<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model {

    // Mengambil semua data lokasi
    public function get_all() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('locations')->result_array();
    }

    // Menyimpan lokasi baru
    public function insert($data) {
        return $this->db->insert('locations', $data);
    }

    // Mengubah lokasi yang ada
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('locations', $data);
    }

    // Menghapus lokasi
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('locations');
    }
}