<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class C_emedrec_iri extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('emedrec/M_emedrec_iri', '', TRUE);
        $this->load->model('emedrec/M_emedrec', '', TRUE);
        $this->load->model('iri/rimtindakan');
        $this->load->model('iri/rimpasien');
        $this->load->model('irj/rjmpelayanan');
        $this->load->model('admin/appconfig', '', TRUE);
        $this->load->model('lab/labmdaftar', '', TRUE);
        $this->load->model('rad/radmdaftar', '', TRUE);
        $this->load->model('irj/rjmregistrasi', '', TRUE);
        $this->load->model('elektromedik/emmdaftar', '', TRUE);
        //$this->load->library('ciqrcode');
    }

    public function index()
    {
        $data['title'] = 'E MEDREC RAWAT INAP';
        $data['data_pasien'] =  "";


        $this->load->view('emedrec/V_emedrec_iri', $data);
    }

    public function pasien_iri($cm = '')
    {
        $data['title'] = 'E MEDREC RAWAT INAP';
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
        // print_r($data['data_pasien']);
        // exit();
        // $data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
        // $data['data_pasien_irj'] = $this->M_emedrec->getdata_record_pasien($this->input->post('cari_no_cm'))->result();
        // $data['data_pasien_iri'] = $this->M_emedrec->getdata_iri_pasien($this->input->post('cari_no_cm'))->result();
        // $data['data_pasien_ird'] =  $this->M_emedrec->getdata_ird_pasien($this->input->post('cari_no_cm'))->result();
        // print_r($data['data_pasien_irj']);
        // exit();
        // $data['result_lab'] = [];

        if (empty($data['data_pasien']) == 1) {
            $success =     '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec');
        } else {

            $this->load->view('emedrec/V_emedrec_iri', $data);
        }
    }

    public function rekam_medis_detail($cm = '')
    {
        $cm_string = strval($cm);
        $data['title'] = 'REKAM MEDIK ' . $cm_string;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['data_pasien_iri'] = $this->M_emedrec_iri->get_pasien_iri_by_no_cm($cm);
        $this->load->view('emedrec/V_rekam_medik_detail_iri', $data);
    }

    // done 
    public function cetak_pengantar_iri($no_ipd = '')
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        if ($no_ipd != '') {
            $no_ipd = $no_ipd;
        } else {
            $no_ipd = $this->input->post('user_id');
        }
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        // 
        $data['kode_document'] = $this->M_emedrec->get_kode_document('surat_pengantar_ri');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_for_pengantar_iri_by_no_ipd($no_ipd);
        $nipeg = isset($data['data_pasien'][0]->nm_dokter) ? $data['data_pasien'][0]->nm_dokter : '';
        $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
        $data['ruang'] = $this->M_emedrec_iri->get_last_ruang($no_ipd)->row()->nmruang;
        $data['tanggal'] = $this->M_emedrec_iri->get_tanggal_masuk_ranap($no_ipd)->row()->tgl_masuk;
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('spri')->row();
        // var_dump($data['sip_dokter']);
        // $data['pengantar_ri'] = $this->M_emedrec_iri->get_data_for_pengantar_iri_by_no_ipd($no_ipd);
        $this->load->view('emedrec/ri/surat_pengantar_rawat_inap', $data);
        // // die();
        // if($testy != null){
        //     $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        //     $data['logo_header'] =  "logo.png";
        //     // var_dump($no_ipd);
        //     $data['data_pasien'] = $this->M_emedrec_iri->get_data_for_pengantar_iri_by_no_ipd($no_ipd);
        //     // $data['jenkel']=$data['data_pasien']->sex;	
        //     // if($data['jenkel']=='L'){
        //     //     $data['jenis_kelamin'] = 'Laki - Laki';
        //     // }else{
        //     //     $data['jenis_kelamin'] = 'Perempuan';
        //     // }
        //     // var_dump($data['data_pasien']);
        //     $this->load->view('emedrec/ri/surat_pengantar_rawat_inap',$data);
        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }

    }

    // added
    // belum di cek , baru dimasukan views nya
    public function cetak_resume_medis_iri($noipd = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";

        //7,8,9        
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->result();
        // var_dump($data['pasien']->ttd_dpjp);
        // die();

        $noregasal = $data['pasien']->noregasal;
        $id_poli = $this->M_emedrec_iri->get_poli($noregasal)->row()->id_poli;
        $data['id_poli'] = $id_poli;

        //1
        $riwayat_penyakit = $this->M_emedrec_iri->get_riwayat_penyakit_igd($noregasal)->row();
        $data['riwayat_penyakit'] = json_decode($riwayat_penyakit->formjson, TRUE);

        //2
        $fisik = $this->M_emedrec_iri->get_fisik_igd($noregasal)->row();
        $data['fisik'] = $fisik->objective_perawat;

        //3
        $data['radiologi'] = $this->M_emedrec_iri->get_radiologi_for_resume($no_ipd)->result();
        $data['labor'] = $this->M_emedrec_iri->get_lab_for_resume($no_ipd)->result();
        $data['elektro'] = $this->M_emedrec_iri->get_elektro_for_resume($no_ipd)->result();
        $data['hasil_lab'] = $this->M_emedrec_iri->get_hasil_lab_for_resume($no_ipd)->result();

        if ($id_poli == 'BA00') {
            $data['radiologi_igd'] = $this->M_emedrec_iri->get_radiologi_for_resume($noregasal)->result();
            $data['labor_igd'] = $this->M_emedrec_iri->get_lab_for_resume($noregasal)->result();
            $data['elektro_igd'] = $this->M_emedrec_iri->get_elektro_for_resume($noregasal)->result();
            $data['hasil_lab_igd'] = $this->M_emedrec_iri->get_hasil_lab_for_resume($noregasal)->result();
        } else {
            $data['radiologi'] = array();
            $data['labor'] = array();
            $data['elektro'] = array();
            $data['hasil_lab_igd'] = array();
        }

        //4        
        $data['diagnosa'] = $this->M_emedrec_iri->get_diagnosa_for_resume($no_ipd)->result();
        $data['diagnosa_utama'] = $this->M_emedrec_iri->get_diagnosa_utama_for_resume($no_ipd)->result();

        //5
        $data['tindakan'] = $this->M_emedrec_iri->get_prosedur_for_resume($no_ipd)->result();

        //6
        $data['obat_all'] = $this->M_emedrec_iri->get_obat_all_for_resume($noregasal)->result();


        //10
        $data['obat'] = $this->M_emedrec_iri->get_obat_for_resume($no_ipd)->result();

        $rad_rows = $this->M_emedrec_iri->get_radiologi_for_resume($no_ipd)->num_rows();
        $em_rows = $this->M_emedrec_iri->get_elektro_for_resume($no_ipd)->num_rows();
        $lab_rows = $this->M_emedrec_iri->get_lab_for_resume($no_ipd)->num_rows();
        $hasil_lab_rows = $this->M_emedrec_iri->get_hasil_lab_for_resume($no_ipd)->num_rows();

        $rad_rows_igd = $this->M_emedrec_iri->get_radiologi_for_resume($noregasal)->num_rows();
        $em_rows_igd = $this->M_emedrec_iri->get_elektro_for_resume($noregasal)->num_rows();
        $lab_rows_igd = $this->M_emedrec_iri->get_lab_for_resume($noregasal)->num_rows();
        $hasil_lab_rows_igd = $this->M_emedrec_iri->get_hasil_lab_for_resume($noregasal)->num_rows();

        foreach ($data['radiologi'] as $key) {
            $rad_jenis_tindakan[] = $key->jenis_tindakan;
            $rad_id_tindakan[] = $key->id_tindakan;
        }
        foreach ($data['elektro'] as $key) {
            $em_jenis_tindakan[] = $key->jenis_tindakan;
            $em_id_tindakan[] = $key->id_tindakan;
        }
        foreach ($data['labor'] as $key) {
            $lab_jenis_tindakan[] = $key->jenis_tindakan;
            $lab_id_tindakan[] = $key->id_tindakan;
        }
        foreach ($data['hasil_lab'] as $key) {
            $hasil_lab_jenis_hasil[] = $key->jenis_hasil;
            $hasil_lab_hasil_lab[] = $key->hasil_lab;
            $hasil_lab_kadar_normal[] = $key->kadar_normal;
            $hasil_lab_satuan[] = $key->satuan;
            $hasil_lab_jenis_tindakan[] = $key->jenis_hasil;
            $hasil_lab_id_tindakan[] = $key->id_tindakan;
        }

        if ($id_poli == 'BA00') {
            foreach ($data['radiologi_igd'] as $key) {
                $rad_jenis_tindakan_igd[] = $key->jenis_tindakan;
                $rad_id_tindakan_igd[] = $key->id_tindakan;
            }
            foreach ($data['elektro_igd'] as $key) {
                $em_jenis_tindakan_igd[] = $key->jenis_tindakan;
                $em_id_tindakan_igd[] = $key->id_tindakan;
            }
            foreach ($data['labor_igd'] as $key) {
                $lab_jenis_tindakan_igd[] = $key->jenis_tindakan;
                $lab_id_tindakan_igd[] = $key->id_tindakan;
            }
            foreach ($data['hasil_lab_igd'] as $key) {
                $hasil_lab_jenis_hasil_igd[] = $key->jenis_hasil;
                $hasil_lab_hasil_lab_igd_igd[] = $key->hasil_lab;
                $hasil_lab_kadar_normal_igd[] = $key->kadar_normal;
                $hasil_lab_satuan_igd[] = $key->satuan;
                $hasil_lab_jenis_tindakan_igd[] = $key->jenis_hasil;
                $hasil_lab_id_tindakan_igd[] = $key->id_tindakan;
            }
        } else {
        }

        $tidak_ada[] = array("Tidak Ada Pemeriksaan");

        $tampung = array();
        // if ($rows == 0) {
        // 	for ($i=0; $i < $rows ; $i++) { 
        // 		$tampung[] = '<br>'.$tidak_ada[$i];
        // 	}
        // }else{
        $tampung[] = '•Rawat Inap';
        if ($rad_rows != 0) {
            for ($i = 0; $i < $rad_rows; $i++) {
                $tampung[] = '<br>' . 'Radiologi :' . $rad_jenis_tindakan[$i] . ' (' . $rad_id_tindakan[$i] . ')<br>';
            }
        } else {
        }

        if ($em_rows != 0) {
            for ($i = 0; $i < $em_rows; $i++) {
                $tampung[] = '<br>' . 'Elektromedik :' . $em_jenis_tindakan[$i] . ' (' . $em_id_tindakan[$i] . ')<br>';
            }
        } else {
        }

        if ($lab_rows != 0) {
            for ($i = 0; $i < $lab_rows; $i++) {
                $tampung[] = '<br>' . 'Laboratorium :' . $lab_jenis_tindakan[$i] . ' (' . $lab_id_tindakan[$i] . ')<br><br>';
            }
        } else {
        }

        if ($hasil_lab_rows != 0) {
            for ($i = 0; $i < $hasil_lab_rows; $i++) {
                $tampung[] = '<br>' . $hasil_lab_jenis_hasil[$i] . ' Hasil : ' . $hasil_lab_hasil_lab[$i] . ' Kadar Normal : ' . $hasil_lab_kadar_normal[$i] . $hasil_lab_satuan[$i] . '<br>';
            }
        } else {
        }


        if ($id_poli == 'BA00') {
            $tampung[] = '<br>•IGD';
            if ($rad_rows_igd != 0) {
                for ($i = 0; $i < $rad_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Radiologi :' . $rad_jenis_tindakan_igd[$i] . ' (' . $rad_id_tindakan_igd[$i] . ')<br>';
                }
            } else {
            }

            if ($em_rows_igd != 0) {
                for ($i = 0; $i < $em_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Elektromedik :' . $em_jenis_tindakan_igd[$i] . ' (' . $em_id_tindakan_igd[$i] . ')<br>';
                }
            } else {
            }

            if ($lab_rows_igd != 0) {
                for ($i = 0; $i < $lab_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Laboratorium :' . $lab_jenis_tindakan_igd[$i] . ' (' . $lab_id_tindakan_igd[$i] . ')<br><br>';
                }
            } else {
            }

            if ($hasil_lab_rows_igd != 0) {
                for ($i = 0; $i < $hasil_lab_rows_igd; $i++) {
                    $tampung[] = '<br>' . $hasil_lab_jenis_hasil_igd[$i] . ' Hasil : ' . $hasil_lab_hasil_lab_igd_igd[$i] . ' ,Kadar Normal : ' . $hasil_lab_kadar_normal_igd[$i] . $hasil_lab_satuan_igd[$i] . '<br>';
                }
            } else {
            }
        } else {
        }

        // }
        $gabung = implode($tampung);

        $rest['penemuan_klinik'] = $gabung;
        $rest['riwayat_penyakit'] = $data['riwayat_penyakit']['riwayat_kesehatan'];
        $rest['pemeriksaan_fisik'] = $data['fisik'];
        $rows = $this->rimtindakan->get_data_resume($no_ipd)->row();
        // var_dump($rows==FALSE);
        // die();
        if ($rows == FALSE) {
            $rest['no_ipd'] = $no_ipd;
            $this->M_emedrec_iri->insert_data_resume($rest);
            //INSERT
        } else {
            $this->M_emedrec_iri->update_data_resume($no_ipd, $rest);
            // UPDATE
        }

        //tdda kalfyta
        $data['ttf'] = $this->M_emedrec_iri->gte_tdd_keluarda($no_ipd)->row();

        //add resume

        $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($no_ipd)->row();
        $data['pemeriksaan_fisik_ri'] = $this->M_emedrec_iri->pemeriksaan_fisik_ri($no_ipd)->row();

        $nipeg = isset($data['pasien']->dokter) ? $data['pasien']->dokter : '';
        $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('emedrec/ri/resume_medis_iri', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        // $this->load->view('emedrec/ri/resume_medis_iri',$data);
    }

    public function cetak_resume_medis_iri_last($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['noipd'] = $no_ipd;

        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('ringkasan_pasien_pulang')->row();

        //7,8,9        
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($cm);
        // var_dump($data['pasien']->ttd_dpjp);
        // die();
        $data['ttf'] = $this->M_emedrec_iri->gte_tdd_keluarda($no_ipd)->row();
        $noregasal = isset($data['pasien']->noregasal) ? $data['pasien']->noregasal : '';
        // var_dump($noregasal);die();

        $resume = $this->rimtindakan->get_data_resume($no_ipd)->row();
        $data['resume'] = $resume;
        $data['obat'] = $this->M_emedrec_iri->get_obat_for_resume($no_ipd)->result();
        if ($resume != null) {
            //1
            $data['riwayat_penyakit'] = isset($resume->riwayat_penyakit) ? $resume->riwayat_penyakit : '';

            //2
            $data['fisik'] = isset($resume->pemeriksaan_fisik) ? $resume->pemeriksaan_fisik : '';

            //3
            $data['penemuan_klinik'] = isset($resume->penemuan_klinik) ? $resume->penemuan_klinik : '';

            //4        
            $data['diagnosa'] = $this->M_emedrec_iri->get_diagnosa_for_resume($no_ipd)->result();
            $data['diagnosa_utama'] = $this->M_emedrec_iri->get_diagnosa_utama_for_resume($no_ipd)->result();

            //5
            $data['tindakan'] = $this->M_emedrec_iri->get_prosedur_for_resume($no_ipd)->result();

            //6
            // $data['obat_all'] = $this->M_emedrec_iri->get_obat_all_for_resume($noregasal)->result();
            $data['obat_all'] = isset($resume->pengobatan) ? $resume->pengobatan : '';
            $data['ttd'] = $this->M_emedrec_iri->get_ttd_pasien($noipd)->row();
            $data['kio'] = $this->M_emedrec_iri->get_kio_resume($no_ipd)->row();
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('ringkasan_pasien_pulang')->row();
            // var_dump($data['kio']);die();
            // $data['obat'] = $this->M_emedrec_iri->get_obat_for_resume($no_ipd)->result();

            //tdda kalfyta
            //$id_poli = $this->M_emedrec_iri->get_poli($noregasal)->row()->id_poli;
            //$data['id_poli'] = $id_poli;


            $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($no_ipd)->row();
            $data['pemeriksaan_fisik_ri'] = $this->M_emedrec_iri->pemeriksaan_fisik_ri($no_ipd)->row();

            $nipeg = isset($data['pasien']->dokter) ? $data['pasien']->dokter : '';
            // $data['sip_dokter'] = $nipeg?$this->M_emedrec->data_nipeg_by_nama($nipeg)->row():null;
            $data['sip_dokter'] = $this->M_emedrec->get_nama_dokter_by_no_ipd($no_ipd)->row();
        } else {
        }
        $nomor_cm = "" . $no_ipd . " || Cek Validasi di www.rsomh.co.id";

        $writer = new PngWriter();
        $qrCode = QrCode::create($nomor_cm)
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
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        $data['qr'] = $hasil;
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;

        $html = $this->load->view('emedrec/ri/resume_medis_iri_last', $data, true);

        $mpdf->WriteHTML($html);
        $mpdf->showWatermarkImage = true;
        $mpdf->Output();
        //$mpdf->Output($qrCode);
        // $this->load->view('emedrec/ri/resume_medis_iri',$data);
    }

    public function cetak_resume($noipd = '')
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['noipd'] = $no_ipd;

        //7,8,9        
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->result();
        // var_dump($data['pasien']->ttd_dpjp);
        // die();

        $noregasal = $data['pasien']->noregasal;
        $id_poli = $this->M_emedrec_iri->get_poli($noregasal)->row()->id_poli;
        $data['id_poli'] = $id_poli;
        $resume = $this->rimtindakan->get_data_resume($no_ipd)->row();
        if ($resume != null) {
            //1
            $data['riwayat_penyakit'] = isset($resume->riwayat_penyakit) ? $resume->riwayat_penyakit : '';

            //2
            $data['fisik'] = isset($resume->pemeriksaan_fisik) ? $resume->pemeriksaan_fisik : '';

            //3
            $data['penemuan_klinik'] = isset($resume->penemuan_klinik) ? $resume->penemuan_klinik : '';

            //4        
            $data['diagnosa'] = $this->M_emedrec_iri->get_diagnosa_for_resume($no_ipd)->result();
            $data['diagnosa_utama'] = $this->M_emedrec_iri->get_diagnosa_utama_for_resume($no_ipd)->result();

            //5
            $data['tindakan'] = $this->M_emedrec_iri->get_prosedur_for_resume($no_ipd)->result();

            //6
            // $data['obat_all'] = $this->M_emedrec_iri->get_obat_all_for_resume($noregasal)->result();
            $data['obat_all'] = isset($resume->pengobatan) ? $resume->pengobatan : '';


            //10
            $data['obat'] = $this->M_emedrec_iri->get_obat_for_resume($no_ipd)->result();

            //tdda kalfyta
            $data['ttf'] = $this->M_emedrec_iri->gte_tdd_keluarda($no_ipd)->row();


            $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($no_ipd)->row();
            $data['pemeriksaan_fisik_ri'] = $this->M_emedrec_iri->pemeriksaan_fisik_ri($no_ipd)->row();

            $nipeg = isset($data['pasien']->dokter) ? $data['pasien']->dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
        } else {
        }

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        $html = $this->load->view('emedrec/ri/resume_medis_iri_last', $data, true);
        $this->cetak->AddPage('P', 'A4');
        $this->cetak->write2DBarcode("aaaaa", 'QRCODE,L', 155, $this->cetak->getY(), 30, 30, $style);
        $this->cetak->Output('PKKPR.pdf', 'I');
    }

    public function qrcode()
    {
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        //$mpdf = new \Mpdf\HTMLParserMode();
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        //$mpdf->toString($qrCode);
        //$data_qr['qrcode'] = $qrCode;	
        $html = $this->load->view('emedrec/ri/test', true);
        $html = '<watermarkimage src="' . FCPATH . ("assets/images/user_unknown.png") . '" alpha="1" size="12,14" position="93,204" />';
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->showWatermarkImage = true;
        $mpdf->Output();
    }

    // added 
    public function cetak_general_consent($showttd = "", $no_reg = '', $cm = '')
    {
        $cm = $cm != "" ? $cm : $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['pasien'] = $this->M_emedrec_iri->get_data_iri($no_reg);
        $no_ipd = $this->input->post('user_id');
        // var_dump($this->input->post('user_id'));die();
        $noreg = $no_reg != "" ? $no_reg : $this->input->post('user_id');
        $cek = $this->M_emedrec_iri->get_data_general_consent($noreg);
        // if($cek != null){
        $data['showttd'] = $showttd;
        if ($no_reg != '') {
            $data['general_consent'] = $cek;
        } else {
            $no_ipd = $this->input->post('user_id');
            $no_register = $this->M_emedrec_iri->get_noregasal($no_ipd)->row()->noregasal;
            $data['general_consent'] = $cek;
        }
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        //$data['pasien'] = $this->M_emedrec_iri->get_noregasal($no_ipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('general_consent_v2')->row();
        $this->load->view('ri/general_consentjs', $data);

        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }

    }

    public function surat_persetujuan($showttd = "", $noipd = "", $cm = "")
    {
        $no_ipd = $noipd ? $noipd : $this->input->post('user_id');
        $cm = $cm ? $cm : $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($cm);
        $checking = $this->M_emedrec_iri->get_data_surat_persetujuan($no_ipd);
        if ($checking != null) {
            $data['showttd'] = $showttd;
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['surat_persetujuan'] = $checking;
            $data['spri'] = $this->M_emedrec_iri->get_spri($no_ipd)->row();
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('surat_persetujuan')->row();
            $this->load->view('ri/surat_persetujuan', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function catatan_medis_awal_rawat_inap($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $cek_data = $this->M_emedrec_iri->get_data_catatan_awal_medis($no_ipd);

        if ($cek_data != null) {

            $data['no_cm'] = $this->input->post('no_cm');
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
            $data['catatan_medis_awal_inap'] = $this->M_emedrec_iri->get_data_catatan_awal_medis($no_ipd);
            $nipeg = isset($data['catatan_medis_awal_inap'][0]->nm_dokter) ? $data['catatan_medis_awal_inap'][0]->nm_dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_awal_ri')->row();
            $this->load->view('ri/catatan_medis_awal_ri', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function catatan_medis_awal_rawat_inap_anak($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        // $no_ipd = $this->input->post('user_id');
        // $cm=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $cek_anak = $this->M_emedrec_iri->get_data_catatan_awal_medis($noipd);
        if ($cek_anak != null) {
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['catatan_medis_awal_anak'] = $this->M_emedrec_iri->get_data_catatan_awal_medis($noipd);
            $nipeg = isset($data['catatan_medis_awal'][0]->nm_dokter) ? $data['catatan_medis_awal'][0]->nm_dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
            // var_dump($data['catatan_medis_awal_anak']);die();
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_awal_ri_anak')->row();
            $this->load->view('ri/catatan_medis_awal_ri_anak', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function assesment_awal_keperawatan($noipd = "", $nomedrec = "", $nocm = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $cek_keperawatn_iri = $this->M_emedrec_iri->assesment_awal_keperawatan($no_ipd);

        if ($cek_keperawatn_iri != null) {

            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['assesment_awal_keperawatan_iri'] = $this->M_emedrec_iri->assesment_awal_keperawatan($no_ipd);
            // $data['assesment_awal_keperawatan_iri_with_ttd']= $this->M_emedrec_iri->assesment_awal_keperawatan_with_ttd($no_ipd);
            $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('awal_keperawatan')->row();
            //  var_dump($cek_keperawatn_iri[0]->old);die();
            if ($cek_keperawatn_iri[0]->old != 1) {
                $this->load->view('ri/assesment_awal_keperawatan', $data);
            } else {
                $this->load->view('ri/keperawatan', $data);
            }
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function assesment_awal_keperawatan_anak($noipd = "", $nomedrec = "", $nocm = "")
    {

      
        $no_ipd = $noipd != '' ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data_keperawatan_anak = $this->M_emedrec_iri->assesment_awal_keperawatan($no_ipd);
        if ($data_keperawatan_anak != null) {
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['assesment_awal_keperawatan_iri'] = $this->M_emedrec_iri->assesment_awal_keperawatan($no_ipd);
            $test = isset($data['assesment_awal_keperawatan_iri'][0]->formjson) ? json_decode($data['assesment_awal_keperawatan_iri'][0]->formjson) : '';
            $nm_perawat_1 = isset($test->question36) ? $test->question36 : '';
            $nm_perawat_2 = isset($test->question37) ? $test->question37 : '';
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('awal_keperawatan_anak')->row();
            $data['ttd_perawat_one'] = $nm_perawat_1 ? $this->M_emedrec_iri->get_ttd_by_name($nm_perawat_1)->row() : null;
            $data['ttd_perawat_two'] = $nm_perawat_2 ? $this->M_emedrec_iri->get_ttd_by_name($nm_perawat_2)->row() : null;
            $this->load->view('ri/assesment_awal_keperawatan_anak', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function get_cppt_iri($noipd = "", $nocm = "", $nomedrec = "")
    {
        $login_data = $this->load->get_var("user_info");
        $data['ppa'] = $login_data->ppa;
        $no_ipd = $noipd != '' ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $cek_cppt_iri = $this->M_emedrec_iri->get_cppt_iri($no_ipd)->result();

        if ($cek_cppt_iri != null) {
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['cppt_iri'] = $cek_cppt_iri;
            $nipeg = isset($data['catatan_medis_awal'][0]->nm_dokter) ? $data['catatan_medis_awal'][0]->nm_dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
            // var_dump($data['cppt_iri']);
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cppt_iri')->row();
            $this->load->view('ri/cppt_iri', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function get_cppt_iri_all($noipd = "", $nocm = "", $nomedrec = "")
    {
        $login_data = $this->load->get_var("user_info");
        $data['ppa'] = $login_data->ppa;
        $no_ipd = $noipd != '' ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($cm);
        $cek_cppt_iri = $this->M_emedrec_iri->get_cppt_iri_all($medrec)->result();

        if ($cek_cppt_iri != null) {
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['cppt_iri'] = $this->M_emedrec_iri->get_cppt_iri_all($medrec)->result();
            $nipeg = isset($data['catatan_medis_awal'][0]->nm_dokter) ? $data['catatan_medis_awal'][0]->nm_dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
            // var_dump($data['cppt_iri']);
            $data['kode_document'] = $this->M_emedrec->get_kode_document('cppt_iri');
            $this->load->view('ri/cppt_iri_all', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function konsul_dokter_iri($noipd = "", $nocm = "", $nomedrec = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec = "" ? $nomedrec : $this->input->post('no_medrec');
        //$medrec=$this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($no_ipd)->result();
        $noregasal = $data['data_pasien'][0]->noregasal;
        $cek_konsul_iri = $no_ipd != "" ? $this->M_emedrec_iri->get_konsultasi_pasien_iri($no_ipd)->result() : null;

        if (!empty($cek_konsul_iri)) {
            $data['no_cm'] = $nocm != "" ? $nocm : $this->input->post('no_cm');
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_konsultasi_antar_bagian')->row();
            $data['konsul_dokter_iri'] = $no_ipd != "" ? $this->M_emedrec_iri->get_konsultasi_pasien_iri($no_ipd)->result() : null;
            // var_dump($data['kode_document']);die();
            $this->load->view('ri/konsul_iri', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }


    public function dpjp_case_manager($noipd = "", $nocm = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');

        $cek_dpjp = $this->M_emedrec_iri->get_jadwal_dpjp_case_manager($no_ipd)->result();

        //if($cek_dpjp != null){

        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($no_ipd)->result();

        $data['tgl_case_manager'] = $this->M_emedrec_iri->get_tgl_jadwal_dpjp_case_manager($no_ipd)->result();
        $data['num_tgl_case_manager'] = $this->M_emedrec_iri->get_tgl_jadwal_dpjp_case_manager($no_ipd)->num_rows();

        $data['dokter_case_manager'] = $this->M_emedrec_iri->get_dokter_jadwal_dpjp_case_manager($no_ipd)->result();

        $data['detail_case_manager'] = $this->M_emedrec_iri->get_jadwal_dpjp_case_manager($no_ipd)->result();
        $data['drtambahan_iri'] = $this->M_emedrec_iri->get_drtambahan_iri($no_ipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('dpjp_case_manager')->row();
        // ini datanya
        $data['cppt_casemanager'] = $this->M_emedrec_iri->get_cppt_casemanager($no_ipd);

        $this->load->view('ri/case_manager', $data);
        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }

    }



    public function rencana_pemulangan_pasien($noipd = "", $nomedrec = "", $nocm = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $cek_pemulangan = $this->rimtindakan->get_rencana_pemulangan($no_ipd)->row();

        if ($cek_pemulangan != null) {
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rencana_pemulangan_pasien')->row();
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            $data['rencana_pemulangan'] = $this->M_emedrec_iri->get_rencana_pemulangan($no_ipd)->row();

            $this->load->view('ri/rencana_pemulangan_pasien', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function catatan_edukasi_iri($noipd = "", $nomedrec = "", $nocm = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        //$medrec=$this->input->post('no_medrec');
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $cek_edukasi = $no_ipd != "" ? $this->M_emedrec_iri->get_catatan_edukasi_iri($no_ipd)->row() : null;

        if ($cek_edukasi != null) {

            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_edukasi_iri')->row();
            $data['catatan_edukasi'] = $no_ipd != "" ? $this->M_emedrec_iri->get_catatan_edukasi_iri($no_ipd)->row() : null;
            $general_consent = $this->M_emedrec_iri->get_data_general_consent($no_ipd);
            // var_dump($general_consent);die();
            $json_general_consent = isset($general_consent[0]->formjson) ? json_decode($general_consent[0]->formjson) : null;
            // var_dump($json_general_consent);die();
            $data['general_consent']  = [
                'nama' => isset($json_general_consent->question23->nama) ? $json_general_consent->question23->nama : '-',
                'ttd' => isset($json_general_consent->ttd_pasien) ? $json_general_consent->ttd_pasien : null,
                'hub' => isset($json_general_consent->question23->hub) ? $json_general_consent->question23->hub : null
            ];
            $this->load->view('ri/catatan_edukasi', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function hasil_penunjang_iri($no_ipd = "")
    {
        $no_ipd = $this->input->post('user_id');
        $data['no_cm'] = $this->input->post('no_cm');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['data_pasien'] = $no_ipd != "" ? $this->M_emedrec_iri->data_pasien($no_ipd)->row() : null;
        $data['hasil_rad'] = $no_ipd != "" ? $this->M_emedrec_iri->gethasil_rad($no_ipd)->result() : null;
        $data['hasil_lab'] = $no_ipd != "" ? $this->M_emedrec_iri->gethasil_lab($no_ipd)->result() : null;
        $data['hasil_em'] = $no_ipd != "" ? $this->M_emedrec_iri->gethasil_em($no_ipd)->result() : null;
        // var_dump($data['hasil_em']);
        // $data['assesment_awal_keperawatan_iri']= $this->M_emedrec_iri->assesment_awal_keperawatan($no_ipd);
        $this->load->view('ri/penunjang_iri', $data);
    }

    public function ringkasan_masuk_keluar_pasien_iri($noipd = "", $cm = '', $noreg = "")
    {

        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');

        //  var_dump($no_ipd);die();
        $medrec = $this->input->post('no_medrec');
        $cm = $cm != "" ? $cm : $this->input->post('no_cm');
        // var_dump($medrec);die();

        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kode_document'] = $this->M_emedrec->get_kode_document('ringkasan_pasien_pulang');
        $data['data_pasien'] = $no_ipd != "" ? $this->M_emedrec_iri->data_pasien($no_ipd)->result() : null;

        $data['data_pasien_kedua'] = $no_ipd != "" ? $this->M_emedrec_iri->data_pasien_iri($no_ipd)->row() : null;
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();

        $no_reg_asal = $noreg != "" ? $noreg : $data['data_pasien_kedua']->no_register;

        $data['diagnosa_masuk'] = $this->M_emedrec_iri->get_diagnosa_masuk_ringkasan($no_reg_asal)->result();
        $data['diagnosa'] = $this->M_emedrec_iri->get_diagnosa_for_resume($no_ipd)->result();
        $data['diagnosa_utama'] = $this->M_emedrec_iri->get_diagnosa_utama_for_resume($no_ipd)->result();
        $data['tindakan'] = $this->M_emedrec_iri->get_prosedur_for_resume($no_ipd)->result();
        //var_dump( $data['tindakan']);die();
        $data['general_consent'] = $this->M_emedrec_iri->get_data_general_consent($no_ipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('ringkasan_masuk_keluar')->row();
        $waktu_masuk_iri = isset($data['pasien']->tgl_masuk) ? date_create($data['pasien']->tgl_masuk) : null;
        $waktu_keluar_iri = isset($data['pasien']->tgl_keluar) ? date_create($data['pasien']->tgl_keluar) : null;
        $diff = isset($waktu_keluar_iri) ? date_diff($waktu_masuk_iri, $waktu_keluar_iri) : null;
        $data['lama'] = $diff;
        $date = isset($diff->d) ? $diff->d : '';
        if ($date == 0 && $data['pasien']->tgl_keluar != null) {
            $data['lama'] = 1;
        } else {
            $data['lama'] = $date;
        }
        // var_dump($diff);
        // echo $diff->d;
        // echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s));

        $this->load->view('ri/masuk_keluar_pasien_iri', $data);
    }

    public function cetak_surat_laboratorium_iri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_ipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        // $cm=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        // $no_ipd=$this->input->post('user_id');

        $data_lab = $this->M_emedrec_iri->get_nolab_pemeriksaan_lab($no_ipd)->result();
        // var_dump($data_lab);

        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['tgl'] = date("d-m-Y");
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();

            $data['register'] = $data_lab;
            // $data['register'] = $this->M_emedrec_iri->get_nolab_pemeriksaan_lab($no_ipd)->result();

            $data['get_umur'] = $this->rjmregistrasi->get_umur($medrec)->result(); #
            foreach ($data['get_umur'] as $row) {
                $data['tahun'] = $row->umurday;
            }
            $data['usia'] = date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
            $data['hasil_pemeriksaan_lab'] =  isset($no_ipd) ? $this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result() : "";

            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/ri/cetak_laboratorium', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('ri/cetak_laboratorium',$data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_laboratorium_iri_old($no_ipd = "")
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $no_ipd = $this->input->post('user_id');
        $cek_lab_iri =  isset($no_ipd) ? $this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result() : "";

        //if($cek_lab_iri != null){
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['hasil_pemeriksaan_lab'] =  isset($no_ipd) ? $this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result() : "";
        // var_dump($data['pasien']);
        $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
        // var_dump($data['dokter_ruangan']);die();
        $data['kode_document'] = '';
        $this->load->view('ri/cetak_laboratorium', $data);
        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }

    }


    public function cetak_surat_elektromedik_iri($noipd = '', $no_medrec = '', $no_cm = '')
    {
        // $data['no_cm']=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        // $no_ipd=$this->input->post('user_id');
        $data['no_cm'] = $no_cm != "" ? $no_cm : $this->input->post('no_cm');
        $medrec = $no_medrec != "" ? $no_medrec : $this->input->post('no_medrec');
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');

        $null = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_ipd);

        if ($null != null) {
            date_default_timezone_set("Asia/Jakarta");
            $data['tgl_jam'] = date("d-m-Y H:i:s");
            $data['tgl'] = date("d F Y");
            $data['no_register'] =  $no_ipd;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            // var_dump($data['pasien']);
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['pemeriksaan_elektromedik'] = $this->M_emedrec->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_ipd);

            // $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_ipd)->row();

            // $nama_dokter_reffering = $this->M_emedrec->get_nama_dokter($data['data_daftar_ulang']->id_dokter)->row()->nm_dokter;			
            // $data['nama_dokter_reffering'] = $nama_dokter_reffering;

            // $nama_poli = $this->M_emedrec->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;			
            // $data['nama_poli'] = $nama_poli;

            // if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
            //     $data['kontraktor'] = 'BPJS';
            // }elseif($data['data_daftar_ulang']->cara_bayar == 'UMUM'){
            //     $data['kontraktor'] = '';
            // }else{
            //     $nama_kontraktor = $this->M_emedrec->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row()->nmkontraktor;
            //     $data['kontraktor'] = $nama_kontraktor;
            // }

            // if ($data['data_daftar_ulang']->diagnosa == null) {
            //     $data['diagnosa'] = '';    
            // }else{
            //     $nama_diagnosa = $this->M_emedrec->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;        
            //     $data['diagnosa'] = $nama_diagnosa;
            // }


            $this->load->view('ri/cetak_elektromedik_iri', $data);
        } else {
            // $success = 	'<div class="alert alert-danger">
            // 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            // 						<h3>Tidak Bisa Melihat Elektromedik.Dikarenakan Belum Ada Pemeriksaan
            // 					</div>';
            // 		$this->session->set_flashdata('success_msg', $success);
            // redirect('emedrec/C_emedrec/rekam_medik_detail/'.$data['no_cm'].'/'.$medrec);
        }
    }

    public function cetak_surat_radiologi_iri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        //$cm=$this->input->post('no_cm');

        //$medrec=$this->input->post('no_medrec');
        //$noipd=$this->input->post('user_id');
        $cek_rad_iri = $noipd ? $this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result() : "";

        //if($cek_rad_iri != null){
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($noipd)->row();
        // var_dump($data['pasien']);
        $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($noipd)->row();
        // var_dump( $data['dokter_ruangan']);die();
        $data['hasil_pemeriksaan_radiologi'] = $noipd ? $this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result() : "";
        $data['kode_document'] = '';
        $diag = $this->radmdaftar->get_data_pasien_iri($noipd)->row()->diagmasuk;
        if ($diag != null) {
            $id_icd = $this->radmdaftar->get_data_pasien_iri($noipd)->row()->diagmasuk;
            $nm_diagnosa = $this->radmdaftar->get_nama_diagnosa($id_icd)->row();
            if ($nm_diagnosa != null) {
                $data['nama_diagnosa'] = $nm_diagnosa->nm_diagnosa;
            } else {
                $data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
            }
        } else {
            $data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
        }

        $this->load->view('ri/cetak_radiologi_iri', $data);
        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }

    }

    public function cetak_hasil_rad($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');

        if ($noipd != '') {
            $data['no_register'] = $noipd;
            date_default_timezone_set("Asia/Bangkok");
            $tgl_jam = date("d-m-Y H:i:s");
            $data['tgl'] = date("d-m-Y");

            $conf = $this->appconfig->get_headerpdf_appconfig()->result();
            $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
            $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

            $data['data_hasil_rad'] = $this->radmdaftar->get_data_hasil_rad_by_noreg($noipd)->result();
            $data['data_hasil_rad2'] = $this->radmdaftar->get_data_hasil_rad_by_noreg($noipd)->result();

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

            $data['data_pasien'] = $this->radmdaftar->get_data_pasien_cetak_by_noreg($noipd)->row();
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

            $get_norad = $this->radmdaftar->get_norad_by_noreg($noipd)->result();
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
            // $this->load->view('emedrec/rj/cetak_hasil_rad',$data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak ada pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_evaluasi_MPP($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $noipd != "" ? $this->M_emedrec_iri->data_pasien($noipd)->result() : null;
        $data['data_from_a'] = $this->M_emedrec_iri->get_data_formulir_a($noipd)->row();
        $data['diagnosa_resume'] = $this->M_emedrec_iri->get_diagnosa_for_mpp($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('formulir_a_evaluasi_awal_mpp')->row();

        $this->load->view('ri/evaluasi_awal_mpp/evaluasi_awal_mpp', $data);
    }

    public function cetak_catatan_implementasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        // $cm=$this->input->post('no_cm');
        // $medrec=$this->input->post('no_medrec');
        // $noipd=$this->input->post('user_id');

        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $noipd != "" ? $this->M_emedrec_iri->data_pasien($noipd)->result() : null;
        $data['data_from_b'] = $this->M_emedrec_iri->get_data_formulir_b($noipd)->row();
        // var_dump($data['data_from_b']);

        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_implementasi')->row();

        $this->load->view('ri/catatan_implementasi', $data);
    }

    public function pengkajian_dekubitus($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();

        $no_reg_asal = $data['data_pasien'][0]->noregasal != "" ? $data['data_pasien'][0]->noregasal : null;
        // var_dump($no_reg_asal);die();
        $data['pengkajian_dekubitus'] = $this->M_emedrec_iri->pengkajian_dekubitus($noipd);
        $data['diagnosa'] = $this->M_emedrec_iri->get_diagnosa_masuk_ringkasan($no_reg_asal)->row();
        // var_dump($data['diagnosa']);
        $this->load->view('ri/pengkajian_dekubitus/pengkajian_dekubitus', $data);
    }

    public function fungsional_iri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['fungsional_iri'] = $this->M_emedrec_iri->fungsional_iri($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('status_fungsional')->row();

        $this->load->view('ri/pengkajian_dekubitus/fungsional', $data);
    }

    public function skala_morse_iri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['skala_morse_iri'] = $this->M_emedrec_iri->skala_morse_iri($noipd);

        $this->load->view('ri/pengkajian_dekubitus/skala_morse', $data);
    }

    public function ews_iri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        // var_dump($cm); die();
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['data_ews_iri'] = $this->M_emedrec_iri->ews_iri($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_observasi_ews')->row();

        $this->load->view('ri/lembar_ews/ews_dewasa_ri', $data);
    }
    public function lembar_dpjp_mpp($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['drtambahan_iri'] = $this->M_emedrec_iri->get_drtambahan_iri($noipd)->result();
        $data['assesment_awal_keperawatan'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_document('lembar_dpjp_mpp');
        $this->load->view('ri/lembar_dpjp_dan_mpp/lembar_dpjp_dan_mpp', $data);
    }

    public function cetak_serah_terima_asuhan_pasien($no_ipd = "", $noregasal = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $no_regasal = $noregasal != "" ? $noregasal : $this->input->post('noregasal');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        // var_dump($no_regasal);die();
        $data_serah_terima = $this->M_emedrec_iri->get_serah_terima($noipd, $no_regasal)->result();

        if ($data_serah_terima != null) {

            $data['kode_document'] = $this->M_emedrec->get_kode_document('triase');
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
            $data['pasien_iri'] = $this->M_emedrec->get_data_pasien_iri_bynoregasal($noipd)->result();
            $data['serah_terima'] = $data_serah_terima;
            $data['kode_document'] = $this->M_emedrec->get_kode_document('serah_terima');
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



    public function tata_terib_pasien($no_ipd = "", $cm = "")
    {
        $cm = $cm != "" ? $cm : $this->input->post('no_cm');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $no_regasal = $this->input->post('noregasal');
        $medrec = $this->input->post('no_medrec');
        $data['tata'] = $this->M_emedrec_iri->get_data_general_consent($noipd);
        $data['kode_document'] = "A0";
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
        // $data['data_pasien']= $this->M_emedrec_iri->get_data_pasien($cm);
        $data['pasien_iri'] = $this->M_emedrec->get_data_pasien_iri_bynoregasal($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('tata_tertib_v2')->row();
        // $data['serah_terima'] = $data_serah_terima;
        // var_dump($data['data_pasien']);
        $this->load->view('emedrec/ri/tata_tertib/tata_tertib_v2', $data);
    }


    public function asuhan_gizi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asuhan_gizi')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $no_reg_asal = isset($data['data_pasien'][0]->noregasal) ? $data['data_pasien'][0]->noregasal : '';
        $data['asuhan_gizi'] = $this->M_emedrec_iri->get_asuhan_gizi($noipd)->row();
        $ttd_user = isset($data['asuhan_gizi']->xuser) ? $data['asuhan_gizi']->xuser : '';
        $data['diag_masuk'] = $this->M_emedrec_iri->get_diagnosa_masuk_ringkasan($no_reg_asal)->row();
        $data['ttd_user'] = $this->M_emedrec_iri->get_ttd_gizi($ttd_user)->row();
        $this->load->view('ri/asuhan_gizi/asuhan_gizi', $data);
    }

    public function assesment_gizi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('assesment_gizi')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['assesment_gizi'] = $this->M_emedrec_iri->get_assesment_gizi($noipd)->row();
        $ttd_user = $data['assesment_gizi']->id_pemeriksa ?? null;
        $data['ttd_user'] = $ttd_user ? $this->M_emedrec_iri->get_ttd_assesment_gizi($ttd_user)->row() : null;
        //  var_dump( $data['ttd_user']);

        // $data['assesment_awal_keperawatan'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);
        //  $data['kode_document'] = 'Rev.03.02.2020.RM-006g / RI';
        $this->load->view('ri/assesment_gizi/assesment_gizi', $data);
    }

    public function ceklis_pasien_mpp($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['ceklis'] = $this->M_emedrec_iri->get_ceklis_pasien_iri($noipd)->row();

        //  var_dump( $data['ttd_user']);

        // $data['assesment_awal_keperawatan'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);
        //  $data['kode_document'] = 'Rev.03.02.2020.RM-006g / RI';
        $this->load->view('ri/ceklis_pasien_mpp/ceklis_pasien_mpp', $data);
    }

    public function cetak_serah_terima_asuhan_pasien_iri($no_ipd = "", $noreglamaa = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $noreglama = $noreglamaa != "" ? $noreglamaa : $this->input->post('user_id_old');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_serah_terima_iri')->row();
        $no_reglama = $noreglama != "" ? $noreglama : $this->input->post('no_reglama');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noreg =  isset($data['data_pasien'][0]->noregasal) ? $data['data_pasien'][0]->noregasal : $data['data_pasien'][0]->no_register;
        $data['serah_terima'] = $this->M_emedrec_iri->get_serah_terima_iri($noipd, $noreg)->result();

        $this->load->view('emedrec/ri/formserahterima/serah_terima', $data);
    }



    public function rekonsiliasi_obat($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_document('rekonsiliasi_obat');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['rekonsiliasi_obat'] = $this->M_emedrec_iri->get_rekonsiliasi_obat($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rekonsiliasi_obat')->row();
        $this->load->view('emedrec/ri/rekonsiliasi_obat/rekonsiliasi_obat', $data);
    }

    public function daftar_pemberian_obat($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_document('daftar_pemberiatan_obat');
        $data['pemberian_obat'] = $this->M_emedrec_iri->get_pemberian_obat($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('dpo_iri')->row();
        $this->load->view('emedrec/ri/daftar_pemberian_obat/daftar_pemberian_obat', $data);
    }

    public function suket_dirawat($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_document('surat_keterangan');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($noipd)->row();
        $tgl_lahir =  $data['data_pasien'][0]->tgl_lahir;
        $id_dokter =  $data['data_pasien'][0]->id_dokter;
        date_default_timezone_set("Asia/Bangkok");
        $data['tgl_jam'] = date("d-m-Y H:i:s");
        $data['tgl'] = date("d-m-Y");
        $data['thn'] = (int)date('Y') - (int)date('Y', strtotime($tgl_lahir));
        $data['data_dokter'] = $this->M_emedrec_iri->getdata_dokter($id_dokter)->row();

        $this->load->view('emedrec/ri/suket/suket_dirawat', $data);
    }

    public function suket_meninggal($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('suket_meninggal')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($noipd)->row();
        $tgl_lahir =  $data['data_pasien'][0]->tgl_lahir;
        $id_dokter =  $data['data_pasien'][0]->id_dokter;
        $tgl_meninggal = isset($data['data_pasien'][0]->tgl_meninggal) ? $data['data_pasien'][0]->tgl_meninggal : '';
        $hari =  date('D', strtotime($tgl_meninggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $data['meninggal'] = $dayList[$hari];
        date_default_timezone_set("Asia/Bangkok");
        $data['tgl_jam'] = date("d-m-Y H:i:s");
        $data['tgl'] = date("d-m-Y");
        $data['thn'] = (int)date('Y') - (int)date('Y', strtotime($tgl_lahir));
        $data['data_dokter'] = $this->rjmpelayanan->getdata_dokter_for_suket_meninggal($id_dokter)->row();
        if ($data['data_pasien'][0]->tgl_meninggal == null) {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        } else {
            $this->load->view('emedrec/ri/suket/suket_meninggal', $data);
        }
    }



    public function laporan_persalinan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['data_laporan_persalinan'] = $this->M_emedrec_iri->get_laporan_persalinan($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('laporan_persalinan')->row();

        $this->load->view('emedrec/ri/laporan_persalinan/laporan_persalinan', $data);
    }

    public function catatan_medis_awal_bidan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('awal_medis_bidan')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($noipd)->row();

        $this->load->view('emedrec/ri/catatan_medis_awal_kebidanan/catatan_medis_awal_kebidanan', $data);
    }

    public function catatan_persalinan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_persalinan')->row();
        $data['catatan_persalinan'] = $this->M_emedrec_iri->get_catatan_persalinan($noipd);
        $this->load->view('emedrec/ri/catatan_persalinan/catatan_persalinan', $data);
    }

    public function assesment_awal_kebidanan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_bidan_ri')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['assesment_awal_keperawatan_iri'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);

        $this->load->view('emedrec/ri/assesment_awal_bidan/assesment_awal_bidan', $data);
    }

    public function assesment_awal_bayi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_neonatus_ri')->row();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        // $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['assesment_awal_keperawatan_iri'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);

        $this->load->view('emedrec/ri/assesment_awal_keperawatan_bayi/assesment_keperawatan_bayi', $data);
    }


    public function cetak_surat_elektromedik_iri_all()
    {
        $data['no_cm'] = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $no_ipd = $this->input->post('user_id');
        $cm = $this->input->post('no_cm');

        $null = $this->M_emedrec_iri->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all($medrec);
        if ($null != null) {
            date_default_timezone_set("Asia/Jakarta");
            $data['tgl_jam'] = date("d-m-Y H:i:s");
            $data['tgl'] = date("d F Y");
            $data['no_register'] =  $no_ipd;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            // $data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['pemeriksaan_elektromedik'] = $this->M_emedrec_iri->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all($medrec);
            // var_dump($data['pemeriksaan_elektromedik']);
            // die();
            // $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();

            // $nama_dokter_reffering = $this->M_emedrec->get_nama_dokter($data['data_daftar_ulang']->id_dokter)->row()->nm_dokter;			
            // $data['nama_dokter_reffering'] = $nama_dokter_reffering;
            // $nipeg_dok = isset($data['data_daftar_ulang']->id_dokter)?$data['data_daftar_ulang']->id_dokter:'';
            // $data['nipeg_dokter'] = isset($nipeg_dok)?$this->M_emedrec->data_nipeg_by_id($nipeg_dok)->row():"";
            // // var_dump($data['nipeg_dokter']);
            // $nama_poli = $this->M_emedrec->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;			
            // $data['nama_poli'] = $nama_poli;

            // if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
            //     $data['kontraktor'] = 'BPJS';
            // }elseif($data['data_daftar_ulang']->cara_bayar == 'UMUM'){
            //     $data['kontraktor'] = '';
            // }else{
            //     $nama_kontraktor = $this->M_emedrec->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row()->nmkontraktor;
            //     $data['kontraktor'] = $nama_kontraktor;
            // }

            // if ($data['data_daftar_ulang']->diagnosa == null) {
            //     $data['diagnosa'] = '';    
            // }else{
            //     $nama_diagnosa = $this->M_emedrec->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;        
            //     $data['diagnosa'] = $nama_diagnosa;
            // }


            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/ri/cetak_elektromedik_iri_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('ri/cetak_elektromedik_iri', $data);    
        } else {
            $success =     '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3>Tidak Bisa Melihat Elektromedik.Dikarenakan Belum Ada Pemeriksaan
								</div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_elektromedik_all()
    {
        $data['no_cm'] = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $no_ipd = $this->input->post('user_id');
        $cm = $this->input->post('no_cm');

        $null = $this->M_emedrec_iri->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($medrec);
        if ($null != null) {
            date_default_timezone_set("Asia/Jakarta");
            $data['tgl_jam'] = date("d-m-Y H:i:s");
            $data['tgl'] = date("d F Y");
            $data['no_register'] =  $no_ipd;
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            // $data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['pemeriksaan_elektromedik'] = $this->M_emedrec_iri->get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($medrec);
            //$no_em = $data['pemeriksaan_elektromedik']->no_em;
            // var_dump($data['pemeriksaan_elektromedik']);
            // die();
            // $data['data_daftar_ulang'] = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_reg)->row();
            //$data['data_hasil_em']=$this->emmdaftar->get_data_hasil_em($no_em)->result();
            //$data['data_hasil_em2']=$this->emmdaftar->get_data_hasil_em($no_em)->result();
            // $nama_dokter_reffering = $this->M_emedrec->get_nama_dokter($data['data_daftar_ulang']->id_dokter)->row()->nm_dokter;			
            // $data['nama_dokter_reffering'] = $nama_dokter_reffering;
            // $nipeg_dok = isset($data['data_daftar_ulang']->id_dokter)?$data['data_daftar_ulang']->id_dokter:'';
            // $data['nipeg_dokter'] = isset($nipeg_dok)?$this->M_emedrec->data_nipeg_by_id($nipeg_dok)->row():"";
            // // var_dump($data['nipeg_dokter']);
            // $nama_poli = $this->M_emedrec->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;			
            // $data['nama_poli'] = $nama_poli;

            // if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
            //     $data['kontraktor'] = 'BPJS';
            // }elseif($data['data_daftar_ulang']->cara_bayar == 'UMUM'){
            //     $data['kontraktor'] = '';
            // }else{
            //     $nama_kontraktor = $this->M_emedrec->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row()->nmkontraktor;
            //     $data['kontraktor'] = $nama_kontraktor;
            // }

            // if ($data['data_daftar_ulang']->diagnosa == null) {
            //     $data['diagnosa'] = '';    
            // }else{
            //     $nama_diagnosa = $this->M_emedrec->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;        
            //     $data['diagnosa'] = $nama_diagnosa;
            // }


            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/ri/cetak_elektromedik_all', $data, true);
            //$this->mpdf->AddPage('L'); 
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            // $this->load->view('ri/cetak_elektromedik_iri', $data);    
        } else {
            $success =     '<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3>Tidak Bisa Melihat Elektromedik.Dikarenakan Belum Ada Pemeriksaan
								</div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_laboratorium_iri_all()
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $no_ipd = $this->input->post('user_id');

        $data_lab =  $this->M_emedrec->get_noreg_pemeriksaan_lab($medrec)->result();

        if ($data_lab != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
            $data['tgl'] = date("d-m-Y");
            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();

            $data['medrec'] = $this->M_emedrec_iri->get_noreg_pemeriksaan_lab($medrec)->result();
            // $data['register'] = $this->M_emedrec_iri->get_nolab_pemeriksaan_lab($no_ipd)->result();

            $data['get_umur'] = $this->rjmregistrasi->get_umur($medrec)->result(); #
            foreach ($data['get_umur'] as $row) {
                $data['tahun'] = $row->umurday;
            }
            $data['usia'] = date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
            // $data['usia']=date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
            $data['hasil_pemeriksaan_lab'] =  isset($no_ipd) ? $this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result() : "";

            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/ri/cetak_laboratorium_iri_all', $data, true);
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
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function cetak_surat_radiologi_iri_all()
    {
        $cm = $this->input->post('no_cm');
        $medrec = $this->input->post('no_medrec');
        $noipd = $this->input->post('user_id');
        $cek_rad_iri = $noipd ? $this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result() : "";

        // $data['hasil_pemeriksaan_radiologi']= $noipd?$this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_iri($noipd)->result():"";

        $data_rad = $this->M_emedrec->getdata_hasil_pemeriksaan_radiologi_all($medrec)->result();

        if ($data_rad != null) {

            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;

            $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($noipd)->row();
            $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($noipd)->row();

            $data_umum_rad = $this->M_emedrec_iri->getdata_hasil_pemeriksaan_radiologi_all($medrec)->result();
            $data['hasil_pemeriksaan_radiologi'] = $data_umum_rad;

            $data['kode_document'] = '';

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $html = $this->load->view('emedrec/ri/cetak_radiologi_iri_all', $data, true);
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

    public function cetak_formulir_transfer_antar_ruangan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $noregold = $this->input->post('user_id_old');

        $transfer_ruangan = $this->M_emedrec->get_formulir_transfer_ruangan($noipd)->result();
        if ($this->input->get('noreg_old') != '') {
            $transfer_ruangan = $this->M_emedrec->get_formulir_transfer_ruangan_ranap_rajal($noipd, ($this->input->get('akses_luar') == 'true' ? $noregold : $this->input->get('noreg_old')))->result();
        }
        // echo '<pre>';
        // var_dump($transfer_ruangan);
        // echo '</pre>';
        // die();
        if ($transfer_ruangan != null) {

            $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('transfer_ruangan')->row();
            $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
            $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
            $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
            $data['ttd_dokter_pengirim'] = $this->M_emedrec->get_only_dokter_igd($noregold);
            $data['data_all'] = $this->M_emedrec_iri->data_pasien($noipd)->row();
            // var_dump($data['data_rawat_darurat']);die();
            $data['transfer_ruangan'] = $transfer_ruangan;
            // var_dump($data['transfer_ruangan']);die();
            $this->load->view('emedrec/ri/form_antar_ruangan/antar_ruangan', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }


    public function add_penunjang_resume_medis_iri()
    {
        $no_ipd = $this->input->post('no_ipd');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";

        //7,8,9        
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->result();
        // var_dump($data['pasien']->ttd_dpjp);
        // die();

        $noregasal = $data['pasien']->noregasal;
        $id_poli = $this->M_emedrec_iri->get_poli($noregasal)->row()->id_poli;
        $data['id_poli'] = $id_poli;

        //1
        $riwayat_penyakit = $this->M_emedrec_iri->get_riwayat_penyakit($noregasal, $id_poli)->row();


        //2
        $fisik = $this->M_emedrec_iri->get_fisik_igd($noregasal)->row();
        $data['fisik'] = $fisik->objective_perawat;
        $data['riwayat_penyakit'] = $fisik->subjective_perawat;

        //3
        $emnya = $this->input->post('jumlah_em[]');
        $get_em = $this->M_emedrec_iri->get_data_em_query($no_ipd)->result_array();
        if ($emnya) {
            foreach ($get_em as $value_em) {
                foreach ($emnya as $pembanding_em) {
                    if ($pembanding_em == $value_em['id_pemeriksaan_em']) {
                        $em_jenis_tindakan[] = $value_em['jenis_tindakan'];
                        $em_id_tindakan[] = $value_em['id_tindakan'];
                    }
                }
            }
            $em_rows = count($emnya);
        } else {
            $em_jenis_tindakan[] = array();
            $em_id_tindakan[] = array();
            $em_rows = 0;
        }

        $radnya = $this->input->post('jumlah_rad[]');
        $get_rad = $this->M_emedrec_iri->get_data_rad_query($no_ipd)->result_array();
        if ($radnya) {
            foreach ($get_rad as $value_rad) {
                foreach ($radnya as $pembanding_rad) {
                    if ($pembanding_rad == $value_rad['id_pemeriksaan_rad']) {
                        $rad_jenis_tindakan[] = $value_rad['jenis_tindakan'];
                        $rad_id_tindakan[] = $value_rad['id_tindakan'];
                    }
                }
            }
            $rad_rows = count($radnya);
        } else {
            $rad_jenis_tindakan[] = array();
            $rad_id_tindakan[] = array();
            $rad_rows = 0;
        }

        $labnya = $this->input->post('jumlah_lab[]');
        $get_lab = $this->M_emedrec_iri->get_data_lab_query($no_ipd)->result_array();
        $hasil_lab = array();
        if ($labnya) {
            foreach ($get_lab as $value_lab) {
                foreach ($labnya as $pembanding_lab) {
                    if ($pembanding_lab == $value_lab['id_pemeriksaan_lab']) {
                        $lab_jenis_tindakan[] = $value_lab['jenis_tindakan'];
                        $lab_id_tindakan[] = $value_lab['id_tindakan'];
                        $lab_no_register[] = $value_lab['no_register'];
                    }
                }
            }
            $lab_rows = count($labnya);
        } else {
            $lab_jenis_tindakan[] = array();
            $lab_id_tindakan[] = array();
            $lab_no_register[] = array();
            $lab_rows = 0;
        }

        if ($id_poli != NULL) {
            $emnya_igd = $this->input->post('jumlah_em_igd[]');
            $get_em_igd = $this->M_emedrec_iri->get_data_em_query($noregasal)->result_array();
            if ($emnya_igd) {
                foreach ($get_em_igd as $value_em_igd) {
                    foreach ($emnya_igd as $pembanding_em_igd) {
                        if ($pembanding_em_igd == $value_em_igd['id_pemeriksaan_em']) {
                            $em_jenis_tindakan_igd[] = $value_em_igd['jenis_tindakan'];
                            $em_id_tindakan_igd[] = $value_em_igd['id_tindakan'];
                        }
                    }
                }
                $em_rows_igd = count($emnya_igd);
            } else {
                $em_jenis_tindakan_igd[] = array();
                $em_id_tindakan_igd[] = array();
                $em_rows_igd = 0;
            }

            $radnya_igd = $this->input->post('jumlah_rad_igd[]');
            $get_rad_igd = $this->M_emedrec_iri->get_data_rad_query($noregasal)->result_array();
            if ($radnya_igd) {
                foreach ($get_rad_igd as $value_rad_igd) {
                    foreach ($radnya_igd as $pembanding_rad_igd) {
                        if ($pembanding_rad_igd == $value_rad_igd['id_pemeriksaan_rad']) {
                            $rad_jenis_tindakan_igd[] = $value_rad_igd['jenis_tindakan'];
                            $rad_id_tindakan_igd[] = $value_rad_igd['id_tindakan'];
                        }
                    }
                }
                $rad_rows_igd = count($radnya_igd);
            } else {
                $rad_jenis_tindakan_igd[] = array();
                $rad_id_tindakan_igd[] = array();
                $rad_rows_igd = 0;
            }

            $labnya_igd = $this->input->post('jumlah_lab_igd[]');
            $get_lab_igd = $this->M_emedrec_iri->get_data_lab_query($noregasal)->result_array();
            $hasil_lab_igd = array();
            if ($labnya_igd) {
                foreach ($get_lab_igd as $value_lab_igd) {
                    foreach ($labnya_igd as $pembanding_lab_igd) {
                        if ($pembanding_lab_igd == $value_lab_igd['id_pemeriksaan_lab']) {
                            $lab_jenis_tindakan_igd[] = $value_lab_igd['jenis_tindakan'];
                            $lab_id_tindakan_igd[] = $value_lab_igd['id_tindakan'];
                            $lab_no_register_igd[] = $value_lab_igd['no_register'];
                        }
                    }
                }
                $lab_rows_igd = count($labnya_igd);
            } else {
                $lab_jenis_tindakan_igd[] = array();
                $lab_id_tindakan_igd[] = array();
                $lab_no_register_igd[] = array();
                $lab_rows_igd = 0;
            }
        } else {
        }

        $tidak_ada[] = array("Tidak Ada Pemeriksaan");

        $tampung = array();
        $hasil_lab = array();

        $tampung[] = '•Rawat Inap';
        if ($rad_rows != 0) {
            for ($i = 0; $i < $rad_rows; $i++) {
                $tampung[] = '<br>' . 'Radiologi :' . $rad_jenis_tindakan[$i] . ' (' . $rad_id_tindakan[$i] . ')';
            }
        } else {
        }

        if ($em_rows != 0) {
            for ($i = 0; $i < $em_rows; $i++) {
                $tampung[] = '<br>' . 'Elektromedik :' . $em_jenis_tindakan[$i] . ' (' . $em_id_tindakan[$i] . ')';
            }
        } else {
        }

        if ($lab_rows != 0) {
            for ($i = 0; $i < $lab_rows; $i++) {
                $tampung[] = '<br>' . 'Laboratorium :' . $lab_jenis_tindakan[$i] . ' (' . $lab_id_tindakan[$i] . ')';
                $hasil_lab = $this->M_emedrec_iri->get_hasil_lab_for_resume($lab_no_register[$i], $lab_id_tindakan[$i])->result();
                $hasil_lab_rows = count($hasil_lab);
                // for ($x=0; $x < $hasil_lab_rows ; $x++) {           
                foreach ($hasil_lab as $key) {
                    $tampung[] = $key->jenis_hasil . ', Hasil : ' . $key->hasil_lab . ' Kadar Normal : ' . $key->kadar_normal . $key->satuan . '<br>';
                }
                // }
            }
        } else {
            $hasil_lab_rows = 0;
        }

        // var_dump($tampung);   
        // die();


        if ($id_poli != NULL) {
            $tampung[] = '<br>•Instalasi Gawat Darurat';
            if ($rad_rows_igd != 0) {
                for ($i = 0; $i < $rad_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Radiologi :' . $rad_jenis_tindakan_igd[$i] . ' (' . $rad_id_tindakan_igd[$i] . ')';
                }
            } else {
            }

            if ($em_rows_igd != 0) {
                for ($i = 0; $i < $em_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Elektromedik :' . $em_jenis_tindakan_igd[$i] . ' (' . $em_id_tindakan_igd[$i] . ')';
                }
            } else {
            }

            if ($lab_rows_igd != 0) {
                for ($i = 0; $i < $lab_rows_igd; $i++) {
                    $tampung[] = '<br>' . 'Laboratorium :' . $lab_jenis_tindakan_igd[$i] . ' (' . $lab_id_tindakan_igd[$i] . ')';
                    $hasil_lab_igd = $this->M_emedrec_iri->get_hasil_lab_for_resume($lab_no_register_igd[$i], $lab_id_tindakan_igd[$i])->result();
                    $hasil_lab_rows_igd = count($hasil_lab_igd);
                    // for ($x=0; $x < $hasil_lab_rows_igd ; $x++) {           
                    foreach ($hasil_lab_igd as $key) {
                        $tampung[] = $key->jenis_hasil . ', Hasil : ' . $key->hasil_lab . ' Kadar Normal : ' . $key->kadar_normal . $key->satuan . '<br>';
                    }
                    // }
                }
            } else {
                $hasil_lab_rows_igd = 0;
            }

            // if($hasil_lab_rows_igd != 0){
            //     for ($i=0; $i < $hasil_lab_rows_igd ; $i++) { 		
            //         foreach ($hasil_lab_igd[$i] as $key) {
            //             $hasil_lab_jenis_hasil_igd[] = $key->jenis_hasil;
            //             $hasil_lab_hasil_lab_igd[] = $key->hasil_lab;
            //             $hasil_lab_kadar_normal_igd[] = $key->kadar_normal;
            //             $hasil_lab_satuan_igd[] = $key->satuan;
            //             $hasil_lab_jenis_tindakan_igd[] = $key->jenis_hasil;
            //             $hasil_lab_id_tindakan_igd[] = $key->id_tindakan;
            //             $tampung[] = '<br>('.$hasil_lab_id_tindakan_igd[$i].') Jenis Hasil : '.$hasil_lab_jenis_hasil_igd[$i].' Hasil : '.$hasil_lab_hasil_lab_igd[$i].' ,Kadar Normal : '.$hasil_lab_kadar_normal_igd[$i].$hasil_lab_satuan_igd[$i].'<br>';
            //         }

            //     }
            // }else{}

        } else {
        }


        $gabung = implode($tampung);
        $rest['penemuan_klinik'] = $gabung;
        // $rest['riwayat_penyakit'] = $data['riwayat_penyakit']['riwayat_kesehatan'];
        $rest['riwayat_penyakit'] = $data['riwayat_penyakit'];
        $rest['pemeriksaan_fisik'] = $data['fisik'];
        $rows = $this->rimtindakan->get_data_resume($no_ipd)->row();

        if ($rows == FALSE) {
            $rest['no_ipd'] = $no_ipd;
            $this->M_emedrec_iri->insert_data_resume($rest);
            //INSERT
        } else {
            $this->M_emedrec_iri->update_data_resume($no_ipd, $rest);
            // UPDATE
        }


        //add resume

        $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($no_ipd)->row();
        $data['pemeriksaan_fisik_ri'] = $this->M_emedrec_iri->pemeriksaan_fisik_ri($no_ipd)->row();

        $nipeg = isset($data['pasien']->dokter) ? $data['pasien']->dokter : '';
        $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;

        // $mpdf = new \Mpdf\Mpdf(['orientation' => 'P','debug' => true]); 
        // $mpdf->showImageErrors = true;
        // $mpdf->curlAllowUnsafeSslRequests = true;		
        // $html = $this->load->view('emedrec/ri/resume_medis_iri',$data,true);
        // //$this->mpdf->AddPage('L'); 
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        redirect('iri/rictindakan/form/resume/' . $no_ipd);
    }


    public function add_obat_resume_medis_iri()
    {
        $no_ipd = $this->input->post('no_ipd');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";

        //7,8,9        
        $data['pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_pasien_by_no_ipd_for_resume($no_ipd)->result();
        // var_dump($data['pasien']->ttd_dpjp);
        // die();

        $noregasal = $data['pasien']->noregasal;
        $id_poli = $this->M_emedrec_iri->get_poli($noregasal)->row()->id_poli;
        $data['id_poli'] = $id_poli;

        //1
        $riwayat_penyakit = $this->M_emedrec_iri->get_riwayat_penyakit_igd($noregasal)->row();
        //$data['riwayat_penyakit'] = json_decode($riwayat_penyakit->formjson, TRUE);

        //2
        $fisik = $this->M_emedrec_iri->get_fisik_igd($noregasal)->row();
        //var_dump($fisik);die();
        $data['fisik'] = $fisik->objective_perawat;
        $data['riwayat_penyakit'] = $fisik->subjective_perawat;

        //3
        $resrnyad = $this->input->post('jumlah_resep[]');
        $get_resrsdfgbf = $this->M_emedrec_iri->get_data_resrp_query($no_ipd)->result_array();
        if ($resrnyad) {
            foreach ($get_resrsdfgbf as $value_resrfs) {
                foreach ($resrnyad as $pembanding_em) {
                    if ($pembanding_em == $value_resrfs['id_resep_pasien']) {
                        $nama_obat[] = $value_resrfs['nama_obat'];
                        $signa[] = $value_resrfs['signa'];
                    }
                }
            }
            $serdfvd_rows = count($resrnyad);
        } else {
            $nama_obat[] = array();
            $signa[] = array();
            $serdfvd_rows = 0;
        }

        if ($id_poli == 'BA00') {
            $werersfd_igd = $this->input->post('jumlah_resep_igd[]');
            $get_resfd_igd = $this->M_emedrec_iri->get_data_em_query($noregasal)->result_array();
            if ($werersfd_igd) {
                foreach ($get_resfd_igd as $value_resgssdfbf_igd) {
                    foreach ($werersfd_igd as $pembanding_em_igd) {
                        if ($pembanding_em_igd == $value_resgssdfbf_igd['id_resep_pasien']) {
                            $nama_oba_ghsdgdt[] = $value_resgssdfbf_igd['nama_obat'];
                            $signa_igdvssd[] = $value_resgssdfbf_igd['signa'];
                        }
                    }
                }
                $resdfdbhfdzdvx_igd = count($werersfd_igd);
            } else {
                $nama_oba_ghsdgdt[] = array();
                $signa_igdvssd[] = array();
                $resdfdbhfdzdvx_igd = 0;
            }
        } else {
        }

        $tidak_ada[] = array("Tidak Ada Pemeriksaan");

        $tampung = array();

        $tampung[] = '•Rawat Inap';
        if ($serdfvd_rows != 0) {
            for ($i = 0; $i < $serdfvd_rows; $i++) {
                $tampung[] = '<br>' . $nama_obat[$i] . ' (' . $signa[$i] . ')<br>';
            }
        } else {
        }

        if ($id_poli == 'BA00') {
            $tampung[] = '<br>•Instalasi Gawat Darurat';
            if ($resdfdbhfdzdvx_igd != 0) {
                for ($i = 0; $i < $resdfdbhfdzdvx_igd; $i++) {
                    $tampung[] = '<br>' . $nama_oba_ghsdgdt[$i] . ' (' . $signa_igdvssd[$i] . ')<br>';
                }
            } else {
            }
        } else {
        }


        $gabung = implode($tampung);

        $rest['pengobatan'] = $gabung;
        //$rest['riwayat_penyakit'] = $data['riwayat_penyakit']['riwayat_kesehatan'];
        $rest['riwayat_penyakit'] = $data['riwayat_penyakit'];
        // var_dump($rest['riwayat_penyakit']);die();
        $rest['pemeriksaan_fisik'] = $data['fisik'];
        $rows = $this->rimtindakan->get_data_resume($no_ipd)->row();

        if ($rows == FALSE) {
            $rest['no_ipd'] = $no_ipd;
            $this->M_emedrec_iri->insert_data_resume($rest);
            //INSERT
        } else {
            $this->M_emedrec_iri->update_data_resume($no_ipd, $rest);
            // UPDATE
        }


        //add resume

        $data['assesment_medis'] = $this->M_emedrec_iri->get_assesment_medis_bynoipd($no_ipd)->row();
        $data['pemeriksaan_fisik_ri'] = $this->M_emedrec_iri->pemeriksaan_fisik_ri($no_ipd)->row();

        $nipeg = isset($data['pasien']->dokter) ? $data['pasien']->dokter : '';
        $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;

        // $mpdf = new \Mpdf\Mpdf(['orientation' => 'P','debug' => true]); 
        // $mpdf->showImageErrors = true;
        // $mpdf->curlAllowUnsafeSslRequests = true;		
        // $html = $this->load->view('emedrec/ri/resume_medis_iri',$data,true);
        // //$this->mpdf->AddPage('L'); 
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        redirect('iri/rictindakan/index/' . $no_ipd);
    }

    public function cetak_intruksi_obat($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        // var_dump($cm);die();
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $no_ipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        // $cm=$this->input->post('no_cm');
        // $no_ipd=$this->input->post('user_id');
        // $medrec=$this->input->post('no_medrec');
        $intruksi_obat = $this->M_emedrec_iri->get_intruksi_obat($no_ipd)->result();

        // if($intruksi_obat != null){

        // $data['kode_document'] = $this->M_emedrec->get_kode_document('triase');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
        $data['intruksi_obat'] = $intruksi_obat;

        $data['kio'] = $this->M_emedrec_iri->get_kio($no_ipd)->result();
        // var_dump($data['kio']);die();
        $etst = array();
        foreach ($data['kio'] as $rows) {
            $etst[] = $rows->formjson;
        }
        $json = array();
        for ($i = 0; $i < count($etst); $i++) {
            $json[] = json_decode($etst[$i])->matriks_resep_obat[0]->question2;
        }

        $json2 = json_decode(json_encode($json));
        for ($j = 0; $j < count($json2); $j++) {
            $json3 =  $json2[$j];
            //    var_dump($json3[$j]);
            for ($k = 0; $k < count($json3); $k++) {
                $gsd[] = isset($json3[$k]->nama_obat) ? json_decode(json_encode($json3[$k]->nama_obat)) : 0;
            }
        }
        $data['nama_kio'] = $gsd;
        // die();
        $data['pasien_kio'] = $this->M_emedrec_iri->data_pasien_kio($no_ipd)->result();
        $data['bln_kio'] = $this->M_emedrec_iri->bln_kio($no_ipd)->result();
        $data['tgl_kio'] = $this->M_emedrec_iri->tgl_kio($no_ipd)->result();

        $data['obat_kio'] = $this->M_emedrec_iri->obat_kio($no_ipd)->result();
        // var_dump($data['intruksi_obat']);die();

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('emedrec/ri/intruksi_obat/intruksi_obat', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        // $this->load->view('emedrec/ri/intruksi_obat/intruksi_obat',$data);

        // }else{
        //     $success = 	'<div class="alert alert-danger">
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        //     <h3>Tidak Ada Pemeriksaan
        //     </div>';
        //     $this->session->set_flashdata('success_msg', $success);
        //     redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
        // }
    }


    public function surat_pernyatan_selisih_tarif($no_ipd = "", $noregasal = "", $nomedrec = "")
    {
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $no_regasal = $noregasal != "" ? $noregasal : $this->input->post('noregasal');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        // $data['kode_document'] = "RM-001e / RI";
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec->get_data_pasien_by_no_cm($medrec)->result();
        $data['selisih_tarif'] = $this->M_emedrec_iri->get_data_selisih_tarif($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('selisih_tarif_v2')->row();
        $this->load->view('emedrec/ri/selisih_tarif/selisih_tarif', $data);
    }


    public function tindakan_keperawatan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['tind_kep'] = $this->M_emedrec_iri->get_tindakan_keperawatan($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('tindakan_keperawatan')->row();

        $this->load->view('emedrec/ri/tindakan_keperawatan/tind_keperawatan', $data);
    }

    public function persetujuan_anestesi_sedasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['persetujuan_anestesi_sedasi'] = $this->M_emedrec_iri->get_persetujuan_anestesi_sedasi($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('persetujuan_anestesi_sedasi')->row();

        $this->load->view('emedrec/ri/persetujuan_anestesi_sedasi/persetujuan_sedasi_anestesi', $data);
    }

    public function catatan_medis_awal_neonatus($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('medis_neonatus')->row();
        $data['neonatus'] = $this->M_emedrec_iri->get_catatan_medis_awal_neonatus($noipd);
        $this->load->view('emedrec/ri/catatan_medis_neonatus/catatan_medis_awal_neonatus', $data);
    }

    public function geriatri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('awal_medis_geriatri')->row();
        $data['geriatri'] = $this->M_emedrec_iri->get_geriatri($noipd);
        $this->load->view('emedrec/ri/geriatri/geriatri', $data);
    }

    public function persalinan_normal($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();

        $data['persalinan_normal'] = $this->M_emedrec_iri->get_persalinan_normal($noipd);
        $this->load->view('emedrec/ri/persalinan_normal/persalinan_normal', $data);
    }

    public function asuhan_keperawatan_perioperatif($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal =  $data['data_pasien'][0]->noregasal;
        $data['asuhan_keperawatan'] = $this->M_emedrec_iri->get_asuhan_keperawatan_perioperatif($noipd, $noregasal);
        $this->load->view('emedrec/ri/asuhan_keperawatan_perioperatif/asuhan_keperawatan_perioperatif', $data);
    }

    public function catatan_observasi_khusus($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();

        $data['catatan_observasi'] = $this->M_emedrec_iri->get_catatan_observasi_khusus($noipd);
        $this->load->view('emedrec/ri/catatan_observasi_khusus/catatan_observasi_khusus', $data);
    }

    public function asesmen_ulang_jatuh_dewasa($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['jatuh_dewasa'] = $this->M_emedrec_iri->get_asesmen_jatuh_dewasa($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_ulang_resiko_jatuh')->row();
        $this->load->view('emedrec/ri/asesmen_jatuh_dewasa/assesment_resiko_jatuh_dewasa', $data);
    }

    public function monitor_asesmen_jatuh_anak($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_resiko_jatuh_anak')->row();
        $data['jatuh_anak'] = $this->M_emedrec_iri->get_monitor_asesmen_jatuh_anak($noipd);
        $this->load->view('emedrec/ri/monitor_asesmen_jatuh_anak/assesment_resiko_jatuh_anak', $data);
    }

    public function asesmen_kebidanan_ginekologi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kebidanan_ginekologi'] = $this->M_emedrec_iri->get_asesmen_ginekologi_kebidanan($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('kebidanan_ginekologi')->row();
        $this->load->view('emedrec/ri/asesmen_kebidanan_ginekologi/assesment_awal_bidan_ginekologi', $data);
    }

    public function pengkajian_resiko_jatuh_anak($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();

        $data['pengkajian_jatuh_anak'] = $this->M_emedrec_iri->get_pengkajian_jatuh_anak($noipd);
        $this->load->view('emedrec/ri/pengkajian_resiko_jatuh_anak/pengkajian_resiko_jatuh_anak', $data);
    }

    public function skrining_gizi_anak_lanjut($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_gizi_anak')->row();
        $data['skrining'] = $this->M_emedrec_iri->get_skrining_gizi_anak_lanjut($noipd);
        $this->load->view('emedrec/ri/skrining_gizi_anak_lanjut/v_skrining_gizi_anak_lanjut', $data);
    }

    public function monitoring_asesmen_nyeri_dewasa($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_ulang_nyeri_dewasa')->row();
        $data['asesmen_nyeri_dewasa'] = $this->M_emedrec_iri->get_monitoring_asesmen_nyeri_dewasa($noipd);
        $this->load->view('emedrec/ri/monitoring_asesmen_nyeri_dewasa/v_asesmen_nyeri_dewasa', $data);
    }

    public function pengkajian_nyeri_komprehensif($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['komprehensif'] = $this->M_emedrec_iri->get_pengkajian_nyeri_komprehensif($noipd);
        $this->load->view('emedrec/ri/pengkajian_nyeri_komprehensif/v_pengkajian_nyeri_komprehensif', $data);
    }

    public function persetujuan_tindakan_kedokteran($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['persetujuan_kedokteran'] = $this->M_emedrec_iri->get_persetujuan_kedokteran($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('persetujuan_tindakan_dokter')->row();
        $this->load->view('emedrec/ri/persetujuan_kedokteran/v_persetujuan_tindakan_dokter', $data);
    }

    public function penolakan_tindakan_kedokteran($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['penolakan_kedokteran'] = $this->M_emedrec_iri->get_penolakan_kedokteran($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('penolakan_tindakan_kedokteran')->row();
        $this->load->view('emedrec/ri/penolakan_kedokteran/v_penolakan_tindakan_dokter', $data);
    }

    public function edukasi_anestesi_sedasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['edukasi'] = $this->M_emedrec_iri->get_edukasi_anestesi($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_anestesi_sedasi')->row();
        $this->load->view('emedrec/ri/edukasi_anestesi_sedasi/v_edukasi_anestesi_sedasi', $data);
    }

    public function status_sedasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['sedasi'] = $this->M_emedrec_iri->get_status_sedasi($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('status_sedasi')->row();
        $data['stat_sedasi_grafik_pemantauan'] = $this->M_emedrec_iri->stat_sedasi_grafik_pemantauan($noipd);
        $data['no_reg'] = $no_ipd;
        $this->load->view('emedrec/ri/status_sedasi/v_status_sedasi', $data);
    }

    public function checklist_keselamatan_operasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal = $data['data_pasien'][0]->noregasal;
        $idok = $this->M_emedrec_iri->get_id_ok($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('checklist_keselamatan_pasien_operasi')->row();
        //    var_dump($idok != null);die();
        if ($idok) {
            $data['id_ok'] = isset($idok) ? $idok->idoperasi_header : null;
            $aness = $this->M_emedrec_iri->get_id_ok2($noipd)->perawat_anastesi;
            //  var_dump($data['id_ok']);die();
            $data['anes'] = isset($aness) ? $aness : '';
            // var_dump($data['anes']);die();
            // $data['sek'] = $this->M_emedrec_iri->get_id_ok($noipd)->perawat_sek;
            $data['checklist_keselamatan_operasi'] = $this->M_emedrec_iri->get_checklist_keselamatan_operasi($noipd, $noregasal);
            $this->load->view('emedrec/ri/checklist_keselamatan_operasi/checklist_keselamatan_pasien_operasi', $data);
        } else {
            $success =     '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        <h3>Tidak Ada Pemeriksaan
        </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $cm . '/' . $medrec);
        }
    }

    public function laporan_medik_dgn_lokal_anestesi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['lap_medik_lokal_anestesi'] = $this->M_emedrec_iri->get_lap_medik_lokal_anestesi($noipd);
        $this->load->view('emedrec/ri/lap_medik_dengan_lokal_anestesi/laporan_medik_lokal_anestesi', $data);
    }

    public function asuhan_keperawatan_pre_operatif($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['asuhan_preoperatif'] = $this->M_emedrec_iri->get_asuhan_keperawatan_pre_operatif($noipd);
        $this->load->view('emedrec/ri/asuhan_keperawatan_pre_operatif/v_asuhan_preoperatif', $data);
    }

    public function checklist_persiapan_operasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal = $data['data_pasien'][0]->noregasal;
        $data['persiapan_operasi'] = $this->M_emedrec_iri->get_checklist_persiapan_operasi($noipd, $noregasal);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('checklist_persiapan_operasi')->row();
        $this->load->view('emedrec/ri/checklist_persiapan_operasi/checklist_persiapan_operasi', $data);
    }

    public function lap_pembedahan_lokal_anestesi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['pembedahan_lokal_anestesi'] = $this->M_emedrec_iri->get_pembedahan_lokal_anestesi($noipd);
        $this->load->view('emedrec/ri/lap_pembedahan_lokal_anestesi/v_laporan_pembedahan_anestesi_lokal', $data);
    }

    public function daftar_pemberian_infus($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['infus'] = $this->M_emedrec_iri->get_pemberian_infus($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('daftar_pemberian_infus')->row();
        $this->load->view('emedrec/ri/daftar_pemberian_infus/daftar_pemberian_infus', $data);
    }

    public function assesment_pra_anestesi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal = isset($data['data_pasien'][0]->noregasal) ? $data['data_pasien'][0]->noregasal : '';
        $data['pra_anestesti'] = $this->M_emedrec_iri->get_pra_anestesi($noipd, $noregasal);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('assesment_pra_anestesi')->row();
        $this->load->view('emedrec/ri/assesment_pra_anestesi/assesment_pra_anestesi', $data);
    }

    public function surveilans($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['surveilans'] = $this->M_emedrec_iri->get_surveilans($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('surveilans')->row();
        $this->load->view('emedrec/ri/surveilans/v_surveilans', $data);
    }

    public function assesment_prasedasi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['prasedasi'] = $this->M_emedrec_iri->get_prasedasi($noipd);
        $this->load->view('emedrec/ri/assesment_prasedasi/assesment_prasedasi', $data);
    }

    public function laporan_anestesi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal = $data['data_pasien'][0]->noregasal;
        $data['lap_anestesi'] = $this->M_emedrec_iri->lap_anestesi($noipd, $noregasal);
        $data['id_dok_anes'] = $this->M_emedrec_iri->get_id_dok_anes($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('laporan_anestesi')->row();
        $data['lap_anestesi_grafik_pemantauan'] = $this->M_emedrec_iri->lap_anestesi_grafik_pemantauan($noipd, $noregasal);
        $data['no_reg'] = $no_ipd;
        $this->load->view('emedrec/ri/laporan_anestesi/v_laporan_anestesi', $data);
    }

    public function pengkajian_awal_rehab_medik($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['rehab_medik'] = $this->M_emedrec_iri->get_pengkajian_rehab_medik($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_awal_rehab_medik')->row();
        $this->load->view('emedrec/ri/pengkajian_awal_rehab_medik/pengkajian_awal_rehab_medik', $data);
    }

    public function pengkajian_awal_rehab_medik_anak($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['rehab_medik'] = $this->M_emedrec_iri->get_pengkajian_rehab_medik($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_awal_rehab_medik')->row();
        $this->load->view('emedrec/ri/pengkajian_awal_rehab_medik/pengkajian_rehab_medik_anak', $data);
    }

    public function site_marking($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['site_marking'] = $this->M_emedrec_iri->get_site_marking($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('site_marking')->row();
        $this->load->view('emedrec/ri/site_marking/v_site_marking', $data);
    }

    public function monitoring_asesmen_nyeri_anak($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('monitoring_asesmen_nyeri_anak_1sampai7thn')->row();
        $data['asesmen_nyeri_anak'] = $this->M_emedrec_iri->get_monitoring_asesmen_nyeri_dewasa($noipd);
        $this->load->view('emedrec/ri/monitoring_asesmen_nyeri_anak/v_asesmen_nyeri_anak', $data);
    }

    public function monitoring_asesmen_nyeri_tidak_sadar($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['nyeri_tidak_sadar'] = $this->M_emedrec_iri->get_monitoring_asesmen_nyeri_dewasa($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('monitoring_nyeri_pasien_tidak_sadar')->row();
        $this->load->view('emedrec/ri/monitoring_nyeri_pasien_tidak_sadar/nyeri_pasien_tidak_sadar', $data);
    }

    public function asesmen_resiko_dekubitus($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['resiko_dekubitus'] = $this->M_emedrec_iri->get_asesmen_resiko_kejadian_dekubitus($noipd);
        $data['dekubitus'] = $this->M_emedrec_iri->assesment_awal_keperawatan($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_ulang_resiko_kejadian_decubitus')->row();
        $this->load->view('emedrec/ri/asesmen_resiko_dekubitus/asesmen_resiko_dekubitus', $data);
    }

    public function lembar_observasi_harian($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_observasi_harian')->row();
        //$data['resiko_dekubitus'] = $this->M_emedrec_iri->get_asesmen_resiko_kejadian_dekubitus($noipd);
        //$data['observasi_harian'] = $this->M_emedrec_iri->get_observasi_harian($noipd);

        $pemeriksaan_fisik_iri = $this->M_emedrec_iri->get_pemeriksaan_fisik_iri($noipd);

        foreach ($pemeriksaan_fisik_iri as $itemv) {
            $tgl_pemeriksaan[] = date('j/n', strtotime($itemv->tanggal_pemeriksaan));
            $waktu_pemeriksaan[] = date('H:i', strtotime($itemv->tanggal_pemeriksaan));
            $chart_tgl[] = [date('j/n', strtotime($itemv->tanggal_pemeriksaan)), date('H:i', strtotime($itemv->tanggal_pemeriksaan))];
            $tekanan_darah[] = [$itemv->sitolic, $itemv->diatolic];
            $suhu[] = $itemv->suhu;
            $nadi[] = $itemv->nadi;
            $frekuensi_nafas[] = $itemv->frekuensi_nafas;
            $oksigen[] = $itemv->oksigen;
            $bb[] = $itemv->bb;
            $nama_pemeriksa[] = [$itemv->nama_pemeriksa, $itemv->ttd];
            $cvp[] = $itemv->cvp;
            $skala_norton[] = $itemv->skala_norton;
            $skala_nyeri[] = $itemv->skala_nyeri;
            $gcs_e[] = $itemv->gcs_e;
            $gcs_m[] = $itemv->gcs_m;
            $gcs_v[] = $itemv->gcs_v;
        }
        $data['pemeriksaan_fisik_iri'] = $pemeriksaan_fisik_iri;
        $data['tgl_pemeriksaan'] = (!empty($tgl_pemeriksaan)) ? $tgl_pemeriksaan : [];
        $data['waktu_pemeriksaan'] = (!empty($waktu_pemeriksaan)) ? $waktu_pemeriksaan : [];
        $data['chart_tgl'] = (!empty($chart_tgl)) ? $chart_tgl : [];
        $data['tekanan_darah'] = (!empty($tekanan_darah)) ? $tekanan_darah : [];
        $data['suhu'] = (!empty($suhu)) ? $suhu : [];
        $data['nadi'] = (!empty($nadi)) ? $nadi : [];
        $data['frekuensi_nafas'] = (!empty($frekuensi_nafas)) ? $frekuensi_nafas : [];
        $data['oksigen'] = (!empty($oksigen)) ? $oksigen : [];
        $data['bb'] = (!empty($bb)) ? $bb : [];
        $data['nama_pemeriksa'] = (!empty($nama_pemeriksa)) ? $nama_pemeriksa : [];
        $data['cvp'] = (!empty($cvp)) ? $cvp : [];
        $data['skala_norton'] = (!empty($skala_norton)) ? $skala_norton : [];
        $data['skala_nyeri'] = (!empty($skala_nyeri)) ? $skala_nyeri : [];
        $data['gcs_e'] = (!empty($gcs_e)) ? $gcs_e : [];
        $data['gcs_m'] = (!empty($gcs_m)) ? $gcs_m : [];
        $data['gcs_v'] = (!empty($gcs_v)) ? $gcs_v : [];
        // var_dump($data['dekubitus'][0]->formjson);die();
        $this->load->view('emedrec/ri/lembar_observasi_harian/lembar_observasi_harian', $data);
    }

    public function surat_rujukan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('surat_rujukan')->row();
        $data['surat_rujukan'] = $this->M_emedrec_iri->get_surat_rujukan($noipd);
        $this->load->view('emedrec/ri/surat_rujukan/surat_rujukan', $data);
    }

    public function permintaan_pulang_sendiri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['pulang_sendiri'] = $this->M_emedrec_iri->get_permintaan_pulang_sendiri($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pulang_permintaan_sendiri')->row();
        $this->load->view('emedrec/ri/pulang_sendiri/pulang_sendiri', $data);
    }

    public function pernyataan_dnr($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['dnr'] = $this->M_emedrec_iri->get_surat_pernyataan_dnr($noipd);
        $this->load->view('emedrec/ri/pernyataan_dnr/pernyataan_dnr', $data);
    }

    public function penundaan_pelayanan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['pelayanan'] = $this->M_emedrec_iri->get_penundaan_pelayanan($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('penundaan_pelayanan')->row();
        $this->load->view('emedrec/ri/penundaan_pelayanan/penundaan_pelayanan', $data);
    }

    public function assesment_awal_bidan_ginekologi($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        //$data['pelayanan'] = $this->M_emedrec_iri->get_penundaan_pelayanan($noipd);
        $this->load->view('emedrec/ri/assesment_awal_kebidanan_ginekologi/assesment_awal_bidan_ginekologi', $data);
    }

    public function pemantauan_pemberian_cairan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['pemberian_cairan'] = $this->M_emedrec_iri->get_pemantauan_pemberian_cairan($noipd);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pemantauan_pemberian_cairan')->row();
        $this->load->view('emedrec/ri/pemantauan_pemberian_cairan/v_pemberian_cairan', $data);
    }

    public function kio_resep($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kio_resep'] = $this->M_emedrec_iri->get_kio_resep_iri($noipd)->result();

        $this->load->view('emedrec/ri/kio_resep/kio_resep', $data);
    }

    public function dpo_resep($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['dpo_resep'] = $this->M_emedrec_iri->get_dpo_resep_iri($noipd)->result();

        $this->load->view('emedrec/ri/dpo_iri/dpo_iri', $data);
    }

    public function laporan_operasi($no_ipd = "", $noreg_asal = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $noregasal = $no_ipd != "" ? $noreg_asal : $this->input->post('user_id_old');
        // var_dump($noregasal);die();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregold = $data['data_pasien'][0]->noregasal;
        // var_dump($noregold);die();
        $data['lap_operasi'] = $this->M_emedrec_iri->get_lap_operasi_ri_rj($noipd, $noregold)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('laporan_operasi')->row();

        $this->load->view('emedrec/ri/laporan_operasi/v_laporan_operasi', $data);
    }

    public function cetak_rekap_tindakan($no_ipd = '')
    {
        $data['list_tindakan_pasien'] = $this->M_emedrec_iri->get_rekap_tindakan_pasien($no_ipd)->result();
        $data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
        $data['tgl'] = date("Y-m-d");

        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
        $interval = date_diff(date_create(), date_create($data['data_pasien'][0]['tgl_lahir']));
        $thn = $interval->format("%Y Tahun");
        $data['tahun'] = $thn;
        $list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
        $data['ttd'] = $this->rimpasien->get_ttd_dpjp($data['data_pasien'][0]['dr_dpjp'])->row()->ttd;
        $data['dokter'] = $this->rimpasien->get_ttd_dpjp($data['data_pasien'][0]['dr_dpjp'])->row()->nm_dokter;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('emedrec/ri/cetak_rekap_tindakan', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function add_obat_resume_mesid_kio_ri($no_ipd)
    {
        header('Content-Type: application/json; charset=utf-8');
        $data['pengobatan'] = json_encode($this->input->post());
        $rows = $this->rimtindakan->get_data_resume($no_ipd)->row();

        if ($rows == FALSE) {
            $data['no_ipd'] = $no_ipd;
            $res = $this->M_emedrec_iri->insert_data_resume($data);
            //INSERT
        } else {
            $res = $this->M_emedrec_iri->update_data_resume($no_ipd, $data);
            // UPDATE
        }
        echo json_encode([
            'code' => $res ? 200 : 500
        ]);
    }


    function laporan_anestesi_grafik_pemantauan_ajax($no_register)
    {
        $gp_jam = [];
        $grafikjson_arr = $this->M_emedrec_iri->lap_anestesi_grafik_pemantauan($no_register);
        $grafikjson_new = $grafikjson_arr ? json_decode($grafikjson_arr[0]->grafikjson) : [];
        if (!empty($grafikjson_new->questiongraphic)) {
            foreach ($grafikjson_new->questiongraphic as $gpv) {
                $gp_tekanan_darah[] = (!empty($gpv->column2) and !empty($gpv->column3)) ? [$gpv->column2, $gpv->column3] : NULL;
                $gp_jam[] = date('H:i', strtotime($gpv->jam));
                $gp_nadi[] = (!empty($gpv->column4)) ? $gpv->column4 : NULL;
                $gp_oksigen[] = (!empty($gpv->column5)) ? $gpv->column5 : NULL;
                $gp_anestesi[] = (!empty($gpv->column6)) ? $gpv->column6 : NULL;
                $gp_operasi[] = (!empty($gpv->column7)) ? $gpv->column7 : NULL;
            }
        }
        $data['new_tekanan_darah'] = (!empty($gp_tekanan_darah)) ? $gp_tekanan_darah : [];
        $data['new_jam'] = (!empty($gp_jam)) ? $gp_jam : [];
        $data['new_nadi'] = (!empty($gp_nadi)) ? $gp_nadi : [];
        $data['new_oksigen'] = (!empty($gp_oksigen)) ? $gp_oksigen : [];
        $data['new_anestesi'] = (!empty($gp_anestesi)) ? $gp_anestesi : [];
        $data['new_operasi'] = (!empty($gp_operasi)) ? $gp_operasi : [];
        $data['new_total'] = (!empty(count($gp_jam))) ? count($gp_operasi) : 0;
        echo json_encode($data);
    }

    function status_sedasi_grafik_pemantauan_ajax($no_register)
    {
        $gp_jam = [];
        $grafikjson_arr = $this->M_emedrec_iri->stat_sedasi_grafik_pemantauan($no_register);
        $grafikjson_new = $grafikjson_arr ? json_decode($grafikjson_arr[0]->grafikjson) : [];
        if (!empty($grafikjson_new->questiongraphic)) {
            foreach ($grafikjson_new->questiongraphic as $gpv) {
                $gp_tekanan_darah[] = (!empty($gpv->column2) and !empty($gpv->column3)) ? [$gpv->column2, $gpv->column3] : NULL;
                $gp_jam[] = date('H:i', strtotime($gpv->jam));
                $gp_nadi[] = (!empty($gpv->column4)) ? $gpv->column4 : NULL;
                $gp_oksigen[] = (!empty($gpv->column5)) ? $gpv->column5 : NULL;
                $gp_anestesi[] = (!empty($gpv->column6)) ? $gpv->column6 : NULL;
                $gp_operasi[] = (!empty($gpv->column7)) ? $gpv->column7 : NULL;
            }
        }
        $data['new_tekanan_darah'] = (!empty($gp_tekanan_darah)) ? $gp_tekanan_darah : [];
        $data['new_jam'] = (!empty($gp_jam)) ? $gp_jam : [];
        $data['new_nadi'] = (!empty($gp_nadi)) ? $gp_nadi : [];
        $data['new_oksigen'] = (!empty($gp_oksigen)) ? $gp_oksigen : [];
        $data['new_anestesi'] = (!empty($gp_anestesi)) ? $gp_anestesi : [];
        $data['new_operasi'] = (!empty($gp_operasi)) ? $gp_operasi : [];
        $data['new_total'] = (!empty(count($gp_jam))) ? count($gp_operasi) : 0;
        echo json_encode($data);
    }

    public function asesmen_ulang_terminal_keluarga($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asesmen_awal_ulang_pasien_terminal_keluarga')->row();
        $data['asesmen_ulang_terminal_keluarga'] = $this->M_emedrec_iri->get_asesmen_ulang_terminal_keluarga($noipd);
        $this->load->view('emedrec/ri/pasien_terminal_keluarga/pasien_terminal_keluarga', $data);
    }

    public function cuti_perawatan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cuti_perawatan')->row();
        $data['cuti_perawatan'] = $this->M_emedrec_iri->get_cuti_perawatan($noipd);
        $this->load->view('emedrec/ri/cuti_perawatan/cuti_perawatan', $data);
    }

    public function nihss($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('nihss')->row();
        $data['nihss'] = $this->M_emedrec_iri->get_nihss_for_medik($noipd)->row();
        $this->load->view('emedrec/ri/nihss/nihss', $data);
    }

    public function suket_sakit($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['suket_sakit'] = $this->M_emedrec_iri->get_suket($noipd);
        $this->load->view('emedrec/ri/suket_sakit/suket_sakit', $data);
    }

    public function cara_bayar_umum($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_cara_bayar_umum')->row();
        $data['cara_bayar_umum'] = $this->M_emedrec_iri->get_pernyataan_cara_bayar_umum($noipd);
        $this->load->view('emedrec/ri/cara_bayar_umum/cara_bayar_umum', $data);
    }

    public function pernyataan_titip($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_cara_bayar_umum')->row();
        $data['pernyataan_titip'] = $this->M_emedrec_iri->get_pernyataan_titip($noipd);
        $this->load->view('emedrec/ri/pernyataan_titip/pernyataan_titip', $data);
    }

    public function keperawatan_geriatri($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('keperawatan_geriatri')->row();
        $data['keperawatan_geriatri'] = $this->M_emedrec_iri->get_keperawatan_geriatri($noipd);
        $this->load->view('emedrec/ri/assesment_keperawatan_geriatri_rawat_inap/assesment_keperawatan_geriatri_rawat_inap', $data);
    }

    public function disfagia($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $noregasal = $data['data_pasien'][0]->noregasal;
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('disfagia')->row();
        $data['disfagia'] = $this->M_emedrec_iri->get_formulir_disfagia($noipd, $noregasal);
        $this->load->view('emedrec/ri/disfagia/disfagia', $data);
    }

    public function patologi_klinik($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('disfagia')->row();
        $data['patologi_klinik'] = $this->M_emedrec_iri->get_patologi_klinik($noipd);
        $this->load->view('emedrec/ri/patologi_klinik/patologi_klinik', $data);
    }

    public function rasal($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['rasal'] = $this->M_emedrec_iri->get_data_rasal($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rasal')->row();
        $this->load->view('emedrec/ri/rasal/rasal', $data);
    }

    public function raslan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['raslan'] = $this->M_emedrec_iri->get_data_raslan($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('raslan')->row();
        $this->load->view('emedrec/ri/raslan/raslan', $data);
    }

    public function edukasi_penolakan_rencana_asuhan($no_ipd = "", $nomedrec = "", $nocm = "")
    {
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $noipd = $no_ipd != "" ? $no_ipd : $this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['edukasi_penolakan_rencana_asuhan'] = $this->M_emedrec_iri->get_edukasi_penolakan_rencana_asuhan($noipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_penolakan_rencana_asuhan')->row();
        $this->load->view('emedrec/ri/edukasi_penolakan_rencana_asuhan/edukasi_penolakan_rencana_asuhan', $data);
    }

    public function konsul_rj_ri($no_cm, $no_medrec)
    {
        $data['konsul_dokter_iri'] = $no_medrec != "" ? $this->M_emedrec_iri->get_data_konsultasi_rj_ri($no_medrec)->result() : null;
        if (!empty($data['konsul_dokter_iri'])) {
            $data['data_pasien'] = $this->M_emedrec_iri->data_pasien_rj_ri($no_medrec)->result();
            $data['no_cm'] = $no_cm;
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['kode_document'] = $this->M_emedrec->get_kode_document('konsul_iri');
            $this->load->view('konsul_rj_ri', $data);
        } else {
            $success =     '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $no_cm . '/' . $no_medrec);
        }
    }

    public function cppt_rj_ri($no_cm = "", $no_medrec = "")
    {
        $cek_cppt_iri = $this->M_emedrec_iri->get_cppt_ri_rj($no_medrec)->result();

        if ($cek_cppt_iri != null) {
            $data['data_pasien'] = $this->M_emedrec_iri->data_pasien_rj_ri($no_medrec)->result();
            $data['logo_kesehatan_header'] = "kementriankesehatan.png";
            $data['logo_header'] =  "logo.png";
            $data['cppt_iri'] = $cek_cppt_iri;
            $nipeg = isset($data['catatan_medis_awal'][0]->nm_dokter) ? $data['catatan_medis_awal'][0]->nm_dokter : '';
            $data['sip_dokter'] = $nipeg ? $this->M_emedrec->data_nipeg_by_nama($nipeg)->row() : null;
            $data['kode_document'] = $this->M_emedrec->get_kode_document('cppt_iri');
            $this->load->view('cppt_ri_rj', $data);
        } else {
            $success = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Tidak Ada Pemeriksaan
            </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('emedrec/C_emedrec/rekam_medik_detail/' . $no_cm . '/' . $no_medrec);
        }
    }

    public function sep_iri()
    {
        $data['title'] = 'Input SEP Rawat Inap';
        $this->load->view('emedrec/ri/list_pasien_sep', $data);
    }

    public function get_sep_iri()
    {
        $tglkunjungan = !$this->input->get('tglkunjungan') ? '' : $this->input->get('tglkunjungan');
        $data = $this->M_emedrec_iri->get_list_empty_sep_pasien($tglkunjungan)->result();
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode(['result' => $data]);
    }
    public function update_sep()
    {
        header('Content-Type: application/json;charset=utf-8');
        $data = $this->M_emedrec_iri->update_sep($this->input->post('no_ipd'), $this->input->post('no_sep'));
        echo json_encode(['metadata' => ['code' => $data ? 200 : 400, 'response' => $data ? 'Data Berhasil Diupdate' : 'Data Gagal Diupdate']]);
    }

    public function pengkajian_keperawatan_general($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pengkajian_keperawatan_general'] = $this->M_emedrec_iri->get_pengkajian_keperawatan_general($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_keperawatan_general')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_keperawatan_general/pengkajian_keperawatan_general_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_keperawatan_general/pengkajian_keperawatan_general', $data);
        }
        
    }

    public function pengkajian_awal_ranap($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pengkajian_awal_ranap'] = $this->M_emedrec_iri->get_pengkajian_awal_ranap($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_awal_ranap')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_awal_ranap/pengkajian_awal_ranap_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_awal_ranap/pengkajian_awal_ranap', $data);
        }   
    }

    public function pengkajian_dekubitus_sjj($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['peng_dekubitus'] = $this->M_emedrec_iri->get_pengkajian_dekubitus($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_dekubitus')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_dekubitus_sjj/pengkajian_dekubitus_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_dekubitus_sjj/pengkajian_dekubitus', $data);
        }   
    }

    public function pengkajian_pasien_kecanduan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['peng_kecanduan'] = $this->M_emedrec_iri->get_pengkajian_pasien_kecanduan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_pasien_kecanduan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_pasien_kecanduan/pengkajian_pasien_kecanduan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_pasien_kecanduan/pengkajian_pasien_kecanduan', $data);
        }   
    }

    public function pengkajian_anestesi_sedasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['peng_anestesi_sedasi'] = $this->M_emedrec_iri->get_pengkajian_anestesi_sedasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_anestesi_sedasi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_anestesi_sedasi/pengkajian_anestesi_sedasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_anestesi_sedasi/pengkajian_anestesi_sedasi', $data);
        }   
    }

    public function pengkajian_resiko_infeksi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['peng_resiko_infeksi'] = $this->M_emedrec_iri->get_pengkajian_resiko_infeksi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengkajian_resiko_infeksi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_resiko_infeksi/pengkajian_resiko_infeksi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_resiko_infeksi/pengkajian_resiko_infeksi', $data);
        }   
    }

    public function pengantar_rawat_inap($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $noregasal = $this->M_emedrec_iri->get_noregasalnew($no_ipd)->row();
        // var_dump($noregasal);die();
        $data['data_dokter'] = $this->M_emedrec_iri->get_dokter_igd($noregasal->noregasal)->row();

        $data['peng_ranap'] = $this->M_emedrec_iri->get_pengantar_rawat_inap($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengantar_rawat_inap')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengantar_rawat_inap/pengantar_rawat_inap_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengantar_rawat_inap/pengantar_rawat_inap', $data);
        }   
    }

    public function dicharge_planning_kep($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['dicharge_planning'] = $this->M_emedrec_iri->get_dicharge_planning_kep($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('dicharge_planning_kep')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/dicharge_planning_kep/dicharge_planning_kep_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/dicharge_planning_kep/dicharge_planning_kep', $data);
        }   
    }

    public function cek_keselamatan_ok($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['keselamatan_ok'] = $this->M_emedrec_iri->get_cek_keselamatan_ok($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cek_keselamatan_ok')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/cek_keselamatan_ok/cek_keselamatan_ok_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/cek_keselamatan_ok/cek_keselamatan_ok', $data);
        }   
    }

    public function catkep_peri_operatif($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['catkep_perioperatif'] = $this->M_emedrec_iri->get_catkep_peri_operatif($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catkep_peri_operatif')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/catkep_peri_operatif/catkep_peri_operatif_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/catkep_peri_operatif/catkep_peri_operatif', $data);
        }   
    }

    public function cat_pemindahan_ruangan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pemindahan_ruangan'] = $this->M_emedrec_iri->get_cat_pemindahan_ruangan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cat_pemindahan_ruangan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/cat_pemindahan_ruangan/cat_pemindahan_ruangan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/cat_pemindahan_ruangan/cat_pemindahan_ruangan', $data);
        }   
    }

    public function catatan_perawat($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['cat_perawat'] = $this->M_emedrec_iri->get_catatan_perawat($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_perawat')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/catatan_perawat/catatan_perawat_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/catatan_perawat/catatan_perawat', $data);
        }   
    }

    public function catatan_anestesi_pemulihan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['cat_anes_pemulihan'] = $this->M_emedrec_iri->get_catatan_anestesi_pemulihan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('catatan_anestesi_pemulihan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/catatan_anestesi_pemulihan/catatan_anestesi_pemulihan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/catatan_anestesi_pemulihan/catatan_anestesi_pemulihan', $data);
        }   
    }

    public function grafik_tanda_vital($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['grafik_tand_vital'] = $this->M_emedrec_iri->get_grafik_tanda_vital($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('grafik_tanda_vital')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/grafik_tanda_vital/grafik_tanda_vital_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/grafik_tanda_vital/grafik_tanda_vital', $data);
        }   
    }

    public function lembar_observasi_harian_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['lembar_harian'] = $this->M_emedrec_iri->get_lembar_observasi_harian($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_observasi_harian')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lembar_observasi_harian/lembar_observasi_harian_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lembar_observasi_harian/lembar_observasi_harian', $data);
        }   
    }

    public function kontrol_intensive($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        // var_dump($no_ipd);die();
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kontrol_intens'] = $this->M_emedrec_iri->get_kontrol_intensive($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('kontrol_intensive')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/kontrol_intensive/kontrol_intensive_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/kontrol_intensive/kontrol_intensive', $data);
        }   
    }

    public function lembar_ppi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['lembarppi'] = $this->M_emedrec_iri->get_lembar_ppi($no_ipd)->row();
        $data['dokter_rawat'] = $this->M_emedrec_iri->get_dokter_yang_merawat_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_ppi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lembar_ppi/lembar_ppi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lembar_ppi/lembar_ppi', $data);
        }   
    }

    public function pemantauan_pemberian_cairan_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pemantauan_cairan'] = $this->M_emedrec_iri->get_pemantauan_pemberian_cairan_new($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pemantauan_pemberian_cairan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pemantauan_pemberian_cairan/pemantauan_pemberian_cairan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pemantauan_pemberian_cairan/pemantauan_pemberian_cairan', $data);
        }   
    }

    public function rekonsiliasi_obat_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['rekon_obat'] = $this->M_emedrec_iri->get_rekonsiliasi_obat_new($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rekonsiliasi_obat')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/rekonsiliasi_obat/rekonsiliasi_obat_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/rekonsiliasi_obat/rekonsiliasi_obat_new', $data);
        }   
    }

    public function rencana_tindakan_keperawatan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['rencana_keperawatan'] = $this->M_emedrec_iri->get_rencana_tindakan_keperawatan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('rencana_tindakan_keperawatan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/rencana_tindakan_keperawatan/rencana_tindakan_keperawatan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/rencana_tindakan_keperawatan/rencana_tindakan_keperawatan', $data);
        }   
    }

    public function daftar_pemberian_terapi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['dpo'] = $this->M_emedrec_iri->get_daftar_pemberian_terapi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('daftar_pemberian_terapi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/daftar_pemberian_obat/daftar_pemberian_obat_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/daftar_pemberian_obat/daftar_pemberian_obat', $data);
        }   
    }

    public function lap_pembedahan_anestesi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['anes_lokal'] = $this->M_emedrec_iri->get_lap_pembedahan_anestesi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lap_pembedahan_anestesi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lap_pembedahan_anestesi/lap_pembedahan_anestesi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lap_pembedahan_anestesi/lap_pembedahan_anestesi', $data);
        }   
    }

    public function lap_pendamping_anestesi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pendamping_anes'] = $this->M_emedrec_iri->get_lap_pendamping_anestesi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lap_pendamping_anestesi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lap_pendamping_anestesi/lap_pendamping_anestesi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lap_pendamping_anestesi/lap_pendamping_anestesi', $data);
        }   
    }

    public function laporan_pembedahan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pembedahan'] = $this->M_emedrec_iri->get_laporan_pembedahan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('laporan_pembedahan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/laporan_pembedahan/laporan_pembedahan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/laporan_pembedahan/laporan_pembedahan', $data);
        }   
    }

    public function lembar_konsul($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['dokter_rawat'] = $this->M_emedrec_iri->get_dokter_yang_merawat_resume($no_ipd)->row();
        $data['konsul'] = $this->M_emedrec_iri->get_lembar_konsul($no_ipd)->result();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_konsul')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lembar_konsul/lembar_konsul_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lembar_konsul/lembar_konsul', $data);
        }   
    }

    public function lembar_intruksi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['intruksi'] = $this->M_emedrec_iri->get_lembar_intruksi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('lembar_intruksi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/lembar_intruksi/lembar_intruksi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/lembar_intruksi/lembar_intruksi', $data);
        }   
    }

    public function patologi_anatomi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pa'] = $this->M_emedrec_iri->get_patologi_anatomi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('patologi_anatomi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/patologi_anatomi/patologi_anatomi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/patologi_anatomi/patologi_anatomi', $data);
        }   
    }

    public function pengajuan_pembedahan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pengajuan_bedah'] = $this->M_emedrec_iri->get_pengajuan_pembedahan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pengajuan_pembedahan')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengajuan_pembedahan/pengajuan_pembedahan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengajuan_pembedahan/pengajuan_pembedahan', $data);
        }   
    }

    public function askep_general($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['askepgeneral'] = $this->M_emedrec_iri->get_askep_general($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('askep_general')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/askep_general/askep_general_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/askep_general/askep_general', $data);
        }   
    }

    public function persiapan_perawatan_dirumah($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['persiapan_dirumah'] = $this->M_emedrec_iri->get_persiapan_perawatan_dirumah($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('persiapan_perawatan_dirumah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/persiapan_perawatan_dirumah/persiapan_perawatan_dirumah_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/persiapan_perawatan_dirumah/persiapan_perawatan_dirumah', $data);
        }   
    }

    public function cat_khusus_paliatif($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['cat_paliatif'] = $this->M_emedrec_iri->get_cat_khusus_paliatif($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('cat_khusus_paliatif')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/cat_khusus_paliatif/cat_khusus_paliatif_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/cat_khusus_paliatif/cat_khusus_paliatif', $data);
        }   
    }

    public function pramedi_pasca_operasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pramed_operasi'] = $this->M_emedrec_iri->get_pramedi_pasca_operasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pramedi_pasca_operasi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pramedi_pasca_operasi/pramedi_pasca_operasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pramedi_pasca_operasi/pramedi_pasca_operasi', $data);
        }   
    }

    public function status_sedasi_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['stat_sedasi'] = $this->M_emedrec_iri->get_status_sedasi_new($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('status_sedasi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/status_sedasi/status_sedasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/status_sedasi/status_sedasi', $data);
        }   
    }

    public function penolakan_tindakan_medis($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pen_medis'] = $this->M_emedrec_iri->get_penolakan_tindakan_medis($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('penolakan_tindakan_medis')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/penolakan_tindakan_medis/penolakan_tindakan_medis_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/penolakan_tindakan_medis/penolakan_tindakan_medis', $data);
        }   
    }

    public function persetujuan_tindakan_medis($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['persetujuan_medis'] = $this->M_emedrec_iri->get_persetujuan_tindakan_medis($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('persetujuan_tindakan_medis')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/persetujuan_tindakan_medis/persetujuan_tindakan_medis_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/persetujuan_tindakan_medis/persetujuan_tindakan_medis', $data);
        }   
    }

    public function second_opinion($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['sec_opinion'] = $this->M_emedrec_iri->get_second_opinion($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('second_opinion')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/second_opinion/second_opinion_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/second_opinion/second_opinion', $data);
        }   
    }

    public function permintaan_privasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['permintaan_priv'] = $this->M_emedrec_iri->get_permintaan_privasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('permintaan_privasi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/permintaan_privasi/permintaan_privasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/permintaan_privasi/permintaan_privasi', $data);
        }   
    }

    public function pernyataan_rad_kontras($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_rad_kontras'] = $this->M_emedrec_iri->get_pernyataan_rad_kontras($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_rad_kontras')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pernyataan_rad_kontras/pernyataan_rad_kontras_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pernyataan_rad_kontras/pernyataan_rad_kontras', $data);
        }   
    }

    public function pernyataan_restrain_mekanik($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_restrain_mekanik'] = $this->M_emedrec_iri->get_pernyataan_restrain_mekanik($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_restrain_mekanik')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pernyataan_restrain_mekanik/pernyataan_restrain_mekanik_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pernyataan_restrain_mekanik/pernyataan_restrain_mekanik', $data);
        }   
    }

    public function pernyataan_anestesi_sedasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_anestesi_sedasi'] = $this->M_emedrec_iri->get_pernyataan_anestesi_sedasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_anestesi_sedasi')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pernyataan_anestesi_sedasi/pernyataan_anestesi_sedasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pernyataan_anestesi_sedasi/pernyataan_anestesi_sedasi', $data);
        }   
    }

    public function pernyataan_tindakan_hemodialisis($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_tind_hemo'] = $this->M_emedrec_iri->get_pernyataan_tindakan_hemodialisis($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_tindakan_hemodialisis')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pernyataan_tindakan_hemodialisis/pernyataan_tindakan_hemodialisis_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pernyataan_tindakan_hemodialisis/pernyataan_tindakan_hemodialisis', $data);
        }   
    }

    public function pernyataan_transfusi_darah($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_trans_darah'] = $this->M_emedrec_iri->get_pernyataan_transfusi_darah($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pernyataan_transfusi_darah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pernyataan_transfusi_darah/pernyataan_transfusi_darah_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pernyataan_transfusi_darah/pernyataan_transfusi_darah', $data);
        }   
    }
    public function permintaan_darah($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['permintaan'] = $this->M_emedrec_iri->get_permintaan_transfusi_darah($no_ipd)->row();
        // var_dump($data['permintaan']);die();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['data_iri'] = $this->M_emedrec_iri->get_data_iri($no_ipd);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/permintaan_transfusi_darah/permintaan_transfusi_darah_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/permintaan_transfusi_darah/permintaan_transfusi_darah_new', $data);
        } 
    
    }

    public function persetujuan_izin_operasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['persetujuan_izin_op'] = $this->M_emedrec_iri->get_persetujuan_izin_operasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'PERSETUJUAN TINDAKAN OPERASI';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/persetujuan_izin_operasi/persetujuan_izin_operasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/persetujuan_izin_operasi/persetujuan_izin_operasi', $data);
        } 
    }

    public function suket_kelahiran($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['surat_kelahiran'] = $this->M_emedrec_iri->get_suket_kelahiran($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/suket_kelahiran/suket_kelahiran_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/suket_kelahiran/suket_kelahiran', $data);
        } 
    }

    public function surat_penolakan_resusitasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['penolakan_resusitasi'] = $this->M_emedrec_iri->get_surat_penolakan_resusitasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_penolakan_resusitasi/surat_penolakan_resusitasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_penolakan_resusitasi/surat_penolakan_resusitasi', $data);
        } 
    }

    public function pengobatan_iodiumdoc($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['surat_iodiumdoc'] = $this->M_emedrec_iri->get_pengobatan_iodiumdoc($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengobatan_iodiumdoc/pengobatan_iodiumdoc_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengobatan_iodiumdoc/pengobatan_iodiumdoc', $data);
        } 
    }

    public function edukasi_pemberian_darah($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['edukasi_pemberian_darah'] = $this->M_emedrec_iri->get_edukasi_pemberian_darah($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/edukasi_pemberian_darah/edukasi_pemberian_darah_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/edukasi_pemberian_darah/edukasi_pemberian_darah', $data);
        } 
    }

    public function edukasi_anestesi_sedasi_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['ed_anestesi_sedasi'] = $this->M_emedrec_iri->get_edukasi_anestesi_sedasi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_anestesi_sedasi')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/edukasi_anestesi_sedasi/edukasi_anestesi_sedasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/edukasi_anestesi_sedasi/edukasi_anestesi_sedasi', $data);
        } 
    }

    public function leaflet_pasien($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['leaflet'] = $this->M_emedrec_iri->get_leaflet_pasien($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('leaflet_pasien')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/leaflet_pasien/leaflet_pasien_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/leaflet_pasien/leaflet_pasien', $data);
        } 
    }

    public function surat_pernyataan_pulang($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['aps'] = $this->M_emedrec_iri->get_surat_pernyataan_pulang($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('surat_pernyataan_pulang')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_pernyataan_pulang/surat_pernyataan_pulang_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_pernyataan_pulang/surat_pernyataan_pulang', $data);
        } 
    }

    public function registrasi_awal($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['regis_awal'] = $this->M_emedrec_iri->get_registrasi_awal($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('registrasi_awal')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/registrasi_awal/registrasi_awal_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/registrasi_awal/registrasi_awal', $data);
        } 
    }

    public function ringkasan_masuk_keluar_pasien($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['masuk_keluar'] = $this->M_emedrec_iri->get_ringkasan_masuk_keluar_pasien($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('ringkasan_masuk_keluar_pasien')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/ringkasan_masuk_keluar_pasien/ringkasan_masuk_keluar_pasien_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/ringkasan_masuk_keluar_pasien/ringkasan_masuk_keluar_pasien', $data);
        } 
    }

    public function resume_pasien_pulang_keperawatan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['resume_pulang_keperawatan'] = $this->M_emedrec_iri->get_resume_pasien_pulang_keperawatan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('resume_pasien_pulang_keperawatan')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/resume_pasien_pulang_keperawatan/resume_pasien_pulang_keperawatan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/resume_pasien_pulang_keperawatan/resume_pasien_pulang_keperawatan', $data);
        } 
    }

    public function resume_pasien_pulang($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        // var_dump($this->input->post());die();
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['resume_pulang'] = $this->M_emedrec_iri->get_resume_pasien_pulang($no_ipd)->row();
        // var_dump($no_ipd);die();
        $data['dokter_rawat'] = $this->M_emedrec_iri->get_dokter_yang_merawat_resume($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('resume_pasien_pulang')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/resume_pasien_pulang/resume_pasien_pulang_json', $data);
        }else{
            // $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
            // $mpdf->curlAllowUnsafeSslRequests = true;		
            // $html = $this->load->view('ri/emr_ranap_sjj/resume_pasien_pulang/resume_pasien_pulang',$data,true);
            // //$this->mpdf->AddPage('L'); 
            // $mpdf->WriteHTML($html);
            // $mpdf->Output();
             $this->load->view('ri/emr_ranap_sjj/resume_pasien_pulang/resume_pasien_pulang', $data);
        } 
    }

    public function risiko_jatuh_dewasa($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['jatuh_dewasa'] = $this->M_emedrec_iri->get_risiko_jatuh_dewasa($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('risiko_jatuh_dewasa')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/risiko_jatuh_dewasa/risiko_jatuh_dewasa_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/risiko_jatuh_dewasa/risiko_jatuh_dewasa', $data);
        } 
    }

    public function risiko_jatuh_geriatri($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['jatuh_geriatri'] = $this->M_emedrec_iri->get_risiko_jatuh_geriatri($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('risiko_jatuh_geriatri')->row();
        $data['nama_form'] = 'CATATAN EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/risiko_jatuh_geriatri/risiko_jatuh_geriatri_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/risiko_jatuh_geriatri/risiko_jatuh_geriatri', $data);
        } 
    }

    public function data_bayi_lahir($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['data_bayi'] = $this->M_emedrec_iri->get_data_bayi_lahir($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/data_bayi_lahir/data_bayi_lahir_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/data_bayi_lahir/data_bayi_lahir', $data);
        } 
    
    }

    public function identifikasi_bayi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['iden_bayi'] = $this->M_emedrec_iri->get_identifikasi_bayi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/identifikasi_bayi/identifikasi_bayi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/identifikasi_bayi/identifikasi_bayi', $data);
        } 
    
    }

    public function pengkajian_jatuh_neonatus($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['jatuh_neonatus'] = $this->M_emedrec_iri->get_pengkajian_jatuh_neonatus($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_jatuh_neonatus/pengkajian_jatuh_neonatus_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_jatuh_neonatus/pengkajian_jatuh_neonatus', $data);
        } 
    
    }
    public function pengkajian_kep_perinatologi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kep_perina'] = $this->M_emedrec_iri->get_pengkajian_kep_perinatologi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_perinatologi/pengkajian_kep_perinatologi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_perinatologi/pengkajian_kep_perinatologi', $data);
        } 
    
    }
    public function pengkajian_kep_anak($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kep_anak'] = $this->M_emedrec_iri->get_pengkajian_kep_anak($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_anak/pengkajian_kep_anak_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_anak/pengkajian_kep_anak', $data);
        } 
    
    }
    public function resiko_jatuh_anak($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['jatuh_anak'] = $this->M_emedrec_iri->get_resiko_jatuh_anak($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/resiko_jatuh_anak/resiko_jatuh_anak_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/resiko_jatuh_anak/resiko_jatuh_anak', $data);
        } 
    
    }
    public function medis_ranap_anak($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['medis_anak'] = $this->M_emedrec_iri->get_medis_ranap_anak($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/medis_ranap_anak/medis_ranap_anak_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/medis_ranap_anak/medis_ranap_anak', $data);
        } 
    
    }
    public function medis_ranap_neonatus($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['medis_neo'] = $this->M_emedrec_iri->get_medis_ranap_neonatus($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/medis_ranap_neonatus/medis_ranap_neonatus_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/medis_ranap_neonatus/medis_ranap_neonatus', $data);
        } 
    
    }
    public function persetujuan_bayi_tabung($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['bayi_tabung'] = $this->M_emedrec_iri->get_persetujuan_bayi_tabung($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/persetujuan_bayi_tabung/persetujuan_bayi_tabung_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/persetujuan_bayi_tabung/persetujuan_bayi_tabung', $data);
        } 
    
    }
    public function serah_terima_bayi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['terima_bayi'] = $this->M_emedrec_iri->get_serah_terima_bayi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/serah_terima_bayi/serah_terima_bayi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/serah_terima_bayi/serah_terima_bayi', $data);
        } 
    
    }
    public function askep_obgyn($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['obgyn'] = $this->M_emedrec_iri->get_askep_obgyn($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/askep_obgyn/askep_obgyn_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/askep_obgyn/askep_obgyn', $data);
        } 
    
    }
    public function pengkajian_keperawatan_obgyn($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['keperawatanobgyn'] = $this->M_emedrec_iri->get_pengkajian_keperawatan_obgyn($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_keperawatan_obgyn/pengkajian_keperawatan_obgyn_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_keperawatan_obgyn/pengkajian_keperawatan_obgyn', $data);
        } 
    
    }
    public function pengkajian_medis_kb($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['medis_kb'] = $this->M_emedrec_iri->get_pengkajian_medis_kb($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_medis_kb/pengkajian_medis_kb_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_medis_kb/pengkajian_medis_kb', $data);
        } 
    
    }
    public function asuhan_keperawatan_hcu($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kep_hcu'] = $this->M_emedrec_iri->get_asuhan_keperawatan_hcu($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/asuhan_keperawatan_hcu/asuhan_keperawatan_hcu_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/asuhan_keperawatan_hcu/asuhan_keperawatan_hcu', $data);
        } 
    
    }
    public function blanko_harian_hcu($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['harian_hcu'] = $this->M_emedrec_iri->get_blanko_harian_hcu($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/blanko_harian_hcu/blanko_harian_hcu_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/blanko_harian_hcu/blanko_harian_hcu', $data);
        } 
    
    }
    public function pengkajian_kep_hcu($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kep_hcu'] = $this->M_emedrec_iri->get_pengkajian_kep_hcu($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = 'DATA BAYI BARU LAHIR';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_hcu/pengkajian_kep_hcu_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pengkajian_kep_hcu/pengkajian_kep_hcu', $data);
        } 
    
    }

    public function hand_over($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['handover'] = $this->M_emedrec_iri->get_hand_over($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/hand_over/hand_over_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/hand_over/hand_over', $data);
        } 
    
    }

    public function assesment_ulang_nyeri($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['ulang_nyeri'] = $this->M_emedrec_iri->get_assesment_ulang_nyeri($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/assesment_ulang_nyeri/assesment_ulang_nyeri_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/assesment_ulang_nyeri/assesment_ulang_nyeri', $data);
        } 
    
    }

    public function pews($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['pews'] = $this->M_emedrec_iri->get_pews($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pews/pews_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pews/pews', $data);
        } 
    
    }

    public function surat_rujukan_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['sur_rujukan'] = $this->M_emedrec_iri->get_surat_rujukan_new($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_rujukan/surat_rujukan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_rujukan/surat_rujukan', $data);
        } 
    
    }

    public function suket_kematian($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['sur_kematian'] = $this->M_emedrec_iri->get_surat_kematian($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_kematian/surat_kematian_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_kematian/surat_kematian', $data);
        } 
    
    }

    public function persetujuan_penolakan_rujukan($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/persetujuan_penolakan_rujukan/persetujuan_penolakan_rujukan_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/persetujuan_penolakan_rujukan/persetujuan_penolakan_rujukan', $data);
        } 
    
    }
    public function catatan_edukasi_terintegrasi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/edukasi_terintegrasi/edukasi_terintegrasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/edukasi_terintegrasi/edukasi_terintegrasi', $data);
        } 
    
    }
   
    public function penandaan_lokasi_op($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/penandaan_lokasi/penandaan_lokasi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/penandaan_lokasi/penandaan_lokasi', $data);
        } 
    
    }
    public function monitoring_transfusi_darah($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['monitoring_transfusi_darah'] = $this->M_emedrec_iri->get_monitoring_transfusi_darah($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('monitoring_transfusi_darah')->row();
        $data['nama_form'] = '';
        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/monitoring_transfusi_darah/monitoring_transfusi_darah_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/monitoring_transfusi_darah/monitoring_transfusi_darah', $data);
        } 
    
    }

    public function formulir_transfer_pasien($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['formulir_transfer_pasien'] = $this->M_emedrec_iri->get_formulir_transfer_pasien($no_ipd)->row();
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/formulir_transfer_pasien/formulir_transfer_pasien_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/formulir_transfer_pasien/formulir_transfer_pasien', $data);
        } 
    
    }
    public function ews_dewasa($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['ews'] = $this->M_emedrec_iri->get_ews_dewasa($no_ipd)->row();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/ews_dewasa/ews_dewasa_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/ews_dewasa/ews_dewasa', $data);
        } 
    
    }
    public function surat_tugas($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_perintah_tugas/surat_perintah_tugas_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_perintah_tugas/surat_perintah_tugas', $data);
        } 
    
    }
    public function gizi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/gizi/gizi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/gizi/gizi', $data);
        } 
    
    }
    public function intruksi_hcu($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['per_per_rujukan'] = $this->M_emedrec_iri->get_persetujuan_penolakan_rujukan($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('edukasi_pemberian_darah')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/intruksi_hcu/intruksi_hcu_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/intruksi_hcu/intruksi_hcu', $data);
        } 
    
    }
    public function upload_penunjang_ri($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['upload_penunjang_ri'] = $this->M_emedrec_iri->get_upload_penunjang($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('naik_kelas')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/upload_penunjang_ri/upload_penunjang_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/upload_penunjang_ri/upload_penunjang_ri', $data);
        } 
    
    }

    public function kio_ri($noipd = "", $nomedrec = "", $nocm = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['kio'] = $this->M_emedrec_iri->get_kio_iri($no_ipd)->result();
        // var_dump( $data['kio']);die();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = '';
        $data['nama_form'] = '';
        $this->load->view('ri/emr_ranap_sjj/kio/kio', $data);
    
    }
    public function surat_kontrol_ri($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['surat_kontrol'] = $this->M_emedrec_iri->get_surat_kontrol_ri($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        $data['data_iri'] = $this->M_emedrec_iri->get_data_iri($no_ipd);
        // var_dump($data['data_pasien']);die();
        
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('naik_kelas')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/surat_kontrol/surat_kontrol_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/surat_kontrol/surat_kontrol', $data);
        } 
    
    }
    public function pemakaian_ventilator($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['ventilator'] = $this->M_emedrec_iri->get_pemakaian_ventilator($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pemakaian_ventilator')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/pemakaian_ventilator/pemakaian_ventilator_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/pemakaian_ventilator/pemakaian_ventilator', $data);
        } 
    
    }
    public function resiko_jatuh_new($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['resiko_jatuh_new'] = $this->M_emedrec_iri->get_resiko_jatuh_new($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('resiko_jatuh_new')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/resiko_jatuh_general/resiko_jatuh_general_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/resiko_jatuh_general/resiko_jatuh_general', $data);
        } 
    
    }
    public function insert_monitoring_anatesi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['monitoring_anes'] = $this->M_emedrec_iri->get_monitoring_anatesi($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('pemakaian_ventilator')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/monitoring_anatesi/monitoring_anatesi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/monitoring_anatesi/monitoring_anatesi', $data);
        } 
    
    }
    public function insert_asuhan_gizi($noipd = "", $nomedrec = "", $nocm = "",$status = "")
    {
        $no_ipd = $noipd != "" ? $noipd : $this->input->post('user_id');
        $cm = $nocm != "" ? $nocm : $this->input->post('no_cm');
        $medrec = $nomedrec != "" ? $nomedrec : $this->input->post('no_medrec');
        $nostatus = $status != "" ? $status : $this->input->post('status');
    
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        $data['asuhan_gizi'] = $this->M_emedrec_iri->get_asuhan_gizi_ri($no_ipd)->row();
        $data['data_pasien'] = $this->M_emedrec_iri->get_data_pasien($medrec);
        // var_dump($data['data_pasien']);die();
        $data['kode_document'] = $this->M_emedrec->get_kode_rev_form('asuhan_gizi')->row();
        $data['nama_form'] = '';

        if($nostatus == '0'){
            $this->load->view('ri/emr_ranap_sjj/asuhan_gizi/asuhan_gizi_json', $data);
        }else{
            $this->load->view('ri/emr_ranap_sjj/asuhan_gizi/asuhan_gizi', $data);
        } 
    
    }

    
}
