<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//equire_once(APPPATH.'controllers/Secure_area.php');
class Mcsigna extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmsigna','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Signa';

		$data['signa']=$this->mmsigna->get_all_signa()->result();
		$this->load->view('master/mvsigna',$data);
		
	}

	public function insert_signa(){
		$data['signa']=$this->input->post('signa');

		$this->mmsigna->insert_signa($data);
		
		redirect('master/Mcsigna');
	}

	public function get_data_edit_signa(){
		$id_signa=$this->input->post('id_signa');
		$datajson=$this->mmsigna->get_data_signa($id_signa)->result();
	    echo json_encode($datajson);
	}

	public function edit_signa(){
		$id_signa=$this->input->post('edit_id_signa');

		$data['signa']=$this->input->post('edit_signa');

		$this->mmsigna->edit_signa($id_signa, $data);
		
		redirect('master/Mcsigna');
	}
	public function delete_signa(){
		$id_signa=$this->input->post('delete_id_signa');

		// $this->mmsigna->delete_signa($id);
		$this->mmsigna->soft_delete_signa($id_signa);
		
		redirect('master/Mcsigna');
	}

	public function hapus_signa(){
		$id_signa=$this->input->post('hapus_id_signa');
		var_dump($id_signa);die();
		// $this->mmsigna->delete_signa($id);
		// $this->mmsigna->soft_hapus_signa($id_signa);
		
		redirect('master/Mcsigna');
		//print_r($data);
	}

	public function active_signa($id_signa){

		$result  = $this->mmsigna->active_signa($id_signa);
		
		redirect('master/Mcsigna');
	}

}