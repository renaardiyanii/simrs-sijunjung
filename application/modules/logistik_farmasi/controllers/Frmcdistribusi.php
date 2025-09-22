<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcdistribusi extends Secure_area
{
	public function __construct(){
		parent::__construct();
		$this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
		$this->load->model('logistik_farmasi/Frmmdistribusi','',TRUE);
        $this->load->helper('pdf_helper');
	}

	function index($param='')
	{
		if($param==''){
			$data['title'] = 'Distribusi Logistik Farmasi';
			$data['jenis_barang']='OBAT';
		}else{
			$data['title'] = 'Distribusi Logistik Barang Habis Pakai';	
			$data['jenis_barang']='BHP';		
		}
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();	
			$this->load->view('logistik_farmasi/Frmvdaftardistribusi',$data);
		
	}
	
    function get_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmdistribusi->get_amprah_detail_list($this->input->post('id'));
		
		foreach ($hasil as $key =>$value) {
			$row2['id_obat'] = $value->id_obat;
			$row2['nm_obat'] = $value->nm_obat;
			$row2['satuank'] = $value->satuank;
			$row2['qty_req'] = $value->qty_req;
			$row2['id_amprah'] = $value->id_amprah;
			/*
			if ($value->qty_acc == null)
				$row2['qty_acc'] = '<input type="hidden" value="'.$value->id.'" name="id">
				<input type="hidden" value="'.$value->id_gudang.'" name="id_gdmnt">
				<input type="hidden" value="'.$value->id_gudang_tujuan.'" name="id_gdtj">
				<input type="hidden" value="'.$value->id_obat.'" name="id_obat">
				<input type="number" id="qty_acc'.($key+1).'" name="qty_acc" min=0 >';
			else
				$row2['qty_acc'] = $value->qty_acc;
			if (($value->batch_no == null)&&($value->qty_acc == null)){
				$stock = $this->Frmmamprah->get_amprah_detail_stock($value->id_obat, $value->id_gudang_tujuan);
				$select = '<select size="1" class="batch_no" name="batch_no">';
				foreach ($stock as $value2) {
					$select = $select . '<option value="'.$value2->batch_no.'">'.$value2->batch_no.' (Expire: '.$value2->expire_date.'||Stock:'.$value2->qty.')</option>';
				}
				$select = $select . "</select>";
				$row2['batch_no'] = $select;		
			}else
				$row2['batch_no'] = $value->batch_no;
			if (($value->keterangan == null)&&($value->qty_acc == null))
				$row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan">';
			else
				$row2['keterangan'] = $value->keterangan;	
			$row2['expire_date'] = $value->expire_date;
			*/
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }


	function get_detail_acc(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$value2 = $this->Frmmdistribusi->get_total_acc($this->input->post());
		// $total_qty_acc = $value2->total_qty_acc;
		$kuota = $value2->qty_req;
		$acc= 0;
		// var_dump($kuota);die();
		$id_obat = $value2->id_obat;
		$id_gudang = $value2->gd_asal;
		$id_gudang_tujuan = $value2->gd_dituju;
		$qty_req = $value2->qty_req;
		$satuank = $value2->satuank;
		$hasil = $this->Frmmdistribusi->get_amprah_detail_acc($this->input->post());
		// var_dump($hasil);die();
		foreach ($hasil as $value) {
			$acc+=$value->qty_acc;
			$row2['qty_acc'] = $value->qty_acc;
			$row2['batch_no'] = $value->batch_no;
			$row2['expire_date'] = $value->expire_date;
			$row2['aksi'] = '';
			$line2[] = $row2;
		}
		$exp = "";
		if ($kuota>0 && (intval($kuota) - $acc != 0)){
			$stock = $this->Frmmdistribusi->get_amprah_detail_stock($id_obat, $id_gudang_tujuan);
			$select = '<select size="1" class="batch_no" id="batch_no" onchange="rubahExp(this)">';
			$select.='<option value="" selected>Silahkan Pilih</option>
			<option value="-">TAP</option>';
			foreach ($stock as $value2) {
				$select = $select . '<option value="'.$value2->batch_no.'~'.$value2->expire_date.'">'.$value2->batch_no.' (Stock:'.$value2->qty.','.$value2->expire_date.')</option>';
				$exp = $value2->expire_date;
			}
			$select = $select . "</select>";
			$row2['batch_no'] = $select;	
			$row2['qty_acc'] = '<input type="number" id="qty_acc" name="qty_acc" min=0 max='.$kuota.' >';
            $row2['aksi'] = '<button class="btn btn-xs btn-primary" id="btnSimpan">Simpan</button>';
            $row2['expire_date'] ='<input type="text" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd" >
			<input type="hidden" value="'.$id_gudang.'" id="id_gudang">
			<input type="hidden" value="'.$id_gudang_tujuan.'" id="id_gudang_tujuan">
			<input type="hidden" value="'.$satuank.'" id="satuank">
			<input type="hidden" value="'.$qty_req.'" id="qty_req">';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }
	
	function save_detail_acc(){
		$this->Frmmdistribusi->insert_detail_acc($this->input->post()) ;
		echo true;
		// echo "<pre>";
		// echo print_r($this->input->post());
		// echo "</pre>";
	}
	function delete_detail_acc(){
		$this->Frmmdistribusi->delete_detail_acc($this->input->post('id')) ;
		echo true;
	}
	function close_amprah(){
		$this->Frmmdistribusi->update_status_amprah($this->input->post('id_amprah')) ;
		echo true;
	}

	public function cetak_faktur_amprah($id_amprah){
		//$id_amprah = 23;
		error_reporting(~E_ALL);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		  $namars=$this->config->item('namars');
		  $kota_kab=$this->config->item('kota_kab');
		  $alamatrs=$this->config->item('alamat');
		  $telp=$this->config->item('kota');
       	  $header_pdf=$this->config->item('header_pdf');
	   
		//$data_detail_amprah=$this->Frmmamprah->get_receivings($no_faktur_amp)->result();
		$data1=$this->Frmmamprah->get_info($id_amprah);
		$data = json_decode(json_encode($data1), true);
		/*
		 $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();
		*/  

		$konten=
				  "<style type=\"text/css\">
                    table.me {
                        border-collapse: collapse;
                    }
                    
                    table.me, tr.me, td.me {
                        border: 0.5px solid black;
                    }
                    </style>
                    <style type=\"text/css\">
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
                    <hr/>
				  <br>
				  <p align=\"center\"><b>
				  PERMINTAAN BARANG<br/>
				  No. AMP.".$id_amprah."
				  </b></p><br/>
				  <br><br>
				  <table>
					<tr>
					  <td width=\"15%\"><b>Gudang Asal</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"25%\">".$data['nm_gd_asal']."</td>
					</tr>
					<tr>
					  <td width=\"15%\"><b>Gudang Tujuan</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"25%\">".$data['nm_gd_dituju']."</td>
					</tr>
				  </table>
				  <br/><br/>
				  <table style=\"font-size: 8px;\" border=\"0.5\">
					<tr>
					  <th width=\"5%\"><b>No</b></th>
					   <th width=\"10%\"><b>Kode</b></th>
					  <th width=\"50%\"><b>Nama Item</b></th>
					  <th width=\"10%\"><b>Qty</b></th>
					  <th width=\"25%\"><b>Satuan</b></th>
					</tr>";
		
		$data_detail_amprah=$this->Frmmamprah->get_amprah_detail_acc($id_amprah);
		foreach($data_detail_amprah as $key=>$row){
			$konten = $konten . "
					<tr>
						<td>".($key+1)."</td>
						<td>".$row->id_obat."</td>
						<td>".$row->nm_obat."</td>
						<td>".$row->qty_req."</td>
						<td> ".$row->satuank."</td>
					</tr>";
		}
		$konten = $konten ."
					<br><br><br><br><br><br><br>
		  </table>
		  <table>
		  <tr>
					  <td></td>
					</tr>
		  			<tr>
		  			  <td width=\"58%\"></td>
					  <td width=\"40%\">Bukittinggi, ______ ________________ 20____</td>
					</tr>
					<br><br><br>
					<center>
					<tr>
					  <td width=\"4%\"></td>
					  <td width=\"30%\"></td>
					  <td width=\"30%\"></td>
					  <td width=\"30%\" align=\"center\">Mengetahui,</td>
					</tr>
					<tr>
					  <td width=\"4%\"></td>
					  <td width=\"34%\" align=\"center\">&nbsp;&nbsp;&nbsp;Yang Menerima</td>
					  <td width=\"26%\" align=\"center\">Yang Mengeluarkan</td>
					  <td width=\"30%\" align=\"center\">Kepala Gudang</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<br><br><br>
					<tr>
					  <td width=\"10%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					  <td  width=\"3%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					  <td  width=\"3%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					</tr>
					</center>
		  </table>
		  ";

					  
		$file_name="FA_$id_amprah.pdf";

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name);
		
	}
/*
	function alokasi(){
		$this->Frmmamprah->update($this->input->post('json'));
		echo true;
	}
*/
}
?>
