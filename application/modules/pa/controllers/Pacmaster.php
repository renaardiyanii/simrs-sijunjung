<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include('.php');
require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Pacmaster extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('pa/pammaster','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR TINDAKAN';

		$data['tindakan']=$this->pammaster->get_all_tindakan()->result();
		$data['jenis']=$this->pammaster->get_all_jenis()->result();
		$data['kode']=$this->pammaster->get_all_kode()->result();
		$this->load->view('pa/pavmaster',$data);
	}

	public function get_data_edit_tindakan_pa(){
		$idtindakan=$this->input->post('idtindakan');
		$datajson=$this->pammaster->get_data_tindakan($idtindakan)->result();
	    echo json_encode($datajson);
	}

	public function edit_tindakan(){
		$id=$this->input->post('edit_id_hidden');
		if($id!=""){
			$data['jenis']=$this->input->post('edit_jenis');
			$data['nm_jenis']=$this->pammaster->get_nm_jenis($data['jenis'])->row()->nama;
			$data['kode']=$this->input->post('edit_kode');
			$data['nm_kode']=$this->pammaster->get_nm_kode($data['kode'])->row()->kode;

			$this->pammaster->edit_tindakan($id, $data);
		}else{
			$data['idtindakan']=$this->input->post('edit_idtindakan_hidden');
			$data['jenis']=$this->input->post('edit_jenis');
			$data['nm_jenis']=$this->pammaster->get_nm_jenis($data['jenis'])->row()->nama;
			$data['kode']=$this->input->post('edit_kode');
			$data['nm_kode']=$this->pammaster->get_nm_kode($data['kode'])->row()->kode;

			// echo json_encode($data);
			$this->pammaster->insert_tindakan($data);
		}
			
		
		redirect('pa/pacmaster');
	}

	// public function jenis(){
	// 	$data['title'] = 'DAFTAR JENIS TINDAKAN PA';

	// 	$data['jenis']=$this->pammaster->get_all_jenis()->result();
	// 	$this->load->view('pa/pavjenis',$data);
	// }

	public function kode(){
		$data['title'] = 'DAFTAR KODE TINDAKAN PA';

		$data['kode']=$this->pammaster->get_all_kode()->result();
		$this->load->view('pa/pavkode',$data);
	}
	
	
}