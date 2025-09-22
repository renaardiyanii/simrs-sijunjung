<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcgizi extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmgizi','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	//kelompok diet
	public function index(){
		$data['title'] = 'Master Kelompok Diet';

		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvkeldiet',$data);
		//print_r($data);
	}

	public function insert_keldiet(){

		$data['idpokdiet']=$this->input->post('idpokdiet');
		$data['pokdiet']=$this->input->post('pokdiet');		
		$data['xcreate']=$this->input->post('xuser');
		$id=$this->mmgizi->insert_keldiet($data);		
				
		echo json_encode($id);
	}

	function show_keldiet(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmgizi->get_all_keldiet()->result();		
				
		foreach ($hasil as $value) {						
			$row2['idpokdiet'] = $value->idpokdiet;
			$row2['pokdiet'] = $value->pokdiet;				
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keldiet(\''.$value->idpokdiet.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_keldiet(\''.$value->idpokdiet.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function get_data_edit_keldiet(){
		$idpokdiet=$this->input->post('idpokdiet');
		$datajson=$this->mmgizi->get_data_keldiet($idpokdiet)->result();		
	    echo json_encode($datajson);
	}

	public function edit_keldiet(){
		$idpokdiet=$this->input->post('edit_idpokdiet_hidden');
		$data['pokdiet']=$this->input->post('edit_pokdiet');
		
		$id=$this->mmgizi->edit_keldiet($idpokdiet,$data);

		echo json_encode($id);
	}

	public function delete_keldiet(){	
		$idpokdiet=$this->input->post('idpokdiet');	
		if($idpokdiet!=''){
			$id=$this->mmgizi->delete_keldiet($idpokdiet);			
			echo json_encode($id);
		}
	}

	//master menu diet
	// iddiet namadiet idpokdiet tipemakanan grupreport
	public function menu_diet(){
		
		$data['title'] = 'Master Menu Diet';

		$data['menudiet']=$this->mmgizi->get_all_menudiet()->result();
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		$data['tipemakanan']=$this->mmgizi->get_all_tipemakanan()->result();
		$data['menu']=$this->mmgizi->get_all_menu()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvmenudiet',$data);
		//print_r($data);
		
	}

	public function menu(){
		$data['title'] = 'Master Menu';

		$data['menu']=$this->mmgizi->get_all_menu()->result();
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		$data['tipemakanan']=$this->mmgizi->get_all_tipemakanan()->result();
		//$data['grupreport']=$this->mmgizi->get_all_grupreport()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvmenu',$data);
		//print_r($data);
	}

	function show_menudiet(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmgizi->get_all_menudiet()->result();		
				
		foreach ($hasil as $value) {
			$row2['iddiet'] = $value->iddiet;
			$row2['nama_menu'] = $value->nama_menu;
			$row2['idkeldiet'] = $value->idkel_diet;
			$row2['pokdiet'] = $value->pokdiet;				
			$row2['komposisi'] = $value->komposisi;
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_menudiet(\''.$value->iddiet.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_menudiet(\''.$value->iddiet.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

    function show_menu(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->mmgizi->get_all_menu()->result();		
				
		foreach ($hasil as $value) {
			$row2['idmenu_diet'] = $value->idmenu_diet;
			$row2['nama_menu'] = $value->nama_menu;			
			$row2['tipemakanan'] = $value->tipe_makanan;
			$row2['komposisi'] = $value->komposisi;
			$row2['aksi'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_menu(\''.$value->idmenu_diet.'\')"><i class="fa fa-edit"></i></button>
				<button type="button" class="btn btn-danger btn-xs" onclick="delete_menu(\''.$value->idmenu_diet.'\')"><i class="fa fa-trash"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

    public function get_tipemakanan(){
    	$datajson = $this->mmgizi->get_all_tipemakanan()->result();
        // Add below to output the json for your javascript to pick up.
        echo json_encode($datajson);
    }

    public function get_grupreport(){
    	$datajson = $this->mmgizi->get_all_grupreport()->result();
        // Add below to output the json for your javascript to pick up.
        echo json_encode($datajson);
    }

    public function insert_menudiet(){
		$data['iddiet']=$this->input->post('iddiet');
		$data['idkel_diet']=$this->input->post('keldiet');
		$data['idmenu_diet']=$this->input->post('idmenu_diet');
		$data['status']=1;
		$login_data = $this->load->get_var("user_info");
		$data['xinput'] = $login_data->username;

		$id=$this->mmgizi->insert_menudiet($data);		
		
		echo json_encode($id);
	}

	public function insert_menu(){
		$data['idmenu_diet']=$this->input->post('idmenu_diet');
		$data['nama_menu']=$this->input->post('nama_menu');
		if($this->input->post('tipemakanan')!='a'){
			$data['tipe_makanan']=$this->input->post('tipemakanan');
		}else{
			$data['tipe_makanan']=strtoupper($this->input->post('tipemakanan_lain'));
		}

		$data['komposisi']=$this->input->post('komposisi');
		$id=$this->mmgizi->insert_menu($data);		
		
		echo json_encode($id);
	}

	public function get_data_edit_menudiet(){
		$iddiet=$this->input->post('iddiet');
		$datajson=$this->mmgizi->get_data_menudiet($iddiet)->result();
	    echo json_encode($datajson);
	}

	public function get_data_edit_menu(){
		$idmenu_diet=$this->input->post('idmenu_diet');
		$datajson=$this->mmgizi->get_data_menu($idmenu_diet)->result();
	    echo json_encode($datajson);
	}

	public function edit_menudiet(){
		$iddiet=$this->input->post('edit_iddiet_hidden');
		$data['idkel_diet']=$this->input->post('edit_keldiet');
		$data['idmenu_diet']=$this->input->post('edit_idmenu_diet');
		$data['status']=1;
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->username;
		$data['xupdate'] = date('Y-m-d H:i');
		$id=$this->mmgizi->edit_menudiet($iddiet,$data);

		echo json_encode($id);
	}

	public function edit_menu(){
		$idmenu_diet=$this->input->post('edit_idmenudiet_hidden');
		$data['nama_menu']=$this->input->post('edit_nama_menu');
		
		if($this->input->post('edit_tipemakanan')!='a'){
			$data['tipe_makanan']=$this->input->post('edit_tipemakanan');
		}else{
			$data['tipe_makanan']=strtoupper($this->input->post('edit_tipemakanan_lain'));
		}

		$data['komposisi']=$this->input->post('edit_komposisi');

		$id=$this->mmgizi->edit_menu($idmenu_diet,$data);

		echo json_encode($id);
	}

	public function delete_menudiet(){	
		$iddiet=$this->input->post('iddiet');	
		if($iddiet!=''){
			$id=$this->mmgizi->delete_menudiet($iddiet);
			echo json_encode($id);
		}
	}

	public function delete_menu(){	
		$idmenu_diet=$this->input->post('idmenu_diet');	
		if($idmenu_diet!=''){
			$id=$this->mmgizi->delete_menu($idmenu_diet);
			echo json_encode($id);
		}
	}

}
