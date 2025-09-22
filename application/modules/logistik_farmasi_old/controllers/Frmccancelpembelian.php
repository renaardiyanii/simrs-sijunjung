<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmccancelpembelian extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmtransaksi','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpemasok','',TRUE);
  $this->load->model('logistik_farmasi/Frmmkwitansi','',TRUE);
      $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
       $this->load->model('farmasi/Frmmdaftar','',TRUE);
	$this->load->model('master/Mmobat','',TRUE);
  $this->load->model('master/Mmsupplier','',TRUE);
      $this->load->library('session');
  $this->load->helper('pdf_helper');
	}

  function index($param='')
	{
    
   

    $data['obat']=$this->Frmmtransaksi->get_obat()->result();
	  $data['satuan']=$this->Frmmtransaksi->get_satuan()->result();
    $data['select_obat']=$this->Frmmtransaksi->cari_obat()->result();
    $data['Pemasok']=$this->Frmmpemasok->get_pemasok()->result();
    $data['jenis']=$this->Frmmpemasok->get_jenis()->result();
    $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();

   
      $data['title'] = 'Cencel Pembelian Farmasi';

      $login_data = $this->load->get_var("user_info");
       $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
         foreach ($id_gudang as $gudang) {
      //     # code...
           $gud = $gudang->id_gudang;
         }
   //   if ($this->input->post()) {
      
      $data['gudang'] = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
      // print_r($data['gudang']);die();    
  
       $date = date('Y-m-d');
      //$data['jenis_barang']='OBAT';
      $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_cancel_receiving_date($date,$gud)->result();      
      $data['select_pemasok']=$this->Frmmpemasok->cari_pemasok()->result();
      $data['select_jenis']=$this->Frmmpemasok->cari_jenis()->result();
   // }
      $this->load->view('logistik_farmasi/Frmvcancelpembelian',$data);
     
    
	  
	}


public function get_data_po(){
      
        $date = $this->input->post('tgl');
        $jenis = $this->input->post('filter'); 
      //  print_r($jenis);
         $login_data = $this->load->get_var("user_info");
        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
         foreach ($id_gudang as $gudang) {
      //     # code...
           $gud = $gudang->id_gudang;
         }

        if($date == '' ){
                 $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

      //  $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($receiving_id)->result();

        $i=1;
        $hasil = $this->Frmmtransaksi->get_all_data_cancel_receiving_date($date,$gud)->result();
        
     //   print_r($hasil);die();
        foreach ($hasil as $value) {
          if($value->total != ''){
            // $row2['no'] = $i++;
            $row2['no_faktur'] = $value->no_faktur;
            $row2['tgl_kontra_bon'] = date('d-m-Y',strtotime($value->tgl_kontra_bon));
            $row2['jatuh_tempo'] = $value->jatuh_tempo;
            $row2['company_name'] = $value->company_name;
            $row2['jenis_barang'] = $value->jenis_barang;
            $row2['total'] = $value->total;
            $row2['total_price'] = number_format( $value->total_price, 2 , ',' , '.' );
            $row2['aksi'] = " <a class=\"btn btn-danger btn-xs\" href=\"".base_url('logistik_farmasi/frmccancelpembelian/form_detail_transaksi/'.$value->receiving_id)."\">Hapus Pembelian</a>";

            $line2[] = $row2;
        }
      }

        $line['data'] = $line2;

        echo json_encode($line);
    }

    function form_detail_transaksi($receiving_id=''){
        $data['title'] = 'Detail Transaksi';
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_obat']=$this->Mmobat->get_obat_by_gudang($id_gudang)->result();
		    $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($receiving_id)->result();
        $data_company=$this->Frmmpemasok->get_company_name($receiving_id)->result();
        foreach($data_company as $row2){
          $data['supplier_nm'] = $row2->company_name;
        }
        $data_jenis=$this->Frmmpemasok->get_nm_jenis($receiving_id)->result();
      //  print_r($data_jenis);die();
        foreach($data_jenis as $row3){
          $data['jenis_nm'] = $row3->nm_jenis;
   //       print_r($row3->nm_jenis);die();
        }
		        foreach($data_detail_pembelian as $row){
			          $data['receiving_time'] = $row->receiving_time;
			          $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->supplier_id;                
                $data['jenis_barang'] = $row->jenis_barang;
                $data['id_jenis'] = $row->id_jenis;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
                $data['comment'] = $row->comment;
		        }
        $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
        $data['company_name']=$this->Frmmpemasok->get_company_name($receiving_id)->row();
        $data['nm_jenis']=$this->Frmmpemasok->get_nm_jenis($receiving_id)->row();
        $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
        $this->load->view('logistik_farmasi/Frmvcanceltransaksi',$data);
      }



    public function get_data_detail_pembelian(){
    $receiving_id=$this->input->post('receiving_id');
    $datajson=$this->Frmmtransaksi->get_data_receiving($receiving_id)->result();
      echo json_encode($datajson);
    }



  public function hapus_data_receiving($receiving_id='', $id_obat='', $no_faktur='',$id_receiving=''){
   
    $group = $this->Frmmpo->getIdGudang($this->session->userid);
    $item = $this->Frmmtransaksi->get_item($receiving_id)->row();
    $group = $this->Frmmpo->getIdGudang($this->session->userid);
    $query=$this->db->query("SELECT qty FROM gudang_inventory WHERE id_obat='$id_obat' AND batch_no='$item->batch_no' AND id_gudang='$group->id_gudang'");
    $id_obat = $item->item_id;
    $batch = $item->batch_no;
    $id_gudang = $group->id_gudang;
    $exp = $id_obat;
    
    $qty_last=$query->row()->qty;
    $qty_tot=$qty_last-$item->quantity_purchased;
    $cek_inventori=$query->num_rows();
    $qty_kurang = $item->quantity_purchased;
    
    $this->Frmmtransaksi->hapus_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty_kurang);

    $id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);
    
       redirect('logistik_farmasi/Frmccancelpembelian/form_detail_transaksi/'.  $id_receiving);
  
	}

  public function faktur_pembelian()
  {
    $data['title'] = 'Cetak Faktur Farmasi';
    $no_faktur= $this->input->post('faktur_hidden');
    $receiving_id= $this->input->post('receiving_id_hidden');
    if($no_faktur!=''){
      $data['no_faktur']=$no_faktur;
      $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($receiving_id)->result();
            foreach($data_detail_pembelian as $row){
                $data['receiving_time'] = $row->receiving_time;
                $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->supplier_id;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;

            }
      $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
      $data['company_name']=$this->Frmmpemasok->get_company_name($receiving_id)->row();
      $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
      $data['data_permintaan']=$this->Frmmtransaksi->get_all_data_receiving()->result();
      $data['receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();

   //     print_r($data['receiving_item']);die();
          
      if(sizeof($data['data_permintaan'])==0){
        $this->session->set_flashdata('message_no_tindakan','<div class="row">
              <div class="col-md-12">
                <div class="box box-default box-solid">
                <div class="box-header with-border">
                  <center>Tidak Ada Tindakan</center>
                </div>
                </div>
              </div>
            </div>');
      }else{
        $this->session->set_flashdata('message_no_tindakan','');
      }
      
      $this->load->view('logistik_farmasi/Frmvfakturpembelian',$data);
    }else{
      //printf("redirect");
      redirect('logistik_farmasi/Frmcpembelian/faktur_pembelian');
    }
  }

  public function cancel_pembelian($id)
  {
    $receiving_items = $this->Frmmtransaksi->getdata_receiving_item($id);
    foreach ($receiving_items as $item) {
      $query=$this->db->query("SELECT qty FROM gudang_inventory WHERE id_obat='$item->item_id'");
      $qty_last=$query->row()->qty;
      $qty_tot=$qty_last-$qty;
      $cek_inventori=$query->num_rows();

      $this->Frmmtransaksi->update_gudang($id,$qty_tot);
      $this->Frmmtransaksi->cancel_pembelian($id);
      redirect(base_url('logistik_farmasi/Frmcpembelian'));
    }
  }
}
?>