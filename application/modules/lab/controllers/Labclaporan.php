 <?php
	defined('BASEPATH') or exit('No direct script access allowed');
	//
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set("Asia/Jakarta");
	//include(dirname(dirname(__FILE__)).'/Tglindo.php');
	//require_once(APPPATH.'controllers/Secure_area.php');
	class Labclaporan extends Secure_area
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('tgl_indo');
			$this->load->model('ird/ModelKwitansi', '', TRUE);
			$this->load->model('lab/Labmlaporan', '', TRUE);
			$this->load->helper('pdf_helper');
			$this->load->helper('url');
			// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
			//include(site_url('/application/controllers/Tglindo.php'));
			//echo site_url('/application/controllers/Tglindo.php');
		}
		public function index()
		{
			redirect('lab/Labcdaftar', 'refresh');
		}

		public function lap_pemeriksaan()
		{
			$data['title'] = 'Laporan Pemeriksaan Laboratorium';
			//$date0=$this->input->post('date0');
			//$date1=$this->input->post('date1');

			$this->load->view('lab/labvlappemeriksaanrange', $data);
		}

		function showlap_pemeriksaan($date0 = '', $date1 = '')
		{
			$line  = array();
			$line2 = array();
			$row2  = array();
			if ($date0 == '' && $date1 == '') {
				$date0 = date('Y-m-d', strtotime('-7 days'));
				$date1 = date('Y-m-d');
			}
			//$data['tglawal']=date('d F Y',strtotime($date0));
			//$data['tglakhir']=date('d F Y',strtotime($date1));
			$hasil = $this->Labmlaporan->get_lap_pemeriksaan($date0, $date1)->result();
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
			$data['title'] = 'Laporan Kunjungan Pemeriksaan Laboratorium';
			$data['pemeriksaan_title'] = "Laporan per Pemeriksaan :";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$tampil_per = $this->input->post('tampil_per');
				//$tgl_indo=new Tglindo();
				if ($tampil_per == 'TGL') {
					//$tgl_awal=$this->input->post('date_picker_days1');
					//if(){
					//}
					$tgl = $this->input->post('date_picker_days');

					$data['data_laporan_kunj'] = $this->Labmlaporan->get_data_kunj_by_date($tgl)->result();
					$data['data_tindakan'] = $this->Labmlaporan->get_data_tindakan_tgl($tgl)->result();
					$data['data_pemeriksaan'] = $this->Labmlaporan->get_data_pemeriksaan_tgl($tgl)->result();
					$tgl1 = date('d F Y', strtotime($tgl));
					$data['date_title'] = "Laporan Kunjungan Pasien Laboratorium <b>$tgl1</b>";
					$data['field1'] = 'No. Medrec';
					$data['tgl'] = $tgl;
				} else if ($tampil_per == 'BLN') {
					$bln = $this->input->post('date_picker_months');


					//echo $this->input->post('date_picker_months');

					$data['data_laporan_kunj'] = $this->Labmlaporan->get_data_kunj_bln($bln)->result();
					$data['data_tindakan'] = $this->Labmlaporan->get_data_tindakan_bln($bln)->result();
					$data['data_pemeriksaan'] = $this->Labmlaporan->get_data_pemeriksaan_bln($bln)->result();

					$bln1 = date('F Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $bln2;
					$data['date_title'] = "Laporan Kunjungan Pasien Laboratorium per Hari <b>Bulan $bln3</b>";
					$data['pemeriksaan_title'] = "Laporan Pemeriksaan :";
					$data['field1'] = 'Tanggal';
					$data['date'] = $bln; //untuk param waktu cetak
					$data['bln'] = $bln;
					//print_r($bln2);
				} else {
					$thn = $this->input->post('date_picker_years');
					$data['data_laporan_kunj'] = $this->Labmlaporan->get_data_kunj_thn($thn)->result();
					$data['data_tindakan'] = $this->Labmlaporan->get_data_tindakan_thn($thn)->result();
					$data['data_pemeriksaan'] = $this->Labmlaporan->get_data_pemeriksaan_thn($thn)->result();

					$data['date_title'] = "Laporan Kunjungan Pasien Laboratorium <b>Tahun $thn</b>";
					$data['pemeriksaan_title'] = "Laporan Pemeriksaan :";
					$data['field1'] = 'Bulan';
					$data['date'] = $thn; //untuk param waktu cetak
					$data['thn'] = $thn;
					// $data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per'] = $this->input->post('tampil_per'); //untuk param waktu cetak

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

				$this->load->view('lab/labvlapkunjunganrange.php', $data);
			} else {
				$data['data_laporan_kunj'] = $this->Labmlaporan->get_data_kunj_today()->result();
				$data['data_tindakan'] = $this->Labmlaporan->get_data_tindakan()->result();
				$data['data_pemeriksaan'] = $this->Labmlaporan->get_data_pemeriksaan()->result();
				$data['date_title'] = 'Laporan Kunjungan Pasien Laboratorium <b>' . date("d F Y") . '</b>';
				$data['tgl'] = date("Y-m-d");
				$data['field1'] = 'No. Medrec';
				$data['tampil_per'] = 'TGL';

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

				$this->load->view('lab/labvlapkunjunganrange.php', $data);
			}
		}

		///////////////////////////////////////////////////////////////////////////// PENDAPATAN

		public function data_pendapatan($tampil_per = '', $param1 = '')
		{
			$data['title'] = 'Laporan Pendapatan Penunjang Laboratorium';

			// $tgl_indo=new Tglindo();

			$data['date_title'] = '<b>' . date("d F Y") . '</b>';
			$data['tgl'] = date("Y-m-d");

			$data['message_nodata'] = "<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pendapatan.
			</h4>							
			</div>
		</div>";

			$this->load->view('lab/labvpendapatan', $data);
		}

		public function lap_keu($tampil_per = '', $param1 = '', $param2 = '')
		{
			$data['title'] = 'Laporan Keuangan Laboratorium';

			// $tgl_indo=new Tglindo();
			$tampil = substr($tampil_per, 0, 3);
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			//print_r($tampil);
			$namars = $this->config->item('namars');
			$alamat = $this->config->item('alamat');
			$kota_kab = $this->config->item('kota');
			$konten = "<table>
					<tr>
						<td colspan=\"2\">
							<p align=\"left\"><img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\"></p>
						</td>
						<td align=\"right\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
					</tr>
					<tr>
						<td colspan=\"3\">
							<b><font size=\"9\" align=\"right\">$alamat</font></b>
						</td>
					</tr><hr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan Laboratorium</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>";

			$tampil_per = $tampil;
			if ($tampil_per == 'TGL') {
				if ($param1 != '') {
					$tgl = $param1;
					$tgl1 = date('d F Y', strtotime($tgl));

					$date_title = '<b>' . $tgl1 . '</b>';
					$file_name = "KEU_LAB_$tgl.pdf";

					$data_laporan_keu = $this->Labmlaporan->get_data_keu_tind_tgl($tgl)->result();
					$data_keuangan = $this->Labmlaporan->get_data_keuangan_tgl($tgl)->result();

					$konten = $konten . "
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

					$jum_vtot = 0;
					$vtot1 = 0;
					$i = 1;
					foreach ($data_laporan_keu as $row) {
						$no_register = $row->no_register;
						$j = 1;
						foreach ($data_keuangan as $row2) {
							if ($row2->no_register == $no_register) {
								$vtot1 = $vtot1 + $row2->vtot;
								//$jum_vtot = $jum_vtot+$row2->total;
								if ($j == 1) {
									$konten = $konten . "
									<tr>
										<td>" . $i++ . "</td>
										<td>$row->no_cm</td>
										<td>$row->no_register</td>
										<td>$row->nama</td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">" . number_format($row2->vtot, 2, ',', '.') . "</p></td>
									</tr>";
								} else {
									$konten = $konten . "
									<tr>
										<td colspan=\"4\" bgcolor=\"#cdd4cb\"></td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">" . number_format($row2->vtot, 2, ',', '.') . "</p></td>
									</tr>";
								}
								$j++;
							} // if
						}
					}


					$konten = $konten . "
						<tr>
							<th colspan=\"5\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot1, 2, ',', '.') . "</p></th>
						</tr>
					</table>
				"; //print_r($konten);
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH . 'download/lab/lablaporan/keu/' . $file_name, 'FI');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			} else if ($tampil_per == 'BLN') {
				if ($param1 != '') {
					$bln = $param1;
					$bln1 = date('F Y', strtotime($bln));

					$date_title = '<b>' . $bln1 . '</b>';
					$file_name = "KEU_LAB_$bln1.pdf";


					//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_bln($bln)->result();
					if ($param2 != '') {
						$data_periode = $this->Labmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
					} else {
						$data_periode = $this->Labmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_bln($bln)->result();
					}

					$konten = $konten . "
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
					if ($param2 != '') {
						if ($param2 != 'BPJS') {
							$jenis_param2 = ucfirst(strtolower($param2));
						} else {
							$jenis_param2 = $param2;
						}
						$konten = $konten . "
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">" . $jenis_param2 . "</td>
							</tr>";
					}

					$konten = $konten . "
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
					$i = 1;
					$vtot = 0;
					$vtot_pasien = 0;
					$vtot_pemeriksaan = 0;
					foreach ($data_periode as $row) {
						//$vtot=$vtot+$row->total;
						if ($param2 != '') {
							$rwspn = count($this->Labmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
						} else {
							$rwspn = count($this->Labmlaporan->row_table_pertgl($row->tgl)->result());
						}

						$rwspn1 = $rwspn + 1;
						$j = 1;
						$vtottotal = 0;
						$vtotjumpas = 0;
						$vtotjumpem = 0;
						foreach ($data_keuangan as $row2) {
							if ($row2->tgl == $row->tgl) {
								$bln1 = date('d', strtotime($row2->tgl));
								$bln2 = date('m', strtotime($row2->tgl));
								$bulan = $tgl_indo->bulan($bln2);
								$vtottotal = $vtottotal + $row2->total;
								$vtotjumpas = $vtotjumpas + $row2->jumlah_pasien;
								$vtotjumpem = $vtotjumpem + $row2->jumlah_pemeriksaan;
								$vtot = $vtot + $row2->total;
								$vtot_pasien = $vtot_pasien + $row2->jumlah_pasien;
								$vtot_pemeriksaan = $vtot_pemeriksaan + $row2->jumlah_pemeriksaan;
								$konten = $konten . "
										<tr>";
								if ($j == '1') {
									$konten = $konten . "
											<td rowspan=\"$rwspn1\">" . $i++ . "</td>
											<td rowspan=\"$rwspn\">$bln1 $bulan</td>";
								}
								$konten = $konten . "
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">" . number_format($row2->total, 2, ',', '.') . "</td>
										</tr>";
								$j++;
							}
						}
						$konten = $konten . "
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">" . number_format($vtottotal, 2, ',', '.') . "</p></th>
										</tr>";
					}
					$konten = $konten . "
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
								<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot, 2, ',', '.') . "</p></th>
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
					$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH . 'download/lab/lablaporan/keu/' . $file_name, 'FI');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			} else {
				if ($param1 != '') {
					$thn = $param1;
					print_r($status);
					$thn1 = date('Y', strtotime($thn));

					$date_title = '<b>' . $thn1 . '</b>';
					$file_name = "KEU_LAB_$thn1.pdf";

					//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_thn($thn)->result();
					if ($param2 != '') {
						$data_periode = $this->Labmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
					} else {
						$data_periode = $this->Labmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_thn($thn)->result();
					}

					$konten = $konten . "
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
					if ($param2 != '') {
						if ($param2 != 'BPJS') {
							$jenis_param2 = ucfirst(strtolower($param2));
						} else {
							$jenis_param2 = $param2;
						}
						$konten = $konten . "
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">" . $jenis_param2 . "</td>
							</tr>";
					}

					$konten = $konten . "
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
					$i = 1;
					$vtot = 0;
					$vtot_pasien = 0;
					$vtot_pemeriksaan = 0;
					foreach ($data_periode as $row) {
						//$vtot=$vtot+$row->total;
						if ($param2 != '') {
							$rwspn = count($this->Labmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
						} else {
							$rwspn = count($this->Labmlaporan->row_table_perbln($row->bln)->result());
						}
						$rwspn1 = $rwspn + 1;
						$j = 1;
						$vtottotal = 0;
						$vtotjumpas = 0;
						$vtotjumpem = 0;
						foreach ($data_keuangan as $row2) {
							if ($row2->bln == $row->bln) {
								$thn = date('Y', strtotime($row2->bln));
								$bln2 = date('m', strtotime($row2->bln));
								$bulan = $tgl_indo->bulan($bln2);
								$vtottotal = $vtottotal + $row2->total;
								$vtotjumpas = $vtotjumpas + $row2->jumlah_pasien;
								$vtotjumpem = $vtotjumpem + $row2->jumlah_pemeriksaan;
								$vtot = $vtot + $row2->total;
								$vtot_pasien = $vtot_pasien + $row2->jumlah_pasien;
								$vtot_pemeriksaan = $vtot_pemeriksaan + $row2->jumlah_pemeriksaan;
								$konten = $konten . "
										<tr>";
								if ($j == '1') {
									$konten = $konten . "
											<td rowspan=\"$rwspn1\">" . $i++ . "</td>
											<td rowspan=\"$rwspn\">$bulan $thn</td>";
								}
								$konten = $konten . "
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">" . number_format($row2->total, 2, ',', '.') . "</td>
										</tr>";
								$j++;
							}
						}
						$konten = $konten . "
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">" . number_format($vtottotal, 2, ',', '.') . "</p></th>
										</tr>";
					}
					$konten = $konten . "
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
								<th bgcolor=\"yellow\"><p align=\"right\">" . number_format($vtot, 2, ',', '.') . "</p></th>
							</tr>
						</table>";
					//print_r($data_laporan_keu);
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH . 'download/lab/lablaporan/keu/' . $file_name, 'FI');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			}
		}

		public function export_excel($tampil_per = '', $param1 = '', $param2 = '')
		{
			$data['title'] = 'Laporan Keuangan Laboratorium';

			// $tgl_indo=new Tglindo();
			$tampil = substr($tampil_per, 0, 3);
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			//print_r($tampil);
			$namars = $this->config->item('namars');
			$alamat = $this->config->item('alamat');
			$kota_kab = $this->config->item('kota');
			////EXCEL 
			$this->load->library('Excel');

			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();

			// Set document properties  
			$objPHPExcel->getProperties()->setCreator("RSHMRABBAIN")
				->setLastModifiedBy("RSHMRABBAIN")
				->setTitle("Laporan Keuangan RS H. M RABBAIN")
				->setSubject("Laporan Keuangan RS H. M RABBAIN Document")
				->setDescription("Laporan Keuangan RS H. M RABBAIN for Office 2007 XLSX, generated by HMIS.")
				->setKeywords("RS H. M RABBAIN")
				->setCategory("Laporan Keuangan");

			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
			//$objPHPExcel = $objReader->load("project.xlsx");

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);


			////		
			if ($tampil_per == 'TGL') {
				if ($param1 != '') {

					$tgl = $param1;
					$tgl1 = date('d F Y', strtotime($tgl));

					$data_laporan_keu = $this->Labmlaporan->get_data_keu_tind_tgl($tgl)->result();
					$data_keuangan = $this->Labmlaporan->get_data_keuangan_tgl($tgl)->result();

					$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_lab_tgl.xlsx');
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
					$objPHPExcel->setActiveSheetIndex(0);
					// Add some data  
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
					$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : ' . $tgl1);
					$vtot1 = 0;
					$i = 1;
					$rowCount = 4;
					foreach ($data_laporan_keu as $row) {
						$no_register = $row->no_register;
						$j = 1;
						foreach ($data_keuangan as $row2) {
							if ($row2->no_register == $no_register) {
								$vtot1 = $vtot1 + $row2->vtot;
								if ($j == 1) {
									$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->no_cm);
									$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->no_register);
									$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->nama);
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->nm_dokter);
									$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row2->vtot);
									$i++;
								} else {
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->nm_dokter);
									$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row2->vtot);
								}
								$j++;
								$rowCount++;
							} // if
						}
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Total');
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $vtot1);
					header('Content-Disposition: attachment;filename="Lap_Keu_Laboratorium_TGL.xlsx"');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			} else if ($tampil_per == 'BLN') {
				if ($param1 != '') {
					$bln = $param1;
					$bln1 = date('F Y', strtotime($bln));

					if ($param2 != '') {
						$data_periode = $this->Labmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
					} else {
						$data_periode = $this->Labmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_bln($bln)->result();
					}

					$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_lab_bln.xlsx');
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

					$i = 1;
					$vtot = 0;
					$vtot_pasien = 0;
					$vtot_pemeriksaan = 0;
					$rowCount = 6;
					foreach ($data_periode as $row) {
						$j = 1;
						$vtottotal = 0;
						$vtotjumpas = 0;
						$vtotjumpem = 0;
						foreach ($data_keuangan as $row2) {
							if ($row2->tgl == $row->tgl) {
								$bln3 = date('d', strtotime($row2->tgl));
								$bln2 = date('m', strtotime($row2->tgl));
								$bulan = $tgl_indo->bulan($bln2);
								$vtottotal = $vtottotal + $row2->total;
								$vtotjumpas = $vtotjumpas + $row2->jumlah_pasien;
								$vtotjumpem = $vtotjumpem + $row2->jumlah_pemeriksaan;
								$vtot = $vtot + $row2->total;
								$vtot_pasien = $vtot_pasien + $row2->jumlah_pasien;
								$vtot_pemeriksaan = $vtot_pemeriksaan + $row2->jumlah_pemeriksaan;
								if ($j == 1) {
									$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $bln3 . ' ' . $bulan);
									$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_pasien);
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jumlah_pemeriksaan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->total);
									$i++;
								} else {
									$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_pasien);
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jumlah_pemeriksaan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->total);
								}
								$j++;
								$rowCount++;
							} // if
						}
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pasien ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtot_pasien);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '-');
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pemeriksaan ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $vtot_pemeriksaan);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '-');
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pendapatan ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $vtot);
					header('Content-Disposition: attachment;filename="Lap_Keu_Laboratorium_Bulan.xlsx"');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			} else {
				if ($param1 != '') {
					$thn = $param1;
					$thn1 = date('Y', strtotime($thn));

					$date_title = '<b>' . $thn1 . '</b>';
					$file_name = "KEU_LAB_$thn1.pdf";

					//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_thn($thn)->result();
					if ($param2 != '') {
						$data_periode = $this->Labmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
					} else {
						$data_periode = $this->Labmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan = $this->Labmlaporan->get_data_keuangan_thn($thn)->result();
					}

					$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_lab_thn.xlsx');
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
					$i = 1;
					$vtot = 0;
					$vtot_pasien = 0;
					$vtot_pemeriksaan = 0;
					$rowCount = 6;
					foreach ($data_periode as $row) {
						$j = 1;
						$vtottotal = 0;
						$vtotjumpas = 0;
						$vtotjumpem = 0;
						foreach ($data_keuangan as $row2) {
							if ($row2->bln == $row->bln) {
								$thn = date('Y', strtotime($row2->bln));
								$bln2 = date('m', strtotime($row2->bln));
								$bulan = $tgl_indo->bulan($bln2);
								$vtottotal = $vtottotal + $row2->total;
								$vtotjumpas = $vtotjumpas + $row2->jumlah_pasien;
								$vtotjumpem = $vtotjumpem + $row2->jumlah_pemeriksaan;
								$vtot = $vtot + $row2->total;
								$vtot_pasien = $vtot_pasien + $row2->jumlah_pasien;
								$vtot_pemeriksaan = $vtot_pemeriksaan + $row2->jumlah_pemeriksaan;
								if ($j == 1) {
									$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $bulan . ' ' . $thn);
									$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_pasien);
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jumlah_pemeriksaan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->total);
									$i++;
								} else {
									$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->jenis_tindakan);
									$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_pasien);
									$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->jumlah_pemeriksaan);
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->total);
								}
								$j++;
								$rowCount++;
							}
						}
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pasien Tahun ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtot_pasien);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '-');
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pemeriksaan Tahun ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $vtot_pemeriksaan);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '-');
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total Pendapatan Tahun ' . $bln1);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '-');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $vtot);
					header('Content-Disposition: attachment;filename="Lap_Keu_Laboratorium_Tahun.xlsx"');
				} else {
					redirect('lab/Labclaporan/data_pendapatan', 'refresh');
				}
			}

			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('RS H. M RABBAIN');



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

		public function download_keuangan_old($param1 = '', $param2 = '')
		{
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

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');

			$data_keuangan = $this->Labmlaporan->get_data_keu_tind($param1, $param2)->result();

			$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_keu_lab.xlsx');
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

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Laboratorium Periode " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2)));
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$rowCount = 4;
			$temp = "";
			$temptgl = "";
			$total_pendapatan = 0;
			foreach ($data_keuangan as $row) {
				if ($temptgl == $row->tgl_kunjungan) {
				} else {
					$temptgl = $row->tgl_kunjungan;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->tgl_kunjungan);
				}

				if ($temp == $row->no_lab) {
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->status == "1") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				} else {
					$temp = $row->no_lab;
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->no_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->kelas);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->bed);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->status == "1") {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				}

				$rowCount++;
			}
			$filename = "Laporan Pendapatan Laboratorium " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2));
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "Total Pendapatan : ");
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="' . $filename . '.xls"');

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

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');
			// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
			// echo json_encode($data_keuangan);
		}

		public function download_keuangan($param1 = '', $param2 = '')
		{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$inputFileType = 'Xls';
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
			$reader->setReadDataOnly(true);

			$data_keuangan = $this->Labmlaporan->get_data_keu_tind($param1, $param2)->result();
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getStyle('A3')->getFont()->setBold(true);
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getStyle('B3')->getFont()->setBold(true);
			$sheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getStyle('C3')->getFont()->setBold(true);
			$sheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getStyle('D3')->getFont()->setBold(true);
			$sheet->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getStyle('E3')->getFont()->setBold(true);
			$sheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getStyle('F3')->getFont()->setBold(true);
			$sheet->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			$sheet->getStyle('G3')->getFont()->setBold(true);
			$sheet->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('H')->setAutoSize(true);
			$sheet->getStyle('H3')->getFont()->setBold(true);
			$sheet->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('I')->setAutoSize(true);
			$sheet->getStyle('I3')->getFont()->setBold(true);
			$sheet->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('J')->setAutoSize(true);
			$sheet->getStyle('J3')->getFont()->setBold(true);
			$sheet->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('K')->setAutoSize(true);
			$sheet->getStyle('K3')->getFont()->setBold(true);
			$sheet->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('L')->setAutoSize(true);
			$sheet->getStyle('L3')->getFont()->setBold(true);
			$sheet->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('M')->setAutoSize(true);
			$sheet->getStyle('M3')->getFont()->setBold(true);
			$sheet->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('N')->setAutoSize(true);
			$sheet->getStyle('N3')->getFont()->setBold(true);
			$sheet->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimension('O')->setAutoSize(true);
			$sheet->getStyle('O3')->getFont()->setBold(true);
			$sheet->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->setAutoFilter('A3:O3');

			$sheet->SetCellValue('A1', "Laporan Pendapatan Laboratorium Periode " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2)));
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getFont()->setSize(16);
			$sheet->mergeCells('A1:O1');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$rowCount = 4;
			$temp = "";
			$temptgl = "";
			$total_pendapatan = 0;

			// $sheet->SetCellValue('A3','Tanggal Kunjungan');
			// $sheet->SetCellValue('B3','No Lab');
			// $sheet->SetCellValue('C3','No Register');
			// $sheet->SetCellValue('D3','Nama');
			// $sheet->SetCellValue('E3','No Medrec');
			// $sheet->SetCellValue('F3','Kelas');
			// $sheet->SetCellValue('G3','IDRG');
			// $sheet->SetCellValue('H3','Bed');
			// $sheet->SetCellValue('I3','Cara Bayar');
			// $sheet->SetCellValue('J3','Kontraktor');
			// $sheet->SetCellValue('K3','Jenis Tindakan');
			// $sheet->SetCellValue('L3','Biaya Lab');
			// $sheet->SetCellValue('M3','QTY');
			// $sheet->SetCellValue('N3','VTOT');
			// $sheet->SetCellValue('03','Status');

			foreach ($data_keuangan as $row) {
				if ($temptgl == $row->tgl_kunjungan) {
				} else {
					$temptgl = $row->tgl_kunjungan;
					$sheet->SetCellValue('A' . $rowCount, $row->tgl_kunjungan);
				}

				if ($temp == $row->no_lab) {
					$sheet->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$sheet->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$sheet->SetCellValue('M' . $rowCount, $row->qty);
					$sheet->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$sheet->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->cetak_kwitansi == "1") {
						$sheet->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$sheet->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				} else {
					$temp = $row->no_lab;
					$sheet->SetCellValue('B' . $rowCount, $row->no_lab);
					$sheet->SetCellValue('C' . $rowCount, $row->no_register);
					$sheet->SetCellValue('D' . $rowCount, $row->nama);
					$sheet->SetCellValue('E' . $rowCount, $row->no_medrec);
					$sheet->SetCellValue('F' . $rowCount, $row->kelas);
					$sheet->SetCellValue('G' . $rowCount, $row->idrg);
					$sheet->SetCellValue('H' . $rowCount, $row->bed);
					$sheet->SetCellValue('I' . $rowCount, $row->cara_bayar);
					$sheet->SetCellValue('J' . $rowCount, $row->nmkontraktor);
					$sheet->SetCellValue('K' . $rowCount, $row->jenis_tindakan);
					$sheet->SetCellValue('L' . $rowCount, $row->biaya_lab);
					$sheet->SetCellValue('M' . $rowCount, $row->qty);
					$sheet->SetCellValue('N' . $rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if ($row->cara_bayar == "BPJS") {
						$sheet->SetCellValue('O' . $rowCount, "BPJS");
					} else if ($row->cetak_kwitansi == "1") {
						$sheet->SetCellValue('O' . $rowCount, "Lunas");
					} else {
						$sheet->SetCellValue('O' . $rowCount, "Belum Lunas");
					}
				}

				$rowCount++;
			}
			$filename = "Laporan Pendapatan Laboratorium " . date('d F Y', strtotime($param1)) . " - " . date('d F Y', strtotime($param2));
			$sheet->SetCellValue('M' . $rowCount, "Total Pendapatan : ");
			$sheet->SetCellValue('N' . $rowCount, $total_pendapatan);

			$writer = new Xlsx($spreadsheet);
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function excel_lappemeriksaan_old($date0 = '', $date1 = '')
		{
			////EXCEL 
			$this->load->library('Excel');

			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();

			// Set document properties  
			$namars = $this->config->item('namars');
			$objPHPExcel->getProperties()->setCreator($namars)
				->setLastModifiedBy($namars)
				->setTitle("Laporan Laboratorium " . $namars)
				->setSubject("Laporan Laboratorium " . $namars . " Document")
				->setDescription("Laporan Laboratorium " . $namars . ", generated by HMIS.")
				->setKeywords($namars)
				->setCategory("Laporan Laboratorium");

			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
			//$objPHPExcel = $objReader->load("project.xlsx");

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			//$tgl=$param1;
			//$tgl1 = date('d F Y', strtotime($tgl));				

			$objPHPExcel = $objReader->load(APPPATH . 'third_party/lap_range_lab_tgl.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);
			// Add some data  
			//$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
			//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
			$vtot1 = 0;
			$i = 1;
			$rowCount = 4;
			if ($date0 == '' && $date1 == '') {
				$date0 = date('Y-m-d', strtotime('-7 days'));
				$date1 = date('Y-m-d');
			}
			$hasil = $this->Labmlaporan->get_lap_pemeriksaan_detail($date0, $date1)->result();
			$listtgl = $this->Labmlaporan->get_dates_detail($date0, $date1)->result();
			$master_lab = $this->Labmlaporan->get_master_pemeriksaan_lab()->result();
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

			$rowCount = 5;
			$vtotbpjs = 0;
			$vtotumum = 0;
			$vtotdijamin = 0;
			$vtotp = 0;
			$vtotl = 0;
			foreach ($listtgl as $key) {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, date('d-m-Y', strtotime($key->tgl_kunjungan)));
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $key->BPJS);
				$vtotbpjs = $vtotbpjs + $key->BPJS;
				$vtotumum = $vtotumum + $key->UMUM;
				$vtotdijamin + $vtotdijamin + $key->DIJAMIN;
				$vtotp = $vtotp + $key->P;
				$vtotl = $vtotl + $key->L;
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $key->UMUM);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $key->DIJAMIN);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $key->P);
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $key->L);
				foreach ($hasil as $row) {
					$col = 6;
					if ($key->tgl_kunjungan == $row->tgl_kunjungan) {
						foreach ($master_lab as $row0) {
							if ($row->idtindakan == $row0->idtindakan) {
								$vtot1 = $vtot1 + $row->banyak;
								//echo $row->banyak.' '.$row->nmtindakan;      			
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row->banyak);
							} else {
								//echo $row->idtindakan.'=='.$row0->idtindakan;
								//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
								//if($hi==null && $hi<1){
								//	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
								//}

							}
							$col++;
						}
					} else {
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
			foreach ($master_lab as $key) {
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

			for ($j = 5; $j < $rowCount; $j++) {
				for ($i = 6; $i < $col; $i++) {
					$hi = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue(); //getCellValueByColumnAndRow();
					if ($hi == null || $hi == '') {
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
					}
				}
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $vtotbpjs);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $vtotumum);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtotdijamin);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $vtotp);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $vtotl);
			$rowCount++;
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $vtot1);

			header('Content-Disposition: attachment;filename="Lap_Range_Laboratorium.xlsx"');


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

		public function excel_lappemeriksaan($date0 = '', $date1 = '')
		{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Tindakan');
			$sheet->setCellValue('C1', 'Banyak');

			if ($date0 == '' && $date1 == '') {
				$date0 = date('Y-m-d', strtotime('-7 days'));
				$date1 = date('Y-m-d');
			}
			$data = $this->Labmlaporan->get_lap_pemeriksaan($date0, $date1)->result();

			$no = 1;
			$x = 2;

			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $row->nmtindakan);
				$sheet->setCellValue('C' . $x, $row->banyak);
				$x++;
			}

			$writer = new Xlsx($spreadsheet);
			$filename = 'Lap_Range_Laboratorium';
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		static function SaveViaTempFile($objWriter)
		{
			$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
			$objWriter->save($filePath);
			readfile($filePath);
			unlink($filePath);
		}

		public function lap_hematologi()
		{
			$data['title'] = 'Laporan Hematologi Laboratorium';
			$data['tindakan'] = $this->Labmlaporan->get_tindakan_hematologi()->result();
			$this->load->view('lab/labvlap_hematologi', $data);
		}

		public function lap_hematologi_exe($date, $tindakan)
		{
			$hasil = $this->Labmlaporan->get_lap_hematologi($date, $tindakan)->result();

			$line  = array();
			$line2 = array();
			$row2  = array();
			$i = 1;

			foreach ($hasil as $value) {
				$row2['tgl'] = $value->tgl;
				$row2['jml_bpjs_vip'] = $value->jml_bpjs_vip;
				$row2['jml_umum_vip'] = $value->jml_umum_vip;;
				$row2['jml_bpjs_1'] = $value->jml_bpjs_1;
				$row2['jml_umum_1'] = $value->jml_umum_1;
				$row2['jml_bpjs_2'] = $value->jml_bpjs_2;
				$row2['jml_umum_2'] = $value->jml_umum_2;
				$row2['jml_bpjs_3'] = $value->jml_bpjs_3;
				$row2['jml_umum_3'] = $value->jml_umum_3;
				$row2['jml_bpjs_icu'] = $value->jml_bpjs_icu;
				$row2['jml_umum_icu'] = $value->jml_umum_icu;
				$row2['jml_bpjs_hcu'] = $value->jml_bpjs_hcu;
				$row2['jml_umum_hcu'] = $value->jml_umum_hcu;
				$row2['jml_bpjs_rj'] = $value->jml_bpjs_rj;
				$row2['jml_umum_rj'] = $value->jml_umum_rj;
				$row2['jml_bpjs_rd'] = $value->jml_bpjs_rd;
				$row2['jml_umum_rd'] = $value->jml_umum_rd;
				$row2['jml_eks'] = $value->jml_eks;
				$row2['jml_isolasi_bpjs'] = $value->jml_isolasi_bpjs;
				$row2['jml_isolasi_umum'] = $value->jml_isolasi_umum;
				$row2['jml_pasien_luar'] = $value->jml_pasien_luar;
				$line2[] = $row2;
			}

			$line['data'] = $line2;

			echo json_encode($line);
		}

		public function excel_lap_hematologi($date, $tindakan)
		{
			$nmtindakan = $this->Labmlaporan->get_nmtindakan($tindakan)->row()->nmtindakan;
			$tgl = date("F Y", strtotime($date));
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A1:D1')
				->getCell('A1')
				->setValue($nmtindakan);
			$sheet->mergeCells('A2:A3')
				->getCell('A2')
				->setValue('TGL');
			$sheet->mergeCells('B2:C2')
				->getCell('B2')
				->setValue('VIP');
			$sheet->mergeCells('D2:E2')
				->getCell('D2')
				->setValue('I');
			$sheet->mergeCells('F2:G2')
				->getCell('F2')
				->setValue('II');
			$sheet->mergeCells('H2:I2')
				->getCell('H2')
				->setValue('III');
			$sheet->mergeCells('J2:K2')
				->getCell('J2')
				->setValue('ICU');
			$sheet->mergeCells('L2:M2')
				->getCell('L2')
				->setValue('HCU');
			$sheet->mergeCells('N2:O2')
				->getCell('N2')
				->setValue('Isolasi');
			$sheet->mergeCells('P2:Q2')
				->getCell('P2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('R2:S2')
				->getCell('R2')
				->setValue('IGD');
			$sheet->mergeCells('T2:T3')
				->getCell('T2')
				->setValue('Poli Eksekutif');
			$sheet->mergeCells('U2:U3')
				->getCell('U2')
				->setValue('Pasien Luar');
			$sheet->setCellValue('B3', 'BPJS');
			$sheet->setCellValue('C3', 'UMUM');
			$sheet->setCellValue('D3', 'BPJS');
			$sheet->setCellValue('E3', 'UMUM');
			$sheet->setCellValue('F3', 'BPJS');
			$sheet->setCellValue('G3', 'UMUM');
			$sheet->setCellValue('H3', 'BPJS');
			$sheet->setCellValue('I3', 'UMUM');
			$sheet->setCellValue('J3', 'BPJS');
			$sheet->setCellValue('K3', 'UMUM');
			$sheet->setCellValue('L3', 'BPJS');
			$sheet->setCellValue('M3', 'UMUM');
			$sheet->setCellValue('N3', 'BPJS');
			$sheet->setCellValue('O3', 'UMUM');
			$sheet->setCellValue('P3', 'BPJS');
			$sheet->setCellValue('Q3', 'UMUM');
			$sheet->setCellValue('R3', 'BPJS');
			$sheet->setCellValue('S3', 'UMUM');

			$data = $this->Labmlaporan->get_lap_hematologi($date, $tindakan)->result();

			$no = 1;
			$x = 4;

			$tot_bpjs_vip = 0;
			$tot_umum_vip = 0;
			$tot_bpjs_1 = 0;
			$tot_umum_1 = 0;
			$tot_bpjs_2 = 0;
			$tot_umum_2 = 0;
			$tot_bpjs_3 = 0;
			$tot_umum_3 = 0;
			$tot_bpjs_icu = 0;
			$tot_umum_icu = 0;
			$tot_bpjs_hcu = 0;
			$tot_umum_hcu = 0;
			$tot_bpjs_isolasi = 0;
			$tot_umum_isolasi = 0;
			$tot_bpjs_rj = 0;
			$tot_umum_rj = 0;
			$tot_bpjs_rd = 0;
			$tot_umum_rd = 0;
			$tot_eks = 0;
			$tot_pasien_luar = 0;

			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $row->tgl);
				$sheet->setCellValue('B' . $x, $row->jml_bpjs_vip);
				$sheet->setCellValue('C' . $x, $row->jml_umum_vip);
				$sheet->setCellValue('D' . $x, $row->jml_bpjs_1);
				$sheet->setCellValue('E' . $x, $row->jml_umum_1);
				$sheet->setCellValue('F' . $x, $row->jml_bpjs_2);
				$sheet->setCellValue('G' . $x, $row->jml_umum_2);
				$sheet->setCellValue('H' . $x, $row->jml_bpjs_3);
				$sheet->setCellValue('I' . $x, $row->jml_umum_3);
				$sheet->setCellValue('J' . $x, $row->jml_bpjs_icu);
				$sheet->setCellValue('K' . $x, $row->jml_umum_icu);
				$sheet->setCellValue('L' . $x, $row->jml_bpjs_hcu);
				$sheet->setCellValue('M' . $x, $row->jml_umum_hcu);
				$sheet->setCellValue('N' . $x, $row->jml_isolasi_bpjs);
				$sheet->setCellValue('O' . $x, $row->jml_isolasi_umum);
				$sheet->setCellValue('P' . $x, $row->jml_bpjs_rj);
				$sheet->setCellValue('Q' . $x, $row->jml_umum_rj);
				$sheet->setCellValue('R' . $x, $row->jml_bpjs_rd);
				$sheet->setCellValue('S' . $x, $row->jml_umum_rd);
				$sheet->setCellValue('T' . $x, $row->jml_eks);
				$sheet->setCellValue('U' . $x, $row->jml_pasien_luar);
				$tot_bpjs_vip += $row->jml_bpjs_vip;
				$tot_umum_vip += $row->jml_umum_vip;
				$tot_bpjs_1 += $row->jml_bpjs_1;
				$tot_umum_1 += $row->jml_umum_1;
				$tot_bpjs_2 += $row->jml_bpjs_2;
				$tot_umum_2 += $row->jml_umum_2;
				$tot_bpjs_3 += $row->jml_bpjs_3;
				$tot_umum_3 += $row->jml_umum_3;
				$tot_bpjs_icu += $row->jml_bpjs_icu;
				$tot_umum_icu += $row->jml_umum_icu;
				$tot_bpjs_hcu += $row->jml_bpjs_hcu;
				$tot_umum_hcu += $row->jml_umum_hcu;
				$tot_bpjs_isolasi += $row->jml_isolasi_bpjs;
				$tot_umum_isolasi += $row->jml_isolasi_umum;
				$tot_bpjs_rj += $row->jml_bpjs_rj;
				$tot_umum_rj += $row->jml_umum_rj;
				$tot_bpjs_rd += $row->jml_bpjs_rd;
				$tot_umum_rd += $row->jml_umum_rd;
				$tot_eks += $row->jml_eks;
				$tot_pasien_luar += $row->jml_pasien_luar;
				$x++;
			}

			$sheet->setCellValue('A' . $x, 'TOTAL');
			$sheet->setCellValue('B' . $x, $tot_bpjs_vip);
			$sheet->setCellValue('C' . $x, $tot_umum_vip);
			$sheet->setCellValue('D' . $x, $tot_bpjs_1);
			$sheet->setCellValue('E' . $x, $tot_umum_1);
			$sheet->setCellValue('F' . $x, $tot_bpjs_2);
			$sheet->setCellValue('G' . $x, $tot_umum_2);
			$sheet->setCellValue('H' . $x, $tot_bpjs_3);
			$sheet->setCellValue('I' . $x, $tot_umum_3);
			$sheet->setCellValue('J' . $x, $tot_bpjs_icu);
			$sheet->setCellValue('K' . $x, $tot_umum_icu);
			$sheet->setCellValue('L' . $x, $tot_bpjs_hcu);
			$sheet->setCellValue('M' . $x, $tot_umum_hcu);
			$sheet->setCellValue('N' . $x, $tot_bpjs_isolasi);
			$sheet->setCellValue('O' . $x, $tot_umum_isolasi);
			$sheet->setCellValue('P' . $x, $tot_bpjs_rj);
			$sheet->setCellValue('Q' . $x, $tot_umum_rj);
			$sheet->setCellValue('R' . $x, $tot_bpjs_rd);
			$sheet->setCellValue('S' . $x, $tot_umum_rd);
			$sheet->setCellValue('T' . $x, $tot_eks);
			$sheet->setCellValue('U' . $x, $tot_pasien_luar);

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemeriksaan Per Tindakan Labor ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_hematologi_dokter()
		{
			$data['title'] = 'Laporan Hematologi Laboratorium Berdasarkan Dokter';
			$data['tindakan'] = $this->Labmlaporan->get_tindakan_hematologi()->result();
			$this->load->view('lab/labvlap_hematologi_dok.php', $data);
		}

		public function lap_hematologi_dok_exe($date, $tindakan)
		{
			$hasil = $this->Labmlaporan->get_lap_hematologi_dok($date, $tindakan)->result();

			$line  = array();
			$line2 = array();
			$row2  = array();
			$i = 1;

			foreach ($hasil as $value) {
				$row2['tgl'] = $value->tgl;
				$row2['jml_bpjs_ri_el'] = $value->jml_bpjs_ri_el;
				$row2['jml_umum_ri_el'] = $value->jml_umum_ri_el;
				$row2['jml_bpjs_rj_el'] = $value->jml_bpjs_rj_el;
				$row2['jml_umum_rj_el'] = $value->jml_umum_rj_el;
				$row2['jml_bpjs_ri_pat'] = $value->jml_bpjs_ri_pat;
				$row2['jml_umum_ri_pat'] = $value->jml_umum_ri_pat;
				$row2['jml_bpjs_rj_pat'] = $value->jml_bpjs_rj_pat;
				$row2['jml_umum_rj_pat'] = $value->jml_umum_rj_pat;
				$row2['jml_bpjs_isolasi_el'] = $value->jml_bpjs_isolasi_el;
				$row2['jml_umum_isolasi_el'] = $value->jml_umum_isolasi_el;
				$row2['jml_eks_el'] = $value->jml_eks_el;
				$row2['jml_pl_el'] = $value->jml_pl_el;
				$row2['jml_bpjs_isolasi_pat'] = $value->jml_bpjs_isolasi_pat;
				$row2['jml_umum_isolasi_pat'] = $value->jml_umum_isolasi_pat;
				$row2['jml_eks_pat'] = $value->jml_eks_pat;
				$row2['jml_pl_pat'] = $value->jml_pl_pat;
				$line2[] = $row2;
			}

			$line['data'] = $line2;

			echo json_encode($line);
		}

		public function excel_lap_hematologi_dok($date, $tindakan)
		{
			$nmtindakan = $this->Labmlaporan->get_nmtindakan($tindakan)->row()->nmtindakan;
			$tgl = date("F Y", strtotime($date));
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A2:A4')
				->getCell('A2')
				->setValue('TGL');
			$sheet->mergeCells('B2:I2')
				->getCell('B2')
				->setValue('dr. Elhuriah, Sp. PK');
			$sheet->mergeCells('J2:Q2')
				->getCell('J2')
				->setValue('dr. Fatimah Yasin, Sp. PK');
			$sheet->mergeCells('B3:C3')
				->getCell('B3')
				->setValue('Rawat Inap');
			$sheet->mergeCells('D3:E3')
				->getCell('D3')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('F3:G3')
				->getCell('F3')
				->setValue('Isolasi');
			$sheet->mergeCells('H3:H4')
				->getCell('H3')
				->setValue('POLI Eksekutif');
			$sheet->mergeCells('I3:I4')
				->getCell('I3')
				->setValue('Pasien Luar');
			$sheet->mergeCells('J3:K3')
				->getCell('J3')
				->setValue('Rawat Inap');
			$sheet->mergeCells('L3:M3')
				->getCell('L3')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('N3:O3')
				->getCell('N3')
				->setValue('Isolasi');
			$sheet->mergeCells('P3:P4')
				->getCell('P3')
				->setValue('Poli Eksekuitf');
			$sheet->mergeCells('Q3:Q4')
				->getCell('Q3')
				->setValue('Pasien Luar');
			$sheet->setCellValue('B4', 'BPJS');
			$sheet->setCellValue('C4', 'UMUM');
			$sheet->setCellValue('D4', 'BPJS');
			$sheet->setCellValue('E4', 'UMUM');
			$sheet->setCellValue('F4', 'BPJS');
			$sheet->setCellValue('G4', 'UMUM');
			$sheet->setCellValue('J4', 'BPJS');
			$sheet->setCellValue('K4', 'UMUM');
			$sheet->setCellValue('L4', 'BPJS');
			$sheet->setCellValue('M4', 'UMUM');
			$sheet->setCellValue('N4', 'BPJS');
			$sheet->setCellValue('O4', 'UMUM');

			$data = $this->Labmlaporan->get_lap_hematologi_dok($date, $tindakan)->result();

			$no = 1;
			$x = 5;

			$tot_bpjs_ri_el = 0;
			$tot_umum_ri_el = 0;
			$tot_bpjs_rj_el = 0;
			$tot_umum_rj_el = 0;
			$tot_bpjs_isolasi_el = 0;
			$tot_umum_isolasi_el = 0;
			$tot_eks_el = 0;
			$tot_pl_el = 0;
			$tot_bpjs_ri_pat = 0;
			$tot_umum_ri_pat = 0;
			$tot_bpjs_rj_pat = 0;
			$tot_umum_rj_pat = 0;
			$tot_bpjs_isolasi_pat = 0;
			$tot_umum_isolasi_pat = 0;
			$tot_eks_pat = 0;
			$tot_pl_pat = 0;

			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $row->tgl);
				$sheet->setCellValue('B' . $x, $row->jml_bpjs_ri_el);
				$sheet->setCellValue('C' . $x, $row->jml_umum_ri_el);
				$sheet->setCellValue('D' . $x, $row->jml_bpjs_rj_el);
				$sheet->setCellValue('E' . $x, $row->jml_umum_rj_el);
				$sheet->setCellValue('F' . $x, $row->jml_bpjs_isolasi_el);
				$sheet->setCellValue('G' . $x, $row->jml_umum_isolasi_el);
				$sheet->setCellValue('H' . $x, $row->jml_eks_el);
				$sheet->setCellValue('I' . $x, $row->jml_pl_el);
				$sheet->setCellValue('J' . $x, $row->jml_bpjs_ri_pat);
				$sheet->setCellValue('K' . $x, $row->jml_umum_ri_pat);
				$sheet->setCellValue('L' . $x, $row->jml_bpjs_rj_pat);
				$sheet->setCellValue('M' . $x, $row->jml_umum_rj_pat);
				$sheet->setCellValue('N' . $x, $row->jml_bpjs_isolasi_pat);
				$sheet->setCellValue('O' . $x, $row->jml_umum_isolasi_pat);
				$sheet->setCellValue('P' . $x, $row->jml_eks_pat);
				$sheet->setCellValue('Q' . $x, $row->jml_pl_pat);
				$tot_bpjs_ri_el += $row->jml_bpjs_ri_el;
				$tot_umum_ri_el += $row->jml_umum_ri_el;
				$tot_bpjs_rj_el += $row->jml_bpjs_rj_el;
				$tot_umum_rj_el += $row->jml_umum_rj_el;
				$tot_bpjs_isolasi_el += $row->jml_bpjs_isolasi_el;
				$tot_umum_isolasi_el += $row->jml_umum_isolasi_el;
				$tot_eks_el += $row->jml_eks_el;
				$tot_pl_el += $row->jml_pl_el;
				$tot_bpjs_ri_pat += $row->jml_bpjs_ri_pat;
				$tot_umum_ri_pat += $row->jml_umum_ri_pat;
				$tot_bpjs_rj_pat += $row->jml_bpjs_rj_pat;
				$tot_umum_rj_pat += $row->jml_umum_rj_pat;
				$tot_bpjs_isolasi_pat += $row->jml_bpjs_isolasi_pat;
				$tot_umum_isolasi_pat += $row->jml_umum_isolasi_pat;
				$tot_eks_pat += $row->jml_eks_pat;
				$tot_pl_pat += $row->jml_pl_pat;
				$x++;
			}

			$sheet->setCellValue('A' . $x, 'TOTAL');
			$sheet->setCellValue('B' . $x, $tot_bpjs_ri_el);
			$sheet->setCellValue('C' . $x, $tot_umum_ri_el);
			$sheet->setCellValue('D' . $x, $tot_bpjs_rj_el);
			$sheet->setCellValue('E' . $x, $tot_umum_rj_el);
			$sheet->setCellValue('F' . $x, $tot_bpjs_isolasi_el);
			$sheet->setCellValue('G' . $x, $tot_umum_isolasi_el);
			$sheet->setCellValue('H' . $x, $tot_eks_el);
			$sheet->setCellValue('I' . $x, $tot_pl_el);
			$sheet->setCellValue('J' . $x, $tot_bpjs_ri_pat);
			$sheet->setCellValue('K' . $x, $tot_umum_ri_pat);
			$sheet->setCellValue('L' . $x, $tot_bpjs_rj_pat);
			$sheet->setCellValue('M' . $x, $tot_umum_rj_pat);
			$sheet->setCellValue('N' . $x, $tot_bpjs_isolasi_pat);
			$sheet->setCellValue('O' . $x, $tot_umum_isolasi_pat);
			$sheet->setCellValue('P' . $x, $tot_eks_pat);
			$sheet->setCellValue('Q' . $x, $tot_pl_pat);

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemeriksaan Tindakan Per Dokter Labor ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_jml_kunjungan()
		{
			$data['title'] = 'Laporan Jumlah Kunjungan Laboratorium';
			$this->load->view('lab/labvlapjml_kunj', $data);
		}

		public function lap_jml_kunjungan_exe($date, $tampil)
		{
			$hasil = $this->Labmlaporan->get_lap_jml_kunj($date, $tampil)->result();

			$line  = array();
			$line2 = array();
			$row2  = array();
			$i = 1;

			foreach ($hasil as $value) {
				if ($tampil == 'TGL') {
					$row2['tgl'] = date("d-m-Y", strtotime($value->tgl));
				} else {
					$row2['tgl'] = $value->tgl;
				}
				$row2['jml_bpjs_vip'] = $value->jml_bpjs_vip;
				$row2['jml_umum_vip'] = $value->jml_umum_vip;;
				$row2['jml_bpjs_1'] = $value->jml_bpjs_1;
				$row2['jml_umum_1'] = $value->jml_umum_1;
				$row2['jml_bpjs_2'] = $value->jml_bpjs_2;
				$row2['jml_umum_2'] = $value->jml_umum_2;
				$row2['jml_bpjs_3'] = $value->jml_bpjs_3;
				$row2['jml_umum_3'] = $value->jml_umum_3;
				$row2['jml_bpjs_icu'] = $value->jml_bpjs_icu;
				$row2['jml_umum_icu'] = $value->jml_umum_icu;
				$row2['jml_bpjs_hcu'] = $value->jml_bpjs_hcu;
				$row2['jml_umum_hcu'] = $value->jml_umum_hcu;
				$row2['jml_bpjs_rj'] = $value->jml_bpjs_rj;
				$row2['jml_umum_rj'] = $value->jml_umum_rj;
				$row2['jml_bpjs_rd'] = $value->jml_bpjs_rd;
				$row2['jml_umum_rd'] = $value->jml_umum_rd;
				$row2['jml_eks'] = $value->jml_eks;
				$row2['jml_isolasi_bpjs'] = $value->jml_isolasi_bpjs;
				$row2['jml_isolasi_umum'] = $value->jml_isolasi_umum;
				$row2['jml_pasien_luar'] = $value->jml_pasien_luar;
				$line2[] = $row2;
			}

			$line['data'] = $line2;

			echo json_encode($line);
		}

		public function excel_lap_jml_kunj($date, $tampil)
		{
			if ($tampil == 'BLN') {
				$tgl = date("F Y", strtotime($date));
			} else {
				$tgl = date("d F Y", strtotime($date));
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A1:A2')
				->getCell('A1')
				->setValue('TGL');
			$sheet->mergeCells('B1:C1')
				->getCell('B1')
				->setValue('VIP');
			$sheet->mergeCells('D1:E1')
				->getCell('D1')
				->setValue('I');
			$sheet->mergeCells('F1:G1')
				->getCell('F1')
				->setValue('II');
			$sheet->mergeCells('H1:I1')
				->getCell('H1')
				->setValue('III');
			$sheet->mergeCells('J1:K1')
				->getCell('J1')
				->setValue('ICU');
			$sheet->mergeCells('L1:M1')
				->getCell('L1')
				->setValue('HCU');
			$sheet->mergeCells('N1:O1')
				->getCell('N1')
				->setValue('Isolasi');
			$sheet->mergeCells('P1:Q1')
				->getCell('P1')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('R1:S1')
				->getCell('R1')
				->setValue('IGD');
			$sheet->mergeCells('T1:T2')
				->getCell('T1')
				->setValue('Poli Eksekutif');
			$sheet->mergeCells('U1:U2')
				->getCell('U1')
				->setValue('Pasien Luar');
			$sheet->setCellValue('B2', 'BPJS');
			$sheet->setCellValue('C2', 'UMUM');
			$sheet->setCellValue('D2', 'BPJS');
			$sheet->setCellValue('E2', 'UMUM');
			$sheet->setCellValue('F2', 'BPJS');
			$sheet->setCellValue('G2', 'UMUM');
			$sheet->setCellValue('H2', 'BPJS');
			$sheet->setCellValue('I2', 'UMUM');
			$sheet->setCellValue('J2', 'BPJS');
			$sheet->setCellValue('K2', 'UMUM');
			$sheet->setCellValue('L2', 'BPJS');
			$sheet->setCellValue('M2', 'UMUM');
			$sheet->setCellValue('N2', 'BPJS');
			$sheet->setCellValue('O2', 'UMUM');
			$sheet->setCellValue('P2', 'BPJS');
			$sheet->setCellValue('Q2', 'UMUM');
			$sheet->setCellValue('R2', 'BPJS');
			$sheet->setCellValue('S2', 'UMUM');

			$data = $this->Labmlaporan->get_lap_jml_kunj($date, $tampil)->result();

			$no = 1;
			$x = 3;

			$tot_bpjs_vip = 0;
			$tot_umum_vip = 0;
			$tot_bpjs_1 = 0;
			$tot_umum_1 = 0;
			$tot_bpjs_2 = 0;
			$tot_umum_2 = 0;
			$tot_bpjs_3 = 0;
			$tot_umum_3 = 0;
			$tot_bpjs_icu = 0;
			$tot_umum_icu = 0;
			$tot_bpjs_hcu = 0;
			$tot_umum_hcu = 0;
			$tot_bpjs_isolasi = 0;
			$tot_umum_isolasi = 0;
			$tot_bpjs_rj = 0;
			$tot_umum_rj = 0;
			$tot_bpjs_rd = 0;
			$tot_umum_rd = 0;
			$tot_eks = 0;
			$tot_pasien_luar = 0;

			foreach ($data as $row) {
				if ($tampil == 'BLN') {
					$sheet->setCellValue('A' . $x, $row->tgl);
				} else {
					$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl)));
				}
				$sheet->setCellValue('B' . $x, $row->jml_bpjs_vip);
				$sheet->setCellValue('C' . $x, $row->jml_umum_vip);
				$sheet->setCellValue('D' . $x, $row->jml_bpjs_1);
				$sheet->setCellValue('E' . $x, $row->jml_umum_1);
				$sheet->setCellValue('F' . $x, $row->jml_bpjs_2);
				$sheet->setCellValue('G' . $x, $row->jml_umum_2);
				$sheet->setCellValue('H' . $x, $row->jml_bpjs_3);
				$sheet->setCellValue('I' . $x, $row->jml_umum_3);
				$sheet->setCellValue('J' . $x, $row->jml_bpjs_icu);
				$sheet->setCellValue('K' . $x, $row->jml_umum_icu);
				$sheet->setCellValue('L' . $x, $row->jml_bpjs_hcu);
				$sheet->setCellValue('M' . $x, $row->jml_umum_hcu);
				$sheet->setCellValue('N' . $x, $row->jml_isolasi_bpjs);
				$sheet->setCellValue('O' . $x, $row->jml_isolasi_umum);
				$sheet->setCellValue('P' . $x, $row->jml_bpjs_rj);
				$sheet->setCellValue('Q' . $x, $row->jml_umum_rj);
				$sheet->setCellValue('R' . $x, $row->jml_bpjs_rd);
				$sheet->setCellValue('S' . $x, $row->jml_umum_rd);
				$sheet->setCellValue('T' . $x, $row->jml_eks);
				$sheet->setCellValue('U' . $x, $row->jml_pasien_luar);
				$tot_bpjs_vip += $row->jml_bpjs_vip;
				$tot_umum_vip += $row->jml_umum_vip;
				$tot_bpjs_1 += $row->jml_bpjs_1;
				$tot_umum_1 += $row->jml_umum_1;
				$tot_bpjs_2 += $row->jml_bpjs_2;
				$tot_umum_2 += $row->jml_umum_2;
				$tot_bpjs_3 += $row->jml_bpjs_3;
				$tot_umum_3 += $row->jml_umum_3;
				$tot_bpjs_icu += $row->jml_bpjs_icu;
				$tot_umum_icu += $row->jml_umum_icu;
				$tot_bpjs_hcu += $row->jml_bpjs_hcu;
				$tot_umum_hcu += $row->jml_umum_hcu;
				$tot_bpjs_isolasi += $row->jml_isolasi_bpjs;
				$tot_umum_isolasi += $row->jml_isolasi_umum;
				$tot_bpjs_rj += $row->jml_bpjs_rj;
				$tot_umum_rj += $row->jml_umum_rj;
				$tot_bpjs_rd += $row->jml_bpjs_rd;
				$tot_umum_rd += $row->jml_umum_rd;
				$tot_eks += $row->jml_eks;
				$tot_pasien_luar += $row->jml_pasien_luar;
				$x++;
			}

			$sheet->setCellValue('A' . $x, 'TOTAL');
			$sheet->setCellValue('B' . $x, $tot_bpjs_vip);
			$sheet->setCellValue('C' . $x, $tot_umum_vip);
			$sheet->setCellValue('D' . $x, $tot_bpjs_1);
			$sheet->setCellValue('E' . $x, $tot_umum_1);
			$sheet->setCellValue('F' . $x, $tot_bpjs_2);
			$sheet->setCellValue('G' . $x, $tot_umum_2);
			$sheet->setCellValue('H' . $x, $tot_bpjs_3);
			$sheet->setCellValue('I' . $x, $tot_umum_3);
			$sheet->setCellValue('J' . $x, $tot_bpjs_icu);
			$sheet->setCellValue('K' . $x, $tot_umum_icu);
			$sheet->setCellValue('L' . $x, $tot_bpjs_hcu);
			$sheet->setCellValue('M' . $x, $tot_umum_hcu);
			$sheet->setCellValue('N' . $x, $tot_bpjs_isolasi);
			$sheet->setCellValue('O' . $x, $tot_umum_isolasi);
			$sheet->setCellValue('P' . $x, $tot_bpjs_rj);
			$sheet->setCellValue('Q' . $x, $tot_umum_rj);
			$sheet->setCellValue('R' . $x, $tot_bpjs_rd);
			$sheet->setCellValue('S' . $x, $tot_umum_rd);
			$sheet->setCellValue('T' . $x, $tot_eks);
			$sheet->setCellValue('U' . $x, $tot_pasien_luar);

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Kunjungan Labor ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_jml_kunjungan_dok()
		{
			$data['title'] = 'Laporan Jumlah Kunjungan Laboratorium Per Dokter';
			$this->load->view('lab/labvlapjml_kunj_dok', $data);
		}

		public function lap_jml_kunjungan_dok_exe($date, $tampil)
		{
			$hasil = $this->Labmlaporan->get_lap_jml_kunj_dok($date, $tampil)->result();

			$line  = array();
			$line2 = array();
			$row2  = array();
			$i = 1;

			foreach ($hasil as $value) {
				if ($tampil == 'BLN') {
					$row2['tgl'] = $value->tgl;
				} else {
					$row2['tgl'] = date("d-m-Y", strtotime($value->tgl));
				}
				$row2['jml_bpjs_ri_el'] = $value->jml_bpjs_ri_el;
				$row2['jml_umum_ri_el'] = $value->jml_umum_ri_el;
				$row2['jml_bpjs_rj_el'] = $value->jml_bpjs_rj_el;
				$row2['jml_umum_rj_el'] = $value->jml_umum_rj_el;
				$row2['jml_bpjs_ri_pat'] = $value->jml_bpjs_ri_pat;
				$row2['jml_umum_ri_pat'] = $value->jml_umum_ri_pat;
				$row2['jml_bpjs_rj_pat'] = $value->jml_bpjs_rj_pat;
				$row2['jml_umum_rj_pat'] = $value->jml_umum_rj_pat;
				$row2['jml_bpjs_isolasi_el'] = $value->jml_bpjs_isolasi_el;
				$row2['jml_umum_isolasi_el'] = $value->jml_umum_isolasi_el;
				$row2['jml_eks_el'] = $value->jml_eks_el;
				$row2['jml_bpjs_isolasi_pat'] = $value->jml_bpjs_isolasi_pat;
				$row2['jml_umum_isolasi_pat'] = $value->jml_umum_isolasi_pat;
				$row2['jml_eks_pat'] = $value->jml_eks_pat;
				$row2['jml_pl_el'] = $value->jml_pl_el;
				$row2['jml_pl_pat'] = $value->jml_pl_pat;
				$line2[] = $row2;
			}

			$line['data'] = $line2;

			echo json_encode($line);
		}

		public function excel_lap_jml_kunj_dok($date, $tampil)
		{
			if ($tampil == 'BLN') {
				$tgl = date("F Y", strtotime($date));
			} else {
				$tgl = date("d F Y", strtotime($date));
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A1:A3')
				->getCell('A1')
				->setValue('TGL');
			$sheet->mergeCells('B1:I1')
				->getCell('B1')
				->setValue('dr. Elhuriah, Sp. PK');
			$sheet->mergeCells('J1:Q1')
				->getCell('J1')
				->setValue('dr. Fatimah Yasin, Sp. PK');
			$sheet->mergeCells('B2:C2')
				->getCell('B2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('D2:E2')
				->getCell('D2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('F2:G2')
				->getCell('F2')
				->setValue('Isolasi');
			$sheet->mergeCells('H2:H3')
				->getCell('H2')
				->setValue('POLI Eksekutif');
			$sheet->mergeCells('I2:I3')
				->getCell('I2')
				->setValue('Pasien Luar');
			$sheet->mergeCells('J2:K2')
				->getCell('J2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('L2:M2')
				->getCell('L2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('N2:O2')
				->getCell('N2')
				->setValue('Isolasi');
			$sheet->mergeCells('P2:P3')
				->getCell('P2')
				->setValue('Poli Eksekuitf');
			$sheet->mergeCells('Q2:Q3')
				->getCell('Q2')
				->setValue('Pasien Luar');
			$sheet->setCellValue('B3', 'BPJS');
			$sheet->setCellValue('C3', 'UMUM');
			$sheet->setCellValue('D3', 'BPJS');
			$sheet->setCellValue('E3', 'UMUM');
			$sheet->setCellValue('F3', 'BPJS');
			$sheet->setCellValue('G3', 'UMUM');
			$sheet->setCellValue('J3', 'BPJS');
			$sheet->setCellValue('K3', 'UMUM');
			$sheet->setCellValue('L3', 'BPJS');
			$sheet->setCellValue('M3', 'UMUM');
			$sheet->setCellValue('N3', 'BPJS');
			$sheet->setCellValue('O3', 'UMUM');

			$data = $this->Labmlaporan->get_lap_jml_kunj_dok($date, $tampil)->result();

			$no = 1;
			$x = 4;

			$tot_bpjs_ri_el = 0;
			$tot_umum_ri_el = 0;
			$tot_bpjs_rj_el = 0;
			$tot_umum_rj_el = 0;
			$tot_bpjs_isolasi_el = 0;
			$tot_umum_isolasi_el = 0;
			$tot_eks_el = 0;
			$tot_pl_el = 0;
			$tot_bpjs_ri_pat = 0;
			$tot_umum_ri_pat = 0;
			$tot_bpjs_rj_pat = 0;
			$tot_umum_rj_pat = 0;
			$tot_bpjs_isolasi_pat = 0;
			$tot_umum_isolasi_pat = 0;
			$tot_eks_pat = 0;
			$tot_pl_pat = 0;

			foreach ($data as $row) {
				if ($tampil == 'BLN') {
					$sheet->setCellValue('A' . $x, $row->tgl);
				} else {
					$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl)));
				}
				$sheet->setCellValue('B' . $x, $row->jml_bpjs_ri_el);
				$sheet->setCellValue('C' . $x, $row->jml_umum_ri_el);
				$sheet->setCellValue('D' . $x, $row->jml_bpjs_rj_el);
				$sheet->setCellValue('E' . $x, $row->jml_umum_rj_el);
				$sheet->setCellValue('F' . $x, $row->jml_bpjs_isolasi_el);
				$sheet->setCellValue('G' . $x, $row->jml_umum_isolasi_el);
				$sheet->setCellValue('H' . $x, $row->jml_eks_el);
				$sheet->setCellValue('I' . $x, $row->jml_pl_el);
				$sheet->setCellValue('J' . $x, $row->jml_bpjs_ri_pat);
				$sheet->setCellValue('K' . $x, $row->jml_umum_ri_pat);
				$sheet->setCellValue('L' . $x, $row->jml_bpjs_rj_pat);
				$sheet->setCellValue('M' . $x, $row->jml_umum_rj_pat);
				$sheet->setCellValue('N' . $x, $row->jml_bpjs_isolasi_pat);
				$sheet->setCellValue('O' . $x, $row->jml_umum_isolasi_pat);
				$sheet->setCellValue('P' . $x, $row->jml_eks_pat);
				$sheet->setCellValue('Q' . $x, $row->jml_pl_pat);
				$tot_bpjs_ri_el += $row->jml_bpjs_ri_el;
				$tot_umum_ri_el += $row->jml_umum_ri_el;
				$tot_bpjs_rj_el += $row->jml_bpjs_rj_el;
				$tot_umum_rj_el += $row->jml_umum_rj_el;
				$tot_bpjs_isolasi_el += $row->jml_bpjs_isolasi_el;
				$tot_umum_isolasi_el += $row->jml_umum_isolasi_el;
				$tot_eks_el += $row->jml_eks_el;
				$tot_pl_el += $row->jml_pl_el;
				$tot_bpjs_ri_pat += $row->jml_bpjs_ri_pat;
				$tot_umum_ri_pat += $row->jml_umum_ri_pat;
				$tot_bpjs_rj_pat += $row->jml_bpjs_rj_pat;
				$tot_umum_rj_pat += $row->jml_umum_rj_pat;
				$tot_bpjs_isolasi_pat += $row->jml_bpjs_isolasi_pat;
				$tot_umum_isolasi_pat += $row->jml_umum_isolasi_pat;
				$tot_eks_pat += $row->jml_eks_pat;
				$tot_pl_pat += $row->jml_pl_pat;
				$x++;
			}

			$sheet->setCellValue('A' . $x, 'TOTAL');
			$sheet->setCellValue('B' . $x, $tot_bpjs_ri_el);
			$sheet->setCellValue('C' . $x, $tot_umum_ri_el);
			$sheet->setCellValue('D' . $x, $tot_bpjs_rj_el);
			$sheet->setCellValue('E' . $x, $tot_umum_rj_el);
			$sheet->setCellValue('F' . $x, $tot_bpjs_isolasi_el);
			$sheet->setCellValue('G' . $x, $tot_umum_isolasi_el);
			$sheet->setCellValue('H' . $x, $tot_eks_el);
			$sheet->setCellValue('I' . $x, $tot_pl_el);
			$sheet->setCellValue('J' . $x, $tot_bpjs_ri_pat);
			$sheet->setCellValue('K' . $x, $tot_umum_ri_pat);
			$sheet->setCellValue('L' . $x, $tot_bpjs_rj_pat);
			$sheet->setCellValue('M' . $x, $tot_umum_rj_pat);
			$sheet->setCellValue('N' . $x, $tot_bpjs_isolasi_pat);
			$sheet->setCellValue('O' . $x, $tot_umum_isolasi_pat);
			$sheet->setCellValue('P' . $x, $tot_eks_pat);
			$sheet->setCellValue('Q' . $x, $tot_pl_pat);

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Kunjungan Per Dokter Labor ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_pendapatan()
		{
			$data['title'] = 'Laporan Pendapatan Laboratorium';
			$data['jenis_lab'] = $this->Labmlaporan->get_jenis_lab()->result();
			$this->load->view('lab/labvlap_pendapatan', $data);
		}

		public function lap_pendapatan_exe($date, $jenis)
		{
			$hasil = $this->Labmlaporan->get_lap_pendapatan($date, $jenis)->result();

			$line  = array();
			$line2 = array();
			$row2  = array();
			$i = 1;

			foreach ($hasil as $value) {
				$jml_vip = $value->jml_vip ? ($value->jml_vip != '0' ? ($value->jml_vip) : 0) : 0;
				$total_vip = $value->total_vip ? ($value->total_vip != '0' ? ($value->total_vip) : 0) : 0;
				$jml_1 = $value->jml_1 ? ($value->jml_1 != '0' ? ($value->jml_1) : 0) : 0;
				$total_1 = $value->total_1 ? ($value->total_1 != '0' ? ($value->total_1) : 0) : 0;
				$jml_2 = $value->jml_2 ? ($value->jml_2 != '0' ? ($value->jml_2) : 0) : 0;
				$total_2 = $value->total_2 ? ($value->total_2 != '0' ? ($value->total_2) : 0) : 0;
				$jml_3 = $value->jml_3 ? ($value->jml_3 != '0' ? ($value->jml_3) : 0) : 0;
				$total_3 = $value->total_3 ? ($value->total_3 != '0' ? ($value->total_3) : 0) : 0;
				$jml_icu = $value->jml_icu ? ($value->jml_icu != '0' ? ($value->jml_icu) : 0) : 0;
				$total_icu = $value->total_icu ? ($value->total_icu != '0' ? ($value->total_icu) : 0) : 0;
				$jml_hcu = $value->jml_hcu ? ($value->jml_hcu != '0' ? ($value->jml_hcu) : 0) : 0;
				$total_hcu = $value->total_hcu ? ($value->total_hcu != '0' ? ($value->total_hcu) : 0) : 0;
				$jml_rj = $value->jml_rj ? ($value->jml_rj != '0' ? ($value->jml_rj) : 0) : 0;
				$total_rj = $value->total_rj ? ($value->total_rj != '0' ? ($value->total_rj) : 0) : 0;
				$jml_rd = $value->jml_rd ? ($value->jml_rd != '0' ? ($value->jml_rd) : 0) : 0;
				$total_rd = $value->total_rd ? ($value->total_rd != '0' ? ($value->total_rd) : 0) : 0;
				$jml_eks = $value->jml_eks ? ($value->jml_eks != '0' ? ($value->jml_eks) : 0) : 0;
				$total_eks = $value->total_eks ? ($value->total_eks != '0' ? ($value->total_eks) : 0) : 0;

				$row2['no'] = $i++;
				$row2['jenis_tindakan'] = $value->nmtindakan;
				$row2['tarif_vip'] = number_format($value->tarif_vip);
				$row2['tarif_1'] = number_format($value->tarif_1);
				$row2['tarif_2'] = number_format($value->tarif_2);
				$row2['tarif_3'] = number_format($value->tarif_3);
				$row2['tarif_nk'] = number_format($value->tarif_rj);
				$row2['tarif_eks'] = number_format($value->tarif_eks);
				$row2['jml_vip'] = $jml_vip;
				$row2['total_vip'] = number_format($total_vip);
				$row2['jml_1'] = $jml_1;
				$row2['total_1'] = number_format($total_1);
				$row2['jml_2'] = $jml_2;
				$row2['total_2'] = number_format($total_2);
				$row2['jml_3'] = $jml_3;
				$row2['total_3'] = number_format($total_3);
				$row2['jml_icu'] = $jml_icu;
				$row2['total_icu'] = number_format($total_icu);
				$row2['jml_hcu'] = $jml_hcu;
				$row2['total_hcu'] = number_format($total_hcu);
				$row2['jml_rj'] = $jml_rj;
				$row2['total_rj'] = number_format($total_rj);
				$row2['jml_rd'] = $jml_rd;
				$row2['total_rd'] = number_format($total_rd);
				$row2['jml_eks'] = $jml_eks;
				$row2['total_eks'] = number_format($total_eks);
				$line2[] = $row2;
			}

			$line['data'] = $line2;

			echo json_encode($line);
		}

		public function excel_lap_pendapatan($date, $jenis)
		{
			$tgl = date("F Y", strtotime($date));
			$nmtindakan = $this->Labmlaporan->get_nama_jenis_lab($jenis)->row()->nama_jenis;
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', $nmtindakan);
			$sheet->mergeCells('A2:A3')
				->getCell('A2')
				->setValue('No');
			$sheet->mergeCells('B2:B3')
				->getCell('B2')
				->setValue('Tindakan');
			$sheet->mergeCells('C2:E2')
				->getCell('C2')
				->setValue('VIP');
			$sheet->mergeCells('F2:H2')
				->getCell('F2')
				->setValue('Kelas 1');
			$sheet->mergeCells('I2:K2')
				->getCell('I2')
				->setValue('Kelas 2');
			$sheet->mergeCells('L2:N2')
				->getCell('L2')
				->setValue('Kelas 3');
			$sheet->mergeCells('O2:Q2')
				->getCell('O2')
				->setValue('ICU');
			$sheet->mergeCells('R2:T2')
				->getCell('R2')
				->setValue('HCU');
			$sheet->mergeCells('U2:W2')
				->getCell('U2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('X2:Z2')
				->getCell('X2')
				->setValue('IGD');
			$sheet->mergeCells('AA2:AC2')
				->getCell('AA2')
				->setValue('Poli Eksekuitf');
			$sheet->setCellValue('C3', 'JML');
			$sheet->setCellValue('D3', 'Tarif');
			$sheet->setCellValue('E3', 'Penerimaan');
			$sheet->setCellValue('F3', 'JML');
			$sheet->setCellValue('G3', 'Tarif');
			$sheet->setCellValue('H3', 'Penerimaan');
			$sheet->setCellValue('I3', 'JML');
			$sheet->setCellValue('J3', 'Tarif');
			$sheet->setCellValue('K3', 'Penerimaan');
			$sheet->setCellValue('L3', 'JML');
			$sheet->setCellValue('M3', 'Tarif');
			$sheet->setCellValue('N3', 'Penerimaan');
			$sheet->setCellValue('O3', 'JML');
			$sheet->setCellValue('P3', 'Tarif');
			$sheet->setCellValue('Q3', 'Penerimaan');
			$sheet->setCellValue('R3', 'JML');
			$sheet->setCellValue('S3', 'Tarif');
			$sheet->setCellValue('T3', 'Penerimaan');
			$sheet->setCellValue('U3', 'JML');
			$sheet->setCellValue('V3', 'Tarif');
			$sheet->setCellValue('W3', 'Penerimaan');
			$sheet->setCellValue('X3', 'JML');
			$sheet->setCellValue('Y3', 'Tarif');
			$sheet->setCellValue('Z3', 'Penerimaan');
			$sheet->setCellValue('AA3', 'JML');
			$sheet->setCellValue('AB3', 'Tarif');
			$sheet->setCellValue('AC3', 'Penerimaan');

			$data = $this->Labmlaporan->get_lap_pendapatan($date, $jenis)->result();

			$no = 1;
			$x = 4;

			foreach ($data as $value) {
				$jml_vip = $value->jml_vip ? ($value->jml_vip != '0' ? ($value->jml_vip) : 0) : 0;
				$total_vip = $value->total_vip ? ($value->total_vip != '0' ? ($value->total_vip) : 0) : 0;
				$jml_1 = $value->jml_1 ? ($value->jml_1 != '0' ? ($value->jml_1) : 0) : 0;
				$total_1 = $value->total_1 ? ($value->total_1 != '0' ? ($value->total_1) : 0) : 0;
				$jml_2 = $value->jml_2 ? ($value->jml_2 != '0' ? ($value->jml_2) : 0) : 0;
				$total_2 = $value->total_2 ? ($value->total_2 != '0' ? ($value->total_2) : 0) : 0;
				$jml_3 = $value->jml_3 ? ($value->jml_3 != '0' ? ($value->jml_3) : 0) : 0;
				$total_3 = $value->total_3 ? ($value->total_3 != '0' ? ($value->total_3) : 0) : 0;
				$jml_icu = $value->jml_icu ? ($value->jml_icu != '0' ? ($value->jml_icu) : 0) : 0;
				$total_icu = $value->total_icu ? ($value->total_icu != '0' ? ($value->total_icu) : 0) : 0;
				$jml_hcu = $value->jml_hcu ? ($value->jml_hcu != '0' ? ($value->jml_hcu) : 0) : 0;
				$total_hcu = $value->total_hcu ? ($value->total_hcu != '0' ? ($value->total_hcu) : 0) : 0;
				$jml_rj = $value->jml_rj ? ($value->jml_rj != '0' ? ($value->jml_rj) : 0) : 0;
				$total_rj = $value->total_rj ? ($value->total_rj != '0' ? ($value->total_rj) : 0) : 0;
				$jml_rd = $value->jml_rd ? ($value->jml_rd != '0' ? ($value->jml_rd) : 0) : 0;
				$total_rd = $value->total_rd ? ($value->total_rd != '0' ? ($value->total_rd) : 0) : 0;
				$jml_eks = $value->jml_eks ? ($value->jml_eks != '0' ? ($value->jml_eks) : 0) : 0;
				$total_eks = $value->total_eks ? ($value->total_eks != '0' ? ($value->total_eks) : 0) : 0;

				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $value->nmtindakan);
				$sheet->setCellValue('C' . $x, $jml_vip);
				$sheet->setCellValue('D' . $x, number_format($value->tarif_vip));
				$sheet->setCellValue('E' . $x, number_format($total_vip));
				$sheet->setCellValue('F' . $x, $jml_1);
				$sheet->setCellValue('G' . $x, number_format($value->tarif_1));
				$sheet->setCellValue('H' . $x, number_format($total_1));
				$sheet->setCellValue('I' . $x, $jml_2);
				$sheet->setCellValue('J' . $x, number_format($value->tarif_2));
				$sheet->setCellValue('K' . $x, number_format($total_2));
				$sheet->setCellValue('L' . $x, $jml_3);
				$sheet->setCellValue('M' . $x, number_format($value->tarif_3));
				$sheet->setCellValue('N' . $x, number_format($total_3));
				$sheet->setCellValue('O' . $x, $jml_icu);
				$sheet->setCellValue('P' . $x, number_format($value->tarif_1));
				$sheet->setCellValue('Q' . $x, number_format($total_icu));
				$sheet->setCellValue('R' . $x, $jml_hcu);
				$sheet->setCellValue('S' . $x, number_format($value->tarif_2));
				$sheet->setCellValue('T' . $x, number_format($total_hcu));
				$sheet->setCellValue('U' . $x, $jml_rj);
				$sheet->setCellValue('V' . $x, number_format($value->tarif_rj));
				$sheet->setCellValue('W' . $x, number_format($total_rj));
				$sheet->setCellValue('X' . $x, $jml_rd);
				$sheet->setCellValue('Y' . $x, number_format($value->tarif_rj));
				$sheet->setCellValue('Z' . $x, number_format($total_rd));
				$sheet->setCellValue('AA' . $x, $jml_eks);
				$sheet->setCellValue('AB' . $x, number_format($value->tarif_eks));
				$sheet->setCellValue('AC' . $x, number_format($total_eks));
				$x++;
			}

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pendapatan Labor ' . $tgl . ' - ' . $nmtindakan;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_jml_pemeriksaan()
		{
			$date = $this->input->post('date_days');
			$month = $this->input->post('date_months');
			$tampil = $this->input->post('tampil_per');

			if ($tampil == 'TGL') {
				$data['title'] = 'Laporan Pemeriksaan Pasien Laboratorium ' . date("d F Y", strtotime($date));
				$data['date'] = date("d F Y", strtotime($date));
				$data['tanggal'] = $date;
				$data['tampil'] = $tampil;
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_pemeriksaan_per_parameter($date, $tampil)->result();
			} else if ($tampil == 'BLN') {
				$data['title'] = 'Laporan Pemeriksaan Pasien Laboratorium ' . date("F Y", strtotime($month));
				$data['date'] = date("F Y", strtotime($month));
				$data['tanggal'] = $month;
				$data['tampil'] = $tampil;
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_pemeriksaan_per_parameter($month, $tampil)->result();
			} else {
				$tgl = date('Y-m-d');
				$data['title'] = 'Laporan Pemeriksaan Pasien Laboratorium ' . date("d F Y", strtotime($tgl));
				$data['date'] = date("d F Y", strtotime($tgl));
				$data['tanggal'] = $tgl;
				$data['tampil'] = 'TGL';
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_pemeriksaan_per_parameter($tgl, 'TGL')->result();
			}
			$this->load->view('lab/lap_jml_pemeriksaan', $data);
		}

		public function lap_capkin()
		{
			$date = $this->input->post('date_days');
			$month = $this->input->post('date_months');
			$tampil = $this->input->post('tampil_per');

			if ($tampil == 'TGL') {
				$data['title'] = 'Laporan Capaian Kinerja Pelayanan Instalasi Laboratorium ' . date("d F Y", strtotime($date));
				$data['date'] = date("d F Y", strtotime($date));
				$data['tanggal'] = $date;
				$data['tampil'] = $tampil;
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_capkin($date, $tampil)->result();
			} else if ($tampil == 'BLN') {
				$data['title'] = 'Laporan Capaian Kinerja Pelayanan Instalasi Laboratorium ' . date("F Y", strtotime($month));
				$data['date'] = date("F Y", strtotime($month));
				$data['tanggal'] = $month;
				$data['tampil'] = $tampil;
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_capkin($month, $tampil)->result();
			} else {
				$tgl = date('Y-m-d');
				$data['title'] = 'Laporan Capaian Kinerja Pelayanan Instalasi Laboratorium ' . date("d F Y", strtotime($tgl));
				$data['date'] = date("d F Y", strtotime($tgl));
				$data['tanggal'] = $tgl;
				$data['tampil'] = 'TGL';
				$data['lap_pemeriksaan'] = $this->Labmlaporan->get_lap_capkin($tgl, 'TGL')->result();
			}
			$this->load->view('lab/lap_capkin', $data);
		}

		public function excel_lap_capkin($date, $tampil)
		{
			if ($tampil == 'TGL') {
				$tgl = date("d F Y", strtotime($date));
			} else {
				$tgl = date("F Y", strtotime($date));
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A1:A3')
				->getCell('A1')
				->setValue('No');
			$sheet->mergeCells('B1:B3')
				->getCell('B1')
				->setValue('Pelayanan');
			$sheet->mergeCells('C1:K1')
				->getCell('C1')
				->setValue('dr. Elhuriyah, Sp. PK');
			$sheet->mergeCells('L1:T1')
				->getCell('L1')
				->setValue('dr. Fatimah Yasin, Sp. PK');
			$sheet->mergeCells('C2:E2')
				->getCell('C2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('F2:H2')
				->getCell('F2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('I2:I3')
				->getCell('I2')
				->setValue('Eksekutif');
			$sheet->mergeCells('J2:J3')
				->getCell('J2')
				->setValue('Isolasi');
			$sheet->mergeCells('K2:K3')
				->getCell('K2')
				->setValue('Jumlah');
			$sheet->mergeCells('L2:N2')
				->getCell('L2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('O2:Q2')
				->getCell('O2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('R2:R3')
				->getCell('R2')
				->setValue('Eksekutif');
			$sheet->mergeCells('S2:S3')
				->getCell('S2')
				->setValue('Isolasi');
			$sheet->mergeCells('T2:T3')
				->getCell('T2')
				->setValue('Jumlah');
			$sheet->setCellValue('C3', 'BPJS');
			$sheet->setCellValue('D3', 'UMUM');
			$sheet->setCellValue('E3', 'IKS');
			$sheet->setCellValue('F3', 'BPJS');
			$sheet->setCellValue('G3', 'UMUM');
			$sheet->setCellValue('H3', 'IKS');
			$sheet->setCellValue('L3', 'BPJS');
			$sheet->setCellValue('M3', 'UMUM');
			$sheet->setCellValue('N3', 'IKS');
			$sheet->setCellValue('O3', 'BPJS');
			$sheet->setCellValue('P3', 'UMUM');
			$sheet->setCellValue('Q3', 'IKS');

			$data = $this->Labmlaporan->get_lap_capkin($date, $tampil)->result();

			$i = 1;
			$indexes = ['Pemeriksaan Laboratorium', 'Jumlah Pasien', 'Penerimaan'];
			$indes = 0;
			$x = 4;
			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $i++);
				$sheet->setCellValue('B' . $x, $indexes[$indes]);
				$sheet->setCellValue('C' . $x, $row->el_ri_bpjs);
				$sheet->setCellValue('D' . $x, $row->el_ri_umum);
				$sheet->setCellValue('E' . $x, $row->el_ri_iks);
				$sheet->setCellValue('F' . $x, $row->el_rj_bpjs);
				$sheet->setCellValue('G' . $x, $row->el_rj_umum);
				$sheet->setCellValue('H' . $x, $row->el_rj_iks);
				$sheet->setCellValue('I' . $x, $row->el_eksekutif);
				$sheet->setCellValue('J' . $x, $row->el_isolasi);
				$sheet->setCellValue('K' . $x, $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi);
				$sheet->setCellValue('L' . $x, $row->f_ri_bpjs);
				$sheet->setCellValue('M' . $x, $row->f_ri_umum);
				$sheet->setCellValue('N' . $x, $row->f_ri_iks);
				$sheet->setCellValue('O' . $x, $row->f_rj_bpjs);
				$sheet->setCellValue('P' . $x, $row->f_rj_umum);
				$sheet->setCellValue('Q' . $x, $row->f_rj_iks);
				$sheet->setCellValue('R' . $x, $row->f_eksekutif);
				$sheet->setCellValue('S' . $x, $row->f_isolasi);
				$sheet->setCellValue('T' . $x, $row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi);
				$x++;
				$indes++;
			}

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Capaian Kinerja Laboratorium ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function excel_lap_jml_pemeriksaan($date, $tampil)
		{
			if ($tampil == 'TGL') {
				$tgl = date("d F Y", strtotime($date));
			} else {
				$tgl = date("F Y", strtotime($date));
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->mergeCells('A1:A3')
				->getCell('A1')
				->setValue('No');
			$sheet->mergeCells('B1:B3')
				->getCell('B1')
				->setValue('Jenis Pemeriksaan');
			$sheet->mergeCells('C1:K1')
				->getCell('C1')
				->setValue('dr. Elhuriyah, Sp. PK');
			$sheet->mergeCells('L1:T1')
				->getCell('L1')
				->setValue('dr. Fatimah Yasin, Sp. PK');
			$sheet->mergeCells('C2:E2')
				->getCell('C2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('F2:H2')
				->getCell('F2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('I2:I3')
				->getCell('I2')
				->setValue('Eksekutif');
			$sheet->mergeCells('J2:J3')
				->getCell('J2')
				->setValue('Isolasi');
			$sheet->mergeCells('K2:K3')
				->getCell('K2')
				->setValue('Jumlah');
			$sheet->mergeCells('L2:N2')
				->getCell('L2')
				->setValue('Rawat Inap');
			$sheet->mergeCells('O2:Q2')
				->getCell('O2')
				->setValue('Rawat Jalan');
			$sheet->mergeCells('R2:R3')
				->getCell('R2')
				->setValue('Eksekutif');
			$sheet->mergeCells('S2:S3')
				->getCell('S2')
				->setValue('Isolasi');
			$sheet->mergeCells('T2:T3')
				->getCell('T2')
				->setValue('Jumlah');
			$sheet->setCellValue('C3', 'BPJS');
			$sheet->setCellValue('D3', 'UMUM');
			$sheet->setCellValue('E3', 'IKS');
			$sheet->setCellValue('F3', 'BPJS');
			$sheet->setCellValue('G3', 'UMUM');
			$sheet->setCellValue('H3', 'IKS');
			$sheet->setCellValue('L3', 'BPJS');
			$sheet->setCellValue('M3', 'UMUM');
			$sheet->setCellValue('N3', 'IKS');
			$sheet->setCellValue('O3', 'BPJS');
			$sheet->setCellValue('P3', 'UMUM');
			$sheet->setCellValue('Q3', 'IKS');

			$data = $this->Labmlaporan->get_lap_pemeriksaan_per_parameter($date, $tampil)->result();

			$i = 1;
			$x = 4;
			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $i++);
				$sheet->setCellValue('B' . $x, $row->jenis_tindakan);
				$sheet->setCellValue('C' . $x, $row->el_ri_bpjs);
				$sheet->setCellValue('D' . $x, $row->el_ri_umum);
				$sheet->setCellValue('E' . $x, $row->el_ri_iks);
				$sheet->setCellValue('F' . $x, $row->el_rj_bpjs);
				$sheet->setCellValue('G' . $x, $row->el_rj_umum);
				$sheet->setCellValue('H' . $x, $row->el_rj_iks);
				$sheet->setCellValue('I' . $x, $row->el_eksekutif);
				$sheet->setCellValue('J' . $x, $row->el_isolasi);
				$sheet->setCellValue('K' . $x, $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi);
				$sheet->setCellValue('L' . $x, $row->f_ri_bpjs);
				$sheet->setCellValue('M' . $x, $row->f_ri_umum);
				$sheet->setCellValue('N' . $x, $row->f_ri_iks);
				$sheet->setCellValue('O' . $x, $row->f_rj_bpjs);
				$sheet->setCellValue('P' . $x, $row->f_rj_umum);
				$sheet->setCellValue('Q' . $x, $row->f_rj_iks);
				$sheet->setCellValue('R' . $x, $row->f_eksekutif);
				$sheet->setCellValue('S' . $x, $row->f_isolasi);
				$sheet->setCellValue('T' . $x, $row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi);
				$x++;
			}

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemeriksaan Pasien Laboratorium ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}

		public function lap_daftar_hasil_lab()
		{
			$date = $this->input->post('date_days');
			$month = $this->input->post('date_months');
			$tampil_per = $this->input->post('tampil_per');
			$filter_darah = $this->input->post('filter_darah');
			//  var_dump($filter_darah);die();
			if ($tampil_per == 'TGL') {
				$data['title'] = 'Laporan Daftar Hasil Pasien Laboratorium | ' . date("d F Y", strtotime($date));
				$data['date'] = date("d F Y", strtotime($date));
				$data['tanggal'] = $date;
				$data['tampil'] = $tampil_per;
				$data['filter_darah'] = $filter_darah;
				$data['lap_daftar_hasil'] = $this->Labmlaporan->get_lap_daftar_hasil_pasien_lab('TGL', $date, $data['filter_darah'])->result();
			} else if ($tampil_per == 'BLN') {
				$data['title'] = 'Laporan Daftar Hasil Pasien Laboratorium | ' . date("F Y", strtotime($month));
				$data['date'] = date("F Y", strtotime($month));
				$data['tanggal'] = $month;
				$data['tampil'] = $tampil_per;
				$data['filter_darah'] = $filter_darah;
				// var_dump($data['filter_darah']);die();
				$data['lap_daftar_hasil'] = $this->Labmlaporan->get_lap_daftar_hasil_pasien_lab('BLN', $month, $data['filter_darah'])->result();
			} else {
				$tgl = date('Y-m-d');
				$data['title'] = 'Laporan Daftar Hasil Pasien Laboratorium | ' . date("d F Y", strtotime($tgl));
				$data['date'] = date("d F Y", strtotime($tgl));
				$data['tanggal'] = $tgl;
				$data['tampil'] = 'TGL';
				$data['filter_darah'] = "semua";
				$data['lap_daftar_hasil'] = $this->Labmlaporan->get_lap_daftar_hasil_pasien_lab('TGL', $tgl, $data['filter_darah'])->result();
			}
			$this->load->view('lab/lap_daftar_hasil', $data);
		}

		public function excel_lap_daftar_hasil($tampil, $date, $filter_darah)
		{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Jenis Pemeriksaan');
			$sheet->setCellValue('C1', 'Tgl Pemeriksaan');
			$sheet->setCellValue('D1', 'No RM');
			$sheet->setCellValue('E1', 'Nama');
			$sheet->setCellValue('F1', 'Urgensi');
			$sheet->setCellValue('G1', 'Nilai Kritis');
			$sheet->setCellValue('H1', 'Tarif Rumah Sakit');
			$sheet->setCellValue('I1', 'Asal');
			$sheet->setCellValue('J1', 'Kelas');
			$sheet->setCellValue('K1', 'Jaminan');
			$sheet->setCellValue('L1', 'Waktu Mulai Pemeriksaan');
			$sheet->setCellValue('M1', 'Waktu Selesai Pemeriksaan');
			$sheet->setCellValue('N1', 'Dokter');

			if ($tampil == 'TGL') {
				$tgl = date("d F Y", strtotime($date));
				$data = $this->Labmlaporan->get_lap_daftar_hasil_pasien_lab('TGL', $date, $filter_darah)->result();
			} else {
				$tgl = date("F Y", strtotime($date));
				$data = $this->Labmlaporan->get_lap_daftar_hasil_pasien_lab('BLN', $date, $filter_darah)->result();
			}

			$i = 1;
			$x = 2;

			foreach ($data as $row) {
				$sheet->setCellValue('A' . $x, $i++);
				$sheet->setCellValue('B' . $x, $row->jenis_tindakan);
				$sheet->setCellValue('C' . $x, $row->tgl);
				$sheet->setCellValue('D' . $x, $row->no_medrec);
				$sheet->setCellValue('E' . $x, $row->nama);
				if ($row->cito != '1') {
					$sheet->setCellValue('F' . $x, 'TIDAK');
				} else {
					$sheet->setCellValue('F' . $x, 'YA');
				}
				$sheet->setCellValue('G' . $x, '');
				$sheet->setCellValue('H' . $x, number_format($row->biaya_lab));
				$sheet->setCellValue('I' . $x, $row->asal);
				$sheet->setCellValue('J' . $x, $row->kelas);
				$sheet->setCellValue('K' . $x, $row->cara_bayar);
				$sheet->setCellValue('L' . $x, date("d-m-Y H:i:s", strtotime($row->tgl_mulai_pemeriksaan)));
				$sheet->setCellValue('M' . $x, date("d-m-Y H:i:s", strtotime($row->tgl_selesai_pemeriksaan)));
				$sheet->setCellValue('N' . $x, $row->nm_dokter);
				$x++;
			}

			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Daftar Hasil Pasien Laboratorium ' . $tgl;
			ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}
	}

	?>
