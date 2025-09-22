<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//equire_once(APPPATH.'controllers/Secure_area.php');
class Mcqtx extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmqtx','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Qtx';

		$data['qtx']=$this->mmqtx->get_all_qtx()->result();
		$this->load->view('master/mvqtx',$data);
		
	}

	public function insert_qtx(){
		$data['qtx']=$this->input->post('qtx');

		$this->mmqtx->insert_qtx($data);
		
		redirect('master/Mcqtx');
	}

	public function get_data_edit_qtx(){
		$id_qtx=$this->input->post('id_qtx');
		$datajson=$this->mmqtx->get_data_qtx($id_qtx)->result();
	    echo json_encode($datajson);
	}

	public function edit_qtx(){
		$id_qtx=$this->input->post('edit_id_qtx');

		$data['qtx']=$this->input->post('edit_qtx');

		$this->mmqtx->edit_qtx($id_qtx, $data);
		
		redirect('master/Mcqtx');
	}
	public function delete_qtx(){
		$id_qtx=$this->input->post('delete_id_qtx');

		// $this->mmqtx->delete_qtx($id);
		$this->mmqtx->soft_delete_qtx($id_qtx);
		
		redirect('master/Mcqtx');
	}

	public function hapus_qtx(){
		$id_qtx=$this->input->post('hapus_id_qtx');
		var_dump($id_qtx);die();
		// $this->mmqtx->delete_qtx($id);
		// $this->mmqtx->soft_hapus_qtx($id_qtx);
		
		redirect('master/Mcqtx');
		//print_r($data);
	}

	public function active_qtx($id_qtx){

		$result  = $this->mmqtx->active_qtx($id_qtx);
		
		redirect('master/Mcqtx');
	}

}