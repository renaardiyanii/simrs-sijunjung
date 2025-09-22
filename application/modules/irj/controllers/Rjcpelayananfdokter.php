<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
//  include(dirname(dirname(__FILE__)).'/Tglindo.php');

include('Rjcterbilang.php');
use GuzzleHttp\Client;


class rjcpelayananfdokter extends Secure_area {

	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/rjmtracer','',TRUE);
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/rdmpelayanan','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('elektromedik/emmdaftar','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('master/mmgizi','',TRUE);
		$this->load->model('master/Mmformigd','',TRUE);
		$this->load->model('gizi/Mgizi','',TRUE);
		$this->load->model('irj/M_update_sepbpjs','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->model('iri/rimdokter','',TRUE);
		// $this->load->helper('bpjs');
		// $this->load->helper('pdf_helper');
		$this->load->model('admin/appconfig','',TRUE);
	}
	public function index()
	{
		redirect('irj/rjcregistrasi');
	}

	public function list_poli_dokter()
	{
		$data['title'] = 'List Poliklinik Dokter';
		$username = $this->M_user->get_info($this->session->userdata('userid'))->username;
		$data['poliklinik']=$this->rjmpencarian->get_poli_dokter_non_igd($this->session->userdata('userid'))->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik_non_igd()->result();

		$this->load->view('irj/rjvlistpolidokter',$data);
	}

	public function pasien_poli()//pencarian
	{
		$id_poli=$this->input->post('poli');
		redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/'.$id_poli);
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
		date_default_timezone_set('Asia/Jakarta');
		$no_register=$this->input->post('no_register');
		$data_update = array(
		     		'waktu_masuk_dokter' => date("Y-m-d H:i:s"),
					'pemeriksa_dokter'=>$this->load->get_var("user_info")->userid,
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

		//	if ($data['roleid']=='48') {
		//		$data['pasien_daftar']=$this->rjmpencarian->get_pasien_urikes_today($id_poli)->result();
		//	}else{
			$data['pasien_daftar']=$this->rjmpencarian->get_pasien_daftar_today_dokter($id_poli)->result();

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
		$this->load->view('irj/rjvpasienpolidokter',$data);
	}

	private function reverse_tgl($tgl){
		$tgl_lahir_mentah = explode('-',$tgl);
		$reverse_tgl_lahir = $tgl_lahir_mentah[2].'-'.$tgl_lahir_mentah[1].'-'.$tgl_lahir_mentah[0];
		return $reverse_tgl_lahir;
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
		$data['pasien_daftar']=$this->rjmpencarian->get_pasien_daftar_by_date_dokter($id_poli,$date)->result();

		$get_nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->result();
		//$nama_poli = $this->rjmpencarian->get_nm_poli($id_poli)->row();
			foreach($get_nm_poli as $row){
				$data['nma_poli']=$row->nm_poli;
			}
		//$data['nma_poli'] = $nama_poli->nm_poli;
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

		$this->load->view('irj/rjvpasienpolidokter',$data);
	}
	// public function obj_tanggal(){
	// 	 $tgl_indo = new Tglindo();
	// 	 return $tgl_indo;
	// }

	function tindakan_pasien($no_register=''){
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();

			$tindakan_rows = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->num_rows();

			foreach ($hasil as $key) {
				$tindakan_value[] = $key->nmtindakan;
			}

			$tidak_ada_tindakan[] = array("Tidak Ada Tindakan");

			$tampung_tindakan= array();
			if ($tindakan_rows == 0) {
				for ($i=0; $i < $tindakan_rows ; $i++) {
					$tampung_tindakan[] = '<br>'.$tidak_ada_tindakan[$i];
				}
			}else{
				for ($i=0; $i < $tindakan_rows ; $i++) {
					$tampung_tindakan[] = '<br>'.'Nama Tindakan :'.$tindakan_value[$i].' ';
				}
			}
			$gabung_tindakan = implode($tampung_tindakan);

			$cek_pasien_apa = substr($no_register,0,2);

			if($cek_pasien_apa == 'RI'){
                $cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
            }else{
                $cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
            }

			$soap['terapi_tindakan_dokter'] = $gabung_tindakan;

			$id_soap = $cek_soap->row();
			if ($id_soap != null) {
				$this->emmdaftar->update_data_soap($id_soap->id,$soap);
			}else{

			}

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

			if ($surat=="1B1010") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_kesehatan()" class="btn btn-primary btn-xs">View</button>

				<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="1B0115") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_jiwa()" class="btn btn-primary btn-xs">View</button>

				<a href="'.site_url('irj/rjcpelayanan/hapus_tindakan/'.$value->id_poli.'/'.$value->id_pelayanan_poli.'/'.$no_register).'" class="btn btn-danger btn-xs">Hapus</a>';
			} else if ($surat=="1B0114") {
				$row2['aksi'] = '
				<button type="btn" onclick="surat_tindakan_narkoba()" class="btn btn-primary btn-xs">View</button>

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
		/**
		 * Added untuk keperluan antrol update task id => 5
		 */
		// check pasien if antrol daftar_ulang_irj(noreservasi)
		// $noreservasi = $this->rjmpelayanan->get_no_reservasi($this->input->post('no_register'));
		// // var_dump($noreservasi);die();
		// if($noreservasi->noreservasi != '' && $noreservasi->noreservasi != null){
		// 	$this->clients = new Client([
		// 		'verify' => false,
		// 		// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		// 	]);
		// 	$this->endpoint = 'http://192.168.1.139:8000/';
		// 	$antrol = json_decode($this->clients->get(
		// 		$this->endpoint .'adminantrian/prosesantrian/'.$noreservasi->noreservasi.'/5'
		// 	)->getBody()->getContents());
		// }
		// echo $result;
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

	public function form_($kode, $id_poli, $no_register, $rad=''){

		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		$data['radio'] = $rad;
		$data['id_poli'] = $id_poli;
		$data['statfisik'] = 'hide';
		$data['pelayan']='DOKTER';
		$data['staff'] = 'DOKTER';
		$data['view']=0;
		$data['no_ipd'] = $no_register;
		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		$data['id_poli']=$data['data_pasien_daftar_ulang']->id_poli;
		$data['data_tindakan_pasien']=$this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		//$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
		$data['unpaid']='';
		$datenow = date('Y-m-d');
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$no_register_lama=$this->rjmpelayanan->get_no_register_lama($no_register)->row();
		$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();

		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$data['a_em']="open";
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
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}

		if($id_poli=='BA00'){
			$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
		}elseif($id_poli=='BW01') {
			$data['tindakans']=$this->rjmpelayanan->get_tindakan_24($data['kelas_pasien'])->result(); //get
		}else{
			$data['tindakans']=$this->rjmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get
		}

		if($id_poli == 'BG00'){
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		//added amel
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		}elseif ($id_poli=='BW01') {
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}

		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli,0,2) == 'BV') {
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}

		$data['idpokdiet']='';
		if($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['data_pasien']=$this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->Mmformigd->get_form_by_kode_irj($kode)->row()->views;



		switch($kode){
			case 'pem_fisik':
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_kep':
				$data['data_keperawatan']=$this->rjmpelayanan->getdata_keperawatan($no_register)->result();
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_mata':
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_bidan':
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_kunj':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'assesment_kunj_fis':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'assesment_medik_dok':
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				// inputkan task id 4
				$noreservasi = $this->rjmpelayanan->get_no_reservasi($no_register);
				// var_dump($noreservasi);die();
				if($noreservasi->noreservasi != '' && $noreservasi->noreservasi != null){
					$this->clients = new Client([
						'verify' => false,
						// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
					]);
					$this->endpoint = 'http://192.168.1.139:8000/';
					$antrol = json_decode($this->clients->get(
						$this->endpoint .'adminantrian/prosesantrian/'.$noreservasi->noreservasi.'/4'
					)->getBody()->getContents());
				}
				break;
			case 'asesmen_medik_dok_mata':
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'gigi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'gizi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'medik_rehab':
				$data['pengkajian_rehab_medik'] = $this->rimtindakan->get_pengkajian_rehab_medik($no_register);
				break;
			case 'medik_rehab_anak':
				$data['pengkajian_rehab_medik'] = $this->rimtindakan->get_pengkajian_rehab_medik($no_register);
				break;
			case 'operasi':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_ok_pasien']=$this->rjmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();
				break;
			case 'lab':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();
				break;
			case 'rad':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();
				break;
			case 'em':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_em_pasien']=$this->rjmpelayanan->getdata_em_pasienrj($no_register,$datenow)->result();
				break;
			case 'resep':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'diagnosa':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'procedure':
				$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'tf_ruang':
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1)?$data['assesment_keperawatan'] = $assesment_keperawatan->result():'';
				$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
				$data['assesment_medik_igd']= $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_resep_dokter']=$this->rjmpelayanan->getdata_resep_dokter($no_register);
				break;
			case 'konsul':
				$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
				$result=$this->rjmpelayanan->get_no_resep($no_register)->result();
				$data['no_resep']= ($result==Array() ? '':$this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
				$data['konsul'] = $this->rjmpelayanan->get_konsul_dokter($no_register)->row();
				$data['history_konsul'] = $this->rjmpelayanan->get_konsul_dokter($no_register);
				$data['konsultasi'] = '';
				$konsul = $this->rjmpelayanan->get_konsul_dokter($no_register);
				($konsul->num_rows())?$data['konsultasi'] = $konsul->row():'';
				$data['data_konsul'] = isset($data['konsultasi'])?$data['konsultasi']:null;
				//var_dump($data['data_konsul']->id_poli_akhir); die();
				$data['poli_rad'] = $this->rjmpencarian->get_poli_konsul_anestesi()->result();
				$data['nama_poli'] = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row()->nm_poli;
				$data['data_diagnosa_pasien_by_no_reg']=$this->rjmpelayanan->getdata_diagnosa_pasien_noreg($no_register)->result();
				$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
				$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();
				break;
			case 'jawaban_konsul':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'jawabankonsulrehabmedik':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['idasal'] = $this->rjmpelayanan->get_id_konsul_rehab_medik($data['data_pasien_daftar_ulang']->no_register_lama)->result();
				//var_dump($data['idasal']); die();
			case 'assesment_fungsional':
				$data['penilaian_fungsional_status'] = $this->rjmpelayanan->check_penilaian_fungsional_status($no_register)->row();
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
				$data['list_resep_dokter']=$this->rjmpelayanan->getdata_resep_dokter($no_register);

				break;
			case 'serahterima':
				$data['serah_terima'] = $this->rdmpelayanan->check_serah_terima($no_register)->row();
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
				$data['idpokdiet']='';
				$data['users'] = $this->rimtindakan->get_users()->result();
				if($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
					$data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
				}
				$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
				//$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli('BA00')->result();
				break;
			case 'geriatri':
				$data['geriatri'] = $this->rjmpelayanan->get_geriatri_rj($no_register);
				break;
			case 'lap_anestesi':
				$data['laporan_anestesi'] = $this->rjmpelayanan->get_lap_anestesi_rj($no_register);
				break;
			case 'pra_anestesi':
				$data['status_sedasi'] = $this->rjmpelayanan->get_status_sedasi_rj($no_register)->row();
				$data['assesment_pra_anestesi'] = $this->rjmpelayanan->get_assesment_pra_anastesi($no_register)->row();
				break;
			case 'status_sedasi':
				$data['status_sedasi'] = $this->rjmpelayanan->get_status_sedasi_rj($no_register)->row();
				break;
		}
		return $this->load->view($views,$data);
	}

	public function status_sedasi() {
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		//$id_ok = $this->input->post('id_ok');
		// $data['no_ipd'] = $noipd;
		$data_note=$this->rjmpelayanan->get_status_sedasi_rj($no_ipd);
		
		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('ews_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('ews_json');
			}
			$submitdata = $this->rjmpelayanan->update_status_sedasi($no_ipd,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('ews_json');
			$submitdata = $this->rimtindakan->insert_status_sedasi($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}
		echo $response;
	}

	public function assesment_pra_anestesi() {
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		//$id_ok = $this->input->post('id_ok');
	
		$data['formjson'] = $this->input->post('assesment_pra_anastesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		

		$data_note=$this->rjmpelayanan->get_assesment_pra_anastesi($no_ipd);	
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_assesment_pra_anastesi($no_ipd, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			//$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_assesment_pra_anastesi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function laporan_anestesi() {
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		// $data['formjson'] = $this->input->post('ews_json');
		// $data['id_pemeriksa'] = $login_data->userid;
		// $data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rjmpelayanan->get_lap_anestesi_rj($no_ipd);	

		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('ews_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('ews_json');
			}
			$submitdata = $this->rjmpelayanan->update_laporan_anestesi($no_ipd,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('ews_json');
			$submitdata = $this->rimtindakan->insert_laporan_anestesi($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}


		echo $submitdata;
	}

	public function pelayanan_tindakan($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		
		$data['statfisik'] = 'hide';
		$data['staff'] = 'dokter';
		$data['nm_poli'] = $this->rjmpelayanan->get_nama_poli($id_poli)->row()->nm_poli;
		$data['id_poli'] = $id_poli;
		$data['id_header'] = '';
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$poli_detail = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row();
		$data['nama_poli'] = $poli_detail->nm_poli;
		$data['poli_bpjs'] = $poli_detail->poli_bpjs; 
		$data['data_pasien']=$this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
			$data['tgl_kun']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
			$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
			$data['idrg']='IRJ';
			$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
			$data['bed']='Rawat Jalan';
		$nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="#" onclick="return openUrl(`'.site_url('irj/rjcpelayananfdokter/kunj_pasien_poli/'.$id_poli).'`)" id="tombolkembali">Kembali</a>';
		$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli,0,2) == 'BV') {
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}
		

		$this->load->view('irj/rjvpelayananbeta',$data);
	}


	public function pelayanan_tindakan2($id_poli='',$no_register='', $tab ='', $param3 ='', $param4 ='')
	{
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data->userid;
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		$data['pelayan']='DOKTER';
		$data['controller']=$this;
		$data['view']=0;
		$datenow = date('Y-m-d');
		$data['konsul'] = $this->rjmpelayanan->get_konsul_dokter($no_register)->row();
		$data['daftar_ulang'] = $this->rjmpelayanan->get_daftar_ulang_irj_by_noreg_lama($no_register)->row();

		if($id_poli == 'BG00'){
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		// cek rujukan penunjang
		$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['rujukan_penunjang_2']=$this->rjmpelayanan->get_rujukan_penunjang_pending($no_register)->row();
		if(empty($data['rujukan_penunjang_2'])){
			$array_penunjang = array('lab' => 0, 'rad' => 0, 'pa' => 0, 'ok' => 0, 'fisio' => 0);
			$data['rujukan_penunjang_2'] = (object) $array_penunjang;
		}

		// print_r($data['rujukan_penunjang_2']);
		$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();
		$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
		//cek status lab dan resep
		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$data['a_em']="open";
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
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}
		//ambil data runjukan
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$no_register_lama=$this->rjmpelayanan->get_no_register_lama($no_register)->row();

		$data['list_ok_pasien']=$this->rjmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();

		$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();
		$data['cetak_lab_pasien']=$this->rjmpelayanan->getcetak_lab_pasien($no_register)->result();

		// $data['list_pa_pasien']=$this->rjmpelayanan->getdata_pa_pasien($no_register,$datenow)->result();
		// $data['cetak_pa_pasien']=$this->rjmpelayanan->getcetak_pa_pasien($no_register)->result();

		$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();
		$data['cetak_rad_pasien']=$this->rjmpelayanan->getcetak_rad_pasien($no_register)->result();

		$data['list_em_pasien']=$this->rjmpelayanan->getdata_em_pasienrj($no_register,$datenow)->result();
		$data['cetak_em_pasien']=$this->rjmpelayanan->getcetak_em_pasien($no_register)->result();

		// $data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_medrecrad,$datenow)->result();
		$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
		$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
		$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();

		// $data['list_fisio_pasien']=$this->rjmpelayanan->getdata_fisio_pasien($no_register,$datenow)->result();
		// $data['cetak_fisio_pasien']=$this->rjmpelayanan->getcetak_fisio_pasien($no_register)->result();

		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['nama_poli'] = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row()->nm_poli;
		//get id_poli & no_medrec
		$data['data_diagnosa_pasien_by_no_reg']=$this->rjmpelayanan->getdata_diagnosa_pasien_noreg($no_register)->result();
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_pasien']=$this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		// var_dump($data['data_pasien_daftar_ulang']);die();
			$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
			$data['no_medrec']=$data['data_pasien_daftar_ulang']->no_medrec;
			$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
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
		$data['title'] = 'Pelayanan Pasien | '.$nm_poli.' | <a href="'.site_url('irj/rjcpelayananfdokter/kunj_pasien_poli/'.$id_poli).'">Kembali</a>';

		$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik()->row();
		if($id_poli=='BA00'){
			$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
		}elseif($id_poli=='BW01') {
			$data['tindakans']=$this->rjmpelayanan->get_tindakan_24($data['kelas_pasien'])->result(); //get
		}else{
			$data['tindakans']=$this->rjmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get
		}

		$data['perawat_tindakan'] = $this->rjmpelayanan->get_perawat()->result();
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		}elseif ($id_poli=='BW01') {
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}

		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli,0,2) == 'BV') {
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}
		//var_dump(substr($id_poli,0,2));die();
		//////////////////////////////

		$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();

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
		$result=$this->rjmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep']= ($result==Array() ? '':$this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();


		$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		// var_dump($data['data_fisik']);
		// die();



		$result=$this->rjmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab']= ($result==Array() ? '':$this->rjmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result=$this->rjmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa']= ($result==Array() ? '':$this->rjmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result=$this->rjmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad']= ($result==Array() ? '':$this->rjmpelayanan->get_no_rad($no_register)->row()->no_rad);;
		$result=$this->rjmpelayanan->get_no_em($no_register)->result();
		$data['no_em']= ($result==Array() ? '':$this->rjmpelayanan->get_no_em($no_register)->row()->no_em);

		switch ($tab){

			default:
				if ($id_poli == 'BH00' || $id_poli == 'BH03') {
					$data['tab_tindakan']="";
					$data['tab_fisik']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_diagnosa']="";
					$data['tab_prosedur'] = "";
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_assesment_medik_dokter_mata'] = "active";
					$data['tab_assesment_medik_dokter'] = "";
					$data['tab_rad']="";
					$data['tab_konsul'] = "";
					$data['tab_em']="";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_resep']="";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_assesment_keperawatan_mata']= "";
					$data['tab_assesment_keperawatan_bidan']= "";
					$data['tab_gizi'] = "";
					$data['tab_obat'] = "";
					$data['tab_racikan']="";
					$data['tab_gigi'] = "";
					$data['tab_transfer'] = "";
					$data['tab_fungsional_status'] = "";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";

				}else{
					$data['tab_tindakan']="";
					$data['tab_fisik']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_diagnosa']="";
					$data['tab_prosedur'] = "";
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_assesment_medik_dokter_mata'] = "";
					$data['tab_assesment_medik_dokter'] = "active";
					$data['tab_rad']="";
					$data['tab_konsul'] = "";
					$data['tab_em']="";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_resep']="";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_assesment_keperawatan_mata']= "";
					$data['tab_assesment_keperawatan_bidan']= "";
					$data['tab_gizi'] = "";
					$data['tab_obat'] = "";
					$data['tab_racikan']="";
					$data['tab_gigi'] = "";
					$data['tab_transfer'] = "";
					$data['tab_fungsional_status'] = "";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";

				}


				break;

			case 'jawaban_konsultasi':
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur']='';
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "active";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = '';
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

				case 'fungsional_status':
					$data['no_pa']="";
					$data['tab_tindakan']="";
					$data['tab_fisik']="";
					$data['tab_assesment_medik_dokter'] = "";
					$data['tab_prosedur']='';
					$data['tab_diagnosa']="";
					$data['tab_lab']="";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_pa']="";
					$data['tab_rad']="";
					$data['tab_em']="";
					$data['tab_gizi'] = "";
					$data['tab_resep']="";
					$data['tab_konsul'] = "";
					$data['tab_obat'] = '';
					$data['tab_racikan']="";
					$data['tab_transfer'] = "";
					$data['tab_fungsional_status'] = "active";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";

					break;

			case 'tab_gizi':
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "active";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;
			case 'assesmentkeperawatanbidan':

				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "active";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


					break;

			case 'assesmentkeperawatanMata':
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
                $data['tab_lab']="";
                $data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
                $data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
                $data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "active";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


					break;
			case 'assesmentMedisMata':
                $data['tab_tindakan']="";
                $data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
                $data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
                $data['tab_lab']="";
                $data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "active";
				$data['tab_assesment_medik_dokter'] = "";
                $data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
                $data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
                $data['tab_obat'] = "";
                $data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'konsultasi':

				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "active";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'gigi':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "active";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


			case 'assesment':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "active";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'assesmentmedikperawat':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "active";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

				case 'transfer ruangan':
					$data['no_pa']="";
					$data['tab_tindakan']="";
					$data['tab_fisik']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_diagnosa']="";
					$data['tab_prosedur'] = "";
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_assesment_medik_dokter_mata'] = "";
					$data['tab_assesment_medik_dokter'] = "";
					$data['tab_rad']="";
					$data['tab_konsul'] = "";
					$data['tab_em']="";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_resep']="";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_assesment_keperawatan_mata']= "";
					$data['tab_assesment_keperawatan_bidan']= "";
					$data['tab_gizi'] = "";
					$data['tab_obat'] = "";
					$data['tab_racikan']="";
					$data['tab_gigi'] = "";
					$data['tab_fungsional_status'] = "";

					$data['tab_transfer'] = "active";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";
					break;

					case 'rehab medik':
						$data['no_pa']="";
						$data['tab_tindakan']="";
						$data['tab_fisik']="";
						$data['tab_assesment_keperawatan'] = "";
						$data['tab_diagnosa']="";
						$data['tab_prosedur'] = "";
						$data['tab_lab']="";
						$data['tab_pa']="";
						$data['tab_assesment_medik_dokter_mata'] = "";
						$data['tab_assesment_medik_dokter'] = "";
						$data['tab_rad']="";
						$data['tab_konsul'] = "";
						$data['tab_em']="";
						$data['tab_jawaban_konsul'] = "";
						$data['tab_resep']="";
						$data['tab_assesment_medik_perawat'] = "";
						$data['tab_assesment_keperawatan_mata']= "";
						$data['tab_assesment_keperawatan_bidan']= "";
						$data['tab_gizi'] = "";
						$data['tab_obat'] = "";
						$data['tab_racikan']="";
						$data['tab_gigi'] = "";
						$data['tab_fungsional_status'] = "";

						$data['tab_transfer'] = "";
						$data['tab_rehab_medik'] = "active";
						$data['tab_rehab_medik_anak'] = "";
						break;

						case 'rehab medik anak':
							$data['no_pa']="";
							$data['tab_tindakan']="";
							$data['tab_fisik']="";
							$data['tab_assesment_keperawatan'] = "";
							$data['tab_diagnosa']="";
							$data['tab_prosedur'] = "";
							$data['tab_lab']="";
							$data['tab_pa']="";
							$data['tab_assesment_medik_dokter_mata'] = "";
							$data['tab_assesment_medik_dokter'] = "";
							$data['tab_rad']="";
							$data['tab_konsul'] = "";
							$data['tab_em']="";
							$data['tab_jawaban_konsul'] = "";
							$data['tab_resep']="";
							$data['tab_assesment_medik_perawat'] = "";
							$data['tab_assesment_keperawatan_mata']= "";
							$data['tab_assesment_keperawatan_bidan']= "";
							$data['tab_gizi'] = "";
							$data['tab_obat'] = "";
							$data['tab_racikan']="";
							$data['tab_gigi'] = "";
							$data['tab_fungsional_status'] = "";

							$data['tab_transfer'] = "";
							$data['tab_rehab_medik'] = "";
							$data['tab_rehab_medik_anak'] = "active";
							break;

			case 'tindakan':
				$data['no_pa']="";
				$data['tab_tindakan']="active";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;
			case 'prosedur':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "active";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


					break;

			case 'fis':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="active";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'diag':
				$data['no_pa']="";
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="active";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'lab':
                $data['no_lab']=$param3;
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="active";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;



			case 'pa':
				$data['no_pa']=$param3;
				$data['tab_tindakan']="";
				$data['tab_fisik']="";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="active";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


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
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa']="";
				$data['tab_prosedur'] = "";
				$data['tab_lab']="";
				$data['tab_pa']="";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad']="active";
				$data['tab_konsul'] = "";
				$data['tab_em']="";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep']="";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata']= "";
				$data['tab_assesment_keperawatan_bidan']= "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan']="";
				$data['tab_gigi'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

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
					$data['tab_fisik']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_diagnosa']="";
					$data['tab_prosedur'] = "";
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_assesment_medik_dokter_mata'] = "";
					$data['tab_assesment_medik_dokter'] = "";
					$data['tab_rad']="";
					$data['tab_konsul'] = "";
					$data['tab_em']="active";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_resep']="";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_assesment_keperawatan_mata']= "";
					$data['tab_assesment_keperawatan_bidan']= "";
					$data['tab_gizi'] = "";
					$data['tab_obat'] = "";
					$data['tab_racikan']="";
					$data['tab_gigi'] = "";
					$data['tab_fungsional_status'] = "";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";

					break;



			case 'resep':
                $no_resep=$param3;

					$data['tab_tindakan']="";
					$data['tab_fisik']="";
					$data['tab_assesment_keperawatan'] = "";
					$data['tab_diagnosa']="";
					$data['tab_prosedur'] = "";
					$data['tab_lab']="";
					$data['tab_pa']="";
					$data['tab_assesment_medik_dokter_mata'] = "";
					$data['tab_assesment_medik_dokter'] = "";
					$data['tab_rad']="";
					$data['tab_konsul'] = "";
					$data['tab_em']="active";
					$data['tab_jawaban_konsul'] = "";
					$data['tab_resep']="";
					$data['tab_assesment_medik_perawat'] = "";
					$data['tab_assesment_keperawatan_mata']= "";
					$data['tab_assesment_keperawatan_bidan']= "";
					$data['tab_gizi'] = "";
					$data['tab_gigi'] = "";
					$data['tab_rehab_medik'] = "";
					$data['tab_rehab_medik_anak'] = "";

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
				$data['tab_fungsional_status'] = "";

				break;
		}

		//		if ($tab=='' || $tab=='tindakan') {



		$data['tab'] = $tab;
		$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
		$data['statfisik'] = 'hide';
		$data['staff'] = 'dokter';
		$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
		// var_dump($data['soap_pasien_rj']);die();
		$data['dokter_ttd'] = $this->rjmpelayanan->get_dokterttd($data['id_dokterrawat'])->result();
		$data['get_suket'] = $this->rjmpelayanan->getdata_suket($no_register)->row();
		$data['pengkajian_rehab_medik'] = $this->rimtindakan->get_pengkajian_rehab_medik($no_register);

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

	public function cetak_fisik($no_register)
	{

		$data['data_fisik'] =$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		return $this->load->view('CPPT_RJ',$data);

	}

	public function insert_fisik()
	{
		$data = $this->input->post();
		$data['tgl_input'] = date('Y-m-d h:i:s');
        $login_data = $this->load->get_var("user_info");
		$data['userid'] = $login_data->userid;

		$check_available_data = $this->rjmpelayanan->get_soap_pasien($this->input->post('no_register'));
		// var_dump($check_available_data->num_rows());die();
		if($check_available_data->num_rows()){
			$soap['id_dokter'] = $this->input->post('id_dokter');
			$submitdata = $this->rjmpelayanan->update_soap_pasien($data,$this->input->post('no_register'));
			$response = $submitdata?json_encode(array('code'=>200,'message'=>'success update data')):json_encode(array('code'=>6060,'message'=>'gagal update data'));
		}else{
			$soap['id_dokter'] = $this->input->post('id_dokter');
			$submitdata = $this->rjmpelayanan->insert_soap_pasien($data);
			$response = $submitdata?json_encode(array('code'=>200,'message'=>'success tambah data')):json_encode(array('code'=>6060,'message'=>'gagal tambah data'));
		}
		/**
		 * Added untuk keperluan antrol update task id => 5
		 */
		// check pasien if antrol daftar_ulang_irj(noreservasi)
		$noreservasi = $this->rjmpelayanan->get_no_reservasi($this->input->post('no_register'));
		// var_dump($noreservasi);die();
		if($noreservasi->noreservasi != '' && $noreservasi->noreservasi != null){
			$this->clients = new Client([
				'verify' => false,
				// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
			]);
			$this->endpoint = 'http://192.168.1.139:8000/';
			$antrol = json_decode($this->clients->get(
				$this->endpoint .'adminantrian/prosesantrian/'.$noreservasi->noreservasi.'/5'
			)->getBody()->getContents());
		}
		echo $response;
	}

	public function insert_medis_mata($noreg)
	{

		$data['formjson']= $this->input->post('formjson');
		// var_dump($data['formjson']);die();

		$check_available_data = $this->rjmpelayanan->get_soap_pasien($noreg);
		// var_dump($check_available_data->num_rows());die();
		if($check_available_data->num_rows()){
			$soap['id_dokter'] = $this->input->post('id_dokter');
			$submitdata = $this->rjmpelayanan->update_soap_pasien($data,$noreg);
			$response = $submitdata?json_encode(array('code'=>200,'message'=>'success update data')):json_encode(array('code'=>6060,'message'=>'gagal update data'));
		}else{
			$soap['id_dokter'] = $this->input->post('id_dokter');
			$submitdata = $this->rjmpelayanan->insert_soap_pasien($data);
			$response = $submitdata?json_encode(array('code'=>200,'message'=>'success tambah data')):json_encode(array('code'=>6060,'message'=>'gagal tambah data'));
		}
		echo $response;
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
		$data['tgl_kunjungan']=date("Y-m-d H:i:s");
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

		$biaya_alkes = $this->input->post('biaya_alkes_hide');
		if($biaya_alkes != null || $biaya_alkes = ''){
			$data['biaya_alkes']=$biaya_alkes;
		}else{
			$data['biaya_alkes'] = 0;
		}
		$data['qtyind']=$this->input->post('qtyind');
		//$data['dijamin']=$this->input->post('dijamin');
		$data['vtot']=$this->input->post('vtot_hide');
		// print_r($data);die();

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

	public function hapus_konsul_pasien($no_register='', $id='', $id_poli_akhir='', $id_poli='') {
		//$id_poli = $this->input->post('id_poli');
		$this->rjmpelayanan->hapus_data_konsul_pasien($id);
		$this->rjmpelayanan->hapus_data_pasien_irj($no_register, $id_poli_akhir);
		redirect('irj/rjcpelayananfdokter/form/konsul/'.$id_poli.'/'.$no_register);
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
		$data['a_em']="open";
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
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
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
		$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($data['no_medrec'])->result();

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
				$data['tab_em']="";
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
				$data['tab_em']="";
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
				$data['tab_em']="";
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
				$data['tab_em']="";
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
				$data['tab_em']="";
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
			$data['tab_em']="";
			$data['tab_resep']="";
			$data['tab_diagnosa']="";
			$data['tab_obat'] = 'active';
			$data['tab_racikan']  = '';
		} else if($tab=='em'){

			$no_rad=$param3;
			if($no_rad!='')
			{
				$data['data_em_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
				$data['no_em']=$no_rad;
			}else{
				if($this->emmdaftar->get_data_pemeriksaan($no_register)->row()->no_em!=''){
					$data['data_rad_pasien']=$this->emmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_rad_pasien']='';
				}//$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

			}
			$data['tab_tindakan']="";
			$data['tab_fisik']="";
			$data['tab_lab']="";
			$data['tab_med']="";
			$data['tab_pa']="";
			$data['tab_rad']="";
			$data['tab_em']="active";
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
				$data['tab_em']="";
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
				$data['tab_em']="";
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

	public function insert_soap()
	{
		$no_register = $this->input->post('no_register');
		$response = '';
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rjmpelayanan->get_soap_pasien($no_register);
		if($check_available_data->num_rows())
		{
			$submitdata = $this->rjmpelayanan->update_soap_pasien($this->input->post(),$no_register);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data = $this->input->post();
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['nm_pemeriksa'] = $login_data->name;
			$data['ttd_pemeriksa'] = $login_data->ttd;
			$submitdata = $this->rjmpelayanan->insert_soap_pasien($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}
		echo $response;
	}


	function insert_daftar_ulang_by_konsul($du){
		// var_dump($du);die();
		date_default_timezone_set('Asia/Jakarta');
		$du['tgl_kunjungan'] =date('Y-m-d H:i:s');
		$du['id_dokter'] = explode('-',$du['id_dokter_akhir'])[0];
		$du['id_poli'] = substr($du['id_poli_akhir'],0,4);
		$data['vtot']=0;
		$du['jns_kunj'] = "LAMA";
		$du['cara_kunj'] = "DIKIRIM DOKTER";
		$du['no_register_lama'] = $du['no_register'];
		$du['noreg_asal_konsul'] = $du['no_register'];
		$du['kelas_pasien'] = "II";
		unset($du['tanggal_konsul'],$du['id_dokter_akhir'],
		$du['id_poli_akhir'],
		$du['id_dokter_asal'],
		$du['nama_pasien'],$du['id_poli_asal'],$du['no_register'],
		$du['id_diagnosa'],$du['bagian'],$du['opsi_konsul'],$du['ikhtisar'],
		$du['kesimpulan'],$du['konsul_diminta'],$du['opsi_konsul'],
		$du['pendapat'],$du['pengobatan'],$du['penderita'],$du['diag_kerja'],
		$du['alih_pengobatan'],$du['raber']);
		$id = $this->rjmregistrasi->insert_daftar_ulang($du);
		$du['no_register']=$id->no_register;
		$du['jenis_pasien'] = $du['jns_kunj'];
	}

	public function insert_konsul_()
	{
		$data['tanggal_konsul'] = $this->input->post('tanggal_konsul');
		unset($data['no_medrec'],$data['cara_bayar']);
		$data['id_dokter_akhir'] = explode('-',$this->input->post('id_dokter_akhir'))[0];
		$no_register = $this->input->post('no_register');
		$response = '';
		$login_data = $this->load->get_var("user_info");
		$data['id_poli_akhir'] = substr($this->input->post('id_poli_akhir'),0,4);

		if($this->input->post('kemungkinan_sangkaan') == '') {
			$data['kemungkinan_sangkaan'] = NULL;
		} else {
			$data['kemungkinan_sangkaan'] = $this->input->post('kemungkinan_sangkaan');
		}
		$data['bagian'] = $this->input->post('bagian');
		if($this->input->post('pengobatan') == ''){
			$data['pengobatan'] = NULL;
		} else {
			$data['pengobatan'] = $this->input->post('pengobatan');
		}
		$data['pengobatan_untuk'] = $this->input->post('pengobatan_untuk');
		if($this->input->post('kelainan') == '') {
			$data['kelainan'] = NULL;
		} else {
			$data['kelainan'] = $this->input->post('kelainan');
		}
		if($this->input->post('perhatian_khusus') == '') {
			$data['perhatian_khusus'] = NULL;
		} else {
			$data['perhatian_khusus'] = $this->input->post('perhatian_khusus');
		}
		if($this->input->post('nasehat') == ''){
			$data['nasehat'] = NULL;
		} else {
			$data['nasehat'] = $this->input->post('nasehat');
		}

		$data['verif_daftar'] = $this->input->post('verif_daftar');

		$data['opsi_konsul'] = $this->input->post('opsi_konsul');
		$data['no_register'] = $this->input->post('no_register');

		$data['id_dokter_asal'] = $this->input->post('id_dokter_asal');
		$data['id_poli_asal'] = $this->input->post('id_poli_asal');
		$data['nama_pasien'] = $this->input->post('nama_pasien');
		// var_dump($data);

		// get diagnosa awal
		$get_diagnosa = $this->rjmpelayanan->get_diagnosa($no_register)->row();
		if($get_diagnosa){
			$data['id_diagnosa'] = $get_diagnosa->id_diagnosa;
			$data['diagnosa'] = $get_diagnosa->diagnosa;
		}else {
			$data['id_diagnosa'] = '';
			$data['diagnosa'] = '';
		}

		$check_available_data = $this->rjmpelayanan->get_konsultasi_dokter($no_register);


		// to table konsul_dokter
		// if($check_available_data->num_rows())
		// {
		// 	// var_dump('update');die();
		// 	unset($data['no_register']);

		// 	$submitdata = $this->rjmpelayanan->update_konsul_dokter($data,$no_register);
		// 	$response = ($submitdata?json_encode(array("kode"=>201)):json_encode(array("kode"=>6201)));

		// }else{
			$submitdata = $this->rjmpelayanan->insert_konsul_dokter($data);
			$response = ($submitdata?json_encode(array("kode"=>200)):json_encode(array("kode"=>6200)));

			// var_dump($response);die();
		//}

		// var_dump('ext');die();
		// to table daftar_ulang_irj
		$du = $this->input->post();
		//date('Y-m-d',strtotime($data['tanggal_konsul'])) == date('Y-m-d')
		// die();

		$du['id_diagnosa'] = $get_diagnosa->id_diagnosa ??'';
		$du['diagnosa'] =$get_diagnosa->diagnosa??'';
		// var_dump($data['tanggal_konsul']);die();
		// if($check_available_data->num_rows()){
		// 	// echo "masuk sini";die();
		// 	$update_du['tgl_kunjungan'] = $data['tanggal_konsul'];
		// 	$update_du['id_dokter'] = $data['id_dokter_akhir'];
		// 	$this->rjmpelayanan->update_konsul_daftar_ulang($update_du,$no_register);
		// }else{
			// echo "masuk sana";die();
			//$update_du['konsul_nanti'] = '1';
			$daftar_ulang = $this->insert_daftar_ulang_by_konsul($du);
		//}


		echo $response;
	}

	public function surat_konsul($no_register = ''){
		// $data['data_kontrol'] = $this->rjmpelayanan->get_v_data_kontrol($no_register);
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
		$no_cm = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
		$no_regis_lama = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
		$data['data_pasien']=$this->rjmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();

		$data['data_konsul'] = $this->rjmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->result();

		$id_dokter_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_asal;
		$id_dokter_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_akhir;
		$id_poli_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_asal;
		$id_poli_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_akhir;

		$data['dokter_asal'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;
		$data['poli_asal'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
		$data['dokter_akhir'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
		$data['poli_akhir'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;
		$data['konsul_dokter'] = 'konsul';
		$this->load->view('LEMBAR_KONSUL',$data);
	}

	public function insert_jawaban_konsul()
	{
		$data = $this->input->post();
		// var_dump($data);die();
		if($data['pengajuan_kembali_jawaban']==''){
			$data['pengajuan_kembali_jawaban'] = date('Y-m-d H:i:s');
		}

		// to db konsul
		$this->rjmpelayanan->update_konsul_dokter($data, $data['no_register'], $data['id_dokter_akhir'], $data['id_poli_akhir']);
		
		// to db daftar_ulang_irj
		$du['tgl_jawaban_konsul'] = date('Y-m-d H:i:s');
		$du['jawaban_konsul'] = 1;
		$this->rjmpelayanan->update_daftar_ulang_irj($du,$data['no_register']);
		echo true;
	}

	public function insert_jawaban_konsul_rehab_medik() {
		$data = $this->input->post();
		//var_dump($data); die();
		unset($data['no_register']);
		unset($data['idasalKonsul']);
		$id = $this->input->post('idasalKonsul');
		$idasalKonsul = (int)$id;
		//var_dump($idasalKonsul); die();
		$data['jawaban_konsul_rehab']= $this->input->post('jawaban_konsul_rehab') == ""?null:$this->input->post('jawaban_konsul_rehab');
		//var_dump($data['jawaban_konsul_rehab']); die();
		//$data['tgl_jawaban'] = date('Y-m-d H:i:s');
		//$this->rjmpelayanan->update_tgl_jawaban_konsul($data,$i);
		$submitdata = $this->rjmpelayanan->insert_jawaban_konsul_dokter($data,$id);
		$response = $submitdata?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		echo $response;
	}


	public function insert_tindakan_bykonsul($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		$data['id_poli'] = $data1['id_poli'];
		//default BA0102
		if ($data['id_poli'] == 'BA00') { //igd
			//1B0102 ->> BPJS Administrasi
			if ($data1['jenis_pasien'] == 'BARU') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1023')->row();
				$data['idtindakan'] = '1B1023';
				$data['bpjs'] = '0';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1023')->row();
				$data['idtindakan'] = '1B1023';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1025')->row();
				$data['idtindakan'] = '1B1025';
				$data['bpjs'] = '0';
			}

			$data['tgl_kunjungan'] = $data1['tgl_kunjungan'];

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			//	print_r($data);exit();
			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		} else if ($data['id_poli'] == 'BG00' || $data['id_poli'] == 'BW00') {

			if ($data1['jenis_pasien'] == 'BARU' && $data1['no_nrp'] == '') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1025')->row();
				$data['idtindakan'] = '1B1025';
			}
			$data['tgl_kunjungan'] = $data1['tgl_kunjungan'];

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			// tambah lagi disini`
			// idtindakan,tgl_kunjungan,nmtindakan,biaya_tindakan,biaya_alkes,qtyind,vtot,
			// insert tindakan
			// data_vtot update
			$no_register = $data1['no_register'];
			$khusus['no_register'] = $no_register;
			$khusus['idtindakan'] = 'PK0001';
			$khusus['tgl_kunjungan'] = $data1['tgl_kunjungan'];
			$detailkhusus = $this->rjmregistrasi->get_detail_tindakan('PK0001')->row();
			$khusus['nmtindakan'] = $detailkhusus->nmtindakan;
			$khusus['biaya_tindakan'] = $detailkhusus->total_tarif;
			$khusus['biaya_alkes'] = $detailkhusus->tarif_alkes;
			$khusus['qtyind'] = '1';
			$khusus['xuser'] = $user;
			$khusus['xupdate'] = date("Y-m-d H:i:s");
			$khusus['vtot'] = (int)$khusus['biaya_tindakan'] + (int)$khusus['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus);

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		} else {

			if ($data1['jenis_pasien'] == 'BARU' && $data1['no_nrp'] == '') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1024')->row();
				$data['idtindakan'] = '1B1024';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B1025')->row();
				$data['idtindakan'] = '1B1025';
			}
			$data['tgl_kunjungan'] = $data1['tgl_kunjungan'];

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			$no_register = $data1['no_register'];
			$khusus1['no_register'] = $no_register;

			$khusus1['idtindakan'] = 'PK0011';
			$khusus1['tgl_kunjungan'] = $data['tgl_kunjungan'];
			$detailkhusus1 = $this->rjmregistrasi->get_detail_tindakan('PK0011')->row();
			$khusus1['nmtindakan'] = $detailkhusus1->nmtindakan;
			$khusus1['biaya_tindakan'] = $detailkhusus1->total_tarif;
			$khusus1['biaya_alkes'] = $detailkhusus1->tarif_alkes;
			$khusus1['qtyind'] = '1';
			$khusus1['xuser'] = $user;
			$khusus1['xupdate'] = date("Y-m-d H:i:s");
			$khusus1['vtot'] = (int)$khusus1['biaya_tindakan'] + (int)$khusus1['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus1);

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			// $data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$khusus['vtot'];
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus1['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		}


		$no_register = $data1['no_register'];
	}

	public function medik_rehab_irj()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('medik_rehab_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_pengkajian_rehab_medik($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_rehab_medik($no_ipd, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
	 		$result=$this->rimtindakan->insert_pengkajian_rehab_medik($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}

		echo $submitdata;
	}

	public function insert_medik_obgyn()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('medis_obgyn_json');
		$data_note = $this->rjmpelayanan->get_medik_obgyn($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_medik_obgyn($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_medik_obgyn($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	// add sjj 2024

	public function form($kode, $id_poli, $no_register, $rad=''){

		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		$data['radio'] = $rad;
		$data['id_poli'] = $id_poli;
		$data['statfisik'] = 'hide';
		$data['pelayan']='DOKTER';
		$data['staff'] = 'DOKTER';
		$data['view']=0;
		$data['no_ipd'] = $no_register;
		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		$data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		$data['id_poli']=$data['data_pasien_daftar_ulang']->id_poli;
		$data['data_tindakan_pasien']=$this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		//$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
		$data['unpaid']='';
		$datenow = date('Y-m-d');
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$no_register_lama=$this->rjmpelayanan->get_no_register_lama($no_register)->row();
		$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();

		$data['a_lab']="open";
		$data['a_pa']="open";
		$data['a_obat']="open";
		$data['a_rad']="open";
		$data['a_ok']="open";
		$data['a_fisio']="open";
		$data['a_em']="open";
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
		if ($result->em=="0" || $result->status_em=="1") {
			$data['a_em'] = "closed";
		}

		if($id_poli=='BA00'){
			$data['tindakans']=$this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
		}elseif($id_poli=='BW01') {
			$data['tindakans']=$this->rjmpelayanan->get_tindakan_24($data['kelas_pasien'])->result(); //get
		}else{
			$data['tindakans']=$this->rjmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get
		}

		if($id_poli == 'BG00'){
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		
		//added amel
		if($id_poli=='BQ00'){
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		}elseif ($id_poli=='BW01') {
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}

		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli,0,2) == 'BV') {
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter()->result();
		}else{
			$data['dokter_tindakan2']=$this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}

		// var_dump($data['dokter_tindakan2']);die();

		$data['idpokdiet']='';
		if($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()){
			$data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}

		//to disabled print button
		foreach($data['data_tindakan_pasien'] as $row){
			if($row->bayar=='0'){
				$data['unpaid']='1';
			}
		}
		$data['data_pasien']=$this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->Mmformigd->get_form_by_kode_irj($kode)->row()->views;



		switch($kode){
			case 'pem_fisik':
				$data['data_fisik']=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;

			case 'pengkajian_medis':
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['pengkajian_medis_rj'] = $this->rjmpelayanan->get_pengkajian_medis_rj($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['resep']=$this->rdmpelayanan->get_resep_for_pengkajian_medis($no_register)->result();
				break;
			case 'assesment_medik_dok':
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'ringkasan_keluar_pasien_rj':
				$data['ringkasan_keluar'] = $this->rjmpelayanan->get_ringkasan_keluar_rj($no_register)->row();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['resep']=$this->rjmpelayanan->get_resep_for_ringkasan_pulang($no_register)->result();
				$data['procedure']=$this->rjmpelayanan->get_procedure_for_ringkasan_pulang($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				break;
			case 'operasi':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_ok_pasien']=$this->rjmpelayanan->getdata_ok_pasien($no_register,$datenow)->result();
				break;
			case 'lab':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();
				break;
			case 'rad':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();
				break;
			case 'resep':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'diagnosa':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'procedure':
				$data['tgl_kunjungan']=$data['data_pasien_daftar_ulang']->tgl_kunjungan;
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'program_terapi_rehab':
				$data['program_terapi_rehab'] = $this->rjmpelayanan->get_program_terapi_rehab($no_register)->row();
					// var_dump($data['uji_fungsi_rehab']);die();
				$data['diagnosa']=$this->rjmpelayanan->get_diagnosa($no_register)->row();
				break;
			case 'uji_fungsi_rehab':
				$data['uji_fungsi_rehab'] = $this->rjmpelayanan->get_hasil_uji_fungsi_rehab($no_register)->row();
					// var_dump($data['uji_fungsi_rehab']);die();
				$data['diagnosa']=$this->rjmpelayanan->get_diagnosa($no_register)->row();
				break;
			case 'tindakan':
				$data['idpokdiet'] = '';
				$data['users'] = $this->rimtindakan->get_users()->result();
				if ($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()) {
					$data['idpokdiet'] = $this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
				}
				if ($data['kelas_pasien'] == 'EKSEKUTIF') {
					$kelasnya = 'VVIP';
				} else {
					$kelasnya = 'III';
				}
				$data['tindakans'] = $this->rjmpelayanan->getdata_jenis_tindakan_new($id_poli)->result();
				//$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli('BA00')->result();
				break;
			case 'lembar_kontrol':
				$data['lembar_kontrol'] = $this->rjmpelayanan->get_lembar_kontrol_pasien($no_register)->row();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['ringkasan'] = $this->rjmpelayanan->getdata_form_json_ringkasan($no_register)->row();
				break;
			case 'lembar_konsul':
				$data['lembar_konsul'] = $this->rjmpelayanan->get_lembar_konsul_pasien($no_register)->row();
				$data['poliklinik']=$this->rjmpencarian->get_poliklinik()->result();
				$data['nama_poli'] = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row()->nm_poli;
				$data['konsul'] = $this->rjmpelayanan->get_konsul_dokter($no_register)->row();
				break;
			case 'lembar_jawaban_konsul':
				$data['lembar_konsul'] = $this->rjmpelayanan->get_lembar_konsul_pasien($no_register)->row();
				$data['noreg_asal_konsul'] = $this->rjmpelayanan->getdata_noreg_asal_konsul($no_register)->row()->noreg_asal_konsul;
				break;
			case 'pengantar_ranap':
				$data['pengantar_ranap'] = $this->rjmpelayanan->get_pengantar_rawat_inap($no_register)->row();
				$data['pengobatan'] = $this->rjmpelayanan->getdata_form_json($no_register)->row();
				break;
			case 'transfusi_darah':
				$data['transfusi_darah'] = $this->rjmpelayanan->get_permintaan_transfusi_darah($no_register)->row();
				$data['data_dokter'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['diagnosa']=$this->rjmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				
				break;
			case 'persetujuan_tindakan_medik':
				$data['persetujuan_tindakan_medik'] = $this->rjmpelayanan->get_persetujuan_tindakan_medik($no_register)->row();
				$data['data_dokter'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				break;
			case 'penolakan_tindakan_medik':
				$data['penolakan_tindakan_medik'] = $this->rjmpelayanan->get_penolakan_tindakan_medik($no_register)->row();
				break;
			case 'surat_rujukan':
				$data['surat_rujukan'] = $this->rjmpelayanan->get_surat_rujukan($no_register)->row();
				$data['data_pasien_daftar_ulang']=$this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				break;
			case 'pengkajian_tht':
				$data['medik_tht'] = $this->rjmpelayanan->get_pengkajian_medik_tht($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['resep'] = $this->rjmpelayanan->get_resep_dokter($no_register)->result();
				break;
			case 'pengkajian_gigi':
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				break;
			case 'medik_obgyn':
				$data['medik_obgyn'] = $this->rjmpelayanan->get_medik_obgyn($no_register)->row();
				break;
			case 'formulir_hiv':
				$data['formulir_hiv'] = $this->rjmpelayanan->get_regis_hiv($no_register)->row();
				$data['nama_poli'] = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row()->nm_poli;
				
				break;
			case 'lap_echo':
				$data['lap_echo'] = $this->rjmpelayanan->get_lap_echo($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['diagnosa']=$this->rjmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['resep'] = $this->rjmpelayanan->get_resep_dokter($no_register)->result();
				// var_dump($data['lap_echo']);die();
				break;
			case 'persetujuan_hiv':
				$data['persetujuan_hiv'] = $this->rjmpelayanan->get_persetujuan_hiv($no_register)->row();
				break;
			case 'medik_anak':
				$data['medik_anak'] = $this->rjmpelayanan->get_pengkajian_medik_anak($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				break;
			case 'upload_penunjang_rj':
				$data['upload_penunjang_rj'] = $this->rjmpelayanan->get_upload_penunjang($no_register)->row();
				break;
			case 'asuhan_gizi':
				$data['asuhan_gizi'] = $this->rjmpelayanan->get_asuhan_gizi($no_register)->row();
				break;
			case 'asuhan_gizi_anak':
				$data['asuhan_gizi_anak'] = $this->rjmpelayanan->get_asuhan_gizi_anak($no_register)->row();
				break;
		
		}
		return $this->load->view($views,$data);
	}


	public function pengkajian_medis_rawat_jalan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('pengkajian_medis_json');
		$data_note = $this->rjmpelayanan->get_pengkajian_medis_rj($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_pengkajian_medis_rj($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengkajian_medis_rj($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function ringkasan_keluar_pasien_rj()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('ringkasan_keluar_json');
		$data_note = $this->rjmpelayanan->get_ringkasan_keluar_rj($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_ringkasan_keluar_rj($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_ringkasan_keluar_rj($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function lembar_kontrol_pasien()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('lembar_kontrol_json');
		$data_note = $this->rjmpelayanan->get_lembar_kontrol_pasien($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_lembar_kontrol_pasien($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_lembar_kontrol_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function lembar_konsultasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('lembar_konsul_json');
		$data_note = $this->rjmpelayanan->get_lembar_konsul_pasien($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_lembar_konsul_pasien($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_lembar_konsul_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function lembar_jawaban_konsultasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$noreg_asal = $this->input->post('no_register_asal');
		$data['formjson_jawaban'] = $this->input->post('lembar_jawaban_konsul_json');
		$data['id_pemeriksa2'] = $login_data->userid;
		$data['tgl_input2'] = date('Y-m-d H:i:s');
		$result = $this->rjmpelayanan->update_lembar_konsul_pasien($no_reg, $data);
		$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		echo $submitdata;
	}


	public function pengantar_ranap()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('pengantar_ranap_json');
		$data_note = $this->rjmpelayanan->get_pengantar_rawat_inap($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_pengantar_rawat_inap($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengantar_rawat_inap($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function transfusi_darah()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('transfusi_darah_json');
		$data_note = $this->rjmpelayanan->get_permintaan_transfusi_darah($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_permintaan_transfusi_darah($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_permintaan_transfusi_darah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function persetujuan_tindakan_medik()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('persetujuan_tindakan_medik_json');
		$data_note = $this->rjmpelayanan->get_persetujuan_tindakan_medik($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_persetujuan_tindakan_medik($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_persetujuan_tindakan_medik($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function penolakan_tindakan_medik()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('penolakan_tindakan_medik_json');
		$data_note = $this->rjmpelayanan->get_penolakan_tindakan_medik($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_penolakan_tindakan_medik($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_penolakan_tindakan_medik($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	//added putri 03-10-2024
	public function persetujuan_tes_hiv()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('persetujuan_hiv_json');
		$data_note = $this->rjmpelayanan->get_persetujuan_hiv($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_persetujuan_hiv($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_persetujuan_hiv($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function surat_rujukan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('surat_rujukan_json');
		$data_note = $this->rjmpelayanan->get_surat_rujukan($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_surat_rujukan($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_surat_rujukan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_konsul()
	{
		//  var_dump($this->input->post('tanggal_konsul'));die();
		$no_register = $this->input->post('no_register');
		$login_data = $this->load->get_var("user_info");

		$data['no_register'] = $this->input->post('no_register');
		$data['tgl_input'] = date('Y-m-d h:i');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_konsul'] = $this->input->post('tanggal_konsul');
		$data['id_poli_akhir'] = substr($this->input->post('id_poli_akhir'),0,4);
		$data['id_dokter_akhir'] = explode('-',$this->input->post('id_dokter_akhir'))[0];
		if($this->input->post('penderita') == '') {
			$data['penderita'] = NULL;
		} else {
			$data['penderita'] = $this->input->post('penderita');
		}
		if($this->input->post('diag_kerja') == '') {
			$data['diag_kerja'] = NULL;
		} else {
			$data['diag_kerja'] = $this->input->post('diag_kerja');
		}
		if($this->input->post('ikhtisar') == '') {
			$data['ikhtisar'] = NULL;
		} else {
			$data['ikhtisar'] = $this->input->post('ikhtisar');
		}
		if($this->input->post('kesimpulan') == '') {
			$data['kesimpulan'] = NULL;
		} else {
			$data['kesimpulan'] = $this->input->post('kesimpulan');
		}
		if($this->input->post('konsul_diminta') == '') {
			$data['konsul_diminta'] = NULL;
		} else {
			$data['konsul_diminta'] = $this->input->post('konsul_diminta');
		}
		if($this->input->post('opsi_konsul') == '') {
			$data['opsi_konsul'] = NULL;
		} else {
			$data['opsi_konsul'] = $this->input->post('opsi_konsul');
		}
		$data['id_dokter_asal'] = $this->input->post('id_dokter_asal');
		$data['id_poli_asal'] = $this->input->post('id_poli_asal');
		$data['no_medrec'] = $this->input->post('no_medrec');
		if($this->input->post('pendapat') == '') {
			$data['pendapat'] = NULL;
		} else {
			$data['pendapat'] = $this->input->post('pendapat');
		}
		if($this->input->post('pengobatan') == '') {
			$data['pengobatan'] = NULL;
		} else {
			$data['pengobatan'] = $this->input->post('pengobatan');
		}
		if($this->input->post('alih_pengobatan') == '') {
			$data['alih_pengobatan'] = NULL;
		} else {
			$data['alih_pengobatan'] = $this->input->post('alih_pengobatan');
		}
		if($this->input->post('raber') == '') {
			$data['raber'] = NULL;
		} else {
			$data['raber'] = $this->input->post('raber');
		}
		
		

		$check_available_data = $this->rjmpelayanan->get_konsultasi_dokter_new($no_register);

		$submitdata = $this->rjmpelayanan->insert_konsul_dokter_new($data);
		$response = ($submitdata?json_encode(array("kode"=>200)):json_encode(array("kode"=>6200)));

		// if($data['tgl_konsul'] == date('Y-m-d')){
		// 	$du = $this->input->post();
		// 	$daftar_ulang = $this->insert_daftar_ulang_by_konsul($du);
	
		// }
		echo $response;
	}

	public function insert_resep_mata()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('resep_mata');
		$data_note = $this->rjmpelayanan->get_resep_mata($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_resep_mata($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_resep_mata($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_fisik_rehab()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('fisik_rehab_json');
		$data_note = $this->rjmpelayanan->get_lembar_kedokteran_fisik_rehab($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_lembar_kedokteran_fisik_rehab($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_lembar_kedokteran_fisik_rehab($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_uji_fungsi_rehab()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('uji_fungsi_rehab_json');
		$data_note = $this->rjmpelayanan->get_hasil_uji_fungsi_rehab($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_hasil_uji_fungsi_rehab($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_hasil_uji_fungsi_rehab($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_Laporan_echo()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('laporan_echocardiography_json');
		$data_note = $this->rjmpelayanan->get_lap_echo($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_lap_echo($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_lap_echo($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_regis_hiv()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('Formulir_regis_hiv_json');
		$data_note = $this->rjmpelayanan->get_regis_hiv($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_regis_hiv($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_regis_hiv($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function insert_program_terapi_rehab()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('program_terapi_json');
		$data_note = $this->rjmpelayanan->get_program_terapi_rehab($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_program_terapi_rehab($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_program_terapi_rehab($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function insert_keperawatan_anak()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data_note = $this->rjmpelayanan->get_pengkajian_keperawatan_anak($no_reg);
		if ($data_note->num_rows()) {
			if($data_note->row()->id_pemeriksa2){
				$data['formjson'] = $this->input->post('keperawatan_anak_json');
				$result = $this->rjmpelayanan->update_pengkajian_keperawatan_anak($no_reg, $data);
				$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
			}else{
				$data['formjson'] = $this->input->post('keperawatan_anak_json');
				$data['id_pemeriksa2'] = $login_data->userid;
				$data['tgl_input2'] = date('Y-m-d H:i:s');
				$result = $this->rjmpelayanan->update_pengkajian_keperawatan_anak($no_reg, $data);
				$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
			}
			
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['formjson'] = $this->input->post('keperawatan_anak_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengkajian_keperawatan_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_medik_anak()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('medis_anak_json');
		$data_note = $this->rjmpelayanan->get_pengkajian_medik_anak($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_pengkajian_medik_anak($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengkajian_medik_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_medik_tht()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('pengkajian_medis_tht_json');
		$data_note = $this->rjmpelayanan->get_pengkajian_medik_tht($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_pengkajian_medik_tht($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengkajian_medik_tht($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function laporan_pembedahan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('bedah_json');
		$data_note = $this->rjmpelayanan->get_laporan_pembedahan($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_laporan_pembedahan($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_laporan_pembedahan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}
	public function insert_upload_penunjang_rj()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('upload_penunjang_rj_json');
		$data_note = $this->rjmpelayanan->get_upload_penunjang($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_upload_penunjang($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_upload_penunjang($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function lembar_konsultasi_igd()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('lembar_konsul_json');
		$data['no_register'] = $this->input->post('no_register');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$result = $this->rjmpelayanan->insert_lembar_konsul_pasien($data);

		//insert dokter
		$konsul = json_decode($data['formjson']);
		$ket_raber = $this->rimtindakan->count_ket_raber($no_reg)->result();
		$jml_array = isset($ket_raber) ? count($ket_raber) : '';
		$data_ket = $jml_array + 1;
	
		$bersama['ket'] = 'DPJP (Rawat Bersama)' . ' ' . $data_ket;
		$bersama['no_register'] = $no_reg;
		$dokter_konsul = explode('-',$konsul->yth);
		$bersama['id_dokter'] = (int)$dokter_konsul[1];
		$bersama['xcreate'] = date("Y-m-d H:i:s");
		$bersama['xuser'] = $login_data->username;
		$insert_dokter = $this->rimdokter->insert_dokter_bersama($bersama);


		$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		echo $submitdata;
	}

	public function insert_jawaban_konsul_igd()
	{
		$data = $this->input->post();
		$konsul['tgl_jawaban'] = $data['tgl_jawaban'];
		$konsul['penemuan'] = $data['penemuan'];
		$konsul['kesimpulan'] = $data['kesimpulan'];
		$konsul['anjuran'] = $data['anjuran'];
		$konsul['catatan'] = $data['catatan'];

		$result = $this->rjmpelayanan->update_konsultasi($data['no_ipd'], $data['id_konsul'], $konsul);
		$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		echo $submitdata;
	}
	public function insert_asuhan_gizi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('asuhan_gizi_json');
		$data_note = $this->rjmpelayanan->get_asuhan_gizi($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_asuhan_gizi($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_asuhan_gizi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_asuhan_gizi_anak()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('asuhan_gizi_anak_json');
		$data_note = $this->rjmpelayanan->get_asuhan_gizi_anak($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_asuhan_gizi_anak($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_asuhan_gizi_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

}
