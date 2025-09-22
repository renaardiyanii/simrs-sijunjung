<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include(dirname(dirname(__FILE__)).'/Tglindo.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Asia/Jakarta");		
//require_once(APPPATH.'controllers/Secure_area.php');
class Rjcexcel extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);
		$this->load->helper('tgl_indo_helper', TRUE);
		//$this->load->library('Excel'); 
		$this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}
	public function index()
	{
		redirect('irj/Rjcregistrasi','refresh');
	}
	
	public function excel_lapkunj($tampil_per='', $id_poli='', $var1='',$cara_bayar='',$bpjs_bayar='')
	{
		error_reporting(~E_ALL);
		error_reporting(E_ALL);
		$title = 'Laporan Kunjungan';
		//$tgl_indo = new Tglindo();
		
		//get nama poli
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		
		$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL
		$this->load->library('Excel'); 			
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_irj_excel.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
		$no = 1;
		
		if ($tampil_per=="TGL") {
			
			$tgl=$var1;
				
			//nama file----------------------------------
			$date_title = "Tanggal";
			
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date=substr($tgl1,0,2).' '.bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$cara_bayar);
				
			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$tgl1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$cara_bayar,$bpjs_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'NRP');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Cara Bayar');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Diagnosa Utama');
				
				$rowCount = 4;
				$vtot1=0;
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
				
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
				
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;

						$i=1;
						foreach($data_laporan_kunj as $row2){
						
							if ($row2->id_poli==$row1->id_poli) {

								$rowCount++;
								$i++;
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->no_nrp);
								if($row2->cara_bayar=='BPJS'){ 
									$carabayar=$row2->kontraktor; 
								} else 
									$carabayar=$row2->cara_bayar;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $carabayar);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->diagnosa);
							}
						}
						$vtot1=$vtot1+($i-1);
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $i-1)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
					}
				}	
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total Kunjungan')
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $vtot1)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			} else {  //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'NRP');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Cara Bayar');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Diagnosa Utama');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Keterangan');
				$rowCount=5;

				$file_name="KUNJ_POLI_".$id_poli."_$tgl1.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_harian($tgl, $id_poli,$cara_bayar)->result();
				
				$i=1;
				foreach($data_laporan_kunj as $row2){
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->no_nrp);
					if($row2->cara_bayar=='BPJS'){ 
						$carabayar=$row2->kontraktor; 
					} else 
						$carabayar=$row2->cara_bayar;
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $carabayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->diagnosa);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->ket_pulang);
				}
				
				$rowCount++;
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
					->getStyle('G'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $i-1)
					->getStyle('H'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

			}
		
		} else if ($tampil_per=="BLN") {
				
			$bulan=$var1;
			// $tgl_indo = new Tglindo();
			
			//nama file----------------------------------
			$bulan1 = substr($bulan,5,2)." ".date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date=$bulan1;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);

			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$bulan1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_bulanan($bulan)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Pasien Baru');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Pasien Lama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Jumlah Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Jumlah Batal');
				$rowCount=4;
				$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;
				foreach($poli as $row1){ 
	
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;$vtotlama=0;$vtotbaru=0;$vtotbatal=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$i++;
								$rowCount++;
								$vtot1=$vtot1+$row2->jumlah_kunj;
								$vtotbaru=$vtotbaru+$row2->pasien_baru;
								$vtotlama=$vtotlama+$row2->pasien_lama;
								$vtotbatal=$vtotbatal+$row2->jumlah_batal;
								$vtot=$vtot+$row2->jumlah_kunj;
								$vtot2=$vtot2+$row2->pasien_baru;
								$vtot3=$vtot3+$row2->pasien_lama;
								$vtot4=$vtot4+$row2->jumlah_batal;

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->pasien_baru);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->pasien_lama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->jumlah_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->jumlah_batal);

							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotbaru)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotlama)
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $vtotbatal)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Baru')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot2)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Lama')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot3)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Batal')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot4)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			} else {
				
				$file_name="KUNJ_POLI_".$id_poli."_$bulan1.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_bulanan($bulan, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Pasien Baru');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Pasien Lama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Jumlah Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Jumlah Batal');
				$rowCount=5;

				$i=1;
				$vtot=0;$vtotlama=0;$vtotbaru=0;$vtotbatal=0;
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$vtotbaru=$vtotbaru+$row->pasien_baru;
					$vtotlama=$vtotlama+$row->pasien_lama;
					$vtotbatal=$vtotbatal+$row->jumlah_batal;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->pasien_baru);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pasien_lama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->jumlah_kunj)
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->jumlah_batal)
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotbaru)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotlama)
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot)
					->getStyle('E'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotbatal)
					->getStyle('E'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			}
				
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			//nama file----------------------------------
			$date_title = "Tahun";
			$date=$tahun;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);

			if ($id_poli=="SEMUA") {
			
				$file_name="KUNJ_POLI_$tahun.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount=4;
				$vtot1=0;
				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$vtot=$vtot+$row2->jumlah_kunj;
								$vtot1=$vtot1+$row2->jumlah_kunj;
								$i++;
								$rowCount++;
								
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->bulan_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj);

							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total ')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KUNJ_POLI_".$id_poli."_$tahun.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount=5;
				
				$i=1;
				$vtot=0;
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->bulan_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			 
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		}
							
		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Kunjungan');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		
		//redirect('irj/Rjclaporan/lapkunjungan','refresh');
		
	}
	
	//LAPORAN KEUANGAN----------------------------------------------------------------------------------------------------------------------

	//TGL/SEMUA/2016-12-25/10/SEMUA/2017-03-01
	public function excel_lapkeu_old($tampil_per='', $id_poli='', $var1='', $status='', $cara_bayar='',$param1='')
	{
		
		$title = 'Laporan Keuangan';
		//$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL 
		
		require_once (APPPATH.'third_party/PHPExcel.php');
		////////////////////////////////////////////////////////////EXCEL 
		$this->load->library('Excel'); 		
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
			->setLastModifiedBy($namars);  
			//->setTitle("Laporan Keuangan RS PATRIA IKKT")  
			//->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
			//->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
			//->setKeywords("Pendapatan Dokter")  ;
			//->setCategory("Laporan Keuangan");  

		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_irj_excel.xlsx');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		if ($status=='10') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang dan Dirawat - '.$cara_bayar);
		} else if ($status=='1') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang - '.$cara_bayar);
		} else if ($status=='0') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Dirawat - '.$cara_bayar);		
		}
		$no = 1;
		$vtottotal=0;$vtotkunj=0;
		//$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
		$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;$vtotnilaikkglobal=0;
		if ($tampil_per=="TGL") {
		 
			$tgl=$var1;
			$tgl0=$param1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$tgl11 = date('d-m-Y', strtotime($tgl0));
			$date=substr($tgl1,0,2).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl11);
			
			if ($id_poli=="SEMUA") {
				
				//style & format
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('K5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('L5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('M5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('N5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('O5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->setAutoFilter('A5:O5');

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Status');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Cara Bayar');
				//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Biaya Tindakan');	
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Laboratorium');
				$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Radiologi');
				$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Obat');	
				$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Operasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tunai');
				$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'KK');
				$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Diskon');

				$rowCount = 5;

				$file_name="KEU_POLI_".$tgl1."_".$tgl11.".xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $tgl0)->result();
			
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;$total=0;
						$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;$vtotnilaikk=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							
								$rowCount++;
							
								$vtot+=$row2->vtot;
								$vtottotal+=$row2->vtot;
								$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
								$vtotrad+=$row2->vtot_rad;
								$vtotlab+=$row2->vtot_lab;
								$vtotobat+=$row2->vtot_obat;
								$vtotok+=$row2->vtot_ok;
								$vtottunai+=($row2->tunai+$row2->tunai2);
								$vtotnilaikk+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
								$vtotdiskon+=($row2->diskon+$row2->diskon2);
								$vtottot+=$total;
								//$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;
								$vtotlabglobal+=$row2->vtot_lab;
								$vtotradglobal+=$row2->vtot_rad;
								$vtotobatglobal+=$row2->vtot_obat;
								$vtotokglobal+=$row2->vtot_ok;
								$vtottunaiglobal+=($row2->tunai+$row2->tunai2);
								$vtotnilaikkglobal+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
								$vtotdiskonglobal+=($row2->diskon+$row2->diskon2);
								$vtottotglobal+=$total;
								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);		
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $textcb);

								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( ($row2->tunai+$row2->tunai2), 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( ($row2->nilai_kkkd+$row2->nilai_kkkd2), 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, number_format( ($row2->diskon+$row2->diskon2), 2 , ',' , '.' ))
										->getStyle('P'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);								
							}

						}
						
						
								/*$vtottotal+=$row2->vtot;
								$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_obat+$row2->vtot_ok;
								$vtotrad+=$row2->vtot_rad;
								$vtotlab+=$row2->vtot_lab;
								$vtotobat+=$row2->vtot_obat;
								$vtotok+=$row2->vtot_ok;
								$vtottunai+=$row2->tunai;
								$vtotdiskon+=$row2->diskon;
								$vtottot+=$total;
								$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Biaya Tindakan');	
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Laboratorium');
				$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Radiologi');
				$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Obat');	
				$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Operasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tunai');
				$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Diskon');*/
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $vtotlabglobal, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $vtotradglobal, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $vtotobatglobal, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $vtotokglobal, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $vtottunaiglobal, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $vtotnilaikkglobal, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, number_format( $vtotdiskonglobal, 2 , ',' , '.' ))
								->getStyle('P'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
						
						
					}
				}
				
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Nama');	
				$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Status');
				$objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Cara Bayar');
				//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('H6', 'Biaya Tindakan');	
				$objPHPExcel->getActiveSheet()->SetCellValue('I6', 'Laboratorium');
				$objPHPExcel->getActiveSheet()->SetCellValue('J6', 'Radiologi');
				$objPHPExcel->getActiveSheet()->SetCellValue('K6', 'Obat');	
				$objPHPExcel->getActiveSheet()->SetCellValue('L6', 'Operasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('M6', 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('N6', 'Tunai');
				$objPHPExcel->getActiveSheet()->SetCellValue('O6', 'KK');
				$objPHPExcel->getActiveSheet()->SetCellValue('P6', 'Diskon');
				
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$id_poli."_$tgl1_$tgl11.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl,$tgl0, $id_poli)->result();
				
				$vtot=0;$total=0;
				$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;$vtotnilaikk=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
					$vtottotal+=$row2->vtot;
					$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
					$vtotrad+=$row2->vtot_rad;
					$vtotlab+=$row2->vtot_lab;
					$vtotobat+=$row2->vtot_obat;
					$vtotok+=$row2->vtot_ok;
					$vtottunai+=($row2->tunai+$row2->tunai2);
					$vtotnilaikk+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
					$vtotdiskon+=($row2->diskon+$row2->diskon2);
					$vtottot+=$total;

					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $textcb);

								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( ($row2->tunai+$row2->tunai2), 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( ($row2->nilai_kkkd+$row2->nilai_kkkd2), 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, number_format( ($row2->diskon+$row2->diskon2), 2 , ',' , '.' ))
										->getStyle('P'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);					
				
				}
			
				
				
					$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $vtotlab, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $vtotrad, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $vtotobat, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $vtotok, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $vtottunai, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $vtotnilaikk, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, number_format( $vtotdiskon, 2 , ',' , '.' ))
								->getStyle('P'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}  

		} else if ($tampil_per=="BLN") {

			$bulan=$var1;
				
			//nama file----------------------------------
			$bulan1 = substr($bulan,5,2).date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="$bulan1";
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);
			 $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);
				
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_bulanan($bulan, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;
				
				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;$vtot1=0;
						$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$biayadaftar+=$row2->jumlah_biayadaftar;
								$vtot1+=$row2->jumlah_kunj;

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
									->getStyle('E'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
					}
				}
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_bulanan($bulan, $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;

				$i=1;
				$vtot=0;$vtot1=0;
				$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
			
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			$date_title = 'Tahun';
			$date=$tahun;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);

			
			if ($id_poli=="SEMUA") {
			
				$file_name="KEU_POLI_$tahun.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;

				
				foreach($poli as $row1){ 
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
		
						$i=1;
						$vtot=0;$vtot1=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$vtot1+=$row2->jumlah_kunj;
								//$biayadaftar+=$row2->jumlah_biayadaftar;
								

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->bulan_kunj);
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
								->getStyle('E'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
					
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					} //end if data tdk kosong
				} 
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;
				
				$i=1;
				$vtot=0;$vtot1=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					//$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->bulan_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
		}	
		
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Keuangan');
		
		
		//$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_start();
		//ob_end_flush();
		
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		ob_end_clean();  
		ob_start();

		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//ob_end_clean();
		$objWriter->save('php://output');		
	
		redirect('irj/Rjclaporan/lapkeu','refresh');


		
	}

	public function excel_lapkeu($lap_per='', $id_poli='', $var='', $status='', $cara_bayar='',$param1='')
	{
		$title = 'Laporan Keuangan';
		//$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}

		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', $title);
		// if ($status=='10') {
		// 	$sheet->setCellValue('A3', 'Status : Pulang dan Dirawat - '.$cara_bayar);
		// } else if ($status=='1') {
		// 	$sheet->setCellValue('A3', 'Status : Pulang - '.$cara_bayar);
		// } else if ($status=='0') {
		// 	$sheet->setCellValue('A3', 'Status : Dirawat - '.$cara_bayar);		
		// }

		$no = 1;
		$vtottotal=0;$vtotkunj=0;
		//$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
		$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;$vtotnilaikkglobal=0;

		if ($lap_per=="TGL") {
		 
			$tgl=$var;
			$tgl0=$param1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$tgl11 = date('d-m-Y', strtotime($tgl0));
			$date=substr($tgl1,0,2).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$sheet->setCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl11);
			
			if ($id_poli=="SEMUA") {
				
				//style & format
				$sheet->getStyle('A5')->getFont()->setBold(true);
      			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('B5')->getFont()->setBold(true);
      			$sheet->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('C5')->getFont()->setBold(true);
      			$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('D5')->getFont()->setBold(true);
      			$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('E5')->getFont()->setBold(true);
      			$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('F5')->getFont()->setBold(true);
      			$sheet->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('G5')->getFont()->setBold(true);
      			$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('H5')->getFont()->setBold(true);
      			$sheet->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('I5')->getFont()->setBold(true);
      			$sheet->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('J5')->getFont()->setBold(true);
      			$sheet->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('K5')->getFont()->setBold(true);
      			$sheet->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('L5')->getFont()->setBold(true);
      			$sheet->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('M5')->getFont()->setBold(true);
      			$sheet->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('N5')->getFont()->setBold(true);
      			$sheet->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->getStyle('O5')->getFont()->setBold(true);
      			$sheet->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$sheet->setAutoFilter('A5:O5');

				$sheet->SetCellValue('A5', 'No');
				$sheet->SetCellValue('B5', 'Poliklinik');
				$sheet->SetCellValue('C5', 'No Medrec');
				$sheet->SetCellValue('D5', 'No Register');
				$sheet->SetCellValue('E5', 'Nama');				
				// $sheet->SetCellValue('F5', 'Status');
				$sheet->SetCellValue('G5', 'Cara Bayar');
				//$sheet->SetCellValue('G5', 'Biaya Daftar');
				$sheet->SetCellValue('H5', 'Biaya Tindakan');	
				$sheet->SetCellValue('I5', 'Laboratorium');
				$sheet->SetCellValue('J5', 'Radiologi');
				$sheet->SetCellValue('K5', 'Obat');	
				$sheet->SetCellValue('L5', 'Operasi');
				$sheet->SetCellValue('M5', 'Total');
				$sheet->SetCellValue('N5', 'Tunai');
				$sheet->SetCellValue('O5', 'KK');
				$sheet->SetCellValue('P5', 'Diskon');

				$rowCount = 5;

				$file_name="KEU_POLI_".$tgl1."_".$tgl11.".xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $tgl0)->result();
				// echo "<pre>";
				// var_dump($data_laporan_keu);
				// echo "</pre>";
				// die();
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$sheet->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;$total=0;
						$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;$vtotnilaikk=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							
								$rowCount++;
							
								$vtot+=$row2->vtot;
								$vtottotal+=$row2->vtot;
								$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
								$vtotrad+=$row2->vtot_rad;
								$vtotlab+=$row2->vtot_lab;
								$vtotobat+=$row2->vtot_obat;
								$vtotok+=$row2->vtot_ok;
								$vtottunai+=($row2->tunai+$row2->tunai2);
								$vtotnilaikk+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
								$vtotdiskon+=($row2->diskon+$row2->diskon2);
								$vtottot+=$total;
								//$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;
								$vtotlabglobal+=$row2->vtot_lab;
								$vtotradglobal+=$row2->vtot_rad;
								$vtotobatglobal+=$row2->vtot_obat;
								$vtotokglobal+=$row2->vtot_ok;
								$vtottunaiglobal+=($row2->tunai+$row2->tunai2);
								$vtotnilaikkglobal+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
								$vtotdiskonglobal+=($row2->diskon+$row2->diskon2);
								$vtottotglobal+=$total;
								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$sheet->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$sheet->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$sheet->SetCellValue('D'.$rowCount, $row2->no_register);
								$sheet->SetCellValue('E'.$rowCount, $row2->nama);		
								// $sheet->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$sheet->SetCellValue('G'.$rowCount, $textcb);

								$sheet->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$sheet->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('N'.$rowCount, number_format( ($row2->tunai+$row2->tunai2), 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('O'.$rowCount, number_format( ($row2->nilai_kkkd+$row2->nilai_kkkd2), 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('P'.$rowCount, number_format( ($row2->diskon+$row2->diskon2), 2 , ',' , '.' ))
										->getStyle('P'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);								
							}

						}
						
							$rowCount++;
							$sheet->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$sheet->SetCellValue('H'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('I'.$rowCount, number_format( $vtotlabglobal, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('J'.$rowCount, number_format( $vtotradglobal, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('K'.$rowCount, number_format( $vtotobatglobal, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('L'.$rowCount, number_format( $vtotokglobal, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('N'.$rowCount, number_format( $vtottunaiglobal, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('O'.$rowCount, number_format( $vtotnilaikkglobal, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('P'.$rowCount, number_format( $vtotdiskonglobal, 2 , ',' , '.' ))
								->getStyle('P'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						
						
					}
				}
				
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$sheet->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$sheet->SetCellValue('B6', 'No');
				$sheet->SetCellValue('C6', 'No Medrec');
				$sheet->SetCellValue('D6', 'No Register');
				$sheet->SetCellValue('E6', 'Nama');	
				$sheet->SetCellValue('F6', 'Status');
				$sheet->SetCellValue('G6', 'Cara Bayar');
				//$sheet->SetCellValue('G5', 'Biaya Daftar');
				$sheet->SetCellValue('H6', 'Biaya Tindakan');	
				$sheet->SetCellValue('I6', 'Laboratorium');
				$sheet->SetCellValue('J6', 'Radiologi');
				$sheet->SetCellValue('K6', 'Obat');	
				$sheet->SetCellValue('L6', 'Operasi');
				$sheet->SetCellValue('M6', 'Total');
				$sheet->SetCellValue('N6', 'Tunai');
				$sheet->SetCellValue('O6', 'KK');
				$sheet->SetCellValue('P6', 'Diskon');
				
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$tgl1."_".$tgl11.".xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl,$tgl0, $id_poli)->result();
				
				$vtot=0;$total=0;
				$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;$vtotnilaikk=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
					$vtottotal+=$row2->vtot;
					$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
					$vtotrad+=$row2->vtot_rad;
					$vtotlab+=$row2->vtot_lab;
					$vtotobat+=$row2->vtot_obat;
					$vtotok+=$row2->vtot_ok;
					$vtottunai+=($row2->tunai+$row2->tunai2);
					$vtotnilaikk+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
					$vtotdiskon+=($row2->diskon+$row2->diskon2);
					$vtottot+=$total;

					$rowCount++;
					$sheet->SetCellValue('B'.$rowCount, $no++);
					$sheet->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$sheet->SetCellValue('D'.$rowCount, $row2->no_register);
					$sheet->SetCellValue('E'.$rowCount, $row2->nama);
					$sheet->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$sheet->SetCellValue('G'.$rowCount, $textcb);

								$sheet->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$sheet->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('N'.$rowCount, number_format( ($row2->tunai+$row2->tunai2), 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('O'.$rowCount, number_format( ($row2->nilai_kkkd+$row2->nilai_kkkd2), 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('P'.$rowCount, number_format( ($row2->diskon+$row2->diskon2), 2 , ',' , '.' ))
										->getStyle('P'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);					
				
				}
			
				
				
					$rowCount++;
							$sheet->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$sheet->SetCellValue('H'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('I'.$rowCount, number_format( $vtotlab, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('J'.$rowCount, number_format( $vtotrad, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('K'.$rowCount, number_format( $vtotobat, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('L'.$rowCount, number_format( $vtotok, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('N'.$rowCount, number_format( $vtottunai, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$sheet->SetCellValue('O'.$rowCount, number_format( $vtotnilaikk, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$sheet->SetCellValue('P'.$rowCount, number_format( $vtotdiskon, 2 , ',' , '.' ))
								->getStyle('P'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}  

		} else if ($tampil_per=="BLN") {

			$bulan=$var1;
				
			//nama file----------------------------------
			$bulan1 = substr($bulan,5,2).date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="$bulan1";
			//-------------------------------------------
			
			$sheet->SetCellValue('A2', 'Bulan : '.$date);
			 $sheet->SetCellValue('A4', 'Pasien : '.$cara_bayar);
				
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_bulanan($bulan, $status, $cara_bayar)->result();
				
				$sheet->SetCellValue('A6', 'No');
				$sheet->SetCellValue('B6', 'Poliklinik');
				$sheet->SetCellValue('C6', 'Tanggal');
				//$sheet->SetCellValue('D6', 'Total Biaya Daftar');
				$sheet->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;
				
				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	

						$sheet->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;$vtot1=0;
						$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$biayadaftar+=$row2->jumlah_biayadaftar;
								$vtot1+=$row2->jumlah_kunj;

								if ($setpoli==0){
									$sheet->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$sheet->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								/*$sheet->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								*/
								$sheet->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
									->getStyle('E'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
							}
						}
						
						$rowCount++;
						$sheet->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$sheet->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
						$sheet->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$sheet->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$sheet->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$sheet->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
					}
				}
				$rowCount++;
				$sheet->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$sheet->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_bulanan($bulan, $id_poli, $status, $cara_bayar)->result();
				
				$sheet->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$sheet->SetCellValue('A7', 'No');
				$sheet->SetCellValue('B7', 'Tanggal');
				//$sheet->SetCellValue('C7', 'Total Biaya Daftar');
				$sheet->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;

				$i=1;
				$vtot=0;$vtot1=0;
				$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$sheet->SetCellValue('A'.$rowCount, $no++);
					$sheet->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					/*$sheet->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$sheet->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$sheet->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$sheet->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$sheet->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$sheet->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$sheet->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
			
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			$date_title = 'Tahun';
			$date=$tahun;
			
			$sheet->SetCellValue('A2', 'Tahun : '.$date);
			$sheet->SetCellValue('A4', 'Pasien : '.$cara_bayar);

			
			if ($id_poli=="SEMUA") {
			
				$file_name="KEU_POLI_$tahun.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();
				
				$sheet->SetCellValue('A6', 'No');
				$sheet->SetCellValue('B6', 'Poliklinik');
				$sheet->SetCellValue('C6', 'Bulan');
				$sheet->SetCellValue('D6', 'Total Kunjungan');
				$sheet->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;

				
				foreach($poli as $row1){ 
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
		
						$sheet->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
		
						$i=1;
						$vtot=0;$vtot1=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$vtot1+=$row2->jumlah_kunj;
								//$biayadaftar+=$row2->jumlah_biayadaftar;
								

								if ($setpoli==0){
									$sheet->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$sheet->SetCellValue('C'.$rowCount, $row2->bulan_kunj);
								/*$sheet->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
								$sheet->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$sheet->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
								->getStyle('E'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
					
						$rowCount++;
						$sheet->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$sheet->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$sheet->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$sheet->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$sheet->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$sheet->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					} //end if data tdk kosong
				} 
				$rowCount++;
				$sheet->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$sheet->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();
				
				$sheet->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$sheet->SetCellValue('A7', 'No');
				$sheet->SetCellValue('B7', 'Bulan');
				//$sheet->SetCellValue('C7', 'Total Biaya Daftar');
				$sheet->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;
				
				$i=1;
				$vtot=0;$vtot1=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					//$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$sheet->SetCellValue('A'.$rowCount, $no++);
					$sheet->SetCellValue('B'.$rowCount, $row->bulan_kunj);
					/*$sheet->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$sheet->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$sheet->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$sheet->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$sheet->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$sheet->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$sheet->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
		}

		// ini_set('memory_limit', '128M');
		$writer = new Xlsx($spreadsheet);
		// $writer->setPreCalculateFormulas(false);
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $file_name .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function excel_lapkeudokter($id_dokter='', $tgl_awal='', $tgl_akhir='', $cara_bayar)
	{
	
		$data['title'] = 'Laporan Pendapatan Dokter';

		// $tgl_indo=new Tglindo();

		$id_dokter=$id_dokter;
		$tgl_awal=$tgl_awal;
		$tgl_akhir=$tgl_akhir;
		$dokter=$this->Rjmpencarian->get_dokter()->result();
		
		if($tgl_awal!='' && $tgl_akhir!=''){
			
			$tgl_awal1 = date('d-m-Y', strtotime($tgl_awal));
			$tgl_akhir1 = date('d-m-Y', strtotime($tgl_akhir));
				
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			//////////////////////////////////NAMA FILE
			$date_title = "Tanggal";
			if ($id_dokter=="SEMUA") {
				
				if($tgl_awal!=$tgl_akhir){
				$date=$tgl_awal1.' s/d '.$tgl_akhir1;
				$file_name="PENDAPATAN_DOKTER_(".$tgl_awal1."_sd_".$tgl_akhir1.").xlsx";
				}else{
					$date=$tgl_awal1;
					$file_name="PENDAPATAN_DOKTER_($tgl_awal1).xlsx";
				}
			} else {
				//get nama dokter
				$nm_dokter=$this->Rjmlaporan->get_nm_dokter($id_dokter)->row()->nm_dokter;
			
				if($tgl_awal!=$tgl_akhir){
				$date=$tgl_awal1.' s/d '.$tgl_akhir1;
				$file_name="PENDAPATAN_DOKTER_".$id_dokter."_(".$tgl_awal1."_sd_".$tgl_akhir1.").xlsx";
				}else{
					$date=$tgl_awal1;
					$file_name="PENDAPATAN_DOKTER_".$id_dokter."_($tgl_awal1).xlsx";
				}
			}
			$datakeu_dokter=$this->Rjmlaporan->get_data_keu_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar)->result();
			
			////////////////////////////////////////////////////////////EXCEL 
			//$this->load->library('Excel');  
			
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   

			// Set document properties  
			$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars);  
		        //->setTitle("Laporan Keuangan RS PATRIA IKKT")  
		        //->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
		        //->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
		        //->setKeywords("Pendapatan Dokter")  ;
		        //->setCategory("Laporan Keuangan");  

			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);  
			
			// Add some data  
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Cara Bayar : '.$cara_bayar);
			
			$no = 1;
				
			if ($id_dokter=="SEMUA") {
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Ruang');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Tindakan');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Instalasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Biaya');
				$rowCount = 5;
				
				foreach($dokter as $row1){ 

					$array = json_decode(json_encode($datakeu_dokter), True);
					$data_id_dokter=array_column($array, 'id_dokter');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_dokter, $data_id_dokter)) {		
						
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setdokter=0;
						$total=0;
						foreach($datakeu_dokter as $row2){
							if ($row2->id_dokter==$row1->id_dokter) {
								$rowCount++;
								$total+=$row2->vtot;
								
								if ($setdokter==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row2->nm_dokter);
									$setdokter=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl);
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->idrg);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->nmtindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->instalasi);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
									->getStyle('I'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Total')
							->getStyle('H'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $total, 2 , ',' , '.' ))
							->getStyle('I'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
					}
				}
				  
			} else {
			
				//get nama dokter
				$nm_dokter=$this->Rjmlaporan->get_nm_dokter($id_dokter)->row()->nm_dokter;
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Dokter : '.$nm_dokter);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Ruang');
				$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Tindakan');
				$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Instalasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Biaya');
				$rowCount = 6;
				
				$i=1;
				$total=0;
				foreach($datakeu_dokter as $row2){
					$rowCount++;
					$total+=$row2->vtot;
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row2->tgl);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nmtindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->instalasi);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
						->getStyle('G'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total')
					->getStyle('F'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $total, 2 , ',' , '.' ))
					->getStyle('G'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}
			
			header('Content-Disposition: attachment;filename="'.$file_name.'"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('Pendapatan Dokter ');  
	   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			ob_start();
	   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Cache-Control: max-age=0');  
			   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			$objWriter->save('php://output');
		
		} else{
			redirect('irj/Rjclaporan/lapkeu_dokter','refresh');
		}
	}

	
	public function excel_lapkeu_perkasir($lap_per='', $id_poli='', $var='', $status='', $cara_bayar='',$param1='')
	{
		$title = 'LAPORAN PENERIMAAN PER KASIR PER KWITANSI';
		//$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}

		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', $title);
		
		
		

		$no = 1;
		$vtottotal=0;$vtotkunj=0;
		//$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
		$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;$vtotnilaikkglobal=0;

		if ($lap_per=="TGL") {
		 
			$tgl=$var;
			$tgl0=$param1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$tgl11 = date('d-m-Y', strtotime($tgl0));
			$date=substr($tgl1,0,2).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			$login_data = $this->load->get_var("user_info");
			
			//-------------------------------------------
			$sheet->setCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl11);
			$sheet->setCellValue('A3', 'Nama Kasir : '.$login_data->name);
			if ($id_poli=="SEMUA") {
				
				//style & format
				

				$sheet->SetCellValue('A5', 'No');
				$sheet->SetCellValue('B5', 'Nama Poli');
				$sheet->SetCellValue('C5', 'Nomor Transaksi');
				$sheet->SetCellValue('D5', 'Jam');
				$sheet->SetCellValue('E5', 'Data Pasien');				
				$sheet->SetCellValue('F5', 'Status');
				$sheet->SetCellValue('G5', 'Tindakan');
				$sheet->SetCellValue('H5', 'Biaya ADM');	
				$sheet->SetCellValue('I5', 'Biaya Barcode');
				$sheet->SetCellValue('J5', 'Total');

				$rowCount = 5;

				$file_name="KEU_KASIR_".$tgl1."_".$tgl11."";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_kasir($tgl, $tgl0,$login_data->username)->result();							
			
				$biaya_tindakan_global=0;
				$biaya_tindakan_adm_global=0;
				$biaya_tindakan_kartu_global=0;
				$total_biaya_global=0;
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$sheet->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;$total=0;
						$biaya_tindakan=0;
						$total_biaya=0;
						
						$biaya_tindakan_total=0;
						$biaya_tindakan_adm_total=0;
						$biaya_tindakan_kartu_total=0;
						$total_biaya_semua=0;
						
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$rowCount++;
								$total_biaya = (int)$row2->biaya_tindakan+(int)$row2->biaya_adm+(int)$row2->biaya_kartu;

								$biaya_tindakan_total += $row2->biaya_tindakan;
								$biaya_tindakan_adm_total += $row2->biaya_adm;
								$biaya_tindakan_kartu_total += $row2->biaya_kartu;
								$total_biaya_semua += $total_biaya;

								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$sheet->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$sheet->SetCellValue('C'.$rowCount, $row2->no_kwitansi);
								$sheet->SetCellValue('D'.$rowCount, substr($row2->tgl_cetak,11,5));
								$sheet->SetCellValue('E'.$rowCount, $row2->nama);		
								$sheet->SetCellValue('F'.$rowCount, $row2->status);		
								$sheet->SetCellValue('G'.$rowCount, $row2->biaya_tindakan);
								$sheet->SetCellValue('H'.$rowCount, $row2->biaya_adm);
								$sheet->SetCellValue('I'.$rowCount, $row2->biaya_kartu);
								$sheet->SetCellValue('J'.$rowCount, $total_biaya);
								
							}

						}
						
							$biaya_tindakan_global += $biaya_tindakan_total;
							
					

							$biaya_tindakan_adm_global += $biaya_tindakan_adm_total;
							$biaya_tindakan_kartu_global += $biaya_tindakan_kartu_total;
							$total_biaya_global += $total_biaya_semua;
							$rowCount++;
							$sheet->SetCellValue('F'.$rowCount, 'Sub Total');	
							$sheet->SetCellValue('G'.$rowCount, number_format( $biaya_tindakan_total, 2 , ',' , '.' ));
							$sheet->SetCellValue('H'.$rowCount, number_format( $biaya_tindakan_adm_total, 2 , ',' , '.' ));
							$sheet->SetCellValue('I'.$rowCount, number_format( $biaya_tindakan_kartu_total, 2 , ',' , '.' ));							
							$sheet->SetCellValue('J'.$rowCount, number_format( $total_biaya_semua, 2 , ',' , '.' ));
						
						
						
					}
					
				}
				// var_dump($biaya_tindakan_global);
				// die();
				$rowCount++;
				$sheet->SetCellValue('F'.$rowCount, 'Total Setoran Tunai');				
				$sheet->SetCellValue('G'.$rowCount, number_format( $biaya_tindakan_global, 2 , ',' , '.' ));							
				$sheet->SetCellValue('H'.$rowCount, number_format( $biaya_tindakan_adm_global, 2 , ',' , '.' ));
				$sheet->SetCellValue('I'.$rowCount, number_format( $biaya_tindakan_kartu_global, 2 , ',' , '.' ));							
				$sheet->SetCellValue('J'.$rowCount, number_format( $total_biaya_global, 2 , ',' , '.' ));

			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$sheet->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$sheet->SetCellValue('B6', 'No');
				$sheet->SetCellValue('C6', 'No Medrec');
				$sheet->SetCellValue('D6', 'No Register');
				$sheet->SetCellValue('E6', 'Nama');	
				$sheet->SetCellValue('F6', 'Status');
				$sheet->SetCellValue('G6', 'Cara Bayar');
				//$sheet->SetCellValue('G5', 'Biaya Daftar');
				$sheet->SetCellValue('H6', 'Biaya Tindakan');	
				$sheet->SetCellValue('I6', 'Laboratorium');
				$sheet->SetCellValue('J6', 'Radiologi');
				$sheet->SetCellValue('K6', 'Obat');	
				$sheet->SetCellValue('L6', 'Operasi');
				$sheet->SetCellValue('M6', 'Total');
				$sheet->SetCellValue('N6', 'Tunai');
				$sheet->SetCellValue('O6', 'KK');
				$sheet->SetCellValue('P6', 'Diskon');
				
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$tgl1."_".$tgl11.".xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl,$tgl0, $id_poli)->result();
				
				$vtot=0;$total=0;
				$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;$vtotnilaikk=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
					$vtottotal+=$row2->vtot;
					$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
					$vtotrad+=$row2->vtot_rad;
					$vtotlab+=$row2->vtot_lab;
					$vtotobat+=$row2->vtot_obat;
					$vtotok+=$row2->vtot_ok;
					$vtottunai+=($row2->tunai+$row2->tunai2);
					$vtotnilaikk+=($row2->nilai_kkkd+$row2->nilai_kkkd2);
					$vtotdiskon+=($row2->diskon+$row2->diskon2);
					$vtottot+=$total;

					$rowCount++;
					$sheet->SetCellValue('B'.$rowCount, $no++);
					$sheet->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$sheet->SetCellValue('D'.$rowCount, $row2->no_register);
					$sheet->SetCellValue('E'.$rowCount, $row2->nama);
					$sheet->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$sheet->SetCellValue('G'.$rowCount, $textcb);

								$sheet->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ));
								$sheet->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ));
								$sheet->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ));
								$sheet->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ));
								$sheet->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ));
										
								$sheet->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ));
								$sheet->SetCellValue('N'.$rowCount, number_format( ($row2->tunai+$row2->tunai2), 2 , ',' , '.' ));
								$sheet->SetCellValue('O'.$rowCount, number_format( ($row2->nilai_kkkd+$row2->nilai_kkkd2), 2 , ',' , '.' ));
								$sheet->SetCellValue('P'.$rowCount, number_format( ($row2->diskon+$row2->diskon2), 2 , ',' , '.' ));					
				
				}
			
				
				
					$rowCount++;
							$sheet->SetCellValue('G'.$rowCount, 'Total');	
							$sheet->SetCellValue('H'.$rowCount, number_format( $vtot, 2 , ',' , '.' ));							
							$sheet->SetCellValue('I'.$rowCount, number_format( $vtotlab, 2 , ',' , '.' ));
							$sheet->SetCellValue('J'.$rowCount, number_format( $vtotrad, 2 , ',' , '.' ));							
							$sheet->SetCellValue('K'.$rowCount, number_format( $vtotobat, 2 , ',' , '.' ));
							$sheet->SetCellValue('L'.$rowCount, number_format( $vtotok, 2 , ',' , '.' ));							
							$sheet->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ));
							$sheet->SetCellValue('N'.$rowCount, number_format( $vtottunai, 2 , ',' , '.' ));							
							$sheet->SetCellValue('O'.$rowCount, number_format( $vtotnilaikk, 2 , ',' , '.' ));
							$sheet->SetCellValue('P'.$rowCount, number_format( $vtotdiskon, 2 , ',' , '.' ));	
				
			}  

		}

		// die();
		$writer = new Xlsx($spreadsheet);
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $file_name .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
}
?>
