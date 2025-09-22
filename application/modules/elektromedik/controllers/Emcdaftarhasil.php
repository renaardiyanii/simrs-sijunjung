<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Emcdaftarhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('elektromedik/emmdaftar','',TRUE);
		$this->load->model('elektromedik/emmkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR HASIL DIAGNOSTIK';

		$data['elektromedik']=$this->emmdaftar->get_hasil_em_selesai()->result();
		$this->load->view('elektromedik/emvdaftarhasilselesai',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR HASIL DIAGNOSTIK Tanggal '.$date;

		$data['elektromedik']=$this->emmdaftar->get_hasil_em_by_date_selesai($date)->result();
		$this->load->view('elektromedik/emvdaftarhasilselesai',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR HASIL DIAGNOSTIK';

		$data['elektromedik']=$this->emmdaftar->get_hasil_em_by_no_selesai($key)->result();
		$this->load->view('elektromedik/emvdaftarhasilselesai',$data);
	}

	public function view_pdf($no_em){
		$this->load->helper('download');
		if($this->uri->segment(3))
		{
		    $data   = file_get_contents('./download/elektromedik/empengisianhasil/Hasil_Em_'.$no_em.'.pdf');
		}
		$name   = 'Hasil_Em_'.$no_em.'.pdf';
		force_download($name, $data);
	}
}