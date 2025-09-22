<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcloket extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmloket','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	//Loket Kasir
	public function index(){
		$data['title'] = 'Master Loket Kasir';

		$data['Loket']=$this->mmloket->get_all_loket()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvloket',$data);
		//print_r($data);
	}

	public function insert_loket(){

		//$data['id']=$this->input->post('id');
		$data['kasir']=$this->input->post('kasir');		
		$data['deskripsi']=$this->input->post('deskripsi');
		$data['is_active']=0;
		$id=$this->mmloket->insert_loket($data);		
				
		echo json_encode($id);
	}

	function show_loket(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmloket->get_all_loket()->result();		
				
		foreach ($hasil as $value) {						
			$row2['id'] = $value->id;
			$row2['kasir'] = $value->kasir;		
			$row2['deskripsi'] = $value->deskripsi;
			$status='Aktif';
			if((int)$value->is_active==1){
				$status='Nonaktif';
			}
			$row2['status'] = $status;			
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_loket(\''.$value->id.'\',\''.$value->kasir.'\',\''.$value->deskripsi.'\',\''.$value->is_active.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_loket(\''.$value->id.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function get_data_edit_loket(){
		$id=$this->input->post('id');
		$datajson=$this->mmloket->get_data_loket($id)->result();		
	    echo json_encode($datajson);
	}

	public function edit_loket(){
		$id=$this->input->post('edit_id_hidden');
		$data['kasir']=$this->input->post('edit_kasir');
		$data['deskripsi']=$this->input->post('edit_deskripsi');
		$data['is_active']=$this->input->post('edit_isactive');
		
		$id=$this->mmloket->edit_loket($id,$data);

		echo json_encode($id);
	}

	public function delete_loket(){	
		$id=$this->input->post('id');	
		if($id!=''){
			//$id=$this->mmloket->delete_loket($id);
			$data['is_active']=1;
			$id=$this->mmloket->edit_loket($id,$data);	
			echo json_encode($id);
		}
	}

}
