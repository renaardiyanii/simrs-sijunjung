<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// use Mpdf\QrCode\QrCode;
// use Mpdf\QrCode\Output;
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
class Emcpengisianhasil extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('elektromedik/emmdaftar', '', TRUE);
		$this->load->model('elektromedik/emmkwitansi', '', TRUE);
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

		$data['elektromedik'] = $this->emmdaftar->get_hasil_em()->result();
		$this->load->view('elektromedik/emvdaftarpengisian', $data);
	}

	public function by_date()
	{
		$date = $this->input->post('date');
		$data['title'] = 'Diagnostik Tanggal ' . date('d-m-Y', strtotime($date));

		$data['elektromedik'] = $this->emmdaftar->get_hasil_em_by_date($date)->result();
		$this->load->view('elektromedik/emvdaftarpengisian', $data);
	}

	public function by_no()
	{
		$key = $this->input->post('key');
		$data['title'] = 'Diagnostik | ' . $key;

		$data['elektromedik'] = $this->emmdaftar->get_hasil_em_by_no($key)->result();
		$this->load->view('elektromedik/emvdaftarpengisian', $data);
	}

	public function daftar_hasil($no_em = '')
	{
		$data['title'] = 'Diagnostik';
		$data['no_em'] = $no_em;
		$no_register = $this->emmdaftar->get_no_register($no_em)->row()->no_register;
		$data['no_register'] = $no_register;
		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_em)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_cm'] = '-';
				$data['no_medrec'] = '-';
				$data['kelas_pasien'] = 'III';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['nmkontraktor'] = '';
				$data['rs_perujuk'] = $row->rs_perujuk;
				// $data['waktu_masuk_em']='';
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_hasil_pemeriksaan($no_em)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;

				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_em']=$data['data_pasien_daftar_ulang']->waktu_masuk_em;
				if ($data['cara_bayar'] == 'KERJASAMA' or $data['cara_bayar'] == 'BPJS') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'NK';
			} else if (substr($no_register, 0, 2) == "RI") {
				// $data['waktu_masuk_em']='';
				$diag = $this->emmdaftar->get_data_pasien_iri($no_register)->row();
				if ($diag != null) {
					$id_icd = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					if ($id_icd != null) {
						$data['nama_diagnosa'] = $this->emmdaftar->get_nama_diagnosa($id_icd)->row()->nm_diagnosa;
					} else {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
					}
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				if ($data['cara_bayar'] == 'KERJASAMA' or $data['cara_bayar'] == 'BPJS') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
		}

		$data['daftarpengisian'] = $this->emmdaftar->get_data_pengisian_hasil($no_em)->result();

		$this->load->view('elektromedik/emvdaftarhasil', $data);
	}

	public function isi_hasil($id_pemeriksaan_em = '')
	{
		$data['title'] = 'Elektromedik';
		$data['id_pemeriksaan_em'] = $id_pemeriksaan_em;

		$nr = $this->emmdaftar->get_row_register($id_pemeriksaan_em)->result();
		foreach ($nr as $row) {
			$no_register = $row->no_register;
		}

		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_em)->result();

			$data['data_pasien_daftar_ulang'] = $this->emmdaftar->get_data_pasien_luar($no_register)->row();
			$iddokter = $data['data_pasien_daftar_ulang']->dokter;

			$data['kode_jenis'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_em)->row()->kode_jenis;
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_register'] = $no_register;
				$data['usia'] = $row->usia;
				$data['no_cm'] = '-';
				$data['no_medrec'] = '-';
				$data['kelas_pasien'] = 'III';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['jenkel'] = $row->jk;
				$data['no_em'] = $row->no_em;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['nmkontraktor'] = '';
				$data['asal'] = 'Pasien Luar';
				// $data['waktu_masuk_em']='';
			}
			// $data['dokter_em'] = array(
			// 	array(
			// 		'nm_dokter' => $iddokter,
			// 		'id_dokter' => 0
			// 	)				
			// );

			// $data['dokter_em'] = $this->rjmpelayanan->get_dokter_poli2('ME00')->result();
		} else {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_em)->result();
			$data['kode_jenis'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_em)->row()->kode_jenis;
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['alamat'] = $row->alamat;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_em'] = $row->no_em;
				$usia = date_diff(date_create($row->tgl_lahir), date_create('now'));
				$data['usia'] = $usia->y;
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
				} else {
					$data['asal'] = $row->idrg;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->row();
				$data['dokter_rujuk'] = $this->emmdaftar->get_dokter_pengirim_rj($no_register)->row()->nm_dokter;
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_em']=$data['data_pasien_daftar_ulang']->waktu_masuk_em;

				$iddokter = $data['data_pasien_daftar_ulang']->id_dokter;

				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'II';
			} else if (substr($no_register, 0, 2) == "RI") {
				// $data['waktu_masuk_em']='';
				$data['dokter_rujuk'] = $this->emmdaftar->get_dokter_pengirim_ri($no_register)->row()->dokter;
				$diag = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
				$data['data_pasien_daftar_ulang'] = $this->emmdaftar->get_data_pasien_iri($no_register)->row();

				$iddokter = $data['data_pasien_daftar_ulang']->id_dokter;

				if ($diag != null) {
					$id_icd = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$data['nama_diagnosa'] = $this->emmdaftar->get_nama_diagnosa($id_icd)->row()->nm_diagnosa;
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}

			// $data['dokter_em']=$this->emmdaftar->getdata_dokter_isi($iddokter)->result();
		}

		$data['dokter_em'] = $this->emmdaftar->getdata_dokter_all()->result();
		$data['jenis_tindakan'] = $this->emmdaftar->get_data_tindakan_em_id($id_pemeriksaan_em)->row()->jenis_tindakan;

		$this->load->view('elektromedik/emvisihasil', $data);
	}

	public function edit_hasil($id_pemeriksaan_em = '')
	{
		$data['title'] = 'Diagnostik';
		$data['id_pemeriksaan_em'] = $id_pemeriksaan_em;

		$no_register = $this->emmdaftar->get_row_register($id_pemeriksaan_em)->row()->no_register;

		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_em)->result();

			$data['data_pasien_daftar_ulang'] = $this->emmdaftar->get_data_pasien_luar($no_register)->row();
			$iddokter = $data['data_pasien_daftar_ulang']->dokter;

			$data['kode_jenis'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_em)->row()->kode_jenis;
			$data['gambar_hasil_pemeriksaan'] = $this->emmdaftar->get_gambar_hasil_em($id_pemeriksaan_em)->result();
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
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['jenkel'] = $row->jk;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_em'] = $row->no_em;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['hasil_periksa'] = $row->hasil_periksa;
				$data['hasil_dokter'] = $row->hasil_dokter;
				$data['gambar_hasil'] = $row->gambar_hasil;
				$data['nmkontraktor'] = '';
				$data['hasil'] = $row->hasil;
				$data['saran'] = $row->saran;
				$data['btk'] = $row->btk;
				$data['rekam_elektromedik'] = $row->rekam_elektromedik;
				$data['id_hasil_em'] = $row->id_hasil_em;
				$data['id_dokter_1'] = $row->id_dokter;
				$data['hasil_1'] = $row->hasil;
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				$data['ma_hasil'] = $row->ma_hasil;
				$data['mb_hasil'] = $row->mb_hasil;
				$data['mc_hasil'] = $row->mc_hasil;
				$data['md_hasil'] = $row->md_hasil;
				$data['me_hasil'] = $row->me_hasil;
				$data['mf_hasil'] = $row->mf_hasil;
				// $data['waktu_masuk_em']='';
			}
			// $data['dokter_em'] = array(
			// 	array(
			// 		'nm_dokter' => $iddokter,
			// 		'id_dokter' => 0
			// 	)				
			// );

			// $data['dokter_em'] = $this->rjmpelayanan->get_dokter_poli2('ME00')->result();
		} else {
			$data['data_pasien_pemeriksaan'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_em)->result();
			$data['kode_jenis'] = $this->emmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_em)->row()->kode_jenis;
			$data['gambar_hasil_pemeriksaan'] = $this->emmdaftar->get_gambar_hasil_em($id_pemeriksaan_em)->result();
			foreach ($data['gambar_hasil_pemeriksaan'] as $row_gambar) {
				$data['gambar_name'] = $row_gambar->name;
			}
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['alamat'] = $row->alamat;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_cm'] = $row->no_cm;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_em'] = $row->no_em;
				$data['hasil_periksa'] = $row->hasil_periksa;
				$data['hasil_dokter'] = $row->hasil_dokter;
				$data['gambar_hasil'] = $row->gambar_hasil;
				$data['id_hasil_em'] = $row->id_hasil_em;
				$data['id_dokter_1'] = $row->id_dokter;
				$data['hasil_1'] = $row->hasil;
				$data['hasil_pengirim'] = $row->hasil_pengirim;
				$data['hasil'] = $row->hasil;
				$data['saran'] = $row->saran;
				$usia = date_diff(date_create($row->tgl_lahir), date_create('now'));
				$data['usia'] = $usia->y;
				$data['btk'] = $row->btk;
				$data['rekam_elektromedik'] = $row->rekam_elektromedik;
				$data['ma_hasil'] = $row->ma_hasil;
				$data['mb_hasil'] = $row->mb_hasil;
				$data['mc_hasil'] = $row->mc_hasil;
				$data['md_hasil'] = $row->md_hasil;
				$data['me_hasil'] = $row->me_hasil;
				$data['mf_hasil'] = $row->mf_hasil;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}

				if ($row->sex == 'P') {
					$data['jenkel'] = 'Perempuan';
				} else {
					$data['jenkel'] = 'Laki Laki';
				}

				if (substr($no_register, 0, 2) == "RJ") {
					$data['asal'] = $row->bed;
				} else {
					$data['asal'] = $row->idrg;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$diag = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->row();
				$data['dokter_rujuk'] = $this->emmdaftar->get_dokter_pengirim_rj($no_register)->row()->nm_dokter;
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_em']=$data['data_pasien_daftar_ulang']->waktu_masuk_em;
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_em']=$data['data_pasien_daftar_ulang']->waktu_masuk_em;

				$iddokter = $data['data_pasien_daftar_ulang']->id_dokter;
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
				$data['bed'] = 'Rawat Jalan';
				$data['kelas_pasien'] = 'II';
			} elseif (substr($no_register, 0, 2) == "RI") {
				// $data['waktu_masuk_em']='';
				$data['dokter_rujuk'] = $this->emmdaftar->get_dokter_pengirim_ri($no_register)->row()->dokter;
				$diag = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
				$data['data_pasien_daftar_ulang'] = $this->emmdaftar->get_data_pasien_iri($no_register)->row();

				$iddokter = $data['data_pasien_daftar_ulang']->id_dokter;
				if ($diag != null) {
					$id_icd = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$data['nama_diagnosa'] = $this->emmdaftar->get_nama_diagnosa($id_icd)->row()->nm_diagnosa;
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				if ($data['cara_bayar'] == 'DIJAMIN') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
			// $data['dokter_em']=$this->emmdaftar->getdata_dokter_isi($iddokter)->result();
		}

		$data['dokter_em'] = $this->emmdaftar->getdata_dokter_all()->result();
		// $data['dokter_em']=$this->emmdaftar->getdata_dokter()->result();
		//$data['get_data_edit_tindakan_em']=$this->emmdaftar->get_data_edit_tindakan_em($data['id_tindakan'],$data['no_em'])->result();

		$this->load->view('elektromedik/emvedithasil', $data);
	}

	public function simpan_hasil()
	{
		$id_pemeriksaan_em = $this->input->post('id_pemeriksaan_em');
		$no_em = $this->input->post('no_em');
		$no_register = $this->input->post('no_register');
		$kode_jenis = $this->input->post('kode_jenis');

		$validasi_pilih_dokter = explode('-', $this->input->post('id_dokter'))[0];

		if ($validasi_pilih_dokter == null) {
			$success = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Dokter Harus Diisi </h3> 
                       		</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('elektromedik/Emcpengisianhasil/isi_hasil/' . $id_pemeriksaan_em);
		} else {
			$datas['id_pemeriksaan_em'] = $id_pemeriksaan_em;
			$ttd = $this->emmdaftar->get_ttd_dokter(explode('-', $this->input->post('id_dokter'))[0])->row()->ttd;
			$datas['ttd'] = $ttd;
			$datas['id_dokter'] = explode('-', $this->input->post('id_dokter'))[0];

			if ($kode_jenis == 'MF') {
				$data['mf_data'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('data_mf'));
				$data['mf_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesan_mf'));
				$data['mf_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesimpulan_mf'));


				$datas['mf_hasil'] = json_encode($data);
			} elseif ($kode_jenis == 'MB') {
				$data['mb_pre_eeg'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('pre_eeg_mb'));
				$data['mb_history'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('history_mb'));
				$data['mb_hve'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('hve_mb'));
				$data['mb_pdr'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('pdr_mb'));
				$data['mb_tech_comment'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('tech_comment_mb'));
				$data['mb_technologist'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('technologist_mb'));
				$data['mb_interpretation'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('interpretation_mb'));
				$data['mb_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesan_mb'));

				$datas['mb_hasil'] = json_encode($data);
			} elseif ($kode_jenis == 'MC') {
				$data['mc_deskripsi'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('deskripsi_mc'));
				$data['mc_note'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('note_mc'));
				$data['mc_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesimpulan_mc'));

				$datas['mc_hasil'] = json_encode($data);
			} elseif ($kode_jenis == 'MD') {
				$data['md_aorta'] = $this->input->post('aorta_md');
				$data['md_lv_edd'] = $this->input->post('lv_edd_md');
				$data['md_left_atrium'] = $this->input->post('left_atrium_md');
				$data['md_lv_esd'] = $this->input->post('lv_esd_md');
				$data['md_ejection_fraction'] = $this->input->post('ejection_fraction_md');
				$data['md_ivsd'] = $this->input->post('ivsd_md');
				$data['md_epss'] = $this->input->post('epss_md');
				$data['md_ivss'] = $this->input->post('ivss_md');
				$data['md_rv_dimension'] = $this->input->post('rv_dimension_md');
				$data['md_lvpw_diastolic'] = $this->input->post('lvpw_diastolic_md');
				$data['md_lavi'] = $this->input->post('lavi_md');
				$data['md_tapse'] = $this->input->post('tapse_md');
				$data['md_dimensi_r_jantung'] = $this->input->post('dimensi_r_jantung_md');
				$data['md_lvh'] = $this->input->post('lvh_md');
				$data['md_kontraktilitas_lv'] = $this->input->post('kontraktilitas_lv_md');
				$data['md_kontraktilitas_rv'] = $this->input->post('kontraktilitas_rv_md');
				$data['md_analisis_segmental'] = $this->input->post('analisis_segmental_md');
				$data['md_k_aorta'] = $this->input->post('k_aorta_md');
				$data['md_k_mitral'] = $this->input->post('k_mitral_md');
				$data['md_k_trikuspid'] = $this->input->post('k_trikuspid_md');
				$data['md_k_pulmonal'] = $this->input->post('k_pulmonal_md');
				$data['md_dop_ea'] = $this->input->post('dop_ea_md');
				$data['md_dop_dt'] = $this->input->post('dop_dt_md');
				$data['md_dop_ee'] = $this->input->post('dop_ee_md');
				$data['md_dop_ao_vmax'] = $this->input->post('dop_ao_vmax_md');
				$data['md_dop_mpap'] = $this->input->post('dop_mpap_md');
				$data['md_dop'] = $this->input->post('dop_md');
				$data['md_other'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('other_md'));
				$data['md_normakinetik_global'] = $this->input->post('normakinetik_global_md');
				$data['md_katup_struk_func'] = $this->input->post('katup_struk_func_md');
				$data['md_regugitasi'] = $this->input->post('regugitasi_md');

				$dmr = $this->input->post('dimensi_r_jantung_md');
				$klv = $this->input->post('kontraktilitas_md');
				$ng = $this->input->post('normakinetik_global_md');
				$ksc = $this->input->post('katup_struk_func_md');
				$dea = $this->input->post('dop_ea_md');
				$re = $this->input->post('regugitasi_md');

				$data['md_conclusion'] = $dmr . ' ' . $klv . ' ' . $ng . ' ' . $ksc . ' ' . $dea . ' ' . $re;
				$data['md_final_conclusion'] = $this->input->post('final_conclusion_md');


				$datas['md_hasil'] = json_encode($data);
			} elseif ($kode_jenis == 'MA') {
				$data['ma_isi'] = implode('', $this->input->post('isi_ma[]'));
				$data['ma_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesan_ma'));

				$datas['ma_hasil'] = json_encode($data);
			} elseif ($kode_jenis == 'ME') {
				$data['me_faktor_resiko'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('faktor_resiko_me'));

				$data['me_l_cca_psv'] = $this->input->post('l_cca_psv_me');
				$data['me_l_cca_edv'] = $this->input->post('l_cca_edv_me');
				$data['me_l_bulb_psv'] = $this->input->post('l_bulb_psv_me');
				$data['me_l_bulb_edv'] = $this->input->post('l_bulb_edv_me');
				$data['me_l_ica_psv'] = $this->input->post('l_ica_psv_me');
				$data['me_l_ica_edv'] = $this->input->post('l_ica_edv_me');
				$data['me_l_eca_psv'] = $this->input->post('l_eca_psv_me');
				$data['me_l_eca_edv'] = $this->input->post('l_eca_edv_me');
				$data['me_l_ica_eca_psv_edv'] = $this->input->post('l_ica_eca_psv_edv_me');
				$data['me_l_veterbal_psv'] = $this->input->post('l_veterbal_psv_me');
				$data['me_l_veterbal_edv'] = $this->input->post('l_veterbal_edv_me');

				$data['me_r_cca_psv'] = $this->input->post('r_cca_psv_me');
				$data['me_r_cca_edv'] = $this->input->post('r_cca_edv_me');
				$data['me_r_bulb_psv'] = $this->input->post('r_bulb_psv_me');
				$data['me_r_bulb_edv'] = $this->input->post('r_bulb_edv_me');
				$data['me_r_ica_psv'] = $this->input->post('r_ica_psv_me');
				$data['me_r_ica_edv'] = $this->input->post('r_ica_edv_me');
				$data['me_r_eca_psv'] = $this->input->post('r_eca_psv_me');
				$data['me_r_eca_edv'] = $this->input->post('r_eca_edv_me');
				$data['me_r_ica_eca_psv_edv'] = $this->input->post('r_ica_eca_psv_edv_me');
				$data['me_r_veterbal_psv'] = $this->input->post('r_veterbal_psv_me');
				$data['me_r_veterbal_edv'] = $this->input->post('r_veterbal_edv_me');

				$data['me_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('kesimpulan_me'));

				$datas['me_hasil'] = json_encode($data);
			} else {
				$datas['hasil'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('hasil'));

				// $data['hasil_pengirim']=str_replace(["<p>","</p>","&nbsp;","
				// ","
				// "],"",$this->input->post('hasil_pengirim'));
				$datas['saran'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('saran_pengirim'));
				$datas['btk'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('btk_pengirim'));
				$datas['rekam_elektromedik'] = str_replace(["<p>", "</p>", "&nbsp;", "
				", "
				"], "", $this->input->post('rekam_elektromedik_pengirim'));
			}

			$datas['tanggal_isi'] = date('Y-m-d H:i:s');



			$this->emmdaftar->isi_hasil($datas);

			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);
			$data2['xinput'] = $user;
			$data2['xupdate'] = date('Y-m-d H:i:s');
			$data2['id_dokter'] = explode('-', $this->input->post('id_dokter'))[0];
			$data_dokter = $this->emmdaftar->getnama_dokter($data2['id_dokter'])->result();
			foreach ($data_dokter as $row) {
				$data2['nm_dokter'] = $row->nm_dokter;
			}

			$this->emmdaftar->edit_dokter_pemeriksaan_em($no_register, $data2);

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

				$fileName = str_replace(' ', '_', $no_register . "-" . $id_pemeriksaan_em . "-" . $result . "." . $ext);
				$_FILES['userFile']['name'] = $fileName;
				$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
				$_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
				$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
				$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

				$uploadPath = './download/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = '*';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('userFile')) {
					$fileData = $this->upload->data();
					$uploadData[$i]['name'] = $fileName;
					// $uploadData[$i]['token'] = $data_rand;
					$uploadData[$i]['id_pemeriksaan_em'] = $id_pemeriksaan_em;
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
				$insert = $this->emmdaftar->insert_file_hasil($uploadData);
				$statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
				$this->session->set_flashdata('statusMsg', $statusMsg);

				// echo $statusMsg;
				// echo json_encode($uploadData);
			} else {
				// echo "gagal";
				// echo json_encode($uploadData);
			}

			$data_input = json_encode($this->input->post());
			// $response = $this->clients->request(
			// 	'POST',
			// 	'https://192.168.115.5/service-penunjang/api/penunjang',
			// 	[
			// 		'json' => [
			// 			'file'=>$data_input,
			// 			'jenis'=>'EM',
			// 			'tgl_input'=>date("Y-m-d H:i:s"),
			// 			'id_doc'=>md5($no_register),
			// 			'no_order'=>$no_em,
			// 			'id_pemeriksaan'=>$id_pemeriksaan_em
			// 		]
			// 	]
			// )->getBody()->getContents();
			//var_dump($response); die();
			$success = 	'<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
									<h3><i class="fa fa-check-circle"></i> Data berhasil disimpan. </h3> 
								   </div>';
			$this->session->set_flashdata('success_msg', $success);
			// $data2['waktu_keluar_em']=date('Y-m-d H:i:s');
			// $id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);		
			redirect('elektromedik/Emcpengisianhasil/daftar_hasil/' . $no_em);
		}
	}

	public function update_hasil()
	{
		$id_pemeriksaan_em = $this->input->post('id_pemeriksaan_em');
		$no_register = $this->input->post('no_register');
		$noreg = md5($no_register);
		$no_em = $this->input->post('no_em');
		$kode_jenis = $this->input->post('kode_jenis');
		$ket = 'EM';
		// $data_input = json_encode($this->input->post());
		// 		$response = $this->clients->request(
		// 			'PUT',
		// 			'https://192.168.115.5/service-penunjang/api/penunjang/'.$id_pemeriksaan_em.'/'.$no_em.'/'.$noreg.'/'.$ket,
		// 			[
		// 				'json' => [
		// 					'file'=>$data_input,
		// 					'tgl_input'=>date("Y-m-d H:i:s")
		// 				]
		// 			]
		// 		)->getBody()->getContents();
		//var_dump($response); die();
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

			$fileName = str_replace(' ', '_', $no_register . "-" . $id_pemeriksaan_em . "-" . $result . "." . $ext);
			$_FILES['userFile']['name'] = $fileName;
			$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
			$_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
			$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
			$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

			$uploadPath = './download/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$uploadData[$i]['name'] = $fileName;
				// $uploadData[$i]['token'] = $data_rand;
				$uploadData[$i]['id_pemeriksaan_em'] = $id_pemeriksaan_em;
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
			$insert = $this->emmdaftar->insert_file_hasil($uploadData);
			$statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
			$this->session->set_flashdata('statusMsg', $statusMsg);

			// echo $statusMsg;
			// echo json_encode($uploadData);
		} else {
			// echo "gagal";
			// echo json_encode($uploadData);
		}

		//UPDATE DATA
		//
		$ttd = $this->emmdaftar->get_ttd_dokter(explode('-', $this->input->post('id_dokter'))[0])->row()->ttd;
		$datas['ttd'] = $ttd;
		$datas['id_dokter'] = explode('-', $this->input->post('id_dokter'))[0];

		$ttd = $this->emmdaftar->get_ttd_dokter(explode('-', $this->input->post('id_dokter'))[0])->row()->ttd;
		$datas['ttd'] = $ttd;
		$datas['id_dokter'] = explode('-', $this->input->post('id_dokter'))[0];

		if ($kode_jenis == 'MF') {
			$data['mf_data'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('data_mf'));
			$data['mf_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesan_mf'));
			$data['mf_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesimpulan_mf'));


			$datas['mf_hasil'] = json_encode($data);
		} elseif ($kode_jenis == 'MB') {
			$data['mb_pre_eeg'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('pre_eeg_mb'));
			$data['mb_history'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('history_mb'));
			$data['mb_hve'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('hve_mb'));
			$data['mb_pdr'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('pdr_mb'));
			$data['mb_tech_comment'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('tech_comment_mb'));
			$data['mb_technologist'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('technologist_mb'));
			$data['mb_interpretation'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('interpretation_mb'));
			$data['mb_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesan_mb'));

			$datas['mb_hasil'] = json_encode($data);
		} elseif ($kode_jenis == 'MC') {
			$data['mc_deskripsi'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('deskripsi_mc'));
			$data['mc_note'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('note_mc'));
			$data['mc_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesimpulan_mc'));

			$datas['mc_hasil'] = json_encode($data);
		} elseif ($kode_jenis == 'MD') {
			$data['md_aorta'] = $this->input->post('aorta_md');
			$data['md_lv_edd'] = $this->input->post('lv_edd_md');
			$data['md_left_atrium'] = $this->input->post('left_atrium_md');
			$data['md_lv_esd'] = $this->input->post('lv_esd_md');
			$data['md_ejection_fraction'] = $this->input->post('ejection_fraction_md');
			$data['md_ivsd'] = $this->input->post('ivsd_md');
			$data['md_epss'] = $this->input->post('epss_md');
			$data['md_ivss'] = $this->input->post('ivss_md');
			$data['md_rv_dimension'] = $this->input->post('rv_dimension_md');
			$data['md_lvpw_diastolic'] = $this->input->post('lvpw_diastolic_md');
			$data['md_lavi'] = $this->input->post('lavi_md');
			$data['md_tapse'] = $this->input->post('tapse_md');
			$data['md_dimensi_r_jantung'] = $this->input->post('dimensi_r_jantung_md');
			$data['md_lvh'] = $this->input->post('lvh_md');
			$data['md_kontraktilitas_lv'] = $this->input->post('kontraktilitas_lv_md');
			$data['md_kontraktilitas_rv'] = $this->input->post('kontraktilitas_rv_md');
			$data['md_analisis_segmental'] = $this->input->post('analisis_segmental_md');
			$data['md_k_aorta'] = $this->input->post('k_aorta_md');
			$data['md_k_mitral'] = $this->input->post('k_mitral_md');
			$data['md_k_trikuspid'] = $this->input->post('k_trikuspid_md');
			$data['md_k_pulmonal'] = $this->input->post('k_pulmonal_md');
			$data['md_dop_ea'] = $this->input->post('dop_ea_md');
			$data['md_dop_dt'] = $this->input->post('dop_dt_md');
			$data['md_dop_ee'] = $this->input->post('dop_ee_md');
			$data['md_dop_ao_vmax'] = $this->input->post('dop_ao_vmax_md');
			$data['md_dop_mpap'] = $this->input->post('dop_mpap_md');
			$data['md_dop'] = $this->input->post('dop_md');
			$data['md_other'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('other_md'));
			$data['md_normakinetik_global'] = $this->input->post('normakinetik_global_md');
			$data['md_katup_struk_func'] = $this->input->post('katup_struk_func_md');
			$data['md_regugitasi'] = $this->input->post('regugitasi_md');

			$dmr = $this->input->post('dimensi_r_jantung_md');
			$klv = $this->input->post('kontraktilitas_md');
			$ng = $this->input->post('normakinetik_global_md');
			$ksc = $this->input->post('katup_struk_func_md');
			$dea = $this->input->post('dop_ea_md');
			$re = $this->input->post('regugitasi_md');

			$data['md_conclusion'] = $dmr . ' ' . $klv . ' ' . $ng . ' ' . $ksc . ' ' . $dea . ' ' . $re;
			$data['md_final_conclusion'] = $this->input->post('final_conclusion_md');


			$datas['md_hasil'] = json_encode($data);
		} elseif ($kode_jenis == 'MA') {
			$data['ma_isi'] = implode('', $this->input->post('isi_ma[]'));
			$data['ma_kesan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesan_ma'));

			$datas['ma_hasil'] = json_encode($data);
		} elseif ($kode_jenis == 'ME') {
			$data['me_faktor_resiko'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('faktor_resiko_me'));

			$data['me_l_cca_psv'] = $this->input->post('l_cca_psv_me');
			$data['me_l_cca_edv'] = $this->input->post('l_cca_edv_me');
			$data['me_l_bulb_psv'] = $this->input->post('l_bulb_psv_me');
			$data['me_l_bulb_edv'] = $this->input->post('l_bulb_edv_me');
			$data['me_l_ica_psv'] = $this->input->post('l_ica_psv_me');
			$data['me_l_ica_edv'] = $this->input->post('l_ica_edv_me');
			$data['me_l_eca_psv'] = $this->input->post('l_eca_psv_me');
			$data['me_l_eca_edv'] = $this->input->post('l_eca_edv_me');
			$data['me_l_ica_eca_psv_edv'] = $this->input->post('l_ica_eca_psv_edv_me');
			$data['me_l_veterbal_psv'] = $this->input->post('l_veterbal_psv_me');
			$data['me_l_veterbal_edv'] = $this->input->post('l_veterbal_edv_me');

			$data['me_r_cca_psv'] = $this->input->post('r_cca_psv_me');
			$data['me_r_cca_edv'] = $this->input->post('r_cca_edv_me');
			$data['me_r_bulb_psv'] = $this->input->post('r_bulb_psv_me');
			$data['me_r_bulb_edv'] = $this->input->post('r_bulb_edv_me');
			$data['me_r_ica_psv'] = $this->input->post('r_ica_psv_me');
			$data['me_r_ica_edv'] = $this->input->post('r_ica_edv_me');
			$data['me_r_eca_psv'] = $this->input->post('r_eca_psv_me');
			$data['me_r_eca_edv'] = $this->input->post('r_eca_edv_me');
			$data['me_r_ica_eca_psv_edv'] = $this->input->post('r_ica_eca_psv_edv_me');
			$data['me_r_veterbal_psv'] = $this->input->post('r_veterbal_psv_me');
			$data['me_r_veterbal_edv'] = $this->input->post('r_veterbal_edv_me');

			$data['me_kesimpulan'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('kesimpulan_me'));

			$datas['me_hasil'] = json_encode($data);
		} else {
			$datas['hasil'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('hasil'));

			// $data['hasil_pengirim']=str_replace(["<p>","</p>","&nbsp;","
			// ","
			// "],"",$this->input->post('hasil_pengirim'));
			$datas['saran'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('saran_pengirim'));
			$datas['btk'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('btk_pengirim'));
			$datas['rekam_elektromedik'] = str_replace(["<p>", "</p>", "&nbsp;", "
			", "
			"], "", $this->input->post('rekam_elektromedik_pengirim'));
		}

		$datas['tanggal_isi'] = date('Y-m-d H:i:s');

		$this->emmdaftar->update_hasil($id_pemeriksaan_em, $datas);


		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data2['xinput'] = $user;
		$data2['xupdate'] = date('Y-m-d H:i:s');
		$data2['id_dokter'] = explode('-', $this->input->post('id_dokter'))[0];
		$data_dokter = $this->emmdaftar->getnama_dokter($data2['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data2['nm_dokter'] = $row->nm_dokter;
		}

		$this->emmdaftar->edit_dokter_pemeriksaan_em($no_register, $data2);

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Data berhasil disimpan. </h3> 
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('elektromedik/Emcpengisianhasil/daftar_hasil/' . $no_em);
	}

	public function edit_hasil_submit()
	{
		$no_register = $this->input->post('no_register');
		$no_em = $this->input->post('no_em');
		$itot = $this->input->post('itot');
		for ($i = 1; $i <= $itot; $i++) {
			$id_hasil_pemeriksaan = $this->input->post('id_hasil_pemeriksaan_' . $i);
			$hasil_em = $this->input->post('hasil_em_' . $i);

			$this->emmdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_em);
		}

		redirect('elektromedik/emcpengisianhasil/daftar_hasil/' . $no_em);
	}

	public function st_cetak_hasil_em()
	{
		$no_em = $this->input->post('no_em');
		$data_pasien = $this->emmkwitansi->get_data_pasien($no_em)->row();

		if ($no_em != '') {

			$this->emmdaftar->update_status_cetak_hasil($no_em);
			// echo '<script type="text/javascript">window.open("'.site_url("elektromedik/emcpengisianhasil/cetak_hasil_em/$no_em").'", "_blank");window.focus()</script>';

			redirect('elektromedik/emcpengisianhasil/');
		} else {
			redirect('elektromedik/emcpengisianhasil/', 'refresh');
		}
	}

	public function st_cetak_hasil_em_rawat()
	{
		$no_em = $this->input->post('no_em');
		$data_pasien = $this->emmkwitansi->get_data_pasien($no_em)->row();

		if ($no_em != '') {

			$this->emmdaftar->update_status_cetak_hasil($no_em);
			echo '<script type="text/javascript">window.open("' . site_url("elektromedik/emcpengisianhasil/cetak_hasil_em/$no_em") . '", "_blank");window.history.back()</script>';

			//redirect('elektromedik/emcpengisianhasil/','refresh');
		} else {
			//redirect('elektromedik/emcpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_em($no_em = '')
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
				}
			}
			if (substr($data['no_register'], 0, 2) == "PL") {
				$data['data_pasien'] = $this->emmdaftar->get_data_pasien_luar_cetak($no_em)->row();
				$data['nama_dokter'] = '';
				$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_em) . " || Cek Validasi di www.doc.rsomh.co.id";
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
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_em) . " || Cek Validasi di www.doc.rsomh.co.id";
					$data['isi_qr'] = $isi;
				} else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_em) . " || Cek Validasi di www.doc.rsomh.co.id";
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
			$logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
				->setResizeToWidth(50);

			// Create generic label
			$label = Label::create('')
				->setTextColor(new Color(255, 0, 0));

			$result = $writer->write($qrCode, $logo, $label);

			// // Directly output the QR code
			$hasil =  $result->getDataUri();
			$data['qr'] = $hasil;
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('elektromedik/paper_css/hasil_em', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/hasil_em',$data);

		} else {
		}
	}

	public function cetak_hasil_em_old($no_em = '')
	{
		error_reporting(~E_ALL);
		if ($no_em != '') {
			$no_register = $this->emmdaftar->get_row_register_by_noem($no_em)->row()->no_register;

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


			$data_hasil_em = $this->emmdaftar->get_data_hasil_em($no_em)->result();
			$data_hasil_em2 = $this->emmdaftar->get_data_hasil_em($no_em)->result();


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
					HASIL PEMERIKSAAN ELEKTROMEDIK
					</b></p><br/>";

			$nohptelp = "";
			$almt = "";
			if (substr($no_register, 0, 2) == "PL") {
				$data_pasien = $this->emmdaftar->get_data_pasien_luar_cetak($no_em)->row();
				$header = $header .
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Diagnostik</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_em</td>
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
							<td>Dr. PJ. Em</td>
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
				$data_pasien = $this->emmdaftar->get_data_pasien_cetak($no_em)->row();
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
					$nama_dokter = $this->emmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				} else if (substr($no_register, 0, 2) == "RI") {
					$nama_dokter = $this->emmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
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
							<td width=\"25%\">$no_em</td>
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

			// foreach($data_hasil_em as $row){
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
			foreach ($data_hasil_em as $row) {
				if ($row->id_dokter != "") {
					$dokter_1 = $this->emmdaftar->getnama_dokter($row->id_dokter)->row()->nm_dokter;
				} else {
					$dokter_1 = "";
				}
			}
			$body = "
						<table class=\"table-isi\">";
			foreach ($data_hasil_em2 as $key) {
				$gambar_hasil_em = $this->emmdaftar->get_gambar_hasil_em($key->id_pemeriksaan_em)->result();




				$body = $body . "	
						<tr>
							<th colspan=\"2\"><p align=\"left\">
								<b>Jenis Pemeriksaan : $key->jenis_tindakan</b></p>								
							</th>
						</tr>";
				foreach ($gambar_hasil_em as $gambar) {
					$body = $body . "
						<tr>
							<td width=\"16%\">
								<p>Gambar Hasil Pemeriksaan : </p>
							</td>
							<td width=\"84%\">
								<img src=\"download/" . $gambar->name . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
							</td>
						</tr>";
				}
				$body = $body . "
						<tr>
						  	<td width=\"16%\" align=\"right\">
							  Dokter 1 :<br>
							  Hasil :
							</td>
						  	<td width=\"84%\">
								<p align=\"left\">
									$dokter_1<br>
									$key->hasil
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



			$file_name = "Hasil_Em_$no_em.pdf";
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
			$obj_pdf->Output(FCPATH . 'download/' . $file_name, 'FI');
		} else {
			redirect('elektromedik/emcpengisianhasil/', 'refresh');
		}
	}

	public function cetak_hasil_em_pertindakan($id_pemeriksaan_em = '', $no_em = '')
	{
		if ($id_pemeriksaan_em != '') {
			$no_register = $this->emmdaftar->get_data_hasil_em_pertindakan($id_pemeriksaan_em)->row()->no_register;

			//set timezone
			$data['no_em'] = $no_em;
			date_default_timezone_set("Asia/Bangkok");
			$data['tgl_jam'] = date("d-m-Y H:i:s");
			$data['tgl'] = date("d F Y");

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$data['top_header'] = $this->appconfig->get_header_top_pdfconfig()->value;
			$data['bottom_header'] = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

			$data['data_hasil'] = $this->emmdaftar->get_data_hasil_em_pertindakan($id_pemeriksaan_em)->result();
			foreach ($data['data_hasil'] as $row) {
				$data['ma_hasil'] = $row->ma_hasil;
				$data['mb_hasil'] = $row->mb_hasil;
				$data['mc_hasil'] = $row->mc_hasil;
				$data['md_hasil'] = $row->md_hasil;
				$data['me_hasil'] = $row->me_hasil;
				$data['mf_hasil'] = $row->mf_hasil;
			}
			$data['data_pemeriksaan'] = $this->emmdaftar->get_data_hasil_em_pertindakan($id_pemeriksaan_em)->row();
			$data['kode_jenis'] = $this->emmdaftar->get_data_hasil_em_pertindakan($id_pemeriksaan_em)->row()->kode_jenis;
			$data['data_daftar_ulang'] = $this->emmdaftar->get_data_daftar_ulang($no_register)->row();

			if (substr($no_register, 0, 2) == 'RJ') {
				$nama_poli = $this->emmdaftar->get_nama_poli($data['data_daftar_ulang']->id_poli)->row()->nm_poli;
			} else if (substr($no_register, 0, 2) == 'RI') {
				$nama_poli = $data['data_pemeriksaan']->idrg;
			} else {
				$nama_poli = 'Pasien Luar';
			}

			$data['nama_poli'] = $nama_poli;

			if (substr($no_register, 0, 2) == "PL") {
				$data['nama_dokter_reading'] = '';
				$data['nama_dokter_reffering'] = '';
				$data['kontraktor'] = '';
			} else {
				$id_dokter_reading = $this->emmdaftar->get_data_hasil_em_pertindakan($id_pemeriksaan_em)->row()->id_dokter;

				$nama_dokter_reading = $this->emmdaftar->get_nama_dokter($id_dokter_reading)->row()->nm_dokter;
				$data['nama_dokter_reading'] = $nama_dokter_reading;

				$nama_dokter_reffering = $this->emmdaftar->get_nama_dokter($data['data_daftar_ulang']->id_dokter)->row()->nm_dokter;
				$data['nama_dokter_reffering'] = $nama_dokter_reffering;

				if (substr($no_register, 0, 2) == 'RJ') {
					if ($data['data_daftar_ulang']->cara_bayar == 'BPJS') {
						$data['kontraktor'] = 'BPJS';
					} elseif ($data['data_daftar_ulang']->cara_bayar == 'UMUM') {
						$data['kontraktor'] = '';
					} else {
						$nama_kontraktor = $this->emmdaftar->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row()->nmkontraktor;
						$data['kontraktor'] = $nama_kontraktor;
					}
				} else if (substr($no_register, 0, 2) == 'RI') {
					if ($data['data_daftar_ulang']->carabayar == 'BPJS') {
						$data['kontraktor'] = 'BPJS';
					} elseif ($data['data_daftar_ulang']->carabayar == 'UMUM') {
						$data['kontraktor'] = '';
					} else {
						$nama_kontraktor = $this->emmdaftar->get_nama_kontraktor($data['data_daftar_ulang']->id_kontraktor)->row()->nmkontraktor;
						$data['kontraktor'] = $nama_kontraktor;
					}
				}
			}
			// echo '<pre>';
			// var_dump($data['data_daftar_ulang']->diagnosa1);
			// echo '</pre>';
			// die();
			if (!$data['data_daftar_ulang']->diagnosa) {
				$data['diagnosa'] = '';
			} else {
				$nama_diagnosa = $this->emmdaftar->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row();
				if ($nama_diagnosa) {
					$nama_diagnosa = $this->emmdaftar->get_nama_diagnosa($data['data_daftar_ulang']->diagnosa)->row()->nm_diagnosa;
					$data['diagnosa'] = $nama_diagnosa;
				} else {
					$data['diagnosa'] = '';
				}
			}

			if (substr($no_register, 0, 2) == "PL") {
				$data['data_pasien'] = $this->emmdaftar->get_data_pasien_luar_cetak($no_em)->row();
				$data['jenkel'] = $data['data_pasien']->jk;
			} else {
				$data['data_pasien'] = $this->emmdaftar->get_data_pasien_cetak($no_em)->row();
				$data['umur'] = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->row()->umurday;
				$data['jenkel'] = $data['data_pasien']->sex;
			}
			if ($data['jenkel'] == 'L') {
				$data['jenis_kelamin'] = 'Laki - Laki';
			} else {
				$data['jenis_kelamin'] = 'Perempuan';
			}

			// <td>".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>	

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			// $html = $this->load->view('elektromedik/V_hasil',$data,true);
			//$this->mpdf->AddPage('L'); 
			// $mpdf->WriteHTML($html);
			// $mpdf->Output();
			$this->load->view('elektromedik/V_hasil', $data);
		} else {
			redirect('elektromedik/emcpengisianhasil/', 'refresh');
		}
	}
	public function download($data)
	{
		// $fileName = $data;
		//$file_path = 'upload/emgambarhasil/' . $fileName;
		//$this->_push_file($file_path, $fileName);
		//$image_name = "mypic.jpg";
		$image_path = $this->config->item('base_url') . "upload/emgambarhasil/$data";
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
}
