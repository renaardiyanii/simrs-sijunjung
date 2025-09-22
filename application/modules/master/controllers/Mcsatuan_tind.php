<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcsatuan_tind extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmsatuan_tind','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Satuan Tindakan';

		$data['satuan_tind']=$this->Mmsatuan_tind->get_all_satuan()->result();
		$this->load->view('master/mvsatuan_tind',$data);
		//print_r($data);
	}

	public function insert_satuan_tind(){

		$data['nm_satuan']=$this->input->post('nama_satuan');
		$this->Mmsatuan_tind->insert_satuan($data);
		
		redirect('master/Mcsatuan_tind');
		//print_r($data);
	}

	public function get_data_edit_satuan(){
		$id=$this->input->post('id');
		$datajson=$this->Mmsatuan_tind->get_data_satuan($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_satuan(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_satuan']=$this->input->post('edit_namasatuan');
		$this->Mmsatuan_tind->edit_satuan($id,$data);
		
		redirect('master/Mcsatuan_tind');
		//print_r($data);
	}

	public function delete_satuan(){
		$id=$this->input->post('id');
		$this->Mmsatuan_tind->delete_satuan($id);
		
		//redirect('master/Mcgudang');
		print_r($this->Mmsatuan_tind->delete_satuan($id));
	}

}