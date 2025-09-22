<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
//include('Frmcterbilang.php');
class Frmcpinjam extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
	$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	$this->load->model('master/Mmobat','',TRUE);
	$this->load->helper('pdf_helper');
	}

	function index()
	{
		$data['title'] = 'Form Peminjaman Persediaan Farmasi';
		$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
		$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();	
		$this->load->view('logistik_farmasi/Frmvdaftarpinjam',$data);
	}

	function get_pinjam_list($url=null){	
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{
			$login_data = $this->load->get_var('user_info');
			$group = $this->Frmmpo->getIdGudang($login_data->userid);
			$data['id_gudang']= $group->id_gudang;
			$hasil = $this->Frmmamprah->getdata_pinjam_by_role($this->input->post(), $url);		
			foreach ($hasil as $value) {
				$row2['id_pinjam'] = $value->id_header;
				$row2['tgl_pinjam'] = date('d-m-Y',strtotime($value->tgl_pinjam));
				$row2['tujuan'] = $value->tujuan;
				$row2['user'] = $value->user;
				$row2['aksi'] = '<center>
				<a href="'.base_url('logistik_farmasi/frmcpinjam/cetak_surat/'.$value->id_header).'" class="btn btn-primary btn-sm" target="_blank">Print</>
							</center>';
								
					$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }



	
	function form($param='')
	{
		
		if($param!=''){
			$data['title'] = 'Form Permintaan Distribusi Barang Habis Pakai (BHP)';
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['select_gudang1'] = $this->Frmmamprah->get_obat_jenis()->result();		
	        $data['data_obat']=$this->Mmobat->get_all_bhp()->result();        
			$this->load->view('logistik_farmasi/Frmvaddamprah_bhp',$data);
		}else{

			$data['title'] = 'Form Pinjam Persediaan Farmasi';
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['satuan'] = $this->Frmmamprah->get_satuan_obat()->result();
			 foreach ($data['select_gudang0'] as $row) {
		
			 	 $gudang = $row->id_gudang;
			 }
			$data['select_gudang1'] = $this->Frmmamprah->get_tujuan_peminjaman()->result();
			$data['data_obat']=$this->Mmobat->get_all_obat()->result();
			$this->load->view('logistik_farmasi/Frmvaddpinjam',$data);
		}
		
	}
	
    function save(){	
		$id_pinjam = $this->Frmmamprah->insert_peminjaman($this->input->post()) ;
		if ( $id_pinjam != '' ){
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data Amprah berhasil disimpan
					  </div>';
		}else{				
			
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data Amprah gagal disimpan
					  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		$this->session->set_flashdata('cetak', 'cetak('.$id_pinjam.');');
		redirect('logistik_farmasi/Frmcpinjam/');
		
    } 


	public function get_satuan_obat(){
		// var_dump($this->input->post('id'));die();
		$data = $this->Frmmamprah->get($this->input->post('id'));
		echo $data->satuan;
	}

	public function get_satuan_obat_for_distribusi(){
		// var_dump($this->input->post('id'));die();
		
		$id_batch  = explode('@',$this->input->post('id'));
		$id_obat = $id_batch[0];
		$batch_no = $id_batch[1];
		$id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
		// var_dump($batch_no);die();
		$data = $this->Frmmamprah->get_for_dis($id_obat,$batch_no,$id_gudang);
		// var_dump($data);die();
		echo json_encode($data);
	}
	
	public function auto_id_amprah(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('amprah')->like('id_amprah',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->id_amprah
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
    function get_info(){
		$id = $this->input->post('id');
		echo json_encode($this->Frmmamprah->get_info($id));
    }


   

    function get_amprahbhp_list(){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->Frmmamprah->getdata_amprahbhp_by_role($this->input->post());
			/*$line['data'] = $hasil;*/			
			foreach ($hasil as $value) {
				$row2['id_amprah'] = $value->id_amprah;
				$row2['tgl_amprah'] = $value->tgl_amprah;
				$row2['gd_dituju'] = $value->nama_gudang;
				$row2['gd_asal'] = $value->nama_gudang_dituju;
				//$row2['sumber_dana'] = $value->sumber_dana;
				$row2['user'] = $value->user;
				//$row2['no_faktur'] = $value->no_faktur;
				if ($value->status != 1)
					$row2['status'] = '<font color="red">Open</font>';
				else
					$row2['status'] = '<font color="green">Closed</font>';
				if ($value->status != 1)
					$row2['aksi'] = '<center>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_amprah.'">Detail</button> <a href="'.base_url('logistik_farmasi/frmcdistribusi/cetak_faktur_amprah/'.$value->id_amprah).'" class="btn btn-primary btn-sm">Print</a> 
								</center>';
				else
					$row2['aksi'] ='<a href="'.base_url('logistik_farmasi/frmcdistribusi/cetak_faktur_amprah/'.$value->id_amprah).'" class="btn btn-primary btn-sm">Print</a>';
					// $row2['aksi'] ='<center>
					// <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal2" data-id="'.$value->id_amprah.'">Cetak</button> 
					// 			</center>';
							
				$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }

    function get_amprah_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmamprah->get_amprah_detail_list($this->input->post('id'));
		
		foreach ($hasil as $value) {
			$row2['id_obat'] = $value->id_obat;
			$row2['nm_obat'] = $value->nm_obat;
			$row2['satuank'] = $value->satuank;
			$row2['qty_req'] = $value->qty_req;
		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

       function get_stock(){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->Frmmamprah->getdata_stock_by_role($this->input->post());
			/*$line['data'] = $hasil;*/			
			foreach ($hasil as $value) {
				$row2['id_obat'] = $value->id_obat;
				$row2['nm_obat'] = $value->nm_obat;
				$row2['gudang'] = $value->nama_gudang;
				$row2['qty'] = $value->qty;
							
				$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }

    function cek_stock(){
    	$id_obat = $this->input->post('id_obat');
    	$qty = $this->input->post('qty');
    	$gudang = $this->input->post('gd_asal');
    	$login_data = $this->load->get_var("user_info");
    	$user = $login_data->username;
    	$batch = "0";
        $hasil = $this->Frmmamprah->insert_history($id_obat,$qty,$gudang,$batch,$user);
        if($hasil){
        	echo json_encode(['success' => 1]);
        }else{
        	echo json_encode(['success' => 0]);
        }
    }

    function cek_stock_hapus(){
    	$id_obat = $this->input->post('id_obat');
    	$qty = $this->input->post('qty');
    	$gudang = $this->input->post('gd_asal');
    	$login_data = $this->load->get_var("user_info");
    	$user = $login_data->username;
    	$batch = "0";
        $hasil = $this->Frmmamprah->insert_history_hapus($id_obat,$qty,$gudang,$batch,$user);
        if($hasil){
        	echo json_encode(['success' => 1]);
        }else{
        	echo json_encode(['success' => 0]);
        }
    }

	public function cetak_faktur_amprah($id_amprah){
		//$id_amprah = 23;
		//var_dump($id_amprah);die();
		date_default_timezone_set("Asia/Bangkok");
		$data['tgl_jam'] = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");

		  $namars=$this->config->item('namars');
		  $kota_kab=$this->config->item('kota_kab');
		  $alamatrs=$this->config->item('alamat');
		  $telp=$this->config->item('kota');
       	  $header_pdf=$this->config->item('header_pdf');
	   
		//$data_detail_amprah=$this->Frmmamprah->get_receivings($no_faktur_amp)->result();
		$data['dat_amprah']=$this->Frmmamprah->get_info($id_amprah);
		//$data = json_decode(json_encode($data1), true);
		/*
		 $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();
		*/  

		$data['data_detail_amprah']=$this->Frmmamprah->get_amprah_detail_list($id_amprah);
		
		return $this->load->view('cetak/CETAK_FAKTUR_AMPRAH',$data);
		
	
		
	} 


	public function cetak_faktur_amprah_($id_amprah){
		//$id_amprah = 23;
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

		// var_dump($data);die();
		/*
		 $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();


		*/  

		// return $this->load->view('cetak/CETAK_FAKTUR_AMPRAH');

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
				  DISTRIBUSI BARANG<br/>
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
					  <td width=\"15%\"><b>Tujuan Distribusi</b></td>
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
		
		$data_detail_amprah=$this->Frmmamprah->get_amprah_detail_list($id_amprah);
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
					<br>
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
		// ob_start();
		ob_clean();
		ob_flush();
		  $content = $konten;
		// ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name,'FI');

		
		// $pdf->Output('example_007.pdf', 'I');
		ob_end_flush();
		ob_end_clean();
		
	} 

    public function data_obat_all_search($keyword=''){
        $userid = $this->session->userid;
        if ($keyword == '') {
            echo "<table id=\"table_obat_all\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
                        <th style=\"width: 5%;\">No</th>
                        <th style=\"width: 35%;\">Gudang</th>
                        <th style=\"width: 50%;\">Nama Obat</th>
                        <th style=\"width: 10%;\">Stok</th>
                    </tr>
                </thead>";
            echo "</table>";
        }else{
            $data=$this->Frmmamprah->get_obat_pilih_all_search($keyword)->result();
        
            echo "<table id=\"table_obat_all\" class=\" table display nowrap table-hover table-bordered table-striped\" style=\"width: 100%;\">
                <thead>
                    <tr>
						<th style=\"width: 5%;\">No</th>
						<th style=\"width: 35%;\">Gudang</th>
						<th style=\"width: 50%;\">Nama Obat</th>
						<th style=\"width: 10%;\">Stok</th>
						<th style=\"width: 10%;\">Batch</th>
						<th style=\"width: 10%;\">Expire</th>
                    </tr>
                </thead>";
			$i = 1;
            foreach ($data as $key) {
           
                echo "<tr>
                        <td>
                            <p>".$i++."</p>
                        </td>          
						<td>
							<p>$key->nama_gudang</p>
						</td>          
						<td>
							<p>$key->nm_obat</p>
						</td>          
						<td>
							<p>$key->qty</p>
						</td>  
						<td>
							<p>$key->batch_no</p>
						</td>  
						<td>
							<p>$key->expire_date</p>
						</td>              
                    </tr>";
            }
            echo "</table>";
        }       
        
    }

	function autocomplete_obat(){    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->Frmmamprah->autocomplete_obat($q);
        }
    }

	function verifikasi_total(){    
		
		$id_amprah = $this->input->post('id_amprah');
		$data_obat = $this->Frmmamprah->get_obat_done_distribusi( $id_amprah)->result_array();
		$this->Frmmamprah->insert_verifiksi_total($data_obat);
		redirect('logistik_farmasi/Frmcamprah');
	 }

	 public function cetak_surat($id_pinjam){
        
        date_default_timezone_set("Asia/Bangkok");
        $tgl_jam = date("d-m-Y H:i:s");
        $tgl = date("d-m-Y");

        $namars=$this->config->item('namars');
        $kota_kab=$this->config->item('kota_kab');
        $alamatrs=$this->config->item('alamat');
        $telp=$this->config->item('kota');
        $header_pdf=$this->config->item('header_pdf');

        $data['identitas_pinjam']=$this->Frmmamprah->get_info_header_pinjam($id_pinjam)->row();
        $data['data_detail_pinjam']=$this->Frmmamprah->get_detail_pinjam($id_pinjam)->result();
        $data['no']=1; 

        return $this->load->view('cetak/surat_pinjam',$data);

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
    
}
?>
