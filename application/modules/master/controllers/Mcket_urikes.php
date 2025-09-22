<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcket_urikes extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmket_urikes','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	//ket_urikes Kasir
	public function index(){
		$data['title'] = 'Master Keterangan Urikes';

		$data['ket_urikes']=$this->mmket_urikes->get_all_ket_urikes()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvket_urikes',$data);
		//print_r($data);
	}

	public function insert_ket_urikes(){

		//$data['id']=$this->input->post('id');
		$data['nama_ket_urikes']=$this->input->post('kasir');		
		$data['pj_ket_urikes']=$this->input->post('deskripsi');
		$data['no_telp_pj']=$this->input->post('telp_pj');
		$id=$this->mmket_urikes->insert_ket_urikes($data);		
				
		echo json_encode($id);
	}

	function show_ket_urikes(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmket_urikes->get_all_ket_urikes()->result();		
				
		foreach ($hasil as $value) {						
			$row2['id'] = $value->ket_urikes;
			$row2['kasir'] = $value->nama_ket_urikes;		
			$row2['deskripsi'] = $value->pj_ket_urikes;
			$row2['status'] = $value->no_telp_pj;			
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_ket_urikes(\''.$value->ket_urikes.'\',\''.$value->nama_ket_urikes.'\',\''.$value->pj_ket_urikes.'\',\''.$value->no_telp_pj.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_ket_urikes(\''.$value->ket_urikes.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function get_data_edit_ket_urikes(){
		$id=$this->input->post('id');
		$datajson=$this->mmket_urikes->get_data_ket_urikes($id)->result();		
	    echo json_encode($datajson);
	}

	public function edit_ket_urikes(){
		$id=$this->input->post('edit_id_hidden');
		$data['nama_ket_urikes']=$this->input->post('edit_kasir');
		$data['pj_ket_urikes']=$this->input->post('edit_deskripsi');
		$data['no_telp_pj']=$this->input->post('edit_telp_pj');
		
		$id=$this->mmket_urikes->edit_ket_urikes($id,$data);

		echo json_encode($id);
	}

	public function delete_ket_urikes(){	
		$id=$this->input->post('id');	
		if($id!=''){
			$id=$this->mmket_urikes->delete_ket_urikes($id);
			// $data['no_telp_pj']=1;
			//$id=$this->mmket_urikes->edit_ket_urikes($id,$data);	
			echo json_encode($id);
		}
	}

}
