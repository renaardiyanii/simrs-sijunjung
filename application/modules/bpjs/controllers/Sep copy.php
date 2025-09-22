<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');


class Sep extends Secure_area {
	public $xuser;
	public $connection_error;
	public $bpjs_config;
	public function __construct(){
	    parent::__construct();
	    $this->load->helper('pdf_helper');	
	    $this->load->model('bpjs/Mbpjs','',TRUE);	
	    $this->load->model('bpjs/Mpasien','',TRUE);
	    $this->load->model('bpjs/Msep','',TRUE);	            
	    $this->load->model('irj/rjmregistrasi','',TRUE);	
	    $this->load->library('vclaim');  	    
		$this->xuser = $this->load->get_var("user_info")->username; 
		$result_error = array(
			'metaData' => array('code' => '503','message' => 'Terjadi Kesalahan, koneksi dengan service gagal'),
			'response' => ['peserta' => null]
		);
		$this->connection_error = json_encode($result_error); 
		$this->bpjs_config = $this->Mbpjs->get_data_bpjs();	
	}

	public function show($no_sep="") 
	{					
		$param = 'SEP/'.$no_sep;
		$content_type = 'Application/x-www-form-urlencoded';
		$result = $this->vclaim->get($param,$content_type);				
		if ($result) {
			return $result;
		} else {
			return $this->connection_error;
		}
	}

	public function cari_sep($no_register="") 
	{	
		$no_sep = $this->Mpasien->pelayanan($no_register)->no_sep;
		$result = $this->show($no_sep);
		echo $result;
	}

	public function delete() 
	{
		$no_sep = $this->input->post('no_sep');
		$jnsPelayanan = $this->input->post('jnsPelayanan');
		if ($no_sep==''){
			$result_error = array(
        		'metaData' => array('code' => '402','message' => 'SEP tidak boleh kosong.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);		
		} else {				        
		  	$data_request = array(
		   		'request'=>array(
			   		't_sep'=>array(
			   			'noSep' => $no_sep,
			   			'user' => $this->xuser
			   		)
			   	)
		   	);
    	   	$data = json_encode($data_request);										
            $param = 'SEP/Delete';
			$content_type = 'application/x-www-form-urlencoded';
			$result = $this->vclaim->delete($param,$content_type,$data);
            if ($result) { 
		    	$result_object = json_decode($result);
				if ($result_object->metaData->code == '200') {
					switch ($jnsPelayanan) {
					    case 1:
					        $this->Mbpjs->hapussep_iri($no_sep);
					        break;
					    case 2:
					        $this->Mbpjs->hapussep_irj($no_sep);
					        break;
					}
					$data_update['deleted'] = 1;
					$data_update['user_deleted'] = $this->xuser;
					$this->Msep->update($no_sep,$data_update);					
				}
				echo $result;	
		 	} else {				
				echo $this->connection_error;					 			
		 	}
		}
	}
	
	function insert_sep($no_register='') 
	{		
		
		$data_pelayanan = $this->Mpasien->pelayanan($no_register);
		// var_dump($data_pelayanan);die();
		if (empty($data_pelayanan)) {
			$result_error = array(
				'metaData' => array('code' => '404','message' => 'Maaf data pelayanan dengan No. Register '.$no_register.' tidak ditemukan.'),
				'response' => null
			);
			return json_encode($result_error);
		} else {
			$no_bpjs = $data_pelayanan->no_kartu;
			
			if ($no_bpjs == '' || $no_bpjs == null) {
				$result_error = array(
					'metaData' => array('code' => '402','message' => 'No. BPJS Kosong. Isi terlebih dahulu No. BPJS.'),
					'response' => null
				);
				return json_encode($result_error);
			} else {
				$tgl_pelayanan = date('Y-m-d');
				$param = 'Peserta/nokartu/'.$no_bpjs.'/'.'tglSEP/'.$tgl_pelayanan;
				$content_type = 'application/json';
				$data_peserta = $this->vclaim->get($param,$content_type);
				
						
				$cek_peserta = json_decode($data_peserta);	

				$asalRujukan = '1';	
				$tglRujukan = '';
				$noRujukan = '';
				$ppkRujukan = '';
				$diagAwal = '';
				$poliTujuan = '';
				if ($data_pelayanan->catatan == '' || $data_pelayanan->catatan == null) {
					$catatan = '';
				} else $catatan = $data_pelayanan->catatan;
				$katarak = $data_pelayanan->katarak;
				$noTelp = isset($data_pelayanan->no_hp)?$data_pelayanan->no_hp:'075221013';
				if ($data_pelayanan->dpjp_skdp_sep == '' || $data_pelayanan->dpjp_skdp_sep == null) {
					$kodeDPJP = '';
				} else $kodeDPJP = $data_pelayanan->dpjp_skdp_sep;

				if ($data_pelayanan->nosurat_skdp_sep == '' || $data_pelayanan->nosurat_skdp_sep == null) {
					$noSurat = '';
				} else $noSurat = $data_pelayanan->nosurat_skdp_sep;

				$lakaLantas = '0';
				$penjamin = '';
	       		$tglKejadian = '';
	       		$kll_keterangan = '';
	       		$suplesi = '0';
	       		$noSepSuplesi = '';
	       		$kdPropinsi = '';
	       		$kdKabupaten = '';
	       		$kdKecamatan = '';

	       		$kodePpk = '';
	       		$namaPpk = '';
		    	if (isset($cek_peserta->metaData->code)) {			
					if ($cek_peserta->metaData->code == '200') {
						if (substr($no_register,0,2) == 'RJ') {
							$jnsPelayanan = '2';
							$klsRawat = '3';
							
							if ($data_pelayanan->id_poli == 'BA00') {
								$ppkRujukan = $cek_peserta->response->peserta->provUmum->kdProvider;
								$namaPpk = $cek_peserta->response->peserta->provUmum->nmProvider;
								if ($data_pelayanan->alasan_berobat == 'kecelakaan') {
									$lakaLantas = "1";
						       		$penjamin = $data_pelayanan->kll_penjamin;
						       		$tglKejadian = $data_pelayanan->kll_tgl_kejadian;
						       		$kll_keterangan = $data_pelayanan->kll_ketkejadian;
						       		$kdPropinsi = $data_pelayanan->kll_provinsi;
						       		$kdKabupaten = $data_pelayanan->kll_kabupaten;
						       		$kdKecamatan = $data_pelayanan->kll_kecamatan;
								}	
					       	} else {
					       		if ($data_pelayanan->no_rujukan == NULL || $data_pelayanan->no_rujukan == '') {	
					       			$result_error = array(
										'metaData' => array('code' => '402','message' => 'Nomor Rujukan Kosong. Masukkan No. Rujukan untuk membuat SEP.'),
										'response' => null
									);
									return json_encode($result_error);
					       		} else {	
						       		switch ($data_pelayanan->cara_kunj) {
						       			case 'RUJUKAN PUSKESMAS':			
											$result_faskes = $this->rujukan_pcare($data_pelayanan->no_rujukan);
											
											$result_faskes_object = json_decode($result_faskes);
											if ($result_faskes_object->metaData->code == '200') {
												$tglRujukan = $result_faskes_object->response->rujukan->tglKunjungan;
												$noRujukan = $data_pelayanan->no_rujukan;
												$ppkRujukan = $result_faskes_object->response->rujukan->provPerujuk->kode;
												$namaPpk = $result_faskes_object->response->rujukan->provPerujuk->nama;
												$kodePpk = $result_faskes_object->response->rujukan->provPerujuk->kode;
											}										
						       				break;
						       			case 'RUJUKAN RS':
						       				$asalRujukan = '2';	
											$result_faskes = $this->rujukan_rs($data_pelayanan->no_rujukan);
											$result_faskes_object = json_decode($result_faskes);
											if ($result_faskes_object->metaData->code == '200') {
												$tglRujukan = $result_faskes_object->response->rujukan->tglKunjungan;
												$noRujukan = $data_pelayanan->no_rujukan;
												$ppkRujukan = $result_faskes_object->response->rujukan->provPerujuk->kode;
												$namaPpk = $result_faskes_object->response->rujukan->provPerujuk->nama;
												$kodePpk = $result_faskes_object->response->rujukan->provPerujuk->kode;
											}										
						       				break;					       			
						       			default:
						       				$result_error = array(
												'metaData' => array('code' => '402','message' => 'Untuk Poli selain UGD pilih Cara Kunjungan Rujukan Poli, Rujukan Puskesmas atau Rujukan RS.'),
												'response' => null
											);
											return json_encode($result_error);
						       				break;
						       		}
						       	}
					       	}

							$tglSep = date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan));
							$poliTujuan = $data_pelayanan->poli_bpjs;
							if ($data_pelayanan->diagnosa != '' && $data_pelayanan->diagnosa != null) {
								$diagAwal = $data_pelayanan->diagnosa;
							}
						} 
						else if (substr($no_register,0,2) == 'RI') {
							$jnsPelayanan = '1';
							$klsRawat = $cek_peserta->response->peserta->hakKelas->kode;
							$tglSep = date('Y-m-d',strtotime($data_pelayanan->tgl_masuk));
							// $asalRujukan = $data_pelayanan->asal_rujukan;
							$asalRujukan = "2";
							if ($data_pelayanan->no_rujukan != '' && $data_pelayanan->no_rujukan != NULL) {	
								$noRujukan = $data_pelayanan->no_rujukan;
							}
							$tglRujukan = date('Y-m-d',strtotime($data_pelayanan->tgl_rujukan));
							if ($data_pelayanan->diagmasuk != '' && $data_pelayanan->diagmasuk != null) {
								$diagAwal = $data_pelayanan->diagmasuk;
							}
							$ppk_rujukan = explode(" - ", $data_pelayanan->ppk_asal_rujukan);
							// $ppkRujukan = $ppk_rujukan[0];
							$ppkRujukan = "0901R004";
							$kodePpk = $ppk_rujukan[0];
							$namaPpk = $ppk_rujukan[1];
						}		
				    	 
						
						$request_sep = array(
						   	'request'=>array(
						   		't_sep'=>array(
						   			'noKartu' => $data_pelayanan->no_kartu,
						   			'tglSep' =>  $tglSep,
						   			'ppkPelayanan' => $this->bpjs_config->rsid,
						   			'jnsPelayanan' => $jnsPelayanan,
						   			'klsRawat' => $klsRawat,
				                 	'noMR' => $data_pelayanan->no_cm,
				                 	'rujukan' => array(
				                 		'asalRujukan' => $asalRujukan,
				                 		'tglRujukan' => $tglRujukan,
				                 		'noRujukan' => $noRujukan,
				                 		'ppkRujukan' => $ppkRujukan
				                 	),
				                 	'catatan' => $catatan,
				                 	'diagAwal' => $diagAwal,
				                 	'poli' => array(
				                 		'tujuan' => $poliTujuan,
				                 		'eksekutif' => '0'
				                 	),
				                 	'cob' => array(
				                 		'cob' => '0'
				                 	),
				                 	'katarak' => array(
				                 		'katarak' => $katarak
				                 	),
				                 	'jaminan' => array(
				                 		'lakaLantas' => $lakaLantas,
				                 		'penjamin' => array(
					                 		'penjamin' => $penjamin,
					                 		'tglKejadian' => $tglKejadian,
					                 		'keterangan' => $kll_keterangan,
					                 		'suplesi' => array(
						                 		'suplesi' => $suplesi,
						                 		'noSepSuplesi' => $noSepSuplesi,
						                 		'lokasiLaka' => array(
							                 		'kdPropinsi' => $kdPropinsi,
							                 		'kdKabupaten' => $kdKabupaten,
							                 		'kdKecamatan' => $kdKecamatan
							                 	)
						                 	)
					                 	)
				                 	),
				                 	'skdp' => array(
				                 		'noSurat' => $noSurat,
				                 		'kodeDPJP' => $kodeDPJP
				                 	),
				                 	'noTelp' => $noTelp,
				                 	'user' => $this->xuser		   					   			
						   		)
						   	)
						);		
						$data_sep = json_encode($request_sep);	
						// var_dump($data_sep);die();        
				        $param = 'SEP/1.1/insert';
						$content_type = 'Application/x-www-form-urlencoded';
						$result = $this->vclaim->post($param,$content_type,$data_sep); 
				        if ($result == '' || $result == null) {
							return $this->connection_error;
						} else {		 	
							$result_object = json_decode($result);
							if ($result_object->metaData->code == '200') {		
								if (substr($no_register,0,2) == 'RJ') {	
					              	$data_update = array(
				           				'no_sep' => $result_object->response->sep->noSep
					              	);
					           		$this->Mbpjs->update_sep_irj($no_register,$data_update);
								} 
								if (substr($no_register,0,2) == 'RI') {
									$data_update = array(
				           				'no_sep' => $result_object->response->sep->noSep
					              	);
									$this->Mbpjs->update_sep_iri($no_register,$data_update);				
								}	
								$data_insert = array(
				           			'no_sep' => $result_object->response->sep->noSep,
				           			'no_medrec' => $data_pelayanan->no_medrec,
				           			'tgl_sep' => $result_object->response->sep->tglSep,
				           			'jenis_faskes' => $asalRujukan,
				           			'kode_ppk' => $kodePpk,
				           			'nama_ppk' => $namaPpk,
				           			'created_at' => date('Y-m-d H:i:s'),
				           			'user_created' => $this->xuser
				              	);
				           		$this->Mbpjs->insert_sep($data_insert);		
							}
							return $result;
						}  		
				 	} else {
				 		return $data_peserta; 
				 	}
				} else {			
				 	return $this->connection_error;	
				}
			}			
		}	
	}

	function insert_sep_request($no_register='') 
	{		
		$data_pelayanan = $this->Mpasien->pelayanan($no_register);
		if (empty($data_pelayanan)) {
			$result_error = array(
				'metaData' => array('code' => '404','message' => 'Maaf data pelayanan dengan No. Register '.$no_register.' tidak ditemukan.'),
				'response' => null
			);
			return json_encode($result_error);
		} else {
			$no_bpjs = $data_pelayanan->no_kartu;
			if ($no_bpjs == '' || $no_bpjs == null) {
				$result_error = array(
					'metaData' => array('code' => '402','message' => 'No. BPJS Kosong. Isi terlebih dahulu No. BPJS.'),
					'response' => null
				);
				return json_encode($result_error);
			} else {
				$tgl_pelayanan = date('Y-m-d');
				$param = 'Peserta/nokartu/'.$no_bpjs.'/'.'tglSEP/'.$tgl_pelayanan;
				$content_type = 'application/json';
				$data_peserta = $this->vclaim->get($param,$content_type);		
				$cek_peserta = json_decode($data_peserta);	

				$asalRujukan = '1';	
				$tglRujukan = '';
				$noRujukan = '';
				$ppkRujukan = '';
				$diagAwal = '';
				$poliTujuan = '';
				if ($data_pelayanan->catatan == '' || $data_pelayanan->catatan == null) {
					$catatan = '';
				} else $catatan = $data_pelayanan->catatan;
				$katarak = $data_pelayanan->katarak;
				$noTelp = $data_pelayanan->no_hp;
				if ($data_pelayanan->dpjp_skdp_sep == '' || $data_pelayanan->dpjp_skdp_sep == null) {
					$kodeDPJP = '';
				} else $kodeDPJP = $data_pelayanan->dpjp_skdp_sep;

				if ($data_pelayanan->nosurat_skdp_sep == '' || $data_pelayanan->nosurat_skdp_sep == null) {
					$noSurat = '';
				} else $noSurat = $data_pelayanan->nosurat_skdp_sep;

				$lakaLantas = '0';
				$penjamin = '';
	       		$tglKejadian = '';
	       		$kll_keterangan = '';
	       		$suplesi = '0';
	       		$noSepSuplesi = '';
	       		$kdPropinsi = '';
	       		$kdKabupaten = '';
	       		$kdKecamatan = '';

	       		$kodePpk = '';
	       		$namaPpk = '';

		    	if (isset($cek_peserta->metaData->code)) {			
					if ($cek_peserta->metaData->code == '200') {
						if (substr($no_register,0,2) == 'RJ') {
							$jnsPelayanan = '2';
							$klsRawat = '3';
							if ($data_pelayanan->id_poli == 'BA00') {
								$ppkRujukan = $cek_peserta->response->peserta->provUmum->kdProvider;
								$namaPpk = $cek_peserta->response->peserta->provUmum->nmProvider;
								if ($data_pelayanan->alasan_berobat == 'kecelakaan') {
									$lakaLantas = "1";
						       		$penjamin = $data_pelayanan->kll_penjamin;
						       		$tglKejadian = $data_pelayanan->kll_tgl_kejadian;
						       		$kll_keterangan = $data_pelayanan->kll_ketkejadian;
						       		$kdPropinsi = $data_pelayanan->kll_provinsi;
						       		$kdKabupaten = $data_pelayanan->kll_kabupaten;
						       		$kdKecamatan = $data_pelayanan->kll_kecamatan;
								}	
					       	} else {
					       		if ($data_pelayanan->no_rujukan == NULL || $data_pelayanan->no_rujukan == '') {	
					       			$result_error = array(
										'metaData' => array('code' => '402','message' => 'Nomor Rujukan Kosong. Masukkan No. Rujukan untuk membuat SEP.'),
										'response' => null
									);
									return json_encode($result_error);
					       		} else {	
						       		switch ($data_pelayanan->cara_kunj) {
						       			case 'RUJUKAN PUSKESMAS':			
											$result_faskes = $this->rujukan_pcare($data_pelayanan->no_rujukan);
											$result_faskes_object = json_decode($result_faskes);
											if ($result_faskes_object->metaData->code == '200') {
												$tglRujukan = $result_faskes_object->response->rujukan->tglKunjungan;
												$noRujukan = $data_pelayanan->no_rujukan;
												$ppkRujukan = $result_faskes_object->response->rujukan->provPerujuk->kode;
												$namaPpk = $result_faskes_object->response->rujukan->provPerujuk->nama;
												$kodePpk = $result_faskes_object->response->rujukan->provPerujuk->kode;
											}										
						       				break;
						       			case 'RUJUKAN RS':
						       				$asalRujukan = '2';	
											$result_faskes = $this->rujukan_rs($data_pelayanan->no_rujukan);
											$result_faskes_object = json_decode($result_faskes);
											if ($result_faskes_object->metaData->code == '200') {
												$tglRujukan = $result_faskes_object->response->rujukan->tglKunjungan;
												$noRujukan = $data_pelayanan->no_rujukan;
												$ppkRujukan = $result_faskes_object->response->rujukan->provPerujuk->kode;
												$namaPpk = $result_faskes_object->response->rujukan->provPerujuk->nama;
												$kodePpk = $result_faskes_object->response->rujukan->provPerujuk->kode;
											}										
						       				break;					       			
						       			default:
						       				$result_error = array(
												'metaData' => array('code' => '402','message' => 'Untuk Poli selain UGD pilih Cara Kunjungan Rujukan Puskesmas atau Rujukan RS.'),
												'response' => null
											);
											return json_encode($result_error);
						       				break;
						       		}
						       	}
					       	}

							$tglSep = date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan));
							$poliTujuan = $data_pelayanan->poli_bpjs;
							if ($data_pelayanan->diagnosa != '' && $data_pelayanan->diagnosa != null) {
								$diagAwal = $data_pelayanan->diagnosa;
							}
						} 
						if (substr($no_register,0,2) == 'RI') {
							$jnsPelayanan = '1';
							$klsRawat = $cek_peserta->response->peserta->hakKelas->kode;
							$tglSep = date('Y-m-d',strtotime($data_pelayanan->tgl_masuk));
							// $asalRujukan = $data_pelayanan->asal_rujukan;
							$asalRujukan = "2";
							if ($data_pelayanan->no_rujukan != '' && $data_pelayanan->no_rujukan != NULL) {	
								$noRujukan = $data_pelayanan->no_rujukan;
							}
							$tglRujukan = date('Y-m-d',strtotime($data_pelayanan->tgl_rujukan));
							if ($data_pelayanan->diagmasuk != '' && $data_pelayanan->diagmasuk != null) {
								$diagAwal = $data_pelayanan->diagmasuk;
							}
							$ppk_rujukan = explode(" - ", $data_pelayanan->ppk_asal_rujukan);
							// $ppkRujukan = $ppk_rujukan[0];
							$ppkRujukan = "0901R004";
							$kodePpk = $ppk_rujukan[0];
							$namaPpk = $ppk_rujukan[1];
						}		
				    	 
						$request_sep = array(
						   	'request'=>array(
						   		't_sep'=>array(
						   			'noKartu' => $data_pelayanan->no_kartu,
						   			'tglSep' =>  $tglSep,
						   			'ppkPelayanan' => $this->bpjs_config->rsid,
						   			'jnsPelayanan' => $jnsPelayanan,
						   			'klsRawat' => $klsRawat,
				                 	'noMR' => $data_pelayanan->no_cm,
				                 	'rujukan' => array(
				                 		'asalRujukan' => $asalRujukan,
				                 		'tglRujukan' => $tglRujukan,
				                 		'noRujukan' => $noRujukan,
				                 		'ppkRujukan' => $ppkRujukan
				                 	),
				                 	'catatan' => $catatan,
				                 	'diagAwal' => $diagAwal,
				                 	'poli' => array(
				                 		'tujuan' => $poliTujuan,
				                 		'eksekutif' => '0'
				                 	),
				                 	'cob' => array(
				                 		'cob' => '0'
				                 	),
				                 	'katarak' => array(
				                 		'katarak' => $katarak
				                 	),
				                 	'jaminan' => array(
				                 		'lakaLantas' => $lakaLantas,
				                 		'penjamin' => array(
					                 		'penjamin' => $penjamin,
					                 		'tglKejadian' => $tglKejadian,
					                 		'keterangan' => $kll_keterangan,
					                 		'suplesi' => array(
						                 		'suplesi' => $suplesi,
						                 		'noSepSuplesi' => $noSepSuplesi,
						                 		'lokasiLaka' => array(
							                 		'kdPropinsi' => $kdPropinsi,
							                 		'kdKabupaten' => $kdKabupaten,
							                 		'kdKecamatan' => $kdKecamatan
							                 	)
						                 	)
					                 	)
				                 	),
				                 	'skdp' => array(
				                 		'noSurat' => $noSurat,
				                 		'kodeDPJP' => $kodeDPJP
				                 	),
				                 	'noTelp' => $noTelp,
				                 	'user' => $this->xuser		   					   			
						   		)
						   	)
						);		
						$data_sep = json_encode($request_sep);	
						echo $data_sep;			        		
				 	} else {
				 		return $data_peserta; 
				 	}
				} else {			
				 	return $this->connection_error;	
				}
			}			
		}	
	}

	public function create($no_register="") 
	{		
		$result_create = $this->insert_sep($no_register);
		if ($result_create) {      
			echo $result_create;  	
		} else {
			echo $this->connection_error;	
		} 								  
	}	

	public function cetak($no_register="") 
	{					
		$data_sep = $this->Msep->show($no_register);
		if ($data_sep == null) {     
			$error_view = '<!DOCTYPE html>
							<html>
							<head>
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<style>
							.notice {
							    padding: 15px;
							    background-color: #fafafa;
							    border-left: 6px solid #7f7f84;
							    margin-top: 25px;
							    margin-bottom: 10px;
							    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							}
							.notice-danger {
								font-family: Helvetica,Arial;
							    border-color: #d73814;
							}
							.notice-danger h3
							{
								margin-top: 0;
								margin-bottom: 15px;
							    color: #d9534f;
							    font-family: Helvetica,Arial;
							}
							</style>
							</head>
							<body>
								<div class="notice notice-danger">
									<h3>Tidak dapat mencetak SEP</h3>
	        						Data tidak ditemukan.
	    						</div>
							</body>
							</html>';
			echo $error_view;
			return true;
		}	
		$data_pasien = $this->Mpasien->show($data_sep->no_medrec);		
		$cetakan_ke = $data_sep->cetakan;	
		if ($data_pasien->no_telp == '' && $data_pasien->no_hp != '') {
			$no_telp = $data_pasien->no_hp;
		} else if ($data_pasien->no_telp != '' && $data_pasien->no_hp == '') {
			$no_telp = $data_pasien->no_telp;
		} else {
			$no_telp = $data_pasien->no_hp;
		}							
		if ($data_sep->no_sep == '') {	     
			$error_view = '<!DOCTYPE html>
							<html>
							<head>
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<style>
							.notice {
							    padding: 15px;
							    background-color: #fafafa;
							    border-left: 6px solid #7f7f84;
							    margin-top: 25px;
							    margin-bottom: 10px;
							    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							}
							.notice-danger {
								font-family: Helvetica,Arial;
							    border-color: #d73814;
							}
							.notice-danger h3
							{
								margin-top: 0;
								margin-bottom: 15px;
							    color: #d9534f;
							    font-family: Helvetica,Arial;
							}
							</style>
							</head>
							<body>
								<div class="notice notice-danger">
									<h3>Tidak dapat mencetak SEP</h3>
	        						Nomor SEP tidak ditemukan pada pelayanan dengan No. Register '.$no_register.'.
	    						</div>
							</body>
							</html>';
			echo $error_view;
		} else {
			$result = $this->show($data_sep->no_sep);							
            if ($result == '') {
            	echo $this->connection_error;
			} else {
				$result_object = json_decode($result);		     	        				     	
				if ($result_object->metaData->code == '200') {	
					if ($result_object->response->peserta->asuransi == '' || $result_object->response->peserta->asuransi == null) {
						$cob = '-';
					} else $cob = $result_object->response->peserta->asuransi;	
					if ($result_object->response->peserta->kelamin == 'L') {
						$jns_kelamin = 'Laki-Laki';
					} else if ($result_object->response->peserta->kelamin == 'P') {
						$jns_kelamin = 'Perempuan';
					} else {
						$jns_kelamin = '';
					}					
	          	    $fields = array(
						'no_sep' => $result_object->response->noSep,
						'penjamin' => $result_object->response->penjamin,
						'cob' => $cob,
						'no_telp' => $no_telp,
						'tgl_sep' => $result_object->response->tglSep,
						'no_mr' => $data_pasien->no_cm,
						'no_register' => $no_register,
						'no_kartu' => $data_pasien->no_kartu,
						'peserta' => $result_object->response->peserta->jnsPeserta,
						'nm_peserta' => $result_object->response->peserta->nama,
						'tgl_lahir' => $result_object->response->peserta->tglLahir,
						'jns_kelamin' => $jns_kelamin,
						'asal_faskes' => $data_sep->nama_ppk,						
						'poli_tujuan' => $result_object->response->poli,
						'kls_rawat' => $result_object->response->kelasRawat,
						'jns_rawat' => $result_object->response->jnsPelayanan,
						'diag_awal' => $result_object->response->diagnosa,
						'catatan' => $result_object->response->catatan,
						'cetakan_ke' => $cetakan_ke + 1
					);				
	      			$this->Msep->update_cetakan($result_object->response->noSep);		        		
	        		$data_sep = json_encode($fields);
					$this->cetakan_sep($data_sep);							
				} else {
					echo $result;
				}
			}
		}
	}		

	public function cetak_perincian($no_register="") 
	{					
		$data_sep = $this->Msep->show($no_register);
		if ($data_sep == null) {     
			$error_view = '<!DOCTYPE html>
							<html>
							<head>
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<style>
							.notice {
							    padding: 15px;
							    background-color: #fafafa;
							    border-left: 6px solid #7f7f84;
							    margin-top: 25px;
							    margin-bottom: 10px;
							    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							}
							.notice-danger {
								font-family: Helvetica,Arial;
							    border-color: #d73814;
							}
							.notice-danger h3
							{
								margin-top: 0;
								margin-bottom: 15px;
							    color: #d9534f;
							    font-family: Helvetica,Arial;
							}
							</style>
							</head>
							<body>
								<div class="notice notice-danger">
									<h3>Tidak dapat mencetak SEP</h3>
	        						Data tidak ditemukan.
	    						</div>
							</body>
							</html>';
			echo $error_view;
			return true;
		}	
		$data_pasien = $this->Mpasien->show($data_sep->no_medrec);		
		$cetakan_ke = $data_sep->cetakan;	
		if ($data_pasien->no_telp == '' && $data_pasien->no_hp != '') {
			$no_telp = $data_pasien->no_hp;
		} else if ($data_pasien->no_telp != '' && $data_pasien->no_hp == '') {
			$no_telp = $data_pasien->no_telp;
		} else {
			$no_telp = $data_pasien->no_hp;
		}							
		if ($data_sep->no_sep == '') {	     
			$error_view = '<!DOCTYPE html>
							<html>
							<head>
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<style>
							.notice {
							    padding: 15px;
							    background-color: #fafafa;
							    border-left: 6px solid #7f7f84;
							    margin-top: 25px;
							    margin-bottom: 10px;
							    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							}
							.notice-danger {
								font-family: Helvetica,Arial;
							    border-color: #d73814;
							}
							.notice-danger h3
							{
								margin-top: 0;
								margin-bottom: 15px;
							    color: #d9534f;
							    font-family: Helvetica,Arial;
							}
							</style>
							</head>
							<body>
								<div class="notice notice-danger">
									<h3>Tidak dapat mencetak SEP</h3>
	        						Nomor SEP tidak ditemukan pada pelayanan dengan No. Register '.$no_register.'.
	    						</div>
							</body>
							</html>';
			echo $error_view;
		} else {
			$result = $this->show($data_sep->no_sep);							
            if ($result == '') {
            	echo $this->connection_error;
			} else {
				$result_object = json_decode($result);		     	        				     	
				if ($result_object->metaData->code == '200') {	
					if ($result_object->response->peserta->asuransi == '' || $result_object->response->peserta->asuransi == null) {
						$cob = '-';
					} else $cob = $result_object->response->peserta->asuransi;	
					if ($result_object->response->peserta->kelamin == 'L') {
						$jns_kelamin = 'Laki-Laki';
					} else if ($result_object->response->peserta->kelamin == 'P') {
						$jns_kelamin = 'Perempuan';
					} else {
						$jns_kelamin = '';
					}					
	          	    $fields = array(
						'no_sep' => $result_object->response->noSep,
						'penjamin' => $result_object->response->penjamin,
						'cob' => $cob,
						'no_telp' => $no_telp,
						'tgl_sep' => $result_object->response->tglSep,
						'no_mr' => $data_pasien->no_cm,
						'no_register' => $no_register,
						'no_kartu' => $data_pasien->no_kartu,
						'peserta' => $result_object->response->peserta->jnsPeserta,
						'nm_peserta' => $result_object->response->peserta->nama,
						'tgl_lahir' => $result_object->response->peserta->tglLahir,
						'jns_kelamin' => $jns_kelamin,
						'asal_faskes' => $data_sep->nama_ppk,						
						'poli_tujuan' => $result_object->response->poli,
						'kls_rawat' => $result_object->response->kelasRawat,
						'jns_rawat' => $result_object->response->jnsPelayanan,
						'diag_awal' => $result_object->response->diagnosa,
						'catatan' => $result_object->response->catatan,
						'cetakan_ke' => $cetakan_ke + 1
					);				
	      			$this->Msep->update_cetakan($result_object->response->noSep);		        		
	        		$data_sep = json_encode($fields);
					$this->cetakan_sep_perincian($data_sep);							
				} else {
					echo $result;
				}
			}
		}
	}	

	public function cetakan_sep($data_sep)
	{	
		$fields = json_decode($data_sep);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		$konten_sep = "<style type=\"text/css\">
				.signature-sep {
					font-size: 8px;
				}
				.content-sep {
					font-size: 8px;
					padding: 1px, 2px, 2px;
					font-weight: 600;
				}
				.note-sep {
					font-size: 7px;
					font-style: italic;
				}
				.header-sep {
					border-bottom: 1px solid #000; 
					font-size: 9px;
				}
				</style>
				<table class=\"content-sep\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid #000;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" class=\"header-sep\">
							<p align=\"center\">
								<br>
								<b>SURAT ELEGIBILITAS PESERTA</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid #000;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"45\" style=\"padding-right:5px;\">
						</td>
					</tr>
					<br>
					<tr>
						<td width=\"11%\" style=\"font-size: 10px;\">No. SEP</td>
						<td width=\"2%\">:</td>
						<td width=\"45%\" style=\"font-weight: bold; font-size:10px;\">$fields->no_sep</td>
						<td width=\"10%\"></td>
						<td width=\"2%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>:</td>
						<td>".date('d-m-Y', strtotime($fields->tgl_sep))."</td>
						<td>Peserta</td>
						<td>:</td>
						<td>$fields->peserta</td>
					</tr>		
					<tr>
						<td style=\"font-size: 8px;\">No. Kartu</td>
						<td>:</td>
						<td style=\"font-size: 8px;\">".$fields->no_kartu." ( MR : ".$fields->no_mr." )</td>
						<td>COB</td>
						<td>:</td>
						<td>$fields->cob</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>:</td>
						<td>".$fields->nm_peserta."</td>
						<td>Jenis Rawat</td>
						<td>:</td>
						<td>$fields->jns_rawat</td>
					</tr>		
					<tr>
						<td style=\"font-size: 8px;\">Tgl. Lahir</td>
						<td>:</td>
						<td style=\"font-size: 8px;\">".date('d-m-Y', strtotime($fields->tgl_lahir))." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Kelamin : ".$fields->jns_kelamin."</td>
						<td>Kelas Rawat</td>
						<td>:</td>
						<td>$fields->kls_rawat</td>
					</tr>
					<tr>
						<td>No. Telepon</td>
						<td>:</td>
						<td>$fields->no_telp</td>
						<td>Penjamin</td>
						<td>:</td>
						<td>$fields->penjamin</td>
					</tr>				
					<tr>
						<td>Poli Tujuan</td>
						<td>:</td>
						<td>$fields->poli_tujuan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Faskes Perujuk</td>
						<td>:</td>
						<td>$fields->asal_faskes</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td>:</td>
						<td colspan=\"3\">$fields->diag_awal</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>:</td>
						<td>$fields->catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"3\">
							<font class=\"note-sep\"><br>
								* Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
								* SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
						<td width=\"18%\" align=\"center\">Pasien / Keluarga Pasien</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\">Petugas RS</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields->cetakan_ke."</td>
						<td>:</td>
						<td>".$date->format('d-m-Y H:i:s')."</td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
					</tr>										
				</table>
			";	

		$file_name="SEP_".$fields->no_register.".pdf";
		tcpdf();
		$width = 216;
		$height = 356;
		$pageLayout = array($width, $height); 
		$obj_pdf = new TCPDF('P', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetMargins('5', '2', '5');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten_sep.$konten_perincian;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		if (substr($fields->no_register,0,2) == 'RJ') {
			$obj_pdf->Output(FCPATH.'download/bpjs/sep/irj/'.$file_name, 'FI');	
		}
		if (substr($fields->no_register,0,2) == 'RI') {
			$obj_pdf->Output(FCPATH.'download/bpjs/sep/iri/'.$file_name, 'FI');	
		}		
	}

	public function cetakan_sep_perincian($data_sep)
	{	
		$fields = json_decode($data_sep);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		$konten_sep = "<style type=\"text/css\">
				.signature-sep {
					font-size: 7px;
				}
				.content-sep {
					font-size: 7px;
					padding: 1px, 2px, 2px;
					font-weight: 600;
				}
				.note-sep {
					font-size: 6px;
					font-style: italic;
				}
				.header-sep {
					border-bottom: 1px solid #000; 
					font-size: 8px;
				}
				.perincian-header {
					font-size: 7px;
					text-align: center;
				}
				.perincian-content {
					font-size: 6px;
				}
				</style>
				<table class=\"content-sep\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid #000;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" class=\"header-sep\">
							<p align=\"center\">
								<br>
								<b>SURAT ELEGIBILITAS PESERTA</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid #000;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"35\" style=\"padding-right:5px;\">
						</td>
					</tr>
					<br>
					<tr>
						<td width=\"11%\" style=\"font-size: 9px;\">No. SEP</td>
						<td width=\"2%\" style=\"font-size: 9px;\">:</td>
						<td width=\"45%\" style=\"font-weight: bold; font-size:9px;\">$fields->no_sep</td>
						<td width=\"10%\"></td>
						<td width=\"2%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>:</td>
						<td>".date('d-m-Y', strtotime($fields->tgl_sep))."</td>
						<td>Peserta</td>
						<td>:</td>
						<td>$fields->peserta</td>
					</tr>		
					<tr>
						<td style=\"font-size: 8px;\">No. Kartu</td>
						<td>:</td>
						<td style=\"font-size: 8px;\">".$fields->no_kartu." ( MR : ".$fields->no_mr." )</td>
						<td>COB</td>
						<td>:</td>
						<td>$fields->cob</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>:</td>
						<td>".$fields->nm_peserta."</td>
						<td>Jenis Rawat</td>
						<td>:</td>
						<td>$fields->jns_rawat</td>
					</tr>		
					<tr>
						<td style=\"font-size: 7px;\">Tgl. Lahir</td>
						<td>:</td>
						<td style=\"font-size: 7px;\">".date('d-m-Y', strtotime($fields->tgl_lahir))." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Kelamin : ".$fields->jns_kelamin."</td>
						<td>Kelas Rawat</td>
						<td>:</td>
						<td>$fields->kls_rawat</td>
					</tr>
					<tr>
						<td>No. Telepon</td>
						<td>:</td>
						<td>$fields->no_telp</td>
						<td>Penjamin</td>
						<td>:</td>
						<td>$fields->penjamin</td>
					</tr>				
					<tr>
						<td>Poli Tujuan</td>
						<td>:</td>
						<td>$fields->poli_tujuan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Faskes Perujuk</td>
						<td>:</td>
						<td>$fields->asal_faskes</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td>:</td>
						<td colspan=\"3\">$fields->diag_awal</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>:</td>
						<td>$fields->catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"3\">
							<font class=\"note-sep\"><br>
								* Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
								* SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
						<td width=\"18%\" align=\"center\">Pasien / Keluarga Pasien</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\">Petugas RS</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields->cetakan_ke."</td>
						<td>:</td>
						<td>".$date->format('d-m-Y H:i:s')."</td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
					</tr>										
				</table>
				<br>
				<div style=\"border-top: 1px dashed #8c8b8b;width:100%\"></div>
				<table class=\"content-sep\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid #000;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" class=\"header-sep\">
							<p align=\"center\">
								<br>
								<b>SURAT ELEGIBILITAS PESERTA</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom: 1px solid #000;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"35\" style=\"padding-right:5px;\">
						</td>
					</tr>
					<br>
					<tr>
						<td width=\"11%\" style=\"font-size: 9px;\" >No. SEP</td>
						<td width=\"2%\" style=\"font-size: 9px;\">:</td>
						<td width=\"45%\" style=\"font-weight: bold; font-size: 9px;\">$fields->no_sep</td>
						<td width=\"10%\"></td>
						<td width=\"2%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>:</td>
						<td>".date('d-m-Y', strtotime($fields->tgl_sep))."</td>
						<td>Peserta</td>
						<td>:</td>
						<td>$fields->peserta</td>
					</tr>		
					<tr>
						<td style=\"font-size: 7px;\">No. Kartu</td>
						<td>:</td>
						<td style=\"font-size: 7px;\">".$fields->no_kartu." ( MR : ".$fields->no_mr." )</td>
						<td>COB</td>
						<td>:</td>
						<td>$fields->cob</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>:</td>
						<td>".$fields->nm_peserta."</td>
						<td>Jenis Rawat</td>
						<td>:</td>
						<td>$fields->jns_rawat</td>
					</tr>		
					<tr>
						<td style=\"font-size: 7px;\">Tgl. Lahir</td>
						<td>:</td>
						<td style=\"font-size: 7px;\">".date('d-m-Y', strtotime($fields->tgl_lahir))." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Kelamin : ".$fields->jns_kelamin."</td>
						<td>Kelas Rawat</td>
						<td>:</td>
						<td>$fields->kls_rawat</td>
					</tr>
					<tr>
						<td>No. Telepon</td>
						<td>:</td>
						<td>$fields->no_telp</td>
						<td>Penjamin</td>
						<td>:</td>
						<td>$fields->penjamin</td>
					</tr>				
					<tr>
						<td>Poli Tujuan</td>
						<td>:</td>
						<td>$fields->poli_tujuan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Faskes Perujuk</td>
						<td>:</td>
						<td>$fields->asal_faskes</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td>:</td>
						<td colspan=\"3\">$fields->diag_awal</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>:</td>
						<td>$fields->catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"3\">
							<font class=\"note-sep\"><br>
								* Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
								* SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
						<td width=\"18%\" align=\"center\">Pasien / Keluarga Pasien</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\">Petugas RS</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields->cetakan_ke."</td>
						<td>:</td>
						<td>".$date->format('d-m-Y H:i:s')."</td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
						<td width=\"3%\"></td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/>(_____________________)</td>
					</tr>										
				</table>
		";	

		$file_name="SEP_".$fields->no_register.".pdf";
		tcpdf();
		$width = 216;
		$height = 356;
		$pageLayout = array($width, $height); 
		$obj_pdf = new TCPDF('P', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetMargins('5', '2', '5');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten_sep.$konten_perincian;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		if (substr($fields->no_register,0,2) == 'RJ') {
			$obj_pdf->Output(FCPATH.'download/bpjs/sep/irj/'.$file_name, 'FI');	
		}
		if (substr($fields->no_register,0,2) == 'RI') {
			$obj_pdf->Output(FCPATH.'download/bpjs/sep/iri/'.$file_name, 'FI');	
		}					
	}

	public function pengajuan_sep($no_register) 
	{
		$keterangan = $this->input->post('keterangan');
		if (substr($no_register,0,2) == 'RJ') {
			$data_pelayanan = $this->Mpasien->pelayanan($no_register);
			$tgl_kunjungan = date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan));
			$jenis_pelayanan = '2';
		} else if (substr($no_register,0,2) == 'RI') {	
			$data_pelayanan = $this->Mpasien->pelayanan($no_register);
			$tgl_kunjungan = date('Y-m-d',strtotime($data_pelayanan->tgl_masuk));
			$jenis_pelayanan = '1';
		} else {
			$result = array(
        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result);
		}					
    		
		$request_pengajuan = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  $tgl_kunjungan,
		   			'jnsPelayanan' => $jenis_pelayanan,		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $this->xuser		   					   			
		   		)
		   	)
		);
		$data_pengajuan = json_encode($request_pengajuan);	
		
		$param_pengajuan = 'Sep/pengajuanSEP';
		$content_type_pengajuan = 'Application/x-www-form-urlencoded';
		$result_pengajuan = $this->vclaim->post($param_pengajuan,$content_type_pengajuan,$data_pengajuan);	

		$result_pengajuan_object = json_decode($result_pengajuan);
		if ($result_pengajuan_object->metaData->code == '200' || substr($result_pengajuan_object->metaData->message,0,38) == 'Peserta Dalam Proses Pengajuan Aproval') {   
			$request_approval = array(
			   	'request'=>array(
			   		't_sep'=>array(
			   			'noKartu' => $data_pelayanan->no_kartu,
			   			'tglSep' =>  $tgl_kunjungan,
			   			'jnsPelayanan' => $jenis_pelayanan,		   			
	                 	'keterangan' => $keterangan,                 	
	                 	'user' => $this->xuser		   					   			
			   		)
			   	)
			);
			
			$data_approval = json_encode($request_approval);
			$param_approval = 'Sep/aprovalSEP';
			$content_type_approval = 'Application/x-www-form-urlencoded';
			$result_approval = $this->vclaim->post($param_approval,$content_type_approval,$data_approval);
			$result_approval_object = json_decode($result_approval);
			if ($result_approval_object->metaData->code == '200') {   
				$data_update = array(
					'ket_pengajuan_sep' => $keterangan
				);				
				if (substr($no_register,0,2) == 'RJ') {
					$this->Mbpjs->update_sep_irj($no_register,$data_update);
				} 
				if (substr($no_register,0,2) == 'RI') {	
					$this->Mbpjs->update_sep_iri($no_register,$data_update);
				}
			}
			echo $result_approval;			
		} else {
			echo $result_pengajuan;
		}
	}	

	public function perincian_irj($no_register)
	{
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
				    }
					.table-font-size2{
						font-size:8px;
						padding : 1px, 2px, 2px;
				    }
				    .table-ttd{
						font-size:7px;
						padding : 1px, 2px, 2px;
				    }
					.font-italic{
						font-size:7px;
						font-style:italic;
				    }
				</style>
				";
			// $poli="Jalan";
			if($no_register!="Poli UGD"){
				$data_pelayanan=$this->Mbpjs->rincian_irj($no_register);
				// print_r($data_pelayanan);die();
					if($data_pelayanan->nmkontraktor!=''){
						if($data_pelayanan->cara_bayar=='BPJS'){
							$txtperusahaan= 'BPJS - ' . $data_pelayanan->nmkontraktor;
						}
						else $txtperusahaan=$data_pelayanan->cara_bayar." - ".$data_pelayanan->nmkontraktor;
					} else {
						if($data_pelayanan->cara_bayar=='BPJS'){
							$txtperusahaan = 'BPJS';
						}
						else $txtperusahaan= $data_pelayanan->cara_bayar;
					}
					if ($data_pelayanan->jenis_identitas == 'KTP') {
						$no_ktp = $data_pelayanan->no_identitas;
					} else {
						$no_ktp = '';
					}
					$konten=$konten.$konten."<style type=\"text/css\">
						.table-font-size{
							font-size:11px;
						    }  
						</style>
						<br>
						<br>
						<table style=\"text-align:center;\">
							<tr>
								<td width=\"40%\" style=\"font-size:9px;\">
									<table cellpadding=\"2\">
							            <tr>
							              <td>DINAS KESEHATAN ANGKATAN LAUT</td>
							            </tr>
							             <tr>
							              <td>RUMKITAL DR. MINTOHARDJO</td>
							            </tr>
							            <tr>
							              <td><hr></td>
							            </tr>
							    	</table>
							    </td>	
								<td width=\"37%\"></td>
								<td width=\"20%\" colspan=\"6\" border=\"0.5\">
									<table>
							            <tr>
							              <td style=\"font-size:7px;font-weight:bold;\">Nomor Antrian :</td>
							            </tr>
							             <tr>
							              <td style=\"font-size:20px;font-weight:bold;\">$data_pelayanan->no_antrian</td>
							            </tr>
							            <tr>
							              <td style=\"font-size:7px;font-weight:bold;\">$txtperusahaan</td>
							            </tr>
							        </table>
								</td>	

							</tr>
						</table>
						<br>
						<br>
						<table class=\"table-font-size\" style=\"text-align:center;\">
							<tr>
							<td style=\"font-weight:bold;\">PERINCIAN BIAYA PELAYANAN KESEHATAN RAWAT JALAN<br>PESERTA $data_pelayanan->cara_bayar RUMKITAL DR. MINTOHARDJO</td>
							</tr>
						</table>
						<br><br>
						<table class=\"table-font-size\" cellpadding=\"2\">
							<tr>
								<td width=\"24%\">NAMA PASIEN</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\" colspan=\"2\"><b>$data_pelayanan->nama</b></td>
							</tr>	
							<tr>
								<td width=\"24%\">TANGGAL LAHIR PASIEN</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">".date('d-m-Y', strtotime($data_pelayanan->tgl_lahir))."</td>
							</tr>
							<tr>
								<td width=\"24%\">ALAMAT</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">$data_pelayanan->alamat</td>
							</tr>
							<tr>
								<td width=\"24%\">NO. KTP / KITAS</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">$no_ktp</td>
							</tr>
							<tr>
								<td width=\"24%\">NO. SEP</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">$data_pelayanan->no_sep</td>
							</tr>
							<tr>
								<td width=\"24%\">NO. REKAM MEDIS</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">$data_pelayanan->no_cm</td>
							</tr>
							<tr>
								<td width=\"24%\">TANGGAL KUNJUNGAN</td>
								<td width=\"3%\">:</td>
								<td width=\"50%\">$data_pelayanan->tgl_kunjungan</td>
							</tr>
							<tr>								
								<td width=\"24%\">DIAGNOSA UTAMA</td>
								<td width=\"3%\">:</td>
								<td width=\"30%\" style=\"border-bottom:0.5px solid #000;padding-right:10px;\"></td>
								<td width=\"15%\"> KODE ICD X</td>
								<td width=\"3%\">:</td>
								<td style=\"border-bottom:0.5px solid #000;\"></td>
							</tr>
							<tr>								
								<td width=\"24%\">DIAGNOSA SEKUNDER</td>
								<td width=\"3%\">:</td>
								<td width=\"30%\" style=\"border-bottom:0.5px solid #000;\"></td>
								<td width=\"15%\"> KODE ICD X</td>
								<td width=\"3%\">:</td>
								<td style=\"border-bottom:0.5px solid #000;\"></td>
							</tr>
							<tr>								
								<td width=\"24%\"></td>
								<td width=\"3%\"></td>
								<td width=\"30%\" style=\"border-bottom:0.5px solid #000;\"></td>
								<td width=\"15%\"> KODE ICD X</td>
								<td width=\"3%\">:</td>
								<td style=\"border-bottom:0.5px solid #000;\"></td>
							</tr>
							<tr>								
								<td width=\"24%\">TINDAKAN</td>
								<td width=\"3%\">:</td>
								<td width=\"30%\" style=\"border-bottom:0.5px solid #000;\"></td>
								<td width=\"15%\"> KODE ICD 9 CM</td>
								<td width=\"3%\">:</td>
								<td style=\"border-bottom:0.5px solid #000;\"></td>
							</tr>";

							$konten=$konten."$konten1					
							<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
						</table><br>
						<br>
						<style type=\"text/css\">
							.table-diagnosis{
								font-size:11px;
							    }
							</style>
							<table class=\"table-diagnosis\" border=\"0.5\" cellpadding=\"2\">
								<tr>
									<th width=\"4%\" style=\"text-align: center;\">NO</th>
									<th width=\"30%\">BAGIAN</th>
									<th width=\"25%\">JUMLAH BIAYA</th>
									<th width=\"25%\">PARAF PETUGAS</th>
									<th width=\"16%\">KETERANGAN</th>
								</tr>
								<tr>
									<td style=\"text-align: center;\">1</td>
									<td>POLIKLINIK</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">2</td>
									<td>UGD</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">3</td>
									<td>ADMINISTRASI</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">4</td>
									<td>KONSUL</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">5</td>
									<td>LABORATORIUM</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">6</td>
									<td>RADIOLOGI</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">7</td>
									<td>FISIOTERAFI</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">8</td>
									<td>ENDOSCOPY</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">9</td>
									<td>USG</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">10</td>
									<td>EKG</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">11</td>
									<td>KUBT</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">12</td>
									<td>TINDAKAN OPERASI</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">13</td>
									<td>OBAT</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style=\"text-align: center;\">14</td>
									<td>TINDAKAN / DLL</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>JUMLAH</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
							<br><br>
							<table>
								<tr>
									<td width=\"60%\">
										<span style=\"font-size:10px;\">Catatan</span><br>
										<span style=\"font-size:9px;\">1. Berkas tidak dibawa pulang</span><br>
										<span style=\"font-size:9px;\">2. Berkas dikembalikan ke poliklinik atau apotek apabila ada resep obat</span>
									</td>
									<td width=\"40%\" style=\"font-size:10px;text-align: center;\">
										Jakarta,____________20____<br><br><br><br><br> _______________________
									</td>
								</tr>							    
							</table>";
				}

		$file_name="sep_".$fields->no_register.".pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$width = 216;
		$height = 356;
		$pageLayout = array($width, $height); 
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
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
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}	

	function updtglplg($no_register='') 
	{		
		$empty_pelayanan = array(
        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
        		'response' => ['peserta' => null]
      	);
		if (substr($no_register,0,2) == 'RJ') {
			$data_pelayanan = $this->Mpasien->pelayanan($no_register);
			if ($data_pelayanan == '' || is_null($data_pelayanan)) {							
				return json_encode($empty_pelayanan);
			} else $tgl_pulang = $data_pelayanan->tgl_kunjungan;
		} else if (substr($no_register,0,2) == 'RI') {
			$data_pelayanan = $this->Mpasien->pelayanan($no_register);	
			if ($data_pelayanan == '' || is_null($data_pelayanan)) {							
				return json_encode($empty_pelayanan);
			} else {
				if ($data_pelayanan->tgl_keluar == '' || is_null($data_pelayanan->tgl_keluar)) {
					$result_error = array(
		        		"metaData" => array("code" => "402","message" => "Tanggal Keluar Kosong."),
		        		"response" => "Tanggal Keluar Kosong. Pasien belum dipulangkan di sistem.<br/> <a href='".site_url('iri/rictindakan/index/'.$no_register)."' target='_blank'>Klik Disini</a> untuk memulangkan pasien."
			      	);
			      	return json_encode($result_error);
				} else $tgl_pulang = $data_pelayanan->tgl_keluar;
			}
		} else {
			return json_encode($empty_pelayanan);
		}										
    	
		$data = array(
			'request'=>array(
				't_sep'=>array(
			   		'noSep' => $data_pelayanan->no_sep,
			   		'tglPulang' => $tgl_pulang,
			   		'ppkPelayanan' => $this->bpjs_config->rsid	
			   	)
			)
		);
		
		$data_request = json_encode($data);		
		$param = 'Sep/updtglplg';
		$content_type = 'Application/x-www-form-urlencoded';
		$result = $this->vclaim->put($param,$content_type,$data_request);   
        if ($result == '' || $result == null) {
			return $this->connection_error;
		} else {	
			$check_result = json_decode($result);
			if ($check_result->metaData->code == '200') {				
           		$data_update['tglplg_sep'] = 1;
           		$data_update['user_tglplg'] = $this->xuser;
				$this->Msep->update($no_sep,$data_update);
			}	 	
			return $result;
		}
	}

	public function update_tglplg($no_register="") 
	{		
		$result = $this->updtglplg($no_register);
		if ($result) {      
			echo $result;  	
		} else {
			echo $this->connection_error;	
		} 								  
	}

	function rujukan_pcare($no_rujukan='') 
	{
		$param = 'Rujukan/'.$no_rujukan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			return $result;
		} else {			
			return $this->connection_error;
		}
	}

	function rujukan_rs($no_rujukan='') 
	{
		$param = 'Rujukan/RS/'.$no_rujukan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			return $result;
		} else {			
			return $this->connection_error;
		}
	}
}

?>
