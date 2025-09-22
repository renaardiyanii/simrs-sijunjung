<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcobatgenerik extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmobatgenerik','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Obat Generik';

		$data['obat_generik']=$this->Mmobatgenerik->get_all_obat_generik()->result();
		$this->load->view('master/mvobatgenerik',$data);
		//print_r($data);
	}

	public function insert_obat_generik(){

		$data['nm_generik']=$this->input->post('nm_generik');
		$this->Mmobatgenerik->insert_obat_generik($data);
		
		redirect('master/Mcobatgenerik');
		//print_r($data);
	}

	public function get_data_edit_generik(){
		$id=$this->input->post('id');
		$datajson=$this->Mmobatgenerik->get_data_generik($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_generik(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_generik']=$this->input->post('edit_generik');
		$this->Mmobatgenerik->edit_generik($id,$data);
		
		redirect('master/Mcobatgenerik');
		//print_r($data);
	}

	public function delete_generik(){
		$id=$this->input->post('id');
		$this->Mmobatgenerik->delete_generik($id);
		
		//redirect('master/Mcgudang');
		print_r($this->Mmobatgenerik->delete_generik($id));
	}

}