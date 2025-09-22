<?php
	function bpjs_config() {		
		$CI =& get_instance();    		
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$result = $CI->Mbpjs->get_data_bpjs();
		return $result;	
	}

	function kartu_bpjs($no_bpjs='') {
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;									
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
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
		$tgl_pelayanan = date('Y-m-d');
		$ch = curl_init($url.'Peserta/nokartu/'.$no_bpjs.'/'.'tglSEP/'.$tgl_pelayanan);		
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		$peserta = json_decode($result);
		if ($peserta) {
			return $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
        		'response' => ['peserta' => null]
      		);
			return json_encode($result_error);
		}
	}

	function nik($no_nik='') {
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;		
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
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
		$tgl_pelayanan = date('Y-m-d');
		$ch = curl_init($url.'Peserta/nik/'.$no_nik.'/'.'tglSEP/'.$tgl_pelayanan);	
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		$peserta = json_decode($result);
		if ($peserta) {
			return $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => ['peserta' => null]
      		);
			return json_encode($result_error);
		}
	}

	function cari_sep($no_sep='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();				
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;		
		date_default_timezone_set('Asia/Jakarta');							
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			'Accept: application/json', 
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: ' . $cons_id, 
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
		$tgl_pelayanan = date('Y-m-d');
		$ch = curl_init($url.'SEP/'.$no_sep);	
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		$peserta = json_decode($result);
		if ($peserta) {
			return $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => ['peserta' => null]
      		);
			return json_encode($result_error);
		}
	}

	function insert_irj($no_register='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
		$ppk_pelayanan = $bpjs_config->rsid;
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);				
		$data_peserta = kartu_bpjs($data_pelayanan->no_kartu); 	
		$cek_peserta = json_decode($data_peserta);	

    	if($data_peserta == '') {			
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => ['peserta' => null]
	      	);
			return $result_error;
		} else {			
			if ($cek_peserta->metaData->code != '200') {
				return $data_peserta;     		
		 	}			
		}		
       	       	     	
       	$login_data = $CI->load->get_var("user_info");
		$xuser = $login_data->username;       	       	
       	if ($data_pelayanan->id_poli == 'BA00' && $data_pelayanan->alasan_berobat == 'kecelakaan') {
       		$laka_lantas = '1';
       		$lokasi_laka = $data_pelayanan->lokasi_kecelakaan;
       	}
       	else {
       		$laka_lantas = '0';
       		$lokasi_laka = '';
       	}

		if($cek_peserta->response->peserta->provUmum->kdProvider==NULL or $cek_peserta->response->peserta->provUmum->kdProvider==''){
			$ppkrujuk=$ppk_pelayanan;
		} else $ppkrujuk = $cek_peserta->response->peserta->provUmum->kdProvider;

		if($data_pelayanan->no_rujukan == NULL or $data_pelayanan->no_rujukan == ''){
			$norujuk='0';
		} else $norujuk = $data_pelayanan->no_rujukan;
		date_default_timezone_set('Asia/Jakarta');
		$tgl_sep = date('Y-m-d');
		if ($data_pelayanan->no_telp == '' && $data_pelayanan->no_hp != '') {
			$no_telp = $data_pelayanan->no_hp;
		} else if ($data_pelayanan->no_telp != '' && $data_pelayanan->no_hp == '') {
			$no_telp = $data_pelayanan->no_telp;
		} else {
			$no_telp = $data_pelayanan->no_telp;
		}		
		$cob = '0';
		if($cek_peserta->response->peserta->cob->nmAsuransi != null){
			$cob = '1';
		}
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'klsRawat' => '3',
                 	'noMR' => $data_pelayanan->no_cm,
                 	'rujukan' => array(
                 		'asalRujukan' => '1',
                 		'tglRujukan' => date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),
                 		'noRujukan' => $norujuk,
                 		'ppkRujukan' => $ppkrujuk
                 	),
                 	'catatan' => $data_pelayanan->catatan,
                 	'diagAwal' => $data_pelayanan->diagnosa,
                 	'poli' => array(
                 		'tujuan' => $data_pelayanan->poli_bpjs,
                 		'eksekutif' => '0'
                 	),
                 	'cob' => array(
                 		'cob' => $cob
                 	),
                 	'jaminan' => array(
                 		'lakaLantas' => $laka_lantas,
                 		'penjamin' => '0', // ?
                 		'lokasiLaka' => $lokasi_laka
                 	),
                 	'noTelp' => $no_telp,
                 	'user' => $xuser		   					   			
		   		)
		   	)
		);
		// print_r($data);die(); 
		$datasep = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $cons_id,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($url . 'SEP/insert');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '') {
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => null
	      	);
			return $result_error;
		} else {		 	
			$sep = json_decode($result);
			if ($sep->metaData->code == '200') {				
          		$data_update = array(
           			'no_sep' => $sep->response->sep->noSep
              	);
           		$CI->Mbpjs->update_sep_irj($no_register,$data_update);
			}
			return $sep;
		}
	}

	function insert_iri($no_ipd='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
		$ppk_pelayanan = $bpjs_config->rsid;
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);				
		$data_peserta = kartu_bpjs($data_pelayanan->no_kartu); 	
		$cek_peserta = json_decode($data_peserta);	

    	if($data_peserta == '') {			
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => ['peserta' => null]
	      	);
			return $result_error;
		} else {			
			if ($cek_peserta->metaData->code != '200') {
				return $data_peserta;     		
		 	}			
		}		
       	       	     	
       	$login_data = $CI->load->get_var("user_info");
		$xuser = $login_data->username;       	       	
       	// if ($data_pelayanan->id_poli == 'BA00' && $data_pelayanan->alasan_berobat == 'kecelakaan') {
       	// 	$laka_lantas = '1';
       	// 	$lokasi_laka = $data_pelayanan->lokasi_kecelakaan;
       	// }
       	// else {
       		$laka_lantas = '0';
       		$lokasi_laka = '';
       	// }

		if($cek_peserta->response->peserta->provUmum->kdProvider==NULL or $cek_peserta->response->peserta->provUmum->kdProvider==''){
			$ppkrujuk=$ppk_pelayanan;
		} else $ppkrujuk = $cek_peserta->response->peserta->provUmum->kdProvider;

		if($data_pelayanan->nosjp == NULL or $data_pelayanan->nosjp == ''){
			$norujuk='0';
		} else $norujuk = $data_pelayanan->nosjp;
		date_default_timezone_set('Asia/Jakarta');
		$tgl_sep = date('Y-m-d');
		if ($data_pelayanan->no_telp == '' && $data_pelayanan->no_hp != '') {
			$no_telp = $data_pelayanan->no_hp;
		} else if ($data_pelayanan->no_telp != '' && $data_pelayanan->no_hp == '') {
			$no_telp = $data_pelayanan->no_telp;
		} else {
			$no_telp = $data_pelayanan->no_telp;
		}		
		$cob = '0';
		if($cek_peserta->response->peserta->cob->nmAsuransi != null){
			$cob = '1';
		}
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'klsRawat' => '3',
                 	'noMR' => $data_pelayanan->no_cm,
                 	'rujukan' => array(
                 		'asalRujukan' => '1',
                 		'tglRujukan' => date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),
                 		'noRujukan' => $norujuk,
                 		'ppkRujukan' => $ppkrujuk
                 	),
                 	'catatan' => $data_pelayanan->catatan,
                 	'diagAwal' => $data_pelayanan->diagmasuk,
                 	'poli' => array(
                 		'tujuan' => '',
                 		'eksekutif' => '0'
                 	),
                 	'cob' => array(
                 		'cob' => '0'
                 	),
                 	'jaminan' => array(
                 		'lakaLantas' => $laka_lantas,
                 		'penjamin' => '0', // ?
                 		'lokasiLaka' => $lokasi_laka
                 	),
                 	'noTelp' => $no_telp,
                 	'user' => $xuser		   					   			
		   		)
		   	)
		);
		// print_r($data);die(); 
		$datasep = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $cons_id,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($url . 'SEP/insert');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '') {
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => null
	      	);
			return $result_error;
		} else {		 	
			$sep = json_decode($result);
			if ($sep->metaData->code == '200') {				
          		$data_update = array(
           			'no_sep' => $sep->response->sep->noSep
              	);
           		$CI->Mbpjs->update_sep_iri($no_ipd,$data_update);
			}
			return $sep;
		}
	}

	function hapus_sep($no_sep,$jnsPelayanan) {		
		$CI =& get_instance();
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$ppk_pelayanan = $bpjs_config->rsid;
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;					
		if($no_sep==''){
			$result_error = array(
        		'metaData' => array('code' => '402','message' => 'SEP tidak boleh kosong.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);		
		}
		else {			
	        $timezone = date_default_timezone_get();
			date_default_timezone_set('Asia/Jakarta');
			$timestamp = time();  
			$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
			$encoded_signature = base64_encode($signature);
			$tgl_sep = date('Y-m-d');
			$http_header = array(
				   'Accept: application/json',
				   'Content-type: application/x-www-form-urlencoded',
				   'X-cons-id: ' . $cons_id,
				   'X-timestamp: ' . $timestamp,
				   'X-signature: ' . $encoded_signature
			);
			date_default_timezone_set($timezone);
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
			$login_data = $CI->load->get_var("user_info");
			$xuser = $login_data->username;
		  	$data = array(
		   		'request'=>array(
		   		't_sep'=>array(
		   			'noSep' => $no_sep,
		   			'user' => $xuser
		   			)
		   		)
		   	);
    	   	$datasep=json_encode($data);				
			$ch = curl_init($url . 'SEP/Delete');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);          
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            if ($result!='') { 
		    	$sep = json_decode($result);
				if ($sep->metaData->code == '200') {
					switch ($jnsPelayanan) {
					    case '1':
					        $CI->Mbpjs->hapussep_iri($no_sep);
					        break;
					    case '2':
					        $CI->Mbpjs->hapussep_irj($no_sep);
					        break;
					}				
				} else {

				}
				echo $result;	
		 	} else {
				$result_error = array(
        			'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        			'response' => ['peserta' => null]
      			);
				echo json_encode($result_error);					 			
		 	}
		}
	}

	function pengajuan_irj($no_register='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),		   			
		   			'jnsPelayanan' => '2',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/pengajuanSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	function approval_irj($no_register='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),		   			
		   			'jnsPelayanan' => '2',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/aprovalSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	//////////////////////////////////////// Rawat Inap ////////////////////////////////////////

	function pengajuan_iri($no_ipd='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),		   			
		   			'jnsPelayanan' => '1',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/pengajuanSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	function approval_iri($no_ipd='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),		   			
		   			'jnsPelayanan' => '1',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/aprovalSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}


?>