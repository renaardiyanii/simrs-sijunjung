<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmstok_optik extends CI_Model{
    function __construct(){
    parent::__construct();
  }



   function get_all($id_obat) {
    $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY nm_obat");
    return $query->result();
    }

   function get($id_obat) {
    $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
    return $query->row();
   }
  
   function get_all_data_receiving(){
      return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_optik_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings_optik as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
   }
       
   function get_receivings($no_faktur) {
     $query = $this->db->get_where('receivings_optik', array('no_faktur'=>$no_faktur));
     return $query;
    }

    function getdata_inventory(){
      return $this->db->query("SELECT * , (SELECT nm_item FROM master_optik WHERE id_item=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang
        FROM inventory_optik as a order by nm_obat");
    }

    function getdata_gudang_inventory_by_role($role){
      return $this->db->query("SELECT g.*, o.`nm_item`, o.`hargabeli`, o.`kel` AS jenis_barang, 'Gudang Optik' as nama_gudang, 'none' as min_stock
                          FROM inventory_optik g
                          INNER JOIN master_optik o ON o.`id_item` = g.`id_obat`
                          INNER JOIN master_gudang gd ON gd.`id_gudang` = g.`id_gudang`
                          WHERE g.id_gudang = '$role' 
                          ORDER BY o.`nm_item`");
    }

    function get_data_obat($idobat, $idinventory){
        return $this->db->query("SELECT * FROM inventory_optik WHERE id_inventory = ".$idinventory." AND id_obat = ".$idobat);
    }

    function get_roleid($userid){
      return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
    }

    function get_gudangid($userid){
      return $this->db->query("Select id_gudang from dyn_gudang_user where userid = '".$userid."'");
    }

    function getitem_obat($id_obat){
			return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
		}

    function getnama_gudang($id_gudang){
      return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
    }

    function get_data_gudang(){
      return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
    }

    function get_data_gudang_detail($nm_gudang){
      return $this->db->query("SELECT g.*, o.nm_item, o.`hargabeli`, o.`hargajual`, o.kel as jenis_obat, 'nama_gudang' as nama_gudang
                        FROM inventory_optik g
                        INNER JOIN master_optik o ON o.`id_item` = g.`id_obat`
                        INNER JOIN master_gudang gd ON gd.`id_gudang` =g.`id_gudang`
                        ORDER BY g.`batch_no`");
    }

    function data_gudang($batch_no){
      return $this->db->query("SELECT a.nm_obat, b.batch_no , b.qty from master_obat as a, inventory_optik as b where a.id_obat = b.id_obat and b.batch_no ='$batch_no'");
    }

    function get_last_so_by_gudang_name($nama_gudang){
        $new_name = str_replace("-", "/", $nama_gudang);
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          INNER JOIN master_gudang mg ON mg.`id_gudang` = so.`id_gudang`
                          WHERE mg.`nama_gudang` = '$new_name'
                          ORDER BY so.`created_date`");
    }

    function get_last_so($id_gudang){
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          WHERE so.`id_gudang` = $id_gudang 
                          ORDER BY so.`created_date`");
    }

    function get_item_so($id_obat, $id_gudang){
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          inner join inventory_optik_so g on g.`id_obat` = so.`id_obat`
                          where g.`id_gudang` = $id_gudang AND o.`id_obat` = $id_obat
                          ORDER BY so.`created_date`");
    }

    function get_new_jenisobat(){
        return $this->db->query('SELECT*FROM obat_jenis_new ORDER BY nm_jenis ASC');
    }

    function insert_stokopname($data){
        $this->db->select('*')
                  ->where('id_obat', $data['id_obat'])
                  ->where('id_gudang', $data['id_gudang'])
                  ->where('batch_no', $data['batch_no']);
        $cek = $this->db->get('inventory_optik_so')->num_rows();

        if($cek > 0){
            $this->db->query("UPDATE inventory_optik_so SET qty = qty + $data[qty] 
              WHERE id_obat = '$data[id_obat]' AND id_gudang = '$data[id_gudang]' AND batch_no = '$data[batch_no]'");
        }else{
            $this->db->query("INSERT INTO inventory_optik_so (id_inventory, id_obat, id_gudang, qty, expire_date, batch_no, quantity_retur) 
          VALUES ('', '$data[id_obat]', '$data[id_gudang]', '$data[qty]', '$data[expire_date]', '$data[batch_no]', 0)");
        }

        $this->db->query("UPDATE master_obat SET jenis_obat = '$data[jenis_obat]', hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]' WHERE id_obat = '$data[id_obat]'");

        return $this->db->query("INSERT INTO stock_opname_new (id_obat, id_gudang, hargabeli, hargajual, batch_no, expire_date, qty, jenis_obat, created_date) 
          VALUES ('$data[id_obat]', '$data[id_gudang]', '$data[hargabeli]', '$data[hargajual]', '$data[batch_no]', '$data[expire_date]', '$data[qty]', '$data[jenis_obat]', '$data[created_date]') 
          ON DUPLICATE KEY UPDATE qty = qty + $data[qty], created_date = '$data[created_date]', hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]', jenis_obat = '$data[jenis_obat]'");
          /*$this->db->insert('stock_opname_new', $data);
      return true;*/
    }

    function edit_stokopname($data){
        $this->db->query("UPDATE inventory_optik_so 
          SET qty = '$data[qty]',
          expire_date = '$data[expire_date]' 
          WHERE id_obat = '$data[id_obat]' AND id_gudang = '$data[id_gudang]' AND batch_no = '$data[batch_no]'");

        $this->db->query("UPDATE master_obat 
          SET jenis_obat = '$data[jenis_obat]', 
          hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]' 
          WHERE id_obat = '$data[id_obat]'");

        return $this->db->query("UPDATE stock_opname_new
          SET qty = '$data[qty]', 
          created_date = '$data[created_date]', 
          hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]', 
          expire_date = '$data[expire_date]',
          jenis_obat = '$data[jenis_obat]'  

          WHERE id_obat = '$data[id_obat]' AND batch_no = '$data[batch_no]'");
    }

    function delete_stokopname($data){
        $this->db->delete('inventory_optik_so', $data); 
        return $this->db->delete('stock_opname_new', $data); 
    }

    public function importData($data) {
        $date = date('j_FY');
        /* Di Backup dulu ke Table baru */
        $this->db->query("CREATE TABLE inventory_optik_".$date." LIKE inventory_optik");
        $this->db->query("INSERT INTO inventory_optik_".$date." SELECT * FROM inventory_optik");

        $this->db->query("TRUNCATE TABLE inventory_optik");
        return $this->db->insert_batch('inventory_optik',$data);
    }
}

?>
