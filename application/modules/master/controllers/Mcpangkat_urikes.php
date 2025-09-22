<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class MCpangkat_urikes extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmpangkat_urikes','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	//ket_urikes Kasir
	public function index(){
		$data['title'] = 'Master Pangkat Urikes';

		$data['pangkat_urikes']=$this->mmpangkat_urikes->get_all_pangkat_urikes()->result();
		$data['pokpangkat']=$this->mmpangkat_urikes->get_kelompok_pangkat_urikes()->result();
		$data['intensif']=$this->mmpangkat_urikes->get_tingkat_pangkat_urikes()->result();
		$data['urutan']=$this->mmpangkat_urikes->get_urutan_pangkat_urikes()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvpangkat_urikes',$data);
		//print_r($data);
	}

	public function insert_pangkat_urikes(){

		//$data['id']=$this->input->post('id');
		$data['pangkat']=$this->input->post('nama_pangkat');		
		$data['pokpangkat']=$this->input->post('pokpangkat');
		$data['intensif']=$this->input->post('intensif');
		$data['urutan']=$this->input->post('urutan');
		$id=$this->mmpangkat_urikes->insert_pangkat_urikes($data);		
				
		echo json_encode($id);
	}

	function show_pangkat_urikes(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmpangkat_urikes->get_all_pangkat_urikes()->result();		
				
		foreach ($hasil as $value) {						
			$row2['id'] = $value->urutan;
			$row2['kasir'] = $value->pangkat;		
			$row2['deskripsi'] = $value->pokpangkat;
			$row2['status'] = $value->intensif;	
			$row2['kode'] = $value->pangkat_id;			
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_pangkat_urikes(\''.$value->urutan.'\',\''.$value->pangkat.'\',\''.$value->pokpangkat.'\',\''.$value->pangkat_id.'\',\''.$value->intensif.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_pangkat_urikes(\''.$value->pangkat_id.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function get_data_edit_pangkat_urikes(){
		$id=$this->input->post('id');
		$datajson=$this->mmpangkat_urikes->get_data_pangkat_urikes($id)->result();		
	    echo json_encode($datajson);
	}

	public function edit_pangkat_urikes(){
		$id=$this->input->post('edit_id_hidden');
		$data['pangkat']=$this->input->post('edit_nama');
		$data['urutan']=$this->input->post('edit_urutan');
		$data['pokpangkat']=$this->input->post('edit_pokpangkat');
		$data['intensif']=$this->input->post('edit_intensif');
		
		$id=$this->mmpangkat_urikes->edit_pangkat_urikes($id,$data);

		echo json_encode($id);
	}

	public function delete_pangkat_urikes(){	
		$id=$this->input->post('id');	
		if($id!=''){
			$id=$this->mmpangkat_urikes->delete_pangkat_urikes($id);
			// $data['no_telp_pj']=1;
			//$id=$this->mmpangkat_urikes->edit_ket_urikes($id,$data);	
			echo json_encode($id);
		}
	}

}
