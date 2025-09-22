<?php
// rawosi
defined('BASEPATH') OR exit('No direct script access allowed');
include('Fcterbilang.php');
 
//require_once(APPPATH.'controllers/Secure_area.php');
class Fcrekap extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('faktur/fmrekap','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('faktur/fcrekap','refresh');
	}
	
	public function rawat_jalan()
	{
		$data['title'] = 'Rekap Faktur Rawat Jalan';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('Y-m-d',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj_by_date($date)->result();
			
		}else{
		$data['date'] = date('Y-m-d');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj($data['date'])->result();
		
		}

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		// print_r($data['pasien_daftar']);die();
		$this->load->view('faktur/fvrekap_irj',$data);
	}

	public function rawat_jalan_by_no() {
		$data['title'] = 'Rekap Faktur Rawat Jalan';
		$no_cm = $this->input->post('no_cm');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj_by_cm($no_cm)->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		// print_r($data['pasien_daftar']);die();
		$this->load->view('faktur/fvrekap_irj',$data);
	}

	public function rawat_jalan_batal()
	{
		$data['title'] = 'Kwitansi Batal Rawat Jalan';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = $date;
		//	print_r($date);die();
			$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj_by_date_batal($date)->result();
			
		//	print_r($data['pasien_daftar']);die();
		}

		else{
		$data['date'] = date('m-Y');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj_batal()->result();
		
		}

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		// print_r($data['pasien_daftar']);die();
		$this->load->view('faktur/fvrekap_irj_batal',$data);
	}

	public function rawat_inap()
	{ 
		$data['title'] = 'Rekap Faktur Rawat Inap';
		
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_pasien_kwitansi_iri_by_date($date)->result();
		
		}else{
		$data['date'] = date('d-m-Y');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_iri()->result();
		
		}

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		
		$this->load->view('faktur/fvrekap_iri',$data);
	}

	public function rawat_inap_by_no() {
		$data['title'] = 'Rekap Faktur Rawat Inap';
		
		$no_cm=$this->input->post('no_cm');

		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_iri_by_cm($no_cm)->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		
		$this->load->view('faktur/fvrekap_iri',$data);
	}
	
	public function rawat_darurat()
	{
		$data['title'] = 'Rekap Faktur Gawat Darurat';
		$date=$this->input->post('date');
		$setor='';
		echo '<script type="text/javascript">document.cookie = "penyetor='.$setor.'";</script>';
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_pasien_kwitansi_ird_by_date($date)->result();		
		}else{
			$data['date'] = date('Y-m-d');
			$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_ird($data['date'])->result();
		}
		$this->load->view('faktur/fvrekap_ird',$data);
		
	}
	public function faktur_ird($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/ird/rdkwitansi/'.$link));
	}
	
	public function faktur_irj($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/'.$link));
	}	
	
	public function lab()
	{
		
      	$data['title'] = 'Rekap Faktur Laboratorium';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_lab']=$this->fmrekap->get_rekap_lab_by_date($date)->result();
        }else{
		$data['date'] = date('d-m-Y');
		$data['daftar_lab']=$this->fmrekap->get_rekap_lab_by_key()->result();
		}

		$login_data = $this->load->get_var("user_info");
		 $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$this->load->view('faktur/fvrekap_lab',$data);
	}

	public function faktur_lab($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/lab/labfaktur/'.$link));
	}
	public function kwitansi_lab($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/lab/labkwitansi/'.$link));
	}
	
	public function rad()
	{
		     
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_rad']=$this->fmrekap->get_rekap_rad_by_date($date)->result();
        }else{
		$data['date'] = date('d-m-Y');
		$data['daftar_rad']=$this->fmrekap->get_rekap_rad_by_key()->result();
		}

		$login_data = $this->load->get_var("user_info");
		 $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$this->load->view('faktur/fvrekap_rad',$data);
	}

	public function em() {
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_rad']=$this->fmrekap->get_rekap_em_by_date($date)->result();
        }else{
		$data['date'] = date('d-m-Y');
		$data['daftar_rad']=$this->fmrekap->get_rekap_em_by_key()->result();
		}

		$login_data = $this->load->get_var("user_info");
		 $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$this->load->view('faktur/fvrekap_em',$data);
	}

	public function faktur_rad($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/rad/radfaktur/'.$link));
	}
	public function kwitansi_rad($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/rad/radkwitansi/'.$link));
	}
	
	public function frm()
	{
		$data['title'] = 'Rekap Faktur & Kwitansi Farmasi';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm_by_date($date)->result();
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm_by_key()->result();
		}
         
         $login_data = $this->load->get_var("user_info");
		 $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$this->load->view('faktur/fvrekap_frm',$data);
	}
	

	public function frm_ir()
	{
		$data['title'] = 'Rekap Faktur & Kwitansi Farmasi';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm_by_date_ir($date)->result();
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm_ir()->result();
		}
		$this->load->view('faktur/fvrekap_frm',$data);
	}
	public function faktur_frm($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/farmasi/frmkwitansi/'.$link));
	}

	public function ok()
	{
		$data['title'] = 'Rekap Operasi';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_ok']=$this->fmrekap->get_rekap_ok_date($date)->result();		
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_ok']=$this->fmrekap->get_rekap_ok_by_key()->result();
		}


         $login_data = $this->load->get_var("user_info");
		 $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$this->load->view('faktur/fvrekap_ok',$data);
	}

	public function faktur_ok($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/ok/okfaktur/'.$link));
	}

	public function kwitasi_ok($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/ok/okkwitansi/'.$link));
	}

	//pembayaran_RI00000008_Tentara_Coba
	//"detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf"
	public function kw_iri($noreg)
	{
		$data1=$this->fmrekap->get_data_pasien_by_noreg($noreg)->row();
		$nama = str_replace(" ","_",$data1->nama);	
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/inap/laporan/pembayaran/detail_pembayaran_'.$noreg.'_'.$nama.' .pdf'));
	}

	//detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien."_faktur.pdf
	public function faktur_iri($noreg)
	{
		$data1=$this->fmrekap->get_data_pasien_by_noreg($noreg)->row();
		$nama = str_replace(" ","_",$data1->nama);	
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/inap/laporan/pembayaran/detail_pembayaran_'.$noreg.'_'.$nama.'_faktur.pdf'));
	}

	public function kw_irj_1($noreg)
	{
		if(file_exists(FCPATH.'download/irj/rjkwitansi/IRJ_MR_'.$noreg.'.pdf')){
			$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/IRJ_MR_'.$noreg.'.pdf'));
       }else{
       		$this->session->set_flashdata('message_cetak','<div class="alert alert-danger" id="diag_alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h4 class="text-danger"><i class="fa fa-ban"></i> Kwitansi Pendaftaran Pasien dengan No. Reg '.$noreg.' Belum Dicetak !</h4>
                </div>');
       		redirect('faktur/fcrekap/rawat_jalan','refresh');
       }
	}
	public function kw_irj_2($noreg)
	{
		if(file_exists(FCPATH.'download/irj/rjkwitansi/IRJ_'.$noreg.'.pdf')){
		    $url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/IRJ_'.$noreg.'.pdf'));
		} else {
			$this->session->set_flashdata('message_cetak','<div class="alert alert-danger" id="diag_alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h4 class="text-danger"><i class="fa fa-ban"></i> Kwitansi Pasien dengan No. Reg '.$noreg.' Belum Dicetak !</h4>
                </div>');
		    redirect('faktur/fcrekap/rawat_jalan','refresh');
		}
		
	}
	public function kwitansi_frm($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/farmasi/frmkwitansi/'.$link));
	}
	
	public function pa()
	{
		$date=$this->input->post('date');
		$key=$this->input->post('key');
		if($key!='') { 
			$data['title'] = 'Rekap Faktur Patologi Anatomi "'.$key.'"';
			$data['daftar_pa']=$this->fmrekap->get_rekap_pa_by_key($key)->result();
		}else{
			$data['title'] = 'Rekap Faktur Patologi Anatomi';
			$data['date'] = date('d-m-Y');
			$data['daftar_pa']="";
		}
		$this->load->view('faktur/fvrekap_pa',$data);
	}
	public function faktur_pa($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/pa/pafaktur/'.$link));
	}
	public function kwitansi_pa($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/pa/pakwitansi/'.$link));
	}
	

	public function cencel_irj($no_kwitansi='')
	{
		if ($no_kwitansi=='') {
			$no_kwitansi=$this->input->post('no_kwitansi');
		}
		
		$keterangan = $this->input->post('keterangan');
		$nominal=$this->fmrekap->get_nominal_register($no_kwitansi)->row();
		$data['is_cancel']=1;
		$data['cancel_nominal']=$nominal->payment_bill;
		$this->fmrekap->cancel_mhas($no_kwitansi,$data);
		
		$this->fmrekap->cencel_irj($no_kwitansi, $keterangan);
		
		redirect('faktur/fcrekap/rawat_jalan');
	}

	public function cencel_irj_double($no_kwitansi='')
	{
		if ($no_kwitansi=='') {
			$no_kwitansi=$this->input->post('no_kwitansi_double');
		}
		
		$keterangan = $this->input->post('keterangan');
		
	//	print_r($no_kwitansi);die();

		$this->fmrekap->cencel_irj_double($no_kwitansi, $keterangan);
		
		redirect('faktur/fcrekap/rawat_jalan');
	}

	public function retur_irj($no_kwitansi='')
	{
		$no_kwitansi=$this->input->post('no_kwitansi');
		$jml = $this->input->post('jml');
		$this->fmrekap->retur_irj($no_kwitansi, $jml);
	
		redirect('faktur/fcrekap/rawat_jalan');
	}

	public function cencel_iri($no_kwitansi='', $keterangan='')

	{
		if ($no_kwitansi == '') {
			$no_kwitansi = $this->input->post('no_kwitansi');
		}
		$no_ipd = $this->input->post('no_register');
		$keterangan = $this->input->post('keterangan');
		
		$this->fmrekap->cencel_iri($no_kwitansi, $keterangan);
		$this->fmrekap->cencel_reg_iri($no_kwitansi);
		
		redirect('faktur/fcrekap/rawat_inap');
	}

	public function cencel_lab($no_kwitansi='')
	{
		$login_data = $this->load->get_var("user_info");
		$no_kwitansi = $this->input->post('no_kwitansi');
		$keterangan = $this->input->post('keterangan');
		$no_lab = $this->input->post('no_lab');
		
		$lab['cetak_kwitansi'] = NULL;
		$this->fmrekap->cencel_lab($no_lab, $lab);
		$data['status'] = 'batal';
		$data['tgl_cencel'] = date("Y-m-d H:i:s");
		$data['user_cencel'] = $login_data->username;
		$data['ket'] = $keterangan;
		$this->fmrekap->cancel_lab_kwitansi($no_kwitansi, $data);
		
		redirect('faktur/fcrekap/lab');
	}

	public function cencel_lab_double($no_kwitansi='')
	{
		if ($no_kwitansi == '') {
			$no_kwitansi = $this->input->post('no_kwitansi_double');
		}

		$keterangan = $this->input->post('keterangan');
		
		$this->fmrekap->cencel_lab($no_kwitansi, $keterangan);
		
		redirect('faktur/fcrekap/lab');
	}

	public function cencel_rad()
	{
		$login_data = $this->load->get_var("user_info");
		$no_rad = $this->input->post('no_rad');
		$no_kwitansi = $this->input->post('no_kwitansi');
		$keterangan = $this->input->post('keterangan');
		
		$rad['cetak_kwitansi'] = NULL;
		$this->fmrekap->cencel_rad($no_rad, $rad);

		$data['status'] = 'batal';
		$data['tgl_cencel'] = date("Y-m-d H:i:s");
		$data['user_cencel'] = $login_data->username;
		$data['ket'] = $keterangan;
		$this->fmrekap->cancel_rad_kwitansi($no_kwitansi, $data);
		
		redirect('faktur/fcrekap/rad');

	}

	public function cencel_em() {
		$login_data = $this->load->get_var("user_info");
		$no_em = $this->input->post('no_em');
		$no_kwitansi = $this->input->post('no_kwitansi');
		$keterangan = $this->input->post('keterangan');
		
		$em['cetak_kwitansi'] = NULL;
		$this->fmrekap->cencel_em($no_em, $em);

		$data['status'] = 'batal';
		$data['tgl_cencel'] = date("Y-m-d H:i:s");
		$data['user_cencel'] = $login_data->username;
		$data['ket'] = $keterangan;
		$this->fmrekap->cancel_em_kwitansi($no_kwitansi, $data);
		
		redirect('faktur/fcrekap/em');
	}

	public function cencel_ok($no_ok='')
	{
		
		if ($no_ok=='') {
			$no_ok = $this->input->post('no_kwitansi');
		}
		
		$keterangan = $this->input->post('keterangan');
		
	//	$this->fmrekap->cencel_irj($no_register, $keterangan);

		$this->fmrekap->cencel_ok($no_ok,$keterangan);
		
		redirect('faktur/fcrekap/ok');
	}

	public function cencel_farmasi($no_kwitansi='',$keterangan='')
     {      
         if ($no_kwitansi == '') {
			$no_kwitansi = $this->input->post('no_kwitansi');
        //    $keterangan = $this->input->post('keterangan');
		}

		$keterangan = $this->input->post('keterangan');
		
  //      print_r($keterangan);die();

		$this->fmrekap->cencel_farmasi($no_kwitansi, $keterangan);
		
		redirect('faktur/fcrekap/frm');

	//	$this->fmrekap->cencel_farmasi($no_regis,$no_resep);
		
	//	redirect('faktur/fcrekap/frm');
	}

	public function bill_pasien_iri() {
		$data['title'] = 'Cetak Ulang Bill Pasien Pulang Rawat Inap';
		$date = $this->input->post('date_days');
		$mr = $this->input->post('no_rm');
		$sep = $this->input->post('sep');

		if(!empty($date)) {
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['bill'] = $this->fmrekap->get_pasien_cetak_ulang_bill_ri_date($date)->result();
		} else if(!empty($mr)) {
			$data['date_title'] = '('.$mr.')';
			$data['bill'] = $this->fmrekap->get_pasien_cetak_ulang_bill_ri_mr($mr)->result();
		} else if(!empty($sep)) {
			$data['date_title'] = '('.$sep.')';
			$data['bill'] = $this->fmrekap->get_pasien_cetak_ulang_bill_ri_sep($sep)->result();
		} else {
			$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
			$data['date_title'] = date("d F Y", strtotime($week_awal)).' - '.date("d F Y", strtotime(date('Y-m-d')));
			$data['bill'] = $this->fmrekap->get_pasien_cetak_ulang_bill_ri($week_awal, date('Y-m-d'))->result();
		}

		$this->load->view('faktur/fvcetak_ulang_bill', $data);
	}

	public function pasien_blm_administrasi() {
		$date = $this->input->post('date_picker_months');

		if($date != '') {
			$data['title'] = 'Daftar Pasien Belum Selesai Administrasi Rawat Inap '.date("F Y", strtotime($date));
			$data['date_title'] = date("F Y", strtotime($date));
			$data['pasien'] = $this->fmrekap->get_pasien_blm_selesai_admin($date)->result();
		} else {
			$data['title'] = 'Daftar Pasien Belum Selesai Administrasi Rawat Inap '.date("F Y", strtotime(date('Y-m')));
			$data['date_title'] = date("F Y", strtotime(date('Y-m')));
			$data['pasien'] = $this->fmrekap->get_pasien_blm_selesai_admin(date('Y-m'))->result();
		}

		$this->load->view('faktur/fvrekap_blm_admin', $data);
	}

	public function selesai_administrasi($no_ipd) {
		$data['administrasi_tertunda'] = 2;
		$data['cetak_kwitansi'] = NULL;
		$code = $this->fmrekap->update_selesai_administrasi($data, $no_ipd);

		if($code == true) {
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:green\"></i>Data Administrasi Pasien Berhasil Diperbarui ! </span>
			</div>");
			redirect('faktur/fcrekap/pasien_blm_administrasi/');
		} else {
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:red\"></i> Data Administrasi Pasien Gagal Diperbarui, Coba Lagi ! </span>
			</div>");
			redirect('faktur/fcrekap/pasien_blm_administrasi/');
		}
	}
}
?>
