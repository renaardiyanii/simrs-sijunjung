<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class Okcdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('ok/okmdaftar','',TRUE);
		$this->load->model('ird/rdmpelayanan','',TRUE);
		$this->load->model('emedrec/M_emedrec','',TRUE);
        $this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('ok/okmkwitansi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/ModelPelayanan','',TRUE);
		$this->load->model('iri/rimpendaftaran','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
		$this->load->model('emedrec/M_emedrec_iri','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('master/mmform','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Operasi';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok()->result();
		$this->load->view('ok/okvdaftarpasien',$data);



		// $date=$this->input->post('date');
		// $key=$this->input->post('key');
		// if(!empty($date)){
		// 	$data['title'] = 'DAFTAR PASIEN RADIOLOGI Tanggal '.date('d-m-Y',strtotime($date));
		// 	$data['laboratorium']=$this->labmdaftar->get_daftar_pasien_ok_by_date($date)->result();
		// }else if(!empty($key)){
		// 	$data['title'] = 'DAFTAR PASIEN LABORATORIUM | '.$key;
		// 	$data['laboratorium']=$this->labmdaftar->get_daftar_pasien_ok_by_no($key)->result();
		// }else{
		// 	$data['title'] = 'DAFTAR PASIEN LABORATORIUM Tanggal '.date('d-m-Y');
		// 	$data['laboratorium']=$this->labmdaftar->get_daftar_pasien_ok_by_date(date('Y-m-d'))->result();
		// }
		
		// $this->load->view('ok/okvdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Operasi Tanggal '.date('d-m-Y',strtotime($date));;

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok_by_date($date)->result();
		$this->load->view('ok/okvdaftarpasien',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Operasi';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok_by_no($key)->result();
		$this->load->view('ok/okvdaftarpasien',$data);
	}

	public function pemeriksaan_ok_($no_register='',$pelayan = ''){
		$data['title'] = 'Input Detail & Pemeriksaan Operasi';
		$data['id']='';
		$data['id_item_ok']='';
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
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA'){
						$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;
					}else{ $data['nmkontraktor']='';}
					$data['bed']='Rawat Jalan';
					$data['kelas_pasien']='III';
					$data['type_rawat']='rawatjalan';
					$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();
					if($dataok){
						$data['id']=$dataok->idoperasi_header;
					}
				}else{
					redirect("ok/okcdaftar");
				}	
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA'){
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;	
					}else{ $data['nmkontraktor']='';		}
					$data['type_rawat']='ruangrawat';
					$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();				
					if($dataok){
						$data['id']=$dataok->idoperasi_header;
					}
				}else{
					redirect("ok/okcdaftar");
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
		$data['perawat_asisten']=$this->okmdaftar->getdata_perawat_asisten()->result();

		$data['diagnosa']=$this->okmdaftar->get_all_diagnosa()->result();

		// $data['tindakan']=$this->okmdaftar->getdata_tindakan_pasien($data['kelas_pasien'])->result();
		$data['tindakan']=$this->okmdaftar->get_all_tindakan()->result();
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($data['no_register'])->row();
		// $data['dok_anas']=$this->okmdaftar->get_dok_anas()->result();
		// $data['jnsanestesi']=$this->okmdaftar->get_jenis_anestesi()->result();

		//$this->load->view('ok/okvpemeriksaan',$data);
		$data['tindakan_operasi'] = 'hide';

		$this->load->view('ok/okvdetailjadwal',$data);
	}

	public function pemeriksaan_ok($no_register='',$pelayan = ''){
		$data['title'] = 'Input Detail & Pemeriksaan Operasi';
		$data['id']='';
		$data['id_item_ok']='';
		$data['no_register']=$no_register;
		// var_dump($no_register);die();

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
			// var_dump($data['data_pasien_pemeriksaan']);die();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['poli']=$row->poli;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				// var_dump($data['cara_bayar']);die();
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA'){
						$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;
					}else{ $data['nmkontraktor']='';}
					$data['bed']='Rawat Jalan';
					$data['kelas_pasien']='III';
					$data['type_rawat']='rawatjalan';
					$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();
					if($dataok){
						$data['id']=$dataok->idoperasi_header;
					}
				}else{
					redirect("ok/okcdaftar");
				}	
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA'){
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;	
					}else{ $data['nmkontraktor']='';		}
					$data['type_rawat']='ruangrawat';
					$dataok=$this->okmdaftar->get_operasi_header_bynoreg($no_register)->row();				
					if($dataok){
						$data['id']=$dataok->idoperasi_header;
					}
				}else{
					redirect("ok/okcdaftar");
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

	
		$data['kamarok']=$this->okmdaftar->getdata_kamarok()->result();
		$data['data_pemeriksaan']=$this->okmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter']=$this->okmdaftar->getdata_dokter2()->result();
		$data['perawat_anastesi']=$this->okmdaftar->getdata_perawat_anastesi()->result();
		$data['perawat_asisten']=$this->okmdaftar->getdata_perawat_asisten()->result();

		$data['diagnosa']=$this->okmdaftar->get_all_diagnosa()->result();

	
		$data['tindakan']=$this->okmdaftar->get_all_tindakan()->result();
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($data['no_register'])->row();
		$data['tindakan_operasi'] = 'hide';

		$this->load->view('ok/okvjadwalok',$data);
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
		$data['dokter_bedah']=$this->okmdaftar->get_data_dokter_bedah()->result();

		$this->load->view('ok/okvjadwal',$data);
		//print_r($data);
	}

	public function list_tindak($idoperasi_header='') {
		$data['id'] = $idoperasi_header;
		if($idoperasi_header!=''){    		
    		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
			//  print_r($data['data_pasien']);die();

				if($data['data_pasien']->no_register==null){
					$data['title'] = 'DETAIL PERIAPAN OPERASI PASIEN | '.$data['data_pasien']->no_reservasi;
	    		}else{
	    			$data['title'] = 'DETAIL PERSIAPAN OPERASI PASIEN | '.$data['data_pasien']->no_register;
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
				$data['cara_bayar']=$data['data_pasien']->cara_bayar;			
				$data['id_poli']=$data['data_pasien']->id_poli;

				if(substr($data['no_register'],0,2) == 'RI') {
					$noregasal = $this->rimtindakan->get_noregasal($data['no_register'])->row()->noregasal;
				}

				if($data['data_pasien']->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$data['data_pasien']->foto;
				}

				if($data['data_pasien']->type_rawat=='ruangrawat'){					
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']=$data['data_pasien']->bed;
				}else{
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']='-';
				}
				if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=isset($kontraktor)?$kontraktor:null;
				}else{
					$data['nmkontraktor']='';
				}

				// $data['data_pemeriksaan']=$this->okmdaftar->get_data_pemeriksaan($data['no_register'])->result();
				// $data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($data['no_register'])->row();
				// var_dump($data['data_pasien']);die();
				// $data['id_item_ok']='';	
				
				
				$data['laporan_pembedahan'] = $this->okmdaftar->get_laporan_pembedahan($data['data_pasien']->no_register)->row();
				$data['checklist_keselamatan_operasi'] =$this->rimtindakan->get_checklist_keselamatan_pasien_operasi($idoperasi_header)->row();
				$data['peng_anastesi_sedasi'] =$this->rimtindakan->get_pra_anastesi_sedasi_ok($idoperasi_header)->row();
				$data['caper_peri_operatif'] =$this->rimtindakan->get_kep_perioperatif_ok($idoperasi_header)->row();
				$data['catatan_pemulihan'] =$this->rimtindakan->get_catatan_kamar_pemulihan_ok($idoperasi_header)->row();
				$data['lap_bedah_anestesi_lokal'] =$this->rimtindakan->get_laporan_pembedahan_anestesi_lokal_ok($idoperasi_header)->row();
				$data['lap_bedah_anestesi'] =$this->rimtindakan->get_pembedahan_anastesi_ok($idoperasi_header)->row();
				$data['pramedi_pasca_operasi'] =$this->rimtindakan->get_premedi_pasca_bedah_ok($idoperasi_header)->row();
				$data['status_sedasi_sjj'] =$this->rimtindakan->get_status_sedasi_ok($idoperasi_header)->row();
				$data['tindakan_anestesi_sedasi'] =$this->rimtindakan->get_anastesi_sedasi_ok($idoperasi_header)->row();
				$data['edukasi_anestesi_sedasi'] =$this->rimtindakan->get_edukasi_anestesi_ok($idoperasi_header)->row();
				$data['assesmen_pra_induksi'] =$this->rimtindakan->get_assesment_pra_induksi($idoperasi_header)->row();
			$this->load->view('ok/okvlist_tindak',$data);
    	}
	}

	public function surveilans() {
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$id = $this->input->post('id_ok');
		if(substr($noipd,0,2) == 'RI') {
			$idrg = $this->rimtindakan->get_idrg_pasien_iri($noipd)->row()->idrg;
		}
		
		$check = $this->rimtindakan->get_surveilans_iri($noipd);
		if($check->num_rows()) {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			if(substr($noipd,0,2) == 'RI') {
				$data['idrg'] = $idrg;
			}
			$data['id_ok'] = $id;
			$submitdata = $this->rimtindakan->update_surveilans_iri($noipd, $data);
		} else {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			if(substr($noipd,0,2) == 'RI') {
				$data['idrg'] = $idrg;
			}
			$data['id_ok'] = $id;
			$submitdata = $this->rimtindakan->insert_surveilans($data);
		}
		$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));

		echo $response;
	}

	public function persiapan_operasi(){
		$data['title'] = 'PERSIAPAN UNTUK PASIEN OPERASI';
		// $data['dokter_bedah']=$this->okmdaftar->get_data_dokter_bedah()->result();

		$this->load->view('ok/okvpersiapan',$data);
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
			//print_r($hasil);die();
		
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
		// var_dump($idoperasi_header);die();
    	if($idoperasi_header!=''){    		
    		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
			// var_dump($data['data_pasien']->no_register);die();

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
				$data['cara_bayar']=$data['data_pasien']->cara_bayar;			
				$data['id_poli']=$data['data_pasien']->id_poli;
				$data['prioritas']=$data['data_pasien']->prioritas;

				if($data['data_pasien']->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$data['data_pasien']->foto;
				}

				if($data['data_pasien']->type_rawat=='ruangrawat'){					
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']=$data['data_pasien']->bed;
				}else{
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']='-';
				}
				if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else{
					$data['nmkontraktor']='';
				}
				$data['data_pemeriksaan']=$this->okmdaftar->get_data_pemeriksaan($data['no_register'])->result();
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($data['no_register'])->row();
				$data['perawat_anastesi']=$this->okmdaftar->getdata_perawat_anastesi()->result();
				//$data['perawat_asisten']=$this->okmdaftar->getdata_perawat_asisten()->result();
				//$data['perawat_asisten']=$this->okmdaftar->get_all_perawat()->result();
				$data['perawat_asisten']=$this->okmdaftar->get_all_perawat2()->result();
				$data['kamarok']=$this->okmdaftar->getdata_kamarok()->result();
				//$data['dokter']=$this->okmdaftar->getdata_dokter()->result();
				$data['dokter'] = $this->okmdaftar->getdata_dokter2()->result();
				// $data['tindakans']=$this->okmdaftar->getdata_tindakan_pasien($data['kelas_pasien'])->result();
				$data['tindakan']=$this->okmdaftar->getdata_jenis_tindakan_ok_by_prioritas($data['prioritas'])->result();	
	
				$data['id_item_ok']='';		
				
			$data['tindakan_operasi'] = 'show';	
			$this->load->view('ok/okvdetailjadwal',$data);
    	}
    }

	public function form($kode, $no_register, $idoperasi_header) {
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;

		$data['no_register'] = $no_register;
		$data['id'] = $idoperasi_header;
		$datenow = date('Y-m-d');
		// $no_medrecrad=$this->rjmpelayanan->get_medrec_pasienrad($no_register)->row()->no_medrec;
		// $data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		// $data['no_medrec'] = $data['data_pasien_daftar_ulang']->no_medrec;
		// $data['kelas_pasien']=$data['data_pasien_daftar_ulang']->kelas_pasien;
		// $data['cara_bayar']=$data['data_pasien_daftar_ulang']->cara_bayar;
		// $data['id_dokterrawat']=$data['data_pasien_daftar_ulang']->id_dokter;
		// $data['id_poli']=$data['data_pasien_daftar_ulang']->id_poli;
		// $data['data_tindakan_pasien']=$this->rjmpelayanan->getdata_tindakan_pasien($no_register)->result();
		// $data['unpaid']='';
		$data['pelayan']='OK';
		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
		$data['data_pasien2'] = $this->rimtindakan->get_pasien_by_no_ipd($data['no_register']);
		//  var_dump($data['data_pasien2']); die();
		$views = $this->mmform->get_form_by_kode_ok($kode)->row()->views;



		switch($kode){
			case 'status_sedasi':
				$data['status_sedasi'] = $this->rimtindakan->get_status_sedasi($idoperasi_header)->row();
				$data['status_sedasi_grafik_pemantauan'] = $this->rimtindakan->get_status_sedasi_grafik_pemantauan($idoperasi_header)->row();
				break;
			case 'check_persiapan':
				$data['checklist_persiapan_operasi'] =$this->rimtindakan->get_checklist_persiapan_operasi($idoperasi_header)->row();
				$data['persetujuan_tind_kedokteran'] = $this->rimtindakan->get_persetujuan_dokter($no_register);
				break;
			case 'asuhan_keperawatan':
				$data['asuhan_keperawatan_peri_operatif'] =$this->rimtindakan->get_asuhan_keperawatan_peri_operatif($idoperasi_header)->row();
				$data['persetujuan_tind_kedokteran'] = $this->rimtindakan->get_persetujuan_dokter($no_register);
				break;
			case 'pra_anestesi':
				$data['assesment_pra_anestesi'] =$this->rimtindakan->get_assesment_pra_anastesi($idoperasi_header)->row();
				break;
			case 'check_keselamatan':
				$data['checklist_keselamatan_operasi'] =$this->rimtindakan->get_checklist_keselamatan_pasien_operasi($idoperasi_header)->row();
				break;
			case 'lap_operasi':
				$data['laporan_operasi'] = $this->rimtindakan->get_laporan_operasi($idoperasi_header)->row();
				$data['get_data_ok'] =$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
				break;
			case 'lap_anestesi':
				$data['laporan_anestesi'] = $this->rimtindakan->get_laporan_anestesi($idoperasi_header)->row();
				$data['laporan_anestesi_grafik_pemantauan'] = $this->rimtindakan->get_laporan_anestesi_grafik_pemantauan($idoperasi_header)->row();
				$data['get_data_ok'] =$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
				break;
			case 'cat_serah':
				if(substr($no_register,0,2) == 'RI') {
					$data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($data['no_register'],$data['data_pasien2'][0]['noregasal']);
					$data['nmruang'] = $data['data_pasien2'][0]['nmruang'];
					$data['diagmasuk'] = $data['data_pasien2'][0]['diagmasuk'];
					$data['nm_diagmasuk'] = $data['data_pasien2'][0]['nm_diagmasuk'];
				} else {
					$data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($data['no_register'], '');
					$data['nmruang'] = $this->okmdaftar->get_nm_poli($data['no_register'])->row()->nm_poli;
					$data['diagmasuk'] = $this->okmdaftar->get_nm_poli($data['no_register'])->row()->diagmasuk;
					$data['nm_diagmasuk'] = $this->okmdaftar->get_nm_poli($data['no_register'])->row()->nm_diagmasuk;
				}
				$data['user'] = $login_data;
				break;
			case 'surveilans':
				if(substr($no_register,0,2) == 'RI') {
					$noregasal = $this->rimtindakan->get_noregasal($no_register)->row()->noregasal;
					$data['survei_iri'] = $this->rimtindakan->get_surveilans_iri($no_register)->row();
					$data['survei_irj'] = $this->rdmpelayanan->get_surveilans_irj($noregasal)->row();
					$data['dpo_surveilans'] = $this->rimtindakan->get_dpo_surveilans($no_register)->result();
					$data['keperawatan_igd'] = $this->M_emedrec->get_data_asesmen_keperawatan_ird($noregasal)->row();
					$data['suhu_fisik'] = $this->rimtindakan->get_suhu_from_pem_fisik($noregasal)->row()->suhu;
				} else {
					$data['keperawatan_igd'] = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_register)->row();
					$data['suhu_fisik'] = $this->rimtindakan->get_suhu_from_pem_fisik($no_register)->row()->suhu;
					$data['survei_irj'] = $this->rdmpelayanan->get_surveilans_irj($no_register)->row();
					$data['keperawatan_igd'] = $this->M_emedrec->get_data_asesmen_keperawatan_ird($no_register)->row();
					$data['suhu_fisik'] = $this->rimtindakan->get_suhu_from_pem_fisik($no_register)->row()->suhu;
				}
				$data['survei_ok'] =$this->rimtindakan->get_surveilans_by_ok($idoperasi_header)->row();
				$data['lap_anestesi'] = $this->rimtindakan->get_laporan_anestesi($idoperasi_header)->row();
				$data['lap_operasi'] = $this->rimtindakan->get_laporan_operasi($idoperasi_header)->row();
				$data['persiapan_opr'] =$this->rimtindakan->get_checklist_persiapan_operasi($idoperasi_header)->row();
				break;
				case 'patologi_anatomi':
					$data['patologi_klinik'] = $this->rimtindakan->get_patologi_klinik($no_register)->row();
				break;
				case 'lab':
					if(substr($no_register,0,2) == 'RI'){
						$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_register)->result();
						$data['list_lab_pasien'] = $this->rimtindakan->getdata_lab_pasien_ri($no_register, $datenow)->result();
					}else{
						$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->result();
						$data['list_lab_pasien']=$this->rjmpelayanan->getdata_lab_pasien($no_register,$datenow)->result();
					}
					
				break;
				case 'rad':
					if(substr($no_register,0,2) == 'RI'){
						$data['list_rad_pasien'] = $this->rimtindakan->getdata_rad_pasien_ri($no_register, $datenow)->result();
						$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_register)->result();
					}else{
						$data['rujukan_penunjang']=$this->rjmpelayanan->get_rujukan_penunjang($no_register)->result();
						$data['list_rad_pasien']=$this->rjmpelayanan->getdata_rad_pasienrj($no_register,$datenow)->result();
					}

				case 'lap_pembedahan':
					$data['laporan_pembedahan'] = $this->okmdaftar->get_laporan_pembedahan($no_register)->row();
					// var_dump($data['laporan_pembedahan']);die();
					$data['get_data_ok'] =$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
					break;
					case 'anestesi_sedasi':
						$data['peng_anastesi_sedasi'] = $this->rimtindakan->get_pra_anastesi_sedasi_ok($idoperasi_header)->row();
						break;
	
					case 'caper_peri_operatif':
						$data['caper_perioperatif'] = $this->rimtindakan->get_kep_perioperatif_ok($idoperasi_header)->row();
						$data['fisik'] = $this->rimtindakan->getdata_form_json_ok($no_register)->row();
						break;
					case 'catatan_anestesi_pemulihan':
						$data['catatan_pemulihan'] = $this->rimtindakan->get_catatan_kamar_pemulihan_ok($idoperasi_header)->row();
						break;
					case 'lap_bedah_anestesi_lokal':
						$data['lap_bedah_anestesi_lokal_ok'] = $this->rimtindakan->get_laporan_pembedahan_anestesi_lokal_ok($idoperasi_header)->row();
						$data['fisik'] = $this->rimtindakan->getdata_form_json_ok($no_register)->row();
						break;
					case 'lap_bedah_anestesi':
						$data['lap_bedah_anestesi_ok'] = $this->rimtindakan->get_pembedahan_anastesi_ok($idoperasi_header)->row();
						$data['fisik'] = $this->rimtindakan->getdata_form_json_ok($no_register)->row();
						break;
					case 'pramedi_pasca_operasi':
						$data['pramedi_pasca_operasi_ok'] = $this->rimtindakan->get_premedi_pasca_bedah_ok($idoperasi_header)->row();
						break;
					case 'status_sedasi_sjj':
						$data['status_sedasi_sjj_ok'] = $this->rimtindakan->get_status_sedasi_ok($idoperasi_header)->row();
						break;
					case 'tindakan_anestesi_sedasi':
						$data['tindakan_anestesi_sedasi_ok'] = $this->rimtindakan->get_anastesi_sedasi_ok($idoperasi_header)->row();
						$data['fisik'] = $this->rimtindakan->getdata_form_json_ok($no_register)->row();
						break;
					case 'edukasi_anestesi_sedasi':
						$data['edukasi_anestesi_sedasi_ok'] = $this->rimtindakan->get_edukasi_anestesi_ok($idoperasi_header)->row();
						$data['fisik'] = $this->rimtindakan->getdata_form_json_ok($no_register)->row();
						break;
					case 'assesmen_pra_induksi':
						$data['assesmen_pra_induksi'] = $this->rimtindakan->get_assesment_pra_induksi($idoperasi_header)->row();
						break;
				break;
		}
		return $this->load->view($views,$data);
	}
	
	function detail_persiapan($idoperasi_header=''){
    	if($idoperasi_header!=''){    		
    		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
			//  print_r($data['data_pasien']);die();

				if($data['data_pasien']->no_register==null){
					$data['title'] = 'DETAIL PERIAPAN OPERASI PASIEN | '.$data['data_pasien']->no_reservasi;
	    		}else{
	    			$data['title'] = 'DETAIL PERSIAPAN OPERASI PASIEN | '.$data['data_pasien']->no_register;
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
				$data['cara_bayar']=$data['data_pasien']->cara_bayar;			
				$data['id_poli']=$data['data_pasien']->id_poli;

				if($data['data_pasien']->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$data['data_pasien']->foto;
				}

				if($data['data_pasien']->type_rawat=='ruangrawat'){					
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']=$data['data_pasien']->bed;
				}else{
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']='-';
				}
				if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='KERJASAMA' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=isset($kontraktor)?$kontraktor:null;
				}else{
					$data['nmkontraktor']='';
				}

				// $data['data_pemeriksaan']=$this->okmdaftar->get_data_pemeriksaan($data['no_register'])->result();
				// $data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($data['no_register'])->row();
				// var_dump($data['data_pasien']);die();
				// $data['id_item_ok']='';	
				
				$data['persetujuan_tind_kedokteran'] = $this->rimtindakan->get_persetujuan_dokter($data['data_pasien']->no_register);
				$data['checklist_persiapan_operasi'] =$this->rimtindakan->get_checklist_persiapan_operasi($idoperasi_header)->row();
				$data['assesment_pra_anestesi'] =$this->rimtindakan->get_assesment_pra_anastesi($idoperasi_header)->row();
				$data['asuhan_keperawatan_peri_operatif'] =$this->rimtindakan->get_asuhan_keperawatan_peri_operatif($idoperasi_header)->row();
				$data['status_sedasi'] = $this->rimtindakan->get_status_sedasi($idoperasi_header)->row();
			$this->load->view('ok/okvdetailpersiapan',$data);
    	}
    }


	public function checklist_persiapan_operasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
	
	
		
		// $data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_checklist_persiapan_operasi($id_ok);
		// var_dump($data_note);die();
		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('persiapan_operasi_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('persiapan_operasi_json');
			}
			$submitdata = $this->rimtindakan->update_checklist_persiapan_operasi($id_ok,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('persiapan_operasi_json');
			$submitdata = $this->rimtindakan->insert_checklist_persiapan_operasi($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}
		

		echo $response;

	}

	public function asuhan_keperawatan_peri_operatif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_asuhan_keperawatan_peri_operatif($id_ok);
		
		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			}
			$submitdata = $this->rimtindakan->update_asuhan_keperawatan_peri_operatif($id_ok,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			$submitdata = $this->rimtindakan->insert_asuhan_keperawatan_peri_operatif($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}

		echo $response;
	}

	public function assesment_pra_anastesi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
	
		$data['formjson'] = $this->input->post('assesment_pra_anastesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		

		$data_note=$this->rimtindakan->get_assesment_pra_anastesi($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_pra_anastesi($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_assesment_pra_anastesi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function status_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		// $data['no_ipd'] = $noipd;
		$data_note=$this->rimtindakan->get_status_sedasi($id_ok);
		
		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('ews_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('ews_json');
			}
			$submitdata = $this->rimtindakan->update_status_sedasi($id_ok,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('ews_json');
			$submitdata = $this->rimtindakan->insert_status_sedasi($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}
		echo $response;

	}

	public function checklist_persiapan_operasi_view($no_ipd,$id_ok)
    {
      
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['persiapan_operasi'] = $this->rimtindakan->get_checklist_persiapan_operasi($id_ok)->row();
		// var_dump( $data['persiapan_operasi']);die();
        $this->load->view('ok/formulir/checklist_persiapan_operasi/persiapan_operasi_view',$data);

    }

	public function asuhan_keperawatan_pre_operatif_view($no_ipd,$id_ok)
    {
       
	
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
         
        $data['asuhan_keperawatan'] = $this->rimtindakan->get_asuhan_keperawatan_peri_operatif($id_ok)->row();
        $this->load->view('ok/formulir/asuhan_keperawatan_pre_operatif/v_asuhan_preoperatif',$data);

    }

	public function assesment_pra_anestesi_view($no_ipd,$id_ok)
    {
       
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['pra_anestesti'] = $this->rimtindakan->get_assesment_pra_anastesi($id_ok)->row();
        $this->load->view('ok/formulir/assesment_pra_anestesi/v_assesment_pra_anestesi',$data);

    }

	public function status_sedasi_view($no_ipd,$id_ok)
    {

        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['sedasi'] = $this->rimtindakan->get_status_sedasi($id_ok)->row();
        $this->load->view('ok/formulir/status_sedasi/v_status_sedasi',$data);

    }

    public function get_operasi_header($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_operasi_header_byid($id)->row();
			echo json_encode($data_header);
		}
		
	}

	public function get_operasi_header_jadwal($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_operasi_header_by_id($id)->row();
			echo json_encode($data_header);
		}
		
	}

    public function save_detailok()
	{
		// var_dump($this->input->post);die();
		$data['no_reservasi']=$this->input->post('no_reservasi');
		if($this->input->post('no_register')!=''){
			$data['no_register']=$this->input->post('no_register');
		}		
		$data['type_rawat']=$this->input->post('type_rawat');
		$data['ruang_rawat']=$this->input->post('idrg');
		$data['id_dokter']=$this->input->post('id_dokter');
		//added
		$data['id_diagnosa']=$this->input->post('id_diagnosa');
		$data['id_tindakan']=$this->input->post('id_tindakan');
		// end addes
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
		//if($idoperasi_header!=''){
			//$id=$this->okmdaftar->update_detailok($data,$idoperasi_header);
		//}else{
			$id=$this->okmdaftar->insert_detailok($data);
		//}
		// var_dump($id);die();
		echo json_encode($id);

		redirect('ok/okcdaftar/detail_ok/'.$idoperasi_header);
		
		
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$prioritas=$this->input->post('prioritas');
		// $tmno=$this->input->post('tmno');
		

		$biaya=$this->okmdaftar->get_biaya_tindakan_new($id_tindakan,$prioritas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{

		$data = $this->input->post();
		// var_dump($data);die();
		$data['id_dokter2'] = $data['id_dokter2'] == ''?null:$data['id_dokter2']; 
		$data['id_dokter_asist'] = $data['id_dokter_asist'] == ''?null:$data['id_dokter_asist']; 
		$data['id_dok_anes'] = $data['id_dok_anes'] == ''?null:$data['id_dok_anes']; 
		$data['perawat_anastesi'] = $data['perawat_anastesi'] == ''?null:$data['perawat_anastesi']; 
		$data['id_dok_anak'] = $data['id_dok_anak'] == ''?null:$data['id_dok_anak']; 
		$data['perawat_ins'] = $data['perawat_ins'] == ''?null:$data['perawat_ins'];
		$data_tindakan=$this->okmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		if($this->input->post('id_pemeriksaan_ok')!=''){
			$id=$this->okmdaftar->update_pemeriksaan($data,$this->input->post('id_pemeriksaan_ok'));
		}else{
			unset($data['id_pemeriksaan_ok']);
			$id=$this->okmdaftar->insert_pemeriksaan($data);
		}
		echo json_encode([
			'code'=>$id?200:500
		]);
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

				if(substr($data['no_register'],0,2) == 'RI') {
					$titip = $this->okmdaftar->get_data_titip_iri($data['no_register'])->row();
				}

				if(substr($data['no_register'],0,2) == 'RI') {
					if($titip->titip == NULL) {
						if($this->input->post('cara_bayar') == 'KERJASAMA') {
							if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL) {
								$data['biaya_ok'] = 0;
							} else {
								$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
							}
						} else if($this->input->post('cara_bayar') == 'BPJS') {
							if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL) {
								$data['biaya_ok'] = 0;
							} else {
								$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
							}
						} else {
							$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
						}
					} else {
						if($this->input->post('cara_bayar') == 'KERJASAMA') {
							if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks == NULL) {
								$data['biaya_ok'] = 0;
							} else {
								$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks;
							}
						} else if($this->input->post('cara_bayar') == 'BPJS') {
							if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs == NULL) {
								$data['biaya_ok'] = 0;
							} else {
								$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs;
							}
						} else {
							$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->total_tarif;
						}
					}
				} else {
					if($this->input->post('cara_bayar') == 'KERJASAMA') {
						if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL) {
							$data['biaya_ok'] = 0;
						} else {
							$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
						}
					} else if($this->input->post('cara_bayar') == 'BPJS') {
						if($this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL) {
							$data['biaya_ok'] = 0;
						} else {
							$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
						}
					} else {
						$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					}
				}
				//$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
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
		// if ($getrdrj=="RJ"){
		// 	'<script type="text/javascript">
		// 	$.ajax({url: "'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", success: function(result){
		// 		alert("sukses");
		// 	  }});
		// 	</script>';
		//  	redirect('ok/okcdaftar/jadwal_operasi/','refresh');
		// }
		// else if ($getrdrj=="RI"){
		// 	echo '<script type="text/javascript">
		// 	$.ajax({url: "'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", success: function(result){
		// 		alert("sukses");
		// 	  }});
		// 	</script>';
		// 	redirect('ok/okcdaftar/jadwal_operasi/','refresh');
		// }

		// echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';

		// redirect('ok/Labcdaftar/','refresh');
		
		//print_r($getvtotok);
		return $this->cetak_faktur($no_ok);
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
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data['xuser']=$user;
		$data['nama']=$this->input->post('nama');
		$data['usia']=$this->input->post('usia');
		$data['jk']=$this->input->post('jk');
		$data['alamat']=$this->input->post('alamat');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');
		$data['ok']='1';
		$data['dokter']=$this->input->post('dokter');
		$data['cara_bayar']='UMUM';
		$data['jenis_PL']='OK';		
		
		$this->okmdaftar->insert_pasien_luar($data);
		$notification = '<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
										<h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-12"> 
													<hr style="margin-top: 5px;"> 
													<h2>Pasien Berhasil Di Daftarkan</h2>
												</div>   
											</div>
										</div> 
									</div>';	
		$this->session->set_flashdata('success_msg', $notification);
		
		redirect('ok/okcdaftar/jadwal_operasi','refresh');
	}

	public function cetak_faktur_old($no_ok='')
	{
		error_reporting(~E_ALL);
		
		
		if($no_ok!=''){
			$jumlah_vtot=$this->okmdaftar->get_vtot_no_ok($no_ok)->row()->vtot_no_ok;
			$conf=$this->appconfig->get_headerpdf_appconfig()->result();
			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
			$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			
			$data_pasien=$this->okmkwitansi->get_data_pasien($no_ok)->row();
			
			$data_pemeriksaan=$this->okmkwitansi->get_data_pemeriksaan($no_ok)->result();
			
			$cterbilang=new rjcterbilang();

			$tahuns= substr($data_pasien->tgl_lahir,0,4);
			$tahun_now = date('Y');
			$bulan=0;
			$hari=0;
			$tahun= intval($tahun_now) - intval($tahuns);
			$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
			$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);
			
			$jumlah_vtot0=0;
			foreach($data_pemeriksaan as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot0);

			// $header_page = $top_header."<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\">".$bottom_header;
			$header_page = $top_header."<p align=\"center\">
											<img src=\"assets/img/".$logo_kesehatan_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
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
											<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>".$bottom_header;
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
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					".$header_page."
					
					
					<hr/>
					<p align=\"center\"><b>
					FAKTUR OPERASI<br/>
					No. OK_$no_ok
					</b></p>
					<table>
						
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
							<td>$tahun tahun.</td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Terbilang</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>							
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
								$kota_header, $tgl
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

	public function cetak_faktur($no_ok='')
	{
		$data['no_ok'] = $no_ok;
		// echo 'masuk sini';die();
		if($no_ok!=''){
			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);
			$data['xuser']=$user;
			$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['data_pasien']=$this->okmkwitansi->get_data_pasien($no_ok)->row();
			$data['data_pemeriksaan']=$this->okmkwitansi->get_data_pemeriksaan($no_ok)->result();
			// var_dump($data['data_pemeriksaan']);die();
			$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
			$data['tgl'] = date("d-m-Y");
			$tahuns= isset($data['data_pasien']->tgl_lahir)?substr($data['data_pasien']->tgl_lahir,0,4):null;
			$tahun_now = date('Y');
			$data['tahun']= intval($tahun_now) - intval($tahuns);
			$cterbilang=new rjcterbilang();
			$jumlah_vtot0=0;
			foreach($data['data_pemeriksaan'] as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}
			$data['vtot_terbilang']=$cterbilang->terbilang($jumlah_vtot0);
			// var_dump($data);

			$this->load->view('ok/faktur_ok',$data);
		}
	}

	public function edit_jam_operasi(){
		$idoperasi_header=$this->input->post('idoperasi_header');
		$data['tgl_jadwal_ok_tunda']=$this->input->post('tgl_jadwal_ok_tunda');
		$data['intime_jadwal_ok_tunda']=$this->input->post('intime_jadwal_ok_tunda');
		$data['pasien_tunda'] = 'TUNDA';
		
		$this->okmdaftar->edit_jam_operasi($idoperasi_header,$data);

		redirect('ok/okcdaftar/detail_ok/'.$idoperasi_header);
		//print_r($data);
	}

	public function insert_formulir_patologi_klinik()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_patologi_klinik($no_ipd,$tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('formulir_patologi_klinik_json');
			$result = $this->rimtindakan->update_patologi_klinik($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('formulir_patologi_klinik_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_patologi_klinik($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}
	public function insert_assesment_pra_induksi_ok()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
	
		$data['formjson'] = $this->input->post('assesment_pra_induksi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_assesment_pra_induksi($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_pra_induksi($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_assesment_pra_induksi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

}