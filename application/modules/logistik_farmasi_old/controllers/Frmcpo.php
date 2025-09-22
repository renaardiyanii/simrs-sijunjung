<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'controllers/Secure_area.php');
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Frmcpo extends Secure_area
{
    public function __construct(){
        parent::__construct();
        $this->load->model('farmasi/Frmmdaftar','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->model('master/Mmobat','',TRUE);
        $this->load->helper('pdf_helper');
    }

    function index()
    {
        $data['title'] = 'Monitoring PO Farmasi';
        $data['select_pemasok'] = $this->Frmmpo->get_suppliers();
        $this->load->view('logistik_farmasi/Frmvpo',$data);
    }

    function form()
    {
        $data['title'] = 'Form PO Farmasi';
        $data['select_pemasok'] = $this->Frmmpo->get_suppliers();
        $data['select_produsen'] = $this->Frmmpo->get_produsen();
        $data['kemasan'] = $this->Frmmpo->get_kemasan();
        $data['satuan']=$this->Frmmpo->get_satuan();
        $data['generik']=$this->Mmobat->get_data_generik_obat()->result();
        $data['golongan']=$this->Mmobat->get_data_golongan()->result();
        $data['bentuk_sediaan']=$this->Mmobat->get_data_subkelompok_obat()->result();
        //  $data['no_po'] = $this->Frmmpo->getNomorPO();
        $data['data_obat']=$this->Mmobat->get_all_obat()->result();
        $data['obat_satuan'] = $this->Frmmpo->getSatuanObat()->result();
        $this->load->view('logistik_farmasi/Frmvaddpo',$data);
    }

    function save(){
        /*echo "<pre>";
        echo print_r( $this->input->post() );
        echo "</pre>";*/
        $data = $this->input->post();
        // var_dump($data);die();

        // echo $data;
        // echo "<pre>";
        // var_dump($data);
        // $array = explode(',', $data['dataobat']);
        // ;
        // $dataobj = (object)  $array[7];
        // print_r($dataobj);
       
        // die();
        $id_po = $this->Frmmpo->insert($this->input->post());
        // return $id_po;
        $no_po = $this->input->post('no_po');
        // $jenis_pesanan = $this->input->post('sumber_dana');
        $supplier_id = $this->input->post('supplier_id');
        $supplier = $this->Frmmpo->getNamaSupplier($supplier_id);

        if ( $id_po != '' ){
            $msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data PO berhasil disimpan
					  </div>';
        }else{
            $msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data PO gagal disimpan
					  </div>';
        }
        $this->session->set_flashdata('alert_msg', $msg);
        // $this->cetak_faktur($id_po, $no_po, $jenis_pesanan, $supplier->adress);
        // $this->cetak_faktur($id_po, $no_po, $supplier->adress);
        $this->session->set_flashdata('cetak', 'cetak('.$id_po.');');
        // redirect('logistik_farmasi/Frmcpo/surat_pesanan/'.$id_po);
        redirect('logistik_farmasi/Frmcpo');

    }
    
    public function surat_pesanan($id_po){
        $data['info_po'] =$this->Frmmpo->get_info($id_po);
        $data['detail_po']=$this->Frmmpo->get_po_detail_list_beli_pesanan($id_po);
        $jenispo = isset($data['info_po']->jenis_po)?$data['info_po']->jenis_po:'';
     
        if( $jenispo == 'Obat_tertentu' || $jenispo == 'psikotropika' ){
          return $this->load->view('cetak/surat_pesanan',$data);
        }else if($jenispo == 'narkotika'){
          return $this->load->view('cetak/narkotika',$data);
        }else{
          return $this->load->view('cetak/surat_pesanan_all',$data);
        }
    
        
      }
      
    public function get_satuan_obat(){
        $data = $this->Frmmpo->get($this->input->post('id'));
        echo $data->satuank."|".$data->hargabeli;
    }

    public function cari_data_obat(){
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        if($group->id_gudang == "8" || $group->id_gudang == "7"){
            $ids = "1";
        }else{
            $ids = join("','",$no_gudang);
        }
        $keyword = strtoupper($this->uri->segment(4));
        $data = $this->Frmmpo->cari_obat_keyword($keyword);
        if(!empty($data)){
            foreach($data as $row)
            {
                $arr['suggestions'][] = array(
                    'value'	=> $row->nm_obat,
                    'idobat' => $row->id_obat,
                    'nama'	=>$row->nm_obat,
                    'satuank'  =>$row->satuank,
                    'harga' => $row->hargajual,
                    'hargabeli' => $row->hargabeli,
                    'jenis_obat' => $row->jenis_obat,
                    'satuanb'  =>$row->satuanb,
                    'faktorsatuan'  =>$row->faktorsatuan,
                    'hargabeligd'  =>$row->hargabeligd
                );

                // $arr['suggestions'][] = array(
                //     'value'	=> $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",".$row->qty.")",
                //     'idobat' => $row->id_obat,
                //     'nama'	=>$row->nm_obat,
                //     'satuank'  =>$row->satuank,
                //     'harga' => $row->hargajual,
                //     'hargabeli' => $row->hargabeli,
                //     'batch_no' => $row->batch_no,
                //     'expire_date' => $row->expire_date,
                //     'qty' => $row->qty,
                //     'jenis_obat' => $row->jenis_obat
                // );
            }
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    public function auto_no_po(){
        $keyword = $this->uri->segment(4);
        $data = $this->db->from('header_po')->like('no_po',$keyword)->limit(12, 0)->get()->result();

        foreach($data as $row)
        {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value'	=>$row->no_po,
                'id' => $row->id_po
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    function get_info(){
        $id = $this->input->post('id');
        echo json_encode($this->Frmmpo->get_info($id));
        //echo json_encode($this->Frmmpo->get_header_po($id)->row());
    }

    function get_po_list(){
        //print_r($this->input->post());
        $line  = array();
        $line2 = array();
        $row2  = array();
        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
            $hasil = $this->Frmmpo->get_po_list($this->input->post());
            /*$line['data'] = $hasil;*/
            foreach ($hasil as $value) {
                $row2['id_po'] = $value->id_po;
                $row2['no_po'] = $value->no_po;
                $row2['tgl_po'] = $value->tgl_po;
                $row2['company_name'] = $value->company_name;
                $row2['nm_produsen'] = $value->nm_produsen;
                //$row2['supplier'] = $value->company_name;
                $row2['sumber_dana'] = $value->sumber_dana;
                $row2['user'] = $value->user;

                //$row2['no_faktur'] = $value->no_faktur;
                // if ($value->open > 0){
                //     $row2['status'] = '<font color="red">Open</font>';
                //     $row2['aksi'] = '<center>
                // <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button><br>
                // <button class="btn btn-danger btn-sm btn-cancel" id="btnCancel" data-idpo="'.$value->id_po.'">Batalkan</button>
                //             </center>';
                // }else if ($value->open == '' || null){
                //     $row2['status'] = '<font color="green">On Progress</font>';
                //     $row2['aksi'] = '<center>
                // <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>
                //             </center>';
                // }else{
                //     $row2['status'] = '<font color="green">Closed</font>';
                //     $row2['aksi'] = '<center>
                // <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>
                //             </center>';
                // }

                if ($value->open == 1){
                    $row2['status'] = '<font color="green">Open</font>';
                    $row2['aksi'] = '<center>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>
                    
                          </center>';
                        //   <button class="btn btn-danger btn-sm" id="btnCancel">Batalkan</button>
                }else if($value->open == 0){
                    $row2['status'] = '<font color="red">Closed</font>';
                    $row2['aksi'] = '<center>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>';
                }else{
                    $row2['status'] = '<font color="ltgreen">On Progress</font>';
                    $row2['aksi'] = '<center>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>';
                }
    //             $row2['aksi'] = '<center>
				// <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Details</button>
    //             <button class="btn btn-danger btn-sm" id="btnCancel">Batalkan</button>
				// 			</center>';

                $line2[] = $row2;
            }
            $line['data'] = $line2;

        }
        echo json_encode($line);
    }

    function cancel_po(){
        $id = $this->input->post('id');
        echo json_encode($this->Frmmpo->cancel_po($id));
    }

    function get_pembelian_po_list(){
        //print_r($this->input->post());
        $line  = array();
        $line2 = array();
        $row2  = array();
        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
            $hasil = $this->Frmmpo->get_po_list($this->input->post());
            /*$line['data'] = $hasil;*/
            foreach ($hasil as $value) {
                $row2['id_po'] = $value->id_po;
                $row2['no_po'] = $value->no_po;
                $row2['tgl_po'] = $value->tgl_po;
                $row2['company_name'] = $value->company_name;
                //$row2['supplier'] = $value->company_name;
                $row2['sumber_dana'] = $value->sumber_dana;
                $row2['user'] = $value->user;

                //$row2['no_faktur'] = $value->no_faktur;
                if ($value->open == 1){
                    $row2['status'] = '<font color="green">Open</font>';
                    $row2['aksi'] = '<center>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'" data-qty="'.$value->qty.'" data-qtyb="'.$value->qtybeli.'">Isi Faktur</button> <a href="'.base_url('logistik_farmasi/frmcpembelian_po/cetak_faktur/'.$value->id_po).'" class="btn btn-primary btn-sm" target="_blank">Print</> 
                                </center>';
                }else if($value->open == 0){
                    $row2['status'] = '<font color="red">Closed</font>';
                    $row2['aksi'] = '<center><a href="'.base_url('logistik_farmasi/frmcpembelian_po/cetak_faktur/'.$value->id_po).'" class="btn btn-primary btn-sm" target="_blank">Print</></center>';
                }else{
                    $row2['status'] = '<font color="ltgreen">On Progress</font>';
                    $row2['aksi'] = '<center>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'" data-qty="'.$value->qty.'" data-qtyb="'.$value->qtybeli.'">Isi Faktur</button> <a href="'.base_url('logistik_farmasi/frmcpembelian_po/cetak_faktur/'.$value->id_po).'" class="btn btn-primary btn-sm" target="_blank">Print</a></center>';
                }
                $line2[] = $row2;
            }
            $line['data'] = $line2;
        }
        echo json_encode($line);
    }

    function get_detail_list(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $hasil = $this->Frmmpo->get_po_detail_list($this->input->post('id'));
        // var_dump( $hasil);die();
        $total = 0;
        foreach ($hasil as $value) {
            // $row2['item_id'] = "<input type='text' class='itemid' name='itemid[]' style='text-align: left; width: 50px; float: left; background: transparent; border: none; color: #01DFD7;' readonly value = '".$value->item_id."'>";
            // $row2['item_id'] = $value->item_id;
            $row2['item_id'] = "<input type='hidden' name='itemid[]' value='".$value->item_id."'>".$value->item_id;
            $row2['description'] = $value->description;
            $row2['nm_generik'] = $value->nm_generik;
            $row2['satuank'] = $value->satuank;
            $row2['bentuk_sediaan'] = $value->bentuk_sediaan;
            $row2['kemasan'] = $value->kemasan;
            $row2['qty_po'] = "<input type='text' class='qtypo' name='qtypo[]' style='text-align: right; width: 50px; float: right; background: transparent; border: none;' readonly value = '".number_format($value->qty, '0', ',', '.')."'>";
            $row2['qty_beli'] = $value->qty_beli;
            $row2['batch_no'] = $value->batch_no;
            $row2['keterangan'] = $value->keterangan;
            $row2['expire_date'] = $value->expire_date;
            $row2['hargabeli'] = "<p align='right'>".number_format($value->hargabeli, '0', ',', '.')."</p>";
            $row2['subtotal'] = "<p align='right'>".number_format($value->subtotal, '0', ',', '.')."</p>";
            $row2['jml_kemasan'] = "<p align='right'>".number_format($value->jml_kemasan, '0', ',', '.')."</p>";
            $row2['harga_item'] = "<p align='right'>".number_format($value->harga_item, '0', ',', '.')."</p>";
            $total += $value->subtotal;
            $line2[] = $row2;
        }
        $line['data'] = $line2;
        $line['total'] = number_format($total, '2', ',', '.');

        echo json_encode($line);
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
        $data1=$this->Frmmpo->get_info($id_po);
        $data = json_decode(json_encode($data1), true);
        /*
         $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();
        */

        $konten = "<style type=\"text/css\">
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
        $konten .="<table width=\"100%\">
                        <tr>
                            <td align=\"center\"><b>SURAT PEMESANAN BARANG<br/>".$data['no_po']."</b></td>
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
                    </tr>";
        $data_detail_po=$this->Frmmpo->get_po_detail_list($id_po);
        $no=1; $ttot = 0;
        foreach($data_detail_po as $row){
            $konten = $konten . "
					<tr>
						<td align=\"center\" class=\"me\">".$no++."</td>
						<td align=\"center\" class=\"me\">".$row->description."</td>
						<td align=\"center\" class=\"me\">".$row->satuank."</td>
						<td align=\"center\" class=\"me\">".$row->qty."</td>
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

        $konten .= "<tr>
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
		  			  <td width=\"30%\" align=\"center\">Mengetahui</td>
		  			  <td width=\"40%\"></td>
					  <td width=\"30%\" align=\"center\">Petugas pesan</td>
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
        ob_start();
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(FCPATH.'download/logistik_farmasi/PO/'.$file_name,'F');

    }

    function is_exist(){
        $id = $this->input->post('id');
        echo json_encode($this->Frmmpo->checkisexist($id));
    }

    public function export_excel($tgl0, $tgl1)
    {
        $data['title'] = 'PO Farmasi';
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
        $data_po=$this->Frmmpo->get_data_po($param1, $param2)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_po.xlsx');

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

        $objPHPExcel->getActiveSheet()->mergeCells('F3:H3');
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
            $data_obat=$this->Frmmpo->get_data_po_obat($row->id_po)->result();
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
                $j++;
                $rowCount++;
            }
        }
        header('Content-Disposition: attachment;filename="Lap_PO.xlsx"');


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

    function update_qty_po(){
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $iditem = $this->input->post('iditem');
        echo json_encode($this->Frmmpo->update_qty_po($id, $qty, $iditem));
    }

}
?>
