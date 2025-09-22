<?php defined('BASEPATH') OR exit('No direct script access allowed');


class cpiutang extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('piutang/mpiutang','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->model('elektromedik/emmkwitansi','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
		$this->load->model('iri/rimpasien','',TRUE);
		$this->load->model('iri/rimpendaftaran','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
	}

	public function index(){
		// var_dump($this->input->post());die();
		$data['title'] = 'Angsuran Piutang';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		
		if($this->input->post()){
			$tgl = $this->input->post('tgl');
			$medrec = $this->input->post('no_medrec');
			if($tgl != null && $medrec != null){
				$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang($tgl,$medrec);
			}else if($tgl == null && $medrec != null){
				$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang($tgl,$medrec);
			}else if($tgl != null && $medrec == null){
				$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang($tgl,$medrec);
			}else{
				$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang($tgl,$medrec);
			}
		}else{
			$tgl = '';
			$medrec = '';
			$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang($tgl,$medrec);
		}
		$this->load->view('piutang/vpiutang',$data);
	}

	public function index_ranap(){
		$data['title'] = 'Angsuran Piutang';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$data['pasien_piutang'] = $this->mpiutang->get_pasien_piutang_ranap();
		$this->load->view('piutang/vpiutang',$data);
	}

	public function rincian_angsuran($id){
		$data['title'] = 'Angsuran Piutang';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$data['pasien_piutang_item'] = $this->mpiutang->get_pasien_piutang_detail($id);
		$data['cicilan_piutang_item'] = $this->mpiutang->get_pasien_cicilan_detail($id);
		$sisa_akhir_tagihan = $this->mpiutang->get_sisa_akhir_cicilan($id);

		if($sisa_akhir_tagihan == null){
			$data['sisa_akhir'] = $data['pasien_piutang_item']->total_tagihan;
		}else{
			$data['sisa_akhir'] = $sisa_akhir_tagihan->sisa_akhir;
		}

		$this->load->view('piutang/vrincian_piutang',$data);
	}

	public function insert_angsuran_piutang(){
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_register =  $this->input->post('no_register');
		$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
		$biaya_angsuran = $this->input->post('biaya_angsuran');

		$kasir=$this->M_user->get_role_aksesOne($login_data->userid)->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->rjmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
		$data9['no_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['xuser']=$user;
		$data9['xcreate']=date('Y-m-d H:i:s');
		$data9['no_register']= $no_register;
		$data9['nama_poli']='ADM';
		$data9['jenis_bayar'] = 'PIUTANG/IKS';
		$data9['asal'] = $this->input->post('asal');
		$cek=$this->rjmkwitansi->insert_nomorkwitansi($data9);

		$data10['no_kk']='0';$data10['nilai_kkd']='0';$data10['persen_kk']='0';$data10['diskon']='0';
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);


		$data['tunai']=$biaya_angsuran;
		$data['vtot_bayar']=$biaya_angsuran;
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);


		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$user;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Rawat Jalan';
		$datank['dp']= 0;
		$datank['vtot_bayar']=(int)$biaya_angsuran;
		$datank['jenis_bayar'] = 'PIUTANG/IKS';
		$datank['asal'] = $this->input->post('asal');
		$cek=$this->rjmkwitansi->insert_nokwitansi($datank);

		$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
		$noncover=0;
		foreach($data_tindakan as $row1){
			
			if(($row1->noncover)>0){
				$noncover=1;
			}
		}

		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register,0,2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';	
				$additional1 = 'Rawat Darurat 2';
			}else{
				$component_id = '01';	
				$additional1 = 'Rawat Jalan 2';
			}				
		}else{
			$component_id = '03';	
			$additional1 = '';
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = $data_pasien->no_medrec;
		$datares['pasien_name'] = $data_pasien->nama;
		$datares['dob'] = $data_pasien->tgl_lahir;
		$datares['gender'] = $data_pasien->sex;
		$datares['gol_darah'] = $data_pasien->goldarah;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		$datares['component_id'] = $data_pasien->id_poli;
		//$datares['component_id'] = $id_poli;
		$datares['method_pay'] = 'PIUTANG/IKS';
		$datares['nama_dokter'] = $data_pasien->nm_dokter;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = $additional1;
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $no_trx->no_kwitansi;
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}

	public function insert_angsuran_piutang_lab(){
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_register =  $this->input->post('no_register');
		$no_lab=$this->input->post('no_lab');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();
		$biaya_angsuran = $this->input->post('biaya_angsuran');
		$kasir=$this->M_user->get_role_aksesOne($login_data->userid)->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->labmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		// $this->labmkwitansi->update_status_cetak_kwitansi($no_lab, $diskon, $no_register, $xuser);
		$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['xuser']=$user;
		$datak['xcreate']=date('Y-m-d H:i:s');
		$datak['no_register']=$no_register;
		$datak['nama_poli']='ADM';
		$datak['vtot_bayar']=$biaya_angsuran;
		$datak['tunai']=$biaya_angsuran;
		$datak['jenis_bayar'] = 'PIUTANG/IKS';
		$datak['asal'] = 'HA00';
		$this->labmkwitansi->insert_nomorkwitansi($datak);

		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$user;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Laboratorium';
		$datank['dp']= 0;
		$datank['vtot_bayar']=$biaya_angsuran;
		$datank['tunai']=$biaya_angsuran;
		$datank['jenis_bayar'] = 'PIUTANG/IKS';
		$datank['asal'] = 'HA00';
		$this->labmkwitansi->insert_nokwitansi($datank);

		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register,0,2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';	
			}else{
				$component_id = '01';	
			}				
		}else{
			$component_id = '03';	
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = isset($data_pasien->no_medrec)?$data_pasien->no_medrec:null;
		$datares['pasien_name'] = isset($data_pasien->nama)?$data_pasien->nama:null;
		$datares['dob'] = isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:null;
		$datares['gender'] = isset($data_pasien->sex)?$data_pasien->sex:null;
		$datares['gol_darah'] = isset($data_pasien->goldarah)?$data_pasien->goldarah:null;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		if(substr($no_register,0,2) == 'RJ') {
			$datares['component_id'] = 'HA00';
		} else {
			$datares['component_id'] = 'Pasien Luar';
		}
		$datares['method_pay'] = 'PIUTANG/IKS';
		$datares['nama_dokter'] = isset($data_pasien->nm_dokter)?$data_pasien->nm_dokter:null;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Labolatorium';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $no_trx->no_kwitansi;
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}

	public function insert_angsuran_piutang_rad(){
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_register =  $this->input->post('no_register');
		$no_rad=$this->input->post('no_rad');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_rad)->row();
		$biaya_angsuran = $this->input->post('biaya_angsuran');
		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->radmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		
		$datak['asal'] = 'LA00';
		$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['xuser']=$xuser;
		$datak['xcreate']=date('Y-m-d H:i:s');
		$datak['no_register']=$no_register;
		$datak['nama_poli']='ADM';
		$datak['diskon']= 0;
		$datak['vtot_bayar']=$biaya_angsuran;
		$datak['tunai']=$biaya_angsuran;
		$datak['jenis_bayar'] = 'PIUTANG/IKS';
		$this->radmkwitansi->insert_nomorkwitansi($datak);


		$datank['asal'] = 'LA00';
		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$xuser;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Radiologi';
		$datank['dp']= 0;
		$datank['diskon']= 0;
		$datank['vtot_bayar']=$biaya_angsuran;
		$datank['tunai']=$biaya_angsuran;
		$datank['jenis_bayar'] = 'PIUTANG/IKS';
		$this->radmkwitansi->insert_nokwitansi($datank);

		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register,0,2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';	
			}else{
				$component_id = '01';	
			}				
		}else{
			$component_id = '03';	
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = isset($data_pasien->no_medrec)?$data_pasien->no_medrec:null;
		$datares['pasien_name'] = isset($data_pasien->nama)?$data_pasien->nama:null;
		$datares['dob'] = isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:null;
		$datares['gender'] = isset($data_pasien->sex)?$data_pasien->sex:null;
		$datares['gol_darah'] = isset($data_pasien->goldarah)?$data_pasien->goldarah:null;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		//$datares['component_id'] = isset($data_pasien->id_poli)?$data_pasien->id_poli:null;
		$datares['method_pay'] = 'PIUTANG/IKS';
		if(substr($no_register,0,2) == 'RJ') {
			$datares['component_id'] = 'LA00';
		} else {
			$datares['component_id'] = 'Pasien Luar';
		}
		$datares['nama_dokter'] = isset($data_pasien->nm_dokter)?$data_pasien->nm_dokter:null;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Radiologi';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $no_trx->no_kwitansi;
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}

	public function insert_angsuran_piutang_em(){
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_register =  $this->input->post('no_register');
		$no_em=$this->input->post('no_em');
		$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
		$biaya_angsuran = $this->input->post('biaya_angsuran');
		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->emmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		$datak['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$datak['xuser']=$xuser;
		$datak['xcreate']=date('Y-m-d H:i:s');
		$datak['no_register']=$no_register;
		$datak['nama_poli']='ADM';
		$datak['diskon']= $diskon;
		$datak['vtot_bayar']=$biaya_angsuran;
		$datak['tunai']=$biaya_angsuran;
		$datak['jenis_bayar'] = 'PIUTANG/IKS';
		$datak['asal'] = 'ME00';
		$this->emmkwitansi->insert_nomorkwitansi($datak);


		$datank['jenis_bayar'] = 'PIUTANG/IKS';
		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$xuser;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Elektromedik';
		$datank['dp']= 0;
		$datank['diskon']= $diskon;
		$datank['vtot_bayar']=$biaya_angsuran;
		$datank['tunai']=$biaya_angsuran;
		$datank['asal'] = 'ME00';
		$this->emmkwitansi->insert_nokwitansi($datank);

		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register,0,2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';	
			}else{
				$component_id = '01';	
			}				
		}else{
			$component_id = '03';	
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = isset($data_pasien->no_medrec)?$data_pasien->no_medrec:null;
		$datares['pasien_name'] = isset($data_pasien->nama)?$data_pasien->nama:null;
		$datares['dob'] = isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:null;
		$datares['gender'] = isset($data_pasien->sex)?$data_pasien->sex:null;
		$datares['gol_darah'] = isset($data_pasien->goldarah)?$data_pasien->goldarah:null;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		if(substr($no_register,0,2) == 'RJ') {
			$datares['component_id'] = 'ME00';
		} else {
			$datares['component_id'] = 'Pasien Luar';
		}
		$datares['method_pay'] = 'PIUTANG/IKS';
		$datares['nama_dokter'] = isset($data_pasien->nm_dokter)?$data_pasien->nm_dokter:null;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Elektromedik';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $no_trx->no_kwitansi;
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}

	public function verifikasi_lunas(){
		// var_dump($this->input->post());die();
		$no_register = $this->input->post('no_register');
		$id_piutang = $this->input->post('id_piutang');
		$jns_kwitansi = $this->input->post('jns_kwitansi');
		$no_lab = $this->input->post('no_lab');
		$no_rad = $this->input->post('no_rad');
		$no_em = $this->input->post('no_em');

		if($jns_kwitansi == 'Rawat Jalan'){
			$data_irj['cetak_kwitansi'] = 1;
			$data_irj['tgl_cetak_kw'] = date('Y-m-d');
			$this->rjmkwitansi->update_daftar_ulang_irj($no_register, $data_irj);
			$this->rjmkwitansi->update_bayar_pelayanan_poli_piutang_lunas($no_register);
		}else if($jns_kwitansi == 'Laboratorium'){
			$this->mpiutang->update_status_cetak_kwitansi_lab_lunas($no_lab,$no_register);
		}else if($jns_kwitansi == 'Radiologi'){
			$this->mpiutang->update_status_cetak_kwitansi_rad_lunas($no_rad,$no_register);
		}else if($jns_kwitansi == 'Elektromedik'){
			$this->mpiutang->update_status_cetak_kwitansi_em_lunas($no_em,$no_register);
		}else if($jns_kwitansi == 'Rawat Inap'){
			$data_pasien_iri['lunas'] = 1;
			$data_pasien_iri['piutang'] = 2;
			$data_pasien_iri['cetak_kwitansi'] = 1;
			$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
			$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_register);
			$this->rimpasien->flag_kwintasi_rad_piutang_lunas($no_register);
			$this->rimpasien->flag_kwintasi_lab_piutang_lunas($no_register);
			$this->rimpasien->flag_kwintasi_obat_piutang_lunas($no_register);
			$this->rimpasien->flag_kwintasi_em_piutang_lunas($no_register);
		}else if($jns_kwitansi == 'Rawat Jalan (Sebelum Poli)'){
			$du['cetak_kwitansi'] = 0;
			$this->rjmkwitansi->update_cetak_kwitansi($du, $no_register);
			$this->rjmkwitansi->update_piutang_lunas_mrpoli($no_register);
		}
		
		$this->mpiutang->update_header_piutang_lunas($id_piutang);


		//data cetak bukti lunas
		if($jns_kwitansi == 'Rawat Inap'){
			$conf=$this->appconfig->get_headerpdf_appconfig()->result();
			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
	
			$data['data_pasien']=$this->rimtindakan->get_pasien_by_no_ipd($no_register);
			$data['nama_pasien'] = $data['data_pasien'][0]['nama'];
			$data['tgl_lahir'] = $data['data_pasien'][0]['tgl_lahir'];
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');
	
			if ($data['data_pasien'][0]['sex'] == 'L') {
				$data['jenkel'] = 'Laki - Laki';
			}else{
				$data['jenkel'] = 'Perempuan';
			}
	
			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
	
			$data['data_header_piutang'] = $this->mpiutang->get_pasien_piutang_detail($id_piutang);
			$data['data_item_piutang'] = $this->mpiutang->get_pasien_cicilan_detail_piutang_by_id_piutang($id_piutang);
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
	
			$this->load->view('piutang/bukti_lunas_ranap',$data);
		}else{
			$conf=$this->appconfig->get_headerpdf_appconfig()->result();
			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
	
			$data['data_pasien']=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			$data['nama_pasien'] = $data['data_pasien']->nama;
			$data['tgl_lahir'] = $data['data_pasien']->tgl_lahir;
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');
	
			if ($data['data_pasien']->sex == 'L') {
				$data['jenkel'] = 'Laki - Laki';
			}else{
				$data['jenkel'] = 'Perempuan';
			}
	
			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
	
			$data['detail_daful']=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			if($data['detail_daful']->cara_bayar=='UMUM'){
				$data['pasien_bayar']='TUNAI';
			}else {$data['pasien_bayar']='KREDIT';}			
			$data['data_header_piutang'] = $this->mpiutang->get_pasien_piutang_detail($id_piutang);
			$data['data_item_piutang'] = $this->mpiutang->get_pasien_cicilan_detail_piutang_by_id_piutang($id_piutang);
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
	
			$this->load->view('piutang/bukti_lunas',$data);
		}
		
	}

	public function insert_angsuran_piutang_ranap(){
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$idrg = $this->rimpasien->get_recent_idrg_patient($no_ipd)->row()->idrg;
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_ipd = $this->input->post('no_register');
		$biaya_angsuran = $this->input->post('biaya_angsuran');

		$cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');
		$kwitansi['no_register'] = $no_ipd;
		if ($cek_no_kwitansi) {
			$no_kwitansi = substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
			$kwitansi['no_kwitansi'] = 'RI'.date('y').'-'.sprintf("%06d", $no_kwitansi);
			$kwitansi['idno_kwitansi'] = sprintf("%06d", $no_kwitansi);
		}else{
			$kwitansi['no_kwitansi'] = 'RI'.date('y').'-00001';
			$kwitansi['idno_kwitansi'] = 1;
		}

		$kwitansi['jenis_kwitansi'] = 'RI';
		$kwitansi['user_cetak'] = $login_data->username;
		$kwitansi['tgl_cetak'] = date('Y-m-d H:i:s');
		$kwitansi['vtot_bayar'] = $biaya_angsuran;
		$kwitansi['tunai'] = $biaya_angsuran;
		// if($pasien[0]['carabayar'] == 'BPJS') {
		// 	if(($pasien[0]['klsiri'] == $pasien[0]['jatahklsiri']) || ($pasien[0]['jatahklsiri'] == 'III')) {
		// 		$kwitansi['tarif_kls1_inacbg'] = $this->input->post('tarif');
		// 		$kwitansi['tarif_kls2_inacbg'] = $this->input->post('tarif2');
		// 	} else if(($pasien[0]['klsiri'] != $pasien[0]['jatahklsiri']) || ($pasien[0]['jatahklsiri'] != 'III')) {
		// 		$kwitansi['tarif_kls1_inacbg'] = $this->input->post('tarif_satu');
		// 		$kwitansi['tarif_kls2_inacbg'] = $this->input->post('tarif_dua');
		// 	}
		// }
		$kwitansi['jenis_bayar']='PIUTANG/IKS';
		$kwitansi['asal'] = $idrg;
		$this->rimpasien->insert_no_kwitansi($kwitansi);

		$datas['tunai'] = $biaya_angsuran;
		// $datas['no_kk'] = $no_kartu_kredit;
		// $datas['nilai_kkd'] = $dibayar_kartu_cc_debit;
		// $datas['persen_kk'] = $charge;
		$datas['jenis_bayar'] = 'PIUTANG/IKS';
		$datas['asal'] = $idrg;
		$this->rjmkwitansi->update_pembayaran_nokwitansi($kwitansi['idno_kwitansi'],$datas);

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
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Rawat Inap';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$datares['method_pay'] = 'PIUTANG/IKS';
		$datares['component_id'] = $idrg;
		$this->rjmkwitansi->insert_registrasi($datares);
		
		

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $kwitansi['no_kwitansi'];
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}

	public function cetak_faktur_kt_piutang_ranap($id,$id_piutang,$no_register){
		$data['no_register'] = $no_register;
		$data['daftar_ulang']=$this->rimtindakan->get_pasien_by_no_ipd($no_register);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = strtoupper($login_data->username);

		if($no_register!=''){
			// $data['cterbilang']=new rjcterbilang();
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$data['tgl'] = date("d-m-Y");

			$conf=$this->appconfig->get_headerpdf_appconfig()->result();
			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
	
			$data['data_pasien']=$this->rimtindakan->get_pasien_by_no_ipd($no_register);
			// var_dump($data['data_pasien']);die();
			$data['nama_pasien'] = $data['data_pasien'][0]['nama'];
			$data['tgl_lahir'] = $data['data_pasien'][0]['tgl_lahir'];
			$data['tahun_lahir'] = substr($data['tgl_lahir'],0,4);
			$data['tahun_sekarang'] = date('Y');

			if ($data['data_pasien'][0]['sex'] == 'L') {
				$data['jenkel'] = 'Laki - Laki';
			}else{
				$data['jenkel'] = 'Perempuan';
			}

			$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
	
			$data['data_header_piutang'] = $this->mpiutang->get_pasien_piutang_detail($id_piutang);
			$data['data_item_piutang'] = $this->mpiutang->get_pasien_cicilan_detail_piutang($id);
			// $data['vtot']=$this->rjmkwitansi->get_vtot($no_register)->row();
			$this->load->view('piutang//kwitansi_angsuran_ranap',$data);
		
		}else{

		}

	}

	public function insert_angsuran_piutang_sblm_poli(){
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$no_register =  $this->input->post('no_register');
		$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
		$biaya_angsuran = $this->input->post('biaya_angsuran');

		$kasir=$this->M_user->get_role_aksesOne($login_data->userid)->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->rjmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
		$data9['no_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['xuser']=$user;
		$data9['xcreate']=date('Y-m-d H:i:s');
		$data9['no_register']= $no_register;
		$data9['nama_poli']='ADM';
		$data9['jenis_bayar'] = 'PIUTANG/IKS';
		$data9['asal'] = $this->input->post('asal');
		$cek=$this->rjmkwitansi->insert_nomorkwitansi($data9);

		$data10['no_kk']='0';$data10['nilai_kkd']='0';$data10['persen_kk']='0';$data10['diskon']='0';
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);


		$data['tunai']=$biaya_angsuran;
		$data['vtot_bayar']=$biaya_angsuran;
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);


		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$user;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Rawat Jalan';
		$datank['dp']= 0;
		$datank['vtot_bayar']=(int)$biaya_angsuran;
		$datank['jenis_bayar'] = 'PIUTANG/IKS';
		$datank['asal'] = $this->input->post('asal');
		$cek=$this->rjmkwitansi->insert_nokwitansi($datank);

		$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
		$noncover=0;
		foreach($data_tindakan as $row1){
			
			if(($row1->noncover)>0){
				$noncover=1;
			}
		}

		$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$datank['idno_kwitansi'])->row();

		if (substr($no_register,0,2) == 'RJ') {
			if ($data_pasien->id_poli == 'BA00') {
				$component_id = '02';	
				$additional1 = 'Rawat Darurat 1';
			}else{
				$component_id = '01';	
				$additional1 = 'Rawat Jalan 1';
			}				
		}else{
			$component_id = '03';	
			$additional1 = '';
		}

		$datares['reg_date'] = date('Y-m-d');
		$datares['reg_no'] = $no_register;
		$datares['rm_no'] = $data_pasien->no_medrec;
		$datares['pasien_name'] = $data_pasien->nama;
		$datares['dob'] = $data_pasien->tgl_lahir;
		$datares['gender'] = $data_pasien->sex;
		$datares['gol_darah'] = $data_pasien->goldarah;
		$datares['jenis_pelayanan_id'] = 1;
		$datares['jenis_transaksi'] = 1;
		$datares['payment_tp'] = 2;
		$datares['component_id'] = $data_pasien->id_poli;
		//$datares['component_id'] = $id_poli;
		$datares['method_pay'] = 'PIUTANG/IKS';
		$datares['nama_dokter'] = $data_pasien->nm_dokter;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$biaya_angsuran;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = $additional1;
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_cil['no_register'] = $this->input->post('no_register');
		$data_cil['biaya_angsuran']  = $biaya_angsuran;
		$data_cil['sisa_angsuran']  = $this->input->post('sisa_tagihan');
		$data_cil['angsuran_awal']  = $this->input->post('total_tagihan');
		$data_cil['created_date']  = date('Y-m-d h:i:s');
		$data_cil['created_by']  = $user;
		$data_cil['id_piutang']  = $this->input->post('id_piutang');
		$data_cil['no_kwitansi']  = $no_trx->no_kwitansi;
		$data_cil['sisa_akhir']  = $data_cil['sisa_angsuran'] - $data_cil['biaya_angsuran'];
		$this->mpiutang->insert_cicilan_piutang($data_cil);
		redirect('piutang/cpiutang/rincian_angsuran/'.$data_cil['id_piutang']);
	}


	

}