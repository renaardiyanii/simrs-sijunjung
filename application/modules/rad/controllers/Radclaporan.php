<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
//require_once(APPPATH.'controllers/Secure_area.php');
class Radclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('rad/Radmlaporan','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('rad/Radcdaftar','refresh');
	}

	public function lap_pemeriksaan(){
		$data['title'] = 'Laporan Pemeriksaan Radiologi';
		//$date0=$this->input->post('date0');
		//$date1=$this->input->post('date1');
		$data['tindakan'] = $this->Radmlaporan->get_tindakan()->result();
		$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		$tampil = $this->input->post('tampil_per');
		$data['tampil'] = $tampil;
		if($tampil == 'TGL') {
			$tgl = $this->input->post('date_picker_days');
			$data['tgl'] = $tgl;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_tgl($tgl)->result();
		} else if($tampil == 'BLN') {
			$bln = $this->input->post('date_picker_months');
			$data['bln'] = $bln;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_bln($bln)->result();
		} else if($tampil == 'THN') {
			$bln = $this->input->post('date_picker_years');
			$data['thn'] = $thn;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_thn($thn)->result();
		} else if($tampil == '') {
			$data['today'] = date("Y-m-d");
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan()->result();
		}
		//var_dump($data['data_pemeriksaan']); die();
		$this->load->view('rad/radvlappemeriksaanrange',$data);
	}

	function showlap_pemeriksaan($date0='',$date1='',$tindak='',$dokter=''){
		$line  = array();
		$line2 = array();
		$row2  = array();	
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d');
			$date1=date('Y-m-d');
		}		
		//$data['tglawal']=date('d F Y',strtotime($date0));
		//$data['tglakhir']=date('d F Y',strtotime($date1));
		$hasil=$this->Radmlaporan->get_lap_pemeriksaan($date0,$date1,$tindak,$dokter)->result();			
		foreach ($hasil as $value) {
			$row2['idtindakan'] = $value->id_tindakan;
			$row2['nmtindakan'] = $value->jenis_tindakan;
			$row2['nm_dokter'] = $value->nm_dokter;
			$row2['tgl_kunjungan'] = $value->tgl_kunjungan;
			$row2['banyak'] = $value->banyak;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function lap_penerimaan() {
		$data['title'] = 'Laporan Penerimaan Radiologi';
		// $data_r = number_format(1.179e+08);
		// var_dump($data_r); die();
		$this->load->view('rad/radvpenerimaan',$data);
	}

	public function lap_utilisasi() {
		$data['title'] = 'Laporan Utilisasi Radiologi';
		$date = $this->input->post('date_picker_months');
		//$data['utilitas'] = $this->Radmlaporan->get_utilitas($date)->result();
		$this->load->view('rad/radvutilitas',$data);
	}

	public function lap_utilitas_bln($tampil_per_2='',$data2='') {
		$tampil_per = $tampil_per_2==''?$this->input->get('tampil_per'):$tampil_per_2;
		$data = $data2==''?$this->input->get('data'):$data2; 
		//if($tampil_per == 'BLN') {
		$hasil = $this->Radmlaporan->get_utilitas($data, $tampil_per)->result();
		// } else if($tampil_per == 'THN') {
		// 	$hasil = $this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($data)->result();		
		// }
		$modality = [];
		$result = [];
		$tgl = [];
		$persen = 0;
		$rata = 0;
		$total = 0;
		// var_dump($hasil);die();
		foreach($hasil as $val){
			if(!in_array($val->modality,$modality))
			{
				array_push($modality,$val->modality);
			}
			if(!in_array($val->tgl,$tgl))
			{
				array_push($tgl,$val->tgl);
			}
			$rata+=(int)$val->jml;
		}

		$tanggal_lengkap = [];
		for($i = 1;$i<=31;$i++){
			array_push($tanggal_lengkap,$i);
		}
		//if(!empty(aa$modality)) {
			foreach($modality as $mod)
			{
				$data = [
					'modality'=>$mod,
					'hari_kerja'=>count($hasil),
					'total'=>$rata,
					'rata'=>number_format($rata / count($hasil),2, ',', '.'),
					'hasil'=>[]
				];
				
				foreach($tanggal_lengkap as $tgl)
				{
					
					$datas=[];
					$datax = [];
					foreach($hasil as $val){
						//var_dump($hasil);die();
						if($val->modality == $mod){
							if($val->tgl == $tgl){
								//$rumus = $val->jml;
								$datas[$tgl] = [
									'jml'=>$val->jml,
									// 'expert'=>$val->jml_expert,
									// 'persen'=>0,
								];
								$rata += (int)$val->jml;
							}
						}
						if($val->modality == $mod){
							if($val->tgl != $tgl){
								if(!isset($datas[$tgl]['jml'])){
									// echo 'masuk sini';die();
									$datas[$tgl] = [
										'jml'=>'',
										// 'expert'=>'',
										// 'persen'=>'',
									];
									$rata += (int)0;
								}
								// if(!isset($datas[$bln]['exam'])){
								// 	$datax[$bln] = [
								// 		'exam'=>'',
								// 		'expert'=>'',
								// 		'persen'=>0,
								// 	];
									
								// }
							}
						}
					}
					// var_dump($datas);die();
					array_push($data['hasil'],[$datas]);
					// array_push($data['hasil'],[$datax]);
					
					
				}
				
				array_push($result,
				$data);

			}
			
			// $result['total'] = $rata;
			// //$result['hari_kerja'] = count($hasil);
			// $result['rata'] = number_format($rata / count($hasil),2, ',', '.');
			//var_dump($result); die();
		//}
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		// die();

		// $convert = [
		// 	[
		// 		'modality'=>'Radiography',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'modality'=>'Radiologi',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	]
		// ];
		// echo '<pre>';
		// var_dump($convert);
		// echo '</pre>';
		// die();
		if($tampil_per_2==''){
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($result);
			return;
		}
		return $result;
	}

	public function lap_penerimaan_bln($date) {
		$hasil = $this->Radmlaporan->get_penerimaan_bln($date)->result();
		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		$persen = 0;
		foreach ($hasil as $value) {
			//$rumus = $value->jml_exam == "0" || $value->jml_exam == null || $value->jml_expert == "0" || $value->jml_expert == null ? "0":(($value->jml_exam?0:intval($value->jml_exam)) / ($value->jml_expert?0:intval($value->jml_expert)) * 100);
			//$rumus = $value->jml_expert?($value->jml_expert!='0'?(($value->jml_exam / $value->jml_expert) * 100):0):0;
			$row2['no'] = $i++;
			$row2['modality'] = $value->modality;
			$row2['bpjs'] = 'Rp. '.number_format($value->bpjs);
			$row2['umum'] = 'Rp. '.number_format($value->umum);
			//$row2['persen'] = $persen + $rumus.'%';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function lap_ulang_mod_thn($tampil_per_2='',$data2='') {
		$tampil_per = $tampil_per_2==''?$this->input->get('tampil_per'):$tampil_per_2;
		$data = $data2==''?$this->input->get('data'):$data2; 
		if($tampil_per == 'BLN') {
			$hasil = $this->Radmlaporan->get_lap_ulang_bln($data)->result();
		} else if($tampil_per == 'THN') {
			$hasil = $this->Radmlaporan->get_lap_ulang_thn($data)->result();		
		}
		$modality = [];
		$result = [];
		$bulan = [];
		$persen = 0;
		foreach($hasil as $val){
			if(!in_array($val->modality,$modality))
			{
				array_push($modality,$val->modality);
			}
			if(!in_array($val->bulan,$bulan))
			{
				array_push($bulan,$val->bulan);
			}
		}

		//if(!empty(aa$modality)) {
			foreach($modality as $mod)
			{
				$data = [
					'modality'=>$mod,
					'hasil'=>[]
				];
				foreach($bulan as $bln)
				{
					
					$datas=[];
					$datax = [];
					foreach($hasil as $val){
						if($val->modality == $mod){
							if($val->bulan == $bln){
								//$rumus = $val->jml_exam == '0' || $val->jml_exam == null || $val->jml_expert == '0' || $val->jml_expert == null ? '0':(($val->jml_exam?0:intval($val->jml_exam)) / ($val->jml_expert?0:intval($val->jml_expert)) * 100);
								$datas[$bln] = [
									'jml'=>$val->jml,
									// 'expert'=>$val->jml_expert,
									// 'persen'=>0,
								];
							}
						}
						if($val->modality == $mod){
							if($val->bulan != $bln){
								if(!isset($datas[$bln]['jml'])){
									$datas[$bln] = [
										'jml'=>'',
										// 'expert'=>'',
										// 'persen'=>'',
									];
								}
								// if(!isset($datas[$bln]['exam'])){
								// 	$datax[$bln] = [
								// 		'exam'=>'',
								// 		'expert'=>'',
								// 		'persen'=>0,
								// 	];
									
								// }
							}
						}
					}
					array_push($data['hasil'],[$datas]);
					// array_push($data['hasil'],[$datax]);
					
					
					
				}

				
				array_push($result,
				$data);

				
			}
		//}
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		// die();

		// $convert = [
		// 	[
		// 		'modality'=>'Radiography',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'modality'=>'Radiologi',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	]
		// ];
		// echo '<pre>';
		// var_dump($convert);
		// echo '</pre>';
		// die();
		if($tampil_per_2==''){
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($result);
			return;
		}
		return $result;
	}

	public function lap_ulang_mod_bln($date) {
		$hasil = $this->Radmlaporan->get_lap_ulang_bln($date)->result();
		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$rumus = $value->jml?($value->jml!='0'?($value->jml):0):0;
			$row2['no'] = $i++;
			$row2['modality'] = $value->modality;
			$row2['jml'] = $rumus;
		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_ulang_bln($date) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis Layanan');
		$sheet->setCellValue('C1', 'Jumlah');
		// $sheet->setCellValue('D1', 'Febuari');
		// $sheet->setCellValue('E1', 'Maret');
		// $sheet->setCellValue('F1', 'April');
		// $sheet->setCellValue('G1', 'Mei');
		// $sheet->setCellValue('H1', 'Juni');
		// $sheet->setCellValue('I1', 'Juli');
		// $sheet->setCellValue('J1', 'Agustus');
		// $sheet->setCellValue('K1', 'September');
		// $sheet->setCellValue('L1', 'Oktober');
		// $sheet->setCellValue('M1', 'November');
		// $sheet->setCellValue('N1', 'Desember');
						
		$data['data_laporan'] = $this->Radmlaporan->get_lap_ulang_bln($date)->result();
		$no = 1;
		$x = 2;
		
		foreach($data['data_laporan'] as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->modality);
			$sheet->setCellValue('C'.$x, $row->jml?($row->jml!='0'?($row->jml):0):0);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pengulangan Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_ulang_thn($date='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis Layanan');
		$sheet->setCellValue('C1', 'Januari');
		$sheet->setCellValue('D1', 'Febuari');
		$sheet->setCellValue('E1', 'Maret');
		$sheet->setCellValue('F1', 'April');
		$sheet->setCellValue('G1', 'Mei');
		$sheet->setCellValue('H1', 'Juni');
		$sheet->setCellValue('I1', 'Juli');
		$sheet->setCellValue('J1', 'Agustus');
		$sheet->setCellValue('K1', 'September');
		$sheet->setCellValue('L1', 'Oktober');
		$sheet->setCellValue('M1', 'November');
		$sheet->setCellValue('N1', 'Desember');
		
		// $hasil=$this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($date)->result();
		$hasil = $this->lap_ulang_mod_thn('THN',$date);
		$no = 1;
		$x = 2;
		$total_jan = 0;
		$total_feb = 0;
		$total_mar = 0;
		$total_apr = 0;
		$total_mei = 0;
		$total_jun = 0;
		$total_jul = 0;
		$total_ags = 0;
		$total_sep = 0;
		$total_okt = 0;
		$total_nov = 0;
		$total_des = 0;
		foreach($hasil as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row['modality']);

			foreach($row['hasil'] as $v){
				if(isset($v[0]['JANUARI'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$jml = $v[0]['JANUARI']['jml']?($v[0]['JANUARI']['jml']!='0'?($v[0]['JANUARI']['jml']):0):0;
					$total_jan += $jml;
					$sheet->setCellValue('C'.$x, $jml);
				}
				if(isset($v[0]['FEBUARI'])){
					$jml = $v[0]['FEBUARI']['jml']?($v[0]['FEBUARI']['jml']!='0'?($v[0]['FEBUARI']['jml']):0):0;
					$total_feb += $jml;
					$sheet->setCellValue('D'.$x, $jml);
				}
				if(isset($v[0]['MARET'])){
					$jml = $v[0]['MARET']['jml']?($v[0]['MARET']['jml']!='0'?($v[0]['MARET']['jml']):0):0;
					$total_mar += $jml;
					$sheet->setCellValue('E'.$x, $jml);
				}
				if(isset($v[0]['APRIL'])){
					$jml = $v[0]['APRIL']['jml']?($v[0]['APRIL']['jml']!='0'?($v[0]['APRIL']['jml']):0):0;
					$total_apr += $jml;
					$sheet->setCellValue('F'.$x, $jml);
				}
				if(isset($v[0]['MEI'])){
					$jml = $v[0]['MEI']['jml']?($v[0]['MEI']['jml']!='0'?($v[0]['MEI']['jml']):0):0;
					$total_mei += $jml;
					$sheet->setCellValue('G'.$x, $jml);
				}
				if(isset($v[0]['JUNI'])){
					$jml = $v[0]['JUNI']['jml']?($v[0]['JUNI']['jml']!='0'?($v[0]['JUNI']['jml']):0):0;
					$total_jun += $jml;
					$sheet->setCellValue('H'.$x, $jml);
				}
				
				if(isset($v[0]['JULI'])){
					$jml = $v[0]['JULI']['jml']?($v[0]['JULI']['jml']!='0'?($v[0]['JULI']['jml']):0):0;
					$total_jul += $jml;
					$sheet->setCellValue('I'.$x, $jml);
				}
				if(isset($v[0]['AGUSTUS'])){
					$jml = $v[0]['AGUSTUS']['jml']?($v[0]['AGUSTUS']['jml']!='0'?($v[0]['AGUSTUS']['jml']):0):0;
					$total_ags += $jml;
					$sheet->setCellValue('J'.$x, $jml);
				}
				if(isset($v[0]['SEPTEMBER'])){
					$jml = $v[0]['SEPTEMBER']['jml']?($v[0]['SEPTEMBER']['jml']!='0'?($v[0]['SEPTEMBER']['jml']):0):0;
					$total_sep += $jml;
					$sheet->setCellValue('K'.$x, $jml);
				}
				if(isset($v[0]['OKTOBER'])){
					$jml = $v[0]['OKTOBER']['jml']?($v[0]['OKTOBER']['jml']!='0'?($v[0]['OKTOBER']['jml']):0):0;
					$total_okt += $jml;
					$sheet->setCellValue('L'.$x, $jml);
				}
				if(isset($v[0]['NOVEMBER'])){
					$jml = $v[0]['NOVEMBER']['jml']?($v[0]['NOVEMBER']['jml']!='0'?($v[0]['NOVEMBER']['jml']):0):0;
					$total_nov += $jml;
					$sheet->setCellValue('M'.$x, $jml);
				}
				if(isset($v[0]['DESEMBER'])){
					$jml = $v[0]['DESEMBER']['jml']?($v[0]['DESEMBER']['jml']!='0'?($v[0]['DESEMBER']['jml']):0):0;
					$total_des += $jml;
					$sheet->setCellValue('N'.$x, $jml);
				}
			}
			$x++;
		}
		
		$sheet->mergeCells('A7:B7')
			->getCell('A7')
			->setValue('Jumlah Exposi');
		$sheet->setCellValue('C7', $total_jan);
		$sheet->setCellValue('D7', $total_feb);
		$sheet->setCellValue('E7', $total_mar);
		$sheet->setCellValue('F7', $total_apr);
		$sheet->setCellValue('G7', $total_mei);
		$sheet->setCellValue('H7', $total_jun);
		$sheet->setCellValue('I7', $total_jul);
		$sheet->setCellValue('J7', $total_ags);
		$sheet->setCellValue('K7', $total_sep);
		$sheet->setCellValue('L7', $total_okt);
		$sheet->setCellValue('M7', $total_nov);
		$sheet->setCellValue('N7', $total_des);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pengulangan Radiologi '.$date;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_bhp() {
		$data['title'] = 'Laporan BHP Radiologi';
		$this->load->view('rad/radvlapbhp', $data);
	}

	public function lap_bhp_exe($date1, $date2) {
		header('Content-Type: application/json; charset=utf-8');
		$hasil = $this->Radmlaporan->get_data_laporan_bhp($date1, $date2)->result();
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$birthDate = new DateTime($value->tgl_lahir);
            $today = new DateTime("today");
            if ($birthDate > $today) { 
                exit("0 tahun");
            }
            $y = $today->diff($birthDate)->y;
			$row2['no'] = $i++;
			$row2['no_register'] = $value->no_register;
			$row2['nama'] = $value->nama;
			$row2['no_medrec'] = $value->no_cm;
			if(substr($value->no_register,0,2) == 'RI') {
				$row2['asal'] = $value->idrg;
			} else {
				$row2['asal'] = $value->bed;
			}
			$row2['kelamin'] = $value->kelamin;
			$row2['jaminan'] = $value->cara_bayar;
			$row2['umur'] = $y.' Tahun';
			$row2['id_pemeriksaan'] = $value->id_pemeriksaan_rad;
			$row2['jenis_tindakan'] = $value->jenis_tindakan;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		// var_dump($line['data']);die();
		echo json_encode($line);
	}

	public function get_detail_bhp_rad() {
		$no_register = $this->input->post('no_register');

        $line   = array();
        $line2  = array();
        $row2   = array();

        $hasil = $this->Radmlaporan->get_data_bhp_detail($no_register)->result();
        foreach ($hasil as $value) {
            $row2['no_register'] = $value->no_register;
            $row2['jenis_tindakan'] = $value->jenis_tindakan;
			$row2['nama_bhp'] = $value->nama_bhp;
            $row2['satuan'] = $value->satuan;
			$row2['kategori'] = $value->kategori;
            $row2['qty'] = $value->qty;

            $line2[] = $row2;
        }

        $line['data'] = $line2;
      
        echo json_encode($line);
	}

	public function excel_lap_bhp($date1, $date2) {
		$tgl1 = date("d F Y", strtotime($date1));
		$tgl2 = date("d F Y", strtotime($date2));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'Tindakan');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'No Medrec');
		$sheet->setCellValue('F1', 'Asal');
		$sheet->setCellValue('G1', 'Kelamin');
		$sheet->setCellValue('H1', 'Jaminan');
		$sheet->setCellValue('I1', 'Umur');
		$sheet->setCellValue('J1', 'Nama BHP');
		$sheet->setCellValue('K1', 'Satuan');
		$sheet->setCellValue('L1', 'Kategori');
		$sheet->setCellValue('M1', 'Qty');
						
		$data['data_laporan'] = $this->Radmlaporan->get_lap_bhp_excel($date1, $date2)->result();
		$no = 1;
		$x = 2;
		
		foreach($data['data_laporan'] as $row)
		{
			$birthDate = new DateTime($row->tgl_lahir);
            $today = new DateTime("today");
            if ($birthDate > $today) { 
                exit("0 tahun");
            }
            $y = $today->diff($birthDate)->y;
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_register);
			$sheet->setCellValue('C'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('D'.$x, $row->nama);
			$sheet->setCellValue('E'.$x, $row->no_cm);
			if(substr($row->no_register,0,2) == 'RI') {
				$sheet->setCellValue('F'.$x, $row->idrg);
			} else {
				$sheet->setCellValue('F'.$x, $row->bed);
			}	
			$sheet->setCellValue('G'.$x, $row->kelamin);
			$sheet->setCellValue('H'.$x, $row->cara_bayar);
			$sheet->setCellValue('I'.$x, $y.' Tahun');
			$sheet->setCellValue('J'.$x, $row->nama_bhp);
			$sheet->setCellValue('K'.$x, $row->satuan);
			$sheet->setCellValue('L'.$x, $row->kategori);
			$sheet->setCellValue('M'.$x, $row->qty);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan BHP Radiologi '.$tgl1.' - '.$tgl2;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_bhp_detail() {
		$data['title'] = 'Laporan BHP Per Item';
		$this->load->view('rad/radvlapbhp_detail.php', $data);
	}

	public function lap_bhp_detail_mod($tampil_per_2='',$data2='') {
		$tampil_per = $tampil_per_2==''?$this->input->get('tampil_per'):$tampil_per_2;
		$data = $data2==''?$this->input->get('data'):$data2; 
		if($tampil_per == 'BLN') {
			$hasil = $this->Radmlaporan->get_jml_pemeriksaan_expert_bln($data)->result();
		} else if($tampil_per == 'THN') {
			$hasil = $this->Radmlaporan->get_bhp_per_tahun($data)->result();		
		}
		$nama_bhp = [];
		$result = [];
		$bulan = [];
		$persen = 0;
		foreach($hasil as $val){
			if(!in_array($val->nama_bhp,$nama_bhp))
			{
				array_push($nama_bhp,$val->nama_bhp);
			}
			if(!in_array($val->bulan,$bulan))
			{
				array_push($bulan,$val->bulan);
			}
		}

		//if(!empty(aa$modality)) {
			foreach($nama_bhp as $mod)
			{
				$data = [
					'nama_bhp'=>$mod,
					'hasil'=>[]
				];
				foreach($bulan as $bln)
				{
					
					$datas=[];
					$datax = [];
					foreach($hasil as $val){
						if($val->nama_bhp == $mod){
							if($val->bulan == $bln){
								//$rumus = $val->jml_exam == '0' || $val->jml_exam == null || $val->jml_expert == '0' || $val->jml_expert == null ? '0':(($val->jml_exam?0:intval($val->jml_exam)) / ($val->jml_expert?0:intval($val->jml_expert)) * 100);
								$datas[$bln] = [
									'jml'=>$val->jml,
									// 'expert'=>$val->jml_expert,
									// 'persen'=>0,
								];
							}
						}
						if($val->nama_bhp == $mod){
							if($val->bulan != $bln){
								if(!isset($datas[$bln]['jml'])){
									$datas[$bln] = [
										'jml'=>'',
										// 'expert'=>'',
										// 'persen'=>'',
									];
								}
								// if(!isset($datas[$bln]['exam'])){
								// 	$datax[$bln] = [
								// 		'exam'=>'',
								// 		'expert'=>'',
								// 		'persen'=>0,
								// 	];
									
								// }
							}
						}
					}
					array_push($data['hasil'],[$datas]);
					// array_push($data['hasil'],[$datax]);
					
					
					
				}

				
				array_push($result,
				$data);

				
			}
		//}
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		// die();

		// $convert = [
		// 	[
		// 		'modality'=>'Radiography',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'modality'=>'Radiologi',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	]
		// ];
		// echo '<pre>';
		// var_dump($convert);
		// echo '</pre>';
		// die();
		if($tampil_per_2==''){
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($result);
			return;
		}
		return $result;
	}

	public function lap_bhp_detail_bln($date) {
		header('Content-Type: application/json; charset=utf-8');
		$hasil = $this->Radmlaporan->get_bhp_per_bulan($date)->result();
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['nama_bhp'] = $value->nama_bhp;
			$row2['jml'] = $value->jml;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		// var_dump($line['data']);die();
		echo json_encode($line);
	}

	public function excel_lap_bhp_detail_bln($date) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama BHP');
		$sheet->setCellValue('C1', 'Jumlah');
		// $sheet->setCellValue('D1', 'Nama');
		// $sheet->setCellValue('E1', 'No Medrec');
		// $sheet->setCellValue('F1', 'Asal');
		// $sheet->setCellValue('G1', 'Kelamin');
		// $sheet->setCellValue('H1', 'Jaminan');
		// $sheet->setCellValue('I1', 'Umur');
		// $sheet->setCellValue('J1', 'Nama BHP');
		// $sheet->setCellValue('K1', 'Satuan');
		// $sheet->setCellValue('L1', 'Kategori');
		// $sheet->setCellValue('M1', 'Qty');
						
		$data['data_laporan'] = $this->Radmlaporan->get_bhp_per_bulan($date)->result();
		$no = 1;
		$x = 2;
		
		foreach($data['data_laporan'] as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nama_bhp);
			$sheet->setCellValue('C'.$x, $row->jml);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan BHP Detail Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_bhp_detail_thn($date='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama BHP');
		$sheet->setCellValue('C1', 'Januari');
		$sheet->setCellValue('D1', 'Febuari');
		$sheet->setCellValue('E1', 'Maret');
		$sheet->setCellValue('F1', 'April');
		$sheet->setCellValue('G1', 'Mei');
		$sheet->setCellValue('H1', 'Juni');
		$sheet->setCellValue('I1', 'Juli');
		$sheet->setCellValue('J1', 'Agustus');
		$sheet->setCellValue('K1', 'September');
		$sheet->setCellValue('L1', 'Oktober');
		$sheet->setCellValue('M1', 'November');
		$sheet->setCellValue('N1', 'Desember');
		
		// $hasil=$this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($date)->result();
		$hasil = $this->lap_bhp_detail_mod('THN',$date);
		$no = 1;
		$x = 2;
		//$persen = 0;
		foreach($hasil as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row['nama_bhp']);

			foreach($row['hasil'] as $v){
				if(isset($v[0]['JANUARI'])){
					$jml = $v[0]['JANUARI']['jml']?($v[0]['JANUARI']['jml']!='0'?($v[0]['JANUARI']['jml']):0):0;
					$sheet->setCellValue('C'.$x, $jml);
				}
				if(isset($v[0]['FEBUARI'])){
					$jml = $v[0]['FEBUARI']['jml']?($v[0]['FEBUARI']['jml']!='0'?($v[0]['FEBUARI']['jml']):0):0;
					$sheet->setCellValue('D'.$x, $jml);
				}
				if(isset($v[0]['MARET'])){
					$jml = $v[0]['MARET']['jml']?($v[0]['MARET']['jml']!='0'?($v[0]['MARET']['jml']):0):0;
					$sheet->setCellValue('E'.$x, $jml);
				}
				if(isset($v[0]['APRIL'])){
					$jml = $v[0]['APRIL']['jml']?($v[0]['APRIL']['jml']!='0'?($v[0]['APRIL']['jml']):0):0;
					$sheet->setCellValue('F'.$x, $jml);
				}
				if(isset($v[0]['MEI'])){
					$jml = $v[0]['MEI']['jml']?($v[0]['MEI']['jml']!='0'?($v[0]['MEI']['jml']):0):0;
					$sheet->setCellValue('G'.$x, $jml);
				}
				if(isset($v[0]['JUNI'])){
					$jml = $v[0]['JUNI']['jml']?($v[0]['JUNI']['jml']!='0'?($v[0]['JUNI']['jml']):0):0;
					$sheet->setCellValue('H'.$x, $jml);
				}
				
				if(isset($v[0]['JULI'])){
					$jml = $v[0]['JULI']['jml']?($v[0]['JULI']['jml']!='0'?($v[0]['JULI']['jml']):0):0;
					$sheet->setCellValue('I'.$x, $jml);
				}
				if(isset($v[0]['AGUSTUS'])){
					$jml = $v[0]['AGUSTUS']['jml']?($v[0]['AGUSTUS']['jml']!='0'?($v[0]['AGUSTUS']['jml']):0):0;
					$sheet->setCellValue('J'.$x, $jml);
				}
				if(isset($v[0]['SEPTEMBER'])){
					$jml = $v[0]['SEPTEMBER']['jml']?($v[0]['SEPTEMBER']['jml']!='0'?($v[0]['SEPTEMBER']['jml']):0):0;
					$sheet->setCellValue('K'.$x, $jml);
				}
				if(isset($v[0]['OKTOBER'])){
					$jml = $v[0]['OKTOBER']['jml']?($v[0]['OKTOBER']['jml']!='0'?($v[0]['OKTOBER']['jml']):0):0;
					$sheet->setCellValue('L'.$x, $jml);
				}
				if(isset($v[0]['NOVEMBER'])){
					$jml = $v[0]['NOVEMBER']['jml']?($v[0]['NOVEMBER']['jml']!='0'?($v[0]['NOVEMBER']['jml']):0):0;
					$sheet->setCellValue('M'.$x, $jml);
				}
				if(isset($v[0]['DESEMBER'])){
					$jml = $v[0]['DESEMBER']['jml']?($v[0]['DESEMBER']['jml']!='0'?($v[0]['DESEMBER']['jml']):0):0;
					$sheet->setCellValue('N'.$x, $jml);
				}
			}
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan BHP detail Radiologi '.$date;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_amprah_rad() {
		$data['title'] = 'Laporan Amprah Radiologi';
		$this->load->view('rad/radvlap_amprah', $data);
	}

	public function lap_amprah_rad_mod($date1,$date2) {
		header('Content-Type: application/json; charset=utf-8');
		$hasil = $this->Radmlaporan->get_lap_amprah_rad($date1, $date2)->result();
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['nama_obat'] = $value->nm_obat;
			$row2['qty_req'] = $value->qty_req;
			$row2['qty_acc'] = $value->qty_acc;
			$row2['peminta'] = $value->peminta;
			$row2['tujuan'] = $value->tujuan;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		// var_dump($line['data']);die();
		echo json_encode($line);
	}

	public function excel_lap_amprah_rad($date1, $date2) {
		$tgl1 = date("d F Y", strtotime($date1));
		$tgl2 = date("d F Y", strtotime($date2));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Obat');
		$sheet->setCellValue('C1', 'QTY Request');
		$sheet->setCellValue('D1', 'QTY Acc');
		$sheet->setCellValue('E1', 'Peminta');
		$sheet->setCellValue('F1', 'Gudang Tujuan');

		$data['data_laporan'] = $this->Radmlaporan->get_lap_amprah_rad($date1, $date2)->result();
		$no = 1;
		$x = 2;
		
		foreach($data['data_laporan'] as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nm_obat);
			$sheet->setCellValue('C'.$x, $row->qty_req);
			$sheet->setCellValue('D'.$x, $row->qty_acc);
			$sheet->setCellValue('E'.$x, $row->peminta);
			$sheet->setCellValue('F'.$x, $row->tujuan);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Amprah Radiologi '.$tgl1.' - '.$tgl2;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_jml_expert() {
		$data['title'] = 'Laporan Pemeriksaan Radiologi';
		//$date0=$this->input->post('date0');
		//$date1=$this->input->post('date1');
		//$data['tindakan'] = $this->Radmlaporan->get_tindakan()->result();
		//$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		//var_dump($data['data_pemeriksaan']); die();
		$this->load->view('rad/radvlapjmlexpert',$data);
	}

	/// added buat pencarian lap jml expert
	public function lap_jml_expert_mod($tampil_per_2='',$data2='')
	{
		$tampil_per = $tampil_per_2==''?$this->input->get('tampil_per'):$tampil_per_2;
		$data = $data2==''?$this->input->get('data'):$data2; 
		if($tampil_per == 'BLN') {
			$hasil = $this->Radmlaporan->get_jml_pemeriksaan_expert_bln($data)->result();
		} else if($tampil_per == 'THN') {
			$hasil = $this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($data)->result();		
		}
		$modality = [];
		$result = [];
		$bulan = [];
		$persen = 0;
		foreach($hasil as $val){
			if(!in_array($val->modality,$modality))
			{
				array_push($modality,$val->modality);
			}
			if(!in_array($val->bulan,$bulan))
			{
				array_push($bulan,$val->bulan);
			}
		}

		//if(!empty(aa$modality)) {
			foreach($modality as $mod)
			{
				$data = [
					'modality'=>$mod,
					'hasil'=>[]
				];
				foreach($bulan as $bln)
				{
					
					$datas=[];
					$datax = [];
					foreach($hasil as $val){
						if($val->modality == $mod){
							if($val->bulan == $bln){
								//$rumus = $val->jml_exam == '0' || $val->jml_exam == null || $val->jml_expert == '0' || $val->jml_expert == null ? '0':(($val->jml_exam?0:intval($val->jml_exam)) / ($val->jml_expert?0:intval($val->jml_expert)) * 100);
								$datas[$bln] = [
									'exam'=>$val->jml_exam,
									'expert'=>$val->jml_expert,
									'persen'=>0,
								];
							}
						}
						if($val->modality == $mod){
							if($val->bulan != $bln){
								if(!isset($datas[$bln]['exam'])){
									$datas[$bln] = [
										'exam'=>'',
										'expert'=>'',
										'persen'=>'',
									];
								}
								// if(!isset($datas[$bln]['exam'])){
								// 	$datax[$bln] = [
								// 		'exam'=>'',
								// 		'expert'=>'',
								// 		'persen'=>0,
								// 	];
									
								// }
							}
						}
					}
					array_push($data['hasil'],[$datas]);
					// array_push($data['hasil'],[$datax]);
					
					
					
				}

				
				array_push($result,
				$data);

				
			}
		//}
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		// die();

		// $convert = [
		// 	[
		// 		'modality'=>'Radiography',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'modality'=>'Radiologi',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	]
		// ];
		// echo '<pre>';
		// var_dump($convert);
		// echo '</pre>';
		// die();
		if($tampil_per_2==''){
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($result);
			return;
		}
		return $result;
	}

	public function lap_penerimaan_thn($tampil_per_2='',$data2='') {
		$tampil_per = $tampil_per_2==''?$this->input->get('tampil_per'):$tampil_per_2;
		$data = $data2==''?$this->input->get('data'):$data2; 
		if($tampil_per == 'BLN') {
			$hasil = $this->Radmlaporan->get_penerimaan_bln($data)->result();
		} else if($tampil_per == 'THN') {
			$hasil = $this->Radmlaporan->get_penerimaan_thn($data)->result();		
		}
		$modality = [];
		$result = [];
		$bulan = [];
		$total_bln = 0;
		foreach($hasil as $val){
			if(!in_array($val->bulan,$bulan))
			{
				array_push($bulan,$val->bulan);
			}
			if(!in_array($val->modality,$modality))
			{
				array_push($modality,$val->modality);
			}
		}

		//if(!empty(aa$modality)) {
			foreach($bulan as $mon)
			{
				$data = [
					'bulan'=>$mon,
					'hasil'=>[]
				];
				foreach($modality as $mod)
				{
					
					$datas=[];
					$datax = [];
					foreach($hasil as $val){
						if($val->bulan == $mon){
							//var_dump($val->ct_bpjs); die();
							// $total_bln = $total_bln + ($val->ct_bpjs + $val->ct_umum + $val->mr_bpjs + $val->mr_umum + $val->us_bpjs + $val->us_umum + $val->la_bpjs + $val->la_umum + $val->cr_bpjs + $val->cr_umum); 
							// $datas[$mon] = [
							// 	'total_bln'=>number_format($total_bln,0,'.','')
							// ];
							if($val->modality == $mod){
								//$total_per_bln = $val->ct_bpjs + $val->ct_umum + $val->mr_bpjs + $val->mr_umum + $val->us_bpjs + $val->us_umum + $val->la_bpjs + $val->la_umum + $val->cr_bpjs + $val->cr_umum +
								//$rumus = $val->jml_exam == '0' || $val->jml_exam == null || $val->jml_expert == '0' || $val->jml_expert == null ? '0':(($val->jml_exam?0:intval($val->jml_exam)) / ($val->jml_expert?0:intval($val->jml_expert)) * 100);
								$datas[$mod] = [
									'mr_bpjs'=>number_format($val->mr_bpjs,0,'.',''), //2, ',', '.'
									'ct_bpjs'=>number_format($val->ct_bpjs,0,'.','' ),
									'la_bpjs'=>number_format($val->la_bpjs,0,'.',''),
									'us_bpjs'=>number_format($val->us_bpjs,0,'.',''),
									'cr_bpjs'=>number_format($val->cr_bpjs,0,'.',''),
									'mr_umum'=>number_format($val->mr_umum,0,'.',''),
									'ct_umum'=>number_format($val->ct_umum,0,'.',''),
									'la_umum'=>number_format($val->la_umum,0,'.',''),
									'us_umum'=>number_format($val->us_umum,0,'.',''),
									'cr_umum'=>number_format($val->cr_umum,0,'.',''),
									'total_bln'=>number_format($val->total_bln,0,'.',''),
									//'total_bln'=>number_format($val->ct_bpjs + $val->ct_umum + $val->mr_bpjs + $val->mr_umum + $val->us_bpjs + $val->us_umum + $val->la_bpjs + $val->la_umum + $val->cr_bpjs + $val->cr_umum,0,'.',''),
								];
							}
						}
						if($val->bulan == $mon){
							if($val->modality != $mod){
								if(!isset($datas[$mod]['mr_bpjs'])){
									$datas[$mod] = [
										'mr_bpjs'=>'',
										'ct_bpjs'=>'',
										'la_bpjs'=>'',
										'us_bpjs'=>'',
										'cr_bpjs'=>'',
										'mr_umum'=>'',
										'ct_umum'=>'',
										'la_umum'=>'',
										'us_umum'=>'',
										'cr_umum'=>'',
										//'total_bln'=>'',
									];
								}
								// if(!isset($datas[$bln]['exam'])){
								// 	$datax[$bln] = [
								// 		'exam'=>'',
								// 		'expert'=>'',
								// 		'persen'=>0,
								// 	];
									
								// }
							}
						}
					}
					array_push($data['hasil'],[$datas]);
					// array_push($data['hasil'],[$datax]);
					
					
					
				}

				
				array_push($result,
				$data);

				
			}
		//}
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		// die();

		// $convert = [
		// 	[
		// 		'modality'=>'Radiography',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	],
		// 	[
		// 		'modality'=>'Radiologi',
		// 		'hasil'=>[
		// 			'january'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			],
		// 			'Februari'=>[
		// 				'exam'=>'123',
		// 				'expert'=>'123',
		// 				'persen'=>'10%',
		// 			]
		// 		]
		// 	]
		// ];
		// echo '<pre>';
		// var_dump($convert);
		// echo '</pre>';
		// die();
		if($tampil_per_2==''){
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($result);
			return;
		}
		return $result;
	}

	public function lap_jml_expert_mod_bln($date) {
		
		$hasil = $this->Radmlaporan->get_jml_pemeriksaan_expert_bln($date)->result();
		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		$persen = 0;
		foreach ($hasil as $value) {
			//$rumus = $value->jml_exam == "0" || $value->jml_exam == null || $value->jml_expert == "0" || $value->jml_expert == null ? "0":(($value->jml_exam?0:intval($value->jml_exam)) / ($value->jml_expert?0:intval($value->jml_expert)) * 100);
			$rumus = $value->jml_expert?($value->jml_expert!='0'?(($value->jml_expert / $value->jml_exam) * 100):0):0;
			$row2['no'] = $i++;
			$row2['modality'] = $value->modality;
			$row2['exam'] = $value->jml_exam;
			$row2['expert'] = $value->jml_expert;
			$row2['persen'] = $persen + $rumus.'%';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function lap_jml_expert_exe() {
		$data['title'] = 'Laporan Pemeriksaan Radiologi';
		//$date0=$this->input->post('date0');
		//$date1=$this->input->post('date1');
		//$data['tindakan'] = $this->Radmlaporan->get_tindakan()->result();
		//$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		$tampil = $this->input->post('tampil_per');
		$data['tampil'] = $tampil;
		$bln = $this->input->post('date_picker_months');
		//$data['data_pemeriksaan'] = '';
		// 	$tgl = $this->input->post('date_picker_days');
		// 	$data['tgl'] = $tgl;
		// 	$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_tgl($tgl)->result();
		if($tampil == 'BLN') {
			$bln = $this->input->post('date_picker_months');
			$data['bln'] = $bln;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_jml_pemeriksaan_expert_bln($bln)->result();
			$this->load->view('rad/radvlapjmlexpert_bln',$data);
		} else if($tampil == 'THN') {
			$bln = $this->input->post('date_picker_years');
			$data['thn'] = $thn;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($thn)->result();
			$this->load->view('rad/radvlapjmlexpert_thn',$data);
		
		} 
	}

	public function lap_penerimaan_per_kelas() {
		$data['title'] = 'Laporan Penerimaan Per kelas';
		$this->load->view('rad/radvpenerimaan_per_kelas', $data);  
	}

	public function lap_penerimaan_per_kelas_nonri() {
		$data['title'] = 'Laporan Penerimaan Per kelas Rawat Jalan/IGD/Luar';
		$this->load->view('rad/radvpenerimaan_per_kelas_nonri', $data); 
	}

	public function lap_penerimaan_per_kelas_mod_nonri($date, $modality) {
		$hasil = $this->Radmlaporan->get_penerimaan_per_kelas_nonri($date, $modality)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;

		foreach($hasil as $value) {
			$total_umum_rj = $value->total_umum_rj?($value->total_umum_rj!='0'?($value->total_umum_rj):0):0;
			if($total_umum_rj == 0 && $value->jml_tindakan_umum_rj == 0) {
				$sat_umum_rj = 0;
			} else {
				$sat_umum_rj = $total_umum_rj / $value->jml_tindakan_umum_rj;
			}
			$total_bpjs_rj = $value->total_bpjs_rj?($value->total_bpjs_rj!='0'?($value->total_bpjs_rj):0):0;
			if($total_bpjs_rj == 0 && $value->jml_tindakan_bpjs_rj == 0) {
				$sat_bpjs_rj = 0;
			} else {
				$sat_bpjs_rj = $total_bpjs_rj / $value->jml_tindakan_bpjs_rj;
			}
			$total_bpjs_luar = $value->total_bpjs_luar?($value->total_bpjs_luar!='0'?($value->total_bpjs_luar):0):0;
			if($total_bpjs_luar == 0 && $value->jml_tindakan_bpjs_luar == 0) {
				$sat_bpjs_luar = 0;
			} else {
				$sat_bpjs_luar = $total_bpjs_luar / $value->jml_tindakan_bpjs_luar;
			}
			$total_umum_luar = $value->total_umum_luar?($value->total_umum_luar!='0'?($value->total_umum_luar):0):0;
			if($total_umum_luar == 0 && $value->jml_tindakan_umum_luar == 0) {
				$sat_umum_luar = 0;
			} else {
				$sat_umum_luar = $total_umum_luar / $value->jml_tindakan_umum_luar;
			}
			$total_bpjs_rd = $value->total_bpjs_rd?($value->total_bpjs_rd!='0'?($value->total_bpjs_rd):0):0;
			if($total_bpjs_rd == 0 && $value->jml_tindakan_bpjs_rd == 0) {
				$sat_bpjs_rd = 0;
			} else {
				$sat_bpjs_rd = $total_bpjs_rd / $value->jml_tindakan_bpjs_rd;
			}
			$total_umum_rd = $value->total_umum_rd?($value->total_umum_rd!='0'?($value->total_umum_rd):0):0;
			if($total_umum_rd == 0 && $value->jml_tindakan_umum_rd == 0) {
				$sat_umum_rd = 0;
			} else {
				$sat_umum_rd = $total_umum_rd / $value->jml_tindakan_umum_rd;
			}

			$row2['no'] = $i++;
			$row2['jenis_tindakan'] = $value->nmtindakan;
			$row2['jml_umum_rj'] = $value->jml_tindakan_umum_rj;
			$row2['sat_umum_rj'] = number_format($sat_umum_rj);
			$row2['total_umum_rj'] = number_format($total_umum_rj);
			$row2['jml_bpjs_rj'] = $value->jml_tindakan_bpjs_rj;
			$row2['sat_bpjs_rj'] = number_format($sat_bpjs_rj);
			$row2['total_bpjs_rj'] = number_format($total_bpjs_rj);
			$row2['jml_umum_luar'] = $value->jml_tindakan_umum_luar;
			$row2['sat_umum_luar'] = number_format($sat_umum_luar);
			$row2['total_umum_luar'] = number_format($total_umum_luar);
			$row2['jml_bpjs_luar'] = $value->jml_tindakan_bpjs_luar;
			$row2['sat_bpjs_luar'] = number_format($sat_bpjs_luar);
			$row2['total_bpjs_luar'] = number_format($total_bpjs_luar);
			$row2['jml_umum_rd'] = $value->jml_tindakan_umum_rd;
			$row2['sat_umum_rd'] = number_format($sat_umum_rd);
			$row2['total_umum_rd'] = number_format($total_umum_rd);
			$row2['jml_bpjs_rd'] = $value->jml_tindakan_bpjs_rd;
			$row2['sat_bpjs_rd'] = number_format($sat_bpjs_rd);
			$row2['total_bpjs_rd'] = number_format($total_bpjs_rd);
			$line2[] = $row2;
		}

		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function lap_penerimaan_per_kelas_mod($date, $modality) {
		$hasil = $this->Radmlaporan->get_penerimaan_per_kelas($date, $modality)->result();
		//var_dump($hasil); die();
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$total_umum_vip = $value->total_umum_vip?($value->total_umum_vip!='0'?($value->total_umum_vip):0):0;
			if($total_umum_vip == 0 && $value->jml_tindakan_umum_vip == 0) {
				$sat_umum_vip = 0;
			} else {
				$sat_umum_vip = $total_umum_vip / $value->jml_tindakan_umum_vip;
			}
			$total_bpjs_vip = $value->total_bpjs_vip?($value->total_bpjs_vip!='0'?($value->total_bpjs_vip):0):0;
			if($total_bpjs_vip == 0 && $value->jml_tindakan_bpjs_vip == 0) {
				$sat_bpjs_vip = 0;
			} else {
				$sat_bpjs_vip = $total_bpjs_vip / $value->jml_tindakan_bpjs_vip;
			}
			$total_bpjs_hcu = $value->total_bpjs_hcu?($value->total_bpjs_hcu!='0'?($value->total_bpjs_hcu):0):0;
			if($total_bpjs_hcu == 0 && $value->jml_tindakan_bpjs_hcu == 0) {
				$sat_bpjs_hcu = 0;
			} else {
				$sat_bpjs_hcu = $total_bpjs_hcu / $value->jml_tindakan_bpjs_hcu;
			}
			$total_umum_hcu = $value->total_umum_hcu?($value->total_umum_hcu!='0'?($value->total_umum_hcu):0):0;
			if($total_umum_hcu == 0 && $value->jml_tindakan_umum_hcu == 0) {
				$sat_umum_hcu = 0;
			} else {
				$sat_umum_hcu = $total_umum_hcu / $value->jml_tindakan_umum_hcu;
			}
			$total_bpjs_1 = $value->total_bpjs_1?($value->total_bpjs_1!='0'?($value->total_bpjs_1):0):0;
			if($total_bpjs_1 == 0 && $value->jml_tindakan_bpjs_1 == 0) {
				$sat_bpjs_1 = 0;
			} else {
				$sat_bpjs_1 = $total_bpjs_1 / $value->jml_tindakan_bpjs_1;
			}
			$total_umum_1 = $value->total_umum_1?($value->total_umum_1!='0'?($value->total_umum_1):0):0;
			if($total_umum_1 == 0 && $value->jml_tindakan_umum_1 == 0) {
				$sat_umum_1 = 0;
			} else {
				$sat_umum_1 = $total_umum_1 / $value->jml_tindakan_umum_1;
			}
			$total_bpjs_2 = $value->total_bpjs_2?($value->total_bpjs_2!='0'?($value->total_bpjs_2):0):0;
			if($total_bpjs_2 == 0 && $value->jml_tindakan_bpjs_2 == 0) {
				$sat_bpjs_2 = 0;
			} else {
				$sat_bpjs_2= $total_bpjs_2 / $value->jml_tindakan_bpjs_2;
			}
			$total_umum_2 = $value->total_umum_2?($value->total_umum_2!='0'?($value->total_umum_2):0):0;
			if($total_umum_2 == 0 && $value->jml_tindakan_umum_2 == 0) {
				$sat_umum_2 = 0;
			} else {
				$sat_umum_2 = $total_umum_2 / $value->jml_tindakan_umum_2;
			}
			$total_bpjs_3 = $value->total_bpjs_3?($value->total_bpjs_3!='0'?($value->total_bpjs_3):0):0;
			if($total_bpjs_3 == 0 && $value->jml_tindakan_bpjs_3 == 0) {
				$sat_bpjs_3 = 0;
			} else {
				$sat_bpjs_3 = $total_bpjs_3 / $value->jml_tindakan_bpjs_3;
			}
			$total_umum_3 = $value->total_umum_3?($value->total_umum_3!='0'?($value->total_umum_3):0):0;
			if($total_umum_3 == 0 && $value->jml_tindakan_umum_3 == 0) {
				$sat_umum_3 = 0;
			} else {
				$sat_umum_3 = $total_umum_3 / $value->jml_tindakan_umum_3;
			}
			$total_bpjs_icu = $value->total_bpjs_icu?($value->total_bpjs_icu!='0'?($value->total_bpjs_icu):0):0;
			if($total_bpjs_icu == 0 && $value->jml_tindakan_bpjs_icu == 0) {
				$sat_bpjs_icu = 0;
			} else {
				$sat_bpjs_icu = $total_bpjs_icu / $value->jml_tindakan_bpjs_icu;
			}
			$total_umum_icu = $value->total_umum_icu?($value->total_umum_icu!='0'?($value->total_umum_icu):0):0;
			if($total_umum_icu == 0 && $value->jml_tindakan_umum_icu == 0) {
				$sat_umum_icu = 0;
			} else {
				$sat_umum_icu = $total_umum_icu / $value->jml_tindakan_umum_icu;
			}
			$row2['no'] = $i++;
			$row2['jenis_tindakan'] = $value->nmtindakan;
			$row2['jml_umum_vip'] = $value->jml_tindakan_umum_vip;
			$row2['sat_umum_vip'] = number_format($sat_umum_vip);
			$row2['total_umum_vip'] = number_format($total_umum_vip);
			$row2['jml_bpjs_vip'] = $value->jml_tindakan_bpjs_vip;
			$row2['sat_bpjs_vip'] = number_format($sat_bpjs_vip);
			$row2['total_bpjs_vip'] = number_format($total_bpjs_vip);
			$row2['jml_umum_hcu'] = $value->jml_tindakan_umum_hcu;
			$row2['sat_umum_hcu'] = number_format($sat_umum_hcu);
			$row2['total_umum_hcu'] = number_format($total_umum_hcu);
			$row2['jml_bpjs_hcu'] = $value->jml_tindakan_bpjs_hcu;
			$row2['sat_bpjs_hcu'] = number_format($total_bpjs_hcu);
			$row2['total_bpjs_hcu'] = number_format($total_bpjs_hcu);
			$row2['jml_umum_1'] = $value->jml_tindakan_umum_1;
			$row2['sat_umum_1'] = number_format($sat_umum_1);
			$row2['total_umum_1'] = number_format($total_umum_1);
			$row2['jml_bpjs_1'] = $value->jml_tindakan_bpjs_1;
			$row2['sat_bpjs_1'] = number_format($sat_bpjs_1);
			$row2['total_bpjs_1'] = number_format($total_bpjs_1);
			$row2['jml_umum_2'] = $value->jml_tindakan_umum_2;
			$row2['sat_umum_2'] = number_format($sat_umum_2);
			$row2['total_umum_2'] = number_format($total_umum_2);
			$row2['jml_bpjs_2'] = $value->jml_tindakan_bpjs_2;
			$row2['sat_bpjs_2'] = number_format($sat_bpjs_2);
			$row2['total_bpjs_2'] = number_format($total_bpjs_2);
			$row2['jml_umum_3'] = $value->jml_tindakan_umum_3;
			$row2['sat_umum_3'] = number_format($sat_umum_3);
			$row2['total_umum_3'] = number_format($total_umum_3);
			$row2['jml_bpjs_3'] = $value->jml_tindakan_bpjs_3;
			$row2['sat_bpjs_3'] = number_format($sat_bpjs_3);
			$row2['total_bpjs_3'] = number_format($total_bpjs_3);
			$row2['jml_umum_icu'] = $value->jml_tindakan_umum_icu;
			$row2['sat_umum_icu'] = number_format($sat_umum_icu);
			$row2['total_umum_icu'] = number_format($total_umum_icu);
			$row2['jml_bpjs_icu'] = $value->jml_tindakan_bpjs_icu;
			$row2['sat_bpjs_icu'] = number_format($sat_bpjs_icu);
			$row2['total_bpjs_icu'] = number_format($total_bpjs_icu);
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_penerimaan_per_kelas($date, $modality) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A3')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B3')
			->getCell('B1')
			->setValue('Jenis Tindakan');
		$sheet->mergeCells('C1:H1')
			->getCell('C1')
			->setValue('VIP');
		$sheet->mergeCells('I1:N1')
			->getCell('I1')
			->setValue('HCU');
		$sheet->mergeCells('O1:T1')
			->getCell('O1')
			->setValue('Kelas I');
		$sheet->mergeCells('U1:Z1')
			->getCell('U1')
			->setValue('Kelas 2');
		$sheet->mergeCells('AA1:AF1')
			->getCell('AA1')
			->setValue('Kelas 3');
		$sheet->mergeCells('AG1:AL1')
			->getCell('AG1')
			->setValue('ICU');
		$sheet->mergeCells('C2:E2')
			->getCell('C2')
			->setValue('UMUM');
		$sheet->mergeCells('F2:H2')
			->getCell('F2')
			->setValue('BPJS');
		$sheet->mergeCells('I2:K2')
			->getCell('I2')
			->setValue('UMUM');
		$sheet->mergeCells('L2:N2')
			->getCell('L2')
			->setValue('BPJS');
		$sheet->mergeCells('O2:Q2')
			->getCell('O2')
			->setValue('UMUM');
		$sheet->mergeCells('R2:T2')
			->getCell('R2')
			->setValue('BPJS');
		$sheet->mergeCells('U2:W2')
			->getCell('U2')
			->setValue('UMUM');
		$sheet->mergeCells('X2:Z2')
			->getCell('X2')
			->setValue('BPJS');
		$sheet->mergeCells('AA2:AC2')
			->getCell('AA2')
			->setValue('UMUM');
		$sheet->mergeCells('AD2:AF2')
			->getCell('AD2')
			->setValue('BPJS');
		$sheet->mergeCells('AG2:AI2')
			->getCell('AG2')
			->setValue('UMUM');
		$sheet->mergeCells('AJ2:AL2')
			->getCell('AJ2')
			->setValue('BPJS');
		$sheet->setCellValue('C3', 'JML');
		$sheet->setCellValue('D3', 'Tarif');
		$sheet->setCellValue('E3', 'Penerimaan');
		$sheet->setCellValue('F3', 'JML');
		$sheet->setCellValue('G3', 'Tarif');
		$sheet->setCellValue('H3', 'Penerimaan');
		$sheet->setCellValue('I3', 'JML');
		$sheet->setCellValue('J3', 'Tarif');
		$sheet->setCellValue('K3', 'Penerimaan');
		$sheet->setCellValue('L3', 'JML');
		$sheet->setCellValue('M3', 'Tarif');
		$sheet->setCellValue('N3', 'Penerimaan');
		$sheet->setCellValue('O3', 'JML');
		$sheet->setCellValue('P3', 'Tarif');
		$sheet->setCellValue('Q3', 'Penerimaan');
		$sheet->setCellValue('R3', 'JML');
		$sheet->setCellValue('S3', 'Tarif');
		$sheet->setCellValue('T3', 'Penerimaan');
		$sheet->setCellValue('U3', 'JML');
		$sheet->setCellValue('V3', 'Tarif');
		$sheet->setCellValue('W3', 'Penerimaan');
		$sheet->setCellValue('X3', 'JML');
		$sheet->setCellValue('Y3', 'Tarif');
		$sheet->setCellValue('Z3', 'Penerimaan');
		$sheet->setCellValue('AA3', 'JML');
		$sheet->setCellValue('AB3', 'Tarif');
		$sheet->setCellValue('AC3', 'Penerimaan');
		$sheet->setCellValue('AD3', 'JML');
		$sheet->setCellValue('AE3', 'Tarif');
		$sheet->setCellValue('AF3', 'Penerimaan');
		$sheet->setCellValue('AG3', 'JML');
		$sheet->setCellValue('AH3', 'Tarif');
		$sheet->setCellValue('AI3', 'Penerimaan');
		$sheet->setCellValue('AJ3', 'JML');
		$sheet->setCellValue('AK3', 'Tarif');
		$sheet->setCellValue('AL3', 'Penerimaan');
						
		$data['data_laporan'] = $this->Radmlaporan->get_penerimaan_per_kelas($date, $modality)->result();
	
		$no = 1;
		$x = 4;
		
		foreach($data['data_laporan'] as $row)
		{
			$total_umum_vip = $row->total_umum_vip?($row->total_umum_vip!='0'?($row->total_umum_vip):0):0;
			if($total_umum_vip == 0 && $row->jml_tindakan_umum_vip == 0) {
				$sat_umum_vip = 0;
			} else {
				$sat_umum_vip = $total_umum_vip / $row->jml_tindakan_umum_vip;
			}
			$total_bpjs_vip = $row->total_bpjs_vip?($row->total_bpjs_vip!='0'?($row->total_bpjs_vip):0):0;
			if($total_bpjs_vip == 0 && $row->jml_tindakan_bpjs_vip == 0) {
				$sat_bpjs_vip = 0;
			} else {
				$sat_bpjs_vip = $total_bpjs_vip / $row->jml_tindakan_bpjs_vip;
			}
			$total_bpjs_hcu = $row->total_bpjs_hcu?($row->total_bpjs_hcu!='0'?($row->total_bpjs_hcu):0):0;
			if($total_bpjs_hcu == 0 && $row->jml_tindakan_bpjs_hcu == 0) {
				$sat_bpjs_hcu = 0;
			} else {
				$sat_bpjs_hcu = $total_bpjs_hcu / $row->jml_tindakan_bpjs_hcu;
			}
			$total_umum_hcu = $row->total_umum_hcu?($row->total_umum_hcu!='0'?($row->total_umum_hcu):0):0;
			if($total_umum_hcu == 0 && $row->jml_tindakan_umum_hcu == 0) {
				$sat_umum_hcu = 0;
			} else {
				$sat_umum_hcu = $total_umum_hcu / $row->jml_tindakan_umum_hcu;
			}
			$total_bpjs_1 = $row->total_bpjs_1?($row->total_bpjs_1!='0'?($row->total_bpjs_1):0):0;
			if($total_bpjs_1 == 0 && $row->jml_tindakan_bpjs_1 == 0) {
				$sat_bpjs_1 = 0;
			} else {
				$sat_bpjs_1 = $total_bpjs_1 / $row->jml_tindakan_bpjs_1;
			}
			$total_umum_1 = $row->total_umum_1?($row->total_umum_1!='0'?($row->total_umum_1):0):0;
			if($total_umum_1 == 0 && $row->jml_tindakan_umum_1 == 0) {
				$sat_umum_1 = 0;
			} else {
				$sat_umum_1 = $total_umum_1 / $row->jml_tindakan_umum_1;
			}
			$total_bpjs_2 = $row->total_bpjs_2?($row->total_bpjs_2!='0'?($row->total_bpjs_2):0):0;
			if($total_bpjs_2 == 0 && $row->jml_tindakan_bpjs_2 == 0) {
				$sat_bpjs_2 = 0;
			} else {
				$sat_bpjs_2= $total_bpjs_2 / $row->jml_tindakan_bpjs_2;
			}
			$total_umum_2 = $row->total_umum_2?($row->total_umum_2!='0'?($row->total_umum_2):0):0;
			if($total_umum_2 == 0 && $row->jml_tindakan_umum_2 == 0) {
				$sat_umum_2 = 0;
			} else {
				$sat_umum_2 = $total_umum_2 / $row->jml_tindakan_umum_2;
			}
			$total_bpjs_3 = $row->total_bpjs_3?($row->total_bpjs_3!='0'?($row->total_bpjs_3):0):0;
			if($total_bpjs_3 == 0 && $row->jml_tindakan_bpjs_3 == 0) {
				$sat_bpjs_3 = 0;
			} else {
				$sat_bpjs_3 = $total_bpjs_3 / $row->jml_tindakan_bpjs_3;
			}
			$total_umum_3 = $row->total_umum_3?($row->total_umum_3!='0'?($row->total_umum_3):0):0;
			if($total_umum_3 == 0 && $row->jml_tindakan_umum_3 == 0) {
				$sat_umum_3 = 0;
			} else {
				$sat_umum_3 = $total_umum_3 / $row->jml_tindakan_umum_3;
			}
			$total_bpjs_icu = $row->total_bpjs_icu?($row->total_bpjs_icu!='0'?($row->total_bpjs_icu):0):0;
			if($total_bpjs_icu == 0 && $row->jml_tindakan_bpjs_icu == 0) {
				$sat_bpjs_icu = 0;
			} else {
				$sat_bpjs_icu = $total_bpjs_icu / $row->jml_tindakan_bpjs_icu;
			}
			$total_umum_icu = $row->total_umum_icu?($row->total_umum_icu!='0'?($row->total_umum_icu):0):0;
			if($total_umum_icu == 0 && $row->jml_tindakan_umum_icu == 0) {
				$sat_umum_icu = 0;
			} else {
				$sat_umum_icu = $total_umum_icu / $row->jml_tindakan_umum_icu;
			}
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nmtindakan);
			$sheet->setCellValue('C'.$x, $row->jml_tindakan_umum_vip);
			$sheet->setCellValue('D'.$x, number_format($sat_umum_vip));
			$sheet->setCellValue('E'.$x, number_format($total_umum_vip));
			$sheet->setCellValue('F'.$x, $row->jml_tindakan_bpjs_vip);
			$sheet->setCellValue('G'.$x, number_format($sat_bpjs_vip));
			$sheet->setCellValue('H'.$x, number_format($total_bpjs_vip));
			$sheet->setCellValue('I'.$x, $row->jml_tindakan_umum_hcu);
			$sheet->setCellValue('J'.$x, number_format($sat_umum_hcu));
			$sheet->setCellValue('K'.$x, number_format($total_umum_hcu));
			$sheet->setCellValue('L'.$x, $row->jml_tindakan_bpjs_hcu);
			$sheet->setCellValue('M'.$x, number_format($sat_bpjs_hcu));
			$sheet->setCellValue('N'.$x, number_format($total_bpjs_hcu));
			$sheet->setCellValue('O'.$x, $row->jml_tindakan_umum_1);
			$sheet->setCellValue('P'.$x, number_format($sat_umum_1));
			$sheet->setCellValue('Q'.$x, number_format($total_umum_1));
			$sheet->setCellValue('R'.$x, $row->jml_tindakan_bpjs_1);
			$sheet->setCellValue('S'.$x, number_format($sat_bpjs_1));
			$sheet->setCellValue('T'.$x, number_format($total_bpjs_1));
			$sheet->setCellValue('U'.$x, $row->jml_tindakan_umum_2);
			$sheet->setCellValue('V'.$x, number_format($sat_umum_2));
			$sheet->setCellValue('W'.$x, number_format($total_umum_2));
			$sheet->setCellValue('X'.$x, $row->jml_tindakan_bpjs_2);
			$sheet->setCellValue('Y'.$x, number_format($sat_bpjs_2));
			$sheet->setCellValue('Z'.$x, number_format($total_bpjs_2));
			$sheet->setCellValue('AA'.$x, $row->jml_tindakan_umum_3);
			$sheet->setCellValue('AB'.$x, number_format($sat_umum_3));
			$sheet->setCellValue('AC'.$x, number_format($total_umum_3));
			$sheet->setCellValue('AD'.$x, $row->jml_tindakan_bpjs_3);
			$sheet->setCellValue('AE'.$x, number_format($sat_bpjs_3));
			$sheet->setCellValue('AF'.$x, number_format($total_bpjs_3));
			$sheet->setCellValue('AG'.$x, $row->jml_tindakan_umum_icu);
			$sheet->setCellValue('AH'.$x, number_format($sat_umum_icu));
			$sheet->setCellValue('AI'.$x, number_format($total_umum_icu));
			$sheet->setCellValue('AJ'.$x, $row->jml_tindakan_bpjs_icu);
			$sheet->setCellValue('AK'.$x, number_format($sat_bpjs_icu));
			$sheet->setCellValue('AL'.$x, number_format($total_bpjs_icu));
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Radiologi Per Kelas Rawat Inap '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_penerimaan_per_kelas_nonri($date, $modality) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A3')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B3')
			->getCell('B1')
			->setValue('Jenis Tindakan');
		$sheet->mergeCells('C1:H1')
			->getCell('C1')
			->setValue('POLI');
		$sheet->mergeCells('I1:N1')
			->getCell('I1')
			->setValue('LUAR');
		$sheet->mergeCells('O1:T1')
			->getCell('O1')
			->setValue('IGD');
		$sheet->mergeCells('C2:E2')
			->getCell('C2')
			->setValue('UMUM');
		$sheet->mergeCells('F2:H2')
			->getCell('F2')
			->setValue('BPJS');
		$sheet->mergeCells('I2:K2')
			->getCell('I2')
			->setValue('UMUM');
		$sheet->mergeCells('L2:N2')
			->getCell('L2')
			->setValue('BPJS');
		$sheet->mergeCells('O2:Q2')
			->getCell('O2')
			->setValue('UMUM');
		$sheet->mergeCells('R2:T2')
			->getCell('R2')
			->setValue('BPJS');
		$sheet->setCellValue('C3', 'JML');
		$sheet->setCellValue('D3', 'Tarif');
		$sheet->setCellValue('E3', 'Penerimaan');
		$sheet->setCellValue('F3', 'JML');
		$sheet->setCellValue('G3', 'Tarif');
		$sheet->setCellValue('H3', 'Penerimaan');
		$sheet->setCellValue('I3', 'JML');
		$sheet->setCellValue('J3', 'Tarif');
		$sheet->setCellValue('K3', 'Penerimaan');
		$sheet->setCellValue('L3', 'JML');
		$sheet->setCellValue('M3', 'Tarif');
		$sheet->setCellValue('N3', 'Penerimaan');
		$sheet->setCellValue('O3', 'JML');
		$sheet->setCellValue('P3', 'Tarif');
		$sheet->setCellValue('Q3', 'Penerimaan');
		$sheet->setCellValue('R3', 'JML');
		$sheet->setCellValue('S3', 'Tarif');
		$sheet->setCellValue('T3', 'Penerimaan');
						
		$data['data_laporan'] = $this->Radmlaporan->get_penerimaan_per_kelas_nonri($date, $modality)->result();
	
		$no = 1;
		$x = 4;
		
		foreach($data['data_laporan'] as $row) {
			$total_umum_rj = $row->total_umum_rj?($row->total_umum_rj!='0'?($row->total_umum_rj):0):0;
			if($total_umum_rj == 0 && $row->jml_tindakan_umum_rj == 0) {
				$sat_umum_rj = 0;
			} else {
				$sat_umum_rj = $total_umum_rj / $row->jml_tindakan_umum_rj;
			}
			$total_bpjs_rj = $row->total_bpjs_rj?($row->total_bpjs_rj!='0'?($row->total_bpjs_rj):0):0;
			if($total_bpjs_rj == 0 && $row->jml_tindakan_bpjs_rj == 0) {
				$sat_bpjs_rj = 0;
			} else {
				$sat_bpjs_rj = $total_bpjs_rj / $row->jml_tindakan_bpjs_rj;
			}
			$total_bpjs_luar = $row->total_bpjs_luar?($row->total_bpjs_luar!='0'?($row->total_bpjs_luar):0):0;
			if($total_bpjs_luar == 0 && $row->jml_tindakan_bpjs_luar == 0) {
				$sat_bpjs_luar = 0;
			} else {
				$sat_bpjs_luar = $total_bpjs_luar / $row->jml_tindakan_bpjs_luar;
			}
			$total_umum_luar = $row->total_umum_luar?($row->total_umum_luar!='0'?($row->total_umum_luar):0):0;
			if($total_umum_luar == 0 && $row->jml_tindakan_umum_luar == 0) {
				$sat_umum_luar = 0;
			} else {
				$sat_umum_luar = $total_umum_luar / $row->jml_tindakan_umum_luar;
			}
			$total_bpjs_rd = $row->total_bpjs_rd?($row->total_bpjs_rd!='0'?($row->total_bpjs_rd):0):0;
			if($total_bpjs_rd == 0 && $row->jml_tindakan_bpjs_rd == 0) {
				$sat_bpjs_rd = 0;
			} else {
				$sat_bpjs_rd = $total_bpjs_rd / $row->jml_tindakan_bpjs_rd;
			}
			$total_umum_rd = $row->total_umum_rd?($row->total_umum_rd!='0'?($row->total_umum_rd):0):0;
			if($total_umum_rd == 0 && $row->jml_tindakan_umum_rd == 0) {
				$sat_umum_rd = 0;
			} else {
				$sat_umum_rd = $total_umum_rd / $row->jml_tindakan_umum_rd;
			}

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->nmtindakan);
			$sheet->setCellValue('C'.$x, $row->jml_tindakan_umum_rj);
			$sheet->setCellValue('D'.$x, number_format($sat_umum_rj));
			$sheet->setCellValue('E'.$x, number_format($total_umum_rj));
			$sheet->setCellValue('F'.$x, $row->jml_tindakan_bpjs_rj);
			$sheet->setCellValue('G'.$x, number_format($sat_bpjs_rj));
			$sheet->setCellValue('H'.$x, number_format($total_bpjs_rj));
			$sheet->setCellValue('I'.$x, $row->jml_tindakan_umum_luar);
			$sheet->setCellValue('J'.$x, number_format($sat_umum_luar));
			$sheet->setCellValue('K'.$x, number_format($total_umum_luar));
			$sheet->setCellValue('L'.$x, $row->jml_tindakan_bpjs_luar);
			$sheet->setCellValue('M'.$x, number_format($sat_bpjs_luar));
			$sheet->setCellValue('N'.$x, number_format($total_bpjs_luar));
			$sheet->setCellValue('O'.$x, $row->jml_tindakan_umum_rd);
			$sheet->setCellValue('P'.$x, number_format($sat_umum_rd));
			$sheet->setCellValue('Q'.$x, number_format($total_umum_rd));
			$sheet->setCellValue('R'.$x, $row->jml_tindakan_bpjs_rd);
			$sheet->setCellValue('S'.$x, number_format($sat_bpjs_rd));
			$sheet->setCellValue('T'.$x, number_format($total_bpjs_rd));
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Radiologi Per Kelas (Non Rawat Inap) '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_waktu_tunggu() {
		$data['title'] = 'Laporan Kunjungan Radiologi';
		$data['radiografer'] = $this->radmdaftar->get_radiografer()->result();
		$date1 = date("Y-m-d");
		$date2 = date("Y-m-d");
		//$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua($date1, $date2)->result();
		$this->load->view('rad/radvwaktutunggu',$data);
	}

	public function lap_waktu_tunggu_exe($date1='',$date2='',$dokter='',$radiografer='', $igd='') {

		if($igd == 'semua') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		} else if ($igd == 'igd') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_igd($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas_igd($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter_igd($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua_igd($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		} else if ($igd == 'non_igd') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_non($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas_non($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter_non($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua_non($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		}
		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($data['data_laporan'] as $value) {
			$birthDate = new DateTime($value->tgl_lahir);
            $today = new DateTime("today");
            // if ($birthDate > $today) { 
            //     exit("0 tahun");
            // }
            $y = $today->diff($birthDate)->y;
			$row2['no'] = $i++;
			$row2['tgl_periksa'] = $value->tgl_periksa;
			$row2['jenis_tindakan'] = $value->jenis_tindakan;
			$row2['modality'] = $value->modality;
			$row2['asal'] = $value->asal;
			$row2['no_register'] = $value->no_register;
			$row2['no_cm'] = $value->no_cm;
			$row2['nama'] = $value->nama;
			$row2['umur'] = $y.' Tahun';
			$row2['kelamin'] = $value->kelamin;
			$row2['cara_bayar'] = $value->cara_bayar;
			$row2['alamat'] = $value->alamat;
			$row2['diagnosa'] = isset($value->diagnosa)?$value->diagnosa:'';
			$row2['radiografer'] = isset($value->radiografer)?$value->radiografer:'';
			$row2['nm_dokter'] = isset($value->nm_dokter)?$value->nm_dokter:'';
			$row2['waktu_periksa'] = isset($value->tgl_periksa)?$value->tgl_periksa:'';
			$row2['selesai_periksa'] = isset($value->selesai_periksa)?$value->selesai_periksa:'';
			$row2['selesai_expert'] = isset($value->selesai_expert)?$value->selesai_expert:'';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
		//var_dump($data['radiografer']);die();
		//$this->load->view('rad/radvwaktutunggu',$data);
	}

	public function excel_lap_waktu_tunggu($date1='',$date2='',$dokter='',$radiografer='', $igd='') {
		$tgl1 = date("d-m-Y", strtotime($date1));
		$tgl2 = date("d-m-Y", strtotime($date2));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Periksa');
		$sheet->setCellValue('C1', 'Nama Pemeriksaan');
		$sheet->setCellValue('D1', 'Modality');
		$sheet->setCellValue('E1', 'Asal');
		$sheet->setCellValue('F1', 'No Register');
		$sheet->setCellValue('G1', 'No MR');
		$sheet->setCellValue('H1', 'Nama');
		$sheet->setCellValue('I1', 'Umur');
		$sheet->setCellValue('J1', 'Kelamin');
		$sheet->setCellValue('K1', 'Jaminan');
		$sheet->setCellValue('L1', 'Alamat');
		$sheet->setCellValue('M1', 'Diagnosa');
		$sheet->setCellValue('N1', 'Radiografer');
		$sheet->setCellValue('O1', 'Dokter Radiologi');
		$sheet->setCellValue('P1', 'Waktu Periksa');
		$sheet->setCellValue('Q1', 'Selesai Periksa');
		$sheet->setCellValue('R1', 'Selesai Expertise');
						
		if($igd == 'semua') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		} else if ($igd == 'igd') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_igd($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas_igd($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter_igd($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua_igd($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		} else if ($igd == 'non_igd') {
			if($dokter == 'semua') {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_non($date1, $date2)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_dokter_pilih_petugas_non($date1, $date2, $radiografer)->result();
				}
			} else {
				if($radiografer == 'semua') {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_semua_petugas_pilih_dokter_non($date1, $date2, $dokter)->result();
				} else {
					$data['data_laporan'] = $this->Radmlaporan->get_waktu_tunggu_pilih_dua_non($date1, $date2, $dokter, $radiografer)->result();
				}
			}
		}
	
		$no = 1;
		$x = 2;
		
		foreach($data['data_laporan'] as $row)
		{
			$birthDate = new DateTime($row->tgl_lahir);
            $today = new DateTime("today");
            // if ($birthDate > $today) { 
            //     exit("0 tahun");
            // }
            $y = $today->diff($birthDate)->y;
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->tgl_periksa);
			$sheet->setCellValue('C'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('D'.$x, $row->modality);
			$sheet->setCellValue('E'.$x, $row->asal);
			$sheet->setCellValue('F'.$x, $row->no_register);
			$sheet->setCellValue('G'.$x, $row->no_cm);
			$sheet->setCellValue('H'.$x, $row->nama);
			$sheet->setCellValue('I'.$x, $y.' Tahun');
			$sheet->setCellValue('J'.$x, $row->kelamin);
			$sheet->setCellValue('K'.$x, $row->cara_bayar);
			$sheet->setCellValue('L'.$x, $row->alamat);
			$sheet->setCellValue('M'.$x, $row->diagnosa);
			$sheet->setCellValue('N'.$x, $row->radiografer);
			$sheet->setCellValue('O'.$x, $row->nm_dokter);
			$sheet->setCellValue('P'.$x, $row->tgl_periksa);
			$sheet->setCellValue('Q'.$x, $row->selesai_periksa);
			$sheet->setCellValue('R'.$x, $row->selesai_expert);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Waktu Tunggu Radiologi '.$tgl1.' - '.$tgl2;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Radiologi';
		$data['pemeriksaan_title']="Laporan per Pemeriksaan :";

		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');				
				// $tgl_indo=new Tglindo();
				if($tampil_per=='TGL'){
					//$tgl_awal=$this->input->post('date_picker_days1');
					//if(){
					//}
					$tgl=$this->input->post('date_picker_days');					
					
					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_by_date($tgl)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_tgl($tgl)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_tgl($tgl)->result();
					$tgl1 = date('d F Y', strtotime($tgl));
					$data['date_title']="Laporan Kunjungan Pasien Radiologi <b>$tgl1</b>";
					$data['field1']='No. Medrec';					
					$data['tgl']=$tgl;
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');

					
					//echo $this->input->post('date_picker_months');

					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_bln($bln)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_bln($bln)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_bln($bln)->result();
					
					$bln1 = date('F Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $bln2;
					$data['date_title']="Laporan Kunjungan Pasien Radiologi per Hari <b>Bulan $bln3</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
					$data['field1']='Tanggal';					
					$data['date']=$bln;//untuk param waktu cetak
					$data['bln']=$bln;
					//print_r($bln2);
				}else{
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_thn($thn)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_thn($thn)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_thn($thn)->result();
					
					$data['date_title']="Laporan Kunjungan Pasien Radiologi <b>Tahun $thn</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					// $data['tgl_indo']=$tgl_indo;
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
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('rad/radvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan()->result();
			$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan()->result();
			$data['date_title']='Laporan Kunjungan Pasien Radiologi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';
			$data['tampil_per']='TGL';		
			
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

			$this->load->view('rad/radvlapkunjunganrange.php',$data);
		}
	}

	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Penunjang Radiologi';				

		// $tgl_indo=new Tglindo();
		// if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$tampil_per=$this->input->post('tampil_per');			
		// 		if($tampil_per=='TGL'){
		// 			$tgl=$this->input->post('date_picker_days');
		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
		// 			$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
		// 			$data['cara_bayar_pasien']="";
		// 			$tgl1= date('d F Y', strtotime($tgl));
					
		// 			$data['date_title']="<b>$tgl1</b>";
		// 			$data['field1']='No. Register';
		// 			$data['tgl']=$tgl;
					
		// 		}else if($tampil_per=='BLN'){
		// 			$bln=$this->input->post('date_picker_months');			

		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_bln($bln)->result();

		// 			$cara_bayar=$this->input->post('jenis_pasien1');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien1');			
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_bln($bln)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
		// 			}
		// 			$bln1 = date('Y', strtotime($bln));
		// 			$bln2 = date('m', strtotime($bln));
		// 			$bln3 = $tgl_indo->bulan($bln2);
		// 			//echo $tgl_indo->bulan('08');
		// 			$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
		// 			$data['field1']='Tanggal';
		// 			$data['tgl']=$bln3;
		// 			$data['bln']=$bln;
		// 			$data['date']=$bln;//untuk param waktu cetak

		// 		}else{					
					
		// 			$thn=$this->input->post('date_picker_years');
		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien2');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien2');		
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_thn($thn)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)->result();
		// 			}
		// 			$data['date_title']="per Bulan <b> Tahun $thn</b>";
		// 			$data['field1']='Bulan';
		// 			$data['date']=$thn;//untuk param waktu cetak
		// 			$data['thn']=$thn;
		// 			$data['tgl_indo']=$tgl_indo;
		// 		}
		// 		$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
		// 		$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('rad/pend_today',$data);
		// }else{			
		// 	$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tindakan_today()->result();
		// 	$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_today()->result();
		// 	$data['date_title']='<b>'.date("d F Y").'</b>';
		// 	$data['tgl']=date("Y-m-d");
		// 	$data['field1']='No. Register';
		// 	$data['stat_pilih']='';
		// 	$data['tampil_per']='TGL';
		// 	$data['cara_bayar_pasien']="";

		// 	$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			//echo "hahahahdwadawdwafawfeagageaga";
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('rad/pend_today',$data);
		// 	//redirect('ird/IrDLaporan/data','refresh');
		// }
		
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pendapatan.
			</h4>							
			</div>
		</div>";

		$this->load->view('rad/radvpendapatan',$data);


	}

	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Radiologi';

		// $tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		$konten="<table>
					<tr>
						<td colspan=\"2\">
							<p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
						</td>
						<td align=\"right\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
					</tr>
					<tr>
						<td colspan=\"3\">
							<b><font size=\"9\" align=\"right\">$alamat</font></b>
						</td>
					</tr><hr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan Radiologi</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>";

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_RAD_$tgl.pdf";
				
				$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"3%\"><b>No</b></td>
								<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"10%\"><b>No Register</b></td>
								<td width=\"26%\"><b>Nama</b></td>
								<td width=\"31%\"><b>Jenis Pemeriksaan</b></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Pemeriksaan</b></td>
							</tr>
						";
						
					$jum_vtot=0;
					$vtot1=0;
					$i=1;
					foreach($data_laporan_keu as $row){
						$no_register=$row->no_register;
						$j=1;		
						foreach($data_keuangan as $row2){
							if ($row2->no_register==$no_register) {
								$vtot1=$vtot1+$row2->vtot;
								//$jum_vtot = $jum_vtot+$row2->total;
								if($j==1){ 
									$konten=$konten."
									<tr>
										<td>".$i++."</td>
										<td>$row->no_cm</td>
										<td>$row->no_register</td>
										<td>$row->nama</td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 } else { 
								 	$konten=$konten."
									<tr>
										<td colspan=\"4\" bgcolor=\"#cdd4cb\"></td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 }
							$j++;
							} // if
						}
					}

					
					$konten=$konten."
						<tr>
							<th colspan=\"5\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
						
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_RAD_$bln1.pdf";


				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_bln($bln)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
				}
				
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"10%\"><b>Tanggal</b></td>
								<td rowspan=\"2\" width=\"39%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Radmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
							} else {
								$rwspn=count($this->Radmlaporan->row_table_pertgl($row->tgl)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtottotal=0;
							$vtotjumpas=0;
							$vtotjumpem=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$bln1 = date('d', strtotime($row2->tgl));
									$bln2 = date('m', strtotime($row2->tgl));
									$bulan = $tgl_indo->bulan($bln2);
									$vtottotal=$vtottotal+$row2->total;
									$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
									$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
									$vtot=$vtot+$row2->total;
									$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
									$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bln1 $bulan</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_RAD_$thn1.pdf";

				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
				}
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"14%\"><b>Bulan</b></td>
								<td rowspan=\"2\" width=\"35%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Radmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
							} else {
								$rwspn=count($this->Radmlaporan->row_table_perbln($row->bln)->result());
							}
							$rwspn1=$rwspn+1;
							$j=1;
							$vtottotal=0;
							$vtotjumpas=0;
							$vtotjumpem=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									$thn = date('Y', strtotime($row2->bln));
									$bln2 = date('m', strtotime($row2->bln));
									$bulan = $tgl_indo->bulan($bln2);
									$vtottotal=$vtottotal+$row2->total;
									$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
									$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
									$vtot=$vtot+$row2->total;
									$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
									$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bulan $thn</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>"
					;
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}
	}

	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Radiologi';

		// $tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RSPATRIAIKKT")  
		        ->setLastModifiedBy("RSPATRIAIKKT")  
		        ->setTitle("Laporan Keuangan RS PATRIA IKKT")  
		        ->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
		        ->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("RS PATRIA IKKT")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
		if($tampil_per=='TGL'){	
			if($param1!=''){

				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 4;
				foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$j=1;		
					foreach($data_keuangan as $row2){
						if ($row2->no_register==$no_register) {
							$vtot1=$vtot1+$row2->vtot;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_cm);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 	$i++;
							 } else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 }
						$j++;
						$rowCount++;
						} // if
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_TGL.xlsx"');  
					
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : '.$bln1);

				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);

				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->tgl==$row->tgl){
							$bln3 = date('d', strtotime($row2->tgl));
							$bln2 = date('m', strtotime($row2->tgl));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						} // if
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_Bulan.xlsx"');  
			}
			else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_RAD_$thn1.pdf";

				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : '.$thn);


				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->bln==$row->bln){
							$thn = date('Y', strtotime($row2->bln));
							$bln2 = date('m', strtotime($row2->bln));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						}
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_Tahun.xlsx"'); 
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}

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

	public function download_keuangan_old($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")  
		        ->setLastModifiedBy("RS AL Marinir Cilandak")  
		        ->setTitle("Laporan Keuangan RS AL Marinir Cilandak")  
		        ->setSubject("Laporan Keuangan RS AL Marinir Cilandak Document")  
		        ->setDescription("Laporan Keuangan RS AL Marinir Cilandak, generated by HMIS.")  
		        ->setKeywords("RS AL Marinir Cilandak")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		$data_keuangan=$this->Radmlaporan->get_data_keu_tind($param1, $param2)->result();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad.xlsx');
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

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Radiologi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$total_pendapatan = 0;
		foreach($data_keuangan as $row){
			if($temptgl == $row->tgl_kunjungan){

			}else {
				$temptgl = $row->tgl_kunjungan;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
			}

			if($temp == $row->no_rad){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->status=="1"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}else {
				$temp = $row->no_rad;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->idrg);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->bed);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->cara_bayar);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->kontraktor);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->status=="1"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}
			
			$rowCount++;
		}
		$filename = "Laporan Pendapatan Radiologi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');    
		   
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
	}

	public function download_keuangan($param1='',$param2='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$data_keuangan=$this->Radmlaporan->get_data_keu_tind($param1, $param2)->result();
	
		$sheet->getColumnDimension('A')->setAutoSize(true);
      	$sheet->getStyle('A3')->getFont()->setBold(true);
      	$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('B')->setAutoSize(true);
      	$sheet->getStyle('B3')->getFont()->setBold(true);
      	$sheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('C')->setAutoSize(true);
      	$sheet->getStyle('C3')->getFont()->setBold(true);
      	$sheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('D')->setAutoSize(true);
      	$sheet->getStyle('D3')->getFont()->setBold(true);
      	$sheet->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('E')->setAutoSize(true);
      	$sheet->getStyle('E3')->getFont()->setBold(true);
      	$sheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('F')->setAutoSize(true);
      	$sheet->getStyle('F3')->getFont()->setBold(true);
      	$sheet->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('G')->setAutoSize(true);
      	$sheet->getStyle('G3')->getFont()->setBold(true);
      	$sheet->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('H')->setAutoSize(true);
      	$sheet->getStyle('H3')->getFont()->setBold(true);
      	$sheet->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('I')->setAutoSize(true);
      	$sheet->getStyle('I3')->getFont()->setBold(true);
      	$sheet->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('J')->setAutoSize(true);
      	$sheet->getStyle('J3')->getFont()->setBold(true);
      	$sheet->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('K')->setAutoSize(true);
      	$sheet->getStyle('K3')->getFont()->setBold(true);
      	$sheet->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('L')->setAutoSize(true);
      	$sheet->getStyle('L3')->getFont()->setBold(true);
      	$sheet->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('M')->setAutoSize(true);
      	$sheet->getStyle('M3')->getFont()->setBold(true);
      	$sheet->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('N')->setAutoSize(true);
      	$sheet->getStyle('N3')->getFont()->setBold(true);
      	$sheet->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->getColumnDimension('O')->setAutoSize(true);
      	$sheet->getStyle('O3')->getFont()->setBold(true);
      	$sheet->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$sheet->setAutoFilter('A3:O3');

		$sheet->SetCellValue('A1', "Laporan Pendapatan Radiologi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
      	$sheet->getStyle('A1')->getFont()->setBold(true);
      	$sheet->getStyle('A1')->getFont()->setSize(16);
      	$sheet->mergeCells('A1:O1');
      	$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$total_pendapatan = 0;
		foreach($data_keuangan as $row){
			if($temptgl == $row->tgl_kunjungan){

			}else {
				$temptgl = $row->tgl_kunjungan;
				$sheet->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
			}

			if($temp == $row->no_rad){
				$sheet->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$sheet->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$sheet->SetCellValue('M'.$rowCount, $row->qty);
				$sheet->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$sheet->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->cetak_kwitansi=="1"){
					$sheet->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$sheet->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}else {
				$temp = $row->no_rad;
				$sheet->SetCellValue('B'.$rowCount, $row->no_rad);
				$sheet->SetCellValue('C'.$rowCount, $row->no_register);
				$sheet->SetCellValue('D'.$rowCount, $row->nama);
				$sheet->SetCellValue('E'.$rowCount, $row->no_medrec);
				$sheet->SetCellValue('F'.$rowCount, $row->kelas);
				$sheet->SetCellValue('G'.$rowCount, $row->idrg);
				$sheet->SetCellValue('H'.$rowCount, $row->bed);
				$sheet->SetCellValue('I'.$rowCount, $row->cara_bayar);
				$sheet->SetCellValue('J'.$rowCount, $row->nmkontraktor);
				$sheet->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$sheet->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$sheet->SetCellValue('M'.$rowCount, $row->qty);
				$sheet->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$sheet->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->cetak_kwitansi=="1"){
					$sheet->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$sheet->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}
			
			$rowCount++;
		}
		$filename = "Laporan Pendapatan Radiologi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		$sheet->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		$sheet->SetCellValue('N'.$rowCount, $total_pendapatan);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Lap_Range_Laboratorium';
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lappemeriksaan_old($date0='',$date1=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$namars=$this->config->item('namars');
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Radiologi ".$namars)  
		        ->setSubject("Laporan Radiologi ".$namars." Document")  
		        ->setDescription("Laporan Radiologi ".$namars.", generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Radiologi");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		//$tgl=$param1;
		//$tgl1 = date('d F Y', strtotime($tgl));				
					
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_range_lab_tgl.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
		$vtot1=0;
		$i=1;
		$rowCount = 4;
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d', strtotime('-7 days'));
			$date1=date('Y-m-d');
		}	
		$hasil=$this->Radmlaporan->get_lap_pemeriksaan_detail($date0,$date1)->result();
		$listtgl = $this->Radmlaporan->get_dates_detail($date0,$date1)->result();
		$master_lab=$this->Radmlaporan->get_master_pemeriksaan_rad()->result();
		$objPHPExcel->getActiveSheet()->setTitle('Lap Range'); 
		//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, "aaaaaaaaaaaaaa");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$rowCount = 5; $vtotbpjs=0; $vtotumum=0; $vtotdijamin=0; $vtotp=0; $vtotl=0;
      	foreach($listtgl as $key) {
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, date('d-m-Y',strtotime($key->tgl_kunjungan)));
	        $vtotbpjs=$vtotbpjs+$key->BPJS;
	        $vtotumum=$vtotumum+$key->UMUM;
	        $vtotdijamin+$vtotdijamin+$key->DIJAMIN;
	        $vtotp=$vtotp+$key->P;
	        $vtotl=$vtotl+$key->L;
	        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->BPJS);
	        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->UMUM);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->DIJAMIN);
	        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->P);
	        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $key->L);

	        foreach($hasil as $row) {
	        	$col = 6;
		        if($key->tgl_kunjungan==$row->tgl_kunjungan){
		        	foreach($master_lab as $row0) {
		        		if($row->idtindakan==$row0->idtindakan){	
		        			$vtot1=$vtot1+$row->banyak;
		        			//echo $row->banyak.' '.$row->nmtindakan;      			
		        			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowCount, $row->banyak);
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

		$col = 6;
	    foreach($master_lab as $key) {
	        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $key->nmtindakan);
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
	    
	    for ($j=5;$j<$rowCount;$j++) {
			for ($i=6;$i<$col;$i++) {
			    $hi=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue();//getCellValueByColumnAndRow();
			    if($hi==null || $hi==''){
			    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, 0);
			    }
			}
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $vtotbpjs);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotumum);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdijamin);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotl);
		$rowCount++;
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);

		header('Content-Disposition: attachment;filename="Lap_Range_Radiologi.xlsx"');		   
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
	}

	public function cetak_laporan_pemeriksaan($tanggal='',$tampil='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Tindakan');
		$sheet->setCellValue('C1', 'dr. Widya Sp.Rad');
		$sheet->setCellValue('D1', 'dr. Rommy Sp.Rad');
		$sheet->setCellValue('E1', 'Belum Diisi');
		$sheet->setCellValue('F1', 'Total');
				
		if($tampil == 'TGL') {
			$tgl = date("d F Y",strtotime($tanggal));
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_tgl($tanggal)->result();
		} else if($tampil == 'BLN') {
			$tgl = date("F Y",strtotime($tanggal));
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_bln($tanggal)->result();
		} else if($tampil == 'THN') {
			$tgl = $tanggal;
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan_thn($tanggal)->result();
		} else if($tampil == '') {
			$tgl = date("d F Y",strtotime($tanggal));
			$data['data_pemeriksaan'] = $this->Radmlaporan->get_pemeriksaan_tindakan()->result();
		}
	
		$no = 1;
		$x = 2;
		
		foreach($data['data_pemeriksaan'] as $row)
		{
			$total = $row->drwidya + $row->dromy + $row->kosong;
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('C'.$x, $row->drwidya);
			$sheet->setCellValue('D'.$x, $row->dromy);
			$sheet->setCellValue('E'.$x, $row->kosong);
			$sheet->setCellValue('F'.$x, $total);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pemeriksaan Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_jml_expert_bln($date='') {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Tindakan');
		$sheet->setCellValue('C1', 'Jml Exam');
		$sheet->setCellValue('D1', 'Jml Expert');
		$sheet->setCellValue('E1', 'Persen');
		$sheet->mergeCells('A7:B7')
			->getCell('A7')
			->setValue('Jumlah');
						
		$data=$this->Radmlaporan->get_jml_pemeriksaan_expert_bln($date)->result();
	
		$no = 1;
		$x = 2;
		$persen = 0;
		$total_exam = 0;
		$total_expert = 0;
		
		foreach($data as $row)
		{
			$total_exam = $total_exam + ($row->jml_exam);
			$total_expert = $total_expert + ($row->jml_expert);
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->modality);
			$sheet->setCellValue('C'.$x, $row->jml_exam);
			$sheet->setCellValue('D'.$x, $row->jml_expert);
			$rumus = $row->jml_expert?($row->jml_expert!='0'?(($row->jml_exam / $row->jml_expert) * 100):0):0;
			$sheet->setCellValue('E'.$x, $rumus.'%');
			$x++;
		}		
		$total_persen = $total_expert?($total_expert!='0'?(($total_exam / $total_expert) * 100):0):0;
		$sheet->setCellValue('C7',$total_exam);
		$sheet->setCellValue('D7',$total_expert);
		$sheet->setCellValue('E7',$total_persen.'%');

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pemeriksaan Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_jml_expert_thn($date='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Tindakan');
		$sheet->mergeCells('C1:E1')
			->getCell('C1')
			->setValue('Januari');
		$sheet->mergeCells('F1:H1')
			->getCell('F1')
			->setValue('Febuari');
		$sheet->mergeCells('I1:K1')
			->getCell('I1')
			->setValue('Maret');
		$sheet->mergeCells('L1:N1')
			->getCell('L1')
			->setValue('April');
		$sheet->mergeCells('O1:Q1')
			->getCell('O1')
			->setValue('Mei');
		$sheet->mergeCells('R1:T1')
			->getCell('R1')
			->setValue('Juni');
		$sheet->mergeCells('U1:W1')
			->getCell('U1')
			->setValue('Juli');
		$sheet->mergeCells('X1:Z1')
			->getCell('X1')
			->setValue('Agustus');
		$sheet->mergeCells('AA1:AC1')
			->getCell('AA1')
			->setValue('September');
		$sheet->mergeCells('AD1:AF1')
			->getCell('AD1')
			->setValue('Oktober');
		$sheet->mergeCells('AG1:AI1')
			->getCell('AG1')
			->setValue('November');
		$sheet->mergeCells('AJ1:AL1')
			->getCell('AJ1')
			->setValue('Desember');
		$sheet->setCellValue('C2', 'Jml Exam');
		$sheet->setCellValue('D2', 'Jml Expert');
		$sheet->setCellValue('E2', '%');
		$sheet->setCellValue('F2', 'Jml Exam');
		$sheet->setCellValue('G2', 'Jml Expert');
		$sheet->setCellValue('H2', '%');
		$sheet->setCellValue('I2', 'Jml Exam');
		$sheet->setCellValue('J2', 'Jml Expert');
		$sheet->setCellValue('K2', '%');
		$sheet->setCellValue('L2', 'Jml Exam');
		$sheet->setCellValue('M2', 'Jml Expert');
		$sheet->setCellValue('N2', '%');
		$sheet->setCellValue('O2', 'Jml Exam');
		$sheet->setCellValue('P2', 'Jml Expert');
		$sheet->setCellValue('Q2', '%');
		$sheet->setCellValue('R2', 'Jml Exam');
		$sheet->setCellValue('S2', 'Jml Expert');
		$sheet->setCellValue('T2', '%');
		$sheet->setCellValue('U2', 'Jml Exam');
		$sheet->setCellValue('V2', 'Jml Expert');
		$sheet->setCellValue('W2', '%');
		$sheet->setCellValue('X2', 'Jml Exam');
		$sheet->setCellValue('Y2', 'Jml Expert');
		$sheet->setCellValue('Z2', '%');
		$sheet->setCellValue('AA2', 'Jml Exam');
		$sheet->setCellValue('AB2', 'Jml Expert');
		$sheet->setCellValue('AC2', '%');
		$sheet->setCellValue('AD2', 'Jml Exam');
		$sheet->setCellValue('AE2', 'Jml Expert');
		$sheet->setCellValue('AF2', '%');
		$sheet->setCellValue('AG2', 'Jml Exam');
		$sheet->setCellValue('AH2', 'Jml Expert');
		$sheet->setCellValue('AI2', '%');
		$sheet->setCellValue('AJ2', 'Jml Exam');
		$sheet->setCellValue('AK2', 'Jml Expert');
		$sheet->setCellValue('AL2', '%');
		
		// $hasil=$this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($date)->result();
		$hasil = $this->lap_jml_expert_mod('THN',$date);
		$no = 1;
		$x = 3;
		//$persen = 0;
		foreach($hasil as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row['modality']);

			foreach($row['hasil'] as $v){
				if(isset($v[0]['JANUARI'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$exam = $v[0]['JANUARI']['exam']==''?0:$v[0]['JANUARI']['exam'];
					$expert = $v[0]['JANUARI']['expert']==''?0:$v[0]['JANUARI']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('C'.$x, $exam);
					$sheet->setCellValue('D'.$x, $expert);
					$sheet->setCellValue('E'.$x, $persen.'%');
				}
				if(isset($v[0]['FEBUARI'])){
					//$rumus = $v[0]['FEBUARI']['exam'] == '0' || $v[0]['FEBUARI']['exam'] == null || $v[0]['FEBUARI']['expert'] == '0' || $v[0]['FEBUARI']['expert'] == null ? '0':(($v[0]['FEBUARI']['exam']?0:intval($v[0]['FEBUARI']['exam'])) / ($v[0]['FEBUARI']['expert']?0:intval($v[0]['FEBUARI']['expert'])) * 100);
					$exam = $v[0]['FEBUARI']['exam']==''?0:$v[0]['FEBUARI']['exam'];
					$expert = $v[0]['FEBUARI']['expert']==''?0:$v[0]['FEBUARI']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('F'.$x, $exam);
					$sheet->setCellValue('G'.$x, $expert);
					$sheet->setCellValue('H'.$x, $persen.'%');
				}
				if(isset($v[0]['MARET'])){
					//$rumus = $v[0]['MARET']['exam'] == '0' || $v[0]['MARET']['exam'] == null || $v[0]['MARET']['expert'] == '0' || $v[0]['MARET']['expert'] == null ? '0':(($v[0]['MARET']['exam']?0:intval($v[0]['MARET']['exam'])) / ($v[0]['MARET']['expert']?0:intval($v[0]['MARET']['expert'])) * 100);
					$exam = $v[0]['MARET']['exam']==''?0:$v[0]['MARET']['exam'];
					$expert = $v[0]['MARET']['expert']==''?0:$v[0]['MARET']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('I'.$x, $exam);
					$sheet->setCellValue('J'.$x, $expert);
					$sheet->setCellValue('K'.$x, $persen.'%');
				}
				if(isset($v[0]['APRIL'])){
					//$rumus = $v[0]['APRIL']['exam'] == '0' || $v[0]['APRIL']['exam'] == null || $v[0]['APRIL']['expert'] == '0' || $v[0]['APRIL']['expert'] == null ? '0':(($v[0]['APRIL']['exam']?0:intval($v[0]['APRIL']['exam'])) / ($v[0]['APRIL']['expert']?0:intval($v[0]['APRIL']['expert'])) * 100);
					$exam = $v[0]['APRIL']['exam']==''?0:$v[0]['APRIL']['exam'];
					$expert = $v[0]['APRIL']['expert']==''?0:$v[0]['APRIL']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('L'.$x, $exam);
					$sheet->setCellValue('M'.$x, $expert);
					$sheet->setCellValue('N'.$x, $persen.'%');
				}
				if(isset($v[0]['MEI'])){
					//$rumus = $v[0]['MEI']['exam'] == '0' || $v[0]['MEI']['exam'] == null || $v[0]['MEI']['expert'] == '0' || $v[0]['MEI']['expert'] == null ? '0':(($v[0]['MEI']['exam']?0:intval($v[0]['MEI']['exam'])) / ($v[0]['MEI']['expert']?0:intval($v[0]['MEI']['expert'])) * 100);
					$exam = $v[0]['MEI']['exam']==''?0:$v[0]['MEI']['exam'];
					$expert = $v[0]['MEI']['expert']==''?0:$v[0]['MEI']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('O'.$x, $exam);
					$sheet->setCellValue('P'.$x, $expert);
					$sheet->setCellValue('Q'.$x, $persen.'%');
				}
				if(isset($v[0]['JUNI'])){
					//$rumus = $v[0]['JUNI']['exam'] == '0' || $v[0]['JUNI']['exam'] == null || $v[0]['JUNI']['expert'] == '0' || $v[0]['JUNI']['expert'] == null ? '0':(($v[0]['JUNI']['exam']?0:intval($v[0]['JUNI']['exam'])) / ($v[0]['JUNI']['expert']?0:intval($v[0]['JUNI']['expert'])) * 100);
					$exam = $v[0]['JUNI']['exam']==''?0:$v[0]['JUNI']['exam'];
					$expert = $v[0]['JUNI']['expert']==''?0:$v[0]['JUNI']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('R'.$x, $exam);
					$sheet->setCellValue('S'.$x, $expert);
					$sheet->setCellValue('T'.$x, $persen.'%');
				}
				
				if(isset($v[0]['JULI'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['JULI']['exam']==''?0:$v[0]['JULI']['exam'];
					$expert = $v[0]['JULI']['expert']==''?0:$v[0]['JULI']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('U'.$x, $exam);
					$sheet->setCellValue('V'.$x, $expert);
					$sheet->setCellValue('W'.$x, $persen.'%');
				}
				if(isset($v[0]['AGUSTUS'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['AGUSTUS']['exam']==''?0:$v[0]['AGUSTUS']['exam'];
					$expert = $v[0]['AGUSTUS']['expert']==''?0:$v[0]['AGUSTUS']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('X'.$x, $exam);
					$sheet->setCellValue('Y'.$x, $expert);
					$sheet->setCellValue('Z'.$x, $persen.'%');
				}
				if(isset($v[0]['SEPTEMBER'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['SEPTEMBER']['exam']==''?0:$v[0]['SEPTEMBER']['exam'];
					$expert = $v[0]['SEPTEMBER']['expert']==''?0:$v[0]['SEPTEMBER']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('AA'.$x, $exam);
					$sheet->setCellValue('AB'.$x, $expert);
					$sheet->setCellValue('AC'.$x, $persen.'%');
				}
				if(isset($v[0]['OKTOBER'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['OKTOBER']['exam']==''?0:$v[0]['OKTOBER']['exam'];
					$expert = $v[0]['OKTOBER']['expert']==''?0:$v[0]['OKTOBER']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('AD'.$x, $exam);
					$sheet->setCellValue('AE'.$x, $expert);
					$sheet->setCellValue('AF'.$x, $persen.'%');
				}
				if(isset($v[0]['NOVEMBER'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['NOVEMBER']['exam']==''?0:$v[0]['NOVEMBER']['exam'];
					$expert = $v[0]['NOVEMBER']['expert']==''?0:$v[0]['NOVEMBER']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('AG'.$x, $exam);
					$sheet->setCellValue('AH'.$x, $expert);
					$sheet->setCellValue('AI'.$x, $persen.'%');
				}
				if(isset($v[0]['DESEMBER'])){
					//var_dump($v[0]['JULI']); die();
					$exam = $v[0]['DESEMBER']['exam']==''?0:$v[0]['DESEMBER']['exam'];
					$expert = $v[0]['DESEMBER']['expert']==''?0:$v[0]['DESEMBER']['expert'];
					$persen = $expert!='0'?(($exam / $expert) * 100):0;
					$sheet->setCellValue('AJ'.$x, $exam);
					$sheet->setCellValue('AK'.$x, $expert);
					$sheet->setCellValue('AL'.$x, $persen.'%');
				}
			}
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pemeriksaan Modality Radiologi '.$date;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_penerimaan_thn($date='') {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Bulan');
		$sheet->mergeCells('C1:D1')
			->getCell('C1')
			->setValue('CT Scan');
		$sheet->mergeCells('E1:F1')
			->getCell('E1')
			->setValue('Pencitraan MRI');
		$sheet->mergeCells('G1:H1')
			->getCell('G1')
			->setValue('USG');
		$sheet->mergeCells('I1:J1')
			->getCell('I1')
			->setValue('Radiografi Panoramik');
		$sheet->mergeCells('K1:L1')
			->getCell('K1')
			->setValue('Radiografi Konvensional');
		$sheet->setCellValue('C2', 'BPJS');
		$sheet->setCellValue('D2', 'UMUM');
		$sheet->setCellValue('E2', 'BPJS');
		$sheet->setCellValue('F2', 'UMUM');
		$sheet->setCellValue('G2', 'BPJS');
		$sheet->setCellValue('H2', 'UMUM');
		$sheet->setCellValue('I2', 'BPJS');
		$sheet->setCellValue('J2', 'UMUM');
		$sheet->setCellValue('K2', 'BPJS');
		$sheet->setCellValue('L2', 'UMUM');
		
		// $hasil=$this->Radmlaporan->get_jml_pemeriksaan_expert_tahun($date)->result();
		$hasil = $this->lap_penerimaan_thn('THN',$date);
		$no = 1;
		$x = 3;
		$total_ct_bpjs = 0;
		$total_ct_umum = 0;
		$total_mr_bpjs = 0;
		$total_mr_umum = 0;
		$total_us_bpjs = 0;
		$total_us_umum = 0;
		$total_la_bpjs = 0;
		$total_la_umum = 0;
		$total_cr_bpjs = 0;
		$total_cr_umum = 0;
		foreach($hasil as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row['bulan']);

			foreach($row['hasil'] as $v){
				if(isset($v[0]['1 Radiografi CT Scan'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$ct_bpjs = $v[0]['1 Radiografi CT Scan']['ct_bpjs']==''?0:$v[0]['1 Radiografi CT Scan']['ct_bpjs'];
					$ct_umum = $v[0]['1 Radiografi CT Scan']['ct_umum']==''?0:$v[0]['1 Radiografi CT Scan']['ct_umum'];
					$total_ct_bpjs = $total_ct_bpjs + ($ct_bpjs);
					$total_ct_umum = $total_ct_umum + ($ct_umum);
					$sheet->setCellValue('C'.$x, number_format($ct_bpjs));
					$sheet->setCellValue('D'.$x, number_format($ct_umum));
				}
				if(isset($v[0]['2 Pencitraan MRI'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$mr_bpjs = $v[0]['2 Pencitraan MRI']['mr_bpjs']==''?0:$v[0]['2 Pencitraan MRI']['mr_bpjs'];
					$mr_umum = $v[0]['2 Pencitraan MRI']['mr_umum']==''?0:$v[0]['2 Pencitraan MRI']['mr_umum'];
					$total_mr_bpjs = $total_mr_bpjs + ($mr_bpjs);
					$total_mr_umum = $total_mr_umum + ($mr_umum);
					$sheet->setCellValue('E'.$x, number_format($mr_bpjs));
					$sheet->setCellValue('F'.$x, number_format($mr_umum));
				}
				if(isset($v[0]['3 USG'])){
					//var_dump($v[0]['3 USD']); die();
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$us_bpjs = $v[0]['3 USG']['us_bpjs']==''?0:$v[0]['3 USG']['us_bpjs'];
					$us_umum = $v[0]['3 USG']['us_umum']==''?0:$v[0]['3 USG']['us_umum'];
					$total_us_bpjs = $total_us_bpjs + ($us_bpjs);
					$total_us_umum = $total_us_umum + ($us_umum);
					$sheet->setCellValue('G'.$x, number_format($us_bpjs));
					$sheet->setCellValue('H'.$x, number_format($us_umum));
				}
				if(isset($v[0]['4 Radiografi Panoramic/Dental'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$la_bpjs = $v[0]['4 Radiografi Panoramic/Dental']['la_bpjs']==''?0:$v[0]['4 Radiografi Panoramic/Dental']['la_bpjs'];
					$la_umum = $v[0]['4 Radiografi Panoramic/Dental']['la_umum']==''?0:$v[0]['4 Radiografi Panoramic/Dental']['la_umum'];
					$total_la_bpjs = $total_la_bpjs + ($la_bpjs);
					$total_la_umum = $total_la_umum + ($la_umum);
					$sheet->setCellValue('I'.$x, number_format($la_bpjs));
					$sheet->setCellValue('J'.$x, number_format($la_umum));
				}
				if(isset($v[0]['5 Radiografi Konvensional'])){
					//$rumus = $v[0]['JANUARI']['exam'] == "0" || $v[0]['JANUARI']['exam'] == null || $v[0]['JANUARI']['expert'] == "0" || $v[0]['JANUARI']['expert'] == null ? "0":(($v[0]['JANUARI']['exam']?0:intval($v[0]['JANUARI']['exam'])) / ($v[0]['JANUARI']['expert']?0:intval($v[0]['JANUARI']['expert'])) * 100);
					$cr_bpjs = $v[0]['5 Radiografi Konvensional']['cr_bpjs']==''?0:$v[0]['5 Radiografi Konvensional']['cr_bpjs'];
					$cr_umum = $v[0]['5 Radiografi Konvensional']['cr_umum']==''?0:$v[0]['5 Radiografi Konvensional']['cr_umum'];
					$total_cr_bpjs = $total_cr_bpjs + ($cr_bpjs);
					$total_cr_umum = $total_cr_umum + ($cr_umum);
					$sheet->setCellValue('K'.$x, number_format($cr_bpjs));
					$sheet->setCellValue('L'.$x, number_format($cr_umum));
				}
			}
			$x++;
		}		
		$sheet->mergeCells('A15:B16')
			->getCell('A15')
			->setValue('Jumlah');
		$sheet->mergeCells('C16:D16')
			->getCell('C16')
			->setValue(number_format($total_ct_bpjs + $total_ct_umum));
		$sheet->mergeCells('E16:F16')
			->getCell('E16')
			->setValue(number_format($total_mr_bpjs + $total_mr_umum));
		$sheet->mergeCells('G16:H16')
			->getCell('G16')
			->setValue(number_format($total_us_bpjs + $total_us_umum));
		$sheet->mergeCells('I16:J16')
			->getCell('I16')
			->setValue(number_format($total_la_bpjs + $total_la_umum));
		$sheet->mergeCells('K16:L16')
			->getCell('K16')
			->setValue(number_format($total_cr_bpjs + $total_cr_umum));
		$sheet->setCellValue('C15',number_format($total_ct_bpjs));
		$sheet->setCellValue('D15',number_format($total_ct_umum));
		$sheet->setCellValue('E15',number_format($total_mr_bpjs));
		$sheet->setCellValue('F15',number_format($total_mr_umum));
		$sheet->setCellValue('G15',number_format($total_us_bpjs));
		$sheet->setCellValue('H15',number_format($total_us_umum));
		$sheet->setCellValue('I15',number_format($total_la_bpjs));
		$sheet->setCellValue('J15',number_format($total_la_umum));
		$sheet->setCellValue('K15',number_format($total_cr_bpjs));
		$sheet->setCellValue('L15',number_format($total_cr_umum));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Radiologi '.$date;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_penerimaan_bln($date) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Tindakan');
		$sheet->setCellValue('C1', 'BPJS');
		$sheet->setCellValue('D1', 'UMUM');
		// $sheet->setCellValue('E1', 'Persen');
		// $sheet->mergeCells('A7:B7')
		// 	->getCell('A7')
		// 	->setValue('Jumlah');
						
		$data=$this->Radmlaporan->get_penerimaan_bln($date)->result();
	
		$no = 1;
		$x = 2;
		$persen = 0;
		$total_umum = 0;
		$total_bpjs = 0;
		
		foreach($data as $row)
		{
			$total_bpjs = $total_bpjs + ($row->bpjs);
			$total_umum = $total_umum + ($row->umum);
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->modality);
			$sheet->setCellValue('C'.$x, number_format($row->bpjs));
			$sheet->setCellValue('D'.$x, number_format($row->umum));
			// $rumus = $row->jml_expert?($row->jml_expert!='0'?(($row->jml_exam / $row->jml_expert) * 100):0):0;
			// $sheet->setCellValue('E'.$x, $rumus.'%');
			$x++;
		}		
		$sheet->mergeCells('A7:B8')
			->getCell('A7')
			->setValue('Jumlah');
		$sheet->setCellValue('C7',number_format($total_bpjs));
		$sheet->setCellValue('D7',number_format($total_umum));
		$sheet->mergeCells('C8:D8')
			->getCell('C8')
			->setValue(number_format($total_bpjs + $total_umum));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lap_utilitas($date='',$modality) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'TGL');
		$sheet->setCellValue('B1', '1');
		$sheet->setCellValue('C1', '2');
		$sheet->setCellValue('D1', '3');
		$sheet->setCellValue('E1', '4');
		$sheet->setCellValue('F1', '5');
		$sheet->setCellValue('G1', '6');
		$sheet->setCellValue('H1', '7');
		$sheet->setCellValue('I1', '8');
		$sheet->setCellValue('J1', '9');
		$sheet->setCellValue('K1', '10');
		$sheet->setCellValue('L1', '11');
		$sheet->setCellValue('M1', '12');
		$sheet->setCellValue('N1', '13');
		$sheet->setCellValue('O1', '14');
		$sheet->setCellValue('P1', '15');
		$sheet->setCellValue('Q1', '16');
		$sheet->setCellValue('R1', '17');
		$sheet->setCellValue('S1', '18');
		$sheet->setCellValue('T1', '19');
		$sheet->setCellValue('U1', '20');
		$sheet->setCellValue('V1', '21');
		$sheet->setCellValue('W1', '22');
		$sheet->setCellValue('X1', '23');
		$sheet->setCellValue('Y1', '24');
		$sheet->setCellValue('Z1', '25');
		$sheet->setCellValue('AA1', '26');
		$sheet->setCellValue('AB1', '27');
		$sheet->setCellValue('AC1', '28');
		$sheet->setCellValue('AD1', '29');
		$sheet->setCellValue('AE1', '30');
		$sheet->setCellValue('AF1', '31');
		$sheet->setCellValue('AG1', 'Rata Rata');
		$sheet->setCellValue('A2', 'LIMIT');
		if($modality == 'MR') {
			$sheet->setCellValue('B2', '5');
			$sheet->setCellValue('C2', '5');
			$sheet->setCellValue('D2', '5');
			$sheet->setCellValue('E2', '5');
			$sheet->setCellValue('F2', '5');
			$sheet->setCellValue('G2', '5');
			$sheet->setCellValue('H2', '5');
			$sheet->setCellValue('I2', '5');
			$sheet->setCellValue('J2', '5');
			$sheet->setCellValue('K2', '5');
			$sheet->setCellValue('L2', '5');
			$sheet->setCellValue('M2', '5');
			$sheet->setCellValue('N2', '5');
			$sheet->setCellValue('O2', '5');
			$sheet->setCellValue('P2', '5');
			$sheet->setCellValue('Q2', '5');
			$sheet->setCellValue('R2', '5');
			$sheet->setCellValue('S2', '5');
			$sheet->setCellValue('T2', '5');
			$sheet->setCellValue('U2', '5');
			$sheet->setCellValue('V2', '5');
			$sheet->setCellValue('W2', '5');
			$sheet->setCellValue('X2', '5');
			$sheet->setCellValue('Y2', '5');
			$sheet->setCellValue('Z2', '5');
			$sheet->setCellValue('AA2', '5');
			$sheet->setCellValue('AB2', '5');
			$sheet->setCellValue('AC2', '5');
			$sheet->setCellValue('AD2', '5');
			$sheet->setCellValue('AE2', '5');
			$sheet->setCellValue('AF2', '5');
			$sheet->setCellValue('AG2', '5');
		} else {
			$sheet->setCellValue('B2', '');
			$sheet->setCellValue('C2', '');
			$sheet->setCellValue('D2', '');
			$sheet->setCellValue('E2', '');
			$sheet->setCellValue('F2', '');
			$sheet->setCellValue('G2', '');
			$sheet->setCellValue('H2', '');
			$sheet->setCellValue('I2', '');
			$sheet->setCellValue('J2', '');
			$sheet->setCellValue('K2', '');
			$sheet->setCellValue('L2', '');
			$sheet->setCellValue('M2', '');
			$sheet->setCellValue('N2', '');
			$sheet->setCellValue('O2', '');
			$sheet->setCellValue('P2', '');
			$sheet->setCellValue('Q2', '');
			$sheet->setCellValue('R2', '');
			$sheet->setCellValue('S2', '');
			$sheet->setCellValue('T2', '');
			$sheet->setCellValue('U2', '');
			$sheet->setCellValue('V2', '');
			$sheet->setCellValue('W2', '');
			$sheet->setCellValue('X2', '');
			$sheet->setCellValue('Y2', '');
			$sheet->setCellValue('Z2', '');
			$sheet->setCellValue('AA2', '');
			$sheet->setCellValue('AB2', '');
			$sheet->setCellValue('AC2', '');
			$sheet->setCellValue('AD2', '');
			$sheet->setCellValue('AE2', '');
			$sheet->setCellValue('AF2', '');
			$sheet->setCellValue('AG2', '');
		}
		$sheet->mergeCells('AH1:AH2')
			->getCell('AH1')
			->setValue('Jumlah Hari Kerja');
		$sheet->mergeCells('AI1:AI2')
			->getCell('AI1')
			->setValue('Jumlah Pemeriksaan');
						
		$hasil = $this->lap_utilitas_bln($modality,$date);
	
		$no = 1;
		$x = 3;
		
		foreach($hasil as $row)
		{
			//$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('A'.$x, $row['modality']);

			foreach($row['hasil'] as $v){
				if(isset($v[0]['1'])){
					$satu = $v[0]['1']['jml']==''?0:$v[0]['1']['jml'];
					$sheet->setCellValue('B'.$x, $satu);
				}
				if(isset($v[0]['2'])){
					$satu = $v[0]['2']['jml']==''?0:$v[0]['2']['jml'];
					$sheet->setCellValue('C'.$x, $satu);
				}
				if(isset($v[0]['3'])){
					$satu = $v[0]['3']['jml']==''?0:$v[0]['3']['jml'];
					$sheet->setCellValue('D'.$x, $satu);
				}
				if(isset($v[0]['4'])){
					$satu = $v[0]['4']['jml']==''?0:$v[0]['4']['jml'];
					$sheet->setCellValue('E'.$x, $satu);
				}
				if(isset($v[0]['5'])){
					$satu = $v[0]['5']['jml']==''?0:$v[0]['5']['jml'];
					$sheet->setCellValue('F'.$x, $satu);
				}
				if(isset($v[0]['6'])){
					$satu = $v[0]['6']['jml']==''?0:$v[0]['6']['jml'];
					$sheet->setCellValue('G'.$x, $satu);
				}
				if(isset($v[0]['7'])){
					$satu = $v[0]['7']['jml']==''?0:$v[0]['7']['jml'];
					$sheet->setCellValue('H'.$x, $satu);
				}
				if(isset($v[0]['8'])){
					$satu = $v[0]['8']['jml']==''?0:$v[0]['8']['jml'];
					$sheet->setCellValue('I'.$x, $satu);
				}
				if(isset($v[0]['9'])){
					$satu = $v[0]['9']['jml']==''?0:$v[0]['9']['jml'];
					$sheet->setCellValue('J'.$x, $satu);
				}
				if(isset($v[0]['10'])){
					$satu = $v[0]['10']['jml']==''?0:$v[0]['10']['jml'];
					$sheet->setCellValue('K'.$x, $satu);
				}
				if(isset($v[0]['11'])){
					$satu = $v[0]['11']['jml']==''?0:$v[0]['11']['jml'];
					$sheet->setCellValue('L'.$x, $satu);
				}
				if(isset($v[0]['12'])){
					$satu = $v[0]['12']['jml']==''?0:$v[0]['12']['jml'];
					$sheet->setCellValue('M'.$x, $satu);
				}
				if(isset($v[0]['13'])){
					$satu = $v[0]['13']['jml']==''?0:$v[0]['13']['jml'];
					$sheet->setCellValue('N'.$x, $satu);
				}
				if(isset($v[0]['14'])){
					$satu = $v[0]['14']['jml']==''?0:$v[0]['14']['jml'];
					$sheet->setCellValue('O'.$x, $satu);
				}
				if(isset($v[0]['15'])){
					$satu = $v[0]['15']['jml']==''?0:$v[0]['15']['jml'];
					$sheet->setCellValue('P'.$x, $satu);
				}
				if(isset($v[0]['16'])){
					$satu = $v[0]['16']['jml']==''?0:$v[0]['16']['jml'];
					$sheet->setCellValue('Q'.$x, $satu);
				}
				if(isset($v[0]['17'])){
					$satu = $v[0]['17']['jml']==''?0:$v[0]['17']['jml'];
					$sheet->setCellValue('R'.$x, $satu);
				}
				if(isset($v[0]['18'])){
					$satu = $v[0]['18']['jml']==''?0:$v[0]['18']['jml'];
					$sheet->setCellValue('S'.$x, $satu);
				}
				if(isset($v[0]['19'])){
					$satu = $v[0]['19']['jml']==''?0:$v[0]['19']['jml'];
					$sheet->setCellValue('T'.$x, $satu);
				}
				if(isset($v[0]['20'])){
					$satu = $v[0]['20']['jml']==''?0:$v[0]['20']['jml'];
					$sheet->setCellValue('U'.$x, $satu);
				}
				if(isset($v[0]['21'])){
					$satu = $v[0]['21']['jml']==''?0:$v[0]['21']['jml'];
					$sheet->setCellValue('V'.$x, $satu);
				}
				if(isset($v[0]['22'])){
					$satu = $v[0]['22']['jml']==''?0:$v[0]['22']['jml'];
					$sheet->setCellValue('W'.$x, $satu);
				}
				if(isset($v[0]['23'])){
					$satu = $v[0]['23']['jml']==''?0:$v[0]['23']['jml'];
					$sheet->setCellValue('X'.$x, $satu);
				}
				if(isset($v[0]['24'])){
					$satu = $v[0]['24']['jml']==''?0:$v[0]['24']['jml'];
					$sheet->setCellValue('Y'.$x, $satu);
				}
				if(isset($v[0]['25'])){
					$satu = $v[0]['25']['jml']==''?0:$v[0]['25']['jml'];
					$sheet->setCellValue('Z'.$x, $satu);
				}
				if(isset($v[0]['26'])){
					$satu = $v[0]['26']['jml']==''?0:$v[0]['26']['jml'];
					$sheet->setCellValue('AA'.$x, $satu);
				}
				if(isset($v[0]['27'])){
					$satu = $v[0]['27']['jml']==''?0:$v[0]['27']['jml'];
					$sheet->setCellValue('AB'.$x, $satu);
				}
				if(isset($v[0]['28'])){
					$satu = $v[0]['28']['jml']==''?0:$v[0]['28']['jml'];
					$sheet->setCellValue('AC'.$x, $satu);
				}
				if(isset($v[0]['29'])){
					$satu = $v[0]['29']['jml']==''?0:$v[0]['29']['jml'];
					$sheet->setCellValue('AD'.$x, $satu);
				}
				if(isset($v[0]['30'])){
					$satu = $v[0]['30']['jml']==''?0:$v[0]['30']['jml'];
					$sheet->setCellValue('AE'.$x, $satu);
				}
				if(isset($v[0]['31'])){
					$satu = $v[0]['31']['jml']==''?0:$v[0]['31']['jml'];
					$sheet->setCellValue('AF'.$x, $satu);
				}
			}
			$sheet->setCellValue('AG'.$x, $row['rata']);
			$sheet->setCellValue('AH'.$x, $row['hari_kerja']);
			$sheet->setCellValue('AI'.$x, $row['total']);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Utilitas Radiologi '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function excel_lappemeriksaan($date0='',$date1='',$tindak='',$dokter='')
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Tindakan');
		$sheet->setCellValue('C1', 'Dokter');
		$sheet->setCellValue('D1', 'Banyak');
				
		if($date0=='' && $date1==''){
			$date0=date('Y-m-d');
			$date1=date('Y-m-d');
		}		
		$data=$this->Radmlaporan->get_lap_pemeriksaan($date0,$date1,$tindak,$dokter)->result();
	
		$no = 1;
		$x = 2;
		
		foreach($data as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('C'.$x, $row->nm_dokter);
			$sheet->setCellValue('D'.$x, $row->banyak);
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pemeriksaan Radiologi '.$tindak.' '.$date0.' - '.$date1;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}
	
	public function lap_pengulangan() {
		$data['title'] = 'Laporan Pengulangan Radiologi';
		$this->load->view('rad/radvlap_ulang',$data);
	}

	public function lap_pertumbuhan() {
		$data['title'] = 'Laporan Pertumbuhan Expertise';
		$this->load->view('rad/radvlap_pertumbuhan', $data);
	}

	public function get_data_pertumbuhan_expert(){
		//$id_poli=$this->input->post('id_poli');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->Radmlaporan->get_lap_pertumbuhan_by_expert($tgl_awal, $tgl_akhir)->result();
	    // echo json_encode($datajson);
		$datachart=[];
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->tahun, 'y' => (int)$row->jml];
			$i++;
		}
	    echo json_encode($datachart);
	}

	public function lap_pasien_luar() {
		$data['title'] = 'Laporan Pasien Luar';

		$date = $this->input->post('date');
		$month = $this->input->post('month');
		$tipe = $this->input->post('tipe');

		if($date == '' && $month == '') {
			$data['tipe'] = 'Tanggal';
			$data['date'] = date('Y-m-d');
			$data['judul'] = date('d F Y', strtotime($data['date']));
			$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_pasien_luar('Tanggal', $data['date'])->result();
		} else {
			$data['tipe'] = $tipe;
			if($tipe == 'Tanggal') {
				$data['date'] = $date;
				$data['judul'] = date('d F Y', strtotime($date));
				$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_pasien_luar($tipe, $date)->result();
			} else {
				$data['date'] = $month;
				$data['judul'] = date('F Y', strtotime($month));
				$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_pasien_luar($tipe, $month)->result();
			}
		}

		$this->load->view('rad/radvlap_pasienluar', $data);
	}

	public function excel_lap_pasien_luar($tipe, $date) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Tgl Kunjungan');
		$sheet->setCellValue('E1', 'Pemeriksaan');
		$sheet->setCellValue('F1', 'Tgl Pemeriksan');
		$sheet->setCellValue('G1', 'Jaminan');
		$sheet->setCellValue('H1', 'Modality');
		$sheet->setCellValue('I1', 'Tgl Dibaca');
		$sheet->setCellValue('J1', 'Dokter');
		$sheet->setCellValue('K1', 'Kontraktor');

		$pasien_luar = $this->Radmlaporan->get_data_laporan_pasien_luar($tipe, $date)->result();
		if($tipe == 'Tanggal') {
			$tgl = date('d F Y', strtotime($date));
		} else {
			$tgl = date('F Y', strtotime($date));
		}

		$no = 1;
		$x = 2;
		
		foreach($pasien_luar as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_register);
			$sheet->setCellValue('C'.$x, $row->nama);
			$sheet->setCellValue('D'.$x, date('d-m-Y', strtotime($row->tgl_kunjungan)));
			$sheet->setCellValue('E'.$x, $row->jenis_tindakan);

			if($row->tgl_generate != NULL) {
				$sheet->setCellValue('F'.$x, date('d-m-Y', strtotime($row->tgl_generate)));
			} else {
				$sheet->setCellValue('F'.$x, '');
			}

			$sheet->setCellValue('G'.$x, $row->cara_bayar);
			$sheet->setCellValue('H'.$x, $row->modality);

			if($row->tanggal_isi != NULL) {
				$sheet->setCellValue('I'.$x, date('d-m-Y', strtotime($row->tanggal_isi)));
			} else {
				$sheet->setCellValue('I'.$x, '');
			}

			$sheet->setCellValue('J'.$x, $row->nm_dokter);
			$sheet->setCellValue('K'.$x, $row->nmkontraktor);
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Pasien Luar '.$tipe.' '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lapjml_pasien_luar() {
		$data['title'] = 'Laporan Jumlah Pasien Luar';

		$date = $this->input->post('date');
		$month = $this->input->post('month');
		$tipe = $this->input->post('tipe');

		if($date == '' && $month == '') {
			$data['tipe'] = 'Tanggal';
			$data['date'] = date('Y-m-d');
			$data['judul'] = date('d F Y', strtotime($data['date']));
			$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_luar('Tanggal', $data['date'])->result();
		} else {
			$data['tipe'] = $tipe;
			if($tipe == 'Tanggal') {
				$data['date'] = $date;
				$data['judul'] = date('d F Y', strtotime($date));
				$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_luar($tipe, $date)->result();
			} else {
				$data['date'] = $month;
				$data['judul'] = date('F Y', strtotime($month));
				$data['pasien_luar'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_luar($tipe, $month)->result();
			}
		}
		$this->load->view('rad/radvlapjml_pasienluar', $data);
	}

	public function excel_lapjml_pasien_luar($tipe, $date) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Pemeriksaan');
		$sheet->mergeCells('C1:H1')
			->getCell('C1')
			->setValue('dr. Rommy Sp.Rad');
		$sheet->mergeCells('I1:I2')
			->getCell('I1')
			->setValue('dr. Rommy Sp.Rad Total');
		$sheet->mergeCells('J1:O1')
			->getCell('J1')
			->setValue('dr. Widya Sp.Rad');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('dr. Widya Sp.Rad Total');
		$sheet->mergeCells('Q1:V1')
			->getCell('Q1')
			->setValue('(Blank)');
		$sheet->mergeCells('W1:W2')
			->getCell('W1')
			->setValue('(Blank) Total');
		$sheet->mergeCells('X1:X2')
			->getCell('X1')
			->setValue('Grand Total');

		$sheet->setCellValue('C2', 'BPJS - Mandiri');
		$sheet->setCellValue('D2', 'RS Ahmad Mochtar');
		$sheet->setCellValue('E2', 'RS Adnan WD Payakumbuh');
		$sheet->setCellValue('F2', 'RS Madina');
		$sheet->setCellValue('G2', 'RST Bukittinggi');
		$sheet->setCellValue('H2', '(Blank)');
		$sheet->setCellValue('J2', 'BPJS - Mandiri');
		$sheet->setCellValue('K2', 'RS Ahmad Mochtar');
		$sheet->setCellValue('L2', 'RS Adnan WD Payakumbuh');
		$sheet->setCellValue('M2', 'RS Madina');
		$sheet->setCellValue('N2', 'RST Bukittinggi');
		$sheet->setCellValue('O2', '(Blank)');
		$sheet->setCellValue('Q2', 'BPJS - Mandiri');
		$sheet->setCellValue('R2', 'RS Ahmad Mochtar');
		$sheet->setCellValue('S2', 'RS Adnan WD Payakumbuh');
		$sheet->setCellValue('T2', 'RS Madina');
		$sheet->setCellValue('U2', 'RST Bukittinggi');
		$sheet->setCellValue('V2', '(Blank)');

		$pasien_luar = $this->Radmlaporan->get_data_laporan_jumlah_pasien_luar($tipe, $date)->result();
		if($tipe == 'Tanggal') {
			$tgl = date('d F Y', strtotime($date));
		} else {
			$tgl = date('F Y', strtotime($date));
		}

		$no = 1;
		$x = 3;

		$total_drommy_bpjs_mandiri = 0;
        $total_drommy_rsam = 0;
        $total_drommy_rs_payakumbuh = 0;
        $total_drommy_madina = 0;
        $total_drommy_rst = 0;
        $total_drommy_blank = 0;
        $total_drwid_bpjs_mandiri = 0;
        $total_drwid_rsam = 0;
        $total_drwid_rs_payakumbuh = 0;
        $total_drwid_madina = 0;
        $total_drwid_rst = 0;
        $total_drwid_blank = 0;
        $total_blank_bpjs_mandiri = 0;
        $total_blank_rsam = 0;
        $total_blank_rs_payakumbuh = 0;
        $total_blank_madina = 0;
        $total_blank_rst = 0;
        $total_blank_blank = 0;
        $grtotal_drommy = 0;
        $grtotal_drwid = 0;
        $grtotal_blank = 0;
        $total = 0;

		foreach($pasien_luar as $row) {
			$total_drommy = $row->drommy_bpjs_mandiri + $row->drommy_rsam + $row->drommy_rs_payakumbuh + $row->drommy_madina + $row->drommy_rst + $row->drommy_blank;
            $total_drwid = $row->drwid_bpjs_mandiri + $row->drwid_rsam + $row->drwid_rs_payakumbuh + $row->drwid_madina + $row->drwid_rst + $row->drwid_blank;
            $total_blank = $row->blank_bpjs_mandiri + $row->blank_rsam + $row->blank_rs_payakumbuh + $row->blank_madina + $row->blank_rst + $row->blank_blank;

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->jenis_tindakan);

			$sheet->setCellValue('C'.$x, $row->drommy_bpjs_mandiri);
			$total_drommy_bpjs_mandiri += $row->drommy_bpjs_mandiri;

			$sheet->setCellValue('D'.$x, $row->drommy_rsam);
			$total_drommy_rsam += $row->drommy_rsam;

			$sheet->setCellValue('E'.$x, $row->drommy_rs_payakumbuh);
			$total_drommy_rs_payakumbuh += $row->drommy_rs_payakumbuh;

			$sheet->setCellValue('F'.$x, $row->drommy_madina);
			$total_drommy_madina += $row->drommy_madina;

			$sheet->setCellValue('G'.$x, $row->drommy_rst);
			$total_drommy_rst += $row->drommy_rst;

			$sheet->setCellValue('H'.$x, $row->drommy_blank);
			$total_drommy_blank += $row->drommy_blank;

			$sheet->setCellValue('I'.$x, $total_drommy);
			$grtotal_drommy += $total_drommy;

			$sheet->setCellValue('J'.$x, $row->drwid_bpjs_mandiri);
			$total_drwid_bpjs_mandiri += $row->drwid_bpjs_mandiri;

			$sheet->setCellValue('K'.$x, $row->drwid_rsam);
			$total_drwid_rsam += $row->drwid_rsam;

			$sheet->setCellValue('L'.$x, $row->drwid_rs_payakumbuh);
			$total_drwid_rs_payakumbuh += $row->drwid_rs_payakumbuh;

			$sheet->setCellValue('M'.$x, $row->drwid_madina);
			$total_drwid_madina += $row->drwid_madina;

			$sheet->setCellValue('N'.$x, $row->drwid_rst);
			$total_drwid_rst += $row->drwid_rst;

			$sheet->setCellValue('O'.$x, $row->drwid_blank);
			$total_drwid_blank += $row->drwid_blank;

			$sheet->setCellValue('P'.$x, $total_drwid);
			$grtotal_drwid += $total_drwid;

			$sheet->setCellValue('Q'.$x, $row->blank_bpjs_mandiri);
			$total_blank_bpjs_mandiri += $row->blank_bpjs_mandiri;

			$sheet->setCellValue('R'.$x, $row->blank_rsam);
			$total_blank_rsam += $row->blank_rsam;

			$sheet->setCellValue('S'.$x, $row->blank_rs_payakumbuh);
			$total_blank_rs_payakumbuh += $row->blank_rs_payakumbuh;

			$sheet->setCellValue('T'.$x, $row->blank_madina);
			$total_blank_madina += $row->blank_madina;

			$sheet->setCellValue('U'.$x, $row->blank_rst);
			$total_blank_rst += $row->blank_rst;

			$sheet->setCellValue('V'.$x, $row->blank_blank);
			$total_blank_blank += $row->blank_blank;

			$sheet->setCellValue('W'.$x, $total_blank);
			$grtotal_blank += $total_blank;

			$sheet->setCellValue('X'.$x, $total_drommy + $total_drwid + $total_blank);
			$total += $total_drommy + $total_drwid + $total_blank;
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Grand Total');
		$sheet->mergeCells('A'.$x.':'.'B'.$x.'');
		$sheet->setCellValue('C'.$x, $total_drommy_bpjs_mandiri);
		$sheet->setCellValue('D'.$x, $total_drommy_rsam);
		$sheet->setCellValue('E'.$x, $total_drommy_rs_payakumbuh);
		$sheet->setCellValue('F'.$x, $total_drommy_madina);
		$sheet->setCellValue('G'.$x, $total_drommy_rst);
		$sheet->setCellValue('H'.$x, $total_drommy_blank);
		$sheet->setCellValue('I'.$x, $grtotal_drommy);
		$sheet->setCellValue('J'.$x, $total_drwid_bpjs_mandiri);
		$sheet->setCellValue('K'.$x, $total_drwid_rsam);
		$sheet->setCellValue('L'.$x, $total_drwid_rs_payakumbuh);
		$sheet->setCellValue('M'.$x, $total_drwid_madina);
		$sheet->setCellValue('N'.$x, $total_drwid_rst);
		$sheet->setCellValue('O'.$x, $total_drwid_blank);
		$sheet->setCellValue('P'.$x, $grtotal_drwid);
		$sheet->setCellValue('Q'.$x, $total_blank_bpjs_mandiri);
		$sheet->setCellValue('R'.$x, $total_blank_rsam);
		$sheet->setCellValue('S'.$x, $total_blank_rs_payakumbuh);
		$sheet->setCellValue('T'.$x, $total_blank_madina);
		$sheet->setCellValue('U'.$x, $total_blank_rst);
		$sheet->setCellValue('V'.$x, $total_blank_blank);
		$sheet->setCellValue('W'.$x, $grtotal_blank);
		$sheet->setCellValue('X'.$x, $total);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Pasien Luar '.$tipe.' '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_berdasarkan_cetak_billing() {
		$data['title'] = 'Laporan Jumlah Pasien Berdasarkan Cetak Biliing';

		$date = $this->input->post('date');
		$month = $this->input->post('month');
		$tipe = $this->input->post('tipe');

		if($date == '' && $month == '') {
			$data['tipe'] = 'Tanggal';
			$data['date'] = date('Y-m-d');
			$data['judul'] = date('d F Y', strtotime($data['date']));
			$data['pasien'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_cetak_billing('Tanggal', $data['date'])->result();
		} else {
			$data['tipe'] = $tipe;
			if($tipe == 'Tanggal') {
				$data['date'] = $date;
				$data['judul'] = date('d F Y', strtotime($date));
				$data['pasien'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_cetak_billing($tipe, $date)->result();
			} else {
				$data['date'] = $month;
				$data['judul'] = date('F Y', strtotime($month));
				$data['pasien'] = $this->Radmlaporan->get_data_laporan_jumlah_pasien_cetak_billing($tipe, $month)->result();
			}
		}
		$this->load->view('rad/radvlapjml_cetak_billing', $data);
	}

	public function excel_lap_berdasarkan_cetak_billing($tipe, $date) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'No Medrec');
		$sheet->setCellValue('D1', 'Nama');
		$sheet->setCellValue('E1', 'Pemeriksaan');
		$sheet->setCellValue('F1', 'Jaminan');
		$sheet->setCellValue('G1', 'Tgl dicetak Billing');

		$pasien = $this->Radmlaporan->get_data_laporan_jumlah_pasien_cetak_billing($tipe, $date)->result();
		if($tipe == 'Tanggal') {
			$tgl = date('d F Y', strtotime($date));
		} else {
			$tgl = date('F Y', strtotime($date));
		}

		$no = 1;
		$x = 2;
		
		foreach($pasien as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_register);
			$sheet->setCellValue('C'.$x, $row->no_cm);
			$sheet->setCellValue('D'.$x, $row->nama);
			$sheet->setCellValue('E'.$x, $row->jenis_tindakan);
			$sheet->setCellValue('F'.$x, $row->cara_bayar);
			$sheet->setCellValue('G'.$x, date('d-m-Y', strtotime($row->tgl_cetak_billing)));
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Pasien Berdasarkan Cetak Billing '.$tipe.' '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
?>
