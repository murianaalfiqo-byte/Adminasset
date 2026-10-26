<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_based_on_role();
        }
        
        $data['captcha_img'] = $this->create_captcha_image();
        $this->load->view('auth/login', $data);
    }

    public function refresh_captcha() {
        $captcha_img = $this->create_captcha_image();
        echo json_encode(['captcha_img' => $captcha_img]);
    }

    private function create_captcha_image() {
        $code = substr(str_shuffle('0123456789'), 0, 4);
        $this->session->set_userdata('captcha_answer', strtolower($code));

        $image = imagecreatetruecolor(120, 38);
        $bg = imagecolorallocate($image, 245, 247, 250);
        $text_color = imagecolorallocate($image, 15, 23, 42);
        $line_color = imagecolorallocate($image, 148, 163, 184);

        imagefilledrectangle($image, 0, 0, 120, 38, $bg);

        for ($i = 0; $i < 8; $i++) {
            imageline($image, rand(0, 120), rand(0, 38), rand(0, 120), rand(0, 38), $line_color);
        }

        for ($i = 0; $i < strlen($code); $i++) {
            $x = 15 + ($i * 24);
            $y = rand(6, 12);
            imagestring($image, 5, $x, $y, $code[$i], $text_color);
        }

        ob_start();
        imagepng($image);
        $imagedata = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imagedata);
    }

    public function process() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('captcha_input', 'CAPTCHA', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $user_captcha = strtolower(trim($this->input->post('captcha_input', TRUE)));
            $session_captcha = strtolower((string) $this->session->userdata('captcha_answer'));

            if ($user_captcha !== $session_captcha) {
                $this->session->set_flashdata('error_msg', 'Kode CAPTCHA salah! Silakan coba lagi.');
                redirect('auth');
            }

            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->User_model->get_user_by_email($email);

            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    $session_data = [
                        'user_id'   => $user['id'],
                        'email'     => $user['email'],
                        'name'      => $user['name'],
                        'role'      => $user['role'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
                    
                    $this->redirect_based_on_role();
                } else {
                    $this->session->set_flashdata('error_msg', 'Password yang Anda masukkan salah!');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Email tidak terdaftar atau akun nonaktif!');
                redirect('auth');
            }
        }
    }

    private function redirect_based_on_role() {
        if ($this->session->userdata('role') == 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('user_panel'); 
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function forgot_password() {
        $this->load->view('auth/forgot_password');
    }

    public function send_reset_link() {
        $email = $this->input->post('email', TRUE);
        $user  = $this->db->get_where('users', ['email' => $email])->row_array();

        if (!$user) {
            $this->session->set_flashdata('error_msg', 'Email tidak terdaftar dalam sistem.');
            redirect('auth/forgot_password');
        }

        $token = bin2hex(random_bytes(32));
        $this->db->delete('password_resets', ['email' => $email]);
        $this->db->insert('password_resets', [
            'email'      => $email,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $reset_link = site_url('auth/reset_password/' . $token);

        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 465,
            'smtp_user'   => 'email_anda@gmail.com',
            'smtp_pass'   => 'app_password_anda',
            'smtp_crypto' => 'ssl',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->from('no-reply@assetflow.com', 'AssetFlow System');
        $this->email->to($email);
        $this->email->subject('Reset Password Akun AssetFlow');
        $this->email->message('Klik tautan berikut untuk mereset password Anda: <a href="'.$reset_link.'">Reset Password</a>');

        if ($this->email->send()) {
            $this->session->set_flashdata('success_msg', 'Link reset password telah dikirim ke email Anda.');
        } else {
            $this->session->set_flashdata('success_msg', 'Token reset dibuat. Tautan reset: ' . $reset_link);
        }

        redirect('auth/forgot_password');
    }

    public function reset_password($token = NULL) {
        if (!$token) {
            redirect('auth');
        }

        $reset = $this->db->get_where('password_resets', ['token' => $token])->row_array();

        if (!$reset) {
            $this->session->set_flashdata('error_msg', 'Token reset password tidak valid atau sudah kadaluwarsa.');
            redirect('auth');
        }

        $data['token'] = $token;
        $this->load->view('auth/reset_password', $data);
    }

    public function process_reset_password() {
        $token        = $this->input->post('token', TRUE);
        $new_pass     = $this->input->post('new_password', TRUE);
        $confirm_pass = $this->input->post('confirm_password', TRUE);

        $reset = $this->db->get_where('password_resets', ['token' => $token])->row_array();

        if (!$reset) {
            $this->session->set_flashdata('error_msg', 'Sesi reset password tidak valid.');
            redirect('auth');
        }

        if ($new_pass !== $confirm_pass) {
            $this->session->set_flashdata('error_msg', 'Konfirmasi password tidak cocok.');
            redirect('auth/reset_password/' . $token);
        }

        $hash = password_hash($new_pass, PASSWORD_BCRYPT);
        $this->db->where('email', $reset['email'])->update('users', ['password_hash' => $hash]);
        $this->db->delete('password_resets', ['email' => $reset['email']]);

        $this->session->set_flashdata('success_msg', 'Password berhasil diperbarui! Silakan login dengan password baru.');
        redirect('auth');
    }
}