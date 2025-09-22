<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_emedrec extends Secure_area {
    public function __construct() {
        parent::__construct();
        // $this->load->model('irj/rjmpencarian','',TRUE);
        // $this->load->model('irj/rjmregistrasi','',TRUE);
        $this->load->model('emedrec/M_emedrec','',TRUE);
        // $this->load->model('irj/rjmpelayanan','',TRUE);
        // $this->load->model('irj/rjmkwitansi','',TRUE);
        // //$this->load->model('ird/ModelRegistrasi','',TRUE);
        // $this->load->model('admin/M_user','',TRUE);
        // $this->load->model('irj/M_update_sepbpjs','',TRUE);
        // $this->load->model('bpjs/Mbpjs','',TRUE);
        // $this->load->helper('pdf_helper');
        // $this->load->helper('bpjs');
        // $this->load->helper('tgl_indo');
    }

    public function index(){
        $data['title'] = 'E MEDREC';
        
        $data['data_pasien'] =  "";
        $data['result_lab'] = [];
        $data['data_pasien_irj'] = [];
        $data['data_pasien_ird'] = [];
        
        $this->load->view('emedrec/V_emedrec', $data);
    }

    // Get Data Pasien
    public function pasien($cm='')
	{
		$data['title'] = 'E MEDREC';
		$data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
        // print_r($data['data_pasien']);
        // exit();
		// $data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		$data['data_pasien_irj'] = $this->M_emedrec->getdata_record_pasien($this->input->post('cari_no_cm'))->result();
        $data['data_pasien_iri'] = $this->M_emedrec->getdata_iri_pasien($this->input->post('cari_no_cm'))->result();
        $data['data_pasien_ird'] =  $this->M_emedrec->getdata_ird_pasien($this->input->post('cari_no_cm'))->result();
        // print_r($data['data_pasien_irj']);
        // exit();
        $data['result_lab'] = [];
		
		if (empty($data['data_pasien'])==1) 
		{
			$success = 	'<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('emedrec/C_emedrec');
		
		} else {
		
			$this->load->view('emedrec/V_emedrec',$data);
		}
		
	}

    public function get_data_transaksi(){
        $nocm = '00000002';
        $data['data_pasien'] = $this->M_emedrec->getdata_record_pasien($nocm)->result();
        print_r($data['data_pasien']);
        exit();
    }

    public function get_detail_lab(){
		$no_reg=$this->input->post('no_reg');
		$datajson=$this->M_emedrec->getdata_detail_lab($no_reg)->result();
        // print_r(datajson);
        // exit();
	    echo json_encode($datajson);
	}

    public function get_detail_obat(){
		$no_reg=$this->input->post('no_reg');
		$datajson=$this->M_emedrec->getdata_detail_obat($no_reg)->result();
        // print_r(datajson);
        // exit();
	    echo json_encode($datajson);
	}

    public function get_detail_radiologi(){
		$no_reg=$this->input->post('no_reg');
		$datajson=$this->M_emedrec->getdata_detail_radiologi($no_reg)->result();
        // print_r(datajson);
        // exit();
	    echo json_encode($datajson);
	}
}