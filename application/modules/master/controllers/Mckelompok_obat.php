<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mckelompok_obat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmkelompok_obat','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Kelompok';
		$data['kelompok']=$this->Mmkelompok_obat->get_all_kelompok()->result();
		$this->load->view('master/mvkelompok_obat',$data);
		//print_r($data);
	}

	public function insert_kelompok(){
		$data['nm_satuan']=strtoupper($this->input->post('kelompok'));
		$this->Mmkelompok_obat->insert_kelompok_obat($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Kelompok Obat berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mckelompok_obat');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmkelompok_obat->get_data_kelompok($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_kelompok(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_satuan']=$this->input->post('edit_kelompok');
		$this->Mmkelompok_obat->edit_kelompok($id, $data);
		redirect('master/Mckelompok_obat');
		//print_r($data);
	}
	public function delete_kelompok_obat($id=''){
		$datajson=$this->Mmkelompok_obat->delete_kelompok_obat($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Kelompok Obat Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mckelompok_obat','refresh');
		echo json_encode($datajson);
	}
}