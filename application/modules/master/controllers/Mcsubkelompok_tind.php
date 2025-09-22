<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcsubkelompok_tind extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmsubkelompok_tind','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Subkelompok Tindakan';

		$data['subkelompok_tind']=$this->Mmsubkelompok_tind->get_all_subkel()->result();
		$this->load->view('master/mvsubkelompok_tind',$data);
		//print_r($data);
	}

	public function insert_subkelompok_tind(){

		$data['nm_subkelompok']=$this->input->post('nama_subkel');
		$this->Mmsubkelompok_tind->insert_subkel($data);
		
		redirect('master/Mcsubkelompok_tind');
		//print_r($data);
	}

	public function get_data_edit_subkel(){
		$id=$this->input->post('id');
		$datajson=$this->Mmsubkelompok_tind->get_data_subkel($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_subkel(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_subkelompok']=$this->input->post('edit_namasubkel');
		$this->Mmsubkelompok_tind->edit_subkel($id,$data);
		
		redirect('master/Mcsubkelompok_tind');
		//print_r($data);
	}

	public function delete_subkel(){
		$id=$this->input->post('id');
		$this->Mmsubkelompok_tind->delete_subkel($id);
		
		//redirect('master/Mcgudang');
		print_r($this->Mmsubkelompok_tind->delete_subkel($id));
	}

}