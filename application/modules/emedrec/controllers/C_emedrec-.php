<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_emedrec extends Secure_area {
    public function __construct() {
        parent::__construct();
        $this->load->model('emedrec/M_emedrec','',TRUE);
        $this->load->model('admin/appconfig','',TRUE);
    }

    public function index(){
        $data['title'] = 'E MEDREC RAWAT JALAN';
        
        $data['data_pasien'] =  "";
        $data['result_lab'] = [];
        $data['data_pasien_irj'] = [];
        $data['data_pasien_iri'] = [];
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
		// $data['data_pasien_irj'] = $this->M_emedrec->getdata_record_pasien($this->input->post('cari_no_cm'))->result();
        // $data['data_pasien_iri'] = $this->M_emedrec->getdata_iri_pasien($this->input->post('cari_no_cm'))->result();
        // $data['data_pasien_ird'] =  $this->M_emedrec->getdata_ird_pasien($this->input->post('cari_no_cm'))->result();
        // print_r($data['data_pasien_irj']);
        // exit();
        // $data['result_lab'] = [];
		
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

    public function get_data_pasien(){
        $nocm = $this->input->post('no_medrec');
        $datajson = $this->M_emedrec->get_data_pasien_by_no_cm($nocm)->result();
        // print_r($data['data_pasien']);
        // exit();
        echo json_encode($datajson);
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

    public function rekam_medik_detail($cm=''){
        $cm_string = strval($cm);
        $data['title'] = 'REKAM MEDIK '.$cm_string;
        $data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['data_pasien_irj'] = $this->M_emedrec->getdata_record_pasien($cm)->result();
        $this->load->view('emedrec/V_rekam_medik_detail',$data);
    }

    public function cetak_resume($no_cm=''){
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		
		$data['data_pasien_irj'] = $this->M_emedrec->get_data_ringkas_medik_rj($no_cm)->result();
        // var_dump($data['data_pasien_irj']);
		$this->load->view('emedrec/rj/CETAK_RESUME',$data);
	}

    public function cetak_asesmen_awal_keperawatan($cm='',$no_reg=''){
        $data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['asesmen_keperawatan'] = $this->M_emedrec->get_data_asesmen_keperawatan($no_reg)->result();
        $data['asesmen_masalah_keperawatan'] = $this->M_emedrec->get_data_asesmen_masalah_keperawatan($no_reg)->result();
        $data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['data_rawat_jalan'] = $this->M_emedrec->getdata_record_pasien($cm)->result();
        $this->load->view('emedrec/rj/asesmen_awal_keperawatan',$data);
    }

    public function cetak_cppt_rawat_jalan(){
        $data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/cppt_rawat_jalan',$data);
    }

    public function cetak_telaah_resep(){
        $data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/telaah_resep_rawat_jalan',$data);
    }

    public function cetak_asesmen_awal_medis()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/asesmen_awal_medis', $data);
    }

    public function cetak_surat_kontrol()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/surat_kontrol', $data);
    }

    public function cetak_jawaban_konsultasi()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/jawaban_konsultasi', $data);
    }

    public function cetak_surat_bukti_pelayanan()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/surat_bukti_pelayanan', $data);
    }

    public function cetak_surat_radiologi()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/cetak_radiologi', $data);
    }

    public function cetak_surat_elektromedik()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/cetak_elektromedik', $data);
    }

    public function cetak_lembar_konsultasi()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/lembar_konsultasi', $data);
    }

    
    
}