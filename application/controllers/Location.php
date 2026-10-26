<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        // Pastikan Anda sudah membuat Location_model.php sebelumnya
        $this->load->model('Location_model');
    }

    // Menampilkan halaman utama lokasi
    public function index() {
        $data['title'] = 'Lokasi Aset - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        // Ambil data dari model
        $data['locations'] = $this->Location_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/location/index', $data); 
        $this->load->view('admin/layout/footer');
    }

    // Fungsi untuk menambah data
    public function add() {
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'is_active' => 1
        ];
        $this->Location_model->insert($data);
        $this->session->set_flashdata('success_msg', 'Lokasi berhasil ditambahkan!');
        redirect('location');
    }

    // Fungsi untuk mengedit data
    public function edit() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];
        $this->Location_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Lokasi berhasil diperbarui!');
        redirect('location');
    }

    // Fungsi untuk menghapus data
    public function delete($id) {
        if (!$this->Location_model->delete($id)) {
            $this->session->set_flashdata('error_msg', 'Gagal! Lokasi sedang digunakan oleh Aset.');
        } else {
            $this->session->set_flashdata('success_msg', 'Lokasi berhasil dihapus!');
        }
        redirect('location');
    }
}