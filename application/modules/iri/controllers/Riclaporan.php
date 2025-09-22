<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// include(dirname(dirname(__FILE__)).'/Tglindo.php');
// require_once(APPPATH.'controllers/Secure_area.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Riclaporan extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimuser');
		$this->load->model('iri/rimlaporan');
		$this->load->helper('url');
		$this->load->model('irj/Rjmpencarian', '', TRUE);
		$this->load->model('irj/Rjmpelayanan', '', TRUE);
		$this->load->model('irj/Rjmkwitansi', '', TRUE);
		$this->load->model('irj/Rjmlaporan', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->helper('pdf_helper');
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}
	public function index()
	{
		$data['title'] = 'Laporan Rawat Inap - Jumlah Pasien Keluar Masuk';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir);
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan_harian', $data);
		}

		if ($tipe_input == 'TGL') {
			// $data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir);
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan_harian', $data);
		}

		if ($tipe_input == 'BLN') {
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_bulan($bulan);

			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan', $data);
		}

		if ($tipe_input == 'THN') {
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_tahun($tahun);
		}
	}

	public function lap_jml_pasien_pulang_iri()
	{
		$data['title'] = 'Laporan Jumlah Pasien Rawat Inap';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		//bikin object buat penanggalan
		$data['controller'] = $this;

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		//  $jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();

		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			$data['data_kunjungan'] = $this->rimlaporan->get_jml_pasien_pulang_iri($tgl_awal, $tgl_akhir);

			//  $data['tgl_awal_show'] = "";
			//  $data['tgl_akhir_show'] = "";
			//  $data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_jml_pasien_pulang_iri($tgl_awal, $tgl_akhir);

			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_laporan_jml_pasien_pulang', $data);
		}

		if ($tipe_input == 'TGL') {

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_jml_pasien_pulang_iri($tgl_awal, $tgl_akhir);

			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_laporan_jml_pasien_pulang', $data);
		}
	}

	public function lap_data_pasien_pulang_iri()
	{
		$data['title'] = 'Laporan Pasien Rawat Jalan/Darurat Baru';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		//bikin object buat penanggalan
		$data['controller'] = $this;

		$tipe_input = $this->input->post('tampil_per');
		$tgl = $this->input->post('tgl');
		$data['tampil_per'] = $tipe_input;
		//$id_poli = $this->input->post('id_poli');
		//$data['id_poli'] = $this->input->post('id_poli');
		//$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd_gaada_tiga()->result();
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();

		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl = date("Y-m-d");
			//$tgl_akhir = date("Y-m-d");
			$data['data_kunjungan'] = $this->rimlaporan->get_lap_data_pasien_pulang_iri($tgl);
			//$data['diagnosa'] = $this->Rjmlaporan->get_diagnosa_pasien()->row();
			$data['tgl'] = $tgl;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_lap_data_pasien_pulang_iri($tgl);

			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_data_pasien_pulang_iri', $data);
		}

		if ($tipe_input == 'TGL') {

			$data['tgl'] = $tgl;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_lap_data_pasien_pulang_iri($tgl);
			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_data_pasien_pulang_iri', $data);
		}

		if ($tipe_input == 'BLN') {

			$data['tgl'] = $bulan;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_lap_data_pasien_pulang_iri_bulan($bulan);
			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_data_pasien_pulang_iri', $data);
		}

		if ($tipe_input == 'THN') {

			$data['tgl'] = $tahun;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_lap_data_pasien_pulang_iri_tahun($tahun);
			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_data_pasien_pulang_iri', $data);
		}
	}

	public function excel_lap_data_pasien_pulang_iri_today($tgl = '')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');

		$data_kunjungan = $this->rimlaporan->get_lap_data_pasien_pulang_iri($tgl);

		//ambil semua data pendapatan

		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		$sheet->setCellValue('A' . $row, 'No Register');
		$sheet->setCellValue('B' . $row, 'Nama');
		$sheet->setCellValue('C' . $row, 'No RM');
		$sheet->setCellValue('D' . $row, 'Umur');
		$sheet->setCellValue('E' . $row, 'Jenkel');
		$sheet->setCellValue('F' . $row, 'Jaminan');
		$sheet->setCellValue('G' . $row, 'Alamat');
		$sheet->setCellValue('H' . $row, 'Diagnosa');
		$sheet->setCellValue('I' . $row, 'Kode ICD-10');
		$sheet->setCellValue('J' . $row, 'Dokter');

		foreach ($data_kunjungan as $r) {

			$start = new DateTime($r['tgl_lahir']); //start
			$end = new DateTime('today'); //end
			$y = $end->diff($start)->y;

			$row++;
			$sheet->setCellValue('A' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C' . $row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D' . $row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E' . $row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F' . $row, $r['carabayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G' . $row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H' . $row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I' . $row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J' . $row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

		}

		$filename = 'Kunjungan Data Pasien Rawat Inap Tanggal ' . $tgl; //save our workbook as this file name
		$writer = new Xlsx($spreadsheet);
		//ob_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_data_pasien_pulang_iri($tampil_per = '', $tgl = '')
	{
		//var_dump($tampil_per, $tgl); die();

		if ($tampil_per == 'TGL') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			//activate worksheet number 1
			$spreadsheet->setActiveSheetIndex(0);
			//name the worksheet
			$sheet->setTitle('Worksheet 1');

			$data_kunjungan = $this->rimlaporan->get_lap_data_pasien_pulang_iri($tgl);

			//ambil semua data pendapatan

			//print_r($data_pasien_keluar_tanggal[0]);exit;
			$row = 1;
			//set header excel
			$sheet->setCellValue('A' . $row, 'No Register');
			$sheet->setCellValue('B' . $row, 'Nama');
			$sheet->setCellValue('C' . $row, 'No RM');
			$sheet->setCellValue('D' . $row, 'Umur');
			$sheet->setCellValue('E' . $row, 'Jenkel');
			$sheet->setCellValue('F' . $row, 'Jaminan');
			$sheet->setCellValue('G' . $row, 'Alamat');
			$sheet->setCellValue('H' . $row, 'Diagnosa');
			$sheet->setCellValue('I' . $row, 'Kode ICD-10');
			$sheet->setCellValue('J' . $row, 'Dokter');

			foreach ($data_kunjungan as $r) {

				$start = new DateTime($r['tgl_lahir']); //start
				$end = new DateTime('today'); //end
				$y = $end->diff($start)->y;

				$row++;
				$sheet->setCellValue('A' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('B' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('C' . $row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('D' . $row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('E' . $row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('F' . $row, $r['carabayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('G' . $row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('H' . $row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('I' . $row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('J' . $row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

				// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

			}

			$filename = 'Kunjungan Data Pasien Rawat Inap Tanggal ' . $tgl; //save our workbook as this file name
			$writer = new Xlsx($spreadsheet);
			//ob_clean();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		} else if ($tampil_per == 'BLN') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			//activate worksheet number 1
			$spreadsheet->setActiveSheetIndex(0);
			//name the worksheet
			$sheet->setTitle('Worksheet 1');

			$data_kunjungan = $this->rimlaporan->get_lap_data_pasien_pulang_iri_bulan($tgl);

			//ambil semua data pendapatan

			//print_r($data_pasien_keluar_tanggal[0]);exit;
			$row = 1;
			//set header excel
			$sheet->setCellValue('A' . $row, 'No Register');
			$sheet->setCellValue('B' . $row, 'Nama');
			$sheet->setCellValue('C' . $row, 'No RM');
			$sheet->setCellValue('D' . $row, 'Umur');
			$sheet->setCellValue('E' . $row, 'Jenkel');
			$sheet->setCellValue('F' . $row, 'Jaminan');
			$sheet->setCellValue('G' . $row, 'Alamat');
			$sheet->setCellValue('H' . $row, 'Diagnosa');
			$sheet->setCellValue('I' . $row, 'Kode ICD-10');
			$sheet->setCellValue('J' . $row, 'Dokter');

			foreach ($data_kunjungan as $r) {

				$start = new DateTime($r['tgl_lahir']); //start
				$end = new DateTime('today'); //end
				$y = $end->diff($start)->y;

				$row++;
				$sheet->setCellValue('A' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('B' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('C' . $row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('D' . $row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('E' . $row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('F' . $row, $r['carabayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('G' . $row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('H' . $row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('I' . $row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('J' . $row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

				// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

			}

			$filename = 'Kunjungan Data Pasien Rawat Inap Bulan ' . $tgl; //save our workbook as this file name
			$writer = new Xlsx($spreadsheet);
			//ob_clean();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		} else if ($tampil_per == 'THN') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			//activate worksheet number 1
			$spreadsheet->setActiveSheetIndex(0);
			//name the worksheet
			$sheet->setTitle('Worksheet 1');

			$data_kunjungan = $this->rimlaporan->get_lap_data_pasien_pulang_iri_tahun($tgl);

			//ambil semua data pendapatan

			//print_r($data_pasien_keluar_tanggal[0]);exit;
			$row = 1;
			//set header excel
			$sheet->setCellValue('A' . $row, 'No Register');
			$sheet->setCellValue('B' . $row, 'Nama');
			$sheet->setCellValue('C' . $row, 'No RM');
			$sheet->setCellValue('D' . $row, 'Umur');
			$sheet->setCellValue('E' . $row, 'Jenkel');
			$sheet->setCellValue('F' . $row, 'Jaminan');
			$sheet->setCellValue('G' . $row, 'Alamat');
			$sheet->setCellValue('H' . $row, 'Diagnosa');
			$sheet->setCellValue('I' . $row, 'Kode ICD-10');
			$sheet->setCellValue('J' . $row, 'Dokter');

			foreach ($data_kunjungan as $r) {

				$start = new DateTime($r['tgl_lahir']); //start
				$end = new DateTime('today'); //end
				$y = $end->diff($start)->y;

				$row++;
				$sheet->setCellValue('A' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('B' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('C' . $row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('D' . $row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('E' . $row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('F' . $row, $r['carabayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('G' . $row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('H' . $row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('I' . $row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				$sheet->setCellValue('J' . $row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
				// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

				// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

			}

			$filename = 'Kunjungan Data Pasien Rawat Inap Tahun ' . $tgl; //save our workbook as this file name
			$writer = new Xlsx($spreadsheet);
			//ob_clean();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}
	}

	// public function cetak_lap_jml_pasien_pulang_iri_today($tgl_awal='') {
	// 	$spreadsheet = new Spreadsheet();
	// 	$sheet = $spreadsheet->getActiveSheet();

	//   //activate worksheet number 1
	//   $spreadsheet->setActiveSheetIndex(0);
	//   //name the worksheet
	//   $sheet->setTitle('Worksheet 1');

	//   //ambil semua data pendapatan
	//   $data_pasien_keluar_tanggal = $this->rimlaporan->get_jml_pasien_pulang_iri($tgl_awal);
	//   //print_r($data_pasien_keluar_tanggal[0]);exit;
	//   $row = 1;
	//   //set header excel
	//   $sheet->setCellValue('A'.$row, 'Tanggal Keluar');
	//   $sheet->setCellValue('B'.$row, 'Jumlah Pasien');

	// //   $sheet->setCellValue('J'.$row, 'Perolehan');
	// //   $sheet->setCellValue('K'.$row, 'Lokasi');

	// //   $sheet->getStyle('A1')->getFont()->setBold(true);
	// //   $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('B1')->getFont()->setBold(true);
	// //   $sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('C1')->getFont()->setBold(true);
	// //   $sheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('D1')->getFont()->setBold(true);
	// //   $sheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('E1')->getFont()->setBold(true);
	// //   $sheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('F1')->getFont()->setBold(true);
	// //   $sheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('G1')->getFont()->setBold(true);
	// //   $sheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	// //   $sheet->getStyle('H1')->getFont()->setBold(true);
	// //   $sheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('I1')->getFont()->setBold(true);
	// //   $sheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('J1')->getFont()->setBold(true);
	// //   $sheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('K1')->getFont()->setBold(true);
	// //   $sheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('L1')->getFont()->setBold(true);
	// //   $sheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->getStyle('M1')->getFont()->setBold(true);
	// //   $sheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// //   $sheet->setAutoFilter('A1:M1');

	//   foreach ($data_pasien_keluar_tanggal as $r) {

	// 	$no = 1;

	//     $row++;
	// 	$sheet->setCellValue('A'.$row, $r['tgl_keluar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
	//     $sheet->setCellValue('B'.$row, $r['jumlah']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);

	//     // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
	//     // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

	//     // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

	//   }

	//     // //change the font size
	//     // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
	//     // //make the font become bold
	//     // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	//     // //merge cell A1 until D1
	//     // $this->excel->getActiveSheet()->mergeCells('A1:D1');
	//     // //set aligment to center for that merged cell (A1 to D1)
	//     // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//   //$newDate = date("d-m-Y", strtotime($tgl_awal));
	//   $filename='Laporan Jumlah Kunjungan Pasien Tanggal '.$tgl_awal; //save our workbook as this file name
	// //   header('Content-Type: application/vnd.ms-excel'); //mime type
	// //   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	// //   header('Cache-Control: max-age=0'); //no cache

	//   $writer = new Xlsx($spreadsheet);
	// //   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
	//   header('Content-Type: application/vnd.ms-excel');
	//   header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	//   header('Cache-Control: max-age=0');

	//   $writer->save('php://output');
	// }

	public function cetak_lap_jml_pasien_pulang_iri($tgl_awal = '', $tgl_akhir = '')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_pasien_keluar_tanggal = $this->rimlaporan->get_jml_pasien_pulang_iri($tgl_awal, $tgl_akhir);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		$sheet->setCellValue('A' . $row, 'Tanggal Keluar');
		$sheet->setCellValue('B' . $row, 'Jumlah Pasien');

		//   $sheet->setCellValue('J'.$row, 'Perolehan');
		//   $sheet->setCellValue('K'.$row, 'Lokasi');

		//   $sheet->getStyle('A1')->getFont()->setBold(true);
		//   $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('B1')->getFont()->setBold(true);
		//   $sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('C1')->getFont()->setBold(true);
		//   $sheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('D1')->getFont()->setBold(true);
		//   $sheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('E1')->getFont()->setBold(true);
		//   $sheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('F1')->getFont()->setBold(true);
		//   $sheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('G1')->getFont()->setBold(true);
		//   $sheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//   $sheet->getStyle('H1')->getFont()->setBold(true);
		//   $sheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('I1')->getFont()->setBold(true);
		//   $sheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('J1')->getFont()->setBold(true);
		//   $sheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('K1')->getFont()->setBold(true);
		//   $sheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('L1')->getFont()->setBold(true);
		//   $sheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('M1')->getFont()->setBold(true);
		//   $sheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->setAutoFilter('A1:M1');

		foreach ($data_pasien_keluar_tanggal as $r) {

			$no = 1;

			$row++;
			$sheet->setCellValue('A' . $row, $r['tgl_keluar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B' . $row, $r['jumlah']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);

			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Laporan Jumlah Kunjungan Pasien Tanggal ' . $tgl_awal . ' - ' . $tgl_akhir; //save our workbook as this file name
		//   header('Content-Type: application/vnd.ms-excel'); //mime type
		//   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//   header('Cache-Control: max-age=0'); //no cache

		$writer = new Xlsx($spreadsheet);
		//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function pasien_pulang()
	{
		$data['title'] = 'Laporan Pasien Rawat Inap';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		//bikin object buat penanggalan
		$data['controller'] = $this;

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		//  $jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();

		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang($tgl_awal, $tgl_akhir);

			//  $data['tgl_awal_show'] = "";
			//  $data['tgl_akhir_show'] = "";
			//  $data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang($tgl_awal, $tgl_akhir);

			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_laporan_pasien_pulang', $data);
		}

		if ($tipe_input == 'TGL') {

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang($tgl_awal, $tgl_akhir);

			//   $this->load->view('irj/rjvlink');
			$this->load->view('iri/list_laporan_pasien_pulang', $data);
		}
	}

	public function log_user_action()
	{
		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tgl_awal != '' && $tgl_akhir != '') {

			//satuan
			// $data['log_user_antrian'] = $this->rimuser->get_log_user_antrian_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_pasien'] = $this->rimuser->get_log_user_pasien_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan_temp'] = $this->rimuser->get_log_user_tindakan_temp_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan'] = $this->rimuser->get_log_user_tindakan_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_mutasi'] = $this->rimuser->get_log_user_mutasi_by_date($tgl_awal,$tgl_akhir);

			//semua
			$data['log_user_tindakan'] = $this->rimuser->get_log_user_all($tgl_awal, $tgl_akhir);
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
		}

		$this->load->view('iri/rivlink');
		// $this->load->view('iri/list_laporan_harian',$data);
		$this->load->view('iri/list_log_user', $data);
	}


	public function pendapatan_mr()
	{
		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		//bikin object buat penanggalan
		$data['controller'] = $this;

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$user_biling = $this->input->post('user_biling');

		$data['list_user'] = $this->rimuser->get_all_user();
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $tgl_indo = new Tglindo();
			$data['bulan_show'] = substr($tgl_awal, 6, 2);
			$data['tahun_show'] = substr($tgl_awal, 0, 4);
			$data['tanggal_show'] = substr($tgl_awal, 8, 2);
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);

			$tgl_awal_gabung = $tgl_awal . " 00:00";
			$tgl_akhir_gabung = $tgl_akhir . " 23:59";

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);

			// $bulan_show = $tgl_indo->bulan(substr($tgl_awal_gabung,6,2));
			$bulan_show = substr($tgl_awal_gabung, 6, 2);
			$tahun_show = substr($tgl_awal_gabung, 0, 4);
			$tanggal_show = substr($tgl_awal_gabung, 8, 2);
			$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_awal;

			$bulan_show = substr($tgl_akhir_gabung, 6, 2);
			$tahun_show = substr($tgl_akhir_gabung, 0, 4);
			$tanggal_show = substr($tgl_akhir_gabung, 8, 2);
			$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_akhir;

			$data['tgl_awal_show'] = "";
			$data['tgl_akhir_show'] = "";
			$data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			// $this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_mr', $data);
		}

		if ($tipe_input == 'TGL') {
			// $tgl_indo = new Tglindo();
			$data['bulan_show'] = substr($tgl_awal, 6, 2);
			$data['tahun_show'] = substr($tgl_awal, 0, 4);
			$data['tanggal_show'] = substr($tgl_awal, 8, 2);


			$tgl_awal_gabung = $tgl_awal . " " . $jam_awal;
			$tgl_akhir_gabung = $tgl_akhir . " " . $jam_akhir;

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;

			$bulan_show = substr($tgl_awal, 6, 2);
			$tahun_show = substr($tgl_awal, 0, 4);
			$tanggal_show = substr($tgl_awal, 8, 2);
			$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_awal;

			$bulan_show = substr($tgl_akhir, 6, 2);
			$tahun_show = substr($tgl_akhir, 0, 4);
			$tanggal_show = substr($tgl_akhir, 8, 2);
			$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_akhir;

			$data['tgl_awal_show'] = date('d F Y', strtotime($tgl_awal)) . " - " . $jam_awal; //$tgl_awal_lengkap;
			$data['tgl_akhir_show'] = date('d F Y', strtotime($tgl_akhir)) . " - " . $jam_akhir; //$tgl_akhir_lengkap;
			$data['user_show'] = $user_biling;

			$data['tipe_input'] = $tipe_input;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_mr', $data);
		}
	}

	public function pendapatan()
	{

		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		//bikin object buat penanggalan
		$data['controller'] = $this;


		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$user_biling = $this->input->post('user_biling');

		$data['list_user'] = $this->rimuser->get_all_user();

		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if ($tipe_input == '') {
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $tgl_indo = new Tglindo();
			// $data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['bulan_show'] = substr($tgl_awal, 6, 2);
			$data['tahun_show'] = substr($tgl_awal, 0, 4);
			$data['tanggal_show'] = substr($tgl_awal, 8, 2);
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);

			// $tgl_awal_gabung = $tgl_awal." 00:00";
			// $tgl_akhir_gabung = $tgl_akhir." 23:59";
			$tgl_awal_gabung = $tgl_awal;
			$tgl_akhir_gabung = $tgl_akhir;

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggalold($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_lab_luar'] = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_rad_luar'] = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_obat_luar'] = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);


			$bulan_show = substr($tgl_awal_gabung, 6, 2);
			$tahun_show = substr($tgl_awal_gabung, 0, 4);
			$tanggal_show = substr($tgl_awal_gabung, 8, 2);
			$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_awal;


			$bulan_show = substr($tgl_akhir_gabung, 6, 2);
			$tahun_show = substr($tgl_akhir_gabung, 0, 4);
			$tanggal_show = substr($tgl_akhir_gabung, 8, 2);
			$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_akhir;
			$tgl_akhir_lengkap = $tanggal_show . "  " . $tahun_show . " - " . $jam_akhir;

			$data['tgl_awal_show'] = "";
			$data['tgl_akhir_show'] = "";
			$data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan', $data);
		}

		if ($tipe_input == 'TGL') {
			// $tgl_indo = new Tglindo();
			$data['bulan_show'] = substr($tgl_awal, 6, 2);
			$data['tahun_show'] = substr($tgl_awal, 0, 4);
			$data['tanggal_show'] = substr($tgl_awal, 8, 2);


			$tgl_awal_gabung = $tgl_awal . " " . $jam_awal;
			$tgl_akhir_gabung = $tgl_akhir . " " . $jam_akhir;

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggalold($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_lab_luar'] = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_rad_luar'] = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);
			$data['list_pasien_obat_luar'] = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal_gabung, $tgl_akhir_gabung, $user_biling);

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;

			$bulan_show = substr($tgl_awal, 6, 2);
			$tahun_show = substr($tgl_awal, 0, 4);
			$tanggal_show = substr($tgl_awal, 8, 2);
			$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_awal;

			$bulan_show = substr($tgl_akhir, 6, 2);
			$tahun_show = substr($tgl_akhir, 0, 4);
			$tanggal_show = substr($tgl_akhir, 8, 2);
			$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_akhir;

			$data['tgl_awal_show'] = date('d F Y', strtotime($tgl_awal)) . " - " . $jam_awal; //$tgl_awal_lengkap;
			$data['tgl_akhir_show'] = date('d F Y', strtotime($tgl_akhir)) . " - " . $jam_akhir; //$tgl_akhir_lengkap;
			$data['user_show'] = $user_biling;

			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			// $this->load->view('iri/rivlink');

			$this->load->view('iri/list_pendapatan', $data);
		}

		if ($tipe_input == 'BLN') {
			// $tgl_indo = new Tglindo();
			$data['bulan_show'] = substr($bulan, 6, 2);
			$data['tahun_show'] = substr($bulan, 0, 4);

			$data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			// $this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_bulanan', $data);
		}

		if ($tipe_input == 'THN') {
			$data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_tahun($tahun);
		}
	}

	public function cetak_laporan_bln($bulan = '')
	{

		$data_keuangan_bulanan = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
		$logo = $this->config->item('logo_url');

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '<table style="padding:4px;" border="0">
		<tr><td><p align="center"><img src="asset/images/logos/"' . $this->config->item('logo_url') . '" alt="img" height="42" ></p></td></tr></table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Keuangan Rawat Inap Bulan ' . $bulan . '</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>' . $this->config->item('namars') . '</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten . '
		<table >
			<tr>
				<th>Tanggal</th>
				<th>Jumlah Pendapatan</th>
				<th>Jumlah Diskon</th>
				<th>Jumlah Pendapatan Total</th>
				<th>Jumlah Pendapatan Tunai</th>
				<th>Jumlah Diskon Tunai</th>
				<th>Jumlah Tunai Total</th>
				<th>Jumlah Pendapatan Kredit</th>
				<th>Jumlah Diskon Kredit</th>
				<th>Jumlah Kredit Total</th>
			</tr> ';

		$total = 0;
		$total_diskon = 0;
		$total_tunai = 0;
		$total_diskon_tunai = 0;
		$total_kredit = 0;
		$total_diskon_kredit = 0;
		$tgl_indo = new Tglindo();
		foreach ($data_keuangan_bulanan as $r) {

			$bulan_show = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tahun_show = substr($r['tgl_keluar'], 0, 4);
			$tanggal_show = substr($r['tgl_keluar'], 8, 2);
			$tgl_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			$total = $total + $r['vtot_per_tgl'];
			$total_diskon = $total_diskon + $r['vtot_diskon_per_tgl'];
			$total_tunai = $total_tunai + $r['vtot_tunai_per_tgl'];
			$total_diskon_tunai = $total_diskon_tunai + $r['vtot_diskon_tunai_per_tgl'];
			$total_kredit = $total_kredit + $r['vtot_kredit_per_tgl'];
			$total_diskon_kredit = $total_diskon_kredit + $r['vtot_diskon_kredit_per_tgl'];
			$konten = $konten . '	
		  	<tr>
		  		<td>' . date("j F Y", strtotime($r['tgl_keluar'])) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_per_tgl'] + $r['vtot_diskon_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_diskon_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_tunai_per_tgl'] + $r['vtot_diskon_tunai_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_diskon_tunai_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_tunai_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_kredit_per_tgl'] + $r['vtot_diskon_kredit_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_diskon_kredit_per_tgl'], 0) . '</td>
		  		<td align="right">Rp. ' . number_format($r['vtot_kredit_per_tgl'], 0) . '</td>

		  	</tr> ';
		}
		$konten = $konten . '
		  	<tr>
				<td align="right">Total Pembayaran</td>
				<td align="right">Rp. ' . number_format($total + $total_diskon, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_diskon, 0) . '</td>
				<td align="right">Rp. ' . number_format($total, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_tunai + $total_diskon_tunai, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_diskon_tunai, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_tunai, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_kredit + $total_diskon_kredit, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_diskon_kredit, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_kredit, 0) . '</td>
			</tr>
		</table>
		';


		$file_name = "Laporan_Keuangan_Bln_.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}

	public function cetak_laporan_harian($tgl_awal = '')
	{

		$data_pasien_keluar_tanggal = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '<table style="padding:4px;" border="0">
						<tr>
							<td>
								<p align="center">
									<img src="asset/images/logos/"' . $this->config->item('logo_url') . '"" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Keuangan Rawat Inap Tanggal ' . $tgl_awal . '</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>' . $this->config->item('namars') . '</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten . '
		<table >
		<tr>
			<th>Tanggal</th>
			<th>No Registrasi</th>
			<th>Nama Pasien</th>
			<th>Jenis Pembayaran</th>
			<th>Sub Total</th>
			<th>Diskon</th>
			<th>Total Bayar</th>
		</tr>
		';
		$total = 0;
		$total_diskon = 0;
		$tgl_indo = new Tglindo();

		foreach ($data_pasien_keluar_tanggal as $r) {
			$bulan_show = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tahun_show = substr($r['tgl_keluar'], 0, 4);
			$tanggal_show = substr($r['tgl_keluar'], 8, 2);
			$tgl_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			$total = $total + $r['vtot'];
			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;
			$total_disp_bayar_dan_diskon = number_format($r['vtot'] + $diskon, 0);
			if ($r['jenis_bayar'] == "TUNAI") {
				$total_bayar_tunai = $total_bayar_tunai + $r['vtot'];
				$total_diskon_tunai = $total_diskon_tunai + $r['diskon'];
			} else {
				$total_bayar_kredit = $total_bayar_kredit + $r['vtot'];
				$total_diskon_kredit = $total_diskon_kredit + $r['diskon'];
			}
			$konten = $konten . '
	  	<tr>
	  		<td>' . $tgl_lengkap . '</td>
	  		<td>' . $r['no_ipd'] . '</td>
	  		<td>' . $r['nama'] . '</td>
	  		<td>' . $r['jenis_bayar'] . '</td>
	  		<td align="right">Rp. ' . $total_disp_bayar_dan_diskon . ' </td>
	  		<td align="right">Rp. ' . number_format($diskon, 0) . '</td>
	  		<td align="right">Rp. ' . number_format($r['vtot'], 0) . '</td>
	  	</tr>
		';
		}
		$total_disp_all_bayar_dan_diskon = number_format($total + $total_diskon, 0);
		$total_disp_all_bayar_dan_diskon_tunai = number_format($total_bayar_tunai + $total_diskon_tunai, 0);
		$total_disp_all_bayar_dan_diskon_kredit = number_format($total_bayar_kredit + $total_diskon_kredit, 0);
		$konten = $konten . '
		  	<tr>
				<td colspan="4" align="right">Total Pembayaran</td>
				<td align="right">Rp. ' . $total_disp_all_bayar_dan_diskon . '</td>
				<td align="right">Rp. ' . number_format($total_diskon, 0) . '</td>
				<td align="right">Rp. ' . number_format($total, 0) . '</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Tunai</td>
				<td align="right">Rp. ' . $total_disp_all_bayar_dan_diskon_tunai . '</td>
				<td align="right">Rp. ' . number_format($total_diskon_tunai, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_bayar_tunai, 0) . '</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Kredit</td>
				<td align="right">Rp. ' . $total_disp_all_bayar_dan_diskon_kredit . '</td>
				<td align="right">Rp. ' . number_format($total_diskon_kredit, 0) . '</td>
				<td align="right">Rp. ' . number_format($total_bayar_kredit, 0) . '</td>
			</tr>
		</table>
		';


		$file_name = "Laporan_Keuangan_Harian_.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}

	//keperluan tanggal
	public function obj_tanggal()
	{
		$tgl_indo = new Tglindo();
		return $tgl_indo;
	}

	public function cetak_laporan_harian_excel($tgl_awal = '', $tgl_akhir = "", $user = "")
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		$tgl_awal = urldecode($tgl_awal);
		$tgl_akhir = urldecode($tgl_akhir);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		//   $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian.xls");
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		//activate worksheet number 1
		//   $excel->setActiveSheetIndex(0);
		//name the worksheet
		//   $excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$list_keluar_masuk = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal, $tgl_akhir, $user);
		$list_keluar_ird = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal, $tgl_akhir, $user);
		$list_keluar_irj = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggalold($tgl_awal, $tgl_akhir, $user);
		$list_pasien_lab_luar = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal, $tgl_akhir, $user);
		$list_pasien_rad_luar = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal, $tgl_akhir, $user);
		$list_pasien_obat_luar = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal, $tgl_akhir, $user);

		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 5;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		// $tgl_indo = new Tglindo();

		$bulan_show = substr($tgl_awal, 6, 2);
		$tahun_show = substr($tgl_awal, 0, 4);
		$tanggal_show = substr($tgl_awal, 8, 2);
		$jam_show = substr($tgl_awal, 11, 5);
		$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_show;

		$bulan_show = substr($tgl_akhir, 6, 2);
		$tahun_show = substr($tgl_akhir, 0, 4);
		$tanggal_show = substr($tgl_akhir, 8, 2);
		$jam_show = substr($tgl_akhir, 11, 5);
		$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_show;


		$sheet->setCellValue('A1', "Laporan Pendapatan Kasir : " . $user, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('A2', "Tanggal : " . date('d F Y', strtotime($tgl_awal)) . " " . date('H:i', strtotime($tgl_awal)) . " - " . date('d F Y', strtotime($tgl_akhir)) . " " . date('H:i', strtotime($tgl_akhir)), PHPExcel_Cell_DataType::TYPE_STRING);

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


		$sheet->setAutoFilter('A5:J5');
		$total = 0;
		$total_diskon = 0;
		$total_bayar_tunai = 0;
		$total_dibayar_kartu_kredit = 0;
		$total_charge_kartu_kredit = 0;

		//RAWAT INAP
		foreach ($list_keluar_masuk as $r) {
			$total = $total + $r['vtot'] + $r['diskon'];
			$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			$row++;
			$sheet->setCellValue('A' . $row, $r['tgl_cetak_kw'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_ipd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, $r['jenis_bayar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot'] + $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['tunai'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, $r['nilai_kkkd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, $r['nilai_kkkd'] * $r['persen_kk'] / 100, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//LAB
		foreach ($list_pasien_lab_luar as $r) {
			$total = $total + $r['vtot_lab'];
			$total_bayar_tunai = $total_bayar_tunai + $r['vtot_lab'] - $r['diskon'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			$row++;
			$sheet->setCellValue('A' . $row, $r['xupdate'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['Nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, "TUNAI", PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot_lab'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot_lab'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['vtot_lab'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//RAD
		foreach ($list_pasien_rad_luar as $r) {
			$total = $total + $r['vtot_rad'];
			$total_bayar_tunai = $total_bayar_tunai + $r['vtot_rad'] - $r['diskon'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			$row++;
			$sheet->setCellValue('A' . $row, $r['xupdate'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['Nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, "TUNAI", PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot_rad'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot_rad'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['vtot_rad'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//OBAT
		foreach ($list_pasien_obat_luar as $r) {
			$total = $total + $r['vtot_obat'] + $r['diskon'];
			$total_bayar_tunai = $total_bayar_tunai + $r['vtot_obat'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			$row++;
			$sheet->setCellValue('A' . $row, $r['xupdate'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['Nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, "TUNAI", PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot_obat']  + $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot_obat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['vtot_obat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, 0, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//RAWAT DARURAT
		foreach ($list_keluar_ird as $r) {
			$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'];
			$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nila_kkkd'];
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nila_kkkd'] * $r['persen_kk'] / 100);

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;


			if ($r['pasien_bayar'] == 1) {
				$jenis_bayar =  "TUNAI";
			} else {
				$jenis_bayar =  "KREDIT";
			}

			$row++;
			$sheet->setCellValue('A' . $row, $r['tgl_cetak_kw'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, $jenis_bayar, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['tunai'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, $r['nila_kkkd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, $r['nila_kkkd'] * $r['persen_kk'] / 100, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//RAWAT JALAN
		foreach ($list_keluar_irj as $r) {
			$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] + $r['vtot_fisio'] + $r['vtot_ok'];
			$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
			//+$r['vtot_lab_lunas']+$r['vtot_pa_lunas']+$r['vtot_obat_lunas']+$r['vtot_fisio_lunas'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			if ($r['pasien_bayar'] == 1) {
				$jenis_bayar =  "TUNAI";
			} else {
				$jenis_bayar =  "KREDIT";
			}

			$row++;
			$sheet->setCellValue('A' . $row, date('d-m-Y H:i', strtotime($r['tgl_cetak_kw'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('D' . $row, $jenis_bayar, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] + $r['vtot_fisio'] + $r['vtot_ok'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('F' . $row, $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('G' . $row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] + $r['vtot_fisio'] + $r['vtot_ok'] - $diskon, PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('H' . $row, $r['tunai'], PHPExcel_Cell_DataType::TYPE_STRING);
			//+$r['vtot_lab_lunas']+$r['vtot_pa_lunas']+$r['vtot_obat_lunas']+$r['vtot_fisio_lunas'],PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('I' . $row, $r['nilai_kkkd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('J' . $row, $r['nilai_kkkd'] * $r['persen_kk'] / 100, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		$row++;
		$sheet->setCellValue('D' . $row, "Total Pembayaran", PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('E' . $row, $total, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('F' . $row, $total_diskon, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('G' . $row, $total - $total_diskon, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('H' . $row, $total_bayar_tunai, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('I' . $row, $total_dibayar_kartu_kredit, PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue('J' . $row, $total_charge_kartu_kredit, PHPExcel_Cell_DataType::TYPE_STRING);

		// //change the font size
		// $this->sheet->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->sheet->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->sheet->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Pendapatan_Tanggal_' . $newDate; //save our workbook as this file name

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan Berdasarkan Poli Dan Jaminan';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		//   header('Content-Type: application/vnd.ms-excel'); //mime type
		//   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//   header('Cache-Control: max-age=0'); //no cache

		//   //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//   //if you want to save it as .XLSX Excel 2007 format
		//   $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
		//   //force user to download the Excel file without writing it to server's HD
		//   $objWriter->save('php://output');
	}

	public function cetak_laporan_harian_mr_excel($tgl_awal = '', $tgl_akhir = "", $user = "")
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		$tgl_awal = urldecode($tgl_awal);
		$tgl_akhir = urldecode($tgl_akhir);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$list_keluar_masuk = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal, $tgl_akhir, $user);
		$list_keluar_irj = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal, $tgl_akhir, $user);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 5;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$tgl_indo = new Tglindo();

		$bulan_show = $tgl_indo->bulan(substr($tgl_awal, 6, 2));
		$tahun_show = substr($tgl_awal, 0, 4);
		$tanggal_show = substr($tgl_awal, 8, 2);
		$jam_show = substr($tgl_awal, 11, 5);
		$tgl_awal_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_show;

		$bulan_show = $tgl_indo->bulan(substr($tgl_akhir, 6, 2));
		$tahun_show = substr($tgl_akhir, 0, 4);
		$tanggal_show = substr($tgl_akhir, 8, 2);
		$jam_show = substr($tgl_akhir, 11, 5);
		$tgl_akhir_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show . " - " . $jam_show;


		$excel->getActiveSheet()->setCellValue('A1', "Laporan Pendapatan Kasir : " . $user, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('A2', "Tanggal : " . date('d F Y', strtotime($tgl_awal)) . " - " . date('d F Y', strtotime($tgl_akhir)), PHPExcel_Cell_DataType::TYPE_STRING);

		$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		/*$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/


		$excel->getActiveSheet()->setAutoFilter('A5:J5');
		$total = 0;
		$total_diskon = 0;
		$total_bayar_tunai = 0;
		$total_dibayar_kartu_kredit = 0;
		$total_charge_kartu_kredit = 0;

		//RAWAT INAP
		foreach ($list_keluar_masuk as $r) {
			$total = $total + $r['vtot'] + $r['diskon'];
			$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['tgl_cetak_kw'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['no_ipd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, 'IRI', PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $r['tunai'], PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//RAWAT JALAN
		foreach ($list_keluar_irj as $r) {
			$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'];
			$total_bayar_tunai = $total_bayar_tunai + $r['vtotpoli'];
			$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
			$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

			$diskon = $r['diskon'];
			if ($diskon == '' || $diskon == NULL) {
				$diskon = 0;
			}
			$total_diskon = $total_diskon + $diskon;

			if ($r['pasien_bayar'] == 1) {
				$jenis_bayar =  "TUNAI";
			} else {
				$jenis_bayar =  "KREDIT";
			}

			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['tgl_cetak_kw'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['no_register'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, $r['nm_poli'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $r['vtotpoli'], PHPExcel_Cell_DataType::TYPE_STRING);
		}

		$row++;
		$excel->getActiveSheet()->setCellValue('D' . $row, "Total Pembayaran", PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('E' . $row, $total_bayar_tunai, PHPExcel_Cell_DataType::TYPE_STRING);


		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Pendapatan_Tanggal_' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function cetak_laporan_bulanan_excel($bulan = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_bulanan.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_keuangan_bulanan = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



		$excel->getActiveSheet()->setAutoFilter('A1:J1');
		$total = 0;
		$total_diskon = 0;
		$total_tunai = 0;
		$total_diskon_tunai = 0;
		$total_kredit = 0;
		$total_diskon_kredit = 0;
		foreach ($data_keuangan_bulanan as $r) {
			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['tgl_keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['vtot_per_tgl'] + $r['vtot_diskon_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['vtot_diskon_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, $r['vtot_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $r['vtot_tunai_per_tgl'] + $r['vtot_diskon_tunai_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('F' . $row, $r['vtot_diskon_tunai_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('G' . $row, $r['vtot_tunai_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('H' . $row, $r['vtot_kredit_per_tgl'] + $r['vtot_diskon_kredit_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('I' . $row, $r['vtot_diskon_kredit_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('J' . $row, $r['vtot_kredit_per_tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$total = $total + $r['vtot_per_tgl'];
			$total_diskon = $total_diskon + $r['vtot_diskon_per_tgl'];
			$total_tunai = $total_tunai + $r['vtot_tunai_per_tgl'];
			$total_diskon_tunai = $total_diskon_tunai + $r['vtot_diskon_tunai_per_tgl'];
			$total_kredit = $total_kredit + $r['vtot_kredit_per_tgl'];
			$total_diskon_kredit = $total_diskon_kredit + $r['vtot_diskon_kredit_per_tgl'];
		}
		$row++;
		$excel->getActiveSheet()->setCellValue('A' . $row, "Total Pembayaran", PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('B' . $row, $total + $total_diskon, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('C' . $row, $total_diskon, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('D' . $row, $total, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('E' . $row, $total_tunai + $total_diskon_tunai, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('F' . $row, $total_diskon_tunai, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('G' . $row, $total_tunai, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('H' . $row, $total_kredit + $total_diskon_kredit, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('I' . $row, $total_diskon_kredit, PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->getActiveSheet()->setCellValue('J' . $row, $total_kredit, PHPExcel_Cell_DataType::TYPE_STRING);


		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("m-Y", strtotime($bulan));
		$filename = 'Pendapatan_Bulan' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function cetak_laporan_kunjungan_harian($tgl_awal = '')
	{

		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = "
		<table style=\"padding:4px;\" border=\"0\">
			<tr>
				<td>
					<p align=\"center\">
						<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\" >
					</p>
				</td>
			</tr>
		</table>
					<hr><br/><br/>
		<table>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>Laporan Kunjungan Rawat Inap Tanggal " . $tgl_awal . "</b></p></td>
			</tr>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>" . $this->config->item('namars') . "</b></p></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
			<br/>
			<hr/>";
		$konten = $konten . "
		<table border=\"1\" style=\"padding:2px\">
		<tr>
			<td>Tanggal</td>
			<td>No Medrec</td>
			<td>No Register</td>
			<td>Nama</td>
			<td>Diagnosa Utama</td>
			<td>Jenis Kelamin</td>
			<td>Alamat</td>
			<td>Status</td>
			<td>Penjamin</td>
			<td>Ruangan</td>
			<td>Asal Poli</td>
			<td>kesatuan</td>
			<td>Petugas</td>

		</tr>
		";
		$total = 0;
		$total_diskon = 0;
		$tgl_indo = new Tglindo();

		foreach ($data_pasien_keluar_tanggal as $r) {
			$bulan_show = $tgl_indo->bulan(substr($r['tgl'], 6, 2));
			$tahun_show = substr($r['tgl'], 0, 4);
			$tanggal_show = substr($r['tgl'], 8, 2);
			$tgl_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			$konten = $konten . '
	  	<tr>
	  		<td>' . $tgl_lengkap . '</td>
	  		<td>' . $r['no_cm'] . '</td>
	  		<td>' . $r['no_ipd'] . '</td>
	  		<td>' . $r['nama'] . '</td>
	  		<td>' . $r['id_icd'] . ' - ' . $r['nm_diagnosa'] . '</td>
	  		<td>' . $r['sex'] . '</td>
	  		<td>' . $r['alamat'] . '</td>
	  		<td>' . $r['tipe_masuk'] . '</td>
	  		<td>' . $r['nmkontraktor'] . '</td>
			<td>' . $r['nmruang'] . '</td>
			<td>' . $r['id_poli'] . " - " . $r['nm_poli'] . '</td>
			<td>' . $r['kst_nama'] . " | " . $r['kst2_nama'] . " | " . $r['kst3_nama'] . " | " . $r['pangkat'] . '</td>
			<td>' . $r['xuser'] . '</td>
	  	</tr>

		';
		}
		echo $konten;
		$file_name = "Laporan_Kunjungan_Harian_" . $tgl_awal . ".pdf";
		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/kunj/' . $file_name, 'FI');
	}

	public function cetak_laporan_kunjungan_harian_excel_old($tgl_awal = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_kunjungan_harian.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->setAutoFilter('A1:M1');

		foreach ($data_pasien_keluar_tanggal as $r) {


			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['tgl'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['no_cm'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['no_ipd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $r['id_icd'] . " - " . $r['nm_diagnosa'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('F' . $row, $r['sex'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('G' . $row, $r['alamat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('H' . $row, $r['tipe_masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('I' . $row, $r['nmkontraktor'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('J' . $row, $r['nmruang'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('K' . $row, $r['id_poli'] . " - " . $r['nm_poli'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('L' . $row, $r['kst_nama'] . " | " . $r['kst2_nama'] . " | " . $r['kst3_nama'] . " | " . $r['pangkat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('M' . $row, $r['xuser'], PHPExcel_Cell_DataType::TYPE_STRING);
		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Kunjungan_Tanggal_' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function excel_lap_pasien_pulang_iri($tgl_awal = '', $tgl_akhir = '')
	{

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_pasien_keluar_tanggal = $this->rimlaporan->get_pasien_pulang($tgl_awal, $tgl_akhir);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		$sheet->setCellValue('A' . $row, 'No Ipd');
		$sheet->setCellValue('B' . $row, 'Nama');
		$sheet->setCellValue('C' . $row, 'No Medrec');
		$sheet->setCellValue('D' . $row, 'Ruang');
		$sheet->setCellValue('E' . $row, 'JK');
		$sheet->setCellValue('F' . $row, 'Tgl Masuk');
		$sheet->setCellValue('G' . $row, 'Tgl Keluar');
		$sheet->setCellValue('H' . $row, 'Lama Rawat');
		$sheet->setCellValue('I' . $row, 'Dokter');
		//   $sheet->setCellValue('J'.$row, 'Perolehan');
		//   $sheet->setCellValue('K'.$row, 'Lokasi');

		//   $sheet->getStyle('A1')->getFont()->setBold(true);
		//   $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('B1')->getFont()->setBold(true);
		//   $sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('C1')->getFont()->setBold(true);
		//   $sheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('D1')->getFont()->setBold(true);
		//   $sheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('E1')->getFont()->setBold(true);
		//   $sheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('F1')->getFont()->setBold(true);
		//   $sheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('G1')->getFont()->setBold(true);
		//   $sheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//   $sheet->getStyle('H1')->getFont()->setBold(true);
		//   $sheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('I1')->getFont()->setBold(true);
		//   $sheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('J1')->getFont()->setBold(true);
		//   $sheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('K1')->getFont()->setBold(true);
		//   $sheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('L1')->getFont()->setBold(true);
		//   $sheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('M1')->getFont()->setBold(true);
		//   $sheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->setAutoFilter('A1:M1');

		foreach ($data_pasien_keluar_tanggal as $r) {

			$start = new DateTime($r['tgl_masuk']); //start
			$end = new DateTime($r['tgl_keluar']); //end

			$diff = $end->diff($start)->format("%a");
			if ($diff == 0) {
				$diff = 1;
			}

			$row++;
			$sheet->setCellValue('A' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C' . $row, $r['no_medrec']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D' . $row, $r['nm_ruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E' . $row, $r['jenkel']/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F' . $row, $r['tgl_masuk']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G' . $row, $r['tgl_keluar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H' . $row, $diff . " Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I' . $row, $r['dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        

		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Kunjungan_Tanggal ' . $tgl_awal . ' - ' . $tgl_akhir; //save our workbook as this file name
		//   header('Content-Type: application/vnd.ms-excel'); //mime type
		//   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//   header('Cache-Control: max-age=0'); //no cache

		$writer = new Xlsx($spreadsheet);
		//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function cetak_laporan_kunjungan_harian_excel($tgl_awal = '')
	{

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		//activate worksheet number 1
		$spreadsheet->setActiveSheetIndex(0);
		//name the worksheet
		$sheet->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		$sheet->setCellValue('A' . $row, 'UPT');
		$sheet->setCellValue('B' . $row, 'Unit');
		$sheet->setCellValue('C' . $row, 'Nama Aset');
		$sheet->setCellValue('D' . $row, 'Merk');
		$sheet->setCellValue('E' . $row, 'No Seri');
		$sheet->setCellValue('F' . $row, 'Kondisi');
		$sheet->setCellValue('G' . $row, 'PIC');
		$sheet->setCellValue('H' . $row, 'No Inventaris');
		$sheet->setCellValue('I' . $row, 'IP Address');
		$sheet->setCellValue('J' . $row, 'Perolehan');
		$sheet->setCellValue('K' . $row, 'Lokasi');

		//   $sheet->getStyle('A1')->getFont()->setBold(true);
		//   $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('B1')->getFont()->setBold(true);
		//   $sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('C1')->getFont()->setBold(true);
		//   $sheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('D1')->getFont()->setBold(true);
		//   $sheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('E1')->getFont()->setBold(true);
		//   $sheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('F1')->getFont()->setBold(true);
		//   $sheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('G1')->getFont()->setBold(true);
		//   $sheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//   $sheet->getStyle('H1')->getFont()->setBold(true);
		//   $sheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('I1')->getFont()->setBold(true);
		//   $sheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('J1')->getFont()->setBold(true);
		//   $sheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('K1')->getFont()->setBold(true);
		//   $sheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('L1')->getFont()->setBold(true);
		//   $sheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->getStyle('M1')->getFont()->setBold(true);
		//   $sheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//   $sheet->setAutoFilter('A1:M1');

		foreach ($data_pasien_keluar_tanggal as $r) {


			$row++;
			$sheet->setCellValue('A' . $row, $r['tgl']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B' . $row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C' . $row, $r['no_ipd']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D' . $row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E' . $row, $r['id_icd']/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F' . $row, $r['sex']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G' . $row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H' . $row, $r['tipe_masuk']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I' . $row, $r['nmkontraktor']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J' . $row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('K' . $row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);

			$sheet->setCellValue('M' . $row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Kunjungan_Tanggal_' . $newDate; //save our workbook as this file name
		//   header('Content-Type: application/vnd.ms-excel'); //mime type
		//   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//   header('Cache-Control: max-age=0'); //no cache

		$writer = new Xlsx($spreadsheet);
		//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		//   $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//   $objWriter->save('php://output');
	}

	public function cetak_laporan_kunjungan_bulanan($tgl_awal = '')
	{

		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_bulan($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = "
		<table style=\"padding:4px;\" border=\"0\">
			<tr>
				<td>
					<p align=\"center\">
						<img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"42\" >
					</p>
				</td>
			</tr>
		</table>
					<hr><br/><br/>
		<table>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>Laporan Kunjungan Rawat Inap Tanggal " . $tgl_awal . "</b></p></td>
			</tr>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>" . $this->config->item('namars') . "</b></p></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
			<br/>
			<hr/>";
		$konten = $konten . '
		<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>Jumlah Masuk</th>
			<th>Jumlah Keluar</th>
		</tr>
		';
		$total = 0;
		$total_diskon = 0;
		$tgl_indo = new Tglindo();

		foreach ($data_pasien_keluar_tanggal as $r) {
			$bulan_show = $tgl_indo->bulan(substr($r['tanggal'], 6, 2));
			$tahun_show = substr($r['tanggal'], 0, 4);
			$tanggal_show = substr($r['tanggal'], 8, 2);
			$tgl_lengkap = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			$jml_masuk = 0;

			if ($r['jml_tgl_masuk'] == null) {
				$jml_masuk = 0;
			} else {
				$jml_masuk =  $r['jml_tgl_masuk'];
			}

			$jml_keluar = 0;
			if ($r['jml_tgl_keluar'] == null) {
				$jml_keluar =  0;
			} else {
				$jml_keluar =  $r['jml_tgl_keluar'];
			}

			$konten = $konten . '
	  	<tr>
	  		<td>' . $tgl_lengkap . '</td>
	  		<td>' . $jml_masuk . '</td>
	  		<td>' . $jml_keluar . '</td>
	  	</tr>
		';
		}

		$file_name = "Laporan_Kunjungan_Bulanan_" . $tgl_awal . ".pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/kunj/' . $file_name, 'FI');
	}

	public function cetak_laporan_kunjungan_bulanan_excel($tgl_awal = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_kunjungan_bulanan.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_bulan($tgl_awal);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



		$excel->getActiveSheet()->setAutoFilter('A1:C1');

		foreach ($data_pasien_keluar_tanggal as $r) {

			if ($r['jml_tgl_masuk'] == null) {
				$jml_masuk = 0;
			} else {
				$jml_masuk =  $r['jml_tgl_masuk'];
			}

			$jml_keluar = 0;
			if ($r['jml_tgl_keluar'] == null) {
				$jml_keluar =  0;
			} else {
				$jml_keluar =  $r['jml_tgl_keluar'];
			}

			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['tanggal'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $jml_masuk, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $jml_keluar, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl_awal));
		$filename = 'Kunjungan_Bulan_' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function cetak_medrec($tgl = '', $type = '')
	{

		if ($type == "BLN") {
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_month($tgl);
		} else {
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_date('', $tgl);
		}
		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '
		<table style="padding:4px;" >
						<tr>
							<td>
								<p align="center">
									<img src="' . base_url() . 'assets/images/logos/' . $this->config->item('logo_url') . '" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Medical Record Rawat Inap ' . $tgl . '</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>' . $this->config->item('namars') . '</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten . '
		<table cellspacing="0" cellpadding="1" border="1" style=\"padding:2px\">
		<thead>
            <tr>
                <th width=\"3%\"><b>No. Register</b></th>
				<th>Nama</th>
				<th>No MedRec</th>
				<th>Ruang</th>
				<th>Usia</th>
				<th>Kls</th>
				<th>Tgl Masuk</th>
				<th>Tgl Keluar</th>
				<th>Lama Rawat</th>
				<th>Hari Perawatan</th>
				<th>Dokter</th>
				<th>Diagnosa</th>
				<th>Icd</th>
				<th>Berat Bayi</th>
				<th>Keterangan</th>
            </tr>
        </thead>';

		foreach ($data_medrec as $r) {

			$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'], 6, 2));
			$tgl_row = substr($r['tgl_masuk'], 8, 2);
			$thn_row = substr($r['tgl_masuk'], 0, 4);
			$tgl_masuk_show = $tgl_row . " " . $bln_row . " " . $thn_row;

			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tgl_row = substr($r['tgl_keluar'], 8, 2);
			$thn_row = substr($r['tgl_keluar'], 0, 4);
			$tgl_keluar_show =  $tgl_row . " " . $bln_row . " " . $thn_row;

			$temp_tgl_awal = strtotime($r['tgl_masuk']);
			$temp_tgl_akhir = strtotime($r['tgl_keluar']);
			$diff = $temp_tgl_akhir - $temp_tgl_awal;
			$diff =  floor($diff / (60 * 60 * 24));
			if ($diff == 0) {
				$diff = 1;
			}

			$hari_perawatan = $diff + 1;
			$konten = $konten . '	
		  	<tr>
		  		<td>' . $r['no_ipd'] . '</td>
		  		<td>' . $r['nama'] . '</td>
		  		<td>' . $r['no_medrec_minto'] . '</td>
		  		<td>' . $r['idrg'] . '</td>
		  		<td>' . $umur . '</td>
		  		<td>' . $r['klsiri'] . '</td>
		  		<td>' . $tgl_masuk_show . '</td>
		  		<td>' . $tgl_keluar_show . '</td>
	  			<td>' . $diff . '</td>
		  		<td>' . $hari_perawatan . '</td>
		  		<td>' . $r['dokter'] . '</td>
		  		<td>' . $r['nm_diagnosa'] . ',' . $r['list_diagnosa_tambahan'] . '</td>
		  		<td>' . $r['diagnosa1'] . ',' . $r['list_id_diagnosa_tambahan'] . ' </td>
		  		<td>' . $r['brtlahir'] . '</td>
		  		<td>' . $r['jenis_bayar'] . '</td>
		  	</tr> ';
		}
		$konten = $konten . '
		</table>
		';

		// print_r($konten);die();
		$file_name = "Laporan_MedRec.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->setPrintHeader(false); //To remove first line on the top
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
		$obj_pdf->Output(FCPATH . '/download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}


	public function cetak_medrec_excel($tgl = '', $type = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_medrec.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		if ($type == "BLN") {
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_month($tgl);
		} else {
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_date('', $tgl);
		}
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



		$excel->getActiveSheet()->setAutoFilter('A1:R1');

		foreach ($data_medrec as $r) {

			$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'], 6, 2));
			$tgl_row = substr($r['tgl_masuk'], 8, 2);
			$thn_row = substr($r['tgl_masuk'], 0, 4);
			$tgl_masuk_show = $tgl_row . " " . $bln_row . " " . $thn_row;

			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tgl_row = substr($r['tgl_keluar'], 8, 2);
			$thn_row = substr($r['tgl_keluar'], 0, 4);
			$tgl_keluar_show =  $tgl_row . " " . $bln_row . " " . $thn_row;

			$temp_tgl_awal = strtotime($r['tgl_masuk']);
			$temp_tgl_akhir = strtotime($r['tgl_keluar']);
			$diff = $temp_tgl_akhir - $temp_tgl_awal;
			$diff =  floor($diff / (60 * 60 * 24));
			if ($diff == 0) {
				$diff = 1;
			}

			$hari_perawatan = $diff + 1;

			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['no_ipd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['no_medrec_minto'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, $r['nmruang'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $umur, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('F' . $row, $r['sex'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('G' . $row, $r['klsiri'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('H' . $row, $tgl_masuk_show, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('I' . $row, $tgl_keluar_show, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('J' . $row, $diff, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('K' . $row, $hari_perawatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('L' . $row, $r['dokter'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('M' . $row, $r['nm_diagnosa'] . ',' . $r['list_diagnosa_tambahan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('N' . $row, $r['diagnosa1'] . ',' . $r['list_id_diagnosa_tambahan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('O' . $row, $r['brtlahir'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('P' . $row, $r['nmkontraktor'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('Q' . $row, $r['kesatuan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('R' . $row, $r['pangkat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('S' . $row, $r['jenis_bayar'], PHPExcel_Cell_DataType::TYPE_STRING);
		}




		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl));
		$filename = 'Medical_Record_' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function excel_list_pasien_pulang($week_awal, $week_akhir)
	{
		// var_dump($tgl);die();

		// added for karu
		$login_data = $this->load->get_var("user_info");

		$ruangan = $this->rimpasien->load_ruangan_user($login_data->userid);
		$list_ruang = '';
		foreach ($ruangan as $key => $ruang) {
			$list_ruang .= '\'' . $ruang->idrg . '\',';
			if ($key === array_key_last($ruangan)) {
				$list_ruang .= '\'' . $ruang->idrg . '\'';
			}
		}

		if ($login_data->userid == 1) {
			$admin = 1;
		} else {
			$admin = 0;
		}

		// var_dump($list_ruang);die();
		$data = $this->rimpasien->get_medrec_range_date($week_awal, $week_akhir, $list_ruang, $admin)->result();
		// var_dump($data['list_medrec']);die();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'No Medrec');
		$sheet->setCellValue('E1', 'Ruang');
		$sheet->setCellValue('F1', 'JK');
		$sheet->setCellValue('G1', 'Tgl Masuk');
		$sheet->setCellValue('H1', 'Tgl Keluar');
		$sheet->setCellValue('I1', 'Dokter');




		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			//var_dump($row['tgl_masuk']);die();
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_ipd);
			$sheet->setCellValue('C' . $x, $row->nama);
			$sheet->setCellValue('D' . $x, $row->no_medrec_minto);
			$sheet->setCellValue('E' . $x, $row->nm_ruang);
			$sheet->setCellValue('F' . $x, $row->sex);
			$sheet->setCellValue('G' . $x, $row->tgl_masuk);
			$sheet->setCellValue('H' . $x, $row->tgl_keluar);
			$sheet->setCellValue('I' . $x, $row->dokter);



			$x++;
		}




		$writer = new Xlsx($spreadsheet);
		$filename = 'pasien pulang IRI';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}


	//laporan rawat jalan

	public function excel_lapkunj()
	{
		$tampil_per = $this->input->get("tampil_per");
		$id_poli = $this->input->get("id_poli");
		$var1 = $this->input->get("var1");
		$id_poli = strtoupper($id_poli);
		$tampil_per = strtoupper($tampil_per);
		require_once(APPPATH . 'third_party/PHPExcel.php');
		$title = 'Laporan Kunjungan';
		$tgl_indo = new Tglindo();

		//get nama poli
		if ($id_poli != "SEMUA") {
			$nm_poli = $this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}

		$data_rs = $this->Rjmkwitansi->getdata_rs('10000')->result();
		foreach ($data_rs as $row) {
			$namars = $row->namars;
			$kota_kab = $row->kota;
		}

		////////////////////////////////////////////////////////////EXCEL 

		$objPHPExcel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_laporan_dokter_excel.xls");

		//activate worksheet number 1
		$objPHPExcel->setActiveSheetIndex(0);
		//name the worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Worksheet 1');

		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);

		$no = 1;

		if ($tampil_per == "TGL") {

			$tgl = $var1;

			//nama file----------------------------------
			$date_title = "Tanggal";

			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date = substr($tgl1, 0, 2) . ' ' . $tgl_indo->bulan(substr($tgl1, 3, 2)) . ' ' . substr($tgl1, 6, 4);
			//-------------------------------------------

			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : ' . $date);

			if ($id_poli == "SEMUA") {
				$file_name = "KUNJ_POLI_$tgl1.xlsx";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_poli_harian($tgl)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Diagnosa Utama');

				$rowCount = 4;

				foreach ($poli as $row1) {

					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli = array_column($array, 'id_poli');

					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);

						$setpoli = 0;

						$i = 1;
						foreach ($data_laporan_kunj as $row2) {

							if ($row2->id_poli == $row1->id_poli) {

								$rowCount++;
								$i++;
								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowCount, $row2->no_medrec, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row2->diagnosa);
							}
						}

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Total')
							->getStyle('E' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $i - 1)
							->getStyle('F' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				}
			} else {  //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : ' . $nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Diagnosa Utama');
				$rowCount = 5;

				$file_name = "KUNJ_POLI_" . $id_poli . "_$tgl1.xlsx";
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_harian($tgl, $id_poli)->result();

				$i = 1;
				foreach ($data_laporan_kunj as $row2) {
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowCount, $row2->no_medrec, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->diagnosa);
				}

				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Total')
					->getStyle('D' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $i - 1)
					->getStyle('E' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		} else if ($tampil_per == "BLN") {

			$bulan = $var1;
			$tgl_indo = new Tglindo();

			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan, 5, 2)) . " " . date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date = $bulan1;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : ' . $date);

			if ($id_poli == "SEMUA") {

				$file_name = "KUNJ_POLI_$bulan1.xls";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_poli_bulanan(substr($bulan, 5, 2))->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount = 4;

				foreach ($poli as $row1) {

					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli = array_column($array, 'id_poli');

					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);
						$setpoli = 0;

						$i = 1;
						$vtot = 0;
						foreach ($data_laporan_kunj as $row2) {
							if ($row2->id_poli == $row1->id_poli) {
								$i++;
								$rowCount++;
								$vtot = $vtot + $row2->jumlah_kunj;

								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->tgl_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_kunj);
							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total')
							->getStyle('C' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtot)
							->getStyle('D' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				}
			} else {

				$file_name = "KUNJ_POLI_" . $id_poli . "_$bulan1.xls";
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_bulanan(substr($bulan, 5, 2), $id_poli)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : ' . $nm_poli);

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount = 5;

				$i = 1;
				$vtot = 0;
				foreach ($data_laporan_kunj as $row) {
					$vtot = $vtot + $row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->tgl_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->jumlah_kunj)
						->getStyle('C' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total')
					->getStyle('B' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $vtot)
					->getStyle('C' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		} else if ($tampil_per == "THN") {

			$tahun = $var1;

			//nama file----------------------------------
			$date_title = "Tahun";
			$date = $tahun;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : ' . $date);

			if ($id_poli == "SEMUA") {

				$file_name = "KUNJ_POLI_$tahun.xls";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun, $id_poli)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount = 4;

				foreach ($poli as $row1) {

					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli = array_column($array, 'id_poli');

					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);
						$setpoli = 0;
						$i = 1;
						$vtot = 0;
						foreach ($data_laporan_kunj as $row2) {
							if ($row2->id_poli == $row1->id_poli) {
								$vtot = $vtot + $row2->jumlah_kunj;
								$i++;
								$rowCount++;

								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->jumlah_kunj);
							}
						}

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total ')
							->getStyle('C' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $vtot)
							->getStyle('D' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				}
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'

				$file_name = "KUNJ_POLI_" . $id_poli . "_$tahun.xls";
				$data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_tahunan($tahun, $id_poli)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : ' . $nm_poli);

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount = 5;

				$i = 1;
				$vtot = 0;
				foreach ($data_laporan_kunj as $row) {
					$vtot = $vtot + $row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $tgl_indo->bulan($row->bulan_kunj));
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->jumlah_kunj)
						->getStyle('C' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total')
					->getStyle('B' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $vtot)
					->getStyle('C' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		}
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $file_name . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function excel_lapkeu()
	{

		$tampil_per = $this->input->get("tampil_per");
		$id_poli = $this->input->get("id_poli");
		$var1 = $this->input->get("var1");
		$status = $this->input->get("status");
		$cara_bayar = $this->input->get("cara_bayar");

		$id_poli = strtoupper($id_poli);
		$tampil_per = strtoupper($tampil_per);
		$status = strtoupper($status);
		$cara_bayar = strtoupper($cara_bayar);

		require_once(APPPATH . 'third_party/PHPExcel.php');

		$title = 'Laporan Keuangan';
		$tgl_indo = new Tglindo();
		if ($id_poli != "SEMUA") {
			$nm_poli = $this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		$data_rs = $this->Rjmkwitansi->getdata_rs('10000')->result();
		foreach ($data_rs as $row) {
			$namars = $row->namars;
			$kota_kab = $row->kota;
		}

		////////////////////////////////////////////////////////////EXCEL 

		// Create new PHPExcel object  

		$objPHPExcel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_laporan_dokter_excel.xls");

		//activate worksheet number 1
		$objPHPExcel->setActiveSheetIndex(0);
		//name the worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Worksheet 1');

		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);

		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		if ($status == '10') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang dan Dirawat');
		} else if ($status == '1') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang');
		} else if ($status == '0') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Dirawat');
		}
		$no = 1;

		if ($tampil_per == "TGL") {

			$tgl = $var1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date = substr($tgl1, 0, 2) . ' ' . $tgl_indo->bulan(substr($tgl1, 3, 2)) . ' ' . substr($tgl1, 6, 4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : ' . $date);

			if ($id_poli == "SEMUA") {

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');
				if ($status == '10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Tindakan');
				}
				$rowCount = 5;

				$file_name = "KEU_POLI_$tgl1.xlsx";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_poli_harian($tgl, $status)->result();

				foreach ($poli as $row1) {

					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli = array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);

						$setpoli = 0;
						$vtot = 0;
						//$biayadaftar=0;
						foreach ($data_laporan_keu as $row2) {
							if ($row2->id_poli == $row1->id_poli) {

								$rowCount++;

								$vtot += $row2->vtot;
								//$biayadaftar+=$row2->biayadaftar;

								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowCount, $row2->no_medrec, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row2->nama);
								if ($status == '10') {
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, ($row2->status == "1" ? "Pulang" : "Dirawat"));
									/*$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
										->getStyle('G'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									*/
									$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($row2->vtot, 2, ',', '.'))
										->getStyle('G' . $rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								} else {
									/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
										->getStyle('F'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									*/
									$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($row2->vtot, 2, ',', '.'))
										->getStyle('F' . $rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								}
							}
						}

						if ($status == '10') {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Total')
								->getStyle('F' . $rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
							$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($vtot, 2, ',', '.'))
								->getStyle('G' . $rowCount)
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
						} else {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Total')
								->getStyle('E' . $rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
							$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($vtot, 2, ',', '.'))
								->getStyle('F' . $rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						}
					}
				}
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Poliklinik : ' . $nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Nama');
				if ($status == '10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Tindakan');
				}
				$rowCount = 6;

				$file_name = "KEU_POLI_" . $id_poli . "_$tgl1.xlsx";
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_harian($tgl, $id_poli, $status)->result();

				$vtot = 0;
				//$biayadaftar=0;
				foreach ($data_laporan_keu as $row2) {
					$vtot += $row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;

					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowCount, $row2->no_medrec, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row2->nama);
					if ($status == '10') {
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, ($row2->status == "1" ? "Pulang" : "Dirawat"));
						/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($row2->vtot, 2, ',', '.'))
							->getStyle('F' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					} else {
						/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($row2->vtot, 2, ',', '.'))
							->getStyle('E' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				}


				if ($status == '10') {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Total')
						->getStyle('E' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($vtot, 2, ',', '.'))
						->getStyle('F' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('G'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				} else {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Total')
						->getStyle('D' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($vtot, 2, ',', '.'))
						->getStyle('E' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				}
			}
		} else if ($tampil_per == "BLN") {

			$bulan = $var1;

			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan, 5, 2)) . date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date = "$bulan1";
			//-------------------------------------------

			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : ' . $date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : ' . $cara_bayar);


			if ($id_poli == "SEMUA") {

				$file_name = "KEU_POLI_$bulan1.xlsx";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_poli_bulanan(substr($bulan, 5, 2), $status, $cara_bayar)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount = 6;

				foreach ($poli as $row1) {

					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli = array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);
						$setpoli = 0;

						$i = 1;
						$vtot = 0;
						$biayadaftar = 0;
						foreach ($data_laporan_keu as $row2) {
							if ($row2->id_poli == $row1->id_poli) {

								$rowCount++;
								$vtot += $row2->jumlah_vtot;
								$biayadaftar += $row2->jumlah_biayadaftar;


								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row2->tgl_kunj);
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($row2->jumlah_vtot, 2, ',', '.'))
									->getStyle('D' . $rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total')
							->getStyle('C' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($vtot, 2, ',', '.'))
							->getStyle('D' . $rowCount)
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
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'

				$file_name = "KEU_POLI_" . $id_poli . "_$bulan1.xlsx";
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_bulanan(substr($bulan, 5, 2), $id_poli, $status, $cara_bayar)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : ' . $nm_poli);

				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount = 7;

				$i = 1;
				$vtot = 0;
				$biayadaftar = 0;
				foreach ($data_laporan_keu as $row) {
					$vtot += $row->jumlah_vtot;
					$biayadaftar += $row->jumlah_biayadaftar;

					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->tgl_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($row->jumlah_vtot, 2, ',', '.'))
						->getStyle('C' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total')
					->getStyle('B' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($vtot, 2, ',', '.'))
					->getStyle('C' . $rowCount)
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
		} else if ($tampil_per == "THN") {

			$tahun = $var1;

			$date_title = 'Tahun';
			$date = $tahun;

			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : ' . $date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : ' . $cara_bayar);


			if ($id_poli == "SEMUA") {

				$file_name = "KEU_POLI_$tahun.xlsx";
				$poli = $this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount = 6;


				foreach ($poli as $row1) {
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli = array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {

						$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount + 1), $no++);
						$setpoli = 0;

						$i = 1;
						$vtot = 0;
						//$biayadaftar=0;
						foreach ($data_laporan_keu as $row2) {
							if ($row2->id_poli == $row1->id_poli) {

								$rowCount++;
								$vtot += $row2->jumlah_vtot;
								//$biayadaftar+=$row2->jumlah_biayadaftar;


								if ($setpoli == 0) {
									$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row1->nm_poli);
									$setpoli = 1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($row2->jumlah_vtot, 2, ',', '.'))
									->getStyle('D' . $rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total')
							->getStyle('C' . $rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($vtot, 2, ',', '.'))
							->getStyle('D' . $rowCount)
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
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'

				$file_name = "KEU_POLI_" . $id_poli . "_$tahun.xlsx";
				$data_laporan_keu = $this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : ' . $nm_poli);

				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount = 7;

				$i = 1;
				$vtot = 0;
				//$biayadaftar=0;
				foreach ($data_laporan_keu as $row) {
					$vtot += $row->jumlah_vtot;
					//$biayadaftar+=$row->jumlah_biayadaftar;

					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $tgl_indo->bulan($row->bulan_kunj));
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($row->jumlah_vtot, 2, ',', '.'))
						->getStyle('C' . $rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total')
					->getStyle('B' . $rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($vtot, 2, ',', '.'))
					->getStyle('C' . $rowCount)
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

		// header('Content-Disposition: attachment;filename="'.$file_name.'"');  

		// // Rename worksheet (worksheet, not filename)  
		// $objPHPExcel->getActiveSheet()->setTitle('Laporan Keuangan');  

		// // Redirect output to a client’s web browser (Excel2007)  
		// //clean the output buffer  
		// ob_end_clean();  

		// //this is the header given from PHPExcel examples.   
		// //but the output seems somewhat corrupted in some cases.  
		// //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		// //so, we use this header instead.  
		// header('Content-type: application/vnd.ms-excel');  
		// header('Cache-Control: max-age=0');  

		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		// $objWriter->save('php://output');

		// redirect('irj/Rjclaporan/lapkeu','refresh');

		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $file_name . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function cetak_laporan_log_user($tgl_awal = '', $tgl_akhir = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_log_user.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		$data_log_user = $this->rimuser->get_log_user_all($tgl_awal, $tgl_akhir);
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$excel->getActiveSheet()->setAutoFilter('A1:B1');

		foreach ($data_log_user as $r) {


			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['usr'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['jml'], PHPExcel_Cell_DataType::TYPE_STRING);
		}

		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$start_date_format = date("d-m-Y", strtotime($tgl_awal));
		$end_date_format = date("d-m-Y", strtotime($tgl_akhir));
		$filename = 'log_user_rawat_inap_' . $start_date_format . '_.' . $end_date_format . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	//lap pasien keluar
	public function cetak_medrec_keluar($tgl = '', $type = '')
	{

		if ($type == "BLN") {
			$data_medrec = $this->rimpasien->get_discharge_patient_by_month($tgl);
		} else {
			$data_medrec = $this->rimpasien->get_discharge_patient_by_date($tgl);
		}

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '
		<table style="padding:4px;" >
						<tr>
							<td>
								<p align="center">
									<img src="asset/images/logos/"' . $this->config->item('logo_url') . '" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Pasien Keluar Rawat Inap ' . $tgl . '</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>' . $this->config->item('namars') . '</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten . '
		<table >
			<tr>
				<th>No. Register</th>
				<th>Nama</th>
				<th>No MedRec</th>
				<th>Status</th>
				<th>Ruang</th>
				<th>Usia</th>
				<th>Kls</th>
				<th>Tgl Masuk</th>
				<th>Tgl Keluar</th>
				<th>Lama Rawat</th>
				<th>Hari Perawatan</th>
				<th>Dokter</th>
				<th>Diagnosa</th>
				<th>Icd</th>
				<th>Berat Bayi</th>
				<th>Keterangan</th>
			</tr> ';

		foreach ($data_medrec as $r) {

			$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'], 6, 2));
			$tgl_row = substr($r['tgl_masuk'], 8, 2);
			$thn_row = substr($r['tgl_masuk'], 0, 4);
			$tgl_masuk_show = $tgl_row . " " . $bln_row . " " . $thn_row;

			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tgl_row = substr($r['tgl_keluar'], 8, 2);
			$thn_row = substr($r['tgl_keluar'], 0, 4);
			$tgl_keluar_show =  $tgl_row . " " . $bln_row . " " . $thn_row;

			$temp_tgl_awal = strtotime($r['tgl_masuk']);
			$temp_tgl_akhir = strtotime($r['tgl_keluar']);
			$diff = $temp_tgl_akhir - $temp_tgl_awal;
			$diff =  floor($diff / (60 * 60 * 24));
			if ($diff == 0) {
				$diff = 1;
			}

			$hari_perawatan = $diff + 1;
			$konten = $konten . '	
		  	<tr>
		  		<td>' . $r['no_ipd'] . '</td>
		  		<td>' . $r['nama'] . '</td>
		  		<td>' . $r['no_medrec_patria'] . '</td>
		  		<td>' . $r['ket'] . '</td>
		  		<td>' . $r['nmruang'] . '</td>
		  		<td>' . $umur . '</td>
		  		<td>' . $r['klsiri'] . '</td>
		  		<td>' . $tgl_masuk_show . '</td>
		  		<td>' . $tgl_keluar_show . '</td>
	  			<td>' . $diff . '</td>
		  		<td>' . $hari_perawatan . '</td>
		  		<td>' . $r['dokter'] . '</td>
		  		<td>' . $r['nm_diagnosa'] . ',' . $r['list_diagnosa_tambahan'] . '</td>
		  		<td>' . $r['diagnosa1'] . ',' . $r['list_id_diagnosa_tambahan'] . ' </td>
		  		<td>' . $r['brtlahir'] . '</td>
		  		<td>' . $r['jenis_bayar'] . '</td>
		  	</tr> ';
		}
		$konten = $konten . '
		</table>
		';

		//echo $konten;break;
		$file_name = "Laporan_Keluar_IRI.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Laporan Keluar Pasien IRI";
		$obj_pdf->setPrintHeader(false); //To remove first line on the top
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
		$obj_pdf->Output(FCPATH . 'download/inap/laporan/pembayaran/' . $file_name, 'FI');
	}

	public function cetak_medrec_keluar_excel($tgl = '', $type = '')
	{
		require_once(APPPATH . 'third_party/PHPExcel.php');

		set_time_limit(0);

		//load our new PHPExcel library
		//$this->load->library('excel');
		//$this->excel = new PHPExcel();

		$excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_medrec_keluar.xls");

		//activate worksheet number 1
		$excel->setActiveSheetIndex(0);
		//name the worksheet
		$excel->getActiveSheet()->setTitle('Worksheet 1');

		//ambil semua data pendapatan
		if ($type == "BLN") {
			$data_medrec = $this->rimpasien->get_discharge_patient_by_month($tgl);
		} else {
			$data_medrec = $this->rimpasien->get_discharge_patient_by_date($tgl);
		}
		//print_r($data_pasien_keluar_tanggal[0]);exit;
		$row = 1;
		//set header excel
		// $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
		// $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
		// $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
		// $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
		// $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
		// $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
		// $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
		// $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
		// $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
		// $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
		// $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');

		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('T1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



		$excel->getActiveSheet()->setAutoFilter('A1:R1');

		foreach ($data_medrec as $r) {

			$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'], 6, 2));
			$tgl_row = substr($r['tgl_masuk'], 8, 2);
			$thn_row = substr($r['tgl_masuk'], 0, 4);
			$tgl_masuk_show = $tgl_row . " " . $bln_row . " " . $thn_row;

			$tgl_indo = $this->obj_tanggal();
			$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'], 6, 2));
			$tgl_row = substr($r['tgl_keluar'], 8, 2);
			$thn_row = substr($r['tgl_keluar'], 0, 4);
			$tgl_keluar_show =  $tgl_row . " " . $bln_row . " " . $thn_row;

			$temp_tgl_awal = strtotime($r['tgl_masuk']);
			$temp_tgl_akhir = strtotime($r['tgl_keluar']);
			$diff = $temp_tgl_akhir - $temp_tgl_awal;
			$diff =  floor($diff / (60 * 60 * 24));
			if ($diff == 0) {
				$diff = 1;
			}

			$hari_perawatan = $diff + 1;

			$row++;
			$excel->getActiveSheet()->setCellValue('A' . $row, $r['no_ipd'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('B' . $row, $r['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('C' . $row, $r['no_medrec_patria'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('D' . $row, $r['ket'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('E' . $row, $r['nmruang'], PHPExcel_Cell_DataType::TYPE_STRING);

			$excel->getActiveSheet()->setCellValue('F' . $row, $umur, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('G' . $row, $r['sex'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('H' . $row, $r['klsiri'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('I' . $row, $tgl_masuk_show, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('J' . $row, $tgl_keluar_show, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('K' . $row, $diff, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('L' . $row, $hari_perawatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('M' . $row, $r['dokter'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('N' . $row, $r['nm_diagnosa'] . ',' . $r['list_diagnosa_tambahan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('O' . $row, $r['diagnosa1'] . ',' . $r['list_id_diagnosa_tambahan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('P' . $row, $r['brtlahir'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('Q' . $row, $r['nmkontraktor'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('R' . $row, $r['kesatuan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('S' . $row, $r['pangkat'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValue('T' . $row, $r['jenis_bayar'], PHPExcel_Cell_DataType::TYPE_STRING);
		}




		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$newDate = date("d-m-Y", strtotime($tgl));
		$filename = 'Laporan_keluar_iri_' . $newDate . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function lap_masuk_ri()
	{
		$tipe_input = $this->input->post('tampil_per');
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');

		if ($tipe_input == 'TGL') {
			$data['title'] = 'Laporan Masuk Pasien Rawat Inap ' . date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimlaporan->get_kunj_masuk_iri($tipe_input, $date)->result_array();
		} else if ($tipe_input == 'BLN') {
			$data['title'] = 'Laporan Masuk Pasien Rawat Inap ' . date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimlaporan->get_kunj_masuk_iri($tipe_input, $month)->result_array();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Masuk Pasien Rawat Inap ' . date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['data_kunjungan'] = $this->rimlaporan->get_kunj_masuk_iri('TGL', $tgl)->result_array();
		}

		$this->load->view('iri/lap_masuk_rawat_inap', $data);
	}

	public function lap_pulang_ri()
	{
		$tipe_input = $this->input->post('tampil_per');
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');

		if ($tipe_input == 'TGL') {
			$data['title'] = 'Laporan Pasien Pulang Rawat Inap ' . date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang_iri($date, $tipe_input)->result_array();
		} else if ($tipe_input == 'BLN') {
			$data['title'] = 'Laporan Pasien Pulang Rawat Inap ' . date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['date_title'] = date("F Y", strtotime($month));
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang_iri($month, $tipe_input)->result_array();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Pasien Pulang Rawat Inap ' . date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['data_kunjungan'] = $this->rimlaporan->get_pasien_pulang_iri($tgl, 'TGL')->result_array();
		}

		$this->load->view('iri/lap_pulang_ri', $data);
	}

	public function excel_lappulang_iri($date, $tampil)
	{
		$data = $this->rimlaporan->get_pasien_pulang_iri($date, $tampil)->result();

		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'RM');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Jenis Kelamin');
		$sheet->setCellValue('F1', 'ALamat');
		$sheet->setCellValue('G1', 'Jaminan');
		$sheet->setCellValue('H1', 'Ruangan');
		$sheet->setCellValue('I1', 'Kelas');
		$sheet->setCellValue('J1', 'Jatah Kelas');
		$sheet->setCellValue('K1', 'DPJP Utama');
		$sheet->setCellValue('L1', 'Diagnosa Masuk');
		$sheet->setCellValue('M1', 'Ket Tempat Tidur');
		$sheet->setCellValue('N1', 'Waktu Daftar RI');
		$sheet->setCellValue('O1', 'Waktu Diterima Petugas RI');
		$sheet->setCellValue('P1', 'Tgl Masuk');
		$sheet->setCellValue('Q1', 'Tgl Perencanaan Pemulangan Pasien');
		$sheet->setCellValue('R1', 'Tgl Keluar');
		$sheet->setCellValue('S1', 'Pintu Masuk');

		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_ipd);
			$sheet->setCellValue('C' . $x, $row->no_cm);
			$sheet->setCellValue('D' . $x, $row->nama);
			$sheet->setCellValue('E' . $x, $row->jenis_kelamin);
			$sheet->setCellValue('F' . $x, $row->alamat);
			$sheet->setCellValue('G' . $x, $row->carabayar);
			$sheet->setCellValue('H' . $x, $row->ruang);
			$sheet->setCellValue('I' . $x, $row->klsiri);
			$sheet->setCellValue('J' . $x, $row->jatahklsiri);
			$sheet->setCellValue('K' . $x, $row->dokter);
			$sheet->setCellValue('L' . $x, $row->diagmasuk . '-' . $row->diagnosa);
			if ($row->selisih_tarif == 1) {
				$ket_bed =  'Selisih Tarif';
			} else if ($row->titip == 1) {
				$ket_bed =  'Titip';
			} else if ($row->naik_1_tingkat == 1) {
				$ket_bed =  'Naik 1 Tingkat';
			} else {
				$ket_bed =  'Sesuai';
			}
			$sheet->setCellValue('M' . $x, $ket_bed);
			$sheet->setCellValue('N' . $x, isset($row->tgldaftarri) ? date('H:i:s', strtotime($row->tgldaftarri)) : '');
			$sheet->setCellValue('O' . $x, isset($row->wkt_masuk_rg) ? date('H:i:s', strtotime($row->wkt_masuk_rg)) : '');
			$sheet->setCellValue('p' . $x, $row->tgl_masuk);
			$sheet->setCellValue('Q' . $x, $row->tgl_rencana_pulang);
			$sheet->setCellValue('R' . $x, $row->tgl_keluar);
			$sheet->setCellValue('S' . $x, $row->pintu_masuk);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pasien Pulang IRI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function excel_lapmasuk_iri($tampil, $date)
	{
		$data = $this->rimlaporan->get_kunj_masuk_iri($tampil, $date)->result();

		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'RM');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Jenis Kelamin');
		$sheet->setCellValue('F1', 'ALamat');
		$sheet->setCellValue('G1', 'Jaminan');
		$sheet->setCellValue('H1', 'Ruangan');
		$sheet->setCellValue('I1', 'Kelas');
		$sheet->setCellValue('J1', 'Jatah Kelas');
		$sheet->setCellValue('K1', 'DPJP Utama');
		$sheet->setCellValue('L1', 'Diagnosa Masuk');
		$sheet->setCellValue('M1', 'Ket Tempat Tidur');
		$sheet->setCellValue('N1', 'Waktu Daftar RI');
		$sheet->setCellValue('O1', 'Waktu Diterima Petugas RI');
		$sheet->setCellValue('P1', 'WMRI');
		$sheet->setCellValue('Q1', 'Tgl Masuk');
		$sheet->setCellValue('R1', 'Tgl Keluar');
		$sheet->setCellValue('S1', 'Pintu Masuk');

		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_ipd);
			$sheet->setCellValue('C' . $x, $row->no_cm);
			$sheet->setCellValue('D' . $x, $row->nama);
			$sheet->setCellValue('E' . $x, $row->jenis_kelamin);
			$sheet->setCellValue('F' . $x, $row->alamat);
			$sheet->setCellValue('G' . $x, $row->carabayar);
			$sheet->setCellValue('H' . $x, $row->ruang);
			$sheet->setCellValue('I' . $x, $row->klsiri);
			$sheet->setCellValue('J' . $x, $row->jatahklsiri);
			$sheet->setCellValue('K' . $x, $row->dokter);
			$sheet->setCellValue('L' . $x, $row->diagmasuk . '-' . $row->diagnosa);
			if ($row->selisih_tarif == 1) {
				$ket_bed =  'Selisih Tarif';
			} else if ($row->titip == 1) {
				$ket_bed =  'Titip';
			} else if ($row->naik_1_tingkat == 1) {
				$ket_bed =  'Naik 1 Tingkat';
			} else {
				$ket_bed =  'Sesuai';
			}
			$sheet->setCellValue('M' . $x, $ket_bed);
			$sheet->setCellValue('N' . $x, isset($row->tgldaftarri) ? date('H:i:s', strtotime($row->tgldaftarri)) : '');
			$sheet->setCellValue('O' . $x, isset($row->wkt_masuk_rg) ? date('H:i:s', strtotime($row->wkt_masuk_rg)) : '');
			if ($row->tgldaftarri != null && $row->wkt_masuk_rg != null) {
				$waktu_daftar_ri = date_create($row->tgldaftarri);
				$waktu_diterima = date_create($row->wkt_masuk_rg);
				$diff = date_diff($waktu_diterima, $waktu_daftar_ri);
				$wmri = date('H:i:s', strtotime($diff->h . ':' . $diff->i . ':' . $diff->s));
			} else {
				$wmri =  '';
			}
			$sheet->setCellValue('P' . $x, $wmri);
			$sheet->setCellValue('Q' . $x, $row->tgl_masuk);
			$sheet->setCellValue('R' . $x, $row->tgl_keluar);
			$sheet->setCellValue('S' . $x, $row->pintu_masuk);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan Masuk IRI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


	public function lap_dirawat_ri()
	{
		$data['title'] = 'Laporan Dirawat Inap';

		//$tipe_input = $this->input->post('tampil_per');

		$temp = $this->rimpasien->select_pasien_iri_all();
		$data['akses'] = $this->rimpasien->select_ruang_user($this->session->userdata('userid'))->result();
		$user_dokter_info = $this->load->get_var('user_dokter_info');
		if ($temp != null) {
			foreach ($temp as $r) {
				if ($r['no_ipd'] != "") {
					//get status bayi
					$bayi = $this->rimpasien->get_bayi_by_ipd_ibu($r['no_ipd']);
					$status_bayi = 0;
					if (($bayi)) {
						$status_bayi = 1;
					}
					$data_pasien[] = array(
						'no_ipd' => $r['no_ipd'],
						'no_cm' => $r['no_cm'] . ($r['ipdibu'] ? ' ( Bayi )' : ''),
						'nama' => $r['nama'],
						'nmruang' => $r['nmruang'],
						'kelas' => $r['kelas'],
						'bed' => $r['bed'],
						'dokter' => $r['dokter'],
						'tglmasukrg' => $r['tglmasukrg'],
						'status_bayi' => $status_bayi,
						'carabayar' => $r['carabayar'],
						'verifikasi_plg' => $r['verifikasi_plg'],
						'nmkontraktor' => $r['nmkontraktor'],
						'pasien_anak' => $r['pasien_anak'],
						'nmkontraktor' => $r['nmkontraktor'],
						'tgl_masuk' => $r['tgl_masuk'],
						'tgldaftarri' => $r['tgldaftarri'],
						'titip' => $r['titip'],
						'selisih_tarif' => $r['selisih_tarif'],
						'jatahklsiri' => $r['jatahklsiri'],
						'tanggal_perencanaan_pemulangan' => $r['tanggal_perencanaan_pemulangan'],
						'sex' => $r['sex'],
						'kota' => $r['kotakabupaten'],
						'diagmasuk' => $r['nm_diagnosa'],
						'naik_1_tingkat' => $r['naik_1_tingkat']
					);
				}
			}
		} else {
			$data_pasien = [];
		}
		$data['data_kunjungan'] = '';

		if ($data_pasien != '') {
			$data['data_kunjungan'] = $data_pasien;
		}


		$this->load->view('iri/lap_rawat_ri', $data);
	}

	public function excel_laprawat_iri()
	{
		$temp = $this->rimpasien->select_pasien_iri_all();
		$data['akses'] = $this->rimpasien->select_ruang_user($this->session->userdata('userid'))->result();
		$user_dokter_info = $this->load->get_var('user_dokter_info');
		if ($temp != null) {
			foreach ($temp as $r) {
				if ($r['no_ipd'] != "") {
					//get status bayi
					$bayi = $this->rimpasien->get_bayi_by_ipd_ibu($r['no_ipd']);
					$status_bayi = 0;
					if (($bayi)) {
						$status_bayi = 1;
					}
					$data_pasien[] = array(
						'no_ipd' => $r['no_ipd'],
						'no_cm' => $r['no_cm'] . ($r['ipdibu'] ? ' ( Bayi )' : ''),
						'nama' => $r['nama'],
						'nmruang' => $r['nmruang'],
						'kelas' => $r['kelas'],
						'bed' => $r['bed'],
						'dokter' => $r['dokter'],
						'tglmasukrg' => $r['tglmasukrg'],
						'status_bayi' => $status_bayi,
						//'grand_total' => $grand_total,
						'carabayar' => $r['carabayar'],
						'verifikasi_plg' => $r['verifikasi_plg'],
						'nmkontraktor' => $r['nmkontraktor'],
						'pasien_anak' => $r['pasien_anak'],
						'nmkontraktor' => $r['nmkontraktor'],
						'tgl_masuk' => $r['tgl_masuk'],
						'tgldaftarri' => $r['tgldaftarri'],
						'titip' => $r['titip'],
						'selisih_tarif' => $r['selisih_tarif'],
						'jatahklsiri' => $r['jatahklsiri'],
						'naik_1_tingkat' => $r['naik_1_tingkat']
					);
				}
			}
		} else {
			$data_pasien = [];
		}
		$data_hasil = '';

		if ($data_pasien != '') {
			$data_hasil = $data_pasien;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'No MR');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Kamar');
		$sheet->setCellValue('F1', 'Kelas');
		$sheet->setCellValue('G1', 'Jatah Kelas');
		$sheet->setCellValue('H1', 'No Bed');
		$sheet->setCellValue('I1', 'Tgl Masuk');
		$sheet->setCellValue('J1', 'Dokter');
		$sheet->setCellValue('K1', 'Ket Tempat Tidur');
		$sheet->setCellValue('L1', 'Bayi');
		$sheet->setCellValue('M1', 'Penjamin');

		$no = 1;
		$x = 2;

		foreach ($data_hasil as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row['no_ipd']);
			$sheet->setCellValue('C' . $x, $row['no_cm']);
			$sheet->setCellValue('D' . $x, $row['nama']);
			$sheet->setCellValue('E' . $x, $row['nmruang']);
			$sheet->setCellValue('F' . $x, $row['kelas']);
			$sheet->setCellValue('G' . $x, $row['jatahklsiri']);
			$sheet->setCellValue('H' . $x, $row['bed']);
			$sheet->setCellValue('I' . $x, date("d-m-Y", strtotime($row['tgl_masuk'])));
			$sheet->setCellValue('J' . $x, $row['dokter']);

			if ($row['selisih_tarif'] == 1) {
				$ket_bed =  'Selisih Tarif';
			} else if ($row['titip'] == 1) {
				$ket_bed =  'Titip';
			} else if ($row['naik_1_tingkat'] == 1) {
				$ket_bed =  'Naik 1 Tingkat';
			} else {
				$ket_bed =  'Sesuai';
			}

			$sheet->setCellValue('K' . $x, $ket_bed);
			if ($row['status_bayi'] == 0) {
				$sheet->setCellValue('L' . $x, 'Tidak Punya');
			} else {
				$sheet->setCellValue('L' . $x, 'Punya');
			}
			$sheet->setCellValue('M' . $x, $row['carabayar']);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pasien Rawat Inap';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function lap_pindah_ruang_ri()
	{
		$data['title'] = 'Laporan Pindah Ruangan Pasien Rawat Inap';

		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$data['tgl1'] = $tgl1;
		$data['tgl2'] = $tgl2;

		if ($tgl1 == '' && $tgl2 == '') {
			$data['data_kunjungan'] = $this->rimlaporan->get_pindah_ruang_iri()->result_array();
		} else {
			$data['data_kunjungan'] = $this->rimlaporan->get_pindah_ruang_iri_date($tgl1, $tgl2)->result_array();
		}

		$this->load->view('iri/lap_pindah_ruang_ri', $data);
	}

	public function excel_lappindah_iri($tgl1, $tgl2)
	{
		if ($tgl1 == '' && $tgl2 == '') {
			$data = $this->rimlaporan->get_pindah_ruang_iri()->result();
		} else {
			$data = $this->rimlaporan->get_pindah_ruang_iri_date($tgl1, $tgl2)->result();
		}


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Medrec');
		$sheet->setCellValue('C1', 'No IPD');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Tgl Masuk');
		$sheet->setCellValue('F1', 'Tgl Keluar');
		$sheet->setCellValue('G1', 'No Bed Asal');
		$sheet->setCellValue('H1', 'No Bed Baru');
		$sheet->setCellValue('I1', 'Ruang Asal');
		$sheet->setCellValue('J1', 'Ruang Baru');
		$sheet->setCellValue('K1', 'Diagnosa');
		$sheet->setCellValue('L1', 'Jenis Kunjungan');

		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_medrec);
			$sheet->setCellValue('C' . $x, $row->no_ipd);
			$sheet->setCellValue('D' . $x, $row->nama);
			$sheet->setCellValue('E' . $x, $row->tgl_masuk);
			$sheet->setCellValue('F' . $x, $row->tgl_keluar);
			$sheet->setCellValue('G' . $x, $row->bed_asal);
			$sheet->setCellValue('H' . $x, $row->bed_pindah);
			$sheet->setCellValue('I' . $x, $row->nm_ruang_asal);
			$sheet->setCellValue('J' . $x, $row->nm_ruang_pindah);
			$sheet->setCellValue('K' . $x, $row->diagnosa);
			$sheet->setCellValue('L' . $x, $row->jns_kunj);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pindah Pasien Rawat Inap';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function lap_dpjp_remun()
	{
		$data['title'] = 'Laporan DPJP Remun';
		$this->load->view('iri/lapdpjp_remun', $data);
	}

	public function lap_dpjp_utama()
	{
		$data['title'] = 'Laporan DPJP Utama';
		$this->load->view('iri/lapdpjp_utama', $data);
	}

	public function lap_dpjp_utama_pulang()
	{
		$data['title'] = 'Laporan DPJP Utama (Pasien Pulang)';
		$this->load->view('iri/lapdpjp_utama_pulang', $data);
	}

	public function lap_dpjp_remun_exe($date = '', $ppa = '', $tampil = '')
	{
		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_remun_dpjp_bln($date, $tampil)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_remun_raber_bln($date, $tampil)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln($date, $tampil)->result();
		}
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		$dokter = [];
		$nama_dokter = [];
		if ($ppa == 'dpjp' || $ppa == 'raber') {
			foreach ($hasil as $value) {
				$diff = 1;
				if ($value->tglkeluarrg != null) {
					$start = new DateTime($value->tglmasukrg); //start
					$end = new DateTime($value->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($value->tgl_keluar_resume != NULL) {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime($value->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$remun_icu = round(($value->jml_icu / $diff) * 100);
				$remun_hcu = round(($value->jml_hcu / $diff) * 100);
				$remun_neuro_1 = round(($value->jml_neuro_1 / $diff) * 100);
				$remun_neuro_2 = round(($value->jml_neuro_2 / $diff) * 100);
				$remun_anak_bedah_1 = round(($value->jml_anak_bedah_1 / $diff) * 100);
				$remun_anak_bedah_2 = round(($value->jml_anak_bedah_2 / $diff) * 100);
				$remun_anak_bedah_3 = round(($value->jml_anak_bedah_3 / $diff) * 100);
				$remun_interne_1 = round(($value->jml_interne_1 / $diff) * 100);
				$remun_interne_2 = round(($value->jml_interne_2 / $diff) * 100);
				$remun_interne_3 = round(($value->jml_interne_3 / $diff) * 100);
				$remun_irnab_lt12_2 = round(($value->jml_irnab_lt12_2 / $diff) * 100);
				$remun_irnab_lt12_vip = round(($value->jml_irnab_lt12_vip / $diff) * 100);
				$remun_irnab_lt3 = round(($value->jml_irnab_lt3 / $diff) * 100);
				$remun_irnac_lt1 = round(($value->jml_irnac_lt1 / $diff) * 100);
				$remun_irnac_lt2 = round(($value->jml_irnac_lt2 / $diff) * 100);
				$remun_irnac_lt3 = round(($value->jml_irnac_lt3 / $diff) * 100);
				// if($remun_icu>=80){
				if (!in_array($value->dokter, $nama_dokter)) {
					array_push($nama_dokter, $value->dokter);
					array_push($dokter, ['nama_dokter' => $value->dokter, 'hasil_icu' => 0]);
				}
				//}
				//if($remun_interne_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_1'] = 0;
					}
				}
				//}
				//if($remun_interne_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_2'] = 0;
					}
				}
				//}
				//if($remun_interne_3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_3'] = 0;
					}
				}
				//}
				//if($remun_hcu>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_hcu'] = 0;
					}
				}
				//}
				//if($remun_neuro_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_neuro_1'] = 0;
					}
				}
				//}
				//if($remun_neuro_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_neuro_2'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_1'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_2'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_3'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt12_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab12_2'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt12_vip>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab12_vip'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab3'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac1'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac2'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac3'] = 0;
					}
				}
				//}
			}

			// var_dump($dokter);die();


			// ini untuk dokter

			// ini untuk hasil
			foreach ($hasil as $value) {
				$diff = 1;
				if ($value->tglkeluarrg != null) {
					$start = new DateTime($value->tglmasukrg); //start
					$end = new DateTime($value->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($value->tgl_keluar_resume != NULL) {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime($value->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$remun_icu = round(($value->jml_icu / $diff) * 100);
				$remun_hcu = round(($value->jml_hcu / $diff) * 100);
				$remun_neuro_1 = round(($value->jml_neuro_1 / $diff) * 100);
				$remun_neuro_2 = round(($value->jml_neuro_2 / $diff) * 100);
				$remun_anak_bedah_1 = round(($value->jml_anak_bedah_1 / $diff) * 100);
				$remun_anak_bedah_2 = round(($value->jml_anak_bedah_2 / $diff) * 100);
				$remun_anak_bedah_3 = round(($value->jml_anak_bedah_3 / $diff) * 100);
				$remun_interne_1 = round(($value->jml_interne_1 / $diff) * 100);
				$remun_interne_2 = round(($value->jml_interne_2 / $diff) * 100);
				$remun_interne_3 = round(($value->jml_interne_3 / $diff) * 100);
				$remun_irnab_lt12_2 = round(($value->jml_irnab_lt12_2 / $diff) * 100);
				$remun_irnab_lt12_vip = round(($value->jml_irnab_lt12_vip / $diff) * 100);
				$remun_irnab_lt3 = round(($value->jml_irnab_lt3 / $diff) * 100);
				$remun_irnac_lt1 = round(($value->jml_irnac_lt1 / $diff) * 100);
				$remun_irnac_lt2 = round(($value->jml_irnac_lt2 / $diff) * 100);
				$remun_irnac_lt3 = round(($value->jml_irnac_lt3 / $diff) * 100);

				if ($remun_icu >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_icu'])) {
								$dokter[$index]['hasil_icu'] += 1;
								// if(isset($dokter[$index]['hasil_interne_1'])){
								// 	$dokter[$index]['hasil_interne_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_interne_2'])){
								// 	$dokter[$index]['hasil_interne_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_interne_3'])){
								// 	$dokter[$index]['hasil_interne_3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_hcu'])){
								// 	$dokter[$index]['hasil_hcu']+=1;
								// }
								// if(isset($dokter[$index]['hasil_neuro_1'])){
								// 	$dokter[$index]['hasil_neuro_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_neuro_2'])){
								// 	$dokter[$index]['hasil_neuro_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_1'])){
								// 	$dokter[$index]['hasil_bedah_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_2'])){
								// 	$dokter[$index]['hasil_bedah_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_3'])){
								// 	$dokter[$index]['hasil_bedah_3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab12_2'])){
								// 	$dokter[$index]['hasil_irnab12_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab_12_vip'])){
								// 	$dokter[$index]['hasil_irnab12_vip']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab3'])){
								// 	$dokter[$index]['hasil_irnab3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac1'])){
								// 	$dokter[$index]['hasil_irnac1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac2'])){
								// 	$dokter[$index]['hasil_irnac2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac3'])){
								// 	$dokter[$index]['hasil_irnac3']+=1;
								// }
							}
						}
					}
				}
				if ($remun_hcu >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_hcu'])) {
								$dokter[$index]['hasil_hcu'] += 1;
							}
						}
					}
				}
				if ($remun_neuro_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_neuro_1'])) {
								$dokter[$index]['hasil_neuro_1'] += 1;
							}
						}
					}
				}
				if ($remun_neuro_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_neuro_2'])) {
								$dokter[$index]['hasil_neuro_2'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_1'])) {
								$dokter[$index]['hasil_bedah_1'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_2'])) {
								$dokter[$index]['hasil_bedah_2'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_3'])) {
								$dokter[$index]['hasil_bedah_3'] += 1;
							}
						}
					}
				}
				if ($remun_interne_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_1'])) {
								$dokter[$index]['hasil_interne_1'] += 1;
							}
						}
					}
				}
				if ($remun_interne_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_2'])) {
								$dokter[$index]['hasil_interne_2'] += 1;
							}
						}
					}
				}
				if ($remun_interne_3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_3'])) {
								$dokter[$index]['hasil_interne_3'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt12_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab12_2'])) {
								$dokter[$index]['hasil_irnab12_2'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt12_vip >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab12_vip'])) {
								$dokter[$index]['hasil_irnab12_vip'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab3'])) {
								$dokter[$index]['hasil_irnab3'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac1'])) {
								$dokter[$index]['hasil_irnac1'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac2'])) {
								$dokter[$index]['hasil_irnac2'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac3'])) {
								$dokter[$index]['hasil_irnac3'] += 1;
							}
						}
					}
				}
			}
			$line['data'] = $dokter;
		} else {
			foreach ($hasil as $value) {
				$row2['no'] = $i++;
				$row2['nama_dokter'] = $value->dokter;
				$row2['hasil_icu'] = $value->jml_icu;
				$row2['hasil_hcu'] = $value->jml_hcu;
				$row2['hasil_neuro_1'] = $value->jml_neuro_1;
				$row2['hasil_neuro_2'] = $value->jml_neuro_2;
				$row2['hasil_bedah_1'] = $value->jml_anak_bedah_1;
				$row2['hasil_bedah_2'] = $value->jml_anak_bedah_2;
				$row2['hasil_bedah_3'] = $value->jml_anak_bedah_3;
				$row2['hasil_interne_1'] = $value->jml_interne_1;
				$row2['hasil_interne_2'] = $value->jml_interne_2;
				$row2['hasil_interne_3'] = $value->jml_interne_3;
				$row2['hasil_irnab12_2'] = $value->jml_irnab_lt12_2;
				$row2['hasil_irnab12_vip'] = $value->jml_irnab_lt12_vip;
				$row2['hasil_irnab3'] = $value->jml_irnab_lt3;
				$row2['hasil_irnac1'] = $value->jml_irnac_lt1;
				$row2['hasil_irnac2'] = $value->jml_irnac_lt2;
				$row2['hasil_irnac3'] = $value->jml_irnac_lt3;
				// $row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
				$line2[] = $row2;
			}
			$line['data'] = $line2;
		}
		// if($ppa != '') {
		// header('Content-Type: application/json; charset=utf-8');
		echo json_encode($line);
		// 	return;
		// }

		// return $line;
	}

	public function excel_lap_dpjp_remun($date, $ppa, $tampil)
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
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		// $sheet->mergeCells('S1:S2')
		// 	->getCell('S1')
		// 	->setValue('Total');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_remun_dpjp_bln($date, $tampil)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_remun_raber_bln($date, $tampil)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln($date, $tampil)->result();
		}
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		$dokter = [];
		$nama_dokter = [];
		if ($ppa == 'dpjp' || $ppa == 'raber') {
			foreach ($hasil as $value) {
				$diff = 1;
				if ($value->tglkeluarrg != null) {
					$start = new DateTime($value->tglmasukrg); //start
					$end = new DateTime($value->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($value->tgl_keluar_resume != NULL) {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime($value->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$remun_icu = round(($value->jml_icu / $diff) * 100);
				$remun_hcu = round(($value->jml_hcu / $diff) * 100);
				$remun_neuro_1 = round(($value->jml_neuro_1 / $diff) * 100);
				$remun_neuro_2 = round(($value->jml_neuro_2 / $diff) * 100);
				$remun_anak_bedah_1 = round(($value->jml_anak_bedah_1 / $diff) * 100);
				$remun_anak_bedah_2 = round(($value->jml_anak_bedah_2 / $diff) * 100);
				$remun_anak_bedah_3 = round(($value->jml_anak_bedah_3 / $diff) * 100);
				$remun_interne_1 = round(($value->jml_interne_1 / $diff) * 100);
				$remun_interne_2 = round(($value->jml_interne_2 / $diff) * 100);
				$remun_interne_3 = round(($value->jml_interne_3 / $diff) * 100);
				$remun_irnab_lt12_2 = round(($value->jml_irnab_lt12_2 / $diff) * 100);
				$remun_irnab_lt12_vip = round(($value->jml_irnab_lt12_vip / $diff) * 100);
				$remun_irnab_lt3 = round(($value->jml_irnab_lt3 / $diff) * 100);
				$remun_irnac_lt1 = round(($value->jml_irnac_lt1 / $diff) * 100);
				$remun_irnac_lt2 = round(($value->jml_irnac_lt2 / $diff) * 100);
				$remun_irnac_lt3 = round(($value->jml_irnac_lt3 / $diff) * 100);
				// if($remun_icu>=80){
				if (!in_array($value->dokter, $nama_dokter)) {
					array_push($nama_dokter, $value->dokter);
					array_push($dokter, ['nama_dokter' => $value->dokter, 'hasil_icu' => 0]);
				}
				//}
				//if($remun_interne_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_1'] = 0;
					}
				}
				//}
				//if($remun_interne_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_2'] = 0;
					}
				}
				//}
				//if($remun_interne_3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_interne_3'] = 0;
					}
				}
				//}
				//if($remun_hcu>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_hcu'] = 0;
					}
				}
				//}
				//if($remun_neuro_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_neuro_1'] = 0;
					}
				}
				//}
				//if($remun_neuro_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_neuro_2'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_1'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_2'] = 0;
					}
				}
				//}
				//if($remun_anak_bedah_3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_bedah_3'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt12_2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab12_2'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt12_vip>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab12_vip'] = 0;
					}
				}
				//}
				//if($remun_irnab_lt3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnab3'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt1>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac1'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt2>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac2'] = 0;
					}
				}
				//}
				//if($remun_irnac_lt3>=80){
				foreach ($dokter as $ind => $dktr) {
					if ($dktr['nama_dokter'] == $value->dokter) {
						$dokter[$ind]['hasil_irnac3'] = 0;
					}
				}
				//}
			}
			// var_dump($dokter);die();


			// ini untuk dokter

			// ini untuk hasil
			foreach ($hasil as $value) {
				$diff = 1;
				if ($value->tglkeluarrg != null) {
					$start = new DateTime($value->tglmasukrg); //start
					$end = new DateTime($value->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($value->tgl_keluar_resume != NULL) {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime($value->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($value->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$remun_icu = round(($value->jml_icu / $diff) * 100);
				$remun_hcu = round(($value->jml_hcu / $diff) * 100);
				$remun_neuro_1 = round(($value->jml_neuro_1 / $diff) * 100);
				$remun_neuro_2 = round(($value->jml_neuro_2 / $diff) * 100);
				$remun_anak_bedah_1 = round(($value->jml_anak_bedah_1 / $diff) * 100);
				$remun_anak_bedah_2 = round(($value->jml_anak_bedah_2 / $diff) * 100);
				$remun_anak_bedah_3 = round(($value->jml_anak_bedah_3 / $diff) * 100);
				$remun_interne_1 = round(($value->jml_interne_1 / $diff) * 100);
				$remun_interne_2 = round(($value->jml_interne_2 / $diff) * 100);
				$remun_interne_3 = round(($value->jml_interne_3 / $diff) * 100);
				$remun_irnab_lt12_2 = round(($value->jml_irnab_lt12_2 / $diff) * 100);
				$remun_irnab_lt12_vip = round(($value->jml_irnab_lt12_vip / $diff) * 100);
				$remun_irnab_lt3 = round(($value->jml_irnab_lt3 / $diff) * 100);
				$remun_irnac_lt1 = round(($value->jml_irnac_lt1 / $diff) * 100);
				$remun_irnac_lt2 = round(($value->jml_irnac_lt2 / $diff) * 100);
				$remun_irnac_lt3 = round(($value->jml_irnac_lt3 / $diff) * 100);

				if ($remun_icu >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_icu'])) {
								$dokter[$index]['hasil_icu'] += 1;
								// if(isset($dokter[$index]['hasil_interne_1'])){
								// 	$dokter[$index]['hasil_interne_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_interne_2'])){
								// 	$dokter[$index]['hasil_interne_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_interne_3'])){
								// 	$dokter[$index]['hasil_interne_3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_hcu'])){
								// 	$dokter[$index]['hasil_hcu']+=1;
								// }
								// if(isset($dokter[$index]['hasil_neuro_1'])){
								// 	$dokter[$index]['hasil_neuro_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_neuro_2'])){
								// 	$dokter[$index]['hasil_neuro_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_1'])){
								// 	$dokter[$index]['hasil_bedah_1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_2'])){
								// 	$dokter[$index]['hasil_bedah_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_bedah_3'])){
								// 	$dokter[$index]['hasil_bedah_3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab12_2'])){
								// 	$dokter[$index]['hasil_irnab12_2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab_12_vip'])){
								// 	$dokter[$index]['hasil_irnab12_vip']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnab3'])){
								// 	$dokter[$index]['hasil_irnab3']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac1'])){
								// 	$dokter[$index]['hasil_irnac1']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac2'])){
								// 	$dokter[$index]['hasil_irnac2']+=1;
								// }
								// if(isset($dokter[$index]['hasil_irnac3'])){
								// 	$dokter[$index]['hasil_irnac3']+=1;
								// }
							}
						}
					}
				}
				if ($remun_hcu >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_hcu'])) {
								$dokter[$index]['hasil_hcu'] += 1;
							}
						}
					}
				}
				if ($remun_neuro_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_neuro_1'])) {
								$dokter[$index]['hasil_neuro_1'] += 1;
							}
						}
					}
				}
				if ($remun_neuro_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_neuro_2'])) {
								$dokter[$index]['hasil_neuro_2'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_1'])) {
								$dokter[$index]['hasil_bedah_1'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_2'])) {
								$dokter[$index]['hasil_bedah_2'] += 1;
							}
						}
					}
				}
				if ($remun_anak_bedah_3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_bedah_3'])) {
								$dokter[$index]['hasil_bedah_3'] += 1;
							}
						}
					}
				}
				if ($remun_interne_1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_1'])) {
								$dokter[$index]['hasil_interne_1'] += 1;
							}
						}
					}
				}
				if ($remun_interne_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_2'])) {
								$dokter[$index]['hasil_interne_2'] += 1;
							}
						}
					}
				}
				if ($remun_interne_3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_interne_3'])) {
								$dokter[$index]['hasil_interne_3'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt12_2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab12_2'])) {
								$dokter[$index]['hasil_irnab12_2'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt12_vip >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab12_vip'])) {
								$dokter[$index]['hasil_irnab12_vip'] += 1;
							}
						}
					}
				}
				if ($remun_irnab_lt3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnab3'])) {
								$dokter[$index]['hasil_irnab3'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt1 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac1'])) {
								$dokter[$index]['hasil_irnac1'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt2 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac2'])) {
								$dokter[$index]['hasil_irnac2'] += 1;
							}
						}
					}
				}
				if ($remun_irnac_lt3 >= 80) {
					foreach ($dokter as $index => $v) {
						if ($v['nama_dokter'] == $value->dokter) {
							if (isset($dokter[$index]['hasil_irnac3'])) {
								$dokter[$index]['hasil_irnac3'] += 1;
							}
						}
					}
				}
			}

			$line['data'] = $dokter;
		} else {
			foreach ($hasil as $value) {
				$row2['no'] = $i++;
				$row2['nama_dokter'] = $value->dokter;
				$row2['hasil_icu'] = $value->jml_icu;
				$row2['hasil_hcu'] = $value->jml_hcu;
				$row2['hasil_neuro_1'] = $value->jml_neuro_1;
				$row2['hasil_neuro_2'] = $value->jml_neuro_2;
				$row2['hasil_bedah_1'] = $value->jml_anak_bedah_1;
				$row2['hasil_bedah_2'] = $value->jml_anak_bedah_2;
				$row2['hasil_bedah_3'] = $value->jml_anak_bedah_3;
				$row2['hasil_interne_1'] = $value->jml_interne_1;
				$row2['hasil_interne_2'] = $value->jml_interne_2;
				$row2['hasil_interne_3'] = $value->jml_interne_3;
				$row2['hasil_irnab12_2'] = $value->jml_irnab_lt12_2;
				$row2['hasil_irnab12_vip'] = $value->jml_irnab_lt12_vip;
				$row2['hasil_irnab3'] = $value->jml_irnab_lt3;
				$row2['hasil_irnac1'] = $value->jml_irnac_lt1;
				$row2['hasil_irnac2'] = $value->jml_irnac_lt2;
				$row2['hasil_irnac3'] = $value->jml_irnac_lt3;
				// $row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
				$line2[] = $row2;
			}
			$line['data'] = $line2;
		}

		$no = 1;
		$x = 3;

		foreach ($line['data'] as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value['nama_dokter']);
			$sheet->setCellValue('C' . $x, isset($value['hasil_icu']) ? $value['hasil_icu'] : 0);
			$sheet->setCellValue('D' . $x, isset($value['hasil_hcu']) ? $value['hasil_hcu'] : 0);
			$sheet->setCellValue('E' . $x, isset($value['hasil_neuro_1']) ? $value['hasil_neuro_1'] : 0);
			$sheet->setCellValue('F' . $x, isset($value['hasil_neuro_2']) ? $value['hasil_neuro_2'] : 0);
			$sheet->setCellValue('G' . $x, isset($value['hasil_bedah_1']) ? $value['hasil_bedah_1'] : 0);
			$sheet->setCellValue('H' . $x, isset($value['hasil_bedah_2']) ? $value['hasil_bedah_2'] : 0);
			$sheet->setCellValue('I' . $x, isset($value['hasil_bedah_3']) ? $value['hasil_bedah_3'] : 0);
			$sheet->setCellValue('J' . $x, isset($value['hasil_interne_1']) ? $value['hasil_interne_1'] : 0);
			$sheet->setCellValue('K' . $x, isset($value['hasil_interne_2']) ? $value['hasil_interne_2'] : 0);
			$sheet->setCellValue('L' . $x, isset($value['hasil_interne_3']) ? $value['hasil_interne_3'] : 0);
			$sheet->setCellValue('M' . $x, isset($value['hasil_irnab12_2']) ? $value['hasil_irnab12_2'] : 0);
			$sheet->setCellValue('N' . $x, isset($value['hasil_irnab12_vip']) ? $value['hasil_irnab12_vip'] : 0);
			$sheet->setCellValue('O' . $x, isset($value['hasil_irnab3']) ? $value['hasil_irnab3'] : 0);
			$sheet->setCellValue('P' . $x, isset($value['hasil_irnac1']) ? $value['hasil_irnac1'] : 0);
			$sheet->setCellValue('Q' . $x, isset($value['hasil_irnac2']) ? $value['hasil_irnac2'] : 0);
			$sheet->setCellValue('R' . $x, isset($value['hasil_irnac3']) ? $value['hasil_irnac3'] : 0);
			// $sheet->setCellValue('S'.$x, $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Visite Kebutuhan Remun ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_dpjp_pulang_exe($date, $ppa)
	{
		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_bln_pulang($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_bln_pulang($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln_pulang($date)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->dokter;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function lap_dpjp_exe($date, $ppa)
	{
		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_bln($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_bln($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln($date)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->dokter;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function lap_dpjp_pulang_exe_tgl($date, $ppa)
	{
		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_tgl_pulang($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_tgl_pulang($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_tgl_pulang($date)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->dokter;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function excel_lap_dpjp_utama_pulang($date, $ppa)
	{
		$tgl = date("F Y", strtotime($date));
		if ($ppa == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if ($ppa == 'raber') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->mergeCells('S1:S2')
			->getCell('S1')
			->setValue('Total');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_bln_pulang($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_bln_pulang($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln_pulang($date)->result();
		}

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->dokter);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$sheet->setCellValue('S' . $x, $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah ' . $ppa_sbg . ' Rawat Inap ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_dpjp_exe_tgl($date, $ppa)
	{
		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_tgl($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_tgl($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_tgl($date)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->dokter;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$row2['total'] = $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function excel_lap_dpjp_utama($date, $ppa)
	{
		$tgl = date("F Y", strtotime($date));
		if ($ppa == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if ($ppa == 'raber') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->mergeCells('S1:S2')
			->getCell('S1')
			->setValue('Total');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_bln($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_bln($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_bln($date)->result();
		}

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->dokter);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$sheet->setCellValue('S' . $x, $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah ' . $ppa_sbg . ' Rawat Inap ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_dpjp_utama_tgl_pulang($date, $ppa)
	{
		$tgl = date("d F Y", strtotime($date));
		if ($ppa == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if ($ppa == 'raber') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->mergeCells('S1:S2')
			->getCell('S1')
			->setValue('Total');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_tgl_pulang($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_tgl_pulang($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_tgl_pulang($date)->result();
		}

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->dokter);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$sheet->setCellValue('S' . $x, $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah ' . $ppa_sbg . ' Rawat Inap ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_dpjp_utama_tgl($date, $ppa)
	{
		$tgl = date("d F Y", strtotime($date));
		if ($ppa == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if ($ppa == 'raber') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->mergeCells('S1:S2')
			->getCell('S1')
			->setValue('Total');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		if ($ppa == 'dpjp') {
			$hasil = $this->rimlaporan->get_count_dpjp_utama_tgl($date)->result();
		} else if ($ppa == 'raber') {
			$hasil = $this->rimlaporan->get_count_raber_tgl($date)->result();
		} else {
			$hasil = $this->rimlaporan->get_count_konsul_sekali_tgl($date)->result();
		}

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->dokter);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$sheet->setCellValue('S' . $x, $value->jml_icu + $value->jml_hcu + $value->jml_neuro_1 + $value->jml_neuro_2 + $value->jml_anak_bedah_1 + $value->jml_anak_bedah_2 + $value->jml_anak_bedah_3 + $value->jml_interne_1 + $value->jml_interne_2 + $value->jml_interne_3 + $value->jml_irnab_lt12_2 + $value->jml_irnab_lt12_vip + $value->jml_irnab_lt3 +  $value->jml_irnac_lt1 +  $value->jml_irnac_lt2 +  $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah ' . $ppa_sbg . ' Rawat Inap ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_visite_dpjp()
	{
		$data['title'] = 'Laporan Visite Dokter DPJP';
		$this->load->view('iri/lapvisite_dpjp', $data);
	}

	public function lap_visite_dpjp_exe_tgl($date1)
	{
		$hasil = $this->rimlaporan->get_count_visite_dpjp($date1)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->nama_pemeriksa;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function lap_visite_dpjp_exe_bln($bln)
	{
		$hasil = $this->rimlaporan->get_count_visite_dpjp_bln($bln)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->nama_pemeriksa;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function excel_lap_visite_dpjp_tgl($date1)
	{
		$hasil = $this->rimlaporan->get_count_visite_dpjp($date1)->result();
		$tgl = date("d F Y", strtotime($date1));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		$hasil = $this->rimlaporan->get_count_visite_dpjp($date1, $date2)->result();

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->nama_pemeriksa);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Visite DPJP RI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_visite_dpjp_bln($bln)
	{
		$hasil = $this->rimlaporan->get_count_visite_dpjp_bln($bln)->result();
		$tgl = date("F Y", strtotime($bln));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		$hasil = $this->rimlaporan->get_count_visite_dpjp($date1, $date2)->result();

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->nama_pemeriksa);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Visite DPJP RI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_visite_raber()
	{
		$data['title'] = 'Laporan Visite Dokter Bersama';
		$this->load->view('iri/lapvisite_raber', $data);
	}

	public function lap_visite_raber_exe_tgl($date1)
	{
		$hasil = $this->rimlaporan->get_count_visite_raber_tgl($date1)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->nama_pemeriksa;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function lap_visite_raber_exe_bln($bln)
	{
		$hasil = $this->rimlaporan->get_count_visite_raber_bln($bln)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['dokter'] = $value->nama_pemeriksa;
			$row2['jml_icu'] = $value->jml_icu;
			$row2['jml_hcu'] = $value->jml_hcu;
			$row2['jml_neuro_1'] = $value->jml_neuro_1;
			$row2['jml_neuro_2'] = $value->jml_neuro_2;
			$row2['jml_anak_bedah_1'] = $value->jml_anak_bedah_1;
			$row2['jml_anak_bedah_2'] = $value->jml_anak_bedah_2;
			$row2['jml_anak_bedah_3'] = $value->jml_anak_bedah_3;
			$row2['jml_interne_1'] = $value->jml_interne_1;
			$row2['jml_interne_2'] = $value->jml_interne_2;
			$row2['jml_interne_3'] = $value->jml_interne_3;
			$row2['jml_irnab_lt12_2'] = $value->jml_irnab_lt12_2;
			$row2['jml_irnab_lt12_vip'] = $value->jml_irnab_lt12_vip;
			$row2['jml_irnab_lt3'] = $value->jml_irnab_lt3;
			$row2['jml_irnac_lt1'] = $value->jml_irnac_lt1;
			$row2['jml_irnac_lt2'] = $value->jml_irnac_lt2;
			$row2['jml_irnac_lt3'] = $value->jml_irnac_lt3;
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function excel_lap_visite_raber_tgl($date1)
	{
		$tgl = date("d F Y", strtotime($date1));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		$hasil = $this->rimlaporan->get_count_visite_raber_tgl($date1)->result();

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->nama_pemeriksa);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Visite Dokter Bersama RI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_visite_raber_bln($bln)
	{
		$tgl = date("F Y", strtotime($bln));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('ICU');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('HCU');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Neurologi');
		$sheet->mergeCells('G1:I1')
			->getCell('G1')
			->setValue('Anak/Bedah');
		$sheet->mergeCells('J1:L1')
			->getCell('J1')
			->setValue('Interne');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna B Lt 1,2');
		$sheet->mergeCells('O1:O2')
			->getCell('O1')
			->setValue('Irna B Lt 3');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Irna C Lt 1');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Irna C Lt 2');
		$sheet->mergeCells('R1:R2')
			->getCell('R1')
			->setValue('Irna C Lt 3');
		$sheet->setCellValue('E2', 'I');
		$sheet->setCellValue('F2', 'II');
		$sheet->setCellValue('G2', 'I');
		$sheet->setCellValue('H2', 'II');
		$sheet->setCellValue('I2', 'III');
		$sheet->setCellValue('J2', 'I');
		$sheet->setCellValue('K2', 'II');
		$sheet->setCellValue('L2', 'III');
		$sheet->setCellValue('M2', 'II');
		$sheet->setCellValue('N2', 'VIP');

		$hasil = $this->rimlaporan->get_count_visite_raber_bln($bln)->result();

		$no = 1;
		$x = 3;

		foreach ($hasil as $value) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $value->nama_pemeriksa);
			$sheet->setCellValue('C' . $x, $value->jml_icu);
			$sheet->setCellValue('D' . $x, $value->jml_hcu);
			$sheet->setCellValue('E' . $x, $value->jml_neuro_1);
			$sheet->setCellValue('F' . $x, $value->jml_neuro_2);
			$sheet->setCellValue('G' . $x, $value->jml_anak_bedah_1);
			$sheet->setCellValue('H' . $x, $value->jml_anak_bedah_2);
			$sheet->setCellValue('I' . $x, $value->jml_anak_bedah_3);
			$sheet->setCellValue('J' . $x, $value->jml_interne_1);
			$sheet->setCellValue('K' . $x, $value->jml_interne_2);
			$sheet->setCellValue('L' . $x, $value->jml_interne_3);
			$sheet->setCellValue('M' . $x, $value->jml_irnab_lt12_2);
			$sheet->setCellValue('N' . $x, $value->jml_irnab_lt12_vip);
			$sheet->setCellValue('O' . $x, $value->jml_irnab_lt3);
			$sheet->setCellValue('P' . $x, $value->jml_irnac_lt1);
			$sheet->setCellValue('Q' . $x, $value->jml_irnac_lt2);
			$sheet->setCellValue('R' . $x, $value->jml_irnac_lt3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Visite Dokter Bersama RI ' . $tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_wilayah_diagnosa()
	{
		$data['title'] = 'Laporan Poliklinik Berdasarkan Wilayah Dan Diagnosa';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;
		if ($lap_per == '') {
			$data['diagnosa'] = array();
			$data['wilayah'] = array();
			$data['wilayah_detail'] = array();
			$data['valid'] = 'KOSONG';
			$data['judul'] = '';
		} else {
			if ($lap_per == 'TGL') {

				$data['tgl'] = $tgl;
				$valid = $this->rimlaporan->get_wilayah_detail($tgl, $lap_per, $layanan)->row();
				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_diagnosa()->result();
					$data['wilayah'] = $this->rimlaporan->get_wilayah()->result();
					$data['wilayah_detail'] = $this->rimlaporan->get_wilayah_detail($tgl, $lap_per, $layanan)->result();

					$data['valid'] = 'ADA';
					$data['judul'] = $tgl;
				} else {
					$data['diagnosa'] = array();
					$data['wilayah'] = array();
					$data['wilayah_detail'] = array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} elseif ($lap_per == 'BLN') {

				$valid = $this->rimlaporan->get_wilayah_detail($bulan, $lap_per, $layanan)->row();
				$data['bulan'] = $bulan;
				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_diagnosa()->result();
					$data['wilayah'] = $this->rimlaporan->get_wilayah()->result();
					$data['wilayah_detail'] = $this->Rjmlaporan->get_wilayah_detail($bulan, $lap_per, $layanan)->result();

					$data['valid'] = 'ADA';
					$data['judul'] = $bulan;
				} else {
					$data['diagnosa'] = array();
					$data['wilayah'] = array();
					$data['wilayah_detail'] = array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} elseif ($lap_per == 'THN') {

				$valid = $this->rimlaporan->get_wilayah_detail($tahun, $lap_per)->row();
				$data['tahun'] = $tahun;
				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_diagnosa()->result();
					$data['wilayah'] = $this->rimlaporan->get_wilayah()->result();
					$data['wilayah_detail'] = $this->rimlaporan->get_wilayah_detail($tahun, $lap_per)->result();

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				} else {
					$data['diagnosa'] = array();
					$data['wilayah'] = array();
					$data['wilayah_detail'] = array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} else {
				$valid = $this->rimlaporan->get_wilayah_detail('', '')->row();

				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_diagnosa()->result();
					$data['wilayah'] = $this->rimlaporan->get_wilayah()->result();
					$data['wilayah_detail'] = $this->rimlaporan->get_wilayah_detail('', '')->result();

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				} else {
					$data['diagnosa'] = array();
					$data['wilayah'] = array();
					$data['wilayah_detail'] = array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}
		}

		$this->load->view('iri/rivlapwilayahdiagnosa', $data);
	}

	public function lap_dig_kasus_jenkel()
	{
		$data['title'] = 'Laporan Poliklinik Berdasarkan Diagnosa, Kasus Dan Jenis Kelamin';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');

		$data['tgl'] = $tgl;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['lap_per'] = $lap_per;

		if ($lap_per == '') {
			$valid = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel('', '')->row();

			if ($valid != null) {
				$data['diagnosa'] = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel('', '')->result();

				foreach ($data['diagnosa'] as $key) {
					$jumlahL[] = $key->l;
					$jumlahP[] = $key->p;
					$jumlahTotal[] = $key->jumlah;
				}
				$jumlah_l     = array_sum($jumlahL);
				$jumlah_p     = array_sum($jumlahP);
				$jumlah_total = array_sum($jumlahTotal);
				$data['jumlah_l'] = $jumlah_l;
				$data['jumlah_p'] = $jumlah_p;
				$data['jumlah_total'] = $jumlah_total;
				$data['valid'] = 'ADA';
				$data['judul'] = '';
			} else {
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
		} else {
			if ($lap_per == 'TGL') {
				$valid = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($tgl, $lap_per)->row();

				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($tgl, $lap_per)->result();
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] = $key->l;
						$jumlahP[] = $key->p;
						$jumlahTotal[] = $key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;
					$data['jumlah_p'] = $jumlah_p;
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal ' . $tgl;
				} else {
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} elseif ($lap_per == 'BLN') {
				$valid = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($bulan, $lap_per)->row();

				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($bulan, $lap_per)->result();

					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] = $key->l;
						$jumlahP[] = $key->p;
						$jumlahTotal[] = $key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;
					$data['jumlah_p'] = $jumlah_p;
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan ' . $bulan;
				} else {
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} elseif ($lap_per == 'THN') {
				$valid = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($tahun, $lap_per)->row();

				if ($valid != null) {

					$data['diagnosa'] = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($tahun, $lap_per)->result();

					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] = $key->l;
						$jumlahP[] = $key->p;
						$jumlahTotal[] = $key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;
					$data['jumlah_p'] = $jumlah_p;
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun ' . $tahun;
				} else {
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			} else {
				$valid = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel('', '')->row();

				if ($valid != null) {
					$data['diagnosa'] = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel('', '')->result();

					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] = $key->l;
						$jumlahP[] = $key->p;
						$jumlahTotal[] = $key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;
					$data['jumlah_p'] = $jumlah_p;
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				} else {
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}
		}



		$this->load->view('iri/rivlapdigkasusjenkel', $data);
	}

	public function excel_lap_dig_kasus_jenkel($lap_per = '', $var = '')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Diagnosa');
		$sheet->setCellValue('C1', 'Kode ICD10');
		$sheet->setCellValue('D1', 'L');
		$sheet->setCellValue('E1', 'P');
		$sheet->setCellValue('F1', 'Total Kunjungan (B + L)');

		if ($lap_per == 'TGL') {
			$data = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($var, $lap_per)->result();
		} elseif ($lap_per == 'BLN') {
			$data = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($var, $lap_per)->result();
		} elseif ($lap_per == 'THN') {
			$data = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel($var, $lap_per)->result();
		} else {
			$data = $this->rimlaporan->get_kunj_diagnosa_kasus_jenkel('', '')->result();
		}

		$jumlah_l     = 0;
		$jumlah_p     = 0;
		$jumlah_total = 0;

		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->nm_diagnosa);
			$sheet->setCellValue('C' . $x, $row->id_diagnosa);
			$sheet->setCellValue('D' . $x, $row->l);
			$sheet->setCellValue('E' . $x, $row->p);
			$sheet->setCellValue('F' . $x, $row->jumlah);
			$jumlah_l += $row->l;
			$jumlah_p += $row->p;
			$jumlah_total += $row->jumlah;
			$x++;
		}
		$sheet->setCellValue('A' . $x, 'TOTAL');
		$sheet->mergeCells('A' . $x . ':' . 'C' . $x . '');
		$sheet->setCellValue('D' . $x, $jumlah_l);
		$sheet->setCellValue('E' . $x, $jumlah_p);
		$sheet->setCellValue('F' . $x, $jumlah_total);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin RI';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_realisasi_pendapatan_pasien_pulang()
	{
		$data['title'] = 'Laporan Realisasi Pendapatan Pasien Pulang';
		$date1 = $this->input->post('date_picker_days1');
		$date2 = $this->input->post('date_picker_days2');
		$jaminan = $this->input->post('jaminan');

		$data['date1'] = $date1;
		$data['date2'] = $date2;
		$data['jaminan'] = $jaminan;

		if ($jaminan == 'BPJS') {
			$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_bpjs_new($date1, $date2)->result();
		} else if ($jaminan == 'selisih_tarif') {
			$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_selisih_tarif($date1, $date2)->result();
		} else {
			$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang($date1, $date2, $jaminan)->result();
		}

		//else if($jaminan == 'UMUM') {
		// 	$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_umum($date1, $date2)->result();
		// } else {
		// 	$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_selisih_tarif($date1, $date2)->result();
		// }
		$this->load->view('iri/laprealisasi_pendapatan', $data);
	}

	public function excel_lap_pendapatan_pasien_pulang($date1, $date2, $jaminan)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		if ($jaminan == 'UMUM' || $jaminan == 'KERJASAMA') {
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Penjamin');
			$sheet->setCellValue('C1', 'No Register');
			$sheet->setCellValue('D1', 'Tanggal Pulang');
			$sheet->setCellValue('E1', 'No MR');
			$sheet->setCellValue('F1', 'Nama');
			$sheet->setCellValue('G1', 'Ruang');
			$sheet->setCellValue('H1', 'Kelas');
			$sheet->setCellValue('I1', 'Ins Rawat Intensive');
			$sheet->setCellValue('J1', 'IGD');
			$sheet->setCellValue('K1', 'Ins Bedah Sentral');
			$sheet->setCellValue('L1', 'Ins Farmasi');
			$sheet->setCellValue('M1', 'Ins Gizi');
			$sheet->setCellValue('N1', 'Ins Laboratorium');
			$sheet->setCellValue('O1', 'Ins MR');
			$sheet->setCellValue('P1', 'Ins Radiologi');
			$sheet->setCellValue('Q1', 'Elektromedik');
			$sheet->setCellValue('R1', 'ins Rawat Inap');
			$sheet->setCellValue('S1', 'Ins Rawat Jalan');
			$sheet->setCellValue('T1', 'Ins Rehab');
			$sheet->setCellValue('U1', 'Total');
			$sheet->setCellValue('V1', 'Tarif RIll RS');
		} else if ($jaminan == 'BPJS' || $jaminan == 'selisih_tarif') {
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Penjamin');
			$sheet->setCellValue('C1', 'No Register');
			$sheet->setCellValue('D1', 'Tanggal Pulang');
			$sheet->setCellValue('E1', 'No MR');
			$sheet->setCellValue('F1', 'Nama');
			$sheet->setCellValue('G1', 'Inacbg');
			$sheet->setCellValue('H1', 'No SEP');
			$sheet->setCellValue('I1', 'Ruang');
			$sheet->setCellValue('J1', 'Kelas');
			$sheet->setCellValue('K1', 'Ins Rawat Intensive');
			$sheet->setCellValue('L1', 'IGD');
			$sheet->setCellValue('M1', 'Ins Bedah Sentral');
			$sheet->setCellValue('N1', 'Ins Farmasi');
			$sheet->setCellValue('O1', 'Ins Gizi');
			$sheet->setCellValue('P1', 'Ins Laboratorium');
			$sheet->setCellValue('Q1', 'Ins MR');
			$sheet->setCellValue('R1', 'Ins Radiologi');
			$sheet->setCellValue('S1', 'Elektromedik');
			$sheet->setCellValue('T1', 'ins Rawat Inap');
			$sheet->setCellValue('U1', 'Ins Rawat Jalan');
			$sheet->setCellValue('V1', 'Ins Rehab');
			$sheet->setCellValue('W1', 'Total');
			$sheet->setCellValue('X1', 'Tarif RIll RS');
		}
		// $highestColumn = $sheet->getHighestColumn(); 

		$no = 1;
		$x = 2;
		$grand_total_intensif = 0;
		$grand_total_igd = 0;
		$grand_total_ok = 0;
		$grand_total_obat = 0;
		$grand_total_gizi = 0;
		$grand_total_lab = 0;
		$grand_total_mr = 0;
		$grand_total_rad = 0;
		$grand_total_em = 0;
		$grand_total_ri = 0;
		$grand_total_rj = 0;
		$grand_total_rehab = 0;
		$grand_total_all = 0;

		if ($jaminan == 'BPJS' || $jaminan == 'selisih_tarif') {
			if ($jaminan == 'BPJS') {
				$data_pendapatan = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_bpjs_new($date1, $date2)->result();
			} else if ($jaminan == 'selisih_tarif') {
				$data_pendapatan = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_selisih_tarif($date1, $date2)->result();
			}

			foreach ($data_pendapatan as $row) {
				$intensif = $this->rimlaporan->get_ruang_intensif($row->no_ipd);
				$ruang = $this->rimlaporan->get_ruang_non_intensif($row->no_ipd);
				$lab_rill = isset($this->rimlaporan->get_tarif_rill_lab($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_lab($row->no_ipd)->row()->tarif : null;
				$rad_rill = isset($this->rimlaporan->get_tarif_rill_rad($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_rad($row->no_ipd)->row()->tarif : null;
				$em_rill = isset($this->rimlaporan->get_tarif_rill_em($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_em($row->no_ipd)->row()->tarif : null;
				$ok_rill = isset($this->rimlaporan->get_tarif_rill_ok($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_ok($row->no_ipd)->row()->tarif : null;

				if (substr($row->no_ipd, 0, 2) == 'RJ') {
					$alltind_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_rj($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_all_tindakan_rj($row->no_ipd)->row()->tarif : null;
				} else {
					$alltind_rj_rill = isset($this->rimlaporan->get_vtot_noregasal_blm_claim($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_vtot_noregasal_blm_claim($row->no_ipd)->row()->tarif : null;
					$alltind_ri_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_ri($row->no_ipd)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_all_tindakan_ri($row->no_ipd)->row()->tarif : null;
				}

				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $row->carabayar);
				$sheet->setCellValue('C' . $x, $row->no_ipd);
				$sheet->setCellValue('D' . $x, date("d-m-Y", strtotime($row->tgl)));
				$sheet->setCellValue('E' . $x, $row->no_cm);
				$sheet->setCellValue('F' . $x, $row->nama);
				$sheet->setCellValue('G' . $x, $row->kd_inacbg);
				$sheet->setCellValue('H' . $x, $row->no_sep);
				$sheet->setCellValue('I' . $x, $row->ruang);
				$sheet->setCellValue('J' . $x, $row->klsiri);

				$total_intensif = 0;
				$int_rill = 0;
				foreach ($intensif as $ins) {
					$diff = 1;
					if ($ins['tglkeluarrg'] != null) {
						$start = new DateTime($ins['tglmasukrg']); //start
						$end = new DateTime($ins['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($ins['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($ins['tglmasukrg']); //start
							$end = new DateTime($ins['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($ins['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}

							// echo $diff." Hari"; 
						}
					}

					//if($row->carabayar == 'UMUM') {
					// $total_intensif += $ins['total_tarif'] * $diff;
					// if($ins['titip'] == '1') {
					// 	$ruang_rill += $ins['tarif_jatah'] * $diff;
					// } else {
					// 	$ruang_rill += $ins['total_tarif'] * $diff;
					// }
					//} else if($row->carabayar == 'BPJS') {
					$total_intensif += $ins['tarif_bpjs'] * $diff;
					if ($ins['titip'] == '1') {
						$ruang_rill += $ins['tarif_jatah_bpjs'] * $diff;
					} else {
						$ruang_rill += $ins['tarif_bpjs'] * $diff;
					}
					//} else {
					// $total_intensif += $ins['tarif_iks'] * $diff;
					// if($ins['titip'] == '1') {
					// 	$ruang_rill += $ins['tarif_jatah_iks'] * $diff;
					// } else {
					// 	$ruang_rill += $ins['tarif_iks'] * $diff;
					// }
					//}

					$grand_total_intensif += $total_intensif;
				}
				$sheet->setCellValue('K' . $x, number_format($total_intensif));
				// $grand_total_intensif += $row->ruang_intensif;
				$sheet->setCellValue('L' . $x, number_format($row->igd));
				$grand_total_igd += $row->igd;
				$sheet->setCellValue('M' . $x, number_format($row->ok_iri + $row->ok_igd));
				$grand_total_ok += $row->ok_iri + $row->ok_igd;
				$sheet->setCellValue('N' . $x, number_format($row->farmasi_iri + $row->farmasi_irj));
				$grand_total_obat += $row->farmasi_iri + $row->farmasi_irj;
				$sheet->setCellValue('O' . $x, number_format($row->gizi_iri + $row->gizi_igd));
				$grand_total_gizi += $row->gizi_iri + $row->gizi_igd;
				$sheet->setCellValue('P' . $x, number_format($row->lab_iri + $row->lab_igd));
				$grand_total_lab += $row->lab_iri + $row->lab_igd;
				$sheet->setCellValue('Q' . $x, number_format($row->mr));
				$grand_total_mr += $row->mr;
				$sheet->setCellValue('R' . $x, number_format($row->rad_iri + $row->rad_igd));
				$grand_total_rad += $row->rad_iri + $row->rad_igd;
				$sheet->setCellValue('S' . $x, number_format($row->em_iri + $row->em_igd));
				$grand_total_em += $row->em_iri + $row->em_igd;

				$total_ruang = 0;
				$ruang_rill = 0;
				foreach ($ruang as $v) {
					//echo $v['idrg'].'<br>';
					$diff = 1;
					if ($v['tglkeluarrg'] != null) {
						$start = new DateTime($v['tglmasukrg']); //start
						$end = new DateTime($v['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($v['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($v['tglmasukrg']); //start
							$end = new DateTime($v['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($v['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						}
					}

					//if($row->carabayar == 'UMUM') {
					// $total_ruang += ($v['total_tarif'] * $diff);
					// if($v['titip'] == '1') {
					// 	$ruang_rill += $v['tarif_jatah'] * $diff;
					// } else {
					// 	$ruang_rill += $v['total_tarif'] * $diff;
					// }
					//echo number_format($v['total_tarif']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
					//} else if($row->carabayar == 'BPJS') {
					$total_ruang += ($v['tarif_bpjs'] * $diff);
					if ($v['titip'] == '1') {
						$ruang_rill += $v['tarif_jatah_bpjs'] * $diff;
					} else {
						$ruang_rill += $v['tarif_bpjs'] * $diff;
					}
					//echo number_format($v['tarif_bpjs']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
					//} else {
					// $total_ruang += ($v['tarif_iks'] * $diff);
					// if($v['titip'] == '1') {
					// 	$ruang_rill += $v['tarif_jatah_iks'] * $diff;
					// } else {
					// 	$ruang_rill += $v['tarif_iks'] * $diff;
					// }
					//echo number_format($v['tarif_iks']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
					//}

					$grand_total_ri += $total_ruang + $row->iri;
				}
				$sheet->setCellValue('T' . $x, number_format($total_ruang + $row->iri));
				//$grand_total_ri += $row->irj;
				$sheet->setCellValue('U' . $x, number_format($row->irj));
				$grand_total_rj += $row->irj;
				$sheet->setCellValue('V' . $x, number_format($row->rehab_iri + $row->rehab_igd));
				$grand_total_rehab += $row->rehab_iri + $row->rehab_igd;
				$sheet->setCellValue('W' . $x, number_format($row->farmasi_iri + $row->farmasi_irj + $row->igd + $row->ok_iri + $row->ok_igd + $row->gizi_iri + $row->gizi_igd + $row->lab_iri + $row->lab_igd + $row->mr + $row->rad_iri + $row->rad_igd + $row->irj + $row->rehab_iri + $row->rehab_igd + $total_intensif + $row->iri + $total_ruang));
				if (substr($row->no_ipd, 0, 2) == 'RJ') {
					$sheet->setCellValue('X' . $x, number_format($row->farmasi_iri + $row->farmasi_irj + $lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rill));
				} else {
					$sheet->setCellValue('X' . $x, number_format($row->farmasi_iri + $row->farmasi_irj + $lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rj_rill + $alltind_ri_rill + $int_rill + $ruang_rill));
				}
				$x++;
			}
		} else {
			//if($jaminan == 'UMUM') {
			$data_pendapatan = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang($date1, $date2, $jaminan)->result();
			// } else if($jaminan == 'KERJASAMA') {
			// 	$data_pendapatan = $this->rimlaporan->get_realisasi_pendapatan_pasien_pulang_selisih_tarif($date1, $date2)->result();
			// }

			foreach ($data_pendapatan as $r) {
				$intensif = $this->rimlaporan->get_ruang_intensif($r->no_register);
				$ruang = $this->rimlaporan->get_ruang_non_intensif($r->no_register);
				$lab_rill = isset($this->rimlaporan->get_tarif_rill_lab($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_lab($r->no_register)->row()->tarif : null;
				$rad_rill = isset($this->rimlaporan->get_tarif_rill_rad($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_rad($r->no_register)->row()->tarif : null;
				$em_rill = isset($this->rimlaporan->get_tarif_rill_em($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_em($r->no_register)->row()->tarif : null;
				$ok_rill = isset($this->rimlaporan->get_tarif_rill_ok($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_ok($r->no_register)->row()->tarif : null;

				if (substr($r->no_register, 0, 2) == 'RJ') {
					$alltind_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_rj($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_all_tindakan_rj($r->no_register)->row()->tarif : null;
				} else {
					$alltind_rj_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_noregasal($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_all_tindakan_noregasal($r->no_register)->row()->tarif : null;
					$alltind_ri_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_ri($r->no_register)->row()->tarif) ? $this->rimlaporan->get_tarif_rill_all_tindakan_ri($r->no_register)->row()->tarif : null;
				}
				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $r->cara_bayar);
				$sheet->setCellValue('C' . $x, $r->no_register);
				$sheet->setCellValue('D' . $x, date("d-m-Y", strtotime($r->tgl_kunjungan)));
				$sheet->setCellValue('E' . $x, $r->no_medrec);
				$sheet->setCellValue('F' . $x, $r->nama);
				$sheet->setCellValue('G' . $x, $r->nm_poli);
				$sheet->setCellValue('H' . $x, $r->kelas_pasien);
				$total_intensif = 0;
				$int_rill = 0;
				foreach ($intensif as $int) {
					$diff = 1;
					if ($int['tglkeluarrg'] != null) {
						$start = new DateTime($int['tglmasukrg']); //start
						$end = new DateTime($int['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						if ($int['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($int['tglmasukrg']); //start
							$end = new DateTime($int['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						} else {
							$start = new DateTime($int['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						}
					}
					if ($r->cara_bayar == 'UMUM') {
						if ($int['titip'] == '1') {
							$int_rill += $int['tarif_jatah'] * $diff;
						} else {
							$int_rill += $int['total_tarif'] * $diff;
						}
						$total_intensif += $int['total_tarif'] * $diff;
					} else if ($r->cara_bayar == 'BPJS') {
						if ($int['titip'] == '1') {
							$int_rill += $int['tarif_jatah_bpjs'] * $diff;
						} else {
							$int_rill += $int['tarif_bpjs'] * $diff;
						}
						$total_intensif += $int['tarif_bpjs'] * $diff;
					} else {
						if ($int['titip'] == '1') {
							$int_rill += $int['tarif_jatah_iks'] * $diff;
						} else {
							$int_rill += $int['tarif_iks'] * $diff;
						}
						$total_intensif += $int['tarif_iks'] * $diff;
					}
					$grand_total_intensif += $total_intensif;
				}
				$sheet->setCellValue('I' . $x, number_format($total_intensif));
				if (substr($r->no_register, 0, 2) == 'RJ') {
					$igd_gizi_rehab = $r->gizi_igd + $r->rehab_igd;
					if ($igd_gizi_rehab > $r->igd) {
						$igdReal = 0;
					} else {
						$igdReal = $r->igd - $igd_gizi_rehab;
					}
					$sheet->setCellValue('J' . $x, number_format($igdReal));
					$grand_total_igd += $igdReal;
				} else {
					$igdReal = $r->igd;
					$sheet->setCellValue('J' . $x, number_format($r->igd));
					$grand_total_igd += $r->igd;
				}
				$sheet->setCellValue('K' . $x, number_format($r->ok));
				$grand_total_ok += $r->ok;
				$sheet->setCellValue('L' . $x, number_format($r->farmasi));
				$grand_total_obat += $r->farmasi;
				$sheet->setCellValue('M' . $x, number_format($r->gizi_igd + $r->gizi_irj));
				$grand_total_gizi += $r->gizi_igd + $r->gizi_irj;
				$sheet->setCellValue('N' . $x, number_format($r->lab));
				$grand_total_lab += $r->lab;
				$sheet->setCellValue('O' . $x, number_format($r->mr));
				$grand_total_mr += $r->mr;
				$sheet->setCellValue('P' . $x, number_format($r->rad));
				$grand_total_rad += $r->rad;
				$sheet->setCellValue('Q' . $x, number_format($r->em));
				$grand_total_em += $r->em;
				$total_ruang = 0;
				$ruang_rill = 0;
				foreach ($ruang as $val) {
					$diff = 1;
					if ($val['tglkeluarrg'] != null) {
						$start = new DateTime($val['tglmasukrg']); //start
						$end = new DateTime($val['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						if ($val['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($val['tglmasukrg']); //start
							$end = new DateTime($val['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						} else {
							$start = new DateTime($val['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						}
					}
					if ($r->carabayar == 'UMUM') {
						$total_ruang += ($val['total_tarif'] * $diff);
						if ($val['titip'] == '1') {
							$ruang_rill += $val['tarif_jatah'] * $diff;
						} else {
							$ruang_rill += $val['total_tarif'] * $diff;
						}
						// echo number_format($val['total_tarif']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
					} else if ($r->carabayar == 'BPJS') {
						$total_ruang += ($val['tarif_bpjs'] * $diff);
						if ($val['titip'] == '1') {
							$ruang_rill += $val['tarif_jatah_bpjs'] * $diff;
						} else {
							$ruang_rill += $val['tarif_bpjs'] * $diff;
						}
						// echo number_format($val['tarif_bpjs']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
					} else {
						if ($val['titip'] == '1') {
							$ruang_rill += $val['tarif_jatah_iks'] * $diff;
						} else {
							$ruang_rill += $val['tarif_iks'] * $diff;
						}
						$total_ruang += ($val['tarif_iks'] * $diff);
						// echo number_format($val['tarif_iks']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
					}
					$grand_total_ri += $total_ruang + $r->iri;
				}
				$sheet->setCellValue('R' . $x, number_format($total_ruang + $r->iri));
				if (substr($r->no_register, 0, 2) == 'RJ') {
					$irj_gizi_rehab = $r->gizi_irj + $r->rehab_irj;
					if ($irj_gizi_rehab > $r->irj) {
						$irjReal = 0;
					} else {
						$irjReal = $r->irj - $irj_gizi_rehab;
					}
					$sheet->setCellValue('S' . $x, number_format($irjReal));
					$grand_total_rj += $irjReal;
				} else {
					$irjReal = $r->irj;
					$sheet->setCellValue('S' . $x, number_format($r->irj));
					$grand_total_rj += $r->irj;
				}

				$sheet->setCellValue('T' . $x, number_format($r->rehab_igd + $r->rehab_irj));
				$grand_total_rehab += $r->rehab_igd + $r->rehab_irj;
				$sheet->setCellValue('U' . $x, number_format($row->farmasi + $igdReal + $r->em + $r->ok + $r->gizi_igd + $r->gizi_irj + $r->lab + $r->mr + $r->rad + $irjReal + $r->rehab_igd + $r->rehab_irj + $total_intensif + $r->iri + $total_ruang));
				$sheet->setCellValue('V' . $x, number_format($row->farmasi + $igdReal + $r->em + $r->ok + $r->gizi_igd + $r->gizi_irj + $r->lab + $r->mr + $r->rad + $irjReal + $r->rehab_igd + $r->rehab_irj + $total_intensif + $r->iri + $total_ruang));
				$x++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Realisasi Pendapatan Pasien Pulang ' . $date1 . ' - ' . $date2;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		ob_end_clean();
		$writer->save('php://output');
	}

	public function rincian_bill_pasien()
	{
		$data['title'] = 'List Rincian Bill Pasien';

		$date = $this->input->post('date_picker_days');

		if ($date == '') {
			$tgl = date("Y-m-d");
			$data['date'] = $tgl;
			$data['list_rincian'] = $this->rimlaporan->get_data_list_rincian_bil_pasien($tgl)->result();
		} else {
			$data['date'] = $date;
			$data['list_rincian'] = $this->rimlaporan->get_data_list_rincian_bil_pasien($date)->result();
		}
		$this->load->view('iri/list_rincian_bill', $data);
	}

	public function rincian_bill_detail($no_ipd)
	{
		$noregasal = $this->rimlaporan->get_noregasal_pasien($no_ipd)->row()->noregasal;

		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$data['tgl'] = date("Y-m-d");

		$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['ok'] = $this->rimlaporan->get_rincian_ok_pasien($no_ipd, $noregasal)->result();
		$data['lab'] = $this->rimlaporan->get_rincian_lab_pasien($no_ipd, $noregasal)->result();
		$data['em'] = $this->rimlaporan->get_rincian_em_pasien($no_ipd, $noregasal)->result();
		$data['rad'] = $this->rimlaporan->get_rincian_rad_pasien($no_ipd, $noregasal)->result();
		$data['gizi'] = $this->rimlaporan->get_tind_gizi_pasien($no_ipd, $noregasal)->result();
		$data['tind_igd'] = $this->rimlaporan->get_tind_igd_pasien($noregasal)->result();
		$data['ins_mr'] = $this->rimlaporan->get_tind_mr_pasien($noregasal)->result();
		$data['irj'] = $this->rimlaporan->get_tind_irj_pasien($noregasal)->result();
		$data['rehab_medik'] = $this->rimlaporan->get_tind_rehab_pasien($no_ipd, $noregasal)->result();
		$data['resep_pasien'] = $this->rimlaporan->get_resep_bill_pasien_new($no_ipd, $noregasal)->result();
		$data['ruang_intensif'] = $this->rimlaporan->get_ruang_intensif_bill_pasien($no_ipd);
		$data['ruang'] = $this->rimlaporan->get_ruang_non_intensif_bill_pasien($no_ipd);
		$data['tind_iri'] = $this->rimlaporan->get_tind_iri_pasien($no_ipd)->result();
		$interval = date_diff(date_create(), date_create($data['data_pasien']->tgl_lahir));
		$thn = $interval->format("%Y Tahun");
		$data['tahun'] = $thn;

		$data['ttd'] = $this->rimlaporan->get_ttd_dpjp($data['data_pasien']->id_dokter)->row()->ttd ?? '';

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;
		// $html = $this->load->view('iri/cetak_rincian_bill',$data,true);
		$html = $this->load->view('iri/cetak_rincian_bill_new', $data, true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function pendapatan_perhari()
	{
		$data['title'] = 'Laporan Pendapatan Perhari';
		$date1 = $this->input->post('date_picker_days1');
		$date2 = $this->input->post('date_picker_days2');
		$jaminan = $this->input->post('jaminan');

		$data['date1'] = $date1;
		$data['date2'] = $date2;
		$data['jaminan'] = $jaminan;
		if ($jaminan == 'BPJS') {
			$data['data_pendapatan'] = $this->rimlaporan->get_pendapatan_perhari_bpjs_new($date1, $date2)->result();
			$data['noreg'] = $this->rimlaporan->get_noreg_pendapatan_perhari_bpjs($date1, $date2)->result();
			//} else if($jaminan == 'selisih_tarif') {
			//$data['data_pendapatan'] = $this->rimlaporan->get_pendapatan_perhari_selisih_tarif($date1, $date2)->result();
			//} 
		} else if ($jaminan == 'UMUM' || $jaminan == 'KERJASAMA' || $jaminan == 'selisih_tarif') {
			$data['data_pendapatan'] = $this->rimlaporan->get_pendapatan_perhari_umum($date1, $date2, $jaminan)->result();
		} else {
			$data['data_pendapatan'] = $this->rimlaporan->get_pendapatan_perhari_gabungan($date1)->result();
		}

		$this->load->view('iri/lap_pendapatan_per_hari', $data);
	}

	public function excel_lap_pendapatan_perhari($date1, $date2, $jaminan)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		if ($jaminan == 'UMUM') {
			$sheet->setCellValue('A1', 'Tanggal');
			$sheet->setCellValue('B1', 'Ins Rawat Intensive');
			$sheet->setCellValue('C1', 'IGD');
			$sheet->setCellValue('D1', 'Ins Bedah Sentral');
			$sheet->setCellValue('E1', 'Ins Gizi');
			$sheet->setCellValue('F1', 'Ins Laboratorium');
			$sheet->setCellValue('G1', 'Ins MR');
			$sheet->setCellValue('H1', 'Ins Radiologi');
			$sheet->setCellValue('I1', 'Ins Elektromedik');
			$sheet->setCellValue('J1', 'Ins Farmasi');
			$sheet->setCellValue('K1', 'Non Pasien');
			$sheet->setCellValue('L1', 'ins Rawat Inap');
			$sheet->setCellValue('M1', 'Ins Rawat Jalan');
			$sheet->setCellValue('N1', 'Ins Rehab');
			$sheet->setCellValue('O1', 'Total');
		} else {
			$sheet->setCellValue('A1', 'Tanggal');
			$sheet->setCellValue('B1', 'Ins Rawat Intensive');
			$sheet->setCellValue('C1', 'IGD');
			$sheet->setCellValue('D1', 'Ins Bedah Sentral');
			$sheet->setCellValue('E1', 'Ins Gizi');
			$sheet->setCellValue('F1', 'Ins Laboratorium');
			$sheet->setCellValue('G1', 'Ins MR');
			$sheet->setCellValue('H1', 'Ins Radiologi');
			$sheet->setCellValue('I1', 'Ins Elektromedik');
			$sheet->setCellValue('J1', 'ins Rawat Inap');
			$sheet->setCellValue('K1', 'Ins Rawat Jalan');
			$sheet->setCellValue('L1', 'Ins Rehab');
			$sheet->setCellValue('M1', 'Total');
		}
		$tgl1 = date("d F Y", strtotime($date1));
		$tgl2 = date("d F Y", strtotime($date2));

		$no = 1;
		$x = 2;

		if ($jaminan == 'BPJS') {
			$data_pendapatan = $this->rimlaporan->get_pendapatan_perhari_bpjs_new($date1, $date2)->result();
			$noreg = $this->rimlaporan->get_noreg_pendapatan_perhari_bpjs($date1, $date2)->result();
			foreach ($data_pendapatan as $row) {
				$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl_keluar_resume)));
				$intensive = 0;
				foreach ($noreg as $n) {
					$intensif = $this->rimlaporan->get_ruang_intensif($n->no_register);

					$total_intensif = 0;
					foreach ($intensif as $ins) {
						$diff = 1;
						if ($ins['tglkeluarrg'] != null) {
							$start = new DateTime($ins['tglmasukrg']); //start
							$end = new DateTime($ins['tglkeluarrg']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							if ($ins['tgl_keluar_resume'] != NULL) {
								$start = new DateTime($ins['tglmasukrg']); //start
								$end = new DateTime($ins['tgl_keluar_resume']); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
								// echo $diff." Hari"; 
							} else {
								$start = new DateTime($ins['tglmasukrg']); //start
								$end = new DateTime(date("Y-m-d")); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}

								// echo $diff." Hari"; 
							}
						}

						$total_intensif += $ins['tarif_bpjs'] * $diff;
					}
					$intensive += $total_intensif;
				}
				$sheet->setCellValue('B' . $x, number_format($intensive));
				$sheet->setCellValue('C' . $x, number_format($row->igd));
				$sheet->setCellValue('D' . $x, number_format($row->ok));
				$sheet->setCellValue('E' . $x, number_format($row->gizi));
				$sheet->setCellValue('F' . $x, number_format($row->lab));
				$sheet->setCellValue('G' . $x, number_format($row->mr));
				$sheet->setCellValue('H' . $x, number_format($row->rad));
				$sheet->setCellValue('I' . $x, number_format($row->em));
				$ruang = 0;
				foreach ($noreg as $no) {
					$akom = $this->rimlaporan->get_ruang_non_intensif($no->no_register);

					$total_ruang = 0;
					foreach ($akom as $v) {
						$diff = 1;
						if ($v['tglkeluarrg'] != null) {
							$start = new DateTime($v['tglmasukrg']); //start
							$end = new DateTime($v['tglkeluarrg']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							if ($v['tgl_keluar_resume'] != NULL) {
								$start = new DateTime($v['tglmasukrg']); //start
								$end = new DateTime($v['tgl_keluar_resume']); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
								// echo $diff." Hari"; 
							} else {
								$start = new DateTime($v['tglmasukrg']); //start
								$end = new DateTime(date("Y-m-d")); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}

								// echo $diff." Hari"; 
							}
						}

						$total_ruang += $v['tarif_bpjs'] * $diff;
					}
					$ruang += $total_ruang;
				}
				$sheet->setCellValue('J' . $x, number_format($ruang + $row->iri));
				$sheet->setCellValue('K' . $x, number_format($row->irj));
				$sheet->setCellValue('L' . $x, number_format($row->rehab));
				$sheet->setCellValue('M' . $x, number_format($intensive + $ruang + $row->igd + $row->ok + $row->gizi + $row->lab + $row->mr + $row->rad + $row->em + $row->iri + $row->irj + $row->rehab));
				$x++;
			}
		} else if ($jaminan == 'UMUM') {
			$data_pendapatan = $this->rimlaporan->get_pendapatan_perhari_umum($date1, $date2, $jaminan)->result();

			foreach ($data_pendapatan as $row) {
				$intensif = $this->rimlaporan->get_ruang_intensif_pendapatan_perhari_umum($row->tgl);
				$ruang = $this->rimlaporan->get_ruang_non_intensif_pendapatan_perhari_umum($row->tgl);

				$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl)));
				$total_intensif = 0;
				foreach ($intensif as $ui) {
					$diff = 1;
					if ($ui['tglkeluarrg'] != null) {
						$start = new DateTime($ui['tglmasukrg']); //start
						$end = new DateTime($ui['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($ui['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($ui['tglmasukrg']); //start
							$end = new DateTime($ui['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($ui['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}

							// echo $diff." Hari"; 
						}
					}

					$total_intensif += $ui['total_tarif'] * $diff;
				}
				$sheet->setCellValue('B' . $x, number_format($total_intensif));

				$igd_gizi_rehab = $row->gizi_igd + $row->rehab_igd;
				if ($igd_gizi_rehab > $row->igd) {
					$igdReal = 0;
				} else {
					$igdReal = $row->igd - $igd_gizi_rehab;
				}
				$sheet->setCellValue('C' . $x, number_format($igdReal));
				$sheet->setCellValue('D' . $x, number_format($row->ok));
				$sheet->setCellValue('E' . $x, number_format($row->gizi_igd + $row->gizi_irj));
				$sheet->setCellValue('F' . $x, number_format($row->lab));
				$sheet->setCellValue('G' . $x, number_format($row->mr));
				$sheet->setCellValue('H' . $x, number_format($row->rad));
				$sheet->setCellValue('I' . $x, number_format($row->em));
				$sheet->setCellValue('J' . $x, number_format($row->farmasi));
				$sheet->setCellValue('K' . $x, number_format($row->non_pasien));
				$total_ruang = 0;
				foreach ($ruang as $ur) {
					//echo $val['idrg'].'<br>';
					$diff = 1;
					if ($ur['tglkeluarrg'] != null) {
						$start = new DateTime($ur['tglmasukrg']); //start
						$end = new DateTime($ur['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($ur['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($ur['tglmasukrg']); //start
							$end = new DateTime($ur['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($ur['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}

							// echo $diff." Hari"; 
						}
					}
					$total_ruang += ($ur['total_tarif'] * $diff);
				}
				$sheet->setCellValue('L' . $x, number_format($total_ruang + $row->iri));
				$irj_gizi_rehab = $row->gizi_irj + $row->rehab_irj;
				if ($irj_gizi_rehab > $row->irj) {
					$irjReal = 0;
				} else {
					$irjReal = $row->irj - $irj_gizi_rehab;
				}
				$sheet->setCellValue('M' . $x, number_format($irjReal));
				$sheet->setCellValue('N' . $x, number_format($row->rehab_igd + $row->rehab_irj));
				$sheet->setCellValue('O' . $x, number_format($total_intensif + $igdReal + $row->ok + $row->em + $row->gizi_igd + $row->gizi_irj + $row->lab + $row->mr + $row->rad + $total_ruang + $row->iri + $irjReal + $row->rehab_igd + $row->rehab_irj + $row->farmasi + $row->non_pasien));
				$x++;
			}
		} else if ($jaminan == 'KERJASAMA' || $jaminan == 'selisih_tarif') {
			$data_pendapatan = $this->rimlaporan->get_pendapatan_perhari_umum($date1, $date2, $jaminan)->result();

			foreach ($data_pendapatan as $row) {
				$intensif = $this->rimlaporan->get_ruang_intensif_pendapatan_perhari_umum($row->tgl);
				$ruang = $this->rimlaporan->get_ruang_non_intensif_pendapatan_perhari_umum($row->tgl);

				$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl)));
				$total_intensif = 0;
				foreach ($intensif as $ui) {
					$diff = 1;
					if ($ui['tglkeluarrg'] != null) {
						$start = new DateTime($ui['tglmasukrg']); //start
						$end = new DateTime($ui['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($ui['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($ui['tglmasukrg']); //start
							$end = new DateTime($ui['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($ui['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}

							// echo $diff." Hari"; 
						}
					}

					if ($jaminan == 'KERJASAMA') {
						$total_intensif += $ui['tarif_iks'] * $diff;
					} else if ($jaminan == 'selisih_tarif') {
						$total_intensif += $ui['tarif_bpjs'] * $diff;
					}
				}
				$sheet->setCellValue('B' . $x, number_format($total_intensif));

				$igd_gizi_rehab = $row->gizi_igd + $row->rehab_igd;
				if ($igd_gizi_rehab > $row->igd) {
					$igdReal = 0;
				} else {
					$igdReal = $row->igd - $igd_gizi_rehab;
				}
				$sheet->setCellValue('C' . $x, number_format($igdReal));
				$sheet->setCellValue('D' . $x, number_format($row->ok));
				$sheet->setCellValue('E' . $x, number_format($row->gizi_igd + $row->gizi_irj));
				$sheet->setCellValue('F' . $x, number_format($row->lab));
				$sheet->setCellValue('G' . $x, number_format($row->mr));
				$sheet->setCellValue('H' . $x, number_format($row->rad));
				$sheet->setCellValue('I' . $x, number_format($row->em));
				$total_ruang = 0;
				foreach ($ruang as $ur) {
					//echo $val['idrg'].'<br>';
					$diff = 1;
					if ($ur['tglkeluarrg'] != null) {
						$start = new DateTime($ur['tglmasukrg']); //start
						$end = new DateTime($ur['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($ur['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($ur['tglmasukrg']); //start
							$end = new DateTime($ur['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($ur['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}

							// echo $diff." Hari"; 
						}
					}
					if ($jaminan == 'KERJASAMA') {
						$total_ruang += $ur['tarif_iks'] * $diff;
					} else if ($jaminan == 'selisih_tarif') {
						$total_ruang += $ur['tarif_bpjs'] * $diff;
					}
				}
				$sheet->setCellValue('J' . $x, number_format($total_ruang + $row->iri));
				$irj_gizi_rehab = $row->gizi_irj + $row->rehab_irj;
				if ($irj_gizi_rehab > $row->irj) {
					$irjReal = 0;
				} else {
					$irjReal = $row->irj - $irj_gizi_rehab;
				}
				$sheet->setCellValue('K' . $x, number_format($irjReal));
				$sheet->setCellValue('L' . $x, number_format($row->rehab_igd + $row->rehab_irj));
				$sheet->setCellValue('M' . $x, number_format($total_intensif + $igdReal + $row->ok + $row->em + $row->gizi_igd + $row->gizi_irj + $row->lab + $row->mr + $row->rad + $total_ruang + $row->iri + $irjReal + $row->rehab_igd + $row->rehab_irj));
				$x++;
			}
		} else {
			$data_pendapatan = $this->rimlaporan->get_pendapatan_perhari_gabungan($date1, $date2)->result();

			foreach ($data_pendapatan as $row) {
				$intensif = $this->rimlaporan->get_ruang_intensif_pendapatan_perhari($row->tgl_keluar_resume);
				$ruang = $this->rimlaporan->get_ruang_non_intensif_pendapatan_perhari($row->tgl_keluar_resume);

				$sheet->setCellValue('A' . $x, date("d-m-Y", strtotime($row->tgl_keluar_resume)));
				$total_intensif = 0;
				foreach ($intensif as $r) {
					$diff = 1;
					if ($r['tglkeluarrg'] != null) {
						$start = new DateTime($r['tglmasukrg']); //start
						$end = new DateTime($r['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($r['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime($r['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($r['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						}
					}
					//echo $diff.'<br>';
					$total_intensif += $r['total_tarif'] * $diff;
				}
				$sheet->setCellValue('B' . $x, number_format($total_intensif + $row->ruang_intensif));
				$sheet->setCellValue('C' . $x, number_format($row->igd));
				$sheet->setCellValue('D' . $x, number_format($row->ok));
				$sheet->setCellValue('E' . $x, number_format($row->gizi));
				$sheet->setCellValue('F' . $x, number_format($row->lab));
				$sheet->setCellValue('G' . $x, number_format($row->mr));
				$sheet->setCellValue('H' . $x, number_format($row->rad));
				$total_ruang = 0;
				foreach ($ruang as $val) {
					//echo $val['idrg'].'<br>';
					$diff = 1;
					if ($val['tglkeluarrg'] != null) {
						$start = new DateTime($val['tglmasukrg']); //start
						$end = new DateTime($val['tglkeluarrg']); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
						// echo $diff." Hari"; 
					} else {
						if ($val['tgl_keluar_resume'] != NULL) {
							$start = new DateTime($val['tglmasukrg']); //start
							$end = new DateTime($val['tgl_keluar_resume']); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						} else {
							$start = new DateTime($val['tglmasukrg']); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
							// echo $diff." Hari"; 
						}
					}
					$total_ruang += ($val['total_tarif'] * $diff);
				}
				$sheet->setCellValue('I' . $x, number_format($total_ruang + $row->iri + $row->ruang));
				$sheet->setCellValue('J' . $x, number_format($row->irj));
				$sheet->setCellValue('K' . $x, number_format($row->rehab));
				$sheet->setCellValue('L' . $x, number_format($total_intensif + $row->ruang_intensif + $row->igd + $row->ok + $row->gizi + $row->lab + $row->mr + $row->rad + $total_ruang + $row->ruang + $row->iri + $row->irj + $row->rehab));
				$x++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pendapatan Perhari ' . $tgl1 . ' - ' . $tgl2 . ' ' . $jaminan;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_realisasi_tindakan_backup()
	{
		$data['title'] = 'Realisasi Tindakan';
		$date1 = $this->input->post('date_picker_days1');
		$date2 = $this->input->post('date_picker_days2');

		// if($date1 == '' || $date2 == '') {
		// 	$tgl1 = date("Y-m-d");
		// 	$tgl2 = date("Y-m-d");
		// 	$data['tgl1'] = $tgl1;
		// 	$data['tgl2'] = $tgl2;
		// 	$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_tindakan($tgl1, $tgl2)->result();
		// 	$data['ruang'] = $this->rimlaporan->get_ruang_umum_realisasi_tindakan($tgl1, $tgl2)->result();
		//} else {
		$data['tgl1'] = $date1;
		$data['tgl2'] = $date2;
		$data['data_pendapatan'] = $this->rimlaporan->get_realisasi_tindakan($date1, $date2)->result();
		$data['ruang'] = $this->rimlaporan->get_ruang_umum_realisasi_tindakan($date1, $date2)->result();
		//}
		$this->load->view('iri/laprealisasi_tindakan', $data);
	}

	public function lap_realisasi_tindakan()
	{
		$data['title'] = 'Laporan Realisasi Tindakan';
		$this->load->view('iri/lap_realisasi_tindakan', $data);
	}

	public function getRealisasiTindakan()
	{
		header('Content-Type: application/json');
		$startMonth = $_POST["startMonth"];
		$endMonth = $_POST["endMonth"];

		$realisasiTindakan = $this->rimlaporan->get_realisasi_tindakan($startMonth, $endMonth)->result();
		$realisasiAkomodasi = $this->rimlaporan->get_ruang_umum_realisasi_tindakan($startMonth, $endMonth)->result();

		$rowNum = 1;
		$newArr  = array();
		foreach ($realisasiTindakan as $row) {
			$newArr[] = array(
				"no" => $rowNum,
				"kel_tindakan" => $row->kel_tindakan,
				"kategori" => $row->kategori,
				"sub_kelompok" => $row->sub_kelompok,
				"nmtindakan" => $row->nmtindakan,
				"satuan" => $row->satuan,
				"qty_bpjs" => $row->qty_bpjs,
				"qty_umum" => $row->qty_umum,
				"qty_iks_pln" => $row->qty_iks_pln,
				"qty_iks" => $row->qty_iks,
				"vtot_bpjs" => number_format($row->vtot_bpjs),
				"vtot_umum" => number_format($row->vtot_umum),
				"vtot_iks_pln" => number_format($row->vtot_iks_pln),
				"vtot_iks" => number_format($row->vtot_iks),
				"vtotUmum" => $row->vtot_umum,
				"vtotBpjs" => $row->vtot_bpjs,
				"vtotIksPln" => $row->vtot_iks_pln,
				"vtotIks" => $row->vtot_iks
			);
			$rowNum++;
		}

		foreach ($realisasiAkomodasi as $r) {
			$newArr[] = array(
				"no" => $rowNum,
				"kel_tindakan" => $r->kel_tindakan,
				"kategori" => $r->kategori,
				"sub_kelompok" => $r->sub_kelompok,
				"nmtindakan" => $r->nmruang . ' (' . $r->kelas . ')',
				"satuan" => $r->satuan,
				"qty_bpjs" => $r->qty_bpjs,
				"qty_umum" => $r->qty_umum,
				"qty_iks_pln" => $r->qty_iks_pln,
				"qty_iks" => $r->qty_iks,
				"vtot_bpjs" => number_format($r->vtot_bpjs),
				"vtot_umum" => number_format($r->vtot_umum),
				"vtot_iks_pln" => number_format($r->vtot_iks_pln),
				"vtot_iks" => number_format($r->vtot_iks),
				"vtotUmum" => $r->vtot_umum,
				"vtotBpjs" => $r->vtot_bpjs,
				"vtotIksPln" => $r->vtot_iks_pln,
				"vtotIks" => $r->vtot_iks
			);
			$rowNum++;
		}
		echo json_encode($newArr);
	}

	public function excel_lap_realisasi_tindakan($date1, $date2)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Kelompok Tindakan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Kategori');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('Sub Kelompok');
		$sheet->mergeCells('E1:E2')
			->getCell('E1')
			->setValue('Tindakan');
		$sheet->mergeCells('F1:F2')
			->getCell('F1')
			->setValue('Satuan');
		$sheet->mergeCells('G1:J1')
			->getCell('G1')
			->setValue('Volume');
		$sheet->mergeCells('K1:N1')
			->getCell('K1')
			->setValue('Rupiah');
		$sheet->setCellValue('G2', 'BPJS');
		$sheet->setCellValue('H2', 'UMUM');
		$sheet->setCellValue('I2', 'IKS PLN');
		$sheet->setCellValue('J2', 'IKS DLL');
		$sheet->setCellValue('K2', 'BPJS');
		$sheet->setCellValue('L2', 'UMUM');
		$sheet->setCellValue('M2', 'IKS PLN');
		$sheet->setCellValue('N2', 'IKS DLL');

		$tgl1 = date("d F Y", strtotime($date1));
		$tgl2 = date("d F Y", strtotime($date2));
		$data = $this->rimlaporan->get_realisasi_tindakan($date1, $date2)->result();
		$ruang = $this->rimlaporan->get_ruang_umum_realisasi_tindakan($date1, $date2)->result();

		$no = 1;
		$x = 3;
		$total_ruang_umum = 0;
		$total_ruang_bpjs = 0;
		$total_ruang_iks = 0;
		$total_ruang_ikspln = 0;
		$qty_ruang_umum = 0;
		$qty_ruang_bpjs = 0;
		$qty_ruang_iks = 0;
		$qty_ruang_ikspln = 0;
		$total_umum = 0;
		$total_bpjs = 0;
		$total_ikspln = 0;
		$total_iks = 0;
		$qty_umum = 0;
		$qty_bpjs = 0;
		$qty_ikspln = 0;
		$qty_iks = 0;

		foreach ($data as $row) {
			$total_bpjs += $row->vtot_bpjs;
			$total_umum += $row->vtot_umum;
			$total_iks += $row->vtot_iks;
			$total_ikspln += $row->vtot_iks_pln;
			$qty_bpjs += $row->qty_bpjs;
			$qty_umum += $row->qty_umum;
			$qty_iks += $row->qty_iks;
			$qty_ikspln += $row->qty_iks_pln;

			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->kel_tindakan);
			$sheet->setCellValue('C' . $x, $row->kategori);
			$sheet->setCellValue('D' . $x, $row->sub_kelompok);
			$sheet->setCellValue('E' . $x, $row->nmtindakan);
			$sheet->setCellValue('F' . $x, $row->satuan);
			$sheet->setCellValue('G' . $x, $row->qty_bpjs);
			$sheet->setCellValue('H' . $x, $row->qty_umum);
			$sheet->setCellValue('I' . $x, $row->qty_iks_pln);
			$sheet->setCellValue('J' . $x, $row->qty_iks);
			$sheet->setCellValue('K' . $x, number_format($row->vtot_bpjs));
			$sheet->setCellValue('L' . $x, number_format($row->vtot_umum));
			$sheet->setCellValue('M' . $x, number_format($row->vtot_iks_pln));
			$sheet->setCellValue('N' . $x, number_format($row->vtot_iks));
			$x++;
		}

		if ($ruang) {
			foreach ($ruang as $r) {
				$total_ruang_umum += $r->vtot_umum;
				$total_ruang_bpjs += $r->vtot_bpjs;
				$total_ruang_iks += $r->vtot_iks;
				$total_ruang_ikspln += $r->vtot_iks_pln;
				$qty_ruang_umum += $r->qty_umum;
				$qty_ruang_bpjs += $r->qty_bpjs;
				$qty_ruang_iks += $r->qty_iks;
				$qty_ruang_ikspln += $r->qty_iks_pln;

				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $r->kel_tindakan);
				$sheet->setCellValue('C' . $x, $r->kategori);
				$sheet->setCellValue('D' . $x, $r->sub_kelompok);
				$sheet->setCellValue('E' . $x, $r->nmruang . ' (' . $r->kelas . ')');
				$sheet->setCellValue('F' . $x, $r->satuan);
				$sheet->setCellValue('G' . $x, $r->qty_bpjs);
				$sheet->setCellValue('H' . $x, $r->qty_umum);
				$sheet->setCellValue('I' . $x, $r->qty_iks_pln);
				$sheet->setCellValue('J' . $x, $r->qty_iks);
				$sheet->setCellValue('K' . $x, number_format($r->vtot_bpjs));
				$sheet->setCellValue('L' . $x, number_format($r->vtot_umum));
				$sheet->setCellValue('M' . $x, number_format($r->vtot_iks_pln));
				$sheet->setCellValue('N' . $x, number_format($r->vtot_iks));
				$x++;
			}
		}

		$sheet->setCellValue('A' . $x, 'TOTAL');
		$sheet->mergeCells('A' . $x . ':' . 'F' . $x . '');
		$sheet->setCellValue('G' . $x, $qty_bpjs + $qty_ruang_bpjs);
		$sheet->setCellValue('H' . $x, $qty_umum + $qty_ruang_umum);
		$sheet->setCellValue('I' . $x, $qty_ikspln + $qty_ruang_ikspln);
		$sheet->setCellValue('J' . $x, $qty_iks + $qty_ruang_iks);
		$sheet->setCellValue('K' . $x, number_format($total_bpjs + $total_ruang_bpjs));
		$sheet->setCellValue('L' . $x, number_format($total_umum + $total_ruang_umum));
		$sheet->setCellValue('M' . $x, number_format($total_ikspln + $total_ruang_ikspln));
		$sheet->setCellValue('N' . $x, number_format($total_iks + $total_ruang_iks));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Realisasi Tindakan ' . $tgl1 . ' - ' . $tgl2;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function input_realisasi_tindakan()
	{
		$data['title'] = 'Input Realisasi Tindakan Rawat Inap';

		$date1 = $this->input->post('date_picker_months1');
		$date2 = $this->input->post('date_picker_months2');

		// if($date1 == '' || $date2 == '') {
		// 	$tgl1 = date("Y-m-d");
		// 	$tgl2 = date("Y-m-d");
		// 	$data['list_umbal'] = $this->rimlaporan->get_pasien_input_realisasi_tindakan($tgl1, $tgl2)->result();
		// } else {
		$data['list_umbal'] = $this->rimlaporan->get_pasien_input_realisasi_tindakan($date1, $date2)->result();
		//}
		$this->load->view('iri/list_umbal', $data);
	}

	public function form_input($no_ipd)
	{
		$data['title'] = 'Input Realisasi Tindakan Rawat Inap';
		$data['no_register'] = $no_ipd;
		$noregasal = $this->rimlaporan->get_noregasal_pasien($no_ipd)->row()->noregasal;
		$data['noregasal'] = $noregasal;
		$data['data_pasien'] = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$data['carabayar'] = $data['data_pasien']->carabayar;
		$data['inacbg'] = $this->rimlaporan->get_tarif_inacbg($no_ipd)->row()->tarif_kls_inacbg;
		$data['tindakan'] = $this->rimlaporan->get_tindakan_umbal($no_ipd, $noregasal)->result();
		$data['resep'] = $this->rimlaporan->get_resep_umbal_pasien($no_ipd, $noregasal)->result();
		$data['ruang'] = $this->rimlaporan->get_ruang_umbal_pasien($no_ipd)->result();
		$this->load->view('iri/form_umbal', $data);
	}

	public function get_data_tindakan()
	{
		$no_register = $this->input->post('no_ipd');
		$id_tindakan = $this->input->post('id_tindakan');
		$noregasal = $this->input->post('noregasal');

		$datajson = $this->rimlaporan->get_data_tindakan($id_tindakan, $no_register, $noregasal)->row();
		echo json_encode($datajson);
	}

	public function get_data_tindakan_obat()
	{
		$no_register = $this->input->post('no_ipd');
		$noregasal = $this->input->post('noregasal');
		$item_obat = $this->input->post('item_obat');

		$datajson = $this->rimlaporan->get_data_tindakan_obat($item_obat, $no_register, $noregasal)->row();
		echo json_encode($datajson);
	}

	public function get_data_tindakan_ruang()
	{
		$no_register = $this->input->post('no_ipd');
		$idrg = $this->input->post('idrg');

		$datajson = $this->rimlaporan->get_data_tindakan_ruang($no_register, $idrg)->row();
		echo json_encode($datajson);
	}

	public function insert_total_tindakan_pasien()
	{
		$no_register = $this->input->post('noreg_hide');
		$login_data = $this->load->get_var("user_info");
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_register)->row();

		$datot['no_register'] = $no_register;
		$datot['volume'] = $this->input->post('vol_umum');
		$datot['vtot'] = $this->input->post('tarif_umum');
		$datot['carabayar'] = $data_pasien->carabayar;
		$datot['xcreate'] = date("Y-m-d H:i:s");
		$datot['xinput'] = $login_data->userid;
		$datot['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$datot['id_kontraktor'] = $data_pasien->id_kontraktor;
		$datot['noregasal'] = $data_pasien->noregasal;
		$datot['tarif_kls_inacbg'] = $data_pasien->inacbg;

		$cek_tindakan = $this->rimlaporan->get_tindakan_input_total($no_register, $data_pasien->noregasal)->result();
		$cek_obat = $this->rimlaporan->get_obat_input_total($no_register, $data_pasien->noregasal)->result();
		$cek_ruang = $this->rimlaporan->get_ruang_input_total($no_register)->result();

		if ($cek_tindakan) {
			foreach ($cek_tindakan as $row) {
				$presentase = ($row->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$data['id_tindakan'] = $row->id_tindakan;
				$data['nama_tindakan'] = $row->jenis_tindakan;
				if ($row->kel_tindakan == '') {
					$data['kel_tindakan'] = NULL;
				} else {
					$data['kel_tindakan'] = $row->kel_tindakan;
				}
				if ($row->kategori == '') {
					$data['kategori'] = NULL;
				} else {
					$data['kategori'] = $row->kategori;
				}
				if ($row->sub_kelompok == '') {
					$data['sub_kelompok'] = NULL;
				} else {
					$data['sub_kelompok'] = $row->sub_kelompok;
				}
				if ($row->satuan == '') {
					$data['satuan'] = NULL;
				} else {
					$data['satuan'] = $row->satuan;
				}
				$data['carabayar'] = $data_pasien->carabayar;
				$data['selisih_tarif'] = $data_pasien->selisih_tarif;
				$data['id_kontraktor'] = $data_pasien->id_kontraktor;
				$data['volume'] = $row->qty;
				$data['xcreate'] = date("Y-m-d H:i:s");
				$data['xinput'] = $login_data->userid;
				$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
				$data['no_register'] = $no_register;
				$data['noregasal'] = $data_pasien->noregasal;
				$data['kontraktor'] = $data_pasien->nmkontraktor;
				$data['tarif_kls_inacbg'] = $data_pasien->inacbg;
				$data['vtot'] = $tarif_tindakan;
				$data['ins'] = $row->ins;
				$data['no_medrec'] = $data_pasien->no_medrec;
				$this->rimlaporan->insert_detail_tindakan_pasien($data);
			}
		}

		if ($cek_obat) {
			foreach ($cek_obat as $r) {
				$presentase = ($r->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$obat['id_tindakan'] = $r->item_obat;
				$obat['nama_tindakan'] = $r->nama_obat;
				if ($r->kel_tindakan == '') {
					$obat['kel_tindakan'] = NULL;
				} else {
					$obat['kel_tindakan'] = $r->kel_tindakan;
				}
				if ($r->kategori == '') {
					$obat['kategori'] = NULL;
				} else {
					$obat['kategori'] = $r->kategori;
				}
				if ($r->sub_kelompok == '') {
					$obat['sub_kelompok'] = NULL;
				} else {
					$obat['sub_kelompok'] = $r->sub_kelompok;
				}
				if ($r->satuan == '') {
					$obat['satuan'] = NULL;
				} else {
					$obat['satuan'] = $r->satuan;
				}
				$obat['carabayar'] = $data_pasien->carabayar;
				$obat['selisih_tarif'] = $data_pasien->selisih_tarif;
				$obat['id_kontraktor'] = $data_pasien->id_kontraktor;
				$obat['volume'] = $r->qty;
				$obat['xcreate'] = date("Y-m-d H:i:s");
				$obat['xinput'] = $login_data->userid;
				$obat['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
				$obat['no_register'] = $no_register;
				$obat['noregasal'] = $data_pasien->noregasal;
				$obat['kontraktor'] = $data_pasien->nmkontraktor;
				$obat['tarif_kls_inacbg'] = $data_pasien->inacbg;
				$obat['vtot'] = $tarif_tindakan;
				$obat['no_medrec'] = $data_pasien->no_medrec;
				$this->rimlaporan->insert_detail_tindakan_pasien($obat);
			}
		}

		if ($cek_ruang) {
			$per_ruang = 0;
			foreach ($cek_ruang as $r) {
				$diff = 1;
				if ($r->tglkeluarrg != null) {
					$start = new DateTime($r->tglmasukrg); //start
					$end = new DateTime($r->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($r->tgl_keluar_resume != NULL) {
						$start = new DateTime($r->tglmasukrg); //start
						$end = new DateTime($r->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($r->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$presentase = (($r->total_tarif * $diff) / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$ruang['id_tindakan'] = $r->idrg;
				$ruang['nama_tindakan'] = $r->tindakan;
				if ($r->kel_tindakan == '') {
					$ruang['kel_tindakan'] = NULL;
				} else {
					$ruang['kel_tindakan'] = $r->kel_tindakan;
				}
				if ($r->kategori == '') {
					$ruang['kategori'] = NULL;
				} else {
					$ruang['kategori'] = $r->kategori;
				}
				if ($r->sub_kelompok == '') {
					$ruang['sub_kelompok'] = NULL;
				} else {
					$ruang['sub_kelompok'] = $r->sub_kelompok;
				}
				if ($r->satuan == '') {
					$ruang['satuan'] = NULL;
				} else {
					$ruang['satuan'] = $r->satuan;
				}
				$ruang['carabayar'] = $data_pasien->carabayar;
				$ruang['selisih_tarif'] = $data_pasien->selisih_tarif;
				$ruang['id_kontraktor'] = $data_pasien->id_kontraktor;
				$ruang['volume'] = $diff;
				$ruang['xcreate'] = date("Y-m-d H:i:s");
				$ruang['xinput'] = $login_data->userid;
				$ruang['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
				$ruang['no_register'] = $no_register;
				$ruang['noregasal'] = $data_pasien->noregasal;
				$ruang['kontraktor'] = $data_pasien->nmkontraktor;
				$ruang['tarif_kls_inacbg'] = $data_pasien->inacbg;
				$ruang['vtot'] = $tarif_tindakan;
				$ruang['ins'] = $r->ins;
				$ruang['no_medrec'] = $data_pasien->no_medrec;
				$this->rimlaporan->insert_detail_tindakan_pasien($ruang);
			}
		}

		$this->Rjmlaporan->insert_total_tindakan_pasien($datot);
	}

	public function update_total_tindakan_pasien()
	{
		$no_register = $this->input->post('noreg_hide');
		$login_data = $this->load->get_var("user_info");
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_register)->row();

		$datot['xinput'] = $login_data->userid;
		$datot['xcreate'] = date("Y-m-d H:i:s");
		$datot['vtot'] = $this->input->post('tarif_umum');

		$cek_tindakan = $this->rimlaporan->get_tindakan_input_total($no_register, $data_pasien->noregasal)->result();
		$cek_obat = $this->rimlaporan->get_obat_input_total($no_register, $data_pasien->noregasal)->result();
		$cek_ruang = $this->rimlaporan->get_ruang_input_total($no_register)->result();

		if ($cek_tindakan) {
			foreach ($cek_tindakan as $row) {
				$presentase = ($row->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$data['xcreate'] = date("Y-m-d H:i:s");
				$data['xinput'] = $login_data->userid;
				$data['vtot'] = $tarif_tindakan;
				$this->rimlaporan->update_detail_tindakan_pasien($data, $row->id_tindakan, $no_register);
			}
		}

		if ($cek_obat) {
			foreach ($cek_obat as $r) {
				$presentase = ($r->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$obat['xcreate'] = date("Y-m-d H:i:s");
				$obat['xinput'] = $login_data->userid;
				$obat['vtot'] = $tarif_tindakan;
				$this->rimlaporan->update_detail_tindakan_pasien($obat, $r->item_obat, $no_register);
			}
		}

		if ($cek_ruang) {
			$per_ruang = 0;
			foreach ($cek_ruang as $r) {
				$diff = 1;
				if ($r->tglkeluarrg != null) {
					$start = new DateTime($r->tglmasukrg); //start
					$end = new DateTime($r->tglkeluarrg); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
				} else {
					if ($r->tgl_keluar_resume != NULL) {
						$start = new DateTime($r->tglmasukrg); //start
						$end = new DateTime($r->tgl_keluar_resume); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						$start = new DateTime($r->tglmasukrg); //start
						$end = new DateTime(date("Y-m-d")); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					}
				}
				$presentase = (($r->total_tarif * $diff) / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$ruang['xcreate'] = date("Y-m-d H:i:s");
				$ruang['xinput'] = $login_data->userid;
				$ruang['vtot'] = $tarif_tindakan;
				$this->rimlaporan->update_detail_tindakan_pasien($ruang, $r->idrg, $no_register);
			}
		}

		$this->rimlaporan->update_total_tindakan_pasien($datot, $no_register);
	}

	public function insert_realisasi_tindakan_bpjs()
	{
		$no_ipd = $this->input->post('noipd');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idtindakan_hide');
		$data['nama_tindakan'] = $this->input->post('nmtindakan_hide');
		if ($this->input->post('keltindakan_hide') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide');
		}

		if ($this->input->post('subkelompok_hide') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide');
		}

		if ($this->input->post('kategori_hide') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide');
		}

		if ($this->input->post('satuan_hide') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum');
		$data['vtot'] = $this->input->post('tarif_umum');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['tarif_kls_inacbg'] = $this->input->post('ina-cbg');
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function insert_realisasi_tindakan_iks()
	{
		$no_ipd = $this->input->post('noipd_iks');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idtindakan_hide_iks');
		$data['nama_tindakan'] = $this->input->post('nmtindakan_hide_iks');
		if ($this->input->post('keltindakan_hide_iks') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_iks');
		}

		if ($this->input->post('subkelompok_hide_iks') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_iks');
		}

		if ($this->input->post('kategori_hide_iks') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_iks');
		}

		if ($this->input->post('satuan_hide_iks') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_iks');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_iks');
		$data['vtot'] = $this->input->post('tarif_umum_iks');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function insert_realisasi_tindakan_obat_bpjs()
	{
		$no_ipd = $this->input->post('noipd_obat');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idobat_hide');
		$data['nama_tindakan'] = $this->input->post('nmobat_hide');
		if ($this->input->post('keltindakan_hide_obat') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_obat');
		}

		if ($this->input->post('subkelompok_hide_obat') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_obat');
		}

		if ($this->input->post('kategori_hide_obat') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_obat');
		}

		if ($this->input->post('satuan_hide_obat') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_obat');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_obat');
		$data['vtot'] = $this->input->post('tarif_umum_obat');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['tarif_kls_inacbg'] = $this->input->post('ina-cbg_obat');
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function insert_realisasi_tindakan_obat_iks()
	{
		$no_ipd = $this->input->post('noipd_obat_iks');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idobat_hide_iks');
		$data['nama_tindakan'] = $this->input->post('nmobat_hide_iks');
		if ($this->input->post('keltindakan_hide_obat_iks') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_obat_iks');
		}

		if ($this->input->post('subkelompok_hide_obat_iks') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_obat_iks');
		}

		if ($this->input->post('kategori_hide_obat_iks') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_obat_iks');
		}

		if ($this->input->post('satuan_hide_obat_iks') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_obat_iks');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_obat_iks');
		$data['vtot'] = $this->input->post('tarif_umum_obat_iks');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function insert_realisasi_tindakan_ruang()
	{
		$no_ipd = $this->input->post('noipd_ruang');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idrg');
		$data['nama_tindakan'] = $this->input->post('nmtindakan_hide_ruang');
		if ($this->input->post('keltindakan_hide_ruang') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_ruang');
		}

		if ($this->input->post('subkelompok_hide_ruang') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_ruang');
		}

		if ($this->input->post('kategori_hide_ruang') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_ruang');
		}

		if ($this->input->post('satuan_hide_ruang') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_ruang');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_ruang');
		$data['vtot'] = $this->input->post('tarif_umum_ruang');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['tarif_kls_inacbg'] = $this->input->post('ina-cbg_ruang');
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function insert_realisasi_tindakan_ruang_iks()
	{
		$no_ipd = $this->input->post('noipd_ruang_iks');
		// var_dump($no_register);
		$data_pasien = $this->rimlaporan->get_data_pasien_rincian_bill($no_ipd)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idrg_iks');
		$data['nama_tindakan'] = $this->input->post('nmtindakan_hide_ruang_iks');
		if ($this->input->post('keltindakan_hide_ruang_iks') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_ruang_iks');
		}

		if ($this->input->post('subkelompok_hide_ruang_iks') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_ruang_iks');
		}

		if ($this->input->post('kategori_hide_ruang_iks') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_ruang_iks');
		}

		if ($this->input->post('satuan_hide_ruang_iks') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_ruang_iks');
		}

		$data['carabayar'] = $data_pasien->carabayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_ruang_iks');
		$data['vtot'] = $this->input->post('tarif_umum_ruang_iks');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = $data_pasien->tgl_keluar_resume;
		$data['no_register'] = $no_ipd;
		$data['noregasal'] = $data_pasien->noregasal;
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->rimlaporan->insert_realisasi_tindakan($data);
	}

	public function ketepatan_visite()
	{
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');

		if ($tampil == 'TGL') {
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan Ruangan dan Kelas ' . date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['judul'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tampil;
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp($tampil, $date)->result();
		} else if ($tampil == 'BLN') {
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan Ruangan dan Kelas ' . date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['judul'] = date("F Y", strtotime($month));
			$data['tampil'] = $tampil;
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp($tampil, $month)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan Ruangan dan Kelas ' . date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['judul'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp('TGL', $tgl)->result();
		}
		$this->load->view('iri/lapketepatan_visite', $data);
	}

	public function excel_ketepatan_visite($date, $tampil)
	{
		if ($tampil == 'BLN') {
			$tanggal = date("F Y", strtotime($date));
		} else {
			$tanggal = date("d F Y", strtotime($date));
		}
		$data = $this->rimlaporan->get_ketepatan_visite_dpjp($tampil, $date)->result();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:D1')
			->getCell('C1')
			->setValue('Panorama Anak');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Panorama Bedah');
		$sheet->mergeCells('G1:H1')
			->getCell('G1')
			->setValue('Panorama Bidan');
		$sheet->mergeCells('I1:J1')
			->getCell('I1')
			->setValue('Irna B L1,2/Singgalang');
		$sheet->mergeCells('K1:L1')
			->getCell('K1')
			->setValue('Irna B L3/Singgalang');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna C L1/Merapi');
		$sheet->mergeCells('O1:P1')
			->getCell('O1')
			->setValue('Irna C L2/Merapi');
		$sheet->mergeCells('Q1:R1')
			->getCell('Q1')
			->setValue('Irna C L3/Merapi');
		$sheet->mergeCells('S1:T1')
			->getCell('S1')
			->setValue('Limpapeh L2&3');
		$sheet->mergeCells('U1:V1')
			->getCell('U1')
			->setValue('Limpapeh L4');
		$sheet->mergeCells('W1:X1')
			->getCell('W1')
			->setValue('ICU/ICCU');
		$sheet->mergeCells('Y1:Z1')
			->getCell('Y1')
			->setValue('NICU');
		$sheet->mergeCells('AA1:AB1')
			->getCell('AA1')
			->setValue('Jumlah');
		$sheet->mergeCells('AC1:AC2')
			->getCell('AC1')
			->setValue('Total');
		$sheet->mergeCells('AD1:AD2')
			->getCell('AD1')
			->setValue('Hasil');
		$sheet->setCellValue('C2', '<= Jam 12');
		$sheet->setCellValue('D2', '> Jam 12');
		$sheet->setCellValue('E2', '<= Jam 12');
		$sheet->setCellValue('F2', '> Jam 12');
		$sheet->setCellValue('G2', '<= Jam 12');
		$sheet->setCellValue('H2', '> Jam 12');
		$sheet->setCellValue('I2', '<= Jam 12');
		$sheet->setCellValue('J2', '> Jam 12');
		$sheet->setCellValue('K2', '<= Jam 12');
		$sheet->setCellValue('L2', '> Jam 12');
		$sheet->setCellValue('M2', '<= Jam 12');
		$sheet->setCellValue('N2', '> Jam 12');
		$sheet->setCellValue('O2', '<= Jam 12');
		$sheet->setCellValue('P2', '> Jam 12');
		$sheet->setCellValue('Q2', '<= Jam 12');
		$sheet->setCellValue('R2', '> Jam 12');
		$sheet->setCellValue('S2', '<= Jam 12');
		$sheet->setCellValue('T2', '> Jam 12');
		$sheet->setCellValue('U2', '<= Jam 12');
		$sheet->setCellValue('V2', '> Jam 12');
		$sheet->setCellValue('W2', '<= Jam 12');
		$sheet->setCellValue('X2', '> Jam 12');
		$sheet->setCellValue('Y2', '<= Jam 12');
		$sheet->setCellValue('Z2', '> Jam 12');
		$sheet->setCellValue('AA2', '<= Jam 12');
		$sheet->setCellValue('AB2', '> Jam 12');

		$x = 3;
		$no = 1;
		$total_kurang_10_icu = 0;
		$total_lebih_12_icu = 0;
		$total_kurang_10_nicu = 0;
		$total_lebih_12_nicu = 0;
		$total_kurang_10_limpapeh23 = 0;
		$total_lebih_12_limpapeh23 = 0;
		$total_kurang_10_limpapeh4 = 0;
		$total_lebih_12_limpapeh4 = 0;
		$total_kurang_10_anak = 0;
		$total_lebih_12_anak = 0;
		$total_kurang_10_bedah = 0;
		$total_lebih_12_bedah = 0;
		$total_kurang_10_bidan = 0;
		$total_lebih_12_bidan = 0;
		$total_kurang_10_singgalang12 = 0;
		$total_lebih_12_singgalang12 = 0;
		$total_kurang_10_singgalang3 = 0;
		$total_lebih_12_singgalang3 = 0;
		$total_kurang_10_merapi1 = 0;
		$total_lebih_12_merapi1 = 0;
		$total_kurang_10_merapi2 = 0;
		$total_lebih_12_merapi2 = 0;
		$total_kurang_10_merapi3 = 0;
		$total_lebih_12_merapi3 = 0;
		$jumlah_kurang_10 = 0;
		$jumlah_lebih_12 = 0;
		$jumlah = 0;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->nama_pemeriksa);

			$sheet->setCellValue('C' . $x, $row->kurang_10_anak);
			$total_kurang_10_anak += $row->kurang_10_anak;

			$sheet->setCellValue('D' . $x, $row->lebih_12_anak);
			$total_lebih_12_anak += $row->lebih_12_anak;

			$sheet->setCellValue('E' . $x, $row->kurang_10_bedah);
			$total_kurang_10_bedah += $row->kurang_10_bedah;

			$sheet->setCellValue('F' . $x, $row->lebih_12_bedah);
			$total_lebih_12_bedah += $row->lebih_12_bedah;

			$sheet->setCellValue('G' . $x, $row->kurang_10_bidan);
			$total_kurang_10_bidan += $row->kurang_10_bidan;

			$sheet->setCellValue('H' . $x, $row->lebih_12_bidan);
			$total_lebih_12_bidan += $row->lebih_12_bidan;

			$sheet->setCellValue('I' . $x, $row->kurang_10_singgalang12);
			$total_kurang_10_singgalang12 += $row->kurang_10_singgalang12;

			$sheet->setCellValue('J' . $x, $row->lebih_12_singgalang12);
			$total_lebih_12_singgalang12 += $row->lebih_12_singgalang12;

			$sheet->setCellValue('K' . $x, $row->kurang_10_singgalang3);
			$total_kurang_10_singgalang3 += $row->kurang_10_singgalang3;

			$sheet->setCellValue('L' . $x, $row->lebih_12_singgalang3);
			$total_lebih_12_singgalang3 += $row->lebih_12_singgalang3;

			$sheet->setCellValue('M' . $x, $row->kurang_10_merapi1);
			$total_kurang_10_merapi1 += $row->kurang_10_merapi1;

			$sheet->setCellValue('N' . $x, $row->lebih_12_merapi1);
			$total_lebih_12_merapi1 += $row->lebih_12_merapi1;

			$sheet->setCellValue('O' . $x, $row->kurang_10_merapi2);
			$total_kurang_10_merapi2 += $row->kurang_10_merapi2;

			$sheet->setCellValue('P' . $x, $row->lebih_12_merapi2);
			$total_lebih_12_merapi2 += $row->lebih_12_merapi2;

			$sheet->setCellValue('Q' . $x, $row->kurang_10_merapi3);
			$total_kurang_10_merapi3 += $row->kurang_10_merapi3;

			$sheet->setCellValue('R' . $x, $row->lebih_12_merapi3);
			$total_lebih_12_merapi3 += $row->lebih_12_merapi3;

			$sheet->setCellValue('S' . $x, $row->kurang_10_limpapeh23);
			$total_kurang_10_limpapeh23 += $row->kurang_10_limpapeh23;

			$sheet->setCellValue('T' . $x, $row->lebih_12_limpapeh23);
			$total_lebih_12_limpapeh23 += $row->lebih_12_limpapeh23;

			$sheet->setCellValue('U' . $x, $row->kurang_10_limpapeh4);
			$total_kurang_10_limpapeh4 += $row->kurang_10_limpapeh4;

			$sheet->setCellValue('V' . $x, $row->lebih_12_limpapeh4);
			$total_lebih_12_limpapeh4 += $row->lebih_12_limpapeh4;

			$sheet->setCellValue('W' . $x, $row->kurang_10_icu);
			$total_kurang_10_icu += $row->kurang_10_icu;

			$sheet->setCellValue('X' . $x, $row->lebih_12_icu);
			$total_lebih_12_icu += $row->lebih_12_icu;

			$sheet->setCellValue('Y' . $x, $row->kurang_10_nicu);
			$total_kurang_10_nicu += $row->kurang_10_nicu;

			$sheet->setCellValue('Z' . $x, $row->lebih_12_nicu);
			$total_lebih_12_nicu += $row->lebih_12_nicu;

			$sheet->setCellValue('AA' . $x, $row->kurang_10_icu + $row->kurang_10_nicu + $row->kurang_10_limpapeh23 + $row->kurang_10_limpapeh4 + $row->kurang_10_anak + $row->kurang_10_bedah + $row->kurang_10_bidan + $row->kurang_10_singgalang12 + $row->kurang_10_singgalang3 + $row->kurang_10_merapi1 + $row->kurang_10_merapi2 + $row->kurang_10_merapi3);
			$total_kurang_10 = $row->kurang_10_icu + $row->kurang_10_nicu + $row->kurang_10_limpapeh23 + $row->kurang_10_limpapeh4 + $row->kurang_10_anak + $row->kurang_10_bedah + $row->kurang_10_bidan + $row->kurang_10_singgalang12 + $row->kurang_10_singgalang3 + $row->kurang_10_merapi1 + $row->kurang_10_merapi2 + $row->kurang_10_merapi3;
			$jumlah_kurang_10 += $row->kurang_10_icu + $row->kurang_10_nicu + $row->kurang_10_limpapeh23 + $row->kurang_10_limpapeh4 + $row->kurang_10_anak + $row->kurang_10_bedah + $row->kurang_10_bidan + $row->kurang_10_singgalang12 + $row->kurang_10_singgalang3 + $row->kurang_10_merapi1 + $row->kurang_10_merapi2 + $row->kurang_10_merapi3;

			$sheet->setCellValue('AB' . $x, $row->lebih_12_icu + $row->lebih_12_nicu + $row->lebih_12_limpapeh23 + $row->lebih_12_limpapeh4 + $row->lebih_12_anak + $row->lebih_12_bedah + $row->lebih_12_bidan + $row->lebih_12_singgalang12 + $row->lebih_12_singgalang3 + $row->lebih_12_merapi1 + $row->lebih_12_merapi2 + $row->lebih_12_merapi3);
			$total_lebih_12 = $row->lebih_12_icu + $row->lebih_12_nicu + $row->lebih_12_limpapeh23 + $row->lebih_12_limpapeh4 + $row->lebih_12_anak + $row->lebih_12_bedah + $row->lebih_12_bidan + $row->lebih_12_singgalang12 + $row->lebih_12_singgalang3 + $row->lebih_12_merapi1 + $row->lebih_12_merapi2 + $row->lebih_12_merapi3;
			$jumlah_lebih_12 += $row->lebih_12_icu + $row->lebih_12_nicu + $row->lebih_12_limpapeh23 + $row->lebih_12_limpapeh4 + $row->lebih_12_anak + $row->lebih_12_bedah + $row->lebih_12_bidan + $row->lebih_12_singgalang12 + $row->lebih_12_singgalang3 + $row->lebih_12_merapi1 + $row->lebih_12_merapi2 + $row->lebih_12_merapi3;

			$sheet->setCellValue('AC' . $x, $total_kurang_10 + $total_lebih_12);
			$jumlah += $total_kurang_10 + $total_lebih_12;

			$total = $total_kurang_10 + $total_lebih_12;
			if ($total != 0) {
				$hasil = ($total_kurang_10 / $total) * 100;
			} else {
				$hasil = 0;
			}
			$sheet->setCellValue('AD' . $x, round($hasil, 1) . '%');
			$x++;
		}

		$sheet->setCellValue('A' . $x, 'Jumlah');
		$sheet->mergeCells('A' . $x . ':' . 'B' . $x . '');
		$sheet->setCellValue('C' . $x, $total_kurang_10_anak);
		$sheet->setCellValue('D' . $x, $total_lebih_12_anak);
		$sheet->setCellValue('E' . $x, $total_kurang_10_bedah);
		$sheet->setCellValue('F' . $x, $total_lebih_12_bedah);
		$sheet->setCellValue('G' . $x, $total_kurang_10_bidan);
		$sheet->setCellValue('H' . $x, $total_lebih_12_bidan);
		$sheet->setCellValue('I' . $x, $total_kurang_10_singgalang12);
		$sheet->setCellValue('J' . $x, $total_lebih_12_singgalang12);
		$sheet->setCellValue('K' . $x, $total_kurang_10_singgalang3);
		$sheet->setCellValue('L' . $x, $total_lebih_12_singgalang3);
		$sheet->setCellValue('M' . $x, $total_kurang_10_merapi1);
		$sheet->setCellValue('N' . $x, $total_lebih_12_merapi1);
		$sheet->setCellValue('O' . $x, $total_kurang_10_merapi2);
		$sheet->setCellValue('P' . $x, $total_lebih_12_merapi2);
		$sheet->setCellValue('Q' . $x, $total_kurang_10_merapi3);
		$sheet->setCellValue('R' . $x, $total_lebih_12_merapi3);
		$sheet->setCellValue('S' . $x, $total_kurang_10_limpapeh23);
		$sheet->setCellValue('T' . $x, $total_lebih_12_limpapeh23);
		$sheet->setCellValue('U' . $x, $total_kurang_10_limpapeh4);
		$sheet->setCellValue('V' . $x, $total_lebih_12_limpapeh4);
		$sheet->setCellValue('W' . $x, $total_kurang_10_icu);
		$sheet->setCellValue('X' . $x, $total_lebih_12_icu);
		$sheet->setCellValue('Y' . $x, $total_kurang_10_nicu);
		$sheet->setCellValue('Z' . $x, $total_lebih_12_nicu);
		$sheet->setCellValue('AA' . $x, $jumlah_kurang_10);
		$sheet->setCellValue('AB' . $x, $jumlah_lebih_12);
		$sheet->setCellValue('AC' . $x, $jumlah);
		if ($jumlah != 0) {
			$presentase_jumlah = ($jumlah_kurang_10 / $jumlah) * 100;
		} else {
			$presentase_jumlah = 0;
		}
		$sheet->setCellValue('AD' . $x, round($presentase_jumlah, 1) . '%');
		$x++;

		$sheet->setCellValue('A' . $x, 'Hasil Ruangan');
		$sheet->mergeCells('A' . $x . ':' . 'B' . $x . '');

		$sheet->setCellValue('C' . $x, $total_kurang_10_anak + $total_lebih_12_anak);
		$total_anak = $total_kurang_10_anak + $total_lebih_12_anak;
		if ($total_anak != 0) {
			$presentase_anak = ($total_kurang_10_anak / $total_anak) * 100;
		} else {
			$presentase_anak = 0;
		}
		$sheet->setCellValue('D' . $x, round($presentase_anak, 1) . '%');

		$sheet->setCellValue('E' . $x, $total_kurang_10_bedah + $total_lebih_12_bedah);
		$total_bedah = $total_kurang_10_bedah + $total_lebih_12_bedah;
		if ($total_bedah != 0) {
			$presentase_bedah = ($total_kurang_10_bedah / $total_bedah) * 100;
		} else {
			$presentase_bedah = 0;
		}
		$sheet->setCellValue('F' . $x, round($presentase_bedah, 1) . '%');

		$sheet->setCellValue('G' . $x, $total_kurang_10_bidan + $total_lebih_12_bidan);
		$total_bidan = $total_kurang_10_bidan + $total_lebih_12_bidan;
		if ($total_bidan != 0) {
			$presentase_bidan = ($total_kurang_10_bidan / $total_bidan) * 100;
		} else {
			$presentase_bidan = 0;
		}
		$sheet->setCellValue('H' . $x, round($presentase_bidan, 1) . '%');

		$sheet->setCellValue('I' . $x, $total_kurang_10_singgalang12 + $total_lebih_12_singgalang12);
		$total_singgalang12 = $total_kurang_10_singgalang12 + $total_lebih_12_singgalang12;
		if ($total_singgalang12 != 0) {
			$presentase_singgalang12 = ($total_kurang_10_singgalang12 / $total_singgalang12) * 100;
		} else {
			$presentase_singgalang12 = 0;
		}
		$sheet->setCellValue('J' . $x, round($presentase_singgalang12, 1) . '%');

		$sheet->setCellValue('K' . $x, $total_kurang_10_singgalang3 + $total_lebih_12_singgalang3);
		$total_singgalang3 = $total_kurang_10_singgalang3 + $total_lebih_12_singgalang3;
		if ($total_singgalang3 != 0) {
			$presentase_singgalang3 = ($total_kurang_10_singgalang3 / $total_singgalang3) * 100;
		} else {
			$presentase_singgalang3 = 0;
		}
		$sheet->setCellValue('L' . $x, round($presentase_singgalang3, 1) . '%');

		$sheet->setCellValue('M' . $x, $total_kurang_10_merapi1 + $total_lebih_12_merapi1);
		$total_merapi1 = $total_kurang_10_merapi1 + $total_lebih_12_merapi1;
		if ($total_merapi1 != 0) {
			$presentase_merapi1 = ($total_kurang_10_merapi1 / $total_merapi1) * 100;
		} else {
			$presentase_merapi1 = 0;
		}
		$sheet->setCellValue('N' . $x, round($presentase_merapi1, 1) . '%');

		$sheet->setCellValue('O' . $x, $total_kurang_10_merapi2 + $total_lebih_12_merapi2);
		$total_merapi2 = $total_kurang_10_merapi2 + $total_lebih_12_merapi2;
		if ($total_merapi2 != 0) {
			$presentase_merapi2 = ($total_kurang_10_merapi2 / $total_merapi2) * 100;
		} else {
			$presentase_merapi2 = 0;
		}
		$sheet->setCellValue('P' . $x, round($presentase_merapi2, 1) . '%');

		$sheet->setCellValue('Q' . $x, $total_kurang_10_merapi3 + $total_lebih_12_merapi3);
		$total_merapi3 = $total_kurang_10_merapi3 + $total_lebih_12_merapi3;
		if ($total_merapi3 != 0) {
			$presentase_merapi3 = ($total_kurang_10_merapi3 / $total_merapi3) * 100;
		} else {
			$presentase_merapi3 = 0;
		}
		$sheet->setCellValue('R' . $x, round($presentase_merapi3, 1) . '%');

		$sheet->setCellValue('S' . $x, $total_kurang_10_limpapeh23 + $total_lebih_12_limpapeh23);
		$total_limpapeh23 = $total_kurang_10_limpapeh23 + $total_lebih_12_limpapeh23;
		if ($total_limpapeh23 != 0) {
			$presentase_limpapeh23 = ($total_kurang_10_limpapeh23 / $total_limpapeh23) * 100;
		} else {
			$presentase_limpapeh23 = 0;
		}
		$sheet->setCellValue('T' . $x, round($presentase_limpapeh23, 1) . '%');

		$sheet->setCellValue('U' . $x, $total_kurang_10_limpapeh4 + $total_lebih_12_limpapeh4);
		$total_limpapeh4 = $total_kurang_10_limpapeh4 + $total_lebih_12_limpapeh4;
		if ($total_limpapeh4 != 0) {
			$presentase_limpapeh4 = ($total_kurang_10_limpapeh4 / $total_limpapeh4) * 100;
		} else {
			$presentase_limpapeh4 = 0;
		}
		$sheet->setCellValue('V' . $x, round($presentase_limpapeh4, 1) . '%');

		$sheet->setCellValue('W' . $x, $total_kurang_10_icu + $total_lebih_12_icu);
		$total_icu = $total_kurang_10_icu + $total_lebih_12_icu;
		if ($total_icu != 0) {
			$presentase_icu = ($total_kurang_10_icu / $total_icu) * 100;
		} else {
			$presentase_icu = 0;
		}
		$sheet->setCellValue('X' . $x, round($presentase_icu, 1) . '%');

		$sheet->setCellValue('Y' . $x, $total_kurang_10_nicu + $total_lebih_12_nicu);
		$total_nicu = $total_kurang_10_nicu + $total_lebih_12_nicu;
		if ($total_nicu != 0) {
			$presentase_nicu = ($total_kurang_10_nicu / $total_nicu) * 100;
		} else {
			$presentase_nicu = 0;
		}
		$sheet->setCellValue('Z' . $x, round($presentase_nicu, 1) . '%');
		$sheet->setCellValue('AA' . $x, '');
		$sheet->setCellValue('AB' . $x, '');
		$sheet->setCellValue('AC' . $x, '');
		$sheet->setCellValue('AD' . $x, '');

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Ketepatan Visite DPJP ' . $tanggal;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function ketepatan_visite_by_imn()
	{
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');

		if ($tampil == 'TGL') {
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan IMN Tahun 2023 (' . date("d F Y", strtotime($date)) . ')';
			$data['date'] = $date;
			$data['judul'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tampil;
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp_imn($date, $tampil)->result();
		} else if ($tampil == 'BLN') {
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan IMN Tahun 2023 (' . date("F Y", strtotime($month)) . ')';
			$data['date'] = $month;
			$data['judul'] = date("F Y", strtotime($month));
			$data['tampil'] = $tampil;
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp_imn($month, $tampil)->result();
		} else {
			$tgl = date('Y-m');
			$data['title'] = 'Jumlah Visite DPJP Berdasarkan IMN Tahun 2023 (' . date("d F Y", strtotime($tgl)) . ')';
			$data['date'] = $tgl;
			$data['judul'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['visite'] = $this->rimlaporan->get_ketepatan_visite_dpjp_imn($tgl, 'TGL')->result();
		}
		$this->load->view('iri/lapketepatan_visite_imn', $data);
	}

	public function excel_ketepatan_visite_imn($date, $tampil)
	{
		if ($tampil == 'TGL') {
			$tanggal = date("d F Y", strtotime($date));
		} else {
			$tanggal = date("F Y", strtotime($date));
		}
		$data = $this->rimlaporan->get_ketepatan_visite_dpjp_imn($date, $tampil)->result();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama DPJP');
		$sheet->mergeCells('C1:D1')
			->getCell('C1')
			->setValue('Panorama Anak');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Panorama Bedah');
		$sheet->mergeCells('G1:H1')
			->getCell('G1')
			->setValue('Panorama Bidan');
		$sheet->mergeCells('I1:J1')
			->getCell('I1')
			->setValue('Irna B L1,2/Singgalang');
		$sheet->mergeCells('K1:L1')
			->getCell('K1')
			->setValue('Irna B L3/Singgalang');
		$sheet->mergeCells('M1:N1')
			->getCell('M1')
			->setValue('Irna C L1/Merapi');
		$sheet->mergeCells('O1:P1')
			->getCell('O1')
			->setValue('Irna C L2/Merapi');
		$sheet->mergeCells('Q1:R1')
			->getCell('Q1')
			->setValue('Irna C L3/Merapi');
		$sheet->mergeCells('S1:T1')
			->getCell('S1')
			->setValue('Limpapeh L2&3');
		$sheet->mergeCells('U1:V1')
			->getCell('U1')
			->setValue('Limpapeh L4');
		$sheet->mergeCells('W1:X1')
			->getCell('W1')
			->setValue('ICU/ICCU');
		$sheet->mergeCells('Y1:Z1')
			->getCell('Y1')
			->setValue('NICU');
		$sheet->mergeCells('AA1:AB1')
			->getCell('AA1')
			->setValue('Jumlah');
		$sheet->mergeCells('AC1:AC2')
			->getCell('AC1')
			->setValue('Total');
		$sheet->mergeCells('AD1:AD2')
			->getCell('AD1')
			->setValue('Hasil');
		$sheet->setCellValue('C2', 'Jam 6 - 14');
		$sheet->setCellValue('D2', '> Jam 14');
		$sheet->setCellValue('E2', 'Jam 6 - 14');
		$sheet->setCellValue('F2', '> Jam 14');
		$sheet->setCellValue('G2', 'Jam 6 - 14');
		$sheet->setCellValue('H2', '> Jam 14');
		$sheet->setCellValue('I2', 'Jam 6 - 14');
		$sheet->setCellValue('J2', '> Jam 14');
		$sheet->setCellValue('K2', 'Jam 6 - 14');
		$sheet->setCellValue('L2', '> Jam 14');
		$sheet->setCellValue('M2', 'Jam 6 - 14');
		$sheet->setCellValue('N2', '> Jam 14');
		$sheet->setCellValue('O2', 'Jam 6 - 14');
		$sheet->setCellValue('P2', '> Jam 14');
		$sheet->setCellValue('Q2', 'Jam 6 - 14');
		$sheet->setCellValue('R2', '> Jam 14');
		$sheet->setCellValue('S2', 'Jam 6 - 14');
		$sheet->setCellValue('T2', '> Jam 14');
		$sheet->setCellValue('U2', 'Jam 6 - 14');
		$sheet->setCellValue('V2', '> Jam 14');
		$sheet->setCellValue('W2', 'Jam 6 - 14');
		$sheet->setCellValue('X2', '> Jam 14');
		$sheet->setCellValue('Y2', 'Jam 6 - 14');
		$sheet->setCellValue('Z2', '> Jam 14');
		$sheet->setCellValue('AA2', 'Jam 6 - 14');
		$sheet->setCellValue('AB2', '> Jam 14');

		$x = 3;
		$no = 1;
		$total_kurang_14_icu = 0;
		$total_lebih_14_icu = 0;
		$total_kurang_14_nicu = 0;
		$total_lebih_14_nicu = 0;
		$total_kurang_14_limpapeh23 = 0;
		$total_lebih_14_limpapeh23 = 0;
		$total_kurang_14_limpapeh4 = 0;
		$total_lebih_14_limpapeh4 = 0;
		$total_kurang_14_anak = 0;
		$total_lebih_14_anak = 0;
		$total_kurang_14_bedah = 0;
		$total_lebih_14_bedah = 0;
		$total_kurang_14_bidan = 0;
		$total_lebih_14_bidan = 0;
		$total_kurang_14_singgalang12 = 0;
		$total_lebih_14_singgalang12 = 0;
		$total_kurang_14_singgalang3 = 0;
		$total_lebih_14_singgalang3 = 0;
		$total_kurang_14_merapi1 = 0;
		$total_lebih_14_merapi1 = 0;
		$total_kurang_14_merapi2 = 0;
		$total_lebih_14_merapi2 = 0;
		$total_kurang_14_merapi3 = 0;
		$total_lebih_14_merapi3 = 0;
		$jumlah_kurang_14 = 0;
		$jumlah_lebih_14 = 0;
		$jumlah = 0;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->nama_pemeriksa);

			$sheet->setCellValue('C' . $x, $row->kurang_14_anak);
			$total_kurang_14_anak += $row->kurang_14_anak;

			$sheet->setCellValue('D' . $x, $row->lebih_14_anak);
			$total_lebih_14_anak += $row->lebih_14_anak;

			$sheet->setCellValue('E' . $x, $row->kurang_14_bedah);
			$total_kurang_14_bedah += $row->kurang_14_bedah;

			$sheet->setCellValue('F' . $x, $row->lebih_14_bedah);
			$total_lebih_14_bedah += $row->lebih_14_bedah;

			$sheet->setCellValue('G' . $x, $row->kurang_14_bidan);
			$total_kurang_14_bidan += $row->kurang_14_bidan;

			$sheet->setCellValue('H' . $x, $row->lebih_14_bidan);
			$total_lebih_14_bidan += $row->lebih_14_bidan;

			$sheet->setCellValue('I' . $x, $row->kurang_14_singgalang12);
			$total_kurang_14_singgalang12 += $row->kurang_14_singgalang12;

			$sheet->setCellValue('J' . $x, $row->lebih_14_singgalang12);
			$total_lebih_14_singgalang12 += $row->lebih_14_singgalang12;

			$sheet->setCellValue('K' . $x, $row->kurang_14_singgalang3);
			$total_kurang_14_singgalang3 += $row->kurang_14_singgalang3;

			$sheet->setCellValue('L' . $x, $row->lebih_14_singgalang3);
			$total_lebih_14_singgalang3 += $row->lebih_14_singgalang3;

			$sheet->setCellValue('M' . $x, $row->kurang_14_merapi1);
			$total_kurang_14_merapi1 += $row->kurang_14_merapi1;

			$sheet->setCellValue('N' . $x, $row->lebih_14_merapi1);
			$total_lebih_14_merapi1 += $row->lebih_14_merapi1;

			$sheet->setCellValue('O' . $x, $row->kurang_14_merapi2);
			$total_kurang_14_merapi2 += $row->kurang_14_merapi2;

			$sheet->setCellValue('P' . $x, $row->lebih_14_merapi2);
			$total_lebih_14_merapi2 += $row->lebih_14_merapi2;

			$sheet->setCellValue('Q' . $x, $row->kurang_14_merapi3);
			$total_kurang_14_merapi3 += $row->kurang_14_merapi3;

			$sheet->setCellValue('R' . $x, $row->lebih_14_merapi3);
			$total_lebih_14_merapi3 += $row->lebih_14_merapi3;

			$sheet->setCellValue('S' . $x, $row->kurang_14_limpapeh23);
			$total_kurang_14_limpapeh23 += $row->kurang_14_limpapeh23;

			$sheet->setCellValue('T' . $x, $row->lebih_14_limpapeh23);
			$total_lebih_14_limpapeh23 += $row->lebih_14_limpapeh23;

			$sheet->setCellValue('U' . $x, $row->kurang_14_limpapeh4);
			$total_kurang_14_limpapeh4 += $row->kurang_14_limpapeh4;

			$sheet->setCellValue('V' . $x, $row->lebih_14_limpapeh4);
			$total_lebih_14_limpapeh4 += $row->lebih_14_limpapeh4;

			$sheet->setCellValue('W' . $x, $row->kurang_14_icu);
			$total_kurang_14_icu += $row->kurang_14_icu;

			$sheet->setCellValue('X' . $x, $row->lebih_14_icu);
			$total_lebih_14_icu += $row->lebih_14_icu;

			$sheet->setCellValue('Y' . $x, $row->kurang_14_nicu);
			$total_kurang_14_nicu += $row->kurang_14_nicu;

			$sheet->setCellValue('Z' . $x, $row->lebih_14_nicu);
			$total_lebih_14_nicu += $row->lebih_14_nicu;

			$sheet->setCellValue('AA' . $x, $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3);
			$total_kurang_14 = $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3;
			$jumlah_kurang_14 += $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3;

			$sheet->setCellValue('AB' . $x, $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3);
			$total_lebih_14 = $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3;
			$jumlah_lebih_14 += $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3;

			$sheet->setCellValue('AC' . $x, $total_kurang_14 + $total_lebih_14);
			$jumlah += $total_kurang_14 + $total_lebih_14;

			$total = $total_kurang_14 + $total_lebih_14;
			if ($total != 0) {
				$hasil = ($total_kurang_14 / $total) * 100;
			} else {
				$hasil = 0;
			}
			$sheet->setCellValue('AD' . $x, round($hasil, 1) . '%');
			$x++;
		}

		$sheet->setCellValue('A' . $x, 'Jumlah');
		$sheet->mergeCells('A' . $x . ':' . 'B' . $x . '');
		$sheet->setCellValue('C' . $x, $total_kurang_14_anak);
		$sheet->setCellValue('D' . $x, $total_lebih_14_anak);
		$sheet->setCellValue('E' . $x, $total_kurang_14_bedah);
		$sheet->setCellValue('F' . $x, $total_lebih_14_bedah);
		$sheet->setCellValue('G' . $x, $total_kurang_14_bidan);
		$sheet->setCellValue('H' . $x, $total_lebih_14_bidan);
		$sheet->setCellValue('I' . $x, $total_kurang_14_singgalang12);
		$sheet->setCellValue('J' . $x, $total_lebih_14_singgalang12);
		$sheet->setCellValue('K' . $x, $total_kurang_14_singgalang3);
		$sheet->setCellValue('L' . $x, $total_lebih_14_singgalang3);
		$sheet->setCellValue('M' . $x, $total_kurang_14_merapi1);
		$sheet->setCellValue('N' . $x, $total_lebih_14_merapi1);
		$sheet->setCellValue('O' . $x, $total_kurang_14_merapi2);
		$sheet->setCellValue('P' . $x, $total_lebih_14_merapi2);
		$sheet->setCellValue('Q' . $x, $total_kurang_14_merapi3);
		$sheet->setCellValue('R' . $x, $total_lebih_14_merapi3);
		$sheet->setCellValue('S' . $x, $total_kurang_14_limpapeh23);
		$sheet->setCellValue('T' . $x, $total_lebih_14_limpapeh23);
		$sheet->setCellValue('U' . $x, $total_kurang_14_limpapeh4);
		$sheet->setCellValue('V' . $x, $total_lebih_14_limpapeh4);
		$sheet->setCellValue('W' . $x, $total_kurang_14_icu);
		$sheet->setCellValue('X' . $x, $total_lebih_14_icu);
		$sheet->setCellValue('Y' . $x, $total_kurang_14_nicu);
		$sheet->setCellValue('Z' . $x, $total_lebih_14_nicu);
		$sheet->setCellValue('AA' . $x, $jumlah_kurang_14);
		$sheet->setCellValue('AB' . $x, $jumlah_lebih_14);
		$sheet->setCellValue('AC' . $x, $jumlah);
		if ($jumlah != 0) {
			$presentase_jumlah = ($jumlah_kurang_14 / $jumlah) * 100;
		} else {
			$presentase_jumlah = 0;
		}
		$sheet->setCellValue('AD' . $x, round($presentase_jumlah, 1) . '%');
		$x++;

		$sheet->setCellValue('A' . $x, 'Hasil Ruangan');
		$sheet->mergeCells('A' . $x . ':' . 'B' . $x . '');

		$sheet->setCellValue('C' . $x, $total_kurang_14_anak + $total_lebih_14_anak);
		$total_anak = $total_kurang_14_anak + $total_lebih_14_anak;
		if ($total_anak != 0) {
			$presentase_anak = ($total_kurang_14_anak / $total_anak) * 100;
		} else {
			$presentase_anak = 0;
		}
		$sheet->setCellValue('D' . $x, round($presentase_anak, 1) . '%');

		$sheet->setCellValue('E' . $x, $total_kurang_14_bedah + $total_lebih_14_bedah);
		$total_bedah = $total_kurang_14_bedah + $total_lebih_14_bedah;
		if ($total_bedah != 0) {
			$presentase_bedah = ($total_kurang_14_bedah / $total_bedah) * 100;
		} else {
			$presentase_bedah = 0;
		}
		$sheet->setCellValue('F' . $x, round($presentase_bedah, 1) . '%');

		$sheet->setCellValue('G' . $x, $total_kurang_14_bidan + $total_lebih_14_bidan);
		$total_bidan = $total_kurang_14_bidan + $total_lebih_14_bidan;
		if ($total_bidan != 0) {
			$presentase_bidan = ($total_kurang_14_bidan / $total_bidan) * 100;
		} else {
			$presentase_bidan = 0;
		}
		$sheet->setCellValue('H' . $x, round($presentase_bidan, 1) . '%');

		$sheet->setCellValue('I' . $x, $total_kurang_14_singgalang12 + $total_lebih_14_singgalang12);
		$total_singgalang12 = $total_kurang_14_singgalang12 + $total_lebih_14_singgalang12;
		if ($total_singgalang12 != 0) {
			$presentase_singgalang12 = ($total_kurang_14_singgalang12 / $total_singgalang12) * 100;
		} else {
			$presentase_singgalang12 = 0;
		}
		$sheet->setCellValue('J' . $x, round($presentase_singgalang12, 1) . '%');

		$sheet->setCellValue('K' . $x, $total_kurang_14_singgalang3 + $total_lebih_14_singgalang3);
		$total_singgalang3 = $total_kurang_14_singgalang3 + $total_lebih_14_singgalang3;
		if ($total_singgalang3 != 0) {
			$presentase_singgalang3 = ($total_kurang_14_singgalang3 / $total_singgalang3) * 100;
		} else {
			$presentase_singgalang3 = 0;
		}
		$sheet->setCellValue('L' . $x, round($presentase_singgalang3, 1) . '%');

		$sheet->setCellValue('M' . $x, $total_kurang_14_merapi1 + $total_lebih_14_merapi1);
		$total_merapi1 = $total_kurang_14_merapi1 + $total_lebih_14_merapi1;
		if ($total_merapi1 != 0) {
			$presentase_merapi1 = ($total_kurang_14_merapi1 / $total_merapi1) * 100;
		} else {
			$presentase_merapi1 = 0;
		}
		$sheet->setCellValue('N' . $x, round($presentase_merapi1, 1) . '%');

		$sheet->setCellValue('O' . $x, $total_kurang_14_merapi2 + $total_lebih_14_merapi2);
		$total_merapi2 = $total_kurang_14_merapi2 + $total_lebih_14_merapi2;
		if ($total_merapi2 != 0) {
			$presentase_merapi2 = ($total_kurang_14_merapi2 / $total_merapi2) * 100;
		} else {
			$presentase_merapi2 = 0;
		}
		$sheet->setCellValue('P' . $x, round($presentase_merapi2, 1) . '%');

		$sheet->setCellValue('Q' . $x, $total_kurang_14_merapi3 + $total_lebih_14_merapi3);
		$total_merapi3 = $total_kurang_14_merapi3 + $total_lebih_14_merapi3;
		if ($total_merapi3 != 0) {
			$presentase_merapi3 = ($total_kurang_14_merapi3 / $total_merapi3) * 100;
		} else {
			$presentase_merapi3 = 0;
		}
		$sheet->setCellValue('R' . $x, round($presentase_merapi3, 1) . '%');

		$sheet->setCellValue('S' . $x, $total_kurang_14_limpapeh23 + $total_lebih_14_limpapeh23);
		$total_limpapeh23 = $total_kurang_14_limpapeh23 + $total_lebih_14_limpapeh23;
		if ($total_limpapeh23 != 0) {
			$presentase_limpapeh23 = ($total_kurang_14_limpapeh23 / $total_limpapeh23) * 100;
		} else {
			$presentase_limpapeh23 = 0;
		}
		$sheet->setCellValue('T' . $x, round($presentase_limpapeh23, 1) . '%');

		$sheet->setCellValue('U' . $x, $total_kurang_14_limpapeh4 + $total_lebih_14_limpapeh4);
		$total_limpapeh4 = $total_kurang_14_limpapeh4 + $total_lebih_14_limpapeh4;
		if ($total_limpapeh4 != 0) {
			$presentase_limpapeh4 = ($total_kurang_14_limpapeh4 / $total_limpapeh4) * 100;
		} else {
			$presentase_limpapeh4 = 0;
		}
		$sheet->setCellValue('V' . $x, round($presentase_limpapeh4, 1) . '%');

		$sheet->setCellValue('W' . $x, $total_kurang_14_icu + $total_lebih_14_icu);
		$total_icu = $total_kurang_14_icu + $total_lebih_14_icu;
		if ($total_icu != 0) {
			$presentase_icu = ($total_kurang_14_icu / $total_icu) * 100;
		} else {
			$presentase_icu = 0;
		}
		$sheet->setCellValue('X' . $x, round($presentase_icu, 1) . '%');

		$sheet->setCellValue('Y' . $x, $total_kurang_14_nicu + $total_lebih_14_nicu);
		$total_nicu = $total_kurang_14_nicu + $total_lebih_14_nicu;
		if ($total_nicu != 0) {
			$presentase_nicu = ($total_kurang_14_nicu / $total_nicu) * 100;
		} else {
			$presentase_nicu = 0;
		}
		$sheet->setCellValue('Z' . $x, round($presentase_nicu, 1) . '%');
		$sheet->setCellValue('AA' . $x, '');
		$sheet->setCellValue('AB' . $x, '');
		$sheet->setCellValue('AC' . $x, '');
		$sheet->setCellValue('AD' . $x, '');

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Ketepatan Visite DPJP Bulan ' . $tanggal;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function umpan_balik()
	{
		$data['title'] = 'Input Data Umpan Balik Klaim BPJS';
		$data['bulan'] = $this->rimlaporan->get_bulan_pertahun()->result();

		$this->load->view('iri/umpan_balik', $data);
	}

	public function umbal_exe()
	{
		$this->load->helper('file');

		/* Allowed MIME(s) File */
		$file_mimes = array(
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		if (isset($_FILES['uploadFile']['name']) && in_array($_FILES['uploadFile']['type'], $file_mimes)) {

			$array_file = explode('.', $_FILES['uploadFile']['name']);
			$extension  = end($array_file);

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
			$sheet_data = $spreadsheet->getActiveSheet(0)->toArray();
			$array_data  = [];

			$monthClaim = explode("-", $this->input->post('bulan_pelayanan'));
			$numMonth = sprintf("%02d", $monthClaim[0]);
			$checkTahap = $this->rimlaporan->check_data_umbal($monthClaim[1], $this->input->post('periode'), $this->input->post('objek_klaim'), $this->input->post('tahun'))->result();
			// var_dump($checkTahap);die();
			if ($checkTahap) {
				for ($i = 1; $i < count($sheet_data); $i++) {
					if ($sheet_data[$i]['1'] != '') {
						$data['no_sep'] = $sheet_data[$i]['1'];
						$data['tgl_verif'] = date('Y-m-d H:i:s', strtotime($sheet_data[$i]['2']));
						$data['ril_rs'] = str_replace(array('.', ','), '',  $sheet_data[$i]['3']);
						// $data['ril_rs'] = str_replace('.', '', $sheet_data[$i]['3']);
						$data['diajukan'] = str_replace(array('.', ','), '',  $sheet_data[$i]['4']);
						// $data['diajukan'] = str_replace('.', '', $sheet_data[$i]['4']);
						$data['disetujui'] = str_replace(array('.', ','), '',  $sheet_data[$i]['5']);
						// $data['disetujui'] = str_replace('.', '', $sheet_data[$i]['5']);
						$data['tahun'] = $this->input->post('tahun');
						$data['bulan'] = $monthClaim[1];
						$data['bln_klaim'] = $numMonth;
						$data['periode_umbal'] = 'Klaim ' . $monthClaim[1] . ' ' . $this->input->post('periode');
						$data['periode'] = $this->input->post('periode');
						$data['objek'] = $this->input->post('objek_klaim');
						$data['xcreate'] = date('Y-m-d H:i:s');
						$this->rimlaporan->update_umbal($data, $monthClaim[1], $this->input->post('periode'), $this->input->post('objek_klaim'), $this->input->post('tahun'));
					}
				}

				$this->session->set_flashdata(
					'pesan',
					"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<span style=\"font-size:30px;color:green\"></i> Data Berhasil Diupdate ! </span>
				</div>"
				);
			} else {
				for ($i = 1; $i < count($sheet_data); $i++) {
					if ($sheet_data[$i]['1'] != '') {
						$data['no_sep'] = $sheet_data[$i]['1'];
						$data['tgl_verif'] = date('Y-m-d H:i:s', strtotime($sheet_data[$i]['2']));
						$data['ril_rs'] = str_replace(array('.', ','), '',  $sheet_data[$i]['3']);
						// $data['ril_rs'] = str_replace('.', '', $sheet_data[$i]['3']);
						$data['diajukan'] = str_replace(array('.', ','), '',  $sheet_data[$i]['4']);
						// $data['diajukan'] = str_replace('.', '', $sheet_data[$i]['4']);
						$data['disetujui'] = str_replace(array('.', ','), '',  $sheet_data[$i]['5']);
						// $data['disetujui'] = str_replace('.', '', $sheet_data[$i]['5']);
						$data['tahun'] = $this->input->post('tahun');
						$data['bulan'] = $monthClaim[1];
						$data['bln_klaim'] = $numMonth;
						$data['periode_umbal'] = 'Klaim ' . $monthClaim[1] . ' ' . $this->input->post('periode');
						$data['periode'] = $this->input->post('periode');
						$data['objek'] = $this->input->post('objek_klaim');
						$data['xcreate'] = date('Y-m-d H:i:s');
						$this->rimlaporan->insert_umbal($data);
					}
				}

				$this->session->set_flashdata(
					'pesan',
					"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<span style=\"font-size:30px;color:green\"></i> Data Berhasil Diinput ! </span>
				</div>"
				);
			}
			redirect('iri/riclaporan/umpan_balik');
		} else {
			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:red\"></i> Data Gagal Diinput ! </span>
			</div>"
			);
			redirect('iri/riclaporan/umpan_balik');
		}
	}

	public function update_cppt_verif_dokter()
	{
		$data = $this->rimlaporan->get_data_verif_dokter()->result();

		// foreach($data as $row) {
		// 	$data['id_pjp'] = $row->id_dokter;
		// 	$data['nama_pjp'] = $row->dokter;
		// 	$data['tgl_acc_pjp'] = $row->tgl_keluar;

		// 	$this->rimlaporan->update_cppt_verif_dokter($row->no_ipd, $data);
		// }

		foreach ($data as $row) {
			$this->rimlaporan->update_cppt_verif_dokter2($row->no_ipd, $row->id_dokter, $row->dokter, $row->tgl_keluar);
		}

		redirect('iri/Ricpasien');
	}

	public function lap_kegiatan_mpp()
	{
		$data['petugas'] = $this->rimlaporan->get_list_petugas_mpp()->result();
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil_per = $this->input->post('tampil_per');
		$petugas = $this->input->post('petugas');

		if ($tampil_per == 'TGL') {
			if ($petugas == 'semua') {
				$data['nama_petugas'] = 'SEMUA Petugas';
			} else {
				$data['nama_petugas'] = explode("-", $petugas)[1];
			}
			$data['title'] = 'Laporan Kegiatan Manejer Pelayanan Pasien | ' . date("d F Y", strtotime($date));
			$data['date'] = date("d F Y", strtotime($date));
			$data['tanggal'] = $date;
			$data['tampil'] = $tampil_per;
			$data['petugas_mpp'] = $petugas;
			$data['lap_mpp'] = $this->rimlaporan->get_lap_kegiatan_mpp_pasien('TGL', $date, $petugas)->result();
		} else if ($tampil_per == 'BLN') {
			if ($petugas == 'semua') {
				$data['nama_petugas'] = 'SEMUA Petugas';
			} else {
				$data['nama_petugas'] = explode("-", $petugas)[1];
			}
			$data['title'] = 'Laporan Kegiatan Manejer Pelayanan Pasien | ' . date("F Y", strtotime($month));
			$data['date'] = date("F Y", strtotime($month));
			$data['tanggal'] = $month;
			$data['tampil'] = $tampil_per;
			$data['petugas_mpp'] = $petugas;
			$data['lap_mpp'] = $this->rimlaporan->get_lap_kegiatan_mpp_pasien('BLN', $month, $petugas)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['nama_petugas'] = 'SEMUA Petugas';
			$data['title'] = 'Laporan Kegiatan Manejer Pelayanan Pasien | ' . date("d F Y", strtotime($tgl));
			$data['date'] = date("d F Y", strtotime($tgl));
			$data['tanggal'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['petugas_mpp'] = 'semua';
			$data['lap_mpp'] = $this->rimlaporan->get_lap_kegiatan_mpp_pasien('TGL', $tgl, 'semua')->result();
		}
		$this->load->view('iri/lap_kegiatan_mpp', $data);
	}

	public function excel_lap_kegiatan_mpp($tampil, $date, $petugas)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama');
		$sheet->setCellValue('C1', 'No RM');
		$sheet->setCellValue('D1', 'Diagnosa');
		$sheet->setCellValue('E1', 'Tgl Masuk');
		$sheet->setCellValue('F1', 'Tgl Keluar');
		$sheet->setCellValue('G1', 'Formulir');
		$sheet->setCellValue('H1', 'Ruangan');
		$sheet->setCellValue('I1', 'Petugas MPP');
		$sheet->setCellValue('J1', 'Ket');

		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_kegiatan_mpp_pasien('TGL', $date, $petugas)->result();
		} else {
			$tgl = date("F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_kegiatan_mpp_pasien('BLN', $date, $petugas)->result();
		}

		if ($petugas == 'semua') {
			$nama_petugas = 'SEMUA Petugas';
		} else {
			$nama_petugas = explode("-", $petugas)[1];
		}

		$i = 1;
		$x = 2;

		foreach ($data as $row) {
			$mpp = isset($row->formjson) ? json_decode($row->formjson) : null;

			$sheet->setCellValue('A' . $x, $i++);
			$sheet->setCellValue('B' . $x, $row->nama);
			$sheet->setCellValue('C' . $x, $row->no_medrec);
			$sheet->setCellValue('D' . $x, $mpp->diagnosa);
			$sheet->setCellValue('E' . $x, date("d-m-Y", strtotime($row->tgl_masuk)));
			$sheet->setCellValue('F' . $x, date("d-m-Y", strtotime($row->tgl_keluar)));
			$sheet->setCellValue('G' . $x, 'Form A');
			$sheet->setCellValue('H' . $x, $row->nmruang);
			$sheet->setCellValue('I' . $x, $row->petugas_mpp);
			$sheet->setCellValue('J' . $x, $row->keadaanpulang);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kegiatan Manejer Pelayanan Pasien ' . $tgl . ' (' . $nama_petugas . ')';
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_tindakan_gizi()
	{
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil_per = $this->input->post('tampil_per');

		if ($tampil_per == 'TGL') {
			$data['title'] = 'Laporan Tindakan Gizi | ' . date("d F Y", strtotime($date));
			$data['date'] = date("d F Y", strtotime($date));
			$data['tanggal'] = $date;
			$data['tampil'] = $tampil_per;
			$data['tindakan_gizi'] = $this->rimlaporan->get_lap_tindakan_gizi('TGL', $date)->result();
		} else if ($tampil_per == 'BLN') {
			$data['title'] = 'Laporan Tindakan Gizi | ' . date("F Y", strtotime($month));
			$data['date'] = date("F Y", strtotime($month));
			$data['tanggal'] = $month;
			$data['tampil'] = $tampil_per;
			$data['tindakan_gizi'] = $this->rimlaporan->get_lap_tindakan_gizi('BLN', $month)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Tindakan Gizi | ' . date("d F Y", strtotime($tgl));
			$data['date'] = date("d F Y", strtotime($tgl));
			$data['tanggal'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['tindakan_gizi'] = $this->rimlaporan->get_lap_tindakan_gizi('TGL', $tgl)->result();
		}
		$this->load->view('iri/lap_tindakan_gizi', $data);
	}

	public function excel_lap_tindakan_gizi($tampil, $date)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No RM');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Kelamin');
		$sheet->setCellValue('E1', 'Jaminan');
		$sheet->setCellValue('F1', 'Ruangan');
		$sheet->setCellValue('G1', 'Kelas');
		$sheet->setCellValue('H1', 'Jenis Tindakan');
		$sheet->setCellValue('I1', 'QTY');
		$sheet->setCellValue('J1', 'Tarif');
		$sheet->setCellValue('K1', 'Tgl Konsul');
		$sheet->setCellValue('L1', 'Edukasi yg diberikan');
		$sheet->setCellValue('M1', 'Petugas');

		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_tindakan_gizi('TGL', $date)->result();
		} else {
			$tgl = date("F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_tindakan_gizi('BLN', $date)->result();
		}

		$i = 1;
		$x = 2;

		foreach ($data as $row) {
			$asuhan = isset($row->json) ? json_decode($row->json) : null;

			$sheet->setCellValue('A' . $x, $i++);
			$sheet->setCellValue('B' . $x, $row->no_medrec);
			$sheet->setCellValue('C' . $x, $row->nama);
			$sheet->setCellValue('D' . $x, $row->sex);
			$sheet->setCellValue('E' . $x, $row->carabayar);
			$sheet->setCellValue('F' . $x, $row->ruangan);
			$sheet->setCellValue('G' . $x, $row->kelas);
			$sheet->setCellValue('H' . $x, $row->nmtindakan);
			$sheet->setCellValue('I' . $x, $row->jumlah_tindakan);
			$sheet->setCellValue('J' . $x, $row->tumuminap);
			$sheet->setCellValue('K' . $x, date("d-m-Y", strtotime($row->tanggal)));
			$sheet->setCellValue('L' . $x, isset($asuhan->kebutuhan_gizi->diit) ? $asuhan->kebutuhan_gizi->diit : '');
			$sheet->setCellValue('M' . $x, $row->petugas);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Tindakan Gizi ' . $tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_porsi_makanan_gizi()
	{
		$month = $this->input->post('date_months');

		if ($month != '') {
			$data['title'] = 'Laporan Porsi Makanan Tindakan Gizi ' . date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['judul'] = date("F Y", strtotime($month));
			$data['porsi'] = $this->rimlaporan->get_lap_porsi_makanan_gizi($month)->result();
		} else {
			$bln = date('Y-m');
			$data['title'] = 'Laporan Porsi Makanan Tindakan Gizi ' . date("F Y", strtotime($bln));
			$data['date'] = $bln;
			$data['judul'] = date("F Y", strtotime($bln));
			$data['porsi'] = $this->rimlaporan->get_lap_porsi_makanan_gizi($bln)->result();
		}

		$this->load->view('iri/lap_porsi_makanan', $data);
	}

	public function excel_lap_porsi_gizi($date)
	{
		$tgl = date("F Y", strtotime($date));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Kelas Rawatan');
		$sheet->mergeCells('C1:F1')
			->getCell('C1')
			->setValue('Jaminan');
		$sheet->setCellValue('C2', 'BPJS');
		$sheet->setCellValue('D2', 'UMUM');
		$sheet->setCellValue('E2', 'IKS');
		$sheet->setCellValue('F2', 'Total');

		$data = $this->rimlaporan->get_lap_porsi_makanan_gizi($date)->result();

		$i = 1;
		$x = 3;

		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $i++);
			$sheet->setCellValue('B' . $x, $row->kelas);
			$sheet->setCellValue('C' . $x, $row->tgl_bpjs * 3);
			$sheet->setCellValue('D' . $x, $row->tgl_umum * 3);
			$sheet->setCellValue('E' . $x, $row->tgl_iks * 3);
			$sheet->setCellValue('F' . $x, ($row->tgl_bpjs + $row->tgl_umum + $row->tgl_iks) * 3);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Porsi Makanan Tindakan Gizi ' . $tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_pasien_pulang_rawat_inap()
	{
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil_per = $this->input->post('tampil_per');

		if ($tampil_per == 'TGL') {
			$data['title'] = 'Laporan Pasien Pulang RI | ' . date("d F Y", strtotime($date));
			$data['date'] = date("d F Y", strtotime($date));
			$data['tanggal'] = $date;
			$data['tampil'] = $tampil_per;
			$data['laporan'] = $this->rimlaporan->get_lap_pasien_pulang_v2('TGL', $date)->result();
		} else if ($tampil_per == 'BLN') {
			$data['title'] = 'Laporan Pasien Pulang RI | ' . date("F Y", strtotime($month));
			$data['date'] = date("F Y", strtotime($month));
			$data['tanggal'] = $month;
			$data['tampil'] = $tampil_per;
			$data['laporan'] = $this->rimlaporan->get_lap_pasien_pulang_v2('BLN', $month)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Pasien Pulang RI | ' . date("d F Y", strtotime($tgl));
			$data['date'] = date("d F Y", strtotime($tgl));
			$data['tanggal'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['laporan'] = $this->rimlaporan->get_lap_pasien_pulang_v2('TGL', $tgl)->result();
		}
		$this->load->view('iri/lap_pasien_pulang_v2', $data);
	}

	public function excel_lap_pasien_pulang_rawat_inap_v2($tampil, $date)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', "No Register");
		$sheet->setCellValue('C1', 'No RM');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Jenis Kelamin');
		$sheet->setCellValue('F1', 'Alamat Kota');
		$sheet->setCellValue('G1', 'Jaminan');
		$sheet->setCellValue('H1', 'Ruangan');
		$sheet->setCellValue('I1', 'Kelas');
		$sheet->setCellValue('J1', 'Jatah Kelas');
		$sheet->setCellValue('K1', 'DPJP Utama');
		$sheet->setCellValue('L1', 'Diagnosa Masuk');
		$sheet->setCellValue('M1', 'Ket Tempat Tidur');
		$sheet->setCellValue('N1', 'Waktu Daftar RI');
		$sheet->setCellValue('O1', 'Waktu Diterima Petugas RI');
		$sheet->setCellValue('P1', 'Tgl Masuk');
		$sheet->setCellValue('Q1', 'Tgl Perencanaan Pemulangan Pasien');
		$sheet->setCellValue('R1', 'Tgl Keluar');
		$sheet->setCellValue('S1', 'Pintu Masuk');

		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_pasien_pulang_v2('TGL', $date)->result();
		} else {
			$tgl = date("F Y", strtotime($date));
			$data = $this->rimlaporan->get_lap_pasien_pulang_v2('BLN', $date)->result();
		}

		$no = 1;
		$x = 2;

		foreach ($data as $row) {
			$rencana_pulang = isset($row->formjson) ? json_decode($row->formjson) : null;

			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_ipd);
			$sheet->setCellValue('C' . $x, $row->no_medrec);
			$sheet->setCellValue('D' . $x, $row->nama);

			if ($row->sex == 'P') {
				$sheet->setCellValue('E' . $x, 'Perempuan');
			} else {
				$sheet->setCellValue('E' . $x, 'Laki Laki');
			}

			$sheet->setCellValue('F' . $x, $row->kotakabupaten);
			$sheet->setCellValue('G' . $x, $row->carabayar);
			$sheet->setCellValue('H' . $x, $row->nmruang);
			$sheet->setCellValue('I' . $x, $row->klsiri);
			$sheet->setCellValue('J' . $x, $row->jatahklsiri);
			$sheet->setCellValue('K' . $x, $row->dokter);
			$sheet->setCellValue('L' . $x, $row->nm_diagnosa);

			if ($row->titip == '1') {
				$titip = 'Titip : YA';
			} else {
				$titip = 'Titip : Tidak';
			}

			if ($row->selisih_tarif == 1) {
				$selisih = 'Selisih Tarif : YA';
			} else {
				$selisih = 'Selisih Tarif : Tidak';
			}

			$sheet->setCellValue('M' . $x, $titip . "\n " . $selisih);
			$sheet->getStyle('M' . $x)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('N' . $x, date("d-m-Y", strtotime($row->tgldaftarri)));

			if ($row->wkt_masuk_rg != '') {
				$sheet->setCellValue('O' . $x, date("d-m-Y", strtotime($row->wkt_masuk_rg)));
			} else {
				$sheet->setCellValue('O' . $x, '');
			}

			$sheet->setCellValue('P' . $x, date("d-m-Y", strtotime($row->tgl_masuk)));
			$sheet->setCellValue('Q' . $x, isset($rencana_pulang->tanggal_perencanaan_pemulangan) ? date("d-m-Y", strtotime($rencana_pulang->tanggal_perencanaan_pemulangan)) : '');
			$sheet->setCellValue('R' . $x, date("d-m-Y", strtotime($row->tgl_keluar)));
			$sheet->setCellValue('S' . $x, $row->nm_poli);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pasien Pulang RI ' . $tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function list_tindakan()
	{
		$data['list_ruang'] = $this->rimlaporan->get_ruang_active_non_ok()->result();
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');
		$ruang = $this->input->post('ruang');

		if ($tampil == 'TGL') {
			$data['title'] = 'Laporan Tindakan Rawat Inap ' . date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tampil;
			$data['date'] = $date;
			if ($ruang == 'semua') {
				$data['nmruang'] = '(SEMUA Ruang)';
				$idrg = 'semua';
				$data['idrg'] = $idrg;
			} else {
				$data['nmruang'] = '(' . explode("-", $ruang)[1] . ')';
				$idrg = explode("-", $ruang)[0];
				$data['idrg'] = $idrg;
			}
			$data['tindakan'] = $this->rimlaporan->get_lap_list_tindakan($date, $tampil, $idrg)->result();
		} else if ($tampil == 'BLN') {
			$data['title'] = 'Laporan Tindakan Rawat Inap ' . date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['tampil'] = $tampil;
			$data['date'] = $month;
			if ($ruang == 'semua') {
				$data['nmruang'] = '(SEMUA Ruang)';
				$idrg = 'semua';
				$data['idrg'] = $idrg;
			} else {
				$data['nmruang'] = '(' . explode("-", $ruang)[1] . ')';
				$idrg = explode("-", $ruang)[0];
				$data['idrg'] = $idrg;
			}
			$data['tindakan'] = $this->rimlaporan->get_lap_list_tindakan($month, $tampil, $idrg)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Tindakan Rawat Inap ' . date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['date'] = $tgl;
			$data['nmruang'] = '(SEMUA Ruang)';
			$idrg = 'semua';
			$data['idrg'] = $idrg;
			$data['tindakan'] = $this->rimlaporan->get_lap_list_tindakan($tgl, 'TGL', 'semua')->result();
		}

		$this->load->view('iri/lap_list_tindakan', $data);
	}

	public function excel_list_tindakan($date, $tampil, $idrg)
	{
		if ($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
			if ($idrg == 'semua') {
				$nmruang = '(SEMUA Ruang)';
			} else {
				$nmruang = $this->rimlaporan->get_nm_ruang($idrg)->row()->nmruang;
			}
		} else {
			$tgl = date("F Y", strtotime($date));
			if ($idrg == 'semua') {
				$nmruang = '(SEMUA Ruang)';
			} else {
				$nmruang = $this->rimlaporan->get_nm_ruang($idrg)->row()->nmruang;
			}
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Nama Tindakan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Ruangan');
		$sheet->mergeCells('D1:D2')
			->getCell('D1')
			->setValue('Kelas');
		$sheet->mergeCells('E1:E2')
			->getCell('E1')
			->setValue('Tarif RS');
		$sheet->mergeCells('F1:I1')
			->getCell('F1')
			->setValue('Kelompok Jaminan');
		$sheet->mergeCells('J1:J2')
			->getCell('J1')
			->setValue('Total Pendapatan');
		$sheet->setCellValue('F2', 'BPJS');
		$sheet->setCellValue('G2', 'UMUM');
		$sheet->setCellValue('H2', 'IKS');
		$sheet->setCellValue('I2', 'Total');

		$data = $this->rimlaporan->get_lap_list_tindakan($date, $tampil, $idrg)->result();

		$no = 1;
		$x = 3;
		$total_bpjs = 0;
		$total_umum = 0;
		$total_iks = 0;
		$total = 0;
		$tarif_rs = 0;
		$total_tarif = 0;

		foreach ($data as $row) {
			$total_bpjs += $row->bpjs;
			$total_umum += $row->umum;
			$total_iks += $row->iks;
			$total += $row->bpjs + $row->umum + $row->iks;
			$tarif_rs += $row->tarif_rs;
			$total_tarif += ($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs;

			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->nmtindakan);
			$sheet->setCellValue('C' . $x, $row->nmruang);
			$sheet->setCellValue('D' . $x, $row->kelas);
			$sheet->setCellValue('E' . $x, number_format($row->tarif_rs));
			$sheet->setCellValue('F' . $x, $row->bpjs);
			$sheet->setCellValue('G' . $x, $row->umum);
			$sheet->setCellValue('H' . $x, $row->iks);
			$sheet->setCellValue('I' . $x, $row->bpjs + $row->umum + $row->iks);
			$sheet->setCellValue('J' . $x, number_format(($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs));
			$x++;
		}

		$sheet->setCellValue('A' . $x, 'Grand Total');
		$sheet->mergeCells('A' . $x . ':' . 'D' . $x . '');
		$sheet->setCellValue('E' . $x, number_format($tarif_rs));
		$sheet->setCellValue('F' . $x, $total_bpjs);
		$sheet->setCellValue('G' . $x, $total_umum);
		$sheet->setCellValue('H' . $x, $total_iks);
		$sheet->setCellValue('I' . $x, $total);
		$sheet->setCellValue('J' . $x, number_format($total_tarif));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Tindakan Rawat Inap ' . $tgl . ' (' . $nmruang . ')';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function list_dokter_ruangan_jaga()
	{
		$data['dokter_umum'] = $this->rimlaporan->get_dokter_umum()->result();
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');
		$dokter = $this->input->post('id_dokter');

		if ($this->input->post()) {
			if ($tampil == 'TGL') {
				$data['title'] = 'Laporan Pasien Dokter Ruangan/Dokter Jaga IGD ' . date("d F Y", strtotime($date));
				$data['date_title'] = date("d F Y", strtotime($date));
				$data['tampil'] = $tampil;
				$data['date'] = $date;
				if ($dokter == 'semua') {
					$data['nmdokter'] = '(SEMUA Dokter)';
					$id_dokter = 'semua';
					$data['id_dokter'] = $id_dokter;
				} else {
					$data['nmdokter'] = '(' . explode("-", $dokter)[1] . ')';
					$id_dokter = explode("-", $dokter)[0];
					$data['id_dokter'] = $id_dokter;
				}
				$data['list_dokter'] = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($date, $tampil, $id_dokter)->result();
			} else if ($tampil == 'BLN') {
				$data['title'] = 'Laporan Pasien Dokter Ruangan/Dokter Jaga IGD ' . date("F Y", strtotime($month));
				$data['date_title'] = date("F Y", strtotime($month));
				$data['tampil'] = $tampil;
				$data['date'] = $month;
				if ($dokter == 'semua') {
					$data['nmdokter'] = '(SEMUA Dokter)';
					$id_dokter = 'semua';
					$data['id_dokter'] = $id_dokter;
				} else {
					$data['nmdokter'] = '(' . explode("-", $dokter)[1] . ')';
					$id_dokter = explode("-", $dokter)[0];
					$data['id_dokter'] = $id_dokter;
				}
				// $data['list_dokter'] = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($month, $tampil, $id_dokter)->result();
				$data['list_dokter'] = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($month, $tampil, $id_dokter)->result();
			} else {
				$tgl = date('Y-m-d');
				$data['title'] = 'Laporan Pasien Dokter Ruangan/Dokter Jaga IGD ' . date("d F Y", strtotime($tgl));
				$data['date_title'] = date("d F Y", strtotime($tgl));
				$data['tampil'] = 'TGL';
				$data['date'] = $tgl;
				$data['nmdokter'] = '(SEMUA Dokter)';
				$data['id_dokter'] = 'semua';
				// $data['list_dokter'] = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($date, 'TGL', 'semua')->result();
				$data['list_dokter'] = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($date, $tampil, $id_dokter)->result();
			}
		} else {
			$data['title'] = 'Laporan Pasien Dokter Ruangan/Dokter Jaga IGD ';
			$data['list_dokter'] = array();
			$data['date_title'] = '';
			$data['nmdokter'] = '';
			$data['id_dokter'] = '';
			$data['tampil'] = '';
		}



		$this->load->view('iri/list_dokter_ruangan_jaga', $data);
	}

	public function laporan_rekapitulasi_kinerja()
	{
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');

		if ($tampil == 'TGL') {
			$data['title'] = 'LAPORAN REKAPITULASI KINERJA DOKTER UMUM RS. OTAK DR. Drs. M. HATTA BUKITTINGI ' . date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tampil;
			$data['date'] = $date;
			$data['list_dokter'] = $this->rimlaporan->get_lap_rekapitulasi_kinerja_dokter_igd($date, $tampil)->result();
		} else if ($tampil == 'BLN') {
			$data['title'] = 'LAPORAN REKAPITULASI KINERJA DOKTER UMUM RS. OTAK DR. Drs. M. HATTA BUKITTINGI ' . date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['tampil'] = $tampil;
			$data['date'] = $month;
			$data['list_dokter'] = $this->rimlaporan->get_lap_rekapitulasi_kinerja_dokter_igd($month, $tampil)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'LAPORAN REKAPITULASI KINERJA DOKTER UMUM RS. OTAK DR. Drs. M. HATTA BUKITTINGI ' . date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['date'] = $tgl;
			$data['list_dokter'] = $this->rimlaporan->get_lap_rekapitulasi_kinerja_dokter_igd($tgl, 'TGL')->result();
		}

		$this->load->view('iri/laporan_rekapitulasi_kinerja', $data);
	}

	public function excel_list_dokter_ruangan_jaga($date, $tampil, $id_dokter)
	{
		$data_kunjungan = $this->rimlaporan->get_lap_list_dokter_ruang_jaga($date, $tampil, $id_dokter)->result();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A4', 'No');
		$sheet->setCellValue('B4', 'No RM');
		$sheet->setCellValue('C4', 'Tgl Input');
		$sheet->setCellValue('D4', 'Nama');
		$sheet->setCellValue('E4', 'Kelamin');
		$sheet->setCellValue('F4', 'Jaminan');
		$sheet->setCellValue('G4', 'Ruangan');
		$sheet->setCellValue('H4', 'Kelas');
		$sheet->setCellValue('I4', 'Asuhan Medis Dalam Bentuk SOAP Yg Dilakukan');
		$sheet->setCellValue('J4', 'Pengkajian Awal Medis');
		$sheet->setCellValue('K4', 'Pasien Pulang yang Dientrikan Diagnosis');
		$sheet->setCellValue('L4', 'Melakukan Tindakn Emergency');
		$sheet->setCellValue('M4', 'Kelengkapan Rekam Medis');
		$sheet->setCellValue('N4', 'Kepatuhan Pelaksanaan Tebak');
		$sheet->setCellValue('O4', 'Respon Tim Sisrute >= 1 Jam');
		$sheet->setCellValue('P4', 'Petugas');
		$sheet->setCellValue('Q4', 'Tgl Masuk');
		$sheet->setCellValue('R4', 'Tgl Keluar');

		$no = 1;
		$x = 5;

		foreach ($data_kunjungan as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->no_medrec);
			$sheet->setCellValue('C' . $x, $row->tgl);
			$sheet->setCellValue('D' . $x, $row->nama);
			$sheet->setCellValue('E' . $x, $row->sex);
			$sheet->setCellValue('F' . $x, $row->carabayar);
			$ruang = explode("@", $row->nm_ruang);
			if (isset($ruang[1])) {
				$ruangan = $ruang[1];
			} else {
				$ruang2 = explode("-", $row->nm_ruang);
				if (isset($ruang2[1])) {
					$ruangan = $ruang2[1];
				} else {
					$ruangan = $row->nm_ruang;
				}
			}
			$sheet->setCellValue('G' . $x, $ruangan);
			$sheet->setCellValue('H' . $x, $row->klsiri);
			if ($row->soap >= 1) {
				$sheet->setCellValue('I' . $x, 'Ada');
			} else {
				$sheet->setCellValue('I' . $x, 'Tidak');
			}

			if ($row->medis >= 1) {
				$sheet->setCellValue('J' . $x, 'Ada');
			} else {
				$sheet->setCellValue('J' . $x, 'Tidak');
			}

			if ($row->diagnosa >= 1) {
				$sheet->setCellValue('K' . $x, 'Ada');
			} else {
				$sheet->setCellValue('K' . $x, 'Tidak');
			}

			if ($row->soap_emergency >= 1) {
				$sheet->setCellValue('L' . $x, 'Ada');
			} else {
				$sheet->setCellValue('L' . $x, 'Tidak');
			}

			if ($row->rm >= 1) {
				$sheet->setCellValue('M' . $x, 'Ada');
			} else {
				$sheet->setCellValue('M' . $x, 'Tidak');
			}

			if ($row->tebak >= 1) {
				$sheet->setCellValue('N' . $x, 'Ada');
			} else {
				$sheet->setCellValue('N' . $x, 'Tidak');
			}

			if ($row->sisrute >= 1) {
				$sheet->setCellValue('O' . $x, 'Ada');
			} else {
				$sheet->setCellValue('O' . $x, 'Tidak');
			}

			$sheet->setCellValue('P' . $x, $row->petugas);
			$sheet->setCellValue('Q' . $x, date('d-m-Y', strtotime($row->tgl_masuk)));
			$sheet->setCellValue('R' . $x, date('d-m-Y', strtotime($row->tgl_keluar)));
			$x++;
		}



		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pasien Dokter Ruangan / Dokter Jaga IGD ' . ' ' . $date;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_realisasi_potensi_bpjs()
	{
		$month = $this->input->post('date_months');
		$object = $this->input->post('object_claim');

		if (!empty($month)) {
			$data['title'] = 'Laporan Realisasi dan Potensi Pendapatan BPJS ' . date("F Y", strtotime($month));
			$objectClaim = explode("-", $object);
			$data['date_title'] = $objectClaim[1] . ' ' . date("F Y", strtotime($month));
			$data['object'] = $objectClaim[0];
			$data['date'] = $month;
			$data['potensi_bpjs'] = $this->rimlaporan->get_realisasi_potensi_pendapatan_bpjs($objectClaim[0], $month)->result();
			$data['countSep'] = $this->rimlaporan->get_count_sep($month, $objectClaim[0])->row()->count;
			$data['noregBelumClaim'] = $this->rimlaporan->get_noreg_sep_belum_claim($month, $objectClaim[0])->result();
		} else {
			$data['title'] = 'Laporan Realisasi dan Potensi Pendapatan BPJS ' . date("F Y", strtotime(date('Y-m')));
			$data['date_title'] = 'Rawat Inap ' . date("F Y", strtotime(date('Y-m')));
			$data['object'] = 'RI';
			$data['date'] = date('Y-m');
			$data['potensi_bpjs'] = $this->rimlaporan->get_realisasi_potensi_pendapatan_bpjs('RI', date('Y-m'))->result();
			$data['countSep'] = $this->rimlaporan->get_count_sep(date('Y-m'), 'RI')->row()->count;
			$data['noregBelumClaim'] = $this->rimlaporan->get_noreg_sep_belum_claim(date('Y-m'), 'RI')->result();
		}

		$this->load->view('iri/laprealisasi_potensi_bpjs', $data);
		set_time_limit(300);
	}

	public function excel_lap_realisasi_potensi_bpjs($object, $date)
	{
		if ($object == 'RI') {
			$title = 'Rawat Inap ' . date("F Y", strtotime($date));
		} else {
			$title = 'Rawat Jalan ' . date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Realisasi dan Potensi Pendapatan')->getStyle('A1')->getFont()->setBold(true);;
		$sheet->setCellValue('B1', 'Rill RS')->getStyle('B1')->getFont()->setBold(true);;
		$sheet->setCellValue('C1', 'RIll RS versi umbal')->getStyle('C1')->getFont()->setBold(true);;
		$sheet->setCellValue('D1', 'Klaim Diajukan')->getStyle('D1')->getFont()->setBold(true);;
		$sheet->setCellValue('E1', 'Umbal Disetujui')->getStyle('E1')->getFont()->setBold(true);;

		$data = $this->rimlaporan->get_realisasi_potensi_pendapatan_bpjs($object, $date)->result();
		$countSep = $this->rimlaporan->get_count_sep($date, $object)->row()->count;
		$noregBelumClaim = $this->rimlaporan->get_noreg_sep_belum_claim($date, $object)->result();

		$x = 2;
		$countClaim = 0;
		$rillRSUmbal = 0;
		$vtotDiajukan = 0;
		$vtotDisetujui = 0;
		$vtotRill = 0;
		$vtotRillBlmClaim = 0;
		$vtotRuang = 0;
		$vtotRuangBlm = 0;
		foreach ($data as $row) {
			$countClaim += $row->vol_kasus_umbal;
			$rillRSUmbal += $row->rupiah_rilrs;
			$vtotDiajukan += $row->rupiah_diajukan;
			$vtotDisetujui += $row->rupiah_disetujui;
			$sep = $this->rimlaporan->get_nosep_umbal($row->periode_umbal, $object)->result();

			$sheet->setCellValue('A' . $x, $row->periode_umbal);
			$sheet->mergeCells('A' . $x . ':' . 'E' . $x . '')->getStyle('A' . $x)->getFont()->setBold(true);
			$x++;

			$sheet->setCellValue('A' . $x, 'Vol Kasus/Kunjungan');
			$sheet->setCellValue('B' . $x, $row->vol_kasus_umbal);
			$sheet->setCellValue('C' . $x, $row->vol_kasus_umbal);
			$sheet->setCellValue('D' . $x, $row->vol_kasus_umbal);
			$sheet->setCellValue('E' . $x, $row->vol_kasus_umbal);
			$x++;

			$sheet->setCellValue('A' . $x, 'Rupiah');

			$rill = 0;
			$vtotAkomodasiClaim = 0;
			foreach ($sep as $row_nosep) {
				$no_register = $this->rimlaporan->get_nosep_from_bpjsep($row_nosep->no_sep)->row()->no_register;

				if (substr($no_register, 0, 2) == 'RI') {
					$iriRill = isset($this->rimlaporan->get_vtot_iri_blm_claim($no_register)->row()->tarif) ? $this->rimlaporan->get_vtot_iri_blm_claim($no_register)->row()->tarif : null;
					$irjNoregasalRill = isset($this->rimlaporan->get_vtot_noregasal_blm_claim($no_register)->row()->tarif) ? $this->rimlaporan->get_vtot_noregasal_blm_claim($no_register)->row()->tarif : null;
					$ruang = $this->rimlaporan->get_ruang_realisasi_potensi($no_register)->result();

					$vtotRuangClaim = 0;
					foreach ($ruang as $val) {
						$diff = 1;
						if ($val->tglkeluarrg != null) {
							$start = new DateTime($val->tglmasukrg); //start
							$end = new DateTime($val->tglkeluarrg); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						} else {
							if ($val->tgl_keluar_resume != NULL) {
								$start = new DateTime($val->tglmasukrg); //start
								$end = new DateTime($val->tgl_keluar_resume); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
							} else {
								$start = new DateTime($val->tglmasukrg); //start
								$end = new DateTime(date("Y-m-d")); //end

								$diff = $end->diff($start)->format("%a");
								if ($diff == 0) {
									$diff = 1;
								}
							}
						}

						if ($val->titip == '1') {
							$vtotRuangClaim += $val->tarif_jatah_bpjs * $diff;
						} else {
							$vtotRuangClaim += $val->tarif_bpjs * $diff;
						}
					}
					$vtotAkomodasiClaim += $vtotRuangClaim;
					$rill += $iriRill + $irjNoregasalRill;
				} else {
					$irjRill = isset($this->rimlaporan->get_vtot_irj_blm_claim($no_register)->row()->tarif) ? $this->rimlaporan->get_vtot_irj_blm_claim($no_register)->row()->tarif : null;
					$rill += $irjRill;
				}
			}

			$vtotRill += $rill;
			$vtotRuang += $vtotAkomodasiClaim;
			$sheet->setCellValue('B' . $x, number_format($vtotAkomodasiClaim + $rill)); //rill rs
			$sheet->setCellValue('C' . $x, number_format($row->rupiah_rilrs));
			$sheet->setCellValue('D' . $x, number_format($row->rupiah_diajukan));
			$sheet->setCellValue('E' . $x, number_format($row->rupiah_disetujui));
			$x++;

			$sheet->setCellValue('A' . $x, '');
			$sheet->mergeCells('A' . $x . ':' . 'E' . $x . '');
			$x++;
		}

		$sheet->setCellValue('A' . $x, 'Belum Klaim');
		$sheet->mergeCells('A' . $x . ':' . 'E' . $x . '')->getStyle('A' . $x)->getFont()->setBold(true);
		$x++;

		$sheet->setCellValue('A' . $x, 'Vol Kasus/Kunjungan');
		$sheet->setCellValue('B' . $x, $countSep);
		$sheet->setCellValue('C' . $x, '');
		$sheet->setCellValue('D' . $x, '');
		$sheet->setCellValue('E' . $x, '');
		$x++;

		$sheet->setCellValue('A' . $x, 'Rupiah');

		if ($object == 'RI') {
			$rilliri = isset($this->rimlaporan->get_rill_rs_blm_claim_ri($date, $object)->row()->tarif) ? $this->rimlaporan->get_rill_rs_blm_claim_ri($date, $object)->row()->tarif : null;
			$rillNoregasal = isset($this->rimlaporan->get_rill_rs_blm_claim_noregasal($date, $object)->row()->tarif) ? $this->rimlaporan->get_rill_rs_blm_claim_noregasal($date, $object)->row()->tarif : null;

			$vtotAkomodasiBlmClaim = 0;
			foreach ($noregBelumClaim as $row_blm) {
				$ruangBlmClaim = $this->rimlaporan->get_ruang_realisasi_potensi($row_blm->no_register)->result();

				$vtotRuangBlmClaim = 0;
				foreach ($ruangBlmClaim as $r) {
					$diff = 1;
					if ($r->tglkeluarrg != null) {
						$start = new DateTime($r->tglmasukrg); //start
						$end = new DateTime($r->tglkeluarrg); //end

						$diff = $end->diff($start)->format("%a");
						if ($diff == 0) {
							$diff = 1;
						}
					} else {
						if ($r->tgl_keluar_resume != NULL) {
							$start = new DateTime($r->tglmasukrg); //start
							$end = new DateTime($r->tgl_keluar_resume); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						} else {
							$start = new DateTime($r->tglmasukrg); //start
							$end = new DateTime(date("Y-m-d")); //end

							$diff = $end->diff($start)->format("%a");
							if ($diff == 0) {
								$diff = 1;
							}
						}
					}

					if ($r->titip == '1') {
						$vtotRuangBlmClaim += $r->tarif_jatah_bpjs * $diff;
					} else {
						$vtotRuangBlmClaim += $r->tarif_bpjs * $diff;
					}
				}
				$vtotAkomodasiBlmClaim += $vtotRuangBlmClaim;
			}
			$sheet->setCellValue('B' . $x, number_format($rilliri + $rillNoregasal + $vtotAkomodasiBlmClaim));
			$vtotRillBlmClaim += $rilliri + $rillNoregasal + $vtotAkomodasiBlmClaim;
		} else {
			$rillirj = isset($this->rimlaporan->get_rill_rs_blm_claim_rj($date, $object)->row()->tarif) ? $this->rimlaporan->get_rill_rs_blm_claim_rj($date, $object)->row()->tarif : null;
			$sheet->setCellValue('B' . $x, number_format($rillirj));
			$vtotRillBlmClaim += $rillirj;
		} //rill rs

		$sheet->setCellValue('C' . $x, '');
		$sheet->setCellValue('D' . $x, '');
		$sheet->setCellValue('E' . $x, '');
		$x++;

		$sheet->setCellValue('A' . $x, '');
		$sheet->mergeCells('A' . $x . ':' . 'E' . $x . '');
		$x++;

		$sheet->setCellValue('A' . $x, 'Total');
		$sheet->mergeCells('A' . $x . ':' . 'E' . $x . '')->getStyle('A' . $x)->getFont()->setBold(true);
		$x++;

		$sheet->setCellValue('A' . $x, 'Vol Kasus/Kunjungan')->getStyle('A' . $x)->getFont()->setBold(true);
		$sheet->setCellValue('B' . $x, $countSep + $countClaim);
		$sheet->setCellValue('C' . $x, $countClaim);
		$sheet->setCellValue('D' . $x, $countClaim);
		$sheet->setCellValue('E' . $x, $countClaim);
		$x++;

		$sheet->setCellValue('A' . $x, 'Rupiah')->getStyle('A' . $x)->getFont()->setBold(true);
		$sheet->setCellValue('B' . $x, number_format($vtotRill + $vtotRillBlmClaim + $vtotRuang)); //rill rs
		$sheet->setCellValue('C' . $x, number_format($rillRSUmbal));
		$sheet->setCellValue('D' . $x, number_format($vtotDiajukan));
		$sheet->setCellValue('E' . $x, number_format($vtotDisetujui));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Realisasi dan Potensi Pendapatan BPJS ' . $title;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_rencana_plg_h_1()
	{
		$data['title'] = 'Laporan Pasien Rencana Pulang H-1';
		$this->load->view('iri/lap_rencana_pulang_h_1', $data);
	}

	public function lap_rencana_plg_h_1_dt_ajax()
	{
		$bulan = date('Y-m', strtotime(strval($this->input->post('date'))));
		$get_dt = $this->rimlaporan->get_datatable_rencana_pulang_pasien_h_1($bulan)->row();
		echo ($get_dt) ? $get_dt->res : json_encode((object)[]);
	}
}
