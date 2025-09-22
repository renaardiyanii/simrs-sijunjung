<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcpbf extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmpbf','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master PBF';

		$data['pbf']=$this->Mmpbf->get_all_pbf()->result();
		$this->load->view('master/mvpbf',$data);
		//print_r($data);
	}

	public function insert_pbf(){

		$data['pbf']=$this->input->post('pbf');
		$this->Mmpbf->insert_pbf($data);
		
		redirect('master/Mcpbf');
		//print_r($data);
	}

	public function get_data_edit_pbf(){
		$id=$this->input->post('id');
		$datajson=$this->Mmpbf->get_data_pbf($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_pbf(){
		$id=$this->input->post('edit_id_hidden');
		$data['pbf']=$this->input->post('edit_pbf');
		$this->Mmpbf->edit_pbf($id,$data);
		
		redirect('master/Mcpbf');
		//print_r($data);
	}

	public function delete_pbf(){
		$id=$this->input->post('id');
		$this->Mmpbf->delete_pbf($id);
		
		//redirect('master/Mcgudang');
		print_r($this->Mmpbf->delete_pbf($id));
	}

}