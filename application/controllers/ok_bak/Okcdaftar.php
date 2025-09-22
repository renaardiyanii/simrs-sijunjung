<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Okcdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('ok/okmdaftar','',TRUE);
		$this->load->model('ok/okmkwitansi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('iri/rimpendaftaran','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Operasi';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok()->result();
		$this->load->view('ok/okvdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Operasi Tanggal '.$date;

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok_by_date($date)->result();
		$this->load->view('ok/okvdaftarpasien',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Operasi';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok_by_no($key)->result();
		$this->load->view('ok/okvdaftarpasien',$data);
	}

	public function pemeriksaan_ok($no_register=''){
		$data['title'] = 'Input Detail & Pemeriksaan Operasi';
		$data['id']='';
		$data['no_register']=$no_register;

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->okmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['type_rawat']='-';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->okmdaftar->get_data_pasien_pemeriksaan($no_register)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']=='KERJASAMA'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
				$data['type_rawat']='rawatjalan';
				$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();
				if($dataok){
					$data['id']=$dataok->idoperasi_header;
				}
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']=='KERJASAMA'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';		
				$data['type_rawat']='ruangrawat';
				$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();				
				if($dataok){
					$data['id']=$dataok->idoperasi_header;
				}
			}else{
				$dataok=$this->okmdaftar->get_operasi_header_bynoreservasi($no_register)->row();
				if($dataok){
					$data['id']=$dataok->idoperasi_header;
				}
				$data['nmkontraktor']='';		
				$data['type_rawat']='ruangrawat';
			}
		}

		// $data['data_jenis_ok']=$this->okmdaftar->get_jenis_ok()->result();
		// $data['data_jenis_ok']=$this->okmdaftar->get_jenis_ok()->result();
		$data['kamarok']=$this->okmdaftar->getdata_kamarok()->result();
		$data['data_pemeriksaan']=$this->okmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter']=$this->okmdaftar->getdata_dokter()->result();
		
		$data['perawat_anastesi']=$this->okmdaftar->getdata_perawat_anastesi()->result();
       
        // print_r()

		$data['perawat_asisten']=$this->okmdaftar->getdata_perawat_asisten()->result();

		$data['tindakan']=$this->okmdaftar->getdata_tindakan_pasien($data['kelas_pasien'])->result();
		// $data['dok_anas']=$this->okmdaftar->get_dok_anas()->result();
		// $data['jnsanestesi']=$this->okmdaftar->get_jenis_anestesi()->result();

		//$this->load->view('ok/okvpemeriksaan',$data);
		$this->load->view('ok/okvdetailjadwal',$data);
	}

	public function selesai_ok(){		
		$date=$this->input->post('date');
		if($date!=''){
			$tgl=date('Y-m-d');
		}
		$data['title'] = 'DAFTAR PASIEN HASIL OPERASI ';
		$data['operasi']=$this->okmdaftar->get_daftar_pasien_hasil_ok()->result();
		$this->load->view('ok/okvdaftarpengisian',$data);
		//print_r($data);
	}

	public function batal_ok($no_register){	
		if($no_register!=''){
			$data['ok']=0;
			$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();
			if($dataok){
				$data1['batal']=1;
				$idoperasi_header=$dataok->idoperasi_header;
				$id=$this->okmdaftar->update_detailok($data1,$idoperasi_header);
				if(substr($no_register, 0,2)=="RJ"){
					$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
				}else if(substr($no_register, 0,2)=="RI"){
					$id=$this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_register);
				}
				$this->session->set_flashdata('success_msg',
					"<div class='alert alert-success alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-close'></i> Permintaan Operasi Pasien telah berhasil dibatalkan.
					</div>");
			}else{
				if(substr($no_register, 0,2)=="RJ"){
					$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
				}else if(substr($no_register, 0,2)=="RI"){
					$id=$this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_register);
				}
				$this->session->set_flashdata('success_msg',
					"<div class='alert alert-success alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-close'></i> Permintaan Operasi Pasien telah berhasil dibatalkan.
					</div>");
			}
			

			redirect('ok/okcdaftar','refresh');
		}
	}

	public function jadwal_operasi(){
		$data['title'] = 'JADWAL PASIEN OPERASI';

		$this->load->view('ok/okvjadwal',$data);
		//print_r($data);
	}

	public function get_data_item_pemeriksaan($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_data_item_pemeriksaan_byid($id)->row();
			echo json_encode($data_header);
		}
		
	}

	function get_itempemeriksaan($idoperasi_header=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->okmdaftar->get_data_pemeriksaan_byidokhead($idoperasi_header)->result();		
		
		/*<th>No</th>												  	
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Operator</th>												  	
												  	<th width="10%">Total Pemeriksaan</th>
												  	<th width="5%">Aksi</th>*/		
		foreach ($hasil as $value) {
			$row2['id_pemeriksaan_ok'] = $value->id_pemeriksaan_ok;
			$row2['jenis_tindakan'] = $value->jenis_tindakan;
			//$row2['biaya_ok'] = $value->biaya_ok;
			//$row2['qty'] = $value->qty;
			$row2['vtot'] = number_format($value->vtot,0);
			$txtdokter='Dokter 1 : '.$value->nm_dokter.' ('.$value->id_dokter.')';										
			if($value->id_dokter2<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter 2 : '.$value->nm_dokter2.' ('.$value->id_dokter2.')';
			if($value->id_dokter_asist<>NULL)
				$txtdokter=$txtdokter.'<br>Asisten Dokter : '.$value->nm_asist_dokter;
			if($value->id_dok_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anestesi: '.$value->nm_dok_anes.' ('.$value->id_dok_anes.')';
			if($value->perawat_anastesi<>NULL)
				$txtdokter=$txtdokter.'<br>Perawat Anestesi: '.$value->perawat_anastesi;
			if($value->jns_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Jenis Anestesi: '.$value->jns_anes;
			if($value->id_dok_anak<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anak: '.$value->nm_dok_anak.' ('.$value->id_dok_anak.')';
			$row2['operator'] = $txtdokter;
			$row2['aksi'] = '<button type="button" class="btn btn-success btn-xs" onClick="edit_data_pemeriksaan('.$value->id_pemeriksaan_ok.')"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn btn-danger btn-xs" onClick="hapus_data_pemeriksaan('.$value->id_pemeriksaan_ok.')"><i class="fa fa-trash"></i></button>';		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }


	function detail_ok($idoperasi_header=''){
    	if($idoperasi_header!=''){    		
    		
    		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();

    	//	print_r($data['data_pasien']);die();

				if($data['data_pasien']->no_register==null){
					$data['title'] = 'DETAIL OPERASI PASIEN | '.$data['data_pasien']->no_reservasi;
	    		}else{
	    			$data['title'] = 'DETAIL OPERASI PASIEN | '.$data['data_pasien']->no_register;
	    		}
	    		$data['id']=$idoperasi_header;
	    		$data['no_register']=$data['data_pasien']->no_register;
				$data['nama']=$data['data_pasien']->nama;
				$data['alamat']=$data['data_pasien']->alamat;
				$data['dokter_rujuk']=$data['data_pasien']->nm_dokter;
				$data['no_medrec']=$data['data_pasien']->no_medrec;
				$data['no_cm']=$data['data_pasien']->no_cm;
				$data['kelas_pasien']=$data['data_pasien']->kelas;
				$data['tgl_kun']=$data['data_pasien']->tgl_daftar;
				$data['type_rawat']=$data['data_pasien']->type_rawat;			
				$data['cara_bayar']=$data['data_pasien']->carabayar;

				if($data['data_pasien']->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$data['data_pasien']->foto;
				}

				if($data['data_pasien']->type_rawat=='ruangrawat'){					
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']=$data['data_pasien']->bed;
				}else{
					$data['idrg']=$data['data_pasien']->nm_poli;
					$data['bed']='-';
				}
				if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else{
					$data['nmkontraktor']='';
				}
				$data['kamarok']=$this->okmdaftar->getdata_kamarok()->result();
				$data['dokter']=$this->okmdaftar->getdata_dokter()->result();
				
				$data['tindakan']=$this->okmdaftar->getdata_tindakan_pasien($data['kelas_pasien'])->result();

			//	$data['tindakan']=$this->okmdaftar->getdata_tindakan_pasien($data['kelas_pasien'])->result();

			$this->load->view('ok/okvdetailjadwal',$data);
    	}
    }

    public function get_operasi_header($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_operasi_header_byid($id)->row();
			echo json_encode($data_header);
		}
		
	}

    public function save_detailok()
	{
		$data['no_reservasi']=$this->input->post('no_reservasi');
		if($this->input->post('no_register')!=''){
			$data['no_register']=$this->input->post('no_register');
		}		
		$data['type_rawat']=$this->input->post('type_rawat');
		$data['ruang_rawat']=$this->input->post('idrg');
		$data['id_dokter']=$this->input->post('id_dokter');
		$data['tgl_daftar']=date('Y-m-d');
		
				
		$data['prioritas']=$this->input->post('prioritas');
		$data['ket']=$this->input->post('ket');		
		$data['tgl_jadwal_ok']=$this->input->post('tgl_jadwal_ok');
		$data['intime_jadwal_ok']=$this->input->post('intime_jadwal_ok');
		$data['xinput']=$this->input->post('xuser');
		$data['xupdate']=date('Y-m-d H:i:s');
		/*$data['no_ok']=$this->input->post('no_ok');
		if($data['no_ok']!=''){
		} else {
			$this->okmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_ok']=$this->okmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_ok;
		}*/
		$idoperasi_header=$this->input->post('idoperasi_header');
		if($idoperasi_header!=''){
			$id=$this->okmdaftar->update_detailok($data,$idoperasi_header);
		}else{
			$id=$this->okmdaftar->insert_detailok($data);
		}
		echo json_encode($id);
		
		
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=$this->okmdaftar->get_biaya_tindakan($id_tindakan,$kelas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['idkamar_operasi']=$this->input->post('idkamar_operasi');
		$data['idoperasi_header']=$this->input->post('idoperasi_header');
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data_tindakan=$this->okmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['id_dokter']=$this->input->post('id_dokter1');
		$data['id_dokter2']=$this->input->post('id_dokter2');
		//$data['id_opr_anes']=$this->input->post('id_opr_anes');
		$data['id_dokter_asist']=$this->input->post('id_dokter_asist');

		if($this->input->post('perawat_anas')!=''){
			$data['perawat_anastesi']=$this->input->post('perawat_anas');
		}
		$data['id_dok_anes']=$this->input->post('id_dok_anes');
		$data['jns_anes']=$this->input->post('jns_anes');
		$data['id_dok_anak']=$this->input->post('id_dok_anak');
		//$data['tgl_jadwal']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		//$data['tgl_operasi']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		$data['biaya_ok']=$this->input->post('biaya_ok_hide');
		$data['qty']=$this->input->post('qty');
		$data['biaya_tambahan_ok']=$this->input->post('biaya_tambahan_ok');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');
		$data['xupdate']=$this->input->post('xupdate');

		/*$data['no_ok']=$this->input->post('no_ok');
		if($data['no_ok']!=''){
		} else {
			$this->okmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_ok']=$this->okmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_ok;
		}*/
		
		//redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register'].'/'.$data['no_ok']);
		if($this->input->post('id_pemeriksaan_ok')!=''){
			$id=$this->okmdaftar->update_pemeriksaan($data,$this->input->post('id_pemeriksaan_ok'));
		}else{
			$id=$this->okmdaftar->insert_pemeriksaan($data);
		}
		echo json_encode($id);
		//redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register']);
		//print_r($data);
	}

	public function save_pemeriksaan(){
		if( isset( $_POST['myCheckboxes'] ) )
		{
		    for ( $i=0; $i < count( $_POST['myCheckboxes'] ); $i++ )
		    {
		        $data['no_register']=$this->input->post('no_register');
				$data['no_medrec']=$this->input->post('no_medrec');
				$data['id_tindakan']=$this->input->post('myCheckboxes['.$i.']');
				$data['kelas']=$this->input->post('kelas_pasien');
				$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan=$this->okmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach($data_tindakan as $row){
					$data['jenis_tindakan']=$row->nmtindakan;
				}
				$data['qty']='1';
				$data['id_dokter']=$this->input->post('id_dokter');
				$data_dokter=$this->okmdaftar->getnama_dokter($data['id_dokter'])->result();
				foreach($data_dokter as $row){
					$data['nm_dokter']=$row->nm_dokter;
				}
				$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				$data['vtot']=$data['biaya_ok'];
				$data['idrg']=$this->input->post('idrg');
				$data['bed']=$this->input->post('bed');
				$data['cara_bayar']=$this->input->post('cara_bayar');
				$data['xinput']=$this->input->post('xuser');

				$this->okmdaftar->insert_pemeriksaan($data);
		    }
			
			echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR OK DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotok=$this->okmdaftar->get_vtot_ok($no_register)->row()->vtot_ok;
		$getrdrj=substr($no_register, 0,2);

		$data['status']=1;		
		$data['xupdate']=date('Y-m-d H:i:s');
		$idoperasi_header=$this->input->post('idoperasi_header');		
		$id=$this->okmdaftar->update_detailok($data,$idoperasi_header);

		$no_ok=$idoperasi_header;
		if($getrdrj=="RJ"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotok,$no_ok);
		}		
		else if ($getrdrj=="RI"){
			$data_iri=$this->okmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_ok=$row->status_ok;
			}
			$status_ok = $status_ok + 1;
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_ok,$getvtotok,$no_ok);
		}

		// if($getrdrj=="PL"){
		// 	echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';

		// 	redirect('ok/okcdaftar/','refresh');
		// } 
		// else if($getrdrj=="RJ"){
		// 	echo '<script type="text/javascript">window.close();
		// 	window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
		// }
		// else 
		if ($getrdrj=="RJ"){
			echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
		 	redirect('ok/okcdaftar/','refresh');
		}
		else if ($getrdrj=="RI"){
			echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
			redirect('ok/okcdaftar/','refresh');
		}

		// echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';

		// redirect('ok/Labcdaftar/','refresh');
		
		//print_r($getvtotok);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_ok='')
	{
		$this->okmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_ok);
        echo json_encode(array("status" => $id_pemeriksaan_ok));
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		//$data['xuser']=$this->input->post('xuser');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->okmdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['ok']='1';
		
		$this->okmdaftar->insert_pasien_luar($data);
		
		redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register']);
		print_r($data);
	}

	public function cetak_faktur($no_ok='')
	{
		$jumlah_vtot=$this->okmdaftar->get_vtot_no_ok($no_ok)->row()->vtot_no_ok;
		if($no_ok!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->okmkwitansi->get_data_pasien($no_ok)->row();
			$data_pemeriksaan=$this->okmkwitansi->get_data_pemeriksaan($no_ok)->result();
			
			$cterbilang=new rjcterbilang();

			$tahun=0;
			$bulan=0;
			$hari=0;
			$tahun=floor($data_pasien->tgl_lahir/365);
			$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
			$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);
			
			$jumlah_vtot0=0;
			foreach($data_pemeriksaan as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot0);

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					.table-font-size2{
						font-size:9px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>
					<hr/>
					<p align=\"center\"><b>
					FAKTUR OPERASI<br/>
					No. OK_$no_ok
					</b></p>
					<table>
						<tr>
							<td width=\"20%\"><b>Terbilang</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>							
						</tr>
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"78%\"></td>							
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->no_register</td>
							<td width=\"20%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->nama</td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td>$data_pasien->no_cm</td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td>$tahun tahun, $bulan bulan, $hari hari.</td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
						</tr>
					</table>
					<br/><br/>

					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"55%\"><p align=\"center\"><b>Nama Pemeriksaan</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Biaya</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
					";
					$i=1;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."
						<tr>
						  	<td><p align=\"center\">$i</p></td>
						  	<td>$row->jenis_tindakan</td>
						  	<td><p align=\"right\">".number_format( $row->biaya_ok, 2 , ',' , '.' )."</p></td>
						  	<td><p align=\"center\">$row->qty</p></td>
						  	<td><p align=\"right\">$vtot</P></td>
						</tr>";
						$i++;

					}

				$konten=$konten."
						<tr>
							<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
						$this->load->helper('pdf_helper');
					
				$konten=$konten."
					</table>
					<br>
					<br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>Kamar Operasi
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>
					";
			
			// $file_name="FKTR_$no_ok.pdf";
			$file_name="FKTR_OK_".$no_ok."_".$data_pasien->nama.".pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('10', '5', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ok/okfaktur/'.$file_name, 'FI');
		}else{
			redirect('ok/okcdaftar/','refresh');
		}
	}
}