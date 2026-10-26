<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_panel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'employee') {
            $this->session->set_flashdata('error_msg', 'Anda tidak memiliki akses ke halaman Karyawan.');
            redirect('auth');
        }
        $this->load->model('Asset_model');
        $this->load->model('Category_model');
        $this->load->model('Borrowing_model');
    }

    // Redirect default ke Dashboard
    public function index() {
        $this->dashboard();
    }

    // Halaman Dashboard Karyawan
    public function dashboard() {
        $data['title']     = 'Dashboard Karyawan - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        $user_id           = $this->session->userdata('user_id');

        $data['stats']             = $this->Borrowing_model->get_user_stats($user_id);
        $data['recent_borrowings'] = $this->Borrowing_model->get_recent_by_user($user_id, 5);

        $this->load->view('employee/layout/header', $data);
        $this->load->view('employee/layout/navbar', $data);
        $this->load->view('employee/dashboard', $data);
        $this->load->view('employee/layout/footer');
    }

    // Halaman Katalog Aset
    public function catalog() {
        $data['title']      = 'Katalog Aset - AssetFlow';
        $data['user_name']  = $this->session->userdata('name');
        
        $data['assets']     = $this->Asset_model->get_available_assets();
        $data['categories'] = $this->Category_model->get_all();

        $this->load->view('employee/layout/header', $data);
        $this->load->view('employee/layout/navbar', $data);
        $this->load->view('employee/catalog', $data);
        $this->load->view('employee/layout/footer');
    }

    // Alias pendukung agar URL user_panel/history tetap berjalan
    public function history() {
        redirect('history');
    }
}