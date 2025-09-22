<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once(APPPATH.'controllers/Secure_area.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include('Frmcterbilang.php');
class Frmcstok extends Secure_area
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('logistik_farmasi/Frmmtransaksi', '', TRUE);
    $this->load->model('logistik_farmasi/Frmmpemasok', '', TRUE);
    $this->load->model('logistik_farmasi/Frmmdistribusi', '', TRUE);
    $this->load->model('logistik_farmasi/Frmmstok', '', TRUE);
    $this->load->model('master/Mmobat', '', TRUE);
    $this->load->model('farmasi/Frmmdaftar', '', TRUE);
    $this->load->model('logistik_farmasi/Frmmpo', '', TRUE);
    $this->load->library('session');
    $this->load->helper('pdf_helper');
  }

  function index($all_gudang = '')
  {
    $data['all_gudang'] = $all_gudang;
    $data['title'] = 'Stok Barang';
    $data['select_gudang'] = $this->Frmmstok->get_data_gudang()->result();
    $data['kelompok'] = $this->Mmobat->get_data_kelompok_obat()->result();
    $data['jenis'] = $this->Mmobat->get_data_jenis()->result();
    $data['subkelompok'] = $this->Mmobat->get_data_subkelompok_obat()->result();
    $login_data = $this->load->get_var("user_info");
    $data['roleid'] = $this->Frmmstok->get_roleid($login_data->userid)->row()->roleid;
    // var_dump($data['roleid']);die();
    $data['id_gudang'] = $this->Frmmstok->get_gudangid($login_data->userid)->row()->id_gudang;
    $data['gudang'] = $this->Frmmstok->getnama_gudang($data['id_gudang'])->row()->nama_gudang;
    //  var_dump( $data['gudang']);die();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data['title'] = "Stock Gudang";
      $data['kel'] = $this->input->post('kel');
      $data['sub'] = $this->input->post('subkel');
      $data['jns'] = $this->input->post('jenis_obat');
      $data['rolegd'] = $this->input->post('role');

      if ($data['kel'] != null && $data['sub'] == null && $data['jns'] == null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_kelompok($data['kel'], $data['rolegd'])->result();
      } else if ($data['sub'] != null && $data['kel'] == null && $data['jns'] == null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_subkelompok($data['sub'], $data['rolegd'])->result();
      } else if ($data['sub'] == null && $data['kel'] == null && $data['jns'] != null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_jenis($data['jns'], $data['rolegd'])->result();
      } else if ($data['sub'] != null && $data['kel'] != null && $data['jns'] == null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_subkelompok_kel($data['sub'], $data['kel'], $data['rolegd'])->result();
      } else if ($data['sub'] == null && $data['kel'] != null && $data['jns'] != null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_jns_kel($data['jns'], $data['kel'], $data['rolegd'])->result();
      } else if ($data['sub'] != null && $data['kel'] == null && $data['jns'] != null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_jns_sub($data['jns'], $data['sub'], $data['rolegd'])->result();
      } else if ($data['sub'] != null && $data['kel'] != null && $data['jns'] != null) {
        $data['data_barang'] = $this->Frmmstok->get_all_obat_by_jns_sub_kel($data['jns'], $data['sub'], $data['kel'], $data['rolegd'])->result();
      } else {
        $data['data_barang'] = $this->Frmmstok->getdata_gudang_inventory_by_role($data['rolegd'])->result();
      }
      $this->load->view('logistik_farmasi/Frmvdaftarstok', $data);
    } else {
      $i = 1;
      if ($all_gudang == '') {
        $id_gudang = $this->Frmmstok->get_gudangid($login_data->userid)->result();
        // var_dump($id_gudang);die();
        foreach ($id_gudang as $row) {
          $data['rolegd'] = $row->id_gudang;
          if ($i == 1) {
            $gd = $this->Frmmstok->getdata_gudang_inventory_by_role($row->id_gudang)->result();
          } else {
            // var_dump($row->id_gudang);die();
            $gd = array_merge($gd, $this->Frmmstok->getdata_gudang_inventory_by_role($row->id_gudang)->result());
            // var_dump($gd);die();
          }

          $i++;
        }
      } else {
        // echo 'masuk sini';die();
        $gd = $this->Frmmstok->getdata_gudang_inventory_by_role('')->result();
      }



      // print_r($gd);die();
      $data['data_barang'] = $gd;
      $data['alloabt'] = $this->Frmmstok->get_all_obat()->result();
      $data['allgudang'] = $this->Frmmstok->get_all_gudang()->result();
      $this->load->view('logistik_farmasi/Frmvdaftarstok', $data);
    }
  }

  public function cetak_label($batch_no)
  {
    error_reporting(~E_ALL);
    if ($batch_no != '') {
      //var_dump($no_ipd);die();
      $data = $this->Frmmstok->get_data_batch($batch_no)->row();
      // print_r($data_pasien);die();
      tcpdf();
      $obj_pdf = new TCPDF('L', 'mm', array('40', '65'), true, 'UTF-8', false);
      // TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
      // TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $title = "";
      $obj_pdf->SetTitle($title);
      $obj_pdf->SetHeaderData('', '', $title, '');
      // $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      // $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);
      $obj_pdf->SetDefaultMonospacedFont('helvetica');
      // $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      // $obj_pdf->SetFooterMargin('5');
      $obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
      $obj_pdf->SetAutoPageBreak(TRUE, '10');
      $obj_pdf->SetFont('helvetica', '', 9);
      $obj_pdf->setFontSubsetting(false);
      // $obj_pdf->rotate(-90, 25, 25);
      // 
      // --- Rotation --------------------------------------------
      // $obj_pdf->SetDrawColor(200);
      // $obj_pdf->Rect(1, 1, 84, 52, 'D');
      $obj_pdf->SetDrawColor(0);
      $obj_pdf->SetTextColor(0);
      // Start Transformation
      $obj_pdf->StartTransform();
      // Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
      // $obj_pdf->Rotate(-90, 1, 1);
      // $obj_pdf->Translate(20, -47);
      //$obj_pdf->SetXY(0, 10);
      //$obj_pdf->Rect(1, 1, 84, 52, 'D');

      // new style
      $style = array(
        'border' => false,
        'padding' => 0,
        'fgcolor' => array(128, 0, 0),
        'bgcolor' => false,
      );

      // $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
      $params = $obj_pdf->serializeTCPDFtagParameters(array($data->id_inventory, 'C128', '', '', 20, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

      // print_r($data_pasien[0]);die();


      //foreach ($data as $row) {
      //$tgl_lahir = date('d-m-Y', strtotime($row['tgl_lahir']));

      // $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
      // $html.=
      // "
      // 	<br/>
      // 	<style type=\"text/css\">
      // .table-font-size{
      // 	margin-top:9px;
      //     }
      // .nama-pasien{
      // 	font-size:9px;
      //     }
      // </style>
      // <table class=\"table-font-size\" border=\"0\" width=\"300px\">
      // 		<tr>
      // 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
      // 		</tr>
      // 		<tr>
      // 			<td colspan=\"2\">No Register : $no_ipd</td>
      // 		</tr>
      // 		<tr>
      // 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
      // 		</tr>
      // 		<tr>
      // 			<td>Tgl. Lahir : $tgl_lahir</td>
      // 			<td>JK : ".$row['sex']."</td>
      // 		</tr>
      // 		<tr>
      // 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
      // 		</tr>
      // </table>
      // ";



      $html .=
        "
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:8px;
				    }
				.rs{
					font-size:7px;
					}
				.list{
					font-size:7px;
					}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
						<tr>
							<td colspan=\"2\" class=\"nama-pasien\"><b>" . $data->nm_obat . "</b></td>
						</tr>
						<tr>
							<td class=\"list\" width=\"30%\"><b>Batch : " . $data->batch_no . "</b><br>
							" . $data->id_inventory . "<br>
							Exp Date : " . $data->expire_date . "
							</td>

							<td width=\"70%\">";
      $html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
      $html .= "
							</td>
						</tr>
						<tr>
							<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
						</tr>
				</table>
				";
      //}




      $style = array(
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false
      );
      // $obj_pdf->AddPage();
      // $obj_pdf->writeHTML($html, true, 0, true, 0);
      // $obj_pdf->AddPage();
      // $obj_pdf->writeHTML($html, true, 0, true, 0);
      // $obj_pdf->AddPage();
      // $obj_pdf->writeHTML($html, true, 0, true, 0);
      // $obj_pdf->AddPage();
      // $obj_pdf->writeHTML($html, true, 0, true, 0);
      $obj_pdf->AddPage();
      $obj_pdf->writeHTML($html, true, 0, true, 0);

      $obj_pdf->Translate(20, 0);

      // $obj_pdf->Text(3, 44, $nrp);

      // $obj_pdf->Text(3, 22, $no_cm);
      // $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
      // $obj_pdf->Text(3, 32, $tgl_lahir);



      // Stop Transformation
      $obj_pdf->StopTransform();


      // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

      // reset pointer to the last page
      $obj_pdf->lastPage();

      // ---------------------------------------------------------

      //Close and output PDF document
      $obj_pdf->Output('barcode label', 'I');
    } else {
      redirect('logistik_farmasi/frmcstok/index', 'refresh');
    }
  }

  function edit_hargajual($idinventory)
  {
    $data['title'] = 'Edit Harga Jual';

    $data['detail'] = $this->Frmmstok->get_detail_stok($idinventory)->row();

    // print_r($data['detail']);die();

    $this->load->view('logistik_farmasi/Frmvedithargajual', $data);
  }

  function update_harga_jual()
  {

    $dataupdate['hargajual'] = $this->input->post('hargajual');
    $id_inventory = $this->input->post('id_inventory');
    $this->Frmmstok->update_hargajual($dataupdate, $id_inventory);
    echo "sukses";
    // var_dump($this->input->post());die();

  }

  function index2()
  {
    $data['title'] = 'Stok Barang';
    $data['select_gudang'] = $this->Frmmstok->get_data_gudang()->result();
    $data['data_barang'] = $this->Frmmstok->getdata_gudang_inventory()->result();

    $this->load->view('logistik_farmasi/Frmvlapstok', $data);
  }

  public function get_data_detail_gudang()
  {
    $nm_gudang = $this->input->post('nm_gudang');
    $datajson = $this->Frmmdistribusi->getdata_gudang_inventory($nm_gudang)->result();
    echo json_encode($datajson);
  }

  public function get_data_master_gudang_all()
  {
    $login_data = $this->load->get_var("user_info");
    $id_gudang = $this->Frmmstok->get_gudangid($login_data->userid)->result();
    $id = isset($id_gudang[0]->id_gudang) ? $id_gudang[0]->id_gudang : null;
    //  var_dump();die();
    echo json_encode($this->Frmmdistribusi->get_data_master_gudang_all($id));
  }

  public function exceldown($nm_gudang)
  {
    // var_dump($nm_gudang);die();
    $data['title'] = 'Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta';
    // $nm_gudangreal=str_ireplace("%20"," ",$nm_gudang);  
    // var_dump($nm_gudangreal);die();  
    $namars = $this->config->item('namars');
    $alamat = $this->config->item('alamat');
    $kota_kab = $this->config->item('kota');

    // $nm_gudang=$this->input->post('nm_gudang');
    $datajson = $this->Frmmstok->get_data_gudang_detail($nm_gudang)->result();
    //print_r($datajson);break;
    ////EXCEL 
    // $this->load->library('Excel');  

    // Create new PHPExcel object  
    // $objPHPExcel = new PHPExcel();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // $spreadsheet->getProperties()->setCreator($namars)  
    //         ->setLastModifiedBy($namars)  
    //         ->setTitle("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars)  
    //         ->setSubject("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." Document")  
    //         ->setDescription("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." for Office 2007 XLSX, generated by HMIS.")  
    //         ->setKeywords($namars)  
    //         ->setCategory("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta");  

    // $objReader= PHPExcel_IOFactory::createReader('Excel2007');
    // $objReader->setReadDataOnly(true);
    $date = date('Y-m-d');
    $date_title = date('d F Y', strtotime($date));

    // $objPHPExcel=$objReader->load(APPPATH.'third_party/log_farm_stok_gudang.xlsx');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
    // $objPHPExcel->setActiveSheetIndex(0);  
    // Add some data  
    $sheet->SetCellValue('A1', $data['title'] . ' ' . $nm_gudang);
    $sheet->SetCellValue('A2', 'Tanggal : ' . $date_title);

    $i = 1;
    $rowCount = 5;
    $qtytot = 0;
    foreach ($datajson as $row) {
      $qtytot += $row->qty;
      $sheet->SetCellValue('A' . $rowCount, $i);
      $sheet->SetCellValue('B' . $rowCount, $row->batch_no);
      //SetCellValue('B'.$rowCount, $row->no_medrec);
      $sheet->SetCellValue('C' . $rowCount, $row->nm_obat);
      $sheet->SetCellValue('D' . $rowCount, $row->qty);
      $sheet->SetCellValue('E' . $rowCount, $row->expire_date);
      $i++;

      $rowCount++;
    }

    // $sheet->SetCellValue('C'.$rowCount, 'Total');
    //     $sheet->SetCellValue('D'.$rowCount, $qtytot);
    //     $sheet->getStyle('D'.$rowCount)->applyFromArray(
    //         array(
    //       'fill' => array(
    //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //           'color' => array('rgb' => 'C1B2B2')
    //       )
    //         )
    //     );



    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"');  


    // $sheet->setTitle($namars);  

    // Redirect output to a client’s web browser (Excel2007)  
    //clean the output buffer  
    // ob_end_clean();  

    //this is the header given from PHPExcel examples.   
    //but the output seems somewhat corrupted in some cases.  
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
    //so, we use this header instead.  
    // header('Content-type: application/vnd.ms-excel');  
    // header('Cache-Control: max-age=0');  

    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    // $objWriter->save('php://output');

    $writer = new Xlsx($spreadsheet);
    // $filename = 'excel';
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Excel_Gudang_' . $date . '_' . $nm_gudang . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }

  public function exceldown_so($nm_gudang)
  {
    // var_dump($nm_gudang);die();
    $data['title'] = 'Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta';
    // $nm_gudangreal=str_ireplace("%20"," ",$nm_gudang);    
    $namars = $this->config->item('namars');
    $alamat = $this->config->item('alamat');
    $kota_kab = $this->config->item('kota');

    // $nm_gudang=$this->input->post('nm_gudang');
    $datajson = $this->Frmmstok->get_data_gudang_detail($nm_gudang)->result();
    $gudang =  $datajson[0]->nama_gudang;
    //print_r($datajson);break;;
    ////EXCEL 
    // $this->load->library('Excel');  

    // Create new PHPExcel object  
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // $objPHPExcel = new PHPExcel();

    // $objPHPExcel->getProperties()->setCreator($namars)  
    //         ->setLastModifiedBy($namars)  
    //         ->setTitle("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars)
    //         ->setSubject("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." Document")  
    //         ->setDescription("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." for Office 2007 XLSX, generated by HMIS.")  
    //         ->setKeywords($namars)  
    //         ->setCategory("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta");

    // $objReader= PHPExcel_IOFactory::createReader('Excel2007');
    // $objReader->setReadDataOnly(true);
    $date = date('Y-m-d');
    $date_title = date('d F Y', strtotime($date));

    // $objPHPExcel=$objReader->load(APPPATH.'third_party/log_farm_stok_opname.xlsx');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
    // $objPHPExcel->setActiveSheetIndex(0);  
    // Add some data  
    $sheet->SetCellValue('A1', $data['title'] . ' ' . $gudang);
    $sheet->SetCellValue('A2', 'Tanggal : ' . $date_title);
    $sheet->SetCellValue('A4', 'idobat');
    $sheet->SetCellValue('B4', 'Batch');
    $sheet->SetCellValue('C4', 'nama obat');
    $sheet->SetCellValue('D4', 'Harga Beli');
    $sheet->SetCellValue('E4', 'Harga Jual');
    $sheet->SetCellValue('F4', 'Expire Date');
    $sheet->SetCellValue('G4', 'Jenis Obat');
    $sheet->SetCellValue('H4', 'Qty');

    $i = 1;
    $rowCount = 5;
    $qtytot = 0;
    foreach ($datajson as $row) {
      $qtytot += $row->qty;
      $sheet->SetCellValue('A' . $rowCount, $row->id_obat);
      $sheet->SetCellValue('B' . $rowCount, $row->batch_no);
      //SetCellValue('B'.$rowCount, $row->no_medrec);
      $sheet->SetCellValue('C' . $rowCount, $row->nm_obat);
      $sheet->SetCellValue('D' . $rowCount, $row->hargabeli);
      $sheet->SetCellValue('E' . $rowCount, $row->hargajual);
      $sheet->SetCellValue('F' . $rowCount, $row->expire_date);
      $sheet->SetCellValue('G' . $rowCount, $row->jenis_obat);
      $sheet->SetCellValue('H' . $rowCount, $row->qty);
      $sheet->SetCellValue('I' . $rowCount, "0");
      $i++;

      $rowCount++;
    }

    /*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $qtytot);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->applyFromArray(
            array(
          'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'C1B2B2')
          )
            )
        );*/

    header('Content-Disposition: attachment;filename="Excel_Gudang_' . $date . '_' . $gudang . '.xlsx"');

    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"'); 
    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"');  

    // $objPHPExcel->getActiveSheet()->setTitle($namars);  

    // Redirect output to a client’s web browser (Excel2007)  
    //clean the output buffer  
    // ob_end_clean();  

    //this is the header given from PHPExcel examples.   
    //but the output seems somewhat corrupted in some cases.  
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
    //so, we use this header instead.  
    // header('Content-type: application/vnd.ms-excel');  
    // header('Cache-Control: max-age=0');  

    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    // $objWriter->save('php://output');
    $writer = new Xlsx($spreadsheet);
    // $filename = 'excel';
    header('Content-type: application/vnd.ms-excel');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }



  public function exceldown_so_expire($nm_gudang)
  {
    // var_dump($nm_gudang);die();
    $data['title'] = 'Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta';
    // $nm_gudangreal=str_ireplace("%20"," ",$nm_gudang);    
    $namars = $this->config->item('namars');
    $alamat = $this->config->item('alamat');
    $kota_kab = $this->config->item('kota');

    // $nm_gudang=$this->input->post('nm_gudang');
    $datajson = $this->Frmmstok->get_data_gudang_detail_expire($nm_gudang)->result();
    $gudang =  $datajson[0]->nama_gudang;
    //print_r($datajson);break;;
    ////EXCEL 
    // $this->load->library('Excel');  

    // Create new PHPExcel object  
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // $objPHPExcel = new PHPExcel();

    // $objPHPExcel->getProperties()->setCreator($namars)  
    //         ->setLastModifiedBy($namars)  
    //         ->setTitle("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars)
    //         ->setSubject("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." Document")  
    //         ->setDescription("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." for Office 2007 XLSX, generated by HMIS.")  
    //         ->setKeywords($namars)  
    //         ->setCategory("Laporan Gudang Rumah Sakit Otak DR. Drs. M. Hatta");

    // $objReader= PHPExcel_IOFactory::createReader('Excel2007');
    // $objReader->setReadDataOnly(true);
    $date = date('Y-m-d');
    $date_title = date('d F Y', strtotime($date));

    // $objPHPExcel=$objReader->load(APPPATH.'third_party/log_farm_stok_opname.xlsx');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
    // $objPHPExcel->setActiveSheetIndex(0);  
    // Add some data  
    $sheet->SetCellValue('A1', $data['title'] . ' ' . $gudang);
    $sheet->SetCellValue('A2', 'Tanggal : ' . $date_title);
    $sheet->SetCellValue('A4', 'idobat');
    $sheet->SetCellValue('B4', 'Batch');
    $sheet->SetCellValue('C4', 'nama obat');
    $sheet->SetCellValue('D4', 'Harga Beli');
    $sheet->SetCellValue('E4', 'Harga Jual');
    $sheet->SetCellValue('F4', 'Expire Date');
    $sheet->SetCellValue('G4', 'Jenis Obat');
    $sheet->SetCellValue('H4', 'Qty');

    $i = 1;
    $rowCount = 5;
    $qtytot = 0;
    foreach ($datajson as $row) {
      $qtytot += $row->qty;
      $sheet->SetCellValue('A' . $rowCount, $row->id_obat);
      $sheet->SetCellValue('B' . $rowCount, $row->batch_no);
      //SetCellValue('B'.$rowCount, $row->no_medrec);
      $sheet->SetCellValue('C' . $rowCount, $row->nm_obat);
      $sheet->SetCellValue('D' . $rowCount, $row->hargabeli);
      $sheet->SetCellValue('E' . $rowCount, $row->hargajual);
      $sheet->SetCellValue('F' . $rowCount, $row->expire_date);
      $sheet->SetCellValue('G' . $rowCount, $row->jenis_obat);
      $sheet->SetCellValue('H' . $rowCount, $row->qty);
      $sheet->SetCellValue('I' . $rowCount, "0");
      $i++;

      $rowCount++;
    }

    /*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $qtytot);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->applyFromArray(
            array(
          'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'C1B2B2')
          )
            )
        );*/

    header('Content-Disposition: attachment;filename="Excel_Expire_' . $date . '_' . $gudang . '.xlsx"');

    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"'); 
    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"');  

    // $objPHPExcel->getActiveSheet()->setTitle($namars);  

    // Redirect output to a client’s web browser (Excel2007)  
    //clean the output buffer  
    // ob_end_clean();  

    //this is the header given from PHPExcel examples.   
    //but the output seems somewhat corrupted in some cases.  
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
    //so, we use this header instead.  
    // header('Content-type: application/vnd.ms-excel');  
    // header('Cache-Control: max-age=0');  

    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    // $objWriter->save('php://output');
    $writer = new Xlsx($spreadsheet);
    // $filename = 'excel';
    header('Content-type: application/vnd.ms-excel');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }

  public function exceldown_hasilso($nm_gudang)
  {
    // $nm_gudangreal=str_ireplace("%20"," ",$nm_gudang);    
    $data['title'] = 'Laporan Hasil SO Rumah Sakit Otak DR. Drs. M. Hatta ' . $nm_gudang;
    $namars = $this->config->item('namars');
    $alamat = $this->config->item('alamat');
    $kota_kab = $this->config->item('kota');

    // $nm_gudang=$this->input->post('nm_gudang');
    $datajson = $this->Frmmstok->get_last_so_by_gudang_name($nm_gudang)->result();
    //print_r($datajson);break;
    ////EXCEL 
    // $this->load->library('Excel');  

    // Create new PHPExcel object  

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // $objPHPExcel = new PHPExcel();

    // $objPHPExcel->getProperties()->setCreator($namars)  
    //         ->setLastModifiedBy($namars)  
    //         ->setTitle("Laporan Hasil SO Rumah Sakit Otak DR. Drs. M. Hatta ".$namars."  ".$nm_gudang)  
    //         ->setSubject("Laporan Hasil SO Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." Document")  
    //         ->setDescription("Laporan Hasil SO Rumah Sakit Otak DR. Drs. M. Hatta ".$namars." for Office 2007 XLSX, generated by HMIS.")  
    //         ->setKeywords($namars)  
    //         ->setCategory("Laporan Hasil SO Rumah Sakit Otak DR. Drs. M. Hatta");

    // $objReader= PHPExcel_IOFactory::createReader('Excel2007');
    // $objReader->setReadDataOnly(true);
    $date = date('Y-m-d');
    $date_title = date('d F Y', strtotime($date));

    // $objPHPExcel=$objReader->load(APPPATH.'third_party/log_farm_hasil_so.xlsx');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
    // $objPHPExcel->setActiveSheetIndex(0);  
    // Add some data  
    $sheet->SetCellValue('A1', $data['title'] . ' ' . $nm_gudangreal);
    $sheet->SetCellValue('A2', 'Tanggal : ' . $date_title);

    $i = 1;
    $rowCount = 5;
    $qtytot = 0;
    foreach ($datajson as $row) {
      $qtytot += $row->qty;
      $sheet->SetCellValue('A' . $rowCount, $row->id_obat);
      $sheet->SetCellValue('B' . $rowCount, $row->batch_no);
      //SetCellValue('B'.$rowCount, $row->no_medrec);
      $sheet->SetCellValue('C' . $rowCount, $row->nm_obat);
      $sheet->SetCellValue('D' . $rowCount, $row->hargabeli);
      $sheet->SetCellValue('E' . $rowCount, $row->hargajual);
      $sheet->SetCellValue('F' . $rowCount, $row->jenis_obat);
      $sheet->SetCellValue('G' . $rowCount, $row->expire_date);
      $sheet->SetCellValue('H' . $rowCount, $row->qty);
      $i++;

      $rowCount++;
    }

    // $sheet->SetCellValue('F'.$rowCount, 'Total');
    // $sheet->SetCellValue('H'.$rowCount, $qtytot);
    // $sheet->getStyle('F'.$rowCount)->applyFromArray(
    //     array(
    //   'fill' => array(
    //       'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //       'color' => array('rgb' => 'C1B2B2')
    //   )
    //     )
    // );



    header('Content-Disposition: attachment;filename="Excel_Gudang_' . $date . '_' . $nm_gudang . '.xlsx"');
    // header('Content-Disposition: attachment;filename="Excel_Gudang_'.$date.'_'.$nm_gudangreal.'.xlsx"');  

    // $sheet->setTitle($namars);  

    // Redirect output to a client’s web browser (Excel2007)  
    //clean the output buffer  
    ob_end_clean();

    //this is the header given from PHPExcel examples.   
    //but the output seems somewhat corrupted in some cases.  
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
    //so, we use this header instead.  
    // header('Content-type: application/vnd.ms-excel');  
    // header('Cache-Control: max-age=0');  

    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
    // $objWriter->save('php://output');
    $writer = new Xlsx($spreadsheet);
    // $filename = 'excel';
    header('Content-type: application/vnd.ms-excel');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }

  public function stokOpname()
  {
    $data['title'] = 'Input Stock Opname';

    $userid = $this->session->userid;
    $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

    $data['data_so'] = $this->Frmmstok->get_last_so($group)->result();
    $this->load->view('logistik_farmasi/frmvstokopname', $data);
  }

  public function insert_stokopname()
  {
    $userid = $this->session->userid;
    $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

    $data['id_obat'] = $this->input->post('id_obat');
    $data['hargabeli'] = $this->input->post('biaya_obat');
    $data['hargajual'] = $this->input->post('harga_jual');
    $data['expire_date'] = $this->input->post('expire_date');
    $data['batch_no'] = $this->input->post('batch_no');
    $data['qty'] = $this->input->post('qty');
    $data['jenis_obat'] = $this->input->post('jenis_obat');
    $data['created_date'] = date('Y-m-d h:i:s');
    $data['id_gudang'] = $group;

    $save = $this->Frmmstok->insert_stokopname($data);
    redirect('logistik_farmasi/Frmcstok/stokOpname');
  }

  public function edit_stokopname()
  {
    $userid = $this->session->userid;
    $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

    $data['id_obat'] = $this->input->post('id_obat');
    $data['hargabeli'] = $this->input->post('biaya_obat');
    $data['hargajual'] = $this->input->post('harga_jual');
    $data['expire_date'] = $this->input->post('expire_date');
    $data['batch_no'] = $this->input->post('batch_no');
    $data['qty'] = $this->input->post('qty');
    $data['jenis_obat'] = $this->input->post('jenis_obat');
    $data['created_date'] = date('Y-m-d h:i:s');
    $data['id_gudang'] = $group;
    $save = $this->Frmmstok->edit_stokopname($data);
    redirect('logistik_farmasi/Frmcstok/stokOpname');
  }

  public function delete_stokopname()
  {
    $data['id_obat'] = $this->input->post('id_obat');
    $data['batch_no'] = $this->input->post('batch_no');

    $delete = $this->Frmmstok->delete_stokopname($data);
    redirect('logistik_farmasi/Frmcstok/stokOpname');
  }

  public function edit_hasil_so($id_obat)
  {
    $data['title'] = 'Edit Stock Opname';
    $userid = $this->session->userid;
    $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

    $data['itemso'] = $this->Frmmstok->get_item_so($id_obat, $group)->row();
    $data['jenis'] = $this->Frmmstok->get_new_jenisobat()->result();

    $this->load->view('logistik_farmasi/Frmveditstokopname', $data);
  }

  function edit_stok($idinventory)
  {
    $data['title'] = 'Edit Stok Obat';

    $data['detail'] = $this->Frmmstok->get_detail_stok($idinventory)->row();

    //  print_r($data['detail']);die();

    $this->load->view('logistik_farmasi/Frmveditstokgudang', $data);
  }

  function update_stok()
  {
    // var_dump($this->input->post());die();
    $login_data = $this->load->get_var("user_info");
    $created_by = $login_data->username;
    $created_date = date("Y-m-d H:i:s");
    $qty_awal = $this->input->post('qty_awal');
    $qty_akhirs = $this->input->post('qty_akhir');
    if ($qty_akhirs == null) {
      $qty_akhir = $qty_awal;
    } else {
      $qty_akhir = $qty_akhirs;
    }
    // $alasan_ajustmen = $this->input->post('alasan_ajustmen');
    $adjust = $qty_akhir - $qty_awal;
    // var_dump( $adjust);die();
    $id_inventory = $this->input->post('id_inventory');
    $detail_obat = $this->Frmmstok->cek_detail_obat($id_inventory)->row();
    $batch_no = $this->input->post('batch_no');
    $id_gudang = $detail_obat->id_gudang;
    $id_obat = $detail_obat->id_obat;

    $where['id_inventory'] = $this->input->post('id_inventory');

    //var_dump($where);die();

    $data['expire_date'] = $this->input->post('expire_date');
    $data['qty'] = $qty_akhir;
    $data['alasan_adjustment'] = $this->input->post('alasan_adjustment');
    $data['batch_no'] = $batch_no;
    $data2['id_obat'] = $id_obat;
    $data2['stok_awal'] = $qty_awal;
    $data2['stok_akhir'] = $qty_akhir;
    //  $data2['adjustment'] = $adjust;
    $data2['gudang1'] = $id_gudang;
    $data2['batch_no'] = $batch_no;
    $data2['created_by'] = $created_by;
    $data2['created_date'] = $created_date;
    $data2['no_transaksi'] = '0';
    // $data2['alasan_ajustmen'] = $alasan_ajustmen;



    if ($adjust < 0) {
      $data2['keterangan'] = "Adjusment_Kurang";
      $data2['adjustment'] = $adjust * (-1);
    } else {
      $data2['keterangan'] = "Adjusment_Tambah";
      $data2['adjustment'] = $adjust;
    }
    $this->Frmmstok->update_history($data2);

    $data['hargajual'] = $this->input->post('hargajual');

    $this->Frmmstok->update_table('gudang_inventory', $data, $where);

    echo "sukses";
  }

  function index_expire($all_gudang = '')
  {
    $data['all_gudang'] = $all_gudang;
    $data['title'] = 'Stok Barang';
    $data['select_gudang'] = $this->Frmmstok->get_data_gudang()->result();

    $login_data = $this->load->get_var("user_info");

    // print_r($login_data);die();

    $data['roleid'] = $this->Frmmstok->get_roleid($login_data->userid)->row()->roleid;

    //  print_r( $data['roleid']);die();

    $i = 1;
    if ($all_gudang == '') {
      $id_gudang = $this->Frmmstok->get_gudangid($login_data->userid)->result();
      foreach ($id_gudang as $row) {
        if ($i == 1) {
          $gd = $this->Frmmstok->getdata_expire_gudang_inventory_by_role($row->id_gudang)->result();
        } else {
          $gd = array_merge($gd, $this->Frmmstok->getdata_expire_gudang_inventory_by_role($row->id_gudang)->result());
        }

        $i++;
      }
    } else {
      $gd = $this->Frmmstok->getdata_expire_gudang_inventory_by_role('')->result();
    }


    // print_r($gd);die();
    $data['data_barang'] = $gd;
    $data['alloabt'] = $this->Frmmstok->get_all_obat()->result();
    $data['allgudang'] = $this->Frmmstok->get_all_gudang()->result();
    $this->load->view('logistik_farmasi/Frmvdaftarstok_expire', $data);
  }

  public function add_to_gudang()
  {
    // var_dump($this->input->post());die();
    $id_obat = $this->input->post('id_obat');
    $batch_no =  $this->input->post('batch_no');
    $data['qty'] = $this->input->post('qty');
    $data['expire_date'] = $this->input->post('exp_date');
    $hargajual = $this->input->post('hargajual');
    if ($hargajual == null) {
      $haju = null;
    } else {
      $haju = $hargajual;
    }
    $data['hargajual'] = $haju;
    $hargabeli = $this->input->post('vtot_x');
    if ($hargabeli == null) {
      $habe = null;
    } else {
      $habe = $hargabeli;
    }
    $data['hargabeli'] = $habe;
    $data['id_gudang'] = $this->input->post('id_gudang');
    $cek = $this->Frmmstok->cek_obat_to_gudang($id_obat, $batch_no, $data['id_gudang'])->row();
    // var_dump($cek);
    // die();
    if ($cek == null) {
      $data['id_obat'] = $id_obat;
      $data['batch_no'] = $batch_no;
      $this->Frmmstok->add_obat_to_gudang($data);
    } else {
      // $this->Frmmstok->update_obat_to_gudang($data,$id_obat,$batch_no);
      $success =   '<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								<h3 class="text-success">Obat & No Batch Sudah Ada Di Gudang.</h3> Harap masukkan Obat & No Batch yang berbeda.
							</div>';
      $this->session->set_flashdata('success_msg', $success);
      redirect('logistik_farmasi/Frmcstok/index');
    }

    redirect('logistik_farmasi/Frmcstok/index');
  }

  public function verif_expire($id_inventory)
  {
    $this->Frmmstok->verif_stock_expire($id_inventory);
    redirect('logistik_farmasi/Frmcstok/index_expire');
  }
}
