<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH . 'controllers/Secure_area.php');
include('Frmcterbilang.php');

class Frmcpembelianoptik extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmtransaksi', '', TRUE);
        $this->load->model('logistik_farmasi/Frmmpemasok', '', TRUE);
        $this->load->model('logistik_farmasi/Frmmkwitansi', '', TRUE);
        $this->load->model('logistik_farmasi/Frmmpo', '', TRUE);
        $this->load->model('master/Mmobat', '', TRUE);
        $this->load->model('master/Mmsupplier', '', TRUE);
        $this->load->library('session');
        $this->load->helper('pdf_helper');
    }

    function index($param = '')
    {

        $data['obat'] = $this->Frmmtransaksi->get_optik()->result();
        $data['satuan'] = $this->Frmmtransaksi->get_satuan()->result();
        $data['select_obat'] = $this->Frmmtransaksi->cari_obat()->result();
        $data['Pemasok'] = $this->Frmmpemasok->get_pemasok()->result();
        $data['title'] = 'Pengadaan Barang Optik';
        $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_receiving_optik()->result();
        $data['select_pemasok'] = $this->Frmmpemasok->cari_pemasok()->result();
        $this->load->view('logistik_farmasi/Frmvpembelianoptik', $data);


    }

    function form_supplier()
    {
        $data['title'] = 'Tambah Pemasok';
        $data['Pemasok'] = $this->Frmmpemasok->get_pemasok()->result();
        $data['company_name'] = $this->Frmmpemasok->get_company()->result();
        $data['account_number'] = $this->Frmmpemasok->get_account_numb()->result();
        $this->load->view('logistik_farmasi/Frmvtambahpemasok', $data);
    }

    public function insert_supplier()
    {
        $data['company_name'] = $this->input->post('nmsupplier');
        $data['account_number'] = $this->input->post('accountnumber');
        $data['adress'] = $this->input->post('adress');
        $data['zip_code'] = $this->input->post('zip_code');
        $data['phone'] = $this->input->post('phone');
        $this->Mmsupplier->insert_supplier($data);

        // $this->Frmmpemasok->insert_supplier($data);
        redirect('logistik_farmasi/Frmcpembelianoptik');
    }

    function insert_detail_pembelian()
    {
        $data['receiving_id'] = $this->input->post('receiving_id');
        $data['supplier_id'] = $this->input->post('id_supplier');
        $no_faktur = str_replace("/", "-", $this->input->post('no_faktur'));
        $data['no_faktur'] = $this->input->post('no_faktur');
        $data['comment'] = $this->input->post('comment');
        $data['payment_type'] = $this->input->post('payment_type');
        $data['jatuh_tempo'] = $this->input->post('jatuh_tempo');
        $data['tgl_kontra_bon'] = $this->input->post('tgl_kontra_bon');
        $data['ppn'] = 10;
        $data['total_price'] = '0';
        $this->Frmmtransaksi->insert_detail_optik($data);
        redirect('logistik_farmasi/Frmcpembelianoptik/form_detail_transaksi/' . $no_faktur);

    }

    function form_detail_transaksi($no_faktur = '')
    {
        $no_faktur = str_replace("-", "/", $no_faktur);
        $data['title'] = 'Detail Pengadaan Optik';
        $data['data_obat'] = $this->Mmobat->get_all_optik()->result();
        $data_detail_pembelian = $this->Frmmtransaksi->get_receivings_optik($no_faktur)->result();
        foreach ($data_detail_pembelian as $row) {
            $data['receiving_time'] = $row->receiving_time;
            $data['payment_type'] = $row->payment_type;
            $data['id_receiving'] = $row->receiving_id;
            $data['total_price'] = $row->total_price;
            $data['supplier_id'] = $row->supplier_id;
            $data['no_faktur'] = $row->no_faktur;
            $data['jatuh_tempo'] = $row->jatuh_tempo;
            $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
        }
        $data['select_gudang'] = $this->Frmmtransaksi->cari_gudang()->result();
        $data['company_name'] = $this->Frmmpemasok->get_company_name($no_faktur)->row();
        $data['data_receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item_optik($data['id_receiving'])->result();
        $this->load->view('logistik_farmasi/Frmvdetailtransaksi_optik', $data);
    }

    public function insert_pembelian()
    {
        $data['receiving_id'] = $this->input->post('receiving_id');
        $no_faktur = $this->input->post('no_faktur');
        $no_faktur2 = str_replace("/", "-", $no_faktur);
        $data['item_id'] = $this->input->post('idobat');
        $data_optik = $this->Frmmtransaksi->getitem_optik($data['item_id'])->result();
        foreach ($data_optik as $row) {
            $data['description'] = $row->nm_item;
            if($row->harga != null || $row->hargajual != ""){
                $data['item_unit_price'] = $this->input->post('biaya_obat');
            }else{
                $data['item_unit_price'] = 0;
            }
    
        }
        $data['item_cost_price'] = $this->input->post('vtot_x');
        $data['quantity_purchased'] = $this->input->post('qty');
        $data['ppn_percent'] = 10;
        $data['discount_percent'] = $this->input->post('diskon');
        $data['batch_no'] = $this->input->post('batch_no');

        $this->Frmmtransaksi->insert_receiving_item_optik($data);
        $data1['id_obat'] = $this->input->post('idobat');
        $data1['qty'] = $this->input->post('qty');
        if ($this->input->post('expire_date') != '') {
            $data1['expire_date'] = $this->input->post('expire_date');
        }
        $data1['batch_no'] = $this->input->post('batch_no');
        $id_obat=$this->input->post('idobat');
        $batch=$this->input->post('batch_no');
        $qty = $this->input->post('qty');
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        $data1['id_gudang'] = $group->id_gudang;

        $query=$this->db->query("SELECT qty FROM inventory_optik WHERE id_obat='$id_obat' AND batch_no='$batch'");
          $qty_last=$query->row()->qty;
          $qty_tot=$qty_last+$qty;
          $cek_inventori=$query->num_rows();
          if($cek_inventori==0){
            $this->Frmmtransaksi->insert_selesai_transaksi_optik($data1);
          }else{
            $this->Frmmtransaksi->insert_selesai_transaksi_optik2($id_obat,$batch,$qty_tot);
          }
        $this->Frmmtransaksi->update_total_price_optik($this->input->post('receiving_id'));

        redirect('logistik_farmasi/Frmcpembelianoptik/form_detail_transaksi/' . $no_faktur2);
        //print_r($data);
    }


    public function selesai_transaksi()
    {
        $data['item_id'] = $this->input->post('idobat');
        $data_obat = $this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
        foreach ($data_obat as $row) {
            $data['description'] = $row->nm_obat;
        }
        $data['quantity_purchased'] = $this->input->post('qty');

        $this->Frmmtransaksi->insert_receiving_item_optik($data);
       
        redirect('logistik_farmasi/Frmcpembelianoptik/form_detail_transaksi/' . $no_faktur);
        //print_r($data);
    }


    public function get_data_detail_pembelian()
    {
        $receiving_id = $this->input->post('receiving_id');
        $datajson = $this->Frmmtransaksi->get_data_receiving_optik($receiving_id)->result();
        echo json_encode($datajson);
    }


    public function get_biaya_optik()
    {
        $id_obat = $this->input->post('idobat');
        $biaya = $this->Frmmtransaksi->get_biaya_optik($id_obat)->row()->hargajual;
        echo json_encode($biaya);
    }

    public function hapus_data_receiving($receiving_id = '', $id_obat = '', $no_faktur = '', $batch = '', $tipe = '')
    {
        $cek_stok=$this->Frmmtransaksi->cek_stok($id_obat);
        $qty_hapus=$this->Frmmtransaksi->get_qty_hapus($receiving_id, $id_obat);
        $stok_akhir=$cek_stok->qty-$qty_hapus->quantity_purchased;
        $stok_up=$this->Frmmtransaksi->update_stok($id_obat,$stok_akhir);
        $id = $this->Frmmtransaksi->hapus_data_receiving_optik($receiving_id, $id_obat, $batch);
            redirect('logistik_farmasi/Frmcpembelianoptik/form_detail_transaksi/' . $no_faktur);

        // print_r($id);
    }

    function delete_pembelian(){
        $id = $this->input->post('receiving_id');
        $this->Frmmtransaksi->hapus_data_receiving_all_optik($id);
        echo "success";
    }

    public function faktur_pembelian()
    {
        $data['title'] = 'Cetak Faktur Optik';
        $no_faktur = $this->input->post('faktur_hidden');
        if ($no_faktur != '') {
            $data['no_faktur'] = $no_faktur;
            $data_detail_pembelian = $this->Frmmtransaksi->get_receivings_optik($no_faktur)->result();
            foreach ($data_detail_pembelian as $row) {
                $data['receiving_time'] = $row->receiving_time;
                $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->supplier_id;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
            }
            $data['select_gudang'] = $this->Frmmtransaksi->cari_gudang()->result();
            $data['company_name'] = $this->Frmmpemasok->get_company_name_optik($no_faktur)->row();
            $data['data_receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item_optik($data['id_receiving'])->result();
            $data['data_permintaan'] = $this->Frmmtransaksi->get_all_data_receiving_optik()->result();
            $data['receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item_optik($data['id_receiving'])->result();

            if (sizeof($data['data_permintaan']) == 0) {
                $this->session->set_flashdata('message_no_tindakan', '<div class="row">
              <div class="col-md-12">
                <div class="box box-default box-solid">
                <div class="box-header with-border">
                  <center>Tidak Ada Tindakan</center>
                </div>
                </div>
              </div>
            </div>');
            } else {
                $this->session->set_flashdata('message_no_tindakan', '');
            }

            $this->load->view('logistik_farmasi/Frmvfakturpembelian_optik', $data);
        } else {
            //printf("redirect");
            redirect('logistik_farmasi/Frmcpembelianoptik/faktur_pembelian');
        }
    }

    public function cetak_faktur()
    {
        $no_faktur = $this->input->post('faktur_hidden');
        $cookiediskon = $this->input->post('diskon_hide');
      

        echo '<script type="text/javascript">document.cookie = "diskon=' . $cookiediskon . '";window.open("' . site_url("logistik_farmasi/Frmcpembelianoptik/cetak_faktur_op/$no_faktur") . '", "_blank");window.focus()</script>';

        redirect('logistik_farmasi/Frmcpembelianoptik/', 'refresh');
    }

    function get_detail(){      
        $line  = array();
        $line2 = array();
        $row2  = array();
        $i = 1;
        $hasil = $this->Frmmtransaksi->get_detail($this->input->post('id'));
        
        foreach ($hasil as $value) {
            $row2['id_item'] = $value->item_id;
            $row2['no'] = $i;
            $row2['item'] = $value->description;
            $row2['supplier'] = $value->company_name;
            $row2['qty'] = $value->quantity_purchased;
            $row2['satuan'] = "Pcs";
            $row2['harga'] = $value->item_unit_price;
            $row2['hargajual'] = $value->item_cost_price/$value->quantity_purchased;
            $row2['subtotal'] = $value->item_cost_price;
            $line2[] = $row2;
            $i++;
        }
        $line['data'] = $line2;
            
        echo json_encode($line);
    }

    public function cetak_faktur_op($no_faktur = '')
    {
        $diskon = $_COOKIE['diskon'];

        date_default_timezone_set("Asia/Bangkok");
        $tgl_jam = date("d-m-Y H:i:s");
        $tgl = date("d-m-Y");

        $namars = $this->config->item('namars');
        $kota_kab = $this->config->item('kota');
        $telp = $this->config->item('telp');
        $alamatrs = $this->config->item('alamat');
        $nmsingkat = $this->config->item('namasingkat');

        $data_detail_pembelian = $this->Frmmtransaksi->get_receivings_optik($no_faktur)->result();
        foreach ($data_detail_pembelian as $row) {
            $data['receiving_time'] = $row->receiving_time;
            $data['payment_type'] = $row->payment_type;
            $payment_type = $data['payment_type'];
            $data['id_receiving'] = $row->receiving_id;
            $id_receiving = $data['id_receiving'];
            $data['total_price'] = $row->total_price;
            $data['supplier_id'] = $row->supplier_id;
            $supplier_id = $data['supplier_id'];
            $data['no_faktur'] = $row->no_faktur;
            $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
            $data['jatuh_tempo'] = $row->jatuh_tempo;
            $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
        }
        $data['company_name'] = $this->Frmmpemasok->get_company_name_optik($no_faktur)->row();
        $company_name = $this->Frmmpemasok->get_company_name_byidsupplier($supplier_id)->row()->company_name;

        print_r($data_detail_pembelian);
        $data['data_receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item_optik($data['id_receiving'])->result();
        $cterbilang = new rjcterbilang();
        $konten =
            "<style type=\"text/css\">
              .table-font-size{
                font-size:7px;
                  }
              .table-font-size1{
                font-size:8.5px;
                  }
              </style>
              
              <table  border=\"0\">
                <tr>
                  <td width=\"16%\" align=\"center\">
                      <img src=\"asset/images/logos/" . $this->config->item('logo_url') . "\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
                  </td>
                  <td  width=\"70%\" style=\" font-size:7px;\">
                  <b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
                  </td>
                  <td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>           
                </tr>
              </table>
              <hr/>
    					<p align=\"center\"><b>
    					FAKTUR PENGADAAN OPTIK<br/>
    					No. FRM. OPT_" . $id_receiving . "
    					</b></p><br/>
    					
    					<table class=\"table-font-size1\">
    						<tr>
    							<td width=\"20%\"><b>No. Faktur</b></td>
    							<td width=\"3%\"> : </td>
    							<td>$no_faktur</td>
    							<td width=\"15%\"> </td>
    							<td width=\"15%\"><b>Jenis Transaksi</b></td>
    							<td width=\"3%\"> : </td>
    							<td>$payment_type</td>
    						</tr>
    						<tr><td width=\"20%\"><b>Supplier</b></td>
                              <td width=\"3%\"> :  </td>
                              <td>" . $company_name . "</td> 
                              <td width=\"15%\"> </td>
    						</tr>
               
    					</table>
    					<br/><br/>
    					<table>
    						<tr><hr>
    							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
    							<th width=\"45%\"><p align=\"center\"><b>Nama Item</b></p></th>
    							<th width=\"20%\"><p align=\"center\"><b>Harga</b></p></th>
    							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
    							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
    						</tr>
    						<hr>
    					";

        $i = 1;
        $jumlah_vtot = 0;
        foreach ($data['data_receiving_item'] as $row) {
            $dis = $row->discount_percent/100;
            $distot = $row->item_unit_price*$dis;
            $hargaUnit = $row->item_unit_price-$distot;
            $jumlah_vtot = $jumlah_vtot + $hargaUnit*$row->quantity_purchased;
            $vtot = number_format($hargaUnit*$row->quantity_purchased, 2, ',', '.');
            $vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);
            $konten = $konten . "<tr>
							  <td><p align=\"center\">$i</p></td>
							  <td><p align=\"center\">$row->description</p></td>
							  <td><p align=\"center\">" . number_format($hargaUnit, 2, ',', '.') . "</p></td>
							  <td><p align=\"center\">$row->quantity_purchased</p></td>
							  <td><p align=\"right\">$vtot</P></td>
							  <br>
							</tr>";
            $i++;
        }
        $konten = $konten . "
        <tr><hr><br>
          <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
          <th><p align=\"right\"><font size=\"12\"><b>" . number_format($jumlah_vtot, 2, ',', '.') . "</b></font></p></th>
        </tr>      
      ";

        $totakhir = $jumlah_vtot - $diskon;
        if ($diskon != 0) {
            $vtot_terbilang = $cterbilang->terbilang($totakhir);
            $konten = $konten . "
            <tr>
              <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Diskon   </b></font></p></th>
              <th ><p align=\"right\"><font size=\"12\"><b>" . number_format($diskon, 2, ',', '.') . "</b></font></p></th>
            </tr>

            <tr><hr><br>
              <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Total Bayar   </b></font></p></th>
              <th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>" . number_format($totakhir, 2, ',', '.') . "</b></font></p></th>
            </tr>";
            $jumlah_vtot = $jumlah_vtot - $diskon;
        }
        $konten = $konten . "
            <b><font size=\"10\"><p align=\"right\">Terbilang : " . $vtot_terbilang . "</p></font></b>
                    <br><br>
                    <p align=\"right\">$kota_kab, $tgl</p>
      </table>
      ";


        $file_name = "FT_$id_receiving.pdf";
        //echo '<script type="text/javascript">window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/").'", "_blank");window.focus()</script>';
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $title = "";
        $obj_pdf->SetTitle($file_name);
        $obj_pdf->SetPrintHeader(false);
        $obj_pdf->SetPrintFooter(false);
        $obj_pdf->SetHeaderData('', '', $title, '');
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins('10', '10', '10');
        $obj_pdf->SetAutoPageBreak(TRUE, '5');
        $obj_pdf->SetFont('helvetica', '', 9);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        ob_start();
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(FCPATH . 'download/logistik_farmasi/' . $file_name, 'FI');
        redirect('logistik_farmasi/Frmcpembelianoptik/index', 'refresh');
    }
}

?>