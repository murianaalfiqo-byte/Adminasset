<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $this->load->model('Borrowing_model');
    }

    public function index() {
        $data['title']     = 'Riwayat Peminjamanku - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $user_id = $this->session->userdata('user_id');
        $data['borrowings'] = $this->Borrowing_model->get_by_user($user_id);

        // Path disesuaikan dengan folder views/employee/
        $this->load->view('employee/layout/header', $data);
        $this->load->view('employee/layout/navbar', $data); 
        $this->load->view('employee/history', $data);
        $this->load->view('employee/layout/footer');
    }

    public function cancel($id) {
        $user_id   = $this->session->userdata('user_id');
        $borrowing = $this->Borrowing_model->get_transaction_by_id($id);

        if ($borrowing && $borrowing['user_id'] == $user_id && $borrowing['status'] == 'pending') {
            $this->Borrowing_model->update_status($id, 'canceled');
            $this->session->set_flashdata('success_msg', 'Pengajuan peminjaman berhasil dibatalkan.');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal membatalkan pengajuan.');
        }

        redirect('history');
    }
}