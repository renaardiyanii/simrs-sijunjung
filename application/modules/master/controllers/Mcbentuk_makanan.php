<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcbentuk_makanan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmbentuk_makanan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Bentuk Makanan';

		$data['bentuk_makanan']=$this->mmbentuk_makanan->get()->result();
		$this->load->view('master/mvbentuk_makanan',$data);
	}


	public function insert(){
		$data = $this->input->post();
		$req = $this->mmbentuk_makanan->insert($data);		
		echo json_encode([
			'code' =>$req?200:500,
			'message'
		]);
	}


	public function get_data_edit_bentuk_makanan(){
		$id=$this->input->post('id');
		$datajson=$this->mmbentuk_makanan->get_data_bentuk_makanan($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_bentuk_makanan(){
		$id=$this->input->post('edit_id_bentuk_makanan');
		$data['nama']=$this->input->post('edit_bentuk_makanan');
		$data['kode']=$this->input->post('edit_kode');
		$this->mmbentuk_makanan->edit_bentuk_makanan($id, $data);
		redirect('master/Mcbentuk_makanan');
	}


	public function delete_bentuk_makanan(){
		$id=$this->input->post('delete_id');
		$this->mmbentuk_makanan->soft_delete_bentuk_makanan($id);
		redirect('master/Mcbentuk_makanan');
	}

	public function active_bentuk_makanan(){
		$id=$this->input->post('active_id');
		$this->mmbentuk_makanan->soft_active_bentuk_makanan($id);
		redirect('master/Mcbentuk_makanan');
	}	
	
}
