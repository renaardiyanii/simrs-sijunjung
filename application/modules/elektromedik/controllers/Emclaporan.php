<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
//require_once(APPPATH.'controllers/Secure_area.php');
class Emclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('elektromedik/Emmlaporan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('elektromedik/Emcdaftar','refresh');
	}

	public function lap_pemeriksaan(){
		$data['title'] = 'Laporan Pemeriksaan Elektromedik';
		//$date0=$this->input->post('date0');
		//$date1=$this->input->post('date1');

		$this->load->view('elektromedik/emvlappemeriksaanrange.php',$data);
	}

	function showlap_pemeriksaan($date0='',$date1=''){
		$line  = array();
		$line2 = array();
		$row2  = array();	
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d', strtotime('-7 days'));
			$date1=date('Y-m-d');
		}		
		//$data['tglawal']=date('d F Y',strtotime($date0));
		//$data['tglakhir']=date('d F Y',strtotime($date1));
		$hasil=$this->Emmlaporan->get_lap_pemeriksaan($date0,$date1)->result();			
		foreach ($hasil as $value) {
			$row2['idtindakan'] = $value->idtindakan;
			$row2['nmtindakan'] = $value->nmtindakan;
			$row2['banyak'] = $value->banyak;			
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function data_kunjungan() 
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Pemeriksaan Elektromedik';
		$data['pemeriksaan_title']="Laporan per Pemeriksaan :";

		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');				
				//$tgl_indo=new Tglindo();
				if($tampil_per=='TGL'){
					//$tgl_awal=$this->input->post('date_picker_days1');
					//if(){
					//}
					$tgl=$this->input->post('date_picker_days');					
					
					$data['data_laporan_kunj']=$this->Emmlaporan->get_data_kunj_by_date($tgl)->result();
					$data['data_tindakan']=$this->Emmlaporan->get_data_tindakan_tgl($tgl)->result();
					$data['data_pemeriksaan']=$this->Emmlaporan->get_data_pemeriksaan_tgl($tgl)->result();
					$tgl1 = date('d F Y', strtotime($tgl));
					$data['date_title']="Laporan Kunjungan Pasien Elektromedik <b>$tgl1</b>";
					$data['field1']='No. Medrec';					
					$data['tgl']=$tgl;
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');

					
					//echo $this->input->post('date_picker_months');

					$data['data_laporan_kunj']=$this->Emmlaporan->get_data_kunj_bln($bln)->result();
					$data['data_tindakan']=$this->Emmlaporan->get_data_tindakan_bln($bln)->result();
					$data['data_pemeriksaan']=$this->Emmlaporan->get_data_pemeriksaan_bln($bln)->result();
					
					$bln1 = date('F Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $bln2;
					$data['date_title']="Laporan Kunjungan Pasien Elektromedik per Hari <b>Bulan $bln3</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
					$data['field1']='Tanggal';					
					$data['date']=$bln;//untuk param waktu cetak
					$data['bln']=$bln;
					//print_r($bln2);
				}else{
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_kunj']=$this->Emmlaporan->get_data_kunj_thn($thn)->result();
					$data['data_tindakan']=$this->Emmlaporan->get_data_tindakan_thn($thn)->result();
					$data['data_pemeriksaan']=$this->Emmlaporan->get_data_pemeriksaan_thn($thn)->result();
					
					$data['date_title']="Laporan Kunjungan Pasien Elektromedik <b>Tahun $thn</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					// $data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_kunj']);
				//$data['size']=$size;
				if($size<1){
				//echo "hahahaha";
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('elektromedik/emvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Emmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Emmlaporan->get_data_tindakan()->result();
			$data['data_pemeriksaan']=$this->Emmlaporan->get_data_pemeriksaan()->result();
			$data['date_title']='Laporan Kunjungan Pasien Elektromedik <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';
			$data['tampil_per']='TGL';		
			
			$size=sizeof($data['data_laporan_kunj']);			

			if($size<1){
				//
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('elektromedik/emvlapkunjunganrange.php',$data);
		}
	}

	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Penunjang Elektromedik';				

		// $tgl_indo=new Tglindo();
		// if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$tampil_per=$this->input->post('tampil_per');			
		// 		if($tampil_per=='TGL'){
		// 			$tgl=$this->input->post('date_picker_days');
		// 			$data['data_laporan_keu']=$this->Emmlaporan->get_data_keu_tind_tgl($tgl)->result();
		// 			$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_tgl($tgl)->result();
		// 			$data['cara_bayar_pasien']="";
		// 			$tgl1= date('d F Y', strtotime($tgl));
					
		// 			$data['date_title']="<b>$tgl1</b>";
		// 			$data['field1']='No. Register';
		// 			$data['tgl']=$tgl;
					
		// 		}else if($tampil_per=='BLN'){
		// 			$bln=$this->input->post('date_picker_months');			

		// 			$data['data_laporan_keu']=$this->Emmlaporan->get_data_keu_tind_bln($bln)->result();

		// 			$cara_bayar=$this->input->post('jenis_pasien1');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien1');			
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Emmlaporan->get_data_periode_bln($bln)->result();
		// 				$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_bln($bln)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Emmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
		// 			}
		// 			$bln1 = date('Y', strtotime($bln));
		// 			$bln2 = date('m', strtotime($bln));
		// 			$bln3 = $tgl_indo->bulan($bln2);
		// 			//echo $tgl_indo->bulan('08');
		// 			$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
		// 			$data['field1']='Tanggal';
		// 			$data['tgl']=$bln3;
		// 			$data['bln']=$bln;
		// 			$data['date']=$bln;//untuk param waktu cetak

		// 		}else{					
					
		// 			$thn=$this->input->post('date_picker_years');
		// 			$data['data_laporan_keu']=$this->Emmlaporan->get_data_keu_tind_thn($thn)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien2');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien2');		
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Emmlaporan->get_data_periode_thn($thn)->result();
		// 				$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_thn($thn)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Emmlaporan->get_data_periode_thn_bycarabayar($thn, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)->result();
		// 			}
		// 			$data['date_title']="per Bulan <b> Tahun $thn</b>";
		// 			$data['field1']='Bulan';
		// 			$data['date']=$thn;//untuk param waktu cetak
		// 			$data['thn']=$thn;
		// 			$data['tgl_indo']=$tgl_indo;
		// 		}
		// 		$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
		// 		$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('elektromedik/pend_today',$data);
		// }else{			
		// 	$data['data_laporan_keu']=$this->Emmlaporan->get_data_keu_tindakan_today()->result();
		// 	$data['data_keuangan']=$this->Emmlaporan->get_data_keuangan_today()->result();
		// 	$data['date_title']='<b>'.date("d F Y").'</b>';
		// 	$data['tgl']=date("Y-m-d");
		// 	$data['field1']='No. Register';
		// 	$data['stat_pilih']='';
		// 	$data['tampil_per']='TGL';
		// 	$data['cara_bayar_pasien']="";

		// 	$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			//echo "hahahahdwadawdwafawfeagageaga";
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('elektromedik/pend_today',$data);
		// 	//redirect('ird/IrDLaporan/data','refresh');
		// }
		
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pendapatan.
			</h4>							
			</div>
		</div>";

		$this->load->view('elektromedik/emvpendapatan',$data);


	}

	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Elektromedik';

		// $tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		$konten="<table>
					<tr>
						<td colspan=\"2\">
							<p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
						</td>
						<td align=\"right\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
					</tr>
					<tr>
						<td colspan=\"3\">
							<b><font size=\"9\" align=\"right\">$alamat</font></b>
						</td>
					</tr><hr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan Elektromedik</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>";

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_EM_$tgl.pdf";
				
				$data_laporan_keu=$this->Emmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Emmlaporan->get_data_keuangan_tgl($tgl)->result();
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"3%\"><b>No</b></td>
								<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"10%\"><b>No Register</b></td>
								<td width=\"26%\"><b>Nama</b></td>
								<td width=\"31%\"><b>Jenis Pemeriksaan</b></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Pemeriksaan</b></td>
							</tr>
						";
						
					$jum_vtot=0;
					$vtot1=0;
					$i=1;
					foreach($data_laporan_keu as $row){
						$no_register=$row->no_register;
						$j=1;		
						foreach($data_keuangan as $row2){
							if ($row2->no_register==$no_register) {
								$vtot1=$vtot1+$row2->vtot;
								//$jum_vtot = $jum_vtot+$row2->total;
								if($j==1){ 
									$konten=$konten."
									<tr>
										<td>".$i++."</td>
										<td>$row->no_cm</td>
										<td>$row->no_register</td>
										<td>$row->nama</td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 } else { 
								 	$konten=$konten."
									<tr>
										<td colspan=\"4\" bgcolor=\"#cdd4cb\"></td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 }
							$j++;
							} // if
						}
					}

					
					$konten=$konten."
						<tr>
							<th colspan=\"5\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/elektromedik/emlaporan/keu/'.$file_name, 'FI');
						
			}else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_EM_$bln1.pdf";


				//$data_laporan_keu=$this->Emmlaporan->get_data_keu_tind_bln($bln)->result();
				if($param2!=''){
					$data_periode=$this->Emmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Emmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_bln($bln)->result();
				}
				
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"10%\"><b>Tanggal</b></td>
								<td rowspan=\"2\" width=\"39%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Emmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
							} else {
								$rwspn=count($this->Emmlaporan->row_table_pertgl($row->tgl)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtottotal=0;
							$vtotjumpas=0;
							$vtotjumpem=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$bln1 = date('d', strtotime($row2->tgl));
									$bln2 = date('m', strtotime($row2->tgl));
									$bulan = $tgl_indo->bulan($bln2);
									$vtottotal=$vtottotal+$row2->total;
									$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
									$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
									$vtot=$vtot+$row2->total;
									$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
									$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bln1 $bulan</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/elektromedik/emlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_EM_$thn1.pdf";

				//$data_laporan_keu=$this->Emmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Emmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Emmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_thn($thn)->result();
				}
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"14%\"><b>Bulan</b></td>
								<td rowspan=\"2\" width=\"35%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Emmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
							} else {
								$rwspn=count($this->Emmlaporan->row_table_perbln($row->bln)->result());
							}
							$rwspn1=$rwspn+1;
							$j=1;
							$vtottotal=0;
							$vtotjumpas=0;
							$vtotjumpem=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									$thn = date('Y', strtotime($row2->bln));
									$bln2 = date('m', strtotime($row2->bln));
									$bulan = $tgl_indo->bulan($bln2);
									$vtottotal=$vtottotal+$row2->total;
									$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
									$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
									$vtot=$vtot+$row2->total;
									$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
									$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bulan $thn</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>"
					;
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/elektromedik/emlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}
	}

	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Elektromedik';

		// $tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RSPATRIAIKKT")  
		        ->setLastModifiedBy("RSPATRIAIKKT")  
		        ->setTitle("Laporan Keuangan RS PATRIA IKKT")  
		        ->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
		        ->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("RS PATRIA IKKT")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
		if($tampil_per=='TGL'){	
			if($param1!=''){

				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				$data_laporan_keu=$this->Emmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Emmlaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_em_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 4;
				foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$j=1;		
					foreach($data_keuangan as $row2){
						if ($row2->no_register==$no_register) {
							$vtot1=$vtot1+$row2->vtot;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_cm);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 	$i++;
							 } else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 }
						$j++;
						$rowCount++;
						} // if
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);
				header('Content-Disposition: attachment;filename="Lap_Keu_Elektromedik_TGL.xlsx"');  
					
			}else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				if($param2!=''){
					$data_periode=$this->Emmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Emmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_bln($bln)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_em_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : '.$bln1);

				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);

				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->tgl==$row->tgl){
							$bln3 = date('d', strtotime($row2->tgl));
							$bln2 = date('m', strtotime($row2->tgl));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						} // if
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Elektromedik_Bulan.xlsx"');  
			}
			else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_EM_$thn1.pdf";

				//$data_laporan_keu=$this->Emmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Emmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Emmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Emmlaporan->get_data_keuangan_thn($thn)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_em_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : '.$thn);


				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->bln==$row->bln){
							$thn = date('Y', strtotime($row2->bln));
							$bln2 = date('m', strtotime($row2->bln));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						}
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Elektromedik_Tahun.xlsx"'); 
			}else{
				redirect('elektromedik/Emclaporan/data_pendapatan','refresh');
			}
		}

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS PATRIA IKKT');  
		   
		   
		   
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
		$objWriter->save('php://output');  
	}

	public function download_keuangan($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")  
		        ->setLastModifiedBy("RS AL Marinir Cilandak")  
		        ->setTitle("Laporan Keuangan RS AL Marinir Cilandak")  
		        ->setSubject("Laporan Keuangan RS AL Marinir Cilandak Document")  
		        ->setDescription("Laporan Keuangan RS AL Marinir Cilandak, generated by HMIS.")  
		        ->setKeywords("RS AL Marinir Cilandak")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		$data_keuangan=$this->Emmlaporan->get_data_keu_tind($param1, $param2)->result();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_em.xlsx');
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

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Elektromedik Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
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

			if($temp == $row->no_em){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_em);
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
				$temp = $row->no_em;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_em);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->idrg);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->bed);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->cara_bayar);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->kontraktor);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_em);
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
		$filename = "Laporan Pendapatan Elektromedik ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');    
		   
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
	}

	public function excel_lappemeriksaan_old($date0='',$date1=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$namars=$this->config->item('namars');
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Elektromedik ".$namars)  
		        ->setSubject("Laporan Elektromedik ".$namars." Document")  
		        ->setDescription("Laporan Elektromedik ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Elektromedik");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		//$tgl=$param1;
		//$tgl1 = date('d F Y', strtotime($tgl));				
					
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_range_lab_tgl.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
		$vtot1=0;
		$i=1;
		$rowCount = 4;
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d', strtotime('-7 days'));
			$date1=date('Y-m-d');
		}	
		$hasil=$this->Emmlaporan->get_lap_pemeriksaan_detail($date0,$date1)->result();
		$listtgl = $this->Emmlaporan->get_dates_detail($date0,$date1)->result();
		$master_lab=$this->Emmlaporan->get_master_pemeriksaan_em()->result();
		$objPHPExcel->getActiveSheet()->setTitle('Lap Range'); 
		//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, "aaaaaaaaaaaaaa");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$rowCount = 5; $vtotbpjs=0; $vtotumum=0; $vtotdijamin=0; $vtotp=0; $vtotl=0;
      	foreach($listtgl as $key) {
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, date('d-m-Y',strtotime($key->tgl_kunjungan)));
	        $vtotbpjs=$vtotbpjs+$key->BPJS;
	        $vtotumum=$vtotumum+$key->UMUM;
	        $vtotdijamin+$vtotdijamin+$key->DIJAMIN;
	        $vtotp=$vtotp+$key->P;
	        $vtotl=$vtotl+$key->L;
	        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->BPJS);
	        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->UMUM);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->DIJAMIN);
	        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->P);
	        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $key->L);

	        foreach($hasil as $row) {
	        	$col = 6;
		        if($key->tgl_kunjungan==$row->tgl_kunjungan){
		        	foreach($master_lab as $row0) {
		        		if($row->idtindakan==$row0->idtindakan){	
		        			$vtot1=$vtot1+$row->banyak;
		        			//echo $row->banyak.' '.$row->nmtindakan;      			
		        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row->banyak);
		        		}else{
		        			//echo $row->idtindakan.'=='.$row0->idtindakan;
		        			//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
		        			//if($hi==null && $hi<1){
		        			//	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
		        			//}
		        			
		        		}	
		        		$col++;	
		        	}
		    	}else{	    		
		    		//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
		        	//if($hi==null && $hi<1){
		        	//			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
		        	//}
		        	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, '0');		        	
		    	}
	        }
	        $rowCount++;
	    }

		$col = 6;
	    foreach($master_lab as $key) {
	        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $key->nmtindakan);
	        $col++;
	    }
		//break;
	    /*$col = 5;
	    foreach($hasil as $key) {
	    	$vtot1=$vtot1+$key->banyak;
	    	if($key->tgl_kunjungan){

	    	}else{

	    	}
	        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, $key->banyak);
	        $col++;
	    }*/
	    
	    for ($j=5;$j<$rowCount;$j++) {
			for ($i=6;$i<$col;$i++) {
			    $hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();//getCellValueByColumnAndRow();
			    if($hi==null || $hi==''){
			    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
			    }
			}
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $vtotbpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotumum);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdijamin);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotl);
		$rowCount++;
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);

		header('Content-Disposition: attachment;filename="Lap_Range_Elektromedik.xlsx"');		   
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
	}

	
	public function excel_lappemeriksaan($date0='',$date1='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Tindakan');
		$sheet->setCellValue('C1', 'Banyak');
				
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d', strtotime('-7 days'));
			$date1=date('Y-m-d');
		}		
		$data=$this->Emmlaporan->get_lap_pemeriksaan($date0,$date1)->result();
	
		$no = 1;
		$x = 2;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nmtindakan);
			$sheet->setCellValue('C'.$x, $row->banyak);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Lap_Range_Laboratorium';
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}

	public function lap_list_tindakan() {
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$ruang = $this->input->post('ruang');
		$tampil = $this->input->post('tampil_per');

		if($tampil == 'TGL') {
			$data['title'] = 'List Tindakan Unit Diagnostik Terpadu '.date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tampil;
			$data['ruang'] = $ruang;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_tindakan($date, $tampil, $ruang)->result();
		} else if($tampil == 'BLN') {
			$data['title'] = 'List Tindakan Unit Diagnostik Terpadu '.date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tampil;
			$data['ruang'] = $ruang;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_tindakan($month, $tampil, $ruang)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'List Tindakan Unit Diagnostik Terpadu '.date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['ruang'] = 'semua';
			$data['list_tindakan'] = $this->Emmlaporan->get_list_tindakan($tgl, 'TGL', 'semua')->result();
		}

		$this->load->view('elektromedik/laplist_tindakan', $data);
	}

	public function lap_keuangan() {
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$ruang = $this->input->post('ruang');
		$tampil = $this->input->post('tampil_per');

		if($tampil == 'TGL') {
			$data['title'] = 'Laporan Unit Diagnostik Terpadu '.date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tampil;
			$data['ruang'] = $ruang;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_keuangan($date, $tampil, $ruang)->result();
		} else if($tampil == 'BLN') {
			$data['title'] = 'Laporan Unit Diagnostik Terpadu '.date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tampil;
			$data['ruang'] = $ruang;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_keuangan($month, $tampil, $ruang)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Unit Diagnostik Terpadu '.date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['ruang'] = 'semua';
			$data['list_tindakan'] = $this->Emmlaporan->get_list_keuangan($tgl, 'TGL', 'semua')->result();
		}

		$this->load->view('elektromedik/laplist_keuangan', $data);
	}

	public function excel_lap_keuangan($date, $tampil, $ruang) {
		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		if($ruang == 'RI') {
			$ket_pasien = 'Pasien Rawat Inap';
		} else if($ruang == 'RJ') {
			$ket_pasien = 'Pasien Rawat Jalan/IGD';
		} else if($ruang == 'PL') {
			$ket_pasien = 'Pasien Luar'; 
		} else {
			$ket_pasien = 'Semua Pasien';
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Tindakan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Ruangan');
		$sheet->mergeCells('D1:G1')
			->getCell('D1')
			->setValue('Kelompok Jaminan');
		$sheet->mergeCells('H1:H2')
			->getCell('H1')
			->setValue('Tarif RS');
		$sheet->mergeCells('I1:I2')
			->getCell('I1')
			->setValue('Total Pendapatan');
		$sheet->setCellValue('D2', 'BPJS');
		$sheet->setCellValue('E2', 'UMUM');
		$sheet->setCellValue('F2', 'IKS');
		$sheet->setCellValue('G2', 'Total');

		$data = $this->Emmlaporan->get_list_keuangan($date, $tampil, $ruang)->result();

		$no = 1;
		$x = 3;
		$bpjs = 0;
		$umum = 0;
		$iks = 0;
		$total_count = 0;
		$tarif_rs = 0;
		$pendapatan = 0;

		foreach($data as $row) {
			$total = $row->bpjs + $row->umum + $row->iks;
			$bpjs += $row->bpjs;
			$umum += $row->umum;
			$iks += $row->iks;
			$total_count += $total;
			$tarif_rs += $row->tarif_rs;
			$pendapatan += $row->tarif_rs * $total;

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('C'.$x, $row->ruang);
			$sheet->setCellValue('D'.$x, $row->bpjs);
			$sheet->setCellValue('E'.$x, $row->umum);
			$sheet->setCellValue('F'.$x, $row->iks);
			$sheet->setCellValue('G'.$x, $total);
			$sheet->setCellValue('H'.$x, number_format($row->tarif_rs));
			$sheet->setCellValue('I'.$x, number_format($row->tarif_rs * $total));
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Grand Total');
		$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
		$sheet->setCellValue('D'.$x, $bpjs);
		$sheet->setCellValue('E'.$x, $umum);
		$sheet->setCellValue('F'.$x, $iks);
		$sheet->setCellValue('G'.$x, $total_count);
		$sheet->setCellValue('H'.$x, number_format($tarif_rs));
		$sheet->setCellValue('I'.$x, number_format($pendapatan));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Unit Diagnostik Terpadu '.$tgl.' '.$ket_pasien;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_jml_tindakan() {
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');

		if($tampil == 'TGL') {
			$data['title'] = 'Laporan Jumlah Tindakan Elektromedik Berdasarkan DPJP '.date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tampil;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_jml_tindakan($date, $tampil)->result();
		} else if($tampil == 'BLN') {
			$data['title'] = 'Laporan Jumlah Tindakan Elektromedik Berdasarkan DPJP '.date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tampil;
			$data['list_tindakan'] = $this->Emmlaporan->get_list_jml_tindakan($month, $tampil)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Jumlah Tindakan Elektromedik Berdasarkan DPJP '.date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['list_tindakan'] = $this->Emmlaporan->get_list_jml_tindakan($tgl, 'TGL')->result();
		}

		$this->load->view('elektromedik/lapjml_tindakan', $data);
	}

	public function excel_jml_tindakan($date, $tampil) {
		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Tindakan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('DPJP');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('Ket DPJP');
		$sheet->mergeCells('E1:G1')
			->getCell('E1')
			->setValue('Kelompok Jaminan');
		$sheet->mergeCells('H1:H2')
			->getCell('H1')
			->setValue('Total');
		$sheet->setCellValue('E2', 'BPJS');
		$sheet->setCellValue('F2', 'UMUM');
		$sheet->setCellValue('G2', 'IKS');

		$data = $this->Emmlaporan->get_list_jml_tindakan($date, $tampil)->result();

		$no = 1;
		$x = 3;
		$bpjs = 0;
		$umum = 0;
		$iks = 0;
		$total_count = 0;

		foreach($data as $row) {
			$total = $row->bpjs + $row->umum + $row->iks;
			$bpjs += $row->bpjs;
			$umum += $row->umum;
			$iks += $row->iks;
			$total_count += $total;

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->tindakan);
			$sheet->setCellValue('C'.$x, $row->dokter);
			$sheet->setCellValue('D'.$x, $row->ket);
			$sheet->setCellValue('E'.$x, $row->bpjs);
			$sheet->setCellValue('F'.$x, $row->umum);
			$sheet->setCellValue('G'.$x, $row->iks);
			$sheet->setCellValue('H'.$x, $total);
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Grand Total');
		$sheet->mergeCells('A'.$x.':'.'D'.$x.'');
		$sheet->setCellValue('E'.$x, $bpjs);
		$sheet->setCellValue('F'.$x, $umum);
		$sheet->setCellValue('G'.$x, $iks);
		$sheet->setCellValue('H'.$x, $total_count);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Tindakan Elektromedik Berdasarkan DPJP '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
}
?>
