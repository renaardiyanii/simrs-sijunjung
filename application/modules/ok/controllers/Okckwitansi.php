 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include('Okcterbilang.php');
require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');

class Okckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('ok/okmdaftar','',TRUE);
		$this->load->model('ok/okmkwitansi','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		redirect('ok/okckwitansi/kwitansi','refresh');
	}
	

    public function dp_ok()
	{
	    $date=$this->input->post('date');
		$key=$this->input->post('key');	
		
		//	print_r($date);key();
		if(!empty($date)){		
		$data['title'] = 'DAFTAR PASIEN OK Tanggal | '.$date;
		$data['daftar_ok']=$this->okmkwitansi->get_list_dp($date)->result();
		}else if(!empty($key)){
		$data['title'] = 'DAFTAR PASIEN OK No Register | '.$key;	
        $data['daftar_ok']=$this->okmkwitansi->get_list_dp_by_key()->result();
		}else{
			$data['title'] = 'DAFTAR PASIEN OK Tanggal | '.date('d-m-Y');
			$data['daftar_ok']=$this->okmkwitansi->get_list_dp(date('Y-m-d'))->result();
		}
		
		$this->load->view('ok/okvuangmuka',$data);
	}

	public function kwitansi()
	{
		$data['title'] = 'Kwitansi OK';
		//$data['daftar_ok']=$this->okmdaftar->get_daftar_pasien_hasil_ok()->result();
		//$this->load->view('ok/okvdaftarpengisian',$data);
		$data['daftar_ok']=$this->okmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_ok'])==0){
			$this->session->set_flashdata('message_nodata','
					<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		$this->load->view('ok/okvkwitansi',$data);
	}


	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi OK';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_ok']=$this->okmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_ok'])==0){
				$this->session->set_flashdata('message_nodata','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak ada lagi data</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				// teste
				$this->session->set_flashdata('message_nodata','');
			}
			$this->load->view('ok/okvkwitansi',$data);
		}else{
			redirect('ok/okckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi OK';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_ok']=$this->okmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_ok'])==0){
				$this->session->set_flashdata('message_nodata','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak ada lagi data</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_nodata','');
			}
			$this->load->view('ok/okvkwitansi',$data);
		}else{
			redirect('ok/okckwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_ok='')
	{
		$data['title'] = 'Cetak Kwitansi OK';
		if($no_ok!=''){
			$data['no_ok']=$no_ok;
			$data['data_pasien']=$this->okmkwitansi->get_data_pasien($no_ok)->row();
			$data['data_pemeriksaan']=$this->okmkwitansi->get_data_pemeriksaan($no_ok)->result();
		//	print_r($data['data_pasien']);die();
			if(sizeof($data['data_pemeriksaan'])==0){
				$this->session->set_flashdata('message_no_tindakan','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_no_tindakan','');
			}
			
			$this->load->view('ok/okvkwitansipasien',$data);
		}else{
			redirect('ok/okckwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt()
	{
		$no_ok=$this->input->post('no_ok');
		$xuser=$this->input->post('xuser');
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->okmkwitansi->get_data_pasien($no_ok)->row();
		//	print_r($data_pasien);die();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		
		 $diskon=$this->input->post('diskon_hide');
		 $dp=$this->input->post('dp');

		 if($diskon==""){
			$diskon = 0;
		}

		if($dp==""){
			$dp = 0;
		}
	
		$tunai = $jumlah_vtot - $diskon;

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->okmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();

		if($no_ok!=''){
			$no_register=$this->okmdaftar->get_row_register_by_nook($no_ok)->row()->no_register;
		
			$this->okmkwitansi->update_status_cetak_kwitansi($no_ok, $diskon, $jumlah_vtot, $tunai, $no_register, $xuser);
					
				$cek_no_kwitansi = $this->okmkwitansi->get_no_kwitansi('OK');

				$kwitansi['no_register']=$no_register;
				if ($cek_no_kwitansi) {					
					$no_kwitansi=substr($cek_no_kwitansi->row()->no_kwitansi, 6)  + 1;
					$tahun = date('Y');
					$depan = substr($tahun,2,2);
					$kwitansi['no_kwitansi']='OK'.$depan.'-'.sprintf("%06d", $no_kwitansi);
					$datak['no_kwitansi']=intval(sprintf("%06d", $no_kwitansi));
					$kwitansi['referensi']=$no_ok;
					$kwitansi['vtot_bayar']=$jumlah_vtot;
				    $kwitansi['tunai']=$jumlah_vtot-$diskon;
				    $kwitansi['diskon']=$diskon;
				}else{
					$tahun = date('Y');
					$depan = substr($tahun,2,2);
					$kwitansi['no_kwitansi']='OK'.$depan.'-'.'000001';
					$datak['no_kwitansi']=000001;
				}
				$kwitansi['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$kwitansi['jenis_kwitansi']='OK';
				$kwitansi['user_cetak']=$xuser;
				$kwitansi['tgl_cetak']=date('Y-m-d H:i:s');
				$kwitansi['referensi']=$no_ok;
				$kwitansi['vtot_bayar']=$jumlah_vtot;
				$kwitansi['tunai']=$jumlah_vtot-$diskon;
				$kwitansi['diskon']=$diskon;
				$kwitansi['dp']=$dp;
		//		}
		//	print_r($kwitansi);die();
			$this->okmkwitansi->insert_no_kwitansi($kwitansi);



			$datak['idno_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
			$datak['xuser']=$xuser;
			$datak['xcreate']=date('Y-m-d H:i:s');
			$datak['no_register']=$no_register;
			$datak['nama_poli']='ADM';
			$datak['diskon']= $diskon;
			$datak['vtot_bayar']=$jumlah_vtot;
			$datak['tunai']=$jumlah_vtot-$diskon;
			$datak['dp']=$dp;
			$this->okmkwitansi->insert_nomorkwitansi($datak);

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			$no_trx = $this->rjmkwitansi->get_no_kwitansi_by_id((int)$kwitansi['idno_kwitansi'])->row();

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
			$datares['rm_no'] = $data_pasien->no_medrec;
			$datares['pasien_name'] = $data_pasien->nama;
			$datares['dob'] = $data_pasien->tgl_lahir;
			$datares['gender'] = $data_pasien->sex;
			$datares['gol_darah'] = $data_pasien->goldarah;
			$datares['jenis_pelayanan_id'] = 1;
			$datares['jenis_transaksi'] = 1;
			$datares['payment_tp'] = 2;
			$datares['component_id'] = $component_id;
			$datares['kode_unit_poli'] = $data_pasien->id_poli;
			$datares['nama_dokter'] = $data_pasien->nm_dokter;
			$datares['trx_no'] = $no_trx->no_kwitansi;
			$datares['paid_flag'] = 0;
			$datares['cancel_flag'] = 0;
			$datares['is_cancel'] = 0;
			$datares['payment_bill'] = (int)$kwitansi['vtot_bayar'];
			$datares['cancel_nominal'] = 0;
			$datares['retur_nominal'] = 0;
			$datares['retur_flag'] = 0;
			$datares['new_payment_bill'] = 0;
			$datares['additional1'] = 'Operasi';
			$datares['additional2'] = '0';
			$datares['additional3'] = '0';
	$this->rjmkwitansi->insert_registrasi($datares);

		//	print_r($no_ok.' '.$diskon.' '.$no_register.' '.$xuser);die();
			// echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("ok/okckwitansi/cetak_kwitansi_kt/$no_ok/".$kwitansi["no_kwitansi"]).'", "_blank");window.focus()</script>';
			
			redirect('ok/okckwitansi/kwitansi/','refresh');
		}else{
			redirect('ok/okckwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_ok='')
	{
		if($no_ok!=''){
			redirect('ok/okckwitansi/kwitansi/','refresh');
		}else{
			redirect('ok/okckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_ok='',$penyetors = '')
	{
		error_reporting(~E_ALL);
		$no_register=$this->okmdaftar->get_row_register_by_nook($no_ok)->row()->no_register;
		$no_kwitansi=$this->okmkwitansi->get_row_noKwitansi_by_register($no_register)->row()->no_kwitansi;
		$jumlah_vtot=$this->okmdaftar->get_vtot_no_ok($no_ok)->row()->vtot_no_ok;
		
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;

		if ($penyetors=="" || $penyetors == null) 
		{
			$datpasien=$this->okmkwitansi->get_data_pasien($no_ok)->row();
			$penyetor=$datpasien->nama;
			
		} else {
			$penyetor = $penyetors;
			
		}

		//	$jumlah_vtot=$this->okmdaftar->get_vtot_ok($no_ok)->row()->diskon;
		$diskon=$this->input->post('diskon_hide');
		$dp=$this->input->post('dp');

		if($diskon==""){
			$diskon = 0;
		}

		if($dp==""){
			$dp = 0;
		}
		//  $diskon=$this->okmdaftar->get_vtot_no_ok($no_ok)->row()->diskon;

		//   $dp=$this->okmdaftar->get_vtot_no_ok($no_ok)->row()->dp;
		
		$bayar = intval($jumlah_vtot)-$diskon-$dp;
		
		if($no_ok!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

		
			
			foreach($conf as $rowheader){
				$head_pdf =	$rowheader->value;
			}


			$data_pasien=$this->okmkwitansi->get_data_pasien($no_ok)->row();

			$data_pemeriksaan=$this->okmkwitansi->get_data_pemeriksaan($no_ok)->result();

			$cterbilang= new rjcterbilang();

			$tahun=0;
			$tahun_now = intval(date('Y'));
			$bulan=0;
			$hari=0;
			$tgl_lahir = intval($data_pasien->tgl_lahir); 
			$tahun= $tahun_now - intval($tgl_lahir);
			$bulan=($tgl_lahir - ($tahun*365))/30;
			$hari=$tgl_lahir - ($bulan * 30) - ($tahun * 365);
			
			$jumlah_vtot0=0;
			foreach($data_pemeriksaan as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}

			$vtot_terbilang=$cterbilang->terbilang($bayar);
			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);

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
					
					*{
						letter-spacing:1px;
					}
				
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
					$header_page
					<hr>
					<table border=\"0\">
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"78%\"></td>							
						</tr>
						<tr>
							<td align=\"center\" colspan=\"3\"><b>KWINTANSI OK No. ok_$no_ok</b></td>
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"32%\">$data_pasien->no_register</td>
							<td width=\"16%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"32%\">$data_pasien->nama</td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td>$data_pasien->no_cm</td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td>$tahun Tahun.</td>
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
							<td><b>Asal Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->ruang</td>
							<td><b>No Kwitansi</b></td>
							<td> : </td>
							<td>$no_kwitansi</td>
						</tr>
						<tr>
							<td><b>Sudah Terima Dari</b></td>
							<td> : </td>
							<td colspan=\"4\">".str_replace('%20', ' ', $penyetor)."</td>
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
						<th colspan=\"4\"><p align=\"right\"><b>DP   </b></p></th>
						<th><p align=\"right\">".number_format( $dp, 2 , ',' , '.' )."</p></th>
					</tr>
					<tr>
						<th colspan=\"4\"><p align=\"right\"><b>Diskon   </b></p></th>
						<th><p align=\"right\">".number_format( $diskon, 2 , ',' , '.' )."</p></th>
					</tr>
					<tr>
						<th colspan=\"4\"><p align=\"right\"><b>Total Bayar   </b></p></th>
						<th><p align=\"right\">".number_format( $bayar, 2 , ',' , '.' )."</p></th>
					</tr>";		
			$konten=$konten."
				</table>
				<br>
				<br>
				<table style=\"width:100%;\">
					<tr>
						<td width=\"20%\"><b>Terbilang</b></td>
						<td width=\"3%\"> : </td>
						<td width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>							
					</tr>
					<tr>
						<td width=\"75%\" >ASLI</td>
						<td width=\"25%\">
							<p align=\"center\">
							$kota_header, $tgl
							<br>$user
							</p>
						</td>
					</tr>	
				</table>
				";
			$konten=$konten."
					<tr>
						<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
						<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
					</tr>";		
			$konten=$konten."
				</table>
				<br>
				<br>
				<table style=\"width:100%;\">
					<tr>
						<td width=\"75%\" >COPY2</td>
						<td width=\"25%\">
							<p align=\"center\">
							$kota_header, $tgl
							<br>Kasir
							<br><br><br>$user
							</p>
						</td>
					</tr>	
				</table>
				";
			$konten=$konten."
					<tr>
						<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
						<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
					</tr>";		
			$konten=$konten."
				</table>
				<br>
				<br>
				<table style=\"width:100%;\">
					<tr>
						<td width=\"75%\" >COPY3</td>
						<td width=\"25%\">
							<p align=\"center\">
							$kota_header, $tgl
							<br>$user
							</p>
						</td>
					</tr>	
				</table>
				";
			$file_name="KW_OK_".$no_ok."_".$data_pasien->nama.".pdf";
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
				$obj_pdf->Output(FCPATH.'download/lab/labkwitansi/'.$file_name, 'FI');
		}else{
			redirect('ok/okcdaftar/','refresh');
		}
	}
	

}
?>