<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
//  include(dirname(dirname(__FILE__)).'/Tglindo.php');
use GuzzleHttp\Client;

include('Rjcterbilang.php');

class rjcpelayanan extends Secure_area
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimtindakan');
		$this->load->model('emedrec/M_emedrec', '', TRUE);
		$this->load->model('irj/rjmpencarian', '', TRUE);
		$this->load->model('ird/rdmpelayanan', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('pa/pamdaftar', '', TRUE);
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
		$this->load->model('farmasi/Frmmkwitansi', '', TRUE);
		$this->load->model('irj/Rjmkwitansi', '', TRUE);
		$this->load->model('irj/rjmtracer', '', TRUE);
		$this->load->model('ird/ModelPelayanan', '', TRUE);
		$this->load->model('master/Mmformigd', '', TRUE);
		$this->load->model('rad/radmdaftar', '', TRUE);
		$this->load->model('elektromedik/emmdaftar', '', TRUE);
		$this->load->model('admin/M_user', '', TRUE);
		$this->load->model('master/mmgizi', '', TRUE);
		$this->load->model('gizi/Mgizi', '', TRUE);
		$this->load->model('irj/M_update_sepbpjs', '', TRUE);
		$this->load->model('bpjs/Mbpjs', '', TRUE);
		// $this->load->helper('bpjs');
		// $this->load->helper('pdf_helper');
		$this->load->model('iri/rimpasien');
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('irj/Mdiagnosa', '', TRUE);
	}
	public function index()
	{
		redirect('irj/rjcregistrasi');
	}

	public function list_poli()
	{
		date_default_timezone_set("Asia/Jakarta");

		$data['title'] = 'List Poliklinik Perawat';
		$username = $this->M_user->get_info($this->session->userdata('userid'))->username;
		$data['poliklinik'] = $this->rjmpencarian->get_poli_non_igd($this->session->userdata('userid'))->result();
		$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();

		$this->load->view('irj/rjvlistpoli', $data);
	}

	public function pasien_poli() //pencarian
	{
		$id_poli = $this->input->post('poli');
		redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli);
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan = $this->input->post('id_tindakan');
		$kelas = $this->input->post('kelas');
		$cara_bayar = $this->input->post('cara_bayar');
		$biaya = array();
		if ($kelas == 'EKSEKUTIF') {
			$kelas = 'VVIP';
		}
		$result = $this->rjmpelayanan->get_biaya_tindakan($id_tindakan, $kelas)->row();
		if ($cara_bayar == 'KERJASAMA') {
			if ($result->tarif_iks == NULL) {
				$biaya[0] = 0;
			} else {
				$biaya[0] = $result->tarif_iks;
			}
		} else if ($cara_bayar == 'BPJS') {
			if ($result->tarif_bpjs == NULL) {
				$biaya[0] = 0;
			} else {
				$biaya[0] = $result->tarif_bpjs;
			}
		} else {
			$biaya[0] = $result->total_tarif;
		}
		$biaya[1] = $result->tarif_alkes;
		echo json_encode($biaya);
	}

	public function update_waktu_masuk()
	{
		date_default_timezone_set('Asia/Jakarta');
		$no_register = $this->input->post('no_register');

		$id_poli = $this->rjmpelayanan->get_id_poli_by_noreg($no_register)->row();

		if ($id_poli->id_poli == 'ME00') {
			$cek_waktu_masuk_poli = $this->rjmpelayanan->get_waktu_masuk_poli_by_noreg($no_register)->row();

			if ($cek_waktu_masuk_poli == null) {

				$data_update = array(
					'waktu_masuk_poli' => date("Y-m-d H:i:s"),
					'pemeriksa_perawat' => $this->load->get_var("user_info")->userid,
				);
				$result = $this->rjmpelayanan->update_waktu_masuk($no_register, $data_update);
				echo json_encode($result);
			} else {
				echo json_encode(true);
			}
		} else {
			$data_update = array(
				'waktu_masuk_poli' => date("Y-m-d H:i:s"),
				'pemeriksa_perawat' => $this->load->get_var("user_info")->userid,

			);
			$result = $this->rjmpelayanan->update_waktu_masuk($no_register, $data_update);
			echo json_encode($result);
		}

		/**
		 * Added untuk keperluan antrol update task id => 4
		 */
		// check pasien if antrol daftar_ulang_irj(noreservasi)
		$noreservasi = $this->rjmpelayanan->get_no_reservasi($this->input->post('no_register'));
		// var_dump($noreservasi);die();
		if ($noreservasi->noreservasi != '' && $noreservasi->noreservasi != null) {
			$this->clients = new Client([
				'verify' => false,
				// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
			]);
			$this->endpoint = 'http://192.168.1.139:8000/';

			// cek dahulu apakah task 3 exist
			$antrol = json_decode($this->clients->get(
				$this->endpoint . 'adminantrian/prosesantrian/' . $noreservasi->noreservasi . '/3'
			)->getBody()->getContents());
			$antrol = json_decode($this->clients->get(
				$this->endpoint . 'adminantrian/prosesantrian/' . $noreservasi->noreservasi . '/4'
			)->getBody()->getContents());
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////batal
	public function pelayanan_batal($id_poli = '', $no_register = '', $status = '')
	{
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		//	if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32' || $data['roleid']=='43'){
		$status_sep = $this->rjmpelayanan->get_status_sep($no_register);
		if ($status_sep == '') {
			$notif = '<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Registrasi Tidak Ditemukan
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('notification', $notif);
			redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli);
		} else {
			if ($status_sep->cara_bayar == 'BPJS') {
				$id = $this->rjmpelayanan->batal_pelayanan_poli($no_register, $status);
				if ($status_sep->poli_ke == 1 && $status_sep->no_sep != NULL || $status_sep->poli_ke == 1 && $status_sep->no_sep != '') {
					hapus_sep($status_sep->no_sep, 2);
				}
				$notif = '<div class="alert alert-success">
	                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
	                       		</div>';
				$this->session->set_flashdata('notification', $notif);
				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli);
			} else {
				$id = $this->rjmpelayanan->batal_pelayanan_poli($no_register, $status);
				$notif = '<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses.</h3> Pelayanan Berhasil Dibatalkan.
                       		</div>';
				$this->session->set_flashdata('notification', $notif);
				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli);
			}
		} // else status sep
		// //	} else {
		// 		$notif = '<div class="box box-default">
		// 							<div class="alert alert-danger alert-dismissable">
		// 								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		// 								<i class="icon fa fa-check"></i>
		// 								Anda tidak memiliki hak akses untuk pembatalan pasien
		// 							</div>
		// 						</div>';
		// 		$this->session->set_flashdata('notification', $notif);
		// 		redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli);
		// //	}

	}

	public function asdasdasd($id_poli){
		$data['pasien_daftar'] = $this->rjmpencarian->get_pasien_daftar_today($id_poli)->result();

		var_dump($data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////pencarian list antrian pasien per poli by
	public function kunj_pasien_poli($id_poli = '') //perpoli
	{
		date_default_timezone_set("Asia/Jakarta");

		$data['title'] = 'List Pasien Poliklinik | ' . date('d-m-Y');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$data['kontraktor'] = $this->rdmpelayanan->get_kontraktor()->result();
		$data['kontraktor_bpjs'] = $this->rdmpelayanan->get_kontraktor_bpjs()->result();
		if ($data['roleid'] == '1' || $data['roleid'] == '25' || $data['roleid'] == '32') {
			$data['access'] = 1;
		} else {
			$data['access'] = 0;
		}
		$data['pasien_daftar'] = $this->rjmpencarian->get_pasien_daftar_today($id_poli)->result();
		$get_nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->result();
		foreach ($get_nm_poli as $row) {
			$data['nma_poli'] = $row->nm_poli;
			$data['poli_bpjs'] = $row->poli_bpjs;

		}

		$data['id_poli'] = $id_poli;
		if (sizeof($data['pasien_daftar']) == 0) {
			$this->session->set_flashdata('message_nodata', '<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		} else {
			$this->session->set_flashdata('message_nodata', '');
		}

		$this->load->view('irj/rjvpasienpoli', $data);
	}

	public function kunj_pasien_poli_antrol($id_poli = '') //perpoli
	{
		date_default_timezone_set("Asia/Jakarta");

		$data['title'] = 'List Pasien Poliklinik | ' . date('d-m-Y');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$data['kontraktor'] = $this->rdmpelayanan->get_kontraktor()->result();
		$data['kontraktor_bpjs'] = $this->rdmpelayanan->get_kontraktor_bpjs()->result();
		if ($data['roleid'] == '1' || $data['roleid'] == '25' || $data['roleid'] == '32') {
			$data['access'] = 1;
		} else {
			$data['access'] = 0;
		}
		// $data['pasien_daftar'] = $this->rjmpencarian->get_pasien_daftar_today_checkin($id_poli)->result();
		// Ambil kedua data
		$data['pasien_sudah_checkin'] = $this->rjmpencarian->get_pasien_daftar_today_checkin($id_poli)->result();
		$data['pasien_belum_checkin'] = $this->rjmpencarian->get_pasien_daftar_today_notcheckin($id_poli)->result();
		$get_nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->row();
		// foreach ($get_nm_poli as $row) {
		// 	$data['nma_poli'] = $row->nm_poli;
		// 	$data['poli_bpjs'] = $row->poli_bpjs;

		// }
		$data['nma_poli'] = $get_nm_poli->nm_poli;
		$data['poli_bpjs'] = $get_nm_poli->poli_bpjs;

		$data['id_poli'] = $id_poli;
		// if (sizeof($data['pasien_daftar']) == 0) {
		// 	$this->session->set_flashdata('message_nodata', '<div class="row">
		// 				<div class="col-md-12">
		// 				  <div class="box box-default box-solid">
		// 					<div class="box-header with-border">
		// 					  <center>Tidak ada lagi data</center>
		// 					</div>
		// 				  </div>
		// 				</div>
		// 			</div>');
		// } else {
		// 	$this->session->set_flashdata('message_nodata', '');
		// }

		$this->load->view('irj/rjvpasienpoliantrol', $data);
	}

	private function reverse_tgl($tgl)
	{
		$tgl_lahir_mentah = explode('/', $tgl);
		$reverse_tgl_lahir = $tgl_lahir_mentah[2] . '-' . $tgl_lahir_mentah[1] . '-' . $tgl_lahir_mentah[0];
		return $reverse_tgl_lahir;
	}

	public function kunj_pasien_poli_by_date()
	{
		$date = $this->input->post('date');
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		// if($data['roleid']=='1' || $data['roleid']=='25' || $data['roleid']=='32'){
		// 	$data['access']=1;
		// }else{
		// 	$data['access']=0;
		// }

		$id_poli = $this->input->post('id_poli'); //perpoli
		//	if ($data['roleid']=='48') {
		//		$data['pasien_daftar']=$this->rjmpencarian->get_pasien_urikes_by_date($id_poli,$date)->result();
		//	}else{
		$data['pasien_daftar'] = $this->rjmpencarian->get_pasien_daftar_by_date($id_poli, $date)->result();

		//	}
		$get_nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->result();
		foreach ($get_nm_poli as $row) {
			$data['nma_poli'] = $row->nm_poli;
			$data['poli_bpjs'] = $row->poli_bpjs;

		}
		$data['id_poli'] = $id_poli;
		if (sizeof($data['pasien_daftar']) == 0) {
			$this->session->set_flashdata('message_nodata', '<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		} else {
			$this->session->set_flashdata('message_nodata', '');
		}
		$data['title'] = 'List Pasien Poliklinik | ' . date('d-m-Y', strtotime($date));

		$this->load->view('irj/rjvpasienpoli', $data);
	}
	// public function obj_tanggal(){
	// 	 $tgl_indo = new Tglindo();
	// 	 return $tgl_indo;
	// }

	function tindakan_pasien($no_register = '')
	{



		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();

		foreach ($hasil as $value) {
			$surat = $value->idtindakan;

			$row2['id_pelayanan_poli'] = $value->id_pelayanan_poli;
			$row2['nmtindakan'] = $value->nmtindakan;
			$row2['tmno'] = $value->tmno;
			$row2['nm_dokter'] = $value->nm_user;
			$row2['nm_asis'] = $value->asisten_nmuser;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan, 2, ',', '.');
			$row2['qtyind'] = $value->qtyind;
			$row2['biaya_tindakan'] = number_format($value->biaya_tindakan, 2, ',', '.');
			$row2['vtot'] = number_format($value->vtot, 2, ',', '.');
			if ($value->ttd_dokter == '') {
				$row2['ttd'] = ' ';
			} else {
				$row2['ttd'] = '<img src="' . $value->ttd . '" alt="" width="50px" height="50px"/> ';
			}

			// surat kesehatan
			if ($surat == "1B1010") {
				$row2['aksi'] = '
				

				<a href="' . site_url('irj/rjcpelayanan/hapus_tindakan/' . $value->idpoli . '/' . $value->id_pelayanan_poli . '/' . $no_register) . '" onclick="hapus()" class="btn btn-danger btn-xs">Hapus</a>';
				// surat kesehatan jiwa
			} else if ($surat == "1B0115") {
				$row2['aksi'] = '
				

				<a href="' . site_url('irj/rjcpelayanan/hapus_tindakan/' . $value->idpoli . '/' . $value->id_pelayanan_poli . '/' . $no_register) . '" onclick="hapus()" class="btn btn-danger btn-xs">Hapus</a>';
				// surat bebas narkoba
			} else if ($surat == "1B0114") {
				$row2['aksi'] = '
				

				<a href="' . site_url('irj/rjcpelayanan/hapus_tindakan/' . $value->idpoli . '/' . $value->id_pelayanan_poli . '/' . $no_register) . '" onclick="hapus()" class="btn btn-danger btn-xs">Hapus</a>';
			} else {
				$row2['aksi'] = '<a href="' . site_url('irj/rjcpelayanan/hapus_tindakan/' . $value->idpoli . '/' . $value->id_pelayanan_poli . '/' . $no_register) . '" onclick="hapus()" class="btn btn-danger btn-xs">Hapus</a>';
			}

			$line2[] = $row2;
		}
		$line['data'] = $line2;

		// soap
		$tindakan_rows = count($hasil);

		foreach ($hasil as $key) {

			$idtindakan[] = $key->idtindakan;
			$nmtindakan[] = $key->nmtindakan;
		}
		$tidak_ada_tindakan[] = array("Tidak Ada Tindakan");

		$tampung_tindakan = array();
		if ($tindakan_rows == 0) {
			for ($i = 0; $i < $tindakan_rows; $i++) {
				$tampung_tindakan[] = $tampung_tindakan[$i];
			}
		} else {
			for ($i = 0; $i < $tindakan_rows; $i++) {
				$tampung_tindakan[] = '-' . ' ' . $nmtindakan[$i] . '(' . $idtindakan[$i] . ')' . '<br>';
			}
		}
		$gabung_tindakan = implode($tampung_tindakan);

		$cek_pasien_apa = substr($no_register, 0, 2);

		if ($cek_pasien_apa == 'RI') {
			$cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
		} else {
			$cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
		}


		$soap['terapi_tindakan_dokter'] = $gabung_tindakan;
		// var_dump($soap['terapi_tindakan_dokter']);die();

		$id_soap = $cek_soap->row();
		// var_dump($cek_soap->num_rows());
		// die();
		if ($id_soap != null) {
			$this->emmdaftar->update_data_soap($id_soap->id, $soap);
		} else {
			$soap['no_register'] = $no_register;
			$this->emmdaftar->insert_data_soap($soap);
		}


		echo json_encode($line);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	function autocomplete_diagnosa()
	{
		if (isset($_GET['term'])) {
			$q = strtolower($_GET['term']);
			$this->rjmpelayanan->autocomplete_diagnosa($q);
		}
	}
	function autocomplete_procedure()
	{
		if (isset($_GET['term'])) {
			$q = strtolower($_GET['term']);
			$this->rjmpelayanan->autocomplete_procedure($q);
		}
	}
	public function set_utama_diagnosa()
	{
		$id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
		$no_register = $this->input->post('no_register');
		$result = $this->rjmpelayanan->set_utama_diagnosa($id_diagnosa_pasien, $no_register);
		echo json_encode($result);
	}
	public function set_utama_procedure()
	{
		$id = $this->input->post('id');
		$no_register = $this->input->post('no_register');
		$result = $this->rjmpelayanan->set_utama_procedure($id, $no_register);
		echo json_encode($result);
	}
	public function diagnosa_pasien()
	{
		$data_diagnosa = $this->rjmpelayanan->get_diagnosa_pasien();
		$data = array();
		$no = $_POST['start'];
		$diagnosa_pasien = '';
		$no_register = $this->input->post('no_register');

		foreach ($data_diagnosa as $diagnosa) {
			$no++;
			$row = array();
			$row[] = $no;
			// if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
			if ($diagnosa->diagnosa != '') {
				if ($diagnosa->klasifikasi_diagnos == 'utama') {
					$row[] = '<strong>' . $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa . '</strong>';
				} else $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa;
			} else $row[] = '';

			if ($diagnosa->klasifikasi_diagnos == 'utama') {
				$row[] = '<strong>' . $diagnosa->diagnosa_text . '</strong>';
				$row[] = '<center><strong>' . $diagnosa->klasifikasi_diagnos . '</strong></center>';
				$row[] = '<button type="button" onclick="delete_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			} else {
				$row[] = $diagnosa->diagnosa_text;
				$row[] = '<center>' . $diagnosa->klasifikasi_diagnos . '</center>';
				$row[] = '<button type="button" onclick="set_utama_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			}
			$data[] = $row;
		}

		$diagnosa_rows = count($data_diagnosa);

		foreach ($data_diagnosa as $key) {

			$id_diagnosa[] = $key->id_diagnosa;
			$nm_diagnosa[] = $key->diagnosa;
			$jns_diagnosa[] = $key->klasifikasi_diagnos;
			$cat_diagnosa[] = $key->diagnosa_text;
		}

		$tidak_ada_diagnosa[] = array("Tidak Ada Diagnosa");

		$tampung_diagnosa = array();
		if ($diagnosa_rows == 0) {
			for ($i = 0; $i < $diagnosa_rows; $i++) {
				$tampung_diagnosa[] = $tampung_diagnosa[$i];
			}
		} else {
			for ($i = 0; $i < $diagnosa_rows; $i++) {
				if ($cat_diagnosa[$i] == null) {
					$tampung_diagnosa[] = '-' . '(' . $id_diagnosa[$i] . ')' . $nm_diagnosa[$i] . '(' . $jns_diagnosa[$i] . ')' . '<br>';
				} else {
					$tampung_diagnosa[] = '-' . '(' . $id_diagnosa[$i] . ')' . $nm_diagnosa[$i] . '(' . $jns_diagnosa[$i] . ')' . '<br>' . 'Catatan :' . $cat_diagnosa[$i] . '<br>';
				}
			}
		}
		$gabung_diagnosa = implode($tampung_diagnosa);

		$cek_pasien_apa = substr($no_register, 0, 2);

		if ($cek_pasien_apa == 'RI') {
			$cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
		} else {
			$cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
		}


		$soap['diagnosis_kerja_dokter'] = $gabung_diagnosa;
		


		$id_soap = $cek_soap->row();
		// if ($id_soap != null) {
		// 	if($cek_soap->row()->assesment_dokter != null){
		// 		$soap['assesment_dokter'] = $cek_soap->row()->assesment_dokter.'<br>'.'Diagnosa : <br> '.$gabung_diagnosa;
		// 	}else{
		// 		$soap['assesment_dokter'] = 'Diagnosa <br>'.$gabung_diagnosa;
		// 	}
		// 	$this->emmdaftar->update_data_soap($id_soap->id, $soap);
		// } else {
		// }

		if ($id_soap != null) {
			$soap['assesment_dokter'] = $gabung_diagnosa;
			$this->emmdaftar->update_data_soap($id_soap->id, $soap);
		} else {
		}


		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rjmpelayanan->diagnosa_count_all(),
			"recordsFiltered" => $this->rjmpelayanan->diagnosa_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function diagnosa_pasien_view()
	{
		$data_diagnosa = $this->rjmpelayanan->get_diagnosa_pasien();
		$data = array();
		$no = $_POST['start'];
		$diagnosa_pasien = '';

		foreach ($data_diagnosa as $diagnosa) {
			$no++;
			$row = array();
			$row[] = $no;
			if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
				if ($diagnosa->klasifikasi_diagnos == 'utama') {
					$row[] = '<strong>' . $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa . '</strong>';
				} else $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa;
			} else $row[] = '';

			if ($diagnosa->klasifikasi_diagnos == 'utama') {
				$row[] = '<strong>' . $diagnosa->diagnosa_text . '</strong>';
				$row[] = '<center><strong>' . $diagnosa->klasifikasi_diagnos . '</strong></center>';
			} else {
				$row[] = $diagnosa->diagnosa_text;
				$row[] = '<center>' . $diagnosa->klasifikasi_diagnos . '</center>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rjmpelayanan->diagnosa_count_all(),
			"recordsFiltered" => $this->rjmpelayanan->diagnosa_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function procedure_pasien()
	{
		$data_procedure = $this->rjmpelayanan->get_procedure_pasien();
		$data = array();
		$no = $_POST['start'];
		$no_register = $this->input->post('no_register');
		foreach ($data_procedure as $procedure) {
			$no++;
			$row = array();
			$row[] = $no;
			if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
				if ($procedure->klasifikasi_procedure == 'utama') {
					$row[] = '<strong>' . $procedure->id_procedure . ' - ' . $procedure->nm_procedure . '</strong>';
				} else $row[] = $procedure->id_procedure . ' - ' . $procedure->nm_procedure;
			} else $row[] = '';

			if ($procedure->klasifikasi_procedure == 'utama') {
				$row[] = '<strong>' . $procedure->procedure_text . '</strong>';
				$row[] = '<center><strong>' . $procedure->klasifikasi_procedure . '</strong></center>';
				$row[] = '<button type="button" onclick="delete_procedure(\'' . $procedure->id . '\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			} else {
				$row[] = $procedure->procedure_text;
				$row[] = '<center>' . $procedure->klasifikasi_procedure . '</center>';
				$row[] = '<button type="button" onclick="set_utama_procedure(\'' . $procedure->id . '\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_procedure(\'' . $procedure->id . '\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			}
			$data[] = $row;
		}

		$procedure_rows = count($data_procedure);

		foreach ($data_procedure as $key) {

			$id_procedure[] = $key->id_procedure;
			$nm_procedure[] = $key->nm_procedure;
			$jns_procedure[] = $key->klasifikasi_procedure;
			$cat_procedure[] = $key->procedure_text;
		}

		$tidak_ada_procedure[] = array("Tidak Ada Procedure");

		$tampung_procedure = array();
		if ($procedure_rows == 0) {
			for ($i = 0; $i < $procedure_rows; $i++) {
				$tampung_procedure[] = $tampung_procedure[$i];
			}
		} else {
			for ($i = 0; $i < $procedure_rows; $i++) {

				if ($cat_procedure[$i] == null) {
					$tampung_procedure[] = '-' . '(' . $id_procedure[$i] . ')' . $nm_procedure[$i] . '(' . $jns_procedure[$i] . ')' . '<br>';
				} else {
					$tampung_procedure[] = '-' . '(' . $id_procedure[$i] . ')' . $nm_procedure[$i] . '(' . $jns_procedure[$i] . ')' . '<br>' . 'Catatan :' . $cat_procedure[$i] . '<br>';
				}
			}
		}
		$gabung_procedure = implode($tampung_procedure);

		$cek_pasien_apa = substr($no_register, 0, 2);

		if ($cek_pasien_apa == 'RI') {
			$cek_soap = $this->emmdaftar->cek_elektromedik($no_register);
		} else {
			$cek_soap = $this->emmdaftar->cek_elektromedikrj($no_register);
		}


		// $soap['plan_dokter'] = $gabung_procedure;
		// $soap['plan_perawat'] = $gabung_procedure;


		// $id_soap = $cek_soap->row();
		// if ($id_soap != null) {
		// 	$this->emmdaftar->update_data_soap($id_soap->id,$soap);
		// }else{

		// }

		$id_soap = $cek_soap->row();
		// if ($id_soap != null) {
		// 	if($cek_soap->row()->assesment_dokter != null){
		// 		$soap['assesment_dokter'] = $cek_soap->row()->assesment_dokter.'<br>'.'Procedure : <br> '.$gabung_procedure;
		// 	}else{
		// 		$soap['assesment_dokter'] = 'Procedure<br>'.$gabung_procedure;
		// 	}
		// 	$this->emmdaftar->update_data_soap($id_soap->id, $soap);
		// } else {
		// }

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rjmpelayanan->procedure_count_all(),
			"recordsFiltered" => $this->rjmpelayanan->procedure_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function procedure_pasien_view()
	{
		$data_procedure = $this->rjmpelayanan->get_procedure_pasien();
		$data = array();
		$no = $_POST['start'];
		foreach ($data_procedure as $procedure) {
			$no++;
			$row = array();
			$row[] = $no;
			if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
				if ($procedure->klasifikasi_procedure == 'utama') {
					$row[] = '<strong>' . $procedure->id_procedure . ' - ' . $procedure->nm_procedure . '</strong>';
				} else $row[] = $procedure->id_procedure . ' - ' . $procedure->nm_procedure;
			} else $row[] = '';

			if ($procedure->klasifikasi_procedure == 'utama') {
				$row[] = '<strong>' . $procedure->procedure_text . '</strong>';
				$row[] = '<center><strong>' . $procedure->klasifikasi_procedure . '</strong></center>';
			} else {
				$row[] = $procedure->procedure_text;
				$row[] = '<center>' . $procedure->klasifikasi_procedure . '</center>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rjmpelayanan->procedure_count_all(),
			"recordsFiltered" => $this->rjmpelayanan->procedure_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function insert_diagnosa()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_diag');
		$cek_utama = $this->rjmpelayanan->count_utama_diagnosa($no_register);
		if ($cek_utama > 0) {
			$klasifikasi = 'tambahan';
		} else {
			$klasifikasi = 'utama';
		}
		$diagnosa_text = $this->input->post('diagnosa_text');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$id_diagnosa = '';
		$diagnosa = '';

		if ($this->input->post('id_diagnosa') != '') {
			$postdiagnosa = explode("@", $this->input->post('diagnosa_separate'));
			$id_diagnosa = $postdiagnosa[0];
			$diagnosa = $postdiagnosa[1];
		}

		$data_insert = array(
			'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
			'no_register' => $no_register,
			'id_poli' => $this->input->post('id_poli'),
			'id_diagnosa' => $id_diagnosa,
			'diagnosa' => $diagnosa,
			'diagnosa_text' => $diagnosa_text,
			'klasifikasi_diagnos' => $klasifikasi,
			'xuser' => $user
		);
		$result = $this->rjmpelayanan->insert_diagnosa($data_insert);
		echo $result;
	}
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {
	// 	$id=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function hapus_procedure()
	{
		// var_dump($this->input->post());die();
		// echo $this->input->post('id');
		$delete = $this->rjmpelayanan->hapus_procedure($this->input->post('id'));
		echo json_encode($delete);
	}
	public function hapus_diagnosa($id_diagnosa_pasien)
	{
		$delete = $this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
		echo json_encode($delete);
	}

	public function form_($kode, $id_poli, $no_register)
	{

		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		$data['id_poli'] = 'BA00';
		$data['statfisik'] = 'show';
		$data['view'] = 0;
		//$data['statfisik'] = 'hide';
		$data['staff'] = 'perawat';

		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad = $this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['kelas_pasien'] = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar'] = $data['data_pasien_daftar_ulang']->cara_bayar;
		$data['id_dokterrawat'] = $data['data_pasien_daftar_ulang']->id_dokter;
		$data['id_poli'] = $data['data_pasien_daftar_ulang']->id_poli;
		$data['data_tindakan_pasien'] = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid'] = '';

		$data['a_lab'] = "open";
		$data['a_pa'] = "open";
		$data['a_obat'] = "open";
		$data['a_rad'] = "open";
		$data['a_ok'] = "open";
		$data['a_fisio'] = "open";
		$data['a_em'] = "open";
		$result = $this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab == "0" || $result->status_lab == "1") {
			$data['a_lab'] = "closed";
		}
		if ($result->ok == "0" || $result->status_ok == "1") {
			$data['a_ok'] = "closed";
		}
		if ($result->pa == "0" || $result->status_pa == "1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat == "0" || $result->status_obat == "1") {
			$data['a_obat'] = "closed";
		}
		if ($result->rad == "0" || $result->status_rad == "1") {
			$data['a_rad'] = "closed";
		}
		if ($result->fisio == "0" || $result->status_fisio == "1") {
			$data['a_fisio'] = "closed";
		}
		if ($result->em == "0" || $result->status_em == "1") {
			$data['a_em'] = "closed";
		}

		if ($id_poli == 'BW01') {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}

		if ($id_poli == 'BG00') {
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli, 0, 2) == 'BV') {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}

		//to disabled print button
		foreach ($data['data_tindakan_pasien'] as $row) {
			if ($row->bayar == '0') {
				$data['unpaid'] = '1';
			}
		}
		$data['data_pasien'] = $this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->Mmformigd->get_form_by_kode_irj($kode)->row()->views;



		switch ($kode) {
			case 'pem_fisik':
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_kep':
				$data['data_keperawatan'] = $this->rjmpelayanan->getdata_keperawatan($no_register)->result();
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_mata':
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_awal_bidan':
				$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'assesment_kunj':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'assesment_kunj_fis':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'assesment_medik_dok':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'asesmen_medik_dok_mata':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'gigi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'gizi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'medik_rehab':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'medik_rehab_anak':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'operasi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_ok_pasien'] = $this->rjmpelayanan->getdata_ok_pasien($no_register, $datenow)->result();
				break;
			case 'lab':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_lab_pasien'] = $this->rjmpelayanan->getdata_lab_pasien($no_register, $datenow)->result();
				$data['cetak_lab_pasien'] = $this->rjmpelayanan->getcetak_lab_pasien($no_register)->result();
				break;
			case 'rad':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_rad_pasien'] = $this->rjmpelayanan->getdata_rad_pasienrj($no_register, $datenow)->result();
				$data['cetak_rad_pasien'] = $this->rjmpelayanan->getcetak_rad_pasien($no_register)->result();
				break;
			case 'em':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_em_pasien'] = $this->rjmpelayanan->getdata_em_pasienrj($no_register, $datenow)->result();
				$data['cetak_em_pasien'] = $this->rjmpelayanan->getcetak_em_pasien($no_register)->result();
				break;
			case 'resep':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_resep_pasien'] = $this->rjmpelayanan->getdata_resep_pasien($no_register, $datenow)->result();
				$data['cetak_resep_pasien'] = $this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				break;
			case 'tf_ruang':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'konsul':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'jawaban_konsul':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			case 'assesment_fungsional':
				$data['penilaian_fungsional_status'] = $this->rjmpelayanan->check_penilaian_fungsional_status($no_register)->row();
				break;
			case 'keperawatan':
				$data['assesment_medik_igd'] = $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$triase = $this->rdmpelayanan->get_triase_by_noreg($no_register);
				($triase->num_rows() >= 1) ? $data['triase'] = $triase->result() : '';
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1) ? $data['assesment_keperawatan'] = $assesment_keperawatan->result() : '';
				$data['data_pemeriksa'] = $this->load->get_var("user_info");
				break;
			case 'evaluasi':
				$data['pelayan'] = 'PERAWAT';
				$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
				$data['data_pasien_daftar_ulang'] = $this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				break;
			case 'transferruangan':
				$data['transfer_ruangan'] = $this->rdmpelayanan->check_transfer_ruangan($no_register)->row();
				$data['assesment_medik_igd'] = $this->rdmpelayanan->get_assesment_medik_igd_bynoreg($no_register);
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1) ? $data['assesment_keperawatan'] = $assesment_keperawatan->result() : '';
				$data['data_pasien_daftar_ulang'] = $this->rdmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
				$data['data_fisik'] = $this->rdmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			case 'serahterima':
				$data['serah_terima'] = $this->rdmpelayanan->check_serah_terima($no_register)->row();
				$data['soap_pasien_rj'] = $this->rdmpelayanan->get_soappasienrj_bynoreg($no_register)->row();
				$data['assesment_keperawatan'] = '';
				$assesment_keperawatan = $this->rdmpelayanan->get_assesment_keperawatan_by_noreg($no_register);
				($assesment_keperawatan->num_rows() >= 1) ? $data['assesment_keperawatan'] = $assesment_keperawatan->result() : '';
				$data['diagnosa_pasien'] = $this->rdmpelayanan->get_diagnosa_pasien_noreg($no_register)->result();
				break;
			case 'penilaianfungsional':
				$data['penilaian_fungsional_status'] = $this->rdmpelayanan->check_penilaian_fungsional_status($no_register)->row();
				break;
			case 'tindakan':
				$data['idpokdiet'] = '';
				$data['users'] = $this->rimtindakan->get_users()->result();
				if ($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()) {
					$data['idpokdiet'] = $this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
				}
				if ($data['kelas_pasien'] == 'EKSEKUTIF') {
					$kelasnya = 'VVIP';
				} else {
					$kelasnya = $data['kelas_pasien'];
				}
				$data['tindakans'] = $this->ModelPelayanan->getdata_jenis_tindakan($kelasnya)->result();
				//$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli('BA00')->result();
				break;
			case 'geriatri':
				$data['geriatri'] = $this->rjmpelayanan->get_geriatri_rj($no_register);
				break;
			case 'surveilans':
				$data['survei_irj'] = $this->rdmpelayanan->get_surveilans_irj($no_register)->row();
				$data['lap_anestesi'] = $this->rdmpelayanan->get_laporan_anestesi_by_noreg($no_register)->row();
				$data['lap_operasi'] = $this->rdmpelayanan->get_laporan_operasi_by_noreg($no_register)->row();
				$data['persiapan_opr'] = $this->rdmpelayanan->get_checklist_persiapan_operasi_by_noreg($no_register)->row();
				break;
			case 'rasal':
				$data['rasal'] = $this->rjmpelayanan->get_data_rasal($no_register)->row();
				break;
			case 'raslan':
				$data['raslan'] = $this->rjmpelayanan->get_data_raslan($no_register)->row();
				break;
			case 'gyssens':
				$data['gyssens'] = $this->rjmpelayanan->get_data_gyssens($no_register)->row();
				break;
			case 'raspatur':
				$data['raspatur'] = $this->rjmpelayanan->get_data_raspatur($no_register)->row();
				break;
			case 'iadl':
				$data['iadl'] = $this->rjmpelayanan->get_data_iadl($no_register)->row();
				break;
			case 'edukasi_penolakan_rencana_asuhan':
				$data['edukasi_penolakan_rencana_asuhan'] = $this->rjmpelayanan->get_edukasi_penolakan_rencana_asuhan($no_register)->row();
				break;
			case 'nihss':
				$data['nihss'] = $this->rjmpelayanan->get_nihss($no_register)->row();
				break;
			case 'suket_sakit':
				$data['suket_sakit'] = $this->rjmpelayanan->get_suket_sakit($no_register)->row();
				break;
		}
		return $this->load->view($views, $data);
	}

	public function surveilans()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		// $idrg = $this->rimtindakan->get_idrg_pasien_iri($noipd)->row()->idrg;

		$check = $this->rdmpelayanan->get_surveilans_irj($noipd);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			// $data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->update_surveilans_iri($noipd, $data);
		} else {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			// $data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->insert_surveilans($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function pelayanan_tindakan($id_poli = '', $no_register = '', $tab = '', $param3 = '', $param4 = '')
	{
		$data['pelayan'] = 'PERAWAT';
		$data['nm_poli'] = $this->rjmpelayanan->get_nama_poli($id_poli)->row()->nm_poli;
		$data['id_poli'] = $id_poli;
		$no_medrecrad = $this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$poli_detail = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row();
		$data['nama_poli'] = $poli_detail->nm_poli;
		$data['poli_bpjs'] = $poli_detail->poli_bpjs;
		$data['data_pasien'] = $this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		$data['kelas_pasien'] = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm'] = $data['data_pasien_daftar_ulang']->no_cm;
		$data['tgl_kun'] = $data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['cara_bayar'] = $data['data_pasien_daftar_ulang']->cara_bayar;
		$data['idrg'] = 'IRJ';
		$data['id_dokterrawat'] = $data['data_pasien_daftar_ulang']->id_dokter;
		$data['bed'] = 'Rawat Jalan';
		$nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register'] = $no_register;
		$data['title'] = 'Pelayanan Pasien | ' . $nm_poli . ' | <a href="#" onclick="return openUrl(`' . site_url('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli) . '`)" id="tombolkembali">Kembali</a>';
		$data['poliklinik'] = $this->rjmpencarian->get_poliklinik()->result();
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli, 0, 2) == 'BV') {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}
		$data['statfisik'] = 'show';

		$this->load->view('irj/rjvpelayananbeta', $data);
	}

	public function pelayanan_tindakan2($id_poli = '', $no_register = '', $tab = '', $param3 = '', $param4 = '')
	{

		$data['pelayan'] = 'PERAWAT';
		$datenow = date('Y-m-d');
		// load data jika poli gigi (BG00)
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data->userid;
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		if ($id_poli == 'BG00') {
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		$data['id_poli'] = $id_poli;
		$data['controller'] = $this;
		$data['view'] = 0;
		$data['rujukan_penunjang'] = $this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
		$data['rujukan_penunjang_2'] = $this->rjmpelayanan->get_rujukan_penunjang_pending($no_register)->row();
		if (empty($data['rujukan_penunjang_2'])) {
			$array_penunjang = array('lab' => 0, 'rad' => 0, 'pa' => 0, 'ok' => 0, 'fisio' => 0, 'em' => 0);
			$data['rujukan_penunjang_2'] = (object) $array_penunjang;
		}

		$data['kerja'] = $this->rjmpencarian->get_pekerjaan()->result();
		$data['a_lab'] = "open";
		$data['a_pa'] = "open";
		$data['a_obat'] = "open";
		$data['a_rad'] = "open";
		$data['a_ok'] = "open";
		$data['a_fisio'] = "open";
		$data['a_em'] = "open";
		$result = $this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab == "0" || $result->status_lab == "1") {
			$data['a_lab'] = "closed";
		}
		if ($result->ok == "0" || $result->status_ok == "1") {
			$data['a_ok'] = "closed";
		}
		if ($result->pa == "0" || $result->status_pa == "1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat == "0" || $result->status_obat == "1") {
			$data['a_obat'] = "closed";
		}
		if ($result->rad == "0" || $result->status_rad == "1") {
			$data['a_rad'] = "closed";
		}
		if ($result->fisio == "0" || $result->status_fisio == "1") {
			$data['a_fisio'] = "closed";
		}
		if ($result->em == "0" || $result->status_em == "1") {
			$data['a_em'] = "closed";
		}
		//ambil data runjukan
		$no_medrecrad = $this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;

		$data['list_ok_pasien'] = $this->rjmpelayanan->getdata_ok_pasien($no_register, $datenow)->result();

		$data['list_lab_pasien'] = $this->rjmpelayanan->getdata_lab_pasien($no_register, $datenow)->result();
		$data['cetak_lab_pasien'] = $this->rjmpelayanan->getcetak_lab_pasien($no_register)->result();

		// $data['list_pa_pasien']=$this->rjmpelayanan->getdata_pa_pasien($no_register,$datenow)->result();
		// $data['cetak_pa_pasien']=$this->rjmpelayanan->getcetak_pa_pasien($no_register)->result();

		$data['list_rad_pasien'] = $this->rjmpelayanan->getdata_rad_pasienrj($no_register, $datenow)->result();
		$data['cetak_rad_pasien'] = $this->rjmpelayanan->getcetak_rad_pasien($no_register)->result();

		$data['list_em_pasien'] = $this->rjmpelayanan->getdata_em_pasienrj($no_register, $datenow)->result();
		$data['cetak_em_pasien'] = $this->rjmpelayanan->getcetak_em_pasien($no_register)->result();

		$data['list_resep_pasien'] = $this->rjmpelayanan->getdata_resep_pasien($no_register, $datenow)->result();
		$data['cetak_resep_pasien'] = $this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();

		// $data['list_fisio_pasien']=$this->rjmpelayanan->getdata_fisio_pasien($no_register,$datenow)->result();
		// $data['cetak_fisio_pasien']=$this->rjmpelayanan->getcetak_fisio_pasien($no_register)->result();

		$data['keldiet'] = $this->mmgizi->get_all_keldiet()->result();
		//get id_poli & no_medrec
		$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();

		$data['nama_poli'] = $this->rjmpelayanan->get_nama_poli($data['data_pasien_daftar_ulang']->id_poli)->row()->nm_poli;
		$data['data_pasien'] = $this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		// print_r($data['data_pasien_daftar_ulang']);die();
		$data['kelas_pasien'] = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm'] = $data['data_pasien_daftar_ulang']->no_cm;
		$data['tgl_kun'] = $data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['cara_bayar'] = $data['data_pasien_daftar_ulang']->cara_bayar;
		$data['idrg'] = 'IRJ';
		$data['id_dokterrawat'] = $data['data_pasien_daftar_ulang']->id_dokter;
		$data['bed'] = 'Rawat Jalan';
		$data['idpokdiet'] = '';
		if ($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()) {
			$data['idpokdiet'] = $this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
		}

		$data['data_diagnosa_pasien'] = $this->rjmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien'] = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid'] = '';

		//to disabled print button
		foreach ($data['data_tindakan_pasien'] as $row) {
			if ($row->bayar == '0') {
				$data['unpaid'] = '1';
			}
		}
		$data['tgl_kunjungan'] = $data['data_pasien_daftar_ulang']->tgl_kunjungan;
		// $data['id_poli']=$id_poli;
		$nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		$data['no_register'] = $no_register;
		$data['title'] = 'Pelayanan Pasien | ' . $nm_poli . ' | <a href="' . site_url('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli) . '">Kembali</a>';

		$data['poliklinik'] = $this->rjmpencarian->get_poliklinik()->result();
		// var_dump($id_poli);die();
		if ($id_poli == 'BA00') {
			$data['tindakans'] = $this->ModelPelayanan->getdata_jenis_tindakan($data['kelas_pasien'])->result();
		} elseif ($id_poli == 'BW01') {
			$data['tindakans'] = $this->rjmpelayanan->get_tindakan_24($data['kelas_pasien'])->result(); //get
		} else {
			$data['tindakans'] = $this->rjmpelayanan->get_tindakan($data['kelas_pasien'], $id_poli)->result(); //get
		}

		// if($id_poli=='BQ00'){
		// 	$data['dokter_tindakan']=$this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		// }else
		$data['perawat_tindakan'] = $this->rjmpelayanan->get_perawat()->result();
		if ($id_poli == 'BW01') {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}


		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli, 0, 2) == 'BV') {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}
		//var_dump(substr($id_poli,0,2));die();
		//////////////////////////////
		$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();

		//data untuk tab laboratorium------------------------------
		$data['data_pemeriksaan'] = $this->labmdaftar->get_data_pemeriksaan($no_register, $data['no_medrec'])->result();
		$data['dokter_lab'] = $this->labmdaftar->getdata_dokter()->result();
		$data['tindakan_lab'] = $this->labmdaftar->getdata_tindakan_pasien()->result();

		//data untuk tab patalogi anatomi------------------------------
		$data['data_pemeriksaan'] = $this->pamdaftar->get_data_pemeriksaan($no_register, $data['no_medrec'])->result();
		$data['dokter_pa'] = $this->pamdaftar->getdata_dokter()->result();
		// $data['tindakan_pa']=$this->pamdaftar->getdata_tindakan_pasien()->result();

		//data untuk tab radiologi---------------------------------------
		$data['dokter_rad'] = $this->radmdaftar->getdata_dokter()->result();
		$data['tindakan_rad'] = $this->radmdaftar->getdata_tindakan_pasien()->result();
		$data['data_tindakan_racikan'] = '';
		$no_medrec = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($no_medrec)->result();

		//data untuk tab elektromedik---------------------------------------
		$data['dokter_em'] = $this->emmdaftar->getdata_dokter()->result();
		$data['tindakan_em'] = $this->emmdaftar->getdata_tindakan_pasien()->result();
		$data['data_tindakan_racikan'] = '';
		$no_medrec = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['data_em_pasien'] = $this->emmdaftar->get_data_pemeriksaan($no_medrec)->result();

		//data untuk tab obat--------------------------------------------
		$result = $this->rjmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat'] = $this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien'] = $this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();


		$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		$data['data_keperawatan'] = $this->rjmpelayanan->getdata_keperawatan($no_register)->result();

		$result = $this->rjmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result = $this->rjmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result = $this->rjmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_rad($no_register)->row()->no_rad);
		$result = $this->rjmpelayanan->get_no_em($no_register)->result();
		$data['no_em'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_em($no_register)->row()->no_em);

		switch ($tab) {

			default:
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "active";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_keperawatan_bidan'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_prosedur'] = "";
				$data['tab_lab'] = "";
				$data['tab_pa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_assesment_keperawatan_mata'] = "";
				$data['tab_rad'] = "";
				$data['tab_konsul'] = "";
				$data['tab_em'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_medik_dokter_mata'] = "";
				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'assesmentMedisMata':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_gizi'] = "";
				$data['tab_assesment_keperawatan_bidan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata'] = "";
				$data['tab_assesment_medik_dokter_mata'] = "active";
				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'jawaban_konsultasi':
				$data['no_pa'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_prosedur'] = '';
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "";
				$data['tab_jawaban_konsul'] = "active";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_gizi'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "";
				$data['tab_obat'] = '';
				$data['tab_racikan'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'fungsional_status':
				$data['no_pa'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_prosedur'] = '';
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_gizi'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "";
				$data['tab_obat'] = '';
				$data['tab_racikan'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "active";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'tab_gizi':
				$data['no_pa'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_prosedur'] = '';
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "";
				$data['tab_gizi'] = "active";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "";
				$data['tab_obat'] = '';
				$data['tab_racikan'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'konsultasi':
				$data['no_pa'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_prosedur'] = '';
				$data['tab_jawaban_konsul'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_gizi'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "active";
				$data['tab_obat'] = '';
				$data['tab_racikan'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'gigi':
				$data['tab_tindakan'] = "";
				$data['tab_prosedur'] = "";

				$data['tab_fisik'] = "";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_konsul'] = "";
				$data['tab_lab'] = "";
				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata'] = "";

				$data['tab_gizi'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "active";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


			case 'assesment':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_assesment_keperawatan'] = "active";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_gizi'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "";

				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";



				break;

			case 'assesmentmedikperawat':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_gizi'] = "";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "active";

				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;
			case 'assesmentkeperawatanbidan':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_gizi'] = "";
				$data['tab_assesment_keperawatan_bidan'] = "active";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "";

				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;
			case 'assesmentkeperawatanMata':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_gizi'] = "";
				$data['tab_assesment_keperawatan_bidan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_assesment_keperawatan_mata'] = "active";
				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;


			case 'tindakan':
				$data['tab_prosedur'] = "";
				$data['tab_tindakan'] = "active";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_gizi'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_assesment_medik_perawat'] = "";

				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;
			case 'prosedur':
				$data['tab_prosedur'] = "active";
				$data['tab_tindakan'] = "";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "";
				$data['tab_pa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_gizi'] = "";
				$data['tab_jawaban_konsul'] = "";

				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_konsul'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'fis':
				$data['tab_tindakan'] = "";
				$data['tab_prosedur'] = "";

				$data['tab_assesment_keperawatan'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_gizi'] = "";
				$data['tab_fisik'] = "active";
				$data['tab_pa'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_lab'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_obat'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_konsul'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'diag':
				$data['tab_tindakan'] = "";
				$data['tab_prosedur'] = "";

				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_diagnosa'] = "active";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_fisik'] = "";
				$data['tab_gizi'] = "";
				$data['tab_pa'] = "";
				$data['tab_lab'] = "";
				$data['tab_resep'] = "";
				$data['tab_rad'] = "";
				$data['tab_konsul'] = "";
				$data['tab_em'] = "";
				$data['tab_obat'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'lab':
				$data['no_lab'] = $param3;
				$data['tab_prosedur'] = "";

				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_lab'] = "active";
				$data['tab_pa'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_konsul'] = "";
				$data['tab_gizi'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;



			case 'pa':
				$data['no_pa'] = $param3;
				$data['tab_prosedur'] = "";

				$data['tab_assesment_keperawatan'] = "";
				$data['tab_tindakan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_dokter'] = "active";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_pa'] = "";
				$data['tab_gizi'] = "";
				$data['tab_rad'] = "";
				$data['tab_konsul'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "";
				$data['tab_obat'] = '';
				$data['tab_racikan'] = "";
				$data['tab_gigi'] = "";
				$data['tab_transfer'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";


				break;

			case 'rad':
				$no_rad = $param3;
				if ($no_rad != '') {
					$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($no_register)->result();
					$data['no_rad'] = $no_rad;
				} else {
					if ($this->radmdaftar->get_data_pemeriksaan($no_register)->row()->no_rad != '') {
						$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($no_register)->result();
					} else {
						$data['data_rad_pasien'] = '';
					} //$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

				}
				$data['tab_tindakan'] = "";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_fisik'] = "";
				$data['tab_lab'] = "";
				$data['tab_gizi'] = "";
				$data['tab_prosedur'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_konsul'] = "";

				$data['tab_pa'] = "";
				$data['tab_rad'] = "active";
				$data['tab_em'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_resep'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_obat'] = 'active';
				$data['tab_racikan']  = '';
				$data['tab_gigi'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				break;

			case 'em':
				$no_em = $param3;
				if ($no_em != '') {
					$data['data_em_pasien'] = $this->emmdaftar->get_data_pemeriksaan($no_register)->result();
					$data['no_em'] = $no_em;
				} else {
					if ($this->emmdaftar->get_data_pemeriksaan($no_register)->row()->no_em != '') {
						$data['data_em_pasien'] = $this->emmdaftar->get_data_pemeriksaan($no_register)->result();
					} else {
						$data['data_em_pasien'] = '';
					} //$data['data_em_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

				}
				$data['tab_tindakan'] = "";
				$data['tab_assesment_keperawatan'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_fisik'] = "";
				$data['tab_lab'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_prosedur'] = "";
				$data['tab_gizi'] = "";
				$data['tab_jawaban_konsul'] = "";

				$data['tab_konsul'] = "";
				$data['tab_pa'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "active";
				$data['tab_resep'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_obat'] = 'active';
				$data['tab_racikan']  = '';
				$data['tab_gigi'] = "";
				$data['tab_fungsional_status'] = "";

				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";
				break;



			case 'resep':
				$no_resep = $param3;
				$data['tab_tindakan'] = "";
				$data['tab_prosedur'] = "";

				$data['tab_assesment_keperawatan'] = "";
				$data['tab_fisik'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_assesment_medik_perawat'] = "";
				$data['tab_lab'] = "";
				$data['tab_gizi'] = "";
				$data['tab_pa'] = "";
				$data['tab_konsul'] = "";
				$data['tab_jawaban_konsul'] = "";
				$data['tab_assesment_medik_dokter'] = "";
				$data['tab_rad'] = "";
				$data['tab_em'] = "";
				$data['tab_resep'] = "active";
				$data['tab_gigi'] = "";
				$data['tab_fungsional_status'] = "";
				$data['tab_rehab_medik'] = "";
				$data['tab_rehab_medik_anak'] = "";

				if ($no_resep != '') {

					$data['data_obat_pasien'] = $this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();
					$data['data_tindakan_racikan'] = $this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
					$data['no_resep'] = $no_resep;
				} else {
					if ($this->rjmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep != '') {
						$data['no_resep'] = $this->rjmpelayanan->getdata_resep_pasien($no_register)->result();
					} else {
						$data['data_obat_pasien'] = '';
					}
				}
				$data['tab_obat'] = "active";
				$data['tab_racikan'] = "";
				if ($param4 != '') {
					$data['tab_obat'] = "";
					$data['tab_racikan'] = "active";
				}
				break;
		}
		$data['penilaian_fungsional_status'] = $this->rjmpelayanan->check_penilaian_fungsional_status($no_register)->row();
		$data['tab'] = $tab;
		$data['assesment_keperawatan'] = $this->rjmpelayanan->check_assesment_keperawatan($no_register)->row();
		$data['statfisik'] = 'show';
		$data['staff'] = 'perawat';
		$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
		$data['get_suket'] = $this->rjmpelayanan->getdata_suket($no_register)->row();
		$this->load->view('irj/rjvpelayanan', $data);
	}

	public function geriatri_rawat_jalan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('geriatri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rjmpelayanan->get_geriatri_rj($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_geriatri_rj($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_register');
			$result = $this->rjmpelayanan->insert_geriatri_rj($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}



	//NOTE IGD - CATATAN MEDIS GAWAT DARURAT
	public function note_igd($no_register = '')
	{
		if ($no_register != '') {
			$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			$data['title'] = 'CATATAN MEDIS GAWAT DARURAT | ' . $data['data_pasien_daftar_ulang']->nama . ' | ' . $no_register;
			$data['id_poli'] = 'BA00';
			$data['no_register'] = $no_register;
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli_BA00()->result();
			$this->load->view('irj/rdvnote', $data);
		}
	}

	public function get_noteigd()
	{
		$no_register = $this->input->post('no_register');
		if ($no_register != '') {
			$data = $this->rjmpelayanan->getdata_noteigd($no_register)->result();
			echo json_encode($data);
		}
	}

	public function insert_noteigd()
	{

		$data['triage_nbm'] = $this->input->post('triage_non');
		$data['triage_bm'] = $this->input->post('triage_mass');
		if ($this->input->post('cara_dtg') != 'SENDIRI') {
			$data['cara_datang'] = $this->input->post('extra_diantar');
		} else {
			$data['cara_datang'] = $this->input->post('cara_dtg');
		}

		$data['jenis_anamnesa'] = $this->input->post('jns_anamnesa');
		$data['subjektif'] = $this->input->post('subjektif');

		if ($this->input->post('riwayat_alergi')) {
			$data['riwayat_alergi'] = $this->input->post('riwayat_alergi');
		} else {
			$data['riwayat_alergi'] = $this->input->post('riwayat_alergi');
		}

		$data['riwayat_terdahulu'] = $this->input->post('riwayat_terdahulu');
		$data['keadaan_umum'] = $this->input->post('keadaan_umum');
		$data['nilai_nyeri'] = $this->input->post('nilai_nyeri');
		$data['td'] = $this->input->post('td');
		$data['nadi'] = $this->input->post('nadi');
		$data['suhu'] = $this->input->post('suhu');
		$data['pernafasan'] = $this->input->post('pernafasan');
		$data['bb'] = $this->input->post('bb');
		$data['sato'] = $this->input->post('sato');
		$data['id_dokter'] = $this->input->post('id_dokter');
		$data['jam_dokter'] = $this->input->post('jam_dokter');

		$data['objektif'] = $this->input->post('objektif');
		$data['gcs_e'] = $this->input->post('gcs_e');
		$data['gcs_m'] = $this->input->post('gcs_m');
		$data['gcs_v'] = $this->input->post('gcs_v');
		$data['lab'] = $this->input->post('lab');
		$data['rad'] = $this->input->post('rad');
		$data['ekg_ecg'] = $this->input->post('ekg');
		$data['head'] = $this->input->post('head');
		$data['eyes'] = $this->input->post('eyes');
		$data['mouth'] = $this->input->post('mouth');
		$data['neck'] = $this->input->post('neck');
		$data['chest'] = $this->input->post('chest');
		$data['abdomen'] = $this->input->post('abdomen');
		$data['extremity'] = $this->input->post('extremity');
		$data['genetalia'] = $this->input->post('genetalia');
		$data['work_diag'] = $this->input->post('diag_kerja');
		$data['diff_diag'] = $this->input->post('diag_diff');
		$data['treat_therapy'] = $this->input->post('treat_therapy');
		$data['consultation'] = $this->input->post('consul');
		$data['cito'] = $this->input->post('cito');
		$data['follow_up'] = $this->input->post('follow_up');
		$data['discharge'] = $this->input->post('discharge');
		//$data['tgl_plg']=$this->input->post('id_poli');
		//$data['jam_plg']=$this->input->post('id_poli');

		$no_register = $this->input->post('no_register');
		$data_note = $this->rjmpelayanan->getdata_noteigd($no_register)->row();
		if (sizeof($data_note) == 0) {
			$data['no_register'] = $this->input->post('no_register');
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data['nama_perawat'] = $user;
			$data['jam_perawat'] = date('H:i');
			$id = $this->rjmpelayanan->insert_note_igd($data);
			//INSERT
		} else {
			$id = $this->rjmpelayanan->update_note_igd($no_register, $data);
			// UPDATE
		}
		echo json_encode($id);
	}

	public function insert_dietpasien()
	{
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['idpokdiet'] = $this->input->post('record_gizi');
		$data['rawat'] = $this->input->post('rawat');
		$data['xcreate'] = date('Y-m-d H:i:s');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;

		$result = $this->Mgizi->insert_dietpasien($data);
		echo json_encode($result);
	}

	public function get_json_form_assesment($no_reg = '')
	{
		return $this->rjmpelayanan->getJsonFormAssesment($no_reg);
	}

	public function cetak_fisik($no_register)
	{

		$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		return $this->load->view('CPPT_RJ', $data);
	}

	public function insert_medik_perawat($noreg)
	{
	}

	public function insert_assesment_keperawatan_rj($noreg)
	{
		$data = $this->input->post();
		// var_dump($data);die();
		$check_available_data = $this->rjmpelayanan->check_assesment_keperawatan($noreg);
		if ($check_available_data->num_rows()) {
			$this->rjmpelayanan->update_assesment_keperawatan($noreg, $data);
			echo json_encode(array('code' => 201));
		} else {
			$data['no_register'] = $noreg;
			$this->rjmpelayanan->insert_assesment_keperawatan($data);
			echo json_encode(array('code' => 200));
		}
		$assesment = isset($data['formjson']) ? json_decode($data['formjson']) : '';
		// var_dump($assesment);die();
		$value_medik = isset($assesment->nyeri_akut) ? $assesment->nyeri_akut[0] . ':' : '';
		$value_medik .= isset($assesment->chek_nyeri_akut) ? $assesment->chek_nyeri_akut . '-' : '';
		$value_medik .= isset($assesment->ketidakseimbangan_nutrisi) ? $assesment->ketidakseimbangan_nutrisi[0] . ':' : '';
		$value_medik .= isset($assesment->check_ketidakseimbangan_nutrisi) ? $assesment->check_ketidakseimbangan_nutrisi . '-' : '';
		$value_medik .= isset($assesment->pola_nafas_tidak_efektif) ? $assesment->pola_nafas_tidak_efektif[0] . ':' : '';
		$value_medik .= isset($assesment->check_pola_nafas_tidak_efektif) ? $assesment->check_pola_nafas_tidak_efektif . '-' : '';
		$value_medik .= isset($assesment->bersihkan_jalan_nafas) ? $assesment->bersihkan_jalan_nafas[0] . ':' : '';
		$value_medik .= isset($assesment->check_bersihkan_jalan_nafas) ? $assesment->check_bersihkan_jalan_nafas . '-' : '';
		$value_medik .= isset($assesment->hipertermia) ? $assesment->hipertermia[0] . ':' : '';
		$value_medik .= isset($assesment->check_hipertermia) ? $assesment->check_hipertermia . '-' : '';
		$value_medik .= isset($assesment->diare) ? $assesment->diare[0] . ':' : '';
		$value_medik .= isset($assesment->check_diare) ? $assesment->check_diare . '-' : '';
		$value_medik .= isset($assesment->resiko_infeksi_pembedahan) ? $assesment->resiko_infeksi_pembedahan[0] . ':' : '';
		$value_medik .= isset($assesment->check_resiko_infeksi_pembedahan) ? $assesment->check_resiko_infeksi_pembedahan . '-' : '';
		$value_medik .= isset($assesment->ansietas) ? $assesment->ansietas[0] . ':' : '';
		$value_medik .= isset($assesment->check_ansietas) ? $assesment->check_ansietas . '-' : '';
		$value_medik .= isset($assesment->gangguan_citra_tubuh) ? $assesment->gangguan_citra_tubuh[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_citra_tubuh) ? $assesment->check_gangguan_citra_tubuh . '-' : '';
		$value_medik .= isset($assesment->gangguan_menelan) ? $assesment->gangguan_menelan[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_menelan) ? $assesment->check_gangguan_menelan . '-' : '';
		$value_medik .= isset($assesment->penurunan_curah_jantung) ? $assesment->penurunan_curah_jantung[0] . ':' : '';
		$value_medik .= isset($assesment->check_penurunan_curah_jantung) ? $assesment->check_penurunan_curah_jantung . '-' : '';
		$value_medik .= isset($assesment->intoleran_aktifitas) ? $assesment->intoleran_aktifitas[0] . ':' : '';
		$value_medik .= isset($assesment->check_intoleran_aktifitas) ? $assesment->check_intoleran_aktifitas . '-' : '';
		$value_medik .= isset($assesment->gangguan_mobilitas_fisik) ? $assesment->gangguan_mobilitas_fisik[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_mobilitas_fisik) ? $assesment->check_gangguan_mobilitas_fisik . '-' : '';
		$value_medik .= isset($assesment->hambatan_komunikasi_verbal) ? $assesment->hambatan_komunikasi_verbal[0] . ':' : '';
		$value_medik .= isset($assesment->check_hambatan_komunikasi_verbal) ? $assesment->check_hambatan_komunikasi_verbal . '-' : '';
		$value_medik .= isset($assesment->diskontuinitas_jaringan) ? $assesment->diskontuinitas_jaringan[0] . ':' : '';
		$value_medik .= isset($assesment->check_diskontuinitas_jaringan) ? $assesment->check_diskontuinitas_jaringan . '-' : '';
		$value_medik .= isset($assesment->ketidakstabilan_gula_darah) ? $assesment->ketidakstabilan_gula_darah[0] . ':' : '';
		$value_medik .= isset($assesment->check_ketidakstabilan_gula_darah) ? $assesment->check_ketidakstabilan_gula_darah . '-' : '';
		$value_medik .= isset($assesment->check_lainnya) ? $assesment->check_lainnya . ':' : '';
		$value_medik .= isset($assesment->check_lainnya2) ? $assesment->check_lainnya2 . '-' : '';
		$value_medik .= isset($assesment->check_lainnya1) ? $assesment->check_lainnya1 . ':' : '';
		$value_medik .= isset($assesment->check_lainnya3) ? $assesment->check_lainnya3 . '-' : '';

		$check_available_data_soap = $this->rjmpelayanan->get_soap_pasien($noreg);
		$soap['plan_perawat'] = '';
		if (isset($assesment->kebutuhan_edukasi)) {
			foreach ($assesment->kebutuhan_edukasi as $value) {
				$soap['plan_perawat'] .= $value . '-';
			}
		}

		$soap['assesment_perawat'] = $value_medik;
		// var_dump($soap['assesment_perawat']);die();
		$soap['plan_perawat'] = $soap['plan_perawat'];
		$soap['tgl_input']	= date('Y-m-d H:i:s');


		if ($check_available_data_soap->num_rows()) {
			$this->rjmpelayanan->update_soap_pasien($soap, $noreg);
		} else {
			$soap['no_register'] = $noreg;
			$this->rjmpelayanan->insert_soap_pasien($soap);
		}
	}



	public function insert_assesment($no_reg = '', $iid_poli = '')
	{
		//var_dump($this->input->post());
		$id_poli = $iid_poli;
		$no_register = $no_reg;
		$data['alergi'] = $this->input->post('alergi');
		$data['riwayat_alergi'] = $this->input->post('riwayat_alergi');
		$data['reaksi_alergi'] = $this->input->post('reaksi_alergi');
		$data['nyeri'] = $this->input->post('nyeri');
		$data['kualitas_nyeri'] = $this->input->post('kualitas_nyeri');
		$data['skala_nyeri'] = $this->input->post('skala_nyeri');
		$data['metode_nyeri'] = $this->input->post('metode_nyeri');
		$data['frekuensi_nyeri'] = $this->input->post('frekuensi_nyeri');
		$data['durasi_nyeri'] = $this->input->post('durasi_nyeri');

		$cek_menjalar = $this->input->post('menjalar');
		if ($cek_menjalar != "iya") {
			$data['menjalar'] = $this->input->post('menjalar');
		} else {
			$data['menjalar'] = $this->input->post('value_menjalar');
		}



		$data['lokasi_nyeri'] = $this->input->post('lokasi_nyeri');
		$data['fk_minum_obat'] = $this->input->post('fk_minum_obat');
		$data['fk_istirahat'] = $this->input->post('fk_istirahat');
		$data['fk_musik'] = $this->input->post('fk_musik');
		$data['fk_posisi_tidur'] = $this->input->post('fk_posisi_tidur');
		$data['gizi_asupan_makan'] = $this->input->post('gizi_asupan_makan');
		$data['penilaian_gizi'] = $this->input->post('penilaian_gizi');
		$data['stat_sosial_keluarga'] = $this->input->post('stat_sosial_keluarga');
		$data['stat_psikologis'] = $this->input->post('stat_psikologis');
		$data['stat_pernikahan_ekonomi'] = $this->input->post('stat_pernikahan_ekonomi');
		$data['skrining_risiko_cedera'] = $this->input->post('skrining_risiko_cedera');
		$data['fungsional_alat_bantu'] = $this->input->post('fungsional_alat_bantu');
		$data['alat_bantu'] = $this->input->post('alat_bantu');

		$cek_gizi_penurunan_bb = $this->input->post('gizi_penurunan_bb');
		if ($cek_gizi_penurunan_bb == "ya") {
			$data['gizi_penurunan_bb'] = $this->input->post('value_gizi_penurunan_bb');
		} else {
			$data['gizi_penurunan_bb'] = $this->input->post('gizi_penurunan_bb');
		}


		$fungsional_cacat_tubuh_ada = $this->input->post('fungsional_cacat_tubuh');
		if ($fungsional_cacat_tubuh_ada == "ada") {
			$data['fungsional_cacat_tubuh'] = $this->input->post('value_cacat_tubuh');
		} else {
			$data['fungsional_cacat_tubuh'] = $this->input->post('fungsional_cacat_tubuh');
		}

		$data['kes_keluarga_pas_edukasi'] = $this->input->post('kes_keluarga_pas_edukasi');
		$data['hambatan_edukasi'] = $this->input->post('hambatan_edukasi');
		$data['membutuhkan_penerjemah_edukasi'] = $this->input->post('membutuhkan_penerjemah_edukasi');
		$data['pengetahuan_edukasi'] = $this->input->post('pengetahuan_edukasi');
		$data['perawatan_penyakit'] = $this->input->post('perawatan_penyakit');
		$data['cara_minum_obat'] = $this->input->post('cara_minum_obat');
		$data['diet'] = $this->input->post('diet');


		$dataasesment['nyeri_akut'] = $this->input->post('nyeri_akut');
		$dataasesment['ketidakseimbangan_nutrisi'] = $this->input->post('ketidakseimbangan_nutrisi');
		$dataasesment['pola_nafas_tidak_efektif'] = $this->input->post('pola_nafas_tidak_efektif');
		$dataasesment['bersihkan_jalan_nafas'] = $this->input->post('bersihkan_jalan_nafas');
		$dataasesment['hipertermia'] = $this->input->post('hipertermia');
		$dataasesment['diare'] = $this->input->post('diare');
		$dataasesment['resiko_infeksi_pembedahan'] = $this->input->post('resiko_infeksi_pembedahan');
		$dataasesment['ansietas'] = $this->input->post('ansietas');
		$dataasesment['gangguan_citra_tubuh'] = $this->input->post('gangguan_citra_tubuh');
		$dataasesment['gangguan_menelan'] = $this->input->post('gangguan_menelan');
		$dataasesment['penurunan_curah_jantung'] = $this->input->post('penurunan_curah_jantung');
		$dataasesment['intoleransi_aktifitas'] = $this->input->post('intoleran_aktifitas');
		$dataasesment['gangguan_mobilitas_fisik'] = $this->input->post('gangguan_mobilitas_fisik');
		$dataasesment['hambatan_komunikasi_verbal'] = $this->input->post('hambatan_komunikasi_verbal');
		$dataasesment['diskontuinitas_jaringan'] = $this->input->post('diskontuinitas_jaringan');
		$dataasesment['ketidakstabilan_gula_darah'] = $this->input->post('ketidakstabilan_gula_darah');
		$dataasesment['lainnya'] = $this->input->post('lainnya');
		$id_keperawatan = $this->input->post('id_keperawatan[]');
		$dataasesment['no_register'] = $no_register;

		// added kekuatan otot ->aldi

		$data['tangan_kiri_otot'] = $this->input->post('tangan_kiri_otot');
		$data['tangan_kanan_otot'] = $this->input->post('tangan_kanan_otot');
		$data['kaki_kiri_otot'] = $this->input->post('kaki_kiri_otot');
		$data['kaki_kanan_otot'] = $this->input->post('kaki_kanan_otot');


		$data_assesment = $this->rjmpelayanan->getdata_assesment($no_register)->row();
		$data_fisik = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik == NULL) {
			$data['no_register'] = $no_register;
			$this->rjmpelayanan->insert_data_fisik($data);
		} else {
			$this->rjmpelayanan->update_data_fisik($no_register, $data);
		}
		if ($data_assesment == NULL) {
			$data['no_register'] = $no_register;
			$this->rjmpelayanan->insert_assesment($dataasesment);
		} else {
			$this->rjmpelayanan->update_assesment($no_register, $dataasesment);
		}

		$data_fisik = $data['formjson'];

		$assesment = isset($data_fisik) ? json_decode($data_fisik) : '';

		$value_medik = isset($assesment->nyeri_akut) ? $assesment->nyeri_akut[0] . ':' : '';
		$value_medik .= isset($assesment->check_nyeri_akut) ? $assesment->check_nyeri_akut . '\n' : '';
		$value_medik .= isset($assesment->ketidakseimbangan_nutrisi) ? $assesment->ketidakseimbangan_nutrisi[0] . ':' : '';
		$value_medik .= isset($assesment->check_ketidakseimbangan_nutrisi) ? $assesment->check_ketidakseimbangan_nutrisi . '\n' : '';
		$value_medik .= isset($assesment->pola_nafas_tidak_efektif) ? $assesment->pola_nafas_tidak_efektif[0] . ':' : '';
		$value_medik .= isset($assesment->check_pola_nafas_tidak_efektif) ? $assesment->check_pola_nafas_tidak_efektif . '\n' : '';
		$value_medik .= isset($assesment->bersihkan_jalan_nafas) ? $assesment->bersihkan_jalan_nafas[0] . ':' : '';
		$value_medik .= isset($assesment->check_bersihkan_jalan_nafas) ? $assesment->check_bersihkan_jalan_nafas . '\n' : '';
		$value_medik .= isset($assesment->hipertermia) ? $assesment->hipertermia[0] . ':' : '';
		$value_medik .= isset($assesment->check_hipertermia) ? $assesment->check_hipertermia . '\n' : '';
		$value_medik .= isset($assesment->diare) ? $assesment->diare[0] . ':' : '';
		$value_medik .= isset($assesment->check_diare) ? $assesment->check_diare . '\n' : '';
		$value_medik .= isset($assesment->resiko_infeksi_pembedahan) ? $assesment->resiko_infeksi_pembedahan[0] . ':' : '';
		$value_medik .= isset($assesment->check_resiko_infeksi_pembedahan) ? $assesment->check_resiko_infeksi_pembedahan . '\n' : '';
		$value_medik .= isset($assesment->ansietas) ? $assesment->ansietas[0] . ':' : '';
		$value_medik .= isset($assesment->check_ansietas) ? $assesment->check_ansietas . '\n' : '';
		$value_medik .= isset($assesment->gangguan_citra_tubuh) ? $assesment->gangguan_citra_tubuh[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_citra_tubuh) ? $assesment->check_gangguan_citra_tubuh . '\n' : '';
		$value_medik .= isset($assesment->gangguan_menelan) ? $assesment->gangguan_menelan[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_menelan) ? $assesment->check_gangguan_menelan . '\n' : '';
		$value_medik .= isset($assesment->penurunan_curah_jantung) ? $assesment->penurunan_curah_jantung[0] . ':' : '';
		$value_medik .= isset($assesment->check_penurunan_curah_jantung) ? $assesment->check_penurunan_curah_jantung . '\n' : '';
		$value_medik .= isset($assesment->intoleran_aktifitas) ? $assesment->intoleran_aktifitas[0] . ':' : '';
		$value_medik .= isset($assesment->check_intoleran_aktifitas) ? $assesment->check_intoleran_aktifitas . '\n' : '';
		$value_medik .= isset($assesment->gangguan_mobilitas_fisik) ? $assesment->gangguan_mobilitas_fisik[0] . ':' : '';
		$value_medik .= isset($assesment->check_gangguan_mobilitas_fisik) ? $assesment->check_gangguan_mobilitas_fisik . '\n' : '';
		$value_medik .= isset($assesment->hambatan_komunikasi_verbal) ? $assesment->hambatan_komunikasi_verbal[0] . ':' : '';
		$value_medik .= isset($assesment->check_hambatan_komunikasi_verbal) ? $assesment->check_hambatan_komunikasi_verbal . '\n' : '';
		$value_medik .= isset($assesment->diskontuinitas_jaringan) ? $assesment->diskontuinitas_jaringan[0] . ':' : '';
		$value_medik .= isset($assesment->check_diskontuinitas_jaringan) ? $assesment->check_diskontuinitas_jaringan . '\n' : '';
		$value_medik .= isset($assesment->ketidakstabilan_gula_darah) ? $assesment->ketidakstabilan_gula_darah[0] . ':' : '';
		$value_medik .= isset($assesment->check_ketidakstabilan_gula_darah) ? $assesment->check_ketidakstabilan_gula_darah . '\n' : '';
		$value_medik .= isset($assesment->lainnya) ? $assesment->lainnya[0] : '';
		$value_medik .= isset($assesment->check_lainnya) ? $assesment->check_lainnya . '\n' : '';

		$check_available_data_soap = $this->rjmpelayanan->get_soap_pasien($no_register);
		$soap['plan_perawat'] = '';
		if (isset($assesment->kebutuhan_edukasi)) {
			foreach ($assesment->kebutuhan_edukasi as $value) {
				$soap['plan_perawat'] .= $value . '\n';
			}
		}

		$soap['assesment_perawat'] = $value_medik;
		$soap['plan_perawat'] = $soap['plan_perawat'];
		$soap['tgl_input']	= date('Y-m-d H:i:s');
		$login_data = $this->load->get_var("user_info");
		$soap['nm_pemeriksa'] = $login_data->name;
		$soap['ttd_pemeriksa'] = $login_data->ttd;


		if ($check_available_data_soap->num_rows()) {
			$this->rjmpelayanan->update_soap_pasien($soap, $no_register);
		} else {
			$soap['no_register'] = $no_register;
			$this->rjmpelayanan->insert_soap_pasien($soap);
		}

		$res = array('code' => 'sukses');
		echo json_encode($res);
	}

	//added putri 03-09-2024
	public function insert_kep_obgyn()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data['formjson'] = $this->input->post('keperawatan_obgyn_json');
		$data_note = $this->rjmpelayanan->get_kep_obgyn($no_reg);
		if ($data_note->num_rows()) {
			$result = $this->rjmpelayanan->update_kep_obgyn($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['id_pemeriksa2'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_kep_obgyn($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_masalah_keperawatan()
	{
		$value = $this->input->post();
		// var_dumP($value['masalahkeperawatansoap']);die();
		$value['masalah_keperawatan_json'] = $this->input->post('masalahkeperawatansoap') ?? "";
		$data_fisik = $this->rjmpelayanan->getdata_tindakan_fisik($this->input->post('no_register'))->row();
		if ($data_fisik == FALSE) {
			unset($value['masalahkeperawatansoap']);
			$value['tanggal_pemeriksaan'] = date("Y-m-d H:i:s");
			$value['id_perawat'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_data_fisik($value);
			$response = ($result ? json_encode(array("message" => 'success insert fisik')) : json_encode(array("message" => 'error insert fisik')));
			unset($value['masalah_keperawatan_json']);
		} else {
			unset($value['masalahkeperawatansoap']);
			$result = $this->rjmpelayanan->update_data_fisik($this->input->post('no_register'), $value);
			$response = ($result ? json_encode(array("message" => 'success update fisik')) : json_encode(array("message" => 'error update fisik')));

			unset($value['masalah_keperawatan_json']);
		}

		$value = $this->input->post();
		if (isset($value['masalahkeperawatansoap'])) {


			$assesment = isset($value['masalahkeperawatansoap']) ? json_decode($value['masalahkeperawatansoap']) : '';
			$value_medik = isset($assesment->nyeri_akut) ? $assesment->nyeri_akut[0] . ':' : '';
			$value_medik .= isset($assesment->chek_nyeri_akut) ? $assesment->chek_nyeri_akut . '-' : '';
			$value_medik .= isset($assesment->ketidakseimbangan_nutrisi) ? $assesment->ketidakseimbangan_nutrisi[0] . ':' : '';
			$value_medik .= isset($assesment->check_ketidakseimbangan_nutrisi) ? $assesment->check_ketidakseimbangan_nutrisi . '-' : '';
			$value_medik .= isset($assesment->pola_nafas_tidak_efektif) ? $assesment->pola_nafas_tidak_efektif[0] . ':' : '';
			$value_medik .= isset($assesment->check_pola_nafas_tidak_efektif) ? $assesment->check_pola_nafas_tidak_efektif . '-' : '';
			$value_medik .= isset($assesment->bersihkan_jalan_nafas) ? $assesment->bersihkan_jalan_nafas[0] . ':' : '';
			$value_medik .= isset($assesment->check_bersihkan_jalan_nafas) ? $assesment->check_bersihkan_jalan_nafas . '-' : '';
			$value_medik .= isset($assesment->hipertermia) ? $assesment->hipertermia[0] . ':' : '';
			$value_medik .= isset($assesment->check_hipertermia) ? $assesment->check_hipertermia . '-' : '';
			$value_medik .= isset($assesment->diare) ? $assesment->diare[0] . ':' : '';
			$value_medik .= isset($assesment->check_diare) ? $assesment->check_diare . '-' : '';
			$value_medik .= isset($assesment->resiko_infeksi_pembedahan) ? $assesment->resiko_infeksi_pembedahan[0] . ':' : '';
			$value_medik .= isset($assesment->check_resiko_infeksi_pembedahan) ? $assesment->check_resiko_infeksi_pembedahan . '-' : '';
			$value_medik .= isset($assesment->ansietas) ? $assesment->ansietas[0] . ':' : '';
			$value_medik .= isset($assesment->check_ansietas) ? $assesment->check_ansietas . '-' : '';
			$value_medik .= isset($assesment->gangguan_citra_tubuh) ? $assesment->gangguan_citra_tubuh[0] . ':' : '';
			$value_medik .= isset($assesment->check_gangguan_citra_tubuh) ? $assesment->check_gangguan_citra_tubuh . '-' : '';
			$value_medik .= isset($assesment->gangguan_menelan) ? $assesment->gangguan_menelan[0] . ':' : '';
			$value_medik .= isset($assesment->check_gangguan_menelan) ? $assesment->check_gangguan_menelan . '-' : '';
			$value_medik .= isset($assesment->penurunan_curah_jantung) ? $assesment->penurunan_curah_jantung[0] . ':' : '';
			$value_medik .= isset($assesment->check_penurunan_curah_jantung) ? $assesment->check_penurunan_curah_jantung . '-' : '';
			$value_medik .= isset($assesment->intoleran_aktifitas) ? $assesment->intoleran_aktifitas[0] . ':' : '';
			$value_medik .= isset($assesment->check_intoleran_aktifitas) ? $assesment->check_intoleran_aktifitas . '-' : '';
			$value_medik .= isset($assesment->gangguan_mobilitas_fisik) ? $assesment->gangguan_mobilitas_fisik[0] . ':' : '';
			$value_medik .= isset($assesment->check_gangguan_mobilitas_fisik) ? $assesment->check_gangguan_mobilitas_fisik . '-' : '';
			$value_medik .= isset($assesment->hambatan_komunikasi_verbal) ? $assesment->hambatan_komunikasi_verbal[0] . ':' : '';
			$value_medik .= isset($assesment->check_hambatan_komunikasi_verbal) ? $assesment->check_hambatan_komunikasi_verbal . '-' : '';
			$value_medik .= isset($assesment->diskontuinitas_jaringan) ? $assesment->diskontuinitas_jaringan[0] . ':' : '';
			$value_medik .= isset($assesment->check_diskontuinitas_jaringan) ? $assesment->check_diskontuinitas_jaringan . '-' : '';
			$value_medik .= isset($assesment->ketidakstabilan_gula_darah) ? $assesment->ketidakstabilan_gula_darah[0] . ':' : '';
			$value_medik .= isset($assesment->check_ketidakstabilan_gula_darah) ? $assesment->check_ketidakstabilan_gula_darah . '-' : '';
			$value_medik .= isset($assesment->check_lainnya) ? $assesment->check_lainnya . ':' : '';
			$value_medik .= isset($assesment->check_lainnya2) ? $assesment->check_lainnya2 . '-' : '';
			$value_medik .= isset($assesment->check_lainnya1) ? $assesment->check_lainnya1 . ':' : '';
			$value_medik .= isset($assesment->check_lainnya3) ? $assesment->check_lainnya3 . '-' : '';
			unset($value['masalahkeperawatansoap']);

			$check_available_data_soap = $this->rjmpelayanan->get_soap_pasien($this->input->post('no_register'));
			$soap['plan_perawat'] = '';
			if (isset($assesment->kebutuhan_edukasi)) {
				foreach ($assesment->kebutuhan_edukasi as $value) {
					$soap['plan_perawat'] .= $value . '-';
				}
			}
			$soap['assesment_perawat'] = $value_medik;
			$login_data = $this->load->get_var("user_info");


			if ($check_available_data_soap->num_rows()) {
				$this->rjmpelayanan->update_soap_pasien($soap, $this->input->post('no_register'));
			} else {

				$soap['id_pemeriksa'] = $login_data->userid;
				$soap['tgl_input']	= date('Y-m-d H:i:s');
				$soap['no_register'] = $this->input->post('no_register');
				$this->rjmpelayanan->insert_soap_pasien($soap);
			}
		}



		echo $response;
	}

	public function insert_fisik($staff)
	{
		$value = $this->input->post();
		//  var_dump($value);die();
		$value['no_register'] = $this->input->post('no_register');
		$login_data = $this->load->get_var("user_info");
		// var_dump($this->input->post('keluhan'));die();
		// $keluhan = $this->input->post('keluhan');
		// var_dump($value['keluhan']);die();
		if (isset($value['keluhan'])) {
			$value['catatan'] = $value['keluhan'];
			unset($value['keluhan']);
		}
		$data_fisik = $this->rjmpelayanan->getdata_tindakan_fisik($value['no_register'])->row();
		if ($data_fisik == FALSE) {
			$value['tanggal_pemeriksaan'] = date("Y-m-d H:i:s");
			$value['id_perawat'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_data_fisik($value);
			$response = ($result ? json_encode(array("message" => 'success insert fisik')) : json_encode(array("message" => 'error insert fisik')));
		} else {
			$value['id_perawat'] = $login_data->userid;
			$result = $this->rjmpelayanan->update_data_fisik($value['no_register'], $value);
			// var_dump($value['no_register']); die();
			$response = ($result ? json_encode(array("message" => 'success update fisik')) : json_encode(array("message" => 'error update fisik')));
		}

		$id_poli = $this->rjmpelayanan->get_id_poli_by_noreg($value['no_register'])->row();
		$data['userid'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data['subjective_perawat'] = trim($value['catatan']);
		$data['assesment_perawat'] = trim($value['assesment_perawat']);
		$data['plan_perawat'] = trim($value['plan_perawat']);

		if ($id_poli->id_poli == 'BB00') {
			$data['objective_perawat'] = 'Tekanan Darah:' . $value['sitolic'] . '/' . $value['diatolic'] . ' ' . 'mmHg' . '-Berat Badan:' . $value['bb'] . ' ' . 'kg' .
				'-Nadi:' . $value['nadi'] . ' ' . 'x/menit' . '-Frekuensi Nafas:' . $value['frekuensi_nafas'] . ' ' . 'x/menit' .
				'-Suhu:' . $value['suhu'] . ' ' . '°C' . '-Status Lokalis:' . $value['lingkar_kepala'] . ' ' . 'cm' . '-VAS:' . $value['nyeri'] . ' ' ;
		} else {
			$data['objective_perawat'] = 'Tekanan Darah:' . $value['sitolic'] . '/' . $value['diatolic'] . ' ' . 'mmHg' . '-Berat Badan:' . $value['bb'] . ' ' . 'kg' .
				'-Nadi:' . $value['nadi'] . ' ' . 'x/menit' . '-Frekuensi Nafas:' . $value['frekuensi_nafas'] . ' ' . 'x/menit' .
				'-Suhu:' . $value['suhu'] . ' ' . '°C' . '-Lingkar Kepala:' . $value['lingkar_kepala'] . ' ' . 'cm' . '-VAS:' . $value['nyeri'] . ' '  ;
		}

		// var_dump($data['subjective_perawat']);die();

		$check_available_data = $this->rjmpelayanan->get_soap_pasien($value['no_register']);
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rjmpelayanan->update_soap_pasien($data, $value['no_register']);
			$response .= ($submitdata ? json_encode(array("message" => 'success update soap')) : json_encode(array("message" => 'error update soap')));
		} else {
			$data['no_register'] = $value['no_register'];

			$submitdata = $this->rjmpelayanan->insert_soap_pasien($data);
			$response .= ($submitdata ? json_encode(array("message" => 'success insert soap')) : json_encode(array("message" => 'error insert soap')));
		}

		echo $response;
	}

	public function insert_tindakan()
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$userid = $login_data->userid;
		$pelaksana = explode("-", $this->input->post('pelaksana'));
		if($this->input->post('asis_pelaksana')){
			$asis_pelaksana = explode("-", $this->input->post('asis_pelaksana'));
			$data['asisten_userid'] = isset($asis_pelaksana[0])?$asis_pelaksana[0]:0;
			$data['asisten_nmuser'] = isset($asis_pelaksana[1])?$asis_pelaksana[1]:'';
		}
		$data['userid'] = $pelaksana[0];
		$data['nm_user'] = $pelaksana[1];
		
		$data['xuser'] = $user;
		$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
		$data['xupdate'] = date("Y-m-d H:i:s");
		$data['id_poli'] = $this->input->post('id_poli');
		$data['no_register'] = $this->input->post('no_register');
		$no_register = $this->input->post('no_register');
		$tindakan = explode("@", $this->input->post('idtindakan'));
		$data['idtindakan'] = $tindakan[0];
		$data['nmtindakan'] = $tindakan[1];
		$data['jam_tindakan'] = date("H:i:s");
		$get_ttd_dokter = $this->rjmpelayanan->ttd_pemeriksa($userid)->row();
		$data['ttd_dokter'] = '';
		$data['bpjs'] = $this->input->post('cover_bpjs');
		$data['biaya_tindakan'] = $this->input->post('biaya_tindakan_hide');
		$biaya_alkes = $this->input->post('biaya_alkes_hide');
		if ($biaya_alkes != null || $biaya_alkes = '') {
			$data['biaya_alkes'] = $biaya_alkes;
		} else {
			$data['biaya_alkes'] = 0;
		}
		$data['qtyind'] = $this->input->post('qtyind');
		$data['vtot'] = $this->input->post('vtot_hide');
		$data['tmno'] = $this->input->post('kualifikasi_tind');
		$id = $this->rjmpelayanan->insert_tindakan($data);
	

		//penambahan vtot di daftar_ulang_irj
		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data['no_register'])->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$data['vtot'];
		$id = $this->rjmpelayanan->update_vtot($data_vtot, $data['no_register']);

		echo json_encode($id);
	}
	public function hapus_tindakan($id_poli = '', $id_pelayanan_poli = '', $no_register = '')
	{
		//pengurangan vtot di daftar_ulang_irj
		//$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($no_register)->row()->vtot;
		//get vtot_tindakan_sebelumnya
		//$vtot_tindakan_sebelumnya=$this->rjmpelayanan->get_vtot_tindakan_sebelumnya($id_pelayanan_poli)->row()->vtot;
		//$data_vtot['vtot'] = (int)$vtot_sebelumnya-(int)$vtot_tindakan_sebelumnya;

		//$this->rjmpelayanan->update_vtot($data_vtot,$no_register);
		$id = $this->rjmpelayanan->hapus_tindakan($id_pelayanan_poli);

		$success = 	'<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				<h3><i class="fa fa-check-circle"></i> Data Berhasil Dihapus.</h3>
			</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('irj/rjcpelayananfdokter/form/tindakan/' . $id_poli . '/' . $no_register);
		// redirect('refresh');
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////create update data pelayanan poli

	// public function insert_diagnosa()
	// {
	// 	date_default_timezone_set("Asia/Jakarta");
	// 	$login_data = $this->load->get_var("user_info");
	// 	$user = $login_data->username;
	// 	$data['xuser']=$user;
	// 	$data['xupdate']=date("Y-m-d H:i:s");

	// 	$data['no_register']=$this->input->post('no_register');
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['id_poli']=$id_poli;
	// 	$data['klasifikasi_diagnos']=$this->input->post('klasifikasi_diagnos');

	// 	if ($data['klasifikasi_diagnos']=="utama")
	// 	{
	// 		//cek diagnosa utama
	// 		$cek_diagnosa_utama=$this->rjmpelayanan->cek_diagnosa_utama($data['no_register'])->row();
	// 		$jumlah_diag_utama=$cek_diagnosa_utama->jumlah;
	// 		echo  $jumlah_diag_utama;
	// 		if ($jumlah_diag_utama==1)
	// 		{
	// 			$tab="diag";
	// 			$success = 	'
	// 					<div class="content-header">
	// 						<div class="box box-default">
	// 							<div class="alert alert-danger alert-dismissable">
	// 								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	// 								<h4>
	// 								<i class="icon fa fa-check"></i>
	// 								Diagnosa utama untuk no register "'.$data['no_register'].'" sudah terdaftar.
	// 								</h4>
	// 							</div>
	// 						</div>
	// 					</div>';
	// 			$this->session->set_flashdata('success_msg', $success);
	// 			redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		} else {
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];
	// 		$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$diag_utama=$this->rjmpelayanan->get_diag_pasien($data['no_register']);

	// 		$i=0;
	// 		$diag3=$diag_utama->result();
	// 		foreach($diag3 as $row){
	// 			echo "hahaha";
	// 			$diag[$i]=$row->id_diagnosa;
	// 			++$i;
	// 		}

	// 		if($diag[0]!=''){
	// 			$add_diag['diag_baru']=$diag[0];
	// 		}
	// 		if($diag[1]!=''){
	// 			$add_diag['diag_lama']=$diag[1];
	// 		}
	// 		//print_r($diag);
	// 		$diag_utama=$this->rjmpelayanan->update_diag_daful($add_diag,$data['no_register']);

	// 		//$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 		}
	// 	}
	// 	else //jika klasifikasi diagnosa==tambahan
	// 	{
	// 		$diagnosa = explode("@", $this->input->post('diagnosa'));
	// 		$data['id_diagnosa']=$diagnosa[0];
	// 		$data['diagnosa']=$diagnosa[1];

	// 		$id=$this->rjmpelayanan->insert_diagnosa($data);
	// 		$tab="diag";
	// 		redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab);
	// 	}
	// }
	// public function hapus_diagnosa($id_poli='',$id_diagnosa_pasien='', $no_register='')
	// {
	// 	$id=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	// 	$tab="diag";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// }
	public function cek_diag()
	{
		$cek_utama = $this->rjmpelayanan->cek_diagnosa_utama($this->input->post('no_register'))->row();
		if ((int)$cek_utama->jumlah > 0) {
			echo '1';
		} else {
			echo '2';
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////pulang / selesai pelayanan poli
	public function update_pulang()
	{
		date_default_timezone_set('Asia/Jakarta');
		if ($this->input->post('cetak_prmrj') != null) {
			$data['cetak_prmrj'] = 1;
		} else {
			$data['cetak_prmrj'] = 0;
		}


		$id_poli = $this->input->post('id_poli');
		$no_register = $this->input->post('no_register');
		$data_pasien_daftar_ulang = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		// var_dump($data_pasien_daftar_ulang);die();
		// $data['id_dokter'] = $data_pasien_daftar_ulang->id_dokter;
		$data['dokter_kontrol_id'] = $this->input->post('dokter_kontrol_id');
		$data['id_poli_rujuk'] = $this->input->post('id_poli_rujuk');
		$cara_bayar = $data_pasien_daftar_ulang->cara_bayar;
		$no_sep = $data_pasien_daftar_ulang->no_sep;
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$data['tgl_pulang'] = date("Y-m-d");
		$data['ket_pulang'] = $this->input->post('ket_pulang');
		$data['status'] = 1;
		$data['waktu_pulang'] = date('Y-m-d H:i:s');


		if ($this->input->post('note_pulang') != '') {
			$data['catatan_plg'] = $this->input->post('note_pulang');
		}

		// validation for tgl_kontrol
		if ($this->input->post('tgl_kontrol') != null) {
			$dateObject = DateTime::createFromFormat('m/d/Y', $this->input->post('tgl_kontrol'));
			$formattedDate = $dateObject->format('Y-m-d');
			$data['tgl_kontrol'] = $formattedDate;
			// $data['tgl_kontrol'] = $this->input->post('tgl_kontrol');
		}

		//validation for jam_kontrol_ulang
		if ($this->input->post('jam_kontrol_ulang') != null) {
			$data['jam_kontrol_ulang'] = $this->input->post('jam_kontrol_ulang');
		} else {
			$data['jam_kontrol_ulang'] = '';
		}


		$data['tindak_lanjut'] = $this->input->post('tindak_lanjut');
		$data['alasan_kontrol_ulang'] = $this->input->post('alasan_fasilitas');

		$id = $this->rjmpelayanan->update_pulang($data, $no_register);
		// var_dump($data['ket_pulang']);die();
		switch ($data['ket_pulang']) {
			case "JAWABAN_KONSUL":
				$datenow = '';
				$data_sblm = $this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
				foreach ($data_sblm as $row) {

					$data2['no_medrec'] = $row->no_medrec;
					$datenow = date('Y-m-d H:i:s');
					$data2['tgl_kunjungan'] = $datenow;
					$data2['jns_kunj'] = $row->jns_kunj;
					$data2['umurrj'] = $row->umurrj;
					$data2['uharirj'] = $row->uharirj;
					$data2['ublnrj'] = $row->ublnrj;
					$data2['asal_rujukan'] = $row->asal_rujukan;
					$data2['no_rujukan'] = $row->no_rujukan;
					$data2['kelas_pasien'] = $row->kelas_pasien;
					$data2['cara_bayar'] = $row->cara_bayar;
					$data2['id_kontraktor'] = $row->id_kontraktor;
					$data2['nama_penjamin'] = $row->nama_penjamin;
					$data2['hubungan'] = $row->hubungan;
					$data2['vtot'] = $row->vtot;
					$data2['no_sep'] = $row->no_sep;
				}
				$data2['no_register_lama'] = $no_register;
				$data2['cara_kunj'] = "RUJUKAN POLI";
				$data2['xcreate'] = $login_data->username;
				$data2['vtot'] = 0;
				$data2['biayadaftar'] = 0;
				// $id=$this->rjmregistrasi->insert_daftar_ulang($data2);
				$data4['timein'] = date('Y-m-d H:i:s');
				$data4['status'] = 2;
				$id1 = $this->rjmtracer->update_mappasien($no_register, $data4);
				$noreg = $this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;

				$data2['no_register'] = $noreg;


				// Insert To Table konsul_dokter
				$data_jawaban_konsul['no_register'] = $no_register;
				$data_jawaban_konsul['nama_pasien'] = $this->input->post('nama_pasien');
				$data_jawaban_konsul['no_register_lama'] = $this->input->post('no_register_lama');
				$data_jawaban_konsul['diagnosa_akhir'] = $this->input->post('diagnosa_akhir');
				$data_jawaban_konsul['kesan'] = $this->input->post('kesan');
				$data_jawaban_konsul['anjuran'] = $this->input->post('anjuran');
				$data_jawaban_konsul['tanggal_periksa'] = date('Y-m-d');
				$data_jawaban_konsul['jam_periksa'] = date('H:i:s');
				$data_jawaban_konsul['id_dokter'] = $this->input->post('id_dokter');
				$data_jawaban_konsul['nama_dokter'] = $this->input->post('nama_dokter');


				$this->rjmpelayanan->insert_jawaban_konsul($data_jawaban_konsul);

				// End Insert

				echo '<script type="text/javascript">window.open("' . site_url("irj/rjcregistrasi/cetak_tracer/$noreg") . '", "_blank");window.focus()</script>';

				$success = 	'<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Pasien berhasil dirujuk rawat jalan.
										</h4>
									</div>
								</div>
							</div>';

				// $this->insert_tindakan3($data2);
				$this->session->set_flashdata('success_msg', $success);

				// redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');

				redirect('irj/rjcpelayanan/surat_jawaban_konsul/' . $no_register, 'refresh');
				break;
			case "DIRUJUK_RAWATJALAN":
				$data2['id_poli'] = $this->input->post('id_poli_rujuk');
				$data2['id_dokter'] = $this->input->post('dokter_kontrol_id');
				$datenow = '';
				$data_sblm = $this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
				foreach ($data_sblm as $row) {

					$data2['no_medrec'] = $row->no_medrec;
					$datenow = date('Y-m-d H:i:s');
					$data2['tgl_kunjungan'] = $datenow;
					$data2['jns_kunj'] = $row->jns_kunj;
					$data2['umurrj'] = $row->umurrj;
					$data2['uharirj'] = $row->uharirj;
					$data2['ublnrj'] = $row->ublnrj;
					$data2['asal_rujukan'] = $row->asal_rujukan;
					$data2['no_rujukan'] = $row->no_rujukan;
					$data2['kelas_pasien'] = $row->kelas_pasien;
					$data2['cara_bayar'] = $row->cara_bayar;
					$data2['id_kontraktor'] = $row->id_kontraktor;
					$data2['nama_penjamin'] = $row->nama_penjamin;
					$data2['hubungan'] = $row->hubungan;
					$data2['vtot'] = $row->vtot;
					$data2['no_sep'] = $row->no_sep;
				}
				$data2['no_register_lama'] = $no_register;
				$data2['cara_kunj'] = "RUJUKAN POLI";
				$data2['xcreate'] = $login_data->username;
				$data2['vtot'] = 0;
				$data2['biayadaftar'] = 0;
				// $id = $this->rjmregistrasi->insert_daftar_ulang($data2);
				$data4['timein'] = date('Y-m-d H:i:s');
				$data4['status'] = 2;
				// $id1 = $this->rjmtracer->update_mappasien($no_register, $data4);
				$noreg = $this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;

				$data2['no_register'] = $noreg;

				// Insert To Table konsul_dokter
				$data_konsul_dokter['no_register'] = $no_register;
				$data_konsul_dokter['id_dokter_asal'] = $this->input->post('id_dokter_asal');
				$data_konsul_dokter['id_poli_asal'] = $this->input->post('id_poli_asal');
				$data_konsul_dokter['tanggal_konsul'] = date('Y-m-d');
				$data_konsul_dokter['nama_pasien'] = $this->input->post('nama_pasien');
				$data_konsul_dokter['diagnosis_awal'] = $this->input->post('diagnosis_awal');
				$data_konsul_dokter['tindakan_asal'] = $this->input->post('tindakan_asal');
				$data_konsul_dokter['id_dokter_akhir'] = $this->input->post('dokter_kontrol_id');
				$data_konsul_dokter['id_poli_akhir'] = $this->input->post('id_poli_rujuk');


				// $this->rjmpelayanan->insert_konsul_dokter($data_konsul_dokter);

				// End Insert

				echo '<script type="text/javascript">window.open("' . site_url("irj/rjcregistrasi/cetak_tracer/$noreg") . '", "_blank");window.focus()</script>';

				$success = 	'<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Pasien berhasil dirujuk rawat jalan.
										</h4>
									</div>
								</div>
							</div>';
				// $no_register = $id->no_register;
				// $this->insert_tindakan3($data2);
				$this->session->set_flashdata('success_msg', $success);

				redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');

				// redirect('irj/rjcpelayanan/surat_konsul/' . $no_register, 'refresh');
				break;
			case "DIRUJUK_RAWATINAP":
				// var_dump($no_register);die();
				$data4['timein'] = date('Y-m-d H:i:s');
				$data4['status'] = 2;
				$id1 = $this->rjmtracer->update_mappasien($no_register, $data4);

				// insert langsung ke reservasi
				$count = $this->rimpendaftaran->get_pasien_iri_exist($data_pasien_daftar_ulang->no_medrec)->row()->exist;
				// var_dump($count);die();
				$data_reservasi['tppri'] = "rawatjalan";
				if ($data_reservasi['tppri'] == 'rawatjalan' and (int)$count == 0) {
					$count = 0;
				} else if ($data_reservasi['tppri'] == 'ruangrawat' and (int)$count == 1) {
					$count = 0;
				}
				if ((int)$count == 0) {
					// Asal

					$datenow = date('Ymd');
					$noreservasi = count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow)) + 1;
					$data_reservasi['noreservasi'] = $datenow . '-' . $noreservasi; // No. Antrian
					$data_reservasi['rujukan'] = 'regional'; // Rujukan
					$data_reservasi['no_medrec'] = $data_pasien_daftar_ulang->no_medrec; // No. CM


					$data_reservasi['no_register_asal'] = $no_register; // Kode Reg. Asal
					// var_dump($no_register);die();
					$data_pasien_reservasi = $this->rimreservasi->select_pasien_irj($data_reservasi['no_register_asal']);
					 

					// $this->session->set_flashdata('pesan',
					// "<div class='alert alert-error alert-dismissable'>
					// 	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	<i class='icon fa fa-close'></i> Reg asal tidak ditemukan!
					// </div>");
					if (!($data_pasien_reservasi)) {
						if ($this->input->post('sebagai') == 'PERAWAT') {
							redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						} else {
							redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						}
						exit;
					}

					$data_reservasi['tglreserv'] = date('Y-m-d H:i:s'); // Tanggal Reservasi
					$data_reservasi['telp'] = $data_pasien_daftar_ulang->no_telp; // Telp
					$data_reservasi['hp'] = $data_pasien_daftar_ulang->no_hp; // HP

					$data_reservasi['id_poli'] = $data_pasien_daftar_ulang->id_poli; // Id Poli
					//    $data_reservasi['poliasal']=$data_pasien_daftar_ulang->nm_poli; // Poli Asal
					$data_reservasi['id_dokter'] = $data_pasien_daftar_ulang->id_dokter; // Poli asal
					$data_reservasi['dokter'] = $data_pasien_daftar_ulang->dokter; // Poli Asal
					$data_reservasi['diagnosa'] = $data_pasien_daftar_ulang->diagnosa; // Poli Asal
					$data_reservasi['dikirim_oleh'] = 'Dokter';
					$data_reservasi['dikirim_oleh_teks'] = $data_pasien_daftar_ulang->dokter;

					//  RENCANA MASUK
					$data_reservasi['tglrencanamasuk'] = date('Y-m-d'); // Rencana masuk
					//    $temp_ruang = $this->input->post('ruang',true); // Kode ruang pilih
					//    var_dump($temp_ruang);die();
					//    $temp_ruang =explode("-", $temp_ruang);
					//    $data_reservasi['ruangpilih']=$temp_ruang[0]; // Kode ruang pilih
					// $data_reservasi['kelas']=$this->input->post('kelas'); // Kelas
					//    $data_reservasi['kelas']=$temp_ruang[2]; // Kelas
					$data_reservasi['pilihan_prioritas'] = $this->input->post('pilihan_prioritas'); // Kelas
					$data_reservasi['prioritas'] = $this->input->post('prioritas'); // Kelas
					//if(($this->input->post('infeksi'))){
					if ($this->input->post('infeksi') != null) {
						$data_reservasi['infeksi'] = $this->input->post('infeksi'); // Infeksi
					} else {
						$data_reservasi['infeksi'] = 'N';
					}
					//    $data_reservasi['keterangan']=$this->input->post('keterangan'); // Keterangan
					$data_reservasi['carabayar'] = $data_pasien_daftar_ulang->cara_bayar;
					$data_reservasi['statusantrian'] = 'N'; // Keterangan
					$data_reservasi['batal'] = 'N'; // Keterangan
					$login_data = $this->load->get_var("user_info");
					$data_reservasi['user_approve'] = $login_data->username;
					$roleid = $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;
					// MENU
					$data['reservasi'] = 'active';
					$data['daftar'] = '';
					$data['pasien'] = '';
					$data['mutasi'] = '';
					$data['status'] = '';
					$data['resume'] = '';
					$data['kontrol'] = '';
					//    $this->session->set_flashdata('pesan',
					//    "<div class='alert alert-success alert-dismissable'>
					// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	   cetak_surat_kontrol <i class='icon fa fa-check'></i> Data telah tersimpan!
					//    </div>");
					$data['tppri'] = 'rawatjalan';
					$data_reservasi['spri'] = substr($data_reservasi['id_poli'], -2) . strval(date('m')) . strval(sprintf("%02d", $noreservasi));
					$id = $this->rimreservasi->insert_reservasi($data_reservasi);
					if ($id == '') {
						if ($this->input->post('mutasi') != '') {
							//    redirect('iri/ricpasien');
							if ($this->input->post('sebagai') == 'PERAWAT') {
								redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
							} else {
								redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
							}
						} else {
							if ($roleid == '24') {
								if ($this->input->post('sebagai') == 'PERAWAT') {
									redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								} else {
									redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								}

								//    redirect('iri/ricpasien');
							} else {
								//    redirect('iri/Ricdaftar/index/1');
								if ($this->input->post('sebagai') == 'PERAWAT') {
									redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								} else {
									redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								}
							}
						}
					} else {
						//    $this->session->set_flashdata('pesan',
						//    "<div class='alert alert-error alert-dismissable'>
						// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						// 	   <i class='icon fa fa-close'></i> Gagal menambahkan pasien ke list antrian !
						//    </div>");
						if ($this->input->post('sebagai') == 'PERAWAT') {
							redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						} else {
							redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						}
						//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
					}
				} else {
					if ($this->input->post('tppri', true) == 'rawatjalan') {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_rawatjalan'); // Kode Reg. Asal
					} else if ($this->input->post('tppri', true) == 'ruangrawat') {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_ruangrawat', true); // Kode Reg.
					} else {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_rawatdarurat'); // Kode Reg. Asal
					}
					//    $this->session->set_flashdata('pesan',
					// 	   "<div class='alert alert-error alert-dismissable'>
					// 		   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 		   <i class='icon fa fa-close'></i> Pasien sudah dirawat diruangan !
					// 	   </div>");
					if ($this->input->post('sebagai') == 'PERAWAT') {
						redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
					} else {
						redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
					}
					//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
				}


				// die();
				// redirect('irj/rjcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
				break;

			case "DIRUJUK_RAWATINAP_NR":
				$data4['timein'] = date('Y-m-d H:i:s');
				$data4['status'] = 2;
				$id1 = $this->rjmtracer->update_mappasien($no_register, $data4);

				// insert langsung ke reservasi
				$count = $this->rimpendaftaran->get_pasien_iri_exist($data_pasien_daftar_ulang->no_medrec)->row()->exist;
				$data_reservasi['tppri'] = "rawatjalan";
				if ($data_reservasi['tppri'] == 'rawatjalan' and (int)$count == 0) {
					$count = 0;
				} else if ($data_reservasi['tppri'] == 'ruangrawat' and (int)$count == 1) {
					$count = 0;
				}
				if ((int)$count == 0) {
					// Asal

					$datenow = date('Ymd');
					$noreservasi = count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow)) + 1;
					$data_reservasi['noreservasi'] = $datenow . '-' . $noreservasi; // No. Antrian
					$data_reservasi['rujukan'] = 'regional'; // Rujukan
					$data_reservasi['no_medrec'] = $data_pasien_daftar_ulang->no_medrec; // No. CM


					$data_reservasi['no_register_asal'] = $no_register; // Kode Reg. Asal
					// var_dump($no_register);die();
					$data_pasien_reservasi = $this->rimreservasi->select_pasien_irj($data_reservasi['no_register_asal']);
					// var_dump($data_pasien_reservasi);die();

					// $this->session->set_flashdata('pesan',
					// "<div class='alert alert-error alert-dismissable'>
					// 	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	<i class='icon fa fa-close'></i> Reg asal tidak ditemukan!
					// </div>");
					if (!($data_pasien_reservasi)) {
						if ($this->input->post('sebagai') == 'PERAWAT') {
							redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						} else {
							redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						}
						exit;
					}

					$data_reservasi['tglreserv'] = date('Y-m-d H:i:s'); // Tanggal Reservasi
					$data_reservasi['telp'] = $data_pasien_daftar_ulang->no_telp; // Telp
					$data_reservasi['hp'] = $data_pasien_daftar_ulang->no_hp; // HP

					$data_reservasi['id_poli'] = $data_pasien_daftar_ulang->id_poli; // Id Poli
					//    $data_reservasi['poliasal']=$data_pasien_daftar_ulang->nm_poli; // Poli Asal
					$data_reservasi['id_dokter'] = $data_pasien_daftar_ulang->id_dokter; // Poli asal
					$data_reservasi['dokter'] = $data_pasien_daftar_ulang->dokter; // Poli Asal
					$data_reservasi['diagnosa'] = $data_pasien_daftar_ulang->diagnosa; // Poli Asal
					$data_reservasi['dikirim_oleh'] = 'Dokter';
					$data_reservasi['dikirim_oleh_teks'] = $data_pasien_daftar_ulang->dokter;

					//  RENCANA MASUK
					$data_reservasi['tglrencanamasuk'] = date('Y-m-d'); // Rencana masuk
					//    $temp_ruang = $this->input->post('ruang',true); // Kode ruang pilih
					//    var_dump($temp_ruang);die();
					//    $temp_ruang =explode("-", $temp_ruang);
					//    $data_reservasi['ruangpilih']=$temp_ruang[0]; // Kode ruang pilih
					// $data_reservasi['kelas']=$this->input->post('kelas'); // Kelas
					//    $data_reservasi['kelas']=$temp_ruang[2]; // Kelas
					$data_reservasi['pilihan_prioritas'] = $this->input->post('pilihan_prioritas'); // Kelas
					$data_reservasi['prioritas'] = $this->input->post('prioritas'); // Kelas
					//if(($this->input->post('infeksi'))){
					if ($this->input->post('infeksi') != null) {
						$data_reservasi['infeksi'] = $this->input->post('infeksi'); // Infeksi
					} else {
						$data_reservasi['infeksi'] = 'N';
					}
					//    $data_reservasi['keterangan']=$this->input->post('keterangan'); // Keterangan
					$data_reservasi['carabayar'] = $data_pasien_daftar_ulang->cara_bayar;
					$data_reservasi['statusantrian'] = 'N'; // Keterangan
					$data_reservasi['batal'] = 'N'; // Keterangan
					$login_data = $this->load->get_var("user_info");
					$data_reservasi['user_approve'] = $login_data->username;
					$roleid = $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;
					// MENU
					$data['reservasi'] = 'active';
					$data['daftar'] = '';
					$data['pasien'] = '';
					$data['mutasi'] = '';
					$data['status'] = '';
					$data['resume'] = '';
					$data['kontrol'] = '';
					//    $this->session->set_flashdata('pesan',
					//    "<div class='alert alert-success alert-dismissable'>
					// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 	   cetak_surat_kontrol <i class='icon fa fa-check'></i> Data telah tersimpan!
					//    </div>");
					$data['tppri'] = 'rawatjalan';
					$data_reservasi['spri'] = substr($data_reservasi['id_poli'], -2) . strval(date('m')) . strval(sprintf("%02d", $noreservasi));
					$id = $this->rimreservasi->insert_reservasi($data_reservasi);
					if ($id == '') {
						if ($this->input->post('mutasi') != '') {
							//    redirect('iri/ricpasien');
							if ($this->input->post('sebagai') == 'PERAWAT') {
								redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
							} else {
								redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
							}
						} else {
							if ($roleid == '24') {
								if ($this->input->post('sebagai') == 'PERAWAT') {
									redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								} else {
									redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								}

								//    redirect('iri/ricpasien');
							} else {
								//    redirect('iri/Ricdaftar/index/1');
								if ($this->input->post('sebagai') == 'PERAWAT') {
									redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								} else {
									redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
								}
							}
						}
					} else {
						//    $this->session->set_flashdata('pesan',
						//    "<div class='alert alert-error alert-dismissable'>
						// 	   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						// 	   <i class='icon fa fa-close'></i> Gagal menambahkan pasien ke list antrian !
						//    </div>");
						if ($this->input->post('sebagai') == 'PERAWAT') {
							redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						} else {
							redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
						}
						//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
					}
				} else {
					if ($this->input->post('tppri', true) == 'rawatjalan') {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_rawatjalan'); // Kode Reg. Asal
					} else if ($this->input->post('tppri', true) == 'ruangrawat') {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_ruangrawat', true); // Kode Reg.
					} else {
						$data_reservasi['no_register_asal'] = $this->input->post('no_register_rawatdarurat'); // Kode Reg. Asal
					}
					//    $this->session->set_flashdata('pesan',
					// 	   "<div class='alert alert-error alert-dismissable'>
					// 		   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					// 		   <i class='icon fa fa-close'></i> Pasien sudah dirawat diruangan !
					// 	   </div>");
					if ($this->input->post('sebagai') == 'PERAWAT') {
						redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
					} else {
						redirect('irj/rjcpelayananfdokter/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
					}
					//    redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'.$no_register);
				}
				//var_dump($id1);die();

				break;

			case "DIRUJUK_RS":
				$success = 	'<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Pasien berhasil dirujuk RS.
										</h4>
									</div>
								</div>
							</div>';
				$this->session->set_flashdata('success_msg', $success);

				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
				break;
			case "MENINGGAL":
				$success = 	'<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Pasien Meninggal.
										</h4>
									</div>
								</div>
							</div>';

				$this->session->set_flashdata('success_msg', $success);

				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
				break;
			case "PULANG":
				$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<i class="fa fa-check-circle"></i> Status pulang berhasil disimpan.
                       		</div>';
				$this->session->set_flashdata('success_msg', $success);

				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
				break;

			default:
				// Kondisi ket_pulang = kontrol

				// data yang dibutuhkan
				// no mr data_pasien_daftar_ulang -> no_medrec
				// nama pasien data_pasien_daftar_ulang join
				// diagnose
				// tgl surat rujukan
				// alasan pulang
				// tindak lanjut
				// dokter yang memeriksa
				redirect('irj/rjcpelayanan/kunj_pasien_poli/' . $id_poli . '/', 'refresh');
				// redirect('irj/rjcpelayanan/surat_kontrol/' . $no_register, 'refresh');
				break;
		}
	}




	public function insert_tindakan3($data1)
	{
		//date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		//  1B0109 ADM RAWAT JALAN
		//  1B0103 ADM RAWAT Darurat
		//  1B0104 KARTU
		//  1B0107 Biaya Spesialis IRJ
		//  1B0108 Biaya IGD
		//  1B0105 Biaya Dokter Akupuntur

		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		$data['id_poli'] = $data1['id_poli'];
		//default
		$vtota = 0;
		if ($data['id_poli'] == 'BA00') {
			$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0109')->row();
			$data['idtindakan'] = '1B0109';
			$data['bpjs'] = '0';
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$vtota = $data['vtot'];
			$id = $this->rjmpelayanan->insert_tindakan($data);
			//IGD ADD DOCTOR FEE
			$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0108')->row();
			$data['idtindakan'] = '1B0108';
			$data['bpjs'] = '0';
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");

			$data['nmtindakan'] = $detailtind->nmtindakan;

			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$vtota += $data['vtot'];
			$id = $this->rjmpelayanan->insert_tindakan($data);
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$vtota;
			$this->rjmpelayanan->update_vtot($data_vtot, $data['no_register']);
		} else {
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			//IGD ADD DOCTOR FEE
			//ini diganti dulu karena tidak ada datanya
			// $detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0107')->row();
			// $data['idtindakan']='1B0107';

			//diganti dengan ini dengan isi pemeriksaan dan konseling dr spesialis
			$detailtind = $this->rjmregistrasi->get_detail_tindakan('1B0134')->row();
			$data['idtindakan'] = '1B0134';
			$data['bpjs'] = '0';
			$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
			$data['nmtindakan'] = $detailtind->nmtindakan;
			$data['biaya_tindakan'] = $detailtind->total_tarif;
			$data['biaya_alkes'] = $detailtind->tarif_alkes;
			$data['qtyind'] = '1';
			$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];
			$vtota += $data['vtot'];
			$id = $this->rjmpelayanan->insert_tindakan($data);
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya + (int)$vtota;
			$this->rjmpelayanan->update_vtot($data_vtot, $data['no_register']);
		}
		if ($data['id_poli'] == 'BZ04') { //lab
			$data4['lab'] = 1;
			$data4['status_lab'] = 0;
			$data4['jadwal_lab'] = date("Y-m-d H:i:s");
			$data4['ket_pulang'] = "PULANG";
			$data4['tgl_pulang'] = date("Y-m-d");
			$id = $this->rjmpelayanan->update_rujukan_penunjang($data4, $no_register);
		} else if ($data['id_poli'] == 'BZ02') { //rad
			$data4['rad'] = 1;
			$data4['status_rad'] = 0;
			$data4['jadwal_rad'] = date("Y-m-d H:i:s");
			$data4['ket_pulang'] = "PULANG";
			$data4['tgl_pulang'] = date("Y-m-d");
			$id = $this->rjmpelayanan->update_rujukan_penunjang($data4, $no_register);
		} else if ($data['id_poli'] == 'BZ01') { //pa
			$data4['pa'] = 1;
			$data4['status_pa'] = 0;
			$data4['jadwal_pa'] = date("Y-m-d H:i:s");
			$data4['ket_pulang'] = "PULANG";
			$data4['tgl_pulang'] = date("Y-m-d");
			$id = $this->rjmpelayanan->update_rujukan_penunjang($data4, $no_register);
		} else {
			$data4['em'] = 1;
			$data4['status_em'] = 0;
			$data4['jadwal_em'] = date("Y-m-d H:i:s");
			$data4['ket_pulang'] = "PULANG";
			$data4['tgl_pulang'] = date("Y-m-d");
		}
		$no_register = $data1['no_register'];
		if ($data1['cara_bayar'] != 'UMUM') {
			echo '<script type="text/javascript">window.open("' . site_url("irj/rjcsjp/cetak_sjp/$no_register") . '", "_blank");window.focus()</script>';
		}
	}





	public function update_rujukan_penunjang_2()
	{
		$no_register = $this->input->post('no_register');
		$jenis_rujuk = $this->input->post('jenis_rujuk');
		if ($jenis_rujuk == 'lab') {
			$data['jadwal_lab'] = $this->input->post('jadwal_rujuk') . " " . date(" H:i:s");
			$data['lab'] = 1;
			$data['status_lab'] = 1;
		} else if ($jenis_rujuk == 'rad') {
			$data['jadwal_rad'] = $this->input->post('jadwal_rujuk') . " " . date(" H:i:s");
			$data['rad'] = 1;
			$data['status_rad'] = 1;
		} else if ($jenis_rujuk == 'pa') {
			$data['jadwal_pa'] = $this->input->post('jadwal_rujuk') . " " . date(" H:i:s");
			$data['pa'] = 1;
			$data['status_pa'] = 1;
		} else if ($jenis_rujuk == 'ok') {
			$data['jadwal_ok'] = $this->input->post('jadwal_rujuk') . " " . date(" H:i:s");
			$data['ok'] = 1;
			$data['status_ok'] = 1;
		} else if ($jenis_rujuk == 'em') {
			$data['jadwal_rad'] = $this->input->post('jadwal_rujuk') . " " . date(" H:i:s");
			$data['em'] = 1;
			$data['status_em'] = 1;
		}

		// print_r($data);

		$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

		// $success = 	'<div class="content-header">
		// 					<div class="box box-default">
		// 						<div class="alert alert-success alert-dismissable">
		// 							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		// 							<h4>
		// 							<i class="icon fa fa-check"></i>
		// 							Rujukan Penunjang berhasil disimpan.
		// 							</h4>
		// 						</div>
		// 					</div>
		// 				</div>';


		// $this->session->set_flashdata('success_msg', $success);

		// redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
		echo json_encode(array("status" => $id));
	}

	function update_rujukan_resep_ruangan_rad()
	{
		$id_poli = $this->input->post('idrg');
		$no_register = $this->input->post('no_register');
		// $data['obat']=$this->input->post('obat');
		$pelayan = $this->input->post('pelayan');

		if ($no_register == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			}
		} else {
			$data['obat'] = 1;
			// $data['status_obat']=0;

			$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

			if ($id == true) {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}
	}

	function update_rujukan_resep_ruangan()
	{
		$id_poli = $this->input->post('idrg');
		$no_register = $this->input->post('no_register');
		$iter_obat = $this->input->post('iter_obat');
		// var_dump($iter);die();
		// $data['obat']=$this->input->post('obat');
		$pelayan = $this->input->post('pelayan');
		// var_dump($pelayan);die();
		if ($no_register == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			}
		} else {
			$data['obat'] = 1;
			$data['waktu_resep_dokter'] = date('Y-m-d H:i:s');
			// $data['status_obat']=0;

			$id = $this->rjmpelayanan->update_rujukan_penunjang_new($no_register, $iter_obat);

			if ($id == true) {
				if ($id_poli == 'BH00' || $id_poli == 'BH03') {
					redirect('irj/rjcpelayananfdokter/form/assesment_medik_dok/' . $id_poli . '/' . $no_register);
				} else {
					if($pelayan == 'DOKTER'){
						redirect('irj/rjcpelayananfdokter/form/assesment_medik_dok/' . $id_poli . '/' . $no_register);
					}else{
						redirect('irj/rjcpelayanan/form/resep/' . $id_poli . '/' . $no_register);
					}
					
				}
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}
	}

	public function update_rujukan_penunjang()
	{
		$id_poli = $this->input->post('id_poli');
		$no_register = $this->input->post('no_register');

		if ($this->input->post('lab') != null) {
			$data['lab'] = $this->input->post('lab');
			$data['status_lab'] = 0;
			$data['jadwal_lab'] = date("Y-m-d");
			// $data['jadwal_lab']=$this->input->post('jadwal_lab');
		}

		if ($this->input->post('ok') != null) {
			$data['ok'] = $this->input->post('ok');
			$data['status_ok'] = 0;
			$data['jadwal_ok'] = date("Y-m-d");
			// $data['jadwal_ok']=$this->input->post('jadwal');

			//add poli anastesi
			$data2['id_poli'] = 'CD00';

			$datenow = '';
			$data_sblm = $this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
			foreach ($data_sblm as $row) {

				$data2['no_medrec'] = $row->no_medrec;
				$datenow = date('Y-m-d H:i:s');
				$data2['tgl_kunjungan'] = $datenow;
				$data2['jns_kunj'] = $row->jns_kunj;
				$data2['umurrj'] = $row->umurrj;
				$data2['uharirj'] = $row->uharirj;
				$data2['ublnrj'] = $row->ublnrj;
				$data2['asal_rujukan'] = $row->asal_rujukan;
				$data2['no_rujukan'] = $row->no_rujukan;
				$data2['kelas_pasien'] = $row->kelas_pasien;
				$data2['cara_bayar'] = $row->cara_bayar;
				$data2['id_kontraktor'] = $row->id_kontraktor;
				$data2['nama_penjamin'] = $row->nama_penjamin;
				$data2['hubungan'] = $row->hubungan;
				$data2['vtot'] = $row->vtot;
				$data2['no_sep'] = $row->no_sep;
			}

			$data2['cara_kunj'] = "RUJUKAN POLI";
			$login_data = $this->load->get_var("user_info");
			$data2['xcreate'] = $login_data->username;
			$data2['vtot'] = 0;
			$data2['biayadaftar'] = 0;


			//print_r($data2);
			$id = $this->rjmregistrasi->insert_daftar_ulang($data2);

			//echo($id->no_register);
			$data4['timein'] = date('Y-m-d H:i:s');
			$data4['status'] = 2;
			$id1 = $this->rjmtracer->update_mappasien($no_register, $data4);

			$noreg = $this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;

			$data2['no_register'] = $noreg;
			$data6['no_register'] = $noreg;
			$data6['no_medrec'] = $data2['no_medrec'];
			$data6['id_poli'] = $data2['id_poli'];
			$data5['timeout'] = date('Y-m-d H:i:s');
			$data6['status'] = 1;
			$data6['tiperawat'] = 'IRJ';
			$this->insert_tindakan3($data2);
			$id2 = $this->rjmtracer->insert_mappasien($data6);
		}

		if ($this->input->post('pa') != null) {
			$data['pa'] = $this->input->post('pa');
			$data['status_pa'] = 0;
			$data['jadwal_pa'] = date("Y-m-d");
			// $data['jadwal_pa']=$this->input->post('jadwal');
		}
		if ($this->input->post('rad') != null) {
			$data['rad'] = $this->input->post('rad');
			$data['status_rad'] = 0;
			$data['jadwal_rad'] = date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		}
		if ($this->input->post('obat') != null) {
			$data['obat'] = $this->input->post('obat');
			$data['status_obat'] = 0;
		}
		if ($this->input->post('fisio') != null) {
			$data['fisio'] = $this->input->post('fisio');
			$data['status_fisio'] = 0;
		}
		if ($this->input->post('em') != null) {
			$data['em'] = $this->input->post('em');
			$data['status_em'] = 0;
			$data['jadwal_em'] = date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');
		}



		$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
                       	</div>';


		$this->session->set_flashdata('success_msg', $success);

		redirect('irj/rjcpelayanan/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
	}

	public function hapus_sep($no_sep = '')
	{
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;
		if ($no_sep == '') {
			$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';
			$this->session->set_flashdata('notification', $notif);
			//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
		} else {
			$url = $data_bpjs->service_url;
			$timezone = date_default_timezone_get();
			date_default_timezone_set('Asia/Jakarta');
			$timestamp = time();  //cari timestamp
			//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
			$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
			$encoded_signature = base64_encode($signature);
			$tgl_sep = date('Y-m-d 00:00:00');
			$http_header = array(
				'Accept: application/json',
				// 'Content-type: application/xml',
				// 'Content-type: application/json',
				'Content-type: application/x-www-form-urlencoded',
				'X-cons-id: ' . $cons_id, //id rumah sakit
				'X-timestamp: ' . $timestamp,
				'X-signature: ' . $encoded_signature
			);
			date_default_timezone_set($timezone);
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
			$data = array(
				'request' => array(
					't_sep' => array(
						'noSep' => $no_sep,
						'ppkPelayanan' => $ppk_pelayanan
					)
				)
			);
			$datasep = json_encode($data);
			// print_r($datasep);exit; ///////////////////////////////////////
			$ch = curl_init($url . 'SEP/Delete');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			if ($result != '') { //valid koneksi internet
				$sep = json_decode($result);
				// print_r($sep->response);exit; ///////////////////////////////////////
				if ($sep->metadata->code == '800') {
					$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, ' . $sep->metadata->message . '
								</div>
							</div>
						</div>';
					$this->session->set_flashdata('notification', $notif);
					//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
				}
				if ($sep->metadata->code == '200') {

					$id = $this->M_update_sepbpjs->update_hapus_SEP($no_sep);
					// $data_update = array(
					//     		'no_sep' => NULL
					//   			);
					// $this->M_update_sepbpjs->delete_sep($no_register,$no_sep,$data_update);
					$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP <b>' . $sep->response . '</b> berhasil dihapus.
								</div>
							</div>
						</div>';
					$this->session->set_flashdata('notification', $notif);
					//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
				} else {
					$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									' . $sep->metadata->message . '.
								</div>
							</div>
						</div>';
					$this->session->set_flashdata('notification', $notif);
					//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
				}
			} else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);
				//redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
			}
		}
	}
	// //--------------------------------------------------------------------------------------------------LAB
	// public function insert_pemeriksaan() //insert LAB
	// {
	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['id_tindakan']=$this->input->post('idtindakan');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
	// 	$data_tindakan=$this->labmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['jenis_tindakan']=$row->nmtindakan;
	// 	}
	// 	$data['qty']=$this->input->post('qty_lab');
	// 	$data['id_dokter']=$this->input->post('id_dokter');
	// 	$data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
	// 	foreach($data_dokter as $row){
	// 		$data['nm_dokter']=$row->nm_dokter;
	// 	}
	// 	$data['biaya_lab']=$this->input->post('biaya_lab_hide');
	// 	$data['vtot']=$this->input->post('vtot_lab_hide');
	// 	$data['idrg']=$id_poli;
	// 	//$data['bed']=$this->input->post('bed');
	// 	$data['no_lab']=$this->input->post('no_lab');
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');

	// 	if($data['no_lab']!=''){
	// 	} else {
	// 		//$this->labmdaftar->insert_data_header($no_register,$data['idrg'],$data['bed'],$data['kelas_pasien']);
	// 		$this->labmdaftar->insert_data_header($data['no_register'],$id_poli,'',$data['kelas']);
	// 	}
	// 	$data['no_lab']=$this->labmdaftar->get_data_header($data['no_register'],$id_poli,'',$data['kelas'])->row()->no_lab;


	// 	$this->labmdaftar->insert_pemeriksaan($data);

	// 	$tab="lab";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_lab']);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register'].'/'.$data['no_lab']);
	// 	//print_r($data);
	// }

	// public function hapus_data_pemeriksaan($id_poli='', $no_register='', $tab='', $no_lab='', $id_pemeriksaan_lab='')
	// {
	// 	$id=$this->labmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_lab);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab.'/'.$no_lab);
	// 	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$no_lab);
	// }

	// public function selesai_daftar_pemeriksaan($id_poli='', $no_register='', $tab='')
	// {
	// 	$getvtotlab=$this->labmdaftar->get_vtot_lab($no_register)->row()->vtot_lab;

	// 	//update vtot_lab di daftar ulang irj
	// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotlab);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/'.$tab);
	// 	//redirect('lab/Labcdaftar/');
	// }
	//--------------------------------------------------------------------------------------------------END LAB

	// //--------------------------------------------------------------------------------------------------RESEP
	// public function insert_resep()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');

	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunjungan');
	// 	$data['item_obat']=$this->input->post('obat');
	// 	$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['nama_obat']=$row->nm_obat;
	// 		$data['Satuan_obat']=$row->satuank;
	// 	}
	// 	$data['idrg']=$id_poli;
	// 	$data['bed']='';
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
	// 	$data['no_resep']=$this->input->post('no_resep');
	// 	$data['qty']=$this->input->post('qtyResep');
	// 	$data['Signa']=$this->input->post('signa');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['biaya_obat']=$this->input->post('biaya_obat_hide');
	// 	$data['vtot']=$this->input->post('vtot_resep_hide');
	// 	$get_data_markup=$this->Frmmdaftar->get_data_markup()->result();
	// 	foreach($get_data_markup as $row){
	// 		//$data['kdmarkup']=$row->kodemarkup;
	// 		//$data['ketmarkup']=$row->ket_markup;
	// 		$data['fmarkup']=$row->markup;
	// 	}
	// 	$data['ppn']=1.1;

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 	$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}

	// 	$this->Frmmdaftar->insert_permintaan($data);

	// 	$tab="resep";
	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/'.$tab.'/'.$data['no_resep']);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// }

	// public function hapus_data_resep($id_poli='', $no_register='', $no_lab='', $id_resep_pasien='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_lab);
	// 	//redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep');
	// }

	// public function selesai_daftar_resep()
	// {
	// 	$no_register=$this->input->post('no_register');
	// 	$id_poli=$this->input->post('id_poli');
	// 	$no_resep=$this->input->post('no_resep');

	// 	//update daftar ulang irj
	// 	$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
	// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);

	// 	//$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	// 	echo '<script type="text/javascript">window.open("'.site_url("irj/Rjcpelayanan/cetak_faktur_obat/$no_resep").'", "_blank");window.focus()</script>';

	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep','refresh');
	// 	//redirect('farmasi/Frmcdaftar/','refresh');

	// }

	// public function insert_racikan()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');

	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['item_obat']=$this->input->post('idracikan');
	// 	$data['idrg']=$id_poli;
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	$data['bed']='';
	// 	$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
	// 	foreach($data_tindakan as $row){
	// 		$data['nama_obat']=$row->nm_obat;
	// 		$data['Satuan_obat']=$row->satuank;
	// 	}
	// 	$data['qty']=$this->input->post('qty_racikan');
	// 	$data['no_resep']=$this->input->post('no_resep');

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 		$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}

	// 	$this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);

	// 	redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep'].'/racik');
	// 	//print_r($data);
	// }

	// public function hapus_data_racikan($no_register='', $no_resep='', $item_obat='', $id_resep_pasien='',$id_poli='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_racikan($item_obat, $id_resep_pasien);

	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'/resep/'.$no_resep.'/racik','refresh');

	// 	//print_r($id);
	// }

	// public function insert_racikan_selesai()
	// {
	// 	//$id_pemeriksaan_lab=$this->input->post('id_poli');
	// 	//$data['no_slip']=$this->input->post('no_slip');

	// 	$id_poli=$this->input->post('id_poli');
	// 	$data['no_register']=$this->input->post('no_register');
	// 	$data['no_medrec']=$this->input->post('no_medrec');
	// 	$data['tgl_kunjungan']=$this->input->post('tgl_kun');
	// 	$data['idrg']=$id_poli;
	// 	$data['cara_bayar']=$this->input->post('cara_bayar');
	// 	$data['bed']='';
	// 	$data['no_resep']=$this->input->post('no_resep');
	// 	$data['qty']=$this->input->post('qty1');
	// 	$data['Signa']=$this->input->post('signa');
	// 	$data['kelas']=$this->input->post('kelas_pasien');
	// 	//$data['biaya_obat']=$this->input->post('biaya_obat_hide');//sum dari db
	// 	$data['fmarkup']=$this->input->post('fmarkup');// dari db
	// 	$data['ppn']=1.1;
	// 	$data['vtot']=$this->input->post('vtot_x_hide');
	// 	$data['nama_obat']=$this->input->post('racikan');
	// 	$data['racikan']='1';
	// 	$data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik($data['no_resep'])->result();
	// 	foreach($data_biaya_racik as $row){
	// 		$data['biaya_obat']=$row->total;
	// 	}

	// 	if($data['no_resep']!=''){
	// 	} else {
	// 		$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
	// 		$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
	// 	}


	// 	$this->Frmmdaftar->insert_permintaan($data);
	// 	$id_resep_pasien=$this->rjmpelayanan->get_id_resep($data['no_resep'])->row()->id_resep_pasien;
	// 	$this->Frmmdaftar->update_racikan($data['no_resep'], $id_resep_pasien);

	// 	redirect('irj/Rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$data['no_register'].'/resep/'.$data['no_resep']);
	// 	//print_r($data);
	// }
	public function cetak_faktur_obat($no_resep = '')
	{
		if ($no_resep != '') {
			$cterbilang = new rjcterbilang();

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamat=$row->alamat;
			// 	}
			$namars = $this->config->item('namars');
			$alamat = $this->config->item('alamat');
			$kota_kab = $this->config->item('kota');

			$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			foreach ($data_pasien as $row) {
				$nama = $row->nama;
				$sex = $row->sex;
				$goldarah = $row->goldarah;
				$no_register = $row->no_register;
				$no_medrec = $row->no_medrec;
				$idrg = $row->idrg;
				//$bed=$row->bed;
				$cara_bayar = $row->cara_bayar;
			}

			//$data_permintaan=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			$data_permintaan = $this->rjmpelayanan->get_data_permintaan($no_resep)->result();

			$konten =
				"<table>
						<tr>
							<td><p align=\"right\"><b>Tanggal-Jam: $tgl_jam</b></p></td>
						</tr>
						<tr>
							<td><font size=\"12\"><b>$namars</b></font></td>
						</tr>
						<tr>
							<td><b>$alamat</b></td>
						</tr>
					</table>
					<br/><hr/><br/>
					<p align=\"center\"><b>
					FAKTUR PERMINTAAN OBAT<br/>
					No. SKT. FRM_$no_resep
					</b></p><br/>
					<br><br>
					<table>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_register</td>
							<td width=\"15%\"> </td>
							<td width=\"15%\"><b>Cara Bayar</b></td>
							<td width=\"3%\"> : </td>
							<td>$cara_bayar</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Medrec</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_medrec</td>
							<td width=\"15%\"></td>
							<td width=\"15%\"><b>Poliklinik</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"30%\">" . $idrg . "</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td width=\"30%\">" . $nama . " / " . $sex . " / " . $goldarah . "</td>
						</tr>
						<tr>
							<td><b>Untuk Permintaan Obat</b></td>
							<td> : </td>
							<td></td>
						</tr>
					</table>
					<br/><br/>
					<table>
						<tr><hr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"40%\"><p align=\"center\"><b>Nama Item</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Harga</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
						<hr>
					";
			$i = 1;
			$jumlah_vtot = 0;
			foreach ($data_permintaan as $row) {
				$jumlah_vtot = $jumlah_vtot + $row->vtot;
				$vtot = number_format($row->vtot, 2, ',', '.');
				$konten = $konten . "<tr>
										  <td><p align=\"center\">$i</p></td>
										  <td>$row->nama_obat</td>
										  <td><p align=\"center\">$row->qty</p></td>
										  <td><p align=\"center\">" . number_format($row->biaya_obat, 2, ',', '.') . "</p></td>
										  <td><p align=\"right\">$vtot</P></td>
										  <br>
										</tr>";
				if ($row->racikan == '1') {
					$data_detail_racikan = $this->rjmpelayanan->get_detail_racikan($row->id_resep_pasien)->result();

					foreach ($data_detail_racikan as $row2) {
						$konten = $konten . "<tr>
											  <td></td>
											  <td>$row2->nm_obat</td>
											  <td><p align=\"center\">$row2->qty</p></td>
											  <td></td>
											  <td></td>
											  <br>
											</tr>";
					}
				}
				$i++;
			}

			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);

			$konten = $konten . "
						<tr><hr><br>
							<th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>" . number_format($jumlah_vtot, 2, ',', '.') . "</b></font></p></th>
						</tr>

					</table>
					<b><font size=\"10\"><p align=\"right\">Terbilang : " . $vtot_terbilang . "</p></font></b>
					<br><br>
					<p align=\"right\">$kota_kab, $tgl</p>
					";

			$file_name = "SKT_$no_resep.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, '5');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/farmasi/frmkwitansi/' . $file_name, 'FI');
		} else {
			redirect('farmasi/Frmckwitansi/', 'refresh');
		}
	}
	//--------------------------------------------------------------------------------------------------END RESEP

	public function update_dokter()
	{

		if ($this->input->post('id_dokter') != '') {
			$dokter = explode("@", $this->input->post('id_dokter'));
			$data['id_dokter'] = $dokter[0];
			$data2['id_dokter'] = $dokter[0];
			$data['nm_dokter'] = $dokter[1];
		}
		$no_register = $this->input->post('no_register');
		$jalan = '1B0101';
		$ugd = '1B0108';
		$update1 = $this->rjmpelayanan->update_rujukan_penunjang_poli(
			$data,
			$no_register,
			$jalan,
			$ugd
		);
		$update2 = $this->rjmpelayanan->update_rujukan_penunjang($data2, $no_register);


		echo $update2;
		//echo '<script type="text/javascript">tabeltindakan('.$no_register.'); </script>';

	}
	// <table>
	// 						<tr>
	// 							<td width=\"20%\"><b>No. Registrasi</b></td>
	// 							<td width=\"3%\"> : </td>
	// 							<td>$no_register</td>
	// 							<td width=\"15%\"> </td>
	// 							<td width=\"15%\"><b>Cara Bayar</b></td>
	// 							<td width=\"3%\"> : </td>
	// 							<td>$cara_bayar</td>
	// 						</tr>
	// 						<tr>
	// 							<td width=\"20%\"><b>No. Medrec</b></td>
	// 							<td width=\"3%\"> : </td>
	// 							<td>$no_medrec</td>
	// 							<td width=\"15%\"></td>
	// 							<td width=\"15%\"><b>Poliklinik</b></td>
	// 							<td width=\"3%\"> : </td>
	// 							<td width=\"30%\">".$idrg."</td>
	// 						</tr>
	// 						<tr>
	// 							<td><b>Nama Pasien</b></td>
	// 							<td> : </td>
	// 							<td width=\"30%\">".$nama." / ".$sex." / ".$goldarah."</td>
	// 						</tr>
	// 						<tr>
	// 							<td><b>Untuk Permintaan Obat</b></td>
	// 							<td> : </td>
	// 							<td></td>
	// 						</tr>
	// 					</table>
	// 					<br/><br/>
	// 					<table>
	// 						<tr><hr>
	// 							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
	// 							<th width=\"40%\"><p align=\"center\"><b>Nama Item</b></p></th>
	// 							<th width=\"20%\"><p align=\"center\"><b>Banyak</b></p></th>
	// 							<th width=\"15%\"><p align=\"center\"><b>Harga</b></p></th>
	// 							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
	// 						</tr>
	// 						<hr>

	public function cetak_surat_keterangan_st()
	{
		// var_dump($this->input->post());die();
		$data['no_register'] = $this->input->post('no_register');
		//
		$data['tb'] = $this->input->post('tb');
		$data['bb'] = $this->input->post('bb');
		$data['kondisi_pasien'] = $this->input->post('kondisi_pasien');
		$data['tgl_input'] = date("Y-m-d H:i:s");
		$check_data = $this->rjmpelayanan->load_data_surat_tindakan($data['no_register']);
		if ($check_data->num_rows()) {
			return $this->rjmpelayanan->update_data_surat_tindakan($data, $data['no_register']);
		} else {
			return $this->rjmpelayanan->insert_data_surat_kesehatan($data);
		}
	}

	public function cetak_surat_keterangan()
	{

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");
		$thn = date("Y");

		// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
		// 	foreach($data_rs as $row){
		// 		$namars=$row->namars;
		// 		$kota_kab=$row->kota;
		// 		$alamat=$row->alamat;
		// 	}
		$namars = $this->config->item('namars');
		$alamat = $this->config->item('alamat');
		$kota_kab = $this->config->item('kota');
		$no_register = $this->session->userdata('no_reg_extra');

		$thc = $this->session->userdata('thc_extra');
		$amphe = $this->session->userdata('amphe_extra');
		$opiat = $this->session->userdata('opiat_extra');
		$keterangan = $this->session->userdata('kets');
		$hasil = $this->session->userdata('hasil');
		$nosur = $this->session->userdata('nosur');
		$bulan = $this->session->userdata('bulan');
		//$no_register=$_COOKIE['no_register'];//$this->input->post('no_register');
		//$a=$_COOKIE['a'];//$this->input->post('a');
		// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
		// 	foreach($data_pasien as $row){
		// 		$nama=$row->nama;
		// 		$sex=$row->sex;
		// 		$goldarah=$row->goldarah;
		// 		$no_register=$row->no_register;
		// 		$no_medrec=$row->no_medrec;
		// 		$idrg=$row->idrg;
		// 		//$bed=$row->bed;
		// 		$cara_bayar=$row->cara_bayar;
		// 	}

		$dokter = $this->rjmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
		$data_permintaan = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$kontens =
			"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					.table-font-size1{
						font-size:13px;
					    }
					.table-font-size2{
						font-size:10px;
						margin : 5px 1px 1px 1px;
						padding : 3px 1px 1px 1px;
					    }
					</style>
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:13px\">$namars</font></b><br><br>$alamat $kota_kab
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
						</tr>
						<tr>
							<td></td>
							<td colspan=\"0\"><p align=\"center\"><b><u>SURAT KETERANGAN BEBAS NARKOBA<br></u></b>
							NO.SKET/" . $nosur . "/NAPZA/" . $bulan . "/" . $thn . "</p>
							</td>
						</tr>

					</table>
					<table class=\"table-font-size2\">
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">
							Yang bertanda tangan dibawah ini menerangkan bahwa
							</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Nama</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($data_permintaan->nama)) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Tempat / Tanggal lahir </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($data_permintaan->tmpt_lahir)) . ", " . date('d-m-Y', strtotime($data_permintaan->tgl_lahir)) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Jenis Kelamin	 </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower(($data_permintaan->sex == 'L' ? 'Laki-laki' : ($data_permintaan->sex == 'P' ? 'Perempuan' : 'LAKI-LAKI / PEREMPUAN')))) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Alamat</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">" . strtolower($data_permintaan->alamat) . "</td>
						</tr>

						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Saat ini dari hasil pemeriksaan urine yang bersangkutan <b>" . ucwords($hasil) . "</b> : </td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">THC</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($thc)) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">Opiat</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($opiat)) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"11%\">Amphetamin</td>
							<td width=\"1%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($amphe)) . "</td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Keterangan ini diberikan untuk <b>" . $keterangan . "</b></td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Harap yang berkepentingan maklum adanya</td>
						</tr>
					</table>

					<table style=\"width:100%;\">
						<tr>
							<td width=\"70%\" ></td>
							<td width=\"30%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>a.n. Kepala Rumkital Dr. Mintohardjo
								<br>Perwira Kesehatan <br>
								<br><br><br>
								" . ((int)$dokter == 60 ? '
									<u>Kol(Purn)dr.Eunice.P.N.Psikiater</u><br>
									SIP.20/2.104/31.71.07/-1.779.3/e/2016 '
				: ((int)$dokter == 61 ? '
									<u>Kol(Purn)dr.Pramudya.P.Psikiater</u><br>
									SIP.23/2.104/31.71.07/-1.779.3/e/2016 '
					: ((int)$dokter == 185 ? '
									<u>dr.Fransiska Drie N. SpKJ</u><br>
									Kapten Laut (K/W) NRP. 15729/P'
						: ((int)$dokter == 62 ? '
									<u>dr. Rudyhard E. Hutagalung, Sp.KJ</u><br>
									Letkol Laut (K) NRP 14087/P '
							:
							'<u>dr.Eliyati D.Rosadi,SpKJ (K)</u><br>
									SIP.12/2.104/31.71.07/-1.779.3/e/2017')))) . "
								</p>
							</td>
						</tr>
					</table>
					";


		$file_name = "SKBN.pdf";

		// echo $kontens;
		// break;
		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '7', '5', '5');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$contentt = $kontens;
		ob_end_clean();
		$obj_pdf->writeHTML($kontens);
		$obj_pdf->Output(FCPATH . '/download/irj/rjcpelayanan/surat_bebas_narkoba/' . $file_name, 'FI');
	}
	// <table class=\"table-font-size2\">
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"90%\">
	// 						Yang bertanda tangan dibawah ini menerangkan bahwa  <br>
	// 						</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Nama</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Umur / Tanggal lahir </td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Jenis Kelamin	 </td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Alamat</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pendidikan</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pekerjaan / Kesatuan</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Pangkat & NRP</td>
	// 						<td width=\"2%\">:</td>
	// 						<td width=\"68%\"></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\"></td>
	// 						<td width=\"20%\">Saat ini tidak kami dapatkan adanya psikopatologi tertentu (tidak ada )</td>
	// 					</tr>
	// 				</table>


	public function cetak_surat_keterangan_st_jiwa()
	{
		//  var_dump($this->input->post());die();
		$data['no_register'] = $this->input->post('no_register');
		//
		$data['pemeriksaan_jiwa'] = $this->input->post('pemeriksaan_jiwa');
		$data['tgl_hasil_jiwa'] = $this->input->post('tgl_hasil_jiwa');
		$data['hasil_pem_jiwa'] = $this->input->post('hasil_pem_jiwa');
		$data['surat_untuk'] = $this->input->post('surat_untuk');
		$data['tgl_input'] = date("Y-m-d H:i:s");
		$check_data = $this->rjmpelayanan->load_data_surat_tindakan($data['no_register']);
		if ($check_data->num_rows()) {
			return $this->rjmpelayanan->update_data_surat_tindakan($data, $data['no_register']);
		} else {
			return $this->rjmpelayanan->insert_data_surat_kesehatan($data);
		}
	}

	public function cetak_surat_keterangan_jiwa()
	{

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");
		$thn = date("Y");

		// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
		// 	foreach($data_rs as $row){
		// 		$namars=$row->namars;
		// 		$kota_kab=$row->kota;
		// 		$alamat=$row->alamat;
		// 	}
		$namars = $this->config->item('namars');
		$alamat = $this->config->item('alamat');
		$kota_kab = $this->config->item('kota');
		$no_register = $this->session->userdata('no_reg_extra');

		$keterangan = $this->session->userdata('ketssj');
		$hasil = $this->session->userdata('hasilsj');
		$nosur = $this->session->userdata('nosursj');
		$bulan = $this->session->userdata('bulansj');
		//$no_register=$_COOKIE['no_register'];//$this->input->post('no_register');
		//$a=$_COOKIE['a'];//$this->input->post('a');
		// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
		// 	foreach($data_pasien as $row){
		// 		$nama=$row->nama;
		// 		$sex=$row->sex;
		// 		$goldarah=$row->goldarah;
		// 		$no_register=$row->no_register;
		// 		$no_medrec=$row->no_medrec;
		// 		$idrg=$row->idrg;
		// 		//$bed=$row->bed;
		// 		$cara_bayar=$row->cara_bayar;
		// 	}

		$dokter = $this->rjmpelayanan->getdata_dokter_tindakan($no_register)->row()->id_dokter;
		$data_permintaan = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$kontens =
			"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					.table-font-size1{
						font-size:13px;
					    }
					.table-font-size2{
						font-size:10px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:13px\">$namars</font></b><br><br>$alamat $kota_kab
							</td>
							<td width=\"14%\"><font size=\"9\" align=\"right\">$tgl_jam</font></td>
						</tr>
						<tr>
							<td></td>
							<td colspan=\"0\"><p align=\"center\"><b><u>SURAT KETERANGAN<br></u></b>
							NO.SKET/" . $nosur . "/KESWA/" . $bulan . "/" . $thn . "</p>
							</td>
						</tr>

					</table>
					<table class=\"table-font-size2\">
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">
							Yang bertanda tangan dibawah ini menerangkan bahwa
							</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Nama</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($data_permintaan->nama)) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Tempat / Tanggal lahir </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ucwords(strtolower($data_permintaan->tmpt_lahir . ", " . date('d-m-Y', strtotime($data_permintaan->tgl_lahir)))) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Jenis Kelamin	 </td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . ($data_permintaan->sex == 'L' ? 'Laki-laki' : ($data_permintaan->sex == 'P' ? 'Perempuan' : 'Laki-laki / Perempuan')) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Alamat</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">" . strtolower($data_permintaan->alamat) . "</td>
						</tr>
						<tr>
							<td width=\"15%\"></td>
							<td width=\"20%\">Pendidikan</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">" . $data_permintaan->pendidikan . "</td>
						</tr>
						<tr>
						" . ($data_permintaan->nrp_sbg == 'T' ? '
									<td width=\"15%\"></td>
									<td width=\"20%\">Pekerjaan dan Kesatuan</td>
									<td width=\"2%\">:</td>
									<td width=\"63%\">' . $data_permintaan->pekerjaan . '/ ' . ($data_permintaan->kst_id == '' ? ($data_permintaan->kesatuan_ehr) : ($data_permintaan->kst_nama . ' | ' . $data_permintaan->kst2_nama . ' | ' . $data_permintaan->kst3_nama)) . '</td>
								' : '
							<td width=\"15%\"></td>
							<td width=\"20%\">Pekerjaan</td>
							<td width=\"2%\">:</td>
							<td width=\"63%\">' . ucwords(strtolower($data_permintaan->pekerjaan)) . '</td>
						') . "
						</tr>

						<tr>
						" . ($data_permintaan->nrp_sbg == 'T' ? '

							<td width=\"15%\"></td>
							<td width=\"20%\">Pangkat / NRP</td>
							<td width=\"2%\">:</td>
							<td width=\"68%\">' . ($data_permintaan->pkt_id != '' ? ($data_permintaan->pangkat . ' / ' . $data_permintaan->no_nrp) : ' ') . '</td>
								' : '<td> </td>') . "
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Saat ini <b>" . ($hasil == 'ada' ? 'kami dapatkan' : 'tidak kami dapatkan') . "</b> adanya psikopatologi tertentu " . ($hasil == 'ada' ? '(ada kelainan dibidang kejiwaan)' : '(tidak ada kelainan dibidang kejiwaan)') . " </td>
						</tr>

						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Keterangan ini diberikan untuk <b>" . $keterangan . "</b></td>
						</tr>
						<tr>
							<td width=\"10%\"></td>
							<td width=\"90%\">Harap yang berkepentingan maklum adanya</td>
						</tr>
					</table>

					<table style=\"width:100%;\">
						<tr>
							<td width=\"70%\" ></td>
							<td width=\"30%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>a.n. Kepala Rumkital Dr. Mintohardjo
								<br>Perwira Kesehatan <br>
								<br><br><br>
								" . ((int)$dokter == 60 ? '
									<u>Kol(Purn)dr.Eunice.P.N.Psikiater</u><br>
									SIP.20/2.104/31.71.07/-1.779.3/e/2016 '
				: ((int)$dokter == 61 ? '
									<u>Kol(Purn)dr.Pramudya.P.Psikiater</u><br>
									SIP.23/2.104/31.71.07/-1.779.3/e/2016 '
					: ((int)$dokter == 185 ? '
									<u>dr.Fransiska Drie N. SpKJ</u><br>
									Kapten Laut (K/W) NRP. 15729/P '
						: ((int)$dokter == 62 ? '
									<u>dr. Rudyhard E. Hutagalung, SpKJ</u><br>
									Letkol Laut (K) NRP 14087/P '
							:
							'<u>dr.Eliyati D.Rosadi,SpKJ (K)</u><br>
									SIP.12/2.104/31.71.07/-1.779.3/e/2017')))) . "
								</p>
							</td>
						</tr>
					</table>
					";


		$file_name = "SKSJ.pdf";

		// echo $kontens;
		// break;
		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '7', '5', '5');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$contentt = $kontens;
		ob_end_clean();
		$obj_pdf->writeHTML($kontens);
		$obj_pdf->Output(FCPATH . '/download/irj/rjcpelayanan/surat_jiwa/' . $file_name, 'FI');
	}


	public function pelayanan_tindakan_view($id_poli = '', $no_register = '', $tab = '', $param3 = '', $param4 = '')
	{
		$data['controller'] = $this;
		$data['view'] = 1;
		// cek rujukan penunjang
		$data['rujukan_penunjang'] = $this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();

		//cek status lab dan resep
		$data['a_lab'] = "open";
		$data['a_pa'] = "open";
		$data['a_obat'] = "open";
		$data['a_rad'] = "open";
		$result = $this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab == "0" || $result->status_lab == "1") {
			$data['a_lab'] = "closed";
		}
		if ($result->pa == "0" || $result->status_pa == "1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat == "0" || $result->status_obat == "1") {
			$data['a_obat'] = "closed";
		}
		if ($result->rad == "0" || $result->status_rad == "1") {
			$data['a_rad'] = "closed";
		}
		if ($result->em == "0" || $result->status_em == "1") {
			$data['a_em'] = "closed";
		}

		//ambil data runjukan
		$no_medrecrad = $this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		
		$data['cetak_lab_pasien'] = $this->rjmpelayanan->getcetak_lab_pasien($no_medrecrad)->result();
		$data['list_pa_pasien'] = array();
		$data['cetak_pa_pasien'] = array();
		
		$data['cetak_rad_pasien'] = $this->rjmpelayanan->getcetak_rad_pasien($no_medrecrad)->result();
	
		$data['cetak_resep_pasien'] = $this->rjmpelayanan->getcetak_resep_pasien($no_medrecrad)->result();
		$data['pelayan'] = '';


		$data['list_resep_pasien'] = $this->rjmpelayanan->getdata_resep_pasien_new_by_noreg($no_register)->result();
		$data['list_lab_pasien'] = $this->rjmpelayanan->getdata_lab_pasien_new_by_noreg($no_register)->result();
		$data['list_rad_pasien'] = $this->rjmpelayanan->getdata_rad_pasienrj_new_by_noreg($no_register)->result();
		$data['list_ok_pasien'] = $this->rjmpelayanan->getdata_ok_pasienrj_new_by_noreg($no_medrecrad)->result();

		//get id_poli & no_medrec
		$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['kelas_pasien'] = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['tgl_kun'] = $data['data_pasien_daftar_ulang']->tgl_kunjungan;
		$data['cara_bayar'] = $data['data_pasien_daftar_ulang']->cara_bayar;
		$data['idrg'] = 'IRJ';
		$data['bed'] = 'Rawat Jalan';

		$data['data_diagnosa_pasien'] = $this->rjmpelayanan->getdata_diagnosa_pasien($data['no_medrec'])->result();
		$data['data_tindakan_pasien'] = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid'] = '';

		//to disabled print button
		foreach ($data['data_tindakan_pasien'] as $row) {
			if ($row->bayar == '0') {
				$data['unpaid'] = '1';
			}
		}
		$data['id_poli'] = $id_poli;

		$nm_poli = $this->rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;

		$data['no_register'] = $no_register;
		$data['title'] = 'Pelayanan Rawat Jalan | ' . $nm_poli;

		$data['poliklinik'] = $this->rjmpencarian->get_poliklinik()->result();
		$data['tindakan'] = $this->rjmpelayanan->get_tindakan($data['kelas_pasien'], substr($id_poli, 0, 2))->result(); //get tindakan yang ada pada tabel tarif dan sesuai kelas
		if ($id_poli == 'BQ00') {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli_BQ00()->result();
		} else
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		$data['diagnosa'] = $this->rjmpencarian->get_diagnosa()->result();
		$data['tgl_kunjungan'] = $data['data_pasien_daftar_ulang']->tgl_kunjungan;
		//data untuk tab laboratorium------------------------------
		$data['data_pemeriksaan'] = $this->labmdaftar->get_data_pemeriksaan($no_register, $data['no_medrec'])->result();
		$data['dokter_lab'] = $this->labmdaftar->getdata_dokter()->result();
		$data['tindakan_lab'] = $this->labmdaftar->getdata_tindakan_pasien()->result();

		//data untuk tab patalogi anatomi------------------------------
		$data['data_pemeriksaan'] = $this->pamdaftar->get_data_pemeriksaan($no_register, $data['no_medrec'])->result();
		$data['dokter_pa'] = $this->pamdaftar->getdata_dokter()->result();
		$data['tindakan_pa'] = array();

		//data untuk tab radiologi---------------------------------------
		$data['dokter_rad'] = $this->radmdaftar->getdata_dokter()->result();
		$data['tindakan_rad'] = $this->radmdaftar->getdata_tindakan_pasien()->result();
		$data['data_tindakan_racikan'] = '';
		$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($data['no_medrec'])->result();

		//data untuk tab obat--------------------------------------------
		$result = $this->rjmpelayanan->get_no_resep($no_register)->result();
		$data['no_resep'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_resep($no_register)->row()->no_resep);
		$data['data_obat'] = $this->Frmmdaftar->get_data_resep()->result();
		$data['data_obat_pasien'] = $this->Frmmdaftar->getdata_resep_pasien($no_register, $data['no_resep'])->result();

		/*$data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
		foreach($data['get_data_markup'] as $row){
			$data['kdmarkup']=$row->kodemarkup;
			$data['ketmarkup']=$row->ket_markup;
			$data['fmarkup']=$row->markup;
		}
		$data['ppn']=1.1;*/
		//---------------------------------------------------------
		$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();

		//print_r($data['data_fisik']);die();
		// var_dump($data['data_fisik']);die();

		if ($data['data_fisik'] == FALSE) {
			$data['td'] = '';
			$data['bb'] = '';
			$data['tb'] = '';
			$data['nadi'] = '';
			$data['suhu'] = '';
			$data['rr'] = '';
			//$data['ku']='';

			$data['catatan'] = '';

			$data['subjective'] = '';
			$data['objective'] = '';
			$data['assesment'] = '';
			$data['plan'] = '';
			$data['tindakan'] = '';
			$data['diag_kerja'] = '';
			$data['diag_banding'] = '';
		} else {
			$data['td'] = $data['data_fisik']->sitolic.'/'.$data['data_fisik']->diatolic;
			$data['bb'] = $data['data_fisik']->bb;
			$data['tb'] = '';
			$data['nadi'] = $data['data_fisik']->nadi;
			$data['suhu'] = $data['data_fisik']->suhu;
			$data['rr'] = $data['data_fisik']->rr;
			//$data['ku']=$data['data_fisik']->ku;
			$data['catatan'] = $data['data_fisik']->catatan;

			// $data['subjective'] = $data['data_fisik']->subjective;
			// $data['objective'] = $data['data_fisik']->objective;
			// $data['assesment'] = $data['data_fisik']->assesment;
			// $data['plan'] = $data['data_fisik']->plan;
			// $data['tindakan'] = $data['data_fisik']->tindakan;
			// $data['diag_kerja'] = $data['data_fisik']->diag_kerja;
			// $data['diag_banding'] = $data['data_fisik']->diag_banding;
		}

		$result = $this->rjmpelayanan->get_no_lab($no_register)->result();
		$data['no_lab'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_lab($no_register)->row()->no_lab);
		$result = $this->rjmpelayanan->get_no_pa($no_register)->result();
		$data['no_pa'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_pa($no_register)->row()->no_pa);
		$result = $this->rjmpelayanan->get_no_rad($no_register)->result();
		$data['no_rad'] = ($result == array() ? '' : $this->rjmpelayanan->get_no_rad($no_register)->row()->no_rad);

		if ($tab == '' || $tab == 'tindakan') {
			$data['tab_tindakan'] = "active";
			$data['tab_fisik'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_prosedur'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_pa'] = "";
			$data['tab_rad'] = "";
			$data['tab_resep'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		} else if ($tab == "fis") {
			$data['tab_tindakan'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_fisik'] = "active";
			$data['tab_prosedur'] = "";

			$data['tab_pa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_resep'] = "";
			$data['tab_rad'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		} else if ($tab == "prosedur") {
			$data['tab_tindakan'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_prosedur'] = "active";
			$data['tab_fisik'] = "";
			$data['tab_pa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_resep'] = "";
			$data['tab_rad'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		} else if ($tab == "diag") {
			$data['tab_tindakan'] = "";
			$data['tab_diagnosa'] = "active";
			$data['tab_prosedur'] = "";
			$data['tab_fisik'] = "";
			$data['tab_pa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_resep'] = "";
			$data['tab_rad'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		} else if ($tab == "lab") {
			$data['no_lab'] = $param3;
			$data['tab_tindakan'] = "";
			$data['tab_prosedur'] = "";
			$data['tab_fisik'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_lab'] = "active";
			$data['tab_pa'] = "";
			$data['tab_rad'] = "";
			/*if($no_lab!='')
			{
				$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register, $no_lab)->result();
				$data['no_lab']=$no_lab;
			}else {	if($this->labmdaftar->get_data_pemeriksaan($no_register)->row()->no_lab!=''){
					$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_pemeriksaan']='';
				}
			}
			*/

			$data['tab_resep'] = "";
			$data['tab_prosedur'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		} else if ($tab == "pa") {
			$data['no_pa'] = $param3;
			$data['tab_prosedur'] = "";
			$data['tab_tindakan'] = "";
			$data['tab_fisik'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_pa'] = "active";
			$data['tab_rad'] = "";
			/*if($no_lab!='')
			{
				$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register, $no_lab)->result();
				$data['no_lab']=$no_lab;
			}else {	if($this->labmdaftar->get_data_pemeriksaan($no_register)->row()->no_lab!=''){
					$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register)->result();
				}else{
					$data['data_pemeriksaan']='';
				}
			}
			*/

			$data['tab_resep'] = "";
			$data['tab_obat'] = '';
			$data['tab_racikan'] = "";
		} else if ($tab == 'rad') {

			$no_rad = $param3;
			if ($no_rad != '') {
				$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($no_register)->result();
				$data['no_rad'] = $no_rad;
			} else {
				if ($this->radmdaftar->get_data_pemeriksaan($no_register)->row()->no_rad != '') {
					$data['data_rad_pasien'] = $this->radmdaftar->get_data_pemeriksaan($no_register)->result();
				} else {
					$data['data_rad_pasien'] = '';
				} //$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();

			}
			$data['tab_tindakan'] = "";
			$data['tab_prosedur'] = "";
			$data['tab_fisik'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_pa'] = "";
			$data['tab_rad'] = "active";
			$data['tab_resep'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_obat'] = 'active';
			$data['tab_racikan']  = '';
		} else if ($tab == "resep") {
			$no_resep = $param3;
			$data['tab_tindakan'] = "";
			$data['tab_prosedur'] = "";
			$data['tab_fisik'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_pa'] = "";
			$data['tab_rad'] = "";
			$data['tab_resep'] = "active";
			if ($no_resep != '') {

				$data['data_obat_pasien'] = $this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();
				$data['data_tindakan_racikan'] = $this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
				$data['no_resep'] = $no_resep;
			} else {
				if ($this->rjmpelayanan->getdata_resep_pasien($no_register)->row()->no_resep != '') {
					$data['no_resep'] = $this->rjmpelayanan->getdata_resep_pasien($no_register)->result();
				} else {
					$data['data_obat_pasien'] = '';
				}
			}
			$data['tab_obat'] = "active";
			$data['tab_racikan'] = "";
			if ($param4 != '') {
				$data['tab_obat'] = "";
				$data['tab_racikan'] = "active";
			}
		}
		if ($data['data_fisik'] == FALSE) {
			$data['tab_tindakan'] = "";
			$data['tab_fisik'] = "active";
			$data['tab_prosedur'] = "";
			$data['tab_diagnosa'] = "";
			$data['tab_lab'] = "";
			$data['tab_med'] = "";
			$data['tab_pa'] = "";
			$data['tab_rad'] = "";
			$data['tab_resep'] = "";
			$data['tab_obat'] = "";
			$data['tab_racikan'] = "";
		}

		/*{
			$data['tab_tindakan']="";
			$data['tab_diagnosa']="active";
		}
		*/
		$this->load->view('irj/rjvpelayanan_view', $data);
	}

	public function list_rawat_jalan()
	{
		$data['title'] = 'List Pasien Rawat Jalan ' . date('d-m-Y');
		$data['cara_bayar'] = $this->rjmpencarian->get_cara_bayar()->result();
		$data['pasien_daftar'] = $this->rjmpencarian->get_list_rawat_jalan()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		if ($data['roleid'] == '1' || $data['roleid'] == '25' || $data['roleid'] == '22') {
			$data['access'] = 1;
		} else {
			$data['access'] = 0;
		}
		// $data['id_poli']=$id_poli;
		if (sizeof($data['pasien_daftar']) == 0) {
			$this->session->set_flashdata('message_nodata', '<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		} else {
			$this->session->set_flashdata('message_nodata', '');
		}

		$this->load->view('irj/rjvlistrawatjalan', $data);
	}

	public function get_data_by_register()
	{
		$no_register = $this->input->post('no_register');
		$datajson = $this->rjmpencarian->get_data_by_register($no_register)->result();
		echo json_encode($datajson);
	}
	public function edit_cara_bayar()
	{
		$no_register = $this->input->post('no_reg_hidden');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['id_kontraktor'] = $this->input->post('id_kontraktor');
		if ($data['cara_bayar'] == "UMUM") {
			$data['id_kontraktor'] = "";
		}
		//	print_r($data);die();
		$this->rjmpencarian->edit_cara_bayar($no_register, $data);

		redirect('irj/rjcpelayanan/list_rawat_jalan');
		//print_r($data);
	}

	public function cetak_resume($no_cm = '')
	{
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		// echo $top_header;die();
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		// $logo_kesehatan_header=
		// var_dump($data['logo_header']);die();
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;

		$data['data_pasien_irj'] = $this->rjmregistrasi->get_data_ringkas_medik_rj($no_cm)->result();
		$this->load->view('CETAK_RESUME', $data);
	}

	public function surat_kontrol($no_register = '')
	{
		$data['data_kontrol'] = $this->rjmpelayanan->get_v_data_kontrol($no_register);

		if ($this->rjmpelayanan->get_diagnosa_by_noreg($no_register)->result() != null) {
			$data['diagnosa_kontrol'] = $this->rjmpelayanan->get_diagnosa_by_noreg($no_register)->result();
		} else {
			$data['diagnosa_kontrol'] = array();
		}
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
		$data_rajal = $this->M_emedrec->get_data_daftar_ulang_by_no_reg($no_register)->row();
		$data['data_daftar_ulang_rawat_jalan'] = $data_rajal;

		$nipeg_dokter_sip = isset($data_rajal->id_dokter) ? $data_rajal->id_dokter : '';
		$data['nipeg_dokter'] = isset($nipeg_dokter_sip) ? $this->M_emedrec->data_nipeg_by_id($nipeg_dokter_sip)->row() : "";
		// var_dump($data['nipeg_dokter']);
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
		if ($data_rajal->cara_bayar == 'BPJS') {
			$surat_kontrol = $this->M_emedrec->get_surat_kontrol_bysepasal($data_rajal->no_sep);

			if (isset($surat_kontrol->surat_kontrol)) {
				$data['surat_kontrol_bpjs'] = $surat_kontrol->surat_kontrol;
			}
		}


		$this->load->view('SURAT_KONTROL', $data);
	}

	public function surat_konsul($no_register = '')
	{
		// $data['data_kontrol'] = $this->rjmpelayanan->get_v_data_kontrol($no_register);
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

		$data['data_konsul'] = $this->rjmpelayanan->get_data_konsul_by_noreg($no_register)->row();

		$this->load->view('LEMBAR_KONSUL', $data);
	}

	public function surat_jawaban_konsul($no_register = '')
	{
		// $data['data_kontrol'] = $this->rjmpelayanan->get_v_data_kontrol($no_register);
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
		// var_dump($no_register);
		// var_dump($no_cm);
		// die();
		$no_regis_lama = $this->rjmpelayanan->get_data_daftar_ulang_by_no_reg($no_register)->row()->no_register_lama;
		$data['data_pasien'] = $this->rjmpelayanan->get_data_pasien_by_no_medrec($no_cm)->result();

		$data['data_konsul'] = $this->rjmpelayanan->get_data_jawab_konsul_by_noreg($no_regis_lama)->result();

		$data['konsul_dokter'] = 'jawab';
		$this->load->view('LEMBAR_KONSUL', $data);
	}

	public function cetak_asesmen_awal_keperawatan($no_cm = '', $no_register = '')
	{
		// $cm=$this->input->post('no_cm');
		// $no_reg=$this->input->post('no_register');
		//var_dump($no_reg);die();
		$data['kode_document'] = $this->rjmpelayanan->get_kode_document('assesment_keperawatan_poliklinik')[0]->kode_rm;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['asesmen_keperawatan'] = $this->rjmpelayanan->get_data_asesmen_keperawatan($no_register)->result();
		// var_dump( $data['asesmen_keperawatan']);die();
		$data['asesmen_masalah_keperawatan'] = $this->rjmpelayanan->get_data_asesmen_masalah_keperawatan($no_register)->result();
		$data['data_pasien'] = $this->rjmpelayanan->get_data_pasien_by_no_cm($no_cm)->result();
		$data['data_rawat_jalan'] = $this->rjmpelayanan->getdata_record_pasien_by_no_reg($no_register)->result();
		$this->load->view('emedrec/rj/formassesmentkeperawatan/asesmen_awal_keperawatan', $data);
	}

	public function insert_assesment_gigi()
	{
		$data['xcreate'] = date('Y-m-d');
		$data = $this->input->post();
		// if ($data['adaalergiobat']) {
		// 	$data['alergi_obat'] = $data['adaalergiobat'];
		// }
		// if ($data['adaalergimakan']) {
		// 	$data['alergi_makan'] = $data['adaalergimakan'];
		// }
		if ($data['diastema_value']) {
			$data['diastema'] = $data['diastema_value'];
		}
		if ($data['gigianomali_value']) {
			$data['gigi_anomali'] = $data['gigianomali_value'];;
		}
		unset($data['gigianomali_value']);
		unset($data['diastema_value']);
		unset($data['adaalergimakan']);
		unset($data['adaalergiobat']);
		// cek available data in db
		$check_data = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($data['no_register']);
		if ($check_data->num_rows()) {
			return $this->rjmpelayanan->update_assesment_gigi($data);
		} else {
			return $this->rjmpelayanan->insert_assesment_gigi($data);
		}
	}

	public function insert_procedure()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_register = $this->input->post('noreg_procedure');
		$procedure_text = $this->input->post('procedure_text');
		// var_dump($this->input->post());
		$cek_utama = $this->rjmpelayanan->count_utama_procedure($no_register);
		if ($cek_utama > 0) {
			$klasifikasi = 'tambahan';
		} else {
			$klasifikasi = 'utama';
		}

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$id_procedure = '';
		$procedure = '';

		if ($this->input->post('id_procedure') != '') {
			$postprocedure = explode("@", $this->input->post('procedure_separate'));
			$id_procedure = $postprocedure[0];
			$nm_procedure = $postprocedure[1];
		}

		$data_insert = array(
			'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
			'no_register' => $no_register,
			'id_poli' => $this->input->post('id_poli'),
			'id_dokter' => $this->input->post('id_dokter'),
			'nm_dokter' => $this->input->post('dokter'),
			'id_procedure' => $id_procedure,
			'nm_procedure' => $nm_procedure,
			'procedure_text' => $procedure_text,
			'klasifikasi_procedure' => $klasifikasi,
			'xuser' => $user,
			'xupdate' => date('Y-m-d H:i:s')
		);
		$result = $this->rjmpelayanan->insert_procedure($data_insert);
		echo $result;
	}

	public function insert_soap()
	{
		$no_register = $this->input->post('no_register');
		$response = '';
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rjmpelayanan->get_soap_pasien($no_register);
		$data = json_decode($this->input->post('formjson_perawat'));
		// var_dump($data->objective_rajal);die();


		$soap['subjective_perawat'] = json_encode($data->subjective_rajal);
		$soap['objective_perawat'] = json_encode($data->objective_rajal);
		$soap['assesment_perawat'] = json_encode($data->assesmen_rajal);
		$soap['plan_perawat'] = json_encode($data->plan_rajal);
		// var_dump($soap);die();
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rjmpelayanan->update_soap_pasien($soap, $no_register);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			// $soap = $this->input->post();
			$soap['tgl_input'] = date('Y-m-d H:i:s');
			$soap['nm_pemeriksa'] = $login_soap->name;
			$soap['ttd_pemeriksa'] = $login_data->ttd;
			$submitdata = $this->rjmpelayanan->insert_soap_pasien($soap);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}


	public function update_rujukan_penunjang_ok()
	{
		$id_poli = $this->input->post('id_poli');
		$no_register = $this->input->post('no_register');


		$data['ok'] = 1;
		$data['status_ok'] = 0;
		$data['jadwal_ok'] = date("Y-m-d");
		// $data['jadwal_ok']=$this->input->post('jadwal');

		//add poli anastesi
		$data2['id_poli'] = 'CD00';

		$datenow = '';
		$data_sblm = $this->rjmpelayanan->getdata_daftar_sblm($no_register)->result();
		foreach ($data_sblm as $row) {

			$data2['no_medrec'] = $row->no_medrec;
			$datenow = date('Y-m-d H:i:s');
			$data2['tgl_kunjungan'] = $datenow;
			$data2['jns_kunj'] = $row->jns_kunj;
			$data2['umurrj'] = $row->umurrj;
			$data2['uharirj'] = $row->uharirj;
			$data2['ublnrj'] = $row->ublnrj;
			$data2['asal_rujukan'] = $row->asal_rujukan;
			$data2['no_rujukan'] = $row->no_rujukan;
			$data2['kelas_pasien'] = $row->kelas_pasien;
			$data2['cara_bayar'] = $row->cara_bayar;
			$data2['id_kontraktor'] = $row->id_kontraktor;
			$data2['nama_penjamin'] = $row->nama_penjamin;
			$data2['hubungan'] = $row->hubungan;
			$data2['vtot'] = $row->vtot;
			$data2['no_sep'] = $row->no_sep;
		}

		$data2['cara_kunj'] = "RUJUKAN POLI";
		$login_data = $this->load->get_var("user_info");
		$data2['xcreate'] = $login_data->username;
		$data2['vtot'] = 0;
		$data2['biayadaftar'] = 0;


		//print_r($data2);
		$id = $this->rjmregistrasi->insert_daftar_ulang($data2);

		//echo($id->no_register);
		$data4['timein'] = date('Y-m-d H:i:s');
		$data4['status'] = 2;
		$id1 = $this->rjmtracer->update_mappasien($no_register, $data4);

		$noreg = $this->rjmregistrasi->get_noreg_pasien($data2['no_medrec'])->row()->noreg;

		$data2['no_register'] = $noreg;
		$data6['no_register'] = $noreg;
		$data6['no_medrec'] = $data2['no_medrec'];
		$data6['id_poli'] = $data2['id_poli'];
		$data5['timeout'] = date('Y-m-d H:i:s');
		$data6['status'] = 1;
		$data6['tiperawat'] = 'IRJ';
		$this->insert_tindakan3($data2);
		$id2 = $this->rjmtracer->insert_mappasien($data6);


		$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

		// $success = 	'<div class="alert alert-success">
		//                 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		//                     	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
		//                	</div>';


		// $this->session->set_flashdata('success_msg', $success);

		echo json_encode(array('status' => 'success'));
	}

	public function update_rujukan_penunjang_lab()
	{
		$id_poli = $this->input->post('idrg');
		// var_dump($id_poli);die();
		$no_register = $this->input->post('no_register');
		$pelayan = $this->input->post('pelayan');

		if ($no_register == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			}
		} else {
			$data['lab'] = 1;
			// $data['status_lab']=0;
			$data['jadwal_lab'] = date("Y-m-d");
			// $data['jadwal_lab']=$this->input->post('jadwal_lab');


			$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

			if ($id == true) {
				redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}

		redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
	}

	public function update_rujukan_penunjang_rad()
	{
		$id_poli = $this->input->post('idrg');
		$no_register = $this->input->post('no_register');
		$pelayan = $this->input->post('pelayan');

		if ($no_register == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			}
		} else {
			$data['rad'] = 1;
			// $data['status_rad']=0;
			$data['jadwal_rad'] = date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');


			$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

			if ($id == true) {
				redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}
	}

	public function update_rujukan_penunjang_em()
	{
		$id_poli = $this->input->post('idrg');
		$no_register = $this->input->post('no_register');
		$pelayan = $this->input->post('pelayan');

		if ($no_register == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
			}
		} else {
			$data['em'] = 1;
			// $data['status_em']=0;
			$data['jadwal_em'] = date("Y-m-d");
			// $data['jadwal_rad']=$this->input->post('jadwal');

			$id = $this->rjmpelayanan->update_rujukan_penunjang($data, $no_register);

			if ($id == true) {
				redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}
	}

	public function insert_gigi()
	{
		var_dump($this->input->post());
	}

	public function cetak_surat_ket_sakit()
	{
		// $cm=$this->input->post('no_cm');
		// $no_reg=$this->input->post('user_id');
		// $medrec=$this->input->post('no_medrec');
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		// $data['data_pasien']=$this->M_emedrec->get_data_pasien_by_no_cm($cm)->result();
		// $data['data_rawat_darurat'] = $this->M_emedrec->getdata_record_pasien_by_no_reg($no_reg)->result();
		// $data['data_fungsional'] = $this->M_emedrec->getdata_record_data_fungsional($no_reg)->result();
		// var_dump($data['data_fungsional']);
		$this->load->view('surat_kesehatan/suket_sakit', $data);
	}

	public function cetak_surat_kesehatan_jiwa($noreg = "")
	{
		$no_register = $noreg;
		// var_dump($no_register);
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['data_permintaan'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_suket_kesehatan'] = $this->rjmpelayanan->getdata_suket($no_register)->row();
		$id_dokter = $data['data_permintaan']->id_dokter;
		$tgl_lahir = $data['data_permintaan']->tgl_lahir;
		$data['data_dokter'] = $this->rjmpelayanan->getdata_dokter($id_dokter)->row();
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");
		$data['thn'] = (int)date('Y') - (int)date('Y', strtotime($tgl_lahir));

		$this->load->view('surat_kesehatan/kesehatan_jiwa', $data);
	}

	public function cetak_surat_kesehatan($noreg = "")
	{

		$no_register = $noreg;
		// var_dump($no_register);
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['data_permintaan'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_suket_kesehatan'] = $this->rjmpelayanan->getdata_suket($no_register)->row();
		$id_dokter = $data['data_permintaan']->id_dokter;
		$tgl_lahir = $data['data_permintaan']->tgl_lahir;
		$data['data_dokter'] = $this->rjmpelayanan->getdata_dokter($id_dokter)->row();
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");
		$data['thn'] = (int)date('Y') - (int)date('Y', strtotime($tgl_lahir));

		$this->load->view('surat_kesehatan/suket_kesehatan', $data);
	}

	public function cetak_suket_bebas_narkoba($noreg = "")
	{
		$no_register = $noreg;
		// var_dump($no_register);
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['data_permintaan'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['data_suket_kesehatan'] = $this->rjmpelayanan->getdata_suket($no_register)->row();
		$id_dokter = $data['data_permintaan']->id_dokter;
		$tgl_lahir = $data['data_permintaan']->tgl_lahir;
		$data['data_dokter'] = $this->rjmpelayanan->getdata_dokter($id_dokter)->row();
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");
		$data['thn'] = (int)date('Y') - (int)date('Y', strtotime($tgl_lahir));
		$this->load->view('surat_kesehatan/suket_bebas_narkoba', $data);
	}


	public function cetak_surat_keterangan_st_narkoba()
	{
		//  var_dump($this->input->post());die();
		$data['no_register'] = $this->input->post('no_register');
		//
		$data['pemeriksaan_narkoba'] = $this->input->post('pemeriksaan_narkoba');

		$data['tgl_input'] = date("Y-m-d H:i:s");
		$check_data = $this->rjmpelayanan->load_data_surat_tindakan($data['no_register']);
		if ($check_data->num_rows()) {
			return $this->rjmpelayanan->update_data_surat_tindakan($data, $data['no_register']);
		} else {
			return $this->rjmpelayanan->insert_data_surat_kesehatan($data);
		}
	}

	public function get_poli_bpjs($poli)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpelayanan->get_poliklinik_bpjs($poli));
	}

	public function get_dokter_by_poli($id_poli)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rjmpelayanan->get_dokter_by_poli($id_poli));
	}

	public function eretensi($norm)
	{
		$clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
		header('Content-Type: application/json; charset=utf-8');

		$response = $clients->request(
			'GET',
			'http://192.168.206.50/emr/data/index_rssn.php?do=list&no_rm=' . $norm,
		)->getBody()->getContents();
		echo $response;
	}

	public function rasal()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rjmpelayanan->get_data_rasal($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('rasal_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rjmpelayanan->update_rasal($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('rasal_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rjmpelayanan->insert_rasal($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function raslan()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rjmpelayanan->get_data_raslan($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('raslan_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rjmpelayanan->update_raslan($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('raslan_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rjmpelayanan->insert_raslan($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function gyssens()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rjmpelayanan->get_data_gyssens($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('gyssens_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rjmpelayanan->update_gyssens($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('gyssens_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rjmpelayanan->insert_gyssens($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function raspatur()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rjmpelayanan->get_data_raspatur($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('raspatur_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rjmpelayanan->update_raspatur($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('raspatur_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rjmpelayanan->insert_raspatur($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function iadl()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rjmpelayanan->get_data_iadl($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('iadl_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rjmpelayanan->update_iadl($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('iadl_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rjmpelayanan->insert_iadl($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function edukasi_penolakan_rencana_asuhan()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rjmpelayanan->get_edukasi_penolakan_rencana_asuhan($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('edukasi_penolakan_rencana_asuhan_json');
			$result = $this->rjmpelayanan->update_edukasi_penolakan_rencana_asuhan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('edukasi_penolakan_rencana_asuhan_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_edukasi_penolakan_rencana_asuhan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}


	public function nihss()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rjmpelayanan->get_nihss($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('nihss_json');
			$result = $this->rjmpelayanan->update_nihss($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('nihss_json');
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rjmpelayanan->insert_nihss($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	// add sjj 2024
	public function form($kode, $id_poli, $no_register)
	{

		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['users'] = $login_data;
		$data['id_poli'] = 'BA00';
		$data['pelayan']='PERAWAT';
		$data['statfisik'] = 'show';
		$data['view'] = 0;
		//$data['statfisik'] = 'hide';
		$data['staff'] = 'perawat';

		$data['no_register'] = $no_register;
		$datenow = date('Y-m-d');
		$no_medrecrad = $this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		$data['no_cm']=$data['data_pasien_daftar_ulang']->no_cm;
		$data['kelas_pasien'] = $data['data_pasien_daftar_ulang']->kelas_pasien;
		$data['cara_bayar'] = $data['data_pasien_daftar_ulang']->cara_bayar;
		$data['id_dokterrawat'] = $data['data_pasien_daftar_ulang']->id_dokter;
		$data['id_poli'] = $data['data_pasien_daftar_ulang']->id_poli;
		$data['data_tindakan_pasien'] = $this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['unpaid'] = '';

		$data['a_lab'] = "open";
		$data['a_pa'] = "open";
		$data['a_obat'] = "open";
		$data['a_rad'] = "open";
		$data['a_ok'] = "open";
		$data['a_fisio'] = "open";
		$data['a_em'] = "open";
		$result = $this->rjmpelayanan->cek_pa_lab_rad_resep($no_register)->row();
		if ($result->lab == "0" || $result->status_lab == "1") {
			$data['a_lab'] = "closed";
		}
		if ($result->ok == "0" || $result->status_ok == "1") {
			$data['a_ok'] = "closed";
		}
		if ($result->pa == "0" || $result->status_pa == "1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat == "0" || $result->status_obat == "1") {
			$data['a_obat'] = "closed";
		}
		if ($result->rad == "0" || $result->status_rad == "1") {
			$data['a_rad'] = "closed";
		}
		if ($result->fisio == "0" || $result->status_fisio == "1") {
			$data['a_fisio'] = "closed";
		}
		if ($result->em == "0" || $result->status_em == "1") {
			$data['a_em'] = "closed";
		}

		if ($id_poli == 'BW01') {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan'] = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
		}

		if ($id_poli == 'BG00') {
			$data['gigi'] = $this->rjmpelayanan->load_data_assesment_gigi_by_noreg($no_register);
		}
		//added amel
		if ($id_poli == 'BK01' || $id_poli == 'BK02' || $id_poli == 'BK07' || substr($id_poli, 0, 2) == 'BV') {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter()->result();
		} else {
			$data['dokter_tindakan2'] = $this->rjmpelayanan->get_dokter_poli2($id_poli)->result();
		}

		//to disabled print button
		foreach ($data['data_tindakan_pasien'] as $row) {
			if ($row->bayar == '0') {
				$data['unpaid'] = '1';
			}
		}
		$no_register_lama=$this->rjmpelayanan->get_no_register_lama($no_register)->row();
		$data['data_pasien'] = $this->rjmpelayanan->getdata_pasien($no_medrecrad)->row();
		$views = $this->Mmformigd->get_form_by_kode_irj($kode)->row()->views;
		// var_dump($views);die();


		switch ($kode) {
			case 'pem_fisik':
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;

			case 'pengkajian_keperawatan':
				$data['data_keperawatan'] = $this->rjmpelayanan->get_pengkajian_rawat_jalan($no_register)->row();
				$data['data_fisik'] = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
				break;
			
			case 'assesment_medik_dok':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				break;
			
			case 'operasi':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_ok_pasien'] = $this->rjmpelayanan->getdata_ok_pasien($no_register, $datenow)->result();
				break;
			case 'lab':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();
				break;
				break;
			case 'rad':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();
				break;
			case 'em':
				$data['get_soap'] = $this->rjmpelayanan->get_soap_pasien($no_register)->result();
				$data['list_em_pasien'] = $this->rjmpelayanan->getdata_em_pasienrj($no_register, $datenow)->result();
				$data['cetak_em_pasien'] = $this->rjmpelayanan->getcetak_em_pasien($no_register)->result();
				break;
			case 'resep':
				$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->row();
				$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register,$datenow)->result();
				$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
				$data['list_resep_pasien_konsul']=$this->rjmpelayanan->getdata_resep_pasien($no_register_lama->no_register_lama,$datenow)->result();
				break;
			case 'tindakan':
				$data['idpokdiet'] = '';
				$data['users'] = $this->rimtindakan->get_users()->result();
				if ($this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()) {
					$data['idpokdiet'] = $this->rjmpelayanan->get_pasien_recorddiet($data['no_medrec'])->row()->idpokdiet;
				}
				if ($data['kelas_pasien'] == 'EKSEKUTIF') {
					$kelasnya = 'VVIP';
				} else {
					$kelasnya = 'III';
				}
				$data['tindakans'] = $this->rjmpelayanan->getdata_jenis_tindakan_new($id_poli)->result();;
				break;
			case 'resep_mata':
				$data['resep_mata'] = $this->rjmpelayanan->get_resep_mata($no_register)->row();
				break;
			case 'pembedahan':
				$data['pembedahan'] = $this->rjmpelayanan->get_resep_mata($no_register)->row();
				break;
			case 'lembar_fisik_rehab':
				$data['fisik_rehab'] = $this->rjmpelayanan->get_lembar_kedokteran_fisik_rehab($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['procedure']=$this->rjmpelayanan->get_procedur_for_pengkajian_medis($no_register)->result();
				break;
			case 'uji_fungsi_rehab':
				$data['uji_fungsi_rehab'] = $this->rjmpelayanan->get_hasil_uji_fungsi_rehab($no_register)->row();
				// var_dump($data['uji_fungsi_rehab']);die();
				$data['diagnosa']=$this->rjmpelayanan->get_diagnosa($no_register)->row();
				break;
			case 'program_terapi_rehab':
				$data['program_terapi_rehab'] = $this->rjmpelayanan->get_program_terapi_rehab($no_register)->row();
				// var_dump($data['uji_fungsi_rehab']);die();
				$data['diagnosa']=$this->rjmpelayanan->get_diagnosa($no_register)->row();
				break;
			case 'keperawatan_anak':
				$data['keperawatan_anak'] = $this->rjmpelayanan->get_pengkajian_keperawatan_anak($no_register)->row();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['diagnosa']=$this->rjmpelayanan->get_diagnosa($no_register)->row();
				break;
			case 'keperawatan_obgyn':
				$data['keperawatan_obgyn'] = $this->rjmpelayanan->get_kep_obgyn($no_register)->row();
				break;
			case 'medik_anak':
				$data['medik_anak'] = $this->rjmpelayanan->get_pengkajian_medik_anak($no_register)->row();
				$data['pemeriksaan_fisik'] = $this->rjmpelayanan->get_pemfisik_rj($no_register)->row();
				$data['lab']=$this->rdmpelayanan->get_lab_for_pengkajian_medis($no_register)->result();
				$data['rad']=$this->rdmpelayanan->get_rad_for_pengkajian_medis($no_register)->result();
				$data['diagnosa']=$this->rdmpelayanan->get_diag_for_pengkajian_medis($no_register)->result();
				$data['soap_pasien_rj'] = $this->rjmpelayanan->get_soap_pasien($no_register)->row();
				break;
			case 'lap_pembedahan':
				$data['laporan_pembedahan'] = $this->rjmpelayanan->get_laporan_pembedahan($no_register)->row();
				break;
	
			
			
		}
		return $this->load->view($views, $data);
	}

	// add sjj 2024

	public function pengkajian_rawat_jalan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_reg = $this->input->post('no_register');
		$data_note = $this->rjmpelayanan->get_pengkajian_rawat_jalan($no_reg);
		if ($data_note->num_rows()) {
			if($data_note->row()->id_pemeriksa2){
				$data['formjson'] = $this->input->post('pengkajian_keperawatan_json');
				$result = $this->rjmpelayanan->update_pengkajian_rawat_jalan($no_reg, $data);
				$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
			}else{
				$data['formjson'] = $this->input->post('pengkajian_keperawatan_json');
				$data['id_pemeriksa2'] = $login_data->userid;
				$data['tgl_input2'] = date('Y-m-d H:i:s');
				$result = $this->rjmpelayanan->update_pengkajian_rawat_jalan($no_reg, $data);
				$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
			}
			
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$data['formjson'] = $this->input->post('pengkajian_keperawatan_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$result = $this->rjmpelayanan->insert_pengkajian_rawat_jalan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function get_biaya_tindakan_new()
	{
		// var_dump($this->input->post());die();
		$id_tindakan = $this->input->post('id_tindakan');
		
		$result = $this->rjmpelayanan->getdata_jenis_tindakan_new_by_id($id_tindakan)->row();
	
		$biaya['tarif'] = $result->tarif;
		$biaya['kualifikasi'] = $result->tmno;
		echo json_encode($biaya);
	}

	function select2s_diagnosa(){  
		header('Content-Type: application/json; charset=utf-8');

        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->rjmpelayanan->select2s_diagnosa($q);
        }
    }


}
