<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error_msg', 'Anda tidak memiliki akses ke halaman Admin!');
            redirect('auth');
        }
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');

        $this->db->where('is_archived', 0);
        $data['total_asset'] = $this->db->count_all_results('assets');

        $this->db->where('is_archived', 0);
        $this->db->where('operational_status', 'available');
        $data['asset_available'] = $this->db->count_all_results('assets');

        $this->db->where('is_archived', 0);
        $this->db->where('operational_status', 'in_use');
        $data['asset_borrowed'] = $this->db->count_all_results('assets');

        $this->db->where('is_archived', 0);
        $this->db->where('operational_status', 'maintenance');
        $data['asset_maintenance'] = $this->db->count_all_results('assets');

        $data['kpi'] = [
            'total_assets' => $data['total_asset'],
            'available'    => $data['asset_available'],
            'borrowed'     => $data['asset_borrowed'],
            'maintenance'  => $data['asset_maintenance']
        ];

        $this->db->select('borrowings.*, users.name as user_name, assets.name as asset_name');
        $this->db->from('borrowings');
        $this->db->join('users', 'users.id = borrowings.user_id', 'left');
        $this->db->join('assets', 'assets.id = borrowings.asset_id', 'left');
        $this->db->where('borrowings.status', 'pending');
        $this->db->order_by('borrowings.id', 'DESC');
        $this->db->limit(5);
        $query_pending = $this->db->get();
        
        $data['pending_requests'] = ($query_pending) ? $query_pending->result_array() : [];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/layout/footer');
    }
}