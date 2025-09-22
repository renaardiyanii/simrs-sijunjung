 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');

include('Rjcterbilang.php');

class rjcpelayanan extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/rjmtracer','',TRUE);
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('master/mmgizi','',TRUE);
		$this->load->model('gizi/Mgizi','',TRUE);
		$this->load->model('irj/M_update_sepbpjs','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->helper('bpjs');
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('irj/rjcregistrasi');
	}
	
	public function list_poli()
	{	
		$data['title'] = 'List Poliklinik';
		$username = $this->M_user->get_info($this->session->userdata('userid'))->username;		
		$data['poliklinik']=$this->rjmpencarian->get_poli($this->session->userdata('userid'))->result();
		$this->load->view('irj/rjvlistpoli',$data);
	}
	public function pasien_poli()//pencarian
	{	
		$id_poli=$this->input->post('id_poli');
		redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=array();
		$result=$this->rjmpelayanan->get_biaya_tindakan($id_tindakan,$kelas)->row();
		$biaya[0]=$result->total_tarif;
		$biaya[1]=$result->tarif_alkes;
		echo json_encode($biaya);
	}

	public function update_waktu_masuk()
	{
		$no_register=$this->input->post('no_register');
		$data_update = array(
		     		'waktu_masuk_poli' => date("Y-m-d H:i:s")
		);
		$result = $this->rjmpelayanan->update_waktu_masuk($no_register,$data_update);	
		echo json_encode($result);
	}
	
		////////////////////////////////////////////////////////////////////////////////////////////////////////////batal
	public function pelayanan_batal($id_poli='',$no_register='',$status='')
	{			
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
	//	if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32' || $data['roleid']=='43'){		
			$status_sep=$this->rjmpelayanan->get_status_sep($no_register);
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
				redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);
			}else {
				if ($status_sep->cara_bayar == 'BPJS' ) {
					$id=$this->rjmpelayanan->batal_pelayanan_poli($no_register,$status);
					if ($status_sep->poli_ke == 1 && $status_sep->no_sep != NULL || $status_sep->no_sep != '') {
						hapus_sep($status_sep->no_sep,2);	
					}			
					$notif = '<div class="alert alert-success">
	                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
	                       		</div>';
					$this->session->set_flashdata('notification', $notif);	
					redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);	
				} else {
				$id=$this->rjmpelayanan->batal_pelayanan_poli($no_register);				
				$notif = '<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
                       		</div>';
				$this->session->set_flashdata('notification', $notif);	
				redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);	
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
	// 		redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);
	// //	}

	}	
		////////////////////////////////////////////////////////////////////////////////////////////////////////////pencarian list antrian pasien per poli by
	public function kunj_pasien_poli($id_poli='')//perpoli
	{
		$data['title'] = 'List Pasien Poliklinik | '.date('d-m-Y');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32'){
			$data['access']=1;
		}else{
			$data['access']=0;
		}

		if ($data['roleid']=='48') {
			$data['pasien_daftar']=$this->rjmpencarian->get_pasien_urikes_today($id_poli)->result();
		}else{
			$data['pasien_daftar']=$this->rjmpencarian->get_pasien_daftar_today($id_poli)->result();
			
		}
		$get_nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->result();
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
		
		$this->load->view('irj/rjvpasienpoli',$data);
	}
	
	public function kunj_pasien_poli_by_date()
	{
		$date=$this->input->post('date');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		// if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32'){
		// 	$data['access']=1;
		// }else{
		// 	$data['access']=0;
		// }

		$id_poli=$this->input->post('id_poli');//perpoli
	//	if ($data['roleid']=='48') {
	//		$data['pasien_daftar']=$this->rjmpencarian->get_pasien_urikes_by_date($id_poli,$date)->result();
	//	}else{
			$data['pasien_daftar']=$this->rjmpencarian->get_pasien_daftar_by_date($id_poli,$date)->result();
			
	//	}
		$get_nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->result();
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
		
		$this->load->view('irj/rjvpasienpoli',$data);
	}
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	function tindakan_pasien($no_register=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();		
				
		foreach ($hasil as $value) {
			$surat=$value->idtindakan;
			
			$row2['id_pelayanan_poli'] = $value->id_pelayanan_poli;
			$row2['nmtindakan'] = $value->nmtindakan;
			$row2['nm_dokter'] = $value->nm_dokter;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan , 2 , ',' , '.' );
			$row2['qtyind'] = $value->qtyind;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan , 2 , ',' , '.' );
			$row2['biaya_alkes'] = number_format($value->biaya_alkes , 2 , ',' , '.' );
			$row2['vtot'] = number_format($value->vtot , 2 , ',' , '.' );

			if ($surat=="BD0014") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="BD0015") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_jiwa()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="BD0016") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_jiwa()" class="btn btn-primary btn-xs">Cetak</button>
				
				<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			}else {
				$row2['aksi'] = '<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
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
          $this->rjmpelayanan->autocomplete_diagnosa($q);
        }
    }
    function autocomplete_procedure(){    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->rjmpelayanan->autocomplete_procedure($q);
        }
    }
    public function set_utama_diagnosa(){	
    	$id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
    	$no_register = $this->input->post('no_register');
    	$result = $this->rjmpelayanan->set_utama_diagnosa($id_diagnosa_pasien,$no_register);
    	echo json_encode($result);
    }
    public function set_utama_procedure(){	
    	$id = $this->input->post('id');
    	$no_register = $this->input->post('no_register');
    	$result = $this->rjmpelayanan->set_utama_procedure($id,$no_register);
    	echo json_encode($result);
    }
	public function diagnosa_pasien(){
		$data_diagnosa=$this->rjmpelayanan->get_diagnosa_pasien();
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
            	$row[] = '<button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {
            	$row[] = $diagnosa->diagnosa_text;            
            	$row[] = '<center>'.$diagnosa->klasifikasi_diagnos.'</center>';
            	$row[] = '<button type="button" onclick="set_utama_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';  
            }                        
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rjmpelayanan->diagnosa_count_all(),
            "recordsFiltered" => $this->rjmpelayanan->diagnosa_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function diagnosa_pasien_view(){
		$data_diagnosa=$this->rjmpelayanan->get_diagnosa_pasien();
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
            "recordsTotal" => $this->rjmpelayanan->diagnosa_count_all(),
            "recordsFiltered" => $this->rjmpelayanan->diagnosa_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}	
	public function procedure_pasien(){
		$data_procedure=$this->rjmpelayanan->get_procedure_pasien();
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
            "recordsTotal" => $this->rjmpelayanan->procedure_count_all(),
            "recordsFiltered" => $this->rjmpelayanan->procedure_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function procedure_pasien_view(){
		$data_procedure=$this->rjmpelayanan->get_procedure_pasien();
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
            "recordsTotal" => $this->rjmpelayanan->procedure_count_all(),
            "recordsFiltered" => $this->rjmpelayanan->procedure_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}
	public function insert_diagnosa() {
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_diag');
		$cek_utama = $this->rjmpelayanan->count_utama_diagnosa($no_register);
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
        $result = $this->rjmpelayanan->insert_diagnosa($data_insert);		
		echo $result;
	}
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {	
	// 	$id=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function hapus_procedure($id_procedure_pasien)
	{	
		$delete=$this->rjmpelayanan->hapus_procedure($id_procedure_pasien);
		echo json_encode($delete);
	}
	public function hapus_diagnosa($id_diagnosa_pasien)
	{	
		$delete=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
		echo json_encode($delete);
	}
		
	public function insert_procedure()
	{	
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_procedure');
		$procedure_text = $this->input->post('procedure_text');
		$cek_utama = $this->rjmpelayanan->count_utama_procedure($no_register);
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
        $result = $this->rjmpelayanan->insert_procedure($data_insert);		
		echo $result;
	}	
	public function pelayanan_tindakan($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$data['controller']=$this; 
		$data['view']=0; 
		// cek rujukan penunjang
		$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['rujukan_penunjang_2']=$this->rjmpelayanan->get_rujukan_penunjang_pending($no_register)->row();
		if(empty($data['rujukan_penunjang_2'])){
			$array_penunjang = array('lab' => 0, 'rad' => 0, 'pa' => 0, 'ok' => 0, 'fisio' => 0);
			$data['rujukan_penunjang_2'] = (object) $array_penunjang;
		}

		// print_r($data['rujukan_penunjang_2']);
		
		//cek status lab dan resep
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$result=$this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
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
		//ambil data runjukan
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;

		$data['list_ok_pasien']=$this->rjmpelayanan->getdata_ok_pasien($no_medrecrad)->result();
		$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_medrecrad)->result();	
		$data['cetak_lab_pasien']=$this->rjmpelayanan->getcetak_lab_pasien($no_medrecrad)->result();	
		$data['list_pa_pasien']=$this->rjmpelayanan->getdata_pa_pasien($no_medrecrad)->result();	
		$data['cetak_pa_pasien']=$this->rjmpelayanan->getcetak_pa_pasien($no_medrecrad)->result();		
		$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_medrecrad)->result();	
		$data['cetak_rad_pasien']=$this->rjmpelayanan->getcetak_rad_pasien($no_medrecrad)->result();
		$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_medrecrad)->result();	
		$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_medrecrad)->result();
		$data['list_fisio_pasien']=$this->rjmpelayanan->getdata_fisio_pasien($no_medrecrad)->result();	
		$data['cetak_fisio_pasien']=$this->rjmpelayanan->getcetak_fisio_pasien($no_medrecrad)->result();
		
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		//get id_poli & no_medrec	
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
			$data['bed']='Rawat Jalan';
		$data['idpokdiet']='';
		if($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}
		
		$data['data_diagnosa_pasien']=$this->rjmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien']=$this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['id_poli']=$id_poli;
		$nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="'.site_url('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli).'">Kembali</a>';
		
		$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
		if($id_poli=='BA00'){
			$data['tindakan']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result(); 		
		}
		else{
			$data['tindakan']=$this->rjmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get 
		}
		
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
		
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
		$no_medrec=$data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_medrec)->result();
		
		//data untuk tab obat--------------------------------------------
		$result=$this->rjmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
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
		$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data['data_fisik']==FALSE) {
			$data['td']='';
			$data['bb']='';
			$data['tb']='';

			$data['nadi']='';
			$data['rr']='';
			$data['suhu']='';

			$data['catatan']='';
		} else {
			$data['td']=$data['data_fisik']->td;
			$data['bb']=$data['data_fisik']->bb;
			$data['tb']=$data['data_fisik']->tb;

			$data['nadi']=$data['data_fisik']->nadi;
			$data['rr']=$data['data_fisik']->rr;
			$data['suhu']=$data['data_fisik']->suhu;

			$data['catatan']=$data['data_fisik']->catatan;
		}
		
		$result=$this->rjmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rjmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rjmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rjmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rjmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rjmpelayanan->get_no_rad($no_register)->row()->no_rad);

		switch ($tab){

			default:
                $data['tab_tindakan']="";
                $data['tab_fisik']="active";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				break;

			case 'tindakan':
                $data['tab_tindakan']="active";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				break;

			case 'fis':
                $data['tab_tindakan']="";
                $data['tab_diagnosa']="";
                $data['tab_fisik']="active";
                $data['tab_pa']="";
                $data['tab_lab']="";
                $data['tab_resep']="";
                $data['tab_rad']="";
                $data['tab_obat']="";
                $data['tab_racikan']="";
				break;

			case 'diag':
                $data['tab_tindakan']="";
                $data['tab_diagnosa']="active";
                $data['tab_fisik']="";
                $data['tab_pa']="";
                $data['tab_lab']="";
                $data['tab_resep']="";
                $data['tab_rad']="";
                $data['tab_obat']="";
                $data['tab_racikan']="";
				break;

			case 'lab':
                $data['no_lab']=$param3;
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="active";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_resep']="";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				break;

			case 'pa':
                $data['no_pa']=$param3;
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="active";
                $data['tab_rad']="";
                $data['tab_resep']="";
                $data['tab_obat'] = '';
                $data['tab_racikan']="";
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
                $data['tab_fisik']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="active";
                $data['tab_resep']="";
                $data['tab_diagnosa']="";
                $data['tab_obat'] = 'active';
                $data['tab_racikan']  = '';
				break;

			case 'resep':
                $no_resep=$param3;
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
                $data['tab_diagnosa']="";
                $data['tab_lab']="";
                $data['tab_pa']="";
                $data['tab_rad']="";
                $data['tab_resep']="active";
                if($no_resep!='')
                {

                    $data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();
                    $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
                    $data['no_resep']=$no_resep;
                }else{
                    if($this->rjmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
                        $data['no_resep']=$this->rjmpelayanan->getdata_resep_pasien($no_register)->result();
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
		$this->load->view('irj/rjvpelayanan',$data);
	}

	//NOTE IGD - CATATAN MEDIS GAWAT DARURAT
	public function note_igd($no_register=''){
		if($no_register!=''){
			$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['title'] = 'CATATAN MEDIS GAWAT DARURAT | '.$data['data_pasien_daftar_ulang']->nama.' | '.$no_register;
			$data['id_poli']='BA00';
			$data['no_register']=$no_register;
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BA00()->result();
			$this->load->view('irj/rdvnote',$data);
		}
	}

	public function get_noteigd(){
		$no_register=$this->input->post('no_register');
		if($no_register!=''){
			$data=$this->rjmpelayanan->getdata_noteigd($no_register)->result();
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
		$data_note=$this->rjmpelayanan->getdata_noteigd($no_register)->row();	
		if (sizeof($data_note)==0) {	
			$data['no_register']=$this->input->post('no_register');
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data['nama_perawat']=$user;
			$data['jam_perawat']=date('H:i');
	 		$id=$this->rjmpelayanan->insert_note_igd($data);
			//INSERT
		} else {
	 		$id=$this->rjmpelayanan->update_note_igd($no_register, $data);
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

	public function insert_fisik()
	{
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$td=$this->input->post('td');
		$bb=$this->input->post('bb');
		$tb=$this->input->post('tb');

		$suhu=$this->input->post('suhu');
		$rr=$this->input->post('rr');
		$nadi=$this->input->post('nadi');

		$catatan=$this->input->post('catatan');

		$data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik==FALSE) {
			$data['no_register'] = $no_register;
			$data['td'] = $td;
			$data['bb'] = $bb;
			$data['tb'] = $tb;
			
			$data['suhu'] = $suhu;
			$data['rr'] = $rr;
			$data['nadi'] = $nadi;

			$data['catatan'] = $catatan;
	 		$this->rjmpelayanan->insert_data_fisik($data);
			//INSERT
		} else {
			$data['td'] = $td;
			$data['bb'] = $bb;
			$data['tb'] = $tb;

			$data['suhu'] = $suhu;
			$data['rr'] = $rr;
			$data['nadi'] = $nadi;

			$data['catatan'] = $catatan;
	 		$this->rjmpelayanan->update_data_fisik($no_register, $data);
			// UPDATE
		}
		//print_r($data);
		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
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
		
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/rad/'.$data['no_rad']);
	// 	//print_r($data);
	// }

	// public function selesai_daftar_rad($no_register='',$id_poli='')
	// {
	// 	$getvtotrad=$this->radmdaftar->get_vtot_rad($no_register)->row()->vtot_rad;
	// 	$getrj=substr($no_register, 0,2);
	// 	if ($getrj=="RJ"){
	// 		$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotrad);
	// 	}		

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/rad');
	// 	//print_r($getvtotrad);
	// }

	// public function hapus_data_rad($no_register='',$no_rad='', $id_pemeriksaan_rad='', $id_poli='')
	// {
	// 	$id=$this->radmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_rad);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/rad/'.$no_rad);
		
	// 	//print_r($id);
	// }	
	////////////////////////////////////////////////////////////////////////////////////////////
	public function insert_tindakan()
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");


		$data['id_poli']=$this->input->post('id_poli');
		$data['no_register']=$this->input->post('no_register');
		$tindakan = explode("@", $this->input->post('idtindakan'));
		$data['idtindakan']=$tindakan[0];
		$data['nmtindakan']=$tindakan[1];
		
		if($this->input->post('id_dokter')!=''){
			$dokter = explode("@", $this->input->post('id_dokter'));
			$data['id_dokter']=$dokter[0];
			$data['nm_dokter']=$dokter[1];
		}

		$data['bpjs']=$this->input->post('cover_bpjs');
		$data['biaya_tindakan']=$this->input->post('biaya_tindakan_hide');
		$data['biaya_alkes']=$this->input->post('biaya_alkes_hide');
		$data['qtyind']=$this->input->post('qtyind');
		//$data['dijamin']=$this->input->post('dijamin');
		$data['vtot']=$this->input->post('vtot_hide');
		
		$id=$this->rjmpelayanan->insert_tindakan($data);
		
		//penambahan vtot di daftar_ulang_irj
		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data['no_register'])->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
		$id=$this->rjmpelayanan->update_vtot($data_vtot,$data['no_register']);
		
		echo json_encode($id);
		//redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$data['id_poli'].'/'.$data['no_register']);
	}	
	public function hapus_tindakan($id_poli='',$id_pelayanan_poli='', $no_register='')
	{	
		//pengurangan vtot di daftar_ulang_irj
		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($no_register)->row()->vtot;
		//get vtot_tindakan_sebelumnya
		$vtot_tindakan_sebelumnya=$this->rjmpelayanan->get_vtot_tindakan_sebelumnya($id_pelayanan_poli)->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya-(int)$vtot_tindakan_sebelumnya;
		
		$this->rjmpelayanan->update_vtot($data_vtot,$no_register);
		$id=$this->rjmpelayanan->hapus_tindakan($id_pelayanan_poli);
		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
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
	// 		$cek_diagnosa_utama=$this->rjmpelayanan->cek_diagnosa_utama($data['no_register'])->row();
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
	// 			redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		} else {
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];
	// 		$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$diag_utama=$this->rjmpelayanan->get_diag_pasien($data['no_register']);
		
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
	// 		$diag_utama=$this->rjmpelayanan->update_diag_daful($add_diag,$data['no_register']);

	// 		//$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		}
	// 	}
	// 	else //jika klasifikasi diagnosa==tambahan
	// 	{
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];

	// 		$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 	}
	// }
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {	
	// 	$id=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function cek_diag()
	{	
		$cek_utama = $this->rjmpelayanan->cek_diagnosa_utama($this->input->post('no_register'))->row();
		if ((int)$cek_utama->jumlah>0) {
			echo '1';
		} else {
			echo '2';
		}	
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////pulang / selesai pelayanan poli
	public function update_pulang()
	{	
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		//get detail pasien
		$data_pasien_daftar_ulang=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();			
			$cara_bayar=$data_pasien_daftar_ulang->cara_bayar;
			$no_sep=$data_pasien_daftar_ulang->no_sep;

		$data['tgl_pulang']=date("Y-m-d");
		$data['ket_pulang']=$this->input->post('ket_pulang');
		if ($data['ket_pulang']=="PULANG") {
			if($this->input->post('tgl_kontrol')!=''){
				$data['tgl_kontrol']= date("Y-m-d", strtotime($this->input->post('tgl_kontrol')));
			}
		}
		//$data['lab']=$this->input->post('lab')==null ? 0:$this->input->post('lab');
		//$data['rad']=$this->input->post('rad')==null ? 0:$this->input->post('rad');
		//$data['obat']=$this->input->post('obat')==null ? 0:$this->input->post('obat');
		$data['status']=1;

		if($this->input->post('note_pulang')!=''){
			$data['catatan_plg']=$this->input->post('note_pulang');	
		}
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xpulang']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		//print_r($data);echo $no_register;
		$id=$this->rjmpelayanan->update_pulang($data,$no_register);
		
		if($data['ket_pulang']=='DIRUJUK_RAWATJALAN'){
			$data2['id_poli']=$this->input->post('id_poli_rujuk');
			$data2['id_dokter']=$this->input->post('id_dokter_rujuk');
			//$data2['kd_ruang']=$this->input->post('kd_ruang_rujuk');
			
			/*$no_register_new=$this->rjmregistrasi->get_new_register()->result();
			foreach($no_register_new as $val){
				$data2['no_register']=sprintf("RJ%s%06s",$val->year,$val->counter+1);
			}
			*/
			
			$datenow='';
			$data_sblm=$this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
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
			
			//$noreservasi=($this->rjmregistrasi->select_antrian_bynoreg($datenow,$data2['id_poli'])->row()->no)+1;
			//echo $noreservasi;
			//$data2['no_antrian']=$noreservasi;

			$data2['cara_kunj']="RUJUKAN POLI";
			$data2['xcreate']=$login_data->username;
			$data2['vtot']=0;
			$data2['biayadaftar']=0;
			
			//print_r($data2);
			$id=$this->rjmregistrasi->insert_daftar_ulang($data2);
			//echo($id->no_register);
			$data4['timein']=date('Y-m-d H:i:s');
			$data4['status']=2;
			$id1=$this->rjmtracer->update_mappasien($no_register,$data4);
			/*if($data2['id_poli']=='HA00'){ //lab
				$data4['lab']=1;
				$data4['status_lab']=0;
				
				$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$id->no_register);
			}else if($data2['id_poli']=='LA00'){ //rad
				$data4['rad']=1;
				$data4['status_rad']=0;

				$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$id->no_register);
			}else if($data2['id_poli']=='PA00'){ //pa
				$data4['pa']=1;
				$data4['status_pa']=0;

				$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$id->no_register);
			}*/
			//break;
			$noreg=$this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;

			$data2['no_register']=$noreg;
			/*$data6['no_register']=$noreg;
			$data6['no_medrec']=$data2['no_medrec'];
			$data6['id_poli']=$data2['id_poli'];
			$data5['timeout']=date('Y-m-d H:i:s');
			$data6['status']=1;
			$data6['tiperawat']='IRJ';


			$id2=$this->rjmtracer->insert_mappasien($data6);*/
			
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';

			$success = 	'<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Pasien berhasil dirujuk rawat jalan.
									</h4>
								</div>
							</div>
						</div>';
			
			//cetak_karcis
			$no_register=$id->no_register;
			$this->insert_tindakan3($data2);	
			//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_karcis/$no_register").'", "_blank");window.focus()</script>';
			
		} else if($data['ket_pulang']=='BATAL_PELAYANAN_POLI' && $cara_bayar=='BPJS' ){
			hapus_sep($no_sep,2);
			$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<i class="fa fa-check-circle"></i> Status pulang berhasil disimpan & SEP berhasil dihapus.
                       		</div>';
		}else {
			
			if($data['ket_pulang']=='DIRUJUK_RAWATINAP'){
				/*$data4['timein']=date('Y-m-d H:i:s');
				$data4['status']=2;
				$id1=$this->rjmtracer->update_mappasien($no_register,$data4);*/
			}
			//message sukses kalau ket.pulang == pulang
			$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<i class="fa fa-check-circle"></i> Status pulang berhasil disimpan.
                       		</div>';
		}
		
		$this->session->set_flashdata('success_msg', $success);
		
		redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
	}




	public function insert_tindakan3($data1)
	{
		//date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		//  1B0102 ADM RAWAT JALAN 
		//  1B0103 ADM RAWAT Darurat
		//  1B0104 KARTU
		//  1B0107 Biaya Spesialis IRJ
		//  1B0108 Biaya IGD
		//  1B0105 Biaya Dokter Akupuntur

		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];				
		//default 
		if($data['id_poli']=='BA00'){
			
			/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
				$data['idtindakan']='1B0106';
				$data['bpjs']='0';
			}else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
				$data['idtindakan']='1B0104';
				$data['bpjs']='1';
			}
			else { */
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0103')->row();	
				$data['idtindakan']='1B0103';
				$data['bpjs']='0';
			//}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota=$data['vtot'];
			$id=$this->rjmpelayanan->insert_tindakan($data);

			//IGD ADD DOCTOR FEE
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0108')->row();	
				$data['idtindakan']='1B0108';
				$data['bpjs']='0';
			//}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota+=$data['vtot'];
			$id=$this->rjmpelayanan->insert_tindakan($data);			
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

		}else if($data['id_poli']=='BJ00'){
			
			/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
				$data['idtindakan']='1B0106';
				$data['bpjs']='0';
			}else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
				$data['idtindakan']='1B0104';
				$data['bpjs']='1';
			}
			else { */
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0103')->row();	
				$data['idtindakan']='1B0103';
				$data['bpjs']='0';
			//}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota=$data['vtot'];
			$id=$this->rjmpelayanan->insert_tindakan($data);

			//Akupuntur ADD DOCTOR FEE
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0105')->row();	
				$data['idtindakan']='1B0105';
				$data['bpjs']='0';
			//}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

			/*if($data1['jenis_pasien']=='BARU'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
				$data['idtindakan']='BA0102';					
			}else{
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
				$data['idtindakan']='BA0103';
			}*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota+=$data['vtot'];

			$id=$this->rjmpelayanan->insert_tindakan($data);			
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

		}else{

			/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
				$data['idtindakan']='1B0106';
				$data['bpjs']='0';
			}
			else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
				$data['idtindakan']='1B0104';
				$data['bpjs']='1';
			}			
			else { */
			//	$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();	
			//	$data['idtindakan']='1B0102';
			//	$data['bpjs']='0';
			//}			
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			//$data['nmtindakan']=$detailtind->nmtindakan;		

			//$data['biaya_tindakan']=$detailtind->total_tarif;
			//$data['biaya_alkes']=$detailtind->tarif_alkes;
			//$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			//$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			//$vtota=$data['vtot'];
			//$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//IGD ADD DOCTOR FEE
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0107')->row();	
				$data['idtindakan']='1B0107';
				$data['bpjs']='0';
			//}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			$vtota+=$data['vtot'];
			$id=$this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}
			

		if($data['id_poli']=='BZ04'){ //lab
			$data4['lab']=1;
			$data4['status_lab']=0;
			$data4['jadwal_lab']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ02'){ //rad
			$data4['rad']=1;
			$data4['status_rad']=0;
			$data4['jadwal_rad']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ01'){ //pa
			$data4['pa']=1;
			$data4['status_pa']=0;
			$data4['jadwal_pa']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}/*else{
			//add periksa
			$detailperiksa=$this->rjmregistrasi->get_tarif_periksa_dokter($data1['id_dokter'])->row();

			$data3['id_dokter']=$data1['id_dokter'];
			$data3['nmtindakan']=$detailperiksa->nmtindakan;
			$data3['nm_dokter']=$detailperiksa->nm_dokter;
			$data3['idtindakan']=$detailperiksa->id_biaya_periksa;
			$data3['qtyind']='1';
			$data3['biaya_tindakan']=$detailperiksa->total_tarif;
			$data3['biaya_alkes']=$detailperiksa->tarif_alkes;
			$data3['vtot']=(int)$data3['biaya_tindakan']+(int)$data3['biaya_alkes'];
			$data3['no_register']=$data1['no_register'];
			$data3['xuser']=$user;
			$id=$this->rjmpelayanan->insert_tindakan($data3);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data3['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}*/
		$no_register=$data1['no_register'];
		/*if($data1['cara_bayar']!='UMUM'){
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
		}*/
		
		
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
		} 

		// print_r($data);
		
		$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
		
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
		
		// redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
        echo json_encode(array("status" => $id));
	}

	function update_rujukan_resep_ruangan(){
        $id_poli=$this->input->post('id_poli');
        $no_register=$this->input->post('no_register');
        $data['obat']=$this->input->post('obat');
        $data['status_obat']=0;

        $update = $this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
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
			$data_sblm=$this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
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
				$id=$this->rjmregistrasi->insert_daftar_ulang($data2);

				//echo($id->no_register);
				$data4['timein']=date('Y-m-d H:i:s');
				$data4['status']=2;
				$id1=$this->rjmtracer->update_mappasien($no_register,$data4);
			
				$noreg=$this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;
				
				$data2['no_register']=$noreg;
				$data6['no_register']=$noreg;
				$data6['no_medrec']=$data2['no_medrec'];
				$data6['id_poli']=$data2['id_poli'];
				$data5['timeout']=date('Y-m-d H:i:s');
				$data6['status']=1;
				$data6['tiperawat']='IRJ';
				$this->insert_tindakan3($data2);
				$id2=$this->rjmtracer->insert_mappasien($data6);
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

		print_r($data);
		
		$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
		
		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
                       	</div>';
		
		
		$this->session->set_flashdata('success_msg', $success);
		
		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
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
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');			
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
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
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
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');				
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
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');	
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
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');						 			
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
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_lab']);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register'].'/'.$data['no_lab']);
	// 	//print_r($data);
	// }

	// public function hapus_data_pemeriksaan($id_poli='', $no_register='', $tab='', $no_lab='', $id_pemeriksaan_lab='')
	// {
	// 	$id=$this->labmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_lab);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab.'/'.$no_lab);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$no_lab);
	// }
	
	// public function selesai_daftar_pemeriksaan($id_poli='', $no_register='', $tab='')
	// {
	// 	$getvtotlab=$this->labmdaftar->get_vtot_lab($no_register)->row()->vtot_lab;
		
	// 	//update vtot_lab di daftar ulang irj
	// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotlab);
		
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
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
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_resep']);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// }
	
	// public function hapus_data_resep($id_poli='', $no_register='', $no_lab='', $id_resep_pasien='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);
		
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_lab);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep');
	// }
	
	// public function selesai_daftar_resep()
	// {
	// 	$no_register=$this->input->post('no_register');
	// 	$id_poli=$this->input->post('id_poli');
	// 	$no_resep=$this->input->post('no_resep');
		
	// 	//update daftar ulang irj
	// 	$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
	// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);
		
	// 	//$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	// 	echo '<script type="text/javascript">window.open("'.site_url("irj/Rjcpelayanan/cetak_faktur_obat/$no_resep").'", "_blank");window.focus()</script>';
		
	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep','refresh');
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
		
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep'].'/racik');
	// 	//print_r($data);
	// }

	// public function hapus_data_racikan($no_register='', $no_resep='', $item_obat='', $id_resep_pasien='',$id_poli='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_racikan($item_obat, $id_resep_pasien);

	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_resep.'/racik','refresh');
		
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
	// 	$id_resep_pasien=$this->rjmpelayanan->get_id_resep($data['no_resep'])->row()->id_resep_pasien;
	// 	$this->Frmmdaftar->update_racikan($data['no_resep'], $id_resep_pasien);
		
	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// 	//print_r($data);
	// }
	public function cetak_faktur_obat($no_resep='')
	{
		if($no_resep!=''){
			$cterbilang=new rjcterbilang();
				
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
			$data_permintaan=$this->rjmpelayanan->get_data_permintaan($no_resep)->result();
	
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
							$data_detail_racikan=$this->rjmpelayanan->get_detail_racikan($row->id_resep_pasien)->result();
							
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
		$jalan='1B0107';
		$ugd='1B0108';
		$update1=$this->rjmpelayanan->update_rujukan_penunjang_poli($data, $no_register, 
			$jalan, $ugd);	
		$update2=$this->rjmpelayanan->update_rujukan_penunjang($data2, $no_register);


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
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcpelayanan/cetak_surat_keterangan").'", "_blank");window.focus()</script>';
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

			$dokter=$this->rjmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
			$data_permintaan=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
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
				$obj_pdf->Output(FCPATH.'/download/irj/rjcpelayanan/surat_bebas_narkoba/'.$file_name,'FI');
	
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
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcpelayanan/cetak_surat_keterangan_jiwa").'", "_blank");window.focus()</script>';
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

			$dokter=$this->rjmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
			$data_permintaan=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
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
				$obj_pdf->Output(FCPATH.'/download/irj/rjcpelayanan/surat_jiwa/'.$file_name,'FI');
	
	}
	

	public function pelayanan_tindakan_view($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$data['controller']=$this; 
		$data['view']=1; 
		// cek rujukan penunjang
		$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
		
		//cek status lab dan resep
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$result=$this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
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
		
		//ambil data runjukan
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_medrecrad)->result();	
		$data['cetak_lab_pasien']=$this->rjmpelayanan->getcetak_lab_pasien($no_medrecrad)->result();	
		$data['list_pa_pasien']=$this->rjmpelayanan->getdata_pa_pasien($no_medrecrad)->result();	
		$data['cetak_pa_pasien']=$this->rjmpelayanan->getcetak_pa_pasien($no_medrecrad)->result();		
		$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_medrecrad)->result();	
		$data['cetak_rad_pasien']=$this->rjmpelayanan->getcetak_rad_pasien($no_medrecrad)->result();
		$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_medrecrad)->result();	
		$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_medrecrad)->result();		

		// $no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row();
		// $data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register)->result();	
		// $data['cetak_lab_pasien']=$this->rjmpelayanan->getcetak_lab_pasien($no_register)->result();	
		// $data['list_pa_pasien']=$this->rjmpelayanan->getdata_pa_pasien($no_register)->result();	
		// $data['cetak_pa_pasien']=$this->rjmpelayanan->getcetak_pa_pasien($no_register)->result();		
		// $data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_medrecrad)->result();	
		// $data['cetak_rad_pasien']=$this->rjmpelayanan->getcetak_rad_pasien($no_register)->result();
		// $data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register)->result();	
		// $data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
		
		//get id_poli & no_medrec	
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['bed']='Rawat Jalan';
			
		$data['data_diagnosa_pasien']=$this->rjmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien']=$this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid']='';

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['id_poli']=$id_poli;
		$nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Rawat Jalan | '.$nm_poli;
		
		$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
		$data['tindakan']=$this->rjmpelayanan->get_tindakan($data['kelas_pasien'], substr($id_poli,0,2))->result(); //get tindakan yang ada pada tabel tarif dan sesuai kelas
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		}else
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
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
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
		
		//data untuk tab obat--------------------------------------------
		$result=$this->rjmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
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
		$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data['data_fisik']==FALSE) {
			$data['td']='';
			$data['bb']='';
			$data['tb']='';
			$data['nadi']='';
			$data['suhu']='';
			$data['rr']='';
			//$data['ku']='';
			$data['catatan']='';
		} else {
			$data['td']=$data['data_fisik']->td;
			$data['bb']=$data['data_fisik']->bb;
			$data['tb']=$data['data_fisik']->tb;
			$data['nadi']=$data['data_fisik']->nadi;
			$data['suhu']=$data['data_fisik']->suhu;
			$data['rr']=$data['data_fisik']->rr;
			//$data['ku']=$data['data_fisik']->ku;
			$data['catatan']=$data['data_fisik']->catatan;
		}
		
		$result=$this->rjmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rjmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rjmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rjmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rjmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rjmpelayanan->get_no_rad($no_register)->row()->no_rad);

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
				if($this->rjmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
					$data['no_resep']=$this->rjmpelayanan->getdata_resep_pasien($no_register)->result();
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
		$this->load->view('irj/rjvpelayanan_view',$data);
	}	

		public function list_rawat_jalan()
	{
		$data['title'] = 'List Pasien Rawat Jalan '.date('d-m-Y');
		$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
		$data['pasien_daftar']=$this->rjmpencarian->get_list_rawat_jalan()->result();

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
		
		$this->load->view('irj/rjvlistrawatjalan',$data);
	}

	public function get_data_by_register(){
		$no_register=$this->input->post('no_register');
		$datajson=$this->rjmpencarian->get_data_by_register($no_register)->result();
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
		$this->rjmpencarian->edit_cara_bayar($no_register, $data);
		
		redirect('irj/rjcpelayanan/list_rawat_jalan');
		//print_r($data);
	}
}
?>
