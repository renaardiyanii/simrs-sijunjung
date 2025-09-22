<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcsatuan_obat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmsatuan_obat','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Satuan';
		$data['satuan']=$this->Mmsatuan_obat->get_all_satuan_obat()->result();
		$this->load->view('master/mvsatuan_obat',$data);
		//print_r($data);
	}

	public function insert_satuan(){
		$data['nm_satuan']=strtoupper($this->input->post('satuan'));
		$this->Mmsatuan_obat->insert_satuan_obat($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Satuan Obat berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcsatuan_obat');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmsatuan_obat->get_data_satuan($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_satuan(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_satuan']=$this->input->post('edit_satuan');
		$this->Mmsatuan_obat->edit_satuan($id, $data);
		redirect('master/Mcsatuan_obat');
		//print_r($data);
	}
	public function delete_satuan_obat($id=''){
		$datajson=$this->Mmsatuan_obat->delete_satuan_obat($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Satuan Obat Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcsatuan_obat','refresh');
		echo json_encode($datajson);
	}
}