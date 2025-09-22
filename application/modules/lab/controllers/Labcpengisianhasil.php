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
class Labcpengisianhasil extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('lab/labmkwitansi', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
	}

	public function index()
	{
		$date = $this->input->post('date');
		$key = $this->input->post('key');
		if (!empty($date)) {
			$data['title'] = 'PENGISIAN HASIL LABORATORIUM Tanggal ' . date('d-m-Y', strtotime($date));
			$data['laboratorium'] = $this->labmdaftar->get_hasil_lab_by_date($date)->result();
		} else if (!empty($key)) {
			$data['title'] = 'PENGISIAN HASIL LABORATORIUM | ' . $key;
			$data['laboratorium'] = $this->labmdaftar->get_hasil_lab_by_no($key)->result();
		} else {
			$data['title'] = 'PENGISIAN HASIL LABORATORIUM Tanggal ' . date('d-m-Y');
			$data['laboratorium'] = $this->labmdaftar->get_hasil_lab_by_date(date('Y-m-d'))->result();
		}

		$this->load->view('lab/labvdaftarpengisian', $data);
	}

	// public function by_date(){
	// 	$date=$this->input->post('date');
	// 	$data['title'] = 'PENGISIAN HASIL LABORATORIUM Tanggal '.date('d-m-Y',strtotime($date));

	// 	$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_date($date)->result();
	// 	$this->load->view('lab/labvdaftarpengisian',$data);
	// }

	// public function by_no(){
	// 	$key=$this->input->post('key');
	// 	$data['title'] = 'PENGISIAN HASIL LABORATORIUM | '.$key;

	// 	$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_no($key)->result();
	// 	$this->load->view('lab/labvdaftarpengisian',$data);
	// }

	public function daftar_hasil($no_lab = '')
	{
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
		$data['no_lab'] = $no_lab;
		$no_register = $this->labmdaftar->get_no_register($no_lab)->row()->no_register;
		$data['no_register'] = $no_register;
		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_cm;
				$data['nama'] = $row->nama;
				$data['usia'] = $row->usia;
				$data['jk'] = $row->jk;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['kelas_pasien'] = 'II';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['nmkontraktor'] = '';
				$data['tgl_periksa'] = $row->tgl_kunjungan;
				$data['waktu_masuk_lab'] = "";
				$data['rs_perujuk'] = $row->rs_perujuk;
				$data['tgl_lahir'] = $row->tgl_lahir;
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_hasil_pemeriksaan($no_lab)->result();
			// var_dump($data['data_pasien_pemeriksaan']);die();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				if ($data['cara_bayar'] == 'KERJASAMA' or $data['cara_bayar'] == 'BPJS') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row();
					$data['nmkontraktor'] = isset($kontraktor->nmkontraktor) ? $kontraktor->nmkontraktor : '';
				} else $data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'II';
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_lab']=$data['data_pasien_daftar_ulang']->waktu_masuk_lab;
			} else if (substr($no_register, 0, 2) == "RI") {
				$data['waktu_masuk_lab'] = '';
				if ($data['cara_bayar'] == 'KERJASAMA') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row();
					$data['nmkontraktor'] = isset($kontraktor->nmkontraktor) ? $kontraktor->nmkontraktor : '';
				} else $data['nmkontraktor'] = '';
			}
		}

		$data['jenis_hasil_lab'] = $this->labmdaftar->get_jenis_hasil_lab()->result();

		$hasil = $this->labmdaftar->get_row_hasil($no_lab)->result();

		$data['daftar_periksa'] = $this->labmdaftar->get_isi_hasil_tgl($no_lab)->result();
		if (empty($hasil)) {
			$data['jenis'] = 'isi';
			$data['daftarpengisian'] = $this->labmdaftar->get_isi_hasil($no_lab)->result();
		} else {
			$data['jenis'] = 'edit';
			$data['daftarpengisian'] = $this->labmdaftar->get_edit_hasil($no_lab)->result();
		}
		// var_dump($data['daftarpengisian']);die();
		$data['ket'] = isset($this->labmdaftar->get_keterangan_nolab($no_lab)->row()->ket) ? $this->labmdaftar->get_keterangan_nolab($no_lab)->row()->ket : '';
		$data['dokter_pengisi'] = $this->labmdaftar->get_data_dokter_pengisi_lab($no_lab)->row();
		$data['dokter'] = $this->labmdaftar->getdata_dokter()->result();
		// var_dump($data['dokter_pengisi']);
		// die();
		// print_r($data['jenis']);
		$this->load->view('lab/labvdaftarhasil', $data);
	}

	public function isi_hasil($id_pemeriksaan_lab = '')
	{
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
		$data['id_pemeriksaan_lab'] = $id_pemeriksaan_lab;

		$nr = $this->labmdaftar->get_row_register($id_pemeriksaan_lab)->result();
		foreach ($nr as $row) {
			$no_register = $row->no_register;
		}

		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_cm;
				$data['nama'] = $row->nama;
				$data['usia'] = $row->usia;
				$data['jk'] = $row->jk;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_register'] = $no_register;
				$data['kelas_pasien'] = 'II';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_lab'] = $row->no_lab;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['waktu_masuk_lab'] = '';
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_lab'] = $row->no_lab;
				$data['foto'] = $row->foto;
				$data['waktu_masuk_lab'] = $row->waktu_masuk_lab;
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$data['bed'] = 'Rawat Jalan';
			} else if (substr($no_register, 0, 2) == "RD") {
				$data['bed'] = 'Rawat Darurat';
			}
		}

		$data['get_data_tindakan_lab'] = $this->labmdaftar->get_data_tindakan_lab($data['id_tindakan'])->result();

		$this->load->view('lab/labvisihasil', $data);
	}

	public function edit_hasil($id_pemeriksaan_lab = '')
	{
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
		$data['id_pemeriksaan_lab'] = $id_pemeriksaan_lab;

		$nr = $this->labmdaftar->get_row_register($id_pemeriksaan_lab)->result();
		foreach ($nr as $row) {
			$no_register = $row->no_register;
		}

		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_cm;
				$data['nama'] = $row->nama;
				$data['usia'] = $row->usia;
				$data['jk'] = $row->jk;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['no_register'] = $no_register;
				$data['kelas_pasien'] = 'II';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_lab'] = $row->no_lab;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_register'] = $no_register;
				$data['id_tindakan'] = $row->id_tindakan;
				$data['jenis_tindakan'] = $row->jenis_tindakan;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['no_lab'] = $row->no_lab;
				$data['foto'] = $row->foto;
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$data['bed'] = 'Rawat Jalan';
			} else if (substr($no_register, 0, 2) == "RD") {
				$data['bed'] = 'Rawat Darurat';
			}
		}

		$data['get_data_edit_tindakan_lab'] = $this->labmdaftar->get_data_edit_tindakan_lab($data['id_tindakan'], $data['no_lab'])->result();

		$this->load->view('lab/labvedithasil', $data);
	}

	public function simpan_hasil()
	{
		// echo '<pre>';
		// var_dump($this->input->post());
		// echo '</pre>';
		// die();
		$no_register = $this->input->post('no_register');
		$noreg = substr($no_register, 0, 2);
		$no_lab = $this->input->post('no_lab');
		$id_pemeriksaan = $this->input->post('id_pemeriksaan_lab');
		$itot = $this->input->post('itot');
		$data_input = json_encode($this->input->post());
		for ($i = 1; $i <= $itot; $i++) {
			$data['id_tindakan'] = $this->input->post('id_tindakan_' . $i);
			$id_pemeriksaan_lab = $this->input->post('id_pemeriksaan_lab_' . $i);
			$data['no_lab'] = $this->input->post('no_lab');
			$data['no_register'] = $this->input->post('no_register');
			$data['jenis_hasil'] = $this->input->post('jenis_hasil_' . $i);
			$data['kadar_normal'] = $this->input->post('kadar_normal_' . $i);
			$data['satuan'] = $this->input->post('satuan_' . $i);
			$data['hasil_lab'] = $this->input->post('hasil_lab_' . $i);
			$data['ket'] = $this->input->post('ket');
			$data['tgl_isi'] = date("Y-m-d H:i:s");
			if ($this->input->post('urut_' . $i) != '') {
				$no_urut = $data['no_urut'] = $this->input->post('urut_' . $i);
			} else {
				$no_urut = $data['no_urut'] = 0;
			}
			$this->labmdaftar->isi_hasil($data);
		}
		// print_r($data);die();
		$this->labmdaftar->set_hasil_periksa_by_noreg($no_register);

		// $data2['waktu_keluar_rad']=date('Y-m-d H:i:s');
		// $id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);
		// redirect('lab/labcpengisianhasil/daftar_hasil/'.$data['no_lab']);
		echo json_encode(array("status" => TRUE));
	}

	public function edit_hasil_submit()
	{
		$no_register = $this->input->post('no_register');
		$id_pemeriksaan_lab = $this->input->post('id_pemeriksaan_lab');
		$noreg = md5($no_register);
		$ket = 'LAB';
		$no_lab = $this->input->post('no_lab');
		$itot = $this->input->post('itot');
		// $data_input = json_encode($this->input->post());
		// 		$response = $this->clients->request(
		// 			'PUT',
		// 			'https://192.168.115.5/service-penunjang/api/penunjang/'.$id_pemeriksaan_lab.'/'.$no_lab.'/'.$noreg.'/'.$ket,
		// 			[
		// 				'json' => [
		// 					'file'=>$data_input,
		// 					'tgl_input'=>date("Y-m-d H:i:s")
		// 				]
		// 			]
		// 		)->getBody()->getContents();
		for ($i = 1; $i <= $itot; $i++) {
			// jika dia null id_hasil_pemeriksaan maka ( insert )
			if (!$this->input->post('id_hasil_pemeriksaan_' . $i)) {
				$data['id_tindakan'] = $this->input->post('id_tindakan_' . $i);
				$id_pemeriksaan_lab = $this->input->post('id_pemeriksaan_lab');
				$data['no_lab'] = $this->input->post('no_lab');
				$data['no_register'] = $this->input->post('no_register');
				$data['jenis_hasil'] = $this->input->post('jenis_hasil_' . $i);
				$data['kadar_normal'] = $this->input->post('kadar_normal_' . $i);
				$data['satuan'] = $this->input->post('satuan_' . $i);
				if ($this->input->post('jenis_kuman_' . $i) != '' || $this->input->post('jenis_kuman_' . $i) != null) {
					$data['hasil_lab'] = '-';
					$data['jenis_kuman'] = $this->input->post('jenis_kuman_' . $i);
					$data['mic'] = $this->input->post('mic_' . $i);
					$data['sensitifitas'] = $this->input->post('sensitifitas_' . $i);
					$data['nama_organisme'] = $this->input->post('nama_organisme_' . $i);
					$data['ket'] = $this->input->post('ket');
					$data['tgl_isi'] = date("Y-m-d H:i:s");
				} else {

					$data['hasil_lab'] = $this->input->post('hasil_lab_' . $i);
					$data['ket'] = $this->input->post('ket');
					$data['tgl_isi'] = date("Y-m-d H:i:s");
					if ($this->input->post('urut_' . $i) != '') {
						$no_urut = $data['no_urut'] = $this->input->post('urut_' . $i);
					} else {
						$no_urut = $data['no_urut'] = 0;
					}
				}
				$this->labmdaftar->isi_hasil($data);
			} else {
				// else update
				$id_hasil_pemeriksaan = $this->input->post('id_hasil_pemeriksaan_' . $i);
				$id_tindakan = $this->input->post('id_tindakan_' . $i);
				$hasil_lab = $this->input->post('hasil_lab_' . $i);
				$jenis_hasil = $this->input->post('jenis_hasil_' . $i);
				$kadar_normal = $this->input->post('kadar_normal_' . $i);
				$satuan = $this->input->post('satuan_' . $i);
				$ket = $this->input->post('ket');
				$tgl = date("Y-m-d H:i:s");
				$data_update['hasil_lab'] = $hasil_lab;
				$data_update['ket'] = $ket;
				$data['tgl_isi'] = $tgl;
				// var_dump($data_update);die();
				$login_data = $this->load->get_var("user_info");
				$data_update['user_edit'] = $login_data->name;
				$this->labmdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_lab, $data_update);
				
			}
		}

		// die();
		// redirect('lab/labcpengisianhasil/daftar_hasil/'.$no_lab);
		echo json_encode(array("status" => TRUE));
	}

	public function st_cetak_hasil_lab()
	{
		date_default_timezone_set('Asia/Jakarta');
		$no_lab = $this->input->post('no_lab');
		$data_pasien = $this->labmkwitansi->get_data_pasien($no_lab)->row();

		if ($no_lab != '') {

			$this->labmdaftar->update_status_cetak_hasil($no_lab);
			// echo '<script type="text/javascript">window.open("'.site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab").'", "_blank");window.focus()</script>';
			// '<script type="text/javascript">window.open("'.site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab").'", "_blank");window.focus()</script>';

			redirect(site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab"), "_blank");
		} else {
			redirect('lab/labcpengisianhasil/', 'refresh');
		}
	}

	public function st_cetak_hasil_lab_rawat()
	{
		$no_lab = $this->input->post('no_lab');
		$data_pasien = $this->labmkwitansi->get_data_pasien($no_lab)->row();

		if ($no_lab != '') {

			$this->labmdaftar->update_status_cetak_hasil($no_lab);
			echo '<script type="text/javascript">window.open("' . site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab") . '", "_blank");window.history.back();</script>';

			//redirect('lab/labcpengisianhasil/','refresh');
		} else {
			//redirect('lab/labcpengisianhasil/','refresh');
		}
	}

	public function history_lab_all($no_medrec = '')
	{
		$data['$no_medrec'] = $no_medrec;
		$no_lab = $this->input->post('no_lab');
		if ($no_medrec != '') {
			$data['no_register'] = $this->labmdaftar->get_row_register_by_nomed($no_medrec)->row()->no_register;

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$data['tgl'] = date("d-m-Y");


			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
			$data['medrec'] = $this->labmdaftar->get_noreg_pemeriksaan_lab($no_medrec)->result();

			$data['data_jenis_lab'] = $this->labmdaftar->get_data_jenis_lab_new($no_lab)->result();
			$data['data_kategori_lab'] = $this->labmdaftar->get_data_kategori_lab_new($no_lab)->result();

			if (substr($data['no_register'], 0, 2) == "PL") {
				$data['data_pasien'] = $this->labmdaftar->get_data_pasien_luar_cetak_new($no_medrec)->row();
			} else {
				$data['data_pasien'] = $this->labmdaftar->get_data_pasien_cetak_new($no_medrec)->row();
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
			$data['login_data'] = $this->load->get_var("user_info");
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('lab/paper_css/hasil_lab_all', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();

			// $this->load->view('paper_css/hasil_lab',$data);
		} else {
		}
	}

	public function cetak_history_lab_all($no_medrec = '')
	{
		$cm = $this->input->post('no_cm');
		$medrec = $this->input->post('no_medrec');
		$no_ipd = $this->input->post('user_id');

		$data_lab =  $this->labmdaftar->get_noreg_pemeriksaan_lab($no_medrec)->result();

		if ($data_lab != null) {

			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
			$data['tgl'] = date("d-m-Y");
			$data['pasien'] = $this->labmdaftar->get_data_pasien_lab($no_medrec)->row();
			//$data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();

			$data['medrec'] = $this->labmdaftar->get_noreg_pemeriksaan_lab($no_medrec)->result();
			$data['register'] = $this->labmdaftar->get_nolab_pemeriksaan_lab($no_medrec)->result();

			$data['get_umur'] = $this->labmdaftar->get_umur($no_medrec)->result(); #
			foreach ($data['get_umur'] as $row) {
				$data['tahun'] = $row->umurday;
			}
			$data['usia'] = date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
			//$data['usia']=date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
			$data['hasil_pemeriksaan_lab'] =  isset($no_ipd) ? $this->labmdaftar->get_data_laboratorium_by_noipd($no_ipd)->result() : "";

			$data['kode_document'] = '';

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('emedrec/rd/hasil_lab_all', $data, true);
			ini_set("pcre.backtrack_limit", "5000000");
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('ri/cetak_laboratorium',$data);

		} else {

			// $success = 	'<div class="alert alert-danger">
			// <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			// <h3>Tidak ada pemeriksaan
			// </div>';
			// $this->session->set_flashdata('success_msg', $success);
			// redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);

		}
	}

	public function cetak_hasil_lab($no_lab = '')
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
			$get_ket = $this->labmdaftar->get_keterangan_nolab($no_lab)->row();
			$data['ket'] = isset($get_ket->ket) ? $get_ket->ket : '';
			$data['data_kategori_lab'] = $this->labmdaftar->get_data_kategori_lab($no_lab)->result();
			$data['data_kategori_kultur'] = $this->labmdaftar->get_data_kategori_lab_kultur($no_lab)->result();
			// 1. => 2[ hematologi , kimia darah]

			$data['data_jenis_lab'] = $this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data['data_jenis_kultur'] = $this->labmdaftar->get_data_jenis_lab_kultur($no_lab)->result();
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
			// var_dump($data['no_register']);die();
			if (substr($data['no_register'], 0, 2) == "PL") {
				$data['data_pasien'] = $this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
				$isi =  "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_lab) . " || Cek Validasi di www.doc.rsomh.co.id";
				$data['isi_qr'] = $isi;
				$data['kelamin'] = '';
			} else {
				$data['data_pasien'] = $this->labmdaftar->get_data_pasien_cetak($no_lab)->row();
				// var_dump($data['data_pasien']);die();
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
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_lab) . " || Cek Validasi di www.doc.rsomh.co.id";
					$data['isi_qr'] = $isi;
				} else if (substr($data['data_pasien']->no_register, 0, 2) == "RI") {
					$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($data['data_pasien']->no_register) . "" . md5($no_lab) . " || Cek Validasi di www.doc.rsomh.co.id";
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
			// var_dump($data['data_pasien']); die();
			$data['check_micro'] = $this->labmdaftar->check_pemeriksaan_micro($no_lab)->result();
			$data['header_micro'] = $this->labmdaftar->get_data_header_hasil_pemeriksaan_micro($no_lab)->result();
			$data['jenis_hasil_micro'] = $this->labmdaftar->get_data_hasil_pemeriksaan_micro($no_lab)->result();
			// $data['ttd'] = $this->labmdaftar->ttd_haisl((int)$data['data_pasien']->id_dokter)->row()->ttd;
			$data['login_data'] = $this->load->get_var("user_info");
			if($data['data_pasien']->id_dokter != null){
				$data['user_id'] = $this->labmdaftar->get_id_dokter($data['data_pasien']->id_dokter)->row()->userid;
			}else{
				$data['user_id'] = '';
			}
			
			
			// var_dump($data['data_pasien']->id_dokter);die();
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
			// $logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
			// 	->setResizeToWidth(40);

			// Create generic label
			$label = Label::create('')
				->setTextColor(new Color(255, 0, 0));

			// $result = $writer->write($qrCode, $logo, $label);

			// // Directly output the QR code
			// $hasil =  $result->getDataUri();
			// $data['qr'] = $hasil;
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('lab/paper_css/hasil_lab', $data, true);
			 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			

			//  $this->load->view('paper_css/hasil_lab',$data);
		} else {
		}
	}

	public function cetak_hasil_lab_old($no_lab = '')
	{
		error_reporting(~E_ALL);
		if ($no_lab != '') {
			$no_register = $this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;

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

			foreach ($conf as $rowheader) {
				$head_pdf =	$rowheader->value;
			}
			$header_pdf = $this->config->item('header_pdf');

			$data_jenis_lab = $this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data_kategori_lab = $this->labmdaftar->get_data_kategori_lab($no_lab)->result();
			$nohptelp = "";
			$almt = "";

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
			$konten = "
			<font size=\"6\" align=\"right\">$tgl_jam</font><br>
			$header_page
			<hr><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN LABORATORIUM
					</b></p><br/>";
			if (substr($no_register, 0, 2) == "PL") {
				$data_pasien = $this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
				$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
				$konten = $konten .
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_lab</td>
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
							<td>Dr. PJ. Lab</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$interval->format(\"%Y tahun\");</td>
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
				$data_pasien = $this->labmdaftar->get_data_pasien_cetak($no_lab)->row();
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
				$nm_poli = $this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				$nama_dokter = $this->labmdaftar->getnm_dokter($data_pasien->no_register)->row()->nm_dokter;
				if ($data_pasien->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar = "$a->a - $a->b";
				} else {
					$cara_bayar = $data_pasien->cara_bayar;
				}
				if (substr($no_register, 0, 2) == RJ) {
					$lokasi = $data_pasien->idrg;
				} else if (substr($no_register, 0, 2) == RI) {
					$lokasi = 'Rawat Inap - ' . $data_pasien->idrg;
					// $lokasi = $nm_poli;
				} else {
					$lokasi = 'Pasien Langsung';
				}


				$konten = $konten .
					"<table  border=\"0\" cellpadding=\"0\" cellspacing=\"1\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_lab</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Lab</td>
							<td> : </td>
							<td>$data_pasien->nm_dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td>Status</td>
							<td> : </td>
							<td>$cara_bayar</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>
								$almt
							</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			$konten = $konten . "
					<table style=\"padding-left:10px; font-size:9\">
						<tr>
							<th width=\"30%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"30%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"25%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
						</tr>
					</table><hr>
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px; 
						    font-size:9;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    border-right: 1px solid #ddd;
						}
					</style>
					<table class=\"table-isi\" border=\"0\">";
			foreach ($data_kategori_lab as $rw) {
				$tindakan = strtoupper($rw->nama_jenis);
				$konten = $konten . "
							<tr>
								<th colspan=\"5\"><p align=\"left\">
									<br/><b>Jenis Pemeriksaan : <i>$tindakan</i></b></p>
								</th>
							</tr>";
				foreach ($data_jenis_lab as $row) {
					if ($rw->kode_jenis == substr($row->id_tindakan, 0, 2)) {
						$konten = $konten . "
									<tr>
										<th colspan=\"5\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
									</tr>";
						$data_hasil_lab = $this->labmdaftar->get_data_hasil_lab($row->id_tindakan, $row->no_lab)->result();
						foreach ($data_hasil_lab as $row1) {
							$kadar_normal = str_replace('<', '&lt;', $row1->kadar_normal);
							$kadar_normal = str_replace('>', '&gt;', $kadar_normal);
							$konten = $konten . "<tr>
													  <td width=\"30%\">&nbsp;&nbsp;&nbsp;&nbsp;$row1->jenis_hasil</td>
													  <td width=\"30%\"><center>$row1->hasil_lab</center></td>
													  <td width=\"15%\">$row1->satuan</td>
													  <td width=\"25%\">$row1->kadar_normal</td>
													</tr>";
						}
					}
				}
			}


			$konten = $konten . "
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
								
								<br><br><br>Laboratorium
								</p>
							</td>
						</tr>	
					</table>
					<br>*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter
					";

			$file_name = "Hasil_Lab_$no_lab.pdf";
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
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/lab/labpengisianhasil/' . $file_name, 'FI');
		} else {
			redirect('lab/labcpengisianhasil/', 'refresh');
		}
	}

	public function export_hasil_lab($no_lab = '')
	{
		if ($no_lab != '') {
			$no_register = $this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars = $this->config->item('namars');
			$kota_kab = $this->config->item('kota');
			$telp = $this->config->item('telp');
			$alamatrs = $this->config->item('alamat');
			$nmsingkat = $this->config->item('namasingkat');
			$email = $this->config->item('email');
			$header_pdf = $this->config->item('header_pdf');

			$data_jenis_lab = $this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data_kategori_lab = $this->labmdaftar->get_data_kategori_lab($no_lab)->result();


			////EXCEL 
			$this->load->library('Excel');

			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();

			// Set document properties  
			$objPHPExcel->getProperties()->setCreator("RUMAH SAKIT KHUSUS MATA")
				->setLastModifiedBy("RUMAH SAKIT KHUSUS MATA")
				->setTitle("Laporan Keuangan RUMAH SAKIT KHUSUS MATA")
				->setSubject("Laporan Keuangan RUMAH SAKIT KHUSUS MATA Document")
				->setDescription("Laporan Keuangan RUMAH SAKIT KHUSUS MATA, generated by HMIS.")
				->setKeywords("RUMAH SAKIT KHUSUS MATA")
				->setCategory("Laboratorium");

			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
			//$objPHPExcel = $objReader->load("project.xlsx");

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');

			$data_keuangan = $this->Labmlaporan->get_data_keu_tind($param1, $param2)->result();

			$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_lab.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);
			// Add some data  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Laboratorium Periode " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2)));
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$rowCount = 4;
			$temp = "";
			$temptgl = "";
			$total_pendapatan = 0;
			foreach ($data_keuangan as $row) {
				if ($temptgl == $row->tgl_kunjungan) {
				} else {
					$temptgl = $row->tgl_kunjungan;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->tgl_kunjungan);
				}

				if ($temp == $row->no_lab) {
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->status == "1") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				} else {
					$temp = $row->no_lab;
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->no_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->kelas);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->bed);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->status == "1") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				}

				$rowCount++;
			}
			$filename = "Laporan Pendapatan Laboratorium " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2));
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "Total Pendapatan : ");
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="' . $filename . '.xls"');

			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('RUMAH SAKIT KHUSUS MATA');

			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();

			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			// $objWriter->save('php://output');  
			$this->SaveViaTempFile($objWriter);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');
			// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
			// echo json_encode($data_keuangan);
		} else {
			redirect('lab/labcpengisianhasil/', 'refresh');
		}
	}

	public function input_dokter_lab()
	{
		$no_lab = $this->input->post('no_lab');
		$id_dokter = $this->input->post('id_dokter');

		$data['id_dokter'] = $id_dokter;
		$data_dokter = $this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data['nm_dokter'] = $row->nm_dokter;
		}

		$this->labmdaftar->input_dokter_isi($data, $no_lab);



		echo json_encode(array('status' => 'success'));
	}


	public function input_nama_organisme_kultur()
	{
		header('Content-Type: application/json; charset=utf-8');
		$no_lab = $this->input->post('no_lab');
		$nama_organisme_kultur = $this->input->post('nama_organisme_kultur');
		$this->labmdaftar->input_dokter_isi(['nama_organisme_kultur' => $nama_organisme_kultur], $no_lab);
		echo json_encode(array('status' => 200));
	}

	public function input_tgl_lab()
	{
		$no_lab = $this->input->post('no_lab');
		$id_tindakan = $this->input->post('id_tindakan_periksa');
		$data['tgl_periksa'] = $this->input->post('tgl_periksa') . ' ' . $this->input->post('time_periksa');

		$this->labmdaftar->input_tgl_periksa_isi($data, $no_lab, $id_tindakan);

		echo json_encode(array('status' => 'success'));
	}

	public function daftar_hasil_lengkap($no_lab = '', $id_tindakan = '', $isedit = "")
	{
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
		$data['isedit'] = $isedit;
		$data['no_lab'] = $no_lab;
		$no_register = $this->labmdaftar->get_no_register($no_lab)->row()->no_register;
		$data['no_register'] = $no_register;
		$data['id_pemeriksaan_lab'] = $this->labmdaftar->get_id_pemeriksaan_lab($no_lab, $id_tindakan)->row()->id_pemeriksaan_lab;
		if (substr($no_register, 0, 2) == "PL") {
			$data['data_pasien'] = $this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_lab)->result();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_cm;
				$data['nama'] = $row->nama;
				$data['usia'] = $row->usia;
				$data['jk'] = $row->jk;
				$data['alamat'] = $row->alamat;
				$data['dokter_rujuk'] = $row->dokter;
				$data['kelas_pasien'] = 'II';
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = $row->cara_bayar;
				$data['nmkontraktor'] = '';
				$data['tgl_periksa'] = $row->tgl_kunjungan;
				$data['waktu_masuk_lab'] = "";
				$data['rs_perujuk'] = $row->rs_perujuk;
				$data['asal'] = 'Pasien Luar';
				$data['tgl_lahir'] = $row->tgl_lahir;
			}
		} else {
			$data['data_pasien'] = $this->labmdaftar->get_data_pasien_cetak($no_lab)->row();
			$usia = date_diff(date_create($data['data_pasien']->tgl_lahir), date_create('now'));
			$data['usia'] = $usia->y;
			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_hasil_pemeriksaan($no_lab)->result();
			// var_dump($data['data_pasien_pemeriksaan']);die();
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			if (substr($no_register, 0, 2) == "RJ") {
				$data['asal'] = $data['data_pasien']->bed;
				// if($data['cara_bayar']=='KERJASAMA'){
				// 	$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
				// 	$data['nmkontraktor']=$kontraktor;
				//}else 
				$data['nmkontraktor'] = '';
				// $data['bed']='Rawat Jalan';
				$data['kelas_pasien'] = 'II';
				$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_lab']=$data['data_pasien_daftar_ulang']->waktu_masuk_lab;
			} else if (substr($no_register, 0, 2) == "RI") {
				$data['asal'] = $data['data_pasien']->idrg;
				$data['waktu_masuk_lab'] = '';
				if ($data['cara_bayar'] == 'KERJASAMA') {
					$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row(['nmkontraktor']);
					$data['nmkontraktor'] = $kontraktor;
				} else $data['nmkontraktor'] = '';
			}
		}
		//var_dump($data['asal']); die();
		$data['jenis_hasil_lab'] = $this->labmdaftar->get_jenis_hasil_lab()->result();

		$hasil = $this->labmdaftar->cek_isi_hasil($no_lab, $id_tindakan)->result();

		$data['daftar_periksa'] = $this->labmdaftar->get_isi_hasil_tgl($no_lab)->result();
		if (empty($hasil)) {
			$data['jenis'] = 'isi';
			//$data['ket'] = $this->labmdaftar->get_ket_hasil($no_lab, $id_tindakan)->row()->ket;
			$data['daftarpengisian'] = $this->labmdaftar->get_isi_hasil_lengkap($no_lab, $id_tindakan)->result();
		} else {
			$data['jenis'] = 'edit';
			$data['daftarpengisian'] = $this->labmdaftar->get_edit_hasil_lengkap($no_lab, $id_tindakan)->result();
			$data['ket'] = $this->labmdaftar->get_ket_hasil($no_lab, $id_tindakan)->row()->ket;
			//var_dump($data['ket']); die();
		}
		$data['id_pemeriksaan'] = $this->labmdaftar->get_id_pemeriksaan_lab($no_lab, $id_tindakan)->row()->id_pemeriksaan_lab;

		if ($data['data_pasien']->sex == 'P') {
			$sex = 'PEREMPUAN';
			$data['jk'] = $sex;
		} else {
			$sex = 'LAKI LAKI';
			$data['jk'] = $sex;
		}

		$data['kategori_lab'] = $this->labmdaftar->get_data_kategori_lab_api($no_lab, $id_tindakan)->row();
		$data['jenis_lab'] = $this->labmdaftar->get_data_jenis_lab_api($no_lab, $id_tindakan)->row();
		$data['dokter_pengisi'] = $this->labmdaftar->get_data_dokter_pengisi_lab($no_lab)->row();
		$data['dokter_isi'] = $this->labmdaftar->get_data_dokter_pengisi_lab_new($no_lab, $id_tindakan)->row();
		// $data['ttd'] = $this->labmdaftar->ttd_haisl($data['dokter_isi']->id_dokter)->row()->ttd;
		$data['ttd'] = '';
		$data['drpengirim'] = $this->labmdaftar->getnm_dokter($no_register)->row()->nm_dokter;
		$data['dokter'] = $this->labmdaftar->getdata_dokter()->result();
		$data['master_jenis_kuman_lab'] = $this->labmdaftar->get_master_jenis_kuman_lab()->result();
		$data['id_tindakan_hidden'] = $id_tindakan;

		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';
		// die();
		$this->load->view('lab/labvdaftarhasillengkap', $data);
	}

	public function input_keterangan_pemeriksaan()
	{
		$no_lab = $this->input->post('no_lab');
		$catatan = $this->input->post('catatan');

		$data['ket'] = $catatan;

		$this->labmdaftar->input_keterangan_pemeriksaan($data, $no_lab);

		echo json_encode(array('status' => 'success'));
	}
}
