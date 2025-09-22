<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcprodusen extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmprodusen','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Produsen';

		$data['produsen']=$this->Mmprodusen->get_all_produsen()->result();
		$this->load->view('master/mvprodusen',$data);
		//print_r($data);
	}

	public function insert_produsen(){

		$data['nm_produsen']=$this->input->post('nama_produsen');
		$this->Mmprodusen->insert_produsen($data);
		
		redirect('master/Mcprodusen');
		//print_r($data);
	}

	public function get_data_edit_produsen(){
		$id=$this->input->post('id');
		$datajson=$this->Mmprodusen->get_data_produsen($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_produsen(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_produsen']=$this->input->post('edit_namaprodusen');
		$this->Mmprodusen->edit_produsen($id,$data);
		
		redirect('master/Mcprodusen');
		//print_r($data);
	}

	public function delete_produsen(){
		$id=$this->input->post('id');
		$this->Mmprodusen->delete_produsen($id);
		
		//redirect('master/Mcgudang');
		print_r($this->Mmprodusen->delete_produsen($id));
	}

}