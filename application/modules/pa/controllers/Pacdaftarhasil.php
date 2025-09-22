<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Pacdaftarhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR HASIL PATOLOGI ANATOMI';

		$data['patologi']=$this->pamdaftar->get_hasil_pa_selesai_new()->result();
		$this->load->view('pa/pavdaftarhasilselesai',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR HASIL PATOLOGI ANATOMI Tanggal '.$date;

		$data['patologi']=$this->pamdaftar->get_hasil_pa_by_date_selesai($date)->result();
		$this->load->view('pa/pavdaftarhasilselesai',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR HASIL PATOLOGI ANATOMI';

		$data['patologi']=$this->pamdaftar->get_hasil_pa_by_no_selesai($key)->result();
		$this->load->view('pa/pavdaftarhasilselesai',$data);
	}

	public function view_pdf($no_pa){
		$this->load->helper('download');
		if($this->uri->segment(3))
		{
		    $data   = file_get_contents('./download/pa/papengisianhasil/Hasil_Pa_'.$no_pa.'.pdf');
		}
		$name   = 'Hasil_Pa_'.$no_pa.'.pdf';
		force_download($name, $data);
	}
}