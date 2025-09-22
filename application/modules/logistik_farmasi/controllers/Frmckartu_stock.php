<?php defined('BASEPATH') OR exit('No direct script access allowed');
//
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//require_once(APPPATH.'controllers/Secure_area.php');
class Frmckartu_stock extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelLaporan','',TRUE);
		$this->load->model('logistik_farmasi/Frmmlaporan','',TRUE);
        $this->load->model('logistik_farmasi/Frmmkartu_stock','',TRUE);
        $this->load->model('farmasi/Frmmdaftar','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
		$this->load->model('logistik_farmasi/Frmmadjustment','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		$data['title'] = 'Kartu Stock Obat';

        $login_data = $this->load->get_var("user_info");
        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
		
        foreach ($id_gudang as $gudang) {
        	$gud = $gudang->id_gudang;
        }
		$data['tgl']=date("Y-m-d");
		$data['tgl1']= date("Y-m-d");
		$data['tgl2']= date("Y-m-d");
		$data['data_stok']=[];
		$data['date_title']='';
		$data['id_gudang'] = '';
		$data['id_obat'] = '';
		$data['tanggal1']= date("Y-m-d");
		$data['tanggal2']= date("Y-m-d");


	    $data['gudang'] = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
		
        if ($this->input->post()) {
			  
			
            $data['gudang'] = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
			$id_gudang = $this->input->post('filter');
			$id_obat = $this->input->post('id_obat');
			$tgl=explode("-", $this->input->post('tanggal_laporan'));
			
			$data['id_gudang'] =$id_gudang;
			$data['id_obat'] =$id_obat;
			$data['tanggal'] =str_replace("/","-",$this->input->post('tanggal_laporan'));
			$data['tgl1']= $tgl[0];
			$data['tgl2']= $tgl[1];
			$data['tanggal1'] = date('Y-m-d',strtotime($data['tgl1']));
			$data['tanggal2'] = date('Y-m-d',strtotime($data['tgl2']));
			
			$data['date_title']='<b>'.date('d/m/Y', strtotime($data['tgl1'])).'-'.date('d/m/Y', strtotime($data['tgl2'])).'</b>';
         
			$data['data_stok']=$this->Frmmkartu_stock->get_data_stock(date('Y-m-d',strtotime($data['tgl1'])), date('Y-m-d',strtotime($data['tgl2'])),$id_gudang,$id_obat)->result();

			
		}
		$data['obat'] = $this->Frmmkartu_stock->get_obat_by_gudang_for_view_stock($gud)->result();
		$this->load->view('logistik_farmasi/Frmvkartu_stock',$data); 
	}		

	function download_kartu_stock($id_gd,$id_obat,$tgl1, $tgl2){
		$data = $this->Frmmkartu_stock->get_data_stock($tgl1,$tgl2,$id_gd,$id_obat)->result();
		//var_dump($data['data_stok']);die();
		$spreadsheet = new Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet(); 

		$sheet->SetCellValue('A1', 'nama obat');
		$sheet->SetCellValue('B1', 'Batch');
		$sheet->SetCellValue('C1', 'Expire Date');
		$sheet->SetCellValue('D1', 'Keterangan');
		$sheet->SetCellValue('E1', 'Stock Awal'); 
		$sheet->SetCellValue('F1', 'Stock Masuk'); 
		$sheet->SetCellValue('G1', 'Stock Keluar'); 
		$sheet->SetCellValue('H1', 'Stock Akhir'); 
		$sheet->SetCellValue('I1', 'Harga Beli'); 
		$sheet->SetCellValue('J1', 'User'); 
	
		$rowCount = 2;
		foreach($data as $row){
		  $sheet->SetCellValue('A'.$rowCount, $row->nm_obat);
		  $sheet->SetCellValue('B'.$rowCount, $row->batch_no);
		  $sheet->SetCellValue('C'.$rowCount, isset($row->expire_date)?date('d-m-Y',strtotime($row->expire_date)):'');
		  $sheet->SetCellValue('D'.$rowCount, $row->keterangan);
		  $sheet->SetCellValue('E'.$rowCount, $row->stok_awal);
		  $sheet->SetCellValue('F'.$rowCount, $row->masuk);
		  $sheet->SetCellValue('G'.$rowCount, $row->keluar);
		  $sheet->SetCellValue('H'.$rowCount, $row->stok_akhir);
		  $sheet->SetCellValue('I'.$rowCount, $row->hargabeli);
		  $sheet->SetCellValue('J'.$rowCount, $row->created_by);
		  $rowCount++;
		}

		//ob_end_clean();
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan '.$tgl1.' - '.$tgl2;
		//ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}


	function cari_data_obat(){
		     $login_data = $this->load->get_var("user_info");
        // $roleid= $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

            $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        // print_r($id_gudang); exit();
           foreach ($id_gudang as $gudang) {
        	# code...
        	$gud = $gudang->id_gudang;
        //	print_r($gud);die();
        }
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
      
            $this->Frmmkartu_stock->autocomplete_obat($q);
            //echo json_encode($q);
        }
    }

	public function download_kartu($param1='',$param2='', $filter='', $obat='', $batch=''){
		////EXCEL 
		/*$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();
		echo "<pre>";
		echo print_r($data_keuangan);
		echo "</pre>";*/

		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RSU SRIWIJAYA")  
		        ->setLastModifiedBy("RSU SRIWIJAYA")  
		        ->setTitle("Kartu Stock RASU SRIWIJAYA")  
		        ->setSubject("Kartu Stock RSU SRIWIJAYA")  
		        ->setDescription("Kartu Stock RSU SRIWIJAYA")  
		        ->setKeywords("RSU SRIWIJAYA")
		        ->setCategory("Kartu Stock RSU SRIWIJAYA");  
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$data_obat=$this->Frmmkartu_stock->get_data_stock($param1, $param2, $filter, $obat, $batch)->result();

		//print_r($data_obat);die();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/kartu_stock.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
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
      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->setAutoFilter('A5:H5');

      	$objPHPExcel->getActiveSheet()->SetCellValue('A1', "RSU Sriwijaya Palembang");
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Kartu Stock Obat Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
       // print_r($data_obat);die();

        foreach($data_obat as $row1){
        	$obat=$row1->nm_obat;
        //	$gudang=$row1->nama_gudang;
        }
        // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "Gudang : ");
        // $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
        // $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
        // $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // $objPHPExcel->getActiveSheet()->SetCellValue('A4', "Obat   : ".$obat);
        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
        // $objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		$rowCount = 6;
		$temp = "";
		$i=1;

		foreach($data_obat as $row){

				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tanggal);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nm_obat);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->keterangan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->stok_awal);
				if ($row->pembelian != 0){
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->pembelian);
				}else if($row->distribusi!= 0 AND $row->keterangan!="Batal Distribusi"){
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->distribusi);
				}else if($row->distribusi!= 0 AND $row->keterangan=="Batal Distribusi"){
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->distribusi);
				}else if($row->keterangan=="Adjusment_Tambah"){
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->adjustment);
				}else if($row->keterangan=="Adjusment_Kurang"){
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->adjustment);			
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->penjualan);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->stok_akhir);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->created_by);
				
			
			$i++;
			$rowCount++;
		}
		$filename = "Kartu Stock ".$obat."_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('Kartu Stok Obat');    
		   
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

}
