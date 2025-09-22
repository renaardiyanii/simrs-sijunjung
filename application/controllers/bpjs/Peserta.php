<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');


class Peserta extends Secure_area {

	public function __construct(){
	    parent::__construct();	    
	    $this->load->model('bpjs/Mbpjs','',TRUE);
	    $this->load->model('bpjs/Mpasien','',TRUE);	    
	    $this->load->library('vclaim');
	}

	public function get_timestamp()
	{
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;
        $url = $data_bpjs->service_url;
        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);		
		$http_header = array(
			   'Accept: application/json',
			   'Content-type: application/json',
			   'X-cons-id: ' . $cons_id,
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);		
		echo $encoded_signature;
		echo $timestamp;
	}

	public function nik() 
	{		
		$no_nik = $this->input->post('no_nik');		
		$tgl_pelayanan = date('Y-m-d');
		$param = 'Peserta/nik/'.$no_nik.'/'.'tglSEP/'.$tgl_pelayanan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			echo $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);
		}
	}

	public function no_kartu() 
	{
		$no_bpjs = $this->input->post('no_bpjs');		
		$tgl_pelayanan = date('Y-m-d');
		$param = 'Peserta/nokartu/'.$no_bpjs.'/'.'tglSEP/'.$tgl_pelayanan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			echo $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);
		}		
	}

	public function no_rujukan() 
	{
		$no_rujukan = $this->input->post('no_rujukan');
		$cara_kunjungan = $this->input->post('cara_kunjungan');
		if ($cara_kunjungan == 'RUJUKAN RS') {
			$param = 'Rujukan/RS/'.$no_rujukan;
			$content_type = 'application/json';
			$result = $this->vclaim->get($param,$content_type);			
		} else {
			$param = 'Rujukan/'.$no_rujukan;
			$content_type = 'application/json';
			$result = $this->vclaim->get($param,$content_type);			
		}
		if ($result) {
			echo $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);
		}				
	}

}
?>
