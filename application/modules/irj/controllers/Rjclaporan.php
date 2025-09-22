<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Rjcterbilang.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// include(dirname(dirname(__FILE__)).'/Tglindo.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class Rjclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('iri/rimpasien','',TRUE);
		$this->load->model('iri/rimlaporan','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);	
	}
	public function index()
	{
		redirect('irj/Rjcregistrasi','refresh');
	}
	public function lap_perpoli(){
		$data['title'] = 'Laporan Kasir Per Poli';
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');

		$tgl_awal_gabung = $tgl_awal." ".$jam_awal;
		$tgl_akhir_gabung = $tgl_akhir." ".$jam_akhir;

		if($tgl_awal==''){
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);
			$jam_awal='00:00';
			$jam_akhir='23:59';
			$tgl_awal_gabung = $tgl_awal." 00:00";
			$tgl_akhir_gabung = $tgl_akhir." 23:59";
		}

		$data['tgl_awal'] = $tgl_awal_gabung;
		$data['tgl_akhir'] = $tgl_akhir_gabung;

		$data['tgl_awal_show'] = date('d F Y',strtotime($tgl_awal))." - ".$jam_awal;//$tgl_awal_lengkap;
		$data['tgl_akhir_show'] = date('d F Y',strtotime($tgl_akhir))." - ".$jam_akhir;//

		$data['list_irj'] = $this->Rjmlaporan->get_pendapatan_perpoli($tgl_awal_gabung,$tgl_akhir_gabung);
		$this->load->view('irj/list_pendapatan_kasir',$data);
	}


	public function rekap_harian_kasirLoket(){
		$data['title'] = 'Laporan Kasir Per Poli';
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');

		

		if($tgl_awal==''){
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);
			$jam_awal='00:00';
			$jam_akhir='23:59';
			$tgl_awal_gabung = $tgl_awal." 00:00";
			$tgl_akhir_gabung = $tgl_akhir." 23:59";
		}else{
			$tgl_awal_gabung = $tgl_awal." ".$jam_awal;
			$tgl_akhir_gabung = $tgl_akhir." ".$jam_akhir;
		}

		$data['tgl_awal'] = $tgl_awal_gabung;
		$data['tgl_akhir'] = $tgl_akhir_gabung;

		$data['tgl_awal_show'] = date('d F Y',strtotime($tgl_awal))." - ".$jam_awal;//$tgl_awal_lengkap;
		$data['tgl_akhir_show'] = date('d F Y',strtotime($tgl_akhir))." - ".$jam_akhir;//

		$data['list_irj'] = $this->Rjmlaporan->get_rekap_harian_kasir($tgl_awal_gabung,$tgl_akhir_gabung,$this->session->userdata("userid"));
		$this->load->view('irj/list_rekap_loket_kasir',$data);
	}

	public function cetak_laporan_harian_kasir_excel($tgl_awal='',$tgl_akhir=""){
	  require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      $tgl_awal = urldecode($tgl_awal);
      $tgl_akhir = urldecode($tgl_akhir);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian_kasir.xlsx");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan     
		$list_keluar_irj = $this->Rjmlaporan->get_pendapatan_perpoli($tgl_awal,$tgl_akhir);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 5;
      
       //	$tgl_indo = new Tglindo();

  		$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
		$tahun_show = substr($tgl_awal,0,4);
		$tanggal_show = substr($tgl_awal,8,2);
		$jam_show = substr($tgl_awal,11,5);
		$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;

		$bulan_show = $tgl_indo->bulan(substr($tgl_akhir,6,2));
		$tahun_show = substr($tgl_akhir,0,4);
		$tanggal_show = substr($tgl_akhir,8,2);
		$jam_show = substr($tgl_akhir,11,5);
		$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;


      $excel->getActiveSheet()->setCellValue('A1', "Laporan Pendapatan Kasir ",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('A2', "Tanggal : ".date('d F Y', strtotime($tgl_awal))." - ".date('d F Y', strtotime($tgl_akhir)),PHPExcel_Cell_DataType::TYPE_STRING);

      $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

     
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
	  	$jumlah = 0;
     	$i=1;
      //RAWAT JALAN
      foreach ($list_keluar_irj as $r) {
     	$total = $total + $r['total'];
  		$jumlah= $jumlah + $r['jumlah'];

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $i++,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['jumlah'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, number_format($r['total'],0),PHPExcel_Cell_DataType::TYPE_STRING);    
      }

      $row++;
      $excel->getActiveSheet()->setCellValue('B'.$row, "Total ",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('C'.$row, $jumlah,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('D'.$row, number_format($total,0),PHPExcel_Cell_DataType::TYPE_STRING);

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Pendapatan_Kasir_Tanggal_'.$newDate.'.xlsx'; //save our workbook as this file name
      ob_end_clean();  
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_laporan_harian_kasirLoket_excel($tgl_awal='',$tgl_akhir=""){
	  require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      $tgl_awal = urldecode($tgl_awal);
      $tgl_akhir = urldecode($tgl_akhir);
      $userid=$this->session->userdata('userid');
      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian_loket.xlsx");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan     
		$list_keluar_irj = $this->Rjmlaporan->get_rekap_harian_kasir($tgl_awal,$tgl_akhir,$userid);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 5;
      
       	// $tgl_indo = new Tglindo();

  		$bulan_show =substr($tgl_awal,6,2);
		$tahun_show = substr($tgl_awal,0,4);
		$tanggal_show = substr($tgl_awal,8,2);
		$jam_show = substr($tgl_awal,11,5);
		$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;

		$bulan_show =substr($tgl_akhir,6,2);
		$tahun_show = substr($tgl_akhir,0,4);
		$tanggal_show = substr($tgl_akhir,8,2);
		$jam_show = substr($tgl_akhir,11,5);
		$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;


      $excel->getActiveSheet()->setCellValue('A1', "Laporan Rekapitulasi Kasir ",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('A2', "Tanggal : ".date('d F Y', strtotime($tgl_awal))." - ".date('d F Y', strtotime($tgl_akhir)),PHPExcel_Cell_DataType::TYPE_STRING);

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

		$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

     $excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

      
      $excel->getActiveSheet()->setAutoFilter('A5:H5');
        $jumlahtunai=0;$jumlahcc=0;$jumlahdisc=0;	
     	$i=1;
      //RAWAT JALAN
     	/*<th>No</th>
								<th>No Kwitansi</th>
								<th>Nama Pasien</th>
								<th>Nama Poli</th>
								<th>Bagian</th>
								<th>Jenis</th>
								<th>Jumlah Bayar</th>
								<th>Potongan/Diskon</th>*/
      foreach ($list_keluar_irj as $r) {
     	$jumlahtunai+=$r['tunai'];	
		$jumlahcc+=$r['nilai_kkd'];
		$jumlahdisc+=$r['diskon'];

        $row++;
        if((int)$r['nilai_kkd']==0 or $r['nilai_kkd']==''){ $jbayar='Tunai';} else { $jbayar='CC/Debit';}
        $excel->getActiveSheet()->setCellValue('A'.$row, $i++,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['kasir'].$r['no_kwitansi'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['nama_kel'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $jbayar,PHPExcel_Cell_DataType::TYPE_STRING);
        $txtbatal='';
        if((int)$r['batal']==1){ $txtbatal='BATAL '.$r['editnote'];} 
        if((int)$r['retur']==1){ $txtbatal=$txtbatal.'RETUR '.$r['editnote'];}
        $excel->getActiveSheet()->setCellValue('G'.$row, $jbayar,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, number_format((int)$r['tunai']+(int)$r['nilai_kkd'],0),PHPExcel_Cell_DataType::TYPE_STRING); 
        $excel->getActiveSheet()->setCellValue('I'.$row, number_format($r['diskon'],0),PHPExcel_Cell_DataType::TYPE_STRING);    
      }

      $row++;
      $excel->getActiveSheet()->setCellValue('G'.$row, "Total ",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('H'.$row, number_format((int)$jumlahtunai+(int)$jumlahcc,0),PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('I'.$row, number_format($jumlahdisc,0),PHPExcel_Cell_DataType::TYPE_STRING);

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Rekap_Kasir_Tanggal_'.$newDate.'.xlsx'; //save our workbook as this file name
      ob_end_clean();  
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function kunj_pasien()
	{	   
		if($this->input->post('date0')!=''){
			$data['date_awal'] = $this->input->post('date0');
		}else {
			$data['date_awal'] = date('Y-m-d', strtotime('-1 days'));
		}
		
		if($this->input->post('date1')!=''){
			$data['date_akhir'] = $this->input->post('date1');
		}else {
			$data['date_akhir'] = date('Y-m-d');
		}		
		//	echo $data['date_awal'];echo $data['date_akhir'];
		$data['title'] = 'Laporan Kunjungan Pasien <b>'.date('d-m-Y', strtotime($data['date_awal'])).' s/d '.date('d-m-Y', strtotime($data['date_akhir'])).'</b>';
			
		$data['msk_iri1']=$this->Rjmlaporan->get_data_iri_masuk_lt1($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_iri2']=$this->Rjmlaporan->get_data_iri_masuk_lt2($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_iri3']=$this->Rjmlaporan->get_data_iri_masuk_lt3($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri1']=$this->Rjmlaporan->get_data_iri_keluar_lt1($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri2']=$this->Rjmlaporan->get_data_iri_keluar_lt2($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri3']=$this->Rjmlaporan->get_data_iri_keluar_lt3($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_ird']=$this->Rjmlaporan->get_data_ird_masuk($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_irj']=$this->Rjmlaporan->get_data_irj_masuk($data['date_awal'],$data['date_akhir'])->result();
		$this->load->view('irj/lap_kunj_pasien',$data);			
		
	}

	public function kunj_pasien_all()
	{	   
		if($this->input->post('date0')!=''){
			$data['date_awal'] = $this->input->post('date0');
		}else {
			$data['date_awal'] = date('Y-m-d', strtotime('-1 days'));
		}
		
		if($this->input->post('date1')!=''){
			$data['date_akhir'] = $this->input->post('date1');
		}else {
			$data['date_akhir'] = date('Y-m-d');
		}		
		//	echo $data['date_awal'];echo $data['date_akhir'];
		$data['title'] = 'Laporan Kunjungan Pasien <b>'.date('d-m-Y', strtotime($data['date_awal'])).' s/d '.date('d-m-Y', strtotime($data['date_akhir'])).'</b>';
			
		$data['all']=$this->Rjmlaporan->get_data_kunj_all($data['date_awal'],$data['date_akhir'])->result();		
		$this->load->view('irj/lap_kunj_pasien_all',$data);			
		
	}

	public function pasien_baru_irj() {
		$data['title'] = 'Laporan Pasien Rawat Jalan/Darurat Baru';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl = $this->input->post('bulan');
		//  $jam_awal = $this->input->post('jam_awal');
		//$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
		$tgl = date("Y-m-d");
		//$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_baru_irj($tgl);

			//  $data['tgl_awal_show'] = "";
			//  $data['tgl_akhir_show'] = "";
			//  $data['user_show'] = "";
		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_baru_irj($tgl);

			//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_pasien_baru',$data);
      
		}

		if($tipe_input == 'BLN'){

		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_baru_irj($tgl);

		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_pasien_baru',$data);
		
		}
	}

	public function get_lap_jml_pemeriksaan_dpjp() {
		if($_SERVER['REQUEST_METHOD']=='POST'){
		$data['title'] = 'Laporan Jumlah Pasien Rawat Jalan/Darurat Per DPJP';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$data['tampil_per'] = $this->input->post('tampil_per');
		$id_poli = $this->input->post('id_poli');
		$id_dokter = $this->input->post('id_dokter');
		$tgl= $this->input->post('tgl');
		$tahun = $this->input->post('tahun');
		$bulan_awal = $this->input->post('bulan1');
		$bulan_akhir = $this->input->post('bulan2');
		$bulan = $this->input->post('bulan');
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		$data['id_dokter']=$this->input->post('id_dokter');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		
			$this->load->view('irj/rjvjmlpasienperdpjp',$data);
		} else {
			redirect('irj/Rjclaporan/rjvjmlpasienperdpjp','refresh');
		}
	}

	public function excel_lapjml_konsul_dpjp($tampil_per='', $id_poli='', $tgl='', $id_dokter='') {
		if ($tampil_per == "TGL") {
			//$bln1=$tgl;
			//$bln2=$bulan_akhir;
			//$range1 = date('m-Y', strtotime($bln1));
			$tanggal = date('d-m-Y', strtotime($tgl));
			$date_title='<b>('.$tanggal.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_harian($tgl);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_konsul_harian_dpjp($tgl, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $id_dokter;
					$data['id_dokter']=$this->input->post('id_dokter');
					$result = $this->Rjmlaporan->get_lap_jml_konsul_harian_per_dpjp($tgl, $select_id_poli, $select_dokter);
					
				}											
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Tanggal Konsul');
				$sheet->setCellValue('E1', 'Jenis Konsul');
				$sheet->setCellValue('F1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['tanggal_konsul']);
							$sheet->setCellValue('E'.$x, $row['opsi']);
							$sheet->setCellValue('F'.$x, $row['jumlah']);

							$x++;
				}
				
				//ob_clean();
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien Konsul IRJ Per DPJP Tanggal '.$tgl;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
				
		} else if ($tampil_per == "BLN") {
			$bulan=$tgl;
			//$bln2=$bulan_akhir;
			//$range1 = date('m-Y', strtotime($bln1));
			$bln = date('m-Y', strtotime($bulan));
			$date_title='<b>('.$bln.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_bulanan($bulan);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_konsul_bulanan_dpjp($bulan, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_konsul_bulanan_per_dpjp($bulan, $select_id_poli, $select_dokter);
					
				}											
			}
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Dokter');
			$sheet->setCellValue('C1', 'Poli');
			$sheet->setCellValue('D1', 'Tanggal Konsul');
			$sheet->setCellValue('E1', 'Jenis Konsul');
			$sheet->setCellValue('F1', 'Jumlah Pasien');

			$no = 1;
			$x = 2;
			foreach ($result as $row) {
		
						$sheet->setCellValue('A'.$x, $no++);
						$sheet->setCellValue('B'.$x, $row['nm_dokter']);
						$sheet->setCellValue('C'.$x, $row['nm_poli']);
						$sheet->setCellValue('D'.$x, $row['tanggal_konsul']);
						$sheet->setCellValue('E'.$x, $row['opsi']);
						$sheet->setCellValue('F'.$x, $row['jumlah']);

						$x++;
			}
				
				//ob_clean();
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien Konsul IRJ Per DPJP Bulan '.$bln;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	
		} else if ($tampil_per == "THN") {
				
			$tahun=$tgl;
			//$bln2=$bulan_akhir;
			// $range1 = date('m-Y', strtotime($bln1));
			 $thn = date('Y', strtotime($tahun));
			$date_title='<b>('.$thn.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_tahunan($tahun);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_konsul_tahunan_dpjp($tahun, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_konsul_tahunan_per_dpjp($tahun, $select_id_poli, $select_dokter);
					
				}											
			}
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Dokter');
			$sheet->setCellValue('C1', 'Poli');
			$sheet->setCellValue('D1', 'Tanggal Konsul');
			$sheet->setCellValue('E1', 'Jenis Konsul');
			$sheet->setCellValue('F1', 'Jumlah Pasien');

			$no = 1;
			$x = 2;
			foreach ($result as $row) {
		
						$sheet->setCellValue('A'.$x, $no++);
						$sheet->setCellValue('B'.$x, $row['nm_dokter']);
						$sheet->setCellValue('C'.$x, $row['nm_poli']);
						$sheet->setCellValue('D'.$x, $row['tanggal_konsul']);
						$sheet->setCellValue('E'.$x, $row['opsi']);
						$sheet->setCellValue('F'.$x, $row['jumlah']);

						$x++;
			}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien Konsul IRJ Per DPJP Tahun '.$thn;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}
	}

	public function excel_lapjml_dpjp($tampil_per='', $id_poli='', $tgl='', $id_dokter='') {
		//$poli=$this->Rjmpencarian->get_poliklinik()->result();
		//var_dump($id_poli, $id_dokter, $tgl, $tampil_per); die();
		
		if ($tampil_per == "TGL") {
			//$bln1=$tgl;
			//$bln2=$bulan_akhir;
			//$range1 = date('m-Y', strtotime($bln1));
			$tanggal = date('d-m-Y', strtotime($tgl));
			$date_title='<b>('.$tanggal.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_dpjp_harian($tgl);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_harian_dpjp($tgl, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $id_dokter;
					$data['id_dokter']=$this->input->post('id_dokter');
					$result = $this->Rjmlaporan->get_lap_jml_harian_per_dpjp($tgl, $select_id_poli, $select_dokter);
					
				}											
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['jumlah']);

							$x++;
				}
				
				//ob_clean();
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien IRJ Per DPJP Tanggal '.$tgl;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
				
		} else if ($tampil_per == "BLN") {
			$bulan=$tgl;
			//$bln2=$bulan_akhir;
			//$range1 = date('m-Y', strtotime($bln1));
			$bln = date('m-Y', strtotime($bulan));
			$date_title='<b>('.$bln.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_dpjp_bulanan($bulan);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_bulanan_dpjp($bulan, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_bulanan_per_dpjp($bulan, $select_id_poli, $select_dokter);
					
				}											
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['jumlah']);

							$x++;
				}
				
				//ob_clean();
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien IRJ Per DPJP Bulan '.$bln;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	
		} else if ($tampil_per == "THN") {
				
			$tahun=$tgl;
			//$bln2=$bulan_akhir;
			// $range1 = date('m-Y', strtotime($bln1));
			 $thn = date('Y', strtotime($tahun));
			$date_title='<b>('.$thn.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_dpjp_tahunan($tahun);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_tahunan_dpjp($tahun, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_tahunan_per_dpjp($tahun, $select_id_poli, $select_dokter);
					
				}											
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['jumlah']);

							$x++;
				}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien IRJ Per DPJP Tahun '.$thn;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}
}
	public function excel_lapjml_konsul_dpjp_triwulan($tampil_per='', $id_poli='', $tgl='', $bulan_akhir='', $id_dokter='') {
		$bln1=$tgl;
			$bln2=$bulan_akhir;
			$range1 = date('m-Y', strtotime($bln1));
			$range2 = date('m-Y', strtotime($bln2));
			$date_title='<b>('.$bln1.' - '.$bln2.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_triwulan($bln1, $bln2);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_konsul_triwulan_dpjp($bln1, $bln2, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_konsul_triwulan_per_dpjp($bln1, $bln2, $select_id_poli, $select_dokter);
					
				}											
			}
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Dokter');
			$sheet->setCellValue('C1', 'Poli');
			$sheet->setCellValue('D1', 'Tanggal Konsul');
			$sheet->setCellValue('E1', 'Jenis Konsul');
			$sheet->setCellValue('F1', 'Jumlah Pasien');

			$no = 1;
			$x = 2;
			foreach ($result as $row) {
		
						$sheet->setCellValue('A'.$x, $no++);
						$sheet->setCellValue('B'.$x, $row['nm_dokter']);
						$sheet->setCellValue('C'.$x, $row['nm_poli']);
						$sheet->setCellValue('D'.$x, $row['tanggal_konsul']);
						$sheet->setCellValue('E'.$x, $row['opsi']);
						$sheet->setCellValue('F'.$x, $row['jumlah']);

						$x++;
			}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien Konsul IRJ Per DPJP Bulan '.$range1.' Hingga '.$range2;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}

	public function excel_lapjml_dpjp_triwulan($tampil_per='', $id_poli='', $tgl='', $bulan_akhir='', $id_dokter='') {
			$bln1=$tgl;
			$bln2=$bulan_akhir;
			$range1 = date('m-Y', strtotime($bln1));
			$range2 = date('m-Y', strtotime($bln2));
			$date_title='<b>('.$bln1.' - '.$bln2.')</b>';
			//----------
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result = $this->Rjmlaporan->get_lap_jml_dpjp_triwulan($bln1, $bln2);
				// }else{
				// 	echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result = $this->Rjmlaporan->get_lap_jml_triwulan_dpjp($bln1, $bln2, $select_id_poli);
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result = $this->Rjmlaporan->get_lap_jml_triwulan_per_dpjp($bln1, $bln2, $select_id_poli, $select_dokter);
					
				}											
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['jumlah']);

							$x++;
				}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Pasien IRJ Per DPJP Bulan '.$range1.' Hingga '.$range2;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}

	public function excel_lapjml_konsul_dpjp_today($tgl='') {
		$tanggal = date('d-m-Y', strtotime($tgl));
			$date_title='<b>('.$tgl.')</b>';
			//----------				
			$result = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_harian($tgl);
									
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Dokter');
			$sheet->setCellValue('C1', 'Poli');
			$sheet->setCellValue('D1', 'Tanggal Konsul');
			$sheet->setCellValue('E1', 'Jenis Konsul');
			$sheet->setCellValue('F1', 'Jumlah Pasien');

			$no = 1;
			$x = 2;
			foreach ($result as $row) {
		
						$sheet->setCellValue('A'.$x, $no++);
						$sheet->setCellValue('B'.$x, $row['nm_dokter']);
						$sheet->setCellValue('C'.$x, $row['nm_poli']);
						$sheet->setCellValue('D'.$x, $row['tanggal_konsul']);
						$sheet->setCellValue('E'.$x, $row['opsi']);
						$sheet->setCellValue('F'.$x, $row['jumlah']);

						$x++;
			}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Jumlah Pasien Konsul Per DPJP IRJ '.$tanggal;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}

	public function excel_lapjml_dpjp_today($tgl='') {
			//$tanggal=$tgl;
			//$bln2=$bulan_akhir;
			//$range1 = date('m-Y', strtotime($bln1));
			$tanggal = date('d-m-Y', strtotime($tgl));
			$date_title='<b>('.$tgl.')</b>';
			//----------				
			$result = $this->Rjmlaporan->get_lap_jml_dpjp_harian($tgl);
									
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Dokter');
				$sheet->setCellValue('C1', 'Poli');
				$sheet->setCellValue('D1', 'Jumlah Pasien');

				$no = 1;
				$x = 2;
				foreach ($result as $row) {
			
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $row['nm_dokter']);
							$sheet->setCellValue('C'.$x, $row['nm_poli']);
							$sheet->setCellValue('D'.$x, $row['jumlah']);

							$x++;
				}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan Jumlah Pasien Per DPJP IRJ '.$tanggal;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
	}

	public function lap_jml_konsultasi_dpjp() {
		$data['title'] = 'Laporan Jumlah Pasien Konsultasi Rawat Jalan/Darurat Per DPJP';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$data['tampil_per'] = $this->input->post('tampil_per');
		//$data['tampil_per'] = "TGL";
		$tgl= $this->input->post('tgl');
		$tahun = $this->input->post('tahun');
		$bulan_awal = $this->input->post('bulan1');
		$bulan_akhir = $this->input->post('bulan2');
		$bulan = $this->input->post('bulan');
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		//$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl = date("Y-m-d");
			//$data['tampil_per'] = "TGL";
			//$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_irj_perdpjp($tgl);
	
			$tanggal = date('d m Y', strtotime($tgl));
			$data['date_title']='<b>('.substr($tanggal,0,2).'  '.substr($tanggal,6,4).')</b>';
			$data['tgl'] = $tgl;
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_harian($tgl);
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$this->load->view('irj/rjvjmlkonsulpasienperdpjp',$data);
		  
		}

		if($tipe_input == 'TGL'){

		$data['tgl'] = $tgl;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_irj_perdpjp($tgl);
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		$data['id_poli']="SEMUA";
		//$data['id_dokter']="SEMUA";
		$data['id_poli']=$this->input->post('id_poli');
		$data['id_dokter']=$this->input->post('id_dokter');

		$tanggal = date('d-m-Y', strtotime($tgl));
		//$data['date_title']='(<b>'.$tgl.'</b>)';
		$data['date_title']='<b>Tanggal ('.$tanggal.')</b>';
				
			if ($this->input->post('id_poli')=="SEMUA") {					
				if ($this->input->post('id_dokter')=="SEMUA") {
					$data['id_dokter']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_harian($tgl);
				// }else{
						
				}									
			} else {
				//$data['nm_poli'] = $this->input->post('id_poli');
				if ($this->input->post('id_dokter')=="SEMUA") {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_harian_dpjp($tgl, $select_id_poli);
				}else{
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $this->input->post('id_dokter');
					$data['id_dokter']=$this->input->post('id_dokter');
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_harian_per_dpjp($tgl, $select_id_poli, $select_dokter);
				}										
			}
		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/rjvjmlkonsulpasienperdpjp',$data);
		} 

		if ($tipe_input == "BLN") {
			$data['tgl'] = $bulan;
			//$data['bulan_akhir'] = $bulan_akhir;
			//$bulan_awal = $this->input->post('bulan1');
			//$bulan = $this->input->post('bulan');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			// $data['id_poli']="SEMUA";
			// $data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$bulan.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_bulanan($bulan);
						$data['id_dokter'] = "SEMUA";
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_bulanan_dpjp($bulan, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_bulanan_per_dpjp($bulan, $select_id_poli, $select_dokter);
					}										
				}
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/rjvjmlkonsulpasienperdpjp',$data);
		}

		if($tipe_input == "THN") {
			$data['tgl'] = $tahun;
			//$data['bulan_akhir'] = $bulan_akhir;
			//$bulan_awal = $this->input->post('bulan1');
			$tahun = $this->input->post('tahun');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$tahun.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_tahunan($tahun);
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_tahunan_dpjp($tahun, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_tahunan_per_dpjp($tahun, $select_id_poli, $select_dokter);
					}										
				}
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/rjvjmlkonsulpasienperdpjp',$data);
		}

		if($tipe_input == "TRIWULAN") {
			$data['tgl'] = $bulan_awal;
			$data['bulan_akhir'] = $bulan_akhir;
			$bulan_awal = $this->input->post('bulan1');
			$bulan_akhir = $this->input->post('bulan2');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$bulan_awal.' - '.$bulan_akhir.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_dpjp_triwulan($bulan_awal, $bulan_akhir);
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_triwulan_dpjp($bulan_awal, $bulan_akhir, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_konsul_triwulan_per_dpjp($bulan_awal, $bulan_akhir, $select_id_poli, $select_dokter);
					}										
				}
				$this->load->view('irj/rjvjmlkonsulpasienperdpjp',$data);
			}
	}

	public function lap_jml_pemeriksaan_dpjp() {
		$data['title'] = 'Laporan Jumlah Pasien Rawat Jalan/Darurat Per DPJP';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$data['tampil_per'] = $this->input->post('tampil_per');
		//$data['tampil_per'] = "TGL";
		$tgl= $this->input->post('tgl');
		$tahun = $this->input->post('tahun');
		$bulan_awal = $this->input->post('bulan1');
		$bulan_akhir = $this->input->post('bulan2');
		$bulan = $this->input->post('bulan');
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		//$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		//  $bulan = $this->input->post('bulan');
		//  $tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl = date("Y-m-d");
			//$data['tampil_per'] = "TGL";
			//$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_irj_perdpjp($tgl);
	
			$tanggal = date('d m Y', strtotime($tgl));
			$data['date_title']='<b>('.substr($tanggal,0,2).'  '.substr($tanggal,6,4).')</b>';
			$data['tgl'] = $tgl;
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_dpjp_harian($tgl);
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$this->load->view('irj/rjvjmlpasienperdpjp',$data);
		  
		}

		if($tipe_input == 'TGL'){

		$data['tgl'] = $tgl;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_pasien_irj_perdpjp($tgl);
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
		$data['id_poli']="SEMUA";
		//$data['id_dokter']="SEMUA";
		$data['id_poli']=$this->input->post('id_poli');
		//$data['id_dokter']=$this->input->post('id_dokter');

		$tanggal = date('d-m-Y', strtotime($tgl));
		//$data['date_title']='(<b>'.$tgl.'</b>)';
		$data['date_title']='<b>Tanggal ('.$tanggal.')</b>';
				
			if ($this->input->post('id_poli')=="SEMUA") {					
				if ($this->input->post('id_dokter')=="SEMUA") {
					$data['id_dokter']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_dpjp_harian($tgl);
				// }else{
						
				}									
			} else {
				//$data['nm_poli'] = $this->input->post('id_poli');
				if ($this->input->post('id_dokter')=="SEMUA") {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_harian_dpjp($tgl, $select_id_poli);
				}else{
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $this->input->post('id_dokter');
					$data['id_dokter']=$this->input->post('id_dokter');
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_harian_per_dpjp($tgl, $select_id_poli, $select_dokter);
				}										
			}
		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/rjvjmlpasienperdpjp',$data);
		} 

		if ($tipe_input == "BLN") {
			$data['tgl'] = $bulan;
			//$data['bulan_akhir'] = $bulan_akhir;
			//$bulan_awal = $this->input->post('bulan1');
			//$bulan = $this->input->post('bulan');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$bulan.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_dpjp_bulanan($bulan);
						$data['id_dokter'] = "SEMUA";
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_bulanan_dpjp($bulan, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_bulanan_per_dpjp($bulan, $select_id_poli, $select_dokter);
					}										
				}
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/rjvjmlpasienperdpjp',$data);
		}

		if($tipe_input == "THN") {
			$data['tgl'] = $tahun;
			//$data['bulan_akhir'] = $bulan_akhir;
			//$bulan_awal = $this->input->post('bulan1');
			$tahun = $this->input->post('tahun');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$tahun.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_dpjp_tahunan($tahun);
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_tahunan_dpjp($tahun, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_tahunan_per_dpjp($tahun, $select_id_poli, $select_dokter);
					}										
				}
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/rjvjmlpasienperdpjp',$data);
		}

		if($tipe_input == "TRIWULAN") {
			$data['tgl'] = $bulan_awal;
			$data['bulan_akhir'] = $bulan_akhir;
			$bulan_awal = $this->input->post('bulan1');
			$bulan_akhir = $this->input->post('bulan2');
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['date_title']='<b> Bulan ('.$bulan_awal.' - '.$bulan_akhir.')</b>';
					
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_dpjp_triwulan($bulan_awal, $bulan_akhir);
					//}else{
							
					}
																	
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_triwulan_dpjp($bulan_awal, $bulan_akhir, $select_id_poli);
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$data['id_poli']=$select[0];
						$data['nm_poli']='<b>'.$select[1].'</b>';
						$select_dokter = $this->input->post('id_dokter');
						$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_jml_triwulan_per_dpjp($bulan_awal, $bulan_akhir, $select_id_poli, $select_dokter);
					}										
				}
				$this->load->view('irj/rjvjmlpasienperdpjp',$data);
			}
	}

	public function lap_poli_irj_ada_tiga() {
		$data['title'] = 'Laporan Pasien Rawat Jalan/Darurat Baru';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl = $this->input->post('tgl');
		$data['tampil_per'] = $tipe_input;
		$id_poli = $this->input->post('id_poli');
		$id_dokter = $this->input->post('id_dokter');
		$data['id_poli'] = $this->input->post('id_poli');
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd_ada_tiga()->result();
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
		$tgl = date("Y-m-d");
		//$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_ada_tiga($tgl);
		//$data['diagnosa'] = $this->Rjmlaporan->get_diagnosa_pasien()->row();
		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_ada_tiga($tgl);

			//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_ada_3',$data);
      
		}

		if($tipe_input == 'TGL'){

		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_ada_tiga($tgl);
			} else {
				if($id_dokter == 'SEMUA') {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_pilih($tgl, $select_id_poli);
				} else {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_pilih($tgl, $select_id_poli);
				}
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_ada_3',$data);
		
		}

		if($tipe_input == 'BLN'){

			$data['tgl'] = $bulan;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_ada_tiga_bulan($bulan);
			} else {
				$select = explode("@", $this->input->post('id_poli'));
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_bulan_pilih($bulan, $select_id_poli);
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_ada_3',$data);
			
		}

		if($tipe_input == 'THN'){

			$data['tgl'] = $tahun;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_ada_tiga_tahun($tahun);
			} else {
				$select = explode("@", $this->input->post('id_poli'));
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_tahun_pilih($tahun, $select_id_poli);
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_ada_3',$data);
			
		}
	}

	public function lap_poli_irj_gaada_tiga() {
		$data['title'] = 'Laporan Pasien Rawat Jalan/Darurat Baru';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl = $this->input->post('tgl');
		$data['tampil_per'] = $tipe_input;
		$id_poli = $this->input->post('id_poli');
		$id_dokter = $this->input->post('id_dokter');
		$data['id_poli'] = $this->input->post('id_poli');
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd_gaada_tiga()->result();
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
		$tgl = date("Y-m-d");
		//$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		//$data['diagnosa'] = $this->Rjmlaporan->get_diagnosa_pasien()->row();
		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);

			//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_3',$data);
      
		}

		if($tipe_input == 'TGL'){

		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
			} else {
				if($id_dokter == 'SEMUA') {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_pilih($tgl, $select_id_poli);
				} else {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $this->input->post('id_dokter');
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_pilih_dokter($tgl, $select_id_poli, $select_dokter);
				}
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_3',$data);
		
		}

		if($tipe_input == 'BLN'){

			$data['tgl'] = $bulan;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_bulan($bulan);
			} else {
				if($id_dokter == 'SEMUA') {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_bulan_pilih($bulan, $select_id_poli);
				} else {
					$select = explode("@", $this->input->post('id_poli'));
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					$data['nm_poli']='<b>'.$select[1].'</b>';
					$select_dokter = $this->input->post('id_dokter');
					$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_bulan_pilih_dokter($bulan, $select_id_poli, $select_dokter);
				}
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_3',$data);
			
		}

		if($tipe_input == 'THN'){

			$data['tgl'] = $tahun;
		//$data['tgl_akhir'] = $tgl_akhir;
		//$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
		
			if($id_poli == "SEMUA") {
				$data['id_poli'] = "SEMUA";
				$data['data_kunjungan']=$this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_tahun($tahun);
			} else {
				$select = explode("@", $this->input->post('id_poli'));
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data['data_kunjungan'] = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_tahun_pilih($tahun, $select_id_poli);
			}


		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_pasien_poli_3',$data);
			
		}
	}

	public function lap_kunj_data_pasien_igd() {
		$data['title'] = 'Laporan Pasien Rawat Jalan/Darurat Baru';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl = $this->input->post('tgl');
		$data['tampil_per'] = $tipe_input;
		//$tgl_akhir = $this->input->post('tgl_akhir');
		//  $jam_akhir = $this->input->post('jam_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		//  $user_biling = $this->input->post('user_biling');

		//  $data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
		$tgl = date("Y-m-d");
		//$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);
		//$data['diagnosa'] = $this->Rjmlaporan->get_diagnosa_pasien()->row();
		foreach($data['data_kunjungan'] as $r) {
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;

			// $diff = $end->diff($start)->format("%a");
			// 	if($diff == 0){
			// 		$diff = 1;
			// 	}
			$data['umur'] = $y;
		}

			//  $data['tgl_awal_show'] = "";
			//  $data['tgl_akhir_show'] = "";
			//  $data['user_show'] = "";
		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);

			//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_data_pasien_igd',$data);
      
		}

		if($tipe_input == 'TGL'){

		$data['tgl'] = $tgl;
		//$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);
		foreach($data['data_kunjungan'] as $r) {
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;

			$data['umur'] = $y;
			// 	if($diff == 0){
			// 		$diff = 1;
			// 	}
		}

		

		//   $this->load->view('irj/rjvlink');
		$this->load->view('irj/list_kunj_data_pasien_igd',$data);
		
		}

		if($tipe_input == 'BLN'){

			$data['tgl'] = $bulan;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan']=$this->Rjmlaporan->get_lap_kunj_data_pasien_igd_bulan($bulan);
			foreach($data['data_kunjungan'] as $r) {
				$start = new DateTime($r['tgl_lahir']);//start
				$end = new DateTime('today');//end
				$y = $end->diff($start)->y;
	
				$data['umur'] = $y;
				// 	if($diff == 0){
				// 		$diff = 1;
				// 	}
			}
	
			
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/list_kunj_data_pasien_igd',$data);
			
		}

		if($tipe_input == 'THN'){

			$data['tgl'] = $tahun;
			//$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan']=$this->Rjmlaporan->get_lap_kunj_data_pasien_igd_tahun($tahun);
			foreach($data['data_kunjungan'] as $r) {
				$start = new DateTime($r['tgl_lahir']);//start
				$end = new DateTime('today');//end
				$y = $end->diff($start)->y;
	
				$data['umur'] = $y;
				// 	if($diff == 0){
				// 		$diff = 1;
				// 	}
			}

			//ini_set('memory_limit', '4096M');
			//   $this->load->view('irj/rjvlink');
			$this->load->view('irj/list_kunj_data_pasien_igd',$data);
			
		}
	}

	public function data_pasien_konsul_irj() {
		$data['title'] = 'Data Pasien Konsul';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['controller']=$this; 
		$data['poliklinik']=$this->Rjmpencarian->get_poliklinik()->result();
		$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -14 day'));
		$week_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_data_pasien_konsul_irj_new($week_awal, $week_akhir);
		$this->load->view('irj/list_data_pasien_konsul',$data);
      
	}

    public function lap_kunj_pasien_detail() {
		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl = date("Y-m-d");
			$data['title'] = 'Laporan Kunjugan Pasien Detail '.date("d F Y", strtotime($tgl));
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail('TGL', $tgl);
			$data['date'] = date("d F Y", strtotime($tgl));
			$data['tanggal'] = $tgl;
			$data['tampil'] = 'TGL';
			
			$this->load->view('irj/list_kunj_pasien_detail',$data);
		}

		if($tipe_input == 'TGL'){
			$data['title'] = 'Laporan Kunjugan Pasien Detail '.date("d F Y", strtotime($date));
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tipe_input, $date);
			$data['date'] = date("d F Y", strtotime($date));
			$data['tanggal'] = $date;
			$data['tampil'] = $tipe_input;

			$this->load->view('irj/list_kunj_pasien_detail',$data);
		}

		if($tipe_input == 'BLN') {
			$data['title'] = 'Laporan Kunjugan Pasien Detail '.date("F Y", strtotime($month));
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tipe_input, $month);
			$data['date'] = date("F Y", strtotime($month));
			$data['tanggal'] = $month;
			$data['tampil'] = $tipe_input;

			$this->load->view('irj/list_kunj_pasien_detail',$data);
		}
  	}

	public function excel_lapkunj_detail($tampil, $date) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Tanggal');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'No RM');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Lama/Baru');
		$sheet->setCellValue('F1', 'Cara Bayar');
		$sheet->setCellValue('G1', 'Umur');
		$sheet->setCellValue('H1', 'Jenis Kelamin');
		$sheet->setCellValue('I1', 'Kecamatan');

		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$data = $this->Rjmlaporan->get_kunj_pasien_detail($tipe_input, $date);

		$x = 2;

		foreach($data as $row) {
			$sheet->setCellValue('A'.$x, $row['tanggal']);
			$sheet->setCellValue('B'.$x, $row['no_register']);
			$sheet->setCellValue('C'.$x, $row['no_cm']);
			$sheet->setCellValue('D'.$x, $row['nama']);
			$sheet->setCellValue('E'.$x, $row['jns_kunj']);
			$sheet->setCellValue('F'.$x, $row['cara_bayar']);
			$tanggal_lahir = new DateTime($row['tgl_lahir']);
			$sekarang = new DateTime("today");
			$thn = $sekarang->diff($tanggal_lahir)->y;
			$sheet->setCellValue('G'.$x, $thn.' '.'Thn');
			$sheet->setCellValue('H'.$x, $row['jenis_kelamin']);
			$sheet->setCellValue('I'.$x, $row['kecamatan']);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjugan Pasien Detail '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lapkunjungan()
	{
		$data['title']='Laporan Kunjungan Pasien';

		$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result();
		//$tgl_indo = new Tglindo();
		$data['space']="";
		$data['cara_bayar']="SEMUA";
		$data['kontraktorcari']='';
		$result=$this->Rjmlaporan->get_data_kunj_poli_harian(date('Y-m-d'),$data['cara_bayar'],'')->row();

		if($result != null){
			
			$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();
																		
			// var_dump($data['data_laporan_kunj']);
			// die();									
			
			
			//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
			$tgl = date("d m Y");
			$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
			$data['tampil_per']="TGL";
			
			$data['tgl']=date("Y-m-d");
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['data_lap'] = "Ada";
			
		}else{
			$data['data_lap'] = "Kosong";
			$tgl = date("d m Y");
			$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
			$data['tampil_per']="TGL";
			
			$data['tgl']=date("Y-m-d");
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";
			$data['data_laporan_kunj']= array();
		}
		// var_dump($data['data_laporan_kunj']);
		// 			die();
		// var_dump($data['data_laporan_kunj']);die();
		$this->load->view('irj/rjvlapkunjungan',$data);
	}
	
	public function data_kunjungan()
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data['title']="Laporan Kunjungan Pasien";
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
			$data['space']="";
			$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result();
			$data['tampil_per']=$this->input->post('tampil_per');
			// $data['kontraktorcari']='';
			// var_dump($this->input->post('tampil_per'));
			// var_dump($this->input->post('cara_bayar'));
			// var_dump($this->input->post('tgl'));
			// var_dump(explode("@", $this->input->post('id_poli')));
			// var_dump($this->input->post('id_dokter'));
			// die();
				$data['cara_bayar']=$this->input->post('cara_bayar');				
				$data['kontraktorcari']=$this->input->post('bpjs_bayar');	

			if ($data['tampil_per'] == "TGL") {
									
				//date title
				$data['tgl']=$this->input->post('tgl');
				
				$data['cara_bayar']=$this->input->post('cara_bayar');				
				$data['kontraktorcari']=$this->input->post('bpjs_bayar');	
				$tgl = date('d m Y', strtotime($data['tgl']));
				//$data['date_title']='(<b>'.$tgl.'</b>)';
				$data['date_title']='<b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				
				//----------
				/*if($data['tgl_awal']!=$data['tgl_akhir']){
					$data['date_title']='<b>('.$tgl_awal1.' s/d '.$tgl_akhir1.')</b>';
				}else{
					$data['date_title']='<b>('.$tgl_awal1.')</b>';
				}*/
				// var_dump($this->input->post('id_poli'));
				
				
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						// var_dump($data['tgl']);
						// var_dump($data['cara_bayar']);
						// var_dump($this->input->post('bpjs_bayar'));
						// die();
						$result=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();
						
						if ($result != null) {
							$data['data_lap'] = "Ada";
							$data['id_poli']="SEMUA";
							$data['id_dokter']=$this->input->post('id_dokter');
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();
							
						
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row(['tgl_lahir']);
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;	
						}else{
							$data['data_lap'] = "Kosong";
							$data['id_poli']="SEMUA";
							$data['id_dokter']='SEMUA';
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();					
							$data['data_laporan_kunj']=array();
						}
						
			
					}else{
						$data['id_poli']="SEMUA";
						$data['data_lap'] = "Kosong";		
						$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();		
						$data['data_laporan_kunj']=array();
						echo "Data Kosong";
					}
																
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$result=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$this->input->post('id_dokter');
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();				
							// 	var_dump($data['data_laporan_kunj']);
							// die();	
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$select_dokter = $this->input->post('id_dokter');
						$result=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$this->input->post('id_dokter');
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->result();


							
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}										
				}
					
			} else if ($data['tampil_per'] == "BLN") {
				
				//date title
				$data['bulan']=$this->input->post('bulan');
				//$bulan = date('m Y', strtotime($data['bulan']));
				$bulan1 = substr($data['bulan'],5,2)." ".date('Y', strtotime($data['bulan']));
				$data['date_title']='<b>('.$bulan1.')</b>';
				//----------
				$data['cara_bayar']='';
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_bulanan($data['bulan'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_bulanan($data['bulan'],$data['id_poli'])->result();
				}
			
			} else if ($data['tampil_per'] == "THN") {
					
				//date title
				$data['tahun']=$this->input->post('tahun');
				$data['date_title']='<b>('.$data['tahun'].')</b>';
				//----------
				$data['cara_bayar']='';
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_tahunan($data['tahun'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_tahunan($data['tahun'],$data['id_poli'])->result();
				}
			
			} else{
				$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();
																		
				// var_dump($data['data_laporan_kunj']);
				// die();									
				
				
				//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
				$tgl = date("d m Y");
				$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				$data['tampil_per']="TGL";
				
				$data['tgl']=date("Y-m-d");
				$data['poli']=$this->Rjmpencarian->get_poliklinik_non_igd()->result();
				$data['id_poli']="SEMUA";
				$data['id_dokter']="SEMUA";

				$data['data_lap'] = "Ada";
			}
			


			$this->load->view('irj/rjvlapkunjungan',$data);
		}else{
			redirect('irj/Rjclaporan/rjvlapkunjungan','refresh');
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////keuangan poli
	public function lapkeu()
	{
		$data['title']='Laporan Keuangan Instalasi Rawat Jalan';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_harian(date("Y-m-d"),date('Y-m-d', strtotime('-7 days')), $data['status'],$data['cara_bayar'])->result();
		//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
		$tgl = date("d m Y");
		$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));
		$data['select_poli']=$this->Rjmpencarian->get_poliklinik()->result();
		$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
		$data['id_poli']="SEMUA";		

		if($this->input->post('tgl')!=''){
			$tgl0=$this->input->post('tgl');
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
		}

		if($this->input->post('tgl0')!=''){
			$tgl1=$this->input->post('tgl0');
		}else{
			$tgl1=date('Y-m-d');
		}

		if($this->input->post('id_poli')==''){
			$data['id_poli']="SEMUA";
			$data['nm_poli']='SEMUA';
		}else{
			//$data['id_poli']=$this->input->post('id_poli');
			$select_poli = explode("@", $this->input->post('id_poli'));
			$data['id_poli']=$select_poli[0];
			$data['nm_poli']='<b>'.$select_poli[1].'</b>';
		}
		
		$id_poli=$data['id_poli'];
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeuangan',$data);
	}
	
	public function data_keu()
	{
		if($this->input->post('tgl')!=''){
			$tgl0=$this->input->post('date_picker_days0');
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
		}

		if($this->input->post('tgl0')!=''){
			$tgl1=$this->input->post('date_picker_days1');
		}else{
			$tgl1=date('Y-m-d');
		}

		$id_poli=$this->input->post('id_poli');
		$status="10";
		$cara_bayar="SEMUA";
		if($_SERVER['REQUEST_METHOD']=='POST'){

				echo '<script type="text/javascript">window.open("'.site_url("irj/rjexcel/excel_lapkeu/$id_poli/$tgl0/$status/$cara_bayar/$tgl1").'", "_blank");window.focus()</script>';
				// /rjcexcel/excel_lapkeu/$id_poli/$tgl/$status/$cara_bayar/$tgl1
			$data['title']="Laporan Keuangan Instalasi Rawat Jalan";
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->input->post('cara_bayar');			
			// $tgl_indo = new Tglindo();
			$data['tgl_indo'] = date('Y-m-d');
			
			//status rawat jalan
			if ($this->input->post('status_pulang')=='1' && $this->input->post('status_dirawat')=='1') {
				$data['status']= "10";
			} else if ($this->input->post('status_pulang')=='1' && $this->input->post('status_dirawat')=='') {
				$data['status']= "1";
			} else if ($this->input->post('status_pulang')=='' && $this->input->post('status_dirawat')=='1') {
				$data['status']= "0";
			} else {
				$data['status']= "10";
			}
			
			$data['tampil_per']=$this->input->post('tampil_per');
			if ($data['tampil_per'] == "TGL") {
						
				//date title
				$data['tgl']=$this->input->post('tgl');
				$tgl = date('d m Y', strtotime($data['tgl']));
				//$data['date_title']='(<b>'.$tgl.'</b>)';
				$data['date_title']='<b>('.substr($tgl,0,2).' '.$tgl_indo->bulan(substr($tgl,3,2)).' '.substr($tgl,6,4).')</b>';
				//----------
				/*if($data['tgl_awal']!=$data['tgl_akhir']){
					$data['date_title']='<b>('.$tgl_awal1.' s/d '.$tgl_akhir1.')</b>';
				}else{
					$data['date_title']='<b>('.$tgl_awal1.')</b>';
				}*/
				
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_harian($data['tgl'], $data['status'],$data['cara_bayar'])->result();	
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_harian($data['tgl'],$data['id_poli'], $data['status'],$data['cara_bayar'])->result();
				}
					
			} else if ($data['tampil_per'] == "BLN") {
					
				//date title
				$data['bulan']=$this->input->post('bulan');
				$bulan = date('m Y', strtotime($data['bulan']));
				$data['date_title']='<b>('.$tgl_indo->bulan(substr($bulan,0,2)).' '.substr($bulan,3,4).')</b>';
				//----------
				
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_bulanan($data['bulan'], $data['status'], $data['cara_bayar'])->result();
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_bulanan($data['bulan'],$data['id_poli'], $data['status'], $data['cara_bayar'])->result();
				}
			
			} else if ($data['tampil_per'] == "THN") {
					
				//date title
				$data['tahun']=$this->input->post('tahun');
				$data['date_title']='<b>('.$data['tahun'].')</b>';
				//----------
				
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_tahunan($data['tahun'], $data['status'], $data['cara_bayar'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_tahunan($data['tahun'],$data['id_poli'], $data['status'], $data['cara_bayar'])->result();
				}
			
			}
			
			$this->load->view('irj/rjvlapkeuangan',$data);
		}else{
			redirect('irj/Rjclaporan/rjvlapkeuangan','refresh');
		}
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////pendapatan dokter
	public function lapkeu_dokter()
	{
		$data['title']='Laporan Pendapatan Dokter Instalasi Rawat Jalan';
		// $tgl_indo = new Tglindo();
		$data['id_dokter']='SEMUA';
		$data['cara_bayar']="SEMUA";
		// $data['datakeu_dokter']=$this->Rjmlaporan->get_data_keu_dokter($data['id_dokter'], date("Y-m-d"), date("Y-m-d"), $data['cara_bayar'])->result();
		$data['select_dokter']=$this->Rjmpencarian->get_dokter()->result();
		$data['dokter']=$this->Rjmlaporan->get_dokter()->result();
		$data['poliklinik']=$this->Rjmlaporan->get_poliklinik()->result();
		$data['ruang']=$this->Rjmlaporan->get_ruang()->result();
		$tgl=date("d m Y");
		$data['date_title']='Hari ini <b>('.substr($tgl,0,2).' '.substr($tgl,3,2).' '.substr($tgl,6,4).')</b>';
		$data['tgl_awal']=date("Y-m-d");
		$data['tgl_akhir']=date("Y-m-d");
		$data['datakeu_dokter']= null;
		
		$this->load->view('irj/rjvlapkeuangandokter',$data);
	}
	public function datakeu_dokter()
	{
		// $tgl_indo = new Tglindo();
		$data['title']='Laporan Pendapatan Dokter';

		$data['select_dokter']=$this->Rjmpencarian->get_dokter()->result();
		$data['dokter']=$this->Rjmlaporan->get_dokter()->result();
		$data['poliklinik']=$this->Rjmlaporan->get_poliklinik()->result();
		$data['ruang']=$this->Rjmlaporan->get_ruang()->result();
		
		$data['id_dokter']=$this->input->post('id_dokter');
		$data['jenis_pelayanan']=$this->input->post('jenis_pelayanan');
		$data['poli']=$this->input->post('poli');
		$data['idrg']=$this->input->post('ruang');
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data['tgl_awal']=$this->input->post('tgl_awal');
			$tgl_awal1 = date('Y-m-d', strtotime($data['tgl_awal']));
			$data['tgl_akhir']=$this->input->post('tgl_akhir');
			$tgl_akhir1 = date('Y-m-d', strtotime($data['tgl_akhir']));
			
			if($data['tgl_awal']!=$data['tgl_akhir']){
				$tgl_indo1=$tgl_awal1;
				$tgl_indo2=$tgl_akhir1;
				$data['date_title']='<b>('.$data['tgl_awal'].' s/d '.$data['tgl_akhir'].')</b>';
			}else{
				$data['date_title']='<b>('.$data['tgl_awal'].' s/d '.$data['tgl_akhir'].')</b>';
			}

			// if ($data['id_dokter']!='SEMUA') {
			// 	$dokter = explode("@", $data['id_dokter']);
			// 	$data['id_dokter']=$dokter[0];
			// 	$data['nm_dokter']=$dokter[1];
			// }else{
			// 	$data['dokter']=$this->Rjmlaporan->get_data_keu_det_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $data['cara_bayar'])->result();
			// }
			
			// $data['datakeu_dokter']=$this->Rjmlaporan->get_data_keu_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $data['cara_bayar'])->result();
			$data['datakeu_dokter']=$this->Rjmlaporan->get_data_keu_dokter_report($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $data['jenis_pelayanan'],$data['poli'],$data['idrg'])->result();
			//print_r($data['datakeu_dokter']);
			$this->load->view('irj/rjvlapkeuangandokter',$data);
		}else{
			redirect('irj/Rjclaporan/lapkeu_dokter','refresh');
		}
	}
	
	public function cetak($tipe='', $tgl_awal='',$tgl_akhir='')
	{

		// $tgl_indo=new Tglindo();
		
		
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		// $data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$alamat=$row->alamat;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
		////EXCEL 
		//$this->load->library('Excel');  
		 $this->load->file(APPPATH.'third_party/PHPExcel.php');   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Kunjungan ".$namars)  
		        ->setSubject("Laporan Kunjungan ".$namars." Document")  
		        ->setDescription("Laporan Kunjungan HMIS ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan User");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$tgl1 = date('d F Y', strtotime($tgl_awal));	
		$tgl2 = date('d F Y', strtotime($tgl_akhir));

		if($tipe=='mskiri1'){				
			$data_user=$this->Rjmlaporan->get_data_iri_masuk_lt1($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskiri2'){
			$data_user=$this->Rjmlaporan->get_data_iri_masuk_lt2($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskiri3'){
			$data_user=$this->Rjmlaporan->get_data_iri_masuk_lt3($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskirj'){
			$data_user=$this->Rjmlaporan->get_data_irj_masuk($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskird'){
			$data_user=$this->Rjmlaporan->get_data_ird_masuk($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri1'){
			$data_user=$this->Rjmlaporan->get_data_iri_keluar_lt1($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri2'){
			$data_user=$this->Rjmlaporan->get_data_iri_keluar_lt2($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri3'){
			$data_user=$this->Rjmlaporan->get_data_iri_keluar_lt3($tgl_awal,$tgl_akhir)->result();
		}
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_kunj_pasien.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl2);

				$vtot1=0;$vtot2=0;
				$i=1;
				$rowCount = 5;
				//print_r($data_user); break;
				foreach($data_user as $row){				
					$j=1;		
					$vtot1=$vtot1+$row->total;
					 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->total);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, date('d-m-Y',strtotime($row->tgl)));
							 	$i++;
							 								
						$rowCount++;
						// if
					
				}
				
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total Input');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,  $vtot1);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_'.$tipe.'_TGL_'.date('d-m-Y', strtotime($tgl_awal)).'_'.date('d-m-Y', strtotime($tgl_akhir)).'.xlsx"');  

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

	public function cetak_all($tgl_awal='',$tgl_akhir='')
	{

		// $tgl_indo=new Tglindo();
		
		
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		// $data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$alamat=$row->alamat;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Kunjungan ".$namars)  
		        ->setSubject("Laporan Kunjungan ".$namars." Document")  
		        ->setDescription("Laporan Kunjungan HMIS ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan User");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$tgl1 = date('d F Y', strtotime($tgl_awal));	
		$tgl2 = date('d F Y', strtotime($tgl_akhir));
					
		$data_user=$this->Rjmlaporan->get_data_kunj_all($tgl_awal,$tgl_akhir)->result();		
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_kunj_pasien_all.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Laporan Kunjungan Semua Pasien');
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl2);

				$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;$vtot5=0;$vtot6=0;$vtot7=0;$vtot8=0;$vtot9=0;
				$i=1;
				$rowCount = 6;
				//print_r($data_user); break;
				foreach($data_user as $row){				
					$j=1;		
					$vtot1=$vtot1+$row->total;
					$vtot2=$vtot2+$row->ird;
					$vtot3=$vtot3+$row->irj;
					$vtot4=$vtot4+$row->iri_masuk1;
					$vtot5=$vtot5+$row->iri_masuk2;
					$vtot6=$vtot6+$row->iri_masuk3;
					$vtot7=$vtot7+$row->iri_keluar1;
					$vtot8=$vtot8+$row->iri_keluar2;
					$vtot9=$vtot9+$row->iri_keluar3;
					 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, date('d-m-Y',strtotime($row->tanggal)));
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->total);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->ird);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->irj);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->iri_masuk1);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->iri_masuk2);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->iri_masuk3);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->iri_keluar1);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->iri_keluar2);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->iri_keluar3);

							 	$i++;
							 								
						$rowCount++;
						// if
					
				}
				
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,  $vtot1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,  $vtot2);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $vtot3);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,  $vtot4);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,  $vtot5);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,  $vtot6);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,  $vtot7);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,  $vtot8);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,  $vtot9);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_All_TGL_'.date('d-m-Y', strtotime($tgl_awal)).'_'.date('d-m-Y', strtotime($tgl_akhir)).'.xlsx"');  

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle($namars);  
		   
		   
		   
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

	public function data_dokter_poli($id_poli='')
	{
		if ($id_poli == "SEMUA") {
			echo "<option selected value=''>-Pilih Dokter-</option>";
			echo "<option value='SEMUA'>SEMUA</option> ";				
		}else{
			$data=$this->Rjmlaporan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			echo "<option value='SEMUA'>SEMUA</option> ";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
		}
		
	}


	public function lap_dig_kasus_jenkel()
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Diagnosa, Kasus Dan Jenis Kelamin';
		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$lap_per = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');
		$data['tgl'] = $tgl;
		$data['bulan'] = $bulan;
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;

		if ($lap_per == '') {
				$data['diagnosa']=array();
				$data['jumlah_l'] = '';	
				$data['jumlah_p'] = '';	
				$data['jumlah_baru'] = '';
				$data['jumlah_lama'] = '';
				$data['jumlah_total'] = '';
				$data['valid'] = 'ADA';
				$data['judul'] = '';		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tgl,$lap_per,$layanan)->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tgl,$lap_per,$layanan)->result();				
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.date('d-m-Y',strtotime($tgl));
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($bulan,$lap_per,$layanan)->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.date('m-Y',strtotime($bulan));
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tahun,$lap_per)->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
						$data['valid'] = 'KOSONG';
						$data['judul'] = '';
				}
			}	
		}
				

		
		$this->load->view('irj/rjvlapdigkasusjenkel',$data);
		
	}

	public function lap_wilayah_jaminan()
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Wilayah Dan Jaminan';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');

		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;		

		if ($lap_per == '') {
				$data['diagnosa']=array();
				$data['jumlah_umum'] = '';
				$data['jumlah_bpjs'] = '';	
				$data['jumlah_inhealth'] = '';	
				$data['jumlah_nayaka'] = '';	
				$data['jumlah_bukit_asam'] = '';	
				$data['jumlah_telkom'] = '';	
				$data['jumlah_pln'] = '';	
				$data['jumlah_taspen'] = '';	
				$data['jumlah_jasa_rahaja'] = '';	
				$data['jumlah_bpjs_pbi'] = '';	
				$data['jumlah_bpjs_mandiri'] = '';	
				$data['jumlah_bpjs_non_pbi'] = '';	
				$data['jumlah_total'] = '';	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tgl,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.date('d-m-Y',strtotime($tgl));
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($bulan,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.date('m-Y',strtotime($bulan));
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tahun,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);
	
					$data['jumlah_umum'] = $jumlah_umum;
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				

		
		$this->load->view('irj/rjvlapwilayahjaminan',$data);
		
	}

	public function lap_jenkel_jaminan_kasus()
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Jenis Kelamin ,Jaminan Dan Kasus';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');

		$data['tgl'] = $tgl;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;

		if ($lap_per == '') {
			
				$data['kunj_poli']=array();
				$data['jumlah_umum_baru_l'] = '';
				$data['jumlah_umum_baru_p'] = '';	
				$data['jumlah_umum_lama_l'] = '';
				$data['jumlah_umum_lama_p'] = '';	

				$data['jumlah_bpjs_baru_l'] = '';
				$data['jumlah_bpjs_baru_p'] = '';	
				$data['jumlah_bpjs_lama_l'] = '';
				$data['jumlah_bpjs_lama_p'] = '';	

				$data['jumlah_bukit_asam_baru_l'] = '';
				$data['jumlah_bukit_asam_baru_p'] = '';	
				$data['jumlah_bukit_asam_lama_l'] = '';
				$data['jumlah_bukit_asam_lama_p'] = '';	

				$data['jumlah_pln_baru_l'] = '';
				$data['jumlah_pln_baru_p'] = '';	
				$data['jumlah_pln_lama_l'] = '';
				$data['jumlah_pln_lama_p'] = '';	

				$data['jumlah_inhealth_baru_l'] = '';
				$data['jumlah_inhealth_baru_p'] = '';	
				$data['jumlah_inhealth_lama_l'] = '';
				$data['jumlah_inhealth_lama_p'] = '';		

				$data['jumlah_telkom_baru_l'] = '';
				$data['jumlah_telkom_baru_p'] = '';	
				$data['jumlah_telkom_lama_l'] = '';
				$data['jumlah_telkom_lama_p'] = '';

				$data['jumlah_baru'] = '';
				$data['jumlah_lama'] = '';	
					
				$data['jumlah_total'] = '';	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
		
			
		
		}else{
			if ($lap_per == 'TGL') {

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tgl,$lap_per,$layanan)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($bulan,$lap_per,$layanan)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = 'Bulan'.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tahun,$lap_per)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tahun,$lap_per)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = 'Tahun'.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	

			}else{
				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
			}	
		}
				

		
		$this->load->view('irj/rjvlapjenkeljaminankasus',$data);
		
	}

	public function lap_wilayah_diagnosa()
	{		
		// $valid=$this->Rjmlaporan->get_kunj_wilayah_diagnosa('','')->result();
		
		$data['title']='Laporan Poliklinik Berdasarkan Wilayah Dan Diagnosa';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$data['lap_per'] = $lap_per;
		if ($lap_per == '') {

			$valid=$this->Rjmlaporan->get_wilayah_detail('','')->row();

			if ($valid != null) {
				// $data['kunj_poli']=$this->Rjmlaporan->get_kunj_wilayah_diagnosa('','')->result();
				$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
				$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
				$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail('','')->result();													
		
				
				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['diagnosa']= array();
				$data['wilayah']= array();
				$data['wilayah_detail']= array();
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {

				$data['tgl'] = $tgl;

				$valid=$this->Rjmlaporan->get_wilayah_detail($tgl,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($tgl,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){

				$valid=$this->Rjmlaporan->get_wilayah_detail($bulan,$lap_per)->row();
				$data['bulan'] = $bulan;
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($bulan,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
				
			}elseif($lap_per == 'THN'){

				$valid=$this->Rjmlaporan->get_wilayah_detail($tahun,$lap_per)->row();
				$data['tahun'] = $tahun;
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($tahun,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_wilayah_detail('','')->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail('','')->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
			}	
		}
				

		
		$this->load->view('irj/rjvlapwilayahdiagnosa',$data);
		
	}
	
	public function excel_lapkunj_irj($tampil_per='', $id_poli='',$tgl='',$cara_bayar='',$id_dokter = '')
	{
		// var_dump($tampil_per);die();
		$poli=$this->Rjmpencarian->get_poliklinik()->result();
		
		if ($tampil_per == "TGL") {
									
			//date title				
			$kontraktorcari=$this->input->post('bpjs_bayar');	
			// $tgl = date('d m Y', strtotime($tgl));
			$date_title='<b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
			
				
			if ($id_poli=="SEMUA") {					
				if ($id_dokter=="SEMUA") {					
					$result=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$cara_bayar,$this->input->post('bpjs_bayar'))->row();
					
					if ($result != null) {
						$data=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$cara_bayar,$this->input->post('bpjs_bayar'))->result();
						
					
						$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$cara_bayar,$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
						$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
						$waktu_masuk_poli = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
						
						// $tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$cara_bayar,'')->row()->tgl_lahir;
						// $tahun_tgl_lahir = substr($tgl_lahir,0,4);
						// $tahun_sekarang = date('Y');
						// $pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
						// $tgl_lahir = $pengurangan;	

						
					}else{

					}	
				}else{
					echo "Data Kosong";
				}						
														
			} else {
				if ($id_dokter=="SEMUA") {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$result=$this->Rjmlaporan->get_data_kunj_harian($tgl,$select_id_poli,$cara_bayar,$this->input->post('bpjs_bayar'))->row();

					if($result != null){
						$select_poli = explode("@", $id_poli);
						$id_poli=$select_poli[0];
						// $nm_poli='<b>'.$select_poli[1].'</b>';
						$data=$this->Rjmlaporan->get_data_kunj_harian($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'))->result();
						
						$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
						$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
						$waktu_masuk_poli = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
						
						// $tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
						// $tahun_tgl_lahir = substr($tgl_lahir,0,4);
						// $tahun_sekarang = date('Y');
						// $pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
						// $tgl_lahir = $pengurangan;
					}else{			
						
					}
					
				}else{
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$select_dokter = $id_dokter;
					$result=$this->Rjmlaporan->get_data_kunj_harian_dokter($tgl,$select_id_poli,$cara_bayar,$this->input->post('bpjs_bayar'),$select_dokter)->row();

					if($result != null){
						$select_poli = explode("@", $id_poli);
						$id_poli=$select_poli[0];
						// $nm_poli='<b>'.$select_poli[1].'</b>';
						$data=$this->Rjmlaporan->get_data_kunj_harian_dokter($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'),$select_dokter)->result();

						$poli=$this->Rjmpencarian->get_poliklinik()->result();	
						$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian_dokter($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
						$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
						$waktu_masuk_poli = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
						
						// $tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian_dokter($tgl,$id_poli,$cara_bayar,$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
						// $tahun_tgl_lahir = substr($tgl_lahir,0,4);
						// $tahun_sekarang = date('Y');
						// $pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
						// $tgl_lahir = $pengurangan;
					}else{			
						
					}
					
				}	
				
						
														
			}
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama');
				$sheet->setCellValue('C1', 'No MR');
				$sheet->setCellValue('D1', 'No SEP');
				$sheet->setCellValue('E1', 'Umur');
				$sheet->setCellValue('F1', 'Jenis Kelamin');
				$sheet->setCellValue('G1', 'Jaminan');
				$sheet->setCellValue('H1', 'Kontraktor');
				$sheet->setCellValue('I1', 'Alamat');
				$sheet->setCellValue('J1', 'Diagnosa');
				$sheet->setCellValue('K1', 'ICD-10');
				$sheet->setCellValue('L1', 'Kasus');
				$sheet->setCellValue('M1', 'Poli');
				$sheet->setCellValue('N1', 'xdaftar');
				$sheet->setCellValue('O1', 'Dokter');
				$sheet->setCellValue('P1', 'Waktu Daftar Ulang');
				$sheet->setCellValue('Q1', 'Waktu Tindak Perawat');
				$sheet->setCellValue('R1', 'Waktu Tindak Dokter');
				$sheet->setCellValue('S1', 'Waktu Penyerahan Obat');
				$sheet->setCellValue('T1', 'Selisih Daftar Ulang Penyerahan Obat');
				$sheet->setCellValue('U1', 'Selisih Dokter Perawat');
				$sheet->setCellValue('V1', 'Selisih Daftar Ulang Dokter');
				$sheet->setCellValue('W1', 'No Register');
				$sheet->setCellValue('X1', 'Keterangan');


				$no = 1;
				$x = 2;
				foreach ($poli as $key) {
					foreach($data as $row){
						if ($key->id_poli==$row->id_poli) {	
							$car = $row->cara_bayar;
						
							if($car == 'BPJS'){
								$car_bar = $row->kontraktor;
							}else if($row->cara_bayar=='KERJASAMA'){
								$car_bar = $row->kontraktor;
							}else{ 
								$car_bar = $row->cara_bayar;
							}

							if($row->waktu_masuk_poli == null){
								$waktu_mapol = '';
							} else{
								$waktu_mapol = date('H:i:s',strtotime($row->waktu_masuk_poli)); 
							}

							if($row->waktu_masuk_dokter == null){
								$waktu_madok = '';
							}else{
								$waktu_madok = date('H:i:s',strtotime($row->waktu_masuk_dokter));
							}

							if($row->waktu_pulang == null){
								$waktu_mapul = '';
							}else{
								$waktu_mapul = date('H:i:s',strtotime($row->waktu_pulang));
							}

							$nm_poli = $this->Rjmlaporan->get_nm_poli($row->id_poli)->row()->nm_poli;

							if($row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null){
								$waktu_masuk_poli = date_create($row->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);
								$diff = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);
								$selisih_dokper = date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
							}else{
								$selisih_dokper = '';
							}	

							$detik = 0;
							$menit = 0;
							$jam = 0;
							$jam_array = array();
							if ($row->tgl_kunjungan != null && $row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null) {

								$waktu_masuk = date_create($row->tgl_kunjungan);
								$waktu_masuk_poli = date_create($row->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);
								
								$diff1 = date_diff($waktu_masuk_poli,$waktu_masuk);
								$diff2 = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);
								$diff3 = date_diff($waktu_masuk_dokter,$waktu_masuk);

								$waktu_awal = date_create(date('H:i:s',strtotime($diff1->h.':'.$diff1->i.':'.$diff1->s)));																
								$waktu_akhir = date_create(date('H:i:s',strtotime($diff2->h.':'.$diff2->i.':'.$diff2->s)));

								$last_diff = date_diff($waktu_akhir,$waktu_awal);
								$lama_tunggu =  date('H:i:s',strtotime($diff3->h.':'.$diff3->i.':'.$diff3->s));																															
																															
							}else{
								$lama_tunggu =  '';
							}

							if($row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null){
								$waktu_daftar_ulang = date_create($row->tgl_kunjungan);
								$waktu_penyerahan_obat = date_create($row->wkt_penyerahan_obat);
								$diff = date_diff($waktu_penyerahan_obat,$waktu_daftar_ulang);
								$selisih_penyerahan =  date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
							}else{
								$selisih_penyerahan = '';
							}	

							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, strtoupper($row->nama));
							$sheet->setCellValue('C'.$x, $row->no_cm);
							$sheet->setCellValue('D'.$x, $row->no_sep);
							$sheet->setCellValue('E'.$x, (int)date('Y') - (int)date('Y',strtotime($row->tgl_lahir)));
							$sheet->setCellValue('F'.$x, $row->sex);
							$sheet->setCellValue('G'.$x, $row->cara_bayar);
							$sheet->setCellValue('H'.$x, $row->kontraktor);
							$sheet->setCellValue('I'.$x, $row->kotakabupaten);
							$sheet->setCellValue('J'.$x, $row->diagnosa);
							$sheet->setCellValue('K'.$x, $row->id_diagnosa);
							$sheet->setCellValue('L'.$x, $row->jns_kunj);
							$sheet->setCellValue('M'.$x, $nm_poli);
							$sheet->setCellValue('N'.$x, $row->xdaftar);
							$sheet->setCellValue('O'.$x, $row->nm_dokter);
							$sheet->setCellValue('P'.$x, date('H:i:s',strtotime($row->tgl_kunjungan)));
							$sheet->setCellValue('Q'.$x, $waktu_mapol);
							$sheet->setCellValue('R'.$x, $waktu_madok);
							$sheet->setCellValue('S'.$x, isset($row->wkt_penyerahan_obat)?date('h:i:s',strtotime($row->wkt_penyerahan_obat)):'');
							$sheet->setCellValue('T'.$x, $selisih_penyerahan);
							$sheet->setCellValue('U'.$x, $selisih_dokper);
							$sheet->setCellValue('V'.$x, $lama_tunggu);
							$sheet->setCellValue('W'.$x, $row->no_register);
							$sheet->setCellValue('X'.$x, str_replace('_', ' ',$row->ket_pulang));

							$x++;
						}	
														
					}
				}
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan IRJ';
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
				
		} else if ($tampil_per == "BLN") {
			//date title
			$bulan=$tgl;
			//$bulan = date('m Y', strtotime($bulan));
			$bulan1 = substr($bulan,5,2)." ".date('Y', strtotime($bulan));
			$date_title='<b>('.$bulan1.')</b>';
			
			$cara_bayar='';
			if ($id_poli=="SEMUA") {
				$id_poli="SEMUA";
				$data=$this->Rjmlaporan->get_data_kunj_poli_bulanan($bulan)->result();

				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Poli');
				$sheet->setCellValue('C1', 'Tanggal');
				$sheet->setCellValue('D1', 'Pasien Baru');
				$sheet->setCellValue('E1', 'Pasien Lama');
				$sheet->setCellValue('F1', 'UMUM');
				$sheet->setCellValue('G1', 'BPJS');
				$sheet->setCellValue('H1', 'KERJASAMA');
				$sheet->setCellValue('I1', 'Jumlah Kunjungan');
				$sheet->setCellValue('J1', 'Jumlah Batal');
				$sheet->setCellValue('K1', 'User');

				$vtotbaru=0; $vtotlama=0;$vtotbatal=0; $vtotumum=0;$vtotbpjs=0;$vtotkerjasama=0;$vtot=0;
				
				$no = 1;
				$x = 2;
				foreach ($poli as $key) {
					foreach($data as $row){
						if ($key->id_poli==$row->id_poli) {	
							
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $key->nm_poli);
							$sheet->setCellValue('C'.$x, $row->tgl_kunj);
							$sheet->setCellValue('D'.$x, $row->pasien_baru);
							$sheet->setCellValue('E'.$x, $row->pasien_lama);
							$sheet->setCellValue('F'.$x, $row->umum);
							$sheet->setCellValue('G'.$x, $row->bpjs);
							$sheet->setCellValue('H'.$x, $row->kerjasama);
							$sheet->setCellValue('I'.$x, $row->jumlah_kunj);
							$sheet->setCellValue('J'.$x, $row->jumlah_batal);
							$sheet->setCellValue('K'.$x, $row->nmuser);
							$x++;

							$vtotbaru += $row->pasien_baru;
							$vtotlama += $row->pasien_lama;
							$vtotumum += $row->umum;
							$vtotbpjs += $row->bpjs;
							$vtotkerjasama += $row->kerjasama;
							$vtot += $row->jumlah_kunj;
							$vtotbatal += $row->jumlah_batal;
						}	
														
					}
				}

				
				$sheet->setCellValue('A'.$x, 'TOTAL');
				$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
				$sheet->setCellValue('D'.$x, $vtotbaru);
				$sheet->setCellValue('E'.$x, $vtotlama);
				$sheet->setCellValue('F'.$x, $vtotumum);
				$sheet->setCellValue('G'.$x, $vtotbpjs);
				$sheet->setCellValue('H'.$x, $vtotkerjasama);
				$sheet->setCellValue('I'.$x, $vtot);
				$sheet->setCellValue('J'.$x, $vtotbatal);

				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan IRJ';
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			} else {
				$select_poli = explode("@", $id_poli);
				$id_polis=$select_poli[0];
				// $nm_poli='<b>'.$select_poli[1].'</b>';
				$data=$this->Rjmlaporan->get_data_kunj_bulanan($bulan,$id_polis)->result();

				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Poli');
				$sheet->setCellValue('C1', 'Tanggal');
				$sheet->setCellValue('D1', 'Pasien Baru');
				$sheet->setCellValue('E1', 'Pasien Lama');
				$sheet->setCellValue('F1', 'Jumlah Kunjungan');
				$sheet->setCellValue('G1', 'Jumlah Batal');
				$sheet->setCellValue('H1', 'User');

				$vtotbaru=0; $vtotlama=0;$vtotbatal=0;$vtot=0;
				
				$no = 1;
				$x = 2;
				foreach ($poli as $key) {
					foreach($data as $row){
						if ($key->id_poli==$row->id_poli) {	
							
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $key->nm_poli);
							$sheet->setCellValue('C'.$x, $row->tgl_kunj);
							$sheet->setCellValue('D'.$x, $row->pasien_baru);
							$sheet->setCellValue('E'.$x, $row->pasien_lama);
							$sheet->setCellValue('F'.$x, $row->jumlah_kunj);
							$sheet->setCellValue('G'.$x, $row->jumlah_batal);
							$sheet->setCellValue('H'.$x, $row->nmuser);
							$x++;

							$vtotbaru += $row->pasien_baru;
							$vtotlama += $row->pasien_lama;
							$vtot += $row->jumlah_kunj;
							$vtotbatal += $row->jumlah_batal;
						}	
														
					}
				}

				
				$sheet->setCellValue('A'.$x, 'TOTAL');
				$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
				$sheet->setCellValue('D'.$x, $vtotbaru);
				$sheet->setCellValue('E'.$x, $vtotlama);
				$sheet->setCellValue('F'.$x, $vtot);
				$sheet->setCellValue('G'.$x, $vtotbatal);
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan IRJ';
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			}
				
		
		} else if ($tampil_per == "THN") {
				
			//date title
			$tahun=$tgl;
			$date_title='<b>('.$tahun.')</b>';
			//----------
			$cara_bayar='';
			if ($id_poli=="SEMUA") {
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$id_poli="SEMUA";
				$data=$this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun)->result();

				
			} else {
				$select_poli = explode("@", $id_poli);
				$id_poli=$select_poli[0];
				// $nm_poli='<b>'.$select_poli[1].'</b>';
				$data=$this->Rjmlaporan->get_data_kunj_tahunan($tahun,$id_poli)->result();
			}


			
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Nama Poli');
				$sheet->setCellValue('C1', 'Bulan');
				$sheet->setCellValue('D1', 'Jumlah Kunjungan');

				$vtot=0;
				
				$no = 1;
				$x = 2;
				foreach ($poli as $key) {
					foreach($data as $row){
						if ($key->id_poli==$row->id_poli) {	
							
							$sheet->setCellValue('A'.$x, $no++);
							$sheet->setCellValue('B'.$x, $key->nm_poli);
							$sheet->setCellValue('C'.$x, $row->bulan_kunj);
							$sheet->setCellValue('D'.$x, $row->jumlah_kunj);
							$x++;

							$vtot += $row->jumlah_kunj;
						}	
														
					}
				}

				
				$sheet->setCellValue('A'.$x, 'TOTAL');
				$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
				$sheet->setCellValue('D'.$x, $vtot);
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kunjungan IRJ';
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
		
		}else{

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama');
			$sheet->setCellValue('C1', 'No MR');
			$sheet->setCellValue('D1', 'Umur');
			$sheet->setCellValue('E1', 'Jenis Kelamin');
			$sheet->setCellValue('F1', 'Jaminan');
			$sheet->setCellValue('G1', 'Alamat');
			$sheet->setCellValue('H1', 'Diagnosa');
			$sheet->setCellValue('I1', 'ICD-10');
			$sheet->setCellValue('J1', 'Kasus');
			$sheet->setCellValue('K1', 'Poli');
			$sheet->setCellValue('L1', 'Dokter');
			$sheet->setCellValue('M1', 'Waktu Daftar Ulang');
			$sheet->setCellValue('N1', 'Waktu Tindak Perawat');
			$sheet->setCellValue('O1', 'Waktu Tindak Dokter');
			$sheet->setCellValue('P1', 'Waktu Pulang');
			$sheet->setCellValue('Q1', 'Selisih Dokter Perawat');
			$sheet->setCellValue('R1', 'Lama Tunggu');
			$sheet->setCellValue('S1', 'No Register');
			$sheet->setCellValue('T1', 'Keterangan');

			$data =$this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),'SEMUA','')->result();

			$tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),'SEMUA','')->row()->tgl_lahir;
			$tahun_tgl_lahir = substr($tgl_lahir,0,4);
			$tahun_sekarang = date('Y');
			$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
			$tgl_lahir = $pengurangan; 

			$no = 1;
			$x = 2;
			foreach ($poli as $key) {
				foreach($data as $row){
					if ($key->id_poli==$row->id_poli) {	
						$car = $row->cara_bayar;
					
						if($car == 'BPJS'){
							$car_bar = $row->kontraktor;
						}else if($row->cara_bayar=='KERJASAMA'){
							$car_bar = $row->kontraktor;
						}else{ 
							$car_bar = $row->cara_bayar;
						}

						if($row->waktu_masuk_poli == null){
							$waktu_mapol = '';
						} else{
							$waktu_mapol = date('H:i:s',strtotime($row->waktu_masuk_poli)); 
						}

						if($row->waktu_masuk_dokter == null){
							$waktu_madok = '';
						}else{
							$waktu_madok = date('H:i:s',strtotime($row->waktu_masuk_dokter));
						}

						if($row->waktu_pulang == null){
							$waktu_mapul = '';
						}else{
							$waktu_mapul = date('H:i:s',strtotime($row->waktu_pulang));
						}

						$nm_poli = $this->Rjmlaporan->get_nm_poli($row->id_poli)->row()->nm_poli;

						if($row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null){
							$waktu_masuk_poli = date_create($row->waktu_masuk_poli);
							$waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);
							$diff = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);
							$selisih_dokper = date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
						}else{
							$selisih_dokper = '';
						}	

						$detik = 0;
						$menit = 0;
						$jam = 0;
						$jam_array = array();
						if ($row->tgl_kunjungan != null && $row->waktu_masuk_poli != null && $row->waktu_masuk_dokter != null) {

							$waktu_masuk = date_create($row->tgl_kunjungan);
							$waktu_masuk_poli = date_create($row->waktu_masuk_poli);
							$waktu_masuk_dokter = date_create($row->waktu_masuk_dokter);
							
							$diff1 = date_diff($waktu_masuk_poli,$waktu_masuk);
							$diff2 = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);

							$waktu_awal = date_create(date('H:i:s',strtotime($diff1->h.':'.$diff1->i.':'.$diff1->s)));																
							$waktu_akhir = date_create(date('H:i:s',strtotime($diff2->h.':'.$diff2->i.':'.$diff2->s)));

							$last_diff = date_diff($waktu_akhir,$waktu_awal);
							$lama_tunggu =  date('H:i:s',strtotime($last_diff->h.':'.$last_diff->i.':'.$last_diff->s));																															
						}else{
							$lama_tunggu =  '';
						}

						$sheet->setCellValue('A'.$x, $no++);
						$sheet->setCellValue('B'.$x, strtoupper($row->nama));
						$sheet->setCellValue('C'.$x, $row->no_cm);
						$sheet->setCellValue('D'.$x, $tgl_lahir);
						$sheet->setCellValue('E'.$x, $row->sex);
						$sheet->setCellValue('F'.$x, $car_bar);
						$sheet->setCellValue('G'.$x, $row->kotakabupaten);
						$sheet->setCellValue('H'.$x, $row->nm_diagnosa);
						$sheet->setCellValue('I'.$x, $row->id_diagnosa);
						$sheet->setCellValue('J'.$x, $row->jns_kunj);
						$sheet->setCellValue('K'.$x, $nm_poli);
						$sheet->setCellValue('L'.$x, $row->nm_dokter);
						$sheet->setCellValue('M'.$x, date('H:i:s',strtotime($row->tgl_kunjungan)));
						$sheet->setCellValue('N'.$x, $waktu_mapol);
						$sheet->setCellValue('O'.$x, $waktu_madok);
						$sheet->setCellValue('P'.$x, $waktu_mapul);
						$sheet->setCellValue('Q'.$x, $selisih_dokper);
						$sheet->setCellValue('R'.$x, $lama_tunggu);
						$sheet->setCellValue('S'.$x, $row->no_register);
						$sheet->setCellValue('T'.$x, str_replace('_', ' ',$row->ket_pulang));
						$x++;
					}	
													
				}
			}
			
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Kunjungan IRJ';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}


		
	}

	public function excel_lap_dig_kasus_jenkel($lap_per='',$layanan='',$var='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->mergeCells("A1:A2");
		$sheet->setCellValue('B1', 'Diagnosa');
		$sheet->mergeCells("B1:B2");
		$sheet->setCellValue('C1', 'Kode ICD10');
		$sheet->mergeCells("C1:C2");

		if($layanan=='ri'){
			$sheet->setCellValue('D1', 'Pasien Hidup');
			$sheet->mergeCells("D1:E1");
			$sheet->setCellValue('D2', 'L');
			$sheet->setCellValue('E2', 'P');
			$sheet->setCellValue('F1', 'Total Pasien Hidup');
			$sheet->mergeCells("F1:F2");
			$sheet->setCellValue('G1', 'Total Pasien Mati');
			$sheet->mergeCells("G1:G2");
			$sheet->setCellValue('H1', 'Total Pasien (H + M)');
			$sheet->mergeCells("H1:H2");
		}else{
			$sheet->setCellValue('D1', 'Kunjungan Baru');
			$sheet->mergeCells("D1:E1");
			$sheet->setCellValue('D2', 'L');
			$sheet->setCellValue('E2', 'P');
			$sheet->setCellValue('F1', 'Total Kunjungan Baru');
			$sheet->mergeCells("F1:F2");
			$sheet->setCellValue('G1', 'Total Kunjungan Lama');
			$sheet->mergeCells("G1:G2");
			$sheet->setCellValue('H1', 'Total Kunjungan (B + L)');
			$sheet->mergeCells("H1:H2");
		}
		
		
		if ($lap_per == 'TGL') {
			$data =$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'BLN') {
			$data =$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'THN') {
			$data =$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($var,$lap_per,$layanan)->result();
		}else{
			$data =$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->result();
		}

		$jumlah_l     = 0;
		$jumlah_p     = 0;
		$jumlah_lama  = 0;
		$jumlah_baru  = 0;
		$jumlah_total = 0;

		$no = 1;
		$x = 3;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nm_diagnosa);
			$sheet->setCellValue('C'.$x, $row->id_diagnosa);
			$sheet->setCellValue('D'.$x, $row->l);
			$sheet->setCellValue('E'.$x, $row->p);
			$sheet->setCellValue('F'.$x, $row->baru);
			$sheet->setCellValue('G'.$x, $row->lama);
			$sheet->setCellValue('H'.$x, $row->jumlah);
			$jumlah_l += $row->l; 
			$jumlah_p += $row->p; 
			$jumlah_lama += $row->lama; 
			$jumlah_baru += $row->baru; 
			$jumlah_total += $row->jumlah; 
			$x++;
		}		
		$sheet->setCellValue('A'.$x, 'TOTAL');
		$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
		$sheet->setCellValue('D'.$x, $jumlah_l);
		$sheet->setCellValue('E'.$x, $jumlah_p);
		$sheet->setCellValue('F'.$x, $jumlah_baru);
		$sheet->setCellValue('G'.$x, $jumlah_lama);
		$sheet->setCellValue('H'.$x, $jumlah_total);

		$writer = new Xlsx($spreadsheet);
		if($layanan == 'rj'){
			$layananya = 'Rawat Jalan'.' '.$var;
		}else if($layanan == 'rd'){
			$layananya = 'Rawat Darurat'.' '.$var;
		}else{
			$layananya = 'Rawat Inap'.' '.$var;
		}
		$filename = ' Laporan Kunjungan Diagnosa Berdasarkan Jenis Kelamin Dan Kasus '.$layananya.' Di RSUD SIJUNJUNG';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_wilayah_jaminan($lap_per='',$layanan='',$var='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'ALAMAT');
		$sheet->setCellValue('C1', 'UMUM');
		$sheet->setCellValue('D1', 'BPJS');
		$sheet->setCellValue('E1', 'BUKIT ASAM');
		$sheet->setCellValue('F1', 'TELKOM');
		$sheet->setCellValue('G1', 'INHEALTH');
		$sheet->setCellValue('H1', 'PLN');
		$sheet->setCellValue('I1', 'Grand Total');
		
		if ($lap_per == 'TGL') {
			$data =$this->Rjmlaporan->get_kunj_wilayah_jaminan($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'BLN') {
			$data =$this->Rjmlaporan->get_kunj_wilayah_jaminan($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'THN') {
			$data =$this->Rjmlaporan->get_kunj_wilayah_jaminan($var,$lap_per,$layanan)->result();
		}else{
			$data =$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->result();
		}

		$jumlah_umum     	  = 0;
		$jumlah_bpjs     	  = 0;
		$jumlah_bukit_asam    = 0;
		$jumlah_telkom  	  = 0;
		$jumlah_inhealth  	  = 0;
		$jumlah_pln  		  = 0;
		$jumlah_total 		  = 0;

		$no = 1;
		$x = 2;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->kotakabupaten);
			$sheet->setCellValue('C'.$x, $row->umum);
			$sheet->setCellValue('D'.$x, $row->bpjs);
			$sheet->setCellValue('E'.$x, $row->bukit_asam);
			$sheet->setCellValue('F'.$x, $row->telkom);
			$sheet->setCellValue('G'.$x, $row->inhealth);
			$sheet->setCellValue('H'.$x, $row->pln);
			$sheet->setCellValue('I'.$x, $row->jumlah);
			$jumlah_umum     	  += $row->umum;
			$jumlah_bpjs     	  += $row->bpjs;
			$jumlah_bukit_asam    += $row->bukit_asam;
			$jumlah_telkom  	  += $row->telkom;
			$jumlah_inhealth  	  += $row->inhealth;
			$jumlah_pln  		  += $row->pln;
			$jumlah_total 		  += $row->jumlah;
			$x++;
		}		
		$sheet->setCellValue('A'.$x, 'TOTAL');
		$sheet->mergeCells('A'.$x.':'.'B'.$x.'');
		$sheet->setCellValue('C'.$x, $jumlah_umum);
		$sheet->setCellValue('D'.$x, $jumlah_bpjs);
		$sheet->setCellValue('E'.$x, $jumlah_bukit_asam);
		$sheet->setCellValue('F'.$x, $jumlah_telkom);
		$sheet->setCellValue('G'.$x, $jumlah_inhealth);
		$sheet->setCellValue('H'.$x, $jumlah_pln);
		$sheet->setCellValue('I'.$x, $jumlah_total);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan Wilayah Berdasarkan Jaminan '.' '.$layanan.' '.$var.' '.'Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_jenkel_jaminan_kasus($lap_per='',$layanan='',$var='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		if($layanan == 'ri'){
			$sheet->setCellValue('A1', 'No');
			$sheet->mergeCells("A1:A3");
			$sheet->setCellValue('B1', 'Poli');
			$sheet->mergeCells("B1:B3");

			$sheet->setCellValue('C1', 'UMUM');
			$sheet->mergeCells("C1:F1");
			$sheet->setCellValue('C2', 'H');
			$sheet->mergeCells("C2:D2");
			$sheet->setCellValue('C3', 'L');
			$sheet->setCellValue('D3', 'P');
			$sheet->setCellValue('E2', 'M');
			$sheet->mergeCells("E2:F2");
			$sheet->setCellValue('E3', 'L');
			$sheet->setCellValue('F3', 'P');

			$sheet->setCellValue('G1', 'BPJS');
			$sheet->mergeCells("G1:J1");
			$sheet->setCellValue('G2', 'H');
			$sheet->mergeCells("G2:H2");
			$sheet->setCellValue('G3', 'L');
			$sheet->setCellValue('H3', 'P');
			$sheet->setCellValue('I2', 'M');
			$sheet->mergeCells("I2:J2");
			$sheet->setCellValue('I3', 'L');
			$sheet->setCellValue('J3', 'P');

			$sheet->setCellValue('K1', 'BUKIT ASAM');
			$sheet->mergeCells("K1:N1");
			$sheet->setCellValue('K2', 'H');
			$sheet->mergeCells("K2:L2");
			$sheet->setCellValue('K3', 'L');
			$sheet->setCellValue('L3', 'P');
			$sheet->setCellValue('M2', 'M');
			$sheet->mergeCells("M2:N2");
			$sheet->setCellValue('M3', 'L');
			$sheet->setCellValue('N3', 'P');

			$sheet->setCellValue('O1', 'PLN');
			$sheet->mergeCells("O1:R1");
			$sheet->setCellValue('O2', 'H');
			$sheet->mergeCells("O2:P2");
			$sheet->setCellValue('O3', 'L');
			$sheet->setCellValue('P3', 'P');
			$sheet->setCellValue('Q2', 'M');
			$sheet->mergeCells("Q2:R2");
			$sheet->setCellValue('Q3', 'L');
			$sheet->setCellValue('R3', 'P');

			$sheet->setCellValue('S1', 'INHEALTH');
			$sheet->mergeCells("S1:V1");
			$sheet->setCellValue('S2', 'H');
			$sheet->mergeCells("S2:T2");
			$sheet->setCellValue('S3', 'L');
			$sheet->setCellValue('T3', 'P');
			$sheet->setCellValue('U2', 'M');
			$sheet->mergeCells("U2:V2");
			$sheet->setCellValue('U3', 'L');
			$sheet->setCellValue('V3', 'P');

			$sheet->setCellValue('W1', 'TELKOM');
			$sheet->mergeCells("W1:Z1");
			$sheet->setCellValue('W2', 'H');
			$sheet->mergeCells("W2:X2");
			$sheet->setCellValue('W3', 'L');
			$sheet->setCellValue('X3', 'P');
			$sheet->setCellValue('Y2', 'M');
			$sheet->mergeCells("Y2:Z2");
			$sheet->setCellValue('Y3', 'L');
			$sheet->setCellValue('Z3', 'P');

			$sheet->setCellValue('AA1', 'TOTAL KASUS');
			$sheet->mergeCells("AA1:AB2");
			$sheet->setCellValue('AA3', 'MATI');
			$sheet->setCellValue('AB3', 'HIDUP');

			$sheet->setCellValue('AC1', 'Total');
			$sheet->mergeCells("AC1:AC3");
		}else{
			$sheet->setCellValue('A1', 'No');
			$sheet->mergeCells("A1:A3");
			$sheet->setCellValue('B1', 'Poli');
			$sheet->mergeCells("B1:B3");

			$sheet->setCellValue('C1', 'UMUM');
			$sheet->mergeCells("C1:F1");
			$sheet->setCellValue('C2', 'B');
			$sheet->mergeCells("C2:D2");
			$sheet->setCellValue('C3', 'L');
			$sheet->setCellValue('D3', 'P');
			$sheet->setCellValue('E2', 'L');
			$sheet->mergeCells("E2:F2");
			$sheet->setCellValue('E3', 'L');
			$sheet->setCellValue('F3', 'P');

			$sheet->setCellValue('G1', 'BPJS');
			$sheet->mergeCells("G1:J1");
			$sheet->setCellValue('G2', 'B');
			$sheet->mergeCells("G2:H2");
			$sheet->setCellValue('G3', 'L');
			$sheet->setCellValue('H3', 'P');
			$sheet->setCellValue('I2', 'L');
			$sheet->mergeCells("I2:J2");
			$sheet->setCellValue('I3', 'L');
			$sheet->setCellValue('J3', 'P');

			$sheet->setCellValue('K1', 'BUKIT ASAM');
			$sheet->mergeCells("K1:N1");
			$sheet->setCellValue('K2', 'B');
			$sheet->mergeCells("K2:L2");
			$sheet->setCellValue('K3', 'L');
			$sheet->setCellValue('L3', 'P');
			$sheet->setCellValue('M2', 'L');
			$sheet->mergeCells("M2:N2");
			$sheet->setCellValue('M3', 'L');
			$sheet->setCellValue('N3', 'P');

			$sheet->setCellValue('O1', 'PLN');
			$sheet->mergeCells("O1:R1");
			$sheet->setCellValue('O2', 'B');
			$sheet->mergeCells("O2:P2");
			$sheet->setCellValue('O3', 'L');
			$sheet->setCellValue('P3', 'P');
			$sheet->setCellValue('Q2', 'L');
			$sheet->mergeCells("Q2:R2");
			$sheet->setCellValue('Q3', 'L');
			$sheet->setCellValue('R3', 'P');

			$sheet->setCellValue('S1', 'INHEALTH');
			$sheet->mergeCells("S1:V1");
			$sheet->setCellValue('S2', 'B');
			$sheet->mergeCells("S2:T2");
			$sheet->setCellValue('S3', 'L');
			$sheet->setCellValue('T3', 'P');
			$sheet->setCellValue('U2', 'L');
			$sheet->mergeCells("U2:V2");
			$sheet->setCellValue('U3', 'L');
			$sheet->setCellValue('V3', 'P');

			$sheet->setCellValue('W1', 'TELKOM');
			$sheet->mergeCells("W1:Z1");
			$sheet->setCellValue('W2', 'B');
			$sheet->mergeCells("W2:X2");
			$sheet->setCellValue('W3', 'L');
			$sheet->setCellValue('X3', 'P');
			$sheet->setCellValue('Y2', 'L');
			$sheet->mergeCells("Y2:Z2");
			$sheet->setCellValue('Y3', 'L');
			$sheet->setCellValue('Z3', 'P');

			$sheet->setCellValue('AA1', 'TOTAL KASUS');
			$sheet->mergeCells("AA1:AB2");
			$sheet->setCellValue('AA3', 'LAMA');
			$sheet->setCellValue('AB3', 'BARU');

			$sheet->setCellValue('AC1', 'Total');
			$sheet->mergeCells("AC1:AC3");

		}
		

		if ($lap_per == 'TGL') {
			$data =$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'BLN') {
			$data =$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'THN') {
			$data =$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($var,$lap_per)->result();
		}else{
			$data =$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->result();
		}


		$jumlah_umum_baru_l     = 0;
		$jumlah_umum_baru_p     = 0;
		$jumlah_umum_lama_l     = 0;
		$jumlah_umum_lama_p     = 0;

		$jumlah_bpjs_baru_l     = 0;
		$jumlah_bpjs_baru_p     = 0;
		$jumlah_bpjs_lama_l     = 0;
		$jumlah_bpjs_lama_p     = 0;

		$jumlah_bukit_asam_baru_l     = 0;
		$jumlah_bukit_asam_baru_p     = 0;
		$jumlah_bukit_asam_lama_l     = 0;
		$jumlah_bukit_asam_lama_p     = 0;

		$jumlah_pln_baru_l     = 0;
		$jumlah_pln_baru_p     = 0;
		$jumlah_pln_lama_l     = 0;
		$jumlah_pln_lama_p     = 0;

		$jumlah_inhealth_baru_l     = 0;
		$jumlah_inhealth_baru_p     = 0;
		$jumlah_inhealth_lama_l     = 0;
		$jumlah_inhealth_lama_p     = 0;

		$jumlah_telkom_baru_l     = 0;
		$jumlah_telkom_baru_p     = 0;
		$jumlah_telkom_lama_l     = 0;
		$jumlah_telkom_lama_p     = 0;

		$jumlah_baru     = 0;
		$jumlah_lama     = 0;
		
		$jumlah_total = 0;

		$no = 1;
		$x = 4;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nm_poli);

			$sheet->setCellValue('C'.$x, $row->umum_baru_l);
			$sheet->setCellValue('D'.$x, $row->umum_baru_p);
			$sheet->setCellValue('E'.$x, $row->umum_lama_l);
			$sheet->setCellValue('F'.$x, $row->umum_lama_p);

			$sheet->setCellValue('G'.$x, $row->bpjs_baru_l);
			$sheet->setCellValue('H'.$x, $row->bpjs_baru_p);
			$sheet->setCellValue('I'.$x, $row->bpjs_lama_l);
			$sheet->setCellValue('J'.$x, $row->bpjs_lama_p);

			$sheet->setCellValue('K'.$x, $row->bukit_asam_baru_l);
			$sheet->setCellValue('L'.$x, $row->bukit_asam_baru_p);
			$sheet->setCellValue('M'.$x, $row->bukit_asam_lama_l);
			$sheet->setCellValue('N'.$x, $row->bukit_asam_lama_p);

			$sheet->setCellValue('O'.$x, $row->pln_baru_l);
			$sheet->setCellValue('P'.$x, $row->pln_baru_p);
			$sheet->setCellValue('Q'.$x, $row->pln_lama_l);
			$sheet->setCellValue('R'.$x, $row->pln_lama_p);

			$sheet->setCellValue('S'.$x, $row->inhealth_baru_l);
			$sheet->setCellValue('T'.$x, $row->inhealth_baru_p);
			$sheet->setCellValue('U'.$x, $row->inhealth_lama_l);
			$sheet->setCellValue('V'.$x, $row->inhealth_lama_p);

			$sheet->setCellValue('W'.$x, $row->telkom_baru_l);
			$sheet->setCellValue('X'.$x, $row->telkom_baru_p);
			$sheet->setCellValue('Y'.$x, $row->telkom_lama_l);
			$sheet->setCellValue('Z'.$x, $row->telkom_lama_p);

			$sheet->setCellValue('AA'.$x, $row->lama);
			$sheet->setCellValue('AB'.$x, $row->baru);
			$sheet->setCellValue('AC'.$x, $row->jumlah);

			$jumlah_umum_baru_l     += $row->umum_baru_l ;
			$jumlah_umum_baru_p     += $row->umum_baru_p ;
			$jumlah_umum_lama_l     += $row->umum_lama_l ;
			$jumlah_umum_lama_p     += $row->umum_lama_p ;

			$jumlah_bpjs_baru_l     += $row->bpjs_baru_l ;
			$jumlah_bpjs_baru_p     += $row->bpjs_baru_p ;
			$jumlah_bpjs_lama_l     += $row->bpjs_lama_l ;
			$jumlah_bpjs_lama_p     += $row->bpjs_lama_p ;

			$jumlah_bukit_asam_baru_l     += $row->bukit_asam_baru_l ;
			$jumlah_bukit_asam_baru_p     += $row->bukit_asam_baru_p ;
			$jumlah_bukit_asam_lama_l     += $row->bukit_asam_lama_l ;
			$jumlah_bukit_asam_lama_p     += $row->bukit_asam_lama_p ;

			$jumlah_pln_baru_l     += $row->pln_baru_l ;
			$jumlah_pln_baru_p     += $row->pln_baru_p ;
			$jumlah_pln_lama_l     += $row->pln_lama_l ;
			$jumlah_pln_lama_p     += $row->pln_lama_p ;

			$jumlah_inhealth_baru_l     += $row->inhealth_baru_l ;
			$jumlah_inhealth_baru_p     += $row->inhealth_baru_p ;
			$jumlah_inhealth_lama_l     += $row->inhealth_lama_l ;
			$jumlah_inhealth_lama_p     += $row->inhealth_lama_p ;

			$jumlah_telkom_baru_l     += $row->telkom_baru_l ;
			$jumlah_telkom_baru_p     += $row->telkom_baru_p ;
			$jumlah_telkom_lama_l     += $row->telkom_lama_l ;
			$jumlah_telkom_lama_p     += $row->telkom_lama_p ;

			$jumlah_baru     += $row->lama ;
			$jumlah_lama     += $row->baru ;
			
			$jumlah_total += $row->jumlah ;

			$x++;
		}		
		$sheet->setCellValue('A'.$x, 'TOTAL');
		$sheet->mergeCells('A'.$x.':'.'B'.$x.'');
		$sheet->setCellValue('C'.$x, $jumlah_umum_baru_l);
		$sheet->setCellValue('D'.$x, $jumlah_umum_baru_p);
		$sheet->setCellValue('E'.$x, $jumlah_umum_lama_l);
		$sheet->setCellValue('F'.$x, $jumlah_umum_lama_p);
		$sheet->setCellValue('G'.$x, $jumlah_bpjs_baru_l);
		$sheet->setCellValue('H'.$x, $jumlah_bpjs_baru_p);
		$sheet->setCellValue('I'.$x, $jumlah_bpjs_lama_l);
		$sheet->setCellValue('J'.$x, $jumlah_bpjs_lama_p);
		$sheet->setCellValue('K'.$x, $jumlah_bukit_asam_baru_l);
		$sheet->setCellValue('L'.$x, $jumlah_bukit_asam_baru_p);
		$sheet->setCellValue('M'.$x, $jumlah_bukit_asam_lama_l);
		$sheet->setCellValue('N'.$x, $jumlah_bukit_asam_lama_p);
		$sheet->setCellValue('O'.$x, $jumlah_pln_baru_l);
		$sheet->setCellValue('P'.$x, $jumlah_pln_baru_p);
		$sheet->setCellValue('Q'.$x, $jumlah_pln_lama_l);
		$sheet->setCellValue('R'.$x, $jumlah_pln_lama_p);
		$sheet->setCellValue('S'.$x, $jumlah_inhealth_baru_l);
		$sheet->setCellValue('T'.$x, $jumlah_inhealth_baru_p);
		$sheet->setCellValue('U'.$x, $jumlah_inhealth_lama_l);
		$sheet->setCellValue('V'.$x, $jumlah_inhealth_lama_p);
		$sheet->setCellValue('W'.$x, $jumlah_telkom_baru_l);
		$sheet->setCellValue('X'.$x, $jumlah_telkom_baru_p);
		$sheet->setCellValue('Y'.$x, $jumlah_telkom_lama_l);
		$sheet->setCellValue('Z'.$x, $jumlah_telkom_lama_p);
		$sheet->setCellValue('AA'.$x, $jumlah_baru);
		$sheet->setCellValue('AB'.$x, $jumlah_lama);
		$sheet->setCellValue('AC'.$x, $jumlah_total);

		$styleArray = array(
			'borders' => array(
				'allBorders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('argb' => '000000'),
				),
			),
		);
		$sheet->getStyle('A1:AC'.$x)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan Poliklinik Berdasarkan Jaminan,Kasus & Jenis Kelamin '.$layanan.' '.$var.' Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_poli_irj_ada_tiga_today($tgl='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		  //activate worksheet number 1
		  $spreadsheet->setActiveSheetIndex(0);
		  //name the worksheet
		  $sheet->setTitle('Worksheet 1');
		
			$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga($tgl);
				
		  //ambil semua data pendapatan
		 
		  //print_r($data_pasien_keluar_tanggal[0]);exit;
		  $row = 1;
		  //set header excel
		  $sheet->setCellValue('A'.$row, 'No Register');
		  $sheet->setCellValue('B'.$row, 'Nama');
		  $sheet->setCellValue('C'.$row, 'No RM');
		  $sheet->setCellValue('D'.$row, 'Jenis Pasien');
		  $sheet->setCellValue('E'.$row, 'Umur');
		  $sheet->setCellValue('F'.$row, 'Jenkel');
		  $sheet->setCellValue('G'.$row, 'Poli');
		  $sheet->setCellValue('H'.$row, 'Jaminan');
		  $sheet->setCellValue('I'.$row, 'Alamat');
		  $sheet->setCellValue('K'.$row, 'Diagnosa');
		  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
		  $sheet->setCellValue('L'.$row, 'Dokter');
		
			  foreach ($data_kunjungan as $r) {
	
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;
		  
			$row++;
			  $sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			
			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
			
		  } 
	
		  $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
		  $writer = new Xlsx($spreadsheet);
			//ob_clean();
		  header('Content-Type: application/vnd.ms-excel');
		  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		  header('Cache-Control: max-age=0');
	
		  $writer->save('php://output');
	}
	
	public function excel_lap_poli_irj_ada_tiga($tampil_per='', $id_poli='', $tgl='') {
		if($tampil_per=='TGL') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
	
		  //activate worksheet number 1
		  $spreadsheet->setActiveSheetIndex(0);
		  //name the worksheet
		  $sheet->setTitle('Worksheet 1');
			if($id_poli == "SEMUA") {
					$id_poli= "SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga($tgl);
				} else {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					//$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_pilih($tgl, $select_id_poli);
				}
	
		  //ambil semua data pendapatan
		 
		  //print_r($data_pasien_keluar_tanggal[0]);exit;
		  $row = 1;
		  //set header excel
		  $sheet->setCellValue('A'.$row, 'No Register');
		  $sheet->setCellValue('B'.$row, 'Nama');
		  $sheet->setCellValue('C'.$row, 'No RM');
		  $sheet->setCellValue('D'.$row, 'Jenis Pasien');
		  $sheet->setCellValue('E'.$row, 'Umur');
		  $sheet->setCellValue('F'.$row, 'Jenkel');
		  $sheet->setCellValue('G'.$row, 'Poli');
		  $sheet->setCellValue('H'.$row, 'Jaminan');
		  $sheet->setCellValue('I'.$row, 'Alamat');
		  $sheet->setCellValue('K'.$row, 'Diagnosa');
		  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
		  $sheet->setCellValue('L'.$row, 'Dokter');
		
			  foreach ($data_kunjungan as $r) {
	
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;
		  
			$row++;
			  $sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			
			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
			
		  } 
	
		  $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
		  $writer = new Xlsx($spreadsheet);
			//ob_clean();
		  header('Content-Type: application/vnd.ms-excel');
		  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		  header('Cache-Control: max-age=0');
	
		  $writer->save('php://output');
		}
	
		else if($tampil_per=='BLN') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
	
		  //activate worksheet number 1
		  $spreadsheet->setActiveSheetIndex(0);
		  //name the worksheet
		  $sheet->setTitle('Worksheet 1');
			if($id_poli == "SEMUA") {
					$id_poli= "SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_bulan($tgl);
				} else {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					//$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_bulan_pilih($tgl, $select_id_poli);
				}
	
		  //ambil semua data pendapatan
		 
		  //print_r($data_pasien_keluar_tanggal[0]);exit;
		  $row = 1;
		  //set header excel
		  $sheet->setCellValue('A'.$row, 'No Register');
		  $sheet->setCellValue('B'.$row, 'Nama');
		  $sheet->setCellValue('C'.$row, 'No RM');
		  $sheet->setCellValue('D'.$row, 'Jenis Pasien');
		  $sheet->setCellValue('E'.$row, 'Umur');
		  $sheet->setCellValue('F'.$row, 'Jenkel');
		  $sheet->setCellValue('G'.$row, 'Poli');
		  $sheet->setCellValue('H'.$row, 'Jaminan');
		  $sheet->setCellValue('I'.$row, 'Alamat');
		  $sheet->setCellValue('K'.$row, 'Diagnosa');
		  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
		  $sheet->setCellValue('L'.$row, 'Dokter');
		
			  foreach ($data_kunjungan as $r) {
	
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;
		  
			$row++;
			  $sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			
			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
			
		  } 
	
		  $filename='Kunjungan Data Pasien Rawat Darurat Bulan '.$tgl; //save our workbook as this file name
		  $writer = new Xlsx($spreadsheet);
			//ob_clean();
		  header('Content-Type: application/vnd.ms-excel');
		  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		  header('Cache-Control: max-age=0');
	
		  $writer->save('php://output');
		}
	
		else if($tampil_per=='THN') {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
	
		  //activate worksheet number 1
		  $spreadsheet->setActiveSheetIndex(0);
		  //name the worksheet
		  $sheet->setTitle('Worksheet 1');
			if($id_poli == "SEMUA") {
					$id_poli= "SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_tahun($tgl);
				} else {
					$select = explode("@", $id_poli);
					$select_id_poli=$select[0];
					$data['id_poli']=$select[0];
					//$data['nm_poli']='<b>'.$select[1].'</b>';
					//$data['id_dokter_tgl']="SEMUA";
					$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_ada_tiga_tahun_pilih($tgl, $select_id_poli);
				}
	
		  //ambil semua data pendapatan
		 
		  //print_r($data_pasien_keluar_tanggal[0]);exit;
		  $row = 1;
		  //set header excel
		  $sheet->setCellValue('A'.$row, 'No Register');
		  $sheet->setCellValue('B'.$row, 'Nama');
		  $sheet->setCellValue('C'.$row, 'No RM');
		  $sheet->setCellValue('D'.$row, 'Jenis Pasien');
		  $sheet->setCellValue('E'.$row, 'Umur');
		  $sheet->setCellValue('F'.$row, 'Jenkel');
		  $sheet->setCellValue('G'.$row, 'Poli');
		  $sheet->setCellValue('H'.$row, 'Jaminan');
		  $sheet->setCellValue('I'.$row, 'Alamat');
		  $sheet->setCellValue('K'.$row, 'Diagnosa');
		  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
		  $sheet->setCellValue('L'.$row, 'Dokter');
		
			  foreach ($data_kunjungan as $r) {
	
			$start = new DateTime($r['tgl_lahir']);//start
			$end = new DateTime('today');//end
			$y = $end->diff($start)->y;
		  
			$row++;
			  $sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			//$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
			// $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
			
			// $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
			
		  } 
	
		  $filename='Kunjungan Data Pasien Rawat Darurat Tahun '.$tgl; //save our workbook as this file name
		  $writer = new Xlsx($spreadsheet);
			//ob_clean();
		  header('Content-Type: application/vnd.ms-excel');
		  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		  header('Cache-Control: max-age=0');
	
		  $writer->save('php://output');
		}
	}

	public function excel_lap_poli_irj_gaada_tiga_today($tgl='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
	
		$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
			

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
	  $sheet->setCellValue('G'.$row, 'Poli');
      $sheet->setCellValue('H'.$row, 'Jaminan');
      $sheet->setCellValue('I'.$row, 'Alamat');
      $sheet->setCellValue('K'.$row, 'Diagnosa');
	  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('L'.$row, 'Dokter');
    
      	foreach ($data_kunjungan as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	public function excel_lap_poli_irj_gaada_tiga($tampil_per='', $id_poli='', $tgl='') {
		//var_dump($tampil_per, $tgl); die();
		// $data_pasien_bln = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd_bulan($tgl);
		// $data_pasien_tgl = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);
		// $data_pasien_thn = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd_tahun($tgl);
		
	  if($tampil_per=='TGL') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
		if($id_poli == "SEMUA") {
				$id_poli= "SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga($tgl);
			} else {
				$select = explode("@", $id_poli);
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				//$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_pilih($tgl, $select_id_poli);
			}

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
	  $sheet->setCellValue('G'.$row, 'Poli');
      $sheet->setCellValue('H'.$row, 'Jaminan');
      $sheet->setCellValue('I'.$row, 'Alamat');
      $sheet->setCellValue('K'.$row, 'Diagnosa');
	  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('L'.$row, 'Dokter');
    
      	foreach ($data_kunjungan as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	else if($tampil_per=='BLN') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
		if($id_poli == "SEMUA") {
				$id_poli= "SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_bulan($tgl);
			} else {
				$select = explode("@", $id_poli);
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				//$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_bulan_pilih($tgl, $select_id_poli);
			}

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
	  $sheet->setCellValue('G'.$row, 'Poli');
      $sheet->setCellValue('H'.$row, 'Jaminan');
      $sheet->setCellValue('I'.$row, 'Alamat');
      $sheet->setCellValue('K'.$row, 'Diagnosa');
	  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('L'.$row, 'Dokter');
    
      	foreach ($data_kunjungan as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Bulan '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	else if($tampil_per=='THN') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
		if($id_poli == "SEMUA") {
				$id_poli= "SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_tahun($tgl);
			} else {
				$select = explode("@", $id_poli);
				$select_id_poli=$select[0];
				$data['id_poli']=$select[0];
				//$data['nm_poli']='<b>'.$select[1].'</b>';
				//$data['id_dokter_tgl']="SEMUA";
				$data_kunjungan = $this->Rjmlaporan->get_lap_poli_irj_gaada_tiga_tahun_pilih($tgl, $select_id_poli);
			}

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
	  $sheet->setCellValue('G'.$row, 'Poli');
      $sheet->setCellValue('H'.$row, 'Jaminan');
      $sheet->setCellValue('I'.$row, 'Alamat');
      $sheet->setCellValue('K'.$row, 'Diagnosa');
	  $sheet->setCellValue('K'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('L'.$row, 'Dokter');
    
      	foreach ($data_kunjungan as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('G'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('I'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('L'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tahun '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}
	}

	public function excel_lap_kunj_data_pasien_igd_today($tgl='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
	  $data_pasien_tgl = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);
      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
      $sheet->setCellValue('G'.$row, 'Jaminan');
      $sheet->setCellValue('H'.$row, 'Alamat');
      $sheet->setCellValue('I'.$row, 'Diagnosa');
	  $sheet->setCellValue('J'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('K'.$row, 'Dokter');
    
      	foreach ($data_pasien_tgl as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('G'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('I'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	public function excel_lap_kunj_data_pasien_igd($tampil_per='', $tgl='') {
		//var_dump($tampil_per, $tgl); die();
		$data_pasien_bln = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd_bulan($tgl);
		$data_pasien_tgl = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd($tgl);
		$data_pasien_thn = $this->Rjmlaporan->get_lap_kunj_data_pasien_igd_tahun($tgl);
		
	  if($tampil_per=='TGL') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
      $sheet->setCellValue('G'.$row, 'Jaminan');
      $sheet->setCellValue('H'.$row, 'Alamat');
      $sheet->setCellValue('I'.$row, 'Diagnosa');
	  $sheet->setCellValue('J'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('K'.$row, 'Dokter');
    
      	foreach ($data_pasien_tgl as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('G'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('I'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tanggal '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
		//ob_clean();
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	else if($tampil_per=='BLN') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
      $sheet->setCellValue('G'.$row, 'Jaminan');
      $sheet->setCellValue('H'.$row, 'Alamat');
      $sheet->setCellValue('I'.$row, 'Diagnosa');
	  $sheet->setCellValue('J'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('K'.$row, 'Dokter');
		
      	foreach ($data_pasien_bln as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('G'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('I'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Bulan '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
	//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	else if($tampil_per=='THN') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');

      //ambil semua data pendapatan
     
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Register');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No RM');
      $sheet->setCellValue('D'.$row, 'Jenis Pasien');
      $sheet->setCellValue('E'.$row, 'Umur');
      $sheet->setCellValue('F'.$row, 'Jenkel');
      $sheet->setCellValue('G'.$row, 'Jaminan');
      $sheet->setCellValue('H'.$row, 'Alamat');
      $sheet->setCellValue('I'.$row, 'Diagnosa');
	  $sheet->setCellValue('J'.$row, 'Kode ICD-10');
	  $sheet->setCellValue('K'.$row, 'Dokter');
      	foreach ($data_pasien_thn as $r) {

		$start = new DateTime($r['tgl_lahir']);//start
        $end = new DateTime('today');//end
        $y = $end->diff($start)->y;
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_cm']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['jns_kunj']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $y/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['kelamin']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('G'.$row, $r['cara_bayar']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['alamat']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('I'.$row, $r['diag1']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('J'.$row, $r['id_diag']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('K'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('J'.$row, $r['nmruang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        // $sheet->setCellValue('K'.$row, $r['id_poli']/*." - ".$r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        
        // $sheet->setCellValue('M'.$row, $r['xuser']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);        
        
      } 

      $filename='Kunjungan Data Pasien Rawat Darurat Tahun '.$tgl; //save our workbook as this file name
	  $writer = new Xlsx($spreadsheet);
	//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}
	}

	public function excel_lap_pasien_baru_irj($tgl = '') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

      //activate worksheet number 1
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_pasien_keluar_tanggal = $this->Rjmlaporan->get_pasien_baru_irj($tgl);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      $sheet->setCellValue('A'.$row, 'No Ipd');
      $sheet->setCellValue('B'.$row, 'Nama');
      $sheet->setCellValue('C'.$row, 'No Medrec');
      $sheet->setCellValue('D'.$row, 'Tgl Kunjungan');
      $sheet->setCellValue('E'.$row, 'Kelas');
      $sheet->setCellValue('F'.$row, 'Poliklinik');
      $sheet->setCellValue('G'.$row, 'Tgl Pulang');
      //$sheet->setCellValue('H'.$row, 'Lama Rawa');
      $sheet->setCellValue('H'.$row, 'Dokter');
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

		// $start = new DateTime($r['tgl_masuk']);//start
		// $end = new DateTime($r['tgl_keluar']);//end
		   
		// $diff = $end->diff($start)->format("%a");
		// if($diff == 0){
		// 	$diff = 1;
		// }
      
        $row++;
	  	$sheet->setCellValue('A'.$row, $r['no_register']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
		$sheet->setCellValue('B'.$row, $r['nama']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('C'.$row, $r['no_medrec']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('D'.$row, $r['tgl_kunjungan']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('E'.$row, $r['kelas_pasien']/*." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('F'.$row, $r['nm_poli']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('G'.$row, $r['tgl_pulang']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        //$sheet->setCellValue('H'.$row, $diff." Hari"/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
        $sheet->setCellValue('H'.$row, $r['nm_dokter']/*,PHPExcel_Cell_DataType::TYPE_STRING*/);
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
      $filename='Kunjungan Pasien Baru Rawat Jalan Bulan '.$tgl; //save our workbook as this file name
    //   header('Content-Type: application/vnd.ms-excel'); //mime type
    //   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    //   header('Cache-Control: max-age=0'); //no cache

	  $writer = new Xlsx($spreadsheet);
	//   $filename = 'Laporan Kunjungan Berdasarkan Diagnosa Kasus Jenis Kelamin';
	  header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
	}

	public function excel_lap_poli_jaminan($lap_per='',$layanan='',$var='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$sheet->setCellValue('A1', 'No');
		$sheet->mergeCells('A1:A2');
		$sheet->setCellValue('B1', 'Poliklinik');
		$sheet->mergeCells('B1:B2');
		$sheet->setCellValue('C1', 'UMUM');
		$sheet->mergeCells('C1:C2');
		$sheet->setCellValue('D1', 'BPJS');
		$sheet->mergeCells('D1:F1');
		$sheet->setCellValue('D2', 'BPJS-PBI');
		$sheet->setCellValue('E2', 'BPJS-NON PBI');
		$sheet->setCellValue('F2', 'BPJS-MANDIRI');

		$sheet->setCellValue('G1', 'KERJASAMA');
		$sheet->mergeCells('G1:J1');

		$sheet->setCellValue('G2', 'BUKIT ASAM');
		$sheet->setCellValue('H2', 'TELKOM');
		$sheet->setCellValue('I2', 'INHEALTH');
		$sheet->setCellValue('J2', 'PLN');
		$sheet->setCellValue('K1', 'Grand Total');
		$sheet->mergeCells('K1:K2');
		
		if ($lap_per == 'TGL') {
			$data =$this->Rjmlaporan->get_kunj_poli_jaminan($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'BLN') {
			$data =$this->Rjmlaporan->get_kunj_poli_jaminan($var,$lap_per,$layanan)->result();
		}elseif ($lap_per == 'THN') {
			$data =$this->Rjmlaporan->get_kunj_poli_jaminan($var,$lap_per,$layanan)->result();
		}else{
			$data =$this->Rjmlaporan->get_kunj_poli_jaminan('','')->result();
		}

		$jumlah_umum     	  = 0;
		$jumlah_bpjs_pbi      = 0;
		$jumlah_bpjs_non_pbi  = 0;
		$jumlah_bpjs_mandiri  = 0;
		$jumlah_bukit_asam    = 0;
		$jumlah_telkom  	  = 0;
		$jumlah_inhealth  	  = 0;
		$jumlah_pln  		  = 0;
		$jumlah_total 		  = 0;

		$no = 1;
		$x = 3;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nm_poli);
			$sheet->setCellValue('C'.$x, $row->umum);
			$sheet->setCellValue('D'.$x, $row->bpjs_pbi);
			$sheet->setCellValue('E'.$x, $row->bpjs_non_pbi);
			$sheet->setCellValue('F'.$x, $row->bpjs_mandiri);
			$sheet->setCellValue('G'.$x, $row->bukit_asam);
			$sheet->setCellValue('H'.$x, $row->telkom);
			$sheet->setCellValue('I'.$x, $row->inhealth);
			$sheet->setCellValue('J'.$x, $row->pln);
			$sheet->setCellValue('K'.$x, $row->jumlah);

			$jumlah_umum     	  += $row->umum;
			$jumlah_bpjs_pbi      += $row->bpjs_pbi;
			$jumlah_bpjs_non_pbi  += $row->bpjs_non_pbi;
			$jumlah_bpjs_mandiri  += $row->bpjs_mandiri;
			$jumlah_bukit_asam    += $row->bukit_asam;
			$jumlah_telkom  	  += $row->telkom;
			$jumlah_inhealth  	  += $row->inhealth;
			$jumlah_pln  		  += $row->pln;
			$jumlah_total 		  += $row->jumlah;
			$x++;
		}		
		$sheet->setCellValue('A'.$x, 'TOTAL');
		$sheet->mergeCells('A'.$x.':'.'B'.$x.'');
		$sheet->setCellValue('C'.$x, $jumlah_umum);
		$sheet->setCellValue('D'.$x, $jumlah_bpjs_pbi);
		$sheet->setCellValue('E'.$x, $jumlah_bpjs_non_pbi);
		$sheet->setCellValue('F'.$x, $jumlah_bpjs_mandiri);
		$sheet->setCellValue('G'.$x, $jumlah_bukit_asam);
		$sheet->setCellValue('H'.$x, $jumlah_telkom);
		$sheet->setCellValue('I'.$x, $jumlah_inhealth);
		$sheet->setCellValue('J'.$x, $jumlah_pln);
		$sheet->setCellValue('K'.$x, $jumlah_total);

		$writer = new Xlsx($spreadsheet);
		if($layanan != ''){ 
			if($layanan == 'rj'){
				$layananya = 'Rawat Jalan';
			}else if($layanan == 'rd'){
				$layananya = 'Rawat Darurat';
			}else{
				$layananya = 'Rawat Inap';
			}
		}
		$filename = 'Laporan Kunjungan '.$layananya.' Berdasarkan Jaminan '.$var.' 2023 Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}	

	public function lap_poli_jaminan()
	{		
		$data['title']='Laporan Poliklinik Dan Jaminan';
		// var_dump($this->input->post());die();
		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');
		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;		

		if ($lap_per == '') {
			
				$data['diagnosa']=array();
				$data['jumlah_umum'] = '';
				$data['jumlah_bpjs'] = '';	
				$data['jumlah_inhealth'] = '';	
				$data['jumlah_nayaka'] = '';	
				$data['jumlah_bukit_asam'] = '';	
				$data['jumlah_telkom'] = '';	
				$data['jumlah_pln'] = '';	
				$data['jumlah_taspen'] = '';	
				$data['jumlah_jasa_rahaja'] = '';	
				$data['jumlah_bpjs_pbi'] = '';	
				$data['jumlah_bpjs_mandiri'] = '';	
				$data['jumlah_bpjs_non_pbi'] = '';	
				$data['jumlah_total'] = '';	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
				$data['layanan'] = '';
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($tgl,$lap_per,$layanan)->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($tgl,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($bulan,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($tahun,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);
	
					$data['jumlah_umum'] = $jumlah_umum;
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				

		
		$this->load->view('irj/rjvlappolijaminan',$data);
		
	}

	public function lapkeuperkasir($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Per-Kasir';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeuperkasir',$data);
	}

	public function pdf_lapkeuperkasir($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Per-Kasir';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_kasir($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];
		
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		
		$html = $this->load->view('irj/pdf/rjvlapkeuperkasir',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		
		// $this->load->view('irj/rjvlapkeuperkasir',$data);
	}

	public function lapkeufarmasi($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Farmasi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeufarmasi',$data);
	}

	public function pdf_lapkeufarmasi($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Farmasi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi(date('Y-m-d'), date("Y-m-d"), '')->result();
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi($tgl_awal, $tgl_akhir, '')->result();
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_farmasi($tgl_awal, $tgl_akhir, $userid)->result();
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapkeufarmasi',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeufarmasi',$data);
	}

	public function lapkeurad($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Radiologi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeurad',$data);
	}

	public function pdf_lapkeurad($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Radiologi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad(date('Y-m-d'), date("Y-m-d"), '')->result();
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad($tgl_awal, $tgl_akhir, '')->result();
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_rad($tgl_awal, $tgl_akhir, $userid)->result();
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapkeurad',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeurad',$data);
	}

	public function lapkeulab($tgl_awal='',$tgl_akhir='',$pelayanan='',$carabayar='')
	{
		// var_dump($tgl_awal);
		// var_dump($tgl_akhir);
		// var_dump($pelayanan);
		// var_dump($carabayar);
		// die(); 
		$data['title']='Laporan Keuangan Laboratorium';
		if ($pelayanan != 'SEMUA' && $carabayar !='SEMUA') {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal,$tgl_akhir,$pelayanan,$carabayar)->result();
			$data['tgl_awal']=$tgl_awal;
			$data['tgl_akhir']=$tgl_akhir;
			$data['pelayanan']=$pelayanan;
			$data['carabayar']=$carabayar;
		}else if($pelayanan == 'SEMUA' && $carabayar !='SEMUA'){	
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal,$tgl_akhir,$pelayanan,$carabayar)->result();
			$data['tgl_awal']=$tgl_awal;
			$data['tgl_akhir']=$tgl_akhir;
			$data['pelayanan']='SEMUA';
			$data['carabayar']=$carabayar;
		}else if($pelayanan != 'SEMUA' && $carabayar =='SEMUA'){
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal,$tgl_akhir,$pelayanan,$carabayar)->result();
			$data['tgl_awal']=$tgl_awal;
			$data['tgl_akhir']=$tgl_akhir;
			$data['pelayanan']=$pelayanan;
			$data['carabayar']='SEMUA';
		}else{
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal,$tgl_akhir,$pelayanan,$carabayar)->result();
			$data['tgl_awal']=$tgl_awal;
			$data['tgl_akhir']=$tgl_akhir;
			$data['pelayanan']='SEMUA';
			$data['carabayar']='SEMUA';
		}

		$this->load->view('irj/rjvlapkeulab',$data);
	}

	public function pdf_lapkeulab($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Laboratorium';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_lab($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapkeulab',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeulab',$data);
	}

	public function lapkeuem($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Elektromedik';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeuem',$data);
	}

	public function pdf_lapkeuem($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Elektromedik';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_em($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapkeuem',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeuem',$data);
	}

	public function lapkeuok($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Operasi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeuok',$data);
	}

	public function pdf_lapkeuok($tgl_awal='',$tgl_akhir='',$userid='')
	{
		$data['title']='Laporan Keuangan Operasi';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		if ($tgl_awal == null && $tgl_akhir == null && $userid == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date('Y-m-d');
			$data['tgl_akhir']=date('Y-m-d');
			$data['userid']='';
		}else{
			// $tgl = explode("-", $tanggal);
			
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			
			if ($userid == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok($tgl_awal, $tgl_akhir, '')->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']='';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_ok($tgl_awal, $tgl_akhir, $userid)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['userid']=$userid;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		// if($this->input->post('tgl')!=''){
		// 	$tgl0=$this->input->post('tgl');
		// }else{
		// 	$tgl0=date('Y-m-d', strtotime('-7 days'));
		// }

		// if($this->input->post('tgl0')!=''){
		// 	$tgl1=$this->input->post('tgl0');
		// }else{
		// 	$tgl1=date('Y-m-d');
		// }
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		
		$html = $this->load->view('irj/pdf/rjvlapkeuok',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeuok',$data);
	}

	public function lap_dokter_poli_jaminan()
	{		
		$data['title']='Laporan Dokter Berdasarkan Poliklinik Dan Jaminan';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;		
		$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	

		if ($lap_per == '') {
			// die();
			$valid=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan('','')->row();
			
			
			if ($valid != null) {
				$data['diagnosa']=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan('','')->result();
		
				foreach ($data['diagnosa'] as $key) {
					$jumlahUmum[] =$key->umum;
					$jumlahBpjs[] =$key->bpjs;
					$jumlahInhealth[] =$key->inhealth;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBukit_asam[] =$key->bukit_asam;
					$jumlahTelkom[] =$key->telkom;
					$jumlahPln[] =$key->pln;
					$jumlahTaspen[] =$key->taspen;
					$jumlahJasa_rahaja[] =$key->jasa_rahaja;
					$jumlahBpjs_pbi[] =$key->bpjs_pbi;
					$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
					$jumlahTotal[] =$key->jumlah;
				}
				$jumlah_umum     = array_sum($jumlahUmum);
				$jumlah_bpjs     = array_sum($jumlahBpjs);
				$jumlah_inhealth  = array_sum($jumlahInhealth);
				$jumlah_nayaka  = array_sum($jumlahNayaka);
				$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
				$jumlah_telkom  = array_sum($jumlahTelkom);
				$jumlah_pln  = array_sum($jumlahPln);
				$jumlah_taspen  = array_sum($jumlahTaspen);
				$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
				$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
				$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
				$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
				$jumlah_total = array_sum($jumlahTotal);

				$data['jumlah_umum'] = $jumlah_umum;
				$data['jumlah_bpjs'] = $jumlah_bpjs;	
				$data['jumlah_inhealth'] = $jumlah_inhealth;	
				$data['jumlah_nayaka'] = $jumlah_nayaka;	
				$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
				$data['jumlah_telkom'] = $jumlah_telkom;	
				$data['jumlah_pln'] = $jumlah_pln;	
				$data['jumlah_taspen'] = $jumlah_taspen;	
				$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
				$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
				$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
				$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
				$data['jumlah_total'] = $jumlah_total;	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($tgl,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($tgl,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($bulan,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($bulan,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan($tahun,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan('','')->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_dokter_poli_jaminan('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);
	
					$data['jumlah_umum'] = $jumlah_umum;
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				

		
		$this->load->view('irj/rjvlapdokterpolijaminan',$data);
		
	}

	public function lap_waktu_tunggu_irj()
	{		
		$data['title']='Laporan Dokter Berdasarkan Poliklinik Dan Jaminan';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');
		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;		
		$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	

		if ($lap_per == '') {
			// die();
			$valid=$this->Rjmlaporan->get_data_kunj_waktu_irj('','')->row();
			
			
			if ($valid != null) {
				$data['data']=$this->Rjmlaporan->get_data_kunj_waktu_irj('','')->result();
		
				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_data_kunj_waktu_irj($tgl,$lap_per)->row();

				if ($valid != null) {
					$data['data']=$this->Rjmlaporan->get_data_kunj_waktu_irj($tgl,$lap_per)->result();
		

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_data_kunj_waktu_irj($bulan,$lap_per)->row();

				if ($valid != null) {
					$data['data']=$this->Rjmlaporan->get_data_kunj_waktu_irj($bulan,$lap_per)->result();
		
					

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_data_kunj_waktu_irj($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['data']=$this->Rjmlaporan->get_data_kunj_waktu_irj($tahun,$lap_per)->result();
		
					

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_data_kunj_waktu_irj('','')->row();
				if ($valid != null) {
					$data['data']=$this->Rjmlaporan->get_data_kunj_waktu_irj('','')->result();
			
					
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				

		
		$this->load->view('irj/rjvlapwaktutungguirj',$data);
		
	}

	public function lapkeukerjasamarj($tgl_awal='',$tgl_akhir='',$id_kontraktor='')
	{
		$data['title']='Laporan Keuangan Kerjasama Rawat Jalan';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}elseif ($id_kontraktor == 'SEMUA') {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, '')->result();				
			$data['tgl_awal']=$tgl_awal;
			$data['tgl_akhir']=$tgl_akhir;
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeukerjasamarj',$data);
	}

	public function pdf_lapkeukerjasamarj($id_kontraktor='',$tgl_awal='',$tgl_akhir='')
	{
		$data['title']='Laporan Keuangan Kerjasama Rawat Jalan';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}elseif ($id_kontraktor == 'SEMUA') {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_rj($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

				$html = $this->load->view('irj/pdf/rjvlapkeukerjasamarj',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
		// $this->load->view('irj/rjvlapkeukerjasamarj',$data);
	}

	public function lapkeukerjasamari($tgl_awal='',$tgl_akhir='',$id_kontraktor='')
	{
		$data['title']='Laporan Keuangan Kerjasama Rawat Inap';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}elseif ($id_kontraktor == 'SEMUA') {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeukerjasamari',$data);
	}

	public function pdf_lapkeukerjasamari($id_kontraktor='',$tgl_awal='',$tgl_akhir='')
	{
		$data['title']='Laporan Keuangan Kerjasama Rawat Inap';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}elseif ($id_kontraktor == 'SEMUA') {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_ri($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

				$html = $this->load->view('irj/pdf/rjvlapkeukerjasamari',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
		// $this->load->view('irj/rjvlapkeukerjasamari',$data);
	}

	public function lapkeukerjasamapenunjang($tgl_awal='',$tgl_akhir='',$id_kontraktor='')
	{
		$data['title']='Laporan Keuangan Kerjasama Penunjang';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}elseif ($id_kontraktor == 'SEMUA') {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$this->load->view('irj/rjvlapkeukerjasamapenunjang',$data);
	}

	public function pdf_lapkeukerjasamapenunjang($id_kontraktor='',$tgl_awal='',$tgl_akhir='')
	{
		$data['title']='Laporan Keuangan Kerjasama Penunjang';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['kasir']=$this->Rjmlaporan->get_user_kasir()->result();
		$data['kontraktor']=$this->Rjmlaporan->get_kontraktor()->result();
		$data['poli']=$this->Rjmlaporan->get_poliklinik()->result();
		// $tanggal = $this->input->post('tanggal_laporan');
		// $userid = $this->input->post('userid');
		// var_dump($tanggal);
		// die();
		if ($tgl_awal == null && $tgl_akhir == null && $id_kontraktor == null) {
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang(date('Y-m-d'), date("Y-m-d"), '')->result();
			$data['tgl_awal']=date("Y-m-d");
			$data['tgl_akhir']=date("Y-m-d");
			$data['nmkontraktor']='SEMUA';
			$data['id_kontraktor']='SEMUA';
		}else{
			// $tgl = explode("-", $tanggal);
			// $tgl_awal=str_replace('/','-',$tgl[0]);
			// $tgl_akhir=str_replace('/','-',$tgl[1]);
			
			if ($id_kontraktor == null) {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}elseif ($id_kontraktor == 'SEMUA') {
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, '')->result();				
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']='SEMUA';
				$data['id_kontraktor']='SEMUA';
			}else{
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_kerjasama_penunjang($tgl_awal, $tgl_akhir, $id_kontraktor)->result();
				$data['tgl_awal']=$tgl_awal;
				$data['tgl_akhir']=$tgl_akhir;
				$data['nmkontraktor']=$this->Rjmlaporan->get_nmkontraktor($id_kontraktor)->row()->nmkontraktor;
				$data['id_kontraktor']=$id_kontraktor;
			}			
		}
		

		$tgl = date("d m Y");
		$data['date_title']='Tanggal <b>('.$tgl_awal.' - '.$tgl_akhir.')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));	
		
		$status=$data['status'];
		$cara_bayar=$data['cara_bayar'];

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
		$mpdf->curlAllowUnsafeSslRequests = true;		
 
		$html = $this->load->view('irj/pdf/rjvlapkeukerjasamapenunjang',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapkeukerjasamapenunjang',$data);
	}

	public function pdf_lap_kunj_irj($tampil_per='', $id_poli='',$tgl='',$cara_bayar='',$id_dokter = '')
	{
		
			$data['title']="Laporan Kunjungan Pasien";
			$data['select_poli']=$this->Rjmpencarian->get_poliklinik()->result();
			$data['space']="";
			$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result();
			$data['tampil_per']=$tampil_per;
			$data['kontraktorcari']='';
			// var_dump($this->input->post('tampil_per'));
			// var_dump($this->input->post('cara_bayar'));
			// var_dump($this->input->post('tgl'));
			// var_dump(explode("@", $this->input->post('id_poli')));
			// var_dump($this->input->post('id_dokter'));
			// die();

			if ($data['tampil_per'] == "TGL") {
									
				//date title
				$data['tgl']=$tgl;
				
				$data['cara_bayar']=$cara_bayar;				
				$data['kontraktorcari']=$this->input->post('bpjs_bayar');	
				$tgl = date('d m Y', strtotime($data['tgl']));
				//$data['date_title']='(<b>'.$tgl.'</b>)';
				$data['date_title']='<b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				
				
				
				if ($id_poli=="SEMUA") {					
					if ($id_dokter=="SEMUA") {
						// var_dump($data['tgl']);
						// var_dump($data['cara_bayar']);
						// var_dump($this->input->post('bpjs_bayar'));
						// die();
						$result=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();
						
						if ($result != null) {
							$data['data_lap'] = "Ada";
							$data['id_poli']="SEMUA";
							$data['id_dokter']=$id_dokter;
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();
							
						
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;	
						}else{
							$data['data_lap'] = "Kosong";
							$data['id_poli']="SEMUA";
							$data['id_dokter']='SEMUA';
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();					
							$data['data_laporan_kunj']=array();
						}
						
			
					}else{
						echo "Data Kosong";
					}
																
				} else {
					if ($id_dokter=="SEMUA") {
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$result=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$id_dokter;
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();				
							// 	var_dump($data['data_laporan_kunj']);
							// die();	
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}else{
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$select_dokter = $id_dokter;
						$result=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$id_dokter;
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->result();


							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}										
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		

				$html = $this->load->view('irj/pdf/rjvlapkunjungan_harian',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			} else if ($data['tampil_per'] == "BLN") {
				
				//date title
				$data['bulan']=$tgl;
				//$bulan = date('m Y', strtotime($data['bulan']));
				$bulan1 = substr($data['bulan'],5,2)." ".date('Y', strtotime($data['bulan']));
				$data['date_title']='<b>('.$bulan1.')</b>';
				//----------
				$data['cara_bayar']='';
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_bulanan($data['bulan'])->result();
					
				} else {
					$select_poli = explode("@", $id_poli);
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_bulanan($data['bulan'],$data['id_poli'])->result();
				}
			
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
				$mpdf->curlAllowUnsafeSslRequests = true;		
 
				$html = $this->load->view('irj/pdf/rjvlapkunjungan_bulanan',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			} else if ($data['tampil_per'] == "THN") {
					
				//date title
				$data['tahun']=$tgl;
				$data['date_title']='<b>('.$data['tahun'].')</b>';
				//----------
				$data['cara_bayar']='';
				if ($id_poli=="SEMUA") {
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_tahunan($data['tahun'])->result();
					
				} else {
					$select_poli = explode("@", $id_poli);
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_tahunan($data['tahun'],$data['id_poli'])->result();
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		

				$html = $this->load->view('irj/pdf/rjvlapkunjungan_tahunan',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			}else{
				$data['tgl']=date('Y-m-d');
				
				$data['cara_bayar']=$cara_bayar;				
				$data['kontraktorcari']=$this->input->post('bpjs_bayar');	
				$tgl = date('d m Y', strtotime($data['tgl']));
				//$data['date_title']='(<b>'.$tgl.'</b>)';
				$data['date_title']='<b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				
				
				
				if ($id_poli=="SEMUA") {					
					if ($id_dokter=="SEMUA") {
						// var_dump($data['tgl']);
						// var_dump($data['cara_bayar']);
						// var_dump($this->input->post('bpjs_bayar'));
						// die();
						$result=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();
						
						if ($result != null) {
							$data['data_lap'] = "Ada";
							$data['id_poli']="SEMUA";
							$data['id_dokter']=$id_dokter;
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();
							
						
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;	
						}else{
							$data['data_lap'] = "Kosong";
							$data['id_poli']="SEMUA";
							$data['id_dokter']='SEMUA';
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();					
							$data['data_laporan_kunj']=array();
						}
						
			
					}else{
						echo "Data Kosong";
					}
																
				} else {
					if ($id_dokter=="SEMUA") {
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$result=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$id_dokter;
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();				
							// 	var_dump($data['data_laporan_kunj']);
							// die();	
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}else{
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$select_dokter = $id_dokter;
						$result=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']=$id_dokter;
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->result();


							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rjmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['id_dokter']='';
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}										
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		

				$html = $this->load->view('irj/pdf/rjvlapkunjungan_harian',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			}
			


			// $this->load->view('irj/rjvlapkunjungan',$data);
		
	}
	
	public function pdf_lap_dig_kasus_jenkel($lap_pers='',$layanan='',$var='')
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Diagnosa, Kasus Dan Jenis Kelamin';

		$tgl = $var;
		$bulan = $var;
		$tahun = $var;
		$lap_per = $lap_pers;

		$data['tgl'] = $tgl;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;

		if ($lap_per == '') {
			$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->row();

			if ($valid != null) {
				$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->result();
				
				foreach ($data['diagnosa'] as $key) {
					$jumlahL[] =$key->l;
					$jumlahP[] =$key->p;
					$jumlahBaru[] =$key->baru;
					$jumlahLama[] =$key->lama;
					$jumlahTotal[] =$key->jumlah;
				}
				$jumlah_l     = array_sum($jumlahL);
				$jumlah_p     = array_sum($jumlahP);
				$jumlah_baru  = array_sum($jumlahBaru);
				$jumlah_lama  = array_sum($jumlahLama);
				$jumlah_total = array_sum($jumlahTotal);
				$data['jumlah_l'] = $jumlah_l;	
				$data['jumlah_p'] = $jumlah_p;		
				$data['jumlah_baru'] = $jumlah_baru;
				$data['jumlah_lama'] = $jumlah_lama;	
				$data['jumlah_total'] = $jumlah_total;	
				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
			}			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tgl,$lap_per,$layanan)->result();				
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($bulan,$lap_per,$layanan)->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel($tahun,$lap_per)->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;
					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_diagnosa_kasus_jenkel('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahL[] =$key->l;
						$jumlahP[] =$key->p;
						$jumlahLama[] =$key->lama;
						$jumlahBaru[] =$key->baru;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_l     = array_sum($jumlahL);
					$jumlah_p     = array_sum($jumlahP);
					$jumlah_lama  = array_sum($jumlahLama);
					$jumlah_baru  = array_sum($jumlahBaru);
					$jumlah_total = array_sum($jumlahTotal);
					$data['jumlah_l'] = $jumlah_l;	
					$data['jumlah_p'] = $jumlah_p;	
					$data['jumlah_lama'] = $jumlah_lama;	
					$data['jumlah_baru'] = $jumlah_baru;	
					$data['jumlah_total'] = $jumlah_total;	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
						$data['valid'] = 'KOSONG';
						$data['judul'] = '';
				}
			}	
		}
				

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapdigkasusjenkel',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapdigkasusjenkel',$data);
		
	}	

	public function pdf_lap_wilayah_jaminan($lap_pers='',$layanan='',$var='')
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Wilayah Dan Jaminan';

		$tgl = $var;
		$bulan = $var;
		$tahun = $var;
		$lap_per = $lap_pers;

		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;
		$data['layanan'] = urldecode($layanan);;		

		if ($lap_per == '') {
			$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->row();

			if ($valid != null) {
				$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->result();
		
				foreach ($data['diagnosa'] as $key) {
					$jumlahUmum[] =$key->umum;
					$jumlahBpjs[] =$key->bpjs;
					$jumlahInhealth[] =$key->inhealth;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBukit_asam[] =$key->bukit_asam;
					$jumlahTelkom[] =$key->telkom;
					$jumlahPln[] =$key->pln;
					$jumlahTaspen[] =$key->taspen;
					$jumlahJasa_rahaja[] =$key->jasa_rahaja;
					$jumlahBpjs_pbi[] =$key->bpjs_pbi;
					$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
					$jumlahTotal[] =$key->jumlah;
				}
				$jumlah_umum     = array_sum($jumlahUmum);
				$jumlah_bpjs     = array_sum($jumlahBpjs);
				$jumlah_inhealth  = array_sum($jumlahInhealth);
				$jumlah_nayaka  = array_sum($jumlahNayaka);
				$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
				$jumlah_telkom  = array_sum($jumlahTelkom);
				$jumlah_pln  = array_sum($jumlahPln);
				$jumlah_taspen  = array_sum($jumlahTaspen);
				$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
				$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
				$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
				$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
				$jumlah_total = array_sum($jumlahTotal);

				$data['jumlah_umum'] = $jumlah_umum;
				$data['jumlah_bpjs'] = $jumlah_bpjs;	
				$data['jumlah_inhealth'] = $jumlah_inhealth;	
				$data['jumlah_nayaka'] = $jumlah_nayaka;	
				$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
				$data['jumlah_telkom'] = $jumlah_telkom;	
				$data['jumlah_pln'] = $jumlah_pln;	
				$data['jumlah_taspen'] = $jumlah_taspen;	
				$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
				$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
				$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
				$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
				$data['jumlah_total'] = $jumlah_total;	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tgl,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($bulan,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan($tahun,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_wilayah_jaminan('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);
	
					$data['jumlah_umum'] = $jumlah_umum;
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapwilayahjaminan',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		// $this->load->view('irj/rjvlapwilayahjaminan',$data);
		
	}

	public function pdf_lap_jenkel_jaminan_kasus($lap_pers='',$layanan='',$var='')
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Jenis Kelamin ,Jaminan Dan Kasus';

		$tgl = $var;
		$bulan = $var;
		$tahun = $var;
		$lap_per = $lap_pers;

		$data['tgl'] = $tgl;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;

		if ($lap_per == '') {
			$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->row();

			if ($valid != null) {
				$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->result();
		
				foreach ($data['kunj_poli'] as $key) {
					$jumlahUmum_baru_l[] =$key->umum_baru_l;
					$jumlahUmum_baru_p[] =$key->umum_baru_p;
					$jumlahUmum_lama_l[] =$key->umum_lama_l;
					$jumlahUmum_lama_p[] =$key->umum_lama_p;
					
					$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
					$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
					$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
					$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
					
					$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
					$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
					$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
					$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
					
					$jumlahPln_baru_l[] =$key->pln_baru_l;
					$jumlahPln_baru_p[] =$key->pln_baru_p;
					$jumlahPln_lama_l[] =$key->pln_lama_l;
					$jumlahPln_lama_p[] =$key->pln_lama_p;
					
					$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
					$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
					$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
					$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
					
					$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
					$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
					$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
					$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

					$jumlahBaru[] =$key->baru;
					$jumlahLama[] =$key->lama;

					$jumlahTotal[] =$key->jumlah;
				}
				$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
				$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
				$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
				$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

				$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
				$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
				$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
				$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

				$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
				$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
				$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
				$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

				$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
				$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
				$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
				$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

				$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
				$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
				$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
				$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

				$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
				$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
				$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
				$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

				$jumlah_baru     = array_sum($jumlahBaru);
				$jumlah_lama     = array_sum($jumlahLama);
				
				$jumlah_total = array_sum($jumlahTotal);

				$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
				$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
				$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
				$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

				$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
				$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
				$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
				$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

				$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
				$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
				$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
				$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

				$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
				$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
				$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
				$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

				$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
				$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
				$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
				$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

				$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
				$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
				$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
				$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

				$data['jumlah_baru'] = $jumlah_baru;
				$data['jumlah_lama'] = $jumlah_lama;	
					
				$data['jumlah_total'] = $jumlah_total;	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tgl,$lap_per,$layanan)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($bulan,$lap_per,$layanan)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = 'Bulan'.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){

				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tahun,$lap_per)->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus($tahun,$lap_per)->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = 'Tahun'.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	

			}else{
				$valid=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->row();

				if ($valid != null) {
					$data['kunj_poli']=$this->Rjmlaporan->get_kunj_jenkel_jaminan_kasus('','')->result();
			
					foreach ($data['kunj_poli'] as $key) {
						$jumlahUmum_baru_l[] =$key->umum_baru_l;
						$jumlahUmum_baru_p[] =$key->umum_baru_p;
						$jumlahUmum_lama_l[] =$key->umum_lama_l;
						$jumlahUmum_lama_p[] =$key->umum_lama_p;
						
						$jumlahBPJS_baru_l[] =$key->bpjs_baru_l;
						$jumlahBPJS_baru_p[] =$key->bpjs_baru_p;
						$jumlahBPJS_lama_l[] =$key->bpjs_lama_l;
						$jumlahBPJS_lama_p[] =$key->bpjs_lama_p;
						
						$jumlahBukit_asam_baru_l[] =$key->bukit_asam_baru_l;
						$jumlahBukit_asam_baru_p[] =$key->bukit_asam_baru_p;
						$jumlahBukit_asam_lama_l[] =$key->bukit_asam_lama_l;
						$jumlahBukit_asam_lama_p[] =$key->bukit_asam_lama_p;
						
						$jumlahPln_baru_l[] =$key->pln_baru_l;
						$jumlahPln_baru_p[] =$key->pln_baru_p;
						$jumlahPln_lama_l[] =$key->pln_lama_l;
						$jumlahPln_lama_p[] =$key->pln_lama_p;
						
						$jumlahInhealth_baru_l[] =$key->inhealth_baru_l;
						$jumlahInhealth_baru_p[] =$key->inhealth_baru_p;
						$jumlahInhealth_lama_l[] =$key->inhealth_lama_l;
						$jumlahInhealth_lama_p[] =$key->inhealth_lama_p;
						
						$jumlahTelkom_baru_l[] =$key->telkom_baru_l;
						$jumlahTelkom_baru_p[] =$key->telkom_baru_p;
						$jumlahTelkom_lama_l[] =$key->telkom_lama_l;
						$jumlahTelkom_lama_p[] =$key->telkom_lama_p;

						$jumlahBaru[] =$key->baru;
						$jumlahLama[] =$key->lama;

						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum_baru_l     = array_sum($jumlahUmum_baru_l);
					$jumlah_umum_baru_p     = array_sum($jumlahUmum_baru_p);
					$jumlah_umum_lama_l     = array_sum($jumlahUmum_lama_l);
					$jumlah_umum_lama_p     = array_sum($jumlahUmum_lama_p);

					$jumlah_bpjs_baru_l     = array_sum($jumlahBPJS_baru_l);
					$jumlah_bpjs_baru_p     = array_sum($jumlahBPJS_baru_p);
					$jumlah_bpjs_lama_l     = array_sum($jumlahBPJS_lama_l);
					$jumlah_bpjs_lama_p     = array_sum($jumlahBPJS_lama_p);

					$jumlah_bukit_asam_baru_l     = array_sum($jumlahBukit_asam_baru_l);
					$jumlah_bukit_asam_baru_p     = array_sum($jumlahBukit_asam_baru_p);
					$jumlah_bukit_asam_lama_l     = array_sum($jumlahBukit_asam_lama_l);
					$jumlah_bukit_asam_lama_p     = array_sum($jumlahBukit_asam_lama_p);

					$jumlah_pln_baru_l     = array_sum($jumlahPln_baru_l);
					$jumlah_pln_baru_p     = array_sum($jumlahPln_baru_p);
					$jumlah_pln_lama_l     = array_sum($jumlahPln_lama_l);
					$jumlah_pln_lama_p     = array_sum($jumlahPln_lama_p);

					$jumlah_inhealth_baru_l     = array_sum($jumlahInhealth_baru_l);
					$jumlah_inhealth_baru_p     = array_sum($jumlahInhealth_baru_p);
					$jumlah_inhealth_lama_l     = array_sum($jumlahInhealth_lama_l);
					$jumlah_inhealth_lama_p     = array_sum($jumlahInhealth_lama_p);

					$jumlah_telkom_baru_l     = array_sum($jumlahTelkom_baru_l);
					$jumlah_telkom_baru_p     = array_sum($jumlahTelkom_baru_p);
					$jumlah_telkom_lama_l     = array_sum($jumlahTelkom_lama_l);
					$jumlah_telkom_lama_p     = array_sum($jumlahTelkom_lama_p);

					$jumlah_baru     = array_sum($jumlahBaru);
					$jumlah_lama     = array_sum($jumlahLama);
					
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum_baru_l'] = $jumlah_umum_baru_l;
					$data['jumlah_umum_baru_p'] = $jumlah_umum_baru_p;	
					$data['jumlah_umum_lama_l'] = $jumlah_umum_lama_l;
					$data['jumlah_umum_lama_p'] = $jumlah_umum_lama_p;	

					$data['jumlah_bpjs_baru_l'] = $jumlah_bpjs_baru_l;
					$data['jumlah_bpjs_baru_p'] = $jumlah_bpjs_baru_p;	
					$data['jumlah_bpjs_lama_l'] = $jumlah_bpjs_lama_l;
					$data['jumlah_bpjs_lama_p'] = $jumlah_bpjs_lama_p;	

					$data['jumlah_bukit_asam_baru_l'] = $jumlah_bukit_asam_baru_l;
					$data['jumlah_bukit_asam_baru_p'] = $jumlah_bukit_asam_baru_p;	
					$data['jumlah_bukit_asam_lama_l'] = $jumlah_bukit_asam_lama_l;
					$data['jumlah_bukit_asam_lama_p'] = $jumlah_bukit_asam_lama_p;	

					$data['jumlah_pln_baru_l'] = $jumlah_pln_baru_l;
					$data['jumlah_pln_baru_p'] = $jumlah_pln_baru_p;	
					$data['jumlah_pln_lama_l'] = $jumlah_pln_lama_l;
					$data['jumlah_pln_lama_p'] = $jumlah_pln_lama_p;	

					$data['jumlah_inhealth_baru_l'] = $jumlah_inhealth_baru_l;
					$data['jumlah_inhealth_baru_p'] = $jumlah_inhealth_baru_p;	
					$data['jumlah_inhealth_lama_l'] = $jumlah_inhealth_lama_l;
					$data['jumlah_inhealth_lama_p'] = $jumlah_inhealth_lama_p;		

					$data['jumlah_telkom_baru_l'] = $jumlah_telkom_baru_l;
					$data['jumlah_telkom_baru_p'] = $jumlah_telkom_baru_p;	
					$data['jumlah_telkom_lama_l'] = $jumlah_telkom_lama_l;
					$data['jumlah_telkom_lama_p'] = $jumlah_telkom_lama_p;

					$data['jumlah_baru'] = $jumlah_baru;
					$data['jumlah_lama'] = $jumlah_lama;	
						
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
			}	
		}
				
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
		$mpdf->curlAllowUnsafeSslRequests = true;		
 
		$html = $this->load->view('irj/pdf/rjvlapjenkeljaminankasus',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		
		// $this->load->view('irj/rjvlapjenkeljaminankasus',$data);
		
	}

	public function pdf_lap_poli_jaminan($lap_pers='',$layanan='',$var='')
	{		
		$data['title']='Laporan Poliklinik Dan Jaminan';

		$tgl = $var;
		$bulan = $var;
		$tahun = $var;
		$lap_per = $lap_pers;
		$data['tgl'] = $tgl;			
		$data['bulan'] = $bulan;		
		$data['tahun'] = $tahun;			
		$data['lap_per'] = $lap_per;
		$data['layanan'] = $layanan;		

		if ($lap_per == '') {
			// die();
			$valid=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->row();
			
			
			if ($valid != null) {
				$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->result();
		
				foreach ($data['diagnosa'] as $key) {
					$jumlahUmum[] =$key->umum;
					$jumlahBpjs[] =$key->bpjs;
					$jumlahInhealth[] =$key->inhealth;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBukit_asam[] =$key->bukit_asam;
					$jumlahTelkom[] =$key->telkom;
					$jumlahPln[] =$key->pln;
					$jumlahTaspen[] =$key->taspen;
					$jumlahJasa_rahaja[] =$key->jasa_rahaja;
					$jumlahBpjs_pbi[] =$key->bpjs_pbi;
					$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
					$jumlahNayaka[] =$key->nayaka;
					$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
					$jumlahTotal[] =$key->jumlah;
				}
				$jumlah_umum     = array_sum($jumlahUmum);
				$jumlah_bpjs     = array_sum($jumlahBpjs);
				$jumlah_inhealth  = array_sum($jumlahInhealth);
				$jumlah_nayaka  = array_sum($jumlahNayaka);
				$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
				$jumlah_telkom  = array_sum($jumlahTelkom);
				$jumlah_pln  = array_sum($jumlahPln);
				$jumlah_taspen  = array_sum($jumlahTaspen);
				$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
				$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
				$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
				$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
				$jumlah_total = array_sum($jumlahTotal);

				$data['jumlah_umum'] = $jumlah_umum;
				$data['jumlah_bpjs'] = $jumlah_bpjs;	
				$data['jumlah_inhealth'] = $jumlah_inhealth;	
				$data['jumlah_nayaka'] = $jumlah_nayaka;	
				$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
				$data['jumlah_telkom'] = $jumlah_telkom;	
				$data['jumlah_pln'] = $jumlah_pln;	
				$data['jumlah_taspen'] = $jumlah_taspen;	
				$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
				$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
				$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
				$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
				$data['jumlah_total'] = $jumlah_total;	

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($tgl,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($tgl,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tanggal '.$tgl;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($bulan,$lap_per,$layanan)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($bulan,$lap_per,$layanan)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Bulan '.$bulan;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
				
			}elseif($lap_per == 'THN'){
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan($tahun,$lap_per)->result();
		
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);

					$data['jumlah_umum'] = $jumlah_umum;	
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	

					$data['valid'] = 'ADA';
					$data['judul'] = ' Tahun '.$tahun;
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->row();
				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_kunj_poli_jaminan('','')->result();
			
					foreach ($data['diagnosa'] as $key) {
						$jumlahUmum[] =$key->umum;
						$jumlahBpjs[] =$key->bpjs;
						$jumlahInhealth[] =$key->inhealth;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBukit_asam[] =$key->bukit_asam;
						$jumlahTelkom[] =$key->telkom;
						$jumlahPln[] =$key->pln;
						$jumlahTaspen[] =$key->taspen;
						$jumlahJasa_rahaja[] =$key->jasa_rahaja;
						$jumlahBpjs_pbi[] =$key->bpjs_pbi;
						$jumlahBpjs_mandiri[] =$key->bpjs_mandiri;
						$jumlahNayaka[] =$key->nayaka;
						$jumlahBpjs_non_pbi[] =$key->bpjs_non_pbi;
						$jumlahTotal[] =$key->jumlah;
					}
					$jumlah_umum     = array_sum($jumlahUmum);
					$jumlah_bpjs     = array_sum($jumlahBpjs);
					$jumlah_inhealth  = array_sum($jumlahInhealth);
					$jumlah_nayaka  = array_sum($jumlahNayaka);
					$jumlah_bukit_asam  = array_sum($jumlahBukit_asam);
					$jumlah_telkom  = array_sum($jumlahTelkom);
					$jumlah_pln  = array_sum($jumlahPln);
					$jumlah_taspen  = array_sum($jumlahTaspen);
					$jumlah_jasa_rahaja  = array_sum($jumlahJasa_rahaja);
					$jumlah_bpjs_pbi  = array_sum($jumlahBpjs_pbi);
					$jumlah_bpjs_mandiri  = array_sum($jumlahBpjs_mandiri);
					$jumlah_bpjs_non_pbi  = array_sum($jumlahBpjs_non_pbi);
					$jumlah_total = array_sum($jumlahTotal);
	
					$data['jumlah_umum'] = $jumlah_umum;
					$data['jumlah_bpjs'] = $jumlah_bpjs;	
					$data['jumlah_inhealth'] = $jumlah_inhealth;	
					$data['jumlah_nayaka'] = $jumlah_nayaka;	
					$data['jumlah_bukit_asam'] = $jumlah_bukit_asam;	
					$data['jumlah_telkom'] = $jumlah_telkom;	
					$data['jumlah_pln'] = $jumlah_pln;	
					$data['jumlah_taspen'] = $jumlah_taspen;	
					$data['jumlah_jasa_rahaja'] = $jumlah_jasa_rahaja;	
					$data['jumlah_bpjs_pbi'] = $jumlah_bpjs_pbi;	
					$data['jumlah_bpjs_mandiri'] = $jumlah_bpjs_mandiri;	
					$data['jumlah_bpjs_non_pbi'] = $jumlah_bpjs_non_pbi;	
					$data['jumlah_total'] = $jumlah_total;	
	
					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
			}	
		}
				
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		$mpdf->curlAllowUnsafeSslRequests = true;		
 
		$html = $this->load->view('irj/pdf/rjvlappolijaminan',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		
		// $this->load->view('irj/rjvlappolijaminan',$data);
		
	}

	public function pdf_lap_wilayah_diagnosa($lap_pers='',$var='')
	{		
		// $valid=$this->Rjmlaporan->get_kunj_wilayah_diagnosa('','')->result();
		
		$data['title']='Laporan Poliklinik Berdasarkan Jenis Kelamin ,Jaminan Dan Kasus';

		$tgl = $var;
		$bulan = $var;
		$tahun = $var;
		$lap_per = $lap_pers;
		$data['lap_per'] = $lap_per;
		if ($lap_per == '') {

			$valid=$this->Rjmlaporan->get_wilayah_detail('','')->row();

			if ($valid != null) {
				// $data['kunj_poli']=$this->Rjmlaporan->get_kunj_wilayah_diagnosa('','')->result();
				$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
				$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
				$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail('','')->result();										

				$data['valid'] = 'ADA';
				$data['judul'] = '';
			}else{
				$data['diagnosa']= array();
				$data['wilayah']= array();
				$data['wilayah_detail']= array();
				$data['valid'] = 'KOSONG';
				$data['judul'] = '';
			}
			
		
		}else{
			if ($lap_per == 'TGL') {

				$valid=$this->Rjmlaporan->get_wilayah_detail($tgl,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($tgl,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}elseif($lap_per == 'BLN'){

				$valid=$this->Rjmlaporan->get_wilayah_detail($bulan,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($bulan,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}
				
			}elseif($lap_per == 'THN'){

				$valid=$this->Rjmlaporan->get_wilayah_detail($tahun,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail($tahun,$lap_per)->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}

			}else{
				$valid=$this->Rjmlaporan->get_wilayah_detail('','')->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rjmlaporan->get_diagnosa()->result();
					$data['wilayah']=$this->Rjmlaporan->get_wilayah()->result();
					$data['wilayah_detail']=$this->Rjmlaporan->get_wilayah_detail('','')->result();										

					$data['valid'] = 'ADA';
					$data['judul'] = '';
				}else{
					$data['diagnosa']= array();
					$data['wilayah']= array();
					$data['wilayah_detail']= array();
					$data['valid'] = 'KOSONG';
					$data['judul'] = '';
				}	
			}	
		}
				
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('irj/pdf/rjvlapwilayahdiagnosa',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		
		// $this->load->view('irj/rjvlapwilayahdiagnosa',$data);
		
	}

	public function get_data_edit_konsul(){
		$id=$this->input->post('id');
		//var_dump($id); die();
		$datajson=$this->Rjmlaporan->get_data_konsul($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_konsul(){
		$id=$this->input->post('edit_id_hidden');
		$noreg = $this->input->post('noreg_hidden');
		$id_poli = $this->input->post('id_poli_hidden');
		$data['tanggal_konsul']=$this->input->post('edit_tgl');
		$du['tgl_kunjungan']=$this->input->post('edit_tgl');
		$data['id_poli_akhir']=$this->input->post('id_poli_akhir');
		$du['kelas_pasien']=$this->input->post('kelas_pasien');
		$data['id_poli_akhir']=substr($this->input->post('id_poli_akhir'),0,4);
		$du['id_poli']=substr($this->input->post('id_poli_akhir'),0,4);
		$data['id_dokter_akhir']=explode('-',$this->input->post('id_dokter_akhir'))[0];
		$du['id_dokter']=explode('-',$this->input->post('id_dokter_akhir'))[0];
		$data['kemungkinan_sangkaan']=$this->input->post('edit_kemungkinan');
		$data['pengobatan_untuk']=$this->input->post('edit_pengobatan');
		$data['kelainan'] = $this->input->post('edit_kelainan');
		$data['pengobatan'] = $this->input->post('edit_pengobatan_yg_dilakukan');
		$data['perhatian_khusus'] = $this->input->post('edit_perhatian');
		$data['nasehat'] = $this->input->post('edit_nasehat');
		$data['opsi_konsul'] = $this->input->post('opsi_konsul');
		$data['verif_daftar'] = $this->input->post('verif_daftar');

		$this->Rjmlaporan->edit_konsul($id, $data);
		$this->Rjmlaporan->edit_data_konsul_daftar_ulang($noreg, $id_poli, $du);
		
		redirect('irj/rjclaporan/data_pasien_konsul_irj');
		//print_r($data);
	}

	public function lap_dpjp_utama() {
		$data['title'] = 'Laporan DPJP Utama Rawat Jalan';
		$this->load->view('irj/lapdpjp_utama', $data);
	}

	public function lap_dpjp_exe($date, $opsi) {
		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul($date, $opsi)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['dokter'] = $value->dokter;
			$row2['igd'] = $value->igd;
			$row2['kandungan'] = $value->kandungan;
			$row2['umum'] = $value->umum;
			$row2['umum24'] = $value->umum24;
			$row2['interne'] = $value->interne;
			$row2['saraf'] = $value->saraf;
			$row2['anak'] = $value->anak;
			$row2['mcu'] = $value->mcu;
			$row2['paru'] = $value->paru;
			$row2['fungsi_luhur'] = $value->fungsi_luhur;
			$row2['rehab_medik'] = $value->rehab_medik;
			$row2['bedah'] = $value->bedah;
			$row2['bedah_syaraf'] = $value->bedah_syaraf;
			$row2['anestesi'] = $value->anestesi;
			$row2['vaksin'] = $value->vaksin;
			$row2['terapi_wicara'] = $value->terapi_wicara;
			$row2['gizi'] = $value->gizi;
			$row2['gigi'] = $value->gigi;
			$row2['neuropsikiatri'] = $value->neuropsikiatri;
			$row2['tht'] = $value->tht;
			$row2['akupuntur'] = $value->akupuntur;
			$row2['fisioterapi'] = $value->fisioterapi;
			$row2['ortetik'] = $value->ortetik;
			$row2['okupasi'] = $value->okupasi;
			$row2['neurointervensi'] = $value->neurointervensi;
			$row2['mata'] = $value->mata;
			$row2['jantung'] = $value->jantung;
			$row2['scu'] = $value->scu;
			$row2['total'] = $value->igd + $value->kandungan + $value->umum + $value->umum24 + $value->interne + $value->saraf + $value->anak + $value->mcu + $value->paru + $value->fungsi_luhur + $value->rehab_medik + $value->bedah + $value->bedah_syaraf + $value->anestesi + $value->vaksin + $value->terapi_wicara + $value->gizi + $value->gigi + $value->neuropsikiatri + $value->tht + $value->fisioterapi + $value->akupuntur + $value->ortetik + $value->okupasi + $value->neurointervensi + $value->mata + $value->jantung + $value->scu;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function lap_dpjp_exe_tgl($date, $opsi) {
		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_tgl($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_tgl($date, $opsi)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['dokter'] = $value->dokter;
			$row2['igd'] = $value->igd;
			$row2['kandungan'] = $value->kandungan;
			$row2['umum'] = $value->umum;
			$row2['umum24'] = $value->umum24;
			$row2['interne'] = $value->interne;
			$row2['saraf'] = $value->saraf;
			$row2['anak'] = $value->anak;
			$row2['mcu'] = $value->mcu;
			$row2['paru'] = $value->paru;
			$row2['fungsi_luhur'] = $value->fungsi_luhur;
			$row2['rehab_medik'] = $value->rehab_medik;
			$row2['bedah'] = $value->bedah;
			$row2['bedah_syaraf'] = $value->bedah_syaraf;
			$row2['anestesi'] = $value->anestesi;
			$row2['vaksin'] = $value->vaksin;
			$row2['terapi_wicara'] = $value->terapi_wicara;
			$row2['gizi'] = $value->gizi;
			$row2['gigi'] = $value->gigi;
			$row2['neuropsikiatri'] = $value->neuropsikiatri;
			$row2['tht'] = $value->tht;
			$row2['akupuntur'] = $value->akupuntur;
			$row2['fisioterapi'] = $value->fisioterapi;
			$row2['ortetik'] = $value->ortetik;
			$row2['okupasi'] = $value->okupasi;
			$row2['neurointervensi'] = $value->neurointervensi;
			$row2['mata'] = $value->mata;
			$row2['jantung'] = $value->jantung;
			$row2['scu'] = $value->scu;
			$row2['total'] = $value->igd + $value->kandungan + $value->umum + $value->umum24 + $value->interne + $value->saraf + $value->anak + $value->mcu + $value->paru + $value->fungsi_luhur + $value->rehab_medik + $value->bedah + $value->bedah_syaraf + $value->anestesi + $value->vaksin + $value->terapi_wicara + $value->gizi + $value->gigi + $value->neuropsikiatri + $value->tht + $value->fisioterapi + $value->akupuntur + $value->ortetik + $value->okupasi + $value->neurointervensi + $value->mata + $value->jantung + $value->scu;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_dpjp_utama($date, $opsi) {
		$tgl = date("F Y", strtotime($date));
		if($opsi == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if($opsi == 'rawat_bersama') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
				
		$sheet->setCellValue('A1', 'Nama DPJP');
		$sheet->setCellValue('B1', 'IGD');
		$sheet->setCellValue('C1', 'Kebidanan/Kandungan');
		$sheet->setCellValue('D1', 'UMUM');
		$sheet->setCellValue('E1', 'UMUM 24 Jam');
		$sheet->setCellValue('F1', 'Penyakit Dalam(INTERNE)');
		$sheet->setCellValue('G1', 'Saraf(NEUROLOGI)');
		$sheet->setCellValue('H1', 'Anak');
		$sheet->setCellValue('I1', 'MCU');
		$sheet->setCellValue('J1', 'Paru');
		$sheet->setCellValue('K1', 'Fungsi Luhur');
		$sheet->setCellValue('L1', 'Rehab Medik');
		$sheet->setCellValue('M1', 'Bedah');
		$sheet->setCellValue('N1', 'Bedah Syaraf');
		$sheet->setCellValue('O1', 'Anestesi');
		$sheet->setCellValue('P1', 'Poli Vaksin');
		$sheet->setCellValue('Q1', 'Terapi Wicara');
		$sheet->setCellValue('R1', 'Gizi');
		$sheet->setCellValue('S1', 'Gigi dan Mulut');
		$sheet->setCellValue('T1', 'Neuropsikiatri');
		$sheet->setCellValue('U1', 'THT');
		$sheet->setCellValue('V1', 'Akupuntur');
		$sheet->setCellValue('W1', 'Fisioterapi');
		$sheet->setCellValue('X1', 'Ortetik Prostetik');
		$sheet->setCellValue('Y1', 'Okupasi Terapi');
		$sheet->setCellValue('Z1', 'Neurointervensi');
		$sheet->setCellValue('AA1', 'Mata');
		$sheet->setCellValue('AB1', 'Jantung dan Pembuluh Darah');
		$sheet->setCellValue('AC1', 'SCU');
		$sheet->setCellValue('AD1', 'Total');

		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul($date, $opsi)->result();
		}
				
		$no = 1;
		$x = 2;
				
		foreach($hasil as $value){
			$sheet->setCellValue('A'.$x, $value->dokter);
			$sheet->setCellValue('B'.$x, $value->igd);
			$sheet->setCellValue('C'.$x, $value->kandungan);
			$sheet->setCellValue('D'.$x, $value->umum);
			$sheet->setCellValue('E'.$x, $value->umum24);
			$sheet->setCellValue('F'.$x, $value->interne);
			$sheet->setCellValue('G'.$x, $value->saraf);
			$sheet->setCellValue('H'.$x, $value->anak);
			$sheet->setCellValue('I'.$x, $value->mcu);
			$sheet->setCellValue('J'.$x, $value->paru);
			$sheet->setCellValue('K'.$x, $value->fungsi_luhur);
			$sheet->setCellValue('L'.$x, $value->rehab_medik);
			$sheet->setCellValue('M'.$x, $value->bedah);
			$sheet->setCellValue('N'.$x, $value->bedah_syaraf);
			$sheet->setCellValue('O'.$x, $value->anestesi);
			$sheet->setCellValue('P'.$x, $value->vaksin);
			$sheet->setCellValue('Q'.$x, $value->terapi_wicara);
			$sheet->setCellValue('R'.$x, $value->gizi);
			$sheet->setCellValue('S'.$x, $value->gigi);
			$sheet->setCellValue('T'.$x, $value->neuropsikiatri);
			$sheet->setCellValue('U'.$x, $value->tht);
			$sheet->setCellValue('V'.$x, $value->akupuntur);
			$sheet->setCellValue('W'.$x, $value->fisioterapi);
			$sheet->setCellValue('X'.$x, $value->ortetik);
			$sheet->setCellValue('Y'.$x, $value->okupasi);
			$sheet->setCellValue('Z'.$x, $value->neurointervensi);
			$sheet->setCellValue('AA'.$x, $value->mata);
			$sheet->setCellValue('AB'.$x, $value->jantung);
			$sheet->setCellValue('AC'.$x, $value->scu);
			$sheet->setCellValue('AD'.$x, $value->igd + $value->kandungan + $value->umum + $value->umum24 + $value->interne + $value->saraf + $value->anak + $value->mcu + $value->paru + $value->fungsi_luhur + $value->rehab_medik + $value->bedah + $value->bedah_syaraf + $value->anestesi + $value->vaksin + $value->terapi_wicara + $value->gizi + $value->gigi + $value->neuropsikiatri + $value->tht + $value->fisioterapi + $value->akupuntur + $value->ortetik + $value->okupasi + $value->neurointervensi + $value->mata + $value->jantung + $value->scu);
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah '.$ppa_sbg.' Rawat Jalan '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function  excel_lap_dpjp_utama_tgl($date, $opsi) {
		$tgl = date("d F Y", strtotime($date));
		if($opsi == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if($opsi == 'rawat_bersama') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
				
		$sheet->setCellValue('A1', 'Nama DPJP');
		$sheet->setCellValue('B1', 'IGD');
		$sheet->setCellValue('C1', 'Kebidanan/Kandungan');
		$sheet->setCellValue('D1', 'UMUM');
		$sheet->setCellValue('E1', 'UMUM 24 Jam');
		$sheet->setCellValue('F1', 'Penyakit Dalam(INTERNE)');
		$sheet->setCellValue('G1', 'Saraf(NEUROLOGI)');
		$sheet->setCellValue('H1', 'Anak');
		$sheet->setCellValue('I1', 'MCU');
		$sheet->setCellValue('J1', 'Paru');
		$sheet->setCellValue('K1', 'Fungsi Luhur');
		$sheet->setCellValue('L1', 'Rehab Medik');
		$sheet->setCellValue('M1', 'Bedah');
		$sheet->setCellValue('N1', 'Bedah Syaraf');
		$sheet->setCellValue('O1', 'Anestesi');
		$sheet->setCellValue('P1', 'Poli Vaksin');
		$sheet->setCellValue('Q1', 'Terapi Wicara');
		$sheet->setCellValue('R1', 'Gizi');
		$sheet->setCellValue('S1', 'Gigi dan Mulut');
		$sheet->setCellValue('T1', 'Neuropsikiatri');
		$sheet->setCellValue('U1', 'THT');
		$sheet->setCellValue('V1', 'Akupuntur');
		$sheet->setCellValue('W1', 'Fisioterapi');
		$sheet->setCellValue('X1', 'Ortetik Prostetik');
		$sheet->setCellValue('Y1', 'Okupasi Terapi');
		$sheet->setCellValue('Z1', 'Neurointervensi');
		$sheet->setCellValue('AA1', 'Mata');
		$sheet->setCellValue('AB1', 'Jantung dan Pembuluh Darah');
		$sheet->setCellValue('AC1', 'SCU');
		$sheet->setCellValue('AD1', 'Total');

		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_tgl($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_tgl($date, $opsi)->result();
		}
				
		$no = 1;
		$x = 2;
				
		foreach($hasil as $value){
			$sheet->setCellValue('A'.$x, $value->dokter);
			$sheet->setCellValue('B'.$x, $value->igd);
			$sheet->setCellValue('C'.$x, $value->kandungan);
			$sheet->setCellValue('D'.$x, $value->umum);
			$sheet->setCellValue('E'.$x, $value->umum24);
			$sheet->setCellValue('F'.$x, $value->interne);
			$sheet->setCellValue('G'.$x, $value->saraf);
			$sheet->setCellValue('H'.$x, $value->anak);
			$sheet->setCellValue('I'.$x, $value->mcu);
			$sheet->setCellValue('J'.$x, $value->paru);
			$sheet->setCellValue('K'.$x, $value->fungsi_luhur);
			$sheet->setCellValue('L'.$x, $value->rehab_medik);
			$sheet->setCellValue('M'.$x, $value->bedah);
			$sheet->setCellValue('N'.$x, $value->bedah_syaraf);
			$sheet->setCellValue('O'.$x, $value->anestesi);
			$sheet->setCellValue('P'.$x, $value->vaksin);
			$sheet->setCellValue('Q'.$x, $value->terapi_wicara);
			$sheet->setCellValue('R'.$x, $value->gizi);
			$sheet->setCellValue('S'.$x, $value->gigi);
			$sheet->setCellValue('T'.$x, $value->neuropsikiatri);
			$sheet->setCellValue('U'.$x, $value->tht);
			$sheet->setCellValue('V'.$x, $value->akupuntur);
			$sheet->setCellValue('W'.$x, $value->fisioterapi);
			$sheet->setCellValue('X'.$x, $value->ortetik);
			$sheet->setCellValue('Y'.$x, $value->okupasi);
			$sheet->setCellValue('Z'.$x, $value->neurointervensi);
			$sheet->setCellValue('AA'.$x, $value->mata);
			$sheet->setCellValue('AB'.$x, $value->jantung);
			$sheet->setCellValue('AC'.$x, $value->scu);
			$sheet->setCellValue('AD'.$x, $value->igd + $value->kandungan + $value->umum + $value->umum24 + $value->interne + $value->saraf + $value->anak + $value->mcu + $value->paru + $value->fungsi_luhur + $value->rehab_medik + $value->bedah + $value->bedah_syaraf + $value->anestesi + $value->vaksin + $value->terapi_wicara + $value->gizi + $value->gigi + $value->neuropsikiatri + $value->tht + $value->fisioterapi + $value->akupuntur + $value->ortetik + $value->okupasi + $value->neurointervensi + $value->mata + $value->jantung + $value->scu);
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah '.$ppa_sbg.' Rawat Jalan '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_dpjp_utama_eksekutif() {
		$data['title'] = 'Laporan DPJP Utama Rawat Jalan Poli Eksekutif';
		$this->load->view('irj/lapdpjp_utama_eksekutif', $data);
	}

	public function lap_dpjp_exekutif($date, $opsi) {
		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_eksekutif($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_eksekutif($date, $opsi)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['dokter'] = $value->dokter;
			$row2['mata'] = $value->mata;
			$row2['gigi'] = $value->gigi;
			$row2['interne'] = $value->interne;
			$row2['paru'] = $value->paru;
			$row2['anak'] = $value->anak;
			$row2['fungsi_luhur'] = $value->fungsi_luhur;
			$row2['umum'] = $value->umum;
			$row2['umum24'] = $value->umum24;
			$row2['bedah'] = $value->bedah;
			$row2['bedah_syaraf'] = $value->bedah_syaraf;
			$row2['gizi'] = $value->gizi;
			$row2['jantung'] = $value->jantung;
			$row2['ortetik'] = $value->ortetik;
			$row2['fisioterapi'] = $value->fisioterapi;
			$row2['okupasi'] = $value->okupasi;
			$row2['terapi_wicara'] = $value->terapi_wicara;
			$row2['saraf'] = $value->saraf;
			$row2['neurointervensi'] = $value->neurointervensi;
			$row2['neuropsikiatri'] = $value->neuropsikiatri;
			$row2['mcu'] = $value->mcu;
			$row2['vaksin'] = $value->vaksin;
			$row2['total'] = $value->mata + $value->gigi + $value->interne + $value->paru + $value->anak + $value->fungsi_luhur + $value->umum + $value->umum24 +  $value->bedah +  $value->bedah_syaraf +  $value->gizi +  $value->jantung +  $value->ortetik +  $value->fisioterapi +  $value->okupasi +  $value->terapi_wicara +  $value->saraf +  $value->neuropsikiatri +  $value->neurointervensi +  $value->mcu +  $value->vaksin;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function lap_dpjp_exekutif_tgl($date, $opsi) {
		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_eksekutif_tgl($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_eksekutif_tgl($date, $opsi)->result();
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['dokter'] = $value->dokter;
			$row2['mata'] = $value->mata;
			$row2['gigi'] = $value->gigi;
			$row2['interne'] = $value->interne;
			$row2['paru'] = $value->paru;
			$row2['anak'] = $value->anak;
			$row2['fungsi_luhur'] = $value->fungsi_luhur;
			$row2['umum'] = $value->umum;
			$row2['umum24'] = $value->umum24;
			$row2['bedah'] = $value->bedah;
			$row2['bedah_syaraf'] = $value->bedah_syaraf;
			$row2['gizi'] = $value->gizi;
			$row2['jantung'] = $value->jantung;
			$row2['ortetik'] = $value->ortetik;
			$row2['fisioterapi'] = $value->fisioterapi;
			$row2['okupasi'] = $value->okupasi;
			$row2['terapi_wicara'] = $value->terapi_wicara;
			$row2['saraf'] = $value->saraf;
			$row2['neurointervensi'] = $value->neurointervensi;
			$row2['neuropsikiatri'] = $value->neuropsikiatri;
			$row2['mcu'] = $value->mcu;
			$row2['vaksin'] = $value->vaksin;
			$row2['total'] = $value->mata + $value->gigi + $value->interne + $value->paru + $value->anak + $value->fungsi_luhur + $value->umum + $value->umum24 +  $value->bedah +  $value->bedah_syaraf +  $value->gizi +  $value->jantung +  $value->ortetik +  $value->fisioterapi +  $value->okupasi +  $value->terapi_wicara +  $value->saraf +  $value->neuropsikiatri +  $value->neurointervensi +  $value->mcu +  $value->vaksin;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_dpjp_utama_eksekutif($date, $opsi) {
		$tgl = date("F Y", strtotime($date));
		if($opsi == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if($opsi == 'rawat_bersama') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
				
		$sheet->setCellValue('A1', 'Nama DPJP');
		$sheet->setCellValue('B1', 'Mata Eksekutif');
		$sheet->setCellValue('C1', 'Gigi dan Mulut Eksekutif');
		$sheet->setCellValue('D1', 'Penyakit Dalam(INTERNE) Eksekutif');
		$sheet->setCellValue('E1', 'Paru Eksekutif');
		$sheet->setCellValue('F1', 'Anak Eksekutif');
		$sheet->setCellValue('G1', 'Fungsi Luhur Eksekutif');
		$sheet->setCellValue('H1', 'Umum Eksekutif');
		$sheet->setCellValue('I1', 'Umum 24 Jam Eksekutif');
		$sheet->setCellValue('J1', 'Bedah Umum Eksekutif');
		$sheet->setCellValue('K1', 'Bedah Syaraf Eksekutif');
		$sheet->setCellValue('L1', 'Gizi Eksekutif');
		$sheet->setCellValue('M1', 'Jantung Eksekutif');
		$sheet->setCellValue('N1', 'Ortetik Prostetik Eksekutif');
		$sheet->setCellValue('O1', 'Fisioterapi Eksekutif');
		$sheet->setCellValue('P1', 'Okupasi Terapi Eksekutif');
		$sheet->setCellValue('Q1', 'Terapi Wicara Eksekutif');
		$sheet->setCellValue('R1', 'Saraf(NEUROLOGI) Eksekutif');
		$sheet->setCellValue('S1', 'Neurointervensi Eksekutif');
		$sheet->setCellValue('T1', 'Neuropsikiatri Eksekutif');
		$sheet->setCellValue('U1', 'MCU Eksekutif');
		$sheet->setCellValue('V1', 'Vaksin Eksekutif');
		$sheet->setCellValue('W1', 'Total');

		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_eksekutif($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_eksekutif($date, $opsi)->result();
		}
				
		$no = 1;
		$x = 2;
				
		foreach($hasil as $value){
			$sheet->setCellValue('A'.$x, $value->dokter);
			$sheet->setCellValue('B'.$x, $value->mata);
			$sheet->setCellValue('C'.$x, $value->gigi);
			$sheet->setCellValue('D'.$x, $value->interne);
			$sheet->setCellValue('E'.$x, $value->paru);
			$sheet->setCellValue('F'.$x, $value->anak);
			$sheet->setCellValue('G'.$x, $value->fungsi_luhur);
			$sheet->setCellValue('H'.$x, $value->umum);
			$sheet->setCellValue('I'.$x, $value->umum24);
			$sheet->setCellValue('J'.$x, $value->bedah);
			$sheet->setCellValue('K'.$x, $value->bedah_syaraf);
			$sheet->setCellValue('L'.$x, $value->gizi);
			$sheet->setCellValue('M'.$x, $value->jantung);
			$sheet->setCellValue('N'.$x, $value->ortetik);
			$sheet->setCellValue('O'.$x, $value->fisioterapi);
			$sheet->setCellValue('P'.$x, $value->okupasi);
			$sheet->setCellValue('Q'.$x, $value->terapi_wicara);
			$sheet->setCellValue('R'.$x, $value->saraf);
			$sheet->setCellValue('S'.$x, $value->neurointervensi);
			$sheet->setCellValue('T'.$x, $value->neuropsikiatri);
			$sheet->setCellValue('U'.$x, $value->mcu);
			$sheet->setCellValue('V'.$x, $value->vaksin);
			$sheet->setCellValue('W'.$x, $value->mata + $value->gigi + $value->interne + $value->paru + $value->anak + $value->fungsi_luhur + $value->umum + $value->umum24 +  $value->bedah +  $value->bedah_syaraf +  $value->gizi +  $value->jantung +  $value->ortetik +  $value->fisioterapi +  $value->okupasi +  $value->terapi_wicara +  $value->saraf +  $value->neuropsikiatri +  $value->neurointervensi +  $value->mcu +  $value->vaksin);
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah '.$ppa_sbg.' Rawat Jalan Eksekutif '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_dpjp_utama_eksekutif_tgl($date, $opsi) {
		$tgl = date("d F Y", strtotime($date));
		if($opsi == 'dpjp') {
			$ppa_sbg = 'Konsul DPJP';
		} else if($opsi == 'rawat_bersama') {
			$ppa_sbg = 'Konsul Rawat Bersama';
		} else {
			$ppa_sbg = 'Konsul Sekali';
		}
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
				
		$sheet->setCellValue('A1', 'Nama DPJP');
		$sheet->setCellValue('B1', 'Mata Eksekutif');
		$sheet->setCellValue('C1', 'Gigi dan Mulut Eksekutif');
		$sheet->setCellValue('D1', 'Penyakit Dalam(INTERNE) Eksekutif');
		$sheet->setCellValue('E1', 'Paru Eksekutif');
		$sheet->setCellValue('F1', 'Anak Eksekutif');
		$sheet->setCellValue('G1', 'Fungsi Luhur Eksekutif');
		$sheet->setCellValue('H1', 'Umum Eksekutif');
		$sheet->setCellValue('I1', 'Umum 24 Jam Eksekutif');
		$sheet->setCellValue('J1', 'Bedah Umum Eksekutif');
		$sheet->setCellValue('K1', 'Bedah Syaraf Eksekutif');
		$sheet->setCellValue('L1', 'Gizi Eksekutif');
		$sheet->setCellValue('M1', 'Jantung Eksekutif');
		$sheet->setCellValue('N1', 'Ortetik Prostetik Eksekutif');
		$sheet->setCellValue('O1', 'Fisioterapi Eksekutif');
		$sheet->setCellValue('P1', 'Okupasi Terapi Eksekutif');
		$sheet->setCellValue('Q1', 'Terapi Wicara Eksekutif');
		$sheet->setCellValue('R1', 'Saraf(NEUROLOGI) Eksekutif');
		$sheet->setCellValue('S1', 'Neurointervensi Eksekutif');
		$sheet->setCellValue('T1', 'Neuropsikiatri Eksekutif');
		$sheet->setCellValue('U1', 'MCU Eksekutif');
		$sheet->setCellValue('V1', 'Vaksin Eksekutif');
		$sheet->setCellValue('W1', 'Total');

		if($opsi == 'dpjp') {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_utama_eksekutif_tgl($date)->result();
		} else {
			$hasil = $this->Rjmlaporan->get_lap_dpjp_konsul_eksekutif_tgl($date, $opsi)->result();
		}
				
		$no = 1;
		$x = 2;
				
		foreach($hasil as $value){
			$sheet->setCellValue('A'.$x, $value->dokter);
			$sheet->setCellValue('B'.$x, $value->mata);
			$sheet->setCellValue('C'.$x, $value->gigi);
			$sheet->setCellValue('D'.$x, $value->interne);
			$sheet->setCellValue('E'.$x, $value->paru);
			$sheet->setCellValue('F'.$x, $value->anak);
			$sheet->setCellValue('G'.$x, $value->fungsi_luhur);
			$sheet->setCellValue('H'.$x, $value->umum);
			$sheet->setCellValue('I'.$x, $value->umum24);
			$sheet->setCellValue('J'.$x, $value->bedah);
			$sheet->setCellValue('K'.$x, $value->bedah_syaraf);
			$sheet->setCellValue('L'.$x, $value->gizi);
			$sheet->setCellValue('M'.$x, $value->jantung);
			$sheet->setCellValue('N'.$x, $value->ortetik);
			$sheet->setCellValue('O'.$x, $value->fisioterapi);
			$sheet->setCellValue('P'.$x, $value->okupasi);
			$sheet->setCellValue('Q'.$x, $value->terapi_wicara);
			$sheet->setCellValue('R'.$x, $value->saraf);
			$sheet->setCellValue('S'.$x, $value->neurointervensi);
			$sheet->setCellValue('T'.$x, $value->neuropsikiatri);
			$sheet->setCellValue('U'.$x, $value->mcu);
			$sheet->setCellValue('V'.$x, $value->vaksin);
			$sheet->setCellValue('W'.$x, $value->mata + $value->gigi + $value->interne + $value->paru + $value->anak + $value->fungsi_luhur + $value->umum + $value->umum24 +  $value->bedah +  $value->bedah_syaraf +  $value->gizi +  $value->jantung +  $value->ortetik +  $value->fisioterapi +  $value->okupasi +  $value->terapi_wicara +  $value->saraf +  $value->neuropsikiatri +  $value->neurointervensi +  $value->mcu +  $value->vaksin);
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah '.$ppa_sbg.' Rawat Jalan Eksekutif '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_jenis_pasien() {
		$data['title'] = 'Laporan Jenis Pasien';
		$this->load->view('irj/rjvlap_jenis_pasien', $data);
	}

	public function lap_jenis_pasien_exe($date, $tampil) {
		$hasil = $this->Rjmlaporan->get_jenis_kunj_pasien($date, $tampil)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;

		foreach($hasil as $value) {
			$row2['kode_rs'] = '1375036';
			$row2['nama_rs'] = 'RSOMH Bukittinggi';
			$row2['bulan'] = date("F", strtotime($value->tgl));
			$row2['tahun'] = date("Y", strtotime($value->tgl));
			$row2['kab'] = 'Bukittinggi';
			$row2['prop'] = '13 Prop';
			$row2['no'] = $i++;
			$row2['jenis'] = $value->jenis;
			$row2['jml'] = $value->jml;
			$line2[] = $row2;
		}

		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_jenis_pasien($date, $tampil) {
		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
				
		$sheet->setCellValue('A1', 'Kode RS');
		$sheet->setCellValue('B1', 'Nama RS');
		$sheet->setCellValue('C1', 'Bulan');
		$sheet->setCellValue('D1', 'Tahun');
		$sheet->setCellValue('E1', 'Kab/Kota');
		$sheet->setCellValue('F1', 'Kode Provinsi');
		$sheet->setCellValue('G1', 'No');
		$sheet->setCellValue('H1', 'Jenis Kegiatan');
		$sheet->setCellValue('I1', 'Jumlah');

		$hasil = $this->Rjmlaporan->get_jenis_kunj_pasien($date, $tampil)->result();
				
		$no = 1;
		$x = 2;
				
		foreach($hasil as $value){
			$sheet->setCellValue('A'.$x, '1375036');
			$sheet->setCellValue('B'.$x, 'Bukittinggi');
			$sheet->setCellValue('C'.$x, date("F", strtotime($value->tgl)));
			$sheet->setCellValue('D'.$x, date("Y", strtotime($value->tgl)));
			$sheet->setCellValue('E'.$x, 'Bukittinggi');
			$sheet->setCellValue('F'.$x, '13 Prop');
			$sheet->setCellValue('G'.$x, $no++);
			$sheet->setCellValue('H'.$x, $value->jenis);
			$sheet->setCellValue('I'.$x, $value->jml);
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah RL 5.1 '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function list_rekap() {
		$data['title'] = 'List Rekap Pasien Rawat Jalan';

		$date = $this->input->post('date_picker_days');

		if($date == '') {
			$tgl = date("Y-m-d");
			$data['list_rekap'] = $this->Rjmlaporan->get_data_list_pasien_rekap($tgl)->result();
		} else {
			$data['list_rekap'] = $this->Rjmlaporan->get_data_list_pasien_rekap($date)->result();
		}
		$this->load->view('irj/list_rekap_pasien', $data);
	}

	public function cetak_rekap_pasien($no_register) {
		$data_pasien = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();

		$list_tindakan_ird = $this->Rjmlaporan->get_list_tindakan_ird_rekap($no_register)->result();
		$list_ok_ird = $this->rimpasien->get_list_ok_ird_rekap($no_register)->result();
		$list_em_ird = $this->Rjmlaporan->get_list_em_ird_rekap($no_register)->result();
		$list_rad_ird = $this->Rjmlaporan->get_list_rad_ird_rekap($no_register)->result();
		$list_lab_ird = $this->Rjmlaporan->get_list_lab_ird_rekap($no_register)->result();
		$list_resep_ird = $this->rimpasien->get_list_resep_iri_rekap($no_register)->result();

		$konten = "";
		$konten0 = "";

		$konten0 = $konten0.'<style type=\"text/css\">	
			.table-isi th{
				border-bottom: 1px solid #ddd;
			}
			.table-isi td{
				border-bottom: 1px solid #ddd;
			}
		</style>';
			
		$konten = $konten.'<br/>';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount= 0;
		$ceknull=0;
		$jasa_total=0;

		$konten = $konten."		
			<table class=\"table-isi\" border=\"0\">
				<tr>
					<td colspan=\"8\"><b>List Rekap</b></td>
				</tr>
			</table><br/>";

		//tindakan
		// var_dump($);die();
		if(($list_tindakan_ird)){
			$result = $this->string_table_tindakan_ird_faktur_rekap($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}

		$vtotrad=0;
		if(($list_rad_ird)){
			$result = $this->string_table_radiologi_ird_rekap($list_rad_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			$vtotrad=$result['subtotal'];
		}

		$vtotem=0;
		if(($list_em_ird)){
			$result = $this->string_table_elektromedik_ird_rekap($list_em_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			$vtotem=$result['subtotal'];
		}

		$vtotok =0;
		if(($list_ok_ird)){
			$result = $this->string_table_operasi_ird_rekap($list_ok_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			$vtotok=$result['subtotal'];
		}

		$vtotlab=0;
		if(($list_lab_ird)){
			$result = $this->string_table_lab_ird_rekap($list_lab_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			
			$vtotlab=$result['subtotal'];
			// $konten = $konten.$result['konten'];
		}

		// $vtotresep=0;
		// if(($list_resep_ird)){
		// 	$result = $this->string_table_resep_rekap($list_resep_ird);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];	
		// }

		$konten = $konten."
			<table class=\"table-isi\" style=\"width: 100%;\" width=\"100%\">";

		$konten0 = $this->string_data_pasien_sementara($data_pasien,$grand_total,"",'').$konten0;
		$konten = $konten0.$konten;
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->name);
		$span='6';
		$span1='2';

		$grand_total_string = "	
			<tr>
				<th colspan=\"".$span."\" align=\"left\"><p><b>Total</b></p></th>
				<th align=\"right\" colspan=\"".$span1."\"><p>".number_format($grand_total)."</p></th>
			</tr>
		</table>
		<br/><br>
		<table style=\"width: 100%;\" width=\"100%\">
			<tr>
				<td style=\"width: 50%;\"></td>
				<td style=\"width: 50%;\" align=\"center\">Bukittinggi, $tgl</td>
			</tr>
			<tr>
				<td align=\"center\">Pasien</td>
				<td align=\"center\">$user</td>
			</tr>
		</table>";

		$konten = $konten.$grand_total_string;
		ob_clean();
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		
		$html = $konten;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}

	private function string_table_tindakan_ird_faktur_rekap($list_tindakan_pasien) {
		$konten = "";
		
		$konten= $konten.'
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			   <td align="left">Tindakan</td>
			   <td align="center">Qty</td>
			  <td align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		
			foreach ($list_tindakan_pasien as $r) {				
				$subtotal += $r->total; 	
				$konten = $konten. "
				<tr>
					<td align=\"left\">".$r->nmtindakan."</td>
					<td align=\"center\">".$r->qty."</td>
					<td align=\"right\">".number_format($r->total)."</td>
				</tr>
				";			
			}
			
			$konten = $konten.'				
				<tr style="font-weight:bold;">
					<td colspan="2" align="left">Total</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					);
		return $result;
	}

	private function string_table_radiologi_ird_rekap($list_rad_ird) {
		$konten = "";
		$konten= $konten.'
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Radiologi</td>
				<td align="center">qty</td>
				<td align="right">Total</td>
			</tr>
			';
	
			$subtotal = 0;
			foreach ($list_rad_ird as $r) {
				$subtotal += $r->total_rekap;
				$konten = $konten. "
				<tr>
					<td align=\"left\">".$r->jenis_tindakan."</td>
					<td align=\"center\">".$r->qtx."</td>
					<td align=\"right\">".intval($r->total_rekap)."</td>
				</tr>
				";
			}
	
		$konten = $konten.'
				<tr style="font-weight:bold;">
					<td colspan="2" align="left">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$konten = $konten."</table><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_elektromedik_ird_rekap($list_em_ird) {
		$konten = "";
		$konten= $konten.'
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Elektromedik</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';
			
			$subtotal = 0;
			foreach ($list_em_ird as $r) {
				$subtotal += $r->total_rekap;
				$konten = $konten. "
				<tr>
					<td align=\"left\">".$r->jenis_tindakan."</td>
					<td align=\"center\">".$r->qtx."</td>
					<td align=\"right\">".number_format($r->total_rekap)."</td>
				</tr>
				";
			}
	
		$konten = $konten.'
				<tr style="font-weight:bold;">
					<td colspan="2" align="left">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$konten = $konten."</table> <br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_operasi_ird_rekap($list_ok_ird) {
		$konten = "";
	
		$konten= $konten.'
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td align="left">Jenis Tind Operasi</td>
				<td align="center">Qty</td>
				<td align="right">Total</td>
			</tr>
			';
			
			$subtotal = 0;
			foreach ($list_ok_ird as $r) {
				$subtotal += $r->total_rekap;
				$konten = $konten. "
				<tr>
					<td>".$r->jenis_tindakan."</td>
					<td align=\"center\">".$r->qtx."</td>
					<td align=\"right\">".number_format($r->total_rekap)."</td>
				</tr>
				";
			}
	
		$konten = $konten.'
				<tr style="font-weight:bold;">
					<td colspan="2" align="left">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_ird_rekap($list_lab_ird) {
		$konten = "";
	
		$konten= $konten.'		
			<table class="table-isi" border="0" style="width: 100%;" width="100%">
			<tr style="font-weight:bold;">
				<td width="35%">Jenis Tind Laboratorium</td>
				  <td width="30%">Qty</td>
				  <td align="right" width="10%">Total</td>
			</tr>
			';
			$subtotal = 0;
			foreach ($list_lab_ird as $r) {
				$subtotal += $r->total_rekap;
				$konten = $konten. "
				<tr>
				<td>".$r->jenis_tindakan."</td>
				<td>".$r->qtx."</td>
				<td align=\"right\">".number_format($r->total_rekap)."</td>
			</tr>
				";
			}
	
		$konten = $konten.'
				<tr style="font-weight:bold;">
					<td colspan="2" align="left">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br>";
		//</table>
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	} 

	private function string_table_resep_rekap($list_resep) {
		$konten = "";
		//<table border="1">
		$konten= $konten.'
		<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="5" align="left">Resep (Nama Obat)</td>
			<td align="center">Qty</td>
			<td align="right">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal += $r->total_rekap;
			$konten = $konten. "
			<tr>
			<td colspan=\"5\" align=\"left\">".strtoupper($r->nama_obat)."</td>
			<td align=\"center\">".$r->quantiti."</td>
			<td align=\"right\">".number_format($r->total_rekap)."</td>
		</tr>
			";
		}
		// $total_biaya=$subtotal;
		// $tot1 = $total_biaya;
		// $tot2 = substr($tot1, - 3);
		// if ($tot2 % 1000 != 0){
		// 	$mod = $tot2 % 1000;
		// 	$tot1 = $tot1 - $mod;
		// 	$tot1 = $tot1 + 1000; 
		// }
		
		//$subtotal=$tot1;
		$konten = $konten.'
				<tr style="font-weight:bold;">
					<td colspan="6" align="left">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br>";
		//</table>
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_data_pasien_sementara($pasien,$grand_total,$penerima,$jenis_pembayaran){

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
	
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");
		$tgl_keluar = isset($pasien->tgl_kunjungan)?date("d-m-Y", strtotime($pasien->tgl_kunjungan)):'';
		//var_dump($tgl_keluar);die();
		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
	
	
		//tanda terima
		$penyetor = $penerima;
	
	
		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);
	
		$konten = "";
	
		$interval = date_diff(date_create(), date_create($pasien->tgl_lahir));
	
		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}
	
		//print_r($detail_bayar);
		$txtperusahaan='';
		if($pasien->cara_bayar=='DIJAMIN' || $pasien->cara_bayar=='BPJS' || $pasien->cara_bayar == 'KERJASAMA')
			{
				$kontraktor=$this->rimlaporan->getdata_perusahaan_irj($pasien->no_register)->row();
				//if($kontraktor!=''){
					$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
				//}				
			}
	
			$header_page = $top_header."<p align=\"center\">
											<img src=\"assets/img/".$logo_kesehatan_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>
									</td>
									<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
										<font style=\"font-size:12px\">
											<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
										</font>
										<font style=\"font-size:11px\">
											<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
											<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
										</font>    
										<br>
										<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
										<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
									</td>
									<td width=\"13%\">
										<p align=\"center\">
											<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
										</p>".$bottom_header;	
		$konten = $konten."<style type=\"text/css\">
					table tr td{
						font-size:14px;
						}
					.table-font-size1{
						font-size:8px;
						}
					</style>
					
	
					<p style=\"font-size: 12px;\" size=\"6\" align=\"right\"></p><br>
					$header_page
					<hr>
					
					<table style=\"width: 100%;\" width=\"100%\">			
						<tr>
							<td colspan=\"6\" style=\"\">
								<p size=\"11\" ><u><b>RINCIAN BIAYA RAWAT JALAN NO ".$pasien->no_register."</b></u></p>
							</td>
						</tr>			
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($pasien->nama)."</td>
								<td width=\"20%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien->nama)."</td>
								<td ><b>No Register</b></td>
								<td > : </td>
								<td>".strtoupper($pasien->no_register)."</td>
							</tr>
							<tr>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($pasien->no_cm)."</td>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Thn")."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien->cara_bayar)."</td>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien->alamat)."</td>															
							</tr>
							<tr>
								<td ><b>Tujuan</b></td>
								<td > : </td>
								<td>".strtoupper($pasien->nm_poli)."</td>
								$txtperusahaan	
							</tr>
					</table>";
	
		return $konten;
	}

	/**
	 * Added @aldi
	 * Pembuatan Laporan Pendaftaran Lewat APM
	 * Pembuatan Laporan Daftar Ulang Lewat APM
	 */

	public function laporan_apm()
	{
		$this->load->view('irj/laporan_apm',[
			'title'=>'Laporan Pendaftaran Anjungan Pendaftaran Mandiri'
		]);
	}

	public function laporan_apm_data()
	{
		header('Content-Type: application/json; charset=utf-8');
		$pencarian = $this->input->get('pencarian');
		$datapencarian = $this->input->get('data');
		$data = $this->Rjmlaporan->pencarian_pasien_baru_total_apm($pencarian,$datapencarian)->result();
		echo json_encode($data);
	}

	public function laporan_apm_data_poli()
	{
		header('Content-Type: application/json; charset=utf-8');
		$pencarian = $this->input->get('pencarian');
		$datapencarian = $this->input->get('data');
		$data = $this->Rjmlaporan->pencarian_pasien_poliklinik_total_apm($pencarian,$datapencarian)->result();
		echo json_encode($data);
	}

	public function laporan_apm_data_detail()
	{
		header('Content-Type: application/json; charset=utf-8');
		$datapencarian = $this->input->get('data');
		$data = $this->Rjmlaporan->pencarian_pasien_baru_apm($datapencarian)->result();
		echo json_encode($data);
	}

	public function laporan_apm_data_detail_poli()
	{
		header('Content-Type: application/json; charset=utf-8');
		$datapencarian = $this->input->get('data');
		$data = $this->Rjmlaporan->pencarian_pasien_poli_apm($datapencarian)->result();
		// var_dump($data);
		echo json_encode($data);
	}

	public function excel_laporan_apm_poli($data)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();


		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tgl Kunjungan');
		$sheet->setCellValue('C1', 'No. Rekam Medis');

		$data = $this->Rjmlaporan->pencarian_pasien_baru_apm_poli($data,TRUE)->result();
		// var_dump($data);die();
		$index = 2;
		foreach($data as $val){
			$sheet->setCellValue('A'.$index,$index);
			$sheet->setCellValue('B'.$index,date('d-m-Y',strtotime($val->tgl_kunjungan)));
			$sheet->setCellValue('C'.$index,$val->no_medrec);
			$index++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pendaftaran Poliklinik Anjungan Pendaftaran Mandiri ';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	

	public function excel_laporan_apm($data)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();


		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tgl Daftar');
		$sheet->setCellValue('C1', 'No. Rekam Medis');
		$sheet->setCellValue('D1', 'Nama');

		$data = $this->Rjmlaporan->pencarian_pasien_baru_apm($data,TRUE)->result();
		$index = 2;
		foreach($data as $val){
			$sheet->setCellValue('A'.$index,$index);
			$sheet->setCellValue('B'.$index,date('d-m-Y',strtotime($val->tgl_daftar)));
			$sheet->setCellValue('C'.$index,$val->no_cm);
			$sheet->setCellValue('D'.$index,$val->nama);
			$index++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pendaftaran Pasien Baru Anjungan Pendaftaran Mandiri ';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	// End Added @aldi

	public function input_realisasi_tindakan() {
		$data['title'] = 'Input Realisasi Tindakan Rawat Jalan/IGD';

		$date1 = $this->input->post('date_picker_months1');
		$date2 = $this->input->post('date_picker_months2');

		// if($date1 == '' || $date2 == '') {
		// 	$tgl1 = date("Y-m-d");
		// 	$tgl2 = date("Y-m-d");
		// 	$data['list_umbal'] = $this->Rjmlaporan->get_pasien_input_realisasi_tindakan($tgl1, $tgl2)->result();
		// } else {
			$data['list_umbal'] = $this->Rjmlaporan->get_pasien_input_realisasi_tindakan($date1, $date2)->result();
		//}
		$this->load->view('irj/list_umbal', $data);
	}

	public function form_input($no_register) {
		$data['title'] = 'Input Realisasi Tindakan Rawat Jalan/IGD';
		$data['no_register'] = $no_register;
		$data['data_pasien'] = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();
		$data['tindakan'] = $this->Rjmlaporan->get_tindakan_umbal($no_register)->result();
		$data['resep'] = $this->Rjmlaporan->get_resep_umbal_pasien($no_register)->result();
		$this->load->view('irj/form_umbal', $data);
	}

	public function get_total_tindakan_pasien() {
		$no_register = $this->input->post('no_register');

		$datajson=$this->Rjmlaporan->get_total_tindakan_pasien($no_register)->row();
	    echo json_encode($datajson);
	}

	public function insert_total_tindakan_pasien() {
		$no_register = $this->input->post('noreg_hide');
		$login_data = $this->load->get_var("user_info");
		$data_pasien = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();

		$datot['no_register'] = $no_register;
		$datot['volume'] = $this->input->post('vol_umum');
		$datot['vtot'] = $this->input->post('tarif_umum');
		$datot['carabayar'] = $data_pasien->cara_bayar;
		$datot['xcreate'] = date("Y-m-d H:i:s");
		$datot['xinput'] = $login_data->userid;
		$datot['tgl_keluar_resume'] = date("Y-m-d", strtotime($data_pasien->tgl_kunjungan));
		$datot['id_kontraktor'] = $data_pasien->id_kontraktor;

		$cek_tindakan = $this->Rjmlaporan->get_tindakan_input_total($no_register)->result();
		$cek_obat = $this->Rjmlaporan->get_obat_input_total($no_register)->result();

		if($cek_tindakan) {
			foreach($cek_tindakan as $row) {
				$presentase = ($row->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$data['id_tindakan'] = $row->id_tindakan;
				$data['nama_tindakan'] = $row->jenis_tindakan;
				if($row->kel_tindakan == '') {
					$data['kel_tindakan'] = NULL;
				} else {
					$data['kel_tindakan'] = $row->kel_tindakan;
				}
				if($row->kategori == '') {
					$data['kategori'] = NULL;
				} else {
					$data['kategori'] = $row->kategori;
				}
				if($row->sub_kelompok == '') {
					$data['sub_kelompok'] = NULL;
				} else {
					$data['sub_kelompok'] = $row->sub_kelompok;
				}
				if($row->satuan == '') {
					$data['satuan'] = NULL;
				} else {
					$data['satuan'] = $row->satuan;
				}
				$data['carabayar'] = $data_pasien->cara_bayar;
				$data['id_kontraktor'] = $data_pasien->id_kontraktor;
				$data['volume'] = $row->qty;
				$data['xcreate'] = date("Y-m-d H:i:s");
				$data['xinput'] = $login_data->userid;
				$data['tgl_keluar_resume'] = date("Y-m-d", strtotime($data_pasien->tgl_kunjungan));
				$data['no_register'] = $no_register;
				$data['kontraktor'] = $data_pasien->nmkontraktor;
				$data['vtot'] = $tarif_tindakan;
				$data['ins'] = $row->ins;
				$data['no_medrec'] = $data_pasien->no_medrec;
				$this->Rjmlaporan->insert_detail_tindakan_pasien($data);
			}
		}

		if($cek_obat) {
			foreach($cek_obat as $r) {
				$presentase = ($r->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$obat['id_tindakan'] = $r->item_obat;
				$obat['nama_tindakan'] = $r->nama_obat;
				if($r->kel_tindakan == '') {
					$obat['kel_tindakan'] = NULL;
				} else {
					$obat['kel_tindakan'] = $r->kel_tindakan;
				}
				if($r->kategori == '') {
					$obat['kategori'] = NULL;
				} else {
					$obat['kategori'] = $r->kategori;
				}
				if($r->sub_kelompok == '') {
					$obat['sub_kelompok'] = NULL;
				} else {
					$obat['sub_kelompok'] = $r->sub_kelompok;
				}
				if($r->satuan == '') {
					$obat['satuan'] = NULL;
				} else {
					$obat['satuan'] = $r->satuan;
				}
				$obat['carabayar'] = $data_pasien->cara_bayar;
				$obat['id_kontraktor'] = $data_pasien->id_kontraktor;
				$obat['volume'] = $r->qty;
				$obat['xcreate'] = date("Y-m-d H:i:s");
				$obat['xinput'] = $login_data->userid;
				$obat['tgl_keluar_resume'] = date("Y-m-d", strtotime($data_pasien->tgl_kunjungan));
				$obat['no_register'] = $no_register;
				$obat['kontraktor'] = $data_pasien->nmkontraktor;
				$obat['vtot'] = $tarif_tindakan;
				$obat['no_medrec'] = $data_pasien->no_medrec;
				$this->Rjmlaporan->insert_detail_tindakan_pasien($obat);
			}
		}
		// var_dump($data);die();

		$this->Rjmlaporan->insert_total_tindakan_pasien($datot);
	}

	public function get_data_tindakan() {
		$no_register = $this->input->post('no_register');
		$id_tindakan = $this->input->post('id_tindakan');

		$datajson=$this->Rjmlaporan->get_data_tindakan($id_tindakan, $no_register)->row();
	    echo json_encode($datajson);
	}

	public function get_data_tindakan_obat() {
		$no_register = $this->input->post('no_register');
		$item_obat = $this->input->post('item_obat');

		$datajson=$this->Rjmlaporan->get_data_tindakan_obat($item_obat, $no_register)->row();
	    echo json_encode($datajson);
	}

	public function insert_realisasi_tindakan() {
		$no_register = $this->input->post('noreg_hide');
		// var_dump($no_register);
		$data_pasien = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idtindakan_hide');
		$data['nama_tindakan'] = $this->input->post('nmtindakan_hide');
		if($this->input->post('keltindakan_hide') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide');
		}
		
		if($this->input->post('subkelompok_hide') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide');
		}

		if($this->input->post('kategori_hide') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide');
		}

		if($this->input->post('satuan_hide') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide');
		}
		
		$data['carabayar'] = $data_pasien->cara_bayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum');
		$data['vtot'] = $this->input->post('tarif_umum');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = date("Y-m-d", strtotime($data_pasien->tgl_kunjungan));
		$data['no_register'] = $no_register;
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->Rjmlaporan->insert_realisasi_tindakan($data);
	}

	public function update_total_tindakan_pasien() {
		// var_dump($this->input->post());die();
		$no_register = $this->input->post('noreg_hide');
		$login_data = $this->load->get_var("user_info");
		$data_pasien = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();

		$datot['vtot'] = $this->input->post('tarif_umum');
		$datot['xcreate'] = date("Y-m-d H:i:s");
		$datot['xinput'] = $login_data->userid;

		$cek_tindakan = $this->Rjmlaporan->get_tindakan_input_total($no_register)->result();
		$cek_obat = $this->Rjmlaporan->get_obat_input_total($no_register)->result();

		if($cek_tindakan) {
			foreach($cek_tindakan as $row) {
				$presentase = ($row->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$data['xcreate'] = date("Y-m-d H:i:s");
				$data['xinput'] = $login_data->userid;
				$data['vtot'] = $tarif_tindakan;
				$this->Rjmlaporan->update_detail_tindakan_pasien($data, $row->id_tindakan, $no_register);
			}
		}

		if($cek_obat) {
			foreach($cek_obat as $row) {
				$presentase = ($row->total / $this->input->post('vol_umum')) * 1;
				$tarif_tindakan = round($this->input->post('tarif_umum') * $presentase);
				$data['xcreate'] = date("Y-m-d H:i:s");
				$data['xinput'] = $login_data->userid;
				$data['vtot'] = $tarif_tindakan;
				$this->Rjmlaporan->update_detail_tindakan_pasien($data, $row->item_obat, $no_register);
			}
		}

		$this->Rjmlaporan->update_total_tindakan_pasien($datot, $no_register);
	}

	public function insert_realisasi_tindakan_obat() {
		$no_register = $this->input->post('noreg_hide_obat');
		// var_dump($no_register);
		$data_pasien = $this->Rjmlaporan->get_data_pasien_rekap($no_register)->row();
		$login_data = $this->load->get_var("user_info");
		// var_dump($data_pasien);die();

		$data['id_tindakan'] = $this->input->post('idobat_hide');
		$data['nama_tindakan'] = $this->input->post('nmobat_hide');
		if($this->input->post('keltindakan_hide_obat') == '') {
			$data['kel_tindakan'] = NULL;
		} else {
			$data['kel_tindakan'] = $this->input->post('keltindakan_hide_obat');
		}
		
		if($this->input->post('subkelompok_hide_obat') == '') {
			$data['sub_kelompok'] = NULL;
		} else {
			$data['sub_kelompok'] = $this->input->post('subkelompok_hide_obat');
		}

		if($this->input->post('kategori_hide_obat') == '') {
			$data['kategori'] = NULL;
		} else {
			$data['kategori'] = $this->input->post('kategori_hide_obat');
		}

		if($this->input->post('satuan_hide_obat') == '') {
			$data['satuan'] = NULL;
		} else {
			$data['satuan'] = $this->input->post('satuan_hide_obat');
		}
		
		$data['carabayar'] = $data_pasien->cara_bayar;
		$data['kontraktor'] = $data_pasien->nmkontraktor;
		$data['volume'] = $this->input->post('vol_umum_obat');
		$data['vtot'] = $this->input->post('tarif_umum_obat');
		$data['xcreate'] = date("Y-m-d H:i:s");
		$data['xinput'] = $login_data->userid;
		$data['tgl_keluar_resume'] = date("Y-m-d", strtotime($data_pasien->tgl_kunjungan));
		$data['no_register'] = $no_register;
		$data['id_kontraktor'] = $data_pasien->id_kontraktor;

		$this->Rjmlaporan->insert_realisasi_tindakan($data);
	}

	public function lap_pasien_baru_surveilans()
	{	
		$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
		$data['tgl_awal'] = date('Y-m-d');
		$data['tgl_akhir'] = date('Y-m-d');
		$data['idrg'] = $this->input->post('idrg');
		$data['lap_pasien_baru_surveilans'] = array();
		if ($this->input->post()) {
			$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
			$data['tgl_awal'] = $this->input->post('tgl_awal');
			$data['tgl_akhir'] = $this->input->post('tgl_akhir');
			$data['idrg'] = $this->input->post('idrg');
			$data['nama_rg'] = $this->Rjmlaporan->data_ruangan_nm($data['idrg'])->row();
			$data['lap_pasien_baru_surveilans'] = $this->Rjmlaporan->lap_pasien_baru_surveilans($data['tgl_awal'],$data['tgl_akhir'],$data['idrg'])->result();
		}
		$this->load->view('irj/lap_pasienbaru_surveilans', $data);
	}

		function download_lap_pasien_baru_surveilans($tgl1,$tgl2,$idrg){
			
			$data = $this->Rjmlaporan->lap_pasien_baru_surveilans( $tgl1,$tgl2,$idrg)->result();
			//  var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Tanggal');
			$sheet->SetCellValue('B1', 'Nama');
			$sheet->SetCellValue('C1', 'Jenis Kelamin');
			$sheet->SetCellValue('D1', 'Umur');
			$sheet->SetCellValue('E1', 'Medrec'); 
			$sheet->SetCellValue('F1', 'Dokter'); 
			$sheet->SetCellValue('G1', 'ETT'); 
			$sheet->SetCellValue('H1', 'CVL');
			$sheet->SetCellValue('I1', 'Infus');
			$sheet->SetCellValue('J1', 'Kateter');
			$sheet->SetCellValue('K1', 'Tirah Baring');
			$sheet->SetCellValue('L1', 'Kultur');
			$sheet->SetCellValue('M1', 'Antibiotika');
		
			$rowCount = 2;
			foreach($data as $row){
				$data_json = json_decode($row->formjson);
				$sheet->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
				$sheet->SetCellValue('B'.$rowCount, $row->nama);
			 
				if($row->sex == 'P'){
					$jenis_kel = 'Perempuan';
				}else{
					$jenis_kel = 'Laki-Laki';
				}
                          
				$sheet->SetCellValue('C'.$rowCount,	$jenis_kel);

				$tanggal = new DateTime($row->tgl_lahir);
				$today = new DateTime('today');
				$y = $today->diff($tanggal)->y;


				$sheet->SetCellValue('D'.$rowCount, $y.' '.'Tahun');
				$sheet->SetCellValue('E'.$rowCount,	$row->no_medrec);
				$sheet->SetCellValue('F'.$rowCount, $row->dokter);

				$ett_pasang = isset($data_json->pemasangan[0]->intra4_pasang)?new DateTime($data_json->pemasangan[0]->intra4_pasang):'';
				$ett_lepas = isset($data_json->pemasangan[0]->intra4_lepas)?new DateTime($data_json->pemasangan[0]->intra4_lepas):'';
				if($ett_lepas != '' && $ett_pasang != ''){
					$hasil_ett =  $ett_lepas->diff($ett_pasang)->d;
					if($hasil_ett == 0){
						$ett = 1;
					}else{
						$ett = $hasil_ett ;
					}
				}else{
					$ett = 0; 
				}


				$sheet->SetCellValue('G'.$rowCount, $ett);

				$cvl_pasang = isset($data_json->pemasangan[0]->intra2_pasang)?new DateTime($data_json->pemasangan[0]->intra2_pasang):'';
				$cvl_lepas = isset($data_json->pemasangan[0]->intra2_lepas)?new DateTime($data_json->pemasangan[0]->intra2_lepas):'';
				if($cvl_lepas != '' && $cvl_pasang != ''){
					$hasil_cvl =  $cvl_lepas->diff($cvl_pasang)->d;
					if($hasil_cvl == 0){
						$cvl = 1;
					}else{
						$cvl = $hasil_cvl ;
					}
				}else{
					$cvl = 0; 
				}

				$sheet->SetCellValue('H'.$rowCount, $cvl);


				$infus_pasang = isset($data_json->pemasangan[0]->intra_pasang)?new DateTime($data_json->pemasangan[0]->intra_pasang):'';
				$infus_lepas = isset($data_json->pemasangan[0]->intra_lepas)?new DateTime($data_json->pemasangan[0]->intra_lepas):'';

				if($infus_pasang != '' && $infus_lepas != ''){
					$hasil_infus =  $infus_lepas->diff($infus_pasang)->d;
					if($hasil_infus == 0){
						$infus = 1;
					}else{
						$infus = $hasil_infus ;
					}
				}else{
					$infus = 0; 
				}

				$sheet->SetCellValue('I'.$rowCount, $infus);

				$kateter_pasang = isset($data_json->pemasangan[0]->intra3_pasang)?new DateTime($data_json->pemasangan[0]->intra3_pasang):'';
				$kateter_lepas = isset($data_json->pemasangan[0]->intra3_lepas)?new DateTime($data_json->pemasangan[0]->intra3_lepas):'';

				if($kateter_pasang != '' && $kateter_lepas != ''){
					$hasil_keteter =  $kateter_lepas->diff($kateter_pasang)->d;
					if($hasil_keteter == 0){
						$kateter = 1;
					}else{
						$kateter = $hasil_keteter ;
					}
				}else{
					$kateter = 0; 
				}

				$sheet->SetCellValue('J'.$rowCount, $kateter);

				$sheet->SetCellValue('K'.$rowCount, isset($data_json->question4[0]->tirah_baring)?$data_json->question4[0]->tirah_baring == "y" ? "Ya":'Tidak':'X');
				
				$sheet->SetCellValue('L'.$rowCount, isset($data_json->question3[0]->pemeriksaan)?$data_json->question3[0]->pemeriksaan:'X');
				$sheet->SetCellValue('M'.$rowCount, isset($data_json->pemasangan[0]->antibiotik)?$data_json->pemasangan[0]->antibiotik:'X');

				$rowCount++;


			}
	
			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Lapora Pasien Baru';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		  public function lap_peralatan_medis_surveilans()
		  {	
				$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
				$data['tgl_awal'] = date('Y-m-d');
				$data['tgl_akhir'] = date('Y-m-d');
				$data['idrg'] = $this->input->post('idrg');
				$data['lap_peralatan_medis_surveilans'] = array();
			  	if ($this->input->post()) {
					$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
					$data['tgl_awal'] = $this->input->post('tgl_awal');
					$data['tgl_akhir'] = $this->input->post('tgl_akhir');
					$data['idrg'] = $this->input->post('idrg');
					$data['nama_rg'] = $this->Rjmlaporan->data_ruangan_nm($data['idrg'])->row();
					$data['lap_peralatan_medis_surveilans'] = $this->Rjmlaporan->lap_peralatan_medis_surveilans($data['tgl_awal'],$data['tgl_akhir'],$data['idrg'])->result();
			  	}
			  	$this->load->view('irj/lap_peralatan_medis_surveilans', $data);
		  }

		  function download_lap_peralatan_medis_surveilans($tgl1,$tgl2,$idrg){
			
			$data = $this->Rjmlaporan->lap_peralatan_medis_surveilans( $tgl1,$tgl2,$idrg)->result();
			//  var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Tanggal');
			$sheet->SetCellValue('B1', 'No Medrec');
			$sheet->SetCellValue('C1', 'Nama');
			$sheet->SetCellValue('D1', 'ETT');
			$sheet->SetCellValue('E1', 'CVL'); 
			$sheet->SetCellValue('F1', 'Infus'); 
			$sheet->SetCellValue('G1', 'Kateter'); 
			$sheet->SetCellValue('H1', 'Tirah Baring');
			$sheet->SetCellValue('I1', 'VAP');
			$sheet->SetCellValue('J1', 'Bakteremia');
			$sheet->SetCellValue('K1', 'Plebitis');
			$sheet->SetCellValue('L1', 'ISK');
			$sheet->SetCellValue('M1', 'Dekubitus');
			$sheet->SetCellValue('N1', 'Kultur');
			$sheet->SetCellValue('O1', 'Antibiotika');
		
			$rowCount = 2;
			foreach($data as $row){
				$data_json = json_decode($row->formjson);
				$sheet->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
				$sheet->SetCellValue('B'.$rowCount, $row->no_medrec);
				$sheet->SetCellValue('C'.$rowCount,	$row->nama);
				$ett_pasang = isset($data_json->pemasangan[0]->intra4_pasang)?new DateTime($data_json->pemasangan[0]->intra4_pasang):'';
				$ett_lepas = isset($data_json->pemasangan[0]->intra4_lepas)?new DateTime($data_json->pemasangan[0]->intra4_lepas):'';
				if($ett_lepas != '' && $ett_pasang != ''){
					$hasil_ett =  $ett_lepas->diff($ett_pasang)->d;
					if($hasil_ett == 0){
						$ett = 1;
					}else{
						$ett = $hasil_ett ;
					}
				}else{
					$ett = 0; 
				}


				$sheet->SetCellValue('D'.$rowCount, $ett);

				$cvl_pasang = isset($data_json->pemasangan[0]->intra2_pasang)?new DateTime($data_json->pemasangan[0]->intra2_pasang):'';
				$cvl_lepas = isset($data_json->pemasangan[0]->intra2_lepas)?new DateTime($data_json->pemasangan[0]->intra2_lepas):'';
				if($cvl_lepas != '' && $cvl_pasang != ''){
					$hasil_cvl =  $cvl_lepas->diff($cvl_pasang)->d;
					if($hasil_cvl == 0){
						$cvl = 1;
					}else{
						$cvl = $hasil_cvl ;
					}
				}else{
					$cvl = 0; 
				}

				$sheet->SetCellValue('E'.$rowCount, $cvl);


				$infus_pasang = isset($data_json->pemasangan[0]->intra_pasang)?new DateTime($data_json->pemasangan[0]->intra_pasang):'';
				$infus_lepas = isset($data_json->pemasangan[0]->intra_lepas)?new DateTime($data_json->pemasangan[0]->intra_lepas):'';

				if($infus_pasang != '' && $infus_lepas != ''){
					$hasil_infus =  $infus_lepas->diff($infus_pasang)->d;
					if($hasil_infus == 0){
						$infus = 1;
					}else{
						$infus = $hasil_infus ;
					}
				}else{
					$infus = 0; 
				}

				$sheet->SetCellValue('F'.$rowCount, $infus);

				$kateter_pasang = isset($data_json->pemasangan[0]->intra3_pasang)?new DateTime($data_json->pemasangan[0]->intra3_pasang):'';
				$kateter_lepas = isset($data_json->pemasangan[0]->intra3_lepas)?new DateTime($data_json->pemasangan[0]->intra3_lepas):'';

				if($kateter_pasang != '' && $kateter_lepas != ''){
					$hasil_keteter =  $kateter_lepas->diff($kateter_pasang)->d;
					if($hasil_keteter == 0){
						$kateter = 1;
					}else{
						$kateter = $hasil_keteter ;
					}
				}else{
					$kateter = 0; 
				}

				$sheet->SetCellValue('G'.$rowCount, $kateter);
				$sheet->SetCellValue('H'.$rowCount,isset($data_json->question4[0]->tirah_baring)?$data_json->question4[0]->tirah_baring == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('I'.$rowCount,	isset($data_json->question4[0]->vap)?$data_json->question4[0]->vap == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('J'.$rowCount,  isset($data_json->question4[0]->baktere)?$data_json->question4[0]->baktere == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('K'.$rowCount, isset($data_json->question4[0]->plebitis)?$data_json->question4[0]->plebitis == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('L'.$rowCount, isset($data_json->question4[0]->infeksi)?$data_json->question4[0]->infeksi == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('M'.$rowCount, isset($data_json->question4[0]->dekubitus)?$data_json->question4[0]->dekubitus == "y" ? "Ya":'Tidak':'X');
				$sheet->SetCellValue('N'.$rowCount, isset($data_json->question3[0]->pemeriksaan)?$data_json->question3[0]->pemeriksaan:'X');
				$sheet->SetCellValue('O'.$rowCount, isset($data_json->pemasangan[0]->antibiotik)?$data_json->pemasangan[0]->antibiotik:'X');
				

				$rowCount++;


			}
	
			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemakaian Peralatan Medis';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		  public function lap_alat_infeksi_surveilans()
		  {	
				$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
				$data['tgl_awal'] = date('Y-m-d');
				$data['tgl_akhir'] = date('Y-m-d');
				$data['idrg'] = $this->input->post('idrg');
				$data['lap_alat_infeksi_surveilans'] = array();
			  	if ($this->input->post()) {
					$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
					$data['tgl_awal'] = $this->input->post('tgl_awal');
					$data['tgl_akhir'] = $this->input->post('tgl_akhir');
					$data['idrg'] = $this->input->post('idrg');
					$data['nama_rg'] = $this->Rjmlaporan->data_ruangan_nm($data['idrg'])->row();
					$data['lap_alat_infeksi_surveilans'] = $this->Rjmlaporan->lap_alat_infeksi_surveilans($data['tgl_awal'],$data['tgl_akhir'],$data['idrg'])->result();
			  	}

			  	$this->load->view('irj/lap_alat_infeksi_surveilans', $data);
		  }

		  function download_lap_alat_infeksi_surveilans($tgl1,$tgl2,$idrg){
			
			$data = $this->Rjmlaporan->lap_alat_infeksi_surveilans( $tgl1,$tgl2,$idrg)->result();
			//  var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Tanggal');
			$sheet->SetCellValue('B1', 'Jumlah Pasien');
			$sheet->SetCellValue('C1', 'ETT');
			$sheet->SetCellValue('D1', 'CVL');
			$sheet->SetCellValue('E1', 'Infus'); 
			$sheet->SetCellValue('F1', 'Kateter'); 
			$sheet->SetCellValue('G1', 'Tirah Baring'); 
			$sheet->SetCellValue('H1', 'VAP');
			$sheet->SetCellValue('I1', 'Bakteremia');
			$sheet->SetCellValue('J1', 'Plebitis');
			$sheet->SetCellValue('K1', 'ISK');
			$sheet->SetCellValue('L1', 'Dekubitus');
			$sheet->SetCellValue('M1', 'Kultur');
			$sheet->SetCellValue('N1', 'Antibiotika');
		
			$rowCount = 2;
			foreach($data as $row){
				$sheet->SetCellValue('A'.$rowCount, $row->tgl);
				$sheet->SetCellValue('B'.$rowCount, $row->jml_pasien);
				$sheet->SetCellValue('C'.$rowCount,	$row->jml_ett);
				$sheet->SetCellValue('D'.$rowCount, $row->jml_cvl);
				$sheet->SetCellValue('E'.$rowCount,	$row->jml_infus);
				$sheet->SetCellValue('F'.$rowCount, $row->jml_kateter);
				$sheet->SetCellValue('G'.$rowCount, $row->jml_tirah_baring);
				$sheet->SetCellValue('H'.$rowCount, $row->jml_vap);
				$sheet->SetCellValue('I'.$rowCount, $row->jml_bakteremia);
				$sheet->SetCellValue('J'.$rowCount, $row->jml_plebitis);
				$sheet->SetCellValue('K'.$rowCount, $row->jml_isk);
				$sheet->SetCellValue('L'.$rowCount, $row->jml_dekubitus);
				$sheet->SetCellValue('M'.$rowCount, $row->jml_kultur);
				$sheet->SetCellValue('N'.$rowCount, $row->jml_antibiotika);

				$rowCount++;


			}
	
			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemakaian Alat dan Infeksi';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		  public function lap_surveilands()
		  {	
				$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
				$data['tgl_awal'] = date('Y-m-d');
				$data['tgl_akhir'] = date('Y-m-d');
				$data['idrg'] = $this->input->post('idrg');
				$data['lap_alat_infeksi_surveilans'] = array();
			  	if ($this->input->post()) {
				$data['ruang']=$this->Rjmlaporan->data_ruangan()->result();
			
				$data['tgl_awal'] = $this->input->post('tgl_awal');
				$data['tgl_akhir'] = $this->input->post('tgl_akhir');
				$data['idrg'] = $this->input->post('idrg');
				$data['nama_rg'] = $this->Rjmlaporan->data_ruangan_nm($data['idrg'])->row();
					// var_dump($data['nama_rg']);die();
				$data['lap_surveilands'] = $this->Rjmlaporan->lap_surveilands($data['tgl_awal'],$data['tgl_akhir'],$data['idrg'])->row();
			  	}

			  	$this->load->view('irj/lap_surveilands', $data);
		  }

		  function download_lap_surveilands($tgl1,$tgl2,$idrg){
			
			$data = $this->Rjmlaporan->lap_surveilands( $tgl1,$tgl2,$idrg)->row();
			$ruang = $this->Rjmlaporan->data_ruangan_nm($idrg)->row();
			//  var_dump($data);die();
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'Jumlah Pasien');
			$sheet->SetCellValue('A2', 'Ruangan');
			$sheet->SetCellValue('A3', 'Tanggal');
			$sheet->SetCellValue('A4', '');

			$sheet->SetCellValue('B1', $data->jml_pasien);
			$sheet->SetCellValue('B2', $ruang->nmruang);
			$sheet->SetCellValue('B3', $tgl1.' '.'sampai'.' '.$tgl2);

			$sheet->mergeCells('B4:C4')
			->getCell('B4')
			->setValue('Jenis Operasi');

			$sheet->SetCellValue('D4', 'Jumlah Pasien');

			$sheet->mergeCells('A5:A15')
			->getCell('A5')
			->setValue('Operasi');

			$sheet->mergeCells('B5:B6')
			->getCell('B5')
			->setValue('Tipe Operasi');

			$sheet->SetCellValue('C5', 'Terbuka');
			$sheet->SetCellValue('C6', 'Tertutup');

			$sheet->SetCellValue('D5', $data->jml_op_terbuka);
			$sheet->SetCellValue('D6', $data->jml_op_tertutup);

			$sheet->mergeCells('B7:B10')
			->getCell('B7')
			->setValue('Jenis Luka');

			$sheet->SetCellValue('C7', 'Bersih');
			$sheet->SetCellValue('C8', 'Bersih Kontaminasi');
			$sheet->SetCellValue('C9', 'Kontaminasi');
			$sheet->SetCellValue('C10', 'Kotor');

			$sheet->SetCellValue('D7', $data->jml_luka_bersih);
			$sheet->SetCellValue('D8', $data->jml_luka_kontaminasi);
			$sheet->SetCellValue('D9', $data->jml_luka_konta);
			$sheet->SetCellValue('D10', $data->jml_luka_kotor);

			$sheet->mergeCells('B11:B13')
			->getCell('B11')
			->setValue('Lama Operasi');

			$sheet->SetCellValue('C11', '0 - 1 Jam');
			$sheet->SetCellValue('C12', '> 1 jam < 5 jam');
			$sheet->SetCellValue('C13', '≥ 5 jam');

			$sheet->SetCellValue('D11', $data->jml_op_satujam);
			$sheet->SetCellValue('D12', $data->jml_op_duajam);
			$sheet->SetCellValue('D13', $data->jml_op_limajam);

			$sheet->mergeCells('B14:C14')
			->getCell('B14')
			->setValue('ASA Score');

			$sheet->mergeCells('B15:C15')
			->getCell('B15')
			->setValue('Risk Score');

			$sheet->SetCellValue('D14', $data->jml_asa);
			$sheet->SetCellValue('D15', $data->jml_resiko);

			$sheet->mergeCells('A16:A23')
			->getCell('A16')
			->setValue('Tindakan');

			
			$sheet->mergeCells('B16:B17')
			->getCell('B16')
			->setValue('Catheter');

			$sheet->SetCellValue('C16', 'Jumlah pasien terpasang cateter');
			$sheet->SetCellValue('C17', 'Jumlah hari  terpasang cateter');

			$sheet->SetCellValue('D16', $data->jml_pasien_kateter);
			$sheet->SetCellValue('D17', $data->jml_hari_kateter);

			$sheet->mergeCells('B18:B19')
			->getCell('B18')
			->setValue('Infus');

			$sheet->SetCellValue('C18', 'Jumlah pasien terpasang infus');
			$sheet->SetCellValue('C19', 'Jumlah hari  terpasang infus');

			$sheet->SetCellValue('D18', $data->jml_pasien_infus);
			$sheet->SetCellValue('D19', $data->jml_hari_infus);

			$sheet->mergeCells('B20:B21')
			->getCell('B20')
			->setValue('CVL');

			$sheet->SetCellValue('C20', 'Jumlah pasien terpasang CVL');
			$sheet->SetCellValue('C21', 'Jumlah hari  terpasang CVL');

			$sheet->SetCellValue('D20', $data->jml_pasien_cvl);
			$sheet->SetCellValue('D21', $data->jml_hari_cvl);

			$sheet->mergeCells('B22:B23')
			->getCell('B22')
			->setValue('ETT');

			$sheet->SetCellValue('C22', 'Jumlah pasien terpasang ETT');
			$sheet->SetCellValue('C23', 'Jumlah hari  terpasang ETT');

			$sheet->SetCellValue('D22', $data->jml_pasien_ett);
			$sheet->SetCellValue('D23', $data->jml_hari_ett);

			$sheet->mergeCells('A24:A25')
			->getCell('A24')
			->setValue('Pemakaian antibiotik');

			$sheet->mergeCells('B24:C24')
			->getCell('B24')
			->setValue('Profilaksis');

			$sheet->mergeCells('B25:C25')
			->getCell('B25')
			->setValue('Pengobatan');

			$sheet->SetCellValue('D24', $data->jml_profilaksis);
			$sheet->SetCellValue('D25', $data->jml_pengobatan);

			$sheet->mergeCells('A26:A29')
			->getCell('A26')
			->setValue('Pemeriksaan Kultur');

			$sheet->mergeCells('B26:C26')
			->getCell('B26')
			->setValue('Darah');

			$sheet->mergeCells('B27:C27')
			->getCell('B27')
			->setValue('Urine');

			$sheet->mergeCells('B28:C28')
			->getCell('B28')
			->setValue('Sputum');

			$sheet->mergeCells('B29:C29')
			->getCell('B29')
			->setValue('Pus Luka');

			$sheet->SetCellValue('D26', $data->jml_darah);
			$sheet->SetCellValue('D27', $data->jml_urine);
			$sheet->SetCellValue('D28', $data->jml_sputum);
			$sheet->SetCellValue('D29', $data->jml_pus_luka);

			$sheet->mergeCells('A30:C30')
			->getCell('A30')
			->setValue('Hasi Kultur');

			$sheet->SetCellValue('D30', $data->jml_hasil_kultur);

			$sheet->mergeCells('A31:A37')
			->getCell('A31')
			->setValue('HAIs');

			$sheet->mergeCells('B31:C31')
			->getCell('B31')
			->setValue('Bakterimia');

			$sheet->mergeCells('B31:C31')
			->getCell('B31')
			->setValue('Luka');

			$sheet->mergeCells('B32:C32')
			->getCell('B32')
			->setValue('Sepsis');

			$sheet->mergeCells('B33:C33')
			->getCell('B33')
			->setValue('Pneumonia / VAP (Ventilator Associated Pneumonia ) / HAP');

			$sheet->mergeCells('B34:C34')
			->getCell('B34')
			->setValue('Infeksi Saluran Kemih');

			$sheet->mergeCells('B35:C35')
			->getCell('B35')
			->setValue('Infeksi Luka Operasi');

			$sheet->mergeCells('B36:C36')
			->getCell('B36')
			->setValue('Plebitis');

			$sheet->mergeCells('B37:C37')
			->getCell('B37')
			->setValue('Infeksi Lain');

			$sheet->SetCellValue('D31', $data->jml_bakteremia);
			$sheet->SetCellValue('D32', $data->jml_sepsis);
			$sheet->SetCellValue('D33', $data->jml_vap);
			$sheet->SetCellValue('D34', $data->jml_isk);
			$sheet->SetCellValue('D35', $data->jml_luka_operasi);
			$sheet->SetCellValue('D36', $data->jml_plebitis);
			$sheet->SetCellValue('D37', $data->jml_infeksi_lain);

			$sheet->mergeCells('A38:A39')
			->getCell('A38')
			->setValue('Dekubitus');

			$sheet->mergeCells('B38:C38')
			->getCell('B38')
			->setValue('umlah pasien terjadi dekubitus');

			$sheet->mergeCells('B39:C39')
			->getCell('B39')
			->setValue('Jumlah hari tirah baring');

			$sheet->SetCellValue('D38', $data->jml_dekubitus);
			$sheet->SetCellValue('D39', $data->jml_tirah_baring);


			// $sheet->SetCellValue('F1', 'Kateter'); 
			// $sheet->SetCellValue('G1', 'Tirah Baring'); 
			// $sheet->SetCellValue('H1', 'VAP');
			// $sheet->SetCellValue('I1', 'Bakteremia');
			// $sheet->SetCellValue('J1', 'Plebitis');
			// $sheet->SetCellValue('K1', 'ISK');
			// $sheet->SetCellValue('L1', 'Dekubitus');
			// $sheet->SetCellValue('M1', 'Kultur');
			// $sheet->SetCellValue('N1', 'Antibiotika');
		
			
	
			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Pemakaian Alat dan Infeksi';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		function bor_los_toi(){
			if($this->input->post()){
			 	$thn = $this->input->post('tahun');
				$data['tahun_now'] = $thn;
			 	$data['hari_perawatan'] = $this->Rjmlaporan->get_hari_perawatan_search($thn)->row();
				$data['lama_perawatan'] = $this->Rjmlaporan->get_lama_perawatan_search($thn)->row();
				$data['pasien_keluar'] = $this->Rjmlaporan->get_pasien_keluar_search($thn)->row();
				$data['pasien_meninggal_lbh_48'] = $this->Rjmlaporan->get_pasien_meninggal_48_search($thn)->row();
				$data['pasien_meninggal'] = $this->Rjmlaporan->get_pasien_meninggal_search($thn)->row();
				$data['bed'] = $this->Rjmlaporan->get_count_bed()->row();
				$this->load->view('irj/bor_los_toi_search', $data);
			}else{
				$data['hari_perawatan'] = $this->Rjmlaporan->get_hari_perawatan()->row();
				$data['lama_perawatan'] = $this->Rjmlaporan->get_lama_perawatan()->row();
				$data['pasien_keluar'] = $this->Rjmlaporan->get_pasien_keluar()->row();
				$data['pasien_meninggal_lbh_48'] = $this->Rjmlaporan->get_pasien_meninggal_48()->row();
				$data['pasien_meninggal'] = $this->Rjmlaporan->get_pasien_meninggal()->row();
				$data['bed'] = $this->Rjmlaporan->get_count_bed()->row();
				$this->load->view('irj/bor_los_toi', $data);
			}
			
		}

		function download_bor_los_toi(){
			
			$hari_perawatan = $this->Rjmlaporan->get_hari_perawatan()->row();
			$lama_perawatan = $this->Rjmlaporan->get_lama_perawatan()->row();
			$pasien_keluar = $this->Rjmlaporan->get_pasien_keluar()->row();
			$pasien_meninggal_lbh_48 = $this->Rjmlaporan->get_pasien_meninggal_48()->row();
			$pasien_meninggal = $this->Rjmlaporan->get_pasien_meninggal()->row();
			$bed = $this->Rjmlaporan->get_count_bed()->row()->bed;

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'BULAN');
			$sheet->SetCellValue('B1', 'BOR');
			$sheet->SetCellValue('C1', 'LOS');
			$sheet->SetCellValue('D1', 'TOI');
			$sheet->SetCellValue('E1', 'BTO');
			$sheet->SetCellValue('F1', 'NDR');
			$sheet->SetCellValue('G1', 'GDR');

			$tahun_now = date('Y');
			$sheet->SetCellValue('A2', 'JANUARI');
			
// JANUARI
			$jumHarijan = cal_days_in_month(CAL_GREGORIAN, 1, $tahun_now);
			$bulan_jan = $tahun_now.'-'.'01';
				// bor
			if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){ 
					$hari_perawatanjan = $hari_perawatan->hp_januari;
					$bawah_jan =  $bed*$jumHarijan;
					$bor_blm_persen =  $hari_perawatanjan / $bawah_jan;
					$bor_fix = $bor_blm_persen * 100;
					$sheet->SetCellValue('B2', number_format($bor_fix,2).'%');
			}else{
					$sheet->SetCellValue('B2', '-');
			}

			// los

			if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){ 
				$lama_rawatjan = $lama_perawatan->lamrat_januari;
				$pasien_keluarjan = $pasien_keluar->keluar_januari;
				$los = $lama_rawatjan / $pasien_keluarjan;

					$sheet->SetCellValue('C2', round($los).' '.'Hari');
			}else{
					$sheet->SetCellValue('C2', '-');
			}

			// TOI
			if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){
				$atasjan = $bawah_jan - $hari_perawatanjan;
				$toi =  $atasjan/$pasien_keluarjan ;
				$sheet->SetCellValue('D2', round($toi).' '.'Hari');
			}else{
				$sheet->SetCellValue('D2', '-');
			}

			// BTO

			if( date('Y-m') == $bulan_jan || date('Y-m') > $bulan_jan){
				$bto = $pasien_keluarjan / $bed;
				$sheet->SetCellValue('E2', round($bto).' '.'Kali');
			}else{
				$sheet->SetCellValue('E2', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_jan){
				$pasien_meninggal48_jan = $pasien_meninggal_lbh_48->meninggal_lebih48_januari;
				$ndr_jan_blm_permil = $pasien_meninggal48_jan / $pasien_keluarjan;
				$ndr_jan_fix = $ndr_jan_blm_permil * 1000;
				$sheet->SetCellValue('F2', number_format($ndr_jan_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F2', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_jan){
				$pasien_meninggal_jan = $pasien_meninggal->meninggal_januari;
				$gdr_jan_blm_permil = $pasien_meninggal_jan / $pasien_keluarjan;
				$gdr_jan_fix = $gdr_jan_blm_permil * 1000;
				$sheet->SetCellValue('G2', number_format($gdr_jan_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G2', '-');
			}



// FEBRUARI
			$sheet->SetCellValue('A3', 'FEBRUARI');
			$jumHarifeb = cal_days_in_month(CAL_GREGORIAN, 2, $tahun_now);
			$bulan_feb = $tahun_now.'-'.'02';

			// bor

			if( date('Y-m') >= $bulan_feb){ 
				$hari_perawatanfeb = $hari_perawatan->hp_februari;
				$bawahfeb =  $bed*$jumHarifeb;
				$bor_blm_persen_feb =  $hari_perawatanfeb / $bawahfeb;
				$bor_fix_feb = $bor_blm_persen_feb * 100;
					$sheet->SetCellValue('B3',number_format($bor_fix_feb,2).'%');
				}else{
					$sheet->SetCellValue('B3','-');
				}

			// los
			if( date('Y-m') >= $bulan_feb){ 
				$lama_rawat_feb = $lama_perawatan->lamrat_februari;
				$pasien_keluar_feb = $pasien_keluar->keluar_februari;
				$los_feb = $lama_rawat_feb / $pasien_keluar_feb;
				$sheet->SetCellValue('C3', round($los_feb).' '.'Hari');
			}else{
				$sheet->SetCellValue('C3', '-');
			}

			// toi

			if( date('Y-m') >= $bulan_feb){
				$atas_feb = $bawahfeb - $hari_perawatanfeb;
				$toi_feb =  $atas_feb/$pasien_keluar_feb ;
				$sheet->SetCellValue('D3', round($toi_feb).' '.'Hari');
			}else{
				$sheet->SetCellValue('D3','-');
			}

			// bto

			if( date('Y-m') >= $bulan_feb){
				$bto_feb = $pasien_keluar_feb / $bed;
				$sheet->SetCellValue('E3', round($bto_feb).' '.'kali');
			}else{
				$sheet->SetCellValue('E3', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_feb){
				$pasien_meninggal48_feb = $pasien_meninggal_lbh_48->meninggal_lebih48_februari;
				$ndr_feb_blm_permil = $pasien_meninggal48_feb / $pasien_keluar_feb;
				$ndr_feb_fix = $ndr_feb_blm_permil * 1000;
				$sheet->SetCellValue('F3', number_format($ndr_feb_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F3', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_feb){
				$pasien_meninggal_feb = $pasien_meninggal->meninggal_februari;
				$gdr_feb_blm_permil = $pasien_meninggal_feb / $pasien_keluar_feb;
				$gdr_feb_fix = $gdr_feb_blm_permil * 1000;
				$sheet->SetCellValue('G3', number_format($gdr_feb_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G3', '-');
			}


// MARET

			$jumHarimar = cal_days_in_month(CAL_GREGORIAN, 3, $tahun_now);
			$bulan_maret = $tahun_now.'-'.'03';
			$sheet->SetCellValue('A4', 'MARET');

			// bor
			if( date('Y-m') >= $bulan_maret){ 
				$hari_perawatan_mar = $hari_perawatan->hp_maret;
				$bawah_mar =  $bed*$jumHarimar;
				$bor_blm_persen_mar =  $hari_perawatan_mar / $bawah_mar;
				$bor_fix_mar = $bor_blm_persen_mar * 100;
				$sheet->SetCellValue('B4',number_format($bor_fix_mar,2).'%');
			}else{
				$sheet->SetCellValue('B4','-');
			}

			// los

			if( date('Y-m') >= $bulan_maret){ 
				$lama_rawat_mar = $lama_perawatan->lamrat_maret;
				$pasien_keluar_mar = $pasien_keluar->keluar_maret;
				$los_mar = $lama_rawat_mar / $pasien_keluar_mar;
				$sheet->SetCellValue('C4', round($los_mar).' '.'Hari');
			}else{
				$sheet->SetCellValue('C4', '-');
			}

			// toi
			if( date('Y-m') >= $bulan_maret){
				$atas_mar = $bawah_mar - $hari_perawatan_mar;
				$toi_mar =  $atas_mar/$pasien_keluar_mar ;
				$sheet->SetCellValue('D4', round($toi_mar).' '.'Hari');
			}else{
				$sheet->SetCellValue('D4', '-');
			}

			// bto
			if( date('Y-m') >= $bulan_maret){
				$bto_mar = $pasien_keluar_mar / $bed;
				$sheet->SetCellValue('E4', round($bto_mar).' '.'kali');
			}else{
				$sheet->SetCellValue('E4', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_maret){
				$pasien_meninggal48_mar = $pasien_meninggal_lbh_48->meninggal_lebih48_maret;
				$ndr_mar_blm_permil = $pasien_meninggal48_mar / $pasien_keluar_mar;
				$ndr_mar_fix = $ndr_mar_blm_permil * 1000;
				$sheet->SetCellValue('F4', number_format($ndr_mar_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F4', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_maret){
				$pasien_meninggal_mar = $pasien_meninggal->meninggal_maret;
				$gdr_mar_blm_permil = $pasien_meninggal_mar / $pasien_keluar_mar;
				$gdr_mar_fix = $gdr_mar_blm_permil * 1000;
				$sheet->SetCellValue('G4', number_format($gdr_mar_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G4', '-');
			}


// APRIL

			$jumHariapril = cal_days_in_month(CAL_GREGORIAN, 4, $tahun_now);
			$bulan_april = $tahun_now.'-'.'04';
			$sheet->SetCellValue('A5', 'APRIL');

			// BOR

			if( date('Y-m') >= $bulan_april){ 
				$hari_perawatan_apr = $hari_perawatan->hp_april;
				$bawah_april =  $bed*$jumHariapril;
				$bor_blm_persen_apr =  $hari_perawatan_apr / $bawah_april;
				$bor_fix_april = $bor_blm_persen_apr * 100;
				$sheet->SetCellValue('B5',number_format($bor_fix_april,2).'%');
			}else{
				$sheet->SetCellValue('B5','-');
			}

			// los

			if( date('Y-m') >= $bulan_april){ 
				$lama_rawat_apr = $lama_perawatan->lamrat_april;
				$pasien_keluar_apr = $pasien_keluar->keluar_april;
				$los_apr = $lama_rawat_apr / $pasien_keluar_apr;
				$sheet->SetCellValue('C5', round($los_apr).' '.'Hari');
			}else{
				$sheet->SetCellValue('C5', '-');
			}

			// toi
			if( date('Y-m') >= $bulan_april){
				$atas_april = $bawah_april - $hari_perawatan_apr;
				$toi_april =  $atas_april/$pasien_keluar_apr ;
				$sheet->SetCellValue('D5', round($toi_april).' '.'Hari');
			}else{
				$sheet->SetCellValue('D5', '-');
			}

			// bto
			if( date('Y-m') >= $bulan_april){
				$bto_april = $pasien_keluar_apr / $bed;
				$sheet->SetCellValue('E5', round($bto_april).' '.'kali');
			}else{
				$sheet->SetCellValue('E5', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_april){
				$pasien_meninggal48_apr = $pasien_meninggal_lbh_48->meninggal_lebih48_april;
				$ndr_apr_blm_permil = $pasien_meninggal48_apr / $pasien_keluar_apr;
				$ndr_apr_fix = $ndr_apr_blm_permil * 1000;
				$sheet->SetCellValue('F5', number_format($ndr_apr_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F5', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_april){
				$pasien_meninggal_apr = $pasien_meninggal->meninggal_april;
				$gdr_apr_blm_permil = $pasien_meninggal_apr / $pasien_keluar_apr;
				$gdr_apr_fix = $gdr_apr_blm_permil * 1000;
				$sheet->SetCellValue('G5', number_format($gdr_apr_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G5', '-');
			}
			
// MEI
			$jumHariMei = cal_days_in_month(CAL_GREGORIAN, 5, $tahun_now);
			$bulan_mei = $tahun_now.'-'.'05';
			$sheet->SetCellValue('A6', 'MEI');
			// bor
			if( date('Y-m') >= $bulan_mei){ 
				$hari_perawatan_mei = $hari_perawatan->hp_mei;
				$bawah_mei =  $bed*$jumHariMei;
				$bor_blm_persen_mei =  $hari_perawatan_mei / $bawah_mei;
				$bor_fix_mei = $bor_blm_persen_mei * 100;
				$sheet->SetCellValue('B6',number_format($bor_fix_mei,2).'%');
			}else{
				$sheet->SetCellValue('B6','-');
			}

			// los
			if( date('Y-m') >= $bulan_mei){ 
				$lama_rawat_mei = $lama_perawatan->lamrat_mei;
				$pasien_keluar_mei = $pasien_keluar->keluar_mei;
				$los_mei = $lama_rawat_mei / $pasien_keluar_mei;
				$sheet->SetCellValue('C6',round($los_mei,2).'Hari');
			}else{
				$sheet->SetCellValue('C6','-');
			}

			// toi
			if( date('Y-m') >= $bulan_mei){
				$atas_mei = $bawah_mei - $hari_perawatan_mei;
				$toi_mei =  $atas_mei/$pasien_keluar_mei ;
				$sheet->SetCellValue('D6', round($toi_mei).' '.'Hari');
			}else{
				$sheet->SetCellValue('D6', '-');
			}

			// bto
			if( date('Y-m') >= $bulan_mei){
				$bto_mei = $pasien_keluar_mei / $bed;
				$sheet->SetCellValue('E6', round($bto_mei).' '.'kali');
			}else{
				$sheet->SetCellValue('E6', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_mei){
				$pasien_meninggal48_mei = $pasien_meninggal_lbh_48->meninggal_lebih48_mei;
				$ndr_mei_blm_permil = $pasien_meninggal48_mei / $pasien_keluar_mei;
				$ndr_mei_fix = $ndr_mei_blm_permil * 1000;
				$sheet->SetCellValue('F6', number_format($ndr_mei_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F6', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_mei){
				$pasien_meninggal_mei = $pasien_meninggal->meninggal_mei;
				$gdr_mei_blm_permil = $pasien_meninggal_mei / $pasien_keluar_mei;
				$gdr_mei_fix = $gdr_mei_blm_permil * 1000;
				$sheet->SetCellValue('G6', number_format($gdr_mei_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G6', '-');
			}

// JUNI

			$jumHariJuni = cal_days_in_month(CAL_GREGORIAN, 6, $tahun_now);
			$bulan_juni = $tahun_now.'-'.'06';
			$sheet->SetCellValue('A7', 'JUNI');
			// bor
			if( date('Y-m') >= $bulan_juni){ 
				$hari_perawatan_jun = $hari_perawatan->hp_juni;
				$bawah_juni =  $bed*$jumHariJuni;
				$bor_blm_persen_juni =  $hari_perawatan_jun / $bawah_juni;
				$bor_fix_juni = $bor_blm_persen_juni * 100;
				$sheet->SetCellValue('B7',number_format($bor_fix_juni,2).'%');
			}else{
				$sheet->SetCellValue('B7','-');
			}
			// los
			if( date('Y-m') >= $bulan_juni){ 
				$lama_rawat_juni = $lama_perawatan->lamrat_juni;
				$pasien_keluar_juni = $pasien_keluar->keluar_juni;
				$los_juni = $lama_rawat_juni / $pasien_keluar_juni;
				$sheet->SetCellValue('C7',round($los_juni,2).'Hari');
			}else{
				$sheet->SetCellValue('C7','-');
			}
			// toi
			if( date('Y-m') >= $bulan_juni){
				$atas_juni = $bawah_juni - $hari_perawatan_jun;
				$toi_juni =  $atas_juni/$pasien_keluar_juni ;
				$sheet->SetCellValue('D7', round($toi_juni).' '.'Hari');
			}else{
				$sheet->SetCellValue('D7','-');
			}
			// bto
			if( date('Y-m') >= $bulan_juni){
				$bto_juni = $pasien_keluar_juni / $bed;
				$sheet->SetCellValue('E7', round($bto_juni).' '.'kali');
			}else{
				$sheet->SetCellValue('E7','-');
			}

			
			// NDR

			if( date('Y-m') >= $bulan_juni){
				$pasien_meninggal48_jun = $pasien_meninggal_lbh_48->meninggal_lebih48_juni;
				$ndr_jun_blm_permil = $pasien_meninggal48_jun / $pasien_keluar_juni;
				$ndr_jun_fix = $ndr_jun_blm_permil * 1000;
				$sheet->SetCellValue('F7', number_format($ndr_jun_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F7', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_juni){
				$pasien_meninggal_jun = $pasien_meninggal->meninggal_juni;
				$gdr_jun_blm_permil = $pasien_meninggal_jun / $pasien_keluar_juni;
				$gdr_jun_fix = $gdr_jun_blm_permil * 1000;
				$sheet->SetCellValue('G7', number_format($gdr_jun_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G7', '-');
			}

// JULI
			$jumHariJuli = cal_days_in_month(CAL_GREGORIAN, 7, $tahun_now);
			$bulan_juli = $tahun_now.'-'.'07';
			$sheet->SetCellValue('A8', 'JULI');
			// bor
			if( date('Y-m') >= $bulan_juli){ 
				$hari_perawatan_juli = $hari_perawatan->hp_juli;
				$bawah_juli =  $bed*$jumHariJuli;
				$bor_blm_persen_juli =  $hari_perawatan_juli / $bawah_juli;
				$bor_fix_juli = $bor_blm_persen_juli * 100;
				$sheet->SetCellValue('B8',number_format($bor_fix_juli,2).'%');
			}else{
				$sheet->SetCellValue('B8','-');
			}

			// los
			if( date('Y-m') >= $bulan_juli){ 
				$lama_rawat_juli = $lama_perawatan->lamrat_juli;
				$pasien_keluar_juli = $pasien_keluar->keluar_juli;
				$los_juli = $lama_rawat_juli / $pasien_keluar_juli;
				$sheet->SetCellValue('C8',round($los_juli,2).'Hari');
			}else{
				$sheet->SetCellValue('C8','-');
			}
			// toi
			if( date('Y-m') >= $bulan_juli){
				$atas_juli = $bawah_juli - $hari_perawatan_juli;
				$toi_juli =  $atas_juli/$pasien_keluar_juli ;
				$sheet->SetCellValue('D8', round($toi_juli).' '.'Hari');
			}else{
				$sheet->SetCellValue('D8', '-');
			}
			// bto
			if( date('Y-m') >= $bulan_juli){
				$bto_juli = $pasien_keluar_juli / $bed;
				$sheet->SetCellValue('E8', round($bto_juli).' '.'kali');
			}else{
				$sheet->SetCellValue('E8', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_juli){
				$pasien_meninggal48_jul = $pasien_meninggal_lbh_48->meninggal_lebih48_juli;
				$ndr_jul_blm_permil = $pasien_meninggal48_jul / $pasien_keluar_juli;
				$ndr_jul_fix = $ndr_jul_blm_permil * 1000;
				$sheet->SetCellValue('F8', number_format($ndr_jul_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F8', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_juli){
				$pasien_meninggal_jul = $pasien_meninggal->meninggal_juli;
				$gdr_jul_blm_permil = $pasien_meninggal_jul / $pasien_keluar_juli;
				$gdr_jul_fix = $gdr_jul_blm_permil * 1000;
				$sheet->SetCellValue('G8', number_format($gdr_jul_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G8', '-');
			}

// AGUSTUS
			$jumHariAgustus = cal_days_in_month(CAL_GREGORIAN, 8, $tahun_now);
            $bulan_agus = $tahun_now.'-'.'08';
			$sheet->SetCellValue('A9', 'AGUSTUS');
			// bor
			if( date('Y-m') >= $bulan_agus){ 
				$hari_perawatan_agus = $hari_perawatan->hp_agustus;
				$bawah_agus =  $bed*$jumHariAgustus;
				$bor_blm_persen_agus =  $hari_perawatan_agus / $bawah_agus;
				$bor_fix_agus = $bor_blm_persen_agus * 100;
				$sheet->SetCellValue('B9',number_format($bor_fix_agus,2).'%');
			}else{
				$sheet->SetCellValue('B9','-');
			}
			// los
			if( date('Y-m') >= $bulan_agus){ 
				$lama_rawat_agus = $lama_perawatan->lamrat_agustus;
				$pasien_keluar_agus = $pasien_keluar->keluar_agustuss;
				$los_agus = $lama_rawat_agus / $pasien_keluar_agus;
				$sheet->SetCellValue('C9',round($los_agus,2).'Hari');
			}else{
				$sheet->SetCellValue('C9','-');
			}
			// toi
			if( date('Y-m') >= $bulan_agus){
				$atas_agus = $bawah_agus - $hari_perawatan_agus;
				$toi_agus =  $atas_agus/$pasien_keluar_agus ;
				$sheet->SetCellValue('D9', round($toi_agus).' '.'Hari');
			}else{
				$sheet->SetCellValue('D9', '-');
			}
			// bto
			if( date('Y-m') >= $bulan_agus){
				$bto_agus = $pasien_keluar_agus / $bed;
				$sheet->SetCellValue('E9', round($bto_agus).' '.'kali');
			}else{
				$sheet->SetCellValue('E9', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_agus){
				$pasien_meninggal48_agus = $pasien_meninggal_lbh_48->meninggal_lebih48_agustus;
				$ndr_agus_blm_permil = $pasien_meninggal48_agus / $pasien_keluar_agus;
				$ndr_agus_fix = $ndr_agus_blm_permil * 1000;
				$sheet->SetCellValue('F9', number_format($ndr_agus_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F9', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_agus){
				$pasien_meninggal_agus = $pasien_meninggal->meninggal_agus;
				$gdr_agus_blm_permil = $pasien_meninggal_agus / $pasien_keluar_agus;
				$gdr_agus_fix = $gdr_agus_blm_permil * 1000;
				$sheet->SetCellValue('G9', number_format($gdr_agus_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G9', '-');
			}

// SEPTEMBER
			$jumHarisep = cal_days_in_month(CAL_GREGORIAN, 9, $tahun_now);
			$bulan_sep = $tahun_now.'-'.'09';
			$sheet->SetCellValue('A10', 'SEPTEMBER');
			// bor
			if( date('Y-m') >= $bulan_sep){ 
				$hari_perawatan_sep = $hari_perawatan->hp_september;
				$bawah_sep =  $bed*$jumHarisep;
				$bor_blm_persen_sep =  $hari_perawatan_sep / $bawah_sep;
				$bor_fix_sep = $bor_blm_persen_sep * 100;
				$sheet->SetCellValue('B10',number_format($bor_fix_sep,2).'%');
			}else{
				$sheet->SetCellValue('B10','-');
			}
			// los
			if( date('Y-m') >= $bulan_sep){ 
				$lama_rawat_sep = $lama_perawatan->lamrat_september;
				$pasien_keluar_sep = $pasien_keluar->keluar_september;
				$los_sep = $lama_rawat_sep / $pasien_keluar_sep;
				$sheet->SetCellValue('C10',round($los_sep,2).'Hari');
			}else{
				$sheet->SetCellValue('C10','-');
			}
			// toi
			if( date('Y-m') >= $bulan_sep){
				$atas_sep = $bawah_sep - $hari_perawatan_sep;
				$toi_sep =  $atas_sep/$pasien_keluar_sep ;
				$sheet->SetCellValue('D10', round($toi_sep).' '.'Hari');
			}else{
				$sheet->SetCellValue('D10', '-');
			}
			// bto
			if( date('Y-m') >= $bulan_sep){
				$bto_sep = $pasien_keluar_sep / $bed;
				$sheet->SetCellValue('E10', round($bto_sep).' '.'kali');
			}else{
				$sheet->SetCellValue('E10', '-');
			}
			// NDR

			if( date('Y-m') >= $bulan_sep){
				$pasien_meninggal48_sep = $pasien_meninggal_lbh_48->meninggal_lebih48_september;
				$ndr_sep_blm_permil = $pasien_meninggal48_sep / $pasien_keluar_sep;
				$ndr_sep_fix = $ndr_sep_blm_permil * 1000;
				$sheet->SetCellValue('F10', number_format($ndr_sep_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F10', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_sep){
				$pasien_meninggal_sep = $pasien_meninggal->meninggal_september;
				$gdr_sep_blm_permil = $pasien_meninggal_sep / $pasien_keluar_sep;
				$gdr_sep_fix = $gdr_sep_blm_permil * 1000;
				$sheet->SetCellValue('G10', number_format($gdr_sep_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G10', '-');
			}

// OKTOBER
			$jumHariokt = cal_days_in_month(CAL_GREGORIAN, 10, $tahun_now);
			$bulan_okt = $tahun_now.'-'.'10';
			$sheet->SetCellValue('A11', 'OKTOBER');
			// bor
			if( date('Y-m') >= $bulan_okt){ 
				$hari_perawatan_okt = $hari_perawatan->hp_oktober;
				$bawah_okt =  $bed*$jumHariokt;
				$bor_blm_persen_okt =  $hari_perawatan_okt / $bawah_okt;
				$bor_fix_okt = $bor_blm_persen_okt * 100;
				$sheet->SetCellValue('B11',number_format($bor_fix_okt,2).'%');
			}else{
				$sheet->SetCellValue('B11','-');
			}
			// los
			if( date('Y-m') >= $bulan_okt){ 
				$lama_rawat_okt = $lama_perawatan->lamrat_oktober;
				$pasien_keluar_okt = $pasien_keluar->keluar_oktober;
				$los_okt = $lama_rawat_okt / $pasien_keluar_okt;
				$sheet->SetCellValue('C11',round($los_okt,2).'Hari');
			}else{
				$sheet->SetCellValue('C11','-');
			}
			// toi
			if( date('Y-m') >= $bulan_okt){
				$atas_okt = $bawah_okt - $hari_perawatan_okt;
				$toi_okt =  $atas_okt/$pasien_keluar_okt ;
				$sheet->SetCellValue('D11', round($toi_okt).' '.'Hari');
			}else{
				$sheet->SetCellValue('D11', '-');
			}
			// bto
			if( date('Y-m') >= $bulan_okt){
				$bto_okt = $pasien_keluar_okt / $bed;
				$sheet->SetCellValue('E11', round($bto_okt).' '.'kali');
			}else{
				$sheet->SetCellValue('E11', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_okt){
				$pasien_meninggal48_okt = $pasien_meninggal_lbh_48->meninggal_lebih48_okt;
				$ndr_okt_blm_permil = $pasien_meninggal48_okt / $pasien_keluar_okt;
				$ndr_okt_fix = $ndr_okt_blm_permil * 1000;
				$sheet->SetCellValue('F11', number_format($ndr_okt_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F11', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_okt){
				$pasien_meninggal_okt = $pasien_meninggal->meninggal_okt;
				$gdr_okt_blm_permil = $pasien_meninggal_okt / $pasien_keluar_okt;
				$gdr_okt_fix = $gdr_okt_blm_permil * 1000;
				$sheet->SetCellValue('G11', number_format($gdr_okt_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G11', '-');
			}

// november
			$jumHariNov = cal_days_in_month(CAL_GREGORIAN, 11, $tahun_now);
			$bulan_nov = $tahun_now.'-'.'11';
			$sheet->SetCellValue('A12', 'NOVEMBER');
			// bor
			if( date('Y-m') >= $bulan_nov){ 
				$hari_perawatan_nov = $hari_perawatan->hp_november;
				$bawah_nov =  $bed*$jumHariNov;
				$bor_blm_persen_nov =  $hari_perawatan_nov / $bawah_nov;
				$bor_fix_nov = $bor_blm_persen_nov * 100;
				$sheet->SetCellValue('B12',number_format($bor_fix_nov,2).'%');
			}else{
				$sheet->SetCellValue('B12','-');
			}
			// los
			if( date('Y-m') >= $bulan_nov){ 
				$lama_rawat_nov = $lama_perawatan->lamrat_november;
				$pasien_keluar_nov = $pasien_keluar->keluar_november;
				$los_nov = $lama_rawat_nov / $pasien_keluar_nov;
				$sheet->SetCellValue('C12',round($los_nov,2).'Hari');
			}else{
				$sheet->SetCellValue('C12','-');
			}
			// toi
			if( date('Y-m') >= $bulan_nov){
				$atas_nov = $bawah_nov - $hari_perawatan_nov;
				$toi_nov =  $atas_nov/$pasien_keluar_nov ;
				$sheet->SetCellValue('D12', round($toi_nov).' '.'Hari');
			}else{
				$sheet->SetCellValue('D12', '-');
			}
			// bto
			if( date('Y-m') >= $bulan_nov){
				$bto_nov = $pasien_keluar_nov / $bed;
				$sheet->SetCellValue('E12', round($bto_nov).' '.'kali');
			}else{
				$sheet->SetCellValue('E12', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_nov){
				$pasien_meninggal48_nov = $pasien_meninggal_lbh_48->meninggal_lebih48_nov;
				$ndr_nov_blm_permil = $pasien_meninggal48_nov / $pasien_keluar_nov;
				$ndr_nov_fix = $ndr_nov_blm_permil * 1000;
				$sheet->SetCellValue('F12', number_format($ndr_nov_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F12', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_nov){
				$pasien_meninggal_nov = $pasien_meninggal->meninggal_nov;
				$gdr_nov_blm_permil = $pasien_meninggal_nov / $pasien_keluar_nov;
				$gdr_nov_fix = $gdr_nov_blm_permil * 1000;
				$sheet->SetCellValue('G12', number_format($gdr_nov_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G12', '-');
			}


// DESEMBER
			$jumHariDes = cal_days_in_month(CAL_GREGORIAN, 12, $tahun_now);
			$bulan_des = $tahun_now.'-'.'12';
			$sheet->SetCellValue('A13', 'DESEMBER');
			// bor
			if( date('Y-m') >= $bulan_des){ 
				$hari_perawatan_des = $hari_perawatan->hp_desember;
				$bawah_des =  $bed*$jumHariDes;
				$bor_blm_persen_des =  $hari_perawatan_des / $bawah_des;
				$bor_fix_des = $bor_blm_persen_des * 100;
				$sheet->SetCellValue('B13',number_format($bor_fix_des,2).'%');
			}else{
				$sheet->SetCellValue('B13','-');
			}
			// los
			if( date('Y-m') >= $bulan_des){ 
				$lama_rawat_des = $lama_perawatan->lamrat_desember;
				$pasien_keluar_des = $pasien_keluar->keluar_desember;
				$los_des = $lama_rawat_des / $pasien_keluar_des;
				$sheet->SetCellValue('C13',round($los_des,2).'Hari');
			}else{
				$sheet->SetCellValue('C13','-');
			}
			// toi
			if( date('Y-m') >= $bulan_des){
				$atas_des = $bawah_des - $hari_perawatan_des;
				$toi_des =  $atas_des/$pasien_keluar_des ;
				$sheet->SetCellValue('D13', round($toi_des).' '.'Hari');
			}else{
				$sheet->SetCellValue('D13','-');
			}
			// bto
			if( date('Y-m') >= $bulan_des){
				$bto_des = $pasien_keluar_des / $bed;
				$sheet->SetCellValue('E13', round($bto_des).' '.'kali');
			}else{
				$sheet->SetCellValue('E13', '-');
			}

			// NDR

			if( date('Y-m') >= $bulan_des){
				$pasien_meninggal48_des = $pasien_meninggal_lbh_48->meninggal_lebih48_des;
				$ndr_des_blm_permil = $pasien_meninggal48_des / $pasien_keluar_des;
				$ndr_des_fix = $ndr_des_blm_permil * 1000;
				$sheet->SetCellValue('F13', number_format($ndr_des_fix,2).'‰');
			}else{
				$sheet->SetCellValue('F13', '-');
			}

			// GDR

			if( date('Y-m') >= $bulan_des){
				$pasien_meninggal_des = $pasien_meninggal->meninggal_des;
				$gdr_des_blm_permil = $pasien_meninggal_des / $pasien_keluar_des;
				$gdr_des_fix = $gdr_des_blm_permil * 1000;
				$sheet->SetCellValue('G13', number_format($gdr_des_fix,2).'‰');
			}else{
				$sheet->SetCellValue('G13', '-');
			}


			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan BOR LOS TOI';
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		function download_bor_los_toi_search($thn){
			// var_dump($thn);die();
			$hari_perawatan = $this->Rjmlaporan->get_hari_perawatan_search($thn)->row();
			$lama_perawatan = $this->Rjmlaporan->get_lama_perawatan_search($thn)->row();
			$pasien_keluar = $this->Rjmlaporan->get_pasien_keluar_search($thn)->row();
			$pasien_meninggal_lbh_48 = $this->Rjmlaporan->get_pasien_meninggal_48_search($thn)->row();
			$pasien_meninggal = $this->Rjmlaporan->get_pasien_meninggal_search($thn)->row();
			$bed = $this->Rjmlaporan->get_count_bed()->row()->bed;

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet(); 
	
			$sheet->SetCellValue('A1', 'BULAN');
			$sheet->SetCellValue('B1', 'BOR');
			$sheet->SetCellValue('C1', 'LOS');
			$sheet->SetCellValue('D1', 'TOI');
			$sheet->SetCellValue('E1', 'BTO');
			$sheet->SetCellValue('F1', 'NDR');
			$sheet->SetCellValue('G1', 'GDR');

			$tahun_now = $thn;
			$sheet->SetCellValue('A2', 'JANUARI');
			
// JANUARI
			$jumHarijan = cal_days_in_month(CAL_GREGORIAN, 1, $tahun_now);
			$bulan_jan = $tahun_now.'-'.'01';
				// bor
			
					$hari_perawatanjan = $hari_perawatan->hp_januari;
					$bawah_jan =  $bed*$jumHarijan;
					$bor_blm_persen =  $hari_perawatanjan / $bawah_jan;
					$bor_fix = $bor_blm_persen * 100;
					$sheet->SetCellValue('B2', number_format($bor_fix,2).'%');
			

			// los

			
				$lama_rawatjan = $lama_perawatan->lamrat_januari;
				$pasien_keluarjan = $pasien_keluar->keluar_januari;
				$los = $lama_rawatjan / $pasien_keluarjan;

					$sheet->SetCellValue('C2', round($los).' '.'Hari');
			

			// TOI
			
				$atasjan = $bawah_jan - $hari_perawatanjan;
				$toi =  $atasjan/$pasien_keluarjan ;
				$sheet->SetCellValue('D2', round($toi).' '.'Hari');
		

			// BTO

			
				$bto = $pasien_keluarjan / $bed;
				$sheet->SetCellValue('E2', round($bto).' '.'Kali');
			

			// NDR

			
				$pasien_meninggal48_jan = $pasien_meninggal_lbh_48->meninggal_lebih48_januari;
				$ndr_jan_blm_permil = $pasien_meninggal48_jan / $pasien_keluarjan;
				$ndr_jan_fix = $ndr_jan_blm_permil * 1000;
				$sheet->SetCellValue('F2', number_format($ndr_jan_fix,2).'‰');

			// GDR

			
				$pasien_meninggal_jan = $pasien_meninggal->meninggal_januari;
				$gdr_jan_blm_permil = $pasien_meninggal_jan / $pasien_keluarjan;
				$gdr_jan_fix = $gdr_jan_blm_permil * 1000;
				$sheet->SetCellValue('G2', number_format($gdr_jan_fix,2).'‰');
			



// FEBRUARI
			$sheet->SetCellValue('A3', 'FEBRUARI');
			$jumHarifeb = cal_days_in_month(CAL_GREGORIAN, 2, $tahun_now);
			$bulan_feb = $tahun_now.'-'.'02';

			// bor

			
				$hari_perawatanfeb = $hari_perawatan->hp_februari;
				$bawahfeb =  $bed*$jumHarifeb;
				$bor_blm_persen_feb =  $hari_perawatanfeb / $bawahfeb;
				$bor_fix_feb = $bor_blm_persen_feb * 100;
					$sheet->SetCellValue('B3',number_format($bor_fix_feb,2).'%');
			

			// los
		
				$lama_rawat_feb = $lama_perawatan->lamrat_februari;
				$pasien_keluar_feb = $pasien_keluar->keluar_februari;
				$los_feb = $lama_rawat_feb / $pasien_keluar_feb;
				$sheet->SetCellValue('C3', round($los_feb).' '.'Hari');
			

			// toi

			
				$atas_feb = $bawahfeb - $hari_perawatanfeb;
				$toi_feb =  $atas_feb/$pasien_keluar_feb ;
				$sheet->SetCellValue('D3', round($toi_feb).' '.'Hari');
		

			// bto

			
				$bto_feb = $pasien_keluar_feb / $bed;
				$sheet->SetCellValue('E3', round($bto_feb).' '.'kali');
			

			// NDR

			
				$pasien_meninggal48_feb = $pasien_meninggal_lbh_48->meninggal_lebih48_februari;
				$ndr_feb_blm_permil = $pasien_meninggal48_feb / $pasien_keluar_feb;
				$ndr_feb_fix = $ndr_feb_blm_permil * 1000;
				$sheet->SetCellValue('F3', number_format($ndr_feb_fix,2).'‰');
			

			// GDR

		
				$pasien_meninggal_feb = $pasien_meninggal->meninggal_februari;
				$gdr_feb_blm_permil = $pasien_meninggal_feb / $pasien_keluar_feb;
				$gdr_feb_fix = $gdr_feb_blm_permil * 1000;
				$sheet->SetCellValue('G3', number_format($gdr_feb_fix,2).'‰');
		


// MARET

			$jumHarimar = cal_days_in_month(CAL_GREGORIAN, 3, $tahun_now);
			$bulan_maret = $tahun_now.'-'.'03';
			$sheet->SetCellValue('A4', 'MARET');

			// bor
		
				$hari_perawatan_mar = $hari_perawatan->hp_maret;
				$bawah_mar =  $bed*$jumHarimar;
				$bor_blm_persen_mar =  $hari_perawatan_mar / $bawah_mar;
				$bor_fix_mar = $bor_blm_persen_mar * 100;
				$sheet->SetCellValue('B4',number_format($bor_fix_mar,2).'%');
		

			// los

			
				$lama_rawat_mar = $lama_perawatan->lamrat_maret;
				$pasien_keluar_mar = $pasien_keluar->keluar_maret;
				$los_mar = $lama_rawat_mar / $pasien_keluar_mar;
				$sheet->SetCellValue('C4', round($los_mar).' '.'Hari');
		

			// toi
			
				$atas_mar = $bawah_mar - $hari_perawatan_mar;
				$toi_mar =  $atas_mar/$pasien_keluar_mar ;
				$sheet->SetCellValue('D4', round($toi_mar).' '.'Hari');
	

			// bto
			
				$bto_mar = $pasien_keluar_mar / $bed;
				$sheet->SetCellValue('E4', round($bto_mar).' '.'kali');
		

			// NDR

			
				$pasien_meninggal48_mar = $pasien_meninggal_lbh_48->meninggal_lebih48_maret;
				$ndr_mar_blm_permil = $pasien_meninggal48_mar / $pasien_keluar_mar;
				$ndr_mar_fix = $ndr_mar_blm_permil * 1000;
				$sheet->SetCellValue('F4', number_format($ndr_mar_fix,2).'‰');
		

			// GDR

		
				$pasien_meninggal_mar = $pasien_meninggal->meninggal_maret;
				$gdr_mar_blm_permil = $pasien_meninggal_mar / $pasien_keluar_mar;
				$gdr_mar_fix = $gdr_mar_blm_permil * 1000;
				$sheet->SetCellValue('G4', number_format($gdr_mar_fix,2).'‰');
			


// APRIL

			$jumHariapril = cal_days_in_month(CAL_GREGORIAN, 4, $tahun_now);
			$bulan_april = $tahun_now.'-'.'04';
			$sheet->SetCellValue('A5', 'APRIL');

			// BOR

			
				$hari_perawatan_apr = $hari_perawatan->hp_april;
				$bawah_april =  $bed*$jumHariapril;
				$bor_blm_persen_apr =  $hari_perawatan_apr / $bawah_april;
				$bor_fix_april = $bor_blm_persen_apr * 100;
				$sheet->SetCellValue('B5',number_format($bor_fix_april,2).'%');
			

			// los

			
				$lama_rawat_apr = $lama_perawatan->lamrat_april;
				$pasien_keluar_apr = $pasien_keluar->keluar_april;
				$los_apr = $lama_rawat_apr / $pasien_keluar_apr;
				$sheet->SetCellValue('C5', round($los_apr).' '.'Hari');
			

			// toi
		
				$atas_april = $bawah_april - $hari_perawatan_apr;
				$toi_april =  $atas_april/$pasien_keluar_apr ;
				$sheet->SetCellValue('D5', round($toi_april).' '.'Hari');
			

			// bto
			
				$bto_april = $pasien_keluar_apr / $bed;
				$sheet->SetCellValue('E5', round($bto_april).' '.'kali');
			

			// NDR

			
				$pasien_meninggal48_apr = $pasien_meninggal_lbh_48->meninggal_lebih48_april;
				$ndr_apr_blm_permil = $pasien_meninggal48_apr / $pasien_keluar_apr;
				$ndr_apr_fix = $ndr_apr_blm_permil * 1000;
				$sheet->SetCellValue('F5', number_format($ndr_apr_fix,2).'‰');
		

			// GDR

			
				$pasien_meninggal_apr = $pasien_meninggal->meninggal_april;
				$gdr_apr_blm_permil = $pasien_meninggal_apr / $pasien_keluar_apr;
				$gdr_apr_fix = $gdr_apr_blm_permil * 1000;
				$sheet->SetCellValue('G5', number_format($gdr_apr_fix,2).'‰');
		
			
// MEI
			$jumHariMei = cal_days_in_month(CAL_GREGORIAN, 5, $tahun_now);
			$bulan_mei = $tahun_now.'-'.'05';
			$sheet->SetCellValue('A6', 'MEI');
			// bor
		
				$hari_perawatan_mei = $hari_perawatan->hp_mei;
				$bawah_mei =  $bed*$jumHariMei;
				$bor_blm_persen_mei =  $hari_perawatan_mei / $bawah_mei;
				$bor_fix_mei = $bor_blm_persen_mei * 100;
				$sheet->SetCellValue('B6',number_format($bor_fix_mei,2).'%');
			

			// los
		 
				$lama_rawat_mei = $lama_perawatan->lamrat_mei;
				$pasien_keluar_mei = $pasien_keluar->keluar_mei;
				$los_mei = $lama_rawat_mei / $pasien_keluar_mei;
				$sheet->SetCellValue('C6',round($los_mei,2).'Hari');
		

			// toi
		
				$atas_mei = $bawah_mei - $hari_perawatan_mei;
				$toi_mei =  $atas_mei/$pasien_keluar_mei ;
				$sheet->SetCellValue('D6', round($toi_mei).' '.'Hari');
			

			// bto
		
				$bto_mei = $pasien_keluar_mei / $bed;
				$sheet->SetCellValue('E6', round($bto_mei).' '.'kali');
			

			// NDR

			
				$pasien_meninggal48_mei = $pasien_meninggal_lbh_48->meninggal_lebih48_mei;
				$ndr_mei_blm_permil = $pasien_meninggal48_mei / $pasien_keluar_mei;
				$ndr_mei_fix = $ndr_mei_blm_permil * 1000;
				$sheet->SetCellValue('F6', number_format($ndr_mei_fix,2).'‰');
		

			// GDR

			
				$pasien_meninggal_mei = $pasien_meninggal->meninggal_mei;
				$gdr_mei_blm_permil = $pasien_meninggal_mei / $pasien_keluar_mei;
				$gdr_mei_fix = $gdr_mei_blm_permil * 1000;
				$sheet->SetCellValue('G6', number_format($gdr_mei_fix,2).'‰');
			

// JUNI

			$jumHariJuni = cal_days_in_month(CAL_GREGORIAN, 6, $tahun_now);
			$bulan_juni = $tahun_now.'-'.'06';
			$sheet->SetCellValue('A7', 'JUNI');
			// bor
		
				$hari_perawatan_jun = $hari_perawatan->hp_juni;
				$bawah_juni =  $bed*$jumHariJuni;
				$bor_blm_persen_juni =  $hari_perawatan_jun / $bawah_juni;
				$bor_fix_juni = $bor_blm_persen_juni * 100;
				$sheet->SetCellValue('B7',number_format($bor_fix_juni,2).'%');
		
			// los
			
				$lama_rawat_juni = $lama_perawatan->lamrat_juni;
				$pasien_keluar_juni = $pasien_keluar->keluar_juni;
				$los_juni = $lama_rawat_juni / $pasien_keluar_juni;
				$sheet->SetCellValue('C7',round($los_juni,2).'Hari');
			
			// toi
			
				$atas_juni = $bawah_juni - $hari_perawatan_jun;
				$toi_juni =  $atas_juni/$pasien_keluar_juni ;
				$sheet->SetCellValue('D7', round($toi_juni).' '.'Hari');
		
			// bto
		
				$bto_juni = $pasien_keluar_juni / $bed;
				$sheet->SetCellValue('E7', round($bto_juni).' '.'kali');
			

			
			// NDR

			
				$pasien_meninggal48_jun = $pasien_meninggal_lbh_48->meninggal_lebih48_juni;
				$ndr_jun_blm_permil = $pasien_meninggal48_jun / $pasien_keluar_juni;
				$ndr_jun_fix = $ndr_jun_blm_permil * 1000;
				$sheet->SetCellValue('F7', number_format($ndr_jun_fix,2).'‰');
		

			// GDR

			
				$pasien_meninggal_jun = $pasien_meninggal->meninggal_juni;
				$gdr_jun_blm_permil = $pasien_meninggal_jun / $pasien_keluar_juni;
				$gdr_jun_fix = $gdr_jun_blm_permil * 1000;
				$sheet->SetCellValue('G7', number_format($gdr_jun_fix,2).'‰');
			

// JULI
			$jumHariJuli = cal_days_in_month(CAL_GREGORIAN, 7, $tahun_now);
			$bulan_juli = $tahun_now.'-'.'07';
			$sheet->SetCellValue('A8', 'JULI');
			// bor
		
				$hari_perawatan_juli = $hari_perawatan->hp_juli;
				$bawah_juli =  $bed*$jumHariJuli;
				$bor_blm_persen_juli =  $hari_perawatan_juli / $bawah_juli;
				$bor_fix_juli = $bor_blm_persen_juli * 100;
				$sheet->SetCellValue('B8',number_format($bor_fix_juli,2).'%');
		

			// los
		
				$lama_rawat_juli = $lama_perawatan->lamrat_juli;
				$pasien_keluar_juli = $pasien_keluar->keluar_juli;
				$los_juli = $lama_rawat_juli / $pasien_keluar_juli;
				$sheet->SetCellValue('C8',round($los_juli,2).'Hari');
		
			// toi
		
				$atas_juli = $bawah_juli - $hari_perawatan_juli;
				$toi_juli =  $atas_juli/$pasien_keluar_juli ;
				$sheet->SetCellValue('D8', round($toi_juli).' '.'Hari');
		
			// bto
			
				$bto_juli = $pasien_keluar_juli / $bed;
				$sheet->SetCellValue('E8', round($bto_juli).' '.'kali');
		

			// NDR

			
				$pasien_meninggal48_jul = $pasien_meninggal_lbh_48->meninggal_lebih48_juli;
				$ndr_jul_blm_permil = $pasien_meninggal48_jul / $pasien_keluar_juli;
				$ndr_jul_fix = $ndr_jul_blm_permil * 1000;
				$sheet->SetCellValue('F8', number_format($ndr_jul_fix,2).'‰');
		

			// GDR

		
				$pasien_meninggal_jul = $pasien_meninggal->meninggal_juli;
				$gdr_jul_blm_permil = $pasien_meninggal_jul / $pasien_keluar_juli;
				$gdr_jul_fix = $gdr_jul_blm_permil * 1000;
				$sheet->SetCellValue('G8', number_format($gdr_jul_fix,2).'‰');
			

// AGUSTUS
			$jumHariAgustus = cal_days_in_month(CAL_GREGORIAN, 8, $tahun_now);
            $bulan_agus = $tahun_now.'-'.'08';
			$sheet->SetCellValue('A9', 'AGUSTUS');
			// bor
		
				$hari_perawatan_agus = $hari_perawatan->hp_agustus;
				$bawah_agus =  $bed*$jumHariAgustus;
				$bor_blm_persen_agus =  $hari_perawatan_agus / $bawah_agus;
				$bor_fix_agus = $bor_blm_persen_agus * 100;
				$sheet->SetCellValue('B9',number_format($bor_fix_agus,2).'%');
		
			// los
		
				$lama_rawat_agus = $lama_perawatan->lamrat_agustus;
				$pasien_keluar_agus = $pasien_keluar->keluar_agustus;
				$los_agus = $lama_rawat_agus / $pasien_keluar_agus;
				$sheet->SetCellValue('C9',round($los_agus,2).'Hari');
		
			// toi
			
				$atas_agus = $bawah_agus - $hari_perawatan_agus;
				$toi_agus =  $atas_agus/$pasien_keluar_agus ;
				$sheet->SetCellValue('D9', round($toi_agus).' '.'Hari');
			
			// bto
		
				$bto_agus = $pasien_keluar_agus / $bed;
				$sheet->SetCellValue('E9', round($bto_agus).' '.'kali');
			

			// NDR

		
				$pasien_meninggal48_agus = $pasien_meninggal_lbh_48->meninggal_lebih48_agustus;
				$ndr_agus_blm_permil = $pasien_meninggal48_agus / $pasien_keluar_agus;
				$ndr_agus_fix = $ndr_agus_blm_permil * 1000;
				$sheet->SetCellValue('F9', number_format($ndr_agus_fix,2).'‰');
			

			// GDR

			
				$pasien_meninggal_agus = $pasien_meninggal->meninggal_agustus;
				$gdr_agus_blm_permil = $pasien_meninggal_agus / $pasien_keluar_agus;
				$gdr_agus_fix = $gdr_agus_blm_permil * 1000;
				$sheet->SetCellValue('G9', number_format($gdr_agus_fix,2).'‰');
		

// SEPTEMBER
			$jumHarisep = cal_days_in_month(CAL_GREGORIAN, 9, $tahun_now);
			$bulan_sep = $tahun_now.'-'.'09';
			$sheet->SetCellValue('A10', 'SEPTEMBER');
			// bor
		
				$hari_perawatan_sep = $hari_perawatan->hp_september;
				$bawah_sep =  $bed*$jumHarisep;
				$bor_blm_persen_sep =  $hari_perawatan_sep / $bawah_sep;
				$bor_fix_sep = $bor_blm_persen_sep * 100;
				$sheet->SetCellValue('B10',number_format($bor_fix_sep,2).'%');
			
			// los
			
				$lama_rawat_sep = $lama_perawatan->lamrat_september;
				$pasien_keluar_sep = $pasien_keluar->keluar_september;
				$los_sep = $lama_rawat_sep / $pasien_keluar_sep;
				$sheet->SetCellValue('C10',round($los_sep,2).'Hari');
		
			// toi
			
				$atas_sep = $bawah_sep - $hari_perawatan_sep;
				$toi_sep =  $atas_sep/$pasien_keluar_sep ;
				$sheet->SetCellValue('D10', round($toi_sep).' '.'Hari');
		
			// bto
		
				$bto_sep = $pasien_keluar_sep / $bed;
				$sheet->SetCellValue('E10', round($bto_sep).' '.'kali');
		
			// NDR

			
				$pasien_meninggal48_sep = $pasien_meninggal_lbh_48->meninggal_lebih48_september;
				$ndr_sep_blm_permil = $pasien_meninggal48_sep / $pasien_keluar_sep;
				$ndr_sep_fix = $ndr_sep_blm_permil * 1000;
				$sheet->SetCellValue('F10', number_format($ndr_sep_fix,2).'‰');
			

			// GDR

		
				$pasien_meninggal_sep = $pasien_meninggal->meninggal_september;
				$gdr_sep_blm_permil = $pasien_meninggal_sep / $pasien_keluar_sep;
				$gdr_sep_fix = $gdr_sep_blm_permil * 1000;
				$sheet->SetCellValue('G10', number_format($gdr_sep_fix,2).'‰');
			

// OKTOBER
			$jumHariokt = cal_days_in_month(CAL_GREGORIAN, 10, $tahun_now);
			$bulan_okt = $tahun_now.'-'.'10';
			$sheet->SetCellValue('A11', 'OKTOBER');
			// bor
			
				$hari_perawatan_okt = $hari_perawatan->hp_oktober;
				$bawah_okt =  $bed*$jumHariokt;
				$bor_blm_persen_okt =  $hari_perawatan_okt / $bawah_okt;
				$bor_fix_okt = $bor_blm_persen_okt * 100;
				$sheet->SetCellValue('B11',number_format($bor_fix_okt,2).'%');
		
			// los
		
				$lama_rawat_okt = $lama_perawatan->lamrat_oktober;
				$pasien_keluar_okt = $pasien_keluar->keluar_oktober;
				$los_okt = $lama_rawat_okt / $pasien_keluar_okt;
				$sheet->SetCellValue('C11',round($los_okt,2).'Hari');
			
			// toi
			
				$atas_okt = $bawah_okt - $hari_perawatan_okt;
				$toi_okt =  $atas_okt/$pasien_keluar_okt ;
				$sheet->SetCellValue('D11', round($toi_okt).' '.'Hari');
		
			// bto
		
				$bto_okt = $pasien_keluar_okt / $bed;
				$sheet->SetCellValue('E11', round($bto_okt).' '.'kali');
			

			// NDR

			
				$pasien_meninggal48_okt = $pasien_meninggal_lbh_48->meninggal_lebih48_okt;
				$ndr_okt_blm_permil = $pasien_meninggal48_okt / $pasien_keluar_okt;
				$ndr_okt_fix = $ndr_okt_blm_permil * 1000;
				$sheet->SetCellValue('F11', number_format($ndr_okt_fix,2).'‰');
			

			// GDR

			
				$pasien_meninggal_okt = $pasien_meninggal->meninggal_okt;
				$gdr_okt_blm_permil = $pasien_meninggal_okt / $pasien_keluar_okt;
				$gdr_okt_fix = $gdr_okt_blm_permil * 1000;
				$sheet->SetCellValue('G11', number_format($gdr_okt_fix,2).'‰');
		

// november
			$jumHariNov = cal_days_in_month(CAL_GREGORIAN, 11, $tahun_now);
			$bulan_nov = $tahun_now.'-'.'11';
			$sheet->SetCellValue('A12', 'NOVEMBER');
			// bor
		
				$hari_perawatan_nov = $hari_perawatan->hp_november;
				$bawah_nov =  $bed*$jumHariNov;
				$bor_blm_persen_nov =  $hari_perawatan_nov / $bawah_nov;
				$bor_fix_nov = $bor_blm_persen_nov * 100;
				$sheet->SetCellValue('B12',number_format($bor_fix_nov,2).'%');
		
			// los
			
				$lama_rawat_nov = $lama_perawatan->lamrat_november;
				$pasien_keluar_nov = $pasien_keluar->keluar_november;
				$los_nov = $lama_rawat_nov / $pasien_keluar_nov;
				$sheet->SetCellValue('C12',round($los_nov,2).'Hari');
			
			// toi
			
				$atas_nov = $bawah_nov - $hari_perawatan_nov;
				$toi_nov =  $atas_nov/$pasien_keluar_nov ;
				$sheet->SetCellValue('D12', round($toi_nov).' '.'Hari');
		
			// bto
			
				$bto_nov = $pasien_keluar_nov / $bed;
				$sheet->SetCellValue('E12', round($bto_nov).' '.'kali');
		

			// NDR

			
				$pasien_meninggal48_nov = $pasien_meninggal_lbh_48->meninggal_lebih48_nov;
				$ndr_nov_blm_permil = $pasien_meninggal48_nov / $pasien_keluar_nov;
				$ndr_nov_fix = $ndr_nov_blm_permil * 1000;
				$sheet->SetCellValue('F12', number_format($ndr_nov_fix,2).'‰');
			

			// GDR

			
				$pasien_meninggal_nov = $pasien_meninggal->meninggal_nov;
				$gdr_nov_blm_permil = $pasien_meninggal_nov / $pasien_keluar_nov;
				$gdr_nov_fix = $gdr_nov_blm_permil * 1000;
				$sheet->SetCellValue('G12', number_format($gdr_nov_fix,2).'‰');
		


// DESEMBER
			$jumHariDes = cal_days_in_month(CAL_GREGORIAN, 12, $tahun_now);
			$bulan_des = $tahun_now.'-'.'12';
			$sheet->SetCellValue('A13', 'DESEMBER');
			// bor
			
				$hari_perawatan_des = $hari_perawatan->hp_desember;
				$bawah_des =  $bed*$jumHariDes;
				$bor_blm_persen_des =  $hari_perawatan_des / $bawah_des;
				$bor_fix_des = $bor_blm_persen_des * 100;
				$sheet->SetCellValue('B13',number_format($bor_fix_des,2).'%');
			
			// los
			
				$lama_rawat_des = $lama_perawatan->lamrat_desember;
				$pasien_keluar_des = $pasien_keluar->keluar_desember;
				$los_des = $lama_rawat_des / $pasien_keluar_des;
				$sheet->SetCellValue('C13',round($los_des,2).'Hari');
			
			// toi
			
				$atas_des = $bawah_des - $hari_perawatan_des;
				$toi_des =  $atas_des/$pasien_keluar_des ;
				$sheet->SetCellValue('D13', round($toi_des).' '.'Hari');
			
			// bto
			
				$bto_des = $pasien_keluar_des / $bed;
				$sheet->SetCellValue('E13', round($bto_des).' '.'kali');
			

			// NDR

			
				$pasien_meninggal48_des = $pasien_meninggal_lbh_48->meninggal_lebih48_des;
				$ndr_des_blm_permil = $pasien_meninggal48_des / $pasien_keluar_des;
				$ndr_des_fix = $ndr_des_blm_permil * 1000;
				$sheet->SetCellValue('F13', number_format($ndr_des_fix,2).'‰');
			

			// GDR

			
				$pasien_meninggal_des = $pasien_meninggal->meninggal_des;
				$gdr_des_blm_permil = $pasien_meninggal_des / $pasien_keluar_des;
				$gdr_des_fix = $gdr_des_blm_permil * 1000;
				$sheet->SetCellValue('G13', number_format($gdr_des_fix,2).'‰');
		


			// ob_end_clean();
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan BOR LOS TOI'.' '.$thn;
			//ob_end_clean();
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}

		function bor_los_toi_new(){
			$data['datanya'] = $this->input->post();
			if($data['datanya'] != ''){
			 	$bulan = $this->input->post('bulan');
				 $data['bulannow'] = $bulan;
			 	$data['pasien_awal'] = $this->Rjmlaporan->get_pasien_awal_borlostoi($bulan)->row();
				$data['pasien_masuk'] = $this->Rjmlaporan->get_pasien_masuk_borlostoi($bulan)->row();
				$data['pasien_keluar_pindah'] = $this->Rjmlaporan->get_pasien_pindah_borlostoi($bulan)->row();
				$data['pasien_masuk_pindah'] = $this->Rjmlaporan->get_jumlah_pasien_masuk_pindah($bulan)->row();
				$data['pasien_keluar_hidup'] = $this->Rjmlaporan->get_pasien_keluar_hidup_borlostoi($bulan)->row();
				$data['pasien_keluar_mati'] = $this->Rjmlaporan->get_pasien_keluar_mati_borlostoi($bulan)->row();
				$data['pasien_keluar_hidup_mati'] = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_borlostoi($bulan)->row();
				$data['pasien_mati_kurang48'] = $this->Rjmlaporan->get_pasien_mati_kurang48_borlostoi($bulan)->row();
				$data['pasien_mati_lebih48'] = $this->Rjmlaporan->get_pasien_mati_lebih48_borlostoi($bulan)->row();
				$data['lama_rawat'] = $this->Rjmlaporan->get_lama_rawat_borlostoi($bulan)->row();
				$data['tt_vip'] = $this->Rjmlaporan->get_jumlah_tt_vip()->row();
				$data['tt_satu'] = $this->Rjmlaporan->get_jumlah_tt_satu()->row();
				$data['tt_dua'] = $this->Rjmlaporan->get_jumlah_tt_dua()->row();
				$data['tt_tiga'] = $this->Rjmlaporan->get_jumlah_tt_tiga()->row();
				$data['hari_perawatan'] = $this->Rjmlaporan->get_jumlah_hari_perawatan($bulan)->row();
				$data['hari_perawatan_vip'] = $this->Rjmlaporan->get_jumlah_hari_perawatan_vip($bulan)->row();
				$data['hari_perawatan_satu'] = $this->Rjmlaporan->get_jumlah_hari_perawatan_satu($bulan)->row();
				$data['hari_perawatan_dua'] = $this->Rjmlaporan->get_jumlah_hari_perawatan_dua($bulan)->row();
				$data['hari_perawatan_tiga'] = $this->Rjmlaporan->get_jumlah_hari_perawatan_tiga($bulan)->row();
				$this->load->view('irj/bor_los_toi_search', $data);
			}else{
				$this->load->view('irj/bor_los_toi_search', $data);
			}
			
		}

		function bor_los_toi_ruangan(){
			$data['datanya'] = $this->input->post();
			if($data['datanya'] != ''){
				$data['bulan_now'] = $this->input->post('bulan');
				$data['bln'] = $data['bulan_now'];
				$data['pasien_awal_all_ruangan'] = $this->Rjmlaporan->get_pasien_awal_borlostoi($data['bulan_now'])->row();
				$data['get_tt_ruangan'] = $this->Rjmlaporan->get_tt_perbulan($data['bulan_now'])->result();
				$this->load->view('irj/bor_los_toi_new',$data);
			}else{
				$this->load->view('irj/bor_los_toi_new');
			}

		}

		function bor_los_toi_ruangan_excel($bulan_now){
			if($bulan_now != ''){
				$pasien_awal_all_ruangan = $this->Rjmlaporan->get_pasien_awal_borlostoi($bulan_now)->row();
				$get_tt_ruangan = $this->Rjmlaporan->get_tt_perbulan($bulan_now)->result();
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet(); 

				// LIMPAPEH L2

				$sheet->mergeCells('F1:I1')
				->getCell('F1')
				->setValue('PELAYANAN RAWAT INAP LIMPAPEH L2');

				$sheet->SetCellValue('A2','Tanggal');
				$sheet->SetCellValue('B2','Pasien Awal');
				$sheet->SetCellValue('C2','Pasien Masuk');
				$sheet->SetCellValue('D2','Pasien Pindah');
				$sheet->SetCellValue('E2','Jumlah Pend Dirawat');
				$sheet->mergeCells('F2:I2')
				->getCell('F2')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J2','Pasien Keluar H + M');
				$sheet->mergeCells('K2:L2')
				->getCell('K2')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M2','Total Lama dirawat');
				$sheet->SetCellValue('N2','Jumlah Hari Rawatan');
				$sheet->mergeCells('O2:R2')
				->getCell('O2')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F3','Di pindahkan');
				$sheet->SetCellValue('G3','Hidup');
				$sheet->SetCellValue('H3','Mati');
				$sheet->SetCellValue('I3','Total');
				$sheet->SetCellValue('K3','< 48 Jam');
				$sheet->SetCellValue('L3','≥ 48 Jam');
				$sheet->SetCellValue('O3','VIP');
				$sheet->SetCellValue('P3','I');
				$sheet->SetCellValue('Q3','II');
				$sheet->SetCellValue('R3','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_limpapeh_l2 = "idrg = '0801'";
				$total_pasien_awal = 0;
				$total_pasien_masuk = 0;
				$total_pasien_masuk_pindah = 0;
				$total_pasien_dirawat_all = 0;
				$total_pasien_keluar_pindah = 0;
				$total_pasien_keluar_hidup = 0;
				$total_pasien_keluar_mati = 0;
				$total_pasien_keluar_all = 0;
				$total_pasien_keluar_hidup_mati = 0;
				$total_pasien_mati_krg48= 0;
				$total_pasien_mati_lbh48 = 0;
				$total_lama_rawat = 0;
				$total_hari_rawat = 0;
				$total_hari_rawat_vip = 0;
				$total_hari_rawat_satu = 0;
				$total_hari_rawat_dua = 0;
				$total_hari_rawat_tiga = 0;

				$rowCount = 4;
				for ($i=1; $i < $tanggal+1; $i++) {
					$index = $rowCount++;
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$pasien_awal = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_masuk = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_masuk_pindah = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_keluar_pindah = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_keluar_hidup = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_keluar_mati = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_keluar_hidup_mati = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_mati_krg_48 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$pasien_mati_lbh_48 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$lama_rawat = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$hari_rawat = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l2)->row();
					$hari_rawat_vip = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l2)->row();
					$hari_rawat_satu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l2)->row();
					$hari_rawat_dua = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l2)->row();
					$hari_rawat_tiga = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l2)->row();
				   
					$sheet->SetCellValue('A'.$index, $i);
					$sheet->SetCellValue('B'.$index, $pasien_awal->jml);
					$sheet->SetCellValue('C'.$index, $pasien_masuk->jml);
					$sheet->SetCellValue('D'.$index, $pasien_masuk_pindah->jml);
			
                    $total_pasien_dirawat = $pasien_awal->jml + $pasien_masuk->jml + $pasien_masuk_pindah->jml;
                                 
					$sheet->SetCellValue('E'.$index, $total_pasien_dirawat);
					$sheet->SetCellValue('F'.$index, $pasien_keluar_pindah->jml);
					$sheet->SetCellValue('G'.$index, $pasien_keluar_hidup->jml);
					$sheet->SetCellValue('H'.$index, $pasien_keluar_mati->jml);
					$total_pasien_keluar = $pasien_keluar_pindah->jml + $pasien_keluar_hidup->jml + $pasien_keluar_mati->jml;
					$sheet->SetCellValue('I'.$index, $total_pasien_keluar);
					$sheet->SetCellValue('J'.$index, $pasien_keluar_hidup_mati->jml);
					$sheet->SetCellValue('K'.$index, $pasien_mati_krg_48->jml );
					$sheet->SetCellValue('L'.$index, $pasien_mati_lbh_48->jml);
					$sheet->SetCellValue('M'.$index, $lama_rawat->jml);
					if($i <= date('j')){
						$harirawat = $hari_rawat->jml;
						$harirawat_vip = $hari_rawat_vip->jml;
						$harirawat_satu = $hari_rawat_satu->jml;
						$harirawat_dua = $hari_rawat_dua->jml;
						$harirawat_tiga = $hari_rawat_tiga->jml;
					}else{
						$harirawat = 0;
						$harirawat_vip = 0;
						$harirawat_satu = 0;
						$harirawat_dua = 0;
						$harirawat_tiga = 0;
					}
					$sheet->SetCellValue('N'.$index,$harirawat);
					$sheet->SetCellValue('O'.$index,$harirawat_vip);
					$sheet->SetCellValue('P'.$index,$harirawat_satu);
					$sheet->SetCellValue('Q'.$index,$harirawat_dua);
					$sheet->SetCellValue('R'.$index,$harirawat_tiga);

					$total_pasien_awal += $pasien_awal->jml;
					$total_pasien_masuk += $pasien_masuk->jml;
					$total_pasien_masuk_pindah += $pasien_masuk_pindah->jml;
					$total_pasien_keluar_pindah += $pasien_keluar_pindah->jml;
					$total_pasien_dirawat_all += $total_pasien_dirawat;
					$total_pasien_keluar_pindah += $pasien_keluar_pindah->jml;
					$total_pasien_keluar_mati += $pasien_keluar_mati->jml;
					$total_pasien_keluar_hidup += $pasien_keluar_hidup->jml;
					$total_pasien_keluar_all += $total_pasien_keluar;
					$total_pasien_keluar_hidup_mati += $pasien_keluar_hidup_mati->jml;
					$total_pasien_mati_krg48 += $pasien_mati_krg_48->jml;
					$total_pasien_mati_lbh48 += $pasien_mati_lbh_48->jml;
					$total_lama_rawat += $lama_rawat->jml;
					$total_hari_rawat += $harirawat;
					$total_hari_rawat_vip += $harirawat_vip;
					$total_hari_rawat_satu += $harirawat_satu;
					$total_hari_rawat_dua += $harirawat_dua;
					$total_hari_rawat_tiga += $harirawat_tiga;

				}

				// LIMPAPEH L3 
				$sheet->mergeCells('F38:I38')
				->getCell('F38')
				->setValue('PELAYANAN RAWAT INAP LIMPAPEH L3');

				$sheet->SetCellValue('A39','Tanggal');
				$sheet->SetCellValue('B39','Pasien Awal');
				$sheet->SetCellValue('C39','Pasien Masuk');
				$sheet->SetCellValue('D39','Pasien Pindah');
				$sheet->SetCellValue('E39','Jumlah Pend Dirawat');
				$sheet->mergeCells('F39:I39')
				->getCell('F39')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J39','Pasien Keluar H + M');
				$sheet->mergeCells('K39:L39')
				->getCell('K39')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M39','Total Lama dirawat');
				$sheet->SetCellValue('N39','Jumlah Hari Rawatan');
				$sheet->mergeCells('O39:R39')
				->getCell('O39')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F40','Di pindahkan');
				$sheet->SetCellValue('G40','Hidup');
				$sheet->SetCellValue('H40','Mati');
				$sheet->SetCellValue('I40','Total');
				$sheet->SetCellValue('K40','< 48 Jam');
				$sheet->SetCellValue('L40','≥ 48 Jam');
				$sheet->SetCellValue('O40','VIP');
				$sheet->SetCellValue('P40','I');
				$sheet->SetCellValue('Q40','II');
				$sheet->SetCellValue('R40','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_limpapeh_l3 = "idrg IN ('0802','0804')";
				$total_pasien_awal_limpapeh_l3 = 0;
				$total_pasien_masuk_limpapeh_l3 = 0;
				$total_pasien_masuk_pindah_limpapeh_l3 = 0;
				$total_pasien_dirawat_all_limpapeh_l3 = 0;
				$total_pasien_keluar_pindah_limpapeh_l3 = 0;
				$total_pasien_keluar_hidup_limpapeh_l3 = 0;
				$total_pasien_keluar_mati_limpapeh_l3 = 0;
				$total_pasien_keluar_all_limpapeh_l3 = 0;
				$total_pasien_keluar_hidup_mati_limpapeh_l3 = 0;
				$total_pasien_mati_krg48_limpapeh_l3= 0;
				$total_pasien_mati_lbh48_limpapeh_l3 = 0;
				$total_lama_rawat_limpapeh_l3 = 0;
				$total_hari_rawat_limpapeh_l3 = 0;
				$total_hari_rawat_vip_limpapeh_l3 = 0;
				$total_hari_rawat_satu_limpapeh_l3 = 0;
				$total_hari_rawat_dua_limpapeh_l3 = 0;
				$total_hari_rawat_tiga_limpapeh_l3 = 0;

				$rowCountlimpapehl3 = 41;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$indexlimpapehl3 = $rowCountlimpapehl3++;
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$pasien_awal_limpapeh_l3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_masuk_limpapeh_l3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_masuk_pindah_limpapeh_l3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_keluar_pindah_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_keluar_hidup_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_keluar_mati_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_keluar_hidup_mati_limpapeh_l3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_mati_krg_48_limpapeh_l3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$pasien_mati_lbh_48_limpapeh_l3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$lama_rawat_limpapeh_l3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$hari_rawat_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l3)->row();
					$hari_rawat_vip_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l3)->row();
					$hari_rawat_satu_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l3)->row();
					$hari_rawat_dua_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l3)->row();
					$hari_rawat_tiga_limpapeh_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l3)->row();

					$sheet->SetCellValue('A'.$indexlimpapehl3, $i);
					$sheet->SetCellValue('B'.$indexlimpapehl3, $pasien_awal_limpapeh_l3->jml);
					$sheet->SetCellValue('C'.$indexlimpapehl3, $pasien_masuk_limpapeh_l3->jml);
					$sheet->SetCellValue('D'.$indexlimpapehl3, $pasien_masuk_pindah_limpapeh_l3->jml);
			
					$total_pasien_dirawat_limpapeh_l3 = $pasien_awal_limpapeh_l3->jml + $pasien_masuk_limpapeh_l3->jml + $pasien_masuk_pindah_limpapeh_l3->jml;
                                 
					$sheet->SetCellValue('E'.$indexlimpapehl3, $total_pasien_dirawat_limpapeh_l3);
					$sheet->SetCellValue('F'.$indexlimpapehl3, $pasien_keluar_pindah_limpapeh_l3->jml);
					$sheet->SetCellValue('G'.$indexlimpapehl3, $pasien_keluar_hidup_limpapeh_l3->jml);
					$sheet->SetCellValue('H'.$indexlimpapehl3, $pasien_keluar_mati_limpapeh_l3->jml);
					$total_pasien_keluar_limpapeh_l3 = $pasien_keluar_pindah_limpapeh_l3->jml + $pasien_keluar_hidup_limpapeh_l3->jml + $pasien_keluar_mati_limpapeh_l3->jml;
					$sheet->SetCellValue('I'.$indexlimpapehl3, $total_pasien_keluar_limpapeh_l3);
					$sheet->SetCellValue('J'.$indexlimpapehl3, $pasien_keluar_hidup_mati_limpapeh_l3->jml);
					$sheet->SetCellValue('K'.$indexlimpapehl3, $pasien_mati_krg_48_limpapeh_l3->jml );
					$sheet->SetCellValue('L'.$indexlimpapehl3, $pasien_mati_lbh_48_limpapeh_l3->jml);
					$sheet->SetCellValue('M'.$indexlimpapehl3, $lama_rawat_limpapeh_l3->jml);
					if($i <= date('j')){
						$harirawat_limpapeh_l3 = $hari_rawat_limpapeh_l3->jml;
						$harirawat_vip_limpapeh_l3 = $hari_rawat_vip_limpapeh_l3->jml;
						$harirawat_satu_limpapeh_l3 = $hari_rawat_satu_limpapeh_l3->jml;
						$harirawat_dua_limpapeh_l3 = $hari_rawat_dua_limpapeh_l3->jml;
						$harirawat_tiga_limpapeh_l3 = $hari_rawat_tiga_limpapeh_l3->jml;
					}else{
						$harirawat_limpapeh_l3 = 0;
						$harirawat_vip_limpapeh_l3 = 0;
						$harirawat_satu_limpapeh_l3 = 0;
						$harirawat_dua_limpapeh_l3 = 0;
						$harirawat_tiga_limpapeh_l3 = 0;
					}
					$sheet->SetCellValue('N'.$indexlimpapehl3,$harirawat_limpapeh_l3);
					$sheet->SetCellValue('O'.$indexlimpapehl3,$harirawat_vip_limpapeh_l3);
					$sheet->SetCellValue('P'.$indexlimpapehl3,$harirawat_satu_limpapeh_l3);
					$sheet->SetCellValue('Q'.$indexlimpapehl3,$harirawat_dua_limpapeh_l3);
					$sheet->SetCellValue('R'.$indexlimpapehl3,$harirawat_tiga_limpapeh_l3);

					$total_pasien_awal_limpapeh_l3 += $pasien_awal_limpapeh_l3->jml;
					$total_pasien_masuk_limpapeh_l3 += $pasien_masuk_limpapeh_l3->jml;
					$total_pasien_masuk_pindah_limpapeh_l3 += $pasien_masuk_pindah_limpapeh_l3->jml;
					$total_pasien_dirawat_all_limpapeh_l3 += $total_pasien_dirawat_limpapeh_l3;
					$total_pasien_keluar_pindah_limpapeh_l3 += $pasien_keluar_pindah_limpapeh_l3->jml;
					$total_pasien_keluar_mati_limpapeh_l3 += $pasien_keluar_mati_limpapeh_l3->jml;
					$total_pasien_keluar_hidup_limpapeh_l3 += $pasien_keluar_hidup_limpapeh_l3->jml;
					$total_pasien_keluar_all_limpapeh_l3 += $total_pasien_keluar_limpapeh_l3;
					$total_pasien_keluar_hidup_mati_limpapeh_l3 += $pasien_keluar_hidup_mati_limpapeh_l3->jml;
					$total_pasien_mati_krg48_limpapeh_l3 += $pasien_mati_krg_48_limpapeh_l3->jml;
					$total_pasien_mati_lbh48_limpapeh_l3 += $pasien_mati_lbh_48_limpapeh_l3->jml;
					$total_lama_rawat_limpapeh_l3 += $lama_rawat_limpapeh_l3->jml;
					$total_hari_rawat_limpapeh_l3 += $harirawat_limpapeh_l3;
					$total_hari_rawat_vip_limpapeh_l3 += $harirawat_vip_limpapeh_l3;
					$total_hari_rawat_satu_limpapeh_l3 += $harirawat_satu_limpapeh_l3;
					$total_hari_rawat_dua_limpapeh_l3 += $harirawat_dua_limpapeh_l3;
					$total_hari_rawat_tiga_limpapeh_l3 += $harirawat_tiga_limpapeh_l3;
				}

				// LIMPAPEH L4
				$sheet->mergeCells('F75:I75')
				->getCell('F75')
				->setValue('PELAYANAN RAWAT INAP LIMPAPEH L4');

				$sheet->SetCellValue('A76','Tanggal');
				$sheet->SetCellValue('B76','Pasien Awal');
				$sheet->SetCellValue('C76','Pasien Masuk');
				$sheet->SetCellValue('D76','Pasien Pindah');
				$sheet->SetCellValue('E76','Jumlah Pend Dirawat');
				$sheet->mergeCells('F76:I76')
				->getCell('F76')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J76','Pasien Keluar H + M');
				$sheet->mergeCells('K76:L76')
				->getCell('K76')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M76','Total Lama dirawat');
				$sheet->SetCellValue('N76','Jumlah Hari Rawatan');
				$sheet->mergeCells('O76:R76')
				->getCell('O76')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F77','Di pindahkan');
				$sheet->SetCellValue('G77','Hidup');
				$sheet->SetCellValue('H77','Mati');
				$sheet->SetCellValue('I77','Total');
				$sheet->SetCellValue('K77','< 48 Jam');
				$sheet->SetCellValue('L77','≥ 48 Jam');
				$sheet->SetCellValue('O77','VIP');
				$sheet->SetCellValue('P77','I');
				$sheet->SetCellValue('Q77','II');
				$sheet->SetCellValue('R77','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_limpapeh_l4 = "idrg IN ('0803','0805')";
				$total_pasien_awal_limpapeh_l4 = 0;
				$total_pasien_masuk_limpapeh_l4 = 0;
				$total_pasien_masuk_pindah_limpapeh_l4 = 0;
				$total_pasien_dirawat_all_limpapeh_l4 = 0;
				$total_pasien_keluar_pindah_limpapeh_l4 = 0;
				$total_pasien_keluar_hidup_limpapeh_l4 = 0;
				$total_pasien_keluar_mati_limpapeh_l4 = 0;
				$total_pasien_keluar_all_limpapeh_l4 = 0;
				$total_pasien_keluar_hidup_mati_limpapeh_l4 = 0;
				$total_pasien_mati_krg48_limpapeh_l4= 0;
				$total_pasien_mati_lbh48_limpapeh_l4 = 0;
				$total_lama_rawat_limpapeh_l4 = 0;
				$total_hari_rawat_limpapeh_l4 = 0;
				$total_hari_rawat_vip_limpapeh_l4 = 0;
				$total_hari_rawat_satu_limpapeh_l4 = 0;
				$total_hari_rawat_dua_limpapeh_l4 = 0;
				$total_hari_rawat_tiga_limpapeh_l4 = 0;

				$rowCountlimpapehl4 = 78;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$indexlimpapehl4 = $rowCountlimpapehl4++;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$pasien_awal_limpapeh_l4 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_masuk_limpapeh_l4 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_masuk_pindah_limpapeh_l4 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_keluar_pindah_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_keluar_hidup_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_keluar_mati_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_keluar_hidup_mati_limpapeh_l4 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_mati_krg_48_limpapeh_l4 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$pasien_mati_lbh_48_limpapeh_l4 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$lama_rawat_limpapeh_l4 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$hari_rawat_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_limpapeh_l4)->row();
					$hari_rawat_vip_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_limpapeh_l4)->row();
					$hari_rawat_satu_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_limpapeh_l4)->row();
					$hari_rawat_dua_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_limpapeh_l4)->row();
					$hari_rawat_tiga_limpapeh_l4 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_limpapeh_l4)->row();

					$sheet->SetCellValue('A'.$indexlimpapehl4, $i);
					$sheet->SetCellValue('B'.$indexlimpapehl4, $pasien_awal_limpapeh_l4->jml);
					$sheet->SetCellValue('C'.$indexlimpapehl4, $pasien_masuk_limpapeh_l4->jml);
					$sheet->SetCellValue('D'.$indexlimpapehl4, $pasien_masuk_pindah_limpapeh_l4->jml);
			
					$total_pasien_dirawat_limpapeh_l4 = $pasien_awal_limpapeh_l4->jml + $pasien_masuk_limpapeh_l4->jml + $pasien_masuk_pindah_limpapeh_l4->jml;
                                 
					$sheet->SetCellValue('E'.$indexlimpapehl4, $total_pasien_dirawat_limpapeh_l4);
					$sheet->SetCellValue('F'.$indexlimpapehl4, $pasien_keluar_pindah_limpapeh_l4->jml);
					$sheet->SetCellValue('G'.$indexlimpapehl4, $pasien_keluar_hidup_limpapeh_l4->jml);
					$sheet->SetCellValue('H'.$indexlimpapehl4, $pasien_keluar_mati_limpapeh_l4->jml);
					$total_pasien_keluar_limpapeh_l4 = $pasien_keluar_pindah_limpapeh_l4->jml + $pasien_keluar_hidup_limpapeh_l4->jml + $pasien_keluar_mati_limpapeh_l4->jml;
					$sheet->SetCellValue('I'.$indexlimpapehl4, $total_pasien_keluar_limpapeh_l4);
					$sheet->SetCellValue('J'.$indexlimpapehl4, $pasien_keluar_hidup_mati_limpapeh_l4->jml);
					$sheet->SetCellValue('K'.$indexlimpapehl4, $pasien_mati_krg_48_limpapeh_l4->jml );
					$sheet->SetCellValue('L'.$indexlimpapehl4, $pasien_mati_lbh_48_limpapeh_l4->jml);
					$sheet->SetCellValue('M'.$indexlimpapehl4, $lama_rawat_limpapeh_l4->jml);
					if($i <= date('j')){
						$harirawat_limpapeh_l4 = $hari_rawat_limpapeh_l4->jml;
						$harirawat_vip_limpapeh_l4 = $hari_rawat_vip_limpapeh_l4->jml;
						$harirawat_satu_limpapeh_l4 =  $hari_rawat_satu_limpapeh_l4->jml;
						$harirawat_dua_limpapeh_l4 = $hari_rawat_dua_limpapeh_l4->jml;
						$harirawat_tiga_limpapeh_l4 = $hari_rawat_tiga_limpapeh_l4->jml;
					}else{
						$harirawat_limpapeh_l4 = 0;
						$harirawat_vip_limpapeh_l4 = 0;
						$harirawat_satu_limpapeh_l4 = 0;
						$harirawat_dua_limpapeh_l4 = 0;
						$harirawat_tiga_limpapeh_l4 = 0;
					}
					$sheet->SetCellValue('N'.$indexlimpapehl4,$harirawat_limpapeh_l4);
					$sheet->SetCellValue('O'.$indexlimpapehl4,$harirawat_vip_limpapeh_l4);
					$sheet->SetCellValue('P'.$indexlimpapehl4,$harirawat_satu_limpapeh_l4);
					$sheet->SetCellValue('Q'.$indexlimpapehl4,$harirawat_dua_limpapeh_l4);
					$sheet->SetCellValue('R'.$indexlimpapehl4,$harirawat_tiga_limpapeh_l4);

					$total_pasien_awal_limpapeh_l4 += $pasien_awal_limpapeh_l4->jml;
					$total_pasien_masuk_limpapeh_l4 += $pasien_masuk_limpapeh_l4->jml;
					$total_pasien_masuk_pindah_limpapeh_l4 += $pasien_masuk_pindah_limpapeh_l4->jml;
					$total_pasien_dirawat_all_limpapeh_l4 += $total_pasien_dirawat_limpapeh_l4;
					$total_pasien_keluar_pindah_limpapeh_l4 += $pasien_keluar_pindah_limpapeh_l4->jml;
					$total_pasien_keluar_mati_limpapeh_l4 += $pasien_keluar_mati_limpapeh_l4->jml;
					$total_pasien_keluar_hidup_limpapeh_l4 += $pasien_keluar_hidup_limpapeh_l4->jml;
					$total_pasien_keluar_all_limpapeh_l4 += $total_pasien_keluar_limpapeh_l4;
					$total_pasien_keluar_hidup_mati_limpapeh_l4 += $pasien_keluar_hidup_mati_limpapeh_l4->jml;
					$total_pasien_mati_krg48_limpapeh_l4 += $pasien_mati_krg_48_limpapeh_l4->jml;
					$total_pasien_mati_lbh48_limpapeh_l4 += $pasien_mati_lbh_48_limpapeh_l4->jml;
					$total_lama_rawat_limpapeh_l4 += $lama_rawat_limpapeh_l4->jml;
					$total_hari_rawat_limpapeh_l4 += $harirawat_limpapeh_l4;
					$total_hari_rawat_vip_limpapeh_l4 += $harirawat_vip_limpapeh_l4;
					$total_hari_rawat_satu_limpapeh_l4 += $harirawat_satu_limpapeh_l4;
					$total_hari_rawat_dua_limpapeh_l4 += $harirawat_dua_limpapeh_l4;
					$total_hari_rawat_tiga_limpapeh_l4 += $harirawat_tiga_limpapeh_l4;
				}

				// SINGGALANG L1 & L2
				$sheet->mergeCells('F112:I112')
				->getCell('F112')
				->setValue('PELAYANAN RAWAT INAP SINGGALANG L1 & L2');

				$sheet->SetCellValue('A113','Tanggal');
				$sheet->SetCellValue('B113','Pasien Awal');
				$sheet->SetCellValue('C113','Pasien Masuk');
				$sheet->SetCellValue('D113','Pasien Pindah');
				$sheet->SetCellValue('E113','Jumlah Pend Dirawat');
				$sheet->mergeCells('F113:I113')
				->getCell('F113')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J113','Pasien Keluar H + M');
				$sheet->mergeCells('K113:L113')
				->getCell('K113')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M113','Total Lama dirawat');
				$sheet->SetCellValue('N113','Jumlah Hari Rawatan');
				$sheet->mergeCells('O113:R113')
				->getCell('O113')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F114','Di pindahkan');
				$sheet->SetCellValue('G114','Hidup');
				$sheet->SetCellValue('H114','Mati');
				$sheet->SetCellValue('I114','Total');
				$sheet->SetCellValue('K114','< 48 Jam');
				$sheet->SetCellValue('L114','≥ 48 Jam');
				$sheet->SetCellValue('O114','VIP');
				$sheet->SetCellValue('P114','I');
				$sheet->SetCellValue('Q114','II');
				$sheet->SetCellValue('R114','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_singgalangl1l2 = "idrg IN ('0601','0602')";
				$total_pasien_awal_singgalangl1l2 = 0;
				$total_pasien_masuk_singgalangl1l2 = 0;
				$total_pasien_masuk_pindah_singgalangl1l2 = 0;
				$total_pasien_dirawat_all_singgalangl1l2 = 0;
				$total_pasien_keluar_pindah_singgalangl1l2 = 0;
				$total_pasien_keluar_hidup_singgalangl1l2 = 0;
				$total_pasien_keluar_mati_singgalangl1l2 = 0;
				$total_pasien_keluar_all_singgalangl1l2 = 0;
				$total_pasien_keluar_hidup_mati_singgalangl1l2 = 0;
				$total_pasien_mati_krg48_singgalangl1l2= 0;
				$total_pasien_mati_lbh48_singgalangl1l2 = 0;
				$total_lama_rawat_singgalangl1l2 = 0;
				$total_hari_rawat_singgalangl1l2 = 0;
				$total_hari_rawat_vip_singgalangl1l2 = 0;
				$total_hari_rawat_satu_singgalangl1l2 = 0;
				$total_hari_rawat_dua_singgalangl1l2 = 0;
				$total_hari_rawat_tiga_singgalangl1l2 = 0;

				$rowCountsinggalangl1l2 = 115;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$indexsinggalangl1l2 = $rowCountsinggalangl1l2++;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$pasien_awal_singgalangl1l2 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_masuk_singgalangl1l2 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_masuk_pindah_singgalangl1l2 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_keluar_pindah_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_keluar_hidup_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_keluar_mati_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_keluar_hidup_mati_singgalangl1l2 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_mati_krg_48_singgalangl1l2 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$pasien_mati_lbh_48_singgalangl1l2 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$lama_rawat_singgalangl1l2 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$hari_rawat_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_singgalangl1l2)->row();
					$hari_rawat_vip_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_singgalangl1l2)->row();
					$hari_rawat_satu_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_singgalangl1l2)->row();
					$hari_rawat_dua_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_singgalangl1l2)->row();
					$hari_rawat_tiga_singgalangl1l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_singgalangl1l2)->row();

					$sheet->SetCellValue('A'.$indexsinggalangl1l2, $i);
					$sheet->SetCellValue('B'.$indexsinggalangl1l2, $pasien_awal_singgalangl1l2->jml);
					$sheet->SetCellValue('C'.$indexsinggalangl1l2, $pasien_masuk_singgalangl1l2->jml);
					$sheet->SetCellValue('D'.$indexsinggalangl1l2, $pasien_masuk_pindah_singgalangl1l2->jml);
			
					$total_pasien_dirawat_singgalangl1l2 = $pasien_awal_singgalangl1l2->jml + $pasien_masuk_singgalangl1l2->jml + $pasien_masuk_pindah_singgalangl1l2->jml;
                                 
					$sheet->SetCellValue('E'.$indexsinggalangl1l2, $total_pasien_dirawat_singgalangl1l2);
					$sheet->SetCellValue('F'.$indexsinggalangl1l2, $pasien_keluar_pindah_singgalangl1l2->jml);
					$sheet->SetCellValue('G'.$indexsinggalangl1l2, $pasien_keluar_hidup_singgalangl1l2->jml);
					$sheet->SetCellValue('H'.$indexsinggalangl1l2, $pasien_keluar_mati_singgalangl1l2->jml);
					$total_pasien_keluar_singgalangl1l2 = $pasien_keluar_pindah_singgalangl1l2->jml + $pasien_keluar_hidup_singgalangl1l2->jml + $pasien_keluar_mati_singgalangl1l2->jml;
					$sheet->SetCellValue('I'.$indexsinggalangl1l2, $total_pasien_keluar_singgalangl1l2);
					$sheet->SetCellValue('J'.$indexsinggalangl1l2, $pasien_keluar_hidup_mati_singgalangl1l2->jml);
					$sheet->SetCellValue('K'.$indexsinggalangl1l2, $pasien_mati_krg_48_singgalangl1l2->jml );
					$sheet->SetCellValue('L'.$indexsinggalangl1l2, $pasien_mati_lbh_48_singgalangl1l2->jml);
					$sheet->SetCellValue('M'.$indexsinggalangl1l2, $lama_rawat_singgalangl1l2->jml);
					if($i <= date('j')){
						$harirawat_singgalangl1l2 = $hari_rawat_singgalangl1l2->jml;
						$harirawat_vip_singgalangl1l2 = $hari_rawat_vip_singgalangl1l2->jml;
						$harirawat_satu_singgalangl1l2 = $hari_rawat_satu_singgalangl1l2->jml;
						$harirawat_dua_singgalangl1l2 = $hari_rawat_dua_singgalangl1l2->jml;
						$harirawat_tiga_singgalangl1l2 = $hari_rawat_tiga_singgalangl1l2->jml;
					}else{
						$harirawat_singgalangl1l2 = 0;
						$harirawat_vip_singgalangl1l2 = 0;
						$harirawat_satu_singgalangl1l2 = 0;
						$harirawat_dua_singgalangl1l2 = 0;
						$harirawat_tiga_singgalangl1l2 = 0;
					}
					$sheet->SetCellValue('N'.$indexsinggalangl1l2, $harirawat_singgalangl1l2);
					$sheet->SetCellValue('O'.$indexsinggalangl1l2,$harirawat_vip_singgalangl1l2);
					$sheet->SetCellValue('P'.$indexsinggalangl1l2,$harirawat_satu_singgalangl1l2);
					$sheet->SetCellValue('Q'.$indexsinggalangl1l2,$harirawat_dua_singgalangl1l2);
					$sheet->SetCellValue('R'.$indexsinggalangl1l2,$harirawat_tiga_singgalangl1l2);

					$total_pasien_awal_singgalangl1l2 += $pasien_awal_singgalangl1l2->jml;
					$total_pasien_masuk_singgalangl1l2 += $pasien_masuk_singgalangl1l2->jml;
					$total_pasien_masuk_pindah_singgalangl1l2 += $pasien_masuk_pindah_singgalangl1l2->jml;
					$total_pasien_dirawat_all_singgalangl1l2 += $total_pasien_dirawat_singgalangl1l2;
					$total_pasien_keluar_pindah_singgalangl1l2 += $pasien_keluar_pindah_singgalangl1l2->jml;
					$total_pasien_keluar_mati_singgalangl1l2 += $pasien_keluar_mati_singgalangl1l2->jml;
					$total_pasien_keluar_hidup_singgalangl1l2 += $pasien_keluar_hidup_singgalangl1l2->jml;
					$total_pasien_keluar_all_singgalangl1l2 += $total_pasien_keluar_singgalangl1l2;
					$total_pasien_keluar_hidup_mati_singgalangl1l2 += $pasien_keluar_hidup_mati_singgalangl1l2->jml;
					$total_pasien_mati_krg48_singgalangl1l2 += $pasien_mati_krg_48_singgalangl1l2->jml;
					$total_pasien_mati_lbh48_singgalangl1l2 += $pasien_mati_lbh_48_singgalangl1l2->jml;
					$total_lama_rawat_singgalangl1l2 += $lama_rawat_singgalangl1l2->jml;
					$total_hari_rawat_singgalangl1l2 += $harirawat_singgalangl1l2;
					$total_hari_rawat_vip_singgalangl1l2 += $harirawat_vip_singgalangl1l2;
					$total_hari_rawat_satu_singgalangl1l2 += $harirawat_satu_singgalangl1l2;
					$total_hari_rawat_dua_singgalangl1l2 += $harirawat_dua_singgalangl1l2;
					$total_hari_rawat_tiga_singgalangl1l2 += $harirawat_tiga_singgalangl1l2;
				}

				// SINGGALANG L3

				$sheet->mergeCells('F149:I149')
				->getCell('F149')
				->setValue('PELAYANAN RAWAT INAP SINGGALANG L3');

				$sheet->SetCellValue('A150','Tanggal');
				$sheet->SetCellValue('B150','Pasien Awal');
				$sheet->SetCellValue('C150','Pasien Masuk');
				$sheet->SetCellValue('D150','Pasien Pindah');
				$sheet->SetCellValue('E150','Jumlah Pend Dirawat');
				$sheet->mergeCells('F150:I150')
				->getCell('F150')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J150','Pasien Keluar H + M');
				$sheet->mergeCells('K150:L150')
				->getCell('K150')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M150','Total Lama dirawat');
				$sheet->SetCellValue('N150','Jumlah Hari Rawatan');
				$sheet->mergeCells('O150:R150')
				->getCell('O150')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F151','Di pindahkan');
				$sheet->SetCellValue('G151','Hidup');
				$sheet->SetCellValue('H151','Mati');
				$sheet->SetCellValue('I151','Total');
				$sheet->SetCellValue('K151','< 48 Jam');
				$sheet->SetCellValue('L151','≥ 48 Jam');
				$sheet->SetCellValue('O151','VIP');
				$sheet->SetCellValue('P151','I');
				$sheet->SetCellValue('Q151','II');
				$sheet->SetCellValue('R151','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_singgalangl3 = "idrg = '0603'";
				$total_pasien_awal_singgalangl3 = 0;
				$total_pasien_masuk_singgalangl3 = 0;
				$total_pasien_masuk_pindah_singgalangl3 = 0;
				$total_pasien_dirawat_all_singgalangl3 = 0;
				$total_pasien_keluar_pindah_singgalangl3 = 0;
				$total_pasien_keluar_hidup_singgalangl3 = 0;
				$total_pasien_keluar_mati_singgalangl3 = 0;
				$total_pasien_keluar_all_singgalangl3 = 0;
				$total_pasien_keluar_hidup_mati_singgalangl3 = 0;
				$total_pasien_mati_krg48_singgalangl3= 0;
				$total_pasien_mati_lbh48_singgalangl3 = 0;
				$total_lama_rawat_singgalangl3 = 0;
				$total_hari_rawat_singgalangl3 = 0;
				$total_hari_rawat_vip_singgalangl3 = 0;
				$total_hari_rawat_satu_singgalangl3 = 0;
				$total_hari_rawat_dua_singgalangl3 = 0;
				$total_hari_rawat_tiga_singgalangl3 = 0;

				$rowCountsinggalangl3 = 152;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexsinggalangl3 = $rowCountsinggalangl3++;
					$pasien_awal_singgalangl3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_masuk_singgalangl3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_masuk_pindah_singgalangl3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_keluar_pindah_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_keluar_hidup_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_keluar_mati_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_keluar_hidup_mati_singgalangl3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_mati_krg_48_singgalangl3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_singgalangl3)->row();
					$pasien_mati_lbh_48_singgalangl3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_singgalangl3)->row();
					$lama_rawat_singgalangl3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_singgalangl3)->row();
					$hari_rawat_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_singgalangl3)->row();
					$hari_rawat_vip_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_singgalangl3)->row();
					$hari_rawat_satu_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_singgalangl3)->row();
					$hari_rawat_dua_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_singgalangl3)->row();
					$hari_rawat_tiga_singgalangl3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_singgalangl3)->row();

					$sheet->SetCellValue('A'.$indexsinggalangl3, $i);
					$sheet->SetCellValue('B'.$indexsinggalangl3, $pasien_awal_singgalangl3->jml);
					$sheet->SetCellValue('C'.$indexsinggalangl3, $pasien_masuk_singgalangl3->jml);
					$sheet->SetCellValue('D'.$indexsinggalangl3, $pasien_masuk_pindah_singgalangl3->jml);
			
					$total_pasien_dirawat_singgalangl3 = $pasien_awal_singgalangl3->jml + $pasien_masuk_singgalangl3->jml + $pasien_masuk_pindah_singgalangl3->jml;
                                 
					$sheet->SetCellValue('E'.$indexsinggalangl3, $total_pasien_dirawat_singgalangl3);
					$sheet->SetCellValue('F'.$indexsinggalangl3, $pasien_keluar_pindah_singgalangl3->jml);
					$sheet->SetCellValue('G'.$indexsinggalangl3, $pasien_keluar_hidup_singgalangl3->jml);
					$sheet->SetCellValue('H'.$indexsinggalangl3, $pasien_keluar_mati_singgalangl3->jml);
					$total_pasien_keluar_singgalangl3 = $pasien_keluar_pindah_singgalangl3->jml + $pasien_keluar_hidup_singgalangl3->jml + $pasien_keluar_mati_singgalangl3->jml;
					$sheet->SetCellValue('I'.$indexsinggalangl3, $total_pasien_keluar_singgalangl3);
					$sheet->SetCellValue('J'.$indexsinggalangl3, $pasien_keluar_hidup_mati_singgalangl3->jml);
					$sheet->SetCellValue('K'.$indexsinggalangl3, $pasien_mati_krg_48_singgalangl3->jml );
					$sheet->SetCellValue('L'.$indexsinggalangl3, $pasien_mati_lbh_48_singgalangl3->jml);
					$sheet->SetCellValue('M'.$indexsinggalangl3, $lama_rawat_singgalangl3->jml);
					if($i <= date('j')){
						$harirawat_singgalangl3 = $hari_rawat_singgalangl3->jml;
						$harirawat_vip_singgalangl3 = $hari_rawat_vip_singgalangl3->jml;
						$harirawat_satu_singgalangl3 = $hari_rawat_satu_singgalangl3->jml;
						$harirawat_dua_singgalangl3 = $hari_rawat_dua_singgalangl3->jml;
						$harirawat_tiga_singgalangl3 = $hari_rawat_tiga_singgalangl3->jml;
					}else{
						$harirawat_singgalangl3 = 0;
						$harirawat_vip_singgalangl3 = 0;
						$harirawat_satu_singgalangl3 = 0;
						$harirawat_dua_singgalangl3 = 0;
						$harirawat_tiga_singgalangl3 = 0;
					}
					$sheet->SetCellValue('N'.$indexsinggalangl3,$harirawat_singgalangl3);
					$sheet->SetCellValue('O'.$indexsinggalangl3,$harirawat_vip_singgalangl3);
					$sheet->SetCellValue('P'.$indexsinggalangl3,$harirawat_satu_singgalangl3);
					$sheet->SetCellValue('Q'.$indexsinggalangl3,$harirawat_dua_singgalangl3);
					$sheet->SetCellValue('R'.$indexsinggalangl3,$harirawat_tiga_singgalangl3);

					$total_pasien_awal_singgalangl3 += $pasien_awal_singgalangl3->jml;
					$total_pasien_masuk_singgalangl3 += $pasien_masuk_singgalangl3->jml;
					$total_pasien_masuk_pindah_singgalangl3 += $pasien_masuk_pindah_singgalangl3->jml;
					$total_pasien_dirawat_all_singgalangl3 += $total_pasien_dirawat_singgalangl3;
					$total_pasien_keluar_pindah_singgalangl3 += $pasien_keluar_pindah_singgalangl3->jml;
					$total_pasien_keluar_mati_singgalangl3 += $pasien_keluar_mati_singgalangl3->jml;
					$total_pasien_keluar_hidup_singgalangl3 += $pasien_keluar_hidup_singgalangl3->jml;
					$total_pasien_keluar_all_singgalangl3 += $total_pasien_keluar_singgalangl3;
					$total_pasien_keluar_hidup_mati_singgalangl3 += $pasien_keluar_hidup_mati_singgalangl3->jml;
					$total_pasien_mati_krg48_singgalangl3 += $pasien_mati_krg_48_singgalangl3->jml;
					$total_pasien_mati_lbh48_singgalangl3 += $pasien_mati_lbh_48_singgalangl3->jml;
					$total_lama_rawat_singgalangl3 += $lama_rawat_singgalangl3->jml;
					$total_hari_rawat_singgalangl3 += $harirawat_singgalangl3;
					$total_hari_rawat_vip_singgalangl3 += $harirawat_vip_singgalangl3;
					$total_hari_rawat_satu_singgalangl3 += $harirawat_satu_singgalangl3;
					$total_hari_rawat_dua_singgalangl3 += $harirawat_dua_singgalangl3;
					$total_hari_rawat_tiga_singgalangl3 += $harirawat_tiga_singgalangl3;

				}

				// MERAPI L1 

				$sheet->mergeCells('F186:I186')
				->getCell('F186')
				->setValue('PELAYANAN RAWAT INAP MERAPI L1');

				$sheet->SetCellValue('A187','Tanggal');
				$sheet->SetCellValue('B187','Pasien Awal');
				$sheet->SetCellValue('C187','Pasien Masuk');
				$sheet->SetCellValue('D187','Pasien Pindah');
				$sheet->SetCellValue('E187','Jumlah Pend Dirawat');
				$sheet->mergeCells('F187:I187')
				->getCell('F187')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J187','Pasien Keluar H + M');
				$sheet->mergeCells('K187:L187')
				->getCell('K187')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M187','Total Lama dirawat');
				$sheet->SetCellValue('N187','Jumlah Hari Rawatan');
				$sheet->mergeCells('O187:R187')
				->getCell('O187')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F188','Di pindahkan');
				$sheet->SetCellValue('G188','Hidup');
				$sheet->SetCellValue('H188','Mati');
				$sheet->SetCellValue('I188','Total');
				$sheet->SetCellValue('K188','< 48 Jam');
				$sheet->SetCellValue('L188','≥ 48 Jam');
				$sheet->SetCellValue('O188','VIP');
				$sheet->SetCellValue('P188','I');
				$sheet->SetCellValue('Q188','II');
				$sheet->SetCellValue('R188','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_merapil1 = "idrg = '0701'";
				$total_pasien_awal_merapil1 = 0;
				$total_pasien_masuk_merapil1 = 0;
				$total_pasien_masuk_pindah_merapil1 = 0;
				$total_pasien_dirawat_all_merapil1 = 0;
				$total_pasien_keluar_pindah_merapil1 = 0;
				$total_pasien_keluar_hidup_merapil1 = 0;
				$total_pasien_keluar_mati_merapil1 = 0;
				$total_pasien_keluar_all_merapil1 = 0;
				$total_pasien_keluar_hidup_mati_merapil1 = 0;
				$total_pasien_mati_krg48_merapil1= 0;
				$total_pasien_mati_lbh48_merapil1 = 0;
				$total_lama_rawat_merapil1 = 0;
				$total_hari_rawat_merapil1 = 0;
				$total_hari_rawat_vip_merapil1 = 0;
				$total_hari_rawat_satu_merapil1 = 0;
				$total_hari_rawat_dua_merapil1 = 0;
				$total_hari_rawat_tiga_merapil1 = 0;
        
				$rowCountmerapil1 = 189;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexmerapil1 = $rowCountmerapil1++;
					$pasien_awal_merapil1 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_masuk_merapil1 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_masuk_pindah_merapil1 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_keluar_pindah_merapil1 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_keluar_hidup_merapil1 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_keluar_mati_merapil1 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_keluar_hidup_mati_merapil1 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_mati_krg_48_merapil1 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil1)->row();
					$pasien_mati_lbh_48_merapil1 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil1)->row();
					$lama_rawat_merapi_l1 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil1)->row();
					$hari_rawat_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil1)->row();
					$hari_rawat_vip_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil1)->row();
					$hari_rawat_satu_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil1)->row();
					$hari_rawat_dua_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil1)->row();
					$hari_rawat_tiga_merapi_l1 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil1)->row();

					$sheet->SetCellValue('A'.$indexmerapil1, $i);
					$sheet->SetCellValue('B'.$indexmerapil1, $pasien_awal_merapil1->jml);
					$sheet->SetCellValue('C'.$indexmerapil1, $pasien_masuk_merapil1->jml);
					$sheet->SetCellValue('D'.$indexmerapil1, $pasien_masuk_pindah_merapil1->jml);
			
					$total_pasien_dirawat_merapil1 = $pasien_awal_merapil1->jml + $pasien_masuk_merapil1->jml + $pasien_masuk_pindah_merapil1->jml;
                                 
					$sheet->SetCellValue('E'.$indexmerapil1, $total_pasien_dirawat_merapil1);
					$sheet->SetCellValue('F'.$indexmerapil1, $pasien_keluar_pindah_merapil1->jml);
					$sheet->SetCellValue('G'.$indexmerapil1, $pasien_keluar_hidup_merapil1->jml);
					$sheet->SetCellValue('H'.$indexmerapil1, $pasien_keluar_mati_merapil1->jml);
					$total_pasien_keluar_merapil1 = $pasien_keluar_pindah_merapil1->jml + $pasien_keluar_hidup_merapil1->jml + $pasien_keluar_mati_merapil1->jml;
					$sheet->SetCellValue('I'.$indexmerapil1, $total_pasien_keluar_merapil1);
					$sheet->SetCellValue('J'.$indexmerapil1, $pasien_keluar_hidup_mati_merapil1->jml);
					$sheet->SetCellValue('K'.$indexmerapil1, $pasien_mati_krg_48_merapil1->jml );
					$sheet->SetCellValue('L'.$indexmerapil1, $pasien_mati_lbh_48_merapil1->jml);
					$sheet->SetCellValue('M'.$indexmerapil1, $lama_rawat_merapi_l1->jml);
					if($i <= date('j')){
						$harirawat_merapi_l1 = $hari_rawat_merapi_l1->jml;
						$harirawat_vip_merapi_l1 = $hari_rawat_vip_merapi_l1->jml;
						$harirawat_satu_merapi_l1 = $hari_rawat_satu_merapi_l1->jml;
						$harirawat_dua_merapi_l1 = $hari_rawat_dua_merapi_l1->jml;
						$harirawat_tiga_merapi_l1 = $hari_rawat_tiga_merapi_l1->jml;
					}else{
						$harirawat_merapi_l1 = 0;
						$harirawat_vip_merapi_l1 = 0;
						$harirawat_satu_merapi_l1 = 0;
						$harirawat_dua_merapi_l1 = 0;
						$harirawat_tiga_merapi_l1 = 0;
					}
					$sheet->SetCellValue('N'.$indexmerapil1, $harirawat_merapi_l1);
					$sheet->SetCellValue('O'.$indexmerapil1, $harirawat_vip_merapi_l1);
					$sheet->SetCellValue('P'.$indexmerapil1, $harirawat_satu_merapi_l1);
					$sheet->SetCellValue('Q'.$indexmerapil1, $harirawat_dua_merapi_l1);
					$sheet->SetCellValue('R'.$indexmerapil1, $harirawat_tiga_merapi_l1);

					$total_pasien_awal_merapil1 += $pasien_awal_merapil1->jml;
					$total_pasien_masuk_merapil1 += $pasien_masuk_merapil1->jml;
					$total_pasien_masuk_pindah_merapil1 += $pasien_masuk_pindah_merapil1->jml;
					$total_pasien_dirawat_all_merapil1 += $total_pasien_dirawat_merapil1;
					$total_pasien_keluar_pindah_merapil1 += $pasien_keluar_pindah_merapil1->jml;
					$total_pasien_keluar_mati_merapil1 += $pasien_keluar_mati_merapil1->jml;
					$total_pasien_keluar_hidup_merapil1 += $pasien_keluar_hidup_merapil1->jml;
					$total_pasien_keluar_all_merapil1 += $total_pasien_keluar_merapil1;
					$total_pasien_keluar_hidup_mati_merapil1 += $pasien_keluar_hidup_mati_merapil1->jml;
					$total_pasien_mati_krg48_merapil1 += $pasien_mati_krg_48_merapil1->jml;
					$total_pasien_mati_lbh48_merapil1 += $pasien_mati_lbh_48_merapil1->jml;
					$total_lama_rawat_merapil1 += $lama_rawat_merapi_l1->jml;
					$total_hari_rawat_merapil1 += $harirawat_merapi_l1;
					$total_hari_rawat_vip_merapil1 += $harirawat_vip_merapi_l1;
					$total_hari_rawat_satu_merapil1 += $harirawat_satu_merapi_l1;
					$total_hari_rawat_dua_merapil1 += $harirawat_dua_merapi_l1;
					$total_hari_rawat_tiga_merapil1 += $harirawat_tiga_merapi_l1;
				}

				// MERAPI L2
				$sheet->mergeCells('F223:I223')
				->getCell('F223')
				->setValue('PELAYANAN RAWAT INAP MERAPI L2');

				$sheet->SetCellValue('A224','Tanggal');
				$sheet->SetCellValue('B224','Pasien Awal');
				$sheet->SetCellValue('C224','Pasien Masuk');
				$sheet->SetCellValue('D224','Pasien Pindah');
				$sheet->SetCellValue('E224','Jumlah Pend Dirawat');
				$sheet->mergeCells('F224:I224')
				->getCell('F224')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J224','Pasien Keluar H + M');
				$sheet->mergeCells('K224:L224')
				->getCell('K224')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M224','Total Lama dirawat');
				$sheet->SetCellValue('N224','Jumlah Hari Rawatan');
				$sheet->mergeCells('O224:R224')
				->getCell('O224')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F225','Di pindahkan');
				$sheet->SetCellValue('G225','Hidup');
				$sheet->SetCellValue('H225','Mati');
				$sheet->SetCellValue('I225','Total');
				$sheet->SetCellValue('K225','< 48 Jam');
				$sheet->SetCellValue('L225','≥ 48 Jam');
				$sheet->SetCellValue('O225','VIP');
				$sheet->SetCellValue('P225','I');
				$sheet->SetCellValue('Q225','II');
				$sheet->SetCellValue('R225','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_merapil2 = "idrg IN ('0702','0705')";
				$total_pasien_awal_merapil2 = 0;
				$total_pasien_masuk_merapil2 = 0;
				$total_pasien_masuk_pindah_merapil2 = 0;
				$total_pasien_dirawat_all_merapil2 = 0;
				$total_pasien_keluar_pindah_merapil2 = 0;
				$total_pasien_keluar_hidup_merapil2 = 0;
				$total_pasien_keluar_mati_merapil2 = 0;
				$total_pasien_keluar_all_merapil2 = 0;
				$total_pasien_keluar_hidup_mati_merapil2 = 0;
				$total_pasien_mati_krg48_merapil2= 0;
				$total_pasien_mati_lbh48_merapil2 = 0;
				$total_lama_rawat_merapil2 = 0;
				$total_hari_rawat_merapil2 = 0;
				$total_hari_rawat_vip_merapil2 = 0;
				$total_hari_rawat_satu_merapil2 = 0;
				$total_hari_rawat_dua_merapil2 = 0;
				$total_hari_rawat_tiga_merapil2 = 0;

				$rowCountmerapil2 = 226;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexmerapil2 = $rowCountmerapil2++;
					$pasien_awal_merapil2 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_masuk_merapil2 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_masuk_pindah_merapil2 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_keluar_pindah_merapil2 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_keluar_hidup_merapil2 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_keluar_mati_merapil2 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_keluar_hidup_mati_merapil2 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_mati_krg_48_merapil2 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil2)->row();
					$pasien_mati_lbh_48_merapil2 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil2)->row();
					$lama_rawat_merapi_l2 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil2)->row();
					$hari_rawat_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil2)->row();
					$hari_rawat_vip_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil2)->row();
					$hari_rawat_satu_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil2)->row();
					$hari_rawat_dua_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil2)->row();
					$hari_rawat_tiga_merapi_l2 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil2)->row();

					$sheet->SetCellValue('A'.$indexmerapil2, $i);
					$sheet->SetCellValue('B'.$indexmerapil2, $pasien_awal_merapil2->jml);
					$sheet->SetCellValue('C'.$indexmerapil2, $pasien_masuk_merapil2->jml);
					$sheet->SetCellValue('D'.$indexmerapil2, $pasien_masuk_pindah_merapil2->jml);
			
					$total_pasien_dirawat_merapil2 = $pasien_awal_merapil2->jml + $pasien_masuk_merapil2->jml + $pasien_masuk_pindah_merapil2->jml;
                                 
					$sheet->SetCellValue('E'.$indexmerapil2, $total_pasien_dirawat_merapil2);
					$sheet->SetCellValue('F'.$indexmerapil2, $pasien_keluar_pindah_merapil2->jml);
					$sheet->SetCellValue('G'.$indexmerapil2, $pasien_keluar_hidup_merapil2->jml);
					$sheet->SetCellValue('H'.$indexmerapil2, $pasien_keluar_mati_merapil2->jml);
					$total_pasien_keluar_merapil2 = $pasien_keluar_pindah_merapil2->jml + $pasien_keluar_hidup_merapil2->jml + $pasien_keluar_mati_merapil2->jml;
					$sheet->SetCellValue('I'.$indexmerapil2, $total_pasien_keluar_merapil2);
					$sheet->SetCellValue('J'.$indexmerapil2, $pasien_keluar_hidup_mati_merapil2->jml);
					$sheet->SetCellValue('K'.$indexmerapil2, $pasien_mati_krg_48_merapil2->jml );
					$sheet->SetCellValue('L'.$indexmerapil2, $pasien_mati_lbh_48_merapil2->jml);
					$sheet->SetCellValue('M'.$indexmerapil2, $lama_rawat_merapi_l2->jml);
					if($i <= date('j')){
						$harirawat_merapi_l2 = $hari_rawat_merapi_l2->jml;
						$harirawat_vip_merapi_l2 = $hari_rawat_vip_merapi_l2->jml ;
						$harirawat_satu_merapi_l2 = $hari_rawat_satu_merapi_l2->jml;
						$harirawat_dua_merapi_l2 = $hari_rawat_dua_merapi_l2->jml;
						$harirawat_tiga_merapi_l2 = $hari_rawat_tiga_merapi_l2->jml;
					}else{
						$harirawat_merapi_l2 = 0;
						$harirawat_vip_merapi_l2 = 0;
						$harirawat_satu_merapi_l2 = 0;
						$harirawat_dua_merapi_l2 = 0;
						$harirawat_tiga_merapi_l2 = 0;
					}
					$sheet->SetCellValue('N'.$indexmerapil2, $harirawat_merapi_l2);
					$sheet->SetCellValue('O'.$indexmerapil2, $harirawat_vip_merapi_l2);
					$sheet->SetCellValue('P'.$indexmerapil2, $harirawat_satu_merapi_l2);
					$sheet->SetCellValue('Q'.$indexmerapil2, $harirawat_dua_merapi_l2);
					$sheet->SetCellValue('R'.$indexmerapil2, $harirawat_tiga_merapi_l2);

					$total_pasien_awal_merapil2 += $pasien_awal_merapil2->jml;
					$total_pasien_masuk_merapil2 += $pasien_masuk_merapil2->jml;
					$total_pasien_masuk_pindah_merapil2 += $pasien_masuk_pindah_merapil2->jml;
					$total_pasien_dirawat_all_merapil2 += $total_pasien_dirawat_merapil2;
					$total_pasien_keluar_pindah_merapil2 += $pasien_keluar_pindah_merapil2->jml;
					$total_pasien_keluar_mati_merapil2 += $pasien_keluar_mati_merapil2->jml;
					$total_pasien_keluar_hidup_merapil2 += $pasien_keluar_hidup_merapil2->jml;
					$total_pasien_keluar_all_merapil2 += $total_pasien_keluar_merapil2;
					$total_pasien_keluar_hidup_mati_merapil2 += $pasien_keluar_hidup_mati_merapil2->jml;
					$total_pasien_mati_krg48_merapil2 += $pasien_mati_krg_48_merapil2->jml;
					$total_pasien_mati_lbh48_merapil2 += $pasien_mati_lbh_48_merapil2->jml;
					$total_lama_rawat_merapil2 += $lama_rawat_merapi_l2->jml;
					$total_hari_rawat_merapil2 += $harirawat_merapi_l2;
					$total_hari_rawat_vip_merapil2 += $harirawat_vip_merapi_l2;
					$total_hari_rawat_satu_merapil2 += $harirawat_satu_merapi_l2;
					$total_hari_rawat_dua_merapil2 += $harirawat_dua_merapi_l2;
					$total_hari_rawat_tiga_merapil2 += $harirawat_tiga_merapi_l2;
				}

				// MERAPI L3
				$sheet->mergeCells('F260:I260')
				->getCell('F260')
				->setValue('PELAYANAN RAWAT INAP MERAPI L3');

				$sheet->SetCellValue('A261','Tanggal');
				$sheet->SetCellValue('B261','Pasien Awal');
				$sheet->SetCellValue('C261','Pasien Masuk');
				$sheet->SetCellValue('D261','Pasien Pindah');
				$sheet->SetCellValue('E261','Jumlah Pend Dirawat');
				$sheet->mergeCells('F261:I261')
				->getCell('F261')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J261','Pasien Keluar H + M');
				$sheet->mergeCells('K261:L261')
				->getCell('K261')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M261','Total Lama dirawat');
				$sheet->SetCellValue('N261','Jumlah Hari Rawatan');
				$sheet->mergeCells('O261:R261')
				->getCell('O261')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F262','Di pindahkan');
				$sheet->SetCellValue('G262','Hidup');
				$sheet->SetCellValue('H262','Mati');
				$sheet->SetCellValue('I262','Total');
				$sheet->SetCellValue('K262','< 48 Jam');
				$sheet->SetCellValue('L262','≥ 48 Jam');
				$sheet->SetCellValue('O262','VIP');
				$sheet->SetCellValue('P262','I');
				$sheet->SetCellValue('Q262','II');
				$sheet->SetCellValue('R262','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_merapil3 = "idrg IN ('0703','0706')";
				$total_pasien_awal_merapil3 = 0;
				$total_pasien_masuk_merapil3 = 0;
				$total_pasien_masuk_pindah_merapil3 = 0;
				$total_pasien_dirawat_all_merapil3 = 0;
				$total_pasien_keluar_pindah_merapil3 = 0;
				$total_pasien_keluar_hidup_merapil3 = 0;
				$total_pasien_keluar_mati_merapil3 = 0;
				$total_pasien_keluar_all_merapil3 = 0;
				$total_pasien_keluar_hidup_mati_merapil3 = 0;
				$total_pasien_mati_krg48_merapil3= 0;
				$total_pasien_mati_lbh48_merapil3 = 0;
				$total_lama_rawat_merapil3 = 0;
				$total_hari_rawat_merapil3 = 0;
				$total_hari_rawat_vip_merapil3 = 0;
				$total_hari_rawat_satu_merapil3 = 0;
				$total_hari_rawat_dua_merapil3 = 0;
				$total_hari_rawat_tiga_merapil3 = 0;

				$rowCountmerapil3 = 263;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexmerapil3 = $rowCountmerapil3++;
					$pasien_awal_merapil3 = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_masuk_merapil3 = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_masuk_pindah_merapil3 = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_keluar_pindah_merapil3 = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_keluar_hidup_merapil3 = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_keluar_mati_merapil3 = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_keluar_hidup_mati_merapil3 = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_mati_krg_48_merapil3 = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_merapil3)->row();
					$pasien_mati_lbh_48_merapil3 = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_merapil3)->row();
					$lama_rawat_merapi_l3 = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_merapil3)->row();
					$hari_rawat_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_merapil3)->row();
					$hari_rawat_vip_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_merapil3)->row();
					$hari_rawat_satu_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_merapil3)->row();
					$hari_rawat_dua_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_merapil3)->row();
					$hari_rawat_tiga_merapi_l3 = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_merapil3)->row();

					$sheet->SetCellValue('A'.$indexmerapil3, $i);
					$sheet->SetCellValue('B'.$indexmerapil3, $pasien_awal_merapil3->jml);
					$sheet->SetCellValue('C'.$indexmerapil3, $pasien_masuk_merapil3->jml);
					$sheet->SetCellValue('D'.$indexmerapil3, $pasien_masuk_pindah_merapil3->jml);
			
					$total_pasien_dirawat_merapil3 = $pasien_awal_merapil3->jml + $pasien_masuk_merapil3->jml + $pasien_masuk_pindah_merapil3->jml;
                                 
					$sheet->SetCellValue('E'.$indexmerapil3, $total_pasien_dirawat_merapil3);
					$sheet->SetCellValue('F'.$indexmerapil3, $pasien_keluar_pindah_merapil3->jml);
					$sheet->SetCellValue('G'.$indexmerapil3, $pasien_keluar_hidup_merapil3->jml);
					$sheet->SetCellValue('H'.$indexmerapil3, $pasien_keluar_mati_merapil3->jml);
					$total_pasien_keluar_merapil3 = $pasien_keluar_pindah_merapil3->jml + $pasien_keluar_hidup_merapil3->jml + $pasien_keluar_mati_merapil3->jml;
					$sheet->SetCellValue('I'.$indexmerapil3, $total_pasien_keluar_merapil3);
					$sheet->SetCellValue('J'.$indexmerapil3, $pasien_keluar_hidup_mati_merapil3->jml);
					$sheet->SetCellValue('K'.$indexmerapil3, $pasien_mati_krg_48_merapil3->jml );
					$sheet->SetCellValue('L'.$indexmerapil3, $pasien_mati_lbh_48_merapil3->jml);
					$sheet->SetCellValue('M'.$indexmerapil3, $lama_rawat_merapi_l3->jml);
					if($i <= date('j')){
						$harirawat_merapi_l3 = $hari_rawat_merapi_l3->jml;
						$harirawat_vip_merapi_l3 = $hari_rawat_vip_merapi_l3->jml ;
						$harirawat_satu_merapi_l3= $hari_rawat_satu_merapi_l3->jml;
						$harirawat_dua_merapi_l3 = $hari_rawat_dua_merapi_l3->jml;
						$harirawat_tiga_merapi_l3 = $hari_rawat_tiga_merapi_l3->jml;
					}else{
						$harirawat_merapi_l3 = 0;
						$harirawat_vip_merapi_l3 = 0;
						$harirawat_satu_merapi_l3= 0;
						$harirawat_dua_merapi_l3 = 0;
						$harirawat_tiga_merapi_l3 = 0;
					}
					$sheet->SetCellValue('N'.$indexmerapil3, $harirawat_merapi_l3);
					$sheet->SetCellValue('O'.$indexmerapil3, $harirawat_vip_merapi_l3);
					$sheet->SetCellValue('P'.$indexmerapil3, $harirawat_satu_merapi_l3);
					$sheet->SetCellValue('Q'.$indexmerapil3, $harirawat_dua_merapi_l3);
					$sheet->SetCellValue('R'.$indexmerapil3, $harirawat_tiga_merapi_l3);

					$total_pasien_awal_merapil3 += $pasien_awal_merapil3->jml;
					$total_pasien_masuk_merapil3 += $pasien_masuk_merapil3->jml;
					$total_pasien_masuk_pindah_merapil3 += $pasien_masuk_pindah_merapil3->jml;
					$total_pasien_dirawat_all_merapil3 += $total_pasien_dirawat_merapil3;
					$total_pasien_keluar_pindah_merapil3 += $pasien_keluar_pindah_merapil3->jml;
					$total_pasien_keluar_mati_merapil3 += $pasien_keluar_mati_merapil3->jml;
					$total_pasien_keluar_hidup_merapil3 += $pasien_keluar_hidup_merapil3->jml;
					$total_pasien_keluar_all_merapil3 += $total_pasien_keluar_merapil3;
					$total_pasien_keluar_hidup_mati_merapil3 += $pasien_keluar_hidup_mati_merapil3->jml;
					$total_pasien_mati_krg48_merapil3 += $pasien_mati_krg_48_merapil3->jml;
					$total_pasien_mati_lbh48_merapil3 += $pasien_mati_lbh_48_merapil3->jml;
					$total_lama_rawat_merapil3 += $lama_rawat_merapi_l3->jml;
					$total_hari_rawat_merapil3 += $harirawat_merapi_l3;
					$total_hari_rawat_vip_merapil3 += $harirawat_vip_merapi_l3;
					$total_hari_rawat_satu_merapil3 += $harirawat_satu_merapi_l3;
					$total_hari_rawat_dua_merapil3 += $harirawat_dua_merapi_l3;
					$total_hari_rawat_tiga_merapil3 += $harirawat_tiga_merapi_l3;
				}

				// ANAK

				$sheet->mergeCells('F297:I297')
				->getCell('F297')
				->setValue('PELAYANAN RAWAT INAP ANAK');

				$sheet->SetCellValue('A298','Tanggal');
				$sheet->SetCellValue('B298','Pasien Awal');
				$sheet->SetCellValue('C298','Pasien Masuk');
				$sheet->SetCellValue('D298','Pasien Pindah');
				$sheet->SetCellValue('E298','Jumlah Pend Dirawat');
				$sheet->mergeCells('F298:I298')
				->getCell('F298')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J298','Pasien Keluar H + M');
				$sheet->mergeCells('K298:L298')
				->getCell('K298')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M298','Total Lama dirawat');
				$sheet->SetCellValue('N298','Jumlah Hari Rawatan');
				$sheet->mergeCells('O298:R298')
				->getCell('O298')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F299','Di pindahkan');
				$sheet->SetCellValue('G299','Hidup');
				$sheet->SetCellValue('H299','Mati');
				$sheet->SetCellValue('I299','Total');
				$sheet->SetCellValue('K299','< 48 Jam');
				$sheet->SetCellValue('L299','≥ 48 Jam');
				$sheet->SetCellValue('O299','VIP');
				$sheet->SetCellValue('P299','I');
				$sheet->SetCellValue('Q299','II');
				$sheet->SetCellValue('R299','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_anak = "idrg IN ('0101','0501','0103')";
				$total_pasien_awal_anak = 0;
				$total_pasien_masuk_anak = 0;
				$total_pasien_masuk_pindah_anak = 0;
				$total_pasien_dirawat_all_anak = 0;
				$total_pasien_keluar_pindah_anak = 0;
				$total_pasien_keluar_hidup_anak = 0;
				$total_pasien_keluar_mati_anak = 0;
				$total_pasien_keluar_all_anak = 0;
				$total_pasien_keluar_hidup_mati_anak = 0;
				$total_pasien_mati_krg48_anak= 0;
				$total_pasien_mati_lbh48_anak = 0;
				$total_lama_rawat_anak = 0;
				$total_hari_rawat_anak = 0;
				$total_hari_rawat_vip_anak = 0;
				$total_hari_rawat_satu_anak = 0;
				$total_hari_rawat_dua_anak = 0;
				$total_hari_rawat_tiga_anak = 0;

				$rowCountanak = 300;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexanak = $rowCountanak++;
					$pasien_awal_anak = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_anak)->row();
					$pasien_masuk_anak = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_anak)->row();
					$pasien_masuk_pindah_anak = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_anak)->row();
					$pasien_keluar_pindah_anak = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_anak)->row();
					$pasien_keluar_hidup_anak = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_anak)->row();
					$pasien_keluar_mati_anak = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_anak)->row();
					$pasien_keluar_hidup_mati_anak = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_anak)->row();
					$pasien_mati_krg_48_anak = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_anak)->row();
					$pasien_mati_lbh_48_anak = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_anak)->row();
					$lama_rawat_anak = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_anak)->row();
					$hari_rawat_anak = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_anak)->row();
					$hari_rawat_vip_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_anak)->row();
					$hari_rawat_satu_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_anak)->row();
					$hari_rawat_dua_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_anak)->row();
					$hari_rawat_tiga_anak = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_anak)->row();

					$sheet->SetCellValue('A'.$indexanak, $i);
					$sheet->SetCellValue('B'.$indexanak, $pasien_awal_anak->jml);
					$sheet->SetCellValue('C'.$indexanak, $pasien_masuk_anak->jml);
					$sheet->SetCellValue('D'.$indexanak, $pasien_masuk_pindah_anak->jml);
			
					$total_pasien_dirawat_anak = $pasien_awal_anak->jml + $pasien_masuk_anak->jml + $pasien_masuk_pindah_anak->jml;
                                 
					$sheet->SetCellValue('E'.$indexanak, $total_pasien_dirawat_anak);
					$sheet->SetCellValue('F'.$indexanak, $pasien_keluar_pindah_anak->jml);
					$sheet->SetCellValue('G'.$indexanak, $pasien_keluar_hidup_anak->jml);
					$sheet->SetCellValue('H'.$indexanak, $pasien_keluar_mati_anak->jml);
					$total_pasien_keluar_anak = $pasien_keluar_pindah_anak->jml + $pasien_keluar_hidup_anak->jml + $pasien_keluar_mati_anak->jml;
					$sheet->SetCellValue('I'.$indexanak, $total_pasien_keluar_anak);
					$sheet->SetCellValue('J'.$indexanak, $pasien_keluar_hidup_mati_anak->jml);
					$sheet->SetCellValue('K'.$indexanak, $pasien_mati_krg_48_anak->jml );
					$sheet->SetCellValue('L'.$indexanak, $pasien_mati_lbh_48_anak->jml);
					$sheet->SetCellValue('M'.$indexanak, $lama_rawat_anak->jml);
					if($i <= date('j')){
						$harirawat_anak = $hari_rawat_anak->jml;
						$harirawat_vip_anak = $hari_rawat_vip_anak->jml ;
						$harirawat_satu_anak = $hari_rawat_satu_anak->jml;
						$harirawat_dua_anak = $hari_rawat_dua_anak->jml;
						$harirawat_tiga_anak = $hari_rawat_tiga_anak->jml;
					}else{
						$harirawat_anak = 0;
						$harirawat_vip_anak = 0;
						$harirawat_satu_anak = 0;
						$harirawat_dua_anak = 0;
						$harirawat_tiga_anak = 0;
					}
					$sheet->SetCellValue('N'.$indexanak, $harirawat_anak);
					$sheet->SetCellValue('O'.$indexanak, $harirawat_vip_anak);
					$sheet->SetCellValue('P'.$indexanak, $harirawat_satu_anak);
					$sheet->SetCellValue('Q'.$indexanak, $harirawat_dua_anak);
					$sheet->SetCellValue('R'.$indexanak, $harirawat_tiga_anak);

					$total_pasien_awal_anak += $pasien_awal_anak->jml;
					$total_pasien_masuk_anak += $pasien_masuk_anak->jml;
					$total_pasien_masuk_pindah_anak += $pasien_masuk_pindah_anak->jml;
					$total_pasien_dirawat_all_anak += $total_pasien_dirawat_anak;
					$total_pasien_keluar_pindah_anak += $pasien_keluar_pindah_anak->jml;
					$total_pasien_keluar_mati_anak += $pasien_keluar_mati_anak->jml;
					$total_pasien_keluar_hidup_anak += $pasien_keluar_hidup_anak->jml;
					$total_pasien_keluar_all_anak += $total_pasien_keluar_anak;
					$total_pasien_keluar_hidup_mati_anak += $pasien_keluar_hidup_mati_anak->jml;
					$total_pasien_mati_krg48_anak += $pasien_mati_krg_48_anak->jml;
					$total_pasien_mati_lbh48_anak += $pasien_mati_lbh_48_anak->jml;
					$total_lama_rawat_anak += $lama_rawat_anak->jml;
					$total_hari_rawat_anak += $harirawat_anak;
					$total_hari_rawat_vip_anak += $harirawat_vip_anak;
					$total_hari_rawat_satu_anak += $harirawat_satu_anak;
					$total_hari_rawat_dua_anak += $harirawat_dua_anak;
					$total_hari_rawat_tiga_anak += $harirawat_tiga_anak;
				}

				// BEDAH

				$sheet->mergeCells('F334:I334')
				->getCell('F334')
				->setValue('PELAYANAN RAWAT INAP BEDAH');

				$sheet->SetCellValue('A335','Tanggal');
				$sheet->SetCellValue('B335','Pasien Awal');
				$sheet->SetCellValue('C335','Pasien Masuk');
				$sheet->SetCellValue('D335','Pasien Pindah');
				$sheet->SetCellValue('E335','Jumlah Pend Dirawat');
				$sheet->mergeCells('F335:I335')
				->getCell('F335')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J335','Pasien Keluar H + M');
				$sheet->mergeCells('K335:L335')
				->getCell('K335')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M335','Total Lama dirawat');
				$sheet->SetCellValue('N335','Jumlah Hari Rawatan');
				$sheet->mergeCells('O335:R335')
				->getCell('O335')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F336','Di pindahkan');
				$sheet->SetCellValue('G336','Hidup');
				$sheet->SetCellValue('H336','Mati');
				$sheet->SetCellValue('I336','Total');
				$sheet->SetCellValue('K336','< 48 Jam');
				$sheet->SetCellValue('L336','≥ 48 Jam');
				$sheet->SetCellValue('O336','VIP');
				$sheet->SetCellValue('P336','I');
				$sheet->SetCellValue('Q336','II');
				$sheet->SetCellValue('R336','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_bedah = "idrg = '0502'";
				$total_pasien_awal_bedah = 0;
				$total_pasien_masuk_bedah = 0;
				$total_pasien_masuk_pindah_bedah = 0;
				$total_pasien_dirawat_all_bedah = 0;
				$total_pasien_keluar_pindah_bedah = 0;
				$total_pasien_keluar_hidup_bedah = 0;
				$total_pasien_keluar_mati_bedah = 0;
				$total_pasien_keluar_all_bedah = 0;
				$total_pasien_keluar_hidup_mati_bedah = 0;
				$total_pasien_mati_krg48_bedah= 0;
				$total_pasien_mati_lbh48_bedah = 0;
				$total_lama_rawat_bedah = 0;
				$total_hari_rawat_bedah = 0;
				$total_hari_rawat_vip_bedah = 0;
				$total_hari_rawat_satu_bedah = 0;
				$total_hari_rawat_dua_bedah = 0;
				$total_hari_rawat_tiga_bedah = 0;

				$rowCountbedah = 337;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexbedah = $rowCountbedah++;
					$pasien_awal_bedah = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_bedah)->row();
					$pasien_masuk_bedah = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_bedah)->row();
					$pasien_masuk_pindah_bedah = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_bedah)->row();
					$pasien_keluar_pindah_bedah = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_bedah)->row();
					$pasien_keluar_hidup_bedah = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_bedah)->row();
					$pasien_keluar_mati_bedah = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_bedah)->row();
					$pasien_keluar_hidup_mati_bedah = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_bedah)->row();
					$pasien_mati_krg_48_bedah = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_bedah)->row();
					$pasien_mati_lbh_48_bedah = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_bedah)->row();
					$lama_rawat_bedah = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_bedah)->row();
					$hari_rawat_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_bedah)->row();
					$hari_rawat_vip_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_bedah)->row();
					$hari_rawat_satu_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_bedah)->row();
					$hari_rawat_dua_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_bedah)->row();
					$hari_rawat_tiga_bedah = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_bedah)->row();

					$sheet->SetCellValue('A'.$indexbedah, $i);
					$sheet->SetCellValue('B'.$indexbedah, $pasien_awal_bedah->jml);
					$sheet->SetCellValue('C'.$indexbedah, $pasien_masuk_bedah->jml);
					$sheet->SetCellValue('D'.$indexbedah, $pasien_masuk_pindah_bedah->jml);
			
					$total_pasien_dirawat_bedah = $pasien_awal_bedah->jml + $pasien_masuk_bedah->jml + $pasien_masuk_pindah_bedah->jml;
                                 
					$sheet->SetCellValue('E'.$indexbedah, $total_pasien_dirawat_bedah);
					$sheet->SetCellValue('F'.$indexbedah, $pasien_keluar_pindah_bedah->jml);
					$sheet->SetCellValue('G'.$indexbedah, $pasien_keluar_hidup_bedah->jml);
					$sheet->SetCellValue('H'.$indexbedah, $pasien_keluar_mati_bedah->jml);
					$total_pasien_keluar_bedah = $pasien_keluar_pindah_bedah->jml + $pasien_keluar_hidup_bedah->jml + $pasien_keluar_mati_bedah->jml;
					$sheet->SetCellValue('I'.$indexbedah, $total_pasien_keluar_bedah);
					$sheet->SetCellValue('J'.$indexbedah, $pasien_keluar_hidup_mati_bedah->jml);
					$sheet->SetCellValue('K'.$indexbedah, $pasien_mati_krg_48_bedah->jml );
					$sheet->SetCellValue('L'.$indexbedah, $pasien_mati_lbh_48_bedah->jml);
					$sheet->SetCellValue('M'.$indexbedah, $lama_rawat_bedah->jml);
					if($i <= date('j')){
						$harirawat_bedah = $hari_rawat_bedah->jml;
						$harirawat_vip_bedah = $hari_rawat_vip_bedah->jml ;
						$harirawat_satu_bedah = $hari_rawat_satu_bedah->jml;
						$harirawat_dua_bedah = $hari_rawat_dua_bedah->jml;
						$harirawat_tiga_bedah = $hari_rawat_tiga_bedah->jml;
					}else{
						$harirawat_bedah = 0;
						$harirawat_vip_bedah = 0;
						$harirawat_satu_bedah = 0;
						$harirawat_dua_bedah = 0;
						$harirawat_tiga_bedah = 0;
					}
					$sheet->SetCellValue('N'.$indexbedah, $harirawat_bedah);
					$sheet->SetCellValue('O'.$indexbedah, $harirawat_vip_bedah);
					$sheet->SetCellValue('P'.$indexbedah, $harirawat_satu_bedah);
					$sheet->SetCellValue('Q'.$indexbedah, $harirawat_dua_bedah);
					$sheet->SetCellValue('R'.$indexbedah, $harirawat_tiga_bedah);

					$total_pasien_awal_bedah += $pasien_awal_bedah->jml;
					$total_pasien_masuk_bedah += $pasien_masuk_bedah->jml;
					$total_pasien_masuk_pindah_bedah += $pasien_masuk_pindah_bedah->jml;
					$total_pasien_dirawat_all_bedah += $total_pasien_dirawat_bedah;
					$total_pasien_keluar_pindah_bedah += $pasien_keluar_pindah_bedah->jml;
					$total_pasien_keluar_mati_bedah += $pasien_keluar_mati_bedah->jml;
					$total_pasien_keluar_hidup_bedah += $pasien_keluar_hidup_bedah->jml;
					$total_pasien_keluar_all_bedah += $total_pasien_keluar_bedah;
					$total_pasien_keluar_hidup_mati_bedah += $pasien_keluar_hidup_mati_bedah->jml;
					$total_pasien_mati_krg48_bedah += $pasien_mati_krg_48_bedah->jml;
					$total_pasien_mati_lbh48_bedah += $pasien_mati_lbh_48_bedah->jml;
					$total_lama_rawat_bedah += $lama_rawat_bedah->jml;
					$total_hari_rawat_bedah += $harirawat_bedah;
					$total_hari_rawat_vip_bedah += $harirawat_vip_bedah;
					$total_hari_rawat_satu_bedah += $harirawat_satu_bedah;
					$total_hari_rawat_dua_bedah += $harirawat_dua_bedah;
					$total_hari_rawat_tiga_bedah += $harirawat_tiga_bedah;
				}

				// KEBIDANAN

				$sheet->mergeCells('F371:I371')
				->getCell('F371')
				->setValue('PELAYANAN RAWAT INAP KEBIDANAN');

				$sheet->SetCellValue('A372','Tanggal');
				$sheet->SetCellValue('B372','Pasien Awal');
				$sheet->SetCellValue('C372','Pasien Masuk');
				$sheet->SetCellValue('D372','Pasien Pindah');
				$sheet->SetCellValue('E372','Jumlah Pend Dirawat');
				$sheet->mergeCells('F372:I372')
				->getCell('F372')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J372','Pasien Keluar H + M');
				$sheet->mergeCells('K372:L372')
				->getCell('K372')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M372','Total Lama dirawat');
				$sheet->SetCellValue('N372','Jumlah Hari Rawatan');
				$sheet->mergeCells('O372:R372')
				->getCell('O372')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F373','Di pindahkan');
				$sheet->SetCellValue('G373','Hidup');
				$sheet->SetCellValue('H373','Mati');
				$sheet->SetCellValue('I373','Total');
				$sheet->SetCellValue('K373','< 48 Jam');
				$sheet->SetCellValue('L373','≥ 48 Jam');
				$sheet->SetCellValue('O373','VIP');
				$sheet->SetCellValue('P373','I');
				$sheet->SetCellValue('Q373','II');
				$sheet->SetCellValue('R373','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_bidan = "idrg IN ('0503','0107')";
				$total_pasien_awal_bidan = 0;
				$total_pasien_masuk_bidan = 0;
				$total_pasien_masuk_pindah_bidan = 0;
				$total_pasien_dirawat_all_bidan = 0;
				$total_pasien_keluar_pindah_bidan = 0;
				$total_pasien_keluar_hidup_bidan = 0;
				$total_pasien_keluar_mati_bidan = 0;
				$total_pasien_keluar_all_bidan = 0;
				$total_pasien_keluar_hidup_mati_bidan = 0;
				$total_pasien_mati_krg48_bidan= 0;
				$total_pasien_mati_lbh48_bidan = 0;
				$total_lama_rawat_bidan = 0;
				$total_hari_rawat_bidan = 0;
				$total_hari_rawat_vip_bidan = 0;
				$total_hari_rawat_satu_bidan = 0;
				$total_hari_rawat_dua_bidan = 0;
				$total_hari_rawat_tiga_bidan = 0;

				$rowCountbidan = 374;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexbidan = $rowCountbidan++;
					$pasien_awal_bidan = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_bidan)->row();
					$pasien_masuk_bidan = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_bidan)->row();
					$pasien_masuk_pindah_bidan = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_bidan)->row();
					$pasien_keluar_pindah_bidan = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_bidan)->row();
					$pasien_keluar_hidup_bidan = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_bidan)->row();
					$pasien_keluar_mati_bidan = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_bidan)->row();
					$pasien_keluar_hidup_mati_bidan = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_bidan)->row();
					$pasien_mati_krg_48_bidan = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_bidan)->row();
					$pasien_mati_lbh_48_bidan = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_bidan)->row();
					$lama_rawat_bidan = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_bidan)->row();
					$hari_rawat_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_bidan)->row();
					$hari_rawat_vip_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_bidan)->row();
					$hari_rawat_satu_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_bidan)->row();
					$hari_rawat_dua_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_bidan)->row();
					$hari_rawat_tiga_bidan = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_bidan)->row();

					$sheet->SetCellValue('A'.$indexbidan, $i);
					$sheet->SetCellValue('B'.$indexbidan, $pasien_awal_bidan->jml);
					$sheet->SetCellValue('C'.$indexbidan, $pasien_masuk_bidan->jml);
					$sheet->SetCellValue('D'.$indexbidan, $pasien_masuk_pindah_bidan->jml);
			
					$total_pasien_dirawat_bidan = $pasien_awal_bidan->jml + $pasien_masuk_bidan->jml + $pasien_masuk_pindah_bidan->jml;
                                 
					$sheet->SetCellValue('E'.$indexbidan, $total_pasien_dirawat_bidan);
					$sheet->SetCellValue('F'.$indexbidan, $pasien_keluar_pindah_bidan->jml);
					$sheet->SetCellValue('G'.$indexbidan, $pasien_keluar_hidup_bidan->jml);
					$sheet->SetCellValue('H'.$indexbidan, $pasien_keluar_mati_bidan->jml);
					$total_pasien_keluar_bidan = $pasien_keluar_pindah_bidan->jml + $pasien_keluar_hidup_bidan->jml + $pasien_keluar_mati_bidan->jml;
					$sheet->SetCellValue('I'.$indexbidan, $total_pasien_keluar_bidan);
					$sheet->SetCellValue('J'.$indexbidan, $pasien_keluar_hidup_mati_bidan->jml);
					$sheet->SetCellValue('K'.$indexbidan, $pasien_mati_krg_48_bidan->jml );
					$sheet->SetCellValue('L'.$indexbidan, $pasien_mati_lbh_48_bidan->jml);
					$sheet->SetCellValue('M'.$indexbidan, $lama_rawat_bidan->jml);
					if($i <= date('j')){
						$harirawat_bidan = $hari_rawat_bidan->jml;
						$harirawat_vip_bidan = $hari_rawat_vip_bidan->jml ;
						$harirawat_satu_bidan = $hari_rawat_satu_bidan->jml;
						$harirawat_dua_bidan = $hari_rawat_dua_bidan->jml;
						$harirawat_tiga_bidan = $hari_rawat_tiga_bidan->jml;
					}else{
						$harirawat_bidan = 0;
						$harirawat_vip_bidan = 0;
						$harirawat_satu_bidan = 0;
						$harirawat_dua_bidan = 0;
						$harirawat_tiga_bidan = 0;
					}
					$sheet->SetCellValue('N'.$indexbidan, $harirawat_bidan);
					$sheet->SetCellValue('O'.$indexbidan, $harirawat_vip_bidan);
					$sheet->SetCellValue('P'.$indexbidan, $harirawat_satu_bidan);
					$sheet->SetCellValue('Q'.$indexbidan, $harirawat_dua_bidan);
					$sheet->SetCellValue('R'.$indexbidan, $harirawat_tiga_bidan);

					$total_pasien_awal_bidan += $pasien_awal_bidan->jml;
					$total_pasien_masuk_bidan += $pasien_masuk_bidan->jml;
					$total_pasien_masuk_pindah_bidan += $pasien_masuk_pindah_bidan->jml;
					$total_pasien_dirawat_all_bidan += $total_pasien_dirawat_bidan;
					$total_pasien_keluar_pindah_bidan += $pasien_keluar_pindah_bidan->jml;
					$total_pasien_keluar_mati_bidan += $pasien_keluar_mati_bidan->jml;
					$total_pasien_keluar_hidup_bidan += $pasien_keluar_hidup_bidan->jml;
					$total_pasien_keluar_all_bidan += $total_pasien_keluar_bidan;
					$total_pasien_keluar_hidup_mati_bidan += $pasien_keluar_hidup_mati_bidan->jml;
					$total_pasien_mati_krg48_bidan += $pasien_mati_krg_48_bidan->jml;
					$total_pasien_mati_lbh48_bidan += $pasien_mati_lbh_48_bidan->jml;
					$total_lama_rawat_bidan += $lama_rawat_bidan->jml;
					$total_hari_rawat_bidan += $harirawat_bidan;
					$total_hari_rawat_vip_bidan += $harirawat_vip_bidan;
					$total_hari_rawat_satu_bidan += $harirawat_satu_bidan;
					$total_hari_rawat_dua_bidan += $harirawat_dua_bidan;
					$total_hari_rawat_tiga_bidan += $harirawat_tiga_bidan;
				}

				// ICU
				$sheet->mergeCells('F408:I408')
				->getCell('F408')
				->setValue('PELAYANAN RAWAT INAP ICU');

				$sheet->SetCellValue('A409','Tanggal');
				$sheet->SetCellValue('B409','Pasien Awal');
				$sheet->SetCellValue('C409','Pasien Masuk');
				$sheet->SetCellValue('D409','Pasien Pindah');
				$sheet->SetCellValue('E409','Jumlah Pend Dirawat');
				$sheet->mergeCells('F409:I409')
				->getCell('F409')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J409','Pasien Keluar H + M');
				$sheet->mergeCells('K409:L409')
				->getCell('K409')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M409','Total Lama dirawat');
				$sheet->SetCellValue('N409','Jumlah Hari Rawatan');
				$sheet->mergeCells('O409:R409')
				->getCell('O409')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F410','Di pindahkan');
				$sheet->SetCellValue('G410','Hidup');
				$sheet->SetCellValue('H410','Mati');
				$sheet->SetCellValue('I410','Total');
				$sheet->SetCellValue('K410','< 48 Jam');
				$sheet->SetCellValue('L410','≥ 48 Jam');
				$sheet->SetCellValue('O410','VIP');
				$sheet->SetCellValue('P410','I');
				$sheet->SetCellValue('Q410','II');
				$sheet->SetCellValue('R410','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_icu = "idrg IN ('0404','0704')";
				$total_pasien_awal_icu = 0;
				$total_pasien_masuk_icu = 0;
				$total_pasien_masuk_pindah_icu = 0;
				$total_pasien_dirawat_all_icu = 0;
				$total_pasien_keluar_pindah_icu = 0;
				$total_pasien_keluar_hidup_icu = 0;
				$total_pasien_keluar_mati_icu = 0;
				$total_pasien_keluar_all_icu = 0;
				$total_pasien_keluar_hidup_mati_icu = 0;
				$total_pasien_mati_krg48_icu= 0;
				$total_pasien_mati_lbh48_icu = 0;
				$total_lama_rawat_icu = 0;
				$total_hari_rawat_icu = 0;
				$total_hari_rawat_vip_icu = 0;
				$total_hari_rawat_satu_icu = 0;
				$total_hari_rawat_dua_icu = 0;
				$total_hari_rawat_tiga_icu = 0;
        
				$rowCounticu = 411;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexicu = $rowCounticu++;
					$pasien_awal_icu = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_icu)->row();
					$pasien_masuk_icu = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_icu)->row();
					$pasien_masuk_pindah_icu = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_icu)->row();
					$pasien_keluar_pindah_icu = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_icu)->row();
					$pasien_keluar_hidup_icu = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_icu)->row();
					$pasien_keluar_mati_icu = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_icu)->row();
					$pasien_keluar_hidup_mati_icu = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_icu)->row();
					$pasien_mati_krg_48_icu = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_icu)->row();
					$pasien_mati_lbh_48_icu = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_icu)->row();
					$lama_rawat_icu = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_icu)->row();
					$hari_rawat_icu = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_icu)->row();
					$hari_rawat_vip_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_icu)->row();
					$hari_rawat_satu_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_icu)->row();
					$hari_rawat_dua_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_icu)->row();
					$hari_rawat_tiga_icu = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_icu)->row();

					$sheet->SetCellValue('A'.$indexicu, $i);
					$sheet->SetCellValue('B'.$indexicu, $pasien_awal_icu->jml);
					$sheet->SetCellValue('C'.$indexicu, $pasien_masuk_icu->jml);
					$sheet->SetCellValue('D'.$indexicu, $pasien_masuk_pindah_icu->jml);
			
					$total_pasien_dirawat_icu = $pasien_awal_icu->jml + $pasien_masuk_icu->jml + $pasien_masuk_pindah_icu->jml;
                                 
					$sheet->SetCellValue('E'.$indexicu, $total_pasien_dirawat_icu);
					$sheet->SetCellValue('F'.$indexicu, $pasien_keluar_pindah_icu->jml);
					$sheet->SetCellValue('G'.$indexicu, $pasien_keluar_hidup_icu->jml);
					$sheet->SetCellValue('H'.$indexicu, $pasien_keluar_mati_icu->jml);
					$total_pasien_keluar_icu = $pasien_keluar_pindah_icu->jml + $pasien_keluar_hidup_icu->jml + $pasien_keluar_mati_icu->jml;
					$sheet->SetCellValue('I'.$indexicu, $total_pasien_keluar_icu);
					$sheet->SetCellValue('J'.$indexicu, $pasien_keluar_hidup_mati_icu->jml);
					$sheet->SetCellValue('K'.$indexicu, $pasien_mati_krg_48_icu->jml );
					$sheet->SetCellValue('L'.$indexicu, $pasien_mati_lbh_48_icu->jml);
					$sheet->SetCellValue('M'.$indexicu, $lama_rawat_icu->jml);
					if($i <= date('j')){
						$harirawat_icu = $hari_rawat_icu->jml;
						$harirawat_vip_icu = $hari_rawat_vip_icu->jml ;
						$harirawat_satu_icu = $hari_rawat_satu_icu->jml;
						$harirawat_dua_icu = $hari_rawat_dua_icu->jml;
						$harirawat_tiga_icu = $hari_rawat_tiga_icu->jml;
					}else{
						$harirawat_icu = 0;
						$harirawat_vip_icu = 0;
						$harirawat_satu_icu = 0;
						$harirawat_dua_icu = 0;
						$harirawat_tiga_icu = 0;
					}
					$sheet->SetCellValue('N'.$indexicu, $harirawat_icu);
					$sheet->SetCellValue('O'.$indexicu, $harirawat_vip_icu);
					$sheet->SetCellValue('P'.$indexicu, $harirawat_satu_icu);
					$sheet->SetCellValue('Q'.$indexicu, $harirawat_dua_icu);
					$sheet->SetCellValue('R'.$indexicu, $harirawat_tiga_icu);

					$total_pasien_awal_icu += $pasien_awal_icu->jml;
					$total_pasien_masuk_icu += $pasien_masuk_icu->jml;
					$total_pasien_masuk_pindah_icu += $pasien_masuk_pindah_icu->jml;
					$total_pasien_dirawat_all_icu += $total_pasien_dirawat_icu;
					$total_pasien_keluar_pindah_icu += $pasien_keluar_pindah_icu->jml;
					$total_pasien_keluar_mati_icu += $pasien_keluar_mati_icu->jml;
					$total_pasien_keluar_hidup_icu += $pasien_keluar_hidup_icu->jml;
					$total_pasien_keluar_all_icu += $total_pasien_keluar_icu;
					$total_pasien_keluar_hidup_mati_icu += $pasien_keluar_hidup_mati_icu->jml;
					$total_pasien_mati_krg48_icu += $pasien_mati_krg_48_icu->jml;
					$total_pasien_mati_lbh48_icu += $pasien_mati_lbh_48_icu->jml;
					$total_lama_rawat_icu += $lama_rawat_icu->jml;
					$total_hari_rawat_icu += $harirawat_icu;
					$total_hari_rawat_vip_icu += $harirawat_vip_icu;
					$total_hari_rawat_satu_icu += $harirawat_satu_icu;
					$total_hari_rawat_dua_icu += $harirawat_dua_icu;
					$total_hari_rawat_tiga_icu += $harirawat_tiga_icu;
				}

				// NICU
				$sheet->mergeCells('F445:I445')
				->getCell('F445')
				->setValue('PELAYANAN RAWAT INAP NICU');

				$sheet->SetCellValue('A446','Tanggal');
				$sheet->SetCellValue('B446','Pasien Awal');
				$sheet->SetCellValue('C446','Pasien Masuk');
				$sheet->SetCellValue('D446','Pasien Pindah');
				$sheet->SetCellValue('E446','Jumlah Pend Dirawat');
				$sheet->mergeCells('F446:I446')
				->getCell('F446')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('J446','Pasien Keluar H + M');
				$sheet->mergeCells('K409:L446')
				->getCell('K446')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('M446','Total Lama dirawat');
				$sheet->SetCellValue('N446','Jumlah Hari Rawatan');
				$sheet->mergeCells('O446:R446')
				->getCell('O446')
				->setValue('Rincian Hari Rawatan Perkelas');

				$sheet->SetCellValue('F447','Di pindahkan');
				$sheet->SetCellValue('G447','Hidup');
				$sheet->SetCellValue('H447','Mati');
				$sheet->SetCellValue('I447','Total');
				$sheet->SetCellValue('K447','< 48 Jam');
				$sheet->SetCellValue('L447','≥ 48 Jam');
				$sheet->SetCellValue('O447','VIP');
				$sheet->SetCellValue('P447','I');
				$sheet->SetCellValue('Q447','II');
				$sheet->SetCellValue('R447','III');

				$bulan_search = explode('-',$bulan_now);
				$tahun = $bulan_search[0];
				$bulan = $bulan_search[1];
				$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
				$where_nicu = "idrg = '0406'";
				$total_pasien_awal_nicu = 0;
				$total_pasien_masuk_nicu = 0;
				$total_pasien_masuk_pindah_nicu = 0;
				$total_pasien_dirawat_all_nicu = 0;
				$total_pasien_keluar_pindah_nicu = 0;
				$total_pasien_keluar_hidup_nicu = 0;
				$total_pasien_keluar_mati_nicu = 0;
				$total_pasien_keluar_all_nicu = 0;
				$total_pasien_keluar_hidup_mati_nicu = 0;
				$total_pasien_mati_krg48_nicu= 0;
				$total_pasien_mati_lbh48_nicu = 0;
				$total_lama_rawat_nicu = 0;
				$total_hari_rawat_nicu = 0;
				$total_hari_rawat_vip_nicu = 0;
				$total_hari_rawat_satu_nicu = 0;
				$total_hari_rawat_dua_nicu = 0;
				$total_hari_rawat_tiga_nicu = 0;

				$rowCountNicu = 448;
				for ($i=1; $i < $tanggal+1; $i++) { 
					$tgl = $tahun.'-'.$bulan.'-'.$i;
					$tgl_format = date('Y-m-d',strtotime($tgl));
					$indexNicu = $rowCountNicu++;
					$pasien_awal_nicu = $this->Rjmlaporan->get_pasien_awal_ruangan($tgl_format,$where_nicu)->row();
					$pasien_masuk_nicu = $this->Rjmlaporan->get_pasien_masuk_ruangan($tgl_format,$where_nicu)->row();
					$pasien_masuk_pindah_nicu = $this->Rjmlaporan->get_pasien_masuk_pindah_ruangan($tgl_format,$where_nicu)->row();
					$pasien_keluar_pindah_nicu = $this->Rjmlaporan->get_pasien_keluar_pindah_ruangan($tgl_format,$where_nicu)->row();
					$pasien_keluar_hidup_nicu = $this->Rjmlaporan->get_pasien_keluar_hidup_ruangan($tgl_format,$where_nicu)->row();
					$pasien_keluar_mati_nicu = $this->Rjmlaporan->get_pasien_keluar_mati_ruangan($tgl_format,$where_nicu)->row();
					$pasien_keluar_hidup_mati_nicu = $this->Rjmlaporan->get_pasien_keluar_hidup_mati_ruangan($tgl_format,$where_nicu)->row();
					$pasien_mati_krg_48_nicu = $this->Rjmlaporan->get_pasien_mati_krg48_ruangan($tgl_format,$where_nicu)->row();
					$pasien_mati_lbh_48_nicu = $this->Rjmlaporan->get_pasien_mati_lbh48_ruangan($tgl_format,$where_nicu)->row();
					$lama_rawat_nicu = $this->Rjmlaporan->get_lama_rawat_ruangan($tgl_format,$where_nicu)->row();
					$hari_rawat_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan($tgl_format,$where_nicu)->row();
					$hari_rawat_vip_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_vip($tgl_format,$where_nicu)->row();
					$hari_rawat_satu_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_satu($tgl_format,$where_nicu)->row();
					$hari_rawat_dua_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_dua($tgl_format,$where_nicu)->row();
					$hari_rawat_tiga_nicu = $this->Rjmlaporan->get_hari_rawat_ruangan_tiga($tgl_format,$where_nicu)->row();

					$sheet->SetCellValue('A'.$indexNicu, $i);
					$sheet->SetCellValue('B'.$indexNicu, $pasien_awal_nicu->jml);
					$sheet->SetCellValue('C'.$indexNicu, $pasien_masuk_nicu->jml);
					$sheet->SetCellValue('D'.$indexNicu, $pasien_masuk_pindah_nicu->jml);
			
					$total_pasien_dirawat_nicu = $pasien_awal_nicu->jml + $pasien_masuk_nicu->jml + $pasien_masuk_pindah_nicu->jml;
                                 
					$sheet->SetCellValue('E'.$indexNicu, $total_pasien_dirawat_nicu);
					$sheet->SetCellValue('F'.$indexNicu, $pasien_keluar_pindah_nicu->jml);
					$sheet->SetCellValue('G'.$indexNicu, $pasien_keluar_hidup_nicu->jml);
					$sheet->SetCellValue('H'.$indexNicu, $pasien_keluar_mati_nicu->jml);
					$total_pasien_keluar_nicu = $pasien_keluar_pindah_nicu->jml + $pasien_keluar_hidup_nicu->jml + $pasien_keluar_mati_nicu->jml;
					$sheet->SetCellValue('I'.$indexNicu, $total_pasien_keluar_nicu);
					$sheet->SetCellValue('J'.$indexNicu, $pasien_keluar_hidup_mati_nicu->jml);
					$sheet->SetCellValue('K'.$indexNicu, $pasien_mati_krg_48_nicu->jml );
					$sheet->SetCellValue('L'.$indexNicu, $pasien_mati_lbh_48_nicu->jml);
					$sheet->SetCellValue('M'.$indexNicu, $lama_rawat_nicu->jml);
					if($i <= date('j')){
						$harirawat_nicu = $hari_rawat_nicu->jml;
						$harirawat_vip_nicu = $hari_rawat_vip_nicu->jml ;
						$harirawat_satu_nicu = $hari_rawat_satu_nicu->jml;
						$harirawat_dua_nicu = $hari_rawat_dua_nicu->jml;
						$harirawat_tiga_nicu = $hari_rawat_tiga_nicu->jml;
					}else{
						$harirawat_nicu = 0;
						$harirawat_vip_nicu = 0;
						$harirawat_satu_nicu = 0;
						$harirawat_dua_nicu = 0;
						$harirawat_tiga_nicu = 0;
					}
					$sheet->SetCellValue('N'.$indexNicu, $harirawat_nicu);
					$sheet->SetCellValue('O'.$indexNicu, $harirawat_vip_nicu);
					$sheet->SetCellValue('P'.$indexNicu, $harirawat_satu_nicu);
					$sheet->SetCellValue('Q'.$indexNicu, $harirawat_dua_nicu);
					$sheet->SetCellValue('R'.$indexNicu, $harirawat_tiga_nicu);

					$total_pasien_awal_nicu += $pasien_awal_nicu->jml;
					$total_pasien_masuk_nicu += $pasien_masuk_nicu->jml;
					$total_pasien_masuk_pindah_nicu += $pasien_masuk_pindah_nicu->jml;
					$total_pasien_dirawat_all_nicu += $total_pasien_dirawat_nicu;
					$total_pasien_keluar_pindah_nicu += $pasien_keluar_pindah_nicu->jml;
					$total_pasien_keluar_mati_nicu += $pasien_keluar_mati_nicu->jml;
					$total_pasien_keluar_hidup_nicu += $pasien_keluar_hidup_nicu->jml;
					$total_pasien_keluar_all_nicu += $total_pasien_keluar_nicu;
					$total_pasien_keluar_hidup_mati_nicu += $pasien_keluar_hidup_mati_nicu->jml;
					$total_pasien_mati_krg48_nicu += $pasien_mati_krg_48_nicu->jml;
					$total_pasien_mati_lbh48_nicu += $pasien_mati_lbh_48_nicu->jml;
					$total_lama_rawat_nicu += $lama_rawat_nicu->jml;
					$total_hari_rawat_nicu += $harirawat_nicu;
					$total_hari_rawat_vip_nicu += $harirawat_vip_nicu;
					$total_hari_rawat_satu_nicu += $harirawat_satu_nicu;
					$total_hari_rawat_dua_nicu += $harirawat_dua_nicu;
					$total_hari_rawat_tiga_nicu += $harirawat_tiga_nicu;
				}

				// total limpapeh l2
				$sheet->mergeCells('Z4:AC4')
				->getCell('Z4')
				->setValue('PELAYANAN RAWAT INAP');

				$sheet->SetCellValue('W5','Ruangan');
				$sheet->SetCellValue('X5','Pasien Awal');
				$sheet->SetCellValue('Y5','Pasien Masuk');
				$sheet->SetCellValue('Z5','Pasien Pindah');
				$sheet->SetCellValue('AA5','Jumlah Pend Dirawat');
				$sheet->mergeCells('AB5:AE5')
				->getCell('AB5')
				->setValue('Pasien Keluar');
				$sheet->SetCellValue('AF5','Pasien Keluar H + M');
				$sheet->mergeCells('AG5:AH5')
				->getCell('AG5')
				->setValue('Perincian Keluar Mati');
				$sheet->SetCellValue('AI5','Total Lama dirawat');
				$sheet->SetCellValue('AJ5','Pasien Akhir');
				$sheet->SetCellValue('AK5','Jumlah Hari Rawatan');
				$sheet->mergeCells('AL5:AO5')
				->getCell('AL5')
				->setValue('Rincian Hari Rawatan Perkelas');
				$sheet->mergeCells('AP5:AT5')
				->getCell('AP5')
				->setValue('Jumlah TT');

				$sheet->mergeCells('AU5:AX5')
				->getCell('AU5')
				->setValue('BOR Kelas');

				$sheet->SetCellValue('AY5','BOR');

				$sheet->SetCellValue('AB6','Di pindahkan');
				$sheet->SetCellValue('AC6','Hidup');
				$sheet->SetCellValue('AD6','Mati');
				$sheet->SetCellValue('AE6','Total');

				$sheet->SetCellValue('AG6','< 48 Jam');
				$sheet->SetCellValue('AH6','≥ 48 Jam');

				$sheet->SetCellValue('AL6','VIP');
				$sheet->SetCellValue('AM6','I');
				$sheet->SetCellValue('AN6','II');
				$sheet->SetCellValue('AO6','III');

				$sheet->SetCellValue('AP6','VIP');
				$sheet->SetCellValue('AQ6','I');
				$sheet->SetCellValue('AR6','II');
				$sheet->SetCellValue('AS6','III');
				$sheet->SetCellValue('AT6','JML');

				$sheet->SetCellValue('AU6','VIP');
				$sheet->SetCellValue('AV6','I');
				$sheet->SetCellValue('AW6','II');
				$sheet->SetCellValue('AX6','III');

				$sheet->SetCellValue('W7','LIMPAPEH L2');
				$sheet->SetCellValue('X7', $pasien_awal_all_ruangan->limpapeh_l2);
				$sheet->SetCellValue('Y7', $total_pasien_masuk);
				$sheet->SetCellValue('Z7', $total_pasien_masuk_pindah);
				$sheet->SetCellValue('AA7', $total_pasien_dirawat_all);
				$sheet->SetCellValue('AB7', $total_pasien_keluar_pindah);
				$sheet->SetCellValue('AC7', $total_pasien_keluar_hidup);
				$sheet->SetCellValue('AD7', $total_pasien_keluar_mati);
				$sheet->SetCellValue('AE7', $total_pasien_keluar_all);
				$sheet->SetCellValue('AF7', $total_pasien_keluar_hidup_mati);
				$sheet->SetCellValue('AG7', $total_pasien_mati_krg48);
				$sheet->SetCellValue('AH7', $total_pasien_mati_lbh48);
				$sheet->SetCellValue('AI7', $total_lama_rawat);
				
				$jml_pasien_akhir = $total_pasien_dirawat_all - $total_pasien_keluar_all;
			
				$sheet->SetCellValue('AJ7', $jml_pasien_akhir);
				$sheet->SetCellValue('AK7', $total_hari_rawat);
				$sheet->SetCellValue('AL7', $total_hari_rawat_vip);
				$sheet->SetCellValue('AM7', $total_hari_rawat_satu);
				$sheet->SetCellValue('AN7', $total_hari_rawat_dua);
				$sheet->SetCellValue('AO7', $total_hari_rawat_tiga);
				$total_bed_limpapeh_l2 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP7', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ7', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR7', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS7',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'LIMPAPEH L2'){ 
						$total_bed_limpapeh_l2 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT7', $total_bed_limpapeh_l2);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_limpapeh_l2 = $tot_tt->bed;
				}}

				if($tt_vip_limpapeh_l2 == '0'){
					$bor_limpapehl2_vip = 0;
				}else{
					$bor_kali_limpapeh_l2_vip =  $tt_vip_limpapeh_l2 * $periode;
					$bor_bagi_limpapeh_l2_vip = $total_hari_rawat_vip / $bor_kali_limpapeh_l2_vip;
					$bor_limpapehl2_vip =  $bor_bagi_limpapeh_l2_vip * 100;
				}

				$sheet->SetCellValue('AU7', number_format($bor_limpapehl2_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'I'){ 
						$tt_satu_limpapeh_l2 = $tot_tt->bed;
				}}

				if($tt_satu_limpapeh_l2 == '0'){
					$bor_limpapeh_l2_satu = 0;
				}else{
					$bor_kali_limpapeh_l2_satu =  $tt_satu_limpapeh_l2 * $periode;
					$bor_bagi_limpapeh_l2_satu = $total_hari_rawat_satu / $bor_kali_limpapeh_l2_satu;
					$bor_limpapeh_l2_satu =  $bor_bagi_limpapeh_l2_satu * 100;
				}

				$sheet->SetCellValue('AV7', number_format($bor_limpapeh_l2_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'II'){ 
						$tt_dua_limpapeh_l2 = $tot_tt->bed;
				}}

				if($tt_dua_limpapeh_l2 == '0'){
					$bor_limpapeh_l2_dua = 0;
				}else{
					$bor_kali_limpapeh_l2_dua =  $tt_dua_limpapeh_l2 * $periode;
					$bor_bagi_limpapeh_l2_dua = $total_hari_rawat_dua / $bor_kali_limpapeh_l2_dua;
					$bor_limpapeh_l2_dua =  $bor_bagi_limpapeh_l2_dua * 100;                                           
				}
				$sheet->SetCellValue('AW7',  number_format($bor_limpapeh_l2_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L2' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_limpapeh_l2 = $tot_tt->bed;
				}}

				if($tt_tiga_limpapeh_l2 == '0'){
					$bor_limpapeh_l2_tiga = 0;
				}else{
					$bor_kali_limpapeh_l2_tiga =  $tt_tiga_limpapeh_l2 * $periode;
					$bor_bagi_limpapeh_l2_tiga = $total_hari_rawat_tiga / $bor_kali_limpapeh_l2_tiga;
					$bor_limpapeh_l2_tiga = $bor_bagi_limpapeh_l2_tiga * 100;
				}
				$sheet->SetCellValue('AX7', number_format($bor_limpapeh_l2_tiga,2).'%');

				if( $total_bed_limpapeh_l2 == '0'){
					$bor_limpapeh_l2_all = 0;
				}else{
					$bor_kali_limpapeh_l2_all =  $total_bed_limpapeh_l2 * $periode;
					$bor_bagi_limpapeh_l2_all = $total_hari_rawat / $bor_kali_limpapeh_l2_all;
					$bor_limpapeh_l2_all = $bor_bagi_limpapeh_l2_all * 100;
				}
				$sheet->SetCellValue('AY7', number_format($bor_limpapeh_l2_all,2).'%');

				// total limpapeh l3
				$sheet->SetCellValue('W8','LIMPAPEH L3');
				$sheet->SetCellValue('X8', $pasien_awal_all_ruangan->limpapeh_l3);
				$sheet->SetCellValue('Y8', $total_pasien_masuk_limpapeh_l3);
				$sheet->SetCellValue('Z8', $total_pasien_masuk_pindah_limpapeh_l3);
				$sheet->SetCellValue('AA8', $total_pasien_dirawat_all_limpapeh_l3);
				$sheet->SetCellValue('AB8', $total_pasien_keluar_pindah_limpapeh_l3);
				$sheet->SetCellValue('AC8', $total_pasien_keluar_hidup_limpapeh_l3);
				$sheet->SetCellValue('AD8', $total_pasien_keluar_mati_limpapeh_l3);
				$sheet->SetCellValue('AE8', $total_pasien_keluar_all_limpapeh_l3);
				$sheet->SetCellValue('AF8', $total_pasien_keluar_hidup_mati_limpapeh_l3);
				$sheet->SetCellValue('AG8', $total_pasien_mati_krg48_limpapeh_l3);
				$sheet->SetCellValue('AH8', $total_pasien_mati_lbh48_limpapeh_l3);
				$sheet->SetCellValue('AI8', $total_lama_rawat_limpapeh_l3);
				
				$jml_pasien_akhir_limpapeh_l3 = $total_pasien_dirawat_all_limpapeh_l3 - $total_pasien_keluar_all_limpapeh_l3;
			
				$sheet->SetCellValue('AJ8', $jml_pasien_akhir_limpapeh_l3);
				$sheet->SetCellValue('AK8', $total_hari_rawat_limpapeh_l3);
				$sheet->SetCellValue('AL8', $total_hari_rawat_vip_limpapeh_l3);
				$sheet->SetCellValue('AM8', $total_hari_rawat_satu_limpapeh_l3);
				$sheet->SetCellValue('AN8', $total_hari_rawat_dua_limpapeh_l3);
				$sheet->SetCellValue('AO8', $total_hari_rawat_tiga_limpapeh_l3);
				$total_bed_limpapeh_l3 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP8', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ8', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR8', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS8',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'LIMPAPEH L3'){ 
						$total_bed_limpapeh_l3 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT8', $total_bed_limpapeh_l3);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_limpapeh_l3 = $tot_tt->bed;
				}}

				if($tt_vip_limpapeh_l3 == '0'){
					$bor_limpapehl3_vip = 0;
				}else{
					$bor_kali_limpapeh_l3_vip =  $tt_vip_limpapeh_l3 * $periode;
					$bor_bagi_limpapeh_l3_vip = $total_hari_rawat_vip_limpapeh_l3 / $bor_kali_limpapeh_l3_vip;
					$bor_limpapehl3_vip =  $bor_bagi_limpapeh_l3_vip * 100;
				}

				$sheet->SetCellValue('AU8', number_format($bor_limpapehl3_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'I'){ 
						$tt_satu_limpapeh_l3 = $tot_tt->bed;
				}}

				if($tt_satu_limpapeh_l3 == '0'){
					$bor_limpapeh_l3_satu = 0;
				}else{
					$bor_kali_limpapeh_l3_satu =  $tt_satu_limpapeh_l3 * $periode;
					$bor_bagi_limpapeh_l3_satu = $total_hari_rawat_satu_limpapeh_l3 / $bor_kali_limpapeh_l3_satu;
					$bor_limpapeh_l3_satu =  $bor_bagi_limpapeh_l3_satu * 100;
				}

				$sheet->SetCellValue('AV8', number_format($bor_limpapeh_l3_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'II'){ 
						$tt_dua_limpapeh_l3 = $tot_tt->bed;
				}}

				if($tt_dua_limpapeh_l3 == '0'){
					$bor_limpapeh_l3_dua = 0;
				}else{
					$bor_kali_limpapeh_l3_dua =  $tt_dua_limpapeh_l3 * $periode;
					$bor_bagi_limpapeh_l3_dua = $total_hari_rawat_dua_limpapeh_l3 / $bor_kali_limpapeh_l3_dua;
					$bor_limpapeh_l3_dua =  $bor_bagi_limpapeh_l3_dua * 100;                                           
				}
				$sheet->SetCellValue('AW8',  number_format($bor_limpapeh_l3_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L3' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_limpapeh_l3 = $tot_tt->bed;
				}}

				if($tt_tiga_limpapeh_l3 == '0'){
					$bor_limpapeh_l3_tiga = 0;
				}else{
					$bor_kali_limpapeh_l3_tiga =  $tt_tiga_limpapeh_l3 * $periode;
					$bor_bagi_limpapeh_l3_tiga = $total_hari_rawat_tiga_limpapeh_l3 / $bor_kali_limpapeh_l3_tiga;
					$bor_limpapeh_l3_tiga = $bor_bagi_limpapeh_l3_tiga * 100;
				}
				$sheet->SetCellValue('AX8', number_format($bor_limpapeh_l3_tiga,2).'%');

				if( $total_bed_limpapeh_l3 == '0'){
					$bor_limpapeh_l3_all = 0;
				}else{
					$bor_kali_limpapeh_l3_all =  $total_bed_limpapeh_l3 * $periode;
					$bor_bagi_limpapeh_l3_all = $total_hari_rawat_limpapeh_l3 / $bor_kali_limpapeh_l3_all;
					$bor_limpapeh_l3_all = $bor_bagi_limpapeh_l3_all * 100;
				}
				$sheet->SetCellValue('AY8', number_format($bor_limpapeh_l3_all,2).'%');

				// total limpapeh l4
				$sheet->SetCellValue('W9','LIMPAPEH L4');
				$sheet->SetCellValue('X9', $pasien_awal_all_ruangan->limpapeh_l4);
				$sheet->SetCellValue('Y9', $total_pasien_masuk_limpapeh_l4);
				$sheet->SetCellValue('Z9', $total_pasien_masuk_pindah_limpapeh_l4);
				$sheet->SetCellValue('AA9', $total_pasien_dirawat_all_limpapeh_l4);
				$sheet->SetCellValue('AB9', $total_pasien_keluar_pindah_limpapeh_l4);
				$sheet->SetCellValue('AC9', $total_pasien_keluar_hidup_limpapeh_l4);
				$sheet->SetCellValue('AD9', $total_pasien_keluar_mati_limpapeh_l4);
				$sheet->SetCellValue('AE9', $total_pasien_keluar_all_limpapeh_l4);
				$sheet->SetCellValue('AF9', $total_pasien_keluar_hidup_mati_limpapeh_l4);
				$sheet->SetCellValue('AG9', $total_pasien_mati_krg48_limpapeh_l4);
				$sheet->SetCellValue('AH9', $total_pasien_mati_lbh48_limpapeh_l4);
				$sheet->SetCellValue('AI9', $total_lama_rawat_limpapeh_l4);
				
				$jml_pasien_akhir_limpapeh_l4 = $total_pasien_dirawat_all_limpapeh_l4 - $total_pasien_keluar_all_limpapeh_l4;
			
				$sheet->SetCellValue('AJ9', $jml_pasien_akhir_limpapeh_l4);
				$sheet->SetCellValue('AK9', $total_hari_rawat_limpapeh_l4);
				$sheet->SetCellValue('AL9', $total_hari_rawat_vip_limpapeh_l4);
				$sheet->SetCellValue('AM9', $total_hari_rawat_satu_limpapeh_l4);
				$sheet->SetCellValue('AN9', $total_hari_rawat_dua_limpapeh_l4);
				$sheet->SetCellValue('AO9', $total_hari_rawat_tiga_limpapeh_l4);
				$total_bed_limpapeh_l4 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP9', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ9', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR9', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS9',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'LIMPAPEH L4'){ 
						$total_bed_limpapeh_l4 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT9', $total_bed_limpapeh_l4);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_limpapeh_l4 = $tot_tt->bed;
				}}

				if($tt_vip_limpapeh_l4 == '0'){
					$bor_limpapehl4_vip = 0;
				}else{
					$bor_kali_limpapeh_l4_vip =  $tt_vip_limpapeh_l4 * $periode;
					$bor_bagi_limpapeh_l4_vip = $total_hari_rawat_vip_limpapeh_l4 / $bor_kali_limpapeh_l4_vip;
					$bor_limpapehl4_vip =  $bor_bagi_limpapeh_l4_vip * 100;
				}

				$sheet->SetCellValue('AU9',  number_format($bor_limpapehl4_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'I'){ 
						$tt_satu_limpapeh_l4 = $tot_tt->bed;
				}}

				if($tt_satu_limpapeh_l4 == '0'){
					$bor_limpapeh_l4_satu = 0;
				}else{
					$bor_kali_limpapeh_l4_satu =  $tt_satu_limpapeh_l4 * $periode;
					$bor_bagi_limpapeh_l4_satu = $total_hari_rawat_satu_limpapeh_l4 / $bor_kali_limpapeh_l4_satu;
					$bor_limpapeh_l4_satu =  $bor_bagi_limpapeh_l4_satu * 100;
				}

				$sheet->SetCellValue('AV9',  number_format($bor_limpapeh_l4_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'II'){ 
						$tt_dua_limpapeh_l4 = $tot_tt->bed;
				}}

				if($tt_dua_limpapeh_l4 == '0'){
					$bor_limpapeh_l4_dua = 0;
				}else{
					$bor_kali_limpapeh_l4_dua =  $tt_dua_limpapeh_l4 * $periode;
					$bor_bagi_limpapeh_l4_dua = $total_hari_rawat_dua_limpapeh_l4 / $bor_kali_limpapeh_l4_dua;
					$bor_limpapeh_l4_dua =  $bor_bagi_limpapeh_l4_dua * 100;                                           
				}
				$sheet->SetCellValue('AW9', number_format($bor_limpapeh_l4_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'LIMPAPEH L4' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_limpapeh_l4 = $tot_tt->bed;
				}}

				if($tt_tiga_limpapeh_l4 == '0'){
					$bor_limpapeh_l4_tiga = 0;
				}else{
					$bor_kali_limpapeh_l4_tiga =  $tt_tiga_limpapeh_l4 * $periode;
					$bor_bagi_limpapeh_l4_tiga = $total_hari_rawat_tiga_limpapeh_l4 / $bor_kali_limpapeh_l4_tiga;
					$bor_limpapeh_l4_tiga = $bor_bagi_limpapeh_l4_tiga * 100;
				}
				$sheet->SetCellValue('AX9', number_format($bor_limpapeh_l4_tiga,2).'%');

				if( $total_bed_limpapeh_l4 == '0'){
					$bor_limpapeh_l4_all = 0;
				}else{
					$bor_kali_limpapeh_l4_all =  $total_bed_limpapeh_l4 * $periode;
					$bor_bagi_limpapeh_l4_all = $total_hari_rawat_limpapeh_l4 / $bor_kali_limpapeh_l4_all;
					$bor_limpapeh_l4_all = $bor_bagi_limpapeh_l4_all * 100;
				}
				$sheet->SetCellValue('AY9', number_format($bor_limpapeh_l4_all,2).'%');

				// total singgalang l1 & l2
				$sheet->SetCellValue('W10','SINGGALANG L1 & L2');
				$sheet->SetCellValue('X10', $pasien_awal_all_ruangan->singgalang_l1_l2);
				$sheet->SetCellValue('Y10', $total_pasien_masuk_singgalangl1l2);
				$sheet->SetCellValue('Z10', $total_pasien_masuk_pindah_singgalangl1l2);
				$sheet->SetCellValue('AA10', $total_pasien_dirawat_all_singgalangl1l2);
				$sheet->SetCellValue('AB10', $total_pasien_keluar_pindah_singgalangl1l2);
				$sheet->SetCellValue('AC10', $total_pasien_keluar_hidup_singgalangl1l2);
				$sheet->SetCellValue('AD10', $total_pasien_keluar_mati_singgalangl1l2);
				$sheet->SetCellValue('AE10', $total_pasien_keluar_all_singgalangl1l2);
				$sheet->SetCellValue('AF10', $total_pasien_keluar_hidup_mati_singgalangl1l2);
				$sheet->SetCellValue('AG10', $total_pasien_mati_krg48_singgalangl1l2);
				$sheet->SetCellValue('AH10', $total_pasien_mati_lbh48_singgalangl1l2);
				$sheet->SetCellValue('AI10', $total_lama_rawat_singgalangl1l2);
				
				$jml_pasien_akhir_singgalangl1l2 = $total_pasien_dirawat_all_singgalangl1l2 - $total_pasien_keluar_all_singgalangl1l2;
			
				$sheet->SetCellValue('AJ10', $jml_pasien_akhir_singgalangl1l2);
				$sheet->SetCellValue('AK10', $total_hari_rawat_singgalangl1l2);
				$sheet->SetCellValue('AL10', $total_hari_rawat_vip_singgalangl1l2);
				$sheet->SetCellValue('AM10', $total_hari_rawat_satu_singgalangl1l2);
				$sheet->SetCellValue('AN10', $total_hari_rawat_dua_singgalangl1l2);
				$sheet->SetCellValue('AO10', $total_hari_rawat_tiga_singgalangl1l2);
				$total_bed_singgalang_l1_l2 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP10', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ10', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR10', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS10',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2'){ 
						$total_bed_singgalang_l1_l2 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT10', $total_bed_singgalang_l1_l2);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_singgalangl1l2 = $tot_tt->bed;
				}}

				if($tt_vip_singgalangl1l2 == '0'){
					$bor_singgalangl1l2_vip = 0;
				}else{
					$bor_kali_singgalangl1l2_vip =  $tt_vip_singgalangl1l2 * $periode;
					$bor_bagi_singgalangl1l2_vip = $total_hari_rawat_vip_singgalangl1l2 / $bor_kali_singgalangl1l2_vip;
					$bor_singgalangl1l2_vip =  $bor_bagi_singgalangl1l2_vip * 100;
				}

				$sheet->SetCellValue('AU10',  number_format($bor_singgalangl1l2_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'I'){ 
						$tt_satu_singgalangl1l2 = $tot_tt->bed;
				}}

				if($tt_satu_singgalangl1l2 == '0'){
					$bor_singgalangl1l2_satu = 0;
				}else{
					$bor_kali_singgalangl1l2_satu =  $tt_satu_singgalangl1l2 * $periode;
					$bor_bagi_singgalangl1l2_satu = $total_hari_rawat_satu_singgalangl1l2 / $bor_kali_singgalangl1l2_satu;
					$bor_singgalangl1l2_satu =  $bor_bagi_singgalangl1l2_satu * 100;
				}
				$sheet->SetCellValue('AV10',  number_format($bor_singgalangl1l2_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'II'){ 
						$tt_dua_singgalangl1l2 = $tot_tt->bed;
				}}

				if($tt_dua_singgalangl1l2 == '0'){
					$bor_singgalangl1l2_dua = 0;
				}else{
					$bor_kali_singgalangl1l2_dua =  $tt_dua_singgalangl1l2 * $periode;
					$bor_bagi_singgalangl1l2_dua = $total_hari_rawat_dua_singgalangl1l2 / $bor_kali_singgalangl1l2_dua;
					$bor_singgalangl1l2_dua =  $bor_bagi_singgalangl1l2_dua * 100;                                           
				}
				$sheet->SetCellValue('AW10', number_format($bor_singgalangl1l2_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L1 & L2' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_singgalangl1l2 = $tot_tt->bed;
				}}

				if($tt_tiga_singgalangl1l2 == '0'){
					$bor_singgalangl1l2_tiga = 0;
				}else{
					$bor_kali_singgalangl1l2_tiga =  $tt_tiga_singgalangl1l2 * $periode;
					$bor_bagi_singgalangl1l2_tiga = $total_hari_rawat_tiga_singgalangl1l2 / $bor_kali_singgalangl1l2_tiga;
					$bor_singgalangl1l2_tiga = $bor_bagi_singgalangl1l2_tiga * 100;
				}
				$sheet->SetCellValue('AX10', number_format($bor_singgalangl1l2_tiga,2).'%');

				if( $total_bed_singgalang_l1_l2 == '0'){
					$bor_singgalangl1l2_all = 0;
				}else{
					$bor_kali_singgalangl1l2_all =  $total_bed_singgalang_l1_l2 * $periode;
					$bor_bagi_singgalangl1l2_all = $total_hari_rawat_singgalangl1l2 / $bor_kali_singgalangl1l2_all;
					$bor_singgalangl1l2_all = $bor_bagi_singgalangl1l2_all * 100;
				}
				$sheet->SetCellValue('AY10', number_format($bor_singgalangl1l2_all,2).'%');


				// total singgalang l3
				$sheet->SetCellValue('W11','SINGGALANG L3');
				$sheet->SetCellValue('X11', $pasien_awal_all_ruangan->singgalang_l3);
				$sheet->SetCellValue('Y11', $total_pasien_masuk_singgalangl3);
				$sheet->SetCellValue('Z11', $total_pasien_masuk_pindah_singgalangl3);
				$sheet->SetCellValue('AA11', $total_pasien_dirawat_all_singgalangl3);
				$sheet->SetCellValue('AB11', $total_pasien_keluar_pindah_singgalangl3);
				$sheet->SetCellValue('AC11', $total_pasien_keluar_hidup_singgalangl3);
				$sheet->SetCellValue('AD11', $total_pasien_keluar_mati_singgalangl3);
				$sheet->SetCellValue('AE11', $total_pasien_keluar_all_singgalangl3);
				$sheet->SetCellValue('AF11', $total_pasien_keluar_hidup_mati_singgalangl3);
				$sheet->SetCellValue('AG11', $total_pasien_mati_krg48_singgalangl3);
				$sheet->SetCellValue('AH11', $total_pasien_mati_lbh48_singgalangl3);
				$sheet->SetCellValue('AI11', $total_lama_rawat_singgalangl3);
				
				$jml_pasien_akhir_singgalangl3 = $total_pasien_dirawat_all_singgalangl3 - $total_pasien_keluar_all_singgalangl3;
			
				$sheet->SetCellValue('AJ11', $jml_pasien_akhir_singgalangl3);
				$sheet->SetCellValue('AK11', $total_hari_rawat_singgalangl3);
				$sheet->SetCellValue('AL11', $total_hari_rawat_vip_singgalangl3);
				$sheet->SetCellValue('AM11', $total_hari_rawat_satu_singgalangl3);
				$sheet->SetCellValue('AN11', $total_hari_rawat_dua_singgalangl3);
				$sheet->SetCellValue('AO11', $total_hari_rawat_tiga_singgalangl3);
				$total_bed_singgalang_l3 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP11', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ11', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR11', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS11',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'SINGGALANG L3'){ 
						$total_bed_singgalang_l3 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT11', $total_bed_singgalang_l3);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_singgalangl3 = $tot_tt->bed;
				}}

				if($tt_vip_singgalangl3 == '0'){
					$bor_singgalangl3_vip = 0;
				}else{
					$bor_kali_singgalangl3_vip =  $tt_vip_singgalangl3 * $periode;
					$bor_bagi_singgalangl3_vip = $total_hari_rawat_vip_singgalangl3 / $bor_kali_singgalangl3_vip;
					$bor_singgalangl3_vip =  $bor_bagi_singgalangl3_vip * 100;
				}
				$sheet->SetCellValue('AU11',  number_format($bor_singgalangl3_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'I'){ 
						$tt_satu_singgalangl3 = $tot_tt->bed;
				}}

				if($tt_satu_singgalangl3 == '0'){
					$bor_singgalangl3_satu = 0;
				}else{
					$bor_kali_singgalangl3_satu =  $tt_satu_singgalangl3 * $periode;
					$bor_bagi_singgalangl3_satu = $total_hari_rawat_satu_singgalangl3 / $bor_kali_singgalangl3_satu;
					$bor_singgalangl3_satu =  $bor_bagi_singgalangl3_satu * 100;
				}
				$sheet->SetCellValue('AV11',  number_format($bor_singgalangl3_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'II'){ 
						$tt_dua_singgalangl3 = $tot_tt->bed;
				}}

				if($tt_dua_singgalangl3 == '0'){
					$bor_singgalangl3_dua = 0;
				}else{
					$bor_kali_singgalangl3_dua =  $tt_dua_singgalangl3 * $periode;
					$bor_bagi_singgalangl3_dua = $total_hari_rawat_dua_singgalangl3 / $bor_kali_singgalangl3_dua;
					$bor_singgalangl3_dua =  $bor_bagi_singgalangl3_dua * 100;                                           
				}
				$sheet->SetCellValue('AW11', number_format($bor_singgalangl3_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'SINGGALANG L3' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_singgalangl3 = $tot_tt->bed;
				}}

				if($tt_tiga_singgalangl3 == '0'){
					$bor_singgalangl3_tiga = 0;
				}else{
					$bor_kali_singgalangl3_tiga =  $tt_tiga_singgalangl3 * $periode;
					$bor_bagi_singgalangl3_tiga = $total_hari_rawat_tiga_singgalangl3 / $bor_kali_singgalangl3_tiga;
					$bor_singgalangl3_tiga = $bor_bagi_singgalangl3_tiga * 100;
				}
				$sheet->SetCellValue('AX11', number_format($bor_singgalangl3_tiga,2).'%');

				if( $total_bed_singgalang_l3 == '0'){
					$bor_singgalangl3_all = 0;
				}else{
					$bor_kali_singgalangl3_all =  $total_bed_singgalang_l3 * $periode;
					$bor_bagi_singgalangl3_all = $total_hari_rawat_singgalangl3 / $bor_kali_singgalangl3_all;
					$bor_singgalangl3_all = $bor_bagi_singgalangl3_all * 100;
				}
				$sheet->SetCellValue('AY11', number_format($bor_singgalangl3_all,2).'%');


				// total merapi l1
				$sheet->SetCellValue('W12','MERAPI L1');
				$sheet->SetCellValue('X12', $pasien_awal_all_ruangan->merapi_l1);
				$sheet->SetCellValue('Y12', $total_pasien_masuk_merapil1);
				$sheet->SetCellValue('Z12', $total_pasien_masuk_pindah_merapil1);
				$sheet->SetCellValue('AA12', $total_pasien_dirawat_all_merapil1);
				$sheet->SetCellValue('AB12', $total_pasien_keluar_pindah_merapil1);
				$sheet->SetCellValue('AC12', $total_pasien_keluar_hidup_merapil1);
				$sheet->SetCellValue('AD12', $total_pasien_keluar_mati_merapil1);
				$sheet->SetCellValue('AE12', $total_pasien_keluar_all_merapil1);
				$sheet->SetCellValue('AF12', $total_pasien_keluar_hidup_mati_merapil1);
				$sheet->SetCellValue('AG12', $total_pasien_mati_krg48_merapil1);
				$sheet->SetCellValue('AH12', $total_pasien_mati_lbh48_merapil1);
				$sheet->SetCellValue('AI12', $total_lama_rawat_merapil1);
				
				$jml_pasien_akhir_merapi_l1 = $total_pasien_dirawat_all_merapil1 - $total_pasien_keluar_all_merapil1;
			
				$sheet->SetCellValue('AJ12', $jml_pasien_akhir_merapi_l1);
				$sheet->SetCellValue('AK12', $total_hari_rawat_merapil1);
				$sheet->SetCellValue('AL12', $total_hari_rawat_vip_merapil1);
				$sheet->SetCellValue('AM12', $total_hari_rawat_satu_merapil1);
				$sheet->SetCellValue('AN12', $total_hari_rawat_dua_merapil1);
				$sheet->SetCellValue('AO12', $total_hari_rawat_tiga_merapil1);
				$total_bed_merapi_l1 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP12', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ12', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR12', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS12',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'MERAPI L1'){ 
						$total_bed_merapi_l1 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT12', $total_bed_merapi_l1);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_merapil1 = $tot_tt->bed;
				}}

				if($tt_vip_merapil1 == '0'){
					$bor_merapil1_vip = 0;
				}else{
					$bor_kali_merapil1_vip =  $tt_vip_merapil1 * $periode;
					$bor_bagi_merapil1_vip = $total_hari_rawat_vip_merapil1 / $bor_kali_merapil1_vip;
					$bor_merapil1_vip =  $bor_bagi_merapil1_vip * 100;
				}
				$sheet->SetCellValue('AU12', number_format($bor_merapil1_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'I'){ 
						$tt_satu_merapil1 = $tot_tt->bed;
				}}

				if($tt_satu_merapil1 == '0'){
					$bor_merapil1_satu = 0;
				}else{
					$bor_kali_merapil1_satu =  $tt_satu_merapil1 * $periode;
					$bor_bagi_merapil1_satu = $total_hari_rawat_satu_merapil1 / $bor_kali_merapil1_satu;
					$bor_merapil1_satu =  $bor_bagi_merapil1_satu * 100;
				}
				$sheet->SetCellValue('AV12',  number_format($bor_merapil1_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'II'){ 
						$tt_dua_merapil1 = $tot_tt->bed;
				}}

				if($tt_dua_merapil1 == '0'){
					$bor_merapil1_dua = 0;
				}else{
					$bor_kali_merapil1_dua =  $tt_dua_merapil1 * $periode;
					$bor_bagi_merapil1_dua = $total_hari_rawat_dua_merapil1 / $bor_kali_merapil1_dua;
					$bor_merapil1_dua =  $bor_bagi_merapil1_dua * 100;                                           
				}
				$sheet->SetCellValue('AW12', number_format($bor_merapil1_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L1' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_merapil1 = $tot_tt->bed;
				}}

				if($tt_tiga_merapil1 == '0'){
					$bor_merapil1_tiga = 0;
				}else{
					$bor_kali_merapil1_tiga =  $tt_tiga_merapil1 * $periode;
					$bor_bagi_merapil1_tiga = $total_hari_rawat_tiga_merapil1 / $bor_kali_merapil1_tiga;
					$bor_merapil1_tiga = $bor_bagi_merapil1_tiga * 100;
				}
				$sheet->SetCellValue('AX12', number_format($bor_merapil1_tiga,2).'%');

				if(  $total_bed_merapi_l1 == '0'){
					$bor_merapil1_all = 0;
				}else{
					$bor_kali_merapil1_all =   $total_bed_merapi_l1 * $periode;
					$bor_bagi_merapil1_all = $total_hari_rawat_merapil1 / $bor_kali_merapil1_all;
					$bor_merapil1_all = $bor_bagi_merapil1_all * 100;
				}
				$sheet->SetCellValue('AY12', number_format($bor_merapil1_all,2).'%');

				// total merapi l2
				$sheet->SetCellValue('W13','MERAPI L2');
				$sheet->SetCellValue('X13', $pasien_awal_all_ruangan->merapi_l2);
				$sheet->SetCellValue('Y13', $total_pasien_masuk_merapil2);
				$sheet->SetCellValue('Z13', $total_pasien_masuk_pindah_merapil2);
				$sheet->SetCellValue('AA13', $total_pasien_dirawat_all_merapil2);
				$sheet->SetCellValue('AB13', $total_pasien_keluar_pindah_merapil2);
				$sheet->SetCellValue('AC13', $total_pasien_keluar_hidup_merapil2);
				$sheet->SetCellValue('AD13', $total_pasien_keluar_mati_merapil2);
				$sheet->SetCellValue('AE13', $total_pasien_keluar_all_merapil2);
				$sheet->SetCellValue('AF13', $total_pasien_keluar_hidup_mati_merapil2);
				$sheet->SetCellValue('AG13', $total_pasien_mati_krg48_merapil2);
				$sheet->SetCellValue('AH13', $total_pasien_mati_lbh48_merapil2);
				$sheet->SetCellValue('AI13', $total_lama_rawat_merapil2);
				
				$jml_pasien_akhir_merapi_l2 = $total_pasien_dirawat_all_merapil2 - $total_pasien_keluar_all_merapil2;
			
				$sheet->SetCellValue('AJ13', $jml_pasien_akhir_merapi_l2);
				$sheet->SetCellValue('AK13', $total_hari_rawat_merapil2);
				$sheet->SetCellValue('AL13', $total_hari_rawat_vip_merapil2);
				$sheet->SetCellValue('AM13', $total_hari_rawat_satu_merapil2);
				$sheet->SetCellValue('AN13', $total_hari_rawat_dua_merapil2);
				$sheet->SetCellValue('AO13', $total_hari_rawat_tiga_merapil2);
				$total_bed_merapi_l2 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP13', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ13', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR13', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS13',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'MERAPI L2'){ 
						$total_bed_merapi_l2 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT13', $total_bed_merapi_l2);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_merapil2 = $tot_tt->bed;
				}}

				if($tt_vip_merapil2 == '0'){
					$bor_merapil2_vip = 0;
				}else{
					$bor_kali_merapil2_vip =  $tt_vip_merapil2 * $periode;
					$bor_bagi_merapil2_vip = $total_hari_rawat_vip_merapil2 / $bor_kali_merapil2_vip;
					$bor_merapil2_vip =  $bor_bagi_merapil2_vip * 100;
				}
				$sheet->SetCellValue('AU13', number_format($bor_merapil2_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'I'){ 
						$tt_satu_merapil2 = $tot_tt->bed;
				}}

				if($tt_satu_merapil2 == '0'){
					$bor_merapil2_satu = 0;
				}else{
					$bor_kali_merapil2_satu =  $tt_satu_merapil2 * $periode;
					$bor_bagi_merapil2_satu = $total_hari_rawat_satu_merapil2 / $bor_kali_merapil2_satu;
					$bor_merapil2_satu =  $bor_bagi_merapil2_satu * 100;
				}
				$sheet->SetCellValue('AV13',  number_format($bor_merapil2_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'II'){ 
						$tt_dua_merapil2 = $tot_tt->bed;
				}}

				if($tt_dua_merapil2 == '0'){
					$bor_merapil2_dua = 0;
				}else{
					$bor_kali_merapil2_dua =  $tt_dua_merapil2 * $periode;
					$bor_bagi_merapil2_dua = $total_hari_rawat_dua_merapil2 / $bor_kali_merapil2_dua;
					$bor_merapil2_dua =  $bor_bagi_merapil2_dua * 100;                                           
				}
				$sheet->SetCellValue('AW13', number_format($bor_merapil2_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L2' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_merapil2 = $tot_tt->bed;
				}}

				if($tt_tiga_merapil2 == '0'){
					$bor_merapil2_tiga = 0;
				}else{
					$bor_kali_merapil2_tiga =  $tt_tiga_merapil2 * $periode;
					$bor_bagi_merapil2_tiga = $total_hari_rawat_tiga_merapil2 / $bor_kali_merapil2_tiga;
					$bor_merapil2_tiga = $bor_bagi_merapil2_tiga * 100;
				}
				$sheet->SetCellValue('AX13', number_format($bor_merapil2_tiga,2).'%');

				if(  $total_bed_merapi_l2 == '0'){
					$bor_merapil2_all = 0;
				}else{
					$bor_kali_merapil2_all =   $total_bed_merapi_l2 * $periode;
					$bor_bagi_merapil2_all = $total_hari_rawat_merapil2 / $bor_kali_merapil2_all;
					$bor_merapil2_all = $bor_bagi_merapil2_all * 100;
				}
				$sheet->SetCellValue('AY13', number_format($bor_merapil2_all,2).'%');

				// total merapi l3
				$sheet->SetCellValue('W14','MERAPI L3');
				$sheet->SetCellValue('X14', $pasien_awal_all_ruangan->merapi_l3);
				$sheet->SetCellValue('Y14', $total_pasien_masuk_merapil3);
				$sheet->SetCellValue('Z14', $total_pasien_masuk_pindah_merapil3);
				$sheet->SetCellValue('AA14', $total_pasien_dirawat_all_merapil3);
				$sheet->SetCellValue('AB14', $total_pasien_keluar_pindah_merapil3);
				$sheet->SetCellValue('AC14', $total_pasien_keluar_hidup_merapil3);
				$sheet->SetCellValue('AD14', $total_pasien_keluar_mati_merapil3);
				$sheet->SetCellValue('AE14', $total_pasien_keluar_all_merapil3);
				$sheet->SetCellValue('AF14', $total_pasien_keluar_hidup_mati_merapil3);
				$sheet->SetCellValue('AG14', $total_pasien_mati_krg48_merapil3);
				$sheet->SetCellValue('AH14', $total_pasien_mati_lbh48_merapil3);
				$sheet->SetCellValue('AI14', $total_lama_rawat_merapil3);
				
				$jml_pasien_akhir_merapi_l3 = $total_pasien_dirawat_all_merapil3 - $total_pasien_keluar_all_merapil3;
			
				$sheet->SetCellValue('AJ14', $jml_pasien_akhir_merapi_l3);
				$sheet->SetCellValue('AK14', $total_hari_rawat_merapil3);
				$sheet->SetCellValue('AL14', $total_hari_rawat_vip_merapil3);
				$sheet->SetCellValue('AM14', $total_hari_rawat_satu_merapil3);
				$sheet->SetCellValue('AN14', $total_hari_rawat_dua_merapil3);
				$sheet->SetCellValue('AO14', $total_hari_rawat_tiga_merapil3);
				$total_bed_merapi_l3 = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP14', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ14', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR14', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS14',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'MERAPI L3'){ 
						$total_bed_merapi_l3 += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT14', $total_bed_merapi_l3);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_merapil3 = $tot_tt->bed;
				}}

				if($tt_vip_merapil3 == '0'){
					$bor_merapil3_vip = 0;
				}else{
					$bor_kali_merapil3_vip =  $tt_vip_merapil3 * $periode;
					$bor_bagi_merapil3_vip = $total_hari_rawat_vip_merapil3 / $bor_kali_merapil3_vip;
					$bor_merapil3_vip =  $bor_bagi_merapil3_vip * 100;
				}
				$sheet->SetCellValue('AU14', number_format($bor_merapil3_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'I'){ 
						$tt_satu_merapil3 = $tot_tt->bed;
				}}

				if($tt_satu_merapil3 == '0'){
					$bor_merapil3_satu = 0;
				}else{
					$bor_kali_merapil3_satu =  $tt_satu_merapil3 * $periode;
					$bor_bagi_merapil3_satu = $total_hari_rawat_satu_merapil3 / $bor_kali_merapil3_satu;
					$bor_merapil3_satu =  $bor_bagi_merapil3_satu * 100;
				}
				$sheet->SetCellValue('AV14',  number_format($bor_merapil3_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'II'){ 
						$tt_dua_merapil3 = $tot_tt->bed;
				}}

				if($tt_dua_merapil3 == '0'){
					$bor_merapil3_dua = 0;
				}else{
					$bor_kali_merapil3_dua =  $tt_dua_merapil3 * $periode;
					$bor_bagi_merapil3_dua = $total_hari_rawat_dua_merapil3 / $bor_kali_merapil3_dua;
					$bor_merapil3_dua =  $bor_bagi_merapil3_dua * 100;                                           
				}
				$sheet->SetCellValue('AW14', number_format($bor_merapil3_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'MERAPI L3' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_merapil3 = $tot_tt->bed;
				}}

				if($tt_tiga_merapil3 == '0'){
					$bor_merapil3_tiga = 0;
				}else{
					$bor_kali_merapil3_tiga =  $tt_tiga_merapil3 * $periode;
					$bor_bagi_merapil3_tiga = $total_hari_rawat_tiga_merapil3 / $bor_kali_merapil3_tiga;
					$bor_merapil3_tiga = $bor_bagi_merapil3_tiga * 100;
				}
				$sheet->SetCellValue('AX14',  number_format($bor_merapil3_tiga,2).'%');

				if(  $total_bed_merapi_l3 == '0'){
					$bor_merapil3_all = 0;
				}else{
					$bor_kali_merapil3_all =   $total_bed_merapi_l3 * $periode;
					$bor_bagi_merapil3_all = $total_hari_rawat_merapil3 / $bor_kali_merapil3_all;
					$bor_merapil3_all = $bor_bagi_merapil3_all * 100;
				}
			
				$sheet->SetCellValue('AY14', number_format($bor_merapil3_all,2).'%');

				// total anak
				$sheet->SetCellValue('W15','ANAK');
				$sheet->SetCellValue('X15', $pasien_awal_all_ruangan->anak);
				$sheet->SetCellValue('Y15', $total_pasien_masuk_anak);
				$sheet->SetCellValue('Z15', $total_pasien_masuk_pindah_anak);
				$sheet->SetCellValue('AA15', $total_pasien_dirawat_all_anak);
				$sheet->SetCellValue('AB15', $total_pasien_keluar_pindah_anak);
				$sheet->SetCellValue('AC15', $total_pasien_keluar_hidup_anak);
				$sheet->SetCellValue('AD15', $total_pasien_keluar_mati_anak);
				$sheet->SetCellValue('AE15', $total_pasien_keluar_all_anak);
				$sheet->SetCellValue('AF15', $total_pasien_keluar_hidup_mati_anak);
				$sheet->SetCellValue('AG15', $total_pasien_mati_krg48_anak);
				$sheet->SetCellValue('AH15', $total_pasien_mati_lbh48_anak);
				$sheet->SetCellValue('AI15', $total_lama_rawat_anak);
				
				$jml_pasien_akhir_anak = $total_pasien_dirawat_all_anak - $total_pasien_keluar_all_anak;
			
				$sheet->SetCellValue('AJ15', $jml_pasien_akhir_anak);
				$sheet->SetCellValue('AK15', $total_hari_rawat_anak);
				$sheet->SetCellValue('AL15', $total_hari_rawat_vip_anak);
				$sheet->SetCellValue('AM15', $total_hari_rawat_satu_anak);
				$sheet->SetCellValue('AN15', $total_hari_rawat_dua_anak);
				$sheet->SetCellValue('AO15', $total_hari_rawat_tiga_anak);
				$total_bed_anak = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP15', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ15', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR15', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS15',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'ANAK'){ 
						$total_bed_anak += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT15', $total_bed_anak);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_anak = $tot_tt->bed;
				}}

				if($tt_vip_anak == '0'){
					$bor_anak_vip = 0;
				}else{
					$bor_kali_anak_vip =  $tt_vip_anak * $periode;
					$bor_bagi_anak_vip = $total_hari_rawat_vip_anak / $bor_kali_anak_vip;
					$bor_anak_vip =  $bor_bagi_anak_vip * 100;
				}
				$sheet->SetCellValue('AU15', number_format($bor_anak_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'I'){ 
						$tt_satu_anak = $tot_tt->bed;
				}}

				if($tt_satu_anak == '0'){
					$bor_anak_satu = 0;
				}else{
					$bor_kali_anak_satu =  $tt_satu_anak * $periode;
					$bor_bagi_anak_satu = $total_hari_rawat_satu_anak / $bor_kali_anak_satu;
					$bor_anak_satu =  $bor_bagi_anak_satu * 100;
				}
				$sheet->SetCellValue('AV15',  number_format($bor_anak_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'II'){ 
						$tt_dua_anak = $tot_tt->bed;
				}}

				if($tt_dua_anak == '0'){
					$bor_anak_dua = 0;
				}else{
					$bor_kali_anak_dua =  $tt_dua_anak * $periode;
					$bor_bagi_anak_dua = $total_hari_rawat_dua_anak / $bor_kali_anak_dua;
					$bor_anak_dua =  $bor_bagi_anak_dua * 100;                                           
				}
				$sheet->SetCellValue('AW15', number_format($bor_anak_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ANAK' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_anak = $tot_tt->bed;
				}}

				if($tt_tiga_anak == '0'){
					$bor_anak_tiga = 0;
				}else{
					$bor_kali_anak_tiga =  $tt_tiga_anak * $periode;
					$bor_bagi_anak_tiga = $total_hari_rawat_tiga_anak / $bor_kali_anak_tiga;
					$bor_anak_tiga = $bor_bagi_anak_tiga * 100;
				}
				$sheet->SetCellValue('AX15',  number_format($bor_anak_tiga,2).'%');

				if(  $total_bed_anak == '0'){
					$bor_anak_all = 0;
				}else{
					$bor_kali_anak_all =   $total_bed_anak * $periode;
					$bor_bagi_anak_all = $total_hari_rawat_anak / $bor_kali_anak_all;
					$bor_anak_all = $bor_bagi_anak_all * 100;
				}
			
				$sheet->SetCellValue('AY15', number_format($bor_anak_all,2).'%');

				// total bedah
				$sheet->SetCellValue('W16','BEDAH');
				$sheet->SetCellValue('X16', $pasien_awal_all_ruangan->bedah);
				$sheet->SetCellValue('Y16', $total_pasien_masuk_bedah);
				$sheet->SetCellValue('Z16', $total_pasien_masuk_pindah_bedah);
				$sheet->SetCellValue('AA16', $total_pasien_dirawat_all_bedah);
				$sheet->SetCellValue('AB16', $total_pasien_keluar_pindah_bedah);
				$sheet->SetCellValue('AC16', $total_pasien_keluar_hidup_bedah);
				$sheet->SetCellValue('AD16', $total_pasien_keluar_mati_bedah);
				$sheet->SetCellValue('AE16', $total_pasien_keluar_all_bedah);
				$sheet->SetCellValue('AF16', $total_pasien_keluar_hidup_mati_bedah);
				$sheet->SetCellValue('AG16', $total_pasien_mati_krg48_bedah);
				$sheet->SetCellValue('AH16', $total_pasien_mati_lbh48_bedah);
				$sheet->SetCellValue('AI16', $total_lama_rawat_bedah);
				
				$jml_pasien_akhir_bedah = $total_pasien_dirawat_all_bedah - $total_pasien_keluar_all_bedah;
			
				$sheet->SetCellValue('AJ16', $jml_pasien_akhir_bedah);
				$sheet->SetCellValue('AK16', $total_hari_rawat_bedah);
				$sheet->SetCellValue('AL16', $total_hari_rawat_vip_bedah);
				$sheet->SetCellValue('AM16', $total_hari_rawat_satu_bedah);
				$sheet->SetCellValue('AN16', $total_hari_rawat_dua_bedah);
				$sheet->SetCellValue('AO16', $total_hari_rawat_tiga_bedah);
				$total_bed_bedah = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP16', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ16', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR16', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS16',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'BEDAH'){ 
						$total_bed_bedah += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT16', $total_bed_bedah);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_bedah = $tot_tt->bed;
				}}

				if($tt_vip_bedah == '0'){
					$bor_bedah_vip = 0;
				}else{
					$bor_kali_bedah_vip =  $tt_vip_bedah * $periode;
					$bor_bagi_bedah_vip = $total_hari_rawat_vip_bedah / $bor_kali_bedah_vip;
					$bor_bedah_vip =  $bor_bagi_bedah_vip * 100;
				}
				$sheet->SetCellValue('AU16', number_format($bor_bedah_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'I'){ 
						$tt_satu_bedah = $tot_tt->bed;
				}}

				if($tt_satu_bedah == '0'){
					$bor_bedah_satu = 0;
				}else{
					$bor_kali_bedah_satu =  $tt_satu_bedah * $periode;
					$bor_bagi_bedah_satu = $total_hari_rawat_satu_bedah / $bor_kali_bedah_satu;
					$bor_bedah_satu =  $bor_bagi_bedah_satu * 100;
				}
				$sheet->SetCellValue('AV16',  number_format($bor_bedah_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'II'){ 
						$tt_dua_bedah = $tot_tt->bed;
				}}

				if($tt_dua_bedah == '0'){
					$bor_bedah_dua = 0;
				}else{
					$bor_kali_bedah_dua =  $tt_dua_bedah * $periode;
					$bor_bagi_bedah_dua = $total_hari_rawat_dua_bedah / $bor_kali_bedah_dua;
					$bor_bedah_dua =  $bor_bagi_bedah_dua * 100;                                           
				}
				$sheet->SetCellValue('AW16', number_format($bor_bedah_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'BEDAH' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_bedah = $tot_tt->bed;
				}}

				if($tt_tiga_bedah == '0'){
					$bor_bedah_tiga = 0;
				}else{
					$bor_kali_bedah_tiga =  $tt_tiga_bedah * $periode;
					$bor_bagi_bedah_tiga = $total_hari_rawat_tiga_bedah / $bor_kali_bedah_tiga;
					$bor_bedah_tiga = $bor_bagi_bedah_tiga * 100;
				}
				$sheet->SetCellValue('AX16',  number_format($bor_bedah_tiga,2).'%');

				if(  $total_bed_bedah == '0'){
					$bor_bedah_all = 0;
				}else{
					$bor_kali_bedah_all =   $total_bed_bedah * $periode;
					$bor_bagi_bedah_all = $total_hari_rawat_bedah / $bor_kali_bedah_all;
					$bor_bedah_all = $bor_bagi_bedah_all * 100;
				}
			
				$sheet->SetCellValue('AY16', number_format($bor_bedah_all,2).'%');

				// total bidan
				$sheet->SetCellValue('W17','KEBIDANAN');
				$sheet->SetCellValue('X17', $pasien_awal_all_ruangan->kebidanan);
				$sheet->SetCellValue('Y17', $total_pasien_masuk_bidan);
				$sheet->SetCellValue('Z17', $total_pasien_masuk_pindah_bidan);
				$sheet->SetCellValue('AA17', $total_pasien_dirawat_all_bidan);
				$sheet->SetCellValue('AB17', $total_pasien_keluar_pindah_bidan);
				$sheet->SetCellValue('AC17', $total_pasien_keluar_hidup_bidan);
				$sheet->SetCellValue('AD17', $total_pasien_keluar_mati_bidan);
				$sheet->SetCellValue('AE17', $total_pasien_keluar_all_bidan);
				$sheet->SetCellValue('AF17', $total_pasien_keluar_hidup_mati_bidan);
				$sheet->SetCellValue('AG17', $total_pasien_mati_krg48_bidan);
				$sheet->SetCellValue('AH17', $total_pasien_mati_lbh48_bidan);
				$sheet->SetCellValue('AI17', $total_lama_rawat_bidan);
				
				$jml_pasien_akhir_bidan = $total_pasien_dirawat_all_bidan - $total_pasien_keluar_all_bidan;
			
				$sheet->SetCellValue('AJ17', $jml_pasien_akhir_bidan);
				$sheet->SetCellValue('AK17', $total_hari_rawat_bidan);
				$sheet->SetCellValue('AL17', $total_hari_rawat_vip_bidan);
				$sheet->SetCellValue('AM17', $total_hari_rawat_satu_bidan);
				$sheet->SetCellValue('AN17', $total_hari_rawat_dua_bidan);
				$sheet->SetCellValue('AO17', $total_hari_rawat_tiga_bidan);
				$total_bed_bidan = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP17', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ17', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR17', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS17',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'KEBIDANAN'){ 
						$total_bed_bidan += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT17', $total_bed_bidan);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_bidan = $tot_tt->bed;
				}}

				if($tt_vip_bidan == '0'){
					$bor_bidan_vip = 0;
				}else{
					$bor_kali_bidan_vip =  $tt_vip_bidan * $periode;
					$bor_bagi_bidan_vip = $total_hari_rawat_vip_bidan / $bor_kali_bidan_vip;
					$bor_bidan_vip =  $bor_bagi_bidan_vip * 100;
				}
				$sheet->SetCellValue('AU17', number_format($bor_bidan_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'I'){ 
						$tt_satu_bidan = $tot_tt->bed;
				}}

				if($tt_satu_bidan == '0'){
					$bor_bidan_satu = 0;
				}else{
					$bor_kali_bidan_satu =  $tt_satu_bidan * $periode;
					$bor_bagi_bidan_satu = $total_hari_rawat_satu_bidan / $bor_kali_bidan_satu;
					$bor_bidan_satu =  $bor_bagi_bidan_satu * 100;
				}
				$sheet->SetCellValue('AV17',  number_format($bor_bidan_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'II'){ 
						$tt_dua_bidan = $tot_tt->bed;
				}}

				if($tt_dua_bidan == '0'){
					$bor_bidan_dua = 0;
				}else{
					$bor_kali_bidan_dua =  $tt_dua_bidan * $periode;
					$bor_bagi_bidan_dua = $total_hari_rawat_dua_bidan / $bor_kali_bidan_dua;
					$bor_bidan_dua =  $bor_bagi_bidan_dua * 100;                                           
				}
				$sheet->SetCellValue('AW17', number_format($bor_bidan_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'KEBIDANAN' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_bidan = $tot_tt->bed;
				}}

				if($tt_tiga_bidan == '0'){
					$bor_bidan_tiga = 0;
				}else{
					$bor_kali_bidan_tiga =  $tt_tiga_bidan * $periode;
					$bor_bagi_bidan_tiga = $total_hari_rawat_tiga_bidan / $bor_kali_bidan_tiga;
					$bor_bidan_tiga = $bor_bagi_bidan_tiga * 100;
				}
				$sheet->SetCellValue('AX17', number_format($bor_bidan_tiga,2).'%');

				if(  $total_bed_bidan == '0'){
					$bor_bidan_all = 0;
				}else{
					$bor_kali_bidan_all =   $total_bed_bidan * $periode;
					$bor_bagi_bidan_all = $total_hari_rawat_bidan / $bor_kali_bidan_all;
					$bor_bidan_all = $bor_bagi_bidan_all * 100;
				}
			
				$sheet->SetCellValue('AY17', number_format($bor_bidan_all,2).'%');

				// total icu
				$sheet->SetCellValue('W18','ICU');
				$sheet->SetCellValue('X18', $pasien_awal_all_ruangan->icu);
				$sheet->SetCellValue('Y18', $total_pasien_masuk_icu);
				$sheet->SetCellValue('Z18', $total_pasien_masuk_pindah_icu);
				$sheet->SetCellValue('AA18', $total_pasien_dirawat_all_icu);
				$sheet->SetCellValue('AB18', $total_pasien_keluar_pindah_icu);
				$sheet->SetCellValue('AC18', $total_pasien_keluar_hidup_icu);
				$sheet->SetCellValue('AD18', $total_pasien_keluar_mati_icu);
				$sheet->SetCellValue('AE18', $total_pasien_keluar_all_icu);
				$sheet->SetCellValue('AF18', $total_pasien_keluar_hidup_mati_icu);
				$sheet->SetCellValue('AG18', $total_pasien_mati_krg48_icu);
				$sheet->SetCellValue('AH18', $total_pasien_mati_lbh48_icu);
				$sheet->SetCellValue('AI18', $total_lama_rawat_icu);
				
				$jml_pasien_akhir_icu = $total_pasien_dirawat_all_icu - $total_pasien_keluar_all_icu;
			
				$sheet->SetCellValue('AJ18', $jml_pasien_akhir_icu);
				$sheet->SetCellValue('AK18', $total_hari_rawat_icu);
				$sheet->SetCellValue('AL18', $total_hari_rawat_vip_icu);
				$sheet->SetCellValue('AM18', $total_hari_rawat_satu_icu);
				$sheet->SetCellValue('AN18', $total_hari_rawat_dua_icu);
				$sheet->SetCellValue('AO18', $total_hari_rawat_tiga_icu);
				$total_bed_icu = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP18', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ18', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR18', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS18',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'ICU'){ 
						$total_bed_icu += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT18', $total_bed_icu);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_icu = $tot_tt->bed;
				}}

				if($tt_vip_icu == '0'){
					$bor_icu_vip = 0;
				}else{
					$bor_kali_icu_vip =  $tt_vip_icu * $periode;
					$bor_bagi_icu_vip = $total_hari_rawat_vip_icu / $bor_kali_icu_vip;
					$bor_icu_vip =  $bor_bagi_icu_vip * 100;
				}
				$sheet->SetCellValue('AU18', number_format($bor_icu_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'I'){ 
						$tt_satu_icu = $tot_tt->bed;
				}}

				if($tt_satu_icu == '0'){
					$bor_icu_satu = 0;
				}else{
					$bor_kali_icu_satu =  $tt_satu_icu * $periode;
					$bor_bagi_icu_satu = $total_hari_rawat_satu_icu / $bor_kali_icu_satu;
					$bor_icu_satu =  $bor_bagi_icu_satu * 100;
				}
				$sheet->SetCellValue('AV18',   number_format($bor_icu_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'II'){ 
						$tt_dua_icu = $tot_tt->bed;
				}}

				if($tt_dua_icu == '0'){
					$bor_icu_dua = 0;
				}else{
					$bor_kali_icu_dua =  $tt_dua_icu * $periode;
					$bor_bagi_icu_dua = $total_hari_rawat_dua_icu / $bor_kali_icu_dua;
					$bor_icu_dua =  $bor_bagi_icu_dua * 100;                                           
				}
				$sheet->SetCellValue('AW18', number_format($bor_icu_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'ICU' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_icu = $tot_tt->bed;
				}}

				if($tt_tiga_icu == '0'){
					$bor_icu_tiga = 0;
				}else{
					$bor_kali_icu_tiga =  $tt_tiga_icu * $periode;
					$bor_bagi_icu_tiga = $total_hari_rawat_tiga_icu / $bor_kali_icu_tiga;
					$bor_icu_tiga = $bor_bagi_icu_tiga * 100;
				}
				$sheet->SetCellValue('AX18', number_format($bor_icu_tiga,2).'%');

				if(  $total_bed_icu == '0'){
					$bor_icu_all = 0;
				}else{
					$bor_kali_icu_all =   $total_bed_icu * $periode;
					$bor_bagi_icu_all = $total_hari_rawat_icu / $bor_kali_icu_all;
					$bor_icu_all = $bor_bagi_icu_all * 100;
				}
			
				$sheet->SetCellValue('AY18', number_format($bor_icu_all,2).'%');

				// total nicu
				$sheet->SetCellValue('W19','NICU');
				$sheet->SetCellValue('X19', $pasien_awal_all_ruangan->nicu);
				$sheet->SetCellValue('Y19', $total_pasien_masuk_nicu);
				$sheet->SetCellValue('Z19', $total_pasien_masuk_pindah_nicu);
				$sheet->SetCellValue('AA19', $total_pasien_dirawat_all_nicu);
				$sheet->SetCellValue('AB19', $total_pasien_keluar_pindah_nicu);
				$sheet->SetCellValue('AC19', $total_pasien_keluar_hidup_nicu);
				$sheet->SetCellValue('AD19', $total_pasien_keluar_mati_nicu);
				$sheet->SetCellValue('AE19', $total_pasien_keluar_all_nicu);
				$sheet->SetCellValue('AF19', $total_pasien_keluar_hidup_mati_nicu);
				$sheet->SetCellValue('AG19', $total_pasien_mati_krg48_nicu);
				$sheet->SetCellValue('AH19', $total_pasien_mati_lbh48_nicu);
				$sheet->SetCellValue('AI19', $total_lama_rawat_nicu);
				
				$jml_pasien_akhir_nicu = $total_pasien_dirawat_all_nicu - $total_pasien_keluar_all_nicu;
			
				$sheet->SetCellValue('AJ19', $jml_pasien_akhir_nicu);
				$sheet->SetCellValue('AK19', $total_hari_rawat_nicu);
				$sheet->SetCellValue('AL19', $total_hari_rawat_vip_nicu);
				$sheet->SetCellValue('AM19', $total_hari_rawat_satu_nicu);
				$sheet->SetCellValue('AN19', $total_hari_rawat_dua_nicu);
				$sheet->SetCellValue('AO19', $total_hari_rawat_tiga_nicu);
				$total_bed_nicu = 0;
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'VIP'){ 
						$sheet->SetCellValue('AP19', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'I'){ 
						$sheet->SetCellValue('AQ19', $tot_tt->bed );
					} 
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'II'){ 
						$sheet->SetCellValue('AR19', $tot_tt->bed);
					} 
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'III'){ 
						$sheet->SetCellValue('AS19',$tot_tt->bed);
					}
					if( $tot_tt->ruangan == 'NICU'){ 
						$total_bed_nicu += $tot_tt->bed;
					}
						$sheet->SetCellValue('AT19', $total_bed_nicu);
				
				}

				$periode = date('j');
				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'VIP'){ 
						$tt_vip_nicu = $tot_tt->bed;
				}}

				if($tt_vip_nicu == '0'){
					$bor_nicu_vip = 0;
				}else{
					$bor_kali_nicu_vip =  $tt_vip_nicu * $periode;
					$bor_bagi_nicu_vip = $total_hari_rawat_vip_nicu / $bor_kali_nicu_vip;
					$bor_nicu_vip =  $bor_bagi_nicu_vip * 100;
				}
				$sheet->SetCellValue('AU19',number_format($bor_nicu_vip,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'I'){ 
						$tt_satu_nicu = $tot_tt->bed;
				}}

				if($tt_satu_nicu == '0'){
					$bor_nicu_satu = 0;
				}else{
					$bor_kali_nicu_satu =  $tt_satu_nicu * $periode;
					$bor_bagi_nicu_satu = $total_hari_rawat_satu_nicu / $bor_kali_nicu_satu;
					$bor_nicu_satu =  $bor_bagi_nicu_satu * 100;
				}
				$sheet->SetCellValue('AV19', number_format($bor_nicu_satu,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'II'){ 
						$tt_dua_nicu = $tot_tt->bed;
				}}

				if($tt_dua_nicu == '0'){
					$bor_nicu_dua = 0;
				}else{
					$bor_kali_nicu_dua =  $tt_dua_nicu * $periode;
					$bor_bagi_nicu_dua = $total_hari_rawat_dua_nicu / $bor_kali_nicu_dua;
					$bor_nicu_dua =  $bor_bagi_nicu_dua * 100;                                           
				}
				$sheet->SetCellValue('AW19', number_format($bor_nicu_dua,2).'%');

				foreach ($get_tt_ruangan as $tot_tt){
					if( $tot_tt->ruangan == 'NICU' && $tot_tt->kelas == 'III'){ 
						$tt_tiga_nicu = $tot_tt->bed;
				}}

				if($tt_tiga_nicu == '0'){
					$bor_nicu_tiga = 0;
				}else{
					$bor_kali_nicu_tiga =  $tt_tiga_nicu * $periode;
					$bor_bagi_nicu_tiga = $total_hari_rawat_tiga_nicu / $bor_kali_nicu_tiga;
					$bor_nicu_tiga = $bor_bagi_nicu_tiga * 100;
				}
				$sheet->SetCellValue('AX19', number_format($bor_nicu_tiga,2).'%');

				if(  $total_bed_nicu == '0'){
					$bor_nicu_all = 0;
				}else{
					$bor_kali_nicu_all =   $total_bed_nicu * $periode;
					$bor_bagi_nicu_all = $total_hari_rawat_nicu / $bor_kali_nicu_all;
					$bor_nicu_all = $bor_bagi_nicu_all * 100;
				}
			
				$sheet->SetCellValue('AY19', number_format($bor_nicu_all,2).'%');

				// total all
				$sheet->SetCellValue('W20','JUMLAH');
				$jmlh_pasien_awal = $total_pasien_awal +  $pasien_awal_all_ruangan->limpapeh_l3 + $pasien_awal_all_ruangan->limpapeh_l4 + $pasien_awal_all_ruangan->singgalang_l1_l2 + $pasien_awal_all_ruangan->singgalang_l3
				+ $pasien_awal_all_ruangan->merapi_l1 + $pasien_awal_all_ruangan->merapi_l2 + $pasien_awal_all_ruangan->merapi_l3 + $pasien_awal_all_ruangan->anak + $pasien_awal_all_ruangan->bedah
				+ $pasien_awal_all_ruangan->kebidanan + $pasien_awal_all_ruangan->icu + $pasien_awal_all_ruangan->nicu;
				$sheet->SetCellValue('X20', $jmlh_pasien_awal);

				$jmlh_pasien_masuk = $total_pasien_masuk + $total_pasien_masuk_limpapeh_l3 + $total_pasien_masuk_limpapeh_l4 + $total_pasien_masuk_singgalangl1l2 + $total_pasien_masuk_singgalangl3
				+ $total_pasien_masuk_merapil1 + $total_pasien_masuk_merapil2 +  $total_pasien_masuk_merapil3 + $total_pasien_masuk_anak + $total_pasien_masuk_bedah
				+ $total_pasien_masuk_bidan + $total_pasien_masuk_icu + $total_pasien_masuk_nicu;
				$sheet->SetCellValue('Y20', $jmlh_pasien_masuk);

				$jmlh_pasien_masuk_pindah = $total_pasien_masuk_pindah + $total_pasien_masuk_pindah_limpapeh_l3 + $total_pasien_masuk_pindah_limpapeh_l4 +  $total_pasien_masuk_pindah_singgalangl1l2 + $total_pasien_masuk_pindah_singgalangl3 
				+ $total_pasien_masuk_pindah_merapil1 + $total_pasien_masuk_pindah_merapil2 + $total_pasien_masuk_pindah_merapil3 + $total_pasien_masuk_pindah_anak + $total_pasien_masuk_pindah_bedah + $total_pasien_masuk_pindah_bidan
				+ $total_pasien_masuk_pindah_icu + $total_pasien_masuk_pindah_nicu;
				$sheet->SetCellValue('Z20', $jmlh_pasien_masuk_pindah);

				$jmlh_pasien_dirawat = $total_pasien_dirawat_all + $total_pasien_dirawat_all_limpapeh_l3 + $total_pasien_dirawat_all_limpapeh_l4 +  $total_pasien_dirawat_all_singgalangl1l2 + $total_pasien_dirawat_all_singgalangl3
				+ $total_pasien_dirawat_all_merapil1 + $total_pasien_dirawat_all_merapil2 + $total_pasien_dirawat_all_merapil3 + $total_pasien_dirawat_all_anak + $total_pasien_dirawat_all_bedah + $total_pasien_dirawat_all_bidan
				+ $total_pasien_dirawat_all_icu + $total_pasien_dirawat_all_nicu;
				$sheet->SetCellValue('AA20', $jmlh_pasien_dirawat);

				$jmlh_pasien_keluar_pindah = $total_pasien_keluar_pindah + $total_pasien_keluar_pindah_limpapeh_l3 + $total_pasien_keluar_pindah_limpapeh_l4 +  $total_pasien_keluar_pindah_singgalangl1l2 + $total_pasien_keluar_pindah_singgalangl3
				+ $total_pasien_keluar_pindah_merapil1 + $total_pasien_keluar_pindah_merapil2 + $total_pasien_keluar_pindah_merapil3 + $total_pasien_keluar_pindah_anak + $total_pasien_keluar_pindah_bedah + $total_pasien_keluar_pindah_bidan
				+ $total_pasien_keluar_pindah_icu + $total_pasien_keluar_pindah_nicu;
				$sheet->SetCellValue('AB20', $jmlh_pasien_keluar_pindah);

				$jmlh_pasien_keluar_hidup = $total_pasien_keluar_hidup + $total_pasien_keluar_hidup_limpapeh_l3 + $total_pasien_keluar_hidup_limpapeh_l4 +  $total_pasien_keluar_hidup_singgalangl1l2 +  $total_pasien_keluar_hidup_singgalangl3 
				+ $total_pasien_keluar_hidup_merapil1 + $total_pasien_keluar_hidup_merapil2 + $total_pasien_keluar_hidup_merapil3 + $total_pasien_keluar_hidup_anak + $total_pasien_keluar_hidup_bedah + $total_pasien_keluar_hidup_bidan
				+ $total_pasien_keluar_hidup_icu + $total_pasien_keluar_hidup_nicu;
				$sheet->SetCellValue('AC20', $jmlh_pasien_keluar_hidup);

				$jmlh_pasien_keluar_mati = $total_pasien_keluar_mati + $total_pasien_keluar_mati_limpapeh_l3 + $total_pasien_keluar_mati_limpapeh_l4 + $total_pasien_keluar_mati_singgalangl1l2 + $total_pasien_keluar_mati_singgalangl3
				+ $total_pasien_keluar_mati_merapil1 + $total_pasien_keluar_mati_merapil2 + $total_pasien_keluar_mati_merapil3 + $total_pasien_keluar_mati_anak + $total_pasien_keluar_mati_bedah + $total_pasien_keluar_mati_bidan
				+ $total_pasien_keluar_mati_icu + $total_pasien_keluar_mati_nicu;
				$sheet->SetCellValue('AD20', $jmlh_pasien_keluar_mati);

				$jmlh_pasien_keluar_all = $total_pasien_keluar_all + $total_pasien_keluar_all_limpapeh_l3 + $total_pasien_keluar_all_limpapeh_l4 +  $total_pasien_keluar_all_singgalangl1l2 + $total_pasien_keluar_all_singgalangl3
				+ $total_pasien_keluar_all_merapil1 + $total_pasien_keluar_all_merapil2 + $total_pasien_keluar_all_merapil3 + $total_pasien_keluar_all_anak + $total_pasien_keluar_all_bedah + $total_pasien_keluar_all_bidan
				+ $total_pasien_keluar_all_icu + $total_pasien_keluar_all_nicu;
				$sheet->SetCellValue('AE20', $jmlh_pasien_keluar_all);

				$jmlh_pasien_keluar_hidup_mati = $total_pasien_keluar_hidup_mati + $total_pasien_keluar_hidup_mati_limpapeh_l3 +  $total_pasien_keluar_hidup_mati_limpapeh_l4 + $total_pasien_keluar_hidup_mati_singgalangl1l2 + $total_pasien_keluar_hidup_mati_singgalangl3
				+ $total_pasien_keluar_hidup_mati_merapil1 + $total_pasien_keluar_hidup_mati_merapil2 + $total_pasien_keluar_hidup_mati_merapil3 + $total_pasien_keluar_hidup_mati_anak + $total_pasien_keluar_hidup_mati_bedah + $total_pasien_keluar_hidup_mati_bidan
				+ $total_pasien_keluar_hidup_mati_icu + $total_pasien_keluar_hidup_mati_nicu;
				$sheet->SetCellValue('AF20', $jmlh_pasien_keluar_hidup_mati);

				$jmlh_pasien_mati_krg48 = $total_pasien_mati_krg48 + $total_pasien_mati_krg48_limpapeh_l3 + $total_pasien_mati_krg48_limpapeh_l4 + $total_pasien_mati_krg48_singgalangl1l2 + $total_pasien_mati_krg48_singgalangl3
				+ $total_pasien_mati_krg48_merapil1 + $total_pasien_mati_krg48_merapil2 + $total_pasien_mati_krg48_merapil3 +  $total_pasien_mati_krg48_anak + $total_pasien_mati_krg48_bedah + $total_pasien_mati_krg48_bidan
				+ $total_pasien_mati_krg48_icu + $total_pasien_mati_krg48_nicu;
				$sheet->SetCellValue('AG20', $jmlh_pasien_mati_krg48);

				$jmlh_pasien_mati_lbh48 = $total_pasien_mati_lbh48 + $total_pasien_mati_lbh48_limpapeh_l3 + $total_pasien_mati_lbh48_limpapeh_l4 +  $total_pasien_mati_lbh48_singgalangl1l2 + $total_pasien_mati_lbh48_singgalangl3
				+  $total_pasien_mati_lbh48_merapil1 + $total_pasien_mati_lbh48_merapil2 + $total_pasien_mati_lbh48_merapil3 + $total_pasien_mati_lbh48_anak + $total_pasien_mati_lbh48_bedah + $total_pasien_mati_lbh48_bidan
				+ $total_pasien_mati_lbh48_icu +  $total_pasien_mati_lbh48_nicu;
				$sheet->SetCellValue('AH20', $jmlh_pasien_mati_lbh48);

				$jmlh_pasien_lama_rawat = $total_lama_rawat + $total_lama_rawat_limpapeh_l3 + $total_lama_rawat_limpapeh_l4 + $total_lama_rawat_singgalangl1l2 + $total_lama_rawat_singgalangl3
				+ $total_lama_rawat_merapil1 +  $total_lama_rawat_merapil2 +  $total_lama_rawat_merapil3 + $total_lama_rawat_anak + $total_lama_rawat_bedah + $total_lama_rawat_bidan
				+ $total_lama_rawat_icu + $total_lama_rawat_nicu;
				$sheet->SetCellValue('AI20', $jmlh_pasien_lama_rawat);
				
				$jmlh_pasien_akhir = $jml_pasien_akhir + $jml_pasien_akhir_limpapeh_l3 +  $jml_pasien_akhir_limpapeh_l4 + $jml_pasien_akhir_singgalangl1l2 + $jml_pasien_akhir_singgalangl3
				+ $jml_pasien_akhir_merapi_l1 + $jml_pasien_akhir_merapi_l2 + $jml_pasien_akhir_merapi_l3 + $jml_pasien_akhir_anak + $jml_pasien_akhir_bedah + $jml_pasien_akhir_bidan
				+ $jml_pasien_akhir_icu + $jml_pasien_akhir_nicu;
			
				$sheet->SetCellValue('AJ20', $jmlh_pasien_akhir);

				$jmlh_hari_perawatan = $total_hari_rawat + $total_hari_rawat_limpapeh_l3 + $total_hari_rawat_limpapeh_l4 + $total_hari_rawat_singgalangl1l2 + $total_hari_rawat_singgalangl3
				+ $total_hari_rawat_merapil1 + $total_hari_rawat_merapil2 + $total_hari_rawat_merapil3 + $total_hari_rawat_anak + $total_hari_rawat_bedah + $total_hari_rawat_bidan
				+ $total_hari_rawat_icu + $total_hari_rawat_nicu;
				$sheet->SetCellValue('AK20', $jmlh_hari_perawatan);

				$jmlh_hari_rawat_vip = $total_hari_rawat_vip + $total_hari_rawat_vip_limpapeh_l3 + $total_hari_rawat_vip_limpapeh_l4 + $total_hari_rawat_vip_singgalangl1l2 + $total_hari_rawat_vip_singgalangl3
				+ $total_hari_rawat_vip_merapil1 + $total_hari_rawat_vip_merapil2 + $total_hari_rawat_vip_merapil3 + $total_hari_rawat_vip_anak + $total_hari_rawat_vip_bedah + $total_hari_rawat_vip_bidan
				+ $total_hari_rawat_vip_icu + $total_hari_rawat_vip_nicu;
				$sheet->SetCellValue('AL20', $jmlh_hari_rawat_vip);

				$jmlh_hari_rawat_satu = $total_hari_rawat_satu + $total_hari_rawat_satu_limpapeh_l3 + $total_hari_rawat_satu_limpapeh_l4 + $total_hari_rawat_satu_singgalangl1l2 + $total_hari_rawat_satu_singgalangl3
				+ $total_hari_rawat_satu_merapil1 + $total_hari_rawat_satu_merapil2 + $total_hari_rawat_satu_merapil3 + $total_hari_rawat_satu_anak + $total_hari_rawat_satu_bedah + $total_hari_rawat_satu_bidan
				+ $total_hari_rawat_satu_icu + $total_hari_rawat_satu_nicu;
				$sheet->SetCellValue('AM20', $jmlh_hari_rawat_satu);

				$jmlh_hari_rawat_dua = $total_hari_rawat_dua + $total_hari_rawat_dua_limpapeh_l3 + $total_hari_rawat_dua_limpapeh_l4 + $total_hari_rawat_dua_singgalangl1l2 + $total_hari_rawat_dua_singgalangl3
				+ $total_hari_rawat_dua_merapil1 + $total_hari_rawat_dua_merapil2 + $total_hari_rawat_dua_merapil3 + $total_hari_rawat_dua_anak + $total_hari_rawat_dua_bedah + $total_hari_rawat_dua_bidan
				+ $total_hari_rawat_dua_icu + $total_hari_rawat_dua_nicu;
				$sheet->SetCellValue('AN20', $jmlh_hari_rawat_dua);

				$jmlh_hari_rawat_tiga =  $total_hari_rawat_tiga + $total_hari_rawat_tiga_limpapeh_l3 + $total_hari_rawat_tiga_limpapeh_l4 + $total_hari_rawat_tiga_singgalangl1l2 + $total_hari_rawat_tiga_singgalangl3
				+ $total_hari_rawat_tiga_merapil1 + $total_hari_rawat_tiga_merapil2 + $total_hari_rawat_tiga_merapil3 + $total_hari_rawat_tiga_anak + $total_hari_rawat_tiga_bedah + $total_hari_rawat_tiga_bidan
				+ $total_hari_rawat_tiga_icu + $total_hari_rawat_tiga_nicu;
				$sheet->SetCellValue('AO20', $jmlh_hari_rawat_tiga);

				 	$jumlah_bed_all = 0;
					$jumlah_bed_all_vip = 0;
					$jumlah_bed_all_satu = 0;
					$jumlah_bed_all_dua = 0;
					$jumlah_bed_all_tiga = 0;
					$jumlah_bed_all_rg = 0;

					foreach ($get_tt_ruangan as $tot_tt){
						if($tot_tt->kelas == 'VIP'){ 
							$jumlah_bed_all_vip += $tot_tt->bed;
						}}
						
						$sheet->SetCellValue('AP20', $jumlah_bed_all_vip);

						foreach ($get_tt_ruangan as $tot_tt){
						if($tot_tt->kelas == 'I'){ 
							$jumlah_bed_all_satu += $tot_tt->bed;
						}}
					
						$sheet->SetCellValue('AQ20', $jumlah_bed_all_satu );

						
						foreach ($get_tt_ruangan as $tot_tt){
						if($tot_tt->kelas == 'II'){ 
							$jumlah_bed_all_dua += $tot_tt->bed;
						}}
					
						$sheet->SetCellValue('AR20', $jumlah_bed_all_dua);

						
						foreach ($get_tt_ruangan as $tot_tt){
						if($tot_tt->kelas == 'III'){ 
							$jumlah_bed_all_tiga += $tot_tt->bed;
						}}
						
						$sheet->SetCellValue('AS20',$jumlah_bed_all_tiga);
					   
						
						foreach ($get_tt_ruangan as $tot_tt){
						
							$jumlah_bed_all_rg += $tot_tt->bed;
						}
						
						$sheet->SetCellValue('AT20', $jumlah_bed_all_rg);


				

				$periode = date('j');
				if($jumlah_bed_all_vip == '0'){
					$bor_all_vip = 0;
				}else{
					$bor_kali_all_vip =  $jumlah_bed_all_vip * $periode;
					$bor_bagi_all_vip = $jmlh_hari_rawat_vip / $bor_kali_all_vip;
					$bor_all_vip =  $bor_bagi_all_vip * 100;
				}
				$sheet->SetCellValue('AU20',number_format($bor_all_vip,2).'%');

				if($jumlah_bed_all_satu == '0'){
					$bor_all_satu = 0;
				}else{
					$bor_kali_all_satu =  $jumlah_bed_all_satu * $periode;
					$bor_bagi_all_satu = $jmlh_hari_rawat_satu / $bor_kali_all_satu;
					$bor_all_satu =  $bor_bagi_all_satu * 100;
				}
				$sheet->SetCellValue('AV20',  number_format($bor_all_satu,2).'%');

				if($jumlah_bed_all_dua == '0'){
					$bor_all_dua = 0;
				}else{
					$bor_kali_all_dua =  $jumlah_bed_all_dua * $periode;
					$bor_bagi_all_dua = $jmlh_hari_rawat_dua / $bor_kali_all_dua;
					$bor_all_dua =  $bor_bagi_all_dua * 100;                                           
				}
				$sheet->SetCellValue('AW20', number_format($bor_all_dua,2).'%');

				if($jumlah_bed_all_tiga == '0'){
					$bor_all_tiga = 0;
				}else{
					$bor_kali_all_tiga =  $jumlah_bed_all_tiga * $periode;
					$bor_bagi_all_tiga = $jmlh_hari_rawat_tiga / $bor_kali_all_tiga;
					$bor_all_tiga = $bor_bagi_all_tiga * 100;
				}
				$sheet->SetCellValue('AX20', number_format($bor_all_tiga,2).'%');

				if( $jumlah_bed_all_rg == '0'){
					$bor_fix_all = 0;
				}else{
					$bor_kali_fix_all =  $jumlah_bed_all_rg * $periode;
					$bor_bagi_fix_all = $jmlh_hari_perawatan / $bor_kali_fix_all;
					$bor_fix_all = $bor_bagi_fix_all * 100;
				}
			
				$sheet->SetCellValue('AY20', number_format($bor_fix_all,2).'%');


				if( $jumlah_bed_all_rg == '0'){
					$bor_fix_all = 0;
				}else{
					$bor_kali_fix_all =  $jumlah_bed_all_rg * $periode;
					$bor_bagi_fix_all = $jmlh_hari_perawatan / $bor_kali_fix_all;
					$bor_fix_all = $bor_bagi_fix_all * 100;
				}
				$periode = date('j');
				$avlos = $jmlh_pasien_lama_rawat / $jmlh_pasien_keluar_hidup_mati;
				$toi_kali =  $jumlah_bed_all_rg * $periode;
				$toi_kurang = $toi_kali - $jmlh_hari_perawatan;
				$toi_fix =  $toi_kurang / $jmlh_pasien_keluar_hidup_mati;
				$bto = $jmlh_pasien_keluar_hidup_mati / $jumlah_bed_all_rg;
				$gdr = $jmlh_pasien_keluar_mati / $jmlh_pasien_keluar_hidup_mati;
				$gdr_fix =  $gdr * 1000;
				$ndr = $jmlh_pasien_mati_krg48 / $jmlh_pasien_keluar_hidup_mati;
				$ndr_fix =  $ndr * 1000;

				$sheet->SetCellValue('W23','BOR RS');
				$sheet->SetCellValue('W25','AVLOS');
				$sheet->SetCellValue('W27','TOI');
				$sheet->SetCellValue('W29','BTO');
				$sheet->SetCellValue('W31','GDR');
				$sheet->SetCellValue('W33','NDR');

				$sheet->SetCellValue('X23',number_format($bor_fix_all,2).'%');
				$sheet->SetCellValue('X25',ceil($avlos));
				$sheet->SetCellValue('X27',ceil($toi_fix));
				$sheet->SetCellValue('X29',ceil($bto));
				$sheet->SetCellValue('X31',ceil($gdr_fix));
				$sheet->SetCellValue('X33',ceil($ndr_fix));

				// ob_end_clean();
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan BOR LOS TOI'.' '.$bulan_now;
				//ob_end_clean();
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');
		
				$writer->save('php://output');

			
			
			}

		}


		function menu_monitoring_jmlh_bed_ruangan(){
			$data['data_bed'] = $this->Rjmlaporan->get_jmlh_bed_ruangan_perbulan()->result();
			$this->load->view('irj/monitoring_jmlh_bed_ruangan',$data);

	}

	function monitoring_jmlh_bed($bln){
		$cek_bed_ruangan = $this->Rjmlaporan->count_jmlh_bed_ruangan_perbulan($bln)->row();
		$get_kelompok_ruang = $this->Rjmlaporan->get_kelompok_ruangan()->result();

		if($cek_bed_ruangan->jml == '0'){
			
			foreach($get_kelompok_ruang as $r){
				$tt_vip = $this->Rjmlaporan->get_tt_vip_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_vip->jml;
				$data['kelas'] ='VIP';
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->insert_monitoring_jmlh_bed($data);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_satu = $this->Rjmlaporan->get_tt_satu_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_satu->jml;
				$data['kelas'] ='I';
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->insert_monitoring_jmlh_bed($data);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_dua = $this->Rjmlaporan->get_tt_dua_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_dua->jml;
				$data['kelas'] ='II';
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->insert_monitoring_jmlh_bed($data);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_tiga = $this->Rjmlaporan->get_tt_tiga_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_tiga->jml;
				$data['kelas'] ='III';
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->insert_monitoring_jmlh_bed($data);
			}


			
		}else{

			foreach($get_kelompok_ruang as $r){
				$tt_vip = $this->Rjmlaporan->get_tt_vip_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_vip->jml;
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->update_monitor_bed_ruangan_vip($data,$bln);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_vip = $this->Rjmlaporan->get_tt_satu_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_vip->jml;
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->update_monitor_bed_ruangan_satu($data,$bln);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_vip = $this->Rjmlaporan->get_tt_dua_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_vip->jml;
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->update_monitor_bed_ruangan_dua($data,$bln);
			}

			foreach($get_kelompok_ruang as $r){
				$tt_vip = $this->Rjmlaporan->get_tt_tiga_ruangan($r->id_kelompok)->row();
				$data['ruangan'] = $r->nama_ruang;
				$data['bed'] = $tt_vip->jml;
				$data['tgl_update'] =date('Y-m-d');
				$result = $this->Rjmlaporan->update_monitor_bed_ruangan_tiga($data,$bln);
			}

		}
		redirect('irj/Rjclaporan/menu_monitoring_jmlh_bed_ruangan','refresh');
	}

	public function morbiditas_diagnosa() {
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');
		$layanan = $this->input->post('layanan');
	
		if($tampil == 'TGL') {
			$data['title'] = 'Laporan Morbiditas '.date("d F Y", strtotime($date));
			$data['judul'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tampil;
			$data['layanan'] = $layanan;
			$data['morbiditas'] = $this->Rjmlaporan->get_laporan_morbiditas($date, $tampil,$layanan)->result();
		} else if($tampil == 'BLN') {
			$data['title'] = 'Laporan Morbiditas '.date("F Y", strtotime($month));
			$data['judul'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tampil;
			$data['layanan'] = $layanan;
			$data['morbiditas'] = $this->Rjmlaporan->get_laporan_morbiditas($month, $tampil,$layanan)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Morbiditas '.date("d F Y", strtotime($tgl));
			$data['judul'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = 'TGL';
			$data['morbiditas'] = array();
		}
		$this->load->view('irj/lap_morbiditas', $data);
	}
	
	public function excel_morbiditas_diagnosa($date, $tampil,$layanan) {
		if($tampil == 'BLN') {
			$tanggal = date("F Y", strtotime($date));
		} else {
			$tanggal = date("d F Y", strtotime($date));
		}
	
		$data = $this->Rjmlaporan->get_laporan_morbiditas($date, $tampil,$layanan)->result();
	
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('ICD 10');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Diagnosa');
		$sheet->mergeCells('D1:E1')
			->getCell('D1')
			->setValue('0hr-27hr');
		$sheet->mergeCells('F1:G1')
			->getCell('F1')
			->setValue('28hr-<1th');
		$sheet->mergeCells('H1:I1')
			->getCell('H1')
			->setValue('1th-4th');
		$sheet->mergeCells('J1:K1')
			->getCell('J1')
			->setValue('5th-14th');
		$sheet->mergeCells('L1:M1')
			->getCell('L1')
			->setValue('15th-24th');
		$sheet->mergeCells('N1:O1')
			->getCell('N1')
			->setValue('25th-44th');
		$sheet->mergeCells('P1:Q1')
			->getCell('P1')
			->setValue('45th-64th');
		$sheet->mergeCells('R1:S1')
			->getCell('R1')
			->setValue('> 65th');
		$sheet->mergeCells('T1:V1')
			->getCell('T1')
			->setValue('Jumlah Kasus Baru Menurut Sex');
		$sheet->mergeCells('W1:W2')
			->getCell('W1')
			->setValue('Jumlah Kunjungan B+L');
		$sheet->setCellValue('D2', 'L');
		$sheet->setCellValue('E2', 'P');
		$sheet->setCellValue('F2', 'L');
		$sheet->setCellValue('G2', 'P');
		$sheet->setCellValue('H2', 'L');
		$sheet->setCellValue('I2', 'P');
		$sheet->setCellValue('J2', 'L');
		$sheet->setCellValue('K2', 'P');
		$sheet->setCellValue('L2', 'L');
		$sheet->setCellValue('M2', 'P');
		$sheet->setCellValue('N2', 'L');
		$sheet->setCellValue('O2', 'P');
		$sheet->setCellValue('P2', 'L');
		$sheet->setCellValue('Q2', 'P');
		$sheet->setCellValue('R2', 'L');
		$sheet->setCellValue('S2', 'P');
		$sheet->setCellValue('T2', 'L');
		$sheet->setCellValue('U2', 'P');
		$sheet->setCellValue('V2', 'Total');
	
		$no = 1;
		$x = 3;
	
		foreach($data as $row) {
			$total_l = $row->hari_0_27_baru_l + $row->hari_28_1_baru_l + $row->tahun_1_4_baru_l + $row->tahun_5_14_baru_l + $row->tahun_15_24_baru_l + $row->tahun_25_44_baru_l + $row->tahun_45_64_baru_l + $row->tahun_65_baru_l; 
			$total_p = $row->hari_0_27_baru_p + $row->hari_28_1_baru_p + $row->tahun_1_4_baru_p + $row->tahun_5_14_baru_p + $row->tahun_15_24_baru_p + $row->tahun_25_44_baru_p + $row->tahun_45_64_baru_p + $row->tahun_65_baru_p; 
			$total_lama = $row->hari_0_27_lama + $row->hari_28_1_lama + $row->tahun_1_4_lama + $row->tahun_5_14_lama + $row->tahun_15_24_lama + $row->tahun_25_44_lama + $row->tahun_45_64_lama + $row->tahun_65_lama;
	
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->id_diagnosa);
			$sheet->setCellValue('C'.$x, $row->diagnosa);
			$sheet->setCellValue('D'.$x, $row->hari_0_27_baru_l);
			$sheet->setCellValue('E'.$x, $row->hari_0_27_baru_p);
			$sheet->setCellValue('F'.$x, $row->hari_28_1_baru_l);
			$sheet->setCellValue('G'.$x, $row->hari_28_1_baru_p);
			$sheet->setCellValue('H'.$x, $row->tahun_1_4_baru_l);
			$sheet->setCellValue('I'.$x, $row->tahun_1_4_baru_p);
			$sheet->setCellValue('J'.$x, $row->tahun_5_14_baru_l);
			$sheet->setCellValue('K'.$x, $row->tahun_5_14_baru_p);
			$sheet->setCellValue('L'.$x, $row->tahun_15_24_baru_l);
			$sheet->setCellValue('M'.$x, $row->tahun_15_24_baru_p);
			$sheet->setCellValue('N'.$x, $row->tahun_25_44_baru_l);
			$sheet->setCellValue('O'.$x, $row->tahun_25_44_baru_p);
			$sheet->setCellValue('P'.$x, $row->tahun_45_64_baru_l);
			$sheet->setCellValue('Q'.$x, $row->tahun_45_64_baru_p);
			$sheet->setCellValue('R'.$x, $row->tahun_65_baru_l);
			$sheet->setCellValue('S'.$x, $row->tahun_65_baru_p);
			$sheet->setCellValue('T'.$x, $total_l);
			$sheet->setCellValue('U'.$x, $total_p);
			$sheet->setCellValue('V'.$x, $total_l + $total_p);
			$sheet->setCellValue('W'.$x, $total_l + $total_p + $total_lama);
			$x++;
		}
		if($layanan == 'rj'){
			$layananya = 'Rawat Jalan';
		}else if($layanan == 'rd'){
			$layananya = 'Rawat Darurat';
		}else{
			$layananya = 'Rawat Inap';
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Morbiditas '.$layananya.' '. $tanggal.' '.'Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function list_tindakan() {
		$data['list_poli'] = $this->Rjmpencarian->get_poliklinik()->result();
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
		$tampil = $this->input->post('tampil_per');
		$poli = $this->input->post('id_poli');

		if($tampil == 'TGL') {
			$data['title'] = 'Laporan Tindakan Rawat Jalan '.date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tampil;
			$data['date'] = $date;
			if($poli == 'semua') {
				$data['nm_poli'] = '(SEMUA Poli)';
				$id_poli = 'semua';
				$data['poli'] = $id_poli;
			} else {
				$data['nm_poli'] = '('.explode("-", $poli)[1].')';
				$id_poli = explode("-", $poli)[0];
				$data['poli'] = $id_poli;
			}
			$data['tindakan'] = $this->Rjmlaporan->get_lap_list_tindakan($date, $tampil, $id_poli)->result();
		} else if($tampil == 'BLN') {
			$data['title'] = 'Laporan Tindakan Rawat Jalan '.date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['tampil'] = $tampil;
			$data['date'] = $month;
			if($poli == 'semua') {
				$data['nm_poli'] = '(SEMUA Poli)';
				$id_poli = 'semua';
				$data['poli'] = $id_poli;
			} else {
				$data['nm_poli'] = '('.explode("-", $poli)[1].')';
				$id_poli = explode("-", $poli)[0];
				$data['poli'] = $id_poli;
			}
			$data['tindakan'] = $this->Rjmlaporan->get_lap_list_tindakan($month, $tampil, $id_poli)->result();
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Tindakan Rawat Jalan '.date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['date'] = $tgl;
			$data['poli'] = 'semua';
			$data['nm_poli'] = '(SEMUA Poli)';
			$data['tindakan'] = $this->Rjmlaporan->get_lap_list_tindakan($tgl, 'TGL', 'semua')->result();
		}

		$this->load->view('irj/lap_list_tindakan', $data);
	}

	public function excel_list_tindakan($date, $tampil, $poli) {
		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
			if($poli == 'semua') {
				$nm_poli = '(SEMUA Poli)';
			} else {
				$nm_poli = $this->Rjmlaporan->get_nm_poliklinik($poli)->row()->nm_poli;
			}
		} else {
			$tgl = date("F Y", strtotime($date));
			if($poli == 'semua') {
				$nm_poli = '(SEMUA Poli)';
			} else {
				$nm_poli = $this->Rjmlaporan->get_nm_poliklinik($poli)->row()->nm_poli;
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

		$data = $this->Rjmlaporan->get_lap_list_tindakan($date, $tampil, $poli)->result();

		$no = 1;
		$x = 3;
		$total_bpjs = 0;
        $total_umum = 0;
        $total_iks = 0;
        $total = 0;
        $tarif_rs = 0;
        $total_tarif = 0;

		foreach($data as $row) {
			$total_bpjs += $row->bpjs;
            $total_umum += $row->umum;
            $total_iks += $row->iks;
            $total += $row->bpjs + $row->umum + $row->iks;
            $tarif_rs += $row->tarif_rs;
            $total_tarif += ($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs;

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nmtindakan);
			$sheet->setCellValue('C'.$x, $row->nm_poli);
			$sheet->setCellValue('D'.$x, $row->bpjs);
			$sheet->setCellValue('E'.$x, $row->umum);
			$sheet->setCellValue('F'.$x, $row->iks);
			$sheet->setCellValue('G'.$x, $row->bpjs + $row->umum + $row->iks);
			$sheet->setCellValue('H'.$x, number_format($row->tarif_rs));
			$sheet->setCellValue('I'.$x, number_format(($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs));
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Grand Total');
		$sheet->mergeCells('A'.$x.':'.'C'.$x.'');
		$sheet->setCellValue('D'.$x, $total_bpjs);
		$sheet->setCellValue('E'.$x, $total_umum);
		$sheet->setCellValue('F'.$x, $total_iks);
		$sheet->setCellValue('G'.$x, $total);
		$sheet->setCellValue('H'.$x, number_format($tarif_rs));
		$sheet->setCellValue('I'.$x, number_format($total_tarif));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Tindakan Rawat Jalan '.$tgl.' ('.$nm_poli.')';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function lap_serangan_stroke()
		{
			
			$tgl_awal = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');
			$bulan = $this->input->post('date_months');
			$tampil_per = $this->input->post('tampil_per');

			
				if($tampil_per == 'TGL'){
					$data['title'] = 'Laporan Serangan Stroke ';
					// $data['date_title'] = date("d F Y", strtotime($tgl_awal)) - date("d F Y", strtotime($tgl_akhir));
					$data['date1'] = $tgl_awal;
					$data['date2'] = $tgl_akhir;
					$data['tampil'] = $tampil_per;
					$data['data_kunjungan']=$this->Rjmlaporan->data_lap_serangan_stroke($data,$tampil_per)->row();
					$this->load->view('irj/lap_serangan_stroke',$data);
				}else if($tampil_per == 'BLN'){
					$data['title'] = 'Laporan Serangan Stroke ';
					// $data['date_title'] = date("F Y", strtotime($bulan));
					$data['date'] = $bulan;
					$data['tampil'] = $tampil_per;
					$data['data_kunjungan']=$this->Rjmlaporan->data_lap_serangan_stroke($data,$tampil_per)->row();
					$this->load->view('irj/lap_serangan_stroke',$data);
				}else{
					$data['bulan'] = $bulan;

					$tgl = date('Y-m-d');
					$data['title'] = 'Laporan Serangan Stroke ';
					// $data['date_title'] = date("d F Y", strtotime($tgl));
					$data['date'] = $tgl;
					$data['tampil'] = $tampil_per;
					$data['data_kunjungan']=$this->Rjmlaporan->data_lap_serangan_stroke($data,$tampil_per)->row();
					$this->load->view('irj/lap_serangan_stroke',$data);
				}

			
		
		}

		public function excel_lap_serangan_stroke_tgl($tgl_awal,$tgl_akhir)
		{
				$data_kunjungan=$this->Rjmlaporan->data_lap_serangan_stroke_tgl($tgl_awal,$tgl_akhir)->row();
					
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Serangan Stroke');
				$sheet->setCellValue('C1', 'Jumlah');
				$sheet->setCellValue('D1', '%');

				$total_pasien = $data_kunjungan->kel_golden + $data_kunjungan->kel_akut + $data_kunjungan->non_stroke;

				$sheet->setCellValue('A2', 'A');
				$sheet->setCellValue('B2', 'Kel Golden Periode');
				$sheet->setCellValue('C2', $data_kunjungan->kel_golden);
				if($data_kunjungan->kel_golden == 0){
					$persen_kel_golden = 0;
				}else{
					$persen_kel_golden = $data_kunjungan->kel_golden / $total_pasien;
				}
				
				$persentase_kel_golden = $persen_kel_golden * 100;
				$sheet->setCellValue('D2', number_format($persentase_kel_golden,2).'%');


				$sheet->setCellValue('A3', '1');
				$sheet->setCellValue('B3', '* ≤ 4,5 Jam');
				$sheet->setCellValue('C3', $data_kunjungan->kel_golden_1);
				$sheet->setCellValue('D3', '');

				$sheet->setCellValue('A4', '');
				$sheet->setCellValue('B4', '- 1 Jam');
				$sheet->setCellValue('C4', $data_kunjungan->kel_golden_1jam);
				$sheet->setCellValue('D4', '');

				$sheet->setCellValue('A5', '');
				$sheet->setCellValue('B5', '- 2 Jam');
				$sheet->setCellValue('C5', $data_kunjungan->kel_golden_2jam);
				$sheet->setCellValue('D5', '');

				$sheet->setCellValue('A6', '');
				$sheet->setCellValue('B6', '- 3 Jam');
				$sheet->setCellValue('C6', $data_kunjungan->kel_golden_3jam);
				$sheet->setCellValue('D6', '');

				$sheet->setCellValue('A7', '');
				$sheet->setCellValue('B7', '- 4 Jam');
				$sheet->setCellValue('C7', $data_kunjungan->kel_golden_4jam);
				$sheet->setCellValue('D7', '');

				$sheet->setCellValue('A8', '');
				$sheet->setCellValue('B8', '- 4.5 Jam');
				$sheet->setCellValue('C8', $data_kunjungan->kel_golden_4koma5jam);
				$sheet->setCellValue('D8', '');

				$sheet->setCellValue('A9', '2');
				$sheet->setCellValue('B9', '* > 4,5 Jam sd/ ≤ 6 Jam');
				$sheet->setCellValue('C9', $data_kunjungan->kel_golden_2);
				$sheet->setCellValue('D9', '');

				$sheet->setCellValue('A10', 'B');
				$sheet->setCellValue('B10', 'Kel Akut');
				$sheet->setCellValue('C10', $data_kunjungan->kel_akut);
				if($data_kunjungan->kel_akut == 0){
					$persen_kel_akut = 0;
				}else{
					$persen_kel_akut = $data_kunjungan->kel_akut / $total_pasien;
				}
				
				$persentase_kel_akut = $persen_kel_akut * 100;
				$sheet->setCellValue('D10', number_format($persentase_kel_akut,2).'%');

				$sheet->setCellValue('A11', '1');
				$sheet->setCellValue('B11', '> 06 Jam sd ≤ 24 Jam');
				$sheet->setCellValue('C11', $data_kunjungan->kel_akut_1);
				$sheet->setCellValue('D11', '');

				$sheet->setCellValue('A12', '2');
				$sheet->setCellValue('B12', '> 24 Jam sd ≤ 03 hari');
				$sheet->setCellValue('C12', $data_kunjungan->kel_akut_2);
				$sheet->setCellValue('D12', '');

				$sheet->setCellValue('A13', '3');
				$sheet->setCellValue('B13', '> 03 Hari sd ≤ 07 hari');
				$sheet->setCellValue('C13', $data_kunjungan->kel_akut_3);
				$sheet->setCellValue('D13', '');

				$sheet->setCellValue('A14', '4');
				$sheet->setCellValue('B14', '> 07 hari');
				$sheet->setCellValue('C14', $data_kunjungan->kel_akut_4);
				$sheet->setCellValue('D14', '');

				$sheet->setCellValue('A15', 'C');
				$sheet->setCellValue('B15', 'Non Stroke');
				$sheet->setCellValue('C15', $data_kunjungan->non_stroke);
				if($data_kunjungan->non_stroke == 0){
					$persen_non_stroke = 0;
				}else{
					$persen_non_stroke = $data_kunjungan->non_stroke / $total_pasien;
				}
				
				$persentase_non_stroke = $persen_non_stroke * 100;
				$sheet->setCellValue('D15', number_format($persentase_non_stroke,2).'%');

				$sheet->setCellValue('A16', '');
				$sheet->setCellValue('B16', 'Grand Total');
				$sheet->setCellValue('C16', $total_pasien);
				if($total_pasien == 0){
					$persen_total = 0;
				}else{
					$persen_total = $total_pasien / $total_pasien;
				}
				
				$persentase_total = $persen_total * 100;
				$sheet->setCellValue('D16', number_format($persentase_total,2).'%');
				
				

				
														
				
				$writer = new Xlsx($spreadsheet);
				$awal = date('d/m/Y',strtotime($tgl_awal));
				$akhir = date('d/m/Y',strtotime($tgl_akhir));
				$filename = 'Laporan Serangan Stroke'.' '.$awal.'s/d'.$akhir;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');		
	}

	public function excel_lap_serangan_stroke_bln($bln)
		{
				$data_kunjungan=$this->Rjmlaporan->data_lap_serangan_stroke_bln($bln)->row();
					
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'No');
				$sheet->setCellValue('B1', 'Serangan Stroke');
				$sheet->setCellValue('C1', 'Jumlah');
				$sheet->setCellValue('D1', '%');

				$total_pasien = $data_kunjungan->kel_golden + $data_kunjungan->kel_akut + $data_kunjungan->non_stroke;

				$sheet->setCellValue('A2', 'A');
				$sheet->setCellValue('B2', 'Kel Golden Periode');
				$sheet->setCellValue('C2', $data_kunjungan->kel_golden);
				if($data_kunjungan->kel_golden == 0){
					$persen_kel_golden = 0;
				}else{
					$persen_kel_golden = $data_kunjungan->kel_golden / $total_pasien;
				}
				
				$persentase_kel_golden = $persen_kel_golden * 100;
				$sheet->setCellValue('D2', number_format($persentase_kel_golden,2).'%');


				$sheet->setCellValue('A3', '1');
				$sheet->setCellValue('B3', '* ≤ 4,5 Jam');
				$sheet->setCellValue('C3', $data_kunjungan->kel_golden_1);
				$sheet->setCellValue('D3', '');

				$sheet->setCellValue('A4', '');
				$sheet->setCellValue('B4', '- 1 Jam');
				$sheet->setCellValue('C4', $data_kunjungan->kel_golden_1jam);
				$sheet->setCellValue('D4', '');

				$sheet->setCellValue('A5', '');
				$sheet->setCellValue('B5', '- 2 Jam');
				$sheet->setCellValue('C5', $data_kunjungan->kel_golden_2jam);
				$sheet->setCellValue('D5', '');

				$sheet->setCellValue('A6', '');
				$sheet->setCellValue('B6', '- 3 Jam');
				$sheet->setCellValue('C6', $data_kunjungan->kel_golden_3jam);
				$sheet->setCellValue('D6', '');

				$sheet->setCellValue('A7', '');
				$sheet->setCellValue('B7', '- 4 Jam');
				$sheet->setCellValue('C7', $data_kunjungan->kel_golden_4jam);
				$sheet->setCellValue('D7', '');

				$sheet->setCellValue('A8', '');
				$sheet->setCellValue('B8', '- 4.5 Jam');
				$sheet->setCellValue('C8', $data_kunjungan->kel_golden_4koma5jam);
				$sheet->setCellValue('D8', '');

				$sheet->setCellValue('A9', '2');
				$sheet->setCellValue('B9', '* > 4,5 Jam sd/ ≤ 6 Jam');
				$sheet->setCellValue('C9', $data_kunjungan->kel_golden_2);
				$sheet->setCellValue('D9', '');

				$sheet->setCellValue('A10', 'B');
				$sheet->setCellValue('B10', 'Kel Akut');
				$sheet->setCellValue('C10', $data_kunjungan->kel_akut);
				if($data_kunjungan->kel_akut == 0){
					$persen_kel_akut = 0;
				}else{
					$persen_kel_akut = $data_kunjungan->kel_akut / $total_pasien;
				}
				
				$persentase_kel_akut = $persen_kel_akut * 100;
				$sheet->setCellValue('D10', number_format($persentase_kel_akut,2).'%');

				$sheet->setCellValue('A11', '1');
				$sheet->setCellValue('B11', '> 06 Jam sd ≤ 24 Jam');
				$sheet->setCellValue('C11', $data_kunjungan->kel_akut_1);
				$sheet->setCellValue('D11', '');

				$sheet->setCellValue('A12', '2');
				$sheet->setCellValue('B12', '> 24 Jam sd ≤ 03 hari');
				$sheet->setCellValue('C12', $data_kunjungan->kel_akut_2);
				$sheet->setCellValue('D12', '');

				$sheet->setCellValue('A13', '3');
				$sheet->setCellValue('B13', '> 03 Hari sd ≤ 07 hari');
				$sheet->setCellValue('C13', $data_kunjungan->kel_akut_3);
				$sheet->setCellValue('D13', '');

				$sheet->setCellValue('A14', '4');
				$sheet->setCellValue('B14', '> 07 hari');
				$sheet->setCellValue('C14', $data_kunjungan->kel_akut_4);
				$sheet->setCellValue('D14', '');

				$sheet->setCellValue('A15', 'C');
				$sheet->setCellValue('B15', 'Non Stroke');
				$sheet->setCellValue('C15', $data_kunjungan->non_stroke);
				if($data_kunjungan->non_stroke == 0){
					$persen_non_stroke = 0;
				}else{
					$persen_non_stroke = $data_kunjungan->non_stroke / $total_pasien;
				}
				
				$persentase_non_stroke = $persen_non_stroke * 100;
				$sheet->setCellValue('D15', number_format($persentase_non_stroke,2).'%');

				$sheet->setCellValue('A16', '');
				$sheet->setCellValue('B16', 'Grand Total');
				$sheet->setCellValue('C16', $total_pasien);
				if($total_pasien == 0){
					$persen_total = 0;
				}else{
					$persen_total = $total_pasien / $total_pasien;
				}
				
				$persentase_total = $persen_total * 100;
				$sheet->setCellValue('D16', number_format($persentase_total,2).'%');
				
				

				
														
				
				$writer = new Xlsx($spreadsheet);
				$awal = date('m/Y',strtotime($bln));
				$filename = 'Laporan Serangan Stroke'.' '.$awal;
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');

				$writer->save('php://output');		
	}

	public function data_pasien_irj() {
		$data['title'] = 'Data Pasien';
		
		$data['daftar_pasien']=$this->Rjmlaporan->get_data_pasien_new()->result();
		
		$this->load->view('irj/rjvformdaftarpasiennew',$data);
      
	}

	public function data_pasien_kontrol_irj() {
		$data['title'] = 'Data Pasien Kontrol';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['controller']=$this; 
		$data['poliklinik']=$this->Rjmpencarian->get_poliklinik()->result();
		$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -14 day'));
		$week_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rjmlaporan->get_data_pasien_kontrol_irj_new($week_awal, $week_akhir);
		$this->load->view('irj/list_data_pasien_kontrol',$data);
      
	}

	public function lapkeu_bpjs_rajal()
	{
		// var_dump($this->input->post());die();
		$data['title']='Laporan Keuangan Instalasi Rawat Jalan BPJS';
		$dateRange = $this->input->post('tanggal_laporan');
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_harian_bpjs($data['tgl'],$data['tgl1'])->result();	
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_laporan_keu']= array();
		}

		$this->load->view('irj/rjvlapkeuanganbpjs',$data);
	}

	public function lapkeu_jasa_rajal()
	{
	
		$data['title']='Laporan Jasa Instalasi Rawat Jalan';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['carabayar'] = $this->input->post('carabayar');
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_laporan']=$this->Rjmlaporan->get_data_pasien_jasa_rj($data['tgl'],$data['tgl1'],$data['carabayar'])->result();	
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_laporan']=array();
		}

		$this->load->view('irj/rjvlapjasarj',$data);
	}

	public function lapkeu_jasa_igd()
	{
	
		$data['title']='Laporan Jasa Instalasi Rawat Darurat';
		$dateRange = $this->input->post('tanggal_laporan');
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_laporan']=$this->Rjmlaporan->get_data_pasien_jasa_rd($data['tgl'],$data['tgl1'])->result();	
			$data['data_tindakan']=$this->Rjmlaporan->get_data_pasien_jasa_tind_rj($data['tgl'],$data['tgl1'])->result();
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_laporan']=array();
		}

		$this->load->view('irj/rjvlapjasard',$data);
	}

	public function lapkeu_jasa_iri()
	{
	
		$data['title']='Laporan Jasa Instalasi Rawat Inap';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['carabayar'] = $this->input->post('carabayar');
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_laporan']=$this->Rjmlaporan->get_data_pasien_jasa_ri($data['tgl'],$data['tgl1'],$data['carabayar'])->result();	
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_laporan']=array();
		}

		$this->load->view('irj/rjvlapjasari',$data);
	}

	public function excel_lap_jasa_iri($tgl,$tgl1,$carabayar)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$data =$this->Rjmlaporan->get_data_pasien_jasa_ri($tgl,$tgl1,$carabayar)->result();
		if($carabayar == 'SEMUA'){
			$bayar = 'BPJS dan Umum';
		}else{
			$bayar = $carabayar;
		}
		
		$sheet->setCellValue('A1', 'LAPORAN JASA RAWAT INAP'.' '.$bayar.' '.$tgl.' '.'sampai'.' '.$tgl1);

		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Tgl Masuk');
		$sheet->setCellValue('C3', 'Tgl keluar');
		$sheet->setCellValue('D3', 'Nama');
		$sheet->setCellValue('E3', 'No RM');
		$sheet->setCellValue('F3', 'No SEP');
		$sheet->setCellValue('G3', 'DPJP');
		$sheet->mergeCells('H3:I3');
		$sheet->mergeCells('J3:K3');
		$sheet->mergeCells('L3:M3');
		$sheet->mergeCells('N3:O3');
		$sheet->mergeCells('P3:Q3');

		$sheet->setCellValue('H3', 'Tindakan');
		$sheet->setCellValue('J3', 'Laboratorium');
		$sheet->setCellValue('L3', 'Radiologi');
		$sheet->setCellValue('N3', 'Operasi');
		$sheet->setCellValue('P3', 'Resep');


		$sheet->setCellValue('H4', 'Qty');
		$sheet->setCellValue('I4', 'Biaya');
		$sheet->setCellValue('J4', 'Qty');
		$sheet->setCellValue('K4', 'Biaya');
		$sheet->setCellValue('L4', 'Qty');
		$sheet->setCellValue('M4', 'Biaya');
		$sheet->setCellValue('N4', 'Qty');
		$sheet->setCellValue('O4', 'Biaya');
		$sheet->setCellValue('P4', 'Qty');
		$sheet->setCellValue('Q4', 'Biaya');

		$x = 6;
		$i = 1;
		foreach($data as $val){
			$sheet->setCellValue('A'.$x, $i++);
			$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($val->tgl_masuk)));
			$sheet->setCellValue('C'.$x, date('d-m-Y',strtotime($val->tgl_keluar)));
			$sheet->setCellValue('D'.$x, $val->nama);
			$sheet->setCellValue('E'.$x, $val->no_cm);
			$sheet->setCellValue('F'.$x, $val->no_sep);
			$sheet->setCellValue('G'.$x, $val->dpjp);
			$sheet->setCellValue('H'.$x, $val->qty_tindakan);
			$sheet->setCellValue('I'.$x, intval($val->harga_tindakan));
			$sheet->setCellValue('J'.$x, $val->qty_labor);
			$sheet->setCellValue('K'.$x, intval($val->harga_labor));
			$sheet->setCellValue('L'.$x, $val->qty_rad);
			$sheet->setCellValue('M'.$x, intval($val->harga_rad));
			$sheet->setCellValue('N'.$x, $val->qty_ok);
			$sheet->setCellValue('O'.$x, intval($val->harga_ok));
			$sheet->setCellValue('P'.$x, $val->qty_obat);
			$sheet->setCellValue('Q'.$x, intval($val->harga_obat));
			$x++;
		}
	
	

		$writer = new Xlsx($spreadsheet);
		
		$filename = 'Laporan Jasa Rawat Inap';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_jasa_irj($tgl,$tgl1,$carabayar)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$data =$this->Rjmlaporan->get_data_pasien_jasa_rj($tgl,$tgl1,$carabayar)->result();
		if($carabayar == 'SEMUA'){
			$bayar = 'BPJS dan Umum';
		}else{
			$bayar = $carabayar;
		}
		
		$sheet->setCellValue('A1', 'LAPORAN JASA RAWAT JALAN'.' '.$bayar.' '.$tgl.' '.'sampai'.' '.$tgl1);

		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Tgl Masuk');
		$sheet->setCellValue('C3', 'Tgl keluar');
		$sheet->setCellValue('D3', 'Nama');
		$sheet->setCellValue('E3', 'No RM');
		$sheet->setCellValue('F3', 'No SEP');
		$sheet->setCellValue('G3', 'DPJP');
		$sheet->mergeCells('H3:I3');
		$sheet->mergeCells('J3:K3');
		$sheet->mergeCells('L3:M3');
		$sheet->mergeCells('N3:O3');
		$sheet->mergeCells('P3:Q3');

		$sheet->setCellValue('H3', 'Tindakan');
		$sheet->setCellValue('J3', 'Laboratorium');
		$sheet->setCellValue('L3', 'Radiologi');
		$sheet->setCellValue('N3', 'Operasi');
		$sheet->setCellValue('P3', 'Resep');


		$sheet->setCellValue('H4', 'Qty');
		$sheet->setCellValue('I4', 'Biaya');
		$sheet->setCellValue('J4', 'Qty');
		$sheet->setCellValue('K4', 'Biaya');
		$sheet->setCellValue('L4', 'Qty');
		$sheet->setCellValue('M4', 'Biaya');
		$sheet->setCellValue('N4', 'Qty');
		$sheet->setCellValue('O4', 'Biaya');
		$sheet->setCellValue('P4', 'Qty');
		$sheet->setCellValue('Q4', 'Biaya');

		$x = 6;
		$i = 1;
		foreach($data as $val){
			$sheet->setCellValue('A'.$x, $i++);
			$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($val->tgl_masuk)));
			$sheet->setCellValue('C'.$x, date('d-m-Y',strtotime($val->tgl_keluar)));
			$sheet->setCellValue('D'.$x, $val->nama);
			$sheet->setCellValue('E'.$x, $val->no_cm);
			$sheet->setCellValue('F'.$x, $val->no_sep);
			$sheet->setCellValue('G'.$x, $val->dpjp);
			$sheet->setCellValue('H'.$x, $val->qty_tindakan);
			$sheet->setCellValue('I'.$x, intval($val->harga_tindakan));
			$sheet->setCellValue('J'.$x, $val->qty_labor);
			$sheet->setCellValue('K'.$x, intval($val->harga_labor));
			$sheet->setCellValue('L'.$x, $val->qty_rad);
			$sheet->setCellValue('M'.$x, intval($val->harga_rad));
			$sheet->setCellValue('N'.$x, $val->qty_ok);
			$sheet->setCellValue('O'.$x, intval($val->harga_ok));
			$sheet->setCellValue('P'.$x, $val->qty_obat);
			$sheet->setCellValue('Q'.$x, intval($val->harga_obat));
			$x++;
		}
	
	

		$writer = new Xlsx($spreadsheet);
		
		$filename = 'Laporan Jasa Rawat Jalan';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lapkeu_jasa_tind_rajal()
	{
	
		$data['title']='Laporan Jasa Instalasi Tindakan Rawat Jalan';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['id_dokter'] = $this->input->post('id_dokter');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['id_poli'] = $this->input->post('id_poli');
		$data['poli'] = $this->Rjmlaporan->get_data_poli()->result();
		$data['data_dokter'] = $this->Rjmlaporan->get_data_dokter_dpjp()->result();	
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_tind']=$this->Rjmlaporan->get_data_qty_tind_jasa_rajal_new($data['tgl'],$data['tgl1'],$data['id_dokter'],$data['id_poli'],$data['cara_bayar'])->result();
		
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_tind']=array();
			$data['data_detail_tind']=array();
		}

		$this->load->view('irj/rjvlapjasa_tind_rj',$data);
	}

	public function excel_lap_jasa_irj_tind_detail($tgl,$tgl1,$id_dokter,$id_poli,$cara_bayar)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$data =$this->Rjmlaporan->get_data_qty_tind_jasa_rajal_new($tgl,$tgl1,$id_dokter,$id_poli,$cara_bayar)->result();
		
		$sheet->setCellValue('A1', 'LAPORAN JASA RAWAT JALAN'.' '.$tgl.' '.'sampai'.' '.$tgl1);

		
		$sheet->setCellValue('A3', 'Tgl Masuk');
		$sheet->setCellValue('B3', 'Tgl keluar');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'No RM');
		$sheet->setCellValue('E3', 'No Register');
		$sheet->setCellValue('F3', 'No SEP');
		$sheet->setCellValue('G3', 'Dokter');
		$sheet->setCellValue('H3', 'Poli');
		$sheet->setCellValue('I3', 'Jenis');
		$sheet->setCellValue('J3', 'Tindakan');
		$sheet->setCellValue('K3', 'Qty');
		$sheet->setCellValue('L3', 'Biaya');
		$sheet->setCellValue('M3', 'Pelaksana');
	

		$x = 4;
		foreach($data as $val){
			
			$sheet->setCellValue('A'.$x, date('d-m-Y',strtotime($val->tgl_masuk)));
			$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($val->tgl_keluar)));
			$sheet->setCellValue('C'.$x, $val->nama);
			$sheet->setCellValue('D'.$x, $val->no_cm);
			$sheet->setCellValue('E'.$x, $val->no_register);
			$sheet->setCellValue('F'.$x, $val->no_sep);
			$sheet->setCellValue('G'.$x, $val->dpjp);
			$sheet->setCellValue('H'.$x, $val->ruang);
			$sheet->setCellValue('I'.$x, $val->jenis);
			$sheet->setCellValue('J'.$x, $val->nama_tindakan);
			$sheet->setCellValue('K'.$x, $val->qty_tindakan);
			$sheet->setCellValue('L'.$x, $val->harga_tindakan);
			$sheet->setCellValue('M'.$x, $val->pelaksana);
			
			 
			$x++;
		}
	
	

		$writer = new Xlsx($spreadsheet);
		
		$filename = 'Laporan Jasa Rawat Jalan';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lapkeu_jasa_tind_ranap()
	{
		// var_dump($this->input->post('id_ruang'));die();
	
		$data['title']='Laporan Jasa Instalasi Tindakan Rawat Inap';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['id_dokter'] = $this->input->post('id_dokter');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['id_ruang'] = $this->input->post('id_ruang');
		$data['data_dokter'] = $this->Rjmlaporan->get_data_dokter_dpjp()->result();	
		$data['ruangan'] = $this->Rjmlaporan->get_data_ruangan()->result();	
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_tind']=$this->Rjmlaporan->geta_data_detail_tind_jasa_ranap_new($data['tgl'],$data['tgl1'],$data['id_dokter'],$data['cara_bayar'],$data['id_ruang'])->result();
			// $data['data_detail_tind']=$this->Rjmlaporan->geta_data_detail_tind_jasa_ranap($data['tgl'],$data['tgl1'])->result();	
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_tind']=array();
			$data['data_detail_tind']=array();
		}

		$this->load->view('irj/rjvlapjasa_tind_ri',$data);
	}

	public function excel_lap_jasa_iri_tind_detail($tgl,$tgl1,$id_dokter,$cara_bayar,$id_ruang)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$data =$this->Rjmlaporan->geta_data_detail_tind_jasa_ranap_new($tgl,$tgl1,$id_dokter,$cara_bayar,$id_ruang)->result();
		
		$sheet->setCellValue('A1', 'LAPORAN JASA RAWAT INAP'.' '.$tgl.' '.'sampai'.' '.$tgl1);

		
		$sheet->setCellValue('A3', 'Tgl Masuk');
		$sheet->setCellValue('B3', 'Tgl keluar');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'No RM');
		$sheet->setCellValue('E3', 'No Register');
		$sheet->setCellValue('F3', 'No SEP');
		$sheet->setCellValue('G3', 'DPJP');
		$sheet->setCellValue('H3', 'Ruang');
		$sheet->setCellValue('I3', 'Jenis');
		$sheet->setCellValue('J3', 'Tindakan');
		$sheet->setCellValue('K3', 'Qty');
		$sheet->setCellValue('L3', 'Biaya');
		$sheet->setCellValue('M3', 'Pelaksana');
	

		$x = 4;
		foreach($data as $val){
			
			$sheet->setCellValue('A'.$x, date('d-m-Y',strtotime($val->tgl_masuk)));
			$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($val->tgl_keluar)));
			$sheet->setCellValue('C'.$x, $val->nama);
			$sheet->setCellValue('D'.$x, $val->no_cm);
			$sheet->setCellValue('E'.$x, $val->no_ipd);
			$sheet->setCellValue('F'.$x, $val->no_sep);
			$sheet->setCellValue('G'.$x, $val->dpjp);
			$sheet->setCellValue('H'.$x, $val->ruang);
			$sheet->setCellValue('I'.$x, $val->jenis);
			$sheet->setCellValue('J'.$x, $val->nama_tindakan);
			$sheet->setCellValue('K'.$x, $val->qty_tindakan);
			$sheet->setCellValue('L'.$x, $val->harga_tindakan);
			$sheet->setCellValue('M'.$x, $val->pelaksana);
			
			 
			$x++;
		}
	
	

		$writer = new Xlsx($spreadsheet);
		
		$filename = 'Laporan Jasa Rawat Inap';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_keu_lab($tgl,$tgl1,$carabayar,$pelayanan) {
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		if ($pelayanan != 'SEMUA' && $carabayar !='SEMUA') {
			$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_lab($tgl,$tgl1,$pelayanan,$carabayar)->result();
		}else if($pelayanan == 'SEMUA' && $carabayar !='SEMUA'){	
			$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_lab($tgl,$tgl1,$pelayanan,$carabayar)->result();
		}else if($pelayanan != 'SEMUA' && $carabayar =='SEMUA'){
			$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_lab($tgl,$tgl1,$pelayanan,$carabayar)->result();
		}else{
			$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_lab($tgl,$tgl1,$pelayanan,$carabayar)->result();
		}
				
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tgl Kunjungan');
		$sheet->setCellValue('C1', 'No Medrec');
		$sheet->setCellValue('D1', 'No Register');
		$sheet->setCellValue('E1', 'Nama');
		$sheet->setCellValue('F1', 'Ruang');
		$sheet->setCellValue('G1', 'Jenis Tindakan');
		$sheet->setCellValue('H1', 'Biaya');
		
	
		$no = 1;
		$x = 2;
				
		foreach($data_laporan_keu as $value){
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $value->tgl_kunjungan);
			$sheet->setCellValue('C'.$x, $value->no_cm);
			$sheet->setCellValue('D'.$x, $value->no_register);
			$sheet->setCellValue('E'.$x, $value->nama);
			$sheet->setCellValue('F'.$x, $value->ruang);
			$sheet->setCellValue('G'.$x, $value->jenis_tindakan);
			$sheet->setCellValue('H'.$x, $value->vtot);
		
			$x++;
		}	
														
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pendapatan Laboratorium';
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_per_item_obat()
	{
	
		$data['title']='Laporan Per Item Obat';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['id_obat'] = $this->input->post('id_obat');
		$data['data_obat'] = $this->Rjmlaporan->get_data_obat()->result();	
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_item']=$this->Rjmlaporan->get_data_obat_peritem($data['tgl'],$data['tgl1'],$data['id_obat'])->result();
		
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_item']=array();
		}

		$this->load->view('irj/rjvlapobat',$data);
	}

	public function lap_per_item_obat_ranap()
	{
	
		$data['title']='Laporan Per Item Obat Rawat Inap';
		$dateRange = $this->input->post('tanggal_laporan');
		$data['id_obat'] = $this->input->post('id_obat');
		$data['data_obat'] = $this->Rjmlaporan->get_data_obat()->result();	
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_item']=$this->Rjmlaporan->get_data_obat_peritem_ranap($data['tgl'],$data['tgl1'],$data['id_obat'])->result();
		
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_item']=array();
		}

		$this->load->view('irj/rjvlapobatranap',$data);
	}

	public function lap_jam_farmasi()
	{
	
		$data['title']='Laporan Waktu Tunggu Farmasi';
		$dateRange = $this->input->post('tanggal_laporan');	
		if($dateRange){
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['data_item']=$this->Rjmlaporan->get_data_jam_farmasi($data['tgl'],$data['tgl1'])->result();
			$data['data_resep']=$this->Rjmlaporan->get_data_resep_farmasi($data['tgl'],$data['tgl1'])->result();
		
		}else{
			$data['tgl'] = date('Y-m-d');
			$data['tgl1'] = date('Y-m-d');
			$data['data_item']=array();
		}

		$this->load->view('irj/rjvlapwaktufarm',$data);
	}

	public function excel_lap_waktu_tunggu_farmasi($tgl1,$tgl2) {
		// var_dump($tgl1);
		// var_dump($tgl2);
		// die();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal');
		$sheet->setCellValue('C1', 'No RM');
		$sheet->setCellValue('D1', 'No BPJS');
		$sheet->setCellValue('E1', 'No SEP');
		$sheet->setCellValue('F1', 'Nama Pasien');
		$sheet->setCellValue('G1', 'Dokter');
		$sheet->setCellValue('H1', 'Poli');
		$sheet->setCellValue('I1', 'Cara Bayar');
		$sheet->setCellValue('J1', 'Waktu Mulai Resep');
		$sheet->setCellValue('K1', 'Waktu Selesai Resep');
		$sheet->setCellValue('L1', 'Detail Obat');

		$sheet->setCellValue('L2', 'Nama Obat');
		$sheet->setCellValue('M2', 'Qty');
		$sheet->setCellValue('N2', 'Harga');
		$sheet->setCellValue('O2', 'Total');

		

		$data = $this->Rjmlaporan->get_data_jam_farmasi($tgl1,$tgl2)->result();
		$data_resep = $this->Rjmlaporan->get_data_resep_farmasi($tgl1,$tgl2)->result();
	
		$x = 4;
		$i = 1;

		foreach($data as $row) {
			$obat_pasien = array_filter($data_resep, function($resep) use ($row) {
				return $resep->no_register == $row->no_register;
			});
			if(empty($obat_pasien)) {
				$sheet->setCellValue('A'.$x, $i++);
				$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($row->tgl_kunjungan)));
				$sheet->setCellValue('C'.$x, $row->no_cm );
				$sheet->setCellValue('D'.$x, $row->no_kartu );
				$sheet->setCellValue('E'.$x, $row->no_sep );
				$sheet->setCellValue('F'.$x, $row->nama );
				$sheet->setCellValue('G'.$x, $row->dokter );
				$sheet->setCellValue('H'.$x, $row->poli );
				$sheet->setCellValue('I'.$x, $row->cara_bayar );
				$sheet->setCellValue('J'.$x, isset($row->waktu_resep_farmasi)?date('H:i',strtotime($row->waktu_resep_farmasi)):'-');
				$sheet->setCellValue('K'.$x, isset($row->waktu_selesai_farmasi)?date('H:i',strtotime($row->waktu_selesai_farmasi)):'-');;
				$x++;
			} else {
				$first = true;
				foreach($obat_pasien as $resep) {
					if($first) {
						$sheet->setCellValue('A'.$x, $i++);
						$sheet->setCellValue('B'.$x, date('d-m-Y',strtotime($row->tgl_kunjungan)));
						$sheet->setCellValue('C'.$x, $row->no_cm );
						$sheet->setCellValue('D'.$x, $row->no_kartu );
						$sheet->setCellValue('E'.$x, $row->no_sep );
						$sheet->setCellValue('F'.$x, $row->nama );
						$sheet->setCellValue('G'.$x, $row->dokter );
						$sheet->setCellValue('H'.$x, $row->poli );
						$sheet->setCellValue('I'.$x, $row->cara_bayar );
						$sheet->setCellValue('J'.$x, date('H:i',strtotime($row->waktu_resep_farmasi)));
						$sheet->setCellValue('K'.$x, date('H:i',strtotime($row->waktu_selesai_farmasi)));
						$sheet->setCellValue('L'.$x, $resep->nama_obat);
						$sheet->setCellValue('M'.$x, $resep->qty);
						$sheet->setCellValue('N'.$x, $resep->biaya_obat);
						$sheet->setCellValue('O'.$x, $resep->vtot);
						$first = false;
					} else {
						$sheet->setCellValue('L'.$x, $resep->nama_obat);
						$sheet->setCellValue('M'.$x, $resep->qty);
						$sheet->setCellValue('N'.$x, $resep->biaya_obat);
						$sheet->setCellValue('O'.$x, $resep->vtot);
					}
					$x++;
				}
			}
		}


		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Waktu Tunggu Farmasi';
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}

?>
