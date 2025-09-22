<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Rjcterbilang.php');

// require_once(APPPATH.'controllers/Secure_area.php');
class Ricsjp extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('iri/rimlaporan','',TRUE);
		$this->load->helper('pdf_helper');
		// $this->load->library('zend');
	}

	

	public function index()
	{

		$data['title'] = 'SJP RAWAT INAP';
		$data['pasien_daftar']=$this->rimlaporan->get_pasien_sjp()->result();
		$data['url']='';


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
		$this->load->view('iri/rivsjp',$data);
	}

	public function cetak_sjp($no_register='', $cara_bayar='')
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
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rimlaporan->getdata_pasien_sjp($no_register)->row();
			// print_r($data_pasien);
			$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			if(substr($data_pasien->noregasal,0,2)=='RD'){
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			}else{
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			}

			if($data_pasien->sex=='L'){
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			if($data_pasien->carabayar=='BPJS'){
				$cara_bayar=$data_pasien->carabayar;
			} else {
				$cara_bayar='DIJAMIN / JAMSOSKES';
			}

			if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
				$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			} else {
				$tgl_rujukan = '';
			}

			$asal_rujukan=$data_asal->asal_rujukan;
			if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
				$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			}
			if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}

			
			$style='';			

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:12px;
					    }
					.table-font-size1{
						font-size:9px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					
					<table class=\"table-font-size1\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table ><br>
					<table border=\"0\" class=\"table-font-size1\">
							<tr>
								<td colspan=\"6\" ><hr>
									<font size=\"9\" align=\"center\">
										SURAT JAMINAN PELAYANAN (SJP) ".$cara_bayar."<br/>
										SJP RITL No. $no_register
									</font><hr>
								</td>
							</tr>		
							<tr>
								<td width=\"21%\">1. Tanggal SJP</td>
								<td width=\"1%\">:</td>
								<td width=\"34%\">".strtoupper($tgl)."</td>
								<td width=\"19%\">Nama Pasien</td>
								<td width=\"1%\">:</td>
								<td width=\"23%\">".strtoupper($data_pasien->nama)."</td>
							</tr>	
							<tr>
								<td>2. Nomor Rujukan</td>
								<td>:</td>
								<td>".$data_pasien->nosjp."</td>
								<td>Nomor Medrec</td>
								<td>:</td>
								<td><b>".$data_pasien->no_cm."</b></td>
							</tr>	
							<tr>
								<td>3. Tanggal Rujukan</td>
								<td>:</td>
								<td>".$tgl_rujukan."</td>
								<td>Nomor Register</td>
								<td>:</td>
								<td>".$data_pasien->no_ipd."</td>
							</tr>	
							<tr>
								<td>4. Asal Rujukan</td>
								<td>:</td>
								<td>".$rujukan."</td>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td>".$jk."
								</td>
							</tr>	
							<tr>
								<td>5. Ruangan</td>
								<td>:</td>
								<td>".$data_ruang->nmruang."</td>
								<td>Tanggal Lahir</td>
								<td>:</td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_lahir))."</td>
							</tr>	
							<tr>
								<td>6. Bed</td>
								<td>:</td>
								<td>".$bed."</td>
								<td>Status</td>
								<td>:</td>
								<td></td>
							</tr>	
							<tr>
								<td>7. Tanggal Masuk</td>
								<td>:</td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_masuk))."</td>
								<td colspan=\"3\">
								Pasien  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								Dokter RS&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								Petugas</td>
							</tr>	
							<tr>
								<td>8. Tanggal Keluar</td>
								<td>:</td>
								<td></td>
								<td colspan=\"3\">
								1)............  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								1)............ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								1)............</td>
							</tr>	
							<tr>
								<td>9. Tujuan Rujukan</td>
								<td>:</td>
								<td>1) Rawat Inap</td>
								<td colspan=\"3\">
								2)............  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								2)............ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								2)............</td>
							</tr>	
							<tr>
								<td>10. Pemeriksaan Paket</td>
								<td>:</td>
								<td>
									2)__P2A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3)__P2B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4)__P2C 
									<br>
									5)__P3A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6)__P2A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7)__P3C
								</td>
								<td colspan=\"3\">
								3)............  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								3)............ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
								3)............</td>

							</tr>	
							<tr>
								<td>11. Rujukan Intern Ke</td>
								<td>:</td>
								<td>
									8) Poli :<br>
									9) Poli :
								</td>	
								<td>Diagnosa Asal</td>
								<td>:</td>
								<td></td>						</tr>	
							<tr>
								<td>12. Jaminan Pelayanan</td>
								<td>:</td>
								<td>
									10) ".$data_pasien->nmkontraktor."
								</td>
								<td>Diagnosa Dokter</td>
								<td>:</td>
								<td></td>
							</tr>	
							<tr>
								<td></td>
								<td></td>
								<td>
									11) 
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							<tr>
								<td>13. Catatan Khusus</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							<tr>
								<td>14. Biaya Pelayanan</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp; &nbsp; &nbsp; Diajukan</td>
								<td>:</td>
								<td> Rp. </td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp; &nbsp; &nbsp; Disetujui</td>
								<td>:</td>
								<td> Rp. </td>
								<td></td>
								<td></td>
								<td></td>
							</tr>																			
					</table><br/><br/><br/><br/><br/><br/><br/><br/>";
		
			$konten=$konten."
					<p ><b>BERKAS INI TIDAK DIBAWA PULANG</b></p>
					<p align=\"right\">$kota_kab, $tgl<br>
					&nbsp; &nbsp; &nbsp; Petugas Pengendali RS<br><br><br><br><br>
					(......................................)</p>";
			//echo $konten;			
				$file_name="SJP_$no_register.pdf";			
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
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/inap/sjp/'.$file_name, 'FI');
		}else{
			redirect('iri/ricsjp/','refresh');
		}
	}

	// public function cetak_barcode()
	// {
	// 	$this->barcode();
	// 	// $this->load->view('contoh_barcode',$data);
	// }
		
	// public function barcode( $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 , $filepath="") {
	// 	$code_string = "";
	// 	// Translate the $text into barcode the correct $code_type
	// 	if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
	// 		$chksum = 104;
	// 		// Must not change order of array elements as the checksum depends on the array's key to validate final code
	// 		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
	// 		$code_keys = array_keys($code_array);
	// 		$code_values = array_flip($code_keys);
	// 		for ( $X = 1; $X <= strlen($text); $X++ ) {
	// 			$activeKey = substr( $text, ($X-1), 1);
	// 			$code_string .= $code_array[$activeKey];
	// 			$chksum=($chksum + ($code_values[$activeKey] * $X));
	// 		}
	// 		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

	// 		$code_string = "211214" . $code_string . "2331112";
	// 	} elseif ( strtolower($code_type) == "code128a" ) {
	// 		$chksum = 103;
	// 		$text = strtoupper($text); // Code 128A doesn't support lower case
	// 		// Must not change order of array elements as the checksum depends on the array's key to validate final code
	// 		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
	// 		$code_keys = array_keys($code_array);
	// 		$code_values = array_flip($code_keys);
	// 		for ( $X = 1; $X <= strlen($text); $X++ ) {
	// 			$activeKey = substr( $text, ($X-1), 1);
	// 			$code_string .= $code_array[$activeKey];
	// 			$chksum=($chksum + ($code_values[$activeKey] * $X));
	// 		}
	// 		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

	// 		$code_string = "211412" . $code_string . "2331112";
	// 	} elseif ( strtolower($code_type) == "code39" ) {
	// 		$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

	// 		// Convert to uppercase
	// 		$upper_text = strtoupper($text);

	// 		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
	// 			$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
	// 		}

	// 		$code_string = "1211212111" . $code_string . "121121211";
	// 	} elseif ( strtolower($code_type) == "code25" ) {
	// 		$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
	// 		$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

	// 		for ( $X = 1; $X <= strlen($text); $X++ ) {
	// 			for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
	// 				if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
	// 					$temp[$X] = $code_array2[$Y];
	// 			}
	// 		}

	// 		for ( $X=1; $X<=strlen($text); $X+=2 ) {
	// 			if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
	// 				$temp1 = explode( "-", $temp[$X] );
	// 				$temp2 = explode( "-", $temp[($X + 1)] );
	// 				for ( $Y = 0; $Y < count($temp1); $Y++ )
	// 					$code_string .= $temp1[$Y] . $temp2[$Y];
	// 			}
	// 		}

	// 		$code_string = "1111" . $code_string . "311";
	// 	} elseif ( strtolower($code_type) == "codabar" ) {
	// 		$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
	// 		$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

	// 		// Convert to uppercase
	// 		$upper_text = strtoupper($text);

	// 		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
	// 			for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
	// 				if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
	// 					$code_string .= $code_array2[$Y] . "1";
	// 			}
	// 		}
	// 		$code_string = "11221211" . $code_string . "1122121";
	// 	}

	// 	// Pad the edges of the barcode
	// 	$code_length = 20;
	// 	if ($print) {
	// 		$text_height = 30;
	// 	} else {
	// 		$text_height = 0;
	// 	}
		
	// 	for ( $i=1; $i <= strlen($code_string); $i++ ){
	// 		$code_length = $code_length + (integer)(substr($code_string,($i-1),1));
	// 		}

	// 	if ( strtolower($orientation) == "horizontal" ) {
	// 		$img_width = $code_length*$SizeFactor;
	// 		$img_height = $size;
	// 	} else {
	// 		$img_width = $size;
	// 		$img_height = $code_length*$SizeFactor;
	// 	}

	// 	$image = imagecreate($img_width, $img_height + $text_height);
	// 	$black = imagecolorallocate ($image, 0, 0, 0);
	// 	$white = imagecolorallocate ($image, 255, 255, 255);

	// 	imagefill( $image, 0, 0, $white );
	// 	if ( $print ) {
	// 		imagestring($image, 5, 31, $img_height, $text, $black );
	// 	}

	// 	$location = 10;
	// 	for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
	// 		$cur_size = $location + ( substr($code_string, ($position-1), 1) );
	// 		if ( strtolower($orientation) == "horizontal" )
	// 			imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
	// 		else
	// 			imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
	// 		$location = $cur_size;
	// 	}
		
	// 	// Draw barcode to the screen or save in a file
	// 	if ( $filepath=="" ) {
	// 		header ('Content-type: image/png');
	// 		imagepng($image);
	// 		imagedestroy($image);
	// 	} else {
	// 		imagepng($image,$filepath);
	// 		imagedestroy($image);		
	// 	}
	// }

	public function cetak_gelang($no_register='')
	{
		error_reporting(~E_ALL);
		
		// echo NAMA_RS;die();
		$a = $this->db->query("SELECT * FROM app_config WHERE key = 'top_pdf'")->row();
		$b = $this->db->query("SELECT * FROM app_config WHERE key = 'bottom_pdf'")->row();
		// $c = $this->db->query("SELECT * FROM app_config WHERE key = 'isi'")->row();
		// print_r($a->value.);
		// echo $c->value;
		// echo $a->value.$b->value;
		// die();
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			//$tgl_jam = date("d-m-Y H:i:s");
			$tgl_jam = date("d-m-Y ");
			$tgl = date("d-m-Y");
			// $contoh_barcode = set_barcode('TEsting');
			// echo $contoh_barcode;
			// die();
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rimlaporan->getdata_pasien_sjp($no_register)->row();
			// print_r($data_pasien);
			$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			if(substr($data_pasien->noregasal,0,2)=='RD'){
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			}else{
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			}

			if($data_pasien->sex=='L'){
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			if($data_pasien->carabayar=='BPJS'){
				$cara_bayar=$data_pasien->carabayar;
			} else {
				$cara_bayar='JAMSOSKES';
			}

			if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
				$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			} else {
				$tgl_rujukan = '';
			}

			$asal_rujukan=$data_asal->asal_rujukan;
			if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
				$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			}
			if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}

			$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
			$thn=$interval->format("%Y Tahun");
			
			
			
			$style = array(
				'border' => false,
				'padding' => 0,
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			// $barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_register.'">';

			$file_name="GELANG_$no_register.pdf";			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();			
			$pageLayout = array('53', '500'); //  or array($height, $width) 
			$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);				
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
			$obj_pdf->SetMargins('1', '1', '1');
			$obj_pdf->SetAutoPageBreak(TRUE, '1');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_register, 'C128', '', '', 50, 15, 0.4, array('position'=>'T', 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>4, 'stretchtext'=>4), 'N'));
			

			$konten=
		
			



			// "<style type=\"text/css\">
			// 		.table-font-size{
			// 			font-size:5px;
			// 		    }
			// 		.table-font-size1{
			// 			font-size:7px;
			// 			margin : 0.5px 1px 0.5px 1px;
			// 			padding : 1px 1px 0.5px 1px;
			// 			width:100%; height:100%;
			// 		    }
			// 		</style>
			// 		<br><br>
			// 		<table class=\"table-font-size1\" border=\"0\">
			// 			<tr>
			// 				<td width=\"16%\"></td>
			// 				<td align=\"center\" rowspan=\"3\" width=\"7%\">
			// 					<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"27\" style=\"\">
			// 				</td>
			// 				<td width=\"37%\">$data_pasien->nama</td>	
			// 				<td width=\"40%\" align=\"left\">No Medrec : $data_pasien->no_cm</td>
			// 			</tr>
			// 			<tr>	
			// 				<td></td>
			// 				<td>$jk</td>					
			// 				<td align=\"left\">No Register : $data_pasien->no_ipd</td>				
			// 			</tr>
			// 			<tr>	
			// 				<td align=\"right\"><font size=\"5px\">$tgl_jam</font></td>
			// 				<td>".date("d-m-Y",strtotime(substr($data_pasien->tgl_lahir,0,10)))." (".$thn.")</td>		
			// 				<td align=\"left\">$data_ruang->nmruang, Bed $bed</td>				
			// 			</tr>
			// 		</table >";

			



					'<style type="text/css">
					.table-font-size{
						font-size:5px;
					    }
					.table-font-size1{
						font-size:5px;
						margin : 0px 1px 0.5px 1px;
						padding : 0px 1px 0.5px 1px;
						width:100%; 
						height:100%;
					    }
					</style>
					<br><br>
					<table class="table-font-size1" border="0">
						<tr>
							<td colspan="3">
							<b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b>
							</td>
						</tr>
						<tr>
							<td colspan="3">
							
							</td>
						</tr>
						<tr>
							<td width="15%">'.$data_pasien->nama.'</td>	
							<td align="left">'.$data_pasien->no_cm.'</td>
						</tr>
						<tr>	
							<td width="15%">Tgl Dirawat: '.$tgl_jam.'</td>	
							<td width="15%">Tgl Lahir:'.date('d-m-Y',strtotime(substr($data_pasien->tgl_lahir,0,10))).' <br>('.$thn.')</td>
							<td style="padding:100px;">';
							$konten.= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
							$konten.='</td>
						</tr>
					
					</table >
					';
					// $konten.= NAMA_RS;

			//echo $konten;
				// $c = $a->value.$b->value;			
				// $konten .= TOP_HEADER;
				// $konten .= ISI;
				// $konten .= BOTTOM_HEADER;
				$content = $konten;
				
				// ob_end_clean();
				// $content .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';
				// $pdf->SetAutoPageBreak(TRUE, 0);
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				// $obj_pdf->write1DBarcode($no_register, 'C128B', '', 10, 50, 20, 2, $style,'N');

				$obj_pdf->Output(FCPATH.'download/inap/gelang/'.$file_name, 'FI');
		}else{
			redirect('iri/ricsjp/','refresh');
		}
	}
}
?>
