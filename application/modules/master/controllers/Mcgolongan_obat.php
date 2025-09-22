<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcgolongan_obat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmgolongan_obat','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Golongan';
		$data['golongan']=$this->Mmgolongan_obat->get_all_golongan()->result();
		$this->load->view('master/mvgolongan_obat',$data);
		//print_r($data);
	}

	public function insert_golongan(){
		$data['nm_golongan']=strtoupper($this->input->post('golongan'));
		$this->Mmgolongan_obat->insert_golongan_obat($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Golongan Obat berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcgolongan_obat');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmgolongan_obat->get_data_golongan($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_golongan(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_golongan']=$this->input->post('edit_golongan');
		$this->Mmgolongan_obat->edit_golongan($id, $data);
		redirect('master/Mcgolongan_obat');
		//print_r($data);
	}
	public function delete_golongan_obat($id=''){
		$datajson=$this->Mmgolongan_obat->delete_golongan_obat($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Golongan Obat Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcgolongan_obat','refresh');
		echo json_encode($datajson);
	}
}