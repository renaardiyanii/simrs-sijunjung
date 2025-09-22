<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcformigd extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmformigd','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Form IGD';

		$data['form']=$this->mmformigd->get()->result();
		$this->load->view('master/mvformigd',$data);
	}

	public function get_role_form($id_form){
		$datas = $this->mmformigd->get_role_form_by_id_form($id_form)->result();
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['data'=>$datas]);
	}

	public function insert(){
		$data = $this->input->post();
		$req = $this->mmformigd->insert($data);		
		echo json_encode([
			'code' =>$req?200:500,
			'message'
		]);
	}

	public function insert_role_form(){
		$data = $this->input->post();
		$berhasil = 0;
		$gagal = 0;
		$data_sebelumnya = $this->mmformigd->get_role_form_by_id_form($data['id_form'])->result();
		$penampung_role_sebelumnya = [];
		// cek data sebelumnya sesuai form
		foreach($data_sebelumnya as $old){
			if(!in_array($old->role,$penampung_role_sebelumnya)){
				array_push($penampung_role_sebelumnya,$old->role);
			}
		}

		foreach($data['role'] as $val){
			// jika role yang dituju sudah ada di yang form , dismiss
			if(in_array($val,$penampung_role_sebelumnya)){
				// pass;
			}
			// jika role yang dituju gaada di yang form sebelumnya , tambahkan
			if(!in_array($val,$penampung_role_sebelumnya)){
				$datas = [
					'id_form'=>$data['id_form'],
					'role'=>$val
				];
				$req = $this->mmformigd->insert_role_form($datas);
				if($req){
					$berhasil++;
				}else{
					$gagal++;
				
			}
			}
		}

		$penampung_role_update = [];
		// cek data sebelumnya sesuai form
		foreach($data['role'] as $new){
			if(!in_array($new,$penampung_role_update)){
				array_push($penampung_role_update,$new);
			}
		}

		foreach($data_sebelumnya as $val){
			// jika role yang dituju gaada , tapi yang di form sebelumnya ada , delete
			if(!in_array($val->role,$penampung_role_update)){
				$this->mmformigd->delete_role_form($val->id);
			}
		}

		echo json_encode([
			'code' =>$gagal>0?400:200,
			'message'=>[
				'akses_berhasil'=>$berhasil,
				'akses_gagal'=>$gagal
			]
		]);
	}


	public function edit(){
		$id_poli=$this->input->post('edit_id_poli_hidden');
		$data['nm_poli']=$this->input->post('edit_nm_poli');
		$data['nm_pokpoli']=$this->input->post('edit_nm_pokpoli');
		$data['lokasi']=$this->input->post('edit_lokasi');
		$data['poli_bpjs']=$this->input->post('edit_kode_bpjs');
		$data['active']=$this->input->post('edit_active');
		$data['id_polilama']=$this->input->post('edit_id_polilama');
		
		$this->mmpoli->edit_poli($id_poli,$data);

		redirect('master/Mcpoli');
		//print_r($data);
	}

	public function delete($id){		
		if($id_poli!=''){
			$this->mmpoli->delete_poli($id_poli);

			$success = 	'<div class="content-header">
						<div class="box box-default">
							<div class="alert alert-success alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>								
								Poliklinik dengan ID "'.$id_poli.'" berhasil dihapus
								</h4>
							</div>
						</div>
					</div>';
			$this->session->set_flashdata('success_msg', $success);
		}
		redirect('master/Mcpoli','refresh');
		//print_r($data);
	}

	
	
}
