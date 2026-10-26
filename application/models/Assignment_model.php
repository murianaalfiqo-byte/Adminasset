<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_model extends CI_Model {
    public function get_all() {
        $this->db->select('assignments.*, assets.name as asset_name, assets.asset_code, users.name as user_name');
        $this->db->from('assignments');
        $this->db->join('assets', 'assignments.asset_id = assets.id');
        $this->db->join('users', 'assignments.user_id = users.id');
        $this->db->order_by('assignments.id', 'DESC');
        return $this->db->get()->result_array();
    }
    public function insert($data) {
        return $this->db->insert('assignments', $data);
    }
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('assignments', $data);
    }
}