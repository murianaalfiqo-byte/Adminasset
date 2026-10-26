<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') redirect('auth');
    }

    public function index() {
        $data['title'] = 'Pengaturan Akun - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        // Ambil data admin dari session ID
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row_array();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/setting/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', ['id' => $user_id])->row_array();
        
        $old_password = $this->input->post('old_password', TRUE);
        $new_password = $this->input->post('new_password', TRUE);
        
        // Verifikasi password lama
        if (password_verify($old_password, $user['password_hash'])) {
            // Hash password baru
            $new_hash = password_hash($new_password, PASSWORD_BCRYPT);
            $this->db->update('users', ['password_hash' => $new_hash], ['id' => $user_id]);
            
            $this->session->set_flashdata('success_msg', 'Keamanan: Password berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal: Password lama yang Anda masukkan salah!');
        }
        redirect('setting');
    }
}