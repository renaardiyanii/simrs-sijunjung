<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Klaim extends Secure_area {
	public $xuser;
	public function __construct() {
			parent::__construct();
			$this->load->model('inacbg/M_pasien','',TRUE);
			$this->load->model('inacbg/M_inacbg','',TRUE);
			$this->load->model('Mdiagnosa','',TRUE);   
      		$this->load->model('Mprocedure','',TRUE); 				
			$this->load->library('inacbg');  	 
			$this->xuser = $this->load->get_var("user_info"); 	
	}

    public function show_klaim(){
		$data_klaim=$this->M_inacbg->get_all_pelayanan();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_klaim as $klaim) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $klaim->no_register;            
            if ($klaim->tgl_kunjungan == NULL || $klaim->tgl_kunjungan == '0000-00-00') {
            	$row[] = '';
            } else $row[] = date_indo(date('Y-m-d',strtotime($klaim->tgl_kunjungan))); 
            if ($klaim->tgl_pulang == NULL || $klaim->tgl_pulang == '0000-00-00') {
            	$row[] = '';
            } else $row[] = date_indo(date('Y-m-d',strtotime($klaim->tgl_pulang)));           
            $row[] = $klaim->no_sep; 
            if (isset($klaim->jaminan)) {
            	$row[] = '<center>'.$klaim->jaminan.'<center>';  
            } else $row[] = '<center>-</center>'; 
            switch (substr($klaim->no_register, 0,2)) {
            	case 'RJ':
            		$row[] = '<center>RJ<center>';  
            		break;
            	case 'RI':
            		$row[] = '<center>RI<center>';  
            		break;
            	default:
            		$row[] = '<center>-<center>'; 
            		break;
            }
            if (isset($klaim->cbg_code)) {
            	$row[] = '<center>'.$klaim->cbg_code.'<center>';  
            } else $row[] = '<center>-</center>'; 
            if (isset($klaim->status_kirim)) {
            	if ($klaim->status_kirim == 1) {
            		$row[] = '<center>Terkirim<center>';  
            	} else $row[] = '<center>Belum Terkirim<center>';     	
            } else $row[] = '<center>-</center>';                                        	
            $data[] = $row;
        }
 
        $output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->M_inacbg->count_all_pelayanan(),
	        "recordsFiltered" => $this->M_inacbg->filtered_all_pelayanan(),
	        "data" => $data
        );
        echo json_encode($output);
	}
	
	public function get_claim_data($nomor_sep='')
    {
		$data = array(
			'metadata'=>array(
				'method' => 'get_claim_data'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep		 			   			
			)
		);
	 	$data_klaim = json_encode($data);
	 	$response = $this->inacbg->web_service($data_klaim);		
		echo $response;	    		           
    }	

    public function new_claim()
    {
    	$cob_cd = "#";
    	$no_register = $this->input->post('no_register');
    	$kode_tarif = $this->M_inacbg->config_inacbg()->row()->kode_tarif;
    	if (substr($no_register, 0,2) == 'RJ') {
    		$jenis_rawat = "2";
    		$kelas_rawat = "3";
    		$icu_indikator = "0";
    		$icu_los = "";
    		$ventilator_hour = "";

    		$upgrade_class_ind = "0";
	    	$upgrade_class_class = "";
	    	$upgrade_class_los = "";
	    	$add_payment_pct = "";
    	}

    	if (substr($no_register, 0,2) == 'RI') {
    		$jenis_rawat = "1";
    		$kelas_rawat = $this->input->post('kelas_rawat');
    		$upgrade_class_ind = $this->input->post('upgrade_class_ind');
    		$icu_indikator = $this->input->post('icu_indikator');
    		if ($upgrade_class_ind == '1') {
    			$upgrade_class_class = $this->input->post('upgrade_class_class');
		    	$upgrade_class_los = $this->input->post('upgrade_class_los');
		    	$add_payment_pct = $this->input->post('add_payment_pct');
	    	} else {
		    	$upgrade_class_ind = '0';
		    	$upgrade_class_class = '';
		    	$upgrade_class_los = '';
		    	$add_payment_pct = '';
	    	}
	    	if ($icu_indikator == '1') {
    			$icu_los = $this->input->post('icu_los');
	    		$ventilator_hour = $this->input->post('ventilator_hour');
	    	} else {
		    	$icu_indikator = "0";
	    		$icu_los = "";
	    		$ventilator_hour = "";
	    	}
    	}

    	$data_insert = array(
    		'no_register' => $this->input->post('no_register'),
    		'nomor_kartu' => $this->input->post('no_bpjs'),	
		 	'no_sep' => $this->input->post('no_sep'),		
		 	'nama_pasien' => $this->input->post('nama'),
		 	'tgl_lahir' => $this->input->post('tgl_lahir'),
			'tgl_masuk' => $this->input->post('tgl_masuk'),
			'tgl_pulang' => $this->input->post('tgl_pulang'),
			'jenis_rawat' => $jenis_rawat,
			'kelas_rawat' => $kelas_rawat,
			'adl_sub_acute' => $this->input->post('adl_sub_acute'),
			'adl_chronic' => $this->input->post('adl_chronic'),
			'icu_indikator' => $icu_indikator,
			'icu_los' => $icu_los, 
			'ventilator_hour' => $ventilator_hour, 
			'upgrade_class_ind' => $upgrade_class_ind,
			'upgrade_class_class' => $upgrade_class_class,
			'upgrade_class_los' => $upgrade_class_los,
			'add_payment_pct' => $add_payment_pct,
			'birth_weight' => $this->input->post('birth_weight'),
			'discharge_status' => $this->input->post('discharge_status'),
			'diagnosa' => $this->input->post('diagnosa'),
			'procedure' => $this->input->post('procedure'),
			'tarif_poli_eks' => '0', 
			'nama_dokter' => $this->input->post('nama_dokter'),	
			'kode_tarif' => $kode_tarif,
			'payor_id' => $this->input->post('payor_id'),		
			'payor_cd' => $this->input->post('payor_cd'),		
			'cob_cd' => $cob_cd,		
			'coder_nik' => $this->xuser->nik,
			'status_klaim' => 1	
	    );	

    	$data_update_tarif = array(               
	        'tarif_prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
	        'tarif_prosedur_bedah' => $this->input->post('prosedur_bedah'), 
	        'tarif_konsultasi' => $this->input->post('konsultasi'), 
	        'tarif_tenaga_ahli' => $this->input->post('tenaga_ahli'), 
	        'tarif_keperawatan' => $this->input->post('keperawatan'), 
	        'tarif_penunjang' => $this->input->post('penunjang'), 
	        'tarif_radiologi' => $this->input->post('radiologi'), 
	        'tarif_laboratorium' => $this->input->post('laboratorium'), 
	        'tarif_pelayanan_darah' => $this->input->post('pelayanan_darah'), 
	        'tarif_rehabilitasi' => $this->input->post('rehabilitasi'), 
	        'tarif_kamar' => $this->input->post('kamar'), 
	        'tarif_rawat_intensif' => $this->input->post('rawat_intensif'), 
	        'tarif_obat' => $this->input->post('obat'), 
	        'tarif_obat_kronis' => $this->input->post('obat_kronis'), 
	        'tarif_obat_kemoterapi' => $this->input->post('obat_kemoterapi'), 
	        'tarif_alkes' => $this->input->post('alkes'), 
	        'tarif_bmhp' => $this->input->post('bmhp'), 
	        'tarif_sewa_alat' => $this->input->post('sewa_alat')
		);
		$this->M_pasien->update_tarif_rs($this->input->post('no_register'),$data_update_tarif);
  		$new_claim_data = array(
			'metadata'=>array(
				'method' => 'new_claim'
			),		   			
			'data'=>array(
				'nomor_kartu' => $this->input->post('no_bpjs'),
				'nomor_sep' => $this->input->post('no_sep'),
				'nomor_rm' => $this->input->post('no_rm'),
				'nama_pasien' => $this->input->post('nama'),
				'tgl_lahir' => $this->input->post('tgl_lahir'),
				'gender' => $this->input->post('gender')
		    )
		);	

	 	$data_klaim = json_encode($new_claim_data);
	 	// print_r($data_klaim);die();
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);			

		if ($response_array->metadata->code == '200') { 
			$this->M_inacbg->insert_inacbg($data_insert);						     
		}
		echo $response;	
    }  	

    public function set_claim_data()
    {
    	$cob_cd = "#";
    	$check_klaim = $this->M_inacbg->check_klaim($this->input->post('no_sep'));
    	$no_register = $this->input->post('no_register');
    	$kode_tarif = $this->M_inacbg->config_inacbg()->row()->kode_tarif;

    	if (!count($check_klaim)) {
    		$data_insert = array(
        		'no_register' => $this->input->post('no_register'),
			 	'no_sep' => $this->input->post('no_sep'),		
			 	'coder_nik' => $this->xuser->nik,
			 	'status_klaim' => 1	
		    );			
			$this->M_inacbg->insert_inacbg($data_insert);
    	}

    	if (substr($no_register, 0,2) == 'RJ') {
    		$jenis_rawat = "2";
    		$kelas_rawat = "3";
    		$icu_indikator = "0";
    		$icu_los = "";
    		$ventilator_hour = "";

    		$upgrade_class_ind = "0";
	    	$upgrade_class_class = "";
	    	$upgrade_class_los = "";
	    	$add_payment_pct = "";
    	}

    	if (substr($no_register, 0,2) == 'RI') {
    		$jenis_rawat = "1";
    		$kelas_rawat = $this->input->post('kelas_rawat');
    		$upgrade_class_ind = $this->input->post('upgrade_class_ind');
    		$icu_indikator = $this->input->post('icu_indikator');
    		if ($upgrade_class_ind == '1') {
    			$upgrade_class_class = $this->input->post('upgrade_class_class');
		    	$upgrade_class_los = $this->input->post('upgrade_class_los');
		    	$add_payment_pct = $this->input->post('add_payment_pct');
	    	} else {
		    	$upgrade_class_ind = '0';
		    	$upgrade_class_class = '';
		    	$upgrade_class_los = '';
		    	$add_payment_pct = '';
	    	}
	    	if ($icu_indikator == '1') {
    			$icu_los = $this->input->post('icu_los');
	    		$ventilator_hour = $this->input->post('ventilator_hour');
	    	} else {
		    	$icu_indikator = "0";
	    		$icu_los = "";
	    		$ventilator_hour = "";
	    	}
    	}

		$set_claim_data = array(
			'metadata'=>array(
				'method' => 'set_claim_data',
				'nomor_sep' => $this->input->post('no_sep'),
			),		   			
			'data' => array(
				'nomor_sep' => $this->input->post('no_sep'),
				'nomor_kartu' => $this->input->post('no_bpjs'),
				'tgl_masuk' => $this->input->post('tgl_masuk'),
				'tgl_pulang' => $this->input->post('tgl_pulang'),
				'jenis_rawat' => $jenis_rawat,
				'kelas_rawat' => $kelas_rawat,
				'adl_sub_acute' => $this->input->post('adl_sub_acute'),
				'adl_chronic' => $this->input->post('adl_chronic'),
				'icu_indikator' => $icu_indikator,
				'icu_los' => $icu_los, 
				'ventilator_hour' => $ventilator_hour, 
				'upgrade_class_ind' => $upgrade_class_ind,
				'upgrade_class_class' => $upgrade_class_class,
				'upgrade_class_los' => $upgrade_class_los,
				'add_payment_pct' => $add_payment_pct,
				'birth_weight' => $this->input->post('birth_weight'),
				'discharge_status' => $this->input->post('discharge_status'),
				'diagnosa' => $this->input->post('diagnosa'),
				'procedure' => $this->input->post('procedure'),
				'tarif_rs' => array(
					'prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
					'prosedur_bedah' => $this->input->post('prosedur_bedah'), 
					'konsultasi' => $this->input->post('konsultasi'), 
					'tenaga_ahli' => $this->input->post('tenaga_ahli'), 
					'keperawatan' => $this->input->post('keperawatan'), 
					'penunjang' => $this->input->post('penunjang'), 
					'radiologi' => $this->input->post('radiologi'), 
					'laboratorium' => $this->input->post('laboratorium'), 
					'pelayanan_darah' => $this->input->post('pelayanan_darah'), 
					'rehabilitasi' => $this->input->post('rehabilitasi'), 
					'kamar' => $this->input->post('kamar'), 
					'rawat_intensif' => $this->input->post('rawat_intensif'), 
					'obat' => $this->input->post('obat'), 
					'alkes' => $this->input->post('alkes'), 
					'bmhp' => $this->input->post('bmhp'), 
					'sewa_alat' => $this->input->post('sewa_alat')
				),
				'tarif_poli_eks' => '0', // tidak ada poli eksekutif
				'nama_dokter' => $this->input->post('nama_dokter'),	
				'kode_tarif' => $kode_tarif,
				'payor_id' => $this->input->post('payor_id'),		
				'payor_cd' => $this->input->post('payor_cd'),		
				'cob_cd' => $cob_cd,		
				'coder_nik' => $this->xuser->nik,
			)
		);    	
		$data_setklaim = json_encode($set_claim_data);
		// print_r($data_setklaim);die();
		
		$response_setclaim = $this->inacbg->web_service($data_setklaim);
		$response_setclaim_array = json_decode($response_setclaim);			

		if ($response_setclaim_array->metadata->code == '200') { 
			$data_update_tarif = array(               
		        'tarif_prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
		        'tarif_prosedur_bedah' => $this->input->post('prosedur_bedah'), 
		        'tarif_konsultasi' => $this->input->post('konsultasi'), 
		        'tarif_tenaga_ahli' => $this->input->post('tenaga_ahli'), 
		        'tarif_keperawatan' => $this->input->post('keperawatan'), 
		        'tarif_penunjang' => $this->input->post('penunjang'), 
		        'tarif_radiologi' => $this->input->post('radiologi'), 
		        'tarif_laboratorium' => $this->input->post('laboratorium'), 
		        'tarif_pelayanan_darah' => $this->input->post('pelayanan_darah'), 
		        'tarif_rehabilitasi' => $this->input->post('rehabilitasi'), 
		        'tarif_kamar' => $this->input->post('kamar'), 
		        'tarif_rawat_intensif' => $this->input->post('rawat_intensif'), 
		        'tarif_obat' => $this->input->post('obat'), 
		        'tarif_obat_kronis' => $this->input->post('obat_kronis'), 
		        'tarif_obat_kemoterapi' => $this->input->post('obat_kemoterapi'), 
		        'tarif_alkes' => $this->input->post('alkes'), 
		        'tarif_bmhp' => $this->input->post('bmhp'), 
		        'tarif_sewa_alat' => $this->input->post('sewa_alat')
			);
			$data_update_setclaim = array(					 						
		 		'adl_sub_acute' => $this->input->post('adl_sub_acute'),
				'adl_chronic' => $this->input->post('adl_chronic'),
				'kelas_rawat' => $kelas_rawat,
				'icu_indikator' => $icu_indikator,
				'icu_los' => $icu_los, 
				'ventilator_hour' => $ventilator_hour, 
				'upgrade_class_ind' => $upgrade_class_ind,
				'upgrade_class_class' => $upgrade_class_class,
				'upgrade_class_los' => $upgrade_class_los,
				'add_payment_pct' => $add_payment_pct,
				'birth_weight' => $this->input->post('birth_weight'),
				'discharge_status' => $this->input->post('discharge_status'),
				'diagnosa' => $this->input->post('diagnosa'),
				'procedure' => $this->input->post('procedure'),
				'tarif_poli_eks' => '0', // tidak ada poli eksekutif		
				'payor_id' => $this->input->post('payor_id'),		
				'payor_cd' => $this->input->post('payor_cd'),		
				'cob_cd' => $cob_cd,		
				'coder_nik' => $this->xuser->nik,
				'status_klaim' => 2
			);
			$this->M_pasien->update_tarif_rs($this->input->post('no_register'),$data_update_tarif);
			$this->M_inacbg->update_klaim($data_update_setclaim,$this->input->post('no_sep'));	

			$response_grouper1 = $this->grouper_stage1($this->input->post('no_sep'));
			$response_grouper1_array = json_decode($response_grouper1);

			if ($response_grouper1_array->metadata->code && $response_grouper1_array->metadata->code == '200') {
				$data_update = array('status_klaim' => 2,'cbg_code' => $response_grouper1_array->response->cbg->code,'grouper_at' => date('Y-m-d H:i'));
				$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));
				if (isset($response_grouper1_array->response->cbg->tariff)) {
					$update_tarif = array('tarif_grouper1' => $response_grouper1_array->response->cbg->tariff);
					$this->M_inacbg->update_klaim($update_tarif,$this->input->post('no_sep')); 
				}
				
				if (isset($response_grouper1_array->special_cmg_option)) {
					foreach ($response_grouper1_array->special_cmg_option as $cmg_option) {
				   		$push_cmg[] = $cmg_option->code;
					}
					$special_cmg = implode('#', $push_cmg);		
					$response_grouper2 = $this->grouper_stage2($this->input->post('no_sep'),$special_cmg);
					$response_grouper2_array = json_decode($response_grouper2);
					if ($response_grouper2_array->metadata->code == '200') {
			            $data_update = array('tarif_grouper2' => $response_grouper2_array->response->cbg->tariff,'cbg_code' => $response_grouper2_array->response->cbg->code,'special_cmg' => $response_grouper2_array->response->cbg->special_cmg,'grouper_at' => date('Y-m-d H:i'));
						$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep')); 
					} else {
						echo $response_grouper2;  
					}								
				} else {
				    echo $response_grouper1;
				}  // isset cmg_option  

			} else {
				echo $response_grouper1; 			
			} 	
		} else {
			echo $response_setclaim;
		}
    } 

	public function delete_claim()
    {
		$data = array(
			'metadata'=>array(
			 	'method' => 'delete_claim'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('nomor_sep'),
			 	'coder_nik' => $this->xuser->nik
			)
		);
	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);		
		$response_array = json_decode($response);
		if ($response_array->metadata->code == '200') {
			$this->M_inacbg->delete_klaim($this->input->post('nomor_sep'));
		}

		echo $response;	  
		   		           
    }	    

    public function claim_print($no_sep='')
    {    	
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_print'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $no_sep		 			   			
			)
		);
	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
		 	$base64 = $response_array->data;
		 	$result = base64_decode($base64);
			$file_name = 'KLAIM_'.$nomor_sep.'.pdf';
			header('Content-Type: application/pdf');
			header('Content-disposition: inline; filename="' . $file_name . '"');
			header('Cache-Control: public, must-revalidate, max-age=0');
			header('Pragma: public');
			header('Expires: 0');	
			echo $result;
		} else {
			echo $response_array->metadata->message;
		}		    		           
    }

    public function kirim_online() {        
        $data['title'] = 'Kirim Klaim Online';
        $this->load->view('inacbg/kirim_online',$data);        
    }

    public function send_claim()
    {
    	$tanggal_cari = $this->input->post('tanggal_cari');
        $from_date = substr($tanggal_cari,0,10);
        $to_date = substr($tanggal_cari,13,23);          
		$data = array(
			'metadata'=>array(
			 	'method' => 'send_claim'
			),		   			
			'data'=>array(	
			 	'start_dt' => date('Y-m-d',strtotime($from_date)),
			 	'stop_dt' => date('Y-m-d',strtotime($to_date)),
			 	'jenis_rawat' => $this->input->post('jenis_rawat'),
           		'date_type' => $this->input->post('date_type') 			   			
			)
		);
	 	$data_klaim=json_encode($data);	 	
		$result = $this->inacbg->web_service($data_klaim);
		echo $result;
	}

	public function laporan() {        
        $data['title'] = 'Laporan';
        $this->load->view('ina-cbg/laporan',$data);        
    }

	public function send_claim_individual()
    {
    	$nomor_sep = $this->input->post('nomor_sep');	
		$data = array(
			'metadata'=>array(
			 	'method' => 'send_claim_individual'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep 			   			
			)
		);		

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$result = json_decode($response);
		if ($result->metadata->code == '200' && $result->response->data[0]->kemkes_dc_status == 'sent') {
			$check_klaim = $this->M_inacbg->check_klaim($this->input->post('no_sep'));
			$data_update = array('status_kirim' => '1');
			$data_insert = array('no_register' => '','no_sep' => '','status_kirim' => '1');
	    	if (count($check_klaim)) {
			$this->M_inacbg->update_klaim($data_update,$nomor_sep);
			} else {

			}
		}
		echo $response;
	}	

	public function claim_final() {
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_final'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('no_sep'),
			 	'coder_nik' => $this->xuser->nik		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
			$data_update = array('status_klaim' => 3);
			$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));
		} 
	    echo $response;
    } 		

	public function pull_claim()
    {
		$data = array(
			'metadata'=>array(
			 	'method' => 'pull_claim'
			),		   			
			'data'=>array(	
			 	'start_dt' => $this->input->post('start_dt'),
			 	'stop_dt' => $this->input->post('stop_dt'),
			 	'jenis_rawat' => $this->input->post('jenis_rawat')		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
		 	
		}
	}	

	public function grouper_stage1($no_sep) {   
		$grouper_data = array(
			'metadata'=>array(
				'method' => 'grouper',
				'stage' => '1'
			),		   			
			'data'=>array(	
				'nomor_sep' => $no_sep			 			   			
			)
		);	
    	$data_klaim=json_encode($grouper_data);
		$response = $this->inacbg->web_service($data_klaim);
		return $response;		   			
    }  

	public function grouper_stage2($nomor_sep='',$cmg_option='') {    	
		$data = array(
			'metadata'=>array(
				'method' => 'grouper',
			 	'stage' => '2'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'special_cmg' => $cmg_option			 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		curl_close($ch);

		return $response; 		
    }  

	public function reedit_claim() {
		$data = array(
			'metadata'=>array(
			 	'method' => 'reedit_claim'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('no_sep')
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
			$data_update = array('status_klaim' => 2,'status_kirim' => 0);	
			$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));		
		}
		echo $response; 
    }      
	
	public function finalisasi($nomor_sep) {
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_final'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'coder_nik' => $this->xuser->nik		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
			$data_update = array('status_klaim' => 3);
			$this->M_inacbg->update_klaim($data_update,$nomor_sep);
		} 
	    echo $response;
    }   	

	public function get_diagnosa($no_register='') {
        $select_diag = $this->Mdiagnosa->pelayanan($no_register);          
        $diagnosa_utama = '';
        $diagnosa_tambahan = array();      
        foreach ($select_diag as $diagnosa) {
        	if ($diagnosa->klasifikasi_diagnos == 'utama') {
        		$diagnosa_utama = $diagnosa->id_diagnosa;
        	}
			if ($diagnosa->klasifikasi_diagnos == 'tambahan') {
        		$diagnosa_tambahan[] = $diagnosa->id_diagnosa;
        	}
        }     

		$result = array(
			 	'diagnosa_utama' => $diagnosa_utama,
			 	'diagnosa_tambahan' => $diagnosa_tambahan
		);         
        echo json_encode($result);        
    }  

	public function get_procedure($no_register = '') {
        $result = $this->Mprocedure->pelayanan($no_register);         
        // $procedure_utama = '';
        // $procedure_tambahan = array();     
   //      foreach ($select_procedure as $procedure) {
   //      	if ($procedure->klasifikasi_procedure == 'utama') {
   //      		$procedure_utama = $procedure->id_procedure;
   //      	}
			// if ($procedure->klasifikasi_procedure == 'tambahan') {
   //      		$procedure_tambahan[] = $procedure->id_procedure;
   //      	}
   //      }       

		// $result = array(
		// 	'procedure_utama' => $procedure_utama,
		// 	'procedure_tambahan' => $procedure_tambahan
		// );         
        echo json_encode($result);        
    }    	

    public function lap_inacbg()
	{
		$data['tgl_awal'] = date('Y-m-d');
		$data['tgl_akhir'] = date('Y-m-d');

		if ($this->input->post()) {
			$tanggal = $this->input->post('tgl');
			$tgl = explode("-", $tanggal);

			$data['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
			$data['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		}

		$data['inacbgs'] = $this->M_inacbg->get_incbg_klaim($data['tgl_awal'], $data['tgl_akhir'])->result();

		$this->load->view('inacbg/laporan', $data);
	}	 

	public function lap_inacbg_excel($tgl_awal, $tgl_akhir)
    {
    	////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $namars=$this->config->item('namars');
        $objPHPExcel->getProperties()->setCreator($namars);

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $penerimaan_obat=$this->M_inacbg->get_incbg_klaim($tgl_awal, $tgl_akhir)->result();
        //$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pembelian_obat.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUMAH SAKIT SRIWIJAYA");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A3', "LAPORAN INACBG");
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        // Add some data

        $objPHPExcel->getActiveSheet()->SetCellValue('A6', "No Register");
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', "Nama");
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', "No SEP");
        $objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', "No Kartu");
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', "Jenis Rawat");
        $objPHPExcel->getActiveSheet()->getStyle('E6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', "Kelas");
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('G6', "Prosedur");
        $objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('H6', "Diagnosa");
        $objPHPExcel->getActiveSheet()->getStyle('H6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('I6', "Dokter");
        $objPHPExcel->getActiveSheet()->getStyle('I6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('J6', "Tarif Grouper 1");
        $objPHPExcel->getActiveSheet()->getStyle('J6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('K6', "Tarif Grouper 2");
        $objPHPExcel->getActiveSheet()->getStyle('K6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $rowCount = 7;
        $i=1;
        $tqty = 0; $tsubtotal = 0;
        foreach($penerimaan_obat as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->no_register);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_pasien);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_sep);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nomor_kartu);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->jenis_rawat);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas_rawat);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->procedure);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->diagnosa);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->nama_dokter);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->tarif_grouper1);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->tarif_grouper2);
            $tqty += $row->qty;
            $tsubtotal += $row->subtotal;

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Penerimaan_Obat_".date('d F Y', strtotime($tgl_awal))."-".date('d F Y', strtotime($$tgl_akhir));

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS SRIWIJAYA');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();
        ob_start();
        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }    
}
?>
