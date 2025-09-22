<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmkartu_stock extends CI_Model{
    function __construct(){
    parent::__construct();
  }

	function get_gudang($id_gudang){
    return $this->db->query("SELECT * FROM master_gudang where id_gudang = '$id_gudang' ")->result();
  }

   
  function autocomplete_obat($q){
          $query=$this->db->query("SELECT o.`id_obat`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, o.`satuank`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`harga_po`
                                FROM master_obat o, gudang_inventory g
                                WHERE o.id_obat = g.id_obat and o.`nm_obat` LIKE '%".$q."%' LIMIT 20");
          if($query->num_rows() > 0){
              foreach ($query->result() as $row){
                  $new_row['label']=htmlentities(stripslashes($row->nm_obat." (".$row->batch_no.",".$row->expire_date.",Stock:".$row->qty.")"));
                  $new_row['value']=htmlentities(stripslashes($row->nm_obat));
                  $new_row['idobat'] = htmlentities(stripslashes($row->id_obat));
                  $new_row['batch_no'] = htmlentities(stripslashes($row->batch_no));
                  $row_set[] = $new_row; //build an array
              }
              echo json_encode($row_set); //format the array into json data
          } else {
              echo json_encode([]);
          }
  }

  function get_data_stock($awal, $akhir,$id_gudang){
      	return $this->db->query("SELECT SUBSTR(a.created_date,1,10) as tanggal, a.created_date as waktu, case when keterangan = 'Transaksi Penjualan' then (select no_resgister from resep_header where no_resep = a.no_transaksi)   else  a.no_transaksi end as no_register, 
          case when keterangan in ('Transaksi Penjualan','Adjusment_Kurang','Distribusi') then a.penjualan+a.adjustment+a.distribusi else 0 end as keluar, 
          case when keterangan in ('Pembelian Obat','Adjusment_Tambah','Hapus Pembelian') then a.pembelian+a.adjustment+a.retur_pembelian else 0 end as masuk,
          b.nm_obat, a.keterangan, a.stok_awal, a.pembelian , a.retur_pembelian, a.distribusi, a.amprah, a.penjualan, a.stok_akhir, a.batch_no,a.created_by, a.adjustment FROM history_obat a JOIN master_obat b ON a.id_obat=b.id_obat WHERE left(a.created_date,10) >= '".$awal."' AND left(a.created_date,10) <= '".$akhir."' and a.gudang1= ".$id_gudang."");
  }

  // function get_data_stock($param1, $param2, $filter, $obat){
  //       return $this->db->query("SELECT SUBSTR(a.created_date,1,10) as tanggal, a.created_date as waktu, b.nm_obat, a.keterangan, a.stok_awal, a.pembelian , a.retur_pembelian, a.distribusi, a.amprah, a.penjualan, a.stok_akhir, a.batch_no FROM history_obat a JOIN master_obat b ON a.id_obat=b.id_obat WHERE a.id_obat='".$obat."' AND SUBSTR(a.created_date,1,10) >= '".$param1."' AND SUBSTR(a.created_date,1,10) <= '".$param2."'");
  // }

  // function get_data_stock($param1, $param2, $filter, $obat, $batch){
  //       return $this->db->query("SELECT SUBSTR(a.created_date,1,10) as tanggal, a.created_date as waktu, b.nm_obat, a.keterangan, a.stok_awal, a.pembelian , a.retur_pembelian, a.distribusi, a.amprah, a.penjualan, a.stok_akhir, a.batch_no, c.nama_gudang FROM history_oba a JOIN master_obat b ON a.id_obat=b.id_obat JOIN master_gudang c ON a.gudang1=c.id_gudang WHERE a.id_obat='".$obat."' AND SUBSTR(a.created_date,1,10) >= '".$param1."' AND SUBSTR(a.created_date,1,10) <= '".$param2."' AND a.gudang1='".$filter."' AND a.batch_no='".$batch."'
  //     UNION
  //     SELECT SUBSTR(a.tanggal,1,10) as tanggal, a.tanggal as waktu, b.nm_obat, a.keterangan, a.stok_awal, a.stok_in as pembelian, 0 as retur_pembelian, stok_out as distribusi, 0 as amprah, 0 as penjualan, a.stok_akhir, a.batch_no, c.nama_gudang FROM history_stok a JOIN master_obat b ON a.id_obat=b.id_obat JOIN master_gudang c ON a.tujuan=c.id_gudang WHERE a.id_obat='".$obat."' AND SUBSTR(a.tanggal,1,10) >= '".$param1."' AND SUBSTR(a.tanggal,1,10) <= '".$param2."' AND a.tujuan='".$filter."' AND a.batch_no='".$batch."'
  //     ORDER BY waktu ASC");
  // }
}

?>