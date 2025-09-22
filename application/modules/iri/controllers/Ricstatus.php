<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('Rjcterbilang.php');

// include(dirname(dirname(__FILE__)).'/Tglindo.php');

// require_once(APPPATH.'controllers/Secure_area.php');
class Ricstatus extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimlaporan');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimdokter');
		$this->load->model('irj/rjmkwitansi');
		$this->load->model('irj/rjmmedrec');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('irj/M_update_sepbpjs');
		$this->load->model('admin/appconfig', '', TRUE);

		$this->load->model('lab/labmdaftar');
		$this->load->helper('pdf_helper');
	}

	public function insert_inacbg() {
		$no_register = $this->input->post('no_register');

		$data['kd_inacbg'] = $this->input->post('kode_inacbg');
		$code = $this->rjmmedrec->update_kodeinacbg_pasien_ri($data, $no_register);

		if($code == true) {
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:green\"></i> Kode INA - CBG Pasien Berhasil Diperbarui ! </span>
			</div>");
			redirect('iri/ricstatus/index/'.$no_register);
		} else {
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:red\"></i> Kode INA - CBG Pasien Gagal Diperbarui, Coba Lagi ! </span>
			</div>");
			redirect('iri/ricstatus/index/'.$no_register);
		}
	}

	public function test()
	{


		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);

		$data = '
			 <request>
			 <data>
			 <t_sep>
			 <noKartu>0000026975924</noKartu>
			 <tglSep>' . $tgl_sep . '</tglSep>
			 <tglRujukan>' . $tgl_sep . '</tglRujukan>
			 <noRujukan>Tes01</noRujukan>
			 <ppkRujukan>0301U049</ppkRujukan>
			 <ppkPelayanan>0301R001</ppkPelayanan>
			 <jnsPelayanan>2</jnsPelayanan>
			 <catatan>Coba SEP Bridging</catatan>
			 <diagAwal>H52.0</diagAwal>
			 <poliTujuan>MAT</poliTujuan>
			 <klsRawat>3</klsRawat>
			 <lakaLantas>2</lakaLantas>
			 <user>viena</user>
			 <noMr>121280</noMr>
			 </t_sep>
			 </data>
			 </request>
		 ';

		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		exit;


		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			'Accept: application/json',
			'Content-type: application/xml',
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Peserta/peserta/0001219738138');
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
		$json_response = json_decode($result);
		print_r($json_response->response->peserta);
		exit;
	}

	public function cek_kartu_bpjs()
	{
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$url = $data_bpjs->service_url;
		$no_bpjs = $this->input->post('no_bpjs');
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			'Accept: application/json',
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: ' . $cons_id, //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init($url . 'Peserta/peserta/' . $no_bpjs);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);

		if ($result != '') { //valid koneksi internet
			$sep = json_decode($result)->response;
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->peserta == '') {
				echo "No Kartu \"<b>$no_bpjs</b>\" Tidak Ditemukan. <br> Silahkan memilih cara bayar yang lain...";
			} else {
				foreach ($sep as $key => $value) {
					echo "<b>No Kartu:</b> $value->noKartu <br/>";
					echo "<b>NIK:</b> $value->nik <br/>";
					echo "<b>Nama:</b> $value->nama <br/>";
					echo "<b>Pisa:</b> $value->pisa <br/>";
					echo "<b>Sex:</b> $value->sex <br/>";
					echo "<b>Tanggal Lahir:</b> $value->tglLahir <br/>";
					echo "<b>Tanggal Cetak Kartu:</b> $value->tglCetakKartu <br/>";
					$kdprovider = $value->provUmum->kdProvider;
					$nmProvider = $value->provUmum->nmProvider;
					$kdCabang = $value->provUmum->kdCabang;
					$nmCabang = $value->provUmum->nmCabang;
					echo '<br/><b>Kode Provider:</b> ' . $kdprovider;
					echo '<br/><b>Nama Provider:</b> ' . $nmProvider;
					echo '<br/><b>Kode Cabang:</b> ' . $kdCabang;
					echo '<br/><b>Nama Cabang:</b> ' . $nmCabang;
					$kdJenisPeserta = $value->jenisPeserta->kdJenisPeserta;
					$nmJenisPeserta = $value->jenisPeserta->nmJenisPeserta;
					echo '<br/><br/><b>Kode Jenis Peserta:</b> ' . $kdJenisPeserta;
					echo '<br/><b>Jenis Peserta:</b> ' . $nmJenisPeserta;
					$kdKelas = $value->kelasTanggungan->kdKelas;
					$nmKelas = $value->kelasTanggungan->nmKelas;
					echo '<br/><br/><b>Kode Kelas:</b> ' . $kdKelas;
					echo '<br/><b>Nama Kelas:</b> ' . $nmKelas;
					echo '<br/><b>Status Peserta:</b> ' . $value->statusPeserta->keterangan;
					// print_r($value->jenisPeserta->nmJenisPeserta);
				};
			}
		} else {
			echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
			//echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
		}
	}

	public function ambil_sep()
	{


		$no_bpjs = $this->input->post('no_bpjs');
		$nosjp = $this->input->post('nosjp');
		$noregasal = $this->input->post('noregasal_hidden');
		$temp_ruang = $this->input->post('ruang');
		$diagnosa_id = $this->input->post('diagnosa_id');
		$no_cm = $this->input->post('no_cm');
		$ppk = $this->input->post('ppk');
		if ($no_bpjs == "") {
			$data_response = array(
				'status' => 0,
				'response' => "Nomor Kartu BPJS Kosong"
			);
			echo json_encode($data_response);
			exit;
		}
		if ($nosjp == "") {
			$data_response = array(
				'status' => 0,
				'response' => "Nomor SJP / Rujukan Kosong"
			);
			echo json_encode($data_response);
			exit;
		}
		if ($temp_ruang == "") {
			$data_response = array(
				'status' => 0,
				'response' => "Nomor Kelas Ruangan Belum Terpilih"
			);
			echo json_encode($data_response);
			exit;
		}

		$ruang = explode("-", $temp_ruang);
		$temp_kelas = $ruang[2];
		$temp_kelas = explode(" ", $temp_kelas);

		$kelas = $temp_kelas[0];
		switch ($kelas) {
			case 'I':
				$kelas = 1;
				break;
			case 'II':
				$kelas = 2;
				break;
			case 'III':
				$kelas = 3;
				break;
			case 'VIP':
				$kelas = 1;
				break;
			default:
				$kelas = 3;
				break;
		}

		$kode = substr($noregasal, 0, 2);

		// if($kode=='RJ'){
		// 	$pasien=$this->rimpendaftaran->select_pasien_irj_by_no_register_asal_with_diag_utama($noregasal);
		// }else if($kode=='RI'){
		// 	$pasien=$this->rimpendaftaran->select_pasien_iri_by_no_register_asal($noregasal);
		// }else{
		// 	$pasien=$this->rimpendaftaran->select_pasien_ird_by_no_register_asal_with_diag_utama($noregasal);
		// }

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		$data = '
			 <request>
			 <data>
			 <t_sep>
			 <noKartu>' . $no_bpjs . '</noKartu>
			 <tglSep>' . $tgl_sep . '</tglSep>
			 <tglRujukan>' . $tgl_sep . '</tglRujukan>
			 <noRujukan>' . $nosjp . '</noRujukan>
			 <ppkRujukan>' . $ppk . '</ppkRujukan>
			 <ppkPelayanan>0301R001</ppkPelayanan>
			 <jnsPelayanan>2</jnsPelayanan>
			 <catatan>-</catatan>
			 <diagAwal>' . $diagnosa_id . '</diagAwal>
			 <poliTujuan>MAT</poliTujuan>
			 <klsRawat>' . $kelas . '</klsRawat>
			 <lakaLantas>2</lakaLantas>
			 <user>' . $user . '</user>
			 <noMr>' . $no_cm . '</noMr>
			 </t_sep>
			 </data>
			 </request>
		 ';
		//print_r($data);exit;
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		if ($result != '') { //valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array(
					'status' => 0,
					'response' => $sep->metadata->message
				);
			} else {
				$data_response = array(
					'status' => 1,
					'response' => $sep->response
				);
			}
		} else {
			$data_response = array(
				'status' => 0,
				'response' => "Pastikan Anda Terhubung Internet!!"
			);
		}

		echo json_encode($data_response);
	}

	public function data_icd9cm()
	{
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimtindakan->select_icd9cm_like($keyword);

		foreach ($data as $row) {

			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['id_tind'] . " - " . $row['nm_tindakan'],
				'id_tind'				=> $row['id_tind'],
				'kode_procedure'				=> $row['id_tind'],
				'nm_tindakan'				=> $row['nm_tindakan']
			);
		}
		echo json_encode($arr);
	}

	public function set_pulang_sep()
	{


		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			'Content-type: Application/x-www-form-urlencoded',
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		$data = '
			<request>
			 <data>
			  <t_sep>
			   <noSep>0301R00105160000042</noSep>
			   <tglPlg>' . $tgl_sep . '</tglPlg>
			   <ppkPelayanan>0301R001</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>

		 ';
		//print_r($data);exit;
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Sep/Sep/updtglplg');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		print_r($result);
		exit;
		if ($result != '') { //valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array(
					'status' => 0,
					'response' => $sep->metadata->message
				);
			} else {
				$data_response = array(
					'status' => 1,
					'response' => $sep->response
				);
			}
		} else {
			$data_response = array(
				'status' => 0,
				'response' => "Pastikan Anda Terhubung Internet!!"
			);
		}

		echo json_encode($data_response);
	}

	public function hapus_sep()
	{


		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time() - strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			'Content-type: Application/x-www-form-urlencoded',
			'X-cons-id: 1000', //id rumah sakit
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		$data = '
			<request>
			 <data>
			  <t_sep>
			   <noSep>0301R00105160000042</noSep>
			   <ppkPelayanan>0301R001</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>

		 ';
		//print_r($data);exit;
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		print_r($result);
		exit;
		if ($result != '') { //valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array(
					'status' => 0,
					'response' => $sep->metadata->message
				);
			} else {
				$data_response = array(
					'status' => 1,
					'response' => $sep->response
				);
			}
		} else {
			$data_response = array(
				'status' => 0,
				'response' => "Pastikan Anda Terhubung Internet!!"
			);
		}

		echo json_encode($data_response);
	}

	public function cetak_sep($no_ipd = '')
	{

		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH . 'controllers/irj/SEP.php');

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		//$data_rs = $this->rimkelas->get_data_rs('10000');

		$sep = new SEP();


		$fields = array(
			'No. Register' => $pasien[0]['no_ipd'],
			'No. SEP' => $pasien[0]['no_sep'],
			'Tgl. SEP' => $pasien[0]['tgl_masuk'],
			'No. Kartu' => $pasien[0]['no_kartu'],
			'Peserta' => $pasien[0]['no_kartu'],
			'Nama Peserta' => $pasien[0]['nama'],
			'Tgl. Lahir' => $pasien[0]['tgl_lahir'],
			'Jenis Kelamin' => $pasien[0]['sex'],
			'Asal Faskes' => $pasien[0]['tgl_lahir'],
			'Poli Tujuan' => "-",
			'Kelas Rawat' => $pasien[0]['kelas'],
			'Jenis Rawat' => "Rawat Inap",
			'Diagnosa Awal' => $pasien[0]['nm_diagmasuk'],
			'Catatan' => "",
			'Nama RS' => $this->config->item('namars')
		);
		$sep->set_nilai($fields);
		$sep->cetak();
	}

	//keperluan tanggal
	// public function obj_tanggal(){
	// 	 $tgl_indo = new Tglindo();
	// 	 return $tgl_indo;
	// }

	public function get_grandtotal_all($no_ipd)
	{


		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);

		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;



		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}


		// if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){			
		// 	$list_lab_pasien = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
		// 	$list_radiologi = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
		// 	$list_resep = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
		// 	$list_pa = $this->rimpasien->get_list_pa_pasien_umum($no_ipd);
		// 	//radiologi
		// 	if(($list_radiologi)){
		// 		$result = $this->string_table_radiologi_simple($list_radiologi);
		// 		$grand_total = $grand_total + $result['subtotal'];

		// 	}

		// 	//lab
		// 	if(($list_lab_pasien)){
		// 		$result = $this->string_table_lab_simple($list_lab_pasien);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//pa
		// 	if(($list_pa)){
		// 		$result = $this->string_table_pa_simple($list_pa);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//resep
		// 	if(($list_resep)){
		// 		$result = $this->string_table_resep_simple($list_resep);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}
		// }else{
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_pa = $this->rimpasien->get_list_pa_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_ok = $this->rimpasien->get_list_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		//radiologi
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//lab
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//pa
		if (($list_pa)) {
			$result = $this->string_table_pa_simple($list_pa);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ok
		if (($list_ok)) {
			$result = $this->string_table_ok_simple($list_ok);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ird
		if (($list_tindakan_ird)) {
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//irj
		if ($pasien[0]['carabayar'] == 'BPJS') {
			if (($poli_irj)) {
				$result = $this->string_table_irj_simple($poli_irj);
				$grand_total = $grand_total + $result['subtotal'];
			}
		}
		// }

		return $grand_total;
	}

	public function cetak_list_tindakan($no_ipd = '')
	{
		// $cm=$nocm!=""?$nocm:$this->input->post('no_cm');
		// $medrec=$nomedrec!=""?$nomedrec:$this->input->post('no_medrec');
		// $no_ipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
		// $cm=$this->input->post('no_cm');
		// $medrec=$this->input->post('no_medrec');
		// $no_ipd=$this->input->post('user_id');

		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		// var_dump($data['list_tindakan_pasien']);die();
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['tgl'] = date("Y-m-d");

		//  if($list_tindakan_pasien != null){

		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$interval = date_diff(date_create(), date_create($data['data_pasien'][0]['tgl_lahir']));
		$thn = $interval->format("%Y Tahun");
		$data['tahun'] = $thn;
		// $data['dokter_ruangan'] = $this->M_emedrec_iri->get_dokter_ruangan($no_ipd)->row();
		// $data['register'] = $data_lab;
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		// $data['ttd'] = $this->rimpasien->get_ttd_dpjp($data['data_pasien'][0]['dr_dpjp'])->row()->ttd;
		$data['dokter'] = $this->rimpasien->get_ttd_dpjp($data['data_pasien'][0]['dr_dpjp'])->row()->nm_dokter;
		// $data['get_umur']=$this->rjmregistrasi->get_umur($medrec)->result();#
		// foreach($data['get_umur'] as $row)
		// {
		//     $data['tahun']=$row->umurday;
		// }
		// $data['usia']=date_diff(date_create($data['pasien']->tgl_lahir), date_create('now'));
		// $data['hasil_pemeriksaan_lab'] =  isset($no_ipd)?$this->M_emedrec_iri->get_data_laboratorium_by_noipd($no_ipd)->result():"";

		// $data['kode_document'] = '';
		ini_set("pcre.backtrack_limit", "5000000");
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('iri/cetak_tindakan', $data, true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('iri/cetak_tindakan',$data);
		// }else{
		// $success = 	'<div class="alert alert-danger">
		// <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		// <h3>Tidak Ada Pemeriksaan
		// </div>';
		// $this->session->set_flashdata('success_msg', $success);
		// redirect('emedrec/C_emedrec/rekam_medik_detail/'.$cm.'/'.$medrec);
		//}

	}

	public function get_total_pembayaran($no_ipd = '')
	{

		//Mufti hehe :D

		// $total_ruangan = ;
		// $total_tindakan = ;
		// $total_operasi = ;
		// $total_lab = ;
		// $total_rad = ;
		// $total_pa = ;
		// $total_resep = ;
		// $total_poli = ;

		return $grand_total;
	}

	public function index($no_ipd = '', $param = '')
	{
		$data['title'] = 'Status Pasien | ' . $no_ipd;
		$data['reservasi'] = '';
		$data['daftar'] = '';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = 'active';
		$data['resume'] = '';
		$data['kontrol'] = '';
		$data['linkheader'] = 'ricstatus';
		$data['no_ipd'] = $no_ipd;
		//bikin object buat penanggalan
		$data['controller'] = $this;
		$data['view'] = 0;
		//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		// $data['ttd'] = $this->rimtindakan->get_list_tindakan_pelayanan_iri($no_ipd)->row()->ttd_pelaksana;
		// $path = $data['ttd']; //this is the image path
		// $type = pathinfo($path, PATHINFO_EXTENSION);
		// $dt = file_get_contents($path);
		// $tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
		if($pasien[0]['verifikasi_plg'] == 1) {
			$userid = isset($pasien[0]['user_verif'])?$pasien[0]['user_verif']:0;
			$data['user_verif'] = isset($this->rimtindakan->get_name_user_verif($userid)->row()->name)?$this->rimtindakan->get_name_user_verif($userid)->row()->name:'';
		}
		$data['inacbg'] = $this->rjmmedrec->get_kode_inacbg()->result();
		$data['diagnosa'] = $this->rjmmedrec->get_diagnosa_inacbg($no_ipd)->result();
		$data['data_pasien'] = $pasien;
		$data['state'] = $param;
		$data['title2'] = 'STATUS PASIEN DI RUANGAN';
		if ($param != '') {
			$data['title2'] = 'DETAIL TINDAKAN PASIEN';
		} else {
			$temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
			if ($temp) {
				$this->session->set_flashdata(
					'pesan_tindakan',
					"<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Terdapat Data Tindakan yang belum tersimpan ! Simpan terlebih dahulu sebelum pasien akan dimutasi/dipulangkan
				</div>"
				);
			}
		}

		//list tindakan, mutasi, dll
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$data['total_tind'] = $this->rimpasien->get_total_tindakan_pasien($no_ipd)->row()->total;

		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);

		$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		//kalo misalnya dia ada paket, langusn flag paketnya
		$data['status_paket'] = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$data['status_paket'] = 1;
		}
		if ($pasien[0]['ipdibu'] == NULL) {
			$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		} else {
			$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien_bayi($no_ipd);
		}

		$data['list_ok_pasien'] = $this->rimpasien->get_list_ok_pasien($no_ipd, $pasien[0]['noregasal']);

		// if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){	
		// 	$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
		// 	$data['cetak_lab_pasien'] = $this->rimpasien->get_cetak_lab_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_pa_pasien'] = $this->rimpasien->get_list_pa_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['cetak_pa_pasien'] = $this->rimpasien->get_cetak_pa_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		// 	$data['cetak_rad_pasien'] = $this->rimpasien->get_cetak_rad_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_resep'] = $this->rimpasien->get_list_resep_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		// 	$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		// }else{
		// $data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['cetak_lab_pasien'] = $this->rimpasien->get_cetak_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['list_pa_pasien'] = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['cetak_pa_pasien'] = $this->rimpasien->get_cetak_pa_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['cetak_rad_pasien'] = $this->rimpasien->get_cetak_rad_pasien($no_ipd,$pasien[0]['noregasal']);
		// $data['list_resep'] = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);

		$data['list_ok_iri'] = $this->rimpasien->get_list_ok_iri_status($no_ipd);
		$data['list_pa_pasien'] = "";
		$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_iri_status($no_ipd);
		$data['list_radiologi'] = $this->rimpasien->get_list_rad_iri_status($no_ipd);
		$data['list_elektromedik'] = $this->rimpasien->get_list_em_iri_status($no_ipd);
		$data['list_resep'] = $this->rimpasien->get_list_resep_iri($no_ipd);

		if ($pasien[0]['noregasal'] != '') {
			$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
			$data['list_ok_ird'] = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
			$data['list_em_ird'] = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
			$data['list_rad_ird'] = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
			$data['list_lab_ird'] = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
			$data['list_resep_ird'] = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
		} else {
			$data['list_tindakan_ird'] = array();
			$data['list_ok_ird'] = array();
			$data['list_em_ird'] = array();
			$data['list_rad_ird'] = array();
			$data['list_lab_ird'] = array();
			$data['list_resep_ird'] = array();
		}
		//	$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		//	$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		// }
		//print_r($data['poli_irj']);exit();

		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);

		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivstatus');

		$login_data = $this->load->get_var("user_info");
		$datarole = $this->labmdaftar->get_roleid($login_data->userid)->result();
		$data['role'] = $datarole[0]->roleid;
		//print_r($datarole);
		foreach ($datarole as $f) {
			//	if(($f->roleid=='1' || $f->roleid=='16' || $f->roleid=='24') && $param==''){
			$data['access'] = 1;
			break;
			//	}else{
			//	$data['access']=0;
			//		}
		}

		$this->load->view('iri/list_status', $data);
		//$this->load->view('iri/rivfooter');
	}

	public function tindakan_pasien($no_register)
	{
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_register);

		$line  = array();
		$line2 = array();
		$row2  = array();

		foreach ($data['list_tindakan_pasien'] as $row) {
			$row2['tindakan'] = $row['nmtindakan'];
			$row2['pelaksana'] = $row['pelaksana'];
			$row2['ruang'] = $row['nmruang'];
			$row2['tgl_tindakan'] = date("d-m-Y", strtotime($row['tgl_layanan']));
			if ($row['jam_tindakan'] != NULL) {
				$row2['jam_tindakan'] = date('H:i', strtotime($row['jam_tindakan']));
			} else {
				$row2['jam_tindakan'] = "";
			}
			$row2['biaya_tindakan'] = number_format($row['tumuminap']);
			$row2['biaya_alkes'] = number_format($row['tarifalkes']);
			$row2['qty'] = $row['qtyyanri'];
			$row2['total'] = number_format($row['tumuminap'] * $row['qtyyanri']);
			$row2['ttd'] = '<img id="imageid" name="imageid" src="' . $row['ttd_pelaksana'] . '" alt="Red dot" width="75px" height="75px">';
			$row2['aksi'] = '<button type="button" id="btn-hapus-tindakan" class="btn btn-danger btn-sm" onclick="hapus_tindakan(' . $row['id_jns_layanan'] . ')">Hapus</button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		echo json_encode($line);
	}

	public function cetak_list_pembayaran_pasien_simple()
	{

		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		//echo $diskon;
		$dibayar_tunai = $this->input->post('dibayar_tunai');
		//$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		//$charge = $this->input->post('charge');
		//$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		//$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if (!($diskon) || $diskon == '') {
			$diskon = 0;
		}
		//print_r($penerima);exit;

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//kamari
		/*if($pasien[0]['cetak_kwitansi'] == '1'){
			$string_close_windows = "window.open('', '_self', ''); window.close();";
			echo 'Kwitansi hanya diperbolehkan dicetak satu kali. klik tombol ini untuk kembali <button type="button" 
        onclick="'.$string_close_windows.'">Kembali</button>';
        	exit;
		}*/
		//end 

		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd);
		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		$status_paket = 0;
		if (($data_paket)) {
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		//$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
		//$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . ".pdf";
		$konten = "";
		$konten1 = "";


		$konten = $konten . '<table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$mutasicount = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1 . $result['konten'];
			$mutasicount = $mutasicount + 1;
		}

		//tindakan dokter
		if (($list_tindakan_dokter_pasien)) {
			$result = $this->string_table_tindakan_simple($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1 . $result['konten'];
			//print_r($konten);exit;
		}

		//tindakan perawat
		if (($list_tindakan_perawat_pasien)) {
			$result = $this->string_table_tindakan_simple($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1 . $result['konten'];
			//print_r($konten);exit;
		}

		//tindakan matkes
		/*if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1.$result['konten'];
			//print_r($konten);exit;
		}*/


		//radiologi
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1 . $result['konten'];
		}

		//ok
		if (($list_ok_pasien)) {
			$result = $this->string_table_ok_simple($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1 . $result['konten'];
		}

		$matkes_iri = 0;
		/*if(($list_matkes_ok_pasien)){
			$result = $this->string_table_ok_simple($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$matkes_iri = $matkes_iri + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}*/
		//pa
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa_simple($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1 . $result['konten'];
		}

		//lab
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1 . $result['konten'];
		}

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1 . $result['konten'];
		}

		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}*/

		//irj
		if ($pasien[0]['carabayar'] == 'BPJS') {
			/*if(($poli_irj)){
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
			}*/
			if (($poli_irj)) {
				$result = $this->string_table_irj($poli_irj);
				$grand_total = $grand_total + $result['subtotal'];
				$konten1 = $konten1 . "
			<tr>
				<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
				<td>Rp. " . number_format($result['subtotal'], 0) . "</td>
			</tr>
			";
				//$konten = $konten.$result['konten'];
			}
		}

		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		$vtot_peserta = $grand_total + $biaya_administrasi;
		// +$biaya_materai+$biaya_daftar+$jasa_perawat
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		/*switch ($jenis_bayar) {
			case 'TUNAI':
				$vtot_peserta = $dibayar_tunai+$dibayar_kartu_cc_debit+$nomimal_charge;
				break;
			case 'KREDIT':
				/*if($jenis_bayar == "KREDIT" && ( $dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0 ) )
				{
					$vtot_peserta = $dibayar_tunai + $dibayar_kartu_cc_debit +$nomimal_charge;
				}else{
					$vtot_peserta = $grand_total+$biaya_administrasi;
				}
				$vtot_peserta = $grand_total+$biaya_administrasi;
				break;
			default:
				# code...
				break;
		}*/
		//INIT KALO TUNAI DAN KREDIT

		// $konten = $this->string_data_pasien_simple($pasien,$grand_total-$subsidi_total,$penerima,$jenis_pembayaran).$konten;
		$konten = $this->string_data_pasien_simple($pasien, $dibayar_tunai, $penerima, $jenis_pembayaran) . $konten;
		$tgl = date("d F Y");

		$jenis_bayar = $this->input->post('jenis_pembayaran');
		$string_detail_pembayaran_kredit_tunai = "";
		$string_diskon = "";
		if ($diskon != 0) {
			$string_diskon = "<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
						<th ><p align=\"right\">Rp. " . number_format($diskon, 0) . "</p></th>
					</tr>";
		}

		$string_detail_pembayaran_kredit_tunai =
			"
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
					<th ><p align=\"right\">Rp. " . number_format($dibayar_tunai, 0) . "</p></th>
				</tr>
				" . $string_diskon;
		//echo $vtot_peserta;
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		//echo $string_detail_pembayaran_kredit_tunai;
		$grand_total_string = "
		<br><br>
		<table border=\"1\">
			" . $string_detail_pembayaran_kredit_tunai . "
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. " . number_format($vtot_peserta, 0) . "</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td colspan=\"3\" align=\" left \">Terbilang : $vtot_terbilang</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>K a s i r</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>----------------------------------------</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>
		";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$konten = $konten . "<br>" . $grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['vtot'] = $grand_total - $diskon + $biaya_administrasi;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if ($jenis_bayar == "KREDIT") {
			$data_pasien_iri['diskon'] = $grand_total + $biaya_administrasi - $dibayar_tunai - $this->input->post('diskon');
			$data_pasien_iri['vtot'] = $grand_total + $biaya_administrasi - $data_pasien_iri['diskon'];
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		} else {
			$data_pasien_iri['diskon'] = $this->input->post('diskon');
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		//$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		//$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		//$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['matkes_iri'] = $matkes_iri;
		$data_pasien_iri['jasa_perawat'] = $this->input->post('jasa_perawat');
		$data_pasien_iri['biaya_administrasi'] = $this->input->post('biaya_administrasi');
		//$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if ($pasien[0]['carabayar'] == "DIJAMIN") {
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		$this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'], date("Y:m:d H:m:i"), $data_pasien_iri['lunas']);
		$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'], date("Y:m:d H:m:i"), $data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		if ($jenis_bayar == "KREDIT" && ($dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0)) {
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');

			$obj_pdf->AddPage();
			ob_start();
			$content = $konten_kredit;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
		} else {
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
		}
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}

	public function cetak_log_list_pembayaran_pasien_simple()
	{

		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');

		$dibayar_tunai = $this->input->post('dibayar_tunai');
		$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		$charge = $this->input->post('charge');
		$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');


		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if (!($diskon) || $diskon == '') {
			$diskon = 0;
		}
		//print_r($penerima);exit;

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//kamari
		// if($pasien[0]['cetak_kwitansi'] == '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwitansi hanya diperbolehkan dicetak satu kali. klik tombol ini untuk kembali <button type="button" 
		//       onclick="'.$string_close_windows.'">Kembali</button>';
		//       	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		$status_paket = 0;
		if (($data_paket)) {
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . " .pdf";
		$konten = "";


		$konten = $konten . '<table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			//$konten = $konten.$result['konten'];
		}

		//tindakan
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			//$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}

		//radiologi
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//ird
		if (($list_tindakan_ird)) {
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//irj
		if (($poli_irj)) {
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		switch ($jenis_bayar) {
			case 'TUNAI':
				$vtot_peserta = $dibayar_tunai + $dibayar_kartu_cc_debit + $nomimal_charge;
				break;
			case 'KREDIT':
				if ($jenis_bayar == "KREDIT" && ($dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0)) {
					$vtot_peserta = $dibayar_tunai + $dibayar_kartu_cc_debit + $nomimal_charge;
				} else {
					$vtot_peserta = $grand_total + $biaya_administrasi;
				}
				break;
			default:
				# code...
				break;
		}
		//INIT KALO TUNAI DAN KREDIT

		// $konten = $this->string_data_pasien_simple($pasien,$grand_total-$subsidi_total,$penerima,$jenis_pembayaran).$konten;
		$konten = $this->string_data_pasien_simple($pasien, $vtot_peserta, $penerima, $jenis_pembayaran) . $konten;
		$tgl = date("d F Y");

		$jenis_bayar = $this->input->post('jenis_pembayaran');
		$string_detail_pembayaran_kredit_tunai = "";
		switch ($jenis_bayar) {
			case 'TUNAI':
				$string_kartu_kredit = "";
				if ($dibayar_kartu_cc_debit != 0) {
					$string_kartu_kredit = "
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
						<th ><p align=\"right\">Rp. " . number_format($dibayar_kartu_cc_debit, 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Charge % </b></p></th>
						<th ><p align=\"right\">" . $charge . "</p></th>
					</tr>
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Nominal Charge   </b></p></th>
						<th ><p align=\"right\">Rp. " . number_format($nomimal_charge, 0) . "</p></th>
					</tr>
					";
				}

				$string_diskon = "";
				if ($diskon != 0) {
					$string_diskon = "<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
						<th ><p align=\"right\">Rp. " . number_format($diskon, 0) . "</p></th>
					</tr>";
				}

				$string_detail_pembayaran_kredit_tunai =
					"
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
					<th ><p align=\"right\">Rp. " . number_format($dibayar_tunai, 0) . "</p></th>
				</tr>
				" . $string_kartu_kredit . $string_diskon;
				break;
			case 'KREDIT':
				//$vtot_peserta = $grand_total+$biaya_administrasi;
				break;
			default:
				# code...
				break;
		}

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
		<br><br><br>
		<table border=\"1\">
			" . $string_detail_pembayaran_kredit_tunai . "
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. " . number_format($vtot_peserta, 0) . "</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>K a s i r</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>----------------------------------------</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>
		";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$konten = $konten . "<br>" . $grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['vtot'] = $grand_total - $diskon + $biaya_administrasi;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if ($jenis_bayar == "KREDIT") {
			$data_pasien_iri['diskon'] =  $this->input->post('diskon');
			$data_pasien_iri['vtot'] = $grand_total + $biaya_administrasi - $data_pasien_iri['diskon'];
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		} else {
			$data_pasien_iri['diskon'] = $this->input->post('diskon');
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['biaya_administrasi'] = $biaya_administrasi;
		$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if ($pasien[0]['carabayar'] == "DIJAMIN / JAMSOSKES") {
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		// $this->rimpendaftaran->update_pendaftaran_mutasi($, $no_ipd);
		// $this->rimpasien->flag_kwintasi_rad_terbayar(data_pasien_iri$no_ipd);
		// $this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		// $this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		// $this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		// $this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran


		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		if ($jenis_bayar == "KREDIT" && ($dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0)) {
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');

			$obj_pdf->AddPage();
			ob_start();
			$content = $konten_kredit;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
		} else {
			ob_start();
			$content = $konten;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
		}
		//$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');


	}

	private function string_perusahaan($pasien, $jumlah_dijamin, $penerima, $jenis_pembayaran, $tgl)
	{
		$konten = "";
		$konten = $konten . $this->string_data_pasien_simple($pasien, $jumlah_dijamin, $penerima, $jenis_pembayaran);
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
		<br><br><br>
		<table border=\"1\">
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. " . number_format($jumlah_dijamin, 0) . "</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>K a s i r</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>----------------------------------------</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>
		";

		$konten = $konten . "<br>" . $grand_total_string;
		return $konten;
	}

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$konten = $konten . '
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$lama_inap = 0;
		$total_subsidi = 0;
		// $tgl_indo = new Tglindo();
		$ceknull = 0;
		$jasaperawat = 0;
		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = substr($r['tglmasukrg'], 6, 2);
			$tahun_show = substr($r['tglmasukrg'], 0, 4);
			$tanggal_show = substr($r['tglmasukrg'], 8, 2);
			$tgl_masuk_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if ($r['tglkeluarrg'] != null) {
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = substr($r['tglkeluarrg'], 6, 2);
				$tahun_show = substr($r['tglkeluarrg'], 0, 4);
				$tanggal_show = substr($r['tglkeluarrg'], 8, 2);
				$tgl_keluar_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;
			} else {
				if ($pasien[0]['tgl_keluar'] != null) {
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = substr($pasien[0]['tgl_keluar'], 6, 2);
					$tahun_show = substr($pasien[0]['tgl_keluar'], 0, 4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'], 8, 2);
					$tgl_keluar_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;
				} else {
					$tgl_keluar_rg = "-";
				}
			}

			if ($r['tglkeluarrg'] != null) {
				$start = new DateTime($r['tglmasukrg']); //start
				$end = new DateTime($r['tglkeluarrg']); //end

				$diff = $end->diff($start)->format("%a");
				if ($diff == 0) {
					$diff = 1;
				}
				$selisih_hari =  $diff . " Hari";
			} else {
				if ($pasien[0]['tgl_keluar'] != NULL) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($pasien[0]['tgl_keluar']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime(date("Y-m-d")); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}

					$selisih_hari =  "- Hari";
				}
			}

			//untuk perhitungan subsidi, berdasarkan lama inap
			$lama_inap = $lama_inap + $diff;
			$jasaperawat = $jasaperawat + $r['jasa_perawat'];

			if ($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') {
				$ceknull = 1;
			}
			//ambil harga jatah kelas
			// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
			// if(!($kelas)){
			// 	$total_tarif = 0;
			// }else{
			// 	$total_tarif = $kelas[0]['total_tarif'] ;
			// }\
			$total_tarif = $r['harga_jatah_kelas'];

			$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			if ($status_paket == 1) {
				// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
				// if($temp_diff < 0){
				// 	$temp_diff = 0;
				// }
				$total_per_kamar = 0;
			} else {
				$total_per_kamar = $r['vtot'] * $diff;
			}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten . "
			<tr>
				<td align=\"center\">" . $r['nmruang'] . "</td>
				<td align=\"center\">" . $r['kelas'] . "</td>
				<td align=\"center\">" . $r['bed'] . "</td>
				<td align=\"center\">" . $tgl_masuk_rg . "</td>
				<td align=\"center\">" . $tgl_keluar_rg . "</td>
				<td align=\"center\">" . $selisih_hari . "</td>
				<td align=\"right\">Rp. " . number_format($total_per_kamar, 0) . "</td>
			</tr>
			";
		}

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subsidi' => $total_subsidi,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien)
	{
		$konten = "";

		$subtotal = 0;

		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['tumuminap'] + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			$vtot = number_format($r['vtot'], 0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'], 0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subsidi' => $subtotal_jth_kelas
		);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal = $subtotal + $r['vtot'];
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			// $biaya_ok = number_format($r['biaya_ok'],0);
			// $vtot = number_format($r['vtot'],0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Operasi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_pa_simple($list_pa_pasien)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_pa = number_format($r['biaya_pa'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Patologi Anatomi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_resep_simple($list_resep)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Obat</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_irj_simple($poli_irj)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="6" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}
	//end modul cetak laporan simple

	public function get_tarif_inacbg()
	{
		$keyword = strtoupper($this->uri->segment(12));
		$tarif = $this->rimpasien->cari_kd_inacbg($keyword)->result();
		if (!empty($tarif)) {
			foreach ($tarif as $row) {
				$arr['suggestions'][] = array(
					'id' => $row->id_tarif_inacbg,
					'kd_inacbg'	=> $row->kd_inacbg,
					'kelas'  => $row->kelas,
					'tarif' => $row->tarif,
					'kelas_rs' => $row->kelas_rs
				);

				// $arr['suggestions'][] = array(
				//     'value'	=> $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",".$row->qty.")",
				//     'idobat' => $row->id_obat,
				//     'nama'	=>$row->nm_obat,
				//     'satuank'  =>$row->satuank,
				//     'harga' => $row->hargajual,
				//     'hargabeli' => $row->hargabeli,
				//     'batch_no' => $row->batch_no,
				//     'expire_date' => $row->expire_date,
				//     'qty' => $row->qty,
				//     'jenis_obat' => $row->jenis_obat
				// );
			}
		}
	}

	public function kalkulasi_harga_()
	{
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		$vtotdenda = $this->input->post('denda');
		$obat = $this->input->post('biaya_obat');
		$tarif = $this->input->post('tarif');
		$tarif2 = $this->input->post('tarif2');
		$tarif3 = $this->input->post('tarif_vip');
		$dibayar_tunai = $this->input->post('dibayar_tunai');
		$dibayar_tunai1 = $this->input->post('dibayar_tunai1');
		$dibayar_tunai3 = $this->input->post('dibayar_tunai3');
		$dibayar_tunai4 = $this->input->post('dibayar_tunai4');
		$dibayar_tunai5 = $this->input->post('dibayar_tunai5');
		$dibayar_tunai6 = $this->input->post('dibayar_tunai6');
		$total_gabungan = $this->input->post('total_gabungan');
		$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		$charge = $this->input->post('charge');
		$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = 0; //40000;
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');
		$grand_total = $this->input->post('biaya_total');

		$subsidi_total = 0;

		$kasir = $this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$data10['tunai'] = '0';
		$data10['no_kk'] = '0';
		$data10['nilai_kkd'] = '0';
		$data10['persen_kk'] = '0';
		$data10['diskon'] = '0';
		// $this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);

		$idrg = $this->rimpasien->get_recent_idrg_patient($no_ipd)->row()->idrg;
		//if($pasien[0]['carabayar']=='BPJS'){
		$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd);
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_pa_pasien = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
		$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
		$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd); //belum ada no_register
		$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd);
		//$list_resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row;
		//	$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		//	$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
		//$list_ok_pasien = $this->rimpasien->get_list_all_ok_pasien($no_ipd);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		// }else{
		// 	$list_pa_pasien = "";
		// 	$list_lab_pasien = "";
		// 	$list_radiologi = "";
		// 	$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		// 	$list_tindakan_ird = "";
		// 	$poli_irj = "";
		// 	$list_ok_pasien = "";
		// 	$list_matkes_ok_pasien = "";
		// }

		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$vtot_ruang = $result['subtotal'];
		}

		$biaya_kamar = $grand_total;
		$vtot_tindakan = 0;
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtot_tindakan = $result['subtotal'];
		}

		//radiologi
		$vtotrad = 0;
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi($list_radiologi);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotrad = $result['subtotal'];
		}

		//elektromedik
		$vtotem = 0;
		if (($list_elektromedik)) {
			$result = $this->string_table_elektromedik($list_elektromedik);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotem = $result['subtotal'];
		}

		//operasi
		$vtotok = 0;
		if (($list_ok_pasien)) {
			$result = $this->string_table_operasi($list_ok_pasien);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotok = $result['subtotal'];
		}

		//operasi
		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotok += $result['subtotal'];
		}

		//pa
		$vtotpa = 0;
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotpa = $result['subtotal'];
		}

		//lab
		$vtotlab = 0;
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotlab = $result['subtotal'];
		}

		//resep
		$vtotresep = 0;
		if (($list_resep)) {
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotresep = $result['subtotal'];
		}

		$login_data = $this->load->get_var("user_info");
		//if(($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] != 'VIP') && ($pasien[0]['titip'] == NULL || $pasien[0]['titip'] == '1')){
		$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');
		$kwitansi['no_register'] = $no_ipd;
		if ($cek_no_kwitansi) {
			$no_kwitansi = substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
			$kwitansi['no_kwitansi'] = 'RI' . date('y') . '-' . sprintf("%06d", $no_kwitansi);
			$kwitansi['idno_kwitansi'] = sprintf("%06d", $no_kwitansi);
		} else {
			$kwitansi['no_kwitansi'] = 'RI' . date('y') . '-00001';
			$kwitansi['idno_kwitansi'] = 1;
		}
		$kwitansi['jenis_kwitansi'] = 'RI';
		$kwitansi['user_cetak'] = $login_data->username;
		$kwitansi['tgl_cetak'] = date('Y-m-d H:i:s');
		$kwitansi['vtot_bayar'] = $this->input->post('biaya_total');
		$kwitansi['tunai'] = $this->input->post('dibayar_tunai');
		$kwitansi['diskon'] = (int)$diskon;
		if ($pasien[0]['carabayar'] == 'BPJS') {
			if (($pasien[0]['klsiri'] == $pasien[0]['jatahklsiri']) || ($pasien[0]['jatahklsiri'] == 'III')) {
				$kwitansi['tarif_kls1_inacbg'] = $this->input->post('tarif');
				$kwitansi['tarif_kls2_inacbg'] = $this->input->post('tarif2');
			} else if (($pasien[0]['klsiri'] != $pasien[0]['jatahklsiri']) || ($pasien[0]['jatahklsiri'] != 'III')) {
				$kwitansi['tarif_kls1_inacbg'] = $this->input->post('tarif_satu');
				$kwitansi['tarif_kls2_inacbg'] = $this->input->post('tarif_dua');
			}
		}
		$kwitansi['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$kwitansi['asal'] = $idrg;
		$this->rimpasien->insert_no_kwitansi($kwitansi);
		// }else if((($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == NULL)) || (($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == '1'))){
		// 	$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');
		// 	$kwitansi['no_register']=$no_ipd;
		// 	if ($cek_no_kwitansi) {
		// 		$no_kwitansi=substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-'.sprintf("%06d", $no_kwitansi);
		// 		$kwitansi['idno_kwitansi']=sprintf("%06d", $no_kwitansi);
		// 	}else{
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-00001';
		// 		$kwitansi['idno_kwitansi']= 1;
		// 	}
		// 	$kwitansi['jenis_kwitansi']='RI';
		// 	$kwitansi['user_cetak']=$login_data->username;
		// 	$kwitansi['tgl_cetak']=date('Y-m-d H:i:s');
		// 	$kwitansi['vtot_bayar']=$this->input->post('biaya_total3');
		// 	$kwitansi['tunai']=(int)$this->input->post('dibayar_tunai3');
		// 	$kwitansi['diskon']=(int)$diskon;
		// 	$kwitansi['tarif_kls_inacbg']=(int)$tarif3;
		// 	$kwitansi['jenis_bayar']=$this->input->post('jenis_pembayaran');
		// 	$kwitansi['asal'] = $pasien[0]['nmruang'];
		// 	$this->rimpasien->insert_no_kwitansi($kwitansi);
		// } else if(($pasien[0]['carabayar']=='KERJASAMA') && ($pasien[0]['titip'] == NULL)) {
		// 	$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');

		// 	$kwitansi['no_register']=$no_ipd;
		// 	if ($cek_no_kwitansi) {
		// 		$no_kwitansi=substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-'.sprintf("%06d", $no_kwitansi);
		// 		$kwitansi['idno_kwitansi']=sprintf("%06d", $no_kwitansi);
		// 	}else{
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-00001';
		// 		$kwitansi['idno_kwitansi']= 1;
		// 	}

		// 	$kwitansi['jenis_kwitansi']='RI';
		// 	$kwitansi['user_cetak']=$login_data->username;
		// 	$kwitansi['tgl_cetak']=date('Y-m-d H:i:s');
		// 	$kwitansi['vtot_bayar']=(int)$this->input->post('biaya_total4');
		// 	$kwitansi['tunai']=(int)$this->input->post('dibayar_tunai4');
		// 	$kwitansi['diskon']=(int)$diskon;
		// 	$kwitansi['jenis_bayar']=$this->input->post('jenis_pembayaran');
		// 	$kwitansi['asal'] = $pasien[0]['nmruang'];
		// 	$this->rimpasien->insert_no_kwitansi($kwitansi);
		// }else if(($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == NULL)){
		// 	$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');

		// 	$kwitansi['no_register']=$no_ipd;
		// 	if ($cek_no_kwitansi) {
		// 		$no_kwitansi=substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-'.sprintf("%06d", $no_kwitansi);
		// 		$kwitansi['idno_kwitansi']=sprintf("%06d", $no_kwitansi);
		// 	}else{
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-00001';
		// 		$kwitansi['idno_kwitansi']= 1;
		// 	}

		// 	$kwitansi['jenis_kwitansi']='RI';
		// 	$kwitansi['user_cetak']=$login_data->username;
		// 	$kwitansi['tgl_cetak']=date('Y-m-d H:i:s');
		// 	$kwitansi['vtot_bayar']=(int)$this->input->post('biaya_total1');
		// 	$kwitansi['tunai']=(int)$this->input->post('dibayar_tunai1');
		// 	$kwitansi['diskon']=(int)$diskon;
		// 	$kwitansi['jenis_bayar']=$this->input->post('jenis_pembayaran');
		// 	$kwitansi['asal'] = $pasien[0]['nmruang'];
		// 	$this->rimpasien->insert_no_kwitansi($kwitansi);
		// } else if(($pasien[0]['carabayar'] == 'UMUM' || $pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == '1')) {
		// 	$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');
		// 	$kwitansi['no_register']=$no_ipd;
		// 	if ($cek_no_kwitansi) {
		// 		$no_kwitansi=substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-'.sprintf("%06d", $no_kwitansi);
		// 		$kwitansi['idno_kwitansi']=sprintf("%06d", $no_kwitansi);
		// 	}else{
		// 		$kwitansi['no_kwitansi']='RI'.date('y').'-00001';
		// 		$kwitansi['idno_kwitansi']= 1;
		// 	}
		// 	$kwitansi['jenis_kwitansi']='RI';
		// 	$kwitansi['user_cetak']=$login_data->username;
		// 	$kwitansi['tgl_cetak']=date('Y-m-d H:i:s');
		// 	$kwitansi['vtot_bayar']=$this->input->post('biaya_total5');
		// 	$kwitansi['tunai']=(int)$this->input->post('dibayar_tunai5');
		// 	$kwitansi['diskon']=(int)$diskon;
		// 	$kwitansi['jenis_bayar']=$this->input->post('jenis_pembayaran');
		// 	$kwitansi['asal'] = $pasien[0]['nmruang'];
		// 	$this->rimpasien->insert_no_kwitansi($kwitansi);
		// }

		$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd);
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		//$data_pasien_iri['vtot'] = $this->string_table_tindakan_faktur($list_tindakan_pasien,$list_dokter)['subtotal'];
		$data_pasien_iri['vtot'] = $vtot_tindakan;
		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$data_pasien_iri['vtot_ok'] = $vtotok;
		$data_pasien_iri['vtot_lab'] = $vtotlab;
		$data_pasien_iri['vtot_rad'] = $vtotrad;
		$data_pasien_iri['vtot_em'] = $vtotem;
		$data_pasien_iri['vtot_pa'] = $vtotpa;
		$data_pasien_iri['vtot_obat'] = $vtotresep;
		// $data_pasien_iri['vtot_usg']=$vtotusg;
		$data_pasien_iri['denda_terlambat'] = $vtotdenda;
		$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
		// $data_pasien_iri['biaya_alkes']=$total_alkes;
		$data_pasien_iri['biaya_alkes'] = 0; //untuk sementara
		// $data_pasien_iri['vtot_ruang']=$vtotruang;
		$data_pasien_iri['vtot_ruang'] = 0; //untuk sementar
		$data_pasien_iri['biaya_daftar'] = $biaya_daftar;
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if ($this->input->post('jenis_pembayaran') == "KREDIT") {
			$data_pasien_iri['diskon'] = $diskon;
			// $data_pasien_iri['vtot'] = $grand_total;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		} else {
			$data_pasien_iri['diskon'] = $diskon;
		}
		// $data_pasien_iri['vtot'] = $grand_total;
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');
		$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
		$data_pasien_iri['pngobatan'] = $this->input->post('total_obat');
		$data_pasien_iri['lunas'] = 1;
		//if(($pasien[0]['carabayar'] == "KERJASAMA") && ($pasien[0]['titip'] == NULL)){
		$data_pasien_iri['lunas'] = 0;
		$data_pasien_iri['tunai'] = $this->input->post('dibayar_tunai');
		$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
		$data_pasien_iri['total_bayar'] = $this->input->post('dibayar_tunai') + $diskon;
		$data_pasien_iri['anamakwitansi'] = $penerima;

		$datas['tunai'] = $this->input->post('dibayar_tunai');
		$datas['diskon'] = $diskon;
		$datas['no_kk'] = $no_kartu_kredit;
		$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		$datas['persen_kk'] = $charge;
		$datas['jenis_bayar'] = $jenis_pembayaran;
		$datas['asal'] = $idrg;
		// }
		// else if(($pasien[0]['carabayar'] == "BPJS") && ($pasien[0]['klsiri'] != 'VIP') && ($pasien[0]['titip'] == NULL || $pasien[0]['titip'] == '1')) {
		// 	$data_pasien_iri['tunai'] = $dibayar_tunai;
		// 	$data_pasien_iri['total_bayar'] = $dibayar_tunai+$diskon;
		// 	$data_pasien_iri['totalcshare'] = $dibayar_tunai;
		// 	$data_pasien_iri['anamakwitansi'] = $penerima;
		// 	$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
		// 	$data_pasien_iri['kd_inacbg_jatah'] = $this->input->post('kode_inacbg');

		// 	$datas['tunai'] = $dibayar_tunai;
		// 	$datas['diskon'] = $diskon;
		// 	$datas['no_kk'] = $no_kartu_kredit;
		// 	$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		// 	$datas['persen_kk'] = $charge;
		// 	$datas['jenis_bayar'] = $jenis_pembayaran;
		// 	$datas['asal'] = $pasien[0]['nmruang'];
		// } else if((($pasien[0]['carabayar'] == "BPJS") && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == NULL)) || (($pasien[0]['carabayar'] == "BPJS") && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == '1'))){
		// 	$data_pasien_iri['tunai'] = $dibayar_tunai3;
		// 	$data_pasien_iri['total_bayar'] = $dibayar_tunai3+$diskon;
		// 	$data_pasien_iri['totalcshare'] = $dibayar_tunai3;
		// 	$data_pasien_iri['anamakwitansi'] = $penerima;
		// 	$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
		// 	$data_pasien_iri['kd_inacbg_jatah'] = $this->input->post('kode_inacbg');

		// 	$datas['tunai'] = $dibayar_tunai3;
		// 	$datas['diskon'] = $diskon;
		// 	$datas['no_kk'] = $no_kartu_kredit;
		// 	$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		// 	$datas['persen_kk'] = $charge;
		// 	$datas['jenis_bayar'] = $jenis_pembayaran;
		// 	$datas['asal'] = $pasien[0]['nmruang'];
		// }else if(($pasien[0]['carabayar'] == "UMUM") && ($pasien[0]['titip'] == NULL)){
		// 	$data_pasien_iri['tunai'] = $dibayar_tunai1;
		// 	$data_pasien_iri['total_bayar'] = $dibayar_tunai1+$diskon;
		// 	$data_pasien_iri['anamakwitansi'] = $penerima;

		// 	$datas['tunai'] = $dibayar_tunai1;
		// 	$datas['diskon'] = $diskon;
		// 	$datas['no_kk'] = $no_kartu_kredit;
		// 	$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		// 	$datas['persen_kk'] = $charge;
		// 	$datas['jenis_bayar'] = $jenis_pembayaran;
		// 	$datas['asal'] = $pasien[0]['nmruang'];
		// } else if(($pasien[0]['carabayar'] == 'UMUM' || $pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == '1')) {
		// 	$data_pasien_iri['tunai'] = $dibayar_tunai5;
		// 	$data_pasien_iri['total_bayar'] = $dibayar_tunai5+$diskon;
		// 	$data_pasien_iri['anamakwitansi'] = $penerima;

		// 	$datas['tunai'] = $dibayar_tunai5;
		// 	$datas['diskon'] = $diskon;
		// 	$datas['no_kk'] = $no_kartu_kredit;
		// 	$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		// 	$datas['persen_kk'] = $charge;
		// 	$datas['jenis_bayar'] = $jenis_pembayaran;
		// 	$datas['asal'] = $pasien[0]['nmruang'];
		// }
		$this->rjmkwitansi->update_pembayaran_nokwitansi($kwitansi['idno_kwitansi'], $datas);
		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_em_terbayar($no_ipd);
		if ($pasien[0]['carabayar'] == 'BPJS') {
			// $this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'],date("Y:m:d H:i"),$data_pasien_iri['lunas']);
			$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'], date("Y-m-d H:i"), $data_pasien_iri['lunas']);
		}
		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_ipd;
		$datares['rm_no'] = $pasien[0]['no_medrec'];
		$datares['pasien_name'] = $pasien[0]['nama'];
		$datares['dob'] = $pasien[0]['tgl_lahir'];
		$datares['gender'] = $pasien[0]['sex'];
		$datares['gol_darah'] = $pasien[0]['goldarah'];
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		$datares['nama_dokter'] = $pasien[0]['nm_dokter'];
		$datares['trx_no'] = $kwitansi['no_kwitansi'];
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		// if(($pasien[0]['carabayar'] == "KERJASAMA") && ($pasien[0]['titip'] == NULL)){
		$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai');
		// } else if(($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] != 'VIP') && ($pasien[0]['titip'] == NULL || $pasien[0]['titip'] == '1')){
		// 	$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai');
		// } else if((($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == NULL)) || (($pasien[0]['carabayar']=='BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == '1'))){
		// 	$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai3');
		// } else if(($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == NULL)){
		// 	$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai1');
		// } else if(($pasien[0]['carabayar'] == 'UMUM' || $pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == '1')) {
		// 	$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai5');
		// }
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Rawat Inap';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$datares['method_pay'] = $jenis_pembayaran;
		$datares['component_id'] = $idrg;
		//var_dump($datares['component_id']);die();	
		$this->rjmkwitansi->insert_registrasi($datares);

		if($this->input->post('ket_impas') == 'impas') {
			redirect(base_url('iri/ricstatus/cetak_list_pembayaran_pasien/' . $no_ipd . '/7/' . $kwitansi['no_kwitansi']));
		} else {
			redirect(base_url('iri/ricstatus/cetak_list_pembayaran_pasien/' . $no_ipd . '/1/' . $kwitansi['no_kwitansi']));
		}
	}

	public function kalkulasi_harga()
	{
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$dibayar_tunai = $this->input->post('dibayar_tunai');
		$total_gabungan = $this->input->post('total_gabungan');

		$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		$charge = $this->input->post('charge');
		$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = 0; //40000;
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');
		$grand_total = $this->input->post('biaya_total');

		$subsidi_total = 0;

		$kasir = $this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$data10['tunai'] = '0';
		$data10['no_kk'] = '0';
		$data10['nilai_kkd'] = '0';
		$data10['persen_kk'] = '0';
		$data10['diskon'] = '0';
		

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$idrg = $this->rimpasien->get_recent_idrg_patient($no_ipd)->row()->idrg;
		$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd);
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_pa_pasien = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
		$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
		$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd); //belum ada no_register
		$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd);
		$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$vtot_ruang = $result['subtotal'];
		}

		$biaya_kamar = $grand_total;
		$vtot_tindakan = 0;
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtot_tindakan = $result['subtotal'];
		}

		//radiologi
		$vtotrad = 0;
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi($list_radiologi);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotrad = $result['subtotal'];
		}

		//elektromedik
		$vtotem = 0;
		if (($list_elektromedik)) {
			$result = $this->string_table_elektromedik($list_elektromedik);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotem = $result['subtotal'];
		}

		//operasi
		$vtotok = 0;
		if (($list_ok_pasien)) {
			$result = $this->string_table_operasi($list_ok_pasien);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotok = $result['subtotal'];
		}

		//operasi
		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			// $grand_total = $grand_total + $result['subtotal'];
			$vtotok += $result['subtotal'];
		}

		//pa
		$vtotpa = 0;
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotpa = $result['subtotal'];
		}

		//lab
		$vtotlab = 0;
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotlab = $result['subtotal'];
		}

		//resep
		$vtotresep = 0;
		if (($list_resep)) {
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotresep = $result['subtotal'];
		}

		if ($jenis_pembayaran == 'PIUTANG/IKS') {
			$data_piutang['no_register'] = $no_ipd;
			$data_piutang['jns_kwitansi'] = 'Rawat Inap';
			$data_piutang['total_tagihan'] = (int)$total_gabungan;
			$data_piutang['created_date'] = date('Y-m-d h:i:s');
			$data_piutang['created_by'] = $user;
			$data_piutang['nama'] = $pasien[0]['nama'];
			$data_piutang['medrec'] = $pasien[0]['no_medrec'];
			$data_piutang['asal'] = 'RI';
			$data_piutang['cara_bayar'] = $pasien[0]['carabayar'];
			$this->rimtindakan->insert_header_piutang($data_piutang);

			$data_pasien_iri['vtot'] = $vtot_tindakan;
			$data_pasien_iri['vtot_piutang'] = (int)$total_gabungan;
			$data_pasien_iri['vtot_ok'] = $vtotok;
			$data_pasien_iri['vtot_lab'] = $vtotlab;
			$data_pasien_iri['vtot_rad'] = $vtotrad;
			$data_pasien_iri['vtot_em'] = $vtotem;
			$data_pasien_iri['vtot_pa'] = $vtotpa;
			$data_pasien_iri['vtot_obat'] = $vtotresep;
			$data_pasien_iri['denda_terlambat'] = $vtotdenda;
			$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
			$data_pasien_iri['biaya_alkes'] = 0;
			$data_pasien_iri['vtot_ruang'] = 0;
			$data_pasien_iri['biaya_daftar'] = $biaya_daftar;
			$data_pasien_iri['xuser'] = $login_data->username;
			$data_pasien_iri['diskon'] = $diskon;
			$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
			$data_pasien_iri['remark'] = $this->input->post('remark');
			$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
			$data_pasien_iri['pngobatan'] = $this->input->post('total_obat');
			$data_pasien_iri['piutang'] = 1;
			$data_pasien_iri['tunai'] = $this->input->post('dibayar_tunai');
			$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
			$data_pasien_iri['total_bayar'] = $this->input->post('dibayar_tunai') + $diskon;
			$data_pasien_iri['anamakwitansi'] = $penerima;
			$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
			$this->rimpasien->flag_kwintasi_rad_piutang($no_ipd);
			$this->rimpasien->flag_kwintasi_lab_piutang($no_ipd);
			$this->rimpasien->flag_kwintasi_obat_piutang($no_ipd);
			$this->rimpasien->flag_kwintasi_em_piutang($no_ipd);
			if ($pasien[0]['carabayar'] == 'BPJS') {
				$this->rimpasien->flag_irj_piutang($pasien[0]['noregasal']);
			}
			redirect(base_url('iri/rickwitansi'));
		} else {

			$login_data = $this->load->get_var("user_info");
			$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');
			$kwitansi['no_register'] = $no_ipd;
			if ($cek_no_kwitansi) {
				$no_kwitansi = substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
				$kwitansi['no_kwitansi'] = 'RI' . date('y') . '-' . sprintf("%06d", $no_kwitansi);
				$kwitansi['idno_kwitansi'] = sprintf("%06d", $no_kwitansi);
			} else {
				$kwitansi['no_kwitansi'] = 'RI' . date('y') . '-00001';
				$kwitansi['idno_kwitansi'] = 1;
			}
			$kwitansi['jenis_kwitansi'] = 'RI';
			$kwitansi['user_cetak'] = $login_data->username;
			$kwitansi['tgl_cetak'] = date('Y-m-d H:i:s');
			$kwitansi['vtot_bayar'] = $this->input->post('biaya_total');
			$kwitansi['tunai'] = $this->input->post('dibayar_tunai');
			$kwitansi['jenis_bayar'] = $this->input->post('jenis_pembayaran');
			$kwitansi['asal'] = $idrg;
			$this->rimpasien->insert_no_kwitansi($kwitansi);
			

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd);
			$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
			$data_pasien_iri['vtot'] = $vtot_tindakan;
			//update status cetak kwitansi
			$data_pasien_iri['cetak_kwitansi'] = 1;
			$data_pasien_iri['vtot_piutang'] = $subsidi_total;
			$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
			$data_pasien_iri['vtot_ok'] = $vtotok;
			$data_pasien_iri['vtot_lab'] = $vtotlab;
			$data_pasien_iri['vtot_rad'] = $vtotrad;
			$data_pasien_iri['vtot_em'] = $vtotem;
			$data_pasien_iri['vtot_pa'] = $vtotpa;
			$data_pasien_iri['vtot_obat'] = $vtotresep;
			// $data_pasien_iri['vtot_usg']=$vtotusg;
			$data_pasien_iri['denda_terlambat'] = $vtotdenda;
			$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
			// $data_pasien_iri['biaya_alkes']=$total_alkes;
			$data_pasien_iri['biaya_alkes'] = 0; //untuk sementara
			// $data_pasien_iri['vtot_ruang']=$vtotruang;
			$data_pasien_iri['vtot_ruang'] = 0; //untuk sementar
			$data_pasien_iri['biaya_daftar'] = $biaya_daftar;
			$data_pasien_iri['xuser'] = $login_data->username;
			//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
			if ($this->input->post('jenis_pembayaran') == "KREDIT") {
				$data_pasien_iri['diskon'] = $diskon;
				// $data_pasien_iri['vtot'] = $grand_total;
				// tambahan kredit //
				$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
				// end tambahan kredit //
			} else {
				$data_pasien_iri['diskon'] = $diskon;
			}
			// $data_pasien_iri['vtot'] = $grand_total;
			$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
			$data_pasien_iri['remark'] = $this->input->post('remark');
			$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
			$data_pasien_iri['pngobatan'] = $this->input->post('total_obat');
			$data_pasien_iri['lunas'] = 1;
			$data_pasien_iri['lunas'] = 0;
			$data_pasien_iri['tunai'] = $this->input->post('dibayar_tunai');
			$data_pasien_iri['kd_inacbg'] = $this->input->post('kode_inacbg');
			$data_pasien_iri['total_bayar'] = $this->input->post('dibayar_tunai') + $diskon;
			$data_pasien_iri['anamakwitansi'] = $penerima;

			$datas['tunai'] = $this->input->post('dibayar_tunai');
			$datas['diskon'] = $diskon;
			$datas['no_kk'] = $no_kartu_kredit;
			$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
			$datas['persen_kk'] = $charge;
			$datas['jenis_bayar'] = $jenis_pembayaran;
			$datas['asal'] = $idrg;
			if ($jenis_pembayaran == 'split') {
				$datas['cash'] = (int)$this->input->post('biaya_cash');
				$datas['noncash'] = (int)$this->input->post('biaya_non_cash');
			} else {
				$datas['cash'] = 0;
				$datas['noncash'] = 0;
			}
			
			$this->rjmkwitansi->update_pembayaran_nokwitansi($kwitansi['idno_kwitansi'], $datas);
			$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
			$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
			$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
			$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
			$this->rimpasien->flag_kwintasi_em_terbayar($no_ipd);
			if ($pasien[0]['carabayar'] == 'BPJS') {
				$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'], date("Y-m-d H:i"), $data_pasien_iri['lunas']);
			}
			$datares['reg_date'] = date('Y-m-d');
			$datares['reg_no'] = $no_ipd;
			$datares['rm_no'] = $pasien[0]['no_medrec'];
			$datares['pasien_name'] = $pasien[0]['nama'];
			$datares['dob'] = $pasien[0]['tgl_lahir'];
			$datares['gender'] = $pasien[0]['sex'];
			$datares['gol_darah'] = $pasien[0]['goldarah'];
			$datares['jenis_pelayanan_id'] = 1;
			$datares['jenis_transaksi'] = 1;
			$datares['payment_tp'] = 2;
			$datares['nama_dokter'] = $pasien[0]['nm_dokter'];
			$datares['trx_no'] = $kwitansi['no_kwitansi'];
			$datares['paid_flag'] = 0;
			$datares['cancel_flag'] = 0;
			$datares['is_cancel'] = 0;
			$datares['payment_bill'] = (int)$this->input->post('dibayar_tunai');
			$datares['cancel_nominal'] = 0;
			$datares['retur_nominal'] = 0;
			$datares['retur_flag'] = 0;
			$datares['new_payment_bill'] = 0;
			$datares['additional1'] = 'Rawat Inap';
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';
			$datares['method_pay'] = $jenis_pembayaran;
			$datares['component_id'] = $idrg;
			$this->rjmkwitansi->insert_registrasi($datares);

			redirect(base_url('iri/ricstatus/cetak_list_pembayaran_pasien/' . $no_ipd . '/1/' . $kwitansi['no_kwitansi']));
		}
	}


	public function cetak_list_pembayaran_pasien_($no_ipd = '', $status = '', $no_kwitansi = '')
	{

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data_kwitansi = $this->rimtindakan->get_data_kwitansi($no_ipd)->row();
		//var_dump($data_kwitansi); die();
		//$selisihbayar = $this->rimpasien->get_tarif_inacbg()->result();
		//$tarif = $this->input->post('tarif');
		//$pasienn = $this->Fmrekap->get_rekap_faktur_iri();
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);

		if ($status == '0') {
			$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);

			// print_r($list_tindakan_pasien);die(); 

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong


			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);

			$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
			$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
			$list_resep = $this->rimpasien->get_list_resep_iri($no_ipd);
			//$list_resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
				$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
				$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
				$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
				$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
				$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}


			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";


			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				//tindakan
				// var_dump($);die();
				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_sementara($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_sementara($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//elekromedik
				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_sementara($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_sementara($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Tindakan Operasi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					//
					$vtotok = $result['subtotal'];
				}

				//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_sementara($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				// resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_sementara($list_resep_ird, $pasien[0]['tuslah']);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
						</tr>
					</table><br/>			
				";
			//mutasi ruangan pasien
			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan_sementara($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			//tindakan
			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_sementara($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_sementara($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//elekromedik
			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik_sementara($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_sementara($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			//operasi
			if (($list_matkes_ok_pasien)) {
				$result = $this->string_table_operasi_sementara($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];


				$vtotok += $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}


			//lab
			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_sementara($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_sementara($list_resep, $pasien[0]['tuslah']);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}
			//$fixs_adm=40000*$selisih_hari;

			// $fixs_adm= $grand_total* 7/100;
			$fixs_adm = 0;
			//$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
			$konten = $konten . "
		
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				
				";

			//$grand_total = (double) $grand_total + (double) $fixs_adm - (double) $diskon;
			// + (double) $pasien[0]['jasaperawat'] + 6000 + (double) $pasien[0]['biaya_daftar']

			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;

			//	print_r($konten0);die();

			$konten = $konten0 . $konten;
		} else if ($status == '2') {
			$list_tindakan_pasien = $this->rimpasien->get_rekap_tindakan_pasien($no_ipd)->result();
			$list_visite = $this->rimpasien->get_rekap_tindakan_pasien_visite($no_ipd)->result();
			// print_r($list_tindakan_pasien);die(); 

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong

			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);

			$list_ok_pasien = $this->rimpasien->get_list_ok_iri_rekap($no_ipd)->result();
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri_rekap($no_ipd)->result();
			$list_radiologi = $this->rimpasien->get_list_rad_iri_rekap($no_ipd)->result();
			$list_elektromedik = $this->rimpasien->get_list_em_iri_rekap($no_ipd)->result();
			$list_resep = $this->rimpasien->get_list_resep_iri_rekap($no_ipd)->result();
			//$list_resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();

			if ($pasien[0]['noregasal'] != '') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_rekap($pasien[0]['noregasal'])->result();
				//var_dump($list_tindakan_ird);die();
				$list_ok_ird = $this->rimpasien->get_list_ok_ird_rekap($pasien[0]['noregasal'])->result();
				$list_em_ird = $this->rimpasien->get_list_em_ird_rekap($pasien[0]['noregasal'])->result();
				$list_rad_ird = $this->rimpasien->get_list_rad_ird_rekap($pasien[0]['noregasal'])->result();
				$list_lab_ird = $this->rimpasien->get_list_lab_ird_rekap($pasien[0]['noregasal'])->result();
				$list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap($pasien[0]['noregasal'])->result();
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}


			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";


			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				//tindakan
				// var_dump($);die();
				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//elekromedik
				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_rekap($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Tindakan Operasi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					//
					$vtotok = $result['subtotal'];
				}

				//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_rekap($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				//resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_rekap($list_resep_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
						</tr>
					</table><br/>			
				";
			//mutasi ruangan pasien
			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan_sementara($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			//tindakan

			if (($list_visite)) {
				$result = $this->string_table_visite_faktur_rekap($list_visite);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_rekap($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_rekap($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//elekromedik
			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik_rekap($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_rekap($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			//operasi
			if (($list_matkes_ok_pasien)) {
				$result = $this->string_table_operasi_sementara($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];


				$vtotok += $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}


			//lab
			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_rekap($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_rekap($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}
			//$fixs_adm=40000*$selisih_hari;

			// $fixs_adm= $grand_total* 7/100;
			$fixs_adm = 0;
			//$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
			$konten = $konten . "
		
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				
				";

			//$grand_total = (double) $grand_total + (double) $fixs_adm - (double) $diskon;
			// + (double) $pasien[0]['jasaperawat'] + 6000 + (double) $pasien[0]['biaya_daftar']

			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;

			//	print_r($konten0);die();

			$konten = $konten0 . $konten;
		} else if ($status == '6') {
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong

			if (($data_paket)) {
				$status_paket = 1;
			}

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_rekap_cetak($pasien[0]['noregasal'])->result();
				$list_em_ird = $this->rimpasien->get_list_em_ird_rekap_cetak($pasien[0]['noregasal'])->result();
				$list_rad_ird = $this->rimpasien->get_list_rad_ird_rekap_cetak($pasien[0]['noregasal'])->result();
				$list_lab_ird = $this->rimpasien->get_list_lab_ird_rekap_cetak($pasien[0]['noregasal'])->result();
				// $list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap_cetak($pasien[0]['noregasal'])->result();
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}

			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";

			$konten = "";
			$konten0 = "";

			$konten0 = $konten0 . '<style type=\"text/css\">
				.table-isi th{
					border-bottom: 1px solid #ddd;
				} .table-isi td{
					border-bottom: 1px solid #ddd;
				}
				</style>';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>";

				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}

				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotrad = $result['subtotal'];
				}

				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotem = $result['subtotal'];
				}

				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_rekap($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotlab = $result['subtotal'];
				}
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}

			$konten = $konten . "<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">";

			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;

			$konten = $konten0 . $konten;
		} else if ($status == '3') {
			$list_tindakan_pasien = $this->rimpasien->get_rekap_tindakan_pasien($no_ipd)->result();
			$list_visite = $this->rimpasien->get_rekap_tindakan_pasien_visite($no_ipd)->result();

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong

			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_ok_iri_rekap($no_ipd)->result();
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri_rekap($no_ipd)->result();
			$list_radiologi = $this->rimpasien->get_list_rad_iri_rekap($no_ipd)->result();
			$list_elektromedik = $this->rimpasien->get_list_em_iri_rekap($no_ipd)->result();
			$list_resep = $this->rimpasien->get_list_resep_iri_rekap($no_ipd)->result();

			if ($pasienold[0]['id_poli'] != '') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_rekap($pasien[0]['noregasal'])->result();
				// var_dump($list_tindakan_ird);die();
				$list_ok_ird = $this->rimpasien->get_list_ok_ird_rekap($pasien[0]['noregasal'])->result();
				$list_em_ird = $this->rimpasien->get_list_em_ird_rekap($pasien[0]['noregasal'])->result();
				$list_rad_ird = $this->rimpasien->get_list_rad_ird_rekap($pasien[0]['noregasal'])->result();
				$list_lab_ird = $this->rimpasien->get_list_lab_ird_rekap($pasien[0]['noregasal'])->result();
				$list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap($pasien[0]['noregasal'])->result();
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}


			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";

			$konten = "";
			$konten0 = "";

			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] != '') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_rekap($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Tindakan Operasi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					//
					$vtotok = $result['subtotal'];
				}

				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_rekap($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				//resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_rekap($list_resep_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
						</tr>
					</table><br/>			
				";

			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan_rekap_iks($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			if (($list_visite)) {
				$result = $this->string_table_visite_faktur_rekap($list_visite);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_rekap($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_rekap_iks($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik_rekap_iks($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_rekap_iks($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_rekap_iks($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_rekap($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}

			$konten = $konten . "<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">";
			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;
			$konten = $konten0 . $konten;
		} else if ($status == '4') {
			$list_tindakan_pasien = $this->rimpasien->get_rekap_tindakan_pasien_iks_jatah($no_ipd)->result();
			$list_visite = $this->rimpasien->get_rekap_tindakan_pasien_visite_iks_jatah($no_ipd)->result();

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong

			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_ok_iri_rekap($no_ipd)->result();
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri_rekap($no_ipd)->result();
			$list_radiologi = $this->rimpasien->get_list_rad_iri_rekap($no_ipd)->result();
			$list_elektromedik = $this->rimpasien->get_list_em_iri_rekap($no_ipd)->result();
			$list_resep = $this->rimpasien->get_list_resep_iri_rekap($no_ipd)->result();

			if ($pasienold[0]['id_poli'] != '') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_rekap($pasien[0]['noregasal'])->result();
				//var_dump($list_tindakan_ird);die();
				$list_ok_ird = $this->rimpasien->get_list_ok_ird_rekap($pasien[0]['noregasal'])->result();
				$list_em_ird = $this->rimpasien->get_list_em_ird_rekap($pasien[0]['noregasal'])->result();
				$list_rad_ird = $this->rimpasien->get_list_rad_ird_rekap($pasien[0]['noregasal'])->result();
				$list_lab_ird = $this->rimpasien->get_list_lab_ird_rekap($pasien[0]['noregasal'])->result();
				$list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap($pasien[0]['noregasal'])->result();
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}

			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";

			$konten = "";
			$konten0 = "";

			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] != '') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_rekap($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Tindakan Operasi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					//
					$vtotok = $result['subtotal'];
				}

				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_rekap($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				//resep
				// $vtotresep=0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_rekap($list_resep_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
						</tr>
					</table><br/>			
				";

			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan_rekap_iks_jatah($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			if (($list_visite)) {
				$result = $this->string_table_visite_faktur_rekap_iks_jatah($list_visite);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_rekap_iks_jatah($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_rekap_iks_jatah($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik_rekap_iks_jatah($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_rekap_iks_jatah($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_rekap_iks_jatah($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_rekap($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}

			$konten = $konten . "<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">";
			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;
			$konten = $konten0 . $konten;
		} else if ($status == '5') {
			$list_tindakan_pasien = $this->rimpasien->get_rekap_tindakan_pasien_jatah($no_ipd)->result();
			$list_visite = $this->rimpasien->get_rekap_tindakan_pasien_visite_jatah($no_ipd)->result();

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong

			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);

			$list_ok_pasien = $this->rimpasien->get_list_ok_iri_rekap($no_ipd)->result();
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri_rekap($no_ipd)->result();
			$list_radiologi = $this->rimpasien->get_list_rad_iri_rekap($no_ipd)->result();
			$list_elektromedik = $this->rimpasien->get_list_em_iri_rekap($no_ipd)->result();
			$list_resep = $this->rimpasien->get_list_resep_iri_rekap($no_ipd)->result();
			//$list_resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_rekap($pasien[0]['noregasal'])->result();
				//var_dump($list_tindakan_ird);die();
				$list_ok_ird = $this->rimpasien->get_list_ok_ird_rekap($pasien[0]['noregasal'])->result();
				$list_em_ird = $this->rimpasien->get_list_em_ird_rekap($pasien[0]['noregasal'])->result();
				$list_rad_ird = $this->rimpasien->get_list_rad_ird_rekap($pasien[0]['noregasal'])->result();
				$list_lab_ird = $this->rimpasien->get_list_lab_ird_rekap($pasien[0]['noregasal'])->result();
				$list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap($pasien[0]['noregasal'])->result();
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}

			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";

			$konten = "";
			$konten0 = "";

			$konten0 = $konten0 . '<style type=\"text/css\">
				.table-isi th{
					border-bottom: 1px solid #ddd;
				}.table-isi td{
					border-bottom: 1px solid #ddd;
				}
				</style>';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				//tindakan
				// var_dump($);die();
				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//elekromedik
				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_rekap($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Tindakan Operasi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					//
					$vtotok = $result['subtotal'];
				}

				//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_rekap($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				//resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_rekap($list_resep_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			$konten = $konten . "		
				<table class=\"table-isi\" border=\"0\">
					<tr>
						<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
					</tr>
				</table><br/>";

			//mutasi ruangan pasien
			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan_jatah_kelas($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			//tindakan

			if (($list_visite)) {
				$result = $this->string_table_visite_faktur_rekap_jatah($list_visite);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_rekap_jatah($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_rekap_jatah($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//elekromedik
			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik_rekap_jatah($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_rekap_jatah($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_rekap_jatah($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_rekap($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}

			$fixs_adm = 0;
			//$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
			$konten = $konten . "
		
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">";

			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;

			$konten = $konten0 . $konten;
		} else {
			$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);

			// print_r($list_tindakan_pasien);die(); 

			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			// print_r($list_dokter);die();	
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			// print_r($list_mutasi_pasien);die();
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong


			if (($data_paket)) {
				$status_paket = 1;
			}


			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
			$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
			$list_resep = $this->rimpasien->get_list_resep_iri($no_ipd);
			$resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();
			//var_dump($resep->vtot_obat);die();

			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
				$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
				$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
				$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
				$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
				$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}


			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";


			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;
			//mutasi ruangan pasien
			if (($list_mutasi_pasien)) {
				$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
				$grand_total = $grand_total + $result['subtotal'];
				$jasa_total = $jasa_total + $result['jasaperawat'];
				$selisih_hari = $result['selisihhari'];

				$ceknull = $result['ceknull'];
				$mutasicount = $mutasicount + 1;
				$konten = $konten . $result['konten'];
			}
			$biaya_kamar = $grand_total;

			//tindakan
			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//elekromedik
			$vtotem = 0;
			if (($list_elektromedik)) {
				$result = $this->string_table_elektromedik($list_elektromedik);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//
				$vtotok = $result['subtotal'];
			}

			//operasi
			if (($list_matkes_ok_pasien)) {
				$result = $this->string_table_operasi($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];


				$vtotok += $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//pa
			$vtotpa = 0;
			if (($list_pa_pasien)) {
				$result = $this->string_table_pa($list_pa_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Patologi Anatomi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				$vtotpa = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			//lab
			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			//resep
			$vtotresep = 0;
			if (($resep)) {
				$result = $this->string_table_resep($list_resep, $pasien[0]['tuslah']);

				$result = $this->string_table_resep($resep, $pasien[0]['tuslah']);

				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}


			if ($pasienold[0]['id_poli'] == 'BA00') {
				// 	$konten = $konten."		
				// 		<br>
				// 		<table class=\"table-isi\" border=\"0\">
				// 			<tr>
				// 				<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
				// 			</tr>
				// 		</table>			
				// 	";

				// 	//tindakan
				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					//print_r($konten);exit;
				}

				// 	//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					// 		/*$konten = $konten."
					// 		<tr>
					// 			<td colspan=\"3\">Total Pembayaran Radiologi</td>
					// 			<td>Rp. ".number_format($result['subtotal'],0)."</td>
					// 		</tr>
					// 		";*/
					$vtotrad = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				// 	//elekromedik
				$vtotem = 0;
				if (($list_em_ird)) {
					$result = $this->string_table_elektromedik_ird($list_em_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
					$vtotem = $result['subtotal'];
					//$konten = $konten.$result['konten'];
				}

				// 	//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					// 		/*$konten = $konten."
					// 		<tr>
					// 			<td colspan=\"3\">Total Tindakan Operasi</td>
					// 			<td>Rp. ".number_format($result['subtotal'],0)."</td>
					// 		</tr>
					// 		";*/
					// 		//
					$vtotok = $result['subtotal'];
				}

				// 	//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];

					$vtotlab = $result['subtotal'];
					// $konten = $konten.$result['konten'];
				}

				// 	//resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep($list_resep_ird, $pasien[0]['tuslah']);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}
			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}
			//$fixs_adm=40000*$selisih_hari;

			// $fixs_adm= $grand_total* 7/100;
			$fixs_adm = 0;
			//$totalselisih = $this->input->post('totalselisih');
			//$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
			$konten = $konten . "
			<br>
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				";

			//$grand_total = (double) $grand_total + (double) $fixs_adm;
			// + (double) $pasien[0]['jasaperawat'] + 6000 + (double) $pasien[0]['biaya_daftar']

			$konten0 = $this->string_data_pasien_faktur($pasien, $grand_total, "", '', $no_kwitansi) . $konten0;

			//	print_r($konten0);die();

			$konten = $konten0 . $konten;
		}

		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');

		$cterbilang = new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;


		$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}


		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->name);
		$userid = $login_data->userid;
		$ttd_2 = $this->rimtindakan->get_list_tindakan_pelayanan_iri($no_ipd)->row()->ttd_pelaksana;
		$ttd = $this->rimpasien->get_ttd_by_login($userid)->row()->ttd;
		//var_dump($ttd);die();
		/*<tr>
					<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
					<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
				</tr>*/
		if ($status == '0' || $status == '2' || $status == '6') {
			$span = '6';
			$span1 = '2';

			if (($pasien[0]['carabayar'] == 'UMUM' && $pasien[0]['titip'] == NULL) || ($pasien[0]['carabayar'] == 'UMUM' && $pasien[0]['titip'] == '1')) {

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\"></td>
				// 		</tr>
			} else if (($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == NULL) || ($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == '1')) {
				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\"></td>
				//</tr>
			} else if (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] != 'VIP') && ($pasien[0]['titip'] == NULL)) {
				if (!empty($data_kwitansi)) {
					$tarif_kls = $data_kwitansi->tarif_kls_inacbg;
					$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_kls = 0;
					$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
								<tr>
									<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Kelas INA-CBG</b></p></th>
									<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_kls) . "</p></th>
								</tr>
								<tr>
									<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Jatah Kelas INA-CBG</b></p></th>
									<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_jatah) . "</p></th>
								</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\" width=\"50px;\" height=\"50px;\"></td>
				// 		</tr>
			} else if ((($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == NULL)) || (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == '1'))) {
				if (!empty($list_mutasi_pasien)) {
					foreach ($list_mutasi_pasien as $r) {
						//$diff = 1;
						if ($r['tglkeluarrg'] != null) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($r['tglkeluarrg']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							//echo $diff." Hari"; 
						} else {
							if ($data_pasien[0]['tgl_keluar'] != NULL) {
								$start = new DateTime($r['tglmasukrg']); //start
								$end = new DateTime($data_pasien[0]['tgl_keluar']); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
								//echo $diff." Hari"; 
							} else {
								$start = new DateTime($r['tglmasukrg']); //start
								$end = new DateTime(date("Y-m-d")); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}

								//echo $diff." Hari"; 
							}
						}
					}
				}
				if ($diff <= 3) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>30%</p></th>";
				} else if (($diff > 3) & ($diff <= 7)) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>50%</p></th>";
				} else if ($diff > 7) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>75%</p></th>";
				}

				if (!empty($data_kwitansi)) {
					$tarif_kls = $data_kwitansi->tarif_kls_inacbg;
					//$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_kls = 0;
					//$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif INA-CBG Kelas I</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_kls) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Presentase Tarif VIP (" . $diff . " Hari)</b></p></th>
								$tarif
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\" width=\"10px;\" height=\"10px;\"></td>
				// 		</tr>
			} else if (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['titip'] == '1') && ($pasien[0]['klsiri'] != 'VIP')) {
				if (!empty($data_kwitansi)) {
					$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
					//$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_jatah = 0;
					//$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Jatah Kelas INA-CBG</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_jatah) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\"></td>
				// 		</tr>
			}
		} else if ($status == '5') {
			$span = '6';
			$span1 = '2';

			if (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] != 'VIP') && ($pasien[0]['titip'] == NULL)) {
				if (!empty($data_kwitansi)) {
					$tarif_kls = $data_kwitansi->tarif_kls_inacbg;
					$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_kls = 0;
					$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
								<tr>
									<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Kelas INA-CBG</b></p></th>
									<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_kls) . "</p></th>
								</tr>
								<tr>
									<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Jatah Kelas INA-CBG</b></p></th>
									<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_jatah) . "</p></th>
								</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\" width=\"50px;\" height=\"50px;\"></td>
				// 		</tr>
			} else if ((($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == NULL)) || (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['klsiri'] == 'VIP') && ($pasien[0]['titip'] == '1'))) {
				if (!empty($list_mutasi_pasien)) {
					foreach ($list_mutasi_pasien as $r) {
						//$diff = 1;
						if ($r['tglkeluarrg'] != null) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($r['tglkeluarrg']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							//echo $diff." Hari"; 
						} else {
							if ($data_pasien[0]['tgl_keluar'] != NULL) {
								$start = new DateTime($r['tglmasukrg']); //start
								$end = new DateTime($data_pasien[0]['tgl_keluar']); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
								//echo $diff." Hari"; 
							} else {
								$start = new DateTime($r['tglmasukrg']); //start
								$end = new DateTime(date("Y-m-d")); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}

								//echo $diff." Hari"; 
							}
						}
					}
				}
				if ($diff <= 3) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>30%</p></th>";
				} else if (($diff > 3) & ($diff <= 7)) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>50%</p></th>";
				} else if ($diff > 7) {
					$tarif = "<th colspan=\"" . $span1 . "\" align=\"right\"><p>75%</p></th>";
				}

				if (!empty($data_kwitansi)) {
					$tarif_kls = $data_kwitansi->tarif_kls_inacbg;
					//$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_kls = 0;
					//$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif INA-CBG Kelas I</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_kls) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Presentase Tarif VIP (" . $diff . " Hari)</b></p></th>
								$tarif
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\" width=\"10px;\" height=\"10px;\"></td>
				// 		</tr>
			} else if (($pasien[0]['carabayar'] == 'BPJS') && ($pasien[0]['titip'] == '1') && ($pasien[0]['klsiri'] != 'VIP')) {
				if (!empty($data_kwitansi)) {
					$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
					//$tarif_jatah = $data_kwitansi->tarif_jatahkls_inacbg;
				} else {
					$tarif_jatah = 0;
					//$tarif_jatah = 0;
				}

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Tarif Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Jatah Kelas INA-CBG</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($tarif_jatah) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Bayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['totalcshare']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					";
				// <tr>
				// 			<td align=\"center\"></td>
				// 			<td align=\"center\"><img src=\"".$ttd."\"></td>
				// 		</tr>
			}
		} else if ($status == '3') {
			$span = '6';
			$span1 = '2';

			$grand_total_string = "	<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Kelas Rawat</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
						<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon'], 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
					</tr>
				</table>
				<br/><br>
				<table style=\"width: 100%;\" width=\"100%\">
					<tr>
						<td style=\"width: 50%;\"></td>
						<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
					</tr>
					<tr>
						<td align=\"center\">Pasien</td>
						<td align=\"center\">$user</td>
					</tr>
				</table>";
		} else if ($status == '4') {
			$span = '6';
			$span1 = '2';

			$grand_total_string = "	<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Jatah Kelas Rawat</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
						<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon'], 0) . "</p></th>
					</tr>
					<tr>
						<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
						<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
					</tr>
				</table>
				<br/><br>
				<table style=\"width: 100%;\" width=\"100%\">
					<tr>
						<td style=\"width: 50%;\"></td>
						<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
					</tr>
					<tr>
						<td align=\"center\">Pasien</td>
						<td align=\"center\">$user</td>
					</tr>
				</table>";
		} else {
			$span = '7';
			$span1 = '1';

			if ($pasien[0]['carabayar'] == 'BPJS') {
				if ($pasien[0]['jatahklsiri'] == 'I' && $pasien[0]['klsiri'] == 'VIP') {
					$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 1</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
				} else if (($pasien[0]['jatahklsiri'] == 'II' && $pasien[0]['klsiri'] == 'VIP') || ($pasien[0]['jatahklsiri'] == 'II' && $pasien[0]['klsiri'] == 'I')) {
					$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 1</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 2</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls2_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
				} else {
					$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Jatah Kelas</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls2_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
				}
			} else {
				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
			}
		}

		$konten = $konten . $grand_total_string;
		//return $konten;
		ob_clean();
		// flush();
		//  header("Content-type:application/pdf");
		// header("Content-Disposition:attachment;filename='downloaded.pdf'");
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $konten;
		//$this->mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}

	private function cetak_list_pembayaran_pasien_new(){
		/**
		 * Data yang dibutuhkan : 
		 * 
		*{
		*	"terimadari":"",
		*	"namapasien":"",
		*	"umur":"",
		*	"alamat":"",
		*	"tglmasuk":"",
		*	"nomedrec_register":"",
		*	"carabayar":"",
		*	"tglkeluar":"",
		*	"totaltarif":"",
		*	"visitedankonsul":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakanlaboratorium":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakanradiologi":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakanrehabmedik":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakanpenunjang":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"akomodasi":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakankeperawatan":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"tindakanoperasi":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"bmhp":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"sewaalat":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"pelayanandarah":{
		*		"igd":[],
		*		"rawatinap":[]
		*	},
		*	"resepfarmasi":{
		*		"igd":[],
		*		"rawatinap":[]
		*	}
		*}
		 **/

		$no_ipd = base64_decode($this->input->get('q'));
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd_new($no_ipd);
		$data_kwitansi = $this->rimtindakan->get_data_kwitansi($no_ipd)->row();
		$pasienold = $this->rimtindakan->get_old_pasien($pasien->noregasal);
		$list_tindakan_pasien = $this->rimpasien->get_rekap_tindakan_pasien($no_ipd)->result();
		$list_visite = $this->rimpasien->get_rekap_tindakan_pasien_visite($no_ipd)->result();
		$data = [
			'no_ipd'=>$pasien->no_ipd,
			'terimadari'=>$pasien->anamakwitansi,
			'namapasien'=>$pasien->nama,
			'umur'=>$pasien->nmruang,
			'alamat'=>$pasien->alamat,
			'tglmasuk'=>$pasien->tgl_masuk,
			'nomedrec_register'=>$pasien->no_cm.'/'.$pasien->no_ipd,
			'carabayar'=>$pasien->carabayar,
			'tglkeluar'=>$pasien->tgl_keluar,
			'umur'=>$pasien->birth_date,
			'titip'=>$pasien->titip,
			'totaltarif'=>0,
			'tgl_keluar_resume'=>$pasien->tgl_keluar_resume,
			'tgl_masuk'=>$pasien->tgl_masuk,
			'visitedankonsul'=>[
				'igd'=>$this->rimpasien->get_list_visite_ird($pasien->noregasal),
				'rawatinap'=>$this->rimpasien->get_rekap_tindakan_pasien_visite($no_ipd)->result()
			],
			'tindakanlaboratorium'=>[
				// 'igd'=>$this->rimpasien->get_list_lab_ird($pasien->noregasal),
				'igd'=>$this->rimpasien->get_list_lab_urutan($pasien->noregasal),
				// 'rawatinap'=>$this->rimpasien->get_list_lab_iri($no_ipd)
				'rawatinap'=>$this->rimpasien->get_list_lab_urutan($no_ipd)
			],
			'tindakanradiologi'=>[
				'igd'=>$this->rimpasien->get_list_rad_ird($pasien->noregasal),
				'rawatinap'=>$this->rimpasien->get_list_rad_iri($no_ipd)
			],
			'tindakanrehabmedik'=>[
				'igd'=>$this->rimpasien->get_list_rehab_ird($pasien->noregasal),
				'rawatinap'=>$this->rimtindakan->get_list_rehab_pasien_by_no_ipd($no_ipd)
			],
			'akomodasi'=>[
				'igd'=>[],
				'rawatinap'=>$this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd)
			],
			'tindakankeperawatan'=>[
				'igd'=>$this->rimpasien->get_list_perawat_ird($pasien->noregasal),
				'rawatinap'=>$this->rimtindakan->get_list_perawat_pasien_by_no_ipd($no_ipd)
			],
			'bmhp' => [
				'igd' => $this->rimpasien->get_list_bmhp_ird($pasien->noregasal),
				'rawatinap' => $this->rimpasien->get_list_bmhp_iri($no_ipd)
			],
			'alat' => [
				'igd' => $this->rimpasien->get_list_alat_ird($pasien->noregasal),
				'rawatinap' => $this->rimpasien->get_list_alat_iri($no_ipd)
			],
			'darah' => [
				'igd' => $this->rimpasien->get_list_pelayanan_darah_ird($pasien->noregasal),
				'rawatinap' => $this->rimpasien->get_list_pelayanan_darah_iri($no_ipd)
			],
			'tindakanoperasi'=>[
				'igd'=>$this->rimpasien->get_list_ok_ird($pasien->noregasal),
				'rawatinap'=>$this->rimpasien->get_list_ok_iri_rekap($no_ipd)->result()
			],
			'resepfarmasi'=>[
				'igd'=>$this->rimpasien->get_list_resep_iri_rekap($pasien->noregasal)->result(),
				//'igd'=>$this->rimpasien->get_list_resep_ird($pasien->noregasal),
				//'rawatinap'=>$this->rimpasien->get_list_resep_iri($no_ipd)
				'rawatinap'=>$this->rimpasien->get_list_resep_iri_rekap($no_ipd)->result()
			],
			'tindakanelektromedik'=>[
				'igd'=>$this->rimpasien->get_list_em_ird($pasien->noregasal),
				'rawatinap'=>$this->rimpasien->get_list_em_iri($no_ipd)
			]
		];
		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';
		// die();
		$html = $this->load->view('iri/cetak_kwitansi_new',$data,true);
		// echo $html;
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function cetak_list_pembayaran_pasien($no_ipd = '', $status = '', $no_kwitansi = '')
	{
		if($this->input->get()){
			$this->cetak_list_pembayaran_pasien_new();
			return;
		} 
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data_kwitansi = $this->rimtindakan->get_data_kwitansi($no_ipd)->row();
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);

		if ($status == '0') {
			$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong
			if (($data_paket)) {
				$status_paket = 1;
			}

			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_ok_iri_billing($no_ipd);
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
			$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
			$list_resep = $this->rimpasien->get_list_resep_iri($no_ipd);
			$list_utdrs = $this->rimpasien->get_list_utdrs_iri($no_ipd);
			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
				$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
				$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
				$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
				$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
				$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
				$list_utd_ird = $this->rimpasien->get_list_utd_ird($pasien[0]['noregasal']);
			} else {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
				$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
				$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
				$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
				$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
				$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
				$list_utd_ird = array();
			}


			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";
			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '<br/>';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;

			
				$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
						</tr>
					</table><br/>			
				";

				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur_sementara($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}

				//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird_sementara($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotrad = $result['subtotal'];
				}

				//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird_sementara($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotok = $result['subtotal'];
				}

				//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird_sementara($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotlab = $result['subtotal'];
					
				}

				//resep
				$vtotresep = 0;
				if (($list_resep_ird)) {
					$result = $this->string_table_resep_sementara($list_resep_ird, $pasien[0]['tuslah']);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}

				//utd
				$vtotutdrs = 0;
				if (($list_utd_ird)) {
					$result = $this->string_table_utdrs_sementara($list_utd_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
				}

				
			

			$konten = $konten . "		
					<table class=\"table-isi\" border=\"0\">
						<tr>
							<td colspan=\"8\"><b>Tindakan Rawat Inap</b></td>
						</tr>
					</table><br/>			
				";
			//mutasi ruangan pasien
			// if (($list_mutasi_pasien)) {
			// 	$result = $this->string_table_mutasi_ruangan_sementara($list_mutasi_pasien, $pasien, $status_paket);
			// 	$grand_total = $grand_total + $result['subtotal'];
			// 	$jasa_total = $jasa_total + $result['jasaperawat'];
			// 	$selisih_hari = $result['selisihhari'];

			// 	$ceknull = $result['ceknull'];
			// 	$mutasicount = $mutasicount + 1;
			// 	$konten = $konten . $result['konten'];
			// }
			// $biaya_kamar = $grand_total;

			//tindakan
			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur_sementara($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];

				$konten = $konten . $result['konten'];
			
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi_sementara($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotrad = $result['subtotal'];
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi_sementara($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotok = $result['subtotal'];
			}

			//operasi
			if (($list_matkes_ok_pasien)) {
				$result = $this->string_table_operasi_sementara($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotok += $result['subtotal'];
			}


			//lab
			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab_sementara($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotlab = $result['subtotal'];
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep_sementara($list_resep, $pasien[0]['tuslah']);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}

			//utdrs
			$vtotutdrs = 0;
			if (($list_utdrs)) {
				$result = $this->string_table_utdrs_sementara($list_utdrs);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
			}


			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}
			$fixs_adm = 0;
			$konten = $konten . "
		
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				
				";
			$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;
			$konten = $konten0 . $konten;
		} else if($status == '7'){
			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";
			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$grand_total = 0;

			$konten = $konten . "
			<br>
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				";
			$konten0 = $this->string_data_pasien_faktur($pasien, $grand_total, "", '', $no_kwitansi) . $konten0;
			$konten = $konten0 . $konten;

			$list_prosedur_non_bedah = $this->rimtindakan->get_prosedur_non_bedah($no_ipd)->result_array();
			$list_prosedur_bedah = $this->rimtindakan->get_prosedur_bedah($no_ipd)->result_array();
			$list_konsultasi = $this->rimtindakan->get_konsultasi($no_ipd)->result_array();
			$list_tenaga_ahli = $this->rimtindakan->get_tenaga_ahli($no_ipd)->result_array();
			$list_keperawatan = $this->rimtindakan->get_keperawatan($no_ipd)->result_array();
			$list_penunjang = $this->rimtindakan->get_keperawatan($no_ipd)->result_array();
			$list_akomodasi = $this->rimtindakan->get_akomodasi($no_ipd)->result_array();
			$list_radiologi = $this->rimtindakan->get_rad($no_ipd)->result_array();
			$list_laboratorium = $this->rimtindakan->get_labor($no_ipd)->result_array();
			$list_resep = $this->rimtindakan->get_resep($no_ipd);
			$list_pelayanan_darah = $this->rimtindakan->get_unitdarah($no_ipd)->result_array();
			$list_rehabilitasi = $this->rimtindakan->get_rehabilitasi($no_ipd)->result_array();
			$list_rewat_intensif = $this->rimtindakan->get_rawat_intensif($no_ipd)->result_array();



			//prosedur non bedah //13 dan null
			if (($list_prosedur_non_bedah)) {
				$result = $this->string_table_tindakan_faktur_prosedur_non_bedah($list_prosedur_non_bedah);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_prosedur_non_bedah = $result['subtotal'];
				
			}

			//prosedur bedah // OK
			if (($list_prosedur_bedah)) {
				$result = $this->string_table_tindakan_faktur_prosedur_bedah($list_prosedur_bedah);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_prosedur_bedah = $result['subtotal'];
				
			}

			//konsultasi // 6
			if (($list_konsultasi)) {
				$result = $this->string_table_tindakan_faktur_konsultasi($list_konsultasi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_konsultasi = $result['subtotal'];
				
			}

			//tenaga ahli // 1
			if (($list_tenaga_ahli)) {
				$result = $this->string_table_tindakan_faktur_tenaga_ahli($list_tenaga_ahli);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_tenaga_ahli = $result['subtotal'];
				
			}

			//keperawatan // 11
			if (($list_keperawatan)) {
				$result = $this->string_table_tindakan_faktur_keperawatan($list_keperawatan);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_keperawatan = $result['subtotal'];
				
			}

			//Penunjang // 5
			if (($list_penunjang)) {
				$result = $this->string_table_tindakan_faktur_penunjang($list_penunjang);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_penunjang = $result['subtotal'];
				
			}

			//akomodasi // 8
			if (($list_akomodasi)) {
				$result = $this->string_table_tindakan_faktur_akomodasi($list_akomodasi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_akomodasi = $result['subtotal'];
				
			}

			//rad
			if (($list_radiologi)) {
				$result = $this->string_table_tindakan_faktur_rad($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_rad = $result['subtotal'];
				
			}

			//labor
			if (($list_laboratorium)) {
				$result = $this->string_table_tindakan_faktur_lab($list_laboratorium);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_lab = $result['subtotal'];
				
			}

			//resep
			if (($list_resep)) {
				$result = $this->string_table_tindakan_faktur_resep($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_resep = $result['subtotal'];
				
			}

			//unit darah
			if (($list_pelayanan_darah)) {
				$result = $this->string_table_tindakan_faktur_unit_darah($list_pelayanan_darah);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_darah = $result['subtotal'];
				
			}

			//rehabilitasi
			if (($list_rehabilitasi)) {
				$result = $this->string_table_tindakan_faktur_rehabilitasi($list_rehabilitasi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_rehab = $result['subtotal'];
				
			}

			//Rawat Intensif
			if (($list_rewat_intensif)) {
				$result = $this->string_table_tindakan_faktur_rawat_intensif($list_rewat_intensif);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$biaya_intensif = $result['subtotal'];
				
			}
		
			$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
			$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong
			if (($data_paket)) {
				$status_paket = 1;
			}
			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
			$list_pa_pasien = "";
			$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
			$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
			$list_resep = $this->rimpasien->get_list_resep_iri($no_ipd);
			$resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();
			if ($pasienold[0]['id_poli'] == 'BA00') {
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
				$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
				$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
				$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
				$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
				$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
			} else {
				$list_tindakan_ird = array();
				$list_ok_ird = array();
				$list_em_ird = array();
				$list_rad_ird = array();
				$list_lab_ird = array();
				$list_resep_ird = array();
			}
			$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
			$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";


			$konten = "";
			$konten0 = "";


			$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

			$konten = $konten . '';

			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount = 0;
			$ceknull = 0;
			$jasa_total = 0;
			//mutasi ruangan pasien
			// if (($list_mutasi_pasien)) {
			// 	$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			// 	$grand_total = $grand_total + $result['subtotal'];
			// 	$jasa_total = $jasa_total + $result['jasaperawat'];
			// 	$selisih_hari = $result['selisihhari'];

			// 	$ceknull = $result['ceknull'];
			// 	$mutasicount = $mutasicount + 1;
			// 	$konten = $konten . $result['konten'];
			// }
			// $biaya_kamar = $grand_total;

			//tindakan
			if (($list_tindakan_pasien)) {
				$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
				$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
				$total_alkes = $total_alkes + $result['subtotal_alkes'];
				$konten = $konten . $result['konten'];
				$biaya_tind = $result['subtotal'];
				
			}

			//radiologi
			$vtotrad = 0;
			if (($list_radiologi)) {
				$result = $this->string_table_radiologi($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotrad_ri = $result['subtotal'];
				
			}

			//operasi
			$vtotok = 0;
			if (($list_ok_pasien)) {
				$result = $this->string_table_operasi($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotok = $result['subtotal'];
			}

			//operasi
			if (($list_matkes_ok_pasien)) {
				$result = $this->string_table_operasi($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotok += $result['subtotal'];
			}

			//lab
			$vtotlab = 0;
			if (($list_lab_pasien)) {
				$result = $this->string_table_lab($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotlab_ri = $result['subtotal'];
				
			}

			//resep
			$vtotresep = 0;
			if (($list_resep)) {
				$result = $this->string_table_resep($list_resep, $pasien[0]['tuslah']);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				$vtotresep_ri = $result['subtotal'];
			}

			if ($pasienold[0]['id_poli'] == 'BA00') {
				if (($list_tindakan_ird)) {
					$result = $this->string_table_tindakan_ird_faktur($list_tindakan_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$biaya_tind_igd = $result['subtotal'];
				}

				//radiologi
				$vtotrad = 0;
				if (($list_rad_ird)) {
					$result = $this->string_table_radiologi_ird($list_rad_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotrad = $result['subtotal'];
				}

				//operasi
				$vtotok = 0;
				if (($list_ok_ird)) {
					$result = $this->string_table_operasi_ird($list_ok_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotok = $result['subtotal'];
				}

				//lab
				$vtotlab = 0;
				if (($list_lab_ird)) {
					$result = $this->string_table_lab_ird($list_lab_ird);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . $result['konten'];
					$vtotlab = $result['subtotal'];
				}

				//resep
				$vtotresep=0;
				if(($list_resep_ird)){
					$result = $this->string_table_resep($list_resep_ird, $pasien[0]['tuslah']);
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten.$result['konten'];
					$vtotresep = $result['subtotal'];

				}

			}

			if ($status == '0') {
				$span = '7';
			} else {
				$span = '7';
			}
			$fixs_adm = 0;
			$konten = $konten . "
			<br>
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				";
			$konten0 = $this->string_data_pasien_faktur($pasien, $grand_total, "", '', $no_kwitansi) . $konten0;
			$konten = $konten0 . $konten;
		}

		
		$tgl = date('d F Y');

		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;
		$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->name);
		//  var_dump($login_data);die();
		$userid = $login_data->userid;
		$ttd_2 = $this->rimtindakan->get_list_tindakan_pelayanan_iri($no_ipd)->row()->ttd_pelaksana;
		$ttd = $this->rimpasien->get_ttd_by_login($userid)->row()->ttd;
		
		if ($status == '0') {
			$span = '6';
			$span1 = '2';
			$ttd_wen = $this->rjmkwitansi->get_ttd_wen()->row();
			$ttd_dir = $this->rjmkwitansi->get_ttd_dir()->row();
		

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Total Umum</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Biaya Adminstrasi</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($fixs_adm, 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Denda</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Potongan</b></p></th>
								<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['diskon'], 0) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Tanah Badantuang, $tgl</td>
							</tr>
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\"><img width=\"120px\" src=".$ttd_wen->ttd."></td>
							</tr>
							<tr>
								<td align=\"center\"></td>
								<td align=\"center\">Wenny Sayori, A.Md</td>
							</tr>
						</table>
					";
				
		}else if($status == '7'){

			$span = '6';
			$span1 = '2';

		

				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Prosedur Non Bedah</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_prosedur_non_bedah) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Prosedur Bedah</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_prosedur_bedah) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Konsultasi</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_konsultasi) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tenaga Ahli</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_tenaga_ahli) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Keperawatan</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_keperawatan) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Penunjang</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_penunjang) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Radiologi</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_rad) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Laboratorium</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_lab) . "</p></td>
							</tr>

							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Pelayanan Darah</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_darah) . "</p></td>
							</tr>

							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Rehabilitasi</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_rehab) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Kamar/Akomodasi</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_akomodasi) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Rawat Intensif</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_intensif) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Obat</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_resep) . "</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Obat Kronis</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. 0</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Obat Kemoterapi</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. 0</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Alkes</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. 0</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>BMHP</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. 0</p></td>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Sewa Alat</b></p></th>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. 0</p></td>
							</tr>

							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><br></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><br></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($grand_total) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Tanah Badantuang, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>
					"; 
		}else {
			$span = '7';
			$span1 = '1';
			$ttd_wen = $this->rjmkwitansi->get_ttd_wen()->row();
			$ttd_dir = $this->rjmkwitansi->get_ttd_dir()->row();
			
				$grand_total_string = "	
						

							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Poli/IGD</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"></th>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p> Tindakan</p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_tind_igd) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Radiologi</p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotrad) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Laboratoium </p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotlab) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Resep </p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotresep) . "</p></td>
							</tr>

							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Rawat Inap</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"></th>
							</tr>

						

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p> Tindakan</p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($biaya_tind) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Radiologi</p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotrad_ri) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Laboratoium </p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotlab_ri) . "</p></td>
							</tr>

							<tr>
								<td colspan=\"" . $span . "\" align=\"left\"><p>Resep </p></td>
								<td align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($vtotresep_ri) . "</p></td>
							</tr>



							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><br></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><br></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>

						


						<br/><br>
						<hr>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Tanah Badantuang, $tgl</td>
							</tr>

							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Pemimpin BLUD</td>
							</tr>

							<tr>
								<td style=\"width: 50%;\" align=\"center\"><img width=\"120px\" src=".$ttd_wen->ttd."></td>
								<td style=\"width: 50%;\" align=\"center\"><img width=\"120px\" src=".$ttd_dir->ttd."></td>
							</tr>

							<tr>
								<td style=\"width: 50%;\" align=\"center\">( Wenny Sayori, A.Md )</td>
								<td style=\"width: 50%;\" align=\"center\">( dr. Reyantis Capanay)</td>
							</tr>

							


							
						</table>
						
						</div>
						
						";
			
		}

		$konten = $konten . $grand_total_string;
		//return $konten;
		ob_clean();
		// flush();
		//  header("Content-type:application/pdf");
		// header("Content-Disposition:attachment;filename='downloaded.pdf'");
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $konten;
		// echo $html;
		//$this->mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}

	public function cetak_list_pembayaran_pasien_simple3()
	{
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		$vtotdenda = $this->input->post('denda');
		$obat = $this->input->post('biaya_obat');
		$dibayar_tunai = (int)$this->input->post('dibayar_tunai') + (int)$this->input->post('denda');
		$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		$charge = $this->input->post('charge');
		$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = 0; //40000;
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');

		$kasir = $this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket'] = $kasir->kasir;
		$nomor = $this->rjmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
		$data9['no_kwitansi'] = sprintf("%08d", ($nomor->no_kwitansi + 1));
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data9['xuser'] = $user;
		$data9['xcreate'] = date('Y-m-d H:i:s');
		$data9['no_register'] = $no_ipd;
		$data9['nama_poli'] = 'RI';
		$cek = $this->rjmkwitansi->insert_nokwitansi($data9);

		$data10['tunai'] = '0';
		$data10['no_kk'] = '0';
		$data10['nilai_kkd'] = '0';
		$data10['persen_kk'] = '0';
		$data10['diskon'] = '0';
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'], $data10);

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if (!($diskon) || $diskon == '') {
			$diskon = 0;
		}

		if (!($vtotdenda) || $vtotdenda == '') {
			$vtotdenda = 0;
		}

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		//print_r($no_ipd);
		//kamari
		// if($pasien[0]['cetak_kwitansi'] != '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwintasi Harus Dicetak Terlebih Dahulu <button type="button" 
		// onclick="'.$string_close_windows.'">Kembali</button>';
		// 	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien_kelompok = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd_newest($no_ipd, 'kelompok');
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd_newest($no_ipd, 'lainnya');
		//$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);

		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd_newest($no_ipd);

		$list_tindakan_alat = $this->rimtindakan->get_list_alat_pasien_by_no_ipd($no_ipd, 1);
		$list_tindakan_alat_hide = $this->rimtindakan->get_list_alat_pasien_by_no_ipd($no_ipd, 0);

		$list_tindakan_perawat_ruang_pasien = $this->rimtindakan->get_list_tindakan_perawat_ruang_pasien_by_no_ipd($no_ipd);
		//matkes ruang

		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$list_lokasi_pasien = $this->rimpasien->get_list_lokasi_mutasi_pasien($no_ipd);
		//Ruang ICU VK
		$list_tindakan_ruang_pasien = $this->rimtindakan->get_list_ruang_pasien_by_no_ipd($no_ipd);
		//$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd($no_ipd);

		//oksigen
		$list_oksigen = $this->rimtindakan->get_list_oksigen_pasien_by_no_ipd_newest($no_ipd);

		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}

		if ($pasien[0]['carabayar'] == 'BPJS') {
			$list_ok = $this->rimpasien->get_list_ok_pasien_newest($no_ipd, $pasien[0]['noregasal']);
			$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register

			//usg
			$list_usg_radiologi = $this->rimpasien->get_list_usg_pasien($no_ipd, $pasien[0]['noregasal']);

			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj_dokter_kelompok = $this->rimpasien->get_list_poli_rj_dokter_pasien_kelompok($pasien[0]['noregasal'], 'kelompok');
			$poli_irj_dokter = $this->rimpasien->get_list_poli_rj_dokter_pasien_kelompok($pasien[0]['noregasal'], '');
			$poli_irj_perawat = $this->rimpasien->get_list_poli_rj_perawat_pasien($pasien[0]['noregasal']);
		} else {
			//echo 'masuk';die();
			$list_lab_pasien = $this->rimpasien->get_list_all_lab_pasien($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_all_radiologi_pasien($no_ipd);
			$list_pa_pasien = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
			$list_usg_radiologi = $this->rimpasien->get_list_all_usg_pasien($no_ipd);
			$list_ok = $this->rimpasien->get_list_all_ok_pasien($no_ipd);
			$list_resep = $this->rimpasien->get_list_all_resep_pasien($no_ipd);
			$poli_irj_dokter_kelompok = $this->rimpasien->get_list_poli_rj_dokter_pasien_kelompok($pasien[0]['noregasal'], 'kelompok');
			$poli_irj_dokter = $this->rimpasien->get_list_poli_rj_dokter_pasien_kelompok($pasien[0]['noregasal'], '');
			$poli_irj_perawat = $this->rimpasien->get_list_poli_rj_perawat_pasien($pasien[0]['noregasal']);
		}




		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . " .pdf";

		$konten = "";
		$konten0 = "";

		$konten0 = $konten0 . '<style type=\"text/css\">
		
			.table-isi th{
			border-bottom: 1px solid #ddd;
			}
			.table-isi td{
			border-bottom: 1px solid #ddd;
			}
			</style>
		<br><br><br><table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount = 0;
		$vtotruang = 0;
		$ceknull = 0;
		$jasa_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			$selisih_hari = $result['selisihhari'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$vtotruang = $result['subtotal_ruang'];
			$vtoticu = $result['subtotal_icu'];
			$ceknull = $result['ceknull'];
			$mutasicount = $mutasicount + 1;
			$konten = $konten . $result['konten'];
		}
		$jasa_perawat = $jasa_total;

		$lama_inap = 0;
		$start = new DateTime($pasien[0]['tglmasukrg']); //start
		$end = new DateTime(); //end

		$diff = $end->diff($start)->format("%a");
		if ($diff == 0) {
			$diff = 1;
		}
		$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
		if ($ceknull != 0) {
			$detailjasa = $this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();
			$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
			if ($pasien[0]['nmruang'] == 'ICU') {
				$jasa_perawat1 = (float)$total_per_kamar * ((float)20 / 100);
			} else
				$jasa_perawat1 = (float)$total_per_kamar * ((float)$detailjasa->persen_jasa / 100);
		}
		$jasa_perawat = $jasa_perawat + $jasa_perawat1;
		//$data_pasien_iri['jasa_perawat'] = $jasa_perawat;

		$matkes = 0;
		$biaya_kamar = $grand_total;

		//operasi		
		if (($list_ok)) {
			$result = $this->string_table_operasi_kw($list_ok);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotok = $result['subtotal'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			$konten = $konten . $result['konten'];
		}


		$vtotmedis = 0;
		if (($list_tindakan_dokter_pasien_kelompok)) {
			$result = $this->string_table_tindakan_dokter_kw($list_tindakan_dokter_pasien_kelompok);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$vtotmedis = $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			/*$konten = $konten."
			 <tr>
			 	<td>Total Pembayaran Tindakan Ruangan Anyelir</td>
			 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			 </tr>
			";*/
			$konten = $konten . $result['konten'];
			//print_r($konten);exit;
		}
		if (($list_tindakan_dokter_pasien)) {
			$result = $this->string_table_tindakan_dokter_kw($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$vtotmedis = $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			/*$konten = $konten."
			 <tr>
			 	<td>Total Pembayaran Tindakan Ruangan Anyelir</td>
			 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			 </tr>
			";*/
			$konten = $konten . $result['konten'];
			//print_r($konten);exit;
		}

		//echo $konten;		
		//$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd($no_ipd);
		//$list_tindakan_vk_pasien = $this->rimtindakan->get_list_tindakan_vk_pasien_by_no_ipd($no_ipd);		

		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"6\">Total Pembayaran Rawat Darurat</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}*/
		//irj
		// if(($poli_irj_dokter_kelompok) or ($poli_irj_dokter)){
		// 	$konten= $konten.'
		// 	<table class="table-isi" border="0">
		// 		<tr>
		// 	  	<td colspan="3" align="center" > Tindakan IRJ</td>
		// 	  	<td colspan="3" align="left">Dokter</td>
		// 	  	<td colspan="2" align="center"></td>
		// 	</tr>		
		// 	';

		// 	$result = $this->string_table_irj_kw($poli_irj_dokter, $poli_irj_dokter_kelompok);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// 	$konten = $konten."
		// 	<tr>
		// 		<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
		// 		<td>Rp. ".number_format($result['subtotal'],0)."</td>
		// 	</tr>
		// 	";
		// 	$konten = $konten.$result['konten'];

		// 	$konten = $konten."</table>";
		// }
		// if(($poli_irj_perawat)){
		// 	$result = $this->string_table_irj($poli_irj_perawat);
		// 	if((int)$result['subtotal']!=0){
		// 		$grand_total = $grand_total + $result['subtotal'];				
		// 		$konten = $konten."
		// 		<table class=\"table-isi\" border=\"0\">
		// 		<tr>
		// 			<td colspan=\"7\">Tindakan Perawat Rawat Jalan</td>
		// 			<td align=\"right\"> ".number_format($result['subtotal'],0)." </td>
		// 		</tr>
		// 		</table>
		// 		";
		// 	}

		// 	$konten = $konten.$result['konten'];
		// }
		$konten = $konten . "<br><br>";
		//radiologi
		// $vtotrad=0;
		// if(($list_radiologi)){
		// 	$result = $this->string_table_radiologi($list_radiologi);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten."<table class=\"table-isi\" border=\"0\">
		// 	<tr>
		// 		<td colspan=\"6\">Total Pembayaran Radiologi</td>
		// 		<td colspan=\"2\" align=\"right\">".number_format($result['subtotal'],0)."</td>
		// 	</tr></table>
		// 	";
		// 	$vtotrad=$result['subtotal'];
		// 	//$konten = $konten.$result['konten'];
		// }

		//usg
		$vtotusg = 0;
		if (($list_usg_radiologi)) {
			$result = $this->string_table_radiologi($list_usg_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotusg = $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"6\">Total Pembayaran USG Radiologi</td>
				<td colspan=\"2\" align=\"right\">" . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotrad = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//pa
		$vtotpa = 0;
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"6\">Total Pembayaran Patologi Anatomi</td>
				<td colspan=\"2\" align=\"right\">" . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotpa = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		// $vtotlab=0;
		// if(($list_lab_pasien)){
		// 	$result = $this->string_table_lab($list_lab_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten."<table class=\"table-isi\" border=\"0\">
		// 	<tr>
		// 		<td colspan=\"6\" >Total Pembayaran Laboratorium</td>
		// 		<td colspan=\"2\" align=\"right\"> ".number_format($result['subtotal'],0)."</td>
		// 	</tr></table>
		// 	";
		// 	$vtotlab=$result['subtotal'];
		// 	// $konten = $konten.$result['konten'];
		// }

		//resep
		$vtotresep = 0;
		if (($list_resep)) {
			$result = $this->string_table_resep($list_resep, $pasien[0]['tuslah']);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "<table border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Resep</td>
				<td align=\"right\"> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotresep = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		if (($obat)) {
			//$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $obat;
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Apotik</td>
				<td align=\"right\"> " . number_format($obat, 0) . "</td>
			</tr></table>
			";
			$vtotresep = $obat;
			//$konten = $konten.$result['konten'];
		}
		//biaya_administrasi
		//$biaya_administrasi= (double) $grand_total * 0.1;
		// $biaya_administrasi=40000*$selisih_hari;
		// if($biaya_administrasi<=50000){
		// 	$fix_adm=40000;
		// }else if($biaya_administrasi>=750000 && $pasien[0]['carabayar']=='UMUM'){
		// 	$fix_adm=$biaya_administrasi;
		// }else{
		// 	$fix_adm=$biaya_administrasi;
		// }

		$fix_adm = 0; //$grand_total* 5/100;


		//1B0103
		$detailtind = $this->rimpasien->get_detail_tindakan('1B0103', $pasien[0]['kelas'])->row();

		//$data['dijamin']=$this->input->post('dijamin');
		$biaya_daftar = (int) $detailtind->total_tarif + (int)$detailtind->tarif_alkes;
		$konten = $konten . "<br><br>
			<table class=\"table-isi\" border=\"0\">";

		/*if((int)$tind_perawat!=0){
			$konten = $konten."<tr >
				<td colspan=\"7\">Tindakan Perawat</td>
				<td align=\"right\"> ".number_format($tind_perawat,0)." </td>
			</tr>";
		}*/
		$tind_perawat = 0;
		//tindakan		

		$kontenB = '';
		if (($list_tindakan_perawat_pasien)) {
			$result = $this->string_table_tindakan_perawat($list_tindakan_perawat_pasien, $list_lokasi_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$vtotmedis = $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			/*$konten = $konten."
			 <tr>
			 	<td>Total Pembayaran Tindakan Ruangan</td>
			 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			 </tr>
			";*/
			$kontenB = $kontenB . $result['konten'];
			//print_r($konten);exit;
		}


		$kontenC = '';
		if (($list_tindakan_alat)) {
			$result = $this->string_table_tindakan_kel_kw($list_tindakan_alat);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			//$vtotmedis=$result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			/*$konten = $konten."
			 <tr>
			 	<td>Total Pembayaran Tindakan Ruangan</td>
			 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			 </tr>
			";*/
			$kontenC = $kontenC . $result['konten'];
		}

		if (($list_tindakan_alat_hide)) {
			$result = $this->string_table_tindakan_kel_kw($list_tindakan_alat_hide);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			//$vtotmedis=$result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal'] + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			/*$konten = $konten."
			 <tr>
			 	<td>Total Pembayaran Tindakan Ruangan</td>
			 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			 </tr>
			";*/
			//$kontenC = $kontenC.$result['konten'];


		}
		//echo (int)$total_alkes!=0;exit;
		if ((int)$total_alkes != 0) {
			$kontenC = $kontenC . "<tr>
				<td colspan=\"7\">Sewa Alat</td>
				<td align=\"right\"><p> " . number_format($total_alkes, 0) . " </p></td>
			</tr>";
		}

		$konten = $konten . $kontenC . $kontenB;

		//$biaya_administrasi= (double) $grand_total * 0.1;
		// $biaya_administrasi=40000*$selisih_hari;
		// if($biaya_administrasi<=50000){
		// 	$fix_adm=40000;
		// }else if($biaya_administrasi>=750000 && $pasien[0]['carabayar']=='UMUM'){
		// 	$fix_adm=$biaya_administrasi;
		// }else{
		// 	$fix_adm=$biaya_administrasi;
		// }
		$fix_adm = 0; //$grand_total* 5/100;


		$konten = $konten . "<tr>
				<td align=\"right\" colspan=\"7\">Total</td>
				<td align=\"right\"> " . number_format($grand_total, 0) . " </td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			
			
			";
		// <tr>
		// 	<td colspan=\"7\">Jasa Keperawatan</td>
		// 	<td align=\"right\"> ".number_format($jasa_perawat,0)." </td>
		// </tr>
		// <tr>
		// 	<td colspan=\"7\">Biaya Materai</td>
		// 	<td align=\"right\"> ".number_format(6000,0)." </td>
		// </tr>
		// <tr>
		// 	<td colspan=\"7\">Biaya Pendaftaran</td>
		// 	<td align=\"right\"> ".number_format($biaya_daftar,0)." </td>
		// </tr>

		$grand_total = (float) $grand_total + (float) $fix_adm;
		// + (double) $jasa_perawat + 6000 + (double) $biaya_daftar
		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;



		$jenis_bayar = $this->input->post('jenis_pembayaran');


		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$konten0 = $this->string_data_pasien_sementara($pasien, $grand_total, "", '') . $konten0;

		$konten = $konten0 . $konten;
		//echo $konten;
		//break;
		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');


		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		$vtot_peserta = $grand_total + $biaya_administrasi;
		// +6000+$biaya_daftar+$jasa_perawat
		//$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}


		/*if($biaya_adm == "" && $status_paket == 0){
			$biaya_adm = $grand_total * 5 / 100;
			$grand_total = $grand_total + $biaya_adm;
		}*/
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		/*<tr>
				<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
				<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
			</tr>*/


		$list_tindakan_pasien = $this->rimtindakan->get_list_sumtindakan_pasien_by_no_ipd($no_ipd);
		$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);

		if ($pasien[0]['carabayar'] == 'BPJS') {
			$list_pa_pasien = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
			$list_lab_pasien = $this->rimpasien->get_list_all_lab_pasien($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_all_radiologi_pasien($no_ipd); //belum ada no_register
			$list_resep = $this->rimpasien->get_list_all_resep_pasien($no_ipd);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		} else {
			// $list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			// $list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			// $list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
			// $list_tindakan_ird = "";
			// $poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		}

		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_kwitansi.pdf";


		$konten = "";
		$konten0 = "";


		$konten0 = $konten0 . '<style type=\"text/css\">
		
			.table-isi th{
			border-bottom: 1px solid #ddd;
			}
			.table-isi td{
			border-bottom: 1px solid #ddd;
			}
			</style>
		<br><br><br><table border="0">';

		$konten = $konten . '<br><br><br>';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount = 0;
		$ceknull = 0;
		$jasa_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			$selisih_hari = $result['selisihhari'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$ceknull = $result['ceknull'];
			$mutasicount = $mutasicount + 1;
			$konten = $konten . $result['konten'];
		}
		$biaya_kamar = $grand_total;

		//tindakan
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten . $result['konten'];
			//print_r($konten);exit;
		}
		$tind_perawat = 0;
		if (($list_tindakan_perawat_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$tind_perawat = $result['subtotal'];
			//print_r($konten);exit;
		}
		$matkes = 0;
		if (($list_tindakan_matkes_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkes = $result['subtotal'];
			//print_r($konten);exit;
		}

		//radiologi
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Radiologi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//operasi
		if (($list_ok_pasien)) {
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//
		}

		//operasi
		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Matkes Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//pa
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Patologi Anatomi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//lab
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Laboratorium</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			// $konten = $konten.$result['konten'];
		}

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep($list_resep, $pasien[0]['tuslah']);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Resep</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//ird
		if (($list_tindakan_ird)) {
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "
			<tr>
				<td colspan=\"6\">Total Pembayaran Rawat Darurat</td>
				<td>Rp. " . number_format($result['subtotal'], 0) . "</td>
			</tr>
			";
			$konten = $konten . $result['konten'];
		}

		//irj
		if ($pasien[0]['carabayar'] != 'UMUM') {
			if (($poli_irj && $poli_irj[0]['id_poli'] == "BA00")) {
				$result = $this->string_table_irj($poli_irj);
				$grand_total = $grand_total + $result['subtotal'];
				//$konten = $konten.$result['konten'];
				$konten = $konten . "
			<tr>
				<td colspan=\"3\">Total Pembayaran Rawat Jalan</td>
				<td>Rp. " . number_format($result['subtotal'], 0) . "</td>
			</tr>
			";
				$konten = $konten . $result['konten'];
			}
		}
		//1B0103
		$detailtind = $this->rimpasien->get_detail_tindakan('1B0103', $pasien[0]['kelas'])->row();

		//$data['dijamin']=$this->input->post('dijamin');<tr>
		//	<td colspan=\"7\">Tindakan Perawat</td>
		//	<td>Rp. ".number_format($tind_perawat,0)."</td>
		//</tr>
		/*<tr>
				<td colspan=\"6\">Matkes Ruang Rawat</td>
				<td>Rp. ".number_format($pasien[0]['matkes_iri'],0)."</td>
			</tr>*/
		if ($status == '0') {
			$span = '7';
		} else {
			$span = '7';
		}
		//$fixs_adm=40000*$selisih_hari;

		$fixs_adm = 0; //$grand_total* 5/100;
		$biaya_daftar = (int) $detailtind->total_tarif + (int)$detailtind->tarif_alkes;
		$konten = $konten . "		
		<table class=\"table-isi\">
			<tr>
				<td colspan=\"" . $span . "\">Sewa Alat</td>
				<td align=\"right\"><p>" . number_format($total_alkes, 0) . "</p></td>
			</tr>
			<tr>
				<td colspan=\"" . $span . "\">Biaya Administrasi</td>
				<td align=\"right\">" . number_format($fixs_adm, 0) . "</td>
			</tr>
			
			";
		// <tr>
		// 	<td colspan=\"".$span."\">Biaya Administrasi</td>
		// 	<td align=\"right\">".number_format($pasien[0]['biaya_administrasi'],0)."</td>
		// </tr>
		// <tr>
		// 	<td colspan=\"".$span."\">Jasa Keperawatan</td>
		// 	<td align=\"right\">".number_format($pasien[0]['jasaperawat'],0)."</td>
		// </tr>
		// <tr>
		// 	<td colspan=\"".$span."\">Biaya Materai</td>
		// 	<td align=\"right\">".number_format(6000,0)."</td>
		// </tr>
		// <tr>
		// 	<td colspan=\"".$span."\">Biaya Pendaftaran</td>
		// 	<td align=\"right\">".number_format($pasien[0]['biaya_daftar'],0)."</td>
		// </tr>

		$grand_total = (float) $grand_total + (float) $fixs_adm;
		// + (double) $pasien[0]['jasaperawat'] + 6000 + (double) $pasien[0]['biaya_daftar']

		$konten0 = $this->string_data_pasien_faktur($pasien, $grand_total, "", '') . $konten0;
		$konten = $konten0 . $konten;

		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');

		$cterbilang = new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;
		// $grand_total_string = "
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Tunai   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['tunai'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['nilai_kkkd'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Charge % </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".$pasien[0]['persen_kk']."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Nominal Charge   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $nomimal_charge, 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Diskon   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['diskon'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Total   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $grand_total-$subsidi_total-$pasien[0]['diskon'], 0)."</p></th>
		// 	</tr>
		// </table>
		// <br/><br/>
		// Terbilang<br>
		// ".strtoupper($vtot_terbilang)."
		// <br/><br/>
		// <table>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>$tgl</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>an.Kepala Rumah Sakit</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>K a s i r</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>----------------------------------------</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>ADMIN</td>
		// 	</tr>
		// </table>
		// ";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}


		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		/*<tr>
				<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
				<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
			</tr>*/
		if ($status == '0') {
			$span = '6';
			$span1 = '2';
		} else {
			$span = '7';
			$span1 = '1';
		}

		$grand_total_string = "	
			<tr>
				<th colspan=\"" . $span . "\"><p><b>Denda Terlambat</b></p></th>
				<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($pasien[0]['denda_terlambat'], 0) . "</p></th>
			</tr>					
			<tr>
				<th colspan=\"" . $span . "\"><p><b>Total Biaya</b></p></th>
				<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total + $pasien[0]['denda_terlambat'], 0) . "</p></th>
			</tr>
			<tr>
				<th colspan=\"" . $span . "\"><p><b>Diskon</b></p></th>
				<th colspan=\"" . $span1 . "\" align=\"right\"><p>" . number_format($diskon, 0) . "</p></th>
			</tr>
			<tr>
				<th colspan=\"" . $span . "\"><p><b>Total Bayar</b></p></th>
				<th align=\"right\" colspan=\"" . $span1 . "\"><p>" . number_format($grand_total + $pasien[0]['denda_terlambat'] - $diskon, 0) . "</p></th>
			</tr>
		</table>
		<br><br><br>
		<table>
			<tr>
				<td colspan=\"3\" align=\" left \">Terbilang : $vtot_terbilang</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><br><br><br><br></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>
		";

		$konten1 = $konten . $grand_total_string;

		// $konten = "";


		// $konten = $konten.$this->string_data_pasien($pasien,0,'');

		// $grand_total = 0;
		// //mutasi ruangan pasien
		// if(($list_mutasi_pasien)){
		// 	$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }


		// //tindakan
		// if(($list_tindakan_pasien)){
		// 	$result = $this->string_table_tindakan($list_tindakan_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];

		// 	$konten = $konten.$result['konten'];
		// 	//print_r($konten);exit;
		// }

		// //radiologi
		// if(($list_radiologi)){
		// 	$result = $this->string_table_radiologi($list_radiologi);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //lab
		// if(($list_lab_pasien)){
		// 	$result = $this->string_table_lab($list_lab_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //resep
		// if(($list_resep)){
		// 	$result = $this->string_table_resep($list_resep);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //ird
		// if(($list_tindakan_ird)){
		// 	$result = $this->string_table_ird($list_tindakan_ird);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		//irj
		// if(($poli_irj)){
		// 	$result = $this->string_table_irj($poli_irj);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// $grand_total_string = '
		// <table border="1">
		// 	<tr>
		// 		<td colspan="6" align="center">Grand Total</td>
		// 		<td align="right">Rp. '.number_format($grand_total,0).'</td>
		// 	</tr>
		// </table>
		// ';

		// $konten = '<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 		

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		//$data_pasien_iri['vtot'] = $grand_total;
		$data_pasien_iri['total'] = $grand_total;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		//$data_pasien_iri['vtot_kamar']=$biaya_kamar;
		//$data_pasien_iri['vtot_icu']=$vtoticu;
		//$data_pasien_iri['vtot_vk']=$vtotvk;
		//$data_pasien_iri['vtot_ok']=$vtotok;
		$data_pasien_iri['vtot_lab'] = $vtotlab;
		$data_pasien_iri['vtot_rad'] = $vtotrad;
		$data_pasien_iri['vtot_pa'] = $vtotpa;
		$data_pasien_iri['vtot_obat'] = $vtotresep;
		$data_pasien_iri['vtot_usg'] = $vtotusg;
		$data_pasien_iri['denda_terlambat'] = $vtotdenda;

		$data_pasien_iri['biaya_alkes'] = $total_alkes;
		//$data_pasien_iri['vtot_ruang']=$vtotruang;
		//$data_pasien_iri['matkes_ok']=$matkesok;
		//$data_pasien_iri['matkes_vk']=$matkesvk;
		$data_pasien_iri['biaya_daftar'] = $biaya_daftar;
		//$data_pasien_iri['matkes_icu']=$matkesicu;

		//$data_pasien_iri['vtot_oksigen']=$vtotoksigen;
		//$data_pasien_iri['vtot_kamaricu']=$vtotkamaricu;
		//$data_pasien_iri['vtot_kamarvk']=$vtotkamarvk;
		$data_pasien_iri['vtot_medis'] = $vtotmedis;
		//$data_pasien_iri['vtot_paramedis']=$vtotparamedis;
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if ($jenis_bayar == "KREDIT") {
			$data_pasien_iri['diskon'] = $diskon;
			$data_pasien_iri['vtot'] = $grand_total;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		} else {
			$data_pasien_iri['diskon'] = $diskon;
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');
		//$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		//$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		//$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['matkes_iri'] = $matkes;
		$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
		$data_pasien_iri['biaya_administrasi'] = $fix_adm;
		//$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if ($pasien[0]['carabayar'] == "DIJAMIN") {
			$data_pasien_iri['lunas'] = 0;
		}

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		$data_pasien_iri['total_bayar'] = $dibayar_tunai + $diskon;

		$datas['tunai'] = $dibayar_tunai;
		$datas['diskon'] = $diskon;
		$datas['no_kk'] = $no_kartu_kredit;
		$datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		$datas['persen_kk'] = $charge;
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'], $datas);
		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		if ($pasien[0]['carabayar'] == 'BPJS') {
			$this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'], date("Y:m:d H:i"), $data_pasien_iri['lunas']);
			$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'], date("Y:m:d H:i"), $data_pasien_iri['lunas']);
		}
		//update ke lab, rad, obat kalo udah pembayaran		
		//echo $konten;
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Kwitansi Rawat Inap - " . $no_ipd . " - " . $pasien[0]['nama'];
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content1 = $konten1;
		ob_end_clean();
		$obj_pdf->writeHTML($content1, true, false, true, false, '');
		// $obj_pdf->AddPage();
		// ob_start();
		// 	$content2 = $konten2;
		// ob_end_clean();
		// $obj_pdf->writeHTML($content2, true, false, true, false, '');
		// $obj_pdf->AddPage();
		// ob_start();
		// 	$content3 = $konten3;
		// ob_end_clean();
		// $obj_pdf->writeHTML($content3, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}


	public function cetak_list_pembayaran_pasien_simple2()
	{
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		$vtotdenda = $this->input->post('denda');
		$obat = $this->input->post('biaya_obat');
		//echo $diskon;
		$dibayar_tunai = (int)$this->input->post('dibayar_tunai') + (int)$this->input->post('denda');
		//$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		//$charge = $this->input->post('charge');
		//$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		//$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if (!($diskon) || $diskon == '') {
			$diskon = 0;
		}

		if (!($vtotdenda) || $vtotdenda == '') {
			$vtotdenda = 0;
		}

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);


		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd_kw($no_ipd);
		//$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);

		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd_kw($no_ipd);

		$list_tindakan_perawat_ruang_pasien = $this->rimtindakan->get_list_tindakan_perawat_ruang_pasien_by_no_ipd($no_ipd);
		//matkes ruang
		$list_tindakan_matkes_pasien = $this->rimtindakan->get_list_tindakan_matkes_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);

		//Ruang ICU VK
		$list_tindakan_ruang_pasien = $this->rimtindakan->get_list_ruang_pasien_by_no_ipd($no_ipd);
		//$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd($no_ipd);


		//new
		//VK
		$list_tindakan_vk_pasien = $this->rimtindakan->get_list_tindakan_vk_pasien_by_no_ipd_kw($no_ipd);
		//ICU
		$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd_new($no_ipd);

		//oksigen
		$list_oksigen = $this->rimtindakan->get_list_oksigen_pasien_by_no_ipd($no_ipd);

		//matkes ICU matkes VK
		$list_tindakan_matkes_icu_pasien = $this->rimtindakan->get_list_tindakan_matkes_icu_pasien_by_no_ipd($no_ipd);
		$list_tindakan_matkes_vk_pasien = $this->rimtindakan->get_list_tindakan_matkes_vk_pasien_by_no_ipd($no_ipd);

		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		$list_ok = $this->rimpasien->get_list_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register

		//usg
		$list_usg_radiologi = $this->rimpasien->get_list_usg_pasien($no_ipd, $pasien[0]['noregasal']);

		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj_dokter = $this->rimpasien->get_list_poli_rj_dokter_pasien($pasien[0]['noregasal']);
		$poli_irj_perawat = $this->rimpasien->get_list_poli_rj_perawat_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . " .pdf";

		$konten = "";
		$konten0 = "";


		$konten0 = $konten0 . '<style type=\"text/css\">
			
			.table-isi th{
			border-bottom: 1px solid #ddd;
			}
			.table-isi td{
			border-bottom: 1px solid #ddd;
			}
			</style>
		<br><br><br><table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount = 0;
		$vtotruang = 0;
		$ceknull = 0;
		$jasa_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];

			$vtotruang = $result['subtotal_ruang'];
			$vtoticu = $result['subtotal_icu'];
			$ceknull = $result['ceknull'];
			$mutasicount = $mutasicount + 1;
			$konten = $konten . $result['konten'];
		}
		$jasa_perawat = $jasa_total;

		$biaya_kamar = $grand_total;
		$vtotkamarvk = 0;
		$list_tindakan_vk_kamar = $this->rimtindakan->get_vk_room($no_ipd);
		$result = $this->string_table_mutasi_ruangan_vk($list_tindakan_vk_kamar, $pasien, $status_paket);
		$vtotkamarvk = $result['subtotalvk'];
		$grand_total = $grand_total + $vtotkamarvk;
		$trvk = $result['konten'];

		//vk
		$vtotvk = 0;
		if (($list_tindakan_vk_pasien)) {
			$result = $this->string_table_vk_kw($list_tindakan_vk_pasien, $trvk, $vtotkamarvk);
			$vtotvk = $vtotvk + $result['subtotal'];
			$grand_total = $grand_total + $result['subtotal'];

			$konten = $konten . $result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}

		//operasi		
		if (($list_ok)) {
			$result = $this->string_table_operasi_kw($list_ok);
			//$grand_total = $grand_total + $result['subtotal'];	
			$vtotok = $result['subtotal'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			$konten = $konten . $result['konten'];
		}

		$vtotok = 0;
		if (($list_ok_pasien)) {
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotok = $result['subtotal'];
		}

		//operasi
		$matkesok = 0;
		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$matkes_ok = $result['subtotal'];
			$matkesok = $result['subtotal'];
		}

		//tindakan
		$vtotmedis = 0;
		if (($list_tindakan_dokter_pasien)) {
			$result = $this->string_table_tindakan_dokter_kw($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$vtotmedis = $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];

			$konten = $konten . $result['konten'];
			//print_r($konten);exit;
		}

		$vtotparamedis = 0;
		if (($list_tindakan_perawat_ruang_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_perawat_ruang_pasien);

			$vtotparamedis = $result['subtotal'];
			//print_r($konten);exit;
		}

		$matkes = 0;
		if (($list_tindakan_matkes_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkes = $result['subtotal'];
			//print_r($konten);exit;
		}

		$matkesicu = 0;
		if (($list_tindakan_matkes_icu_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_matkes_icu_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];

			$matkesicu = $result['subtotal'];
			//print_r($konten);exit;
		}

		$matkesvk = 0;
		if (($list_tindakan_matkes_vk_pasien)) {
			$result = $this->string_table_tindakan($list_tindakan_matkes_vk_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkesvk = $result['subtotal'];
			//print_r($konten);exit;
		}


		//ruang
		$vtotruang = 0;
		if (($list_tindakan_ruang_pasien)) {
			$result = $this->string_table_ruang($list_tindakan_ruang_pasien);
		}

		//icu
		$vtotkamaricu = 0;
		$vtoticu = 0;
		if (($list_tindakan_icu_pasien)) {
			$result = $this->string_table_icu_kw($list_tindakan_icu_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtoticu = $result['subtotal'];

			$konten = $konten . $result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}


		//radiologi
		$vtotrad = 0;
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Radiologi</td>
				<td> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotrad = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//usg
		$vtotusg = 0;
		if (($list_usg_radiologi)) {
			$result = $this->string_table_radiologi($list_usg_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotusg = $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran USG Radiologi</td>
				<td> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotrad = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//pa
		$vtotpa = 0;
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Patologi Anatomi</td>
				<td> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotpa = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		$vtotlab = 0;
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Laboratorium</td>
				<td> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotlab = $result['subtotal'];
			// $konten = $konten.$result['konten'];
		}

		//resep
		$vtotresep = 0;


		if (($obat)) {
			//$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $obat;
			$konten = $konten . "<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\"> Total Pembayaran Resep</td>
				<td align=\"right\"> " . number_format($obat, 0) . "</td>
			</tr></table>
			";
			$vtotresep = $obat;
			//$konten = $konten.$result['konten'];
		}
		$vtotoksigen = 0;
		if (($list_oksigen)) { //harus Pelaksana Rumah Sakit
			$result = $this->string_table_tindakan($list_oksigen);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . "
			<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\"> Oksigen (O2)</td>
				<td align=\"right\"> " . number_format($result['subtotal'], 0) . "</td>
			</tr></table>
			";
			$vtotoksigen = $result['subtotal'];
		}

		//irj
		if ($pasien[0]['carabayar'] == 'BPJS') {
			if (($poli_irj_dokter)) {
				$result = $this->string_table_irj_kw($poli_irj_dokter);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//$konten = $konten.$result['konten'];
			}
			if (($poli_irj_perawat)) {
				$result = $this->string_table_irj($poli_irj_perawat);
				if ((int)$result['subtotal'] != 0) {
					$grand_total = $grand_total + $result['subtotal'];
					$konten = $konten . "
					<table class=\"table-isi\" border=\"0\">
					<tr>
						<td colspan=\"7\">Tindakan Perawat Rawat Jalan</td>
						<td align=\"right\"> " . number_format($result['subtotal'], 0) . " </td>
					</tr>
					</table>
					";
				}

				//$konten = $konten.$result['konten'];
			}
		}



		$fix_adm = $grand_total * 5 / 100;

		//1B0103
		$detailtind = $this->rimpasien->get_detail_tindakan('1B0103', $pasien[0]['kelas'])->row();

		//$data['dijamin']=$this->input->post('dijamin');
		$biaya_daftar = (int) $detailtind->total_tarif + (int)$detailtind->tarif_alkes;
		$konten = $konten . "<br><br>
			<table class=\"table-isi\" border=\"0\">";
		if ((int)$total_alkes != 0) {
			$konten = $konten . "<tr>
				<td colspan=\"7\">Sewa Alat</td>
				<td align=\"right\"><p> " . number_format($total_alkes, 0) . " </p></td>
			</tr>";
		}

		/*if((int)$tind_perawat!=0){
			$konten = $konten."<tr >
				<td colspan=\"7\">Tindakan Perawat</td>
				<td align=\"right\"> ".number_format($tind_perawat,0)." </td>
			</tr>";
		}*/

		$tind_perawat = 0;
		if (($list_tindakan_perawat_pasien)) {
			$result = $this->string_table_tindakan_perawat($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];

			$konten = $konten . $result['konten'];
			$tind_perawat = $result['subtotal'];
			//print_r($konten);exit;

		}

		if ((int)$matkes != 0) {
			$konten = $konten . "<tr>
				<td colspan=\"7\">Matkes Ruang Rawat</td>
				<td align=\"right\"> " . number_format($matkes, 0) . " </td>
			</tr>";
		}


		$fix_adm = 0; //$grand_total* 5/100;
		$konten = $konten . "<tr>
				<td align=\"right\" colspan=\"7\">Total</td>
				<td align=\"right\"> " . number_format($grand_total, 0) . " </td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			
			<tr>
				<td colspan=\"7\">Biaya Administrasi</td>
				<td align=\"right\"> " . number_format($fix_adm, 0) . " </td>
			</tr>
						
			";


		$grand_total = (float) $grand_total + (float) $fix_adm;
		// + (double) $jasa_perawat + 6000 + (double) $biaya_daftar

		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;





		$jenis_bayar = $this->input->post('jenis_pembayaran');
		$string_detail_pembayaran_kredit_tunai = "";
		$string_diskon = "";
		if ($diskon != 0) {
			$string_diskon = "<tr>
							<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
							<th ><p align=\"right\"> " . number_format($diskon, 0) . " </p></th>
						</tr>";
		}

		$string_detail_pembayaran_kredit_tunai =
			"
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
						<th ><p align=\"right\"> " . number_format($dibayar_tunai, 0) . " </p></th>
					</tr>
					" . $string_diskon;
		//echo $vtot_peserta;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
						
			<table class=\"table-isi\" border=\"0\">
				" . $string_detail_pembayaran_kredit_tunai . "
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
					<th ><p align=\"right\"> " . number_format($grand_total + $vtotdenda, 0) . " </p></th>
				</tr>
			</table>
			<br/><br/><br/>			
			<table border=\"1\">";

		$konten0 = $konten0 . "<br>" . $grand_total_string;
		$konten0 = $this->string_data_pasien($pasien, $grand_total, "", '') . $konten0;

		$konten = $konten0 . $konten;
		//echo $konten;
		//break;
		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');


		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		$vtot_peserta = $grand_total + $biaya_administrasi;
		// +$biaya_materai+$biaya_daftar+$jasa_perawat
		//$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}


		/*if($biaya_adm == "" && $status_paket == 0){
			$biaya_adm = $grand_total * 5 / 100;
			$grand_total = $grand_total + $biaya_adm;
		}*/
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total + $vtotdenda, 1);
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		/*<tr>
				<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
				<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
			</tr>*/
		$grand_total_string = "			
			<tr>
				<th colspan=\"7\"><p><b>Denda Terlambat</b></p></th>
				<th><p align=\"right\"> " . number_format($vtotdenda, 0) . " </p></th>
			</tr>
			<tr>
				<th colspan=\"7\"><p><b>Total Biaya</b></p></th>
				<th><p align=\"right\"> " . number_format($grand_total + $vtotdenda, 0) . " </p></th>
			</tr>
		</table>
		<br>
		<p><b>Terbilang : </b><i>" . strtoupper($vtot_terbilang) . "</i></p><br>	
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Kepala Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>----------------------------------------</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>	
		";

		$konten = $konten . $grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['total_bayar'] = $grand_total;
		$data_pasien_iri['total'] = $grand_total;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$data_pasien_iri['vtot_kamar'] = $biaya_kamar;
		$data_pasien_iri['vtot_icu'] = $vtoticu;
		$data_pasien_iri['vtot_vk'] = $vtotvk;
		$data_pasien_iri['vtot_ok'] = $vtotok;
		$data_pasien_iri['vtot_lab'] = $vtotlab;
		$data_pasien_iri['vtot_rad'] = $vtotrad;
		$data_pasien_iri['vtot_pa'] = $vtotpa;
		$data_pasien_iri['vtot_obat'] = $vtotresep;
		$data_pasien_iri['vtot_usg'] = $vtotusg;
		$data_pasien_iri['denda_terlambat'] = $vtotdenda;

		$data_pasien_iri['biaya_alkes'] = $total_alkes;
		$data_pasien_iri['vtot_ruang'] = $vtotruang;
		$data_pasien_iri['matkes_ok'] = $matkesok;
		$data_pasien_iri['matkes_vk'] = $matkesvk;
		$data_pasien_iri['biaya_daftar'] = $biaya_daftar;
		$data_pasien_iri['matkes_icu'] = $matkesicu;

		$data_pasien_iri['vtot_oksigen'] = $vtotoksigen;
		$data_pasien_iri['vtot_kamaricu'] = $vtotkamaricu;
		$data_pasien_iri['vtot_kamarvk'] = $vtotkamarvk;
		$data_pasien_iri['vtot_medis'] = $vtotmedis;
		$data_pasien_iri['vtot_paramedis'] = $vtotparamedis;
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if ($jenis_bayar == "KREDIT") {
			$data_pasien_iri['diskon'] = $diskon;
			$data_pasien_iri['vtot'] = $grand_total;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien, $data_pasien_iri['diskon'], $penerima, $jenis_pembayaran, $data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		} else {
			$data_pasien_iri['diskon'] = $diskon;
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		//$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		//$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		//$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['matkes_iri'] = $matkes;
		$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
		$data_pasien_iri['biaya_administrasi'] = $fix_adm;
		//$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if ($pasien[0]['carabayar'] == "DIJAMIN") {
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		$this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'], date("Y:m:d H:i"), $data_pasien_iri['lunas']);
		$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'], date("Y:m:d H:i"), $data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran		
		//echo $konten;
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Kwitansi Rawat Inap - " . $no_ipd . " - " . $pasien[0]['nama'];
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);


		$obj_pdf->AddPage();
		ob_start();
		$content1 = $konten1;
		ob_end_clean();
		$obj_pdf->writeHTML($content3, true, false, true, false, '');
		$obj_pdf->AddPage();
		ob_start();
		$content2 = $konten2;
		ob_end_clean();
		$obj_pdf->writeHTML($content3, true, false, true, false, '');
		$obj_pdf->AddPage();
		ob_start();
		$content3 = $konten3;
		ob_end_clean();
		$obj_pdf->writeHTML($content3, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}



	//COBA COBA

	private function string_data_pasien($pasien, $grand_total, $penerima, $jenis_pembayaran)
	{

		$namars = $this->config->item('namars');
		//print_r($namars);die();
		$kota_kab = $this->config->item('kota');
		$telp = $this->config->item('telp');
		$alamatrs = $this->config->item('alamat');
		$nmsingkat = $this->config->item('namasingkat');

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');


		//tanda terima
		$penyetor = $penerima;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;

		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";

		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan = '';
		if ($pasien[0]['carabayar'] == 'KERJASAMA' || $pasien[0]['carabayar'] == 'BPJS') {
			$kontraktor = $this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
			$txtperusahaan = "<td><b>Dijamin Oleh</b></td>
					<td> : </td>
					<td>" . strtoupper($kontraktor->nmkontraktor) . "</td>"; //
		}

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

		$konten = $konten . "<style type=\"text/css\">
				.table-font-size{
					font-size:9px;
					}
				.table-font-size1{
					font-size:12px;
					}
				</style>
				
				$header_page
				
				<table style=\"padding-top:2px;\" border=\"1\">
					<tr>							
						<td><font size=\"8\" align=\"right\">$tgl_jam</font></td>
					</tr>			
					<tr>
						<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT INAP</b></u></font></td>
					</tr>			
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td width=\"17%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"37%\">" . strtoupper($pasien[0]['anamakwitansi']) . "</td>
							<td width=\"20%\"><b>Tanggal Kunjungan</b></td>
							<td width=\"2%\"> : </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['nama']) . "</td>
							<td ><b>No Medrec / No Register</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['no_cm']) . " / " . strtoupper($pasien[0]['no_ipd']) . "</td>
						</tr>
						<tr>
							<td ><b>Umur</b></td>
							<td > : </td>
							<td>" . $interval->format("%Y Thn, %M Bln, %d Hr") . "</td>
							
							<td ><b>Gol. Pasien</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['carabayar']) . "</td>
						</tr>
						
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['alamat']) . "</td>
							
							$txtperusahaan
						</tr>
				</table>";



		return $konten;
	}

	private function string_data_pasien_noheader($pasien, $grand_total, $nokwitansi, $penerima, $jenis_pembayaran)
	{

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');


		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";

		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan = '';
		if ($pasien[0]['carabayar'] == 'KERJASAMA' || $pasien[0]['carabayar'] == 'BPJS') {
			$kontraktor = $this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
			$txtperusahaan = "<td><b>Dijamin Oleh</b></td>
					<td> : </td>
					<td>" . strtoupper($kontraktor->nmkontraktor) . "</td>"; //
		}

		$konten = $konten . "<style type=\"text/css\">
				.table-font-size{
					font-size:9px;
					}
				.table-font-size1{
					font-size:12px;
					}
				</style>
				
				<table style=\"padding-top:2px;\">
					<tr>							
						<td><font size=\"8\" align=\"right\"></font></td>
					</tr>			
					<tr>
						<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT INAP  " . $pasien[0]['no_ipd'] . "</b></u></font></td>
					</tr>			
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td width=\"17%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"37%\">" . strtoupper($pasien[0]['nama']) . "</td>
							<td width=\"20%\"><b>Tanggal Kunjungan</b></td>
							<td width=\"2%\"> : </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['nama']) . "</td>
							<td ><b>No Medrec / No Register</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['no_cm']) . " / " . strtoupper($pasien[0]['no_ipd']) . "</td>
						</tr>
						<tr>
							<td ><b>Umur</b></td>
							<td > : </td>
							<td>" . $interval->format("%Y Thn, %M Bln, %d Hr") . "</td>
							
							<td ><b>Gol. Pasien</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['carabayar']) . "</td>
						</tr>
						
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['alamat']) . "</td>
							
							$txtperusahaan
						</tr>
				</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>

		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>

		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>

		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>

		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>

		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>

		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>

		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_data_pasien_sementara($pasien, $grand_total, $penerima, $jenis_pembayaran)
	{

		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");
		$tgl_keluar = isset($pasien[0]['tgl_keluar']) ? date("d-m-Y", strtotime($pasien[0]['tgl_keluar'])) : '';



		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";

		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		
		$txtperusahaan = '';
		if ($pasien[0]['carabayar'] == 'DIJAMIN' || $pasien[0]['carabayar'] == 'BPJS' || $pasien[0]['carabayar'] == 'KERJASAMA') {
			$kontraktor = $this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
			//if($kontraktor!=''){
			$txtperusahaan = "<td><b>Dijamin Oleh</b></td>
					<td> : </td>
					<td>" . strtoupper($kontraktor->nmkontraktor) . "</td>";
			//}				
		}

		$header_page = $top_header . "<p align=\"center\">
										<img src=\"assets/img/" . $logo_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
									</p>
								</td>
								<td  width=\"74%\" style=\"font-size:14px;\" align=\"center\">
									<font style=\"font-size:22px\">
										<b><label>RSUD AHMAD SYAFII MAARIF</label></b><br>
									</font>
								</td>
								<td width=\"13%\">
									<p align=\"center\">
										
									</p>" . $bottom_header;
		$konten = $konten . "<style type=\"text/css\">
				table tr td{
					font-size:14px;
					}
				.table-font-size1{
					font-size:8px;
					}
				</style>
				

				<p style=\"font-size: 12px;\" size=\"6\" align=\"right\"></p><br>
				$header_page
				<hr>
				
				<table style=\"width: 100%;\" width=\"100%\">			
					<tr>
						<td colspan=\"6\" style=\"\">
							<center><p size=\"11\" ><u><b>RINCIAN BIAYA RAWAT INAP NO " . $pasien[0]['no_ipd'] . "</b></u></p></center>
						</td>
					</tr>			
						<tr>
							<td width=\"17%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"37%\">" . strtoupper($pasien[0]['nama']) . "</td>
							<td width=\"20%\"><b>Tanggal Masuk</b></td>
							<td width=\"2%\"> : </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['nama']) . "</td>
							<td ><b>No Medrec / No Register</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['no_cm']) . " / " . strtoupper($pasien[0]['no_ipd']) . "</td>
						</tr>
						<tr>
							<td ><b>Umur</b></td>
							<td > : </td>
							<td>" . $interval->format("%Y Thn") . "</td>
							
							<td ><b>Gol. Pasien</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['carabayar']) . "</td>
						</tr>
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['alamat']) . "</td>								
							<td><b>Tanggal Keluar</b></td>
							<td> : </td>
							<td>" . $tgl_keluar . "</td>							
						</tr>
						
				</table>";
		return $konten;
	}

	private function string_data_pasien_faktur($pasien, $grand_total, $penerima, $jenis_pembayaran, $no_kwitansi = '')
	{

		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");




		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');


		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan = '';
		if ($pasien[0]['carabayar'] == 'KERJASAMA' || $pasien[0]['carabayar'] == 'BPJS') {
			$kontraktor = $this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
			//if($kontraktor!=''){
			$txtperusahaan = "
					<td ><b>Dijamin Oleh</b></td>
					<td >: </td>
					<td>" . strtoupper($kontraktor->nmkontraktor) . "</td>";
			//}

		}

		// $header_page = $top_header . "<p align=\"center\">
		// 								<img src=\"assets/img/" . $logo_header . "\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
		// 							</p>
		// 						</td>
		// 						<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
		// 							<font style=\"font-size:22px\">
		// 								<b><label>RSUD AHMAD SYAFII MAARIF</label></b><br>
		// 							</font>
		// 						</td>
		// 						<td width=\"13%\">
		// 							<p align=\"center\">
		// 							</p>" . $bottom_header;
		$header_page = "<table border=\"1\" width=\"100%\" style=\"border-collapse: collapse; border: solid 1px black;\" cellpadding=\"5px\"  cellspacing=\"5px\">
		<tr>
			<td width=\"30%\" >
				<p style=\"font-size:12px;font-weight:bold\">PEMDA KABUPATEN SIJUNJUNG</p>
				<center><span style=\"font-size:8px\">Jl. Prof. M. Yamin, SH No.17</span></center>
				<center><p style=\"font-size:10px;font-weight:bold\">Muaro Sijunjung</p></center>
			</td>
			<td width=\"40%\" style=\"text-align: center;\">
				<p style=\"font-size:12px; font-weight:bold;\">SURAT KETETAPAN RETRIBUSI DAERAH</p>
				<span style=\"font-size:12px; font-weight:bold;\">(SKRD)</span>
				<p style=\"font-size:8px; text-align:left;\">Masa Retribusi :</p>
				<p style=\"font-size:8px; text-align:left;\">Tahun : ".date('Y')."</p>
			</td>
			<td width=\"30%\" style=\"text-align: center;\">
				<p style=\"font-size:8px;\">No Urut : ".$no_kwitansi."</p>
				
			</td>
		</tr>
		</table>";
		$konten = $konten . "<style type=\"text/css\">
				.table-font-size{
					font-size:9px;
					}
				.table-font-size1{
					font-size:10px;
					}
				</style>
				

				<p style=\"font-size: 12px;\" size=\"6\" align=\"right\"></p><br>
				$header_page
				
				<div style=\"border: solid 1px black\">
				<table style=\"padding-top:2px;\">
					<tr>
						<td colspan=\"6\" ><center><font size=\"10px\" text-align=\"center\"><u><b>Kwitansi RAWAT INAP <br>NO " . $pasien[0]['no_ipd'] . "</b></u></font></center></td>
					</tr>			
						<tr>
							<td><br></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td width=\"17%\"><b>Terima Dari</b></td>
							<td width=\"2%\">: </td>
							<td width=\"37%\">" . strtoupper($pasien[0]['nama']) . "</td>
							<td width=\"19%\"><b>Tanggal Masuk</b></td>
							<td width=\"2%\">: </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td>: </td>
							<td>" . strtoupper($pasien[0]['nama']) . "</td>

							<td><b>Tanggal Keluar</b></td>
							<td >: </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_keluar'])) . "</td>
							
						</tr>
						<tr>
							<td ><b>Tanggal Lahir</b></td>
							<td >: </td>
							<td>" . date('d-m-Y', strtotime($pasien[0]['tgl_lahir'])) . "</td>
							
							<td ><b>No Medrec</b></td>
							<td >: </td>
							<td>" . strtoupper($pasien[0]['no_cm']) . "</td>


						</tr>
						<tr>
							<td ><b>Kelas</b></td>
							<td >: </td>
							<td>" . $pasien[0]['kelas'] . "</td>
							
							<td><b>No Register</b></td>
							<td>: </td>
							<td>" . $pasien[0]['no_ipd'] . "</td>
							

						</tr>
						<tr>
							<td ><b>Penjamin</b></td>
							<td >: </td>
							<td>" . strtoupper($pasien[0]['carabayar']) . "</td>

							<td><b>Jatah Kelas</b></td>
							<td>: </td>
							<td>" . $pasien[0]['jatahklsiri'] . "</td>
						</tr>
						<tr>
							<td ><b>No Kwitansi</b></td>
							<td >: </td>
							<td>" . $no_kwitansi . "</td>
						</tr>
				</table>
				<hr>
				
				";
		// $konten = $konten . "
		// 	<div style=\"border: solid 1px black\">
		// 		<table>
		// 			<tr>
		// 				<td width=\"20%\"><b>Dokter(DPJP) </b></td>
		// 				<td>" . strtoupper($pasien[0]['dokter']) . "</td>
		// 			</tr>
		// 		</table>
		// 		</div>
		// 		";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>

		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>

		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>

		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>

		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>

		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>

		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>

		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_data_pasien_simple($pasien, $grand_total, $penerima, $jenis_pembayaran)
	{
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');

		//tanda terima
		$penyetor = $penerima;

		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " TUNAI ";
		}
		$konten = $konten . "<style type=\"text/css\">
				.table-font-size{
					font-size:9px;
					}
				.table-font-size1{
					font-size:12px;
					}
				</style>
				
				<table class=\"table-font-size\" border=\"0\">
					<tr>
					<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
					<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>" . $this->config->item('namars') . "</b> <br/> " . $this->config->item('alamat') . "</td>
					<td width=\"10%\"></td>						
					</tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>" . $tambahan_jenis_pembayaran . "</u></b></p></td></tr>
				</table>
				
				
				<table >
					<tr>							
						<td><font size=\"8\" align=\"left\"></font></td>
					</tr>			
					<tr>
						<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT INAP<br/>
				No. KW. " . $pasien[0]['no_ipd'] . "</b></u></font></td>
					</tr>	<br>		
						<tr>
							<td width=\"17%\"><b>Terbilang</b></td>
							<td width=\"2%\"> : </td>
							<td  width=\"78%\"><i>" . strtoupper($vtot_terbilang) . "</i></td>
						</tr>			
						<tr>
							<td><b>Untuk Pemeriksaan</b></td>
							<td> : </td>
							<td><i>Untuk Pembayaran Pemeriksaan, Tindakan dan pengobatan Rawat Inap sesuai nota terlampir</i></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td width=\"17%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"37%\">" . strtoupper($pasien[0]['nama']) . "</td>
							<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
							<td width=\"2%\"> : </td>
							<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['nama']) . "</td>
							<td ><b>No Medrec</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['no_cm']) . "</td>
						</tr>
						<tr>
							<td ><b>Umur</b></td>
							<td > : </td>
							<td>" . $interval->format("%Y Tahun, %M Bulan, %d Hari") . " TAHUN</td>
							
							<td ><b>Gol. Pasien</b></td>
							<td > : </td>
							<td>" . strtoupper($pasien[0]['carabayar']) . "</td>
						</tr>
						
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>" . strtoupper($pasien[0]['alamat']) . "</td>
							
						</tr>
				</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Kwitansi $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			No. KW. ".$pasien[0]['no_ipd']."
		// 			</b></p><br/>
		// 			<table>

		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>

		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>

		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>

		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>

		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>

		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>

		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$ipdibu = $this->rimpasien->get_ipd_ibu($pasien[0]['no_ipd'])->row()->ipdibu;
		// $konten= $konten.'
		// <table  class="table-isi" border="0">
		// 	<tr>
		// 	  <td colspan="2" align="center" >Ruangan</td>
		// 	  <td align="center">Kelas</td>
		// 	  <td align="center">Tgl Masuk</td>
		// 	  <td align="center">Tgl Keluar</td>
		// 	  <td align="center">Tarif</td>
		// 	  <td align="center">Lama Inap</td>
		// 	  <td align="center"></td>
		// 	</tr>
		// ';
		// $konten= $konten.'
		// <table  class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr>
		// 	  <td colspan="7" align="left" >Ruangan</td>
		// ';
		$subtotal = 0;
		$subtotalruang = 0;
		$selisih_ruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		$subtotalicu = 0;
		if (($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == NULL)) {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = $r['total_tarif'] * $diff;
						} else {
							$total_per_kamar = $r['total_tarif'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;
					//   var_dump($subtotal);die();
					// 
					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					// $konten = $konten. "
					// <tr>
					// 	<td colspan=\"2\" align=\"left\">".$r['nmruang']."</td>
					// 	<td align=\"center\">".$r['kelas']."</td>
					// 	<td align=\"center\">".$tgl_masuk_rg."</td>
					// 	<td align=\"center\">".$tgl_keluar_rg."</td>
					// 	<td align=\"center\"> ".number_format($r['vtot'],0)."</td>
					// 	<td align=\"center\">".$selisih_hari."</td>
					// 	<td align=\"right\"> ".number_format($total_per_kamar,0)."</td>
					// </tr>
					// ";
				}
			}

			// $konten = $konten.'
			// 		<tr>
			// 			<td colspan="6" align="right">Subtotal</td>
			// 			<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten."
			// 			<td align=\"right\"> ".number_format($subtotal,0)."</td>
			// 		</tr>
			// 		";
		} else if ($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == NULL) {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];

					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if ($status_paket == 1) {
						$total_per_kamar = 0;
					} else {
						if ($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_per_kamar = ($r['total_tarif'] / 2) * $diff;
							} else {
								$total_per_kamar = $r['total_tarif'] * $diff;
							}
						} else if ($pasien[0]['tgl_masuk'] < '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_per_kamar = ($r['total_tarif'] / 2) * $diff;
							} else {
								$total_per_kamar = $r['total_tarif'] * $diff;
							}
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}
				}
			}
		} else if (($pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == NULL)) {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_iks'] / 2) * $diff;
							$total_jatah = ($r['tarif_jatah_iks'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_iks'] * $diff;
							$total_jatah = $r['tarif_jatah_iks'] * $diff;
						}

						if (($r['tarif_iks'] > $r['tarif_jatah_iks']) || ($r['tarif_iks'] == $r['tarif_jatah_iks'])) {
							$selisih_ruang =  $selisih_ruang + ($total_per_kamar - $total_jatah);
						} else if ($r['tarif_iks'] < $r['tarif_jatah_iks']) {
							$selisih_ruang =  $selisih_ruang + (0);
						}
					}

					$subtotal = $subtotal + ($selisih_ruang);

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					// $konten = $konten. "
					// <tr>
					// 	<td colspan=\"2\" align=\"left\">".$r['nmruang']."</td>
					// 	<td align=\"center\">".$r['kelas']."</td>
					// 	<td align=\"center\">".$tgl_masuk_rg."</td>
					// 	<td align=\"center\">".$tgl_keluar_rg."</td>
					// 	<td align=\"center\"> ".number_format($r['vtot'],0)."</td>
					// 	<td align=\"center\">".$selisih_hari."</td>
					// 	<td align=\"right\"> ".number_format($total_per_kamar,0)."</td>
					// </tr>
					// ";
				}
			}

			// $konten = $konten.'
			// 		<tr>
			// 			<td colspan="6" align="right">Subtotal</td>
			// 			<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten."
			// 			<td align=\"right\"> ".number_format($selisih_ruang,0)."</td>
			// 		</tr>
			// 		";
		} else if (($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == '1')) {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_jatah'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_jatah'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					// $konten = $konten. "
					// <tr>
					// 	<td colspan=\"2\" align=\"left\">".$r['nmruang']."</td>
					// 	<td align=\"center\">".$r['kelas']."</td>
					// 	<td align=\"center\">".$tgl_masuk_rg."</td>
					// 	<td align=\"center\">".$tgl_keluar_rg."</td>
					// 	<td align=\"center\"> ".number_format($r['vtot'],0)."</td>
					// 	<td align=\"center\">".$selisih_hari."</td>
					// 	<td align=\"right\"> ".number_format($total_per_kamar,0)."</td>
					// </tr>
					// ";
				}
			}

			// $konten = $konten.'
			// 		<tr>
			// 			<td colspan="6" align="right">Subtotal</td>
			// 			<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten."
			// 			<td align=\"right\"> ".number_format($subtotal,0)."</td>
			// 		</tr>
			// 		";
		} else if ($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == '1') {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];

					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if ($status_paket == 1) {
						$total_per_kamar = 0;
					} else {
						if ($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_per_kamar = ($r['tarif_jatah_bpjs'] / 2) * $diff;
							} else {
								$total_per_kamar = $r['tarif_jatah_bpjs'] * $diff;
							}
						} else if ($pasien[0]['tgl_masuk'] < '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_per_kamar = ($r['tarif_jatah'] / 2) * $diff;
							}
							$total_per_kamar = $r['tarif_jatah'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}
				}
			}
		} else if ($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == '1') {
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];

					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if ($status_paket == 1) {
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_jatah_iks'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_jatah_iks'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}
				}
			}
		}
		//$konten = $konten."</table>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_rekap_iks($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$ipdibu = $this->rimpasien->get_ipd_ibu($pasien[0]['no_ipd'])->row()->ipdibu;
		$konten = $konten . '
		<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
			  <td align="left" colspan="3" width="25%">Ruangan</td>
			  <td align="center" width="15%">Kelas</td>
			  <td align="center" width="15%">Tgl Masuk</td>
			  <td align="center" width="15%">Tgl Keluar</td>
			  <td align="center" width="15%">Lama Inap</td>
			  <td align="right" width="15%">Subtotal</td>
			</tr>
		';

		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		$subtotalicu = 0;
		foreach ($list_mutasi_pasien as $r) {
			if (strpos($r['nmruang'], 'Bersalin') == false) {
				$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
				if ($r['tglkeluarrg'] != null) {
					$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != null) {
						$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
					} else {
						//$tgl_keluar_rg = "-" ;
						$tgl_keluar_rg = date("d-m-Y");
					}
				}
				if ($r['tglkeluarrg'] != null) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($r['tglkeluarrg']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != NULL) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime(); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
						//$selisih_hari =  "- Hari";
					}
				}
				$jasaperawat = $jasaperawat + $r['jasa_perawat'];
				if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
					$ceknull = 1;
				}
				$total_tarif = $r['harga_jatah_kelas'];



				$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
				$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

				// $total_per_kamar = $r['vtot'] * $diff;

				if ($status_paket == 1) {
					// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
					// if($temp_diff < 0){
					// 	$temp_diff = 0;
					// }
					$total_per_kamar = 0;
				} else {
					if ($ipdibu != NULL) {
						$total_per_kamar = ($r['tarif_iks'] / 2) * $diff;
					} else {
						$total_per_kamar = $r['tarif_iks'] * $diff;
					}
				}

				$subtotal = $subtotal + $total_per_kamar;

				if (strpos($r['nmruang'], 'ICU')) {
					$subtotalicu += $total_per_kamar;
				} else {
					$subtotalruang += $total_per_kamar;
				}

				$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
				</tr>
				";
			}
		}

		$konten = $konten . '
		<tr style="font-weight:bold;">
			<td colspan="7" align="left">Subtotal</td>
			<td align="right"> ' . number_format($subtotal, 0) . '</td>
		</tr>
		';
		$konten = $konten . "</table><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_rekap_iks_jatah($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$ipdibu = $this->rimpasien->get_ipd_ibu($pasien[0]['no_ipd'])->row()->ipdibu;
		$konten = $konten . '
		<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
			  <td align="left" colspan="3" width="25%">Ruangan</td>
			  <td align="center" width="15%">Jatah Kelas</td>
			  <td align="center" width="15%">Tgl Masuk</td>
			  <td align="center" width="15%">Tgl Keluar</td>
			  <td align="center" width="15%">Lama Inap</td>
			  <td align="right" width="15%">Subtotal</td>
			</tr>
		';

		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		$subtotalicu = 0;
		foreach ($list_mutasi_pasien as $r) {
			if (strpos($r['nmruang'], 'Bersalin') == false) {
				$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
				if ($r['tglkeluarrg'] != null) {
					$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != null) {
						$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
					} else {
						//$tgl_keluar_rg = "-" ;
						$tgl_keluar_rg = date("d-m-Y");
					}
				}
				if ($r['tglkeluarrg'] != null) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($r['tglkeluarrg']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != NULL) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime(); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
						//$selisih_hari =  "- Hari";
					}
				}
				$jasaperawat = $jasaperawat + $r['jasa_perawat'];
				if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
					$ceknull = 1;
				}
				$total_tarif = $r['harga_jatah_kelas'];



				$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
				$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

				// $total_per_kamar = $r['vtot'] * $diff;

				if ($status_paket == 1) {
					// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
					// if($temp_diff < 0){
					// 	$temp_diff = 0;
					// }
					$total_per_kamar = 0;
				} else {
					if ($ipdibu != NULL) {
						$total_per_kamar = ($r['tarif_jatah_iks'] / 2) * $diff;
					} else {
						$total_per_kamar = $r['tarif_jatah_iks'] * $diff;
					}
				}

				$subtotal = $subtotal + $total_per_kamar;

				if (strpos($r['nmruang'], 'ICU')) {
					$subtotalicu += $total_per_kamar;
				} else {
					$subtotalruang += $total_per_kamar;
				}

				$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
				</tr>
				";
			}
		}

		$konten = $konten . '
		<tr style="font-weight:bold;">
			<td colspan="7" align="left">Subtotal</td>
			<td align="right"> ' . number_format($subtotal, 0) . '</td>
		</tr>
		';
		$konten = $konten . "</table><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_jatah_kelas($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$ipdibu = $this->rimpasien->get_ipd_ibu($pasien[0]['no_ipd'])->row()->ipdibu;
		$konten = $konten . '
		<table class="table-isi" border="0"  style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
			  <td align="left" colspan="3" width="25%">Ruangan</td>
			  <td align="center" width="15%">Kelas</td>
			  <td align="center" width="15%">Tgl Masuk</td>
			  <td align="center" width="15%">Tgl Keluar</td>
			  <td align="center" width="15%">Lama Inap</td>
			  <td align="right" width="15%">Subtotal</td>
			</tr>';

		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		$subtotalicu = 0;
		foreach ($list_mutasi_pasien as $r) {
			if (strpos($r['nmruang'], 'Bersalin') == false) {
				$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
				if ($r['tglkeluarrg'] != null) {
					$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != null) {
						$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
					} else {
						//$tgl_keluar_rg = "-" ;
						$tgl_keluar_rg = date("d-m-Y");
					}
				}
				if ($r['tglkeluarrg'] != null) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($r['tglkeluarrg']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					if ($pasien[0]['tgl_keluar_resume'] != NULL) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime(); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
						//$selisih_hari =  "- Hari";
					}
				}
				$jasaperawat = $jasaperawat + $r['jasa_perawat'];
				if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
					$ceknull = 1;
				}
				$total_tarif = $r['harga_jatah_kelas'];

				$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
				$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

				// $total_per_kamar = $r['vtot'] * $diff;

				if ($status_paket == 1) {
					// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
					// if($temp_diff < 0){
					// 	$temp_diff = 0;
					// }
					$total_per_kamar = 0;
				} else {
					if ($pasien[0]['tgl_masuk'] >= '2023-04-06') {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_jatah_bpjs'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_jatah_bpjs'] * $diff;
						}
					} else if ($pasien[0]['tgl_masuk'] < '2023-04-06') {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_jatah'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_jatah'] * $diff;
						}
					}
				}
				$subtotal = $subtotal + $total_per_kamar;

				if (strpos($r['nmruang'], 'ICU')) {
					$subtotalicu += $total_per_kamar;
				} else {
					$subtotalruang += $total_per_kamar;
				}

				$konten = $konten . "
			<tr>
				<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
				<td align=\"center\">" . $r['kelas'] . "</td>
				<td align=\"center\">" . $tgl_masuk_rg . "</td>
				<td align=\"center\">" . $tgl_keluar_rg . "</td>
				<td align=\"center\">" . $selisih_hari . "</td>
				<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
			</tr>";
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="7" align="left">Subtotal</td>
				<td align="right"> ' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_sementara($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$ipdibu = $this->rimpasien->get_ipd_ibu($pasien[0]['no_ipd'])->row()->ipdibu;

		if (($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == NULL)) {
			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" colspan="3" width="25%">Ruangan</td>
				<td align="center" width="15%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="15%">Lama Inap</td>
				<td align="right" width="15%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['total_tarif'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['total_tarif'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
				</tr>
				";
				}
			}
		} else if ($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == NULL) {

			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" colspan="3" width="25%">Ruangan</td>
				<td align="center" width="15%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="15%">Lama Inap</td>
				<td align="right" width="15%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_per_kamar = $r['tarif_bpjs'] * $diff;
							} else {
								$total_per_kamar = $r['tarif_bpjs'] * $diff;
							}
						} else if ($pasien[0]['tgl_masuk'] < '2023-04-06') {
							if ($ipdibu != NULL) {
								// $total_per_kamar = ($r['total_tarif'] / 2) * $diff;
								$total_per_kamar = $r['total_tarif'] * $diff;
							} else {
								$total_per_kamar = $r['total_tarif'] * $diff;
							}
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
				</tr>
				";
				}
			}
		} else if (($pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == NULL)) {
			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" width="25%">Ruangan</td>
				<td align="center" width="5%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="10%">Lama Inap</td>
				<td align="center" width="10%">Total Kelas</td>
				<td align="center" width="10%">Total Jatah</td>
				<td align="right" width="10%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$total = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_per_kamar = ($r['tarif_iks'] / 2) * $diff;
							$total_jatah = ($r['tarif_jatah_iks'] / 2) * $diff;
						} else {
							$total_per_kamar = $r['tarif_iks'] * $diff;
							$total_jatah = $r['tarif_jatah_iks'] * $diff;
						}

						if (($r['tarif_iks'] > $r['tarif_jatah_iks']) || ($r['tarif_iks'] == $r['tarif_jatah_iks'])) {
							$total = $total + ($total_per_kamar - $total_jatah);
						} else if ($r['tarif_iks'] < $r['tarif_jatah_iks']) {
							$total = $total + (0);
						}
					}

					$subtotal = $subtotal + $total;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\">" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_per_kamar) . "</td>
					<td align=\"right\"> " . number_format($total_jatah) . "</td>
					<td align=\"right\"> " . number_format($total) . "</td>
				</tr>
				";
				}
			}
		} else if (($pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == '1')) {
			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" colspan="3" width="25%">Ruangan</td>
				<td align="center" width="15%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="15%">Lama Inap</td>
				<td align="right" width="15%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$total = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_jatah = ($r['tarif_jatah'] / 2) * $diff;
						} else {
							$total_jatah = $r['tarif_jatah'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_jatah;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_jatah) . "</td>
				</tr>
				";
				}
			}
		} else if ($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == '1') {
			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" colspan="3" width="25%">Ruangan</td>
				<td align="center" width="15%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="15%">Lama Inap</td>
				<td align="right" width="15%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$total = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_jatah = ($r['tarif_jatah_bpjs'] / 2) * $diff;
							} else {
								$total_jatah = $r['tarif_jatah_bpjs'] * $diff;
							}
						} else if ($pasien[0]['tgl_masuk'] < '2023-04-06') {
							if ($ipdibu != NULL) {
								$total_jatah = ($r['tarif_jatah'] / 2) * $diff;
							} else {
								$total_jatah = $r['tarif_jatah'] * $diff;
							}
						}
					}

					$subtotal = $subtotal + $total_jatah;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_jatah) . "</td>
				</tr>
				";
				}
			}
		} else if ($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == '1') {
			$konten = $konten . '
			<table  class="table-isi" border="0"  style="width: 100%;" width="100%">
				<tr style="font-weight:bold;">
				<td align="left" colspan="3" width="25%">Ruangan</td>
				<td align="center" width="15%">Kelas</td>
				<td align="center" width="15%">Tgl Masuk</td>
				<td align="center" width="15%">Tgl Keluar</td>
				<td align="center" width="15%">Lama Inap</td>
				<td align="right" width="15%">Subtotal</td>
				</tr>
			';
			$subtotal = 0;
			$subtotalruang = 0;
			$diff = 1;
			$total_subsidi = 0;
			$total = 0;
			$jasaperawat = 0;
			$ceknull = 0;
			$subtotalvk = 0;
			$subtotalicu = 0;
			foreach ($list_mutasi_pasien as $r) {
				if (strpos($r['nmruang'], 'Bersalin') == false) {
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if ($r['tglkeluarrg'] != null) {
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != null) {
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume']));
						} else {
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}
					}
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						$selisih_hari =  $diff . " Hari";
					} else {
						if ($pasien[0]['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							$selisih_hari =  $diff . " Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat = $jasaperawat + $r['jasa_perawat'];
					if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar_resume'] == null || $pasien[0]['tgl_keluar_resume'] == '')) {
						$ceknull = 1;
					}
					$total_tarif = $r['harga_jatah_kelas'];



					$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					// $total_per_kamar = $r['vtot'] * $diff;

					if ($status_paket == 1) {
						// $temp_diff = $diff - 2;//kalo ada paket free 2 hari
						// if($temp_diff < 0){
						// 	$temp_diff = 0;
						// }
						$total_per_kamar = 0;
					} else {
						if ($ipdibu != NULL) {
							$total_jatah = ($r['tarif_jatah_iks'] / 2) * $diff;
						} else {
							$total_jatah = $r['tarif_jatah_iks'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_jatah;

					if (strpos($r['nmruang'], 'ICU')) {
						$subtotalicu += $total_per_kamar;
					} else {
						$subtotalruang += $total_per_kamar;
					}

					$konten = $konten . "
				<tr>
					<td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
					<td align=\"center\">" . $r['kelas'] . "</td>
					<td align=\"center\">" . $tgl_masuk_rg . "</td>
					<td align=\"center\">" . $tgl_keluar_rg . "</td>
					<td align=\"center\">" . $selisih_hari . "</td>
					<td align=\"right\"> " . number_format($total_jatah) . "</td>
				</tr>
				";
				}
			}
		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="7" align="left">Subtotal</td>
				<td align="right"> ' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_vk($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		//		
		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		foreach ($list_mutasi_pasien as $r) {
			$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
			if ($r['tglkeluarrg'] != null) {
				$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
			} else {
				if ($pasien[0]['tgl_keluar'] != null) {
					$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar']));
				} else {
					//$tgl_keluar_rg = "-" ;
					$tgl_keluar_rg = date("d-m-Y");
				}
			}
			if ($r['tglkeluarrg'] != null) {
				$start = new DateTime($r['tglmasukrg']); //start
				$end = new DateTime($r['tglkeluarrg']); //end

				$diff = $end->diff($start)->format("%a");
				if ($diff == 0) {
					$diff = 1;
				}
				$selisih_hari =  $diff . " Hari";
			} else {
				if ($pasien[0]['tgl_keluar'] != NULL) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($pasien[0]['tgl_keluar']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime(); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
					//$selisih_hari =  "- Hari";
				}
			}
			//$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
			if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar'] == null || $pasien[0]['tgl_keluar'] == '')) {
				$ceknull = 1;
			}
			$total_tarif = $r['harga_jatah_kelas'];



			$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//$total_per_kamar = $r['vtot'] * $diff;

			/*if($status_paket == 1){
			$temp_diff = $diff - 2;//kalo ada paket free 2 hari
			if($temp_diff < 0){
				$temp_diff = 0;
			}
			$total_per_kamar = $r['vtot'] * $temp_diff;
		}else{*/
			$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;

			$subtotalvk += $total_per_kamar;

			$namaruang = $r['nmruang'];
			$konten = $konten . "
		<tr>
			<td align=\"left\" colspan=\"3\">Sewa " . $r['nmruang'] . "</td>
			<td align=\"center\" colspan=\"3\"></td>
			<td align=\"right\" colspan=\"2\"> " . number_format($total_per_kamar, 0) . " </td>
		</tr>
		";
		}
		$result = array(
			'subtotalvk' => $subtotalvk,
			'konten' => $konten
		);
		return $result;
	}

	private function string_table_mutasi_ruangan_kw($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		//
		$konten = $konten . '
	<table border="1">
		<tr>
		  <td align="center" >Ruang</td>
		  <td align="center">Kelas</td>
		  <td align="center">Bed</td>
		  <td align="center">Tgl Masuk</td>
		  <td align="center">Tgl Keluar</td>
		  <td align="center">Tarif</td>
		  <td align="center">Lama Inap</td>
		  <td align="center"></td>
		</tr>
	';
		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat = 0;
		$ceknull = 0;
		$subtotalvk = 0;
		$subtotalicu = 0;
		foreach ($list_mutasi_pasien as $r) {
			$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
			if ($r['tglkeluarrg'] != null) {
				$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
			} else {
				if ($pasien[0]['tgl_keluar'] != null) {
					$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar']));
				} else {
					//$tgl_keluar_rg = "-" ;
					$tgl_keluar_rg = date("d-m-Y");
				}
			}
			if ($r['tglkeluarrg'] != null) {
				$start = new DateTime($r['tglmasukrg']); //start
				$end = new DateTime($r['tglkeluarrg']); //end

				$diff = $end->diff($start)->format("%a");
				if ($diff == 0) {
					$diff = 1;
				}
				$selisih_hari =  $diff . " Hari";
			} else {
				if ($pasien[0]['tgl_keluar'] != NULL) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($pasien[0]['tgl_keluar']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime(); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
					//$selisih_hari =  "- Hari";
				}
			}
			$jasaperawat = $jasaperawat + $r['jasa_perawat'];
			if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($pasien[0]['tgl_keluar'] == null || $pasien[0]['tgl_keluar'] == '')) {
				$ceknull = 1;
			}
			$total_tarif = $r['harga_jatah_kelas'];



			$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//$total_per_kamar = $r['vtot'] * $diff;

			/*if($status_paket == 1){
			$temp_diff = $diff - 2;//kalo ada paket free 2 hari
			if($temp_diff < 0){
				$temp_diff = 0;
			}
			$total_per_kamar = $r['vtot'] * $temp_diff;
		}else{*/
			$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;

			if (strpos($r['nmruang'], 'Ruang Bersalin')) {
				$subtotalvk += $total_per_kamar;
			} else	if (strpos($r['nmruang'], 'ICU')) {
				$subtotalicu += $total_per_kamar;
			} else {
				$subtotalruang += $total_per_kamar;
			}

			$konten = $konten . "
		<tr>
			<td align=\"center\">" . $r['nmruang'] . "</td>
			<td align=\"center\">" . $r['kelas'] . "</td>
			<td align=\"center\">" . $r['bed'] . "</td>
			<td align=\"center\">" . $tgl_masuk_rg . "</td>
			<td align=\"center\">" . $tgl_keluar_rg . "</td>
			<td align=\"center\">Rp. " . number_format($r['vtot'], 0) . "</td>
			<td align=\"center\">" . $selisih_hari . "</td>
			<td align=\"right\"> " . number_format($total_per_kamar, 0) . "</td>
		</tr>
		";
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'selisihhari' => $diff,
			'jasaperawat' => $jasaperawat,
			'ceknull' => $ceknull
		);
		return $result;
	}

	private function string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter)
	{
		//var_dump($list_tindakan_pasien); die();
		$konten = "";
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		//    	<td colspan="3" >Tindakan</td>
		//    	<td >Pelaksana</td>
		//    	<td align="center">Tgl layanan</td>
		//   	<td align="center">Biaya Tindakan</td>
		//   	<td align="center">Qty</td>
		//   	<td align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	   <td colspan="6" >Tindakan</td>
		// ';
		$subtotal = 0;
		$subtotal_alkes = 0;
		if (($list_tindakan_pasien[0]['carabayar'] == 'BPJS' || $list_tindakan_pasien[0]['carabayar'] == 'UMUM') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
			foreach ($list_dokter as $d) {
				$subtotalinner = 0;
				$subtotal_alkesinner = 0;
				foreach ($list_tindakan_pasien as $r) {
					if ($d['idoprtr'] == $r['idoprtr']) {
						$subtotal = $subtotal + ($r['tumuminap'] * $r['qtyyanri']);
						$subtotalinner = $subtotalinner + ($r['tumuminap'] * $r['qtyyanri']);
						$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
						$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes'] * $r['qtyyanri']);
						$tumuminap = number_format($r['tumuminap'], 0);
						$vtot = number_format($r['vtot'], 0);
						// $konten = $konten. "
						// <tr>
						// <td colspan=\"3\" >".$r['nmtindakan']." (".$r['kelas'].")</td>
						// <td >".$r['nm_dokter']."</td>
						// <td align=\"center\">".date('d-m-Y',strtotime($r['tgl_layanan']))."</td>
						// <td align=\"center\">".$tumuminap."</td>
						// <td align=\"center\">".$r['qtyyanri']."</td>
						// <td align=\"right\">".($r['tumuminap']*$r['qtyyanri'])."</td>
						// </tr>					
						// ";
					}
				}
				// $konten = $konten."
				// 	<tr>
				// 			<td colspan=\"7\" align=\"right\">Total&nbsp;&nbsp;&nbsp;</td>
				// 			<td align=\"right\">Rp. ".number_format($subtotalinner,0)."</td>
				// 		</tr>
				// 	";
			}
			// $konten = $konten.'
			// 			<td >Tindakan</td>
			// 			<td colspan="7" align="center">Subtotal</td>
			// 			<td align="right">Rp. '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten.'				
			// 			<td align="right">'.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
		} else if (($list_tindakan_pasien[0]['carabayar'] == 'KERJASAMA') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
			foreach ($list_dokter as $d) {
				$subtotalinner = 0;
				$subtotal_alkesinner = 0;
				foreach ($list_tindakan_pasien as $r) {
					if ($d['idoprtr'] == $r['idoprtr']) {
						if (($r['tumuminap'] > $r['tarif_iks']) || ($r['tumuminap'] == $r['tarif_iks'])) {
							$subtotal = $subtotal + (($r['tumuminap'] * $r['qtyyanri']) - ($r['tarif_iks'] * $r['qtyyanri']));
						} else if ($r['tumuminap'] < $r['tarif_jatah']) {
							$subtotal = $subtotal + (0);
						}
						$subtotalinner = $subtotalinner + ($r['tumuminap'] * $r['qtyyanri']);
						$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
						$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes'] * $r['qtyyanri']);
						$tumuminap = number_format($r['tumuminap'], 0);
						$vtot = number_format($r['vtot'], 0);
						// $konten = $konten. "
						// <tr>
						// <td colspan=\"3\" >".$r['nmtindakan']." (".$r['kelas'].")</td>
						// <td >".$r['nm_dokter']."</td>
						// <td align=\"center\">".date('d-m-Y',strtotime($r['tgl_layanan']))."</td>
						// <td align=\"center\">".$tumuminap."</td>
						// <td align=\"center\">".$r['qtyyanri']."</td>
						// <td align=\"right\">".($r['tumuminap']*$r['qtyyanri'])."</td>
						// </tr>					
						// ";
					}
				}
				// $konten = $konten."
				// 	<tr>
				// 			<td colspan=\"7\" align=\"right\">Total&nbsp;&nbsp;&nbsp;</td>
				// 			<td align=\"right\">Rp. ".number_format($subtotalinner,0)."</td>
				// 		</tr>
				// 	";
			}
			// $konten = $konten.'
			// 			<td >Tindakan</td>
			// 			<td colspan="7" align="center">Subtotal</td>
			// 			<td align="right">Rp. '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten.'				
			// 			<td align="right">'.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
		} else if (($list_tindakan_pasien[0]['carabayar'] == 'BPJS' || $list_tindakan_pasien[0]['carabayar'] == 'UMUM') && ($list_tindakan_pasien[0]['titip'] == '1')) {
			foreach ($list_dokter as $d) {
				$subtotalinner = 0;
				$subtotal_alkesinner = 0;
				foreach ($list_tindakan_pasien as $r) {
					if ($d['idoprtr'] == $r['idoprtr']) {
						$subtotal = $subtotal + ($r['tarif_jatah'] * $r['qtyyanri']);
						$subtotalinner = $subtotalinner + ($r['tumuminap'] * $r['qtyyanri']);
						$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
						$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes'] * $r['qtyyanri']);
						$tumuminap = number_format($r['tumuminap'], 0);
						$vtot = number_format($r['vtot'], 0);
						// $konten = $konten. "
						// <tr>
						// <td colspan=\"3\" >".$r['nmtindakan']." (".$r['kelas'].")</td>
						// <td >".$r['nm_dokter']."</td>
						// <td align=\"center\">".date('d-m-Y',strtotime($r['tgl_layanan']))."</td>
						// <td align=\"center\">".$tumuminap."</td>
						// <td align=\"center\">".$r['qtyyanri']."</td>
						// <td align=\"right\">".($r['tumuminap']*$r['qtyyanri'])."</td>
						// </tr>					
						// ";
					}
				}
				// $konten = $konten."
				// 	<tr>
				// 			<td colspan=\"7\" align=\"right\">Total&nbsp;&nbsp;&nbsp;</td>
				// 			<td align=\"right\">Rp. ".number_format($subtotalinner,0)."</td>
				// 		</tr>
				// 	";
			}
			// $konten = $konten.'
			// 			<td >Tindakan</td>
			// 			<td colspan="7" align="center">Subtotal</td>
			// 			<td align="right">Rp. '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten.'				
			// 			<td align="right">'.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
		} else if ($list_tindakan_pasien[0]['carabayar'] == 'KERJASAMA' && $list_tindakan_pasien[0]['titip'] == '1') {
			foreach ($list_dokter as $d) {
				$subtotalinner = 0;
				$subtotal_alkesinner = 0;
				foreach ($list_tindakan_pasien as $r) {
					if ($d['idoprtr'] == $r['idoprtr']) {
						$subtotal = $subtotal + ($r['tarif_iks'] * $r['qtyyanri']);
						$subtotalinner = $subtotalinner + ($r['tumuminap'] * $r['qtyyanri']);
						$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
						$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes'] * $r['qtyyanri']);
						$tumuminap = number_format($r['tumuminap'], 0);
						$vtot = number_format($r['vtot'], 0);
						// $konten = $konten. "
						// <tr>
						// <td colspan=\"3\" >".$r['nmtindakan']." (".$r['kelas'].")</td>
						// <td >".$r['nm_dokter']."</td>
						// <td align=\"center\">".date('d-m-Y',strtotime($r['tgl_layanan']))."</td>
						// <td align=\"center\">".$tumuminap."</td>
						// <td align=\"center\">".$r['qtyyanri']."</td>
						// <td align=\"right\">".($r['tumuminap']*$r['qtyyanri'])."</td>
						// </tr>					
						// ";
					}
				}
				// $konten = $konten."
				// 	<tr>
				// 			<td colspan=\"7\" align=\"right\">Total&nbsp;&nbsp;&nbsp;</td>
				// 			<td align=\"right\">Rp. ".number_format($subtotalinner,0)."</td>
				// 		</tr>
				// 	";
			}
			// $konten = $konten.'
			// 			<td >Tindakan</td>
			// 			<td colspan="7" align="center">Subtotal</td>
			// 			<td align="right">Rp. '.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
			// $konten = $konten.'				
			// 			<td align="right">'.number_format($subtotal,0).'</td>
			// 		</tr>
			// 		';
		}
		//$konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_visite_faktur_rekap_iks_jatah($list_visite)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="20%" align="left">Konsul/Visite</td>
			   <td width="35%">Dokter</td>
			   <td width="25%">Ruang</td>
			   <td width="10%">Qty</td>
			   <td width="10%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_visite as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->tarif_iks * $r->qty;
			$konten = $konten . "
					<tr>
					<td align=\"left\">" . $r->nmtindakan . "</td>
					<td>" . $r->name . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->tarif_iks * $r->qty) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_visite_faktur_rekap_jatah($list_visite)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="20%" align="left">Konsul/Visite</td>
			   <td width="35%">Dokter</td>
			   <td width="25%">Ruang</td>
			   <td width="10%">Qty</td>
			   <td width="10%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_visite as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->tarif_jatah * $r->qty;
			$konten = $konten . "
					<tr>
					<td align=\"left\">" . $r->nmtindakan . "</td>
					<td>" . $r->name . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->tarif_jatah * $r->qty) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_visite_faktur_rekap($list_visite)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="20%" align="left">Konsul/Visite</td>
			   <td width="35%">Dokter</td>
			   <td width="25%">Ruang</td>
			   <td width="10%">Qty</td>
			   <td width="10%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_visite as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->total;
			$konten = $konten . "
					<tr>
					<td align=\"left\">" . $r->nmtindakan . "</td>
					<td>" . $r->name . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->total) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_faktur_rekap_iks_jatah($list_tindakan_pasien, $list_dokter)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="25%">Tindakan</td>
			   <td width="25%">Ruang</td>
			   <td width="15%">Qty</td>
			   <td width="15%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_tindakan_pasien as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->tarif_iks * $r->qty;
			$konten = $konten . "
					<tr>
					<td>" . $r->nmtindakan . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->tarif_iks * $r->qty) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_faktur_rekap_jatah($list_tindakan_pasien, $list_dokter)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="25%">Tindakan</td>
			   <td width="25%">Ruang</td>
			   <td width="15%">Qty</td>
			   <td width="15%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_tindakan_pasien as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->tarif_jatah * $r->qty;
			$konten = $konten . "
					<tr>
					<td>" . $r->nmtindakan . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->tarif_jatah * $r->qty) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_faktur_rekap($list_tindakan_pasien, $list_dokter)
	{
		$konten = "";

		//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td width="25%">Tindakan</td>
			   <td width="25%">Ruang</td>
			   <td width="15%">Qty</td>
			   <td width="15%" align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		//foreach($list_dokter as $d){	
		$subtotalinner = 0;
		$subtotal_alkesinner = 0;
		foreach ($list_tindakan_pasien as $r) {
			//if($d['idoprtr']==$r['idoprtr']){
			$subtotal += $r->total;
			$konten = $konten . "
					<tr>
					<td>" . $r->nmtindakan . "</td>
					<td>" . $r->nmruang . "</td>
					<td>" . $r->qty . "</td>
					<td align=\"right\">" . number_format($r->total) . "</td>
					</tr>					
					";
			//}

		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_faktur_sementara($list_tindakan_pasien, $list_dokter)
	{
		// var_dump($list_tindakan_pasien);die();
		$konten = "";

		
			$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="6" width="25%">Tindakan</td>
				<td align="center" width="15%">Pelaksana</td>
				<td align="center" width="15%">Tgl layanan</td>
				<td align="center" width="15%">Biaya Tindakan</td>
				<td align="center" width="15%">Qty</td>
				<td align="right" width="15%">Total</td>
			</tr>
			';
			$subtotal = 0;
			$subtotal_alkes = 0;
			$subtotalinner = 0;
			$subtotal_alkesinner = 0;
			foreach ($list_tindakan_pasien as $r) {
				$subtotal += $r['tumuminap'] * $r['qtyyanri'];
				$subtotalinner = $subtotalinner + ($r['tumuminap'] * $r['qtyyanri']);
				$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
				$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes'] * $r['qtyyanri']);
				$tumuminap = number_format($r['tumuminap'], 0);
				$vtot = number_format($r['vtot'], 0);
				$konten = $konten . "
					<tr>
					<td colspan=\"6\" >" . $r['nmtindakan'] . "</td>
					<td >" . $r['pelaksana'] . "</td>
					<td align=\"center\">" . date('d-m-Y', strtotime($r['tgl_layanan'])) . "</td>
					<td align=\"center\">" . $tumuminap . "</td>
					<td align=\"center\">" . $r['qtyyanri'] . "</td>
					<td align=\"right\">" . number_format($r['tumuminap'] * $r['qtyyanri']) . "</td>
					</tr>					
					";
				//}

			}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="10" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_ird_faktur($list_tindakan_pasien)
	{
		$konten = "";

		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	   <td colspan="6" >Tindakan</td>
		// ';
		$subtotal = 0;

		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);
		}

		// 	$konten = $konten.'				
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
		);
		return $result;
	}

	private function string_table_tindakan_ird_faktur_rekap($list_tindakan_pasien)
	{
		$konten = "";

		$konten = $konten . '
	<table class="table-isi" border="0" style="width: 100%;" width="100%">
	<tr style="font-weight:bold;">
		   <td align="left">Tindakan</td>
		   <td align="center">Qty</td>
		  <td align="right">Total</td>
	</tr>
	';
		$subtotal = 0;

		foreach ($list_tindakan_pasien as $r) {
			$subtotal += $r->total;
			$konten = $konten . "
			<tr>
				<td align=\"left\">" . $r->nmtindakan . "</td>
				<td align=\"center\">" . $r->qty . "</td>
				<td align=\"right\">" . number_format($r->total) . "</td>
			</tr>
			";
		}

		$konten = $konten . '				
			<tr style="font-weight:bold;">
				<td colspan="2" align="left">Total</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
		);
		return $result;
	}

	private function string_table_tindakan_ird_faktur_sementara($list_tindakan_pasien)
	{
		$konten = "";

		$konten = $konten . '
	<table class="table-isi" border="0" style="width: 100%;" width="100%">
	<tr style="font-weight:bold;">
		   <td align="left" colspan="3">Tindakan</td>
		   <td align="left">Pelaksana</td>
		   <td align="center">Tgl layanan</td>
		  <td align="right">Total</td>
	</tr>
	';
		$subtotal = 0;

		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);
			$konten = $konten . "
			<tr>
				<td align=\"left\" colspan=\"3\">" . $r['nmtindakan'] . "</td>
				<td align=\"left\">" . $r['nm_dokter'] . "</td>
				<td align=\"center\">" . date("d-m-Y", strtotime($r['tgl_kunjungan'])) . "</td>
				<td align=\"right\">" . number_format($r['vtot'], 0) . "</td>
			</tr>
			";
		}

		$konten = $konten . '				
			<tr style="font-weight:bold;">
				<td colspan="5" align="left">Total</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
		);
		return $result;
	}

	private function string_table_tindakan($list_tindakan_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		   <td colspan="3" align="center">Tindakan</td>
		   <td align="center">Pelaksana</td>
		  <td align="center">Biaya Tindakan</td>
		  <td align="center">Biaya Alkes</td>
		  <td align="center">Qty</td>
		  <td align="center">Total</td>
	</tr>
	';
		$subtotal = 0;
		$subtotal_alkes = 0;
		$vtot = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + ($r['tumuminap'] * $r['qtyyanri']);
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'], 0);
			$vtot = $vtot + ($r['tumuminap'] * $r['qtyyanri']);
			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"center\">" . $r['nmtindakan'] . "</td>
		<td align=\"center\">" . $r['nm_dokter'] . "</td>
		<td align=\"center\">" . $tumuminap . "</td>
		<td align=\"center\">" . $r['tarifalkes'] . "</td>
		<td align=\"center\">" . $r['qtyyanri'] . "</td>
		<td align=\"right\">" . $vtot . "</td>
	</tr>
		";
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'vtot' => $vtot,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_perawat($list_tindakan_pasien, $list_ruang)
	{
		$konten = "";
		//<table class="table-isi" border="0">
		$konten = $konten . '
			
	';
		$subtotal = 0;
		$subtotal_vk = 0;
		$subtotal_alkes = 0;
		$subtotal_alkes_vk = 0;

		foreach ($list_ruang as $s) {
			$subtotal_intern = 0;
			foreach ($list_tindakan_pasien as $r) {

				//echo strpos($r['nmruang'],'anyelir');
				if ($r['lokasi'] == $s['lokasi']) {
					$subtotal = $subtotal + $r['vtot'];
					$subtotal_intern = $subtotal_intern + $r['vtot'];
					$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
					$tumuminap = number_format($r['tumuminap'], 0);
				}
			}
			if ($subtotal_intern != 0) {
				$konten = $konten . '
						<tr>
							<td colspan="7" >Tindakan Perawat ' . $s['lokasi'] . '</td>
							<td align="right">' . number_format($subtotal_intern, 0) . '</td>
						</tr>
					';
			}
		}



		//$konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_perawat_anyelir($list_tindakan_pasien)
	{
		$konten = "";
		//<table class="table-isi" border="0">
		$konten = $konten . '
			
	';
		$subtotal = 0;
		$subtotal_vk = 0;
		$subtotal_alkes = 0;
		$subtotal_alkes_vk = 0;

		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + ($r['tumuminap'] * $r['qtyyanri']);
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * $r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'], 0);
		}
		$konten = $konten . '
						<tr>
							<td colspan="7" >Tindakan Perawat Anyelir</td>
							<td align="right">' . number_format($subtotal, 0) . '</td>
						</tr>
					';


		//$konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_dokter($list_tindakan_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		   <td colspan="3" align="center">Tindakan</td>
		   <td colspan="2" align="center">Pelaksana</td>
		  <td align="center">Biaya Tindakan</td>		  	
		  <td align="center">Qty</td>
		  <td align="center">Total</td>
	</tr>
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['tumuminap'] * (int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes'] * (int)$r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'], 0);
			//$vtot = number_format($r['endtotal'],0);

			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"center\">" . $r['nmtindakan'] . "</td>
		<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
		<td align=\"center\">" . $tumuminap . "</td>			
		<td align=\"center\">" . $r['qtyyanri'] . "</td>
		<td align=\"right\">" . number_format($vtottind, 0) . "</td>
	</tr>
		";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_dokter_kw($list_tindakan_pasien)
	{
		$konten = "";
		/*<tr>
		   <td colspan="3" align="center">Tindakan Rawat Inap</td>
		   <td colspan="3" align="left">Pelaksana</td>
		  <td colspan="2" align="center"></td>
	</tr>*/
		$konten = $konten . '
	<table class="table-isi" border="0">
	
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['vtot'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			//$vtot = number_format($r['endtotal'],0);			
			/*if($r['idkel_tind']=='3' or $r['idkel_tind']=='18' or $r['idkel_tind']=='24' or $r['idkel_tind']=='25' or $r['idkel_tind']=='26' or $r['idkel_tind']=='27' or $r['idkel_tind']=='28' or $r['idkel_tind']=='29' or $r['idkel_tind']=='30'){*/
			$tot1 = $vtottind;
			$tot2 = substr($tot1, -3);
			if ($tot2 % 1000 != 0) {
				$mod = $tot2 % 1000;
				$tot1 = $tot1 - $mod;
				$tot1 = $tot1 + 1000;
			}
			$vtottind = $tot1;
			if ($r['idkel_tind'] != '0') {
				$konten = $konten . "
			<tr>
				<td colspan=\"3\" >" . $r['nama_kel'] . "</td>
				<td colspan=\"3\" align=\"left\">" . $r['nm_dokter'] . "</td>
				<td colspan=\"2\" align=\"right\">" . number_format($vtottind, 0) . "</td>
			</tr>
			";
			} else {
				$konten = $konten . "
			<tr>
				<td colspan=\"3\" >" . $r['nmtindakan'] . "</td>
				<td colspan=\"3\" align=\"left\">" . $r['nm_dokter'] . "</td>
				<td colspan=\"2\" align=\"right\">" . number_format($vtottind, 0) . "</td>
			</tr>
			";
			}

			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
			</tr>
			';*/
		$konten = $konten . "</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_tindakan_kel_kw($list_tindakan_pasien)
	{
		$konten = "";
		/*<tr>
		   <td colspan="3" align="center">Tindakan Rawat Inap</td>
		   <td colspan="3" align="left">Pelaksana</td>
		  <td colspan="2" align="center"></td>
	</tr>*/
		$konten = $konten . '
	<table class="table-isi" border="0">
	
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['vtot'];
			$vtott = (int)$r['vtot'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			//$vtot = number_format($r['endtotal'],0);			
			$konten = $konten . "
			<tr>
				<td colspan=\"6\" >" . $r['nama_kel'] . "</td>
				<td colspan=\"2\" align=\"right\">" . number_format($vtott, 0) . "</td>
			</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
			</tr>
			';*/
		$konten = $konten . "</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_ruang($list_tindakan_pasien)
	{

		$subtotal = 0;
		//$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot_ruang'];
			//$subtotal_tind = $subtotal_tind + $r['vtot'];			

		}
		$result = array(
			'subtotal' => $subtotal
			//		'subtotal_tind' => $subtotal_tind
		);
		return $result;
	}


	private function string_table_icu($list_tindakan_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		   <td colspan="3" align="center">Tindakan ICU</td>
		   <td colspan="2" align="center">Pelaksana</td>
		  <td align="center">Biaya Tindakan</td>		  	
		  <td align="center">Qty</td>
		  <td align="center">Total</td>
	</tr>
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotalruang = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['tumuminap'] * (int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);

			//$vtot = number_format($r['endtotal'],0);

			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"center\">" . $r['nmtindakan'] . " (" . $r['kelas'] . ")</td>
		<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
		<td align=\"center\">" . $tumuminap . "</td>			
		<td align=\"center\">" . $r['qtyyanri'] . "</td>
		<td align=\"right\">" . number_format($vtottind, 0) . "</td>
	</tr>
		";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";


		$result = array(
			'subtotal' => $subtotal,
			//'subtotalruang' => $subtotalruang,
			'konten' => $konten,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_icu_kw($list_tindakan_pasien)
	{
		$konten = "";
		/*<tr>
		   <td colspan="3" align="center">Tindakan ICU</td>
		   <td colspan="3" align="center">Pelaksana</td>
		  <td colspan="2" align="center"></td>
	</tr>*/
		$konten = $konten . '
	<table class="table-isi" border="0">		
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotalruang = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['tumuminap'] * (int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);

			//$vtot = number_format($r['endtotal'],0);

			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"center\">" . $r['nmtindakan'] . " (" . $r['kelas'] . ")</td>
		<td colspan=\"3\" align=\"center\">" . $r['nm_dokter'] . "</td>
		<td colspan=\"2\" align=\"right\">" . number_format($vtottind, 0) . "</td>
	</tr>
		";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">Rp. '.number_format($subtotal,0).'</td>
			</tr>
			';*/
		$konten = $konten . "</table>";


		$result = array(
			'subtotal' => $subtotal,
			//'subtotalruang' => $subtotalruang,
			'konten' => $konten,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_vk_kw($list_tindakan_pasien, $kamar_konten, $totkamarvk)
	{
		$konten = "";
		/*<tr>
		   <td colspan="3" align="center">Tindakan VK</td>
		   <td colspan="3" align="left">Pelaksana</td>
		  <td colspan="2" align="center"></td>
	</tr>*/
		$konten = $konten . '
	<table class="table-isi" border="0">		
	' . $kamar_konten;
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotalruang = 0;
		$subtotal_alkes = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['tumuminap'] * (int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			//$vtot = number_format($r['endtotal'],0);

			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"left\">" . $r['nmtindakan'] . " (" . $r['kelas'] . ")</td>
		<td colspan=\"3\" align=\"left\">" . $r['nm_dokter'] . "</td>
		<td colspan=\"2\" align=\"right\">" . number_format($vtottind, 0) . "</td>
	</tr>
		";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td colspan="2" align="right"> '.number_format($subtotal+$totkamarvk,0).'</td>
			</tr>
			';*/
		$konten = $konten . "</table>";
		$result = array(
			'subtotal' => $subtotal,
			//'subtotalruang' => $subtotalruang,
			'konten' => $konten,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_vk($list_tindakan_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		   <td colspan="3" align="center">Tindakan VK</td>
		   <td colspan="2" align="center">Pelaksana</td>
		  <td align="center">Biaya Tindakan</td>		  	
		  <td align="center">Qty</td>
		  <td align="center">Total Biaya</td>
	</tr>
	';
		//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotalruang = 0;
		$subtotal_alkes = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind = (int)$r['tumuminap'] * (int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			//$vtot = number_format($r['endtotal'],0);

			$konten = $konten . "
		<tr>
		<td colspan=\"3\" align=\"center\">" . $r['nmtindakan'] . " (" . $r['kelas'] . ")</td>
		<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
		<td align=\"center\">" . $tumuminap . "</td>			
		<td align=\"center\">" . $r['qtyyanri'] . "</td>
		<td align=\"right\">" . number_format($vtottind, 0) . "</td>
	</tr>
		";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="center">Subtotal</td>
				<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'subtotal' => $subtotal,
			//'subtotalruang' => $subtotalruang,
			'konten' => $konten,
			'subtotal_alkes' => $subtotal_alkes
		);
		return $result;
	}

	private function string_table_radiologi($list_radiologi)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal += ($r['biaya_rad'] * $r['qty']);
		}
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_ird($list_rad_ird)
	{
		$konten = "";
		//<table border="1">
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		// 	<td colspan="3" >Jenis Tind Radiologi</td>
		// 	<td colspan="3" >Dokter</td>
		// 	<td colspan="2" align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	<td colspan="6" >Radiologi</td>
		// ';
		$subtotal = 0;

		foreach ($list_rad_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_rad'] * $r['qty']);
			// $konten = $konten. "
			// <tr>
			// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
			// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
			// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
			// </tr>
			// ";
		}
		// $konten = $konten.'
		// 		<tr>
		// 			<td colspan="7" align="center">Subtotal</td>
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten.'
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';

		// $konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_rekap_iks_jatah($list_radiologi)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Radiologi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
	';

		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal += $r->tarif_iks * $r->qtx;
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_rekap_iks($list_radiologi)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Radiologi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
	';

		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->total_rekap) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_rekap_jatah($list_radiologi)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Radiologi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			if ($list_radiologi[0]->tgl_masuk >= '2023-04-06') {
				$subtotal += $r->tarif_jatah_bpjs * $r->qtx;
				$konten = $konten . "
			<tr>
				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
			</tr>";
			} else if ($list_radiologi[0]->tgl_masuk < '2023-04-06') {
				$subtotal += $r->biaya_rad * $r->qtx;
				$konten = $konten . "
			<tr>
				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->biaya_rad * $r->qtx) . "</td>
			</tr>";
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_rekap($list_radiologi)
	{
		$konten = "";
		// <table border="1">
		//var_dump($list_radiologi[0]->carabayar);die();
		if ($list_radiologi[0]->titip == NULL) {
			if ($list_radiologi[0]->carabayar == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					$subtotal += $r->total_rekap;
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->total_tarif * $r->qtx) . "</td>
				</tr>
				";
				}
			} else if ($list_radiologi[0]->carabayar == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					if ($list_radiologi[0]->tgl_masuk >= '2023-04-06') {
						$subtotal += $r->tarif_bpjs * $r->qtx;
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . number_format($r->tarif_bpjs * $r->qtx) . "</td>
					</tr>
					";
					} else if ($list_radiologi[0]->tgl_masuk < '2023-04-06') {
						$subtotal += $r->biaya_rad * $r->qtx;
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . number_format($r->biaya_rad * $r->qtx) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_radiologi[0]->carabayar == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="center">Total Kelas</td>
				<td align="center">Total Jatah</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
						$subtotal = $subtotal + (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx));
					} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
						$subtotal = $subtotal + (0);
					}

					if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"center\">" . intval($r->tarif_jatah_iks * $r->qtx) . "</td>
						<td align=\"center\">" . intval($r->tarif_iks * $r->qtx) . "</td>
						<td align=\"right\">" . intval(($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx)) . "</td>
					</tr>
					";
					} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
						$konten = $konten . "
					<tr>
					<td align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"center\">" . intval($r->tarif_jatah_iks * $r->qtx) . "</td>
					<td align=\"center\">" . intval($r->tarif_iks * $r->qtx) . "</td>
						<td align=\"right\">" . intval(0) . "</td>
					</tr>
					";
					}
				}
			}
		} else {
			if ($list_radiologi[0]->carabayar == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r->tarif_jatah * $r->qtx);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . intval($r->tarif_jatah * $r->qtx) . "</td>
				</tr>
				";
				}
			} else if ($list_radiologi[0]->carabayar == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					if ($list_radiologi[0]->tgl_masuk >= '2023-04-06') {
						$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . intval($r->tarif_jatah_bpjs * $r->qtx) . "</td>
					</tr>
					";
					} else if ($list_radiologi[0]->tgl_masuk < '2023-04-06') {
						$subtotal = $subtotal + ($r->biaya_rad * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . intval($r->biaya_rad * $r->qtx) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_radiologi[0]->carabayar == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . intval($r->tarif_iks * $r->qtx) . "</td>
				</tr>
				";
				}
			}
		}
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_sementara($list_radiologi)
	{
		$konten = "";
		// <table border="1">
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Radiologi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r['biaya_rad'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['nm_dokter'] . "</td>
					<td align=\"right\">" . intval($r['biaya_rad'] * $r['qty']) . "</td>
				</tr>
				";
				}
			
		

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_ird_rekap($list_rad_ird)
	{
		$konten = "";
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td align="left">Jenis Tind Radiologi</td>
			<td align="center">qty</td>
			<td align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_rad_ird as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
			<tr>
				<td align=\"left\">" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . intval($r->total_rekap) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="2" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_radiologi_ird_sementara($list_rad_ird)
	{
		$konten = "";
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="5" align="left">Jenis Tind Radiologi</td>
			<td colspan="5" align="center">Dokter</td>
			<td colspan="4" align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_rad_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_rad'] * $r['qty']);
			$konten = $konten . "
			<tr>
				<td colspan=\"5\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"5\" align=\"center\">" . $r['nm_dokter'] . "</td>
				<td colspan=\"4\" align=\"right\">" . intval($r['biaya_rad'] * $r['qty']) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="13" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik($list_elektromedik)
	{
		$konten = "";
		//<table border="1">
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		// 	<td colspan="3" >Jenis Tind Elektromedik</td>
		// 	<td colspan="3" >Dokter</td>
		// 	<td colspan="2" align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	<td colspan="6" >Elektromedik</td>
		// ';
		$subtotal = 0;
		// if(($list_elektromedik[0]['cara_bayar']=='BPJS' || $list_elektromedik[0]['cara_bayar']=='UMUM') && ($list_elektromedik[0]['titip']==NULL)) {
		// 	foreach ($list_elektromedik as $r) {
		// 		$subtotal = $subtotal + ($r['biaya_em']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_elektromedik[0]['cara_bayar']=='KERJASAMA') && ($list_elektromedik[0]['titip']==NULL)) {
		// 	foreach ($list_elektromedik as $r) {
		// 		if(($r['biaya_em'] > $r['tarif_iks']) || ($r['biaya_em'] == $r['tarif_iks'])) {
		// 			$subtotal = $subtotal + (($r['biaya_em']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
		// 		} else if($r['biaya_em'] < $r['tarif_iks']) {
		// 			$subtotal = $subtotal + (0);
		// 		}
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_elektromedik[0]['cara_bayar']=='BPJS' || $list_elektromedik[0]['cara_bayar']=='UMUM') && ($list_elektromedik[0]['titip']=='1')) {
		// 	foreach ($list_elektromedik as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if($list_elektromedik[0]['cara_bayar']=='KERJASAMA' && $list_elektromedik[0]['titip']=='1') {
		// 	foreach ($list_elektromedik as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// }
		//$konten = $konten."</table>";
		if ($list_elektromedik[0]['titip'] == '1') {
			if ($list_elektromedik[0]['carabayar'] == 'UMUM') {
				foreach ($list_elektromedik as $r) {
					$subtotal += ($r['tarif_jatah'] * $r['qty']);
				}
			} else if ($list_elektromedik[0]['carabayar'] == 'BPJS') {
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['tarif_jatah_bpjs'] * $r['qty']);
					} else if ($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['biaya_em'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_elektromedik as $r) {
					$subtotal += ($r['tarif_iks'] * $r['qty']);
				}
			}
		} else {
			if ($list_elektromedik[0]['carabayar'] == 'UMUM') {
				foreach ($list_elektromedik as $r) {
					$subtotal += ($r['biaya_lab'] * $r['qty']);
				}
			} else if ($list_elektromedik[0]['carabayar'] == 'BPJS') {
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['tarif_bpjs'] * $r['qty']);
					} else if ($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['biaya_em'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_elektromedik as $r) {
					$subtotal += ($r['tarif_jatah_iks'] * $r['qty']);
				}
			}
		}
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_ird($list_em_ird)
	{
		$konten = "";
		//<table border="1">
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		// 	<td colspan="3" >Jenis Tind Elektromedik</td>
		// 	<td colspan="3" >Dokter</td>
		// 	<td colspan="2" align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	<td colspan="6" >Elektromedik</td>
		// ';
		$subtotal = 0;

		foreach ($list_em_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
			// $konten = $konten. "
			// <tr>
			// 	<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
			// 	<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
			// 	<td colspan=\"2\" align=\"center\">".$r['vtot']."</td>
			// </tr>
			// ";
		}
		// $konten = $konten.'
		// 		<tr>
		// 			<td colspan="7" align="center">Subtotal</td>
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten.'
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';

		// $konten = $konten."</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_rekap_iks_jatah($list_elektromedik)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Elektromedik</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_elektromedik as $r) {
			$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_rekap_iks($list_elektromedik)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Elektromedik</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_elektromedik as $r) {
			$subtotal = $subtotal + ($r->tarif_jatah_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_rekap_jatah($list_elektromedik)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Elektromedik</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_elektromedik as $r) {
			if ($list_elektromedik[0]->tgl_masuk >= '2023-04-06') {
				$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
				$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
				</tr>";
			} else if ($list_elektromedik[0]->tgl_masuk < '2023-04-06') {
				$subtotal = $subtotal + ($r->biaya_em * $r->qtx);
				$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->biaya_em * $r->qtx) . "</td>
				</tr>";
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_rekap($list_elektromedik)
	{
		$konten = "";
		// <table border="1">
		if ($list_elektromedik[0]->titip == NULL) {
			if ($list_elektromedik[0]->carabayar == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r->total_tarif * $r->qtx);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->total_tarif * $r->qtx) . "</td>
				</tr>
				";
				}
			} else if ($list_elektromedik[0]->carabayar == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]->tgl_masuk >= '2023-04-06') {
						$subtotal = $subtotal + ($r->tarif_bpjs * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . number_format($r->tarif_bpjs * $r->qtx) . "</td>
					</tr>
					";
					} else if ($list_elektromedik[0]->tgl_masuk < '2023-04-06') {
						$subtotal = $subtotal + ($r->biaya_em * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . number_format($r->biaya_em * $r->qtx) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_elektromedik[0]->carabayar == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="center">Total Kelas</td>
				<td align="center">Total Jatah</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
						$subtotal = $subtotal + (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx));
					} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
						$subtotal = $subtotal + (0);
					}

					if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"center\">" . ($r->tarif_jatah_iks * $r->qtx) . "</td>
						<td align=\"center\">" . ($r->tarif_iks * $r->qtx) . "</td>
						<td align=\"right\">" . (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx)) . "</td>
					</tr>
					";
					} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"center\">" . ($r->tarif_jatah_iks * $r->qtx) . "</td>
						<td align=\"center\">" . ($r->tarif_iks * $r->qtx) . "</td>
						<td align=\"right\">" . number_format(0) . "</td>
					</tr>
					";
					}
				}
			}
		} else {
			if ($list_elektromedik[0]->carabayar == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r->tarif_jatah * $r->qtx);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . ($r->tarif_jatah * $r->qtx) . "</td>
				</tr>
				";
				}
			} else if ($list_elektromedik[0]->carabayar == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]->tgl_masuk >= '2023-04-06') {
						$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . ($r->tarif_jatah_bpjs * $r->qtx) . "</td>
					</tr>
					";
					} else if ($list_elektromedik[0]->tgl_masuk < '2023-04-06') {
						$subtotal = $subtotal + ($r->biaya_em * $r->qtx);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
						<td align=\"center\">" . $r->qtx . "</td>
						<td align=\"right\">" . ($r->biaya_em * $r->qtx) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_elektromedik[0]->carabayar == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . ($r->tarif_iks * $r->qtx) . "</td>
				</tr>
				";
				}
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_sementara($list_elektromedik)
	{
		$konten = "";
		// <table border="1">
		if ($list_elektromedik[0]['titip'] == NULL) {
			if ($list_elektromedik[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['total_tarif'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['nm_dokter'] . "</td>
					<td align=\"right\">" . ($r['total_tarif'] * $r['qty']) . "</td>
				</tr>
				";
				}
			} else if ($list_elektromedik[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_bpjs'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"right\">" . ($r['tarif_bpjs'] * $r['qty']) . "</td>
					</tr>
					";
					} else if ($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"right\">" . ($r['biaya_em'] * $r['qty']) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_elektromedik[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="center">Total Kelas</td>
				<td align="center">Total Jatah</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']));
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}

					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . ($r['tarif_jatah_iks'] * $r['qty']) . "</td>
						<td align=\"center\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
						<td align=\"right\">" . (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty'])) . "</td>
					</tr>
					";
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . ($r['tarif_jatah_iks'] * $r['qty']) . "</td>
						<td align=\"center\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
						<td align=\"right\">" . number_format(0) . "</td>
					</tr>
					";
					}
				}
			}
		} else {
			if ($list_elektromedik[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['nm_dokter'] . "</td>
					<td align=\"right\">" . ($r['tarif_jatah'] * $r['qty']) . "</td>
				</tr>
				";
				}
			} else if ($list_elektromedik[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					if ($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"right\">" . ($r['tarif_jatah_bpjs'] * $r['qty']) . "</td>
					</tr>
					";
					} else if ($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"right\">" . ($r['biaya_em'] * $r['qty']) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_elektromedik[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Elektromedik</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['tarif_iks'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['nm_dokter'] . "</td>
					<td align=\"right\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
				</tr>
				";
				}
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_ird_rekap($list_em_ird)
	{
		$konten = "";
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td align="left">Jenis Tind Elektromedik</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_em_ird as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
			<tr>
				<td align=\"left\">" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->total_rekap) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="2" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_ird_sementara($list_em_ird)
	{
		$konten = "";
		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="5" align="left">Jenis Tind Elektromedik</td>
			<td colspan="5" align="center">Dokter</td>
			<td colspan="4" align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_em_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
			$konten = $konten . "
			<tr>
				<td colspan=\"5\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"5\" align=\"center\">" . $r['nm_dokter'] . "</td>
				<td colspan=\"4\" align=\"right\">" . ($r['biaya_em'] * $r['qty']) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="13" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi($list_ok_pasien)
	{
		$konten = "";
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		// 	<td colspan="3" align="center">Jenis Tind Operasi</td>
		// 	<td colspan="3" align="left">Dokter</td>
		// 	<td colspan="2" align="center"></td>
		// </tr>
		// ';
		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	<td colspan="6">Operasi</td>
		// ';
		$subtotal = 0;
		// if(($list_ok_pasien[0]['cara_bayar']=='BPJS' || $list_ok_pasien[0]['cara_bayar']=='UMUM') && ($list_ok_pasien[0]['titip']==NULL)) {
		// 	foreach ($list_ok_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['biaya_ok']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="6" align="right">Subtotal</td>
		// 	// 			<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_ok_pasien[0]['cara_bayar']=='KERJASAMA') && ($list_ok_pasien[0]['titip']==NULL)) {
		// 	foreach ($list_ok_pasien as $r) {
		// 		if(($r['biaya_ok'] > $r['tarif_iks']) || ($r['biaya_ok'] == $r['tarif_iks'])) {
		// 			$subtotal = $subtotal + (($r['biaya_ok']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
		// 		} else if($r['biaya_ok'] < $r['tarif_iks']) {
		// 			$subtotal = $subtotal + (0);
		// 		}
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="6" align="right">Subtotal</td>
		// 	// 			<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_ok_pasien[0]['cara_bayar']=='BPJS' || $list_ok_pasien[0]['cara_bayar']=='UMUM') && ($list_ok_pasien[0]['titip']=='1')) {
		// 	foreach ($list_ok_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="6" align="right">Subtotal</td>
		// 	// 			<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if($list_ok_pasien[0]['cara_bayar']=='KERJASAMA' && $list_ok_pasien[0]['titip']=='1') {
		// 	foreach ($list_ok_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
		// 		// $konten = $konten. "
		// 		// <tr>
		// 		// 	<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
		// 		// 	<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
		// 		// 	<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
		// 		// </tr>
		// 		// ";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="6" align="right">Subtotal</td>
		// 	// 			<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// }
		//$konten = $konten."</table>";
		if ($list_ok_pasien[0]['titip'] == '1') {
			if ($list_ok_pasien[0]['carabayar'] == 'UMUM') {
				foreach ($list_ok_pasien as $r) {
					$subtotal += ($r['tarif_jatah'] * $r['qty']);
				}
			} else if ($list_ok_pasien[0]['carabayar'] == 'BPJS') {
				foreach ($list_ok_pasien as $r) {
					if ($list_ok_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['tarif_jatah_bpjs'] * $r['qty']);
					} else if ($list_ok_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['biaya_ok'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_ok_pasien as $r) {
					$subtotal += ($r['tarif_iks'] * $r['qty']);
				}
			}
		} else {
			if ($list_ok_pasien[0]['carabayar'] == 'UMUM') {
				foreach ($list_ok_pasien as $r) {
					$subtotal += ($r['biaya_lab'] * $r['qty']);
				}
			} else if ($list_ok_pasien[0]['carabayar'] == 'BPJS') {
				foreach ($list_ok_pasien as $r) {
					if ($list_ok_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['tarif_bpjs'] * $r['qty']);
					} else if ($list_ok_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['biaya_ok'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_ok_pasien as $r) {
					$subtotal += ($r['tarif_jatah_iks'] * $r['qty']);
				}
			}
		}
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_ird($list_ok_ird)
	{
		$konten = "";
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		// 	<td colspan="3" align="center">Jenis Tind Operasi</td>
		// 	<td colspan="3" align="left">Dokter</td>
		// 	<td colspan="2" align="center"></td>
		// </tr>
		// ';
		$konten = $konten . '
	<table class="table-isi" border="0" style="width: 100%;" width="100%">
	<tr>
		<td colspan="6">Operasi</td>
	';
		$subtotal = 0;

		foreach ($list_ok_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
			// $konten = $konten. "
			// <tr>
			// 	<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
			// 	<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
			// 	<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
			// </tr>
			// ";
		}
		// $konten = $konten.'
		// 		<tr>
		// 			<td colspan="6" align="right">Subtotal</td>
		// 			<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		$konten = $konten . '
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';

		$konten = $konten . "</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_rekap_iks_jatah($list_ok_pasien)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Operasi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_rekap_iks($list_ok_pasien)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Operasi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + ($r->tarif_jatah_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_rekap_jatah($list_ok_pasien)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" align="left">Jenis Tind Operasi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			if ($list_ok_pasien[0]->tgl_masuk >= '2023-04-06') {
				$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
				$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
				</tr>";
			} else if ($list_ok_pasien[0]->tgl_masuk < '2023-04-06') {
				$subtotal = $subtotal + ($r->biaya_ok * $r->qtx);
				$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
					<td align=\"center\">" . $r->qtx . "</td>
					<td align=\"right\">" . number_format($r->biaya_ok * $r->qtx) . "</td>
				</tr>";
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_rekap($list_ok_pasien)
	{
		$konten = "";
		$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';

		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
			<tr>
				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->total_rekap) . "</td>
			</tr>";
		}

		// if ($list_ok_pasien[0]->titip == NULL) {
		// 	if ($list_ok_pasien[0]->carabayar == 'UMUM') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			$subtotal = $subtotal + ($r->total_tarif * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 			<td align=\"center\">" . $r->qtx . "</td>
		// 			<td align=\"right\">" . number_format($r->total_tarif * $r->qtx) . "</td>
		// 		</tr>
		// 		";
		// 		}
		// 	} else if ($list_ok_pasien[0]->carabayar == 'BPJS') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			if ($list_ok_pasien[0]->tgl_masuk >= '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->tarif_bpjs * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->tarif_bpjs * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($list_ok_pasien[0]->tgl_masuk < '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->biaya_ok * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->biaya_ok * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	} else if ($list_ok_pasien[0]->carabayar == 'KERJASAMA') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="center">Total Kelas</td>
		// 		<td align="center">Total Jatah</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
		// 				$subtotal = $subtotal + (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx));
		// 			} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
		// 				$subtotal = $subtotal + (0);
		// 			}

		// 			if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 				<td align=\"right\">" . number_format(($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx)) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 				<td align=\"right\">" . number_format(0) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	}
		// } else {
		// 	if ($list_ok_pasien[0]->carabayar == 'UMUM') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			$subtotal = $subtotal + ($r->tarif_jatah * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 			<td align=\"center\">" . $r->qtx . "</td>
		// 			<td align=\"right\">" . number_format($r->tarif_jatah * $r->qtx) . "</td>
		// 		</tr>
		// 		";
		// 		}
		// 	} else if ($list_ok_pasien[0]->carabayar == 'BPJS') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			if ($list_ok_pasien[0]->tgl_masuk >= '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($list_ok_pasien[0]->tgl_masuk < '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->biaya_ok * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->biaya_ok * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	} else if ($list_ok_pasien[0]->carabayar == 'KERJASAMA') {
		// 		$konten = $konten . '
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" align="left">Jenis Tind Operasi</td>
		// 		<td align="center">Qty</td>
		// 		<td align="right">Total</td>
		// 	</tr>
		// 	';

		// 		$subtotal = 0;
		// 		foreach ($list_ok_pasien as $r) {
		// 			$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 			<td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
		// 			<td align=\"center\">" . $r->qtx . "</td>
		// 			<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 		</tr>
		// 		";
		// 		}
		// 	}
		// }

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_sementara($list_ok_pasien)
	{
		$konten = "";

		if ($list_ok_pasien[0]['titip'] == NULL) {
			if ($list_ok_pasien[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['dok_ok'] . "</td>
					<td align=\"right\">" . number_format($r['total_tarif'] * $r['qty'], 0) . "</td>
				</tr>
				";
				}
			} else if ($list_ok_pasien[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					if ($list_ok_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
					</tr>
					";
					} else if ($list_ok_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_ok_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="center">Total Kelas</td>
				<td align="center">Total Jatah</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']));
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}

					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"center\">" . number_format($r['tarif_jatah_iks'] * $r['qty'], 0) . "</td>
						<td align=\"center\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
						<td align=\"right\">" . number_format(($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']), 0) . "</td>
					</tr>
					";
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$konten = $konten . "
					<tr>
						<td align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"center\">" . number_format($r['tarif_jatah_iks'] * $r['qty'], 0) . "</td>
						<td align=\"center\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
						<td align=\"right\">" . number_format((0), 0) . "</td>
					</tr>
					";
					}
				}
			}
		} else {
			if ($list_ok_pasien[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['dok_ok'] . "</td>
					<td align=\"right\">" . number_format($r['tarif_jatah'] * $r['qty'], 0) . "</td>
				</tr>
				";
				}
			} else if ($list_ok_pasien[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					if ($list_ok_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"right\">" . number_format($r['tarif_jatah_bpjs'] * $r['qty'], 0) . "</td>
					</tr>
					";
					} else if ($list_ok_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
						<td align=\"center\">" . $r['dok_ok'] . "</td>
						<td align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
					</tr>
					";
					}
				}
			} else if ($list_ok_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" align="left">Jenis Tind Operasi</td>
				<td align="center">Dokter</td>
				<td align="right">Total</td>
			</tr>
			';

				$subtotal = 0;
				foreach ($list_ok_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_iks'] * $r['qty']);
					$konten = $konten . "
				<tr>
					<td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
					<td align=\"center\">" . $r['dok_ok'] . "</td>
					<td align=\"right\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
				</tr>
				";
				}
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_ird_rekap($list_ok_ird)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td align="left">Jenis Tind Operasi</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_ok_ird as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
			<tr>
				<td>" . $r->jenis_tindakan . "</td>
				<td align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->total_rekap) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="2" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_ird_sementara($list_ok_ird)
	{
		$konten = "";

		$konten = $konten . '
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="5" align="left">Jenis Tind Operasi</td>
			<td colspan="5" align="center">Dokter</td>
			<td colspan="4" align="right">Total</td>
		</tr>
		';

		$subtotal = 0;
		foreach ($list_ok_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
			$konten = $konten . "
			<tr>
				<td colspan=\"5\" >" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"5\" align=\"center\">" . $r['dok_ok'] . "</td>
				<td colspan=\"4\" align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
			</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="12" align="left">Subtotal</td>
				<td colspan="2" align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_operasi_kw($list_ok_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">		
	';
		/*<tr>
		<td colspan="3" align="center">Jenis Tind Operasi</td>
		<td colspan="3" align="left">Dokter</td>
		<td colspan="2" align="center"></td>
	</tr>*/
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			if ($r['nm_dokter'] == 'Rumah Sakit')
				$nm_dokter = '';
			else
				$nm_dokter = $r['nm_dokter'];
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" >" . $r['jenis_tindakan'] . "</td>
			<td colspan=\"3\" align=\"left\">" . $nm_dokter . "</td>
			<td colspan=\"2\" align=\"right\">" . number_format($r['vtot'], 0) . "</td>
		</tr>
		";
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
			</tr>
			';*/
		$konten = $konten . "</table>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_pa($list_pa_pasien)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		<td colspan="3" align="center">Jenis Tind PA</td>
		<td colspan="3" align="center">Dokter</td>			
		<td colspan="2" align="center">Total</td>
	</tr>
	';
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" align=\"center\">" . $r['jenis_tindakan'] . "</td>
			<td colspan=\"2\" align=\"left\">" . $r['nm_dokter'] . "</td>
			<td colspan=\"2\" align=\"right\">" . number_format($r['vtot'], 0) . "</td>

		</tr>
		";
		}
		$konten = $konten . '
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab($list_lab_pasien)
	{
		$konten = "";
		//<table border="1">
		// $konten= $konten.'		
		// <table class="table-isi" border="0">
		// <tr>
		//    	<td colspan="3">Jenis Tind Laboratorium</td>
		//   	<td colspan="2">Dokter</td>
		//   	<td align="center">Harga Satuan</td>
		//   	<td align="center">Qty</td>
		//   	<td align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'		
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	   <td colspan="6">Laboratorium</td>
		// ';
		$subtotal = 0;
		// if(($list_lab_pasien[0]['cara_bayar']=='BPJS' || $list_lab_pasien[0]['cara_bayar']=='UMUM') && ($list_lab_pasien[0]['titip']==NULL)) {
		// 	foreach ($list_lab_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['biaya_lab']*$r['qty']);
		// 		$biaya_lab = number_format($r['biaya_lab'],0);
		// 		$vtot = number_format($r['biaya_lab']*$r['qty'],0);
		// 	// 	$konten = $konten. "
		// 	// 	<tr>
		// 	// 	<td colspan=\"3\">".$r['jenis_tindakan']."</td>
		// 	// 	<td colspan=\"2\">".$r['nm_dokter']."</td>
		// 	// 	<td align=\"center\">".$biaya_lab."</td>
		// 	// 	<td align=\"center\">".$r['qty']."</td>
		// 	// 	<td align=\"right\">".$vtot."</td>
		// 	// </tr>
		// 	// 	";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_lab_pasien[0]['cara_bayar']=='KERJASAMA') && ($list_lab_pasien[0]['titip']==NULL)) {
		// 	foreach ($list_lab_pasien as $r) {
		// 		if(($r['biaya_lab'] > $r['tarif_iks']) || ($r['biaya_lab'] == $r['tarif_iks'])) {
		// 			$subtotal = $subtotal + (($r['biaya_lab']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
		// 		} else if($r['biaya_lab'] < $r['tarif_iks']) {
		// 			$subtotal = $subtotal + (0);
		// 		}
		// 		$biaya_lab = number_format($r['biaya_lab'],0);
		// 		$vtot = number_format($r['vtot'],0);
		// 	// 	$konten = $konten. "
		// 	// 	<tr>
		// 	// 	<td colspan=\"3\">".$r['jenis_tindakan']."</td>
		// 	// 	<td colspan=\"2\">".$r['nm_dokter']."</td>
		// 	// 	<td align=\"center\">".$biaya_lab."</td>
		// 	// 	<td align=\"center\">".$r['qty']."</td>
		// 	// 	<td align=\"right\">".$vtot."</td>
		// 	// </tr>
		// 	// 	";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if(($list_lab_pasien[0]['cara_bayar']=='BPJS' || $list_lab_pasien[0]['cara_bayar']=='UMUM') && ($list_lab_pasien[0]['titip']=='1')) {
		// 	foreach ($list_lab_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
		// 		$biaya_lab = number_format($r['biaya_lab'],0);
		// 		$vtot = number_format($r['biaya_lab']*$r['qty'],0);
		// 	// 	$konten = $konten. "
		// 	// 	<tr>
		// 	// 	<td colspan=\"3\">".$r['jenis_tindakan']."</td>
		// 	// 	<td colspan=\"2\">".$r['nm_dokter']."</td>
		// 	// 	<td align=\"center\">".$biaya_lab."</td>
		// 	// 	<td align=\"center\">".$r['qty']."</td>
		// 	// 	<td align=\"right\">".$vtot."</td>
		// 	// </tr>
		// 	// 	";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// } else if($list_lab_pasien[0]['cara_bayar']=='KERJASAMA' && $list_lab_pasien[0]['titip']=='1') {
		// 	foreach ($list_lab_pasien as $r) {
		// 		$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
		// 		$biaya_lab = number_format($r['biaya_lab'],0);
		// 		$vtot = number_format($r['biaya_lab']*$r['qty'],0);
		// 	// 	$konten = $konten. "
		// 	// 	<tr>
		// 	// 	<td colspan=\"3\">".$r['jenis_tindakan']."</td>
		// 	// 	<td colspan=\"2\">".$r['nm_dokter']."</td>
		// 	// 	<td align=\"center\">".$biaya_lab."</td>
		// 	// 	<td align=\"center\">".$r['qty']."</td>
		// 	// 	<td align=\"right\">".$vtot."</td>
		// 	// </tr>
		// 	// 	";
		// 	}
		// 	// $konten = $konten.'
		// 	// 		<tr>
		// 	// 			<td colspan="7" align="center">Subtotal</td>
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// 	// $konten = $konten.'
		// 	// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 	// 		</tr>
		// 	// 		';
		// }
		if ($list_lab_pasien[0]['titip'] == '1') {
			if ($list_lab_pasien[0]['carabayar'] == 'UMUM') {
				foreach ($list_lab_pasien as $r) {
					$subtotal += ($r['tarif_jatah'] * $r['qty']);
				}
			} else if ($list_lab_pasien[0]['carabayar'] == 'BPJS') {
				foreach ($list_lab_pasien as $r) {
					if ($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['tarif_jatah_bpjs'] * $r['qty']);
					} else if ($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['biaya_lab'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_lab_pasien as $r) {
					$subtotal += ($r['tarif_iks'] * $r['qty']);
				}
			}
		} else {
			if ($list_lab_pasien[0]['carabayar'] == 'UMUM') {
				foreach ($list_lab_pasien as $r) {
					$subtotal += ($r['biaya_lab'] * $r['qty']);
				}
			} else if ($list_lab_pasien[0]['carabayar'] == 'BPJS') {
				foreach ($list_lab_pasien as $r) {
					if ($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal += ($r['biaya_lab'] * $r['qty']);
					} else if ($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal += ($r['biaya_lab'] * $r['qty']);
					}
				}
			} else {
				foreach ($list_lab_pasien as $r) {
					$subtotal += ($r['biaya_lab'] * $r['qty']);
				}
			}
		}
		//$konten = $konten."</table>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_ird($list_lab_ird)
	{
		$konten = "";
		//<table border="1">
		// $konten= $konten.'		
		// <table class="table-isi" border="0">
		// <tr>
		//    	<td colspan="3">Jenis Tind Laboratorium</td>
		//   	<td colspan="2">Dokter</td>
		//   	<td align="center">Harga Satuan</td>
		//   	<td align="center">Qty</td>
		//   	<td align="center">Total</td>
		// </tr>
		// ';
		// $konten= $konten.'		
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	   <td colspan="6">Laboratorium</td>
		// ';
		$subtotal = 0;

		foreach ($list_lab_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_lab'] * $r['qty']);
			$biaya_lab = number_format($r['biaya_lab'], 0);
			$vtot = number_format($r['biaya_lab'] * $r['qty'], 0);
			// 	$konten = $konten. "
			// 	<tr>
			// 	<td colspan=\"3\">".$r['jenis_tindakan']."</td>
			// 	<td colspan=\"2\">".$r['nm_dokter']."</td>
			// 	<td align=\"center\">".$biaya_lab."</td>
			// 	<td align=\"center\">".$r['qty']."</td>
			// 	<td align=\"right\">".$vtot."</td>
			// </tr>
			// 	";
		}
		// $konten = $konten.'
		// 		<tr>
		// 			<td colspan="7" align="center">Subtotal</td>
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten.'
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';

		// $konten = $konten."</table>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_rekap_iks_jatah($list_lab_pasien)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
			<td align="center" width="10%">Qty</td>
			<td align="right" width="20%">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_rekap_iks($list_lab_pasien)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
			<td align="center" width="10%">Qty</td>
			<td align="right" width="20%">Total</td>
		</tr>';

		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal += ($r->tarif_jatah_iks * $r->qtx);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
			<td align=\"center\">" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		</tr>";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="4" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_rekap_jatah($list_lab_pasien)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
			<td colspan="4" align="center" width="10%">Qty</td>
			<td align="right" width="10%">Total</td>
		</tr>';
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			if ($list_pasien[0]->tgl_masuk >= '2023-04-06') {
				$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
				$konten = $konten . "
			<tr>
				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
				<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
			</tr>";
			} else if ($list_pasien[0]->tgl_masuk < '2023-04-06') {
				$subtotal = $subtotal + ($r->biaya_lab * $r->qtx);
				$konten = $konten . "
			<tr>
				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
				<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->biaya_lab * $r->qtx) . "</td>
			</tr>";
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="6" align="left">Subtotal</td>
				<td align="right" colspan="2">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_rekap($list_lab_pasien)
	{
		$konten = "";
		//<table border="1">
		$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				<td colspan="4" align="center" width="10%">Qty</td>
				<td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					$subtotal += $r->total_rekap;
					$konten = $konten . "
				<tr>
				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
				<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
				<td align=\"right\">" . number_format($r->total_rekap) . "</td>
			</tr>
				";
				}
		// if ($list_lab_pasien[0]->titip == NULL) {
		// 	if ($list_lab_pasien[0]->carabayar == 'UMUM') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		<td colspan="4" align="center" width="10%">Qty</td>
		// 		<td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			$subtotal += ($r->total_tarif * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 		<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 		<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
		// 		<td align=\"right\">" . number_format($r->total_tarif * $r->qtx) . "</td>
		// 	</tr>
		// 		";
		// 		}
		// 	} else if ($list_lab_pasien[0]->carabayar == 'BPJS') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		<td colspan="4" align="center" width="10%">Qty</td>
		// 		<td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			if ($list_lab_pasien[0]->tgl_masuk >= '2023-04-06') {
		// 				$subtotal += ($r->tarif_bpjs * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->tarif_bpjs * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($list_lab_pasien[0]->tgl_masuk < '2023-04-06') {
		// 				$subtotal += ($r->biaya_lab * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td colspan=\"4\" align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->biaya_lab * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	} else if ($list_lab_pasien[0]->carabayar == 'KERJASAMA') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		<td align="center" width="10%">Qty</td>
		// 		<td align="center" width="10%">Total Kelas</td>
		// 		<td align="center" width="10%">Total Jatah</td>
		// 		<td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		$jatah = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
		// 				$subtotal = $subtotal + (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx));
		// 			} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
		// 				$subtotal = $subtotal + (0);
		// 			}
		// 			if (($r->tarif_jatah_iks > $r->tarif_iks) || ($r->tarif_jatah_iks == $r->tarif_iks)) {
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 				<td align=\"right\">" . (($r->tarif_jatah_iks * $r->qtx) - ($r->tarif_iks * $r->qtx)) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($r->tarif_jatah_iks < $r->tarif_iks) {
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td align=\"center\">" . $r->qtx . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_jatah_iks * $r->qtx) . "</td>
		// 				<td align=\"center\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 				<td align=\"right\">" . number_format(0) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	}
		// } 
		// else {
		// 	if ($list_lab_pasien[0]->carabayar == 'UMUM') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		  <td colspan="4" width="30%">Qty</td>
		// 		  <td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			$subtotal = $subtotal + ($r->tarif_jatah * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 		<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 		<td colspan=\"4\">" . $r->qtx . "</td>
		// 		<td align=\"right\">" . number_format($r->tarif_jatah * $r->qtx) . "</td>
		// 	</tr>
		// 		";
		// 		}
		// 	} else if ($list_lab_pasien[0]->carabayar == 'BPJS') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		  <td colspan="4" width="30%">Qty</td>
		// 		  <td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			if ($list_lab_pasien[0]->tgl_masuk >= '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->tarif_jatah_bpjs * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td colspan=\"4\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->tarif_jatah_bpjs * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			} else if ($list_lab_pasien[0]->tgl_masuk < '2023-04-06') {
		// 				$subtotal = $subtotal + ($r->biaya_lab * $r->qtx);
		// 				$konten = $konten . "
		// 			<tr>
		// 				<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 				<td colspan=\"4\">" . $r->qtx . "</td>
		// 				<td align=\"right\">" . number_format($r->biaya_lab * $r->qtx) . "</td>
		// 			</tr>
		// 			";
		// 			}
		// 		}
		// 	} else if ($list_lab_pasien[0]->carabayar == 'KERJASAMA') {
		// 		$konten = $konten . '		
		// 	<table class="table-isi" border="0" style="width: 100%;" width="100%">
		// 	<tr style="font-weight:bold;">
		// 		   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
		// 		  <td colspan="4" width="30%">Qty</td>
		// 		  <td align="right" width="10%">Total</td>
		// 	</tr>
		// 	';
		// 		$subtotal = 0;
		// 		foreach ($list_lab_pasien as $r) {
		// 			$subtotal = $subtotal + ($r->tarif_iks * $r->qtx);
		// 			$konten = $konten . "
		// 		<tr>
		// 		<td colspan=\"3\">" . $r->jenis_tindakan . "</td>
		// 		<td colspan=\"4\">" . $r->qtx . "</td>
		// 		<td align=\"right\">" . number_format($r->tarif_iks * $r->qtx) . "</td>
		// 	</tr>
		// 		";
		// 		}
		// 	}
		// }

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="6" align="left">Subtotal</td>
				<td align="right" colspan="2">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_sementara($list_lab_pasien)
	{
		$konten = "";
		//<table border="1">
		if ($list_lab_pasien[0]['titip'] == NULL) {
			if ($list_lab_pasien[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				<td colspan="4" width="30%">Dokter</td>
				<td align="center" width="15%">Harga Satuan</td>
				<td align="center" width="10%">Qty</td>
				<td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['total_tarif'] * $r['qty']);
					$biaya_lab = number_format($r['total_tarif'], 0);
					$vtot = number_format($r['total_tarif'] * $r['qty'], 0);
					$konten = $konten . "
				<tr>
				<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
				<td align=\"center\">" . $biaya_lab . "</td>
				<td align=\"center\">" . $r['qty'] . "</td>
				<td align=\"right\">" . $vtot . "</td>
			</tr>
				";
				}
			} else if ($list_lab_pasien[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				<td colspan="4" width="30%">Dokter</td>
				<td align="center" width="15%">Harga Satuan</td>
				<td align="center" width="10%">Qty</td>
				<td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					if ($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_lab'] * $r['qty']);
						$biaya_lab = number_format($r['biaya_lab'], 0);
						$vtot = number_format($r['biaya_lab'] * $r['qty'], 0);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $biaya_lab . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
					</tr>
					";
					} else if ($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_lab'] * $r['qty']);
						$biaya_lab = number_format($r['biaya_lab'], 0);
						$vtot = number_format($r['biaya_lab'] * $r['qty'], 0);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $biaya_lab . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
					</tr>
					";
					}
				}
			} else if ($list_lab_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				<td colspan="2" width="30%" align="center">Dokter</td>
				<td align="center" width="15%">Harga Satuan</td>
				<td align="center" width="10%">Qty</td>
				<td align="center" width="10%">Total Kelas</td>
				<td align="center" width="10%">Total Jatah</td>
				<td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				$jatah = 0;
				foreach ($list_lab_pasien as $r) {
					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']));
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}
					$tarif_jatah_iks = number_format($r['tarif_jatah_iks'], 0);
					$jatah = number_format($r['tarif_iks'] * $r['qty']);
					$vtot = number_format($r['tarif_jatah_iks'] * $r['qty'], 0);
					if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $tarif_jatah_iks . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
						<td align=\"center\">" . $jatah . "</td>
						<td align=\"right\">" . (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty'])) . "</td>
					</tr>
					";
					} else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $tarif_jatah_iks . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
						<td align=\"center\">" . $jatah . "</td>
						<td align=\"right\">" . number_format(0) . "</td>
					</tr>
					";
					}
				}
			}
		} else {
			if ($list_lab_pasien[0]['cara_bayar'] == 'UMUM') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				  <td colspan="4" width="30%">Dokter</td>
				  <td align="center" width="15%">Harga Satuan</td>
				  <td align="center" width="10%">Qty</td>
				  <td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah'] * $r['qty']);
					$biaya_lab = number_format($r['tarif_jatah'], 0);
					$vtot = number_format($r['tarif_jatah'] * $r['qty'], 0);
					$konten = $konten . "
				<tr>
				<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
				<td align=\"center\">" . $biaya_lab . "</td>
				<td align=\"center\">" . $r['qty'] . "</td>
				<td align=\"right\">" . $vtot . "</td>
			</tr>
				";
				}
			} else if ($list_lab_pasien[0]['cara_bayar'] == 'BPJS') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				  <td colspan="4" width="30%">Dokter</td>
				  <td align="center" width="15%">Harga Satuan</td>
				  <td align="center" width="10%">Qty</td>
				  <td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					if ($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs'] * $r['qty']);
						$biaya_lab = number_format($r['tarif_jatah_bpjs'], 0);
						$vtot = number_format($r['tarif_jatah_bpjs'] * $r['qty'], 0);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $biaya_lab . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
					</tr>
					";
					} else if ($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['biaya_lab'] * $r['qty']);
						$biaya_lab = number_format($r['biaya_lab'], 0);
						$vtot = number_format($r['biaya_lab'] * $r['qty'], 0);
						$konten = $konten . "
					<tr>
						<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
						<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
						<td align=\"center\">" . $biaya_lab . "</td>
						<td align=\"center\">" . $r['qty'] . "</td>
						<td align=\"right\">" . $vtot . "</td>
					</tr>
					";
					}
				}
			} else if ($list_lab_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				$konten = $konten . '		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
				  <td colspan="4" width="30%">Dokter</td>
				  <td align="center" width="15%">Harga Satuan</td>
				  <td align="center" width="10%">Qty</td>
				  <td align="right" width="10%">Total</td>
			</tr>
			';
				$subtotal = 0;
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_iks'] * $r['qty']);
					$biaya_lab = number_format($r['tarif_iks'], 0);
					$vtot = number_format($r['tarif_iks'] * $r['qty'], 0);
					$konten = $konten . "
				<tr>
				<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
				<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
				<td align=\"center\">" . $biaya_lab . "</td>
				<td align=\"center\">" . $r['qty'] . "</td>
				<td align=\"right\">" . $vtot . "</td>
			</tr>
				";
				}
			}
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="8" align="left">Subtotal</td>
				<td align="right" colspan="2">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_ird_rekap($list_lab_ird)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td width="35%">Jenis Tind Laboratorium</td>
			  <td width="30%">Qty</td>
			  <td align="right" width="10%">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_lab_ird as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
			<tr>
			<td>" . $r->jenis_tindakan . "</td>
			<td>" . $r->qtx . "</td>
			<td align=\"right\">" . number_format($r->total_rekap) . "</td>
		</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="2" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_ird_sementara($list_lab_ird)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
			  <td colspan="4" width="30%">Dokter</td>
			  <td align="center" width="15%">Harga Satuan</td>
			  <td align="center" width="10%">Qty</td>
			  <td align="right" width="10%">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_lab_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_lab'] * $r['qty']);
			$biaya_lab = number_format($r['biaya_lab'], 0);
			$vtot = number_format($r['biaya_lab'] * $r['qty'], 0);
			$konten = $konten . "
			<tr>
			<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
			<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
			<td align=\"center\">" . $biaya_lab . "</td>
			<td align=\"center\">" . $r['qty'] . "</td>
			<td align=\"right\">" . $vtot . "</td>
		</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="9" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_resep($list_resep, $tuslah = 0)
	{
		//var_dump($list_resep);die();
		//var_dump($list_resep);die();

		$konten = "";
		//<table border="1">
		// $konten= $konten.'
		// <table class="table-isi" border="0">
		// <tr>
		//     <td colspan="5" >Resep (Nama Obat)</td>
		// 	<td align="center">Satuan Obat</td>
		// 	<td align="center">Qty</td>
		// 	<td align="center">Total</td>
		// </tr>
		// ';

		// $konten= $konten.'
		// <table class="table-isi" border="0" style="width: 100%;" width="100%">
		// <tr>
		// 	<td colspan="6" >Resep</td>
		// ';
		//$subtotal = $list_resep->vtot_obat;
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);

			// $konten= $konten.'
			// <table class="table-isi" border="0" style="width: 100%;" width="100%">
			// <tr>
			// 	<td colspan="6" >Resep</td>
			// ';
			// $subtotal = $list_resep->vtot_obat;
			//foreach ($list_resep as $r) {
			// $subtotal = $subtotal + $r['vtot'];
			// $vtot = number_format($r['vtot'],0) ;

			// 	$konten = $konten. "
			// 	<tr>
			// 	<td colspan=\"5\" >".$r['nama_obat']."</td>
			// 	<td align=\"center\">".$r['Satuan_obat']."</td>
			// 	<td align=\"center\">".$r['qty']."</td>
			// 	<td align=\"right\">".$vtot."</td>
			// </tr>
			// 	";
		}

		//}

		// $total_biaya=$subtotal;
		// $tot1 = $total_biaya;
		// $tot2 = substr($tot1, - 3);
		// if ($tot2 % 1000 != 0){
		// 	$mod = $tot2 % 1000;
		// 	$tot1 = $tot1 - $mod;
		// 	$tot1 = $tot1 + 1000; 
		// }

		//$subtotal=$tot1;
		// $konten = $konten.'
		// 		<tr>
		// 			<td colspan="7" align="center">Subtotal</td>
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten.'
		// 			<td align="right">'.number_format($subtotal,0).'</td>
		// 		</tr>
		// 		';
		// $konten = $konten."</table>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_resep_rekap($list_resep)
	{
		$konten = "";
		//<table border="1">
		$konten = $konten . '
	<table class="table-isi" border="0" style="width: 100%;" width="100%">
	<tr style="font-weight:bold;">
		<td colspan="6" align="left">Resep (Nama Obat)</td>
		<td align="center">Qty</td>
		<td align="right">Total</td>
	</tr>
	';
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten . "
		<tr>
		<td colspan=\"6\" align=\"left\">" . strtoupper($r->nama_obat) . "</td>
		<td align=\"center\">" . $r->quantiti . "</td>
		<td align=\"right\">" . number_format($r->total_rekap) . "</td>
	</tr>
		";
		}
		// $total_biaya=$subtotal;
		// $tot1 = $total_biaya;
		// $tot2 = substr($tot1, - 3);
		// if ($tot2 % 1000 != 0){
		// 	$mod = $tot2 % 1000;
		// 	$tot1 = $tot1 - $mod;
		// 	$tot1 = $tot1 + 1000; 
		// }

		//$subtotal=$tot1;
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="7" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_resep_sementara($list_resep, $tuslah = 0)
	{
		$konten = "";
		//<table border="1">
		$konten = $konten . '
	<table class="table-isi" border="0" style="width: 100%;" width="100%">
	<tr style="font-weight:bold;">
		<td colspan="6" align="left">Resep (Nama Obat)</td>
		<td align="center">Qty</td>
		<td align="right">Total</td>
	</tr>
	';
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + ($r['vtot']);
			$vtot = number_format($r['vtot'], 0);
			$konten = $konten . "
		<tr>
		<td colspan=\"6\" align=\"left\">" . strtoupper($r['nama_obat'] == '' ? 'Obat Racikan' : $r['nama_obat']) . "</td>
		<td align=\"center\">" . $r['qty'] . "</td>
		<td align=\"right\">" . $vtot . "</td>
	</tr>
		";
		}
		$total_biaya = $subtotal;
		$tot1 = $total_biaya;
		// $tot2 = substr($tot1, - 3);
		// if ($tot2 % 1000 != 0){
		// 	$mod = $tot2 % 1000;
		// 	$tot1 = $tot1 - $mod;
		// 	$tot1 = $tot1 + 1000; 
		// }

		$subtotal = $tot1;
		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="7" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_ird($list_tindakan_ird)
	{
		$konten = "";
		$konten = $konten . '
	<table border="1">
	<tr>
		<td colspan="2" align="center">Tindakan</td>
		<td colspan="2" align="center">Dokter</td>
		<td align="center">Biaya</td>
		<td align="center">Qty</td>
		<td align="center">Total</td>
	</tr>
	';
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'], 0);
			$vtot = number_format($r['vtot'], 0);
			$konten = $konten . "
		<tr>
		<td colspan=\"2\" align=\"center\">" . $r['idtindakan'] . "</td>
		<td colspan=\"2\" align=\"center\">" . $r['nm_dokter'] . "</td>
		<td align=\"center\">Rp. " . $biaya_ird . "</td>
		<td align=\"center\">" . $r['qty'] . "</td>
		<td align=\"right\">Rp. " . $vtot . "</td>
	</tr>
		";
		}
		$konten = $konten . '
			<tr>
				<td colspan="6" align="center">Subtotal</td>
				<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_irj($poli_irj)
	{
		$konten = "";
		$konten = $konten . '
	<table class="table-isi" border="0">
	<tr>
		  <td colspan="3">Tindakan IRJ</td>
		  <td colspan="2">Dokter</td>
		  <td align="center">Biaya</td>
		  <td align="center">Qty</td>
		  <td align="center">Total</td>
	</tr>
	';
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'], 0);
			$vtot = number_format($r['vtot'], 0);
			$nmpoli = $r['nmpoli'];
			$konten = $konten . "
		<tr>
			<td colspan=\"3\">" . $r['nmtindakan'] . "</td>
			<td colspan=\"2\">" . $r['nm_dokter'] . "</td>
			<td align=\"center\">" . $biaya_tindakan . "</td>
			<td align=\"center\">" . $r['qtyind'] . "</td>
			<td align=\"right\">" . $vtot . "</td>
		</tr>
		";
		}
		$konten = $konten . '
			<tr>
				<td colspan="7" align="right">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br><br>";

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'nmpoli' => $nmpoli
		);
		return $result;
	}
	//end modul cetak laporan detail

	private function string_table_irj_kw($poli_irj, $poli_irj_kelompok)
	{
		$konten = "";
		/**/
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'], 0);
			$vtot = number_format($r['vtot'], 0);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" >" . $r['nmtindakan'] . "</td>
			<td colspan=\"3\" align=\"left\">" . $r['nm_dokter'] . "</td>
			<td colspan=\"2\" align=\"right\"> " . $vtot . "</td>
		</tr>
		";
		}
		foreach ($poli_irj_kelompok as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'], 0);
			$vtot = number_format($r['vtot'], 0);
			$konten = $konten . "
		<tr>
			<td colspan=\"3\" >" . $r['nama_kel'] . "</td>
			<td colspan=\"3\" align=\"left\">" . $r['nm_dokter'] . "</td>
			<td colspan=\"2\" align=\"right\"> " . $vtot . "</td>
		</tr>
		";
		}
		/*$konten = $konten.'
			<tr>
				<td colspan="6" align="right">Subtotal</td>
				<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
			</tr>
			';*/

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	public function insert_status()
	{
		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>"
		);

		redirect('iri/ricstatus');
	}

	public function data_icd_1()
	{
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimtindakan->select_icd_1_like($keyword);

		foreach ($data as $row) {

			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['id_icd'] . " - " . $row['nm_diagnosa'],
				'id_icd'				=> $row['id_icd'],
				'kode_icd'				=> $row['id_icd'],
				'nm_diagnosa'				=> $row['nm_diagnosa']
			);
		}
		echo json_encode($arr);

		// // 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		// $keyword = $this->uri->segment(4);
		// $data = $this->rimreservasi->select_pasien_irj_like($keyword);
		// foreach($data as $row){
		// 	$coba=strtotime($row['tgl_lahir']);
		// 	$date=date('d/m/Y', $coba);

		// 	$arr['query'] = $keyword;
		// 	$arr['suggestions'][] 	= array(
		// 		'value'				=>$row['no_register'],
		// 		'no_cm'				=>$row['no_medrec'],
		// 		'no_reg'			=>$row['no_register'],
		// 		'nama'				=>$row['nama'],
		// 		'jenis_kelamin'		=>$row['sex'],
		// 		'tanggal_lahir'		=>$date,
		// 		'telp'				=>$row['no_telp'],
		// 		'hp'				=>$row['no_hp'],
		// 		'id_poli'			=>'',
		// 		'poliasal'			=>'',
		// 		'id_dokter'			=>'',
		// 		'dokter'			=>'',
		// 		'diagnosa'			=>''
		// 		// 'id_poli'			=>$row['id_poli'],
		// 		// 'poliasal'			=>$row['poliasal'],
		// 		// 'id_dokter'			=>$row['id_dokter'],
		// 		// 'dokter'			=>$row['dokter'],
		// 		// 'diagnosa'			=>$row['diagnosa']
		// 	);
		// }
		// echo json_encode($arr);
	}

	private function clean($string)
	{
		$str = str_replace(array('-', '<', '>', '&', '{', '}', '*'), array(' '), $string);
		return $str;
	}

	public function batalkan_pasien($no_ipd = '')
	{
		//cek semua tindakan yang pernah ada. kalo belum ada tindakan ga boleh batal
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		$no_ipd = $pasien[0]['no_ipd'];
		$no_register_asal = $pasien[0]['noregasal'];

		$status_bisa_batal = true;

		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		if (($list_tindakan_pasien)) {
			$status_bisa_batal = false;
		}

		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $no_register_asal);
		if (($list_lab_pasien)) {
			$status_bisa_batal = false;
		}
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $no_register_asal); //belum ada no_register
		if (($list_radiologi)) {
			$status_bisa_batal = false;
		}
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $no_register_asal);
		if (($list_resep)) {
			$status_bisa_batal = false;
		}
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		if (sizeof($list_mutasi_pasien) > 1) {
			$status_bisa_batal = false;
		}
		/*$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($no_register_asal);
		if(($list_tindakan_ird)){
			$status_bisa_batal = false;
		}
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($no_register_asal);
		if(($poli_irj)){
			$status_bisa_batal = false;
		}*/

		if ($status_bisa_batal == true) {
			//echo "bisa pulang";
			//hapus dulu ruangan
			$this->rimpasien->delete_ruang_iri_by_ipd($no_ipd);
			$this->rimreservasi->batal_iri_reservasi($no_register_asal);
			//flag bed jadi N
			$data_bed['isi'] = 'N';
			$this->rimkelas->flag_bed_by_id($data_bed, $pasien[0]['bed']);

			//hapus pasien
			$this->rimpasien->delete_pasien_iri($no_ipd);

			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Pasien telah dibatalkan!
			</div>"
			);
			redirect('iri/ricpasien/');
		} else {
			//echo "tidak bisa ulang";
			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Pasien tidak bisa dibatalkan karena sudah ada tindakan yang terinput!
			</div>"
			);
			redirect('iri/ricstatus/index/' . $no_ipd);
		}
	}

	public function cetak_detail_farmasi($no_ipd = '')
	{

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//kamari
		// if($pasien[0]['cetak_kwitansi'] != '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwintasi Harus Dicetak Terlebih Dahulu <button type="button" 
		//       onclick="'.$string_close_windows.'">Kembali</button>';
		//       	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . " .pdf";


		$konten = "";


		$konten = $konten . '<br><br><br><table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			// $konten = $konten."
			// <tr>
			// 	<td colspan=\"6\">Total Pembayaran Resep</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten . $result['konten'];
		}

		$grand_total = $grand_total + $pasien[0]['biaya_administrasi'];

		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;
		$konten = $this->string_data_pasien_utk_farmasi($pasien, $grand_total, "", '', $no_ipd) . $konten;
		$tgl = date("Y-m-d");

		// $tgl_indo = new Tglindo();
		$bulan_show = substr($tgl, 6, 2);
		$tahun_show = substr($tgl, 0, 4);
		$tanggal_show = substr($tgl, 8, 2);
		$tgl = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

		$cterbilang = new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;
		// $grand_total_string = "
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Tunai   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['tunai'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['nilai_kkkd'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Charge % </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".$pasien[0]['persen_kk']."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Nominal Charge   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $nomimal_charge, 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Diskon   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['diskon'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Total   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $grand_total-$subsidi_total-$pasien[0]['diskon'], 0)."</p></th>
		// 	</tr>
		// </table>
		// <br/><br/>
		// Terbilang<br>
		// ".strtoupper($vtot_terbilang)."
		// <br/><br/>
		// <table>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>$tgl</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>an.Kepala Rumah Sakit</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>K a s i r</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>----------------------------------------</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>ADMIN</td>
		// 	</tr>
		// </table>
		// ";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
		</table>
		<br><br><br>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Kepala Rumah Sakit</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>----------------------------------------</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>$user</td>
			</tr>
		</table>
		";

		$konten = $konten . $grand_total_string;

		// $konten = "";


		// $konten = $konten.$this->string_data_pasien($pasien,0,'');

		// $grand_total = 0;
		// //mutasi ruangan pasien
		// if(($list_mutasi_pasien)){
		// 	$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }


		// //tindakan
		// if(($list_tindakan_pasien)){
		// 	$result = $this->string_table_tindakan($list_tindakan_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];

		// 	$konten = $konten.$result['konten'];
		// 	//print_r($konten);exit;
		// }

		// //radiologi
		// if(($list_radiologi)){
		// 	$result = $this->string_table_radiologi($list_radiologi);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //lab
		// if(($list_lab_pasien)){
		// 	$result = $this->string_table_lab($list_lab_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //resep
		// if(($list_resep)){
		// 	$result = $this->string_table_resep($list_resep);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //ird
		// if(($list_tindakan_ird)){
		// 	$result = $this->string_table_ird($list_tindakan_ird);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //irj
		// if(($poli_irj)){
		// 	$result = $this->string_table_irj($poli_irj);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// $grand_total_string = '
		// <table border="1">
		// 	<tr>
		// 		<td colspan="6" align="center">Grand Total</td>
		// 		<td align="right">Rp. '.number_format($grand_total,0).'</td>
		// 	</tr>
		// </table>
		// ';

		// $konten = '<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>'.$konten.$grand_total_string;

		tcpdf();


		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Rincian Obat - " . $no_ipd . " - " . $pasien[0]['nama'];;
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
		// $obj_pdf->SetCreator(PDF_CREATOR);
		// $title = "Rincian Biaya Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		// $tgl_cetak = date("j F Y");
		// $obj_pdf->SetTitle($file_name);
		// $obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// $obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins('5', '5', '5', '5');
		// $obj_pdf->setPrintHeader(false);
		// $obj_pdf->setPrintFooter(false);
		// $obj_pdf->SetAutoPageBreak(TRUE, '5');
		// $obj_pdf->SetFont('helvetica', '', 10);
		// $obj_pdf->setFontSubsetting(false);
		// $obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}

	private function string_data_pasien_utk_farmasi($pasien, $grand_total, $penerima, $jenis_pembayaran, $no_ipd)
	{
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');


		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang = new rjcterbilang();
		$vtot_terbilang = $cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if ($jenis_pembayaran == "KREDIT") {
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		} else {
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}


		$konten = $konten . "<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>" . $this->config->item('namars') . "</b> <br/> " . $this->config->item('alamat') . "</td>
						<td width=\"10%\"></td>						
						</tr>
						<tr><td></td><td></td></tr>
						
					</table>
					
					
					<table >
						<tr>							
							<td><font size=\"8\" align=\"left\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>RINCIAN OBAT PASIEN RAWAT INAP
					</b></u></font></td>
						</tr>	<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>NO REGISTER</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">" . $no_ipd . "</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>" . date("d-m-Y", strtotime($pasien[0]['tgl_masuk'])) . "</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>" . strtoupper($pasien[0]['nama']) . "</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>" . strtoupper($pasien[0]['no_cm']) . "</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>" . $interval->format("%Y Tahun, %M Bulan, %d Hari") . "</td>
								
								<td ><b>Status Pasien</b></td>
								<td > : </td>
								<td>" . strtoupper($pasien[0]['carabayar']) . "</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>" . strtoupper($pasien[0]['alamat']) . "</td>
								
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>

		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>

		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>

		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>

		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>

		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>

		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>

		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	public function update_dokter()
	{
		$no_ipd = $this->input->post('no_ipd');
		$tgl_buat = $this->input->post('date_dokter');
		$id_dokter = $this->input->post('id_dokter');
		$id_dokter_old = $this->input->post('id_dokter_old');
		$nmdokter = $this->input->post('nmdokter');

		$data['id_dokter'] = $id_dokter;
		$data['dokter'] = $nmdokter;

		$this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_ipd);
		$data1['no_register'] = $no_ipd;
		$data1['id_dokter'] = $this->input->post('id_dokter_old');
		$data1['ket'] = 'DPJP pasien sebelumnya ' . $tgl_buat . ' / ' . date('Y-m-d');
		$data1['xcreate'] = date('Y-m-d H:i:s');
		$login_data = $this->load->get_var("user_info");
		$data1['xuser'] = $login_data->username;

		$this->rimdokter->insert_dokter_bersama($data1);

		echo "1";
	}

	public function hapus_tindakan()
	{
		$id = $this->input->post('id');
		$no_register = $this->input->post('no_register');
		$this->rimpasien->hapus_tindakan($id);

		$datajson = $this->rimpasien->get_total_tindakan_pasien($no_register)->row();
		echo json_encode($datajson);
	}

	public function hapus_tindakan_ok($id, $no_ipd)
	{
		$this->rimpasien->hapus_tindakan_ok($id);
		redirect('iri/ricstatus/index/' . $no_ipd);
	}

	public function cetak_list_piutang_pasien($no_ipd = '')
	{

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);

		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_dokter = $this->rimpasien->get_patient_doctor($no_ipd); //datakosong
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); // data ada 
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong
		if (($data_paket)) {
			$status_paket = 1;
		}
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_ok_iri($no_ipd);
		$list_pa_pasien = "";
		$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
		$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
		$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
		$list_resep = $this->rimpasien->get_list_resep_iri($no_ipd);
		$resep = $this->rimpasien->get_list_resep_iri_new($no_ipd)->row();
		if ($pasienold[0]['id_poli'] == 'BA00') {
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
			$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
			$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
			$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
			$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
			$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);
		} else {
			$list_tindakan_ird = array();
			$list_ok_ird = array();
			$list_em_ird = array();
			$list_rad_ird = array();
			$list_lab_ird = array();
			$list_resep_ird = array();
		}


		$nama_pasien = str_replace(" ", "_", $pasien[0]['nama']);
		$file_name = "detail_pembayaran_" . $pasien[0]['no_ipd'] . "_" . $nama_pasien . "_faktur.pdf";


		$konten = "";
		$konten0 = "";


		$konten0 = $konten0 . '<style type=\"text/css\">
			
				.table-isi th{
				
				border-bottom: 1px solid #ddd;
				}
				.table-isi td{
				border-bottom: 1px solid #ddd;
				}
				</style>
			';

		$konten = $konten . '';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount = 0;
		$ceknull = 0;
		$jasa_total = 0;
		//mutasi ruangan pasien
		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			$selisih_hari = $result['selisihhari'];

			$ceknull = $result['ceknull'];
			$mutasicount = $mutasicount + 1;
			$konten = $konten . $result['konten'];
		}
		$biaya_kamar = $grand_total;

		//tindakan
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];

			$konten = $konten . $result['konten'];
			//print_r($konten);exit;
		}

		//radiologi
		$vtotrad = 0;
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
			$vtotrad = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//elekromedik
		$vtotem = 0;
		if (($list_elektromedik)) {
			$result = $this->string_table_elektromedik($list_elektromedik);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Radiologi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
			$vtotem = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//operasi
		$vtotok = 0;
		if (($list_ok_pasien)) {
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Tindakan Operasi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
			//
			$vtotok = $result['subtotal'];
		}

		//operasi
		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];


			$vtotok += $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//pa
		$vtotpa = 0;
		if (($list_pa_pasien)) {
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];
			/*$konten = $konten."
				<tr>
					<td colspan=\"3\">Total Pembayaran Patologi Anatomi</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
			$vtotpa = $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		$vtotlab = 0;
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten . $result['konten'];

			$vtotlab = $result['subtotal'];
			// $konten = $konten.$result['konten'];
		}

		//resep
		// $vtotresep=0;
		// if(($resep)){
		// 	$result = $this->string_table_resep($list_resep, $pasien[0]['tuslah']);

		// 	$result = $this->string_table_resep($resep, $pasien[0]['tuslah']);

		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];

		// }


		if ($pasienold[0]['id_poli'] == 'BA00') {
			// 	$konten = $konten."		
			// 		<br>
			// 		<table class=\"table-isi\" border=\"0\">
			// 			<tr>
			// 				<td colspan=\"8\"><b>Tindakan Poli IGD</b></td>
			// 			</tr>
			// 		</table>			
			// 	";

			// 	//tindakan
			if (($list_tindakan_ird)) {
				$result = $this->string_table_tindakan_ird_faktur($list_tindakan_ird);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				//print_r($konten);exit;
			}

			// 	//radiologi
			$vtotrad = 0;
			if (($list_rad_ird)) {
				$result = $this->string_table_radiologi_ird($list_rad_ird);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				// 		/*$konten = $konten."
				// 		<tr>
				// 			<td colspan=\"3\">Total Pembayaran Radiologi</td>
				// 			<td>Rp. ".number_format($result['subtotal'],0)."</td>
				// 		</tr>
				// 		";*/
				$vtotrad = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			// 	//elekromedik
			$vtotem = 0;
			if (($list_em_ird)) {
				$result = $this->string_table_elektromedik_ird($list_em_ird);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				/*$konten = $konten."
					<tr>
						<td colspan=\"3\">Total Pembayaran Radiologi</td>
						<td>Rp. ".number_format($result['subtotal'],0)."</td>
					</tr>
					";*/
				$vtotem = $result['subtotal'];
				//$konten = $konten.$result['konten'];
			}

			// 	//operasi
			$vtotok = 0;
			if (($list_ok_ird)) {
				$result = $this->string_table_operasi_ird($list_ok_ird);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];
				// 		/*$konten = $konten."
				// 		<tr>
				// 			<td colspan=\"3\">Total Tindakan Operasi</td>
				// 			<td>Rp. ".number_format($result['subtotal'],0)."</td>
				// 		</tr>
				// 		";*/
				// 		//
				$vtotok = $result['subtotal'];
			}

			// 	//lab
			$vtotlab = 0;
			if (($list_lab_ird)) {
				$result = $this->string_table_lab_ird($list_lab_ird);
				$grand_total = $grand_total + $result['subtotal'];
				$konten = $konten . $result['konten'];

				$vtotlab = $result['subtotal'];
				// $konten = $konten.$result['konten'];
			}

			// 	//resep
			// $vtotresep=0;
			// if(($list_resep_ird)){
			// 	$result = $this->string_table_resep($list_resep_ird, $pasien[0]['tuslah']);
			// 	$grand_total = $grand_total + $result['subtotal'];
			// 	$konten = $konten.$result['konten'];

			// }

		}

		if ($status == '0') {
			$span = '7';
		} else {
			$span = '7';
		}
		//$fixs_adm=40000*$selisih_hari;

		// $fixs_adm= $grand_total* 7/100;
		$fixs_adm = 0;
		//$totalselisih = $this->input->post('totalselisih');
		//$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
		$konten = $konten . "
			<br>
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">	
				";

		//$grand_total = (double) $grand_total + (double) $fixs_adm;
		// + (double) $pasien[0]['jasaperawat'] + 6000 + (double) $pasien[0]['biaya_daftar']

		$konten0 = $this->string_data_pasien_faktur($pasien, $grand_total, "", '', $no_kwitansi) . $konten0;

		//	print_r($konten0);die();

		$konten = $konten0 . $konten;


		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');

		$cterbilang = new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang = $cterbilang->terbilang($grand_total, 1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;


		$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}


		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->name);
		$userid = $login_data->userid;
		$ttd_2 = $this->rimtindakan->get_list_tindakan_pelayanan_iri($no_ipd)->row()->ttd_pelaksana;
		$ttd = $this->rimpasien->get_ttd_by_login($userid)->row()->ttd;
		//var_dump($ttd);die();
		/*<tr>
					<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
					<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
				</tr>*/

		$span = '7';
		$span1 = '1';

		if ($pasien[0]['carabayar'] == 'BPJS') {
			if ($pasien[0]['jatahklsiri'] == 'I' && $pasien[0]['klsiri'] == 'VIP') {
				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 1</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
			} else if (($pasien[0]['jatahklsiri'] == 'II' && $pasien[0]['klsiri'] == 'VIP') || ($pasien[0]['jatahklsiri'] == 'II' && $pasien[0]['klsiri'] == 'I')) {
				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 1</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas 2</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls2_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
			} else {
				$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Kelas</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls1_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Tarif Inacbg Jatah Kelas</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($data_kwitansi->tarif_kls2_inacbg) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($pasien[0]['tunai'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
			}
		} else {
			$grand_total_string = "	
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Biaya</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Obat</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Total Dibayar Pasien</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p>Rp. " . number_format($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "</p></th>
							</tr>
							<tr>
								<th colspan=\"" . $span . "\" align=\"left\"><p><b>Terbilang</b></p></th>
								<th align=\"right\" colspan=\"" . $span1 . "\"><p><i>" . $cterbilang->terbilang($grand_total + $fixs_adm + $pasien[0]['denda_terlambat'] - $pasien[0]['diskon'] + $pasien[0]['pngobatan']) . "<i></p></th>
							</tr>
						</table>
						<br/><br>
						<table style=\"width: 100%;\" width=\"100%\">
							<tr>
								<td style=\"width: 50%;\"></td>
								<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
							</tr>
							<tr>
								<td align=\"center\">Pasien</td>
								<td align=\"center\">$user</td>
							</tr>
						</table>";
		}


		$konten = $konten . $grand_total_string;
		//return $konten;
		ob_clean();
		// flush();
		//  header("Content-type:application/pdf");
		// header("Content-Disposition:attachment;filename='downloaded.pdf'");
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $konten;
		//$this->mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}

	public function cetak_list_pembayaran_skrd($no_ipd = '')
	{
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('kwitansi_skrd', $data, true);
		$mpdf->WriteHTML($html);
		$mpdf->Output();

	}

	private function string_table_utdrs_sementara($list_utd_ird)
	{
		$konten = "";

		$konten = $konten . '		
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="3" width="35%">Jenis Tind Unit Darah</td>
			  <td colspan="4" width="30%">Dokter</td>
			  <td align="center" width="15%">Harga Satuan</td>
			  <td align="center" width="10%">Qty</td>
			  <td align="right" width="10%">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_utd_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_utd'] * $r['qty']);
			$biaya_utd = number_format($r['biaya_utd'], 0);
			$vtot = number_format($r['biaya_utd'] * $r['qty'], 0);
			$konten = $konten . "
			<tr>
			<td colspan=\"3\">" . $r['jenis_tindakan'] . "</td>
			<td colspan=\"4\">" . $r['nm_dokter'] . "</td>
			<td align=\"center\">" . $biaya_utd . "</td>
			<td align=\"center\">" . $r['qty'] . "</td>
			<td align=\"right\">" . $vtot . "</td>
		</tr>
			";
		}

		$konten = $konten . '
			<tr style="font-weight:bold;">
				<td colspan="9" align="left">Subtotal</td>
				<td align="right">' . number_format($subtotal, 0) . '</td>
			</tr>
			';
		$konten = $konten . "</table><br>";
		//</table>
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	
}
