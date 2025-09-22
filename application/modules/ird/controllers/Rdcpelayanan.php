<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
//  include(dirname(dirname(__FILE__)).'/Tglindo.php');

include('Rdcterbilang.php');

class rdcpelayanan extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/rdmpencarian','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('ird/rdmpelayanan','',TRUE);
		$this->load->model('ird/rdmregistrasi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->model('ird/Rdmkwitansi','',TRUE);
		$this->load->model('ird/rdmtracer','',TRUE);
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('elektromedik/emmdaftar','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('master/mmgizi','',TRUE);
		$this->load->model('master/mmformigd','',TRUE);
		$this->load->model('gizi/Mgizi','',TRUE);
		$this->load->model('ird/M_update_sepbpjs','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->model('irj/rjmtracer','',TRUE);
		// $this->load->helper('bpjs');
		// $this->load->helper('pdf_helper');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmpencarian');
		$this->load->model('admin/appconfig','',TRUE);

	}
	public function index()
	{
		redirect('ird/rdcregistrasi');
	}
	
	public function list_poli()
	{	
		$data['title'] = 'List Poliklinik Perawat';
		$username = $this->M_user->get_info($this->session->userdata('userid'))->username;		
		$data['poliklinik']=$this->rdmpencarian->get_poli_non_igd($this->session->userdata('userid'))->result();
		$data['poli']=$this->rdmpencarian->get_poliklinik_non_igd()->result();
		
		$this->load->view('ird/rdvlistpoli',$data);
	}
	
	public function pasien_poli()//pencarian
	{	
		$id_poli=$this->input->post('poli');
		redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli);
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$cara_bayar=$this->input->post('cara_bayar');
		$biaya=array();
		$result=$this->rdmpelayanan->getdata_jenis_tindakan_new_by_id($id_tindakan)->row();
		// if($cara_bayar == 'KERJASAMA') {
		// 	if($result->tarif_iks == NULL) {
		// 		$biaya[0] = 0;
		// 	} else {
		// 		$biaya[0]=$result->tarif_iks;
		// 	}
		// } else if($cara_bayar == 'BPJS') {
		// 	if($result->tarif_bpjs == NULL) {
		// 		$biaya[0] = 0;
		// 	} else {
		// 		$biaya[0]=$result->tarif_bpjs;
		// 	}
		// } else {
		// 	$biaya[0]=$result->total_tarif;
		// }
		$biaya['tarif']=$result->tarif;
		$biaya['tmno']=$result->tmno;
		echo json_encode($biaya);
	}

	public function update_waktu_masuk()
	{
		$no_register=$this->input->post('no_register');
		$data_update = array(
		     		'waktu_masuk_poli' => date("Y-m-d H:i:s")
		);
		$result = $this->rdmpelayanan->update_waktu_masuk($no_register,$data_update);	
		echo json_encode($result);
	}
	
		////////////////////////////////////////////////////////////////////////////////////////////////////////////batal
	public function pelayanan_batal($id_poli='',$no_register='',$status='')
	{			
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		//	if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32' || $data['roleid']=='43'){		
			$status_sep=$this->rdmpelayanan->get_status_sep($no_register);
			if ($status_sep == '') {
				$notif = '<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Registrasi Tidak Ditemukan
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);	
				redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli);
			}else {
				if ($status_sep->cara_bayar == 'BPJS' ) {
					$id=$this->rdmpelayanan->batal_pelayanan_poli($no_register,$status);
					if ($status_sep->poli_ke == 1 && $status_sep->no_sep != NULL || $status_sep->no_sep != '') {
						hapus_sep($status_sep->no_sep,2);	
					}			
					$notif = '<div class="alert alert-success">
	                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
	                       		</div>';
					$this->session->set_flashdata('notification', $notif);	
					redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli);	
				} else {
				$id=$this->rdmpelayanan->batal_pelayanan_poli($no_register,$status);				
				$notif = '<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
                       		</div>';
				$this->session->set_flashdata('notification', $notif);	
				redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli);	
				}			
			} // else status sep			
	// //	} else {
	// 		$notif = '<div class="box box-default">
	// 							<div class="alert alert-danger alert-dismissable">
	// 								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	// 								<i class="icon fa fa-check"></i>
	// 								Anda tidak memiliki hak akses untuk pembatalan pasien
	// 							</div>
	// 						</div>';
	// 		$this->session->set_flashdata('notification', $notif);	
	// 		redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli);
	// //	}

	}	
		////////////////////////////////////////////////////////////////////////////////////////////////////////////pencarian list antrian pasien per poli by
	public function kunj_pasien_poli($id_poli='')//perpoli
	{
		$data['title'] = 'PERAWAT - List Pasien Poliklinik | '.date('d-m-Y');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$data['kontraktor'] = $this->rdmpelayanan->get_kontraktor()->result();
		$data['kontraktor_bpjs'] = $this->rdmpelayanan->get_kontraktor_bpjs()->result();
		if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32'){
			$data['access']=1;
		}else{
			$data['access']=0;
		}
		$data['pasien_daftar']=$this->rdmpencarian->get_pasien_daftar_today($id_poli)->result();
		$get_nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->result();
			foreach($get_nm_poli as $row){
				$data['nma_poli']=$row->nm_poli;
			}
		
		$data['id_poli']=$id_poli;
		if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		$data['triase'] = '';
		$this->load->view('ird/rdvpasienpoli',$data);
	}

	private function reverse_tgl($tgl){
		$tgl_lahir_mentah = explode('/',$tgl);
		$reverse_tgl_lahir = $tgl_lahir_mentah[2].'-'.$tgl_lahir_mentah[1].'-'.$tgl_lahir_mentah[0];
		return $reverse_tgl_lahir;
	}
	
	public function kunj_pasien_poli_by_date()
	{
		$date=$this->input->post('date');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$data['kontraktor'] = $this->rdmpelayanan->get_kontraktor()->result();
		$data['kontraktor_bpjs'] = $this->rdmpelayanan->get_kontraktor_bpjs()->result();
		$id_poli=$this->input->post('id_poli');//perpoli
	//	if ($data['roleid']=='48') {
	//		$data['pasien_daftar']=$this->rdmpencarian->get_pasien_urikes_by_date($id_poli,$date)->result();
	//	}else{
			$data['pasien_daftar']=$this->rdmpencarian->get_pasien_daftar_by_date($id_poli,$date)->result();
			
	//	}
		$get_nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->result();
			foreach($get_nm_poli as $row){
				$data['nma_poli']=$row->nm_poli;
			}
		$data['id_poli']=$id_poli;
		if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		$data['title'] = 'List Pasien Poliklinik | '.date('d-m-Y',strtotime($date));
		
		$this->load->view('ird/rdvpasienpoli',$data);
	}
	// public function obj_tanggal(){
	// 	 $tgl_indo = new Tglindo();
	// 	 return $tgl_indo;
	// }

	function tindakan_pasien($no_register=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
			//add 
			// $tindakan_rows = $this->rdmpelayanan->getdata_tindakan_pasien($no_register)->num_rows();	
			
			// foreach ($hasil as $key) {
			// 	$tindakan_value[] = $key->nmtindakan;
			// }

			// $tidak_ada_tindakan[] = array("Tidak Ada Tindakan");

			// $tampung_tindakan= array();
			// if ($tindakan_rows == 0) {
			// 	for ($i=0; $i < $tindakan_rows ; $i++) { 
			// 		$tampung_tindakan[] = '<br>'.$tidak_ada_tindakan[$i];
			// 	}
			// }else{
			// 	for ($i=0; $i < $tindakan_rows ; $i++) { 
			// 		$tampung_tindakan[] = '<br>'.'Nama Tindakan :'.$tindakan_value[$i].' ';
			// 	}
			// }
			// $gabung_tindakan = implode($tampung_tindakan);

			// $datafisik['tindakan'] = $gabung_tindakan;
			// $data_fisik=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
			// if ($data_fisik==FALSE) {
			// 	$datafisik['no_register'] = $no_register;
			// 	$this->rdmpelayanan->insert_data_fisik_live($datafisik);
			// 	//INSERT
			// } else {
			// 	$this->rdmpelayanan->update_data_fisik_live($no_register, $datafisik);
			// 	// UPDATE
			// }
			//end
		foreach ($hasil as $value) {
			$surat=$value->idtindakan;
			
			$row2['id_pelayanan_poli'] = $value->id_pelayanan_poli;
			$row2['nmtindakan'] = $value->nmtindakan;
			$row2['tmno'] = $value->tmno;
			$row2['nm_dokter'] = $value->nm_user;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan , 2 , ',' , '.' );
			$row2['qtyind'] = $value->qtyind;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan , 2 , ',' , '.' );
			$row2['biaya_alkes'] = number_format($value->biaya_alkes , 2 , ',' , '.' );
			$row2['vtot'] = number_format($value->vtot * $value->qtyind, 2 , ',' , '.' );
			if($value->ttd_dokter == ''){
				$row2['ttd'] = ' ';
			}else{
				$row2['ttd'] = '<img src="'.$value->ttd_dokter.'" alt="" width="50px" height="50px"/> ';
			}

			if ($surat=="BD0014") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('ird/rdcpelayanan/hapus_tindakan/'.$value->poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="BD0015") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_jiwa()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('ird/rdcpelayanan/hapus_tindakan/'.$value->poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="BD0016") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_jiwa()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('ird/rdcpelayanan/hapus_tindakan/'.$value->poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			}else {
				$row2['aksi'] = '<a href="'.site_url('ird/rdcpelayanan/hapus_tindakan/'.$value->poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} 
			 
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
    function autocomplete_diagnosa(){    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->rdmpelayanan->autocomplete_diagnosa($q);
        }
    }
    function autocomplete_procedure(){    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->rdmpelayanan->autocomplete_procedure($q);
        }
    }
    public function set_utama_diagnosa(){	
    	$id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
    	$no_register = $this->input->post('no_register');
    	$result = $this->rdmpelayanan->set_utama_diagnosa($id_diagnosa_pasien,$no_register);
    	echo json_encode($result);
    }
    public function set_utama_procedure(){	
    	$id = $this->input->post('id');
    	$no_register = $this->input->post('no_register');
    	$result = $this->rdmpelayanan->set_utama_procedure($id,$no_register);
    	echo json_encode($result);
    }
	public function diagnosa_pasien(){
		$data_diagnosa=$this->rdmpelayanan->get_diagnosa_pasien();
        $data = array();
        $no = $_POST['start'];
        $diagnosa_pasien = '';   
		$no_register = $this->input->post('no_register'); 

        
        foreach ($data_diagnosa as $diagnosa) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
            	if ($diagnosa->klasifikasi_diagnos == 'utama') {
            		$row[] = '<strong>'.$diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa.'</strong>';
            	} else $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa;        		
       		} else $row[] = '';
            
            if ($diagnosa->klasifikasi_diagnos == 'utama') {
            	$row[] = '<strong>'.$diagnosa->diagnosa_text.'</strong>';            
            	$row[] = '<center><strong>'.$diagnosa->klasifikasi_diagnos.'</strong></center>';
            	$row[] = '<button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {
            	$row[] = $diagnosa->diagnosa_text;            
            	$row[] = '<center>'.$diagnosa->klasifikasi_diagnos.'</center>';
            	$row[] = '<button type="button" onclick="set_utama_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';  
            }                        
            $data[] = $row;
        }
		$diagnosa_rows = count($data_diagnosa);

		foreach ($data_diagnosa as $key) {
		
			$nm_diagnosa[] = $key->diagnosa;
			$jns_diagnosa[] = $key->klasifikasi_diagnos;
	
		}

		$tampung_diagnosa= array();
            if ($diagnosa_rows == 0) {
                for ($i=0; $i < $diagnosa_rows ; $i++) { 
                    $tampung_diagnosa[] = $tampung_diagnosa[$i];
                }
            }else{
                for ($i=0; $i < $diagnosa_rows ; $i++) { 
                    $tampung_diagnosa[] = '-'.' '.$nm_diagnosa[$i].'('.$jns_diagnosa[$i].')'.'<br>';
                }
            }
            $gabung_diagnosa = implode($tampung_diagnosa);
            
            $cek_pasien_apa = substr($no_register,0,2);
            
            if($cek_pasien_apa == 'RI'){
                $cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
            }else{
                $cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
            }
            
           
			$soap['diagnosis_kerja_dokter'] = $gabung_diagnosa;
			$soap['assesment_dokter'] = $gabung_diagnosa;


			$id_soap = $cek_soap->row();
			if ($id_soap != null) {                
				$this->emmdaftar->update_data_soap($id_soap->id,$soap);
			}else{
				
			}
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rdmpelayanan->diagnosa_count_all(),
            "recordsFiltered" => $this->rdmpelayanan->diagnosa_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function diagnosa_pasien_view(){
		$data_diagnosa=$this->rdmpelayanan->get_diagnosa_pasien();
        $data = array();
        $no = $_POST['start'];
        $diagnosa_pasien = '';        
        
        foreach ($data_diagnosa as $diagnosa) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
        		if ($diagnosa->klasifikasi_diagnos == 'utama') {
            		$row[] = '<strong>'.$diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa.'</strong>';
            	} else $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa; 
       		} else $row[] = '';

            if ($diagnosa->klasifikasi_diagnos == 'utama') {
            	$row[] = '<strong>'.$diagnosa->diagnosa_text.'</strong>';            
            	$row[] = '<center><strong>'.$diagnosa->klasifikasi_diagnos.'</strong></center>';
            } else {
            	$row[] = $diagnosa->diagnosa_text;            
            	$row[] = '<center>'.$diagnosa->klasifikasi_diagnos.'</center>';
            }            
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rdmpelayanan->diagnosa_count_all(),
            "recordsFiltered" => $this->rdmpelayanan->diagnosa_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}	
	public function procedure_pasien(){
		$data_procedure=$this->rdmpelayanan->get_procedure_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_procedure as $procedure) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
            	if ($procedure->klasifikasi_procedure == 'utama') {
            		$row[] = '<strong>'.$procedure->id_procedure . ' - ' . $procedure->nm_procedure.'</strong>';
            	} else $row[] = $procedure->id_procedure . ' - ' . $procedure->nm_procedure;         		
       		} else $row[] = '';
            
            if ($procedure->klasifikasi_procedure == 'utama') {
            	$row[] = '<strong>'.$procedure->procedure_text.'</strong>';            
            	$row[] = '<center><strong>'.$procedure->klasifikasi_procedure.'</strong></center>';
            	$row[] = '<button type="button" onclick="delete_procedure(\''.$procedure->id.'\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {
            	$row[] = $procedure->procedure_text;
            	$row[] = '<center>'.$procedure->klasifikasi_procedure.'</center>';
            	$row[] = '<button type="button" onclick="set_utama_procedure(\''.$procedure->id.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_procedure(\''.$procedure->id.'\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>'; 
            } 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rdmpelayanan->procedure_count_all(),
            "recordsFiltered" => $this->rdmpelayanan->procedure_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function procedure_pasien_view(){
		$data_procedure=$this->rdmpelayanan->get_procedure_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_procedure as $procedure) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
            	if ($procedure->klasifikasi_procedure == 'utama') {
            		$row[] = '<strong>'.$procedure->id_procedure . ' - ' . $procedure->nm_procedure.'</strong>';
            	} else $row[] = $procedure->id_procedure . ' - ' . $procedure->nm_procedure;         		
       		} else $row[] = '';
            
            if ($procedure->klasifikasi_procedure == 'utama') {
            	$row[] = '<strong>'.$procedure->procedure_text.'</strong>';            
            	$row[] = '<center><strong>'.$procedure->klasifikasi_procedure.'</strong></center>';            	
            } else {
            	$row[] = $procedure->procedure_text;
            	$row[] = '<center>'.$procedure->klasifikasi_procedure.'</center>';            	
            }           
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rdmpelayanan->procedure_count_all(),
            "recordsFiltered" => $this->rdmpelayanan->procedure_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function insert_diagnosa() {
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_diag');
		$cek_utama = $this->rdmpelayanan->count_utama_diagnosa($no_register);
		if ($cek_utama > 0) {
			$klasifikasi = 'tambahan';
		} else {
			$klasifikasi = 'utama';
		}		
		$diagnosa_text = $this->input->post('diagnosa_text');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$id_diagnosa = '';
		$diagnosa = '';
		
    	if ($this->input->post('id_diagnosa') != '') {    	
    		$postdiagnosa = explode("@", $this->input->post('diagnosa_separate'));
			$id_diagnosa = $postdiagnosa[0]; 
			$diagnosa = $postdiagnosa[1];      		
    	}

        $data_insert = array(
        	'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
        	'no_register' => $no_register,
        	'id_poli' => $this->input->post('id_poli'),
        	'id_diagnosa' => $id_diagnosa,
        	'diagnosa' => $diagnosa,
        	'diagnosa_text' => $diagnosa_text,
        	'klasifikasi_diagnos' => $klasifikasi,
        	'xuser' => $user
        );
        $result = $this->rdmpelayanan->insert_diagnosa($data_insert);		
		echo $result;
	}
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {	
	// 	$id=$this->rdmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function hapus_procedure($id_procedure_pasien)
	{	
		$delete=$this->rdmpelayanan->hapus_procedure($id_procedure_pasien);
		echo json_encode($delete);
	}
	public function hapus_diagnosa($id_diagnosa_pasien)
	{	
		$delete=$this->rdmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
		echo json_encode($delete);
	}
		
	public function insert_procedure()
	{	
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_procedure');
		$procedure_text = $this->input->post('procedure_text');
		$cek_utama = $this->rdmpelayanan->count_utama_procedure($no_register);
		if ($cek_utama > 0) {
			$klasifikasi = 'tambahan';
		} else {
			$klasifikasi = 'utama';
		}

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$id_procedure = '';
		$procedure = '';
		
    	if ($this->input->post('id_procedure') != '') {    	
    		$postprocedure = explode("@", $this->input->post('procedure_separate'));
			$id_procedure = $postprocedure[0]; 
			$nm_procedure = $postprocedure[1];      		
    	}

        $data_insert = array(
        	'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
        	'no_register' => $no_register,
        	'id_poli' => $this->input->post('id_poli'),
        	'id_procedure' => $id_procedure,
        	'nm_procedure' => $nm_procedure,
        	'procedure_text' => $procedure_text,
        	'klasifikasi_procedure' => $klasifikasi,
        	'xuser' => $user
        );
        $result = $this->rdmpelayanan->insert_procedure($data_insert);		
		echo $result;
	}	
	
	public function pelayanan_tindakan_copy($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{

		$data['pelayan']='PERAWAT';
		$datenow = date('Y-m-d');
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data; 
		// load data jika poli gigi (BG00)
		if($id_poli == 'BG00'){
			$data['gigi'] = $this->rdmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}

		//load data pemeriksaan_fisik poli ird (BA00)


		//load data assesment keperawatan ird 
		$data['assesment_keperawatan'] = '';
		$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
		($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';

		//---------------------------------------------------------------------------------------------
		$data['id_poli'] = $id_poli;
		$data['controller']=$this; 
		$data['view']=0; 
		$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['rujukan_penunjang_2']=$this->rdmpelayanan->get_rujukan_penunjang_pending($no_register)->row();
		if(empty($data['rujukan_penunjang_2'])){
			$array_penunjang = array('lab' => 0, 'rad' => 0, 'pa' => 0, 'ok' => 0, 'fisio' => 0, 'em' => 0);
			$data['rujukan_penunjang_2'] = (object) $array_penunjang;
		}
		
		$data['kerja']=$this->rdmpencarian->get_pekerjaan()->result();
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$data['a_em']="open";
		$result=$this->rdmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab=="0" || $result->status_lab=="1") {
			$data['a_lab'] = "closed";
		}
		if ($result->ok=="0" || $result->status_ok=="1") {
			$data['a_ok'] = "closed";
		}
		if ($result->pa=="0" || $result->status_pa=="1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat=="0" || $result->status_obat=="1") {
			$data['a_obat'] = "closed";
		} 
		if ($result->rad=="0" || $result->status_rad=="1") {
			$data['a_rad'] = "closed";
		}
		if ($result->fisio=="0" || $result->status_fisio=="1") {
			$data['a_fisio'] = "closed";
		}
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}
		//ambil data runjukan
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;

		$data['list_ok_pasien']=$this->rdmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();

		$data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();	
		$data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_register)->result();

		// $data['list_pa_pasien']=$this->rdmpelayanan->getdata_pa_pasien($no_register)->result();	
		// $data['cetak_pa_pasien']=$this->rdmpelayanan->getcetak_pa_pasien($no_register)->result();	

		$data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();	
		$data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_register)->result();

		$data['list_em_pasien']=$this->rdmpelayanan->getdata_em_pasienrj($no_register,$datenow)->result();	
		$data['cetak_em_pasien']=$this->rdmpelayanan->getcetak_em_pasien($no_register)->result();

		$data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();	
		$data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_register)->result();

		// $data['list_fisio_pasien']=$this->rdmpelayanan->getdata_fisio_pasien($no_register)->result();	
		// $data['cetak_fisio_pasien']=$this->rdmpelayanan->getcetak_fisio_pasien($no_register)->result();
		
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		//get id_poli & no_medrec	
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_pasien']=$this->rdmpelayanan->getdata_pasien($no_medrecrad)->row();
		// print_r($data['data_pasien_daftar_ulang']);die();	
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
			$data['bed']='Rawat Jalan';
		$data['idpokdiet']='';
		if($this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}
		
		$data['data_diagnosa_pasien']=$this->rdmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien']=$this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['id_poli']=$id_poli;
		$nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="'.site_url('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli).'">Kembali</a>';
		
		$data['poliklinik']=$this->rdmpencarian->get_poliklinik()->result();
		if($id_poli=='BA00'){
			$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result(); 		
		}
		else{
			$data['tindakans']=$this->rdmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get 
		}
		
		$data['perawat_tindakan'] = $this->rjmpelayanan->get_perawat()->result();
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli($id_poli)->result();
			$data['dokter_tindakan2']=$this->rdmpelayanan->get_dokter_poli2($id_poli)->result();
		$data['diagnosa']=$this->rdmpencarian->get_diagnosa()->result();
		
		//data untuk tab laboratorium------------------------------
		$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_lab']=$this->labmdaftar->getdata_dokter()->result();
		$data['tindakan_lab']=$this->labmdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab patalogi anatomi------------------------------
		$data['data_pemeriksaan']=$this->pamdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_pa']=$this->pamdaftar->getdata_dokter()->result();
		// $data['tindakan_pa']=$this->pamdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab radiologi---------------------------------------
		$data['dokter_rad']=$this->radmdaftar->getdata_dokter()->result();
		$data['tindakan_rad']=$this->radmdaftar->getdata_tindakan_pasien()->result();		
		$data['data_tindakan_racikan']='';
		$no_medrec=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_medrec)->result();

		//data untuk tab elektromedik---------------------------------------
		$data['dokter_em']=$this->emmdaftar->getdata_dokter()->result();
		$data['tindakan_em']=$this->emmdaftar->getdata_tindakan_pasien()->result();		
		$data['data_tindakan_racikan']='';
		$no_medrec=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_medrec)->result();
		
		//data untuk tab obat--------------------------------------------
		$result=$this->rdmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rdmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();

	
		$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		$data['data_keperawatan']=$this->rdmpelayanan->getdata_keperawatan($no_register)->result();

		if ($data['data_fisik'] == FALSE) {
			// ADDED KEADAAN UMUM , KESADARAN PASIEN
			$data['lokasi_nyeri'] = '';
			$data['keadaan_umum'] = '';
			$data['kesadaran_pasien'] = '';
			$data['lingkar_kepala'] = '';
			// END
			$data['alergi']='';
			$data['riwayat_alergi']='';
			$data['reaksi_alergi'] = '';
			// added
			$data['pengetahuan_edukasi'] = '';
			$data['riwayat_kesehatan'] = '';
			$data['nyeri'] = '';
			$data['skala_nyeri'] = '';
			$data['metode_nyeri'] = '';
			$data['kualitas_nyeri'] = '';
			$data['frekuensi_nyeri'] = '';
			$data['menjalar'] = '';
			$data['durasi_nyeri'] = '';
			$data['fk_minum_obat'] = '';
			$data['fk_istirahat'] = '';
			$data['fk_musik'] = '';
			$data['fk_posisi_tidur'] = '';
			$data['gizi_penurunan_bb'] = '';
			$data['gizi_asupan_makan'] = '';
			$data['penilaian_gizi'] = '';
			$data['stat_sosial_keluarga'] = '';
			$data['stat_psikologis'] = '';
			$data['stat_pernikahan_ekonomi'] = '';
			$data['pekerjaan'] = $data['data_pasien']->pekerjaan;
			$data['skrining_risiko_cedera'] = '';
			$data['fungsional_alat_bantu'] = '';
			$data['alat_bantu'] = '';
			$data['laporan_dokter_alatbantu']= '';
			$data['fungsional_cacat_tubuh']= '';
			$data['masalah_keperawatan[]'] = '';
			$data['kes_keluarga_pas_edukasi'] = '';
			$data['hambatan_edukasi'] = '';
			$data['membutuhkan_penerjemah_edukasi'] = '';
			$data['perawatan_penyakit'] = '';
			$data['cara_minum_obat'] = '';
			$data['diet'] = '';
			$data['alergi'] = '';
			$data['reaksi_alergi'] = '';
			$data['riwayat_alergi'] = '';
			

			
			
			
			
			
			// end
			
			$data['keluhan']='';

			// $data['td']='';
			$data['bb']='';
			// $data['tb']='';
			$data['sitolic'] = "";
			$data['diatolic'] = "";

			$data['nadi']='';	
			$data['rr']='';
			$data['suhu']='';

			$data['catatan']='';

			// $data['subjective'] = '';
			// $data['objective'] = '';
			// $data['assesment'] = '';
			// $data['plan'] = '';
			$data['diag_kerja'] = '';
			$data['diag_banding'] = '';
			$data['plan'] = '';
			$data['tindakan'] = '';
			$data['pem_penunjang'] = '';
			$data['frekuensi_nafas'] = '';

			$data['visus_od'] = '';
			$data['visus_os'] = '';
			$data['kacamata_od'] = '';
			$data['kacamata_os'] = '';

			$data['kedudukan_od'] = '';
			$data['kedudukan_os'] = '';
			$data['palpebra_od'] = '';
			$data['palpebra_os'] = '';
			$data['conjungtiva_od'] = '';
			$data['conjungtiva_os'] = '';
			$data['cornea_od'] = '';
			$data['cornea_os'] = '';
			$data['coa_od'] = '';
			$data['coa_os'] = '';
			$data['pupil_od'] = '';
			$data['pupil_os'] = '';
			$data['lensa_od'] = '';
			$data['lensa_os'] = '';
			$data['humor_od'] = '';
			$data['humor_os'] = '';
			$data['okuli_od'] = '';
			$data['okuli_os'] = '';
			$data['ku'] = '';
			





		} else {
			

			// ADDED KEADAAN UMUM , KESADARAN PASIEN

			$data['keadaan_umum'] = $data['data_fisik']->keadaan_umum;
			$data['kesadaran_pasien'] = $data['data_fisik']->kesadaran_pasien;
			$data['lingkar_kepala'] = $data['data_fisik']->lingkar_kepala;
			// END
			$data['alergi']=$data['data_fisik']->alergi;
			$data['riwayat_alergi']=$data['data_fisik']->riwayat_alergi;
			$data['reaksi_alergi'] = $data['data_fisik']->reaksi_alergi;
			$data['keluhan']=$data['data_fisik']->catatan;

			// $data['td']=$data['data_fisik']->td;
			$data['sitolic'] = $data['data_fisik']->sitolic;
			$data['diatolic'] = $data['data_fisik']->diatolic;
			$data['bb']=$data['data_fisik']->bb;
			// $data['tb']=$data['data_fisik']->tb;

			$data['alergi']=$data['data_fisik']->alergi;
			$data['reaksi_alergi']=$data['data_fisik']->reaksi_alergi;
			$data['riwayat_alergi'] = $data['data_fisik']->riwayat_alergi;;

			$data['nadi']=$data['data_fisik']->nadi;
			$data['frekuensi_nafas'] = $data['data_fisik']->frekuensi_nafas;
			// var_dump($data['frekuensi_nafas']);die();
			$data['rr']=$data['data_fisik']->rr;
			$data['suhu']=$data['data_fisik']->suhu;

			$data['catatan']=$data['data_fisik']->catatan;

			// $data['subjective'] = $data['data_fisik']->subjective;
			// $data['objective'] = $data['data_fisik']->objective;
			// $data['assesment'] = $data['data_fisik']->assesment;
			// $data['plan'] = $data['data_fisik']->plan;
			$data['tindakan'] = $data['data_fisik']->tindakan;
			$data['diag_kerja'] = $data['data_fisik']->diag_kerja;
			$data['diag_banding'] = $data['data_fisik']->diag_banding;
			$data['pem_penunjang'] = $data['data_fisik']->pem_penunjang;


			// ADDED
			$data['pengetahuan_edukasi'] = $data['data_fisik']->pengetahuan_edukasi;
			$data['lokasi_nyeri'] = $data['data_fisik']->lokasi_nyeri;
			$data['riwayat_kesehatan'] = $data['data_fisik']->riwayat_kesehatan;
			$data['nyeri'] = $data['data_fisik']->nyeri;
			$data['skala_nyeri'] = $data['data_fisik']->skala_nyeri;
			$data['metode_nyeri'] = $data['data_fisik']->metode_nyeri;
			$data['kualitas_nyeri'] = $data['data_fisik']->kualitas_nyeri;
			$data['frekuensi_nyeri'] = $data['data_fisik']->frekuensi_nyeri;
			$data['menjalar'] = $data['data_fisik']->menjalar;
			$data['durasi_nyeri'] = $data['data_fisik']->durasi_nyeri;
			$data['fk_minum_obat'] = $data['data_fisik']->fk_minum_obat;
			$data['fk_istirahat'] = $data['data_fisik']->fk_istirahat;
			$data['fk_musik'] = $data['data_fisik']->fk_musik;
			$data['fk_posisi_tidur'] = $data['data_fisik']->fk_posisi_tidur;
			$data['gizi_penurunan_bb'] = $data['data_fisik']->gizi_penurunan_bb;
			$data['gizi_asupan_makan'] = $data['data_fisik']->gizi_asupan_makan;
			$data['penilaian_gizi'] = $data['data_fisik']->penilaian_gizi;
			$data['stat_sosial_keluarga'] = $data['data_fisik']->stat_sosial_keluarga;
			$data['stat_psikologis'] = $data['data_fisik']->stat_psikologis;
			$data['stat_pernikahan_ekonomi'] = $data['data_fisik']->stat_pernikahan_ekonomi;
			// $data['pekerjaan'] = $data['data_fisik']->pekerjaan;
			$data['skrining_risiko_cedera'] = $data['data_fisik']->skrining_risiko_cedera;
			$data['fungsional_alat_bantu'] = $data['data_fisik']->fungsional_alat_bantu;
			$data['alat_bantu'] = $data['data_fisik']->alat_bantu;;
			$data['laporan_dokter_alatbantu']= $data['data_fisik']->laporan_dokter_alatbantu;
			$data['fungsional_cacat_tubuh']= $data['data_fisik']->fungsional_cacat_tubuh;
			// $data['masalah_keperawatan[]'] = $data['data_fisik']->nyeri;
			$data['kes_keluarga_pas_edukasi'] = $data['data_fisik']->kes_keluarga_pas_edukasi;
			$data['hambatan_edukasi'] = $data['data_fisik']->hambatan_edukasi;
			$data['membutuhkan_penerjemah_edukasi'] = $data['data_fisik']->membutuhkan_penerjemah_edukasi;
			$data['perawatan_penyakit'] = $data['data_fisik']->perawatan_penyakit;
			$data['cara_minum_obat'] = $data['data_fisik']->cara_minum_obat;
			$data['diet'] = $data['data_fisik']->diet;
			$data['kerjaan'] = $data['data_pasien']->pekerjaan;


			$data['visus_od'] = $data['data_fisik']->visus_od;
			$data['visus_os'] = $data['data_fisik']->visus_os;
			$data['kacamata_od'] = $data['data_fisik']->kacamata_od;
			$data['kacamata_os'] = $data['data_fisik']->kacamata_os;


			$data['kedudukan_od'] = $data['data_fisik']->kedudukan_od;
			$data['kedudukan_os'] = $data['data_fisik']->kedudukan_os;
			$data['palpebra_od'] = $data['data_fisik']->palpebra_od;
			$data['palpebra_os'] = $data['data_fisik']->palpebra_os;
			$data['conjungtiva_od'] = $data['data_fisik']->conjungtiva_od;
			$data['conjungtiva_os'] = $data['data_fisik']->conjungtiva_os;
			$data['cornea_od'] = $data['data_fisik']->cornea_od;
			$data['cornea_os'] = $data['data_fisik']->cornea_os;
			$data['coa_od'] = $data['data_fisik']->coa_od;
			$data['coa_os'] = $data['data_fisik']->coa_os;
			$data['pupil_od'] = $data['data_fisik']->pupil_od;
			$data['pupil_os'] = $data['data_fisik']->pupil_os;
			$data['lensa_od'] = $data['data_fisik']->lensa_od;
			$data['lensa_os'] = $data['data_fisik']->lensa_os;
			$data['humor_od'] = $data['data_fisik']->humor_od;
			$data['humor_os'] = $data['data_fisik']->humor_os;
			$data['okuli_od'] = $data['data_fisik']->okuli_od;
			$data['okuli_os'] = $data['data_fisik']->okuli_os;
			$data['ku'] = $data['data_fisik']->ku;
		}
		// var_dump($data['data_fisik']);
		
		$result=$this->rdmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rdmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rdmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rdmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rdmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rdmpelayanan->get_no_rad($no_register)->row()->no_rad);
		$result=$this->rdmpelayanan->get_no_em($no_register)->result();
		$data['no_em']= ($result==Array() ? '':$this->rdmpelayanan->get_no_em($no_register)->row()->no_em);

		
		switch ($tab){

			default:
                $data['tab_tindakan']="";
                $data['tab_fisik']="active";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="";
				$data['tab_prosedur'] = "";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";
				break;

			case 'gigi':
				$data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_prosedur'] = "";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "active";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;

			case 'cppt':
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_prosedur'] = "";
				$data['tab_resep']="";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "active";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;


			case 'assesment':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "active";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
				$data['tab_prosedur'] = "";

                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;

			case 'tindakan':
                $data['tab_tindakan']="active";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
				$data['tab_prosedur'] = "";
                $data['tab_pa']="";
                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;

			case 'TransferRuangan':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik']="";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_prosedur'] = "";
				$data['tab_pa']="";
				$data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_resep']="";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="active";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;

			case 'SerahTerima':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik']="";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_prosedur'] = "";
				$data['tab_pa']="";
				$data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_resep']="";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "active";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";

				break;

			case 'FormEws':
					$data['tab_tindakan']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_fisik']="";
					$data['tab_diagnosa']="";
					$data['tab_lab']="";
					$data['tab_prosedur'] = "";
					$data['tab_pa']="";
					$data['tab_rad']="";
					$data['tab_em']="";
					$data['tab_resep']="";
					$data['tab_obat'] = "";
					$data['tab_racikan']="";
					$data['tab_gigi'] = "";
					$data['tab_cppt'] = "";
					$data['tab_transfer_ruangan'] ="";
					$data['tab_serah_terima'] = "";
					$data['tab_fungsional_status'] = "";
					$data['tab_ews'] = "active";
	
					break;

			case 'FungsionalStatus':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik']="";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_prosedur'] = "";
				$data['tab_pa']="";
				$data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_resep']="";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "active";
				$data['tab_ews'] = "";

				break;

			case 'fis':
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
                $data['tab_fisik']="active";
                $data['tab_pa']="";
                $data['tab_lab']="";
				$data['tab_prosedur'] = "";
                $data['tab_resep']="";
				$data['tab_em']="";
                $data['tab_rad']="";
                $data['tab_obat']="";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";
				break;

			case 'diag':
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="active";
                $data['tab_fisik']="";
                $data['tab_pa']="";
                $data['tab_lab']="";
				$data['tab_prosedur'] = "";
                $data['tab_resep']="";
				$data['tab_em']="";
                $data['tab_rad']="";
                $data['tab_obat']="";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";
				break;

			case 'diag':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_fisik']="";
				$data['tab_pa']="";
				$data['tab_lab']="";
				$data['tab_prosedur'] = "active";
				$data['tab_resep']="";
				$data['tab_rad']="";
				$data['tab_em']="";
				$data['tab_obat']="";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				break;

			case 'lab':
                $data['no_lab']=$param3;
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
                $data['tab_lab']="active";
                $data['tab_pa']="";
                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				break;

			case 'pa':
                $data['no_pa']=$param3;
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="active";
				$data['tab_prosedur'] = "";
                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = '';
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				break;

			case 'rad':
                $no_rad=$param3;
                if($no_rad!='')
                {
                    $data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
                    $data['no_rad']=$no_rad;
                }else{
                    if($this->radmdaftar->get_data_pemeriksaan($no_register)->row()->no_rad!=''){
                        $data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
                    }else{
                        $data['data_rad_pasien']='';
                    }//$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

                }
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="active";
				$data['tab_em']="";
				$data['tab_prosedur'] = "";
                $data['tab_resep']="";
                $data['tab_diagnosa']="";
                $data['tab_obat'] = 'active';
                $data['tab_racikan']  = '';
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_serah_terima'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_ews'] = "";
				break;


			case 'em':
					$no_em=$param3;
					if($no_em!='')
					{
						$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
						$data['no_em']=$no_em;
					}else{
						if($this->emmdaftar->get_data_pemeriksaan($no_register)->row()->no_em!=''){
							$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
						}else{
							$data['data_em_pasien']='';
						}//$data['data_em_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
	
					}
					$data['tab_tindakan']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_fisik']="";
					$data['tab_lab']="";
					$data['tab_prosedur'] = "";
	
					$data['tab_pa']="";
					$data['tab_rad']="";
					$data['tab_em']="active";
					$data['tab_resep']="";
					$data['tab_diagnosa']="";
					$data['tab_obat'] = 'active';
					$data['tab_racikan']  = '';
					$data['tab_gigi'] = "";
					$data['tab_cppt'] = "";
					$data['tab_transfer_ruangan'] ="";
					$data['tab_serah_terima'] = "";
					$data['tab_fungsional_status'] = "";

					break;				

			case 'resep':
                $no_resep=$param3;
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
				$data['tab_prosedur'] = "";
                $data['tab_pa']="";
                $data['tab_rad']="";
				$data['tab_em']="";
                $data['tab_resep']="active";
				$data['tab_gigi'] = "";
				$data['tab_cppt'] = "";
				$data['tab_transfer_ruangan'] ="";
				$data['tab_fungsional_status'] = "";


                if($no_resep!='')
                {

                    $data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();
                    $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
                    $data['no_resep']=$no_resep;
                }else{
                    if($this->rdmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
                        $data['no_resep']=$this->rdmpelayanan->getdata_resep_pasien($no_register)->result();
                    }else{
                        $data['data_obat_pasien']='';
                    }
                }
                $data['tab_obat']="active";
                $data['tab_racikan']="";
                if($param4!=''){
                    $data['tab_obat']="";
                    $data['tab_racikan']="active";
                }
				$data['tab_serah_terima'] = "";
				break;
		}



		$data['tab'] = $tab;
		$data['statfisik'] = 'show';
		$data['staff'] = 'perawat';
		$data['data_pemeriksa'] = $this->load->get_var("user_info");
		$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
		$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();
		$data['assesment_medik_igd']= $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
		$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
		$data['serah_terima'] = $this->rdmpelayanan->check_serah_terima($no_register)->row();
		$data['penilaian_fungsional_status'] = $this->rdmpelayanan->check_penilaian_fungsional_status($no_register)->row();

		$this->load->view('ird/rdvpelayanan',$data);
	}


	public function pelayanan_tindakan($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="#" onclick="return openUrl(`'.site_url('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli).'`)" id="tombolkembali">Kembali</a>';
		$data['pelayan']='PERAWAT';
		$datenow = date('Y-m-d');
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data; 
		$data['id_poli'] = $id_poli;
		$data['controller']=$this; 
		$data['view']=0; 
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_pasien']=$this->rdmpelayanan->getdata_pasien($no_medrecrad)->row();
		$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		$data['idrg']='IRJ';
		$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		$data['bed']='Rawat Jalan';
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['no_register']=$no_register;
		$data['poliklinik']=$this->rdmpencarian->get_poliklinik()->result();
		$data['statfisik'] = 'show';
		$data['staff'] = 'perawat';
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli($id_poli)->result();
			$data['dokter_tindakan2']=$this->rdmpelayanan->get_dokter_poli2($id_poli)->result();

		$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['role_form'] = $this->mmformigd->get_role_form('perawat')->result();
		$data['form'] = $this->mmformigd->get()->result();
		$this->load->view('ird/rdvpelayananbeta',$data);
	}


	public function form_($kode,$no_register,$rad=''){
		
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['radio'] = $rad;
		$data['id_poli'] = 'BA00';

		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$medrec = $data['data_pasien_daftar_ulang']->no_medrec;
		$nama_pasien = $this->rdmpelayanan->get_nama_pasien($medrec)->row()->nama;
		$data['title'] = $nama_pasien;
		$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		$data['data_tindakan_pasien']=$this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['data_pasien']=$this->rdmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->mmformigd->get_form_by_kode($kode)->row()->views;
		$data['idpokdiet']='';
		if($this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}
		

		switch($kode){
			case 'formfisik':
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'ews':
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'keperawatan':
				$data['assesment_medik_igd']= $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$triase = $this->rdmpelayanan->get_triase_by_noreg($no_register);
				($triase->num_rows() >= 1)?$data['triase'] = $triase->result():'';
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['data_pemeriksa'] = $this->load->get_var("user_info");
				break;
			case 'evaluasi':
				$data['pelayan']='PERAWAT';
				$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
				$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				break;
			case 'transferruangan':
				$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();
				$data['assesment_medik_igd']= $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'serahterima':
				if($login_data->role == 'Perawat IGD' || $login_data->role == 'Perawat Poli' || $login_data->role == 'Perawat Rawat Jalan' || $login_data->role == 'Perawat Kebidanan' || $login_data->role == 'Perawat Rawat Inap' || $login_data->role == 'Administrator') {
					$data['serah_terima'] = $this->rdmpelayanan->check_serah_terima($no_register, 'Perawat')->row();
				} else if($login_data->role == 'Dokter Umum' || $login_data->role == 'Dokter Spesialis') {
					$data['serah_terima'] = $this->rdmpelayanan->check_serah_terima($no_register, 'Dokter')->row();
				}
					
				$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
				break;
			case 'penilaianfungsional':
				$data['penilaian_fungsional_status'] = $this->rdmpelayanan->check_penilaian_fungsional_status($no_register)->row();
				break;
			case 'tindakan':
				$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
				$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli('BA00')->result();
				$data['users'] = $this->rimtindakan->get_users()->result();
				break;
			case 'triase':
				$data['triase'] = '';
				$triase = $this->rdmpelayanan->get_triase_by_noreg($no_register);
				($triase->num_rows() >= 1)?$data['triase'] = $triase->result():'';
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'asesmenmedik':
				$data['triase'] = '';
				$triase = $this->rdmpelayanan->get_triase_by_noreg($no_register);
				($triase->num_rows() >= 1)?$data['triase'] = $triase->result():'';
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['assesment_medik_igd']= $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'skriningcovid':
				$data['skrining_covid'] = $this->rdmpelayanan->check_skrining_covid($no_register)->row();
				break;
			case 'lab':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();	
				$data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_register)->result();	
				break;
			case 'rad':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();	
				$data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_register)->result();
				break;
			case 'em':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_em_pasien']=$this->rdmpelayanan->getdata_em_pasienrj($no_register,$datenow)->result();	
				$data['cetak_em_pasien']=$this->rdmpelayanan->getcetak_em_pasien($no_register)->result();
				break;
			case 'resep':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();	
				$data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_register)->result();
				break;
			case 'ok':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_ok_pasien']=$this->rdmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();
				break;
			case 'konsultasi':
				$data['poli']=$this->rjmpencarian->get_poliklinik_non_igd()->result();
				$data['poli_rad'] = $this->rjmpencarian->get_poli_konsul_anestesi()->result();
				break;
			case 'surveilans':
				$data['survei_irj'] = $this->rdmpelayanan->get_surveilans_irj($no_register)->row();
				$data['lap_anestesi'] = $this->rdmpelayanan->get_laporan_anestesi_by_noreg($no_register)->row();
				$data['lap_operasi'] = $this->rdmpelayanan->get_laporan_operasi_by_noreg($no_register)->row();
				$data['persiapan_opr'] = $this->rdmpelayanan->get_checklist_persiapan_operasi_by_noreg($no_register)->row();
				// $data['dpo_surveilans'] = $this->rimtindakan->get_dpo_surveilans($no_ipd)->result();
				break;
			case 'nihss':
				$data['nihss'] = $this->rjmpelayanan->get_nihss($no_register)->row();
				break;
			case 'disfagia':
				$data['disfagia'] = $this->rjmpelayanan->get_formulir_disfagia($no_register)->row();
				break;
			case 'suket_sakit':
				$data['suket_sakit'] = $this->rjmpelayanan->get_suket_sakit($no_register)->row();
				break;
			case 'rasal':
				$data['rasal'] = $this->rjmpelayanan->get_data_rasal($no_register)->row();
				break;
			case 'raslan':
				$data['raslan'] = $this->rjmpelayanan->get_data_raslan($no_register)->row();
				break;
			case 'gyssens':
				$data['gyssens'] = $this->rjmpelayanan->get_data_gyssens($no_register)->row();
				break;
			case 'raspatur':
				$data['raspatur'] = $this->rjmpelayanan->get_data_raspatur($no_register)->row();
				break;
			case 'edukasi_penolakan_rencana_asuhan':
				$data['edukasi_penolakan_rencana_asuhan'] = $this->rjmpelayanan->get_edukasi_penolakan_rencana_asuhan($no_register)->row();
				break;
			

				
		}
		return $this->load->view($views,$data);
	}

	public function surveilans() {
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		// $idrg = $this->rimtindakan->get_idrg_pasien_iri($noipd)->row()->idrg;
		
		$check = $this->rdmpelayanan->get_surveilans_irj($noipd);
		if($check->num_rows()) {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			// $data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->update_surveilans_iri($noipd, $data);
		} else {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			// $data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->insert_surveilans($data);
		}
		$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));

		echo $response;
	}

	public function cek_pasien_ird_ranap($noregasal)
	{
		header('Content-Type: application/json; charset=utf-8');
		$get_noipd = $this->rimtindakan->get_ipd_for_konsul($noregasal)->result();
		echo json_encode($get_noipd);
	}

	//NOTE IGD - CATATAN MEDIS GAWAT DARURAT
	public function note_igd($no_register=''){
		if($no_register!=''){
			$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['title'] = 'CATATAN MEDIS GAWAT DARURAT | '.$data['data_pasien_daftar_ulang']->nama.' | '.$no_register;
			$data['id_poli']='BA00';
			$data['no_register']=$no_register;
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli_BA00()->result();
			$this->load->view('ird/rdvnote',$data);
		}
	}

	public function get_noteigd(){
		$no_register=$this->input->post('no_register');
		if($no_register!=''){
			$data=$this->rdmpelayanan->getdata_noteigd($no_register)->result();
			echo json_encode($data);
		}
	}

	public function insert_noteigd()
	{		
		
		$data['triage_nbm']=$this->input->post('triage_non');
		$data['triage_bm']=$this->input->post('triage_mass');
		if($this->input->post('cara_dtg')!='SENDIRI'){
			$data['cara_datang']=$this->input->post('extra_diantar');
		}else{
			$data['cara_datang']=$this->input->post('cara_dtg');
		}
		
		$data['jenis_anamnesa']=$this->input->post('jns_anamnesa');
		$data['subjektif']=$this->input->post('subjektif');

		if($this->input->post('riwayat_alergi')){
			$data['riwayat_alergi']=$this->input->post('riwayat_alergi');
		}else{
			$data['riwayat_alergi']=$this->input->post('riwayat_alergi');
		}
		
		$data['riwayat_terdahulu']=$this->input->post('riwayat_terdahulu');
		$data['keadaan_umum']=$this->input->post('keadaan_umum');
		$data['nilai_nyeri']=$this->input->post('nilai_nyeri');
		$data['td']=$this->input->post('td');
		$data['nadi']=$this->input->post('nadi');
		$data['suhu']=$this->input->post('suhu');
		$data['pernafasan']=$this->input->post('pernafasan');
		$data['bb']=$this->input->post('bb');
		$data['sato']=$this->input->post('sato');
		$data['id_dokter']=$this->input->post('id_dokter');
		$data['jam_dokter']=$this->input->post('jam_dokter');
		
		$data['objektif']=$this->input->post('objektif');
		$data['gcs_e']=$this->input->post('gcs_e');
		$data['gcs_m']=$this->input->post('gcs_m');
		$data['gcs_v']=$this->input->post('gcs_v');
		$data['lab']=$this->input->post('lab');
		$data['rad']=$this->input->post('rad');
		$data['ekg_ecg']=$this->input->post('ekg');
		$data['head']=$this->input->post('head');
		$data['eyes']=$this->input->post('eyes');
		$data['mouth']=$this->input->post('mouth');
		$data['neck']=$this->input->post('neck');
		$data['chest']=$this->input->post('chest');
		$data['abdomen']=$this->input->post('abdomen');
		$data['extremity']=$this->input->post('extremity');
		$data['genetalia']=$this->input->post('genetalia');
		$data['work_diag']=$this->input->post('diag_kerja');
		$data['diff_diag']=$this->input->post('diag_diff');
		$data['treat_therapy']=$this->input->post('treat_therapy');
		$data['consultation']=$this->input->post('consul');
		$data['cito']=$this->input->post('cito');
		$data['follow_up']=$this->input->post('follow_up');
		$data['discharge']=$this->input->post('discharge');
		//$data['tgl_plg']=$this->input->post('id_poli');
		//$data['jam_plg']=$this->input->post('id_poli');

		$no_register=$this->input->post('no_register');		
		$data_note=$this->rdmpelayanan->getdata_noteigd($no_register)->row();	
		if (sizeof($data_note)==0) {	
			$data['no_register']=$this->input->post('no_register');
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data['nama_perawat']=$user;
			$data['jam_perawat']=date('H:i');
	 		$id=$this->rdmpelayanan->insert_note_igd($data);
			//INSERT
		} else {
	 		$id=$this->rdmpelayanan->update_note_igd($no_register, $data);
			// UPDATE
		}
		echo json_encode($id);
	}

	public function insert_dietpasien()
    {        
        $data['no_medrec'] = $this->input->post('no_medrec');
        $data['idpokdiet'] = $this->input->post('record_gizi');
        $data['rawat'] = $this->input->post('rawat');
        $data['xcreate'] = date('Y-m-d H:i:s');
        
        $login_data = $this->load->get_var("user_info");
        $user = $login_data->username;
        $data['xuser']=$user;
    
        $result = $this->Mgizi->insert_dietpasien($data);
        echo json_encode($result);
    }

	public function get_json_form_assesment($no_reg = ''){
		return $this->rdmpelayanan->getJsonFormAssesment($no_reg);
	}

	public function cetak_fisik($no_register)
	{
		
		$data['data_fisik'] =$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		return $this->load->view('CPPT_RJ',$data);

	}

	public function insert_assesment($no_reg = '',$iid_poli = '')
	{
		//var_dump($this->input->post());
		$id_poli=$iid_poli;
		$no_register = $no_reg;
		$data['alergi'] = $this->input->post('alergi');
		$data['riwayat_alergi'] = $this->input->post('riwayat_alergi');
		$data['reaksi_alergi'] = $this->input->post('reaksi_alergi');
		$data['nyeri'] = $this->input->post('nyeri');
		$data['kualitas_nyeri'] = $this->input->post('kualitas_nyeri');
		$data['skala_nyeri'] = $this->input->post('skala_nyeri');
		$data['metode_nyeri'] = $this->input->post('metode_nyeri');
		$data['frekuensi_nyeri'] = $this->input->post('frekuensi_nyeri');
		$data['durasi_nyeri'] = $this->input->post('durasi_nyeri');

		$cek_menjalar = $this->input->post('menjalar');
		if($cek_menjalar != "iya"){
			$data['menjalar'] = $this->input->post('menjalar');
			
		}else{
			$data['menjalar'] = $this->input->post('value_menjalar');
		}

		

		$data['lokasi_nyeri'] = $this->input->post('lokasi_nyeri');
		$data['formjson'] = $this->input->post('formjson');
		$data['fk_minum_obat'] = $this->input->post('fk_minum_obat');
		$data['fk_istirahat'] = $this->input->post('fk_istirahat');
		$data['fk_musik'] = $this->input->post('fk_musik');
		$data['fk_posisi_tidur'] = $this->input->post('fk_posisi_tidur');
		$data['gizi_asupan_makan'] = $this->input->post('gizi_asupan_makan');
		$data['penilaian_gizi'] = $this->input->post('penilaian_gizi');
		$data['stat_sosial_keluarga'] = $this->input->post('stat_sosial_keluarga');
		$data['stat_psikologis'] = $this->input->post('stat_psikologis');
		$data['stat_pernikahan_ekonomi'] = $this->input->post('stat_pernikahan_ekonomi');
		$data['skrining_risiko_cedera'] = $this->input->post('skrining_risiko_cedera');
		$data['fungsional_alat_bantu'] = $this->input->post('fungsional_alat_bantu');
		$data['alat_bantu'] = $this->input->post('alat_bantu');
		
		$cek_gizi_penurunan_bb = $this->input->post('gizi_penurunan_bb');
		if($cek_gizi_penurunan_bb == "ya"){
			$data['gizi_penurunan_bb'] = $this->input->post('value_gizi_penurunan_bb');
		}else{
			$data['gizi_penurunan_bb'] = $this->input->post('gizi_penurunan_bb');
		}


		$fungsional_cacat_tubuh_ada = $this->input->post('fungsional_cacat_tubuh');
		if($fungsional_cacat_tubuh_ada == "ada"){
			$data['fungsional_cacat_tubuh'] = $this->input->post('value_cacat_tubuh');
		}else{
			$data['fungsional_cacat_tubuh'] = $this->input->post('fungsional_cacat_tubuh');
		}

		$data['kes_keluarga_pas_edukasi'] = $this->input->post('kes_keluarga_pas_edukasi');
		$data['hambatan_edukasi'] = $this->input->post('hambatan_edukasi');
		$data['membutuhkan_penerjemah_edukasi'] = $this->input->post('membutuhkan_penerjemah_edukasi');
		$data['pengetahuan_edukasi'] = $this->input->post('pengetahuan_edukasi');
		$data['perawatan_penyakit'] = $this->input->post('perawatan_penyakit');
		$data['cara_minum_obat'] = $this->input->post('cara_minum_obat');
		$data['diet'] = $this->input->post('diet');
		//var_dump($data);die();

		
		$dataasesment['nyeri_akut'] = $this->input->post('nyeri_akut');
		$dataasesment['ketidakseimbangan_nutrisi'] = $this->input->post('ketidakseimbangan_nutrisi');
		$dataasesment['pola_nafas_tidak_efektif'] = $this->input->post('pola_nafas_tidak_efektif');
		$dataasesment['bersihkan_jalan_nafas'] = $this->input->post('bersihkan_jalan_nafas');
		$dataasesment['hipertermia'] = $this->input->post('hipertermia');
		$dataasesment['diare'] = $this->input->post('diare');
		$dataasesment['resiko_infeksi_pembedahan'] = $this->input->post('resiko_infeksi_pembedahan');
		$dataasesment['ansietas'] = $this->input->post('ansietas');
		$dataasesment['gangguan_citra_tubuh'] = $this->input->post('gangguan_citra_tubuh');
		$dataasesment['gangguan_menelan'] = $this->input->post('gangguan_menelan');
		$dataasesment['penurunan_curah_jantung'] = $this->input->post('penurunan_curah_jantung');
		$dataasesment['intoleransi_aktifitas'] = $this->input->post('intoleran_aktifitas');
		$dataasesment['gangguan_mobilitas_fisik'] = $this->input->post('gangguan_mobilitas_fisik');
		$dataasesment['hambatan_komunikasi_verbal'] = $this->input->post('hambatan_komunikasi_verbal');
		$dataasesment['diskontuinitas_jaringan'] = $this->input->post('diskontuinitas_jaringan');
		$dataasesment['ketidakstabilan_gula_darah'] = $this->input->post('ketidakstabilan_gula_darah');
		$dataasesment['lainnya'] = $this->input->post('lainnya');
		$id_keperawatan = $this->input->post('id_keperawatan[]');
		$dataasesment['no_register'] = $no_register;
		$data_assesment=$this->rdmpelayanan->getdata_assesment($no_register)->row();
		$data_fisik=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik==NULL) {
			$data['no_register'] = $no_register;
			$this->rdmpelayanan->insert_data_fisik($data);
		} else {
			$this->rdmpelayanan->update_data_fisik($no_register, $data);
		}
		if ($data_assesment==NULL) {
				$data['no_register'] = $no_register;
				$this->rdmpelayanan->insert_assesment($dataasesment);										
		} else {
				$this->rdmpelayanan->update_assesment($no_register,$dataasesment);
		}
		$res = array('code' => 'sukses');
		return json_encode($res);
	}

	public function insert_fisik()
	{
		$no_register=$this->input->post('no_register');	
		$id_poli=$this->input->post('id_poli');
		$data = $this->input->post();
		$login_data = $this->load->get_var("user_info");
		$result = '';
		$data['id_perawat'] = $login_data->userid;
		$soap['userid'] = $login_data->userid;
		// validate to pemeriksaan_fisik
		$data_fisik=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik==FALSE) {
			$data['no_register'] = $no_register;
			$this->rdmpelayanan->insert_data_fisik($data);
		} else {
			$this->rdmpelayanan->update_data_fisik($no_register, $data);
		}
		// var_dump($data);die();
		// validate to soap_pasien_rj
		$soap_pasien_rj_get = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register);
		// $soap['subjective_perawat'] = $data['ku'];
		//ini yg dulu
		// $soap['objective_perawat'] = 'Td : '.$data['sitolic'].'/'.$data['diatolic'].PHP_EOL.'nadi : '.$data['nadi'].PHP_EOL.'pernafasan : '.$data['pernafasan'].PHP_EOL.'suhu : '.$data['suhu'].PHP_EOL.'bb : '.$data['bb'].PHP_EOL.'pupil : '.$data['pupil'].PHP_EOL.'spotwo : '.$data['spotwo'].PHP_EOL.'kesadaran : '.$data['kesadaran'].PHP_EOL.'gcs : '.' '.'E :'.$data['e_gcs'].' '.'M :'.$data['m_gcs'].' '.'V :'.$data['v_gcs'].PHP_EOL.'sensorik : '.$data['sensorik_tangan_kanan'].'*'.$data['sensorik_tangan_kiri'].'*'.$data['sensorik_kaki_kanan'].'*'.$data['sensorik_kaki_kiri'];
		$soap['objective_perawat'] = 'Td : '.$this->input->post('sitolic').'/'.$this->input->post('diatolic').PHP_EOL.'nadi : '.$this->input->post('nadi').PHP_EOL.'pernafasan : '.$this->input->post('pernafasan').PHP_EOL.'suhu : '.$this->input->post('suhu').PHP_EOL.'bb : '.$this->input->post('bb').PHP_EOL.'pupil : '.$this->input->post('pupil').PHP_EOL.'spotwo : '.$this->input->post('spotwo').PHP_EOL.'kesadaran : '.$this->input->post('kesadaran').PHP_EOL.'gcs : '.' '.'E :'.$this->input->post('e_gcs').' '.'M :'.$this->input->post('m_gcs').' '.'V :'.$this->input->post('v_gcs').PHP_EOL.'sensorik : '.$this->input->post('sensorik_tangan_kanan').'*'.$this->input->post('sensorik_tangan_kiri').'*'.$this->input->post('sensorik_kaki_kanan').'*'.$this->input->post('sensorik_kaki_kiri');
		$soap['tgl_input'] = date('Y-m-d H:i:s');
		$soap['id_pemeriksa'] = $login_data->userid;
		$soap['no_register'] = $no_register;
		if($soap_pasien_rj_get->num_rows()){
			
			$soap_update = $this->rdmpelayanan->update_soap_pasien($soap,$data['no_register']);
			$submitdata = $soap_update?$result.json_encode(array('data'=>'update soap sukses')):$result.json_encode(array('data'=>'update soap gagal'));
			
		}else{
			$soap_insert = $this->rdmpelayanan->insert_soap_pasien($soap);
			$submitdata = $soap_insert?$result.json_encode(array('data'=>'insert soap sukses')):$result.json_encode(array('data'=>'insert soap gagal'));
		}
		echo $result;
		
	}
	// /////////////////////////////////////////////////////////////////////////////////////////////
	// public function insert_rad()
	// {
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['id_tindakan']=$this->input->post('idtindakan');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
	// 	$data_tindakan=$this->radmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['jenis_tindakan']=$row->nmtindakan;
	// 	}
	// 	$data['qty']=$this->input->post('qty_rad');
	// 	$data['id_dokter']=$this->input->post('id_dokter');
	// 	$data_dokter=$this->radmdaftar->getnama_dokter($data['id_dokter'])->result();
	// 	foreach($data_dokter as $row){
	// 		$data['nm_dokter']=$row->nm_dokter;
	// 	}
	// 	$data['biaya_rad']=$this->input->post('biaya_rad_hide');
	// 	$data['vtot']=$this->input->post('vtot_rad_hide');
	// 	$data['idrg']=$this->input->post('idrg');
	// 	$data['bed']=$this->input->post('bed');
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
	// 	$data['no_rad']=$this->input->post('no_rad');

	// 	if($data['no_rad']!=''){
	// 	} else {
	// 		$this->radmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 		$data['no_rad']=$this->radmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_rad;
	// 	}

		

	// 	$this->radmdaftar->insert_pemeriksaan($data);
		
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/rad/'.$data['no_rad']);
	// 	//print_r($data);
	// }

	// public function selesai_daftar_rad($no_register='',$id_poli='')
	// {
	// 	$getvtotrad=$this->radmdaftar->get_vtot_rad($no_register)->row()->vtot_rad;
	// 	$getrj=substr($no_register, 0,2);
	// 	if ($getrj=="RJ"){
	// 		$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotrad);
	// 	}		

	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/rad');
	// 	//print_r($getvtotrad);
	// }

	// public function hapus_data_rad($no_register='',$no_rad='', $id_pemeriksaan_rad='', $id_poli='')
	// {
	// 	$id=$this->radmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_rad);

	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/rad/'.$no_rad);
		
	// 	//print_r($id);
	// }	
	////////////////////////////////////////////////////////////////////////////////////////////
	public function insert_tindakan()
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$userid =  $login_data->userid;
		$pelaksana = explode("-", $this->input->post('pelaksana'));

		$data['userid']=$pelaksana[0];
		$data['nm_user']=$pelaksana[1];

		$data['xuser']=$user;
		$data['tgl_kunjungan']=date("Y-m-d H:i:s", strtotime($this->input->post('tgl_tindakan')));
		$data['xupdate']=date("Y-m-d H:i:s", strtotime($this->input->post('tgl_tindakan')));


		$data['id_poli']=$this->input->post('id_poli');
		$data['no_register']=$this->input->post('no_register');
		$no_register = $this->input->post('no_register');
		$tindakan = explode("@", $this->input->post('idtindakan'));
		$data['idtindakan']=$tindakan[0];
		$data['nmtindakan']=$tindakan[1];
		$data['jam_tindakan'] = date("H:i:s", strtotime($this->input->post('tgl_tindakan')));
		
		
		// if($this->input->post('id_dokter')!=''){
		// 	$dokter = explode("@", $this->input->post('id_dokter'));
		// 	$data['id_dokter']=$dokter[0];
		// 	$data['nm_dokter']=$dokter[1];
		// }else{
			
		// }

		// if($this->input->post('id_perawat')!=''){
		// 	$dokter = explode("@", $this->input->post('id_perawat'));
		// 	$data['id_perawat']=$dokter[0];
		// 	$data['nm_perawat']=$dokter[1];
		// }else{
			
		// }

		// $get_ttd_dokter = $this->rjmpelayanan->ttd_user($login_data->userid)->row();
		// if($data['id_dokter'] == ''){
		// 	$get_ttd_dokter = null;
		// }else{
			$get_ttd_dokter = $this->rjmpelayanan->ttd_pemeriksa($userid)->row();
		//}
		

		//if ($get_ttd_dokter != null) {
			$data['ttd_dokter']=$get_ttd_dokter->ttd;
		// }else{
		// 	$data['ttd_dokter']='';
		// }

		$data['bpjs']=$this->input->post('cover_bpjs');
		$data['biaya_tindakan']=$this->input->post('biaya_tindakan_hide');
		
		$biaya_alkes = $this->input->post('biaya_alkes_hide');
		if($biaya_alkes != null || $biaya_alkes = ''){
			$data['biaya_alkes']=$biaya_alkes;
		}else{
			$data['biaya_alkes'] = 0;
		}
		$data['qtyind']=$this->input->post('qtyind');
		//$data['dijamin']=$this->input->post('dijamin');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['tmno']=$this->input->post('tmno');
		// print_r($data);die();


		// $cektindakan = $this->rdmpelayanan->cek_tindakan($no_register)->row();
        //                 if($cektindakan == false){
        //                     $datafisik['tindakan'] = 'Tindakan '.$data['nmtindakan'].' ';
        //                 }else{
        //                     $datafisik['tindakan'] = $cektindakan->tindakan.'<br>'.'Tindakan '.$data['nmtindakan'].' ';
        //                 }
		

		$id=$this->rdmpelayanan->insert_tindakan($data);
		//	fisik
		// $data_fisik=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		// if ($data_fisik==FALSE) {
		// 	$datafisik['no_register'] = $no_register;
		// 	$this->rdmpelayanan->insert_data_fisik($datafisik);
		// 	//INSERT
		// } else {
		// 	$this->rdmpelayanan->update_data_fisik($no_register, $datafisik);
		// 	// UPDATE
		// }
		
		//penambahan vtot di daftar_ulang_ird
		$vtot_sebelumnya = $this->rdmpelayanan->get_vtot($data['no_register'])->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
		$id=$this->rdmpelayanan->update_vtot($data_vtot,$data['no_register']);

		// penambahan untuk report ke assesment awal keperawatan
		$report['no_register'] = $this->input->post('no_register');
		$report['nm_tindakan'] = $tindakan[1];
		$report['id_pemeriksa'] = $login_data->userid;
		$report['tgl_input'] = date('Y-m-d H:i:s');
		$this->rdmpelayanan->insert_tindakan_resep_pasien_ird($report);


		// add to soap pasien rj @aldi 
		
		$check_available_data = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register);
		$soap['terapi_tindakan_dokter'] = isset($check_available_data->row()->terapi_tindakan_dokter)?$check_available_data->row()->terapi_tindakan_dokter:''.'- '.$tindakan[0].' , '.$tindakan[1].'\n';
		if($check_available_data->num_rows()){
			$soap_update = $this->rdmpelayanan->update_soap_pasien($soap,$no_register);
			// update
		}else{
			$soap_insert = $this->rdmpelayanan->insert_soap_pasien($soap);
			// insert
		}
		
		echo json_encode($id);

		// $success = 	'<div class="alert alert-success">
		// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		// 		<h3><i class="fa fa-check-circle"></i> Data Berhasil Dihapus.</h3>
		// 	</div>';
		// $this->session->set_flashdata('success_msg', $success);
		// redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$data['id_poli'].'/'.$data['no_register']);
	}	
	public function hapus_tindakan($id_poli='',$id_pelayanan_poli='', $no_register='')
	{	
		//pengurangan vtot di daftar_ulang_ird
		$vtot_sebelumnya = $this->rdmpelayanan->get_vtot($no_register)->row()->vtot;
		//get vtot_tindakan_sebelumnya
		$vtot_tindakan_sebelumnya=$this->rdmpelayanan->get_vtot_tindakan_sebelumnya($id_pelayanan_poli)->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya-(int)$vtot_tindakan_sebelumnya;
		
		$this->rdmpelayanan->update_vtot($data_vtot,$no_register);
		$id=$this->rdmpelayanan->hapus_tindakan($id_pelayanan_poli);

		$success = 	'<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				<h3><i class="fa fa-check-circle"></i> Data Berhasil Dihapus.</h3>
			</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('ird/rdcpelayanan/form/tindakan/'.$no_register);
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////create update data pelayanan poli
	
	// public function insert_diagnosa()
	// {
	// 	date_default_timezone_set("Asia/Jakarta");
	// 	$login_data = $this->load->get_var("user_info");
	// 	$user = $login_data->username;
	// 	$data['xuser']=$user;
	// 	$data['xupdate']=date("Y-m-d H:i:s");

	// 	$data['no_register']=$this->input->post('no_register');
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['id_poli']=$id_poli;
	// 	$data['klasifikasi_diagnos']=$this->input->post('klasifikasi_diagnos');
		
	// 	if ($data['klasifikasi_diagnos']=="utama") 
	// 	{
	// 		//cek diagnosa utama 
	// 		$cek_diagnosa_utama=$this->rdmpelayanan->cek_diagnosa_utama($data['no_register'])->row();
	// 		$jumlah_diag_utama=$cek_diagnosa_utama->jumlah;
	// 		echo  $jumlah_diag_utama;
	// 		if ($jumlah_diag_utama==1) 
	// 		{
	// 			$tab="diag";
	// 			$success = 	'
	// 					<div class="content-header">
	// 						<div class="box box-default">
	// 							<div class="alert alert-danger alert-dismissable">
	// 								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	// 								<h4>
	// 								<i class="icon fa fa-check"></i>
	// 								Diagnosa utama untuk no register "'.$data['no_register'].'" sudah terdaftar.
	// 								</h4>
	// 							</div>
	// 						</div>
	// 					</div>';
	// 			$this->session->set_flashdata('success_msg', $success);
	// 			redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		} else {
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];
	// 		$id=$this->rdmpelayanan->insert_diagnosa($data);
	// 		$diag_utama=$this->rdmpelayanan->get_diag_pasien($data['no_register']);
		
	// 		$i=0;
	// 		$diag3=$diag_utama->result();
	// 		foreach($diag3 as $row){
	// 			echo "hahaha";
	// 			$diag[$i]=$row->id_diagnosa;	
	// 			++$i;		
	// 		}

	// 		if($diag[0]!=''){
	// 			$add_diag['diag_baru']=$diag[0];
	// 		}
	// 		if($diag[1]!=''){
	// 			$add_diag['diag_lama']=$diag[1];
	// 		}
	// 		//print_r($diag);
	// 		$diag_utama=$this->rdmpelayanan->update_diag_daful($add_diag,$data['no_register']);

	// 		//$id=$this->rdmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		}
	// 	}
	// 	else //jika klasifikasi diagnosa==tambahan
	// 	{
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];

	// 		$id=$this->rdmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 	}
	// }
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {	
	// 	$id=$this->rdmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function cek_diag()
	{	
		$cek_utama = $this->rdmpelayanan->cek_diagnosa_utama($this->input->post('no_register'))->row();
		if ((int)$cek_utama->jumlah>0) {
			echo '1';
		} else {
			echo '2';
		}	
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////pulang / selesai pelayanan poli
	public function update_pulang()
	{	
		date_default_timezone_set('Asia/Jakarta');
		$data['cetak_prmrj'] = $this->input->post('cetak_prmrj')!= null?1:0;
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		
		$data_pasien_daftar_ulang=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();		
		// var_dump($data_pasien_daftar_ulang);die();	
		// $data['id_dokter'] = ($this->input->post('dokter_kontrol_id') != null ||$this->input->post('dokter_kontrol_id') != '')?$this->input->post('dokter_kontrol_id') :$data_pasien_daftar_ulang->id_dokter;
		$data['dokter_kontrol_id'] = $this->input->post('dokter_kontrol_id')??null;
		$cara_bayar=$data_pasien_daftar_ulang->cara_bayar;
		$no_sep=$data_pasien_daftar_ulang->no_sep;
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['tgl_pulang']=date("Y-m-d");
		$data['ket_pulang']=$this->input->post('ket_pulang');
		$data['status']=1;
		$data['tujuan_rs'] = $this->input->post('tujuan_rs');
		$data['waktu_pulang'] = date('Y-m-d H:i:s');
		$data['saran_rawat'] = $this->input->post('saran_rawat');
		$data['catatan_plg'] = $this->input->post('alasan_rujukan')!=''?$this->input->post('alasan_rujukan'):'';
		$data['tindak_lanjut'] = $this->input->post('tindak_lanjut');
		$data['jam_kontrol_ulang'] = ($this->input->post('jam_kontrol_ulang')!= null || $this->input->post('jam_kontrol_ulang')!= '')?$this->input->post('jam_kontrol_ulang'):'';
		$data['puskesmas_tujuan'] = $this->input->post('puskesmas_tujuan');
		$id=$this->rdmpelayanan->update_pulang($data,$no_register);
		// var_dump($data['ket_pulang']);die();
		switch($data['ket_pulang']){
			
			case "dirujuk":
				// redirect('bpjs/sep/create/'.$no_register.'/IRD');
			
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<a target="_blank" href="'.base_url('emedrec/c_emedrec/cetak_surat_kontrol/'.$this->input->post('no_medrec').'/'.$this->input->post('no_register')).'" class="btn waves-effect waves-light btn-primary" type="button" ><i class="fa fa-print"></i> Cetak Surat Kontrol</a>
									Cetak Surat Kontrol
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);	
				if($this->input->post('sebagai')== 'PERAWAT'){
					redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
				}else{
					redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
				}

			case "DIRUJUK_RAWATINAP":
				$data4['timein']=date('Y-m-d H:i:s');
				$data4['status']=2;
				$id1=$this->rjmtracer->update_mappasien($no_register,$data4);		
				
				// insert langsung ke reservasi
				$count=$this->rimpendaftaran->get_pasien_iri_exist($data_pasien_daftar_ulang->no_medrec)->row()->exist;
				$data_reservasi['tppri']= "rawatjalan";
				if($data_reservasi['tppri']=='rawatjalan' and (int)$count==0 ){
					$count=0;
				}else if($data_reservasi['tppri']=='ruangrawat' and (int)$count==1 ){
					$count=0;
				}
				if((int)$count==0){
					// Asal
	   
				   $datenow=date('Ymd');
				   $noreservasi=count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow))+1;
				   $data_reservasi['noreservasi']=$datenow.'-'.$noreservasi; // No. Antrian
				   $data_reservasi['rujukan']='regional'; // Rujukan
				   $data_reservasi['no_medrec']=$data_pasien_daftar_ulang->no_medrec; // No. CM
	   
				
					$data_reservasi['no_register_asal']=$no_register; // Kode Reg. Asal
					// var_dump($no_register);die();
					$data_pasien_reservasi = $this->rimreservasi->select_pasien_irj($data_reservasi['no_register_asal']);
					//  var_dump($data_pasien_reservasi);die();

					// $this->session->set_flashdata('pesan',
					// "<div class='alert alert-error alert-dismissable'>
					// 	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	<i class='icon fa fa-close'></i> Reg asal tidak ditemukan!
					// </div>");
					if(!($data_pasien_reservasi)){
						if($this->input->post('sebagai')== 'PERAWAT'){
							redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
						}else{
							redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
						}
						exit;
					}

					if($this->input->post('tgl_rujuk') != ''){
						$data_reservasi['tglreserv']=$this->input->post('tgl_rujuk');
						$data_reservasi['tglrencanamasuk']=$this->input->post('tgl_rujuk');
					}else{
						$data_reservasi['tglreserv']=date('Y-m-d H:i:s');
						$data_reservasi['tglrencanamasuk']=date('Y-m-d');
					}
				   $data_reservasi['telp']=$data_pasien_daftar_ulang->no_telp; // Telp
				   $data_reservasi['hp']=$data_pasien_daftar_ulang->no_hp; // HP
	   
				   $data_reservasi['id_poli']=$data_pasien_daftar_ulang->id_poli; // Id Poli
				//    $data_reservasi['poliasal']=$data_pasien_daftar_ulang->nm_poli; // Poli Asal
				   $data_reservasi['id_dokter']=$data_pasien_daftar_ulang->id_dokter; // Poli asal
				   $data_reservasi['dokter']=$data_pasien_daftar_ulang->dokter; // Poli Asal
				   $data_reservasi['diagnosa']=$data_pasien_daftar_ulang->diagnosa; // Poli Asal
				   $data_reservasi['dikirim_oleh']='Dokter';
				   $data_reservasi['dikirim_oleh_teks']=$data_pasien_daftar_ulang->dokter;
				   
				   //  RENCANA MASUK
				//    $data_reservasi['tglrencanamasuk']=date('Y-m-d'); // Rencana masuk
				//    $temp_ruang = $this->input->post('ruang',true); // Kode ruang pilih
				//    var_dump($temp_ruang);die();
				//    $temp_ruang =explode("-", $temp_ruang);
				//    $data_reservasi['ruangpilih']=$temp_ruang[0]; // Kode ruang pilih
				   // $data_reservasi['kelas']=$this->input->post('kelas'); // Kelas
				//    $data_reservasi['kelas']=$temp_ruang[2]; // Kelas
				   $data_reservasi['pilihan_prioritas']=$this->input->post('pilihan_prioritas'); // Kelas
				   $data_reservasi['prioritas']=$this->input->post('prioritas'); // Kelas
				   //if(($this->input->post('infeksi'))){
				   if($this->input->post('infeksi') != null){
					   $data_reservasi['infeksi']=$this->input->post('infeksi'); // Infeksi
				   }else{
					   $data_reservasi['infeksi']='N';
				   }
				//    $data_reservasi['keterangan']=$this->input->post('keterangan'); // Keterangan
				   $data_reservasi['carabayar']=$data_pasien_daftar_ulang->cara_bayar;
				   $data_reservasi['statusantrian']='N'; // Keterangan
				   $data_reservasi['batal']='N'; // Keterangan
				   $login_data = $this->load->get_var("user_info");
				   $data_reservasi['user_approve'] = $login_data->username;		
				   $roleid= $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;	
				   // MENU
				   $data['reservasi']='active';
				   $data['daftar']='';
				   $data['pasien']='';
				   $data['mutasi']='';
				   $data['status']='';
				   $data['resume']='';
				   $data['kontrol']='';
				//    $this->session->set_flashdata('pesan',
				//    "<div class='alert alert-success alert-dismissable'>
				// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				// 	   cetak_surat_kontrol <i class='icon fa fa-check'></i> Data telah tersimpan!
				//    </div>");
				   $data['tppri'] = 'rawatjalan';
				   $data_reservasi['spri'] = substr($data_reservasi['id_poli'],-2).strval(date('m')).strval(sprintf("%02d", $noreservasi));
				   $id=$this->rimreservasi->insert_reservasi($data_reservasi);		
				   if($id==''){
					   if($this->input->post('mutasi')!=''){
					//    redirect('iri/ricpasien');
							if($this->input->post('sebagai')== 'PERAWAT'){
								redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
							}else{
								redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
							}

					   }else{
						   if ($roleid=='24') {
							if($this->input->post('sebagai')== 'PERAWAT'){
								redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
							}else{
								redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
							}

							//    redirect('iri/ricpasien');
						   }else {
						//    redirect('iri/Ricdaftar/index/1');
						if($this->input->post('sebagai')== 'PERAWAT'){
							redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
						}else{
							redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
						}

					   }}
				   }else{				
					//    $this->session->set_flashdata('pesan',
					//    "<div class='alert alert-error alert-dismissable'>
					// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	   <i class='icon fa fa-close'></i> Gagal menambahkan pasien ke list antrian !
					//    </div>");		
					if($this->input->post('sebagai')== 'PERAWAT'){
						redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
					}else{
						redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
					}
					//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
				   }
				   
			   }else{
				   if($this->input->post('tppri',true)=='rawatjalan'){
					   $data_reservasi['no_register_asal']=$this->input->post('no_register_rawatjalan'); // Kode Reg. Asal	
				   }else if($this->input->post('tppri',true)=='ruangrawat'){
					   $data_reservasi['no_register_asal']=$this->input->post('no_register_ruangrawat',true); // Kode Reg. 
				   }else{
					   $data_reservasi['no_register_asal']=$this->input->post('no_register_rawatdarurat'); // Kode Reg. Asal
				   }
				//    $this->session->set_flashdata('pesan',
				// 	   "<div class='alert alert-error alert-dismissable'>
				// 		   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				// 		   <i class='icon fa fa-close'></i> Pasien sudah dirawat diruangan !
				// 	   </div>");			
					if($this->input->post('sebagai')== 'PERAWAT'){
						redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
					}else{
						redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
					}
				//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
			   }


				// die();
				// redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
				break;
			

				default:
				// Kondisi ket_pulang = kontrol

				// data yang dibutuhkan
				// no mr data_pasien_daftar_ulang -> no_medrec
				// nama pasien data_pasien_daftar_ulang join 
				// diagnose
				// tgl surat rujukan
				// alasan pulang
				// tindak lanjut
				// dokter yang memeriksa
				// ini bpjs di non-aktifin
				// redirect('bpjs/sep/create/'.$no_register.'/IRD');
				if($this->input->post('sebagai')== 'PERAWAT'){
					redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
				}else{
					redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
				}
				break;
		}
		
		
		
	}




	public function insert_tindakan3($data1)
	{
		//date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		//  1B0109 ADM RAWAT JALAN 
		//  1B0103 ADM RAWAT Darurat
		//  1B0104 KARTU
		//  1B0107 Biaya Spesialis IRJ
		//  1B0108 Biaya IGD
		//  1B0105 Biaya Dokter Akupuntur

		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];				
		//default 
		$vtota = 0;
		if($data['id_poli']=='BA00'){
			$detailtind=$this->rdmregistrasi->get_detail_tindakan('1B0109')->row();	
			$data['idtindakan']='1B0109';
			$data['bpjs']='0';
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");
			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota=$data['vtot'];
			$id=$this->rdmpelayanan->insert_tindakan($data);
			//IGD ADD DOCTOR FEE
			$detailtind=$this->rdmregistrasi->get_detail_tindakan('1B0108')->row();	
			$data['idtindakan']='1B0108';
			$data['bpjs']='0';
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota+=$data['vtot'];
			$id=$this->rdmpelayanan->insert_tindakan($data);
			$vtot_sebelumnya = $this->rdmpelayanan->get_vtot($data['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
			$this->rdmpelayanan->update_vtot($data_vtot,$data['no_register']);

		}else{
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");
			//IGD ADD DOCTOR FEE 
			//ini diganti dulu karena tidak ada datanya
			// $detailtind=$this->rdmregistrasi->get_detail_tindakan('1B0107')->row();	
			// $data['idtindakan']='1B0107';

			//diganti dengan ini dengan isi pemeriksaan dan konseling dr spesialis
			$detailtind=$this->rdmregistrasi->get_detail_tindakan('1B0134')->row();	
			$data['idtindakan']='1B0134';
			$data['bpjs']='0';
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");
			$data['nmtindakan']=$detailtind->nmtindakan;		
			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota+=$data['vtot'];
			$id=$this->rdmpelayanan->insert_tindakan($data);
			$vtot_sebelumnya = $this->rdmpelayanan->get_vtot($data['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
			$this->rdmpelayanan->update_vtot($data_vtot,$data['no_register']);
		}
		if($data['id_poli']=='BZ04'){ //lab
			$data4['lab']=1;
			$data4['status_lab']=0;
			$data4['jadwal_lab']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ02'){ //rad
			$data4['rad']=1;
			$data4['status_rad']=0;
			$data4['jadwal_rad']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ01'){ //pa
			$data4['pa']=1;
			$data4['status_pa']=0;
			$data4['jadwal_pa']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else{
			$data4['em']=1;
			$data4['status_em']=0;
			$data4['jadwal_em']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
		}
		$no_register=$data1['no_register'];
		if($data1['cara_bayar']!='UMUM'){
			echo '<script type="text/javascript">window.open("'.site_url("ird/rdcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
		}
		
		
	}





	public function update_rujukan_penunjang_2()
	{	
		$no_register=$this->input->post('no_register');
		$jenis_rujuk=$this->input->post('jenis_rujuk');
		if($jenis_rujuk=='lab'){
			$data['jadwal_lab']=$this->input->post('jadwal_rujuk')." ".date(" H:i:s");
			$data['lab']=1;
			$data['status_lab']=1;
		} else if($jenis_rujuk=='rad'){
			$data['jadwal_rad']=$this->input->post('jadwal_rujuk')." ".date(" H:i:s");
			$data['rad']=1;
			$data['status_rad']=1;
		} else if($jenis_rujuk=='pa'){
			$data['jadwal_pa']=$this->input->post('jadwal_rujuk')." ".date(" H:i:s");
			$data['pa']=1;
			$data['status_pa']=1;
		} else if($jenis_rujuk=='ok'){
			$data['jadwal_ok']=$this->input->post('jadwal_rujuk')." ".date(" H:i:s");
			$data['ok']=1;
			$data['status_ok']=1;
		} else if($jenis_rujuk=='em'){
			$data['jadwal_rad']=$this->input->post('jadwal_rujuk')." ".date(" H:i:s");
			$data['em']=1;
			$data['status_em']=1;
		} 

		// print_r($data);
		
		$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);
		
		// $success = 	'<div class="content-header">
		// 					<div class="box box-default">
		// 						<div class="alert alert-success alert-dismissable">
		// 							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		// 							<h4>
		// 							<i class="icon fa fa-check"></i>
		// 							Rujukan Penunjang berhasil disimpan.
		// 							</h4>
		// 						</div>
		// 					</div>
		// 				</div>';
		
		
		// $this->session->set_flashdata('success_msg', $success);
		
		// redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
        echo json_encode(array("status" => $id));
	}

	function update_rujukan_resep_ruangan_rad() {
		$id_poli=$this->input->post('idrg');
        $no_register=$this->input->post('no_register');
        $data['obat']=1;
        // $data['status_obat']=0;
		$pelayan=$this->input->post('pelayan');

		if($no_register == null){
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if($pelayan == 'DOKTER'){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
			}else{
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}	
		}else{
			$data['em']=1;
			// $data['status_em']=0;
			$data['jadwal_em']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);

			if($id == true){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}else{
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if($pelayan == 'DOKTER'){
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
				}else{
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
				}				
			}
			
		}
	}

	function update_rujukan_resep_ruangan(){
        $id_poli=$this->input->post('idrg');
        $no_register=$this->input->post('no_register');
        // $data['obat']=1;
        // $data['status_obat']=0;
		$pelayan=$this->input->post('pelayan');

		if($no_register == null){
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if($pelayan == 'DOKTER'){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
			}else{
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}	
		}else{
			$data['em']=1;
			// $data['status_em']=0;
			$data['jadwal_em']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);
			$id=$this->rdmpelayanan->update_rujukan_penunjang_new($no_register);

			if($id == true){
				redirect('ird/rdcpelayanan/form/resep/'.$no_register);
			}else{
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if($pelayan == 'DOKTER'){
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
				}else{
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
				}				
			}
			
		}

        

		
	}

	public function update_rujukan_penunjang()
	{	
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		
		if ($this->input->post('lab')!=null) 
		{
			$data['lab']=$this->input->post('lab');
			$data['status_lab']=0;
			$data['jadwal_lab']=date("Y-m-d");
			// $data['jadwal_lab']=$this->input->post('jadwal_lab');
		}

		if ($this->input->post('ok')!=null) 
		{
			$data['ok']=$this->input->post('ok');
			$data['status_ok']=0;
			$data['jadwal_ok']=date("Y-m-d");
			// $data['jadwal_ok']=$this->input->post('jadwal');

			//add poli anastesi
			$data2['id_poli']='CD00';
			
			$datenow='';
			$data_sblm=$this->rdmpelayanan->getdata_daftar_sblm($no_register)->result();
			foreach($data_sblm as $row){
				
				$data2['no_medrec']=$row->no_medrec;
				$datenow=date('Y-m-d H:i:s');
				$data2['tgl_kunjungan']=$datenow;
				$data2['jns_kunj']=$row->jns_kunj;
				$data2['umurrj']=$row->umurrj;
				$data2['uharird']=$row->uharird;
				$data2['ublnrj']=$row->ublnrj;
				$data2['asal_rujukan']=$row->asal_rujukan;
				$data2['no_rujukan']=$row->no_rujukan;
				$data2['kelas_pasien']=$row->kelas_pasien;
				$data2['cara_bayar']=$row->cara_bayar;
				$data2['id_kontraktor']=$row->id_kontraktor;
				$data2['nama_penjamin']=$row->nama_penjamin;
				$data2['hubungan']=$row->hubungan;
				$data2['vtot']=$row->vtot;
				$data2['no_sep']=$row->no_sep;
				
			}

				$data2['cara_kunj']="RUJUKAN POLI";
				$login_data = $this->load->get_var("user_info");
				$data2['xcreate']=$login_data->username;
				$data2['vtot']=0;
				$data2['biayadaftar']=0;
				
				
				//print_r($data2);
				$id=$this->rdmregistrasi->insert_daftar_ulang($data2);

				//echo($id->no_register);
				$data4['timein']=date('Y-m-d H:i:s');
				$data4['status']=2;
				$id1=$this->rdmtracer->update_mappasien($no_register,$data4);
			
				$noreg=$this->rdmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;
				
				$data2['no_register']=$noreg;
				$data6['no_register']=$noreg;
				$data6['no_medrec']=$data2['no_medrec'];
				$data6['id_poli']=$data2['id_poli'];
				$data5['timeout']=date('Y-m-d H:i:s');
				$data6['status']=1;
				$data6['tiperawat']='IRJ';
				$this->insert_tindakan3($data2);
				$id2=$this->rdmtracer->insert_mappasien($data6);
		}

		if ($this->input->post('pa')!=null) 
		{
			$data['pa']=$this->input->post('pa');
			$data['status_pa']=0;
			$data['jadwal_pa']=date("Y-m-d");
			// $data['jadwal_pa']=$this->input->post('jadwal');
		}
		if ($this->input->post('rad')!=null) 
		{	
			$data['rad']=$this->input->post('rad');
			$data['status_rad']=0;
			$data['jadwal_rad']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		}
		if ($this->input->post('obat')!=null)
		{
			$data['obat']=$this->input->post('obat');
			$data['status_obat']=0;
		}
		if ($this->input->post('fisio')!=null)
		{
			$data['fisio']=$this->input->post('fisio');
			$data['status_fisio']=0;
		}
		if ($this->input->post('em')!=null) 
		{	
			$data['em']=$this->input->post('em');
			$data['status_em']=0;
			$data['jadwal_em']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		}

		print_r($data);
		
		$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);
		
		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
                       	</div>';
		
		
		$this->session->set_flashdata('success_msg', $success);
		
		redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
	}
	
	public function hapus_sep($no_sep='') {
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;				
		if($no_sep==''){
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				//redirect('ird/rdcregistrasi/kelola_sep' ,'refresh');			
		}
		else {
		$url = $data_bpjs->service_url;
        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   // 'Content-type: application/xml',
			   // 'Content-type: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
				$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		  		$data = array(
		   		'request'=>array(
		   		't_sep'=>array(
		   			'noSep' => $no_sep,
		   			'ppkPelayanan' => $ppk_pelayanan
		   			)
		   		)
		   		);
    	   		$datasep=json_encode($data);				
         		// print_r($datasep);exit; ///////////////////////////////////////
			    $ch = curl_init($url . 'SEP/Delete');
			    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
             	curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);          
             	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              	$result = curl_exec($ch);
             	curl_close($ch);
             	if($result!=''){//valid koneksi internet
		     	$sep = json_decode($result);
         		// print_r($sep->response);exit; ///////////////////////////////////////
		     	if ($sep->metadata->code == '800') {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);		     
				//redirect('ird/rdcregistrasi/kelola_sep' ,'refresh');
		     	}
				if ($sep->metadata->code == '200') {

					$id=$this->M_update_sepbpjs->update_hapus_SEP($no_sep);
				// $data_update = array(
    //     		'no_sep' => NULL
    //   			);				
				// $this->M_update_sepbpjs->delete_sep($no_register,$no_sep,$data_update);					
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP <b>'.$sep->response.'</b> berhasil dihapus.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				//redirect('ird/rdcregistrasi/kelola_sep' ,'refresh');				
			}
				else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									'.$sep->metadata->message.'.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				//redirect('ird/rdcregistrasi/kelola_sep' ,'refresh');	
			}
		 }
		 		else{
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				//redirect('ird/rdcregistrasi/kelola_sep' ,'refresh');						 			
		 		}
		}
	}
	// //--------------------------------------------------------------------------------------------------LAB
	// public function insert_pemeriksaan() //insert LAB
	// {
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['id_tindakan']=$this->input->post('idtindakan');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
	// 	$data_tindakan=$this->labmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['jenis_tindakan']=$row->nmtindakan;
	// 	}
	// 	$data['qty']=$this->input->post('qty_lab');
	// 	$data['id_dokter']=$this->input->post('id_dokter');
	// 	$data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
	// 	foreach($data_dokter as $row){
	// 		$data['nm_dokter']=$row->nm_dokter;
	// 	}
	// 	$data['biaya_lab']=$this->input->post('biaya_lab_hide');
	// 	$data['vtot']=$this->input->post('vtot_lab_hide');
	// 	$data['idrg']=$id_poli;
	// 	//$data['bed']=$this->input->post('bed');
	// 	$data['no_lab']=$this->input->post('no_lab');
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
		
	// 	if($data['no_lab']!=''){
	// 	} else {
	// 		//$this->labmdaftar->insert_data_header($no_register,$data['idrg'],$data['bed'],$data['kelas_pasien']);
	// 		$this->labmdaftar->insert_data_header($data['no_register'],$id_poli,'',$data['kelas']);
	// 	}
	// 	$data['no_lab']=$this->labmdaftar->get_data_header($data['no_register'],$id_poli,'',$data['kelas'])->row()->no_lab;


	// 	$this->labmdaftar->insert_pemeriksaan($data);
		
	// 	$tab="lab";
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_lab']);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register'].'/'.$data['no_lab']);
	// 	//print_r($data);
	// }

	// public function hapus_data_pemeriksaan($id_poli='', $no_register='', $tab='', $no_lab='', $id_pemeriksaan_lab='')
	// {
	// 	$id=$this->labmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_lab);

	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab.'/'.$no_lab);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$no_lab);
	// }
	
	// public function selesai_daftar_pemeriksaan($id_poli='', $no_register='', $tab='')
	// {
	// 	$getvtotlab=$this->labmdaftar->get_vtot_lab($no_register)->row()->vtot_lab;
		
	// 	//update vtot_lab di daftar ulang ird
	// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotlab);
		
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// 	//redirect('lab/Labcdaftar/');
	// }
	//--------------------------------------------------------------------------------------------------END LAB
	
	// //--------------------------------------------------------------------------------------------------RESEP
	// public function insert_resep()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');
		
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunjungan');
	// 	$data['item_obat']=$this->input->post('obat');
	// 	$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['nama_obat']=$row->nm_obat;
	// 		$data['Satuan_obat']=$row->satuank;
	// 	}
	// 	$data['idrg']=$id_poli;
	// 	$data['bed']='';
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
	// 	$data['no_resep']=$this->input->post('no_resep');
	// 	$data['qty']=$this->input->post('qtyResep');
	// 	$data['Signa']=$this->input->post('signa');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['biaya_obat']=$this->input->post('biaya_obat_hide');
	// 	$data['vtot']=$this->input->post('vtot_resep_hide');
	// 	$get_data_markup=$this->Frmmdaftar->get_data_markup()->result();
	// 	foreach($get_data_markup as $row){
	// 		//$data['kdmarkup']=$row->kodemarkup;
	// 		//$data['ketmarkup']=$row->ket_markup;
	// 		$data['fmarkup']=$row->markup;
	// 	}	
	// 	$data['ppn']=1.1;

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 	$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}
		
	// 	$this->Frmmdaftar->insert_permintaan($data);
		
	// 	$tab="resep";
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_resep']);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// }
	
	// public function hapus_data_resep($id_poli='', $no_register='', $no_lab='', $id_resep_pasien='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);
		
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_lab);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep');
	// }
	
	// public function selesai_daftar_resep()
	// {
	// 	$no_register=$this->input->post('no_register');
	// 	$id_poli=$this->input->post('id_poli');
	// 	$no_resep=$this->input->post('no_resep');
		
	// 	//update daftar ulang ird
	// 	$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
	// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);
		
	// 	//$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	// 	echo '<script type="text/javascript">window.open("'.site_url("ird/Rjcpelayanan/cetak_faktur_obat/$no_resep").'", "_blank");window.focus()</script>';
		
	// 	redirect('ird/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep','refresh');
	// 	//redirect('farmasi/Frmcdaftar/','refresh');
		
	// }

	// public function insert_racikan()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');
		
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['item_obat']=$this->input->post('idracikan');
	// 	$data['idrg']=$id_poli;
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['bed']='';
	// 	$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['nama_obat']=$row->nm_obat;
	// 		$data['Satuan_obat']=$row->satuank;
	// 	}
	// 	$data['qty']=$this->input->post('qty_racikan');
	// 	$data['no_resep']=$this->input->post('no_resep');

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 		$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}
		
	// 	$this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
		
	// 	redirect('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep'].'/racik');
	// 	//print_r($data);
	// }

	// public function hapus_data_racikan($no_register='', $no_resep='', $item_obat='', $id_resep_pasien='',$id_poli='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_racikan($item_obat, $id_resep_pasien);

	// 	redirect('ird/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_resep.'/racik','refresh');
		
	// 	//print_r($id);
	// }

	// public function insert_racikan_selesai()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');
		
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kun');
	// 	$data['idrg']=$id_poli;
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
	// 	$data['bed']='';
	// 	$data['no_resep']=$this->input->post('no_resep');
	// 	$data['qty']=$this->input->post('qty1');
	// 	$data['Signa']=$this->input->post('signa');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	//$data['biaya_obat']=$this->input->post('biaya_obat_hide');//sum dari db
	// 	$data['fmarkup']=$this->input->post('fmarkup');// dari db
	// 	$data['ppn']=1.1;
	// 	$data['vtot']=$this->input->post('vtot_x_hide');
	// 	$data['nama_obat']=$this->input->post('racikan');
	// 	$data['racikan']='1';
	// 	$data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik($data['no_resep'])->result();
	// 	foreach($data_biaya_racik as $row){
	// 		$data['biaya_obat']=$row->total;
	// 	}

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 		$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}
		

	// 	$this->Frmmdaftar->insert_permintaan($data);
	// 	$id_resep_pasien=$this->rdmpelayanan->get_id_resep($data['no_resep'])->row()->id_resep_pasien;
	// 	$this->Frmmdaftar->update_racikan($data['no_resep'], $id_resep_pasien);
		
	// 	redirect('ird/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// 	//print_r($data);
	// }
	public function cetak_faktur_obat($no_resep='')
	{
		if($no_resep!=''){
			$cterbilang=new rdcterbilang();
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamat=$row->alamat;
			// 	}
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			
			$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$sex=$row->sex;
					$goldarah=$row->goldarah;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$idrg=$row->idrg;
					//$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
				}

			//$data_permintaan=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			$data_permintaan=$this->rdmpelayanan->get_data_permintaan($no_resep)->result();
	
			$konten=
					"<table>
						<tr>
							<td><p align=\"right\"><b>Tanggal-Jam: $tgl_jam</b></p></td>
						</tr>
						<tr>
							<td><font size=\"12\"><b>$namars</b></font></td>
						</tr>
						<tr>
							<td><b>$alamat</b></td>
						</tr>
					</table>
					<br/><hr/><br/>
					<p align=\"center\"><b>
					FAKTUR PERMINTAAN OBAT<br/>
					No. SKT. FRM_$no_resep
					</b></p><br/>
					<br><br>
					<table>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_register</td>
							<td width=\"15%\"> </td>
							<td width=\"15%\"><b>Cara Bayar</b></td>
							<td width=\"3%\"> : </td>
							<td>$cara_bayar</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Medrec</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_medrec</td>
							<td width=\"15%\"></td>
							<td width=\"15%\"><b>Poliklinik</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"30%\">".$idrg."</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td width=\"30%\">".$nama." / ".$sex." / ".$goldarah."</td>
						</tr>
						<tr>
							<td><b>Untuk Permintaan Obat</b></td>
							<td> : </td>
							<td></td>
						</tr>
					</table>
					<br/><br/>
					<table>
						<tr><hr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"40%\"><p align=\"center\"><b>Nama Item</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Harga</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
						<hr>
					";
					$i=1;
					$jumlah_vtot=0;
					foreach($data_permintaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."<tr>
										  <td><p align=\"center\">$i</p></td>
										  <td>$row->nama_obat</td>
										  <td><p align=\"center\">$row->qty</p></td>
										  <td><p align=\"center\">".number_format( $row->biaya_obat, 2 , ',' , '.' )."</p></td>
										  <td><p align=\"right\">$vtot</P></td>
										  <br>
										</tr>";
						if ($row->racikan=='1') {
							$data_detail_racikan=$this->rdmpelayanan->get_detail_racikan($row->id_resep_pasien)->result();
							
							foreach($data_detail_racikan as $row2){
								$konten=$konten."<tr>
											  <td></td>
											  <td>$row2->nm_obat</td>
											  <td><p align=\"center\">$row2->qty</p></td>
											  <td></td>
											  <td></td>
											  <br>
											</tr>";
							}
						}
						$i++;

					}
					
						$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);

				$konten=$konten."
						<tr><hr><br>
							<th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>".number_format( $jumlah_vtot, 2 , ',' , '.' )."</b></font></p></th>
						</tr>
						
					</table>
					<b><font size=\"10\"><p align=\"right\">Terbilang : " .$vtot_terbilang."</p></font></b>
					<br><br>
					<p align=\"right\">$kota_kab, $tgl</p>
					";
	
			$file_name="SKT_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');
		}
		else{
			redirect('farmasi/Frmckwitansi/','refresh');
		}
	}
	//--------------------------------------------------------------------------------------------------END RESEP

	public function update_dokter(){

		if($this->input->post('id_dokter')!=''){
			$dokter = explode("@", $this->input->post('id_dokter'));
			$data['id_dokter']=$dokter[0];
			$data2['id_dokter']=$dokter[0];
			$data['nm_dokter']=$dokter[1];
		}
		$no_register = $this->input->post('no_register');
		$jalan='1B0101';
		$ugd='1B0108';
		$update1=$this->rdmpelayanan->update_rujukan_penunjang_poli($data, $no_register, 
			$jalan, $ugd);	
		$update2=$this->rdmpelayanan->update_rujukan_penunjang($data2, $no_register);


		echo $update2;
		//echo '<script type="text/javascript">tabeltindakan('.$no_register.'); </script>';

	}
// <table>
// 						<tr>
// 							<td width=\"20%\"><b>No. Registrasi</b></td>
// 							<td width=\"3%\"> : </td>
// 							<td>$no_register</td>
// 							<td width=\"15%\"> </td>
// 							<td width=\"15%\"><b>Cara Bayar</b></td>
// 							<td width=\"3%\"> : </td>
// 							<td>$cara_bayar</td>
// 						</tr>
// 						<tr>
// 							<td width=\"20%\"><b>No. Medrec</b></td>
// 							<td width=\"3%\"> : </td>
// 							<td>$no_medrec</td>
// 							<td width=\"15%\"></td>
// 							<td width=\"15%\"><b>Poliklinik</b></td>
// 							<td width=\"3%\"> : </td>
// 							<td width=\"30%\">".$idrg."</td>
// 						</tr>
// 						<tr>
// 							<td><b>Nama Pasien</b></td>
// 							<td> : </td>
// 							<td width=\"30%\">".$nama." / ".$sex." / ".$goldarah."</td>
// 						</tr>
// 						<tr>
// 							<td><b>Untuk Permintaan Obat</b></td>
// 							<td> : </td>
// 							<td></td>
// 						</tr>
// 					</table>
// 					<br/><br/>
// 					<table>
// 						<tr><hr>
// 							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
// 							<th width=\"40%\"><p align=\"center\"><b>Nama Item</b></p></th>
// 							<th width=\"20%\"><p align=\"center\"><b>Banyak</b></p></th>
// 							<th width=\"15%\"><p align=\"center\"><b>Harga</b></p></th>
// 							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
// 						</tr>
// 						<hr>

	public function cetak_surat_keterangan_st()
	{
		$no_register=$this->input->post('no_register');
		
		$amphe=$this->input->post('amphe');
		$opiat=$this->input->post('opiat');
		$thc=$this->input->post('thc');
		$kets=$this->input->post('ket');
		$hasil=$this->input->post('hasil');
		$nosur=$this->input->post('nosur');
		$bulan=$this->input->post('bulan');
		$this->session->set_userdata(array(
		  
		    'no_reg_extra' => $no_register,
		    'thc_extra' => $thc,
		    'amphe_extra' => $amphe,
		    'opiat_extra' => $opiat,
		    'kets' => $kets,
		    'hasil' => $hasil, 
		    'nosur' => $nosur, 
		    'bulan' => $bulan, 
		    
		    /*,
		    'groupid'  => $user->groupid,
		    'date'     => $user->date_cr,
		    'serial'   => $user->serial,
		    'rec_id'   => $user->rec_id,
		    'status'   => TRUE*/
		));
		if($no_register!=''){
			echo '<script type="text/javascript">window.open("'.site_url("ird/rdcpelayanan/cetak_surat_keterangan").'", "_blank");window.focus()</script>';
		}
		//document.cookie = "no_register='.$no_register.'"; document.cookie = "a=\'a\'"; 
	}

	public function cetak_surat_keterangan()
	{
		
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$thn=date("Y");

			// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamat=$row->alamat;
			// 	}
			 $namars=$this->config->item('namars');
			 $alamat=$this->config->item('alamat');
			 $kota_kab=$this->config->item('kota');
			 $no_register=$this->session->userdata('no_reg_extra');
			
			 $thc=$this->session->userdata('thc_extra');
			 $amphe=$this->session->userdata('amphe_extra');
			 $opiat=$this->session->userdata('opiat_extra');
			 $keterangan=$this->session->userdata('kets');
			 $hasil=$this->session->userdata('hasil');
			 $nosur=$this->session->userdata('nosur');
			 $bulan=$this->session->userdata('bulan');
			 //$no_register=$_COOKIE['no_register'];//$this->input->post('no_register');
			 //$a=$_COOKIE['a'];//$this->input->post('a');
			// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			// 	foreach($data_pasien as $row){
			// 		$nama=$row->nama;
			// 		$sex=$row->sex;
			// 		$goldarah=$row->goldarah;
			// 		$no_register=$row->no_register;
			// 		$no_medrec=$row->no_medrec;
			// 		$idrg=$row->idrg;
			// 		//$bed=$row->bed;
			// 		$cara_bayar=$row->cara_bayar;
			// 	}

			$dokter=$this->rdmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
			$data_permintaan=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$kontens=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					.table-font-size1{
						font-size:13px;
					    }
					.table-font-size2{
						font-size:10px;
						margin : 5px 1px 1px 1px;
						padding : 3px 1px 1px 1px;
					    }
					</style>
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:13px\">$namars</font></b><br><br>$alamat $kota_kab
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr>
							<td></td>
							<td colspan=\"0\"><p align=\"center\"><b><u>SURAT KETERANGAN BEBAS NARKOBA<br></u></b>
							NO.SKET/".$nosur."/NAPZA/".$bulan."/".$thn."</p>
							</td>
						</tr>
						
					</table>
					<table class=\"table-font-size2\">
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">
							Yang bertanda tangan dibawah ini menerangkan bahwa					
							</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Nama</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".ucwords (strtolower($data_permintaan->nama))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Tempat / Tanggal lahir </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($data_permintaan->tmpt_lahir)).", ".date('d-m-Y',strtotime($data_permintaan->tgl_lahir))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Jenis Kelamin	 </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".ucwords(strtolower(($data_permintaan->sex=='L'? 'Laki-laki':($data_permintaan->sex=='P'? 'Perempuan':'LAKI-LAKI / PEREMPUAN'))))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Alamat</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">".strtolower($data_permintaan->alamat)."</td>
						</tr>
						
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Saat ini dari hasil pemeriksaan urine yang bersangkutan <b>".ucwords($hasil)."</b> : </td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">THC</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($thc))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">Opiat</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($opiat))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">Amphetamin</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($amphe))."</td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Keterangan ini diberikan untuk <b>".$keterangan."</b></td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Harap yang berkepentingan maklum adanya</td>
						</tr>
					</table>

					<table style=\"width:100%;\">
						<tr>
							<td width=\"70%\" ></td>
							<td width=\"30%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>a.n. Kepala Rumkital Dr. Mintohardjo 
								<br>Perwira Kesehatan <br>  
								<br><br><br>
								".((int)$dokter==60? '
									<u>Kol(Purn)dr.Eunice.P.N.Psikiater</u><br>
									SIP.20/2.104/31.71.07/-1.779.3/e/2016 '
									:((int)$dokter==61? '
									<u>Kol(Purn)dr.Pramudya.P.Psikiater</u><br>
									SIP.23/2.104/31.71.07/-1.779.3/e/2016 '
									:((int)$dokter==185? '
									<u>dr.Fransiska Drie N. SpKJ</u><br>
									Kapten Laut (K/W) NRP. 15729/P'
									:((int)$dokter==62? '
									<u>dr. Rudyhard E. Hutagalung, Sp.KJ</u><br>
									Letkol Laut (K) NRP 14087/P '
									:
									'<u>dr.Eliyati D.Rosadi,SpKJ (K)</u><br>
									SIP.12/2.104/31.71.07/-1.779.3/e/2017'))))."
								</p>
							</td>
						</tr>	
					</table>
					";
			
					
			$file_name="SKBN.pdf";
				
				// echo $kontens;
				// break;
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '7', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$contentt = $kontens;
				ob_end_clean();
				$obj_pdf->writeHTML($kontens);
				$obj_pdf->Output(FCPATH.'/download/ird/rdcpelayanan/surat_bebas_narkoba/'.$file_name,'FI');
	
	}
	// <table class=\"table-font-size2\">
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"90%\">
	// 						Yang bertanda tangan dibawah ini menerangkan bahwa  <br>						
	// 						</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Nama</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Umur / Tanggal lahir </td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Jenis Kelamin	 </td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Alamat</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pendidikan</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pekerjaan / Kesatuan</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pangkat & NRP</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Saat ini tidak kami dapatkan adanya psikopatologi tertentu (tidak ada )</td>
	// 					</tr>
	// 				</table>


	public function cetak_surat_keterangan_st_jiwa()
	{
		$no_register=$this->input->post('no_register');
		
		$ketsj=$this->input->post('ket2');
		$hasilj=$this->input->post('hasil2');
		$nosurj=$this->input->post('nosur2');
		$bulanj=$this->input->post('bulan2');
		$this->session->set_userdata(array(
		  
		    'no_reg_extra' => $no_register,
		    'ketssj' => $ketsj,
		    'hasilsj' => $hasilj, 
		    'nosursj' => $nosurj, 
		    'bulansj' => $bulanj, 
		    
		    /*,
		    'groupid'  => $user->groupid,
		    'date'     => $user->date_cr,
		    'serial'   => $user->serial,
		    'rec_id'   => $user->rec_id,
		    'status'   => TRUE*/
		));
		if($no_register!=''){
			echo '<script type="text/javascript">window.open("'.site_url("ird/rdcpelayanan/cetak_surat_keterangan_jiwa").'", "_blank");window.focus()</script>';
		}
		//document.cookie = "no_register='.$no_register.'"; document.cookie = "a=\'a\'"; 
	}

	public function cetak_surat_keterangan_jiwa()
	{
		
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$thn=date("Y");

			// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamat=$row->alamat;
			// 	}
			 $namars=$this->config->item('namars');
			 $alamat=$this->config->item('alamat');
			 $kota_kab=$this->config->item('kota');
			 $no_register=$this->session->userdata('no_reg_extra');
			
			 $keterangan=$this->session->userdata('ketssj');
			 $hasil=$this->session->userdata('hasilsj');
			 $nosur=$this->session->userdata('nosursj');
			 $bulan=$this->session->userdata('bulansj');
			 //$no_register=$_COOKIE['no_register'];//$this->input->post('no_register');
			 //$a=$_COOKIE['a'];//$this->input->post('a');
			// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			// 	foreach($data_pasien as $row){
			// 		$nama=$row->nama;
			// 		$sex=$row->sex;
			// 		$goldarah=$row->goldarah;
			// 		$no_register=$row->no_register;
			// 		$no_medrec=$row->no_medrec;
			// 		$idrg=$row->idrg;
			// 		//$bed=$row->bed;
			// 		$cara_bayar=$row->cara_bayar;
			// 	}

			$dokter=$this->rdmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
			$data_permintaan=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$kontens=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					.table-font-size1{
						font-size:13px;
					    }
					.table-font-size2{
						font-size:10px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:13px\">$namars</font></b><br><br>$alamat $kota_kab
							</td>
							<td width=\"14%\"><font size=\"9\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr>
							<td></td>
							<td colspan=\"0\"><p align=\"center\"><b><u>SURAT KETERANGAN<br></u></b>
							NO.SKET/".$nosur."/KESWA/".$bulan."/".$thn."</p>
							</td>
						</tr>
						
					</table>
					<table class=\"table-font-size2\">
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">
							Yang bertanda tangan dibawah ini menerangkan bahwa					
							</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Nama</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($data_permintaan->nama))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Tempat / Tanggal lahir </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".ucwords(strtolower($data_permintaan->tmpt_lahir.", ".date('d-m-Y',strtotime($data_permintaan->tgl_lahir))))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Jenis Kelamin	 </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".($data_permintaan->sex=='L'? 'Laki-laki':($data_permintaan->sex=='P'? 'Perempuan':'Laki-laki / Perempuan'))."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Alamat</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">".strtolower($data_permintaan->alamat)."</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Pendidikan</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">".$data_permintaan->pendidikan."</td>
						</tr>
						<tr>
						".($data_permintaan->nrp_sbg == 'T' ? '
									<td width=\"15%\"></td>
									<td width=\"20%\">Pekerjaan dan Kesatuan</td>
									<td width=\"2%\">:</td>
									<td width=\"63%\">'.$data_permintaan->pekerjaan. '/ ' .($data_permintaan->kst_id=='' ? ($data_permintaan->kesatuan_ehr) : ($data_permintaan->kst_nama.' | '.$data_permintaan->kst2_nama.' | '.$data_permintaan->kst3_nama)).'</td>
								':'
							<td width=\"15%\"></td>
							<td width=\"20%\">Pekerjaan</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">'.ucwords(strtolower($data_permintaan->pekerjaan)).'</td>
						')."
						</tr>

						<tr>
						".($data_permintaan->nrp_sbg == 'T' ? '
						
							<td width=\"15%\"></td>
							<td width=\"20%\">Pangkat / NRP</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">'.($data_permintaan->pkt_id!=''? ($data_permintaan->pangkat.' / '.$data_permintaan->no_nrp):' ').'</td>
								':'<td> </td>')."
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Saat ini <b>".($hasil=='ada'? 'kami dapatkan': 'tidak kami dapatkan')."</b> adanya psikopatologi tertentu ".($hasil=='ada'? '(ada kelainan dibidang kejiwaan)': '(tidak ada kelainan dibidang kejiwaan)')." </td>
						</tr>
						
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Keterangan ini diberikan untuk <b>".$keterangan."</b></td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Harap yang berkepentingan maklum adanya</td>
						</tr>
					</table>

					<table style=\"width:100%;\">
						<tr>
							<td width=\"70%\" ></td>
							<td width=\"30%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>a.n. Kepala Rumkital Dr. Mintohardjo 
								<br>Perwira Kesehatan <br>  
								<br><br><br>
								".((int)$dokter==60? '
									<u>Kol(Purn)dr.Eunice.P.N.Psikiater</u><br>
									SIP.20/2.104/31.71.07/-1.779.3/e/2016 '
									:((int)$dokter==61? '
									<u>Kol(Purn)dr.Pramudya.P.Psikiater</u><br>
									SIP.23/2.104/31.71.07/-1.779.3/e/2016 '
									:((int)$dokter==185? '
									<u>dr.Fransiska Drie N. SpKJ</u><br>
									Kapten Laut (K/W) NRP. 15729/P '
									:((int)$dokter==62? '
									<u>dr. Rudyhard E. Hutagalung, SpKJ</u><br>
									Letkol Laut (K) NRP 14087/P '
									:
									'<u>dr.Eliyati D.Rosadi,SpKJ (K)</u><br>
									SIP.12/2.104/31.71.07/-1.779.3/e/2017'))))."
								</p>
							</td>
						</tr>	
					</table>
					";
			
					
			$file_name="SKSJ.pdf";
				
				// echo $kontens;
				// break;
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '7', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$contentt = $kontens;
				ob_end_clean();
				$obj_pdf->writeHTML($kontens);
				$obj_pdf->Output(FCPATH.'/download/ird/rdcpelayanan/surat_jiwa/'.$file_name,'FI');
	
	}
	

	public function pelayanan_tindakan_view($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$data['controller']=$this; 
		$data['view']=1; 
		// cek rujukan penunjang
		$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
		
		//cek status lab dan resep
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$result=$this->rdmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab=="0" || $result->status_lab=="1") {
			$data['a_lab'] = "closed";
		}
		if ($result->pa=="0" || $result->status_pa=="1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat=="0" || $result->status_obat=="1") {
			$data['a_obat'] = "closed";
		} 
		if ($result->rad=="0" || $result->status_rad=="1") {
			$data['a_rad'] = "closed";
		} 
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}
		
		//ambil data runjukan
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_medrecrad)->result();	
		$data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_medrecrad)->result();	
		$data['list_pa_pasien']=$this->rdmpelayanan->getdata_pa_pasien($no_medrecrad)->result();	
		$data['cetak_pa_pasien']=$this->rdmpelayanan->getcetak_pa_pasien($no_medrecrad)->result();		
		$data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_medrecrad)->result();	
		$data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_medrecrad)->result();
		$data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_medrecrad)->result();	
		$data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_medrecrad)->result();		

		// $no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row();
		// $data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_register)->result();	
		// $data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_register)->result();	
		// $data['list_pa_pasien']=$this->rdmpelayanan->getdata_pa_pasien($no_register)->result();	
		// $data['cetak_pa_pasien']=$this->rdmpelayanan->getcetak_pa_pasien($no_register)->result();		
		// $data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_medrecrad)->result();	
		// $data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_register)->result();
		// $data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_register)->result();	
		// $data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_register)->result();
		
		//get id_poli & no_medrec	
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['bed']='Rawat Jalan';
			
		$data['data_diagnosa_pasien']=$this->rdmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien']=$this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['id_poli']=$id_poli;
		
		$nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Rawat Jalan | '.$nm_poli;
		
		$data['poliklinik']=$this->rdmpencarian->get_poliklinik()->result();
		$data['tindakan']=$this->rdmpelayanan->get_tindakan($data['kelas_pasien'], substr($id_poli,0,2))->result(); //get tindakan yang ada pada tabel tarif dan sesuai kelas
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli($id_poli)->result();
		$data['diagnosa']=$this->rdmpencarian->get_diagnosa()->result();
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;		
		//data untuk tab laboratorium------------------------------
		$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_lab']=$this->labmdaftar->getdata_dokter()->result();
		$data['tindakan_lab']=$this->labmdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab patalogi anatomi------------------------------
		$data['data_pemeriksaan']=$this->pamdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_pa']=$this->pamdaftar->getdata_dokter()->result();
		$data['tindakan_pa']=$this->pamdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab radiologi---------------------------------------
		$data['dokter_rad']=$this->radmdaftar->getdata_dokter()->result();
		$data['tindakan_rad']=$this->radmdaftar->getdata_tindakan_pasien()->result();		
		$data['data_tindakan_racikan']='';
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($data['no_medrec'])->result();
		
		//data untuk tab obat--------------------------------------------
		$result=$this->rdmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rdmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();

		/*$data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
		foreach($data['get_data_markup'] as $row){
			$data['kdmarkup']=$row->kodemarkup;
			$data['ketmarkup']=$row->ket_markup;
			$data['fmarkup']=$row->markup;
		}
		$data['ppn']=1.1;*/
		//---------------------------------------------------------
		$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
        
		//print_r($data['data_fisik']);die();
        // var_dump($data['data_fisik']);die();

		if ($data['data_fisik']==FALSE) {
			$data['td']='';
			$data['bb']='';
			$data['tb']='';
			$data['nadi']='';
			$data['suhu']='';
			$data['rr']='';
			//$data['ku']='';
	
			$data['catatan'] = '';

			$data['subjective'] = '';
			$data['objective'] = '';
			$data['assesment'] = '';
			$data['plan'] = '';
			$data['tindakan'] = '';
			$data['diag_kerja'] = '';
			$data['diag_banding'] = '';

		
		} else {
			$data['td']=$data['data_fisik']->td;
			$data['bb']=$data['data_fisik']->bb;
			$data['tb']=$data['data_fisik']->tb;
			$data['nadi']=$data['data_fisik']->nadi;
			$data['suhu']=$data['data_fisik']->suhu;
			$data['rr']=$data['data_fisik']->rr;
			//$data['ku']=$data['data_fisik']->ku;
			$data['catatan']=$data['data_fisik']->catatan;

			$data['subjective'] = $data['data_fisik']->subjective;
			$data['objective'] = $data['data_fisik']->objective;
			$data['assesment'] = $data['data_fisik']->assesment;
			$data['plan'] = $data['data_fisik']->plan;
			$data['tindakan'] = $data['data_fisik']->tindakan;
			$data['diag_kerja'] = $data['data_fisik']->diag_kerja;
			$data['diag_banding'] = $data['data_fisik']->diag_banding;
		}
		
		$result=$this->rdmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rdmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rdmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rdmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rdmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rdmpelayanan->get_no_rad($no_register)->row()->no_rad);

		if ($tab=='' || $tab=='tindakan') {
			$data['tab_tindakan']="active";
			$data['tab_fisik']="";
			$data['tab_diagnosa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="";
			$data['tab_rad']="";
			$data['tab_resep']="";
			$data['tab_obat'] = "";
			$data['tab_racikan']="";
		} else if ($tab=="fis")
		{
			$data['tab_tindakan']="";
			$data['tab_diagnosa']="";
			$data['tab_fisik']="active";
			$data['tab_pa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_obat']="";
			$data['tab_racikan']="";
		
		} else if ($tab=="diag")
		{
			$data['tab_tindakan']="";
			$data['tab_diagnosa']="active";
			$data['tab_fisik']="";
			$data['tab_pa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_obat']="";
			$data['tab_racikan']="";
		
		} else if ($tab=="lab")
		{
			$data['no_lab']=$param3;
			$data['tab_tindakan']="";
			$data['tab_fisik']="";
			$data['tab_diagnosa']="";
			$data['tab_lab']="active";
			$data['tab_pa']="";
			$data['tab_rad']="";
			/*if($no_lab!='')
			{
				$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register, $no_lab)->result();										
				$data['no_lab']=$no_lab;
			}else {	if($this->labmdaftar->get_data_pemeriksaan($no_register)->row()->no_lab!=''){
					$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_pemeriksaan']='';
				}
			}
			*/
		
			$data['tab_resep']="";
			$data['tab_obat'] = "";
			$data['tab_racikan']="";
	
		} else if ($tab=="pa")
		{
			$data['no_pa']=$param3;
			$data['tab_tindakan']="";
			$data['tab_fisik']="";
			$data['tab_diagnosa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="active";
			$data['tab_rad']="";
			/*if($no_lab!='')
			{
				$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register, $no_lab)->result();										
				$data['no_lab']=$no_lab;
			}else {	if($this->labmdaftar->get_data_pemeriksaan($no_register)->row()->no_lab!=''){
					$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_pemeriksaan']='';
				}
			}
			*/
		
			$data['tab_resep']="";
			$data['tab_obat'] = '';
			$data['tab_racikan']="";
	
		} else if($tab=='rad'){

			$no_rad=$param3;			
			if($no_rad!='')
			{		
				$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
				$data['no_rad']=$no_rad;
			}else{
				if($this->radmdaftar->get_data_pemeriksaan($no_register)->row()->no_rad!=''){
					$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_rad_pasien']='';
				}//$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
				
			}
			$data['tab_tindakan']="";
			$data['tab_fisik']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="";
			$data['tab_rad']="active";			
			$data['tab_resep']="";
			$data['tab_diagnosa']="";
			$data['tab_obat'] = 'active';
			$data['tab_racikan']  = '';
		}else if ($tab=="resep")
		{
			$no_resep=$param3;
			$data['tab_tindakan']="";
			$data['tab_fisik']="";
			$data['tab_diagnosa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="";
			$data['tab_rad']="";
			$data['tab_resep']="active";
			if($no_resep!='')
			{		

				$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();						
				$data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
				$data['no_resep']=$no_resep;
			}else{
				if($this->rdmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
					$data['no_resep']=$this->rdmpelayanan->getdata_resep_pasien($no_register)->result();
				}else{
					$data['data_obat_pasien']='';
				}
			}
			$data['tab_obat']="active";
			$data['tab_racikan']="";
			if($param4!=''){
				$data['tab_obat']="";
				$data['tab_racikan']="active";
			}
		} 
		if ($data['data_fisik']==FALSE) {
			$data['tab_tindakan']="";
			$data['tab_fisik']="active";
			$data['tab_diagnosa']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="";
			$data['tab_rad']="";
			$data['tab_resep']="";
			$data['tab_obat'] = "";
			$data['tab_racikan']="";
		} 
		
		/*{	
			$data['tab_tindakan']="";
			$data['tab_diagnosa']="active";	
		}
		*/
		$this->load->view('ird/rdvpelayanan_view',$data);
	}	

		public function list_rawat_jalan()
	{
		$data['title'] = 'List Pasien Rawat Jalan '.date('d-m-Y');
		$data['cara_bayar']=$this->rdmpencarian->get_cara_bayar()->result();
		$data['pasien_daftar']=$this->rdmpencarian->get_list_rawat_jalan()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='22'){
			$data['access']=1;
		}else{
			$data['access']=0;
		}
		// $data['id_poli']=$id_poli;
		if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		
		$this->load->view('ird/rdvlistrawatjalan',$data);
	}

	public function get_data_by_register(){
		$no_register=$this->input->post('no_register');
		$datajson=$this->rdmpencarian->get_data_by_register($no_register)->result();
	    echo json_encode($datajson);
	}
	public function edit_cara_bayar(){
		$no_register=$this->input->post('no_reg_hidden');
		$data['cara_bayar']= $this->input->post('cara_bayar');
		$data['id_kontraktor'] = $this->input->post('id_kontraktor');
		if($data['cara_bayar'] == "UMUM"){
			$data['id_kontraktor'] ="";
		}else if($data['cara_bayar'] == "BPJS"){
			$data['id_kontraktor'] ="301";
       }
	//	print_r($data);die();
		$this->rdmpencarian->edit_cara_bayar($no_register, $data);
		
		redirect('ird/rdcpelayanan/list_rawat_jalan');
		//print_r($data);
	}

	public function cetak_resume($no_cm=''){
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		
		$data['data_pasien_ird'] = $this->rdmregistrasi->get_data_ringkas_medik_rj($no_cm)->result();
		$this->load->view('CETAK_RESUME',$data);
	}

	public function surat_kontrol($no_register = ''){
		$data['data_kontrol'] = $this->rdmpelayanan->get_v_data_kontrol($no_register);
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		// var_dump($data['data_kontrol']);
		
		$this->load->view('SURAT_KONTROL',$data);
	}

	public function surat_konsul($no_register = ''){
		// $data['data_kontrol'] = $this->rdmpelayanan->get_v_data_kontrol($no_register);
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		// var_dump($data['data_kontrol']);
		$no_cm = $this->rdmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
		$no_regis_lama = $this->rdmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
		$data['data_pasien']=$this->rdmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();
				
		$data['data_konsul'] = $this->rdmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->result();
		
		$id_dokter_asal = $this->rdmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_asal;
		$id_dokter_akhir = $this->rdmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_akhir;
		$id_poli_asal = $this->rdmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_asal;
		$id_poli_akhir = $this->rdmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_akhir;

		$data['dokter_asal'] = $this->rdmpelayanan->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;
		$data['poli_asal'] = $this->rdmpelayanan->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
		$data['dokter_akhir'] = $this->rdmpelayanan->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
		$data['poli_akhir'] = $this->rdmpelayanan->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;

		$data['konsul_dokter'] = 'konsul';

		$this->load->view('LEMBAR_KONSUL',$data);
	}

	public function surat_jawaban_konsul($no_register = ''){
		// $data['data_kontrol'] = $this->rdmpelayanan->get_v_data_kontrol($no_register);
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		// var_dump($data['data_kontrol']);
		
		$no_cm = $this->rdmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
		// var_dump($no_register);
		// var_dump($no_cm);
		// die();
		$no_regis_lama = $this->rdmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
		$data['data_pasien']=$this->rdmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();

		$data['data_konsul'] = $this->rdmpelayanan->get_data_jawab_konsul_by_noreg($no_regis_lama)->result();

		$data['konsul_dokter'] = 'jawab';
		$this->load->view('LEMBAR_KONSUL',$data);
	}

	public function cetak_asesmen_awal_keperawatan($no_cm='',$no_register = ''){
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('no_register');
		//var_dump($no_reg);die();
        $data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['asesmen_keperawatan'] = $this->rdmpelayanan->get_data_asesmen_keperawatan($no_register)->result();
		$data['kode_document'] = $this->rdmpelayanan->get_kode_document('assesment_keperawatan_ird');
		// var_dump( $data['asesmen_keperawatan']);die();
        $data['asesmen_masalah_keperawatan'] = $this->rdmpelayanan->get_data_asesmen_masalah_keperawatan($no_register)->result();
        $data['data_pasien']=$this->rdmpelayanan->get_data_pasien_by_no_cm($no_cm)->result();
        //$data['data_rawat_jalan'] = $this->rdmpelayanan->getdata_record_pasien_by_no_reg($no_register)->result();
		$data['data_rawat_darurat'] = $this->rdmpelayanan->getdata_record_pasien_by_no_reg($no_register)->result();
        $data['keperawatan'] = $this->rdmpelayanan->get_data_asesmen_keperawatan_ird($no_register)->result();
        $data['pemeriksaan_fisik'] = $this->rdmpelayanan->get_pemeriksaan_fisik($no_register);
        $this->load->view('emedrec/rd/formassesmentkeperawatan/assesment_keperawatan',$data);
    }

	public function insert_assesment_gigi(){
		// var_dump($this->input->post('imagegigi'));
		// die();
		if($this->input->post('imagegigi')){
			// var_dump('imagegigi');
			// die();
			$data['no_register'] = $this->input->post('no_register');
			$data['imagegigi'] = $this->input->post('imagegigi');
			// var_dump($data);
			// die();
			return $this->rdmpelayanan->update_assesment_gigi($data);
		}else{
			$data = $this->input->post();
			if($data['adaalergiobat']){
				$data['alergi_obat'] = $data['adaalergiobat'];
			}
			if($data['adaalergimakan']){
				$data['alergi_makan'] = $data['adaalergimakan'];
			}
			if($data['diastema_value']){
				$data['diastema'] = $data['diastema_value'];
			}
			if($data['gigianomali_value']){
				$data['gigi_anomali'] = $data['gigianomali_value'];;
			}
			unset($data['gigianomali_value']);
			unset($data['diastema_value']);
			unset($data['adaalergimakan']);			
			unset($data['adaalergiobat']);
			// cek available data in db
			$check_data = $this->rdmpelayanan->load_data_assesment_gigi_by_noreg($data['no_register']);
			if($check_data){
				return $this->rdmpelayanan->update_assesment_gigi($data);
			}else{
				return $this->rdmpelayanan->insert_assesment_gigi($data);
			}
		}
		
		
		
	}

	public function rekam_medik_gigi($no_register = ''){
		
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;

		$this->load->view('formgigi/rekam_medik_gigi',$data);
	}

	public function triase_ird($id_poli = 'BA00')
	{
		$data['title'] = 'List Pasien Instalasi Rawat Darurat | '.date('d-m-Y');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32'){
			$data['access']=1;
		}else{
			$data['access']=0;
		}
		$data['pasien_daftar']=$this->rdmpencarian->get_pasien_daftar_today($id_poli)->result();
		$get_nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->result();
			foreach($get_nm_poli as $row){
				$data['nma_poli']=$row->nm_poli;
			}
		
		$data['id_poli']=$id_poli;
		if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}

		$data['triase'] = '1';
		$this->load->view('ird/rdvpasienpoli',$data);
	}

	public function pelayanan_triase_ird($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$data['pelayan'] = 'PERAWAT';
		// load data jika poli gigi (BG00)
		$data['assesment_medik_igd'] = '';
		$data['triase'] = '';
		$data['assesment_keperawatan'] = '';
		$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
		($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';

		$datenow = date('Y-m-d');
		$triase = $this->rdmpelayanan->get_triase_by_noreg($no_register);
		($triase->num_rows() >= 1)?$data['triase'] = $triase->result():'';
		if($id_poli == 'BG00'){
			$data['gigi'] = $this->rdmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}

		$data['id_poli'] = $id_poli;
		$data['controller']=$this; 
		$data['view']=0; 
		$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['rujukan_penunjang_2']=$this->rdmpelayanan->get_rujukan_penunjang_pending($no_register)->row();
		if(empty($data['rujukan_penunjang_2'])){
			$array_penunjang = array('lab' => 0, 'rad' => 0, 'pa' => 0, 'ok' => 0, 'fisio' => 0, 'em' => 0);
			$data['rujukan_penunjang_2'] = (object) $array_penunjang;
		}
		
		$data['kerja']=$this->rdmpencarian->get_pekerjaan()->result();
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$data['a_em']="open";
		$result=$this->rdmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab=="0" || $result->status_lab=="1") {
			$data['a_lab'] = "closed";
		}
		if ($result->ok=="0" || $result->status_ok=="1") {
			$data['a_ok'] = "closed";
		}
		if ($result->pa=="0" || $result->status_pa=="1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat=="0" || $result->status_obat=="1") {
			$data['a_obat'] = "closed";
		} 
		if ($result->rad=="0" || $result->status_rad=="1") {
			$data['a_rad'] = "closed";
		}
		if ($result->fisio=="0" || $result->status_fisio=="1") {
			$data['a_fisio'] = "closed";
		}
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}
		//ambil data runjukan
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;

		$data['list_ok_pasien']=$this->rdmpelayanan->getdata_ok_pasien($no_medrecrad)->result();

		$data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_medrecrad,$datenow)->result();	
		$data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_medrecrad)->result();

		$data['list_pa_pasien']=$this->rdmpelayanan->getdata_pa_pasien($no_medrecrad)->result();	
		$data['cetak_pa_pasien']=$this->rdmpelayanan->getcetak_pa_pasien($no_medrecrad)->result();	

		$data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_medrecrad,$datenow)->result();	
		$data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_medrecrad)->result();

		$data['list_em_pasien']=$this->rjmpelayanan->getdata_em_pasienrj($no_medrecrad,$datenow)->result();	
		$data['cetak_em_pasien']=$this->rjmpelayanan->getcetak_em_pasien($no_medrecrad)->result();

		$data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_medrecrad,$datenow)->result();	
		$data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_medrecrad)->result();

		$data['list_fisio_pasien']=$this->rdmpelayanan->getdata_fisio_pasien($no_medrecrad)->result();	
		$data['cetak_fisio_pasien']=$this->rdmpelayanan->getcetak_fisio_pasien($no_medrecrad)->result();
		
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		//get id_poli & no_medrec	
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_pasien']=$this->rdmpelayanan->getdata_pasien($no_medrecrad)->row();
		// print_r($data['data_pasien_daftar_ulang']);die();	
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
			$data['bed']='Rawat Jalan';
		$data['idpokdiet']='';
		if($this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}
		
		$data['data_diagnosa_pasien']=$this->rdmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien']=$this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['id_poli']=$id_poli;
		$nm_poli=$this->rdmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="'.site_url('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli).'">Kembali</a>';
		
		$data['poliklinik']=$this->rdmpencarian->get_poliklinik()->result();
		if($id_poli=='BA00'){
			$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result(); 		
		}
		else{
			$data['tindakans']=$this->rdmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get 
		}
		
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli($id_poli)->result();
			$data['dokter_tindakan2']=$this->rdmpelayanan->get_dokter_poli2($id_poli)->result();
		$data['diagnosa']=$this->rdmpencarian->get_diagnosa()->result();
		
		//data untuk tab laboratorium------------------------------
		$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_lab']=$this->labmdaftar->getdata_dokter()->result();
		$data['tindakan_lab']=$this->labmdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab patalogi anatomi------------------------------
		$data['data_pemeriksaan']=$this->pamdaftar->get_data_pemeriksaan($no_register,$data['no_medrec'])->result();
		$data['dokter_pa']=$this->pamdaftar->getdata_dokter()->result();
		// $data['tindakan_pa']=$this->pamdaftar->getdata_tindakan_pasien()->result();
		
		//data untuk tab radiologi---------------------------------------
		$data['dokter_rad']=$this->radmdaftar->getdata_dokter()->result();
		$data['tindakan_rad']=$this->radmdaftar->getdata_tindakan_pasien()->result();		
		$data['data_tindakan_racikan']='';
		$no_medrec=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_medrec)->result();
		
		//data untuk tab obat--------------------------------------------
		$result=$this->rdmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rdmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();

	
		$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
		$data['data_keperawatan']=$this->rdmpelayanan->getdata_keperawatan($no_register)->result();
		
	
		// var_dump($data['masalah_keperawatan_add'][3]);die();
		// if ($data['data_keperawatan'] == FALSE){
		// 	$data['masalah_keperawatan_add'] = '';
		// 	$data['hasil_keperawatan_add'] = '';
		// } else {
		// 	$data['masalah_keperawatan_add'] = $data['data_keperawatan']->masalah_keperawatan;
		// 	$data['hasil_keperawatan_add'] = $data['data_keperawatan']->hasil_keperawatan;

		// }
		if ($data['data_fisik'] == FALSE) {
			// ADDED KEADAAN UMUM , KESADARAN PASIEN
			$data['lokasi_nyeri'] = '';
			$data['keadaan_umum'] = '';
			$data['kesadaran_pasien'] = '';
			$data['lingkar_kepala'] = '';
			// END
			$data['alergi']='';
			$data['riwayat_alergi']='';
			$data['reaksi_alergi'] = '';
			// added
			$data['pengetahuan_edukasi'] = '';
			$data['riwayat_kesehatan'] = '';
			$data['nyeri'] = '';
			$data['skala_nyeri'] = '';
			$data['metode_nyeri'] = '';
			$data['kualitas_nyeri'] = '';
			$data['frekuensi_nyeri'] = '';
			$data['menjalar'] = '';
			$data['durasi_nyeri'] = '';
			$data['fk_minum_obat'] = '';
			$data['fk_istirahat'] = '';
			$data['fk_musik'] = '';
			$data['fk_posisi_tidur'] = '';
			$data['gizi_penurunan_bb'] = '';
			$data['gizi_asupan_makan'] = '';
			$data['penilaian_gizi'] = '';
			$data['stat_sosial_keluarga'] = '';
			$data['stat_psikologis'] = '';
			$data['stat_pernikahan_ekonomi'] = '';
			$data['pekerjaan'] = $data['data_pasien']->pekerjaan;
			$data['skrining_risiko_cedera'] = '';
			$data['fungsional_alat_bantu'] = '';
			$data['alat_bantu'] = '';
			$data['laporan_dokter_alatbantu']= '';
			$data['fungsional_cacat_tubuh']= '';
			$data['masalah_keperawatan[]'] = '';
			$data['kes_keluarga_pas_edukasi'] = '';
			$data['hambatan_edukasi'] = '';
			$data['membutuhkan_penerjemah_edukasi'] = '';
			$data['perawatan_penyakit'] = '';
			$data['cara_minum_obat'] = '';
			$data['diet'] = '';
			$data['alergi'] = '';
			$data['reaksi_alergi'] = '';
			$data['riwayat_alergi'] = '';
			

			
			
			
			
			
			// end
			
			$data['keluhan']='';

			$data['sitolic']='';
			$data['diatolic']='';
			$data['bb']='';

			$data['nadi']='';	
			$data['rr']='';
			$data['suhu']='';

			$data['catatan']='';

			// $data['subjective_perawat'] = '';
			// $data['objective'] = '';
			// $data['assesment'] = '';
			// $data['plan'] = '';
			$data['diag_kerja'] = '';
			$data['diag_banding'] = '';
			$data['plan'] = '';
			$data['tindakan'] = '';
			$data['pem_penunjang'] = '';
			$data['frekuensi_nafas'] = '';

			$data['visus_od'] = '';
			$data['visus_os'] = '';
			$data['kacamata_od'] = '';
			$data['kacamata_os'] = '';

			$data['kedudukan_od'] = '';
			$data['kedudukan_os'] = '';
			$data['palpebra_od'] = '';
			$data['palpebra_os'] = '';
			$data['conjungtiva_od'] = '';
			$data['conjungtiva_os'] = '';
			$data['cornea_od'] = '';
			$data['cornea_os'] = '';
			$data['coa_od'] = '';
			$data['coa_os'] = '';
			$data['pupil_od'] = '';
			$data['pupil_os'] = '';
			$data['lensa_od'] = '';
			$data['lensa_os'] = '';
			$data['humor_od'] = '';
			$data['humor_os'] = '';
			$data['okuli_od'] = '';
			$data['okuli_os'] = '';
			





		} else {
			

			// ADDED KEADAAN UMUM , KESADARAN PASIEN

			$data['keadaan_umum'] = $data['data_fisik']->keadaan_umum;
			$data['kesadaran_pasien'] = $data['data_fisik']->kesadaran_pasien;
			$data['lingkar_kepala'] = $data['data_fisik']->lingkar_kepala;
			// END
			$data['alergi']=$data['data_fisik']->alergi;
			$data['riwayat_alergi']=$data['data_fisik']->riwayat_alergi;
			$data['reaksi_alergi'] = $data['data_fisik']->reaksi_alergi;
			$data['keluhan']=$data['data_fisik']->catatan;

			$data['sitolic']=$data['data_fisik']->sitolic;
			$data['diatolic']=$data['data_fisik']->diatolic;
			$data['bb']=$data['data_fisik']->bb;

			$data['alergi']=$data['data_fisik']->alergi;
			$data['reaksi_alergi']=$data['data_fisik']->reaksi_alergi;
			$data['riwayat_alergi'] = $data['data_fisik']->riwayat_alergi;;

			$data['nadi']=$data['data_fisik']->nadi;
			$data['frekuensi_nafas'] = $data['data_fisik']->frekuensi_nafas;
			// var_dump($data['frekuensi_nafas']);die();
			$data['rr']=$data['data_fisik']->rr;
			$data['suhu']=$data['data_fisik']->suhu;

			$data['catatan']=$data['data_fisik']->catatan;

			// $data['subjective_perawat'] = $data['data_fisik']->subjective_perawat;
			// $data['objective'] = $data['data_fisik']->objective;
			// $data['assesment'] = $data['data_fisik']->assesment;
			// $data['plan'] = $data['data_fisik']->plan;
			$data['tindakan'] = $data['data_fisik']->tindakan;
			$data['diag_kerja'] = $data['data_fisik']->diag_kerja;
			$data['diag_banding'] = $data['data_fisik']->diag_banding;
			$data['pem_penunjang'] = $data['data_fisik']->pem_penunjang;


			// ADDED
			$data['pengetahuan_edukasi'] = $data['data_fisik']->pengetahuan_edukasi;
			$data['lokasi_nyeri'] = $data['data_fisik']->lokasi_nyeri;
			$data['riwayat_kesehatan'] = $data['data_fisik']->riwayat_kesehatan;
			$data['nyeri'] = $data['data_fisik']->nyeri;
			$data['skala_nyeri'] = $data['data_fisik']->skala_nyeri;
			$data['metode_nyeri'] = $data['data_fisik']->metode_nyeri;
			$data['kualitas_nyeri'] = $data['data_fisik']->kualitas_nyeri;
			$data['frekuensi_nyeri'] = $data['data_fisik']->frekuensi_nyeri;
			$data['menjalar'] = $data['data_fisik']->menjalar;
			$data['durasi_nyeri'] = $data['data_fisik']->durasi_nyeri;
			$data['fk_minum_obat'] = $data['data_fisik']->fk_minum_obat;
			$data['fk_istirahat'] = $data['data_fisik']->fk_istirahat;
			$data['fk_musik'] = $data['data_fisik']->fk_musik;
			$data['fk_posisi_tidur'] = $data['data_fisik']->fk_posisi_tidur;
			$data['gizi_penurunan_bb'] = $data['data_fisik']->gizi_penurunan_bb;
			$data['gizi_asupan_makan'] = $data['data_fisik']->gizi_asupan_makan;
			$data['penilaian_gizi'] = $data['data_fisik']->penilaian_gizi;
			$data['stat_sosial_keluarga'] = $data['data_fisik']->stat_sosial_keluarga;
			$data['stat_psikologis'] = $data['data_fisik']->stat_psikologis;
			$data['stat_pernikahan_ekonomi'] = $data['data_fisik']->stat_pernikahan_ekonomi;
			// $data['pekerjaan'] = $data['data_fisik']->pekerjaan;
			$data['skrining_risiko_cedera'] = $data['data_fisik']->skrining_risiko_cedera;
			$data['fungsional_alat_bantu'] = $data['data_fisik']->fungsional_alat_bantu;
			$data['alat_bantu'] = $data['data_fisik']->alat_bantu;;
			$data['laporan_dokter_alatbantu']= $data['data_fisik']->laporan_dokter_alatbantu;
			$data['fungsional_cacat_tubuh']= $data['data_fisik']->fungsional_cacat_tubuh;
			// $data['masalah_keperawatan[]'] = $data['data_fisik']->nyeri;
			$data['kes_keluarga_pas_edukasi'] = $data['data_fisik']->kes_keluarga_pas_edukasi;
			$data['hambatan_edukasi'] = $data['data_fisik']->hambatan_edukasi;
			$data['membutuhkan_penerjemah_edukasi'] = $data['data_fisik']->membutuhkan_penerjemah_edukasi;
			$data['perawatan_penyakit'] = $data['data_fisik']->perawatan_penyakit;
			$data['cara_minum_obat'] = $data['data_fisik']->cara_minum_obat;
			$data['diet'] = $data['data_fisik']->diet;
			$data['kerjaan'] = $data['data_pasien']->pekerjaan;


			$data['visus_od'] = $data['data_fisik']->visus_od;
			$data['visus_os'] = $data['data_fisik']->visus_os;
			$data['kacamata_od'] = $data['data_fisik']->kacamata_od;
			$data['kacamata_os'] = $data['data_fisik']->kacamata_os;


			$data['kedudukan_od'] = $data['data_fisik']->kedudukan_od;
			$data['kedudukan_os'] = $data['data_fisik']->kedudukan_os;
			$data['palpebra_od'] = $data['data_fisik']->palpebra_od;
			$data['palpebra_os'] = $data['data_fisik']->palpebra_os;
			$data['conjungtiva_od'] = $data['data_fisik']->conjungtiva_od;
			$data['conjungtiva_os'] = $data['data_fisik']->conjungtiva_os;
			$data['cornea_od'] = $data['data_fisik']->cornea_od;
			$data['cornea_os'] = $data['data_fisik']->cornea_os;
			$data['coa_od'] = $data['data_fisik']->coa_od;
			$data['coa_os'] = $data['data_fisik']->coa_os;
			$data['pupil_od'] = $data['data_fisik']->pupil_od;
			$data['pupil_os'] = $data['data_fisik']->pupil_os;
			$data['lensa_od'] = $data['data_fisik']->lensa_od;
			$data['lensa_os'] = $data['data_fisik']->lensa_os;
			$data['humor_od'] = $data['data_fisik']->humor_od;
			$data['humor_os'] = $data['data_fisik']->humor_os;
			$data['okuli_od'] = $data['data_fisik']->okuli_od;
			$data['okuli_os'] = $data['data_fisik']->okuli_os;
		}
		// var_dump($data['data_fisik']);
		
		$result=$this->rdmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rdmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rdmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rdmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rdmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rdmpelayanan->get_no_rad($no_register)->row()->no_rad);
		$result=$this->rdmpelayanan->get_no_em($no_register)->result();
		$data['no_em']= ($result==Array() ? '':$this->rdmpelayanan->get_no_em($no_register)->row()->no_em);

		switch ($tab){

			default:
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_prosedur'] = "";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_triase'] ='active';
				break;

			case 'triase':
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_prosedur'] = "";

				$data['tab_resep']="";
				$data['tab_triase'] ='active';

				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";

			case 'assesmentmedik':
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_diagnosa']="";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_triase'] = "";
				$data['tab_assesment_medik'] = 'active';
				$data['tab_prosedur'] = '';
				$data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_resep']="";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				break;

			case 'gigi':
				$data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
				$data['tab_assesment_medik'] = '';
                $data['tab_lab']="";
                $data['tab_pa']="";
				$data['tab_prosedur'] = "";

                $data['tab_rad']="";
                $data['tab_em']="";
                $data['tab_resep']="";
				$data['tab_triase'] ='';

                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "active";

			case 'assesment':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "active";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
				$data['tab_triase'] ='';
                $data['tab_lab']="";
                $data['tab_pa']="";
				$data['tab_assesment_medik'] = '';
                $data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_prosedur'] = "";

                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'tindakan':
                $data['tab_tindakan']="active";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_triase'] ='';
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
				$data['tab_prosedur'] = "";

                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'fis':
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
                $data['tab_fisik']="active";
                $data['tab_pa']="";
				$data['tab_triase'] ='';
                $data['tab_lab']="";
                $data['tab_resep']="";
                $data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_assesment_medik'] = '';
                $data['tab_obat']="";
				$data['tab_prosedur'] = "";

                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'diag':
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="active";
				$data['tab_triase'] ='';
                $data['tab_fisik']="";
                $data['tab_pa']="";
                $data['tab_lab']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_prosedur'] = "";

                $data['tab_resep']="";
                $data['tab_rad']="";
                $data['tab_em']="";
                $data['tab_obat']="";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'prosedur':
				$data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_triase'] ='';
				$data['tab_assesment_medik'] = '';
				$data['tab_fisik']="";
				$data['tab_pa']="";
				$data['tab_lab']="";
				$data['tab_prosedur'] = "active";

				$data['tab_resep']="";
				$data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_obat']="";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'lab':
                $data['no_lab']=$param3;
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_triase'] ='';
                $data['tab_diagnosa']="";
                $data['tab_lab']="active";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
				$data['tab_prosedur'] = "";

                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'pa':
                $data['no_pa']=$param3;
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_triase'] ='';
                $data['tab_diagnosa']="";
				$data['tab_assesment_medik'] = '';
                $data['tab_lab']="";
                $data['tab_pa']="active";
                $data['tab_rad']="";
                $data['tab_em']="";
                $data['tab_resep']="";
				$data['tab_prosedur'] = "";

                $data['tab_obat'] = '';
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";

				break;

			case 'rad':
                $no_rad=$param3;
                if($no_rad!='')
                {
                    $data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
                    $data['no_rad']=$no_rad;
                }else{
                    if($this->radmdaftar->get_data_pemeriksaan($no_register)->row()->no_rad!=''){
                        $data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
                    }else{
                        $data['data_rad_pasien']='';
                    }//$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

                }
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
				$data['tab_assesment_medik'] = '';
				$data['tab_triase'] ='';
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="active";
                $data['tab_em']="";
                $data['tab_resep']="";
                $data['tab_diagnosa']="";
                $data['tab_obat'] = 'active';
                $data['tab_racikan']  = '';
				$data['tab_prosedur'] = "";

				$data['tab_gigi'] = "";

				break;
				case 'em':
					$no_em=$param3;
					if($no_em!='')
					{
						$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
						$data['no_em']=$no_em;
					}else{
						if($this->emmdaftar->get_data_pemeriksaan($no_register)->row()->no_em!=''){
							$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
						}else{
							$data['data_em_pasien']='';
						}//$data['data_em_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
	
					}
					$data['tab_tindakan']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_fisik']="";
					$data['tab_assesment_medik'] = '';
					$data['tab_triase'] ='';
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_rad']="";
					$data['tab_em']="active";
					$data['tab_resep']="";
					$data['tab_diagnosa']="";
					$data['tab_obat'] = 'active';
					$data['tab_racikan']  = '';
					$data['tab_prosedur'] = "";

					$data['tab_gigi'] = "";
	
					break;
			case 'resep':
                $no_resep=$param3;
                $data['tab_tindakan']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_fisik']="";
				$data['tab_triase'] ='';
                $data['tab_diagnosa']="";
				$data['tab_assesment_medik'] = '';
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_em']="";
				$data['tab_prosedur'] = "";

                $data['tab_resep']="active";
				$data['tab_gigi'] = "";

                if($no_resep!='')
                {

                    $data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();
                    $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
                    $data['no_resep']=$no_resep;
                }else{
                    if($this->rdmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
                        $data['no_resep']=$this->rdmpelayanan->getdata_resep_pasien($no_register)->result();
                    }else{
                        $data['data_obat_pasien']='';
                    }
                }
                $data['tab_obat']="active";
                $data['tab_racikan']="";
                if($param4!=''){
                    $data['tab_obat']="";
                    $data['tab_racikan']="active";
                }
				break;

				
		}

//		if ($tab=='' || $tab=='tindakan') {

		$data['tab'] = $tab;
		$data['statfisik'] = 'show';
		$data['staff'] = 'triase';
		$data['data_pemeriksa'] = $this->load->get_var("user_info");
		$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
		$data['dokter_ttd'] = $this->rjmpelayanan->get_dokterttd($data['id_dokterrawat'])->result();


		// var_dump($data['kedudukan_od']);
		// var_dump($data);die();
		$this->load->view('ird/rdvpelayanan',$data);
	}

	public function insert_triase()
	{
		// var_dump(json_decode($this->input->post('data'))->keluhan_utama);die();
		$data['no_register'] = $this->input->post('no_register');
		// var_dump($data['no_register']);die();
		$data['formjson'] = $this->input->post('data');
		$data['tgl_pemeriksa'] = date('Y-m-d');
		$login_data = $this->load->get_var('user_info');
		$triase_get = $this->rdmpelayanan->get_triase_by_noreg($data['no_register'])->num_rows();
		if($triase_get>=1){
			$this->rdmpelayanan->update_triase($data);
			$result['kode'] = 202;
			$result['data'] = 'update success';
		}else{
			$data['id_pemeriksa'] = $login_data->userid;
			$this->rdmpelayanan->insert_triase($data);
			$result['kode'] = 201;
			$result['data'] = 'insert success';
		}

		// soap_pasien_rj insert/update
		$soap_pasien_rj_get = $this->rdmpelayanan->get_soappasienrj_bynoreg($data['no_register']);
		if($soap_pasien_rj_get->num_rows()){
			$soap['subjective_perawat'] = json_decode($this->input->post('data'))->keluhan_utama;
			$soap['tgl_input'] = date('Y-m-d H:i:s');
			$login_data = $this->load->get_var("user_info");
			$soap_update = $this->rdmpelayanan->update_soap_pasien($soap,$data['no_register']);
			$submitdata = $soap_update?json_encode(array('data'=>'update soap sukses')):result.json_encode(array('data'=>'update soap gagal'));

		}else{
			$soap['id_pemeriksa'] = $login_data->userid;
			$soap['no_register'] = $data['no_register'];
			$soap['subjective_perawat'] = json_decode($this->input->post('data'))->keluhan_utama;
			$soap['tgl_input'] = date('Y-m-d H:i:s');
			$soap_insert = $this->rdmpelayanan->insert_soap_pasien($soap);
			$submitdata = $soap_insert?json_encode(array('data'=>'insert soap sukses')):result.json_encode(array('data'=>'insert soap gagal'));
		}
		

		echo json_encode($result);
		
	}

	public function insert_assesment_keperawatan_ird()
	{
		$login_data = $this->load->get_var("user_info");
		$data['tgl_assesment'] = date('Y-m-d H:i:s');
		$data['formjson'] = $this->input->post('data');
		$noreg = json_decode($this->input->post('data'))->no_register;
		$check_data_available = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($noreg);
		if($check_data_available->num_rows()){
			$response = $this->rdmpelayanan->update_assesment_keperawatan_ird($data,$noreg);
			$result = ($response?json_encode(array('kode'=>200,'message'=>'succes update data')):json_encode(array('kode'=>6060,'message'=>'Gagal update data')));
		}else{
			$data['id_pemeriksa'] = $login_data->userid;
			$data['no_register'] = $noreg;
			$response = $this->rdmpelayanan->insert_assesment_keperawatan_ird($data);
			$result = ($response?json_encode(array('kode'=>201,'message'=>'succes insert data')):json_encode(array('kode'=>6060,'message'=>'Gagal insert data')));
		}
		$check_soap = $this->rdmpelayanan->get_soappasienrj_bynoreg($noreg);
		$subjective_perawat = json_decode($this->input->post('data'))->riwayat_kesehatan;
		$soap['subjective_perawat'] = $subjective_perawat;
		if($check_soap->num_rows()){
			$response = $this->rdmpelayanan->update_soap_pasien($soap,$noreg);
			$result .= ($response?json_encode(array('kode'=>200,'message'=>'succes update soap')):json_encode(array('kode'=>6060,'message'=>'Gagal update soap')));
		}else{
			$soap['tgl_input'] = date('Y-m-d H:i:s');
			$soap['id_pemeriksa'] = $login_data->userid;
			$soap['no_register'] = $noreg;
			$response = $this->rdmpelayanan->insert_soap_pasien($soap);
			$result .= ($response?json_encode(array('kode'=>201,'message'=>'succes insert soap')):json_encode(array('kode'=>6060,'message'=>'Gagal insert soap')));
		}

		echo $result;
	}

	public function view_assesment_awal_keperawatan($no_register = ''){
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$this->load->view('formassesmentkeperawatan/assesment_keperawatan',$data);
	}

	

	public function update_rujukan_penunjang_ok()
	{	
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');

		
			$data['ok']=1;
			$data['status_ok']=0;
			$data['jadwal_ok']=date("Y-m-d");
			// $data['jadwal_ok']=$this->input->post('jadwal');

			//add poli anastesi
			$data2['id_poli']='CD00';
			
			$datenow='';
			$data_sblm=$this->rdmpelayanan->getdata_daftar_sblm($no_register)->result();
			foreach($data_sblm as $row){
				
				$data2['no_medrec']=$row->no_medrec;
				$datenow=date('Y-m-d H:i:s');
				$data2['tgl_kunjungan']=$datenow;
				$data2['jns_kunj']=$row->jns_kunj;
				$data2['umurrj']=$row->umurrj;
				$data2['uharirj']=$row->uharirj;
				$data2['ublnrj']=$row->ublnrj;
				$data2['asal_rujukan']=$row->asal_rujukan;
				$data2['no_rujukan']=$row->no_rujukan;
				$data2['kelas_pasien']=$row->kelas_pasien;
				$data2['cara_bayar']=$row->cara_bayar;
				$data2['id_kontraktor']=$row->id_kontraktor;
				$data2['nama_penjamin']=$row->nama_penjamin;
				$data2['hubungan']=$row->hubungan;
				$data2['vtot']=$row->vtot;
				$data2['no_sep']=$row->no_sep;
				
			}

				$data2['cara_kunj']="RUJUKAN POLI";
				$login_data = $this->load->get_var("user_info");
				$data2['xcreate']=$login_data->username;
				$data2['vtot']=0;
				$data2['biayadaftar']=0;
				
				
				//print_r($data2);
				$id=$this->rdmregistrasi->insert_daftar_ulang($data2);

				//echo($id->no_register);
				$data4['timein']=date('Y-m-d H:i:s');
				$data4['status']=2;
				$id1=$this->rdmtracer->update_mappasien($no_register,$data4);
			
				$noreg=$this->rdmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;
				
				$data2['no_register']=$noreg;
				$data6['no_register']=$noreg;
				$data6['no_medrec']=$data2['no_medrec'];
				$data6['id_poli']=$data2['id_poli'];
				$data5['timeout']=date('Y-m-d H:i:s');
				$data6['status']=1;
				$data6['tiperawat']='IRJ';
				$this->insert_tindakan3($data2);
				$id2=$this->rdmtracer->insert_mappasien($data6);
		
		
		$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);
		
		// $success = 	'<div class="alert alert-success">
        //                 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //                     	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
        //                	</div>';
		
		
		// $this->session->set_flashdata('success_msg', $success);
		
		echo json_encode(array('status' => 'success'));
	}

	public function update_rujukan_penunjang_lab()
	{	
		$id_poli=$this->input->post('idrg');
		$no_register=$this->input->post('no_register');
		$pelayan=$this->input->post('pelayan');
		
		if($no_register == null){
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if($pelayan == 'DOKTER'){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
			}else{
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}	
		}else{
			$data['lab']=1;
			// $data['status_lab']=0;
			$data['jadwal_lab']=date("Y-m-d");
			// $data['jadwal_lab']=$this->input->post('jadwal_lab');
		
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);

			if($id == true){
				redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
			}else{
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if($pelayan == 'DOKTER'){
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
				}else{
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
				}				
			}

		}
		
			
		

		
		redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
	}

	public function update_rujukan_penunjang_rad()
	{	
		$id_poli=$this->input->post('idrg');
		$no_register=$this->input->post('no_register');
		$pelayan=$this->input->post('pelayan');
		
		if($no_register == null){
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if($pelayan == 'DOKTER'){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
			}else{
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}	
		}else{
			$data['rad']=1;
			// $data['status_rad']=0;
			$data['jadwal_rad']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		
		
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);

			if($id == true){
				redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
			}else{
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if($pelayan == 'DOKTER'){
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
				}else{
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
				}				
			}
		}							
		
	}

	public function update_rujukan_penunjang_em()
	{			
		$id_poli=$this->input->post('idrg');
		$no_register=$this->input->post('no_register');
		$pelayan=$this->input->post('pelayan');

		if($no_register == null){
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if($pelayan == 'DOKTER'){
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
			}else{
				redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
			}	
		}else{
			$data['em']=1;
			// $data['status_em']=0;
			$data['jadwal_em']=date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		
			$id=$this->rdmpelayanan->update_rujukan_penunjang($data,$no_register);

			if($id == true){
				redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
			}else{
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if($pelayan == 'DOKTER'){
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/DOKTER');
				}else{
					redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
				}				
			}
			
		}
		
	}

	public function insert_cppt()
	{
		$data = $this->input->post();
		unset($data['no_register']);
		// var_dump($data);die();
		$data['objective_perawat'] = str_replace(PHP_EOL,'<br>',$data['objective_perawat']);
		$noreg = $this->input->post('no_register');
		$check_available_data = $this->rdmpelayanan->check_cppt_pasien($noreg);
		if($check_available_data->num_rows())
		{
			$submitdata = $this->rdmpelayanan->update_cppt_igd($data,$noreg);
			$result = json_encode($submitdata?['code'=>200]:['code'=>500]);
		}else{
			$login_data = $this->load->get_var("user_info");
			$data['id_pemeriksa'] = $login_data->userid;
			$data['no_register'] = $noreg;
			$submitdata = $this->rdmpelayanan->insert_cppt($data);
			$result = json_encode($submitdata?['code'=>201]:['code'=>500]);
		}
		echo $result;
	}

	public function transfer_ruangan()
	{
		$data = $this->input->post();
		$check_available_data = $this->rdmpelayanan->check_transfer_ruangan($data['no_register']);
		$result = $check_available_data->num_rows()?$this->rdmpelayanan->update_transfer_ruangan($data,$data['no_register']):$this->rdmpelayanan->insert_transfer_ruangan($data);
		echo json_encode([
			$result?200:400
		]);
	}

	public function serah_terima()
	{
		// $data = $this->input->post();
		$login_data = $this->load->get_var("user_info");
		$no_register = $this->input->post('no_register');
		// var_dump($login_data->role);die();

		if($login_data->role == 'Perawat IGD' || $login_data->role == 'Perawat Poli' || $login_data->role == 'Perawat Rawat Jalan' || $login_data->role == 'Perawat Kebidanan' || $login_data->role == 'Perawat Rawat Inap' || $login_data->role == 'Administrator') {
			$check_available_data = $this->rdmpelayanan->check_serah_terima($no_register, 'Perawat');
			$role = 'Perawat';
		} else if($login_data->role == 'Dokter Umum' || $login_data->role == 'Dokter Spesialis') {
			$check_available_data = $this->rdmpelayanan->check_serah_terima($no_register, 'Dokter');
			$role = 'Dokter';
		}

		// $check_available_data = $this->rdmpelayanan->check_serah_terima($no_register);

		$insert['no_register'] = $no_register;
		$insert['formjson'] = $this->input->post('formjson');
		$insert['id_pemeriksa'] = $login_data->userid;
		$insert['role'] = $role;

		$data['formjson'] = $this->input->post('formjson');
		$data['id_pemeriksa'] = $login_data->userid;
		
		$result = $check_available_data->num_rows()?$this->rdmpelayanan->update_serah_terima($data, $no_register, $role):$this->rdmpelayanan->insert_serah_terima($insert);
		echo json_encode([
			$result?200:400
		]);
	}

	public function penilaian_fungsional_status()
	{
		$data = $this->input->post();
		$check_available_data = $this->rdmpelayanan->check_penilaian_fungsional_status($data['no_register']);
		$result = $check_available_data->num_rows()?$this->rdmpelayanan->update_penilaian_fungsional_status($data,$data['no_register']):$this->rdmpelayanan->insert_penilaian_fungsional_status($data);
		echo json_encode([
			$result?200:400
		]);
	}	

	public function skrining_covid()
	{
		$data = $this->input->post();
		// var_dump($data);die();
		$login_data = $this->load->get_var("user_info");
		$data['id_pemeriksa'] = $login_data->userid;
		
		$check_available_data = $this->rdmpelayanan->check_skrining_covid($data['no_register']);
		$result = $check_available_data->num_rows()?$this->rdmpelayanan->update_skrining_covid_igd($data,$data['no_register']):$this->rdmpelayanan->insert_skrining_covid_igd($data);
		echo json_encode([
			$result?200:400
		]);
	}

	public function insert_ews()
	{
		$data['no_register'] = $this->input->post('no_register')??"";
		$data['ews_json'] = $this->input->post('ews_json')??"";
		// var_dump($data['ews_json']);die();
		$data_fisik=$this->rdmpelayanan->getdata_tindakan_fisik($data['no_register'])->row();
		if ($data_fisik==FALSE) {
			// $data['no_register'] = $no_register;
			$this->rdmpelayanan->insert_data_fisik($data);
		} else {
			$no_register = $data['no_register'];
			$this->rdmpelayanan->update_data_fisik($no_register, $data);
		}
	
	}

	public function get_data_pasien_igd() {
		$id=$this->input->post('id');
		//var_dump($id); die();
		$datajson=$this->rdmpelayanan->get_data_pasien_igd($id)->result();
	    echo json_encode($datajson);
	}

	public function update_cara_bayar() {
		$no_register = $this->input->post('no_register_hide');
		//var_dump($no_register);die();
		$data['cara_bayar'] = $this->input->post('cara_bayar_edit');
		$bpjs = explode('@', $this->input->post('iks_bpjs'));
		$iks = explode('@', $this->input->post('iks_edit'));
		if($data['cara_bayar'] == 'BPJS') {
			$data['id_kontraktor'] = $bpjs[0];
		} else if($data['cara_bayar'] == 'KERJASAMA') {
			$data['id_kontraktor'] = $iks[0];
		} else {
			$data['id_kontraktor'] = NULL;
		}

		$this->rdmpelayanan->update_cara_bayar($data, $no_register);
		//redirect('rad/radcdaftar/list_order');
	}

	public function nihss()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rjmpelayanan->get_nihss($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('nihss_json');
			$result = $this->rjmpelayanan->update_nihss($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('nihss_json');
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_nihss($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function insert_disfagia()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rjmpelayanan->get_formulir_disfagia($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('disfagia_json');
			$result = $this->rjmpelayanan->update_formulir_disfagia($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('disfagia_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_formulir_disfagia($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function surat_keterangan_sakit()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rjmpelayanan->get_suket_sakit($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('ket_sakit_json');
			$result = $this->rjmpelayanan->update_suket_sakit($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('ket_sakit_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_suket_sakit($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function form($kode,$no_register,$rad=''){
		
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['radio'] = $rad;
		$data['id_poli'] = 'BA00';

		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad=$this->rdmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$medrec = $data['data_pasien_daftar_ulang']->no_medrec;
		$nama_pasien = $this->rdmpelayanan->get_nama_pasien($medrec)->row()->nama;
		$data['title'] = $nama_pasien;
		$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		$data['data_tindakan_pasien']=$this->rdmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['data_pasien']=$this->rdmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->mmformigd->get_form_by_kode($kode)->row()->views;
		$data['idpokdiet']='';
		if($this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rdmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}
		

		switch($kode){
			case 'formfisik':
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;

			case 'pengkajian_medis':
				$data['pengkajian_medis']=$this->rdmpelayanan->get_pengkajian_medis_igd($no_register)->row();
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				break;

			case 'triase_igd':
				$data['triase']=$this->rdmpelayanan->get_triase_igd($no_register)->row();
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				
				break;

			case 'ringkasan_pulang_rd':
				$data['ringkasan_pulang']=$this->rdmpelayanan->get_ringkasan_pulang_igd($no_register)->row();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['get_data_tind'] = $this->rdmpelayanan->get_tindakan_pasien($no_register)->result();
				$data['get_obat'] = $this->rdmpelayanan->get_resep_dokter($no_register)->result();
				break;

			case 'form_skrining':
				$data['skrining']=$this->rdmpelayanan->get_formulir_skrining($no_register)->row();
				break;

			case 'pengantar_ranap':
				$data['pengantar_ranap']=$this->rdmpelayanan->get_pengantar_rawat_inap($no_register)->row();
				$data['rencana_kerja'] = $this->rdmpelayanan->getdata_form_json($no_register)->row();
				break;

			case 'ket_kematian':
				$data['ket_kematian']=$this->rdmpelayanan->get_surat_keterangan_kematian($no_register)->row();
				break;
			case 'observasi':
				$data['observasi']=$this->rdmpelayanan->get_observasi($no_register)->row();
				break;
	
			case 'surat_rujukan':
				$data['surat_rujukan']=$this->rdmpelayanan->get_surat_rujukan($no_register)->row();
				break;
			case 'penundaan_pelayanan':
				$data['penundaan_pelayanan']=$this->rdmpelayanan->get_penundaan_pelayanan($no_register)->row();
				break;
			case 'cuti':
				$data['cuti']=$this->rdmpelayanan->get_cuti($no_register)->row();
				break;
			case 'persetujuan_tindakan_medik':
				$data['persetujuan_tindakan_medik'] = $this->rjmpelayanan->get_persetujuan_tindakan_medik($no_register)->row();
				break;
			case 'penolakan_tindakan_medik':
				$data['penolakan_tindakan_medik'] = $this->rjmpelayanan->get_penolakan_tindakan_medik($no_register)->row();
				break;
			case 'edukasi_pasien':
				$data['edukasi_pasien']=$this->rdmpelayanan->get_edukasi_pasien($no_register)->row();
				break;
			case 'tindakan':
				$data['tindakans']=$this->rdmpelayanan->getdata_jenis_tindakan_new('BA00')->result();
				$data['dokter_tindakan']=$this->rdmpelayanan->get_dokter_poli('BA00')->result();
				$data['users'] = $this->rimtindakan->get_users()->result();
				break;
		
			case 'lab':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_lab_pasien']=$this->rdmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();	
				$data['cetak_lab_pasien']=$this->rdmpelayanan->getcetak_lab_pasien($no_register)->result();	
				break;
			case 'rad':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_rad_pasien']=$this->rdmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();	
				$data['cetak_rad_pasien']=$this->rdmpelayanan->getcetak_rad_pasien($no_register)->result();
				break;
			case 'em':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_em_pasien']=$this->rdmpelayanan->getdata_em_pasienrj($no_register,$datenow)->result();	
				$data['cetak_em_pasien']=$this->rdmpelayanan->getcetak_em_pasien($no_register)->result();
				break;
			case 'resep':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rdmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();	
				$data['cetak_resep_pasien']=$this->rdmpelayanan->getcetak_resep_pasien($no_register)->result();
				break;
			case 'operasi':
				$data['rujukan_penunjang']=$this->rdmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_ok_pasien']=$this->rdmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();
				break;
			case 'lembar_konsul':
				$data['lembar_konsul'] = $this->rjmpelayanan->get_lembar_konsul_pasien($no_register)->row();
				$data['histo_konsultasi'] = $this->rjmpelayanan->get_lembar_konsul_pasien($no_register)->result();
				break;
			case 'lembar_jawaban_konsul':
				$data['lembar_konsul'] = $this->rjmpelayanan->get_lembar_konsul_pasien($no_register)->row();
				break;
			case 'pengkajian_gigi':
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
				break;
			case 'keperawatan_ponek':
				$data['keperawatan_ponek'] = $this->rdmpelayanan->get_keperawatan_ponek($no_register)->row();
				$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['data_fisik']=$this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'permintaan_transfusi_darah':
				$data['permintaan_transfusi_darah']=$this->rdmpelayanan->get_permintaan_transfusi_darah($no_register)->row();
				break;
			case 'asuhan_keperawatan_ponek':
				$data['asuhan_keperawatan_ponek']=$this->rdmpelayanan->get_pengkajian_keperawatan_ponek($no_register)->row();
				break;
			case 'medis_igd_ponek':
				$data['medis_igd_ponek']=$this->rdmpelayanan->get_medis_igd_ponek($no_register)->row();
				break;
			case 'resiko_jatuh_ponek':
				$data['resiko_jatuh_ponek']=$this->rdmpelayanan->get_resiko_jatuh_ponek($no_register)->row();
				break;
			case 'triase_igd_ponek':
				$data['triase_igd_ponek']=$this->rdmpelayanan->get_triase_igd_ponek($no_register)->row();
				break;
			case 'upload_penunjang_rd':
				$data['upload_penunjang_rd'] = $this->rdmpelayanan->get_upload_penunjang($no_register)->row();
				break;
			case 'utd':
				$data['rujukan_penunjang'] = $this->rdmpelayanan->get_rujukan_penunjang($no_register)->result();
				$data['list_utd_pasien'] = $this->rdmpelayanan->getdata_utd_pasien_rj($no_register, $datenow)->result();
				break;

				
		}
		return $this->load->view($views,$data);
	}

	public function pengkajian_medis_igd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rdmpelayanan->get_pengkajian_medis_igd($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('pengkajian_medis_igd_json');
			$result = $this->rdmpelayanan->update_pengkajian_medis_igd($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('pengkajian_medis_igd_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_pengkajian_medis_igd($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}


	public function triase_igd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rdmpelayanan->get_triase_igd($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('triase_igd_json');
			$result = $this->rdmpelayanan->update_triase_igd($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('triase_igd_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_triase_igd($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}


	public function ringkasan_pulang_igd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rdmpelayanan->get_ringkasan_pulang_igd($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('ringkasan_pulang_rd_json');
			$result = $this->rdmpelayanan->update_ringkasan_pulang_igd($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('ringkasan_pulang_rd_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_ringkasan_pulang_igd($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function formulir_skrining_ird()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rdmpelayanan->get_formulir_skrining($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('form_skrining_json');
			$result = $this->rdmpelayanan->update_formulir_skrining($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('form_skrining_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_formulir_skrining($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function pengantar_ranap()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('pengantar_ranap_json');
		$data_note = $this->rdmpelayanan->get_pengantar_rawat_inap($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_pengantar_rawat_inap($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_pengantar_rawat_inap($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function suket_kematian()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('suket_kematian_json');
		$data_note = $this->rdmpelayanan->get_surat_keterangan_kematian($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_surat_keterangan_kematian($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_surat_keterangan_kematian($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_cuti_perawatan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('cuti_json');
		$data_note = $this->rdmpelayanan->get_cuti($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_cuti_perawatan_new($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_cuti_perawatan_new($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_penundaan_pelayanan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('penundaan_pelayanan_json');
		$data_note = $this->rdmpelayanan->get_penundaan_pelayanan($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_penundaan_pelayanan($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_penundaan_pelayanan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_formulir_observasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('observasi_json');
		$data_note = $this->rdmpelayanan->get_observasi($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_observasi($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_observasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	// insert keperawatan ponek oleh putri 09-10-2024
	public function insert_keperawatan_ponek()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('catatan_ponek_json');
		$data_note = $this->rdmpelayanan->get_keperawatan_ponek($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_keperawatan_ponek($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_keperawatan_ponek($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_edukasi_pasien()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('edukasi_pasien_json');
		$data_note = $this->rdmpelayanan->get_edukasi_pasien($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rdmpelayanan->update_edukasi_pasien($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rdmpelayanan->insert_edukasi_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}
	// aded putri 21-04-2025
	public function insert_permintaan_transfusi_darah_igd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_permintaan_transfusi_darah($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('permintaan_transfusi_darah_json');
			$result = $this->rdmpelayanan->update_permintaan_transfusi_darah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('permintaan_transfusi_darah_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_permintaan_transfusi_darah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}
	public function triase_igd_ponek()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		// $tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_triase_igd_ponek($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('triase_ponek_json');
			$result = $this->rdmpelayanan->update_triase_igd_ponek($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('triase_ponek_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_triase_igd_ponek($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function insert_medis_ponek()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_medis_igd_ponek($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('medis_igd_ponek_json');
			$result = $this->rdmpelayanan->update_medis_igd_ponek($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('medis_igd_ponek_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_medis_igd_ponek($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}
	public function keperawatan_ponek_igd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_pengkajian_keperawatan_ponek($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('pengkajian_keperawatan_ponek_json');
			$result = $this->rdmpelayanan->update_pengkajian_keperawatan_ponek($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('pengkajian_keperawatan_ponek_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_pengkajian_keperawatan_ponek($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}
	public function pengkajian_resiko_jatuh()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_resiko_jatuh_ponek($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_json');
			$result = $this->rdmpelayanan->update_resiko_jatuh_ponek($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_pemeriksa'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_resiko_jatuh_ponek($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}
	public function insert_upload_penunjang_rd()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rdmpelayanan->get_upload_penunjang($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('upload_penunjang_rd_json');
			$result = $this->rdmpelayanan->update_upload_penunjang($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('upload_penunjang_rd_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rdmpelayanan->insert_upload_penunjang($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}


}
?>
