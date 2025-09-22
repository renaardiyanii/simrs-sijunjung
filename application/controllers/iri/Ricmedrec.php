<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Ricmedrec extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function index(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//bikin object buat penanggalan
		$data['controller']=$this; 

		//ambil data di pasien iri, ambil yang diagnosa1 nya masih kosong selama seminggu
		//buat awal
		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = substr($this->input->post('tgl_akhir'),0,10);
		$tgl_akhir = substr($this->input->post('tgl_akhir'),13,23);
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		// echo $tgl_akhir;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$week_akhir = date("Y-m-d");
			$tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -7 day'));
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date($week_awal,$week_akhir);
			
			// print_r($data['list_medrec']);exit;
		}

		if($tipe_input == 'TGL'){
			$tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;			
			$tanggal_awal = substr($tgl_awal,8,2);
			$bulan_awal = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$tahun_awal = substr($tgl_awal,0,4);
			$tanggal_akhir = substr($tgl_akhir,8,2);
			$bulan_akhir = $tgl_indo->bulan(substr($tgl_akhir,6,2));
			$tahun_akhir = substr($tgl_akhir,0,4);
			$data['date_start'] = $tanggal_awal." ".$bulan_awal." ".$tahun_awal;
			$data['date_end'] = $tanggal_akhir." ".$bulan_akhir." ".$tahun_akhir;
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date($tgl_awal,$tgl_akhir);
			// print_r($data['list_medrec']);exit;			
		}

		if($tipe_input == 'BLN'){
			$tgl_indo = new Tglindo();
			$data['tgl'] = $bulan;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = $tgl_indo->bulan(substr($bulan,6,2));
			$data['tahun_show'] = substr($bulan,0,4);
			$data['list_medrec'] = $this->rimpasien->get_empty_diagnosa_by_month($bulan);			
		}

		if($tipe_input == 'THN'){
			$data['list_medrec'] = $this->rimpasien->get_medrec_year($tahun);
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['tahun_show'] = $tahun;
			// print_r($data['list_medrec']);exit;

		}

		//print_r($data['list_medrec']);exit;
		
		// $this->load->view('iri/rivlink');
		//$this->load->view('iri/list_antrian', $data);

		$this->load->view('iri/list_medrec', $data);
	}

	public function lap_keluar_iri(){
		$data['title'] = 'Pasien Keluar IRI';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//bikin object buat penanggalan
		$data['controller']=$this; 

		//ambil data di pasien iri, ambil yang diagnosa1 nya masih kosong selama seminggu
		//buat awal
		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_akhir = date("Y-m-d");
			$tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_date($tgl_akhir);
			
			//print_r($data['list_medrec'][0]);exit;
		}

		if($tipe_input == 'TGL'){
			$tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_date($tgl_akhir);
			
		}

		if($tipe_input == 'BLN'){
			$tgl_indo = new Tglindo();
			$data['tgl'] = $bulan;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = $tgl_indo->bulan(substr($bulan,6,2));
			$data['tahun_show'] = substr($bulan,0,4);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_month($bulan);
			
		}

		if($tipe_input == 'THN'){
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_year($tahun);

		}

		//print_r($data['list_medrec']);exit;
		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/list_antrian', $data);
		$this->load->view('iri/list_medrec_keluar', $data);
	}

	public function lengkapi_medrec($no_ipd=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		//print_r($data['data_pasien']);exit;

		// $this->load->view('iri/rivlink');
		//$this->load->view('iri/lengkapi_form_resume', $data);
		$this->load->view('iri/form_resume', $data);
	}
	
}
