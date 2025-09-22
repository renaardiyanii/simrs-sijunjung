<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
include('Rjcterbilang.php');

use GuzzleHttp\Client;

class Rjconline extends Secure_area
{
	//class rjcregistrasi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('irj/online/rjmdaftar', '', TRUE);
		$this->load->model('irj/rjmpencarian', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('irj/rjmkwitansi', '', TRUE);
		$this->load->model('ird/ModelRegistrasi', '', TRUE);
		$this->load->model('admin/M_user', '', TRUE);
		$this->load->model('irj/M_update_sepbpjs', '', TRUE);
		$this->load->model('bpjs/Mbpjs', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('lab/labmdaftar', '', TRUE);
		// $this->load->model('irj/online/rjmdaftar','rjmonline',TRUE);
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		$this->endpoint = 'http://192.168.112.121:9810/api/v1/mobile/';
		$this->token = '';
		$this->generate_token();
	}

	function generate_token()
	{
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . 'token',
				[
					'headers' => [
						'username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ==',
						'password' => 'WGNnbkJmWDhBbW9sT2JLcGNLdEpjZz09'
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		$response = json_decode($response);
		if ($response->metadata->code == 200) {
			$this->token = $response->response->token;
			// var_dump($this->token);die();
		}
	}

	public function ambilpasienonline($tgl = '')
	{
		header('Content-Type: application/json; charset=utf-8');
		try {
			$response = $this->clients->request(
				'GET',
				$this->endpoint . 'daftarulang/tgl/' . ($tgl == '' ? date('Y-m-d') : $tgl),
				[
					'headers' => [
						'x-token' => $this->token,
						'x-username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ=='
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		//  var_dump($response);die();
		$response = json_decode($response);
		if ($response->metadata->code == 200) {
			foreach ($response->response as $index => $val) {
				$nama = $this->rjmdaftar->get_nama_by_nocm($response->response[$index]->nocm)->row();
				if ($nama) {

					$response->response[$index]->nama = $nama->nama;
				}
			}
			// var_dump($response);die();
		}
		echo json_encode($response);
	}

	public function index()
	{
		$data = [
			'title' => 'Pendaftaran Pasien Online'
		];
		// $login_data = $this->load->get_var("user_info");
		// $data['list'] = $this->rjmdaftar->get_all_pasien()->result();
		$this->load->view('irj/online/listpasien', $data);
	}

	function generate_umur($no_medrec)
	{
		$get_umur = $this->rjmdaftar->get_umur($no_medrec)->row();
		$tahun = floor($get_umur->umurday / 365);
		$bulan = floor(($get_umur->umurday - ($tahun * 365)) / 30);
		$hari = $get_umur->umurday - ($bulan * 30) - ($tahun * 365);
		return [$tahun, $bulan, $hari];
	}

	public function insert_daftar_ulang()
	{
		// grab all data
		$login_data = $this->load->get_var("user_info");
		$payload = $this->input->post('data');
		// grab no bpjs in database
		// cek poli , jika pasien hari itu ada di poli keluarkan
		// get umur pasien berdasarkan no_cm
		$umur = $this->generate_umur($payload['no_cm']);
		switch ($payload['id_poli']) {
			case 'ME00':
				$payload['em'] = 1;
				break;
			case 'HA00':
				$payload['lab'] = 1;
				break;
			case 'ME00':
				$payload['rad'] = 1;
				break;
		}
		$data = [
			'umurrj' => $umur[0],
			'ublnrj' => $umur[1],
			'uharirj' => $umur[2],
			'no_medrec' => intval($payload['no_cm']),
			'jns_kunj' => $payload['status'],
			'cara_kunj' => 'DATANG SENDIRI',
			'no_rujukan' => $payload['no_rujukan'] ?? null,
			'diagnosa' => $payload['diagnosa'] ?? null,
			'id_poli' => $payload['id_poli'],
			'id_dokter' => $payload['id_dokter'],
			'biayadaftar' => 0,
			'nama_penjamin' => $payload['penjamin'] ?? null,
			'hubungan' => $payload['hubungan'] ?? null,
			'vtot' => 0,
			"xcreate" => $login_data->name,
			"tgl_kunjungan" => date('Y-m-d H:i:s'),
			'xupdate' => date('Y-m-d H:i:s'),
			'online' => 1,
			'em' => $payload['em'] ?? null,
			'lab' => $payload['lab'] ?? null,
			'rad' => $payload['rad'] ?? null,
			'kelas_pasien' => 'NK',
			'cara_bayar' => $payload['cara_bayar'],
			'katarak' => $payload['katarak'] ?? 0
		];

		$id = $this->rjmregistrasi->insert_daftar_ulang($data);
		$datat = [
			'no_register' => $id->no_register,
			'id_poli' => $payload['id_poli'],
			'jenis_pasien' => $payload['status'],
			'cara_bayar' => $payload['cara_bayar'],
		];

		$this->insert_tindakan($datat);
		$delete_pasien_onlie = isset($id->no_register) ? $this->rjmdaftar->delete_pasien_online($payload['id']) : null;
		echo json_encode([
			'code' => $delete_pasien_onlie ? 200 : 400
		]);
	}

	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		$data['id_poli'] = $data1['id_poli'];
		//default BA0102
		if ($data['id_poli'] == 'BA00') { //igd
			//1B0102 ->> BPJS Administrasi
			if ($data1['jenis_pasien'] == 'BARU') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan'] = '1B0102';
				$data['bpjs'] = '0';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan'] = '1B0102';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0101')->row();
				$data['idtindakan'] = '1B0101';
				$data['bpjs'] = '0';
			}

			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			//	print_r($data);exit();	
			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		} else if ($data['id_poli'] == 'BG00' || $data['id_poli'] == 'BW00') {

			if ($data1['jenis_pasien'] == 'BARU' && $data1['no_nrp'] == '') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0105')->row();
				$data['idtindakan'] = '1B0105';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0105')->row();
				$data['idtindakan'] = '1B0105';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0101')->row();
				$data['idtindakan'] = '1B0101';
			}
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			// tambah lagi disini`
			// idtindakan,tgl_kunjungan,nmtindakan,biaya_tindakan,biaya_alkes,qtyind,vtot,
			// insert tindakan
			// data_vtot update 
			$no_register = $data1['no_register'];
			$khusus['no_register'] = $no_register;
			$khusus['idtindakan'] = '1B0135';
			$khusus['tgl_kunjungan'] = $data['tgl_kunjungan'];
			$detailkhusus = $this->rjmregistrasi->get_detail_tindakan('1B0135')->row();
			$khusus['nmtindakan'] = $detailkhusus->nmtindakan;
			$khusus['biaya_tindakan'] = $detailkhusus->total_tarif;
			$khusus['biaya_alkes'] = $detailkhusus->tarif_alkes;
			$khusus['qtyind'] = '1';
			$khusus['xuser'] = $user;
			$khusus['xupdate'] = date("Y-m-d H:i:s");
			$khusus['vtot'] = (int)$khusus['biaya_tindakan'] + (int)$khusus['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus);

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		} else {

			if ($data1['jenis_pasien'] == 'BARU' && $data1['no_nrp'] == '') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0105')->row();
				$data['idtindakan'] = '1B0105';
			} else if ($data1['cara_bayar'] == 'BPJS') {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0105')->row();
				$data['idtindakan'] = '1B0105';
				$data['bpjs'] = '1';
			} else {
				$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0101')->row();
				$data['idtindakan'] = '1B0101';
			}
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];


			$id = $this->rjmpelayanan->insert_tindakan($data);

			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);

			$no_register = $data1['no_register'];
			$khusus1['no_register'] = $no_register;

			$khusus1['idtindakan'] = '1B0134';
			$khusus1['tgl_kunjungan'] = $data['tgl_kunjungan'];
			$detailkhusus1 = $this->rjmregistrasi->get_detail_tindakan('1B0134')->row();
			$khusus1['nmtindakan'] = $detailkhusus1->nmtindakan;
			$khusus1['biaya_tindakan'] = $detailkhusus1->total_tarif;
			$khusus1['biaya_alkes'] = $detailkhusus1->tarif_alkes;
			$khusus1['qtyind'] = '1';
			$khusus1['xuser'] = $user;
			$khusus1['xupdate'] = date("Y-m-d H:i:s");
			$khusus1['vtot'] = (int)$khusus1['biaya_tindakan'] + (int)$khusus1['biaya_alkes'];

			$id = $this->rjmpelayanan->insert_tindakan($khusus1);

			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$khusus1['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot, $data1['no_register']);
		}


		$no_register = $data1['no_register'];
	}

	public function get_list_antrian()
	{
		$tglawal = $this->input->get('tglawal') ? $this->input->get('tglawal') : Date('Y-m-d', strtotime('-3 days'));
		$tglakhir = $this->input->get('tglakhir') ? $this->input->get('tglakhir') : Date('Y-m-d');
		header('Content-Type: application/json; charset=utf-8');
		$ch = curl_init("http://192.168.115.253:8000/api/v1/adminantrian/statusantrianpertgl/$tglawal/$tglakhir");
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;
	}


	/**
	 * Pembuatan antrian online bpjs bridging 
	 */

	public function antrianbpjs()
	{
		$data =  [
			'title' => 'Antrian Online BPJS'
		];
		$this->load->view('irj/online/antrianbpjs', $data);
	}

	public function grabpasienbaru()
	{
		header('Content-Type: application/json; charset=utf-8');
		try {
			$response = $this->clients->request(
				'GET',
				'http://192.168.112.121:9810/api/v1/mobile/getPasienBaru',
				[
					'headers' => [
						'x-token' => $this->token,
						'x-username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ=='
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		$response = json_decode($response);

		echo json_encode($response);
	}

	public function insert_pasien_baru()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = base64_decode($this->input->post('data'));
		$req = json_decode($data);
		date_default_timezone_set("Asia/Jakarta");
		// clean
		$clean_data = [
			'bahasa' => $req->bahasa,
			'jenis_identitas' => $req->jenis_identitas,
			'no_identitas' => $req->no_identitas,
			'no_kartu' => $req->no_kartu_bpjs,
			'id_provinsi' => $req->id_provinsi,
			'id_kotakabupaten' => $req->id_kotakabupaten,
			'id_kecamatan' => $req->id_kecamatan,
			'id_kelurahandesa' => $req->id_kelurahandesa,
			// 'provinsi'=>'',
			// 'kotakabupaten'=>$req->,
			// 'kecamatan'=>$req->,
			// 'kelurahandesa'=>$req->,
			'suami_istri' => $req->suami_istri,
			'nama_ayah' => $req->nama_ayah,
			'nama_ibu' => $req->nama_ibu,
			'alamat2' => $req->alamat2,
			'rt_alamat2' => $req->rt2,
			'rw_alamat2' => $req->rw,
			'tgl_lahir' => $req->tgl_lahir,
			'suku_bangsa' => $req->suku_bangsa,
			'nama' => $req->nama,
			'sex' => $req->sex,
			'tmpt_lahir' => $req->tmpt_lahir,
			'agama' => $req->agama,
			'wnegara' => $req->wnegara,
			'status' => $req->status,
			'alamat' => $req->alamat,
			'rt' => $req->rt,
			'rw' => $req->rw,
			'identitas_info' => $req->akses_info,
			'identitas_info_kepada' => $req->akses_info_ke,
			'nama_ttd' => $req->nama,
			'kodepos' => $req->kodepos,
			'pendidikan' => $req->pendidikan,
			'pekerjaan' => $req->pekerjaan,
			'no_telp' => $req->no_telp,
			'no_hp' => $req->no_hp,
			'no_telp_kantor' => $req->no_telp_kantor,
			// 'email'=>$req->,
			'goldarah' => $req->goldarah,
			'tgl_daftar' => date("Y-m-d"),
			'xupdate' => date("Y-m-d H:i:s"),
			'xuser' => 'My Hatta',
			'userid' => '1',
			'ttd_pasien' => $req->ttd_pasien,
		];
		$id = $this->rjmregistrasi->insert_pasien_irj($clean_data);
		try {
			$response = $this->clients->request(
				'POST',
				'http://192.168.112.121:9810/api/v1/mobile/updatePasienBaru/' . $req->no_identitas,
				[
					'headers' => [
						'x-token' => $this->token,
						'x-username' => 'eyJpdiI6ICJoaXVwQU9CcFZHaVJUUVlzNHVqcnlnPT0iLCAiZGF0YSI6ICJyUGxEV05LaSt2K3p0SVYwSEVsSDJRPT0ifQ=='
					]
				]
			)->getBody()->getContents();
		} catch (Exception $e) {
			throw new \Exception($e->getMessage(), 1);
		}
		echo json_encode([
			'code' => 200,
			'norm' => $id
		]);
	}
}
