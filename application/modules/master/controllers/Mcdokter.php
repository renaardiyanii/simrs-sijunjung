<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Mcdokter extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmdokter','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->helper(array('html','url')); 
	}

	public function index(){
		$data['title'] = 'Master Dokter';

		// $data['dokter']=$this->mmdokter->get_all_dokter()->result();
		$data['dokter']=$this->mmdokter->get_all_dokter_poli()->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$data['biaya']=$this->mmdokter->get_all_biaya()->result();
		$this->load->view('master/mvdokter',$data);
	}

	public function insert_dokter(){
		//ini untuk jaga jaga kalo mau tambah dokter mau nambah spesialis
		// $id_poli = $this->input->post('poli');
		// $poli=$this->mmdokter->get_nm_poli($id_poli)->row();
		// $nm_poli = $poli->nm_poli;
		// $sub_poli = substr($nm_poli,0,5);
		// if($sub_poli == 'ORTET'){
		// 	$sub_poliklinik = substr($nm_poli,8);
		// }elseif($sub_poli == 'POLIK'){
		// 	$sub_poliklinik = substr($nm_poli,11);
		// }elseif($sub_poli == 'POLI '){
		// 	$sub_poliklinik = substr($nm_poli,5);
		// }else{
		// 	$sub_poliklinik = $nm_poli;
		// }
		// $camel_poli = ucwords(strtolower($sub_poliklinik));
		
		// $poliklinik = 'Spesialis '.$camel_poli;
		//	$data['spesialis'] = $poliklinik;
		// var_dump($poliklinik);
		// die();
		$data_uri = $this->input->post('canvas');
		// var_dump($data_uri);
		// die();
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		
		if (empty($_FILES["insert_scan_ttd"]["name"])) { 
			$data['scan_ttd']='';
		} else {
			$config['upload_path'] = './upload/ttd_dokter/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('insert_scan_ttd'))  
	        {  
	            echo $this->upload->display_errors(); 
	        }  
	        else  
	        {
	        	$data_upload = $this->upload->data();
	        	$data['scan_ttd']=$data_upload["file_name"];	        	
	        }
		}

		$data['nm_dokter']=$this->input->post('nm_dokter');
		$data['nipeg']=$this->input->post('nipeg');
		$data['klp_pelaksana']=$this->input->post('klp_pelaksana');
		$data['ket']=$this->input->post('ket');
		$data['deleted'] = 0;
		$result = $this->mmdokter->insert_dokter($data);
		$dokter=$this->mmdokter->get_dokter($data['nm_dokter'])->result();
		foreach($dokter as $row)
			{
				// echo $row->umurday;
				$data1['id_dokter']=$row->id_dokter;				
			}
		if($this->input->post('poli')!=''){
			$data1['id_poli']=$this->input->post('poli');
			$data1['id_biaya_periksa']=$this->input->post('biaya');
			$this->mmdokter->insert_dokter_poli($data1);
		}
		
		
		echo json_decode($result);
		//print_r($data);
	}

	public function get_data_edit_dokter(){
		$id_dokter=$this->input->post('id_dokter');
		$datajson=$this->mmdokter->get_data_dokter($id_dokter)->result();
	    echo json_encode($datajson);
	}

	public function add_ttd()
	{

		$id_dokter=$this->input->post('id_dokter');
		$foto=$this->input->post('foto');

		// var_dump($foto);
		// die();
		
		$data['ttd'] = $foto;
		// if (!empty($decoded_image)) {
		// 	$config['upload_path'] = './upload/ttd_dokter/'; 
	    //     $config['allowed_types'] = 'jpg|jpeg|png|gif';  
	    //     $this->load->library('upload', $config); 
	    //     $this->upload->initialize($config); 
	    //     if(!$this->upload->do_upload('edit_scan_ttd'))  
	    //     {  
	    //         echo $this->upload->display_errors(); 
	    //     }  
	    //     else  
	    //     {
	    //     	$data_upload = $this->upload->data();
	    //     	$data['scan_ttd']=$data_upload["file_name"];	        	
	    //     }
		// }

		
		
		$result = $this->mmdokter->edit_dokter($id_dokter, $data);						
		
		echo json_encode($result);
	}

	public function edit_dokter_hfis($id_dokter,$kode_dokter){
		$data['kode_dpjp_bpjs'] = $kode_dokter;
		$result = $this->mmdokter->edit_dokter($id_dokter, $data);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([
			'code'=>200,
			'response'=>"OK"
		]);
	}

	public function edit_dokter(){
			
		if (!empty($_FILES["edit_scan_ttd"]["name"])) {
			$config['upload_path'] = './upload/ttd_dokter/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('edit_scan_ttd'))  
	        {  
	            echo $this->upload->display_errors(); 
	        }  
	        else  
	        {
	        	$data_upload = $this->upload->data();
	        	$data['scan_ttd']=$data_upload["file_name"];	        	
	        }
		}
		$id_dokter=$this->input->post('edit_id_dokter_hidden');
		$data['nm_dokter']=$this->input->post('edit_nm_dokter');
		$data['nipeg']=$this->input->post('edit_nipeg');
		$data['kode_dpjp_bpjs']=$this->input->post('kode_dpjp_bpjs');
		$data['klp_pelaksana']=$this->input->post('edit_klp_pelaksana');
		$data['ket']=$this->input->post('edit_ket');
		
		$result = $this->mmdokter->edit_dokter($id_dokter, $data);

		$data1['id_dokter']=$id_dokter;							
		
		if($this->input->post('edit_poli')!=''){
			$data1['id_poli']=$this->input->post('edit_poli');
			$data1['id_biaya_periksa']=$this->input->post('edit_biaya');
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
			$this->mmdokter->insert_dokter_poli($data1);
		}else
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
		echo json_encode($result);
		//print_r($data);
	}

	public function delete_dokter($iddokter=''){
		$data['deleted']='1';
		$datajson=$this->mmdokter->delete_dokter($iddokter,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Dokter dengan ID "'.$iddokter.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mcdokter','refresh');
	}

	public function active_dokter($iddokter=''){
		$data['deleted']='0';
		$datajson=$this->mmdokter->active_dokter($iddokter,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Dokter dengan ID "'.$iddokter.'" berhasil diaktifkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mcdokter','refresh');
	}

	public function dokter_user()
	{
		$data['dokter_user'] = $this->mmdokter->get_all_dokter_user();
		$data['hmis_users'] = $this->mmdokter->get_all_hmis_users();
		$this->load->view('dokter_user/dokter_user_all',$data);
	}

	public function dokter_user_transaction()
	{
		// grab data
		$data['id_dokter'] = $this->input->post('edit_id_dokter');
		$data['userid'] = $this->input->post('edit_userid');
		// cek jika data ada by userid
		$check_available_data = $this->mmdokter->get_dyn_user_dokter_by_id_dokter($data['id_dokter']);
		// kalo ada ada maka update
		// kalo data tidak ada maka lakukan insert
		$request = $check_available_data->num_rows()?$this->mmdokter->update_dyn_user_dokter($data['id_dokter'],$data):$this->mmdokter->insert_dyn_user_dokter($data);
		// json response
		echo json_encode([
			'kode'=>$request,
			'message'=>$request==201?'Sukses Update':'Sukses Insert'
		]);
	}

	public function delete_relasi_dokter_user($idrelasi)
	{
		$res = $this->mmdokter->delete_dyn_user_dokter_by_id($idrelasi);
		return $res?200:400;
	}

}
