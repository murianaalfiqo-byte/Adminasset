<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

    // Mengambil semua data departemen
    public function get_all() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('departments')->result_array();
    }

    // Menyimpan departemen baru
    public function insert($data) {
        return $this->db->insert('departments', $data);
    }

    // Mengubah departemen yang ada
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('departments', $data);
    }

    // Menghapus departemen
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('departments');
    }
}