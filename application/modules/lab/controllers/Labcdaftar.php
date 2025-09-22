<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//include('.php');
require_once(APPPATH . 'controllers/irj/Rjcterbilang.php');
//require_once(APPPATH.'controllers/Secure_area.php');
class Labcdaftar extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
		$this->load->model('rad/radmdaftar', '', TRUE);
		$this->load->model('lab/labmkwitansi', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		$date = $this->input->post('date');
		$key = $this->input->post('key');
		if (!empty($date)) {
			$data['title'] = 'DAFTAR PASIEN LABORATORIUM Tanggal ' . date('d-m-Y', strtotime($date));
			$data['laboratorium'] = $this->labmdaftar->get_daftar_pasien_lab_by_date($date)->result();
		} else if (!empty($key)) {
			$data['title'] = 'DAFTAR PASIEN LABORATORIUM | ' . $key;
			$data['laboratorium'] = $this->labmdaftar->get_daftar_pasien_lab_by_no($key)->result();
		} else {
			$data['title'] = 'DAFTAR PASIEN LABORATORIUM';
			$data['laboratorium'] = $this->labmdaftar->get_daftar_pasien_lab()->result();
		}
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
		$data['kontraktor'] = $this->labmdaftar->get_kontraktor_kerjasama()->result();
		$this->load->view('lab/labvdaftarpasien', $data);
		//print_r($data);
	}

	// public function by_date(){
	// 	$date=$this->input->post('date');
	// 	$data['title'] = 'DAFTAR PASIEN LABORATORIUM Tanggal '.date('d-m-Y',strtotime($date));

	// 	$data['laboratorium']=$this->labmdaftar->get_daftar_pasien_lab_by_date($date)->result();
	// 	$this->load->view('lab/labvdaftarpasien',$data);
	// }

	// public function by_no(){
	// 	$key=$this->input->post('key');
	// 	$data['title'] = 'DAFTAR PASIEN LABORATORIUM | '.$key;

	// 	$data['laboratorium']=$this->labmdaftar->get_daftar_pasien_lab_by_no($key)->result();
	// 	$this->load->view('lab/labvdaftarpasien',$data);
	// }

	public function pemeriksaan_lab($no_register = '', $pelayan = '')
	{

		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan Laboratorium';

		$data['no_register'] = $no_register;
		// $titip = $this->labmdaftar->get_data_titip_iri($data['no_register'])->row();
		//  var_dump($pelayan);die();
		if (substr($no_register, 0, 2) == "PL") {
			$lab = $this->labmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row()->lab;
			if ($lab == '1') {
				$validdata = $this->labmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row();
				if ($validdata == null) {
					$data['no_cm'] = '';
					$data['no_medrec'] = '';
					$data['nama'] = '';
					$data['usia'] = '';
					$data['jk'] = '';
					$data['alamat'] = '';
					$data['dokter_rujuk'] = '';
					$data['kelas_pasien'] = '';
					$data['tgl_kun'] = '';
					$data['idrg'] = '-';
					$data['bed'] = '-';
					$data['cara_bayar'] = '';
					$data['nmkontraktor'] = '';
					$data['tgl_periksa'] = '';
					$data['waktu_masuk_lab'] = '';
					$data['cara_bayar'] = '';
					$data['rs_perujuk'] = '';
					$data['tgl_lahir'] = '';
				} else {
					$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
					foreach ($data['data_pasien_pemeriksaan'] as $row) {
						$data['no_cm'] = $row->no_cm;
						$data['no_medrec'] = $row->no_cm;
						$data['nama'] = $row->nama;
						$data['usia'] = $row->usia;
						$data['jk'] = $row->jk;
						$data['alamat'] = $row->alamat;
						$data['dokter_rujuk'] = $row->dokter;
						$data['kelas_pasien'] = 'NK';
						$data['tgl_kun'] = $row->tgl_kunjungan;
						$data['idrg'] = '-';
						$data['bed'] = '-';
						$data['cara_bayar'] = $row->cara_bayar;
						$data['nmkontraktor'] = '';
						$data['tgl_periksa'] = $row->tgl_kunjungan;
						$data['waktu_masuk_lab'] = "";
						$data['status_lab'] = $row->lab;
						$data['cara_bayar'] = $row->cara_bayar;
						$data['rs_perujuk'] = $row->rs_perujuk;
						$data['tgl_lahir'] = $row->tgl_lahir;
					}
				}
			} else {
				redirect("lab/labcdaftar");
			}
		} else {

			$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_pasien_pemeriksaan($no_register)->result();

			//	print_r($data['data_pasien_pemeriksaan']);die();

			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_periksa'] = $row->tgl_kunjungan;
				$data['tgl_lahir'] = $row->tgl_lahir;

				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			// var_dump($data['cara_bayar']);
			// die();
			if (substr($no_register, 0, 2) == "RJ") {
				if ($data['cara_bayar'] != null) {
					// if($data['cara_bayar'] != null || $data['cara_bayar'] != '' || isset($data['cara_bayar'])){
					//	print_r($data['cara_bayar']);die();

					if ($data['cara_bayar'] == 'KERJASAMA' or $data['cara_bayar'] == 'BPJS') {
						$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row();
						$data['nmkontraktor'] = isset($kontraktor->nmkontraktor);
					} else {
						$data['nmkontraktor'] = '';
						// $data['bed']='Rawat Jalan';
						//$data['kelas_pasien']='II';

						$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
						// print_r($data['data_pasien_daftar_ulang']);die();
						$data['waktu_masuk_lab'] = $data['data_pasien_daftar_ulang']->waktu_masuk_lab;


						if ($data['waktu_masuk_lab'] == null) {
							$data['waktu_masuk_lab'] = date('Y-m-d H:i:s');
							$data2['waktu_masuk_lab'] = $data['waktu_masuk_lab'];
							$id = $this->rjmpelayanan->update_rujukan_penunjang($data2, $no_register);
						}
					}
				} else {
					redirect("lab/labcdaftar");
				}
			} else if (substr($no_register, 0, 2) == "RI") {
				// var_dump($no_register);die();
				if ($data['cara_bayar'] != null) {

					// if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					$data['waktu_masuk_lab'] = "";
					if ($data['cara_bayar'] == 'KERJASAMA') {
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor'] = $kontraktor;
					} else $data['nmkontraktor'] = '';
				} else {
					redirect("lab/labcdaftar");
				}
			}
		}


		$data['dokter_kirim'] = $this->labmdaftar->get_dokter_kirim($no_register)->row();
		$data['data_jenis_lab'] = $this->labmdaftar->get_jenis_lab()->result();
		$data['data_pemeriksaan'] = $this->labmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter'] = $this->labmdaftar->getdata_dokter()->result();
		$data['tindakan'] = $this->labmdaftar->getdata_tindakan_pasien()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$get_id_ok = $this->labmdaftar->get_id_ok($no_register)->row();
		$data['id_ok'] = isset($get_id_ok->idoperasi_header) ? $get_id_ok->idoperasi_header : '';
		// var_dump($data['id_ok']);die();
		$this->load->view('lab/labvpemeriksaan', $data);
	}

	// public function pemeriksaan_lab($no_register='', $no_lab=""){
	// 	$data['title'] = 'Input Pemeriksaan Laboratorium';

	// 	$data['no_register']=$no_register;
	// 	$data['no_lab']=$no_lab;

	// 	if(substr($no_register, 0,2)=="PL"){
	// 		$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
	// 		foreach($data['data_pasien_pemeriksaan'] as $row){
	// 			$data['no_cm']=$row->no_cm;
	// 			$data['no_medrec']=$row->no_cm;
	// 			$data['nama']=$row->nama;
	// 			$data['usia']=$row->usia;
	// 			$data['jk']=$row->jk;
	// 			$data['alamat']=$row->alamat;
	// 			$data['dokter_rujuk']=$row->dokter;
	// 			$data['kelas_pasien']='II';
	// 			$data['tgl_kun']=$row->tgl_kunjungan;
	// 			$data['idrg']='-';
	// 			$data['bed']='-';
	// 			$data['cara_bayar']=$row->cara_bayar;
	// 			$data['nmkontraktor']='';
	// 			$data['tgl_periksa']=$row->tgl_kunjungan;
	// 			$data['waktu_masuk_lab']="";
	// 		}
	// 	}else{
	// 		$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_pasien_pemeriksaan($no_register)->result();
	// 		foreach($data['data_pasien_pemeriksaan'] as $row){
	// 			$data['nama']=$row->nama;
	// 			$data['no_cm']=$row->no_cm;
	// 			$data['no_medrec']=$row->no_medrec;
	// 			$data['kelas_pasien']=$row->kelas;				
	// 			$data['tgl_kun']=$row->tgl_kunjungan;
	// 			$data['idrg']=$row->idrg;
	// 			$data['bed']=$row->bed;
	// 			$data['cara_bayar']=$row->cara_bayar;	
	// 			$data['tgl_periksa']=$row->jadwal_lab;			
	// 			if($row->foto==NULL){
	// 				$data['foto']='unknown.png';
	// 			}else {
	// 				$data['foto']=$row->foto;
	// 			}
	// 		}
	// 		if(substr($no_register, 0,2)=="RJ"){
	// 			if($data['cara_bayar']=='KERJASAMA'){
	// 				$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
	// 				$data['nmkontraktor']=$kontraktor;
	// 			}else $data['nmkontraktor']='';
	// 			$data['bed']='Rawat Jalan';
	// 			//$data['kelas_pasien']='II';

	// 			$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
	// 			$data['waktu_masuk_lab']=$data['data_pasien_daftar_ulang']->waktu_masuk_lab;

	// 			if($data['waktu_masuk_lab']==null){
	// 				$data['waktu_masuk_lab']=date('Y-m-d H:i:s');
	// 				$data2['waktu_masuk_lab']=$data['waktu_masuk_lab'];
	// 				$id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);			
	// 			}
	// 		}else if (substr($no_register, 0,2)=="RI"){
	// 			$data['waktu_masuk_lab']="";
	// 			if($data['cara_bayar']=='KERJASAMA'){
	// 				$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
	// 				$data['nmkontraktor']=$kontraktor;	
	// 			}else $data['nmkontraktor']='';			
	// 		}
	// 	}

	// 	$data['data_jenis_lab']=$this->labmdaftar->get_jenis_lab()->result();
	// 	$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register, $no_lab)->result();
	// 	$data['dokter']=$this->labmdaftar->getdata_dokter()->result();
	// 	$data['tindakan']=$this->labmdaftar->getdata_tindakan_pasien()->result();

	// 	$login_data = $this->load->get_var("user_info");
	// 	$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;

	// 	$this->load->view('lab/labvpemeriksaan',$data);
	// }

	public function pemeriksaan_lab_urikes($no_register)
	{
		$data['title'] = 'Input Pemeriksaan Laboratorium';

		$data['no_register'] = $no_register;

		$data['data_pasien_pemeriksaan'] = $this->labmdaftar->get_data_pasien_urikes($no_register)->result();
		foreach ($data['data_pasien_pemeriksaan'] as $row) {
			$data['nama'] = $row->nama;
			$data['cara_bayar'] = $row->catatan;
			$data['tgl_periksa'] = $row->tgl_pemeriksaan;
			$data['paket'] = $row->nama_paket;
		}
		$data['data_jenis_lab'] = $this->labmdaftar->get_jenis_lab()->result();
		$data['data_pemeriksaan'] = $this->labmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter'] = $this->labmdaftar->getdata_dokter()->result();
		$data['tindakan'] = $this->labmdaftar->getdata_tindakan_pasien()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$this->load->view('lab/labvpemeriksaan', $data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan = $this->input->post('id_tindakan');
		$kelas = $this->input->post('kelas');
		$biaya = $this->labmdaftar->get_biaya_tindakan($id_tindakan, $kelas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['no_register'] = $this->input->post('no_register');
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['id_tindakan'] = $this->input->post('idtindakan');
		$data['kelas'] = $this->input->post('kelas_pasien');
		if ($this->input->post('tgl_periksa') != '') {
			$data['tgl_kunjungan'] = $this->input->post('tgl_periksa');
		} else $data['tgl_kunjungan'] = $this->input->post('tgl_kunj');

		$data_tindakan = $this->labmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach ($data_tindakan as $row) {
			$data['jenis_tindakan'] = $row->nmtindakan;
		}
		$data['qty'] = $this->input->post('qty');
		$data['id_dokter'] = $this->input->post('id_dokter');
		$data_dokter = $this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach ($data_dokter as $row) {
			$data['nm_dokter'] = $row->nm_dokter;
		}
		$data['biaya_lab'] = $this->input->post('biaya_lab_hide');
		$data['vtot'] = $this->input->post('vtot_hide');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['xinput'] = $this->input->post('xuser');


		// var_dump($data);die();

		/*
		$data['no_lab']=$this->input->post('no_lab');
		if($data['no_lab'] !=''){
		} else {
			$this->labmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_lab']=$this->labmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_lab;
		*/

		$this->labmdaftar->insert_pemeriksaan($data);

		//redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register'].'/'.$data['no_lab']);
		// redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register']);
		//print_r($data);

		echo json_encode(array("status" => TRUE));
	}


	public function save_pemeriksaan()
	{

		// $this->console_log("ini : " . $_POST['myCheckboxes']);
		// $validasi_dokter = $this->input->post('id_dokter');
		// if($validasi_dokter == null){
		// 	echo json_encode(array("status" => FALSE));
		// }else{
		if (isset($_POST['myCheckboxes'])) {
			for ($i = 0; $i < count($_POST['myCheckboxes']); $i++) {
				// var_dump($this->input->post());die();
				$data['no_register'] = $this->input->post('no_register');
				$data['no_medrec'] = $this->input->post('no_medrec');
				$data['id_tindakan'] = $this->input->post('myCheckboxes[' . $i . ']');
				$data['kelas'] = $this->input->post('kelas_pasien');
				$data['cito'] = $this->input->post('cito');

				$data['kelas'] = ($data['kelas'] == 'EKSEKUTIF' ? 'VVIP' : $data['kelas']);


				//    $this->console_log("ini : " . $this->input->post('tgl_periksa'));

				// if($this->input->post('tgl_periksa')!=''){

				// $data['tgl_kunjungan']= $this->input->post('tgl_periksa');
				// $data['tgl_kunjungan']= date('Y-m-d H:i:s');
				// }else 
				// 	$data['tgl_kunjungan']=$this->input->post('tgl_kunj');

				$data_tindakan = $this->labmdaftar->getjenis_tindakan($data['id_tindakan'])->result();

				//print_r($data_tindakan);die();

				foreach ($data_tindakan as $row) {
					$data['jenis_tindakan'] = $row->nmtindakan;
				}
				$data['qty'] = '1';
				// $data['id_dokter']=$this->input->post('id_dokter');
				// $data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
				// foreach($data_dokter as $row){
				// 	$data['nm_dokter']=$row->nm_dokter;
				// }
				if (substr($data['no_register'], 0, 2) == 'RI') {
					$titip = $this->labmdaftar->get_data_titip_iri($data['no_register'])->row();
				}
				if (substr($this->input->post('no_register'), 0, 2) == 'RI') {
					if ($titip->titip == NULL) {
						
					$data['biaya_lab'] = $this->labmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					
					} else {
						$data['biaya_lab'] = $this->labmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					}
				} else {
					if ($this->input->post('cara_bayar') == 'KERJASAMA') {
						$data['biaya_lab'] = $this->labmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					} else if ($this->input->post('cara_bayar') == 'BPJS') {
						$data['biaya_lab'] = $this->labmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					} else {
						$data['biaya_lab'] = $this->labmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					}
				}
				$data['vtot'] = $data['biaya_lab'];
				$data['idrg'] = $this->input->post('idrg');
				$data['bed'] = $this->input->post('bed');
				$data['cara_bayar'] = $this->input->post('cara_bayar');
				// $data['xinput']=$this->input->post('xuser');
				$data['xinput'] = $this->input->post('xuserid');

				$no_register = $this->input->post('no_register');

				$cek_pasien_apa = substr($no_register, 0, 2);
				if ($cek_pasien_apa == 'RI') {
					$cel_laborat = $this->radmdaftar->cek_radiologi($no_register)->row();
				} else {
					$cel_laborat = $this->radmdaftar->cek_radiologi($no_register)->row();
				}


				if ($cel_laborat == false) {
					$datafisik['pemeriksaan_penunjang_dokter'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(L)' . ' <br>';
					$datafisik['no_register'] = $no_register;
					$this->radmdaftar->insert_data_soap($datafisik);
				} else {
					$id = $cel_laborat->id;
					$datafisik['tgl_input'] = date("Y-m-d H:i:s");
					$datafisik['pemeriksaan_penunjang_dokter'] = $cel_laborat->pemeriksaan_penunjang_dokter . '<br>-' . ' ' . $data['jenis_tindakan'] . ' ' . '(L)';
					$this->radmdaftar->update_data_soap($datafisik, $id);
				}


				// INSERT TO PENGKAJIAN MEDIS SJJ
				// if ($cek_pasien_apa == 'RJ') {
				// 	$cek_pengkajian_medis = $this->rjmpelayanan->cek_pengkajian_medis($no_register)->row();
				// 	// var_dump($cek_pengkajian_medis);die();
				// 	if ($cek_pengkajian_medis == false) {
				// 		$dat_medis['pemeriksaan_penunjang'] = $data['jenis_tindakan'] . ' ' . '(L)';
				// 		$dat_medis['no_register'] = $no_register;
				// 		$this->rjmpelayanan->insert_pengkajian_medis_rj($dat_medis);
				// 	} else {
				// 		$id = $cek_pengkajian_medis->id;
				// 		$dat_medis['pemeriksaan_penunjang'] = $cek_pengkajian_medis->pemeriksaan_penunjang . ',' . ' ' . $data['jenis_tindakan'] . ' ' . '(L)';
				// 		$this->rjmpelayanan->update_pengkajian_medis_rj_for_penunjang($dat_medis, $id);
				// 	}
				// }

				

				// END




				//$this->console_log($data);

				//	print_r($data);die();

				// Sesi untuk input atau update data ke soap_pasien_rj

				// $no_register = $this->input->post('no_register');
				// $cek_pasien_apa = substr($no_register,0,2);
				// if($cek_pasien_apa == 'RI'){
				// 	$cek_soap = $this->labmdaftar->cek_soap($no_register)->row();
				// }else{
				// 	$cek_soap = $this->labmdaftar->cek_soap_rj($no_register)->row();
				// }
				// if($cek_soap == false){
				// 	$datafisik['pemeriksaan_penunjang_dokter'] = '-'.' '.$data['jenis_tindakan'].' '.'(L)'.' <br>';
				// 	$datafisik['no_register'] = $no_register;
				// 	$result = $this->labmdaftar->insert_data_soap($datafisik);
				// 	$submitdata = $result?json_encode(array("message"=>"sukses insert data")):json_encode(array("message"=>"gagal insert data"));
				// }else{
				// 	$id = $cek_soap->id;
				// 	$datafisik['pemeriksaan_penunjang_dokter'] = $cek_soap->pemeriksaan_penunjang_dokter.'<br>'.'-'.' '.$data['jenis_tindakan'].' '.'(L)';
				// 	$result = $this->labmdaftar->update_data_soap($datafisik,$id);
				// 	$submitdata = $result?json_encode(array("message"=>"sukses update data")):json_encode(array("message"=>"gagal update data"));

				// }
				// var_dump($data);die();

				$this->labmdaftar->insert_pemeriksaan($data);

				echo json_encode(array("status" => TRUE));
			}
			echo json_encode(array("status" => TRUE));
		} else {
			echo json_encode(array("status" => FALSE));
		}
		// echo json_encode(array("status" => TRUE));
		// }
	}

	public function insert_header_lab($pelayan = '') //JANGAN LUPA SETTING NOMOR LAB DISINI
	{
		$no_register = $this->input->post('no_register');
		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');

		$cara_bayar = $this->input->post('cara_bayar');

		$vtotlab = $this->labmdaftar->get_vtot_lab($no_register)->row();
		$getvtotlab = intval($vtotlab->vtot_lab);
		$getrdrj = substr($no_register, 0, 2);

		// if ($this->labmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
		$this->labmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas);
		// }

		$no_lab = $this->labmdaftar->get_data_header($no_register, $idrg, $bed, $kelas)->row()->no_lab;

		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}

		// if($getrdrj=="PL"){
		// 	$this->labmdaftar->selesai_daftar_pemeriksaan_PL_header($no_register,$getvtotlab,$no_lab);
		// } else if($getrdrj=="RJ"){
		// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ_header($no_register,$getvtotlab,$no_lab);
		// }
		// else if ($getrdrj=="RD"){
		// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRD_header($no_register,$getvtotlab,$no_lab);
		// }
		// else if ($getrdrj=="RI"){
		// 	$data_iri=$this->labmdaftar->getdata_iri($no_register)->result();
		// 	foreach($data_iri as $row){
		// 		$status_lab=$row->status_lab;
		// 	}
		// 	$status_lab = $status_lab + 1;
		// 	$this->labmdaftar->selesai_daftar_pemeriksaan_IRI_header($no_register,$status_lab,$getvtotlab,$no_lab);
		// }

		//window.open("'.site_url("lab/labcdaftar/cetak_blanko/$no_lab").'", "_blank");

		if ($pelayan == 'DOKTER') {
			if ($id_poli == 'BA00') {
				redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
			} else {
				if ($getrdrj == "PL") {
					redirect("lab/labcdaftar/");
				} else if ($getrdrj == "RJ") {
					redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
				} else if ($getrdrj == "RI") {
					redirect("iri/rictindakan/index/$no_register");
				} else {
					redirect("lab/labcdaftar/");
				}
			}
		} else {
			if ($id_poli == 'BA00') {
				redirect("lab/labcdaftar/cetak_faktur/$no_lab");
			} else {
				if ($getrdrj == "PL") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else if ($getrdrj == "RJ") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else if ($getrdrj == "RI") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else {
					redirect("lab/labcdaftar/");
				}
			}
		}

		// echo "<meta http-equiv=\"refresh\" content=\"0;URL=".site_url("lab/labcdaftar/")."\">";
		// echo '<META HTTP-EQUIV=Refresh CONTENT="3; URL='.site_url("lab/labcdaftar/").'">';
		// redirect('lab/labcdaftar/','refresh');
		// echo '<script type="text/javascript">window.open("'.site_url("lab/labcdaftar/cetak_faktur/$no_lab").'", "_blank");window.focus()</script>';

		// redirect('lab/Labcdaftar/','refresh');

		//print_r($getvtotlab);
	}

	public function selesai_daftar_pemeriksaan($pelayan = '') //JANGAN LUPA SETTING NOMOR LAB DISINI
	{
		$no_register = $this->input->post('no_register');
		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');

		$cara_bayar = $this->input->post('cara_bayar');

		$vtotlab = $this->labmdaftar->get_vtot_lab($no_register)->row();
		$getvtotlab = intval($vtotlab->vtot_lab);
		$getrdrj = substr($no_register, 0, 2);

// var_dump($no_register);die();
		// if ($this->labmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
		$this->labmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas);
		// }
		$no_lab = $this->labmdaftar->get_data_header($no_register, $idrg, $bed, $kelas)->row()->no_lab;
		// var_dump($no_lab);die();
		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}

		$tglkunjung = date('Y-m-d H:i:s');

		if ($getrdrj == "PL") {
			$this->labmdaftar->selesai_daftar_pemeriksaan_PL($no_register, $getvtotlab, $no_lab, $tglkunjung);
		} else if ($getrdrj == "RJ") {
			$data_iri = $this->labmdaftar->getdata_rj($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung);
		} else if ($getrdrj == "RD") {
			$data_iri = $this->labmdaftar->getdata_rj($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			$this->labmdaftar->selesai_daftar_pemeriksaan_IRD($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung);
		} else if ($getrdrj == "RI") {
			$data_iri = $this->labmdaftar->getdata_iri($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			$this->labmdaftar->selesai_daftar_pemeriksaan_IRI($no_register, $status_lab, $getvtotlab, $no_lab, $tglkunjung);
		}

		//window.open("'.site_url("lab/labcdaftar/cetak_blanko/$no_lab").'", "_blank");

		if ($pelayan == 'DOKTER') {
			if ($id_poli == 'BA00') {
				redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
			} else {
				if ($getrdrj == "PL") {
					redirect("lab/labcdaftar/");
				} else if ($getrdrj == "RJ") {
					redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
				} else if ($getrdrj == "RI") {
					redirect("iri/rictindakan/index/$no_register");
				} else {
					redirect("lab/labcdaftar/");
				}
			}
		} else {
			if ($id_poli == 'BA00') {
				redirect("lab/labcdaftar/cetak_faktur/$no_lab");
			} else {
				if ($getrdrj == "PL") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else if ($getrdrj == "RJ") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else if ($getrdrj == "RI") {
					redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				} else {
					redirect("lab/labcdaftar/");
				}
			}
		}
		// echo "<meta http-equiv=\"refresh\" content=\"0;URL=".site_url("lab/labcdaftar/")."\">";
		// echo '<META HTTP-EQUIV=Refresh CONTENT="3; URL='.site_url("lab/labcdaftar/").'">';
		// redirect('lab/labcdaftar/','refresh');
		// echo '<script type="text/javascript">window.open("'.site_url("lab/labcdaftar/cetak_faktur/$no_lab").'", "_blank");window.focus()</script>';

		// redirect('lab/Labcdaftar/','refresh');

		//print_r($getvtotlab);
	}

	public function selesai_daftar_pemeriksaan_($pelayan = '')
	{ //JANGAN LUPA SETTING NOMOR LAB DISINI
		$no_register = $this->input->post('no_register');
		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');
		$cara_bayar = $this->input->post('cara_bayar');

		$vtotlab = $this->labmdaftar->get_vtot_lab($no_register)->row();
		$getvtotlab = intval($vtotlab->vtot_lab);
		$getrdrj = substr($no_register, 0, 2);

		if ($getrdrj == 'RJ') {
			$id_poli = $this->labmdaftar->get_id_poli($no_register)->row()->id_poli;
		} else {
			$id_poli = 'Ranap';
		}
		$subth = substr(date('Y'), 2);
		$bln = date('m');
		$day = date('d');
		$date = $subth . $bln . $day;

		if ($getrdrj == 'RJ' && $id_poli != 'BA00') {
			$check_hema = $this->labmdaftar->get_tindakan_hematologi_pasien($no_register)->result();

			$check_non_hema = $this->labmdaftar->get_tindakan_non_hematologi_pasien($no_register)->result();

			$check_mikro = $this->labmdaftar->get_tindakan_mikro_pasien($no_register)->result();
			// 
			if ($check_hema) {
				$check_nolab = $this->labmdaftar->check_nolab_today($date)->row();
				if ($check_nolab) {
					$last_number = substr($check_nolab->no_lab, 6);
					$urutan = sprintf("%03d", $last_number + 1);
					$nolab = $date . $urutan;
				} else {
					$nolab = $date . '001';
				}

				$this->labmdaftar->insert_data_header_hema($no_register, $idrg, $bed, $kelas, $nolab);
			}

			if ($check_non_hema) {
				$check_nolab = $this->labmdaftar->check_nolab_today($date)->row();
				if ($check_nolab) {
					$last_number = substr($check_nolab->no_lab, 6);
					$urutan = sprintf("%03d", $last_number + 1);
					$nolab = $date . $urutan;
				} else {
					$nolab = $date . '001';
				}

				$this->labmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas, $nolab);
			}

			if ($check_mikro) {
				$check_nolab = $this->labmdaftar->check_nolab_today($date)->row();
				if ($check_nolab) {
					$last_number = substr($check_nolab->no_lab, 6);
					$urutan = sprintf("%03d", $last_number + 1);
					$nolab = $date . $urutan;
				} else {
					$nolab = $date . '001';
				}

				$this->labmdaftar->insert_data_header_mikro($no_register, $idrg, $bed, $kelas, $nolab);
			}
		} else {
			$check_nolab = $this->labmdaftar->check_nolab_today($date)->row();
			if ($check_nolab) {
				$last_number = substr($check_nolab->no_lab, 6);
				$urutan = sprintf("%03d", $last_number + 1);
				$nolab = $date . $urutan;
			} else {
				$nolab = $date . '001';
			}

			$this->labmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas, $nolab);
		}

		$no_lab = isset($this->labmdaftar->get_data_header_non_hema_non_mikro($no_register, $idrg, $bed, $kelas)->row()->no_lab) ? $this->labmdaftar->get_data_header_non_hema_non_mikro($no_register, $idrg, $bed, $kelas)->row()->no_lab : '';
		$no_lab_hema = isset($this->labmdaftar->get_data_header_hema($no_register, $idrg, $bed, $kelas)->row()->no_lab) ? $this->labmdaftar->get_data_header_hema($no_register, $idrg, $bed, $kelas)->row()->no_lab : '';
		$no_lab_mikro = isset($this->labmdaftar->get_data_header_mikro($no_register, $idrg, $bed, $kelas)->row()->no_lab) ? $this->labmdaftar->get_data_header_mikro($no_register, $idrg, $bed, $kelas)->row()->no_lab : '';
		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}

		$tglkunjung = date('Y-m-d H:i:s');

		if ($getrdrj == "PL") {
			$this->labmdaftar->selesai_daftar_pemeriksaan_PL($no_register, $getvtotlab, $no_lab, $tglkunjung);
		} else if ($getrdrj == "RJ") {
			$data_iri = $this->labmdaftar->getdata_rj($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			// $this->labmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotlab,$no_lab,$status_lab,$tglkunjung);
			if ($no_lab != '') {
				if ($id_poli != 'BA00') {
					$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ_non_hema($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung);
				} else {
					$this->labmdaftar->selesai_daftar_pemeriksaan_IRD($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung);
				}
			}

			if ($no_lab_hema != '') {
				$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ_hema($no_register, $getvtotlab, $no_lab_hema, $status_lab, $tglkunjung);
			}

			if ($no_lab_mikro != '') {
				$this->labmdaftar->selesai_daftar_pemeriksaan_IRJ_mikro($no_register, $getvtotlab, $no_lab_mikro, $status_lab, $tglkunjung);
			}
		} else if ($getrdrj == "RD") {
			$data_iri = $this->labmdaftar->getdata_rj($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			$this->labmdaftar->selesai_daftar_pemeriksaan_IRD($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung);
		} else if ($getrdrj == "RI") {
			$data_iri = $this->labmdaftar->getdata_iri($no_register)->result();
			foreach ($data_iri as $row) {
				$status_lab = $row->status_lab;
			}
			$status_lab = $status_lab + 1;
			$this->labmdaftar->selesai_daftar_pemeriksaan_IRI($no_register, $status_lab, $getvtotlab, $no_lab, $tglkunjung);
		}

		if ($pelayan == 'DOKTER') {
			if ($id_poli == 'BA00') {
				redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
			} else {
				if ($getrdrj == "RJ") {
					redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
				} else if ($getrdrj == "RI") {
					redirect("iri/rictindakan/index/$no_register");
				} else {
					redirect("lab/labcdaftar/");
				}
			}
		} else {
			if ($getrdrj == 'RJ') {
				redirect("lab/labcdaftar/cetak_faktur_new?no_lab=$no_lab&no_lab_hema=$no_lab_hema&no_lab_mikro=$no_lab_mikro");
				// return $this->cetak_faktur_new($datas);
				// if($no_lab != '' && $no_lab_hema != '' && $no_lab_mikro != ''){
				// 	redirect("lab/labcdaftar/cetak_faktur_hema_mikro/$no_lab/$no_lab_hema/$no_lab_mikro");
				// }
				// else if($no_lab != '' && $no_lab_hema != '' && $no_lab_mikro == '') {
				// 	redirect("lab/labcdaftar/cetak_faktur_hema/$no_lab/$no_lab_hema");
				// } else if($no_lab != '' && $no_lab_hema == '') {
				// 	redirect("lab/labcdaftar/cetak_faktur/$no_lab");
				// } else if($no_lab == '' && $no_lab_hema != '') {
				// 	redirect("lab/labcdaftar/cetak_faktur/$no_lab_hema");
				// }
			} else {
				redirect("lab/labcdaftar/cetak_faktur/$no_lab");
			}
		}
	}


	public function hapus_data_pemeriksaan($id_pemeriksaan_lab = '')
	{
		$this->labmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_lab);
		echo json_encode(array("status" => $id_pemeriksaan_lab));

		//print_r($id);
	}

	public function daftar_pasien_luar()
	{
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data['xuser'] = $user;
		$data['nama'] = $this->input->post('nama');
		$data['usia'] = $this->input->post('usia');
		$data['jk'] = $this->input->post('jk');
		$data['alamat'] = $this->input->post('alamat');
		$data['tgl_lahir'] = $this->input->post('tgl_lahir');
		$data['tgl_kunjungan'] = date('Y-m-d H:i:s');
		$data['lab'] = '1';
		$data['dokter'] = $this->input->post('dokter');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['jenis_PL'] = 'LAB';
		$data['cetak_kwitansi'] = 0;
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['jenis_PL'] = 'LAB';
		$data['cetak_kwitansi'] = 0;
		if ($data['cara_bayar'] == 'BPJS') {
			$data['nmkontraktor'] = $this->input->post('iks_bpjs');
		} else if ($data['cara_bayar'] == 'KERJASAMA') {
			$data['nmkontraktor'] = $this->input->post('iks');
		} else {
			$data['nmkontraktor'] = NULL;
		}
		$data['rs_perujuk'] = $this->input->post('perujuk');
		$data['no_hp'] = $this->input->post('no_hp');
		$data['email'] = $this->input->post('email');
		$data['nik'] = $this->input->post('nik');
		$data['no_hp'] = $this->input->post('no_hp');
		$data['email'] = $this->input->post('email');
		$data['nik'] = $this->input->post('nik');
		$data['rs_perujuk'] = $this->input->post('perujuk');
		// $no_register=$this->labmdaftar->get_new_register()->result();
		// foreach($no_register as $val){
		// 	$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		// }

		$this->labmdaftar->insert_pasien_luar($data);
		// $this->insert_tindakan_luar($data);
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

		//redirect('lab/labcdaftar/');
		// print_r($data);
	}

	public function insert_tindakan_luar($data1)
	{


		// var_dump($data1);die();
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
		$data['no_register'] = $data1['no_register'];
		$no_register = $data1['no_register'];
		// var_dump($no_register);die();	
		$data['idtindakan'] = '1B0226';
		$detailkhusus = $this->labmdaftar->get_detail_tindakan('1B0226')->row();
		$data['nmtindakan'] = $detailkhusus->nmtindakan;
		$data['biaya_tindakan'] = $detailkhusus->total_tarif;
		$data['biaya_alkes'] = $detailkhusus->tarif_alkes;
		$data['qtyind'] = '1';
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");

		$data['vtot'] = (int)$data['biaya_tindakan'] + (int)$data['biaya_alkes'];

		$id = $this->labmdaftar->insert_tindakan($data);
	}

	public function cetak_faktur($no_lab = '')
	{
		$data['no_lab'] = $no_lab;
		$jumlah_vtot = $this->labmdaftar->get_vtot_no_lab($no_lab)->row()->vtot_no_lab;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if ($no_lab != '') {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien'] = $this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data['data_pemeriksaan'] = $this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->name);
			$cterbilang = new rjcterbilang();
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			$jumlah_vtot0 = 0;
			foreach ($data['data_pemeriksaan'] as $row) {
				$jumlah_vtot0 = $jumlah_vtot0 + $row->vtot;
			}
			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot0);
			$data['vtot_terbilang'] = $vtot_terbilang;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/faktur_lab', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_lab',$data);
		} else {
			redirect('lab/labcdaftar/', 'refresh');
		}
	}


	public function cetak_faktur_backup($no_lab = '')
	{
		error_reporting(~E_ALL);
		$jumlah_vtot = $this->labmdaftar->get_vtot_no_lab($no_lab)->row()->vtot_no_lab;

		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header = $this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header = $this->appconfig->get_kota_pdfconfig()->value;
		if ($no_lab != '') {

			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");


			foreach ($conf as $rowheader) {
				$head_pdf =	$rowheader->value;
			}
			$header_pdf = $this->config->item('header_pdf');


			$data_pasien = $this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data_pemeriksaan = $this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();

			$cterbilang = new rjcterbilang();

			$tahun_lahir = substr($data_pasien->tgl_lahir, 0, 4);
			$bulan_lahir = substr($data_pasien->tgl_lahir, 5, 2);
			$tanggal_lahir = substr($data_pasien->tgl_lahir, 8, 2);
			$tahun_now = date('Y');
			$bulan = 0;
			$hari = 0;
			$tahun = intval($tahun_now) - intval($tahun_lahir);
			$bulan = floor(($data_pasien->tgl_lahir - ($tahun * 365)) / 30);
			$hari = $data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);

			$jumlah_vtot0 = 0;
			foreach ($data_pemeriksaan as $row) {
				$jumlah_vtot0 = $jumlah_vtot0 + $row->vtot;
			}

			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot0);

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

			// $header_page = $top_header."	
			// 	<td width=\"15%\">
			// 		<p align=\"center\">
			// 			<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
			// 		</p>
			// 	</td>
			// 	<td  width=\"55%\" style=\"font-size:9px;line-height: 5px;\" >
			// 		<font style=\"font-size:15px\">
			// 			<b><p>RUMAH SAKIT OTAK DR.Drs.M.HATTA</p></b><br>
			// 			<b><p>BUKITTINGGI</p></b>
			// 		</font>
			// 	</td>
			// 	<td width=\"30%\">
			// 		<div style=\"border: 1px solid black;\">
			// 			<table cellspacing=\"2\">
			// 				<tr>
			// 					<td>Nama </td>
			// 					<td>: ".$data_pasien->nama." - ".$data_pasien->jk."</td>
			// 				</tr>
			// 				<tr>
			// 					<td>NIK </td>
			// 					<td>: ".$data_pasien->no_identitas."</td>
			// 				</tr>
			// 				<tr>
			// 					<td>No. RM </td>
			// 					<td>: ".$data_pasien->no_cm."</td>
			// 				</tr>
			// 				<tr>
			// 					<td>Tanggal Lahir </td>
			// 					<td>: ".$tanggal_lahir."-".$bulan_lahir."-".$tahun_lahir."</td>
			// 				</tr>
			// 			</table>
			// 		</div>
			// 	</td>".$bottom_header;


			$konten = "<style type=\"text/css\">
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
					" . $header_page . "
					
					<hr/>
					<table>
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"78%\"></td>							
						</tr>
						<tr>
							<td align=\"center\" colspan=\"3\"><b>FAKTUR LABORATORIUM  No. LAB_$no_lab</b></td>
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"32%\">$data_pasien->no_register</td>
							<td width=\"10%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"32%\">$data_pasien->nama</td>
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
							<td rowspan=\"2\">$data_pasien->alamat</td>
						</tr>
						<tr>
							<td><b>Asal Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->ruang</td>
						</tr>
						<tr>
							<td colspan=\"3\"><b>Terbilang : <i>" . strtoupper($vtot_terbilang) . "</i></b></td>
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
			$i = 1;
			$jumlah_vtot = 0;
			foreach ($data_pemeriksaan as $row) {
				$jumlah_vtot = $jumlah_vtot + $row->vtot;
				$vtot = number_format($row->vtot, 2, ',', '.');
				$konten = $konten . "
						<tr>
						  	<td><p align=\"center\">$i</p></td>
						  	<td>$row->jenis_tindakan</td>
						  	<td><p align=\"right\">" . number_format($row->biaya_lab, 2, ',', '.') . "</p></td>
						  	<td><p align=\"center\">$row->qty</p></td>
						  	<td><p align=\"right\">$vtot</P></td>
						</tr>";
				$i++;
			}

			$konten = $konten . "
						<tr>
							<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">" . number_format($jumlah_vtot, 2, ',', '.') . "</p></th>
						</tr>";

			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);
			$konten = $konten . "
					</table>
					<br>
					<br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_header, $tgl
								<br>Laboratorium
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>
					";

			// $file_name="FKTR_$no_lab.pdf";
			$file_name = "FKTR_LAB_" . $no_lab . "_" . $data_pasien->nama . ".pdf";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . site_url("lab/labcdaftar/") . "\">";
			$obj_pdf->Output(FCPATH . 'download/lab/labfaktur/' . $file_name, 'FI');

			header("Refresh:1");

			echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . site_url("lab/labcdaftar/") . "\">";
			echo '<META HTTP-EQUIV=Refresh CONTENT="3; URL=' . site_url("lab/labcdaftar/") . '">';
			return redirect('lab/labcdaftar/', 'refresh');
		} else {
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . site_url("lab/labcdaftar/") . "\">";
			echo '<META HTTP-EQUIV=Refresh CONTENT="3; URL=' . site_url("lab/labcdaftar/") . '">';
			return redirect('lab/labcdaftar/', 'refresh');
		}
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . site_url("lab/labcdaftar/") . "\">";
		echo '<META HTTP-EQUIV=Refresh CONTENT="3; URL=' . site_url("lab/labcdaftar/") . '">';
		return redirect('lab/labcdaftar/', 'refresh');
	}

	public function cetak_blanko($no_lab = '')
	{
		if ($no_lab != '') {
			$nr = $this->labmdaftar->get_row_register_by_nolab($no_lab)->result();
			foreach ($nr as $row) {
				$no_register = $row->no_register;
			}

			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars = $this->config->item('namars');
			$kota_kab = $this->config->item('kota');
			$telp = $this->config->item('telp');
			$alamatrs = $this->config->item('alamat');
			$nmsingkat = $this->config->item('namasingkat');

			$data_jenis_lab = $this->labmdaftar->get_blanko_jenis_lab($no_lab)->result();
			$data_kategori_lab = $this->labmdaftar->get_blanko_kategori_lab($no_lab)->result();
			$nohptelp = "";
			$almt = "";

			$konten = "
					
					<table  border=\"0\" style=\"padding-top:10px;padding-bottom:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\"><br>$namars
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:12px\">LABORATORIUM</font></b><br><br>$alamatrs $kota_kab <br>$telp 
								<br>Email : laboratoriumrsmc@gmail.com
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>

					<hr/><br/><br>
					<p align=\"center\"><b>
					BLANKO PEMERIKSAAN LABORATORIUM
					</b></p><br/>";
			if (substr($no_register, 0, 2) == "PL") {
				$data_pasien = $this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
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
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">" . date("d F Y", strtotime($data_pasien->tgl_kunjungan)) . "</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
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
					$tahun = floor($row->umurday / 365);
					$bulan = floor(($row->umurday - ($tahun * 365)) / 30);
					$hari = $row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				$nm_poli = $this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if ($data_pasien->cara_bayar == 'BPJS') {
					$a = $this->labmdaftar->getcr_bayar_bpjs($data_pasien->no_register)->row();
					$cara_bayar = "$a->b";
				} else if ($data_pasien->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar = "$a->a - $a->b";
				} else {
					$cara_bayar = $data_pasien->cara_bayar;
				}
				if (substr($no_register, 0, 2) == 'RJ') {
					$nama_dokter = $this->labmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				} else if (substr($no_register, 0, 2) == 'RI') {
					$nama_dokter = $this->labmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - ' . $data_pasien->idrg . " (" . $data_pasien->bed . ")";
					// $lokasi = $nm_poli;
				} else {
					$lokasi = 'Pasien Langsung';
				}
				$konten = $konten .
					"<table  border=\"0\">
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
					<table style=\"padding-left:10px; \">
						<tr>
							<th width=\"30%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"33%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"22%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
						</tr>
					</table><hr>
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px;
						    font-size:10;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						}
					</style>
					<table class=\"table-isi\" border=\"0\">";
			foreach ($data_kategori_lab as $rw) {
				$tindakan = strtoupper($rw->nama_jenis);
				$konten = $konten . "
							<tr>
								<th colspan=\"4\"><p align=\"left\">
									<br/><b>$tindakan</b></p>
								</th>
							</tr>";
				foreach ($data_jenis_lab as $row) {
					if ($rw->kode_jenis == substr($row->id_tindakan, 0, 2)) {
						$konten = $konten . "
									<tr>
										<th colspan=\"4\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
									</tr>";
						$data_hasil_lab = $this->labmdaftar->get_blanko_hasil_lab($row->id_tindakan)->result();
						foreach ($data_hasil_lab as $row1) {
							$konten = $konten . "<tr>
													  <td width=\"30%\">&nbsp;&nbsp;&nbsp;&nbsp;$row1->jenis_hasil</td>
													  <td width=\"35%\"><center></center></td>
													  <td width=\"15%\">$row1->satuan</td>
													  <td width=\"20%\">$row1->kadar_normal</td>
													</tr>";
						}
					}
				}
			}

			$konten = $konten . "
					</table>
					<hr>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\"><br>
								$kota_kab, $tgl								
								
								<br><br><br>Pemeriksa : ________________
								</p>
							</td>
						</tr>	
					</table>
					";

			$file_name = "Blanko_LAB_$no_lab.pdf";
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

			// print_r($a);
		} else {
			redirect('lab/labcdaftar/', 'refresh');
		}
	}

	public function autocomplete_search()
	{
		$keyword = $_GET['term'];
		$names = array(0, null);
		$data = $this->db->select('idpok2, idtindakan,nmtindakan')
			->from('jenis_tindakan_lab')
			->where_in('deleted', $names)
			->like('UPPER(nmtindakan)', strtoupper($keyword))
			->or_like('UPPER(idtindakan)', strtoupper($keyword))->limit(20, 0)->get();
		$arr = '';
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$new_row['label'] = $row['idtindakan'] . ' - ' . $row['nmtindakan'];
				$new_row['value'] = $row['idtindakan'] . ' - ' . $row['nmtindakan'];
				$new_row['idtindakan'] = $row['idtindakan'];
				$new_row['idpok2'] = $row['idpok2'];
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {
			echo json_encode([]);
		}
	}

	// added @aldi
	public function bridging_lab()
	{
		$data['lab'] = $this->labmdaftar->load_bridging_lab();
		$this->load->view("bridging_lab", $data);
	}

	public function insert_bridging_lab()
	{
		$res = $this->labmdaftar->update_jenis_hasil_lab($this->input->post(), $this->input->post('id_jenis_hasil_lab'));
		echo json_encode(['code' => $res ? 200 : 400]);
	}

	public function test($noreg)
	{

		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";

		$data['penunjang'] = $this->labmdaftar->get_daftar_order($noreg)->result();
		$data['kiriman_penunjang'] = $this->labmdaftar->data_kiriman_order($noreg)->row();

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'debug' => true]);
		$mpdf->showImageErrors = true;
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('paper_css/output_lab', $data, true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view("paper_css/output_lab",$data);
	}

	public function update_rujukan_penunjang()
	{
		$no_register = $this->input->post('no_register');
		// var_dump($no_register);die();
		if ($no_register == null) {
			echo json_encode(array('status' => false));
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				$data['lab'] = 1;
				$data['jadwal_lab'] = date("Y-m-d H:i:s");
				$data['order_lab_cito'] = $this->input->post('cyto');

				$id = $this->labmdaftar->update_rujukan_penunjang_irj($data, $no_register);
			} else {
				$data['lab'] = 1;
				$data['jadwal_lab'] = date("Y-m-d H:i:s");
				$data['order_lab_cito'] = $this->input->post('cyto');

				$id = $this->labmdaftar->update_rujukan_penunjang_iri($data, $no_register);
			}

			// $data['status_lab']=0;		

			if ($id == true) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	public function cetak_order($noreg = '')
	{
		$data['no_lab'] = $noreg;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if ($noreg != '') {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['data_pasien'] = $this->labmdaftar->get_data_pasien_by_noreg($noreg)->row();
			$data['data_pemeriksaan'] = $this->labmdaftar->get_data_pemeriksaan_by_noreg($noreg)->result();
			$login_data = $this->load->get_var("user_info");
			$name  = $this->labmdaftar->get_ttd_by_userid($login_data->userid)->row();
			$data['user'] = strtoupper($name->name);
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/order_lab', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_lab',$data);
		} else {
			redirect('lab/labcdaftar/', 'refresh');
		}
	}

	public function batal_kunjung($no_register, $pelayan = '', $id_poli = '')
	{
		$cek = $this->labmdaftar->batal_kunjungan($no_register);
		if ($cek == false) {
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> No Register Tidak Ditemukan</div>');
		} else {
			$this->session->set_flashdata('warning', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-success"><i class="fa fa-success"></i>Berhasil</h3></div>');
		}
		$this->labmdaftar->delete_order_batal($no_register);
		if ($pelayan == '') {
			redirect('lab/labcdaftar');
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				if ($id_poli == 'BA00') {
					redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
				} else {
					redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
				}
			} else {
				redirect('iri/rictindakan/index/' . $no_register);
			}
		}
	}

	public function update_cito()
	{
		$id = $this->input->post('id');
		$this->labmdaftar->update_cito($id);
	}

	public function get_detail_pemeriksaan_lab($noreg)
	{
		$hasil = $this->labmdaftar->get_detail_pemeriksaan_lab($noreg)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['jenis_tindakan'] = $value->jenis_tindakan;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function cetak_faktur_new()
	{
		$data['no_lab'] = $this->input->get('no_lab');
		$data['no_lab_hema'] = $this->input->get('no_lab_hema');
		$data['no_lab_mikro'] = $this->input->get('no_lab_mikro');
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if ($data['no_lab'] != '' || $data['no_lab_hema'] != '' || $data['no_lab_mikro'] != '') {
			if ($data['no_lab'] != '') {
				$no_lab = $data['no_lab'];
			} else if ($data['no_lab_hema'] != '') {
				$no_lab = $data['no_lab_hema'];
			} else {
				$no_lab = $data['no_lab_mikro'];
			}
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien'] = $this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data['data_pemeriksaan'] = $this->labmkwitansi->get_data_pemeriksaan($data['no_lab'])->result();
			$data['data_pemeriksaan_hema'] = $data['no_lab_hema'] ? $this->labmkwitansi->get_data_pemeriksaan($data['no_lab_hema'])->result() : null;
			$data['data_pemeriksaan_mikro'] = $data['no_lab_mikro'] ? $this->labmkwitansi->get_data_pemeriksaan($data['no_lab_mikro'])->result() : null;
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
			$cterbilang = new rjcterbilang();
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			$jumlah_vtot0 = 0;
			$jumlah_vtot_hema = 0;
			$jumlah_vtot_mikro = 0;

			foreach ($data['data_pemeriksaan'] as $row) {
				$jumlah_vtot0 += $row->vtot;
			}

			if ($data['no_lab_hema']) {
				foreach ($data['data_pemeriksaan_hema'] as $r) {
					$jumlah_vtot_hema += $r->vtot;
				}
			}

			if ($data['no_lab_mikro']) {
				foreach ($data['data_pemeriksaan_mikro'] as $r) {
					$jumlah_vtot_mikro += $r->vtot;
				}
			}


			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot0 + $jumlah_vtot_hema + $jumlah_vtot_mikro);
			$data['vtot_terbilang'] = $vtot_terbilang;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/faktur_lab_new', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_lab_new',$data);
		} else {
			redirect('lab/labcdaftar/', 'refresh');
		}
	}

	public function cetak_faktur_hema($no_lab, $no_lab_hema)
	{
		$data['no_lab'] = $no_lab;
		$data['no_lab_hema'] = $no_lab_hema;
		$jumlah_vtot = $this->labmdaftar->get_vtot_no_lab($no_lab)->row()->vtot_no_lab;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if ($no_lab != '') {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien'] = $this->labmkwitansi->get_data_pasien($no_lab)->row();
			$data['data_pemeriksaan'] = $this->labmkwitansi->get_data_pemeriksaan($no_lab)->result();
			$data['data_pemeriksaan_hema'] = $this->labmkwitansi->get_data_pemeriksaan($no_lab_hema)->result();
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
			$cterbilang = new rjcterbilang();
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			$jumlah_vtot0 = 0;
			$jumlah_vtot_hema = 0;

			foreach ($data['data_pemeriksaan'] as $row) {
				$jumlah_vtot0 += $row->vtot;
			}

			foreach ($data['data_pemeriksaan_hema'] as $r) {
				$jumlah_vtot_hema += $r->vtot;
			}
			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot0 + $jumlah_vtot_hema);
			$data['vtot_terbilang'] = $vtot_terbilang;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/faktur_lab_hema', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_lab',$data);
		} else {
			redirect('lab/labcdaftar/', 'refresh');
		}
	}
}
