<?php
defined('BASEPATH') or exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
// include('Rjcterbilang.php');

use GuzzleHttp\Client;

class Antrol extends Secure_area
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('antrol/mantrol', '', TRUE);
		$this->clients = new Client([
			'verify' => false,
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		// $this->endpoint = 'http://localhost:8000/';
		$this->load->library('vclaim');
	}

	function referensipoli()
	{
		if($this->input->get('hit') !=0){
			header('Content-Type: application/json; charset=utf-8');
			try {
				$response = $this->clients->request(
					'GET',
					$this->endpoint . 'wsbpjs/refpoli'
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$this->load->view('antrol/referensi_poli',['title'=>'Referensi Poli | Antrian Online BPJS']);
	}

	function referensidokter()
	{
		if($this->input->get('hit') !=0){
			header('Content-Type: application/json; charset=utf-8');
			try {
				$response = $this->clients->request(
					'GET',
					$this->endpoint . 'wsbpjs/refdokter'
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$this->load->view('antrol/referensi_dokter',['title'=>'Referensi Dokter | Antrian Online BPJS']);
	}

	function jadwaldokter()
	{
		if($this->input->get('hit') !=0){
			header('Content-Type: application/json; charset=utf-8');
			$param = $this->input->get();
			if($param['kodepoli'] == '' && $param['tanggal'] == ''){
				echo json_encode(['metadata'=>['code'=>400,'message'=>'Pastikan Tanggal dan Kode Poli Diisi']]);
				return;
			}
			try {
				$response = $this->clients->request(
					'GET',
					$this->endpoint . "wsbpjs/jadwaldokter/kodepoli/".$param['kodepoli']."/tanggal/".$param['tanggal']
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$data = 
		[
			'title'=>'Jadwal Dokter | Antrian Online BPJS',
			'poli'=>$this->mantrol->get_poliklinik_bpjs()
		];
		$this->load->view('antrol/jadwaldokter',$data);
	}

	function referensipolifinger()
	{
		if($this->input->get('hit') !=0){
			header('Content-Type: application/json; charset=utf-8');
			try {
				$response = $this->clients->request(
					'GET',
					$this->endpoint . 'wsbpjs/refpolifinger'
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$this->load->view('antrol/referensi_polifinger',['title'=>'Referensi Poli Finger Print | Antrian Online BPJS']);
	}

	function referensipasienfinger()
	{
		if($this->input->get('hit') !=0){
			header('Content-Type: application/json; charset=utf-8');
			$param = $this->input->get();
			if($param['pilihan'] == ''&& $param['noidentitas'] == ''){
				echo json_encode(['metadata'=>['code'=>400,'message'=>'Pastikan Tanggal dan Kode Poli Diisi']]);
				return;
			}
			try {
				$response = $this->clients->request(
					'GET',
					$this->endpoint . "wsbpjs/ref/pasien/fp/identitas/".$param['pilihan']."/noidentitas/".$param['noidentitas']
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$data = 
		[
			'title'=>'Referensi Pasien Fingerprint | Antrian Online BPJS',
		];
		$this->load->view('antrol/pasienfinger',$data);
	}

	function updatejadwaldokter()
	{
		if($this->input->post()){
			header('Content-Type: application/json; charset=utf-8');
			$param = $this->input->post();
			$posting = [
				'kodepoli'=>explode("@",$param['kodepoli'])[1],
				'kodesubspesialis'=>explode("@",$param['kodepoli'])[1],
				'kodedokter'=>$param['kodedokter'],
				'jadwal'=>[]
			];
			foreach($param['hari'] as $index=>$v)
			{
				array_push($posting['jadwal'],[
					'hari'=>$param['hari'][$index],
					'buka'=>$param['buka'][$index],
					'tutup'=>$param['tutup'][$index],

				]);
			}
			try {
				$response = $this->clients->post(
					$this->endpoint .'wsbpjs/jadwaldokter/updatejadwaldokter',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$posting
					]
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		$data = 
		[
			'title'=>'Update Jadwal Dokter | Antrian Online BPJS',
			'poli'=>$this->mantrol->get_poliklinik_bpjs()
		];
		$this->load->view('antrol/updatejadwaldokter',$data);
	}

	public function getdoctors()
	{
		header('Content-Type: application/json; charset=utf-8');
		$kodepoli = $this->input->get('kodepoli');
		if($kodepoli == '' || $kodepoli == null)
		{
			echo json_encode([
				'metadata'=>[
					'code'=>400,
					'message'=>'Poliklinik Harus dipilih dengan sesuai'
				]
			]);
			return;
		}

		echo json_encode(
			[
				'metadata'=>[
					'code'=>200,
					'message'=>'OK'
				],
				'response'=>$this->mantrol->get_dokter_bpjs($kodepoli)	
			]
		);
	}

	function index($loket='1')
	{
		if($this->input->get())
		{
			$param = $this->input->get();
			if(isset($param['tanggalpertama']) && isset($param['tanggalkedua'])){
				header('Content-Type: application/json; charset=utf-8');
				if($param['tanggalpertama'] == '' && $param['tanggalkedua'] == ''){
					echo json_encode(['metadata'=>['code'=>400,'message'=>'Pastikan Tanggal Diisi Dengan Benar']]);
					return;
				}
				try {
					$response = $this->clients->request(
						'GET',
						$this->endpoint . "adminantrian/statusantrianpertgl/".$param['tanggalpertama']."/".$param['tanggalkedua']
					)->getBody()->getContents();
					echo $response;
					return;
				} catch (Exception $e) {
					throw new \Exception($e->getMessage(), 1);
				}
				return;
			}
		}
		if($this->input->post()){
			header('Content-Type: application/json; charset=utf-8');
			$param = $this->input->post();
			$posting = [
				'kodepoli'=>explode("@",$param['kodepoli'])[1],
				'kodesubspesialis'=>explode("@",$param['kodepoli'])[1],
				'kodedokter'=>$param['kodedokter'],
				'jadwal'=>[]
			];
			foreach($param['hari'] as $index=>$v)
			{
				array_push($posting['jadwal'],[
					'hari'=>$param['hari'][$index],
					'buka'=>$param['buka'][$index],
					'tutup'=>$param['tutup'][$index],

				]);
			}
			try {
				$response = $this->clients->post(
					$this->endpoint .'wsbpjs/jadwaldokter/updatejadwaldokter',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$posting
					]
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		
		$data = 
		[
			'title'=>'Daftar Antrian Online | Antrian Online BPJS',
			'loket'=>$loket
		];
		$this->load->view('antrol/index',$data);
	}


	
	function indexv2($loket='1')
	{
		if($this->input->get())
		{
			$param = $this->input->get();
			if(isset($param['tanggalpertama']) && isset($param['tanggalkedua'])){
				header('Content-Type: application/json; charset=utf-8');
				if($param['tanggalpertama'] == '' && $param['tanggalkedua'] == ''){
					echo json_encode(['metadata'=>['code'=>400,'message'=>'Pastikan Tanggal Diisi Dengan Benar']]);
					return;
				}
				$url = "adminantrian/statusantrianpertglbatal/".$param['tanggalpertama']."/".$param['tanggalkedua'];
				if(isset($param['selesai'])){
					$url = "adminantrian/statusantrianpertglselesai/".$param['tanggalpertama']."/".$param['tanggalkedua'];
				}
				try {
					$response = $this->clients->request(
						'GET',
						$this->endpoint . $url
					)->getBody()->getContents();
					echo $response;
					return;
				} catch (Exception $e) {
					throw new \Exception($e->getMessage(), 1);
				}
				return;
			}
		}
		if($this->input->post()){
			header('Content-Type: application/json; charset=utf-8');
			$param = $this->input->post();
			$posting = [
				'kodepoli'=>explode("@",$param['kodepoli'])[1],
				'kodesubspesialis'=>explode("@",$param['kodepoli'])[1],
				'kodedokter'=>$param['kodedokter'],
				'jadwal'=>[]
			];
			foreach($param['hari'] as $index=>$v)
			{
				array_push($posting['jadwal'],[
					'hari'=>$param['hari'][$index],
					'buka'=>$param['buka'][$index],
					'tutup'=>$param['tutup'][$index],

				]);
			}
			try {
				$response = $this->clients->post(
					$this->endpoint .'wsbpjs/jadwaldokter/updatejadwaldokter',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$posting
					]
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;

		}
		
		$data = 
		[
			'title'=>'Daftar Antrian Online | Antrian Online BPJS',
			'loket'=>$loket
		];
		$this->load->view('antrol/indexv2',$data);
	}

	function kirimwsbpjs()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = base64_decode($this->input->get('data'));
		// var_dump($data);
		// die();
		$req = json_decode($data);
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		

		if($req->nomorreferensi == '' && $req->jeniskunjungan == 3){
			// cek suratkontrol dan ambil di db
			$ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($req->nomorkartu);
			if($ambilnomorsuratkontrol !=null){
				$req->nomorreferensi = $ambilnomorsuratkontrol->surat_kontrol;
			}
		}
		// var_dump($req);
		// die();
		// yang diperlukan 
		$payloads = array(
			"kodebooking" => $req->kodebooking,
			"jenispasien" => $req->jenispasien,
			"nomorkartu" => $req->nomorkartu,
			"nik" => $req->nik,
			"nohp" => $req->nohp,
			"kodepoli" => $req->kodepoli,
			"namapoli" => $req->namapoli,
			"pasienbaru" => intval($req->pasienbaru),
			"norm" => str_pad($req->norm, 8, '0', STR_PAD_LEFT),
			"tanggalperiksa" => date('Y-m-d', strtotime($req->tanggalperiksa)),
			"kodedokter" => intval($req->kodedokter),
			"namadokter" => $req->namadokter,
			"jampraktek" => $req->jampraktek,
			"jeniskunjungan" => $req->jenispasien == 'NON JKN'?'2':$req->jeniskunjungan, //-> production
			// "jeniskunjungan" => 2, // development
			"nomorreferensi" => $req->nomorreferensi,
			"nomorantrean" => $req->nomorantrian,
			"angkaantrean" => intval($req->angkaantrean),
			"estimasidilayani" => intval($req->estimasidilayani),
			"sisakuotajkn" => intval($req->sisakuotajkn),
			"kuotajkn" => intval($req->kuotajkn),
			"sisakuotanonjkn" => intval($req->sisakuotanonjkn),
			"kuotanonjkn" => intval($req->kuotanonjkn),
			"keterangan" => "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
		);
		// var_dump($payloads);die();
		$this->endpoint = 'http://192.168.1.139:8000/';
		$response = $this->clients->post(
			$this->endpoint .'wsbpjs/antrean/add',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$payloads
			]
		)->getBody()->getContents();
		$json = json_decode($response);
		if($json->metadata->code == 200){
			// hit task id 1
			if($payloads['pasienbaru'] == 1){
				$this->endpoint = 'http://192.168.1.139:8000/';
				$response = $this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$payloads['kodebooking'].'/1',
					[
						'headers'=>['Content-Type'=>'application/json']
					]
				)->getBody()->getContents();
				echo $response;
				return;
			}
		}
		echo $response;
	}

	function updatetaskidmanual($kodebooking,$taskid){
		$this->endpoint = 'http://192.168.1.139:8000/';
		$response = $this->clients->get(
			$this->endpoint .'adminantrian/prosesantrian/'.$kodebooking.'/'.$taskid,
			[
				'headers'=>['Content-Type'=>'application/json']
			]
		)->getBody()->getContents();
		echo $response;
		return true;
	}

	function panggil()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = base64_decode($this->input->get('data'));
		// var_dump($data);
		$req = json_decode($data);
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$posting = [
			'kodebooking'=>$req->kodebooking,
			'keterangan'=>''
		];
		$this->endpoint = 'http://192.168.1.139:8000/';
		$response = $this->clients->post(
			$this->endpoint .'adminantrian/panggil_admisi',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$posting
			]
		)->getBody()->getContents();
		echo $response;

	}

	function batalantrean()
	{
		header('Content-Type: application/json; charset=utf-8');

		$req = json_decode(base64_decode($this->input->get('patient')));
		/**
		 * Added untuk keperluan antrol update task id => 5
		 */
		if($req->kodebooking != '' && $req->kodebooking != null){
			$this->clients = new Client([
				'verify' => false,
				// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
			]);
			$posting = [
				'kodebooking'=>$req->kodebooking,
				'keterangan'=>'Pasien Tidak Hadir'
			];
			$this->endpoint = 'http://192.168.1.139:8000/';
			$response = $this->clients->post(
				$this->endpoint .'adminantrian/batalantrian',
				[
					'headers'=>['Content-Type'=>'application/json'],
					'json'=>$posting
				]
			)->getBody()->getContents();
			echo $response;
		}
	}

	
	function taskid()
	{
		header('Content-Type: application/json; charset=utf-8');
		$req = json_decode(base64_decode($this->input->get('patient')));
		if($req->kodebooking != '' && $req->kodebooking != null){
			$this->clients = new Client([
				'verify' => false,
				// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
			]);
			$posting = [
				'kodebooking'=>$req->kodebooking,
			];
			$this->endpoint = 'http://192.168.1.139:8000/';
			$response = $this->clients->post(
				$this->endpoint .'wsbpjs/antrean/getlisttask',
				[
					'headers'=>['Content-Type'=>'application/json'],
					'json'=>$posting
				]
			)->getBody()->getContents();
			echo $response;
		}
	}

	
	function antrean()
	{
		if($this->input->get()){

			$req = $this->input->get();
			if(isset($req['tanggal'])){
				header('Content-Type: application/json; charset=utf-8');
				
				if($req['tanggal'] != '' && $req['tanggal'] != null){
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$response = $this->clients->get(
						$this->endpoint .'wsbpjs/antrean/pendaftaran/tanggal/'.$req['tanggal']
					)->getBody()->getContents();
					echo $response;
					return;
				}
			}
			if(isset($req['kodebooking'])){
				header('Content-Type: application/json; charset=utf-8');

				if($req['kodebooking'] != '' && $req['kodebooking'] != null){
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$response = $this->clients->get(
						$this->endpoint .'wsbpjs/antrean/pendaftaran/kodebooking/'.$req['kodebooking']
					)->getBody()->getContents();
					echo $response;
					return;
				}
			}
			if(isset($req['antrian_belum_dilayani'])){
				header('Content-Type: application/json; charset=utf-8');

				$this->clients = new Client([
					'verify' => false,
					// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
				]);
				$this->endpoint = 'http://192.168.1.139:8000/';
				$response = $this->clients->get(
					$this->endpoint .'wsbpjs/antrean/pendaftaran/aktif'
				)->getBody()->getContents();
				echo $response;
				return;
			}
		}
		$data = 
		[
			'title'=>'Antrean Pendaftaran | Antrian Online BPJS',
		];
		$this->load->view('antrol/antrean',$data);
	}

	function dashboard()
	{
		if($this->input->get()){

			$req = $this->input->get();
			if(isset($req['tanggal']) && isset($req['waktu'])){
				header('Content-Type: application/json; charset=utf-8');
				
				if($req['tanggal'] != '' && $req['tanggal'] != null && $req['waktu'] != '' && $req['waktu'] != null){
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$response = $this->clients->get(
						$this->endpoint .'wsbpjs/dashboard/waktutunggu/tanggal/'.$req['tanggal'].'/waktu/'.$req['waktu']
					)->getBody()->getContents();
					echo $response;
					return;
				}
			}
			
		}
		$data = 
		[
			'title'=>'Dashboard Per Tanggal | Antrian Online BPJS',
		];
		$this->load->view('antrol/dashboard',$data);
	}

	function dashboard_bulan()
	{
		if($this->input->get()){

			$req = $this->input->get();
			if(isset($req['bulan']) && isset($req['tahun']) && isset($req['waktu'])){
				header('Content-Type: application/json; charset=utf-8');
				
				if($req['bulan'] != '' && $req['bulan'] != null && $req['waktu'] != '' && $req['waktu'] != null&&$req['tahun'] != '' &&$req['tahun'] != null){
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$response = $this->clients->get(
						$this->endpoint .'wsbpjs/dashboard/waktutunggu/bulan/'.$req['bulan'].'/tahun/'.$req['tahun'].'/waktu/'.$req['waktu']
					)->getBody()->getContents();
					echo $response;
					return;
				}
			}
			
		}
		$data = 
		[
			'title'=>'Dashboard Per Bulan | Antrian Online BPJS',
		];
		$this->load->view('antrol/dashboard_bulan',$data);
	}


	function dashboard_per()
	{
		if ($this->input->get()) {
			$req = $this->input->get();
			if (isset($req['kodepoli']) && isset($req['kodedokter']) && isset($req['hari']) && isset($req['jampraktek'])) {
				header('Content-Type: application/json; charset=utf-8');

				if ($req['kodepoli'] != '' && $req['kodepoli'] != null && $req['kodedokter'] != '' && $req['kodedokter'] != null && $req['hari'] != '' && $req['hari'] != null && $req['jampraktek'] != '' && $req['jampraktek'] != null) {
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$response = $this->clients->get(
						$this->endpoint . 'wsbpjs/antrean/pendaftaran/kodepoli/' . $req['kodepoli'] . '/kodedokter/' . $req['kodedokter'] . '/hari/' . $req['hari'] . '/jampraktek/' . $req['jampraktek']
					)->getBody()->getContents();
					echo $response;
					return;
				}
			}
		}

		$data = [
			'title' => 'Dashboard Per Poli Per Dokter Per Hari Per Jam Praktek | Antrian Online BPJS',
		];
		$this->load->view('antrol/dashboard_per', $data);
	}


	/**
	 * Fungsi : Onsite Daftar Antrian Online
	 * Param : 
	 * get -> ceknokartu: 1 else load tampilan
	 * post -> nomorkartu: <nomor kartu bpjs> 
	 * logic:
	 * 1. ambil nomor kartu dari inputan, cek 13 digit else return gagal!
	 * 2. (datapasien) 	cari dari db exist? ambil else? return pasien baru
	 * 3. (datapasien) 	cari dari service bpjs berdasarkan nomor kartu bpjs exist? ambil else? return gagal!
	 * 4. (rujukan) 	cari dari service bpjs berdasarkan nomor kartu bpjs exist? ambil else? return null!  
	 * Return 
	 * {
	 * 	'nik':'',
	 * 	'nohp:'',
	 * 	'norm:'',
	 * 	'kodepoli:'',
	 * 	'tglperiksa:'',
	 * 	'jeniskunjungan:'',
	 * 	'nomorreferensi:'',
	 * }
	 */
	function onsite()
	{

		if($this->input->get('submit') == '1'){
			header('Content-Type: application/json; charset=utf-8');
			
			if($this->input->get('nonjkn') == '1'){
				$req = $this->input->post();
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
				// 	"namadokter": "",
				// 	"namapoli": "",
				// 	"nama": "",
				// 	"estimasidilayani": "",
				// 	"sisakuotajkn": "",
				// 	"kuotajkn": "",
				// 	"sisakuotanonjkn": "",
				// 	"kuotanonjkn": "",
				// 	"pasienbaru": "string"
				//   }
				$req['nomorkartu'] = '';
				$req['tanggalperiksa'] = date('Y-m-d');
				$req['kodedokter'] = explode('@',$req['kodedokter'])[0];
				$req['jeniskunjungan'] = 0;
				$req['nomorreferensi'] = '';
				$req['jenispasien'] = 'NON JKN';
				// var_dump($req);
				// echo json_encode($req);
				try {
					$response = $this->clients->post(
						$this->endpoint .'adminantrian/ambilantriannonjkn',
						[
							'headers'=>['Content-Type'=>'application/json'],
							'json'=>$req
						]
					)->getBody()->getContents();
					echo $response;
					return;
				} catch (Exception $e) {
					throw new \Exception($e->getMessage(), 1);
				}
				


				return;
			}

			
			$req = $this->input->post();
			$req['tanggalperiksa'] = date('Y-m-d');
			$req['kodedokter'] = explode('@',$req['kodedokter'])[0];
			
			try {
				$response = $this->clients->post(
					$this->endpoint .'adminantrian/ambilantrianlama',
					[
						'headers'=>['Content-Type'=>'application/json'],
						'json'=>$req
					]
				)->getBody()->getContents();
				echo $response;
				return;
			} catch (Exception $e) {
				throw new \Exception($e->getMessage(), 1);
			}
			return;
		}

		if($this->input->get('cekdokter') == '1')
		{
			header('Content-Type: application/json; charset=utf-8');
			$this->clients = new Client([
				'verify' => false,
				// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
			]);
			$this->endpoint = 'http://192.168.1.139:8000/';
			$response = $this->clients->get(
				$this->endpoint .'wsbpjs/jadwaldokter/kodepoli/'.$this->input->get('val').'/tanggal/'.date('Y-m-d')
			)->getBody()->getContents();
			echo $response;
			return;
		}

		if($this->input->get('cekpoliklinik') == '1'){
			header('Content-Type: application/json; charset=utf-8');
			$result = $this->mantrol->get_poliklinik_bpjs_antrol();
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$result
			]
			);
			return;
		}
		if($this->input->get('ceknokartu') == '1'){
			header('Content-Type: application/json; charset=utf-8');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				echo json_encode([
					'metaData'=>[
						'code'=>400,
						'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
					]
				]);
				return;
			}
			$datapasien = $this->mantrol->get_data_pasien($nomorkartu);
			if(!$datapasien){
				$url = '/Peserta/nokartu/'.$nomorkartu.'/'.$this->input->get('nomor').'/tglSEP/'.date('Y-m-d');
				$grabPasienBpjs = json_decode($this->vclaim->get($url));
				if($grabPasienBpjs->metaData->code != '200'){
					echo $grabPasienBpjs;
					return;
				}
				$datapasien = $grabPasienBpjs->response;
				// var_dump($datapasien);die();
				if($datapasien->peserta->statusPeserta->keterangan != 'AKTIF'){
					echo json_encode([
						'metaData'=>[
							'code'=>201,
							'message'=>'Status Peserta Tidak Aktif'
						]
						]);
						return;
				}

				
				$pasien = [
					'nik'=>$datapasien->peserta->nik,
					'nohp'=>$datapasien->peserta->mr->noTelepon,
					'norm'=>$datapasien->peserta->mr->noMR,
				];
			}else{
				$pasien = [
					'nik'=>$datapasien->nik,
					'nohp'=>$datapasien->nohp,
					'norm'=>$datapasien->norm,
				];
			}
			$url = '/Rujukan/Peserta/'.$nomorkartu;
			$datarujukan = json_decode($this->vclaim->get($url));
			if($datarujukan->metaData->code == '200'){
				// * 	'kodepoli:'',
				// * 	'tglperiksa:'',
				// * 	'jeniskunjungan:'',
				// * 	'nomorreferensi:'',
				$pasien['kodepoli'] = $datarujukan->response->rujukan->poliRujukan;
				$pasien['tglperiksa']= date('Y-m-d');
				// disini cek berapa jumlah sep berdasarkan nomor kartu.
				$url = 'Rujukan/JumlahSEP/1/'.$datarujukan->response->rujukan->noKunjungan;
				$datajumlahsep = json_decode($this->vclaim->get($url));
				$jumlahsep = '0';
				if($datajumlahsep->metaData->code == '200'){
					$jumlahsep = $datajumlahsep->response->jumlahSEP;
				}
				if($jumlahsep == '0'){
					$pasien['jeniskunjungan'] = 1;
					$pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
				}else if($jumlahsep >= 1){
					// ambil poli
					$poli = $this->input->post('kodepoli');
					if($poli == $datarujukan->response->rujukan->poliRujukan->kode){
						// menandakan poli sama dengan poli rujukan maka nomor referensi = nomor surat kontrol
						// ambil nomor surat kontrol berdasarkan nomor rujukan dimana nomor sep is null atau ''(belum cetak sep)
						// $ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($nomorkartu);
						// if($ambilnomorsuratkontrol !=null){
						// 	$pasien['nomorreferensi'] = $ambilnomorsuratkontrol->surat_kontrol;
						// 	$pasien['jeniskunjungan'] = 3;
						// }else{
						// 	$pasien['nomorreferensi'] = '';
						// 	$pasien['jeniskunjungan'] = 3;
						// }
						/**
						 * Overhaul in version 1.1.0
						 * ambil surat kontrol langsung dari BPJS 7 hari dari hari ini.
						 */
						$yearnow = date("Y");
						$monthnow = date("m");
						$url = "/RencanaKontrol/ListRencanaKontrol/Bulan/$monthnow/Tahun/$yearnow/Nokartu/$nomorkartu/filter/2";
						$suratkontrolnew = json_decode($this->vclaim->get($url));
						// var_dump($suratkontrolnew);die();
						if($suratkontrolnew->metaData->code == '200'){
							// check jika surat kontrol ada  
							// ambil yang pertama [0]
							if(count($suratkontrolnew->response->list)>0){
								/**
								 * Penambahan versi 1.1.1 
								 * added filter untuk hanya mengambil list kontrol yang bukan namaJnsKontrol = 'SPRI'
								 */
								$datasuratkontrolfirst = '';
								foreach($suratkontrolnew->response->list as $v){
									// filter hanya surat kontrol
									if($v->namaJnsKontrol !='SPRI'){
										// filter ada tidak datasuratkontrol, jika tidak ada. maka masukan.
										if($datasuratkontrolfirst == '')
										{
											$datasuratkontrolfirst = $v->noSuratKontrol;
										}
									}
								}
								$pasien['nomorreferensi'] = $datasuratkontrolfirst;
								$pasien['jeniskunjungan'] = 3;
							}
						}else{
							$pasien['nomorreferensi'] = '';
							$pasien['jeniskunjungan'] = 3;
							
						}
						
					}else{
						// menandakan poli beda dengan poli rujukan maka nomor referensi = nomor rujukan
						$pasien['jeniskunjungan'] = 2;
						// $pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
						$pasien['nomorreferensi'] = "$poli"."0304R".date("dmY").sprintf("%03d", $this->mantrol->get_counter_internal());
					}
				}
				
			}else{
				$url = 'Rujukan/RS/Peserta/'.$nomorkartu;
				$datarujukanrs = json_decode($this->vclaim->get($url));
				if($datarujukanrs->metaData->code == '200'){
					$pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
					$pasien['tglperiksa']= date('Y-m-d');
					// disini cek berapa jumlah sep berdasarkan nomor kartu.
					$url = 'Rujukan/JumlahSEP/2/'.$datarujukanrs->response->rujukan->noKunjungan;
					$datajumlahsep = json_decode($this->vclaim->get($url));
					$jumlahsep = '0';
					if($datajumlahsep->metaData->code == '200'){
						$jumlahsep = $datajumlahsep->response->jumlahSEP;
					}
					if($jumlahsep == '0'){
						$pasien['jeniskunjungan'] = 1;
						$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
					}else if($jumlahsep >= 1){
						// ambil poli
						$poli = $this->input->post('kodepoli');
						if($poli == $datarujukanrs->response->rujukan->poliRujukan->kode){
							// menandakan poli sama dengan poli rujukan maka nomor referensi = nomor surat kontrol
							// ambil nomor surat kontrol berdasarkan nomor rujukan dimana nomor sep is null atau ''(belum cetak sep)
							// $ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($nomorkartu);
							// if($ambilnomorsuratkontrol !=null){
							// 	$pasien['nomorreferensi'] = $ambilnomorsuratkontrol->surat_kontrol;
							// 	$pasien['jeniskunjungan'] = 3;
							// }else{
							// 	$pasien['nomorreferensi'] = '';
							// 	$pasien['jeniskunjungan'] = 3;
							// }
							/**
						 * Overhaul in version 1.1.0
						 * ambil surat kontrol langsung dari BPJS 7 hari dari hari ini.
						 */
						$yearnow = date("Y");
						$monthnow = date("m");
						$url = "/RencanaKontrol/ListRencanaKontrol/Bulan/$monthnow/Tahun/$yearnow/Nokartu/$nomorkartu/filter/2";
						$suratkontrolnew = json_decode($this->vclaim->get($url));
						// var_dump($suratkontrolnew);die();
						if($suratkontrolnew->metaData->code == '200'){
							// check jika surat kontrol ada  
							// ambil yang pertama [0]
							if(count($suratkontrolnew->response->list)>0){
								/**
								 * Penambahan versi 1.1.1 
								 * added filter untuk hanya mengambil list kontrol yang bukan namaJnsKontrol = 'SPRI'
								 */
								$datasuratkontrolfirst = '';
								foreach($suratkontrolnew->response->list as $v){
									// filter hanya surat kontrol
									if($v->namaJnsKontrol !='SPRI'){
										// filter ada tidak datasuratkontrol, jika tidak ada. maka masukan.
										if($datasuratkontrolfirst == '')
										{
											$datasuratkontrolfirst = $v->noSuratKontrol;
										}
									}
								}
								$pasien['nomorreferensi'] = $datasuratkontrolfirst;
								$pasien['jeniskunjungan'] = 3;
							}
						}else{
							$pasien['nomorreferensi'] = '';
							$pasien['jeniskunjungan'] = 3;
							
						}
							
							
						}else{
							// menandakan poli beda dengan poli rujukan maka nomor referensi = nomor rujukan
							$pasien['jeniskunjungan'] = 2;
							// $pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
							$pasien['nomorreferensi'] = "$poli"."0304R".date("dmY").sprintf("%03d", $this->mantrol->get_counter_internal());
						}
					}
					
				}else{
					$pasien['kodepoli'] ='';
					$pasien['tglperiksa']= date('Y-m-d');
					$pasien['jeniskunjungan'] = '';
					$pasien['nomorreferensi'] = '';
				}
			}
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$pasien
			]);
			return;
		}
		$this->load->view('antrol/onsite');
	}

	public function pasienbaru(){
		header('Content-Type: application/json; charset=utf-8');
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		$posting = $this->input->post();
		
		// {
		// 	"nomorkartu": "0002046159753",
		// 	"nik": "6408042011200004",
		// 	"nomorkk": "1212452133213",
		// 	"nama": "TESDSSS",
		// 	"jeniskelamin": "L",
		// 	"tanggallahir": "2021-01-01",
		// 	"nohp": "089127489899",
		// 	"alamat": "JALAN JALAN",
		// 	 "kodeprop": "11",
		// 	 "namaprop": "Jawa Barat",
		// 	 "kodedati2": "0120",
		// 	 "namadati2": "Kab. Bandung",
		// 	 "kodekec": "1319",
		// 	 "namakec": "Soreang",
		// 	 "kodekel": "D2105",
		// 	 "namakel": "Cingcin",
		// 	 "rw": "001",
		// 	 "rt": "013"
		//   }
		// $prop =  explode("@",$posting['kodeprop']);
		$posting['kodeprop'] =explode("@",$this->input->post('kodeprop'))[0];
		$posting['namaprop'] =explode("@",$this->input->post('kodeprop'))[1];

		// $dati2 = explode("@",$posting['kodedati2']);
		$posting['kodedati2'] =explode("@",$this->input->post('kodedati2'))[0];
		$posting['namadati2'] =explode("@",$this->input->post('kodedati2'))[1];

		// $kec = explode("@",$posting['kodekec']);
		$posting['kodekec'] =explode("@",$this->input->post('kodekec'))[0];
		$posting['namakec'] =explode("@",$this->input->post('kodekec'))[1];

		// $kel = explode("@",$posting['kodekel']);
		$posting['kodekel'] ='D2105';
		$posting['namakel'] ='Cingcin';
		// echo "<pre>";
		// var_dump($posting);
		// echo "</pre>";
		// die();

		$response = $this->clients->post(
			$this->endpoint .'adminantrian/pasienbaru',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$posting
			]
		)->getBody()->getContents();
		echo $response;
	}

	function icare()
	{
		if($this->input->get('hit') !=0){
			// '0001305764133'
			// 402088
			header('Content-Type: application/json; charset=utf-8');
			$data = [
				'param'=>$this->input->get('nokartu'),
				'kodedokter'=>intval($this->input->get('pilihan'))
			];
			// var_dump($data);die();
			echo $this->vclaim->posticare('wsihs/api/rs/validate',$data,[],'https://apijkn.bpjs-kesehatan.go.id/');
			return;

		}
		$data = 
		[
			'title'=>'ICare BPJS Kesehatan',
		];
		$this->load->view('antrol/icare',$data);
	}

	public function dashboard_antrian_poli($kodepoli=''){
		$data['kodepoli'] = $kodepoli;
		// var_dump($data['kodepoli']);
		$this->load->view('antrol/dashboard_antrian_poli',$data);
	}

	public function get_data_dashboard_antrian_poli($kodepoli)
	{
		header('Content-Type: application/json');
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . "adminantrian/dashboardantrian/".$kodepoli
			)->getBody()->getContents();
			echo $response;
			return;
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
	}

	public function dashboard_antrian_farmasi(){
		$data = [];
		$this->load->view('antrol/dashboard_antrian_farmasi',$data);
	}

	public function get_data_dashboard_antrian_farmasi()
	{
		header('Content-Type: application/json');
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . "adminantrian/dashboardantrianfarmasi/"
			)->getBody()->getContents();
			echo $response;
			return;
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
	}

	public function dashboard_antrian_admisi(){
		$data = [];
		$this->load->view('antrol/dashboard_antrian_admisi',$data);
	}

	public function get_data_dashboard_antrian_admisi()
	{
		header('Content-Type: application/json');
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . "adminantrian/dashboardantrianadmisi/"
			)->getBody()->getContents();
			echo $response;
			return;
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
	}

	public function referensitaskid()
    {
        // Jika parameter hit ada, maka lakukan request API
        if($this->input->get('hit') != 0){
            header('Content-Type: application/json; charset=utf-8');
            // Ambil tanggalawal dan tanggalakhir dari parameter GET (opsional)
            $tanggalawal = $this->input->get('tanggalawal') ? $this->input->get('tanggalawal') : date('Y-m-d');
            $tanggalakhir = $this->input->get('tanggalakhir') ? $this->input->get('tanggalakhir') : date('Y-m-d');
            try {
                $response = $this->clients->request(
                    'GET',
                    $this->endpoint . 'adminantrian/taskid?tanggalawal=' . $tanggalawal . '&tanggalakhir=' . $tanggalakhir
                )->getBody()->getContents();
                echo $response;
                return;
            } catch (Exception $e) {
                // Tangani error jika terjadi
                echo json_encode([
                    'metadata' => [
                        'code' => 500,
                        'message' => $e->getMessage()
                    ]
                ]);
                return;
            }
        }

		// Handle export request
		if($this->input->get('export')) {
			$this->export_referensitaskid();
			return;
		}
        // Jika tidak ada parameter hit, tampilkan view
        $this->load->view('taskid_view', ['title'=>'Data Task ID']);
    }

	private function export_referensitaskid()
	{
		$tanggalawal = $this->input->get('tanggalawal') ?: date('Y-m-d');
		$tanggalakhir = $this->input->get('tanggalakhir') ?: date('Y-m-d');

		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . 'adminantrian/taskid?tanggalawal=' . $tanggalawal . '&tanggalakhir=' . $tanggalakhir
			)->getBody()->getContents();

			$data = json_decode($response, true);
			
			if($data['metadata']['code'] !== 200) {
				throw new Exception($data['metadata']['message']);
			}

			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Header
			$sheet->setCellValue('A1', 'ID');
			$sheet->setCellValue('B1', 'Created');
			$sheet->setCellValue('C1', 'Nama');
			$sheet->setCellValue('D1', 'Kodebooking');
			$sheet->setCellValue('E1', 'Hit');
			$sheet->setCellValue('F1', 'Request');
			$sheet->setcelLValue('G1', 'Response');
			$sheet->setCellValue('H1', 'Status');

			// Data
			$row = 2;
			foreach($data['response'] as $item) {
				$timestamp = strtotime($item['created']);
    			$formattedCreated = ($timestamp !== false) ? date('Y-m-d', $timestamp) : 'Invalid Date';
				$sheet->setCellValue('A'.$row, $item['id']);
				$sheet->setCellValue('B'.$row, $formattedCreated);
				$sheet->setCellValue('C'.$row, $item['nama']);
				$sheet->setCellValue('D'.$row, $item['kodebooking']);
				$sheet->setCellValue('E'.$row, $item['hit']);
				$sheet->setCellValue('F'.$row, $item['request']);
				$sheet->setCellValue('G'.$row, $item['response']);
				$sheet->setCellValue('H'.$row, $item['status']);
				$row++;
			}

			// Styling header
			$headerStyle = [
				'font' => ['bold' => true],
				'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
				'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
			];
			$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

			// Auto size columns
			foreach(range('A','H') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			$filename = 'taskid_'.$tanggalawal.'_'.$tanggalakhir.'.xlsx';

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
			exit;

		} catch (Exception $e) {
			$this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(json_encode([
					'metadata' => [
						'code' => 500,
						'message' => $e->getMessage()
					]
				]));
		}
	}

	public function panggilantrianadmisi()
	{
		header('Content-Type: application/json; charset=utf-8');

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo json_encode([
				'success' => false,
				'message' => 'Method not allowed'
			]);
			return;
		}

		$id = $this->input->post('id');
		$loket = $this->input->post('loket');
		$no_antrian = $this->input->post('no_antrian');
		$status = $this->input->post('status'); // Ambil parameter status

		// Debug log untuk melihat parameter yang diterima
		error_log("panggilantrianadmisi received params - id: $id, loket: $loket, no_antrian: $no_antrian, status: $status");

		if (!$id || !$loket || !$no_antrian) {
			echo json_encode([
				'success' => false,
				'message' => 'Parameter tidak lengkap'
			]);
			return;
		}

		try {
			$this->clients = new Client(['verify' => false]);

			$posting = [
				'id' => $id,
				'loket' => $loket,
				'no_antrian' => $no_antrian,
				'status' => $status ?: 'dipanggil' // Gunakan status yang dikirim, default 'dipanggil'
			];

			// Debug log untuk melihat data yang akan dikirim ke API
			error_log("Sending to API: " . json_encode($posting));

			$response = $this->clients->post(
				$this->endpoint . 'adminantrian/v2/panggilantrian',
				[
					'headers' => ['Content-Type' => 'application/json'],
					'json' => $posting
				]
			)->getBody()->getContents();

			// Debug log untuk melihat response dari API
			error_log("API Response: " . $response);

			$result = json_decode($response, true);

			// Debug log untuk melihat hasil decode
			error_log("Decoded result: " . json_encode($result));

			if ($result && isset($result['metadata']) && $result['metadata']['code'] == 200) {
				echo json_encode([
					'success' => true,
					'message' => 'Antrian berhasil dipanggil',
					'data' => [
						'id' => $id,
						'loket' => $loket,
						'no_antrian' => $no_antrian
					],
					'api_response' => $result // Tambahkan response API untuk debug
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => $result['metadata']['message'] ?? 'Gagal memanggil antrian',
					'api_response' => $result // Tambahkan response API untuk debug
				]);
			}

		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			]);
		}
	}

	public function updatestatusantrian()
	{
		header('Content-Type: application/json; charset=utf-8');

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo json_encode([
				'success' => false,
				'message' => 'Method not allowed'
			]);
			return;
		}

		$id = $this->input->post('id');
		$status = $this->input->post('status'); // processed, completed

		if (!$id || !$status) {
			echo json_encode([
				'success' => false,
				'message' => 'Parameter tidak lengkap'
			]);
			return;
		}

		try {
			$this->clients = new Client(['verify' => false]);

			$posting = [
				'id' => $id,
				'status' => $status
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
	}

	public function hapusantrian()
	{
		header('Content-Type: application/json; charset=utf-8');

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo json_encode([
				'success' => false,
				'message' => 'Method not allowed'
			]);
			return;
		}

		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode([
				'success' => false,
				'message' => 'ID antrian tidak ditemukan'
			]);
			return;
		}

		try {
			$this->clients = new Client(['verify' => false]);

			$posting = [
				'id' => $id
			];

			$response = $this->clients->post(
				$this->endpoint . 'adminantrian/v2/hapusantrian',
				[
					'headers' => ['Content-Type' => 'application/json'],
					'json' => $posting
				]
			)->getBody()->getContents();

			$result = json_decode($response, true);

			if ($result && isset($result['metadata']) && $result['metadata']['code'] == 200) {
				echo json_encode([
					'success' => true,
					'message' => 'Antrian berhasil dihapus',
					'data' => [
						'id' => $id
					]
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => $result['metadata']['message'] ?? 'Gagal menghapus antrian'
				]);
			}

		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			]);
		}
	}

	

	public function dashboard_antrian_multi($poli1='', $poli2='', $poli3='', $poli4='', $poli5=''){
		// Gabungkan parameter poli yang tidak kosong
		$poli_params = array_filter([$poli1, $poli2, $poli3, $poli4, $poli5], function($poli) {
			return !empty($poli);
		});

		$data['kodepolis'] = implode(',', $poli_params);
		$data['poli_list'] = $poli_params;
		$this->load->view('antrol/dashboard_antrian_multi',$data);
	}

	public function get_data_dashboard_antrian_multi($kodepolis)
	{
		header('Content-Type: application/json');
		try {
			// Parse poli list dari comma separated string
			$poli_list = array_map('trim', explode(',', $kodepolis));

			// Batasi maksimal 5 poli
			$poli_list = array_slice($poli_list, 0, 5);

			if (empty($poli_list)) {
				echo json_encode([
					'metadata' => [
						'code' => 400,
						'message' => 'Format poli tidak valid'
					]
				]);
				return;
			}

			// Load model rjmpelayanan
			$this->load->model('irj/rjmpelayanan', '', TRUE);

			// Ambil data antrian dari database
			$result = $this->rjmpelayanan->get_dashboard_multi_poli($poli_list);
			$data_antrian = $result->result();

			// Ambil info pemanggilan terakhir
			$latest_call = $this->rjmpelayanan->get_latest_call_info($poli_list);

			// Group data berdasarkan dokter dan poli
			$doctors = [];
			$grouped_data = [];

			foreach ($data_antrian as $row) {
				$key = $row->id_poli . '_' . $row->id_dokter;

				if (!isset($grouped_data[$key])) {
					$grouped_data[$key] = [
						'dokter' => $row->nm_dokter ?: 'Dokter Tidak Diketahui',
						'poli' => $row->nm_poli ?: $row->id_poli,
						'kodepoli' => $row->id_poli,
						'kodedokter' => $row->id_dokter,
						'is_latest_call' => false,
						'pasiendilayani' => null,
						'pasien' => [],
						'total_antrian' => 0
					];
				}

				// Tentukan status pasien
				if ($row->status_antrian === 'sedang_dilayani' || $row->status_antrian === 'dipanggil') {
					// Pasien sedang dilayani
					$grouped_data[$key]['pasiendilayani'] = [
						'nourut' => $row->no_antrian,
						'nomorantrian' => $row->no_antrian,
						'nama' => $row->nama ?: 'Nama Tidak Diketahui',
						'norm' => $row->no_medrec,
						'waktu_panggil' => $row->waktu_panggil
					];
				} elseif ($row->status_antrian === 'menunggu') {
					// Pasien menunggu antrian
					$grouped_data[$key]['pasien'][] = [
						'nourut' => $row->no_antrian,
						'nomorantrian' => $row->no_antrian,
						'nama' => $row->nama ?: 'Nama Tidak Diketahui',
						'norm' => $row->no_medrec
					];
				}

				$grouped_data[$key]['total_antrian']++;
			}

			// Set flag untuk pemanggilan terakhir
			if ($latest_call) {
				$latest_key = $latest_call->id_poli . '_' . $latest_call->id_dokter;
				if (isset($grouped_data[$latest_key])) {
					$grouped_data[$latest_key]['is_latest_call'] = true;
				}
			}

			// Convert ke array untuk response
			$response_data = array_values($grouped_data);

			echo json_encode($response_data);

		} catch (Exception $e) {
			echo json_encode([
				'metadata' => [
					'code' => 500,
					'message' => $e->getMessage()
				]
			]);
		}
	}

	public function dashboard_selector()
	{
		$data = [
			'title' => 'Pilih Dashboard Antrian Poliklinik'
		];

		$this->load->view('antrol/dashboard_selector', $data);
	}

	public function get_poliklinik_list()
	{
		header('Content-Type: application/json');
		try {
			// Load model untuk mengambil daftar poliklinik
			$this->load->model('irj/rjmpelayanan', '', TRUE);

			$query = "
				SELECT
					p.id_poli,
					p.nm_poli,
					COUNT(DISTINCT d.id_dokter) as total_dokter,
					COUNT(d.no_register) as total_pasien_hari_ini
				FROM poliklinik p
				LEFT JOIN daftar_ulang_irj d ON p.id_poli = d.id_poli
					AND DATE(d.tgl_kunjungan) = CURRENT_DATE
					AND d.ket_pulang IS NULL
				GROUP BY p.id_poli, p.nm_poli
				ORDER BY p.nm_poli ASC
			";

			$result = $this->rjmpelayanan->db->query($query);
			$data = $result->result();

			echo json_encode([
				'success' => true,
				'data' => $data
			]);

		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => $e->getMessage()
			]);
		}
	}

	public function get_antrian_farmasi()
	{
		header('Content-Type: application/json; charset=utf-8');
		try {
			$date = $this->input->get('date') ?: date('Y-m-d');
			$result = $this->mantrol->get_antrian_farmasi($date);
			$data = $result->result();

			echo json_encode([
				'success' => true,
				'data' => $data
			]);
		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
				'data' => []
			]);
		}
	}

	public function panggil_antrian_farmasi()
	{
		header('Content-Type: application/json; charset=utf-8');

		$no_register = $this->input->post('no_register');
		$no_antrian = $this->input->post('no_antrian');
		$nama_pasien = $this->input->post('nama_pasien');

		if (empty($no_register) || empty($no_antrian)) {
			echo json_encode([
				'success' => false,
				'message' => 'Parameter tidak lengkap'
			]);
			return;
		}

		try {
			$result = $this->mantrol->panggil_antrian_farmasi($no_register, $no_antrian);

			if ($result) {
				echo json_encode([
					'success' => true,
					'message' => 'Antrian ' . $no_antrian . ' (' . $nama_pasien . ') berhasil dipanggil'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Gagal memanggil antrian'
				]);
			}
		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			]);
		}
	}

	public function selesai_antrian_farmasi()
	{
		header('Content-Type: application/json; charset=utf-8');

		$no_register = $this->input->post('no_register');
		$no_antrian = $this->input->post('no_antrian');
		$nama_pasien = $this->input->post('nama_pasien');

		if (empty($no_register)) {
			echo json_encode([
				'success' => false,
				'message' => 'No register tidak boleh kosong'
			]);
			return;
		}

		try {
			$result = $this->mantrol->selesai_antrian_farmasi($no_register);

			if ($result) {
				echo json_encode([
					'success' => true,
					'message' => 'Antrian ' . $no_antrian . ' (' . $nama_pasien . ') telah selesai'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Gagal menyelesaikan antrian'
				]);
			}
		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			]);
		}
	}
}
