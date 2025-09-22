<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Claporantxtbpjs extends Secure_area {
    public function __construct(){
		parent::__construct();
		
		$this->load->model("laporan_pendapatan_diagnosa/mlaporantxtbpjs");
		
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

    public function index(){
		$data['title'] = 'Laporan Txt BPJS';
    
    }

    public function txtBPJSRawatJalan(){
		    $data['title'] = 'Laporan BPJS Rawat Jalan';

        $this->load->view('laporan/view_laporan_txt_bpjs_rawat_jalan',$data);   
    }
    

    public function txtBPJSRawatInap(){
      $data['title'] = 'Laporan BPJS Rawat Inap';
      if($this->input->post()){
        $bulan = $this->input->post('startMonth');
        $data['bln'] = $bulan;
        $data['data_lap'] = $this->mlaporantxtbpjs->get_laporan_txt_ranap($bulan);
      }else{
        $bulan = '';
        $data['bln'] = $bulan;
        $data['data_lap'] = $this->mlaporantxtbpjs->get_laporan_txt_ranap($bulan);
      }
      // var_dump($this->input->post());die();
      $this->load->view('laporan_pendapatan_diagnosa/view_laporan_txt_bpjs_rawat_inap',$data);   
    }

    public function excel_txtBPJSRawatInap($bln)
    {
      // var_dump($bln);die();
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      $sheet->setCellValue('A2', 'No');
      $sheet->setCellValue('B2', 'Kelompok Penagihan');
      $sheet->setCellValue('C2', 'Tanggal Pelayanan');
      $sheet->setCellValue('D2', 'Kelas Rawatan');
      $sheet->setCellValue('E2', 'ruang rawatan terakhir');
      $sheet->setCellValue('F2', 'SEP');
      $sheet->setCellValue('G2', 'Nama Pasien');
      $sheet->setCellValue('H2', 'Diagnosa');
      $sheet->setCellValue('I2', 'Kode INA-CBG');
      $sheet->setCellValue('J2', 'Deskripsi INA-CBG');
      $sheet->setCellValue('K2', 'Nama DPJP');
      $sheet->setCellValue('L2', 'Spesialistik');
      $sheet->setCellValue('M2', 'LOS RI');
      $sheet->setCellValue('N2', 'Tarif INA-CBG');
      $sheet->setCellValue('O2', 'Tarif RS');
      $sheet->setCellValue('P2', 'Tarif RS total');
     
      
      
      $data =$this->mlaporantxtbpjs->get_laporan_txt_ranap($bln);


      $no = 1;
      $x = 3;
      
      foreach($data as $val) {
      $sheet->setCellValue('A'.$x, $no++);
      $sheet->setCellValue('B'.$x, $val->kelompok_penagihan);
      $sheet->setCellValue('C'.$x, date('d-m-Y',strtotime($val->tgl_keluar)));
      $sheet->setCellValue('D'.$x, $val->kelas);
      $sheet->setCellValue('E'.$x, $val->nmruang);
      $sheet->setCellValue('F'.$x, $val->no_sep);
      $sheet->setCellValue('G'.$x, $val->nama);
      $sheet->setCellValue('H'.$x, $val->diagnosa);
      $sheet->setCellValue('I'.$x, $val->cbg_code);
      $sheet->setCellValue('J'.$x, $val->descripsi_inacg);
      $sheet->setCellValue('K'.$x, $val->dokterdpjp);
      $sheet->setCellValue('L'.$x, $val->nm_poli);

      $diff = 1;                                   
      if($val->tgl_keluar != NULL){
      $start = new DateTime($val->tgl_masuk);//start
          $end = new DateTime($val->tgl_keluar);//end

          $diff = $end->diff($start)->format("%a");
          if($diff == 0){
              $diff = 1;
          }

      }else{
          $start = new DateTime($val->tgl_masuk);//start
          $end = new DateTime(date("Y-m-d"));//end

          $diff = $end->diff($start)->format("%a");
          if($diff == 0){
              $diff = 1;
          }
      }


      $sheet->setCellValue('M'.$x, $diff .' '.'Hari' );
      $sheet->setCellValue('N'.$x, $val->tarif_inacbg);
      $sheet->setCellValue('O'.$x, $val->tarif_rs);
      $sheet->setCellValue('P'.$x, $val->tarif_rs_total);
      $x++;
    }
     

      $writer = new Xlsx($spreadsheet);
      $filename = 'Laporan txt BPJS Rawat Inap';
      header('Content-type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
    }


}
?>