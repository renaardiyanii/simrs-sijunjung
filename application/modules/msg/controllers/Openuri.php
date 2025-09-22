<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Mpdf\QrCode\QrCode;
// use Mpdf\QrCode\Output;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class Openuri extends CI_Controller
{
  private $_client;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('M_check', '', TRUE);
    $this->load->helper('pdf_helper');
    $this->load->model('admin/appconfig', '', TRUE);
    $this->load->model('lab/labmdaftar', '', TRUE);
    $this->load->model('irj/rjmregistrasi', '', TRUE);
    $this->load->model('rad/radmdaftar', '', TRUE);
    $this->load->model('elektromedik/emmdaftar', '', TRUE);
  }

  public function waba_lab($no_lab = '', $qr_val = '')
  {
    $data['no_lab'] = $no_lab;
    if ($no_lab != '') {
      $data['no_register'] = $this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;
      $tgl = $this->labmdaftar->get_tgl_periksa_lab($no_lab)->result_array();
      //var_dump($tgl); die();
      //set timezone
      date_default_timezone_set("Asia/Bangkok");

      $data['tgl'] = $tgl;


      $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;

      $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
      $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
      //var_dump($data['kota_header']); die();

      $data['data_kategori_lab'] = $this->labmdaftar->get_data_kategori_lab($no_lab)->result();
      // 1. => 2[ hematologi , kimia darah]

      $data['data_jenis_lab'] = $this->labmdaftar->get_data_jenis_lab($no_lab)->result();
      // 2 , => kolestrol , darah lengkap

      /**
       * NOTED 
       *
       *  */
      // $data_jenis_lab=$this->labmdaftar->get_data_jenis_lab($no_lab)->result();
      // $data_kategori_lab=$this->labmdaftar->get_data_kategori_lab($no_lab)->result();
      // $hasil_lab=$this->labmdaftar->get_data_hasil_lab_new($no_lab)->result();
      // $json = json_encode($hasil_lab);
      /**
       * NOTED 
       *
       *  */

      $data['hasil_labor'] = [];
      foreach ($data['data_kategori_lab'] as $rw) {
        $tindakan = strtoupper($rw->nama_jenis);
        foreach ($data['data_jenis_lab'] as $row) {
          if ($rw->kode_jenis == substr($row->id_tindakan, 0, 2)) {
            $nmtindakan = $row->nmtindakan;
            array_push($data['hasil_labor'], $this->labmdaftar->get_data_hasil_lab($row->id_tindakan, $row->no_lab)->result());
            $data_hasil_lab = $this->labmdaftar->get_data_hasil_lab($row->id_tindakan, $row->no_lab)->result();
            // var_dump($data_hasil_lab);die();
            foreach ($data_hasil_lab as $row1) {
              $kadar_normal = str_replace('<', '&lt;', $row1->kadar_normal);
              $kadar_normal = str_replace('>', '&gt;', $kadar_normal);
              $jenis_hasil = $row1->jenis_hasil;
              $hasil = $row1->hasil_lab;
              $satuan = $row1->satuan;
              $kadar = $row1->kadar_normal;
            }
          }
        }
      }
      if (substr($data['no_register'], 0, 2) == "PL") {
        $data['data_pasien'] = $this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
        $isi =   "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
        $data['isi_qr'] = $isi;
      } else {
        $data['data_pasien'] = $this->labmdaftar->get_data_pasien_cetak($no_lab)->row();
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
        if (substr($data['data_pasien']->no_register, 0, 2) == "RJ") {
          $isi =  "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        } else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
          $isi =  "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        }


        $data['get_umur'] = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
        $tahun = 0;
        $bulan = 0;
        $hari = 0;
        foreach ($data['get_umur'] as $row) {
          $data['tahun'] = $row->umurday;
          //$data['usia']=$row->age;

        }
        $data['usia'] = date_diff(date_create($data['data_pasien']->tgl_lahir), date_create('now'));
        // $nama_poli=$this->labmdaftar->getnama_poli($data['data_pasien']->idrg)->row()->nm_poli;
        // $data['nama_poli'] =$nama_poli;
        $nama_dokter = $this->labmdaftar->getnm_dokter($data['data_pasien']->no_register)->row()->nm_dokter;
        $data['nama_dokter'] = $nama_dokter;
        if ($data['data_pasien']->cara_bayar == 'KERJASAMA') {
          $a = $this->labmdaftar->getcr_bayar_dijamin($data['data_pasien']->no_register)->row();
          // var_dump($a);
          $data['cara_bayar'] = $a->a . ' - ' . $a->b;
        } else {
          $data['cara_bayar'] = $data['data_pasien']->cara_bayar;
        }
        if (substr($data['no_register'], 0, 2) == 'RJ') {
          $get_nama_poli = $this->labmdaftar->get_nama_poli($data['data_pasien']->idrg)->row();
          $data['lokasi'] = $get_nama_poli->nm_poli;
        } else if (substr($data['no_register'], 0, 2) == 'RI') {
          $data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
          // $lokasi = $nm_poli;
        } else {
          $data['lokasi'] = 'Pasien Langsung';
        }
      }
      //var_dump($data['data_pasien']->id_dokter); die();
      $data['ttd'] = $this->labmdaftar->ttd_haisl($data['data_pasien']->id_dokter)->row()->ttd;
      $data['login_data'] = $this->load->get_var("user_info");
      // $qrCode = new QrCode($isi);
      // $output = new Output\Svg();
      // $result = $output->output($qrCode, 175, 'white', 'black');
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
      $logo = Logo::create(($_SERVER['HTTP_HOST'] == '36.66.44.99:8927' OR $_SERVER['HTTP_HOST']=='36.66.44.99:8926') ? 'http://36.66.44.99:8926/assets/img/Logo-rsomh-qr.png': str_replace('https', 'http', base_url() . 'assets/img/Logo-rsomh-qr.png'))
        ->setResizeToWidth(40);
      // $logo = Logo::create('http://asset.rsomh.co.id/Logo-rsomh-qr.png')
      //   ->setResizeToWidth(40);

      // Create generic label
      $label = Label::create('')
        ->setTextColor(new Color(255, 0, 0));

      $result = $writer->write($qrCode, $logo, $label);

      // // Directly output the QR code
      $hasil =  $result->getDataUri();
      $data['qr'] = $hasil;


      if ($this->input->get('view') == 'json') {
        header("Content-type:application/json");
        echo json_encode($data);
      } else {
        // $this->load->view('lab/paper_css/hasil_lab', $data);
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('lab/paper_css/hasil_lab', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      }
    } else {
      echo 'Not Found';
    }
  }

  public function waba_rad($no_rad = '', $qr_val = '')
  {
    if ($no_rad != '') {
      $data['no_register'] = $this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
      $data['no_rad'] = $no_rad;
      //set timezone
      date_default_timezone_set("Asia/Bangkok");
      $tgl_jam = date("d-m-Y H:i:s");
      $data['tgl'] = date("d-m-Y");

      $conf = $this->appconfig->get_headerpdf_appconfig()->result();
      $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
      $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
      // $data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
      // $data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
      // $data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
      $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
      // var_dump($data['logo_header']);die();
      $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
      $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

      $data['data_hasil_rad'] = $this->radmdaftar->get_data_hasil_rad($no_rad)->result();
      $data['data_hasil_rad2'] = $this->radmdaftar->get_data_hasil_rad($no_rad)->result();
      //var_dump($data['data_hasil_rad2'][0]->id_dokter_1);die();
      $data['resultGambar'] = [];
      $data['resultGambarwaba'] = [];

      // echo '<pre>';
      // var_dump($data['data_hasil_rad2']);
      // echo '</pre>';
      // die();
      foreach ($data['data_hasil_rad2'] as $key) {
        $gambar_hasil_rad = $this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
        array_push($data['resultGambar'], $this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result());
        //$data['gambar_hasil_rad']=$this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
        $jenis_tindakan = $key->jenis_tindakan;
        $hasil_pengirim = $key->hasil_pengirim;
        foreach ($gambar_hasil_rad as $gambar) {
          $path = str_replace('https', 'http', base_url() . 'download/rad/' . $gambar->name);
          $type = pathinfo($path, PATHINFO_EXTENSION);
          $dt = file_get_contents($path);
          $tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
          array_push($data['resultGambarwaba'], [$gambar->name, $tanda]);
        }
        $cekeestttd = $this->labmdaftar->ttd_haisl($key->id_dokter_1)->row();
        $data['ttd'] = $cekeestttd->ttd;
        $data['name'] = $cekeestttd->name;
        //var_dump($tanda);die();
      }
      // echo '<pre>';
      // var_dump($data['gambar_hasil_rad']);
      // echo '</pre>';
      // die();
      // die();
      if (substr($data['no_register'], 0, 2) == "PL") {
        $data['data_pasien'] = $this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
        $isi = "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
        $data['isi_qr'] = $isi;
      } else {
        $data['data_pasien'] = $this->radmdaftar->get_data_pasien_cetak($no_rad)->row();
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
        if (substr($data['data_pasien']->no_register, 0, 2) == "RJ") {
          $isi =  "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        } else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
          $isi =  "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        }

        $get_umur = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
        $tahun = 0;
        $bulan = 0;
        $hari = 0;
        foreach ($get_umur as $row) {
          // echo $row->umurday;
          $data['tahun'] = $row->umurday;
          // $bulan=floor(($row->umurday - ($tahun*365))/30);
          // $hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
        }
        // $nm_poli=$this->labmdaftar->getnama_poli($data['data_pasien']->idrg)->row()->nm_poli;
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
        $data['gambar_hasil_rad'] = $this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
      }
      //var_dump($isi); die();
      // $qrCode = new QrCode($isi);
      // $output = new Output\Svg();
      // $hasil = $output->output($qrCode, 175, 'white', 'black');
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
      $logo = Logo::create(($_SERVER['HTTP_HOST'] == '36.66.44.99:8927' OR $_SERVER['HTTP_HOST']=='36.66.44.99:8926') ? 'http://36.66.44.99:8926/assets/img/Logo-rsomh-qr.png': str_replace('https', 'http', base_url() . 'assets/img/Logo-rsomh-qr.png'))
        ->setResizeToWidth(40);

      // Create generic label
      $label = Label::create('')
        ->setTextColor(new Color(255, 0, 0));

      $result = $writer->write($qrCode, $logo, $label);

      // // Directly output the QR code
      $hasil =  $result->getDataUri();
      $data['qr'] = $hasil;
      //$data = (string)$data;


      if ($this->input->get('view') == 'json') {
        header("Content-type:application/json");
        echo json_encode($data);
      } else {
        //$data = (string)$data;
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('rad/paper_css/cetk_hasil_rad_all', $data, true);
        // // $this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      }
    } else {
      echo 'Not Found';
    }
  }

  public function waba_udt($no_em = '', $qr_val = '')
  {
    if ($no_em != '') {
      $data['no_register'] = $this->emmdaftar->get_row_register_by_noem($no_em)->row()->no_register;
      $data['no_em'] = $no_em;
      //set timezone
      date_default_timezone_set("Asia/Bangkok");
      $tgl_jam = date("d-m-Y H:i:s");
      $data['tgl'] = date("d-m-Y");

      $conf = $this->appconfig->get_headerpdf_appconfig()->result();
      $top_header = $this->appconfig->get_header_top_pdfconfig()->value;
      $bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
      $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
      $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
      $data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;


      $data['data_hasil_em'] = $this->emmdaftar->get_data_hasil_em($no_em)->result();
      $data['data_hasil_em2'] = $this->emmdaftar->get_data_hasil_em($no_em)->result();

      $data['gambar_hasil_em'] = [];
      $data['gambar_hasil_waba'] = [];
      foreach ($data['data_hasil_em2'] as $key) {
        $gambar_hasil_em1 = $this->emmdaftar->get_gambar_hasil_em($key->id_pemeriksaan_em)->result();
        array_push($data['gambar_hasil_em'], $this->emmdaftar->get_gambar_hasil_em($key->id_pemeriksaan_em)->result());
        $jenis_tindakan = $key->jenis_tindakan;
        $hasil = $key->hasil;
        $hasil_pengirim = $key->hasil_pengirim;
        foreach ($gambar_hasil_em1 as $gambar) {
          $path = str_replace('https', 'http', base_url() . 'download/' . $gambar->name);
          $type = pathinfo($path, PATHINFO_EXTENSION);
          $dt = file_get_contents($path);
          $tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
          //var_dump($tanda);die();
          array_push($data['gambar_hasil_waba'], [$gambar->name, $tanda]);
        }
      }
      if (substr($data['no_register'], 0, 2) == "PL") {
        $data['data_pasien'] = $this->emmdaftar->get_data_pasien_luar_cetak($no_em)->row();
        $data['nama_dokter'] = '';
        $isi = "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
        $data['isi_qr'] = $isi;
      } else {
        $data['data_pasien'] = $this->emmdaftar->get_data_pasien_cetak($no_em)->row();
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
        if (substr($data['data_pasien']->no_register, 0, 2) == "RJ") {
          $isi = "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        } else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
          $isi = "" . $qr_val . " || Cek Validasi di www.doc.rsomh.co.id";
          $data['isi_qr'] = $isi;
        }
        // if(($data['data_pasien']->no_telp!="") && ($data['data_pasien']->no_hp!="")){
        // 	$nohptelp = $nohptelp.$data['data_pasien']->no_telp / $data['data_pasien']->no_hp;
        // } else if($data['data_pasien']->no_telp!=""){
        // 	$nohptelp = $nohptelp.$data['data_pasien']->no_telp;
        // } else if($data['data_pasien']->no_hp!=""){
        // 	$nohptelp = $nohptelp.$data['data_pasien']->no_hp;
        // } else {
        // 	$nohptelp = "-";
        // }

        $data['get_umur'] = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
        $tahun = 0;
        $bulan = 0;
        $hari = 0;
        foreach ($data['get_umur'] as $row) {
          $data['tahun'] = $row->umurday;
        }
        if ($data['data_pasien']->cara_bayar == 'DIJAMIN') {
          $a = $this->emmdaftar->getcr_bayar_dijamin($data['data_pasien']->no_register)->row();
          $data['cara_bayar'] = $a->a - $a->b;
        } else {
          $data['cara_bayar'] = $data['data_pasien']->cara_bayar;
        }
        if (substr($data['no_register'], 0, 2) == "RJ") {
          $data['nama_dokter'] = $this->emmdaftar->getnm_dokter_rj($data['data_pasien']->no_register)->row()->nm_dokter;
          $data['lokasi'] = $data['data_pasien']->idrg;
        } else if (substr($data['no_register'], 0, 2) == "RI") {
          $data['nama_dokter'] = $this->emmdaftar->getnm_dokter_ri($data['data_pasien']->no_register)->row()->nm_dokter;
          $data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
          // $lokasi = $nm_poli;
        } else {
          $data['lokasi'] = 'Pasien Langsung';
        }
      }

      $data['dokter_1'] = "";
      foreach ($data['data_hasil_em'] as $row) {
        if ($row->id_dokter != "") {
          $data['dokter_1'] = $this->emmdaftar->getnama_dokter($row->id_dokter)->row()->nm_dokter;
          $data['id_dokter_1'] = $this->emmdaftar->getnama_dokter($row->id_dokter)->row()->id_dokter;
        } else {
          $data['dokter_1'] = "";
          $data['id_dokter_1'] = "";
        }
      }

      foreach ($data['data_hasil_em2'] as $key) {
        $data['$gambar_hasil_em'] = $this->emmdaftar->get_gambar_hasil_em($key->id_pemeriksaan_em)->result();
      }
      $cekeestttd = $this->labmdaftar->ttd_haisl($data['id_dokter_1'])->row();
      $data['ttd'] = $cekeestttd->ttd;
      // $qrCode = new QrCode($isi);
      // $output = new Output\Svg();
      // $result = $output->output($qrCode, 200, 'white', 'black');
      // $data['qr'] = $result;
      $writer = new PngWriter();
      $qrCode = QrCode::create($isi)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        ->setSize(190)
        ->setMargin(10)
        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->setForegroundColor(new Color(0, 0, 0, 10))
        ->setBackgroundColor(new Color(255, 255, 255));

      // Create generic logo
      $logo = Logo::create(($_SERVER['HTTP_HOST'] == '36.66.44.99:8927' OR $_SERVER['HTTP_HOST']=='36.66.44.99:8926') ? 'http://36.66.44.99:8926/assets/img/Logo-rsomh-qr.png': str_replace('https', 'http', base_url() . 'assets/img/Logo-rsomh-qr.png'))
        ->setResizeToWidth(50);

      // Create generic label
      $label = Label::create('')
        ->setTextColor(new Color(255, 0, 0));

      $result = $writer->write($qrCode, $logo, $label);

      // // Directly output the QR code
      $hasil =  $result->getDataUri();
      $data['qr'] = $hasil;


      if ($this->input->get('view') == 'json') {
        header("Content-type:application/json");
        echo json_encode($data);
      } else {
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('elektromedik/paper_css/hasil_em', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        // $this->load->view('paper_css/hasil_em',$data);
      }
    } else {
      echo 'Not Found';
    }
  }
}
