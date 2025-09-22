<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Emcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');

class Emckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('elektromedik/emmdaftar','',TRUE);
		$this->load->model('elektromedik/emmkwitansi','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('elektromedik/emckwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		$data['daftar_em']=$this->emmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_em'])==0){
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
		$this->load->view('elektromedik/emvkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_em']=$this->emmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_em'])==0){
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
			$this->load->view('elektromedik/emvkwitansi',$data);
		}else{
			redirect('elektromedik/emckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_em']=$this->emmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_em'])==0){
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
			$this->load->view('elektromedik/emvkwitansi',$data);
		}else{
			redirect('elektromedik/emckwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_em='')
	{
		$data['title'] = 'Cetak Kwitansi Diagnostik';
		if($no_em!=''){
			$data['no_em']=$no_em;
			$data['data_pasien']=$this->emmkwitansi->get_data_pasien($no_em)->row();
			if(substr($data['data_pasien']->no_register,0,2) == 'PL'){
				$data_adm=$this->emmkwitansi->get_data_adm_pasien_luar()->row();
				$data['data_adm']=$this->emmkwitansi->get_detail_tindakan($data_adm->idtindakan)->row();	
			}else{
				$data['data_adm']=array();
			}
			$data['data_pemeriksaan']=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();
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
			
			$this->load->view('elektromedik/emvkwitansipasien',$data);
		}else{
			redirect('elektromedik/emckwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt_()
	{
		$no_em=$this->input->post('no_em');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->emmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_em!=''){
			$no_register=$this->emmdaftar->get_row_register_by_noem($no_em)->row()->no_register;
			$this->emmkwitansi->update_status_cetak_kwitansi($no_em, $diskon, $no_register, $xuser);


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
			$datak['asal'] = 'ME00';

			$this->emmkwitansi->insert_nomorkwitansi($datak);

			$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
			$datank['no_register']=$no_register; 
			$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
			$datank['user_cetak']=$xuser;
			$datank['tgl_cetak']=date('Y-m-d H:i:s');
			$datank['jenis_kwitansi']= 'Elektromedik';
			$datank['dp']= 0;
			$datank['diskon']= $diskon;
			$datank['vtot_bayar']=$jumlah_vtot;
			$datank['tunai']=$jumlah_vtot-$diskon;
			$datank['asal'] = 'ME00';
			$this->emmkwitansi->insert_nokwitansi($datank);

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
				$datares['component_id'] = 'ME00';
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
			$datares['additional1'] = 'Elektromedik';
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("elektromedik/emckwitansi/cetak_kwitansi_kt/$no_em").'", "_blank");window.focus()</script>';
			
			// redirect('elektromedik/emckwitansi/cetak_kwitansi_kt/'.$no_em,'refresh');
		}else{
			redirect('elektromedik/emckwitansi/kwitansi/','refresh');
		}
	}

	public function st_cetak_kwitansi_kt()
	{
		// var_dump($this->input->post());die();
		$no_em=$this->input->post('no_em');
		$xuser=$this->input->post('xuser');
		$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=isset($kasir->kasir)?$kasir->kasir:'';
		$nomor=$this->emmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($diskon==""){
			$diskon = 0;
		}
		if($no_em!=''){
			$no_register=$this->emmdaftar->get_row_register_by_noem($no_em)->row()->no_register;
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$ket=$this->input->post('pembayaran_hide');
			if($ket == 'PIUTANG/IKS'){
				$data_piutang['no_register'] = $no_register;
				$data_piutang['jns_kwitansi'] = 'Elektromedik';
				$data_piutang['total_tagihan']= (int)$jumlah_vtot;
				$data_piutang['created_date']= date('Y-m-d h:i:s');
				$data_piutang['created_by']= $user;
				$data_piutang['nama'] = $data_pasien->nama;
				$data_piutang['medrec'] = $data_pasien->no_medrec;
				$data_piutang['asal'] = 'ME00';
				$data_piutang['cara_bayar'] = $data_pasien->cara_bayar;
				$data_piutang['no_em'] = $no_em;
				$this->rjmkwitansi->insert_header_piutang($data_piutang);
				$this->emmkwitansi->update_status_piutang_em($no_em, $diskon, $no_register, $xuser);
			} else{

				$this->emmkwitansi->update_status_cetak_kwitansi($no_em, $diskon, $no_register, $xuser);
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
				$datak['asal'] = 'ME00';
				if($ket == 'split'){
					$datak['cash']=(int)$this->input->post('biaya_tunai_hide');
					$datak['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				}else{
					$datak['cash']=0;
					$datak['noncash']=0;
				}

				$this->emmkwitansi->insert_nomorkwitansi($datak);

				$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
				$datank['no_register']=$no_register; 
				$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
				$datank['user_cetak']=$xuser;
				$datank['tgl_cetak']=date('Y-m-d H:i:s');
				$datank['jenis_kwitansi']= 'Elektromedik';
				$datank['dp']= 0;
				$datank['diskon']= $diskon;
				$datank['vtot_bayar']=$jumlah_vtot;
				$datank['tunai']=$jumlah_vtot-$diskon;
				$datank['asal'] = 'ME00';
				if($ket == 'split'){
					$datank['cash']=(int)$this->input->post('biaya_tunai_hide');
					$datank['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				}else{
					$datank['cash']=0;
					$datank['noncash']=0;
				}
				$this->emmkwitansi->insert_nokwitansi($datank);

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
					$datares['component_id'] = 'ME00';
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
				$datares['additional1'] = 'Elektromedik';
				$datares['additional2'] = '0';
				$datares['additional3'] = '0';
				if($ket == 'split'){
					$datares['cash']=(int)$this->input->post('biaya_tunai_hide');
					$datares['noncash']=(int)$this->input->post('biaya_non_tunai_hide');
				}else{
					$datares['cash']=0;
					$datares['noncash']=0;
				}
				$this->rjmkwitansi->insert_registrasi($datares);
			}

			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("elektromedik/emckwitansi/cetak_kwitansi_kt/$no_em").'", "_blank");window.focus()</script>';
			
			// redirect('elektromedik/emckwitansi/cetak_kwitansi_kt/'.$no_em,'refresh');
		}else{
			redirect('elektromedik/emckwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_em='')
	{
		if($no_em!=''){
			redirect('elektromedik/emckwitansi/kwitansi/','refresh');
		}else{
			redirect('elektromedik/emckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_em=''){
		// if ($penyetors=="" || $penyetors == null) 
		// {
		// 	$data['data_pasien']=$this->emmkwitansi->get_data_pasien($no_em)->row();
		// 	$data['penyetor']=$data['data_pasien']->nama;
			
		// } else {
		// 	$data['penyetor'] = $penyetors;
			
		// }
		$data['no_em'] = $no_em;
		$data['jumlah_vtot']=$this->input->post('jumlah_vtot');
		//$data['diskon']=$diskon;

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		$data['adm']=$this->emmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->emmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();

		
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');
		if($no_em!=''){
		$data['cterbilang']=new emcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");

			

			$data['data_pasien']=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');
			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
			$data['no_register'] = $data['data_pasien']->no_register;
			$get_no_kwitansi = $this->emmkwitansi->get_no_kwitansi($data['no_register'])->row();
			$data['no_kwitansi'] = $get_no_kwitansi;

			if(isset($get_no_kwitansi->cash) != null){
				$data['cash'] = $get_no_kwitansi->cash;
			}else{
				$data['cash'] = 0;
			}

			if(isset($get_no_kwitansi->noncash) != null){
				$data['noncash'] = $get_no_kwitansi->noncash;
			}else{
				$data['noncash'] = 0;
			}

			$cek_cara_ = substr($data['no_register'],0,2);
			if($cek_cara_ == 'RJ' || $cek_cara_ == 'RI' ){
				$data['detail_daful']=$this->emmkwitansi->get_detail_daful($data['no_register'])->row();	

			}
			$data['data_pemeriksaan']=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		

			$html = $this->load->view('elektromedik/paper_css/kwitansi_em',$data,true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/kwitansi_em',$data);
		}else{

		}

	}

	public function cetak_kwitansi_kt_old($no_em='',$penyetors='')
	{
		
		error_reporting(~E_ALL);
		
		if ($penyetors=="" || $penyetors == null) 
		{
			$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$penyetor=$data_pasien->nama;
			
		} else {
			$penyetor = $penyetors;
			
		}

		
		
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;

		if($no_em!=''){
			$cterbilang=new emcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			foreach($conf as $rowheader){
				$head_pdf =	$rowheader->value;
			}
			$header_pdf=$this->config->item('header_pdf');

			$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$no_register = $data_pasien->no_register;
			$get_no_kwitansi = $this->emmkwitansi->get_no_kwitansi($no_register)->row();
				
			$data_pemeriksaan=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();
			
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
					No. DIA_$no_em
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
						  	<td>Admin Pasien Luar</td>
						  	<td><p align=\"center\"></p></td>
						  	<td><p align=\"right\">5000</P></td>
						</tr>";

					}

				if(substr($data_pasien->no_register,0,2) == 'PL'){
							$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"center\"><b> Diagnostik </b></p></th>
							<th><p align=\"right\"><b>".$i."   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot+5000, 2 , ',' , '.' )."</p></th>
						</tr>";
						}else{

							$konten=$konten."
							<tr>
								<th colspan=\"2\"><p align=\"center\"><b> Diagnostik </b></p></th>
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
					$jumlah_vtot=$jumlah_vtot-$diskon;
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total Bayar</b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				}

				if(substr($data_pasien->no_register,0,2) == 'PL'){
					$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot+5000);
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
			
			$file_name="KW_$no_em.pdf";
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
				$obj_pdf->Output(FCPATH.'download/'.$file_name, 'FI');
		}else{
			redirect('elektromedik/emckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_detail_tagihan_em($no_em=''){
		$data['no_em'] = $no_em;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		$data['adm']=$this->emmkwitansi->get_data_adm_pasien_luar()->row();
		$data['data_adm']=$this->emmdaftar->get_detail_tindakan($data['adm']->idtindakan)->row();

		
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');
		if($no_em!=''){
		$data['cterbilang']=new emcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");

			

			$data['data_pasien']=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');
			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
			$data['no_register'] = $data['data_pasien']->no_register;

			$cek_cara_ = substr($data['no_register'],0,2);
			if($cek_cara_ == 'RJ' || $cek_cara_ == 'RI' ){
				$data['detail_daful']=$this->emmkwitansi->get_detail_daful($data['no_register'])->row();	

			}
			$data['data_pemeriksaan']=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();

			// $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			// $mpdf->curlAllowUnsafeSslRequests = true;		

			// $html = $this->load->view('elektromedik/paper_css/kwitansi_em',$data,true);
			// //$this->mpdf->AddPage('L'); 
			// $mpdf->WriteHTML($html);
			// $mpdf->Output();
			$this->load->view('paper_css/detail_tagihan_em',$data);
		}else{

		}

	}
	
}
?>