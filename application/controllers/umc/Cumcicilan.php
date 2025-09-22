<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Rjcterbilang.php');

require_once(APPPATH.'controllers/Secure_area.php');
require_once(APPPATH.'helpers/tcpdf/tcpdf.php');
class MYPDF extends TCPDF {  
	//$this->load->helper('pdf_helper');
       // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-8);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
	date_default_timezone_set("Asia/Jakarta");			
	$tgl_jam = date("d-m-Y H:i:s");
        $this->Cell(0, 0, '', 0, false, 'L', 0, '', 0, false, 'T', 'M');    
	$this->Cell(0, 10, $this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');  
        }      
    }
class Cumcicilan extends Secure_area{
	public function __construct() {
		parent::__construct();

		$this->load->model('umc/mumcicilan','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		// $cterbilang=new rjcterbilang();
		// echo $cterbilang->terbilang(100);
		redirect('irj/rjcregistrasi','refresh');
	}
	
	public function irj()
	{
		$data['title'] = 'Daftar Uang Muka / Cicilan Pasien Rawat Jalan';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$dateawal=$this->input->post('date0');
		$dateakhir=$this->input->post('date1');
		$data['tgl_awal']=date('d-m-Y', strtotime($dateawal));
		$data['tgl_akhir']=date('d-m-Y', strtotime($dateakhir));
		if($dateawal=='' && $dateakhir=='')
		{
			$data['tgl_awal']=date('d-m-Y', strtotime('-7 days', time()));
			$dateawal=date('Y-m-d', strtotime('-7 days', time()));
			$dateakhir=date('Y-m-d');
			$data['tgl_akhir']=date('d-m-Y');
		}
		$data['url']='';
		$data['pasien_umc']=$this->mumcicilan->get_all_pasien_cicilan_irj($dateawal,$dateakhir)->result();
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('umc/umcviewlist',$data);
	}

	public function input_irj($no_medrec='')
	{
		$data['title'] = 'Input Uang Muka / Cicilan Pasien Rawat Jalan';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		
		$data['url']='';
		$data['pasien_umc']=$this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_medrec)->row();
		$data['last_daful']=$this->rjmregistrasi->get_pasien_last_daful($no_medrec)->row();
		$data['detail_cicilan']=$this->mumcicilan->get_max_cicilan_ke($data['last_daful']->no_register)->row()->last_cicilan;
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('umc/umcviewinput',$data);
	}

	public function iri()
	{
		$data['title'] = 'Input Uang Muka / Cicilan Pasien Rawat Inap';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$date=$this->input->post('tgl');
		if($date==''){
			$date=date('Y-m-d');
		}
		$data['url']='';
		$data['pasien_daftar']=$this->rjmkwitansi->get_pasien_kwitansi($date)->result();
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('irj/rjvkwitansi',$data);
	}

	public function cari()
	{
		$data['title'] = 'Pencarian Pasien';
		$this->load->view('umc/umcviewlistpasien',$data);	
	}

	public function pasien()
	{
		$data['data_pasien']='';
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
		}	
		else if($this->input->post('cari_no_cm_lama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_cm_lama'))->result();
		}	
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
		}else if($this->input->post('cari_no_nrp')!=''){
			//mystring.replace(/,/g , ":")
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nrp($this->input->post('cari_no_nrp'))->result();
		}
		
		// if (empty($data['data_pasien'])) 
		// {
		// 	$success = 	'<div class="alert alert-danger">
  //                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  //                           <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
  //                       </div>';
  //           echo json_encode(0);
		// 	//$this->session->set_flashdata('success_msg', $success);
		// 	//redirect('irj/rjcregistrasi');
		
		// } else {
			//echo json_encode($this->input->post('cari_no_nrp'));
			echo json_encode($data['data_pasien']);
			//$this->load->view('irj/rjvformcaripasien',$data);
		// }
		
	}

}
?>