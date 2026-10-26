<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') redirect('auth');
        
        $this->load->model('Assignment_model');
        $this->load->model('Asset_model');
        $this->load->model('Employee_model');
    }

    public function index() {
        $data['title'] = 'Penugasan Aset - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $data['assignments'] = $this->Assignment_model->get_all();
        $data['employees'] = $this->Employee_model->get_all();
        
        // Hanya ambil aset yang "Tersedia" DAN sifatnya "Ditugaskan" (assignable)
        $this->db->where('operational_status', 'available');
        $this->db->where('management_type', 'assignable');
        $data['assets'] = $this->db->get('assets')->result_array();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/assignment/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function add() {
        $asset_id = $this->input->post('asset_id', TRUE);
        
        $data = [
            'asset_id'      => $asset_id,
            'user_id'       => $this->input->post('user_id', TRUE),
            'assigned_date' => $this->input->post('assigned_date', TRUE),
            'notes'         => $this->input->post('notes', TRUE),
            'status'        => 'assigned'
        ];
        
        $this->Assignment_model->insert($data);
        
        // Ubah status aset menjadi "Ditugaskan"
        $this->Asset_model->update($asset_id, ['operational_status' => 'assigned']);
        
        $this->session->set_flashdata('success_msg', 'Aset berhasil ditugaskan ke karyawan!');
        redirect('assignment');
    }

    public function revoke() {
        $id = $this->input->post('id', TRUE);
        $asset_id = $this->input->post('asset_id', TRUE);
        
        $data = [
            'return_date' => date('Y-m-d'), // Tanggal ditarik (hari ini)
            'status'      => 'returned'
        ];
        
        $this->Assignment_model->update($id, $data);
        
        // Kembalikan status aset jadi Tersedia
        $this->Asset_model->update($asset_id, ['operational_status' => 'available']);
        
        $this->session->set_flashdata('success_msg', 'Aset berhasil ditarik dan kembali ke inventaris!');
        redirect('assignment');
    }
}