<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class C_emedrec extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('emedrec/M_emedrec', '', TRUE);
        $this->load->model('emedrec/M_emedrec_iri', '', TRUE);
        $this->load->model('admin/appconfig', '', TRUE);
        $this->load->model('irj/Rjmlaporan', '', TRUE);
        $this->load->model('irj/rjmpelayanan', '', TRUE);
        $this->load->model('farmasi/Frmmdaftar', '', TRUE);
        $this->load->model('lab/labmdaftar', '', TRUE);
        $this->load->model('rad/radmdaftar', '', TRUE);
        $this->load->model('irj/rjmregistrasi', '', TRUE);
        $this->load->model('lab/labmdaftar', '', TRUE);
    }

    public function index()
    {
        $data['title'] = 'E MEDREC RAWAT JALAN';

        $data['data_pasien'] =  "";
        $data['result_lab'] = [];
        $data['data_pasien_irj'] = [];
        $data['data_pasien_iri'] = [];
        $data['data_pasien_ird'] = [];

        $this->load->view('emedrec/V_emedrec', $data);
    }

    // Get Data Pasien
    public function pasien($cm = '')
    {
        // var_dump($this->input->post());die();
        /**
         * Overhaul , 
         * Perbaikan rekomendasi bssn 2023
         * @aldi 28/03/2023 9:11 AM
         */
        $data['title'] = 'E MEDREC';
        $isError = false;
        // validasi jika bukan type integer => keluarkan pesan
        // if (!filter_var($this->input->post('cari_no_rm'), FILTER_VALIDATE_INT)) {
        //     $success =     '<div class="alert alert-danger">
        //                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //                     <h4 class="text-danger"><i class="fa fa-ban"></i> Pastikan isi No. RM dengan benar !</h4>
        //                 </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec');
        //     return;
        // }
        if( $this->input->post('search_per')== 'cm' ){
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_medrecs($this->input->post('cari_no_rm'))->result();
        }else if($this->input->post('search_per')== 'nama'){
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_nama(strtoupper($this->input->post('cari_nama')))->result();
        }else{
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_medrecs($this->input->post('cari_no_rm'))->result();
        }
       
        if (empty($data['data_pasien']) == 1) {
            $success =     '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec');
            return;
        }
        $this->load->view('emedrec/V_emedrec', $data);
    }

    public function get_data_pasien()
    {
        $nocm = $this->input->post('no_medrec');
        $datajson = $this->M_emedrec->get_data_pasien_by_no_cm($nocm)->result();
        // print_r($data['data_pasien']);
        // exit();
        echo json_encode($datajson);
    }

    public function get_detail_lab()
    {
        $no_reg = $this->input->post('no_reg');
        $datajson = $this->M_emedrec->getdata_detail_lab($no_reg)->result();
        // print_r(datajson);
        // exit();
        echo json_encode($datajson);
    }

    public function get_detail_obat()
    {
        $no_reg = $this->input->post('no_reg');
        $datajson = $this->M_emedrec->getdata_detail_obat($no_reg)->result();
        // print_r(datajson);
        // exit();
        echo json_encode($datajson);
    }

    public function get_detail_radiologi()
    {
        $no_reg = $this->input->post('no_reg');
        $datajson = $this->M_emedrec->getdata_detail_radiologi($no_reg)->result();
        // print_r(datajson);
        // exit();
        echo json_encode($datajson);
    }

    public function rekam_medik_detail($cm = '', $no_medrec = '', $register = "", $register_old = "")
    {
        if ($no_medrec != '') {
            $data['register'] = $register;
            $data['register_old'] = $register_old;
            $cm_string = strval($cm);
            $data['title'] = 'REKAM MEDIK ' . $cm_string;
            $data['data_pasien'] = ($no_medrec != "") ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : '';
            $data['data_pasien_irj'] = ($no_medrec != "") ? $this->M_emedrec->getdata_record_pasien($no_medrec)->result() : '';
            $data['data_pasien_iri'] = ($no_medrec != "") ? $this->M_emedrec->getdata_iri_pasien($no_medrec)->result() : '';
            $data['data_pasien_ird'] = ($no_medrec != "") ? $this->M_emedrec->getdata_ird_pasien($no_medrec)->result() : '';
            $data_pasien_irj = ($no_medrec != "") ? $this->M_emedrec->getdata_record_pasien($no_medrec)->row() : '';
            $data_pasien_iri = ($no_medrec != "") ? $this->M_emedrec->getdata_iri_pasien($no_medrec)->row() : '';
            $data_pasien_ird = ($no_medrec != "") ? $this->M_emedrec->getdata_ird_pasien($no_medrec)->row() : '';
            if ($data_pasien_irj != null) {
                $data['noregister'] = $data_pasien_irj->noregister;
            } elseif ($data_pasien_iri != null) {
                $data['noregister'] = $data_pasien_iri->no_ipd;
            } else {
                if ($data_pasien_ird)
                    $data['noregister'] = $data_pasien_ird->noregister;
                else
                    $data['noregister'] = null;
            }



            $this->load->view('emedrec/V_rekam_medik_detail', $data);
        } else {

            redirect('emedrec/C_emedrec');
        }
    }

    public function cetak_resume($no_cm = '')
    {
        $conf = $this->appconfig->get_headerpdf_appconfig()->result();
        $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
        $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_cm)->result();
        $data['data_pasien_irj'] = $this->M_emedrec->get_data_ringkas_medik_rj($no_cm)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_document('prmrj');
        $this->load->view('emedrec/rj/CETAK_RESUME', $data);
    }

    public function cetak_resume_by_noreg()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        // $data_prrmj = $no_reg?$this->M_emedrec->cek_prrmj($no_reg)->row():null;

        // if($data_prrmj != null){

        $data['kode_document'] = $this->M_emedrec->get_kode_document('prmrj');

        $data['data_pasien'] = $cm ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
        $conf = $this->appconfig->get_headerpdf_appconfig()->result();
        $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
        $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['diagnosas'] = $no_reg ? $this->M_emedrec->get_diagnosa_pasien_by_noreg($no_reg) : null;
        $data_pasien_irj_all = $no_reg ? $this->M_emedrec->get_data_ringkas_medik_rj_by_noreg($no_reg)->result() : null;
        $data['data_pasien_irj'] =  $data_pasien_irj_all;
        $nama_sip = $data_pasien_irj_all[0]->nm_dokter;
        $data['no_sip_dokter'] = $this->M_emedrec->data_nipeg_by_nama($nama_sip)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('prmrj')->row();
        // var_dump($data['no_sip_dokter']);
        $this->load->view('emedrec/rj/CETAK_RESUME', $data);

        // }else{

        //     $success = 	'<div class="alert alert-danger">
        //                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //                             <h3>Tidak ada pemeriksaan
        //                         </div>';
        //             $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }


    }

    public function cetak_asesmen_awal_keperawatan($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        //if($data_all != null){

        $data['poli'] = $this->input->post('poli');
        //  var_dump($data['poli']);die();

        //  var_dump($data['kode_document']);die();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_assesment_keperawatan_irj'] = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        $data['asesmen_keperawatan'] = isset($no_reg) ? $this->M_emedrec->get_data_asesmen_keperawatan($no_reg ?? "")->result() : "";
        $data['asesmen_masalah_keperawatan'] = isset($no_reg) ? $this->M_emedrec->get_data_asesmen_masalah_keperawatan($no_reg ?? "")->result() : '';
        // var_dump($data['get_assesment_keperawatan_irj']);
        $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm ?? "")->result() : "";
        $data['data_rawat_jalan'] = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg ?? "")->result() : "";
        $data['get_ttd_perawat'] = $data['asesmen_keperawatan'] ? $this->M_emedrec->get_ttd_perawat_by_soap($no_reg)->row() : '';

        $kode_dokumen = '';
        if (isset($data['poli'])) {
            switch ($data['poli']) {
                case 'POLI MATA':
                    $kode_dokumen = 'keperawatan_mata';
                    break;
                case 'KEBIDANAN dan KANDUNGAN':
                    $kode_dokumen = 'keperawatan_bidan';
                    break;
                default:
                    $kode_dokumen = 'assesment_keperawatan_poliklinik';
                    break;
            }
        }


        // $data['kode_document'] = $this->M_emedrec->get_kode_document($kode_dokumen);
        // $datakode_document = $this->M_emedrec->get_kode_document('assesment_keperawatan_poliklinik');
        // if($datakode_document){

        // }else{
        //     $data['kode_document'] = null;
        // }

        if ($data['poli'] == 'MATA') {
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_mata')->row();
            $this->load->view('emedrec/rj/formassesmentkeperawatan/awal_keperawatan_mata', $data);
        } else if ($data['poli'] == 'KEBIDANAN dan KANDUNGAN') {
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_bidan')->row();
            $this->load->view('emedrec/rj/formkebidanan/kebidanan', $data);
        } else {
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_poli')->row();
            $this->load->view('emedrec/rj/formassesmentkeperawatan/asesmen_awal_keperawatan', $data);
        }



        //}else{

        // $success = 	'<div class="alert alert-danger">
        //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //                         <h3>Tidak ada pemeriksaan
        //                     </div>';
        //         $this->session->set_flashdata('success_msg', $success);
        // redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        //}
    }

    public function cetak_data_pasien($no_cm = '')
    {
        $data['kode_document'] = $this->M_emedrec->get_kode_document('pendaftaran');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $cekdata = $this->M_emedrec->getdata_identitas($no_cm)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm_real($no_cm)->result();
        if ($cekdata == null) {
            $data['data_identitas'] = $this->M_emedrec->getdata_identitas_two($no_cm)->result();
        } else {
            $data['data_identitas'] = $this->M_emedrec->getdata_identitas($no_cm)->result();
        }

        // var_dump($)						
        return $this->load->view('emedrec/rj/identitas_pasien', $data);
    }

    public function cetak_cppt_rawat_jalan($no_medrec = '', $no_cm = "",$rd = '')
    {
        // $data['no_register'] = $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt($no_medrec);
        // $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_noreg($no_reg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_cm)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cppt')->row();
        //  var_dump( $data['data_pasien']);die();
        $data['rd'] = $rd;
        $data['nama_form'] = 'CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN';
        $this->load->view('emedrec/rj/cppt_rawat_jalan', $data);
    }

    public function cetak_cppt_pasien_poli($no_medrec = '', $id_poli = '', $rd = "")
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_poli($no_medrec, $id_poli);
        // $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_noreg($no_reg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_medrec)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_document('cppt');
        $data['rd'] = $rd;
        $this->load->view('emedrec/rj/cppt_rawat_jalan_poli', $data);
    }

    public function cetak_cppt_pasien_poli_all($no_cm='',$no_medrec = '', $rd = '')
    {
        // var_dump($no_cm);die();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_poli_all($no_medrec);
        // $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_noreg($no_reg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_cm)->row();
        $data['nama_form'] = 'CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN';
        $data['rd'] = $rd;
        $this->load->view('emedrec/rj/cppt_rawat_jalan_poli', $data);
    }

    public function cetak_cppt_pasien_all($no_medrec = '', $rd = "")
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_all($no_medrec);
        // $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_noreg($no_reg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_medrec)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cppt')->row();
        $data['rd'] = $rd;
        $this->load->view('emedrec/rj/cppt_rawat_jalan_all', $data);
    }

    public function cetak_telaah_resep()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $this->load->view('emedrec/rj/telaah_resep_rawat_jalan', $data);
    }

    public function cetak_asesmen_awal_medis($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        $data['data_pasien'] = ($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
        $data_medik = isset($no_reg) ? $this->M_emedrec->get_pemeriksaan_fisik_by_noreg($no_reg)->row() : "";
        if ($data_medik != null) {
            $data['poli'] = $this->input->post('poli');
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['soap_pasien_rj'] = isset($no_reg) ? $this->M_emedrec->get_soap_pasien_rj_no_reg($no_reg)->row() : "";
            $data['pemeriksaan_fisik'] = isset($no_reg) ? $this->M_emedrec->get_pemeriksaan_fisik_by_noreg($no_reg)->row() : "";
            $data['assesment_gigi'] = isset($no_reg) ? $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_reg)->result() : '';
            $data_semua = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->row() : "";
            $data_nip = $data_semua->id_dokter;
            $data['nip_dokter'] = isset($data_nip) ? $this->M_emedrec->data_nipeg_by_id($data_nip)->row() : "";
            $data['data_rawat_jalan'] = $data_semua;
            $data['gigi'] = isset($no_reg) ? $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_reg)->result() : '';
            $data['get_ttd'] = isset($data['soap_pasien_rj']->id_pemeriksa) ? $this->M_emedrec->get_ttd_perawat($data['soap_pasien_rj']->id_pemeriksa)->row() : "";
            $kode_dokumen = '';
            //   var_dump($data['poli']);die();
            if (isset($data['poli'])) {
                switch ($data['poli']) {
                    case 'UMUM':
                        $kode_dokumen = 'medis_umum';
                        break;
                    case 'SARAF (NEUROLOGI)':
                        $kode_dokumen = 'medis_saraf';
                        break;
                    case 'PENYAKIT DALAM (INTERNE)':
                        $kode_dokumen = 'medis_interne';
                        break;
                    case 'ANAK':
                        $kode_dokumen = 'medis_anak';
                        break;
                    case 'NEUROPSIKIATRI':
                        $kode_dokumen = 'medis_psikiatri';
                        break;
                    case 'BEDAH':
                        $kode_dokumen = 'medis_bedah_umum';
                        break;
                    case 'BEDAH SYARAF':
                        $kode_dokumen = 'medis_bedah_syaraf';
                        break;
                    case 'MATA':
                        $kode_dokumen = 'medis_mata';
                        break;
                    case 'JANTUNG DAN PEMBULUH DARAH':
                        $kode_dokumen = 'medis_jantung';
                        break;
                    case 'GIGI DAN MULUT':
                        $kode_dokumen = 'gigi';
                        break;
                    case 'PARU':
                        $kode_dokumen = 'medis_paru';
                        break;
                    case 'GIZI':
                        $kode_dokumen = 'medis_gizi';
                        break;




                    case 'FUNGSI LUHUR':
                        $kode_dokumen = '';
                        break;
                    case 'POLI BEDAH SYARAF':
                        $kode_dokumen = 'assesment_medis_bedah_syaraf';
                        break;

                    case 'POLI BEDAH UMUM':
                        $kode_dokumen = 'assesment_medis_bedah_umum';
                        break;
                    case 'POLI GIGI DAN MULUT':
                        $kode_dokumen = 'assesment_medis_gigi';
                        break;


                    case 'POLI GIZI':
                        $kode_dokumen = 'assesment_medis_gizi';
                        break;
                    case 'POLI PARU':
                        $kode_dokumen = 'assesment_medis_paru';
                        break;
                    case 'POLIKLINIK JANTUNG DAN PEMBULUH DARAH':
                        $kode_dokumen = 'assesment_medis_jantung';
                        break;

                    default:
                        $kode_dokumen = 'assesment_medis_umum';
                        break;
                }
            }


            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form($kode_dokumen)->row();
            if ($data['kode_document']) {
                $data['kode_document'];
            } else {
                $data['kode_document'] = null;
            }

            if ($data['poli'] == 'GIGI DAN MULUT') {

                // $this->load->view('emedrec/rj/formgigi/rekam_medik_gigi',$data);
                $this->load->view('emedrec/rj/asesmen_awal_medis', $data);
            } else if ($data['poli'] == 'MATA') {

                $this->load->view('emedrec/rj/asesmen_awal_medis_mata', $data);
            } else {
                $this->load->view('emedrec/rj/asesmen_awal_medis', $data);
            }
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
        </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_kontrol_new($no_medrec = "", $no_register = "")
    {
        $data['no_register'] = $no_register;
        $cm = $no_medrec != "" ? $no_medrec : $this->input->post('no_cm');
        $no_reg = $no_register != "" ? $no_register : $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data_kontrol = $this->M_emedrec->getdata_kontrol($no_reg)->result();
        $catatan = $this->M_emedrec->getdata_kontrol($no_reg)->row()->catatan;
        $tindak_lanjut = $this->M_emedrec->getdata_kontrol($no_reg)->row()->tindak_lanjut;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : "";
        $data_rajal = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result() : "";
        $data['data_rawat_jalan'] = $data_rajal;
        $nipeg_dokter_sip = isset($data_rajal[0]->id_dokter) ? $data_rajal[0]->id_dokter : '';
        $data['nipeg_dokter'] = isset($nipeg_dokter_sip) ? $this->M_emedrec->data_nipeg_by_id($nipeg_dokter_sip)->row() : "";
        // var_dump($data['data_rawat_jalan']);

        $data['data_daftar_ulang_rawat_jalan'] = isset($no_reg) ? $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row() : "";

        return $this->load->view('emedrec/rj/formkontrol/surat_kontrol', $data);
    }

    public function cetak_surat_kontrol($no_medrec = "", $no_register = "")
    {
        $cm = $no_medrec != "" ? $no_medrec : $this->input->post('no_cm');
        $no_reg = $no_register != "" ? $no_register : $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data_kontrol = $this->M_emedrec->getdata_kontrol($no_reg)->result();
        $catatan = $this->M_emedrec->getdata_kontrol($no_reg)->row()->catatan;
        $tindak_lanjut = $this->M_emedrec->getdata_kontrol($no_reg)->row()->tindak_lanjut;

        if ($data_kontrol != NULL) {
            if ($catatan != NULL || $tindak_lanjut != NULL) {
                $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
                $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
                $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : "";
                $data_rajal = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result() : "";
                $data['data_rawat_jalan'] = $data_rajal;
                $nipeg_dokter_sip = isset($data_rajal[0]->id_dokter) ? $data_rajal[0]->id_dokter : '';
                $data['nipeg_dokter'] = isset($nipeg_dokter_sip) ? $this->M_emedrec->data_nipeg_by_id($nipeg_dokter_sip)->row() : "";
                // var_dump($data['nipeg_dokter']);

                $data['data_daftar_ulang_rawat_jalan'] = isset($no_reg) ? $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row() : "";

                if (isset($data['data_daftar_ulang_rawat_jalan']->id_poli)) {
                    if ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BA00') {
                        $data['regis'] = 'RD';
                    } else {
                        $data['regis'] = 'RJ';
                    }
                }

                $data['bulan'] = isset($data['data_daftar_ulang_rawat_jalan']->tgl_kunjungan) ? date('m', strtotime($data['data_daftar_ulang_rawat_jalan']->tgl_kunjungan)) : "";
                $data['tahun'] = isset($data['data_daftar_ulang_rawat_jalan']->tgl_kunjungan) ? date('Y', strtotime($data['data_daftar_ulang_rawat_jalan']->tgl_kunjungan)) : "";

                if (isset($data['data_daftar_ulang_rawat_jalan']->id_poli)) {
                    if ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BJ00') { //neuro
                        $data['kode'] = '1';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BQ00') { //interne
                        $data['kode'] = '2';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BH00') { // mata
                        $data['kode'] = '3';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'jiwa') { // jiwa
                        $data['kode'] = '4';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BR00') { // anak
                        $data['kode'] = '5';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BQ02') { // jantung
                        $data['kode'] = '6';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BB02') { // bedah saraf
                        $data['kode'] = '7';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BB00') { // bedah umum
                        $data['kode'] = '8';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BQ01') { // paru
                        $data['kode'] = '9';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BG00') { // gigi
                        $data['kode'] = '10';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'kebidanan') { // kebidanan
                        $data['kode'] = '11';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BM00') { // gizi
                        $data['kode'] = '12';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'dots') { // dots
                        $data['kode'] = '13';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'vct') { // vct
                        $data['kode'] = '14';
                    } elseif ($data['data_daftar_ulang_rawat_jalan']->id_poli == 'BA00') { // igd
                        $data['kode'] = '15';
                    } else {
                        $data['kode'] = 'belum ada kode';
                    }
                }


                $this->load->view('emedrec/rj/formkontrol/surat_kontrol', $data);
            } else {

                $success =     '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                <h3>Tidak ada pemeriksaan
            </div>';
                $this->session->set_flashdata('success_msg', $success);
                redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
            }
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
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
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data_rad = $no_reg ? $this->M_emedrec->getdata_hasil_pemeriksaan_radiologi($no_reg)->result() : "";

        if ($data_rad != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $cm ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row() : "";
            $data['data_pasien_rad'] = $this->M_emedrec->get_data_rad($no_reg)->row();
            $data_umum_rad = $no_reg ? $this->M_emedrec->getdata_hasil_pemeriksaan_radiologi($no_reg)->result() : "";
            $data['hasil_pemeriksaan_radiologi'] = $data_umum_rad;
            $dokter_sip = isset($data_umum_rad[0]->id_dokter) ? $data_umum_rad[0]->id_dokter : '';
            $data['nipeg_dokter'] = $dokter_sip ? $this->M_emedrec->data_nipeg_by_id($dokter_sip)->row() : "";
            // var_dump($data['nipeg_dokter']);
            $data['kode_document'] = '';

            $diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_reg)->row();
            if ($diag != null) {
                $data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_reg)->result();
            } else {
                $data['nama_diagnosa'] = array();
            }

            $this->load->view('emedrec/rj/formradiologi/cetak_radiologi', $data);
        } else {


            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_hasil_rad()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');

        if ($no_reg != '') {
            $data['no_register'] = $no_reg;
            date_default_timezone_set("Asia/Bangkok");
            $tgl_jam = date("d-m-Y H:i:s");
            $data['tgl'] = date("d-m-Y");

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

            $data['data_hasil_rad'] = $this->radmdaftar->get_data_hasil_rad_by_noreg($no_reg)->result();
            $data['data_hasil_rad2'] = $this->radmdaftar->get_data_hasil_rad_by_noreg($no_reg)->result();

            $data['resultGambar'] = [];

            foreach ($data['data_hasil_rad2'] as $key) {
                $gambar_hasil_rad = $this->radmdaftar->get_gambar_hasil_rad((int)$key->id_pemeriksaan_rad)->result();
                array_push($data['resultGambar'], $this->radmdaftar->get_gambar_hasil_rad((int)$key->id_pemeriksaan_rad)->result());
                $jenis_tindakan = $key->jenis_tindakan;
                $hasil_pengirim = $key->hasil_pengirim;
                foreach ($gambar_hasil_rad as $gambar) {
                    $path = str_replace('https', 'http', base_url() . 'download/rad/' . $gambar->name);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $dt = file_get_contents($path);
                    $tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
                }
                $cekeestttd = $this->labmdaftar->ttd_haisl((int)$key->id_dokter_1)->row();
                $data['ttd'] = isset($cekeestttd->ttd) ? $cekeestttd->ttd : "";
                $data['name'] = isset($cekeestttd->name) ? $cekeestttd->name : '';
            }

            $data['data_pasien'] = $this->radmdaftar->get_data_pasien_cetak_by_noreg($no_reg)->row();
            if ($data['data_pasien']->sex == "L") {
                $data['kelamin'] = "Laki-laki";
            } else {
                $data['kelamin'] = "Perempuan";
            }

            $almt = $data['data_pasien']->alamat;
            if ($data['data_pasien']->rt != "") {
                $almt = $almt . "RT" . $data['data_pasien']->rt;
            }
            if ($data['data_pasien']->rw != "") {
                $almt = $almt . "RW:" . $data['data_pasien']->rw;
            }
            if ($data['data_pasien']->kelurahandesa != "") {
                $almt = $almt . $data['data_pasien']->kelurahandesa;
            }
            if ($data['data_pasien']->kecamatan != "") {
                $almt = $almt . $data['data_pasien']->kecamatan;
            }
            if ($data['data_pasien']->kotakabupaten != "") {
                $almt = $almt . "<br>" . $data['data_pasien']->kotakabupaten;
            }

            $data['almt'] = $almt;

            $get_norad = $this->radmdaftar->get_norad_by_noreg($no_reg)->result();
            foreach ($get_norad as $rad) {
                $no_rad = $rad->no_rad;
            }

            if (substr($data['data_pasien']->no_register, 0, 2) == "RJ") {
                $isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
                $data['isi_qr'] = $isi;
            } else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
                $isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
                $data['isi_qr'] = $isi;
            }

            $get_umur = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
            foreach ($get_umur as $row) {
                $data['tahun'] = $row->umurday;
            }

            if ($data['data_pasien']->cara_bayar == 'DIJAMIN') {
                $a = $this->labmdaftar->getcr_bayar_dijamin($data['data_pasien']->no_register)->row();
                $data['cara_bayar'] = "$a->a - $a->b";
            } else {
                $data['cara_bayar'] = $data['data_pasien']->cara_bayar;
            }

            if (substr($data['no_register'], 0, 2) == 'RJ') {
                $data['nama_dokter'] = $this->radmdaftar->getnm_dokter_rj($data['data_pasien']->no_register)->row()->nm_dokter;
                $data['lokasi'] = $data['data_pasien']->idrg;
            } else if (substr($data['no_register'], 0, 2) == 'RI') {
                $data['nama_dokter'] = $this->radmdaftar->getnm_dokter_ri($data['data_pasien']->no_register)->row()->nm_dokter;
                $data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
                // $lokasi = $nm_poli;
            } else {
                $data['lokasi'] = 'Pasien Langsung';
            }

            $dokter_1 = "";
            foreach ($data['data_hasil_rad'] as $row) {
                if ($row->id_dokter_1 != "") {
                    $data['dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
                    $data['id_dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->id_dokter;
                } else {
                    $data['dokter_1'] = "";
                    $data['id_dokter_1'] = "";
                }
            }

            foreach ($data['data_hasil_rad2'] as $key) {
                $id = isset($key->id_pemeriksaan_rad) ? $key->id_pemeriksaan_rad : null;
                $data['gambar_hasil_rad'] = $this->radmdaftar->get_gambar_hasil_rad((int)$id)->result();
            }

            $writer = new PngWriter();
            $qrCode = QrCode::create($isi)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(155)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0, 10))
                ->setBackgroundColor(new Color(255, 255, 255));

            // Create generic logo
            $logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
                ->setResizeToWidth(40);

            // Create generic label
            $label = Label::create('')
                ->setTextColor(new Color(255, 0, 0));

            $result = $writer->write($qrCode, $logo, $label);
            $hasil =  $result->getDataUri();
            $data['qr'] = $hasil;
            //$data = (string)$data;
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rj/cetak_hasil_rad', $data, true);
            // // $this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_laboratorium()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');

        $data_lab = $this->M_emedrec_iri->get_nolab_pemeriksaan_lab($no_reg)->result();

        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['tgl'] = date("d-m-Y");
            $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : "";
            $data_umum = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result() : "";
            $data['data_rawat_jalan'] = $data_umum;
            $nipeg = isset($data_umum[0]->id_dokter) ? $data_umum[0]->id_dokter : '';
            $data['nipeg_dokter'] = isset($nipeg) ? $this->M_emedrec->data_nipeg_by_id($nipeg)->row() : "";


            $data['register'] = $data_lab;

            $data['get_umur'] = $this->rjmregistrasi->get_umur($medrec)->result();
            foreach ($data['get_umur'] as $row) {
                $data['tahun'] = $row->umurday;
            }

            $data['usia'] = date_diff(date_create($data['data_pasien'][0]->tgl_lahir), date_create('now'));

            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rj/formlaboratorium/cetak_laboratorium', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_laboratorium_old()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        // var_dump($no_reg);
        $data_lab =  $this->M_emedrec->get_data_laboratorium_by_noreg($no_reg)->result();

        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : "";
            $data_umum = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result() : "";
            $data['data_rawat_jalan'] = $data_umum;
            $nipeg = isset($data_umum[0]->id_dokter) ? $data_umum[0]->id_dokter : '';
            $data['nipeg_dokter'] = isset($nipeg) ? $this->M_emedrec->data_nipeg_by_id($nipeg)->row() : "";
            // var_dump($data['nipeg_dokter']);
            // $data['hasil_pemeriksaan_radiologi']= $this->M_emedrec->getdata_hasil_pemeriksaan_radiologi($no_reg)->result();
            $data['hasil_pemeriksaan_lab'] =  isset($no_reg) ? $this->M_emedrec->get_data_laboratorium_by_noreg($no_reg)->result() : "";
            // var_dump($data['hasil_pemeriksaan_lab']);
            $data['kode_document'] = '';
            $this->load->view('emedrec/rj/formlaboratorium/cetak_laboratorium', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_elektromedik($noipd = '', $no_medrec = '', $no_cm = '')
    {
        // $cm=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        // $no_reg=$this->input->post('user_id');
        $cm = $no_cm != "" ? $no_cm : $this->input->post('no_cm');
        $medrec = $no_medrec != "" ? $no_medrec : $this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');

        $null = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_reg);
        if ($null != null) {
            date_default_timezone_set("Asia/Jakarta");
            $data['tgl_jam'] = date("d-m-Y H:i:s");
            $data['tgl'] = date("d F Y");
            $data['no_register'] = $no_reg;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['pemeriksaan_elektromedik'] = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_reg);
            $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();

            $nama_dokter_reffering = $this->M_emedrec->get_nama_dokter($data['data_daftar_ulang']->id_dokter)->row()->nm_dokter;
            $data['nama_dokter_reffering'] = $nama_dokter_reffering;
            $nipeg_dok = isset($data['data_daftar_ulang']->id_dokter) ? $data['data_daftar_ulang']->id_dokter : '';
            $data['nipeg_dokter'] = isset($nipeg_dok) ? $this->M_emedrec->data_nipeg_by_id($nipeg_dok)->row() : "";
            // var_dump($data['nipeg_dokter']);
            $nama_poli = $this->M_emedrec->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;
            $data['nama_poli'] = $nama_poli;

            if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
                $data['kontraktor'] = 'BPJS';
            } elseif ($data['data_daftar_ulang']->cara_bayar == 'UMUM') {
                $data['kontraktor'] = '';
            } else {
                // var_dump($data['data_daftar_ulang']->id_kontraktor);die();
                $nama_kontraktor = isset($data['data_daftar_ulang']->id_kontraktor) ? $this->M_emedrec->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row() : '';
                $data['kontraktor'] = isset($nama_kontraktor->nmkontraktor) ? $nama_kontraktor->nmkontraktor : '';
            }

            if ($data['data_daftar_ulang']->diagnosa == null) {
                $data['diagnosa'] = '';
            } else {
                $nama_diagnosa = $this->M_emedrec->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;
                $data['diagnosa'] = $nama_diagnosa;
            }


            $this->load->view('emedrec/rj/formelektromedik/cetak_elektromedik', $data);
        } else {
            $success =     '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3>Tidak Bisa Melihat Elektromedik.Dikarenakan Belum Ada Pemeriksaan
								</div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    // public function btn_elektromedik()
    // {
    //     $no_reg = $this->input->post('no_register');
    //     $result = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_reg);
    //     if ($result == null) {
    //         $data['status'] = 'error';
    //         echo json_encode('error');    
    //     }else{
    //         $data['status'] = 'success';
    //         echo json_encode('success');
    //     }

    // }

    public function cetak_lembar_konsultasi()
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/lembar_konsultasi', $data);
    }

    public function cetak_cppt_rawat_jalan_by_noreg($noipd = "", $nocm = "", $nomedrec = "", $rd = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        $id_poli = $this->input->post('id_poli');
        $fisio = $id_poli == 'BK07' ? 1 : 0;
        $data_cppt = ($no_reg) ? $fisio ? $this->M_emedrec->get_data_cppt_by_noreg_fisio($no_reg)->result() : $this->M_emedrec->get_data_cppt_by_noreg($no_reg)->result() : null;

        if ($data_cppt != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cppt')->row();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data_semuanya = $data_cppt;
            $no_sip = isset($data_semuanya[0]->id_dokter) ? $data_semuanya[0]->id_dokter : '';
            $data['sip_dokter'] = ($no_sip) ? $this->M_emedrec->data_nipeg_by_id($no_sip)->row() : null;
            $data['get_data_cppt'] = $data_semuanya;
            $data['rd'] = $rd;
            $data['data_pasien'] = ($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
            $fisio ? $this->load->view('emedrec/rj/cppt_rawat_jalan_fisio', $data) : $this->load->view('emedrec/rj/cppt_rawat_jalan', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_cppt_by_medrec_poli($no_medrec = '', $idpoli = '')
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $id_poli = $this->input->post('id_poli');
        $fisio = $id_poli == 'BK07' ? 1 : 0;
        $no_register = $this->M_emedrec->get_noreg_by_medrec_poli($no_medrec, $idpoli)->result_array();
        //var_dump($no_register); die();
        $data_cppt = ($no_register) ? $fisio ? $this->M_emedrec->get_data_cppt_by_noreg_fisio($no_register)->result() : $this->M_emedrec->get_data_cppt_by_noreg($no_register)->result() : null;
        var_dump($data_cppt);
        die();
        if ($data_cppt != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kode_document'] = $this->M_emedrec->get_kode_document('cppt');
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data_semuanya = $data_cppt;
            $no_sip = isset($data_semuanya[0]->id_dokter) ? $data_semuanya[0]->id_dokter : '';
            $data['sip_dokter'] = ($no_sip) ? $this->M_emedrec->data_nipeg_by_id($no_sip)->row() : null;
            //  var_dump($data['sip_dokter']);
            $data['get_data_cppt'] = $data_semuanya;
            // var_dump($data['get_data_cppt']);
            //$data['rd'] = $rd;

            $data['data_pasien'] = ($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
            $fisio ? $this->load->view('emedrec/rj/cppt_rawat_jalan_fisio_by_poli', $data) : $this->load->view('emedrec/rj/cppt_rawat_jalan_by_poli', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_diagnosa_noreg($no_reg = '', $nocm = '')
    {
        if ($no_reg != '') {
            $noreg = $no_reg;
        } else {
            $noreg = $this->input->post('user_id');
        }
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        // $no_reg=$this->input->post('user_id');
        $data_sbpk = $noreg ? $this->M_emedrec->get_pemeriksaan_fisik($noreg) : '';

        if ($data_sbpk != null) {

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $cm ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
            $data_all_diag = $noreg ? $this->M_emedrec->getdata_record_pasien_by_no_reg($noreg)->result() : null;
            $no_sip_dokter = isset($data_all_diag[0]->id_dokter) ? $data_all_diag[0]->id_dokter : '';
            $data['sip_dokter'] = $no_sip_dokter ? $this->M_emedrec->data_nipeg_by_id($no_sip_dokter)->row() : null;
            // var_dump($data['sip_dokter']);
            $data['data_rawat_jalan'] = $data_all_diag;
            $data['data_rawat_jalan_new'] = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg ?? "")->result() : "";
            $data['object_dokter'] = $noreg ? $this->M_emedrec->get_object_dokter($noreg) : '';
            $data['pemeriksaan_fisik'] = $noreg ? $this->M_emedrec->get_pemeriksaan_fisik($noreg) : '';
            $data['keperawatan'] = $noreg ? $this->M_emedrec->get_data_asesmen_keperawatan_ird($noreg)->result() : '';
            $data['diagnosa_pasien'] = $noreg ? $this->M_emedrec->get_diagnosa_pasien_by_noreg($noreg) : null;
            $data['icd9cm_irj'] = $noreg ? $this->M_emedrec->get_icd9cmirj_by_noreg($noreg) : null;
            $this->load->view('emedrec/rj/formdiagnosa/surat_bukti_pelayanan', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function sbpk()
    {
        $date = $this->input->post('date_days');
        $id_poli = explode("@", $this->input->post('poli'));
        $data_sbpk = $this->M_emedrec->get_pemeriksaan_fisik_poli($date, $id_poli[0])->result();

        if ($data_sbpk != null) {
            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['data_sbpk'] = $data_sbpk;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            // $data['data_pasien'] = $cm ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : null;
            // $data_all_diag = $noreg ? $this->M_emedrec->getdata_record_pasien_by_no_reg($noreg)->result() : null;
            // $no_sip_dokter = isset($data_all_diag[0]->id_dokter) ? $data_all_diag[0]->id_dokter : '';
            // $data['sip_dokter'] = $no_sip_dokter ? $this->M_emedrec->data_nipeg_by_id($no_sip_dokter)->row() : null;
            // $data['data_rawat_jalan'] = $data_all_diag;
            // $data['object_dokter'] = $noreg ? $this->M_emedrec->get_object_dokter($noreg) : '';
            // $data['pemeriksaan_fisik'] = $noreg ? $this->M_emedrec->get_pemeriksaan_fisik($noreg) : '';
            // $data['keperawatan'] = $noreg ? $this->M_emedrec->get_data_asesmen_keperawatan_ird($noreg)->result() : '';
            // $data['diagnosa_pasien'] = $noreg ? $this->M_emedrec->get_diagnosa_pasien_by_noreg($noreg) : null;
            // $data['icd9cm_irj'] = $noreg ? $this->M_emedrec->get_icd9cmirj_by_noreg($noreg) : null;
            $this->load->view('emedrec/rj/formdiagnosa/sbpk', $data);
        } else {
            $success = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/sbpk_poli');
        }
    }

    public function sbpk_poli()
    {
        $data['title'] = 'Cetak Surat Bukti Pelayanan Kesehatan (SBPK) Per Poli';
        $data['poli'] = $this->M_emedrec->get_poli()->result();
        $this->load->view('emedrec/sbpk_perpoli', $data);
    }

    public function cetak_Eresep()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');

        $data_eresep = isset($no_reg) ? $this->M_emedrec->get_resep_pasien_by_noreg($no_reg)->result() : '';

        // if($data_eresep != null){

        $conf = $this->appconfig->get_headerpdf_appconfig()->result();
        $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
        $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : ''; //data model ngaco
        $data['pemeriksaan_fisik'] = isset($no_reg) ? $this->M_emedrec->get_alergi_pemeriksaan_fisik_by_noreg($no_reg)->result() : "";
        $data['telaah_obat'] = isset($no_reg) ? $this->M_emedrec->get_telaah_obat_by_no_reg($no_reg)->result() : '';
        $data_resep = isset($no_reg) ? $this->M_emedrec->get_resep_pasien_by_noreg($no_reg)->result() : '';
        $no_sip_dokter = isset($data_resep[0]->id_dokter) ? $data_resep[0]->id_dokter : '';
        if ($no_sip_dokter != '') {

            $data['sip_dokter'] = isset($no_sip_dokter) ? $this->M_emedrec->data_nipeg_by_id($no_sip_dokter)->row() : '';
        } else {

            $data['sip_dokter'] = '';
        }
        // var_dump($no_sip_dokter);die();
        // $data['sip_dokter'] = isset($no_sip_dokter) ?$this->M_emedrec->data_nipeg_by_id($no_sip_dokter)->row() : '';
        // var_dump($data['sip_dokter']);
        $data['resep_pasien'] = $data_resep;
        $data['data_tindakan_racik'] = isset($no_reg) ? $this->Frmmdaftar->getdata_resep_racik($no_reg)->result() : '';
        $data['kode_document'] = '';


        $this->load->view('emedrec/rj/formEresep/telaah_resep_rawat_jalan', $data);

        // }else{

        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);

        // }

    }

    public function cetak_Eresep_telaah($nocm = '', $reg = '')
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $no_reg = $reg != "" ? $reg : $this->input->post('user_id');

        $conf = $this->appconfig->get_headerpdf_appconfig()->result();
        $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
        $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        //  var_dump($cm);die();
        $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row() : ''; //data model ngaco
        if (substr($no_reg, 0, 2) == 'PL') {
            $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm_luar($cm)->row() : ''; //data model ngaco
        }
        $data['pemeriksaan_fisik'] = isset($no_reg) ? $this->M_emedrec->get_alergi_pemeriksaan_fisik_by_noreg($no_reg)->result() : "";
        $data['telaah_obat'] = isset($no_reg) ? $this->M_emedrec->get_telaah_obat_by_no_reg($no_reg)->result() : '';
        $data['resep_pasien'] = isset($no_reg) ? $this->M_emedrec->get_resep_pasien_by_noreg_telaah($no_reg)->result() : '';
        $data['data_tindakan_racik'] = isset($no_reg) ? $this->M_emedrec->getdata_resep_racik($no_reg)->result() : '';
        $data['nama_form'] = 'RESEP';
        // $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
        // $mpdf->curlAllowUnsafeSslRequests = true;		
        // $html = $this->load->view('emedrec/rj/formEresep/telaah_resep_rawat_jalan',$data,true);
        // //$this->mpdf->AddPage('L'); 
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        $this->load->view('emedrec/rj/formEresep/telaah_resep_rawat_jalan', $data);
    }

    public function surat_konsul_old()
    {
        $no_register = $this->input->post('user_id');

        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');


        $conf = $this->appconfig->get_headerpdf_appconfig()->result();
        $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
        $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $no_cm = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
        $no_regis_lama = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;

        if ($no_regis_lama == null) {
            $success =     '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3>Tidak Bisa Melihat Konsul Dokter.Dikarenakan Belum Konsul
								</div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        } else {
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_medrec($cm)->result();
            $data['data_konsul'] = $this->M_emedrec->get_data_konsul_by_noreg($no_regis_lama)->row();
            // $data['data_jawab'] = $this->M_emedrec->get_data_jawab_konsul_by_noreg($no_regis_lama)->row();

            $id_dokter_asal = $this->M_emedrec->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_asal;
            $id_dokter_akhir = $this->M_emedrec->get_data_konsul_by_noreg($no_regis_lama)->row()->id_dokter_akhir;
            $id_poli_asal = $this->M_emedrec->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_asal;
            $id_poli_akhir = $this->M_emedrec->get_data_konsul_by_noreg($no_regis_lama)->row()->id_poli_akhir;

            $data['dokter_asal'] = $this->M_emedrec->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;

            $data['poli_asal'] = $this->M_emedrec->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
            $data['dokter_akhir'] = $this->M_emedrec->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
            $data['poli_akhir'] = $this->M_emedrec->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;
            $data['konsul_dokter'] = 'konsul';
            $this->load->view('rj/formkonsul/LEMBAR_KONSUL', $data);
        }
    }
    public function surat_konsul($noregis = '', $nocm = "", $nomedrec = "")
    {
        $no_register = $noregis != "" ? $noregis : $this->input->post('user_id');

        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_konsultasi = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row();

        if ($data_konsultasi != null) {

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            // $logo_kesehatan_header=
            // var_dump($data['logo_header']);die();
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            // var_dump($data['data_kontrol']);
            $no_cm = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
            $no_regis_lama = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
            $data['data_pasien'] = $this->rjmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();


            // $id_dokter_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_asal;
            // $id_dokter_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_akhir;
            // $id_poli_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_asal;
            // $id_poli_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_akhir;

            // $data['dokter_asal'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;
            // $data['poli_asal'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
            // $data['dokter_akhir'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
            // $data['poli_akhir'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;
            // $data['konsul_dokter'] = 'konsul';

            $data['data_konsul'] = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row();
            $this->load->view('rj/formkonsul/LEMBAR_KONSUL', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function surat_konsul_by_reg($noregis = '', $nocm = "", $nomedrec = "")
    {
        $no_register = $noregis != "" ? $noregis : $this->input->post('user_id');

        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        // var_dump($no_register);
        // var_dump($cm);
        // var_dump($medrec);
        // die();
        $data_konsultasi = $this->rjmpelayanan->get_data_konsul_by_reg($no_register)->result();
        // var_dump($data_konsultasi);die();

        if ($data_konsultasi != null) {

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            // echo $top_header;die();
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            // $logo_kesehatan_header=
            // var_dump($data['logo_header']);die();
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            // var_dump($data['data_kontrol']);
            $no_cm = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
            $no_regis_lama = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
            $data['data_pasien'] = $this->rjmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();


            // $id_dokter_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_asal;
            // $id_dokter_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_akhir;
            // $id_poli_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_asal;
            // $id_poli_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_akhir;

            // $data['dokter_asal'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;
            // $data['poli_asal'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
            // $data['dokter_akhir'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
            // $data['poli_akhir'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;
            // $data['konsul_dokter'] = 'konsul';
            $data['data_rehab_medik'] = $this->rjmpelayanan->get_data_konsul_by_reg_rehab($no_register)->row();
            $data['data_konsul'] = $this->rjmpelayanan->get_data_konsul_by_reg($no_register)->result();
            $this->load->view('rj/formkonsul/lembar_konsul_by_reg', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function surat_konsul_all($noregis = '', $nocm = "", $nomedrec = "")
    {
        $no_register = $noregis != "" ? $noregis : $this->input->post('user_id');

        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        // var_dump($no_register);
        // var_dump($cm);
        // var_dump($medrec);
        // die();
        $data_konsultasi = $this->rjmpelayanan->get_data_konsul_by_medrec($medrec)->result();
        // var_dump($data_konsultasi);die();

        if ($data_konsultasi != null) {

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            // echo $top_header;die();
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            // $logo_kesehatan_header=
            // var_dump($data['logo_header']);die();
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            // var_dump($data['data_kontrol']);
            $no_cm = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_medrec;
            $no_regis_lama = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
            $data['data_pasien'] = $this->rjmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();


            // $id_dokter_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_asal;
            // $id_dokter_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_dokter_akhir;
            // $id_poli_asal = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_asal;
            // $id_poli_akhir = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row()->id_poli_akhir;

            // $data['dokter_asal'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_asal)->row()->nm_dokter;
            // $data['poli_asal'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_asal)->row()->nm_poli;
            // $data['dokter_akhir'] = $this->rjmpelayanan->get_data_dokter_by_konsul($id_dokter_akhir)->row()->nm_dokter;
            // $data['poli_akhir'] = $this->rjmpelayanan->get_data_poli_by_konsul($id_poli_akhir)->row()->nm_poli;
            // $data['konsul_dokter'] = 'konsul';
            $data['data_rehab_medik'] = $this->rjmpelayanan->get_data_konsul_by_medrec_rehab($medrec)->row();
            $data['data_konsul'] = $this->rjmpelayanan->get_data_konsul_by_medrec($medrec)->result();
            $this->load->view('rj/formkonsul/lembar_konsul_all', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function konsul_dokter_iGD($noreg = "", $nocm = "", $nomedrec = "")
    {

        $noreg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec = "" ? $nomedrec : $this->input->post('no_medrec');
        // 
        //$medrec=$this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($cm);
        $data['dokter_iri'] = $noreg != "" ? $this->M_emedrec_iri->get_dokter_for_konsul_igd($noreg)->row() : null;
        $cek_konsul_iri = $noreg != "" ? $this->M_emedrec_iri->get_konsul_igd($data['dokter_iri']->no_ipd)->result() : null;

        if (!empty($cek_konsul_iri)) {
            $data['no_cm'] = $nocm != "" ? $nocm : $this->input->post('no_cm');
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['kode_document'] = $this->M_emedrec->get_kode_document('konsul_iri');
            $data['konsul_dokter_ird'] = $noreg != "" ? $this->M_emedrec_iri->get_konsul_igd($data['dokter_iri']->no_ipd)->result() : null;
            // var_dump($data['kode_document']);die();
            $this->load->view('rd/konsuligd', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function assesment_medik_ird($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_medik_ird = $this->M_emedrec->get_data_assesment_medik_ird($no_reg)->result();

        if ($data_medik_ird != null) {

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $kota_header = $this->appconfig->get_kota_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_igd')->row();
            $data['no_register'] = $no_reg;
            $data_ird = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
            $data['rawat_jalan'] = $data_ird;
            $nip = $data_ird[0]->id_dokter;
            $data['nip_dokter'] = isset($nip) ? $this->M_emedrec->data_nipeg_by_id($nip)->row() : '';
            $data['soap_pasien_rj'] = isset($no_reg) ? $this->M_emedrec->get_soap_pasien_rj_no_reg($no_reg)->row() : "";
            $data['assesment_medik_ird'] = $data_medik_ird;
            $data['diagnosa_kerja'] = $this->M_emedrec->get_diagnosa_kerja($no_reg)->result();
            $data['penunjang'] = $this->M_emedrec->get_penunjang_igd($no_reg)->result();
            $data['keperawatan'] = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_reg)->result();

            $this->load->view('emedrec/rd/assesment_medik/assesmentmedik', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_asesmen_awal_keperawatan_ird($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_keperawatan_ird = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_reg)->result();

        if ($data_keperawatan_ird != null) {

            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_igd')->row();
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
            $test = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_reg)->result();
            if ($test == null) {
                $data['keperawatan'] = array(
                    'no_register' => '-',
                    'tgl' => '-',
                    'form_json' => '-',
                    'tgl_assesment' => '-',
                    'id_pemeriksaa' => '-',
                );
                $data['pemeriksa'] = new \stdClass();
                $data['pemeriksa']->ttd = '-';
            } else {
                $data['keperawatan'] = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_reg)->result();
                $data['pemeriksa'] = $this->M_emedrec->get_data_ttd($data['keperawatan'][0]->id_pemeriksa)->row();
            }


            // var_dump($data['keperawatan']);
            // die();

            $data['pemeriksaan_fisik'] = $this->M_emedrec->get_pemeriksaan_fisik($no_reg);
            $data['soap_pasien_rj'] = isset($no_reg) ? $this->M_emedrec->get_soap_pasien_rj_no_reg($no_reg)->row() : "";
            $data['tindakan_resep_pasien_ird'] = $this->M_emedrec->get_tindakan_resep_pasien_ird($no_reg)->result();
            $this->load->view('emedrec/rd/formassesmentkeperawatan/assesment_keperawatan', $data);
        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_triase_ird($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_triase_ird = $this->M_emedrec->get_data_triase_ird_by_noreg($no_reg)->result();

        if ($data_triase_ird != null) {

            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('triase')->row();
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
            $data['triase'] = $data_triase_ird;
            $sip_dokter =  isset($data_triase_ird[0]->name) ? $data_triase_ird[0]->name : '';
            // var_dump($sip_dokter);die();
            $data['sip_dokter'] = $sip_dokter != "" ? $this->M_emedrec->data_nipeg_by_nama($sip_dokter)->row() : '';
            $this->load->view('emedrec/rd/formtriase/formtriase', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function testing_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'No MR');
        $sheet->setCellValue('D1', 'Umur');
        $sheet->setCellValue('E1', 'Jenis Kelamin');
        $sheet->setCellValue('F1', 'Jaminan');
        $sheet->setCellValue('G1', 'Alamat');
        $sheet->setCellValue('H1', 'Diagnosa');
        $sheet->setCellValue('I1', 'ICD-10');
        $sheet->setCellValue('J1', 'Kasus');
        $sheet->setCellValue('K1', 'Poli');
        $sheet->setCellValue('L1', 'Dokter');
        $sheet->setCellValue('M1', 'Waktu Daftar Ulang');
        $sheet->setCellValue('N1', 'Waktu Tindak Perawat');
        $sheet->setCellValue('O1', 'Waktu Tindak Dokter');
        $sheet->setCellValue('P1', 'Waktu Pulang');
        $sheet->setCellValue('Q1', 'Selisih Dokter Perawat');
        $sheet->setCellValue('R1', 'Lama Tunggu');
        $sheet->setCellValue('S1', 'No Register');
        $sheet->setCellValue('T1', 'Keterangan');

        $data = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"), 'SEMUA', '')->result();

        $tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"), 'SEMUA', '')->row()->tgl_lahir;
        $tahun_tgl_lahir = substr($tgl_lahir, 0, 4);
        $tahun_sekarang = date('Y');
        $pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
        $tgl_lahir = $pengurangan;



        $no = 1;
        $x = 2;
        foreach ($data as $row) {
            $car = $row->cara_bayar;

            if ($car == 'BPJS') {
                $car_bar = $row->kontraktor;
            } else if ($row->cara_bayar == 'KERJASAMA') {
                $car_bar = $row->kontraktor;
            } else {
                $car_bar = $row->cara_bayar;
            }

            if ($row->waktu_masuk_poli == null) {
                $waktu_mapol = '';
            } else {
                $waktu_mapol = date('H:i:s', strtotime($row->waktu_masuk_poli));
            }

            if ($row->waktu_masuk_dokter == null) {
                $waktu_madok = '';
            } else {
                $waktu_madok = date('H:i:s', strtotime($row->waktu_masuk_dokter));
            }

            if ($row->waktu_pulang == null) {
                $waktu_mapul = '';
            } else {
                $waktu_mapul = date('H:i:s', strtotime($row->waktu_pulang));
            }

            $nm_poli = $this->Rjmlaporan->get_nm_poli($row->id_poli)->row()->nm_poli;

            if ($row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null) {
                $waktu_masuk_poli = date_create($row->waktu_masuk_poli);
                $waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);
                $diff = date_diff($waktu_masuk_dokter, $waktu_masuk_poli);
                $selisih_dokper = date('H:i:s', strtotime($diff->h . ':' . $diff->i . ':' . $diff->s));
            } else {
                $selisih_dokper = '';
            }

            $detik = 0;
            $menit = 0;
            $jam = 0;
            $jam_array = array();
            if ($row->tgl_kunjungan != null && $row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null) {

                $waktu_masuk = date_create($row->tgl_kunjungan);
                $waktu_masuk_poli = date_create($row->waktu_masuk_poli);
                $waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);

                $diff1 = date_diff($waktu_masuk_poli, $waktu_masuk);
                $diff2 = date_diff($waktu_masuk_dokter, $waktu_masuk_poli);

                $waktu_awal = date_create(date('H:i:s', strtotime($diff1->h . ':' . $diff1->i . ':' . $diff1->s)));
                $waktu_akhir = date_create(date('H:i:s', strtotime($diff2->h . ':' . $diff2->i . ':' . $diff2->s)));

                $last_diff = date_diff($waktu_akhir, $waktu_awal);
                $lama_tunggu =  date('H:i:s', strtotime($last_diff->h . ':' . $last_diff->i . ':' . $last_diff->s));
            } else {
                $lama_tunggu =  '';
            }

            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, strtoupper($row->nama));
            $sheet->setCellValue('C' . $x, $row->no_cm);
            $sheet->setCellValue('D' . $x, $tgl_lahir);
            $sheet->setCellValue('E' . $x, $row->sex);
            $sheet->setCellValue('F' . $x, $car_bar);
            $sheet->setCellValue('G' . $x, $row->kotakabupaten);
            $sheet->setCellValue('H' . $x, $row->nm_diagnosa);
            $sheet->setCellValue('I' . $x, $row->id_diagnosa);
            $sheet->setCellValue('J' . $x, $row->jns_kunj);
            $sheet->setCellValue('K' . $x, $nm_poli);
            $sheet->setCellValue('L' . $x, $row->nm_dokter);
            $sheet->setCellValue('M' . $x, date('H:i:s', strtotime($row->tgl_kunjungan)));
            $sheet->setCellValue('N' . $x, $waktu_mapol);
            $sheet->setCellValue('O' . $x, $waktu_madok);
            $sheet->setCellValue('P' . $x, $waktu_mapul);
            $sheet->setCellValue('Q' . $x, $selisih_dokper);
            $sheet->setCellValue('R' . $x, $lama_tunggu);
            $sheet->setCellValue('S' . $x, $row->no_register);
            $sheet->setCellValue('T' . $x, str_replace('_', ' ', $row->ket_pulang));
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'testing_excel';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // pointmedika
    public function cetak_cppt_rawat_jalan_pm($no_cm = '')
    {
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_pm($no_cm); // pointmedika -> tb_rekam_medis_cppt
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($no_cm)->result();
        // $data['kode_document'] = $this->M_emedrec->get_kode_document('cppt');
        $this->load->view('emedrec/rj/cppt_rawat_jalan', $data);
    }

    public function cetak_formulir_transfer_antar_ruangan($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $ipd = $this->M_emedrec->get_noipd($no_reg)->row();
        $no_ipd = isset($ipd->no_ipd) ? $ipd->no_ipd : $no_reg;
        // $no_ipd = $no_reg;
        //  var_dump($no_ipd);die();
        $transfer_ruangan = $this->M_emedrec->get_formulir_transfer_ruangan2($no_ipd)->result();

        if ($transfer_ruangan != null) {


            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_reg)->row();
            // var_dump($data['dokter_ruangan']);die();
            $data['transfer_ruangan'] = $transfer_ruangan;
            $this->load->view('emedrec/rd/form_antar_ruangan/antar_ruangan', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_serah_terima_asuhan_pasien($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_serah_terima = $this->M_emedrec->get_serah_terima($no_reg)->result();

        if ($data_serah_terima != null) {


            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
            $data['pasien_iri'] = $this->M_emedrec->get_data_pasien_iri_bynoregasal($no_reg)->result();
            $data['serah_terima'] = $data_serah_terima;
            $this->load->view('emedrec/rd/formserahterima/serah_terima', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function assesment_awal_kebidanan()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data['kode_document'] = $this->M_emedrec->get_kode_document('');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $this->load->view('emedrec/rj/formkebidanan/kebidanan', $data);
    }

    public function penilaian_fungsional($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rd/penilaian_fungsional/penilaian_fungsional', $data);
    }

    public function evaluasi_antibiotik($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rj/evaluasi_antibiotik/evaluasi_antibiotik', $data);
    }

    public function assesment_keperawatan_geriatri_rawat_inap($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/ri/assesment_keperawatan_geriatri_rawat_inap/assesment_keperawatan_geriatri_rawat_inap', $data);
    }
    public function formulir_patologi_klinik($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/ri/formulir_patologi_klinik/formulir_patologi_klinik', $data);
    }
    public function surat_pernyataan_titip($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/ri/surat_pernyataan_titip/surat_pernyataan_titip', $data);
    }
    public function formulir_edukasi_penolakan_rencana_asuhan($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rj/formulir_edukasi_penolakan_rencana_asuhan/formulir_edukasi_penolakan_rencana_asuhan', $data);
    }
    public function asesmen_pasien_terminal($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/ri/asesmen_pasien_terminal/asesmen_pasien_terminal', $data);
    }

    public function rehab_medik_fisio()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_pasien']);
        $this->load->view('emedrec/rj/assesment_fisio/rehab_fisio', $data);
    }

    public function lembar_assesment()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rj/lembar_assesment/lembar_assesment', $data);
    }

    public function ews_dewasa($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['kode_document'] = $this->M_emedrec->get_kode_document('observasi_ews');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['ews_dewasa'] = $this->M_emedrec->get_pemeriksaan_fisik_by_noreg($no_reg)->row();
        // $ttd_user = $data['asuhan_gizi']->xuser;
        // $data['ttd_user'] = $this->M_emedrec_iri->get_ttd_gizi($ttd_user)->row();
        //  var_dump( $data['ttd_user']);

        // $data['assesment_awal_keperawatan'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);
        //  $data['kode_document'] = 'Rev.03.02.2020.RM-006g / RI';
        $this->load->view('rd/ews_dewasa/ews_dewasa', $data);
    }

    public function skrining_triase_covid($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['skrining_covid'] = $this->M_emedrec->check_skrining_covid($no_reg)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('skrining_triase')->row();
        // $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rd/skrining_triase_covid/skrining_covid', $data);
    }

    public function lembar_program_terapi()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['lap_terapi']=$this->M_emedrec->get_data_lembar_terapi($no_reg)->row();
        // var_dump($data['lap_terapi']);

        $this->load->view('emedrec/rj/lembar_program_terapi/lembar_program_terapi', $data);
    }

    public function pengkajian_awal_rehab_medik($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        $data['rehab_medik'] = $this->M_emedrec_iri->get_pengkajian_rehab_medik($no_reg);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_rehab_medik')->row();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rj/pengkajian_awal_rehab_medik/pengkajian_awal_rehab_medik', $data);
    }

    public function pengkajian_awal_rehab_medik_anak($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $no_reg=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
        $data['rehab_medik'] = $this->M_emedrec_iri->get_pengkajian_rehab_medik($no_reg);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_rehab_medik')->row();
        // var_dump($data['data_fungsional']);
        $this->load->view('emedrec/rj/pengkajian_awal_rehab_medik/pengkajian_rehab_medik_anak', $data);
    }


    public function lembar_formulir_rehabilitasi()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        // $data['formulir_rehab']=$this->M_emedrec->get_data_formulir_rehab($no_reg)->row();
        // var_dump($data['lap_terapi']);

        $this->load->view('emedrec/rj/lembar_formulir_rehabilitasi/lembar_formulir_rehabilitasi', $data);
    }


    public function cetak_surat_elektromedik_all($noipd = "", $nocm = "", $nomedrec = "")
    {
        // $cm=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        // $no_reg=$this->input->post('user_id');
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $no_medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $medrec = (int)$no_medrec;
        $data_all = isset($no_reg) ? $this->M_emedrec->get_asssesment_keperawatan_irj($no_reg)->row() : '';
        //var_dump($no_reg);
        $null = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($medrec);
        if ($null != null) {
            date_default_timezone_set("Asia/Jakarta");
            $data['tgl_jam'] = date("d-m-Y H:i:s");
            $data['tgl'] = date("d F Y");
            $data['no_register'] = $no_reg;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($medrec)->row();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['pemeriksaan_elektromedik'] = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($medrec);
            $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
            // var_dump($data['data_daftar_ulang']);
            // die();
            $dr = $data['data_daftar_ulang']->id_dokter;
            $nama_dokter_reffering = $this->M_emedrec->get_nama_dokter($dr)->row()->nm_dokter;
            $data['nama_dokter_reffering'] = $nama_dokter_reffering;
            $nipeg_dok = isset($data['data_daftar_ulang']->id_dokter) ? $data['data_daftar_ulang']->id_dokter : '';
            $data['nipeg_dokter'] = isset($nipeg_dok) ? $this->M_emedrec->data_nipeg_by_id($nipeg_dok)->row() : "";
            // var_dump($data['nipeg_dokter']);
            $nama_poli = $this->M_emedrec->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;
            $data['nama_poli'] = $nama_poli;

            if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
                $data['kontraktor'] = 'BPJS';
            } elseif ($data['data_daftar_ulang']->cara_bayar == 'UMUM') {
                $data['kontraktor'] = '';
            } else {
                $nama_kontraktor = isset($data['data_daftar_ulang']->id_kontraktor) ? $this->M_emedrec->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row() : '';
                $data['kontraktor'] = isset($nama_kontraktor->nmkontraktor) ? $nama_kontraktor->nmkontraktor : '';
            }

            if ($data['data_daftar_ulang']->diagnosa == null) {
                $data['diagnosa'] = '';
            } else {
                $nama_diagnosa = $this->M_emedrec->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;
                $data['diagnosa'] = $nama_diagnosa;
            }


            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rj/formelektromedik/cetak_elektromedik_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('emedrec/rj/formelektromedik/cetak_elektromedik_all', $data);    
        } else {
            $success =     '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3>Tidak Bisa Melihat Elektromedik.Dikarenakan Belum Ada Pemeriksaan
								</div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_radiologi_all($medrec = '',$no_cm = '')
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $no_medrec = $this->input->post('no_medrec');

        // $medrec = (int)$no_medrec;
        $data_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_history_radiologi_all($medrec)->result();
// var_dump($no_cm);die();
        // if ($data_rad != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $no_cm ? $this->M_emedrec->get_data_pasien_by_no_cm($no_cm)->row() : "";
            $data['data_pasien_rad'] = $this->M_emedrec->get_data_rad($no_reg)->row();
            $data_umum_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_history_radiologi_all($medrec)->result();
            $data['hasil_pemeriksaan_radiologi'] = $data_umum_rad;
            $dokter_sip = isset($data_umum_rad[0]->id_dokter) ? $data_umum_rad[0]->id_dokter : '';
            $data['nipeg_dokter'] = $dokter_sip ? $this->M_emedrec->data_nipeg_by_id($dokter_sip)->row() : "";
            // var_dump($data['nipeg_dokter']);
            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rj/formradiologi/cetak_radiologi_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('emedrec/rj/formradiologi/cetak_radiologi', $data);

        // } else {


        //     $success =     '<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak ada pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        // }
    }

    public function cetak_surat_laboratorium_all()
    {
        $cm = $this->input->post('no_cm');
        $no_reg = $this->input->post('user_id');
        $medrec = $this->input->post('no_medrec');

        // die();
        $data_lab =  $this->M_emedrec->get_noreg_pemeriksaan_lab($medrec)->result();

        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['tgl'] = date("d-m-Y");
            $data['data_pasien'] = isset($cm) ? $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result() : "";
            $data_umum = isset($no_reg) ? $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result() : "";
            $data['data_rawat_jalan'] = $data_umum;
            $nipeg = isset($data_umum[0]->id_dokter) ? $data_umum[0]->id_dokter : '';
            $data['nipeg_dokter'] = isset($nipeg) ? $this->M_emedrec->data_nipeg_by_id($nipeg)->row() : "";
            // var_dump($data['nipeg_dokter']);
            // $data['hasil_pemeriksaan_radiologi']= $this->M_emedrec->getdata_hasil_pemeriksaan_radiologi($no_reg)->result();
            $data['medrec'] = $this->M_emedrec->get_noreg_pemeriksaan_lab($medrec)->result();

            $data['get_umur'] = $this->rjmregistrasi->get_umur($medrec)->result(); #
            // foreach($data['get_umur'] as $row)
            // {
            //     $data['tahun']=$row->umurday;  
            // }
            $data['usia'] = date_diff(date_create($data['data_pasien'][0]->tgl_lahir), date_create('now'));
            // var_dump($data['get_umur']);
            // foreach($get_no_reg as $row){
            $data['hasil_pemeriksaan_lab'] = $this->M_emedrec->get_data_laboratorium_by_noreg($no_reg)->result();
            // var_dump($data['hasil_pemeriksaan_lab']);
            // }
            // die();
            // var_dump($data['hasil_pemeriksaan_lab']);
            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rj/formlaboratorium/cetak_laboratorium_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('emedrec/rj/formlaboratorium/cetak_laboratorium', $data);

        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_history_laboratorium_all($no_medrec = '')
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $no_ipd = $this->input->post('user_id');
       

        $data_lab =  $this->labmdaftar->get_noreg_pemeriksaan_lab($no_medrec)->result();
        // 
        $cm = $this->M_emedrec->get_no_cm_by_medrec($no_medrec)->row()->no_cm;
        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['tgl'] = date("d-m-Y");
            $data['pasien'] = $this->labmdaftar->get_data_pasien_lab($no_medrec)->row();
            //$data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
            $data['no_register'] = $this->labmdaftar->get_no_register_by_medrec($no_medrec)->result();
            $data['medrec'] = $this->labmdaftar->get_noreg_pemeriksaan_lab($no_medrec)->result();
            // var_dump( $data['medrec']);die();
            $data['register'] = $this->labmdaftar->get_nolab_pemeriksaan_lab($no_medrec)->result();
            $no_lab = '';
            foreach ($data['register'] as $r) {
                $no_lab = $r->no_lab;
            }
            foreach ($data['no_register'] as $row) {
                $no_register = $row->no_register;
            }
            $data['get_umur'] = $this->labmdaftar->get_umur($no_medrec)->result(); #
            foreach ($data['get_umur'] as $row) {
                $data['tahun'] = $row->umurday;
            }
            $data['usia'] = date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
            //$data['usia']=date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
            // $data['hasil_pemeriksaan_lab'] =  isset($no_ipd) ? $this->labmdaftar->get_data_laboratorium_by_noipd($no_ipd)->result() : "";

            $data['kode_document'] = '';
            $isi = "" . md5($data['pasien']->no_cm) . "" . md5($no_register) . "" . md5($no_lab) . " || Cek Validasi di www.doc.rsomh.co.id";
            $writer = new PngWriter();
            $qrCode = QrCode::create($isi)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(155)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0, 10))
                ->setBackgroundColor(new Color(255, 255, 255));

            // Create generic logo
            // $logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
            //     ->setResizeToWidth(40);

            // Create generic label
            $label = Label::create('')
                ->setTextColor(new Color(255, 0, 0));

            $result = $writer->write($qrCode, $logo, $label);

            // // Directly output the QR code
            // $hasil =  $result->getDataUri();
            // $data['qr'] = $hasil;
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/rd/hasil_lab_all', $data, true);
            ini_set("pcre.backtrack_limit", "5000000");
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('ri/cetak_laboratorium',$data);

        } else {

            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $no_medrec);
        }
    }

    public function cetak_history_radiologi_all($no_medrec = '')
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $noipd = $this->input->post('user_id');
        $cek_rad_iri = $noipd ? $this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result() : "";

        // $data['hasil_pemeriksaan_radiologi']= $noipd?$this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result():"";

        $data_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_history_radiologi_all($no_medrec)->result();

        if ($data_rad != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $no_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_history_radiologi_all($no_medrec)->row()->no_rad;
            $data['pasien'] = $this->labmdaftar->get_data_pasien_cetak_new($no_rad)->row();
            //$data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($noipd)->row();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($noipd)->row();

            $data_umum_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_history_radiologi_all($no_medrec)->result();
            $data['hasil_pemeriksaan_radiologi'] = $data_umum_rad;

            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/hasil_rad_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('ri/cetak_radiologi_iri', $data);

        } else {


            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function geriatri($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['geriatri'] = $this->M_emedrec_iri->get_geriatri($no_reg);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_geriarti')->row();
        $this->load->view('emedrec/rj/geriatri_rj/geriatri_rj', $data);
    }

    public function qrcode()
    {
        $isi = "RI22002134";
        //var_dump($isi); die();
        $qrCode = new QrCode($isi);

        // Save black on white PNG image 100 px wide to filename.png. Colors are RGB arrays.
        $output = new Output\Png();
        $result = $output->output($qrCode, 100, [255, 255, 255], [0, 0, 0]);
        //file_put_contents('assets/images/user_unknown.png', $data);
        // Echo a SVG file, 100 px wide, black on white.
        // Colors can be specified in SVG-compatible formats
        // $output = new Output\Svg();
        // $result = $output->output($qrCode, 100, 'white', 'black');

        // Echo an HTML table
        // $output = new Output\Html();
        // $result = $output->output($qrCode);
        $data['qr'] = $result;
        $this->load->view('emedrec/coba_qr', $data, true);
    }

    public function pdf_qr()
    {
        $qrCode = new QrCode('hello');
        $output = new Output\Svg();
        $result = $output->output($qrCode, 200, 'white', 'black');
        $data['qr'] = $result;
        //$data = (string)$data;
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        //$mpdf->curlAllowUnsafeSslRequests = true;		
        $html = $this->load->view('emedrec/coba_qr', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function endroid_qr()
    {

        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create('Data')
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        //var_dump($qrCode); die();
        // Create generic logo
        $logo = Logo::create(__DIR__ . '/logo.png')
            ->setResizeToWidth(50);

        // Create generic label
        $label = Label::create('Label')
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode, $logo, $label, true);
        //echo $result;
    }

    public function endroid_builder()
    {
        // Compile your QR code
        $qr = QrCode::create('Data');

        // Render to data URI
        $data = $qr->getString();

        // The '@' character is used to indicate that follows an image data stream and not an image file name  
        $pdf->Image('@' . $data);
    }

    public function cetak_list_tindakan($no_register = '')
    {
        $data['list_tindakan_pasien'] = $this->M_emedrec->get_list_tindakan_pasien_by_no_ipd($no_register)->result();
        $data['data_pasien'] = $this->M_emedrec->get_pasien_by_no_ipd($no_register)->row();
        $data['tgl'] = date("Y-m-d");

        //  if($list_tindakan_pasien != null){

        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
        $interval = date_diff(date_create(), date_create($data['data_pasien']->tgl_lahir));
        $thn = $interval->format("%Y Tahun");
        $data['tahun'] = $thn;
        // $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
        // $data['register'] = $data_lab;
        // $list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
        $data['ttd'] = isset($this->M_emedrec->get_ttd_dpjp($data['data_pasien']->id_dokter)->row()->ttd) ? $this->M_emedrec->get_ttd_dpjp($data['data_pasien']->id_dokter)->row()->ttd : null;
        $data['dokter'] = isset($this->M_emedrec->get_ttd_dpjp($data['data_pasien']->id_dokter)->row()->nm_dokter) ? $this->M_emedrec->get_ttd_dpjp($data['data_pasien']->id_dokter)->row()->nm_dokter : null;
        // $data['get_umur']=$this->rjmregistrasi->get_umur($medrec)->result();#
        // foreach($data['get_umur'] as $row)
        // {
        //     $data['tahun']=$row->umurday;
        // }
        // $data['usia']=date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
        // $data['hasil_pemeriksaan_lab'] =  isset($no_ipd)?$this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result():"";

        // $data['kode_document'] = '';

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('emedrec/rj/kartu_tindakan', $data, true);
        // $this->load->view('emedrec/rj/kartu_tindakan', $data);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

   

    public function cetak_identitas_awal($nocm = "")
    {

        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        if (strlen($cm) != 8) {
            $nocm = sprintf("%08d", $nocm);
        }

        

        $cekdata = $this->rjmregistrasi->getdata_identitas_by_no_cm($cm)->result();
        // var_dump($cekdata);die();
        if ($cekdata == null) {
            $data['data_identitas'] = $this->rjmregistrasi->getdata_identitas_by_no_cm($cm)->result();
        } else {
            $data['data_identitas'] = $this->rjmregistrasi->getdata_identitas_by_no_cm($cm)->result();
        }

        $data['data_poli'] = $this->rjmregistrasi->get_daftar_ulang_irj_by_no_cm($cm)->result();
        $data['poliklinik_mana'] = '';
        $data['kekhususan'] = '';
        foreach ($data['data_poli'] as $value1) {
            $data['kekhususan'] = $value1->kekhususan;
            $data['poliklinik_mana'] = $value1->nm_poli;
        }
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pendaftara_pasien_baru_v2')->row();
        // var_dump($data['kode_document']);die();
        $this->load->view('emedrec/rj/formulir_pendaftaran/RM_01', $data);
    }

    public function rasal($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['rasal'] = $this->M_emedrec->get_data_rasal($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rasal')->row();
        $this->load->view('emedrec/rj/rasal/rasal', $data);
    }

    public function raslan($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['raslan'] = $this->M_emedrec->get_data_raslan($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('raslan')->row();
        $this->load->view('emedrec/rj/raslan/raslan', $data);
    }

    public function gyssens($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['gyssens'] = $this->M_emedrec->get_data_gyssens($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('gyssens')->row();
        $this->load->view('emedrec/rj/gyssens/gyssens', $data);
    }

    public function raspatur($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['raspatur'] = $this->M_emedrec->get_data_raspatur($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('raspatur')->row();
        $this->load->view('emedrec/rj/rasparatur/rasparatur', $data);
    }

    public function iadl($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['iadl'] = $this->M_emedrec->get_data_iadl($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('iadl')->row();
        $this->load->view('emedrec/rj/iadl/iadl', $data);
    }

    public function edukasi_penolakan_rencana_asuhan($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['edukasi_penolakan_rencana_asuhan'] = $this->M_emedrec->get_edukasi_penolakan_rencana_asuhan($no_reg)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_penolakan_rencana_asuhan')->row();
        $this->load->view('emedrec/rj/edukasi_penolakan_rencana_asuhan/edukasi_penolakan_rencana_asuhan', $data);
    }

    public function nihss($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('nihss')->row();
        $data['nihss'] = $this->M_emedrec->get_nihss_for_medik($no_reg)->row();
        $this->load->view('emedrec/rd/nihss/nihss', $data);
    }

    public function nihss_irj($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('nihss')->row();
        $data['nihss'] = $this->M_emedrec_iri->get_nihss($no_reg);
        $this->load->view('emedrec/rj/nihss/nihss', $data);
    }

    public function disfagia($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('disfagia')->row();
        $data['disfagia'] = $this->M_emedrec->get_formulir_disfagia($no_reg);
        $this->load->view('emedrec/ri/disfagia/disfagia', $data);
    }

    public function suket_sakit($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_reg = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['suket_sakit'] = $this->M_emedrec_iri->get_suket($no_reg);
        $this->load->view('emedrec/ri/suket_sakit/suket_sakit', $data);
    }

    /**
     * Added Permintaan : 
     * Feat : Pemblokiran akses terhadap pasien yg tidak berkunjung / tidak dalam pengobatan
     * maka akses dibatasi. Acc Ke Tim Rekam Medis
     * @aldi 23/10/2023 1:38 PM
     */
    public function request_medrec()
    {
        header('Content-Type: application/json');
        $no_cm = $this->input->post('no_cm');
        $query = $this->M_emedrec->get_akses_medrec($no_cm, $this->session->userdata('userid'));

        if ($query->num_rows() > 0) {
            echo json_encode([
                'code' => 200,
                'akses' => 1,
                'input' => 0
            ]);
            return;
        }
        $req = $this->M_emedrec->insert_akses_medrec([
            'no_cm' => $no_cm,
            'users' => $this->session->userdata('userid'),
            'tgl_req' => date('Y-m-d H:i:s')
        ]);
        echo json_encode([
            'code' => 200,
            'akses' => 0,
            'input' => 1
        ]);
        return;
    }

    public function permintaan_medrec()
    {
        $data['title'] = 'Permintaan Akses Rekam Medis';
        $this->load->view('approval_medrec', $data);
    }

    public function get_permintaan_medrec()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'result' => $this->M_emedrec->get_permintaan_medrec()->result()
        ]);
    }

    public function acc_permintaan_medrec()
    {
        header('Content-Type: application/json');
        $this->M_emedrec->acc_permintaan_medrec($this->input->post('id'), [
            'users_acc' => $this->session->userdata('userid'),
            'tgl_acc' => date('Y-m-d H:i:s')
        ]);
        echo json_encode([
            'result' => 'OK'
        ]);
    }

    public function sep_irj()
    {
        $data['title'] = 'Input SEP Rawat Jalan';
        $this->load->view('emedrec/rj/list_pasien_sep', $data);
    }

    public function sep_igd()
    {
        $data['title'] = 'Input SEP IGD';
        $this->load->view('emedrec/rd/list_pasien_sep', $data);
    }

    public function get_sep_irj()
    {
        $tglkunjungan = !$this->input->get('tglkunjungan') ? date('Y-m-d') : $this->input->get('tglkunjungan');
        $data = $this->M_emedrec->get_list_empty_sep_pasien($tglkunjungan)->result();
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode(['result' => $data]);
    }

    public function get_sep_igd()
    {
        $tglkunjungan = !$this->input->get('tglkunjungan') ? date('Y-m-d') : $this->input->get('tglkunjungan');
        $data = $this->M_emedrec->get_list_empty_sep_pasien_igd($tglkunjungan)->result();
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode(['result' => $data]);
    }

    public function update_sep()
    {
        header('Content-Type: application/json;charset=utf-8');
        $data = $this->M_emedrec->update_sep($this->input->post('no_register'), $this->input->post('no_sep'));
        echo json_encode(['metadata' => ['code' => $data ? 200 : 400, 'response' => $data ? 'Data Berhasil Diupdate' : 'Data Gagal Diupdate']]);
    }

    // add sjj 2024

    public function cetak_identitas($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rj/formulir_pendaftaran/identitas_pasien', $data);
    }

    //added putri 04-06-2024
    public function surat_keterangan_masuk_igd($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        $data['keluhan'] = $this->M_emedrec->get_pengkajian_medis_igd($no_reg)->row();
        $data['pem_fisik'] = $this->M_emedrec->get_fisik_igd($no_reg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($no_reg)->result();
        $data['pasien_pulang'] = $this->M_emedrec->get_data_medis($no_reg)->row();
        
    

        $this->load->view('emedrec/rd/suket_igd/surat_keterangan_masuk_igd', $data);
    }

    //added putri 04-06-2024
    public function surat_rujukan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/surat_rujukan/surat_rujukan', $data);
    }

    //added putri 04-06-2024
    public function surat_rujuk_balik($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/surat_rujukan/surat_rujuk_balik', $data);
    }

    //added putri 04-06-2024
    public function suket_kematian($reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $reg != "" ? $reg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['ket_kematian'] = $this->M_emedrec->get_ket_kematian($no_reg)->row();
       
        $this->load->view('emedrec/rd/suket_kematian/surat_kematian', $data);
    }

    public function ringkasan_pulang_igd($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id'); 
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['ringkasan_pulang'] = $this->M_emedrec->get_ringkasan_pulang_igd($no_reg)->row();
        $data['nama_form'] = 'RINGKASAN PULANG PASIEN IGD';
        $this->load->view('emedrec/rd/ringkasan_pulang/ringkasan_pulang_igd', $data);
    }

    //added putri 07-06-2024
    public function pengkajian_medis_igd($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['get_data_lab'] = $this->M_emedrec->get_lab_pasien($no_reg)->result();
        $data['get_data_rad'] = $this->M_emedrec->get_rad_pasien($no_reg)->result();
        $data['pengkajian_medis'] = $this->M_emedrec->get_pengkajian_medis_igd($no_reg)->row();
        $this->load->view('emedrec/rd/pengkajian_medis/pengkajian_medis_igd', $data);
    }
    //added putri 10-06-2024
    public function pengantar_ranap($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/pengantar_ranap/suket_pengantar_ranap', $data);
    }
    

    public function pengkajian_rawat_jalan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['nama_form'] = 'PENGKAJIAN KEPERAWATAN RAWAT JALAN';
        $data['assesment_keperawatan'] = $this->M_emedrec->get_pengkajian_rawat_jalan($noreg)->row();
       
        $this->load->view('emedrec/rj/pengkajian_keperawatan_rawat_jalan/pengkajian_keperawatan_rawat_jalan', $data);
    }

    public function pengkajian_medis_rawat_jalan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['nama_form'] = 'PENGKAJIAN MEDIS RAWAT JALAN';
        $data['pengkajian_medis'] = $this->M_emedrec->get_pengkajian_medis_rj($noreg)->row();
       
        $this->load->view('emedrec/rj/pengkajian_medis_rawat_jalan/pengkajian_medis_rawat_jalan', $data);
    }
//added putri 11-06-2024
    public function persetujuan_tindakan_medis($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/tindakan_medis/persetujuan_tindakan_medis', $data);
    }

    public function penolakan_tindakan_medis($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/tindakan_medis/penolakan_tindakan_medis', $data);
    }

    public function lembar_kontrol($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/kontrol/surat_kontrol', $data);
    }

    public function lembar_konsul($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/konsul/lembar_konsul', $data);
    }

    public function cuti_perawatan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['cuti'] = $this->M_emedrec->get_cuti($no_reg)->row();
        $this->load->view('emedrec/rd/cuti/cuti_perawatan', $data);
    }
    //added putri 13-06-2024
    public function penundaan_pelayanan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['penundaan_pelayanan'] = $this->M_emedrec->get_penundaan($no_reg)->row();
        $this->load->view('emedrec/rd/penundaan/penundaan_pelayanan', $data);
    }
    //added putri 14-06-2024
    public function triase($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['triase'] = $this->M_emedrec->get_triase_igd($no_reg)->row();
       
        $this->load->view('emedrec/rd/triase/formulir_triase', $data);
    }
    //added putri 18-06-2024
    public function skrining($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['skrining'] = $this->M_emedrec->get_skrining_igd($no_reg)->row();
       
        $this->load->view('emedrec/rd/skrining/formulir_skrining', $data);
    }
    public function kesediaan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rd/kesediaan/form_kesediaan', $data);
    }
    //added putri 19-06-2024
    public function observasi($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['observasi'] = $this->M_emedrec->get_observasi($no_reg)->row();
        $this->load->view('emedrec/rd/observasi/form_observasi', $data);
    }
    //added 20-06-2024
    public function edukasi_pasien($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['edukasi_pasien'] = $this->M_emedrec->get_edukasi_pasien($no_reg)->row();
       
        $this->load->view('emedrec/rd/edukasi_terintegrasi/form_edukasi', $data);
    }

    public function transfusi_darah($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rj/transfusi/permintaan_transfusi_darah', $data);
    }
    
    //added putri 19-07-2024
    public function resep_kacamata($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['resep_mata'] = $this->M_emedrec->get_resep_mata($no_reg)->row();
       
        $this->load->view('emedrec/rj/resep_mata/resep_mata', $data);
    }

    public function pengkajian_anak($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['pengkajian_anak'] = $this->M_emedrec->get_pengkajian_keperawatan_anak($no_reg)->row();
       
        $this->load->view('emedrec/rj/pengkajian_keperawatan_anak/pengkajian_keperawatan_anak', $data);
    }

    public function pengkajian_medis_anak($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['pengkajian_medik_anak'] = $this->M_emedrec->get_pengkajian_medik_anak($no_reg)->row();
        $this->load->view('emedrec/rj/pengkajian_medis_anak/pengkajian_medis_anak', $data);
    }

    

    public function rehabmedik_rj($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $no_reg != "" ? $no_reg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['rehab_medik'] = $this->M_emedrec->get_lembar_fisik_rehab($no_reg)->row();
        $this->load->view('emedrec/rj/rehabmedik/rehab_medik_rj', $data);
    }


    public function hasil_uji_fungsi($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['uji_fungsi'] = $this->M_emedrec->get_uji_fungsi_rehab($noreg)->row();
        $this->load->view('emedrec/rj/hasil_tindakan/hasil_tindakan_uji', $data);
    }

    public function pengkajian_tht($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id');; 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['medik_tht'] = $this->M_emedrec->get_pengkajian_medik_tht($noreg)->row();
        $this->load->view('emedrec/rj/pengkajian_tht/pengkajian_tht', $data);
    }

    public function pengkajian_medis_obgyn($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $no_reg !="" ? $no_reg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['medik_obgyn'] = $this->M_emedrec->get_medik_obgyn($no_reg)->row();
       
        $this->load->view('emedrec/rj/pengkajian_medis_obgyn/medis_obgyn', $data);
    }

    
    public function pengkajian_keperawatan_obgyn($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $no_reg !="" ? $no_reg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['keperawatan_obgyn'] = $this->M_emedrec->get_keperawatan_obgyn($no_reg)->row();
       
        $this->load->view('emedrec/rj/keperawatan_obgyn/keperawatan_obgyn', $data);
    }

    public function program_terapi($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['program_terapi_rehab'] = $this->M_emedrec->get_program_terapi_rehab($noreg)->row();
        $this->load->view('emedrec/rj/program_terapi/program_terapi', $data);
    }

    public function lap_pembedahan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rj/lap_pembedahan/laporan_pembedahan', $data);
    }

    public function cppt_rajal($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['nama_form'] = 'CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN';
        $data['get_data_cppt'] = $this->M_emedrec->get_data_cppt_by_noreg($noreg)->row();
        $data['get_soap_medik'] = $this->M_emedrec->get_soap_medik($noreg)->row();
        $data['get_data_procedur'] = $this->M_emedrec->get_procedur($noreg)->result();
       
        $this->load->view('emedrec/rj/cppt_rajal/cppt_rajal', $data);
    }

    public function ringkasan_keluar_rj($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['nama_form'] = 'RINGKASAN KELUAR PASIEN RAWAT JALAN';
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
        $data['get_data_tind'] = $this->M_emedrec->get_tindakan_pasien($noreg)->result();
        $data['get_data_procedur'] = $this->M_emedrec->get_procedur($noreg)->result();
        $data['ringkasan_keluar'] = $this->M_emedrec->get_ringkasan_keluar_pasien($noreg)->row();
       
        $this->load->view('emedrec/rj/ringkasan_keluar/ringkasan_pulang_rj', $data);
    }

    public function lembar_kontrol_pasien($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($noreg)->row();
        $data['kontrol'] = $this->M_emedrec->get_lembar_kontrol_pasien($noreg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
       
        $this->load->view('emedrec/rj/kontrol/surat_kontrol', $data);
    }
    public function upload_penunjang_rj($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['upload_penunjang'] = $this->M_emedrec->get_upload_penunjang($noreg)->row();
        $this->load->view('emedrec/rj/upload_penunjang_rj/upload_penunjang_rj', $data);
    }
    public function upload_penunjang_rd($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['upload_penunjang_rd'] = $this->M_emedrec->get_upload_penunjang($noreg)->row();
        $this->load->view('emedrec/rd/upload_penunjang_rd/upload_penunjang_rd', $data);
    }

    public function lembar_konsul_pasien($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['konsul'] = $this->M_emedrec->get_lembar_konsul_pasien($noreg)->row();
        // var_dump( $data['konsul']);die();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
       
        $this->load->view('emedrec/rj/konsul/lembar_konsul', $data);
    }

    public function lembar_jawaban_konsul_pasien($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['konsul'] = $this->M_emedrec->get_lembar_jawaban_konsul_pasien($noreg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
       
        $this->load->view('emedrec/rj/konsul/jawaban_konsul', $data);
    }

    public function pengantar_surat_ranap($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        // var_dump($data['data_dokter']);die();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($noreg)->row();
        $data['pengantar_ranap'] = $this->M_emedrec->get_pengantar_ranap_pasien($noreg)->row();
        $data['get_data_diag'] = $this->M_emedrec->get_diagnosa_pasien($noreg)->result();
        $data['get_data_lab'] = $this->M_emedrec->get_lab_pasien($noreg)->result();
        $data['get_data_rad'] = $this->M_emedrec->get_rad_pasien($noreg)->result();
        
       
        $this->load->view('emedrec/rj/pengantar_ranap/suket_pengantar_ranap', $data);
    }

    public function permintaan_transfusi_darah($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['transfusi_darah'] = $this->M_emedrec->get_permintaan_transfusi_darah($noreg)->row();
        $this->load->view('emedrec/rj/transfusi/permintaan_transfusi_darah', $data);
    }

    public function persetujuan_tindakan_medik($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['persetujuan_tindakan'] = $this->M_emedrec->get_persetujuan_tindakan($noreg)->row();
       
        $this->load->view('emedrec/rj/tindakan_medis/persetujuan_tindakan_medis', $data);
    }

    public function penolakan_tindakan_medik($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['penolakan_tindakan'] = $this->M_emedrec->get_penolakan_tindakan($noreg)->row();
       
        $this->load->view('emedrec/rj/tindakan_medis/penolakan_tindakan_medis', $data);
    }

    public function surat_rujukan_pasien($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['surat_rujukan'] = $this->M_emedrec->surat_rujukan($noreg)->row();
       
        $this->load->view('emedrec/rj/surat_rujukan/surat_rujukan', $data);
    }

    public function pengkajian_gigi($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        // var_dump($data['data_daftar_ulang']);die();
        $data['assesment_gigi'] = isset($noreg) ? $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($noreg)->result() : '';
        $data['gigi'] = isset($noreg) ? $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($noreg)->result() : '';
       
        $this->load->view('emedrec/rj/formgigi/rekam_medik_gigi', $data);
    }

    public function lap_pemebedahan($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['lap_pembedahan'] = $this->M_emedrec->get_lap_pemebedahan($noreg)->row();
        $this->load->view('emedrec/rj/lap_pembedahan_sjj/laporan_pembedahan', $data);
    }
    public function lap_echo($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['laporan_echo'] = $this->M_emedrec->get_lap_echo($noreg)->row();
        $this->load->view('emedrec/rj/laporan_echo/laporan_echo', $data);
    }

    public function persetujuan_hiv($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['persetujuan_hiv'] = $this->M_emedrec->get_persetujuan_hiv($noreg)->row();
        $this->load->view('emedrec/rj/persetujuan_hiv/persetujuan_hiv', $data);
    }
    public function formulir_registrasi_hiv($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['formulir_hiv'] = $this->M_emedrec->get_registrasi_hiv($noreg)->row();
        $this->load->view('emedrec/rj/formulir_regis_hiv/formulir_registasi_hiv', $data);
    }
    public function keperawatan_ponek($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['catatan_ponek'] = $this->M_emedrec->get_keperawaran_ponek($noreg)->row();
        $this->load->view('emedrec/rd/keperawatan_ponek/catatan_kep_ponek', $data);
    }

    public function lembar_konsul_new($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['konsul'] = $this->M_emedrec->get_lembar_konsul_pasien($noreg)->result();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
      
        $this->load->view('emedrec/rj/konsul/konsultasi', $data);
        
    }
    public function insert_medis_ponek($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id'); 
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($noreg)->row();
        $data['medis_ponek'] = $this->M_emedrec->get_medis_ponek($noreg)->row();
        $this->load->view('emedrec/rd/medis_ponek/medis_ponek', $data);
    }
    public function insert_triase_ponek($noreg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $noreg != "" ? $noreg : $this->input->post('user_id');
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
        $data['triase_ponek'] = $this->M_emedrec->get_triase_ponek($no_reg)->row();
       
        $this->load->view('emedrec/rd/triase_ponek/triase_ponek', $data);
    }
    public function asuhan_gizi($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        // var_dump($no_reg);die();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        // var_dump( $data['data_dokter']);die();
        $data['asuhan_gizi_rj'] = $this->M_emedrec->get_asuhan_gizi($no_reg)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rj/asuhan_gizi/asuhan_gizi', $data);
    }
    public function asuhan_gizi_anak($no_reg = "", $nocm = "", $nomedrec = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_reg = $this->input->post('user_id');
        // var_dump($no_reg);die();
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->row();
        $data['data_dokter'] = $this->M_emedrec->get_dokter_igd($no_reg)->row();
        // var_dump( $data['data_dokter']);die();
        $data['asuhan_gizi_anak_rj'] = $this->M_emedrec->get_asuhan_gizi_anak($no_reg)->row();
        $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
       
        $this->load->view('emedrec/rj/asuhan_gizi_anak/asuhan_gizi_anak', $data);
    }

}
