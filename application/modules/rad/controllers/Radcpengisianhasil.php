<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as Exception;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

//require_once(APPPATH.'controllers/Secure_area.php');
class Radcpengisianhasil extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('rad/radmdaftar', '', TRUE);
		$this->load->model('rad/radmkwitansi', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper(array('form', 'url'));
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
	}

	public function index()
	{
		$data['title'] = 'Diagnostik Tanggal ' . date('d-m-Y');
		$data['radiologi'] = $this->radmdaftar->get_hasil_rad()->result();
		$data['radiologi_ri'] = $this->radmdaftar->get_hasil_rad_ri()->result();
		$this->load->view('rad/radvdaftarpengisian', $data);
	}

	public function by_date()
	{
		$date = $this->input->post('date');
		$data['title'] = 'Diagnostik Tanggal ' . date('d-m-Y', strtotime($date));
		$data['radiologi_ri'] = $this->radmdaftar->get_hasil_rad_by_date_ri($date)->result();
		$data['radiologi'] = $this->radmdaftar->get_hasil_rad_by_date($date)->result();
		$this->load->view('rad/radvdaftarpengisian', $data);
	}

	public function by_no()
	{
		$key = $this->input->post('key');
		$data['title'] = 'Diagnostik | ' . $key;
		$data['radiologi_ri'] = $this->radmdaftar->get_hasil_rad_by_no_new_ri($key)->result();
		$data['radiologi'] = $this->radmdaftar->get_hasil_rad_by_no_new($key)->result();
		$this->load->view('rad/radvdaftarpengisian', $data);
	}

	public function daftar_hasil($no_rad = '')
	{
		$data['title'] = 'Diagnostik';
		$data['no_rad'] = $no_rad;
		$data['radio'] = 'RAD';
		$data['tanggal'] = '';
		$no_register = $this->radmdaftar->get_no_register($no_rad)->row()->no_register;
		$no_medrec = $this->radmdaftar->get_no_medrec_hasil($no_rad)->row()->no_medrec;
		$id_poli = $this->radmdaftar->get_idrg_hasil($no_rad)->row()->idrg;
		$no_cm = $this->radmdaftar->get_no_rm_hasil($no_medrec)->row()->no_cm;
		$data['no_register'] = $no_register;
		$data['no_medrec'] = $no_medrec;
		$data['no_cm'] = $no_cm;
		$data['id_poli'] = $id_poli;
		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_rad)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['rs_perujuk'] = $row->rs_perujuk;
				$data['no_cm'] = '-';
				$data['no_medrec'] = '-';
				$data['kelas_pasien'] = 'III';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['nmkontraktor'] = '';
				$data['jenkel'] = $row->jk;
				$data['tgl_lahir'] = $row->tgl_lahir;
				$data['nama_diagnosa'] = $row->diagnosa;
				// $data['waktu_masuk_rad']='';
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_hasil_pemeriksaan($no_rad)->result();
			// var_dump($data['data_pasien_pemeriksaan']);die();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['jenkel'] = $row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;

				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'II';
			} else if (substr($no_register, 0, 2) == "RI") {
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$nm_diagnosa = $this->radmdaftar->get_nama_diagnosa($id_icd)->row();
					if ($nm_diagnosa != null) {
						$data['nama_diagnosa'] = $nm_diagnosa->nm_diagnosa;
					} else {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
					}
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}

				// $data['waktu_masuk_rad']='';
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
		}

		$get_no_lab = $this->radmdaftar->get_no_lab_last($no_register)->row();
		if ($get_no_lab != null) {
			if ($get_no_lab->no_lab != 0) {
				$data['no_lab'] = $get_no_lab->no_lab;
			} else {
				$data['no_lab'] = null;
			}
		} else {
			$data['no_lab'] = null;
		}

		$data['daftarpengisian'] = $this->radmdaftar->get_data_pengisian_hasil($no_rad)->result();

		$this->load->view('rad/radvdaftarhasil', $data);
	}

	public function isi_hasil($id_pemeriksaan_rad = '')
	{
		$data['title'] = 'Radiologi';
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
		$data['tanggal'] = '';
		$data['radio'] = 'RAD';
		$no_register = $this->radmdaftar->get_no_register_by_id($id_pemeriksaan_rad)->row()->no_register;
		$no_medrec = $this->radmdaftar->get_no_medrec_hasil_by_id($id_pemeriksaan_rad)->row()->no_medrec;
		$id_poli = $this->radmdaftar->get_idrg_hasil_by_id($id_pemeriksaan_rad)->row()->idrg;
		$no_cm = $this->radmdaftar->get_no_rm_hasil($no_medrec)->row()->no_cm;

		$data['no_register'] = $no_register;
		$data['no_medrec'] = $no_medrec;
		$data['no_cm'] = $no_cm;
		$data['id_poli'] = $id_poli;
		$nr = $this->radmdaftar->get_row_register($id_pemeriksaan_rad)->result();
		foreach ($nr as $row) {
			$no_register = $row->no_register;
		}

		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_register'] = $no_register;
				$data['no_cm'] = '-';
				$data['no_medrec'] = '-';
				$data['kelas_pasien'] = 'III';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_rad'] = $row->no_rad;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['nmkontraktor'] = '';
				$data['jenkel'] = $row->jk;
				$data['tgl_lahir'] = $row->tgl_lahir;
				$data['nama_diagnosa'] = $row->diagnosa;
				$data['rs_perujuk'] = $row->rs_perujuk;
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				$data['id_dokter_1'] = $row->id_dokter_1;
				$data['asal'] = 'Pasien Luar';
				// $data['waktu_masuk_rad']='';
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['id_dokter_1'] = $row->id_dokter_1;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_rad'] = $row->no_rad;
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				$data['diag_klinis'] = $row->diag_klinis_rad;
				//$data['jenkel']=$row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
				$data['nmkontraktor'] = '';

				if ($row->sex == 'P') {
					$data['jenkel'] = 'Perempuan';
				} else {
					$data['jenkel'] = 'Laki Laki';
				}

				if (substr($no_register, 0, 2) == "RJ") {
					$data['asal'] = $row->bed;
				}
				if (substr($no_register, 0, 2) == "RI") {
					$data['asal'] = $row->idrg;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				$data['dokter_rujuk'] = $this->radmdaftar->get_dokter_pengirim_rj($no_register)->row()->nm_dokter;
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'II';
			} else if (substr($no_register, 0, 2) == "RI") {
				// $data['waktu_masuk_rad']='';
				$data['dokter_rujuk'] = $this->radmdaftar->get_dokter_pengirim_ri($no_register)->row()->dokter;
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$data['nama_diagnosa'] = $this->radmdaftar->get_nama_diagnosa($id_icd)->row()->nm_diagnosa;
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
		}

		$get_no_lab = $this->radmdaftar->get_no_lab_last($no_register)->row();
		if ($get_no_lab != null) {
			if ($get_no_lab->no_lab != 0) {
				$data['no_lab'] = $get_no_lab->no_lab;
			} else {
				$data['no_lab'] = null;
			}
		} else {
			$data['no_lab'] = null;
		}
		//var_dump($data['dokter_rujuk']); die();
		$data['tindakan'] = $this->radmdaftar->get_data_tindakan_rad_id($id_pemeriksaan_rad)->row();
		$data['jenis_tindakan'] = $data['tindakan']->jenis_tindakan;
		$data['dokter_rad'] = $this->radmdaftar->getdata_dokter()->result();
		$data['get_dpjp_by_noreg'] = $this->radmdaftar->get_dpjp_by_noreg($no_register);

		$data['jenis_deskripsi'] = $this->radmdaftar->getdata_deskripsi_rad()->result();

		$this->load->view('rad/radvisihasil', $data);
	}

	public function edit_hasil($id_pemeriksaan_rad = '')
	{
		$data['title'] = 'Diagnostik';
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
		$data['radio'] = 'RAD';
		$data['tanggal'] = '';
		$no_register = $this->radmdaftar->get_no_register_by_id($id_pemeriksaan_rad)->row()->no_register;
		$no_medrec = $this->radmdaftar->get_no_medrec_hasil_by_id($id_pemeriksaan_rad)->row()->no_medrec;
		$id_poli = $this->radmdaftar->get_idrg_hasil_by_id($id_pemeriksaan_rad)->row()->idrg;
		$no_cm = $this->radmdaftar->get_no_rm_hasil($no_medrec)->row()->no_cm;

		$data['no_register'] = $no_register;
		$data['no_medrec'] = $no_medrec;
		$data['no_cm'] = $no_cm;
		$data['id_poli'] = $id_poli;

		//$no_register=$this->radmdaftar->get_row_register($id_pemeriksaan_rad)->row()->no_register;
		//$data['tind']=$this->radmdaftar->get_data_hasil_rad_pemeriksaan($id_pemeriksaan_rad)->row();
		//$data['no_rad'] = $data['tind']->no_rad;
		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad)->result();
			$data['gambar_hasil_pemeriksaan'] = $this->radmdaftar->get_gambar_hasil_rad($id_pemeriksaan_rad)->result();
			foreach ($data['gambar_hasil_pemeriksaan'] as $row_gambar) {
				$data['gambar_name'] = $row_gambar->name;
			}
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_register'] = $no_register;
				$data['no_cm'] = '-';
				$data['no_medrec'] = '-';
				$data['kelas_pasien'] = 'III';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_rad'] = $row->no_rad;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['hasil_periksa'] = $row->hasil_periksa;
				$data['hasil_dokter'] = $row->hasil_dokter;
				$data['gambar_hasil'] = $row->gambar_hasil;
				$data['nmkontraktor'] = '';
				$data['klinikal'] = $row->klinikal;
				$data['saran'] = $row->saran;
				$data['usul'] = $row->usul;
				$data['hasil_1'] = $row->hasil_1;
				$data['btk'] = $row->btk;
				$data['rekam_radiologi'] = $row->rekam_radiologi;
				$data['waktu_masuk_rad'] = '';
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				$data['id_hasil_rad'] = $row->id_hasil_rad;
				$data['id_dokter_1'] = $row->id_dokter_1;
				$data['jenkel'] = $row->jk;
				$data['tgl_lahir'] = $row->tgl_lahir;
				$data['nama_diagnosa'] = $row->diagnosa;
				$data['rs_perujuk'] = $row->rs_perujuk;
				$data['asal'] = 'Pasien Luar';
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad)->result();
			// var_dump($data['data_pasien_pemeriksaan']);die();
			$data['gambar_hasil_pemeriksaan'] = $this->radmdaftar->get_gambar_hasil_rad($id_pemeriksaan_rad)->result();
			foreach ($data['gambar_hasil_pemeriksaan'] as $row_gambar) {
				$data['gambar_name'] = $row_gambar->name;
			}
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_cm'] = $row->no_cm;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['tglkun'] = $row->tglkunj;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_rad'] = $row->no_rad;
				$data['hasil_periksa'] = $row->hasil_periksa;
				$data['hasil_dokter'] = $row->hasil_dokter;
				$data['gambar_hasil'] = $row->gambar_hasil;
				$data['id_hasil_rad'] = $row->id_hasil_rad;
				$data['id_dokter_1'] = $row->id_dokter_1;
				$data['klinikal'] = $row->klinikal;
				$data['saran'] = $row->saran;
				$data['usul'] = $row->usul;
				$data['hasil_1'] = $row->hasil_1;
				$data['btk'] = $row->btk;
				$data['rekam_radiologi'] = $row->rekam_radiologi;
				$data['jenkel'] = $row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;
				// $data['id_dokter_2']=$row->id_dokter_2;
				// $data['hasil_2']=$row->hasil_2;
				// $data['id_dokter_3']=$row->id_dokter_3;
				// $data['hasil_3']=$row->hasil_3;
				// $data['id_dokter_4']=$row->id_dokter_4;
				// $data['hasil_4']=$row->hasil_4;
				// $data['id_dokter_5']=$row->id_dokter_5;
				// $data['hasil_5']=$row->hasil_5;
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}

				if (substr($no_register, 0, 2) == "RJ") {
					$data['asal'] = $row->bed;
				}
				if (substr($no_register, 0, 2) == "RI") {
					$data['asal'] = $row->idrg;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				$data['dokter_rujuk'] = $this->radmdaftar->get_dokter_pengirim_rj($no_register)->row()->nm_dokter;
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				$data['bed'] = 'Rawat Jalan';
				$data['kelas_pasien'] = 'II';
			} else if (substr($no_register, 0, 2) == "RI") {
				// $data['waktu_masuk_rad']='';
				$data['dokter_rujuk'] = $this->radmdaftar->get_dokter_pengirim_ri($no_register)->row()->dokter;
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$data['nama_diagnosa'] = $this->radmdaftar->get_nama_diagnosa($id_icd)->row()->nm_diagnosa;
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
		}

		$get_no_lab = $this->radmdaftar->get_no_lab_last($no_register)->row();
		if ($get_no_lab != null) {
			if ($get_no_lab->no_lab != 0) {
				$data['no_lab'] = $get_no_lab->no_lab;
			} else {
				$data['no_lab'] = null;
			}
		} else {
			$data['no_lab'] = null;
		}

		$data['jenis_deskripsi'] = $this->radmdaftar->getdata_deskripsi_rad()->result();
		$data['dokter_rad'] = $this->radmdaftar->getdata_dokter()->result();
		//$data['get_data_edit_tindakan_rad']=$this->radmdaftar->get_data_edit_tindakan_rad($data['id_tindakan'],$data['no_rad'])->result();

		$this->load->view('rad/radvedithasil', $data);
	}

	public function simpan_hasil_db()
	{
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		//var_dump($id_pemeriksaan_rad); die();
		$no_rad = $this->input->post('no_rad');
		$no_register = $this->input->post('no_register');
		$cek_data = $this->radmdaftar->get_hasil_radiologi($id_pemeriksaan_rad)->row();

		// added -> split id_dokter nm_dokter by -
		$raw_dokter = explode('-', $this->input->post('id_dokter_1'));
		$id_dokter = $raw_dokter[0];
		$nm_dokter = $raw_dokter[1];

		$data_input = json_encode($this->input->post());
		$response = $this->clients->request(
			'POST',
			'https://192.168.115.5/service-penunjang/api/penunjang',
			[
				'json' => [
					'file' => $data_input,
					'jenis' => 'RAD',
					'tgl_input' => date("Y-m-d H:i:s"),
					'id_doc' => md5($no_register),
					'no_order' => $no_rad,
					'id_pemeriksaan' => $id_pemeriksaan_rad
				]
			]
		)->getBody()->getContents();
		//var_dump($response); die();
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
		$data['id_dokter_1'] = $id_dokter;
		$data['klinikal'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('klinikal'));
		$data['saran'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('saran'));
		$data['usul'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('usul'));
		$data['hasil_1'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_1'));
		$data['btk'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('btk'));
		$data['rekam_radiologi'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('rekam_radiologi'));
		// $data['id_dokter_2']=$this->input->post('id_dokter_2');
		// $data['hasil_2']=$this->input->post('hasil_2');
		// $data['id_dokter_3']=$this->input->post('id_dokter_3');
		// $data['hasil_3']=$this->input->post('hasil_3');
		// $data['id_dokter_4']=$this->input->post('id_dokter_4');
		// $data['hasil_4']=$this->input->post('hasil_4');
		// $data['id_dokter_5']=$this->input->post('id_dokter_5');
		// $data['hasil_5']=$this->input->post('hasil_5');
		$data['hasil_pengirim'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_pengirim'));

		$data['rekam_radiologi'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('kesimpulan'));

		$data['tanggal_isi'] = date('Y-m-d H:i:s');
		// var_dump($this->input->post('hasil_pengirim'));die();

		// insert report hasil kesini kesimpulan
		// --> disini

		$report_pacs = [
			'REPORTWL_KEY' => $this->input->post('accession_number'), // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => date('YmdHis'), // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $this->input->post('accession_number'), // nomor study, diisi assessioin id 
			'PATIENT_ID' => $this->input->post('no_cm') == '-' ? substr($this->input->post('accession_number'), 0, 8) : $this->input->post('no_cm'), // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $nm_dokter, // id dokter yang membuat report
			'CREATOR_NAME' => $id_dokter, // yang membuat report
			'CREAT_DTTM' => date('Ymd'), // tgl laporan
			'DICTATOR_ID' => $nm_dokter, // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $id_dokter, // nama yang mendikter
			'DICTATE_DTTM' => date('Ymd'), // tgl mendikte
			'TRANSCRIBER_ID' => $nm_dokter, // id yang mentrascribe
			'TRANSCRIBER_NAME' => $id_dokter, // nama pentranscribe
			'TRANSCRIBE_DTTM' => date('Ymd'), // tgl transcribe
			'APPROVER_ID' => $nm_dokter, // id yg menyet=ujui
			'APPROVER_NAME' => $id_dokter, // nama yang menyetujui
			'APPROVER_DTTM' => date('Ymd'), // tgl persetujuan
			'REVISER_ID' => $nm_dokter, // id yang merevisi
			'REVISER_NAME' => $id_dokter, // nama perevisi
			'REVISER_DTTM' => date('YmdHis'), // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => $this->input->post('hasil_pengirim'), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => $this->input->post('kesimpulan') // kesimpulan
		];

		// var_dump($report_pacs);die();
		// sequence berdasarkan assesion number di digit terakhir
		$counter = substr($this->input->post('accession_number'), -1); //
		// var_dump($counter);die();
		//$this->insert_report_pacs($report_pacs,$counter);
		// die();
		// --> end disini
		// disini isi hasil ke db

		$this->radmdaftar->isi_hasil($data);

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data2['xinput'] = $user;
		$data2['xupdate'] = date('Y-m-d H:i:s');
		$data2['id_dokter'] = $id_dokter;
		$data_dokter = $this->radmdaftar->getnama_dokter($data2['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data2['nm_dokter'] = $row->nm_dokter;
		}

		$this->radmdaftar->edit_dokter_pemeriksaan_rad($no_register, $data2);

		//Upload
		$filesCount = count($_FILES['userFiles']['name']);
		for ($i = 0; $i < $filesCount; $i++) {
			// $data_rand = rand();

			$exploded = explode("/", $_FILES['userFiles']['type'][$i]);
			// $eksfile = strtolower(end($exploded));
			$ext = end(($exploded)); # extra () to prevent notice
			$date = new DateTime();

			$timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

			$fileName = str_replace(' ', '_', $no_register . "-" . $id_pemeriksaan_rad . "~" . $result . "." . $ext);
			$_FILES['userFile']['name'] = $fileName;
			$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
			$_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
			$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
			$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

			$uploadPath = './download/rad/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$uploadData[$i]['name'] = $fileName;
				// $uploadData[$i]['token'] = $data_rand;
				$uploadData[$i]['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
			} else {
				$error = $this->upload->display_errors();
				// echo $error;
			}
			// echo $fileName."<br>";
			// echo $i.'<br>';
		}


		if (!empty($uploadData)) {
			// insert tahap_1_detail
			// printf('<br><br> uploadData: '.json_encode($uploadData));
			$insert = $this->radmdaftar->insert_file_hasil($uploadData);
			$statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
			// $this->session->set_flashdata('statusMsg',$statusMsg);

			// echo $statusMsg;
			// echo json_encode($uploadData);
		} else {
			// echo "gagal";
			// echo json_encode($uploadData);
		}

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Data berhasil disimpan. </h3> 
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		// $data2['waktu_keluar_rad']=date('Y-m-d H:i:s');
		// $id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);		
		//redirect('rad/Radcpengisianhasil/daftar_hasil/'.$no_rad);
		redirect('rad/radcpengisianhasil/isi_hasil/' . $id_pemeriksaan_rad);
	}

	public function simpan_hasil()
	{
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		//var_dump($id_pemeriksaan_rad); die();
		$no_rad = $this->input->post('no_rad');
		$no_register = $this->input->post('no_register');

		// added -> split id_dokter nm_dokter by -
		$raw_dokter = explode('-', $this->input->post('id_dokter_1'));
		$id_dokter = $raw_dokter[0];
		$nm_dokter = $raw_dokter[1];

		$data_input = json_encode($this->input->post());
		// $response = $this->clients->request(
		// 	'POST',
		// 	'https://192.168.115.5/service-penunjang/api/penunjang',
		// 	[
		// 		'json' => [
		// 			'file'=>$data_input,
		// 			'jenis'=>'RAD',
		// 			'tgl_input'=>date("Y-m-d H:i:s"),
		// 			'id_doc'=>md5($no_register),
		// 			'no_order'=>$no_rad,
		// 			'id_pemeriksaan'=>$id_pemeriksaan_rad
		// 		]
		// 	]
		// )->getBody()->getContents();
		//var_dump($response); die();
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
		$data['id_dokter_1'] = $id_dokter;
		$data['klinikal'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('klinikal'));
		$data['saran'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('saran'));
		$data['usul'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('usul'));
		$data['hasil_1'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_1'));
		$data['btk'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('btk'));
		$data['rekam_radiologi'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('rekam_radiologi'));
		// $data['id_dokter_2']=$this->input->post('id_dokter_2');
		// $data['hasil_2']=$this->input->post('hasil_2');
		// $data['id_dokter_3']=$this->input->post('id_dokter_3');
		// $data['hasil_3']=$this->input->post('hasil_3');
		// $data['id_dokter_4']=$this->input->post('id_dokter_4');
		// $data['hasil_4']=$this->input->post('hasil_4');
		// $data['id_dokter_5']=$this->input->post('id_dokter_5');
		// $data['hasil_5']=$this->input->post('hasil_5');
		$data['hasil_pengirim'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_pengirim'));

		$data['rekam_radiologi'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('kesimpulan'));

		$data['tanggal_isi'] = date('Y-m-d H:i:s');
		// var_dump($this->input->post('hasil_pengirim'));die();

		// insert report hasil kesini kesimpulan
		// --> disini

		$report_pacs = [
			'REPORTWL_KEY' => $this->input->post('accession_number'), // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => date('YmdHis'), // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $this->input->post('accession_number'), // nomor study, diisi assessioin id 
			'PATIENT_ID' => $this->input->post('no_cm') == '-' ? substr($this->input->post('accession_number'), 0, 8) : $this->input->post('no_cm'), // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $nm_dokter, // id dokter yang membuat report
			'CREATOR_NAME' => $id_dokter, // yang membuat report
			'CREAT_DTTM' => date('Ymd'), // tgl laporan
			'DICTATOR_ID' => $nm_dokter, // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $id_dokter, // nama yang mendikter
			'DICTATE_DTTM' => date('Ymd'), // tgl mendikte
			'TRANSCRIBER_ID' => $nm_dokter, // id yang mentrascribe
			'TRANSCRIBER_NAME' => $id_dokter, // nama pentranscribe
			'TRANSCRIBE_DTTM' => date('Ymd'), // tgl transcribe
			'APPROVER_ID' => $nm_dokter, // id yg menyet=ujui
			'APPROVER_NAME' => $id_dokter, // nama yang menyetujui
			'APPROVER_DTTM' => date('Ymd'), // tgl persetujuan
			'REVISER_ID' => $nm_dokter, // id yang merevisi
			'REVISER_NAME' => $id_dokter, // nama perevisi
			'REVISER_DTTM' => date('YmdHis'), // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => $this->input->post('hasil_pengirim'), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => $this->input->post('kesimpulan') // kesimpulan
		];

		// var_dump($report_pacs);die();
		// sequence berdasarkan assesion number di digit terakhir
		$counter = substr($this->input->post('accession_number'), -1); //
		// var_dump($counter);die();
		//$this->insert_report_pacs($report_pacs,$counter);
		// die();
		// --> end disini
		// disini isi hasil ke db

		$this->radmdaftar->isi_hasil($data);

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data2['xinput'] = $user;
		$data2['xupdate'] = date('Y-m-d H:i:s');
		$data2['id_dokter'] = $id_dokter;
		//$data2['hasil_simpan'] = 1;
		$data_dokter = $this->radmdaftar->getnama_dokter($data2['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data2['nm_dokter'] = $row->nm_dokter;
		}

		$this->radmdaftar->edit_dokter_pemeriksaan_rad($no_register, $data2);
		$data3['hasil_simpan'] = 1;
		$this->radmdaftar->update_flag_pengisian($id_pemeriksaan_rad, $data3);
		//Upload
		$filesCount = count($_FILES['userFiles']['name']);
		for ($i = 0; $i < $filesCount; $i++) {
			// $data_rand = rand();

			$exploded = explode("/", $_FILES['userFiles']['type'][$i]);
			// $eksfile = strtolower(end($exploded));
			$ext = end(($exploded)); # extra () to prevent notice
			$date = new DateTime();

			$timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

			$fileName = str_replace(' ', '_', $no_register . "-" . $id_pemeriksaan_rad . "-" . $result . "." . $ext);
			$_FILES['userFile']['name'] = $fileName;
			$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
			$_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
			$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
			$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

			$uploadPath = './download/rad/';
			$config['upload_path'] = $uploadPath;
			$allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png");
			if (!in_array($_FILES['userFile']['type'], $allowed)) {
				$error_message = 'Only jpg, gif, and png files are allowed.';

				echo $error_message;

				exit();
			}
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$uploadData[$i]['name'] = $fileName;
				// $uploadData[$i]['token'] = $data_rand;
				$uploadData[$i]['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
			} else {
				$error = $this->upload->display_errors();
				// echo $error;
			}
			// echo $fileName."<br>";
			// echo $i.'<br>';
		}

		//var_dump($uploadData); die();
		if (!empty($uploadData)) {
			// insert tahap_1_detail
			// printf('<br><br> uploadData: '.json_encode($uploadData));
			$insert = $this->radmdaftar->insert_file_hasil($uploadData);
			$statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
			// $this->session->set_flashdata('statusMsg',$statusMsg);

			// echo $statusMsg;
			// echo json_encode($uploadData);
		} else {
			// echo "gagal";
			// echo json_encode($uploadData);
		}

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Data berhasil disimpan. </h3> 
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		// $data2['waktu_keluar_rad']=date('Y-m-d H:i:s');
		// $id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);		
		//redirect('rad/Radcpengisianhasil/daftar_hasil/'.$no_rad);
		redirect('rad/radcpengisianhasil/daftar_hasil/' . $no_rad);
	}

	public function update_hasil()
	{
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		$no_register = $this->input->post('no_register');
		$no_rad = $this->input->post('no_rad');
		$noreg = md5($no_register);
		$ket = 'RAD';
		// $data_input = json_encode($this->input->post());
		// 		$response = $this->clients->request(
		// 			'PUT',
		// 			'https://192.168.115.5/service-penunjang/api/penunjang/'.$id_pemeriksaan_rad.'/'.$no_rad.'/'.$noreg.'/'.$ket,
		// 			[
		// 				'json' => [
		// 					'file'=>$data_input,
		// 					'tgl_input'=>date("Y-m-d H:i:s")
		// 				]
		// 			]
		// 		)->getBody()->getContents();
		//Upload data
		$filesCount = count($_FILES['userFiles']['name']);
		for ($i = 0; $i < $filesCount; $i++) {
			// $data_rand = rand();
			$exploded = explode("/", $_FILES['userFiles']['type'][$i]);
			// $eksfile = strtolower(end($exploded));
			$ext = end(($exploded)); # extra () to prevent notice
			// $ext = end((explode("/", $_FILES['userFiles']['type'][$i]))); # extra () to prevent notice
			// echo $ext;
			$date = new DateTime();

			$timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

			$fileName = str_replace(' ', '_', $no_register . "-" . $id_pemeriksaan_rad . "-" . $result . "." . $ext);
			$_FILES['userFile']['name'] = $fileName;
			$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
			$_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
			$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
			$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

			$uploadPath = './download/rad/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$uploadData[$i]['name'] = $fileName;
				// $uploadData[$i]['token'] = $data_rand;
				$uploadData[$i]['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
			} else {
				$error = $this->upload->display_errors();
				// echo $error;
			}
			// echo $fileName."<br>";
			// echo $i.'<br>';
		}


		if (!empty($uploadData)) {
			// insert tahap_1_detail
			// printf('<br><br> uploadData: '.json_encode($uploadData));
			$insert = $this->radmdaftar->insert_file_hasil($uploadData);
			$statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
			$this->session->set_flashdata('statusMsg', $statusMsg);

			// echo $statusMsg;
			// echo json_encode($uploadData);
		} else {
			// echo "gagal";
			// echo json_encode($uploadData);
		}
		//Upload data

		//UPDATE DATA
		//
		$data['id_dokter_1'] = $this->input->post('id_dokter_1');
		$data['klinikal'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('klinikal'));
		$data['saran'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('saran'));
		$data['usul'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('usul'));
		$data['hasil_1'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_1'));
		$data['btk'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('btk'));
		$data['rekam_radiologi'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('kesimpulan'));
		// $data['id_dokter_2']=$this->input->post('id_dokter_2');
		// $data['hasil_2']=$this->input->post('hasil_2');
		// $data['id_dokter_3']=$this->input->post('id_dokter_3');
		// $data['hasil_3']=$this->input->post('hasil_3');
		// $data['id_dokter_4']=$this->input->post('id_dokter_4');
		// $data['hasil_4']=$this->input->post('hasil_4');
		// $data['id_dokter_5']=$this->input->post('id_dokter_5');
		// $data['hasil_5']=$this->input->post('hasil_5');
		$data['hasil_pengirim'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('hasil_pengirim'));
		// $this->radmdaftar->isi_hasil($data);
		// $data['tanggal_isi']=date('Y-m-d H:i:s');

		$report_pacs = [
			'REPORTWL_KEY' => $this->input->post('accession_number'), // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => date('YmdHis'), // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $this->input->post('accession_number'), // nomor study, diisi assessioin id 
			'PATIENT_ID' => $this->input->post('no_cm') == '-' ? substr($this->input->post('accession_number'), 0, 8) : $this->input->post('no_cm'), // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $nm_dokter, // id dokter yang membuat report
			'CREATOR_NAME' => $id_dokter, // yang membuat report
			'CREAT_DTTM' => date('Ymd'), // tgl laporan
			'DICTATOR_ID' => $nm_dokter, // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $id_dokter, // nama yang mendikter
			'DICTATE_DTTM' => date('Ymd'), // tgl mendikte
			'TRANSCRIBER_ID' => $nm_dokter, // id yang mentrascribe
			'TRANSCRIBER_NAME' => $id_dokter, // nama pentranscribe
			'TRANSCRIBE_DTTM' => date('Ymd'), // tgl transcribe
			'APPROVER_ID' => $nm_dokter, // id yg menyet=ujui
			'APPROVER_NAME' => $id_dokter, // nama yang menyetujui
			'APPROVER_DTTM' => date('Ymd'), // tgl persetujuan
			'REVISER_ID' => $nm_dokter, // id yang merevisi
			'REVISER_NAME' => $id_dokter, // nama perevisi
			'REVISER_DTTM' => date('YmdHis'), // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => $this->input->post('hasil_pengirim'), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => $this->input->post('kesimpulan') // kesimpulan
		];

		// var_dump($report_pacs);die();
		// sequence berdasarkan assesion number di digit terakhir
		$counter = substr($this->input->post('accession_number'), -1); //
		// var_dump($counter);die();
		$this->insert_report_pacs($report_pacs, $counter);
		//end
		$this->radmdaftar->update_hasil($id_pemeriksaan_rad, $data);

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data2['xinput'] = $user;
		$data2['xupdate'] = date('Y-m-d H:i:s');
		$data2['id_dokter'] = $this->input->post('id_dokter_1');
		$data_dokter = $this->radmdaftar->getnama_dokter($data2['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data2['nm_dokter'] = $row->nm_dokter;
		}

		$this->radmdaftar->edit_dokter_pemeriksaan_rad($no_register, $data2);


		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Data berhasil disimpan. </h3> 
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('rad/Radcpengisianhasil/daftar_hasil/' . $no_rad);
	}

	public function edit_hasil_submit()
	{
		$no_register = $this->input->post('no_register');
		$no_rad = $this->input->post('no_rad');
		$itot = $this->input->post('itot');
		for ($i = 1; $i <= $itot; $i++) {
			$id_hasil_pemeriksaan = $this->input->post('id_hasil_pemeriksaan_' . $i);
			$hasil_rad = $this->input->post('hasil_rad_' . $i);

			$this->radmdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_rad);
		}

		redirect('rad/radcpengisianhasil/daftar_hasil/' . $no_rad);
	}

	public function st_cetak_hasil_rad_old()
	{
		$no_rad = $this->input->post('no_rad');
		$data_pasien = $this->radmkwitansi->get_data_pasien($no_rad)->row();

		if ($no_rad != '') {

			$this->radmdaftar->update_status_cetak_hasil($no_rad);
			// echo '<script type="text/javascript">window.open("'.site_url("rad/radcpengisianhasil/cetak_hasil_rad/$no_rad").'", "_blank");window.focus()</script>';

			redirect('rad/radcpengisianhasil/');
		} else {
			redirect('rad/radcpengisianhasil/', 'refresh');
		}
	}

	public function st_cetak_hasil_rad($id_pemeriksaan, $no_rad)
	{
		if ($id_pemeriksaan != '') {
			$this->radmdaftar->update_status_cetak_hasil($id_pemeriksaan);
			redirect('rad/radcpengisianhasil/daftar_hasil/' . $no_rad);
		} else {
			redirect('rad/radcpengisianhasil/', 'refresh');
		}
	}

	public function st_cetak_hasil_rad_rawat()
	{
		$no_rad = $this->input->post('no_rad');
		$data_pasien = $this->radmkwitansi->get_data_pasien($no_rad)->row();

		if ($no_rad != '') {

			$this->radmdaftar->update_status_cetak_hasil($no_rad);
			echo '<script type="text/javascript">window.open("' . site_url("rad/radcpengisianhasil/cetak_hasil_rad/$no_rad") . '", "_blank");window.history.back()</script>';

			//redirect('rad/radcpengisianhasil/','refresh');
		} else {
			//redirect('rad/radcpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_rad($no_rad = '')
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

			// echo '<pre>';
			// var_dump($data['data_hasil_rad2']);
			// echo '</pre>';
			// die();
			foreach ($data['data_hasil_rad2'] as $key) {
				$id_rad = isset($key->id_pemeriksaan_rad) ? $key->id_pemeriksaan_rad : null;
				$gambar_hasil_rad = $this->radmdaftar->get_gambar_hasil_rad($id_rad)->result();
				array_push($data['resultGambar'], $this->radmdaftar->get_gambar_hasil_rad($id_rad)->result());
				// $gambar_hasil_rad=$this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
				// array_push($data['resultGambar'],$this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result());
				//$data['gambar_hasil_rad']=$this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
				$jenis_tindakan = $key->jenis_tindakan;
				$hasil_pengirim = $key->hasil_pengirim;
				foreach ($gambar_hasil_rad as $gambar) {
					$path = str_replace('https', 'http', base_url() . 'download/rad/' . $gambar->name);
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$dt = file_get_contents($path);
					$tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
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
				$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
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
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
					$data['isi_qr'] = $isi;
				} else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
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
			$logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
				->setResizeToWidth(40);

			// Create generic label
			$label = Label::create('')
				->setTextColor(new Color(255, 0, 0));

			$result = $writer->write($qrCode, $logo, $label);

			// // Directly output the QR code
			$hasil =  $result->getDataUri();
			$data['qr'] = $hasil;
			//$data = (string)$data;
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('rad/paper_css/cetk_hasil_rad_all', $data, true);
			// // $this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			//$this->load->view('paper_css/cetk_hasil_rad_all',$data);

		} else {
		}
	}

	public function cetak_hasil_rad_backup($no_rad = '')
	{
		error_reporting(~E_ALL);
		if ($no_rad != '') {
			$no_register = $this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
			$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$kota_header = $this->appconfig->get_kota_pdfconfig()->value;


			$data_hasil_rad = $this->radmdaftar->get_data_hasil_rad($no_rad)->result();
			$data_hasil_rad2 = $this->radmdaftar->get_data_hasil_rad($no_rad)->result();


			// $header_page = $top_header."<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\">".$bottom_header;
			$header_page = $top_header . "<p align=\"center\">
											<img src=\"assets/img/" . $logo_kesehatan_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>
									</td>
									<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
										<font style=\"font-size:12px\">
											<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
										</font>
										<font style=\"font-size:11px\">
											<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
											<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
										</font>    
										<br>
										<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
										<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
									</td>
									<td width=\"13%\">
										<p align=\"center\">
											<img src=\"assets/img/" . $logo_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>" . $bottom_header;
			$header = "
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page
					<hr><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN RADIOLOGI
					</b></p><br/>";

			$nohptelp = "";
			$almt = "";
			if (substr($no_register, 0, 2) == "PL") {
				$data_pasien = $this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
				$header = $header .
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Diagnostik</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Rad</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien = $this->radmdaftar->get_data_pasien_cetak($no_rad)->row();
				if ($data_pasien->sex == "L") {
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt . "$data_pasien->alamat ";
				if ($data_pasien->rt != "") {
					$almt = $almt . "RT. $data_pasien->rt ";
				}
				if ($data_pasien->rw != "") {
					$almt = $almt . "RW. $data_pasien->rw ";
				}
				if ($data_pasien->kelurahandesa != "") {
					$almt = $almt . "$data_pasien->kelurahandesa ";
				}
				if ($data_pasien->kecamatan != "") {
					$almt = $almt . "$data_pasien->kecamatan ";
				}
				if ($data_pasien->kotakabupaten != "") {
					$almt = $almt . "<br>$data_pasien->kotakabupaten ";
				}

				if (($data_pasien->no_telp != "") && ($data_pasien->no_hp != "")) {
					$nohptelp = $nohptelp . "$data_pasien->no_telp / $data_pasien->no_hp";
				} else if ($data_pasien->no_telp != "") {
					$nohptelp = $nohptelp . "$data_pasien->no_telp";
				} else if ($data_pasien->no_hp != "") {
					$nohptelp = $nohptelp . "$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp . "-";
				}

				$get_umur = $this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
				$tahun = 0;
				$bulan = 0;
				$hari = 0;
				foreach ($get_umur as $row) {
					// echo $row->umurday;
					$tahun = $row->umurday;
					// $bulan=floor(($row->umurday - ($tahun*365))/30);
					// $hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				// $nm_poli=$this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if ($data_pasien->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar = "$a->a - $a->b";
				} else {
					$cara_bayar = $data_pasien->cara_bayar;
				}
				if (substr($no_register, 0, 2) == "RJ") {
					$nama_dokter = $this->radmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				} else if (substr($no_register, 0, 2) == "RI") {
					$nama_dokter = $this->radmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - ' . $data_pasien->idrg;
					// $lokasi = $nm_poli;
				} else {
					$lokasi = 'Pasien Langsung';
				}

				$header = $header .
					"<table border=\"0\">
						<tr>
							<td width=\"15%\">No. Diag</td>
							<td width=\"2%\"> : </td>
							<td width=\"25%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td>" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td >Status</td>
							<td> : </td>
							<td >$cara_bayar</td>
							<td>Alamat</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$almt</td>
						</tr>
						<tr>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"3\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}

			$header = $header . "
					<style type=\"text/css\">
					.table-isi{
						    padding:2px 5px;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    font-size:9dp;
						}
					</style>
					
						";

			// foreach($data_hasil_rad as $row){
			// 	$body=$body."<tr>
			// 			  	<th>$row->jenis_tindakan</th>
			// 			  	<td>
			// 					<p align=\"left\">$row->hasil_periksa</p>
			// 			  	</td>
			// 			</tr>";
			// }

			$footer = "
					";


			$dokter_1 = "";
			foreach ($data_hasil_rad as $row) {
				if ($row->id_dokter_1 != "") {
					$dokter_1 = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
				} else {
					$dokter_1 = "";
				}
			}
			$body = "
						<table class=\"table-isi\">";
			foreach ($data_hasil_rad2 as $key) {
				$gambar_hasil_rad = $this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();




				$body = $body . "	
						<tr>
							<th colspan=\"2\"><p align=\"left\">
								<b>Jenis Pemeriksaan : $key->jenis_tindakan</b></p>								
							</th>
						</tr>";
				foreach ($gambar_hasil_rad as $gambar) {
					$body = $body . "
						<tr>
							<td width=\"16%\">
								<p>Gambar Hasil Pemeriksaan : </p>
							</td>
							<td width=\"84%\">
								<img src=\"download/rad/" . $gambar->name . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
							</td>
						</tr>";
				}
				$body = $body . "
						<tr>
						  	<td width=\"16%\" align=\"right\">
							  Dokter 1 :<br>
							  Klinikal :<br>
							  Saran :<br>
							  Usul :<br>
							  Hasil :<br>
							  Btk :<br>
							  Rekam Radiologi :
							</td>
						  	<td width=\"84%\">
								<p align=\"left\">
									$dokter_1<br>
									$key->klinikal<br>
									$key->saran<br>
									$key->usul<br>
									$key->hasil_1<br>
									$key->btk<br>
									$key->rekam_radiologi
								</p>
						  	</td>
						</tr>
					
						<tr>
						  	<td align=\"right\">Dokter Pengirim :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$nama_dokter<br>$key->hasil_pengirim</p>
						  	</td>
						</tr>";
			}

			$body = $body . "
					</table>
					
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
					<br/>
								$kota_header, $tgl	
								<br>Dokter Pembaca							
								
								<br><br><br>$dokter_1
								</p>
							</td>
						</tr>	
					</table>";



			$file_name = "Hasil_Rad_$no_rad.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('5', '5', '5');
			$obj_pdf->SetAutoPageBreak(TRUE, '5');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $header . $body . $footer;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			// $obj_pdf->AddPage();
			// ob_start();
			// 	$content = $header.$body.$footer;
			// ob_end_clean();
			// $obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/rad/radpengisianhasil/' . $file_name, 'FI');
		} else {
			redirect('rad/radcpengisianhasil/', 'refresh');
		}
	}

	public function cetak_hasil_rad_tindakan($id_pemeriksaan_rad = '', $no_rad = '')
	{
		if ($id_pemeriksaan_rad != '') {
			$data['no_rad'] = $no_rad;

			$data['no_register'] = $this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
			$no_register = $data['no_register'];

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

			$data['data_hasil_rad'] = $this->radmdaftar->get_data_hasil_rad_pertindakan($id_pemeriksaan_rad)->result();

			if (substr($no_register, 0, 2) == "PL") {
				$data['data_pasien'] = $this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
				$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
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

				$get_umur = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
				$tahun = 0;
				$bulan = 0;
				$hari = 0;
				foreach ($get_umur as $row) {
					$data['tahun'] = $row->umurday;
				}

				if ($data['data_pasien']->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data['data_pasien']->no_register)->row();
					$data['cara_bayar'] = "$a->a - $a->b";
				} else {
					$data['cara_bayar'] = $data['data_pasien']->cara_bayar;
				}
				if (substr($no_register, 0, 2) == 'RJ') {
					$data['nama_dokter'] = $this->radmdaftar->getnm_dokter_rj($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = $data['data_pasien']->idrg;
				} else if (substr($no_register, 0, 2) == 'RI') {
					$data['nama_dokter'] = $this->radmdaftar->getnm_dokter_ri($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
				} else {
					$data['lokasi'] = 'Pasien Langsung';
				}

				$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($no_register) . "" . md5($no_rad) . " || Cek Validasi di www.doc.rsomh.co.id";
			}

			foreach ($data['data_hasil_rad'] as $row) {
				if (!empty($row->id_dokter_1)) {
					$data['dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
					$data['id_dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->id_dokter;
				} else {
					$data['dokter_1'] = "";
					$data['id_dokter_1'] = "";
				}
			}

			$data['tgl'] = date("d-m-Y");

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
			// 	->setResizeToWidth(40);

			// // Create generic label
			// $label = Label::create('')
			// 	->setTextColor(new Color(255, 0, 0));

			// $result = $writer->write($qrCode, $logo, $label);

			// // Directly output the QR code
			// $hasil =  $result->getDataUri();
			$data['qr'] = '';

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('rad/paper_css/hasil_pertindakan', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		} else {
		}
	}

	public function cetak_hasil_rad_pertindakan($id_pemeriksaan_rad = '', $no_rad = '')
	{
		if ($id_pemeriksaan_rad != '') {

			$data['no_rad'] = $no_rad;

			$data['no_register'] = $this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
			$no_register = $data['no_register'];

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
			$data['data_hasil_rad'] = $this->radmdaftar->get_data_hasil_rad_pertindakan($id_pemeriksaan_rad)->result();

			if (substr($no_register, 0, 2) == "PL") {
				$data['data_pasien'] = $this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
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

				// if(($data['data_pasien']->no_telp!="") && ($data['data_pasien']->no_hp!="")){
				// 	$nohptelp = $nohptelp.$data['data_pasien']->no_telp / $data['data_pasien']->no_hp;
				// } else if($data['data_pasien']->no_telp!=""){
				// 	$nohptelp = $nohptelp.$data['data_pasien']->no_telp;
				// } else if($data['data_pasien']->no_hp!=""){
				// 	$nohptelp = $nohptelp.$data['data_pasien']->no_hp;
				// } else {
				// 	$nohptelp = "-";
				// }

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
				if (substr($no_register, 0, 2) == 'RJ') {
					$data['nama_dokter'] = $this->radmdaftar->getnm_dokter_rj($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = $data['data_pasien']->idrg;
				} else if (substr($no_register, 0, 2) == 'RI') {
					$data['nama_dokter'] = $this->radmdaftar->getnm_dokter_ri($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
					// $lokasi = $nm_poli;
				} else {
					$data['lokasi'] = 'Pasien Langsung';
				}
			}

			foreach ($data['data_hasil_rad'] as $row) {
				if (!empty($row->id_dokter_1)) {
					$data['dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
					$data['id_dokter_1'] = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->id_dokter;
				} else {
					$data['dokter_1'] = "";
					$data['id_dokter_1'] = "";
				}
			}
			$data['tgl'] = date("d-m-Y");
			//  $data['gambar_hasil_rad']=$this->radmdaftar->get_gambar_hasil_rad($row->id_pemeriksaan_rad)->row()->name;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('rad/paper_css/hasil_pengisian_rad', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/hasil_pengisian_rad',$data);
		} else {
		}
	}


	public function cetak_hasil_rad_pertindakan_backup($id_pemeriksaan_rad = '', $no_rad = '')
	{

		error_reporting(~E_ALL);
		if ($id_pemeriksaan_rad != '') {
			$no_register = $this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
			$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$kota_header = $this->appconfig->get_kota_pdfconfig()->value;

			$data_hasil_rad = $this->radmdaftar->get_data_hasil_rad_pertindakan($id_pemeriksaan_rad)->result();

			$header_page = $top_header . "<p align=\"center\">
											<img src=\"assets/img/" . $logo_kesehatan_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>
									</td>
									<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
										<font style=\"font-size:12px\">
											<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
										</font>
										<font style=\"font-size:11px\">
											<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
											<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
										</font>    
										<br>
										<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
										<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
									</td>
									<td width=\"13%\">
										<p align=\"center\">
											<img src=\"assets/img/" . $logo_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>" . $bottom_header;
			$header = "
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page

					<hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN RADIOLOGI
					</b></p><br/>";

			$nohptelp = "";
			$almt = "";
			if (substr($no_register, 0, 2) == "PL") {
				$data_pasien = $this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
				$header = $header .
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Diagnostik</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Rad</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien = $this->radmdaftar->get_data_pasien_cetak($no_rad)->row();
				if ($data_pasien->sex == "L") {
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt . "$data_pasien->alamat ";
				if ($data_pasien->rt != "") {
					$almt = $almt . "RT. $data_pasien->rt ";
				}
				if ($data_pasien->rw != "") {
					$almt = $almt . "RW. $data_pasien->rw ";
				}
				if ($data_pasien->kelurahandesa != "") {
					$almt = $almt . "$data_pasien->kelurahandesa ";
				}
				if ($data_pasien->kecamatan != "") {
					$almt = $almt . "$data_pasien->kecamatan ";
				}
				if ($data_pasien->kotakabupaten != "") {
					$almt = $almt . "<br>$data_pasien->kotakabupaten ";
				}

				if (($data_pasien->no_telp != "") && ($data_pasien->no_hp != "")) {
					$nohptelp = $nohptelp . "$data_pasien->no_telp / $data_pasien->no_hp";
				} else if ($data_pasien->no_telp != "") {
					$nohptelp = $nohptelp . "$data_pasien->no_telp";
				} else if ($data_pasien->no_hp != "") {
					$nohptelp = $nohptelp . "$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp . "-";
				}

				$get_umur = $this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
				$tahun = 0;
				$bulan = 0;
				$hari = 0;
				foreach ($get_umur as $row) {
					// echo $row->umurday;
					$tahun = $row->umurday;
					// $bulan=floor(($row->umurday - ($tahun*365))/30);
					// $hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				// $nm_poli=$this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if ($data_pasien->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar = "$a->a - $a->b";
				} else {
					$cara_bayar = $data_pasien->cara_bayar;
				}
				if (substr($no_register, 0, 2) == 'RJ') {
					$nama_dokter = $this->radmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				} else if (substr($no_register, 0, 2) == 'RI') {
					$nama_dokter = $this->radmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - ' . $data_pasien->idrg;
					// $lokasi = $nm_poli;
				} else {
					$lokasi = 'Pasien Langsung';
				}

				$header = $header .
					"<table border=\"0\">
						<tr>
							<td width=\"15%\">No. Diag</td>
							<td width=\"2%\"> : </td>
							<td width=\"25%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td>" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td >Status</td>
							<td> : </td>
							<td >$cara_bayar</td>
							<td>Alamat</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$almt</td>
						</tr>
						<tr>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"3\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}

			$header = $header . "
					<style type=\"text/css\">
					.table-isi{
						    padding:2px 5px;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    font-size:9dp;
						}
					</style>
					<table class=\"table-isi\">
						";

			// foreach($data_hasil_rad as $row){
			// 	$body=$body."<tr>
			// 			  	<th>$row->jenis_tindakan</th>
			// 			  	<td>
			// 					<p align=\"left\">$row->hasil_periksa</p>
			// 			  	</td>
			// 			</tr>";
			// }

			$footer = "
					";

			$file_name = "Hasil_Rad_Tind_" . $id_pemeriksaan_rad . ".pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('5', '5', '5');
			$obj_pdf->SetAutoPageBreak(TRUE, '5');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);

			foreach ($data_hasil_rad as $row) {
				if (!empty($row->id_dokter_1))
					$dokter_1 = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
				else
					$dokter_1 = "";
				if (!empty($row->id_dokter_2))
					$dokter_2 = $this->radmdaftar->getnama_dokter($row->id_dokter_2)->row()->nm_dokter;
				else
					$dokter_2 = "";
				if (!empty($row->id_dokter_3))
					$dokter_3 = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
				else
					$dokter_3 = "";
				if (!empty($row->id_dokter_4))
					$dokter_4 = $this->radmdaftar->getnama_dokter($row->id_dokter_4)->row()->nm_dokter;
				else
					$dokter_4 = "";
				if (!empty($row->id_dokter_5))
					$dokter_5 = $this->radmdaftar->getnama_dokter($row->id_dokter_5)->row()->nm_dokter;
				else
					$dokter_5 = "";
				// $dokter_pengirim = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
				$gambar_hasil_rad = $this->radmdaftar->get_gambar_hasil_rad($row->id_pemeriksaan_rad)->row()->name;
				$body = "
						<tr>
							<th colspan=\"2\"><p align=\"left\"><b>Jenis Pemeriksaan : $row->jenis_tindakan</b></p></th>
						</tr>";
				if (empty($gambar_hasil_rad)) {
				} else {
					$body = $body . "
						<tr>
							<td width=\"16%\">
								<p>Gambar Hasil Pemeriksaan : </p>
							</td>
							<td width=\"84%\">
								<img src=\"download/rad/" . $gambar_hasil_rad . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
							</td>
						</tr>";
				}

				$body = $body . "
						<tr>
						  	<td width=\"16%\" align=\"right\">
							  Dokter 1 :<br>
							  Klinikal :<br>
							  Saran :<br>
							  Usul :<br>
							  Hasil :<br>
							  Btk :<br>
							  Rekam Radiologi :
							</td>
						  	<td width=\"84%\">
								<p align=\"left\">
									$dokter_1<br>
									$row->klinikal<br>
									$row->saran<br>
									$row->usul<br>
									$row->hasil_1<br>
									$row->btk<br>
									$row->rekam_radiologi<br>
								</p>
						  	</td>
						</tr>";
				// if($dokter_2!=""){
				// 	$body.="
				// 	<tr>
				// 	  	<td align=\"right\">Dokter 2 :<br>Hasil :</td>
				// 	  	<td>
				// 			<p align=\"left\">$dokter_2<br>$row->hasil_2</p>
				// 	  	</td>
				// 	</tr>";
				// }
				// if($dokter_3!=""){
				// 	$body.="
				// 	<tr>
				// 	  	<td align=\"right\">Dokter 3 :<br>Hasil :</td>
				// 	  	<td>
				// 			<p align=\"left\">$dokter_3<br>$row->hasil_3</p>
				// 	  	</td>
				// 	</tr>";
				// }
				// if($dokter_4!=""){
				// 	$body.="
				// 	<tr>
				// 	  	<td align=\"right\">Dokter 4 :<br>Hasil :</td>
				// 	  	<td>
				// 			<p align=\"left\">$dokter_4<br>$row->hasil_4</p>
				// 	  	</td>
				// 	</tr>";
				// }
				// if($dokter_5!=""){
				// 	$body.="
				// 	<tr>
				// 	  	<td align=\"right\">Dokter 5 :<br>Hasil :</td>
				// 	  	<td>
				// 			<p align=\"left\">$dokter_5<br>$row->hasil_5</p>
				// 	  	</td>
				// 	</tr>";
				// }
				$body .= "
						<tr>
						  	<td align=\"right\">Dokter Pengirim :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$nama_dokter<br>$row->hasil_pengirim</p>
						  	</td>
						</tr>
					</table>
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
					<br/>
								$kota_header, $tgl	
								<br>Dokter Pembaca							
								
								<br><br><br>$dokter_1
								</p>
							</td>
						</tr>	
					</table>";

				$obj_pdf->AddPage();
				ob_start();
				$content = $header . $body . $footer;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
			}

			// $obj_pdf->AddPage();
			// ob_start();
			// 	$content = $header.$body.$footer;
			// ob_end_clean();
			// $obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/rad/radpengisianhasil/' . $file_name, 'FI');
		} else {
			redirect('rad/radcpengisianhasil/', 'refresh');
		}
	}
	public function download($data)
	{
		// $fileName = $data;
		//$file_path = 'upload/radgambarhasil/' . $fileName;
		//$this->_push_file($file_path, $fileName);
		//$image_name = "mypic.jpg";
		$image_path = $this->config->item('base_url') . "upload/radgambarhasil/$data";
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$data");
		ob_clean();
		flush();
		readfile($image_path);
	}

	function _push_file($path, $name)
	{
		$this->load->helper('download');
		// make sure it's a file before doing anything!
		if (is_file($path)) {
			// required for IE
			if (ini_get('zlib.output_compression')) {
				ini_set('zlib.output_compression', 'Off');
			}

			// get the file mime type using the file extension
			$this->load->helper('download');
			$mime = get_mime_by_extension($path);
			// Build the headers to push out the file properly.
			header('Pragma: public');     // required
			header('Expires: 0');         // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
			header('Cache-Control: private', false);
			header('Content-Type: jpeg|jpg');  // Add the mime type from Code igniter.
			header('Content-Disposition: attachment; filename="' . basename($name) . '"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); // push it out
			exit();
		} else {
			echo "<script language=\"javascript\">alert('Kosong');</script>";
		}
	}

	public function insert_report_pacs($result, $count)
	{
		$obr = [
			'REPORTWL_KEY' => $result['REPORTWL_KEY'], // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => $result['TRIGGER_DTTM'], // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $result['EXAM_ID'], // nomor study, diisi assessioin id 
			'PATIENT_ID' => $result['PATIENT_ID'], // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $result['CREATOR_ID'], // id dokter yang membuat report
			'CREATOR_NAME' => $result['CREATOR_NAME'], // yang membuat report
			'CREAT_DTTM' => $result['CREAT_DTTM'], // tgl laporan
			'DICTATOR_ID' => $result['DICTATOR_ID'], // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $result['DICTATOR_NAME'], // nama yang mendikter
			'DICTATE_DTTM' => $result['DICTATE_DTTM'], // tgl mendikte
			'TRANSCRIBER_ID' => $result['TRANSCRIBER_ID'], // id yang mentrascribe
			'TRANSCRIBER_NAME' => $result['TRANSCRIBER_NAME'], // nama pentranscribe
			'TRANSCRIBE_DTTM' => $result['TRANSCRIBE_DTTM'], // tgl transcribe
			'APPROVER_ID' => $result['APPROVER_ID'], // id yg menyet=ujui
			'APPROVER_NAME' => $result['APPROVER_NAME'], // nama yang menyetujui
			'APPROVER_DTTM' => $result['APPROVER_DTTM'], // tgl persetujuan
			'REVISER_ID' => $result['REVISER_ID'], // id yang merevisi
			'REVISER_NAME' => $result['REVISER_NAME'], // nama perevisi
			'REVISER_DTTM' => $result['REVISER_DTTM'], // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => str_replace(PHP_EOL, '~', $result['REPORT_TEXT']), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => str_replace(PHP_EOL, '~', $result['CONCLUSION']) // kesimpulan
		];
		$str = implode('|', $obr);
		// echo $str; 
		// echo '<br><br><br>';
		// echo $result['PATIENT_ID'] . $count;
		// return;
		if (!file_put_contents('c:\\WinNMP\pacs_report\\' . $result['PATIENT_ID'] . $count . '.txt', $str)) {
			//if(!file_put_contents('c:\\xampp\htdocs\simrs_rsomh_v2\\'.$result['PATIENT_ID'].$count.'.txt', $str)){
			// echo 'gagal disimpan';

		} else {
			file_put_contents('C:\WinNMP\LOCAL_PACS\report_pacs\\' . $result['PATIENT_ID'] . $count . '.txt', $str);
			//file_put_contents('C:\xampp\htdocs\simrs_rsomh_v2\\'.$result['PATIENT_ID'].$count.'.txt', $str);
			// echo 'sukses';
		}
	}
	public function get_deskripsi_rad_detail()
	{
		$id = $this->input->post('value');
		$jenis = $this->radmdaftar->getdata_deskripsi_rad_detail($id)->row();
		echo json_encode(array('jenis' => $jenis->isi));
	}

	public function sendpacs()
	{
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		//$data['hasil_pacs'] = 1;
		$query = $this->radmdaftar->update_flag_pacs($id_pemeriksaan_rad);
		//var_dump($query); die();
		//var_dump($id_pemeriksaan_rad); die();
		$raw_dokter = explode('-', $this->input->post('id_dokter_1'));
		$id_dokter = $raw_dokter[0];
		$nm_dokter = $raw_dokter[1];

		$report_pacs = [
			'REPORTWL_KEY' => $this->input->post('accession_number'), // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => date('YmdHis'), // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $this->input->post('accession_number'), // nomor study, diisi assessioin id 
			'PATIENT_ID' => $this->input->post('no_cm') == '-' ? substr($this->input->post('accession_number'), 0, 8) : $this->input->post('no_cm'), // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $nm_dokter, // id dokter yang membuat report
			'CREATOR_NAME' => $id_dokter, // yang membuat report
			'CREAT_DTTM' => date('Ymd'), // tgl laporan
			'DICTATOR_ID' => $nm_dokter, // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $id_dokter, // nama yang mendikter
			'DICTATE_DTTM' => date('Ymd'), // tgl mendikte
			'TRANSCRIBER_ID' => $nm_dokter, // id yang mentrascribe
			'TRANSCRIBER_NAME' => $id_dokter, // nama pentranscribe
			'TRANSCRIBE_DTTM' => date('Ymd'), // tgl transcribe
			'APPROVER_ID' => $nm_dokter, // id yg menyet=ujui
			'APPROVER_NAME' => $id_dokter, // nama yang menyetujui
			'APPROVER_DTTM' => date('Ymd'), // tgl persetujuan
			'REVISER_ID' => $nm_dokter, // id yang merevisi
			'REVISER_NAME' => $id_dokter, // nama perevisi
			'REVISER_DTTM' => date('YmdHis'), // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => $this->input->post('hasil_pengirim'), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => $this->input->post('kesimpulan') // kesimpulan
		];

		// var_dump($report_pacs);die();
		// sequence berdasarkan assesion number di digit terakhir
		$counter = substr($this->input->post('accession_number'), -1); //
		// var_dump($counter);die();
		$this->insert_report_pacs($report_pacs, $counter);
		// die();
		// --> end disini
		// disini isi hasil ke db

	}

	public function sendpacs_luar()
	{
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		//$data['hasil_pacs'] = 1;
		$query = $this->radmdaftar->update_flag_pacs($id_pemeriksaan_rad);
		//var_dump($query); die();
		//var_dump($id_pemeriksaan_rad); die();
		//$raw_dokter = explode('-', $this->input->post('id_dokter_1'));
		$id_dokter = $this->input->post('id_dokter');
		$nm_dokter = $this->input->post('nm_dokter');

		$report_pacs = [
			'REPORTWL_KEY' => $this->input->post('accession_number'), // isi nomor uniq, bisa assession number
			'TRIGGER_DTTM' => date('YmdHis'), // datetime, format yyyymmddhhmiss
			'REPLICA_DTTM' => 'ANY',
			'EXAM_ID' => $this->input->post('accession_number'), // nomor study, diisi assessioin id 
			'PATIENT_ID' => $this->input->post('no_cm') == '-' ? substr($this->input->post('accession_number'), 0, 8) : $this->input->post('no_cm'), // no cm
			'REPORT_STAT' => '240', // Final result, jangan diganti
			'CREATOR_ID' => $nm_dokter, // id dokter yang membuat report
			'CREATOR_NAME' => $id_dokter, // yang membuat report
			'CREAT_DTTM' => date('Ymd'), // tgl laporan
			'DICTATOR_ID' => $nm_dokter, // id yang mendikte, samakan dengan creator aja
			'DICTATOR_NAME' => $id_dokter, // nama yang mendikter
			'DICTATE_DTTM' => date('Ymd'), // tgl mendikte
			'TRANSCRIBER_ID' => $nm_dokter, // id yang mentrascribe
			'TRANSCRIBER_NAME' => $id_dokter, // nama pentranscribe
			'TRANSCRIBE_DTTM' => date('Ymd'), // tgl transcribe
			'APPROVER_ID' => $nm_dokter, // id yg menyet=ujui
			'APPROVER_NAME' => $id_dokter, // nama yang menyetujui
			'APPROVER_DTTM' => date('Ymd'), // tgl persetujuan
			'REVISER_ID' => $nm_dokter, // id yang merevisi
			'REVISER_NAME' => $id_dokter, // nama perevisi
			'REVISER_DTTM' => date('YmdHis'), // tgl jam revisi
			'REPORT_TYPE' => '', // tipe laporan, kosongkan saja
			'REPORT_TEXT' => $this->input->post('hasil_pengirim'), // isi laporan, ubah CRLF menjadi ~
			'CONCLUSION' => $this->input->post('kesimpulan') // kesimpulan
		];

		// var_dump($report_pacs);die();
		// sequence berdasarkan assesion number di digit terakhir
		$counter = substr($this->input->post('accession_number'), -1); //
		// var_dump($counter);die();
		$this->insert_report_pacs($report_pacs, $counter);
	}

	public function coba_qr()
	{
		// $result = Builder::create()
		// 	->writer(new PngWriter())
		// 	->writerOptions([])
		// 	->data('Custom QR code contents')
		// 	->encoding(new Encoding('UTF-8'))
		// 	->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
		// 	->size(300)
		// 	->margin(10)
		// 	->roundBlockSizeMode(new RoundBlockSizeModeMargin())
		// 	//->logoPath(__DIR__.site_url('assets/images/logo.png'))
		// 	->logoPath(__DIR__.'/logo.png')
		// 	->setResizeToWidth(50)
		// 	->labelText('')
		// 	->labelFont(new NotoSans(20))
		// 	->labelAlignment(new LabelAlignmentCenter())
		// 	->validateResult(false)
		// 	->build();

		$writer = new PngWriter();

		// Create QR code
		$qrCode = QrCode::create('Life is too short to be generating QR codes')
			->setEncoding(new Encoding('UTF-8'))
			->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
			->setSize(300)
			->setMargin(10)
			->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
			->setForegroundColor(new Color(0, 0, 0, 25))
			->setBackgroundColor(new Color(255, 255, 255));

		// Create generic logo
		$logo = Logo::create(__DIR__ . '/logo.png')
			->setResizeToWidth(125);

		// Create generic label
		$label = Label::create('')
			->setTextColor(new Color(255, 0, 0));

		$result = $writer->write($qrCode, $logo, $label);

		// Validate the result
		// $writer->validateResult($result, 'Life is too short to be generating QR codes');

		// Directly output the QR code
		$dataUri = $result->getDataUri();
		$data['qr'] = $dataUri;

		$this->load->view('rad/paper_css/coba_qr', $data);
	}
}
