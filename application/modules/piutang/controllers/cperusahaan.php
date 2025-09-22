<?php defined('BASEPATH') OR exit('No direct script access allowed');
include('Rjcterbilang.php');


class cperusahaan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('piutang/mperusahaan','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('iri/rimpasien','',TRUE);
		$this->load->model('iri/rimpendaftaran','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
	}

	public function index(){
		// var_dump($this->input->post());die();
		$data['title'] = 'Tagihan Ikatan Kerja Sama IRJ';
		$date1 = $this->input->post('date_days1');
		$date2 = $this->input->post('date_days2');
		if($this->input->post()){
			$data['perusahaan'] = $this->mperusahaan->get_perusahaan_by_tgl($date1,$date2);
			$data['date1'] = $date1;
			$data['date2'] = $date2;
		}else{
			$data['perusahaan'] = array();
			$data['date1'] = '';
			$data['date2'] = '';
		}
		
		$this->load->view('piutang/vperusahaan',$data);
	}

    public function get_list_pasien($id,$date1,$date2){
        // var_dump($id);die();
		$data['title'] = 'Tagihan Ikatan Kerja Sama';
		$data['id_kontraktor'] = $id;
		$data['date1'] = $date1;
		$data['date2'] = $date2;
        $data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
		$data['list_pasien'] = $this->mperusahaan->get_list_pasien_iks($id,$date1,$date2);
		$data['saldo'] = $this->mperusahaan->get_saldo($id);
		$this->load->view('piutang/vlist_pasien_iks',$data);
	}

	public function tambah_saldo(){
        //  var_dump($this->input->post());die();
		$data['id_kontraktor'] = $this->input->post('id_kontraktor');
		$data['saldo'] = $this->input->post('saldo');
        $this->mperusahaan->insert_saldo($data);
		redirect('piutang/cperusahaan/get_list_pasien/'.$data['id_kontraktor']);
	}

	public function cetak_tagihan($id,$date1,$date2){
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['id_kontraktor'] = $id;
		$data['date1'] = $date1;
		$data['date2'] = $date2;
        $data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
		$data['list_pasien'] = $this->mperusahaan->get_list_pasien_iks($id,$date1,$date2);
		$data['saldo'] = $this->mperusahaan->get_saldo($id);

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('piutang/cetak_tagihan_perusahaan', $data, true);
        //$this->mpdf->AddPage('L'); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();

		// $this->load->view('piutang/cetak_tagihan_perusahaan',$data);
	}

	public function pasien_lunas($no_register,$id,$date1,$date2){
	  	$tagihan = $this->mperusahaan->get_list_pasien_iks_by_noreg($no_register);
		$tagihan_pasien =  $tagihan->biaya_poli + $tagihan->biaya_lab + $tagihan->biaya_rad + $tagihan->biaya_em + $tagihan->biaya_ok + $tagihan->biaya_resep;
		$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
		$ket='KERJASAMA';
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$kasir=$this->M_user->get_role_aksesOne($login_data->userid)->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->rjmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
		$data9['no_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$data9['xuser']=$user;
		$data9['xcreate']=date('Y-m-d H:i:s');
		$data9['no_register']=$no_register;
		$data9['nama_poli']='ADM';
		$data9['jenis_bayar'] = $ket;
		$data9['asal'] = $data_pasien->id_poli;
		$cek=$this->rjmkwitansi->insert_nomorkwitansi($data9);

		$data10['no_kk']='0';$data10['nilai_kkd']='0';$data10['persen_kk']='0';$data10['diskon']='0';
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);

		$data['vtot_bayar']=$tagihan_pasien;
		$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);

		$datank['no_register']=$no_register; 
		$datank['idno_kwitansi']=sprintf("%06d",($nomor->no_kwitansi+1));
		$datank['user_cetak']=$user;
		$datank['tgl_cetak']=date('Y-m-d H:i:s');
		$datank['jenis_kwitansi']= 'Rawat Jalan';
		$datank['dp']= 0;
		$datank['vtot_bayar']=(int)$tagihan_pasien;
		$datank['jenis_bayar'] = $ket;
		$datank['asal'] = $data_pasien->id_poli;
		$cek=$this->rjmkwitansi->insert_nokwitansi_iks($datank);


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
		$datares['method_pay'] = $ket;
		$datares['nama_dokter'] = $data_pasien->nm_dokter;
		$datares['trx_no'] = $no_trx->no_kwitansi;
		$datares['paid_flag'] = 0;
		$datares['cancel_flag'] = 0;
		$datares['is_cancel'] = 0;
		$datares['payment_bill'] = (int)$tagihan_pasien;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = $additional1;
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$datares['cash']=0;
		$datares['noncash']=0;
		$this->rjmkwitansi->insert_registrasi($datares);

		$data_irj['cetak_kwitansi'] = 1;
		$data_irj['tgl_cetak_kw'] = date('Y-m-d');
		$this->rjmkwitansi->update_daftar_ulang_irj($no_register, $data_irj);

		//saldo perusahaan
		 $saldo = $this->mperusahaan->get_saldo($id)->saldo;
		 $sisa_saldo = $saldo - (int)$tagihan_pasien;
		 $datasal['id_kontraktor'] = $id;
		 $datasal['saldo'] = $sisa_saldo;
         $this->mperusahaan->insert_saldo($datasal);
		 redirect('piutang/cperusahaan/get_list_pasien/'.$id.'/'.$date1.'/'.$date2);
	}

	public function iks_ranap(){
		$data['title'] = 'Tagihan Ikatan Kerja Sama IRI';
		$date1 = $this->input->post('date_days1');
		$date2 = $this->input->post('date_days2');
		if($this->input->post()){
			$data['perusahaan'] = $this->mperusahaan->get_perusahaan_ranap_by_tgl($date1,$date2);
			$data['date1'] = $date1;
			$data['date2'] = $date2;
		}else{
			$data['perusahaan'] = array();
			$data['date1'] = '';
			$data['date2'] = '';
		}

		$this->load->view('piutang/vperusahaan_ranap',$data);
	}

	public function get_list_pasien_ranap($id,$date1,$date2){
		$data['title'] = 'Tagihan Ikatan Kerja Sama IRI';
		$data['id_kontraktor'] = $id;
		$data['date1'] = $date1;
		$data['date2'] = $date2;
        $data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
		$data['list_pasien'] = $this->mperusahaan->get_list_pasien_iks_ranap($id,$date1,$date2);
		$data['saldo'] = $this->mperusahaan->get_saldo($id);
		$this->load->view('piutang/vlist_pasien_iks_ranap',$data);
	}

	public function cetak_tagihan_ranap($id,$date1,$date2){
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['id_kontraktor'] = $id;
		$data['date1'] = $date1;
		$data['date2'] = $date2;
        $data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
		$data['list_pasien'] = $this->mperusahaan->get_list_pasien_iks_ranap($id,$date1,$date2);
		$data['saldo'] = $this->mperusahaan->get_saldo($id);

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $html = $this->load->view('piutang/cetak_tagihan_perusahaan_ranap', $data, true); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();

		// $this->load->view('piutang/cetak_tagihan_perusahaan_ranap',$data);
	}

	public function pasien_lunas_ranap($no_ipd,$id,$date1,$date2){
	  $tagihan = $this->mperusahaan->get_list_pasien_iks_by_ipd($no_ipd);
	  $tagihan_pasien =  $tagihan->biaya_poli + $tagihan->biaya_lab + $tagihan->biaya_rad + $tagihan->biaya_em + $tagihan->biaya_ok + $tagihan->biaya_resep;
		
	  $pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
	  $idrg = $this->rimpasien->get_recent_idrg_patient($no_ipd)->row()->idrg;
	  $cek_no_kwitansi = $this->rimpasien->get_no_kwitansi('RI');

	    $kwitansi['no_register'] = $no_ipd;
		if ($cek_no_kwitansi) {
			$no_kwitansi = substr($cek_no_kwitansi->row()->no_kwitansi, 5)  + 1;
			$kwitansi['no_kwitansi'] = 'IKS'.date('y').'-'.sprintf("%06d", $no_kwitansi);
			$kwitansi['idno_kwitansi'] = sprintf("%06d", $no_kwitansi);
		}else{
			$kwitansi['no_kwitansi'] = 'IKS'.date('y').'-00001';
			$kwitansi['idno_kwitansi'] = 1;
		}
		$kwitansi['jenis_kwitansi'] = 'RI';
		$kwitansi['user_cetak'] = $login_data->username;
		$kwitansi['tgl_cetak'] = date('Y-m-d H:i:s');
		$kwitansi['vtot_bayar'] = $tagihan_pasien;
		$kwitansi['tunai'] = $tagihan_pasien;
		$kwitansi['diskon'] = 0;
		$kwitansi['jenis_bayar']='KERJASAMA';
		$kwitansi['asal'] = $idrg;
		$kwitansi['cash']=0;
		$kwitansi['noncash']=0;
		$this->rimpasien->insert_no_kwitansi($kwitansi);

		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);

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
		$datares['payment_bill'] = (int)$tagihan_pasien;
		$datares['cash']=0;
		$datares['noncash']=0;
		$datares['cancel_nominal'] = 0;
		$datares['retur_nominal'] = 0;
		$datares['retur_flag'] = 0;
		$datares['new_payment_bill'] = 0;
		$datares['additional1'] = 'Rawat Inap';
		$datares['additional2'] = '0';
		$datares['additional3'] = '0';
		$datares['method_pay'] = 'KERJASAMA';
		$datares['component_id'] = $idrg;
		$this->rjmkwitansi->insert_registrasi($datares);

	  //saldo perusahaan
	   $saldo = $this->mperusahaan->get_saldo($id)->saldo;
	   $sisa_saldo = $saldo - (int)$tagihan_pasien;
	   $datasal['id_kontraktor'] = $id;
	   $datasal['saldo'] = $sisa_saldo;
	   $this->mperusahaan->insert_saldo($datasal);
	   redirect('piutang/cperusahaan/get_list_pasien_ranap/'.$id.'/'.$date1.'/'.$date2);
  }

  public function cetak_kwitansi_irj(){
	// var_dump($this->input->post());die();
	$data['title'] = 'Cetak Kwitansi Ikatan Kerja Sama IRJ';
	$date1 = $this->input->post('date_days1');
	$date2 = $this->input->post('date_days2');
	if($this->input->post()){
		$data['perusahaan'] = $this->mperusahaan->get_perusahaan_kwitansi_by_tgl($date1,$date2);
		$data['date1'] = $date1;
		$data['date2'] = $date2;
	}else{
		$data['perusahaan'] = array();
		$data['date1'] = '';
		$data['date2'] = '';
	}
	
	$this->load->view('piutang/vcetak_kwitansi_irj',$data);
}

public function get_list_pasien_ct_kw($id,$date1,$date2){
	// var_dump($id);die();
	$data['title'] = 'Cetak Kwitansi Ikatan Kerja Sama';
	$data['id_kontraktor'] = $id;
	$data['date1'] = $date1;
	$data['date2'] = $date2;
	$data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
	$data['list_pasien'] = $this->mperusahaan->get_list_pasien_ct_kw_iks($id,$date1,$date2);
	$data['saldo'] = $this->mperusahaan->get_saldo($id);
	$this->load->view('piutang/vlist_pasien_iks_ct_kw',$data);
}

public function cetak_kw_irj($no_register,$id){
	date_default_timezone_set("Asia/Bangkok");
	$tgl_jam = date("d-m-Y H:i:s");
	$data['tgl'] = date("d-m-Y");

	$conf=$this->appconfig->get_headerpdf_appconfig()->result();
	$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
	$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
	$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
	$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
	$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
	$data['id_kontraktor'] = $id;
	$data['no_register'] = $no_register;
	$data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
	$data['daftar_ulang']=$this->rjmkwitansi->getdata_pasien($no_register)->row();
	$data['detail_daful']=$this->rjmkwitansi->get_detail_daful($no_register)->row();
	$data['data_no_kwitansi'] = $this->rjmkwitansi->getdata_no_kwitansi_by_no_register($no_register)->row();
	$data['no_kwitansi'] = $data['data_no_kwitansi']->no_kwitansi;
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
	$data['vtot']=$this->rjmkwitansi->get_vtot($no_register)->row();

	$data['data_tindakan']=$this->mperusahaan->getdata_tindakan_pasien_faktur($no_register)->result();
	$data['data_labor']=$this->mperusahaan->getdata_labor_pasien_faktur($no_register)->result();
	$data['data_rad']=$this->mperusahaan->getdata_rad_pasien_faktur($no_register)->result();
	$data['data_em']=$this->mperusahaan->getdata_em_pasien_faktur($no_register)->result();
	$data['data_resep']=$this->mperusahaan->getdata_resep_pasien_faktur($no_register)->result();
	

	$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
	$mpdf->showImageErrors = true;
	$mpdf->curlAllowUnsafeSslRequests = true;
	$html = $this->load->view('piutang/kwitansi_irj', $data, true);
	$mpdf->WriteHTML($html);
	$mpdf->Output();

}

public function cetak_kwitansi_iri(){
	// var_dump($this->input->post());die();
	$data['title'] = 'Cetak Kwitansi Ikatan Kerja Sama IRI';
	$date1 = $this->input->post('date_days1');
	$date2 = $this->input->post('date_days2');
	if($this->input->post()){
		$data['perusahaan'] = $this->mperusahaan->get_perusahaan_ranap_ct_kw_by_tgl($date1,$date2);
		$data['date1'] = $date1;
		$data['date2'] = $date2;
	}else{
		$data['perusahaan'] = array();
		$data['date1'] = '';
		$data['date2'] = '';
	}
	
	$this->load->view('piutang/vcetak_kwitansi_iri',$data);
}


public function get_list_pasien_ct_kw_iri($id,$date1,$date2){
	// var_dump($id);die();
	$data['title'] = 'Cetak Kwitansi Ikatan Kerja Sama';
	$data['id_kontraktor'] = $id;
	$data['date1'] = $date1;
	$data['date2'] = $date2;
	$data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
	$data['list_pasien'] = $this->mperusahaan->get_list_pasien_iks_ranap_ct_kw($id,$date1,$date2);
	$data['saldo'] = $this->mperusahaan->get_saldo($id);
	$this->load->view('piutang/vlist_pasien_iks_ct_kw_iri',$data);
}

public function cetak_kw_iri($no_ipd,$id){
	date_default_timezone_set("Asia/Bangkok");
	$tgl_jam = date("d-m-Y H:i:s");
	$data['tgl'] = date("d-m-Y");

	$conf=$this->appconfig->get_headerpdf_appconfig()->result();
	$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
	$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
	$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
	$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
	$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
	$data['id_kontraktor'] = $id;
	$data['no_ipd'] = $no_ipd;
	$data['nm_perusahaan'] = $this->mperusahaan->get_nm_perusahaan($id)->nmkontraktor;
	
	$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
	$data['data_pasien'] = $pasien;
	// var_dump($pasien);die();
	$data['data_kwitansi'] = $this->rimtindakan->get_data_kwitansi($no_ipd)->row();

	$data['nama_pasien'] = $pasien[0]['nama'];
	$data['tgl_lahir'] = $pasien[0]['tgl_lahir'];
	$data['tahun_lahir'] = substr($pasien[0]['tgl_lahir'],0,4);
	$data['tahun_sekarang'] = date('Y');

	if ($pasien[0]['sex'] == 'L') {
		$data['jenkel'] = 'Laki - Laki';
	}else{
		$data['jenkel'] = 'Perempuan';
	}

	$data['umur'] = (int)$data['tahun_sekarang'] - (int)$data['tahun_lahir'];
	
	$data['data_ruang']=$this->mperusahaan->get_tagihan_ruangan_ranap($no_ipd);
	$data['data_tindakan']=$this->mperusahaan->getdata_tindakan_pasien_faktur_iri($no_ipd)->result();
	$data['data_labor']=$this->mperusahaan->getdata_labor_pasien_faktur_iri($no_ipd)->result();
	$data['data_rad']=$this->mperusahaan->getdata_rad_pasien_faktur_iri($no_ipd)->result();
	$data['data_em']=$this->mperusahaan->getdata_em_pasien_faktur_iri($no_ipd)->result();
	$data['data_resep']=$this->mperusahaan->getdata_resep_pasien_faktur_iri($no_ipd)->result();
	

	$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
	$mpdf->showImageErrors = true;
	$mpdf->curlAllowUnsafeSslRequests = true;
	$html = $this->load->view('piutang/kwitansi_iri', $data, true);
	$mpdf->WriteHTML($html);
	$mpdf->Output();

}

}