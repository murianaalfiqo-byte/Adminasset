<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Fungsi untuk mengambil data user berdasarkan email yang aktif
    public function get_user_by_email($email) {
        return $this->db->get_where('users', [
            'email' => $email, 
            'is_active' => 1
        ])->row_array();
    }
}