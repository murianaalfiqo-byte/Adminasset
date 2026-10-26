<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('Employee_model');
        $this->load->model('Department_model'); // Dibutuhkan untuk form pilihan departemen
    }

    public function index() {
        $data['title'] = 'Data Karyawan - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $data['employees'] = $this->Employee_model->get_all();
        $data['departments'] = $this->Department_model->get_all(); // Kirim ke View untuk form dropdown

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/employee/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function add() {
        // Enkripsi password default: karyawan123
        $default_password = password_hash('karyawan123', PASSWORD_BCRYPT);

        $data = [
            'employee_code' => $this->input->post('employee_code', TRUE),
            'name'          => $this->input->post('name', TRUE),
            'email'         => $this->input->post('email', TRUE),
            'password_hash' => $default_password,
            'role'          => $this->input->post('role', TRUE),
            'department_id' => $this->input->post('department_id', TRUE),
            'position'      => $this->input->post('position', TRUE),
            'phone'         => $this->input->post('phone', TRUE),
            'is_active'     => 1
        ];

        // Cek apakah email atau kode karyawan sudah dipakai (mencegah duplicate entry error)
        $this->db->where('email', $data['email']);
        $this->db->or_where('employee_code', $data['employee_code']);
        $cek = $this->db->get('users')->num_rows();

        if ($cek > 0) {
            $this->session->set_flashdata('error_msg', 'Gagal! Email atau Kode Karyawan sudah terdaftar.');
        } else {
            $this->Employee_model->insert($data);
            $this->session->set_flashdata('success_msg', 'Karyawan berhasil ditambahkan. Password default: karyawan123');
        }
        redirect('employee');
    }

    public function edit() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'name'          => $this->input->post('name', TRUE),
            'role'          => $this->input->post('role', TRUE),
            'department_id' => $this->input->post('department_id', TRUE),
            'position'      => $this->input->post('position', TRUE),
            'phone'         => $this->input->post('phone', TRUE),
            'is_active'     => $this->input->post('is_active', TRUE)
        ];
        
        $this->Employee_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Data Karyawan berhasil diperbarui!');
        redirect('employee');
    }

    public function delete($id) {
        if (!$this->Employee_model->delete($id)) {
            $this->session->set_flashdata('error_msg', 'Gagal menghapus! Karyawan ini mungkin masih memiliki riwayat peminjaman aset.');
        } else {
            $this->session->set_flashdata('success_msg', 'Karyawan berhasil dihapus!');
        }
        redirect('employee');
    }
}