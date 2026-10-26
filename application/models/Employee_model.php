<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    // Mengambil semua data user/karyawan beserta nama departemennya
    public function get_all() {
        $this->db->select('users.*, departments.name as department_name');
        $this->db->from('users');
        $this->db->join('departments', 'users.department_id = departments.id', 'left');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}