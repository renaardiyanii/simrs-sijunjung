<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include('.php');
require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class El_record extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('medrec/m_elrecord','',TRUE);
	}

	public function index(){
		$data['title'] = 'DAFTAR ELEKTRONIK MEDICAL RECORD';

		// $key=$this->input->post('key');
		// if(empty($key)){
		// 	$data['data_pasien']=$this->labmdaftar->get_daftar_pasien_lab()->result();
		// }else{
		// 	$data['data_pasien']='';
		// }
		$data_post=1;
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
		}		
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
		}else{
			$data['data_pasien']='';
			$data_post=0;
			// $this->load->view('medrec/v_elektronik',$data);
		}
		
		if (empty($data['data_pasien'])==1 AND $data_post==1){
			$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data pasien tidak ditemukan !
							</h4>
						</div>
					</div>
				</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('medrec/el_record');
		} else {
			$this->load->view('medrec/v_elektronik',$data);
		}
	}

	public function pasien($no_medrec=""){
		if($no_medrec!=''){
			$data['title'] = 'ELEKTRONIK MEDICAL RECORD ';

			$data['data_pasien'] = $this->m_elrecord->get_data_pasien($no_medrec)->row();
			$data['kunj_jalan'] = $this->m_elrecord->get_kunj_rj($no_medrec)->result();
			$data['count_kunj_jalan'] = count($data['kunj_jalan']);
			$data['kunj_inap'] = $this->m_elrecord->get_kunj_ri($no_medrec)->result();
			$data['count_kunj_inap'] = count($data['kunj_inap']);
			$data['data_farmasi'] = $this->m_elrecord->get_kunj_farmasi($no_medrec)->result();
			$data['count_data_farmasi'] = count($data['data_farmasi']);
			$data['data_lab'] = $this->m_elrecord->get_data_lab($no_medrec)->result();
			$data['count_data_lab'] = count($data['data_lab']);

			$data['data_rad'] = $this->m_elrecord->get_data_rad($no_medrec)->result();
			$data['count_data_rad'] = count($data['data_rad']);
			$data['data_ok'] = $this->m_elrecord->get_data_ok($no_medrec)->result();
			$data['count_data_ok'] = count($data['data_ok']);
			
			$this->load->view('medrec/v_pasien',$data);
			// print_r(json_encode($data['data_pasien']));
		}
		
	}
}