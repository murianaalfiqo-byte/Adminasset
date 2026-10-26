<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_model extends CI_Model {

    // Mengambil semua data aset yang TIDAK diarsipkan beserta relasinya
    public function get_all() {
        $this->db->select('assets.*, categories.name as category_name, locations.name as location_name, departments.name as department_name');
        $this->db->from('assets');
        $this->db->join('categories', 'assets.category_id = categories.id', 'left');
        $this->db->join('locations', 'assets.location_id = locations.id', 'left');
        $this->db->join('departments', 'assets.department_id = departments.id', 'left');
        $this->db->where('assets.is_archived', 0); // Hanya tampilkan yang tidak diarsipkan
        $this->db->order_by('assets.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        return $this->db->insert('assets', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('assets', $data);
    }

    // Mendapatkan 1 data aset (digunakan saat mau menghapus foto lama)
    public function get_by_id($id) {
        return $this->db->get_where('assets', ['id' => $id])->row_array();
    }

    // KHUSUS KARYAWAN: Mengambil aset yang siap dipinjam
    public function get_available_assets() {
        $this->db->select('assets.*, categories.name as category_name, locations.name as location_name');
        $this->db->from('assets');
        $this->db->join('categories', 'assets.category_id = categories.id', 'left');
        $this->db->join('locations', 'assets.location_id = locations.id', 'left');
        $this->db->where('assets.is_archived', 0);
        $this->db->where('assets.operational_status', 'available'); // Harus tersedia
        $this->db->where('assets.management_type', 'borrowable');   // Sifatnya boleh dipinjam sementara
        $this->db->order_by('assets.name', 'ASC');
        return $this->db->get()->result_array();
    }
}