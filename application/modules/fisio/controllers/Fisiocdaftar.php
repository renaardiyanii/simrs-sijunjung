<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include('.php');
require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Fisiocdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('fisio/fisiomdaftar','',TRUE);
		$this->load->model('fisio/fisiomkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR PASIEN FISIOTERAPI Tanggal '.date('d-m-Y');

		$data['fisioterapi']=$this->fisiomdaftar->get_daftar_pasien_fisio()->result();
		$this->load->view('fisio/fisiovdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR PASIEN FISIOTERAPI Tanggal '.date('d-m-Y',strtotime($date));

		$data['fisioterapi']=$this->fisiomdaftar->get_daftar_pasien_fisio_by_date($date)->result();
		$this->load->view('fisio/fisiovdaftarpasien',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR PASIEN FISIOTERAPI | '.$key;

		$data['fisioterapi']=$this->fisiomdaftar->get_daftar_pasien_fisio_by_no($key)->result();
		$this->load->view('fisio/fisiovdaftarpasien',$data);
	}

	public function pemeriksaan_fisio($no_register=''){
		$data['title'] = 'Input Pemeriksaan Fisioterapi';

		$data['no_register']=$no_register;

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->fisiomdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
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
				$data['tgl_periksa']=$row->tgl_kunjungan;
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->fisiomdaftar->get_data_pasien_pemeriksaan($no_register)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;				
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;	
				$data['tgl_periksa']=$row->tgl_kunjungan;			
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->fisiomdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='III';

				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();		
				
			}else if (substr($no_register, 0,2)=="RI"){				
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->fisiomdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['data_jenis_fisio']=$this->fisiomdaftar->get_jenis_fisio()->result();
		$data['data_pemeriksaan']=$this->fisiomdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter']=$this->fisiomdaftar->getdata_dokter()->result();
		$data['tindakan']=$this->fisiomdaftar->getdata_tindakan_pasien()->result();
		
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->fisiomdaftar->get_roleid($login_data->userid)->row()->roleid;

		$this->load->view('fisio/fisiovpemeriksaan',$data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=$this->fisiomdaftar->get_biaya_tindakan($id_tindakan,$kelas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data['kelas']=$this->input->post('kelas_pasien');
		if($this->input->post('tgl_periksa')!=''){
			$data['tgl_kunjungan']=$this->input->post('tgl_periksa');
		}else $data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data_tindakan=$this->fisiomdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['qty']=$this->input->post('qty');
		$data['id_dokter']=$this->input->post('id_dokter');
		$data_dokter=$this->fisiomdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_fisio']=$this->input->post('biaya_fisio_hide');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');

		/*$data['no_lab']=$this->input->post('no_lab');
		if($data['no_lab']!=''){
		} else {
			$this->fisiomdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_lab']=$this->fisiomdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_lab;
		}*/

		$this->fisiomdaftar->insert_pemeriksaan($data);
		
		//redirect('fisio/fisiocdaftar/pemeriksaan_fisio/'.$data['no_register'].'/'.$data['no_lab']);
		// redirect('fisio/fisiocdaftar/pemeriksaan_fisio/'.$data['no_register']);
		//print_r($data);
		echo json_encode(array("status" => TRUE));
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
				if($this->input->post('tgl_periksa')!=''){
					$data['tgl_kunjungan']=$this->input->post('tgl_periksa');
				}else 
					$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan=$this->fisiomdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach($data_tindakan as $row){
					$data['jenis_tindakan']=$row->nmtindakan;
				}
				$data['qty']='1';
				$data['id_dokter']=$this->input->post('id_dokter');
				$data_dokter=$this->fisiomdaftar->getnama_dokter($data['id_dokter'])->result();
				foreach($data_dokter as $row){
					$data['nm_dokter']=$row->nm_dokter;
				}
				$data['biaya_fisio']=$this->fisiomdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				$data['vtot']=$data['biaya_fisio'];
				$data['idrg']=$this->input->post('idrg');
				$data['bed']=$this->input->post('bed');
				$data['cara_bayar']=$this->input->post('cara_bayar');
				$data['xinput']=$this->input->post('xuser');

				$id=$this->fisiomdaftar->insert_pemeriksaan($data);
		    }
			echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR FISIO DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotfisio=$this->fisiomdaftar->get_vtot_fisio($no_register)->row()->vtot_fisio;
		$getrdrj=substr($no_register, 0,2);

		$this->fisiomdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_fisio=$this->fisiomdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_fisio;

		if($getrdrj=="PL"){
			$this->fisiomdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotfisio,$no_fisio);
		} else if($getrdrj=="RJ"){
			$this->fisiomdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotfisio,$no_fisio);
		}
		else if ($getrdrj=="RD"){
			$this->fisiomdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotfisio,$no_fisio);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->fisiomdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_fisio=$row->status_fisio;
			}
			$status_fisio = $status_fisio + 1;
			$this->fisiomdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_fisio,$getvtotfisio,$no_fisio);
		}

		//window.open("'.site_url("fisio/fisiocdaftar/cetak_blanko/$no_fisio").'", "_blank");
		if($getrdrj=="PL"){
			echo '<script type="text/javascript">
					window.open("'.site_url("fisio/fisiocdaftar/cetak_faktur/$no_fisio").'", "_blank");
					window.focus()
				</script>';
			redirect('fisio/fisiocdaftar/','refresh');
		} 
		else if($getrdrj=="RJ"){
			echo '<script type="text/javascript">
					window.open("'.site_url("fisio/fisiocdaftar/cetak_faktur/$no_fisio").'", "_blank");
					window.focus()
				</script>';
			redirect('fisio/fisiocdaftar/','refresh');

		}
		else if ($getrdrj=="RD"){
			echo '<script type="text/javascript">
					window.open("'.site_url("fisio/fisiocdaftar/cetak_faktur/$no_fisio").'", "_blank");
					window.focus()
				</script>';
			redirect('fisio/fisiocdaftar/','refresh');

		}
		else if ($getrdrj=="RI"){
			echo '<script type="text/javascript">
					window.open("'.site_url("fisio/fisiocdaftar/cetak_faktur/$no_fisio").'", "_blank");
					window.focus()
				</script>';
			redirect('fisio/fisiocdaftar/','refresh');

		}

		// echo '<script type="text/javascript">window.open("'.site_url("fisio/fisiocdaftar/cetak_faktur/$no_fisio").'", "_blank");window.focus()</script>';

		// redirect('lab/Labcdaftar/','refresh');
		
		//print_r($getvtotfisio);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_fisio='')
	{
		$this->fisiomdaftar->hapus_data_pemeriksaan($id_pemeriksaan_fisio);
        echo json_encode(array("status" => $id_pemeriksaan_fisio));
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		//$data['xuser']=$this->input->post('xuser');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->fisiomdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['lab']='1';
		
		$this->fisiomdaftar->insert_pasien_luar($data);
		
		redirect('fisio/fisiocdaftar/pemeriksaan_fisio/'.$data['no_register']);
		print_r($data);
	}

	public function cetak_faktur($no_fisio='')
	{
		$jumlah_vtot=$this->fisiomdaftar->get_vtot_no_fisio($no_fisio)->row()->vtot_no_fisio;
		if($no_fisio!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$header_pdf=$this->config->item('header_pdf');
			$data_pasien=$this->fisiomkwitansi->get_data_pasien($no_fisio)->row();
			$data_pemeriksaan=$this->fisiomkwitansi->get_data_pemeriksaan($no_fisio)->result();

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
					
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_pdf
					<hr/>
					<table>
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"78%\"></td>							
						</tr>
						<tr>
							<td align=\"center\" colspan=\"3\"><b>FAKTUR FISIOTERAPI  No. FISIO_$no_fisio</b></td>
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
						<tr>
							<td colspan=\"3\"><b>Terbilang : <i>".strtoupper($vtot_terbilang)."</i></b></td>
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
						  	<td><p align=\"right\">".number_format( $row->biaya_fisio, 0 , ',' , '.' )."</p></td>
						  	<td><p align=\"center\">$row->qty</p></td>
						  	<td><p align=\"right\">$vtot</P></td>
						</tr>";
						$i++;

					}

				$konten=$konten."
						<tr>
							<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 0 , ',' , '.' )."</p></th>
						</tr>";
					
				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
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
								<br>Fisioterapi
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>
					";
			
			// $file_name="FKTR_$no_fisio.pdf";
			$file_name="FKTR_FISIO_".$no_fisio."_".$data_pasien->nama.".pdf";
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
				$obj_pdf->Output(FCPATH.'download/fisio/fisiofaktur/'.$file_name, 'FI');
		}else{
			redirect('fisio/fisiocdaftar/','refresh');
		}
	}

	public function cetak_blanko($no_fisio='')
	{
		if($no_fisio!=''){
			$nr=$this->fisiomdaftar->get_row_register_by_nofisio($no_fisio)->result();
			foreach($nr as $row){
				$no_register=$row->no_register;
			}
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_jenis_lab=$this->fisiomdaftar->get_blanko_jenis_fisio($no_fisio)->result();
			$data_kategori_lab=$this->fisiomdaftar->get_blanko_kategori_fisio($no_fisio)->result();
			$nohptelp = "";$almt = "";

			$konten="
					
					<table  border=\"0\" style=\"padding-top:10px;padding-bottom:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\"><br>$namars
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:12px\">FISIOTERAPI</font></b><br><br>$alamatrs $kota_kab <br>$telp 
								<br>Email : fisioterapirsmc@gmail.com
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>

					<hr/><br/><br>
					<p align=\"center\"><b>
					BLANKO PEMERIKSAAN FISIOTERAPI
					</b></p><br/>";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->fisiomdaftar->get_data_pasien_luar_cetak($no_fisio)->row();
				$konten=$konten.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_fisio</td>
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
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
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
				$data_pasien=$this->fisiomdaftar->get_data_pasien_cetak($no_fisio)->row();
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
				$nm_poli=$this->fisiomdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if($data_pasien->cara_bayar=='BPJS'){
					$a=$this->fisiomdaftar->getcr_bayar_bpjs($data_pasien->no_register)->row();
					$cara_bayar= "$a->b";
				} else if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->fisiomdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)==RJ) {
					$nama_dokter=$this->fisiomdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)==RI) {
					$nama_dokter=$this->fisiomdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg." (".$data_pasien->bed.")";
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}
				$konten=$konten.
					"<table  border=\"0\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_fisio</td>
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
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
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
			$konten=$konten."
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
						$tindakan=strtoupper($rw->nama_jenis);
						$konten=$konten."
							<tr>
								<th colspan=\"4\"><p align=\"left\">
									<br/><b>$tindakan</b></p>
								</th>
							</tr>";
						foreach($data_jenis_lab as $row){
							if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) {
								$konten=$konten."
									<tr>
										<th colspan=\"4\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
									</tr>";
								$data_hasil_lab=$this->fisiomdaftar->get_blanko_hasil_lab($row->id_tindakan)->result();
								foreach($data_hasil_lab as $row1){
									$konten=$konten."<tr>
													  <td width=\"30%\">&nbsp;&nbsp;&nbsp;&nbsp;$row1->jenis_hasil</td>
													  <td width=\"35%\"><center></center></td>
													  <td width=\"15%\">$row1->satuan</td>
													  <td width=\"20%\">$row1->kadar_normal</td>
													</tr>";

								}
							}
						}
					}
					
				$konten=$konten."
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
			
			$file_name="Blanko_LAB_$no_fisio.pdf";
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
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/fisio/fisiopengisianhasil/'.$file_name, 'FI');
				
				// print_r($a);
		}else{
			redirect('fisio/fisiocdaftar/','refresh');
		}
	}
}