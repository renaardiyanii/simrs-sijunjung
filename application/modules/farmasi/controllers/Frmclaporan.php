<?php
defined('BASEPATH') or exit('No direct script access allowed');
//
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
//require_once(APPPATH.'controllers/Secure_area.php');
class Frmclaporan extends Secure_area
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ird/ModelPelayanan', '', TRUE);
		$this->load->model('ird/ModelRegistrasi', '', TRUE);
		$this->load->model('ird/ModelKwitansi', '', TRUE);
		$this->load->model('ird/ModelLaporan', '', TRUE);
		$this->load->model('master/mmobat', '', TRUE);
		$this->load->model('farmasi/Frmmlaporan', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		$this->load->model('admin/appconfig', '', TRUE);
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('farmasi/Frmcdaftar', 'refresh');
	}

	// public function data_kunjungan()
	// {
	// 	$data['title'] = 'Laporan Kunjungan Farmasi';
	// 	$data['gudang'] = $this->Frmmlaporan->get_gudang()->result();
	// }

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Farmasi';


		// $data['gudang'] = $this->frmmlaporan->get_gudang()->result();	

		$data['gudang'] = $this->Frmmlaporan->get_gudang()->result();

		//    $this->load->view('farmasi/frmvlapkunjunganrange.php',$data); 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//	$tgl_indo=new Tglindo();
			//$tgl_awal=$this->input->post('date_picker_days1');
			//if(){
			//}
			$tanggal = $this->input->post('tgl');
			//	var_dump($tanggal);die();
			$tgl = explode("-", $tanggal);
			$data['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
			$data['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
			$data['cara_bayar'] = $this->input->post('cara_bayar');
			$data['instalasi'] = $this->input->post('instalasi');

			//	print_r($data['instalasi']);die();


			$data['data_laporan_kunj'] = $this->Frmmlaporan->get_data_kunj_periode($data['tgl_awal'], $data['tgl_akhir'], $data['cara_bayar'], $data['instalasi'])->result();

			//	print_r($data['data_laporan_kunj']);die();

			$data['data_tindakan'] = $this->Frmmlaporan->get_data_tindakan_periode($data['tgl_awal'], $data['tgl_akhir'], $data['cara_bayar'], $data['instalasi'])->result();

			$tgl1 = date('d F Y', strtotime($data['tgl_awal'])) . " - " . date('d F Y', strtotime($data['tgl_akhir'])) . " - " . $this->input->post('cara_bayar') . " - " . $this->input->post('instalasi');
			$data['date_title'] = "<b> Kunjungan  $tgl1</b>";
			$data['field1'] = 'No. Medrec';
			$data['tgl'] = $tgl;

			$size = sizeof($data['data_laporan_kunj']);
			//$data['size']=$size;
			if ($size < 1) {
				//echo "hahahaha";
				$data['message_nodata'] = "<div class=\"content-header\">
					<div class=\"alert alert-danger alert-dismissable\">
						<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
					<h4><i class=\"icon fa fa-close\"></i>
						Tidak Ditemukan Data
					</h4>							
					</div>
				</div>";
				$data['size'] = '';
			} else {
				//echo "hahahahdwadawdwafawfeagageaga";
				$data['message_nodata'] = '';
				$data['size'] = $size;
			}

			$this->load->view('farmasi/frmvlapkunjunganrange', $data);
		} else {

			//	$data['gudang'] = $this->Frmmlaporan->get_gudang()->result();

			$data['data_laporan_kunj'] = $this->Frmmlaporan->get_data_kunj_periode(date('Y-m-d'), date('Y-m-d'), null)->result();
			$data['data_tindakan'] = $this->Frmmlaporan->get_data_tindakan_periode(date('Y-m-d'), date('Y-m-d'), null)->result();

			$data['date_title'] = 'Laporan Kunjungan Pasien Farmasi <b>' . date("d F Y") . '</b>';
			$data['tgl_awal'] = date("Y-m-d");
			$data['tgl_akhir'] = date("Y-m-d");
			$data['cara_bayar'] = "";
			$data['instalasi'] = "";
			$data['field1'] = 'No. Medrec';

			$size = sizeof($data['data_laporan_kunj']);

			if ($size < 1) {
				//
				$data['message_nodata'] = "<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size'] = '';
			} else {

				$data['message_nodata'] = '';
				$data['size'] = $size;
			}

			$this->load->view('farmasi/frmvlapkunjunganrange.php', $data);
		}
	}

	/*public function data_kunjungan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Kunjungan Farmasi';				

		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_tind_tgl($tgl)->result();
					$data['data_kunjungan']=$this->Frmmlaporan->get_data_keuangan_tgl($tgl)->result();
					$data['cara_bayar_pasien']="";
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;	
					}
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
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('farmasi/frmvlapkunjunganrange',$data);
		}*/


	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan()
	{
		$data['title'] = 'Laporan Pendapatan Farmasi';

		//$tgl_indo=new Tglindo();
		// if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$tampil_per=$this->input->post('tampil_per');			
		// 		if($tampil_per=='TGL'){
		// 			$tgl=$this->input->post('date_picker_days');
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();

		// 			$tgl1= date('d F Y', strtotime($tgl));

		// 			$data['date_title']="<b>$tgl1</b>";
		// 			$data['field1']='No. Register';
		// 			$data['tgl']=$tgl;
		// 			$data['cara_bayar_pasien']='';




		// 		}else if($tampil_per=='BLN'){
		// 			$bln=$this->input->post('date_picker_months');			
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien1');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien1');			

		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
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
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_thn($thn)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien2');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien2');		
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)->result();
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
		// 			//echo "hahahahdwadawdwafawfeagageaga";
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('farmasi/pend_today',$data);
		// }else{			
		// 	$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tindakan_today()->result();
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
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('farmasi/pend_today',$data);
		// 	//redirect('ird/IrDLaporan/data','refresh');
		// }
		$tgl = $this->input->post('tanggal_laporan');
		$id_gudang = $this->input->post('id_gudang');
		if ($tgl == null && $id_gudang == null) {
			// $data['date_title']='<b>'.date("d F Y").'</b>';
			$data['data_laporan'] = $this->Frmmlaporan->get_data_keu_tind_report('', '', '')->result();
			$data['tgl'] = date("Y-m-d");
		} elseif ($tgl == null && $id_gudang != null) {
			$data['data_laporan'] = $this->Frmmlaporan->get_data_keu_tind_report('', '', $id_gudang)->result();
			$data['tgl'] = date("Y-m-d");
		} else {
			$tgl_space = str_replace(' ', '', $tgl);
			$tgl_pisah = explode('-', $tgl_space);
			$tgl_awal =	date('Y-m-d', strtotime($tgl_pisah[0]));
			$tgl_akhir = date('Y-m-d', strtotime($tgl_pisah[1]));
			// var_dump($tgl_awal);

			if ($id_gudang == null) {
				$data['data_laporan'] = $this->Frmmlaporan->get_data_keu_tind_report($tgl_awal, $tgl_akhir, '')->result();
			} else {
				$data['data_laporan'] = $this->Frmmlaporan->get_data_keu_tind_report($tgl_awal, $tgl_akhir, $id_gudang)->result();
			}

			// $data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl'] = $tgl;
		}
		// var_dump($data['data_laporan']);
		// die();

		$data['gudang'] = $this->Frmmlaporan->get_all_gudang()->result();
		// $data['message_nodata']="<div class=\"content-header\">
		// 	<div class=\"alert alert-danger alert-dismissable\">
		// 		<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 	<h4><i class=\"icon fa fa-close\"></i>
		// 		Silahkan Pilih Jenis Bayar dan Tanggal Kemudian Download untuk Melihat Laporan Pendapatan.
		// 	</h4>							
		// 	</div>
		// </div>";

		$this->load->view('farmasi/frmvpendapatan', $data);
	}

	public function lap_keu($tampil_per = '', $param1 = '', $param2 = '')
	{
		$data['title'] = 'Laporan Keuangan Farmasi';

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		$cara_bayar = $param2;

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");

		$data_rs = $this->ModelKwitansi->getdata_rs('10000')->result();
		$namars = $this->config->item('namars');
		$kota_kab = $this->config->item('kota');
		$alamat = $this->config->item('alamat');
		$nmsingkat = $this->config->item('namasingkat');
		$tampil_per = $tampil;
		if ($tampil_per == 'TGL') {
			if ($param1 != '') {
				$tgl = $param1;
				$tgl1 = date('d F Y', strtotime($tgl));


				$date_title = '<b>' . $tgl1 . '</b>';
				$file_name = "KEU_FRM_$tgl1.pdf";

				$data_laporan_keu = $this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();

				$konten =
					"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\" align=\"left\"><b>No</b></td>
								<td width=\"50%\" align=\"center\"><b>Item Obat</b></td>
								<td width=\"10%\" align=\"center\"><b>Qty</b></td>
								<td width=\"35%\" align=\"center\"><b>Total</b></td>
							</tr>
						";
				$i = 1;
				$vtot2 = 0;
				foreach ($data_laporan_keu as $row) {
					$vtot2 = $vtot2 + $row->vtot;
					$konten = $konten . "
							<tr>
								<td>" . $i++ . "</td>
								<td>$row->nama_obat</td>
								<td><p align=\"center\">$row->qty</p></td>
								<td><p align=\"right\">" . number_format($row->vtot, 2, ',', '.') . "</p></td>
							</tr>";
				}
				$konten = $konten . "
							<tr>
								<th colspan=\"3\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot2, 2, ',', '.') . "</p></th>
							</tr>
						</table>
				"; //print_r($konten);
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
				$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH . 'download/farmasi/Frmlaporan/' . $file_name, 'FI');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
			}
		} else if ($tampil_per == 'BLN') {
			if ($param1 != '') {
				$bln = $param1;
				$bln1 = date('F Y', strtotime($bln));

				$date_title = '<b>' . $bln1 . '</b>';
				$file_name = "KEU_FRM_$bln1.pdf";

				if ($cara_bayar == '') {

					$data_periode = $this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
					$cara_bayar_pasien = 'Semua';
				} else {

					$data_periode = $this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
					$cara_bayar_pasien = $cara_bayar;
				}

				$konten =
					"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								<td width=\"13%\"><b>Cara Bayar</b></td>
								<td width=\"5%\">:</td>
								<td width=\"35%\">$cara_bayar_pasien</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Tanggal</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Obat</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
				$i = 1;
				$vtot = 0;
				foreach ($data_periode as $row) {
					//$vtot=$vtot+$row->total;
					if ($param2 != '') {
						$rwspn = count($this->Frmmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
					} else {
						$rwspn = count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
					}
					$rwspn1 = $rwspn + 1;
					$j = 1;
					$vtot1 = 0;
					foreach ($data_keuangan as $row2) {
						if ($row2->tgl == $row->tgl) {
							$vtot1 = $vtot1 + $row2->total;
							$vtot = $vtot + $row2->total;
							$konten = $konten . "
										<tr>";
							if ($j == '1') {
								$konten = $konten . "
											<td rowspan=\"$rwspn1\">" . $i++ . "</td>
											<td rowspan=\"$rwspn\">$row2->tgl</td>";
							}
							$konten = $konten . "
											<td>$row2->nama_obat</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">" . number_format($row2->total, 2, ',', '.') . "</td>
										</tr>";
							$j++;
						}
					}
					$konten = $konten . "
										<tr>
											<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">" . number_format($vtot1, 2, ',', '.') . "</p></th>
										</tr>";
				}
				$konten = $konten . "
							<tr>
								<th colspan=\"4\"><p align=\"right\"><b>Total $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot, 2, ',', '.') . "</p></th>
							</tr>
						</table>
				";
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
				$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH . 'download/farmasi/Frmlaporan/' . $file_name, 'FI');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
			}
		} else {
			if ($param1 != '') {
				$thn = $param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));

				$date_title = '<b>' . $thn1 . '</b>';
				$file_name = "KEU_FRM_$thn1.pdf";

				if ($cara_bayar == '') {
					$data_periode = $this->Frmmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
					$cara_bayar_pasien = 'Semua';
				} else {
					$data_periode = $this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
					$cara_bayar_pasien = $cara_bayar;
				}

				$konten =
					"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								<td width=\"13%\"><b>Cara Bayar</b></td>
								<td width=\"5%\">:</td>
								<td width=\"35%\">$cara_bayar_pasien</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Bulan</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Obat</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
				$i = 1;
				$vtot = 0;
				foreach ($data_periode as $row) {
					//$vtot=$vtot+$row->total;
					if ($param2 != '') {
						$rwspn = count($this->Frmmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
					} else {
						$rwspn = count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
					}

					$rwspn1 = $rwspn + 1;
					$j = 1;
					$vtot1 = 0;
					foreach ($data_keuangan as $row2) {
						if ($row2->bln == $row->bln) {
							$vtot1 = $vtot1 + $row2->total;
							$vtot = $vtot + $row2->total;
							$konten = $konten . "
										<tr>";
							if ($j == '1') {
								$konten = $konten . "
											<td rowspan=\"$rwspn1\">" . $i++ . "</td>
											<td rowspan=\"$rwspn\">$row2->bln</td>";
							}
							$konten = $konten . "
											<td>$row2->nama_obat</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">" . number_format($row2->total, 2, ',', '.') . "</td>
										</tr>";
							$j++;
						}
					}
					$konten = $konten . "
										<tr>
											<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">" . number_format($vtot1, 2, ',', '.') . "</p></th>
										</tr>";
				}
				$konten = $konten . "
							<tr>
								<th colspan=\"4\"><p align=\"right\"><b>Total $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot, 2, ',', '.') . "</p></th>
							</tr>
						</table>
				";
				//print_r($data_laporan_keu);
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
				$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH . 'download/farmasi/Frmlaporan/' . $file_name, 'FI');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
			}
		}
	}

	public function export_excel($tampil_per = '', $param1 = '', $param2 = '')
	{
		$data['title'] = 'Laporan Keuangan Farmasi';

		// $tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars = $this->config->item('namars');
		$kota_kab = $this->config->item('kota');
		$alamat = $this->config->item('alamat');
		$nmsingkat = $this->config->item('namasingkat');

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

		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$tampil_per = $tampil;
		if ($tampil_per == 'TGL') {
			if ($param1 != '') {
				$tgl = $param1;
				$tgl1 = date('d F Y', strtotime($tgl));


				$date_title = '<b>' . $tgl1 . '</b>';
				$file_name = "KEU_FRM_$tgl1.pdf";

				$data_laporan_keu = $this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();

				$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_farmasi_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : ' . $tgl1);
				$vtot1 = 0;
				$i = 1;
				$rowCount = 5;
				foreach ($data_laporan_keu as $row) {
					$vtot1 = $vtot1 + $row->vtot;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->nama_obat);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->vtot);
					$rowCount++;
					$i++;
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtot1);
				header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_TGL.xlsx"');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else if ($tampil_per == 'BLN') {
			if ($param1 != '') {
				$bln = $param1;
				$bln1 = date('F Y', strtotime($bln));

				$date_title = '<b>' . $bln1 . '</b>';
				$file_name = "KEU_FRM_$bln1.pdf";

				if ($param2 == '') {
					$data_periode = $this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
					$cara_bayar_pasien = 'Semua';
				} else {
					$data_periode = $this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
					$cara_bayar_pasien = $cara_bayar;
				}

				$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_farmasi_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : ' . $bln1);

				if ($param2 != '') {
					if ($param2 != 'BPJS') {
						$jenis_param2 = ucfirst(strtolower($param2));
					} else {
						$jenis_param2 = $param2;
					}
				} else {
					$jenis_param2 = "Semua";
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : ' . $jenis_param2);
				$rowCount = 5;
				$i = 1;
				$vtot = 0;
				foreach ($data_periode as $row) {
					//$vtot=$vtot+$row->total;
					$rwspn = count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
					$rwspn1 = $rwspn + 1;

					$j = 1;
					$vtot1 = 0;
					foreach ($data_keuangan as $row2) {
						if ($row2->tgl == $row->tgl) {
							$vtot1 = $vtot1 + $row2->total;
							$vtot = $vtot + $row2->total;
							if ($j == '1') {
								$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->tgl);
								$i++;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->nama_obat);
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah);
							$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->total);

							$j++;
							$rowCount++;
						}
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total', $date_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $vtot);

				header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_Bulan.xlsx"');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else {
			if ($param1 != '') {
				$thn = $param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));

				$date_title = '<b>' . $thn1 . '</b>';
				$file_name = "KEU_FRM_$thn1.pdf";

				if ($param2 == '') {
					$data_periode = $this->Frmmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
					$cara_bayar_pasien = 'Semua';
				} else {
					$data_periode = $this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan = $this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
					$cara_bayar_pasien = $cara_bayar;
				}

				$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_farmasi_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : ' . $thn);


				if ($param2 != '') {
					if ($param2 != 'BPJS') {
						$jenis_param2 = ucfirst(strtolower($param2));
					} else {
						$jenis_param2 = $param2;
					}
				} else {
					$jenis_param2 = "Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : ' . $jenis_param2);

				$rowCount = 6;
				$i = 1;
				$vtot = 0;
				foreach ($data_periode as $row) {
					//$vtot=$vtot+$row->total;
					$rwspn = count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
					$rwspn1 = $rwspn + 1;
					$j = 1;
					$vtot1 = 0;
					foreach ($data_keuangan as $row2) {
						if ($row2->bln == $row->bln) {

							$vtot = $vtot + $row2->total;

							if ($j == '1') {
								$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->bln);
								$i++;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->nama_obat);
							$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah);
							$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->total);

							$j++;
							$rowCount++;
						}
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total', $date_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_Tahun.xlsx"');
			} else {
				redirect('farmasi/Frmclaporan/data_pendapatan', 'refresh');
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

	public function download_keuangan($param1 = '', $param2 = '')
	{
		////EXCEL 
		// $this->load->library('Excel');  

		// Create new PHPExcel object  
		// $objPHPExcel = new PHPExcel();   
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set document properties  
		$spreadsheet->getProperties()->setCreator("RSU MMC")
			->setLastModifiedBy("RSU MMC")
			->setTitle("Laporan Keuangan RSU MMC")
			->setSubject("Laporan Keuangan RSU MMC Document")
			->setDescription("Laporan Keuangan RSU MMC, generated by HMIS.")
			->setKeywords("RSU MMC")
			->setCategory("Laporan Keuangan");

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");

		// $objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		//komen dulu
		// $data_keuangan=$this->Frmmlaporan->get_data_keu_tind($param1, $param2)->result();

		//    print_r($data_keuangan);die();

		// $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		// $objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);

		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getStyle('B3')->getFont()->setBold(true);

		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getStyle('C3')->getFont()->setBold(true);

		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getStyle('D3')->getFont()->setBold(true);

		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getStyle('E3')->getFont()->setBold(true);

		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getStyle('F3')->getFont()->setBold(true);

		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getStyle('G3')->getFont()->setBold(true);

		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getStyle('H3')->getFont()->setBold(true);

		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getStyle('I3')->getFont()->setBold(true);

		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getStyle('J3')->getFont()->setBold(true);

		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getStyle('K3')->getFont()->setBold(true);

		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->getStyle('L3')->getFont()->setBold(true);

		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getStyle('M3')->getFont()->setBold(true);

		// $sheet->getColumnDimension('N')->setAutoSize(true);
		// $sheet->getStyle('N3')->getFont()->setBold(true);
		// $sheet->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('O')->setAutoSize(true);
		// $sheet->getStyle('O3')->getFont()->setBold(true);
		// $sheet->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('P')->setAutoSize(true);
		// $sheet->getStyle('P3')->getFont()->setBold(true);
		// $sheet->getStyle('P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('Q')->setAutoSize(true);
		// $sheet->getStyle('Q3')->getFont()->setBold(true);
		// $sheet->getStyle('Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('R')->setAutoSize(true);
		// $sheet->getStyle('R3')->getFont()->setBold(true);
		// $sheet->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('S')->setAutoSize(true);
		// $sheet->getStyle('S3')->getFont()->setBold(true);
		// $sheet->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('T')->setAutoSize(true);
		// $sheet->getStyle('T3')->getFont()->setBold(true);
		// $sheet->getStyle('T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('U')->setAutoSize(true);
		// $sheet->getStyle('U3')->getFont()->setBold(true);
		// $sheet->getStyle('U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('V')->setAutoSize(true);
		// $sheet->getStyle('V3')->getFont()->setBold(true);
		// $sheet->getStyle('V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// $sheet->getColumnDimension('W')->setAutoSize(true);
		// $sheet->getStyle('W3')->getFont()->setBold(true);
		// $sheet->getStyle('W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->setAutoFilter('A3:K3');

		$sheet->SetCellValue('A1', "Laporan Pendapatan Farmasi Periode " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2)));
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->mergeCells('A1:W1');
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$i = 1;
		$total_pendapatan = 0;
		$total_diskon = 0;
		foreach ($data_keuangan as $row) {
			// $obat_racik = "";
			// if($row->racikan=="1"){
			// 	$data_racikan = $this->Frmmlaporan->get_data_racikan($row->id_resep_pasien)->result();
			// 	$n=1;
			// 	foreach ($data_racikan as $key) {
			// 		if($n==1){
			// 			$obat_racik = $key->nm_obat;
			// 		}else{
			// 			$obat_racik = $obat_racik."\n".$key->nm_obat;
			// 		}
			// 		$n++;
			// 	}
			// 	$sheet->SetCellValue('P'.$rowCount, $obat_racik);
			// 	$sheet->getStyle('P'.$rowCount)->getAlignment()->setWrapText(true);
			// }else{
			// 	$sheet->SetCellValue('P'.$rowCount, $row->obat);
			// }
			// $temp = $row->no_resep;
			//          $sub_total = (int) (100 * ceil($row->sub_total / 100));
			//          $total = $sub_total - $row->diskon;
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $row->asal);
			$sheet->SetCellValue('C' . $rowCount, $row->tgl_kunjungan);
			$sheet->SetCellValue('D' . $rowCount, $row->no_register);
			$sheet->SetCellValue('E' . $rowCount, $row->no_cm);
			$sheet->SetCellValue('F' . $rowCount, $row->nama);
			$sheet->SetCellValue('G' . $rowCount, $row->cara_bayar);
			$sheet->SetCellValue('H' . $rowCount, $row->nm_dokter);
			$sheet->SetCellValue('I' . $rowCount, $row->ruang_poli);
			$sheet->SetCellValue('J' . $rowCount, $row->nama_obat);
			$sheet->SetCellValue('K' . $rowCount, $row->qty);
			$sheet->SetCellValue('L' . $rowCount, $row->harga);
			$sheet->SetCellValue('M' . $rowCount, $row->vtot);

			//            $total_diskon += $row->diskon;
			//			$total_pendapatan += $sub_total;
			$i++;
			$rowCount++;
		}
		$filename = "Laporan Pendapatan Farmasi " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2));
		// $sheet->SetCellValue('U'.$rowCount, "Total : ");
		// $sheet->SetCellValue('V'.$rowCount, $total_diskon);
		// $sheet->SetCellValue('W'.$rowCount, $total_pendapatan);
		// $sheet->SetCellValue('V'.($rowCount+1), "Total Pendapatan : ");
		// $sheet->SetCellValue('W'.($rowCount+1), $total_pendapatan-$total_diskon);
		// header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  

		// Rename worksheet (worksheet, not filename)  
		$sheet->setTitle('RSU MMC');

		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean();

		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		// header('Content-type: application/vnd.ms-excel');  
		// header('Cache-Control: max-age=0');  


		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		// $objWriter->save('php://output');  
		// $this->SaveViaTempFile($objWriter);
	}

	public function download_keuangan_new($param1 = '', $param2 = '', $jenis)
	{
		////EXCEL
		$this->load->library('Excel');

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("RSU MMC")
			->setLastModifiedBy("RSU MMC")
			->setTitle("Laporan Keuangan RRSU MMC")
			->setSubject("Laporan Keuangan RSU MMC Document")
			->setDescription("Laporan Keuangan RSU MMC, generated by HMIS.")
			->setKeywords("RRSU MMC")
			->setCategory("Laporan Keuangan");

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		//$objPHPExcel = $objReader->load("project.xlsx");

		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		$dataresep = $this->Frmmlaporan->find_no_racik($param1, $param2, $jenis)->result();
		$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_farmasi.xlsx');
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('P3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('S3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('T3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('U3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('V3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('W3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A3:W3');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Farmasi Periode " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2)));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:W1');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$i = 1;
		$total_pendapatan = 0;
		$total_diskon = 0;
		$total_resep = 0;
		foreach ($dataresep as $resep) {

			$subtotal_resep = (int) (1000 * ceil($resep->subtotal / 1000));
			$total_resep += $subtotal_resep;
			//$rowCount++;

			$data_keuangan = $this->Frmmlaporan->get_data_keu_tind_new($resep->no_resep, $jenis)->result();
			foreach ($data_keuangan as $row) {
				$obat_racik = "";
				if ($row->racikan == "1") {
					$data_racikan = $this->Frmmlaporan->get_data_racikan($row->id_resep_pasien)->result();
					$n = 1;
					foreach ($data_racikan as $key) {
						if ($n == 1) {
							$obat_racik = $key->nm_obat;
						} else {
							$obat_racik = $obat_racik . "\n" . $key->nm_obat;
						}
						$n++;
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $obat_racik);
					$objPHPExcel->getActiveSheet()->getStyle('P' . $rowCount)->getAlignment()->setWrapText(true);
				} else {
					$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->obat);
				}
				if ($temp == $row->no_resep) {

					$total = $row->sub_total - $row->diskon;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->tgl_kunjungan);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->no_resep);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->no_kartu);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->no_kartu);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->pangkat);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->kesatuan);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->dokter);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->ruangan);
					$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->status);
					$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->harga);
					$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->jumlah);
					$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->total_obat);
					$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->tuslah);
					$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row->sub_total);
					$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->diskon);
					$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $total);
				} else {
					$temp = $row->no_resep;
					$total = $row->sub_total - $row->diskon;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->tgl_kunjungan);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->no_resep);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->no_kartu);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->no_kartu);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->pangkat);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->kesatuan);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->dokter);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->ruangan);
					$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->status);
					$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->harga);
					$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->jumlah);
					$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->total_obat);
					$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->tuslah);
					$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row->sub_total);
					$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->diskon);
					$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $total);

					$objPHPExcel->getActiveSheet()->getStyle('X' . $rowCount)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $subtotal_resep);
				}

				$total_diskon += $row->diskon;
				$total_pendapatan += $row->sub_total;
				$i++;
				$rowCount++;
			}
		}
		$filename = "Laporan Pendapatan Farmasi " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2));
		$objPHPExcel->getActiveSheet()->getStyle('V' . ($rowCount + 1))->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('V' . ($rowCount + 1), "Total Pendapatan : ");
		$objPHPExcel->getActiveSheet()->getStyle('W' . ($rowCount + 1))->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('W' . ($rowCount + 1), $total_resep);
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');

		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('RSU MMC');

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

	static function SaveViaTempFile($objWriter)
	{
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}


	// public function lap_penjualan_farmasi($tgl_awal,$tgl_alhir,$cara_bayar,$instalasi)
	public function lap_penjualan_farmasi($tgl_awal, $tgl_akhir, $cara_bayar, $instalasi)
	{
		// $mpdf = new \Mpdf\Mpdf();

		//  $tanggal=$this->input->post('tgl');	
		//var_dump($tgl_akhir);die();
		//  $tgl = explode("-", $tanggal);
		//  $data['tgl_awal']=date('Y-m-d', strtotime($tgl[0]));
		//  $data['tgl_akhir']=date('Y-m-d', strtotime($tgl[1]));
		//  $data['cara_bayar']=$this->input->post('cara_bayar');
		//  $data['instalasi']=$this->input->post('instalasi');



		$data['data_laporan_kunj'] = $this->Frmmlaporan->get_data_kunj_periode($tgl_awal, $tgl_akhir, $cara_bayar, $instalasi)->result();
		//    var_dump( $data['data_laporan_kunj']);die();
		$data['data_tindakan'] = $this->Frmmlaporan->get_data_tindakan_periode($tgl_awal, $tgl_akhir, $cara_bayar, $instalasi)->result();
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$nama_gudang = $this->Frmmlaporan->get_nama_gudang($instalasi)->row();
		// var_dump($data['nama_gudang']);die();
		$tgl1 = date('d/m/Y', strtotime($data['tgl_awal'])) . " - " . date('d/m/Y', strtotime($data['tgl_akhir'])) . " - " . $cara_bayar . " - " . $nama_gudang->nama_gudang;
		$data['date_title'] = "<b> Laporan Penjualan Farmasi $tgl1 </b>";
		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		//  $data['field1']='No. Medrec';					
		//  $data['tgl']=$tgl;

		//  $size = sizeof($data['data_laporan_kunj']);
		//  //$data['size']=$size;
		//  if($size<1){
		//  //echo "hahahaha";
		//  $data['message_nodata']="<div class=\"content-header\">
		// 	 <div class=\"alert alert-danger alert-dismissable\">
		// 		 <button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 	 <h4><i class=\"icon fa fa-close\"></i>
		// 		 Tidak Ditemukan Data
		// 	 </h4>							
		// 	 </div>
		//  </div>";
		//  $data['size']='';
		//  }else{
		// 	 //echo "hahahahdwadawdwafawfeagageaga";
		// 	 $data['message_nodata']='';
		// 	 $data['size']=$size;
		//  }

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		$html = $this->load->view('farmasi/paper_css/vlappenjualanfarmasi', $data, true);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	/**
	 * Added @aldi
	 * Pembuatan Modules Rekap Pendapatan Apotik Rawat Jalan
	 * 15/11/2022
	 */

	function menu_rekap_pendapatan_apotikrajal2()
	{
		$this->load->view(
			'farmasi/laporan/rekap_pendapatan_apotik_rajal',
			[
				'title' => 'Rekap Pendapatan Apotik Rawat Jalan'
			]
		);
	}



	function rekap_pendapatan_apotik_rajal2()
	{
		$bulan = $this->input->get('bulan');
		$carabayar = $this->input->get('carabayar');
		$pelayanan = $this->input->get('pelayanan');
		$json = $this->input->get('json');

		$data = $this->Frmmlaporan->rekap_pendapatan_apotik($bulan, $carabayar, $pelayanan);
		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "Rekap Pendapatan " . $carabayar . " Apotik Rawat Jalan" . date('F Y', strtotime($bulan)));
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->mergeCells('A1:I1');
		$sheet->SetCellValue('A3', 'Tgl');
		$sheet->SetCellValue('B3', 'Jumlah R/');
		$sheet->SetCellValue('C3', 'Jumlah Lembar R/');
		$sheet->SetCellValue('D3', 'Nilai R/');
		$sheet->SetCellValue('E3', 'Nilai -R');
		$sheet->SetCellValue('F3', 'Nilai +R');
		$rowCount = 4;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $v->tgl_kunjungan);
			$sheet->SetCellValue('B' . $rowCount, $v->jmlr);
			$sheet->SetCellValue('C' . $rowCount, $v->jmllr);
			$sheet->SetCellValue('D' . $rowCount, 'Rp. ' . number_format($v->nilair));
			$sheet->SetCellValue('E' . $rowCount, 'Rp. ' . number_format($v->nilairmin));
			$sheet->SetCellValue('F' . $rowCount, 'Rp. ' . number_format($v->nilaiall));
			$rowCount++;
		}
		$filename = "Rekap Pendapatan " . $carabayar . " Apotik Rawat Jalan" . date('F Y', strtotime($param1));

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function menu_laporan_pemakaian_obat()
	{
		$this->load->view(
			'farmasi/laporan/laporan_pemakaian_obat_per_dokter',
			[
				'title' => 'Laporan Pemakaian Obat Per Dokter'
			]
		);
	}

	function laporan_pemakaian_obat_per_dokter()
	{
		$tgl_pertama = $this->input->get('tgl_pertama');
		$tgl_kedua = $this->input->get('tgl_kedua');
		$pelayanan = $this->input->get('pelayanan');
		$json = $this->input->get('json');
		$data = $this->Frmmlaporan->laporan_pemakaian_obat_per_dokter($tgl_pertama, $tgl_kedua, $pelayanan)->result();

		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "LAPORAN PEMAKAIAN OBAT PER DOKTER ");
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->SetCellValue('A2', "DEPO RAWAT JALAN UMUM");
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A2')->getFont()->setSize(16);
		$sheet->mergeCells('A2:I2');
		$sheet->SetCellValue('A3', "Tanggal $tgl_pertama Sampai $tgl_kedua");
		$sheet->getStyle('A3')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setSize(16);
		$sheet->mergeCells('A3:I3');
		$sheet->SetCellValue('A4', 'No.');
		$sheet->SetCellValue('B4', 'No. Register');
		$sheet->SetCellValue('C4', 'No. RM');
		$sheet->SetCellValue('D4', 'Nama');
		$sheet->SetCellValue('E4', 'Nama Poli');
		$sheet->SetCellValue('F4', 'Nama Dokter');

		$sheet->SetCellValue('G4', 'Order Resep');
		$sheet->SetCellValue('H4', 'Verifikasi Farmasi');
		$sheet->SetCellValue('I4', 'Telaah Obat');
		$sheet->SetCellValue('J4', 'Selesai Pemeriksaan');

		$sheet->SetCellValue('K4', 'Non Fornas');
		$sheet->SetCellValue('L4', 'Jlh r/');
		$sheet->SetCellValue('M4', 'Biaya Obat');
		$sheet->SetCellValue('N4', 'Diskon');
		$sheet->SetCellValue('O4', 'JP');
		$sheet->SetCellValue('P4', 'Total');
		$rowCount = 6;
		$i = 1;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $v->no_register);
			$sheet->SetCellValue('C' . $rowCount, $v->no_medrec);
			$sheet->SetCellValue('D' . $rowCount, $v->nama);
			$sheet->SetCellValue('E' . $rowCount, $v->namapoli);
			$sheet->SetCellValue('F' . $rowCount, $v->namadokter);
			$sheet->SetCellValue('G' . $rowCount, $v->nfornas);

			$sheet->SetCellValue('H' . $rowCount, $v->waktu_resep_dokter);
			$sheet->SetCellValue('I' . $rowCount, $v->waktu_farmasi_verif);
			$sheet->SetCellValue('J' . $rowCount, $v->waktu_telaah_obat);
			$sheet->SetCellValue('K' . $rowCount, $v->waktu_selesai_farmasi);

			$sheet->SetCellValue('L' . $rowCount, $v->jlhr);
			$sheet->SetCellValue('M' . $rowCount, 'Rp. ' . number_format($v->biaya_obat));
			$sheet->SetCellValue('N' . $rowCount, 'Rp. ' . number_format($v->diskon));
			$sheet->SetCellValue('O' . $rowCount, 'Rp. ' . number_format($v->jp));
			$sheet->SetCellValue('P' . $rowCount, 'Rp. ' . number_format($v->totalbiaya));
			$rowCount++;
			$i++;
		}
		$filename = "Laporan Pemakaian Obat Per Dokter Depo Rawat Jalan Umum " . $tgl_pertama . ' Sampai ' . $tgl_kedua;

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function menu_rekap_pendapatan_apotikrajal()
	{
		$this->load->view(
			'farmasi/laporan/rekap_pendapatan_apotik_rajal2',
			[
				'title' => 'Rekap Pendapatan Apotik Rawat Jalan',
				'poli' => $this->Frmmlaporan->data_poli()->result()
			]
		);
	}

	function menu_rekap_pendapatan_apotikranap()
	{
		$this->load->view(
			'farmasi/laporan/rekap_pendapatan_apotik_ranap',
			[
				'title' => 'Rekap Pendapatan Apotik Rawat Inap',
				'ruang' => $this->Frmmlaporan->data_ruangan()->result()
			]
		);
	}



	function rekap_pendapatan_apotik_rajal()
	{
		$bulan = $this->input->get('bulan');
		$carabayar = $this->input->get('carabayar');
		$idrg = $this->input->get('idrg');
		$asuransi = $this->input->get('asuransi');
		// var_dump($asuransi);die();
		$json = $this->input->get('json');

		$data = $this->Frmmlaporan->rekap_pendapatan_apotik_rajal2($bulan, $carabayar, $idrg,$asuransi);
		if($asuransi != 'semua'){
			$nama_asuransi = $this->Frmmlaporan->nama_asuransi($asuransi)->row()->nmkontraktor;
		}else{
			$nama_asuransi = '';
		}
		

		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "Rekap Pendapatan " . $carabayar . " Apotik Rawat Jalan" . date('F Y', strtotime($bulan)) . ' ' . $nama_asuransi);
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->mergeCells('A1:I1');
		$sheet->SetCellValue('A3', 'Tgl');
		$sheet->SetCellValue('B3', 'Jumlah R/');
		$sheet->SetCellValue('C3', 'Jumlah Lembar R/');
		$sheet->SetCellValue('D3', 'Nilai R/');
		$sheet->SetCellValue('E3', 'Nilai -R');
		$sheet->SetCellValue('F3', 'Nilai +R');
		$rowCount = 4;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $v->tgl_kunjungan);
			$sheet->SetCellValue('B' . $rowCount, $v->jmlr);
			$sheet->SetCellValue('C' . $rowCount, $v->jmllr);
			$sheet->SetCellValue('D' . $rowCount, $v->nilair);
			$sheet->SetCellValue('E' . $rowCount, $v->nilairmin);
			$sheet->SetCellValue('F' . $rowCount, $v->nilaiall);
			$rowCount++;
		}
		$filename = "Rekap Pendapatan " . $carabayar . " Apotik Rawat Jalan" . date('F Y', strtotime($bulan)) . ' ' . $nama_asuransi;

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function rekap_pendapatan_apotik_ranap()
	{
		$bulan = $this->input->get('bulan');
		$carabayar = $this->input->get('carabayar');
		$idrg = $this->input->get('idrg');
		$json = $this->input->get('json');

		$data = $this->Frmmlaporan->rekap_pendapatan_apotik_ranap($bulan, $carabayar, $idrg);
		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "Rekap Pendapatan " . $carabayar . " Apotik Rawat Inap" . date('F Y', strtotime($bulan)));
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->mergeCells('A1:I1');
		$sheet->SetCellValue('A3', 'Tgl');
		$sheet->SetCellValue('B3', 'Jumlah R/');
		$sheet->SetCellValue('C3', 'Jumlah Lembar R/');
		$sheet->SetCellValue('D3', 'Nilai R/');
		$sheet->SetCellValue('E3', 'Nilai -R');
		$sheet->SetCellValue('F3', 'Nilai +R');
		$rowCount = 4;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $v->tgl_kunjungan);
			$sheet->SetCellValue('B' . $rowCount, $v->jmlr);
			$sheet->SetCellValue('C' . $rowCount, $v->jmllr);
			$sheet->SetCellValue('D' . $rowCount, 'Rp. ' . number_format($v->nilair));
			$sheet->SetCellValue('E' . $rowCount, 'Rp. ' . number_format($v->nilairmin));
			$sheet->SetCellValue('F' . $rowCount, 'Rp. ' . number_format($v->nilaiall));
			$rowCount++;
		}
		$filename = "Rekap Pendapatan " . $carabayar . " Apotik Rawat Jalan" . date('F Y', strtotime($param1));

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function menu_laporan_pemakaian_obat_rajal()
	{
		$this->load->view(
			'farmasi/laporan/laporan_pemakaian_obat_per_dokter_rajal',
			[
				'title' => 'Laporan Pemakaian Obat Per Dokter Rawat Jalan',
				'poli' => $this->Frmmlaporan->data_poli()->result()
			]
		);
	}

	function menu_laporan_pemakaian_obat_rajal_perperiodic()
	{
		$this->load->view(
			'farmasi/laporan/menu_laporan_pemakaian_obat_rajal_perperiodic',
			[
				'title' => 'Laporan Pemakaian Obat ',
				'poli' => $this->Frmmlaporan->data_poli()->result(),
				'subkel' => $this->mmobat->get_data_subkelompok_obat()->result()
			]
		);
	}

	function laporan_pemakaian_obat_rajal_perperiodic()
	{
		// var_dump($this->input->get());die();
		$tgl_pertama = $this->input->get('tgl_pertama');
		$tgl_kedua = $this->input->get('tgl_kedua');
		$subkel = $this->input->get('subkel');
		$get_subkel = $this->Frmmlaporan->nama_subkel($subkel)->row();
		$json = $this->input->get('json');
		$data = $this->Frmmlaporan->laporan_pemakaian_obat_per_periodic($tgl_pertama, $tgl_kedua,$subkel)->result();
		// $data_subkelompok = $this->Frmmlaporan->get_all_subkelompok_obat_per_periodic($tgl_pertama, $tgl_kedua)->result();
		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(['data' => $data]);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "LAPORAN PEMAKAIAN OBAT ");
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->SetCellValue('A2', "DEPO RAWAT JALAN UMUM");
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A2')->getFont()->setSize(16);
		$sheet->mergeCells('A2:I2');
		$sheet->SetCellValue('A3', "Tanggal $tgl_pertama Sampai $tgl_kedua");
		$sheet->getStyle('A3')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setSize(16);
		$sheet->mergeCells('A3:I3');
		$sheet->SetCellValue('A4', 'No.');
		$sheet->SetCellValue('B4', 'Nama Obat');
		$sheet->SetCellValue('C4', 'Jumlah Terpakai');
		$rowCount = 6;
		$i = 1;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $v->nm_obat);
			$sheet->SetCellValue('C' . $rowCount, $v->total_pemakaian);
			$rowCount++;
			$i++;
		}
		
		$filename = "Laporan Pemakaian Obat  " . $tgl_pertama . ' Sampai ' . $tgl_kedua .' ' . $get_subkel->bentuk_sediaan;

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}


	function menu_laporan_pemakaian_obat_ranap()
	{
		$this->load->view(
			'farmasi/laporan/laporan_pemakaian_obat_per_dokter_ranap',
			[
				'title' => 'Laporan Pemakaian Obat Per Dokter Rawat Inap',
				'ruang' => $this->Frmmlaporan->data_ruangan()->result(),
				'gudang' => $this->Frmmlaporan->data_gudang_ri()->result()
			]
		);
	}



	function laporan_pemakaian_obat_per_dokter_rajal()
	{
		// var_dump($this->input->get());die();
		$tgl_pertama = $this->input->get('tgl_pertama');
		$tgl_kedua = $this->input->get('tgl_kedua');
		$idrg = $this->input->get('idrg');
		$json = $this->input->get('json');
		$data = $this->Frmmlaporan->laporan_pemakaian_obat_per_dokter_rajal($tgl_pertama, $tgl_kedua, $idrg)->result();
		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "LAPORAN PEMAKAIAN OBAT PER DOKTER ");
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->SetCellValue('A2', "DEPO RAWAT JALAN UMUM");
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A2')->getFont()->setSize(16);
		$sheet->mergeCells('A2:I2');
		$sheet->SetCellValue('A3', "Tanggal $tgl_pertama Sampai $tgl_kedua");
		$sheet->getStyle('A3')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setSize(16);
		$sheet->mergeCells('A3:I3');
		$sheet->SetCellValue('A4', 'No.');
		$sheet->SetCellValue('B4', 'No. Register');
		$sheet->SetCellValue('C4', 'No. RM');
		$sheet->SetCellValue('D4', 'Nama');
		$sheet->SetCellValue('E4', 'Nama Poli');
		$sheet->SetCellValue('F4', 'Cara Bayar');
		$sheet->SetCellValue('G4', 'Nama Asuransi');
		$sheet->SetCellValue('H4', 'Nama Dokter');

		$sheet->SetCellValue('I4', 'Order Resep');
		$sheet->SetCellValue('J4', 'Verifikasi Farmasi');
		$sheet->SetCellValue('K4', 'Telaah Obat');
		$sheet->SetCellValue('L4', 'Selesai Pemeriksaan');
		$sheet->SetCellValue('M4', 'Non Fornas');
		$sheet->SetCellValue('N4', 'Fornas');
		$sheet->SetCellValue('O4', 'Jlh r/');
		$sheet->SetCellValue('P4', 'Biaya Obat');
		$sheet->SetCellValue('Q4', 'Diskon');
		$sheet->SetCellValue('R4', 'JP');
		$sheet->SetCellValue('S4', 'Total');
		$rowCount = 6;
		$i = 1;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $v->no_register);
			$sheet->SetCellValue('C' . $rowCount, $v->no_medrec);
			$sheet->SetCellValue('D' . $rowCount, $v->nama);
			$sheet->SetCellValue('E' . $rowCount, $v->namapoli);
			$sheet->SetCellValue('F' . $rowCount, $v->cara_bayar);
			$sheet->SetCellValue('G' . $rowCount, $v->cara_bayar == 'BPJS'?'-':$v->nmkontraktor);
			$sheet->SetCellValue('H' . $rowCount, $v->namadokter);
			

			$sheet->SetCellValue('I' . $rowCount, $v->waktu_resep_dokter);
			$sheet->SetCellValue('J' . $rowCount, $v->waktu_farmasi_verif);
			$sheet->SetCellValue('K' . $rowCount, $v->waktu_telaah_obat);
			$sheet->SetCellValue('L' . $rowCount, $v->waktu_selesai_farmasi);

			$sheet->SetCellValue('M' . $rowCount, $v->fornas);
			$sheet->SetCellValue('N' . $rowCount, $v->nfornas);
			

			$sheet->SetCellValue('O' . $rowCount, $v->jlhr);
			$sheet->SetCellValue('P' . $rowCount, $v->biaya_obat);
			$sheet->SetCellValue('Q' . $rowCount, $v->diskon);
			$sheet->SetCellValue('R' . $rowCount, $v->jp);
			$sheet->SetCellValue('S' . $rowCount, $v->totalbiaya);
			$rowCount++;
			$i++;
		}
		$filename = "Laporan Pemakaian Obat Per Dokter Depo Rawat Jalan Umum " . $tgl_pertama . ' Sampai ' . $tgl_kedua;

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function laporan_pemakaian_obat_per_dokter_ranap()
	{
		$tgl_pertama = $this->input->get('tgl_pertama');
		$tgl_kedua = $this->input->get('tgl_kedua');
		$idrg = $this->input->get('idrg');
		$json = $this->input->get('json');
		$data = $this->Frmmlaporan->laporan_pemakaian_obat_per_dokter_ranap_new($tgl_pertama, $tgl_kedua, $idrg)->result();

		if ($json != '') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
			return;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "LAPORAN PEMAKAIAN OBAT PER DOKTER ");
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->SetCellValue('A2', "DEPO RAWAT INAP");
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A2')->getFont()->setSize(16);
		$sheet->mergeCells('A2:I2');
		$sheet->SetCellValue('A3', "Tanggal $tgl_pertama Sampai $tgl_kedua");
		$sheet->getStyle('A3')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setSize(16);
		$sheet->mergeCells('A3:I3');
		$sheet->SetCellValue('A4', 'No.');
		$sheet->SetCellValue('B4', 'No. Register');
		$sheet->SetCellValue('C4', 'No. RM');
		$sheet->SetCellValue('D4', 'Nama');
		$sheet->SetCellValue('E4', 'Nama Poli');
		$sheet->SetCellValue('F4', 'Nama Dokter');

		$sheet->SetCellValue('G4', 'Order Resep');
		$sheet->SetCellValue('H4', 'Verifikasi Farmasi');
		$sheet->SetCellValue('I4', 'Telaah Obat');
		$sheet->SetCellValue('J4', 'Selesai Pemeriksaan');

		$sheet->SetCellValue('K4', 'Non Fornas');
		$sheet->SetCellValue('L4', 'Fornas');
		$sheet->SetCellValue('M4', 'Jlh r/');
		$sheet->SetCellValue('N4', 'Biaya Obat');
		$sheet->SetCellValue('O4', 'Diskon');
		$sheet->SetCellValue('P4', 'JP');
		$sheet->SetCellValue('Q4', 'Total');
		$rowCount = 6;
		$i = 1;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $v->no_register);
			$sheet->SetCellValue('C' . $rowCount, $v->no_medrec);
			$sheet->SetCellValue('D' . $rowCount, $v->nama);
			$sheet->SetCellValue('E' . $rowCount, $v->namapoli);
			$sheet->SetCellValue('F' . $rowCount, $v->namadokter);



			$sheet->SetCellValue('G' . $rowCount, $v->waktu_resep_dokter);
			$sheet->SetCellValue('H' . $rowCount, $v->waktu_resep_dokter);
			$sheet->SetCellValue('I' . $rowCount, $v->waktu_farmasi_verif);
			$sheet->SetCellValue('J' . $rowCount, $v->waktu_telaah_obat);
			$sheet->SetCellValue('K' . $rowCount, $v->nfornas);
			$sheet->SetCellValue('L' . $rowCount, $v->fornas);

			$sheet->SetCellValue('M' . $rowCount, $v->jlhr);
			$sheet->SetCellValue('N' . $rowCount, 'Rp. ' . number_format($v->biaya_obat));
			$sheet->SetCellValue('O' . $rowCount, 'Rp. ' . number_format($v->diskon));
			$sheet->SetCellValue('P' . $rowCount, 'Rp. ' . number_format($v->jp));
			$sheet->SetCellValue('Q' . $rowCount, 'Rp. ' . number_format($v->totalbiaya));
			$rowCount++;
			$i++;
		}
		$filename = "Laporan Pemakaian Obat Per Dokter Depo Rawat Inap " . $tgl_pertama . ' Sampai ' . $tgl_kedua;

		// $sheet->setTitle('RSU MMC');    

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function view_data_penyerahan_obat()
	{

		//bikin object buat penanggalan
		$data_post = $this->input->post();
		if ($data_post == null) {
			$tgl_awal = date('Y-m-d');
			$tgl_akhir = date('Y-m-d');
		} else {
			$tgl_awal = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');
		}
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan'] = $this->Frmmlaporan->data_penyerahan_obat($tgl_awal, $tgl_akhir)->result();
		$this->load->view('farmasi/laporan/list_penyerahan_obat', $data);
	}

	function excel_penyerahan_obat($tgl1, $tgl2)
	{

		$data = $this->Frmmlaporan->data_penyerahan_obat($tgl1, $tgl2)->result();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->SetCellValue('A1', "DATA PENYERAHAN OBAT RAWAT JALAN ");
		// $sheet->getStyle('A1')->getFont()->setBold(true);
		// $sheet->getStyle('A1')->getFont()->setSize(16);
		$sheet->SetCellValue('A4', 'No.');
		$sheet->SetCellValue('B4', 'Tgl Kunjungan');
		$sheet->SetCellValue('C4', 'No. RM');
		$sheet->SetCellValue('D4', 'Nama');
		$sheet->SetCellValue('E4', 'Jenis Kelamin');
		$sheet->SetCellValue('F4', 'Alamat');

		$sheet->SetCellValue('G4', 'No HP');
		$sheet->SetCellValue('H4', 'Ruang');
		$sheet->SetCellValue('I4', 'Jaminan');
		$sheet->SetCellValue('J4', 'Waktu Resep Dokter');

		$sheet->SetCellValue('K4', 'Waktu Telaah Obat');
		$sheet->SetCellValue('L4', 'Waktu Dispensing Obat');
		$sheet->SetCellValue('M4', 'Waktu Penyerahan Obat');
		$sheet->SetCellValue('N4', 'WTOJ');
		$rowCount = 6;
		$i = 1;
		foreach ($data as $v) {
			$sheet->SetCellValue('A' . $rowCount, $i);
			$sheet->SetCellValue('B' . $rowCount, $v->tgl_kunjungan);
			$sheet->SetCellValue('C' . $rowCount, $v->no_cm);
			$sheet->SetCellValue('D' . $rowCount, $v->nama);
			$sheet->SetCellValue('E' . $rowCount, $v->sex);
			$sheet->SetCellValue('F' . $rowCount, $v->alamat);
			$sheet->SetCellValue('G' . $rowCount, $v->no_hp);
			$sheet->SetCellValue('H' . $rowCount, $v->nm_poli);
			$sheet->SetCellValue('I' . $rowCount, $v->cara_bayar);
			$sheet->SetCellValue('J' . $rowCount, date('h:i:s', strtotime($v->waktu_resep_dokter)));
			$sheet->SetCellValue('K' . $rowCount, date('h:i:s', strtotime($v->wkt_telaah_obat)));
			$sheet->SetCellValue('L' . $rowCount, date('h:i:s', strtotime($v->wkt_dispensing_obat)));
			$sheet->SetCellValue('M' . $rowCount, date('h:i:s', strtotime($v->wkt_penyerahan_obat)));

			if ($v->waktu_resep_dokter != null && $v->wkt_penyerahan_obat != null) {
				$waktu_order = date_create($v->waktu_resep_dokter);
				$waktu_penyerahan_obat = date_create($v->wkt_penyerahan_obat);
				$diff = date_diff($waktu_penyerahan_obat, $waktu_order);
				$wtoj =  date('H:i:s', strtotime($diff->h . ':' . $diff->i . ':' . $diff->s));
			} else {
				$wtoj = '';
			}

			$sheet->SetCellValue('N' . $rowCount, $wtoj);


			$rowCount++;
			$i++;
		}
		$filename = "Laporan Data Penyerahan Obat Rawat Jalan " . $tgl1 . ' Sampai ' . $tgl2;

		// ob_end_clean();  
		$writer = new Xlsx($spreadsheet);

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
