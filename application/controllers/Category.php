<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('Category_model');
    }

    // Menampilkan halaman utama kategori
    public function index() {
        $data['title'] = 'Kategori Aset - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        // Ambil data dari model
        $data['categories'] = $this->Category_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/category/index', $data); // Kita akan buat file ini
        $this->load->view('admin/layout/footer');
    }

    // Fungsi untuk menambah data
    public function add() {
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'is_active' => 1
        ];
        $this->Category_model->insert($data);
        $this->session->set_flashdata('success_msg', 'Kategori berhasil ditambahkan!');
        redirect('category');
    }

    // Fungsi untuk mengedit data
    public function edit() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];
        $this->Category_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Kategori berhasil diperbarui!');
        redirect('category');
    }

    // Fungsi untuk menghapus data
    public function delete($id) {
        // Pengecekan error database (agar tidak error jika kategori masih dipakai di tabel aset)
        if (!$this->Category_model->delete($id)) {
            $this->session->set_flashdata('error_msg', 'Gagal! Kategori sedang digunakan oleh Aset.');
        } else {
            $this->session->set_flashdata('success_msg', 'Kategori berhasil dihapus!');
        }
        redirect('category');
    }
}