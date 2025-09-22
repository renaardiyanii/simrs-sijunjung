<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcdeskrad extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmdeskrad','',TRUE);
	}
 
	public function index(){
		$data['title'] = 'Master Deskripsi Radiologi';
		$data['deskripsi']=$this->Mmdeskrad->get_all_deskripsi()->result();
		$this->load->view('master/mvdeskrad',$data);
		//print_r($data);
	}

	public function insert_deskripsi(){
		$data['judul']=strtoupper($this->input->post('judul'));
		$data['isi']=$this->input->post('isi');
		$this->Mmdeskrad->insert_deskripsi($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Deskripsi berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcdeskrad');
		//print_r($data);
	}

	public function get_data_edit(){
		$id=$this->input->post('id');
		$datajson=$this->Mmdeskrad->get_data_deskripsi($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_deskripsi(){
		$id=$this->input->post('edit_id_hidden');
		$data['judul']=strtoupper($this->input->post('edit_judul'));
		$data['isi']=$this->input->post('edit_isi');
		$this->Mmdeskrad->edit_deskripsi($id, $data);
		redirect('master/Mcdeskrad');
		//print_r($data);
	}
	public function delete_deskripsi($id=''){
		$datajson=$this->Mmdeskrad->delete_deskripsi($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Deskripsi Dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcdeskrad','refresh');
		echo json_encode($datajson);
	}

	public function bhp() {
		$data['title'] = 'Master BHP Radiologi';
		$data['master_bhp'] = $this->Mmdeskrad->get_bhp_radiologi()->result();
		$this->load->view('master/mvbhp_rad', $data);
	}

	public function insert_bhp() {
		$data['nama_bhp']=strtoupper($this->input->post('nama'));
		$data['satuan_bhp']=strtoupper($this->input->post('satuan'));
		$data['kategori']=strtoupper($this->input->post('kategori'));
		$this->Mmdeskrad->insert_bhp($data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check-circle-o"></i>
							Deskripsi berhasil ditambah!
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcdeskrad/bhp');
	}

	public function get_data_edit_bhp(){
		$id=$this->input->post('id');
		$datajson=$this->Mmdeskrad->get_data_master_bhp($id)->result();
	    echo json_encode($datajson);
	}

	public function update_bhp(){
		$id=$this->input->post('id_bhp');
		$data['nama_bhp']=strtoupper($this->input->post('nama_bhp_edit'));
		$data['satuan_bhp']=strtoupper($this->input->post('satuan_bhp_edit'));
		$data['kategori']=strtoupper($this->input->post('kategori_edit'));
		$this->Mmdeskrad->edit_bhp($id, $data);
		redirect('master/Mcdeskrad/bhp');
		//print_r($data);
	}
}