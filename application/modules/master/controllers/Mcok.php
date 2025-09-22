<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcok extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmok','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Perawat Ok';
		$data['perawat']=$this->Mmok->get_all_perawat()->result();
		$this->load->view('master/mvok',$data);
		//print_r($data);
	}

	public function insert_perawat(){
		$data['nm_perawat']=$this->input->post('nm_perawat');
		$data['klp_pelaksana']=$this->input->post('klp_pelaksana');
		$data['deleted']=0;
		$this->Mmok->insert_perawat($data);
		
		redirect('master/Mcok');
		//print_r($data);
	}

	public function get_data_edit_perawat(){
		$id=$this->input->post('id');
		$datajson=$this->Mmok->get_data_perawat($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_perawat(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_perawat']=$this->input->post('edit_nm_perawat');
		$data['klp_pelaksana']=$this->input->post('edit_klp_pelaksana');
		$this->Mmok->edit_perawat($id, $data);
		redirect('master/Mcok');
		//print_r($data);
	}

	public function delete_perawat($id=''){
		$data['deleted']=1;
		$datajson=$this->Mmok->edit_perawat($id,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Perawat dengan ID "'.$id.'" berhasil di non-aktifkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		echo json_encode($datajson);
	    // redirect('master/Mcok','refresh');
	}

	public function active_perawat($id=''){
		$data['deleted']=0;
		$datajson=$this->Mmok->edit_perawat($id,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Perawat dengan ID "'.$id.'" berhasil di aktifkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/Mcok','refresh');
	}

}
