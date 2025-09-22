<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcjenis_obat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmjenis_obat','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Jenis';
		$data['jenis']=$this->Mmjenis_obat->get_all_jenis()->result();
		$this->load->view('master/mvjenis_obat',$data);
		//print_r($data);
	}

	public function insert_jenis(){
		$data['nm_jenis']=strtoupper($this->input->post('jenis'));
		$data['kelompok']=strtoupper($this->input->post('kelompok'));
		$this->Mmjenis_obat->insert_jenis_obat($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Jenis Obat berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcjenis_obat');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmjenis_obat->get_data_jenis($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_jenis(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_jenis']=$this->input->post('edit_jenis');
		$data['kelompok']=$this->input->post('edit_kelompok');
		$this->Mmjenis_obat->edit_jenis($id, $data);
		redirect('master/Mcjenis_obat');
		//print_r($data);
	}
	public function delete_jenis_obat($id=''){
		$datajson=$this->Mmjenis_obat->delete_jenis_obat($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Jenis Obat Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcjenis_obat','refresh');
		echo json_encode($datajson);
	}
}