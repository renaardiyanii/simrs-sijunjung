<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
// include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Frmcpembelian_po extends Secure_area
{
    public function __construct(){
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->model('farmasi/Frmmdaftar','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->model('master/Mmobat','',TRUE);
        $this->load->model('master/Mmsatuan_obat','',TRUE);
        $this->load->helper('pdf_helper');
        $this->load->library('session');
    }

    function index()
    {
        $data['title'] = 'Pembelian (PO Reference)';
        $data['select_pemasok'] = $this->Frmmpo->get_suppliers();
        $data['kemasan'] = $this->Frmmpo->get_kemasan();
        $this->load->view('logistik_farmasi/Frmvpembelian_po',$data);
    }

    function get_detail_list(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $hasil = $this->Frmmpo->get_po_detail_list($this->input->post('id'));
        $total = 0;
        foreach ($hasil as $key =>$value) {
            $row2['item_id'] = $value->item_id;
            $row2['id_po'] = $value->id_po;
            $row2['id'] = $value->id;
            $row2['description'] = $value->description;
            $row2['satuank'] = $value->satuank;
            $row2['qty_po'] = $value->qty;
            $row2['qty_beli'] = $value->qty_besar;
            $row2['batch_no'] = $value->batch_no;
            $row2['keterangan'] = $value->keterangan;
            $row2['expire_date'] = $value->expire_date;
            $row2['hargabeli'] = $value->hargabeli;
            $row2['subtotal'] = number_format($value->harga_po, '0', ',', '.');
            $row2['jml_kemasan'] = $value->jml_kemasan;
            $row2['harga_item'] = $value->harga_item;
            $row2['satuan_item'] = $value->satuan_item;
            $row2['diskon_persen'] = $value->diskon_persen."%";
            $total += $value->harga_po;
            $row2['total'] = "<p align='right'>".number_format($total, '0', ',', '.')."</p>";
            /*
            if ($value->qty_beli == null)
                $row2['qty_beli'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_beli'.($key+1).'" name="qty_beli" min=0 >';
            else
                $row2['qty_beli'] = $value->qty_beli;
            if ($value->batch_no == null){
                $row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';
            }else
                $row2['batch_no'] = $value->batch_no;
            if ($value->keterangan == null)
                $row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
            else
                $row2['keterangan'] = $value->keterangan;
            if ($value->expire_date == null)
                $row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
            else
                $row2['expire_date'] = $value->expire_date;
            */
            $line2[] = $row2;
        }
        $line['data'] = $line2;
        echo json_encode($line);
    }
    function get_detail_beli_(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $value2 = $this->Frmmpo->get_total_beli($this->input->post());
        // var_dump($value2);die();
        $total_qty_beli = $value2->total_qty_beli;
        $jml_kemasan = $value2->jml_kemasan;
        $hargabeli = $value2->hargabeli;
        $hargajual = $value2->hargajual;
        $description = $value2->description;
        $qty = $value2->qty;
        $diskon_persen = $value2->diskon_persen;
        $satuank = $value2->satuank;
        $open = $value2->open;
        // var_dump($this->input->post());die();
        $hasil = $this->Frmmpo->get_po_detail_beli($this->input->post());
        $qty_beli = 0;
        foreach ($hasil as $value) {
            $row2['qty_beli'] = $value->qty_beli;
            $row2['satuan'] = $value->satuank;
            $row2['jml_kemasan'] = $value->jml_kemasan;
            $row2['hargabeli'] = $value->hargabeli;
            $row2['hargajual'] = $value->hargajual;
            $row2['batch_no'] = $value->batch_no;
            $row2['expire_date'] = $value->expire_date;
            $row2['diskon_persen'] = $value->diskon_persen;
            $row2['aksi'] = '';
            $qty_beli += $value->qty_beli;
            //$row2['aksi'] = '<button class="btn btn-xs btn-warning" id="btnHapus" onClick="hapusBeli('.$value->id.')">Hapus</button>';
            /*
            if ($value->qty_beli == null)
                $row2['qty_beli'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_beli'.($key+1).'" name="qty_beli" min=0 >';
            else
                $row2['qty_beli'] = $value->qty_beli;
            if ($value->batch_no == null){
                $row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';
            }else
                $row2['batch_no'] = $value->batch_no;
            if ($value->keterangan == null)
                $row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
            else
                $row2['keterangan'] = $value->keterangan;
            if ($value->expire_date == null)
                $row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
            else
                $row2['expire_date'] = $value->expire_date;
            */
            $line2[] = $row2;
        }
        $obat_satuan = $this->Mmsatuan_obat->get_all_satuan_obat()->result();
        $kuota = $qty-$qty_beli;

        if ($kuota>0 and $open==1 or $kuota>0 and $open==2){
            $row2['qty_beli'] = '<input type="number" id="qty_beli" name="qty_beli" min=0 max='.$kuota.' style="width:100%" value='.$kuota.' >';

            $select = '<select size="1" class="satuan" id="satuan" name="satuan">';
			$select.='<option value="" selected>Silahkan Pilih</option>';

			foreach ($obat_satuan as $value2) {
				$select = $select . '<option value="'.$value2->satuan.'">'.$value2->satuan.'</option>';
			}
			$select = $select . "</select>";
            $row2['satuan'] = $select;
            
                       
                    
            $row2['jml_kemasan'] = '<input type="number" id="jml_kemasan" name="jml_kemasan" min=0 style="width:50%" value="'.$jml_kemasan.'">';
                /*'<p align="right">'.number_format($jml_kemasan, '0', ',', '.').'</p>';*/
            $row2['hargabeli'] = '<input type="number" id="hargabeli" name="hargabeli" style="width:80%" min=0 value="'.$hargabeli.'">';
            $row2['hargajual'] = '<input type="number" id="hargajual" name="hargajual" style="width:100%" min=0 value="'.$hargajual.'">
			<input type="hidden" id="hargabeli" name="hargabeli" value="'.$hargabeli.'">';
            $row2['batch_no'] = '<input type="text" id="batch_no" name="batch_no" value="0">';
            $row2['diskon_persen'] = '<input type="text" id="diskon_item" name="diskon_item" value="'.$diskon_persen.'" style="width:120%">';
            $row2['expire_date'] ='<input type="date" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd" style="width:100%">
			<input type="hidden" value="'.$description.'" id="description"><input type="hidden" value="'.$satuank.'" id="satuank"><input type="hidden" value="'.$qty.'" id="qty">';
            $row2['aksi'] = '<button class="btn btn-xs btn-primary" id="btnSimpan">Simpan</button>';
            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function get_detail_beli(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $value2 = $this->Frmmpo->get_total_beli($this->input->post());
        //  var_dump($value2);die();
        $total_qty_beli = $value2->total_qty_beli;
        $jml_kemasan = $value2->jml_kemasan;
        $hargabeli = $value2->hargabeli;
        $hargajual = $value2->hargajual;
        $description = $value2->description;
        $qty = $value2->qty;
        $diskon_persen = $value2->diskon_persen;
        $satuank = $value2->satuank;
        $satuank = $value2->satuank;
        $open = $value2->open;
        // var_dump($qty);die();
        $hasil = $this->Frmmpo->get_po_detail_beli($this->input->post());
        // var_dump($hasil);die();
        $qty_beli = 0;
        foreach ($hasil as $value) {
            $row2['qty_beli'] = $value->qty_beli;
            $row2['satuan'] = $value->satuank;
            $row2['jml_kemasan'] = $value->jml_kemasan;
            $row2['hargabeli'] = $value->hargabeli;
            $row2['hargajual'] = $value->hargajual;
            $row2['batch_no'] = $value->batch_no;
            $row2['expire_date'] = $value->expire_date;
            $row2['diskon_persen'] = $value->diskon_persen;
            $row2['id'] = $value->id;
            $row2['verifikasi_penerima'] = $value->verifikasi_penerima;
            $row2['verifikasi_penerima_dt'] = $value->verifikasi_penerima_dt;
            $row2['verifikasi_gudang'] = $value->verifikasi_gudang;
            $row2['verifikasi_gudang_dt'] = $value->verifikasi_gudang_dt;
            $row2['aksi'] = '';
            $row2['qty'] = $qty;
            $qty_beli += $value->qty_beli;
            //$row2['aksi'] = '<button class="btn btn-xs btn-warning" id="btnHapus" onClick="hapusBeli('.$value->id.')">Hapus</button>';
            /*
            if ($value->qty_beli == null)
                $row2['qty_beli'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_beli'.($key+1).'" name="qty_beli" min=0 >';
            else
                $row2['qty_beli'] = $value->qty_beli;
            if ($value->batch_no == null){
                $row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';
            }else
                $row2['batch_no'] = $value->batch_no;
            if ($value->keterangan == null)
                $row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
            else
                $row2['keterangan'] = $value->keterangan;
            if ($value->expire_date == null)
                $row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
            else
                $row2['expire_date'] = $value->expire_date;
            */
            $line2[] = $row2;
        }
        // $obat_satuan = $this->Mmsatuan_obat->get_all_satuan_obat()->result();
        // $kuota = $qty-$qty_beli;

        // if ($kuota>0 and $open==1 or $kuota>0 and $open==2){
        //     $row2['qty_beli'] = '<input type="number" id="qty_beli" name="qty_beli" min=0 max='.$kuota.' style="width:100%" value='.$kuota.' >';

        //     $select = '<select size="1" class="satuan" id="satuan" name="satuan">';
		// 	$select.='<option value="" selected>Silahkan Pilih</option>';

		// 	foreach ($obat_satuan as $value2) {
		// 		$select = $select . '<option value="'.$value2->satuan.'">'.$value2->satuan.'</option>';
		// 	}
		// 	$select = $select . "</select>";
        //     $row2['satuan'] = $select;
            
                       
                    
        //     $row2['jml_kemasan'] = '<input type="number" id="jml_kemasan" name="jml_kemasan" min=0 style="width:50%" value="'.$jml_kemasan.'">';
        //         /'<p align="right">'.number_format($jml_kemasan, '0', ',', '.').'</p>';/
        //     $row2['hargabeli'] = '<input type="number" id="hargabeli" name="hargabeli" style="width:80%" min=0 value="'.$hargabeli.'">';
        //     $row2['hargajual'] = '<input type="number" id="hargajual" name="hargajual" style="width:100%" min=0 value="'.$hargajual.'">
		// 	<input type="hidden" id="hargabeli" name="hargabeli" value="'.$hargabeli.'">';
        //     $row2['batch_no'] = '<input type="text" id="batch_no" name="batch_no" value="0">';
        //     $row2['diskon_persen'] = '<input type="text" id="diskon_item" name="diskon_item" value="'.$diskon_persen.'" style="width:120%">';
        //     $row2['expire_date'] ='<input type="date" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd" style="width:100%">
		// 	<input type="hidden" value="'.$description.'" id="description"><input type="hidden" value="'.$satuank.'" id="satuank"><input type="hidden" value="'.$qty.'" id="qty">';
        //     $row2['aksi'] = '<button class="btn btn-xs btn-primary" id="btnSimpan">Simpan</button>';
        //     $line2[] = $row2;
        // }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function save_detail_beli(){
        // var_dump($this->input->post());die();
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $test = $this->Frmmpo->insert_detail_beli($this->input->post(), 1) ;
        //echo true;
        echo $test;
        /*echo "<pre>";
        echo print_r($this->input->post());
        echo "</pre>";*/
    }
    function delete_detail_beli(){
        $this->Frmmpo->delete_detail_beli($this->input->post('id')) ;
        echo true;
    }
    function selesai_po(){
        $data = $this->Frmmpo->selesai_po($this->input->post('id_po'));
        //  var_dump($data);die();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'metadata'=>[
                'code'=>$data?200:400,
                'message'=>$data?'Data Berhasil disimpan!':'Data Gagal Disimpan!'
            ]
        ]);
        // redirect('logistik_farmasi/Frmcpembelian_po');
    }

    /*
        function alokasi(){
            $this->Frmmpo->update($this->input->post('json'));
            echo true;
        }
        */

    public function export_excel($tgl0, $tgl1)
    {
        $data['title'] = 'Pembelian PO Farmasi';
        // $param1 = '2016-05-09';
        // $param2 = '2017-05-09';
        $param1 = $tgl0;
        $param2 = $tgl1;
        // $param1 = $this->input->post('tgl0');
        // $param2 = $this->input->post('tgl1');

        $tgl_indo=new Tglindo();
        date_default_timezone_set("Asia/Jakarta");
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
        $objPHPExcel->getProperties()->setCreator("RSMCilandak")
            ->setLastModifiedBy("RSMCilandak")
            ->setTitle("Laporan Keuangan RS Marinir Cilandak")
            ->setSubject("Laporan Keuangan RS Marinir Cilandak Document")
            ->setDescription("Laporan Keuangan Marinir Cilandak for Office 2007 XLSX, generated by HMIS.")
            ->setKeywords(" Marinir Cilandak")
            ->setCategory("Laporan Pembuatan PO");

        //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objPHPExcel = $objReader->load("project.xlsx");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);


        if($param1=='' or $param2==''){
            $param1 = date("Y-m-d");
            $param2 = date("Y-m-d");
        }
        $tgl1 = date('d F Y', strtotime($param1));
        $tgl2 = date('d F Y', strtotime($param2));
        $data_po=$this->Frmmpo->get_data_pem_po($param1, $param2)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pem_po.xlsx');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('F3:K3');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Add some data
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Periode '.$tgl1.' - '.$tgl2);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');

        $i=1;
        $rowCount = 5;
        foreach($data_po as $row){
            $no_po=$row->no_po;
            $data_obat='';
            $data_obat=$this->Frmmpo->get_data_pem_po_obat($row->id_po)->result();
            $j=1;
            foreach($data_obat as $row2){
                if($j==1){
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
                    $i++;
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->company_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->sumber_dana);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->qty);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->batch_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row2->expire_date);
                $j++;
                $rowCount++;
            }
        }
        header('Content-Disposition: attachment;filename="Lap_Pem_PO.xlsx"');


        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RSM Cilandak');



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

        echo json_encode(array("status" => TRUE));
    }
    public function cetak_faktur($id_po){
        
        date_default_timezone_set("Asia/Bangkok");
        $tgl_jam = date("d-m-Y H:i:s");
        $tgl = date("d-m-Y");

        $namars=$this->config->item('namars');
        $kota_kab=$this->config->item('kota_kab');
        $alamatrs=$this->config->item('alamat');
        $telp=$this->config->item('kota');
        $header_pdf=$this->config->item('header_pdf');

        //$data_detail_amprah=$this->Frmmamprah->get_receivings($no_faktur_amp)->result();
        $data['identitas_po']=$this->Frmmpo->get_info($id_po);

        // var_dump($data1);die();
        // $data = json_decode(json_encode($data1), true);

        $data['data_detail_po']=$this->Frmmpo->get_po_detail_list_beli($id_po);
        $data['no']=1; $data['ttot'] = 0;

        return $this->load->view('cetak/CETAK_FAKTUR_PO',$data);

        $konten = "
        <style type=\"text/css\">
                    table.me {
                        border-collapse: collapse;
                    }
                    
                    table.me, tr.me, td.me {
                        border: 0.5px solid black;
                    }
                    </style>";
        $konten .="<style type=\"text/css\">
                    .table-font-size{
                        font-size:9px;
                        }
                    .table-font-size1{
                        font-size:12px;
                        }
                    .table-font-size2{
                        font-size:9px;
                        margin : 5px 1px 1px 1px;
                        padding : 5px 1px 1px 1px;
                        }
                    </style>
                    
                    <font size=\"6\" align=\"right\">$tgl_jam</font><br>
                    $header_pdf
                    <hr/>";
        $konten .="
        <table width=\"100%\">
                        <tr>
                            <td align=\"center\"><b>SURAT PENERIMAAN BARANG<br/>".$data['no_po']."</b></td>
                        </tr>
                    </table><br/><br/>
                  <div align=\"right\">NO ULP: ".substr($data['no_po'], 0,3)."</div>
                  <table width=\"100%\">
                    <tr>
                      <td width=\"15%\"><b>SURAT DARI</b></td>
                      <td width=\"3%\"> : </td>
                      <td> ".$data['surat_dari']."</td>
                    </tr>
                    <tr>
                      <td width=\"15%\"><b>NO SURAT</b></td>
                      <td width=\"3%\"> : </td>
                      <td> ".$data['no_surat']."</td>
                    </tr>
                    <tr>
                      <td width=\"15%\"><b>PERIHAL</b></td>
                      <td width=\"3%\"> : </td>
                      <td> ".$data['perihal']."</td>
                    </tr>
                  </table><br/><br/>
                  <table width=\"100%\" class=\"me\">
                    <tr>
                        <td width=\"5%\" rowspan=\"2\"  align=\"center\" class=\"me\"><b>NO</b></td>
                        <td width=\"25%\" rowspan=\"2\" align=\"center\" class=\"me\"><b>NAMA BARANG</b></td>
                        <td width=\"5%\" rowspan=\"2\" align=\"center\" class=\"me\"><b>SAT</b></td>
                        <td width=\"5%\" rowspan=\"2\" align=\"center\" class=\"me\"><b>VOL</b></td>
                        <td width=\"60%\" colspan=\"4\" align=\"center\" class=\"me\"><b>HARGA</b></td>
                    </tr>
                    <tr>
                        <td align=\"center\" class=\"me\"><b>SATUAN</b></td>
                        <td align=\"center\" class=\"me\"><b>SUBTOTAL</b></td>
                        <td align=\"center\" class=\"me\"><b>DISKON</b></td>
                        <td align=\"center\" class=\"me\"><b>TOTAL</b></td>
                    </tr>
                    ";
        // $data_detail_po=$this->Frmmpo->get_po_detail_list_beli($id_po);
        // $no=1; $ttot = 0;

        // var_dump($data_detail_po);die();
        foreach($data_detail_po as $row){
            $konten = $konten . "
                    <tr>
                        <td align=\"center\" class=\"me\">".$no++."</td>
                        <td align=\"center\" class=\"me\">".$row->description."</td>
                        <td align=\"center\" class=\"me\">".$row->satuank."</td>
                        <td align=\"center\" class=\"me\">".$row->qty_beli."</td>
                        <td class=\"me\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\">".number_format($row->harga_item, '2',',', '.')."</td>
                                </tr>
                            </table>
                        </td>
                        <td class=\"me\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\">".number_format($row->subtotal, '2',',', '.')."</td>
                                </tr>
                            </table>
                        </td>
                        <td class=\"me\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\">".$row->diskon_persen."%</td>
                                </tr>
                            </table>
                        </td>
                        <td class=\"me\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\">".number_format($row->total, '2',',', '.')."</td>
                                </tr>
                            </table>
                        </td>
                    </tr>";

            $ttot += $row->total;
        }
        $ppn = 0;
        if($data['ppn'] == 1){
            $ppn = 0.1 * $ttot;
        }else{
            $ppn = 0;
        }
        $total_akhir = $ppn + $ttot;

        $konten .= "
        
        <tr>
                        <td colspan=\"6\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align=\"center\" class=\"me\"></td>
                        <td align=\"center\" class=\"me\">HARGA</td>
                        <td class=\"me\" colspan=\"7\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\"><b>".number_format($ttot, '2',',', '.')."</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" class=\"me\"></td>
                        <td align=\"center\" class=\"me\">PPN</td>
                        <td class=\"me\" colspan=\"7\">
                            <table width=\"100%\">
                                <tr>
                                    <td align=\"right\"><b>".number_format($ppn, '2',',', '.')."</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" class=\"me\"></td>
                        <td align=\"center\" class=\"me\">TOTAL HARGA (Rp.)</td>
                        <td class=\"me\" colspan=\"7\">
                            <table width=\"100%\" >
                                <tr>
                                    <td align=\"right\"><b>".number_format($total_akhir, '2',',', '.')."</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>";
        $konten = $konten ."
          </table>
          <br><br><br>
          <table border=\"0\" width=\"100%\">
                    <tr>
                      <td width=\"30%\" align=\"center\">Pengirim</td>
                      <td width=\"40%\"></td>
                      <td width=\"30%\" align=\"center\">Penerima</td>
                    </tr>
                    
                    <tr>
                      <td width=\"30%\" align=\"center\"><br/><br/><br/><br/><br/>(______________________________)</td>
                      <td width=\"40%\"></td>
                      <td width=\"30%\" align=\"center\"><br/><br/><br/><br/><br/>(______________________________)</td>
                    </tr>
          </table><br/>
          ";
        /*<tr>
                      <td width="30%" align="center">Mengetahui,<br/>WAKAMED Dr. MTH</td>
                      <td width="40%"></td>
                      <td width="30%" align="center"><br/>Pejabat Pengadaan</td>
                    </tr>

                    <tr>
                      <td width="30%" align="center"><br/><br/><br/><br/><br/>dr. Eko Budi Prasetyo, Sp.An, KIC<br/>Kolonel Laut (K) NRP. 9128/P</td>
                      <td width="40%"></td>
                      <td width="30%" align="center"><br/><br/><br/><br/><br/>Barkah Siswoyo, S.Si, APT<br/>Letkol Laut (K) NRP. 10827/P</td>
                    </tr>*/

        //echo $konten;
        $file_name="FP_$id_po.pdf";

        tcpdf();
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $title = "";
        $obj_pdf->SetTitle($file_name);
        $obj_pdf->SetHeaderData('', '', $title, '');
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins('5', '10', '5');
        $obj_pdf->SetAutoPageBreak(TRUE, '5');
        $obj_pdf->SetFont('helvetica', '', 9);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();


        ob_clean();
        ob_flush();

        


        // ob_start();
        $content = $konten;
        // ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(FCPATH.'download/logistik_farmasi/PO/'.$file_name,'FI');

        ob_end_flush();
        ob_end_clean();

    }


    public function verifikasi_penerima()
    {
        $data = [
            'verifikasi_penerima'=>$this->session->userid,
            'verifikasi_penerima_dt'=>date("Y-m-d H:i:s")
        ];
        $hasil = $this->Frmmpo->get_po_detail_beli_belum_verif_penerima($this->input->post());
        $result = $this->Frmmpo->verifikasi_penerima($data,$hasil);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'metadata'=>[
                'code'=>$result ?200:400,
                'message'=>$result ?'Data Berhasil disimpan!':'Data Gagal Disimpan!'
            ]
        ]);
    }

    public function verifikasi_gudang()
    {
        $hasil = $this->Frmmpo->get_po_detail_beli_belum_verif_gudang($this->input->post());
        $data = [
            'verifikasi_gudang'=>$this->session->userid,
            'verifikasi_gudang_dt'=>date("Y-m-d H:i:s")
        ];
        $result = $this->Frmmpo->verifikasi_gudang($data,$hasil,1);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'metadata'=>[
                'code'=>$result ?200:400,
                'message'=>$result ?'Data Berhasil disimpan!':'Data Gagal Disimpan!'
            ]
        ]);
    }

    public function hapus_po_id($id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $checkVerif = $this->Frmmpo->check_po_id($id);
        if(!$checkVerif){
            echo json_encode([
                'metadata'=>[
                    'code'=>400,
                    'message'=>'Data Tidak Tersedia!'
                ]
            ]);
            return;
        }
        if($checkVerif->verifikasi_penerima){
            echo json_encode([
                'metadata'=>[
                    'code'=>400,
                    'message'=>'Data Sudah Diverifikasi Penerima!'
                ]
            ]);
            return;

        }
        if($checkVerif->verifikasi_gudang){
            echo json_encode([
                'metadata'=>[
                    'code'=>400,
                    'message'=>'Data Sudah Diverifikasi Gudang!'
                ]
            ]);
            return;

        }

        $hapusPo = $this->Frmmpo->hapus_po_id($id);
        if(!$hapusPo){
            echo json_encode([
                'metadata'=>[
                    'code'=>400,
                    'message'=>'Data Tidak Bisa Dihapus, hubungi Tim IT!'
                ]
            ]);
            return;
        }
        echo json_encode([
            'metadata'=>[
                'code'=>200,
                'message'=>'Data Berhasil Dihapus!'
            ]
        ]);
        return;
        

    }
}
?>
