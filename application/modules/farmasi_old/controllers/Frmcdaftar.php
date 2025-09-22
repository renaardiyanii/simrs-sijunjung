<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Frmcdaftar extends Secure_area {
    public function __construct(){
        parent::__construct();

        $this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
        $this->load->model('elektromedik/emmdaftar','',TRUE);
        $this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->model('ird/rdmpelayanan','',TRUE);
        $this->load->model('rad/radmdaftar','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
		$this->load->model('iri/rimtindakan');
		$this->load->helper('pdf_helper');
        $this->load->library('session');
    }

    public function index(){
        $data['title'] = 'Daftar Resep Pasien RJ UMUM';
        $this->load->view('farmasi/frmvdaftarpasien', $data);
    }

    public function list_pasien_bpjs(){
        $data['title'] = 'Daftar Resep Pasien RJ BPJS';
        $this->load->view('farmasi/frmvdaftarpasienbpjs', $data);
    }

    public function list_pasien_rj(){
        $data['title'] = 'Daftar Resep Pasien RJ UMUM';
        $this->load->view('farmasi/frmvdaftarpasienrj', $data);
    }

    public function list_pasien_rj_bpjs(){
        $data['title'] = 'Daftar Resep Pasien RJ UMUM';
        $this->load->view('farmasi/frmvdaftarpasienrjbpjs', $data);
    }

    public function list_pasien_ri(){
        $data['title'] = 'Daftar Resep Pasien RI UMUM';
        $this->load->view('farmasi/frmvdaftarpasienri', $data);
    }

    public function list_pasien_ri_bpjs(){
        $data['title'] = 'Daftar Resep Pasien RI BPJS';
        $this->load->view('farmasi/frmvdaftarpasienribpjs', $data);
    }

    public function koreksi(){
        $data['title'] = 'Daftar Koreksi Resep Pasien';
        $this->load->view('farmasi/frmvkoreksi', $data);
    }
    public function get_data_pasien(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien($date)->result();
    

        $line['data'] = $hasil;

        echo json_encode($line);
    }

    // public function get_data_pasien(){
    //     $date = $this->input->post('tgl');
    //     if($date == ''){
    //         $date = date('Y-m-d');
    //     }
    //     $line  = array();
    //     $line2 = array();
    //     $row2  = array();

    //     $i=1;
    //     $hasil = $this->Frmmdaftar->get_daftar_resep_pasien($date)->result();
    //     // var_dump($hasil);
    //     // die();
    //     foreach ($hasil as $value) {
    //         $no_register = $value->no_register;
    //         $getrdrj=substr($no_register, 0,2);
    //         $get_no_resep = $this->Frmmdaftar->get_no_resep($no_register)->row();
    //         if($getrdrj == 'RJ' || $getrdrj == 'RI' || $getrdrj == 'PL'){
    //             if ($get_no_resep != null) {
    //                 $no_resep = $get_no_resep->no_resep;
    //             }else{
    //                 $no_resep = '';
    //             }

    //             if ($no_resep != 0) {
    //                 $selesai = "
    //                 <form action='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' method=\"post\" target=\"_blank\">
    //                     <button type=\"submit\" class=\"btn btn-danger btn-sm\" onclick=\"showswal()\">Selesai</button>
    //                 </form> ";
    //                 $no = "<p style=\"background-color:Lime;color:black  ;border: 1px solid;border-radius:15px;text-align:center;\">".$i++."</p>";
    //             }else{
    //                 $selesai = "";
    //                 $no =$i++;
    //             }

    //         }else{
    //             $selesai = "";
    //             $no =$i++;
    //         }


    //         $row2['no'] = $no;
    //         $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS')."' class=\"btn btn-primary btn-sm\">Resep</a>
    //         <a href='".site_url('farmasi/Frmcdaftar/telaah_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Telaah Obat</a> <br>
    //         <a href='".site_url('emedrec/C_emedrec/cetak_Eresep_telaah/'.$value->no_cm.'/'.$no_register)."' class=\"btn btn-primary btn-sm\" target=\"_blank\" style=\"margin-top:3px;margin-bottom:3px;\">Cetak Telaah Resep</a>".$selesai;
    //         $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
    //         $row2['no_cm'] = $value->no_cm;
    //         $row2['no_register'] = $value->no_register;
    //         $row2['nama'] = $value->nama;
    //         $row2['kelas'] = $value->kelas;
    //         $row2['bed'] = $value->bed;
    //         $row2['dokter'] = $value->dokter;
    //         $row2['cara_bayar'] = $value->cara_bayar;


    //         $line2[] = $row2;
    //     }

    //     $line['data'] = $line2;

    //     echo json_encode($line);
    // }
    public function get_data_pasien_bpjs(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_bpjs($date)->result();

        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_rj(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_rj($date)->result();

        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);

            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_rj_bpjs(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_rj_bpjs($date)->result();

        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_ri(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_ri($date)->result();

        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_ri_bpjs(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_ri_bpjs($date)->result();

        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_koreksi(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_koreksi($date)->result();
        // $print_r($hasil);
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            // if($getrdrj == 'RJ'){
            //     $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            // }else{
            //     $selesai = "";
            // }


            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register)."' class=\"btn btn-primary btn-sm\">Koreksi</a> ";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_pasien_noreg(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_pasien_noreg_bpjs(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg_bpjs($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_noreg_rj(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg_rj($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_noreg_rj_bpjs(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg_rj_bpjs($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_noreg_ri(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg_ri($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }
    public function get_data_pasien_noreg_ri_bpjs(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_daftar_resep_pasien_noreg_ri_bpjs($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;
            $getrdrj=substr($no_register, 0,2);
            if($getrdrj == 'RJ'){
                $selesai = "<a href='".site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register)."' class=\"btn btn-danger btn-sm\">Selesai</a>";
            }else{
                $selesai = "";
            }


            // $row2['no'] = $i++;
            // $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            // $row2['no_cm'] = $value->no_cm;
            // $row2['no_register'] = $value->no_register;
            // $row2['nama'] = $value->nama;
            // $row2['kelas'] = $value->kelas;
            // $row2['idrg'] = $value->idrg;
            // $row2['bed'] = $value->bed;
            // $row2['cara_bayar'] = $value->cara_bayar;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['bed'] = $value->bed;
            $row2['dokter'] = $value->dokter;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<a href='".site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register)."' class=\"btn btn-primary btn-sm\">Resep</a> ".$selesai;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function rekapobat(){
        $data['title'] = 'Rekap Obat Pasien';
        $date = date("Y-m-d");
        $hasil = $this->Frmmdaftar->get_rekap_obat($date)->result();
        $data['hasil'] = $hasil;
        $this->load->view('farmasi/frmvdaftarpasienrekap', $data);
    }

    public function telaah_obat_aksi(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_rekap_obat($date)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Telaah<br/>Obat</button>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_rekap(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_rekap_obat($date)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_rekap_by_date() {
        $date = $this->input->post('date');
        // if($date == ''){
        //     $date = date('Y-m-d');
        // }
        // $line  = array();
        // $line2 = array();
        // $row2  = array();

        // $i=1;
        $hasil = $this->Frmmdaftar->get_rekap_obat($date)->result();
        $data['hasil'] = $hasil;
        // foreach ($hasil as $value) {
        //     $no_register = $value->no_register;

        //     $row2['no'] = $i++;
        //     $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
        //     $row2['no_cm'] = $value->no_cm;
        //     $row2['no_register'] = $value->no_register;
        //     $row2['nama'] = $value->nama;
        //     $row2['kelas'] = $value->kelas;
        //     $row2['idrg'] = $value->idrg;
        //     $row2['bed'] = $value->bed;
        //     $row2['cara_bayar'] = $value->cara_bayar;
        //     $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

        //     $line2[] = $row2;
        // }

        // $line['data'] = $line2;
        $this->load->view('farmasi/frmvdaftarpasienrekap', $data);
        //echo json_encode($line);
    }

    public function get_data_rekap_noreg(){
        $noreg = $this->input->post('key');

        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_rekap_obat_noreg($noreg)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_medrec;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_rekap_by_noreg(){
        $noreg = $this->input->post('key');

        // $line  = array();
        // $line2 = array();
        // $row2  = array();

        // $i=1;
        $hasil = $this->Frmmdaftar->get_rekap_obat_noreg($noreg)->result();
        $data['hasil'] = $hasil;
        // foreach ($hasil as $value) {
        //     $no_register = $value->no_register;

        //     $row2['no'] = $i++;
        //     $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
        //     $row2['no_cm'] = $value->no_medrec;
        //     $row2['no_register'] = $value->no_register;
        //     $row2['nama'] = $value->nama;
        //     $row2['kelas'] = $value->kelas;
        //     $row2['idrg'] = $value->idrg;
        //     $row2['bed'] = $value->bed;
        //     $row2['cara_bayar'] = $value->cara_bayar;
        //     $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

        //     $line2[] = $row2;
        // }

        // $line['data'] = $line2;
        $this->load->view('farmasi/frmvdaftarpasienrekap', $data);
        // echo json_encode($line);
    }

    public function get_data_rekap_detail(){
        $no_register = $this->input->post('no_register');

        $line   = array();
        $line2  = array();
        $row2   = array();

        $i = 1; $ttot = 0;
        $hasil = $this->Frmmdaftar->get_data_rekap_detail($no_register)->result();
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = $value->xupdate;
            $row2['nama'] = $value->nama_obat;
            $row2['harga'] = "<div align=\"right\">".number_format($value->biaya_obat, '0', ',', '.')."</div>";
            $row2['signa'] = $value->signa;
            $row2['qty'] = "<div align=\"right\">".number_format($value->qty, '0', ',', '.')."</div>";
            $row2['total'] = "<div align=\"right\">".number_format($value->vtot, '0', ',', '.')."</div>";

            $ttot += $value->vtot;

            $line2[] = $row2;
        }

        $line['data'] = $line2;
        $line['total'] = "<h4>Total Akhir:&nbsp;&nbsp;&nbsp; Rp. ".number_format($ttot, '2', ',', '.')."</h4>";
        echo json_encode($line);
    }
    public function list_pengambilan(){
        $data['title'] = 'List Pengambilan Resep';
        $this->load->view('farmasi/frmvpengambilanpasien', $data);
    }

    public function get_list_pengambilan(){
        $tanggal = $this->input->post('tgl');
        if($tanggal == ''){
            $date = date('Y-m-d');
        }else{
            $date = $this->input->post('tgl');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_pengambilan_resep_pasien($date)->result();
        foreach ($hasil as $value) {

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<input type=\"button\" name=\"selesai\" onclick=\"selesai_pengambilan($value->no_resep)\" class=\"btn btn-primary\" value=\"Selesai\">";


            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    // public function list_pengambilan(){
    //  $data['title'] = 'Daftar Pengambilan Resep Pasien';
    //        $date = $this->input->post('date');
    //        if($date == ''){
    //            $date = date('Y-m-d');
    //        }
        //  $data['farmasi']=$this->Frmmdaftar->get_pengambilan_resep_pasien($date)->result();
    //        $this->load->view('farmasi/frmvpengambilanpasien', $data);
        // }
    //      public function permintaan_obat($no_register='',$tab =''){

    //         $data['title'] = 'Input Permintaan Obat';
    //         $data['no_resep'] = '';
    //         $data['no_register']=$no_register;

    //         if(substr($no_register, 0,2)=="PL"){
    //              $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
    //              $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
    //             $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();

    //        foreach($data['data_pasien_resep'] as $row){
    //             $data['nama']=$row->nama;
    //             $data['kelas_pasien']=$row->kelas;
    //             $data['no_medrec']=$row->no_medrec;
    //             $data['no_cm']='-';
    //             $data['tgl_kun']=$row->tgl_kunjungan;
    //             $data['cara_bayar']=$row->cara_bayar;
    //             $data['idrg']=$row->idrg;
    //             $data['bed']=$row->bed;
    //             }
    //         }else{
    //             $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
    //             $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
    //             // print_r($data['data_pasien_resep']);die();
    //             foreach($data['data_pasien_resep'] as $row){
    //                 $data['nama']=$row->nama;
    //                 $data['no_medrec']=$row->no_medrec;
    //                 $data['no_cm']=$row->no_cm;
    //                 $data['kelas_pasien']=$row->kelas;
    //                 $data['tgl_kun']=$row->tgl_kunjungan;
    //                 $data['idrg']=$row->idrg;
    //                 $data['bed']=$row->bed;
    //                 $data['cara_bayar']=$row->cara_bayar;
    //                 $data['foto']=$row->foto;

    //             }
    //             // if (substr($no_register, 0,2)=="RD"){
    //             //     $data['bed']='Rawat Darurat';
    //             // }
    //         }

    //         $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
    //         // print_r($data);die();
    //         foreach ($data['get_data_markup'] as $row) {
    //             if($row->id_kebijakan=="MU001"){
    //                 $data['fmarkup']=$row->nilai;
    //             }
    //             else if($row->id_kebijakan=="PN001"){
    //                 $data['ppn']=$row->nilai;
    //             }
    //             else if($row->id_kebijakan=="TS001"){
    //                 if($data['cara_bayar']=="BPJS"){
    //                     $data['tuslah_racik']= '0';
    //                 }else{
    //                 $data['tuslah_racik']=$row->nilai;
    //                 }
    //             }else if($row->id_kebijakan=="TS002"){
    //                 if($data['cara_bayar']=="BPJS"){
    //                     $data['tuslah_non']=0;
    //                 }else{
    //                 $data['tuslah_non']=0;
    //                 }
    //             }
    //         }
    //         //echo $data['tuslah_non'];die();


    //         $data['tab_obat'] = 'active';
    //         $data['tab_racik']  = '';
    //         if($tab!=''){
    //             $data['tab_obat'] = '';
    //             $data['tab_racik'] = 'active';
    //         }


    //         //$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();

    //         $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
    //         $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
    //         $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_register)->result();

    // // Hapus Tuslah tgl 08-01-2021
    //         // if ($this->Frmmdaftar->getdata_resep_pasien($no_register)->num_rows() > 0 && $data['cara_bayar']=="UMUM") {
    //         //     $data['tuslah_non']=3000;
    //         // }else{
    //         //     $data['tuslah_non']=0;
    //         // }
    //     //end off hapus tuslah
    //         // echo $data['tuslah_non'];die();
    //         //get obat from role id
    //         $login_data = $this->load->get_var("user_info");
    //         $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

    //         $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
    //         $i=1;


    //         $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
    //         $dokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
    //         if($dokter > 0){
    //             $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
    //         }else{
    //             $data['nmdokter'] = "";
    //         }
    //         //$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
    //         $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
    //         //$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
    //         $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
    //         $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
    //         $login_data = $this->load->get_var("user_info");
    //         $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

    //         /** Update 12 April 2018 bentrok dengan permintaan obat ruangan */
    //         //$data['id_poli'] = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
    //         $data['id_poli'] = '';

    //         $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();

    //         $userid = $this->session->userid;
    //         $group = $this->Frmmpo->getIdGudang($userid);
    //         $data['id_gudang'] = $group->id_gudang;

    //         $this->load->view('farmasi/frmvpermintaan',$data);
    //     }


    // public function get_data_obat(){
    //     $no_register=$this->input->post('no_register');

    //     $login_data = $this->load->get_var("user_info");
    //     $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

    //     $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
    //     $i=1;

    //     foreach ($id_gudang as $row) {
    //         $no_gudang[]=$row->id_gudang;
    //     }

    //     $userid = $this->session->userid;
    //     $group = $this->Frmmpo->getIdGudang($userid);
    //     if($group->id_gudang == "8" || $group->id_gudang == "7"){
    //         $ids = "1";
    //     }else{
    //         $ids = join("','",$no_gudang);
    //     }
    //     // $i = $this->load->Frmmdaftar->get_data_obat_query($ids);
    //     // print_r($i);die();

    //     // $keyword = $_GET['term'];
    //     $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
    //     $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
    //     $list = $this->Frmmdaftar->data_obat($ids);
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $value) {
    //         $no++;
    //         $row = array();

    //         $row[] = $no.
    //         "
    //         <input type=\"hidden\" name=\"idtindakan[]\" value=\"$value->id_inventory.'-'.$value->id_obat\"/>

    //         ";
    //         // $row[] = "
    //         // <input type=\"checkbox\" id=\"obat\" name=\"obat\" value=\"obat\">
    //         // <label for=\"obat\"></label>
    //         // ";
    //         $checked = $value->nm_obat;
    //         // $row[] = " <input type=\"hidden\" name=\"idtindakan[]\" value=\"$checked\"/>";
    //         $row[] = "<input type=\"checkbox\" class=\"custom-control-input\" name=\"cari_obat[]\"
    //         value=\"$checked\" id=\"$value->id_obat\" >



    //         <label class=\"custom-control-label\" for=\"$value->id_obat\"></label>";

    //         $row[] = $value->nm_obat;

    //         //signa--

    //         $row[] = "
    //         <div class=\"col-sm-1\ style=\" display:inline;\">

    //         <input type=\"text\" class=\"form-control\" style=\"width:60px;\" name=\"'sgn-1-'.$value->id_obat\"
    //         id=\"'sgn-'.$value->id_obat\" min=1 >

    //         <label><b>x</b></label>

    //         <input type=\"text\" class=\"form-control\" style=\"width:60px;\" name=\"'sgn-2-'.$value->id_obat\"
    //         id=\"'sgn-'.$value->id_obat\" min=0 >

    //         <span>Hari</span>

    //         </div>";
    //         // $row[] = "
    //         // <div class=\"col-sm-3\" style=\"width:40px; display:flex; padding:10px;\">
    //         // <input type=\"text\" style=\"margin-right:5px;width:30px;\" class=\"form-control\"
    //         // name=\"signa\">

    //         //  <p><b>x</b></p>

    //         // <input type=\"text\" class=\"form-control\" style=\"margin-left:5px;margin-right:8px;width:30px;\"
    //         // name=\"signa2\" >
    //         // <span>Hari</span>
    //         // </div>";

    //         //satuan--
    //         $row[] ="
    //         <div class=\"col-sm-1\">
    //         <select class=\"form-control\" style=\"width: 150px\" name=\"'satuan-'.$value->id_obat\" id=\"satuan\">



    //         </select>
    //         </div>";

    //         //qty--
    //         $row[] ="
    //         <input class=\"form-control\" type=\"number\" name=\"'qty-'.$value->id_obat\"  style=\"width:40px;justify-content:center;\">
    //         ";



    //         $data[] = $row;
    //     }

    //     $output = array(
    //                     "draw" => $_POST['draw'],
    //                     "recordsTotal" => $this->Frmmdaftar->count_all($ids),
    //                     "recordsFiltered" => $this->Frmmdaftar->count_filtered($ids),
    //                     "data" => $data,
    //             );
    //     //output to json format
    //     echo json_encode($output);
    //     // $data = $this->db->select('o.id_obat,
    //     // o.nm_obat,
    //     // o.hargabeli,
    //     // o.hargajual,
    //     // g.batch_no,
    //     // g.expire_date,
    //     // g.qty,
    //     // o.jenis_obat,
    //     // g.id_inventory')
    //     //         ->from('gudang_inventory g')
    //     //         ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
    //     //         ->where('g.id_gudang', $ids)->limit(20, 0)->get();

    //             // $arr='';
    //     // return $data;
    // }

    public function get_data_obat(){
        $no_register=$this->input->post('no_register');

        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
            $ids = join("','",$no_gudang);
        // }
        // $i = $this->load->Frmmdaftar->get_data_obat_query($ids);
        // print_r($i);die();

        // $keyword = $_GET['term'];
        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
        // var_dump($data['satuan']);die();
        $data_satuan = $data['satuan'];
        $list = $this->Frmmdaftar->data_obat($ids);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();

            $row[] = $no.
            "
            <input type=\"hidden\" name=\"idtindakan[]\" value=\"$value->id_inventory'-'$value->id_obat\"/>

            ";
            // $row[] = "
            // <input type=\"checkbox\" id=\"obat\" name=\"obat\" value=\"obat\">
            // <label for=\"obat\"></label>
            // ";
            $checked = $value->nm_obat;
            // $row[] = " <input type=\"hidden\" name=\"idtindakan[]\" value=\"$checked\"/>";
            // $head_checkbox = "<input type=\"checkbox\" class=\"custom-control-input\" name=\"cari_obat[]\"
            // value=\"$checked\" id=\"$value->id_obat\"";
            // $midle_checkbox = ">
            // <label class=\"custom-control-label\" for=\"$value->id_obat\"></label>";
            // foreach($data_tindakan_pasien as $data_pembanding){
            //     if($data_pembanding->nama_obat == $value['nm_obat']){
            //         echo 'disabled';
            //     }
            // }
            $cek_resep_obat = $this->Frmmdaftar->cek_resep_obat($no_register,$value->id_obat)->row();
            if($cek_resep_obat == false){
                $row[] = "<input type=\"checkbox\" class=\"custom-control-input\" name=\"cari_obat[]\"
                            value=\"$checked\" id=\"$value->id_obat\">
                            <label class=\"custom-control-label\" for=\"$value->id_obat\"></label>";

                $row[] = $value->nm_obat;

                //signa--

                $row[] = "
                    <div class=\"col-sm-1\ style=\" display:inline;\">

                    <input type=\"number\" class=\"form-control\" style=\"width:35px;\" name=\"sgn-1-$value->id_obat\"
                    id=\"'sgn-'.$value->id_obat\" min=1 >

                    <label><b>x</b></label>

                    <input type=\"number\" class=\"form-control\" style=\"width:35px;\" name=\"sgn-2-$value->id_obat\"
                    id=\"'sgn-'.$value->id_obat\" min=1 >

                    <label>Hari</label>

                    </div>";
                // $row[] = "
                // <div class=\"col-sm-3\" style=\"width:40px; display:flex; padding:10px;\">
                // <input type=\"text\" style=\"margin-right:5px;width:30px;\" class=\"form-control\"
                // name=\"signa\">

                //  <p><b>x</b></p>

                // <input type=\"text\" class=\"form-control\" style=\"margin-left:5px;margin-right:8px;width:30px;\"
                // name=\"signa2\" >
                // <span>Hari</span>
                // </div>";

                //satuan--
                $head_satuan= "  <div class=\"col-sm-1\">
                    <select class=\"form-control\" style=\"width: 150px\" name=\"satuan-$value->id_obat\" id=\"satuan\">
                    <option value=\"\">-Pilih Satuan-</option>";

                $foot_satuan = '</select></div>';



                foreach ($data_satuan as $satuans){
                    $head_satuan.= "<option value=\"$satuans->nm_satuan\">$satuans->nm_satuan</option>";
                    // echo $head_satuan;
                };
                $head_satuan.= $foot_satuan;

                $row[] = $head_satuan;

                // die();

                // var_dump($head_satuan);die();

                // $row[] ="
                // <div class=\"col-sm-1\">
                // <select class=\"form-control\" style=\"width: 150px\" name=\"'satuan-'.$value->id_obat\" id=\"satuan\">



                // </select>
                // </div>";

                //qty--
                $row[] ="
                    <input class=\"form-control\" type=\"number\" name=\"qty-$value->id_obat\"  style=\"width:40px;justify-content:center;\" min=1>
                ";
            }else{
                $row[] = "<input type=\"checkbox\" class=\"custom-control-input\" name=\"cari_obat[]\"
                            value=\"$checked\" id=\"$value->id_obat\" disabled>
                            <label class=\"custom-control-label\" for=\"$value->id_obat\"></label>";

                $row[] = $value->nm_obat;

                //signa--

                $row[] = "
                    <div class=\"col-sm-1\ style=\" display:inline;\">

                    <input type=\"text\" class=\"form-control\" style=\"width:60px;\" name=\"sgn-1-$value->id_obat\"
                    id=\"'sgn-'.$value->id_obat\" min=1 disabled>

                    <label><b>x</b></label>

                    <input type=\"text\" class=\"form-control\" style=\"width:60px;\" name=\"sgn-2-$value->id_obat\"
                    id=\"'sgn-'.$value->id_obat\" min=0 disabled>

                    <span>Hari</span>

                    </div>";
                // $row[] = "
                // <div class=\"col-sm-3\" style=\"width:40px; display:flex; padding:10px;\">
                // <input type=\"text\" style=\"margin-right:5px;width:30px;\" class=\"form-control\"
                // name=\"signa\">

                //  <p><b>x</b></p>

                // <input type=\"text\" class=\"form-control\" style=\"margin-left:5px;margin-right:8px;width:30px;\"
                // name=\"signa2\" >
                // <span>Hari</span>
                // </div>";

                //satuan--
                $head_satuan= "  <div class=\"col-sm-1\">
                    <select class=\"form-control\" style=\"width: 150px\" name=\"satuan-$value->id_obat\" id=\"satuan\" disabled>
                    <option value=\"\">-Pilih Satuan-</option>";

                $foot_satuan = '</select></div>';



                foreach ($data_satuan as $satuans){
                    $head_satuan.= "<option value=\"$satuans->nm_satuan\">$satuans->nm_satuan</option>";
                    // echo $head_satuan;
                };
                $head_satuan.= $foot_satuan;

                $row[] = $head_satuan;

                // die();

                // var_dump($head_satuan);die();

                // $row[] ="
                // <div class=\"col-sm-1\">
                // <select class=\"form-control\" style=\"width: 150px\" name=\"'satuan-'.$value->id_obat\" id=\"satuan\">



                // </select>
                // </div>";

                //qty--
                $row[] ="
                    <input class=\"form-control\" type=\"number\" name=\"qty-$value->id_obat\"  style=\"width:40px;justify-content:center;\" disabled>
                ";

            }

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Frmmdaftar->count_all($ids),
                        "recordsFiltered" => $this->Frmmdaftar->count_filtered($ids),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        // $data = $this->db->select('o.id_obat,
        // o.nm_obat,
        // o.hargabeli,
        // o.hargajual,
        // g.batch_no,
        // g.expire_date,
        // g.qty,
        // o.jenis_obat,
        // g.id_inventory')
        //         ->from('gudang_inventory g')
        //         ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
        //         ->where('g.id_gudang', $ids)->limit(20, 0)->get();

                // $arr='';
        // return $data;
    }

    public function permintaan_obat_rad($no_register='',$pelayan='',$tab ='') {
        $data['pelayan'] = $pelayan;
        $data['title'] = 'Input Permintaan Obat';
        $data['no_resep'] = '';
        $data['no_register']=$no_register;
        $data['dokter_rad'] = $this->radmdaftar->get_dokter_rad()->result();
        $splitter = substr($no_register,0,2);
        $poli = '';

        if(substr($no_register,0,2) == 'RI'){
            $last_obat = $this->Frmmdaftar->last_obat($no_register)->result();
            if($last_obat != null){
                $data['last_obat'] = $last_obat;
            }else{
                $data['last_obat'] = null;
            }
        }elseif (substr($no_register,0,2) == 'RJ') {
            $get_no_medrec = $this->Frmmdaftar->get_data_pasien_resep($no_register)->row()->no_medrec;
            // var_dump( $get_no_medrec);die();136783
            $get_id_poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
            // var_dump($get_id_poli);die();BR00
            $get_no_register = $this->Frmmdaftar->get_noreg_by_medrec_poli_rj($get_no_medrec,$get_id_poli)->row();
            $gett = isset($get_no_register->no_register)?$get_no_register->no_register:null;
            // var_dump($get_no_register);die();
            $last_obat = $this->Frmmdaftar->last_obat($gett)->result();
            //  var_dump($last_obat);die();
            if($last_obat != null){
                $data['last_obat'] = $last_obat;
            }else{
                $data['last_obat'] = null;
            }
        }else{
            $data['last_obat'] = null;
        }

        if(substr($no_register,0,2) == 'PL'){
            $data['pengkondisian_poli']= '';
            $poli = '';
        }elseif(substr($no_register,0,2) == 'RJ'){
            $poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
            if ($poli != null) {
                $data['pengkondisian_poli']= $poli;
            }else{
                $data['pengkondisian_poli']= '';
            }
        }elseif(substr($no_register,0,2) == 'RI'){
            $data['pengkondisian_poli']= '';
            $data['noregasal'] = $this->Frmmdaftar->get_noreg_asal($no_register)->row()->noregasal;
        }else{
            $data['pengkondisian_poli']= '';
        }
        $poli != ''?$data['data_obat_poli'] = $this->Frmmdaftar->get_obat_poli($poli)->result():'';

        if(substr($no_register, 0,2)=="PL"){
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();

            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['kelas_pasien']=$row->kelas;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']='-';
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['cara_bayar']=$row->cara_bayar;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
            }
        }else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;
                $data['foto']=$row->foto;

            }
            if (substr($no_register, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }
        }

        $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
        // print_r($data);die();
        foreach ($data['get_data_markup'] as $row) {
            if($row->id_kebijakan=="MU001"){
                $data['fmarkup']=$row->nilai;
            }
            else if($row->id_kebijakan=="PN001"){
                $data['ppn']=$row->nilai;
            }
            else if($row->id_kebijakan=="TS001"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_racik']= '0';
                }else{
                $data['tuslah_racik']=$row->nilai;
                }
            }else if($row->id_kebijakan=="TS002"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_non']=0;
                }else{
                $data['tuslah_non']=0;
                }
            }
        }
        //echo $data['tuslah_non'];die();


        $data['tab_obat'] = 'active';
        $data['tab_racik']  = '';
        if($tab!=''){
            $data['tab_obat'] = '';
            $data['tab_racik'] = 'active';
        }


        //$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();

        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
        $data['data_tindakan_racikan']=$this->Frmmdaftar->racikracik($no_register)->result();


        //add asesmen dokter
            $obat_rows =$this->Frmmdaftar->getdata_resep_pasien($no_register)->num_rows();

            foreach ($data['data_tindakan_pasien'] as $key) {

                $obat_nama_obat[] = $key->nama_obat;
                $obat_signa[] = $key->signa;
                $obat_racikan[] = $key->racikan;
                $obat_id_resep_pasien[] = $key->id_resep_pasien;

            }
            $tidak_ada_obat[] = array("Tidak Ada Obat");

            $tampung_obat= array();
            if ($obat_rows == 0) {
                for ($i=0; $i < $obat_rows ; $i++) {
                    $tampung_obat[] = $tampung_obat[$i];
                }
            }else{
                for ($i=0; $i < $obat_rows ; $i++) {
                    if($obat_racikan[$i] != '1'){
                        $tampung_obat[] = '-'.$obat_nama_obat[$i].' ('.$obat_signa[$i].')<br>';
                    }else{
                        $tampung_obat[] = '-'.$obat_nama_obat[$i].' ('.$obat_signa[$i].')<br>';
                        $daatacicikracikolimpik = $this->Frmmdaftar->get_racik_last($obat_id_resep_pasien[$i])->result();
                        foreach ($daatacicikracikolimpik as $row1) {
                            if ($obat_id_resep_pasien[$i] == $row1->id_resep_pasien) {
                                $tampung_obat[] = '• ' . $row1->nama_obat . ' Dosis '.$row1->dosis.', Satuan '.$row1->satuan.' (' . $row1->qty . ')<br>';
                            }
                        }
                    }

                }
            }
            $gabung_obat = implode($tampung_obat);

            $cek_pasien_apa = substr($no_register,0,2);

            if($cek_pasien_apa == 'RI'){
                $cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
            }else{
                $cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
            }

            // if($obat_rows == 0){
                $soap['plan_dokter'] = $gabung_obat;
                $soap['terapi_tindakan_dokter'] = $gabung_obat;
            // }else{
            //     $soap['plan_dokter'] = $cek_soap->row()->plan_dokter.'<br>'.$gabung_obat;
            // }
            // $soap['plan_dokter'] = $spa['plan'];


            // if($obat_rows == 0){
                $id_soap = $cek_soap->row();
                if ($id_soap != null) {
                    $this->emmdaftar->update_data_soap($id_soap->id,$soap);
                }else{

                }


            // }else{
                // $soap['no_register'] = $no_register;

            //     $this->emmdaftar->update_data_soap($id_soap,$soap);
            // }
            // $datafisikplan['plan'] = $gabung_obat;
            // $dataplan['plan_dokter'] = $gabung_obat;
            // $data_fisik_plan=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row()->plan;
            // var_dump($data_fisik_plan);
            // die();

            // if ($data_fisik_plan == null) {
            // 	$datafisikplan['no_register'] = $no_register;
            // 	$this->Frmmdaftar->insert_data_fisik_live($datafisikplan);
            // 	$this->Frmmdaftar->insert_update_plan($no_register, $dataplan);
            // 	//INSERT
            // } else {
            // 	$this->Frmmdaftar->update_data_fisik_live($no_register, $datafisikplan);
            // 	$this->Frmmdaftar->insert_update_plan($no_register, $dataplan);
            // 	// UPDATE
            // }

        // Hapus Tuslah tgl 08-01-2021
        // if ($this->Frmmdaftar->getdata_resep_pasien($no_register)->num_rows() > 0 && $data['cara_bayar']=="UMUM") {
        //     $data['tuslah_non']=3000;
        // }else{
        //     $data['tuslah_non']=0;
        // }
        //end off hapus tuslah
        // echo $data['tuslah_non'];die();
        //get obat from role id
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;


        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $dokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
        if($dokter > 0){
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }
        //$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
        $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
        //$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
        $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        /** Update 12 April 2018 bentrok dengan permintaan obat ruangan */
        //$data['id_poli'] = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
        $data['id_poli'] = '';

        $data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
        $data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
        $data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();

        $data['poliklinik'] = $this->Frmmdaftar->get_poliklinik()->result();
        $data['diagnosa'] = $this->Frmmdaftar->get_diagnosa()->result();

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data['id_gudang'] = $group->id_gudang;

        // check rawat inap
        $split_noreg = substr($no_register,0,2);
        $data['tambah_pulang'] = $split_noreg == "RI"??1;

        $data['obat_igd'] = $this->Frmmdaftar->get_obat_igd($group->id_gudang)->result();

        $this->load->view('farmasi/frmvpermintaan_rad',$data);
    }


    public function permintaan_obat($no_register='',$pelayan='',$tab =''){
        $data['pelayan'] = $pelayan;
        $data['title'] = 'Input Permintaan Obat';
        $data['no_resep'] = '';
        $data['no_register']=$no_register;
        $splitter = substr($no_register,0,2);
        $poli = '';
        $data['paket_obat'] = $this->Frmmdaftar->get_paket_obat()->result();
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_obat']=$this->Frmmdaftar->get_obat_for_luar($id_gudang)->result();

        if(substr($no_register,0,2) == 'RI'){
            $last_obat = $this->Frmmdaftar->last_obat($no_register)->result();
            if($last_obat != null){
                $data['last_obat'] = $last_obat;
            }else{
                $data['last_obat'] = null;
            }
        }elseif (substr($no_register,0,2) == 'RJ') {
            $get_no_medrec = $this->Frmmdaftar->get_data_pasien_resep($no_register)->row()->no_medrec;
            $get_id_poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
            $get_no_register = $this->Frmmdaftar->get_noreg_by_medrec_poli_rj($get_no_medrec,$get_id_poli)->row();
            $gett = isset($get_no_register->no_register)?$get_no_register->no_register:null;
            $last_obat = $this->Frmmdaftar->last_obat($gett)->result();
            if($last_obat != null){
                $data['last_obat'] = $last_obat;
            }else{
                $data['last_obat'] = null;
            }
        }else{
            $data['last_obat'] = null;
        }

        if(substr($no_register,0,2) == 'PL'){
            $data['pengkondisian_poli']= '';
            $poli = '';
        }elseif(substr($no_register,0,2) == 'RJ'){
            $poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
            if ($poli != null) {
                $data['pengkondisian_poli']= $poli;
            }else{
                $data['pengkondisian_poli']= '';
            }
        }elseif(substr($no_register,0,2) == 'RI'){
            $data['pengkondisian_poli']= '';
            $data['noregasal'] = $this->Frmmdaftar->get_noreg_asal($no_register)->row()->noregasal;
        }else{
            $data['pengkondisian_poli']= '';
        }
        $poli != ''?$data['data_obat_poli'] = $this->Frmmdaftar->get_obat_poli_new($poli)->result():'';

        if(substr($no_register, 0,2)=="PL"){
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();

            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['kelas_pasien']=$row->kelas;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']='-';
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['cara_bayar']=$row->cara_bayar;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
            }
        }else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;
                $data['foto']=$row->foto;

            }
            if (substr($no_register, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }
        }

        $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
        foreach ($data['get_data_markup'] as $row) {
            if($row->id_kebijakan=="MU001"){
                $data['fmarkup']=$row->nilai;
            }
            else if($row->id_kebijakan=="PN001"){
                $data['ppn']=$row->nilai;
            }
            else if($row->id_kebijakan=="TS001"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_racik']= '0';
                }else{
                $data['tuslah_racik']=$row->nilai;
                }
            }else if($row->id_kebijakan=="TS002"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_non']=0;
                }else{
                $data['tuslah_non']=0;
                }
            }
        }


        $data['tab_obat'] = 'active';
        $data['tab_racik']  = '';
        if($tab!=''){
            $data['tab_obat'] = '';
            $data['tab_racik'] = 'active';
        }

        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
        $data['data_tindakan_pasien_dokter']=$this->Frmmdaftar->getdata_resep_pasien_dokter($no_register)->result();
        $data['data_tindakan_pasien_farmasi']=$this->Frmmdaftar->getdata_resep_pasien_farmasi($no_register)->result();
        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
        $data['data_tindakan_racikan']=$this->Frmmdaftar->racikracik($no_register)->result();


        //add asesmen dokter
        $obat_rows =$this->Frmmdaftar->getdata_resep_pasien_dokter($no_register)->num_rows();

            foreach ($data['data_tindakan_pasien_dokter'] as $key) {

                $obat_nama_obat[] = $key->nm_obat;
                $obat_signa[] = $key->signa;
                $obat_racikan[] = $key->racikan;
                $obat_id_resep_dokter[] = $key->id_resep_dokter;

            }
            $tidak_ada_obat[] = array("Tidak Ada Obat");

            $tampung_obat= array();
            if ($obat_rows == 0) {
                for ($i=0; $i < $obat_rows ; $i++) {
                    $tampung_obat[] = $tampung_obat[$i];
                }
            }else{
                for ($i=0; $i < $obat_rows ; $i++) {
                    if($obat_racikan[$i] != '1'){
                        $tampung_obat[] = '-'.$obat_nama_obat[$i].' ('.$obat_signa[$i].')<br>';
                    }else{
                        $tampung_obat[] = '-'.$obat_nama_obat[$i].' ('.$obat_signa[$i].')<br>';
                        $daatacicikracikolimpik = $this->Frmmdaftar->get_racik_last($obat_id_resep_dokter[$i])->result();
                        foreach ($daatacicikracikolimpik as $row1) {
                            if ($obat_id_resep_dokter[$i] == $row1->id_resep_pasien) {
                                $tampung_obat[] = '• ' . $row1->nama_obat . ' Dosis '.$row1->dosis.', Satuan '.$row1->satuan.' (' . $row1->qty . ')<br>';
                            }
                        }
                    }

                }
            }
            $gabung_obat = implode($tampung_obat);

            $cek_pasien_apa = substr($no_register,0,2);

            if($cek_pasien_apa == 'RI'){
                $cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
            }else{
                $cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
            }

            // $soap['plan_dokter'] = $gabung_obat;
            $soap['terapi_tindakan_dokter'] = $gabung_obat;
            $id_soap = $cek_soap->row();
            if ($id_soap != null) {
                $this->emmdaftar->update_data_soap($id_soap->id,$soap);
            }else{

            }
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;


        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $dokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
        if($dokter > 0){
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }
        $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
        $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $data['id_poli'] = '';

        $data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
        $data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
        $data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();

        $data['poliklinik'] = $this->Frmmdaftar->get_poliklinik()->result();
        $data['diagnosa'] = $this->Frmmdaftar->get_diagnosa()->result();

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data['id_gudang'] = $group->id_gudang;

        $split_noreg = substr($no_register,0,2);
        $data['tambah_pulang'] = $split_noreg == "RI"??1;
        $data['tarif_embalase'] = $this->Frmmdaftar->get_tarif_embalase()->result();
        $data['obat_igd'] = $this->Frmmdaftar->get_obat_igd($group->id_gudang)->result();

        $this->load->view('farmasi/frmvpermintaan',$data);
    }

    public function get_data_resep_by_id() {
        $id=$this->input->post('id');
		//var_dump($id); die();
		$datajson=$this->Frmmdaftar->get_data_resep_by_id($id)->result();
	    echo json_encode($datajson);
    }

    public function insert_tarif_embalase() {
        $id = $this->input->post('edit_id_hidden');
        //var_dump($id);die();
		$no_register = $this->input->post('no_register_hide');

		$embalase = explode('@',$this->input->post('edit_embalase'));
        $data['ket_embalase'] = $this->input->post('edit_ket');
		$data['embalase'] = $embalase[1];

		$this->Frmmdaftar->insert_tarif_embalase($id, $data);
		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
    }

    public function permintaan_obat_old($no_register='',$tab =''){

        $data['title'] = 'Input Permintaan Obat';
        $data['no_resep'] = '';
        $data['no_register']=$no_register;
        // $data['cara_bayar'] = '';
        // $data['tgl_kun'] = '';
        // $data['nama'] = '';
        // $data['no_cm'] = '';
        // $data['foto'] = '';
        // $data['kelas_pasien'] = '';
        // $data['idrg'] = '';
        // $data['bed'] = '';
        // $data['no_medrec'] = '';

        if(substr($no_register, 0,2)=="PL"){
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();

            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['kelas_pasien']=$row->kelas;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']='-';
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['cara_bayar']=$row->cara_bayar;

                // print_r($data['cara_bayar']);die();
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
            }
        }
        else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
            // print_r($data['data_pasien_resep']);die();
            foreach($data['data_pasien_resep'] as $row){
                // print_r($row->cara_bayar);
                // die();
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;

                $data['foto']=$row->foto;

            }
            if (substr($no_register, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }

            // print_r($data['cara_bayar']);die();
        }

        // print_r($data['data_pasien_resep']);die();


        $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
        // print_r($data);die();
        foreach ($data['get_data_markup'] as $row) {
            if($row->id_kebijakan=="MU001"){
                $data['fmarkup']=$row->nilai;
            }
            else if($row->id_kebijakan=="PN001"){
                $data['ppn']=$row->nilai;
            }
            else if($row->id_kebijakan=="TS001"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_racik']= '0';
                }else{
                $data['tuslah_racik']=$row->nilai;
                }
            }else if($row->id_kebijakan=="TS002"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_non']=0;
                }else{
                $data['tuslah_non']=0;
                }
            }
        }

        //echo $data['tuslah_non'];die();


        $data['tab_obat'] = 'active';
        $data['tab_racik']  = '';
        if($tab!=''){
            $data['tab_obat'] = '';
            $data['tab_racik'] = 'active';
        }


        //$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();

        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
        $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_register)->result();

        // Hapus Tuslah tgl 08-01-2021
        // if ($this->Frmmdaftar->getdata_resep_pasien($no_register)->num_rows() > 0 && $data['cara_bayar']=="UMUM") {
        //     $data['tuslah_non']=3000;
        // }else{
        //     $data['tuslah_non']=0;
        // }
        //end off hapus tuslah
        // echo $data['tuslah_non'];die();
        //get obat from role id
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;


        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $dokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
        if($dokter > 0){
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }
        //$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
        $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
        //$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
        $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        /** Update 12 April 2018 bentrok dengan permintaan obat ruangan */
        //$data['id_poli'] = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
        $data['id_poli'] = '';

        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data['id_gudang'] = $group->id_gudang;

        $this->load->view('farmasi/frmvpermintaan',$data);
    }

    public function permintaan_obat_koreksi($no_register='',$tab =''){
        $data['title'] = 'Koreksi Obat';
        $data['no_resep'] = '';
        $data['no_register']=$no_register;

        if(substr($no_register, 0,2)=="PL"){
        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar_koreksi($no_register)->result();
        foreach($data['data_pasien_resep'] as $row){
            $data['nama']=$row->nama;
            $data['kelas_pasien']=$row->kelas;
            $data['no_medrec']=$row->no_medrec;
            $data['no_cm']='-';
            $data['tgl_kun']=$row->tgl_kunjungan;
            $data['cara_bayar']=$row->cara_bayar;
            $data['idrg']=$row->idrg;
            $data['bed']=$row->bed;
            }
        }else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep_koreksi($no_register)->result();
            // print_r($data['data_pasien_resep']);die();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;
                $data['foto']=$row->foto;

            }
            if (substr($no_register, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }
        }

        $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
        foreach ($data['get_data_markup'] as $row) {
            if($row->id_kebijakan=="MU001"){
                $data['fmarkup']=$row->nilai;
            }
            else if($row->id_kebijakan=="PN001"){
                $data['ppn']=$row->nilai;
            }
            else if($row->id_kebijakan=="TS001"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_racik']= '0';
                }else{
                $data['tuslah_racik']=$row->nilai;
                }
            }else if($row->id_kebijakan=="TS002"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_non']=0;
                }else{
                $data['tuslah_non']=0;
                }
            }
        }
        //echo $data['tuslah_non'];die();


        $data['tab_obat'] = 'active';
        $data['tab_racik']  = '';
        if($tab!=''){
            $data['tab_obat'] = '';
            $data['tab_racik'] = 'active';
        }


        //$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();

        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien_koreksi($no_register)->result();
        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
        $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_register)->result();
        if ($this->Frmmdaftar->getdata_resep_pasien_koreksi($no_register)->num_rows() > 0 && $data['cara_bayar']=="UMUM") {
            $data['tuslah_non']=0;
        }else{
            $data['tuslah_non']=0;
        }
        // echo $data['tuslah_non'];die();
        //get obat from role id
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;


        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $dokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
        if($dokter > 0){
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }
        //$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
        $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
        //$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
        $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
        /** Update 12 April 2018 bentrok dengan permintaan obat ruangan */
        //$data['id_poli'] = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
        $data['id_poli'] = '';

        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data['id_gudang'] = $group->id_gudang;

        $this->load->view('farmasi/frmvkoreksiobat',$data);

    }

    public function permintaan_obat_ruangan($no_register, $id_poli=NULL, $tab =''){
        $data['title'] = 'Input Permintaan Obat';
        $data['no_resep'] = '';
        $data['no_register']=$no_register;

        if(substr($no_register, 0,2)=="PL"){
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            //$data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['kelas_pasien']=$row->kelas;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']='-';
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['cara_bayar']=$row->cara_bayar;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
            }
        }else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
            //$data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;
                $data['foto']=$row->foto;

            }
            if (substr($no_register, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }
        }

        $data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
        foreach ($data['get_data_markup'] as $row) {
            if($row->id_kebijakan=="MU001"){
                $data['fmarkup']=$row->nilai;
            }
            else if($row->id_kebijakan=="PN001"){
                $data['ppn']=$row->nilai;
            }
            else if($row->id_kebijakan=="TS001"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_racik']= '0';
                }else{
                    $data['tuslah_racik']=$row->nilai;
                }
            }else if($row->id_kebijakan=="TS002"){
                if($data['cara_bayar']=="BPJS"){
                    $data['tuslah_non']= '0';
                }else{
                    $data['tuslah_non']=$row->nilai;
                }
            }
        }


        $data['tab_obat'] = 'active';
        $data['tab_racik']  = '';
        if($tab!=''){
            $data['tab_obat'] = '';
            $data['tab_racik'] = 'active';
        }


        //$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();
        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
        $data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();

        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
        $data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_register)->result();

        //get obat from role id
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        // foreach ($id_gudang as $row) {
        //   if($i==1){
        //     $gd = $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result();
        //   }else {
        //     $gd = array_merge($gd, $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result());
        //   }

        //   $i++;
        // }
        // $data['data_obat'] = $gd;
        // $data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();

        $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        $cekDokter = $this->Frmmdaftar->getnama_dokter_poli($no_register)->num_rows();
        if($cekDokter > 0) {
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }
        //$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
        $data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
        //$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
        $data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
        $data['id_poli'] = $data['idrg'];

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data['id_gudang'] = $group->id_gudang;

        //echo print_r($data);

        $this->load->view('farmasi/frmvpermintaan_ruangan',$data);
    }

    public function cek_stok()
    {
        $i=1;
        $no_register=$this->input->post('no_register');
        $idrg=$this->input->post('idrg');
        $bed=$this->input->post('bed');
        $kelas=$this->input->post('kelas_pasien');
        $nm_dokter=$this->input->post('nm_dokter');
        $cara_bayar=$this->input->post('cara_bayar');
        $qty_obat=$this->Frmmdaftar->cek_qty_obat($no_register)->result();

        foreach($qty_obat as $row){
            if($i==1){
                $stok_obat=$this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result();
            }else {
                $stok_obat = array_merge($stok_obat, $this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result());
            }
            $i++;
        }
        $getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
        $vtotobat = intval($getvtotobat);
        $getrdrj=substr($no_register, 0,2);


        // //---------Sementara diBebaskan Dulu Transaksi------
        // if(empty($stok_obat)){//JIKA TIDAK ADA DATA
        //     $tuslah=0;
        //     if($getrdrj=="PL"){
        //         $this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,0,0,1);
        //     }
        //     else if($getrdrj=="RJ"){
        //         $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,0,0, $tuslah,1);
        //     }
        //     else if ($getrdrj=="RI"){
        //         $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,0,0, $tuslah,1);
        //     }
        //     $data = array('status' => 'Stok Tidak Mencukupi');
        //     echo json_encode($data);
        // }
        // else if($stok_obat!=null){
        //     $nm_obat="";
        //     $i=1;
        //     foreach($stok_obat as $row){
        //         if($i==1){
        //             $nm_obat=$row->nama_obat;
        //         }else {
        //             $nm_obat=$nm_obat.', '.$row->nama_obat;
        //         }
        //         $i++;
        //     }
        //     //$data = array('status' => $nm_obat);
        //     $data = array('status' => 'success');
        //     echo json_encode($data);

        // }
        // else {
            //UPDATE STOK
            // foreach($qty_obat as $row){
            //     $this->Frmmdaftar->update_stok_obat($row->id_inventory, $row->qty);
            // }
            //SELESAI RESEP


            // $this->Frmmdaftar->update_data_header($data['no_resep'], $nm_dokter);

            // if ($this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->num_rows() == 0) {
                $this->Frmmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
            // }

            $no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;

            $cek_obat_tuslah = $this->Frmmdaftar->getdata_resep_pasien($no_register);
            if ($cek_obat_tuslah->num_rows() > 0) {
                $tuslah=0;
            }else{
                $tuslah=0;
            }
            if ($cara_bayar != "UMUM") {
                $kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->id_kontraktor;
                if ($kontraktor == 312) {
                    $tuslah=0;
                }
            }
            if($getrdrj=="PL"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$vtotobat,$no_resep);
            }
            else if($getrdrj=="RJ"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$vtotobat,$no_resep, $tuslah, 0, $cara_bayar);
            }
            /*else if ($getrdrj=="RD"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$vtotobat,$no_resep);
            }
            */else if ($getrdrj=="RI"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$vtotobat,$no_resep,$tuslah);
            }

            $tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

        //   print_r('test');die();
           // update history stok
            $this->Frmmdaftar->update_history_stok($no_resep);
           // end off history stok
            $this->Frmmdaftar->update_data_header($no_resep, $nm_dokter, $tuslah);
            $this->Frmmdaftar->update_racikan_selesai($no_register, $no_resep);

            // echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';

            $data = array('status' => 'success',
                        'no_resep' => $no_resep,
                        'jenis_pasien' => $getrdrj,
                        'cara_bayar' => $cara_bayar
                    );
        // print_r($data);die();
            echo json_encode($data);
        // }
    }

    public function cek_stok_koreksi()
    {
        $i=1;
        $no_register=$this->input->post('no_register');
        $idrg=$this->input->post('idrg');
        $bed=$this->input->post('bed');
        $kelas=$this->input->post('kelas_pasien');
        $nm_dokter=$this->input->post('nm_dokter');
        $cara_bayar=$this->input->post('cara_bayar');
        $qty_obat=$this->Frmmdaftar->cek_qty_obat($no_register)->result();

        $getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
        $getrdrj=substr($no_register, 0,2);
        foreach($qty_obat as $row){
            if($i==1){
                $stok_obat=$this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result();
            }else {
                $stok_obat = array_merge($stok_obat, $this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result());
            }
            $i++;
        }
        //---------Sementara diBebaskan Dulu Transaksi------
        if(empty($qty_obat)){//JIKA TIDAK ADA DATA
            $tuslah=0;
            if($getrdrj=="PL"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,0,0,1);
            }
            else if($getrdrj=="RJ"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,0,0, $tuslah,1);
            }
            else if ($getrdrj=="RI"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,0,0, $tuslah,1);
            }

            $cek_obat_tuslah = $this->Frmmdaftar->getdata_resep_pasien_koreksi($no_register);
            if ($cek_obat_tuslah->num_rows() > 0) {
                $tuslah=0;
            }else{
                $tuslah=0;
            }
            $no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;
            $this->Frmmdaftar->update_data_header($no_resep, $nm_dokter, $tuslah);

            $data = array('status' => 'success');
            echo json_encode($data);
        }else {
            //UPDATE STOK
            foreach($qty_obat as $row){
                $this->Frmmdaftar->update_stok_obat($row->id_inventory, $row->qty);
            }

            //SELESAI RESEP

            $getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
            $vtotobat = intval($getvtotobat);
            $getrdrj=substr($no_register, 0,2);

            // $this->Frmmdaftar->update_data_header($data['no_resep'], $nm_dokter);
            $no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;
            $cek_obat_tuslah = $this->Frmmdaftar->getdata_resep_pasien_koreksi($no_register);
            if ($cek_obat_tuslah->num_rows() > 0) {
                $tuslah=0;
            }else{
                $tuslah=0;
            }

            if ($cara_bayar != "UMUM") {
                $kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->id_kontraktor;
                if ($kontraktor == 312) {
                    $tuslah=0;
                }
            }

            if($getrdrj=="PL"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$vtotobat,$no_resep);
            }
            else if($getrdrj=="RJ"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$vtotobat,$no_resep, $tuslah);
            }
            else if ($getrdrj=="RI"){
                $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$vtotobat,$no_resep,  $tuslah);
            }

            $tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

          //   Update history Stok
             $this->Frmmdaftar->update_history_stok($no_resep, $id_gudang);

            $this->Frmmdaftar->update_data_header($no_resep, $nm_dokter, $tuslah);
            $this->Frmmdaftar->update_racikan_selesai($no_register, $no_resep);

            // echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';

            $data = array('status' => 'success',
                        'no_resep' => $no_resep,
                        'cara_bayar' => $cara_bayar
                    );
        // print_r($data);die();
            echo json_encode($data);

        }
    }


    public function force_selesai($no_register){
        $getrdrj=substr($no_register, 0,2);
        $getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
        $vtotobat = intval($getvtotobat);
        $cara_bayar=$this->Frmmdaftar->get_data_pasien_resep($no_register)->row()->cara_bayar;
        if ($cara_bayar == 'BPJS' && $cara_bayar=='KERJASAMA') {
            $tuslah=0;
        }else{
            $tuslah=0;
        }
        $get_no_resep = $this->Frmmdaftar->get_no_resep($no_register)->row();
        if ($get_no_resep != null) {
            $no_resep = $get_no_resep->no_resep;
        }else{
            $no_resep = '';
        }


            if($getrdrj=="PL"){
                $this->Frmmdaftar->force_selesai_daftar_pemeriksaan_PL($no_register,$vtotobat);
            }
            else if($getrdrj=="RJ"){
                $data_iri=$this->Frmmdaftar->getdata_rj($no_register)->result();
				foreach($data_iri as $row){
					$status_obat=$row->status_obat;
				}
				$status_obat = $status_obat + 1;
                $this->Frmmdaftar->force_selesai_daftar_pemeriksaan_IRJ($no_register,$vtotobat, $tuslah,$status_obat);
            }else if ($getrdrj=="RI"){
                $data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
				foreach($data_iri as $row){
					$status_obat=$row->status_obat;
				}
				$status_obat = $status_obat + 1;
                $this->Frmmdaftar->force_selesai_daftar_pemeriksaan_IRI($no_register,$vtotobat,$status_obat);
            }else{

            }

            if ($cara_bayar=="BPJS") {
                redirect('farmasi/Frmcdaftar');
            }else{
                if ($no_resep != '') {
                    redirect('farmasi/Frmckwitansi/cetak_faktur_kt/'.$no_resep);
                }else{
                    redirect('farmasi/Frmcdaftar');
                }
            }
        redirect('farmasi/Frmcdaftar/','refresh');
    }
    public function get_biaya_resep()
    {
        $no_register=$this->input->post('no_register');
        $data=$this->Frmmdaftar->get_vtot_racikan($no_register)->row()->vtot_racikan_obat;
        echo json_encode($data);
    }

    public function get_biaya_tindakan()
    {
        $id_resep=$this->input->post('id_resep');
        $biaya=$this->Frmmdaftar->get_biaya($id_resep)->row()->hargajual;
        echo json_encode($biaya);
    }

    public function get_biaya_kebijakan()
    {
        $id_kebijakan=$this->input->post('id_kebijakan');
        $biaya_markup=$this->Frmmdaftar->get_biaya($id_kebijakan)->row()->nilai;
        echo json_encode($biaya_markup);
    }

    public function get_cara_bayar()
    {
        $no_register=$this->input->post('no_register');
        $cara_bayar=$this->Frmmdaftar->get_cara_bayar($no_register)->row()->cara_bayar;
        echo json_encode($cara_bayar);
    }

    public function get_kontraktor()
    {
        $no_register=$this->input->post('no_register');
        $nmkontraktor=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
        echo json_encode($nmkontraktor);
    }

    public function getnama_dokter_poli()
    {
        $no_register=$this->input->post('no_register');
        $nmdokter=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
        echo json_encode($nmdokter);
    }

    public function insert_permintaan_rad() {
        $ket=$this->input->post('ket');
        $id_dokter = explode('-',$this->input->post('dokter_rad'))[0];
		$nmdokter = explode('-',$this->input->post('dokter_rad'))[2];
        $data['no_register']=$this->input->post('no_register');
        $no_register = $this->input->post('no_register');
        $data['xupdate'] = date('Y-m-d H:i:s');

        $data['no_medrec']=$this->input->post('no_medrec');
        $data['tgl_kunjungan']=date('Y-m-d H:i:s');
        $data['id_dokter'] = $id_dokter;
        $data['nm_dokter'] = $nmdokter;
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        //03-08-2021
        //1 == tidak
        $data['obat_luar']= $this->input->post('jenis_obat');
        //03-08-2021

        $data['resep_pulang']=$this->input->post('resep_pulang');
        $data['bpjs']=$this->input->post('bpjs');
        $data['cara_bayar'] = $this->input->post('jenis_cara_bayar');

        $data['idrg']='LA00';

        $data['bed']='POLI RADIOLOGI';
        $data['no_resep']=$this->input->post('no_resep');
        $no_resep = $this->input->post('no_resep');

        if($this->input->post('qty') == null){
            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Belum Diisi</div>');
            if ($this->input->post('pelayan') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            }
        }else{
            $data['qty']=$this->input->post('qty');
        }

            if ($this->input->post('gantisigna') == 'OTOMATIS') {
                $sgn=$this->input->post('signa');
                $qtx=$this->input->post('qtx');
                $satuan=$this->input->post('satuan');
                $cara_pakai=$this->input->post('cara_pakai');
                $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                    if ($makan==''){
                        $data['signa']="-";
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    } else {
                        $data['signa']=$makan;
                        if ($qtx == null) {
                            $qtxs = 0;
                        }else{
                            $qtxs = $qtx;
                        }
                        $data['qtx']=$qtxs;
                        $data['Satuan_obat']=$satuan;
                        $data['cara_pakai']=$cara_pakai;
                        $data['kali_harian']=$sgn;
                    }
                $signa = $makan;
            }else{
                $sgn=$this->input->post('signa_all');
                $makan = $sgn;
                    if ($makan==''){
                        $data['signa']="-";
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    } else {
                        $data['signa']=$makan;
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    }
                $signa = $makan;
            }

        $data['kelas']=$this->input->post('kelas_pasien');
        $data['fmarkup']=$this->input->post('fmarkup');
        //$data['vtot']=$this->input->post('vtot_hide');
        $data['ppn']=$this->input->post('margin');

        $data['tuslah']=$this->input->post('tuslah_non');
        $data['xinput']=$this->input->post('xuser');
        $data['satelit'] = $this->input->post('satelit');

        // if($data['no_resep']!=''){
        // } else {
        //  $this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
        //  $data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
        // }
        if($this->input->post('jenis_obat') == 0){
            $data['nama_obat']=$this->input->post('cari_obat');
            $data['biaya_obat']=0;
            $data['vtot']=0;
        }else{
            if($this->input->post('idpoli') == 'BA00'){
                if ($this->input->post('obat_biasa_igd') == 'obat_igd') {
                    if($this->input->post('cari_obat_igd') == null){
                        $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                        if ($this->input->post('pelayan') == 'DOKTER') {
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                        }else{
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                        }
                    }else{
                        $data['id_inventory']=$this->input->post('cari_obat_igd');
                    }
                    $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                    $data['item_obat']=$data_tindakan->id_obat;
                    $data['nama_obat']=$data_tindakan->nm_obat;
                    // $data['Satuan_obat']=$data_tindakan->satuank;

                    $nama_obat = $data_tindakan->nm_obat;
                }else{
                    if($this->input->post('idtindakan') == null){
                        $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                        if ($this->input->post('pelayan') == 'DOKTER') {
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                        }else{
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                        }
                    }else{
                        $data['id_inventory']=$this->input->post('idtindakan');
                    }
                    if($ket==1){
                        $data['item_obat']=$this->input->post('item_obat');
                        $data['nama_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";

                        $nama_obat = $this->input->post('cari_obat');
                    }else{
                        $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                        $data['item_obat']=$data_tindakan->id_obat;
                        $data['nama_obat']=$data_tindakan->nm_obat;
                        // $data['Satuan_obat']=$data_tindakan->satuank;

                        $nama_obat = $data_tindakan->nm_obat;
                    }
                }
            }else{
                if($this->input->post('idtindakan') == null){
                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                    if ($this->input->post('pelayan') == 'DOKTER') {
                        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                    }else{
                        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                    }
                }else{
                    $data['id_inventory']=$this->input->post('idtindakan');
                }
                // $data['id_inventory']=$this->input->post('idtindakan');
                if($ket==1){
                    $data['item_obat']=$this->input->post('item_obat');
                    $data['nama_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";

                    $nama_obat = $this->input->post('cari_obat');
                }else{
                    $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                    $data['item_obat']=$data_tindakan->id_obat;
                    $data['nama_obat']=$data_tindakan->nm_obat;
                    // $data['Satuan_obat']=$data_tindakan->satuank;

                    $nama_obat = $data_tindakan->nm_obat;
                }
            }

            $data['id_gudang']= $group->id_gudang;

            $total = $this->input->post('vtot_hide');
            $data['biaya_obat']=$this->input->post('biaya_obat_hide');
            if($this->input->post('cara_bayar') == 'UMUM'){
                //Update Margin Tambahan + Pembulatan 100 jika pasien Umum
                $total_akhir = $total;//(int) (100 * ceil($total / 100));
            }else{
                $total_akhir = $total;
            }
            $data['vtot']=$total_akhir;
    // $stok_obat=$this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();

            //    var_dump($this->input->post('pelayan'));die();
            //radio button bpjs
            /* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/
    // if (empty($stok_obat)) {
    //     $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');
    //         if ($this->input->post('pelayan') == 'DOKTER') {
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
    //         }else{
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
    //         }


    // }
            //update stok

    // $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);
            $kronis = $this->input->post('kronis');
            $poli = $this->input->post('idpoli');

            if($ket!=1){
                $klaim = $this->Frmmdaftar->cek_kronis_klaim($data_tindakan->id_obat, $poli, $kronis);
                $row_klaim = $klaim->row();
                $cek_klaim = $klaim->num_rows();
            }
        }
        $data['kronis'] = $this->input->post('kronis');

        //ini untuk input plan di pemeriksaan fisik
        // $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();

        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */
        if($data['cara_bayar'] == 'BPJS'){

            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
            */
            // if($cek_klaim > 0) {
            //     if($data['qty'] > $row_klaim->qty){
            //         $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
            //     }else{
            //         $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');
            //         $this->Frmmdaftar->insert_permintaan($data);

            //         $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
            //             if ($data_fisik==FALSE) {
            //                 $datafisik['no_register'] = $no_register;
            //                 $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
            //                 //INSERT
            //             } else {
            //                 $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
            //                 // UPDATE
            //             }
            //     }
            // }else{
                $this->Frmmdaftar->insert_permintaan($data);

                // $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                    // if ($data_fisik==FALSE) {
                        // $datafisik['no_register'] = $no_register;
                        // $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                        //INSERT
                    // } else {
                        // $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                        // UPDATE
                    // }
            // }
        }else{
            // var_dump($data);
            // die();
            $this->Frmmdaftar->insert_permintaan($data);

            // $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                // if ($data_fisik==FALSE) {
                    // $datafisik['no_register'] = $no_register;
                    // $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                    //INSERT
                // } else {
                    // $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                    // UPDATE
                // }
        }

        // input untuk laporan assesment awal keperawatan ird;

        if($this->input->post('idpoli') == "BA00"){
            $report['no_register'] = $this->input->post('no_register');
            $report['signa'] = $makan;
            $report['nm_resep'] =$this->input->post('cari_obat');
            $login_data = $this->load->get_var("user_info");
            $report['id_pemeriksa'] = $login_data->userid;
            $report['tgl_input'] = date('Y-m-d H:i:s');
            $this->rdmpelayanan->insert_tindakan_resep_pasien_ird($report);
        }




        if ($this->input->post('koreksi') != '') {
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$data['no_register']);
        }
            if ($this->input->post('pelayan') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            }
    }

    public function insert_permintaan()
    {
        // var_dump($this->input->post('gantisigna'));
        // die();

        $ket=$this->input->post('ket');

        $data['no_register']=$this->input->post('no_register');
        $no_register = $this->input->post('no_register');
        $data['xupdate'] = date('Y-m-d H:i:s');

        $data['no_medrec']=$this->input->post('no_medrec');
        $data['tgl_kunjungan']=date('Y-m-d H:i:s');

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        //03-08-2021
        //1 == tidak
        $data['obat_luar']= $this->input->post('jenis_obat');
        //03-08-2021

        $data['resep_pulang']=$this->input->post('resep_pulang');
        $data['bpjs']=$this->input->post('bpjs');
        $data['cara_bayar'] = $this->input->post('jenis_cara_bayar');

        $data['idrg']=$this->input->post('idrg');

        $data['bed']=$this->input->post('bed');
        $data['no_resep']=$this->input->post('no_resep');
        $no_resep = $this->input->post('no_resep');

        if($this->input->post('qty') == null){
            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Belum Diisi</div>');
            if ($this->input->post('pelayan') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            }
        }else{
            $data['qty']=$this->input->post('qty');
        }

            if ($this->input->post('gantisigna') == 'OTOMATIS') {
                $sgn=$this->input->post('signa');
                $qtx=$this->input->post('qtx');
                $satuan=$this->input->post('satuan');
                $cara_pakai=$this->input->post('cara_pakai');
                $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                    if ($makan==''){
                        $data['signa']="-";
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    } else {
                        $data['signa']=$makan;
                        if ($qtx == null) {
                            $qtxs = 0;
                        }else{
                            $qtxs = $qtx;
                        }
                        $data['qtx']=$qtxs;
                        $data['Satuan_obat']=$satuan;
                        $data['cara_pakai']=$cara_pakai;
                        $data['kali_harian']=$sgn;
                    }
                $signa = $makan;
            }else{
                $sgn=$this->input->post('signa_all');
                $makan = $sgn;
                    if ($makan==''){
                        $data['signa']="-";
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    } else {
                        $data['signa']=$makan;
                        $data['qtx']=0;
                        $data['Satuan_obat']="-";
                        $data['cara_pakai']="-";
                        $data['kali_harian']="-";
                    }
                $signa = $makan;
            }

        $data['kelas']=$this->input->post('kelas_pasien');
        $data['fmarkup']=$this->input->post('fmarkup');
        //$data['vtot']=$this->input->post('vtot_hide');
        $data['ppn']=$this->input->post('margin');

        $data['tuslah']=$this->input->post('tuslah_non');
        $data['xinput']=$this->input->post('xuser');
        $data['satelit'] = $this->input->post('satelit');

        // if($data['no_resep']!=''){
        // } else {
        //  $this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
        //  $data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
        // }
        if($this->input->post('jenis_obat') == 0){
            $data['nama_obat']=$this->input->post('cari_obat');
            $data['biaya_obat']=0;
            $data['vtot']=0;
        }else{
            if($this->input->post('idpoli') == 'BA00'){
                if ($this->input->post('obat_biasa_igd') == 'obat_igd') {
                    if($this->input->post('cari_obat_igd') == null){
                        $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                        if ($this->input->post('pelayan') == 'DOKTER') {
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                        }else{
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                        }
                    }else{
                        $data['id_inventory']=$this->input->post('cari_obat_igd');
                    }
                    $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                    $data['item_obat']=$data_tindakan->id_obat;
                    $data['nama_obat']=$data_tindakan->nm_obat;
                    // $data['Satuan_obat']=$data_tindakan->satuank;

                    $nama_obat = $data_tindakan->nm_obat;
                }else{
                    if($this->input->post('idtindakan') == null){
                        $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                        if ($this->input->post('pelayan') == 'DOKTER') {
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                        }else{
                            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                        }
                    }else{
                        $data['id_inventory']=$this->input->post('idtindakan');
                    }
                    if($ket==1){
                        $data['item_obat']=$this->input->post('item_obat');
                        $data['nama_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";

                        $nama_obat = $this->input->post('cari_obat');
                    }else{
                        $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                        $data['item_obat']=$data_tindakan->id_obat;
                        $data['nama_obat']=$data_tindakan->nm_obat;
                        // $data['Satuan_obat']=$data_tindakan->satuank;

                        $nama_obat = $data_tindakan->nm_obat;
                    }
                }
            }else{
                if($this->input->post('idtindakan') == null){
                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Belum Diisi</div>');
                    if ($this->input->post('pelayan') == 'DOKTER') {
                        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                    }else{
                        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                    }
                }else{
                    $data['id_inventory']=$this->input->post('idtindakan');
                }
                // $data['id_inventory']=$this->input->post('idtindakan');
                if($ket==1){
                    $data['item_obat']=$this->input->post('item_obat');
                    $data['nama_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";

                    $nama_obat = $this->input->post('cari_obat');
                }else{
                    $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                    $data['item_obat']=$data_tindakan->id_obat;
                    $data['nama_obat']=$data_tindakan->nm_obat;
                    // $data['Satuan_obat']=$data_tindakan->satuank;

                    $nama_obat = $data_tindakan->nm_obat;
                }
            }

            $data['id_gudang']= $group->id_gudang;

            $total = $this->input->post('vtot_hide');
            $data['biaya_obat']=$this->input->post('biaya_obat_hide');
            if($this->input->post('cara_bayar') == 'UMUM'){
                //Update Margin Tambahan + Pembulatan 100 jika pasien Umum
                $total_akhir = $total;//(int) (100 * ceil($total / 100));
            }else{
                $total_akhir = $total;
            }
            $data['vtot']=$total_akhir;
    // $stok_obat=$this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();

            //    var_dump($this->input->post('pelayan'));die();
            //radio button bpjs
            /* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/
    // if (empty($stok_obat)) {
    //     $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');
    //         if ($this->input->post('pelayan') == 'DOKTER') {
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
    //         }else{
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
    //         }


    // }
            //update stok

    // $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);
            $kronis = $this->input->post('kronis');
            $poli = $this->input->post('idpoli');

            if($ket!=1){
                $klaim = $this->Frmmdaftar->cek_kronis_klaim($data_tindakan->id_obat, $poli, $kronis);
                $row_klaim = $klaim->row();
                $cek_klaim = $klaim->num_rows();
            }
        }
        $data['kronis'] = $this->input->post('kronis');

        //ini untuk input plan di pemeriksaan fisik
        // $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();

        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */
        if($data['cara_bayar'] == 'BPJS'){

            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
            */
            // if($cek_klaim > 0) {
            //     if($data['qty'] > $row_klaim->qty){
            //         $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
            //     }else{
            //         $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');
            //         $this->Frmmdaftar->insert_permintaan($data);

            //         $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
            //             if ($data_fisik==FALSE) {
            //                 $datafisik['no_register'] = $no_register;
            //                 $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
            //                 //INSERT
            //             } else {
            //                 $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
            //                 // UPDATE
            //             }
            //     }
            // }else{
                $this->Frmmdaftar->insert_permintaan($data);

                // $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                    // if ($data_fisik==FALSE) {
                        // $datafisik['no_register'] = $no_register;
                        // $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                        //INSERT
                    // } else {
                        // $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                        // UPDATE
                    // }
            // }
        }else{
            // var_dump($data);
            // die();
            $this->Frmmdaftar->insert_permintaan($data);

            // $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                // if ($data_fisik==FALSE) {
                    // $datafisik['no_register'] = $no_register;
                    // $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                    //INSERT
                // } else {
                    // $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                    // UPDATE
                // }
        }

        // input untuk laporan assesment awal keperawatan ird;

        if($this->input->post('idpoli') == "BA00"){
            $report['no_register'] = $this->input->post('no_register');
            $report['signa'] = $makan;
            $report['nm_resep'] =$this->input->post('cari_obat');
            $login_data = $this->load->get_var("user_info");
            $report['id_pemeriksa'] = $login_data->userid;
            $report['tgl_input'] = date('Y-m-d H:i:s');
            $this->rdmpelayanan->insert_tindakan_resep_pasien_ird($report);
        }




        if ($this->input->post('koreksi') != '') {
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$data['no_register']);
        }
            if ($this->input->post('pelayan') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            }

        //echo print_r($data);
    }



    public function insert_permintaan_old()
    {
       
        $no_register = $this->input->post('no_register');
        $login_data = $this->load->get_var("user_info");
        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $obatnya = $this->input->post('jumlah_obat[]');
        // var_dump( $obatnya);die();
        $id_poli = $this->Frmmdaftar->get_id_poli_by_noreg($no_register)->row()->id_poli;
        $get_obat = $this->Frmmdaftar->get_data_obat_query()->result_array();

        //  var_dump($get_obat);die();
        foreach($get_obat as $value){
            if($obatnya){
                foreach($obatnya as $pembanding){
                    if($pembanding == $value['id_obat']){
                        $ket=$this->input->post('ket');
                        if($ket==1){
                             $data['id_obat']=$this->input->post('item_obat');
                             $data['nm_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";
                             $nama_obat=$this->input->post('cari_obat'). "(Konsinyasi)";
                        }else{
                             $data['id_obat']=$value['id_obat'];
                             $data['nm_obat']=$value['nm_obat'];
                             $nama_obat=$value['nm_obat'];
                         }


                        $no_register = $this->input->post('no_register');
                        $data['no_register']=$this->input->post('no_register');
                        $data['tgl_kunjungan']=date('Y-m-d H:i:s');
                        $data['no_resep']=$this->input->post('no_resep');

                        $sgn=$this->input->post('signa-'.$value['id_obat']);
                        $qtx=$this->input->post('qtx-'.$value['id_obat']);
                        $satuan=$this->input->post('satuan-'.$value['id_obat']);
                        $cara_pakai=$this->input->post('cara_pakai-'.$value['id_obat']);
                        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                            if ($makan==''){
                                $data['signa']="-";
                                $data['qtx']=0;
                                $data['satuan']="-";
                                $data['cara_pakai']="-";
                                $data['kali_harian']="-";
                            } else {
                                $data['signa']=$makan;
                                if ($qtx == null) {
                                    $qtxs = 0;
                                }else{
                                    $qtxs = $qtx;
                                }
                                $data['qtx']=$qtxs;
                                $data['satuan']=$satuan;
                                $data['cara_pakai']=$cara_pakai;
                                $data['kali_harian']=$sgn;
                            }
                        $signa = $makan;

                        if($this->input->post('qty-'.$value['id_obat'])!= ''){
                            $data['qty']=$this->input->post('qty-'.$value['id_obat']);
                        }else{
                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                                if ($this->input->post('pelayan') == 'DOKTER') {
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                                }else{
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                                }

                        }

                        $data['obat_luar']= '1';
                        $data['no_medrec']=$this->input->post('no_medrec');
                        $data['id_poli']=$this->input->post('idrg');
                        $data['kronis'] = $this->input->post('kronis');
                       
                        $no_resep=$this->input->post('no_resep');            
                        $poli = $this->input->post('idpoli');
                        if($ket!=1){
                            $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['id_obat'], $poli, $data['kronis']);
                            $row_klaim = $klaim->row();
                            $cek_klaim = $klaim->num_rows();
                        }

                        if($data['cara_bayar'] == 'BPJS'){

                            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                            */
                            if($cek_klaim > 0) {

                                if($data['qty'] > $row_klaim->qty){
                                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                                }else{
                                    $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');


                                }
                            }else{
                                $this->Frmmdaftar->insert_permintaan_dokter($data);
                                //fisik

                            }
                        }else{
                            // var_dump($data);
                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                            //fisik

                        }


                    }
                } 
            }else{
                 if ($this->input->post('pelayan') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
                }
            }

        } //foreach1
        // var_dump($data);
        if ($this->input->post('koreksi') != '') {

            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
        }

        // die();
        if ($this->input->post('pelayan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }

        // var_dump($data);
        // die();


        // var_dump($data);die();
        // foreach($this->input->post('cari_obat') as $values){
        //     echo $values;
        //     echo '<br>';
        // }
        // die();


        //echo print_r($data);
    }

    public function edit_obat()
    {
        $no_register=$this->input->post('edit_no_register');
        $id_resep_pasien = $this->input->post('edit_id_resep_pasien');
        $signa=$this->input->post('edit_signa');
        $satuan=$this->input->post('edit_satuan');
        $cara_pakai=$this->input->post('edit_cara_pakai');
        $qty=$this->input->post('edit_qty');
        $qtx=$this->input->post('edit_qtx');
        $qty_old=$this->input->post('edit_qty_hidden');
        $id_obat=$this->input->post('edit_id_obat_hidden');

        $data['qty'] = $qty;
		$data['signa']=strtoupper($signa.", ".$qtx." ".$satuan.", ".$cara_pakai);
		$data['Satuan_obat']=$satuan;
		$data['cara_pakai']=$cara_pakai;
		$data['kali_harian']=$signa;
		if ($qtx == null) {
            $qtxs = 0;
        }else{
            $qtxs = $qtx;
        }
        $data['qtx']=$qtxs;

        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }
        if ($id_obat == null) {
            $this->Frmmdaftar->edit_obat($id_resep_pasien, $data);

            if ($this->input->post('pelayan') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            }
        }else{
            $get_obat = $this->Frmmdaftar->get_data_obat_query_edit($group->id_gudang,$userid,$id_obat)->result_array();
            foreach($get_obat as $value){
                $biaya_obat=$value['hargajual'];
                $id_inventory = $value['id_inventory'];
                $total_akhir = $biaya_obat * $qty;
            }

            $data['vtot']=$total_akhir;

            $cek_qty = $this->Frmmdaftar->cek_qty_gudang($id_inventory)->row()->qty;

    // if($qty_old < $qty){
    //     $kondisiqty = $qty - $qty_old;
    //     $jumlah_qty = $cek_qty - $kondisiqty;
    //     if($jumlah_qty >= 0){
    //         $this->Frmmdaftar->update_stok_obat($id_inventory,$kondisiqty);
    //         $this->Frmmdaftar->edit_obat($id_resep_pasien, $data);


    //         if ($this->input->post('pelayan') == 'DOKTER') {
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
    //         }else{
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
    //         }
    //     }else{

    //         if ($this->input->post('pelayan') == 'DOKTER') {
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
    //         }else{
    //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
    //         }
    //     }

    // }elseif($qty_old > $qty){
    //     $kondisiqty = $qty_old - $qty;
    //     $jumlah_qty = $cek_qty + $kondisiqty;
    //     $this->Frmmdaftar->update_stok_obat_hapus($id_inventory,$kondisiqty);
    //     $this->Frmmdaftar->edit_obat($id_resep_pasien, $data);

    //     if ($this->input->post('pelayan') == 'DOKTER') {
    //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
    //     }else{
    //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
    //     }
    // }else{
                $this->Frmmdaftar->edit_obat($id_resep_pasien, $data);

                if ($this->input->post('pelayan') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
                }
    // }
        }

    }

    public function insert_racikan_selesai()
    {
        //$id_pemeriksaan_lab=$this->input->post('id_poli');
        //$data['no_slip']=$this->input->post('no_slip');

        $data['no_register']=$this->input->post('no_register');
        $data['no_medrec']=$this->input->post('no_medrec');

        $data['tgl_kunjungan']=date('Y-m-d');
        $data['obat_luar']= 1;
        $data['idrg']=$this->input->post('idrg');
        //$data['cara_bayar']=$this->input->post('cara_bayar');
        $data['bed']=$this->input->post('bed');
        if ($this->input->post('no_resep') == '') {
            $data['no_resep']=0;
        }else{
            $data['no_resep']=$this->input->post('no_resep');
        }

        $data['resep_pulang']=$this->input->post('resep_pulang_racik');
        $data['qty']=$this->input->post('qty1');

        $sgn=$this->input->post('signa');
        $qtx=$this->input->post('qtx');
        $satuan=$this->input->post('satuan');
        $cara_pakai=$this->input->post('cara_pakai');
        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
            if ($makan==''){
                $data['signa']="-";
                $data['qtx']=0;
                $data['Satuan_obat']="-";
                $data['cara_pakai']="-";
                $data['kali_harian']="-";
            } else {
                $data['signa']=$makan;
                if ($qtx == null) {
                    $qtxs = 0;
                }else{
                    $qtxs = $qtx;
                }
                $data['qtx']=$qtxs;
                $data['Satuan_obat']=$satuan;
                $data['cara_pakai']=$cara_pakai;
                $data['kali_harian']=$sgn;
            }
            $signa = $makan;

            // $sgn1=$this->input->post('sgn1');
            // $sgn2=$this->input->post('sgn2');
            // $satuan=$this->input->post('satuan');
                // if ($sgn1==''){
                //     $data['signa']="-";
                // } else {
                //     $data['signa']=$sgn1." x Sehari ".$sgn2." ".$satuan;
                // }

        $data['kelas']=$this->input->post('kelas_pasien');
        //$data['biaya_obat']=$this->input->post('biaya_obat_hide');//sum dari db
        $data['fmarkup']=$this->input->post('fmarkup');// dari db
        $data['ppn']=$this->input->post('ppn');
        $data['tuslah']=$this->input->post('tuslah_racik');
        $data['xuser']=$this->input->post('xuser');

        /* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/
        $data['bpjs']=$this->input->post('bpjs_racik');
        if($this->input->post('id_gudang_racikan') != 3){
            $data['cara_bayar']='UMUM';
        }else{
            $data['cara_bayar']='BPJS';
        }
        $data['vtot']=$this->input->post('vtotakhir_hide_racik');
        $data['nama_obat']=$this->input->post('racikan');
        $data['racikan']='1';
        $data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik($data['no_register'])->result();
        foreach($data_biaya_racik as $row){
            $total = $row->total;
            if($this->input->post('cara_bayar') == 'UMUM'){
                $total_akhir = (100 * ceil($total / 100));
            }else{
                $total_akhir = $total;
            }
            $data['biaya_obat']=$total_akhir;
        }


        // var_dump($data['biaya_obat']);die();
        // if($data['no_resep']!=''){
        // } else {
        //  $this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
        //  $data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
        // }

        $this->Frmmdaftar->insert_permintaan($data);
        $id_resep_pasien=$this->Frmmdaftar->get_id_resep($data['no_register'],$data['nama_obat'])->row()->id_resep_pasien;
        
        $datadokter['id_resep_dokter'] = $id_resep_pasien;
        $datadokter['nm_obat']=$this->input->post('racikan');
        $datadokter['no_register']=$this->input->post('no_register');
        $datadokter['tgl_kunjungan']=date('Y-m-d');
        if ($this->input->post('no_resep') == '') {
            $datadokter['no_resep']=0;
        }else{
            $datadokter['no_resep']=$this->input->post('no_resep');
        }
        $sgn=$this->input->post('signa');
        $qtx=$this->input->post('qtx');
        $satuan=$this->input->post('satuan');
        $cara_pakai=$this->input->post('cara_pakai');
        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
            if ($makan==''){
                $datadokter['signa']="-";
                $datadokter['qtx']=0;
                $datadokter['satuan']="-";
                $datadokter['cara_pakai']="-";
                $datadokter['kali_harian']="-";
            } else {
                $datadokter['signa']=$makan;
                if ($qtx == null) {
                    $qtxs = 0;
                }else{
                    $qtxs = $qtx;
                }
                $datadokter['qtx']=$qtxs;
                $datadokter['satuan']=$satuan;
                $datadokter['cara_pakai']=$cara_pakai;
                $datadokter['kali_harian']=$sgn;
            }
            $signa = $makan;
        $datadokter['qty']=$this->input->post('qty1');
        $datadokter['no_medrec']=$this->input->post('no_medrec');
        $datadokter['id_poli']=$this->input->post('idrg');
        $datadokter['obat_racikan']= 1;
        $datadokter['obat_luar']= 1;
        $datadokter['racikan']= 1;
        $this->Frmmdaftar->insert_permintaan_dokter($datadokter);
        // var_dump($id_resep_pasien);
        // die();
        $this->Frmmdaftar->update_racikan($data['no_register'], $id_resep_pasien);

        if($this->input->post('idpoli_racik') != ''){
            // redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$data['no_register'].'/'.$this->input->post('idpoli_racik').'/'.$data['no_resep']);
            // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/'.$data['no_resep']);
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
        }else{
            // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/'.$data['no_resep']);
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
        }

        //print_r($data);
    }

    public function insert_racikan_selesai_petugas()
    {
        $no_register=$this->input->post('no_register');
        // $data['biaya_obat']=$this->input->post('vtot');
        // $data['vtot']=$this->input->post('vtot');
        $id_resep_pasien=$this->input->post('id_resep_petugas');



        $data['qty']=$this->input->post('qty1');

        $data['resep_pulang']=$this->input->post('resep_pulang_racik');
        $sgn=$this->input->post('signa');
        $qtx=$this->input->post('qtx');
        $satuan=$this->input->post('satuan');
        $cara_pakai=$this->input->post('cara_pakai');
        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
            if ($makan==''){
                $data['signa']="-";
                $data['qtx']=0;
                $data['Satuan_obat']="-";
                $data['cara_pakai']="-";
                $data['kali_harian']="-";
            } else {
                $data['signa']=$makan;
                if ($qtx == null) {
                    $qtxs = 0;
                }else{
                    $qtxs = $qtx;
                }
                $data['qtx']=$qtxs;
                $data['Satuan_obat']=$satuan;
                $data['cara_pakai']=$cara_pakai;
                $data['kali_harian']=$sgn;
            }
            $signa = $makan;


        /* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/

        $data['vtot']=$this->input->post('vtotakhir_hide_racik');
        $data['nama_obat']=$this->input->post('racikan');
        $data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik_petugas($no_register,$id_resep_pasien)->result();
        foreach($data_biaya_racik as $row){
            $total = $row->total;
            if($this->input->post('cara_bayar') == 'UMUM'){
                // $total_akhir = (100 * ceil($total / 100));
                $total_akhir = $total;
                // var_dump($total / 100);
                // var_dump(ceil($total / 100));
            }else{
                $total_akhir = $total;
            }
            $data['biaya_obat']=$total_akhir;
        }

        // var_dump($no_register);
        // var_dump($id_resep_pasien);
        // var_dump($data);
        // die();
        $this->Frmmdaftar->update_racikan_petugas($no_register,$id_resep_pasien,$data);
        // $this->Frmmdaftar->insert_permintaan($data);
        // $id_resep_pasien=$this->Frmmdaftar->get_id_resep($no_register,$data['nama_obat'])->row()->id_resep_pasien;
        // $this->Frmmdaftar->update_racikan($no_register, $id_resep_pasien);

        if($this->input->post('idpoli_racik') != ''){
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }

        //print_r($data);

        // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');

        // echo json_encode('success');

    }


    public function insert_racikan()
    {
        $data['no_register']=$this->input->post('no_register');
        $data['no_medrec']=$this->input->post('no_medrec');

        // $data['item_obat']=$this->input->post('idracikan');
        $data['idrg']=$this->input->post('idrg');
        $data['kelas']=$this->input->post('kelas_pasien');
        $data['bed']=$this->input->post('bed');
        $ket=$this->input->post('ket2');

        $jenis_obat = $this->input->post('jenis_obat_racik');
        if($jenis_obat == '1'){
            if($ket==1){
                $data['item_obat']=$this->input->post('item_obat');
                $data['nama_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
                $data['id_inventory']=NULL;
            } else{
                $data['id_inventory']=$this->input->post('idtindakanracik');
                $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->result();
                foreach($data_tindakan as $row){
                    $data['item_obat']=$row->id_obat;
                    $data['nama_obat']=$row->nm_obat;
                    $data['Satuan_obat']=$row->satuank;
                }
            }
        }else{

            $data['item_obat']=0;
            $data['nama_obat']=$this->input->post('cari_obat2');
            $data['id_inventory']=0;
        }


        // $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->result();
        // foreach($data_tindakan as $row){
        //  $data['item_obat']=$row->id_obat;
        //  $data['nama_obat']=$row->nm_obat;
        //  $data['Satuan_obat']=$row->satuank;
        // }
            $data['qty']=1;
            $data['dosis']=$this->input->post('dosis_racikan');
            $data['satuan']=$this->input->post('satuan_racikan');
        if($ket==1){
            $data['id_inventory']=0;
            $data['item_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
            $this->Frmmdaftar->insert_racikan($data['id_inventory'],$data['item_obat'],$data['qty'],$data['no_register'],$data['dosis'],$data['satuan'],$data['nama_obat']);

        }else{
            $this->Frmmdaftar->insert_racikan($data['id_inventory'],$data['item_obat'],$data['qty'],$data['no_register'],$data['dosis'],$data['satuan'],$data['nama_obat']);
            // $this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
        }
        if($this->input->post('idpoli_racik') != ''){
            // redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$data['no_register'].'/'.$this->input->post('idpoli_racik').'/racik');
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER/RACIK');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER/RACIK');
        }
        //redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/racik');
            //print_r($data);
    }


    public function insert_racikan_petugas()
    {

        $data['no_register']=$this->input->post('no_register');
        if ($this->input->post('id_resep_pasien_petugas') == null) {
            // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            echo json_encode(array("status" => FALSE));
        }else{
            $data['id_resep_pasien']=$this->input->post('id_resep_pasien_petugas');
            $data['no_register']=$this->input->post('no_register');
            $data['no_medrec']=$this->input->post('no_medrec');

            // $data['item_obat']=$this->input->post('idracikan');
            $data['idrg']=$this->input->post('idrg');
            $data['kelas']=$this->input->post('kelas_pasien');
            $data['bed']=$this->input->post('bed');
            if ($this->input->post('idtindakanracik') == null) {
                // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                echo json_encode(array("status" => FALSE));
            }else{
                $data['id_inventory']=$this->input->post('idtindakanracik');
            }

            $ket=$this->input->post('ket2');

            if($ket==1){
                $data['item_obat']=$this->input->post('item_obat');
                $data['nama_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
                $data['id_inventory']=NULL;
            } else{
                $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->result();
                foreach($data_tindakan as $row){
                    $data['item_obat']=$row->id_obat;
                    $data['nama_obat']=$row->nm_obat;
                    $data['Satuan_obat']=$row->satuank;
                }
            }
            // $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->result();
            // foreach($data_tindakan as $row){
            //  $data['item_obat']=$row->id_obat;
            //  $data['nama_obat']=$row->nm_obat;
            //  $data['Satuan_obat']=$row->satuank;
            // }
            // var_dump($data);
            // die();
                $data['qty']=0;
                $data['dosis']=$this->input->post('dosis_racikan');
                $data['satuan']=$this->input->post('satuan_racikan');
            if($ket==1){
                $data['id_inventory']=0;
                $data['item_obat']=$this->input->post('cari_obat2'). "(Konsinyasi)";
                $this->Frmmdaftar->insert_racikan_petugas($data['id_resep_pasien'],$data['id_inventory'],$data['item_obat'],$data['qty'],$data['no_register'],$data['dosis'],$data['satuan']);

            }else{
                $this->Frmmdaftar->insert_racikan_petugas($data['id_resep_pasien'],$data['id_inventory'],$data['item_obat'],$data['qty'],$data['no_register'],$data['dosis'],$data['satuan']);
                // $this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
            }
            // if($this->input->post('idpoli_racik') != ''){
                // redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$data['no_register'].'/'.$this->input->post('idpoli_racik').'/racik');
                // echo json_encode(array(
                //     "status" => TRUE,
                //     "no_register" => $data['no_register'],
                //     "id_resep_pasien" => $data['id_resep_pasien']
                // ));
                // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            // }else{
                echo json_encode(array(
                    "status" => TRUE,
                    "no_register" => $data['no_register'],
                    "id_resep_pasien" => $data['id_resep_pasien']
                ));
                // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            // }
            //redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/racik');
            //print_r($data);
        }
    }

    function edit_qty_obat(){
        $idinventory = $this->input->post('idinventory');
        $idobat = $this->input->post('idobat');
        $noregister = $this->input->post('noregister');
        $oldqty = $this->input->post('oldqty');
        $qty = $this->input->post('qty');
        $vtot = $this->input->post('vtot');
        $biaya = $this->input->post('biaya');

        $where = array(
            'no_register' => $noregister,
            'id_inventory' => $idinventory,
            'item_obat' => $idobat
        );

        if((($biaya*$oldqty)*1.15) - $vtot = 0){
            $vtotakhir = ($qty*$biaya)*1.15;
        }else if((($biaya*$oldqty)*1.5) - $vtot = 0){
            $vtotakhir = ($qty*$biaya)*1.5;
        }else if((($biaya*$oldqty)*1.24) - $vtot = 0){
            $vtotakhir = ($qty*$biaya)*1.24;
        }else{
            $vtotakhir = ($qty*$biaya);
        }

        $data = array(
            'qty' => $qty,
            'vtot' => $vtotakhir
        );

        $res = $this->Frmmdaftar->update_qty_pelayanan($data, $where);
        if($res >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

    public function by_date(){
        $date=$this->input->post('date');
        $data['title'] = 'Farmasi Tanggal '.$date;

        $data['farmasi']=$this->Frmmdaftar->get_daftar_pasien_resep_by_date($date)->result();
        $this->load->view('farmasi/frmvdaftarpasien',$data);
    }

    public function by_no()
    {

        $key=$this->input->post('key');
        $data['title'] = 'Farmasi By No Register '.$key;

        $data['farmasi']=$this->Frmmdaftar->get_daftar_pasien_resep_by_no($key)->result();
        $this->load->view('farmasi/frmvdaftarpasien',$data);
    }

    public function cek_harga_obat(){
        $cek_harga=$this->input->post('nama_obat');

        $cek=$this->Frmmdaftar->get_harga_obat($cek_harga)->result();

        $konten = "";
        $konten .="<table class='table table-hover table-bordered table-responsive'>
                    <tr>
                        <td><b>Nama Obat</b></td>
                        <td><b>Satuan Obat</b></td>
                        <td><b>Harga Obat</b></td>
                    </tr>";
        foreach($cek as $row){

            $konten .= "<tr>
                        <td>$row->nm_obat</td>
                        <td>$row->satuank</td>
                        <td>$row->hargajual</td>
                    </tr>";
        }
        $konten .= '</table>';
        echo $konten;
        //print_r($konten);
    }

    public function selesai_daftar_pemeriksaan($no_register='')
    {

         redirect('farmasi/Frmcdaftar/','refresh');
    }

    public function hapus_data_pemeriksaan($no_register='', $id_resep_pasien='', $no_resep='')
    {
        $id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);

        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$no_resep);

        //print_r($id);
    }

    // public function hapus_data_racikan($no_register='', $id_obat_racikan='')
    // {
    //  $id=$this->Frmmdaftar->hapus_data_racikan($id_obat_racikan);

    //  redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/resep');

    //  //print_r($id);
    // }

    public function get_data_edit_obat(){
        $id_resep_pasien=$this->input->post('id_resep_pasien');
        $datajson=$this->Frmmdaftar->get_resep_pasien($id_resep_pasien)->result();
        echo json_encode($datajson);
    }

    public function get_data_edit_obat_racikan(){
        $id_obat_racikan=$this->input->post('id_racikan');
        $id_obat = $this->input->post('id_obat');
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $datajson['sub']=$this->rimtindakan->get_data_obat_sub($id_obat)->result();
        $datajson['resep']=$this->Frmmdaftar->get_resep_pasien_farmasi_racik($id_obat_racikan,$id_gudang)->result();
        $datajson['racik']=$this->Frmmdaftar->get_resep_pasien_racikan($id_obat_racikan)->result();
        echo json_encode($datajson);
    }

    // function get_resep_pasien_racikan($id_obat_racikan){
    //     return $this->db->query("SELECT * from obat_racikan a, master_obat b
    //     where a.item_obat = b.id_obat and id_obat_racikan='$id_obat_racikan'");
    // }

	public function get_data_edit_obat_racikan_petugas($id_resep_pasien,$no_register){
        $data=$this->Frmmdaftar->get_resep_pasien_racikan_petugas($id_resep_pasien)->result();


        $i = 0;
        $v = 0;
        $vtot = 0;
        foreach ($data as $row) {

                $v = $row->hargajual * $row->qty;
                $vtot = $vtot + $v;

                $i++;
                echo "<tr>
                        <td align=\"center\">$i</td>
                        <td>$row->nm_obat</td>
                        <td>$row->hargajual</td>
                        <td>$row->dosis</td>
                        <td>$row->satuan</td>
                        <td align=\"center\">$row->qty</td>

                        <td>".number_format($v, 2, ',', '.')."</td>
                        <td>
                            <a class=\"btn btn-danger btn-xs text-white\" onclick=\"hapus_obat_racikan('$row->no_register','$row->id_obat_racikan','$id_resep_pasien')\">Hapus</a>
                            <button type=\"button\" class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#editModalracikan\"  onclick=\"edit_obat_racikan('$row->no_register','$row->id_obat_racikan','$id_resep_pasien')\">Edit</button>
                        </td>
                    </tr>";
        }

            echo "<tr>
                    <td colspan=\"5\" align=\"right=\"><b>Total</b></td>
                    <td>Rp <div class=\"pull-right=\">".number_format($vtot, 2, ',', '.')."
                                <input type=\"hidden\" class=\"form-control\"
                                    value=\"$vtot\" name\"vtot_racikan_petugas\" id=\"vtot_racikan_petugas\"></b></div>
                                <input type=\"hidden\" class=\"form-control\"
                                    value=\"$id_resep_pasien\" name\"id_resep_pasien_petugas\" id=\"id_resep_pasien_petugas\">
                    </td>
                </tr>";
            // echo "<button type=\"submit\" class=\"btn btn-primary\" onclick=\"selesai_racik('$no_register','$id_resep_pasien','$vtot')\">Selesai Racik</button>";
	}

    public function get_data_edit_obat_racikan_selesai_petugas(){
        $id_resep_pasien = $this->input->post('id_resep_pasien');
        $data2=$this->Frmmdaftar->get_resep_pasien_racikan_selesai_petugas($id_resep_pasien)->row();
        echo json_encode(
            array(
                'status' => 'success',
                'data' => $data2
            )
        );
	}


    public function hapus_data_obat($pelayan='' ,$no_register='', $id_obat_racikan='', $qty='', $id_poli='', $koreksi=null)
    {
        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }

        // $poli = $this->Frmmdaftar->get_id_poli_by_noreg($no_register)->row()->id_poli;
        // $get_obat = $this->Frmmdaftar->get_data_obat_query($group->id_gudang,$userid,$poli)->result_array();

        // foreach($get_obat as $value){
        //     $biaya_obat=$value['hargajual'];
        //     $id_inventory = $value['id_inventory'];
        // }

        $obat=$this->Frmmdaftar->get_resep_pasien($id_obat_racikan)->row();

        // if ($obat->id_inventory == '') {

        // }else{
    // $this->Frmmdaftar->update_stok_obat_hapus($obat->id_inventory, $obat->qty);
        // }

        $id=$this->Frmmdaftar->hapus_data_obat($id_obat_racikan);


        if ($koreksi != null) {
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/' . $no_register);
        }
        if($id_poli != ''){
            if ($pelayan == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            }
        }else {

                $data = array('status' => 'success');
                // $tes=$this->Frmmdaftar->get_all_resep_pasien($no_register,$obat->no_medrec)->row();
                // var_dump($no_register);
                // var_dump();
                // var_dump($tes);
                // die();

            // echo json_encode($data);
            if ($pelayan == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            }

        }

        //print_r($id);
    }

    public function hapus_data_obat_racik($pelayan='' ,$no_register='', $id_resep_pasien='', $idpoli='')
    {
        $id=$this->Frmmdaftar->hapus_data_obat($id_resep_pasien);
        $id2=$this->Frmmdaftar->hapus_data_obat_racik($id_resep_pasien);

        if($idpoli != ''){
            // redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/' . $no_register . '/' . $idpoli);
            if ($pelayan == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            }
        }else {
            if ($pelayan == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            }
        }

        //print_r($id);
    }

    public function hapus_data_racikan($no_register='', $id_obat_racikan='')
    {
        $id=$this->Frmmdaftar->hapus_data_racikan($id_obat_racikan);
        $id_resep_pasien = $this->input->post('id_resep_pasien');

        if($id == true){
            echo json_encode(array(
                "status" => TRUE,
                "no_register" => $no_register,
                "id_resep_pasien" => $id_resep_pasien
            ));
        }else{
            echo json_encode(array(
                "status" => FALSE
            ));
        }


        // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/resep');

        //print_r($id);
    }

    public function hapus_data_racikan_ruangan($no_register='', $id_obat_racikan='', $id_poli='')
    {
        $id=$this->Frmmdaftar->hapus_data_racikan($id_obat_racikan);

        redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/'.$id_poli.'/resep');

        //print_r($id);
    }

    public function daftar_pasien_luar()
    {
        $login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data['xuser']=$user;
		$data['nama']=$this->input->post('nama');
		$data['usia']=$this->input->post('usia');
		$data['jk']=$this->input->post('jk');
		$data['alamat']=$this->input->post('alamat');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');
		$data['obat']='1';
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['cara_bayar']='UMUM';
		$data['jenis_PL']='FARMASI';

        $this->Frmmdaftar->insert_pasien_luar($data);

        redirect('farmasi/Frmcdaftar/');
        //print_r($data);
    }

    public function selesai_pengambilan(){
        $login_data = $this->load->get_var("user_info");
        $no_resep=$this->input->post('no_resep');
        $xambil = $login_data->username;
        $datajson=$this->Frmmdaftar->selesai_pengambilan($no_resep,$xambil);

        echo json_encode($datajson);

    }
    

    public function cari_data_obat(){
       // $keyword = $this->uri->segment(4);


        // //get obat from role id
        //    $login_data = $this->load->get_var("user_info");
        //    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        //    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        //    $i=1;

        //    foreach ($id_gudang as $row) {
        //      if($i==1){
        //         $data = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
            //      ->from('gudang_inventory g')
            //      ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
            //      ->where('g.id_gudang', $row->id_gudang)
            //      ->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
        //        // $gd = $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result();
        //      }else {
        //         $data1 = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
            //      ->from('gudang_inventory g')
            //      ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
            //      ->where('g.id_gudang', $row->id_gudang)
            //      ->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
        //        $data = array_merge($data, $data1);
        //      }

        //      $i++;
        //    }
        if($_GET['jenis_obat']==1){
            $login_data = $this->load->get_var("user_info");
            $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
    
            $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
            $i=1;
    
            foreach ($id_gudang as $row) {
                $no_gudang[]=$row->id_gudang;
            }
    
            // var_dump($id_gudang);
            // die();
            $userid = $this->session->userid;
            $group = $this->Frmmpo->getIdGudang($userid);
            // if($group->id_gudang == "8" || $group->id_gudang == "7"){
            //     $ids = "1";
            // }else{
                // $ids = "1";
                $ids = join(",",$no_gudang);
                // $tes = join(">",0);
            // }
    
            $keyword = $_GET['term'];
            // $data = $this->db->select('o.id_obat,
            // o.nm_obat,
            // g.hargabeli,
            // g.hargajual,
            // g.batch_no,
            // g.expire_date,
            // g.qty,
            // o.jenis_obat,
            // g.id_inventory')
            //         ->from('gudang_inventory g')
            //         ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
            //         ->where('g.id_gudang', $ids)
            //         //  ->where('g.qty > 0' )
            //         ->where('o.deleted', '0')
            //         ->like('UPPER(nm_obat)',strtoupper($keyword))->limit(20, 0)->get();
    
            $data = $this->db->select('id_obat,
            nm_obat,
            jenis_obat,
            ')
                    ->from('master_obat')
                    ->where('deleted', '0')
                    ->where('id_obat >= 6000')
                    ->like('UPPER(nm_obat)',strtoupper($keyword))->limit(20, 0)->get();
    
                    $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    // $new_row['label']=$row['nm_obat']." (batch-".$row['batch_no'].",".$row['expire_date'].",".$row['qty'].")";
                    $new_row['label']=$row['nm_obat'];
                    $new_row['value']=$row['nm_obat'];
                    $new_row['idobat'] = $row['id_obat'];
                    // $new_row['idinventory'] = $row['id_inventory'];
                    $new_row['nama']  =$row['nm_obat'];
                    // $new_row['harga'] = $row['hargajual'];
                    // $new_row['hargabeli'] = $row['hargabeli'];
                    // $new_row['batch_no'] = $row['batch_no'];
                    // $new_row['expire_date'] = $row['expire_date'];
                    // $new_row['qty'] = $row['qty'];
                    $new_row['jenis_obat'] = $row['jenis_obat'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }
         //    if(!empty($data)){
            //  foreach($data as $row)
            //  {
            //      $arr['query'] = $keyword;
            //      $arr['suggestions'][] = array(
            //          'value' => $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",<font color='red'>".$row->qty."</font>)",
            //          'idobat' => $row->id_obat,
            //          'idinventory' => $row->id_inventory,
            //          'nama'  =>$row->nm_obat,
            //          'harga' => $row->hargajual,
            //          'hargabeli' => $row->hargabeli,
            //          'batch_no' => $row->batch_no,
            //          'expire_date' => $row->expire_date,
            //          'qty' => $row->qty,
            //          'jenis_obat' => $row->jenis_obat
            //      );
            //  }
            // }
            // // minimal PHP 5.2
            // echo json_encode($arr);
            }
            else{
                $login_data = $this->load->get_var("user_info");
                $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
    
                $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
                $i=1;
    
                foreach ($id_gudang as $row) {
                    $no_gudang[]=$row->id_gudang;
                }
    
                $userid = $this->session->userid;
                $group = $this->Frmmpo->getIdGudang($userid);
                // if($group->id_gudang == "8" || $group->id_gudang == "7"){
                //     $ids = "1";
                // }else{
                    $ids = join("','",$no_gudang);
                // }
                $keyword = $_GET['term'];
                $data = $this->db->select('id_obatk, nm_obatk, hargajual, hargabeli, ket')
                        ->from('obat_konsinyasi')
                        // ->where('id_gudang', $ids)
                        ->like('nm_obatk',$keyword)->limit(20, 0)->get();
                $arr='';
                if($data->num_rows() > 0){
                    foreach ($data->result_array() as $row){
                        $new_row['label']=$row['nm_obatk'];
                        $new_row['value']=$row['nm_obatk'];
                        $new_row['idinventory'] = '0';
                        $new_row['idobat'] = $row['id_obatk'];
                        $new_row['nama']  =$row['nm_obatk'];
                        $new_row['harga'] = $row['hargajual'];
                        $new_row['hargabeli'] = $row['hargabeli'];
                        $new_row['ket'] = $row['ket'];
                        $row_set[] = $new_row; //build an array
                    }
                    echo json_encode($row_set); //format the array into json data
                } else {
                    echo json_encode([]);
                }
            }
    }

    public function cari_data_obat_racik(){
        // $keyword = $this->uri->segment(4);


        // //get obat from role id
        //    $login_data = $this->load->get_var("user_info");
        //    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        //    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        //    $i=1;

        //    foreach ($id_gudang as $row) {
        //      if($i==1){
        //         $data = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
            //      ->from('gudang_inventory g')
            //      ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
            //      ->where('g.id_gudang', $row->id_gudang)
            //      ->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
        //        // $gd = $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result();
        //      }else {
        //         $data1 = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
            //      ->from('gudang_inventory g')
            //      ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
            //      ->where('g.id_gudang', $row->id_gudang)
            //      ->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
        //        $data = array_merge($data, $data1);
        //      }

        //      $i++;
        //    }
        if($_GET['jenis_obat']==1){
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        // var_dump($id_gudang);
        // die();
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
            // $ids = "1";
            $ids = join(",",$no_gudang);
            // $tes = join(">",0);
        // }

        $keyword = $_GET['term'];
        $data = $this->db->select('o.id_obat,
        o.nm_obat,
        g.hargabeli,
        g.hargajual,
        g.batch_no,
        g.expire_date,
        g.qty,
        o.jenis_obat,
        g.id_inventory')
                ->from('gudang_inventory g')
                ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
                ->where('g.id_gudang', $ids)
                //  ->where('g.qty > 0' )
                ->where('o.deleted', '0')
                ->like('UPPER(nm_obat)',strtoupper($keyword))->limit(20, 0)->get();

                $arr='';
        if($data->num_rows() > 0){
            foreach ($data->result_array() as $row){
                $new_row['label']=$row['nm_obat']." (batch-".$row['batch_no'].",".$row['expire_date'].",".$row['qty'].")";
                $new_row['value']=$row['nm_obat'];
                $new_row['idobat'] = $row['id_obat'];
                $new_row['idinventory'] = $row['id_inventory'];
                $new_row['nama']  =$row['nm_obat'];
                $new_row['harga'] = $row['hargajual'];
                $new_row['hargabeli'] = $row['hargabeli'];
                $new_row['batch_no'] = $row['batch_no'];
                $new_row['expire_date'] = $row['expire_date'];
                $new_row['qty'] = $row['qty'];
                $new_row['jenis_obat'] = $row['jenis_obat'];
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        } else {
            echo json_encode([]);
        }
     //    if(!empty($data)){
        //  foreach($data as $row)
        //  {
        //      $arr['query'] = $keyword;
        //      $arr['suggestions'][] = array(
        //          'value' => $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",<font color='red'>".$row->qty."</font>)",
        //          'idobat' => $row->id_obat,
        //          'idinventory' => $row->id_inventory,
        //          'nama'  =>$row->nm_obat,
        //          'harga' => $row->hargajual,
        //          'hargabeli' => $row->hargabeli,
        //          'batch_no' => $row->batch_no,
        //          'expire_date' => $row->expire_date,
        //          'qty' => $row->qty,
        //          'jenis_obat' => $row->jenis_obat
        //      );
        //  }
        // }
        // // minimal PHP 5.2
        // echo json_encode($arr);
        }
        else{
            $login_data = $this->load->get_var("user_info");
            $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

            $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
            $i=1;

            foreach ($id_gudang as $row) {
                $no_gudang[]=$row->id_gudang;
            }

            $userid = $this->session->userid;
            $group = $this->Frmmpo->getIdGudang($userid);
            // if($group->id_gudang == "8" || $group->id_gudang == "7"){
            //     $ids = "1";
            // }else{
                $ids = join("','",$no_gudang);
            // }
            $keyword = $_GET['term'];
            $data = $this->db->select('id_obatk, nm_obatk, hargajual, hargabeli, ket')
                    ->from('obat_konsinyasi')
                    ->where('id_gudang', $ids)
                    ->like('nm_obatk',$keyword)->limit(20, 0)->get();
            $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    $new_row['label']=$row['nm_obatk'];
                    $new_row['value']=$row['nm_obatk'];
                    $new_row['idinventory'] = '0';
                    $new_row['idobat'] = $row['id_obatk'];
                    $new_row['nama']  =$row['nm_obatk'];
                    $new_row['harga'] = $row['hargajual'];
                    $new_row['hargabeli'] = $row['hargabeli'];
                    $new_row['ket'] = $row['ket'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }
        }
    }

    //     public function cari_data_obat_konsinyasi(){
    //     $keyword = $this->uri->segment(4);
    //     $data = $this->db->select('id_obatk, nm_obatk, hargajual, hargabeli')
    //             ->from('obat_konsinyasi')
    //             ->like('nm_obatk',$keyword)->limit(20, 0)->get()->result();
    //     $arr='';
    //     if(!empty($data)){
    //         foreach($data as $row)
    //         {
    //             $arr['query'] = $keyword;
    //             $arr['suggestions'][] = array(
    //                 'value' => $row->nm_obatk,
    //                 'idobat' => $row->id_obatk,
    //                 'nama'  =>$row->nm_obatk,
    //                 'harga' => $row->hargajual,
    //                 'hargabeli' => $row->hargabeli
    //             );
    //         }
    //     }
    //     // minimal PHP 5.2
    //     echo json_encode($arr);
    // }

    public function cari_data_obat_all(){

        $keyword = $_GET['term'];

        $data = $this->db->select('*')
                ->from('master_obat')
                ->like('UPPER(nm_obat)',strtoupper($keyword))->limit(20, 0)->get()->result();
        $arr= '';
        if(!empty($data)){
            foreach($data as $row)
            {



            }
            echo json_encode([]);
        }else {
            echo json_encode([]);
        }

        // minimal PHP 5.2

    }

    public function cari_data_obat_by_gudang(){

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

        $keyword = $this->uri->segment(4);
        $data = $this->db->select('g.`id_obat`, o.`nm_obat`, o.`hargajual`, o.`hargabeli`, g.`batch_no`,
            g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`satuank`')
                ->from('gudang_inventory g')
                ->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
                ->where('g.`id_gudang`', $group)
                ->like('o.`nm_obat`', $keyword)->limit(20, 0)->get()->result();
        $arr='';
        if(!empty($data)){
            foreach($data as $row)
            {
                $arr['query'] = $keyword;
                $arr['suggestions'][] = array(
                    'value' => $row->nm_obat." BATCH: ".$row->batch_no." STOK: ".$row->qty,
                    'idobat' => $row->id_obat,
                    'nama'  =>$row->nm_obat,
                    'harga' => $row->hargajual,
                    'hargabeli' => $row->hargabeli,
                    'batch_no' => $row->batch_no,
                    'expire_date' => $row->expire_date,
                    'satuank' => $row->satuank,
                    'qty' => 0,
                    'jenis_obat' => $row->jenis_obat
                );
            }
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    public function get_margin_carabayar(){
        $cara_bayar = $this->input->post('carabayar');
        $margin = $this->Frmmdaftar->get_margin_obat($cara_bayar)->result();

        $no = 0;
        echo "<select class=\"form-control\" style=\"width: 100%\" name=\"margin\" id=\"margin\" onchange=\"set_total_akhir()\" disabled>";
            foreach ($margin as $margins){ $no++;
                /*echo "<input type='radio' name='group5".$no."' id='group5".$no."' class='radio-col-red' value='".$margins->pengali."' onclick=\"set_total_akhir(this.value)\"
                    ".($no == 1 ? ' checked' : '').">
                    <label for='group5".$no."'>".$margins->persentase." % ".$margins->keterangan."</label>";*/
                echo "<option value='".$margins->pengali."'>".$margins->persentase." % ".$margins->keterangan."</option>";
            }
        echo "</select>";
    }

    public function get_margin_carabayar_racik(){
        $cara_bayar = $this->input->post('carabayar');
        $margin = $this->Frmmdaftar->get_margin_obat($cara_bayar)->result();

        echo "<select class=\"form-control\" style=\"width: 100%\" name=\"margin_racik\" id=\"margin_racik\" onchange=\"set_total_akhir_racik()\">";
        foreach ($margin as $margins){
            /*echo "<input type='radio' name='group5".$no."' id='group5".$no."' class='radio-col-red' value='".$margins->pengali."' onclick=\"set_total_akhir(this.value)\"
                ".($no == 1 ? ' checked' : '').">
                <label for='group5".$no."'>".$margins->persentase." % ".$margins->keterangan."</label>";*/
            echo "<option value='".$margins->pengali."'>".$margins->persentase." % ".$margins->keterangan."</option>";
        }
        echo "</select>";

        /*foreach ($margin as $margins){
        */?><!--
        <input type="radio" name="margin_racik" id="margin_racik" value="<?/*=$margins->pengali*/?>" onclick="set_total_akhir_racik(this.value)"
        <?php
        /*      if($cara_bayar=='UMUM' && $margins->keterangan=='Umum'){
                    echo "checked";
                }else if($cara_bayar=='BPJS' && $margins->keterangan=='BPJS'){
                    echo "checked";
                }
                */?> >
                &nbsp;<?/*=$margins->persentase*/?> % &nbsp;&nbsp;<?/*=$margins->keterangan*/?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                --><?php
        /*        }*/
    }

    public function roundUpToNearestHundred($n){
        return (int) (100 * ceil($n / 100));
    }

    public function roundUpToNearestThousand($n){
        return (int) (1000 * ceil($n / 1000));
    }


	public function cetak_resep_obat($no_resep,$item_obat)
	{
		error_reporting(~E_ALL);
		//UNTUK GET NO_REGISTER
		$a=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();

				foreach($a as $row){
				$no_register= $row->no_register;
			}


		$data_tindakan_racik=$this->Frmmkwitansi->getdata_resep_racik($no_register)->result();
		//END GET REGISTER
		$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
            $tgl_now = date('Y-m-d');


			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');

		$getrdrj=substr($no_register, 0,2);
		if ($getrdrj == "RJ") {
			$tuslah= 0;//$this->Frmmkwitansi->get_tuslah_irj($no_register)->row()->tuslah;
		}elseif ($getrdrj == "RI") {
			$tuslah=0;//$this->Frmmkwitansi->get_tuslah_iri($no_register)->row()->tuslah;
		}

		if($no_resep!=''){

			$diskon = 0;

			$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			//	print_r($data_pasien);die();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$no_cm=$row->no_cm;
					$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
					$tgl_lahir=$row->tgl_lahir;
				}


			$data_header=$this->Frmmdaftar->getnama_dokter_poli($no_register)->result();

		//	print_r($data_header);die();
				foreach($data_header as $row){
					$nmdokter=$row->nmdokter;

				}


			if (substr($no_register,0,2)=="PL"){
				$data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				foreach($data_ruang as $row){
					$nmruang='Pasien Luar';
				}

			}
            $data_obat = $this->Frmmdaftar->get_data_permintaan($no_resep,$no_medrec,$no_register,$item_obat)->result();
            foreach($data_obat as $row){
                $nama_obat=$row->nama_obat;
                $qty=$row->qty;
                $signa=$row->signa;
            }
            $group = $this->Frmmpo->getIdGudang($userid);

            $kadaluarsa = $this->Frmmdaftar->get_tgl_kadaluarsa($item_obat,$group->id_gudang)->result();
            foreach($kadaluarsa as $row){
                $tgL_kadaluarsa=$row->expire_date;
            }
            // var_dump($item_obat);
            // die();

			//cetak resep

				$konten=
				"<style>
                *{
                    font-weight:bold;
                }
                header{
                    width: 100%;
                    font-size: 10px;
                    display: inline;
                    position: absolute;
                }

                .header-parent{
                    width: 100%;
                    display: inline;
                    position: absolute;
                }
                .left{
                    float: left;
                }

                .right{
                    float: right;
                    font-size: 10px;
                }

                table{
                    font-size:10px;
						padding : 0px 1px 0.5px 1px;
						width:98%;
                        height: 100%;
                }



        </style>
        <br>
        <br>
        <table border=\"2\">
            <tr>
                <td>
                    <header>

                            <table>
                                <tr>
                                    <td style=\"width: 15%;\"><img src=\"assets/images/logos/".$this->config->item('logo_url')."\" height=\"40px\" width=\"40px\" class=\"left\"></td>
                                    <td style=\"width: 85%;\">
                                        <label>RS.OTAK DR.Drs.M.HATTA BKT</label><br>
                                        <label>DEPO FARMASI RAWAT JALAN</label>
                                    </td>
                                </tr>
                            </table>

                    </header>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>No.Resep : $no_resep</td>
                            <td style=\"float: right;\">TGL : $tgl</td>
                        </tr>
                        <tr>
                            <td>$nama</td>
                            <td style=\"float: right;\">RM : $no_cm</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style=\"float: right;\">Lhr : $tgl_lahir</td>
                        </tr>
                        <tr>
                            <td colspan=\"2\">Nama Obat : $nama_obat</td>
                        </tr>
                        <tr>
                            <td>Tgl. Kadaluarsa : $tgL_kadaluarsa</td>
                            <td style=\"float: right;\">Jlh : $qty</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div style=\"text-align: center;\">
                        <label><b>$signa</b></label>
                    </div>
                </td>
            </tr>
        </table>


				";






			$file_name="fobat_no_resep_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$pageLayout = array('280', '185'); //  or array($height, $width)
				$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);
				// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";

				$fontname = TCPDF_FONTS::addTTFfont(FCPATH.'asset/font/Calibri.ttf', 'TrueTypeUnicode', '', 32);

				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('1', '1', '1');
				$obj_pdf->SetAutoPageBreak(TRUE, '1');
				$obj_pdf->SetFont('helvetica', '', 9);
				// $obj_pdf->SetFont($fontname, '', 12, '', false);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				// ob_start();
				ob_clean();
				ob_flush();
					$content = $konten;
				ob_end_flush();
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');

		}else{
			redirect('farmasi/Frmcdaftar/','refresh');
		}
	}

    public function resepobat()
	{
        $data['title'] = 'Resep Obat Pasien';
		$this->load->view('farmasi/frmvresepobatpasien',$data);
	}


    public function get_data_resep(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmdaftar->get_resep_obat($date)->result();
        foreach ($hasil as $value) {
            $no_register = $value->no_register;

            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-Y | H:i',strtotime($value->tgl_kunjungan));
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Daftar Resep<br/>Obat</button>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    public function get_data_resep_detail(){
        $no_register = $this->input->post('no_register');

        $line   = array();
        $line2  = array();
        $row2   = array();

        $i = 1; $ttot = 0;
        $hasil = $this->Frmmdaftar->get_data_rekap_detail($no_register)->result();
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = $value->xupdate;
            $row2['nama'] = $value->nama_obat;
            $row2['harga'] = "<div align=\"right\">".number_format($value->biaya_obat, '0', ',', '.')."</div>";
            $row2['signa'] = $value->signa;
            $row2['qty'] = "<div align=\"right\">".number_format($value->qty, '0', ',', '.')."</div>";
            $row2['total'] = "<div align=\"right\">".number_format($value->vtot, '0', ',', '.')."</div>";
            $row2['aksi'] = "<a href=".site_url("farmasi/frmcdaftar/cetak_resep_obat/".$value->no_resep."/".$value->item_obat)." target=\"_blank\">cetak resep</a>";

            $ttot += $value->vtot;

            $line2[] = $row2;
        }

        $line['data'] = $line2;
        $line['total'] = "<h4>Total Akhir:&nbsp;&nbsp;&nbsp; Rp. ".number_format($ttot, '2', ',', '.')."</h4>";
        echo json_encode($line);
    }

    public function telaah_obat($noreg)
    {
        $data['no_register'] = $noreg;
        $data['hasil'] = $this->Frmmdaftar->get_data_rekap_detail($noreg)->result();
        $data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($noreg)->result();
        $data['survey_telaah_obat'] = $this->Frmmdaftar->data_telaah($noreg)->row();
        $this->load->view('farmasi/telaah_obat/frmvtelaahobat',$data);
    }

    public function insert_telaah()
    {
        $raw = json_decode($this->input->post('data'));

        $data['formjson'] = $this->input->post('data');
        // var_dump($data['formjson']);die();
        $data['no_register'] = $this->input->post('no_register');
        // $data['tulisan_jelas'] = isset($raw->telaah_resep->tulisan_jelas)?$raw->telaah_resep->tulisan_jelas:'';
        // $data['benar_nama_obat'] = isset($raw->telaah_resep->benar_nama_obat)?$raw->telaah_resep->benar_nama_obat:'';
        // $data['benar_kekuatan_obat'] = isset($raw->telaah_resep->benar_kekuatan_obat)?$raw->telaah_resep->benar_kekuatan_obat:'';
        // $data['benar_frekuensi'] = isset($raw->telaah_resep->benar_frekuensi)?$raw->telaah_resep->benar_frekuensi:'';
        // $data['pemberian'] = isset($raw->telaah_resep->pemberian)?$raw->telaah_resep->pemberian:'';
        // $data['benar_rute'] = isset($raw->telaah_resep->benar_rute)?$raw->telaah_resep->benar_rute:'';
        // $data['ada_duplikasi'] = isset($raw->telaah_resep->ada_duplikasi)?$raw->telaah_resep->ada_duplikasi:'';
        // $data['ada_interaksi'] = isset($raw->telaah_resep->ada_interaksi)?$raw->telaah_resep->ada_interaksi:'';
        // $data['nama_pasien'] = isset($raw->verif_penyerahan_obat->nama_pasien)?$raw->verif_penyerahan_obat->nama_pasien:'';
        // $data['nama_obat'] = isset($raw->verif_penyerahan_obat->nama_obat)?$raw->verif_penyerahan_obat->nama_obat:'';
        // $data['bentuk_sediaan'] = isset($raw->verif_penyerahan_obat->bentuk_sediaan)?$raw->verif_penyerahan_obat->bentuk_sediaan:'';
        // $data['kekuatan'] = isset($raw->verif_penyerahan_obat->kekuatan)?$raw->verif_penyerahan_obat->kekuatan:'';
        // $data['rute_pembelian'] = isset($raw->verif_penyerahan_obat->rute_pembelian)?$raw->verif_penyerahan_obat->rute_pembelian:'';
        // $data['frek_pembelian'] = isset($raw->verif_penyerahan_obat->frek_pembelian)?$raw->verif_penyerahan_obat->frek_pembelian:'';
        // $data['item'] = isset($raw->telaah_resep->item)?$raw->telaah_resep->item:'';
        $dokter = $this->Frmmdaftar->getnama_dokter_by_noreg($data['no_register'])->row();
        $apoteker = $this->load->get_var("user_info");
        $data['ttd_apoteker'] = $apoteker->ttd;
        $data['ttd_dokter'] = ($dokter)?$dokter->ttd:'';
        $data['nm_dokter'] = $dokter?$dokter->nm_dokter:'';
        $data['nm_apoteker'] = $apoteker->name;
        $data['tgl_resep'] = date('Y-m-d H:i:s');

        $data_telaah = $this->Frmmdaftar->data_telaah($data['no_register'])->row();
        if ($data_telaah==FALSE) {
            $input = $this->Frmmdaftar->insert_telaah($data);
            $result = json_encode(array('code'=>$input?200:500));
            //INSERT
        } else {
            $noreg = $data['no_register'];
            $input =$this->Frmmdaftar->update_data_telaah($noreg,$data);
            $result = json_encode(array('code'=>$input?200:500));

            // UPDATE
        }
        echo $result;

    }

	public function data_obat_poli($id_poli='')
	{
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        $qtx = $this->Frmmdaftar->get_qtx()->result();
		$data=$this->Frmmdaftar->get_obat_pilih_poli($id_poli)->result();


            echo "<table id=\"table_obat_poli\" class=\" table display table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
        foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_poli[]\" id=\"poli-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"poli-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_poli-$key->id_obat\" id=\"signa_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_poli-$key->id_obat\" id=\"qtx_poli-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_poli-$key->id_obat\" id=\"satuan_poli-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_poli-$key->id_obat\" id=\"cara_pakai_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_poli[]\" id=\"id_obat_poli\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_poli-$key->id_obat\" id=\"qty_poli\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 100%;\">
                        </td>
                    </tr>";
            }

            echo "</table>";



			// echo "<option selected value=''>-Pilih Dokter-</option>";
			// foreach($data as $row){
			// 	echo "<option value='$row->id_poli'>$row->nm_obat</option>";
			// }
	}

    public function data_obat_poli_search($id_poli='',$keyword=''){
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $qtx = $this->Frmmdaftar->get_qtx()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        if ($keyword == '') {
            $data=$this->Frmmdaftar->get_obat_pilih_poli($id_poli)->result();


            echo "<table id=\"table_obat_poli\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_poli[]\" id=\"poli-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"poli-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_poli-$key->id_obat\" id=\"signa_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_poli-$key->id_obat\" id=\"qtx_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_poli-$key->id_obat\" id=\"satuan_poli-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_poli-$key->id_obat\" id=\"cara_pakai_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_poli[]\" id=\"id_obat_poli\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_poli-$key->id_obat\" id=\"qty_poli\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 100%;\">
                        </td>
                    </tr>";
            }
            echo "</table>";
        }else{
            $data=$this->Frmmdaftar->get_obat_pilih_poli_search($id_poli,$keyword)->result();
            echo "<table id=\"table_obat_poli\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_poli[]\" id=\"poli-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"poli-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_poli-$key->id_obat\" id=\"signa_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_poli-$key->id_obat\" id=\"qtx_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_poli-$key->id_obat\" id=\"satuan_poli-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_poli-$key->id_obat\" id=\"cara_pakai_poli-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_poli[]\" id=\"id_obat_poli\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_poli-$key->id_obat\" id=\"qty_poli\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 100%;\">
                        </td>
                    </tr>";
            }
            echo "</table>";
        }

    }

    public function insert_permintaan_obat_poli()
    {
        // var_dump($this->load->get_var("ket_poli"));die();

        $no_register = $this->input->post('no_register_poli');
        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }

        $obatnya = $this->input->post('jumlah_obat_poli[]');

        $id_poli = $this->input->post('id_poli_rujuk');
        $get_obat = $this->Frmmdaftar->get_data_obat_query_poli($id_poli)->result_array();


        foreach($get_obat as $value){
            // $value['nm_obat']
            // if($data)
            if($obatnya != null){
                foreach($obatnya as $pembanding){
                    if($pembanding == $value['id_obat']){
                        $no_register = $this->input->post('no_register_poli');
                        $data['no_register']=$this->input->post('no_register_poli');
                        $data['no_medrec']=$this->input->post('no_medrec_poli');
                        $data['tgl_kunjungan']=date('Y-m-d');
                        $data['obat_luar']= '1';
                    
                        $ket=$this->input->post('ket_poli');
                       if($ket==1){
                            $data['id_obat']=$this->input->post('item_obat_poli');
                            $data['nm_obat']=$this->input->post('cari_obat_poli'). "(Konsinyasi)";
                            $nama_obat=$this->input->post('cari_obat_poli'). "(Konsinyasi)";
                       }
                        else{
                            $data['id_obat']=$value['id_obat'];
                            $data['nm_obat']=$value['nm_obat'];
                            $nama_obat=$value['nm_obat'];
                        }

                        $data['id_poli']=$this->input->post('idrg_poli');
                        $data['no_resep']=$this->input->post('no_resep_poli');
                        $no_resep=$this->input->post('no_resep_poli');

                        if($this->input->post('qty_poli-'.$value['id_obat'])!= ''){
                            $data['qty']=$this->input->post('qty_poli-'.$value['id_obat']);
                        }else{
                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                                if ($this->input->post('pelayan_poli') == 'DOKTER') {
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                                }else{
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                                }

                        }
                        $sgn=$this->input->post('signa_poli-'.$value['id_obat']);
                        $qtx=$this->input->post('qtx_poli-'.$value['id_obat']);
                        $cara_pakai=$this->input->post('cara_pakai_poli-'.$value['id_obat']);
                        $satuan=$this->input->post('satuan_poli-'.$value['id_obat']);
                        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                            if ($makan==''){
                                $data['signa']="-";
                                $data['qtx']=0;
                                $data['satuan']="-";
                                $data['cara_pakai']="-";
                                $data['kali_harian']="-";
                            } else {
                                $data['signa']=$makan;
                                if ($qtx == null) {
                                    $qtxs = 0;
                                }else{
                                    $qtxs = $qtx;
                                }
                                $data['qtx']=$qtxs;
                                $data['satuan']=$satuan;
                                $data['cara_pakai']=$cara_pakai;
                                $data['kali_harian']=$sgn;
                            }
                        $signa = $makan;

                      


                        $data['kronis'] = $this->input->post('kronis_poli');
                        // $kronis = $this->input->post('kronis');
                        $poli = $this->input->post('idpoli_poli');
                        if($ket!=1){
                            $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['id_obat'], $poli, $data['kronis']);
                            $row_klaim = $klaim->row();
                            $cek_klaim = $klaim->num_rows();
                        }

                        $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();
                        if($cekplan == false){
                            $datafisik['plan'] = '-- '.$nama_obat.' ('.$signa.') <br>';
                        }else{
                            $datafisik['plan'] = $cekplan->plan.'<br>'.'-- '.$nama_obat.' ( '.$signa.' )<br>';
                        }
                        // print_r($data);
                        // die();
                        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */


                        if($data['cara_bayar'] == 'BPJS'){

                            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                            */
                            if($cek_klaim > 0) {

                                if($data['qty'] > $row_klaim->qty){
                                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                                }else{
                                    $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');

                                    // var_dump($data);

                                    $this->Frmmdaftar->insert_permintaan_dokter($data);
                                    //fisik
                                    $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                        if ($data_fisik==FALSE) {
                                            $datafisik['no_register'] = $no_register;
                                            $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                            //INSERT
                                        } else {
                                            $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                            // UPDATE
                                        }
                                }
                            }else{
                                // var_dump($data);
                                // die();
                                $this->Frmmdaftar->insert_permintaan_dokter($data);
                                //fisik
                                $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                    if ($data_fisik==FALSE) {
                                        $datafisik['no_register'] = $no_register;
                                        $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                        //INSERT
                                    } else {
                                        $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                        // UPDATE
                                    }
                            }
                        }else{
                            // var_dump($data);
                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                            //fisik
                            $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                if ($data_fisik==FALSE) {
                                    $datafisik['no_register'] = $no_register;
                                    $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                    //INSERT
                                } else {
                                    $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                    // UPDATE
                                }
                        }


                    }
                } //foreach2
            }else{
                // die();
                if ($this->input->post('pelayan_poli') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
                }
            }

        } //foreach1
        // var_dump($data);
        if ($this->input->post('koreksi_poli') != '') {

            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
        }
        if($this->input->post('idpoli_poli') != ''){
            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/PETUGAS'.'/'.$poli);
        }
        // die();
        if ($this->input->post('pelayan_poli') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }
        // var_dump($data);
        // die();


        // var_dump($data);die();
        // foreach($this->input->post('cari_obat') as $values){
        //     echo $values;
        //     echo '<br>';
        // }
        // die();


        //echo print_r($data);
    }

    public function data_obat_diag($id_diag='')
	{
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        $qtx = $this->Frmmdaftar->get_qtx()->result();
		$data=$this->Frmmdaftar->get_obat_pilih_diag($id_diag)->result();


            echo "<table id=\"table_obat_diag\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
        foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_diag[]\" id=\"diag-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"diag-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_diag-$key->id_obat\" id=\"signa_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_diag-$key->id_obat\" id=\"qtx_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_diag-$key->id_obat\" id=\"satuan_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_diag-$key->id_obat\" id=\"cara_pakai_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>

                            <input type=\"hidden\" name=\"id_obat_diag[]\" id=\"id_obat_diag\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_diag-$key->id_obat\" id=\"qty_diag\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 100%;\">
                        </td>
                    </tr>";
            }

            echo "</table>";



			// echo "<option selected value=''>-Pilih Dokter-</option>";
			// foreach($data as $row){
			// 	echo "<option value='$row->id_poli'>$row->nm_obat</option>";
			// }
	}

    public function data_obat_diag_search($id_diag='',$keyword=''){
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $qtx = $this->Frmmdaftar->get_qtx()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        if ($keyword == '') {
            $data=$this->Frmmdaftar->get_obat_pilih_diag($id_diag)->result();


            echo "<table id=\"table_obat_diag\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_diag[]\" id=\"diag-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"diag-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_diag-$key->id_obat\" id=\"signa_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_diag-$key->id_obat\" id=\"qtx_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_diag-$key->id_obat\" id=\"satuan_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_diag-$key->id_obat\" id=\"cara_pakai_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_diag[]\" id=\"id_obat_diag\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_diag-$key->id_obat\" id=\"qty_diag\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 70px;\">
                        </td>
                    </tr>";
            }
            echo "</table>";
        }else{
            $data=$this->Frmmdaftar->get_obat_pilih_diag_search($id_diag,$keyword)->result();

            echo "<table id=\"table_obat_diag\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            foreach ($data as $key) {
                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_diag[]\" id=\"diag-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"diag-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_diag-$key->id_obat\" id=\"signa_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_diag-$key->id_obat\" id=\"qtx_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_diag-$key->id_obat\" id=\"satuan_diag-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_diag-$key->id_obat\" id=\"cara_pakai_diag-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai-</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_diag[]\" id=\"id_obat_diag\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_diag-$key->id_obat\" id=\"qty_diag\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 70px;\">
                        </td>
                    </tr>";
            }
            echo "</table>";
        }


    }

    public function insert_permintaan_obat_diag()
    {
        // var_dump( $this->input->post());die();
        $no_register = $this->input->post('no_register_diag');
        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }

        $obatnya = $this->input->post('jumlah_obat_diag[]');

        $id_diag = $this->input->post('id_diag');
        $get_obat = $this->Frmmdaftar->get_data_obat_query_diag($id_diag)->result_array();
        
        // 

        foreach($get_obat as $value){
            // $value['nm_obat']
            // if($data)
            if($obatnya != null){
                foreach($obatnya as $pembanding){
                    if($pembanding == $value['id_obat']){

                        $no_register = $this->input->post('no_register_diag');
                        $data['no_register']=$this->input->post('no_register_diag');

                        $data['no_medrec']=$this->input->post('no_medrec_diag');
                        $data['tgl_kunjungan']=date('Y-m-d');
                        $data['obat_luar']= '1';
                       
                        $ket=$this->input->post('ket_diag');
                       if($ket==1){
                            $data['id_obat']=$this->input->post('item_obat_diag');
                            $data['nm_obat']=$this->input->post('cari_obat_diag'). "(Konsinyasi)";
                            $nama_obat=$this->input->post('cari_obat_diag'). "(Konsinyasi)";
                       }
                        else{
                           
                            $data['id_obat']=$value['id_obat'];
                            $data['nm_obat']=$value['nm_obat'];
                            $nama_obat=$value['nm_obat'];
                        
                        }

                        
                        $data['id_poli']=$this->input->post('idrg_diag');

                        $data['no_resep']=$this->input->post('no_resep_diag');
                        $no_resep=$this->input->post('no_resep_diag');
                        
                        if($this->input->post('qty_diag-'.$value['id_obat'])!= '' ){
                            $data['qty']=$this->input->post('qty_diag-'.$value['id_obat']);
                        }else{
                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                                if ($this->input->post('pelayan_diag') == 'DOKTER') {
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                                }else{
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                                }

                        }
                        $sgn=$this->input->post('signa_diag-'.$value['id_obat']);
                        $qtx=$this->input->post('qtx_diag-'.$value['id_obat']);
                        $cara_pakai=$this->input->post('cara_pakai_diag-'.$value['id_obat']);
                        $satuan=$this->input->post('satuan_diag-'.$value['id_obat']);
                        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                            if ($makan==''){
                                $data['signa']="-";
                                $data['qtx']=0;
                                $data['satuan']="-";
                                $data['cara_pakai']="-";
                                $data['kali_harian']="-";
                            } else {
                                $data['signa']=$makan;
                                if ($qtx == null) {
                                    $qtxs = 0;
                                }else{
                                    $qtxs = $qtx;
                                }
                                $data['qtx']=$qtxs;
                                $data['satuan']=$satuan;
                                $data['cara_pakai']=$cara_pakai;
                                $data['kali_harian']=$sgn;
                            }
                        $signa = $makan;
                     

                     

                        $data['kronis'] = $this->input->post('kronis_diag');
                      
                        $poli = $this->input->post('idpoli_diag');
                        if($ket!=1){
                            $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['id_obat'], $poli, $data['kronis']);
                            $row_klaim = $klaim->row();
                            $cek_klaim = $klaim->num_rows();
                        }

                        $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();
                        if($cekplan == false){
                            $datafisik['plan'] = '-- '.$nama_obat.' ('.$signa.') <br>';
                        }else{
                            $datafisik['plan'] = $cekplan->plan.'<br>'.'-- '.$nama_obat.' ( '.$signa.' )<br>';

                        }
                        // print_r($data);
                        // die();
                        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */


                        if($data['cara_bayar'] == 'BPJS'){

                            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                            */
                            if($cek_klaim > 0) {

                                if($data['qty'] > $row_klaim->qty){
                                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                                }else{
                                    $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');

                                    // var_dump($data);

                                    $this->Frmmdaftar->insert_permintaan_dokter($data);
                                    //fisik
                                    $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                        if ($data_fisik==FALSE) {
                                            $datafisik['no_register'] = $no_register;
                                            $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                            //INSERT
                                        } else {
                                            $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                            // UPDATE
                                        }
                                }
                            }else{
                                // var_dump($data);
                                // die();
                                $this->Frmmdaftar->insert_permintaan_dokter($data);
                                //fisik
                                $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                    if ($data_fisik==FALSE) {
                                        $datafisik['no_register'] = $no_register;
                                        $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                        //INSERT
                                    } else {
                                        $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                        // UPDATE
                                    }
                            }
                        }else{
                            // var_dump($data);
                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                            //fisik
                            $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                if ($data_fisik==FALSE) {
                                    $datafisik['no_register'] = $no_register;
                                    $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                    //INSERT
                                } else {
                                    $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                    // UPDATE
                                }
                        }


                    }
                } //foreach2
            }else{
                // die();
                if ($this->input->post('pelayan_diag') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
                }
            }

        } //foreach1
        // var_dump($data);
        if ($this->input->post('koreksi_diag') != '') {

            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
        }
        if($this->input->post('idpoli_diag') != ''){
            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/'.$poli);
        }
        // die();
        if ($this->input->post('pelayan_diag') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }
        // var_dump($data);
        // die();


        // var_dump($data);die();
        // foreach($this->input->post('cari_obat') as $values){
        //     echo $values;
        //     echo '<br>';
        // }
        // die();


        //echo print_r($data);
    }

    public function data_obat_all_search($keyword=''){
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        $qtx = $this->Frmmdaftar->get_qtx()->result();
        if ($keyword == '') {
            echo "<table id=\"table_obat_all\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            echo "</table>";
        }else{
            $data=$this->Frmmdaftar->get_obat_pilih_all_search($keyword)->result();
            echo "<table id=\"table_obat_all\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
            foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_all[]\" id=\"all-$key->id_obat\" value=\"$key->id_obat\">
                            <label for=\"all-$key->id_obat\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <select class=\"form-control\" name=\"signa_all-$key->id_obat\" id=\"signa_all-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Signa-</option>  ";

                        foreach ($signa as $row) {
                            echo "<option value=\"$row->signa\">$row->signa</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"qtx_all-$key->id_obat\" id=\"qtx_all-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Qtx-</option>  ";
                        foreach ($qtx as $row) {
                            echo "<option value=\"$row->qtx\">$row->qtx</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"satuan_all-$key->id_obat\" id=\"satuan_all-$key->id_obat\" style=\"width: 24%;\">
                            <option value=\"\">-Satuan-</option>  ";
                        foreach ($satuan as $row) {
                            echo "<option value=\"$row->nm_satuan\">$row->nm_satuan</option>";
                        }
                    echo "  </select>
                            <select class=\"form-control\" name=\"cara_pakai_all-$key->id_obat\" id=\"cara_pakai_all-$key->id_obat\" style=\"width: 24%;\">
                                <option value=\"\">-Cara Pakai -</option>  ";
                        foreach ($cara_pakai as $row) {
                            echo "<option value=\"$row->cara_pakai\">$row->cara_pakai</option>";
                        }
                    echo "  </select>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_inventory_all[]\" id=\"id_inventory_all\" value=\"$key->id_obat\">
                            <input type=\"number\" min=\"1\" name=\"qty_all-$key->id_obat\" id=\"qty_all\" placeholder=\"Qty\" class=\"form-control\" style=\"width: 100%;\">
                        </td>
                    </tr>";
            }
            echo "</table>";
        }

    }

    public function insert_permintaan_obat_all()
    {
        // var_dump($this->input->post());die();
        $no_register = $this->input->post('no_register_all');
        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }

        $obatnya = $this->input->post('jumlah_obat_all[]');

        $get_obat = $this->Frmmdaftar->get_data_obat_query_all()->result_array();


        foreach($get_obat as $value){
            // $value['nm_obat']
            // if($data)
            if($obatnya != null){
                foreach($obatnya as $pembanding){
                    if($pembanding == $value['id_obat']){
                        $no_register = $this->input->post('no_register_all');
                        $data['no_register']=$this->input->post('no_register_all');
                        $data['no_medrec']=$this->input->post('no_medrec_all');
                        $data['tgl_kunjungan']=date('Y-m-d');
                        $data['obat_luar']= '1';
                        $ket=$this->input->post('ket_all');
                       if($ket==1){
                            $data['id_obat']=$this->input->post('item_obat_all');
                            $data['nm_obat']=$this->input->post('cari_obat_all'). "(Konsinyasi)";
                            $nama_obat=$this->input->post('cari_obat_all'). "(Konsinyasi)";
                       }
                        else{
                            $data['id_obat']=$value['id_obat'];
                            $data['nm_obat']=$value['nm_obat'];
                            $nama_obat=$value['nm_obat'];
                        }

                        $data['id_poli']=$this->input->post('idrg_all');
                        $data['no_resep']=$this->input->post('no_resep_all');
                        $no_resep=$this->input->post('no_resep_all');
                        if($this->input->post('qty_all-'.$value['id_obat'])!= ''){
                            $data['qty']=$this->input->post('qty_all-'.$value['id_obat']);
                        }else{
                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                                if ($this->input->post('pelayan_all') == 'DOKTER') {
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                                }else{
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                                }

                        }
                        $sgn=$this->input->post('signa_all-'.$value['id_obat']);
                        $qtx=$this->input->post('qtx_all-'.$value['id_obat']);
                        $cara_pakai=$this->input->post('cara_pakai_all-'.$value['id_obat']);
                        $satuan=$this->input->post('satuan_all-'.$value['id_obat']);
                        $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                            if ($makan==''){
                                $data['signa']="-";
                                $data['qtx']=0;
                                $data['satuan']="-";
                                $data['cara_pakai']="-";
                                $data['kali_harian']="-";
                            } else {
                                $data['signa']=$makan;
                                if ($qtx == null) {
                                    $qtxs = 0;
                                }else{
                                    $qtxs = $qtx;
                                }
                                $data['qtx']=$qtxs;
                                $data['satuan']=$satuan;
                                $data['cara_pakai']=$cara_pakai;
                                $data['kali_harian']=$sgn;
                            }
                        $signa = $makan;
                        $data['kronis'] = $this->input->post('kronis_all');
                       
                        $poli = $this->input->post('idpoli_all');
                        if($ket!=1){
                            $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['id_obat'], $poli, $data['kronis']);
                            $row_klaim = $klaim->row();
                            $cek_klaim = $klaim->num_rows();
                        }

                        $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();
                        if($cekplan == false){
                            $datafisik['plan'] = '-- '.$nama_obat.' ('.$signa.') <br>';
                        }else{
                            $datafisik['plan'] = $cekplan->plan.'<br>'.'-- '.$nama_obat.' ( '.$signa.' )<br>';
                        }
                        // print_r($data);
                        // die();
                        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */


                        if($data['cara_bayar'] == 'BPJS'){

                            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                            */
                            if($cek_klaim > 0) {

                                if($data['qty'] > $row_klaim->qty){
                                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                                }else{
                                    $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');

                                    // var_dump($data);

                                    $this->Frmmdaftar->insert_permintaan_dokter($data);
                                    //fisik
                                    $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                        if ($data_fisik==FALSE) {
                                            $datafisik['no_register'] = $no_register;
                                            $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                            //INSERT
                                        } else {
                                            $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                            // UPDATE
                                        }
                                }
                            }else{
                                // var_dump($data);
                                // die();
                                $this->Frmmdaftar->insert_permintaan_dokter($data);
                                //fisik
                                $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                    if ($data_fisik==FALSE) {
                                        $datafisik['no_register'] = $no_register;
                                        $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                        //INSERT
                                    } else {
                                        $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                        // UPDATE
                                    }
                            }
                        }else{
                            // var_dump($data);
                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                            //fisik
                            $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                if ($data_fisik==FALSE) {
                                    $datafisik['no_register'] = $no_register;
                                    $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                    //INSERT
                                } else {
                                    $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                    // UPDATE
                                }
                        }


                    }
                } //foreach2

            }else{
                // die();
                if ($this->input->post('pelayan_all') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
                }
            }

        } //foreach1
        // var_dump($data);
        if ($this->input->post('koreksi_all') != '') {

            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
        }
        if($this->input->post('idpoli_all') != ''){
            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/PETUGAS'.'/'.$poli);
        }
        // die();
        if ($this->input->post('pelayan_all') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }
        // var_dump($data);
        // die();


        // var_dump($data);die();
        // foreach($this->input->post('cari_obat') as $values){
        //     echo $values;
        //     echo '<br>';
        // }
        // die();


        //echo print_r($data);
    }

    public function cari_data_diagnosa(){

        $keyword = $_GET['term'];
            $data = $this->db->select('id_icd, nm_diagnosa')
                    ->from('icd1')
                    ->join('obat_diagnosa','obat_diagnosa.id_diagnosa = icd1.id_icd')
                    ->like('UPPER(nm_diagnosa)',strtoupper($keyword))
                    ->or_like('UPPER(id_icd)',strtoupper($keyword))
                    ->group_by(array("id_icd", "nm_diagnosa"))
                    ->limit(20, 0)
                    ->get();
            $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    $new_row['label']=$row['nm_diagnosa'];
                    $new_row['value']=$row['nm_diagnosa'];
                    $new_row['id_diag'] = $row['id_icd'];
                    $new_row['nama']  =$row['nm_diagnosa'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }

    }


    public function cari_data_diagnosawithid(){

        $keyword = $_GET['term'];
        // var_dump($keyword);die();
            $data = $this->db->select('id_icd, nm_diagnosa')
                    ->from('icd1')
                    ->like('UPPER(nm_diagnosa)',strtoupper($keyword))
                    ->or_like('UPPER(id_icd)',strtoupper($keyword))->limit(20, 0)->get();
            $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    $new_row['label']=$row['id_icd'].' - '.$row['nm_diagnosa'];
                    $new_row['value']=$row['id_icd'].' - '.$row['nm_diagnosa'];
                    $new_row['id_diag'] = $row['id_icd'];
                    $new_row['nama']  =$row['nm_diagnosa'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }

    }

    public function cari_data_obat_diagnosa(){

        $keyword = $_GET['term'];
            $data = $this->db->select('id_obat, nm_obat')
                    ->from('master_obat')
                    ->where('deleted = 0')
                    ->like('UPPER(nm_obat)',strtoupper($keyword))->limit(20, 0)->get();
            $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    $new_row['label']=$row['nm_obat'];
                    $new_row['value']=$row['nm_obat'];
                    $new_row['id_obat'] = $row['id_obat'];
                    $new_row['nama']  =$row['nm_obat'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }

    }

    public function data_obat_history($no_register='',$noregasal=""){
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);

        if (substr($no_register,0,2) == 'PL') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_pl_by_noreg($no_register)->row()->no_cm;
        }elseif (substr($no_register,0,2) == 'RJ') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_rj_by_noreg($no_register)->row()->no_medrec;
        }elseif (substr($no_register,0,2) == 'RI') {
            // $no_medrec = $this->Frmmdaftar->get_no_medrec_ri_by_noreg($no_register)->row()->no_medrec;
        }else{
            $no_medrec = '';
        }

        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
		$data = $noregasal!=""?$this->Frmmdaftar->get_obat_history_asal($noregasal,$group->id_gudang,$userid)->result():$this->Frmmdaftar->get_obat_history($no_medrec,$group->id_gudang,$userid)->result();


            echo "<table id=\"table_obat_history\" class=\" table display table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 25%;\">Nama Obat</th>
                        <th style=\"width: 60%;\">Signa</th>
                        <th style=\"width: 10%;\">Quantity</th>
                    </tr>
                </thead>";
        foreach ($data as $key) {

                echo "<tr>
                        <td>
                            <input type=\"checkbox\" name=\"jumlah_obat_history[]\" id=\"history-$key->id_resep_pasien\" value=\"$key->id_resep_pasien\">
                            <label for=\"history-$key->id_resep_pasien\"></label>
                        </td>
                        <td><label>$key->nm_obat</label></td>
                        <td>
                            <input type=\"hidden\" name=\"signa_history-$key->id_resep_pasien\" id=\"signa_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->signa\">
                            <input type=\"hidden\" name=\"satuan_history-$key->id_resep_pasien\" id=\"satuan_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->Satuan_obat\">
                            <input type=\"hidden\" name=\"cara_pakai_history-$key->id_resep_pasien\" id=\"cara_pakai_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->cara_pakai\">
                            <input type=\"hidden\" name=\"kali_harian_history-$key->id_resep_pasien\" id=\"kali_harian_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->kali_harian\">
                            <input type=\"hidden\" name=\"qtx_history-$key->id_resep_pasien\" id=\"qtx_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->qtx\">
                            <label>$key->signa</label>
                        </td>
                        <td>
                            <input type=\"hidden\" name=\"id_obat_history[]\" id=\"id_obat_history\" value=\"$key->id_resep_pasien\">
                            <input type=\"hidden\" name=\"qty_history-$key->id_resep_pasien\" id=\"qty_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->resep_qty\">
                            <label>$key->resep_qty</label>
                        </td>
                    </tr>";
        }

            echo "</table>";



			// echo "<option selected value=''>-Pilih Dokter-</option>";
			// foreach($data as $row){
			// 	echo "<option value='$row->id_poli'>$row->nm_obat</option>";
			// }
	}

    public function data_obat_history_search($no_register='',$keyword=''){
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);

        if (substr($no_register,0,2) == 'PL') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_pl_by_noreg($no_register)->row()->no_cm;
        }elseif (substr($no_register,0,2) == 'RJ') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_rj_by_noreg($no_register)->row()->no_medrec;
        }elseif (substr($no_register,0,2) == 'RI') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_ri_by_noreg($no_register)->row()->no_medrec;
        }else{
            $no_medrec = '';
        }

        $satuan = $this->Frmmdaftar->get_satuan()->result();
        $signa = $this->Frmmdaftar->get_signa()->result();
        $cara_pakai = $this->Frmmdaftar->get_cara_pakai()->result();
        if ($keyword == '') {
            $data=$this->Frmmdaftar->get_obat_history($no_medrec,$group->id_gudang,$userid)->result();
            // var_dump($data);die();
                echo "<table id=\"table_obat_history\" class=\" table display table-hover table-bordered table-striped\" style=\"width: 100%;\">
                    <thead>
                        <tr>
                            <th style=\"width: 5%;\">No</th>
                            <th style=\"width: 25%;\">Nama Obat</th>
                            <th style=\"width: 60%;\">Signa</th>
                            <th style=\"width: 10%;\">Quantity</th>
                        </tr>
                    </thead>";
            foreach ($data as $key) {

                    echo "<tr>
                            <td>
                                <input type=\"checkbox\" name=\"jumlah_obat_history[]\" id=\"history-$key->id_resep_pasien\" value=\"$key->id_resep_pasien\">
                                <label for=\"history-$key->id_resep_pasien\"></label>
                            </td>
                            <td><label>$key->nm_obat</label></td>
                            <td>
                                <input type=\"hidden\" name=\"signa_history-$key->id_resep_pasien\" id=\"signa_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->signa\">
                                <input type=\"hidden\" name=\"satuan_history-$key->id_resep_pasien\" id=\"satuan_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->Satuan_obat\">
                                <input type=\"hidden\" name=\"cara_pakai_history-$key->id_resep_pasien\" id=\"cara_pakai_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->cara_pakai\">
                                <input type=\"hidden\" name=\"kali_harian_history-$key->id_resep_pasien\" id=\"kali_harian_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->kali_harian\">
                                <input type=\"hidden\" name=\"qtx_history-$key->id_resep_pasien\" id=\"qtx_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->qtx\">
                                <label>$key->signa</label>
                            </td>
                            <td>
                                <input type=\"hidden\" name=\"id_obat_history[]\" id=\"id_obat_history\" value=\"$key->id_resep_pasien\">
                                <input type=\"hidden\" name=\"qty_history-$key->id_resep_pasien\" id=\"qty_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->resep_qty\">
                                <label>$key->resep_qty</label>
                            </td>
                        </tr>";
            }

                echo "</table>";
        }else{
            $data=$this->Frmmdaftar->get_obat_pilih_history_search($no_medrec,$group->id_gudang,$userid,$keyword)->result();

            echo "<table id=\"table_obat_history\" class=\" table display table-hover table-bordered table-striped\" style=\"width: 100%;\">
                    <thead>
                        <tr>
                            <th style=\"width: 5%;\">No</th>
                            <th style=\"width: 25%;\">Nama Obat</th>
                            <th style=\"width: 60%;\">Signa</th>
                            <th style=\"width: 10%;\">Quantity</th>
                        </tr>
                    </thead>";
            foreach ($data as $key) {

                    echo "<tr>
                            <td>
                                <input type=\"checkbox\" name=\"jumlah_obat_history[]\" id=\"history-$key->id_resep_pasien\" value=\"$key->id_resep_pasien\">
                                <label for=\"history-$key->id_resep_pasien\"></label>
                            </td>
                            <td><label>$key->nm_obat</label></td>
                            <td>
                                <input type=\"hidden\" name=\"signa_history-$key->id_resep_pasien\" id=\"signa_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->signa\">
                                <input type=\"hidden\" name=\"satuan_history-$key->id_resep_pasien\" id=\"satuan_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->Satuan_obat\">
                                <input type=\"hidden\" name=\"cara_pakai_history-$key->id_resep_pasien\" id=\"cara_pakai_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->cara_pakai\">
                                <input type=\"hidden\" name=\"kali_harian_history-$key->id_resep_pasien\" id=\"kali_harian_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->kali_harian\">
                                <input type=\"hidden\" name=\"qtx_history-$key->id_resep_pasien\" id=\"qtx_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->qtx\">
                                <label>$key->signa</label>
                            </td>
                            <td>
                                <input type=\"hidden\" name=\"id_obat_history[]\" id=\"id_obat_history\" value=\"$key->id_resep_pasien\">
                                <input type=\"hidden\" name=\"qty_history-$key->id_resep_pasien\" id=\"qty_history-$key->id_resep_pasien\" class=\"form-control\" style=\"width: 100%;\" value=\"$key->resep_qty\">
                                <label>$key->resep_qty</label>
                            </td>
                        </tr>";
            }

                echo "</table>";
        }


    }

    public function insert_permintaan_obat_history()
    {

        // var_dump($this->input->post('ket_history'));die();
        $no_register = $this->input->post('no_register_history');

        if (substr($no_register,0,2) == 'PL') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_pl_by_noreg($no_register)->row()->no_cm;
        }elseif (substr($no_register,0,2) == 'RJ') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_rj_by_noreg($no_register)->row()->no_medrec;
        }elseif (substr($no_register,0,2) == 'RI') {
            $no_medrec = $this->Frmmdaftar->get_no_medrec_ri_by_noreg($no_register)->row()->no_medrec;
        }else{
            $no_medrec = '';
        }

        $login_data = $this->load->get_var("user_info");
        // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        // if($group->id_gudang == "8" || $group->id_gudang == "7"){
        //     $ids = "1";
        // }else{
        //     $ids = join("','",$no_gudang);
        // }

        $resepnya = $this->input->post('jumlah_obat_history[]');
        // var_dump($resepnya);die();
        foreach ($resepnya as $key) {
            $idreseppasien[] = array(
                'id_resep_pasien' => $key
            );
            $obatnya[] = $this->Frmmdaftar->get_id_obat_by_resep_pasien($key)->row()->item_obat;
        }


        $get_obat = $this->Frmmdaftar->get_data_obat_query_history($group->id_gudang,$userid,$no_medrec)->result_array();
        foreach($get_obat as $value){
            // $value['nm_obat']
            // if($data)
            //if($obatnya != null){
                //foreach($resepnya as $pembanding){
                    //if($pembanding == $value['id_obat']){
                        foreach ($idreseppasien as $col){
                            if ($col['id_resep_pasien'] == $value['id_resep_pasien']) {
                                 echo $value['id_obat'].'<br>';
                                //  die();
                                // echo $value['nm_obat'].'<br>';
                                // echo $value['hargajual'].'<br>';
                                // echo $this->input->post('sgn-1-'.$value['id_obat']);
                                // echo $this->input->post('sgn-2-'.$value['id_obat']);
                                // echo $this->input->post('satuan-'.$value['id_obat']);
                                // echo $this->input->post('qty-'.$value['id_obat']);
                                // echo $value['id_inventory'].'<br>';
                                // echo $value['jenis_obat'].'<br>';
                                $no_register = $this->input->post('no_register_history');
                                $data['no_register']=$this->input->post('no_register_history');

                                $data['no_medrec']=$this->input->post('no_medrec_history');
                                $data['tgl_kunjungan']=date('Y-m-d');
                                $data['obat_luar']= '1';
                             
                             
                                $ket=$this->input->post('ket_history');
                                if($ket==1){
                                    $data['id_obat']=$this->input->post('item_obat_history');
                                    $data['nm_obat']=$this->input->post('cari_obat_history'). "(Konsinyasi)";
                                    $nama_obat=$this->input->post('cari_obat_history'). "(Konsinyasi)";
                                }
                                else{
                                   
                                    $data['id_obat']=$value['id_obat'];
                                    $data['nm_obat']=$value['nm_obat'];
                                    $nama_obat=$value['nm_obat'];
                                    // $data['Satuan_obat']=$this->input->post('satuan_history-'.$value['id_obat']);
                                    // $satuan_obat=$this->input->post('satuan_history-'.$value['id_obat']);
                                }

                                // var_dump($data);
                                $data['id_poli']=$this->input->post('idrg_history');

                              
                                $data['no_resep']=$this->input->post('no_resep_history');
                                $no_resep=$this->input->post('no_resep_history');
                                $data['qty']=$this->input->post('qty_history-'.$col['id_resep_pasien']);
                                $qtx=$this->input->post('qtx_history-'.$col['id_resep_pasien']);
                                $resep=$this->input->post('signa_history-'.$col['id_resep_pasien']);
                                $sgn=$this->input->post('kali_harian_history-'.$col['id_resep_pasien']);
                                $satuan=$this->input->post('satuan_history-'.$value['id_resep_pasien']);
                                $cara_pakai=$this->input->post('cara_pakai_history-'.$value['id_resep_pasien']);
                                // $signa=$this->input->post('signa_history-'.$value['id_resep_pasien']);
                                $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);

                                        if ($resep!=''){
                                            $data['signa']=isset($resep)?$resep:"-";
                                            $data['satuan']=isset($satuan)?$satuan:"-";
                                            $data['qtx']=isset($qtx)?$qtx:0;
                                            $data['cara_pakai']=isset($cara_pakai)?$cara_pakai:"-";
                                            $data['kali_harian']=isset($sgn)?$sgn:"-";
                                            $signa=isset($resep)?$resep:"-";
                                        } else {
                                            $data['signa']=$makan;
                                            $data['satuan']=$satuan;
                                            $data['cara_pakai']=$cara_pakai;
                                            $data['kali_harian']=$sgn;
                                            if ($qtx == null) {
                                                $qtxs = 0;
                                            }else{
                                                $qtxs = $qtx;
                                            }
                                            $data['qtx']=$qtxs;
                                            $signa=$makan;
                                        }

                        // $stok_obat=$this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();


                        // if (empty($stok_obat)) {
                        //     $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');
                        //     if($this->input->post('idpoli_history') != ''){
                        //         redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$data['no_register'].'/PETUGAS'.'/'.$poli);
                        //     }else{
                        //         if ($this->input->post('pelayan_history') == 'DOKTER') {
                        //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                        //         }else{
                        //             redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                        //         }
                        //     }
                        // }
                                //     //update stok
                        // $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);



                                $data['kronis'] = $this->input->post('kronis_history');
                                // $kronis = $this->input->post('kronis');
                                $poli = $this->input->post('idpoli_history');
                                if($ket!=1){
                                    $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['id_obat'], $poli, $data['kronis']);
                                    $row_klaim = $klaim->row();
                                    $cek_klaim = $klaim->num_rows();
                                }

                                $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();
                                if($cekplan == false){
                                    $datafisik['plan'] = '-- '.$nama_obat.' ('.$signa.') <br>';
                                }else{
                                    $datafisik['plan'] = $cekplan->plan.'<br>'.'-- '.$nama_obat.' ( '.$signa.' )<br>';
                                }
                                // print_r($data);
                                // die();
                                /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */


                                if($data['cara_bayar'] == 'BPJS'){

                                    /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                                    * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                                    */
                                    if($cek_klaim > 0) {

                                        if($data['qty'] > $row_klaim->qty){
                                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                                        }else{
                                            $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');

                                            // var_dump($data);

                                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                                            //fisik
                                            $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                                if ($data_fisik==FALSE) {
                                                    $datafisik['no_register'] = $no_register;
                                                    $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                                    //INSERT
                                                } else {
                                                    $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                                    // UPDATE
                                                }
                                        }
                                    }else{
                                        // var_dump($data);
                                        // die();
                                        $this->Frmmdaftar->insert_permintaan_dokter($data);
                                        //fisik
                                        $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                            if ($data_fisik==FALSE) {
                                                $datafisik['no_register'] = $no_register;
                                                $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                                //INSERT
                                            } else {
                                                $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                                // UPDATE
                                            }
                                    }
                                }else{
                                    // var_dump($data);
                                    $this->Frmmdaftar->insert_permintaan_dokter($data);
                                    //fisik
                                    $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
                                        if ($data_fisik==FALSE) {
                                            $datafisik['no_register'] = $no_register;
                                            $this->Frmmdaftar->insert_data_fisik($datafisik,$no_resep);
                                            //INSERT
                                        } else {
                                            $this->Frmmdaftar->update_data_fisik($no_register, $datafisik,$no_resep);
                                            // UPDATE
                                        }
                                }


                            }
                        }
                    //}
                //} //foreach2
            // }else{
            //     // die();
            //     if ($this->input->post('pelayan_history') == 'DOKTER') {
            //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            //     }else{
            //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            //     }
            // }

        } //foreach1
        // var_dump($data);
        if ($this->input->post('koreksi_history') != '') {

            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register.'/PETUGAS');
        }
        if($this->input->post('idpoli_history') != ''){
            // die();
            redirect('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/PETUGAS'.'/'.$poli);
        }
        // die();
        if ($this->input->post('pelayan_history') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }
        // var_dump($data);
        // die();


        // var_dump($data);die();
        // foreach($this->input->post('cari_obat') as $values){
        //     echo $values;
        //     echo '<br>';
        // }
        // die();


        //echo print_r($data);
    }

    public function insert_header_resep($pelayan='')
    {
        $i=1;
         $no_register = $this->input->post('no_register');
         $login_data = $this->load->get_var("user_info");
         $idrg=$this->input->post('idrg');
         $bed=$this->input->post('bed');
         $kelas=$this->input->post('kelas_pasien');
         $nm_dokter=$this->input->post('nm_dokter');
         $cara_bayar=$this->input->post('cara_bayar');
 
         $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
         $i=1;
 
         foreach ($id_gudang as $row) {
             $no_gudang[]=$row->id_gudang;
         }
         $userid = $this->session->userid;
         $group = $this->Frmmpo->getIdGudang($userid);
 
         $obatnya = $this->input->post('jumlah_obat-perawat[]');
         $get_obat = $this->Frmmdaftar->get_data_obat_query_resep($group->id_gudang,$userid)->result_array();
 
         $this->Frmmdaftar->update_flag_daftar_ulang_irj($no_register,[
            'farmasi'=>'1',
            'dtfarmasi'=>date('Y-m-d H:i:s')
         ]);
         foreach($get_obat as $value){
             if($obatnya){
                 foreach($obatnya as $pembanding){
                     if($pembanding == $value['id_inventory']){
                             $data['id_inventory']= $value['id_inventory'];
                             $data['id_gudang']= $group->id_gudang;
                             $data['qty']=$this->input->post('qty-perawat-'.$value['id_inventory']); 
                            $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);
 
                     }
 
                 } //foreach2
 
             }else{
                 if (substr($no_register,0,2) == 'RJ') {
                     if ($pelayan == 'DOKTER') {
                         if($idrg == 'BA00'){
                             redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register);
                         }else{
                             redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register);
                         }
                     }else{
                         redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
                     }
                 }elseif (substr($no_register,0,2) == 'RI'){
                     if ($pelayan == 'DOKTER') {
                         redirect('iri/rictindakan/index/'.$no_register);
                     }else{
                         redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
                     }
                 }else{
                     if ($pelayan == 'DOKTER') {
                         redirect('farmasi/frmcdaftar/');
                     }else{
                         redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
                     }
                 }
             }
 
         } 
 
         $qty_obat=$this->Frmmdaftar->cek_qty_obat($no_register)->result();
        $this->Frmmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
         // }
 
         $no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;
 
         $cek_obat_tuslah = $this->Frmmdaftar->getdata_resep_pasien($no_register);
         if ($cek_obat_tuslah->num_rows() > 0) {
             $tuslah=0;
         }else{
             $tuslah=0;
         }
         if ($cara_bayar != "UMUM") {
             $kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->id_kontraktor;
             if ($kontraktor == 312) {
                 $tuslah=0;
             }
         }
 
         // var_dump('success');
     $this->Frmmdaftar->update_data_header($no_resep, $nm_dokter, $tuslah);
     $this->Frmmdaftar->update_no_resep($no_resep,$no_register);
 
     $racikan = $this->input->post('racikan-perawat[]');
 
         foreach ($racikan as $test) {
             if($test== '1'){
                 $this->Frmmdaftar->update_no_resep_racik($no_resep,$no_register);
             }
         }
 
 
     $data_obat_today = $this->Frmmdaftar->get_all_obat_today($no_register)->result();
 
     $ko = array();
     if($data_obat_today != null){
         foreach ($data_obat_today as $kolom) {
             $tset[] =  array(
                 "nama_obat" => $kolom->item_obat.'.'.$kolom->nama_obat,
                 "frekuensi" => $kolom->kali_harian,
                 "qty" => $kolom->qty
              );
 
         }
     }else{
         $tset = array(
             "nama_obat" => '',
             "frekuensi" => '',
             "qty" => ''
         );
     }
 
 
     $tas[] = array(
         "question2" =>$tset,
         "tgl" => date('Y-m-d')
     );
 
     $ko['matriks_resep_obat'] =$tas;
 
 
     if(substr($no_register,0,2) == 'RI'){
         $kkiioo['formjson'] = json_encode($ko);
         $hasirgsfd = date('Y-m-d');
         $check_available_data = $this->rimtindakan->get_intruksi_obat($no_register,$hasirgsfd);
 
         if($check_available_data->num_rows()){
             $this->rimtindakan->update_intruksi_obat($kkiioo,$no_register,$hasirgsfd);
         }else{
             $kkiioo['tgl_input'] = date('Y-m-d H:i:s');
             $kkiioo['no_ipd'] = $no_register;
             $kkiioo['id_pemeriksa'] = $userid;
             $this->rimtindakan->insert_intruksi_obat($kkiioo);
 
         }
     }
 
         // die();
         if (substr($no_register,0,2) == 'RJ') {
             if ($pelayan == 'DOKTER') {
                 if($idrg == 'BA00'){
                     redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register);
                 }else{
                     redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register);
                 }
             }else{
                 redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
             }
         }elseif (substr($no_register,0,2) == 'RI'){
             if ($pelayan == 'DOKTER') {
                 redirect('iri/rictindakan/index/'.$no_register);
             }else{
                 redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
             }
         }else{
             if ($pelayan == 'DOKTER') {
                 redirect('farmasi/frmcdaftar/');
             }else{
                 redirect('farmasi/frmcdaftar/cetak_all_resep/'.$no_register);
             }
         }

    }


	public function cetak_all_resep_old($no_register)
	{
		error_reporting(~E_ALL);
		//UNTUK GET NO_REGISTER
		$data_tindakan_racik=$this->Frmmkwitansi->getdata_resep_racik($no_register)->result();
		//END GET REGISTER
		$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
            $tgl_now = date('Y-m-d');


			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');

		$getrdrj=substr($no_register, 0,2);
		if ($getrdrj == "RJ") {
			$tuslah= 0;//$this->Frmmkwitansi->get_tuslah_irj($no_register)->row()->tuslah;
		}elseif ($getrdrj == "RI") {
			$tuslah=0;//$this->Frmmkwitansi->get_tuslah_iri($no_register)->row()->tuslah;
		}

		if($no_register!=''){

			$diskon = 0;

			$data_pasien=$this->Frmmkwitansi->get_data_pasien_by_noreg($no_register)->result();
			//	print_r($data_pasien);die();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$no_cm=$row->no_cm;
					$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
					$tgl_lahir=$row->tgl_lahir;
				}


			$data_header=$this->Frmmdaftar->getnama_dokter_poli($no_register)->result();

		    //	print_r($data_header);die();
				foreach($data_header as $row){
					$nmdokter=$row->nmdokter;

				}


			if (substr($no_register,0,2)=="PL"){
				$data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				foreach($data_ruang as $row){
					$nmruang='Pasien Luar';
				}

			}
            $data_obat = $this->Frmmdaftar->get_data_permintaan_by_noreg($no_register)->result();
            foreach($data_obat as $row){
                $nama_obat=$row->nama_obat;
                $qty=$row->qty;
                $signa=$row->signa;
                $item_obat = $row->item_obat;
            }
            $group = $this->Frmmpo->getIdGudang($userid);

            $get_no_resep = $this->Frmmdaftar->get_no_resep_by_noreg($no_register)->row();
            if ($get_no_resep != null) {
                $no_resep = $get_no_resep->no_resep;
            }else{
                $no_resep = '0';
            }


            if ($item_obat == null && $group->id_gudang == null) {
                $tgL_kadaluarsa = '';
            }else{
                $kadaluarsa = $this->Frmmdaftar->get_tgl_kadaluarsa($item_obat,$group->id_gudang)->result();

                foreach($kadaluarsa as $row){
                    $tgL_kadaluarsa=$row->expire_date;
                }
            }


			//cetak resep
                $konten=
                    "<style>
                    *{
                        font-weight:bold;
                    }

                    </style>
                    <div style=\"width: 100%;position:relative;display:block;\">
                ";

			foreach ($data_obat as $key) {
                $konten = $konten."

                <br>  <br>
                    <table border=\"2\" style=\"height: 100%;width: 98%;\">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td style=\"width:15%;\">
                                            <img src=\"assets/images/logos/".$this->config->item('logo_url')."\" height=\"40px\" width=\"40px\" class=\"left\">
                                        </td>
                                        <td style=\"width:85%;\">
                                            <label>RS.OTAK DR.Drs.M.HATTA BKT</label><br>
                                            <label>DEPO FARMASI RAWAT JALAN</label>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>No.Resep : $no_resep</td>
                                        <td style=\"float: right;\">TGL : $tgl</td>
                                    </tr>
                                    <tr>
                                        <td>$nama</td>
                                        <td style=\"float: right;\">RM : $no_cm</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style=\"float: right;\">Lhr : $tgl_lahir</td>
                                    </tr>
                                    <tr>
                                        <td colspan=\"2\">Nama Obat : $key->nama_obat</td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Kadaluarsa : $tgL_kadaluarsa</td>
                                        <td style=\"float: right;\">Jlh : $key->qty</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div style=\"text-align: center;\">
                                    <label style=\"text-align: center;\"><b>$key->signa</b></label>
                                </div>
                            </td>
                        </tr>
                    </table>
                <br>  <br>

                ";
            }
            $konten = $konten."
            </div>
            ";





			$file_name="fobat_no_resep_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$pageLayout = array('280', '160'); //  or array($height, $width)
				$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);
				// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";

				$fontname = TCPDF_FONTS::addTTFfont(FCPATH.'asset/font/Calibri.ttf', 'TrueTypeUnicode', '', 32);

				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('1', '1', '1');
				$obj_pdf->SetAutoPageBreak(TRUE, '1');
				$obj_pdf->SetFont('helvetica', '', 9);
				// $obj_pdf->SetFont($fontname, '', 12, '', false);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				// ob_start();
				ob_clean();
				ob_flush();
					$content = $konten;
				ob_end_flush();
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');

		}else{
			redirect('farmasi/Frmcdaftar/','refresh');
		}
	}

	public function cetak_all_resep($no_register)
	{
		error_reporting(~E_ALL);
		//UNTUK GET NO_REGISTER
		$data['data_tindakan_racik']=$this->Frmmkwitansi->getdata_resep_racik($no_register)->result();
		//END GET REGISTER
		    $data['tgl_jam'] = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");
            $data['tgl_now'] = date('Y-m-d');


			$data['namars']=$this->config->item('namars');
			$data['kota_kab']=$this->config->item('kota');
			$data['alamatrs']=$this->config->item('alamat');
			$data['telp']=$this->config->item('telp');
			$data['nmsingkat']=$this->config->item('namasingkat');

		$getrdrj=substr($no_register, 0,2);
		if ($getrdrj == "RJ") {
			$data['tuslah']= 0;//$this->Frmmkwitansi->get_tuslah_irj($no_register)->row()->tuslah;
		}elseif ($getrdrj == "RI") {
			$data['tuslah']=0;//$this->Frmmkwitansi->get_tuslah_iri($no_register)->row()->tuslah;
		}

		if($no_register!=''){

			$data['diskon'] = 0;

			$data_pasien=$this->Frmmkwitansi->get_data_pasien_by_noreg($no_register)->result();
			//	print_r($data_pasien);die();
				foreach($data_pasien as $row){
					$data['nama']=$row->nama;
					$data['no_register']=$row->no_register;
					$data['no_medrec']=$row->no_medrec;
					$data['no_cm']=$row->no_cm;
					$data['bed']=$row->bed;
					$data['cara_bayar']=$row->cara_bayar;
					$data['tgl_lahir']=$row->tgl_lahir;
				}


			$data_header=$this->Frmmdaftar->getnama_dokter_poli($no_register)->result();

		    //	print_r($data_header);die();
				foreach($data_header as $row){
					$data['nmdokter']=$row->nmdokter;

				}


			if (substr($no_register,0,2)=="PL"){
				$data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				foreach($data_ruang as $row){
					$data['nmruang']='Pasien Luar';
				}

			}
            $data['data_obat'] = $this->Frmmdaftar->get_data_permintaan_by_noreg($no_register)->result();
            foreach($data_obat as $row){
                $data['nama_obat']=$row->nm_obat;
                $data['qty']=$row->qty;
                $data['signa']=$row->signa;
                $data['item_obat ']= $row->id_obat;
            }
            $group = $this->Frmmpo->getIdGudang($userid);

            $get_no_resep = $this->Frmmdaftar->get_no_resep_by_noreg($no_register)->row();
            if ($get_no_resep != null) {
                $data['no_resep'] = $get_no_resep->no_resep;
            }else{
                $data['no_resep'] = '0';
            }


            if ($item_obat == null && $group->id_gudang == null) {
                $data['tgL_kadaluarsa'] = '';
            }else{
                $kadaluarsa = $this->Frmmdaftar->get_tgl_kadaluarsa($item_obat,$group->id_gudang)->result();

                foreach($kadaluarsa as $row){
                    $data['tgL_kadaluarsa']=$row->expire_date;
                }
            }
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [100, 60],
                'margin_top' => 5,
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'margin_header' => 0,
                'margin_footer' => 0,
	            'mirrorMargins' => true
            ]);
            $html = $this->load->view('farmasi/paper_css/cetak_resep',$data,true);
            $mpdf->curlAllowUnsafeSslRequests = true;
            //$this->mpdf->AddPage('L');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
			// $file_name="fobat_no_resep_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// tcpdf();
				// $pageLayout = array('280', '160'); //  or array($height, $width)
				// $obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);


		}else{
			redirect('farmasi/Frmcdaftar/','refresh');
		}
	}

    public function insert_permintaan_obat_luar()
    {

        $data['no_register']=$this->input->post('no_register_luar');

        $no_register = $this->input->post('no_register_luar');
        $data['no_medrec']=$this->input->post('no_medrec_luar');
        $data['tgl_kunjungan']=date('Y-m-d H:i:s');
        $ket=$this->input->post('ket');
        $data['nm_obat']=$this->input->post('nama_obat_luar');
        $nama_obat = $this->input->post('nama_obat_luar');
        $data['id_poli']=$this->input->post('idrg_luar');
        $data['no_resep']=$this->input->post('no_resep_luar');
        $no_resep = $this->input->post('no_resep_luar');
        if($this->input->post('qty_luar')!= ''){
            $data['qty']=$this->input->post('qty_luar');
        }else{
            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                if ($this->input->post('pelayan_luar') == 'DOKTER') {
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                }else{
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                }

        }
            $sgn=$this->input->post('signa_luar');
            $qtx=$this->input->post('qtx_luar');
            $cara_pakai=$this->input->post('cara_pakai_luar');
            $satuan=$this->input->post('satuan_luar');
            $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                if ($makan==''){
                    $data['signa']="-";
                    $data['qtx']=0;
                    $data['satuan']="-";
                    $data['cara_pakai']="-";
                    $data['kali_harian']="-";
                } else {
                    $data['signa']=$makan;
                    if ($qtx == null) {
                        $qtxs = 0;
                    }else{
                        $qtxs = $qtx;
                    }
                    $data['qtx']=$qtxs;
                    $data['satuan']=$satuan;
                    $data['cara_pakai']=$cara_pakai;
                    $data['kali_harian']=$sgn;
                }
            $signa = $makan;

        //03-08-2021

        //0 == iya
        $data['obat_luar']= '0';
        //03-08-2021


        $data['kronis'] = $this->input->post('kronis');
        $kronis = $this->input->post('kronis');
        $poli = $this->input->post('idpoli');


        //ini untuk input plan di pemeriksaan fisik
        // $cekplan = $this->Frmmdaftar->cek_plan($no_register)->row();



        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */
        // if($data['cara_bayar_luar'] == 'BPJS'){
        //     $this->Frmmdaftar->insert_permintaan($data);
        // }else{
            $this->Frmmdaftar->insert_permintaan_dokter($data);
        // }

        // input untuk laporan assesment awal keperawatan ird;

        if($this->input->post('idpoli') == "BA00"){
            $report['no_register'] = $this->input->post('no_register_luar');
            $report['signa'] = $signa;
            $report['nm_resep'] =$this->input->post('nama_obat_luar');
            $login_data = $this->load->get_var("user_info");
            $report['id_pemeriksa'] = $login_data->userid;
            $report['tgl_input'] = date('Y-m-d H:i:s');
            $this->rdmpelayanan->insert_tindakan_resep_pasien_ird($report);
        }




        if ($this->input->post('koreksi') != '') {
            redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$data['no_register']);
        }
            if ($this->input->post('pelayan_luar') == 'DOKTER') {
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
            }else{
                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
            }

        //echo print_r($data);
    }

    public function edit_obat_racikan()
    {
        // var_dump($this->input->post());die();
        $no_register=$this->input->post('edit_no_register_racikan');

        $id_obat_racikan = $this->input->post('edit_id_obat_racikan_hidden');
        $id_resep_pasien = $this->input->post('edit_id_resep_pasien_racikan');
        $qty=$this->input->post('edit_qty_racikan');
        $data['qty'] = $qty;


        $this->Frmmdaftar->edit_obat_racikan($id_obat_racikan, $data);


        if ($this->input->post('pelayan_racikan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
            echo json_encode(array(
                "status" => TRUE,
                "no_register" => $no_register,
                "id_resep_pasien" => $id_resep_pasien
            ));
        }

    }

   public function detail_obat_igd()
   {
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);

        $id_inventory = $this->input->post('id_inventory');
        $data = $this->Frmmdaftar->detail_obat_igd($group->id_gudang,$id_inventory)->row();

        echo json_encode(array(
            'data' => $data
        ));
   }

   public function get_biaya_obat($id)
   {  
           header('Content-Type: application/json; charset=utf-8');
           $data=$this->Frmmdaftar->get_biaya_obat($id)->row();
           echo json_encode($data);
       
   }

   public function insert_permintaan_last_()
   {
       $no_register = $this->input->post('no_register');
       $login_data = $this->load->get_var("user_info");
       // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

       $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
       $i=1;

       foreach ($id_gudang as $row) {
           $no_gudang[]=$row->id_gudang;
       }

       $userid = $this->session->userid;
       $group = $this->Frmmpo->getIdGudang($userid);
       // if($group->id_gudang == "8" || $group->id_gudang == "7"){
       //     $ids = "1";
       // }else{
           // $ids = join("','",$no_gudang);
       // }

       $obatnya = $this->input->post('jumlah_obat[]');
    //    var_dump($obatnya);die();

    //    $id_poli = $this->Frmmdaftar->get_id_poli_by_noreg($no_register)->row()->id_poli;
    //    $get_obat = $this->Frmmdaftar->get_data_obat_query($group->id_gudang,$userid,$id_poli)->result_array();
    $get_no_medrec = $this->Frmmdaftar->get_data_pasien_resep($no_register)->row()->no_medrec;
    // var_dump( $get_no_medrec);die();136783
    $get_id_poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
    // var_dump($get_id_poli);die();BR00
    $get_no_register = $this->Frmmdaftar->get_noreg_by_medrec_poli_rj($get_no_medrec,$get_id_poli)->row()->no_register;
    $get_obat = $this->Frmmdaftar->last_obat($get_no_register)->result_array();


       foreach($get_obat as $value){
           // $value['nm_obat']
           // if($data)
           if($obatnya){
               // echo 'masuk sini';die();
               foreach($obatnya as $pembanding){
                   // var_dump($pembanding);die();
                   if($pembanding == $value['id_resep_pasien']){
                       // echo 'masuk sini';die();
                       // echo $value['id_obat'].'<br>';
                       // echo $value['nm_obat'].'<br>';
                       // echo $value['hargajual'].'<br>';
                       // echo $this->input->post('sgn-1-'.$value['id_obat']);
                       // echo $this->input->post('sgn-2-'.$value['id_obat']);
                       // echo $this->input->post('satuan-'.$value['id_obat']);
                       // echo $this->input->post('qty-'.$value['id_obat']);
                       // echo $value['id_inventory'].'<br>';
                       // echo $value['jenis_obat'].'<br>';
                       $no_register = $this->input->post('no_register');
                       $data['no_register']=$this->input->post('no_register');

                       $data['no_medrec']=$this->input->post('no_medrec');
                       $data['tgl_kunjungan']=date('Y-m-d H:i:s');
                       if($value['id_inventory'] != null){
                        $dsvinte = $value['id_inventory'];
                       }else{
                        $dsvinte = null;
                       }
                       $data['id_inventory']= $dsvinte;

                       //03-08-2021
                       $data['id_gudang']= $group->id_gudang;
                       //1 == TIDAK
                       $data['obat_luar']= '1';
                       //03-08-2021

                      // $data['jenis_obat']= $value['jenis_obat'];
                       // $data['bpjs']=$this->input->post('bpjs');
                       $data['cara_bayar'] = $this->input->post('cara_bayar');
                       $ket=$this->input->post('ket');
                    //   if($ket==1){
                    //        $data['item_obat']=$this->input->post('item_obat');
                    //        $data['nama_obat']=$this->input->post('cari_obat'). "(Konsinyasi)";
                    //        $nama_obat=$this->input->post('cari_obat'). "(Konsinyasi)";
                    //   }
                    //    else{
                           // $data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'])->row();
                           // $data['item_obat']=$data_tindakan->id_obat;
                           // $data['nama_obat']=$data_tindakan->nm_obat;
                           // $data['Satuan_obat']=$data_tindakan->satuank;
                           if($value['item_obat'] != null){
                            $dsid = $value['item_obat'];
                           }else{
                            $dsid = null;
                           }
                           $data['item_obat']=$dsid;
                           $data['nama_obat']=$this->input->post('nama_obat-last-'.$value['id_resep_pasien']);
                           if($this->input->post('racikan-last-'.$value['id_resep_pasien']) != null){
                            $dsracik = $this->input->post('racikan-last-'.$value['id_resep_pasien']);
                           }else{
                            $dsracik = null;
                           }
                           $data['racikan']=$dsracik;
                           $nama_obat=$value['nama_obat'];
                           // $data['Satuan_obat']=$this->input->post('satuan-'.$value['id_obat']);
                           // $satuan_obat=$this->input->post('satuan-'.$value['id_obat']);
                    //    }

                       // var_dump($data);
                       $data['idrg']=$this->input->post('idrg');

                       $data['bed']=$this->input->post('bed');
                       $data['no_resep']=$this->input->post('no_resep');
                       $no_resep=$this->input->post('no_resep');


                       if($this->input->post('qty-last-'.$value['id_resep_pasien'])!= ''){
                           $data['qty']=$this->input->post('qty-last-'.$value['id_resep_pasien']);
                       }else{
                           $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                               if ($this->input->post('pelayan') == 'DOKTER') {
                                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                               }else{
                                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                               }

                       }
                       $data['resep_pulang']=$this->input->post('resep_pulang-last');
                       if($this->input->post('kronis-last-'.$value['id_resep_pasien']) == null){
                            $data['kronis']=0;
                       }else{
                            $data['kronis']=$this->input->post('kronis-last-'.$value['id_resep_pasien']);
                       }

                       $sgn=$this->input->post('signa-last-'.$value['id_resep_pasien']);
                       $qtx=$this->input->post('qtx-last-'.$value['id_resep_pasien']);
                       $satuan=$this->input->post('satuan-last-'.$value['id_resep_pasien']);
                       $cara_pakai=$this->input->post('cara_pakai-last-'.$value['id_resep_pasien']);
                       $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                           if ($makan==''){
                               $data['signa']="-";
                               $data['qtx']=0;
                               $data['Satuan_obat']="-";
                               $data['cara_pakai']="-";
                               $data['kali_harian']="-";
                           } else {
                               $data['signa']=$makan;
                               if ($qtx == null) {
                                   $qtxs = 0;
                               }else{
                                   $qtxs = $qtx;
                               }
                               $data['qtx']=$qtxs;
                               $data['Satuan_obat']=$satuan;
                               $data['cara_pakai']=$cara_pakai;
                               $data['kali_harian']=$sgn;
                           }
                       $signa = $makan;
                       // $qty=$this->input->post('qty-'.$value['id_obat']);
                       // $sgn=$this->input->post('signa-'.$value['id_obat']);
                       // $sgn2=$this->input->post('sgn2-'.$value['id_obat']);
                       // $sgn3=$this->input->post('sgn3-'.$value['id_obat']);
                       // $makan = strtoupper("Diminum ".$sgn3." Makan");
                       // $satuan=$this->input->post('satuan-'.$value['id_obat']);
                               // if ($sgn==''){
                               //     $data['signa']="-";
                               //     $signa="-";
                               // } else {
                               //     $data['signa']=$sgn;
                               //     $signa=$sgn;
                               // }

                    //    $stok_obat=$this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();


                    //    if (empty($stok_obat)) {
                    //        $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');

                    //            if ($this->input->post('pelayan') == 'DOKTER') {
                    //                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                    //            }else{
                    //                redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                    //            }

                    //    }
                            //     //update stok
                    //    $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);

                       $data['kelas']=$this->input->post('kelas_pasien');

                       $data['biaya_obat']=$this->input->post('biaya_obat-last-'.$value['id_resep_pasien']);
                       $data['fmarkup']=$this->input->post('fmarkup');
                       // UNTUK SEMENTARA INPUT HARGAJUAL DULU AJA:
                       // ---------------------------------------------------
                       //$data['vtot']=$this->input->post('vtot_hide');
                       // $data['ppn']=$this->input->post('margin');
                       // $total = $this->input->post('vtotakhir_hide');
                       $total = $data['biaya_obat'] * $data['qty'];
                       if($this->input->post('cara_bayar') == 'UMUM'){
                           //Update Margin Tambahan + Pembulatan 100 jika pasien Umum
                           $total_akhir = $total;//(int) (100 * ceil($total / 100));
                       }else{
                           $total_akhir = $total;
                       }
                       $data['vtot']=$total_akhir;

                       $data['tuslah']=$this->input->post('tuslah_non');
                       $data['xinput']=$this->input->post('xuser');
                       $data['satelit'] = $this->input->post('satelit');


                       $data['kronis'] = $this->input->post('kronis');
                       // $kronis = $this->input->post('kronis');
                       $poli = $this->input->post('idpoli');
                    //    if($ket!=1){
                    //        $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['item_obat'], $poli, $data['kronis']);
                    //        $row_klaim = $klaim->row();
                    //        $cek_klaim = $klaim->num_rows();
                    //    }


                       // print_r($data);
                       // die();
                       /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */


                    //    if($data['cara_bayar'] == 'BPJS'){

                           /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
                           * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
                           */
                        //    if($cek_klaim > 0) {

                        //        if($data['qty'] > $row_klaim->qty){
                        //            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                        //        }else{
                        //            $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');


                        //        }
                        //    }else{
                               // var_dump($data);
                               // die();
                            //    $this->Frmmdaftar->insert_permintaan($data);
                               //fisik

                    //        }
                    //    }else{
                           // var_dump($data);
                           $id = $this->Frmmdaftar->insert_permintaan_last_dokter($data);
                           //fisik

                    //    }
                        if($this->input->post('racikan-last-'.$value['id_resep_pasien']) != null){
                            $data_racik = $this->Frmmdaftar->get_racik_last($value['id_resep_pasien'])->result();
                            foreach($data_racik as $rom){
                                $darack['item_obat']=$rom->item_obat;
                                $darack['qty']=$rom->qty;
                                $darack['id_resep_pasien']=$id;
                                $darack['no_register']=$no_register;
                                $darack['id_inventory']=$rom->id_inventory;
                                $darack['dosis']=$rom->dosis;
                                $darack['satuan']=$rom->satuan;
                                $darack['nama_obat']=$rom->nama_obat;
                                $this->Frmmdaftar->insert_racik_last($darack);
                            }
                        }else{

                        }

                   }
                   // else{
                   //     // echo 'masuk else';die();
                   //     $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Obat Tidak Ada Di Gudang</div>');
                   //     if ($this->input->post('pelayan') == 'DOKTER') {
                   //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
                   //     }else{
                   //         redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register);
                   //     }
                   // }
               } //foreach2
           }else{
               // echo 'masuk else';
               // die();
               // die();
                if ($this->input->post('pelayan') == 'DOKTER') {
                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
               }else{
                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
               }
           }

       } //foreach1
       // var_dump($data);
       if ($this->input->post('koreksi') != '') {

           // die();
           redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
       }

       // die();
       if ($this->input->post('pelayan') == 'DOKTER') {
           redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
       }else{
           redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
       }

       // var_dump($data);
       // die();


       // var_dump($data);die();
       // foreach($this->input->post('cari_obat') as $values){
       //     echo $values;
       //     echo '<br>';
       // }
       // die();


       //echo print_r($data);
   }

   public function insert_permintaan_last()
   {
    // var_dump($this->input->post());die();
       $no_register = $this->input->post('no_register');
       $login_data = $this->load->get_var("user_info");
       // $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

       $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
       $i=1;

       foreach ($id_gudang as $row) {
           $no_gudang[]=$row->id_gudang;
       }

       $userid = $this->session->userid;
       $group = $this->Frmmpo->getIdGudang($userid);
       // if($group->id_gudang == "8" || $group->id_gudang == "7"){
       //     $ids = "1";
       // }else{
           // $ids = join("','",$no_gudang);
       // }

       $obatnya = $this->input->post('jumlah_obat[]');
            //    var_dump($obatnya);die();

            //    $id_poli = $this->Frmmdaftar->get_id_poli_by_noreg($no_register)->row()->id_poli;
            //    $get_obat = $this->Frmmdaftar->get_data_obat_query($group->id_gudang,$userid,$id_poli)->result_array();
            $get_no_medrec = $this->Frmmdaftar->get_data_pasien_resep($no_register)->row()->no_medrec;
            // var_dump( $get_no_medrec);die();136783
            $get_id_poli = $this->Frmmdaftar->get_idpoli($no_register)->row()->id_poli;
            // var_dump($get_id_poli);die();BR00
            $get_no_register = $this->Frmmdaftar->get_noreg_by_medrec_poli_rj($get_no_medrec,$get_id_poli)->row()->no_register;
            $get_obat = $this->Frmmdaftar->last_obat($get_no_register)->result_array();
            // var_dump( $get_no_register);die();

       foreach($get_obat as $value){
           // $value['nm_obat']
           // if($data)
           if($obatnya){
               // echo 'masuk sini';die();
               foreach($obatnya as $pembanding){
                   // var_dump($pembanding);die();
                   if($pembanding == $value['id_resep_pasien']){

                     if($value['item_obat'] != null){
                        $dsid = $value['item_obat'];
                       }else{
                        $dsid = null;
                       }
                       $data['id_obat']=$dsid;
                       $data['nm_obat']=$this->input->post('nama_obat-last-'.$value['id_resep_pasien']);
                       if($this->input->post('racikan-last-'.$value['id_resep_pasien']) != null){
                        $dsracik = $this->input->post('racikan-last-'.$value['id_resep_pasien']);
                       }else{
                        $dsracik = null;
                       }
                       $data['racikan']=$dsracik;
                       $nama_obat=$value['nama_obat'];
                       $no_register = $this->input->post('no_register');
                       $data['no_register']=$this->input->post('no_register');
                       $data['tgl_kunjungan']=date('Y-m-d H:i:s');
                       $sgn=$this->input->post('signa-last-'.$value['id_resep_pasien']);
                       $qtx=$this->input->post('qtx-last-'.$value['id_resep_pasien']);
                       $satuan=$this->input->post('satuan-last-'.$value['id_resep_pasien']);
                       $cara_pakai=$this->input->post('cara_pakai-last-'.$value['id_resep_pasien']);
                       $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                           if ($makan==''){
                               $data['signa']="-";
                               $data['qtx']=0;
                               $data['satuan']="-";
                               $data['cara_pakai']="-";
                               $data['kali_harian']="-";
                           } else {
                               $data['signa']=$makan;
                               if ($qtx == null) {
                                   $qtxs = 0;
                               }else{
                                   $qtxs = $qtx;
                               }
                               $data['qtx']=$qtxs;
                               $data['satuan']=$satuan;
                               $data['cara_pakai']=$cara_pakai;
                               $data['kali_harian']=$sgn;
                           }
                       $signa = $makan;
                       $data['no_medrec']=$this->input->post('no_medrec');
                       $data['id_poli']=$this->input->post('idpoli');
                       $no_resep=$this->input->post('no_resep');
                       $data['no_resep']=$this->input->post('no_resep');
                       $data['obat_luar']= '1';
                       $data['kronis'] = $this->input->post('kronis');
                       if($this->input->post('qty-last-'.$value['id_resep_pasien'])!= ''){
                        $data['qty']=$this->input->post('qty-last-'.$value['id_resep_pasien']);
                        }else{
                            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Isi Data Dengan Lengkap</div>');

                                if ($this->input->post('pelayan') == 'DOKTER') {
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
                                }else{
                                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
                                }

                        }
                        $data['resep_pulang']=$this->input->post('resep_pulang-last');
                        if($this->input->post('kronis-last-'.$value['id_resep_pasien']) == null){
                            $data['kronis']=0;
                        }else{
                            $data['kronis']=$this->input->post('kronis-last-'.$value['id_resep_pasien']);
                        }

                        $id = $this->Frmmdaftar->insert_permintaan_last_dokter($data);
                         
                        if($this->input->post('racikan-last-'.$value['id_resep_pasien']) != null){
                            $data_racik = $this->Frmmdaftar->get_racik_last($value['id_resep_pasien'])->result();
                            foreach($data_racik as $rom){
                                $darack['item_obat']=$rom->item_obat;
                                $darack['qty']=$rom->qty;
                                $darack['id_resep_pasien']=$id;
                                $darack['no_register']=$no_register;
                                $darack['id_inventory']=$rom->id_inventory;
                                $darack['dosis']=$rom->dosis;
                                $darack['satuan']=$rom->satuan;
                                $darack['nama_obat']=$rom->nama_obat;
                                $this->Frmmdaftar->insert_racik_last($darack);
                            }
                        }else{

                        }

                   }
                  
               } //foreach2
           }else{
               
                if ($this->input->post('pelayan') == 'DOKTER') {
                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
               }else{
                   redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
               }
           }

       } //foreach1
       // var_dump($data);
       if ($this->input->post('koreksi') != '') {

           // die();
           redirect('farmasi/Frmcdaftar/permintaan_obat_koreksi/'.$no_register);
       }

       // die();
       if ($this->input->post('pelayan') == 'DOKTER') {
           redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
       }else{
           redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
       }

       // var_dump($data);
       // die();


       // var_dump($data);die();
       // foreach($this->input->post('cari_obat') as $values){
       //     echo $values;
       //     echo '<br>';
       // }
       // die();


       //echo print_r($data);
   }


   public function insert_permintaan_dokter()
    {
        // var_dump($this->input->post());die();
        $data['id_obat'] =$this->input->post('idobat');
        $data['nm_obat'] =$this->input->post('cari_obat');
        $data['no_register'] =$this->input->post('no_register');
        $data['tgl_kunjungan'] =$this->input->post('tgl_kun');
        $data['signa'] =$this->input->post('signa');
        $data['cara_pakai'] =$this->input->post('cara_pakai');
        $data['qty'] =$this->input->post('qty');
        $data['jenis_obat'] =$this->input->post('jenis_obat');
        $data['satuan'] =$this->input->post('satuan');
        $data['no_medrec'] =$this->input->post('no_medrec');
        $data['qtx'] =$this->input->post('qtx');
        $data['id_poli'] =$this->input->post('idrg');
        $data['obat_luar'] =$this->input->post('jenis_obat');
        $data['kronis'] =$this->input->post('kronis');
        $data['resep_pulang'] =$this->input->post('resep_pulang');

        if ($this->input->post('gantisigna') == 'OTOMATIS') {
            $sgn=$this->input->post('signa');
            $qtx=$this->input->post('qtx');
            $satuan=$this->input->post('satuan');
            $cara_pakai=$this->input->post('cara_pakai');
            $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                if ($makan==''){
                    $data['signa']="-";
                    $data['qtx']=0;
                    $data['satuan']="-";
                    $data['cara_pakai']="-";
                    $data['kali_harian']="-";
                } else {
                    $data['signa']=$makan;
                    if ($qtx == null) {
                        $qtxs = 0;
                    }else{
                        $qtxs = $qtx;
                    }
                    $data['qtx']=$qtxs;
                    $data['satuan']=$satuan;
                    $data['cara_pakai']=$cara_pakai;
                    $data['kali_harian']=$sgn;
                }
            $signa = $makan;
        }else{
            $sgn=$this->input->post('signa_all');
            $makan = $sgn;
                if ($makan==''){
                    $data['signa']="-";
                    $data['qtx']=0;
                    $data['satuan']="-";
                    $data['cara_pakai']="-";
                    $data['kali_harian']="-";
                } else {
                    $data['signa']=$makan;
                    $data['qtx']=0;
                    $data['satuan']="-";
                    $data['cara_pakai']="-";
                    $data['kali_harian']="-";
                }
            $signa = $makan;
        }

        $this->Frmmdaftar->insert_permintaan_dokter($data);

        if ($this->input->post('pelayan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
        }


        // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');

    }

    public function get_data_edit_obat_dokter(){
        $id_resep_dokter=$this->input->post('id_resep_dokter');
        $datajson=$this->Frmmdaftar->get_resep_pasien_dokter($id_resep_dokter)->result();
        echo json_encode($datajson);
    }

    public function edit_obat_dokter()
    {
        $no_register=$this->input->post('edit_no_register');
        $id_resep_dokter = $this->input->post('edit_id_resep_dokter');
        $signa=$this->input->post('edit_signa');
        $satuan=$this->input->post('edit_satuan');
        $cara_pakai=$this->input->post('edit_cara_pakai');
        $qty=$this->input->post('edit_qty');
        $qtx=$this->input->post('edit_qtx');
        $qty_old=$this->input->post('edit_qty_hidden');
        $id_obat=$this->input->post('edit_id_obat_hidden');

        $data['qty'] = $qty;
		$data['signa']=strtoupper($signa.", ".$qtx." ".$satuan.", ".$cara_pakai);
		$data['satuan']=$satuan;
		$data['cara_pakai']=$cara_pakai;
		$data['kali_harian']=$signa;
		if ($qtx == null) {
            $qtxs = 0;
        }else{
            $qtxs = $qtx;
        }
        $data['qtx']=$qtxs;

        $this->Frmmdaftar->edit_obat_dokter($id_resep_dokter, $data);

        
        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
              

    }

    public function edit_obat_racikan_farmasi()
    {
        // var_dump($this->input->post());die();
        $no_register=$this->input->post('edit_no_register_racikan_far');

        $id_obat_racikan = $this->input->post('edit_id_obat_racikan_far_hidden');
        $id_resep_pasien = $this->input->post('edit_id_resep_pasien_racikan_far');

        $obat_sub = $this->input->post('nm_sub');
        $id_sub = $this->input->post('cari_obat_sub_racik');

        if($obat_sub != '' && $id_sub != ''){
            $this->Frmmdaftar->update_obat_racik($id_obat_racikan,$id_sub,$obat_sub);
        }

        
        $qty=$this->input->post('edit_qty_racikan_far');
        $id_inventory = $this->input->post('batch_farmasi_racik');
        $this->Frmmdaftar->update_stok_racik($qty,$id_inventory);
        $data['qty'] = $qty;
        $data['inputfarmasi'] = 1;
        $data['id_inventory'] = $id_inventory;


        $this->Frmmdaftar->edit_obat_racikan($id_obat_racikan, $data);


        // if ($this->input->post('pelayan_racikan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS/RACIK');
        // }else{
            // redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        //     echo json_encode(array(
        //         "status" => TRUE,
        //         "no_register" => $no_register,
        //         "id_resep_pasien" => $id_resep_pasien
        //     ));
        // }

    }

    public function get_data_edit_obat_farmasi(){
        $id_resep_dokter=$this->input->post('id_resep_dokter');
        $id_obat=$this->input->post('id_obat');
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $datajson['sub']=$this->rimtindakan->get_data_obat_sub($id_obat)->result();
        $datajson['resep']=$this->Frmmdaftar->get_resep_pasien_farmasi($id_resep_dokter,$id_gudang)->result();
        // var_dump($datajson['resep']);die();
        echo json_encode($datajson);
    }

    public function edit_obat_farmasi()
    {
        // var_dump($this->input->post());die();

            $nm_obat_sub = $this->input->post('nm_sub');
			$id_obat_sub = $this->input->post('cari_obat_sub');
            $id_resep_dokter=$this->input->post('edit_id_resep_dokter_far');
            $data_resep_dokter = $this->Frmmdaftar->get_resep_pasien_dokter($id_resep_dokter)->row();

		  if($nm_obat_sub && $id_obat_sub){
			$data['item_obat']=$id_obat_sub;
			$data['nama_obat']=$nm_obat_sub;
		  }else{
            $data['item_obat']=$data_resep_dokter->id_obat;
            $data['nama_obat']=$data_resep_dokter->nm_obat;
		  }


      
        $data['id_resep_dokter'] = $id_resep_dokter;
        $data['no_medrec']=$data_resep_dokter->no_medrec;
        $data['tgl_kunjungan']=$data_resep_dokter->tgl_kunjungan;
        $data['id_inventory']=$this->input->post('batch_farmasi');
        $data['Satuan_obat']=$this->input->post('edit_satuan_farmasi');
        $data['qty']=$this->input->post('edit_qty_farmasi');

        $sgn=$this->input->post('edit_signa_farmasi');
        $qtx=$this->input->post('edit_qtx_farmasi');
        $satuan=$this->input->post('edit_satuan_farmasi');
        $cara_pakai=$this->input->post('edit_cara_pakai_farmasi');

        $data['signa']=$this->input->post('edit_signa_farmasi');
        if($data['signa'] == null){
            $data['signa']=$data_resep_dokter->signa;
        }else{
            $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
            $data['signa']= $makan; 
        }
        
        $data['no_register']=$this->input->post('edit_no_register_far');
        $data['kelas']=$this->input->post('kelas_pasien');
        $data['idrg']=$this->input->post('idrg');
        $data['bed']=$this->input->post('bed');
        $data['biaya_obat']=$this->input->post('edit_biaya_obat');
        $data['vtot']=$this->input->post('edit_total_akhir'); 
        $data['cara_bayar']=$this->input->post('cara_bayar');
        $data['cara_pakai']=$this->input->post('edit_cara_pakai_farmasi');
        $data['kali_harian']=$this->input->post('edit_signa_farmasi');
        $data['obat_luar']=$data_resep_dokter->obat_luar;
        $data['qtx']=$this->input->post('edit_qtx_farmasi');
        $data['xuser']=$this->input->post('xuser');

        $this->Frmmdaftar->insert_permintaan($data);
        $edit['inputfarmasi'] = 1;
        $edit['signa'] =  $data['signa'];
        $this->Frmmdaftar->update_resep_dokter($id_resep_dokter,$edit);

        if ($this->input->post('pelayan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
        }
        // }
        

    }

    public function hapus_data_obat_dokter($pelayan,$no_register,$id_resep_dokter){

        $this->Frmmdaftar->hapus_data_obat_dokter($id_resep_dokter);

        if ($pelayan == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/PETUGAS');
        }
    }

    public function insert_paket_obat(){
        $no_register = $this->input->post('no_register');
        $paketnya = $this->input->post('jumlah_paket[]');

        $get_paket = $this->Frmmdaftar->get_paket_obat()->result_array();
        foreach($get_paket as $value){
            if($paketnya != null){
                foreach($paketnya as $pembanding){
                    if($pembanding == $value['id_paket']){
                        $get_detail_paket = $this->Frmmdaftar->get_detail_paket_obat($pembanding)->result_array();
                        foreach($get_detail_paket as $detail){
                            $data['id_obat'] =$detail['id_obat'];
                            $data['nm_obat'] =$detail['nama_obat'];
                            $data['qty'] =$detail['qty'];
                            $data['jenis_obat'] =1;
                            $data['obat_luar'] =1;
                            $data['no_register'] =$this->input->post('no_register');
                            $data['no_medrec']=$this->input->post('no_medrec');
                            $data['id_poli'] =$this->input->post('idrg');
                            $data['tgl_kunjungan'] =date('Y-m-d');
                            $data['no_resep'] =$this->input->post('no_resep');
                            $this->Frmmdaftar->insert_permintaan_dokter($data);
                            // var_dump($detail['racikan']);die();
                            // if($detail['racikan'] != '0'){
                            //     echo 'masuk sini';
                            // }
                        }
                    }
                } //foreach2
            }else{
                // die();
              
                    redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
            }

        }
        redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER');
        // var_dump($this->input->post());die();
    }

    public function edit_obat_farmasi_luar()
    {
           
        // var_dump($this->input->post());die();
        $id_inventory=$this->input->post('id_inven');
        $id_resep_dokter=$this->input->post('edit_id_resep_dokter_far_luar');
        $data_resep_dokter = $this->Frmmdaftar->get_resep_pasien_dokter($id_resep_dokter)->row();
        $data_resep = $this->Frmmdaftar->get_item_obat_luar($id_inventory)->row();


        $data['item_obat']= $data_resep->id_obat;
        $data['nama_obat']= $data_resep->nm_obat;
        $data['id_resep_dokter'] = $this->input->post('edit_id_resep_dokter_far_luar');
        $data['no_medrec']=$data_resep_dokter->no_medrec;
        $data['tgl_kunjungan']=$data_resep_dokter->tgl_kunjungan;
        $data['id_inventory']=$this->input->post('id_inven');
        $data['Satuan_obat']=$this->input->post('edit_satuan_farmasi_luar');
        $data['qty']=$this->input->post('edit_qty_farmasi_luar');

        $sgn=$this->input->post('edit_signa_farmasi_luar');
        $qtx=$this->input->post('edit_qtx_farmasi_luar');
        $satuan=$this->input->post('edit_satuan_farmasi_luar');
        $cara_pakai=$this->input->post('edit_cara_pakai_farmasi_luar');

        $data['signa']=$this->input->post('edit_signa_farmasi_luar');
        if($data['signa'] == null){
            $data['signa']=$data_resep_dokter->signa;
        }else{
            $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
            $data['signa']= $makan; 
        }
        // var_dump($data['signa']);die();
        $data['no_register']=$this->input->post('edit_no_register_far_luar');
        $data['kelas']=$this->input->post('kelas_pasien');
        $data['idrg']=$this->input->post('idrg');
        $data['bed']=$this->input->post('bed');
        $data['biaya_obat']=$this->input->post('edit_biaya_farmasi_luar');
        $data['vtot']=$this->input->post('edit_total_akhir_luar'); 
        $data['cara_bayar']=$this->input->post('cara_bayar');
        $data['cara_pakai']=$this->input->post('edit_cara_pakai_farmasi_luar');
        $data['kali_harian']=$this->input->post('edit_signa_farmasi_luar');
        $data['obat_luar']=1;
        $data['qtx']=$this->input->post('edit_qtx_farmasi_luar');
        $data['xuser']=$this->input->post('xuser');

        $this->Frmmdaftar->insert_permintaan($data);
        $edit['inputfarmasi'] = 1;
        $edit['signa'] =  $data['signa'];
        $this->Frmmdaftar->update_resep_dokter($id_resep_dokter,$edit);

        if ($this->input->post('pelayan') == 'DOKTER') {
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/DOKTER');
        }else{
            redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/PETUGAS');
        }
        // }
        

    }

    public function get_data_edit_obat_farmasi_luar(){
        $id_resep_dokter=$this->input->post('id_resep_dokter');
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $datajson['resep']=$this->Frmmdaftar->get_resep_pasien_dokter($id_resep_dokter)->result();
        // var_dump($datajson['resep']);die();
        echo json_encode($datajson);
    }

    public function get_biaya_obat_luar()
	{  
            header('Content-Type: application/json; charset=utf-8');
            $id = $this->input->post('id');
			$data=$this->Frmmdaftar->get_biaya_obat($id)->row();
            echo json_encode($data);
		
	}

   

}

