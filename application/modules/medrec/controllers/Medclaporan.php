<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
// include(dirname(dirname(__FILE__)).'/Tglindo.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class Medclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		// $this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('medrec/MinmedIRILaporan','',TRUE);
		$this->load->model('medrec/Medmlaporan','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index(){
		// redirect('lab/Labcdaftar','refresh');

	}

	public function diag_rj(){
		
		$data['title'] = 'Laporan Diagnosa Rawat Jalan';				
		// var_dump($this->input->post('nama_poli'));
		// die();
		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Diagnosa.
			</h4>							
			</div>
		</div>";
		$data['select_poli']=$this->Medmlaporan->get_poliklinik()->result();
		if ($this->input->post('tanggal_laporan') == null && $this->input->post('nama_poli') == null) {
			$data['data_diag']=$this->Medmlaporan->get_data_diag_rj_max('-','-','-')->result();
		}else{
			$tgl = explode(" - ", $this->input->post('tanggal_laporan'));
			$tgl_awal=date('Y-m-d', strtotime($tgl[0]));
			$tgl_akhir=date('Y-m-d', strtotime($tgl[1]));
			$poli=$this->input->post('nama_poli');

			$data['data_diag']=$this->Medmlaporan->get_data_diag_rj_max($tgl_awal,$tgl_akhir,$poli)->result();									
		}
		
		// var_dump($data['data_diag']);
		// die();
		$this->load->view('medrec/vdiag_rj',$data);
	}

	public function diag_ri($tampil_per='', $param1=''){
		$data['title'] = 'Laporan Diagnosa Rawat Inap';				

		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Diagnosa.
			</h4>							
			</div>
		</div>";
		$data['select_ruangan']=$this->MinmedIRILaporan->get_ruangan()->result();
		$this->load->view('medrec/vdiag_ri',$data);
	}

	public function rekap_ri($tampil_per='', $param1=''){
		$data['title'] = 'Laporan Rekap Pasien Rawat Inap';				

		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pasien Rawat Inap.
			</h4>							
			</div>
		</div>";
		$data['select_ruangan']=$this->MinmedIRILaporan->get_ruangan()->result();
		$this->load->view('medrec/vrekap_ri',$data);
	}

	public function diag_rd($tampil_per='', $param1=''){
		$data['title'] = 'Laporan Diagnosa Rawat Darurat';			

		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Diagnosa.
			</h4>							
			</div>
		</div>";

		$this->load->view('medrec/vdiag_rd',$data);
	}

	public function sensus_ri(){
		$data['title'] = 'Laporan Sensus Harian Pasien Rawat Inap';				

		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Sensus Harian.
			</h4>							
			</div>
		</div>";
		$data['select_lokasi']=$this->Medmlaporan->get_lokasi()->result();
		$this->load->view('medrec/vsensus_ri',$data);
	}

	public function sensus_rj(){
		$data['title'] = 'Laporan Sensus Harian Pasien Rawat Jalan';				

		// $tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Sensus Harian.
			</h4>							
			</div>
		</div>";
		$data['select_poli']=$this->Medmlaporan->get_poliklinik()->result();
		$this->load->view('medrec/vsensus_rj',$data);
	}

	public function dirujuk_rj(){
		$data['title'] = 'Laporan Pasien Dirujuk Keluar Rawat Jalan';				

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pasien Dirujuk Keluar.
			</h4>							
			</div>
		</div>";

		$this->load->view('medrec/vdirujuk',$data);
	}

	public function proc_rj(){
		$data['title'] = 'Laporan 10 Besar Tindakan ICD 9 Rawat Jalan';				

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan 10 Besar Tindakan ICD 9.
			</h4>							
			</div>
		</div>";

		$this->load->view('medrec/vproc_rj',$data);
	}

	public function proc_rd(){
		$data['title'] = 'Laporan 10 Besar Tindakan ICD 9 Rawat Darurat';				

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan 10 Besar Tindakan ICD 9.
			</h4>							
			</div>
		</div>";

		$this->load->view('medrec/vproc_rd',$data);
	}

	public function proc_ri(){
		$data['title'] = 'Laporan 10 Besar Tindakan ICD 9 Rawat Inap';							

		$tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan 10 Besar Tindakan ICD 9.
			</h4>							
			</div>
		</div>";
		$data['select_ruangan']=$this->MinmedIRILaporan->get_ruangan()->result();
		$this->load->view('medrec/vproc_ri',$data);
	}

	public function chart_rj(){
		$data['title'] = 'Laporan Tindakan Rawat Jalan RS';							

		$tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Tindakan Rawat Jalan RS.
			</h4>							
			</div>
		</div>";
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$this->load->view('medrec/vchart_rj',$data);
	}

	public function chart_ri(){
		$data['title'] = 'Laporan Tindakan Rawat Inap RS';							

		$tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Tindakan Rawat Inap RS.
			</h4>							
			</div>
		</div>";
		$data['select_ruangan']=$this->MinmedIRILaporan->get_ruangan()->result();
		$this->load->view('medrec/vchart_ri',$data);
	}

	public function download_diag_rj2($param1='',$param2='', $id_poli=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$namars=$this->config->item('namars');
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Diagnosa ".$namars)  
		        ->setSubject("Laporan Diagnosa ".$namars." Document")  
		        ->setDescription("Laporan Diagnosa ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Diagnosa");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_diag_rj.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		
		if(empty($id_poli)){
			$nama_poli = "Seluruh Poliklinik";
		}else{
			$nama_poli = $this->Medmlaporan->get_nm_poli($id_poli)->row()->nm_poli;
		}
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $nama_poli);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$data_diagnosa=$this->Medmlaporan->get_data_diag_rj($param1, $param2, $id_poli)->result();

		$rowCount = 12;
		$i=1;
		$totl=0;$totp=0;$totlp=0;$totbaru=0;

		$totusia1=0;
		$totusia2=0;
		$totusia3=0;
		$totusia4=0;
		$totusia5=0;
		$totusia6=0;
		$totusia7=0;
		$totusia8=0;
		$totusia9=0;
		$totusia=0;
        $tni_al_m 	= 0;
        $tni_al_s 	= 0;
        $tni_al_k 	= 0;
        $askes_al 	= 0;
        $tni_n_al_m = 0;
        $tni_n_al_s = 0;
        $tni_n_al_k = 0;
        $askes_n_al = 0;
        $bpjs_n_mil = 0;
        $bpjs_ket 	= 0;
        $kerjasama 	= 0;
        $umum 		= 0;
        $total 		= 0;
		foreach($data_diagnosa as $row){
			$totl+=+$row->L;
			$totp+=+$row->P;
			$totlp+=$row->P+$row->L;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, ($row->L+$row->P));
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$totusia1+=$row->usia1;
			$totusia2+=$row->usia2;
			$totusia3+=$row->usia3;
			$totusia4+=$row->usia4;
			$totusia5+=$row->usia5;
			$totusia6+=$row->usia6;
			$totusia7+=$row->usia7;
			$totusia8+=$row->usia8;
			$totusia9+=$row->usia9;
			$totusia+=$row->tot_usia;
			//usia			
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia8);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia9);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

            $tni_al_m 	+= $row->tni_al_m;
            $tni_al_s 	+= $row->tni_al_s;
            $tni_al_k 	+= $row->tni_al_k;
            $askes_al 	+= $row->askes_al;
            $tni_n_al_m += $row->tni_n_al_m;
            $tni_n_al_s += $row->tni_n_al_s;
            $tni_n_al_k += $row->tni_n_al_k;
            $askes_n_al += $row->askes_n_al;
            $bpjs_n_mil += ($row->pbi+$row->bpjs_kes+$row->pol+$row->pol_k+$row->kjs);
            $bpjs_ket 	+= $row->bpjs_ket;
            $kerjasama 	+= $row->kerjasama;
            $umum 		+= ($row->umum+$row->jam_per+$row->phl);
            $total 		+= $row->tot_stat;


			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->tni_al_m);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->tni_al_s);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->tni_al_k);
            $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->askes_al);
            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->tni_n_al_m);
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tni_n_al_s);
            $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->tni_n_al_k);
            $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->askes_n_al);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, ($row->pbi+$row->bpjs_kes+$row->pol+$row->pol_k+$row->kjs));
            $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->bpjs_ket);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $row->kerjasama);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, ($row->umum+$row->jam_per+$row->phl));
            $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		//total
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $totl);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $totp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $totlp);

		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totusia1);
		//6-11thn
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $totusia2);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totusia3);
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totusia4);
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totusia5);
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totusia6);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totusia7);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totusia8);
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totusia9);
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totusia);

        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $tni_al_m);
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $tni_al_s);
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $tni_al_k);
        $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $askes_al);
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $tni_n_al_m);
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $tni_n_al_s);
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $tni_n_al_k);
        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $askes_n_al);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $bpjs_n_mil);
        $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $bpjs_ket);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $kerjasama);
        $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $umum);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $total);


      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$filename = "Diagnosa RJ ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle($namars);    
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean();  
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
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

	public function download_diag_rj($param1='',$param2='', $id_poli=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Diagnosa ".$namars."")  
		        ->setSubject("Laporan Diagnosa ".$namars." Document")  
		        ->setDescription("Laporan Diagnosa ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Diagnosa");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		if($id_poli == 'BA00'){
			$nama_poli = "POLI UGD";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_igd($param1, $param2)->result();
		}
		else if($id_poli == 'BB00'){
			$nama_poli = "POLI BEDAH UMUM";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_bedah_umum($param1, $param2)->result();
		}
		else if($id_poli == 'BB01'){
			$nama_poli = "POLI BEDAH TULANG";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_bedah_tulang($param1, $param2)->result();
		}
		else if($id_poli == 'BB02'){
			$nama_poli = "POLI BEDAH UROLOGI";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_urologi($param1, $param2)->result();
		}
		else if($id_poli == 'BB03'){
			$nama_poli = "POLI BEDAH PLASTIK";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_plastik($param1, $param2)->result();
		}
		else if($id_poli == 'BB04'){
			$nama_poli = "POLI BEDAH SARAF";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_urologi($param1, $param2)->result();
		}
		else if($id_poli == 'BD00'){
			$nama_poli = "POLI PSIKOLOGI";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_psikologi($param1, $param2)->result();
		}
		else if($id_poli == 'BD01'){
			$nama_poli = "POLI KESEHATAN JIWA";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_kesehatanjiwa($param1, $param2)->result();
		}
		else if($id_poli == 'BE00'){
			$nama_poli = "POLI KEBIDANAN DAN KANDUNGAN";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_kebidanan($param1, $param2)->result();
		}
		else if($id_poli == 'BE01'){
			$nama_poli = "POLI KIA";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_kia($param1, $param2)->result();
		}
		else if($id_poli == 'BE02'){
			$nama_poli = "POLI KB";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_kb($param1, $param2)->result();
		}
		else if($id_poli == 'BF00'){
			$nama_poli = "POLI KULI DAN KELAMIN";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_kulit($param1, $param2)->result();
		}
		else if($id_poli == 'BG00'){
			$nama_poli = "POLI GIGI";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_gigi($param1, $param2)->result();
		}
		else if($id_poli == 'BG01'){
			$nama_poli = "POLI BEDAH MULUT";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_bedahmulut($param1, $param2)->result();
		}
		else if($id_poli == 'BG02'){
			$nama_poli = "POLI GIGI (ORTHODONTI)";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_orthodonti($param1, $param2)->result();
		}
		else if($id_poli == 'BG03'){
			$nama_poli = "POLI GIGI (PERIONDONSI)";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_periodonsi($param1, $param2)->result();
		}
		else if($id_poli == 'BG04'){
			$nama_poli = "POLI GIGI (PROSTHODONTI)";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_prosthodonti($param1, $param2)->result();
		}
		else if($id_poli == 'BH00'){
			$nama_poli = "POLI MATA";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_mata($param1, $param2)->result();
		}
		else if($id_poli == 'BI00'){
			$nama_poli = "POLI THT";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_tht($param1, $param2)->result();
		}
		else if($id_poli == 'BK00'){
			$nama_poli = "POLI REHAB MEDIK";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_rehabmedik($param1, $param2)->result();
		}
		else if($id_poli == 'BL00'){
			$nama_poli = "POLI BAYI";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_bayi($param1, $param2)->result();
		}
		else if($id_poli == 'BQ00'){
			$nama_poli = "POLI PENYAKIT DALAM";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_penyakitdalam($param1, $param2)->result();
		}
		else if($id_poli == 'BQ01'){
			$nama_poli = "POLI PARU PARU";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_paru($param1, $param2)->result();
		}
		else if($id_poli == 'BQ02'){
			$nama_poli = "POLI JANTUNG";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_jantung($param1, $param2)->result();
		}
		else if($id_poli == 'BR00'){
			$nama_poli = "POLI ANAK";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_anak($param1, $param2)->result();
		}
		else if($id_poli == 'BS00'){
			$nama_poli = "POLI SYARAF";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_syaraf($param1, $param2)->result();
		}
		else if($id_poli == 'BW00'){
			$nama_poli = "POLI UMUM";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_umum($param1, $param2)->result();
		}
		else if($id_poli == 'BZ00'){
			$nama_poli = "POLI GIZI";
			$data_diagnosa=$this->Medmlaporan->get_data_poli_gizi($param1, $param2)->result();
		}
		else{
			$nama_poli = "KESELURUHAN POLI";
			$data_diagnosa=$this->Medmlaporan->get_data($param1, $param2)->result();
		}
		
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_diag_rj.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		//MERGE
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
      	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
      	$objPHPExcel->getActiveSheet()->mergeCells('A4:U4');
      	$objPHPExcel->getActiveSheet()->mergeCells('A5:U5');
      	$objPHPExcel->getActiveSheet()->mergeCells('A6:U6');
      	$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
      	$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
      	$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
      	$objPHPExcel->getActiveSheet()->mergeCells('D8:F8');
      	$objPHPExcel->getActiveSheet()->mergeCells('G8:M8');
      	$objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
      	$objPHPExcel->getActiveSheet()->mergeCells('O8:U8');
      	$objPHPExcel->getActiveSheet()->mergeCells('V8:V9');
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $nama_poli);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

		//BOLD
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getFont()->setBold(true);

		//CENTER HORIZONTAL
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//CENTER VERTICAL
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

      	//AUTO SIZE
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$rowCount = 10;
		$i=1;
		foreach($data_diagnosa as $row){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->tot);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia1);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat5);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat6);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->stat7);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->tot_stat);
			
			$rowCount++;
		}
		$filename = "Diagnosa RJ ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_diag_ri3($param1='',$param2='',$lokasi='',$kelas=''){
		echo $param1.', '.$param2.', '.$lokasi.', '.$kelas;
	}

	public function download_diag_ri2($param1='',$param2='',$lokasi='',$kelas=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Diagnosa ".$namars."")  
		        ->setSubject("Laporan Diagnosa ".$namars." Document")  
		        ->setDescription("Laporan Diagnosa ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Diagnosa");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_diag_ri.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		$lokasi = str_replace('%20', ' ', $lokasi);
		
		if(empty($lokasi)){
			$nama_ruang = "Seluruh Ruangan";
		}else{
			$nama_ruang = $lokasi;
		}
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $nama_ruang);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));


		$data_diagnosa=$this->Medmlaporan->get_data_diag_ri($param1, $param2, $lokasi)->result();

		$rowCount = 10;
		$i=1;
		foreach($data_diagnosa as $row){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->diagnosa1);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pulang_1);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->pulang_2);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->pulang_3);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia1);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->usia8);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->usia9);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('R'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->stat5);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->stat6);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->stat7);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

      	//AUTO SIZE
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);

		$filename = "Diagnosa RI ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_diag_ri($param1='',$param2='',$lokasi='',$kelas=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');  
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Diagnosa ".$namars."")  
		        ->setSubject("Laporan Diagnosa ".$namars." Document")  
		        ->setDescription("Laporan Diagnosa ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Diagnosa");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		if($lokasi == 'Anyelir'){
		
		 	$nama_ruang = "Ruangan Anyelir ";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_anyelir($param1, $param2)->result();
		 }

		 else if($lokasi == 'Bougenvile'){
		 	$nama_ruang = "Ruangan Bougenvile";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_bougenvile($param1, $param2)->result();
		 }
		 else if($lokasi == 'Cempaka Atas'){
		 	$nama_ruang = "Ruangan Cempaka Atas Kelas";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_cempakaatas($param1, $param2)->result();
		 }
		 else if($lokasi == 'Cempaka Bawah'){
		 	$nama_ruang = "Ruangan Cempaka Bawah";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_cempakabawah($param1, $param2)->result();
		 }
		 else if($lokasi == 'Dahlia Atas'){
		 	$nama_ruang = "Ruangan Dahlia Atas";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_dahliaatas($param1, $param2)->result();
		 }
		 else if($lokasi == 'Dahlia Bawah'){
		 	$nama_ruang = "Ruangan Dahlia Atas";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_dahliabawah($param1, $param2)->result();
		 }
		 else if($lokasi == 'Edelweis'){
		 	$nama_ruang = "Ruangan Edelweis";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_edelweis($param1, $param2)->result();
		 }
		  else if($lokasi == 'Flamboyan Atas'){
		 	$nama_ruang = "Ruangan Flambpoyan Atas";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_flamboyanatas($param1, $param2)->result();
		 }
		  else if($lokasi == 'Flamboyan Bawah'){
		 	$nama_ruang = "Ruangan Flamboyan Bawah";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_flamboyanbawah($param1, $param2)->result();
		 }
		 else if($lokasi == 'Gardenia'){
		 	$nama_ruang = "Ruangan Gardenia";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_gardenia($param1, $param2)->result();
		 }
		 else if($lokasi == 'Ruang ICU'){
		 	$nama_ruang = "Ruangan ICU";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_icu($param1, $param2)->result();
		 }
		 else if($lokasi == 'Ruang Bayi'){
		 	$nama_ruang = "Ruangan Bayi";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data_diagnosa_bayi($param1, $param2)->result();
		 }
		 else {
		 	$nama_ruang = "";
		 	$data_diagnosa=$this->MinmedIRILaporan->get_data($param1, $param2)->result();
		 }
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_diag_ri.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		//MERGE
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
      	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
      	$objPHPExcel->getActiveSheet()->mergeCells('A4:U4');
      	$objPHPExcel->getActiveSheet()->mergeCells('A5:U5');
      	$objPHPExcel->getActiveSheet()->mergeCells('A6:U6');
      	$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
      	$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
      	$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
      	$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
      	$objPHPExcel->getActiveSheet()->mergeCells('E8:F8');
      	$objPHPExcel->getActiveSheet()->mergeCells('G8:H8');
      	$objPHPExcel->getActiveSheet()->mergeCells('I8:I9');
      	$objPHPExcel->getActiveSheet()->mergeCells('J8:P8');
      	$objPHPExcel->getActiveSheet()->mergeCells('Q8:Q9');
      	$objPHPExcel->getActiveSheet()->mergeCells('R8:X8');
      	$objPHPExcel->getActiveSheet()->mergeCells('Y8:Y9');
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $nama_ruang);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

		//BOLD
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getFont()->setBold(true);

		//CENTER HORIZONTAL
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//CENTER VERTICAL
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('C8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('G8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('N8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('O8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('V8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

      	//AUTO SIZE
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$rowCount = 10;
		$i=1;
		foreach($data_diagnosa as $row){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->diagnosa1);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pulang_1);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->pulang_2);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->pulang_3);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->tot);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia1);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->stat5);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->stat6);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->stat7);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->tot_stat);
			
			$rowCount++;
		}
		$filename = "Diagnosa RI ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_rekap_ri($param1='',$param2='',$lokasi=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars'); 
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Pasien Keluar Rawat Inap ".$namars."")  
		        ->setSubject("Laporan Pasien Keluar Rawat Inap ".$namars." Document")  
		        ->setDescription("Laporan Pasien Keluar Rawat Inap ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Pasien Keluar Rawat Inap");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_rekap_ri.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
      	
		$lokasi = str_replace('%20', ' ', $lokasi);

      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $lokasi);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

		$data_diagnosa=$this->Medmlaporan->get_data_rekap_ri($param1, $param2, $lokasi)->result();

		$rowCount = 12;
		$i=1;
		foreach($data_diagnosa as $row){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tgl_keluar);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->pulang_1);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->pulang_2);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pulang_3);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->stat1_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->stat1_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->stat1_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->stat1_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->stat1_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->stat1_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->stat1_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->stat1_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->stat1_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->stat1_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->stat1_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->stat1_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat2_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat2_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat2_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat2_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->stat2_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->stat2_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->stat2_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->stat2_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->stat2_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->stat2_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $row->stat2_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $row->stat2_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $row->stat3_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, $row->stat3_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $row->stat3_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, $row->stat3_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $row->stat3_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$rowCount, $row->stat3_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, $row->stat3_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, $row->stat3_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, $row->stat3_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, $row->stat3_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, $row->stat3_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$rowCount, $row->stat3_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, $row->stat4_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$rowCount, $row->stat4_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, $row->stat4_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$rowCount, $row->stat4_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$rowCount, $row->stat4_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AT'.$rowCount, $row->stat4_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$rowCount, $row->stat4_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$rowCount, $row->stat4_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AW'.$rowCount, $row->stat4_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AX'.$rowCount, $row->stat4_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('AY'.$rowCount, $row->stat4_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('AZ'.$rowCount, $row->stat4_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BA'.$rowCount, $row->stat5_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BB'.$rowCount, $row->stat5_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BC'.$rowCount, $row->stat5_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BD'.$rowCount, $row->stat5_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BE'.$rowCount, $row->stat5_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BF'.$rowCount, $row->stat5_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BG'.$rowCount, $row->stat5_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BH'.$rowCount, $row->stat5_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BI'.$rowCount, $row->stat5_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BJ'.$rowCount, $row->stat5_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BK'.$rowCount, $row->stat5_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BL'.$rowCount, $row->stat5_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BM'.$rowCount, $row->stat6_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BN'.$rowCount, $row->stat6_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BO'.$rowCount, $row->stat6_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BP'.$rowCount, $row->stat6_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BQ'.$rowCount, $row->stat6_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BR'.$rowCount, $row->stat6_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BS'.$rowCount, $row->stat6_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BT'.$rowCount, $row->stat6_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BU'.$rowCount, $row->stat6_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BV'.$rowCount, $row->stat6_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BW'.$rowCount, $row->stat6_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BX'.$rowCount, $row->stat6_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('BY'.$rowCount, $row->stat7_vvip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('BZ'.$rowCount, $row->stat7_vvip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CA'.$rowCount, $row->stat7_vip_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CB'.$rowCount, $row->stat7_vip_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CC'.$rowCount, $row->stat7_utama_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CD'.$rowCount, $row->stat7_utama_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CE'.$rowCount, $row->stat7_I_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CF'.$rowCount, $row->stat7_I_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CG'.$rowCount, $row->stat7_II_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CH'.$rowCount, $row->stat7_II_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CI'.$rowCount, $row->stat7_III_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CJ'.$rowCount, $row->stat7_III_hr);
			$objPHPExcel->getActiveSheet()->SetCellValue('CK'.$rowCount, $row->tot_stat_ps);
			$objPHPExcel->getActiveSheet()->SetCellValue('CL'.$rowCount, $row->tot_stat_hr);
			$rowCount++;
		}

      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

		$filename = "REKAP RAWAT INAP ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_sensus_rj($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		$namars=$this->config->item('namars');  
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Sensus Harian ".$namars."")  
		        ->setSubject("Sensus Harian ".$namars." Document")  
		        ->setDescription("Sensus Harian ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Sensus Harian");  

		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);
		$objPHPExcel=$objReader->load(APPPATH.'third_party/sensus_rj.xlsx');
		
		// $data_diagnosa=$this->Medmlaporan->get_data($param1, $param2)->result();
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		//get day
		$inithari = date('w', strtotime($param1));
		switch ($inithari) {
			case '0':
				$hari = "Minggu";
				break;
			case '1':
				$hari = "Senin";
				break;
			case '2':
				$hari = "Selasa";
				break;
			case '3':
				$hari = "Rabu";
				break;
			case '4':
				$hari = "Kamis";
				break;
			case '5':
				$hari = "Jumat";
				break;
			case '6':
				$hari = "Sabtu";
				break;
			
			default:
				$hari = "Minggu";
				break;
		}

		$param2 = str_replace('%20', ' ', $param2);

		$nm_poli=$this->Medmlaporan->get_nm_poli($param2)->row()->nm_poli;
		$objPHPExcel->getActiveSheet()->SetCellValue('C4', ': '.strtoupper($nm_poli));
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', ': '.$hari);
		$objPHPExcel->getActiveSheet()->SetCellValue('C6', ': '.date('d F Y', strtotime($param1)));

		$rowCount = 10;
		//TEMPAT TIDUR ISI
		$bed_isi_vvip=0;$bed_isi_vip=0;$bed_isi_utama=0;$bed_isi_i=0;$bed_isi_ii=0;$bed_isi_iii=0;
		//dalamperawatan
		$pdp_l=0;$pdp_p=0;
		$pdp_al_m=0;$pdp_al_s=0;$pdp_al_k=0;$pdp_al_p=0;$pdp_al_l=0;
		$pdp_ad_m=0;$pdp_ad_k=0;$pdp_ad_p=0;$pdp_ad_l=0;
		$pdp_au_m=0;$pdp_au_k=0;$pdp_au_p=0;$pdp_au_l=0;
		$pdp_au_bpjs=0;$pdp_au_umum=0;
		//masukrs
		$mr_l=0;$mr_p=0;
		$mr_al_m=0;$mr_al_s=0;$mr_al_k=0;$mr_al_p=0;$mr_al_l=0;
		$mr_ad_m=0;$mr_ad_k=0;$mr_ad_p=0;$mr_ad_l=0;
		$mr_au_m=0;$mr_au_k=0;$mr_au_p=0;$mr_au_l=0;
		$mr_au_bpjs=0;$mr_au_umum=0;
		//pindahdari
		$pd_l=0;$pd_p=0;
		$pd_al_m=0;$pd_al_s=0;$pd_al_k=0;$pd_al_p=0;$pd_al_l=0;
		$pd_ad_m=0;$pd_ad_k=0;$pd_ad_p=0;$pd_ad_l=0;
		$pd_au_m=0;$pd_au_k=0;$pd_au_p=0;$pd_au_l=0;
		$pd_au_bpjs=0;$pd_au_umum=0;
		//keluarhidup
		$kh_l=0;$kh_p=0;
		$kh_al_m=0;$kh_al_s=0;$kh_al_k=0;$kh_al_p=0;$kh_al_l=0;
		$kh_ad_m=0;$kh_ad_k=0;$kh_ad_p=0;$kh_ad_l=0;
		$kh_au_m=0;$kh_au_k=0;$kh_au_p=0;$kh_au_l=0;
		$kh_au_bpjs=0;$kh_au_umum=0;
		//pindahke
		$pk_l=0;$pk_p=0;
		$pk_al_m=0;$pk_al_s=0;$pk_al_k=0;$pk_al_p=0;$pk_al_l=0;
		$pk_ad_m=0;$pk_ad_k=0;$pk_ad_p=0;$pk_ad_l=0;
		$pk_au_m=0;$pk_au_k=0;$pk_au_p=0;$pk_au_l=0;
		$pk_au_bpjs=0;$pk_au_umum=0;
		//rujukrslain
		$rr_l=0;$rr_p=0;
		$rr_al_m=0;$rr_al_s=0;$rr_al_k=0;$rr_al_p=0;$rr_al_l=0;
		$rr_ad_m=0;$rr_ad_k=0;$rr_ad_p=0;$rr_ad_l=0;
		$rr_au_m=0;$rr_au_k=0;$rr_au_p=0;$rr_au_l=0;
		$rr_au_bpjs=0;$rr_au_umum=0;
		//keluarmeninggal
		$km_l=0;$km_p=0;
		$km_al_m=0;$km_al_s=0;$km_al_k=0;$km_al_p=0;$km_al_l=0;
		$km_ad_m=0;$km_ad_k=0;$km_ad_p=0;$km_ad_l=0;
		$km_au_m=0;$km_au_k=0;$km_au_p=0;$km_au_l=0;
		$km_au_bpjs=0;$km_au_umum=0;

		// POLIKLINIK
		$i = 1;
		$data_sensus=$this->Medmlaporan->get_sensus_irJ($param1, $param2)->result();
		foreach($data_sensus as $row){
			if ($row->nrp_sbg!="") {
				if($row->nrp_sbg != null){
					$data_anggota=$this->Medmlaporan->get_data_anggota($row->no_nrp)->row();
					if(empty($data_anggota->pangkat)) $pangkat = ''; else $pangkat=$data_anggota->pangkat;
					if(empty($data_anggota->kst_nama)) $kst_nama = ''; else $kst_nama=$data_anggota->kst_nama;
					if(empty($data_anggota->kst2_nama)) $kst2_nama = ''; else $kst2_nama=$data_anggota->kst2_nama;
					if(empty($data_anggota->kst3_nama)) $kst3_nama = ''; else $kst3_nama=$data_anggota->kst3_nama;
					if($kst_nama==''){
						$kst='';
					}else if($kst2_nama==''){
						$kst=$kst_nama;
					}else if($kst3_nama==''){
						$kst=$kst_nama.'/'.$kst2_nama;
					}else{
						$kst=$kst_nama.'/'.$kst2_nama.'/'.$kst3_nama;
					}


					$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $pangkat);
					$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $kst);
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->BARU);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->LAMA);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->age);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->tni_al_m);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->tni_al_s);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->tni_al_k);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->tni_n_al_m);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->tni_n_al_s);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tni_n_al_k);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->askes_al);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->askes_n_al);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->pol);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->pol_k);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->kjs);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->pbi);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->bpjs_kes);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->jam_per+$row->kerjasama);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->umum);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->bpjs_ket);
			$rowCount++;
		}
			// $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			// $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			// $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_cm);
			// $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
			// $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->diagnosa);
			// $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "=SUM(F10:F".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "=SUM(G10:G".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "=SUM(H10:H".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "=SUM(I10:I".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "=SUM(J10:J".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "=SUM(K10:K".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "=SUM(L10:L".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "=SUM(M10:M".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "=SUM(N10:N".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "=SUM(O10:O".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "=SUM(P10:P".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "=SUM(Q10:Q".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "=SUM(R10:R".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "=SUM(S10:S".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "=SUM(T10:T".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, "=SUM(U10:U".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, "=SUM(V10:V".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, "=SUM(W10:W".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, "=SUM(X10:X".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, "=SUM(Y10:Y".($rowCount-1).")" );
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "=SUM(Z10:Z".($rowCount-1).")" );

		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);

				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('Sensus Harian'); 

		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		$filename = "SENSUS_RJ_".date('d F Y', strtotime($param1))."_".str_replace(" ","_",$param1);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
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


	public function download_sensus_ri($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		$namars=$this->config->item('namars');  
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Sensus Harian ".$namars."")  
		        ->setSubject("Sensus Harian ".$namars." Document")  
		        ->setDescription("Sensus Harian ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Sensus Harian");  

		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);
		$objPHPExcel=$objReader->load(APPPATH.'third_party/sensus_ri.xlsx');
		
		// $data_diagnosa=$this->Medmlaporan->get_data($param1, $param2)->result();
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		//get day
		$inithari = date('w', strtotime($param1));
		switch ($inithari) {
			case '0':
				$hari = "Minggu";
				break;
			case '1':
				$hari = "Senin";
				break;
			case '2':
				$hari = "Selasa";
				break;
			case '3':
				$hari = "Rabu";
				break;
			case '4':
				$hari = "Kamis";
				break;
			case '5':
				$hari = "Jumat";
				break;
			case '6':
				$hari = "Sabtu";
				break;
			
			default:
				$hari = "Minggu";
				break;
		}

		$param2 = str_replace('%20', ' ', $param2);

		$objPHPExcel->getActiveSheet()->SetCellValue('B4', ': '.strtoupper($param2));
		$objPHPExcel->getActiveSheet()->SetCellValue('B5', ': '.$hari);
		$objPHPExcel->getActiveSheet()->SetCellValue('B6', ': '.date('d F Y', strtotime($param1)));

		$rowCount = 10;
		//TEMPAT TIDUR ISI
		$bed_isi_vvip=0;$bed_isi_vip=0;$bed_isi_utama=0;$bed_isi_i=0;$bed_isi_ii=0;$bed_isi_iii=0;
		//dalamperawatan
		$pdp_l=0;$pdp_p=0;
		$pdp_al_m=0;$pdp_al_s=0;$pdp_al_k=0;$pdp_al_p=0;$pdp_al_l=0;
		$pdp_ad_m=0;$pdp_ad_k=0;$pdp_ad_p=0;$pdp_ad_l=0;
		$pdp_au_m=0;$pdp_au_k=0;$pdp_au_p=0;$pdp_au_l=0;
		$pdp_au_bpjs=0;$pdp_au_umum=0;
		//masukrs
		$mr_l=0;$mr_p=0;
		$mr_al_m=0;$mr_al_s=0;$mr_al_k=0;$mr_al_p=0;$mr_al_l=0;
		$mr_ad_m=0;$mr_ad_k=0;$mr_ad_p=0;$mr_ad_l=0;
		$mr_au_m=0;$mr_au_k=0;$mr_au_p=0;$mr_au_l=0;
		$mr_au_bpjs=0;$mr_au_umum=0;
		//pindahdari
		$pd_l=0;$pd_p=0;
		$pd_al_m=0;$pd_al_s=0;$pd_al_k=0;$pd_al_p=0;$pd_al_l=0;
		$pd_ad_m=0;$pd_ad_k=0;$pd_ad_p=0;$pd_ad_l=0;
		$pd_au_m=0;$pd_au_k=0;$pd_au_p=0;$pd_au_l=0;
		$pd_au_bpjs=0;$pd_au_umum=0;
		//keluarhidup
		$kh_l=0;$kh_p=0;
		$kh_al_m=0;$kh_al_s=0;$kh_al_k=0;$kh_al_p=0;$kh_al_l=0;
		$kh_ad_m=0;$kh_ad_k=0;$kh_ad_p=0;$kh_ad_l=0;
		$kh_au_m=0;$kh_au_k=0;$kh_au_p=0;$kh_au_l=0;
		$kh_au_bpjs=0;$kh_au_umum=0;
		//pindahke
		$pk_l=0;$pk_p=0;
		$pk_al_m=0;$pk_al_s=0;$pk_al_k=0;$pk_al_p=0;$pk_al_l=0;
		$pk_ad_m=0;$pk_ad_k=0;$pk_ad_p=0;$pk_ad_l=0;
		$pk_au_m=0;$pk_au_k=0;$pk_au_p=0;$pk_au_l=0;
		$pk_au_bpjs=0;$pk_au_umum=0;
		//rujukrslain
		$rr_l=0;$rr_p=0;
		$rr_al_m=0;$rr_al_s=0;$rr_al_k=0;$rr_al_p=0;$rr_al_l=0;
		$rr_ad_m=0;$rr_ad_k=0;$rr_ad_p=0;$rr_ad_l=0;
		$rr_au_m=0;$rr_au_k=0;$rr_au_p=0;$rr_au_l=0;
		$rr_au_bpjs=0;$rr_au_umum=0;
		//keluarmeninggal
		$km_l=0;$km_p=0;
		$km_al_m=0;$km_al_s=0;$km_al_k=0;$km_al_p=0;$km_al_l=0;
		$km_ad_m=0;$km_ad_k=0;$km_ad_p=0;$km_ad_l=0;
		$km_au_m=0;$km_au_k=0;$km_au_p=0;$km_au_l=0;
		$km_au_bpjs=0;$km_au_umum=0;

		// DALAM PERAWATAN
		$data_sensus_dp=$this->Medmlaporan->get_sensus_iri_dalam_perawatan($param1, $param2)->result();
		foreach($data_sensus_dp as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip++;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip++;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama++;
			} else if ($row->kelas=="I") {
				$bed_isi_i++;
			} else if ($row->kelas=="II") {
				$bed_isi_ii++;
			} else if ($row->kelas=="III") {
				$bed_isi_iii++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'DALAM PERAWATAN');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$mr_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$mr_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$mr_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$mr_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$mr_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$mr_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$mr_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$mr_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$mr_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$mr_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$mr_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$mr_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$mr_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$mr_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$mr_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$mr_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$mr_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// MASUK RS
		$data_sensus_masuk=$this->Medmlaporan->get_sensus_iri_masuk($param1, $param2)->result();
		foreach($data_sensus_masuk as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip++;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip++;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama++;
			} else if ($row->kelas=="I") {
				$bed_isi_i++;
			} else if ($row->kelas=="II") {
				$bed_isi_ii++;
			} else if ($row->kelas=="III") {
				$bed_isi_iii++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'MASUK R.S.');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$mr_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$mr_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$mr_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$mr_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$mr_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$mr_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$mr_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$mr_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$mr_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$mr_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$mr_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$mr_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$mr_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$mr_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$mr_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$mr_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$mr_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// PINDAH DARI
		$data_sensus_pindah_dari=$this->Medmlaporan->get_sensus_iri_pindah_dari($param1, $param2)->result();
		foreach($data_sensus_pindah_dari as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip++;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip++;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama++;
			} else if ($row->kelas=="I") {
				$bed_isi_i++;
			} else if ($row->kelas=="II") {
				$bed_isi_ii++;
			} else if ($row->kelas=="III") {
				$bed_isi_iii++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'PINDAH DARI');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$pd_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$pd_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$pd_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$pd_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$pd_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$pd_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$pd_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$pd_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$pd_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$pd_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$pd_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$pd_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$pd_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$pd_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$pd_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$pd_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$pd_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->lokasi_dari);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// KELUAR HIDUP
		$data_sensus_keluar_hidup=$this->Medmlaporan->get_sensus_iri_keluar_hidup($param1, $param2)->result();
		foreach($data_sensus_keluar_hidup as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip--;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip--;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama--;
			} else if ($row->kelas=="I") {
				$bed_isi_i--;
			} else if ($row->kelas=="II") {
				$bed_isi_ii--;
			} else if ($row->kelas=="III") {
				$bed_isi_iii--;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'KELUAR HIDUP');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$kh_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$kh_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$kh_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$kh_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$kh_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$kh_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$kh_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$kh_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$kh_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$kh_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$kh_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$kh_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$kh_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$kh_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$kh_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$kh_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$kh_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->hp);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// PINDAH KE
		$data_sensus_pindah_ke=$this->Medmlaporan->get_sensus_iri_pindah_ke($param1, $param2)->result();
		foreach($data_sensus_pindah_ke as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip--;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip--;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama--;
			} else if ($row->kelas=="I") {
				$bed_isi_i--;
			} else if ($row->kelas=="II") {
				$bed_isi_ii--;
			} else if ($row->kelas=="III") {
				$bed_isi_iii--;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'PINDAH KE');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$pk_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$pk_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$pk_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$pk_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$pk_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$pk_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$pk_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$pk_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$pk_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$pk_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$pk_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$pk_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$pk_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$pk_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$pk_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$pk_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$pk_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $row->lokasi_ke);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// RUJUK RS LAIN
		$data_sensus_rujuk_rs_lain=$this->Medmlaporan->get_sensus_iri_rujuk_rs_lain($param1, $param2)->result();
		foreach($data_sensus_rujuk_rs_lain as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip--;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip--;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama--;
			} else if ($row->kelas=="I") {
				$bed_isi_i--;
			} else if ($row->kelas=="II") {
				$bed_isi_ii--;
			} else if ($row->kelas=="III") {
				$bed_isi_iii--;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'RUJUK RS LAIN');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$rr_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$rr_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$rr_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$rr_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$rr_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$rr_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$rr_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$rr_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$rr_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD
				$rr_ad_p++; 
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$rr_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$rr_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$rr_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$rr_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$rr_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$rr_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$rr_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->hp);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		// KELUAR MENINGGAL
		$data_sensus_keluar_meninggal=$this->Medmlaporan->get_sensus_iri_keluar_meninggal($param1, $param2)->result();
		foreach($data_sensus_keluar_meninggal as $row){
			if ($row->kelas=="VVIP") {
				$bed_isi_vvip--;
			} else if ($row->kelas=="VIP") {
				$bed_isi_vip--;
			} else if ($row->kelas=="UTAMA") {
				$bed_isi_utama--;
			} else if ($row->kelas=="I") {
				$bed_isi_i--;
			} else if ($row->kelas=="II") {
				$bed_isi_ii--;
			} else if ($row->kelas=="III") {
				$bed_isi_iii--;
			}
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'KELUAR MENINGGAL');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->kelas);

			if($row->sex=="L"){
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->umur);
				$km_l++;
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umur);
				$km_p++;
			}
			
			$al_mil = array(299,301);
			if( in_array($row->id_kontraktor, $al_mil) and $row->nrp_sbg == "T" ){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "x"); //MIL AL
				$km_al_m++;
			}

			if($row->id_kontraktor == 351 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "x"); //PNS AL
				$km_al_s++;
			}

			$al_kel = array(299,301,351);
			if( in_array($row->id_kontraktor, $al_kel) and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "x"); //KEL AL
				$km_al_k++;
			}

			if($row->id_kontraktor == 322){
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "x"); //PENS AL
				$km_al_p++;
			}

			$lal_lain = array(299,301,351);
			if( in_array($row->id_kontraktor, $lal_lain) and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "x"); //LAINNYA AL
				$km_al_l++;
			}

			if($row->id_kontraktor == 303 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "x"); // MIL AD
				$km_ad_m++;
			}

			if( $row->id_kontraktor == 303  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "x"); // KEL AD
				$km_ad_k++;
			}

			if($row->id_kontraktor == 324){
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "x"); //PENS AD 
				$km_ad_p++;
			}

			if( $row->id_kontraktor == 303 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "x"); //LAINNYA AD
				$km_ad_l++;
			}

			if($row->id_kontraktor == 304 and $row->nrp_sbg == "T"){
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "x"); //MIL AU 
				$km_au_m++;
			}

			if( $row->id_kontraktor == 304  and $row->nrp_sbg <> "T" and $row->nrp_sbg <> "" and $row->nrp_sbg <> NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "x"); // KEL AU
				$km_au_k++;
			}

			if($row->id_kontraktor == 327){
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "x"); // PENS AU
				$km_au_p++;
			}

			if( $row->id_kontraktor == 304 and $row->nrp_sbg == "" and $row->nrp_sbg == NULL ){
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "x"); // LAINNYA AU
				$km_au_l++;
			}

			$bpjs_umum = array(299,301,351,322,303,324,304,327);
			if( !in_array($row->id_kontraktor, $bpjs_umum) AND $row->cara_bayar == "BPJS"){
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "x"); // BPJS UMUM
				$km_au_bpjs++;
			}

			if( $row->cara_bayar == "UMUM"){
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "x"); // UMUM
				$km_au_umum++;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->no_cm);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->no_ipd);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->nm_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->hp);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('Z'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'FF0000')
			        )
			    )
			);

			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, "");
			$objPHPExcel->getActiveSheet()->getStyle('AB'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);

				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('Sensus Harian'); 

		// //SHEETS KE DUA
      	// $objPHPExcel->createSheet(1);  
		$objPHPExcel->setActiveSheetIndex(1);  
		// $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'TESSSS');


		// //dalamperawaatan
		$objPHPExcel->getActiveSheet()->SetCellValue('B6', $pdp_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C6', $pdp_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D6', $pdp_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E6', $pdp_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F6', $pdp_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G6', $pdp_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H6', $pdp_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I6', $pdp_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J6', $pdp_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K6', $pdp_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L6', $pdp_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M6', $pdp_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N6', $pdp_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O6', $pdp_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P6', $pdp_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q6', $pdp_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R6', $pdp_au_umum);

		//masukrs
		$objPHPExcel->getActiveSheet()->SetCellValue('B7', $mr_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C7', $mr_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D7', $mr_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E7', $mr_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F7', $mr_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G7', $mr_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H7', $mr_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I7', $mr_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J7', $mr_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K7', $mr_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L7', $mr_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M7', $mr_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N7', $mr_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O7', $mr_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P7', $mr_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q7', $mr_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R7', $mr_au_umum);
		
		//pindahdari
		$objPHPExcel->getActiveSheet()->SetCellValue('B8', $pd_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C8', $pd_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D8', $pd_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E8', $pd_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F8', $pd_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G8', $pd_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H8', $pd_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I8', $pd_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J8', $pd_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K8', $pd_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L8', $pd_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M8', $pd_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N8', $pd_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O8', $pd_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P8', $pd_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q8', $pd_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R8', $pd_au_umum);

		//keluarhidup
		$objPHPExcel->getActiveSheet()->SetCellValue('B10', $kh_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C10', $kh_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D10', $kh_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E10', $kh_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F10', $kh_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G10', $kh_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H10', $kh_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I10', $kh_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J10', $kh_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K10', $kh_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L10', $kh_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M10', $kh_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N10', $kh_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O10', $kh_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P10', $kh_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q10', $kh_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R10', $kh_au_umum);

		//pindahke
		$objPHPExcel->getActiveSheet()->SetCellValue('B11', $pk_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C11', $pk_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D11', $pk_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E11', $pk_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F11', $pk_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G11', $pk_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H11', $pk_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I11', $pk_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J11', $pk_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K11', $pk_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L11', $pk_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M11', $pk_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N11', $pk_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O11', $pk_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P11', $pk_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q11', $pk_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R11', $pk_au_umum);

		//rujukrslain
		$objPHPExcel->getActiveSheet()->SetCellValue('B12', $rr_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C12', $rr_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D12', $rr_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E12', $rr_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F12', $rr_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G12', $rr_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H12', $rr_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I12', $rr_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J12', $rr_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K12', $rr_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L12', $rr_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M12', $rr_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N12', $rr_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O12', $rr_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P12', $rr_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q12', $rr_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R12', $rr_au_umum);

		//keluarmeninggal
		$objPHPExcel->getActiveSheet()->SetCellValue('B13', $km_l);
		$objPHPExcel->getActiveSheet()->SetCellValue('C13', $km_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('D13', $km_al_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('E13', $km_al_s);
		$objPHPExcel->getActiveSheet()->SetCellValue('F13', $km_al_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('G13', $km_al_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('H13', $km_al_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I13', $km_ad_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('J13', $km_ad_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('K13', $km_ad_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('L13', $km_ad_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('M13', $km_au_m);
		$objPHPExcel->getActiveSheet()->SetCellValue('N13', $km_au_k);
		$objPHPExcel->getActiveSheet()->SetCellValue('O13', $km_au_p);
		$objPHPExcel->getActiveSheet()->SetCellValue('P13', $km_au_l);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Q13', $km_au_bpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('R13', $km_au_umum);


		// BANYAK TEMPAT TIDUR
		$bed_vvip=0;$bed_vip=0;$bed_utama=0;$bed_i=0;$bed_ii=0;$bed_iii=0;
		$data_kamar=$this->Medmlaporan->get_data_kamar($param2)->result();
		foreach($data_kamar as $row){
			if ($row->kelas=="VVIP") {
				$bed_vvip++;
			} else if ($row->kelas=="VIP") {
				$bed_vip++;
			} else if ($row->kelas=="UTAMA") {
				$bed_utama++;
			} else if ($row->kelas=="I") {
				$bed_i++;
			} else if ($row->kelas=="II") {
				$bed_ii++;
			} else if ($row->kelas=="III") {
				$bed_iii++;
			}
		}
		//terisi
		$objPHPExcel->getActiveSheet()->SetCellValue('B21', $bed_isi_vvip);
		$objPHPExcel->getActiveSheet()->SetCellValue('C21', $bed_isi_vip);
		$objPHPExcel->getActiveSheet()->SetCellValue('D21', $bed_isi_utama);
		$objPHPExcel->getActiveSheet()->SetCellValue('E21', $bed_isi_i);
		$objPHPExcel->getActiveSheet()->SetCellValue('F21', $bed_isi_ii);
		$objPHPExcel->getActiveSheet()->SetCellValue('G21', $bed_isi_iii);
		//tersedia
		$objPHPExcel->getActiveSheet()->SetCellValue('B23', $bed_vvip);
		$objPHPExcel->getActiveSheet()->SetCellValue('C23', $bed_vip);
		$objPHPExcel->getActiveSheet()->SetCellValue('D23', $bed_utama);
		$objPHPExcel->getActiveSheet()->SetCellValue('E23', $bed_i);
		$objPHPExcel->getActiveSheet()->SetCellValue('F23', $bed_ii);
		$objPHPExcel->getActiveSheet()->SetCellValue('G23', $bed_iii);


		$objPHPExcel->getActiveSheet()->setTitle('Perincian Pasien');   
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		$filename = "SENSUS_RI_".date('d F Y', strtotime($param1));
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
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

	public function download_dirujuk($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Dirujuk ".$namars)  
		        ->setSubject("Laporan Dirujuk".$namars." Document")  
		        ->setDescription("Laporan Dirujuk".$namars." generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Dirujuk");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/RJ_pasien_dirujuk_keluar.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
				
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$data_diagnosa=$this->Medmlaporan->get_all_dirujuk_keluar($param1, $param2)->result();
		$objPHPExcel->getActiveSheet()->setAutoFilter('B6:J6');
		$rowCount = 7;
		$i=1;
		
		foreach($data_diagnosa as $row){			

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_register);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $row->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->nm_poli);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->id_diagnosa.' - '.$row->diagnosa);		
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->id_procedure.' - '.$row->nm_procedure);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->catatan_plg);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->rs_rujukan);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->nm_dokter);			
			
			$rowCount++;
		}

      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$filename = "pasien_dirujuk_".date('d F Y', strtotime($param1))."_".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	//procedure
	public function download_icd_rj($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan 10 Besar ICD 9 ".$namars)  
		        ->setSubject("Laporan 10 Besar ICD 9 ".$namars." Document")  
		        ->setDescription("Laporan 10 Besar ICD 9 ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan 10 Besar ICD 9");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/RJ_10_besar_tindakan_9cm.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		$objPHPExcel->getActiveSheet()->SetCellValue('D4', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');
		$data_proc=$this->Medmlaporan->get_data_proc_rj($param1, $param2)->result();

		$rowCount = 8;
		$i=1;
		$totl=0;$totp=0;$totlp=0;

		$totusia06=0;
		$totusia728=0;
		$totusia1=0;
		$totusia2=0;
		$totusia3=0;
		$totusia4=0;
		$totusia5=0;
		$totusia6=0;
		$totusia7=0;
		$totusia=0;

		$totumum=0;
		$totbpjs=0;
		$totjamsoskes=0;
		$totdijamin=0;
		$totstat=0;
		foreach($data_proc as $row){
			$totl=$totl+$row->L;
			$totp=$totp+$row->P;
			$totlp=$totlp+$row->tot;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->id_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nm_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->tot);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);			

			$totusia06+=$row->usia06;
			$totusia728+=$row->usia728;
			$totusia1+=$row->usia1;
			$totusia2+=$row->usia2;
			$totusia3+=$row->usia3;
			$totusia4+=$row->usia4;
			$totusia5+=$row->usia5;
			$totusia6+=$row->usia6;
			$totusia7+=$row->usia7;
			$totusia+=$row->tot_usia;
			//usia
			//kurang dari 1 thn
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia06);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->usia728);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$totumum+=$row->stat1;
			$totbpjs+=$row->stat2;
			$totjamsoskes+=$row->stat3;
			$totdijamin+=$row->stat4;
			$totstat+=$row->tot_stat;

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'TOTAL');
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
		//total
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $totl);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $totp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $totlp);

			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totusia06);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $totusia728);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totusia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totusia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totusia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totusia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totusia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totusia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totusia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totusia);

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $totumum);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $totbpjs);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $totjamsoskes);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $totdijamin);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $totstat);

      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$filename = "proc_RJ_".date('d F Y', strtotime($param1))."_".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_icd_rd($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan 10 Besar ICD 9 ".$namars)  
		        ->setSubject("Laporan 10 Besar ICD 9 ".$namars." Document")  
		        ->setDescription("Laporan 10 Besar ICD 9 ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan 10 Besar ICD 9");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/RJ_10_besar_tindakan_9cm.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		$objPHPExcel->getActiveSheet()->SetCellValue('D4', "UGD | Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');
		$data_proc=$this->Medmlaporan->get_data_proc_rd($param1, $param2)->result();

		$rowCount = 8;
		$i=1;
		$totl=0;$totp=0;$totlp=0;

		$totusia06=0;
		$totusia728=0;
		$totusia1=0;
		$totusia2=0;
		$totusia3=0;
		$totusia4=0;
		$totusia5=0;
		$totusia6=0;
		$totusia7=0;
		$totusia8=0;
		$totusia9=0;
		$totusia=0;

		$totumum=0;
		$totbpjs=0;
		$totjamsoskes=0;
		$totdijamin=0;
		$totstat=0;
		foreach($data_proc as $row){
			$totl=$totl+$row->L;
			$totp=$totp+$row->P;
			$totlp=$totlp+$row->tot;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->id_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nm_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->tot);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);			

			$totusia06+=$row->usia06;
			$totusia728+=$row->usia728;
			$totusia1+=$row->usia1;
			$totusia2+=$row->usia2;
			$totusia3+=$row->usia3;
			$totusia4+=$row->usia4;
			$totusia5+=$row->usia5;
			$totusia6+=$row->usia6;
			$totusia7+=$row->usia7;
			$totusia+=$row->tot_usia;
			//usia
			//kurang dari 1 thn
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia06);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->usia728);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$totumum+=$row->stat1;
			$totbpjs+=$row->stat2;
			$totjamsoskes+=$row->stat3;
			$totdijamin+=$row->stat4;
			$totstat+=$row->tot_stat;

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'TOTAL');
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
		//total
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $totl);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $totp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $totlp);

			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totusia06);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $totusia728);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totusia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totusia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totusia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totusia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totusia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totusia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totusia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totusia);

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $totumum);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $totbpjs);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $totjamsoskes);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $totdijamin);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $totstat);

      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$filename = "proc_RD_".date('d F Y', strtotime($param1))."_".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_icd_ri($param1='',$param2='',$lokasi='',$kelas=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan 10 Besar Tindakan ICD 9 RI ".$namars)  
		        ->setSubject("Laporan 10 Besar Tindakan ICD 9 RI ".$namars." Document")  
		        ->setDescription("Laporan 10 Besar Tindakan ICD 9 RI ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan 10 Besar Tindakan ICD 9 RI");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		$objPHPExcel=$objReader->load(APPPATH.'third_party/RI_10_besar_tindakan.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  

		$lokasi = str_replace('%20', ' ', $lokasi);
		
		if(empty($lokasi)){
			$nama_ruang = "Seluruh Ruangan";
		}else{
			$nama_ruang = $lokasi;
		}
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', $nama_ruang);
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));


		$data_proc=$this->Medmlaporan->get_data_proc_ri($param1, $param2, $lokasi)->result();

		$rowCount = 10;
		$i=1;
		foreach($data_proc as $row){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nm_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->id_procedure);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pulang_1);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->pulang_2);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->pulang_3);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia1);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}


		$filename = "procedure_RI_".date('d F Y', strtotime($param1))."_".date('d F Y', strtotime($param2));
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_diag_rd2($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		$namars=$this->config->item('namars');   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Diagnosa ".$namars)  
		        ->setSubject("Laporan Diagnosa ".$namars." Document")  
		        ->setDescription("Laporan Diagnosa ".$namars." generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Diagnosa");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		// $objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_diag_rj.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		
      	$objPHPExcel->getActiveSheet()->SetCellValue('A5', "Rawat Darurat");
		$objPHPExcel->getActiveSheet()->SetCellValue('A6', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));

      	// $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$data_diagnosa=$this->Medmlaporan->get_data_diag_rd($param1, $param2)->result();

		$rowCount = 10;
		$i=1;
		$totl=0;$totp=0;$totlp=0;$totbaru=0;
		$totusia1=0;
		$totusia2=0;
		$totusia3=0;
		$totusia4=0;
		$totusia5=0;
		$totusia6=0;
		$totusia7=0;
		$totusia8=0;
		$totusia9=0;
		$totusia=0;

		$totumum=0;
		$totbpjs=0;
		$totjamsoskes=0;
		$totdijamin=0;
		$totstat=0;
		foreach($data_diagnosa as $row){
			$totl=$totl+$row->L;
			$totp=$totp+$row->P;
			$totlp=$totlp+$row->tot;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->id_diagnosa);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->L);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->P);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->tot);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$totbaru=$totbaru+$row->baru;
			//jumlah kunjungan baru
			//$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->baru);

			$totusia1+=$row->usia1;
			$totusia2+=$row->usia2;
			$totusia3+=$row->usia3;
			$totusia4+=$row->usia4;
			$totusia5+=$row->usia5;
			$totusia6+=$row->usia6;
			$totusia7+=$row->usia7;
			$totusia8+=$row->usia8;
			$totusia9+=$row->usia9;
			$totusia+=$row->tot_usia;
			//usia			
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia1);
			//6-11 thn
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->usia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->usia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->usia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->usia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->usia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->usia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->usia8);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->usia9);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->tot_usia);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);

			$totumum+=$row->stat1;
			$totbpjs+=$row->stat2;
			$totjamsoskes+=$row->stat3;
			$totdijamin+=$row->stat4;
			$totstat+=$row->tot_stat;

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->stat1);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->stat2);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->stat3);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->stat4);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->tot_stat);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
			
			$rowCount++;
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'TOTAL');
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'C1C1C1')
			        )
			    )
			);
		//total
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $totl);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $totp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $totlp);

			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totusia1);
			//1-4thn
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $totusia2);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totusia3);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totusia4);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totusia5);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totusia6);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totusia7);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totusia8);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totusia9);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totusia);

			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $totumum);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $totbpjs);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $totjamsoskes);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $totdijamin);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $totstat);
      	//AUTO SIZE
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$filename = "Diagnosa_RD_".date('d F Y', strtotime($param1))."_".date('d F Y', strtotime($param2));
		// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
				
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');
		// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
		// echo json_encode($data_keuangan);
	}

	public function download_chart_rj($param1='',$param2='', $id_poli=''){

		if($id_poli!=''){
			$data_chart=$this->Medmlaporan->get_chart_tindakan_rj($id_poli, $param1, $param2)->result();
			
			$this->load->library('Excel');  
		   
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   
				   
			// Set document properties  
			$namars=$this->config->item('namars');
			$objPHPExcel->getProperties()->setCreator($namars)  
				        ->setLastModifiedBy($namars)  
				        ->setTitle("Laporan Chart RJ ".$namars)  
				        ->setSubject("Laporan Chart RJ ".$namars." Document")  
				        ->setDescription("Laporan Chart RJ ".$namars.", generated by HMIS.")  
				        ->setKeywords($namars)  
				        ->setCategory("Laporan Chart RJ"); 
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_chart_rj.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);

			if($id_poli=='semua'){
				$listtind = $this->Medmlaporan->get_chart_tind_detail($id_poli,$param1, $param2)->result();
				$namapoli='Semua Poliklinik';				
							
				$vtot1=0;
				$i=1;
				$rowCount = 4;	

				$masterpoli=$this->rjmpencarian->get_poliklinik()->result();
				$objPHPExcel->getActiveSheet()->setTitle('Lap Chart RJ'); 
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, "aaaaaaaaaaaaaa");
				$objPHPExcel->getActiveSheet()->setCellValue('B5', $namapoli);
				$objPHPExcel->getActiveSheet()->setCellValue('B6', date('d-m-Y',strtotime($param1)).' - '.date('d-m-Y',strtotime($param2)));

		      	$rowCount = 10; $vtotbpjs=0; $vtotumum=0; $vtotdijamin=0; $vtotjamsos=0; $vtotp=0; $vtotl=0;$no=1;
		      	foreach($listtind as $key) {
			        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $no++);
			        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nmtindakan);
			        
			        foreach($data_chart as $row0) {
			        	$col = 2;
				        if($key->idtindakan==$row0->idtindakan){
				        	foreach($masterpoli as $row) {
				        		// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->id_poli);
				        		if($row0->id_poli==$row->id_poli){	
				        			$vtot1=$vtot1+$row0->banyak;
				        			//echo $row->banyak.' '.$row->nmtindakan;   */   			
				        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->banyak);
				        		}else{
				        			//echo $row->idtindakan.'=='.$row0->idtindakan;
				        			//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        			//if($hi==null && $hi<1){
				        			//	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        			//}
				        			
				        		}	
				        		$col++;	
				        	}
				    	}else{	    		
				    		//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        	//if($hi==null && $hi<1){
				        	//			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        	//}
				        	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, '0');		        	
				    	}
			        }
			        $rowCount++;
			    }

				$col = 2;
			    foreach($masterpoli as $key) {
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 9, $key->nm_poli);
			        $cell=PHPExcel_Cell::stringFromColumnIndex($col);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$rowCount, '=SUM('.$cell.'10:'.$cell.($rowCount-1).')');
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
			    
			    for ($j=10;$j<$rowCount;$j++) {
					for ($i=2;$i<$col;$i++) {
					    $hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();//getCellValueByColumnAndRow();
					    if($hi==null || $hi==''){
					    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
					    }
					}
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Seluruh');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);
			}else{

				$get_nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->result();
				foreach($get_nm_poli as $row){
					$nm_poli=$row->nm_poli;
				}
				$objPHPExcel->getActiveSheet()->setTitle('Lap Chart RJ'); 
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, "aaaaaaaaaaaaaa");
				$objPHPExcel->getActiveSheet()->setCellValue('B5', $nm_poli);
				$objPHPExcel->getActiveSheet()->setCellValue('B6', date('d-m-Y',strtotime($param1)).' - '.date('d-m-Y',strtotime($param2)));

				$rowCount=10;$vtot1=0;$no=1;
				foreach($data_chart as $key) {
					$vtot1=$vtot1+$key->banyak;
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $no++);
			        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nmtindakan);
			        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->banyak);
			        $rowCount++;
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total Seluruh');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1);
			}

			
			$filename = "Lap_chart_RJ_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
			// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
			// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle($namars);    
			   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Cache-Control: max-age=0');  
			   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			// $objWriter->save('php://output');  
			$this->SaveViaTempFile($objWriter);
		}
	}

	public function download_chart_ri($param1='',$param2='', $lokasi=''){

		if(empty($lokasi)){
			$nama_ruang = "Seluruh Ruangan";
			$masterruangan=$this->Medmlaporan->get_ruangan()->result();
		}else{
			$lokasi = str_replace('%20', ' ', $lokasi);
			$masterruangan=$this->Medmlaporan->get_ruangan_by_lokasi($lokasi)->result();
			$nama_ruang = $lokasi;
		}
			$data_chart=$this->Medmlaporan->get_chart_tindakan_ri($lokasi, $param1, $param2)->result();
			$listtind = $this->Medmlaporan->get_chart_ri_tind_detail($lokasi,$param1, $param2)->result();

				$this->load->library('Excel');  
		   
				// Create new PHPExcel object  
				$objPHPExcel = new PHPExcel();   
				   
				// Set document properties  
				$namars=$this->config->item('namars');
				$objPHPExcel->getProperties()->setCreator($namars)  
				        ->setLastModifiedBy($namars)  
				        ->setTitle("Laporan Chart RI ".$namars)  
				        ->setSubject("Laporan Chart RI ".$namars." Document")  
				        ->setDescription("Laporan Chart RI ".$namars.", generated by HMIS.")  
				        ->setKeywords($namars)  
				        ->setCategory("Laporan Chart RI");  

				//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
				//$objPHPExcel = $objReader->load("project.xlsx");
				   
				$objReader= PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				//$tgl=$param1;
				//$tgl1 = date('d F Y', strtotime($tgl));				
							
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_chart_ri.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				//$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 4;	
				//$hasil=$this->Labmlaporan->get_lap_pemeriksaan_detail($date0,$date1)->result();
				//$listtgl = $this->Labmlaporan->get_dates_detail($date0,$date1)->result();
				//$master_lab=$this->Labmlaporan->get_master_pemeriksaan_lab()->result();

				
				$objPHPExcel->getActiveSheet()->setTitle('Lap Chart RI'); 
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, "aaaaaaaaaaaaaa");
				$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Ruangan '.$nama_ruang);
				$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Periode '.date('d-m-Y',strtotime($param1)).' - '.date('d-m-Y',strtotime($param2)));

		      	$rowCount = 10; $vtotbpjs=0; $vtotumum=0; $vtotdijamin=0; $vtotjamsos=0; $vtotp=0; $vtotl=0;$no=1;
		      	foreach($listtind as $key) {
			        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $no++);
			        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nmtindakan);
			        
			        foreach($data_chart as $row0) {
			        	$col = 2;
				        if($key->idtindakan==$row0->idtindakan){
				        	foreach($masterruangan as $row) {
				        		// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->id_poli);
				        		if($row0->idrg==$row->idrg){	
				        			$vtot1=$vtot1+$row0->banyak;
				        			//echo $row->banyak.' '.$row->nmtindakan;   */   			
				        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row0->banyak);
				        		}else{
				        			//echo $row->idtindakan.'=='.$row0->idtindakan;
				        			//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        			//if($hi==null && $hi<1){
				        			//	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        			//}
				        			
				        		}	
				        		$col++;	
				        	}
				    	}else{	    		
				    		//$hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, 5)->getValue();//getCellValueByColumnAndRow();
				        	//if($hi==null && $hi<1){
				        	//			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, 0);
				        	//}
				        	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 5, '0');		        	
				    	}
			        }
			        $rowCount++;
			    }

				$col = 2;
			    foreach($masterruangan as $key) {
			        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 9, $key->nmruang);
			        $cell=PHPExcel_Cell::stringFromColumnIndex($col);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$rowCount, '=SUM('.$cell.'10:'.$cell.($rowCount-1).')');
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
			    
			    for ($j=10;$j<$rowCount;$j++) {
					for ($i=2;$i<$col;$i++) {
					    $hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();//getCellValueByColumnAndRow();
					    if($hi==null || $hi==''){
					    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
					    }
					}
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Seluruh');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);

			
			$filename = "Lap_chart_RI_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
			// $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
			// $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle($namars);    
			   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
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

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}
}

?>
