<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//equire_once(APPPATH.'controllers/Secure_area.php');
class Mcdiagnosa extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmdiagnosa','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Diagnosa';

		$data['diagnosa']=$this->mmdiagnosa->get_all_diagnosa()->result();
		$this->load->view('master/mvdiagnosa',$data);
		
	}

	public function insert_diagnosa(){
		$data['id_icd']=$this->input->post('iddiagnosa');
		$data['nm_diagnosa']=$this->input->post('nmdiagnosaeng');
		$data['diagnosa_indonesia']=$this->input->post('nmdiagnosaind');

		$this->mmdiagnosa->insert_diagnosa($data);
		
		redirect('master/Mcdiagnosa');
		//print_r($data);
	}

	public function get_data_edit_diagnosa(){
		$id=$this->input->post('id');
		$datajson=$this->mmdiagnosa->get_data_diagnosa($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_diagnosa(){
		$id=$this->input->post('edit_id');
		$data['id_icd']=$this->input->post('edit_iddiagnosa');
		$data['nm_diagnosa']=$this->input->post('edit_nmdiagnosaeng');
		$data['diagnosa_indonesia']=$this->input->post('edit_nmdiagnosaind');

		$this->mmdiagnosa->edit_diagnosa($id, $data);
		
		redirect('master/Mcdiagnosa');
	}
	public function delete_diagnosa(){
		$id=$this->input->post('delete_id');

		// $this->mmdiagnosa->delete_diagnosa($id);
		$this->mmdiagnosa->soft_delete_diagnosa($id);
		
		redirect('master/Mcdiagnosa');
	}

	public function hapus_diagnosa(){
		$id = $this->input->post('hapus_id');
		$this->mmdiagnosa->delete_diagnosa($id);
		// $this->mmdiagnosa->soft_hapus_diagnosa($id);
		redirect('master/Mcdiagnosa');
	}

	public function active_diagnosa($id){

		$result  = $this->mmdiagnosa->active_diagnosa($id);
		
		redirect('master/Mcdiagnosa');
	}

}