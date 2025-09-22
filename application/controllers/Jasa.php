<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Jasa extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->helper('pdf_helper');
		$this->load->model('iri/rimpasien');
		$this->load->model('irj/rjmpencarian');
	}

	public function index(){
		 $data['title'] = 'Pelaksana Per-pasien';

		 $this->load->view('viewpelaksana', $data);
	}

	private function string_table_jasa($list1, $list2){
		$konten = "";
		$konten="<table class=\"table table-hover table-striped table-bordered\">
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($list2[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($list2[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($list2[0]['carabayar'])."</td>
							</tr>
						</table>";
				$subtotal = 0;
				foreach ($list1 as $s) {
					$konten=$konten."<h4>Ruangan : ".$s['lokasi']."</h4>
					<table class=\"table table-hover table-striped table-bordered\" border=\"1\" style=\"padding:2px;\">
					<thead>
					<tr>
						<th width=\"5%\">No</th>
						<th >Pelaksana</th>
						<th >Nama Ruangan</th>
						<th >Banyak Tindakan</th>
						<th >Total</th>
					</tr>
					</thead>
					<tbody>";
					$subtotal_intern = 0;
					$i=1;
					foreach ($list2 as $r) {
							//echo strpos($r['nmruang'],'anyelir');
							if($r['lokasi']==$s['lokasi']){
								$subtotal = $subtotal + $r['vtot'];
								$subtotal_intern = $subtotal_intern + $r['vtot'];
								$tumuminap = number_format($r['tumuminap'],0);
								$konten=$konten."<tr>
									<td width=\"5%\">".$i++."</td>
									<td>".$r['nm_dokter']."</td>
									<td>".$r['nmruang']."</td>
									<td>".$r['qtyyanri']."</td>
									<td align=\"right\">".number_format($r['vtot'],0)."</td>					
								</tr>";
							}
					}
					
						$konten = $konten.'
									<tr>
										<td colspan="4" align="right">Total '.$s['lokasi'].'</td>
										<td align="right">'.number_format($subtotal_intern,0).'</td>
									</tr>
								</tbody>
							</table>
						';
					
				}
				$konten = $konten.'<h4 align="center">Total : '.number_format($subtotal,0).' </h4>';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal
					);
		return $result;
	}

	public function cari_recordpelaksana(){
		if($this->input->post('noregister')!='' && $this->input->post('jenisrawat')!=''){
			$no_register=$this->input->post('noregister');
			$jenisrawat=$this->input->post('jenisrawat');
			$konten='';
			if($jenisrawat=='irj'){
				$result=$this->rjmpencarian->get_pelaksana_pasien_irj($no_register);
				$konten="<table class=\"table table-responsive\">															
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($result[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($result[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($result[0]['cara_bayar'])."</td>
							</tr>
						</table>";
			}else{
				$result=$this->rimpasien->get_pelaksana_pasien_iri($no_register);
				$list_mutasi_pasien = $this->rimpasien->get_list_lokasi_mutasi_pasien($no_register);
				$result0=$this->string_table_jasa($list_mutasi_pasien,$result);
				$konten = $konten.$result0['konten'];
				$konten = $konten.'<hr>
							<div align="right">
							<a target="_blank" href="'.site_url("iri/ricstatus/index/".$no_register."/".$jenisrawat).'"><input type="button" class="btn btn-detail" value="Detail"></a>
							<a target="_blank" href="'.site_url("jasa/jpdf/".$no_register."/".$jenisrawat).'"><input type="button" class="btn btn-primary" value="PDF"></a>
							<a target="_blank" href="'.site_url("jasa/jexcel/".$no_register."/".$jenisrawat).'"><input type="button" class="btn btn-danger" value="Excel"></a>
							</div>
							<hr>';
			}
			echo $konten;
		}else{
			echo 'error';
		}
		
	}

	public function jpdf($noregister='',$jenisrawat=''){
		if($noregister!='' && $jenisrawat!=''){
			$no_register=$noregister;
			$jenisrawat=$jenisrawat;
			$konten='';
			if($jenisrawat=='irj'){
				$result=$this->rjmpencarian->get_pelaksana_pasien_irj($no_register);
				$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style><table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>".$this->config->item('namars')."</b> <br/> ".$this->config->item('alamat')."</td>
						<td width=\"10%\"></td>						
						</tr>
						<tr><td></td><td></td></tr>
					</table>
					<table class=\"table table-responsive\">															
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($result[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($result[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($result[0]['cara_bayar'])."</td>
							</tr>
						</table>";
			}else{
				$result=$this->rimpasien->get_pelaksana_pasien_iri($no_register);
				$list_mutasi_pasien = $this->rimpasien->get_list_lokasi_mutasi_pasien($no_register);
				$result0=$this->string_table_jasa($list_mutasi_pasien,$result);
				$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style><table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\"  style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\">
							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"20\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"84%\" style=\"border-bottom:1px solid black; font-size:8.5px;\"><b>".$this->config->item('namars')."</b> <br/> ".$this->config->item('alamat')."</td>
												
						</tr>
						<tr><td></td><td></td></tr>
						
					</table><br><br>".$result0['konten'];				
			}
			$nama_pasien = str_replace(" ","_",$result[0]['nama']);
			$file_name = "pelaksana_".$noregister."_".$nama_pasien.".pdf";
			echo $konten;
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Pelaksana Pasien - ".$noregister." - ".$result[0]['nama'];
			$tgl_cetak = date("j F Y");
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins('5', '5', '5', '5');
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetAutoPageBreak(TRUE, '5');
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
		}else{
			redirect('jasa');
		}
	}

	public function jexcel($noregister='',$jenisrawat=''){

		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');

		$this->load->library('Excel'); 
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pelaksana_pasien.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$no = 1;
		if($noregister!='' && $jenisrawat!=''){
			$no_register=$noregister;
			$jenisrawat=$jenisrawat;			
			

			if($jenisrawat=='irj'){
				$result=$this->rjmpencarian->get_pelaksana_pasien_irj($no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Nama Pasien');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', $result[0]['nama']);
			}else {
				$result=$this->rimpasien->get_pelaksana_pasien_iri($no_register);
				$list_mutasi_pasien = $this->rimpasien->get_list_lokasi_mutasi_pasien($no_register);

				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Nama Pasien');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', $result[0]['nama']);

				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('B2', $result[0]['no_cm'] );

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Cara Bayar');
				$objPHPExcel->getActiveSheet()->SetCellValue('B3', $result[0]['carabayar']);
				$subtotal=0;
				$rowCount = 4;
				foreach($list_mutasi_pasien as $s){ 
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Ruangan '.$s['lokasi']);
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'No');
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Nama Pelaksana');
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Nama Ruangan');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Banyak Tindakan');
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');	
					$subtotal_intern = 0;
					$i=1;
					$rowCount++;
					foreach ($result as $r) {
						if($r['lokasi']==$s['lokasi']){
							$subtotal = $subtotal + $r['vtot'];
							$subtotal_intern = $subtotal_intern + $r['vtot'];
							$tumuminap = number_format($r['tumuminap'],0);
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $r['nm_dokter']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $r['nm_dokter']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $r['qtyyanri']);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $r['vtot']);
							$rowCount++;
						}
							
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total '.$s['lokasi']);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $subtotal_intern);
					$rowCount++;					
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total ');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $subtotal);
			}
			
			$file_name="Pelaksana_".$no_register.".xlsx";

			$objPHPExcel->getActiveSheet()->setTitle('Laporan Pelaksana');
			header('Content-Disposition: attachment;filename="'.$file_name.'"');
			$objPHPExcel->getActiveSheet()->setTitle($namars);
			ob_end_flush();
			//ob_end_clean();
			//this is the header given from PHPExcel examples.
			//but the output seems somewhat corrupted in some cases.
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');		
		
			redirect('jasa','refresh');
		}else{
			redirect('jasa');
		}
	}

}