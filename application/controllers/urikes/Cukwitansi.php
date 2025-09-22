 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH.'controllers/irj/Rjcterbilang.php');

require_once(APPPATH.'controllers/Secure_area.php');
require_once(APPPATH.'helpers/tcpdf/tcpdf.php');
class MYPDF extends TCPDF {  
	//$this->load->helper('pdf_helper');
       // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-8);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
	date_default_timezone_set("Asia/Jakarta");			
	$tgl_jam = date("d-m-Y H:i:s");
        $this->Cell(0, 0, '', 0, false, 'L', 0, '', 0, false, 'T', 'M');    
	$this->Cell(0, 10, $this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');  
        }      
    }
class Cukwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('urikes/Muri_kwitansi','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		// $cterbilang=new rjcterbilang();
		// echo $cterbilang->terbilang(100);
		redirect('urikes/cukwitansi','refresh');
	}
	
	public function kwitansi_urikes()
	{
		$data['title'] = 'Kwitansi Pasien URIKKES';
		$date=$this->input->post('tgl');
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		if($date==''){
			$date=date('Y-m-d');
		}
		$data['pasien_daftar']=$this->Muri_kwitansi->get_pasien_kwitansi($date)->result();
		$data['url']= '1';
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>

					</div>');
		}
		*/
		$this->load->view('urikes/vuri_listkwitansi',$data);
	}
	

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Rawat Jalan';
		$data['url']='';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		//if($_SERVER['REQUEST_METHOD']=='POST'){
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['pasien_daftar']=$this->rjmkwitansi->get_pasien_kwitansi_by_date($date)->result();
			/*if(sizeof($data['pasien_daftar'])==0){
				$this->session->set_flashdata('message_nodata','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak ada lagi data</center>
								</div>
							  </div>
							</div>
						</div>');
			}
			*/
			$this->load->view('irj/rjvkwitansi',$data);
			
		} else {
			redirect('irj/rjckwitansi/kwitansi');
		}
			
		//}else{
		//	redirect('irj/rjckwitansi/kwitansi');
		//}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien


	public function kwitansi_pasien_detail($no_kode='',$id='')
	{
		$data['title'] = 'Cetak Kwitansi Pasien urikes';
		if($no_kode!=''){
			$data['no_kode']=$no_kode;
			$data['editnote']=$id;
			$data['data_pasien']=$this->Muri_kwitansi->getdata_pasien($id)->row();
			//$data['data_tindakan']=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			//$data['kontraktor']=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
			//$data['vtot']=$this->rjmkwitansi->get_vtot($no_register)->row();
			//$data['data_tindakan']=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			/*if(sizeof($data['data_tindakan'])==0){
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
				
			}*/
			
			// if (($data['vtot']->vtot=='0' && $data['vtot']->vtot_lab=='0'&& $data['vtot']->vtot_rad=='0' && $data['vtot']->vtot_obat=='0')==1) {
			// 	$this->session->set_flashdata('message_no_tindakan','tindakan_kosong');
			// }
			
			$this->load->view('urikes/vuri_kwitansipasienunpaid',$data);
		}else{
			redirect('urikes/Cukwitansi/kwitansi_detail');
		}
	}
	
	public function st_selesai_kwitansi_detail_kt($no_kode='',$id='')
	{
		if($no_kode!=''){
			
			$data_tindakan=$this->Muri_kwitansi->getdata_unpaid_tindakan_pasien($id)->result();
			$this->update_bayar($data_tindakan);
			redirect('urikes/cukwitansi/kwitansi_urikes/','refresh');
		}else{
			redirect('urikes/cukwitansi/kwitansi_urikes/','refresh');
		}
	}

	function update_bayar($data_tindakan)
	{
		date_default_timezone_set("Asia/Bangkok");
			
			$data1['tgl_cetak_kw']=date("Y-m-d H:i:s");
			
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data1['xcetak_kw']= $user;
			$data1['cetak_kwitansi']= 1;
			
		foreach($data_tindakan as $rows){
			$status=$this->Muri_kwitansi->update_status_kwitansi_detail_kt($rows->idurikes,$data1);
		}
	}
	public function st_cetak_kwitansi_detail_kt()
	{
		$no_kode=$this->input->post('no_register');
		$idurikes=$this->input->post('idurikes');
		if($no_kode!=''){

		

		$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
		$data9['id_loket']=$kasir->kasir;
		$nomor=$this->Muri_kwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
		$data9['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data9['xuser']=$user;
		$data9['xcreate']=date('Y-m-d H:i:s');
		$data9['no_register']=$no_kode;
		$data9['editnote']=$idurikes;
		$data9['nama_poli']='urikes';
		$cek=$this->Muri_kwitansi->insert_nokwitansi($data9);
		$pilih=$this->input->post('pilih');
		$data2['cetak_kwitansi']=1;
		$data2['xcetak_kw']=$user;
		$data2['tgl_cetak_kw']=date('Y-m-d H:i:s');
		$status=$this->Muri_kwitansi->update_status_kwitansi_detail_kt($idurikes,$data2);

		

		$data10['tunai']='0';$data10['no_kk']='0';$data10['nilai_kkd']='0';$data10['persen_kk']='0';$data10['diskon']='0';
		$this->Muri_kwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data10);

		$data['pasien_bayar']='1';

	
		
		if($this->input->post('notedisc_hide')){
			$data['diskonnote']=$this->input->post('notedisc_hide');
		}

		$data_pasien=$this->Muri_kwitansi->getdata_pasien($idurikes)->row();
		$data['vtot_bayar']=0;
		if($this->input->post('nilai_tunai')){
			$data['tunai']=$this->input->post('nilai_tunai');
			$data['vtot_bayar']=(int)$data['vtot_bayar']+(int)$data['tunai'];
		}
		if($this->input->post('no_kartuk')!=''){
			$data['no_kk']=$this->input->post('no_kk');
		}
		if($this->input->post('nilai_kk')!=''){
			$data['nilai_kkd']=$this->input->post('nilai_kk');
			$data['vtot_bayar']=(int)$data['vtot_bayar']+(int)$data['nilai_kkd'];
		}
		if($this->input->post('charge_rate')!=''){
			$data['persen_kk']=$this->input->post('charge_rate');
		}
		if ($this->input->post('diskon_hide')!='') 
		{	
			$data['diskon']=(int)$this->input->post('diskon_hide');
			$data['tunai']=(int)$this->input->post('nilai_tunai');		
		} else 
			$data['diskon']='0';

		if($this->input->post('totfinal_hide')!=''){
			$totakhir=$this->input->post('totakhir');
		}

		if($this->input->post('pilih')!='detail'){			
			if ($this->input->post('penyetor')=="") 
			{
				$penyetor=$data_pasien->nama;
			} else {
				$penyetor=$this->input->post('penyetor');
			}
			$txtpilih='document.cookie = "pilih=0";';
		}else{
			
			//if (empty($this->input->post('penyetor_hide'))==1) 
			if (!($this->input->post('penyetor_hide'))==1) 
			{
				$penyetor=$data_pasien->nama;
				
			} else {
				$penyetor=$this->input->post('penyetor_hide');
			}
			$txtpilih='document.cookie = "pilih='.$pilih.'";';
			
		}
			$this->Muri_kwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);
			$tunai=$data['tunai'];
			//$this->Muri_kwitansi->update_counter_kwitansi($no_kode);
			
			//cetak kw.pdf
			//echo $tunai;
			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; document.cookie = "tunai='.$tunai.'"; document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' window.open("'.site_url("urikes/cukwitansi/cetak_kwitansi_detail_kt/$no_kode/$idurikes").'", "_blank");window.focus()</script>';
			// //$txtpil='document.cookie = "pil=detail";';
			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
			
			redirect('urikes/cukwitansi/kwitansi_urikes/','refresh');			
		}
		else{
			redirect('urikes/cukwitansi/kwitansi_urikes/','refresh');
		}
	}

public function cetak_kwitansi_detail_kt($no_kode='',$idurikes='')
	{
		$penyetor =  $_COOKIE['penyetor'];
		$nokwitansi =  $_COOKIE['no_kwitansi'];
		$idloket =  $_COOKIE['id_loket'];
		
		$pilih='0';

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_kode!=''){
			$cterbilang=new rjcterbilang();
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->Muri_kwitansi->getdata_pasien($idurikes)->row();
			$data_kwitansi=$this->Muri_kwitansi->getdata_nomor_kwitansi($nokwitansi,$idloket)->row();
			//$detail_daful=$this->Muri_kwitansi->get_detail_daful($no_register)->row();
			
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			// $detail_bayar=$detail_daful->cara_bayar;
			
			$diskon=$data_kwitansi->diskon;
			$persen=$data_kwitansi->persen_kk;
			$tunai=$data_kwitansi->tunai;
			$nilaikk=$data_kwitansi->nilai_kkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			$txtjudul="";
			$style='';			
			$konten1='';
			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:9px;
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
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam<br>
							 </font></td>
							</tr>
							
						  
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN 
								No. ".$idloket."".$nokwitansi."
								</b></u></font></td>
							</tr>	
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_daftar))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No NRP/NIP</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->nip)."</td>
							</tr>
							
							
							<tr>
							<td></td>
							<td></td>
							<td></td>
							</tr>																	
					</table>
					</br>";
		//$pilih='';													
		}
		if($pilih!=''){	
				
			// $data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			// 
			
			$data_tindakan=$this->Muri_kwitansi->getdata_unpaid_tindakan_pasien($idurikes)->result();
			
			$no=1;
			//print_r($data_tindakan);

			if($diskon!='' and $diskon!='0'){
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:9px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:9px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:9px;\">".number_format($nilaikk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:9px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:9px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:9px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:9px; \"><p align=\"right\" style=\"font-size:9px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nilaikk+$tunai_bulat, 2 , ',' , '.' )."</p></td>
					</tr>";

			}

			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nilaikk+$tunai;//-$diskon;
					$jumlah_vtot1=$nilaikk+$tunai;
					
			}
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $diskon." ".$nominal_kk." ".$tunai;
			//echo $jumlah_vtot;
			//break;
				if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
									
					$totalbayar="<tr >						
							<td width=\"50%\" ><p  style=\"font-size:9px;  margin:0;\">Total</p></td>
							<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
							<td width=\"40%\" style=\"font-size:9px; \"><p align=\"right\" style=\"font-size:9px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
				}

			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Bagian</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";
						

				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
				$vtot=0;
				
				foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->vtot_bayar;
						$konten=$konten."
						<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->jenis))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot_bayar, 2 , ',' , '.' )."</p></td>
						</tr>";
					
					
					}

				
			 $konten1=$konten."<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table><br/><br/>
					<table  >										
					
						$txtdiskon	
						$txttunai
						$txtkk				
						$totalbayar

					</table>
					<tr>
								<td width=\"17%\"><p style=\"font-size:9px;\"><b>Terbilang</b></p></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><p style=\"font-size:9px;\"><i>".strtoupper($vtot_terbilang)."</i></p></td>
							</tr>";

			$konten=$konten."
						
				
					<table style=\"border:1px solid black; width:100%;\">
															
					$txtdiskon	
					$txttunai
					$txtkk		
					$totalbayar
					
					</table>
					";

			$konten1=$konten1."

					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Kasir Rumah Sakit
								<br><br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			echo $konten;			
				$file_name="URIKES_KW_$no_kode.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$width = 140;
				$height = 216;
				$pageLayout = array($width, $height);			
				$obj_pdf = new MYPDF('L', PDF_UNIT, $pageLayout, true, 'UTF-8', false);				
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
				//1
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->SetXY( 20, 131 );
				$obj_pdf->cell(1,1,'Lembar Pertama untuk Pasien', 0, 0, 'L');
				$obj_pdf->AddPage();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->SetXY( 20, 131 );
				$obj_pdf->cell(1,1,'Lembar Kedua untuk Urikes', 0, 0, 'L');
				$obj_pdf->AddPage();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->SetXY( 20, 131 );
				$obj_pdf->cell(1,1,'Lembar Ketiga untuk Arsip Kasir', 0, 0, 'L');
				
				$obj_pdf->Output(FCPATH.'/download/irj/rjkwitansi/'.$file_name, 'FI');
				
				
		}
		else{
			redirect('irj/rjckwitansi/kwitansi_detail/','refresh');
		}
	}

	













//////////////////////////////////////////////////////////////////urikes










	

	public function st_cetak_kwitansi_retur_kt()
	{
		$no_register=$this->input->post('no_register');

		$pilih=$this->input->post('pilih');

		//$data['tunai']='0';$data['no_kkkd']='0';$data['nilai_kkkd']='0';$data['persen_kk']='0';$data['diskon']='0';
		//$this->rjmkwitansi->update_pembayaran($no_register,$data);
		if($no_register!=''){

			$data['pasien_bayar']=$this->input->post('jenis_bayar_hide');

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			$myArray = [];
			if($this->input->post('idtindakanretur_hide')){
				$idtindakanretur=$this->input->post('idtindakanretur_hide');
				$myArray = explode(',', $idtindakanretur);
			}
			if($this->input->post('retur_hide')){
				//$data['vtot_retur']=$this->input->post('retur_hide');
				$data['vtot_bayar']=$this->input->post('totfinal_hide');
				$data['retur']=1;
			}
			if($this->input->post('nilai_tunai')){
				$data['tunai']=$this->input->post('nilai_tunai');
			}
			if($this->input->post('no_kartuk')!=''){
				$data['no_kkkd']=$this->input->post('no_kartuk');
			}
			if($this->input->post('nilai_kk')!=''){
				$data['nilai_kkkd']=$this->input->post('nilai_kk');
			}
			if($this->input->post('charge_rate')!=''){
				$data['persen_kk']=$this->input->post('charge_rate');
			}
			if ($this->input->post('diskon_hide')!='') 
			{	
				$data['diskon']=$this->input->post('diskon_hide');
				//$data['tunai']=(int)$data_pasien->vtot-(int)$data['diskon']; 		
			} else 
				$data['diskon']='0';

			if($this->input->post('totfinal_hide')!=''){
				$totakhir=$this->input->post('totakhir');
			}

			if($this->input->post('pilih')!='detail'){			
				if ($this->input->post('pasien_retur')=="") 
				{
					$penyetor=$data_pasien->nama;
				} else {
					$penyetor=$this->input->post('pasien_retur');
				}
				$txtpilih='document.cookie = "pilih=0";';
			}else{
				
				//if (empty($this->input->post('penyetor_hide'))==1) 
				if (!($this->input->post('penyetor_hide'))==1) 
				{
					$penyetor=$data_pasien->nama;
					
				} else {
					$penyetor=$this->input->post('penyetor_hide');
				}
				$txtpilih='document.cookie = "pilih='.$pilih.'";';	
			}
	//		print_r($data);		
			//$this->rjmkwitansi->update_pembayaran_detail($no_register,$data);
			$this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);
			//ubah status
			//$data['cetak_kwitansi']=1;
			//print_r($txtpilih);
			//set timezone
			// date_default_timezone_set("Asia/Bangkok");
			// $data1['bayar']=1;
			// $data1['tgl_cetak_kw']=date("Y-m-d H:i:s");
			
			// $login_data = $this->load->get_var("user_info");
			// $user = $login_data->username;
			// $data1['xcetak']= $user;
			// $tunai = 0;
			// $data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			// foreach($data_tindakan as $rows){
			// 	$tunai = $tunai+$rows->biaya_tindakan;
			// 	$status=$this->rjmkwitansi->update_status_kwitansi_detail_kt($rows->id_pelayanan_poli,$data1);
			// }

			$sizetind=$this->input->post('tot_tind_hide');
			for($i=0;$i<sizeof($myArray);$i++){
				//$data4['id_pelayanan_poli']=$myArray[$i];
				$data4['retur']=1;
				//echo $myArray[$i].",";
				$this->rjmkwitansi->update_status_kwitansi_detail_kt($myArray[$i],$data4);
			}
			//counter kwitansi
			$this->rjmkwitansi->update_counter_kwitansi($no_register);

			if($sizetind==sizeof($myArray)){
				$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success">Kwitansi Berhasil Diretur</h3>
                       		</div>';
				$this->session->set_flashdata('message_cetak', $success);
			}else{
				$data['xupdate']=date('Y-m-d H:i:s');
				$data['pasien_bayar']=$this->input->post('jenis_bayar_hide');

				$kasir=$this->M_user->get_role_aksesOne($this->session->userdata('userid'))->row();
				$data9['id_loket']=$kasir->kasir;
				$nomor=$this->rjmkwitansi->get_no_kwitansi_loket($data9['id_loket'])->row();
				$data9['no_kwitansi']=sprintf("%08d",($nomor->no_kwitansi+1));
				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
				$data9['xuser']=$user;
				$data9['xcreate']=date('Y-m-d H:i:s');
				$data9['no_register']=$no_register;
				$data9['nama_poli']='ADM';
				$cek=$this->rjmkwitansi->insert_nokwitansi($data9);

				echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; document.cookie = "tunai='.$tunai.'"; document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' window.open("'.site_url("irj/rjckwitansi/cetak_kwitansi_detail_kt/$no_register").'", "_blank");window.focus()</script>';
			}
			
			//$tunai=$data['tunai'];
			//cetak kw.pdf
			//echo $tunai;
			
			// //$txtpil='document.cookie = "pil=detail";';
			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
			redirect('irj/rjckwitansi/list_lunas/','refresh');			
		}else{
			redirect('irj/rjckwitansi/list_lunas/','refresh');
		}
	}

	public function st_cetak_kwitansi_batal_kt()
	{
		$no_register=$this->input->post('no_register');

		$pilih=$this->input->post('pilih');

		if($no_register!=''){

			$id_kwitansi=$this->input->post('id_kwitansi_old_hide');

			if($this->input->post('note_hide')){
				$data10['editnote']=$this->input->post('note_hide');
			}

			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);

			$data10['batal']='1'; $data10['xbatal']=$user; $data10['xupdate']=date('Y-m-d H:i:s');
			$this->rjmkwitansi->update_pembayaran_idkwitansi($id_kwitansi,$data10);

			//print_r($data);	
			//$data['ket_pulang']=='BATAL_PELAYANAN_POLI';
			//$data['ket_pulang']=='BATAL_PELAYANAN_POLI';
			//$id=$this->rjmpelayanan->batal_pelayanan_poli($no_register);
			//$this->rjmkwitansi->update_pembayaran_detail($no_register,$data);
			//ubah status
			//$data['cetak_kwitansi']=1;
			//print_r($txtpilih);
			//set timezone
			// date_default_timezone_set("Asia/Bangkok");
			// $data1['bayar']=1;
			// $data1['tgl_cetak_kw']=date("Y-m-d H:i:s");
			
			// $login_data = $this->load->get_var("user_info");
			// $user = $login_data->username;
			// $data1['xcetak']= $user;
			// $tunai = 0;
			// $data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			// foreach($data_tindakan as $rows){
			// 	$tunai = $tunai+$rows->biaya_tindakan;
			// 	$status=$this->rjmkwitansi->update_status_kwitansi_detail_kt($rows->id_pelayanan_poli,$data1);
			// }
			
			$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success">Kwitansi Berhasil Dibatalkan</h3>
                       		</div>';
			$this->session->set_flashdata('message_cetak', $success);
			//for($i=0;$i<sizeof($myArray);$i++){
				//$data4['id_pelayanan_poli']=$myArray[$i];
				//$data4['baya']=1;
				//echo $myArray[$i].",";
			//	$this->rjmkwitansi->update_status_kwitansi_detail_kt($myArray[$i],$data4);
			//}
			//counter kwitansi
			//$this->rjmkwitansi->update_counter_kwitansi($no_register);
			//$tunai=$data['tunai'];
			//cetak kw.pdf
			//echo $tunai;
			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; document.cookie = "tunai='.$tunai.'";'.$txtpilih.' window.open("'.site_url("irj/rjckwitansi/cetak_kwitansi_detail_kt/$no_register").'", "_blank");window.focus()</script>';
			// //$txtpil='document.cookie = "pil=detail";';
			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
			redirect('irj/rjckwitansi/list_lunas/','refresh');			
		}else{
			redirect('irj/rjckwitansi/list_lunas/','refresh');
		}
	}

	// public function st_cetak_kwitansi_kt()
	// {
	// 	$no_register=$this->input->post('no_register');
		
	// 	if($no_register!=''){

	// 	$data_pasien=$this->Muri_kwitansi->getdata_pasien($no_register)->row();
		
	// 	// $data['vtot_bayar']=0;
	// 	if($this->input->post('nilai_tunai')){
	// 		$data['tunai']=$this->input->post('nilai_tunai');
	// 		$data['total_bayar']=(int)$data['total_bayar']+(int)$data['tunai'];
	// 	}
	// 	if($this->input->post('no_kartuk')!=''){
	// 		$data['no_kk']=$this->input->post('no_kk');
	// 	}
	// 	if($this->input->post('nilai_kk')!=''){
	// 		$data['nilai_kkd']=$this->input->post('nilai_kk');
	// 		$data['total_bayar']=(int)$data['total_bayar']+(int)$data['nilai_kkd'];
	// 	}
	// 	if($this->input->post('charge_rate')!=''){
	// 		$data['persen_kk']=$this->input->post('charge_rate');
	// 	}
	// 	if ($this->input->post('diskon_hide')!='') 
	// 	{	
	// 		$data['diskon']=(int)$this->input->post('diskon_hide');
	// 		$data['tunai']=(int)$this->input->post('nilai_tunai');		
	// 	} else 
	// 		$data['diskon']='0';

	// 	if($this->input->post('totfinal_hide')!=''){
	// 		$totakhir=$this->input->post('totakhir');
	// 	}
		
	// 	//print_r($data);
	// 	// $this->rjmkwitansi->update_pembayaran_nokwitansi($data9['no_kwitansi'],$data);
	// 	//$this->rjmkwitansi->update_pembayaran($no_register,$data);
	// 		//ubah status
	// 		$data['cetak_kwitansi']=1;
	// 		//print_r($txtpilih);
	// 		//set timezone
	// 		date_default_timezone_set("Asia/Bangkok");
	// 		$data['tgl_cetak_kw']=date("Y-m-d H:i:s");

	// 		$login_data = $this->load->get_var("user_info");
	// 		$user = $login_data->username;
	// 		$data['xcetak_kw']= $user;

	// 		//$status=$this->rjmkwitansi->update_status_kwitansi_kt($no_register,$data);
	// 		//cetak kw.pdf
			
	// 		//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpilih.' window.open("'.site_url("irj/rjckwitansi/cetak_kwitansi_kt/$no_register").'", "_blank");window.focus()</script>';
	// 		$txtpil='document.cookie = "pil=detail";';

	// 		// $data_tindakan=$this->Muri_kwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
	// 		// $noncover=0;
	// 		// foreach($data_tindakan as $row1){
				
	// 		// 	if(($row1->noncover)>0){
	// 		// 		$noncover=1;
	// 		// 	}
	// 		// }

	// 		/*if(($noncover==1 && $data_pasien->cara_bayar=='BPJS') || $data_pasien->cara_bayar=='UMUM'){
	// 			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kw0_kt/$no_register").'", "_blank");window.focus()</script>';
	// 		}
	// 		if($data_pasien->cara_bayar=='BPJS'){*/
	// 			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kw_kt/$no_register").'", "_blank");window.focus()</script>';

	// 			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kw5_kt/$no_register").'", "_blank");window.focus()</script>';
	// 		//}
			
			
	// 		if($this->input->post('pilih')=='detail'){
	// 			redirect('urikes/Cukwitansi/kwitansi_urikes/'.$no_register,'refresh');
	// 		}else{
	// 			redirect('urikes/Cukwitansi/kwitansi_urikes/','refresh');
	// 		}
	// 	}else{
	// 		redirect('irj/rjckwitansi/kwitansi/','refresh');
	// 	}
	// }




	public function st_selesai_kwitansi_kt($no_register='')
	{
		if($no_register!=''){
			
			//ubah status
			$data['cetak_kwitansi']=1;
			date_default_timezone_set("Asia/Bangkok");
			$data['tgl_cetak_kw']=date("Y-m-d H:i:s");
			$status=$this->rjmkwitansi->update_status_kwitansi_kt($no_register,$data);
			
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}

	//$this->update_bayar($data_tindakan);
	
	public function cetak_kwitansi_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pilih'];
		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->Rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>$detail_daful->id_kontraktor - ".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$jumlah_vtot =  $vtot->vtot + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat + $vtot->vtot_pa;		

			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;
			$txtdiskon='';

			if($pilih==''){
				$txtjudul="<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN<br/>
					No. KW. $no_register</b></u></font></td>
						</tr>";
			}else
				$txtjudul="<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>FAKTUR RAWAT JALAN<br/>
					No. $no_register</b></u></font></td>
						</tr>";
			if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($nominal_kk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nominal_kk+$tunai_bulat+$diskon, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}
			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nominal_kk+$tunai+$diskon;
					
			}

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			
			
			$style='';
			if($txttunai!='' or $txtkk!='' or $txtdiskon!='')
			{
				$style="border-top: 1pt solid black;";
			}

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"30%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p>$namars</td>
						<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"> </td>
						<td width=\"5%\"></td>						
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td></td><td colspan=\"q\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					
					<table >
						<tr>							
							<td></td>
						</tr>			
						$txtjudul	<br>		
							<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>			
							<tr>
								<td><b>Untuk Pemeriksaan</b></td>
								<td> : </td>
								<td><i>Untuk Pembayaran Pemeriksaan, Tindakan dan pengobatan Rawat Jalan sesuai nota terlampir</i></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"37%\">".strtoupper($data_pasien->nama)."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td> : </td>
								<td>".$detail_daful->umurrj." TAHUN</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->alamat)."</td>
							</tr>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								$txtperusahaan
							</tr>
							
							
							
							
					</table><br/><br/>";
					
					
		
	
				$konten1=$konten;
				$konten1=$konten1."
						
					<br/>
					<table style=\"border:1px solid black; width:100%;\">
						
					$txtdiskon	
					$txttunai
					$txtkk				
					$totalbayar
					
					</table>
					";

		
			$konten1=$konten1."
					<p align=\"right\">$kota_kab, $tgl<br>An. Kasir Rumah Sakit<br>K a s i r &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br>$user&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
			//echo $konten1;
			$file_name="KW_$no_register.pdf";
			if($pilih!=''){
				$file_name="IRJ_$no_register.pdf";
			}
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				if($pilih==''){
					$obj_pdf = new MYPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				}else{
					$obj_pdf = new MYPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
				}
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(true);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				if($detail_bayar!='UMUM' and $pilih==''){
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten1;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');				
				}
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
				$data['cetak_kwitansi']='1';
				//echo $vtot->vtot_lab!='';
				if($vtot->vtot_lab!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_laboratorium');
				}
				if($vtot->vtot_rad!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_radiologi');
				}
				if($vtot->vtot_obat!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'resep_pasien');
				}
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_faktur_kw_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pil'];
		$idloket =  $_COOKIE['id_loket'];
		$nokwitansi =  $_COOKIE['no_kwitansi'];
		$data_kwitansi=$this->rjmkwitansi->getdata_nomor_kwitansi($nokwitansi,$idloket)->row();

		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			/*$diskon=$detail_daful->diskon2;
			$persen=$detail_daful->persen_kk2;
			$tunai=$detail_daful->tunai2;
			$nilaikk=$detail_daful->nilai_kkkd2;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;*/
			$diskon=$data_kwitansi->diskon;
			$persen=$data_kwitansi->persen_kk;
			$tunai=$data_kwitansi->tunai;
			$nilaikk=$data_kwitansi->nilai_kkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			$vtottind=0;
			//$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			if($data_pasien->cara_bayar=='UMUM'){
				$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasienumum($no_register)->result();
			}else{
				$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			}
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtottind=$vtottind+$row1->biaya_tindakan;
			}
			
			//print_r($detail_daful);
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			/*$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
			$vtottind=0;
			foreach($data_tindakan as $row1){
				if($row1->bpjs=='1'){
					$vtottind=$vtottind+$row1->vtot;
				}
			}*/
			
			if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($nilaikk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nilaikk+$tunai_bulat, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}
			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nilaikk+$tunai;
					
			}

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			if($data_pasien->cara_bayar!='UMUM'){
				$jumlah_vtot =  $vtottind + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat + $vtot->vtot_pa + $vtot->vtot_ok;
			}/*else
				$jumlah_vtot =  $vtottind;*/
						
								
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			

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
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN 
								No. ".$idloket."".$nokwitansi."</b></u></font></td>
							</tr>	
							<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								
								$txtperusahaan
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan=\"3\">".strtoupper($detail_daful->nm_poli)."</td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($detail_daful->nm_dokter)."</td>
							</tr>											
							</table>
							<br/><br/>";
															
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

				$no=1;
				foreach($data_tindakan as $row1){
					//if($row1->bpjs=='1'){
						$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					//}
					
				}

				

			if($data_pasien->cara_bayar!='UMUM')
			{
				$data_lab=$this->ModelKwitansi->getdata_lab_pasien($no_register)->result();
				$data_pa=$this->ModelKwitansi->getdata_pa_pasien($no_register)->result();
				$data_rad=$this->ModelKwitansi->getdata_rad_pasien($no_register)->result();
				$data_resep=$this->ModelKwitansi->getdata_resep_pasien($no_register)->result();
				$data_ok=$this->ModelKwitansi->getdata_ok_pasien($no_register)->result();
				//print_r($data_tindakan);
				

				// $konten=$konten."	<tr>
				// 				<td><p align=\"center\">2</p></td>
				// 				<td><b>LABORATORIUM</b></td>
				// 				<td></td>
				// 				<td><p align=\"right\">".number_format( $vtot->vtot_lab, 2 , ',' , '.' )."</p></td>
				// 			</tr>";
				
					foreach($data_lab as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(lab) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
				// $konten=$konten."	<tr>

				// 				<td><p align=\"center\">2</p></td>
				// 				<td><b>PATOLOGI ANATOMI</b></td>
				// 				<td></td>

				// 				<td><p align=\"right\">".number_format( $vtot->vtot_pa, 2 , ',' , '.' )."</p></td>

				// 			</tr>";
				
					foreach($data_pa as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(pa) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>

							</tr>";
						}
				// $konten=$konten."	<tr>
				// 				<td><p align=\"center\">3</p></td>
				// 				<td><b>RADIOLOGI</b></td>
				// 				<td></td>
				// 				<td><p align=\"right\">".number_format( $vtot->vtot_rad, 2 , ',' , '.' )."</p></td>
				// 			</tr>";
				foreach($data_rad as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(rad) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
				// $konten=$konten."	<tr>
				// 				<td><p align=\"center\">4</p></td>
				// 				<td><b>OBAT</b></td>
				// 				<td></td>
				// 				<td><p align=\"right\">".number_format( $vtot->vtot_obat, 2 , ',' , '.' )."</p></td>
				// 			</tr>
				// 			";
				foreach($data_resep as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(frm) ".ucwords(strtolower($row1->nama_obat))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
				// $konten=$konten."	<tr>
				// 				<td><p align=\"center\">6</p></td>
				// 				<td><b>Operasi</b></td>
				// 				<td></td>
				// 				<td><p align=\"right\">".number_format( $vtot->vtot_ok, 2 , ',' , '.' )."</p></td>
				// 			</tr>
				// 			";
				foreach($data_ok as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(ok) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
				}
				
				

			
			
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table  >
					$txttunai
					$txtkk	
					$txtdiskon
					$totalbayar									
					<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>
					</table>";
			
			

			$konten=$konten."
						
					<br/>
					
					";

			/*<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>*/
			
			$konten=$konten."
					
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Kasir Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			//echo $konten;			
				$file_name="IRJ_faktur_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
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
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
				if(!file_exists(FCPATH.'download/irj/rjkwitansi/'.$file_name)){
					$this->session->set_flashdata('message_cetak','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Gagal Mencetak Kwitansi</center>
								</div>
							  </div>
							</div>
						</div>');
				    redirect('irj/rjckwitansi/kwitansi/','refresh');
				}
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_faktur_kw0_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pil'];
		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			$vtot_terbilang=$cterbilang->terbilang($tunai);
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			//$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
			$data_ok=$this->ModelKwitansi->getdata_ok_pasien($no_register)->result();
			$vtottind=0;
			foreach($data_tindakan as $row1){
				if($row1->bpjs==0){
					$vtottind=$vtottind+$row1->vtot;
				}				
			}
				$jumlah_vtot =  $vtottind;
						
			
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			

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
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>TUNAI</u></b></p></td></tr>
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN 
								No. $no_register</b></u></font></td>
							</tr>	
							<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								
								$txtperusahaan
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan=\"3\">".strtoupper($detail_daful->nm_poli)."</td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($detail_daful->nm_dokter)."</td>
							</tr>											
							</table>
							<br/><br/>";
															
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

				$no=1;
				foreach($data_tindakan as $row1){
					if($row1->bpjs==0){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>".ucwords(strtolower($row1->nmtindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
					}
				}			
				foreach($data_ok as $row1){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(ok) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}				
				if($diskon>0 && $data_pasien->cara_bayar=='UMUM'){
					$txtdiskon="<tr>
									<td width=\"17%\"><b>Diskon</b></td>
									<td width=\"2%\"> : </td>
									<td  width=\"78%\"><i>".number_format( $diskon, 2 , ',' , '.' )."</i></td>
								</tr>";
					}else $txtdiskon="";
					if($tunai>0 && $data_pasien->cara_bayar=='UMUM'){
						$txttunai="<tr>
										<td width=\"17%\"><b>Jumlah Yang Dibayar</b></td>
										<td width=\"2%\"> : </td>
										<td  width=\"78%\"><i>".number_format($tunai, 2 , ',' , '.' )."</i></td>
									</tr>";
						$vtot_terbilang=$cterbilang->terbilang($tunai);
					}else {
						if($data_pasien->cara_bayar=='BPJS'){
							$txttunai=''; $vtot_terbilang=$cterbilang->terbilang($diskon);
						}
						else{
							$txttunai=''; $vtot_terbilang='Nol Rupiah';
						}
					}
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table  >
					$txtdiskon	
					$txttunai									
					<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>
					</table>";
			
			

			$konten=$konten."
						
					<br/>
					
					";

			/*<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>*/
			
			$konten=$konten."
					
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			//echo $konten;			
				$file_name="IRJ0_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
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
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
				if(file_exists(FCPATH.'download/irj/rjkwitansi/'.$file_name)){

				}else{
					
				}
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_faktur_kw5_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pil'];
		$idloket =  $_COOKIE['id_loket'];
		$nokwitansi =  $_COOKIE['no_kwitansi'];

		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
		
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			$data_kwitansi=$this->rjmkwitansi->getdata_detail_kwitansi($no_register)->result();
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;

			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=''; $tunai=''; $nilaikk=''; $nominal_kk='';
			foreach($data_kwitansi as $row2){
				$diskon+=(int)$row2->diskon;
				$tunai+=(int)$row2->tunai;
				$nilaikk+=(int)$row2->nilai_kkd;			
				$nominal_kk+=($row2->persen_kk/100*$nilaikk+$nilaikk);	
			}
			$vtot_terbilang=$cterbilang->terbilang($tunai);
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			//$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$data_ok=$this->ModelKwitansi->getdata_ok_pasien($no_register)->result();
			$vtottind=0;
			/*foreach($data_tindakan as $row1){
				//if($row1->bpjs==0){
					$vtottind=$vtottind+$row1->vtot;
				//}				
			}
				$jumlah_vtot =  $vtottind;*/

			$txtjudul="";			
			
			$style='';			

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
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>TUNAI</u></b></p></td></tr>
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>FAKTUR RAWAT JALAN 
								NoReg ".$no_register."</b></u></font></td>
							</tr>	
							<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								
								$txtperusahaan
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan=\"3\">".strtoupper($detail_daful->nm_poli)."</td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($detail_daful->nm_dokter)."</td>
							</tr>											
							</table>
							<br/><br/>";
															
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

				$no=1;
				foreach($data_tindakan as $row1){
					$vtottind=$vtottind+$row1->vtot;
					//if($row1->bpjs==0){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>".ucwords(strtolower($row1->nmtindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
					//}
				}			
				foreach($data_ok as $row1){
					$vtottind=$vtottind+$row1->vtot;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(ok) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}				
				if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:9px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:10px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:9px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:10px;\">".number_format( $diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:10px;\">".number_format($nominal_kk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:10px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:9px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:10px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:9px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:10px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nominal_kk+$tunai_bulat, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nilaikk+$tunai;
					$jumlah_vtot1=$nilaikk+$tunai;
					
			}

			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:9px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:9px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:9px; \"><p align=\"right\" style=\"font-size:10px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $vtottind, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table  >
					$txtdiskon
					$txtkk	
					$txttunai	
					$totalbayar							
					<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>
					</table>";
			
			

			$konten=$konten."
						
					<br/>
					<br/>
					<br/>
					";

			/*<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>*/
			
			$konten=$konten."
					
					<table style=\"width:100%;\">
						<tr>
							<td width=\"60%\" ></td>
							<td width=\"40%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Kasir Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			//echo $konten;			
				$file_name="Faktur_IRJ_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);				
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
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
				if(!file_exists(FCPATH.'download/irj/rjkwitansi/'.$file_name)){
					$this->session->set_flashdata('message_cetak','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Gagal Mencetak Kwitansi</center>
								</div>
							  </div>
							</div>
						</div>');
				    redirect('irj/rjckwitansi/kwitansi/','refresh');
				}
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_faktur_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pil'];
		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtottind=0;
			foreach($data_tindakan as $row1){
				$vtottind=$vtottind+$row1->vtot;
			}
			$jumlah_vtot =  $vtottind + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat + $vtot->vtot_pa;
						
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			

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
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN 
								No. $no_register</b></u></font></td>
							</tr>	
							<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								<td></td>
								<td></td>
								$txtperusahaan
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan=\"3\">".strtoupper($detail_daful->nm_poli)."</td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($detail_daful->nm_dokter)."</td>
							</tr>											
							</table>
							<br/><br/>";
															
		
				
			$data_lab=$this->ModelKwitansi->getdata_lab_pasien($no_register)->result();
			$data_pa=$this->ModelKwitansi->getdata_pa_pasien($no_register)->result();
			$data_rad=$this->ModelKwitansi->getdata_rad_pasien($no_register)->result();
			$data_resep=$this->ModelKwitansi->getdata_resep_pasien($no_register)->result();
			$no=1;
			//print_r($data_tindakan);
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

			
				foreach($data_tindakan as $row1){
					
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}

			// $konten=$konten."	<tr>
			// 				<td><p align=\"center\">2</p></td>
			// 				<td><b>LABORATORIUM</b></td>
			// 				<td></td>
			// 				<td><p align=\"right\">".number_format( $vtot->vtot_lab, 2 , ',' , '.' )."</p></td>
			// 			</tr>";
			
				foreach($data_lab as $row1){
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>(lab) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
			// $konten=$konten."	<tr>

			// 				<td><p align=\"center\">2</p></td>
			// 				<td><b>PATOLOGI ANATOMI</b></td>
			// 				<td></td>

			// 				<td><p align=\"right\">".number_format( $vtot->vtot_pa, 2 , ',' , '.' )."</p></td>

			// 			</tr>";
			
				foreach($data_pa as $row1){
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>(pa) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>

						</tr>";
					}
			// $konten=$konten."	<tr>
			// 				<td><p align=\"center\">3</p></td>
			// 				<td><b>RADIOLOGI</b></td>
			// 				<td></td>
			// 				<td><p align=\"right\">".number_format( $vtot->vtot_rad, 2 , ',' , '.' )."</p></td>
			// 			</tr>";
			foreach($data_rad as $row1){
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>(rad) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
			// $konten=$konten."	<tr>
			// 				<td><p align=\"center\">4</p></td>
			// 				<td><b>OBAT</b></td>
			// 				<td></td>
			// 				<td><p align=\"right\">".number_format( $vtot->vtot_obat, 2 , ',' , '.' )."</p></td>
			// 			</tr>
			// 			";
			foreach($data_resep as $row1){
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>(frm) ".ucwords(strtolower($row1->nama_obat))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
			
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table  >										
					<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>
					</table>";
			
			

			$konten=$konten."
						
					<br/>
					
					";

			/*<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>*/
			
			$konten=$konten."
					
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			//echo $konten;			
				$file_name="IRJ_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
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
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
				if(!file_exists(FCPATH.'download/irj/rjkwitansi/'.$file_name)){
					$this->session->set_flashdata('message_cetak','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Gagal Mencetak Kwitansi</center>
								</div>
							  </div>
							</div>
						</div>');
				    redirect('irj/rjckwitansi/kwitansi_detail/','refresh');
				}
		}else{
			redirect('irj/rjckwitansi/kwitansi/','refresh');
		}
	}
	
	public function st_cetak_kwitansi_kk($id_pelayanan_poli='',$id_poli='',$no_register='')
	{
		if($id_pelayanan_poli!=''){
			//ubah status
			$status=$this->rjmkwitansi->update_status_kwitansi_kk($id_pelayanan_poli);
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjckwitansi/cetak_kwitansi_kk/$id_pelayanan_poli/$id_poli/$no_register").'", "_blank");window.focus()</script>';
			redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}else{
			redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}
	}
	public function cetak_kwitansi_kk($id_pelayanan_poli='',$id_poli='',$no_register='')
	{	
		if($id_pelayanan_poli!=''){
		$cterbilang=new rjcterbilang();
			$get_no_kwkt=$this->rjmkwitansi->get_new_kwkk($id_pelayanan_poli)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkk=sprintf("KK%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkk($no_kwkk,$id_pelayanan_poli);
			$tgl_kk=$this->rjmkwitansi->getdata_tgl_kk($id_pelayanan_poli)->result();
				foreach($tgl_kk as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			// $data_rs=$this->rjmkwitansi->getdata_rs('1671013')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota_kab;
			// 	}

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_kwitansikk=$this->rjmkwitansi->getdata_kwitansikk($id_pelayanan_poli)->result();
			foreach($data_kwitansikk as $row){
			$vtot_terbilang=$cterbilang->terbilang($row->biaya_poli);
			$konten=
					"<table>
						<tr>
							<td><b>DEPARTEMEN KESEHATAN RI</b></td>
							<td><b>Tanggal-Jam: $tgl_jam</b></td>
						</tr>
						<tr>
							<td><b>DIRJEN BINA PELAYANAN MEDIK</b></td>
						</tr>
						<tr>
							<td><b>$namars</b></td>
						</tr>
					</table>
					<br/><hr/><br/>
					<p align=\"center\"><b>
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA KONSUL DOKTER RAWAT JALAN<br/>
					No. KW. $no_kwkk
					</b></p><br/>
					<table>
							<tr>
								<td width=\"30%\"><b>Sudah Terima Dari</b></td>
								<td width=\"5%\"> : </td>
								<td width=\"65%\">$row->nama</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>$row->nama</td>
							</tr>
							<tr>
								<td><b>Banyak Uang</b></td>
								<td> : </td>
								<td>$vtot_terbilang</td>
							</tr>
							<tr>
								<td><b>Di Poliklinik</b></td>
								<td> : </td>
								<td>$row->nm_poli</td>
							</tr>
							<tr>
								<td><b>Untuk Biaya Konsul Dokter</b></td>
								<td> : </td>
								<td>$row->nm_dokter</td>
							</tr>
							<tr>
								<td><b>Pemeriksaan</b></td>
								<td> : </td>
								<td>$row->nmtindakan</td>
							</tr>
					</table>
					<br/><br/>
				<b><font size=\"12\">Jumlah : Rp ".number_format( $row->biaya_poli, 2 , ',' , '.' )."</font></b>
				<p align=\"right\">$kota_kab, $tgl</p>
			";
			}
			$file_name="$no_kwkk.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'asset/download/irj/rjkwitansi/'.$file_name, 'FI');
				
		}else{
			redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}
	}

	//Special action

	



	









	public function cetak_kwitansi_detail_kwt($no_register='')
	{$penyetor =  $_COOKIE['penyetor'];		
		//$pilihtemp=$_COOKIE['pil'];
		/*if($pilihtemp=='0'){
			$pilih = '';
		}else */$pilih='0';

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($nominal_kk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nominal_kk+$tunai_bulat+$diskon, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}
			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nominal_kk+$tunai+$diskon;
					
			}

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			
			$konten1='';
			$no_rm=strtoupper($data_pasien->no_cm);
			$nama=strtoupper($penyetor);
			
			$poli=strtoupper($detail_daful->nm_poli);
			$biaya=number_format( $vtot, 2 , ',' , '.' );


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
					<table>	
					<tr><td></td></tr>
							<tr >
								<td > RM :&nbsp;&nbsp;&nbsp;&nbsp;" .strtoupper($data_pasien->no_cm)."</td>
							</tr>				
					</table>
					
					<br/><br/>";
									
		if($pilih!=''){	
				
			// $data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			// 
			
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			//$data_lab=$this->ModelKwitansi->getdata_lab_pasien($no_register)->result();
			//$data_pa=$this->ModelKwitansi->getdata_pa_pasien($no_register)->result();
			//$data_rad=$this->ModelKwitansi->getdata_rad_pasien($no_register)->result();
			//$data_resep=$this->ModelKwitansi->getdata_resep_pasien($no_register)->result();
			$no=1;
			//print_r($data_tindakan);$this->pdf->Cell(0, 12, 'Contoh pertama, CodeIgniter dan TCPDF', 1, 1, 'C');


			$konten=$konten."

			";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

				$vtot=0;
				foreach($data_tindakan as $row1){
					$vtot=$vtot+$row1->vtot;
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
					//$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
					//$jumlah_vtot =  $vtot->vtot + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat + $vtot->vtot_pa;
					if($diskon>0){
					$txtdiskon="<tr>
									<td width=\"17%\"><b>Diskon</b></td>
									<td width=\"2%\"> : </td>
									<td  width=\"78%\"><i>".$diskon."</i></td>
								</tr>";
					}else $txtdiskon="";
					if($tunai>0){
						$txttunai="<tr>
										<td width=\"17%\"><b>Jumlah Yang Dibayar</b></td>
										<td width=\"2%\"> : </td>
										<td  width=\"78%\"><i>".$tunai."</i></td>
									</tr>";
						$vtot_terbilang=$cterbilang->terbilang($tunai);
					}else {$txttunai=''; $vtot_terbilang='Nol Rupiah';	}
					
				
				$konten1=$konten."
					<table>
						<tr>
							<td width=\"\">".strtoupper($penyetor)."</td>
							</tr>
							<tr>
								<td>".strtoupper($detail_daful->nm_poli)."</td>
							</tr>
					</table>
					<table >										
					<tr>
						
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>

					</table>
					<tr>
							
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>";
			
			}

		else{

			$konten=$konten."
						
					<br/>
					<table style=\"border:1px solid black; width:100%;\">
															
					$txtdiskon			
					$totalbayar2
					
					</table>
					";

			
			}
			$konten1=$konten1."
					<br><br><br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
					$isi=$kota_kab;
					$data=$this->rjmregistrasi->getdata_tracer($no_register)->row();
					$row=$data->no_antrian;
					$no_reg=$data->no_register;
					$biaya=number_format( $vtot, 2 , ',' , '.' );
					$terbilang=strtoupper($vtot_terbilang);
			//echo $konten;			
				$file_name="IRJ_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$width = 92;
				$height = 241;
				$pageLayout = array($width, $height); 			
				$obj_pdf = new MYPDF('L', PDF_UNIT, $pageLayout, true, 'UTF-8', false);				
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
				// $obj_pdf->SetMargins('7', '7', '7');
				$obj_pdf->SetAutoPageBreak(TRUE, '7');
				$obj_pdf->SetFont('helvetica', '', 10);
				$obj_pdf->setFontSubsetting(false);
				//1
				$obj_pdf->AddPage();
				$obj_pdf->SetXY( 55, 10 );
				$obj_pdf->cell(10,5,'NO URUT : '.$row, 0, 1, 'L');
				$obj_pdf->SetXY( 200, 20 );
				$obj_pdf->cell(20,5,'RM : '.$no_rm. ' / '. $no_reg, 0, 1, 'R');
				$obj_pdf->SetXY( 95, 20 );
				$obj_pdf->cell(30,5,''.$nama, 0, 1, 'L');
				$obj_pdf->SetXY( 95, 31 );
				$obj_pdf->cell(100,5,''.$terbilang, 0, 1, 'L');
				$obj_pdf->SetXY( 120, 40 );
				$obj_pdf->cell(50,5,''.$poli, 0, 1, 'L');
				$obj_pdf->SetXY( 95, 75 );
				$obj_pdf->cell(30,5,''.$biaya, 0, 1, 'L');
				$obj_pdf->SetXY( 180, 70 );
				$obj_pdf->cell(40,5,''.$isi.', '.$tgl, 0, 1, 'C');
				$obj_pdf->SetXY( 180, 75 );
				$obj_pdf->cell(40,5,''.$user, 0, 1, 'C');
				// if($detail_bayar!='UMUM' and $pilih==''){
				/*2
				$obj_pdf->AddPage();
				ob_start();
				 	$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				//3
				$obj_pdf->AddPage();
				ob_start();
				 	$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');*/				
				// }
				$obj_pdf->Output(FCPATH.'/download/irj/rjkwitansi/'.$file_name, 'FI');
				$data['cetak_kwitansi']='1';
				//echo $vtot->vtot_lab!='';
				if($vtot->vtot_lab!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_laboratorium');
				}
				if($vtot->vtot_rad!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_radiologi');
				}
				if($vtot->vtot_obat!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'resep_pasien');
				}
				$this->update_bayar($data_tindakan);
		}else{
			redirect('irj/rjckwitansi/kwitansi_detail/','refresh');
		}
	}

	function cetak_faktur_kwt($no_register='')
	{
			
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			// 
			//print_r($detail_daful);
			if($detail_daful->cara_bayar=='UMUM'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;
			


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}else{
				$txtperusahaan="<td></td>
								<td></td>
								<td></td>";
			}
			
			
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$vtot=0;
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			$jumlah_vtot =  $vtot;
			
			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				$jumlah_vtot=$nominal_kk+$tunai+$diskon;
				$jumlah_vtot1=$nominal_kk+$tunai;
			}

			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";	
			$nomor=$this->rjmkwitansi->get_no_kwitansi($no_register)->row();
				
			if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($nominal_kk , 2 , ',' , '.' )."</p></td></tr>";
			}

			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nominal_kk+$tunai_bulat+$diskon, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nominal_kk+$tunai+$diskon;
					
			}

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			$style='';			
			if($data_pasien->sex=='L'){
				$sex='LAKI-LAKI';
			}else{
				$sex='PEREMPUAN';
			}

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:7px;
					    }
					.table-font-size1{
						font-size:8.5px;
					    }
					</style>
					
					<table  border=\"0\" style=\"padding-top:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:7px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam
								<br> $nomor
							</font></td>						
						</tr>
						
					</table>
						<tr>
						<td colspan=\"3\" ><font size=\"10\" align=\"center\"><u><b>KWITANSI REGISTRASI RAWAT JALAN 
						No. $no_register-1  </b></u></font></td>
					</tr>
					<table class=\"table-font-size1\" border=\"0\" style=\"padding-top:5px;\">		
								
																								
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"35%\">".strtoupper($data_pasien->nama)."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"22%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Kelamin</b></td>
								<td> : </td>
								<td>".$sex."</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->alamat)."</td>
								<td><b>Poli Tujuan</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nm_poli)."</td>
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td>".$pasien_bayar."</td>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
							</tr>							
							<tr>
								<td><b>Waktu Shift</b></td>
								<td> : </td>
								<td>".$detail_daful->shift."</td>						
								$txtperusahaan
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>						
								<td></td>
								<td></td>
								<td></td>
							</tr>
																											
					</table>";
															
			
				
			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();

			
			//print_r($data_tindakan);
			$no=1;
			$konten.="<table border=\"1\" style=\"padding:2px\" class=\"table-font-size1\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

			
				foreach($data_tindakan as $row1){
					
					$konten.="
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}

						
			
			$konten.="
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th ><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>

					</table>

					$txtdiskon	
					$txttunai
					$txtkk				
					$totalbayar

					<table style=\"padding-top:5px;\" class=\"table-font-size1\"><tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>
							</tr></table>
					
					";
					/*<table style=\"border:1px solid black; \" >										
					<tr>
						<td width=\"50%\" ><p>Jumlah </p></td>
						<td width=\"10%\">:</td>
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					</table>*/
			
			$konten.="
					
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl								
								
								<br><br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>";


			//echo $konten1;

				$konten1=$konten."<hr>".$konten."<hr>".$konten;
				// var_dump($konten1);die();
				$file_name="Daftar_$no_register-1.pdf";			
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
				$obj_pdf->SetMargins('5', '0', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '2');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi/kwitansi/','refresh');
		}
	}

	public function list_lunas()
	{
		$data['title'] = 'Pasien Umum Lunas Pembayaran';
		$data['url']='';
		//if($_SERVER['REQUEST_METHOD']=='POST'){
		$date0=$this->input->post('date0');
		$date1=$this->input->post('date1');
		if ($date0!='' && $date1!='') { 
			
			$data['date0']=$date0;
			$data['date1']=$date1;
		} else {
			$date0=date('Y-m-d', strtotime('-7 days'));
			$date1=date('Y-m-d');
			$data['date0']=$date0;
			$data['date1']=$date1;
		}
		$data['pasien_daftar']=$this->rjmkwitansi->get_pasien_kwitansi_lunas($date0,$date1)->result();
		$this->load->view('irj/rjvkwitansilunas',$data);
		//}else{
		//	redirect('irj/rjckwitansi/kwitansi');
		//}
	}

	public function retur($no_register='')
	{
		$data['title'] = 'Retur Kwitansi Rawat Jalan';
		$data['vtotpoli']=0;
		if($no_register!=''){
				$data['data_tindakan']=$this->rjmkwitansi->getdata_tindakan_pasienumumretur($no_register)->result();
				$data['no_register']=$no_register;
				$data['data_pasien']=$this->rjmkwitansi->getdata_pasien($no_register)->row();
				$data['vtot']=$this->rjmkwitansi->get_vtot($no_register)->row();
			foreach($data['data_tindakan'] as $row){
					$data['vtotpoli']=(int)$data['vtotpoli']+$row->vtot;
			}
			/*if(sizeof($data['data_tindakan'])==0){
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
				
			}*/
			
			$this->load->view('irj/rjvkwitansireturpasien',$data);
		}else{
			redirect('irj/rjckwitansi/list_lunas');
		}
	}

	public function batal($idno_kwitansi='')
	{
		$data['title'] = 'Batal Kwitansi Rawat Jalan';
		$data['vtotpoli']=0;
		if($idno_kwitansi!=''){
				$data['data_pasien']=$this->rjmkwitansi->getdata_pasien_nokwitansi($idno_kwitansi)->row();
				$no_register=$data['data_pasien']->no_register;
				$data['data_tindakan']=$this->rjmkwitansi->getdata_tindakan_pasienumumretur($no_register)->result();
				$data['no_register']=$no_register;
				$data['vtot']=$this->rjmkwitansi->get_vtot($no_register)->row();
			foreach($data['data_tindakan'] as $row){
					$data['vtotpoli']=(int)$data['vtotpoli']+$row->vtot;
			}

			/*if(sizeof($data['data_tindakan'])==0){
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
				
			}*/
			
			$this->load->view('irj/rjvkwitansipasienedit',$data);
		}else{
			redirect('irj/rjckwitansi/list_lunas');
		}
	}
}
?>
