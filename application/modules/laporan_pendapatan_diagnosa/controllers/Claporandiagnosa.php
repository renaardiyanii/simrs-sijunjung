<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Claporandiagnosa extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model("laporan/mlaporandiagnosa");
		
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

    public function index(){
		$data['title'] = 'Laporan Pendapatan Diagnosa';
		
		if (isset($_POST["tgl"]) && isset($_POST["penjamin"]) && isset($_POST["kelPelayanan"])) {
			$array_tgl = explode(" - ", $_POST["tgl"]);
			$startTime = date("m",strtotime($array_tgl[0]));
			$endTime = date("m",strtotime($array_tgl[1]));
			$penjamin = $_POST["penjamin"];
			$kelPelayanan = $_POST["kelPelayanan"];
			// print_r($startTime);
			// print_r($array_tgl[1]);
			// print_r($_POST["penjamin"]);
			// exit();
			$result = $this->mlaporandiagnosa->laporan_pendapatan_diagnosa_rajal($startTime, $endTime,$penjamin, $kelPelayanan)->result();
			$data["pendapatan_diagnosa"] = $result;
			// print_r($result);
			// exit();
			
		}

        $this->load->view('laporan/view_pendapatan_diagnosa',$data);
    }

	public function getPendapatanDiagnosa(){
		header('Content-Type: application/json');
		// $array_tgl = explode(" - ", $_POST["tgl"]);
		// $startTime = date("Y-m-d",strtotime($array_tgl[0]));
		// $endTime = date("Y-m-d",strtotime($array_tgl[1]));
		// print_r($array_tgl);
		// exit();
		$startTime = $_POST["startMonth"];
		$endTime = $_POST["endMonth"];
		$penjamin = $_POST["penjamin"];
		$kelPelayanan = $_POST["kelPelayanan"];
		$result = $this->mlaporandiagnosa->laporan_pendapatan_diagnosa_rajal($startTime, $endTime,$penjamin, $kelPelayanan)->result();
		$pendapatanDiagnosa = $result;
		$rowNum = 1;
		$newArr  = array();
		foreach ($pendapatanDiagnosa as $r) {
			$newArr[] = array(
				"no" => $rowNum,
				"diagnosa" => $r->diagnosa,
				"cara_bayar" => $r->cara_bayar,
				"id_diagnosa" => $r->id_diagnosa,
				"total_kasus" => $r->total_kasus,
				"total_pendapatan" => "Rp. ". number_format($r->total_pendapatan,2,',','.'),
				"kode_cbg" => "",
				"nama_cbg" => "",
			);
			$rowNum++;
		}
		echo json_encode($newArr);
	}

	public function getPendapatanDiagnosaExcel(){
		header('Content-Type: application/json');
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// $array_tgl = explode(" - ", $_POST["tgl"]);
		// $startTime = date("Y-m-d",strtotime($array_tgl[0]));
		// $endTime = date("Y-m-d",strtotime($array_tgl[1]));
		
		// print_r($array_tgl);
		// exit();
		$startTime = $_POST["startMonth"];
		$endTime = $_POST["endMonth"];
		$startTimeString = $_POST["startMonthString"];
		$endTimeString = $_POST["endMonthString"];
		$penjamin = $_POST["penjamin"];
		$kelPelayanan = $_POST["kelPelayanan"];
		$result = $this->mlaporandiagnosa->laporan_pendapatan_diagnosa_rajal($startTime, $endTime,$penjamin, $kelPelayanan)->result();
		$pendapatanDiagnosa = $result;
		$kelompok = "";
		if ($kelPelayanan == "rawat_jalan") {
			$kelompok = "Rawat Jalan";
		}
		if ($kelPelayanan == "rawat_inap") {
			$kelompok = "Rawat Inap";
		}
		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');
		$row = 5;
		// $this->excel->getActiveSheet()->mergeCells('A1:A2');
		$sheet->setCellValue('A1','Laporan Pendapatan Diagnosa');
		$sheet->mergeCells('A1:H1');
		$sheet->setCellValue('A2',$kelompok." - ".$penjamin);
		$sheet->setCellValue('A3',$startTimeString." s/d ".$endTimeString);
		$sheet->setCellValue('A4', 'No');
		$sheet->setCellValue('B4', 'Diagnosa');
		$sheet->setCellValue('C4', 'Nama Diagnosa');
		$sheet->setCellValue('D4', 'Kode CBG');
		$sheet->setCellValue('E4', 'Nama CBG');
		$sheet->setCellValue('F4', 'Jumlah Kasus');
		$sheet->setCellValue('G4', 'Total Tarif Riil');
		$sheet->setCellValue('H4', 'Total Tarif BPJ (Umbal)');

		$no = 1;
		foreach ($pendapatanDiagnosa as $r) {
			$sheet->setCellValue('A'.$row, $no);
			$sheet->setCellValue('B'.$row, $r->id_diagnosa);
			$sheet->setCellValue('C'.$row, $r->diagnosa);
			$sheet->setCellValue('D'.$row, "");
			$sheet->setCellValue('E'.$row, "");
			$sheet->setCellValue('F'.$row, $r->total_kasus);
			$sheet->setCellValue('G'.$row, $r->total_pendapatan);
			$sheet->setCellValue('H'.$row, "");
			$row++;
			$no++;
		}

		// $startPeriod = date("Ymd",strtotime($array_tgl[0]));
		// $endPeriod = date("Ymd",strtotime($array_tgl[1]));
		$filename='Realisasi_Diagnosa_'.$startTimeString.'_'.$endTimeString;
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