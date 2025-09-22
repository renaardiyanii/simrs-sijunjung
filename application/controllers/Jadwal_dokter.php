<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_dokter extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('master/Mmjadwal','',TRUE);
		$this->load->model('irj/Rjmpencarian','',TRUE);
	}
	
	function index()
	{	
		$data['jadwal_dokter'] = $this->Mmjadwal->display_jadwal()->result();
		$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
		// print_r(json_encode($data['jadwal_dokter']));die();		
		$this->load->view('jadwal_dokter',$data);		
	}
}

?>