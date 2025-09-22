<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmtransaksi extends CI_Model{
    function __construct(){
    parent::__construct();
  }

  function cari_obat(){
    return $this->db->query("SELECT id_obat, nm_obat FROM master_obat ORDER BY id_obat");
  }

  function get_obat(){
    return $this->db->query("SELECT id_obat, nm_obat, hargabeli, hargajual FROM master_obat ORDER BY id_obat");
  }

  function get_satuan(){
    return $this->db->query("SELECT * FROM obat_satuan");
  }

  function get_data_obat($id_obat){
    return $this->db->query("SELECT * FROM master_obat WHERE id_obat='$id_obat'");
  }

  function insert_supplier($data){
    $this->db->insert('master_obat', $data);
    return true;
  }

  function get_all($id_obat) {
    $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY id_obat");
    return $query->result();
  }

  function get($id_obat) {
    $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
    return $query->row();
  }
  function insert_detail($data){
    $this->db->insert('receivings',$data);
     return  $this->db->insert_id();
  }

  function get_all_data_receiving(){
     return $this->db->query("SELECT * , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
  }

  function get_all_data_receiving_date($date){
     return $this->db->query("SELECT
     * ,
            ( SELECT SUM ( quantity_purchased ) FROM receivings_items WHERE receiving_id = A.receiving_id GROUP BY receiving_id ) 
            AS total ,
            (select nm_produsen from master_produsen where a.produsen_id = master_produsen.id),
               (select pbf from master_pbf where a.supplier_id = master_pbf.id)
         FROM
            receivings AS A
         WHERE
            to_char(receiving_time ::date ,'YYYY-MM-DD') ='$date'
         ORDER BY
            A.receiving_id DESC");
         }

  /**
   * Added @aldi 
   * Pembuatan Range Picker
   */
  function get_all_data_receiving_date_range($date,$dateakhir){
      return $this->db->query("SELECT * ,
      ( SELECT SUM ( quantity_purchased ) FROM receivings_items WHERE receiving_id = A.receiving_id GROUP BY receiving_id ) AS total,
      ( SELECT nm_produsen FROM master_produsen WHERE A.produsen_id = master_produsen.ID ),
      ( SELECT pbf FROM master_pbf WHERE A.supplier_id = master_pbf.ID ) 
      FROM
         receivings AS A 
      WHERE
      to_char(receiving_time ::date ,'YYYY-MM-DD') BETWEEN '$date' AND '$dateakhir'
      ORDER BY
         A.receiving_id DESC");
   }
  /**End added */

  function get_all_data_cancel_receiving_date($date,$gud){
    //  print_r($jenis);die();
      if ($gud == 1 ) {
        $where = "AND a.jenis_barang  = 'UMUM'";
       }else if ($gud == 2) { 
         $where = "AND a.jenis_barang  = 'BPJS'";
       } else {
         $where = '';
       }
      //  print_r($where);die();
     return $this->db->query("SELECT * , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id and tgl_kontra_bon='$date' $where
        ORDER BY a.receiving_id");
  }

  //  function get_all_data_cancel_receiving($date,$gud){
  //    if ($gud == 1 ) {
  //       $where = "AND a.jenis_barang  = 'UMUM'";
  //      }else if ($gud == 2) { 
  //        $where = "AND a.jenis_barang  = 'BPJS'";
  //      } else {
  //        $where = '';
  //      }
  //    return $this->db->query("SELECT * , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
  //       receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id and tgl_kontra_bon = '$date' $where ORDER BY a.receiving_id");
  // }

  function get_all_data_receiving_bhp(){
     return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        and b.type='BHP'
        ORDER BY a.receiving_id");
  }

  function get_data_receiving($receiving_id){
     return $this->db->query("SELECT * FROM receivings WHERE receiving_id='$receiving_id'");
  }

  function get_receivings($receiving_id) {
     $query = $this->db->get_where('receivings', array('receiving_id'=>$receiving_id));
    // $query = $this->db->query("SELECT *, b.discount_percent as dis FROM receivings a JOIN receivings_items b ON a.receiving_id=b.receiving_id WHERE no_faktur='$no_faktur'");
     return $query;
  }

  function get_receivings_new($id) {
     $query = $this->db->get_where('receivings', array('receiving_id'=>$id));
     return $query;
  }
       
  function update_total_price($receiving_id) {
   return $this->db->query("UPDATE receivings as a SET total_price=(select sum(item_cost_price) as total_price from receivings_items where receiving_id=a.receiving_id) WHERE receiving_id='$receiving_id'");
}

  function get_receiving_id($person_id,$no_faktur,$comment,$payment_type){
     return $this->db->query("SELECT receiving_id FROM receivings WHERE person_id='$person_id' AND no_faktur='$no_faktur' AND comment='$comment' AND payment_type='$payment_type'  ORDER BY receiving_id DESC LIMIT 1");
  }

  function get_biaya($id_obat){
	   return $this->db->query("SELECT satuan FROM gudang_inventory WHERE id_obat='".$id_obat."'");
	}

  function getdata_receiving_item($id_receiving){
     return $this->db->query("SELECT * FROM receivings_items WHERE receiving_id='$id_receiving'");
  }

  function getdata_gudang_inventory($id_receiving){
     return $this->db->query("SELECT * FROM gudang_inventory WHERE receiving_id='$id_receiving'");
  }

  function getitem_obat($id_obat){
		 return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
	}

  function getnama_gudang($id_gudang){
     return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
  }

  function cari_gudang(){
     return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
  }

  function insert_receiving_item($data){
		 $this->db->insert('receivings_items', $data);
		 return true;
	}

  function cek_inventori($id_obat, $batch, $id_gudang){
    $this->db->query("SELECT * FROM gudang_inventory WHERE id_obat='$id_obat' AND batch_no='$batch' AND id_gudang='$id_gudang'");
     return true;
  }

  function get_data_for_stock($id, $id_obat){
   return $this->db->query("SELECT * FROM receivings_items where id_receivings_item = $id and item_id = $id_obat");
    
 }

  // function insert_selesai_transaksi($data1){
  //    $this->db->insert('gudang_inventory', $data1);
  //    return true;
  // }

     function check_stock_awal($id_obat){
    //Start Histori Stock
    //  print_r($id_obat);die();
    $query = $this->db->query("SELECT * FROM gudang_inventory
      WHERE id_obat = '".$id_obat."'");
    if($query->num_rows() > 0){
      return $query->row()->qty;
    }else{
      return 0;
    }
  }

   function insert_selesai_transaksi__copy($data1,$no_faktur2){
   
    $this->db->insert('gudang_inventory', $data1);
  
    //Input History Stok
    $stok = $this->check_stock_awal($data1['id_gudang'], $data1['id_obat'], $data1['batch_no']);
    $stok_akhir = $stok + $data1['qty'];
        $this->db->query("INSERT INTO history_stok (no_transaksi, id_obat, batch_no, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
          VALUES ('".$no_faktur2."', '".$data1['id_obat']."', '".$data1['batch_no']."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$data1['id_gudang']."', '".$stok."', '".$data1['qty']."', '".$stok_akhir."')");
     return true;
  }

  function insert_selesai_transaksi($data1,$no_faktur2){
   
   $this->db->insert('gudang_inventory', $data1);
 
   //Input History Stok
   $stok = $this->check_stock_awal($data1['id_gudang'], $data1['id_obat'], $data1['batch_no']);
   $stok_akhir = $stok + $data1['qty'];

   $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, pembelian, stok_akhir)
   VALUES ('".$no_faktur2."', '".$data1['id_obat']."', '".$data1['batch_no']."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$data1['id_gudang']."', '".$stok."', '".$data1['qty']."', '".$stok_akhir."')");
return true;

   //     $this->db->query("INSERT INTO history_stok (no_transaksi, id_obat, batch_no, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
   //       VALUES ('".$no_faktur2."', '".$data1['id_obat']."', '".$data1['batch_no']."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$data1['id_gudang']."', '".$stok."', '".$data1['qty']."', '".$stok_akhir."')");
   //  return true;
 }


 function insert_selesai_transaksi2__($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty){
    
    $stok = $this->check_stock_awal($id_obat);

  //  print_r($stok);die();
 //   print_r($stok);die();
    
    $this->db->query("UPDATE gudang_inventory SET expire_date = '$exp', qty = '$qty_tot' WHERE id_obat = '$id_obat' AND batch_no = '$batch' AND id_gudang='$id_gudang'");
     //Input History Stok
        $stok_akhir = $stok + $qty;
        if($qty == ''){
           $qty = 0;
        }
        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, pembelian, stok_akhir)
          VALUES ('".$no_faktur2."', '".$id_obat."', '".$batch."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$id_gudang."', '".$stok."', '".$qty."', '".$stok_akhir."')");
     return true;
  }



  function insert_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty){
    
   $stok = $this->check_stock_awal($id_obat);

 //  print_r($stok);die();
//   print_r($stok);die();
   
   $this->db->query("UPDATE gudang_inventory SET expire_date = '$exp', qty = '$qty_tot' WHERE id_obat = '$id_obat' AND batch_no = '$batch' AND id_gudang='$id_gudang'");
    //Input History Stok
       $stok_akhir = $stok + $qty;
       $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, pembelian, stok_akhir)
         VALUES ('".$no_faktur2."', '".$id_obat."', '".$batch."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$id_gudang."', '".$stok."', '".$qty."', '".$stok_akhir."')");
    return true;
 }



   function hapus_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp,$no_faktur2,$qty_kurang){
    $stok = $this->check_stock_awal($id_obat);
   //  $this->db->query("UPDATE gudang_inventory SET expire_date = '$exp', qty = '$qty_tot' WHERE id_obat = '$id_obat' AND batch_no = '$batch' AND id_gudang='$id_gudang'");
    $this->db->query("UPDATE gudang_inventory SET qty = '$qty_tot' WHERE id_obat = '$id_obat' AND batch_no = '$batch' AND id_gudang='$id_gudang'");
     //Input History Stok
        $stok_akhir = $stok - $qty_kurang;
        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, retur_pembelian, stok_akhir)
          VALUES ('".$no_faktur2."', '".$id_obat."', '".$batch."', '".date('Y-m-d H:i:s')."', 'Hapus Pembelian', '".$id_gudang."', '".$stok."', '".$qty_kurang."', '".$stok_akhir."')");
     return true;
  }


  // function insert_selesai_transaksi2($id_obat,$batch,$id_gudang,$qty_tot,$exp){
  //    $this->db->query("UPDATE gudang_inventory SET expire_date = '$exp', qty = '$qty_tot' WHERE id_obat = '$id_obat' AND batch_no = '$batch' AND id_gudang='$id_gudang'");
  //     $this->db->query("INSERT INTO history_sto (no_transaksi, id_obat, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
  //         VALUES ('".$no_faktur2."', '".$id_obat."','".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$id_gudang"', '".$stok."', '".$qty."', '".$stok_akhir."')");
  //    return true;
  // }

  function update_mobat__($harga_po,$id_obat,$hargabeli, $faktorsatuan, $harga_jual,$margin,$batch_no){
     $this->db->query("UPDATE master_obat SET hargabeli=".$hargabeli.", hargajual=".$harga_jual.",  harga_po = ".$harga_po.", faktorsatuan=".$faktorsatuan." WHERE id_obat = ".$id_obat."");
    // $this->db->query("UPDATE gudang_inventory SET hargabeli=".$hargabeli.", hargajual=".$harga_jual.", faktorsatuan=".$faktorsatuan." WHERE id_obat = ".$id_obat." and batch_no = '".$batch_no."'");
     return true;
     
  }

  function update_mobat($harga_po,$id_obat,$hargabeli, $faktorsatuan, $harga_jual,$margin,$satuanb){
   $this->db->query("UPDATE master_obat SET hargabeli=".$hargabeli.", margin =  ".$margin.", harga_po = ".$harga_po.", faktorsatuan='".$faktorsatuan."',hargajual='".$harga_jual."',satuanb='".$satuanb."' WHERE id_obat = ".$id_obat."");
   return true;
}

function update_verif_stock($id,$id_obat,$name){
   $this->db->query("UPDATE receivings_items SET verif = 1, verifikator='$name' WHERE id_receivings_item = $id and item_id = $id_obat");
   return true;
}

  function get_total_harga($receiving_id){
     return $this->db->query("SELECT SUM(total_harga_obat) as total FROM `receivings_items` WHERE receiving_id='$receiving_id' ");
  }

  function update_retur($batch_no){
     return $this->db->query("UPDATE gudang_inventory SET qty='$qty' WHERE batch_no='$batch_no'");
  }

  function hapus_data_receiving($receiving_id,$id_obat){ 
     return $this->db->query("DELETE FROM receivings_items WHERE id_receivings_item='$receiving_id' AND item_id='$id_obat'");
  }

  function update_receiving($condition, $data)
  {
    $this->db->update('receivings', $data, $condition);
  }

  function cancel_pembelian($receiving_id){
      $this->db->query("DELETE FROM receivings_items WHERE receiving_id='$receiving_id'");
      return $this->db->query("DELETE FROM receivings WHERE receiving_id='$receiving_id'");
   }

   function update_gudang($id_obat,$qty_tot){
      $this->db->query("UPDATE gudang_inventory SET qty = '$qty_tot' WHERE id_obat = '$id_obat'");
      return true;
   }

   public function get_item($id_receiving)
   {
      return $this->db->query("SELECT * FROM receivings_items WHERE id_receivings_item='$id_receiving'");
   }

   function insert_gudang_inventory($datag){
		$this->db->insert('gudang_inventory',$datag);
   }   

   function update_header_pembelian($id_rec,$data){
      $this->db->where('receiving_id', $id_rec);
      return $this->db->update('receivings', $data);
      
   }

   
   public function insert_stock_verifikasi($data)
   {
      // var_dump($data);die();

      // update verif in table receiving
      $this->db->query("UPDATE receivings set verif = 1,pembulatan = '".$data['pembulatan']."',
      b_tambahan = '".$data['b_tambahan']."',total_price_awal = '".$data['total_price_awal']."',
      total_price='".$data['total_price']."',user_gudang='".$data['user']."',tgl_verif_gudang = now()
       where receiving_id = '".$data['header_receiving']->receiving_id."' ");

      //cek stock gudang
      foreach ($data['receiving'] as $row) {
         $cek_gd1 = $this->check_stock_gd_asal($data['id_gudang'],$row->batch_no,$row->item_id);
      
         if($cek_gd1->num_rows()){
            $stock = $cek_gd1->row()->jml;
            $stock_akhir = $stock + $row->quantity_purchased;

            $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date,
            created_by, keterangan, gudang1, 
            stok_awal, pembelian, stok_akhir,status_penerimaan,hargabeli,expire_date,pbf)
            VALUES ('".$data['header_receiving']->no_faktur."', '".$row->item_id."', '".$row->batch_no."', '".date('Y-m-d H:i:s')."','".$data['user']."', 
            'Penerimaan Obat', '".$data['id_gudang']."', $stock , 
            '".$row->quantity_purchased."', $stock_akhir,
            '".$data['header_receiving']->status."','".$row->harga_beli."','".$row->expire_date."','".$data['header_receiving']->supplier_id."')");

            $this->db->query("UPDATE gudang_inventory SET qty = $stock + $row->quantity_purchased , ket = '".$data['header_receiving']->status."'
           where id_gudang = '".$data['id_gudang']."' and batch_no = '".$row->batch_no."' and id_obat = $row->item_id
            ");

           

         }else{
            $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date,created_by, keterangan, gudang1, stok_awal, 
            pembelian, stok_akhir,status_penerimaan,hargabeli,expire_date,pbf)
            VALUES ('".$data['header_receiving']->no_faktur."', '".$row->item_id."', '".$row->batch_no."', '".date('Y-m-d H:i:s')."','".$data['user']."', 
            'Penerimaan Obat', '".$data['id_gudang']."', 0, '".$row->quantity_purchased."', 
            '".$row->quantity_purchased."','".$data['header_receiving']->status."','".$row->harga_beli."','".$row->expire_date."','".$data['header_receiving']->supplier_id."')");

            $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date, hargajual, hargabeli, ket)
					VALUES(
							'".$data['id_gudang']."',
							'".$row->item_id."',
							'".$row->batch_no."',
							'".$row->quantity_purchased."',
							'".$row->expire_date."',
                     '".$row->harga_jual."',
                     '".$row->harga_beli."',
                     '".$data['header_receiving']->status."'
						)");

                 
         }

         

      }
      
      
   }

   public function insert_stock_verifikasi_penerima($data)
   {
      // var_dump($data['user_penerima']);die();

      // update verif in table receiving
      $this->db->query("UPDATE receivings set verif_penerima = 1,user_penerima = '".$data['user_penerima']."',
      tgl_verif_penerima = now()
       where receiving_id = '".$data['header_receiving']->receiving_id."'");
      
   }

   function check_stock_gd_asal($id_gd,$batch,$id_obat){
		$query=$this->db->query("
      SELECT qty as jml
      from gudang_inventory 
      where id_gudang = '$id_gd' and batch_no = '$batch' and id_obat = $id_obat"); 
		
		return $query;
	
	}

   function master_pbf(){
      return $this->db->query("SELECT * FROM master_pbf ORDER BY id");
   }

   function master_produsen(){
      return $this->db->query("SELECT * FROM master_produsen ORDER BY id");
   }

   function get_receivings_new2($receiving_id) {
      return $this->db->query("select *,(select nm_produsen from master_produsen where receivings.produsen_id = master_produsen.id ),
      (select pbf from master_pbf where receivings.supplier_id = master_pbf.id ) from receivings where receiving_id = $receiving_id");
   }



}
?>
