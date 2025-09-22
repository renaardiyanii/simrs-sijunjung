<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Radcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');

class radckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('rad/radckwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_rad'])==0){
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
		$this->load->view('rad/radvkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_rad'])==0){
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
			$this->load->view('rad/radvkwitansi',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_rad'])==0){
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
			$this->load->view('rad/radvkwitansi',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_rad='')
	{
		$data['title'] = 'Cetak Kwitansi Diagnostik';
		if($no_rad!=''){
			$data['no_rad']=$no_rad;
			$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			if(substr($data['data_pasien']->no_register,0,2) == 'PL'){
				$data_adm=$this->radmkwitansi->get_data_adm_pasien_luar()->row();
				$data['data_adm']=$this->radmdaftar->get_detail_tindakan($data_adm->idtindakan)->row();	
			}else{
				$data['data_adm']=array();
			}
			$data['data_pemeriksaan']=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			if(sizeof($data['data_pemeriksaan'])==0){
				$this->session->set_flashdata('message_no_tindakan','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_no_tindakan','');
			}
			
			$this->load->view('rad/radvkwitansipasien',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt_()
	{
		$no_rad=$this->input->post('no_rad');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();// required pacs @aldi
		if ($this->input->post('penyetor')=="") 
		{
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->radmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_rad!=''){
			$no_register=$this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
			$this->radmkwitansi->update_status_cetak_kwitansi($no_rad, $diskon, $no_register, $xuser);

			$datak['asal'] = 'LA00';
			$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
			$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
			$datak['xuser']=$xuser;
			$datak['xcreate']=date('Y-m-d H:i:s');
			$datak['no_register']=$no_register;
			$datak['nama_poli']='ADM';
			$datak['diskon']= $diskon;
			$datak['vtot_bayar']=$jumlah_vtot;
			$datak['tunai']=$jumlah_vtot-$diskon;
			$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');

			$this->radmkwitansi->insert_nomorkwitansi($datak);

			$datank['asal'] = 'LA00';
			$datank['no_register']=$no_register; 
			$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
			$datank['user_cetak']=$xuser;
			$datank['tgl_cetak']=date('Y-m-d H:i:s');
			$datank['jenis_kwitansi']= 'Radiologi';
			$datank['dp']= 0;
			$datank['diskon']= $diskon;
			$datank['vtot_bayar']=$jumlah_vtot;
			$datank['tunai']=$jumlah_vtot-$diskon;
			$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
			$this->radmkwitansi->insert_nokwitansi($datank);

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

			if (substr($no_register,0,2) == 'RJ') {
				if ($data_pasien->id_poli == 'BA00') {
					$component_id = '02';	
				}else{
					$component_id = '01';	
				}				
			}else{
				$component_id = '03';	
			}

			$datares['reg_date'] = date('Y-m-d');
			$datares['reg_no'] = $no_register;
			$datares['rm_no'] = isset($data_pasien->no_medrec)?$data_pasien->no_medrec:null;
			$datares['pasien_name'] = isset($data_pasien->nama)?$data_pasien->nama:null;
			$datares['dob'] = isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:null;
			$datares['gender'] = isset($data_pasien->sex)?$data_pasien->sex:null;
			$datares['gol_darah'] = isset($data_pasien->goldarah)?$data_pasien->goldarah:null;
			$datares['jenis_pelayanan_id'] = 1;
			$datares['jenis_transaksi'] = 1;
			$datares['payment_tp'] = 2;
			//$datares['component_id'] = isset($data_pasien->id_poli)?$data_pasien->id_poli:null;
			$datares['method_pay'] = $this->input->post('pembayaran_hide');
			if(substr($no_register,0,2) == 'RJ') {
				$datares['component_id'] = 'LA00';
			} else {
				$datares['component_id'] = 'Pasien Luar';
			}
			$datares['nama_dokter'] = isset($data_pasien->nm_dokter)?$data_pasien->nm_dokter:null;
			$datares['trx_no'] = $no_trx->no_kwitansi;
			$datares['paid_flag'] = 0;
			$datares['cancel_flag'] = 0;
			$datares['is_cancel'] = 0;
			$datares['payment_bill'] = (int)$datank['vtot_bayar'];
			$datares['cancel_nominal'] = 0;
			$datares['retur_nominal'] = 0;
			$datares['retur_flag'] = 0;
			$datares['new_payment_bill'] = 0;
			$datares['additional1'] = 'Radiologi';
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';
			$this->rjmkwitansi->insert_registrasi($datares);

			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("rad/radckwitansi/cetak_kwitansi_kt/$no_rad").'", "_blank");window.focus()</script>';
			
			// insert pacs @aldi
			// ----------------------------------------------------------------------------------------------------
			$i = 0;
			$getrdrj=substr($no_register, 0,2);
			$list_tindakan  = json_decode($this->input->post('list_tindakan'));
			foreach($list_tindakan as $value){
				$txt = ltrim(substr($no_register, 2),'0');
				$date = date_create();
				$timestamp = date_timestamp_get($date);
				$accesion_no = substr($txt.$timestamp,0,12); // noreg + timestamp + sequence
				// $generate_2 =  strval(date('Ymd')) + substr($timestamp,0,6); // ? date aja pak?datetime
				$generate_2 =  date('YmdHis',strtotime($value->tgl_kunjungan)); // ? date aja pak?datetime , date hari i
				$omr['PATIENT_NAME']=$data_pasien->nama;
				$omr['PATIENT_SEX']=$data_pasien->sex;
				$omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
				$omr['PATIENT_ID']=$data_pasien->no_cm; // ini ASSN ID
				$omr['ADMISSION_ID']=$no_register; // ini biasano kunjungan/kunjungan 
				$omr['PATIENT_SEX']=$data_pasien->sex;
				$omr['ATTEND_DOCTOR']='0902016'; // ?
				$omr['REQUEST_DOCTOR']='dr Widya, S.RAD';
				$omr['REFER_DOCTOR']='dr Agus, S.RAD'; 
				$omr['REQUEST_DEPARTMENT']='RAD';
				$omr['ACCESSION_NO']=strval($accesion_no); //no register + 3 angka generate dari belakang untuk no register yang sama unique
				$omr['MWL_KEY']=$omr['ACCESSION_NO'];
				$omr['TRIGGER_DTTM']=strval($generate_2); // datetime  + no_medrec
				$omr['REPLICA_DTTM']='ANY'; 
				$omr['SCHEDULED_AETITLE']=$value->modality;
				$omr['SCHEDULED_DTTM']=strval($generate_2); 
				$omr['ADMIT_DTTM']=strval($generate_2);
				$omr['SCHEDULED_MODALITY']=$value->modality.'   '; //ini modality, perhatikan ada spasi dibelakangnya
				$omr['SCHEDULED_STATION']=$value->modality; // 
				$omr['SCHEDULED_PROC_ID']=$value->id_tindakan; // id periksa
				$omr['SCHEDULED_PROC_DESC']=$value->jenis_tindakan; // 
				$omr['REQUESTED_PROC_ID']=$value->id_tindakan; // id periksa
				$omr['REQUESTED_PROC_DESC']=$value->jenis_tindakan; // 
				$omr['SCHEDULED_PROC_STATUS']='120'; // permintaan baru
				$omr['STUDY_INSTANCE_UID']='1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
				$omr['IMAGING_REQUEST_COMMENTS']=$value->komen;
				$result_pacs = $this->insert_pacs($omr,$i);
				$accesion_number = strval($accesion_no). strval($i);
				if($getrdrj=="PL"){
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				} else if($getrdrj=="RJ"){			
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				}
				else if ($getrdrj=="RD"){
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				}
				else if ($getrdrj=="RI"){
					$this->radmdaftar->update_accession_number($no_register,"",$accesion_number);
				}
				$i++;
			}
			// ----------------------------------------------------------------------------------------------------

			// die();
			// redirect('rad/radckwitansi/cetak_kwitansi_kt/'.$no_rad,'refresh');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	public function st_cetak_kwitansi_kt()
	{
		$no_rad=$this->input->post('no_rad');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();// required pacs @aldi
		if ($this->input->post('penyetor')=="") 
		{
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=isset($kasir->kasir)?$kasir->kasir:'';
		$nomor=$this->radmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_rad!=''){
			$no_register=$this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$ket=$this->input->post('pembayaran_hide');
			if($ket == 'PIUTANG/IKS'){
				$data_piutang['no_register'] = $no_register;
				$data_piutang['jns_kwitansi'] = 'Radiologi';
				$data_piutang['total_tagihan']= (int)$jumlah_vtot;
				$data_piutang['created_date']= date('Y-m-d h:i:s');
				$data_piutang['created_by']= $user;
				$data_piutang['nama'] = $data_pasien->nama;
				$data_piutang['medrec'] = $data_pasien->no_medrec;
				$data_piutang['asal'] = 'LA00';
				$data_piutang['cara_bayar'] = $data_pasien->cara_bayar;
				$data_piutang['no_rad'] = $no_rad;
				$this->rjmkwitansi->insert_header_piutang($data_piutang);
				$this->radmkwitansi->update_status_piutang_rad($no_rad, $diskon, $no_register, $xuser);

			}  else {
				$this->radmkwitansi->update_status_cetak_kwitansi($no_rad, $diskon, $no_register, $xuser);

				$datak['asal'] = 'LA00';
				$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$datak['xuser']=$xuser;
				$datak['xcreate']=date('Y-m-d H:i:s');
				$datak['no_register']=$no_register;
				$datak['nama_poli']='ADM';
				$datak['diskon']= $diskon;
				$datak['vtot_bayar']=$jumlah_vtot;
				$datak['tunai']=$jumlah_vtot-$diskon;
				$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');
				// if($ket == 'split'){
				// 	$datak['cash']=(int)$this->input->post('biaya_tunai_hide');
				// 	$datak['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				// }else{
				// 	$datak['cash']=0;
				// 	$datak['noncash']=0;
				// }

				$this->radmkwitansi->insert_nomorkwitansi($datak);

				$datank['asal'] = 'LA00';
				$datank['no_register']=$no_register; 
				$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
				$datank['user_cetak']=$xuser;
				$datank['tgl_cetak']=date('Y-m-d H:i:s');
				$datank['jenis_kwitansi']= 'Radiologi';
				$datank['dp']= 0;
				$datank['diskon']= $diskon;
				$datank['vtot_bayar']=$jumlah_vtot;
				$datank['tunai']=$jumlah_vtot-$diskon;
				$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
				// if($ket == 'split'){
				// 	$datank['cash']=(int)$this->input->post('biaya_tunai_hide');
				// 	$datank['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				// }else{
				// 	$datank['cash']=0;
				// 	$datank['noncash']=0;
				// }
				$this->radmkwitansi->insert_nokwitansi($datank);

				$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
				$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

				if (substr($no_register,0,2) == 'RJ') {
					if ($data_pasien->id_poli == 'BA00') {
						$component_id = '02';	
					}else{
						$component_id = '01';	
					}				
				}else{
					$component_id = '03';	
				}

				$datares['reg_date'] = date('Y-m-d');
				$datares['reg_no'] = $no_register;
				$datares['rm_no'] = isset($data_pasien->no_medrec)?$data_pasien->no_medrec:null;
				$datares['pasien_name'] = isset($data_pasien->nama)?$data_pasien->nama:null;
				$datares['dob'] = isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:null;
				$datares['gender'] = isset($data_pasien->sex)?$data_pasien->sex:null;
				$datares['gol_darah'] = isset($data_pasien->goldarah)?$data_pasien->goldarah:null;
				$datares['jenis_pelayanan_id'] = 1;
				$datares['jenis_transaksi'] = 1;
				$datares['payment_tp'] = 2;
				//$datares['component_id'] = isset($data_pasien->id_poli)?$data_pasien->id_poli:null;
				$datares['method_pay'] = $this->input->post('pembayaran_hide');
				if(substr($no_register,0,2) == 'RJ') {
					$datares['component_id'] = 'LA00';
				} else {
					$datares['component_id'] = 'Pasien Luar';
				}
				$datares['nama_dokter'] = isset($data_pasien->nm_dokter)?$data_pasien->nm_dokter:null;
				$datares['trx_no'] = $no_trx->no_kwitansi;
				$datares['paid_flag'] = 0;
				$datares['cancel_flag'] = 0;
				$datares['is_cancel'] = 0;
				$datares['payment_bill'] = (int)$datank['vtot_bayar'];
				$datares['cancel_nominal'] = 0;
				$datares['retur_nominal'] = 0;
				$datares['retur_flag'] = 0;
				$datares['new_payment_bill'] = 0;
				$datares['additional1'] = 'Radiologi';
				$datares['additional2'] = '0';
				$datares['additional3'] = '0';
				// if($ket == 'split'){
				// 	$datares['cash']=(int)$this->input->post('biaya_tunai_hide');
				// 	$datares['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				// }else{
				// 	$datares['cash']=0;
				// 	$datares['noncash']=0;
				// }
				$this->rjmkwitansi->insert_registrasi($datares);
			}

			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("rad/radckwitansi/cetak_kwitansi_kt/$no_rad").'", "_blank");window.focus()</script>';
			
			// insert pacs @aldi
			// ----------------------------------------------------------------------------------------------------
			$i = 0;
			$getrdrj=substr($no_register, 0,2);
			$list_tindakan  = json_decode($this->input->post('list_tindakan'));
			foreach($list_tindakan as $value){
				$txt = ltrim(substr($no_register, 2),'0');
				$date = date_create();
				$timestamp = date_timestamp_get($date);
				$accesion_no = substr($txt.$timestamp,0,12); // noreg + timestamp + sequence
				// $generate_2 =  strval(date('Ymd')) + substr($timestamp,0,6); // ? date aja pak?datetime
				$generate_2 =  date('YmdHis',strtotime($value->tgl_kunjungan)); // ? date aja pak?datetime , date hari i
				$omr['PATIENT_NAME']=$data_pasien->nama;
				$omr['PATIENT_SEX']=$data_pasien->sex;
				$omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
				$omr['PATIENT_ID']=$data_pasien->no_cm; // ini ASSN ID
				$omr['ADMISSION_ID']=$no_register; // ini biasano kunjungan/kunjungan 
				$omr['PATIENT_SEX']=$data_pasien->sex;
				$omr['ATTEND_DOCTOR']='0902016'; // ?
				$omr['REQUEST_DOCTOR']='dr Widya, S.RAD';
				$omr['REFER_DOCTOR']='dr Agus, S.RAD'; 
				$omr['REQUEST_DEPARTMENT']='RAD';
				$omr['ACCESSION_NO']=strval($accesion_no); //no register + 3 angka generate dari belakang untuk no register yang sama unique
				$omr['MWL_KEY']=$omr['ACCESSION_NO'];
				$omr['TRIGGER_DTTM']=strval($generate_2); // datetime  + no_medrec
				$omr['REPLICA_DTTM']='ANY'; 
				$omr['SCHEDULED_AETITLE']=$value->modality;
				$omr['SCHEDULED_DTTM']=strval($generate_2); 
				$omr['ADMIT_DTTM']=strval($generate_2);
				$omr['SCHEDULED_MODALITY']=$value->modality.'   '; //ini modality, perhatikan ada spasi dibelakangnya
				$omr['SCHEDULED_STATION']=$value->modality; // 
				$omr['SCHEDULED_PROC_ID']=$value->id_tindakan; // id periksa
				$omr['SCHEDULED_PROC_DESC']=$value->jenis_tindakan; // 
				$omr['REQUESTED_PROC_ID']=$value->id_tindakan; // id periksa
				$omr['REQUESTED_PROC_DESC']=$value->jenis_tindakan; // 
				$omr['SCHEDULED_PROC_STATUS']='120'; // permintaan baru
				$omr['STUDY_INSTANCE_UID']='1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
				$omr['IMAGING_REQUEST_COMMENTS']=$value->komen;
				$result_pacs = $this->insert_pacs($omr,$i);
				$accesion_number = strval($accesion_no). strval($i);
				if($getrdrj=="PL"){
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				} else if($getrdrj=="RJ"){			
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				}
				else if ($getrdrj=="RD"){
					$this->radmdaftar->update_accession_number($no_register,$value->id_pemeriksaan_rad,$accesion_number);
				}
				else if ($getrdrj=="RI"){
					$this->radmdaftar->update_accession_number($no_register,"",$accesion_number);
				}
				$i++;
			}
			// ----------------------------------------------------------------------------------------------------

			// die();
			// redirect('rad/radckwitansi/cetak_kwitansi_kt/'.$no_rad,'refresh');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	// insert to pacs
	public function insert_pacs($result,$count)
	{
		// var_dump(APPPATH);
		
		$omr = [
			'MWL_KEY' => '',
			'TRIGGER_DTTM'=>'',
			'REPLICA_DTTM'=>'',
			'EVENT_TYPE'=>'',
			'CHARACTER_SET'=>'',
			'SCHEDULED_AETITLE'=>'',
			'SCHEDULED_DTTM'=>'',
			'SCHEDULED_MODALITY'=>'',
			'SCHEDULED_STATION'=>'',
			'SCHEDULED_LOCATION'=>'',
			'SCHEDULED_PROC_ID'=>'',
			'SCHEDULED_PROC_DESC'=>'',
			'SCHEDULED_ACTION_CODES'=>'',
			'SCHEDULED_PROC_STATUS'=>'',
			'PREMEDICATION'=>'',
			'CONTRAST_AGENT'=>'',
			'REQUESTED_PROC_ID'=>'',
			'REQUESTED_PROC_DESC'=>'',
			'REQUESTED_PROC_CODES'=>'',
			'REQUESTED_PROC_PRIORITY'=>'',
			'REQUESTED_PROC_REASON'=>'',
			'REQUESTED_PROC_COMMENTS'=>'',
			'STUDY_INSTANCE_UID'=>'',
			'PROC_PLACER_ORDER_NO'=>'',
			'PROC_FILER_ORDER_NO'=>'',
			'ACCESSION_NO'=>'',
			'ATTEND_DOCTOR'=>'',
			'PERFORM_DOCTOR'=>'',
			'CONSULT_DOCTOR'=>'',
			'REQUEST_DOCTOR'=>'',
			'REFER_DOCTOR'=>'',
			'REQUEST_DEPARTMENT'=>'',
			'IMAGING_REQUEST_REASON'=>'',
			'IMAGING_REQUEST_COMMENTS'=>'',
			'IMAGING_REQUEST_DTTM'=>'',
			'ISR_PLACER_ORDER_NO'=>'',
			'ISR_FILLER_ORDER_NO'=>'',
			'ADMISSION_ID'=>'',
			'PATIENT_TRANSPORT'=>'',
			'PATIENT_LOCATION'=>'',
			'PATIENT_RESIDENCY'=>'',
			'PATIENT_NAME'=>'',
			'PATIENT_ID'=>'',
			'OTHER_PATIENT_NAME'=>'',
			'OTHER_PATIENT_ID'=>'',
			'PATIENT_BIRTH_DATE'=>'',
			'PATIENT_SEX'=>'',
			'PATIENT_WEIGHT'=>'',
			'PATIENT_SIZE'=>'',
			'PATIENT_STATE'=>'',
			'CONFIDENTIALITY'=>'',
			'PREGNANCY_STATUS'=>'',
			'MEDICAL_ALERT'=>'',
			'CONTRAST_ALLERGIES'=>'',
			'SPECIAL_NEEDS'=>'',
			'SPECIALITY'=>'',
			'DIAGNOSIS'=>'',
			'ADMIT_DTTM'=>''
		];

		$omr['PATIENT_NAME']=$result['PATIENT_NAME'];
		$omr['PATIENT_SEX']=$result['PATIENT_SEX'];
		$omr['PATIENT_BIRTH_DATE']=$result['PATIENT_BIRTH_DATE'];
		$omr['PATIENT_ID']=$result['PATIENT_ID']; // ini ASSN ID
		$omr['ADMISSION_ID']=$result['ADMISSION_ID']; // no registrasi/kunjungan 
		$omr['PATIENT_SEX']=$result['PATIENT_SEX'];
		$omr['ATTEND_DOCTOR']='0902016'; // ?ini ID dokter widya
		$omr['REQUEST_DOCTOR']='dr Widya, S.RAD';
		$omr['REFER_DOCTOR']=$result['REFER_DOCTOR'];  // ini masukin dr Rjukan aja, tapi di pacs tetep gak muncul
		$omr['REQUEST_DEPARTMENT']='RAD';
		$omr['ACCESSION_NO']=$result['ACCESSION_NO'] . strval($count); //no register + 3 angka generate dari belakang untuk no register yang sama unique
		$omr['MWL_KEY']=$omr['ACCESSION_NO'];
		$omr['TRIGGER_DTTM']=$result['TRIGGER_DTTM']; // datetime  + no_medrec
		$omr['REPLICA_DTTM']='ANY'; 
		$omr['SCHEDULED_AETITLE']=$result['SCHEDULED_AETITLE']; // ini judul pemeriksaan
		$omr['SCHEDULED_DTTM']=$result['SCHEDULED_DTTM']; 
		$omr['ADMIT_DTTM']=$result['SCHEDULED_DTTM'];
		$omr['SCHEDULED_MODALITY']=$result['SCHEDULED_STATION'].'    '; //ini modality, perhatikan ada spasi dibelakangnya
		$omr['SCHEDULED_STATION']=$result['SCHEDULED_STATION']; // 
		$omr['SCHEDULED_PROC_ID']=$result['REQUESTED_PROC_ID']; // id periksa
		$omr['SCHEDULED_PROC_DESC']=$result['REQUESTED_PROC_DESC']; // 
		$omr['REQUESTED_PROC_ID']=$omr['SCHEDULED_PROC_ID']; // id periksa
		$omr['REQUESTED_PROC_DESC']=$omr['SCHEDULED_PROC_DESC']; // 
		$omr['SCHEDULED_PROC_STATUS']='120'; // permintaan baru
		$omr['STUDY_INSTANCE_UID']='1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
		$omr['IMAGING_REQUEST_COMMENTS']=$result['IMAGING_REQUEST_COMMENTS'];

		//$omr = $result;


		$str = implode('|',$omr);    
		// write_file(APPPATH.'/'.$omr['PATIENT_NAME'].'-'.$omr['ACCESSION_NO'].'.txt', $str);
		// if(!file_put_contents('c:\\WinNMP\pacs_order\\'.$omr['PATIENT_NAME'].'-'.$omr['ACCESSION_NO'].'.txt', $str)){
		// 	echo 'gagal disimpan';
		// }else{
		// 	echo 'sukses';
		// }
		// if(!file_put_contents('c:\\WinNMP\pacs_order\\'.$omr['PATIENT_NAME'].'-'.$omr['ACCESSION_NO'].'.txt', $str)){
	// if(!file_put_contents('c:\\WinNMP\pacs_order\\'.$omr['PATIENT_ID'].$count.'.txt', $str)){
			// echo 'gagal disimpan';
	// }else{
			// file_put_contents('c:\\WinNMP\\'.$omr['PATIENT_ID'].$count.'.txt', $str);
			// echo 'sukses';
	// }
		// $ftp['hostname'] = '192.168.115.61';
		// $ftp['username'] = 'administrator';
		// $ftp['password'] = 'P@55w0rd';
		// $ftp['debug'] = TRUE;

		// $this->ftp->connect($ftp);

		// $this->ftp->upload(APPPATH.'/text.txt', '\SourceReportIn_\text.txt', 'ascii', 0775);

		// $this->ftp->close();
	}

	public function st_selesai_kwitansi_kt($no_rad='')
	{
		if($no_rad!=''){
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_rad=''){
		// if ($penyetors=="" || $penyetors == null) 
		// {
			$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
		// 	$data['penyetor']=$data['data_pasien']->nama;
			
		// } else {
		// 	$data['penyetor'] = $penyetors;
			
		// }
		$data['no_rad'] = $no_rad;
		$data['jumlah_vtot']=$this->input->post('jumlah_vtot');
		$data['diskon']=$diskon;

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		$data['adm']=$this->radmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->radmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();

		if($no_rad!=''){
			$data['cterbilang']=new radcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");

			$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');

			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
			$data['no_register'] = $data['data_pasien']->no_register;

			$cek_cara = substr($data['no_register'],0,2);
			if($cek_cara == 'RJ' || $cek_cara == 'RI' ){
				$data['detail_daful']=$this->radmkwitansi->get_detail_daful($data['no_register'])->row();

			}


			$data['get_no_kwitansi'] = $this->radmkwitansi->get_no_kwitansi($data['no_register'])->row();
			
			// if(isset($data['get_no_kwitansi']->cash) != null){
			// 	$data['cash'] = $data['get_no_kwitansi']->cash;
			// }else{
			// 	$data['cash'] = 0;
			// }

			// if(isset($data['get_no_kwitansi']->noncash) != null){
			// 	$data['noncash'] = $data['get_no_kwitansi']->noncash;
			// }else{
			// 	$data['noncash'] = 0;
			// }

			$data['data_pemeriksaan']=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		
			$html = $this->load->view('rad/paper_css/kwitansi_rad',$data,true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/kwitansi_rad',$data);
		} else{

		}
	}

	public function cetak_kwitansi_kt_old($no_rad='',$penyetors='', $diskon="")
	{
		
		error_reporting(~E_ALL);
		
		if ($penyetors=="" || $penyetors == null) 
		{
			$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$penyetor=$data_pasien->nama;
			
		} else {
			$penyetor = $penyetors;
			
		}

	
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$data['diskon']=$diskon;

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;

		if($no_rad!=''){
			$cterbilang=new radcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			foreach($conf as $rowheader){
				$head_pdf =	$rowheader->value;
			}
			$header_pdf=$this->config->item('header_pdf');

			$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$no_register = $data_pasien->no_register;
			$get_no_kwitansi = $this->radmkwitansi->get_no_kwitansi($no_register)->row();
				
			$data_pemeriksaan=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			
			// $header_page = $top_header."<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\">".$bottom_header;
			$header_page = $top_header."<p align=\"center\">
											<img src=\"assets/img/".$logo_kesehatan_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>
									</td>
									<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
										<font style=\"font-size:12px\">
											<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
										</font>
										<font style=\"font-size:11px\">
											<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
											<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
										</font>    
										<br>
										<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
										<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
									</td>
									<td width=\"13%\">
										<p align=\"center\">
											<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>".$bottom_header;
			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					.table-font-size2{
						font-size:9px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page
					<hr>
					<p align=\"center\"><b>
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA DIAGNOSTIK<br/>
					No. DIA_$no_rad
					</b></p><br/>
					<table>
						<tr>
							<td width=\"15%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"38%\">".str_replace('%20', ' ', $penyetor)."</td>
							<td width=\"15%\"><b>Tanggal Periksa</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"28%\">$tgl</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->nama</td>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
						</tr>
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td><b>No Kwitansi</b></td>
							<td> : </td>
							<td>$get_no_kwitansi->no_kwitansi</td>
						</tr>
					</table>
					<br/><br/>
					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"65%\"><p align=\"center\"><b>Nama Pemeriksaan</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
					";
					$i=0;
					$no=1;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						$jumlah_vtot+=$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."
						<tr>
						  	<td><p align=\"center\">$no</p></td>
						  	<td>$row->jenis_tindakan</td>						  							  	
							<td><p align=\"center\">$row->qty</p></td>
							<td><p align=\"right\">$vtot</P></td>
						</tr>";
						$i++;

					}

					if(substr($data_pasien->no_register,0,2) == 'PL'){
						$konten=$konten."
						<tr>
						  	<td><p align=\"center\"></p></td>
						  	<td>Admin Pasien Luar</td>
						  	<td><p align=\"center\"></p></td>
						  	<td><p align=\"right\">5000</P></td>
						</tr>";

					}

				if(substr($data_pasien->no_register,0,2) == 'PL'){
					$jumlah_vtot+=5000;
							$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"center\"><b> Radiologi </b></p></th>
							<th><p align=\"right\"><b>".$i."   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
						}else{

							$konten=$konten."
							<tr>
								<th colspan=\"2\"><p align=\"center\"><b> Radiologi </b></p></th>
								<th><p align=\"right\"><b>".$i."   </b></p></th>
								<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
							</tr>";
						}
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Diskon   </b></p></th>
							<th><p align=\"right\">".number_format( $diskon, 2 , ',' , '.' )."</p></th>
						</tr>";
					$jumlah_vtot-=$diskon;
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total Bayar</b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				}

				if(substr($data_pasien->no_register,0,2) == 'PL'){
				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
				}else{
				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
				}
					
				$konten=$konten."
					</table>
					<br><br>
					<b width=\"50%\">
						<font size=\"9\">Terbilang<br>
							<i>".strtoupper($vtot_terbilang)."
						</font>
					</b><br>
					<table>
						<tr>
							<td></td>
							<td></td>
							<td>$kota_header, $tgl</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>an.Kepala Rumah Sakit</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>K a s i r</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>----------------------------------------</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ADMIN</td>
						</tr>
					</table>
					";
			
			$file_name="KW_$no_rad.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/rad/radkwitansi/'.$file_name, 'FI');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_detail_tagihan_rad($no_rad=''){
		$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
		$data['no_rad'] = $no_rad;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		$data['adm']=$this->radmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->radmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();

		if($no_rad!=''){
			$data['cterbilang']=new radcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");

			$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');

			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
			$data['no_register'] = $data['data_pasien']->no_register;

			$cek_cara = substr($data['no_register'],0,2);
			if($cek_cara == 'RJ' || $cek_cara == 'RI' ){
				$data['detail_daful']=$this->radmkwitansi->get_detail_daful($data['no_register'])->row();

			}
			$data['data_pemeriksaan']=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			// $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			// $mpdf->curlAllowUnsafeSslRequests = true;		
			// $html = $this->load->view('rad/paper_css/detail_tagihan_rad',$data,true);
			// //$this->mpdf->AddPage('L'); 
			// $mpdf->WriteHTML($html);
			// $mpdf->Output();
			$this->load->view('paper_css/detail_tagihan_rad',$data);
		} else{

		}
	}
	
}
?>