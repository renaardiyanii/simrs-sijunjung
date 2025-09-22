<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Referensi extends Secure_area {

	public function __construct(){
	    parent::__construct();
		$this->load->library('vclaim');	      
	}

	function diagnosa() {				
		$keyword = rawurlencode($this->input->post('keyword')); 
		if (isset($keyword)) {
          	$q = strtolower($keyword);       	                     						
			$param = 'referensi/diagnosa/'.$keyword;	
			$content_type = 'application/json';
			$response = $this->vclaim->get($param,$content_type);		

            if ($response == '' || $response == null) { 
            	$result_error = array(
        			'metaData' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
        			'response' => null
      			);
				echo json_encode($result_error);	    		
		 	} else {	
		 		$check_result = json_decode($response);			 		
		 		$diagnosa = json_encode($check_result->response->diagnosa);
		 		$result_object = json_decode($diagnosa, true);
		 		if ($check_result->metaData->code == '200') {
		 			foreach ($result_object as $row) {
						$new_row['label']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
						$new_row['value']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
						$new_row['kode']=htmlentities(stripslashes($row['kode']));
						$new_row['nama']=htmlentities(stripslashes($row['nama']));	            
						$row_set[] = $new_row;
					}
					echo json_encode($row_set);			 			
		 		} else echo json_encode([]);														 			
		 	}			
        }
	}

	function diagnosa_select2() {	
		if (isset($_GET['q'])) {
			$keyword = rawurlencode($_GET['q']); 			
			$param = 'referensi/diagnosa/'.$keyword;	
			$content_type = 'application/json';
			$response = $this->vclaim->get($param,$content_type);
			if ($response == '' || $response == null) { 
            	$result_error = array(
        			'metaData' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
        			'response' => null
      			);
				echo json_encode($result_error);		    		
		 	} else {			
		 		$check_result = json_decode($response);			 				 		
		 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
		 			$diagnosa = json_encode($check_result->response->diagnosa);
		 			$result_object = json_decode($diagnosa, true);
		 			foreach ($result_object as $row) {
						$new_row['id']=htmlentities(stripslashes($row['nama']));
						$new_row['text']=htmlentities(stripslashes($row['nama']));	
						$new_row['kode']=htmlentities(stripslashes($row['kode']));						
						$row_set[] = $new_row;
					}
					echo json_encode($row_set);			 			
		 		} else echo json_encode([]);
		 	}														 						 	
        } else echo json_encode([]);	
	}

	function procedure() {				
		$keyword = rawurlencode($this->input->post('keyword')); 
		if (isset($keyword)) {
          	$q = strtolower($keyword);       	                     						
			$param = 'referensi/procedure/'.$keyword;	
			$content_type = 'application/json';
			$response = $this->vclaim->get($param,$content_type);		

            if ($response == '' || $response == null) { 
            	$result_error = array(
        			'metaData' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
        			'response' => null
      			);
				echo json_encode($result_error);		    		
		 	} else {	
		 		$check_result = json_decode($response);			 		
		 		$procedure = json_encode($check_result->response->procedure);
		 		$result_object = json_decode($procedure, true);
		 		if ($check_result->metaData->code == '200') {
		 			foreach ($result_object as $row) {
						$new_row['label']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
						$new_row['value']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
						$new_row['kode']=htmlentities(stripslashes($row['kode']));
						$new_row['nama']=htmlentities(stripslashes($row['nama']));	            
						$row_set[] = $new_row;
					}
					echo json_encode($row_set);			 			
		 		} else echo json_encode([]);														 			
		 	}			
        }
	}

	function poli($poli) {									   	                      						
		$param = 'referensi/poli/'.$poli;	
		$content_type = 'application/json';
		$response = $this->vclaim->get($param,$content_type);		
 		echo $response;														 					 			
	}

	function poli_select2() {	
		if (isset($_GET['q'])) {
			$keyword = rawurlencode($_GET['q']); 			
			$param = 'referensi/poli/'.$keyword;	
			$content_type = 'application/json';
			$response = $this->vclaim->get($param,$content_type);		
	 		$check_result = json_decode($response);			 				 		
	 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
	 			$poli = json_encode($check_result->response->poli);
	 			$result_object = json_decode($poli, true);
	 			foreach ($result_object as $row) {
					$new_row['id']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
					$new_row['text']=htmlentities(stripslashes($row['nama']));	
					$new_row['kode']=htmlentities(stripslashes($row['kode']));						
					$row_set[] = $new_row;
				}
				echo json_encode($row_set);			 			
	 		} else echo json_encode([]);														 						 	
        } else echo json_encode([]);	
	}

	function faskes() {	
		if (isset($_GET['jenis_faskes']) && isset($_GET['keyword'])) {      	            
            if ($_GET['jenis_faskes'] == ''){
				$result_error = array(
	        		'metaData' => array('code' => '402','message' => 'Pilih Jenis Faskes terlebih dahulu.'),
	        		'response' => ['peserta' => null]
	      		);
				echo json_encode($result_error);		
			} else {		
				if ($_GET['jenis_faskes'] == 'RUJUKAN PUSKESMAS') {
					$jenis_faskes = 1; 
				} else if ($_GET['jenis_faskes'] == 'RUJUKAN RS') {
					$jenis_faskes = 2; 
				} else {
					$result_error = array(
		        		'metaData' => array('code' => '402','message' => 'Pilih Jenis Faskes terlebih dahulu.'),
		        		'response' => ['peserta' => null]
		      		);
					echo json_encode($result_error);
				}	
				$keyword = rawurlencode($_GET['keyword']); 			
				$param = 'referensi/faskes/'.$keyword.'/'.$jenis_faskes;	
				$content_type = 'application/json';
				$response = $this->vclaim->get($param,$content_type);		
		 		$check_result = json_decode($response);			 				 		
		 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
		 			$faskes = json_encode($check_result->response->faskes);
		 			$result_object = json_decode($faskes, true);
		 			foreach ($result_object as $row) {
						$new_row['label']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
						$new_row['value']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));	
						$new_row['kode']=htmlentities(stripslashes($row['kode']));						
						$row_set[] = $new_row;
					}
					echo json_encode($row_set);			 			
		 		} else echo json_encode([]);														 						 	
			}
        } else echo json_encode([]);	
	}

	function faskes_select2() {	
		if (isset($_GET['q']['term'])) {
			$keyword = rawurlencode($_GET['q']['term']); 	
			$asal_rujukan = $_GET['asal_rujukan'];
			$param = 'referensi/faskes/'.$keyword.'/'.$asal_rujukan;
			$content_type = 'application/json';
			$response = $this->vclaim->get($param,$content_type);		
	 		$check_result = json_decode($response);			 				 		
	 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
	 			$faskes = json_encode($check_result->response->faskes);
	 			$result_object = json_decode($faskes, true);
	 			foreach ($result_object as $row) {
					$new_row['id']=htmlentities(stripslashes($row['kode'].' - '.$row['nama']));
					$new_row['text']=htmlentities(stripslashes($row['nama']));	
					$new_row['kode']=htmlentities(stripslashes($row['kode']));						
					$row_set[] = $new_row;
				}
				echo json_encode($row_set);			 			
	 		} else echo json_encode([]);														 						 	
        } else echo json_encode([]);	
	}

	function provinsi_select2() {	
		$param = 'referensi/propinsi';
		$content_type = 'application/json';
		$response = $this->vclaim->get($param,$content_type);		
 		$check_result = json_decode($response);	
 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
 			$list = json_encode($check_result->response->list);
 			$result_object = json_decode($list, true);	
 			foreach ($result_object as $row) {
				$new_row['id']=htmlentities(stripslashes($row['kode']));
				$new_row['name']=htmlentities(stripslashes($row['nama']));							
				$row_set[] = $new_row;
			}
			echo json_encode($row_set);			 			
 		} else echo json_encode([]);
	}

	function kabupaten_select2($kd_provinsi) {	
		$param = 'referensi/kabupaten/propinsi/'.$kd_provinsi;
		$content_type = 'application/json';
		$response = $this->vclaim->get($param,$content_type);		
 		$check_result = json_decode($response);	
 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
 			$list = json_encode($check_result->response->list);
 			$result_object = json_decode($list, true);	
 			foreach ($result_object as $row) {
				$new_row['id']=htmlentities(stripslashes($row['kode']));
				$new_row['name']=htmlentities(stripslashes($row['nama']));							
				$row_set[] = $new_row;
			}
			echo json_encode($row_set);			 			
 		} else echo json_encode([]);
	}

	function kecamatan_select2($kd_kecamatan) {	
		$param = 'referensi/kecamatan/kabupaten/'.$kd_kecamatan;
		$content_type = 'application/json';
		$response = $this->vclaim->get($param,$content_type);		
 		$check_result = json_decode($response);	
 		if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
 			$list = json_encode($check_result->response->list);
 			$result_object = json_decode($list, true);	
 			foreach ($result_object as $row) {
				$new_row['id']=htmlentities(stripslashes($row['kode']));
				$new_row['name']=htmlentities(stripslashes($row['nama']));							
				$row_set[] = $new_row;
			}
			echo json_encode($row_set);			 			
 		} else echo json_encode([]);
	}

	function dokter_dpjp($jns_pelayanan='',$spesialis='') {			
      	$tgl_pelayanan = date('Y-m-d');    	                      						
		$param = 'referensi/dokter/pelayanan/'.$jns_pelayanan.'/tglPelayanan/'.$tgl_pelayanan.'/Spesialis/'.$spesialis;	
		$content_type = 'application/json';
		$response = $this->vclaim->get($param,$content_type);
 		echo $response;															 					 			
	}
}

?>
