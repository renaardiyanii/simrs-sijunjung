<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');


class Referensi extends Secure_area {

	public function __construct(){
	    parent::__construct();
		$this->load->library('inacbg');	      
	}

	function diagnosa() {	
		if (isset($_GET['q'])) {
			$keyword = rawurlencode($_GET['q']); 			
			$request = array(
				'metadata'=>array(
					'method' => 'search_diagnosis'
				),		   			
				'data'=>array(
					'keyword' => $keyword
			    )
			);	
		 	$data_request=json_encode($request);	
			$response = $this->inacbg->web_service($data_request);
			if ($response == '' || $response == null) { 
            	echo json_encode([]);	    		
		 	} else {			
		 		$check_result = json_decode($response);			 				 		
		 		if (isset($check_result->metadata->code) && $check_result->metadata->code == '200') {
		 			$diagnosa = json_encode($check_result->response->data);
		 			$result_object = json_decode($diagnosa);
		 			if ($result_object == "EMPTY") {
		 				echo json_encode([]);
		 			} else {
		 				foreach ($result_object as $row) {
							$new_row['id']=htmlentities(stripslashes($row[1]));
							$new_row['text']=htmlentities(stripslashes($row[1].' - '.$row[0]));	
							$new_row['nm_diagnosa']=htmlentities(stripslashes($row[0]));					
							$row_set[] = $new_row;
						}
						echo json_encode($row_set);	
		 			}		 			
		 		} else echo json_encode([]);
		 	}														 						 	
        } else echo json_encode([]);	
	}

	function procedure() {	
		if (isset($_GET['q'])) {
			$keyword = rawurlencode($_GET['q']); 			
			$request = array(
				'metadata'=>array(
					'method' => 'search_procedures'
				),		   			
				'data'=>array(
					'keyword' => $keyword
			    )
			);	

		 	$data_request=json_encode($request);	
			$response = $this->inacbg->web_service($data_request);
			if ($response == '' || $response == null) { 
            	$result_error = array(
        			'metadata' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
        			'response' => null
      			);
				echo json_encode($result_error);		    		
		 	} else {			
		 		$check_result = json_decode($response);			 				 		
		 		if (isset($check_result->metadata->code) && $check_result->metadata->code == '200') {
		 			$diagnosa = json_encode($check_result->response->data);
		 			$result_object = json_decode($diagnosa);
		 			if ($result_object == "EMPTY") {
		 				echo json_encode([]);
		 			} else {
		 				foreach ($result_object as $row) {
							$new_row['id']=htmlentities(stripslashes($row[1]));
							$new_row['text']=htmlentities(stripslashes($row[1].' - '.$row[0]));	
							$new_row['nm_procedure']=htmlentities(stripslashes($row[0]));					
							$row_set[] = $new_row;
						}
						echo json_encode($row_set);	
		 			}		 			
		 		} else echo json_encode([]);
		 	}														 						 	
        } else echo json_encode([]);	
	}
}

?>
