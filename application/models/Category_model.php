<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    // Mengambil semua data kategori
    public function get_all() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('categories')->result_array();
    }

    // Menyimpan kategori baru
    public function insert($data) {
        return $this->db->insert('categories', $data);
    }

    // Mengubah kategori yang ada
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    // Menghapus kategori
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
}