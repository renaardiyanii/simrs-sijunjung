<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Doclaporan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model("laporan/mlaporandiagnosa");
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

    public function index(){
		$data['title'] = 'Laporan Pendapatan Dokter';
		
		// if (isset($_POST["tgl"])) {
		// 	$array_tgl = explode(" - ", $_POST["tgl"]);
		// 	print_r($array_tgl[0]);
		// 	print_r($array_tgl[1]);
		// 	exit();
		// }
		$data['allKSM'] = $this->mlaporandiagnosa->getAllKSM()->result();

		if (isset($_POST["startMonth"]) && isset($_POST["ksm"])) {
			$array_tgl = explode("-", $_POST["startMonth"]);
			$month = $array_tgl[0];
			$year = $array_tgl[1];
			// $year = date("Y",strtotime($array_tgl[0]));
			// $startTime = date("m",strtotime($array_tgl[0]));
			// $endTime = date("m",strtotime($array_tgl[1]));
			$ksm = $_POST["ksm"];
			$stringKsm = implode (", ", $ksm);
			// $idDokter = $_POST["dokter"];
			// $stringIdDokter = implode (", ", $idDokter);
			// print_r($ksm);
			// print_r($stringIdDokter);
			// exit();
			$data["pendapatanDokter"] = $this->mlaporandiagnosa->getLaporanPendapatanPerDokter($year,$month, "", $stringKsm)->result();
			// print_r($data["pendapatanDokter"]);
			// exit();
		}
		
        $this->load->view('laporan/view_pendapatan_dokter',$data);
    }

	public function getDokterByPoli($id_poli='')
	{
		if ($id_poli == "SEMUA") {
			// echo "<option selected value='' disabled>-Pilih Dokter-</option>";
			// echo "<option value='SEMUA'>SEMUA</option> ";				
		}else{
			$data=$this->mlaporandiagnosa->getDokterByPoli($id_poli)->result();
			// echo "<option selected value='' disabled>-Pilih Dokter-</option>";
			// echo "<option value='SEMUA'>SEMUA</option> ";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
		}
		
	}

	public function getDataRealisasi(){
		header('Content-Type: application/json');
		// $array_tgl = explode("-", $_POST["startMonth"]);
		// $month = $array_tgl[0];
		// $year = $array_tgl[1];
		$startMonth = $_POST["startMonth"];
		// $monthDateTime = strtotime($startMonth);
		// $monthDateTimeFormat = date('Y-m-dd', $monthDateTime);
		$endMonth = $_POST["endMonth"];
		$ksm = $_POST["ksm"];
		// print_r($startMonth);
		// exit();
		$stringKsm = implode (", ", $ksm);
		$pendapatanDokter = $this->mlaporandiagnosa->getLaporanPendapatanPerDokter($startMonth,$endMonth, $stringKsm)->result();
		// print_r($pendapatanDokter);
		// exit();
		$rowNum = 1;
		$newArr  = array();
		foreach ($pendapatanDokter as $result) {
			$newArr[] = array(
				"no" => $rowNum,
				"nm_dokter" => $result->nm_dokter,
				"ksm" => $result->ksm,
				"iri_bpjs" => $result->iri_bpjs,
				"iri_umum" => $result->iri_umum,
				"iri_iks" => $result->iri_iks,
				"irj_bpjs" => $result->irj_bpjs,
				"irj_umum" => $result->irj_umum,
				"irj_iks" => $result->irj_iks,
				"ok_bpjs" => $result->ok_bpjs,
				"ok_umum" => $result->ok_umum,
				"ok_iks" => $result->ok_iks,
				"no_ok_bpjs" => $result->no_ok_bpjs,
				"non_ok_umum" => $result->non_ok_umum,
				"non_ok_iks" => $result->non_ok_iks,
				"total_tarif" => "Rp. ". number_format($result->total_tarif,2,',','.'),
				"pendapatan_bpjs" => "",
				"pendapatan_umum" => "",
				"pendapatan_iks" => ""
			);
			$rowNum++;
		}
		echo json_encode($newArr);
	}

	public function getDataRealisasiExcel(){
		header('Content-Type: application/json');
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// print_r($_POST);
		// exit();

		
		// $array_tgl = explode("-", $_POST["startMonth"]);
		// $month = $array_tgl[0];
		// $year = $array_tgl[1];
		$startMonth = $_POST["startMonth"];
		$endMonth = $_POST["endMonth"];
		$startMonthString = $_POST["startMonthString"];
		$endMonthString = $_POST["endMonthString"];
		$ksm = $_POST["ksm"];
		$stringKsm = implode(", ", $ksm);
		$pendapatanDokter = $this->mlaporandiagnosa->getLaporanPendapatanPerDokter($startMonth,$endMonth, $stringKsm)->result();
		// print_r($stringMonth);
		// exit();
		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');
		$row = 5;
		// $this->excel->getActiveSheet()->mergeCells('A1:A2');
		$sheet->setCellValue('A1','Laporan Pendapatan Dokter');
		$sheet->mergeCells('A1:S1');
		// $sheet->setCellValue('A2', $stringMonth.'-'.$year);
		$sheet->setCellValue('A3', 'No');
		$sheet->mergeCells('A3:A4');
		$sheet->setCellValue('B3', 'Nama Dokter');
		$sheet->mergeCells('B3:B4');
		$sheet->setCellValue('C3', 'KSM');
		$sheet->mergeCells('C3:C4');
		$sheet->setCellValue('D3', 'Jumlah Kasus Ranap');
		$sheet->mergeCells('D3:F3');
		$sheet->setCellValue('D4', 'BPJS');
		$sheet->setCellValue('E4', 'Umum');
		$sheet->setCellValue('F4', 'IKS');
		$sheet->setCellValue('G3', 'Jumlah Kasus Rajal');
		$sheet->mergeCells('G3:I3');
		$sheet->setCellValue('G4', 'BPJS');
		$sheet->setCellValue('H4', 'Umum');
		$sheet->setCellValue('I4', 'IKS');
		$sheet->setCellValue('J3', 'Jumlah Tindakan OK');
		$sheet->mergeCells('J3:L3');
		$sheet->setCellValue('J4', 'BPJS');
		$sheet->setCellValue('K4', 'Umum');
		$sheet->setCellValue('L4', 'IKS');
		$sheet->setCellValue('M3', 'Jumlah Tindakan Diluar OK');
		$sheet->mergeCells('M3:O3');
		$sheet->setCellValue('M4', 'BPJS');
		$sheet->setCellValue('N4', 'Umum');
		$sheet->setCellValue('O4', 'IKS');
		$sheet->setCellValue('P3', 'Total Tarif');
		$sheet->mergeCells('P3:P4');
		$sheet->setCellValue('Q3', 'Penerimaan');
		$sheet->mergeCells('Q3:S3');
		$sheet->setCellValue('Q4', 'BPJS');
		$sheet->setCellValue('R4', 'Umum');
		$sheet->setCellValue('S4', 'IKS');

		$no = 1;
		foreach ($pendapatanDokter as $result) {
			$sheet->setCellValue('A'.$row, $no);
			$sheet->setCellValue('B'.$row, $result->nm_dokter);
			$sheet->setCellValue('C'.$row, $result->ksm);
			$sheet->setCellValue('D'.$row, $result->iri_bpjs);
			$sheet->setCellValue('E'.$row, $result->iri_umum);
			$sheet->setCellValue('F'.$row, $result->iri_iks);
			$sheet->setCellValue('G'.$row, $result->irj_bpjs);
			$sheet->setCellValue('H'.$row, $result->irj_umum);
			$sheet->setCellValue('I'.$row, $result->irj_iks);
			$sheet->setCellValue('J'.$row, $result->ok_bpjs);
			$sheet->setCellValue('K'.$row, $result->ok_umum);
			$sheet->setCellValue('L'.$row, $result->ok_iks);
			$sheet->setCellValue('M'.$row, $result->no_ok_bpjs);
			$sheet->setCellValue('N'.$row, $result->non_ok_umum);
			$sheet->setCellValue('O'.$row, $result->non_ok_iks);
			$sheet->setCellValue('P'.$row, $result->total_tarif);
			$sheet->setCellValue('Q'.$row, "");
			$sheet->setCellValue('R'.$row, "");
			$sheet->setCellValue('S'.$row, "");
			$row++;
			$no++;
		}

		$filename='Realisasi_Dokter_'.$startMonthString.'_'.$endMonthString;
		// exit();
		ob_start();
		$writer = new Xlsx($spreadsheet);
		//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		$xlsData = ob_get_contents();
        ob_end_clean();
        $response =  array(
            'status' => TRUE,
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
			'fileName' => $filename.'.xlsx'
        );
    
        // die(json_encode($response));
		echo json_encode($response);
	}
}