<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') redirect('auth');
        $this->load->model('Maintenance_model');
        $this->load->model('Asset_model');
    }

    public function index() {
        $data['title'] = 'Maintenance Aset';
        $data['user_name'] = $this->session->userdata('name');
        
        $data['maintenances'] = $this->Maintenance_model->get_all();
        
        // Hanya tampilkan aset yang statusnya 'available' (Bisa diservis)
        $this->db->where('operational_status', 'available');
        $data['assets'] = $this->db->get('assets')->result_array();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/maintenance/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function add() {
        $asset_id = $this->input->post('asset_id', TRUE);
        $data = [
            'asset_id' => $asset_id,
            'problem_description' => $this->input->post('problem_description', TRUE),
            'start_date' => $this->input->post('start_date', TRUE),
            'status' => 'ongoing'
        ];
        
        $this->Maintenance_model->insert($data);
        
        // Ubah status aset jadi Maintenance (Agar hilang dari katalog karyawan)
        $this->Asset_model->update($asset_id, ['operational_status' => 'maintenance', 'condition_status' => 'damaged']);
        
        $this->session->set_flashdata('success_msg', 'Aset berhasil dimasukkan ke daftar perbaikan!');
        redirect('maintenance');
    }

    public function complete() {
        $id = $this->input->post('id', TRUE);
        $asset_id = $this->input->post('asset_id', TRUE);
        
        $data = [
            'end_date' => date('Y-m-d'), // Hari ini
            'cost' => str_replace('.', '', $this->input->post('cost', TRUE)),
            'status' => 'completed'
        ];
        
        $this->Maintenance_model->update($id, $data);
        
        // Kembalikan status aset jadi Bagus & Tersedia lagi
        $this->Asset_model->update($asset_id, ['operational_status' => 'available', 'condition_status' => 'good']);
        
        $this->session->set_flashdata('success_msg', 'Perbaikan Selesai! Aset sudah kembali ke inventaris.');
        redirect('maintenance');
    }
}