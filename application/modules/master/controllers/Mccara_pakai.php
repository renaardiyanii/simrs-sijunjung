<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//equire_once(APPPATH.'controllers/Secure_area.php');
class Mccara_pakai extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmcara_pakai','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Obat Cara Pakai';

		$data['cara_pakai']=$this->mmcara_pakai->get_all_cara_pakai()->result();
		$this->load->view('master/mvcara_pakai',$data);
		
	}

	public function insert_cara_pakai(){
		$data['cara_pakai']=$this->input->post('cara_pakai');

		$this->mmcara_pakai->insert_cara_pakai($data);
		
		redirect('master/Mccara_pakai');
	}

	public function get_data_edit_cara_pakai(){
		$id_cara_pakai=$this->input->post('id_cara_pakai');
		$datajson=$this->mmcara_pakai->get_data_cara_pakai($id_cara_pakai)->result();
	    echo json_encode($datajson);
	}

	public function edit_cara_pakai(){
		$id_cara_pakai=$this->input->post('edit_id_cara_pakai');

		$data['cara_pakai']=$this->input->post('edit_cara_pakai');

		$this->mmcara_pakai->edit_cara_pakai($id_cara_pakai, $data);
		
		redirect('master/Mccara_pakai');
	}
	public function delete_cara_pakai(){
		$id_cara_pakai=$this->input->post('delete_id_cara_pakai');

		// $this->mmcara_pakai->delete_cara_pakai($id);
		$this->mmcara_pakai->soft_delete_cara_pakai($id_cara_pakai);
		
		redirect('master/Mccara_pakai');
	}

	public function hapus_cara_pakai(){
		$id_cara_pakai=$this->input->post('hapus_id_cara_pakai');
		var_dump($id_cara_pakai);die();
		// $this->mmcara_pakai->delete_cara_pakai($id);
		// $this->mmcara_pakai->soft_hapus_cara_pakai($id_cara_pakai);
		
		redirect('master/Mccara_pakai');
		//print_r($data);
	}

	public function active_cara_pakai($id_cara_pakai){

		$result  = $this->mmcara_pakai->active_cara_pakai($id_cara_pakai);
		
		redirect('master/Mccara_pakai');
	}

}