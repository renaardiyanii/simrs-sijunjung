<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once("Secure_area.php");
class Beranda extends Secure_area {
	public function __construct() {
		parent::__construct();

		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->helper('pdf_helper');

	}
	
	public function index()
	{
		$data['title'] = 'beranda';
		$data['roleid'] = $this->labmdaftar->get_roleid($this->session->userdata('userid'))->row()->roleid;
		$data['cek_kasir']='';
		if($data['roleid']=='1' || $data['roleid']=='8' || $data['roleid']=='9' || $data['roleid']=='14' || $data['roleid']=='15' || $data['roleid']=='16' || $data['roleid']=='26' || $data['roleid']=='31'){
			$data['kasir'] = $this->M_user->get_role_akses($this->session->userdata('userid'))->result();
			$data['cek_kasir']=1;
		}
		$this->load->view('rsvberanda',$data);
		
	}
	
	public function load_pdf($link)
	{
		echo '<script type="text/javascript">window.open("'.site_url("beranda/load/$link").'", "");window.focus();</script>';
		$data['title'] = 'Beranda';
		$this->load->view('rsvberanda',$data);
	}

	public function insert_aksesLoket()
	{	
		date_default_timezone_set("Asia/Jakarta");

		$kasir = explode("@", $this->input->post('loket_kasir'));
		$data['kasir']=$kasir[0];
		$data['idkasir']=$kasir[1];

        $data_insert = array(
        	'xupdate' => date('Y-m-d H:i'),
        	'idkasir' => $data['idkasir'],
        	'kasir' => $data['kasir'],
        	'userid' => $this->session->userdata('userid')
        );
		if($this->M_user->userAksesSaveOne($this->session->userdata('userid'),$data_insert)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function getUserKasir(){
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		echo json_encode($result);
	}

	public function load($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'doc/'.$link));
	}
}

?>