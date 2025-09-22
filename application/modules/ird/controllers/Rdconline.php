<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
include('Rdcterbilang.php');
class Rdconline extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/online/rdmdaftar','',TRUE);
		$this->load->model('ird/rdmpencarian','',TRUE);
		$this->load->model('ird/rdmregistrasi','',TRUE);
		$this->load->model('ird/rdmpelayanan','',TRUE);
		$this->load->model('ird/rdmkwitansi','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('ird/M_update_sepbpjs','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('lab/labmdaftar','',TRUE);
	}

	public function index()
	{
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		//rolenya 32

		$date=$this->input->post('date');
		$key=$this->input->post('key');
		if(!empty($date)){
			$data['title'] = 'DAFTAR PASIEN ONLINE Tanggal '.date('d-m-Y',strtotime($date));
			// $data['list']=$this->rjmdaftar->get_daftar_pasien_by_date($date)->result();
			$ch = curl_init('http://103.41.205.13/rsmmcapi/api/daful_date/'.date('Y-m-d',strtotime($date)));
		}else if(!empty($key)){
			$data['title'] = 'DAFTAR PASIEN ONLINE dengan No RM : '.$key;
			// $data['list']=$this->rjmdaftar->get_daftar_pasien_by_no($key)->result();
			$ch = curl_init('http://103.41.205.13/rsmmcapi/api/daful_rm/'.$key);
		}else{
			$data['title'] = 'DAFTAR PASIEN ONLINE Tanggal '.date('d-m-Y');
			// $data['list']=$this->rjmdaftar->get_daftar_pasien_by_date(date('Y-m-d'))->result();
			$ch = curl_init('http://103.41.205.13/rsmmcapi/api/daful_date/'.date('Y-m-d'));
		}
		
		$http_header = array(
			   'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImNlZmZjMjMyMTA5YWY2NDIwNDViNmE0YzZjZWY0ZWRkNjQyZjQzYTJjZWE5YWM2MzgxMDQ1ZjI5NjU5ZmE1OTFiM2M1Zjg4YWM5OGE0OWU1In0.eyJhdWQiOiIzIiwianRpIjoiY2VmZmMyMzIxMDlhZjY0MjA0NWI2YTRjNmNlZjRlZGQ2NDJmNDNhMmNlYTlhYzYzODEwNDVmMjk2NTlmYTU5MWIzYzVmODhhYzk4YTQ5ZTUiLCJpYXQiOjE1MzExMDcwOTIsIm5iZiI6MTUzMTEwNzA5MiwiZXhwIjoxNTYyNjQzMDkyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.PKurqaMA_RWoILkwaIxkyckJMFXswV3bHJkiL3XDTLsp_MukheKtd05nTxDl-eFueqmLVE-X6MsYTxZOfx14km8GYucpqHy-k9B84Dl0yUySOYAF5xPz6Po3jjSLASpCXjycsliC0Jr0eQp2UiDuLXTQE-FR4D9MzfbXqKM2QOVwI3oAhBeqlPI-DQVji2W3Xe2xSzskvxM-NuxPZfl5qUVEBxApodouU1U1Dnx8vhvkERJ7yX8rgba1WkrfnLelIDXauA-zkWZY-HZCISCEi-InEhEk99xYpCjgab09Rb8TETu6GtAK_DhOZOqtEpvIHY5JheVPZHfE9JbpueJG_PBkgpR_71AkwPxnuoQHfdGI5PsamUanoucKLssHrU5wQpwGhnuu0LW-_9ih0S22zRCQIZ7ZpO9S-py5xCYEVbPeBWSk6ThLPs-1XsaGAQubY7OVSKVAsdJSIp3wrqkUPbDZdxNYAD8RVXdMUBzDqN5P5GVWDZPPE4--9QId7lRWyRr2_EG7Ma_19vrq_cb9EES3v8DE-nbPBX1DEwQQWPR63nyqKZBZOpz0aTEr7wd6I7QSfuRCMtcgAFUKCMEywOZ6tiMhu4YSn_z1ofUeIrbtDDYSBmk612k29ZtUABtcrlq6IcAWVX_PeRqmNU0RtMgp6TEvBqnBWjCCS_7rimM', 
			   'Content-Type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . 'application/json'
		);

		// $ch = curl_init('http://117.102.69.53/rsal_mintohardjo/api/daful_date/'.$date_now);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);


		$data['list'] = $result;
		// print_r(json_decode($result));
		$this->load->view('ird/online/list',$data);
	}


	public function get_data_online($id=''){
		$data['id_poli_temp']="";
		$data['cara_bayar_temp']="";

		$http_header = array(
			   'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImNlZmZjMjMyMTA5YWY2NDIwNDViNmE0YzZjZWY0ZWRkNjQyZjQzYTJjZWE5YWM2MzgxMDQ1ZjI5NjU5ZmE1OTFiM2M1Zjg4YWM5OGE0OWU1In0.eyJhdWQiOiIzIiwianRpIjoiY2VmZmMyMzIxMDlhZjY0MjA0NWI2YTRjNmNlZjRlZGQ2NDJmNDNhMmNlYTlhYzYzODEwNDVmMjk2NTlmYTU5MWIzYzVmODhhYzk4YTQ5ZTUiLCJpYXQiOjE1MzExMDcwOTIsIm5iZiI6MTUzMTEwNzA5MiwiZXhwIjoxNTYyNjQzMDkyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.PKurqaMA_RWoILkwaIxkyckJMFXswV3bHJkiL3XDTLsp_MukheKtd05nTxDl-eFueqmLVE-X6MsYTxZOfx14km8GYucpqHy-k9B84Dl0yUySOYAF5xPz6Po3jjSLASpCXjycsliC0Jr0eQp2UiDuLXTQE-FR4D9MzfbXqKM2QOVwI3oAhBeqlPI-DQVji2W3Xe2xSzskvxM-NuxPZfl5qUVEBxApodouU1U1Dnx8vhvkERJ7yX8rgba1WkrfnLelIDXauA-zkWZY-HZCISCEi-InEhEk99xYpCjgab09Rb8TETu6GtAK_DhOZOqtEpvIHY5JheVPZHfE9JbpueJG_PBkgpR_71AkwPxnuoQHfdGI5PsamUanoucKLssHrU5wQpwGhnuu0LW-_9ih0S22zRCQIZ7ZpO9S-py5xCYEVbPeBWSk6ThLPs-1XsaGAQubY7OVSKVAsdJSIp3wrqkUPbDZdxNYAD8RVXdMUBzDqN5P5GVWDZPPE4--9QId7lRWyRr2_EG7Ma_19vrq_cb9EES3v8DE-nbPBX1DEwQQWPR63nyqKZBZOpz0aTEr7wd6I7QSfuRCMtcgAFUKCMEywOZ6tiMhu4YSn_z1ofUeIrbtDDYSBmk612k29ZtUABtcrlq6IcAWVX_PeRqmNU0RtMgp6TEvBqnBWjCCS_7rimM', 
			   'Content-Type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . 'application/json'
		);

		$ch = curl_init('http://103.41.205.13/rsmmcapi/api/daful_id/'.$id);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		// print_r($result);
		curl_close($ch);

		$from_api = json_decode($result)->response;
		// print_r($from_api);
		$data['id_poli_temp']=$from_api[0]->id_poli;
		$data['cara_bayar_temp']=$from_api[0]->cara_bayar;
		$data['no_rujukan_temp']=$from_api[0]->no_rujukan;
		$data['tgl_berobat_temp']=$from_api[0]->tgl_berobat;

		echo json_encode($data);
	}
}
