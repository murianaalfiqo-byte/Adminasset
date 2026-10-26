<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('Asset_model');
        $this->load->model('Category_model');
        $this->load->model('Location_model');
        $this->load->model('Department_model');
    }

    public function index() {
        $data['title']     = 'Data Master Aset - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $keyword = trim($this->input->get('keyword', TRUE));
        $data['keyword'] = $keyword;

        if (!empty($keyword)) {
            $this->db->select('assets.*, categories.name as category_name, locations.name as location_name, departments.name as department_name');
            $this->db->from('assets');
            $this->db->join('categories', 'categories.id = assets.category_id', 'left');
            $this->db->join('locations', 'locations.id = assets.location_id', 'left');
            $this->db->join('departments', 'departments.id = assets.department_id', 'left');
            
            if ($this->db->field_exists('is_archived', 'assets')) {
                $this->db->group_start()
                         ->where('assets.is_archived', 0)
                         ->or_where('assets.is_archived IS NULL', NULL, FALSE)
                         ->group_end();
            }

            $this->db->group_start();
            $this->db->like('assets.name', $keyword);
            $this->db->or_like('assets.asset_code', $keyword);
            $this->db->or_like('assets.brand', $keyword);
            $this->db->or_like('assets.model', $keyword);
            $this->db->or_like('assets.serial_number', $keyword);
            $this->db->or_like('categories.name', $keyword);
            $this->db->or_like('locations.name', $keyword);
            $this->db->group_end();

            $this->db->order_by('assets.id', 'DESC');
            $data['assets'] = $this->db->get()->result_array();
        } else {
            $data['assets'] = $this->Asset_model->get_all();
        }

        $data['categories']  = $this->Category_model->get_all();
        $data['locations']   = $this->Location_model->get_all();
        $data['departments'] = $this->Department_model->get_all();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/layout/topbar', $data);
        $this->load->view('admin/asset/index', $data);
        $this->load->view('admin/layout/footer');
    }

    private function upload_photo() {
        $config['upload_path']   = './assets/img/assets/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 30720;
        $config['file_name']     = 'ASET-' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo')) {
            return $this->upload->data('file_name');
        }
        
        return 'default_asset.png';
    }

    public function add() {
        $quantity = (int) $this->input->post('quantity', TRUE);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $base_code = trim($this->input->post('asset_code', TRUE));

        $photo_name = 'default_asset.png';
        if (!empty($_FILES['photo']['name'])) {
            $photo_name = $this->upload_photo();
        }

        $raw_price = $this->input->post('purchase_price', TRUE);
        $clean_price = preg_replace('/[^0-9]/', '', $raw_price);

        $serial_raw = trim($this->input->post('serial_number', TRUE));
        $base_serial = !empty($serial_raw) ? $serial_raw : NULL;

        $inserted_count = 0;

        for ($i = 0; $i < $quantity; $i++) {
            if ($quantity > 1) {
                if (preg_match('/^(.*?)([0-9]+)$/', $base_code, $matches)) {
                    $prefix  = $matches[1];
                    $number  = intval($matches[2]) + $i;
                    $pad_len = strlen($matches[2]);
                    $asset_code = $prefix . str_pad($number, $pad_len, '0', STR_PAD_LEFT);
                } else {
                    $asset_code = $base_code . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                }
            } else {
                $asset_code = $base_code;
            }

            $cek = $this->db->get_where('assets', ['asset_code' => $asset_code])->num_rows();
            if ($cek > 0) {
                if ($quantity == 1) {
                    $this->session->set_flashdata('error_msg', 'Gagal! Kode Aset (' . $asset_code . ') sudah digunakan.');
                    redirect('asset');
                    return;
                } else {
                    continue;
                }
            }

            $serial_number = ($quantity > 1) ? NULL : $base_serial;

            $data = [
                'asset_code'        => $asset_code,
                'name'              => $this->input->post('name', TRUE),
                'category_id'       => $this->input->post('category_id', TRUE),
                'location_id'       => empty($this->input->post('location_id')) ? NULL : $this->input->post('location_id', TRUE),
                'department_id'     => empty($this->input->post('department_id')) ? NULL : $this->input->post('department_id', TRUE),
                'brand'             => $this->input->post('brand', TRUE),
                'model'             => $this->input->post('model', TRUE),
                'serial_number'     => $serial_number,
                'photo'             => $photo_name,
                'purchase_date'     => empty($this->input->post('purchase_date')) ? NULL : $this->input->post('purchase_date', TRUE),
                'purchase_price'    => empty($clean_price) ? 0 : $clean_price,
                'management_type'   => $this->input->post('management_type', TRUE),
                'condition_status'  => $this->input->post('condition_status', TRUE),
                'operational_status'=> 'available' 
            ];

            $this->Asset_model->insert($data);
            $inserted_count++;
        }

        if ($inserted_count > 0) {
            $this->session->set_flashdata('success_msg', "Berhasil menambahkan $inserted_count unit aset baru!");
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menambahkan aset! Kode aset mungkin sudah digunakan.');
        }

        redirect('asset');
    }

    public function edit() {
        $id = $this->input->post('id', TRUE);
        $asset_lama = $this->Asset_model->get_by_id($id);
        
        $photo_name = $asset_lama['photo'];
        
        if (!empty($_FILES['photo']['name'])) {
            $photo_name = $this->upload_photo();
            if ($asset_lama['photo'] != 'default_asset.png' && file_exists('./assets/img/assets/'.$asset_lama['photo'])) {
                unlink('./assets/img/assets/'.$asset_lama['photo']);
            }
        }

        $raw_price = $this->input->post('purchase_price', TRUE);
        $clean_price = preg_replace('/[^0-9]/', '', $raw_price);

        $serial_raw = trim($this->input->post('serial_number', TRUE));
        $serial_number = !empty($serial_raw) ? $serial_raw : NULL;

        $data = [
            'name'              => $this->input->post('name', TRUE),
            'category_id'       => $this->input->post('category_id', TRUE),
            'location_id'       => empty($this->input->post('location_id')) ? NULL : $this->input->post('location_id', TRUE),
            'department_id'     => empty($this->input->post('department_id')) ? NULL : $this->input->post('department_id', TRUE),
            'brand'             => $this->input->post('brand', TRUE),
            'model'             => $this->input->post('model', TRUE),
            'serial_number'     => $serial_number,
            'photo'             => $photo_name,
            'purchase_date'     => empty($this->input->post('purchase_date')) ? NULL : $this->input->post('purchase_date', TRUE),
            'purchase_price'    => empty($clean_price) ? 0 : $clean_price,
            'management_type'   => $this->input->post('management_type', TRUE),
            'condition_status'  => $this->input->post('condition_status', TRUE)
        ];

        $this->Asset_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Data Aset berhasil diperbarui!');
        redirect('asset');
    }

    public function archive($id) {
        $data = ['is_archived' => 1, 'operational_status' => 'archived'];
        $this->Asset_model->update($id, $data);
        $this->session->set_flashdata('success_msg', 'Aset berhasil diarsipkan.');
        redirect('asset');
    }
}