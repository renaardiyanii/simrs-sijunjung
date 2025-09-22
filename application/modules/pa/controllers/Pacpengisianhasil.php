<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as Exception;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
// require_once(APPPATH.'controllers/Secure_area.php');
class Pacpengisianhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->helper(array('form', 'url'));
		$this->clients = new Client([
			'verify' => false,
			// 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
		]);
	}

	public function index(){
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI Tanggal '.date('d-m-Y');

		$data['patologi']=$this->pamdaftar->get_hasil_pa()->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI Tanggal '.date('d-m-Y',strtotime($date));

		$data['patologi']=$this->pamdaftar->get_hasil_pa_by_date($date)->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI | '.$key;

		$data['patologi']=$this->pamdaftar->get_hasil_pa_by_no($key)->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function daftar_hasil($no_pa=''){
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI';
		$data['no_pa'] = $no_pa;
		$no_register=$this->pamdaftar->get_no_register($no_pa)->row()->no_register;
		$data['no_register']=$no_register;
		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->result();
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
				$data['nmkontraktor']='';
				$data['no_pa']=$row->no_pa;
				$data['no_pa_tindakan']=$row->no_pa_tindakan;
				$data['jenis_blanko']=$row->jenis_blanko;
				// $data['waktu_masuk_pa']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_hasil_pemeriksaan($no_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['no_pa_tindakan']=$row->no_pa_tindakan;
				$data['jenis_blanko']=$row->jenis_blanko;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if ($data['no_medrec']=='-') {
				$data['pemeriksaan_kee']='0';
				}
			else {
				$pemeriksaan_ke=$this->pamdaftar->get_data_banyak_pemeriksaan($data['no_medrec'])->row()->pemeriksaan;
				$data['pemeriksaan_kee']=$pemeriksaan_ke;
				}
				
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->pamdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_pa']=$data['data_pasien_daftar_ulang']->waktu_masuk_pa;
			}else if (substr($no_register, 0,2)=="RI"){
				// $data['waktu_masuk_pa']='';
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->pamdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}
		$data['daftarpengisian']=$this->pamdaftar->get_isi_hasil($no_pa)->result();

		$hasil=$this->pamdaftar->get_row_hasil($no_pa)->row()->hasil_periksa;

		// if($hasil==0){
		// 	$data['jenis']='isi';
		// } else {
		// 	$data['jenis']='tidak';
		// 	$aaa=$this->pamdaftar->get_data_hasil($id_pemeriksaan_pa)->row()->hasil;
		// 	$data['hasil'] = json_decode($aaa);
		// }
		$this->load->view('pa/pavdaftarhasil',$data);
	}

	public function isi_hasil($id_pemeriksaan_pa=''){
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI';
		$data['id_pemeriksaan_pa'] = $id_pemeriksaan_pa;

		$nr=$this->pamdaftar->get_row_register($id_pemeriksaan_pa)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				// $data['waktu_masuk_pa']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['foto']=$row->foto;
				$data['nmkontraktor']='';
				if (substr($no_register, 0, 2) == "RJ") {
					$data['asal'] = $row->bed;
				}
				if (substr($no_register, 0, 2) == "RI") {
					$data['asal'] = $row->idrg;
				}

				
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RD"){
				$data['bed']='Rawat Darurat';
			}
		}

		$data['get_data_tindakan_pa']=$this->pamdaftar->get_data_tindakan_pa($data['id_tindakan'])->result();
		
		$this->load->view('pa/pavisihasil',$data);
	}

	public function edit_hasil($id_pemeriksaan_pa=''){
		$data['title'] = 'PENGISIAN HASIL PATOLOGI ANATOMI';
		$data['id_pemeriksaan_pa'] = $id_pemeriksaan_pa;

		$nr=$this->pamdaftar->get_row_register($id_pemeriksaan_pa)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['foto']=$row->foto;
				$data['nmkontraktor']='';
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RD"){
				$data['bed']='Rawat Darurat';
			}
		}

		$data['get_data_edit_tindakan_pa']=$this->pamdaftar->get_data_edit_tindakan_pa($data['id_tindakan'],$data['no_pa'])->row();
		
		$this->load->view('pa/pavedithasil',$data);
	}

	public function simpan_hasil(){
		// var_dump($this->input->post());die();
		$no_register=$this->input->post('no_register');
		$no_pa=$this->input->post('no_pa');
		$id_pemeriksaan_pa=$this->input->post('id_pemeriksaan_pa');

		$data['hasil_pa'] = $this->input->post('hasil_pa');
		$data['id_pemeriksaan_pa'] = $this->input->post('id_pemeriksaan_pa');
		$data['id_tindakan'] = $this->input->post('id_tindakan');
		$data['no_pa'] = $this->input->post('no_pa');
		$data['no_register'] = $this->input->post('no_register');
			
		$this->pamdaftar->isi_hasil_new($data);

		$this->pamdaftar->set_hasil_periksa($id_pemeriksaan_pa);

		redirect('pa/pacpengisianhasil/daftar_hasil/'.$no_pa);
		echo json_encode($data);
	
	}

	public function edit_hasil_submit(){
		// var_dump($this->input->post());die();

		$no_register=$this->input->post('no_register');
		$no_pa=$this->input->post('no_pa');
		$id_hasil_pemeriksaan=$this->input->post('id_hasil_pemeriksaan');
	
		$hasil_pa = $this->input->post('hasil_pa');

		$this->pamdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_pa);

		redirect('pa/pacpengisianhasil/daftar_hasil/'.$no_pa);
		// echo json_encode(array("status" => TRUE));
	}

	public function st_cetak_hasil_pa($id_pemeriksaan, $no_pa)
	{

		if ($id_pemeriksaan != '') {
			$this->pamdaftar->update_status_cetak_hasil($id_pemeriksaan);
			redirect('pa/pacpengisianhasil/daftar_hasil/' . $no_pa);
		} else {
			redirect('pa/pacpengisianhasil/', 'refresh');
		}

	}

	public function st_cetak_hasil_pa_rawat()
	{
		$no_pa=$this->input->post('no_pa');
		$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();

		if($no_pa!=''){

			$this->pamdaftar->update_status_cetak_hasil($no_pa);
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacpengisianhasil/cetak_hasil_pa/$no_pa").'", "_blank");window.history.back();</script>';
			
			//redirect('pa/pacpengisianhasil/','refresh');
		}else{
			//redirect('pa/pacpengisianhasil/','refresh');
		}
	}

	// public function cetak_hasil_pa($no_pa='')
	// {
	// 	if($no_pa!=''){
	// 		$no_register=$this->pamdaftar->get_row_register_by_nopa($no_pa)->row()->no_register;
	// 		// echo "<script> console.log('PHP: ".$no_register."');</script>";
				
	// 		//set timezone
	// 		date_default_timezone_set("Asia/Bangkok");
	// 		$tgl_jam = date("d-m-Y H:i:s");
	// 		$tgl = date("d-m-Y");

	// 		$namars=$this->config->item('namars');
	// 		$kota_kab=$this->config->item('kota');
	// 		$telp=$this->config->item('telp');
	// 		$alamatrs=$this->config->item('alamat');
	// 		$nmsingkat=$this->config->item('namasingkat');
	// 		$email=$this->config->item('email');
	// 		$header_pdf=$this->config->item('header_pdf');

	// 		$data_jenis_pa=$this->pamdaftar->get_data_jenis_pa($no_pa)->result();
	// 		$data_kategori_pa=$this->pamdaftar->get_data_kategori_pa($no_pa)->result();
	// 		$nohptelp = "";$almt = "";

	// 		$konten="
	// 				<font size=\"6\" align=\"right\">$tgl_jam</font><br>
	// 				$header_pdf

	// 				<hr/><br/><br>
	// 				<p align=\"center\"><b>
	// 				HASIL LABORATORIUM HISTOPATOLOGI/SITOLOGI
	// 				</b></p><br/>";
	// 		if(substr($no_register, 0,2)=="PL"){
	// 			$data_pasien=$this->pamdaftar->get_data_pasien_luar_cetak($no_pa)->row();
	// 			$konten=$konten.
	// 				"<table border=\"0\">
	// 					<tr>
	// 						<td width=\"10%\">No. Pa</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"40%\">$no_pa</td>
	// 						<td width=\"10%\">No Reg</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"16%\">$data_pasien->no_register</td>
	// 						<td width=\"5%\">No MR</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"13%\">-</td>
	// 					</tr>
	// 					<tr>
	// 						<td>Dokter</td>
	// 						<td> : </td>
	// 						<td>$data_pasien->dokter</td>
	// 						<td>Nama Pasien</td>
	// 						<td> : </td>
	// 						<td colspan=\"4\"><b>$data_pasien->nama</b></td>
	// 					</tr>
	// 					<tr>
	// 						<td>Dr. PJ. Pa</td>
	// 						<td> : </td>
	// 						<td>$data_pasien->dokter</td>
	// 						<td width=\"10%\">Kelamin</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"16%\">-</td>
	// 						<td width=\"5%\">Usia</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"13%\">- Thn</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Tanggal</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
	// 						<td>Status</td>
	// 						<td> : </td>
	// 						<td>UMUM</td>
	// 					</tr>
	// 					<tr>
	// 						<td>Alamat</td>
	// 						<td> : </td>
	// 						<td>$data_pasien->alamat</td>
	// 						<td>Asal / Lokasi</td>
	// 						<td> : </td>
	// 						<td colspan=\"4\" rowspan=\"2\">-</td>
	// 					</tr>
	// 				</table>
	// 				<br/><hr>
	// 				";
	// 		} else {
	// 			$data_pasien=$this->pamdaftar->get_data_pasien_cetak($no_pa)->row();
	// 			if($data_pasien->sex=="L"){
	// 				$kelamin = "Laki-laki";
	// 			} else {
	// 				$kelamin = "Perempuan";
	// 			}

	// 			$almt = $almt."$data_pasien->alamat ";
	// 			if($data_pasien->rt!=""){
	// 				$almt = $almt."RT. $data_pasien->rt ";
	// 			}
	// 			if($data_pasien->rw!=""){
	// 				$almt = $almt."RW. $data_pasien->rw ";
	// 			}
	// 			if($data_pasien->kelurahandesa!=""){
	// 				$almt = $almt."$data_pasien->kelurahandesa ";
	// 			}
	// 			if($data_pasien->kecamatan!=""){
	// 				$almt = $almt."$data_pasien->kecamatan ";
	// 			}
	// 			if($data_pasien->kotakabupaten!=""){
	// 				$almt = $almt."<br>$data_pasien->kotakabupaten ";
	// 			}

	// 			if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
	// 				$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
	// 			} else if($data_pasien->no_telp!=""){
	// 				$nohptelp = $nohptelp."$data_pasien->no_telp";
	// 			} else if($data_pasien->no_hp!=""){
	// 				$nohptelp = $nohptelp."$data_pasien->no_hp";
	// 			} else {
	// 				$nohptelp = $nohptelp."-";
	// 			}

	// 			$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
	// 			$tahun=0;
	// 			$bulan=0;
	// 			$hari=0;
	// 			foreach($get_umur as $row)
	// 			{
	// 				// echo $row->umurday;
	// 				$tahun=floor($row->umurday/365);
	// 				$bulan=floor(($row->umurday - ($tahun*365))/30);
	// 				$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
	// 			}
	// 			// $nm_poli=$this->pamdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
	// 			$nm_poli=$data_pasien->idrg;
	// 			$nama_dokter=$this->pamdaftar->getnm_dokter($data_pasien->no_register)->row()->nm_dokter;
	// 			if($data_pasien->cara_bayar=='DIJAMIN'){
	// 				$a=$this->pamdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
	// 				$cara_bayar= "$a->a - $a->b";
	// 			} else {
	// 				$cara_bayar=$data_pasien->cara_bayar;
	// 			}
	// 			if (substr($no_register,0,2)=='RJ') {
	// 				$lokasi = $data_pasien->idrg;
	// 			}else if(substr($no_register,0,2)=='RI') {
	// 				$lokasi = 'Rawat Inap - '.$data_pasien->idrg;
	// 				// $lokasi = $nm_poli;
	// 			}else {
	// 				$lokasi = 'Pasien Langsung';
	// 			}
				

	// 			$konten=$konten.
	// 				"<table  border=\"0\">
	// 					<tr>
	// 						<td width=\"10%\">No. Pa</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"40%\">$no_pa</td>
	// 						<td width=\"10%\">No Reg</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"16%\">$data_pasien->no_register </td>
	// 						<td width=\"5%\">No MR</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"13%\">$data_pasien->no_cm</td>
	// 					</tr>
	// 					<tr>
	// 						<td>Dokter</td>
	// 						<td> : </td>
	// 						<td>$nama_dokter</td>
	// 						<td>Nama Pasien</td>
	// 						<td> : </td>
	// 						<td colspan=\"4\"><b>$data_pasien->nama</b></td>
	// 					</tr>
	// 					<tr>
	// 						<td>Dr. PJ. Pa</td>
	// 						<td> : </td>
	// 						<td>$data_pasien->nm_dokter</td>
	// 						<td width=\"10%\">Kelamin</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"16%\">$kelamin</td>
	// 						<td width=\"5%\">Usia</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"13%\">$tahun Thn</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Tanggal</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
	// 						<td>Status</td>
	// 						<td> : </td>
	// 						<td>$cara_bayar</td>
	// 					</tr>
	// 					<tr>
	// 						<td>Alamat</td>
	// 						<td> : </td>
	// 						<td>
	// 							$almt
	// 						</td>
	// 						<td>Asal / Lokasi</td>
	// 						<td> : </td>
	// 						<td colspan=\"4\" rowspan=\"2\">$lokasi</td>
	// 					</tr>
	// 				</table>
	// 				<br/><hr>
	// 				";
	// 		}
	// 		$hasil=$this->pamdaftar->get_data_hasil($no_pa)->row();
	// 		if($hasil->ganas==0)
	// 			$ganas = "Tidak tampak tanda ganas/khas";
	// 		else
	// 			$ganas = "Tampak tanda ganas/khas";
	// 		$konten=$konten."
	// 				<table style=\"font-size:9\">
	// 					<tr>
	// 						<td width=\"10%\">Topologi</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->topologi</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Morfologi</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->morfologi<br></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Diagnosa</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->diagnosa</td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Makroskopik</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->makroskopik<br></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Mikroskopik</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->mikroskopik<br></td>
	// 					</tr>
	// 					<tr>
	// 						<td width=\"10%\">Kesimpulan</td>
	// 						<td width=\"2%\"> : </td>
	// 						<td width=\"88%\">$hasil->kesimpulan<br><b>$ganas</b></td>
	// 					</tr>
	// 				</table><hr>
	// 				<style type=\"text/css\">
	// 				.table-isi{
	// 					    padding-left:10px; 
	// 					    font-size:9;
	// 					}
	// 				.table-isi th{
	// 					    border-bottom: 1px solid #ddd;
	// 					}
	// 				.table-isi td{
	// 					    border-bottom: 1px solid #ddd;
	// 					    border-right: 1px solid #ddd;
	// 					}
	// 				</style>
	// 				<hr>
	// 				<br/>
	// 				<br/>
	// 				<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
	// 					<tr>
	// 						<td width=\"75%\" ></td>
	// 						<td width=\"25%\">
	// 							<p align=\"center\">
	// 				<br/>
	// 							$kota_kab, $tgl								
								
	// 							<br><br><br><br><u>dr. Sigit Wijanarko, SpPA</u><br>
	// 							Mayor Laut (K) Nro. 17276/P
	// 							</p>
	// 						</td>
	// 					</tr>	
	// 				</table>
	// 				";
			
	// 		$file_name="Hasil_Pa_$no_pa.pdf";
	// 			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// 			tcpdf();
	// 			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
	// 			$obj_pdf->SetCreator(PDF_CREATOR);
	// 			$title = "";
	// 			$obj_pdf->SetTitle($file_name);
	// 			$obj_pdf->SetHeaderData('', '', $title, '');
	// 			$obj_pdf->setPrintHeader(false);
	// 			$obj_pdf->setPrintFooter(false);
	// 			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	// 			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	// 			$obj_pdf->SetDefaultMonospacedFont('helvetica');
	// 			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	// 			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	// 			$obj_pdf->SetMargins('5', '5', '5');
	// 			$obj_pdf->SetAutoPageBreak(TRUE, '5');
	// 			$obj_pdf->SetFont('helvetica', '', 9);
	// 			$obj_pdf->setFontSubsetting(false);
	// 			$obj_pdf->AddPage();
	// 			ob_start();
	// 				$content = $konten;
	// 			ob_end_clean();
	// 			$obj_pdf->writeHTML($content, true, false, true, false, '');
	// 			$obj_pdf->Output(FCPATH.'download/pa/papengisianhasil/'.$file_name, 'FI');
	// 	}else{
	// 		redirect('pa/pacpengisianhasil/','refresh');
	// 	}
	// }

	public function cetak_hasil_pa($id_pemeriksaan_pa='')
	{
		if($id_pemeriksaan_pa!=''){
			$no_register=$this->pamdaftar->get_row_register_by_id_pemeriksaan_pa($id_pemeriksaan_pa)->row()->no_register;
			// echo "<script> console.log('PHP: ".$no_register."');</script>";
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$email=$this->config->item('email');
			$header_pdf=$this->config->item('header_pdf');
			$header_pdf='<table class="table-font-size2" border="0">
				<tr>
				<td width="26%"><p align="center">
					<img src="asset/images/logos/logo_mintohardjo.png" alt="img" height="40" style="padding-right:5px;">
				</p>
				</td>
				<td  width="64%" style="font-size:8px;" align="center">
					<font style="font-size:9px">
						<b>
							RUMAH SAKIT ANGKATAN LAUT MINTOHARDJO
						</b>
					</font>
					<br>Jl. Bendungan Hilir No.17A, RT.4/RW.3, Bend. Hilir, Tanah Abang, Jakarta Telp. 021-5703081
				</td>
				</tr>
				</table>';

			$nohptelp = "";$almt = "";

			//HEADER
			$konten="<font size=\"5\" align=\"right\">$tgl_jam</font><br>
					$header_pdf
					<hr/>
					<p align=\"center\"><b>
					<font size=\"7\">HASIL LABORATORIUM HISTOPATOLOGI/SITOLOGI</font>
					</b></p><br/>
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px; 
						    font-size:8;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    border-right: 1px solid #ddd;
						}
						table{
							font-size:7;
						}
					</style>";
			$bawahana="";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->pamdaftar->get_data_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->row();
				if($data_pasien->jk=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}
				$konten=$konten.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Pa</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$data_pasien->no_pa_tindakan</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">Pasien Luar</td>
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
							<td>Dr. PJ. Pa</td>
							<td> : </td>
							<td>$data_pasien->nm_dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien=$this->pamdaftar->get_data_pasien_cetak_by_id_pemeriksaan($id_pemeriksaan_pa)->row();
				if($data_pasien->sex=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt."$data_pasien->alamat ";
				if($data_pasien->rt!=""){
					$almt = $almt."RT. $data_pasien->rt ";
				}
				if($data_pasien->rw!=""){
					$almt = $almt."RW. $data_pasien->rw ";
				}
				if($data_pasien->kelurahandesa!=""){
					$almt = $almt."$data_pasien->kelurahandesa ";
				}
				if($data_pasien->kecamatan!=""){
					$almt = $almt."$data_pasien->kecamatan ";
				}
				if($data_pasien->kotakabupaten!=""){
					$almt = $almt."<br>$data_pasien->kotakabupaten ";
				}

				if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
					$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
				} else if($data_pasien->no_telp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_telp";
				} else if($data_pasien->no_hp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp."-";
				}

				$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
				$tahun=0;
				$bulan=0;
				$hari=0;
				foreach($get_umur as $row)
				{
					// echo $row->umurday;
					$tahun=floor($row->umurday/365);
					$bulan=floor(($row->umurday - ($tahun*365))/30);
					$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				// $nm_poli=$this->pamdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				$nm_poli=$data_pasien->idrg;
				// $nama_dokter=$this->pamdaftar->getnm_dokter($data_pasien->no_register)->row()->nm_dokter;
				if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->pamdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)=='RJ') {
					$lokasi = $data_pasien->idrg;
					$dokter_pengirim = $this->pamdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
				}else if(substr($no_register,0,2)=='RI') {
					// $lokasi = 'Rawat Inap - '.$this->pamdaftar->getruang($data_pasien->idrg)->row()->nmruang;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg;
					$dokter_pengirim = $this->pamdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}

				if($data_pasien->id_dokter=='136')
					$bawahana="Mayor Laut (K) Nro. 17276/P";
				

				// Konten Landscape

				// $konten=$konten.
				// 	"<table  border=\"0\">
				// 		<tr>
				// 			<td width=\"10%\">Asal ruangan</td>
				// 			<td width=\"2%\"> : </td>
				// 			<td width=\"40%\">$lokasi</td>
				// 			<td width=\"12%\">Nama Pasien</td>
				// 			<td width=\"2%\"> : </td>
				// 			<td width=\"34%\">$data_pasien->nama </td>
				// 		</tr>
				// 		<tr>
				// 			<td>Umur/kelamin</td>
				// 			<td> : </td>
				// 			<td>$tahun th / $kelamin</td>
				// 			<td>No. PA</td>
				// 			<td> : </td>
				// 			<td colspan=\"4\">$no_pa</td>
				// 		</tr>
				// 		<tr>
				// 			<td>Status</td>
				// 			<td> : </td>
				// 			<td>-</td>
				// 			<td>Tanggal terima</td>
				// 			<td> : </td>
				// 			<td>".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
				// 		</tr>
				// 		<tr>
				// 			<td>Morfologi</td>
				// 			<td> : </td>
				// 			<td>-</td>
				// 			<td>Tanggal jawab</td>
				// 			<td> : </td>
				// 			<td>-</td>
				// 		</tr>
				// 		<tr>
				// 			<td>Topologi</td>
				// 			<td> : </td>
				// 			<td>
				// 				-
				// 			</td>
				// 			<td>Dokter pengirim</td>
				// 			<td> : </td>
				// 			<td colspan=\"4\" rowspan=\"2\">$nama_dokter</td>
				// 		</tr>
				// 		<tr>
				// 			<td></td>
				// 		</tr>
				// 	</table>
				// 	<br/>
				// 	";

				// Konten Portrait

				// $konten=$konten.
				// 	"<table  border=\"0\">
				// 		<tr>
				// 			<td width=\"17%\">Nama</td>
				// 			<td width=\"2%\"> : </td>
				// 			<td width=\"53%\">$data_pasien->nama</td>
				// 			<td width=\"10%\">No. PA</td>
				// 			<td width=\"2%\"> : </td>
				// 			<td width=\"20%\">$no_pa </td>
				// 		</tr>
				// 		<tr>
				// 			<td>Umur</td>
				// 			<td> : </td>
				// 			<td>$tahun th</td>
				// 		</tr>
				// 		<tr>
				// 			<td>Tanggal terima</td>
				// 			<td> : </td>
				// 			<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
				// 		</tr>
				// 		<tr>
				// 			<td>Tanggal jawab</td>
				// 			<td> : </td>
				// 			<td>NULL</td>
				// 		</tr>
				// 	</table>
				// 	<br/>
				// 	";

				$konten=$konten.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Pa</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$data_pasien->no_pa_tindakan</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter PJ</td>
							<td> : </td>
							<td>$dokter_pengirim</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Pa</td>
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
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			$jenis_tind=$this->pamdaftar->get_jenis_tindakan_pa($data_pasien->id_tindakan)->row()->jenis;
			$hasil_row = $this->pamdaftar->get_data_hasil($id_pemeriksaan_pa)->row()->hasil;
			$hasil = json_decode($hasil_row);

			if($data_pasien->jenis_blanko==2){//sito
				$konten=$konten."
					<table border=\"0\">
						<tr>
							<td width=\"17%\">Makroskopik</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->makroskopik<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Mikroskopik</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->mikroskopik<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Kesimpulan</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->kesimpulan</td>
						</tr>
						<tr>
							<td width=\"17%\">Saran</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->saran</td>
						</tr>
					</table>
					";
			
			}else{//histo
				if($hasil_row != ""){
				if($hasil->ganas==0)
					$ganas = "Tidak tampak tanda ganas/khas";
				else
					$ganas = "Tampak tanda ganas/khas";
				$konten=$konten."
					<table border=\"0\">
						<tr>
							<td width=\"17%\">Morfologi</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->morfologi<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Topologi</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->topologi<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Diagnosa</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->diagnosa<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Makroskopik</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->makroskopik<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Mikroskopik</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->mikroskopik<br></td>
						</tr>
						<tr>
							<td width=\"17%\">Kesimpulan</td>
							<td width=\"2%\"> : </td>
							<td width=\"81%\">$hasil->kesimpulan<br><b>$ganas</b></td>
						</tr>
					</table>
					";
				}else{
					$konten=$konten."
					<table border=\"0\">
						<tr>
							<td>Tidak ada Data</td>
						</tr>
					</table>";
				}
			}

			$konten.="
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"60%\" ></td>
							<td width=\"40%\">
								<p align=\"center\">
					<br/>
								$kota_kab, $tgl								
								
								<br><br><br><br><u>$data_pasien->nm_dokter</u><br>
								$bawahana
								</p>
							</td>
						</tr>	
					</table>";

			
			
			$file_name="Hasil_Pa_$no_pa_tindakan.pdf";
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
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/pa/papengisianhasil/'.$file_name, 'FI');
		}else{
			redirect('pa/pacpengisianhasil/','refresh');
		}
	}
	public function export_hasil_pa($no_pa=''){
		if($no_pa!=''){
			$no_register=$this->pamdaftar->get_row_register_by_nopa($no_pa)->row()->no_register;
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$email=$this->config->item('email');
			$header_pdf=$this->config->item('header_pdf');

			$data_jenis_pa=$this->pamdaftar->get_data_jenis_pa($no_pa)->result();
			$data_kategori_pa=$this->pamdaftar->get_data_kategori_pa($no_pa)->result();


			////EXCEL 
			$this->load->library('Excel');  
			   
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   
			   
			// Set document properties  
			$objPHPExcel->getProperties()->setCreator("RUMAH SAKIT KHUSUS MATA")  
			        ->setLastModifiedBy("RUMAH SAKIT KHUSUS MATA")  
			        ->setTitle("Laporan Keuangan RUMAH SAKIT KHUSUS MATA")  
			        ->setSubject("Laporan Keuangan RUMAH SAKIT KHUSUS MATA Document")  
			        ->setDescription("Laporan Keuangan RUMAH SAKIT KHUSUS MATA, generated by HMIS.")  
			        ->setKeywords("RUMAH SAKIT KHUSUS MATA")  
			        ->setCategory("Patologi Anatomi");  

			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
			//$objPHPExcel = $objReader->load("project.xlsx");
			   
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');

			$data_keuangan=$this->pamlaporan->get_data_keu_tind($param1, $param2)->result();
		
			$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_pa.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);  
			// Add some data  
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Patologi Anatomi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	      	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$rowCount = 4;
			$temp = "";
			$temptgl = "";
			$total_pendapatan = 0;
			foreach($data_keuangan as $row){
				if($temptgl == $row->tgl_kunjungan){

				}else {
					$temptgl = $row->tgl_kunjungan;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
				}

				if($temp == $row->no_pa){
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_pa);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if($row->cara_bayar=="BPJS"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
					}else if($row->status=="1"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
					}
				}else {
					$temp = $row->no_pa;
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_pa);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->bed);
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_pa);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if($row->cara_bayar=="BPJS"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
					}else if($row->status=="1"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
					}
				}
				
				$rowCount++;
			}
			$filename = "Laporan Pendapatan Patologi Anatomi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('RUMAH SAKIT KHUSUS MATA');    
			   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Cache-Control: max-age=0');  
			   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			// $objWriter->save('php://output');  
			$this->SaveViaTempFile($objWriter);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');
			// $data_keuangan=$this->pamlaporan->get_data_keu_tind($awal, $akhir)->result();
			// echo json_encode($data_keuangan);
		}else{
			redirect('pa/pacpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_pa_tindakan($id_pemeriksaan_pa = '', $no_pa = '')
	{
		
		if ($id_pemeriksaan_pa != '') {
			$data['no_pa'] = $no_pa;

			$data['no_register'] = $this->pamdaftar->get_row_register_by_nopa($no_pa)->row()->no_register;
			$no_register = $data['no_register'];

			$conf = $this->appconfig->get_headerpdf_appconfig()->result();
			$top_header = $this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header = $this->appconfig->get_header_bottom_pdfconfig()->value;
			$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
			$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;

			$data['data_hasil_pa'] = $this->pamdaftar->get_data_hasil_pa_pertindakan($id_pemeriksaan_pa)->result();
		
			$data['data_pasien'] = $this->pamdaftar->get_data_pasien_cetak($no_pa)->row();
			
				if ($data['data_pasien']->sex == "L") {
					$data['kelamin'] = "Laki-laki";
				} else {
					$data['kelamin'] = "Perempuan";
				}

				$almt = $data['data_pasien']->alamat;
				if ($data['data_pasien']->rt != "") {
					$almt = $almt . "RT" . $data['data_pasien']->rt;
				}
				if ($data['data_pasien']->rw != "") {
					$almt = $almt . "RW:" . $data['data_pasien']->rw;
				}
				if ($data['data_pasien']->kelurahandesa != "") {
					$almt = $almt . $data['data_pasien']->kelurahandesa;
				}
				if ($data['data_pasien']->kecamatan != "") {
					$almt = $almt . $data['data_pasien']->kecamatan;
				}
				if ($data['data_pasien']->kotakabupaten != "") {
					$almt = $almt . "<br>" . $data['data_pasien']->kotakabupaten;
				}

				$data['almt'] = $almt;

				$get_umur = $this->rjmregistrasi->get_umur($data['data_pasien']->no_medrec)->result();
				$tahun = 0;
				$bulan = 0;
				$hari = 0;
				foreach ($get_umur as $row) {
					$data['tahun'] = $row->umurday;
				}

				if ($data['data_pasien']->cara_bayar == 'DIJAMIN') {
					$a = $this->labmdaftar->getcr_bayar_dijamin($data['data_pasien']->no_register)->row();
					$data['cara_bayar'] = "$a->a - $a->b";
				} else {
					$data['cara_bayar'] = $data['data_pasien']->cara_bayar;
				}
				if (substr($no_register, 0, 2) == 'RJ') {
					$data['nama_dokter'] = $this->pamdaftar->getnm_dokter_rj($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = $data['data_pasien']->idrg;
				} else if (substr($no_register, 0, 2) == 'RI') {
					$data['nama_dokter'] = $this->pamdaftar->getnm_dokter_ri($data['data_pasien']->no_register)->row()->nm_dokter;
					$data['lokasi'] = 'Rawat Inap - ' . $data['data_pasien']->idrg;
				} else {
					$data['lokasi'] = 'Pasien Langsung';
				}

				$isi = "" . md5($data['data_pasien']->no_cm) . "" . md5($no_register) . "" . md5($no_pa) . " || Cek Validasi di www.doc.rsomh.co.id";
			

			foreach ($data['data_hasil_pa'] as $row) {
				if (!empty($row->id_dokter)) {
					$data['dokter_1'] = '';
					$data['id_dokter_1'] = '';
				} else {
					$data['dokter_1'] = "";
					$data['id_dokter_1'] = "";
				}
			}

			$data['tgl'] = date("d-m-Y");

			$writer = new PngWriter();
			$qrCode = QrCode::create($isi)
				->setEncoding(new Encoding('UTF-8'))
				->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
				->setSize(155)
				->setMargin(10)
				->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
				->setForegroundColor(new Color(0, 0, 0, 10))
				->setBackgroundColor(new Color(255, 255, 255));

			// Create generic logo
			$logo = Logo::create(FCPATH . 'assets/img/Logo-rsomh-qr.png')
				->setResizeToWidth(40);

			// Create generic label
			$label = Label::create('')
				->setTextColor(new Color(255, 0, 0));

			// $result = $writer->write($qrCode, $logo, $label);

			// // Directly output the QR code
			// $hasil =  $result->getDataUri();
			// $data['qr'] = $hasil;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('pa/paper_css/hasil_pertindakan', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		} else {
		}
	}
}