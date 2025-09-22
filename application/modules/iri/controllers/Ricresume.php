<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
class Ricresume extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimpasien');
		$this->load->helper('pdf_helper');
	}
	public function index(){
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		$this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivresume');
		$this->load->view('iri/form_resume');
		//$this->load->view('iri/rivfooter');
	}

	public function simpan_resume(){
		//echo "stop";exit;
		// var_dump($this->input->post);die();
		$data_pendaftaran['no_ipd']=$this->input->post('no_ipd');

		

		$data_pendaftaran['drpengirim']=$this->input->post('drpengirim');
		$data_pendaftaran['id_dokter']=$this->input->post('id_dokter');
		// print_r($data_pendaftaran['id_dokter']);
		// exit();
		$data_pendaftaran['dokter']=$this->input->post('dokter');
		$data_pendaftaran['drkonsulen']=$this->input->post('drkonsulen');
		$data_pendaftaran['anamnesa']=$this->input->post('anamnesa');
		$data_pendaftaran['pemfisik']=$this->input->post('pemfisik');
		$data_pendaftaran['diagnosa1']=$this->input->post('diagnosa1');
		$data_pendaftaran['pngobatan']=$this->input->post('pngobatan');
		$data_pendaftaran['prognosis']=$this->input->post('prognosis');
		$data_pendaftaran['lanjutan']=$this->input->post('lanjutan');

		$data_pendaftaran['anjuran']=$this->input->post('anjuran');
		$data_pendaftaran['cara_pulang']=$this->input->post('cara_pulang');
		//$data_pendaftaran['procmasuk']=$this->input->post('procmasuk');
		if($this->input->post('keadaanpulang') == 'MENINGGAL'){
			$mati = $this->input->post('kondisi_meninggal');

			$data_pendaftaran['tgl_meninggal']=$this->input->post('tgl_meninggal');
			$data_pendaftaran['jam_meninggal']=$this->input->post('jam_meninggal');
			$data_pendaftaran['kondisi_meninggal']=$this->input->post('kondisi_meninggal'); // nanti buka komennya

		}else{
			$mati = $this->input->post('keadaanpulang');
		}
		$data_pendaftaran['status_pulang']=$mati;
		$tglpulang = $this->input->post('tgl_pulang');
		
		if($tglpulang != '') {
			$data_pendaftaran['tgl_keluar_resume']=date('Y-m-d', strtotime($tglpulang));// nanti buka komennya
		} else {
			$data_pendaftaran['tgl_keluar_resume'] = NULL;
		}

		//update data pasien_iri, flag tanggal pulang, status pulang
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pendaftaran, $data_pendaftaran['no_ipd']);
		$this->rimpendaftaran->update_diagnosa1($data_pendaftaran['diagnosa1'], $data_pendaftaran['no_ipd']);
		//update tgl keluar. tiba tiba ga mau inser tanggal keluar
	// $this->rimpendaftaran->update_tgl_keluar($data_pendaftaran, $data_pendaftaran['no_ipd']);
		
		//kalo punya bayi, ikut pulangin juga
		$bayi = $this->rimpasien->get_bayi_by_ipd_ibu($data_pendaftaran['no_ipd']);
		if(($bayi)){
			//echo "stop";exit;
			$data_bayi['no_ipd']=$bayi[0]['no_ipd'];
			$data_bayi['tgl_keluar_resume']=$this->input->post('tgl_pulang'); // nanti buka komennya

			//set kwintasi bayi jadi 1
			$data_bayi['cetak_kwitansi']=1;

			//update data pasien_iri, flag tanggal pulang, status pulang
			$this->rimpendaftaran->update_pendaftaran_mutasi($data_bayi, $data_bayi['no_ipd']);
			//$this->rimpendaftaran->update_diagnosa1($data_bayidata_bayi['diagnosa1'], $data_bayi['no_ipd']);
			//update tgl keluar. tiba tiba ga mau inser tanggal keluar

			$this->rimpendaftaran->update_tgl_keluar($data_bayi, $data_bayi['no_ipd']);
		}

		// set di bed N
		$data_bed['isi'] = 'N';
		$bed = $this->input->post('bed');
		$this->rimkelas->flag_bed_by_id($data_bed,$bed); //buka komennya

		//set di ruang iri tanggal pulang diisi
	// $this->rimpendaftaran->update_ruang_iri($data_pendaftaran['tgl_keluar'],$data_pendaftaran['no_ipd']); // buka komennya

		$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Data telah disimpan!
			</div>");
		redirect('iri/rictindakan/index/'.$data_pendaftaran['no_ipd']."");
		// redirect('iri/rictindakan/pulang/'.$data_pendaftaran['no_ipd']."/1");
	}

	public function pdf_resume($no_ipd=''){
		$data['pasien'] = $this->rimtindakan->get_pasien_by_no_ipd_for_resume($no_ipd);
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
		$data['note_iri'] = $this->rimtindakan->get_note_iri_for_resume($no_ipd);
		$data['obat'] = $this->rimtindakan->get_obat_for_resume($no_ipd);
		$data['radiologi'] = $this->rimtindakan->get_radiologi_for_resume($no_ipd);
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);

		$this->load->view('iri/resume_medis_iri',$data);
		// $namars=$this->config->item('namars');
		// 	$alamatrs=$this->config->item('alamat');
		// 	$telprs=$this->config->item('telp');
		// 	$kota=$this->config->item('kota');
		// 	$nmsingkat=$this->config->item('nmsingkat');
		// if ($pasien == null) {
		// 	echo "Data Pasien Tidak Ada";
		// } else {			
		// $diagnosa_tambahan = "";
		// //data semua diagnosa
		// $diagnosa_pasien = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd); 
		// if(($diagnosa_pasien)){
		// 	$diagnosa_tambahan = '<tr>
		// 	<td align="left">  Diagnosa Tambahan</td>
		// 	<td align="left">';
		// 	foreach ($diagnosa_pasien as $r) {
		// 		$diagnosa_tambahan = $diagnosa_tambahan.$r['id_diagnosa']." - ".$r['diagnosa']."<br>";
		// 	}
		// 	$diagnosa_tambahan = $diagnosa_tambahan.'</td>
		// 	<td align="left"></td>
		// 	<td align="left"></td>
		// 	</tr>'; 
		// }


		// $nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		// $file_name = "resume_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf";
		
		// $konten = "
		// 			<style type=\"text/css\">
		// 			.table-font-size{
		// 				font-size:10px;
		// 			    }
		// 			</style>

		// 			<table class=\"table-font-size\" border=\"0\">
		// 				<tr>
		// 				<td rowspan=\"3\" width=\"15%\" style=\" font-size:13px; \"><p><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" style=\"padding-right:5px;\"></p></td>
		// 				<td width=\"65%\" style=\" font-size:12px;\">
		// 				<br/><b>$namars</b> <br/><span style=\"font-size:10px;\">$alamatrs</span><br/><span style=\"font-size:10px;\">$telprs</span></td>
		// 				<td width=\"20%\">
		// 					<br/>
		// 				</td>
		// 				</tr>												
		// 			</table>
		// 			<hr>
		// 			<table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: ".date("j F Y", strtotime(date("y-m-d")))."</b></td>
		// 				</tr>

		// 			</table>
		// 			<p align=\"center\"><b>
		// 			Resume Medical Record Pasien<br/>
		// 			No. Register. ".$pasien[0]['no_ipd']."
		// 			</b></p><br/>
		// 			<table >
		// 				<tr>
		// 					<td width=\"100\" ><b>Nama Pasien</b></td>
		// 					<td width=\"300\"> : ".$pasien[0]['nama']."</td>
		// 				</tr>
		// 				<tr>
		// 					<td><b>No. Rekam Medis</b></td>
		// 					<td> : ".$pasien[0]['no_cm']."</td>
		// 				</tr>
		// 				<tr>
		// 					<td><b>Tgl. Lahir</b></td>
		// 					<td> : ".date("j F Y", strtotime($pasien[0]['tgl_lahir']))."</td>
		// 				</tr>
		// 				<tr>
		// 					<td><b>Alamat Pasien</b></td>
		// 					<td> : ".$pasien[0]['alamat']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>

		// 			";
		// $konten= $konten .'
		// <table border="1">
		// 	<tr>
		// 		<td align="left">  Tgl. Masuk</td>
		// 		<td align="left">  '.date("j F Y", strtotime($pasien[0]['tgl_masuk'])).'</td>
		// 		<td align="left">  Tgl. Meninggal</td>
		// 		<td align="left">  -</td>
		// 	</tr>
		// 	<tr>
		// 		<td align="left">  SMF</td>
		// 		<td align="left">  '.$pasien[0]['id_smf'].'</td>
		// 		<td align="left">  Ruang</td>
		// 		<td align="left">  '.$pasien[0]['idrg'].'</td>
		// 	</tr>
		// 	<tr>
		// 		<td align="left">  Kelas / Bed</td>
		// 		<td align="left">  '.$pasien[0]['kelas'].' / '.$pasien[0]['bed'].'</td>
		// 		<td align="left">  Dr. Konsulen</td>
		// 		<td align="left">  '.$pasien[0]['drkonsulen'].'</td>
		// 	</tr>

		// 	<tr>
		// 		<td align="left">  Anamnesa</td>
		// 		<td align="left">  '.$pasien[0]['anamnesa'].'</td>
		// 		<td align="left">  Pemeriksaan Fisik</td>
		// 		<td align="left">  '.$pasien[0]['pemfisik'].'</td>
		// 	</tr>
		// 	<tr>
		// 		<td align="left">  Diagnosa Akhir</td>
		// 		<td align="left">  '.$pasien[0]['diagnosa1'].' - '.$pasien[0]['nm_diagnosa'].'</td>
		// 		<td align="left">  Pengobatan/ Tindakan</td>
		// 		<td align="left">  '.$pasien[0]['pngobatan'].'</td>
		// 	</tr>

		// 	'.$diagnosa_tambahan.'

		// 	<tr>
		// 		<td align="left">  Prognosis</td>
		// 		<td align="left">  '.$pasien[0]['prognosis'].'</td>
		// 		<td align="left">  Pengobatan Lanjutan</td>
		// 		<td align="left">  '.$pasien[0]['lanjutan'].'</td>
		// 	</tr>

		// 	<tr>
		// 		<td align="left">  Anjuran</td>
		// 		<td align="left">  '.$pasien[0]['anjuran'].'</td>
		// 		<td align="left">  Dr. Yang Merawat</td>
		// 		<td align="left">  '.$pasien[0]['dokter'].'</td>
		// 	</tr>

		// 	<tr>
		// 		<td align="left">  Keadaan Pulang</td>
		// 		<td align="left">  '.$pasien[0]['keadaanpulang'].'</td>
		// 		<td align="left">  Dr. Pengirim</td>
		// 		<td align="left">  '.$pasien[0]['drpengirim'].'</td>
		// 	</tr>
		// 	<tr>
		// 		<td align="left">  Tgl Pulang</td>
		// 		<td align="left">  '.date("j F Y", strtotime($pasien[0]['tgl_keluar'])).'</td>
		// 	</tr>
		// </table>
		// ';
		// tcpdf();
		// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		// $obj_pdf->SetCreator(PDF_CREATOR);
		// $title = "Resume Medik Pasien - ".$pasien[0]['no_ipd']." - ".$pasien[0]['nama'];
		// $tgl_cetak = date("j F Y");
		// $obj_pdf->SetTitle($file_name);
		// $obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// $obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins('5', '5', '5', '5');
		// $obj_pdf->setPrintHeader(false);
		// $obj_pdf->setPrintFooter(false);
		// $obj_pdf->SetAutoPageBreak(TRUE, '5');
		// $obj_pdf->SetFont('helvetica', '', 9);
		// $obj_pdf->setFontSubsetting(false);
		// $obj_pdf->AddPage();
		// ob_start();
		// 	$content = $konten;
		// ob_end_clean();
		// $obj_pdf->writeHTML($content, true, false, true, false, '');
		// $obj_pdf->Output(FCPATH.'/download/inap/laporan/resume/'.$file_name, 'FI');
		// } // else
		
	}
}
