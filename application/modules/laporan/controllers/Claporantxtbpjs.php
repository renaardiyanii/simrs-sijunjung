<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Claporantxtbpjs extends Secure_area {
    public function __construct(){
		parent::__construct();
		
		$this->load->model("laporan/mlaporantxtbpjs");
		
		// $this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

    public function index(){
		$data['title'] = 'Laporan Txt BPJS';
    
    }

    public function txtBPJSRawatJalan(){
		    $data['title'] = 'Laporan BPJS Rawat Jalan';

        $this->load->view('laporan/view_laporan_txt_bpjs_rawat_jalan',$data);   
    }

    public function txtEklaim(){
      $data['title'] = 'Laporan TXT E - Klaim';

      $this->load->view('laporan/viewTxtEklaim',$data);   
  }
    

    public function txtBPJSRawatInap(){
      $data['title'] = 'Laporan BPJS Rawat Inap';

      $this->load->view('laporan/view_laporan_txt_bpjs_rawat_inap',$data);   
    }

    public function getLaporanTxtEklaim() {
      header('Content-Type: application/json');
      // $startMonth = $_POST["startMonth"];
      // $endMonth = $_POST["endMonth"];
      $startMonth = $this->input->post('startMonth');
      $endMonth = $this->input->post('endMonth');
      
      $data = $this->mlaporantxtbpjs->getTxtEklaim($startMonth,$endMonth)->result();

      $rowNum = 1;
		  $newArr  = array();
      foreach($data as $result) {
        $newArr[] = array(
          "no" => $rowNum,
          "no_sep" => $result->no_sep == null ? "" : $result->no_sep,
          "no_register" => $result->no_register == null ? "" : $result->no_register,
          "nama_pasien" => $result->nama_pasien == null ? "" : $result->nama_pasien,
          "tgl_lahir" => $result->tgl_lahir == null ? "" : $result->tgl_lahir,
          "nomor_kartu" => $result->nomor_kartu == null ? "" : $result->nomor_kartu,
          "tgl_masuk" => $result->tgl_masuk == null ? "" : $result->tgl_masuk,
          "tgl_pulang" => $result->tgl_pulang == null ? "" : $result->tgl_pulang,
          "jenis_rawat" => $result->jenis_rawat == null ? "" : $result->jenis_rawat,
          "kelas_rawat" => $result->kelas_rawat == null ? "" : $result->kelas_rawat,
          "adl_sub_acute" => $result->adl_sub_acute == null ? "" : $result->adl_sub_acute,
          "adl_chronic" => $result->adl_chronic == null ? "" : $result->adl_chronic,
          "icu_indikator" => $result->icu_indikator == null ? "" : $result->icu_indikator,
          "icu_los" => $result->icu_los == null ? "" : $result->icu_los,
          "ventilator_hour" => $result->ventilator_hour == null ? "" : $result->ventilator_hour,
          "upgrade_class_ind" => $result->upgrade_class_ind == null ? "" : $result->upgrade_class_ind,
          "upgrade_class_class" => $result->upgrade_class_class == null ? "" : $result->upgrade_class_class,
          "upgrade_class_los" => $result->upgrade_class_los == null ? "" : $result->upgrade_class_los,
          "add_payment_pct" => $result->add_payment_pct == null ? "" : $result->add_payment_pct,
          "birth_weight" => $result->birth_weight == null ? "" : $result->birth_weight,
          "discharge_status" => $result->discharge_status == null ? "" : $result->discharge_status,
          "diagnosa" => $result->diagnosa == null ? "" : $result->diagnosa,
          "procedure" => $result->procedure == null ? "" : $result->procedure,
          "tarif_poli_eks" => $result->tarif_poli_eks == null ? "" : $result->tarif_poli_eks,
          "nama_dokter" => $result->nama_dokter == null ? "" : $result->nama_dokter,
          "kode_tarif" => $result->kode_tarif == null ? "" : $result->kode_tarif,
          "payor_id" => $result->payor_id == null ? "" : $result->payor_id,
          "payor_cd" => $result->payor_cd == null ? "" : $result->payor_cd,
          "cob_cd" => $result->cob_cd == null ? "" : $result->cob_cd,
          "coder_nik" => $result->coder_nik == null ? "" : $result->coder_nik,
          "special_cmg" => $result->special_cmg == null ? "" : $result->special_cmg,
          "cbg_code" => $result->cbg_code == null ? "" : $result->cbg_code,
          "tarif_grouper1" => $result->tarif_grouper1 == null ? "" : $result->tarif_grouper1,
          "tarif_grouper2" => $result->tarif_grouper2 == null ? "" : $result->tarif_grouper2,
          "grouper_at" => $result->grouper_at == null ? "" : $result->grouper_at,
          "status_kirim" => $result->status_kirim == null ? "" : $result->status_kirim,
          "status_klaim" => $result->status_klaim == null ? "" : $result->status_klaim,
          "verifikasi" => $result->verifikasi == null ? "" : $result->verifikasi,
          "tarif_prosedur_non_bedah" => $result->tarif_prosedur_non_bedah == null ? "" : $result->tarif_prosedur_non_bedah,
          "tarif_prosedur_bedah" => $result->tarif_prosedur_bedah == null ? "" : $result->tarif_prosedur_bedah,
          "tarif_konsultasi" => $result->tarif_konsultasi == null ? "" : $result->tarif_konsultasi,
          "tarif_tenaga_ahli" => $result->tarif_tenaga_ahli == null ? "" : $result->tarif_tenaga_ahli,
          "tarif_keperawatan" => $result->tarif_keperawatan == null ? "" : $result->tarif_keperawatan,
          "tarif_penunjang" => $result->tarif_penunjang == null ? "" : $result->tarif_penunjang,
          "tarif_radiologi" => $result->tarif_radiologi == null ? "" : $result->tarif_radiologi,
          "tarif_laboratorium" => $result->tarif_laboratorium == null ? "" : $result->tarif_laboratorium,
          "tarif_pelayanan_darah" => $result->tarif_pelayanan_darah == null ? "" : $result->tarif_pelayanan_darah,
          "tarif_rehabilitasi" => $result->tarif_rehabilitasi == null ? "" : $result->tarif_rehabilitasi,
          "tarif_kamar" => $result->tarif_kamar == null ? "" : $result->tarif_kamar,
          "tarif_rawat_intensif" => $result->tarif_rawat_intensif == null ? "" : $result->tarif_rawat_intensif,
          "tarif_obat" => $result->tarif_obat == null ? "" : $result->tarif_obat,
          "tarif_alkes" => $result->tarif_alkes == null ? "" : $result->tarif_alkes,
          "tarif_bmhp" => $result->tarif_bmhp == null ? "" : $result->tarif_bmhp,
          "tarif_sewa_alat" => $result->tarif_sewa_alat == null ? "" : $result->tarif_sewa_alat,
          "tarif_obat_kronis" => $result->tarif_obat_kronis == null ? "" : $result->tarif_obat_kronis,
          "tarif_obat_kemoterapi" => $result->tarif_obat_kemoterapi == null ? "" : $result->tarif_obat_kemoterapi
        );
        $rowNum++;
      }
      echo json_encode($newArr);
    }

    public function getLaporanTxtRawatJalan(){
      header('Content-Type: application/json');
      $startMonth = $_POST["startMonth"];
      $endMonth = $_POST["endMonth"];
      $laporanTxtRajal = $this->mlaporantxtbpjs->getTxtRawatJalan($startMonth,$endMonth)->result();

      $rowNum = 1;
		  $newArr  = array();
      foreach ($laporanTxtRajal as $result) {
        $newArr[] = array(
          "no" => $rowNum,
          "kelompokPenagihan" => $result->kelompok_penagihan == null ? "" : $result->kelompok_penagihan,
          "tanggalPelayanan" => $result->tanggal_layanan,
          "kelas" => $result->kelas,
          "poliklinik" => $result->ruang_poli,
          "noSep" => $result->no_sep == null ? "" : $result->no_sep,
          "namaPasien" => $result->nama,
          "diagnosa"=>$result->diagnosa,
          "kodeDiagnosa" => $result->id_diagnosa,
          "kodeCBG" => $result->cbg_code == null ? "" : $result->cbg_code,
          "deskripsiCBG" => $result->descripsi_inacg,
          "namaDokter" => $result->dokterdpjp,
          "spesialistik" => $result->spesialistik,
          "tarifInaCbg" => $result->tarif_rs==null? "" :$result->tarif_rs,
          "tarifTotal" => $result->tarif_rs_total==null? "" :$result->tarif_rs_total
        );
        $rowNum++;
      }
      echo json_encode($newArr);
    }

    public function laporanTxtEklaimDownload() {
      header('Content-Type: application/json');
      
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      $startTime = $_POST["startMonth"];
      $endTime = $_POST["endMonth"];
      $startTimeString = $_POST["startMonthString"];
      $endTimeString = $_POST["endMonthString"];

      $data = $this->mlaporantxtbpjs->getTxtEklaim($startTime,$endTime)->result();

      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
      $row = 2;

      $sheet->setCellValue('A1', 'No');
      $sheet->setCellValue('B1', 'No SEP');
      $sheet->setCellValue('C1', 'No Register');
      $sheet->setCellValue('D1', 'Nama');
      $sheet->setCellValue('E1', 'Tgl Lahir');
      $sheet->setCellValue('F1', 'No Kartu BPJS');
      $sheet->setCellValue('G1', 'Tgl Masuk');
      $sheet->setCellValue('H1', 'Tgl Pulang');
      $sheet->setCellValue('I1', 'Jenis Rawat');
      $sheet->setCellValue('J1', 'Kelas Rawat');
      $sheet->setCellValue('K1', 'Adl Sub Acute');
      $sheet->setCellValue('L1', 'Adl Chronic');
      $sheet->setCellValue('M1', 'Icu Indikator');
      $sheet->setCellValue('N1', 'icu Los');
      $sheet->setCellValue('O1', 'Jam Ventilator');
      $sheet->setCellValue('P1', 'Upgrade Class Ind');
      $sheet->setCellValue('Q1', 'Upgrade Class');
      $sheet->setCellValue('R1', 'Upgrade Class Los');
      $sheet->setCellValue('S1', 'Add Payment PCT');
      $sheet->setCellValue('T1', 'Birth Weight');
      $sheet->setCellValue('U1', 'Discharge Status');
      $sheet->setCellValue('V1', 'Diagnosa');
      $sheet->setCellValue('W1', 'Procedure');
      $sheet->setCellValue('X1', 'Tarif Poli Eks');
      $sheet->setCellValue('Y1', 'Dokter');
      $sheet->setCellValue('Z1', 'Kode Tarif');
      $sheet->setCellValue('AA1', 'Payor ID');
      $sheet->setCellValue('AB1', 'Payor CD');
      $sheet->setCellValue('AC1', 'Cob CD');
      $sheet->setCellValue('AD1', 'NIK');
      $sheet->setCellValue('AE1', 'Special CMG');
      $sheet->setCellValue('AF1', 'Kode INA-CBG');
      $sheet->setCellValue('AG1', 'Tarif CBG Kelas 1');
      $sheet->setCellValue('AH1', 'Tarif CBG Kelas 2');
      $sheet->setCellValue('AI1', 'Tgl Grouper');
      $sheet->setCellValue('AJ1', 'Status Kirim');
      $sheet->setCellValue('AK1', 'Status Klaim');
      $sheet->setCellValue('AL1', 'Verifikasi');
      $sheet->setCellValue('AM1', 'Tarif Prosedur Non Bedah');
      $sheet->setCellValue('AN1', 'Tarif Prosedur Bedah');
      $sheet->setCellValue('AO1', 'Tarif Konsul');
      $sheet->setCellValue('AP1', 'Tarif Tenaga Ahli');
      $sheet->setCellValue('AQ1', 'Tarif Keperawatan');
      $sheet->setCellValue('AR1', 'Tarif Penunjang');
      $sheet->setCellValue('AS1', 'Tarif Radiologi');
      $sheet->setCellValue('AT1', 'Tarif Lab');
      $sheet->setCellValue('AU1', 'Tarif Pelayanan Darah');
      $sheet->setCellValue('AV1', 'Tarif Rehab');
      $sheet->setCellValue('AW1', 'Tarif Kamar');
      $sheet->setCellValue('AX1', 'Tarif Rawat Intensif');
      $sheet->setCellValue('AY1', 'Tarif Obat');
      $sheet->setCellValue('AZ1', 'Tarif Alkes');
      $sheet->setCellValue('BA1', 'Tarif BMHP');
      $sheet->setCellValue('BB1', 'Tarif Sewa Alat');
      $sheet->setCellValue('BC1', 'Tarif Obat Kronis');
      $sheet->setCellValue('BD1', 'Tarif Obat Kemoterapi');

      $no = 1;  
      foreach($data as $result) {
        $sheet->setCellValue('A'.$row, $no++);
        $sheet->setCellValue('B'.$row, $result->no_sep == null ? "" : $result->no_sep);
        $sheet->setCellValue('C'.$row, $result->no_register == null ? "" : $result->no_register);
        $sheet->setCellValue('D'.$row, $result->nama_pasien == null ? "" : $result->nama_pasien);
        $sheet->setCellValue('E'.$row, $result->tgl_lahir == null ? "" : $result->tgl_lahir);
        $sheet->setCellValue('F'.$row, $result->nomor_kartu == null ? "" : $result->nomor_kartu);
        $sheet->setCellValue('G'.$row, $result->tgl_masuk == null ? "" : $result->tgl_masuk);
        $sheet->setCellValue('H'.$row, $result->tgl_pulang == null ? "" : $result->tgl_pulang);
        $sheet->setCellValue('I'.$row, $result->jenis_rawat == null ? "" : $result->jenis_rawat);
        $sheet->setCellValue('J'.$row, $result->kelas_rawat == null ? "" : $result->kelas_rawat);
        $sheet->setCellValue('K'.$row, $result->adl_sub_acute == null ? "" : $result->adl_sub_acute);
        $sheet->setCellValue('L'.$row, $result->adl_chronic == null ? "" : $result->adl_chronic);
        $sheet->setCellValue('M'.$row, $result->icu_indikator == null ? "" : $result->icu_indikator);
        $sheet->setCellValue('N'.$row, $result->icu_los == null ? "" : $result->icu_los);
        $sheet->setCellValue('O'.$row, $result->ventilator_hour == null ? "" : $result->ventilator_hour);
        $sheet->setCellValue('P'.$row, $result->upgrade_class_ind == null ? "" : $result->upgrade_class_ind);
        $sheet->setCellValue('Q'.$row, $result->upgrade_class_class == null ? "" : $result->upgrade_class_class);
        $sheet->setCellValue('R'.$row, $result->upgrade_class_los == null ? "" : $result->upgrade_class_los);
        $sheet->setCellValue('S'.$row, $result->add_payment_pct == null ? "" : $result->add_payment_pct);
        $sheet->setCellValue('T'.$row, $result->birth_weight == null ? "" : $result->birth_weight);
        $sheet->setCellValue('U'.$row, $result->discharge_status == null ? "" : $result->discharge_status);
        $sheet->setCellValue('V'.$row, $result->diagnosa == null ? "" : $result->diagnosa);
        $sheet->setCellValue('W'.$row, $result->procedure == null ? "" : $result->procedure);
        $sheet->setCellValue('X'.$row, $result->tarif_poli_eks == null ? "" : $result->tarif_poli_eks);
        $sheet->setCellValue('Y'.$row, $result->nama_dokter == null ? "" : $result->nama_dokter);
        $sheet->setCellValue('Z'.$row, $result->kode_tarif == null ? "" : $result->kode_tarif);
        $sheet->setCellValue('AA'.$row, $result->payor_id == null ? "" : $result->payor_id);
        $sheet->setCellValue('AB'.$row, $result->payor_cd == null ? "" : $result->payor_cd);
        $sheet->setCellValue('AC'.$row, $result->cob_cd == null ? "" : $result->cob_cd);
        $sheet->setCellValue('AD'.$row, $result->coder_nik == null ? "" : $result->coder_nik);
        $sheet->setCellValue('AE'.$row, $result->special_cmg == null ? "" : $result->special_cmg);
        $sheet->setCellValue('AF'.$row, $result->cbg_code == null ? "" : $result->cbg_code);
        $sheet->setCellValue('AG'.$row, $result->tarif_grouper1 == null ? "" : $result->tarif_grouper1);
        $sheet->setCellValue('AH'.$row, $result->tarif_grouper2 == null ? "" : $result->tarif_grouper2);
        $sheet->setCellValue('AI'.$row, $result->grouper_at == null ? "" : $result->grouper_at);
        $sheet->setCellValue('AJ'.$row, $result->status_kirim == null ? "" : $result->status_kirim);
        $sheet->setCellValue('AK'.$row, $result->status_klaim == null ? "" : $result->status_klaim);
        $sheet->setCellValue('AL'.$row, $result->verifikasi == null ? "" : $result->verifikasi);
        $sheet->setCellValue('AM'.$row, $result->tarif_prosedur_non_bedah == null ? "" : $result->tarif_prosedur_non_bedah);
        $sheet->setCellValue('AN'.$row, $result->tarif_prosedur_bedah == null ? "" : $result->tarif_prosedur_bedah);
        $sheet->setCellValue('AO'.$row, $result->tarif_konsultasi == null ? "" : $result->tarif_konsultasi);
        $sheet->setCellValue('AP'.$row, $result->tarif_tenaga_ahli == null ? "" : $result->tarif_tenaga_ahli);
        $sheet->setCellValue('AQ'.$row, $result->tarif_keperawatan == null ? "" : $result->tarif_keperawatan);
        $sheet->setCellValue('AR'.$row, $result->tarif_penunjang == null ? "" : $result->tarif_penunjang);
        $sheet->setCellValue('AS'.$row, $result->tarif_radiologi == null ? "" : $result->tarif_radiologi);
        $sheet->setCellValue('AT'.$row, $result->tarif_laboratorium == null ? "" : $result->tarif_laboratorium);
        $sheet->setCellValue('AU'.$row, $result->tarif_pelayanan_darah == null ? "" : $result->tarif_pelayanan_darah);
        $sheet->setCellValue('AV'.$row, $result->tarif_rehabilitasi == null ? "" : $result->tarif_rehabilitasi);
        $sheet->setCellValue('AW'.$row, $result->tarif_kamar == null ? "" : $result->tarif_kamar);
        $sheet->setCellValue('AX'.$row, $result->tarif_rawat_intensif == null ? "" : $result->tarif_rawat_intensif);
        $sheet->setCellValue('AY'.$row, $result->tarif_obat == null ? "" : $result->tarif_obat);
        $sheet->setCellValue('AZ'.$row, $result->tarif_alkes == null ? "" : $result->tarif_alkes);
        $sheet->setCellValue('BA'.$row, $result->tarif_bmhp == null ? "" : $result->tarif_bmhp);
        $sheet->setCellValue('BB'.$row, $result->tarif_sewa_alat == null ? "" : $result->tarif_sewa_alat);
        $sheet->setCellValue('BC'.$row, $result->tarif_obat_kronis == null ? "" : $result->tarif_obat_kronis);
        $sheet->setCellValue('BD'.$row, $result->tarif_obat_kemoterapi == null ? "" : $result->tarif_obat_kemoterapi);
        $row++;
      }

      $filename ='Laporan_Txt_Eklaim'.$startTimeString.'_'.$endTimeString;
      // exit();
      ob_start();
      $writer = new Xlsx($spreadsheet);
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

    public function laporanTxtRawatJalanDownload(){
      header('Content-Type: application/json');
      
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      $startTime = $_POST["startMonth"];
      $endTime = $_POST["endMonth"];
      $startTimeString = $_POST["startMonthString"];
      $endTimeString = $_POST["endMonthString"];

      $laporanTxtRajal = $this->mlaporantxtbpjs->getTxtRawatJalan($startTime,$endTime)->result();

      // print_r($laporanTxtRajal);
      // exit();
      $spreadsheet->setActiveSheetIndex(0);
      //name the worksheet
      $sheet->setTitle('Worksheet 1');
      $row = 5;

      $sheet->setCellValue('A1','Laporan Txt BPJS Rawat Jalan');
		  $sheet->mergeCells('A1:N1');
      $sheet->setCellValue('A3',$startTimeString." s/d ".$endTimeString);
      
      $sheet->setCellValue('A4', 'No');
      $sheet->setCellValue('B4', 'Kelompok Penagihan');
      $sheet->setCellValue('C4', 'Tanggal Pelayanan');
      $sheet->setCellValue('D4', 'Kelas');
      $sheet->setCellValue('E4', 'Ruang Poli (Terakhir)');
      $sheet->setCellValue('F4', 'SEP');
      $sheet->setCellValue('G4', 'Nama Pasien');
      $sheet->setCellValue('H4', 'Diagnosa');
      $sheet->setCellValue('I4', 'Kode INA-CBG');
      $sheet->setCellValue('J4', 'Deskripsi INA-CBG');
      $sheet->setCellValue('K4', 'Nama DPJP');
      $sheet->setCellValue('L4', 'Spesialistik');
      $sheet->setCellValue('M4', 'Tarif INA-CBG');
      $sheet->setCellValue('N4', 'Tarif RS Total');

      $no = 1;
      foreach ($laporanTxtRajal as $result) {
        $sheet->setCellValue('A'.$row, $no);
        $sheet->setCellValue('B'.$row, $result->kelompok_penagihan);
        $sheet->setCellValue('C'.$row, $result->tanggal_layanan);
        $sheet->setCellValue('D'.$row, $result->kelas);
        $sheet->setCellValue('E'.$row, $result->ruang_poli);
        $sheet->setCellValue('F'.$row, $result->no_sep == null ? "" : $result->no_sep);
        $sheet->setCellValue('G'.$row, $result->nama);
        $sheet->setCellValue('H'.$row, $result->diagnosa);
        $sheet->setCellValue('I'.$row, $result->cbg_code == null ? "" : $result->cbg_code);
        $sheet->setCellValue('J'.$row, $result->descripsi_inacg);
        $sheet->setCellValue('K'.$row, $result->dokterdpjp);
        $sheet->setCellValue('L'.$row, $result->spesialistik);
        $sheet->setCellValue('M'.$row, $result->tarif_rs==null? "" :$result->tarif_rs);
        $sheet->setCellValue('N'.$row, $result->tarif_rs_total==null? "" :$result->tarif_rs_total);
        $row++;
        $no++;
      }

      $filename ='Laporan_Txt_BPJS_Rawat_Jalan'.$startTimeString.'_'.$endTimeString;
      // exit();
      ob_start();
      $writer = new Xlsx($spreadsheet);
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
?>