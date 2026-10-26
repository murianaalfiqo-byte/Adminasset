<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance_model extends CI_Model {
    
    public function get_all() {
        // Menggunakan tabel maintenance_records sesuai database Anda
        $this->db->select('maintenance_records.*, assets.name as asset_name, assets.asset_code');
        $this->db->from('maintenance_records');
        $this->db->join('assets', 'maintenance_records.asset_id = assets.id');
        $this->db->order_by('maintenance_records.id', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function insert($data) {
        return $this->db->insert('maintenance_records', $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('maintenance_records', $data);
    }
}