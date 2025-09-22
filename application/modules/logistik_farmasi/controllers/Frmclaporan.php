<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class MyReadFilter implements PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
	public function readCell($columnAddress, $row, $worksheetName = '')
    {
        // Read rows 1 to 7 and columns A to E only
        if ($row >= 1 ) {
            if (in_array($columnAddress, ['A'])) {
                return true;
            }
        }

        return false;
    }
}

class Frmclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelLaporan','',TRUE);
		$this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
		$this->load->model('logistik_farmasi/Frmmlaporan','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','', TRUE);
		$this->load->model('Master/Mmobat','', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		// redirect('logistik_farmasi/Frmcdaftar','refresh');
	}

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';
		

		if($_SERVER['REQUEST_METHOD']=='POST'){			
				$tgl_indo=new Tglindo();
				//$tgl_awal=$this->input->post('date_picker_days1');
				//if(){
				//}
				$tgl=$this->input->post('date_picker_days');					
				
				$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_by_date($tgl)->result();
				$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan_tgl($tgl)->result();
				
				$tgl1 = date('d F Y', strtotime($tgl));
				$data['date_title']="Laporan Kunjungan Farmasi <b>$tgl1</b>";
				$data['field1']='No. Medrec';					
				$data['tgl']=$tgl;
				
			
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

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan()->result();
			
			$data['date_title']='Laporan Kunjungan Pasien Farmasi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';	
			
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

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
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

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Logistik Farmasi';				

		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
					$data['data_laporan_detail_keu']=$this->Frmmlaporan->get_data_keu_detail_tgl($tgl)->result();
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;
					$data['cara_bayar_pasien']='';
					
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');			
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
					$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
					// $cara_bayar=$this->input->post('jenis_pasien1');	
					// $data['jenis_bayar']=$this->input->post('jenis_pasien1');			
					
					$bln1 = date('Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					//echo $tgl_indo->bulan('08');
					$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
					$data['field1']='Bulan'; //edited
					$data['tgl']=$bln3;
					$data['bln']=$bln;
					$data['date']=$bln;//untuk param waktu cetak

				}else{					
					
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_thn($thn)->result();
					$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
					$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();		
					
					$data['date_title']="per Bulan <b> Tahun $thn</b>";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					$data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_keu']);
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

			 $this->load->view('logistik_farmasi/pend_today',$data);
		}else{			
			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tindakan_today()->result();
			$data['data_laporan_detail_keu']=$this->Frmmlaporan->get_data_keu_detail_tgl(date('Y-m-d'))->result();
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Register';
			$data['stat_pilih']='';
			$data['tampil_per']='TGL';
			$data['cara_bayar_pasien']="";

			$size=sizeof($data['data_laporan_keu']);
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

			$this->load->view('logistik_farmasi/pend_today',$data);
			//redirect('ird/IrDLaporan/data','refresh');
		}
	}

    public function data_pendapatan_new($tampil_per='', $param1=''){

        $data['title'] = 'Laporan Pembelian Per Nomor Faktur & Detail Obat';

      //  $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        /*$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-primary alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pembelian.
			</h4>							
			</div>
		</div>";*/
        $data['message_nodata'] = "Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pembelian";

        $this->load->view('logistik_farmasi/frmvlaporanpembelian',$data);
    }

	public function lap_keu($tampil_per='',$param1='')
	{
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam=date("d-m-Y H:i:s");
		
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_LOG_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_laporan_detail_keu=$this->Frmmlaporan->get_data_keu_detail_tgl($tgl)->result();
				$konten=
						"<style>
						tr.border_bottom td {
						  border-top:1pt solid black;
						}
						</style>
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
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
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pembelian Logistik Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>$tampil_per</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						
						<table border=\"1\"   style=\"padding:2px\">
						<thead>
							<tr>
								<th width=\"5%\">No</th>
								<th width=\"25%\">Supplier</th>
								<th width=\"70%\">Rincian Obat</th>							
							</tr>
						</thead>
						<tbody>
							
			";
			
			
					$i=0;
					foreach($data_laporan_keu as $row){
						$supplier=$row->supplier_id;
						$konten=$konten."<tr>
							<td width=\"5%\">".$i++."</td>
							<td width=\"25%\">".$row->company_name."</td>
							<td width=\"70%\">";
					
						$konten=$konten."<table width=\"100%\" >
						<thead>
							<tr class=\"border_bottom\">
								<th width=\"5%\" >No</th>
								<th width=\"30%\">Nama Obat</th>
								<th width=\"25%\">Quantity</th>
								<th width=\"40%\">Nilai</th>											
							</tr>
						</thead>
						<tbody>";
						
						$j=1;$vtot1=0;
						foreach($data_laporan_detail_keu as $row1){
							if($row1->supplier_id==$supplier){
								$vtot1=$vtot1+$row1->item_cost_price;
								
								$konten=$konten."<tr class=\"border_bottom\"><td>".$j."</td>
									<td>".$row1->description."</td>
									<td>".$row1->quantity_purchased."</td>
									<td>".number_format( $row1->item_cost_price, 2 , ',' , '.' )."</td></tr>";
								$j++;
							}
						}
						$konten=$konten."</tbody>
						</table>
					</td>

				</tr>";
						
			}
			$konten=$konten."</tbody>
					</table>					
					<h4 align=\"right\"><b>Total Transaksi : ".$vtot1."<b></h4>";
						
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
						
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				$bln2 = date('F', strtotime($bln));				
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_FRM_$bln1.pdf";
			
					$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
					$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
						//$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						//$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pembelian Logistik Farmasi</b></p></td>
							</tr>
							<hr>
							
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
							</tr>
						</table>
						<br/>";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row1){
							$cek_tgl=$row1->tgl;
						$konten=$konten."<h4><b>Tanggal ".substr($row1->tgl, 8, 2)." ".$bln2."</b></h4>
		<hr>
									<table border=\"1\" >
									<thead>
										<tr>
											<th width=\"5%\"><b>No</b></th>
											<th width=\"40%\"><b>Nama Supplier</b></th>
											<th width=\"10%\"><b>Qty</b></th>
											<th width=\"45%\"><b>Total</b></th>
										</tr>
									</thead>
									<tbody>
								";
															
									$j=1;
									$vtot1=0;
									foreach($data_keuangan as $row2){
										if($row2->tgl==$row1->tgl){
											$vtot1=$vtot1+$row2->total;
											$vtot=$vtot+$row2->total;									
												
											$konten=$konten."
												<tr><td width=\"5%\">".$i++."</td>
													<td width=\"40%\">$row2->company_name</td>
													<td width=\"10%\">$row2->jumlah</td>
													<td width=\"45%\">".number_format($row2->total, 2 , ',' , '.' )."</td>
												</tr>";
										$j++;
										}
									}
									$konten=$konten."
												<tr>
													<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
													<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
												</tr>
									</tbody>
		</table>";
								}
									$konten=$konten."
									<h4 align=\"center\"><b>Total $date_title</b></h4>
										<h4 align=\"center\">".number_format($vtot, 2 , ',' , '.' )."</h4>
				";//echo $konten;
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_LOG_FRM_$thn1.pdf";
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
					
					
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
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
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pendapatan Logistik Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								
								
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Bulan</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Supplier</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2 ==''){
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$row2->bln</td>";
										}
									$konten=$konten."
											<td>$row2->company_name</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							
						</table>
						<h3 bgcolor=\"yellow\"align=\"right\">Total $date_title : Rp. ".number_format($vtot, 2 , ',' , '.' )."</h3>
				";
			//print_r($data_laporan_keu);
			//echo $konten;

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}
	}

	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';

		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);

		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');

		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RS H RABAIN MUARA ENIM")  
		        ->setLastModifiedBy("RS H RABAIN MUARA ENIM")  
		        ->setTitle("Laporan Keuangan RS H RABAIN MUARA ENIM")  
		        ->setSubject("Laporan Keuangan RS RS H RABAIN MUARA ENIM")  
		        ->setDescription("Laporan Keuangan RS H RABAIN MUARA ENIM for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("RS H RABAIN MUARA ENIM")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_LOG_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
				
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 5;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->vtot;
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->company_name);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->description);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->quantity_purchased);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->item_cost_price);
								$rowCount++;
								$i++;
						}	
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot1);
							header('Content-Disposition: attachment;filename="Lap_Keu_Logistik_Farmasi_TGL.xlsx"'); 
						
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
								
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_LOG_FRM_$bln1.pdf";

				
						$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();		
						$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_bln.xlsx');
						// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
						$objPHPExcel->setActiveSheetIndex(0);  

						// Add some data  
						$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
						$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : '.$bln1);

				//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
						$rowCount=6;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
							$rwspn1=$rwspn+1;

							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl);
											$i++;
										}
									
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->description);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
								$j++;
							    $rowCount++;
								}
							}
									
						}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total', $date_title);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);		
										
								header('Content-Disposition: attachment;filename="Lap_Keu_Logistik_Farmasi_Bulan.xlsx"');  
					}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
							
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_FRM_$thn1.pdf";

				if($param2==''){
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
						$cara_bayar_pasien='Semua';
					} 
			
					$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_thn.xlsx');
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
					$objPHPExcel->setActiveSheetIndex(0);  

					// Add some data  
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
					$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : '.$thn);


						$jenis_param2="Semua";
					
					//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
					
						$rowCount = 6;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									
									$vtot=$vtot+$row2->total;
									
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->bln);
											
											$i++;
										}
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->description);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
									$j++;
							    	$rowCount++;
								}
							}	
										
						}
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total', $date_title);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);
						header('Content-Disposition: attachment;filename="Lap_Pembelian_Logistik_Farmasi_Tahun.xlsx"');  
				}else{
					redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
				}
			}

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS H RABAIN MUARA ENIM');  
		   
		   
		   
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
	  public function lihat_pembelian($param1='',$param2=''){

        $data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();

        
        $rowCount = 4;
        $temp = "";
        $i=1;

		$tdiskon = 0; $tppn = 0; $tmaterai = 0; $ttot = 0;
        foreach($data_keuangan as $row){
            $tplusdiskon = $row->total_obat - $row->diskon_item;
            $tplusdiskonplusdiskon = $tplusdiskon - $row->diskon;
            //Jika PPN
            if($row->ppn == 1){
                $ppn = ($tplusdiskonplusdiskon*10) / 100;
            }else{
                $ppn = 0;
            }
            $subtotal = $tplusdiskonplusdiskon + $ppn + $row->materai;

            $tdiskon += $row->diskon_item;
            $tppn += $ppn;
            $tmaterai += $row->materai;
            $ttot += $subtotal;

            if($temp == $row->id_po){
                $res['no_po'] = "";
	            $res['no_faktur'] = "";
	            $res['tgl_po'] = "";
	            $res['jatuh_tempo'] = "";
	            $res['company_name'] = "";
	            $res['description'] = $row->description;
	            $res['qty_beli'] = $row->qty_beli;
	            $res['satuank'] = $row->satuank;
	            $res['harga_po'] = $row->harga_po;
	            $res['diskon_item'] = $row->diskon_item;
	            $res['tplusdiskon'] = $tplusdiskon;
	            $res['diskon'] = $row->diskon;
	            $res['ppn'] = $ppn;
	            $res['materai'] = $row->materai;
	            $res['subtotal'] = $subtotal;
            }else {
                $temp = $row->id_po;
	            $res['no_po'] = $row->no_po;
	            $res['no_faktur'] = $row->no_faktur;
	            $res['tgl_po'] = $row->tgl_po;
	            $res['jatuh_tempo'] = $row->jatuh_tempo;
	            $res['company_name'] = $row->company_name;
	            $res['description'] = $row->description;
	            $res['qty_beli'] = $row->qty_beli;
	            $res['satuank'] = $row->satuank;
	            $res['harga_po'] = $row->harga_po;
	            $res['diskon_item'] = $row->diskon_item;
	            $res['tplusdiskon'] = $tplusdiskon;
	            $res['diskon'] = $row->diskon;
	            $res['ppn'] = $ppn;
	            $res['materai'] = $row->materai;
	            $res['subtotal'] = $subtotal;
            }
            $i++;
            $rowCount++;
        }

        // $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $tdiskon);
        // $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tppn);
        // $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $tmaterai);
        // $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $ttot);
    	echo json_encode($res);

    }
    public function download_pembelian($param1='',$param2='', $filter=''){
        ////EXCEL 
        /*$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();
        echo "<pre>";
        echo print_r($data_keuangan);
        echo "</pre>";*/

        $this->load->library('Excel');

        // Create new PHPExcel object  
        $objPHPExcel = new PHPExcel();

        // Set document properties  
        $objPHPExcel->getProperties()->setCreator("RSAL Dr. Mintohardjo")
            ->setLastModifiedBy("RSAL Dr. Mintohardjo")
            ->setTitle("Laporan Pembelian Obat")
            ->setSubject("Laporan Pembelian Obat")
            ->setDescription("Laporan Pembelian Obat, generated by HMIS.")
            ->setKeywords("RSAL Dr. Mintohardjo")
            ->setCategory("Laporan Pembelian Obat");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2, $filter)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pembelian_obat.xlsx');
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

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pembelian Obat Per Faktur Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Filter Berdasarkan: ".$filter);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCount = 4;
        $temp = "";
        $i=1;
        $tdiskon = 0; $tppn = 0; $tmaterai = 0; $ttot = 0;
        foreach($data_keuangan as $row){
            $tplusdiskon = $row->total_obat - $row->diskon_item;
            $tplusdiskonplusdiskon = $tplusdiskon - $row->diskon;
            //Jika PPN
            if($row->ppn == 1){
                $ppn = ($tplusdiskonplusdiskon*10) / 100;
            }else{
                $ppn = 0;
            }
            $subtotal = $tplusdiskonplusdiskon + $ppn + $row->materai;

            $tdiskon += $row->diskon_item;
            $tppn += $ppn;
            $tmaterai += $row->materai;
            $ttot += $subtotal;

            if($temp == $row->id_po){
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
            }else {
                $temp = $row->id_po;
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->no_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_faktur);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->tgl_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jatuh_tempo);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->company_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
            }
            //Update Untuk Cilandak
            /*$temp = $row->no_resep;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
            $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
            $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
            $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->total);
            $total_diskon = $total_diskon + $row->diskon;
            $total_pendapatan = $total_pendapatan + $row->total;*/
            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Pembelian Obat_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Total : ");
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $tdiskon);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tppn);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $tmaterai);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $ttot);

        // Rename worksheet (worksheet, not filename)  
        $objPHPExcel->getActiveSheet()->setTitle('RSAL Dr. Mintohardjo');

        // Redirect output to a client’s web browser (Excel2007)  
        //clean the output buffer  
        ob_end_clean();

        //this is the header given from PHPExcel examples.   
        //but the output seems somewhat corrupted in some cases.  
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
        //so, we use this header instead.  
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        //$this->SaveViaTempFile($objWriter);
    	}
            // LAPORAN DISTRIBUSI OBAT
      
        public function distribusi_obat(){
        
        $data['title'] = 'Laporan Distribusi Obat';

        //$tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Distribusi Obat.
			</h4>							
			</div>
		</div>";


        $this->load->view('logistik_farmasi/Frmvlaporandistribusiobat',$data);
    }

    public function distribusi_ruangan(){
        $data['title'] = 'Laporan Distribusi Ruangan';

        $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Distribusi Ruangan.
			</h4>							
			</div>
		</div>";

        $data['gudang'] = $this->Frmmlaporan->get_gudang_distribusi_obat()->result();
        $this->load->view('logistik_farmasi/Frmvlaporandistribusiruangan',$data);
    }

	public function rekap_obat_pasien() {
			
		$data['title'] = 'Rekap Obat Pasien';
		$date = $this->input->post('tgl');
		//$noreg = $this->input->post('key');

		
				$data['hasil'] = $this->Frmmdaftar->get_rekap_obat_lap($date)->result();
				//foreach ($hasil as $value) {
				//$no_register = $value->no_register;
				$data['detail'] = $this->Frmmdaftar->get_data_rekap_detail_lap($date)->result();
		

		$this->load->view('logistik_farmasi/frmvdaftarpasienrekap', $data);
	}

		public function get_data_rekap()
		{
			$data['title'] = 'Rekap Obat Pasien';
			$no_register = $this->input->post('no_register');
			$date = $this->input->post('tgl');
			if ($date == '') {
				$date = date('Y-m-d');
			}
			// $line  = array();
			// $line2 = array();
			// $row2  = array();

			//$i = 1;
			$data['hasil'] = $this->frmmdaftar->get_rekap_obat($date)->result();
			//foreach ($hasil as $value) {
			//$no_register = $value->no_register;
			 	$data['detail'] = $this->frmmdaftar->get_data_rekap_detail($no_register)->result();
			// 	$row2['no'] = $i++;
			// 	$row2['tgl_kunjungan'] = date('d-m-Y | H:i', strtotime($value->tgl_kunjungan));
			// 	$row2['no_cm'] = $value->no_cm;
			// 	$row2['no_register'] = $value->no_register;
			// 	$row2['nama'] = $value->nama;
			// 	$row2['kelas'] = $value->kelas;
			// 	$row2['idrg'] = $value->idrg;
			// 	$row2['bed'] = $value->bed;
			// 	$row2['cara_bayar'] = $value->cara_bayar;
			// 	foreach($detail as $r) {
			// 		$row2['tgl'] = $value->xupdate;
			// 		$row2['nm_obat'] = $value->nama_obat;
			// 		$row2['harga'] = "<div align=\"right\">" . number_format($value->biaya_obat, '0', ',', '.') . "</div>";
			// 		$row2['signa'] = $value->signa;
			// 		$row2['qty'] = "<div align=\"right\">" . number_format($value->qty, '0', ',', '.') . "</div>";
			// 		$row2['total'] = "<div align=\"right\">" . number_format($value->vtot, '0', ',', '.') . "</div>";
			// 	}
			// 	//$row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

			// 	$line2[] = $row2;
			// }

			//$line['data'] = $line2;
			$this->load->view('logistik_farmasi/frmvdaftarpasienrekap', $data);
			//echo json_encode($line);
		}

		public function get_data_rekap_noreg()
		{
			$noreg = $this->input->post('key');

			// $line  = array();
			// $line2 = array();
			// $row2  = array();

			$i = 1;
			$data['hasil'] = $this->frmmdaftar->get_rekap_obat_noreg($noreg)->result();
			// foreach ($hasil as $value) {
			// 	$no_register = $value->no_register;

			// 	$row2['no'] = $i++;
			// 	$row2['tgl_kunjungan'] = date('d-m-Y | H:i', strtotime($value->tgl_kunjungan));
			// 	$row2['no_cm'] = $value->no_medrec;
			// 	$row2['no_register'] = $value->no_register;
			// 	$row2['nama'] = $value->nama;
			// 	$row2['kelas'] = $value->kelas;
			// 	$row2['idrg'] = $value->idrg;
			// 	$row2['bed'] = $value->bed;
			// 	$row2['cara_bayar'] = $value->cara_bayar;
			// 	//$row2['aksi'] = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#detailModal\" data-id=\"$value->no_register\"><i class=\"fa fa-search\"></i> Rekap<br/>Obat</button>";

			// 	$line2[] = $row2;
			// }

			//$line['data'] = $line2;

			//echo json_encode($line);
		}

		public function get_data_rekap_detail()
		{
			$no_register = $this->input->post('no_register');

			$line   = array();
			$line2  = array();
			$row2   = array();

			$i = 1;
			$ttot = 0;
			$hasil = $this->frmmdaftar->get_data_rekap_detail($no_register)->result();
			foreach ($hasil as $value) {
				$row2['no'] = $i++;
				$row2['tgl_kunjungan'] = $value->xupdate;
				$row2['nama'] = $value->nama_obat;
				$row2['harga'] = "<div align=\"right\">" . number_format($value->biaya_obat, '0', ',', '.') . "</div>";
				$row2['signa'] = $value->signa;
				$row2['qty'] = "<div align=\"right\">" . number_format($value->qty, '0', ',', '.') . "</div>";
				$row2['total'] = "<div align=\"right\">" . number_format($value->vtot, '0', ',', '.') . "</div>";

				$ttot += $value->vtot;

				$line2[] = $row2;
			}

			$line['data'] = $line2;
			$line['total'] = "<h4>Total Akhir:&nbsp;&nbsp;&nbsp; Rp. " . number_format($ttot, '2', ',', '.') . "</h4>";
			echo json_encode($line);
		}

    public function download_distribusi_obat($param1='', $param2='', $filter='', $nip_serah='', $nip_terima='', $nama_serah='', $nama_terima=''){
        ////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $namars=$this->config->item('namars');
        $objPHPExcel->getProperties()->setCreator($namars)
            ->setLastModifiedBy($namars)
            ->setTitle("Laporan Distribusi Obat Gudang Besar Logistik")
            ->setSubject("Laporan Distribusi Obat Gudang Besar Logistik")
            ->setDescription("Laporan Distribusi Obat Gudang Besar Logistik, generated by HMIS.")
            ->setKeywords($namars)
            ->setCategory("Laporan Distribusi Obat");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $gd = $this->Frmmlaporan->get_nama_gudang($filter)->row();

        $data_keuangan=$this->Frmmlaporan->get_data_distribusi_obat($param1, $param2, $filter)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_distribusi_obat.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        // $objPHPExcel->getActiveSheet()->getStyle('G9')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A9:F9');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUMKITAL dr. Mintohardjo");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "DEPARTEMEN FARMASI");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A4', "BUKTI PENGELUARAN");
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A5', "NO: -/ -/ 2017/ DEP.FAR");
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A7', "Telah dikeluarkan Material Kesehatan untuk ".$gd->nama_gudang);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A7:G7');
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A8', "Berdasarkan Perintah Kadep Far RUMKITAL dr. Mintohardjo sbb :");
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A8:F8');
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $rowCount = 10;
        $i=1;
        $tqty = 0; $tsubtotal = 0;
        foreach($data_keuangan as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nm_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->satuank);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->hargajual);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->subtotal);
            // $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->minggu);
            $tqty += $row->qty;
            $tsubtotal += $row->subtotal;

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Distribusi_Obat_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Total : ");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $tqty);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $tsubtotal);

        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+3), "Jakarta,");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+5), "Yang Menerima");
        /*$objPHPExcel->getActiveSheet()->SetCellValue('B'.($rowCount+6), "Mengetahui");
        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+6), "Nama : ".$nama_terima);
        /*$objPHPExcel->getActiveSheet()->SetCellValue('B'.($rowCount+7), "Pjs. Kabag Far RSMC");
        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount+7))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+7), "NIP : ".$nip_terima);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+8), "");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+11), "Yang Menyerahkan");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+12), "Nama : ".$nama_serah);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+13), "NIP : ".$nip_serah);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+14), "");

       

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS AL dr. Mintohardjo');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();
        ob_start();
        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function penerimaan_obat()
    {
    	$data['jenis_obats'] = $this->Frmmlaporan->get_jenis_obat()->result();
    	if ($this->input->post()) {
	    	$data['jenis_obat'] = $this->input->post('id_jenis')!="" ? $this->input->post('id_jenis') : "semua";
			$data['status'] = $this->input->post('status')!="" ? $this->input->post('status') : "semua";
			$data['verif'] = $this->input->post('verif')!="" ? $this->input->post('verif') : "semua";
	    	$tgl1 = $this->input->post('tanggal_awal');
			$tgl2 =  $this->input->post('tanggal_akhir');
	    	$data['tgl_awal'] = date('Y-m-d', strtotime($tgl1));
	    	$data['tgl_akhir'] = date('Y-m-d', strtotime($tgl2));
			$data['penerimaan_obats'] = $this->Frmmlaporan->get_data_faktur_penerimaan_obat($data['status'],$data['verif'],$data['tgl_awal'],$data['tgl_akhir'])->result();
    	    $data['obats'] = $this->Frmmlaporan->get_data_detail_faktur_penerimaan_obat($data['jenis_obat'])->result();
			$this->load->view('logistik_farmasi/Frmvpenerimaanobat', $data);
    	}else{
			$data['jenis_obat'] = "semua";
			$data['status'] = "semua";
    		$data['tgl_awal'] = date('Y-m-d');
	    	$data['tgl_akhir'] = date('Y-m-d');
			$data['penerimaan_obats'] = array();
    	    $data['obats'] = array();
    		$this->load->view('logistik_farmasi/Frmvpenerimaanobat', $data);
		}
			
    }

    public function download_peneriamaan_obat($supplier="semua",$jenis="semua",$jenis_obat="semua",$tgl_awal,$tgl_akhir)
    {
    	////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $namars=$this->config->item('namars');
        $objPHPExcel->getProperties()->setCreator($namars);

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $penerimaan_obat=$this->Frmmlaporan->get_penerimaan_obat($supplier, $jenis, $jenis_obat, $tgl_awal, $tgl_akhir)->result();
        //$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pembelian_obat.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUMAH SAKIT SRIWIJAYA");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A3', "LAPORAN PENERIMAAN OBAT");
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        // Add some data

        $objPHPExcel->getActiveSheet()->SetCellValue('A6', "Tanggal Terima");
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', "Kelompok");
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', "Pemasok");
        $objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', "UMUM/BPJS");
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', "No Faktur");
        $objPHPExcel->getActiveSheet()->getStyle('E6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', "Jatuh Tempo");
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('G6', "Nama Obat");
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('H6', "Harga Satuan");
        $objPHPExcel->getActiveSheet()->getStyle('H6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('I6', "Qty");
        $objPHPExcel->getActiveSheet()->getStyle('I6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('J6', "PPN");
        $objPHPExcel->getActiveSheet()->getStyle('J6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('K6', "Diskon");
        $objPHPExcel->getActiveSheet()->getStyle('K6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('L6', "Harga Total");
        $objPHPExcel->getActiveSheet()->getStyle('L6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $rowCount = 7;
        $i=1;
        $tqty = 0; $tsubtotal = 0;
        foreach($penerimaan_obat as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tanggal_terima);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->jenis_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->pemasok);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jenis_barang);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_faktur);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->jatuh_tempo);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->description);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->harga_satuan);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->ppn_percent);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->discount_percent);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->harga_total);
            $tqty += $row->qty;
            $tsubtotal += $row->harga_total;

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Penerimaan_Obat_".date('d F Y', strtotime($tgl_awal))."-".date('d F Y', strtotime($$tgl_akhir));

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS SRIWIJAYA');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();
        ob_start();
        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

       public function laporan_distribusi()
    {
    	$data['tgl_awal'] = date('Y-m-d');
    	$data['tgl_akhir'] = date('Y-m-d');
    	if ($this->input->post()) {
	    	$tgl = explode("-", $this->input->post('tgl'));
	    	$data['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
	    	$data['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
	    //	$data['gudang'] = $this->input->post('gd_asal');
	    	

    	}
		
		 $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
		 
	//	 $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();

	//	 foreach ($select_gudang0 as $row) {
	//	 	$gudang = $row->id_gudang;
	//	 }
		
		 $data['distribusi'] =$this->Frmmlaporan->distribusi_by_date($data['tgl_awal'], $data['tgl_akhir'])->result(); 

      //   print_r($data['distribusi']);die();
 
		$data['date_title']="Laporan Distibusi Obat/alkes <b>    ".$data['tgl_awal']."    S.D    ".$data['tgl_akhir']."</b>";

    	$this->load->view('logistik_farmasi/frmvlaporandistribusi', $data);
    }


	public function fast_moving()
    {
		//$data['week_awal'] = date('Y-m-d', strtotime(date('Y-m-d') . ' -5 day'));
		$data['week_awal'] = date('Y-m-d');
		$data['week_akhir'] =  date("Y-m-d");
		$data['data_obat'] =array();
    	$this->load->view('logistik_farmasi/Frmvfastmoving', $data);
    }

	public function fast_moving_search()
    {
    	if ($this->input->post()) {
			$data['week_awal'] = $this->input->post('tgl_awal');
			$data['week_akhir'] =  $this->input->post('tgl_akhir');
			$data['data_obat'] =array();
			$kategori = $this->input->post('kategori');
			switch($kategori){
				case 'semua':
					$data['data_obat'] =$this->Frmmlaporan->get_fast_moving_all($data['week_awal'], $data['week_akhir'])->result();
					break;
				case 'Fast Moving':
					$data['data_obat'] =$this->Frmmlaporan->get_fast_moving_search($data['week_awal'], $data['week_akhir'])->result();
					break;

				case 'Medium Moving':
					$data['data_obat'] =$this->Frmmlaporan->get_medium_moving_search($data['week_awal'], $data['week_akhir'])->result();
					break;

				case 'Slow Moving':
					$data['data_obat'] =$this->Frmmlaporan->get_slow_moving_search($data['week_awal'], $data['week_akhir'])->result();
					break;

				case 'Dead':
				$data['data_obat'] =$this->Frmmlaporan->get_dead_search($data['week_awal'], $data['week_akhir'])->result();
				break;
				}
    	}
    	$this->load->view('logistik_farmasi/Frmvfastmoving', $data);
    }


	
	public function min_max_stock_gdfarmasi()
    {
		// $data['week_awal'] = date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day'));
		// $data['week_akhir'] =  date("Y-m-d");
		$data ['obat'] = $this->Frmmlaporan->get_obat()->result();
		$data['data_obat'] ='';
		$data ['nmobat'] = '';
		$data ['rumus'] = '';
		$data ['id'] = '';
    	$this->load->view('logistik_farmasi/minmaxstock_gdfarmasi', $data);
    }

	public function hitung_stock()
    {

		// var_dump($this->input->post());die();
		
		$tunggu = $this->input->post('tngg');
		$rata = $this->input->post('rata');
		$data['id'] = $this->input->post('id_obat');
		$data ['obat'] = $this->Frmmlaporan->get_obat()->result();
		$data ['nmobat'] = $this->Frmmlaporan->get_nm_obat($data['id'])->row()->nm_obat;
		$data ['rumus'] = 2 * ( $tunggu * $rata );
		$min_stock= (int) $data ['rumus'];

		$cek= $this->Frmmlaporan->get_min_max($data['id'])->row();
		if($cek){
			$stock['tgl_update_terakhir'] = date("Y-m-d");
			$stock ['min_stock'] = $min_stock;
			$result = $this->Frmmlaporan->update_min_stock($data['id'], $stock);
		}else{
			$stock['tgl_update_terakhir'] = date("Y-m-d");
			$stock['id_obat'] = $this->input->post('id_obat');
			$stock['nm_obat'] = $this->Frmmlaporan->get_nm_obat($data['id'])->row()->nm_obat;
			$stock['min_stock'] = $min_stock;
			$result = $this->Frmmlaporan->insert_min_stock($stock);
		}
		
		// var_dump((int)$data ['rumus']);die();
	
    	$this->load->view('logistik_farmasi/minmaxstock_gdfarmasi', $data);
    }

	public function data_min_stock($id)
  {

			header('Content-Type: application/json; charset=utf-8');	
			$tgl=$this->Frmmlaporan->get_data_tgl_stock($id)->row();
			$tgl_awal = date('Y-m-d', strtotime($tgl->tgl_faktur));
			$tgl_akhir = date("Y-m-d");
			$data['rata'] = $this->Frmmlaporan->get_data_rata_stock($id,$tgl_awal,$tgl_akhir)->row()->avg;
			$data['tgl'] = $this->Frmmlaporan->get_waktu_tunggu($tgl_akhir,$tgl_awal)->row()->tunggu;
			echo json_encode($data);
	  
  }


 		public function get_data_max()
  		{

			$id=$this->input->post('id_obat');

			$tgl=$this->Frmmlaporan->get_data_tgl_stock($id)->row();
			$tgl_awal = date('Y-m-d', strtotime($tgl->tgl_faktur));
			$tgl_akhir = date("Y-m-d");
			$data['rata'] = $this->Frmmlaporan->get_data_rata_stock($id,$tgl_awal,$tgl_akhir)->row()->avg;
			$data['tgl'] = $this->Frmmlaporan->get_waktu_tunggu($tgl_akhir,$tgl_awal)->row()->tunggu;
			$data['id_obat'] = $id;
			$data ['nmobat'] = $this->Frmmlaporan->get_nm_obat($id)->row()->nm_obat;
			$rumus = 2 * ( $data['tgl'] * $data['rata'] );
			$data['rumus'] = (int) $rumus;
			echo json_encode($data);
	  
  		}

		  public function hitung_stock_max()
  		{
			// svar_dump($this->input->post());die();
			$rata = $this->input->post('edit_rata');
			$Smin = $this->input->post('edit_smin');
			$periode = $this->input->post('edit_pengadaan');
			
			$rumus = $Smin + ($periode * $rata);
			$data['rumus'] = (int)$rumus;
			$data['id'] = $this->input->post('edit_id_obat');
			$data ['obat'] = $this->Frmmlaporan->get_obat()->result();
			$data ['nmobat'] = $this->Frmmlaporan->get_nm_obat($data['id'])->row()->nm_obat;


			$cek= $this->Frmmlaporan->get_min_max($data['id'])->row();
			if($cek){
				$stock['tgl_update_terakhir'] = date("Y-m-d");
				$stock ['max_stock'] = $data['rumus'];
				$result = $this->Frmmlaporan->update_min_stock($data['id'], $stock);
			}else{
				$stock['tgl_update_terakhir'] = date("Y-m-d");
				$stock['id_obat'] = $data['id'];
				$stock['nm_obat'] = $this->Frmmlaporan->get_nm_obat($data['id'])->row()->nm_obat;
				$stock['max_stock'] = $data['rumus'];
				$result = $this->Frmmlaporan->insert_min_stock($stock);
			}
			
			$this->load->view('logistik_farmasi/minmaxstock_gdfarmasi', $data);
			 
  		}

		  public function view_min_max()
		  {
			$data['title'] = 'Minimum dan Maximum Stock';
			  $data['week_awal'] = date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day'));
			  $data['week_akhir'] =  date("Y-m-d");
			  $data['data_stock'] =$this->Frmmlaporan->get_min_max_all()->result();
			  $this->load->view('logistik_farmasi/view_min_max', $data);
		  }

		  public function rekap_penerimaan_obat()
		  {
			  if ($this->input->post()) {
					$data['subkelompok'] = $this->Mmobat->get_data_subkelompok_obat()->result();
					$kode = $this->input->post('id_sub');
					//  var_dump($this->input->post());die();
					if($kode == 'semua'){
						$data['kode'] = 'semua';
						$data['tgl_awal'] = $this->input->post('tgl_awal');
						$data['tgl_akhir'] = $this->input->post('tgl_akhir');
						$data['rekap_penerimaan_obat'] = $this->Frmmlaporan->get_rekap_obat_laporan( $data['tgl_awal'], $data['tgl_akhir'], $data['kode'])->result();
					  	$this->load->view('logistik_farmasi/Frmvrekappenerimaanobat', $data);
					}else{
						$data['kode'] = $kode;
						$data['tgl_awal'] = $this->input->post('tgl_awal');
						$data['tgl_akhir'] = $this->input->post('tgl_akhir');
						$data['rekap_penerimaan_obat'] = $this->Frmmlaporan->get_rekap_obat_laporan( $data['tgl_awal'], $data['tgl_akhir'], $data['kode'])->result();
					  	$this->load->view('logistik_farmasi/Frmvrekappenerimaanobat', $data);
					}
					
				
					}else{

					$data['subkelompok'] = $this->Mmobat->get_data_subkelompok_obat()->result();
					$data['tgl_awal'] = date('Y-m-d');
					$data['tgl_akhir'] = date('Y-m-d');
					$data['kode'] = '';
					$data['rekap_penerimaan_obat'] = $this->Frmmlaporan->get_rekap_obat_laporan( $data['tgl_awal'], $data['tgl_akhir'], $data['kode'])->result();
					
					$this->load->view('logistik_farmasi/Frmvrekappenerimaanobat', $data);

					} 
		  }

		  function download_rekap_penerimaan_obat($kode='',$tgl1,$tgl2){
			
			$data = $this->Frmmlaporan->get_rekap_obat_laporan( $tgl1,$tgl2,$kode)->result();
			// var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Kategori');
			$sheet->SetCellValue('B1', 'Nama Barang');
			$sheet->SetCellValue('C1', 'Pabrik');
			$sheet->SetCellValue('D1', 'Kuantitas');
			$sheet->SetCellValue('E1', 'Satuan');
			$sheet->SetCellValue('F1', 'Jumlah'); 
			$sheet->SetCellValue('G1', 'PPN'); 
			$sheet->SetCellValue('H1', 'Nilai'); 
		
			$rowCount = 2;
			foreach($data as $row){
			//   $sheet->SetCellValue('A'.$rowCount, isset($row->description)?$row->description:'');
			//   $sheet->SetCellValue('B'.$rowCount, isset($row->pbf)?$row->pbf:'');
			//   $sheet->SetCellValue('C'.$rowCount, isset($row->quantity_purchased)?$row->quantity_purchased:'');
			//   $sheet->SetCellValue('D'.$rowCount, isset($row->satuank)?$row->satuank:'');
			//   $sheet->SetCellValue('E'.$rowCount, isset($row->biaya_total)?$row->biaya_total:'');
			//   $sheet->SetCellValue('F'.$rowCount, '');
			//   $sheet->SetCellValue('G'.$rowCount, isset($row->item_cost_price)?$row->item_cost_price:'');
				$sheet->SetCellValue('A'.$rowCount, $row->bentuk_sediaan);
				$sheet->SetCellValue('B'.$rowCount, $row->description);
				$sheet->SetCellValue('C'.$rowCount, $row->pbf);
				$sheet->SetCellValue('D'.$rowCount,	$row->quantity_purchased);
				$sheet->SetCellValue('E'.$rowCount, $row->satuank);
				$sheet->SetCellValue('F'.$rowCount,	$row->biaya_total);

				$diskon = $row->biaya_kecil * $row->discount_percent;
				$harga_diskon = $diskon / 100;
				$jml_hna = $row->biaya_kecil - $harga_diskon;
				$jml_ppn = 0.11 * $jml_hna;
				

				$sheet->SetCellValue('G'.$rowCount, $jml_ppn);
				$sheet->SetCellValue('H'.$rowCount, $row->item_cost_price);
				$rowCount++;
			}
	
			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Rekapitulasi Penerimaan Barang';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}


		public function lap_mutasi_obat()
		{
			$data['gudang'] = $this->Frmmlaporan->get_gudang()->result();
			$data['kel'] = $this->Frmmlaporan->master_kelompok_obat()->result();
			$data['tgl_awal'] = date('Y-m-d');
			$data['tgl_akhir'] = date('Y-m-d');
			$data['bulan_old'] = date('Y-m', strtotime(date('Y-m') . ' -1 month'));
			$data['idgudang'] = '';
			$data['kelompok'] = '';
			$data['lap_mutasi_obat'] = array();
			if ($this->input->post()) {
				$data['tgl_awal'] = $this->input->post('tgl_awal');
				$data['tgl_akhir'] = $this->input->post('tgl_akhir');
				$data['kelompok'] = $this->input->post('kel');
				$data['bulan_old'] = date('Y-m', strtotime($data['tgl_awal'] . ' -1 month'));
				$data['gudang'] = $this->Frmmlaporan->get_gudang()->result();
				$data['kel'] = $this->Frmmlaporan->master_kelompok_obat()->result();
				$data['idgudang'] = $this->input->post('gudang');
				$data['lap_mutasi_obat'] = $this->Frmmlaporan->get_data_stock_mutasi_gudang($data['tgl_awal'],$data['tgl_akhir'],$data['idgudang'],$data['kelompok'])->result(); 
			}
			$this->load->view('logistik_farmasi/Frmvlapmutasiobat', $data);
		}


		function download_lap_mutasi_obat($date1,$date2,$gd,$kel){
			
			$data = $this->Frmmlaporan->get_data_stock_mutasi_gudang($date1,$date2,$gd,$kel)->result();
			// var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Harga');

			$sheet->mergeCells('H1:J1')
			->getCell('H1')
			->setValue('Masuk');

			$sheet->mergeCells('K1:N1')
			->getCell('K1')
			->setValue('Keluar');

			$sheet->SetCellValue('A2', 'NO');
			$sheet->SetCellValue('B2', 'ED');
			$sheet->SetCellValue('C2', 'Batch');
			$sheet->SetCellValue('D2', 'Barang');
			$sheet->SetCellValue('E2', 'Satuan');
			$sheet->SetCellValue('F2', 'Satuan + PPN'); 
			$sheet->SetCellValue('G2', 'Stock Awal'); 
			$sheet->SetCellValue('H2', 'GD'); 
			$sheet->SetCellValue('I2', 'mutasi'); 
			$sheet->SetCellValue('J2', 'Total'); 
			$sheet->SetCellValue('K2', 'mutasi');
			$sheet->SetCellValue('L2', 'pemakaian'); 
			$sheet->SetCellValue('M2', 'Expire');  
			$sheet->SetCellValue('N2', 'Total'); 
			$sheet->SetCellValue('O2', 'Total Stock Akhir');
			$sheet->SetCellValue('P2', 'Total Sisa'); 
			$sheet->SetCellValue('Q2', 'Sub Kelompok');
		
			$rowCount = 3;
			$index=1;
			foreach($data as $row){
				$sheet->SetCellValue('A'.$rowCount, $index);
				$sheet->SetCellValue('B'.$rowCount, $row->expire_date);
				$sheet->SetCellValue('C'.$rowCount, $row->batch_no);
				$sheet->SetCellValue('D'.$rowCount,	$row->nm_obat);
				$sheet->SetCellValue('E'.$rowCount, $row->satuank);
				$sheet->SetCellValue('F'.$rowCount,	$row->hargabeli);
				if($val->stock_awal != null or $val->stock_awal != ''){
					$stok_awal = $val->stock_awal;
				}else{
					$stok_awal = 0;
				}
				$sheet->SetCellValue('G'.$rowCount, $stok_awal);
				$sheet->SetCellValue('H'.$rowCount, $row->masuk_gd);
				$sheet->SetCellValue('I'.$rowCount, $row->masuk_mutasi);
				$tot_masuk = $val->masuk_gd + $val->masuk_mutasi;
				$sheet->SetCellValue('J'.$rowCount, $tot_masuk);
				$sheet->SetCellValue('K'.$rowCount, $row->keluar_mutasi);
				$sheet->SetCellValue('L'.$rowCount, $row->keluar_pemakaian);
				$sheet->SetCellValue('M'.$rowCount, $row->expire_date);
				$tot_keluar = $val->keluar_mutasi + $val->keluar_pemakaian;
				$sheet->SetCellValue('N'.$rowCount, $tot_keluar);
				$st = $tot_masuk + $val->stock_awal;
                $tot_sisa = $st + $tot_keluar;
				$sheet->SetCellValue('O'.$rowCount, $tot_sisa);
				$total_harga =  $row->hargabeli* $tot_sisa;
				$sheet->SetCellValue('P'.$rowCount, $total_harga );
				$sheet->SetCellValue('Q'.$rowCount, $row->subkel );
				$rowCount++;
				$index++;
			}
	
			ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Mutasi Obat';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		public function lap_mutasi_obat_all()
		{
			  $data['tgl_awal'] = date('Y-m-d');
			  $data['tgl_akhir'] = date('Y-m-d');
			  $data['bulan_old'] = date('Y-m', strtotime(date('Y-m') . ' -1 month'));
			  $data['kel'] = $this->Frmmlaporan->master_kelompok_obat()->result();
			  $data['kelompok'] = '';
			  $data['lap_mutasi_obat_all'] = array();
			if ($this->input->post()) {
				  $data['kel'] = $this->Frmmlaporan->master_kelompok_obat()->result();
				  $data['tgl_awal'] = $this->input->post('tgl_awal');
				  $data['tgl_akhir'] = $this->input->post('tgl_akhir');
				  $data['kelompok'] = $this->input->post('kel');
				  $data['bulan_old'] = date('Y-m', strtotime($data['tgl_awal'] . ' -1 month'));

				 $data['lap_mutasi_obat_all'] = $this->Frmmlaporan->get_lap_mutasi_by_gudang_all( $data['bulan_old'],$data['tgl_awal'],$data['tgl_akhir'],$data['kelompok'])->result();
				
			}
			$this->load->view('logistik_farmasi/Frmvlapmutasiobatall', $data);
		}

		function download_lap_mutasi_obat_all($blnold='',$date1,$date2,$kel){
			
			$data = $this->Frmmlaporan->get_lap_mutasi_by_gudang_all($blnold,$date1,$date2,$kel)->result();
			// var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Expire Date');
			$sheet->SetCellValue('B1', 'Batch');
			$sheet->SetCellValue('C1', 'Barang');
			$sheet->SetCellValue('D1', 'Satuan');
			$sheet->SetCellValue('E1', 'Satuan + PPN'); 
			$sheet->SetCellValue('F1', 'SA GD'); 
			$sheet->SetCellValue('G1', 'SA Neuro'); 
			$sheet->SetCellValue('H1', 'SA B'); 
			$sheet->SetCellValue('I1', 'SA C'); 
			$sheet->SetCellValue('J1', 'SA RJ'); 
			$sheet->SetCellValue('K1', 'SA Produksi'); 
			$sheet->SetCellValue('L1', 'Total SA'); 
			$sheet->SetCellValue('M1', 'Masuk GD'); 
			$sheet->SetCellValue('N1', 'Masuk Neuro'); 
			$sheet->SetCellValue('O1', 'Masuk B'); 
			$sheet->SetCellValue('P1', 'Masuk C'); 
			$sheet->SetCellValue('Q1', 'Masuk RJ'); 
			$sheet->SetCellValue('R1', 'Masuk Produksi'); 
			$sheet->SetCellValue('S1', 'Total Masuk'); 
			$sheet->SetCellValue('T1', 'keluar GD'); 
			$sheet->SetCellValue('U1', 'keluar Neuro'); 
			$sheet->SetCellValue('V1', 'keluar B'); 
			$sheet->SetCellValue('W1', 'keluar C'); 
			$sheet->SetCellValue('X1', 'keluar RJ'); 
			$sheet->SetCellValue('Y1', 'keluar Produksi'); 
			$sheet->SetCellValue('Z1', 'Total keluar');
			$sheet->SetCellValue('AA1', 'sisa GD');
			$sheet->SetCellValue('AB1', 'sisa Neuro');
			$sheet->SetCellValue('AC1', 'sisa B');
			$sheet->SetCellValue('AD1', 'sisa C');
			$sheet->SetCellValue('AE1', 'sisa RJ');
			$sheet->SetCellValue('AF1', 'sisa Produksi');
			$sheet->SetCellValue('AG1', 'Total sisa');
			$sheet->SetCellValue('AH1', 'Subkelompok');

		
			$rowCount = 2;
			foreach($data as $row){
				$sheet->SetCellValue('A'.$rowCount, $row->expire_date);
				$sheet->SetCellValue('B'.$rowCount, $row->batch_no);
				$sheet->SetCellValue('C'.$rowCount,	$row->nm_obat);
				$sheet->SetCellValue('D'.$rowCount, $row->satuan);
				$sheet->SetCellValue('E'.$rowCount,	$row->hargabeli);
				$sheet->SetCellValue('F'.$rowCount, $row->sa_farm);
				$sheet->SetCellValue('G'.$rowCount, $row->sa_neuro);
				$sheet->SetCellValue('H'.$rowCount, $row->sa_b);
				$sheet->SetCellValue('I'.$rowCount, $row->sa_c);
				$sheet->SetCellValue('J'.$rowCount, $row->sa_rj);
				$sheet->SetCellValue('K'.$rowCount, $row->sa_pro);
				$sheet->SetCellValue('L'.$rowCount, $row->sa_tot);
				$sheet->SetCellValue('M'.$rowCount, $row->mafarm);
				$sheet->SetCellValue('N'.$rowCount, $row->maneuro);
				$sheet->SetCellValue('O'.$rowCount, $row->ma_b);
				$sheet->SetCellValue('P'.$rowCount, $row->ma_c);
				$sheet->SetCellValue('Q'.$rowCount, $row->ma_rj);
				$sheet->SetCellValue('R'.$rowCount, $row->ma_pro);
				$sheet->SetCellValue('S'.$rowCount,'');
				$sheet->SetCellValue('T'.$rowCount, $row->ke_farm);
				$sheet->SetCellValue('U'.$rowCount, $row->ke_neuro);
				$sheet->SetCellValue('V'.$rowCount, $row->ke_b);
				$sheet->SetCellValue('W'.$rowCount, $row->ke_c);
				$sheet->SetCellValue('X'.$rowCount, $row->ke_rj);
				$sheet->SetCellValue('Y'.$rowCount, $row->ke_pro);
				$sheet->SetCellValue('Z'.$rowCount, '');
				$sheet->SetCellValue('AA'.$rowCount, $row->sifarm);
				$sheet->SetCellValue('AB'.$rowCount, $row->si_neuro);
				$sheet->SetCellValue('AC'.$rowCount, $row->si_b);
				$sheet->SetCellValue('AD'.$rowCount, $row->si_c);
				$sheet->SetCellValue('AE'.$rowCount, $row->si_rj);
				$sheet->SetCellValue('AF'.$rowCount, $row->si_pro);
				$sheet->SetCellValue('AG'.$rowCount, '');
				$sheet->SetCellValue('AH'.$rowCount, $row->subkel);
				$rowCount++;
			}
	
			ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Gabungan Semua Depo';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		public function narkotika_psikotropika()
		  {
				
			$data['tgl_awal'] = date('Y-m-d');
			$data['tgl_akhir'] = date('Y-m-d');
			  $data['jenis'] = '';
			  $data['lap_obat_all'] = array();
			  if ($this->input->post()) {
				// var_dump($this->input->post());die();
					$data['tgl_awal'] = $this->input->post('tgl_awal');
					$data['tgl_akhir'] = $this->input->post('tgl_akhir');
					$data['jenis'] = $this->input->post('jenis');
				    $data['lap_obat_all'] = $this->Frmmlaporan->get_lap_narkotik_psikotropik($data['tgl_awal'],$data['tgl_akhir'],$data['jenis'])->result();
				  
			  }
	  
			  $this->load->view('logistik_farmasi/Frmvnarkotik_psikotropik', $data);
		  }

		  
		  function download_lap_narkotik_psikotropik($date1,$date2,$kel=''){
			
			$data = $this->Frmmlaporan->get_lap_narkotik_psikotropik($date1,$date2,$kel)->result();
			// var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Transaksi');
			$sheet->SetCellValue('B1', 'Produk');
			$sheet->SetCellValue('C1', 'Stock Awal');
			$sheet->SetCellValue('D1', 'Dari PBF');
			$sheet->SetCellValue('E1', 'Dari Sarana'); 
			$sheet->SetCellValue('F1', 'Untuk Resep'); 
			$sheet->SetCellValue('G1', 'Untuk Sarana'); 
			$sheet->SetCellValue('H1', 'Pemusnahan'); 
			$sheet->SetCellValue('I1', 'Stock Akhir'); 
			$sheet->SetCellValue('J1', 'Status'); 


		
			$rowCount = 2;
			foreach($data as $row){
				$sheet->SetCellValue('A'.$rowCount, $row->tgl_amprah);
				$sheet->SetCellValue('B'.$rowCount, $row->nm_obat);
				$sheet->SetCellValue('C'.$rowCount,	$row->stock_awal);
				$sheet->SetCellValue('D'.$rowCount, $row->daripbf);
				$sheet->SetCellValue('E'.$rowCount,	'');
				$sheet->SetCellValue('F'.$rowCount, $row->untukresep);
				$sheet->SetCellValue('G'.$rowCount, '');
				$sheet->SetCellValue('H'.$rowCount, '');
				$sheet->SetCellValue('I'.$rowCount, $row->stock_akhir);
				$sheet->SetCellValue('J'.$rowCount, '');
			
				$rowCount++;
			}
	
			ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Narkotik Psikotropika';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		function bot_so_obat_2()
		{
			
			// $spreadsheet = new Spreadsheet();
			// $inputFileType = 'Xlsx';
			// echo FCPATH;
			// die();
			// $inputFileName = FCPATH.'application\modules\logistik_farmasi\controllers\so.xlsx';
			// var_dump($inputFileName);die();
			// $sheetname = 'GUDANG FARMASI';
			/**  Create an Instance of our Read Filter  **/
			// $filterSubset = new MyReadFilter();
			/**  Identify the type of $inputFileName  **/
			// $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

			/**  Create a new Reader of the type defined in $inputFileType  **/
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
			/**  Tell the Reader that we want to use the Read Filter  **/
			$reader->setReadFilter($filterSubset);
			/**  Load only the rows and columns that match our filter to Spreadsheet  **/
			$spreadsheet = $reader->load($inputFileName);
			$filterSubset = new MyReadFilter();

			// $helper->log('Loading file ' . /** @scrutinizer ignore-type */ pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

			// $helper->log('Loading Sheet "' . $sheetname . '" only');
			$reader->setLoadSheetsOnly($sheetname);
			// $helper->log('Loading Sheet using filter');
			$reader->setReadFilter($filterSubset);
			$spreadsheet = $reader->load($inputFileName);

			$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			// echo '<pre>';
			// var_dump($sheetData);
			// echo '</pre>';
			// die();
			$arr = [];
			foreach($sheetData as $index=>$data)
			{
				if($index != 0)
				{
					// echo $data['A'];
					$x = $this->bot_ambil_id($data['A']);
					array_push($arr,$x->id_obat??'-');
					// if(isset($x->id_obat))
					// {
					// }
				}
			}
			echo join("<br>",$arr);
			// foreach($)
			// var_dump($arr);
		}

		function bot_ambil_id($nama)
		{
			return $this->Frmmlaporan->ambil_id_obat($nama)->row();
		}

		public function download_penerimaan_obat_by_faktur($status,$jenis_obat,$verif,$tgl_awal,$tgl_akhir){
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
			$status_brg = str_replace("%20"," ",$status);
			$penerimaan_obats = $this->Frmmlaporan->get_data_faktur_penerimaan_obat($status_brg,$verif,$tgl_awal,$tgl_akhir)->result();
    	    $obats= $this->Frmmlaporan->get_data_detail_faktur_penerimaan_obat($jenis_obat)->result();

			

			$sheet->SetCellValue('A1', 'ID Penerima');
			$sheet->SetCellValue('B1', 'Tanggal Masuk');
			$sheet->SetCellValue('C1', 'Tanggal Faktur');
			$sheet->SetCellValue('D1', 'Tanggal Jatuh Tempo');
			$sheet->SetCellValue('E1', 'PBF/Distributor'); 
			$sheet->SetCellValue('F1', 'No PO'); 
			$sheet->SetCellValue('G1', 'No DO'); 
			$sheet->SetCellValue('H1', 'No Faktur'); 
			$sheet->SetCellValue('I1', 'Nilai Faktur'); 
			$sheet->SetCellValue('J1', 'Pembulatan Nilai Faktur'); 
			$sheet->SetCellValue('K1', 'Produsen/Prinsipal'); 
			$sheet->SetCellValue('L1', 'Kategori'); 
			$sheet->SetCellValue('M1', 'Nama Barang');
			$sheet->SetCellValue('N1', 'Batch');
			$sheet->SetCellValue('O1', 'ED');
			$sheet->SetCellValue('P1', 'Satuan Besar');
			$sheet->SetCellValue('Q1', 'Satuan Kecil');
			$sheet->SetCellValue('R1', 'Faktor Satuan');
			$sheet->SetCellValue('S1', 'Qty Besar');
			$sheet->SetCellValue('T1', 'Qty Kecil');
			$sheet->SetCellValue('U1', 'Harga Bruto');
			$sheet->SetCellValue('V1', 'Disc');
			$sheet->SetCellValue('W1', 'HNA');
			$sheet->SetCellValue('X1', 'HNA+PPN(Besar)');
			$sheet->SetCellValue('Y1', 'HNA+PPN(Kecil)');
			$sheet->SetCellValue('Z1', 'Jumlah HNA');
			$sheet->SetCellValue('AA1', 'Jumlah PPN 11%');
			$sheet->SetCellValue('AB1', 'Jumlah');


			$rowCount = 2;
			foreach($penerimaan_obats as $row){
				$sheet->SetCellValue('A'.$rowCount, $row->receiving_id);
				$sheet->SetCellValue('B'.$rowCount, $row->tgl_masuk);
				if($row->tgl_faktur == null){
					$tgl_fak_do = $row->tgl_do;
				}else{
					$tgl_fak_do =  $row->tgl_faktur;
				}
				$sheet->SetCellValue('C'.$rowCount, $tgl_fak_do );
				$sheet->SetCellValue('D'.$rowCount,	$row->jatuh_tempo);
				$sheet->SetCellValue('E'.$rowCount, $row->distributor);
				$sheet->SetCellValue('F'.$rowCount, '');
				$sheet->SetCellValue('G'.$rowCount, $row->no_do);
				$sheet->SetCellValue('H'.$rowCount, $row->no_faktur);
				$sheet->SetCellValue('I'.$rowCount, $row->total_price_awal);
				$sheet->SetCellValue('J'.$rowCount, $row->total_price);
				foreach($obats as $val){
					if($val->id == $row->receiving_id ){
						$sheet->SetCellValue('K'.$rowCount, $val->produsen);
						$sheet->SetCellValue('L'.$rowCount, $val->bentuk_sediaan);
						$sheet->SetCellValue('M'.$rowCount, $val->nama_obat);
						$sheet->SetCellValue('N'.$rowCount, $val->batch_no);
						$sheet->SetCellValue('O'.$rowCount, $val->expire_date);
						$sheet->SetCellValue('P'.$rowCount, $val->satuank);
						$sheet->SetCellValue('Q'.$rowCount, $val->satuanb);
						$sheet->SetCellValue('R'.$rowCount, $val->faktor_satuan);
						$sheet->SetCellValue('S'.$rowCount, $val->qtyb);
						$sheet->SetCellValue('T'.$rowCount, $val->qtyk);
						$sheet->SetCellValue('U'.$rowCount, $val->harga_bruto);
						$sheet->SetCellValue('V'.$rowCount, $val->discount_percent);
							$hna = $val->harga_bruto - $val->harga_diskon;
						$sheet->SetCellValue('W'.$rowCount, $hna);
						$sheet->SetCellValue('X'.$rowCount, $val->hnappnbesar);
						$sheet->SetCellValue('Y'.$rowCount, $val->hnappnkecil);
							$jml_hna = $val->harga_bruto - $val->harga_diskon;
						$sheet->SetCellValue('Z'.$rowCount, $jml_hna);
							$jml_ppn = 0.11 * $jml_hna;
						$sheet->SetCellValue('AA'.$rowCount, $jml_ppn);
						$sheet->SetCellValue('AB'.$rowCount, $jml_hna + $jml_ppn);
						$rowCount++;
					}
					
				}
			
				$rowCount++;
			}
	
			ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Penerimaan Barang';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
			

		}

		public function cut_off_stock(){
		
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['title'] = 'Cut Off Stok Gudang';
			$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Silahkan Masukan Tanggal Sebelum Cut Off Stock.
				</h4>							
				</div>
			</div>";
	
			$this->load->view('logistik_farmasi/cut_off_stock',$data);
		}

		public function insert_cut_off_stock(){
			$tgl = date_create($this->input->post('tgl'));
			$year_now = date('Y');
			if(date_format($tgl,"Y") == $year_now){
				$insert_stock = $this->Frmmlaporan->insert_cut_off_inven($this->input->post('tgl'));
			}else{
				$create_table == '';
				$insert_stock ='';
			}
			// var_dump($year_now);die();
			// $data['message_nodata']="<div class=\"content-header\">
			// 	<div class=\"alert alert-danger alert-dismissable\">
			// 		<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			// 	<h4><i class=\"icon fa fa-close\"></i>
			// 		Silahkan Masukan Tanggal Sebelum Cut Off Stock.
			// 	</h4>							
			// 	</div>
			// </div>";
			redirect('logistik_farmasi/Frmclaporan/cut_off_stock',$data);
				
		}


		public function laporan_stock(){
		
			// $tgl_indo=new Tglindo();
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['title'] = 'Laporan Stok Gudang';
			$data['gudang']=$this->Frmmlaporan->get_gudang()->result();
			$id_gudang = $this->input->post('filter');
			$periode = $this->input->post('tampil_per');
			$gd = $this->Frmmlaporan->get_nama_gudang($id_gudang)->row();
			$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Silahkan Pilih Gudang dan Periode Untuk Melihat Laporan Stok Obat.
				</h4>							
				</div>
			</div>";
	
			$this->load->view('logistik_farmasi/Frmvlapstokgudangv2',$data);
		}

		public function download_laporan_stock_(){
			$id_gudang = $this->input->post('filter');
			$periode = $this->input->post('tampil_per');
			$gd = $this->Frmmlaporan->get_nama_gudang($id_gudang)->row();
			$data_obat = $this->Frmmlaporan->get_data_obat_all()->result();
			$data_harga_obat = $this->Frmmlaporan->get_data_harga_obat($id_gudang)->result();
		
			if($periode == 'TGL'){
				$date = $this->input->post('tgl');
				$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($periode,$date,$id_gudang)->result();
			
				
			}else if($periode == 'BLN'){
				$date = $this->input->post('bulan');
				$tgl_bln_lalu = date('Y-m', strtotime('-1 month', strtotime($date)));
				$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($periode,$date,$id_gudang)->result();
				
			}else if($periode == 'THN'){
				$date = $this->input->post('tahun');
				$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($periode,$date,$id_gudang)->result();
				
			}
		
			$this->load->library('Excel');
			$objPHPExcel = new PHPExcel();
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel=$objReader->load(APPPATH.'third_party/Laporan_Stok_GD_New.xlsx');
			$objPHPExcel->setActiveSheetIndex(0);
			// Add some data
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('G5:H5');
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('I6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('J6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('I5:J5');
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('K5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('K6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('L6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('M6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('M6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('K5:M5');
	
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('N5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('N6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('N6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('O6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('N5:O5');
	
	
	
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
			$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->setAutoFilter('B5:D5');
	
	
			$rowCount = 7;
		
			foreach($data_obat as $row){
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->kode_rek);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->jenis_obat);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama_kategori);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nm_obat);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->satuank);
	
				foreach($data_stok1 as $value){
					if($value->id_obat == $row->id_obat){
	
						
						$nilai_jumlah_masuk_sisa_old = $value->sisa * $data_harga_obat[0]->harga_obat;
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->sisa);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $nilai_jumlah_masuk_sisa_old);
	
						$jumlah_masuk_total = $value->masuk_pembelian + $value->masuk;
						$nilai_jumlah_masuk_total = $jumlah_masuk_total * $data_harga_obat[0]->harga_obat;
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $jumlah_masuk_total);
						$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $nilai_jumlah_masuk_total);
	
						$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value->keluar);
						$nilai_barang_keluar = $data_harga_obat[0]->harga_obat * $value->keluar;
						$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $nilai_barang_keluar);
	
						$sisa_barang = $jumlah_masuk_total - $value->keluar;
						$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $sisa_barang);
						$nilai_sisa_barang = $sisa_barang * $data_harga_obat[0]->harga_obat ;
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $nilai_sisa_barang);
					}
	
				}
				
				foreach($data_harga_obat as $hrg){
					if($hrg->id_obat == $row->id_obat){
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $hrg->harga_obat);
						$rowCount++;
					}
					
				}
	
				
	
				
				
				$rowCount++;
			}
	
			$filename = "Laporan_Stok";
	
			// Rename worksheet (worksheet, not filename)
			$objPHPExcel->getActiveSheet()->setTitle('RSUD Sijunjung');
			ob_end_clean();
			ob_start();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
			header('Cache-Control: max-age=0');
	
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		
		}


		public function download_laporan_stock(){
			// var_dump($this->input->post());die();
			$id_gudang = $this->input->post('filter');
			// $periode = $this->input->post('tampil_per');
			$gd = $this->Frmmlaporan->get_nama_gudang($id_gudang)->row();
			$data_obat = $this->Frmmlaporan->get_data_obat_all()->result();
			$data_harga_obat = $this->Frmmlaporan->get_data_harga_obat($id_gudang)->result();

			$date = $this->input->post('bulan');
			// $tgl_bln_lalu = date('Y-m', strtotime('-1 month', strtotime($date)));
			$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($date,$id_gudang)->result();
			$kategori = $this->Frmmlaporan->get_kategori()->result();
		
			// if($periode == 'TGL'){
			// 	$date = $this->input->post('tgl');
			// 	$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($periode,$date,$id_gudang)->result();
			
			// }else if($periode == 'BLN'){
			// 	$date = $this->input->post('bulan');
			// 	$tgl_bln_lalu = date('Y-m', strtotime('-1 month', strtotime($date)));
			// 	$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($date,$id_gudang)->result();
				
			// }else if($periode == 'THN'){
			// 	$date = $this->input->post('tahun');
			// 	$data_stok1 = $this->Frmmlaporan->get_stok_laporan_stok_new($periode,$date,$id_gudang)->result();
				
			// }

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 

			$styleArray = [
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'font' => [
					'bold' => true,
				],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => [
						'argb' => 'FFFF00', // Warna kuning
					],
				],
				// 'borders' => [
				// 	'allBorders' => [
				// 		'borderStyle' => Border::BORDER_THIN,
				// 		'color' => ['argb' => '000000'], // Warna border hitam
				// 	],
				// ],
			];

			$styleArray1 = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => Border::BORDER_THIN,
						'color' => ['argb' => '000000'], // Warna border hitam
					],
				],
			];


			$sheet->mergeCells('A5:A6')
			->getCell('A5')
			->setValue('KATEGORI');
			$sheet->getStyle('A5:A6')->applyFromArray($styleArray);

			$sheet->mergeCells('B5:B6')
			->getCell('B5')
			->setValue('CAL');
			$sheet->getStyle('B5:B6')->applyFromArray($styleArray);


			$sheet->mergeCells('C5:C6')
			->getCell('C5')
			->setValue('SATUAN');
			$sheet->getStyle('C5:C6')->applyFromArray($styleArray);

			$sheet->mergeCells('D5:D6')
			->getCell('D5')
			->setValue('HARGA SATUAN');
			$sheet->getStyle('D5:D6')->applyFromArray($styleArray);

			$sheet->mergeCells('E5:F5')
			->getCell('E5')
			->setValue('SISA BULAN LALU');
			$sheet->getStyle('E5:F5')->applyFromArray($styleArray);

			$sheet->mergeCells('G5:H5')
			->getCell('G5')
			->setValue('MASUK');
			$sheet->getStyle('G5:H5')->applyFromArray($styleArray);

			$sheet->mergeCells('I5:J5')
			->getCell('I5')
			->setValue('KELUAR');
			$sheet->getStyle('I5:J5')->applyFromArray($styleArray);

			$sheet->mergeCells('K5:L5')
			->getCell('K5')
			->setValue('EXPIRE');
			$sheet->getStyle('K5:L5')->applyFromArray($styleArray);

			$sheet->mergeCells('M5:N5')
			->getCell('M5')
			->setValue('SISA');
			$sheet->getStyle('M5:N5')->applyFromArray($styleArray);

			$sheet->mergeCells('O5:O6')
			->getCell('O5')
			->setValue('EXPIRE DATE ');
			$sheet->getStyle('O5:O6')->applyFromArray($styleArray);


			$sheet->SetCellValue('E6', 'JUMLAH BARANG');
			$sheet->getStyle('E6')->applyFromArray($styleArray);

			$sheet->SetCellValue('F6', 'NILAI BARANG');
			$sheet->getStyle('F6')->applyFromArray($styleArray);

			$sheet->SetCellValue('G6', 'JUMLAH BARANG');
			$sheet->getStyle('G6')->applyFromArray($styleArray);

			$sheet->SetCellValue('H6', 'NILAI BARANG');
			$sheet->getStyle('H6')->applyFromArray($styleArray);

			$sheet->SetCellValue('I6', 'JUMLAH BARANG');
			$sheet->getStyle('I6')->applyFromArray($styleArray);

			$sheet->SetCellValue('J6', 'NILAI BARANG');
			$sheet->getStyle('J6')->applyFromArray($styleArray);

			$sheet->SetCellValue('K6', 'JUMLAH BARANG');
			$sheet->getStyle('K6')->applyFromArray($styleArray);

			$sheet->SetCellValue('L6', 'NILAI BARANG');
			$sheet->getStyle('L6')->applyFromArray($styleArray);

			$sheet->SetCellValue('M6', 'JUMLAH BARANG');
			$sheet->getStyle('M6')->applyFromArray($styleArray);

			$sheet->SetCellValue('N6', 'NILAI BARANG');
			$sheet->getStyle('N6')->applyFromArray($styleArray);

			$sheet->SetCellValue('B7', 'OBAT');
			$sheet->SetCellValue('B8', 'Obat Cair');

			$rowCount = 7;
			foreach($kategori as $kat){
				$sheet->SetCellValue('A'.$rowCount, $kat->nm_kategori_1);
				foreach($data_stok1 as $obat){
					
							if($kat->id == $obat->kategori_obat){
								$sheet->SetCellValue('B'.$rowCount, $obat->nm_obat);
								$sheet->SetCellValue('C'.$rowCount, $obat->satuank);
								if($obat->harga_jual == null){
									$jual = 0;
								}else{
									$jual = $obat->harga_jual;
								}
								$sheet->SetCellValue('D'.$rowCount, $jual);
								$sheet->SetCellValue('E'.$rowCount, $obat->saldo_awal);
								$sheet->SetCellValue('F'.$rowCount, $jual * $obat->saldo_awal);
								$sheet->SetCellValue('G'.$rowCount, $obat->masuk);
								$sheet->SetCellValue('H'.$rowCount, $jual * $obat->masuk);
								$sheet->SetCellValue('I'.$rowCount, $obat->keluar);
								$sheet->SetCellValue('J'.$rowCount, $jual * $obat->keluar);
								$sheet->SetCellValue('K'.$rowCount, $obat->expire);
								$sheet->SetCellValue('L'.$rowCount, $jual * $obat->expire);
								$stock_masuk = $obat->saldo_awal + $obat->masuk;
								$stock_keluar = $obat->keluar + $obat->expire;
								$sisa = $stock_masuk - $stock_keluar;
								$sheet->SetCellValue('M'.$rowCount, $sisa);
								$sheet->SetCellValue('N'.$rowCount, $jual * $sisa);
								$sheet->SetCellValue('O'.$rowCount, $obat->expire_date);
								$rowCount++;
							}
							
				}
				$rowCount++;
			}
			// foreach($data_stok1 as $obat){

			// 	$sheet->SetCellValue('A'.$rowCount, $obat->kode_rek);
			// 	$sheet->SetCellValue('B'.$rowCount, $obat->nm_obat);
			// 	$sheet->SetCellValue('C'.$rowCount, $obat->jenis_obat);
			// 	$sheet->SetCellValue('D'.$rowCount, $obat->nama_kategori);
			// 	$sheet->SetCellValue('E'.$rowCount, $obat->satuank);

				
			// 	if($obat->harga_jual == null){
			// 		$jual = 0;
			// 	}else{
			// 		$jual = $obat->harga_jual;
			// 	}
			// 	$sheet->SetCellValue('F'.$rowCount, $jual);
			// 	$sheet->SetCellValue('G'.$rowCount, $obat->saldo_awal);
			// 	$sheet->SetCellValue('H'.$rowCount, $jual * $obat->saldo_awal);
			// 	$sheet->SetCellValue('I'.$rowCount, $obat->masuk);
			// 	$sheet->SetCellValue('J'.$rowCount, $jual * $obat->masuk);
			// 	$sheet->SetCellValue('K'.$rowCount, $obat->keluar);
			// 	$sheet->SetCellValue('L'.$rowCount, $jual * $obat->keluar);
			// 	$sheet->SetCellValue('M'.$rowCount, $obat->expire);
			// 	$sheet->SetCellValue('N'.$rowCount, $jual * $obat->expire);
			// 	$stock_masuk = $obat->saldo_awal + $obat->masuk;
			// 	$stock_keluar = $obat->keluar + $obat->expire;
			// 	$sisa = $stock_masuk - $stock_keluar;
			// 	$sheet->SetCellValue('O'.$rowCount, $sisa);
			// 	$sheet->SetCellValue('P'.$rowCount, $jual * $sisa);
			// 	$sheet->SetCellValue('Q'.$rowCount, $obat->expire_date);
			// 	$rowCount++;
			// }

			// $sheet->getStyle('A')->applyFromArray($styleArray1);
			// $sheet->getStyle('B')->applyFromArray($styleArray1);
			// $sheet->getStyle('C')->applyFromArray($styleArray1);





			ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Stock Gudang';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		
		
		
		}

		public function laporan_distribusi_obat()
		{
			// var_dump($this->input->post());die();
			$data['title'] = 'Laporan Distribusi';
			$dateRange = $this->input->post('tanggal_laporan');	
			$data['ruang'] = $this->input->post('ruang');
			if($dateRange){
				$dates = explode(' - ', $dateRange);
				$startDate = $dates[0];
				$endDate = $dates[1];
				$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
				$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
				$data['tgl'] = $startDateObj->format('Y-m-d');
				$data['tgl1'] = $endDateObj->format('Y-m-d');
				$data['data_stock'] =$this->Frmmlaporan->get_distribusi($data['tgl'],$data['tgl1'],$data['ruang'])->result();
				$data['data_gudang'] =$this->Frmmlaporan->get_master_gudang()->result();
			}else{
				$data['tgl'] = date('Y-m-d');
				$data['tgl1'] =  date("Y-m-d");
				$data['data_stock'] =array();
				$data['data_gudang'] =$this->Frmmlaporan->get_master_gudang()->result();
			}
			
			$this->load->view('logistik_farmasi/laporan_distribusi', $data);
		}
		  
		public function excel_lap_distribusi($tgl,$tgl1,$id_ruang)
		{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$data = $this->Frmmlaporan->get_distribusi($tgl,$tgl1,$id_ruang)->result();
			
			$sheet->setCellValue('A1', 'LAPORAN DISTRIBUSI'.' '.$tgl.' '.'sampai'.' '.$tgl1);

			
			$sheet->setCellValue('A3', 'TANGGAL');
			$sheet->setCellValue('B3', 'NAMA OBAT');
			$sheet->setCellValue('C3', 'QTY');
			$sheet->setCellValue('D3', 'GUDANG');

		

			$x = 4;
			foreach($data as $val){
				
				$sheet->setCellValue('A'.$x, date('d-m-Y',strtotime($val->tgl_amprah)));
				$sheet->setCellValue('B'.$x, $val->nm_obat);
				$sheet->setCellValue('C'.$x, $val->qty_acc);
				$sheet->setCellValue('D'.$x, $val->gudang);
				$x++;
			}
		
		

			$writer = new Xlsx($spreadsheet);
			
			$filename = 'Laporan Distribusi Obat';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}
		  
}
