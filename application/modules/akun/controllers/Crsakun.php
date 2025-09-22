<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');

class crsakun extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('akun/mrsakun','',TRUE);
			$this->load->model('farmasi/Frmmlaporan','',TRUE);
			$this->load->helper('url');
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		$data['title'] = 'Akuntansi';
		$data['rekening']=$this->mrsakun->get_all_data_rekening()->result();
		$this->load->view('akun/v_akun',$data);
	}

	public function mata_anggaran()
	{
		$data['title'] = 'Mata Anggaran';
		$data['mataanggaran']=$this->mrsakun->get_all_data_mataanggaran()->result();
		$data['anggaranparent']=$this->mrsakun->get_all_data_mataanggaran_parent()->result();
		$this->load->view('akun/v_mataanggaran',$data);
	}

	public function listtrans()
	{
		$data['title'] = 'Input Transaksi';
		//$data['norek']=$this->mrsakun->get_active_data_norek()->result();
		$this->load->view('akun/v_listtrans',$data);
	}

	public function lap_bukas()
	{
		$data['title'] = 'Laporan Buku Kas';
		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Buku Kas.
			</h4>							
			</div>
		</div>";
		//$data['norek']=$this->mrsakun->get_active_data_norek()->result();
		$this->load->view('akun/v_lapbukas',$data);
	}

	public function intrans($idbukas_header='')
	{
		$data['title'] = 'Input Transaksi';
		$data['idbukas_header']=$idbukas_header;

		$data['norek']=$this->mrsakun->get_active_data_norek()->result();
		$data['mataanggaran']=$this->mrsakun->get_all_data_mataanggaran()->result();
		$this->load->view('akun/v_inputtrans',$data);
	}

	public function norek()
	{
		$data['title'] = 'Nomor Rekening';
		$data['nomorrekening']=$this->mrsakun->get_all_data_norek()->result();
		$this->load->view('akun/v_norek',$data);
	}	
	
	public function valid()
	{
		$data['title'] = 'Validasi Voucher';
		$data['valid']=$this->mrsakun->get_all_valid_voucher()->result();
		$this->load->view('akun/v_valid',$data);
	}

	///////////////////data table
	function get_trans_list(){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
		$tglawal=$this->input->post('tglawal');
		$tglakhir=$this->input->post('tglakhir');
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->mrsakun->getdata_daftar_bukas($tglawal,$tglakhir)->result();
			/*$line['data'] = $hasil;*/		
			$no=1;	
			foreach ($hasil as $value) {
				$row2['kode_trans'] = $value->kode_trans;
				$row2['no'] = $no++;
				$row2['no_bk'] = $value->no_bk;
				$row2['tgl_transaksi'] = date('d-m-Y',strtotime($value->tgl_transaksi));
				$row2['bulan'] = date('F',strtotime($value->tgl_transaksi));
				$row2['uraian'] = $value->uraian;
				$row2['total_debit'] = number_format( $value->total_debit, 0 , ',' , '.' );
				$row2['total_kredit'] = number_format( $value->total_kredit, 0 , ',' , '.' );
				//$row2['user'] = $value->user;
				//$row2['no_faktur'] = $value->no_faktur;
				$row2['aksi'] = '<center>
				<a class="btn btn-primary btn-sm text-white" href="'.site_url("akun/crsakun/intrans").'/'.$value->kode_trans.'"><i class="fa fa-book"></i></a>
				&nbsp;<button class="btn btn-danger btn-sm"  onclick="deleteheader('.$value->idbukas_header.')"><i class="fa fa-trash"></i></button>
							</center>';
							
				$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }

    function get_bukas_detail($idbukas_header){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
			
			$hasil = $this->mrsakun->get_data_bukasdetail_id($idbukas_header)->result();
			/*$line['data'] = $hasil;*/		
			// print_r($hasil);
		if($hasil){
			$no=1;
			foreach ($hasil as $value) {
				$row2['no'] = $no++;
				$row2['no_rek'] = $value->no_rek;
				$row2['debit'] = 'Rp. '.number_format($value->debit, 0 , ',' , '.' );
				$row2['kredit'] = 'Rp. '.number_format($value->kredit, 0 , ',' , '.' );
				
				$row2['aksi'] = '<center>
				<button class="btn btn-primary btn-sm" onclick="editdetail('.$value->idbukas_detail.','.$value->id_norek.','.$value->debit.','.$value->kredit.')"><i class="fa fa-list"></i></button>&nbsp;<button class="btn btn-danger btn-sm" onclick="deletedetail('.$value->idbukas_detail.')"><i class="fa fa-trash"></i></button> 
							</center>';
				$row2['idbukas_detail'] = $value->idbukas_detail;
							
				$line2[] = $row2;
			}
		}	
			
			$line['data'] = $line2;

		echo json_encode($line);
    }

	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function insert_koderekening(){

		$data['kode']=$this->input->post('kode_rek');
		$data['perkiraan']=$this->input->post('perkiraan');
		$data['tl']=$this->input->post('jenis_tl');
		$data['tipe']=$this->input->post('jenis_tipe');
		$data['nb']=$this->input->post('jenis_nb');
		$data['nrl']=$this->input->post('jenis_nrl');
		if($this->input->post('upkode')!=''){
			$data['upkode']=$this->input->post('upkode');
		}
		$login_data = $this->load->get_var('user_info');
		$user = strtoupper($login_data->username);
		$data['xuser'] = $user;
		// var_dump($user);
		// $data['xuser']=$this->input->post('xuser');
		$data['zperkiraan']=$this->input->post('perkiraan');
		$data['statusflag']=$this->input->post('flag');
			
		$this->mrsakun->insert_rekening($data);
		
		// redirect('akun/crsakun/');
		//print_r($data);
	}

	public function insert_mataanggaran(){
		$data['kode_manggaran']=$this->input->post('kode_manggaran');
		$data['nm_manggaran']=$this->input->post('nm_manggaran');
		if($this->input->post('upkode')!=''){
			$data['upkode']=$this->input->post('upkode');
		}
		
		$data['status']=1;

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$data['xcreate']=$user;
		$data['xinput']=date('Y-m-d H:i:s');

		$id=$this->mrsakun->insert_mataanggaran($data);
		
		redirect('akun/crsakun/mata_anggaran');
	}

	public function insert_norekening(){

		$data['no_rek']=$this->input->post('no_rek');
		$data['deskripsi']=$this->input->post('deskripsi');
		$data['jns_bank']=$this->input->post('jns_bank');
		$data['deleted']='0';
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xcreate']=$user;
		$data['xinput']=date('Y-m-d H:i:s');
		$data['xuser'] = $user;
		$id=$this->mrsakun->insert_norek($data);
		
		redirect('akun/crsakun/norek');
		// print_r($data);
	}

	public function insert_bukasheader(){

		$data['no_bk']=$this->input->post('no_bk');
		$data['tgl_transaksi']=$this->input->post('tgl_transaksi');
		$data['uraian']=$this->input->post('deskripsi');
		$data['kode_mataanggaran']=$this->input->post('kode_manggaran');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		

		if($this->input->post('idbukas_header1')==''){
			$data['xcreate']=$user;
			$data['xinput']=date('Y-m-d H:i:s');
			$id=$this->mrsakun->insert_bukasheader($data);
		}else{
			$data['xuser']=$user;
			$data['xupdate']=date('Y-m-d H:i:s');
			$id=$this->mrsakun->edit_bukasheader($data,$this->input->post('idbukas_header1'));
		}

		echo json_encode($id);
	}

	public function insert_bukasdetail(){
		$data['idbukas_header']=$this->input->post('idbukas_header');
		$data['id_norek']=$this->input->post('id_norek');
		$data['debit']=$this->input->post('debit');
		$data['kredit']=$this->input->post('kredit');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		if($this->input->post('idbukas_detail')==''){
			$data['xcreate']=$user;
			$data['xinput']=date('Y-m-d H:i:s');
			$id=$this->mrsakun->insert_bukasdetail($data);
		}else{
			$data['xuser']=$user;
			$data['xupdate']=date('Y-m-d H:i:s');
			$id=$this->mrsakun->edit_bukasdetail($data,$this->input->post('idbukas_detail'));
		}
		

		echo json_encode($id);
	}

	public function get_data_edit_rekening(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_rekening($kode)->result();
	   	echo json_encode($datajson);
	}

	public function get_bukasheader_data(){
		$kode=$this->input->post('idbukas_header');
		$datajson=$this->mrsakun->get_data_bukasheader($kode)->result();
	   	echo json_encode($datajson);
	}

	public function get_data_edit_norekening(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_norek($kode)->result();
	   	echo json_encode($datajson);
	}

	public function get_data_mataanggaran(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_mataanggaran($kode)->result();
	    echo json_encode($datajson);
	}
	
	public function delete_rekening($kode=''){	
		$id=$this->mrsakun->delete_rekening($kode);
		echo json_encode($id);
	    // redirect('akun/crsakun/');
	}

	public function delete_norek($kode){	
		$data['deleted']=1;
		$id=$this->mrsakun->edit_norek($kode, $data);
		echo json_encode($id);
	    // redirect('akun/crsakun/norek');
	}

	public function active_rekening($kode=''){
		$data['deleted']='0';
		$datajson=$this->mrsakun->edit_norek($kode,$data);
		echo json_encode($datajson);
	    // redirect('akun/crsakun/norek');
	}

	public function delete_mataanggaran($kode){	
		$data['status']=0;

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$data['xuser']=$user;
		$data['xupdate']=date('Y-m-d H:i:s');

		$id=$this->mrsakun->edit_mataanggaran($kode, $data);
		
	    redirect('akun/crsakun/mata_anggaran');
	}

	public function delete_bukasdetail(){	
		$kode=$this->input->post('idbukas_header');
		$id=$this->mrsakun->delete_bukasdetail($kode);
		//echo $kode;
		//break;
	    echo json_encode($id);
	}

	public function delete_bukasheader(){	
		$kode=$this->input->post('idbukas_header');
		$data['deleted']=1;
		$id=$this->mrsakun->edit_bukasheader($data,$kode);
		//$id=$this->mrsakun->delete_bukasheader($kode);
		//echo $kode;
		//break;
	    echo json_encode($id);
	}


	public function edit_mataanggaran(){
		$kode=$this->input->post('edit_kode_hidden');
		$data['nm_manggaran']=$this->input->post('edit_nm_manggaran');
		if($this->input->post('edit_upkode')!=''){
			$data['upkode']=$this->input->post('edit_upkode');
		}else{
			$data['upkode']=null;
		}
		
		//$data['status']=$this->input->post('edit_status');

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$data['xuser']=$user;
		$data['xupdate']=date('Y-m-d H:i:s');

		$id=$this->mrsakun->edit_mataanggaran($kode, $data);
	
		redirect('akun/crsakun/mata_anggaran');
	}

	public function edit_norek(){
		$kode=$this->input->post('id_norek');
		$data['no_rek']=$this->input->post('edit_no_rek');
		$data['deskripsi']=$this->input->post('edit_deskripsi');
		$data['jns_bank']=$this->input->post('edit_jns_bank');
		$data['xupdate']=date('Y-m-d H:i:s');

		$id=$this->mrsakun->edit_norek($kode, $data);
	
		redirect('akun/crsakun/norek');
	}

	public function edit_rekening(){

		/*$data['kode'],$data['perkiraan'],$data['tl'],$data['tipe'],$data['nb'],$data['nrl'],$data['upkode'],$data['xuser'],$data['zperkiraan']*/

		$kode=$this->input->post('edit_kode_hidden');
		$data['perkiraan']=$this->input->post('edit_perkiraan');
		//$data['tipebt']=$this->input->post('edit_tb');
		$data['tl']=$this->input->post('edit_jenis_tl');
		$data['tipe']=$this->input->post('edit_tipe');
		$data['nb']=$this->input->post('edit_nb');
		$data['nrl']=$this->input->post('edit_nrl');
		if($this->input->post('edit_upkode')!=''){
			$data['upkode']=$this->input->post('edit_upkode');
		}else{
			$data['upkode']=null;
		}
		$data['xupdate']=$this->input->post('xupdate');
		$data['zperkiraan']=$this->input->post('edit_perkiraan');
		$data['statusflag']=$this->input->post('edit_flag');
		$id=$this->mrsakun->edit_rekening($kode, $data);	
		redirect('akun/crsakun');
		//print_r($data);
	}

	public function ajax_list($novoucher='')
	{
		$list = $this->mrsakun->get_datatables($novoucher);
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		foreach($voucher as $row){
			$tutup=$row->tutupvoucher;
		}
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dgns->novoucher;
			$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			$row[] = $dgns->rekening;
			if($dgns->tipe=='Kredit'){
				$row[] = '<div style="color:red;">'.$dgns->Nilai.'</div>';
			}else{
				$row[] = '<div style="color:navy;">'.$dgns->Nilai.'</div>';
			}			
			$row[] = $dgns->tipe;
			$row[] = $dgns->bt;
			$row[] = $dgns->pic;
			$row[] = $dgns->ket;
			if($tutup!='' && $tutup!='0000-00-00 00:00:00'){
				$row[] = '<a type="button" class="btn btn-danger btn-xs" href="javascript: void(0)" "><i class="fa fa-trash"></i></a>';
			}else{
				$row[] = '<a type="button" class="btn btn-danger btn-xs" href="'.base_url('akun/crsakun/delete_transaksi').'/'.$dgns->novoucher.'/'.$dgns->id.'" "><i class="fa fa-trash"></i></a>';
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all($novoucher),
						"recordsFiltered" => $this->mrsakun->count_filtered($novoucher),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list2($novoucher='')
	{
		$list = $this->mrsakun->get_datatables($novoucher);
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		foreach($voucher as $row){
			$tutup=$row->tutupvoucher;
		}
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dgns->novoucher;
			$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			$row[] = $dgns->rekening;
			if($dgns->tipe=='Kredit'){
				$row[] = '<div style="color:red;">'.$dgns->Nilai.'</div>';
			}else{
				$row[] = '<div style="color:navy;">'.$dgns->Nilai.'</div>';
			}			
			$row[] = $dgns->tipe;
			$row[] = $dgns->bt;
			$row[] = $dgns->pic;
			$row[] = $dgns->ket;
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all($novoucher),
						"recordsFiltered" => $this->mrsakun->count_filtered($novoucher),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list1()
	{
		$list = $this->mrsakun->get_datatables1();
		
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			/*if(($dgns->nilaidebet)-($dgns->nilaikredit)!=0){
				$row[] = '<div style="color:red;"><b>'.$dgns->novoucher.'</b></div>';
			}else if($dgns->nilaidebet=='' and $dgns->nilaikredit==''){
				$row[] = '<div style="color:black;">'.$dgns->novoucher.'</div>';
			}
			else*/
			$row[] = '<div style="color:green;"><b>'.$dgns->novoucher.'</b></div>';
			//$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			if($dgns->tglentry!=null){
				$row[] = date('d-m-Y',strtotime($dgns->tglentry));
			}else
				$row[] = '-';
			//$row[] = $dgns->tutupvoucher;
			if($dgns->tutupvoucher!=null){
				$row[] = date('d-m-Y',strtotime($dgns->tutupvoucher));
			}else
				$row[] = '-';
			//$row[] = date('d-m-Y',strtotime($dgns->tglvalidasi));
			if($dgns->tglvalidasi!=null and $dgns->tglvalidasi!='' and $dgns->tglvalidasi!='0000-00-00 00:00:00'){
				$row[] = date('d-m-Y',strtotime($dgns->tglvalidasi));
			}else
				$row[] = '-';
			$row[] = 'Status';
						
			//$row[] = '<a type="button" class="btn btn-warn btn-xs" href="'.base_url('akun/crsakun/voucher').'/'.$dgns->novoucher.'" "><i class="fa fa-plus"></i></a> <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_voucher('.$dgns->novoucher.')"><i class="fa fa-edit"></i></button>';
			$row[] = '<a type="button" class="btn btn-warn btn-xs" href="#"><i class="fa fa-plus"></i></a> <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_voucher('.$dgns->novoucher.')"><i class="fa fa-edit"></i></button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all1(),
						"recordsFiltered" => $this->mrsakun->count_filtered1(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function voucher($novoucher=''){

		$data['title'] = 'Voucher';
		$data['novoucher'] = $novoucher;
		$data['tglentry']='';
		$data['ket']='';
		$data['tutupvoucher']='';
		
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		
		print_r($novoucher);
		
		$data['href_ok']='javascript: void(0)';
		$data['ok']='0';
		foreach($voucher as $row){
			
			if($row->nilaidebet - $row->nilaikredit==0 and ($row->tutupvoucher==null or $row->tutupvoucher=='0000-00-00 00:00:00' )){
				$data['href_ok']=site_url('akun/crsakun/close_voucher').'/'.$novoucher;
				$data['ok']='1';
			}else{
				//$data['href_ok']='javascript: void(0)';
				//$data['ok']='0';
			}
			$data['tutupvoucher']=$row->tutupvoucher;
			$data['tglentry']=$row->tglentry;
			$data['ket']=$row->ket;
		}
		$data['bt']=$this->mrsakun->get_all_data_bt()->result();
		$data['rekening']=$this->mrsakun->get_all_data_jurnal_rekening()->result();

		$this->load->view('akun/v_vouchertrans',$data);		
	}


	public function open_voucher(){
		
		$novoucher= $this->input->post('novouch1');
		$data['ket'] = $this->input->post('ket1');
		$data['tutupvoucher']='0000-00-00 00:00:00';
		//$data['tglvalidasi']=date('Y-m-d');
		$data['temp']='1';
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		//redirect('/akun/crsakun/valid');	
	}

	public function close_voucher($novoucher=''){
		
		$data['novoucher'] = $novoucher;
		$data['tutupvoucher']=date('Y-m-d h:i:s');
		//$data['tglvalidasi']=date('Y-m-d');
		$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/voucher/'.$novoucher);	
	}

	public function valid_voucher($novoucher=''){
		
		$novoucher = $this->input->post('novouch2');
		$data['ket'] = $this->input->post('ket2');
		$data['tglvalidasi']=date('Y-m-d h:i:s');		
		$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/valid/'.$novoucher);	
	}

	public function open_valid($novoucher=''){
		
		$novoucher = $this->input->post('novouch1');
		$data['ket'] = $this->input->post('ket1');
		$data['tglvalidasi']='0000-00-00 00:00:00';		
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/valid/'.$novoucher);	
	}

	public function delete_transaksi($novoucher='',$id=''){				
		
		$this->mrsakun->delete_transaksi($id);

		redirect('akun/crsakun/voucher/'.$novoucher);	
	}

	public function list_voucher(){

		$data['title'] = 'Daftar Voucher';
		
		$data['tgltrans']='';
		//$data['voucher']=$this->mrsakun->get_all_data_voucher()->result();
		

		$this->load->view('akun/v_voucher',$data);		
	}

	
	public function edit_voucher(){

		$novoucher = $this->input->post('edit_novoucher_hidden');
		$data['tglentry'] = $this->input->post('edit_tgl_entry');
		$data['tutupvoucher']=$this->input->post('edit_tutup');
		$data['tglvalidasi']=$this->input->post('edit_tgl_validasi');
		$data['ket']=$this->input->post('edit_tgl_validasi');
		//$data['tglvalidasi']=date('Y-m-d');
		//$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/voucher/');		
	}
	
	public function get_data_edit_voucher(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_voucher($kode)->result();
	    	echo json_encode($datajson);
	}

	public function add_new_voucher(){

		$data['novoucher']=$this->input->post('new_no_voucher');
		$data['tglentry']=$this->input->post('new_tgl_entry');
		$data['temp']='1';
		$data['xuser']=$this->input->post('xuser');

		$this->mrsakun->insert_voucher($data);
		
		redirect('akun/crsakun/voucher/'.$this->input->post('new_no_voucher'));
		
	}

	public function add_new_transaksi(){

		$data['novoucher']=$this->input->post('trans_novoucher_hidden');
		$data['tgltransaksi']=$this->input->post('trans_tgltrans');		
		$data['Nilai']=$this->input->post('trans_nilai');
		$data['tipebt']=$this->input->post('trans_tipe');
		$data['ket']=$this->input->post('trans_ket');
		if($this->input->post('trans_bt')!=''){
			$data['kodebt']=$this->input->post('trans_bt');
			$data['pic']=$this->input->post('trans_pic');
		}
		$data['koderek']=$this->input->post('trans_koderek');
		$data['xuser']=$this->input->post('xuser');

		$this->mrsakun->insert_transaksi($data);
		//print_r($data);
		redirect('akun/crsakun/voucher/'.$data['novoucher']);
		
	}

	public function insert_voucher(){

		$data['kode']=$this->input->post('kode_rek');
		$data['perkiraan']=$this->input->post('perkiraan');
		$data['tl']=$this->input->post('jenis_tl');
		$data['tipe']=$this->input->post('jenis_tipe');
		$data['nb']=$this->input->post('jenis_nb');
		$data['nrl']=$this->input->post('jenis_nrl');
		if($this->input->post('upkode')!=''){
			$data['upkode']=$this->input->post('upkode');
		}
		$data['xuser']=$this->input->post('xuser');
		$data['zperkiraan']=$this->input->post('perkiraan');
		$data['statusflag']=$this->input->post('flag');

		$this->mrsakun->insert_voucher($data);
		
		redirect('akun/crsakun/voucher/');
		//print_r($data);
	}	

	function download_lap_bukas($tglawal,$tglakhir){
		if($tglawal!=''){
			$data_chart=$this->mrsakun->getdata_daftar_bukas($tglawal,$tglakhir)->result();
			//$data_chart=$this->Medmlaporan->get_chart_tindakan_rj($id_poli, $param1, $param2)->result();
			
			$this->load->library('Excel');  
		   
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   
				   
			// Set document properties  
			$namars=$this->config->item('namars');
			$objPHPExcel->getProperties()->setCreator($namars)  
				        ->setLastModifiedBy($namars)  
				        ->setTitle("Laporan Bukas ".$namars)  
				        ->setSubject("Laporan Bukas ".$namars." Document")  
				        ->setDescription("Laporan Bukas ".$namars.", generated by HMIS.")  
				        ->setKeywords($namars)  
				        ->setCategory("Laporan Bukas"); 
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_bukas.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);
			
				//$listtind = $this->Medmlaporan->get_chart_tind_detail($id_poli,$param1, $param2)->result();
				$listtind = $this->mrsakun->get_all_data_bukas_detail($tglawal,$tglakhir)->result();			
							
				$vtot1=0;
				$i=1;
				$rowCount = 4;	

				$masterrekening=$this->mrsakun->get_active_data_norek()->result();
				$objPHPExcel->getActiveSheet()->setTitle('Lap Bukas');
				$objPHPExcel->getActiveSheet()->mergeCells('A5:M5');
				$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');

				$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Periode '.date('d-m-Y',strtotime($tglawal)).' s/d '.date('d-m-Y',strtotime($tglakhir)));

				

				$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
				$objPHPExcel->getActiveSheet()->setCellValue('A8', 'NO BK');
				$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
				$objPHPExcel->getActiveSheet()->setCellValue('B8', 'URAIAN');
				$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
				$objPHPExcel->getActiveSheet()->setCellValue('C8', 'REFF');
				$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
				$objPHPExcel->getActiveSheet()->setCellValue('D8', 'DEBET');
				$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
				$objPHPExcel->getActiveSheet()->setCellValue('E8', 'KREDIT');

		      	$rowCount = 11;
		      	foreach($data_chart as $key) {
			        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $key->no_bk);
			        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->uraian);
			        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->reff);
			        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->total_debit);
			        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->total_kredit);

			        foreach($listtind as $row0) {
			        	$col = 5;
				        if($key->idbukas_header==$row0->idbukas_header){
				        	foreach($masterrekening as $row) {
				        		// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->id_poli);
				        		if($row0->id_norek==$row->id_norek){	
				        			//echo $row->banyak.' '.$row->nmtindakan;   */   			
				        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->sumdebit);
				        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $rowCount, $row0->sumkredit);
				        		}else{
				        			//echo $row->idtindakan.'=='.$row0->idtindakan;
				        			//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        			//if($hi==null && $hi<1){
				        			//	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        			//}
				        			
				        		}	
				        		$col=$col+2;	
				        	}
				    	}else{	    		
				    		//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        	//if($hi==null && $hi<1){
				        	//			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        	//}
				        	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, '0');		        	
				    	}
			        }
			        $rowCount++;
			    }

				$col = 5;
			    foreach($masterrekening as $key) {
			    	if($key->no_rek=='TUNAI'){
			    		$txtrek=$key->no_rek;
			    	}else{
			    		$txtrek=$key->jns_bank.' Rek. '.$key->no_rek;
			    	}
			    	$cell=PHPExcel_Cell::stringFromColumnIndex($col);
			    	$cell2=PHPExcel_Cell::stringFromColumnIndex($col+1);
			    	$objPHPExcel->getActiveSheet()->mergeCells($cell.'8:'.$cell2.'8');

			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 8, $txtrek);
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 9, 'DEBET');
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, 9, 'KREDIT');
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 10, $col+1);
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, 10, $col+2);
			        /*$cell=PHPExcel_Cell::stringFromColumnIndex($col);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$rowCount, '=SUM('.$cell.'10:'.$cell.($rowCount-1).')');*/
			        $col=$col+2;
			    }
				//break;
			    /*$col = 5;
			    foreach($hasil as $key) {
			    	$vtot1=$vtot1+$key->banyak;
			    	if($key->tgl_kunjungan){

			    	}else{

			    	}
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, $key->banyak);
			        $col++;
			    }*/
			    
			    for ($j=11;$j<$rowCount;$j++) {
					for ($i=5;$i<$col;$i++) {
					    $hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();//getCellValueByColumnAndRow();
					    if($hi==null || $hi==''){
					    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
					    }
					}
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '=SUM(D11:D'.($rowCount-1).')');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '=SUM(E11:E'.($rowCount-1).')');
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Seluruh');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);*/
			
			$filename = "Lap_bukas_".date('d F Y', strtotime($tglawal))."-".date('d F Y', strtotime($tglakhir));
			// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
			// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle($namars);    
			   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Cache-Control: max-age=0');  
			   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			// $objWriter->save('php://output');  
			$this->SaveViaTempFile($objWriter);
		
	}
	}

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}

	function penggunaan(){
        $data['title'] = 'Rekap Penggunaan Dana';
        $data['rencana'] = $this->mrsakun->getRencanaPenggunaan()->result(); 
        $data['mata_anggaran'] = $this->mrsakun->getMataAnggaran()->result();
        $this->load->view('akun/v_penggunaan_dana',$data);
	}

	function get_child_manggar(){
		$ma = $this->input->post('ma');
		$select = "";

		$data = $this->mrsakun->getMataAnggaranChild($ma)->result();

		//echo '<select name="sub_manggar" id="sub_manggar" class="form-control" style="width:100%">';

        foreach ($data as $datum) {
			echo "<option value ='".$datum->kode_manggaran."'>".$datum->nm_manggaran."</option>";
		}
	}

	function saveTransaksi(){
        $login_data = $this->load->get_var("user_info");
		$data = array(
			'rencana_penggunaan' => $this->input->post('rencana'),
			'mata_anggaran' => $this->input->post('mata_anggaran'),
			'ma_child' => $this->input->post('sub_manggar'),
			'jenis_penggunaan' => $this->input->post('jenis_penggunaan'),
			'sumber_dana' => $this->input->post('sumber_dana'),
			'nominal' => $this->input->post('nominal'),
			'keterangan' => $this->input->post('keterangan'),
			'status' => 1,
			'created_by' => $user = $login_data->username,
			'created_date' => date('Y-m-d H:i:s')
		);

		$save = $this->mrsakun->insertData('penggunaan_dana', $data);

		$hasil = array();
		if ($save > 0){
			$hasil['data'] = 'sukses';
		}else{
			$hasil['data'] = 'gagal';
		}

		echo json_encode($hasil);
	}
	public function dataPenggunaanDana(){
        $date1 = $this->input->post('date_picker_awal');
    	$date2 = $this->input->post('date_picker_akhir');

    	$line  = array();
        $line2 = array();
        $row2  = array();
        $a=0;
        $data = $this->mrsakun->getDataPenggunaan()->result();

        // $ma='';
        $ma_child='';
        foreach ($data as $value) {
        	$pagu_yms=0;
        	$pagu_bpjs=0;
        	$penggunaan_yms=0;
        	$penggunaan_bpjs=0;
        	$sisa_yms=0;
        	$sisa_bpjs=0;
        	// if($value->ma_child==$ma_child){
        	// }
            if(!empty($this->mrsakun->getDataPenggunaanPaguyms($value->ma_child)->row()->nominal)){
            	$pagu_yms=$this->mrsakun->getDataPenggunaanPaguyms($value->ma_child)->row()->nominal;
            }
			$row2['pagu_yms'] = $pagu_yms;
			if(!empty($this->mrsakun->getDataPenggunaanPagubpjs($value->ma_child)->row()->nominal)){
				$pagu_bpjs=$this->mrsakun->getDataPenggunaanPagubpjs($value->ma_child)->row()->nominal;
			}
    		$row2['pagu_bpjs'] = $pagu_bpjs;
	        $row2['pagu_total'] = $pagu_yms+$pagu_bpjs;

	        if(!empty($this->mrsakun->getDataPenggunaanPenggunaanyms($value->ma_child)->row()->nominal)){
	        	$penggunaan_yms=$this->mrsakun->getDataPenggunaanPenggunaanyms($value->ma_child)->row()->nominal;
	        }
    		$row2['penggunaan_yms'] = $penggunaan_yms;	
    		if(!empty($this->mrsakun->getDataPenggunaanPenggunaanbpjs($value->ma_child)->row()->nominal)){
    			$penggunaan_bpjs=$this->mrsakun->getDataPenggunaanPenggunaanbpjs($value->ma_child)->row()->nominal;
    		}
    		$row2['penggunaan_bpjs'] = $penggunaan_bpjs;
	        $row2['penggunaan_total'] = $penggunaan_yms+$penggunaan_bpjs;
    			

            $row2['rencana_penggunaan'] = $value->nm_manggaran;
            $row2['ma'] = $value->mata_anggaran;
            $row2['detail'] = $value->detail;

            $row2['sisa_yms'] = $pagu_yms-$penggunaan_yms;
            $row2['sisa_bpjs'] = $pagu_bpjs-$penggunaan_bpjs;
            $row2['sisa_total'] = $row2['pagu_total']-$row2['penggunaan_total'];
            $row2['aksi'] ='';
            $line2[] = $row2;
        }

        $line['data'] = $line2;
    	echo json_encode($line);
	}
}
?>
