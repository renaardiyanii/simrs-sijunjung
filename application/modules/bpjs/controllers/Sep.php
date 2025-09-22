<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Sep extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	/**
	 * Pembuatan SEP v.2
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/sep
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * TYPE : POST
	 * <ipaddress>/bpjs/sep/insert_sep
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function insert_sep($no_register)
	{
		// echo $no_register;die();
		header('Content-Type: application/json; charset=utf-8');
		if($this->input->post())
		{
			$data = $this->input->post();
			$jnsPelayanan = '1';
		}else{
			$data = $this->mbpjs->get_bpjs_sep($no_register)->result_array()[0];
			$jnsPelayanan = '2';
		}
		$no_cm = $this->mbpjs->get_pasien_no_medrec($data['no_medrec']);
		if($no_cm){
			$no_cm = $no_cm->no_cm;
		}else{
			$no_cm = $data['no_medrec'];
		}
		$url = 'SEP/2.0/insert';
		$posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
		'{
			"request":{
			   "t_sep":{
				  "noKartu":"'.trim($data['no_kartu']).'",
				  "tglSep":"'.substr($data['tgl_sep'],0,10).'",
				  "ppkPelayanan":"0311R001",
				  "jnsPelayanan":"'.$jnsPelayanan.'",
				  "klsRawat":{
					 "klsRawatHak":"'.$data['kelasrawat'].'",
					 "klsRawatNaik":"'.($data['klsrawatnaik']??'').'",
					 "pembiayaan":"'.($data['pembiayaan']??'').'",
					 "penanggungJawab":"'.($data['penanggungjawab']??'').'"
				  },
				  "noMR":"'.$no_cm.'",
				  "rujukan":{
					 "asalRujukan":"'.($data['asalrujukan']==""?'2':$data['asalrujukan']).'",
					 "tglRujukan":"'.$data['tglrujukan'].'",
					 "noRujukan":"'.$data['norujukan'].'",
					 "ppkRujukan":"'.$data['ppkrujukan'].'"
				  },
				  "catatan":"'.$data['catatan'].'",
				  "diagAwal":"'.$data['diagawal'].'",
				  "poli":{
					 "tujuan":"'.$data['politujuan'].'",
					 "eksekutif":"0"
				  },
				  "cob":{
					 "cob":"0"
				  },
				  "katarak":{
					 "katarak":"'.($data['katarak']??'0').'"
				  },
				  "jaminan":{
					 "lakaLantas":"'.(!isset($data['jenis_kecelakaan'])?'0':($data['jenis_kecelakaan']==""||$data['jenis_kecelakaan']==null?'0':$data['jenis_kecelakaan'])).'",
					 "noLP":"",
					 "penjamin":{
						"tglKejadian":"'.($data['kll_tgl_kejadian']??'').'",
						"keterangan":"'.($data['kll_ketkejadian']??'').'",
						"suplesi":{
						   "suplesi":"0",
						   "noSepSuplesi":"",
						   "lokasiLaka":{
							  "kdPropinsi":"'.($data['kll_provinsi']??'').'",
							  "kdKabupaten":"'.($data['kll_kabupaten']??'').'",
							  "kdKecamatan":"'.($data['kll_kecamatan']??'').'"
						   }
						}
					 }
				  },
				  "tujuanKunj":"'.$data['tujuankunj'].'",
				  "flagProcedure":"'.$data['flagprocedure'].'",
				  "kdPenunjang":"'.$data['kdpenunjang'].'",
				  "assesmentPel":"'.$data['assesmentpel'].'",
				  "skdp":{
					 "noSurat":"'.$data['nosurat'].'",
					 "kodeDPJP":"'.$data['dpjpsurat'].'"
				  },
				  "dpjpLayan":"'.$data['dpjplayan'].'",
				  "noTelp":"'.($data['notelp']?(strlen($data['notelp'])>=8?$data['notelp']:'00000000000'):'00000000000').'",
				  "user":"'.$data['user'].'"
			   }
			}
		 }'),true);
		//  var_dump($posting);die();

	   $response = $this->vclaim->post($url,$posting);

		$data_decode = json_decode($response);
		if($data_decode->metaData->code == '200')
		{
			$no_sep = $data_decode->response->sep->noSep;
			// insert history antrol
			$this->mbpjs->insert_history_antrol([
				'no_register' => $no_register,        // Isi dengan nilai no_register, contoh: '12345678901234567890'
				'kodebooking' => '',        // Isi dengan nilai kode booking, contoh: '123456789012345678901234567890'
				'aksi' => 'cetaksep'                       // Isi dengan aksi yang sesuai, contoh: 'checkin' atau 'cetaksep'
			]);
			
			if($this->input->post())
			{
				$resu = $this->mbpjs->insert_sep([
					'no_medrec'=>$data['no_medrec'],
					'no_sep'=>$no_sep,
					'tgl_sep'=>$data_decode->response->sep->tglSep,
					'no_register'=>$no_register,
					'no_kartu'=>$data['no_kartu'],
					'kelasrawat'=>$data['kelasrawat'],
					'asalrujukan'=>($data['asalrujukan']==""?'2':$data['asalrujukan']),
					'tglrujukan'=>$data['tglrujukan'],
					'norujukan'=>$data['norujukan'],
					'ppkrujukan'=>$data['ppkrujukan'],
					'catatan'=>$data['catatan'],
					'diagawal'=>$data['diagawal'],
					'politujuan'=>'',
					'tujuankunj'=>'0',
					'flagprocedure'=>'',
					'kdpenunjang'=>'',
					'assesmentpel'=>'',
					'nosurat'=>$data['nosurat'],
					'dpjpsurat'=>$data['dpjpsurat'],
					'dpjplayan'=>'',
					'notelp'=>($data['notelp']?$data['notelp']:'00000000000'),
					'user'=>$data['user'],
					'namafaskes'=>'RSUD SIJUNJUNG'

				]);
				if($resu){
					$this->mbpjs->update_bpjs_surat_kontrol([
						'sep'=>$no_sep,
					],$data['nosurat']);
				}
			}else{
				$internal = $this->mbpjs->cari_sep($no_sep)?1:0;
				$resu = $this->mbpjs->update_sep_bpjs($no_register,['no_sep'=>$no_sep,'internal'=>$internal]);
				// $data_decode->irj = [
				// 	'dokter'=> 'Dr. XX',
				// 	'faskes_perujuk'=>'XXX'
				// ];
				// return $this->cetakan_sep($data_decode);
			}

		}
		echo $response;
	}


	public function cetakan_sep($no_register)
	{
		$daftarulang = $this->mbpjs->cari_bpjs_sep($no_register)->row();
		// var_dump($daftarulang);die();
		if($daftarulang)
		{
			if($daftarulang->internal == '1'){
				$data_sep = $this->vclaim->get('SEP/Internal/'.$daftarulang->no_sep);
			}else{
				$data_sep = $this->vclaim->get('SEP/'.$daftarulang->no_sep);
			}
			$data_decode = json_decode($data_sep);
			// echo '<pre>';
			// var_dump( $data_decode->response);
			// echo '</pre>';
			// die();

			$data_peserta = json_decode($this->vclaim->get('Peserta/nokartu/'.$daftarulang->no_kartu.'/tglSEP/'.date('Y-m-d')));
			if($data_peserta->metaData->code == '200')
			{
				$daftarulang->prb = $data_peserta->response->peserta->informasi->prolanisPRB;
				if($daftarulang->politujuan == 'IGD'){
					$daftarulang->namafaskes = $data_peserta->response->peserta->provUmum->nmProvider;
					$daftarulang->jenis_kunjungan = '-';
				}

			}
			if($data_decode->metaData->code == '200')
			{
				if($data_decode->response->jnsPelayanan == 'Rawat Inap'){
					$data_decode->response->dpjp->nmDPJP = $data_decode->response->kontrol->nmDokter;
				}
				$daftarulang->jenis_kunjungan = $data_decode->response->jnsPelayanan == 'Rawat Inap'?'-':($data_decode->response->kontrol->noSurat!= NULL ?'Kunjungan Kontrol (ulangan)<br>':'-');
				$daftarulang->jenis_kunjungan .= $daftarulang->flagprocedure != "" ?($daftarulang->flagprocedure=='0'?'Prosedur tidak berkelanjutan':'Prosedur berkelanjutan'):'';
				// kalo internal , masuk sini
				if($daftarulang->internal){
					return $this->load->view('irj/sep/view_sep_internal',$data = ['data'=>$data_decode,'daftarulang'=>$daftarulang]);
				}
				// Generate QR code based on no_sep
				$qrCode = new QrCode($daftarulang->no_sep);
				$qrCode->setSize(100); // Adjust size as needed
				$writer = new PngWriter();
				$qrCodeImage = $writer->write($qrCode)->getString();
				// Convert to base64 for embedding in HTML
				$qrCodeBase64 = base64_encode($qrCodeImage);

				$mpdf = new \Mpdf\Mpdf([
					'orientation' => 'L',
					'mode' => 'utf-8',
					'format' => [110, 220],
					'dpi' => 96,
					'default_font' => 'Arial',
					'margin_top' => 5,
					'margin_left' => 2,
					'margin_right' => 2,
					'margin_bottom' => 2,
					'margin_header' => 0,
					'margin_footer' => 0,
					'mirrorMargins' => true
				]);
				// $mpdf = new \Mpdf\Mpdf([
				// 	'orientation' => 'L',
				// 	// 'mode' => 'utf-8',
				// 	'format' => [150, 220]
				// ]);
				ob_start();
				ob_end_clean();
				$mpdf->SetDisplayMode('real');
				$mpdf->curlAllowUnsafeSslRequests = true;
				// var_dump($qrCodeBase64);die();
				$html = $this->load->view('irj/sep/view_sep',$data = ['data'=>$data_decode,'daftarulang'=>$daftarulang,'qrCodeBase64' => $qrCodeBase64],true);
				//$this->mpdf->AddPage('L'); 
				// return $this->load->view($html);
				$mpdf->WriteHTML($html);
				$mpdf->Output();


				// return 
			}
			echo 'Data Tidak Ditemukan';
			return;
		}
		echo 'Data Tidak Ditemukan';
	}

	
// public function cetakan_sep($no_register)
// {
//     $daftarulang = $this->mbpjs->cari_bpjs_sep($no_register)->row();
//     if ($daftarulang) {
//         if ($daftarulang->internal == '1') {
//             $data_sep = $this->vclaim->get('SEP/Internal/' . $daftarulang->no_sep);
//         } else {
//             $data_sep = $this->vclaim->get('SEP/' . $daftarulang->no_sep);
//         }
//         $data_decode = json_decode($data_sep);

//         if ($data_decode->metaData->code == '200') {
//             // Generate QR code based on no_sep
//             $qrCode = new QrCode($daftarulang->no_sep);
//             $qrCode->setSize(100); // Adjust size as needed
//             $writer = new PngWriter();
//             $qrCodeImage = $writer->write($qrCode)->getString();

//             // Convert to base64 for embedding in HTML
//             $qrCodeBase64 = base64_encode($qrCodeImage);

//             // Add QR code to the data array
//             $data = [
//                 'data' => $data_decode,
//                 'daftarulang' => $daftarulang,
//                 'qrCodeBase64' => $qrCodeBase64
//             ];

//             $mpdf = new \Mpdf\Mpdf([
//                 'orientation' => 'L',
//                 'mode' => 'utf-8',
//                 'format' => [110, 220],
//                 'dpi' => 96,
//                 'default_font' => 'Arial',
//                 'margin_top' => 5,
//                 'margin_left' => 2,
//                 'margin_right' => 2,
//                 'margin_bottom' => 2,
//                 'margin_header' => 0,
//                 'margin_footer' => 0,
//                 'mirrorMargins' => true
//             ]);

//             $html = $this->load->view('irj/sep/view_sep', $data, true);
//             $mpdf->WriteHTML($html);
//             $mpdf->Output();
//             return;
//         }
//     }
//     echo 'Data Tidak Ditemukan';
// }


	public function sep_suplesi($nokartu,$tgl)
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'sep/JasaRaharja/Suplesi/'.$nokartu.'/tglPelayanan/'.$tgl;
		echo $this->vclaim->get($url);
		// echo '{
		// 	"metaData": {
		// 	  "code": "200",
		// 	  "message": "Sukses"
		// 	},
		// 	"response": {
		// 	  "jaminan": [
		// 		{
		// 		  "noRegister": "1234",
		// 		  "noSep": "0301R0110818V000008",
		// 		  "noSepAwal": "0301R0110818V000008",
		// 		  "noSuratJaminan": "-",
		// 		  "tglKejadian": "2018-08-06",
		// 		  "tglSep": "2018-08-08"
		// 		},
		// 		{
		// 		  "noRegister": "44222",
		// 		  "noSep": "0301R0110818V000018",
		// 		  "noSepAwal": "0301R0110818V000008",
		// 		  "noSuratJaminan": "-",
		// 		  "tglKejadian": "2018-08-06",
		// 		  "tglSep": "2018-08-08"
		// 		}
		// 	  ]
		// 	}
		//   }';
	}

	 /**
	 * Pencarian SEP
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/sep
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/cari_sep/<sep>
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function cari_sep($sep){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'SEP/'.$sep;
		$json = $this->vclaim->get($url);
		$data_sep = json_decode($json);
		if($data_sep->metaData->code == '200')
		{
			$data_sep->local= $this->mbpjs->cari_sep($sep);
			echo json_encode($data_sep);
			return;
		}
		$data_sep->local = '';
		echo json_encode($data_sep);
		return;

	}


	 /**
	 * Pencarian SEP Internal
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/sep
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/cari_sep_internal/<sep>
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function cari_sep_internal($sep){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'SEP/Internal/'.$sep;
		echo $this->vclaim->get($url);
	}



	/**
	 * Hapus SEP 2.0
	 * Fungsi : Hapus SEP 2.0
	 * method : DELETE
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
	public function delete_sep()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = 'SEP/2.0/delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request": {
			   "t_sep": {
				  "noSep": "'.$param['nosep'].'",
				  "user": "'.$param['user'].'"
			   }
			}
		 }
		'),true);
	   $response = $this->vclaim->delete($url,$data);
	   $this->mbpjs->delete_sep($param['nosep']);
	   echo $response;
	}

	public function delete_sep_2($no_sep,$noreg)
	{
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		header('Content-type: application/json');
		$url = 'SEP/2.0/delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request": {
			   "t_sep": {
				  "noSep": "'.$no_sep.'",
				  "user": "'.$user.'"
			   }
			}
		 }
		'),true);
		$response = $this->vclaim->delete($url,$data);
		$this->mbpjs->delete_sep($no_sep,$noreg);
		echo $response;
	}

	/**
	 * Hapus SEP INTERNAL 2.0
	 * Fungsi : Hapus SEP INTERNAL 2.0
	 * method : POST
	 */
	public function delete_sep_internal()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = 'SEP/Internal/delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request": {
			   "t_sep": {
				  "noSep": "'.$param['noSep'].'",
				  "noSurat": "'.$param['noSurat'].'",
				  "tglRujukanInternal": "'.$param['tglRujukanInternal'].'",
				  "kdPoliTuj": "'.$param['kdPoliTuj'].'",
				  "user": "'.$this->load->get_var('user_info')->name.'"
			   }
			}
		} 
		'),true);
	   $response = $this->vclaim->delete($url,$data);
	   echo $response;
	}


	/**
	 * Update SEP versi 2.0
	 * Fungsi : Update SEP versi 2.0
	 * method : POST
	 */
	public function update_sep()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		// var_dump($param);die();
		$url = 'SEP/2.0/update';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request": {
			   "t_sep": {
					   "noSep": "'.$param['noSep'].'",
					   "klsRawat":{
									   "klsRawatHak":"'.$param['klsRawatHak'].'",
									   "klsRawatNaik":"'.$param['klsRawatNaik'].'",
									   "pembiayaan":"'.$param['pembiayaan'].'",
									   "penanggungJawab":"'.$param['penanggungJawab'].'"
									 },
					   "noMR": "'.$param['noMr'].'",
					   "catatan": "'.$param['catatan'].'",
					   "diagAwal": "'.$param['diagAwal'].'",
					   "poli": {
							   "tujuan": "'.$param['tujuan'].'",
							   "eksekutif": "'.$param['eksekutif'].'"
					   },
					   "cob": {
							   "cob": "'.$param['cob'].'"
					   },
					   "katarak": {
							   "katarak": "'.$param['katarak'].'"
					   },
					   "jaminan": {
							   "lakaLantas": "'.$param['lakaLantas'].'",
							   "penjamin": {
									   "tglKejadian": "'.$param['tglKejadian'].'",
									   "keterangan": "'.$param['keterangan'].'",
									   "suplesi": {
											   "suplesi": "'.($param['suplesi'] == ""?'0':$param['suplesi']).'",
											   "noSepSuplesi": "'.$param['noSepSuplesi'].'",
											   "lokasiLaka": {
													   "kdPropinsi": "'.$param['kdPropinsi'].'",
													   "kdKabupaten": "'.($param['kdKabupaten']??'').'",
													   "kdKecamatan": "'.($param['kdKecamatan']??"").'"
											   }
									   }
							   }
					   },
					   "dpjpLayan":"'.$param['dpjpLayan'].'",
					   "noTelp": "'.$param['noTelp'].'",
					   "user": "'.$this->load->get_var('user_info')->name.'"
			   }
			 }
		   }
		'),true);
		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';
		// die();
	   $response = $this->vclaim->put($url,$data);
	   echo $response;
	}

/**
	 * Update Pulang SEP 2.0
	 * Fungsi : Update Pulang SEP 2.0
	 * method : PUT
	 * Body   :
	 * {
                "request":{
                    "t_sep":{
                        "noSep": "0301R0110121V000829",
                        "statusPulang":"4",
                        "noSuratMeninggal":"325/K/KMT/X/2021",
                        "tglMeninggal":"2021-02-10",
                        "tglPulang":"2021-02-14",
                        "noLPManual":"",
                        "user":"coba"
                    }
                }
            }
	 */
	public function update_pulang_sep()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = 'SEP/2.0/updtglplg';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request":{
				"t_sep":{
					"noSep": "'.$param['noSep'].'",
					"statusPulang":"'.$param['statusPulang'].'",
					"noSuratMeninggal":"'.$param['noSuratMeninggal'].'",
					"tglMeninggal":"'.$param['tglMeninggal'].'",
					"tglPulang":"'.$param['tglPulang'].'",
					"noLPManual":"'.$param['noLPManual'].'",
					"user":"'.$param['user'].'"
				}
			}
		}
		'),true);
	   $response = $this->vclaim->put($url,$data);
	   echo $response;
	}


	/**
	 * Approval Penjaminan SEP
	 * Fungsi : Pengajuan SEP / Approval SEP
	 * Param : 0  : pengajuan , 1: approval
	 * method : POST
	 * Body   :
	 * {
           "request": {
              "t_sep": {
                 "noKartu": "0001300759569",
                 "tglSep": "2021-03-26",
                 "jnsPelayanan": "1",
                 "jnsPengajuan": "2",
                 "keterangan": "Hari libur",
                 "user": "Coba Ws"
              }
           }
        }
	 */
	public function pengajuan_approval($type)
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = $type=='0'?'Sep/pengajuanSEP':'Sep/aprovalSEP';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{
			"request": {
			   "t_sep": {
				  "noKartu": "'.$param['noKartu'].'",
				  "tglSep": "'.$param['tglSep'].'",
				  "jnsPelayanan": "'.$param['jnsPelayanan'].'",
				  "jnsPengajuan": "'.$param['jnsPengajuan'].'",
				  "keterangan": "'.$param['keterangan'].'",
				  "user": "'.$param['user'].'"
			   }
			}
		 }
		'),true);
	   $response = $this->vclaim->post($url,$data);
	   echo $response;
	}

	

	  /**
	 * Menu SEP
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/sep
	 * =========================================================================================
	 *
     * Cari SEP
     * Update SEP
     * Hapus SEP
     * Data Induk Kecelakaan
     * Pengajuan Penjaminan SEP
	 * Update Tgl Pulang SEP
	 * Integrasi SEP dengan INACBG
	 * SEP Internal
	 * Hapus SEP Internal
	 * Get Finger Print
	 * Get List Fingerprint
     *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/index
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function index(){
        $this->load->view('sep',['title'=>'SEP','user'=>$this->load->get_var("user_info")->username]);
	}

	public function edit($sep)
    {
		$url = 'SEP/'.$sep;
		$json = $this->vclaim->get($url);
		$data = json_decode($json);
		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';
		// die();
        if($data->metaData->code == '200')
		{
			$data->local= $this->mbpjs->cari_sep($sep);
			$data->du= $data->response->jnsPelayanan == 'Rawat Inap'?$this->mbpjs->get_diagnosa_ranap($sep):$this->mbpjs->get_diagnosa($sep);

			// $data->du= $this->mbpjs->get_diagnosa($sep);
		}
        $this->load->view('sep/edit',['title'=>'Edit SEP','data'=>$data]);
    }

	public function history_sep($nokartu){
		$data['monitoring']= [];
		$data['title'] ='History Pelayanan SEP';
		$data['nokartu'] = $nokartu;
        if($this->input->get('no_kartu'))
        {
            $data['monitoring'] = json_decode($this->vclaim->get('/monitoring/HistoriPelayanan/NoKartu/'.$this->input->get('no_kartu').'/tglMulai/'.$this->input->get('tgl_mulai').'/tglAkhir/'.$this->input->get('tgl_akhir')));
            if($data['monitoring']->metaData->code !== '200')
            {
                $this->session->set_flashdata('err','<div class="mt-4 ml-4"><span class="text-bold text-danger">'.$data['monitoring']->metaData->message.'</span></div>');
    
            }
        }
        $this->load->view('sep/history_sep',$data);
	}

	
	public function get_noregister_booking($kodebooking){
		header('Content-Type: application/json; charset=utf-8');
		$data= $this->mbpjs->get_noregister_booking($kodebooking);
		echo json_encode($data);
	}

	public function get_noregister_noregister($noregister){
		header('Content-Type: application/json; charset=utf-8');
		$data= $this->mbpjs->get_noregister_noregister($noregister);
		echo json_encode($data);
	}

	public function buat($noregister){
        // ambil data pasien dari no register

		// data required 
		$datapasien = $this->mbpjs->getdatapasienberdasarnoregister($noregister);

		// pengambilan spri yang sudah dibuat dan belum dilakukan pembuatan sep
		$spri = $this->mbpjs->getdataspribynoka($datapasien->no_kartu);
		// var_dump($spri);
		// die();
		// No. Kartu BPJS -> data_pasien.no_bpjs
		// No. Telepon -> data_pasien.no_hp
		// 
		$data = [
			'datapasien'=>$datapasien,
			'title'=>'Pembuatan SEP Rawat Inap',
			'no_register'=> $noregister,
			'spri'=>$spri

		];
		
		$this->load->view("sep/buat",$data);
	}
}

?>
