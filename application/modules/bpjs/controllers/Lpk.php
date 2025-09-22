<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lpk extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	/**
	 * Insert LPK
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/lpk
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * TYPE : POST
	 * <ipaddress>/bpjs/lpk/insert
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function insert()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->input->post();
		$url = 'LPK/insert';
		$diagnosa = json_encode($data['diagnosa']);
		$procedure = json_encode($data['procedure']);
		$posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
		'
		{
			"request": {
			   "t_lpk": {
				  "noSep": "'.$data['nosep'].'",
				  "tglMasuk": "'.$data['tgl_masuk'].'",
				  "tglKeluar": "'.$data['tgl_keluar'].'",
				  "jaminan": "'.$data['jaminan'].'",
				  "poli": {
					 "poli": "'.$data['poli'].'"
				  },
				  "perawatan": {
					 "ruangRawat": "'.$data['ruangrawat'].'",
					 "kelasRawat": "'.$data['kelasrawat'].'",
					 "spesialistik": "'.$data['spesialistik'].'",
					 "caraKeluar": "'.$data['carakeluar'].'",
					 "kondisiPulang": "'.$data['kondisipulang'].'"
				  },
				  "diagnosa": '.$diagnosa.',
				  "procedure": '.$procedure.',
				  "rencanaTL": {
					 "tindakLanjut": "'.$data['tindaklanjut'].'",
					 "dirujukKe": {
						"kodePPK": "'.($data['dirujukke']??'').'"
					 },
					 "kontrolKembali": {
						"tglKontrol": "'.$data['tglkontrolkembali'].'",
						"poli": "'.($data['polikontrolulang']??"").'"
					 }
				  },
				  "DPJP": "'.$data['dpjp'].'",
				  "user": "'.$this->load->get_var("user_info")->username.'"
			   }
			}
		 }
		'),true);
		//  echo '<pre>';
		//  var_dump($posting);
		//  echo '</pre>';
		//  die();
		 $response = $this->vclaim->post($url,$posting);
		echo $response;
	}

	/**
	 * Pencarian data peserta berdasarkan NIK Kependudukan
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/lpk
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * TYPE : GET
	 * <ipaddress>/bpjs/lpk/list_lpk?tglmasuk=YYYY-mm-dd&jnspelayanan=<1. Inap , 2. Jalan >
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function list_lpk()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'LPK/TglMasuk/'.$this->input->get('tglMasuk').'/JnsPelayanan/'.$this->input->get('jnsPelayanan');
	   	echo $this->vclaim->get($url);
		// echo '{
		// 	"metaData": {
		// 	   "code": "200",
		// 	   "message": "OK"
		// 	},
		// 	"response": {
		// 	   "lpk": {
		// 		  "list": [
		// 			 {
		// 				"DPJP": {
		// 				   "dokter": {
		// 					  "kode": "3",
		// 					  "nama": "Satro Jadhit, dr"
		// 				   }
		// 				},
		// 				"diagnosa": {
		// 				   "list": [
		// 					  {
		// 						 "level": "1",
		// 						 "list": {
		// 							"kode": "N88.1",
		// 							"nama": "Old laceration of cervix uteri"
		// 						 }
		// 					  },
		// 					  {
		// 						 "level": "2",
		// 						 "list": {
		// 							"kode": "A00.1",
		// 							"nama": "Cholera due to Vibrio cholerae 01, biovar eltor"
		// 						 }
		// 					  }
		// 				   ]
		// 				},
		// 				"jnsPelayanan": "1",
		// 				"noSep": "0301R0011017V000014",
		// 				"perawatan": {
		// 				   "caraKeluar": {
		// 					  "kode": "1",
		// 					  "nama": "Atas Persetujuan Dokter"
		// 				   },
		// 				   "kelasRawat": {
		// 					  "kode": "1",
		// 					  "nama": "VVIP"
		// 				   },
		// 				   "kondisiPulang": {
		// 					  "kode": "1",
		// 					  "nama": "Sembuh"
		// 				   },
		// 				   "ruangRawat": {
		// 					  "kode": "3",
		// 					  "nama": "Ruang Melati I"
		// 				   },
		// 				   "spesialistik": {
		// 					  "kode": "1",
		// 					  "nama": "Spesialis Penyakit dalam"
		// 				   }
		// 				},
		// 				"peserta": {
		// 				   "kelamin": "L",
		// 				   "nama": "123456",
		// 				   "noKartu": "0000000001231",
		// 				   "noMR": "123456",
		// 				   "tglLahir": "2008-02-05"
		// 				},
		// 				"poli": {
		// 				   "eksekutif": "0",
		// 				   "poli": {
		// 					  "kode": "INT"
		// 				   }
		// 				},
		// 				"procedure": {
		// 				   "list": [
		// 					  {
		// 						 "list": {
		// 							"kode": "00.82",
		// 							"nama": "Revision of knee replacement, femoral component"
		// 						 }
		// 					  },
		// 					  {
		// 						 "list": {
		// 							"kode": "00.83",
		// 							"nama": "Revision of knee replacement,patellar component"
		// 						 }
		// 					  }
		// 				   ]
		// 				},
		// 				"rencanaTL": null,
		// 				"tglKeluar": "2017-10-30",
		// 				"tglMasuk": "2017-10-30"
		// 			 }
		// 		  ]
		// 	   }
		// 	}
		//  }';
	}


	  /**
	 * Menu LPK
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/sep
	 * =========================================================================================
	 *
     * Data Lembar Pengajuan Klaim
	 * Insert LPK
	 * Update LPK
	 * Delete LPK
     *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/index
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function index(){
        $this->load->view('lpk',['title'=>'Lembar Pengajuan Klaim','user'=>$this->load->get_var("user_info")->username]);
	}
}

?>
