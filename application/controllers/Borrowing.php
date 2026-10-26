<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Borrowing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cek autentikasi login
        if (!$this->session->userdata('role')) {
            $this->session->set_flashdata('error_msg', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
    }

    // Helper internal khusus hak akses admin
    private function _check_admin()
    {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error_msg', 'Anda tidak memiliki hak akses ke halaman ini!');
            redirect('catalog');
        }
    }

    public function index()
    {
        $this->_check_admin();

        $data['title']     = 'Kelola Peminjaman Aset - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');

        $status_filter = $this->input->get('status');

        $this->db->select('borrowings.*, users.name as user_name, users.email as user_email, assets.name as asset_name, assets.asset_code, assets.photo');
        $this->db->from('borrowings');
        $this->db->join('users', 'users.id = borrowings.user_id', 'left');
        $this->db->join('assets', 'assets.id = borrowings.asset_id', 'left');

        if (!empty($status_filter)) {
            $this->db->where('borrowings.status', $status_filter);
        }

        $this->db->order_by('borrowings.id', 'DESC');
        $data['borrowings'] = $this->db->get()->result_array();

        $data['count_pending']  = $this->db->where('status', 'pending')->count_all_results('borrowings');
        $data['count_in_use']   = $this->db->where('status', 'in_use')->count_all_results('borrowings');
        $data['count_returned'] = $this->db->where('status', 'returned')->count_all_results('borrowings');
        $data['count_all']      = $this->db->count_all('borrowings');

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/borrowing/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function request($asset_id = null)
    {
        $redirect_page = ($this->session->userdata('role') === 'admin') ? 'borrowing' : 'catalog';

        if (!$asset_id) {
            $this->session->set_flashdata('error_msg', 'Aset tidak ditemukan!');
            redirect($redirect_page);
        }

        $asset = $this->db->get_where('assets', ['id' => $asset_id])->row_array();
        if (!$asset) {
            $this->session->set_flashdata('error_msg', 'Data aset tidak ditemukan!');
            redirect($redirect_page);
        }

        if ($this->input->post()) {
            $this->store();
            return;
        }

        $data['title']     = 'Form Pengajuan Peminjaman Aset';
        $data['user_name'] = $this->session->userdata('name');
        $data['asset']     = $asset;

        if ($this->session->userdata('role') === 'admin') {
            $this->load->view('admin/layout/header', $data);
            $this->load->view('admin/layout/sidebar', $data);
            $this->load->view('admin/layout/topbar', $data);
            $this->load->view('admin/borrowing/request', $data);
            $this->load->view('admin/layout/footer');
        } else {
            $this->load->view('employee/layout/header', $data);
            $this->load->view('employee/borrowing_form', $data);
            $this->load->view('employee/layout/footer');
        }
    }

    public function store()
    {
        if ($this->input->post()) {
            $asset_id = $this->input->post('asset_id', TRUE);
            $user_id  = $this->session->userdata('user_id') ?: ($this->session->userdata('id') ?: 1);

            $purpose = $this->input->post('purpose', TRUE);
            $reason  = $this->input->post('reason', TRUE);

            // Penanganan fallback otomatis jika input purpose kosong agar tidak terjadi error NULL
            if (empty($purpose) && !empty($reason)) {
                $purpose = $reason;
            } elseif (empty($purpose)) {
                $purpose = '-';
            }

            if (empty($reason)) {
                $reason = $purpose;
            }

            // Konversi tanggal datetime-local ke format MySQL
            $start_at = $this->input->post('requested_start_at', TRUE);
            $end_at   = $this->input->post('requested_end_at', TRUE);

            if ($start_at) {
                $start_at = date('Y-m-d H:i:s', strtotime($start_at));
            }
            if ($end_at) {
                $end_at = date('Y-m-d H:i:s', strtotime($end_at));
            }

            $data_insert = [
                'borrowing_code'     => 'BRW-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4)),
                'asset_id'           => $asset_id,
                'user_id'            => $user_id,
                'requested_start_at' => $start_at,
                'requested_end_at'   => $end_at,
                'purpose'            => $purpose,
                'reason'             => $reason,
                'status'             => 'pending',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('borrowings', $data_insert);
            $this->session->set_flashdata('success_msg', 'Pengajuan peminjaman berhasil dikirim!');

            if ($this->session->userdata('role') === 'admin') {
                redirect('borrowing');
            } else {
                redirect(file_exists(APPPATH . 'controllers/History.php') ? 'history' : 'employee/history');
            }
        } else {
            redirect($this->session->userdata('role') === 'admin' ? 'borrowing' : 'catalog');
        }
    }

    public function approve($id)
    {
        $this->_check_admin();
        $borrowing = $this->db->get_where('borrowings', ['id' => $id])->row_array();

        if ($borrowing) {
            $this->db->where('id', $id);
            $this->db->update('borrowings', [
                'status'     => 'approved',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $this->session->set_flashdata('success_msg', 'Pengajuan peminjaman berhasil disetujui!');
        } else {
            $this->session->set_flashdata('error_msg', 'Data peminjaman tidak ditemukan!');
        }

        redirect('borrowing');
    }

    public function reject($id)
    {
        $this->_check_admin();
        $borrowing = $this->db->get_where('borrowings', ['id' => $id])->row_array();

        if ($borrowing) {
            $this->db->where('id', $id);
            $this->db->update('borrowings', [
                'status'     => 'rejected',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $this->session->set_flashdata('success_msg', 'Pengajuan peminjaman telah ditolak.');
        } else {
            $this->session->set_flashdata('error_msg', 'Data peminjaman tidak ditemukan!');
        }

        redirect('borrowing');
    }

    public function handover($id)
    {
        $this->_check_admin();
        $borrowing = $this->db->get_where('borrowings', ['id' => $id])->row_array();

        if ($borrowing) {
            $this->db->where('id', $id);
            $this->db->update('borrowings', [
                'status'             => 'in_use',
                'actual_handover_at' => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);

            $this->db->where('id', $borrowing['asset_id']);
            $this->db->update('assets', ['operational_status' => 'in_use']);

            $this->session->set_flashdata('success_msg', 'Status barang diperbarui menjadi Sedang Dipinjam!');
        }

        redirect('borrowing');
    }

    public function return_asset($id)
    {
        $this->_check_admin();
        $borrowing = $this->db->get_where('borrowings', ['id' => $id])->row_array();

        if ($borrowing) {
            $this->db->where('id', $id);
            $this->db->update('borrowings', [
                'status'           => 'returned',
                'actual_return_at' => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);

            $this->db->where('id', $borrowing['asset_id']);
            $this->db->update('assets', ['operational_status' => 'available']);

            $this->session->set_flashdata('success_msg', 'Barang berhasil dikembalikan ke inventaris.');
        }

        redirect('borrowing');
    }
}