<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error_msg', 'Anda tidak memiliki akses ke halaman ini!');
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Laporan & Analitik - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');

        // 1. Ambil Seluruh Data Aset Aktif
        if ($this->db->field_exists('is_archived', 'assets')) {
            $this->db->group_start()
                     ->where('is_archived', 0)
                     ->or_where('is_archived IS NULL', NULL, FALSE)
                     ->group_end();
        }
        $assets = $this->db->get('assets')->result_array();

        // 2. Kalkulasi Total Investasi Aset (Mencakup purchase_price, price, harga_beli, dll)
        $total_investment = 0;
        foreach ($assets as $asset) {
            $val = 0;
            if (isset($asset['purchase_price']) && $asset['purchase_price'] > 0) {
                $val = $asset['purchase_price'];
            } elseif (isset($asset['price']) && $asset['price'] > 0) {
                $val = $asset['price'];
            } elseif (isset($asset['harga_beli']) && $asset['harga_beli'] > 0) {
                $val = $asset['harga_beli'];
            } elseif (isset($asset['harga']) && $asset['harga'] > 0) {
                $val = $asset['harga'];
            }

            // Bersihkan string dari karakter non-angka
            $clean_val = preg_replace('/[^0-9]/', '', (string)$val);
            if (!empty($clean_val)) {
                $total_investment += floatval($clean_val);
            }
        }
        $data['total_investment'] = $total_investment;

        // 3. Deteksi Aset yang Sedang Diservis / Maintenance
        $active_maintenance_ids = [];
        $m_table = $this->db->table_exists('maintenances') ? 'maintenances' : ($this->db->table_exists('maintenance') ? 'maintenance' : null);
        
        if ($m_table) {
            $this->db->select('asset_id');
            if ($this->db->field_exists('status', $m_table)) {
                $this->db->where_in('LOWER(status)', ['sedang diservis', 'diservis', 'pending', 'in_progress', 'proses']);
            }
            $m_query = $this->db->get($m_table)->result_array();
            foreach ($m_query as $mq) {
                if (!empty($mq['asset_id'])) {
                    $active_maintenance_ids[] = $mq['asset_id'];
                }
            }
        }

        // 4. Deteksi Nama Kolom Kondisi Fisik
        $fields = $this->db->list_fields('assets');
        $cond_field = null;
        foreach (['condition_status', 'condition', 'kondisi', 'status_kondisi', 'item_condition'] as $f) {
            if (in_array($f, $fields)) {
                $cond_field = $f;
                break;
            }
        }

        // 5. Kalkulasi Sinkronisasi Kondisi Fisik
        $condition_counts = [
            'bagus'  => 0,
            'layak'  => 0,
            'rusak'  => 0,
            'hilang' => 0
        ];

        foreach ($assets as $asset) {
            $asset_id  = $asset['id'] ?? null;
            $op_status = strtolower(trim($asset['operational_status'] ?? ''));
            $cond_val  = $cond_field ? strtolower(trim($asset[$cond_field] ?? '')) : '';

            if (($asset_id && in_array($asset_id, $active_maintenance_ids)) || $op_status === 'maintenance' || in_array($cond_val, ['rusak', 'poor', 'bad', 'broken', 'rusak ringan', 'rusak berat'])) {
                $condition_counts['rusak']++;
            } elseif (in_array($cond_val, ['layak', 'fair', 'layak pakai', 'sedang'])) {
                $condition_counts['layak']++;
            } elseif (in_array($cond_val, ['hilang', 'lost', 'missing']) || $op_status === 'lost') {
                $condition_counts['hilang']++;
            } else {
                $condition_counts['bagus']++;
            }
        }

        $data['condition'] = $condition_counts;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/report/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function print_assets() {
        $this->db->select('assets.*, categories.name as category_name, locations.name as location_name');
        $this->db->from('assets');
        $this->db->join('categories', 'categories.id = assets.category_id', 'left');
        $this->db->join('locations', 'locations.id = assets.location_id', 'left');
        if ($this->db->field_exists('is_archived', 'assets')) {
            $this->db->group_start()
                     ->where('assets.is_archived', 0)
                     ->or_where('assets.is_archived IS NULL', NULL, FALSE)
                     ->group_end();
        }
        $this->db->order_by('assets.id', 'DESC');
        $data['assets'] = $this->db->get()->result_array();
        $data['company_name'] = 'PT Indo Techno Medic';

        $this->load->view('admin/report/print_assets', $data);
    }

    public function print_transactions() {
        $data['title'] = 'Cetak Laporan Transaksi - AssetFlow';
        
        $this->db->select('borrowings.*, users.name as user_name, assets.name as asset_name, assets.asset_code');
        $this->db->from('borrowings');
        $this->db->join('users', 'users.id = borrowings.user_id', 'left');
        $this->db->join('assets', 'assets.id = borrowings.asset_id', 'left');
        $this->db->order_by('borrowings.id', 'DESC');
        
        $query = $this->db->get();
        $data['borrowings'] = $query ? $query->result_array() : [];
        $data['company_name'] = 'PT Indo Techno Medic';

        $this->load->view('admin/report/print_transactions', $data);
    }
}