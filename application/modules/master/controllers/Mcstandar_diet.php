<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcstandar_diet extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmstandar_diet','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Standar Diet Gizi';

		$data['standar_diet']=$this->mmstandar_diet->get()->result();
		$this->load->view('master/mvstandar_diet',$data);
	}

	public function get_role_form($id_form){
		$datas = $this->mmform->get_role_form_by_id_form($id_form)->result();
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['data'=>$datas]);
	}

	public function insert(){
		$data = $this->input->post();
		$req = $this->mmstandar_diet->insert($data);		
		echo json_encode([
			'code' =>$req?200:500,
			'message'
		]);
	}


	public function get_data_edit_standar_diet(){
		$id=$this->input->post('id');
		$datajson=$this->mmstandar_diet->get_data_standar_diet($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_standar_diet(){
		$id=$this->input->post('edit_id_standar_diet');
		$data['standar_diet']=$this->input->post('edit_standar_diet');
		$this->mmstandar_diet->edit_standar_diet($id, $data);
		redirect('master/Mcstandar_diet');
	}


	public function delete_standar_diet(){
		$id=$this->input->post('delete_id');
		$this->mmstandar_diet->soft_delete_standar_diet($id);
		redirect('master/Mcstandar_diet');
	}

	public function active_standar_diet(){
		$id=$this->input->post('active_id');
		$this->mmstandar_diet->soft_active_standar_diet($id);
		redirect('master/Mcstandar_diet');
	}	
	
}
