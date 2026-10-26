<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	// Halaman Riwayat Peminjaman Karyawan
    public function history() {
        $data['title'] = 'Peminjamanku - AssetFlow';
        $data['user_name'] = $this->session->userdata('name');
        
        $user_id = $this->session->userdata('user_id');
        // Kita menggunakan fungsi get_by_user() yang sudah dibuat di Borrowing_model sebelumnya
        $data['borrowings'] = $this->Borrowing_model->get_by_user($user_id);

        $this->load->view('employee/layout/header', $data);
        $this->load->view('employee/layout/navbar', $data);
        $this->load->view('employee/history', $data); // Kita akan buat file ini
        $this->load->view('employee/layout/footer');
    }
}
