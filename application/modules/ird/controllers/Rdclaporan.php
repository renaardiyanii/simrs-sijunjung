<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// include(dirname(dirname(__FILE__)).'/Tglindo.php');

// require_once(APPPATH.'controllers/Secure_area.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Rdclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/rdmregistrasi','',TRUE);
		$this->load->model('ird/Rdmpencarian','',TRUE);
		$this->load->model('ird/Rdmpelayanan','',TRUE);
		$this->load->model('ird/Rdmkwitansi','',TRUE);
		$this->load->model('ird/Rdmlaporan','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->helper('pdf_helper');
		
	}
	public function index()
	{
		redirect('ird/Rdcregistrasi','refresh');
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

		$data['list_ird'] = $this->Rdmlaporan->get_pendapatan_perpoli($tgl_awal_gabung,$tgl_akhir_gabung);
		$this->load->view('ird/list_pendapatan_kasir',$data);
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

		$data['list_ird'] = $this->Rdmlaporan->get_rekap_harian_kasir($tgl_awal_gabung,$tgl_akhir_gabung,$this->session->userdata("userid"));
		$this->load->view('ird/list_rekap_loket_kasir',$data);
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
		$list_keluar_ird = $this->Rdmlaporan->get_pendapatan_perpoli($tgl_awal,$tgl_akhir);
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
      foreach ($list_keluar_ird as $r) {
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
		$list_keluar_ird = $this->Rdmlaporan->get_rekap_harian_kasir($tgl_awal,$tgl_akhir,$userid);
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
      foreach ($list_keluar_ird as $r) {
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
			
		$data['msk_iri1']=$this->Rdmlaporan->get_data_iri_masuk_lt1($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_iri2']=$this->Rdmlaporan->get_data_iri_masuk_lt2($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_iri3']=$this->Rdmlaporan->get_data_iri_masuk_lt3($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri1']=$this->Rdmlaporan->get_data_iri_keluar_lt1($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri2']=$this->Rdmlaporan->get_data_iri_keluar_lt2($data['date_awal'],$data['date_akhir'])->result();
		$data['klr_iri3']=$this->Rdmlaporan->get_data_iri_keluar_lt3($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_ird']=$this->Rdmlaporan->get_data_ird_masuk($data['date_awal'],$data['date_akhir'])->result();
		$data['msk_ird']=$this->Rdmlaporan->get_data_ird_masuk($data['date_awal'],$data['date_akhir'])->result();
		$this->load->view('ird/lap_kunj_pasien',$data);			
		
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
			
		$data['all']=$this->Rdmlaporan->get_data_kunj_all($data['date_awal'],$data['date_akhir'])->result();		
		$this->load->view('ird/lap_kunj_pasien_all',$data);			
		
	}

    public function lap_kunj_pasien_detail() {
		$data['title'] = '';
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
		if($tipe_input == ''){
		$tgl_awal = date("Y-m-d");
		$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->Rdmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

			//  $data['tgl_awal_show'] = "";
			//  $data['tgl_akhir_show'] = "";
			//  $data['user_show'] = "";

		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rdmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

			//   $this->load->view('ird/rdvlink');
		$this->load->view('ird/list_kunj_pasien_detail',$data);
      
		}

		if($tipe_input == 'TGL'){

		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['data_kunjungan']=$this->Rdmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

		//   $this->load->view('ird/rdvlink');
		$this->load->view('ird/list_kunj_pasien_detail',$data);
		
		}

  }

	public function lapkunjungan()
	{
		$data['title']='Laporan Kunjungan Pasien';

		$data['kontraktorbpjs']=$this->rdmregistrasi->get_kontraktor_bpjs('BPJS')->result();
		//$tgl_indo = new Tglindo();
		$data['space']="";
		$data['cara_bayar']="SEMUA";
		$data['kontraktorcari']='';
		$result=$this->Rdmlaporan->get_data_kunj_poli_harian(date('Y-m-d'),$data['cara_bayar'],'')->row();

		if($result != null){
			
			$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();
			// var_dump($data['data_laporan_kunj']);
			// die();
			
			$tgl_lahir = $this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
			$tahun_tgl_lahir = substr($tgl_lahir,0,4);
			$tahun_sekarang = date('Y');
			$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
			$data['tgl_lahir'] = $pengurangan; 
			//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
			$tgl = date("d m Y");
			$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
			$data['tampil_per']="TGL";
			
			$data['tgl']=date("Y-m-d");
			$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";

			$data['data_lap'] = "Ada";
			
		}else{
			$data['data_lap'] = "Kosong";
			$tgl = date("d m Y");
			$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
			$data['tampil_per']="TGL";
			
			$data['tgl']=date("Y-m-d");
			$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['id_poli']="SEMUA";
			$data['id_dokter']="SEMUA";
			$data['data_laporan_kunj']= array();
		}
		
		// var_dump($data['data_laporan_kunj']);die();
		$this->load->view('ird/rdvlapkunjungan',$data);
	}
	
	public function data_kunjungan()
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data['title']="Laporan Kunjungan Pasien";
			$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['space']="";
			$data['kontraktorbpjs']=$this->rdmregistrasi->get_kontraktor_bpjs('BPJS')->result();
			$data['tampil_per']=$this->input->post('tampil_per');
			$data['kontraktorcari']='';
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
				// var_dump($this->input->post('id_dokter'));
				// die();
				
				if ($this->input->post('id_poli')=="SEMUA") {					
					if ($this->input->post('id_dokter')=="SEMUA") {
						$result=$this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();
						if ($result != null) {
							$data['data_lap'] = "Ada";
							$data['id_poli']="SEMUA";
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();
							
						
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;	
						}else{
							$data['data_lap'] = "Kosong";
							$data['id_poli']="SEMUA";
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();					
							$data['data_laporan_kunj']=array();
						}	
					}else{
						echo "Data Kosong";
					}
																
				} else {
					if ($this->input->post('id_dokter')=="SEMUA") {
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$result=$this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();


							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $this->input->post('id_poli'));
							
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}else{
						$select = explode("@", $this->input->post('id_poli'));
						$select_id_poli=$select[0];
						$select_dokter = $this->input->post('id_dokter');
						$result=$this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->result();


							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $this->input->post('id_poli'));
							$data['id_poli']=$select_poli[0];
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
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_bulanan($data['bulan'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_bulanan($data['bulan'],$data['id_poli'])->result();
				}
			
			} else if ($data['tampil_per'] == "THN") {
					
				//date title
				$data['tahun']=$this->input->post('tahun');
				$data['date_title']='<b>('.$data['tahun'].')</b>';
				//----------
				$data['cara_bayar']='';
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_tahunan($data['tahun'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_tahunan($data['tahun'],$data['id_poli'])->result();
				}
			
			} else {
				$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();
				// var_dump($data['data_laporan_kunj']);
				// die();
				
				$tgl_lahir = $this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
				$tahun_tgl_lahir = substr($tgl_lahir,0,4);
				$tahun_sekarang = date('Y');
				$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
				$data['tgl_lahir'] = $pengurangan; 
				//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
				$tgl = date("d m Y");
				$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				$data['tampil_per']="TGL";
				
				$data['tgl']=date("Y-m-d");
				$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
				$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
				$data['id_poli']="SEMUA";

				$data['data_lap'] = "Ada";
			}
			
			$this->load->view('ird/rdvlapkunjungan',$data);
		}else{
			redirect('ird/Rdclaporan/rdvlapkunjungan','refresh');
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////keuangan poli
	public function lapkeu()
	{
		$data['title']='Laporan Keuangan Instalasi Rawat Jalan';
		
		//$tgl_indo = new Tglindo();
		$data['status']="10";
		$data['cara_bayar']="SEMUA";
		$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_poli_harian(date("Y-m-d"),date('Y-m-d', strtotime('-7 days')), $data['status'],$data['cara_bayar'])->result();
		//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
		$tgl = date("d m Y");
		$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
		$data['tampil_per']="TGL";
		$data['tgl']=date("Y-m-d");
		$data['tgl1']=date('Y-m-d', strtotime('-7 days'));
		$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
		$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
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

		$this->load->view('ird/rdvlapkeuangan',$data);
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

				echo '<script type="text/javascript">window.open("'.site_url("ird/rdexcel/excel_lapkeu/$id_poli/$tgl0/$status/$cara_bayar/$tgl1").'", "_blank");window.focus()</script>';
				// /rdcexcel/excel_lapkeu/$id_poli/$tgl/$status/$cara_bayar/$tgl1
			$data['title']="Laporan Keuangan Instalasi Rawat Jalan";
			$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
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
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_poli_harian($data['tgl'], $data['status'],$data['cara_bayar'])->result();	
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_harian($data['tgl'],$data['id_poli'], $data['status'],$data['cara_bayar'])->result();
				}
					
			} else if ($data['tampil_per'] == "BLN") {
					
				//date title
				$data['bulan']=$this->input->post('bulan');
				$bulan = date('m Y', strtotime($data['bulan']));
				$data['date_title']='<b>('.$tgl_indo->bulan(substr($bulan,0,2)).' '.substr($bulan,3,4).')</b>';
				//----------
				
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_poli_bulanan($data['bulan'], $data['status'], $data['cara_bayar'])->result();
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_bulanan($data['bulan'],$data['id_poli'], $data['status'], $data['cara_bayar'])->result();
				}
			
			} else if ($data['tampil_per'] == "THN") {
					
				//date title
				$data['tahun']=$this->input->post('tahun');
				$data['date_title']='<b>('.$data['tahun'].')</b>';
				//----------
				
				if ($this->input->post('id_poli')=="SEMUA") {
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_poli_tahunan($data['tahun'], $data['status'], $data['cara_bayar'])->result();
					
				} else {
					$select_poli = explode("@", $this->input->post('id_poli'));
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_keu']=$this->Rdmlaporan->get_data_keu_tahunan($data['tahun'],$data['id_poli'], $data['status'], $data['cara_bayar'])->result();
				}
			
			}
			
			$this->load->view('ird/rdvlapkeuangan',$data);
		}else{
			redirect('ird/Rdclaporan/rdvlapkeuangan','refresh');
		}
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////pendapatan dokter
	public function lapkeu_dokter()
	{
		$data['title']='Laporan Pendapatan Dokter Instalasi Rawat Jalan';
		// $tgl_indo = new Tglindo();
		$data['id_dokter']='SEMUA';
		$data['cara_bayar']="SEMUA";
		$data['datakeu_dokter']=$this->Rdmlaporan->get_data_keu_dokter($data['id_dokter'], date("Y-m-d"), date("Y-m-d"), $data['cara_bayar'])->result();
		$data['select_dokter']=$this->Rdmpencarian->get_dokter()->result();
		$data['dokter']=$this->Rdmpencarian->get_dokter()->result();
		$tgl=date("d m Y");
		$data['date_title']='Hari ini <b>('.substr($tgl,0,2).' '.substr($tgl,3,2).' '.substr($tgl,6,4).')</b>';
		$data['tgl_awal']=date("Y-m-d");
		$data['tgl_akhir']=date("Y-m-d");
		$this->load->view('ird/rdvlapkeuangandokter',$data);
	}
	public function datakeu_dokter()
	{
		// $tgl_indo = new Tglindo();
		$data['title']='Laporan Pendapatan Dokter Instalasi Rawat Jalan';
		$data['dokter']=$this->Rdmpencarian->get_dokter()->result();
		$data['select_dokter']=$this->Rdmpencarian->get_dokter()->result();
		
		$data['id_dokter']=$this->input->post('id_dokter');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$data['tgl_awal']=$this->input->post('tgl_awal');
			$tgl_awal1 = date('d m Y', strtotime($data['tgl_awal']));
			$data['tgl_akhir']=$this->input->post('tgl_akhir');
			$tgl_akhir1 = date('d m Y', strtotime($data['tgl_akhir']));
			
			if($data['tgl_awal']!=$data['tgl_akhir']){
				$tgl_indo1=substr($tgl_awal1,0,2).' '.substr($tgl_awal1,3,2).' '.substr($tgl_awal1,6,4);
				$tgl_indo2=substr($tgl_akhir1,0,2).' '.substr($tgl_akhir1,3,2).' '.substr($tgl_akhir1,6,4);
				$data['date_title']='<b>('.$tgl_indo1.' s/d '.$tgl_indo2.')</b>';
			}else{
				$data['date_title']='<b>('.substr($tgl_awal1,0,2).' '.substr($tgl_awal1,3,2).' '.substr($tgl_awal1,6,4).')</b>';
		
			}
			if ($data['id_dokter']!='SEMUA') {
				$dokter = explode("@", $data['id_dokter']);
				$data['id_dokter']=$dokter[0];
				$data['nm_dokter']=$dokter[1];
			}else{
				$data['dokter']=$this->Rdmlaporan->get_data_keu_det_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $data['cara_bayar'])->result();
			}
			
			$data['datakeu_dokter']=$this->Rdmlaporan->get_data_keu_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $data['cara_bayar'])->result();
			//print_r($data['datakeu_dokter']);
			$this->load->view('ird/rdvlapkeuangandokter',$data);
		}else{
			redirect('ird/Rdclaporan/lapkeu_dokter','refresh');
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
			$data_user=$this->Rdmlaporan->get_data_iri_masuk_lt1($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskiri2'){
			$data_user=$this->Rdmlaporan->get_data_iri_masuk_lt2($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskiri3'){
			$data_user=$this->Rdmlaporan->get_data_iri_masuk_lt3($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskird'){
			$data_user=$this->Rdmlaporan->get_data_ird_masuk($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='mskird'){
			$data_user=$this->Rdmlaporan->get_data_ird_masuk($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri1'){
			$data_user=$this->Rdmlaporan->get_data_iri_keluar_lt1($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri2'){
			$data_user=$this->Rdmlaporan->get_data_iri_keluar_lt2($tgl_awal,$tgl_akhir)->result();
		}
		else if($tipe=='klriri3'){
			$data_user=$this->Rdmlaporan->get_data_iri_keluar_lt3($tgl_awal,$tgl_akhir)->result();
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
					
		$data_user=$this->Rdmlaporan->get_data_kunj_all($tgl_awal,$tgl_akhir)->result();		
		
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
					$vtot3=$vtot3+$row->ird;
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
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->ird);
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
			$data=$this->Rdmlaporan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			echo "<option value='SEMUA'>SEMUA</option> ";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
		}
		
	}


	public function lap_dig_kasus_jenkel()
	{		
		$data['title']='Laporan Poliklinik Berdasarkan Diagnosa Kasus Jenis Kelamin';

		$tgl = $this->input->post('tgl');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$lap_per = $this->input->post('tampil_per');

		if ($lap_per == '') {
			$data['diagnosa']=$this->Rdmlaporan->get_diagnosa('','')->result();
		
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
			if ($lap_per == 'TGL') {
				$valid=$this->Rdmlaporan->get_diagnosa($tgl,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rdmlaporan->get_diagnosa($tgl,$lap_per)->result();				
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
				$valid=$this->Rdmlaporan->get_diagnosa($bulan,$lap_per)->row();

				if ($valid != null) {
					$data['diagnosa']=$this->Rdmlaporan->get_diagnosa($bulan,$lap_per)->result();
			
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
				$valid=$this->Rdmlaporan->get_diagnosa($tahun,$lap_per)->row();

				if ($valid != null) {

					$data['diagnosa']=$this->Rdmlaporan->get_diagnosa($tahun,$lap_per)->result();
			
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
				$data['diagnosa']=$this->Rdmlaporan->get_diagnosa('','')->result();
		
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
			}	
		}
				

		
		$this->load->view('ird/rdvlapdigkasusjenkel',$data);
		
	}

	public function pdf_lap_kunj_ird($tampil_per='', $id_poli='',$tgl='',$cara_bayar='',$id_dokter = '')
	{
		
			$data['title']="Laporan Kunjungan Pasien";
			$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
			$data['space']="";
			$data['kontraktorbpjs']=$this->rdmregistrasi->get_kontraktor_bpjs('BPJS')->result();
			$data['tampil_per']=$tampil_per;
			$data['kontraktorcari']='';

			if ($data['tampil_per'] == "TGL") {
									
				//date title
				$data['tgl']=$tgl;
				
				$data['cara_bayar']=$cara_bayar;				
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
				// var_dump($this->input->post('id_dokter'));
				// die();
				
				if ($id_poli=="SEMUA") {					
					if ($id_dokter=="SEMUA") {
						$result=$this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();
						if ($result != null) {
							$data['data_lap'] = "Ada";
							$data['id_poli']="SEMUA";
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();
							
						
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;	
						}else{
							$data['data_lap'] = "Kosong";
							$data['id_poli']="SEMUA";
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();					
							$data['data_laporan_kunj']=array();
						}	
					}else{
						echo "Data Kosong";
					}
																
				} else {
					if ($id_dokter=="SEMUA") {
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$result=$this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();


							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_harian($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}else{
						$select = explode("@", $id_poli);
						$select_id_poli=$select[0];
						$select_dokter = $id_dokter;
						$result=$this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$select_id_poli,$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row();

						if($result != null){
							$data['data_lap'] = "Ada";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->result();


							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();	
							$waktu_masuk_poli = $this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->waktu_masuk_poli;					
							$bulan_masuk_poli = substr($waktu_masuk_poli,5,2);
							$data['waktu_masuk_poli'] = date('F', mktime(0, 0, 0, $bulan_masuk_poli, 10));
							
							$tgl_lahir = $this->Rdmlaporan->get_data_kunj_harian_dokter($data['tgl'],$data['id_poli'],$data['cara_bayar'],$this->input->post('bpjs_bayar'),$select_dokter)->row()->tgl_lahir;
							$tahun_tgl_lahir = substr($tgl_lahir,0,4);
							$tahun_sekarang = date('Y');
							$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
							$data['tgl_lahir'] = $pengurangan;
						}else{			
							
							$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();				
							$data['data_lap'] = "Kosong";
							$select_poli = explode("@", $id_poli);
							$data['id_poli']=$select_poli[0];
							$data['nm_poli']='<b>'.$select_poli[1].'</b>';
							$data['data_laporan_kunj']=array();
						}
					}										
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		
				$html = $this->load->view('ird/pdf/rdvlapkunjungan_harian',$data,true);
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
				if ($id_poli=="SEMUA") {
					$data['id_poli']="SEMUA";
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_bulanan($data['bulan'])->result();
					
				} else {
					$select_poli = explode("@", $id_poli);
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_bulanan($data['bulan'],$data['id_poli'])->result();
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		
				$html = $this->load->view('ird/pdf/rdvlapkunjungan_bulanan',$data,true);
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
					$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
					$data['id_poli']="SEMUA";
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_tahunan($data['tahun'])->result();
					
				} else {
					$select_poli = explode("@", $id_poli);
					$data['id_poli']=$select_poli[0];
					$data['nm_poli']='<b>'.$select_poli[1].'</b>';
					$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_tahunan($data['tahun'],$data['id_poli'])->result();
				}
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		
				$html = $this->load->view('ird/pdf/rdvlapkunjungan_tahunan',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			} else {
				$data['data_laporan_kunj']=$this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();
				// var_dump($data['data_laporan_kunj']);
				// die();
				
				$tgl_lahir = $this->Rdmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->row()->tgl_lahir;
				$tahun_tgl_lahir = substr($tgl_lahir,0,4);
				$tahun_sekarang = date('Y');
				$pengurangan = (int)$tahun_sekarang - (int)$tahun_tgl_lahir;
				$data['tgl_lahir'] = $pengurangan; 
				//$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
				$tgl = date("d m Y");
				$data['date_title']='Hari ini <b>('.substr($tgl,0,2).'  '.substr($tgl,6,4).')</b>';
				$data['tampil_per']="TGL";
				
				$data['tgl']=date("Y-m-d");
				$data['select_poli']=$this->Rdmpencarian->get_poliklinik()->result();
				$data['poli']=$this->Rdmpencarian->get_poliklinik()->result();
				$data['id_poli']="SEMUA";

				$data['data_lap'] = "Ada";

				$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
				$mpdf->curlAllowUnsafeSslRequests = true;		
				$html = $this->load->view('ird/pdf/rdvlapkunjungan_harian',$data,true);
				//$this->mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
				$mpdf->Output();
			}
			


			// $this->load->view('ird/rdvlapkunjungan',$data);
		
	}

	public function lap_kunj_pasien_igd() {
		$tipe_input = $this->input->post('tampil_per');
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
	   
		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == 'TGL'){
			$data['title'] = 'Laporan Kunjungan IRD '.date("d F Y", strtotime($date));
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->Rdmlaporan->get_kunj_pasien_detail_igd($tipe_input, $date)->result_array();
			$data['data_kunjungan_tind'] = $this->Rdmlaporan->get_kunj_pasien_detail_igd_tind($tipe_input, $date)->result_array();
			
			$this->load->view('ird/lap_kunj_igd',$data);
		} else if($tipe_input == 'BLN') {
			$data['title'] = 'Laporan Kunjungan IRD '.date("F Y", strtotime($month));
			$data['date_title'] = date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan']=$this->Rdmlaporan->get_kunj_pasien_detail_igd($tipe_input, $month)->result_array();
			$data['data_kunjungan_tind'] = $this->Rdmlaporan->get_kunj_pasien_detail_igd_tind($tipe_input, $date)->result_array();
	
			$this->load->view('ird/lap_kunj_igd',$data);
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Kunjungan IRD '.date("d F Y", strtotime($tgl));
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->Rdmlaporan->get_kunj_pasien_detail_igd('TGL', $tgl)->result_array();
			$data['data_kunjungan_tind'] = $this->Rdmlaporan->get_kunj_pasien_detail_igd_tind('TGL', $tgl)->result_array();
			
			$this->load->view('ird/lap_kunj_igd',$data);
		}
	}
	
	public function excel_lap_igd($tampil, $date) {
		$data=$this->Rdmlaporan->get_kunj_pasien_detail_igd($tampil, $date)->result();
		$data_tind = $this->Rdmlaporan->get_kunj_pasien_detail_igd_tind($tampil, $date)->result();

		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}
		           
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
			
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No RM');
		$sheet->setCellValue('C1', 'Jenis Pasien');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Umur');
		$sheet->setCellValue('F1', 'Jenis Kelamin');
		$sheet->setCellValue('G1', 'Jaminan');
		$sheet->setCellValue('H1', 'Alamat');
		$sheet->setCellValue('I1', 'Diagnosa');
		$sheet->setCellValue('J1', 'ICD - 10');
		$sheet->setCellValue('K1', 'Dokter');
		$sheet->setCellValue('L1', 'Waktu Masuk');
		$sheet->setCellValue('M1', 'Waktu Keluar');
		$sheet->setCellValue('N1', 'Ket Pulang');
		$sheet->setCellValue('O1', 'LOS IGD');
		$sheet->setCellValue('P1', 'Tindakan');
	
		$no = 1;
		$x = 2;
			
		foreach($data as $row){
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_cm);
			$sheet->setCellValue('C'.$x, $row->jns_kunj);
			$sheet->setCellValue('D'.$x, strtoupper($row->nama));
			$sheet->setCellValue('E'.$x, (int)date('Y') - (int)date('Y',strtotime($row->tgl_lahir)));
			$sheet->setCellValue('F'.$x, $row->jenis_kelamin);
			if($row->cara_bayar == 'KERJASAMA'){
				$bayar = $row->nmkontraktor;
			}else{
				$bayar = $row->cara_bayar;
			}
			$sheet->setCellValue('G'.$x, $bayar);
			$sheet->setCellValue('H'.$x, $row->alamat);
			$sheet->setCellValue('I'.$x, $row->nama_diagnosa);
			$sheet->setCellValue('J'.$x, $row->id_diagnosa);
			$sheet->setCellValue('K'.$x, $row->nama_dokter);
			$sheet->setCellValue('L'.$x, $row->jam);
			$sheet->setCellValue('M'.$x, isset($row->waktu_pulang)?date('H:i:s',strtotime($row->waktu_pulang)):'');
			$sheet->setCellValue('N'.$x, $row->ket_pulang);
			date_default_timezone_set('Asia/Jakarta');
			if($row->tgl_daftar != null && $row->waktu_pulang != null){
				$waktu_masuk = date("H:i:s", strtotime($row->tgl_daftar));
				$waktu_keluar = date("H:i:s", strtotime($row->waktu_pulang));
				$datetime1 = new DateTime($waktu_masuk);//start time
				$datetime2 = new DateTime($waktu_keluar);//end time
				$interval = $datetime1->diff($datetime2);
				$los_igd =  date('H:i:s', strtotime($interval->h.':'.$interval->i.':'.$interval->s));
			}else{
				$los_igd =  '';
			}		
			$sheet->setCellValue('O'.$x,$los_igd );

				foreach($data_tind as $key=>$val) {
					if($val->no_register == $row->no_register) {
						$sheet->setCellValue('P'.$x, '- '.$val->nmtindakan);
						$x++;
					}
				}
				$x++;
		} 
								
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kunjungan IRD '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');  
	}
}
?>