<?php
defined('BASEPATH') or exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
include('Rjcterbilang.php');

use GuzzleHttp\Client;

class Rjcregistrasi extends Secure_area
{
	//class rjcregistrasi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('irj/rjmpencarian', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('irj/rjmkwitansi', '', TRUE);
		$this->load->model('rad/radmdaftar', '', TRUE);
		$this->load->model('admin/M_user', '', TRUE);
		$this->load->model('irj/M_update_sepbpjs', '', TRUE);
		$this->load->model('bpjs/Mbpjs', '', TRUE);
		$this->load->model('emedrec/M_emedrec', '', TRUE);
		$this->load->model('ird/rdmregistrasi', '', TRUE);
		// $this->load->helper('pdf_helper');
		// $this->load->helper('bpjs');
		$this->load->helper('tgl_indo');
		$this->load->model('admin/appconfig', '', TRUE);
		// $this->load->('bpjs/sep','',TRUE);
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		// $this->endpoint = 'http://192.168.1.139:8000/';
		$this->endpoint = 'http://localhost:8000/';

		// $this->load->constant();		
	}

	function generate_token()
	{
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . 'token',
				[
					'headers' => [
						'username' => 'admin',
						'userid' => '1'
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		$response = json_decode($response);
		if ($response->metadata->code == 200) {
			$this->token = $response->response->token;
		}
	}

	private function gen_token()
	{
		try {
			$response = $this->clients->request(
				'GET',
				'http://192.168.112.121:9810/api/v1/mobile/' . 'token',
				[
					'headers' => [
						'username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ==',
						'password' => 'WGNnbkJmWDhBbW9sT2JLcGNLdEpjZz09'
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		$response = json_decode($response);
		if ($response->metadata->code == 200) {
			return $response->response->token;
			// var_dump($this->token);die();
		}
		return null;
	}

	public function checkinpasienonline($noreservasi, $nocm)
	{
		header('Content-Type: application/json; charset=utf-8');
		try {
			$token = $this->gen_token();
			if($token){
				$response = $this->clients->request(
					'POST',
					'http://192.168.112.121:9810/api/v1/mobile/' . "daftarulang/cekin/$noreservasi/$nocm",
					[
						'headers' => [
							'x-token' => $token,
							'x-username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ=='
						]
					]
				)->getBody()->getContents();
			}
		} catch (Exception $e) {
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		//	var_dump(NAMA_RS);die();
		$data['title'] = 'Registrasi Pasien';
		$data['data_pasien'] =  "";
		$data['kontraktor'] = $this->radmdaftar->get_kontraktor_kerjasama()->result();
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
		$dataregister = $this->input->post('cari_no_cm');
		if ($dataregister != null) {
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		} else {
			$data['data_registrasi'] = array();
		}
		$this->console_log($data['data_registrasi']);
		$this->load->view('irj/rjvformcaripasien', $data);
	}

	public function get_timestamp($no_register = '')
	{
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
		$url = $data_bpjs->service_url;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			'Accept: application/json',
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: ' . $cons_id,
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		echo $encoded_signature;
		echo $timestamp;
	}

	public function get_wilayah_baru()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_wilayah_baru()->result());
	}

	public function data_wilayah()
	{
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')->limit(10, 0)->get()->result();

		//print_r($data);die();	

		foreach ($data as $row) {
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> ($row->id),
				'nm_kelurahan'	=> $row->nama
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function get_wilayah()
	{
		$json = [];

		$this->load->database();

		// $query = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')
		// ->like('initcap(kotakabupaten.nama)',$this->input->get("q"))
		// ->or_like('initcap(kecamatan.nama)',$this->input->get("q"))
		// ->or_like('initcap(kelurahandesa.nama)',$this->input->get("q"))
		// ->select('provinsi.id as id_provinsi,kotakabupaten.id as id_kota,kecamatan.id as id_kecamatan,kelurahandesa.id as id_kelurahan,provinsi.nama as nm_provinsi,kotakabupaten.nama as nm_kota,kecamatan.nama as nm_kecamatan,kelurahandesa.nama as nm_kelurahan')->limit(50, 0)->get();	
		// $json = $query->result();

		$query = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')
			->like('kotakabupaten.nama', strtoupper($this->input->get("q")))
			->or_like('kecamatan.nama', strtoupper($this->input->get("q")))
			->or_like('kelurahandesa.nama', strtoupper($this->input->get("q")))
			->select('provinsi.id as id_provinsi,kotakabupaten.id as id_kota,kecamatan.id as id_kecamatan,kelurahandesa.id as id_kelurahan,provinsi.nama as nm_provinsi,kotakabupaten.nama as nm_kota,kecamatan.nama as nm_kecamatan,kelurahandesa.nama as nm_kelurahan')->limit(50, 0)->get();
		$json = $query->result();


		echo json_encode($json);
	}

	public function regpasienantrol()
	{
		$data['id'] = $this->input->get('id');
		$data['loket'] = $this->input->get('loket');
		$data['title'] = 'Pendaftaran Pasien Baru';
		$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
		$data['prop'] = $this->rjmpencarian->get_prop()->result();

		$data['pekerjaan'] = $this->rjmpencarian->get_pekerjaan()->result();
		$data['master_sukubangsa'] = $this->rjmpencarian->get_sukubangsa()->result();
		$data['last_mr']=$this->rjmpencarian->get_last_cmpatria()->row()->no_cm;
		$data['last_mr'] += 1;

		$this->load->view('irj/rjvformdaftarantrol2', $data);
	}

	public function panggilantrianadmisi(){
		$data['id'] = $this->input->get('id');
		$data['loket'] = $this->input->get('loket');
		// update flag = 2, loket = $loket -> antrian_admisi
		$data['antrian_admisi'] = $this->clients->get(
			$this->endpoint .'adminantrian/v2/updateflagantrian/'.$data['id'].'/2/'.$data['loket']
		)->getBody()->getContents();
		echo json_encode(['ok']);
	}

	public function regpasien()
	{
		$data['title'] = 'Pendaftaran Pasien Baru';
		$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
		$data['prop'] = $this->rjmpencarian->get_prop()->result();

		$data['pekerjaan'] = $this->rjmpencarian->get_pekerjaan()->result();
		$data['master_sukubangsa'] = $this->rjmpencarian->get_sukubangsa()->result();
		
		// cek jika ada antrol -> maka update task id ke 2 
		if($this->input->get('patient')){
			$request = json_decode(base64_decode($this->input->get('patient')));
			$data['request'] = $request;
			// disini trigger flag 2
			
			$data['response_bpjs'] = $this->clients->get(
				$this->endpoint .'adminantrian/prosesantrian/'.$request->kodebooking.'/2'
			)->getBody()->getContents();
			// $data['response_bpjs'] = '{"metadata":{"message":"Ok","code":200}}';
			$data['response_bpjs'] = json_decode($data['response_bpjs']);
			
			return $this->load->view('irj/rjvformdaftarantrol',$data);
		}

		// add sjj 20204
		$data['last_mr']=$this->rjmpencarian->get_last_cmpatria()->row()->no_cm;
		$data['last_mr'] += 1;

		$this->load->view('irj/rjvformdaftar', $data);
	}


	public function show_keluarga($no_cm_pasien = '')
	{
		$result = $this->rjmregistrasi->show_keluarga($no_cm_pasien)->row();
		//$data['mrnrp']=$this->rjmpencarian->get_hubungan()->result();
		echo json_encode($result);
	}

	public function generate_rm()
	{
		$no_medrec = $this->input->post('no_medrec');
		$no_cm = $this->input->post('no_cm');
		$tgldaftar = date("Y-m-d H:i:s");
		$data_update = array(
			'no_cm_lama' => $no_cm,
			'tgl_daftar' => $tgldaftar
		);
		$result = $this->rjmregistrasi->generate_rm($no_medrec, $data_update);
		echo json_encode($result);
	}

	public function get_rm()
	{
		$no_medrec = $this->input->post('no_medrec');
		$result = $this->rjmregistrasi->get_rm($no_medrec)->row();
		echo json_encode($result);
	}

	public function save_keluarga()
	{
		$no_cm_pasien = $this->input->post('no_cm_pasien');
		$if_exist = $this->rjmregistrasi->show_keluarga($no_cm_pasien)->row();
		$data_save = array(
			'nik' => $this->input->post('keluarga_nik'),
			'nama' => $this->input->post('keluarga_nama'),
			'hubungan' => $this->input->post('keluarga_hubungan'),
			'no_nrp' => $this->input->post('keluarga_nrp'),
			'tgl_lahir' => $this->input->post('keluarga_tgl_lahir'),
			'alamat' => $this->input->post('keluarga_alamat'),
			'telp' => $this->input->post('keluarga_telp'),
			'agama' => $this->input->post('keluarga_agama'),
			'pendidikan' => $this->input->post('keluarga_pendidikan'),
			'pekerjaan' => $this->input->post('keluarga_pekerjaan'),
			'pangkat' => $this->input->post('keluarga_pangkat'),
			'alamat_kantor' => $this->input->post('keluarga_alamat_kantor'),
			'telp_kantor' => $this->input->post('keluarga_telp_kantor'),
			'jabatan' => $this->input->post('keluarga_jabatan'),
			'kesatuan' => $this->input->post('keluarga_kesatuan'),
			'alamat_kesatuan' => $this->input->post('keluarga_alamat_kesatuan'),
			'telp_kesatuan' => $this->input->post('keluarga_telp_kesatuan'),
			'no_cm_pasien' => $no_cm_pasien
		);
		$result = '';
		if (empty($if_exist)) {
			$result = $this->rjmregistrasi->insert_keluarga($data_save);
		} else {
			$result = $this->rjmregistrasi->update_keluarga($no_cm_pasien, $data_save);
		}
		echo json_encode($result);
	}

	public function data_keluarga()
	{
		$data_keluarga = $this->rjmregistrasi->getdata_keluarga();
		$data = array();
		$no = $_POST['start'];
		foreach ($data_keluarga as $keluarga) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $keluarga->no_cm;
			switch ($keluarga->nrp_sbg) {
				case 'T':
					$row[] = 'Tenaga Kerja';
					break;
				case '1':
					$row[] = 'Orang Tua';
					break;
				case '2':
					$row[] = 'Suami';
					break;
				case '3':
					$row[] = 'Istri';
					break;
				case '4':
					$row[] = 'Anak Ke-1';
					break;
				case '5':
					$row[] = 'Anak Ke-2';
					break;
				case '6':
					$row[] = 'Anak Ke-3';
					break;
				case '7':
					$row[] = 'Anak Ke-4';
					break;
				case '8':
					$row[] = 'Anak Ke-5';
					break;
			}
			$row[] = $keluarga->nama;
			$row[] = $keluarga->alamat;
			$row[] = $keluarga->no_telp;
			$row[] = $keluarga->pekerjaan;
			// $row[] = '<center><button type="button" class="btn btn-primary btn-xs" onclick="show_procedure('.$keluarga->id.')"><i class="fa fa-pencil-square-o"></i></button></center>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rjmregistrasi->keluarga_count_all(),
			"recordsFiltered" => $this->rjmregistrasi->keluarga_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function data_kotakab($id_prop = '', $sid = '')
	{
		$data = $this->rjmpencarian->get_kotakab($id_prop)->result();
		echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
		foreach ($data as $row) {
			echo "<option value='$row->id-$row->nama'>$row->nama</option>";
		}
	}
	public function data_kecamatan($id_kabupaten = '', $sid = '')
	{
		$data = $this->rjmpencarian->get_kecamatan($id_kabupaten)->result();
		echo "<option selected value=''>Pilih Kecamatan</option>";
		foreach ($data as $row) {
			echo "<option value='$row->id-$row->nama'>$row->nama</option>";
		}
	}

	public function data_kelurahan($id_kecamatan = '', $sid = '')
	{
		$data = $this->rjmpencarian->get_kelurahan($id_kecamatan)->result();
		echo "<option selected value=''>Pilih Kelurahan</option>";
		foreach ($data as $row) {
			echo "<option value='$row->id-$row->nama'>$row->nama</option>";
		}
	}
	public function data_dokter_poli2($id_poli = '')
	{
		if ($id_poli == 'BW01') {
			$data = $this->rjmpelayanan->get_dokter()->result();
			// var_dump($data);
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				echo "<option value='$row->id_dokter-" . $row->kode_dpjp_bpjs . "-$row->nm_dokter'>$row->nm_dokter - $row->nm_poli</option>";
			}
		} else {
			$data = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			// var_dump($data);
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				echo "<option value='$row->id_dokter-$row->kode_dpjp_bpjs-$row->nm_dokter'>$row->nm_dokter</option>";
				// echo "<option value='$row->id_dokter-.$row->kode_dpjp_bpjs."-$row->nm_dokter'>$row->nm_dokter</option>";

			}
		}
	}
	public function data_dokter_poli($id_poli = '')
	{
		if ($id_poli == 'BW01') {
			$data = $this->rjmpelayanan->get_dokter()->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				// echo "<option value='$row->id_dokter'>$row->nm_dokter - $row->nm_poli</option>";
				echo "<option value='$row->id_dokter-$row->kode_dpjp_bpjs-$row->nm_dokter'>$row->nm_dokter</option>";
			}
		} elseif ($id_poli == 'ME00') {
			$data = $this->rjmpelayanan->get_dokter()->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				// echo "<option value='$row->id_dokter'>$row->nm_dokter - $row->nm_poli</option>";
				echo "<option value='$row->id_dokter-$row->kode_dpjp_bpjs-$row->nm_dokter'>$row->nm_dokter</option>";
			}
		} else {
			$data = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				// echo "<option value='$row->id_dokter-$row->nm_dokter'>$row->nm_dokter</option>";
				echo "<option value='$row->id_dokter-$row->kode_dpjp_bpjs-$row->nm_dokter'>$row->nm_dokter</option>";
			}
		}
	}
	public function data_kontraktor($tipe = '')
	{
		// $result = $this->rjmregistrasi->get_kontraktor_kerjasama()->result();
		// 	echo "<option selected value=''>-Pilih Penjamin-</option>";
		// 	foreach($result as $row){
		// 		echo "<option value='$row->id_kontraktor'>$row->nmkontraktor</option>";
		// 	}
		$result = $this->rjmregistrasi->get_kontraktor_bpjs2($tipe)->result();

		echo json_encode($result);
	}
	public function data_kontraktor_bpjs($tipe = '')
	{
		$result = $this->rjmregistrasi->get_kontraktor_bpjs()->result();
		echo "<option selected value=''>-Pilih Penjamin-</option>";
		foreach ($result as $row) {
			echo "<option value='$row->id_kontraktor'>$row->nmkontraktor</option>";
		}
		echo json_encode($result);
	}

	public function data_kontraktor_KERJASAMA($tipe = '')
	{
		$result = $this->rjmregistrasi->get_kontraktor_kerjasama()->result();
		echo "<option selected value=''>-Pilih Penjamin-</option>";
		foreach ($result as $row) {
			echo "<option value='$row->id_kontraktor'>$row->nmkontraktor</option>";
		}
		echo json_encode($result);
	}
	public function data_kontraktorCoba()
	{
		$tipe = 'BPJS';
		$data = $this->rjmregistrasi->get_kontraktor_bpjs($tipe)->result();
		echo json_encode($data);
	}

	public function data_tindakan_iri()
	{
		$keyword = $this->input->post('q');
		//echo json_encode($keyword);			
		$data = $this->rjmregistrasi->get_all_tindakan('III', $keyword)->result();
		echo json_encode($data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function pasien($cm = '')
	{
		$data['title'] = 'Registrasi Pasien';


		if ($this->input->post('cari_no_cm') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		} else if ($this->input->post('cari_no_cm_lama') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_cm_lama'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_lama_history($this->input->post('cari_no_cm_lama'))->result();
		} else if ($this->input->post('cari_no_kartu') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_no_kartu_history($this->input->post('cari_no_kartu'))->result();
		} else if ($this->input->post('cari_no_identitas') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_no_identitas_history($this->input->post('cari_no_identitas'))->result();
		} else if ($this->input->post('cari_nama') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_nama_history($this->input->post('cari_nama'))->result();
		} else if ($this->input->post('cari_alamat') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_alamat_history($this->input->post('cari_alamat'))->result();
		} else if ($this->input->post('cari_tgl') != '') {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_tgl_history($this->input->post('cari_tgl'))->result();
		} else if ($this->input->post('cari_no_nrp') != '') {
			//mystring.replace(/,/g , ":")
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_nrp($this->input->post('cari_no_nrp'))->result();
			$data['data_registrasi'] = $this->rjmregistrasi->get_data_pasien_by_nrp_history($this->input->post('cari_no_nrp'))->result();
		}

		if (empty($data['data_pasien']) == 1) {
			$success = 	'<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('irj/rjcregistrasi');
		} else {

			$this->load->view('irj/rjvformcaripasien', $data);
		}
	}

	public function cek_available_nokartu($nokartu, $nokartuold = '')
	{
		$result = $this->rjmregistrasi->cek_no_kartu($nokartu, $nokartuold);
		echo $result->num_rows();
	}

	public function cek_available_nonrp($nonrp, $nonrpold = '')
	{
		$result = $this->rjmregistrasi->cek_no_nrp(str_replace('_', '/', $nonrp), $nonrpold)->result();
		echo json_encode($result);
	}

	public function cek_available_nonrp1($nonrp, $hub = '')
	{
		$result = $this->rjmregistrasi->cek_no_nrp1($nonrp, $hub)->result();
		echo json_encode($result);
	}
	//identitas old masih diperlukan? @rachmatg
	public function cek_available_noidentitas($noidentitas, $noidentitasold = '')
	{
		$result = $this->rjmregistrasi->cek_no_identitas($noidentitas, $noidentitasold);
		// echo $result->num_rows();
		echo json_encode($result->row());
		// var_dump($result->row());
	}

	// non tni
	// tni & kel
	public function insert_tindakan_kartu($data1)
	{
		// date_default_timezone_set("Asia/Jakarta");
		// $login_data = $this->load->get_var("user_info");
		// $user = $login_data->username;
		// $data['xuser']=$user;
		// $data['xupdate']=date("Y-m-d H:i:s");
		// // 1B0104 kartu umum
		// // 1B0111 kartu tentara
		// $data['no_register']=$data1['no_register'];
		// $no_register=$data1['no_register'];		
		// $data['id_poli']=$data1['id_poli'];

		// 	if($data1['no_nrp']!=''){
		// 		$data['idtindakan']='1B0111';
		// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0111')->row();
		// 	}else{
		// 		$data['idtindakan']='1B0105';
		// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0105')->row();
		// 	}


		// 	$data['tgl_kunjungan']=date("Y-m-d H:i:s");
		// 	$data['bpjs']='0';
		// 	/*if($data1['jenis_pasien']=='BARU'){
		// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
		// 		$data['idtindakan']='BA0102';					
		// 	}else{
		// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
		// 		$data['idtindakan']='BA0103';
		// 	}		*/

		// 	$data['nmtindakan']=$detailtind->nmtindakan;		

		// 	$data['biaya_tindakan']=$detailtind->total_tarif;
		// 	$data['biaya_alkes']=$detailtind->tarif_alkes;
		// 	$data['qtyind']='1';
		// 	$data['bpjs']='0';
		// 	//$data['dijamin']=$this->input->post('dijamin');
		// 	$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];

		// 	$id=$this->rjmpelayanan->insert_tindakan($data);

		// 	//penambahan vtot di daftar_ulang_irj
		// 	$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
		// 	$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
		// 	$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
	}



	public function insert_tindakan_OLD($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		$data['id_poli'] = $data1['id_poli'];
		//default BA0102
		if ($data['id_poli'] == 'BG00' || $data['id_poli'] == 'BW00') {

			if ($data1['jenis_pasien'] == 'BARU') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1025')->row();
				$data['idtindakan'] = '1B1025';
			}
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			// tambah lagi disini`
			// idtindakan,tgl_kunjungan,nmtindakan,biaya_tindakan,biaya_alkes,qtyind,vtot,
			// insert tindakan
			// data_vtot update 
			$no_register = $data1['no_register'];
			$khusus['no_register'] = $no_register;
			$khusus['idtindakan'] = '1B0107';
			$khusus['tgl_kunjungan'] = $data['tgl_kunjungan'];
			$detailkhusus = $this->rjmregistrasi->get_detail_tindakan('1B0107')->row();
			$khusus['nmtindakan'] = $detailkhusus->nmtindakan;
			$khusus['biaya_tindakan'] = $detailkhusus->total_tarif;
			$khusus['biaya_alkes'] = $detailkhusus->tarif_alkes;
			$khusus['qtyind'] = '1';
			$khusus['xuser'] = $user;
			$khusus['xupdate'] = date("Y-m-d H:i:s");
			$khusus['vtot'] = (int)$khusus['biaya_tindakan'] + (int)$khusus['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus);

			if ($data1['jenis_pasien'] == 'BARU') {
				$anayarankamari['no_register'] = $no_register;
				$anayarankamari['idtindakan'] = '1B0104';
				$anayarankamari['tgl_kunjungan'] = $data['tgl_kunjungan'];
				$detailanayarankamari = $this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
				$anayarankamari['nmtindakan'] = $detailanayarankamari->nmtindakan;
				$anayarankamari['biaya_tindakan'] = $detailanayarankamari->total_tarif;
				$anayarankamari['biaya_alkes'] = $detailanayarankamari->tarif_alkes;
				$anayarankamari['qtyind'] = '1';
				$anayarankamari['xuser'] = $user;
				$anayarankamari['xupdate'] = date("Y-m-d H:i:s");
				$anayarankamari['vtot'] = (int)$anayarankamari['biaya_tindakan'] + (int)$anayarankamari['biaya_alkes'];

				$id = $this->rjmpelayanan->insert_tindakan($anayarankamari);
			} else {
			}

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		} else {

			if ($data1['jenis_pasien'] == 'BARU') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1025')->row();
				$data['idtindakan'] = '1B1025';
			}
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			$no_register = $data1['no_register'];
			$khusus1['no_register'] = $no_register;

			$khusus1['idtindakan'] = '1B0106';
			$khusus1['tgl_kunjungan'] = $data['tgl_kunjungan'];
			$detailkhusus1 = $this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
			$khusus1['nmtindakan'] = $detailkhusus1->nmtindakan;
			$khusus1['biaya_tindakan'] = $detailkhusus1->total_tarif;
			$khusus1['biaya_alkes'] = $detailkhusus1->tarif_alkes;
			$khusus1['qtyind'] = '1';
			$khusus1['xuser'] = $user;
			$khusus1['xupdate'] = date("Y-m-d H:i:s");
			$khusus1['vtot'] = (int)$khusus1['biaya_tindakan'] + (int)$khusus1['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus1);

			if ($data1['jenis_pasien'] == 'BARU') {
				$anayaranbieupisan['no_register'] = $no_register;
				$anayaranbieupisan['idtindakan'] = '1B0104';
				$anayaranbieupisan['tgl_kunjungan'] = $data['tgl_kunjungan'];
				$detailanayaranbieupisan = $this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
				$anayaranbieupisan['nmtindakan'] = $detailanayaranbieupisan->nmtindakan;
				$anayaranbieupisan['biaya_tindakan'] = $detailanayaranbieupisan->total_tarif;
				$anayaranbieupisan['biaya_alkes'] = $detailanayaranbieupisan->tarif_alkes;
				$anayaranbieupisan['qtyind'] = '1';
				$anayaranbieupisan['xuser'] = $user;
				$anayaranbieupisan['xupdate'] = date("Y-m-d H:i:s");
				$anayaranbieupisan['vtot'] = (int)$anayaranbieupisan['biaya_tindakan'] + (int)$anayaranbieupisan['biaya_alkes'];

				$id = $this->rjmpelayanan->insert_tindakan($anayaranbieupisan);
			} else {
			}

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus1['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		}


		$no_register = $data1['no_register'];
	}

	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		$data['id_poli'] = $data1['id_poli'];
		//default BA0102
		if ($data['id_poli'] == 'BU00') {
			$detailtind=$this->rjmregistrasi->get_detail_tindakan_new('1B0107')->row();	
			$data['idtindakan']='1B0107';
			$data['id_poli'] = $data1['id_poli'];	
			$data['id_dokter'] = $data1['id_dokter'];
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data['nmtindakan'] = $detailtind->nmtindakan;
			$data['tmno'] = $detailtind->tmno;
			$data['biaya_tindakan'] = $detailtind->tarif;
			$data['biaya_alkes'] = 0;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$id = $this->rjmpelayanan->insert_tindakan($data);
		}else if($data['id_poli'] == 'BG00'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan_new('1B0116')->row();	
			$data['idtindakan']='1B0116';
			$data['id_poli'] = $data1['id_poli'];	
			$data['id_dokter'] = $data1['id_dokter'];
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data['nmtindakan'] = $detailtind->nmtindakan;
			$data['tmno'] = $detailtind->tmno;
			$data['biaya_tindakan'] = $detailtind->tarif;
			$data['biaya_alkes'] = 0;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$id = $this->rjmpelayanan->insert_tindakan($data);
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan_new('1B0130')->row();	
			$data['idtindakan']='1B0130';
			$data['id_poli'] = $data1['id_poli'];	
			$data['id_dokter'] = $data1['id_dokter'];
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data['nmtindakan'] = $detailtind->nmtindakan;
			$data['tmno'] = $detailtind->tmno;
			$data['biaya_tindakan'] = $detailtind->tarif;
			$data['biaya_alkes'] = 0;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$id = $this->rjmpelayanan->insert_tindakan($data);

			$detailtind2=$this->rjmregistrasi->get_detail_tindakan_new('1B0102')->row();
			$data2['xuser'] = $user;
			$data2['xupdate'] = date("Y-m-d H:i:s");
			// baru BA0102 , lama BA0103 //
			$data2['no_register'] = $data1['no_register'];
			$no_register = $data1['no_register'];
			$data2['id_poli'] = $data1['id_poli'];	
			$data2['id_dokter'] = $data1['id_dokter'];
			$data2['idtindakan']='1B0102';
			$data2['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data2['nmtindakan'] = $detailtind2->nmtindakan;
			$data2['tmno'] = $detailtind2->tmno;
			$data2['biaya_tindakan'] = $detailtind2->tarif;
			$data2['biaya_alkes'] = 0;
			$data2['qtyind'] = '1';
			$data2['vtot'] = (int)$data2['biaya_tindakan'] + (int)$data2['biaya_alkes'];
			$id = $this->rjmpelayanan->insert_tindakan($data2);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
			$no_register = $data1['no_register'];
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya;
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		}


		$no_register = $data1['no_register'];
	}


	public function irj_pulang()
	{
		$data['daftar_pasien'] = $this->rjmregistrasi->get_daftar_pasien_belum_pulang()->result();

		$data['title'] = 'Daftar Pasien Rawat Jalan yang Belum Pulang';
		$data['message'] = '';
		$data['search_per'] = 'cm';
		$this->load->view('irj/rjvformdaftarpulang', $data);
	}

	public function kontrol_pasien()
	{			//2016-09-25 2017-03-02

		if ($this->input->post('tgl0') != '') {
			$tgl0 = $this->input->post('tgl0');
			$tgl00 = date('d-m-Y', strtotime($tgl0));
		} else {
			$tgl0 = date('Y-m-d', strtotime('-7 days'));
			$tgl00 = date('d-m-Y', strtotime('-7 days'));
		}

		if ($this->input->post('tgl1') != '') {
			$tgl1 = $this->input->post('tgl1');
			$tgl11 = date('d-m-Y', strtotime($tgl1));
		} else {
			$tgl1 = date('Y-m-d');
			$tgl11 = date('d-m-Y');
		}
		$data['daftar_kontrol'] = $this->rjmregistrasi->get_daftar_kontrol($tgl0, $tgl1)->result();

		$data['title'] = 'Tanggal Kontrol Pasien | ' . $tgl00 . ' s/d ' . $tgl11;
		$data['message'] = '';
		$data['search_per'] = 'cm';
		$this->load->view('irj/rjvformkontrol', $data);
	}

	/**
	 * Over Haul Daftarulang
	 */

	//  Get Data User Login

	public function get_data_user_login()
	{
		header('Content-Type: application/json; charset=utf-8');
	}


	// Ambil data pasien by no cm baru
	public function get_data_pasien_by_no_cm_baru($no_cm)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row());
	}

	// ambil master suku bangsa
	public function get_master_sukubangsa()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_sukubangsa()->result());
	}

	// ambil master pekerjaan
	public function get_master_pekerjaan()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_pekerjaan()->result());
	}

	// ambil master poli
	public function get_master_poli()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_poliklinik_non_igd()->result());
	}

	// ambil master kecelakaan
	public function get_data_kecelakaan()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_data_kecelakaan()->result());
	}


	// ambil master dokter
	public function get_all_dokter()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_dokter()->result());
	}

	// ambil master kontraktor
	public function get_all_kontraktor($data = null)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_kontraktor($data)->result());
	}

	// ambil master diagnosa
	public function get_all_diagnosa()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpencarian->get_diagnosa()->result());
	}

	public function daftarulangantrol($no_cm, $noreg_konsul='')
	{
		$data = [
			'title' => 'Registrasi Pasien',
			'waktu_masuk_mr' => date('Y-m-d H:i:s'),
			'poliumum' => '',
			'no_medrec' => $no_cm,
			'online' => null,
			'data_pasien' => $this->rdmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row(),
			'noreg_asal_konsul' => $noreg_konsul,
		];
		if ($this->input->get('online') == '1') {
			$poli = $this->rjmpencarian->cariPoliklinik($this->input->get('idpoli'))->row();
			$dokter = $this->rjmpencarian->cariDokter($this->input->get('iddokter'))->row();
			$data['online'] = [
				'carabayar' => $this->input->get('carabayar'),
				'iddokter' => $dokter->id_dokter . '-' . $dokter->nm_dokter,
				'poliklinik' => $poli->id_poli . $poli->nm_pokpoli . '~' . $poli->nm_poli,
				'nokartu' => $this->input->get('nokartu'),
				'tglkunjungan' => $this->input->get('tglkunjungan'),
				'noreservasi' => $this->input->get('noreservasi'),
				'tiperujukan' => $this->input->get('tiperujukan')
			];
		}

		if ($no_cm != '') {
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
		}
		if($this->input->get('reservasi')){
			$data['reservasi'] = json_decode(base64_decode($this->input->get('reservasi')));
		}
		
		/**
		 * Feat : penambahan fitur otomatis jika terdapat surat kontrol 
		 * q = base 64 encode (isinya surat kontrol)
		 */
		if($this->input->get('q')){
			$this->load->library('vclaim');
			$suratkontrol = base64_decode($this->input->get('q'));
			$alert = '';
			// check surat kontrol to bpjs surat kontrol
			$url = 'RencanaKontrol/noSuratKontrol/'.$suratkontrol;
			$result = json_decode($this->vclaim->get($url));
			// var_dump($result->metaData->code);
			if($result->metaData->code != '200' && !$result->response){
				$data['alert'] = "Peringatan! ".$result->metaData->message;
				return $this->load->view('irj/daftarulang/daftarulang_new', $data);
				
			}
			// check jika surat kontrol sama dengan kunjungan pasien hari ini 
			$response = $result->response;
			if($response->tglRencanaKontrol != date('Y-m-d'))
			{
				$data['alert'] = "Peringatan! tanggal surat kontrol tidak sesuai 
				dengan tanggal pendaftaran, silahkan untuk mengupdate surat kontrol
				&nbsp;<a target=\"_blank\" href=\"".base_url('bpjs/rencanakontrol/update/'.$suratkontrol)."\" class=\"btn btn-danger\">Update Surat Kontrol</a>";
			}
			$data['suratkontrol'] = $response;
			return $this->load->view('irj/daftarulang/daftarulang_new', $data);
		}

		if($this->input->get('antrol')){
			$data['antrol'] = $this->input->get('antrol');
		}

		return $this->load->view('irj/daftarulang/daftarulangantrol', $data);
	}


	// ambil daftar ulang baru
	public function daftarulangnew($no_cm,$noreg_konsul="")
	{
		// var_dump($no_cm);die();
		
			$data = [
			'title' => 'Registrasi Pasien',
			'waktu_masuk_mr' => date('Y-m-d H:i:s'),
			'poliumum' => '',
			'no_medrec' => $no_cm,
			'online' => null,
			'data_pasien' => $this->rdmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row(),
			'noreg_asal_konsul' => $noreg_konsul,
		];
		if ($this->input->get('online') == '1') {
			$poli = $this->rjmpencarian->cariPoliklinik($this->input->get('idpoli'))->row();
			$dokter = $this->rjmpencarian->cariDokter($this->input->get('iddokter'))->row();
			$data['online'] = [
				'carabayar' => $this->input->get('carabayar'),
				'iddokter' => $dokter->id_dokter . '-' . $dokter->nm_dokter,
				'poliklinik' => $poli->id_poli . $poli->nm_pokpoli . '~' . $poli->nm_poli,
				'nokartu' => $this->input->get('nokartu'),
				'tglkunjungan' => $this->input->get('tglkunjungan'),
				'noreservasi' => $this->input->get('noreservasi'),
				'tiperujukan' => $this->input->get('tiperujukan')
			];
		}

		if ($no_cm != '') {
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
		}
		if($this->input->get('reservasi')){
			$data['reservasi'] = json_decode(base64_decode($this->input->get('reservasi')));
		}
		
		/**
		 * Feat : penambahan fitur otomatis jika terdapat surat kontrol 
		 * q = base 64 encode (isinya surat kontrol)
		 */
		if($this->input->get('q')){
			$this->load->library('vclaim');
			$suratkontrol = base64_decode($this->input->get('q'));
			$alert = '';
			// check surat kontrol to bpjs surat kontrol
			$url = 'RencanaKontrol/noSuratKontrol/'.$suratkontrol;
			$result = json_decode($this->vclaim->get($url));
			// var_dump($result->metaData->code);
			if($result->metaData->code != '200' && !$result->response){
				$data['alert'] = "Peringatan! ".$result->metaData->message;
				return $this->load->view('irj/daftarulang/daftarulang_new', $data);
				
			}
			// check jika surat kontrol sama dengan kunjungan pasien hari ini 
			$response = $result->response;
			if($response->tglRencanaKontrol != date('Y-m-d'))
			{
				$data['alert'] = "Peringatan! tanggal surat kontrol tidak sesuai 
				dengan tanggal pendaftaran, silahkan untuk mengupdate surat kontrol
				&nbsp;<a target=\"_blank\" href=\"".base_url('bpjs/rencanakontrol/update/'.$suratkontrol)."\" class=\"btn btn-danger\">Update Surat Kontrol</a>";
			}
			$data['suratkontrol'] = $response;
			return $this->load->view('irj/daftarulang/daftarulang_new', $data);
		}

		return $this->load->view('irj/daftarulang/daftarulang', $data);
	}


	public function daftarulang($no_cm)
	{
		$data['title'] = 'Registrasi Pasien';
		$data['no_medrec'] = $no_cm;
		$data['waktu_masuk_mr'] = date('Y-m-d h:i:s');
		// $data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
		$data['poliumum'] = ''; //$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
		$data['master_sukubangsa'] = $this->rjmpencarian->get_sukubangsa()->result();

		if ($no_cm != '') { //update
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row();
			$data['prop'] = $this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung'] = $this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
			$data['kelas'] = $this->rjmpencarian->get_kelas()->result();
			$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();
			$data['cara_bayar'] = $this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter'] = $this->rjmpencarian->get_dokter()->result();
			//$this->console_log($data_dokter);
			$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();
			$data['kecelakaan'] = $this->rjmpencarian->get_data_kecelakaan()->result();
			//$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			// $data['hubungan']=$this->rjmpencarian->get_hubungan()->result();

			// $data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			// $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
			// $data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan'] = $this->rjmpencarian->get_pekerjaan()->result();
			$data['online'] = 0;
			$data['status'] = 0;
			// $data['cetak_kwitansi'] = 0;
			// $data['lab'] = 0;
			// $data['status_lab']=0;
			// $data['rad'] = 0;
			// $data['status_rad']=0;
			// $data['pa'] = 0;
			// $data['status_pa']=0;
			// $data['ok'] = 0;
			// $data['status_ok']=0;
			// $data['obat'] = 0;
			// $data['status_oba']=0;


			$this->load->view('irj/rjvformdaftar2', $data);
		} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			redirect('irj/rjcregistrasi');
		} else {
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_cm($no_cm)->row();
			$data['hubungan'] = $this->rjmpencarian->get_hubungan()->result();
			$data['prop'] = $this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung'] = $this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
			$data['kelas'] = $this->rjmpencarian->get_kelas()->result();
			$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();
			$data['cara_bayar'] = $this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter'] = $this->rjmpencarian->get_dokter()->result();

			$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();
			// $data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			// //$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			// $data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			// $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
			// // $data['kesatuan2']=$this->rjmpencarian->get_kesatuan2()->result();
			// // $data['kesatuan3']=$this->rjmpencarian->get_kesatuan3()->result();
			// $data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan'] = $this->rjmpencarian->get_pekerjaan()->result();
			$data['online'] = 0;
			$data['status'] = 0;
			//$data['cetak_kwitansi'] = 0;
			// $data['lab'] = 0;
			// $data['status_lab']=0;
			// $data['rad'] = 0;
			// $data['status_rad']=0;
			// $data['pa'] = 0;
			// $data['status_pa']=0;
			// $data['ok'] = 0;
			// $data['status_ok']=0;
			// $data['obat'] = 0;
			// $data['status_oba']=0;

			$this->load->view('irj/rjvformdaftar2', $data);
		}
	}

	public function get_obat_desc()
	{
		$no_medrec = $this->input->post('no_register');

		$line   = array();
		$line2  = array();
		$row2   = array();

		$no_resep = $this->rjmregistrasi->get_no_resep_desc($no_medrec)->row()->no_resep;
		$hasil = $this->rjmregistrasi->get_obat_desc($no_resep)->result();
		foreach ($hasil as $value) {
			$row2['nama_obat'] = $value->nama_obat;
			$row2['satuan'] = $value->satuan;
			$row2['qty'] = $value->qty;
			$row2['signa'] = $value->signa;

			$line2[] = $row2;
		}

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function daftarulang_online($no_cm = "", $id_online = "")
	{
		$data['title'] = 'Registrasi Pasien';
		$data['waktu_masuk_mr'] = date('Y-m-d h:i:s');
		$data['biayakarcis'] = $this->rjmregistrasi->get_biayakarcis()->row();
		$data['poliumum'] = ''; //$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;

		if ($no_cm != '') { //update
			$data['data_pasien'] = $this->rjmregistrasi->get_data_pasien_by_no_cm_online($no_cm)->row();
			$data['prop'] = $this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung'] = $this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
			$data['kelas'] = $this->rjmpencarian->get_kelas()->result();
			$data['poli'] = $this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar'] = $this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter'] = $this->rjmpencarian->get_dokter()->result();
			$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();
			$data['kecelakaan'] = $this->rjmpencarian->get_data_kecelakaan()->result();
			$data['hubungan'] = $this->rjmpencarian->get_hubungan()->result();
			$data['angkatan'] = $this->rjmpencarian->get_angkatan()->result();
			$data['kesatuan'] = $this->rjmpencarian->get_kesatuan_all()->result();
			$data['pangkat'] = $this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan'] = $this->rjmpencarian->get_pekerjaan()->result();
			$data['online'] = 1;
			$data['id_online'] = $id_online;
			$this->load->view('irj/rjvformdaftar2', $data);
		} else {
			redirect('irj/rjconline');
		}
	}

	function cetak_faktur_kt($no_register = '')
	{

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if ($no_register != '') {
			$cterbilang = new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars = $this->config->item('namars');
			$kota_kab = $this->config->item('kota');
			$telp = $this->config->item('telp');
			$alamatrs = $this->config->item('alamat');
			$nmsingkat = $this->config->item('namasingkat');

			$data_pasien = $this->rjmkwitansi->getdata_pasien($no_register)->row();

			$detail_daful = $this->rjmkwitansi->get_detail_daful($no_register)->row();
			// 
			//print_r($detail_daful);
			if ($detail_daful->cara_bayar == 'UMUM') {
				$pasien_bayar = 'TUNAI';
			} else $pasien_bayar = 'KREDIT';
			$txtkk = '';
			$txtdiskon = '';
			$txttunai = "";
			$txtperusahaan = '';
			$totalbayar = '';
			$totalbayar1 = '';
			$totalbayar2 = '';
			$detail_bayar = $detail_daful->cara_bayar;



			//print_r($detail_bayar);
			if ($detail_bayar == 'DIJAMIN' || $detail_bayar == 'BPJS') {
				$kontraktor = $this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan = "<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>" . strtoupper($kontraktor->nmkontraktor) . "</td>";
			} else {
				$txtperusahaan = "<td></td>
								<td></td>
								<td></td>";
			}



			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			$vtot = $this->rjmkwitansi->get_vtot($no_register)->row();
			$vtot = 0;
			$data_tindakan = $this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			foreach ($data_tindakan as $row1) {
				$vtot = $vtot + $row1->biaya_tindakan;
			}
			$jumlah_vtot =  $vtot;

			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul = "";
			$nomor = $this->rjmkwitansi->get_no_kwitansi($no_register)->row();
			$no_kwitansi = $nomor->no_kwitansi;

			$style = '';
			if ($data_pasien->sex == 'L') {
				$sex = 'LAKI-LAKI';
			} else {
				$sex = 'PEREMPUAN';
			}

			$konten = "<style type=\"text/css\">
					.table-font-size{
						font-size:7px;
					    }
					.table-font-size1{
						font-size:8.5px;
					    }
					</style>
					
					<table  border=\"0\" style=\"padding-top:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:7px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam
								<br> $no_kwitansi
							</font></td>						
						</tr>
						
					</table>
						<tr>
						<td colspan=\"3\" ><font size=\"10\" align=\"center\"><u><b>KWITANSI REGISTRASI RAWAT JALAN 
						No. $no_register-1  </b></u></font></td>
					</tr>
					<table class=\"table-font-size1\" border=\"0\" style=\"padding-top:5px;\">		
								
																								
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"35%\">" . strtoupper($data_pasien->nama) . "</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"22%\">" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							</tr>
							<tr>
								<td><b>Kelamin</b></td>
								<td> : </td>
								<td>" . $sex . "</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>" . strtoupper($data_pasien->no_cm) . "</td>
							</tr>
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>" . strtoupper($data_pasien->alamat) . "</td>
								<td><b>Poli Tujuan</b></td>
								<td> : </td>
								<td>" . strtoupper($data_pasien->nm_poli) . "</td>
							</tr>
							
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>" . strtoupper($data_pasien->cara_bayar) . "</td>
								<td><b>Waktu Shift</b></td>
								<td> : </td>
								<td>" . $detail_daful->shift . "</td>						
								$txtperusahaan
							</tr>							
							
							<tr>
								<td></td>
								<td></td>
								<td></td>						
								<td></td>
								<td></td>
								<td></td>
							</tr>
																											
					</table>";



			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();


			//print_r($data_tindakan);
			$no = 1;
			$konten .= "<table border=\"1\" style=\"padding:2px\" class=\"table-font-size1\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
			// <tr>
			// 	<td><p align=\"center\">1</p></td>
			// 	<td><b>TINDAKAN</b></td>
			// 	<td></td>
			// 	<td><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></td>
			// </tr>";


			foreach ($data_tindakan as $row1) {

				$konten .= "
					<tr>
						<td><p align=\"center\">" . $no++ . "</p></td>
						<td>" . ucwords(strtolower($row1->nmtindakan)) . "</td>
						<td><p align=\"right\">" . number_format($row1->vtot, 2, ',', '.') . "</p></td>
						</tr>";
			}



			$konten .= "
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th ><p align=\"right\">" . number_format($vtot, 2, ',', '.') . "</p></th>
						</tr>

					</table>
					<table style=\"padding-top:5px;\" class=\"table-font-size1\"><tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><b><i>" . strtoupper($vtot_terbilang) . "</i></b></td>
							</tr></table>
					
					";
			/*<table style=\"border:1px solid black; \" >										
					<tr>
						<td width=\"50%\" ><p>Jumlah </p></td>
						<td width=\"10%\">:</td>
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					</table>*/

			$konten .= "
					
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl								
								
								<br><br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>";


			//echo $konten1;

			$konten1 = $konten . "<hr>" . $konten . "<hr>" . $konten;
			// var_dump($konten1);die();
			$file_name = "Daftar_$no_register-1.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('5', '0', '5');
			$obj_pdf->SetAutoPageBreak(TRUE, '2');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten1;
			ob_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/irj/rjkwitansi/' . $file_name, 'FI');
		} else {
			redirect('irj/rjcregistrasi/kwitansi/', 'refresh');
		}
	}

	private function reverse_tgl($tgl)
	{
		$tgl_lahir_mentah = explode('/', $tgl);
		$reverse_tgl_lahir = $tgl_lahir_mentah[2] . '-' . $tgl_lahir_mentah[1] . '-' . $tgl_lahir_mentah[0];
		return $reverse_tgl_lahir;
	}

	private function make_datetime($tgl)
	{
		// $term =$tgl.' 00:00:00';
		return date('Y/m/d h:i:s', strtotime($tgl . '00:00:00'));
		// return date('Y/m/d h:i:s',strtotime($tgl));
		// $term = date('Y-m-d H:i:s',strtotime($tgl.'00:00:00 GMT'));
		// return $term;
	}

	public function insert_data_pasien_antrol()
	{
		// var_dump($this->input->post('reservasi'));die();
		$query_bayi = $this->input->post('bayi') == "1" ? $this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('no_rm_ibu')) : null;
		$data_ibu = $query_bayi ? ($query_bayi->num_rows() ? $query_bayi->row() : null) : null;
		if ($this->input->post('ktp_reader') == '1') {
			$data['tgl_lahir'] = $this->input->post('tgl_lahir');
			$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('nik'))->row();
			if (count($check_ktp)) {
				$success = 	'<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
							</div>';
				$this->session->set_flashdata('success_msg', $success);
				redirect('irj/rjcregistrasi/regpasien');
			}
			$data['jenis_identitas'] = $this->input->post('jenis_identitas');
			$data['no_identitas'] = $this->input->post('no_identitas');
			$data['no_kartu'] = NULL;
			$data['nama'] = $this->input->post('nama');
			if ($this->input->post('jenis_kelamin') == 'LAKI-LAKI') {
				$data['sex'] = 'L';
			} else {
				$data['sex'] = 'P';
			}
			$data['tmpt_lahir'] = $this->input->post('tempat_lahir');
			$data['agama'] = $this->input->post('agama');
			$data['wnegara'] = $this->input->post('kewarganegaraan');
			// $data['status']=$this->input->post('status_kawin');
			if ($this->input->post('status_kawin') == 'KAWIN') {
				$data['status'] = 'K';
			} elseif ($this->input->post('status_kawin') == 'BELUM KAWIN') {
				$data['status'] = 'B';
			} elseif ($this->input->post('status_kawin') == 'CERAI HIDUP') {
				$data['status'] = 'CH';
			} else {
				$data['status'] = 'CM';
			}
			$data['alamat'] = $this->input->post('alamat');
			$data['rt'] = $this->input->post('rt');
			$data['rw'] = $this->input->post('rw');
			$data['provinsi'] = $this->input->post('provinsi');
			$data['kotakabupaten'] = $this->input->post('kabupaten');
			$data['kecamatan'] = $this->input->post('kecamatan');
			$data['kelurahandesa'] = $this->input->post('kelurahan');
			$data['id_provinsi'] = $this->rjmregistrasi->nm_provinsi_byname($this->input->post('provinsi'))->id;
			$data['id_kotakabupaten'] = $this->rjmregistrasi->nm_kota_byname($this->input->post('kabupaten'))->id;
			$data['id_kecamatan'] = $this->rjmregistrasi->nm_kecamatan_byname($this->input->post('kecamatan'))->id;
			$data['id_kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan_byname($this->input->post('kelurahan'))->id;
			$data['kodepos'] = $this->input->post('kodepos');
			$data['pendidikan'] = NULL;
			$data['pekerjaan'] = $this->input->post('jenis_pekerjaan');
			$data['no_telp'] = NULL;
			$data['no_hp'] = NULL;
			$data['no_telp_kantor'] = NULL;
			$data['email'] = NULL;
			$data['goldarah'] = $this->input->post('golongan_darah');
			date_default_timezone_set("Asia/Jakarta");
			$data['tgl_daftar'] = date("Y-m-d");
			$data['xupdate'] = date("Y-m-d H:i:s");
			$data['xuser'] = 'KTP_READER';
			$data['userid'] = 'KTP_READER';
		} else {
			if ($data_ibu == null) {
				if ($this->input->post('bahasa2') != "") {
					$data['bahasa'] = $this->input->post('bahasa2');
				} else {
					$data['bahasa'] = $this->input->post('bahasa');
				}

				if ($this->input->post('jenis_identitas') != '') {
					$data['jenis_identitas'] = $this->input->post('jenis_identitas');
					$data['no_identitas'] = $this->input->post('no_identitas');
				}

				if ($this->input->post('no_kartu') == '') {
					$data['no_kartu'] = NULL;
				} else {
					$data['no_kartu'] = $this->input->post('no_kartu');
				}
				if ($this->input->post('load_wilayah') != '') {
					$wilayah = explode("@", $this->input->post('load_wilayah'));
					$data['id_provinsi'] = $wilayah[0];
					$data['id_kotakabupaten'] = $wilayah[1];
					$data['id_kecamatan'] = $wilayah[2];
					$data['id_kelurahandesa'] = $wilayah[3];

					$data['provinsi'] = $this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
					$data['kotakabupaten'] = $this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
					$data['kecamatan'] = $this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
					$data['kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
				}
			} else {
				$data['bahasa'] = $data_ibu->bahasa;
				$data['jenis_identitas'] = $data_ibu->jenis_identitas;
				$data['no_identitas'] = $data_ibu->no_identitas;
				$data['no_kartu'] = $data_ibu->no_kartu;
				// sini
				$data['id_provinsi'] = $data_ibu->id_provinsi;
				$data['id_kotakabupaten'] = $data_ibu->id_kotakabupaten;
				$data['id_kecamatan'] = $data_ibu->id_kecamatan;
				$data['id_kelurahandesa'] = $data_ibu->id_kelurahandesa;
				$data['provinsi'] = $data_ibu->provinsi;
				$data['kotakabupaten'] = $data_ibu->kotakabupaten;
				$data['kecamatan'] = $data_ibu->kecamatan;
				$data['kelurahandesa'] = $data_ibu->kelurahandesa;
			}
			$data['suami_istri'] = $this->input->post('nama_suami_istri');
			// $data['istri'] = $this->input->post('nama_istri');
			$data['nama_ayah'] = $this->input->post('nama_ayah');
			$data['nama_ibu'] = $this->input->post('nama_ibu');
			$data['alamat2'] = $data_ibu ? $data_ibu->alamat2 : $this->input->post('alamat2');
			$data['rt_alamat2'] = $data_ibu ? $data_ibu->rt_alamat2 : $this->input->post('rt_alamat2');
			$data['rw_alamat2'] = $data_ibu ? $data_ibu->rw_alamat2 : $this->input->post('rw_alamat2');
			$data['tgl_lahir'] = $this->input->post('tgl_lahir');
			$data['suku_bangsa'] = $data_ibu ? $data_ibu->suku_bangsa : strtoupper($this->input->post('suku_bangsa'));
			// if ($this->input->post('jenis_identitas') == 'KTP') {
			// 	$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('no_identitas'))->row();
			// 	if (count($check_ktp)) {
			// 		$success = 	'<div class="alert alert-danger">
			// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			// 						<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
			// 					</div>';
			// 		$this->session->set_flashdata('success_msg', $success);
			// 		redirect('irj/rjcregistrasi/regpasien');
			// 	}			
			// }				


			$data['nama'] = strtoupper($this->input->post('nama'));


			$data['sex'] = $this->input->post('sex');
			$data['tmpt_lahir'] = $this->input->post('tmpt_lahir');
			// $data['tgl_lahir']=$this->input->post('tgl_lahir');
			$data['agama'] = $data_ibu ? $data_ibu->agama : $this->input->post('agama');
			$data['wnegara'] = $data_ibu ? $data_ibu->wnegara : $this->input->post('wnegara');
			$data['status'] = $this->input->post('status');
			$data['alamat'] = $data_ibu ? $data_ibu->alamat : $this->input->post('alamat');
			$data['rt'] = $data_ibu ? $data_ibu->rt : $this->input->post('rt');
			$data['rw'] = $data_ibu ? $data_ibu->rw : $this->input->post('rw');
			$data['identitas_info'] = $this->input->post('identitas_info');
			$data['identitas_info_kepada'] = $this->input->post('identitas_info_kepada');
			$data['nama_ttd'] = $this->input->post('nama_ttd');



			$data['kodepos'] = $data_ibu ? $data_ibu->kodepos : $this->input->post('kodepos');
			$data['pendidikan'] = $this->input->post('pendidikan');

			if ($this->input->post('pekerjaan2') != "") {
				$data['pekerjaan'] = $this->input->post('pekerjaan2');
			} else {
				$data['pekerjaan'] = $this->input->post('pekerjaan');
			}
			//$data['pekerjaan']=$this->input->post('pekerjaan');
			//var_dump($data['pekerjaan']);die();
			$data['no_telp'] = $data_ibu ? $data_ibu->no_telp : $this->input->post('no_telp');
			$data['no_hp'] = $data_ibu ? $data_ibu->no_hp : $this->input->post('no_hp');
			$data['no_telp_kantor'] = $this->input->post('no_telp_kantor');
			$data['email'] = null;
			$data['goldarah'] = $data_ibu ? $data_ibu->rw : $this->input->post('goldarah');
			date_default_timezone_set("Asia/Jakarta");
			$data['tgl_daftar'] = date("Y-m-d");
			$data['xupdate'] = date("Y-m-d H:i:s");
			$data['xuser'] = $this->input->post('user_name');
			$data['userid'] = $this->input->post('userid');
		}
		$data['ttd_pasien'] = $this->input->post('ttd_pasien');
		$id = $this->rjmregistrasi->insert_pasien_irj($data);

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Baru Berhasil.</h3> Data berhasil disimpan. Silahkan daftar ulang pasien.
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		if ($this->input->post('bayi') == '1') {
			redirect('ird/rdcregistrasi/daftarulang/' . $id);
		}
		$no_reservasi = base64_encode($this->input->post('reservasi'));
		redirect('irj/rjcregistrasi/daftarulangnew/' . $id.'?reservasi='.$no_reservasi);
	}

	public function insert_data_pasien_old()
	{
		//  var_dump($this->input->post());die();
		// pasien itu bayi ?
		// if($this->input->post('bayi') == "1"){
		$query_bayi = $this->input->post('bayi') == "1" ? $this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('no_rm_ibu')) : null;
		$data_ibu = $query_bayi ? ($query_bayi->num_rows() ? $query_bayi->row() : null) : null;
		if ($this->input->post('ktp_reader') == '1') {
			$data['tgl_lahir'] = $this->input->post('tgl_lahir');
			$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('nik'))->row();
			if (count($check_ktp)) {
				$success = 	'<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
							</div>';
				$this->session->set_flashdata('success_msg', $success);
				redirect('irj/rjcregistrasi/regpasien');
			}
			$data['jenis_identitas'] = $this->input->post('jenis_identitas');
			$data['no_identitas'] = $this->input->post('no_identitas');
			$data['no_kartu'] = NULL;
			$data['nama'] = $this->input->post('nama');
			if ($this->input->post('jenis_kelamin') == 'LAKI-LAKI') {
				$data['sex'] = 'L';
			} else {
				$data['sex'] = 'P';
			}
			$data['tmpt_lahir'] = $this->input->post('tempat_lahir');
			$data['agama'] = $this->input->post('agama');
			$data['wnegara'] = $this->input->post('kewarganegaraan');
			// $data['status']=$this->input->post('status_kawin');
			if ($this->input->post('status_kawin') == 'KAWIN') {
				$data['status'] = 'K';
			} elseif ($this->input->post('status_kawin') == 'BELUM KAWIN') {
				$data['status'] = 'B';
			} elseif ($this->input->post('status_kawin') == 'CERAI HIDUP') {
				$data['status'] = 'CH';
			} else {
				$data['status'] = 'CM';
			}
			$data['alamat'] = $this->input->post('alamat');
			$data['rt'] = $this->input->post('rt');
			$data['rw'] = $this->input->post('rw');
			$data['provinsi'] = $this->input->post('provinsi');
			$data['kotakabupaten'] = $this->input->post('kabupaten');
			$data['kecamatan'] = $this->input->post('kecamatan');
			$data['kelurahandesa'] = $this->input->post('kelurahan');
			$data['id_provinsi'] = $this->rjmregistrasi->nm_provinsi_byname($this->input->post('provinsi'))->id;
			$data['id_kotakabupaten'] = $this->rjmregistrasi->nm_kota_byname($this->input->post('kabupaten'))->id;
			$data['id_kecamatan'] = $this->rjmregistrasi->nm_kecamatan_byname($this->input->post('kecamatan'))->id;
			$data['id_kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan_byname($this->input->post('kelurahan'))->id;
			$data['kodepos'] = $this->input->post('kodepos');
			$data['pendidikan'] = NULL;
			$data['pekerjaan'] = $this->input->post('jenis_pekerjaan');
			$data['no_telp'] = NULL;
			$data['no_hp'] = NULL;
			$data['no_telp_kantor'] = NULL;
			$data['email'] = NULL;
			$data['goldarah'] = $this->input->post('golongan_darah');
			date_default_timezone_set("Asia/Jakarta");
			$data['tgl_daftar'] = date("Y-m-d");
			$data['xupdate'] = date("Y-m-d H:i:s");
			$data['xuser'] = 'KTP_READER';
			$data['userid'] = 'KTP_READER';
		} else {
			if ($data_ibu == null) {
				if ($this->input->post('bahasa2') != "") {
					$data['bahasa'] = $this->input->post('bahasa2');
				} else {
					$data['bahasa'] = $this->input->post('bahasa');
				}

				if ($this->input->post('jenis_identitas') != '') {
					$data['jenis_identitas'] = $this->input->post('jenis_identitas');
					$data['no_identitas'] = $this->input->post('no_identitas');
				}

				if ($this->input->post('no_kartu') == '') {
					$data['no_kartu'] = NULL;
				} else {
					$data['no_kartu'] = $this->input->post('no_kartu');
				}
				if ($this->input->post('load_wilayah') != '') {
					$wilayah = explode("@", $this->input->post('load_wilayah'));
					$data['id_provinsi'] = $wilayah[0];
					$data['id_kotakabupaten'] = $wilayah[1];
					$data['id_kecamatan'] = $wilayah[2];
					$data['id_kelurahandesa'] = $wilayah[3];

					$data['provinsi'] = $this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
					$data['kotakabupaten'] = $this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
					$data['kecamatan'] = $this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
					$data['kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
				}
			} else {
				$data['bahasa'] = $data_ibu->bahasa;
				$data['jenis_identitas'] = $data_ibu->jenis_identitas;
				$data['no_identitas'] = $data_ibu->no_identitas;
				$data['no_kartu'] = $data_ibu->no_kartu;
				// sini
				$data['id_provinsi'] = $data_ibu->id_provinsi;
				$data['id_kotakabupaten'] = $data_ibu->id_kotakabupaten;
				$data['id_kecamatan'] = $data_ibu->id_kecamatan;
				$data['id_kelurahandesa'] = $data_ibu->id_kelurahandesa;
				$data['provinsi'] = $data_ibu->provinsi;
				$data['kotakabupaten'] = $data_ibu->kotakabupaten;
				$data['kecamatan'] = $data_ibu->kecamatan;
				$data['kelurahandesa'] = $data_ibu->kelurahandesa;
			}
			$data['suami_istri'] = $this->input->post('nama_suami_istri');
			// $data['istri'] = $this->input->post('nama_istri');
			$data['nama_ayah'] = $this->input->post('nama_ayah');
			$data['nama_ibu'] = $this->input->post('nama_ibu');
			$data['alamat2'] = $data_ibu ? $data_ibu->alamat2 : $this->input->post('alamat2');
			$data['rt_alamat2'] = $data_ibu ? $data_ibu->rt_alamat2 : $this->input->post('rt_alamat2');
			$data['rw_alamat2'] = $data_ibu ? $data_ibu->rw_alamat2 : $this->input->post('rw_alamat2');
			$data['tgl_lahir'] = $this->input->post('tgl_lahir');
			$data['suku_bangsa'] = $data_ibu ? $data_ibu->suku_bangsa : strtoupper($this->input->post('suku_bangsa'));
			// if ($this->input->post('jenis_identitas') == 'KTP') {
			// 	$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('no_identitas'))->row();
			// 	if (count($check_ktp)) {
			// 		$success = 	'<div class="alert alert-danger">
			// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			// 						<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
			// 					</div>';
			// 		$this->session->set_flashdata('success_msg', $success);
			// 		redirect('irj/rjcregistrasi/regpasien');
			// 	}			
			// }				


			$data['nama'] = strtoupper($this->input->post('nama'));


			$data['sex'] = $this->input->post('sex');
			$data['tmpt_lahir'] = $this->input->post('tmpt_lahir');
			// $data['tgl_lahir']=$this->input->post('tgl_lahir');
			$data['agama'] = $data_ibu ? $data_ibu->agama : $this->input->post('agama');
			$data['wnegara'] = $data_ibu ? $data_ibu->wnegara : $this->input->post('wnegara');
			$data['status'] = $this->input->post('status');
			$data['alamat'] = $data_ibu ? $data_ibu->alamat : $this->input->post('alamat');
			$data['rt'] = $data_ibu ? $data_ibu->rt : $this->input->post('rt');
			$data['rw'] = $data_ibu ? $data_ibu->rw : $this->input->post('rw');
			$data['identitas_info'] = $this->input->post('identitas_info');
			$data['identitas_info_kepada'] = $this->input->post('identitas_info_kepada');
			$data['nama_ttd'] = $this->input->post('nama_ttd');



			$data['kodepos'] = $data_ibu ? $data_ibu->kodepos : $this->input->post('kodepos');
			$data['pendidikan'] = $this->input->post('pendidikan');

			if ($this->input->post('pekerjaan2') != "") {
				$data['pekerjaan'] = $this->input->post('pekerjaan2');
			} else {
				$data['pekerjaan'] = $this->input->post('pekerjaan');
			}
			//$data['pekerjaan']=$this->input->post('pekerjaan');
			//var_dump($data['pekerjaan']);die();
			$data['no_telp'] = $data_ibu ? $data_ibu->no_telp : $this->input->post('no_telp');
			$data['no_hp'] = $data_ibu ? $data_ibu->no_hp : $this->input->post('no_hp');
			$data['no_telp_kantor'] = $this->input->post('no_telp_kantor');
			$data['email'] = null;
			$data['goldarah'] = $data_ibu ? $data_ibu->rw : $this->input->post('goldarah');
			date_default_timezone_set("Asia/Jakarta");
			$data['tgl_daftar'] = date("Y-m-d");
			$data['xupdate'] = date("Y-m-d H:i:s");
			$data['xuser'] = $this->input->post('user_name');
			$data['userid'] = $this->input->post('userid');
		}
		$data['ttd_pasien'] = $this->input->post('ttd_pasien');





		$id = $this->rjmregistrasi->insert_pasien_irj($data);

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Baru Berhasil.</h3> Data berhasil disimpan. Silahkan daftar ulang pasien.
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		if ($this->input->post('bayi') == '1') {
			redirect('ird/rdcregistrasi/daftarulang/' . $id);
		}
		redirect('irj/rjcregistrasi/daftarulangnew/' . $id);
	}
	public function update_data_pasien()
	{
		$no_medrec = $this->input->post('no_medrec');
		//	print_r($no_medrec);die();
		$data['no_cm'] = $this->input->post('cm_baru');
		if ($this->input->post('jenis_identitas') != '') {
			$data['jenis_identitas'] = $this->input->post('jenis_identitas');
			$data['no_identitas'] = $this->input->post('no_identitas');
		}
		// if ($this->input->post('no_kk')!='') {
		// 	$data['no_kk']=$this->input->post('no_kk');
		// }
		if ($this->input->post('no_kartu') == '') {
			$data['no_kartu'] = NULL;
		} else {
			$data['no_kartu'] = $this->input->post('no_kartu');
		}
		if ($this->input->post('bahasa2') != "") {
			$data['bahasa'] = $this->input->post('bahasa2');
		} else {
			$data['bahasa'] = $this->input->post('bahasa');
		}
		$data['suami_istri'] = $this->input->post('nama_suami_istri');
		$data['suku_bangsa'] = strtoupper($this->input->post('suku_bangsa'));
		$data['alamat2'] = $this->input->post('alamat2');
		$data['rt_alamat2'] = $this->input->post('rt_alamat2');
		$data['rw_alamat2'] = $this->input->post('rw_alamat2');
		$data['rt'] = $this->input->post('rt');
		$data['rw'] = $this->input->post('rw');
		$data['nama_ayah'] = $this->input->post('nama_ayah');
		$data['nama_ibu'] = $this->input->post('nama_ibu');
		$data['nama'] = $this->input->post('nama');
		$data['sex'] = $this->input->post('sex');
		$data['tmpt_lahir'] = $this->input->post('tmpt_lahir');

		// REVERSE TANGGAL LAHIR
		$data['tgl_lahir'] = $this->input->post('tgl_lahir');
		// $data['tgl_lahir']=$this->input->post('tgl_lahir');


		$data['agama'] = $this->input->post('agama');
		$data['wnegara'] = $this->input->post('wnegara');
		$data['status'] = $this->input->post('status');
		$data['alamat'] = $this->input->post('alamat');

		if ($this->input->post('load_wilayah') != '') {
			$wilayah = explode("@", $this->input->post('load_wilayah'));
			$data['id_provinsi'] = $wilayah[0];
			$data['id_kotakabupaten'] = $wilayah[1];
			$data['id_kecamatan'] = $wilayah[2];
			$data['id_kelurahandesa'] = $wilayah[3];
			$data['provinsi'] = $this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
			$data['kotakabupaten'] = $this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
			$data['kecamatan'] = $this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
			$data['kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
		}

		$data['kodepos'] = $this->input->post('kodepos');
		$data['pendidikan'] = $this->input->post('pendidikan');
		if ($this->input->post('pekerjaan2') != "") {
			$data['pekerjaan'] = $this->input->post('pekerjaan2');
		} else {
			$data['pekerjaan'] = $this->input->post('pekerjaan');
		}
		//$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp'] = $this->input->post('no_telp');
		$data['no_hp'] = $this->input->post('no_hp');
		$data['no_telp_kantor'] = $this->input->post('no_telp_kantor');
		$data['email'] = null;
		$data['goldarah'] = $this->input->post('goldarah');
		// $data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		// $data['jabatan']=$this->input->post('jabatan');	

		date_default_timezone_set("Asia/Jakarta");
		$data['xupdate'] = date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$ttd = $this->input->post('ttd_pasien');
		// var_dump($ttd);die();
		if ($ttd != "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAxUlEQVR4nO3BMQEAAADCoPVPbQhfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOA1v9QAATX68/0AAAAASUVORK5CYII=") {
			$data['ttd_pasien'] = $ttd;
		}
		$id = $this->rjmregistrasi->update_pasien_irj($data, $no_medrec);
		redirect('irj/rjcregistrasi/daftarulang/' . $no_medrec);
	}

	function balik_ke_awal($message, $url_redirect)
	{
		$notification = '<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			' . $message . '
			</div>';
		$this->session->set_flashdata('notification', $notification);
		redirect($url_redirect);
	}

	function generate_umur($no_medrec)
	{

		$get_umur = $this->rjmregistrasi->get_umur($no_medrec)->result();
		$tahun = 0;
		$bulan = 0;
		$hari = 0;
		foreach ($get_umur as $row) {
			// $tahun=floor($row->umurday/365);
			$tahun = $row->tahun;
			// $bulan=floor(($row->umurday - ($tahun*365))/30);
			$bulan = $row->bulan;
			// $hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
			$hari = $row->hari;
		}
		return [$tahun, $bulan, $hari];
	}

	/*
	Over Haul Daftar Ulang IRJ
	add feature vclaim bpjs v.2
	*/

	private function register_bpjs($data)
	{
		if($data['tglrujukan'] == ''){
			$data['tglrujukan'] = $data['tgl_sep'];
		}
		$this->rjmregistrasi->insert_sep_bpjs($data);
	}

	public function insert_daftar_ulang_new_antrol()
	{
		// echo "<pre>";
		// var_dump($this->input->post());
		// echo '</pre>';
		// die();
		date_default_timezone_set('Asia/Jakarta');
		$register = $this->input->post();
		/**
		 * Penambahan tgl kunjungan karena butuh time juga
		 */
		$register['tgl_kunjungan'] .= ' ' . date('H:i:s');
		if ($register['id_kontraktor'] == '') {
			$register['id_kontraktor'] = null;
		}
		/**
		 * Cek Konsultasi nanti
		 * notes dari aldi
		 * kalo ada apa apa tanyain sadja
		 */

		// $check_konsul_nanti = $this->rjmpelayanan->check_register_konsul_nanti($register['no_medrec'])->result();
		// if(count($check_konsul_nanti)>0){
		// 	$data['no_register_lama'] = $check_konsul_nanti[0]->no_register;
		// 	$up_du['konsul_nanti'] = "0";
		// 	$this->rjmpelayanan->update_konsul_nanti($up_du,$data['no_register_lama']);
		// }

		$umur = $this->generate_umur($register['no_medrec']);
		$login_data = $this->load->get_var("user_info");
		$register['xuser'] = $login_data->userid;
		$register['xcreate'] = $login_data->username;
		$register['umurrj'] = $umur[0];
		$register['ublnrj'] = $umur[1];
		$register['uharirj'] = $umur[2];
		$register['id_poli'] = substr($register['id_poli'], 0, 4);
		$register['id_dokter'] = explode('-', $register['id_dokter'])[0];
		$register['diagnosa'] = isset($register['diagnosa']) ? explode('@', $register['diagnosa'])[0] : '';
		$register['biayadaftar'] = 0;
		$register['vtot'] = 0;
		$register['xupdate'] = date('Y-m-d H:i:s');
		$register['em'] = $register['id_poli'] == 'ME00' ? 1 : null;
		$register['lab'] = $register['id_poli'] == 'HA00' ? 1 : null;
		$register['rad'] = $register['id_poli'] == 'LA00' ? 1 : null;
		$register['noreg_asal_konsul'] = $this->input->post('noreg_asal_konsul');
		unset(
			$register['kekhususan_lainnya'],
			$register['kelasrawat'],
			$register['asalrujukan'],
			$register['tglrujukan'],
			$register['ppkrujukan'],
			$register['tujuan_kunj'],
			$register['flag_procedure'],
			$register['kd_penunjang'],
			$register['assesment_pel'],
			$register['nosurat_skdp_sep'],
			$register['dpjp_suratkontrol'],
			$register['no_telp'],
			$register['catatan'],
			$register['no_bpjs'],
			$register['alber'],
			$register['pasdatDg'],
			$register['jenis_kecelakaan'],
			$register['dokter_bpjs'],
			$register['id_diagnosa'],
			$register['cetak_kartu1'],
			$register['namafaskes'],
			$register['prb'],
			$register['katarak'],
			$register['cetak_kartu'],
			$register['ppkrujukan_jarkomdat'],
			$register['reservasi'],
			$register['antrol'],
			$register['nik'],
			$register['norm']
		);
		// cek jika ada antrol -> maka masukan kodebooking kedalam sistem ekamek daftar_ulang(noreservasi)
		if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
			$register['noreservasi'] = $this->input->post('reservasi');
		}
		$id = $this->rjmregistrasi->insert_daftar_ulang($register);

		$datat['no_register'] = $id->no_register;

		if($register['noreg_asal_konsul'] != ""){
			$data_konsul['no_reg_new'] = $datat['no_register'];
			$data_konsul['daftar'] = 1;
			$this->rjmpelayanan->update_lembar_konsul_pasien($register['noreg_asal_konsul'],$data_konsul);
		}

		if ($register['cara_bayar'] == 'BPJS') {
			$datainput = $this->input->post();
			if (isset($datainput['ppkrujukan_jarkomdat'])) {
				$datainput['ppkrujukan'] = $datainput['ppkrujukan_jarkomdat'];
			}
			$input = [
				'no_medrec' => $datainput['no_medrec'],
				'tgl_sep' => $datainput['tgl_kunjungan'],
				'no_register' => $id->no_register,
				'no_kartu' => $datainput['no_bpjs'],
				'kelasrawat' => $datainput['kelasrawat'],
				'asalrujukan' => $datainput['asalrujukan'],

				// added for sep jamkordat
				'tglrujukan' => $datainput['cara_kunj'] != 'DATANG SENDIRI' ? $datainput['tglrujukan'] : ($datainput['tglrujukan'] == $datainput['tgl_kunjungan'] ? $datainput['tglrujukan'] : $datainput['tgl_kunjungan']),
				// end
				'norujukan' => $datainput['no_rujukan'],
				'ppkrujukan' => explode('@', $datainput['ppkrujukan'])[0],
				'diagawal' => explode('@', $datainput['diagnosa'])[0],
				'politujuan' => explode('~', $datainput['id_poli'])[1],
				'tujuankunj' => $datainput['tujuan_kunj'],
				'flagprocedure' => $datainput['flag_procedure'] ?? '',
				'kdpenunjang' => $datainput['kd_penunjang'] ?? '',
				'assesmentpel' => $datainput['assesment_pel'] ?? '',
				'nosurat' => $datainput['nosurat_skdp_sep'] ?? '',
				'dpjpsurat' => $datainput['dpjp_suratkontrol'] ?? '',
				'dpjplayan' => $datainput['dpjp_suratkontrol'] != '' || $datainput['dpjp_suratkontrol'] != null ? $datainput['dpjp_suratkontrol'] : explode('-', $datainput['dokter_bpjs'])[0],
				'namadokter' => explode('-', $datainput['dokter_bpjs'])[1],
				'namafaskes' => $datainput['namafaskes'],
				'user' => $datainput['xcreate'],
				'notelp' => $datainput['no_telp'],
				'catatan' => $datainput['catatan'],
				'prb' => $datainput['prb'],
				'katarak' => $datainput['katarak'] ?? "0",
			];
			$this->register_bpjs($input);
		}
		$pokpoli = $this->input->post('id_poli');
		$datat['id_poli'] = substr($pokpoli, 0, 4);
		$datat['jenis_pasien'] = $this->input->post('jns_kunj');
		$datat['cara_bayar'] = $this->input->post('cara_bayar');
		$datat['cara_dtg'] = $this->input->post('cara_dtg');

		/**
		 * Penambahan Jika insert via online (online & ANTROL)
		 * 
		 * @aldi
		 */
		// var_dump($register);die();
		if ($this->input->post('online') == "1") {
			$onlinenya = $this->checkinpasienonline($register['noreservasi'], $register['no_medrec']);
		}
		// cek jika ada antrol -> maka update task id ke 3
		// decode json dan masukan ke variabel antrol
		// Penambahan untuk keperluan antrian online update task id ke 3 
		// if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
		// 	$antrol = json_decode($this->clients->get(
		// 		$this->endpoint .'adminantrian/prosesantrian/'.$this->input->post('reservasi').'/3'
		// 	)->getBody()->getContents());
		// }
		if($this->input->post('antrol'))
		{
			// $antrol = json_decode($this->clients->get(
			// 	$this->endpoint .'adminantrian/prosesantrian/'.$this->input->post('reservasi').'/3'
			// )->getBody()->getContents());
			$antrian_admisi = $this->clients->get(
				$this->endpoint .'adminantrian/v2/updateflagantrian/'.$this->input->post('antrol').'/3/0'
			)->getBody()->getContents();

			if($register['cara_bayar'] != 'BPJS'){
				$req = [
					'nomorkartu'=>'',
					'nik'=>$this->input->post('nik'),
					'nohp'=>'00000000000',
					'kodepoli'=>explode('~', $this->input->post('id_poli'))[1],
					'norm'=>$this->input->post('norm'),
					'tanggalperiksa'=>$this->input->post('tgl_kunjungan'),
					'jampraktek'=>'00:00-23:00',
					'jeniskunjungan'=>'1', // {1 (Rujukan FKTP), 2 (Rujukan Internal), 3 (Kontrol), 4 (Rujukan Antar RS)}
					'nomorreferensi'=>'',
					'pasienbaru'=>'1',
					'jenispasien'=>'NON JKN'
				];

				$req['tanggalperiksa'] = date('Y-m-d');
				$req['kodedokter'] = explode('-', $this->input->post('id_dokter'))[1];
				// var_dump($req);die();
				
				// try {
				$response = $this->clients->post(
					$this->endpoint.'adminantrian/ambilantriannonjkn',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$req
					]
				)->getBody()->getContents();
				$response = json_decode($response);
				// var_dump($response);die();
				$kodebooking = '';
				if(isset($response->response->kodebooking))
				{
					$kodebooking = $response->response->kodebooking;
				}
				if($kodebooking == '')
				{
					// var_dump($response);die();
				}
				// insert task id 1
				$antrol1 = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/1'
				)->getBody()->getContents());
				// insert task id 2
				$antrol2 = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/2'
				)->getBody()->getContents());
				// insert task id 3
				$antrol = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/3'
				)->getBody()->getContents());
	
	
				// update noreservasi -> kodebooking kedalam daftar_ulang_irj
				$this->rjmregistrasi->updatenoreservasi($id->no_register,$kodebooking);
			}else{
				// insert kode booking
				// {
					// 	"nomorkartu": "string",
					// 	"nik": "string",
					// 	"nohp": "string",
					// 	"kodepoli": "string",
					// 	"norm": "string",
					// 	"tanggalperiksa": "string",
					// 	"kodedokter": "string",
					// 	"jampraktek": "string",
					// 	"jeniskunjungan": 0,
					// 	"nomorreferensi": "string",
					// 	"pasienbaru": "string"
					//   }

				// jika tujuan kunjungan = 0 & $datainput['assesment_pel'] == '' 
				// maka rujukan baru 
				$jeniskunjungan = '0';
				$nomorreferensi = '';
				if($datainput['tujuan_kunj'] == '0' )
				{
					if(($datainput['assesment_pel']??'') == '' )
					{
						// rujukan baru
						// check dari rujukan fktp
						if($this->input->post('cara_kunj') == 'RUJUKAN PUSKESMAS')
						{
							$jeniskunjungan = '1';
							$nomorreferensi = $datainput['no_rujukan'];
						}else{
							$jeniskunjungan = '4';
							$nomorreferensi = $datainput['no_rujukan'];
							
						}
					}else{
						// rujukan internal
						$jeniskunjungan = '2';
						$nomorreferensi = (explode('~', $datainput['id_poli'])[1])."0301R".date("dmY").sprintf("%03d", $this->rjmregistrasi->get_counter_internal());

					}
				}else{
					// kontrol
					$jeniskunjungan = '3';
					$nomorreferensi = $datainput['nosurat_skdp_sep'];
				}
				// var_dump($this->input->post());
				$req = [
					'nomorkartu'=>$datainput['no_bpjs'],
					'nik'=>$this->input->post('nik'),
					'nohp'=>$datainput['no_telp']==''?'00000000000':$datainput['no_telp'],
					'kodepoli'=>explode('~', $datainput['id_poli'])[1],
					'norm'=>$this->input->post('norm'),
					'tanggalperiksa'=>$datainput['tgl_kunjungan'],
					'jampraktek'=>'00:00-23:00',
					'jeniskunjungan'=>$jeniskunjungan, // {1 (Rujukan FKTP), 2 (Rujukan Internal), 3 (Kontrol), 4 (Rujukan Antar RS)}
					'nomorreferensi'=>$nomorreferensi,
					'pasienbaru'=>'1'
				];
				$req['tanggalperiksa'] = date('Y-m-d');
				$req['kodedokter'] = explode('-', $this->input->post('dokter_bpjs'))[0];
				// var_dump($req);die();
				
				// try {
				$response = $this->clients->post(
					$this->endpoint.'adminantrian/ambilantriannonregister',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$req
					]
				)->getBody()->getContents();
				$response = json_decode($response);
				// var_dump($response);die();
				$kodebooking = '';
				if(isset($response->response->kodebooking))
				{
					$kodebooking = $response->response->kodebooking;
				}
				if($kodebooking == '')
				{
					var_dump($response);die();
				}
				// insert task id 1
				$antrol1 = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/1'
				)->getBody()->getContents());
				// insert task id 2
				$antrol2 = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/2'
				)->getBody()->getContents());
				// insert task id 3
				$antrol = json_decode($this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/3'
				)->getBody()->getContents());


				// update noreservasi -> kodebooking kedalam daftar_ulang_irj
				$this->rjmregistrasi->updatenoreservasi($id->no_register,$kodebooking);
			}
 
			
		}

		
		// die();
		//  end
		if ($this->input->post('cetak_kartu') == '1') {
			$this->insert_tindakan_kartu($datat);
			$no_cm = $this->input->post('cetak_kartu1');
		}
		 $this->input->post('extra') != '1' ? $this->insert_tindakan($datat) : null;
		$no_register = $id->no_register;

		$notification = '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						<h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<hr style="margin-top: 5px;">
									
									
									<button class="btn waves-effect waves-light btn-primary" type="button" onclick="cetak_identitas(\'' . $register['no_medrec'] . '\')"><i class="fa fa-print"></i> Cetak Identitas Pasien</button>
									<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_tracer(\'' . $no_register . '\',\'' . $register['jns_kunj'] . '\')"><i class="fa fa-print"></i> Cetak Tracer</button>
									<button class="btn waves-effect waves-light btn-warning" type="button" onclick="cetak_registrasi(\'' . $no_register . '\',\'' . $register['no_medrec'] . '\')"><i class="fa fa-print"></i> Cetak Registrasi Pasien</button>
									
									
									
									';

		$notification .= $register['cara_bayar'] == 'BPJS' ? '<button class="btn waves-effect waves-light btn-info" type="button" onclick="create_sep(\'' . $no_register . '\')"><i class="fa fa-print"></i> Cetak SEP</button>' : '';
		$notification .= '
								</div>
							</div>
						</div>
					</div>';

		// cek jika ada antrol -> maka keluarkan hasil antrol kedalam notifikasi alert
		if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
			$notification .= '
				<div class="alert alert-warning" role="alert">
				Task ID 3 : '.$antrol->metadata->message.'
				</div>
			';
		}

		if($this->input->post('antrol') != ''  && $this->input->post('antrol') != null){
			$notification .= '
				<div class="alert alert-warning" role="alert">
				Task ID 3 : '.$antrol->metadata->message.'
				</div>
			';
		}


		$this->session->set_flashdata('success_msg', $notification);
		redirect('irj/rjcregistrasi/');
	}

	public function insert_daftar_ulang_new()
	{
		date_default_timezone_set('Asia/Jakarta');
		$register = $this->input->post();
		$register['id_poli'] = substr($register['id_poli'], 0, 4);
		//var_dump($register['tgl_kunjungan']);die();

		$cek_data_poli=$this->rjmregistrasi->cek_data_poli($register['no_medrec'])->row();
		$cekpoli = substr($register['id_poli'], 0, 4);
		// var_dump($cek_data_poli);die();

		if (isset($cek_data_poli) && $cekpoli !='BA00' && $cekpoli == $cek_data_poli->id_poli) {
			$data_poli = $cek_data_poli->nm_poli;
			$notification = '<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	Pasien sudah terdaftar pada poli "'.$cek_data_poli->nm_poli.'" 
                            	pada tanggal "'.date_indo(date('Y-m-d',strtotime($cek_data_poli->tgl_kunjungan))).'|'.date_indo(date('h:i',strtotime($cek_data_poli->tgl_kunjungan))).'"<br>
                            	Silahkan daftarkan pada poli yang berbeda.
                       		</div>';
			$this->session->set_flashdata('notification', $notification);			
			redirect('irj/rjcregistrasi/daftarulangnew/'.$register['no_medrec']);					
		} else {


				/**
				 * Penambahan tgl kunjungan karena butuh time juga
				 */
				$register['tgl_kunjungan'] .= ' ' . date('H:i:s');
				if ($register['id_kontraktor'] == '') {
					$register['id_kontraktor'] = null;
				}
				/**
				 * Cek Konsultasi nanti
				 * notes dari aldi
				 * kalo ada apa apa tanyain sadja
				 */

				// $check_konsul_nanti = $this->rjmpelayanan->check_register_konsul_nanti($register['no_medrec'])->result();
				// if(count($check_konsul_nanti)>0){
				// 	$data['no_register_lama'] = $check_konsul_nanti[0]->no_register;
				// 	$up_du['konsul_nanti'] = "0";
				// 	$this->rjmpelayanan->update_konsul_nanti($up_du,$data['no_register_lama']);
				// }

					$umur = $this->generate_umur($register['no_medrec']);
					$login_data = $this->load->get_var("user_info");
					$register['xuser'] = $login_data->userid;
					$register['xcreate'] = $login_data->username;
					$register['umurrj'] = $umur[0];
					$register['ublnrj'] = $umur[1];
					$register['uharirj'] = $umur[2];
					$register['id_poli'] = substr($register['id_poli'], 0, 4);
					$register['id_dokter'] = explode('-', $register['id_dokter'])[0];
					$register['diagnosa'] = isset($register['diagnosa']) ? explode('@', $register['diagnosa'])[0] : '';
					$register['biayadaftar'] = 0;
					$register['vtot'] = 0;
					$register['xupdate'] = date('Y-m-d H:i:s');
					$register['em'] = $register['id_poli'] == 'ME00' ? 1 : null;
					$register['lab'] = $register['id_poli'] == 'HA00' ? 1 : null;
					$register['rad'] = $register['id_poli'] == 'LA00' ? 1 : null;
					$register['noreg_asal_konsul'] = $this->input->post('noreg_asal_konsul');
					unset(
						$register['kekhususan_lainnya'],
						$register['kelasrawat'],
						$register['asalrujukan'],
						$register['tglrujukan'],
						$register['ppkrujukan'],
						$register['tujuan_kunj'],
						$register['flag_procedure'],
						$register['kd_penunjang'],
						$register['assesment_pel'],
						$register['nosurat_skdp_sep'],
						$register['dpjp_suratkontrol'],
						$register['no_telp'],
						$register['catatan'],
						$register['no_bpjs'],
						$register['alber'],
						$register['pasdatDg'],
						$register['jenis_kecelakaan'],
						$register['dokter_bpjs'],
						$register['id_diagnosa'],
						$register['cetak_kartu1'],
						$register['namafaskes'],
						$register['prb'],
						$register['katarak'],
						$register['cetak_kartu'],
						$register['ppkrujukan_jarkomdat'],
						$register['reservasi']
					);
						// cek jika ada antrol -> maka masukan kodebooking kedalam sistem ekamek daftar_ulang(noreservasi)
						if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
							$register['noreservasi'] = $this->input->post('reservasi');
						}
						$id = $this->rjmregistrasi->insert_daftar_ulang($register);
						// var_dump($register);die();
						$datat['no_register'] = $id->no_register;

						if($register['id_poli']=='BZ04'){ //lab
							$data4['lab']=1;
							$data4['status_lab']=0;
							$data4['jadwal_lab']=date("Y-m-d H:i:s");
							$data4['tgl_pulang']=date("Y-m-d");
							$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$datat['no_register']);
						}else if($register['id_poli']=='BZ02'){ //rad
							$data4['rad']=1;
							$data4['status_rad']=0;
							$data4['jadwal_rad']=date("Y-m-d H:i:s");
							$data4['tgl_pulang']=date("Y-m-d");
							$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$datat['no_register']);
						}

						if($register['noreg_asal_konsul'] != ""){
							$data_konsul['no_reg_new'] = $datat['no_register'];
							$data_konsul['daftar'] = 1;
							$this->rjmpelayanan->update_lembar_konsul_pasien($register['noreg_asal_konsul'],$data_konsul);
						}

				if ($register['cara_bayar'] == 'BPJS') {
					$datainput = $this->input->post();
					if (isset($datainput['ppkrujukan_jarkomdat'])) {
						$datainput['ppkrujukan'] = $datainput['ppkrujukan_jarkomdat'];
					}
					$input = [
						'no_medrec' => $datainput['no_medrec'],
						'tgl_sep' => $datainput['tgl_kunjungan'],
						'no_register' => $id->no_register,
						'no_kartu' => $datainput['no_bpjs'],
						'kelasrawat' => $datainput['kelasrawat'],
						'asalrujukan' => $datainput['asalrujukan'],

						// added for sep jamkordat
						'tglrujukan' => $datainput['cara_kunj'] != 'DATANG SENDIRI' ? $datainput['tglrujukan'] : ($datainput['tglrujukan'] == $datainput['tgl_kunjungan'] ? $datainput['tglrujukan'] : $datainput['tgl_kunjungan']),
						// end
						'norujukan' => $datainput['no_rujukan'],
						'ppkrujukan' => explode('@', $datainput['ppkrujukan'])[0],
						'diagawal' => explode('@', $datainput['diagnosa'])[0],
						'politujuan' => explode('~', $datainput['id_poli'])[1],
						'tujuankunj' => $datainput['tujuan_kunj'],
						'flagprocedure' => $datainput['flag_procedure'] ?? '',
						'kdpenunjang' => $datainput['kd_penunjang'] ?? '',
						'assesmentpel' => $datainput['assesment_pel'] ?? '',
						'nosurat' => $datainput['nosurat_skdp_sep'] ?? '',
						'dpjpsurat' => $datainput['dpjp_suratkontrol'] ?? '',
						'dpjplayan' => $datainput['dpjp_suratkontrol'] != '' || $datainput['dpjp_suratkontrol'] != null ? $datainput['dpjp_suratkontrol'] : explode('-', $datainput['dokter_bpjs'])[0],
						'namadokter' => explode('-', $datainput['dokter_bpjs'])[1],
						'namafaskes' => $datainput['namafaskes'],
						'user' => $datainput['xcreate'],
						'notelp' => $datainput['no_telp'],
						'catatan' => $datainput['catatan'],
						'prb' => $datainput['prb'],
						'katarak' => $datainput['katarak'] ?? "0",
					];
					$this->register_bpjs($input);
				}
				$pokpoli = $this->input->post('id_poli');
				$datat['id_poli'] = substr($pokpoli, 0, 4);
				$datat['jenis_pasien'] = $this->input->post('jns_kunj');
				$datat['cara_bayar'] = $this->input->post('cara_bayar');
				$datat['cara_dtg'] = $this->input->post('cara_dtg');

				/**
				 * Penambahan Jika insert via online (online & ANTROL)
				 * 
				 * @aldi
				 */
				// var_dump($register);die();
				if ($this->input->post('online') == "1") {
					$onlinenya = $this->checkinpasienonline($register['noreservasi'], $register['no_medrec']);
				}
				// cek jika ada antrol -> maka update task id ke 3
				// decode json dan masukan ke variabel antrol
				// Penambahan untuk keperluan antrian online update task id ke 3 
				// if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
				// 	$antrol = json_decode($this->clients->get(
				// 		$this->endpoint .'adminantrian/prosesantrian/'.$this->input->post('reservasi').'/3'
				// 	)->getBody()->getContents());
				// }
				// die();
				//  end
				if ($this->input->post('cetak_kartu') == '1') {
					$this->insert_tindakan_kartu($datat);
					$no_cm = $this->input->post('cetak_kartu1');
				}
				$this->input->post('extra') != '1' ? $this->insert_tindakan($datat) : null;
				$no_register = $id->no_register;

				$notification = '<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								<h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<hr style="margin-top: 5px;">
											
											
											<button class="btn waves-effect waves-light btn-primary" type="button" onclick="cetak_identitas(\'' . $register['no_medrec'] . '\')"><i class="fa fa-print"></i> Cetak Identitas Pasien</button>
											<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_tracer(\'' . $no_register . '\',\'' . $register['jns_kunj'] . '\')"><i class="fa fa-print"></i> Cetak Tracer</button>
											<button class="btn waves-effect waves-light btn-warning" type="button" onclick="cetak_registrasi(\'' . $no_register . '\',\'' . $register['no_medrec'] . '\')"><i class="fa fa-print"></i> Cetak Registrasi Pasien</button>
											
											
											
											';

				$notification .= $register['cara_bayar'] == 'BPJS' ? '<button class="btn waves-effect waves-light btn-info" type="button" onclick="create_sep(\'' . $no_register . '\')"><i class="fa fa-print"></i> Cetak SEP</button>' : '';
				$notification .= '
										</div>
									</div>
								</div>
							</div>';

				// cek jika ada antrol -> maka keluarkan hasil antrol kedalam notifikasi alert
				if($this->input->post('reservasi') != ''  && $this->input->post('reservasi') != null){
					$notification .= '
						<div class="alert alert-warning" role="alert">
						Task ID 3 : '.$antrol->metadata->message.'
						</div>
					';
				}


				$this->session->set_flashdata('success_msg', $notification);
				redirect('irj/rjcregistrasi/');
		}
	}

	public function insert_daftar_ulang()
	{
		$nomedrec = $this->input->post('no_medrec');
		// sediain variable untuk menampung pesan
		$message = '';
		$redirect = 'irj/rjcregistrasi/daftarulang/' . $nomedrec;

		// ini buat konsultasi nanti
		$check_konsul_nanti = $this->rjmpelayanan->check_register_konsul_nanti($nomedrec)->result();
		if (count($check_konsul_nanti) > 0) {
			$data['no_register_lama'] = $check_konsul_nanti[0]->no_register;
			$up_du['konsul_nanti'] = "0";
			$this->rjmpelayanan->update_konsul_nanti($up_du, $data['no_register_lama']);
		}

		if ($this->input->post('cara_bayar') == "BPJS") {
			if ($this->input->post('nosurat_skdp_sep')) {

				$check_dpjp_sebelumnya = $this->rjmregistrasi->getiddpjpsebelumnya($this->input->post('no_medrec'));
				// cek jika ada dpjp sebelumnya, maka ambil dpjp itu di daftar_ulang_irj
				if ($check_dpjp_sebelumnya) {
					$dpjp = $check_dpjp_sebelumnya->dpjp_skdp_sep;
					$id_dokter = $check_dpjp_sebelumnya->id_dokter;
				} else {

					// 3 items inputan didapet dari db kita , sedangkan 2 items itu didapet dari server bpjs
					// dpjp_skdp_sep, inputan dari user itu ada 3 opsi
					// 1. id_dokter-kodedpjp-namadokter (3 items) 
					// 2. id_dokter-null value kodedpjp - namadokter (tetep 3 items , null value <-- dianggap ada)
					// 3. kodedpjp - namadokter // (2 items)
					$grab_data = $this->input->post('dpjp_skdp_sep');
					$check_inputan = explode('-', $grab_data); // split jadi array untuk pengambilan data nya

					// jika inputan user ada 3 items dan posisi array ke 2 tidak null value
					if (count($check_inputan) == 3 && $check_inputan[1] != "") {
						// ambil kode dpjp yang posisi ke 2 , itu normal
						$dpjp = $check_inputan[1];
						$id_dokter = $check_inputan[0];
					}

					// jika inputan user ada 3 items dan posisi array ke 2 null value
					elseif (count($check_inputan) == 3 && $check_inputan[1] == "") {

						// balik lagi ke user , dan tambahin kode dpjp di dokter
						$notification = '<div class="alert alert-danger" role="alert">
						ID Dokter DPJP Kosong , Silahkan Isi Terlebih Dahulu Di Master Dokter!
					  </div>';

						$this->session->set_flashdata('success_msg', $notification);
						redirect('irj/rjcregistrasi/daftarulang/' . $this->input->post('no_medrec'), $notification);
					}

					// jika inputan ke user ada 2 items , maka ambil dpjp di posisi yang pertama;
					elseif (count($check_inputan) == 2) {
						$dpjp = $check_inputan[0];
						$id_dokter = $this->rjmregistrasi->getDataDokterByIdDokter2($check_inputan[0])->row()->id_dokter;
					}
				}
			}

			// jika input surat kontrol tidak ada maka kesini
			else {
				// 3 items inputan didapet dari db kita , sedangkan 2 items itu didapet dari server bpjs
				// dpjp_skdp_sep, inputan dari user itu ada 3 opsi
				// 1. id_dokter-kodedpjp-namadokter (3 items) 
				// 2. id_dokter-null value kodedpjp - namadokter (tetep 3 items , null value <-- dianggap ada)
				// 3. kodedpjp - namadokter // (2 items)
				$grab_data = $this->input->post('dpjp_skdp_sep');
				if ($grab_data) {
					$check_inputan = explode('-', $grab_data); // split data menjadi array
					// var_dump($check_inputan);die();

					// cek jika inputan user 3 dan kode dpjp tidak null value ( posisi ke 2 )
					if (count($check_inputan) == 3 && $check_inputan[1] != "") {
						$dpjp = $check_inputan[1]; //ambil data dpjp di posisi ke 2
						$id_dokter = $check_inputan[0];
					}
					// kalo null value di posisi kedua dan inputan user ada 3 maka return balik ke user suruh input manual dpjp nya di master dokter
					elseif (count($check_inputan) == 3 && $check_inputan[1] == "") {
						$notification = '<div class="alert alert-danger" role="alert">
						ID Dokter DPJP Kosong , Silahkan Isi Terlebih Dahulu Di Master Dokter!
					  </div>';

						$this->session->set_flashdata('success_msg', $notification);
						redirect('irj/rjcregistrasi/daftarulang/' . $this->input->post('no_medrec'), $notification);
					}

					// kalo inputan user ada 2 maka dpjp ambil di posisi pertama
					elseif (count($check_inputan) == 2) {
						$dpjp = $check_inputan[0];
						$id_dokter = $this->rjmregistrasi->getDataDokterByIdDokter2($check_inputan[0])->row()->id_dokter;
					}
				}
				// dpjp ga diisi , berarti kode nya ambil di id_dokter
				else {
					// var_dump($check_inputan);die();
					$grab_data = $this->input->post('id_dokter');
					$check_inputan = explode('-', $grab_data);
					// cek jika inputan user 3 dan kode dpjp tidak null value ( posisi ke 2 )
					if (count($check_inputan) == 3 && $check_inputan[1] != "") {
						$dpjp = $check_inputan[1]; //ambil data dpjp di posisi ke 2
						$id_dokter = $check_inputan[0];
					}
					// kalo null value di posisi kedua dan inputan user ada 3 maka return balik ke user suruh input manual dpjp nya di master dokter
					elseif (count($check_inputan) == 3 && $check_inputan[1] == "") {
						$notification = '<div class="alert alert-danger" role="alert">
						ID Dokter DPJP Kosong , Silahkan Isi Terlebih Dahulu Di Master Dokter!
					  </div>';

						$this->session->set_flashdata('success_msg', $notification);
						redirect('irj/rjcregistrasi/daftarulang/' . $this->input->post('no_medrec'), $notification);
					}

					// kalo inputan user ada 2 maka dpjp ambil di posisi pertama
					elseif (count($check_inputan) == 2) {
						$dpjp = $check_inputan[0];
						$id_dokter = $this->rjmregistrasi->getDataDokterByIdDokter2($check_inputan[0])->row()->id_dokter;
					}
				}
			}
		}
		if ($this->input->post('kekhususan_lainnya') != "") {
			$data['kekhususan'] = $this->input->post('kekhususan_lainnya');
		} else {
			$data['kekhususan'] = $this->input->post('kekhususan');
		}

		$no_medrec = $this->input->post('no_medrec');
		$no_rujukan = $this->input->post('no_rujukan');
		$no_kartu = $this->input->post('no_bpjs');
		// kalo di data pasien gaada no kartu maka update no kartu;
		$check_data_pasien = $this->rjmregistrasi->check_data_pasien($no_medrec);
		if (!$check_data_pasien->row()->no_kartu) {
			$update_pasien['no_kartu'] = $no_kartu;
			$this->rjmregistrasi->update_data_pasien($no_medrec, $update_pasien);
		}
		// ini buat cek pasien ada apa engga di poli
		$cek_data_poli = $this->rjmregistrasi->cek_data_poli($no_medrec)->result();
		if ($cek_data_poli != null) {
			if (substr($this->input->post('id_poli'), 0, 4) == $key->id_poli) {
				$message .= "pasien sudah terdaftar di poli hari ini";
				$this->balik_ke_awal($message, $redirect);
			}
		}
		if ($this->input->post('cara_bayar') == null) {
			$message .= "Silahkan Isi Data Yang Berbintang (*) Dengan Lengkap";
			$this->balik_ke_awal($message, $redirect);
		}

		$umur = $this->generate_umur($nomedrec);
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->userid;
		$data['umurrj'] = $umur[0];
		$data['ublnrj'] = $umur[1];
		$data['uharirj'] = $umur[2];
		$data['no_medrec'] = $no_medrec;
		$data['jns_kunj'] = $this->input->post('jns_kunj');
		$data['cara_kunj'] = $this->input->post('cara_kunj');
		$data['catatan'] = $this->input->post('entri_catatan');
		$data['kll_penjamin'] = $this->input->post('kll_penjamin') ? implode(',', $this->input->post('kll_penjamin')) : null;
		$data['katarak'] = $this->input->post('katarak') == 1 ? 1 : 0;
		$data['nosurat_skdp_sep'] = $this->input->post('nosurat_skdp_sep');
		$data['dpjp_skdp_sep'] = $dpjp ?? "";
		$data['no_rujukan'] = $this->input->post('no_rujukan');
		$data['kelas_pasien'] = $this->input->post('kelas_pasien');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['id_kontraktor'] = $this->input->post('id_kontraktor');
		if (explode('@', $this->input->post('diagnosa'))[0] == "") {
			$data['diagnosa'] = $this->input->post('id_diagnosa');
		} else {
			$data['diagnosa'] = explode('@', $this->input->post('diagnosa'))[0];
		}

		$pokpoli = $this->input->post('id_poli');
		$data['id_poli'] = substr($pokpoli, 0, 4);
		$data['id_dokter'] = $this->input->post('cara_bayar') == "BPJS" ? $id_dokter : explode('-', $this->input->post('id_dokter'))[0];
		$data['biayadaftar'] = 0;
		$data['nama_penjamin'] = $this->input->post('nama_penjamin');
		$data['hubungan'] = $this->input->post('hubungan');
		$data['vtot'] = 0;
		//$data['xcreate']=$this->input->post('user_name');
		$data['xcreate'] = $login_data->username;
		$data['atas_nama'] = $this->input->post('atas_nama');
		$data['tgl_kunjungan'] = date('Y-m-d H:i:s');

		$data['xupdate'] = date('Y-m-d H:i:s');
		$data['kode_faskes_perujuk'] = $this->input->post('kode_faskes_perujuk');
		$data['nama_faskes_perujuk'] = $this->input->post('nama_faskes_perujuk');
		$data['em'] = $data['id_poli'] == 'ME00' ? 1 : null;
		$data['lab'] = $data['id_poli'] == 'HA00' ? 1 : null;
		$data['rad'] = $data['id_poli'] == 'LA00' ? 1 : null;
		$id = $this->rjmregistrasi->insert_daftar_ulang($data);
		$datat['no_register'] = $id->no_register;
		$datat['id_poli'] = substr($pokpoli, 0, 4);
		$datat['jenis_pasien'] = $this->input->post('jns_kunj');
		$datat['cara_bayar'] = $this->input->post('cara_bayar');

		if ($this->input->post('cetak_kartu') == '1') {
			$this->insert_tindakan_kartu($datat);
			$no_cm = $this->input->post('cetak_kartu1');
		}
		// $this->input->post('extra') != '1' ? $this->insert_tindakan($datat) : null;
		$no_register = $id->no_register;
		// redirect('bpjs/sep/create/'.$no_register)
		$notification = '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						<h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<hr style="margin-top: 5px;">
									<button class="btn waves-effect waves-light btn-primary" type="button" onclick="cetakKartu(\'' . $no_medrec . '\')"><i class="fa fa-print"></i> Cetak Kartu Berobat</button>
									<button class="btn waves-effect waves-light btn-danger" type="button" onclick="tindakan(\'' . $datat['id_poli'] . '\',\'' . $no_register . '\')"><i class="fa fa-print"></i>Input Tindakan</button>
									<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_label(\''  . $no_register . '\')"><i class="fa fa-print"></i>Cetak Label</button>
									<button class="btn waves-effect waves-light btn-primary" type="button" onclick="cetak_identitas(\'' . $no_medrec . '\')"><i class="fa fa-print"></i> Cetak Identitas Pasien</button>
									<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_tracer(\'' . $no_register . '\',\'' . $data['jns_kunj'] . '\')"><i class="fa fa-print"></i> Cetak Tracer</button>

								</div>
							</div>
						</div>
					</div>';


		$this->session->set_flashdata('success_msg', $notification);
		redirect('irj/rjcregistrasi/');
	}

	public function sep_print($fields)
	{
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars = $this->config->item('namars');
		$alamatrs = $this->config->item('alamat');
		$telprs = $this->config->item('telp');
		$kota = $this->config->item('kota');
		$nmsingkat = $this->config->item('nmsingkat');

		// foreach($data_identitas as $row){
		$konten = "<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: " . $fields['No. SEP'] . "</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: " . $fields['Tgl. SEP'] . "</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: " . $fields['No. Kartu'] . " MR: " . $fields['No. Medrec'] . "</td>
						<td>Peserta</td>
						<td>: " . $fields['Peserta'] . "</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: " . $fields['Nama Peserta'] . "</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: " . $fields['Tgl. Lahir'] . "</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: " . $fields['Jenis Kelamin'] . "</td>
						<td>Jenis Rawat</td>
						<td>: " . $fields['Jenis Rawat'] . "</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: " . $fields['Poli Tujuan'] . "</td>
						<td>Kelas Rawat</td>
						<td>: " . $fields['Kelas Rawat'] . "</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: " . $fields['Asal Faskes'] . "</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: " . $fields['Diagnosa Awal'] . "</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: " . $fields['Catatan'] . "</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke " . $fields['Cetakan Ke'] . "</td>
						<td>: " . $date->format('d-m-Y H:i:s') . "</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
		$file_name = "sep_" . $fields['No. Register'] . ".pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5'); //left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/irj/sjp/' . $file_name, 'FI');
	}
	public function pasien_bpjs($no_register = '')
	{
		$data['title'] = 'Daftar Pasien Rawat Jalan';
		$data['message'] = $this->session->flashdata('message');

		if ($no_register == '') {
			$data['daftar_pasien'] = $this->rjmregistrasi->get_daftar_pasien()->result();
			$this->console_log($data['daftar_pasien']);
			$this->load->view('irj/rjvformdaftarbpjs', $data);
		} else {
			$data['detail_pasien'] = $this->rjmregistrasi->get_detail_daful($no_register)->result();
			$data['prop'] = $this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung'] = $this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk'] = $this->rjmpencarian->get_ppk()->result();
			$data['kelas'] = $this->rjmpencarian->get_kelas()->result();
			$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();
			$data['cara_bayar'] = $this->rjmpencarian->get_cara_bayar()->result();

			$data['dokter'] = $this->rjmpencarian->get_dokter()->result();
			$data['kontraktor'] = $this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();

			$this->load->view('irj/rjvformdaful', $data);
		}
	}
	public function insert_pasien_bpjs()
	{
		//get umur
		$no_medrec = $this->input->post('no_medrec');
		$no_register = $this->input->post('no_register');
		$get_umur = $this->rjmregistrasi->get_umur($no_medrec)->result();
		$tahun = 0;
		$bulan = 0;
		$hari = 0;
		foreach ($get_umur as $row) {
			// echo $row->umurday;
			$tahun = floor($row->umurday / 365);
			$bulan = floor(($row->umurday - ($tahun * 365)) / 30);
			$hari = $row->umurday - ($bulan * 30) - ($tahun * 365);
		}

		$data['umurrj'] = $tahun;
		$data['uharirj'] = $hari;
		$data['ublnrj'] = $bulan;
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunj') . " " . date('H:i:s');

		$data['jns_kunj'] = $this->input->post('jns_kunj');
		$data['cara_kunj'] = $this->input->post('cara_kunj');

		if ($this->input->post('asal_rujukan') != '') {
			$data['asal_rujukan'] = $this->input->post('asal_rujukan');
		}

		if ($this->input->post('dll_rujukan') != '') {
			$data['asal_rujukan'] = $this->input->post('dll_rujukan');
		}

		if ($this->input->post('no_rujukan') != '') {
			$data['no_rujukan'] = $this->input->post('no_rujukan');
		}

		$data['tgl_rujukan'] = $this->input->post('tgl_rujukan');
		$data['kelas_pasien'] = $this->input->post('kelas_pasien');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		if ($this->input->post('jenis_kontraktor') != '') {
			$data['id_kontraktor'] = $this->input->post('jenis_kontraktor');
		}
		$data['diagnosa'] = $this->input->post('id_diagnosa');
		$data['id_poli'] = $this->input->post('id_poli');
		$data['id_dokter'] = $this->input->post('id_dokter');
		$data['nama_penjamin'] = $this->input->post('nama_penjamin');
		$data['hubungan'] = $this->input->post('hubungan');
		$data['vtot'] = 0;
		//$data['no_sep']=$this->input->post('no_sep');
		$data['xuser'] = $this->input->post('user_name');
		$data['no_sep'] = $this->input->post('no_sep');


		$id = $this->rjmregistrasi->update_daftar_ulang($no_register, $data);

		if ($data['cara_bayar'] == "BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">

									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>

									Daftar ulang pasien berhasil. &nbsp;<a href="' . site_url('irj/rjcregistrasi/buat_SEP/' . $no_register) . '" class="btn btn-danger">Cetak SEP</a>
									</h4>
								</div>
							</div>
						</div>';
		} else {
			$success = 	'

						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>

									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.

									</h4>
								</div>
							</div>
						</div>';
		}

		$this->session->set_flashdata('success_msg', $success);

		redirect('irj/rjcregistrasi/pasien_bpjs/' . $no_register, 'refresh');
	}

	public function rekap_tracer()
	{
		$data['title'] = 'Daftar Rekap Tracer Pasien Poli';
		$date = $this->input->post('date');
		if ($date != '') {
			$data['date'] = date('Y-m-d', strtotime($date));
			$data['pasien_tracer'] = $this->rjmregistrasi->get_pasien_tracer($date)->result();
		} else {
			$data['pasien_tracer'] = $this->rjmregistrasi->get_pasien_tracer(date('Y-m-d'))->result();
		}
		$this->load->view('irj/rjvformrekaptracer', $data);
	}


	//CETAK KARCIS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_tracer_old($no_register = '')
	{
		if ($no_register != '') {
			/*$get_nokarcis=$this->rjmkwitansi->get_new_nokarcis($no_register)->result();
				foreach($get_nokarcis as $val){
					$noseri_karcis=sprintf("B%s%05s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_nokarcis($noseri_karcis,$no_register);
			*/
			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			$namars = $this->config->item('namars');
			$alamatrs = $this->config->item('alamat');
			$kota = $this->config->item('kota');
			$nmsingkat = $this->config->item('nmsingkat');

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");



			$data_tracer = $this->rjmregistrasi->getdata_tracer($no_register)->result();
			foreach ($data_tracer as $row) {
				if ($row->sex == 'L') {
					$sex = 'Laki-laki';
				} else {
					$sex = 'Perempuan';
				}
				$no_medrec = $row->no_medrec;
				$txtperusahaan = '';
				if ($row->nmkontraktor != '') {
					if ($row->cara_bayar == 'BPJS') {
						$txtperusahaan = $row->nmkontraktor;
					} else $txtperusahaan = $row->cara_bayar . " - " . $row->nmkontraktor;
				} else $txtperusahaan = 'UMUM';
				$konten =
					"<style type=\"text/css\">
					.table-font-size{
							font-size:14px;
					    }
					</style>					
					$namars | $alamatrs
					
					<h1 style=\"font-size:15px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<u>No. Antrian</u>&nbsp; &nbsp;&nbsp;: $row->no_antrian</h1><br/>
					<table class=\"table-font-size\">
						<tr>
							<td width=\"20%\"><h4>No. MR</h4></td>
							<td width=\"5%\"> : </td>
							<td width=\"30%\"><b>$row->no_cm</b></td>
							<td >Pasien</td>
							<td width=\"5%\"> : </td>
							<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>							
						</tr>
						<tr>
							<td>Tgl Registrasi</td>
							<td> : </td>
							<td><b>" . date('d-m-Y', strtotime($row->tgl_kunjungan)) . " | " . date('H:i:s', strtotime($row->tgl_kunjungan)) . "</b></td>
							
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
							
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nama</b></td>
						</tr>												
						<tr>
							<td>Unit Tujuan</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nm_poli</b></td>
						</tr>
						
						<tr>
							<td>Tgl Lahir</td>
							<td> : </td>
							<td>" . date('d-m-Y', strtotime($row->tgl_lahir)) . "</td>
						</tr>
						<tr>
							<td>Umur</td>
							<td> : </td>
							<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
						</tr>
						<tr>
							<td>Kelamin</td>
							<td> : </td>
							<td >$sex</td>
						</tr>";

				if ($this->rjmregistrasi->getdata_before($no_medrec, $no_register)->num_rows() > 0) {
					$data_tracer = $this->rjmregistrasi->getdata_before($no_medrec, $no_register)->result();
					foreach ($data_tracer as $row1) {
						if ($row1->ket_pulang != 'PULANG' and $row1->ket_pulang != '') {
							$txtpulang = '| ' . $row1->ket_pulang;
						} else $txtpulang = '';

						$konten1 = "<tr>
									<td>Unit & Kunjungan Lalu</td>
									<td> : </td>
									<td colspan=\"4\">" . date('d-m-Y', strtotime($row1->tgl_kunjungan)) . " | $row1->nm_poli $txtpulang</td>
								</tr>";
					}
				} else $konten1 = "<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>";

				$login_data = $this->load->get_var("user_info");
				if ($login_data->name == '' || $login_data->name == null) {
					$user = $login_data->username;
				} else $user = $login_data->name;

				$konten = $konten . "$konten1<tr>
							<td>Petugas</td>
							<td> : </td>
							<td colspan=\"2\">" . $user . "</td>
						</tr>						
						<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
					</table><br>
					<hr/>
					<br>
				";
			}
			print_r($konten);
			$konten1 = $konten . "<br>" . $konten . "<br>" . $konten;
			$file_name = "Tracer_$no_register.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('5', '5', '5'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '2');
			$obj_pdf->SetFont('helvetica', '', 7);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten1;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . '/download/irj/rjtracer/' . $file_name, 'FI');
		} else {
			redirect('irj/rjcregistrasi', 'refresh');
		}
	}

	public function cetak_tracer($no_register = '')
	{
		error_reporting(~E_ALL);
		if ($no_register != '') {
			$namars = $this->config->item('namars');
			$alamatrs = $this->config->item('alamat');
			$kota = $this->config->item('kota');
			$nmsingkat = $this->config->item('nmsingkat');

			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");



			$data_tracer = $this->rjmregistrasi->getdata_tracer($no_register)->result();
			foreach ($data_tracer as $row) {
				if ($row->sex == 'L') {
					$sex = 'Laki-laki';
				} else {
					$sex = 'Perempuan';
				}
				$no_medrec = $row->no_medrec;
				$txtperusahaan = '';
				if ($row->cara_bayar != 'UMUM') {
					$txtperusahaan = "BPJS " . $row->nmkontraktor;
				} else $txtperusahaan = 'UMUM';
				$konten =
					"<style type=\"text/css\">
					.table-font-size{
							font-size:10px;
					    }
					</style>					
					$namars | $alamatrs
					
					<br/>
					<table class=\"table-font-size\" style=\"text-align:center;\">
							<tr>
							<td style=\"font-size:22px;font-weight:bold;\">$row->no_antrian</td>
							</tr>
						</table>
						<br>
					<table class=\"table-font-size\">	
						<tr>
							<td width=\"32%\"></td>
							<td width=\"5%\"></td>
							<td width=\"52%\"></td>
							=======================================
						</tr>
						
						<tr>
							<td></td>
							<td></td>
							<td></td>							
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							
						</tr>

						<tr>
							<td >No. Registrasi</td>
							<td > : </td>
							<td >$row->no_register</td>
						</tr>					
																
						<tr>
							<td>Tgl Jam</td>
							<td> : </td>
							<td>" . date('d-m-Y', strtotime($row->tgl_kunjungan)) . " | " . date('H:i:s', strtotime($row->tgl_kunjungan)) . "</td>
							
						</tr>						
						<tr>
							<td>No. RM</td>
							<td> : </td>
							<td><b>" . $row->no_cm . "</b></td>
							
						</tr>";

				$konten3 = "<tr>
							<td>Nama</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nama</b></td>
						</tr>	
						
						<tr>
							<td>Tgl Lahir</td>
							<td> : </td>
							<td>" . date('d-m-Y', strtotime($row->tgl_lahir)) . "</td>
						</tr>


						<tr>
							<td>Layanan</td>
							<td> : </td>
							<td colspan=\"2\">$row->nm_poli</td>
						</tr>

						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td colspan=\"2\">$txtperusahaan</td>
						</tr>

						<tr>
							<td>Pendaftar</td>
							<td> : </td>
							<td colspan=\"2\">$row->xuser</td>
						</tr>";

				$login_data = $this->load->get_var("user_info");
				if ($login_data->name == '' || $login_data->name == null) {
					$user = $login_data->username;
				} else $user = $login_data->name;

				$konten = $konten . $konten3 . "
						<tr>
							<td>Petugas</td>
							<td> : </td>
							<td colspan=\"2\">" . $user . "</td>
						</tr>						
						<tr>
						=======================================
							<td width=\"18%\"></td>
							<td width=\"4%\"></td>
							<td width=\"78%\"></td>
							</tr>							

					</table>
				";
			}
			print_r($konten);
			$konten1 = $konten;
			$file_name = "Tracer_$no_register.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$width = 120;
			$height = 120;
			$pageLayout = array($width, $height);
			$obj_pdf = new TCPDF('P', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('5', '5', '5'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '0');
			$obj_pdf->SetFont('helvetica', '', 7);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten1;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . '/download/irj/rjtracer/' . $file_name, 'FI');
		} else {
			redirect('irj/rjcregistrasi', 'refresh');
		}
	}


	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_identitas($no_cm = '')
	{
		// var_dump($no_cm);die();
		// error_reporting(~E_ALL);
		// if(count$no_cm)
		// echo strlen($no_cm);
		if (strlen($no_cm) != 8) {
			$no_cm = sprintf("%08d", $no_cm);
			// echo $num_padded; // returns 04
			// die();
		}
		$cekdata = $this->rjmregistrasi->getdata_identitas($no_cm)->result();
		if ($cekdata == null) {
			$data['data_identitas'] = $this->rjmregistrasi->getdata_identitas_two($no_cm)->result();
		} else {
			$data['data_identitas'] = $this->rjmregistrasi->getdata_identitas($no_cm)->result();
		}
		$data['data_poli'] = $this->rjmregistrasi->get_daftar_ulang_irj_by_no_cm($no_cm)->result();
		$data['poliklinik_mana'] = '';
		$data['kekhususan'] = '';
		foreach ($data['data_poli'] as $value1) {
			// print_r($value1->nm_poli);
			// var_dump($value1);
			$data['kekhususan'] = $value1->kekhususan;
			$data['poliklinik_mana'] = $value1->nm_poli;
		}

		// HEADER
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;

		// $data['header_page'] = $top_header."<p align=\"center\">
		// <img src=\"assets/img/".$logo_kesehatan_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
		// </p>
		// </td>
		// <td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
		// <font style=\"font-size:12px\">
		// 	<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
		// </font>
		// <font style=\"font-size:11px\">
		// 	<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
		// 	<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
		// </font>    
		// <br>
		// <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
		// <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
		// </td>
		// <td width=\"13%\">
		// <p align=\"center\">
		// 	<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
		// </p>".$bottom_header;
		// 
		$this->load->view('RM_01', $data);
		return;


		if ($no_cm != '') {
			$namars = $this->config->item('namars');
			$alamatrs = $this->config->item('alamat');
			$telprs = $this->config->item('telp');
			$kota = $this->config->item('kota');
			$nmsingkat = $this->config->item('nmsingkat');

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");


			foreach ($data_identitas as $row) {
				$interval = date_diff(date_create(), date_create($row->tgl_lahir));
				$conf = $this->appconfig->get_headerpdf_appconfig($no_register)->result();

				$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
				$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
				$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
				$header_page = $top_header . $logo_header . $bottom_header . '<br><hr/>';



				$konten_header =
					"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					</style>
										
					";
				// $konten = $header_page;
				// echo $konten;die();
				$keluarga = '';
				$konten .=
					'<!DOCTYPE html>
			<html>
			
			<head>
				<title></title>
			</head>
			<style>
				#div1 {
					position: relative;
				}
			
				.header-parent {
					display: flex;
					justify-content: space-between;
			
				}
			
				.right {
					display: flex;
					align-items: flex-end;
					flex-direction: column;
					height: 50px;
					font-size: 12px;
				}
			
				.kotak {
			
					height: 10;
					width: 10;
				}
			
				.patient-info {
					padding: 1em;
					display: flex;
					border-radius: 10px;
				}
			
				#date {
					display: flex;
					justify-content: space-between;
				}
			
				.nomr {
					font-weight: bold;
					display: inline;
			
				}
			
				.kotak {
					float: left;
					width: 30px;
					height: 30px;
				}
			
				.judul {
					font-weight: bold;
					width: 250px;
					height: 50px;
					padding-top: 20px;
					padding-left: 20px;
					padding-right: 20px;
					text-align: center;
				}
			
				.content {
					padding-left: 15px;
					padding-top: 15px;
					padding-bottom: 15px;
				}
			
				.ttd {
					display: flex;
					flex-direction: column;
					justify-content: center;
					align-items: flex-end;
					margin-right: 50px;
				}
			
				#childttd {
					display: flex;
					flex-direction: column;
					align-items: center;
				}
			</style>
			<link rel="stylesheet" href="../assets/css/paper.css">
			
			<body class="A4">
					<p class="judul">
						FORMULIR PENDAFTARAN PASIEN BARU RAWAT JALAN/ GAWAT DARURAT
					</p>
				
				<div class="content">
					<p>Nama
						:.............................................................................................................................................................................................................................................
					</p>
					<p>Jenis Kelamin :
						<input type="checkbox" value="LK">
						<label for="LK">LK</label>
						<input type="checkbox" value="PR">
						<label for="PR">PR</label>
					</p>
					<p>Tempat & Tanggal Lahir
						:...............................................................................................................................................................................................................
					</p>
					<p>Agama :
						<input type="checkbox" value="Islam">
						<label for="Islam">Islam</label>
						<input type="checkbox" value="Kristen ">
						<label for="Kristen ">Kristen </label>
						<input type="checkbox" value="Katholik ">
						<label for="Katholik ">Katholik </label>
						<input type="checkbox" value="Hindu  ">
						<label for="Hindu  ">Hindu </label>
						<input type="checkbox" value="Budha   ">
						<label for="Budha  ">Budha </label>
						<input type="checkbox" value="Lainnya">
						<label for="Lainnya">Lainnya</label>
					</p>
					<p>Status Perkawinan :
						<input type="checkbox" value="Kawin ">
						<label for="Kawin ">Kawin </label>
						<input type="checkbox" value="Belum Kawin">
						<label for="Belum Kawin">Belum Kawin</label>
						<input type="checkbox" value="Janda">
						<label for="Janda">Janda</label>
						<input type="checkbox" value="Duda">
						<label for="Duda">Duda</label>
					</p>
					<p>Pekerjaan :
						<input type="checkbox" value="PNS/Pol/TNI">
						<label for="PNS/Pol/TNI">PNS/Pol/TNI</label>
						<input type="checkbox" value="Swasta">
						<label for="Swasta">Swasta</label>
						<input type="checkbox" value="Pelajar/Mahasiswa">
						<label for="Pelajar/Mahasiswa">Pelajar/Mahasiswa</label>
						<input type="checkbox" value="Dagang">
						<label for="Dagang">Dagang</label>
					<p style="padding-left: 50px;">
						<input type="checkbox" value="Buruh">
						<label for="Buruh">Buruh</label>
						<input type="checkbox" value="Ibu Rumah Tangga">
						<label for="Ibu Rumah Tangga">Ibu Rumah Tangga</label>
						<input type="checkbox" value="Lainnya">
						<label for="Lainnya">....................</label>
					</p>
					</p>
					<p>Pendidikan Terakhir :
						<input type="checkbox" value="Belum/Tdk Sekolah">
						<label for="Belum/Tdk Sekolah">Belum/Tdk Sekolah</label>
						<input type="checkbox" value="SD">
						<label for="SD">SD</label>
						<input type="checkbox" value="SLTP">
						<label for="SLTP">SLTP</label>
						<input type="checkbox" value="SLTA">
						<label for="SLTA">SLTA</label>
						<input type="checkbox" value="DIII">
						<label for="DIII">DIII</label>
						<input type="checkbox" value="DIV/S1">
						<label for="DIV/S1">DIV/S1</label>
					</p>
					<p>
						<span>
							Alamat Sesuai KTP
							:......................................................................................................................................................................................................................
						</span>
					<div style="padding-left: 130px;">
						<p>RT....... RW....... No.......</p>
						<p>Kelurahan
							.......................................................................................................................................................................................
						</p>
						<p>Kecamatan
							......................................................................................................................................................................................
						</p>
						<p>Kab/Kota
							........................................................................................................................................................................................
						</p>
						<p>Provinsi
							...........................................................................................................................................................................................
						</p>
						<p>No. Hp
							............................................................................................................................................................................................
						</p>
					</div>
			
					<p>Alamat Yang Bisa Dihubungi
						:.......................................................................................................................................................................................................
					</p>
					<p>Nama Suami/Istri Pasien
						:..............................................................................................................................................................................................................
					</p>
					<p>Nama Ayah Pasien
						:.......................................................................................................................................................................................................................
					</p>
					<p>Nama Ibu Pasien
						:..........................................................................................................................................................................................................................
					</p>
					<p>Poliklinik Yang Dituju
						:.................................................................................................................................................................................................................
					</p>
			
					<p>Bahasa se Hari-hari :
						<input type="checkbox" value="Indonesia ">
						<label for="Indonesia ">Indonesia </label>
						<input type="checkbox" value="Daerah">
						<label for="Daerah">Daerah</label>
						<input type="checkbox" value="Asing">
						<label for="Asing">Asing...............</label>
					</p>
			
					<p>Kekhususan :
						<input type="checkbox" value="Kereta Dorong">
						<label for="Kereta Dorong">Kereta Dorong</label>
						<input type="checkbox" value="Kursi Dorong">
						<label for="Kursi Dorong">Kursi Dorong</label>
						<input type="checkbox" value="Lainnya">
						<label for="Lainnya">Lainnya............</label>
					</p>
			
				</div>
				<div style="border: 1px solid;">
					<p style="font-weight: bold;text-align: center; font-size: 11px;">PERSETUJUAN UMUM</p>
					<ol>
						<li style="font-size: 11px;">Bahwa saya akan mentaati semua peraturan yang ada di Rumah Sakit Stroke
							Nasional Bukittinggi.</li>
						<li style="font-size: 11px;">Bahwa saya menyetujui untuk dilakukan pemeriksaan/ tindakan yang diperlakukan
							dalam upaya kesembuhan/ keselamatan jiwa saya/ pasien tersebut di atas.</li>
						<li style="font-size: 11px;">Bahwa saya memberi kuasa kepada dokter yang merawat untuk memberikan keterangan
							medis saya kepada pihak yang bertanggung jawab atas biaya perawatan saya.</li>
						<li style="font-size: 11px;">Bahwa saya MENYETUJUI/MENOLAK* identitas saya diinformasikan kepada
							…………………………………………….</li>
					</ol>
					<div class="ttd">
						<div id="childttd">
							<span>Bukittinggi,…………………………………….……20……….</span>
							<br><br><br>
							<span>(...........................)</span><br>
			
						</div>
			
					</div>
				</div>
			
			
				</div>
			
			
			</body>
			
			</html>
			</body>
			
			</html>';
			}
			$file_name = "Identitas_$no_cm.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('15', '10', '15'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '5');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten_header . $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . '/download/irj/rjidentitas/' . $file_name, 'FI');
		} else {
			redirect('irj/rjcregistrasi', 'refresh');
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP
	public function buat_SEP($no_register)
	{

		//$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
		//echo $timestamp."asa";

		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		//echo $encoded_signature."asa";

		$http_header = array(
			'Accept: application/json',
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);

		$data['data_pasien_daftar_ulang'] = $this->getdata_daftar_ulang_pasien($no_register)->row();
		$logged_in_user_info = $this->M_user->get_logged_in_user_info();

		// nama variabel sesuai dengan nama di xml
		$noKartu = $data['data_pasien_daftar_ulang']->no_kartu;
		$tglSep = date('Y-m-d H:i:s');
		$tglRujukan = $data['data_pasien_daftar_ulang']->tgl_rujukan;
		$noRujukan = $data['data_pasien_daftar_ulang']->no_rujukan;
		$ppkRujukan = $data['data_pasien_daftar_ulang']->asal_rujukan;
		$ppkPelayanan = '10000'; //id rs
		$jnsPelayanan = '2'; //1->RJ 2->RD 3-> RI
		$catatan = 'Coba SEP Bridging';
		$diagAwal = $data['data_pasien_daftar_ulang']->diagnosa;
		$poliTujuan = $data['data_pasien_daftar_ulang']->id_poli;
		$klsRawat = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$lakaLantas = '2';
		$user = $logged_in_user_info->username;
		$noMr = $data['data_pasien_daftar_ulang']->no_medrec;

		$data = '<request>
					<data>
					<t_sep>
					<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
					 
					</t_sep>
					</data>
				</request>';
		/*
				
					<poliTujuan>'.$poliTujuan.'</poliTujuan>
					
					 
					 
<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
 
 <noKartu>'.$noKartu.'</noKartu>
					<tglSep>'.$tglSep.'</tglSep>
					<tglRujukan>'.$tglRujukan.'</tglRujukan>
					<noRujukan>'.$noRujukan.'</noRujukan>
					<ppkRujukan>'.$ppkRujukan.'</ppkRujukan>
					<ppkPelayanan>'.$ppkPelayanan.'</ppkPelayanan>
					<jnsPelayanan>'.$jnsPelayanan.'</jnsPelayanan>
					<catatan>'.$catatan.'</catatan>
					<diagAwal>'.$diagAwal.'</diagAwal>
					<poliTujuan>MAT</poliTujuan>
					<klsRawat>'.$klsRawat.'</klsRawat>
					<lakaLantas>'.$lakaLantas.'</lakaLantas>
					<user>'.$user.'</user>
					<noMr>'.$noMr.'</noMr>
					 
 */
		//echo("<br>".$data);
		//break;
		//$ch = curl_init('http://api.asterix.co.id/SepWebRest/sep/create/');
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		// echo $result; 
		$sep = json_decode($result)->response;
		//echo $sep."sad";
		return ("0301R00104160000010");

		// foreach ($sep as $key => $value){
		// echo "$key: $value\n";
		// echo "$key: $value->nama\n";
		// echo "$key: $value->nik\n";
		// };

		// foreach($sep->data as $mydata){
		// echo $mydata->nama . "\n";
		// foreach($mydata->values as $values){
		// echo $values->value . "\n";
		// }
		// }
	}

	public function cetak_sep($no_register)
	{

		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH . 'controllers/irj/SEP.php');

		$sep = new SEP();
		//$this->load->model('r_jalan');
		$entri_rj = $this->rjmregistrasi->get_entri($no_register);

		if (!$entri_rj) {
			return;
		}

		//$this->load->model('pasien_irj');
		$pasien = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($entri_rj->no_medrec)->row();
		if (!$pasien) {
			return;
		}
		//$this->load->model('ppk');
		$ppk = $this->rjmregistrasi->get_ppk($entri_rj->asal_rujukan);
		if ($ppk) {
			$ppk = $ppk->nm_ppk;
		} else {
			$ppk = $entri_rj->asal_rujukan;
		}

		$result = $this->rjmregistrasi->get_diagnosa($entri_rj->diagnosa);
		if ($result != '') {
			$diagnosa = $result->id_icd . " - " . $result->nm_diagnosa;
		} else $diagnosa = '';
		// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$kota_kab=$row->kota;
		// }
		$namars = $this->config->item('namars');
		$alamatrs = $this->config->item('alamat');
		$kota_kab = $this->config->item('kota');
		$nmsingkat = $this->config->item('nmsingkat');

		$fields = array(
			'No. Register' => $entri_rj->no_register,
			'No. SEP' => $entri_rj->no_sep,
			'Tgl. SEP' => date('d/m/Y'),
			'No. Kartu' => $pasien->no_kartu,
			'Peserta' => $pasien->pesertaBPJS,
			'Nama Peserta' => $pasien->nama,
			'Tgl. Lahir' => date("d-m-Y", strtotime($pasien->tgl_lahir)),
			'Jenis Kelamin' => $pasien->sex,
			'Asal Faskes' => $ppk,
			'Poli Tujuan' => $entri_rj->nm_poli,
			'Kelas Rawat' => $entri_rj->kelas_pasien,
			'Jenis Rawat' => 'Rawat Jalan',
			'Diagnosa Awal' => $diagnosa,
			//'Catatan' => $entri_rj->CATATAN
			'Catatan' => '',
			'Nama RS' => $namars
		);
		$sep->set_nilai($fields);
		$sep->cetak();
	}

	public function cetak_kartu_pasien()
	{
		// $this->load->library('PrintZebra');  
		// $hostPrinter = "\\PENDAFTARAN\Zebra P330i Card Printer USB (Copy 1)";
		// $speedPrinter = 4;
		// $darknessPrint = 2;
		// $labelSize = array(300,10);
		// $referencePoint = array(223,15);

		// $z = new ZebraPrinter($hostPrinter, $speedPrinter, $darknessPrint, $labelSize, $referencePoint);
		// $z->setBarcode(1, 344, 80, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,30,4);
		// $z->setBarcode(1, 344, 230, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,180,4);
		// $z->setLabelCopies(1);
		// $z->print2zebra();
		// echo $no_cm;
		$no_cm = $this->input->post('cetak_kartu');
		$no_medrec = $this->input->post('no_medrec');
		echo '<script type="text/javascript">window.open("' . site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm") . '", "_blank");window.focus()</script>';
		// echo '<img src="'.base_url().'irj/rjcregistrasi/bikin_barcode/'.$no_cm.'" height="120px">';
		redirect('irj/rjcregistrasi/daftarulang/' . $no_medrec, 'refresh');
		//echo $no_cm;
	}

	//NEW
	///////////////////////////////////////////////////////////////////////////////////////////
	public function st_cetak_kartu_pasien($no_cm)
	{
		$data['data_pasien'] = $this->rjmregistrasi->getdata_pasien($no_cm, TRUE)->result();
		$this->load->view('RM_02', $data);
		return;
		error_reporting(~E_ALL);



		if ($no_cm != '') {

			$data_pasien = $this->rjmregistrasi->getdata_pasien($no_cm)->result();

			tcpdf();
			$obj_pdf = new TCPDF('P', 'mm', array('54', '86'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('3', '3', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			$obj_pdf->Rotate(-90, 1, 1);
			$obj_pdf->Translate(0, -52);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');


			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

			IMPORTANT:
			If you are printing user-generated content, tcpdf tag can be unsafe.
			You can disable this tag by setting to false the K_TCPDF_CALLS_IN_HTML
			constant on TCPDF configuration file.

			For security reasons, the parameters for the 'params' attribute of TCPDF
			tag must be prepared as an array and encoded with the
			serializeTCPDFtagParameters() method (see the example below).

			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */




			// $params = $obj_pdf->serializeTCPDFtagParameters(array('www.google.com', 'QRCODE,H', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>1), 'N'));

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_cm, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));


			foreach ($data_pasien as $row) {
				$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));

				if (empty($row->no_nrp)) {
					$nrp = '';
				} else {
					// $nrp = 'NRP/NIP : '.$row->no_nrp;
					$nrp = $row->no_nrp;
				}
				if ($row->sex == 'L') {
					$sex = 'LAKI-LAKI';
				} else {
					$sex = 'PEREMPUAN';
				}

				if (strlen($row->nama) > 25) {
					$nama = substr($row->nama, 0, 23) . '..';
				} else {
					$nama = $row->nama;
				}

				//$barcode = $this->set_barcode($no_cm);

				$barcode = '<img src="' . base_url() . 'irj/rjcregistrasi/set_barcode/' . $no_cm . '">';


				$html =
					"
					<br/>
					<br/>
					<br/>
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:12px;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"400px\">
						<tr>
							<td>$no_cm</td>
						</tr>
						<tr>
							<td class=\"nama-pasien\"><b>$row->nama</b></td>
						</tr>
						<tr>
							<td>$tgl_lahir</td>
						</tr>
						<tr>
							<td>$nrp</td>
						</tr>
					</table>
				";
			}
			// $html = $konten.'<tcpdf method="write2DBarcode" params="'.$params.'" />';


			// output the HTML content
			// $obj_pdf->writeHTML($html, true, 0, true, 0);

			// set style for barcode
			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->write2DBarcode($no_cm, 'QRCODE,H', 3, 22, 15, 15, $style, 'N');
			$obj_pdf->write1DBarcode($no_cm, 'C128B', '', 20, 30, 9, 17, $style, 'T');

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);
			$obj_pdf->writeHTML($html, true, 0, true, 0);


			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('irj/rjcregistrasi', 'refresh');
		}
	}


	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function sep_tracer()
	{
		$namars = $this->config->item('namars');
		$alamatrs = $this->config->item('alamat');
		$telprs = $this->config->item('telp');
		$kota = $this->config->item('kota');
		$nmsingkat = $this->config->item('nmsingkat');

		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");

		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();			

		// foreach($data_identitas as $row){
		$konten = "<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: 0601R00111160000032</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: 2016-11-30</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: 0000026975981 MR: 0000000014</td>
						<td>Peserta</td>
						<td>: PNS PUSAT</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: NURAINI FITRIYAH</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: 1999-08-17</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: P</td>
						<td>Jenis Rawat</td>
						<td>: Jalan</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: Poli Penyakit Mata</td>
						<td>Kelas Rawat</td>
						<td>: Kelas III</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: dr. HJ. SRI AULIATI</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: Cholera due to Vibrio cholerae 01, biovar eltor</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: test catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke 5</td>
						<td>: 06-12-2016 11:25:40</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
		// $poli="Jalan";
		// if($poli!="Darurat"){
		$data_tracer = $this->rjmregistrasi->getdata_tracer('RJ16000104')->result();
		foreach ($data_tracer as $row) {
			if ($row->sex == 'L') {
				$sex = 'Laki-laki';
			} else {
				$sex = 'Perempuan';
			}
			$no_medrec = $row->no_medrec;
			if ($row->nmkontraktor != '') {
				if ($row->cara_bayar == 'BPJS') {
					$txtperusahaan = $row->nmkontraktor;
				} else $txtperusahaan = $row->cara_bayar . " - " . $row->nmkontraktor;
			} else {
				$txtperusahaan = 'UMUM';
			}
			$konten = $konten . "<style type=\"text/css\">
						.table-font-size{
							font-size:13px;
						    }
						</style>	<br><br><hr>				
						$namars | $alamatrs
						
						<h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u></h3><br/>
						<table class=\"table-font-size\">
							<tr>
								<td width=\"20%\"><h4>No. Antrian</h4></td>
								<td width=\"5%\"> : </td>
								<td width=\"30%\"><b>$row->no_antrian</b></td>
								<td>No. MR</td>
								<td width=\"5%\"> : </td>
								<td width=\"20%\"><b>$row->no_cm</b></td>
							</tr>
							<tr>
								<td>Tgl Registrasi</td>
								<td> : </td>
								<td><b>" . date('d-m-Y', strtotime($row->tgl_kunjungan)) . " | " . date('H:i:s', strtotime($row->tgl_kunjungan)) . "</b></td>
								<td >Pasien</td>
								<td width=\"5%\"> : </td>
								<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>
							</tr>
							<tr>
								<td>No. Registrasi</td>
								<td> : </td>
								<td><b>$row->no_register</b></td>
							</tr>
							<tr>
								<td>Pasien</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nama</b></td>
							</tr>												
							<tr>
								<td>Unit Tujuan</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nm_poli</b></td>
							</tr>
							
							<tr>
								<td>Tgl Lahir</td>
								<td> : </td>
								<td>" . date('d-m-Y', strtotime($row->tgl_lahir)) . "</td>
							</tr>
							<tr>
								<td>Umur</td>
								<td> : </td>
								<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
							</tr>
							<tr>
								<td>Kelamin</td>
								<td> : </td>
								<td >$sex</td>
							</tr>";

			if ($this->rjmregistrasi->getdata_before($no_medrec, $no_register)->num_rows() > 0) {
				$data_tracer = $this->rjmregistrasi->getdata_before($no_medrec, $no_register)->result();
				foreach ($data_tracer as $row1) {
					if ($row1->ket_pulang != 'PULANG' and $row1->ket_pulang != '') {
						$txtpulang = '| ' . $row1->ket_pulang;
					} else $txtpulang = '';

					$konten1 = "<tr>
										<td>Unit & Kunjungan Lalu</td>
										<td> : </td>
										<td colspan=\"2\">" . date('d-m-Y', strtotime($row1->tgl_kunjungan)) . " | $row1->nm_poli $txtpulang</td>
									</tr>";
				}
			} else {
				$konten1 = "<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>";
			}

			$login_data = $this->load->get_var("user_info");
			if ($login_data->name == '' || $login_data->name == null) {
				$user = $login_data->username;
			} else {
				$user = $login_data->name;
			}

			$konten = $konten . "$konten1<tr>
								<td>Petugas</td>
								<td> : </td>
								<td colspan=\"2\">" . $user . "</td>
							</tr>						
							<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
						</table><br>
						<br>
						<style type=\"text/css\">
							.table-diagnosis{
								font-size:9px;
							    }
							</style>
							<table class=\"table-diagnosis\" border=\"1\">
								<tr>
									<td width=\"18%\">Diagnosis</td>
									<td width=\"7%\">ICD10</td>
									<td width=\"4%\">KB</td>
									<td width=\"4%\">KL</td>
									<td width=\"15%\">Tindakan</td>
									<td width=\"10%\">ICD 9 CM</td>
									<td width=\"15%\">INA CBG</td>
									<td width=\"15%\">Nama Dokter</td>
									<td width=\"12%\">Kode Dokter</td>
								</tr>
								<tr>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
								</tr>
							</table>
					";
		}
		// }



		// }
		$file_name = "sep.pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADEFR);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5'); //left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/irj/sjp/' . $file_name, 'FI');
	}

	public function create_sep($no_kartu = '', $no_register = '')
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
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			'Accept: application/json',
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: ' . $cons_id,
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init($url . 'Peserta/Peserta/' . $no_kartu);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);

		curl_close($ch);
		if ($result != '') {
			$datakartu = json_decode($result)->response;
			$cek_peserta = json_decode($result);
			if ($cek_peserta->metaData->code != '200') {
				return $cek_peserta;
			}
		} else {
			$result_error = array(
				'metaData' => array('code' => '503', 'message' => 'Service Unavailable'),
				'response' => ['peserta' => null]
			);
			return $result_error;
		}

		$entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
		$no_medrec = $this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
		$xuser = $entri_catatan->xuser;
		$id_poli = $entri_catatan->id_poli;
		$alasan_berobat = $entri_catatan->alasan_berobat;
		if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
			$laka_lantas = '1';
			$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
		} else {
			$laka_lantas = '2';
			$lokasi_laka = '';
		}
		$poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

		if ($datakartu->peserta->provUmum->kdProvider == NULL or $datakartu->peserta->provUmum->kdProvider == '') {
			$ppkrujuk = '0901R004';
		} else
			$ppkrujuk = $datakartu->peserta->provUmum->kdProvider;


		if ($entri_catatan->no_rujukan == NULL or $entri_catatan->no_rujukan == '') {
			$norujuk = '0';
		} else
			$norujuk = $entri_catatan->no_rujukan;

		$data = array(
			'request' => array(
				't_sep' => array(
					'noKartu' => $no_kartu,
					'tglSep' =>  $tgl_sep,
					'tglRujukan' => $tgl_sep,
					'noRujukan' => $norujuk,
					'ppkRujukan' => $ppkrujuk,
					'ppkPelayanan' => $ppk_pelayanan,
					'jnsPelayanan' => '2',
					'catatan' => $entri_catatan->catatan,
					'diagAwal' => $entri_catatan->diagnosa,
					'poliTujuan' => $poli_bpjs->poli_bpjs,
					'klsRawat' => '3',
					'lakaLantas' => $laka_lantas,
					'lokasiLaka' => $lokasi_laka,
					'user' => $xuser,
					'noMr' => $no_medrec
				)
			)
		);
		$datasep = json_encode($data);


		$ch = curl_init($url . 'SEP/insert');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		if ($result != '') {
			$sep = json_decode($result);
			if ($sep->metaData->code == '200') {
				$data_update = array(
					'no_sep' => $sep->response
				);
				$this->Mbpjs->update_sep_irj($no_register, $data_update);
			}
			return $sep;
		} else {
			$result_error = array(
				'metaData' => array('code' => '503', 'message' => 'Service Unavailable'),
				'response' => ['peserta' => null]
			);
			return $result_error;
		}
	}

	public function create_sep2($no_kartu = '', $no_register = '')
	{
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
		$url = $data_bpjs->service_url;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
		//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			'Accept: application/json',
			//	   'Content-type: application/xml',
			'Content-type: application/x-www-form-urlencoded',
			// 'Content-type: application/json',
			'X-cons-id: ' . $cons_id, //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init($url . 'Peserta/Peserta/' . $no_kartu);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
		if ($result != '') { //valid koneksi internet
			$datakartu = json_decode($result)->response;
		}
		$cek_peserta = json_decode($result);
		if ($cek_peserta->metaData->message == 'KP : Peserta Tidak Ditemukan') {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Peserta Untuk Nomor ' . $no_kartu . ' Tidak Ditemukan
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);
			//echo '<script type="text/javascript">window.close();</script>';	
			redirect('irj/rjcregistrasi/', 'refresh'); //exit(); 		
		} // metadata code		

		$entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
		$no_medrec = $this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
		$xuser = $entri_catatan->xuser;
		$id_poli = $entri_catatan->id_poli;
		$alasan_berobat = $entri_catatan->alasan_berobat;
		if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
			$laka_lantas = '1';
			$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
		} else {
			$laka_lantas = '2';
			$lokasi_laka = '';
		}
		$poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

		if ($datakartu->peserta->provUmum->kdProvider == NULL or $datakartu->peserta->provUmum->kdProvider == '') {
			$ppkrujuk = '09020100';
		} else
			$ppkrujuk = $datakartu->peserta->provUmum->kdProvider;


		if ($entri_catatan->no_rujukan == NULL or $entri_catatan->no_rujukan == '') {
			$norujuk = '0';
		} else
			$norujuk = $entri_catatan->no_rujukan;

		$data = array(
			'request' => array(
				't_sep' => array(
					'noKartu' => $no_kartu,
					'tglSep' =>  $tgl_sep,
					'tglRujukan' => $tgl_sep,
					'noRujukan' => $norujuk, //$entri_catatan->NO_RUJUKAN,
					'ppkRujukan' => $ppkrujuk,
					'ppkPelayanan' => $ppk_pelayanan,
					'jnsPelayanan' => '2',
					'catatan' => $entri_catatan->catatan,
					// 'diagAwal' => $datakartu->item->diagnosa->kdDiag,
					'diagAwal' => $entri_catatan->diagnosa,
					// 'poliTujuan' => $datakartu->poliRujukan->kdPoli, // INT
					'poliTujuan' => $poli_bpjs->id_poli, // INT
					'klsRawat' => '3', //$datakartu->peserta->provUmum->
					'lakaLantas' => $laka_lantas,
					'lokasiLaka' => $lokasi_laka,
					'user' => $xuser,
					'noMr' => $no_medrec //'999999999',//$datakartu->item->peserta->noMr
				)
			)
		);
		$datasep = json_encode($data);
		//print_r($datasep);exit();
		$ch = curl_init($url . 'SEP/insert');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		if ($result != '') { //valid koneksi internet
			$sep = json_decode($result);
			// print_r($sep->response);exit; ///////////////////////////////////////
			if ($sep->metaData->code == '800') {
				$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, ' . $sep->metaData->message . '
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('success_msg', $success);
				echo $sep->metaData->message;
				print_r($datasep);
				//echo '<script type="text/javascript">window.close();</script>';
				//redirect('irj/rjcregistrasi/');exit();
			} else if ($sep->metaData->code == '200') {


				// $id= $no_rujukan;
				$data_update = array(
					'NO_SEP' => $sep->response
				);
				$this->M_update_sepbpjs->update_sep_bpjs($no_register, $data_update);
				// print_r($sep->response);
				// exit();
				echo '<script type="text/javascript">window.open("' . site_url("irj/c_sepmanual/cetak_sep/") . '/' . $no_register . '", "_blank");window.focus()</script>';
			} else {
				echo $sep->metaData->message;
				exit();
			}
		} else {
			echo "Pastikan Anda Terhubung Internet!!";
			exit();
		}
	}

	public function ktp_reader()
	{
		$data['members_ktp'] = $this->rjmregistrasi->load_all_memberktp();
		$this->load->view('ktp_reader/index', $data);
	}

	public function ttd()
	{
		$this->load->view('ttd/ttd');
	}

	public function insert_procedure()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('no_register');
		if ($this->input->post('procedure_text')) {
			$procedure_text = $this->input->post('procedure_text');
		} else {
			$procedure_text = NULL;
		}
		$cek_utama = $this->Mdiagnosa->count_utama($no_register); //
		$cek_limit = $this->Mdiagnosa->count_limit($no_register);
		if ($cek_limit < 30) {
			if ($cek_utama > 0) {
				$klasifikasi = 'tambahan';
			} else {
				$klasifikasi = 'utama';
			}

			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$idDiagnosa = NULL;
			$namaDiagnosa = NULL;
			if ($this->input->post('diagnosa') != '') {
				$diagnosa = explode("@", $this->input->post('diagnosa'));
				$idDiagnosa = $diagnosa[0];
				$namaDiagnosa = $diagnosa[1];
				// $result_error = array(
				//     'metadata' => array('code' => '402','message' => 'Silahkan pilih diagnosa terlebih dahulu.'),
				//     'response' => null
				// );
				// echo json_encode($result_error);                 
			}
			// else {

			if (substr($no_register, 0, 2) == 'RJ') {
				$exist = $this->db->from('diagnosa_pasien')->where('id_diagnosa', $idDiagnosa)->where('no_register', $no_register)->get();
			}
			if (substr($no_register, 0, 2) == 'RI') {
				$exist = $this->db->from('diagnosa_iri')->where('id_diagnosa', $idDiagnosa)->where('no_register', $no_register)->get();
			}
			if ($exist->num_rows() > 0) {
				$result_error = array(
					'metadata' => array('code' => '422', 'message' => 'Diagnosa ' . $idDiagnosa . ' sudah ada. Tidak dapat menginput diagnosa yang sama.'),
					'response' => null
				);
				echo json_encode($result_error);
			} else {
				$data_insert = array(
					'no_register' => $no_register,
					'tgl_kunjungan' => $this->input->post('tgl_masuk'),
					'id_diagnosa' => $idDiagnosa,
					'diagnosa' => $namaDiagnosa,
					'diagnosa_text' => $diagnosaText,
					'klasifikasi_diagnos' => $klasifikasi,
					'xuser' => $user
				);
				//add
				// $cekdiagnosa_kerja = $this->Mdiagnosa->cekdiagnosa_kerja($no_register)->row();
				// if($cekdiagnosa_kerja == false){
				//     $datafisik['diag_kerja'] = 'Diagnosa :  '. $namaDiagnosa.' ';
				//     $datafisik['diag_banding'] = 'Diagnosa :  '. $namaDiagnosa.' ';
				// }else{
				//     $datafisik['diag_kerja'] = $cekdiagnosa_kerja->diag_banding.'<br>'.'Diagnosa '.$namaDiagnosa.'';
				//     $datafisik['diag_banding'] = $cekdiagnosa_kerja->diag_banding.'<br>'.'Diagnosa '.$namaDiagnosa.'';
				// }

				$result = $this->Mdiagnosa->insert($data_insert);


				if ($result == true) {
					$result_success = array(
						'metadata' => array('code' => '200', 'message' => 'Diagnosa berhasil disimpan.'),
						'response' => 'OK'
					);

					// $data_fisik=$this->Mdiagnosa->getdata_tindakan_fisik($no_register)->row();
					// if ($data_fisik==FALSE) {
					//     $datafisik['no_register'] = $no_register;
					//     $this->Mdiagnosa->insert_data_fisik($datafisik);
					//     //INSERT
					// } else {
					//     $this->Mdiagnosa->update_data_fisik($no_register, $datafisik);
					//     // UPDATE
					// }
					echo json_encode($result_success);
				} else {
					$result_error = array(
						'metadata' => array('code' => '500', 'message' => $result),
						'response' => null
					);
					echo json_encode($result_error);
				}
			}
			// }
		} else {
			$result_error = array(
				'metadata' => array('code' => '403', 'message' => 'Jumlah penginputan diagnosa sudah mencapai batas maksimal.'),
				'response' => null
			);
			echo json_encode($result_error);
		}
	}

	public function cek_available_no_rujukan($no_rujukan, $nomedrec)
	{
		$result = $this->rjmregistrasi->cek_no_rujukan($no_rujukan, $nomedrec);
		$data = $result->row();
		echo json_encode($data);
	}

	public function grab_ktp_reader()
	{
		$result = $this->rjmregistrasi->grab_ktp_reader();
		$data = $result->result();
		echo json_encode($data);
	}

	public function cetak_label_cm($no_cm)
	{
		// $no_cm = '00000070';
		// var_dump(substr($no_cm,2));die();
		error_reporting(~E_ALL);
		if ($no_cm != '') {
			//var_dump($no_ipd);die();
			$data_pasien = $this->rjmregistrasi->get_pasien_by_no_cm($no_cm);
			// print_r($data_pasien);die();
			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('50', '100'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			// $obj_pdf->Rotate(-90, 1, 1);
			// $obj_pdf->Translate(20, -47);
			//$obj_pdf->SetXY(0, 10);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			$params = $obj_pdf->serializeTCPDFtagParameters(array($data_pasien[0]['no_medrec'], 'C128', '', '', 20, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

			// print_r($data_pasien[0]);die();


			foreach ($data_pasien as $row) {
				$tgl_lahir = date('d-m-Y', strtotime($row['tgl_lahir']));

				// $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
				// $html.=
				// "
				// 	<br/>
				// 	<style type=\"text/css\">
				// .table-font-size{
				// 	margin-top:9px;
				//     }
				// .nama-pasien{
				// 	font-size:9px;
				//     }
				// </style>
				// <table class=\"table-font-size\" border=\"0\" width=\"300px\">
				// 		<tr>
				// 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">No Register : $no_ipd</td>
				// 		</tr>
				// 		<tr>
				// 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
				// 		</tr>
				// 		<tr>
				// 			<td>Tgl. Lahir : $tgl_lahir</td>
				// 			<td>JK : ".$row['sex']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
				// 		</tr>
				// </table>
				// ";



				$html .=
					"
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:8px;
				    }
				.rs{
					font-size:7px;
					}
				.list{
					font-size:7px;
					}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
						<tr>
							<td colspan=\"2\" class=\"nama-pasien\"><b>" . substr($no_cm, 2) . "</b></td>
						</tr>
						<tr>
							<td class=\"list\" width=\"30%\"><b>" . $row['nama'] . "     (" . $row['sex'] . ")</b><br>
							" . $row['no_identitas'] . "<br>
							Lhr : " . $tgl_lahir . "
							</td>

							<td width=\"70%\">";
				$html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
				$html .= "
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
						</tr>
				</table>
				";
			}




			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			$obj_pdf->AddPage();
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			$obj_pdf->Translate(20, 0);

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);



			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('iirj/rjcpelayanan/kunj_pasien_poli', 'refresh');
		}
	}

	public function cetak_label_cm_backup($no_cm)
	{
		error_reporting(~E_ALL);
		if ($no_cm != '') {
			//var_dump($no_ipd);die();
			$data_pasien = $this->rjmregistrasi->get_pasien_by_no_cm($no_cm);
			// print_r($data_pasien);die();
			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('50', '100'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			// $obj_pdf->Rotate(-90, 1, 1);
			// $obj_pdf->Translate(20, -47);
			//$obj_pdf->SetXY(0, 10);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			$params = $obj_pdf->serializeTCPDFtagParameters(array($data_pasien[0]['no_medrec'], 'C128', '', '', 20, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

			// print_r($data_pasien[0]);die();


			foreach ($data_pasien as $row) {
				$tgl_lahir = date('d-m-Y', strtotime($row['tgl_lahir']));

				// $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
				// $html.=
				// "
				// 	<br/>
				// 	<style type=\"text/css\">
				// .table-font-size{
				// 	margin-top:9px;
				//     }
				// .nama-pasien{
				// 	font-size:9px;
				//     }
				// </style>
				// <table class=\"table-font-size\" border=\"0\" width=\"300px\">
				// 		<tr>
				// 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">No Register : $no_ipd</td>
				// 		</tr>
				// 		<tr>
				// 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
				// 		</tr>
				// 		<tr>
				// 			<td>Tgl. Lahir : $tgl_lahir</td>
				// 			<td>JK : ".$row['sex']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
				// 		</tr>
				// </table>
				// ";



				$html .=
					"
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:8px;
				    }
				.rs{
					font-size:7px;
					}
				.list{
					font-size:7px;
					}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
						<tr>
							<td colspan=\"2\" class=\"nama-pasien\"><b>" . $row['no_medrec'] . "</b></td>
						</tr>
						<tr>
							<td class=\"list\" width=\"30%\"><b>" . $row['nama'] . " (" . $row['sex'] . ")</b><br>
							" . $row['no_identitas'] . "<br>
							Lhr : " . $tgl_lahir . "
							</td>

							<td width=\"70%\">";
				$html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
				$html .= "
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
						</tr>
				</table>
				";
			}




			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			$obj_pdf->AddPage();
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			$obj_pdf->Translate(20, 0);

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);



			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('iirj/rjcpelayanan/kunj_pasien_poli', 'refresh');
		}
	}

	public function cetak_label($no_ipd)
	{
		error_reporting(~E_ALL);
		if ($no_ipd != '') {
			//var_dump($no_ipd);die();
			$data_pasien = $this->rjmregistrasi->get_pasien_by_no_ipd($no_ipd);
			// print_r($data_pasien);die();
			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('50', '100'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			// $obj_pdf->Rotate(-90, 1, 1);
			// $obj_pdf->Translate(20, -47);
			//$obj_pdf->SetXY(0, 10);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			$params = $obj_pdf->serializeTCPDFtagParameters(array($data_pasien[0]['no_medrec'], 'C128', '', '', 20, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

			// print_r($data_pasien[0]);die();


			foreach ($data_pasien as $row) {
				$tgl_lahir = date('d-m-Y', strtotime($row['tgl_lahir']));

				// $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
				// $html.=
				// "
				// 	<br/>
				// 	<style type=\"text/css\">
				// .table-font-size{
				// 	margin-top:9px;
				//     }
				// .nama-pasien{
				// 	font-size:9px;
				//     }
				// </style>
				// <table class=\"table-font-size\" border=\"0\" width=\"300px\">
				// 		<tr>
				// 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">No Register : $no_ipd</td>
				// 		</tr>
				// 		<tr>
				// 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
				// 		</tr>
				// 		<tr>
				// 			<td>Tgl. Lahir : $tgl_lahir</td>
				// 			<td>JK : ".$row['sex']."</td>
				// 		</tr>
				// 		<tr>
				// 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
				// 		</tr>
				// </table>
				// ";



				$html .=
					"
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:8px;
				    }
				.rs{
					font-size:7px;
					}
				.list{
					font-size:7px;
					}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
						<tr>
							<td colspan=\"2\" class=\"nama-pasien\"><b>" . substr($row['no_cm'], 2) . "</b></td>
						</tr>
						<tr>
							<td class=\"list\" width=\"30%\"><b>" . $row['nama'] . " (" . $row['sex'] . ")</b><br>
							" . $row['no_identitas'] . "<br>
							Lhr : " . $tgl_lahir . "
							</td>

							<td width=\"70%\">";
				$html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
				$html .= "
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
						</tr>
				</table>
				";
			}




			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			$obj_pdf->AddPage();
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			$obj_pdf->Translate(20, 0);

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);



			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('iirj/rjcpelayanan/kunj_pasien_poli', 'refresh');
		}
	}

	public function cetak_label_pl($no_ipd)
	{
		error_reporting(~E_ALL);
		if ($no_ipd != '') {
			//var_dump($no_ipd);die();
			$data_pasien = $this->rjmregistrasi->get_data_pasien_luar($no_ipd)->row();
			// print_r($data_pasien);die();
			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('50', '100'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			// $obj_pdf->Rotate(-90, 1, 1);
			// $obj_pdf->Translate(20, -47);
			//$obj_pdf->SetXY(0, 10);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			$params = $obj_pdf->serializeTCPDFtagParameters(array($data_pasien->no_register, 'C128', '', '', 20, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

			// print_r($data_pasien[0]);die();


			// foreach ($data_pasien as $row) {
			// 	$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));

			// $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
			// $html.=
			// "
			// 	<br/>
			// 	<style type=\"text/css\">
			// .table-font-size{
			// 	margin-top:9px;
			//     }
			// .nama-pasien{
			// 	font-size:9px;
			//     }
			// </style>
			// <table class=\"table-font-size\" border=\"0\" width=\"300px\">
			// 		<tr>
			// 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
			// 		</tr>
			// 		<tr>
			// 			<td colspan=\"2\">No Register : $no_ipd</td>
			// 		</tr>
			// 		<tr>
			// 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
			// 		</tr>
			// 		<tr>
			// 			<td>Tgl. Lahir : $tgl_lahir</td>
			// 			<td>JK : ".$row['sex']."</td>
			// 		</tr>
			// 		<tr>
			// 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
			// 		</tr>
			// </table>
			// ";



			$html .=
				"
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:8px;
				    }
				.rs{
					font-size:7px;
					}
				.list{
					font-size:7px;
					}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
						<tr>
							<td colspan=\"2\" class=\"nama-pasien\"><b>" . $data_pasien->no_register . "</b></td>
						</tr>
						<tr>
							<td class=\"list\" width=\"30%\"><b>" . $data_pasien->nama . " (" . $data_pasien->jk . ")</b><br>
							" . $data_pasien->nik . "<br>
							Lhr : " . date("d-m-Y", strtotime($data_pasien->tgl_lahir)) . "
							</td>

							<td width=\"70%\">";
			$html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
			$html .= "
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
						</tr>
				</table>
				";
			//}




			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			$obj_pdf->AddPage();
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			$obj_pdf->Translate(20, 0);

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);



			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('iirj/rjcpelayanan/kunj_pasien_poli', 'refresh');
		}
	}

	public function cetak_gelang($no_register = '')
	{
		error_reporting(~E_ALL);

		// echo NAMA_RS;die();
		$a = $this->db->query("SELECT * FROM app_config WHERE key = 'top_pdf'")->row();
		$b = $this->db->query("SELECT * FROM app_config WHERE key = 'bottom_pdf'")->row();
		// $c = $this->db->query("SELECT * FROM app_config WHERE key = 'isi'")->row();
		// print_r($a->value.);
		// echo $c->value;
		// echo $a->value.$b->value;
		// die();
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if ($no_register != '') {
			$cterbilang = new rjcterbilang();

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			//$tgl_jam = date("d-m-Y H:i:s");
			$tgl_jam = date("d-m-Y ");
			$tgl = date("d-m-Y");
			// $contoh_barcode = set_barcode('TEsting');
			// echo $contoh_barcode;
			// die();

			$namars = $this->config->item('namars');
			$kota_kab = $this->config->item('kota');
			$alamatrs = $this->config->item('alamat');
			$telp = $this->config->item('telp');
			$nmsingkat = $this->config->item('namasingkat');

			$data_pasien = $this->rjmregistrasi->get_pasien_by_no_ipd($no_register);
			//var_dump($data_pasien);die();
			// print_r($data_pasien);
			//$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			//$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			// if(substr($data_pasien->noregasal,0,2)=='RD'){
			// 	$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			// }else{
			// 	$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			// }

			if ($data_pasien->sex == 'L') {
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			// if($data_pasien->cara_bayar=='BPJS'){
			// 	$cara_bayar=$data_pasien->carabayar;
			// } else {
			// 	$cara_bayar='JAMSOSKES';
			// }

			// if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
			// 	$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			// } else {
			// 	$tgl_rujukan = '';
			// }

			// $asal_rujukan=$data_asal->asal_rujukan;
			// if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
			// 	$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			// }
			// if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}
			//var_dump($data_pasien[0]['tgl_lahir']);die();
			$interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
			$thn = $interval->format("%Y Tahun");

			$style = array(
				'border' => false,
				'padding' => 0,
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			// $barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_register.'">';
			// ob_clean();
			$file_name = "GELANG_$no_register.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$pageLayout = array('53', '500'); //  or array($height, $width) 
			$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('1', '1', '1');
			$obj_pdf->SetAutoPageBreak(TRUE, '1');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			// ob_start();

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'C128', '', '', 50, 15, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 4, 'stretchtext' => 4), 'N'));


			$konten =





				// "<style type=\"text/css\">
				// 		.table-font-size{
				// 			font-size:5px;
				// 		    }
				// 		.table-font-size1{
				// 			font-size:7px;
				// 			margin : 0.5px 1px 0.5px 1px;
				// 			padding : 1px 1px 0.5px 1px;
				// 			width:100%; height:100%;
				// 		    }
				// 		</style>
				// 		<br><br>
				// 		<table class=\"table-font-size1\" border=\"0\">
				// 			<tr>
				// 				<td width=\"16%\"></td>
				// 				<td align=\"center\" rowspan=\"3\" width=\"7%\">
				// 					<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"27\" style=\"\">
				// 				</td>
				// 				<td width=\"37%\">$data_pasien->nama</td>	
				// 				<td width=\"40%\" align=\"left\">No Medrec : $data_pasien->no_cm</td>
				// 			</tr>
				// 			<tr>	
				// 				<td></td>
				// 				<td>$jk</td>					
				// 				<td align=\"left\">No Register : $data_pasien->no_ipd</td>				
				// 			</tr>
				// 			<tr>	
				// 				<td align=\"right\"><font size=\"5px\">$tgl_jam</font></td>
				// 				<td>".date("d-m-Y",strtotime(substr($data_pasien->tgl_lahir,0,10)))." (".$thn.")</td>		
				// 				<td align=\"left\">$data_ruang->nmruang, Bed $bed</td>				
				// 			</tr>
				// 		</table >";





				'<style type="text/css">
					.table-font-size{
						font-size:5px;
					    }
					.table-font-size1{
						font-size:5px;
						margin : 0px 1px 0.5px 1px;
						padding : 0px 1px 0.5px 1px;
						width:100%; 
						height:100%;
					    }
					</style>
					<br><br>
					<table class="table-font-size1" border="0">
						<tr>
							<td colspan="3">
							<b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b>
							</td>
						</tr>
						<tr>
							<td colspan="3">
							
							</td>
						</tr>
						<tr>
							<td width="15%">' . $data_pasien[0]['nama'] . '</td>	
							<td align="left">' . $data_pasien[0]['no_cm'] . '</td>
						</tr>
						<tr>	
							<td width="15%">Tgl Kunjungan: ' . date("d-m-Y", strtotime($data_pasien[0]['tgl_kunjungan'])) . '</td>	
							<td width="15%">Tgl Lahir:' . date('d-m-Y', strtotime(substr($data_pasien[0]['tgl_lahir'], 0, 10))) . ' <br>(' . $thn . ')</td>
							<td style="padding:100px;">';
			$konten .= '<tcpdf method="write1DBarcode" params="' . $params . '" />';
			$konten .= '</td>
						</tr>
					
					</table >
					';
			// $konten.= NAMA_RS;

			//echo $konten;
			// $c = $a->value.$b->value;			
			// $konten .= TOP_HEADER;
			// $konten .= ISI;
			// $konten .= BOTTOM_HEADER;
			$content = $konten;

			ob_end_clean();
			// $content .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
			// $pdf->SetAutoPageBreak(TRUE, 0);
			$obj_pdf->writeHTML($content, true);
			// $obj_pdf->write1DBarcode($no_register, 'C128B', '', 10, 50, 20, 2, $style,'N');

			$obj_pdf->Output();
		} else {
			redirect('iri/ricsjp/', 'refresh');
		}
	}

	public function bpjs_sep($no_rujukan, $type = 0)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rjmregistrasi->get_bpjs_sep($no_rujukan, $type)->result();
		// var_dump($data);die();
		echo json_encode($data);
	}


	public function bpjs_sep_nokartu($nokartu)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rjmregistrasi->get_bpjs_sep_nokartu($nokartu)->result();
		echo json_encode($data);
	}

	public function get_bpjs_sep_nokartu_spri($nokartu)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rjmregistrasi->get_bpjs_sep_nokartu_spri($nokartu)->result();
		echo json_encode($data);
	}


	public function cek_surat_kontrol_exist($no_sep_asal)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rjmregistrasi->cek_bpjs_suratkontrol($no_sep_asal)->row();
		echo json_encode($data);
	}


	public function cek_sep_bpjs($nomedrec)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rjmregistrasi->cek_bpjs_sep_by('no_medrec', $nomedrec)->row();
		echo json_encode($data);
	}

	public function get_data_pasien_by_no_kartu($no_kartu)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->get_data_pasien_by_no_kartu($no_kartu)->row();
		echo json_encode($data);
	}

	public function caripoliberdasarbpjs($poli_bpjs)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->cariPoliberdasarBpjs($poli_bpjs)->result();
		echo json_encode($data);
	}

	public function getdatapasien($nomedrec)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->caridatapasienberdasarkan('no_medrec', $nomedrec)->row();
		echo json_encode($data);
	}

	/**
	 * Added permintaan :
	 * Ada semacam notifikasi ketika pasien didaftarkan nama dan tanggal lahir sama ada peringatan
	 * kalau pasien sudah ada No. rekam medis lamanya, berikut contoh tabel notifikasinya
	 * 
	 * @aldi 23 agustus 2023 2:31 PM
	 */

	public function checkpatient()
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->checkpatientnamatgllahir($this->input->post('nama'), $this->input->post('tgllahir'))->row();
		echo json_encode($data);
	}

	/**
	 * Added permintaan:
	 * Ada update sep untuk pasien yang didaftarkan lewat vclaim . sep nya masuk ke database
	 */
	public function sep_pasien()
	{
		$data = [
			'title'=>'Daftar Pasien BPJS'
		];

		$this->load->view('sep/sep_pasien',$data);
	}

	/**
	 * Feat : Get List BPJS Pasien Seluruh Pelayanan
	 * Method : GET 
	 * Param : 
	 * - pelayanan ( irj,igd,iri)
	 * - tglkunjungan YYYY-MM-DD Default NOW()
	 * 
	 * Response : 
	 * Json Array Object 
	 * 
	 * @aldi 2023-10-21 4:57 PM
	 */
	public function get_listbpjs()
	{
		$pelayanan = $this->input->get('pelayanan');
		$tglkunjungan = !$this->input->get('tglkunjungan')?date('Y-m-d'):$this->input->get('tglkunjungan');
		$data = $this->rjmregistrasi->get_listbpjs($tglkunjungan,$pelayanan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function update_sepbpjs()
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->update_sepbpjs($this->input->post('no_register'),$this->input->post('no_sep'));
		echo json_encode(['metadata'=>['code'=>$data?200:400,'response'=>$data?'Data Berhasil Diupdate':'Data Gagal Diupdate']]);
	}

	public function get_suratkontrol($nosep)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->get_suratkontrol($nosep);
		echo json_encode($data);	
	}

	public function get_spri($nospri)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->get_spri($nospri);
		echo json_encode($data);	
	}


	public function insert_data_pasien_antrol_v2($id,$loket)
	{
		// var_dump($this->input->post());
		// die();
		if ($this->input->post('jenis_identitas') == 'KTP') {
			$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('no_identitas'))->row();
			if ($check_ktp) {
				$success = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
                       		</div>';
				$this->session->set_flashdata('success_msg', $success);
				redirect('irj/rjcregistrasi/regpasien');
			}			
		}				

		if ($this->input->post('jenis_identitas')!='') {
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}		
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		
		if($this->input->post('no_kartu') == '') {
			$data['no_kartu'] = NULL;
		} else {
			$data['no_kartu'] = $this->input->post('no_kartu');
		}

		if ($this->input->post('id_kontraktor1')!='') {
			$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}
		if ($this->input->post('id_kontraktor2')!='') {
			$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}

		$data['nama']=strtoupper($this->input->post('nama'));		

		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['suku_bangsa']=$this->input->post('etnis');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['bahasa']=$this->input->post('bahasa');

		if ($this->input->post('load_wilayah') != '') {
			$wilayah = explode("@", $this->input->post('load_wilayah'));
			$data['id_provinsi'] = $wilayah[0];
			$data['id_kotakabupaten'] = $wilayah[1];
			$data['id_kecamatan'] = $wilayah[2];
			$data['id_kelurahandesa'] = $wilayah[3];

			$data['provinsi'] = $this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
			$data['kotakabupaten'] = $this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
			$data['kecamatan'] = $this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
			$data['kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
		}

		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_cm_lama']=$this->input->post('mr_lama');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['suami_istri']=$this->input->post('nm_ibu_kndg');
		// $data['jabatan']=$this->input->post('jabatan');	
		// $data['foto_blob'] = ($this->input->post('foto_blob')=="") ? NULL : $this->input->post('foto_blob') ;
		// $data['ttd_blob'] = ($this->input->post('ttd_blob')=="") ? NULL : $this->input->post('ttd_blob') ;
		// $data['fingerprint_blob'] = ($this->input->post('fingerprint_blob')=="") ? NULL : $this->input->post('fingerprint_blob') ;;	

		// penanggung jawab
		$data['nm_penanggung_jawab']=$this->input->post('nm_penanggung_jawab');
		$data['umur_penanggung_jawab']=$this->input->post('umur_penanggung_jawab');
		$data['sex_penanggung_jawab']=$this->input->post('sex_penanggung_jawab');
		$data['alamat_tg_jawab']=$this->input->post('alamat_tg_jawab');
		$data['no_hp_tg_jawab']=$this->input->post('no_hp_tg_jawab');
		$data['hub_tg_jawab']=$this->input->post('hub_tg_jawab');


		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_daftar']=date("Y-m-d H:i:s");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');	
		$data['userid']=$this->input->post('user_id');
		

		$no_medrec_pasien_baru = $this->rjmregistrasi->insert_pasien_irj($data);
		$data['response_bpjs'] = $this->clients->get(
			$this->endpoint .'adminantrian/v2/updateflagantrian/'.$id.'/2/'.$loket
		)->getBody()->getContents();

		// Update status antrian menjadi "telah dilayani" menggunakan internal endpoint
		// $id = $this->input->post('id');
		// $status = $this->input->post('status'); // processed, completed
		// var_dump($id);
		// var_dump($status);
		// die();

		// if (!$id || !$status) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => 'Parameter tidak lengkap'
		// 	]);
		// 	return;
		// }

		try {
			$this->clients = new Client(['verify' => false]);

			$posting = [
				'id' => $id,
				'status' => 'telah_dilayani'
			];

			$response = $this->clients->post(
				$this->endpoint . 'adminantrian/v2/updatestatus',
				[
					'headers' => ['Content-Type' => 'application/json'],
					'json' => $posting
				]
			)->getBody()->getContents();

			$result = json_decode($response, true);

			if ($result && isset($result['metadata']) && $result['metadata']['code'] == 200) {
				echo json_encode([
					'success' => true,
					'message' => 'Status antrian berhasil diupdate',
					'data' => [
						'id' => $id,
						'status' => $status
					]
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => $result['metadata']['message'] ?? 'Gagal mengupdate status antrian'
				]);
			}

		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			]);
		}

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Baru Berhasil.</h3> Data berhasil disimpan. Silahkan daftar ulang pasien.
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('http://192.168.1.139:3000/antrian/pasienlamadebug?norm=' . $no_medrec_pasien_baru.'&antrol='.$id );
	}

	// ADD SJJ 2024

	public function insert_data_pasien()
	{
		if ($this->input->post('jenis_identitas') == 'KTP') {
			$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('no_identitas'))->row();
			if (count($check_ktp)) {
				$success = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
                       		</div>';
				$this->session->set_flashdata('success_msg', $success);
				redirect('irj/rjcregistrasi/regpasien');
			}			
		}				

		if ($this->input->post('jenis_identitas')!='') {
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}		
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		
		if($this->input->post('no_kartu') == '') {
			$data['no_kartu'] = NULL;
		} else {
			$data['no_kartu'] = $this->input->post('no_kartu');
		}

		if ($this->input->post('id_kontraktor1')!='') {
			$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}
		if ($this->input->post('id_kontraktor2')!='') {
			$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}

		$data['nama']=strtoupper($this->input->post('nama'));		

		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['suku_bangsa']=$this->input->post('etnis');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['bahasa']=$this->input->post('bahasa');

		if ($this->input->post('load_wilayah') != '') {
			$wilayah = explode("@", $this->input->post('load_wilayah'));
			$data['id_provinsi'] = $wilayah[0];
			$data['id_kotakabupaten'] = $wilayah[1];
			$data['id_kecamatan'] = $wilayah[2];
			$data['id_kelurahandesa'] = $wilayah[3];

			$data['provinsi'] = $this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
			$data['kotakabupaten'] = $this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
			$data['kecamatan'] = $this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
			$data['kelurahandesa'] = $this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
		}

		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_cm_lama']=$this->input->post('mr_lama');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['suami_istri']=$this->input->post('nm_ibu_kndg');
		// $data['jabatan']=$this->input->post('jabatan');	
		// $data['foto_blob'] = ($this->input->post('foto_blob')=="") ? NULL : $this->input->post('foto_blob') ;
		// $data['ttd_blob'] = ($this->input->post('ttd_blob')=="") ? NULL : $this->input->post('ttd_blob') ;
		// $data['fingerprint_blob'] = ($this->input->post('fingerprint_blob')=="") ? NULL : $this->input->post('fingerprint_blob') ;;	

		// penanggung jawab
		$data['nm_penanggung_jawab']=$this->input->post('nm_penanggung_jawab');
		$data['umur_penanggung_jawab']=$this->input->post('umur_penanggung_jawab');
		$data['sex_penanggung_jawab']=$this->input->post('sex_penanggung_jawab');
		$data['alamat_tg_jawab']=$this->input->post('alamat_tg_jawab');
		$data['no_hp_tg_jawab']=$this->input->post('no_hp_tg_jawab');
		$data['hub_tg_jawab']=$this->input->post('hub_tg_jawab');


		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_daftar']=date("Y-m-d H:i:s");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');	
		$data['userid']=$this->input->post('user_id');
		

		$id = $this->rjmregistrasi->insert_pasien_irj($data);

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Baru Berhasil.</h3> Data berhasil disimpan. Silahkan daftar ulang pasien.
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('irj/rjcregistrasi/daftarulangnew/' . $id);
	}
	
	// add sjj 2024
	public function cetak_registrasi($no_reg, $nocm)
    {
      
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_medrec($nocm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $this->load->view('emedrec/rj/formulir_pendaftaran/identitas_pasien', $data);
    }

	public function grab_kebutuhan_daftar_ulang_irj_sebelumnya($no_register)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->grab_kebutuhan_daftar_ulang_irj_sebelumnya($no_register);
		echo json_encode($data);
	}

	public function cari_poli_bpjs($val)
	{
		header('Content-Type: application/json;charset=utf-8');

		$data=$this->rjmpelayanan->cari_poli_bpjs($val);
		echo json_encode($data);

	}

	public function  ambil_surat_kontrol_terakhir($no_kartu)
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->rjmregistrasi->ambil_surat_kontrol_terakhir($no_kartu);
		echo json_encode($data);
		
	}

	public function update_daftar_ulang_irj_sep_irj()
	{
		header('Content-Type: application/json;charset=utf-8');
		$data = $this->input->post();
		// update daftar_ulang_irj
		unset($data['no_kartu']);
		if($data['asal_rujukan'] == '3'){
			$data['asal_rujukan'] = '2';
		}else{
			$data['asal_rujukan'] = '';
		}
		$update = $this->rjmregistrasi->update_daftar_ulang_irj_sep_igd($data);
		echo json_encode(['code'=>200]);
	}

	
	public function checksepavailable($no_register)
	{
		header('Content-Type: application/json;charset=utf-8');
		$checkSepIsAvailable = $this->rjmregistrasi->checkSepIsAvailable($no_register);
		echo json_encode(['code'=>$checkSepIsAvailable->no_sep?200:400,'message'=>$checkSepIsAvailable->no_sep?'OK':'Data Tidak Tersedia']);
	}

	public function list_bpjs_pasien()
	{
		$data = [
			'title'=>'LIST KUNJUNGAN PASIEN BPJS'
		];

		$this->load->view('sep/list_bpjs_pasien',$data);
	}

	public function get_listbpjs_kontrol($tgl_kunj1 = "", $tgl_kunj2 = "")
	{
		$tglkunjungan1 = !$tgl_kunj1?date('Y-m-d'):$tgl_kunj1;
		$tglkunjungan2 = !$tgl_kunj2?date('Y-m-d'):$tgl_kunj2;
		$data = $this->rjmregistrasi->get_list_pasien_kontrol($tglkunjungan1,$tglkunjungan2);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function get_listbpjs_konsul($tgl_kunj = "")
	{
		// var_dump($tgl_kunj);die();
		$tglkunjungan = !$tgl_kunj?date('Y-m-d'):$tgl_kunj;
		$data = $this->rjmregistrasi->get_list_pasien_konsul($tglkunjungan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function cek_available_nokartu_bpjs($nokartu)
	{
		$result = $this->rjmregistrasi->cek_no_kartu_bpjs($nokartu);
		// echo $result->num_rows();
		echo json_encode($result->row());
		// var_dump($result->row());
	}

	public function pembuatan_surat_kontrol()
	{
		$data = [
			'title'=>'Pembuatan Surat Kontrol'
		];

		$this->load->view('sep/pembuatan_surat_kontrol',$data);
	}

	public function get_listbpjs_pembuatan_kontrol($tgl_kunj = "")
	{
		// var_dump($tgl_kunj);die();
		$tglkunjungan = !$tgl_kunj?date('Y-m-d'):$tgl_kunj;
		$data = $this->rjmregistrasi->get_list_pasien_pembuatan_kontrol($tglkunjungan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}


	public function get_data_sep_vclaim()
	{
		$data = [
			'title'=>'Pengambilan data di vclaim'
		];

		$this->load->view('sep/ambil_data_sep_vclaim',$data);
	}

	public function get_listsep_by_vclaim($no_kartu = "")
	{
		// var_dump($tgl_kunj);die();
		if($no_kartu != ''){
			$data = $this->rjmregistrasi->get_list_pasien_sep_vclaim($no_kartu);
		}else{
			$data = '';
		}
		
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function get_listbpjs_rujukan($tgl_kunj = "")
	{
		// var_dump($tgl_kunj);die();
		$tglkunjungan = !$tgl_kunj?date('Y-m-d'):$tgl_kunj;
		$data = $this->rjmregistrasi->get_list_pasien_rujukan_rs($tglkunjungan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function get_listbpjs_posranap($tgl_kunj = "")
	{
		// var_dump($tgl_kunj);die();
		$tglkunjungan = !$tgl_kunj?date('Y-m-d'):$tgl_kunj;
		$data = $this->rjmregistrasi->get_list_pasien_kontrol_posranap($tglkunjungan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}

	public function get_listbpjs_backdate_ranap($tgl_kunj = "")
	{
		// var_dump($tgl_kunj);die();
		$tglkunjungan = !$tgl_kunj?date('Y-m-d'):$tgl_kunj;
		$data = $this->rjmregistrasi->get_list_pasien_backdate_posranap($tglkunjungan);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(['result'=>$data]);
	}
}
