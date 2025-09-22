<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcobat_konsinyasi extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmobat_konsinyasi','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Obat Konsinyasi';
		$data['jadwal']=$this->Mmobat_konsinyasi->get_all_obatk()->result();
		$data['poli']=$this->Mmobat_konsinyasi->get_id_max()->result();
		$this->load->view('master/mvobat_konsinyasi',$data);
		//print_r($data);
	}

	public function insert_obatk(){
		$data['id_obatk']=$this->input->post('id_obatk');
		$data['nm_obatk']=$this->input->post('nama');
		$data['hargabeli']=$this->input->post('hargab');
		$data['hargajual']=$this->input->post('hargaj');
		$data['obatalkes']=$this->input->post('jenis');
		$data['ket']=1;
		$data['xuser']=$this->input->post('xuser');
	$this->Mmobat_konsinyasi->insert_obatk($data);
		
		
		redirect('master/Mcobat_konsinyasi');
		//print_r($data);
	}

	public function get_id_obatk(){
		$data['id_obatk']=$this->Mmobat_konsinyasi->get_id_max()->result();
	}

	public function get_data_edit_obatk(){
		$id=$this->input->post('id');
		$datajson=$this->Mmobat_konsinyasi->get_data_obatk($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_obatk(){
		$id=$this->input->post('edit_id_hidden');
		$data['nm_obatk']=$this->input->post('edit_nm_obatk');
		$data['hargabeli']=$this->input->post('edit_hargab');
		$data['hargajual']=$this->input->post('edit_hargaj');
		$data['obatalkes']=$this->input->post('edit_jenis');
		$this->Mmobat_konsinyasi->edit_obatk($id, $data);
		redirect('master/Mcobat_konsinyasi');
		//print_r($data);
	}
	
	public function delete_obatk($id=''){
		$data['deleted']='1';
		$datajson=$this->Mmobat_konsinyasi->delete_obatk($id,$data);
		// $success = 	'<div class="content-header">
		// 			<div class="box box-default">
		// 				<div class="alert alert-success alert-dismissable">
		// 					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		// 					<h4>
		// 					<i class="icon fa fa-ban"></i>
		// 					Obat berhasil dihapus!
		// 					</h4>
		// 				</div>
		// 			</div>
		// 		</div>';
		// $this->session->set_flashdata('success_msg', $success);
	    // redirect('master/Mcobat_konsinyasi','refresh');
		echo json_encode($datajson);
	}
}