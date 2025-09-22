<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcpembelian extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmtransaksi','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpemasok','',TRUE);
  $this->load->model('logistik_farmasi/Frmmkwitansi','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	$this->load->model('master/Mmobat','',TRUE);
  $this->load->model('master/Mmsatuan_obat','',TRUE);
  $this->load->model('master/Mmsupplier','',TRUE);
  $this->load->model('iri/rimtindakan','',TRUE);
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
    $login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
    $data['pbf']=$this->Frmmtransaksi->master_pbf()->result();
    $data['produsen']=$this->Frmmtransaksi->master_produsen()->result();
    //  var_dump($data['roleid']);die();
    if($param=='1'){
      $data['title'] = 'Pembelian Barang Habis Pakai (BHP)';
      //$data['jenis_barang']='BHP';
      $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_receiving_bhp()->result();       
      $data['select_pemasok']=$this->Frmmpemasok->cari_pemasok_bhp()->result();
      $this->load->view('logistik_farmasi/Frmvpembelian_bhp',$data);
    }else{
      $data['title'] = 'Pembelian Farmasi';
      //$data['jenis_barang']='OBAT';
      $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_receiving()->result();      
      $data['select_pemasok']=$this->Frmmpemasok->cari_pemasok()->result();
      $data['select_jenis']=$this->Frmmpemasok->cari_jenis()->result();
      $this->load->view('logistik_farmasi/Frmvpembelian',$data);
    }
    
    
	  
	}

  function form_supplier(){
    $data['title'] = 'Tambah Pemasok';
    $data['Pemasok']=$this->Frmmpemasok->get_pemasok()->result();
	  $data['company_name']=$this->Frmmpemasok->get_company()->result();
	  $data['account_number']=$this->Frmmpemasok->get_account_numb()->result();
    $this->load->view('logistik_farmasi/Frmvtambahpemasok',$data);
  }

  public function insert_supplier(){
    $data['company_name']=$this->input->post('nmsupplier');
    $data['account_number']=$this->input->post('accountnumber');
    $data['adress']=$this->input->post('adress');
    $data['zip_code']=$this->input->post('zip_code') == ''?null:$this->input->post('zip_code');
    $data['phone']=$this->input->post('phone');
    $this->Mmsupplier->insert_supplier($data);
    
    // $this->Frmmpemasok->insert_supplier($data);
    redirect('logistik_farmasi/Frmcpembelian');
  }

  function insert_detail_pembelian(){

    // var_dump($this->input->post());die();
    $login_data = $this->load->get_var("user_info");
    $data['receiving_by'] = $login_data->username;
    $data['supplier_id']=$this->input->post('id_supplier');
    $data['produsen_id']=$this->input->post('id_produsen');
    $data['no_faktur']=$this->input->post('no_faktur');
    $data['no_do']=$this->input->post('no_do');
    $data['do_faktur']=$this->input->post('do_faktur');
    $data['receiving_time']= date('Y-m-d H:i:s');
    $data['status']= $this->input->post('status');
    $data['comment']=$this->input->post('comment');
    $data['payment_type']=$this->input->post('payment_type');
    // $data['jatuh_tempo']=$this->input->post('jatuh_tempo');
    // $data['tgl_kontra_bon']=$this->input->post('tgl_kontra_bon');
    $data['id_jenis']=$this->input->post('id_jenis');
    $data['jenis_barang']= 'UMUM';
    $jatuh_tempo = $this->input->post('jatuh_tempo');
    $kontra_bon =$this->input->post('tgl_kontra_bon');
    $kontra_bon_do =$this->input->post('tgl_kontra_bon_do');
    $diterima_barang = $this->input->post('diterima_barang');
    if($jatuh_tempo == ''){
      $data['jatuh_tempo']= null;
    }else{
      $data['jatuh_tempo']= $this->input->post('jatuh_tempo');
    }

    if($diterima_barang == ''){
      $data['diterima_barang']= null;
    }else{
      $data['diterima_barang']= $this->input->post('diterima_barang');
    }

    if($kontra_bon == ''){
      $data['tgl_kontra_bon']= null;
    }else{
      $data['tgl_kontra_bon']= $this->input->post('tgl_kontra_bon');
    }

    if($kontra_bon_do == ''){
      $data['tgl_kontra_bon_do']= null;
    }else{
      $data['tgl_kontra_bon_do']= $this->input->post('tgl_kontra_bon_do');
    }
    // $data['jenis_barang']=$this->Frmmpo->getIdGudang($this->session->userid)->id_gudang == 1 ? 'UMUM' : 'BPJS';
    $data['ppn']=11;
    $data['total_price'] = '0';
    $receiving_id = $this->Frmmtransaksi->insert_detail($data);
    if($this->input->post('jenis_barang')!=''){
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$receiving_id);
    }else
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$receiving_id);
        
  }

    function form_detail_transaksi__($receiving_id=''){
        $data['title'] = 'Detail Transaksi';
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_obat']=$this->Mmobat->get_all_obat_aktif()->result();
        // $data['data_obat'] = $this->Mmobat->get_obat_by_gudang($id_gudang)->result();
		    $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($receiving_id)->result();
        $data_company=$this->Frmmpemasok->get_company_name($receiving_id)->result();
        foreach($data_company as $row2){
          $data['supplier_nm'] = $row2->company_name;
        }
        $data_jenis=$this->Frmmpemasok->get_nm_jenis($receiving_id)->result();
      
        foreach($data_jenis as $row3){
          $data['jenis_nm'] = $row3->nm_jenis;
  
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

        $this->load->view('logistik_farmasi/Frmvdetailtransaksi',$data);
        /*echo "<pre>";
        echo print_r($data);
        echo "</pre>";*/
    }


    function form_detail_transaksi($receiving_id=''){
      $data['title'] = 'Detail Transaksi';
      $login_data = $this->load->get_var("user_info");
      $data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
      // var_dump($data['roleid']);die();
      $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
      $data['data_obat']=$this->Mmobat->get_obat_by_gudang_for_penerimaan($id_gudang)->result();
      $data['data_satuan']=$this->Mmsatuan_obat->get_all_satuan_obat()->result();
      $data['produsen']=$this->Frmmtransaksi->master_produsen()->result();
      $data_detail_pembelian=$this->Frmmtransaksi->get_receivings_new2($receiving_id)->result();
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
              $data['status'] = $row->status;
              $data['status'] = $row->status;
              $data['no_do'] = $row->no_do;
              $data['do_faktur'] = $row->do_faktur;
              $data['verif'] = $row->verif;
              $data['diterima_barang'] = $row->diterima_barang;
              $data['nm_supplier'] = $row->pbf;
              $data['nm_produsen'] = $row->nm_produsen;
          }
      $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
      $data['company_name']=$this->Frmmpemasok->get_company_name($receiving_id)->row();
      $data['nm_jenis']=$this->Frmmpemasok->get_nm_jenis($receiving_id)->row();
      $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();

      $this->load->view('logistik_farmasi/Frmvdetailtransaksi',$data);
      /*echo "<pre>";
      echo print_r($data);
      echo "</pre>";*/
  }

    // function form_detail_transaksi_bhp($receiving_id=''){
    //   $data['satuan']=$this->Frmmtransaksi->get_satuan()->result();
    //     $data['title'] = 'Detail Transaksi';
    //     $data['data_obat']=$this->Mmobat->get_all_bhp()->result();
    //     $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($receiving_id)->result();
    //         foreach($data_detail_pembelian as $row)
    //             $data['receiving_time'] = $row->receiving_time;
    //             $data['payment_type'] = $row->payment_type;
    //             $data['id_receiving'] = $row->receiving_id;
    //             $data['total_price'] = $row->total_price;
    //             $data['supplier_id'] = $row->supplier_id;
    //             $data['no_faktur'] = $row->no_faktur;
    //             $data['jatuh_tempo'] = $row->jatuh_tempo;
    //             $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
    //         }
    //     $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
    //     $data['company_name']=$this->Frmmpemasok->get_company_name($receiving_id)->row();
    //     $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
    //     $this->load->view('logistik_farmasi/Frmvdetailtransaksi_bhp',$data);
    // }

  public function insert_pembelian__(){
     
      $data['receiving_id']=$this->input->post('receiving_id');
      $no_faktur=$this->input->post('no_faktur');
      $no_faktur2= str_replace("/", "-", $no_faktur);
      $data['item_id']=$this->input->post('idobat');
    //  var_dump($data['item_id']);
      $data_obat=$this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
      // $margin_harga=$this->input->post('margin')/100*$this->input->post('biaya_obat_hide');
  		foreach($data_obat as $row){
  			$data['description']=$row->nm_obat;
        $data['item_unit_price']=$this->input->post('biaya_obat');
        $data1['item_unit_price']= $row->hargabeli;
    //    print_r($data1['item_unit_price']);die();
  		}
      //$data['item_cost_price']=$this->input->post('vtot_x_hide');
      $data['item_cost_price']=$this->input->post('hargabeli_hide');
      $data['quantity_purchased']=$this->input->post('qty_hide');
      if($data['quantity_purchased'] == ''){
        $data['quantity_purchased'] = 0;
      }
      // $data['ppn_percent']=$this->input->post('ppn');
      // $data['margin_percent']=$this->input->post('margin');
      $data['ppn_percent']=10;
      $data['margin_percent']=25;
      $data['batch_no']=$this->input->post('batch_no');
      $data['expire_date']=$this->input->post('expire_date');
      $data['biaya_besar']=$this->input->post('biaya_besar');
      $data['discount_percent']=$this->input->post('dis');

       $this->Frmmtransaksi->insert_receiving_item($data);

      $data1['id_obat']=$this->input->post('idobat');
      $data1['qty']=$this->input->post('qty_hide');
      if($this->input->post('expire_date') != ''){
        $data1['expire_date']=$this->input->post('expire_date');
      }
      $data1['batch_no']=$this->input->post('batch_no');
      $data1['exp']=$this->input->post('expire_date');     
      $userid = $this->session->userid;
      $group = $this->Frmmpo->getIdGudang($userid);
      $data1['id_gudang']= $group->id_gudang;
      $id_gudang=1;
      // $id_gudang=$group->id_gudang;
      $exp= $this->input->post('expire_date');
      $id_obat = $this->input->post('idobat');
      $batch = $this->input->post('batch_no');
    //  $expired=$this->input->post('expire_date');
      $qty=$this->input->post('qty_hide');
      $harga_po= $this->input->post('vtot_x_hide');
      $margin= $this->input->post('margin');
      $harga_beli = $this->input->post('hargabeli_hide');//$harga_po/$qty;
      $harga_jual=$this->input->post('biaya_obat');
      $faktorsatuan=$this->input->post('faktor_satuan');

      // var_dump($id_obat);
      // var_dump($batch);
      // var_dump($id_gudang);
      // die();
      
      $query=$this->db->query("SELECT qty FROM gudang_inventory WHERE id_obat='$id_obat' AND batch_no= '$batch' AND id_gudang='$id_gudang'");
      
      
      $qty_last=$query->row()->qty;
      if ($qty_last == null) {
        //   var_dump($data1); die();
        $datag = array(
              'id_obat' => $id_obat,
              'id_gudang' =>  $id_gudang,
              'batch_no' => $batch,
              'expire_date' => $exp,
              'qty'       => $qty,
              'hargabeli' => $harga_beli,
              'hargajual' => $harga_jual
        );
        //  var_dump($datag);die();
        $this->Frmmtransaksi->insert_gudang_inventory($datag);
      }else{
        $qty_tot=$qty_last+$qty;

        $cek_inventori=$query->num_rows();
      
        // var_dump($this->input->post('receiving_id'));die();


        if($cek_inventori == 0){
          $this->Frmmtransaksi->insert_selesai_transaksi($data1);
        }else{         
          $this->Frmmtransaksi->insert_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty);
        }
        //  print_r($harga_jual);die();

        // $this->Frmmtransaksi->update_mobat($harga_po,$id_obat,$harga_beli,$faktorsatuan,$harga_jual,$margin);
        $this->Frmmtransaksi->update_total_price($this->input->post('receiving_id'));

        //print_r($data);
        // }   
      }

      // if($this->input->post('jenis')!=''){ 
      //   redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$data['receiving_id']);
      // }else
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$data['receiving_id']);

      
   
  }

  

  public function get_data_header_pembelian(){
		$id_rec=$this->input->post('id_rec');
		$datajson=$this->Frmmtransaksi->get_data_receiving($id_rec)->result();
	    echo json_encode($datajson);
	}

  public function update_header_pembelian(){
    $id_rec = $this->input->post('edit_id_rec_hidden');
		$data['no_faktur'] = $this->input->post('edit_no_faktur');
    $data['no_do'] = $this->input->post('edit_no_do');

    $this->Frmmtransaksi->update_header_pembelian($id_rec,$data);
		// redirect('master/Mcobat');
    
		
    // var_dump($this->input->post());die();

	}


  public function insert_pembelian(){
    $data['receiving_id']=$this->input->post('receiving_id');
    $no_faktur=$this->input->post('no_faktur');
    $no_faktur2= str_replace("/", "-", $no_faktur);
    $data['item_id']=$this->input->post('idobat');
    $data_obat=$this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
    foreach($data_obat as $row){
      $data['description']=$row->nm_obat;
      $data['item_unit_price']=$this->input->post('biaya_obat_hide');
    }
    $data['item_cost_price']=$this->input->post('vtot_x_hide');
    $data['quantity_purchased']=$this->input->post('qty_hide');
    $data['qtyb']=$this->input->post('qtyb');
    $data['ppn_percent']=$this->input->post('ppn');
    $data['margin_percent']=$this->input->post('margin');
    $data['expire_date']=$this->input->post('expire_date');
    $data['biaya_besar']=$this->input->post('biaya_besar');
    $data['batch_no']=$this->input->post('batch_no');
    $data['discount_percent']=$this->input->post('dis');
    $data['faktor_satuan']=$this->input->post('faktor_satuan');
    $data['harga_beli'] = $this->input->post('hargabeli_hide');
    $data['harga_jual']=$this->input->post('biaya_obat_hide');
    $data['harga_sblm_margin']=$this->input->post('biaya_obat_sblm_margin');
    $data['satuanb']=$this->input->post('satuanb');
    $data['biaya_kecil']=$this->input->post('biaya_kecil');
    $data['biaya_besar2']=$this->input->post('biaya_besar2');
    $data['biaya_total']=$this->input->post('biaya_total');
    $data['prinsipal']=$this->input->post('prinsipal');
    $this->Frmmtransaksi->insert_receiving_item($data);
    

    if($this->input->post('jenis')!=''){
   
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$data['receiving_id']);
    }else
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$data['receiving_id']);


  }



  public function insert_stock_pembelian($id,$id_obat,$id_rec){
    // var_dump($id_rec);die();
     $data_obat=$this->Frmmtransaksi->get_data_for_stock($id,$id_obat)->row();
     

    $data['receiving_id'] = $id_rec;
    $data1['id_obat']=$data_obat->item_id;
    $data1['qty']=$data_obat->quantity_purchased;
    $data1['expire_date']=$data_obat->expire_date;
    $data1['batch_no']=$data_obat->batch_no;
    $login_data = $this->load->get_var('user_info');
    $userid = $this->session->userid;
    $name_user = $login_data->name;
    // var_dump($name_user);
    //  die();
    $group = $this->Frmmpo->getIdGudang($userid);
    $data1['id_gudang']= $group->id_gudang;
    $id_gudang=$group->id_gudang;

    $exp=$data_obat->expire_date;
    $id_obat=$data_obat->item_id;
    $batch=$data_obat->batch_no;
    $qty=$data_obat->quantity_purchased;
    $harga_po= $data_obat->item_cost_price;
    $margin= $data_obat->margin_percent;
    $harga_beli = $data_obat->harga_beli;
    $data1['hargabeli']= $data_obat->harga_beli;
    $data1['hargajual']= $data_obat->harga_jual;
    $harga_jual= $data_obat->harga_jual;
    $faktorsatuan= $data_obat->faktor_satuan;
    $satuanb= $data_obat->satuanb;

    $query=$this->db->query("SELECT qty FROM gudang_inventory WHERE id_obat='$id_obat' AND batch_no='$batch' AND id_gudang='$id_gudang'");
    
    
    $cek_inventori=$query->num_rows();
    if($cek_inventori == 0){
       $this->Frmmtransaksi->insert_selesai_transaksi($data1,$no_faktur2);
    }else{
      $qty_last=$query->row()->qty;
      $qty_tot=$qty_last+$qty;
       $this->Frmmtransaksi->insert_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty);
    }

    $this->Frmmtransaksi->update_verif_stock($id,$id_obat,$name_user);

    // $this->Frmmtransaksi->update_mobat($harga_po,$id_obat,$harga_beli,$faktorsatuan,$harga_jual,$margin,$satuanb);

    $this->Frmmtransaksi->update_total_price($data['receiving_id']);

    if($this->input->post('jenis')!=''){
   
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$data['receiving_id']);
    }else
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$data['receiving_id']);


  }
     

    public function selesai_transaksi(){
      $data['item_id']=$this->input->post('idobat');
      $data_obat=$this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
      foreach($data_obat as $row){
        $data['description']=$row->nm_obat;
      }
      $data['quantity_purchased']=$this->input->post('qty');

      $this->Frmmtransaksi->insert_receiving_item($data);
      //$this->Frmmtransaksi->update_total_price($receiving_id);
      /*$data['receiving_time']=$this->input->post('receiving_time');
      $data['person_id']=$this->input->post('person_id');
      $data['no_faktur']=$this->input->post('no_faktur');
      $data['total']=$this->input->post('total');
      $data['payment_type']=$this->input->post('payment_type');*/
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$no_faktur);
      //print_r($data);
    }


    public function get_data_detail_pembelian(){
    $receiving_id=$this->input->post('receiving_id');
    $datajson=$this->Frmmtransaksi->get_data_receiving($receiving_id)->result();
      echo json_encode($datajson);
    }


    public function get_biaya_obat()
	  {
		 $id_obat=$this->input->post('idobat');
		 $biaya=$this->Frmmtransaksi->get_biaya($id_obat)->row();
    
		 echo json_encode($biaya);
    //  var_dump($biaya);die();
	  }

  public function hapus_data_receiving__($receiving_id='', $id_obat='', $no_faktur='',$id_receiving=''){
   
    $group = $this->Frmmpo->getIdGudang($this->session->userid);
    $item = $this->Frmmtransaksi->get_item($receiving_id)->row();
    $group = $this->Frmmpo->getIdGudang($this->session->userid);
    $query=$this->db->query("SELECT qty FROM gudang_inventory WHERE id_obat='$id_obat' AND batch_no='$item->batch_no' AND id_gudang='$group->id_gudang'");
    $id_obat = $item->item_id;
    $batch = $item->batch_no;
    $id_gudang = $group->id_gudang;
    $exp = '';//$id_obat;
    
    $qty_last=$query->row()->qty;
    $qty_tot=$qty_last-$item->quantity_purchased;
    $cek_inventori=$query->num_rows();
    $qty_kurang = $item->quantity_purchased;
    
    $this->Frmmtransaksi->hapus_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty_kurang);

    $id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);
    
    // if($tipe==''){
      //$id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);
       redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.  $id_receiving);
    // }else
    //     redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.  $no_faktur);

		//print_r($id);
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
    
    // $this->Frmmtransaksi->hapus_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty_kurang);

    $id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);
    
    // if($tipe==''){
      //$id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);
       redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.  $id_receiving);
    // }else
    //     redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.  $no_faktur);

		//print_r($id);
	}

  public function insert_verifikasi(){
    $no_faktur= $this->input->post('faktur_hidden');
    $receiving_id= $this->input->post('receiving_id_hidden');

    $login_data = $this->load->get_var("user_info");
    $group = $this->Frmmpo->getIdGudang($this->session->userid);
    $stock['id_gudang'] = $group->id_gudang;
    $stock['user'] = $login_data->name;
    $stock['total_price_awal']= $this->input->post('total_price_awal');
    $stock['total_price']= $this->input->post('total_price');
    $stock['pembulatan']= $this->input->post('pembulatan_hide');
    $stock['b_tambahan']= $this->input->post('b_tambahan_hide');
    if( $stock['pembulatan'] == ''){
      $stock['pembulatan']= 0;
    }else{
      $stock['pembulatan']= $this->input->post('pembulatan_hide');
    }

    if( $stock['b_tambahan'] == ''){
      $stock['b_tambahan']= 0;
    }else{
      $stock['b_tambahan']= $this->input->post('b_tambahan_hide');
    }

    $stock['receiving']=$this->Frmmtransaksi->getdata_receiving_item($receiving_id)->result();
    $stock['header_receiving']=$this->Frmmtransaksi->get_receivings($receiving_id)->row();
    $this->Frmmtransaksi->insert_stock_verifikasi($stock);
    
    redirect('logistik_farmasi/Frmcpembelian');
  }

  public function insert_verifikasi_penerima(){
    $receiving_id= $this->input->post('receiving_id_hidden');
    $login_data = $this->load->get_var("user_info");
    $stock['user_penerima'] = $login_data->name;
    $stock['header_receiving']=$this->Frmmtransaksi->get_receivings($receiving_id)->row();
    $this->Frmmtransaksi->insert_stock_verifikasi_penerima($stock);
    
    redirect('logistik_farmasi/Frmcpembelian');
  }



  public function faktur_pembelian($no_faktur,$receiving_id)
  {
    // var_dump($this->input->post());die();
    $data['title'] = 'Cetak Faktur Farmasi';
    $no_faktur= $no_faktur;
    $receiving_id= $receiving_id;
    if($no_faktur!=''){
      $data_detail_pembelian=$this->Frmmtransaksi->get_receivings_new2($receiving_id)->result();
    //  var_dump( $data_detail_pembelian);die();
            foreach($data_detail_pembelian as $row){
                $data['receiving_time'] = $row->receiving_time;
                $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->nm_produsen;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
                $data['diterima_barang'] = $row->diterima_barang;
                $data['pbf'] = $row->pbf;

            }
      $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
      $data['company_name']=$this->Frmmpemasok->get_company_name($receiving_id)->row();
      $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
      // var_dump($data['data_receiving_item']);die();
      $data['data_permintaan']=$this->Frmmtransaksi->get_all_data_receiving()->result();
      $data['receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();

     ///input stock
    
    
     /////
          
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

  /**
   * Added @aldi
   * Pembuatan pencarian data by range
   */

  public function get_data_po_range()
  {
    $date = $this->input->post('tglawal');
    $dateakhir = $this->input->post('tglakhir');

    $line  = array();
    $line2 = array();
    $row2  = array();

    $i=1;
    $hasil = $this->Frmmtransaksi->get_all_data_receiving_date_range($date,$dateakhir)->result();
    foreach ($hasil as $value) {

        $row2['no'] = $i++;
        $row2['no_faktur'] = $value->no_faktur;
        $row2['no_do'] = $value->no_do;
        $row2['tgl_kontra_bon'] = date('d-m-Y',strtotime($value->tgl_kontra_bon));
        $row2['jatuh_tempo'] = $value->jatuh_tempo;
        $row2['company_name'] = $value->pbf;
        // $row2['produsen_name'] = $value->nm_produsen;
        $row2['jenis_penerimaan'] = $value->status;
        $row2['verif_penerima'] = isset($value->tgl_verif_penerima)?date('d-m-Y h:i:s',strtotime($value->tgl_verif_penerima)).' '.'('.$value->user_penerima.')':'';
        $row2['verif_gudang'] = isset($value->tgl_verif_gudang)?date('d-m-Y h:i:s',strtotime($value->tgl_verif_gudang)).' '.'('.$value->user_gudang.')':'';
       
        $row2['aksi'] = " <a class=\"btn btn-warning btn-xs\" href=\"".base_url('logistik_farmasi/frmcpembelian/form_detail_transaksi/'.$value->receiving_id)."\">Detail Pembelian</a>";

        $line2[] = $row2;
    }

    $line['data'] = $line2;

    echo json_encode($line);
  }

  /**End added */

  public function get_data_po(){
        $date = $this->input->post('tgl');
        if($date == ''){
            $date = date('Y-m-d');
        }
        $line  = array();
        $line2 = array();
        $row2  = array();

        $i=1;
        $hasil = $this->Frmmtransaksi->get_all_data_receiving_date($date)->result();
        foreach ($hasil as $value) {

            $row2['no'] = $i++;
            $row2['no_faktur'] = $value->no_faktur;
            $row2['no_do'] = $value->no_do;
            $row2['tgl_kontra_bon'] = date('d-m-Y',strtotime($value->tgl_kontra_bon));
            $row2['jatuh_tempo'] = $value->jatuh_tempo;
            $row2['company_name'] = $value->pbf;
            $row2['jenis_penerimaan'] = $value->status;
            $row2['verif_penerima'] = isset($value->tgl_verif_penerima)?date('d-m-Y h:i:s',strtotime($value->tgl_verif_penerima)).' '.'('.$value->user_penerima.')':'';
            $row2['verif_gudang'] = isset($value->tgl_verif_gudang)?date('d-m-Y h:i:s',strtotime($value->tgl_verif_gudang)).' '.'('.$value->user_gudang.')':'';
           
            $row2['aksi'] = " <a class=\"btn btn-warning btn-xs\" href=\"".base_url('logistik_farmasi/frmcpembelian/form_detail_transaksi/'.$value->receiving_id)."\">Detail Pembelian</a>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

  public function cetak_faktur(){
    // error_reporting(~E_ALL);
    $no_faktur = $this->input->post('faktur_hidden');
    $b_tambahan = $this->input->post('b_tambahan_hide');
    $id = $this->input->post('id_hidden');
    $condition['receiving_id']=$id;
    $data['pembulatan']=$this->input->post('pembulatan_hide');
    $data['b_tambahan']=$b_tambahan;
    
    if($this->input->post('b_tambahan_hide') == ''){
      $data['b_tambahan'] = 0;
    }

    if($this->input->post('totakhir_hide') == ''){
      $data['total_price']=$this->input->post('jumlah_vtot');      
    }else{
      $data['total_price']=$this->input->post('totakhir_hide'); 
    }
    
    // var_dump($data['total_price']);
    // die();
    $this->Frmmtransaksi->update_receiving($condition, $data);
    //echo '<script type="text/javascript">window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/$no_faktur").'", "_blank");window.focus()</script>';

    // echo '<script type="text/javascript">document.cookie = "diskon='.$b_tambahan.'";window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/$id").'", "_blank");window.focus()</script>';

    redirect('logistik_farmasi/Frmcpembelian/cetak_faktur_kt/'.$id.'/'.$b_tambahan);
  }

  public function cetak_faktur_kt_copy($id='',$disc=''){
		error_reporting(~E_ALL);
    $diskon = $disc;
    // $diskon = $_COOKIE['diskon'];

    date_default_timezone_set("Asia/Bangkok");
    $tgl_jam = date("d-m-Y H:i:s");
    $tgl = date("d-m-Y");

    $namars=$this->config->item('namars');
    $kota_kab=$this->config->item('kota');
    $telp=$this->config->item('telp');
    $alamatrs=$this->config->item('alamat');
    $nmsingkat=$this->config->item('namasingkat');
   
    $data_detail_pembelian=$this->Frmmtransaksi->get_receivings_new($id)->result();
    foreach($data_detail_pembelian as $row){
        $data['receiving_time'] = $row->receiving_time;
        $data['payment_type'] = $row->payment_type;
        $payment_type=$data['payment_type'] ;
        $data['id_receiving'] = $row->receiving_id;
        $id_receiving=$data['id_receiving'] ;
        $data['total_price'] = $row->total_price;
        $data['supplier_id'] = $row->supplier_id;
        $supplier_id=$data['supplier_id'];
        $data['no_faktur'] = $row->no_faktur;
        $no_faktur=$data['no_faktur'] ;
        $data['tgl_kontra_bon']=$row->tgl_kontra_bon;
        $data['jatuh_tempo'] = $row->jatuh_tempo;
        $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
        $b_tambahan=$row->b_tambahan ;
    }
     $data['company_name']=$this->Frmmpemasok->get_company_name_new($id)->row();
     $company_name=$this->Frmmpemasok->get_company_name_byidsupplier($supplier_id)->row()->company_name;

    // print_r($data_detail_pembelian);
    $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
    $cterbilang=new rjcterbilang();
    $konten=
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
                  
                  <td  width=\"70%\" style=\" font-size:7px;\">
                  <b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
                  </td>
                  <td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>           
                </tr>
              </table>
              <hr/>
    					<p align=\"center\"><b>
    					FAKTUR PEMBELIAN OBAT<br/>
    					No. FRM. RCV_".$id_receiving."
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
                  <td>".$company_name."</td> 
                  <td width=\"15%\"> </td>
    						</tr>
                <tr>
                  <td><b>Kontra Bon</b></td>
                  <td> : </td>
                  <td>".$row->tgl_kontra_bon."</td>
                  <td width=\"15%\"> </td>
                  <td width=\"15%\"><b>Jatuh Tempo</b></td>
                  <td width=\"3%\"> : </td>
                  <td>".$row->jatuh_tempo."</td>
                </tr>
    					</table>
    					<br/><br/>
    					<table>
    						<tr><hr>
    							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
    							<th width=\"25%\"><p align=\"center\"><b>Nama Item</b></p></th>
    							<th width=\"20%\"><p align=\"center\"><b>Harga Beli</b></p></th>
    							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
                  <th width=\"10%\"><p align=\"center\"><b>PPN</b></p></th>
                  <th width=\"10%\"><p align=\"center\"><b>Diskon</b></p></th>
    							<th width=\"20%\"><p align=\"right\"><b>Total</b></p></th>
    						</tr>
    						<hr>
    					";

		$i=1;
		$jumlah_vtot=0;
  //  var_dump($data['data_receiving_item']);die();
		foreach($data['data_receiving_item'] as $row){
			$jumlah_vtot= $jumlah_vtot + $row->item_cost_price;
      $vtot = number_format( $row->item_cost_price, 2 , ',' , '.' );
     // $harga_beli=$jumlah_vtot/$row->quantity_purchased;
      $harga_beli = number_format( $row->item_cost_price, 2 , ',' , '.' );
      $vtot_terbilang=$cterbilang->terbilang(number_format($jumlah_vtot,0,'',''));
			$konten=$konten."<tr>
							  <td><p align=\"center\">$i</p></td>
							  <td>$row->description</td>
							  <td><p align=\"center\">".number_format( $harga_beli, 2 , ',' , '.' )."</p></td>
							  <td><p align=\"center\">$row->quantity_purchased</p></td>
                <td><p align=\"center\">$row->ppn_percent %</p></td>
                <td><p align=\"center\">$row->discount_percent%</p></td>
							  <td><p align=\"right\">$vtot</P></td>
							  <br>
							</tr>";
			$i++;
		}	
    $konten=$konten."
        <tr><hr><br>
          <th colspan=\"6\"><p align=\"right\"><font size=\"9\">Jumlah   </font></p></th>
          <th><p align=\"right\"><font size=\"9\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</font></p></th>
        </tr>      
      ";

    $totakhir=$jumlah_vtot+$b_tambahan;
    // print_r($b_tambahan);die();
    if($b_tambahan!=0){
      $vtot_terbilang=$cterbilang->terbilang($totakhir);
      $konten=$konten."
            <tr>
              <th colspan=\"6\"><p align=\"right\"><font size=\"9\">Biaya Tambahan   </font></p></th>
              <th ><p align=\"right\"><font size=\"9\">".number_format( $b_tambahan, 2 , ',' , '.' )."</font></p></th>
            </tr>

            <tr><hr><br>
              <th colspan=\"6\"><p align=\"right\"><font size=\"9\">Total Bayar   </font></p></th>
              <th ><p align=\"right\"><font size=\"9\">".number_format( $totakhir, 2 , ',' , '.' )."</font></p></th>
            </tr>";
      $jumlah_vtot=$jumlah_vtot;    
    }
    $konten=$konten."
            <b><font size=\"10\"><p align=\"right\">Terbilang : " .$vtot_terbilang."</p></font></b>
                    <br><br>
                    <p align=\"right\">$kota_kab, $tgl</p>
      </table>
      ";

                  
    $file_name="FT_$id_receiving.pdf";
    //echo '<script type="text/javascript">window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/").'", "_blank");window.focus()</script>';
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('A', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
    redirect('logistik_farmasi/Frmcpembelian/index', 'refresh');
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

  public function cetak_faktur_kt($id='',$disc=''){
		error_reporting(~E_ALL);
    $data['diskon'] = $disc;
    // $diskon = $_COOKIE['diskon'];

    date_default_timezone_set("Asia/Bangkok");
    $data['tgl_jam'] = date("d-m-Y H:i:s");
    $data['tgl'] = date("d-m-Y");

    $namars=$this->config->item('namars');
    $data['kota_kab']=$this->config->item('kota');
    $telp=$this->config->item('telp');
    $alamatrs=$this->config->item('alamat');
    $nmsingkat=$this->config->item('namasingkat');
   
    $data_detail_pembelian=$this->Frmmtransaksi->get_receivings_new($id)->result();
    foreach($data_detail_pembelian as $row){
        $data['receiving_time'] = $row->receiving_time;
        $data['payment_type'] = $row->payment_type;
        $payment_type=$data['payment_type'] ;
        $data['id_receiving'] = $row->receiving_id;
        $id_receiving=$data['id_receiving'] ;
        $data['total_price'] = $row->total_price;
        $data['supplier_id'] = $row->supplier_id;
        $supplier_id=$data['supplier_id'];
        $data['no_faktur'] = $row->no_faktur;
        $no_faktur=$data['no_faktur'] ;
        $data['tgl_kontra_bon']=$row->tgl_kontra_bon;
        $data['jatuh_tempo'] = $row->jatuh_tempo;
        $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
        $data['b_tambahan']=$row->b_tambahan ;
    }
     $data['company_name']=$this->Frmmpemasok->get_company_name_new($id)->row();
     $data['company_name_new']=$this->Frmmpemasok->get_company_name_byidsupplier($supplier_id)->row()->company_name;

    // print_r($data_detail_pembelian);
    $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
    $data['cterbilang']=new rjcterbilang();
    
  
    $this->load->view('cetak/faktur_penerimaan_obat',$data);
  } 
}
?>