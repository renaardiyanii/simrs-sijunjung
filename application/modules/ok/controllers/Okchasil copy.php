<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Okchasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('ok/okmdaftar','',TRUE);
		$this->load->model('ok/okmkwitansi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR PASIEN OPERASI';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok()->result();
		$this->load->view('ok/okvdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR PASIEN HASIL OPERASI | Tanggal '.$date;

		$data['operasi']=$this->okmdaftar->get_daftar_selesaipasien_ok_by_date($date)->result();
		$this->load->view('ok/okvdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR PASIEN HASIL OPERASI | '.$key;

		$data['operasi']=$this->okmdaftar->get_daftar_selesaipasien_ok_by_no($key)->result();
		$this->load->view('ok/okvdaftarpengisian',$data);
	}

	public function input_hasil($idoperasi_header){				
		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
	    		$data['title'] = 'LAPORAN OPERASI PASIEN | '.$data['data_pasien']->no_register;
	    		
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
				if($data['cara_bayar']=='DIJAMIN' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='DIJAMIN' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else{
					$data['nmkontraktor']='';
				}
		//$data['detail_operasi']=$this->okmdaftar->get_data_detai($idoperasi_header)->result();
		$this->load->view('ok/okvhasilpasien',$data);
		//print_r($data);
	}

	public function jadwal_operasi(){
		$data['title'] = 'JADWAL PASIEN OPERASI';

		$this->load->view('ok/okvjadwal',$data);
		//print_r($data);
	}	
	
	public function get_operasi_header($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_operasi_header_byid($id)->row();
			echo json_encode($data_header);
		}
		
	}

	public function save_hasilok()
	{
		$data['no_register']=$this->input->post('no_register');	
		
		$data['type_anas']=$this->input->post('type_anas');
		$data['type_operasi']=$this->input->post('type_operasi');

		$data['type_anas']=$this->input->post('type_anas');
		$data['type_operasi']=$this->input->post('type_operasi');
		$id_icd9cm = $this->input->post('id_icd9cm');
		$diagpreop = explode("@", $this->input->post('diagnosapreok'));    	
    	if ($this->input->post('id_diagnosapreok') == '') {
    		$data['iddiag_preop'] = ''; 
    		$data['diag_preop'] = ''; 
    	} else {
			$data['iddiag_preop'] = $diagpreop[0]; 
			$data['diag_preop'] = $diagpreop[1];     		
    	}

    	$diagpostop = explode("@", $this->input->post('diagnosapostok'));    	
    	if ($this->input->post('id_diagnosapostok') == '') {
    		$data['iddiag_postop'] = ''; 
    		$data['diag_postop'] = ''; 
    	} else {
			$data['iddiag_postop'] = $diagpostop[0]; 
			$data['diag_postop'] = $diagpostop[1];     		
    	}

		$data['tind_ok']=$this->input->post('tind_ok');
		$data['lap_ok']=$this->input->post('lap_ok');	
		$data['cat_pr']=$this->input->post('cat_pr');		
		$data['intime_jadwal_ok']=$this->input->post('intime_jadwal_ok');
		$data['outtime_jadwal_ok']=$this->input->post('outtime_jadwal_ok');
		//$data['lama_ok']=$this->input->post('lama_ok');

		$start_time = new DateTime($data['intime_jadwal_ok']);
	    $end_time = new DateTime($data['outtime_jadwal_ok']);

	    $time_diff = date_diff($start_time,$end_time);

	    $data['lama_ok']= $time_diff->format('%h');
		$data['xupdate']=date('Y-m-d H:i:s');
		
		$idoperasi_header=$this->input->post('idoperasi_header');
		//print_r($data);break;
		$id=$this->okmdaftar->update_detailok($data,$idoperasi_header);

		echo json_encode($id);
		
		
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
				$txtdokter=$txtdokter.'<br>Asisten Dokter : '.$value->nm_asist_dokter.' ('.$value->id_dokter_asist.')';
			if($value->id_dok_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anestesi: '.$value->nm_dok_anes.' ('.$value->id_dok_anes.')';
			if($value->perawat_anastesi<>NULL)
				$txtdokter=$txtdokter.'<br>Perawat Anestesi: '.$value->perawat_anastesi;
			if($value->jns_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Jenis Anestesi: '.$value->jns_anes;
			if($value->id_dok_anak<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anak: '.$value->nm_dok_anak.' ('.$value->id_dok_anak.')';
			$row2['operator'] = $txtdokter;
			$row2['aksi'] = '<button type="button" class="btn btn-danger btn-xs" onClick="hapus_data_pemeriksaan('.$value->id_pemeriksaan_ok.')"><i class="fa fa-trash"></i></button>';		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function insert_pemeriksaan()
	{
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
		$data['id_dokter_asist']=$this->input->post('id_dokter_asist');

		if($this->input->post('perawat_anas')!=''){
			$data['perawat_anastesi']=$this->input->post('perawat_anas');
		}
		
		$data['id_dokter2']=$this->input->post('id_dokter2');
		//$data['id_opr_anes']=$this->input->post('id_opr_anes');
		$data['id_dok_anes']=$this->input->post('id_dok_anes');
		$data['jns_anes']=$this->input->post('jns_anes');
		$data['id_dok_anak']=$this->input->post('id_dok_anak');
		//$data['tgl_jadwal']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		//$data['tgl_operasi']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		$data['biaya_ok']=$this->input->post('biaya_ok_hide');
		$data['qty']=$this->input->post('qty');
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

		$id=$this->okmdaftar->insert_pemeriksaan($data);
		echo json_encode($id);
		//redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register'].'/'.$data['no_ok']);
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

		$this->okmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_ok=$this->okmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_ok;

		if($getrdrj=="PL"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotok,$no_ok);
		} else if($getrdrj=="RJ"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotok,$no_ok);
		}
		else if ($getrdrj=="RD"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotok,$no_ok);
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

	public function cetak_hasil($idoperasi_header='')
	{
		$jumlah_vtot=$this->okmdaftar->get_vtot_id_ok($idoperasi_header)->row()->vtot_no_ok;
		if($idoperasi_header!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->okmkwitansi->get_data_pasien($idoperasi_header)->row();
			$data_pemeriksaan=$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
			
			$cterbilang=new rjcterbilang();

			$tahun=0;
			$bulan=0;
			$hari=0;
			$tahun=floor($data_pasien->tgl_lahir/365);
			$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
			$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);			
			
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
					<p><font size=\"7\" align=\"right\">$tgl_jam</font></p>
					".$this->config->item('header_pdf')."
					<hr/>
					<h3 align=\"center\"><b><u>LAPORAN OPERASI</u><br/>
					No. OK_$idoperasi_header
					</b></h3>
					<table>												
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->no_register</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->nama ($data_pasien->sex)</td>
						</tr>
						<tr>
							<td><b>No. RM</b></td>
							<td> : </td>
							<td>$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td><b>Umur</b></td>
							<td> : </td>
							<td>$tahun tahun, $bulan bulan, $hari hari.</td>
						</tr>
						<tr>
							<td><b>Nama Dokter Operator</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->nm_dokter</td>
						</tr>
						<tr>
							<td><b>Nama Asisten</b></td>
							<td> : </td>
							<td></td>
						</tr>
						<tr>
							<td><b>Jenis Operasi</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->type_operasi</td>
						</tr>
						<tr>
							<td><b>Jenis Anestesi</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->type_anas</td>
						</tr>
					</table>
					<br/>

					<hr>					
					<table>	
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"77%\"></td>
						</tr>											
						<tr>
							<td width=\"20%\"><b>Diagnosa Pre Op</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">".$data_pemeriksaan->iddiag_preop." - ".$data_pemeriksaan->diag_preop."</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Diagnosa Post Op</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">".$data_pemeriksaan->iddiag_postop." - ".$data_pemeriksaan->diag_postop."</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Tindakan Operasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">$data_pemeriksaan->tind_ok</td>
						</tr>
					</table>
					<br><br>
					<table border=\"1\" style=\"padding:2px\">		
						<thead>										
						<tr>
							<td width=\"20%\"><b>Tgl Operasi</b></td>							
							<td width=\"20%\"><b>Jam Operasi Dimulai</b></td>
							<td width=\"20%\"><b>Jam Operasi Selesai</b></td>
							<td width=\"30%\"><b>Lama Operasi Berlangsung</b></td>							
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width=\"20%\" align=\"center\">".date('d-m-Y',strtotime($data_pemeriksaan->tgl_jadwal_ok))."</td>		
							<td width=\"20%\" align=\"center\">$data_pemeriksaan->intime_jadwal_ok</td>
							<td width=\"20%\" align=\"center\">$data_pemeriksaan->outtime_jadwal_ok</td>
							<td width=\"30%\" align=\"center\">$data_pemeriksaan->lama_ok Jam</td>							
						</tr>
						</tbody>
					</table>
					<br><br>
					<table >												
						<tr>
							<td width=\"20%\"><b>Laporan Operasi</b></td>	
							<td width=\"3%\"> : </td>						
							<td width=\"77%\">$data_pemeriksaan->lap_ok</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Catatan</b></td>	
							<td width=\"3%\"> : </td>						
							<td width=\"77%\" rowspan=\"3\"></td>
						</tr>
					</table>
					";									
				$this->load->helper('pdf_helper');
				
				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
				$konten=$konten."					
					<br>
					<br><br>
					<br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>Tanda Tangan Dokter Operator
								<br><br><br><br><br>(_______________________)
								</p>
							</td>
						</tr>	
					</table>
					";
				
			// $file_name="FKTR_$no_ok.pdf";
				$file_name="HASIL_OK_".$idoperasi_header."_".$data_pasien->nama.".pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
				$obj_pdf->Output(FCPATH.'download/ok/okhasil/'.$file_name, 'FI');
		}else{
			redirect('ok/okcdaftar/','refresh');
		}
	}
}