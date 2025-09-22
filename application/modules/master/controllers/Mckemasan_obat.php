<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mckemasan_obat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmkemasan_obat','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Kemasan Obat';
		$data['kemasan']=$this->Mmkemasan_obat->get_all_kemasan_obat()->result();
		$this->load->view('master/mvkemasan_obat',$data);
		//print_r($data);
	}

	public function insert_kemasan(){
		$data['kemasan']=strtoupper($this->input->post('kemasan'));
		$data['isi_satuan']=$this->input->post('isi_satuan');
		$this->Mmkemasan_obat->insert_kemasan_obat($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Kemasan Obat berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mckemasan_obat');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmkemasan_obat->get_data_kemasan($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_kemasan(){
		$id=$this->input->post('edit_id_hidden');
		$data['kemasan']=$this->input->post('edit_kemasan');
		$data['isi_satuan']=$this->input->post('edit_isi_satuan');
		$this->Mmkemasan_obat->edit_kemasan($id, $data);
		redirect('master/Mckemasan_obat');
		//print_r($data);
	}
	public function delete_kemasan_obat($id=''){
		$datajson=$this->Mmkemasan_obat->delete_kemasan_obat($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Kemasan Obat Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcsatuan_obat','refresh');
		echo json_encode($datajson);
	}
}