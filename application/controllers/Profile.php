<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index() {
        $user_id           = $this->session->userdata('user_id');
        $data['title']     = 'Profil Saya - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $this->db->select('users.*, departments.name as department_name');
        $this->db->from('users');
        $this->db->join('departments', 'departments.id = users.department_id', 'left');
        $this->db->where('users.id', $user_id);
        $data['user'] = $this->db->get()->row_array();

        $this->load->view('employee/layout/header', $data);
        $this->load->view('employee/layout/navbar', $data);
        $this->load->view('employee/profile', $data);
        $this->load->view('employee/layout/footer');
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        $data = [
            'name'  => $this->input->post('name', TRUE),
            'phone' => $this->input->post('phone', TRUE)
        ];

        $this->db->where('id', $user_id)->update('users', $data);
        $this->session->set_userdata('name', $data['name']);
        $this->session->set_flashdata('success_msg', 'Profil berhasil diperbarui!');
        redirect('profile');
    }

    public function change_password() {
        $user_id      = $this->session->userdata('user_id');
        $old_pass     = $this->input->post('old_password', TRUE);
        $new_pass     = $this->input->post('new_password', TRUE);
        $confirm_pass = $this->input->post('confirm_password', TRUE);

        $user = $this->db->get_where('users', ['id' => $user_id])->row_array();

        if (!password_verify($old_pass, $user['password_hash'])) {
            $this->session->set_flashdata('error_msg', 'Password lama Anda salah!');
            redirect('profile');
        }

        if ($new_pass !== $confirm_pass) {
            $this->session->set_flashdata('error_msg', 'Konfirmasi password baru tidak cocok!');
            redirect('profile');
        }

        if (strlen($new_pass) < 6) {
            $this->session->set_flashdata('error_msg', 'Password baru minimal 6 karakter!');
            redirect('profile');
        }

        $hash = password_hash($new_pass, PASSWORD_BCRYPT);
        $this->db->where('id', $user_id)->update('users', ['password_hash' => $hash]);
        
        $this->session->set_flashdata('success_msg', 'Password berhasil diubah!');
        redirect('profile');
    }
}