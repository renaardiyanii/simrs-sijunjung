<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
	}
	
	public function index()
	{
		$this->M_user->logout();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda sudah keluar dari sistem ! </div>');
		redirect('index');
	}
}

?>
