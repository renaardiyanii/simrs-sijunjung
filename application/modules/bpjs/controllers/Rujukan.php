<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rujukan extends Secure_area
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('vclaim');
		$this->load->model('Mbpjs', 'mbpjs', TRUE);
	}

	/**
	 * Rujukan Berdasarkan Nomor Rujukan & Kartu
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rujukan
	 * =========================================================================================
	 *
	 * - type => RS / null ( default PCARE )
	 * - nomor => nomor rujukan / kartu ( Wajib pencarian => kartu )
	 * - pencarian => Cari Berdasarkan No. Rujukan (rujukan) / Cari Berdasarkan No. Kartu (kartu)
	 * - multi => default : false, cari berdasarkan no. kartu ( wajib pencarian => kartu ) multi row
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rujukan/cari_rujukan?pencarian=kartu&nomor=12312321&multi=1&type=RS
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function cari_rujukan()
	{
		header('Content-Type: application/json; charset=utf-8');
		switch ($this->input->get('pencarian')) {
			case 'rujukan':
				$url = '/Rujukan/' . ($this->input->get('type') ? $this->input->get('type') . '/' : '') . $this->input->get('nomor');
				break;
			case 'kartu':
				$url = '/Rujukan/' . ($this->input->get('type') ? $this->input->get('type') . '/' : '') . ($this->input->get('multi') ? 'List' . '/' : '') . 'Peserta/' . $this->input->get('nomor');
				break;
			default:
				$url = '';
				break;
		}
		echo $this->vclaim->get($url);
	}

	/**
	 * Pembuatan Rujukan
	 * Disini tempat service Pembuatan Rujukan
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rujukan
	 * =========================================================================================
	 */



	/**
		* Example Pemanggilan :
		*
		* - <ipaddress>/bpjs/rujukan/insert?type=rujukankhusus
		* - <ipaddress>/bpjs/rujukan/insert
		*
		* ====DOC======
		* Insert :=>
		* - type : Rujukan Khusus (type=rujukankhusus)
		* 		Fungsi : Insert Rujukan Khusus
		* 		Method : POST
		* 		body   :
		* {
		   "norujukan":"NORUJUKAN",
		   "diagnosa":[
			   {"kode":"P;N18"},
			   {"kode":"S;N18.1"},
		   ],
		   "procedure":[
			   {"kode":"39.95"}
		   ]
		   }
		*
		* ===========================================
		* Rujukan 2.0
		* - type : Rujukan 2.0 (type=null)
		* 		Fungsi : Insert Rujukan 2.0
		* 		Method : POST
		* 		Body   :
		* {
		   "nosep":"NOSEP",
		   "tglrujukan":"2022-08-19",
		   "tglrencanakunjungan":"2022-08-20",
		   "ppkdirujuk":"0311R001",
		   "jnspelayanan":"2",
		   "catatan":"Testing",
		   "diagrujukan":"N19",
		   "tiperujukan":"1",
		   "polirujukan":"SAR"
		  }
		*/
	public function insert()
	{
		header('Content-Type: application/json; charset=utf-8');
		/**
		 * Cek Jika type != rujukan =====> rujukan khusus
		 */
		$param = $this->input->post();
		if ($this->input->get('type') == 'rujukankhusus') {
			$url = 'Rujukan/Khusus/insert';
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
				"noRujukan": "' . $param['norujukan'] . '",
				"diagnosa": ' . $param['diagnosa'] . ',
				"procedure":  ' . $param['procedure'] . ',
				"user": "' . $this->load->get_var('user_info')->name . '"
		   }'), true);
			$response = $this->vclaim->post($url, $data);
			echo $response;
			return;
		}
		$url = 'Rujukan/2.0/insert';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request": {
				"t_rujukan": {
						"noSep": "' . $param['noSep'] . '",
						"tglRujukan": "' . date('Y-m-d') . '",
						"tglRencanaKunjungan":"' . $param['tglRencanaKunjungan'] . '",
						"ppkDirujuk": "' . $param['ppkDirujuk'] . '",
						"jnsPelayanan": "' . $param['jnsPelayanan'] . '",
						"catatan": "' . $param['catatan'] . '",
						"diagRujukan": "' . $param['diagRujukan'] . '",
						"tipeRujukan": "' . ($param['tipeRujukan'] ?? '') . '",
						"poliRujukan": "' . ($param['poliRujukan'] ?? "") . '",
						"user": "' . $this->load->get_var('user_info')->name . '"
				}
			}
	   }'), true);
		$response = $this->vclaim->post($url, $data);
		echo $response;
	}

	/**
		* Update Rujukan 2.0
		* Fungsi : Update Rujukan 2.0
		* method : POST
		* Body   :
		* {
		   "noRujukan":"noRujukan",
		   "tglRujukan":"2022-08-19", "{tanggal rujukan, format : yyyy-MM-dd}",
		   "tglRencanaKunjungan":"2022-08-20", "{tanggal rencana kunjungan, format : yyyy-MM-dd}",
		   "ppkDirujuk":"0311R001", "{kode faskes, 8 digit}",
		   "jnsPelayanan":"2",  "{1-> rawat inap, 2-> rawat jalan}",
		   "catatan":"Testing",
		   "diagRujukan":"N19",
		   "tipeRujukan":"1","{0->Penuh, 1->Partial, 2->balik PRB}",
		   "poliRujukan":"SAR" "{kosong untuk tipe rujukan 2, harus diisi jika 0 atau 1}",
		  }
		*/
	public function update()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = 'Rujukan/2.0/Update';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request": {
				   "t_rujukan": {
						"noRujukan": "' . $param['noRujukan'] . '",
						"tglRujukan": "' . $param['tglRujukan'] . '",
						"tglRencanaKunjungan":"' . $param['tglRencanaKunjungan'] . '",
						"ppkDirujuk": "' . $param['ppkDirujuk'] . '",
						"jnsPelayanan": "' . $param['jnsPelayanan'] . '",
						"catatan": "' . $param['catatan'] . '",
						"diagRujukan": "' . $param['diagRujukan'] . '",
						"tipeRujukan": "' . $param['tipeRujukan'] . '",
						"poliRujukan": "' . $param['poliRujukan'] . '",
						"user": "' . $param['user'] . '"
				   }
			}
	   }'), true);
		$response = $this->vclaim->put($url, $data);
		echo $response;
	}

	/**
		* Delete Rujukan
		* ===============
		* Param : none
		* Fungsi : Update Rujukan
		* method : POST
		* Body   :
		* {
		   "noRujukan":"noRujukan"
		  }

	   ================================
		* Delete Rujukan Khusus
		* Param : ?type=rujukankhusus
		* Fungsi : Delete Rujukan Khusus
		* method : POST
		* body :
		* {
		* 	"idRujukan":"12313",
		* 	"noRujukan":"123123123"
		* }
		**/

	public function delete()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		if ($this->input->get('type') == 'rujukankhusus') {
			$url = 'Rujukan/Khusus/delete';
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
				"request": {
					"t_rujukan": {
						"idRujukan": "' . $param['idRujukan'] . '",
						"noRujukan": "' . $param['noRujukan'] . '",
						"user": "' . $this->load->get_var('user_info')->name . '"
					}
				}
			 }'), true);
			$response = $this->vclaim->post($url, $data);
			echo $response;
			return;
		}
		$url = 'Rujukan/delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request": {
				"t_rujukan": {
					"noRujukan": "' . $param['noRujukan'] . '",
					"user": "' . $this->load->get_var('user_info')->name . '"
				}
			}
		} '), true);
		$response = $this->vclaim->delete($url, $data);
		echo $response;
	}

	public function delete_get($norujukan)
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request": {
				"t_rujukan": {
					"noRujukan": "' . $norujukan . '",
					"user": "' . $this->load->get_var('user_info')->name . '"
				}
			}
		} '), true);
		$response = $this->vclaim->delete($url, $data);
		echo $response;
	}

	/**
	 * Data Rujukan Khusus
	 * Param :
	 * - bulan => 1 - 12
	 * - tahun => 4 digit ( 2022- 2023 dst... )
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/list_rujukan_khusus?bulan=1&tahun=2022
	 **/

	public function list_rujukan_khusus()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/Khusus/List/Bulan/' . $this->input->get('bulan') . '/Tahun/' . $this->input->get('tahun');
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : Data Spesialistik
	 * Param :
	 * - ppkrujukan => 8 digit
	 * - tglrujukan => yyyy-MM-dd
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/list_spesialistik_rujukan?ppkrujukan=0311R001&tglrujukan=2022-08-19
	 **/

	public function list_spesialistik_rujukan()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/ListSpesialistik/PPKRujukan/' . $this->input->get('ppkrujukan') . '/TglRujukan/' . $this->input->get('tglrujukan');
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : Data Sarana030120310230123
	 * Param :
	 * - ppkrujukan => 8 digit
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/list_sarana?ppkrujukan=0311R001
	 **/

	public function list_sarana()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/ListSarana/PPKRujukan/' . $this->input->get('ppkrujukan');
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : Data List Rujukan Keluar RS
	 * Param :
	 * - tglmulai => YYYY-mm-dd
	 * - tglakhir => YYYY-mm-dd
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/list_rujukan_keluar_rs?tglmulai=2022-08-01&tglakhir=2022-08-10
	 **/

	public function list_rujukan_keluar_rs()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/Keluar/List/tglMulai/' . $this->input->get('tglmulai') . '/tglAkhir/' . $this->input->get('tglakhir');
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : Get Data Detail Rujukan Keluar RS Berdasarkan Nomor Rujukan
	 * Param :
	 * - norujukan => 030120310230123
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/data_rujukan_keluar_rs?norujukan=030120310230123
	 **/

	public function data_rujukan_keluar_rs()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/Keluar/' . $this->input->get('norujukan');
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : Get Data Jumlah SEP yang terbentuk berdasarkan No Rujukan yang masuk ke RS
	 * Param :
	 * - jnsrujukan => 1 => fktp, 2=> fkrtl
	 * - norujukan => 030120310230123
	 *
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/data_jumlah_sep?jnsrujukan=1&norujukan=030120310230123
	 **/

	public function data_jumlah_sep()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/JumlahSEP/' . $this->input->get('jnsrujukan') . '/' . $this->input->get('norujukan');
		echo $this->vclaim->get($url);
	}

	/**
	 * Menu Rujukan
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rujukan
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/index
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function index()
	{
		$this->load->view('rujukan', ['title' => 'Rujukan', 'user' => $this->load->get_var("user_info")->username]);
	}

	public function ppa_rujukan_nama()
	{
		if (isset($_GET['q'])) {
			$url = 'referensi/faskes/' . $this->input->get('q') . '/' . $this->input->get('kodefaskes');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);
			if ($result->metaData->code != '200') {
				// echo json_encode([]);                   
			} else {

				foreach ($result->response->faskes as $row) {
					$new_row['id'] = $row->kode . '@' . $row->nama;
					$new_row['text'] = $row->nama;
					$row_set[] = $new_row;
				}
				echo json_encode($row_set);
			}
		} else
			echo json_encode([]);
	}


	public function ppa_rujukan()
	{
		if (isset($_GET['q'])) {
			$url = 'referensi/faskes/' . $this->input->get('q') . '/' . $this->input->get('kodefaskes');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);
			if ($result->metaData->code != '200') {
				echo json_encode([]);
			} else {

				foreach ($result->response->faskes as $row) {
					$new_row['id'] = $row->kode;
					$new_row['text'] = $row->nama;
					$row_set[] = $new_row;
				}
				echo json_encode($row_set);
			}
		} else
			echo json_encode([]);
	}


	/**
	 * Fungsi : Get Data Detail Rujukan Keluar RS Berdasarkan Nomor Rujukan
	 * 
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/data_rujukan/030120310230123
	 **/
	public function data_rujukan($norujukan = '')
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/Keluar/' . $norujukan;
		echo $this->vclaim->get($url);
	}

	/**
	 * Fungsi : List Data Rujukan Keluar RS
	 * 
	 * Contoh Pemanggilan :
	 * <ipaddress>/bpjs/rujukan/list_rujukan?tglMulai=<YYYY-MM-dd>&tglAkhir=<YYYY-MM-dd>
	 **/
	public function list_rujukan()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'Rujukan/Keluar/List/tglMulai/' . $this->input->get('tglMulai') . '/tglAkhir/' . $this->input->get('tglAkhir');
		echo $this->vclaim->get($url);
	}

	public function cetak_rujukan($norujukan)
	{
		$url = 'Rujukan/Keluar/' . $norujukan;
		$data['rujukan'] = json_decode($this->vclaim->get($url));
		if ($data['rujukan']->metaData->code == '200') {
			$this->load->view('cetak_rujukan', $data);
			return;
		}
		echo $data['rujukan']->metaData->message;
	}

	public function no_kartu_all_list($nokartu)
	{
		header('Content-Type: application/json; charset=utf-8');

		$param = trim(urldecode($nokartu));
		$type1 = [];
		$type2 = [];
		$type3 = [];
		// try{
		$faskes1 = json_decode($this->vclaim->get('Rujukan/List/Peserta/' . $param));
		if ($faskes1->metaData->code == '200') {
			$type1 = $faskes1->response->rujukan;
		}
		$faskes2 = json_decode($this->vclaim->get('Rujukan/RS/List/Peserta/' . $param));

		if ($faskes2->metaData->code == '200') {
			$type2 = $faskes2->response->rujukan;
		}

		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$rawatinap = $this->rjmregistrasi->get_sep_ranap($nokartu);
		$data = [
			'metaData' => [
				'code' => 200,
				'message' => 'Ok'
			],
			'response' => [
				'faskes1' => $type1,
				'faskes2' => $type2,
				'rawatinap' => $rawatinap
			]
		];
		// }
		// catch(Exception $e)
		// {
		//     echo json_encode($e);
		//     return;
		// }
		// if(!$data)
		// {
		//     echo json_encode($data);
		//     return;
		// }
		echo json_encode($data);
	}

	public function insertrujukan($nosep = '')
	{
		if($nosep == '')
		{
			echo 'Silahkan Masukan Sep Dengan Benar';
			return;
		}
		if($this->input->post())
		{
			// /Rujukan/2.0/insert
			$url = 'Rujukan/2.0/insert';
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
				"request": {
					"t_rujukan": {
							"noSep": "' . $param['noSEP'] . '",
							"tglRujukan": "' . date('Y-m-d') . '",
							"tglRencanaKunjungan":"' . $param['tgl'] . '",
							"ppkDirujuk": "' . $param['ppk_dirujuk'] . '",
							"jnsPelayanan": "' . $param['jnsPelayanan'] . '",
							"catatan": "' . $param['catatan'] . '",
							"diagRujukan": "' . $param['diagnosa'] . '",
							"tipeRujukan": "' . ($param['tipeRujukan'] ?? '') . '",
							"poliRujukan": "' . ($param['spesialis'] ?? "") . '",
							"user": "' . $this->load->get_var('user_info')->name . '"
					}
				}
			}'), true);
			$response = $this->vclaim->post($url, $data);
			header('Content-Type: application/json; charset=utf-8');
			
			echo $response;
			return;
		}
		$data['rujukan']= [];
		$data['title'] ='Pembuatan Rujukan';
		$data['nosep'] = $nosep;
        $this->load->view('rujukan/insert',$data);

	}

	function create()
	{
		$param = $this->input->post();
		$tglSep = date('Y-m-d');
		// ?ambil sep
		$url = 'SEP/'.$param['noSEP'];
		$json = $this->vclaim->get($url);
		$seps = json_decode($json);
        if($seps->metaData->code == '200')
		{
			$tglSep = $seps->response->tglSep;
		}else{
			echo "Pastikan SEP Benar!";
			return;
		}
		$url = 'Rujukan/2.0/insert';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request": {
				"t_rujukan": {
						"noSep": "' . $param['noSEP'] . '",
						"tglRujukan": "' . $tglSep . '",
						"tglRencanaKunjungan":"' . $param['tgl'] . '",
						"ppkDirujuk": "' . $param['ppk_dirujuk'] . '",
						"jnsPelayanan": "' . $param['jnsPelayanan'] . '",
						"catatan": "' . $param['catatan'] . '",
						"diagRujukan": "' . $param['diagnosa'] . '",
						"tipeRujukan": "' . ($param['tipeRujukan'] ?? '') . '",
						"poliRujukan": "' . ($param['spesialis'] ?? "") . '",
						"user": "' . $this->load->get_var('user_info')->name . '"
				}
			}
		}'), true);
		$response = $this->vclaim->post($url, $data);
		header('Content-Type: application/json; charset=utf-8');
		
		echo $response;
		return;
	}

}

?>