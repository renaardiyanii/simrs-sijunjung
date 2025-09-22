<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Labcterbilang.php');
//require_once(APPPATH.'controllers/Secure_area.php');

class labckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		redirect('lab/labckwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Laboratorium';
		$data['daftar_lab']=$this->labmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_lab'])==0){
			$this->session->set_flashdata('message_nodata','
					<div class="row">
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
		$this->load->view('lab/labvkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Laboratorium';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_lab']=$this->labmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_lab'])==0){
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
			$this->load->view('lab/labvkwitansi',$data);
		}else{
			redirect('lab/labckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Laboratorium';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_lab']=$this->labmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_lab'])==0){
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
			$this->load->view('lab/labvkwitansi',$data);
		}else{
			redirect('lab/labckwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_lab='')
	{
		$data['title'] = 'Cetak Kwitansi Laboratorium';
		if($no_lab!=''){
			$data['no_lab']=$no_lab;
			$data['data_pasien']=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			if(substr($data['data_pasien']->no_register,0,2) == 'PL'){
				$data_adm=$this->labmkwitansi->get_data_adm_pasien_luar()->row();
				// var_dump($data_adm);
				// die();
				$data['data_adm']=$this->labmdaftar->get_detail_tindakan($data_adm->idtindakan)->row();	
			}else{
				$data['data_adm']=array();
			}
			$data['data_pemeriksaan']=$this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();
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
			
			$this->load->view('lab/labvkwitansipasien',$data);
		}else{
			redirect('lab/labckwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt_()
	{
		$no_lab=$this->input->post('no_lab');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');

		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->labmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_lab!=''){
			$no_register=$this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			
			$this->labmkwitansi->update_status_cetak_kwitansi($no_lab, $diskon, $no_register, $xuser);

			$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
			$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
			$datak['xuser']=$user;
			$datak['xcreate']=date('Y-m-d H:i:s');
			$datak['no_register']=$no_register;
			$datak['nama_poli']='ADM';
			$datak['diskon']= $diskon;
			$datak['vtot_bayar']=$jumlah_vtot;
			$datak['tunai']=$jumlah_vtot-$diskon;
			$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');
			$datak['asal'] = 'HA00';
			$this->labmkwitansi->insert_nomorkwitansi($datak);

			
			$datank['no_register']=$no_register; 
			$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
			$datank['user_cetak']=$user;
			$datank['tgl_cetak']=date('Y-m-d H:i:s');
			$datank['jenis_kwitansi']= 'Laboratorium';
			$datank['dp']= 0;
			$datank['diskon']= $diskon;
			$datank['vtot_bayar']=$jumlah_vtot;
			$datank['tunai']=$jumlah_vtot-$diskon;
			$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
			$datank['asal'] = 'HA00';
			$this->labmkwitansi->insert_nokwitansi($datank);
			
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
			if(substr($no_register,0,2) == 'RJ') {
				$datares['component_id'] = 'HA00';
			} else {
				$datares['component_id'] = 'Pasien Luar';
			}
			$datares['method_pay'] = $this->input->post('pembayaran_hide');
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
			$datares['additional1'] = 'Labolatorium';
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';
			$this->rjmkwitansi->insert_registrasi($datares);

			//print_r($no_lab.' '.$diskon.' '.$no_register.' '.$xuser);
			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("lab/labckwitansi/cetak_kwitansi_kt/$no_lab").'", "_blank");window.focus()</script>';
			
			// redirect('lab/labckwitansi/cetak_kwitansi_kt/'.$no_lab.'/'.$penyetor.'/'.$diskon,'refresh');
		}else{
			redirect('lab/labckwitansi/kwitansi/','refresh');
		}
	}

	public function st_cetak_kwitansi_kt()
	{
		// var_dump($this->input->post());die();
		$no_lab=$this->input->post('no_lab');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');

		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->labmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_lab!=''){
			$no_register=$this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$ket=$this->input->post('pembayaran_hide');

			if($ket == 'PIUTANG/IKS'){

				$data_piutang['no_register'] = $no_register;
				$data_piutang['jns_kwitansi'] = 'Laboratorium';
				$data_piutang['total_tagihan']= (int)$jumlah_vtot;
				$data_piutang['created_date']= date('Y-m-d h:i:s');
				$data_piutang['created_by']= $user;
				$data_piutang['nama'] = $data_pasien->nama;
				$data_piutang['medrec'] = $data_pasien->no_medrec;
				$data_piutang['asal'] = 'HA00';
				$data_piutang['cara_bayar'] = $data_pasien->cara_bayar;
				$data_piutang['no_lab'] = $no_lab;
				$this->rjmkwitansi->insert_header_piutang($data_piutang);
				$this->labmkwitansi->update_status_piutang_lab($no_lab, $diskon, $no_register, $xuser);

			} else {
				$this->labmkwitansi->update_status_cetak_kwitansi($no_lab, $diskon, $no_register, $xuser);
				$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$datak['xuser']=$user;
				$datak['xcreate']=date('Y-m-d H:i:s');
				$datak['no_register']=$no_register;
				$datak['nama_poli']='ADM';
				$datak['diskon']= $diskon;
				$datak['vtot_bayar']=$jumlah_vtot;
				$datak['tunai']=$jumlah_vtot-$diskon;
				$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');
				$datak['asal'] = 'HA00';
				// if($ket == 'split'){
				// 	$datak['cash']=(int)$this->input->post('biaya_tunai_hide');
				// 	$datak['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				// }else{
				// 	$datak['cash']=0;
				// 	$datak['noncash']=0;
				// }
				$this->labmkwitansi->insert_nomorkwitansi($datak);

				
				$datank['no_register']=$no_register; 
				$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
				$datank['user_cetak']=$user;
				$datank['tgl_cetak']=date('Y-m-d H:i:s');
				$datank['jenis_kwitansi']= 'Laboratorium';
				$datank['dp']= 0;
				$datank['diskon']= $diskon;
				$datank['vtot_bayar']=$jumlah_vtot;
				$datank['tunai']=$jumlah_vtot-$diskon;
				$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
				$datank['asal'] = 'HA00';
				// if($ket == 'split'){
				// 	$datank['cash']=(int)$this->input->post('biaya_tunai_hide');
				// 	$datank['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				// }else{
				// 	$datank['cash']=0;
				// 	$datank['noncash']=0;
				// }
				$this->labmkwitansi->insert_nokwitansi($datank);
				
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
				if(substr($no_register,0,2) == 'RJ') {
					$datares['component_id'] = 'HA00';
				} else {
					$datares['component_id'] = 'Pasien Luar';
				}
				$datares['method_pay'] = $this->input->post('pembayaran_hide');
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
				$datares['additional1'] = 'Labolatorium';
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

			//print_r($no_lab.' '.$diskon.' '.$no_register.' '.$xuser);
			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("lab/labckwitansi/cetak_kwitansi_kt/$no_lab").'", "_blank");window.focus()</script>';
			
			// redirect('lab/labckwitansi/cetak_kwitansi_kt/'.$no_lab.'/'.$penyetor.'/'.$diskon,'refresh');
		}else{
			redirect('lab/labckwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_lab='')
	{
		if($no_lab!=''){
			redirect('lab/labckwitansi/kwitansi/','refresh');
		}else{
			redirect('lab/labckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_lab='', $penyetors='' , $diskon=""){
		$xuser=$this->input->post('xuser');
		$data['no_lab'] = $no_lab;
		$data['penyetors'] = $penyetors;
		// $get_penyetor = $this->input->post('penyetor');
		
		if ($penyetors=="" || $penyetors == null) 
		{
			$data['data_pasien']=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data['penyetor']=$data['data_pasien']->nama;
		} else {
			$data['penyetor']=$penyetors;
		}

		$data['jumlah_vtot']=$this->input->post('jumlah_vtot');
		$data['diskon']=$diskon;
		// var_dump($data['diskon']);die();
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		
		$data['adm']=$this->labmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->labmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();	

		if($no_lab!=''){
			$data['cterbilang']=new labcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");


			$data['data_pasien']=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');

			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];

			

			$data['no_register'] = $data['data_pasien']->no_register;
			$data['get_no_kwitansi'] = $this->labmkwitansi->get_no_kwitansi($data['no_register'])->result();

			
		//		print_r($detail_daful);die();
		// var_dump($data['detail_daful']);die();
			$cek_cara_bayar = substr($data['no_register'],0,2);
			if($cek_cara_bayar == 'RJ' || $cek_cara_bayar == 'RI' ){
				$data['detail_daful']=$this->labmkwitansi->get_detail_daful($data['no_register'])->row();	
				if($data['detail_daful']->cara_bayar=='UMUM'){
					$data['pasien_bayar']='TUNAI';
				}else {$data['pasien_bayar']='KREDIT';}

			}

			
			
			foreach($data['get_no_kwitansi'] as $rowkwi){
				$data['kwitansi'] =	$rowkwi->no_kwitansi;
				// if($rowkwi->cash != null){
				// 	$data['cash'] =	$rowkwi->cash;
				// }else{
				// 	$data['cash'] =	0;
				// }
				
				// if($rowkwi->noncash != null){
				// 	$data['noncash'] =	$rowkwi->noncash;
				// }else{
				// 	$data['noncash'] =	0;
				// }
			}
			
			$data['data_pemeriksaan']=$this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		
			$html = $this->load->view('lab/paper_css/kwitansi_lab',$data,true);
			
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			//  $this->load->view('paper_css/kwitansi_lab',$data);
		}else{

		}
	}

	public function cetak_kwitansi_kt_old($no_lab='', $penyetors='')
	{
		error_reporting(~E_ALL);
		$xuser=$this->input->post('xuser');
		// $get_penyetor = $this->input->post('penyetor');
		
		if ($penyetors=="" || $penyetors == null) 
		{
			$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$penyetors;
		}

		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;

		
		$adm=$this->labmkwitansi->get_data_adm_pasien_luar()->row();
		$data_adm=$this->labmdaftar->get_detail_tindakan($adm->idtindakan)->row();	

		if($no_lab!=''){
			$cterbilang=new labcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			foreach($conf as $rowheader){
				$head_pdf =	$rowheader->value;
			}
			$header_pdf=$this->config->item('header_pdf');

			$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();

			$no_register = $data_pasien->no_register;
			$get_no_kwitansi = $this->labmkwitansi->get_no_kwitansi($no_register)->result();
			
			foreach($get_no_kwitansi as $rowkwi){
				$kwitansi =	$rowkwi->no_kwitansi;
			}
			
			$data_pemeriksaan=$this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();

			
			
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
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA LABORATORIUM<br/>
					No. LAB_$no_lab
					</b></p>
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
							<td>$kwitansi</td>
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
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
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
						  	<td>$data_adm->nmtindakan</td>
						  	<td><p align=\"center\"></p></td>
						  	<td><p align=\"right\">$data_adm->total_tarif</P></td>
						</tr>";
						$jumlah_vtot += $data_adm->total_tarif;
					}
						

				

						
							$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"center\"><b> Laboratorium </b></p></th>
							<th><p align=\"right\"><b>".$i."   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Diskon   </b></p></th>
							<th><p align=\"right\">".number_format( $diskon, 2 , ',' , '.' )."</p></th>
						</tr>";
					$jumlah_vtot=$jumlah_vtot-$diskon;
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total Bayar</b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				}

				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
				
					
				$konten=$konten."
					</table>
					<br><br>
					<b width=\"50%\">
						<font size=\"9\">Terbilang : 
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
			
			$file_name="KW_$no_lab.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
				$obj_pdf->Output(FCPATH.'download/lab/labkwitansi/'.$file_name, 'FI');
		}else{
			redirect('lab/labckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_gelang($no_register='')
	{
		error_reporting(~E_ALL);
		
		// echo NAMA_RS;die();
		$a = $this->db->query("SELECT * FROM app_config WHERE key = 'top_pdf'")->row();
		$b = $this->db->query("SELECT * FROM app_config WHERE key = 'bottom_pdf'")->row();
		// $c = $this->db->query("SELECT * FROM app_config WHERE key = 'isi'")->row();
		// print_r($a->value.);
		// echo $c->value;
		// echo $a->value.$b->value;
		// die();
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			//$cterbilang=new rjcterbilang();
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			//$tgl_jam = date("d-m-Y H:i:s");
			$tgl_jam = date("d-m-Y ");
			$tgl = date("d-m-Y");
			// $contoh_barcode = set_barcode('TEsting');
			// echo $contoh_barcode;
			// die();
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->labmkwitansi->getdata_pasien_sjp($no_register)->row();
			// print_r($data_pasien);
			//$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			//$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			// if(substr($data_pasien->noregasal,0,2)=='RD'){
			// 	$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			// }else{
			// 	$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			// }

			if($data_pasien->sex=='L'){
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			if($data_pasien->carabayar=='BPJS'){
				$cara_bayar=$data_pasien->carabayar;
			} else {
				$cara_bayar='JAMSOSKES';
			}

			// if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
			// 	$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			// } else {
			// 	$tgl_rujukan = '';
			// }

			// $asal_rujukan=$data_asal->asal_rujukan;
			// if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
			// 	$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			// }
			// if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}

			$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
			$thn=$interval->format("%Y Tahun");
			
			
			
			$style = array(
				'border' => false,
				'padding' => 0,
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			// $barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_register.'">';

			$file_name="GELANG_$no_register.pdf";			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();			
			$pageLayout = array('80', '150'); //  or array($height, $width) 
			$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);				
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
			$obj_pdf->SetMargins('1', '1', '1');
			$obj_pdf->SetAutoPageBreak(TRUE, '1');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'C128', '', '', 50, 15, 0.4, array('position'=>'T', 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>4, 'stretchtext'=>4), 'N'));
			

			$konten=
		
			



			// "<style type=\"text/css\">
			// 		.table-font-size{
			// 			font-size:5px;
			// 		    }
			// 		.table-font-size1{
			// 			font-size:7px;
			// 			margin : 0.5px 1px 0.5px 1px;
			// 			padding : 1px 1px 0.5px 1px;
			// 			width:100%; height:100%;
			// 		    }
			// 		</style>
			// 		<br><br>
			// 		<table class=\"table-font-size1\" border=\"0\">
			// 			<tr>
			// 				<td width=\"16%\"></td>
			// 				<td align=\"center\" rowspan=\"3\" width=\"7%\">
			// 					<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"27\" style=\"\">
			// 				</td>
			// 				<td width=\"37%\">$data_pasien->nama</td>	
			// 				<td width=\"40%\" align=\"left\">No Medrec : $data_pasien->no_cm</td>
			// 			</tr>
			// 			<tr>	
			// 				<td></td>
			// 				<td>$jk</td>					
			// 				<td align=\"left\">No Register : $data_pasien->no_ipd</td>				
			// 			</tr>
			// 			<tr>	
			// 				<td align=\"right\"><font size=\"5px\">$tgl_jam</font></td>
			// 				<td>".date("d-m-Y",strtotime(substr($data_pasien->tgl_lahir,0,10)))." (".$thn.")</td>		
			// 				<td align=\"left\">$data_ruang->nmruang, Bed $bed</td>				
			// 			</tr>
			// 		</table >";

			



					'<style type="text/css">
					.table-font-size{
						font-size:5px;
					    }
					.table-font-size1{
						font-size:5px;
						margin : 0px 1px 0.5px 1px;
						padding : 0px 1px 0.5px 1px;
						width:100%; 
						height:100%;
					    }
					</style>
					<br><br>
					<table class="table-font-size1" border="0">
						<tr>
							<td colspan="3">
							<b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b>
							</td>
						</tr>
						<tr>
							<td colspan="3">
							
							</td>
						</tr>
						<tr>
							<td width="45%">'.$data_pasien->nama.'</td>	
							<td align="left">'.$data_pasien->no_cm.'</td>
						</tr>
						<tr>	
							<td width="45%">No Register: '.$data_pasien->no_register.'</td>	
							<td width="45%">Tgl Lahir:'.date('d-m-Y',strtotime(substr($data_pasien->tgl_lahir,0,10))).' <br>('.$thn.')</td>
						</tr>
						<tr>
							<td style="padding:100px;">';
							$konten.= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
							$konten.='</td>
						</tr>
					</table >
					';
					// $konten.= NAMA_RS;

			//echo $konten;
				// $c = $a->value.$b->value;			
				// $konten .= TOP_HEADER;
				// $konten .= ISI;
				// $konten .= BOTTOM_HEADER;
				$content = $konten;
				
				// ob_end_clean();
				// $content .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
				// $pdf->SetAutoPageBreak(TRUE, 0);
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				// $obj_pdf->write1DBarcode($no_register, 'C128B', '', 10, 50, 20, 2, $style,'N');
				$obj_pdf->Output(FCPATH.'download/inap/gelang/'.$file_name, 'FI');
		}else{
			redirect('lab/labcdaftar/','refresh');
		}
	}

	public function cetak_detail_tagihan_lab($no_lab=''){
		
		$data['no_lab'] = $no_lab;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['adm']=$this->labmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->labmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();	

		if($no_lab!=''){
			$data['cterbilang']=new labcterbilang();
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");
			$data['data_pasien']=$this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');
			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
			$data['no_register'] = $data['data_pasien']->no_register;
			// $data['get_no_kwitansi'] = $this->labmkwitansi->get_no_kwitansi($data['no_register'])->result();

			$cek_cara_bayar = substr($data['no_register'],0,2);
			if($cek_cara_bayar == 'RJ' || $cek_cara_bayar == 'RI' ){
				$data['detail_daful']=$this->labmkwitansi->get_detail_daful($data['no_register'])->row();	
				if($data['detail_daful']->cara_bayar=='UMUM'){
					$data['pasien_bayar']='TUNAI';
				}else {$data['pasien_bayar']='KREDIT';}

			}
			$data['data_pemeriksaan']=$this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();
			// $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			// $mpdf->curlAllowUnsafeSslRequests = true;		
			// $html = $this->load->view('lab/paper_css/detail_tagihan_lab',$data,true);
			// //$this->mpdf->AddPage('L'); 
			// $mpdf->WriteHTML($html);
			// $mpdf->Output();
			$this->load->view('paper_css/detail_tagihan_lab',$data);
		}else{

		}
	}
}
?>