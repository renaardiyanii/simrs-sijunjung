<?php
defined('BASEPATH') or exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
// include('Rjcterbilang.php');

use GuzzleHttp\Client;
class Api extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('antrol/mantrol', '', TRUE);
		$this->clients = new Client([
			'verify' => false,
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		$this->load->library('vclaim');
        $this->load->model('Mbpjs','antrol/mbpjs',TRUE);
	}


	public function bpjs_sep($no_rujukan, $type = 0)
	{
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			header('Content-Type: application/json; charset=utf-8');
		$data = $this->mantrol->get_bpjs_sep($no_rujukan, $type)->result();
		echo json_encode($data);
	}
	public function cek_surat_kontrol_exist($no_sep_asal)
	{
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json; charset=utf-8');
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->mantrol->cek_bpjs_suratkontrol($no_sep_asal)->row();
		echo json_encode($data);
	}

	public function data_poli(){
		// CORS headers - urutan yang benar dan tanpa duplikasi
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization');
		header('Content-Type: application/json; charset=utf-8');
		
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
			exit();
		}
		
		$url = 'RencanaKontrol/ListSpesialistik/JnsKontrol/'.$this->input->get('jnskontrol').'/nomor/'.$this->input->get('nomor').'/TglRencanaKontrol/'.$this->input->get('tglrencanakontrol');
		echo $this->vclaim->get($url);
	}

	public function data_dokter(){
		header('Access-Control-Allow-Origin: *');

		header('Content-Type: application/json; charset=utf-8');
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Content-Type: application/json; charset=utf-8');
		$url = '/RencanaKontrol/JadwalPraktekDokter/JnsKontrol/'.$this->input->get('jnskontrol').
        '/KdPoli/'.$this->input->get('poli').'/TglRencanaKontrol/'.$this->input->get('tglrencanakontrol');
		echo $this->vclaim->get($url);
	}

	public function insert_surat_kontrol()
    {
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json; charset=utf-8');
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		
		$url = 'RencanaKontrol/insert';
		
		// Ambil data JSON dari request body
		$json_input = file_get_contents('php://input');
		$param = json_decode($json_input, true);
		
		// Fallback ke input->post() jika JSON kosong
		if (empty($param)) {
			$param = $this->input->post();
		}
        // echo $date;
        $param['user'] = 'ADMIN';

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
            "request": {
                "noSEP":"'.$param['sep'].'",
                "kodeDokter":"'.$param['dokter'].'",
                "poliKontrol":"'.explode('-',$param['poli'])[1].'",
                "tglRencanaKontrol":"'.date('Y-m-d',strtotime($param['tglrencanakontrol'])).'",
                "user":"'.$param['user'].'"
            }
        }'),true);

        $response = $this->vclaim->post($url,$data);
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-05","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010822K000001","tglRencanaKontrol":"2022-08-12","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        $result = json_decode($response);
        if($result->metaData->code == '200'){
            $sender = [
                'surat_kontrol'=>$result->response->noSuratKontrol,
                'no_sep_asal'=>$param['sep'],
                'poli'=>explode('-',$param['poli'])[1],
                'tgl_rencana_kontrol'=>date('Y-m-d',strtotime($param['tglrencanakontrol'])),
                'dokter_bpjs'=>$param['dokter'],
                'no_kartu'=>$result->response->noKartu,
                'nama_dokter_bpjs'=>$param['nama_dokter'],
            ];
            $this->mantrol->insert_bpjs_surat_kontrol($sender);
        }
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
			echo $this->vclaim->posticare('ihs_dev/api/rs/validate',$data,[],'https://apijkn-dev.bpjs-kesehatan.go.id/');
			return;

		}
		$data = 
		[
			'title'=>'ICare BPJS Kesehatan',
		];
		$this->load->view('antrol/icare',$data);
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
			/**
			 * Added Kebutuhan untuk icare jika dokter sendiri yang login buat icare
			 * maka cukup ambil data dirinya sendiri
			 */
			if($this->input->get('self') != 0){
				// var_dump()
				$userid = $this->session->userdata('userid');
				$kode_dpjp_bpjs = $this->mantrol->get_dokter_self($userid);
				// $data = $this->mantrol->get_dokter_self();
				echo json_encode([
					'metadata'=>[
						'code'=>1,
						'message'=>'Ok'
					],
					'response'=>[[
						'kodedokter'=>$kode_dpjp_bpjs->kode_dpjp_bpjs,
						'namadokter'=>$kode_dpjp_bpjs->nm_dokter
					]]]);
				return;	
			}
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

	function index()
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
		];
		$this->load->view('antrol/index',$data);
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
		// var_dump(json_encode($payloads));die();
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

	function selesaimanual($kodebooking,$proses,$timestamp){
		$this->endpoint = 'http://192.168.1.139:8000/';
		$response = $this->clients->get(
			$this->endpoint .'adminantrian/prosesantrianwaktu/'.$kodebooking.'/'.$proses.'/'.$timestamp,
			[
				'headers'=>['Content-Type'=>'application/json']
			]
		)->getBody()->getContents();
		echo $response;
		return;
	}

	function panggil()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = base64_decode($this->input->get('data'));
		// var_dump($data);
		$req = json_decode($data);

		$this->endpoint = 'http://192.168.1.139:8000/';
				$response = $this->clients->get(
					$this->endpoint .'adminantrian/prosesantrian/'.$req->kodebooking.'/1',
					[
						'headers'=>['Content-Type'=>'application/json']
					]
				)->getBody()->getContents();
				echo $response;
				return;
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


	function onsite_nonjknv2()
	{
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			header('Content-Type: application/json; charset=utf-8');
		// header('Content-Type: application/json; charset=utf-8');
		$req = $this->input->post();
		$datapasien = $this->mantrol->get_pasien_by_no_cm($req['no_cm']);
		if(!$datapasien)
		{
			echo json_encode([
				'metadata'=>[
					'code'=>400,
					'message'=>'Silahkan pilih menu pasien baru terlebih dahulu!'
				],
				'response'=>null
			]);
			return;
		}
		$req['nik'] = $datapasien->no_identitas==null || $datapasien->no_identitas == ''?'0000000000000000':$datapasien->no_identitas; // required 
		$req['norm'] = $req['no_cm']; // required
		$req['nohp'] = $datapasien->no_hp == '' || $datapasien->no_hp == null ?'0000000000':$datapasien->no_hp; // required
		$req['nomorkartu'] = '';
		$req['tanggalperiksa'] = date('Y-m-d');
		$req['kodedokter'] = explode('@',$req['kodedokter'])[0]==''?'450599':explode('@',$req['kodedokter'])[0];
		$req['jeniskunjungan'] = 1;
		$req['nomorreferensi'] = '';
		$req['jenispasien'] = 'NON JKN';
		unset($req['no_cm']);
		try {
			$response = $this->clients->post(
				$this->endpoint .'adminantrian/ambilantriannonjknlama',
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
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
				$req['jeniskunjungan'] = 1;
				$req['nomorreferensi'] = '';
				$req['jenispasien'] = 'NON JKN';
				if($req['nohp'] == ''){
					$req['nohp'] = '00000000000';
				}if(strlen($req['nohp'])>=12){
					$req['nohp'] = '00000000000';
				}
				// var_dump($req);
				// echo json_encode($req);
				try {
					$response = $this->clients->post(
						$this->endpoint .'adminantrian/ambilantriannonjknlama',
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
			// var_dump($req);die();
			if($req['nomorkartu'] == $req['nik']){
				// ganti nomorkartu dengan nomor kartu yang sesungguhnya dari db
				$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($req['nomorkartu']);
				$req['nomorkartu'] = $kartupasien->no_kartu;
			}
			$req['tanggalperiksa'] = date('Y-m-d');
			// $req['tanggalperiksa'] = '2025-02-11';
			$req['kodedokter'] = explode('@',$req['kodedokter'])[0];
			if($req['nohp'] == ''){
				$req['nohp'] = '00000000000';
			}if(strlen($req['nohp'])>=12){
				$req['nohp'] = '00000000000';
			}
			
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
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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

		if($this->input->get('ceknikpasienbaru') == '1'){
			header('Content-Type: application/json; charset=utf-8');
			$nomorkartu = trim($this->input->post('nik'));
			if($nomorkartu == '' ){
				echo json_encode([
					'metaData'=>[
						'code'=>400,
						'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
					]
				]);
				return;
			}
			$url = '/Peserta/nik/'.$nomorkartu.'/tglSEP/'.date('Y-m-d');
			$grabPasienBpjs = json_decode($this->vclaim->get($url));
			if($grabPasienBpjs->metaData->code != '200'){
				echo json_encode($grabPasienBpjs);
				return;
			}
			$datapasien = $grabPasienBpjs->response;
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
				'nokartu'=>$datapasien->peserta->noKartu,
				'nik'=>$datapasien->peserta->nik,
				'nohp'=>$datapasien->peserta->mr->noTelepon,
				'nokk'=>'',
				'nama'=>$datapasien->peserta->nama,
				'jeniskelamin'=>$datapasien->peserta->sex,
				'tgllahir'=>$datapasien->peserta->tglLahir,
				'alamat'=>'',
				'provinsi'=>'',
				'kabupatenkota'=>'',
				'kecamatan'=>'',
				'rt'=>'',
				'rw'=>'',
			];
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$pasien
			]);
			return;
		}

		if($this->input->get('ceknokartupasienbaru') == '1'){
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
			$url = '/Peserta/nokartu/'.$nomorkartu.'/tglSEP/'.date('Y-m-d');
			$grabPasienBpjs = json_decode($this->vclaim->get($url));
			if($grabPasienBpjs->metaData->code != '200'){
				echo json_encode($grabPasienBpjs);
				return;
			}
			$datapasien = $grabPasienBpjs->response;
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
				'nokartu'=>$datapasien->peserta->noKartu,
				'nik'=>$datapasien->peserta->nik,
				'nohp'=>$datapasien->peserta->mr->noTelepon,
				'nokk'=>'',
				'nama'=>$datapasien->peserta->nama,
				'jeniskelamin'=>$datapasien->peserta->sex,
				'tgllahir'=>$datapasien->peserta->tglLahir,
				'alamat'=>'',
				'provinsi'=>'',
				'kabupatenkota'=>'',
				'kecamatan'=>'',
				'rt'=>'',
				'rw'=>'',
			];
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$pasien
			]);
			return;
		}

		if($this->input->get('cekpasien') == '1')
		{
			header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				// pengecekan berdasarkan nomor nik.
				// jika nomorkartu ==16 menandakan nik
				// ambil no_kartu berdasarkan nik
				if(strlen($nomorkartu)==16){
					$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
					$nomorkartu = $kartupasien->no_kartu;
				}else{
					echo json_encode([
						'metaData'=>[
							'code'=>400,
							'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
						]
					]);
					return;
				}
				
			}
			$datapasien = $this->mantrol->get_data_pasien($nomorkartu);
			if(!$datapasien){
				$url = '/Peserta/nokartu/'.$nomorkartu.'/'.$this->input->get('nomor').'/tglSEP/'.date('Y-m-d');
				$grabPasienBpjs = json_decode($this->vclaim->get($url));
				// var_dump($grabPasienBpjs);die();
				if($grabPasienBpjs->metaData->code != '200'){
					echo json_encode([
						'metaData'=>[
							'code'=>201,
							'message'=>'Pasien tidak terdaftar'
						]
						]);
						return;
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
			// var_dump($datarujukan);die();
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
				}else{
					$pasien['jeniskunjungan'] = '';
					$pasien['nomorreferensi'] = '';
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
						$pasien['jeniskunjungan'] = 4;
						$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
					}else{
						$pasien['jeniskunjungan'] = '';
						$pasien['nomorreferensi'] = '';
					}
					
					// $pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
					// $pasien['tglperiksa']= date('Y-m-d');
					// $pasien['jeniskunjungan'] = 4;
					// $pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
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

		if($this->input->get('ceknokartu') == '1'){
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				if(strlen($nomorkartu)==16){
					$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
					$nomorkartu = $kartupasien->no_kartu;
				}else{
					echo json_encode([
						'metaData'=>[
							'code'=>400,
							'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
						]
					]);
					return;
				}
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
			// var_dump($datarujukan);die();
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
								$pasien['nomorreferensi'] = $suratkontrolnew->response->list[0]->noSuratKontrol;
								$pasien['jeniskunjungan'] = 3;
							}
						}else{
							$pasien['nomorreferensi'] = '';
							$pasien['jeniskunjungan'] = 3;
							
						}

						/**
						 * Deprecated
						 * Version 1.0.0
						 * ambil surat kontrol berdasarkan localhost
						 */
						// $ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($nomorkartu);
						// if($ambilnomorsuratkontrol !=null){
						// 	$pasien['nomorreferensi'] = $ambilnomorsuratkontrol->surat_kontrol;
						// 	$pasien['jeniskunjungan'] = 3;
						// }else{
						// 	$pasien['nomorreferensi'] = '';
						// 	$pasien['jeniskunjungan'] = 3;
						// }
						
						
					}else{
						// menandakan poli beda dengan poli rujukan maka nomor referensi = nomor rujukan
						$pasien['jeniskunjungan'] = 2;
						// $pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
						$pasien['nomorreferensi'] = "$poli"."0304R".date("dmY").sprintf("%03d", $this->mantrol->get_counter_internal());
					}
				}
				
			}else{
				$url = 'Rujukan/RS/Peserta/'.$nomorkartu;
				// var_dump($url);die();
				$datarujukanrs = json_decode($this->vclaim->get($url));
				// var_dump($datarujukanrs);die();
				if($datarujukanrs->metaData->code == '200'){
					$pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
					$pasien['tglperiksa']= date('Y-m-d');
					$pasien['jeniskunjungan'] = 4;
					$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
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

	function onsitedebug()
	{
		if($this->input->get('submitdebug') == '1'){
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
				$req['jeniskunjungan'] = 1;
				$req['nomorreferensi'] = '';
				$req['jenispasien'] = 'NON JKN';
				if($req['nohp'] == ''){
					$req['nohp'] = '00000000000';
				}if(strlen($req['nohp'])>=12){
					$req['nohp'] = '00000000000';
				}
				// var_dump($req);
				// echo json_encode($req);
				try {
					$response = $this->clients->post(
						$this->endpoint .'adminantrian/ambilantriannonjknlama',
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
			// var_dump($req);die();
			if($req['nomorkartu'] == $req['nik']){
				// ganti nomorkartu dengan nomor kartu yang sesungguhnya dari db
				$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($req['nomorkartu']);
				$req['nomorkartu'] = $kartupasien->no_kartu;
			}
			$req['tanggalperiksa'] = date('Y-m-d');

			//TODO: GANTI KALO UDAH PROD
			// $req['tanggalperiksa'] = '2025-07-30';
			$req['kodedokter'] = explode('@',$req['kodedokter'])[0];
			if($req['nohp'] == ''){
				$req['nohp'] = '00000000000';
			}if(strlen($req['nohp'])>=12){
				$req['nohp'] = '00000000000';
			}

			// var_dump($req);die();
			
			try {
				$response = $this->clients->post(
					$this->endpoint .'adminantrian/ambilantrianlamadebugprod',
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

		if($this->input->get('submit') == '1'){
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
				$req['jeniskunjungan'] = 1;
				$req['nomorreferensi'] = '';
				$req['jenispasien'] = 'NON JKN';
				if($req['nohp'] == ''){
					$req['nohp'] = '00000000000';
				}if(strlen($req['nohp'])>=12){
					$req['nohp'] = '00000000000';
				}
				// var_dump($req);
				// echo json_encode($req);
				try {
					$response = $this->clients->post(
						$this->endpoint .'adminantrian/ambilantriannonjknlama',
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
			// var_dump($req);die();
			if($req['nomorkartu'] == $req['nik']){
				// ganti nomorkartu dengan nomor kartu yang sesungguhnya dari db
				$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($req['nomorkartu']);
				$req['nomorkartu'] = $kartupasien->no_kartu;
			}
			$req['tanggalperiksa'] = date('Y-m-d');

			//TODO: GANTI KALO UDAH PROD
			// $req['tanggalperiksa'] = '2025-07-30';
			$req['kodedokter'] = explode('@',$req['kodedokter'])[0];
			if($req['nohp'] == ''){
				$req['nohp'] = '00000000000';
			}if(strlen($req['nohp'])>=12){
				$req['nohp'] = '00000000000';
			}
			
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
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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

		if($this->input->get('ceknikpasienbaru') == '1'){
			header('Content-Type: application/json; charset=utf-8');
			$nomorkartu = trim($this->input->post('nik'));
			if($nomorkartu == '' ){
				echo json_encode([
					'metaData'=>[
						'code'=>400,
						'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
					]
				]);
				return;
			}
			$url = '/Peserta/nik/'.$nomorkartu.'/tglSEP/'.date('Y-m-d');
			$grabPasienBpjs = json_decode($this->vclaim->get($url));
			if($grabPasienBpjs->metaData->code != '200'){
				echo json_encode($grabPasienBpjs);
				return;
			}
			$datapasien = $grabPasienBpjs->response;
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
				'nokartu'=>$datapasien->peserta->noKartu,
				'nik'=>$datapasien->peserta->nik,
				'nohp'=>$datapasien->peserta->mr->noTelepon,
				'nokk'=>'',
				'nama'=>$datapasien->peserta->nama,
				'jeniskelamin'=>$datapasien->peserta->sex,
				'tgllahir'=>$datapasien->peserta->tglLahir,
				'alamat'=>'',
				'provinsi'=>'',
				'kabupatenkota'=>'',
				'kecamatan'=>'',
				'rt'=>'',
				'rw'=>'',
			];
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$pasien
			]);
			return;
		}

		if($this->input->get('ceknokartupasienbaru') == '1'){
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
			$url = '/Peserta/nokartu/'.$nomorkartu.'/tglSEP/'.date('Y-m-d');
			$grabPasienBpjs = json_decode($this->vclaim->get($url));
			if($grabPasienBpjs->metaData->code != '200'){
				echo json_encode($grabPasienBpjs);
				return;
			}
			$datapasien = $grabPasienBpjs->response;
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
				'nokartu'=>$datapasien->peserta->noKartu,
				'nik'=>$datapasien->peserta->nik,
				'nohp'=>$datapasien->peserta->mr->noTelepon,
				'nokk'=>'',
				'nama'=>$datapasien->peserta->nama,
				'jeniskelamin'=>$datapasien->peserta->sex,
				'tgllahir'=>$datapasien->peserta->tglLahir,
				'alamat'=>'',
				'provinsi'=>'',
				'kabupatenkota'=>'',
				'kecamatan'=>'',
				'rt'=>'',
				'rw'=>'',
			];
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$pasien
			]);
			return;
		}

		if($this->input->get('cekpasien') == '1')
		{
			header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				// pengecekan berdasarkan nomor nik.
				// jika nomorkartu ==16 menandakan nik
				// ambil no_kartu berdasarkan nik
				if(strlen($nomorkartu)==16){
					$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
					$nomorkartu = $kartupasien->no_kartu;
				}else{
					echo json_encode([
						'metaData'=>[
							'code'=>400,
							'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
						]
					]);
					return;
				}
				
			}
			$datapasien = $this->mantrol->get_data_pasien($nomorkartu);
			if(!$datapasien){
				$url = '/Peserta/nokartu/'.$nomorkartu.'/'.$this->input->get('nomor').'/tglSEP/'.date('Y-m-d');
				$grabPasienBpjs = json_decode($this->vclaim->get($url));
				// var_dump($grabPasienBpjs);die();
				if($grabPasienBpjs->metaData->code != '200'){
					echo json_encode([
						'metaData'=>[
							'code'=>201,
							'message'=>'Pasien tidak terdaftar'
						]
						]);
						return;
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
			// var_dump($datarujukan);die();
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
				}else{
					$pasien['jeniskunjungan'] = '';
					$pasien['nomorreferensi'] = '';
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
						$pasien['jeniskunjungan'] = 4;
						$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
					}else{
						$pasien['jeniskunjungan'] = '';
						$pasien['nomorreferensi'] = '';
					}
					
					// $pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
					// $pasien['tglperiksa']= date('Y-m-d');
					// $pasien['jeniskunjungan'] = 4;
					// $pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
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

		if($this->input->get('ceknokartu') == '1'){
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				if(strlen($nomorkartu)==16){
					$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
					$nomorkartu = $kartupasien->no_kartu;
				}else{
					echo json_encode([
						'metaData'=>[
							'code'=>400,
							'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
						]
					]);
					return;
				}
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
			// var_dump($datarujukan);die();
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
								$pasien['nomorreferensi'] = $suratkontrolnew->response->list[0]->noSuratKontrol;
								$pasien['jeniskunjungan'] = 3;
							}
						}else{
							$pasien['nomorreferensi'] = '';
							$pasien['jeniskunjungan'] = 3;
							
						}

						/**
						 * Deprecated
						 * Version 1.0.0
						 * ambil surat kontrol berdasarkan localhost
						 */
						// $ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($nomorkartu);
						// if($ambilnomorsuratkontrol !=null){
						// 	$pasien['nomorreferensi'] = $ambilnomorsuratkontrol->surat_kontrol;
						// 	$pasien['jeniskunjungan'] = 3;
						// }else{
						// 	$pasien['nomorreferensi'] = '';
						// 	$pasien['jeniskunjungan'] = 3;
						// }
						
						
					}else{
						// menandakan poli beda dengan poli rujukan maka nomor referensi = nomor rujukan
						$pasien['jeniskunjungan'] = 2;
						// $pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
						$pasien['nomorreferensi'] = "$poli"."0304R".date("dmY").sprintf("%03d", $this->mantrol->get_counter_internal());
					}
				}
				
			}else{
				$url = 'Rujukan/RS/Peserta/'.$nomorkartu;
				// var_dump($url);die();
				$datarujukanrs = json_decode($this->vclaim->get($url));
				// var_dump($datarujukanrs);die();
				if($datarujukanrs->metaData->code == '200'){
					$pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
					$pasien['tglperiksa']= date('Y-m-d');
					$pasien['jeniskunjungan'] = 4;
					$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
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

		if($this->input->get('ceknokarturujukan') == '1'){
            header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			$nomorkartu = trim($this->input->post('nomorkartu'));
			$rawpoli = explode("#", trim($this->input->post('kodepoli'))); // Ambil kodepoli dari POST
			$kodepoli_post = $rawpoli[1];
			$id_poli = $rawpoli[0];
			// var_dump($rawpoli);die();
			$rujukan = json_decode(trim($this->input->post('rujukan')));
			// var_dump($rujukan);die();
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				if(strlen($nomorkartu)==16){
					$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
					$nomorkartu = $kartupasien->no_kartu;
				}else{
					echo json_encode([
						'metaData'=>[
							'code'=>400,
							'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
						]
					]);
					return;
				}
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
			if (!empty($rujukan) && isset($rujukan->noKunjungan)) {
				// Data rujukan sudah ada dari parameter, langsung gunakan.
				$pasien['kodepoli']    = $rujukan->poliRujukan;
				$pasien['tglperiksa']  = date('Y-m-d');
				
				// Cek jumlah SEP berdasarkan nomor kartu & no rujukan yang sudah ada.
				$url = 'Rujukan/JumlahSEP/1/' . $rujukan->noKunjungan;
				$datajumlahsep = json_decode($this->vclaim->get($url));
				$jumlahsep = '0';
				if ($datajumlahsep->metaData->code == '200') {
					$jumlahsep = $datajumlahsep->response->jumlahSEP;
				}

				if ($jumlahsep == '0') {
					// Ini adalah kunjungan pertama menggunakan rujukan ini.
					$pasien['jeniskunjungan'] = 1; // 1 = Rujukan FKTP
					$pasien['nomorreferensi'] = $rujukan->noKunjungan;
				} else { // $jumlahsep >= 1
					// Pasien sudah pernah membuat SEP dengan rujukan ini, berarti ini adalah kontrol.
					// Cek apakah poli tujuan sama dengan poli rujukan.
					if ($kodepoli_post == $rujukan->poliRujukan->kode) {
						// Poli sama, ini adalah KONTROL. Cari surat kontrol.
						$pasien['jeniskunjungan'] = 3; // 3 = Surat Kontrol
						
						$yearnow = date("Y");
						$monthnow = date("m");
						$url = "/RencanaKontrol/ListRencanaKontrol/Bulan/$monthnow/Tahun/$yearnow/Nokartu/$nomorkartu/filter/2";
						$suratkontrolnew = json_decode($this->vclaim->get($url));
						
						if ($suratkontrolnew->metaData->code == '200' && count($suratkontrolnew->response->list) > 0) {
							// Ambil surat kontrol yang paling baru (biasanya yang pertama)
							$pasien['nomorreferensi'] = $suratkontrolnew->response->list[0]->noSuratKontrol;
						} else {
							// Tidak ditemukan surat kontrol aktif, berikan pesan error ke frontend.
							// Atau biarkan kosong agar divalidasi oleh BPJS saat pembuatan antrean.
							$pasien['nomorreferensi'] = ''; 
						}
					} else {
						// Poli berbeda, ini adalah RUJUKAN INTERNAL.
						// Logika ini mungkin perlu penyesuaian tergantung alur bisnis RS Anda.
						$pasien['jeniskunjungan'] = 2; // 2 = Rujukan Internal
						$pasien['nomorreferensi'] = "$kodepoli_post" . "0304R" . date("dmY") . sprintf("%03d", $this->mantrol->get_counter_internal());
					}
				}
			} else {
				// Jika tidak ada data rujukan yang dikirim, mungkin ini adalah alur non-rujukan
				// atau fallback jika diperlukan. Untuk saat ini kita set kosong.
				$pasien['kodepoli']         = '';
				$pasien['tglperiksa']       = date('Y-m-d');
				$pasien['jeniskunjungan']   = '';
				$pasien['nomorreferensi']   = '';
				// Beri pesan bahwa rujukan tidak ditemukan jika alur ini seharusnya tidak terjadi.
				// echo json_encode(['metaData' => ['code' => 404, 'message' => 'Data rujukan tidak dipilih atau tidak valid.']]);
				// return;
			}
			$pasien['id_poli'] = $id_poli;
		
			echo json_encode([
				'metaData' => [
					'code'    => 200,
					'message' => 'Ok'
				],
				'response' => $pasien
			]);
			return;
			// $url = '/Rujukan/Peserta/'.$nomorkartu;
			// $datarujukan = json_decode($this->vclaim->get($url));
			// // var_dump($datarujukan);die();
			// if($datarujukan->metaData->code == '200'){
			// 	// * 	'kodepoli:'',
			// 	// * 	'tglperiksa:'',
			// 	// * 	'jeniskunjungan:'',
			// 	// * 	'nomorreferensi:'',
			// 	$pasien['kodepoli'] = $datarujukan->response->rujukan->poliRujukan;
			// 	$pasien['tglperiksa']= date('Y-m-d');
			// 	// disini cek berapa jumlah sep berdasarkan nomor kartu.
			// 	$url = 'Rujukan/JumlahSEP/1/'.$datarujukan->response->rujukan->noKunjungan;
			// 	$datajumlahsep = json_decode($this->vclaim->get($url));
			// 	$jumlahsep = '0';
			// 	if($datajumlahsep->metaData->code == '200'){
			// 		$jumlahsep = $datajumlahsep->response->jumlahSEP;
			// 	}
			// 	if($jumlahsep == '0'){
			// 		$pasien['jeniskunjungan'] = 1;
			// 		$pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
			// 	}else if($jumlahsep >= 1){
			// 		// ambil poli
			// 		$poli = $this->input->post('kodepoli');
			// 		if($poli == $datarujukan->response->rujukan->poliRujukan->kode){
			// 			// menandakan poli sama dengan poli rujukan maka nomor referensi = nomor surat kontrol
			// 			// ambil nomor surat kontrol berdasarkan nomor rujukan dimana nomor sep is null atau ''(belum cetak sep)
						
						
			// 			/**
			// 			 * Overhaul in version 1.1.0
			// 			 * ambil surat kontrol langsung dari BPJS 7 hari dari hari ini.
			// 			 */
			// 			$yearnow = date("Y");
			// 			$monthnow = date("m");
			// 			$url = "/RencanaKontrol/ListRencanaKontrol/Bulan/$monthnow/Tahun/$yearnow/Nokartu/$nomorkartu/filter/2";
			// 			$suratkontrolnew = json_decode($this->vclaim->get($url));
			// 			// var_dump($suratkontrolnew);die();
			// 			if($suratkontrolnew->metaData->code == '200'){
			// 				// check jika surat kontrol ada  
			// 				// ambil yang pertama [0]
			// 				if(count($suratkontrolnew->response->list)>0){
			// 					$pasien['nomorreferensi'] = $suratkontrolnew->response->list[0]->noSuratKontrol;
			// 					$pasien['jeniskunjungan'] = 3;
			// 				}
			// 			}else{
			// 				$pasien['nomorreferensi'] = '';
			// 				$pasien['jeniskunjungan'] = 3;
							
			// 			}

			// 			/**
			// 			 * Deprecated
			// 			 * Version 1.0.0
			// 			 * ambil surat kontrol berdasarkan localhost
			// 			 */
			// 			// $ambilnomorsuratkontrol = $this->mantrol->get_suratkontrol($nomorkartu);
			// 			// if($ambilnomorsuratkontrol !=null){
			// 			// 	$pasien['nomorreferensi'] = $ambilnomorsuratkontrol->surat_kontrol;
			// 			// 	$pasien['jeniskunjungan'] = 3;
			// 			// }else{
			// 			// 	$pasien['nomorreferensi'] = '';
			// 			// 	$pasien['jeniskunjungan'] = 3;
			// 			// }
						
						
			// 		}else{
			// 			// menandakan poli beda dengan poli rujukan maka nomor referensi = nomor rujukan
			// 			$pasien['jeniskunjungan'] = 2;
			// 			// $pasien['nomorreferensi'] = $datarujukan->response->rujukan->noKunjungan;
			// 			$pasien['nomorreferensi'] = "$poli"."0304R".date("dmY").sprintf("%03d", $this->mantrol->get_counter_internal());
			// 		}
			// 	}
				
			// }else{
			// 	$url = 'Rujukan/RS/Peserta/'.$nomorkartu;
			// 	// var_dump($url);die();
			// 	$datarujukanrs = json_decode($this->vclaim->get($url));
			// 	// var_dump($datarujukanrs);die();
			// 	if($datarujukanrs->metaData->code == '200'){
			// 		$pasien['kodepoli'] = $datarujukanrs->response->rujukan->poliRujukan;
			// 		$pasien['tglperiksa']= date('Y-m-d');
			// 		$pasien['jeniskunjungan'] = 4;
			// 		$pasien['nomorreferensi'] = $datarujukanrs->response->rujukan->noKunjungan;
			// 	}else{
			// 		$pasien['kodepoli'] ='';
			// 		$pasien['tglperiksa']= date('Y-m-d');
			// 		$pasien['jeniskunjungan'] = '';
			// 		$pasien['nomorreferensi'] = '';
			// 	}
			// }
			// echo json_encode([
			// 	'metaData'=>[
			// 		'code'=>200,
			// 		'message'=>'Ok'
			// 	],
			// 	'response'=>$pasien
			// ]);
			// return;
		}

		/**
		 * Feat: Fetch List Rujukan berdasarkan Nomor Kartu
		 */
		if($this->input->get('getrujukan')== '1'){
			header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
			header('Content-Type: application/json; charset=utf-8');
			$nomorkartu = trim($this->input->get('val'));
			if($nomorkartu == '' || strlen($nomorkartu)!= 13){
				echo json_encode([
					'metaData'=>[
						'code'=>400,
						'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
					]
				]);
				return;
			}
			$url = 'Rujukan/List/Peserta/'.$nomorkartu;
			$datarujukan = json_decode($this->vclaim->get($url));
			if($datarujukan->metaData->code != '200'){
				echo json_encode([
					'metaData'=>[
						'code'=>201,
						'message'=>'Pasien tidak terdaftar'
					]
					]);
					return;
			}
			echo json_encode([
				'metaData'=>[
					'code'=>200,
					'message'=>'Ok'
				],
				'response'=>$datarujukan->response
			]);
			return;
		}

		$this->load->view('antrol/onsite');
	}

	function kiosk()
	{
		return $this->load->view('antrol/kiosk');
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

	public function dashboard_antrian_poli($kodepoli=''){
		$data['kodepoli'] = $kodepoli;
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
		// $arr = [
		// 	[
		// 		'dokter'=>'Dokter Brownsig',
		// 		'pasiendilayani'=>[
		// 			'nourut'=>1,
		// 			'nomorantrian'=>1,
		// 			'nama'=>'Pasien Dilayani 1',
		// 			'norm'=>'00000223'
		// 		],
		// 		'pasien'=>[
		// 			[
		// 				'nourut'=>1,
		// 				'kodebooking'=>'SAR001',
		// 				'nomorantrian'=>'SAR001',
		// 				'nama'=>'Test Pasien 1',
		// 				'norm'=>'00000001'
		// 			],
		// 			[
		// 				'nourut'=>2,
		// 				'kodebooking'=>'SAR002',
		// 				'nomorantrian'=>'SAR002',
		// 				'nama'=>'Test Pasien 2',
		// 				'norm'=>'00000002'
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'dokter'=>'Dokter Test 2',
		// 		'pasiendilayani'=>[
		// 			'nourut'=>1,
		// 			'nomorantrian'=>1,
		// 			'nama'=>'Pasien Dilayani 3',
		// 			'norm'=>'000002234'
		// 		],
		// 		'pasien'=>[
		// 			[
		// 				'nourut'=>1,
		// 				'kodebooking'=>'SAR001',
		// 				'nomorantrian'=>'SAR001',
		// 				'nama'=>'Test Pasien 1',
		// 				'norm'=>'00000001'
		// 			],
		// 			[
		// 				'nourut'=>2,
		// 				'kodebooking'=>'SAR002',
		// 				'nomorantrian'=>'SAR002',
		// 				'nama'=>'Test Pasien 2',
		// 				'norm'=>'00000002'
		// 			]
		// 		]
		// 	],

		// ];
		// echo json_encode( $arr );
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

	public function pasien($nk)
	{
		header('Content-Type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		$nomorkartu = trim($nk);
		if($nomorkartu == '' || strlen($nomorkartu)!= 13){
			if(strlen($nomorkartu)==16){
				$kartupasien = $this->mantrol->get_data_pasien_berdasarkan_nik($nomorkartu);
				$nomorkartu = $kartupasien->no_kartu;
			}
			else{
				echo json_encode([
					'metaData'=>[
						'code'=>400,
						'message'=>'Pastikan Masukan Nomor Kartu Dengan Benar!'
					]
				]);
			}
			return;
		}
		$url = '/Peserta/nokartu/'.$nomorkartu.'/tglSEP/'.date('Y-m-d');
		$grabPasienBpjs = $this->vclaim->get($url);

		echo $grabPasienBpjs;
		
	}

	public function pasienbaru_new()
	{
		header('Content-Type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		$posting = $this->input->post();

		$response = $this->clients->post(
			$this->endpoint .'adminantrian/pasienbarunew',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$posting
			]
		)->getBody()->getContents();
		echo $response;
	}

	
	public function checkinantrian()
	{
		header('Content-Type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		$posting = $this->input->post();

		$response = $this->clients->post(
			$this->endpoint .'adminantrian/checkinantrian',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$posting
			]
		)->getBody()->getContents();
		echo $response;
	}

	public function checkinantrianfarmasi($kode)
    {
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
        header('Content-Type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        if(strlen($kode) == 20){
            // kode booking
            echo json_encode($this->Frmmdaftar->get_daftar_resep_pasien_by('noreservasi',$kode)->row());
        }else{
            // no rm
            echo json_encode($this->Frmmdaftar->get_daftar_resep_pasien_by('norm',$kode)->row());

        }

    }

	public function pasienbaru_newnonjkn()
	{
		header('Content-Type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$this->endpoint = 'http://192.168.1.139:8000/';
		$posting = $this->input->post();

		$response = $this->clients->post(
			$this->endpoint .'adminantrian/pasienbarunewnonjkn',
			[
				'headers'=>['Content-Type'=>'application/json'],
				'json'=>$posting
			]
		)->getBody()->getContents();
		echo $response;
	}
}
