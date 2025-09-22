<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once ("Secure_area.php");
class Emr extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('iri/rimdaftar');
		$this->load->model('iri/rimpasien');
	}
	
	public function index($no_medrec="")
	{
		$data['data_pasien'] = $this->rimdaftar->select_pasien_by_no_medrec($no_medrec);
		$this->load->view('emr/rm001',$data);
	}
	
	public function rm001()
	{
		$this->load->view('emr/rm001',$data);
    }
}