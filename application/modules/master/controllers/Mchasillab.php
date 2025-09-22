<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mchasillab extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmhasillab','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Hasil Lab';
		$data['user_login'] = $this->load->get_var("user_info");
		$data['tindakan_lab']=$this->mmhasillab->get_all_tindakan_lab()->result();
		$data['hasil_lab']=$this->mmhasillab->get_all_hasil_lab()->result();
		$this->load->view('master/mvhasillab',$data);
		//print_r($data);
	}

	public function insert_jenis_hasil_lab(){
		$data['id_tindakan'] = $this->input->post('id_tindakan');
		$data['jenis_hasil'] = $this->input->post('jenis_hasil');
		$data['kadar_normal'] = $this->input->post('kadar_normal');
		$data['satuan'] = $this->input->post('satuan');
		$data['no_urut'] = $this->input->post('no_urut');

		$this->mmhasillab->insert_jenis_hasil_lab($data);
			
		redirect('master/mchasillab');
	}

	public function delete_jenis_hasil_lab(){
		$id_jenis_hasil_lab=$this->input->post('id_jenis_hasil_lab');
		$result =  $this->mmhasillab->delete_jenis_hasil_lab($id_jenis_hasil_lab);
		echo json_encode($result);
		//redirect('master/Mcsupplier');
		//print_r('success');
		// return('success');
	}

	public function get_data_edit_hasil_lab(){
		$id_jenis_hasil_lab=$this->input->post('id_jenis_hasil_lab');
		$datajson=$this->mmhasillab->get_data_hasil_lab($id_jenis_hasil_lab)->result();
	    	echo json_encode($datajson);
	}

	public function update_jenis_hasil_lab(){
		$id_jenis_hasil_lab = $this->input->post('edit_id_jenis_hasil_lab');
		$data['id_tindakan'] = $this->input->post('edit_id_tindakan');
		$data['jenis_hasil'] = $this->input->post('edit_jenis_hasil');
		$data['kadar_normal'] = $this->input->post('edit_kadar_normal');
		$data['satuan'] = $this->input->post('edit_satuan');
		$data['no_urut'] = $this->input->post('edit_no_urut');

		$this->mmhasillab->update_jenis_hasil_lab($id_jenis_hasil_lab, $data);
			
		redirect('master/mchasillab');
	}

}
