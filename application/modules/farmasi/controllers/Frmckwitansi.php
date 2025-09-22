<?php
defined('BASEPATH') or exit('No direct script access allowed');

include('Frmcterbilang.php');

// require_once(APPPATH.'controllers/Secure_area.php');
class Frmckwitansi extends Secure_area
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
		$this->load->model('farmasi/Frmmkwitansi', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('irj/rjmkwitansi', '', TRUE);
	}
	public function index()
	{
		// $cterbilang=new rjcterbilang();
		// echo $cterbilang->terbilang(100);
		redirect('farmasi/Frmcdaftar', 'refresh');
	}

	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Farmasi';
		$data['daftar_farmasi'] = $this->Frmmkwitansi->get_list_kwitansi_rj_luar()->result();
		if (sizeof($data['daftar_farmasi']) == 0) {
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
		$this->load->view('farmasi/frmvkwitansi', $data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Farmasi';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$key = $this->input->post('key');
			$data['daftar_farmasi'] = $this->Frmmkwitansi->get_list_kwitansi_by_no($key)->result();

			if (sizeof($data['daftar_farmasi']) == 0) {
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
			$this->load->view('farmasi/frmvkwitansi', $data);
		} else {
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Farmasi';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$date = $this->input->post('date');
			$data['daftar_farmasi'] = $this->Frmmkwitansi->get_list_kwitansi_by_date_rj($date)->result();
			if (sizeof($data['daftar_farmasi']) == 0) {
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
			$this->load->view('farmasi/frmvkwitansi', $data);
		} else {
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_resep = '')
	{
		$data['title'] = 'Cetak Kwitansi Farmasi';
		if ($no_resep != '') {
			$data['no_resep'] = $no_resep;

			$data['data_pasien'] = $this->Frmmkwitansi->get_data_pasien($no_resep)->row();
			if (substr($data['data_pasien']->no_register, 0, 2) == 'PL') {
				$data_adm = $this->Frmmkwitansi->get_data_adm_pasien_luar()->row();
				$data['data_adm'] = $this->Frmmkwitansi->get_detail_tindakan($data_adm->idtindakan)->row();
			} else {
				$data['data_adm'] = array();
			}
			$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			if (sizeof($data['data_permintaan']) == 0) {
				$this->session->set_flashdata('message_no_tindakan', '<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>2
							  </div>
							</div>
						</div>');
			} else {
				$this->session->set_flashdata('message_no_tindakan', '');
			}

			$this->load->view('farmasi/frmvkwitansipasien', $data);
		} else {
			//printf("redirect");
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}

	public function kwitansi_pasien_rj($no_register = '')
	{
		$data['title'] = 'Cetak Kwitansi Farmasi';
		//if($no_resep!=''){
		//$data['no_resep']=$no_resep;
		if (substr($no_register, 0, 2) == 'RJ') {
			$data['data_pasien'] = $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row();
			$data['kelas'] = $data['data_pasien']->kelas_pasien;
		}
		if (substr($no_register, 0, 2) == 'PL') {
			$data_adm = $this->Frmmkwitansi->get_data_adm_pasien_luar()->row();
			$data['data_adm'] = $this->Frmmkwitansi->get_detail_tindakan($data_adm->idtindakan)->row();
			$data['data_pasien'] = $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
		} else {
			$data['data_adm'] = array();
		}
		$data['embalase'] = $this->Frmmkwitansi->get_embalase_pasien($no_register)->row();
		$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan_rj_detail($no_register)->result();
		// if(sizeof($data['data_permintaan'])==0){
		// 	$this->session->set_flashdata('message_no_tindakan','<div class="row">
		// 				<div class="col-md-12">
		// 				  <div class="box box-default box-solid">
		// 					<div class="box-header with-border">
		// 					  <center>Tidak Ada Tindakan</center>
		// 					</div>2
		// 				  </div>
		// 				</div>
		// 			</div>');
		// }else{
		// 	$this->session->set_flashdata('message_no_tindakan','');
		// }
		//$data['jumlah_vtot'] = $data['data_permintaan']->vtot_obat;
		$this->load->view('farmasi/frmvkwitansipasien', $data);
		// }else{
		// 	//printf("redirect");
		// 	redirect('farmasi/Frmckwitansi/kwitansi');
		// }
	}

	public function faktur_pasien($no_resep = '')
	{
		$data['title'] = 'Cetak Kwitansi Farmasi';
		if ($no_resep != '') {
			$data['no_resep'] = $no_resep;

			$data['data_pasien'] = $this->Frmmkwitansi->get_data_pasien($no_resep)->row();
			$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			if (sizeof($data['data_permintaan']) == 0) {
				$this->session->set_flashdata('message_no_tindakan', '<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>
							  </div>
							</div>
						</div>');
			} else {
				$this->session->set_flashdata('message_no_tindakan', '');
			}

			$this->load->view('farmasi/frmvfakturpasien', $data);
		} else {
			//printf("redirect");
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}


	public function st_cetak_kwitansi_kt_()
	{
		$no_register = $this->input->post('no_register'); //asalnya no resep
		$data_pasien = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
		if ($this->input->post('penyetor') == "") {
			$data_pasien = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
			$penyetor = $data_pasien->nama;
		} else {
			$penyetor = $this->input->post('penyetor');
		}
		$totakhir = $this->input->post('totakhir');
		//$no_register=$this->input->post('no_register');
		$xuser = $this->input->post('xuser');
		$diskon = $this->input->post('diskon_hide');

		if ($diskon == "") {
			$diskon = 0;
		} else {
			$diskon = $this->input->post('diskon_hide');
		}

		//$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$getvtotobat = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_permintaan_rj($no_register)->row()->vtot_obat : $this->Frmmkwitansi->get_data_permintaan_luar($no_register)->row()->vtot_obat;
		$vtotobat = intval($getvtotobat);
		// var_dump($vtotobat);
		// die();

		// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
		//$penyetor=$data_pasien->nama;
		$kasir = $this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket'] = $kasir->kasir;
		$nomor = $this->Frmmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		//$no_register=$this->input->post('no_register');
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$datak['no_kwitansi'] = sprintf("%08d", ($nomor->no_kwitansi + 1));
		$datak['idno_kwitansi'] = sprintf("%08d", ($nomor->no_kwitansi + 1));
		$datak['xuser'] = $user;
		$datak['xcreate'] = date('Y-m-d H:i:s');
		$datak['no_register'] = $no_register;
		$datak['nama_poli'] = 'ADM';
		$datak['diskon'] = $diskon;
		$datak['vtot_bayar'] = $vtotobat;
		$datak['tunai'] = $vtotobat - $diskon;
		$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');
		$datak['asal'] = substr($no_register, 0, 2) == 'RJ' ? $data_pasien->id_poli : 'PASIEN LUAR';
		$this->Frmmkwitansi->insert_nomorkwitansi($datak);

		$datank['no_register'] = $no_register;
		$datank['idno_kwitansi'] = sprintf("%06d", ($nomor->no_kwitansi + 1));
		$datank['user_cetak'] = $user;
		$datank['tgl_cetak'] = date('Y-m-d H:i:s');
		$datank['jenis_kwitansi'] = 'Farmasi';
		$datank['dp'] = 0;
		$datank['diskon'] = $diskon;
		$datank['vtot_bayar'] = $vtotobat;
		$datank['tunai'] = $vtotobat - $diskon;
		$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
		$datank['asal'] = substr($no_register, 0, 2) == 'RJ' ? $data_pasien->id_poli : 'PASIEN LUAR';
		$this->Frmmkwitansi->insert_nokwitansi($datank);

		// $data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register, 0, 2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';
			} else {
				$component_id = '01';
			}
		} else {
			$component_id = '03';
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = isset($data_pasien->no_medrec) ? $data_pasien->no_medrec : null;
		$datares['pasien_name'] = isset($data_pasien->nama) ? $data_pasien->nama : null;
		$datares['dob'] = isset($data_pasien->tgl_lahir) ? $data_pasien->tgl_lahir : null;
		$datares['gender'] = isset($data_pasien->sex) ? $data_pasien->sex : null;
		$datares['gol_darah'] = isset($data_pasien->goldarah) ? $data_pasien->goldarah : null;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		$datares['component_id'] = isset($data_pasien->id_poli) ? $data_pasien->id_poli : null;
		$datares['method_pay'] = $this->input->post('pembayaran_hide');
		// $datares['kode_unit_poli'] = isset($data_pasien->id_poli)?$data_pasien->id_poli:null;
		$datares['nama_dokter'] = isset($data_pasien->nm_dokter) ? $data_pasien->nm_dokter : null;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$datank['vtot_bayar'];
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Farmasi';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);


		$getrdrj = substr($no_register, 0, 2);

		// if($getrdrj=="PL"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$vtotobat,$no_resep);
		// 	//print_r('PL Cetak');
		// } else if($getrdrj=="RJ"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$vtotobat,$no_resep);
		// }
		// else if ($getrdrj=="RD"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$vtotobat,$no_resep);
		// }
		// else if ($getrdrj=="RI"){
		// 	$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
		// 	foreach($data_iri as $row){
		// 		$status_obat=$row->status_obat;
		// 	}
		// 	$status_obat = $status_obat + 1;
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_obat,$vtotobat,$no_resep);
		// }

		if ($this->input->post('diskon_hide') != '') {
			if ($this->input->post('totakhir') != '') {
				$totakhir = $this->input->post('totakhir');
			}
			$cookiediskon = 'document.cookie = "diskon=' . $diskon . '";';
		} else $cookiediskon = 'document.cookie = "diskon=0";';

		//$this->Frmmkwitansi->update_status_cetak_kwitansi($no_resep,$diskon,$no_register,$xuser);
		$this->Frmmkwitansi->update_status_cetak_kwitansi($no_register);

		// echo '<script type="text/javascript">'.$cookiediskon.'document.cookie= "xuser='.$xuser.'";window.open("'.site_url("farmasi/Frmckwitansi/cetak_kwitansi_kt/$no_resep").'", "_blank");window.focus()</script>';

		redirect('farmasi/Frmckwitansi/cetak_kwitansi_kt' . '/' . $no_register . '/' . $penyetor . '/' . $diskon, 'refresh');
		//print_r($no_resep);

	}

	public function st_cetak_kwitansi_kt()
	{
		$no_register = $this->input->post('no_register'); //asalnya no resep
		$data_pasien = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
		if ($this->input->post('penyetor') == "") {
			$data_pasien = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
			$penyetor = $data_pasien->nama;
		} else {
			$penyetor = $this->input->post('penyetor');
		}
		$totakhir = $this->input->post('totakhir');
		//$no_register=$this->input->post('no_register');
		$xuser = $this->input->post('xuser');
		$diskon = $this->input->post('diskon_hide');

		if ($diskon == "") {
			$diskon = 0;
		} else {
			$diskon = $this->input->post('diskon_hide');
		}

		//$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$getvtotobat = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_permintaan_rj($no_register)->row()->vtot_obat : $this->Frmmkwitansi->get_data_permintaan_luar($no_register)->row()->vtot_obat;
		$vtotobat = intval($getvtotobat);
		// var_dump($vtotobat);
		// die();

		// $data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
		//$penyetor=$data_pasien->nama;
		$kasir = $this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket'] = $kasir->kasir;
		$nomor = $this->Frmmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		//$no_register=$this->input->post('no_register');
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$datak['no_kwitansi'] = sprintf("%08d", ($nomor->no_kwitansi + 1));
		$datak['idno_kwitansi'] = sprintf("%08d", ($nomor->no_kwitansi + 1));
		$datak['xuser'] = $user;
		$datak['xcreate'] = date('Y-m-d H:i:s');
		$datak['no_register'] = $no_register;
		$datak['nama_poli'] = 'ADM';
		$datak['diskon'] = $diskon;
		$datak['vtot_bayar'] = $vtotobat;
		$datak['tunai'] = $vtotobat - $diskon;
		$datak['jenis_bayar'] = $this->input->post('pembayaran_hide');
		$datak['asal'] = substr($no_register, 0, 2) == 'RJ' ? $data_pasien->id_poli : 'PASIEN LUAR';
		$this->Frmmkwitansi->insert_nomorkwitansi($datak);

		$datank['no_register'] = $no_register;
		$datank['idno_kwitansi'] = sprintf("%06d", ($nomor->no_kwitansi + 1));
		$datank['user_cetak'] = $user;
		$datank['tgl_cetak'] = date('Y-m-d H:i:s');
		$datank['jenis_kwitansi'] = 'Farmasi';
		$datank['dp'] = 0;
		$datank['diskon'] = $diskon;
		$datank['vtot_bayar'] = $vtotobat;
		$datank['tunai'] = $vtotobat - $diskon;
		$datank['jenis_bayar'] = $this->input->post('pembayaran_hide');
		$datank['asal'] = substr($no_register, 0, 2) == 'RJ' ? $data_pasien->id_poli : 'PASIEN LUAR';
		$this->Frmmkwitansi->insert_nokwitansi($datank);

		// $data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register, 0, 2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';
			} else {
				$component_id = '01';
			}
		} else {
			$component_id = '03';
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = isset($data_pasien->no_medrec) ? $data_pasien->no_medrec : null;
		$datares['pasien_name'] = isset($data_pasien->nama) ? $data_pasien->nama : null;
		$datares['dob'] = isset($data_pasien->tgl_lahir) ? $data_pasien->tgl_lahir : null;
		$datares['gender'] = isset($data_pasien->sex) ? $data_pasien->sex : null;
		$datares['gol_darah'] = isset($data_pasien->goldarah) ? $data_pasien->goldarah : null;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		$datares['component_id'] = isset($data_pasien->id_poli) ? $data_pasien->id_poli : null;
		$datares['method_pay'] = $this->input->post('pembayaran_hide');
		// $datares['kode_unit_poli'] = isset($data_pasien->id_poli)?$data_pasien->id_poli:null;
		$datares['nama_dokter'] = isset($data_pasien->nm_dokter) ? $data_pasien->nm_dokter : null;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$datank['vtot_bayar'];
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Farmasi';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);


		$getrdrj = substr($no_register, 0, 2);

		// if($getrdrj=="PL"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$vtotobat,$no_resep);
		// 	//print_r('PL Cetak');
		// } else if($getrdrj=="RJ"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$vtotobat,$no_resep);
		// }
		// else if ($getrdrj=="RD"){
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$vtotobat,$no_resep);
		// }
		// else if ($getrdrj=="RI"){
		// 	$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
		// 	foreach($data_iri as $row){
		// 		$status_obat=$row->status_obat;
		// 	}
		// 	$status_obat = $status_obat + 1;
		// 	$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_obat,$vtotobat,$no_resep);
		// }

		if ($this->input->post('diskon_hide') != '') {
			if ($this->input->post('totakhir') != '') {
				$totakhir = $this->input->post('totakhir');
			}
			$cookiediskon = 'document.cookie = "diskon=' . $diskon . '";';
		} else $cookiediskon = 'document.cookie = "diskon=0";';

		//$this->Frmmkwitansi->update_status_cetak_kwitansi($no_resep,$diskon,$no_register,$xuser);
		$this->Frmmkwitansi->update_status_cetak_kwitansi($no_register);

		// echo '<script type="text/javascript">'.$cookiediskon.'document.cookie= "xuser='.$xuser.'";window.open("'.site_url("farmasi/Frmckwitansi/cetak_kwitansi_kt/$no_resep").'", "_blank");window.focus()</script>';

		redirect('farmasi/Frmckwitansi/cetak_kwitansi_kt' . '/' . $no_register . '/' . $penyetor . '/' . $diskon, 'refresh');
		//print_r($no_resep);

	}

	// public function st_cetak_faktur_kt()
	// {
	// 	$no_resep=$this->input->post('no_resep');
	// 	$nmdokter=$this->input->post('nmdokter');

	// 	$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	//   //$penyetor=$data_pasien->nama;


	// 	$no_register=$this->input->post('no_register');

	// 	$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
	// 	$getrdrj=substr($no_register, 0,2);

	// 	if($getrdrj=="PL"){
	// 		$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat);
	// 		//print_r('PL Cetak');
	// 	} else if($getrdrj=="RJ"){
	// 		$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);
	// 	}
	// 	else if ($getrdrj=="RD"){
	// 		$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat);
	// 	}
	// 	else if ($getrdrj=="RI"){
	// 		$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
	// 		foreach($data_iri as $row){
	// 			$status_obat=$row->status_obat;
	// 		}
	// 		$status_obat = $status_obat + 1;
	// 		$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_obat,$getvtotobat);
	// 	}



	// 	$tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

	// 	$this->Frmmdaftar->update_data_header($no_resep, $nmdokter, $tot_tuslah);

	// 	if ($this->input->post('diskon_hide')!='') 
	// 	{
	// 		$diskon=$this->input->post('diskon_hide');
	// 		if($this->input->post('totakhir')!=''){
	// 			$totakhir=$this->input->post('totakhir');
	// 		}
	// 		$cookiediskon='document.cookie = "diskon='.$diskon.'";';
	// 	} else $cookiediskon='document.cookie = "diskon=0";';

	// 	echo '<script type="text/javascript">'.$cookiediskon.';window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';



	// 	redirect('farmasi/Frmckwitansi/','refresh');
	// 	//print_r($tot_tuslah);

	// }


	public function st_cetak_faktur_kt()
	{
		$no_resep = $this->input->post('no_resep');
		$nmdokter = $this->input->post('nmdokter');


		$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->row();

		//   print_r($data_pasien);die();
		//$penyetor=$data_pasien->nama;


		$no_register = $this->input->post('no_register');

		$getvtotobat = $this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$vtotobat = intval($getvtotobat);
		//	print_r($getvtotobat);die();

		$getrdrj = substr($no_register, 0, 2);

		if ($getrdrj == "PL") {
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register, $vtotobat);
			//print_r('PL Cetak');
		} else if ($getrdrj == "RJ") {
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register, $vtotobat);
		} else if ($getrdrj == "RD") {
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register, $vtotobat);
		} else if ($getrdrj == "RI") {
			$data_iri = $this->Frmmdaftar->getdata_iri($no_register)->result();
			foreach ($data_iri as $row) {
				$status_obat = $row->status_obat;
			}
			$status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register, $status_obat, $vtotobat);
		}



		$tot_tuslah = 0; //$this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

		$this->Frmmdaftar->update_data_header($no_resep, $nmdokter, $tot_tuslah);

		if ($this->input->post('diskon_hide') != '') {
			$diskon = $this->input->post('diskon_hide');
			if ($this->input->post('totakhir') != '') {
				$totakhir = $this->input->post('totakhir');
			}
			$cookiediskon = 'document.cookie = "diskon=' . $diskon . '";';
		} else $cookiediskon = 'document.cookie = "diskon=0";';

		echo '<script type="text/javascript">' . $cookiediskon . ';window.open("' . site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep") . '", "_blank");window.focus()</script>';



		redirect('farmasi/Frmckwitansi/', 'refresh');
		//print_r($tot_tuslah);

	}

	public function st_selesai_bayar($no_register = '')
	{

		$getrdrj = substr($no_register, 0, 2);

		if ($getrdrj == "PL") {
			$this->Frmmdaftar->selesai_bayar_PL($no_register);
			//print_r('PL Cetak');
		} else if ($getrdrj == "RJ") {
			$this->Frmmdaftar->selesai_bayar_IRJ($no_register);
		} else if ($getrdrj == "RD") {
			$this->Frmmdaftar->selesai_bayar_IRD($no_register);
		} else if ($getrdrj == "RI") {
			$data_iri = $this->Frmmdaftar->getdata_iri($no_register)->result();
			foreach ($data_iri as $row) {
				$status_obat = $row->status_obat;
			}
			$status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_bayar_IRI($no_register, $status_obat);
		}


		//echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';

		redirect('farmasi/Frmcdaftar/', 'refresh');
		//print_r($tot_tuslah);

	}

	public function cetak_faktur_resep_kt()
	{
		$no_resep = $this->input->post('no_resep');
		$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->row();

		if ($no_resep != '') {

			//$this->no_labmdaftar->update_status_cetak_hasil($no_no_lab);
			echo '<script type="text/javascript">window.open("' . site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep") . '", "_blank");window.history.back();</script>';

			//redirect('lab/labcpengisianhasil/','refresh');
		} else {
			//redirect('lab/labcpengisianhasil/','refresh');
		}
	}

	public function cetak_faktur_kt_mama($no_resep = '')
	{
		error_reporting(~E_ALL);
		//UNTUK GET NO_REGISTER
		$a = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
		foreach ($a as $row) {
			$no_register = $row->no_register;
		}
		$data_tindakan_racik = $this->Frmmkwitansi->getdata_resep_racik($no_register)->result();
		//END GET REGISTER
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");


		$namars = $this->config->item('namars');
		$kota_kab = $this->config->item('kota');
		$alamatrs = $this->config->item('alamat');
		$telp = $this->config->item('telp');
		$nmsingkat = $this->config->item('namasingkat');

		if ($no_resep != '') {
			$cterbilang = new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
			$diskon = 0;

			$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			foreach ($data_pasien as $row) {
				$nama = $row->nama;
				$no_register = $row->no_register;
				$no_medrec = $row->no_medrec;
				$no_cm = $row->no_cm;
				$bed = $row->bed;
				$cara_bayar = $row->cara_bayar;
			}

			$data_header = $this->Frmmdaftar->getnama_dokter_poli($no_register)->result();
			foreach ($data_header as $row) {
				$nmdokter = $row->nmdokter;
			}


			if (substr($no_register, 0, 2) == "PL") {
				$data_ruang = $this->Frmmkwitansi->getdata_ruang($idrg)->result();

				foreach ($data_ruang as $row) {
					$nmruang = 'Pasien Luar';
				}
			}
			$data_permintaan = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();



			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//cetak resep
			if ($cara_bayar == 'BPJS') {
				$konten =
					"
				<style type=\"text/css\">
				.table-font-size{
					font-size:7px;
				    }
				.table-font-size1{
					font-size:7px;
					padding : 5px 0px 0px 0px;
				    }
				.table-font-size2{
					font-size:8px;
					margin : 5px 1px 1px 1px;
					padding : 5px 1px 1px 1px;
				    }
				</style>
				<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"60%\" style=\" font-size:7px;\"><font style=\"font-size:8px\">$namars</font><br>$alamatrs $kota_kab $telp
							</td>						
						</tr>						
					</table>
					<hr>
					<table class=\"table-font-size\">
						<tr>
							<td><p align=\"right\">Tanggal-Jam: $tgl_jam</p></td>
						</tr>
					</table>
				<table class=\"table-font-size1\">				
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">$cara_bayar</td>
						
					</tr>
					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>
					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>
					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"50%\">$bed</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
					
				</table>
				<br><br>
				<table class=\"table-font-size1\"border=\"0.5\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"40%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"30%\"><p align=\"center\">Signa</p></th>
						<th  width=\"20%\"><p align=\"center\">Banyak</p></th>
					</tr>
				";


				$i = 1;
				$jumlah_vtot = 0;

				foreach ($data_permintaan as $row) {
					$jumlah_vtot += $row->vtot;
					$vtot = number_format($row->vtot, 2, ',', '.');
					$konten = $konten . "<tr>
									  <td><p  align=\"center\">$i</p></td>
									  <td><p align=\"center\">$row->nama_obat
									   ";
					foreach ($data_tindakan_racik as $row1) {
						if ($row->id_resep_pasien == $row1->id_resep_pasien) {
							echo '<br>- ' . $row1->nm_obat . ' (' . $row1->qty . ')';

							$konten .= "
                                            <br>- $row1->nm_obat ($row1->qty)";
						}
					}

					$konten .= "
                                      </p></td>
									  <td><p align=\"center\">$row->signa</p></td>
									  <td><p align=\"center\">$row->qty</p></td>
									</tr>";
					$i++;
				}
				$total_akhir = (int) (1000 * ceil($jumlah_vtot / 1000));
				$vtot_terbilang = $cterbilang->terbilang($total_akhir);

				$konten = $konten . "
						
						<tr>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"center\">Jumlah   </p></th>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"right\">" . number_format($total_akhir, 2, ',', '.') . "</p></th>
						</tr>
						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\"><b>Terbilang:</b> " . $vtot_terbilang . "</p></th>
						</tr>
					</table>						
					<p class=\"table-font-size\" align=\"right\">Biaya yang dibayar oleh pasien sebesar 0 rupiah<br>(Ditanggung BPJS)</p>
					<p></p>

				<table border=\"0\">
				<tr>
				<th width=\"50%\">
				<table class=\"table-font-size1\"border=\"0.5\">
					<tr>
						<th width=\"10%\"><p align=\"center\">No.</p></th>
						<th width=\"30%\"><p align=\"center\">Screening Klinis</p></th>
						<th width=\"10%\"><p align=\"center\">Ya</p></th>
						<th width=\"10%\"><p align=\"center\">Tidak</p></th>
						<th width=\"25%\"><p align=\"center\">Tindak Lanjut</p></th>
					</tr>

					<tr>
						<td><p align=\"center\">1</p></td>
						<td><p align=\"left\">Ketepatan Indikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">2</p></td>
						<td><p align=\"left\">Ketepatan Dosis</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">3</p></td>
						<td><p align=\"left\">Ketepatan Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">4</p></td>
						<td><p align=\"left\">Waktu Penggunaan</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">5</p></td>
						<td><p align=\"left\">Duplikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">6</p></td>
						<td><p align=\"left\">Alergi Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">7</p></td>
						<td><p align=\"left\">Kontra Indikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">8</p></td>
						<td><p align=\"left\">Interaksi Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">9</p></td>
						<td><p align=\"left\">Efek Samping Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				</th>

				<th width=\"50%\">
				<table class=\"table-font-size1\"border=\"0.5\">

					<tr>
						<td colspan=\"4\"><p align=\"center\"><b>INDIKATOR MUTU - RESPON TIMES <br> PELAYANAN OBAT RACIK/JADI</b></p></td>
					</tr>
					<tr>
						<td colspan=\"2\"><p align=\"center\">Waktu Terima</p></td>
						<td colspan=\"2\"><p align=\"center\">Waktu Penyerahan</p></td>
					</tr>
					<tr>
						<td colspan=\"2\"></td>
						<td colspan=\"2\"></td>
					</tr>
					<tr>
						<td><p align=\"center\">Petugas Farmasi</p></td>
						<td><p align=\"center\">Pasien/Kel</p></td>
						<td><p align=\"center\">Petugas Farmasi</p></td>
						<td><p align=\"center\">Pasien/Kel</p></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<p align=\"center\">Penelaah</p>
					
					<p align=\"center\">(..........................................)</p>
				</table>
				</th>

				</tr>
				</table>
				";
			} else {
				$konten =
					"<style type=\"text/css\">
				.table-font-size{
					font-size:7px;
				    }
				.table-font-size1{
					font-size:7px;
					padding : 5px 0px 0px 0px;
				    }
				.table-font-size2{
					font-size:8px;
					margin : 5px 1px 1px 1px;
					padding : 5px 1px 1px 1px;
				    }
				</style>
				<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"60%\" style=\" font-size:7px;\"><font style=\"font-size:8px\">$namars</font><br>$alamatrs $kota_kab $telp
							</td>						
						</tr>						
					</table>
					<hr>
					<table class=\"table-font-size\">
						<tr>
							<td><p align=\"right\">Tanggal-Jam: $tgl_jam</p></td>
						</tr>
					</table>
				<table class=\"table-font-size1\">
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">$cara_bayar</td>
					</tr>

					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>

					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>

					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"40%\">$bed</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
				</table>
				<br><br>

				<table class=\"table-font-size1\"border=\"0.5\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"30%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"30%\"><p align=\"center\">Signa</p></th>
						<th  width=\"10%\"><p align=\"center\">Banyak</p></th>
						<th  width=\"20%\"><p align=\"center\">Subtotal</p></th>
					</tr>
				";

				$i = 1;
				$jumlah_vtot = 0;
				foreach ($data_permintaan as $row) {
					$bulat = (int) (100 * ceil($row->vtot / 100));
					$jumlah_vtot = $jumlah_vtot + $bulat;
					$vtot = number_format($bulat, 2, ',', '.');

					$konten = $konten . "<tr>
									  <td><p align=\"center\">$i</p></td>
									  <td><p align=\"center\">$row->nama_obat
									   ";
					foreach ($data_tindakan_racik as $row1) {
						if ($row->id_resep_pasien == $row1->id_resep_pasien) {
							echo '<br>- ' . $row1->nm_obat . ' (' . $row1->qty . ')';

							$konten .= "
                                            <br>- $row1->nm_obat ($row1->qty)";
						}
					}

					$konten .= "
                                      </p></td>
									  <td><p align=\"center\">$row->signa</p></td>
									  <td><p align=\"center\">$row->qty</p></td>
									  <td><p align=\"right\">$vtot</p></td>
									</tr>";
					$i++;
				}


				$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);

				$konten = $konten . "
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"center\">Jumlah   </p></th>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"right\">" . number_format($jumlah_vtot, 2, ',', '.') . "</p></th>
						</tr>";
				//$totakhir=$jumlah_vtot-$diskon;
				$persen = $diskon / 100;
				$diskon_persen = $jumlah_vtot * $persen;
				$totakhir = $jumlah_vtot - $diskon_persen;
				if ($diskon != 0) {
					$konten = $konten . "
						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">" . number_format($totakhir, 2, ',', '.') . "</p></th>
						</tr>";
					$jumlah_vtot = $jumlah_vtot - $diskon_persen;
				}
				$vtot_terbilang = $cterbilang->terbilang($totakhir);

				$konten = $konten . "
				<tr>
					<th colspan=\"5\"><p class=\"table-font-size1\" align=\"right\"><b>Terbilang:</b> " . $vtot_terbilang . "</p></th>
				</tr>
				</table>
				<p></p>

				<table border=\"0\">
				<tr>
				<th width=\"50%\">
				<table class=\"table-font-size1\"border=\"0.5\">
					<tr>
						<th width=\"10%\"><p align=\"center\">No.</p></th>
						<th width=\"30%\"><p align=\"center\">Screening Klinis</p></th>
						<th width=\"10%\"><p align=\"center\">Ya</p></th>
						<th width=\"10%\"><p align=\"center\">Tidak</p></th>
						<th width=\"25%\"><p align=\"center\">Tindak Lanjut</p></th>
					</tr>

					<tr>
						<td><p align=\"center\">1</p></td>
						<td><p align=\"left\">Ketepatan Indikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">2</p></td>
						<td><p align=\"left\">Ketepatan Dosis</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">3</p></td>
						<td><p align=\"left\">Ketepatan Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">4</p></td>
						<td><p align=\"left\">Waktu Penggunaan</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">5</p></td>
						<td><p align=\"left\">Duplikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">6</p></td>
						<td><p align=\"left\">Alergi Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">7</p></td>
						<td><p align=\"left\">Kontra Indikasi</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">8</p></td>
						<td><p align=\"left\">Interaksi Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><p align=\"center\">9</p></td>
						<td><p align=\"left\">Efek Samping Obat</p></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				</th>

				<th width=\"50%\">
				<table class=\"table-font-size1\"border=\"0.5\">

					<tr>
						<td colspan=\"4\"><p align=\"center\"><b>INDIKATOR MUTU - RESPON TIMES <br> PELAYANAN OBAT RACIK/JADI</b></p></td>
					</tr>
					<tr>
						<td colspan=\"2\"><p align=\"center\">Waktu Terima</p></td>
						<td colspan=\"2\"><p align=\"center\">Waktu Penyerahan</p></td>
					</tr>
					<tr>
						<td colspan=\"2\"></td>
						<td colspan=\"2\"></td>
					</tr>
					<tr>
						<td><p align=\"center\">Petugas Farmasi</p></td>
						<td><p align=\"center\">Pasien/Kel</p></td>
						<td><p align=\"center\">Petugas Farmasi</p></td>
						<td><p align=\"center\">Pasien/Kel</p></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<p align=\"center\">Penelaah</p>
					
					<p align=\"center\">(..........................................)</p>
					
				</table>
				</th>
				</tr>
				</table><br><br>
					
				";
			}

			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\">Total   </p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$file_name = "SKT_$no_resep.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";

			$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'asset/font/Calibri.ttf', 'TrueTypeUnicode', '', 32);

			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('5', '5', '5');
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			//$obj_pdf->SetFont('courier', '', 10);
			$obj_pdf->SetFont($fontname, '', 12, '', false);
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

	public function cetak_faktur_kt($no_resep = '')
	{
		error_reporting(~E_ALL);
		$data['no_resep'] = $no_resep;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['a'] = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();

		foreach ($data['a'] as $row) {
			$data['no_register'] = $row->no_register;
		}
		$data['data_tindakan_racik'] = $this->Frmmkwitansi->getdata_resep_racik($data['no_register'])->result();
		//END GET REGISTER
		$data['tgl_jam'] = date("d-m-Y");
		$tgl = date("d-m-Y");

		$getrdrj = substr($data['no_register'], 0, 2);
		if ($getrdrj == "RJ") {
			$tuslah = 0; //$this->Frmmkwitansi->get_tuslah_irj($no_register)->row()->tuslah;
		} elseif ($getrdrj == "RI") {
			$tuslah = 0; //$this->Frmmkwitansi->get_tuslah_iri($no_register)->row()->tuslah;
		}
		if ($no_resep != '') {
			$data['cterbilang'] = new rjcterbilang();

			$diskon = 0;

			$data['data_pasien'] = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			foreach ($data['data_pasien'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_register'] = $row->no_register;
				$data['no_medrec'] = $row->no_medrec;
				$data['no_cm'] = $row->no_cm;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['alamat'] = $row->alamat;
			}

			$data['data_header'] = $this->Frmmdaftar->getnama_dokter_poli($data['no_register'])->result();
			foreach ($data['data_header'] as $row) {
				$data['nmdokter'] = $row->nmdokter;
			}
			if (substr($data['no_register'], 0, 2) == "PL") {
				// $data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				// foreach($data_ruang as $row){
				$nmruang = 'Pasien Luar';
				// }

			}
			$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('farmasi/paper_css/faktur_farmasi', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		}
	}


	public function cetak_faktur_kt_old($no_resep = '')
	{

		error_reporting(~E_ALL);
		//UNTUK GET NO_REGISTER
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$a = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();

		foreach ($a as $row) {
			$no_register = $row->no_register;
		}

		$data_tindakan_racik = $this->Frmmkwitansi->getdata_resep_racik($no_register)->result();
		//END GET REGISTER
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");


		$getrdrj = substr($no_register, 0, 2);
		if ($getrdrj == "RJ") {
			$tuslah = 0; //$this->Frmmkwitansi->get_tuslah_irj($no_register)->row()->tuslah;
		} elseif ($getrdrj == "RI") {
			$tuslah = 0; //$this->Frmmkwitansi->get_tuslah_iri($no_register)->row()->tuslah;
		}
		if ($no_resep != '') {
			$cterbilang = new rjcterbilang();

			$diskon = 0;

			$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			//	print_r($data_pasien);die();
			foreach ($data_pasien as $row) {
				$nama = $row->nama;
				$no_register = $row->no_register;
				$no_medrec = $row->no_medrec;
				$no_cm = $row->no_cm;
				$bed = $row->bed;
				$cara_bayar = $row->cara_bayar;
			}

			$data_header = $this->Frmmdaftar->getnama_dokter_poli($no_register)->result();

			//	print_r($data_header);die();
			foreach ($data_header as $row) {
				$nmdokter = $row->nmdokter;
			}


			if (substr($no_register, 0, 2) == "PL") {
				// $data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				// foreach($data_ruang as $row){
				$nmruang = 'Pasien Luar';
				// }

			}
			$data_permintaan = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();

			// echo $data_header;die();

			//cetak resep
			if ($cara_bayar == 'BPJS') {
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

				$konten =
					"
				<style type=\"text/css\">
				
				*{letter-spacing : 1px ; }

				.table-font-size{
					font-size:9px;
				    }
				.table-font-size1{
					font-size:9x;
					padding : 5px 0px 0px 0px;
				    }
				.table-font-size2{
					font-size:9px;
					margin : 5px 1px 1px 1px;
					padding : 5px 1px 1px 1px;
				    }
				</style>
				<font size=\"6\" align=\"right\">$tgl_jam</font><br>
				
					<hr>
				<table class=\"table-font-size1\">				
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">" . $cara_bayar . "</td>
						
					</tr>
					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>
					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td  width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>
					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"50%\">$bed</td>
						<td  width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
					
				</table>
				<br><br>
				<table class=\"table-font-size1\"border=\"0\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"30%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"30%\"><p align=\"center\">Signa</p></th>
						<th  width=\"10%\"><p align=\"center\">Banyak</p></th>
						<th  width=\"20%\"><p align=\"center\">Subtotal</p></th>
					</tr>
				";


				$i = 1;
				$jumlah_vtot = 0;

				foreach ($data_permintaan as $row) {
					$jumlah_vtot += $row->vtot;
					$vtot = number_format($row->vtot, 2, ',', '.');
					$konten = $konten . "<tr>
									  <td><p  align=\"center\">$i</p></td>
									  <td><p align=\"center\">$row->nama_obat
									   ";
					foreach ($data_tindakan_racik as $row1) {
						if ($row->id_resep_pasien == $row1->id_resep_pasien) {
							echo '<br>- ' . $row1->nm_obat . ' (' . $row1->qty . ')';

							$konten .= "
                                            <br>- $row1->nm_obat ($row1->qty)";
						}
					}

					$konten .= "
                                      </p></td>
									  <td><p align=\"center\">$row->signa</p></td>
									  <td><p align=\"center\">$row->qty</p></td>
									  <td><p align=\"right\">$vtot</p></td>
									</tr>";
					$i++;
				}
				$total_akhir = (int) (1000 * ceil($jumlah_vtot / 1000));
				//$total_akhir = (int) (($jumlah_vtot));
				$vtot_terbilang = $cterbilang->terbilang($total_akhir);

				$konten = $konten . "
						
						<tr>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"center\">Jumlah   </p></th>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"right\">" . number_format($total_akhir, 2, ',', '.') . "</p></th>
						</tr>
						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\"><b>Terbilang:</b> " . $vtot_terbilang . "</p></th>
						</tr>
					</table>						
					<p class=\"table-font-size\" align=\"right\">Biaya yang dibayar oleh pasien sebesar 0 rupiah<br>(Ditanggung BPJS)</p>
					<p></p>

				
				";
			} else {
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
				$konten =
					"<style type=\"text/css\">
				*{letter-spacing : 1px ; }
				.table-font-size{
					font-size:9px;
				    }
				.table-font-size1{
					font-size:9px;
					padding : 5px 0px 0px 0px;
				    }
				.table-font-size2{
					font-size:9px;
					margin : 5px 1px 1px 1px;
					padding : 5px 1px 1px 1px;
				    }
				</style>
				<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page
					<hr>
				<table class=\"table-font-size1\">
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">$cara_bayar</td>
					</tr>

					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>

					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>

					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"40%\">$bed</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
				</table>
				<br><br>

				<table class=\"table-font-size1\"border=\"0\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"30%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"30%\"><p align=\"center\">Signa</p></th>
						<th  width=\"10%\"><p align=\"center\">Banyak</p></th>
						<th  width=\"20%\"><p align=\"center\">Subtotal</p></th>
					</tr>
				";

				$i = 1;
				$jumlah_vtot = 0;
				foreach ($data_permintaan as $row) {
					//$bulat = (int) (100 * ceil($row->vtot / 100));
					$bulat = (int) (($row->vtot));
					$jumlah_vtot = $jumlah_vtot + $bulat;
					// $tuslah+=$row->tuslah;
					$vtot = number_format($bulat, 2, ',', '.');

					$konten = $konten . "<tr>
									  <td><p align=\"center\">$i</p></td>
									  <td><p align=\"center\">$row->nama_obat
									   ";
					foreach ($data_tindakan_racik as $row1) {
						if ($row->id_resep_pasien == $row1->id_resep_pasien) {
							echo '<br>- ' . $row1->nm_obat . ' (' . $row1->qty . ')';

							$konten .= "
                                            <br>- $row1->nm_obat ($row1->qty)";
						}
					}

					$konten .= "
                                      </p></td>
									  <td><p align=\"center\">$row->signa</p></td>
									  <td><p align=\"center\">$row->qty</p></td>
									  <td><p align=\"right\">$vtot</p></td>
									</tr>";
					$i++;
				}
				$jumlah_vtot += 0; // $tuslah;

				$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);

				$konten = $konten . "
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"center\">Jumlah   </p></th>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"right\">" . number_format($jumlah_vtot, 2, ',', '.') . "</p></th>
						</tr>";
				//$totakhir=$jumlah_vtot-$diskon;
				$persen = $diskon / 100;
				$diskon_persen = $jumlah_vtot * $persen;
				$totakhir = $jumlah_vtot - $diskon_persen;
				if ($diskon != 0) {
					$konten = $konten . "
						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">" . number_format($totakhir, 2, ',', '.') . "</p></th>
						</tr>";
					$jumlah_vtot = $jumlah_vtot - $diskon_persen;
				}
				$vtot_terbilang = $cterbilang->terbilang($totakhir);

				$konten = $konten . "
				<tr>
					<th colspan=\"5\"><p class=\"table-font-size1\" align=\"right\"><b>Terbilang:</b> " . $vtot_terbilang . "</p></th>
				</tr>
				</table>
				
					
				";
			}

			$file_name = "fobat_no_resep_$no_resep.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";

			$fontname = TCPDF_FONTS::addTTFfont(FCPATH . 'asset/font/Calibri.ttf', 'TrueTypeUnicode', '', 32);

			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('10', '10', '10');
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->SetFont($fontname, '', 12, '', false);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			// ob_start();
			ob_clean();
			ob_flush();
			$content = $konten;

			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH . 'download/farmasi/frmkwitansi/' . $file_name, 'FI');
			ob_end_flush();
			ob_end_clean();
		} else {
			redirect('farmasi/Frmcdaftar/', 'refresh');
		}
	}


	public function cetak_kwitansi_farmasi($no_register = '')
	{
		//if($no_register!=''){
		error_reporting(~E_ALL);

		$data['cterbilang'] = new rjcterbilang();

		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");



		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

		//$data['no_resep'] = $no_resep;
		$data['data_pasien'] = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();;
		$data['datpasien'] = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();;


		if ($penyetors == "" || $penyetors == null) {
			$data['penyetor'] = $data['datpasien']->nama;
		} else {
			$data['penyetor'] = $penyetors;
		}

		//foreach($data['data_pasien'] as $row){
		$data['nama'] = $data['data_pasien']->nama;
		$data['tgl_kunj'] = $data['data_pasien']->tgl_kunjungan;
		$data['sex'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->sex : $data['data_pasien']->jk;
		$data['goldarah'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->goldarah : '-';
		$data['no_register'] = $data['data_pasien']->no_register;
		$data['no_medrec'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->no_medrec : $data['data_pasien']->no_cm;
		$data['no_cm'] = $data['data_pasien']->no_cm;
		//$data['idrg']=$row->idrg;
		$data['bed'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->nm_poli : 'PASIEN LUAR'; //asalnya bed
		$data['cara_bayar'] = $data['data_pasien']->cara_bayar;
		//}

		$data['no_register'] = $data['datpasien']->no_register;
		$data['data_header'] = $this->Frmmdaftar->getnama_dokter_poli($data['no_register'])->result();
		// 	foreach($data['data_header'] as $row){
		// 		$data['nmdokter']=$row->nmdokter;	
		// 	}

		// if (substr($data['no_register'],0,2)=="PL"){
		// 		$data['nmruang']='Pasien Luar';
		// } 
		$data['embalase'] = $this->Frmmkwitansi->get_embalase_pasien($no_register)->row();
		$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan_rj_detail($no_register)->result();
		$data['no_kwitansi'] = $this->Frmmkwitansi->get_row_noKwitansi_by_register($data['no_register'])->row()->no_kwitansi;
		$data['nama_xuser'] = $this->Frmmkwitansi->get_nama_xuser_by_noreg($data['no_register'])->row()->xuser;
		//$data['jumlah_vtot'] = $data['data_permintaan']->vtot_obat;
		$data['diskon'] =  $diskon;
		$data['xuser'] = $diskon = $this->input->post('xuser');

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('farmasi/paper_css/kwitansi_farmasi_sementara', $data, true);
		//$this->mpdf->AddPage('L'); 
		// $mpdf->WriteHTML($html);
		// $mpdf->Output();
		echo $html;
	}

	public function cetak_kwitansi_kt($no_register = '', $penyetors = '', $diskon = "")
	{

		//if($no_register!=''){
		$data['cterbilang'] = new rjcterbilang();

		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");



		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

		//$data['no_resep'] = $no_resep;
		$data['data_pasien'] = substr($no_register, 0, 2) == 'RJ' ? $this->Frmmkwitansi->get_data_pasien_rj($no_register)->row() : $this->Frmmkwitansi->get_data_pasien_luar($no_register)->row();
		$data['datpasien'] = $data['data_pasien'];

		if ($penyetors == "" || $penyetors == null) {
			$data['penyetor'] = $data['datpasien']->nama;
		} else {
			$data['penyetor'] = $penyetors;
		}

		//foreach($data['data_pasien'] as $row){
		$data['nama'] = $data['data_pasien']->nama;
		$data['sex'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->sex : $data['data_pasien']->jk;
		$data['goldarah'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->goldarah : '-';
		$data['no_register'] = $data['data_pasien']->no_register;
		$data['no_medrec'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->no_medrec : $data['data_pasien']->no_cm;
		$data['no_cm'] = $data['data_pasien']->no_cm;
		//$data['idrg']=$row->idrg;
		$data['bed'] = substr($no_register, 0, 2) == 'RJ' ? $data['data_pasien']->nm_poli : 'PASIEN LUAR'; //asalnya bed
		$data['cara_bayar'] = $data['data_pasien']->cara_bayar;
		//}

		$data['no_register'] = $data['datpasien']->no_register;
		$data['data_header'] = $this->Frmmdaftar->getnama_dokter_poli($data['no_register'])->result();
		// 	foreach($data['data_header'] as $row){
		// 		$data['nmdokter']=$row->nmdokter;	
		// 	}

		// if (substr($data['no_register'],0,2)=="PL"){
		// 		$data['nmruang']='Pasien Luar';
		// } 
		$data['embalase'] = $this->Frmmkwitansi->get_embalase_pasien($no_register)->row();
		$data['data_permintaan'] = $this->Frmmkwitansi->get_data_permintaan_rj_detail($no_register)->result();
		$data['no_kwitansi'] = $this->Frmmkwitansi->get_row_noKwitansi_by_register($data['no_register'])->row()->no_kwitansi;
		$data['nama_xuser'] = $this->Frmmkwitansi->get_nama_xuser_by_noreg($data['no_register'])->row()->xuser;
		//$data['jumlah_vtot'] = $data['data_permintaan']->vtot_obat;
		$data['diskon'] =  $diskon;
		$data['xuser'] = $diskon = $this->input->post('xuser');
		//ob_clean();
		//flush();
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('farmasi/paper_css/kwitansi_farm', $data, true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// echo $html;
		// $mpdf->debug = true;
		// $this->load->view('paper_css/kwitansi_farm',$data);
		// } else{

		// }
	}


	public function cetak_kwitansi_kt_old($no_resep = '', $penyetors = '')
	{
		error_reporting(~E_ALL);
		if ($no_resep != '') {
			$cterbilang = new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/

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

			$data_pasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->result();
			$datpasien = $this->Frmmkwitansi->get_data_pasien($no_resep)->row();
			if ($penyetors == "" || $penyetors == null) {

				$penyetor = $datpasien->nama;
			} else {
				$penyetor = $penyetors;
			}

			foreach ($data_pasien as $row) {
				$nama = $row->nama;
				$sex = $row->sex;
				$goldarah = $row->goldarah;
				$no_register = $row->no_register;
				$no_medrec = $row->no_medrec;
				$no_cm = $row->no_cm;
				$idrg = $row->idrg;
				$bed = $row->bed;
				$cara_bayar = $row->cara_bayar;
			}

			$data_header = $this->Frmmdaftar->getnama_dokter_poli($no_register)->result();
			foreach ($data_header as $row) {
				$nmdokter = $row->nmdokter;
			}

			if (substr($no_register, 0, 2) == "PL") {
				$nmruang = 'Pasien Luar';
			}
			$data_permintaan = $this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			$no_kwitansi = $this->Frmmkwitansi->get_row_noKwitansi_by_register($no_register)->row()->no_kwitansi;
			$nama_xuser = $this->Frmmkwitansi->get_nama_xuser_by_noreg($no_register)->row()->xuser;

			$diskon =  $diskon = $this->input->post('diskon_hide');
			$xuser = $diskon = $this->input->post('xuser');




			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/

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
			$konten =
				"
					<style type=\"text/css\">
					.table-font-size{
						font-size:6px;
					    }
					.table-font-size1{
						font-size:10px;
					    }
					.table-font-size2{
						font-size:8px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>				
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page
					<hr>
					<br>
					<table class=\"table-font-size1\">
						<tr>
							<td width=\"20%\"></td>
							<td width=\"2%\"></td>
							<td width=\"20%\"></td>
							<td width=\"5%\"></td>
							<td width=\"24%\"></td>
							<td width=\"2%\"></td>
							<td width=\"15%\"></td>							
						</tr>
						<tr>
							<td width=\"20%\">No. Registrasi</td>
							<td width=\"2%\">:</td>
							<td width=\"20%\">$no_register</td>
							<td width=\"5%\"> </td>
							<td width=\"24%\">Cara Bayar</td>
							<td width=\"2%\">:</td>
							<td width=\"15%\">$cara_bayar</td>
							
						</tr>
						<tr>
							<td width=\"20%\">No. Medrec</td>
							<td width=\"2%\">:</td>
							<td width=\"20%\">$no_cm</td>
							<td width=\"5%\"> </td>
							<td width=\"24%\">No Resep</td>
							<td width=\"2%\">:</td>
							<td width=\"15%\">FRM_$no_resep</td>
						</tr>
						<tr>
							<td  width=\"20%\">Nama Pasien</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$nama</td>
							<td width=\"5%\"> </td>
							<td  width=\"24%\">Resep Dokter</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$nmdokter</td>
						</tr>
						<tr>
							<td  width=\"20%\">Unit Asal</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$bed</td>
							<td width=\"5%\"> </td>
							<td  width=\"24%\">No Kwitansi</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$no_kwitansi</td>
						</tr>
						<tr>
							<td  width=\"20%\">Sudah Terima Dari</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">" . str_replace('%20', ' ', $penyetor) . "</td>
							<td width=\"5%\"> </td>
							<td  width=\"24%\"></td>
							<td  width=\"2%\"></td>
							<td  width=\"20%\"></td>
						</tr>
						
						
					</table>
					<br/>
					<br/><br/>
					<table class=\"table-font-size1\">
						<tr>
							<th  width=\"10%\"><p align=\"center\">No</p></th>
							<th  width=\"50%\"><p align=\"center\">Nama Item</p></th>
							<th  width=\"12%\"><p align=\"center\">Banyak</p></th>
							<th  width=\"30%\"><p align=\"center\">Total</p></th>
						</tr>
						<hr> ";
			$i = 1;
			$jumlah_vtot = 0;

			foreach ($data_permintaan as $row) {
				$jumlah_vtot = $jumlah_vtot + $row->vtot;
				$vtot = number_format($row->vtot, 2, ',', '.');
				$konten = $konten . "<tr>
										  <td><p  align=\"center\">$i</p></td>
										  <td>$row->nama_obat</td>
										  <td><p align=\"center\">$row->qty</p></td>
										  <td><p align=\"right\">$vtot</P></td>
										  <br>
										</tr>";
				$i++;
			}

			if (substr($datpasien->no_register, 0, 2) == 'PL') {
				$konten = $konten . "
						<tr>
						  	<td><p align=\"center\"></p></td>
						  	<td>Admin Pasien Luar</td>
						  	<td><p align=\"center\"></p></td>
						  	<td><p align=\"right\">5000</P></td>
						</tr>";
			}

			if ($cara_bayar == 'BPJS') {
				$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);

				$konten = $konten . "
					</table>
						<tr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\">" . number_format('0', 2, ',', '.') . "</p></th>
						</tr>
						
					
					<p class=\"table-font-size1\" align=\"right\">Biaya yang dibayar oleh pasien sebesar 0 rupiah (Ditanggung BPJS)</p>
					<table class=\"table-font-size1\">
						<tr>
							<td><p align=\"right\">Tanggal-Jam: $tgl_jam</p></td>
						</tr>
					</table>
					";
			} else if (substr($datpasien->no_register, 0, 2) == 'PL') {
				$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);


				$konten = $konten . "
						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\">" . number_format($jumlah_vtot + 5000, 2, ',', '.') . "</p></th>
						</tr>";
				//$totakhir=$jumlah_vtot-$diskon;
				$persen = $diskon / 100;
				$diskon_persen = $jumlah_vtot * $persen;
				$totakhir = $jumlah_vtot - $diskon_persen;
				if ($diskon != 0) {
					$konten = $konten . "
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">" . number_format($totakhir + 5000, 2, ',', '.') . "</p></th>
						</tr>
						<table>";
					$jumlah_vtot = $jumlah_vtot + 5000 - $diskon_persen;
				}
				$vtot_terbilang = $cterbilang->terbilang($totakhir + 5000);
			} else {
				$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);


				$konten = $konten . "
						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\">" . number_format($jumlah_vtot, 2, ',', '.') . "</p></th>
						</tr>";
				//$totakhir=$jumlah_vtot-$diskon;
				$persen = $diskon / 100;
				$diskon_persen = $jumlah_vtot * $persen;
				$totakhir = $jumlah_vtot - $diskon_persen;
				if ($diskon != 0) {
					$konten = $konten . "
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">" . number_format($totakhir, 2, ',', '.') . "</p></th>
						</tr>
						<table>";
					$jumlah_vtot = $jumlah_vtot - $diskon_persen;
				}
				$vtot_terbilang = $cterbilang->terbilang($totakhir);
			}

			$jumlah_vtot = 0;
			foreach ($data_permintaan as $row) {
				$jumlah_vtot = $jumlah_vtot + $row->vtot;
				$vtot = number_format($row->vtot, 2, ',', '.');
			}

			//if ($cara_bayar=='BPJS' or $cara_bayar=='PERUSAHAAN'){
			//	$jumlah_vtot=$jumlah_vtot;
			//}else{
			//$tot1 = $jumlah_vtot;
			//$tot2 = substr($tot1, - 3);
			//if ($tot2 % 500 != 0){
			//	$mod = $tot2 % 500;
			//	$tot1 = $tot1 - $mod;
			//	$tot1 = $tot1 + 500; 
			//}
			//$jumlah_vtot=$tot1;
			//}

			$konten = $konten . "
						<tr><br>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Total  Rp." . number_format($jumlah_vtot, 2, ',', '.') . "  </u></p></th>
							
						</tr>";
			//$totakhir=$jumlah_vtot-$diskon;
			$persen = $diskon / 100;
			$diskon_persen = $jumlah_vtot * $persen;
			$totakhir = $jumlah_vtot - $diskon_persen;

			if ($diskon != 0) {
				$konten = $konten . "
						<tr>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Diskon" . $diskon . " % </u></p></th>
						</tr>

						<tr><hr>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Total Bayar  Rp." . number_format($totakhir, 2, ',', '.') . "  </u></p></th>
						</tr>";
				$jumlah_vtot = $jumlah_vtot - $diskon_persen;
			}
			$vtot_terbilang = $cterbilang->terbilang($totakhir);

			$konten = $konten . "
						
					</table>
					<font size=\"10\">
					Terbilang : " . $vtot_terbilang . "
					</font>
					<p class=\"table-font-size1\" align=\"right\"><i>Untuk Pembayaran Obat yang diminta, sesuai nota terlampir</i></p>
					<br><br>
					<table class=\"table-font-size1\">
						<tr>
							<td></td>
							<td></td>
							<td>$kota_header, $tgl</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>an.Kepala Rumah Sakit</td>
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
							<td>----------------------------------------<br>$nama_xuser</td>
						</tr>
					</table>
					";



			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\">Total   </p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$file_name = "KWI_$no_resep.pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('10', '3', '10');
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
}
