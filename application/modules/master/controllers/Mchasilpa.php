<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mchasilpa extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmhasilpa','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Hasil Pa';

		$data['tindakan_pa']=$this->mmhasilpa->get_all_tindakan_pa()->result();
		$data['hasil_pa']=$this->mmhasilpa->get_all_hasil_pa()->result();
		$this->load->view('master/mvhasilpa',$data);
		//print_r($data);
	}

	public function insert_jenis_hasil_pa(){

		$data['id_tindakan']=$this->input->post('id_tindakan');
		$data['jenis_hasil']=$this->input->post('jenis_hasil');
		$data['kadar_normal']=$this->input->post('kadar_normal');
		$data['satuan']=$this->input->post('satuan');

		$this->mmhasilpa->insert_jenis_hasil_pa($data);
			
		redirect('master/mchasilpa');
		// print_r($data);
	}

	public function delete_jenis_hasil_pa(){
		$id_jenis_hasil_pa=$this->input->post('id_jenis_hasil_pa');
		$this->mmhasilpa->delete_jenis_hasil_pa($id_jenis_hasil_pa);
		//redirect('master/Mcsupplier');
		//print_r('success');
		return('success');
	}

}
