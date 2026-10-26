<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('Borrowing_model');
        $this->load->model('Asset_model');
    }

    // Halaman Utama: Daftar Semua Transaksi
    public function index() {
        $data['title'] = 'Data Peminjaman - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $data['transactions'] = $this->Borrowing_model->get_all_transactions();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/transaction/index', $data); // Kita buat view-nya nanti
        $this->load->view('admin/layout/footer');
    }

    // LOGIKA 1: Admin Menyetujui Pengajuan (Approve)
    public function approve($id) {
        // 1. Ubah status transaksi menjadi 'approved' (Disetujui, tapi barang belum diambil)
        $this->Borrowing_model->update_status($id, 'approved');
        
        $this->session->set_flashdata('success_msg', 'Pengajuan disetujui! Karyawan bisa mengambil barangnya sekarang.');
        redirect('transaction');
    }

    // LOGIKA 2: Admin Menolak Pengajuan (Reject)
    public function reject($id) {
        $this->Borrowing_model->update_status($id, 'rejected');
        
        $this->session->set_flashdata('error_msg', 'Pengajuan telah ditolak.');
        redirect('transaction');
    }

    // LOGIKA 3: Serah Terima Fisik Barang (Handover) -> Barang Resmi Dipinjam
    public function handover($id) {
        // 1. Ambil data transaksinya dulu untuk mengetahui ID Asetnya
        $transaksi = $this->Borrowing_model->get_transaction_by_id($id);
        $asset_id = $transaksi['asset_id'];

        // 2. Ubah status transaksi menjadi 'in_use' (Sedang Dipinjam)
        $this->Borrowing_model->update_status($id, 'in_use');

        // 3. PENTING: Ubah status Aset di tabel assets menjadi 'in_use'
        // Ini agar aset tersebut HILANG dari Katalog Karyawan (tidak bisa dipinjam orang lain)
        $this->Asset_model->update($asset_id, ['operational_status' => 'in_use']);

        $this->session->set_flashdata('success_msg', 'Serah terima berhasil! Status barang kini sedang dipinjam.');
        redirect('transaction');
    }

    // LOGIKA 4: Barang Dikembalikan (Return)
    public function return_asset($id) {
        $transaksi = $this->Borrowing_model->get_transaction_by_id($id);
        $asset_id = $transaksi['asset_id'];

        // 1. Ubah status transaksi menjadi 'returned' (Selesai)
        $this->Borrowing_model->update_status($id, 'returned');

        // 2. PENTING: Kembalikan status Aset menjadi 'available'
        // Agar muncul kembali di Katalog Karyawan
        $this->Asset_model->update($asset_id, ['operational_status' => 'available']);

        $this->session->set_flashdata('success_msg', 'Barang berhasil dikembalikan ke inventaris.');
        redirect('transaction');
    }
}