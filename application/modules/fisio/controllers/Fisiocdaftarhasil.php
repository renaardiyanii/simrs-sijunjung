<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Fisiocdaftarhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('fisio/fisiomdaftar','',TRUE);
		$this->load->model('fisio/fisiomkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR HASIL FISIOTERAPI';

		$data['fisioterapi']=$this->fisiomdaftar->get_hasil_fisio_selesai()->result();
		$this->load->view('fisio/fisiovdaftarhasilselesai',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR HASIL FISIOTERAPI Tanggal '.$date;

		$data['fisioterapi']=$this->fisiomdaftar->get_hasil_fisio_by_date_selesai($date)->result();
		$this->load->view('fisio/fisiovdaftarhasilselesai',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR HASIL FISIOTERAPI';

		$data['fisioterapi']=$this->fisiomdaftar->get_hasil_fisio_by_no_selesai($key)->result();
		$this->load->view('fisio/fisiovdaftarhasilselesai',$data);
	}

	public function view_pdf($no_fisio){
		$this->load->helper('download');
		if($this->uri->segment(3))
		{
		    $data   = file_get_contents('./download/fisio/fisiopengisianhasil/Hasil_fisio_'.$no_fisio.'.pdf');
		}
		$name   = 'Hasil_fisio_'.$no_fisio.'.pdf';
		force_download($name, $data);
	}
}