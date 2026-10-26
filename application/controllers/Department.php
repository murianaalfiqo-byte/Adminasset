<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        // Pastikan Anda sudah membuat Department_model.php sebelumnya
        $this->load->model('Department_model');
    }

    // Menampilkan halaman utama departemen
    public function index() {
        $data['title'] = 'Departemen - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        // Ambil data dari model
        $data['departments'] = $this->Department_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/department/index', $data); 
        $this->load->view('admin/layout/footer');
    }

    // Fungsi untuk menambah data
    public function add() {
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE)
            // Di tabel database kita tidak ada is_active untuk departemen, jadi cukup 2 ini
        ];
        $this->Department_model->insert($data);
        $this->session->set_flashdata('success_msg', 'Departemen berhasil ditambahkan!');
        redirect('department');
    }

    // Fungsi untuk mengedit data
    public function edit() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];
        $this->Department_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Departemen berhasil diperbarui!');
        redirect('department');
    }

    // Fungsi untuk menghapus data
    public function delete($id) {
        if (!$this->Department_model->delete($id)) {
            $this->session->set_flashdata('error_msg', 'Gagal! Departemen masih terikat dengan Karyawan atau Aset.');
        } else {
            $this->session->set_flashdata('success_msg', 'Departemen berhasil dihapus!');
        }
        redirect('department');
    }
}