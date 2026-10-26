<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowing_model extends CI_Model {

    // Fungsi untuk Karyawan: Mengajukan peminjaman baru
    public function insert($data) {
        return $this->db->insert('borrowings', $data);
    }

    // Fungsi untuk Karyawan: Melihat riwayat peminjamannya sendiri
    public function get_by_user($user_id) {
        $this->db->select('borrowings.*, assets.name as asset_name, assets.asset_code, assets.photo');
        $this->db->from('borrowings');
        $this->db->join('assets', 'borrowings.asset_id = assets.id');
        $this->db->where('borrowings.user_id', $user_id);
        $this->db->order_by('borrowings.id', 'DESC');
        return $this->db->get()->result_array();
    }
    
    // Cek apakah aset sedang diajukan oleh user ini dan statusnya masih pending
    public function check_pending_request($user_id, $asset_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('asset_id', $asset_id);
        $this->db->where_in('status', ['pending', 'approved', 'ready_for_handover']);
        return $this->db->get('borrowings')->num_rows();
    }

    // ADMIN: Mengambil SEMUA riwayat peminjaman beserta nama peminjam dan barangnya
    public function get_all_transactions() {
        $this->db->select('borrowings.*, assets.name as asset_name, assets.asset_code, users.name as user_name');
        $this->db->from('borrowings');
        $this->db->join('assets', 'borrowings.asset_id = assets.id');
        $this->db->join('users', 'borrowings.user_id = users.id');
        $this->db->order_by('borrowings.id', 'DESC');
        return $this->db->get()->result_array();
    }

    // ADMIN: Mengubah status di tabel borrowings (contoh: dari pending jadi approved)
    public function update_status($borrowing_id, $status) {
        $this->db->where('id', $borrowing_id);
        return $this->db->update('borrowings', ['status' => $status]);
    }

    // ADMIN: Mengambil 1 data peminjaman spesifik berdasarkan ID
    public function get_transaction_by_id($id) {
        return $this->db->get_where('borrowings', ['id' => $id])->row_array();
    }// KHUSUS KARYAWAN: Mengambil jumlah statistik peminjaman per user
    public function get_user_stats($user_id) {
        return [
            'in_use'   => $this->db->where('user_id', $user_id)->where('status', 'in_use')->count_all_results('borrowings'),
            'pending'  => $this->db->where('user_id', $user_id)->where('status', 'pending')->count_all_results('borrowings'),
            'ready'    => $this->db->where('user_id', $user_id)->where_in('status', ['approved', 'ready_for_handover'])->count_all_results('borrowings'),
            'returned' => $this->db->where('user_id', $user_id)->where('status', 'returned')->count_all_results('borrowings')
        ];
    }

    // KHUSUS KARYAWAN: Mengambil 5 aktivitas peminjaman terbaru milik user
    public function get_recent_by_user($user_id, $limit = 5) {
        $this->db->select('borrowings.*, assets.name as asset_name, assets.asset_code, assets.photo');
        $this->db->from('borrowings');
        $this->db->join('assets', 'borrowings.asset_id = assets.id');
        $this->db->where('borrowings.user_id', $user_id);
        $this->db->order_by('borrowings.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
}