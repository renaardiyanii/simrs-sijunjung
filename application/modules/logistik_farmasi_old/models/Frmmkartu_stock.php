<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmkartu_stock extends CI_Model{
    function __construct(){
    parent::__construct();
  }

	function get_gudang($id_gudang){
    return $this->db->query("SELECT * FROM master_gudang where id_gudang = '$id_gudang' ")->result();
  }

  function get_obat_all()
  {
    return $this->db->query("SELECT * FROM master_obat where deleted = '0' ");
  }

  function get_obat_by_gudang_for_view($id_gudang){
    return $this->db->query("SELECT o.id_obat, o.nm_obat,o.satuank,o.satuanb,o.faktorsatuan,o.hargabeli,o.hargajual,
    o.kel,o.jenis_obat,o.hapus,o.obatalkes,o.min_stock,o.harga_po,o.barcode,o.margin,o.hargabeli_new,o.deleted,
    g.qty, g.expire_date,g.batch_no,g.quantity_retur,g.id_inventory,o.golongan_obat
    FROM master_obat o
    LEFT JOIN gudang_inventory g ON g.id_obat = o.id_obat
    WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' ");
  }


  function get_obat_by_gudang_for_view_stock($id_gudang){
    return $this->db->query("	SELECT distinct o.nm_obat,o.id_obat from master_obat  o inner join gudang_inventory g  ON g.id_obat = o.id_obat
    WHERE g.id_gudang = '$id_gudang' and o.deleted = '0' and o.id_obat >= 7000 and g.deleted = '0'order by o.id_obat desc ");
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

  function get_data_stock($awal, $akhir,$id_gudang,$id_obat){
      // var_dump($awal);
      // var_dump($akhir);
      // var_dump($id_gudang);
      // die();
      	return $this->db->query("SELECT
        to_char( A.created_date,'YYYY-MM-DD') AS tanggal,
        A.created_date AS waktu,
      CASE
          WHEN keterangan IN ( 'Transaksi Penjualan', 'Adjusment_Kurang', 'Distribusi','Produksi Kurang','Pengurangan Distribusi Langsung') THEN
          coalesce(A.penjualan,0) +coalesce(A.adjustment,0) + coalesce(A.distribusi,0) + coalesce(A.produksi,0) + coalesce(A.distribusi,0) ELSE 0 
        END AS keluar,
      CASE
      WHEN keterangan IN ( 'Pembelian Obat', 'Adjusment_Tambah', 'Hapus Pembelian' , 'Produksi Tambah' , 'Penambahan Distribusi Langsung') THEN
          coalesce(A.pembelian,0) + coalesce(A.adjustment,0) + coalesce(A.retur_pembelian,0)+ coalesce(A.produksi,0) + coalesce(A.distribusi,0) ELSE 0 
        END AS masuk,
        b.nm_obat,
        c.pbf,
        A.keterangan,
        A.stok_awal,
        A.pembelian,
        A.retur_pembelian,
        A.distribusi,
        A.amprah,
        A.penjualan,
        A.stok_akhir,
        A.batch_no,
        A.produksi,
        A.created_by,
        A.adjustment,
        A.status_penerimaan,
        A.hargabeli ,
        A.expire_date
    
      FROM
        history_obat
        A JOIN master_obat b ON A.id_obat = b.id_obat  
        JOIN master_pbf c on A.pbf = cast(c.id as text)
        WHERE to_char(a.created_date,'YYYY-MM-DD') >= '".$awal."' 
        AND to_char(a.created_date,'YYYY-MM-DD') <= '".$akhir."' 
        and a.gudang1= ".$id_gudang." and a.id_obat = $id_obat");
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