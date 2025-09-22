<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmstok extends CI_Model{
    function __construct(){
    parent::__construct();
  }



   function get_all($id_obat) {
    $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY nm_obat");
    return $query->result();
    }

    function update_hargajual($data,$id_inventory){
      $this->db->where('id_inventory',$id_inventory);
      $this->db->update('gudang_inventory', $data);
      return true;
    }

   function get($id_obat) {
    $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
    return $query->row();
   }
  
   function get_all_data_receiving(){
      return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
   }
       
   function get_receivings($no_faktur) {
     $query = $this->db->get_where('receivings', array('no_faktur'=>$no_faktur));
     return $query;
    }

    function getdata_gudang_inventory(){
      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang
        FROM gudang_inventory as a order by nm_obat");
    }

    function getdata_gudang_inventory_by_role($role){
      if($role == ''){
        // return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, o.min_stock 
        // FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        // LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        // WHERE o.nm_obat <>'' 
        // and o.deleted = '0'
        // and DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) >= 0
        // and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
        //       (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) >= 3         
        // ORDER BY o.nm_obat
        //                   ");

        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE 
          o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          -- and g.qty > 0
           and CURRENT_DATE <= g.expire_date::date       
          ORDER BY o.nm_obat
                          ");
      }else{
        // return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, o.min_stock 
        //   FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        //   LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        //   WHERE g.id_gudang = '$role'
        //   and o.nm_obat <>'' 
        //   and o.deleted = '0'
        //   and DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) >= 0
        //   and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
        //         (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) >= 3           
        //   ORDER BY o.nm_obat
        //                     ");

      return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
      o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
        FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
        LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
        WHERE g.id_gudang = '$role'
        and o.nm_obat <>'' 
        and o.deleted = '0'
        and g.deleted = '0'
        -- and g.qty > 0
         and ( CURRENT_DATE <= g.expire_date::date or g.expire_date is null)     
        ORDER BY o.nm_obat
                        ");
      }
      
    }

    function getdata_expire_gudang_inventory_by_role($role){
      if($role == ''){
        // return $this->db->query("SELECT g.*, o.nm_obat, o.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, o.min_stock 
        // FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        // INNER JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        // WHERE o.nm_obat <>''
        //   and o.deleted = '0'
        // and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) = 0
        // and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
        //               (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) < 3
        // or expire_date is null) 
        // ORDER BY o.nm_obat
        //                   ");

        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, o.min_stock 
        FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        INNER JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        WHERE o.nm_obat <>''
          and o.deleted = '0'
          AND G.expire_date::date <=  CURRENT_DATE
        or expire_date is null
        ORDER BY o.nm_obat
                          ");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, o.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, o.min_stock 
        FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
        INNER JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
        WHERE g.id_gudang = '$role'
        and o.nm_obat <>''
          and o.deleted = '0'
          AND G.expire_date::date <=  CURRENT_DATE
        or expire_date is null and o.id_obat >= 7000
        ORDER BY o.nm_obat
                          ");
      }
      
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
      return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, g.hargajual, o.jenis_obat, gd.nama_gudang
      FROM gudang_inventory g
      INNER JOIN master_obat o ON o.id_obat = g.id_obat
      INNER JOIN master_gudang gd ON gd.id_gudang =g.id_gudang
      WHERE g.id_gudang=(SELECT id_gudang FROM master_gudang WHERE id_gudang='$nm_gudang')
			  and o.nm_obat <>'' 
          and o.deleted = '0'
          and DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) >= 0
          and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
                (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) >= 3  
      ORDER BY g.batch_no
                        ");
    }

    function data_gudang($batch_no){
      return $this->db->query("SELECT a.nm_obat, b.batch_no , b.qty from master_obat as a, gudang_inventory as b where a.id_obat = b.id_obat and b.batch_no ='$batch_no'");
    }

    function get_last_so_by_gudang_name($nama_gudang){
        $new_name = str_replace("-", "/", $nama_gudang);
        return $this->db->query("SELECT so.*, o.nm_obat
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.id_obat = so.id_obat 
                          INNER JOIN master_gudang mg ON mg.id_gudang = so.id_gudang
                          WHERE mg.nama_gudang = '$new_name'
                          ORDER BY so.created_date");
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
                          inner join gudang_inventory_so g on g.`id_obat` = so.`id_obat`
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
        $cek = $this->db->get('gudang_inventory_so')->num_rows();

        if($cek > 0){
            $this->db->query("UPDATE gudang_inventory_so SET qty = qty + $data[qty] 
              WHERE id_obat = '$data[id_obat]' AND id_gudang = '$data[id_gudang]' AND batch_no = '$data[batch_no]'");
        }else{
            $this->db->query("INSERT INTO gudang_inventory_so (id_inventory, id_obat, id_gudang, qty, expire_date, batch_no, quantity_retur) 
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
        $this->db->query("UPDATE gudang_inventory_so 
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
        $this->db->delete('gudang_inventory_so', $data); 
        return $this->db->delete('stock_opname_new', $data); 
    }

    function get_detail_stok($idinventory){
        return $this->db->query("SELECT g.*, mo.nm_obat FROM gudang_inventory g
                        INNER JOIN master_obat mo ON g.id_obat = mo.id_obat
                        WHERE g. deleted = '0' and g.id_inventory = ".$idinventory);
    }

     function cek_detail_obat($idinventory){
        return $this->db->query("SELECT batch_no, id_gudang, id_obat FROM gudang_inventory
                        WHERE id_inventory = ".$idinventory);
    }

    function update_history($data2){
       $this->db->insert('history_obat', $data2);
    }

    function update_table($table, $data, $where){
        return $this->db->update($table, $data, $where);
    }

    function get_all_obat(){
       return $this->db->query("SELECT * FROM master_obat where deleted = '0' order by nm_obat asc ");
    }

    function add_obat_to_gudang($data2){
      return $this->db->insert('gudang_inventory', $data2);
    }

    function update_obat_to_gudang($data,$id_obat,$batch_no){
      $this->db->where('id_obat', $id_obat);			
      $this->db->where('batch_no', $batch_no);			
      return $this->db->update('pemeriksaan_elektromedik', $data);
    }

    function cek_obat_to_gudang($id_obat,$batch_no,$id_gudang){
       return $this->db->query("SELECT * FROM gudang_inventory where id_obat = '$id_obat' and batch_no = '$batch_no' and id_gudang = $id_gudang and deleted = 0 ");
    }

    function get_all_gudang(){
       return $this->db->query("SELECT * FROM master_gudang order by nama_gudang asc ");
    }

    function get_data_gudang_detail_expire($nm_gudang){
      return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, g.hargajual, o.jenis_obat, gd.nama_gudang
      FROM gudang_inventory g
      INNER JOIN master_obat o ON o.id_obat = g.id_obat
      INNER JOIN master_gudang gd ON gd.id_gudang =g.id_gudang
      WHERE g.id_gudang=(SELECT id_gudang FROM master_gudang WHERE id_gudang='$nm_gudang')
			and o.nm_obat <>''
          and o.deleted = '0'
        and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) = 0
        and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
                      (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) < 3
        or expire_date is null) 
      ORDER BY g.batch_no
                        ");
    }
    
    function get_data_batch($batch_no) {
      return $this->db->query("SELECT a.nm_obat, b.id_inventory, b.expire_date, b.batch_no FROM gudang_inventory AS b, master_obat AS a WHERE b.id_inventory = '$batch_no' AND b.deleted = '0' AND a.id_obat = b.id_obat");
    }

    function get_all_obat_by_kelompok($kel,$role){
      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and o.kelompok = '$kel'
          and g.deleted = '0'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");

      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and o.kelompok = '$kel'
          and g.deleted = '0'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");
      }
		
		}

    function get_all_obat_by_subkelompok($kel,$role){
      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.subkelompok = '$kel'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date         
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.subkelompok = '$kel'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date       
          ORDER BY o.nm_obat");
      }
		
		}

    function get_all_obat_by_jenis($jns,$role){
      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date        
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date     
          ORDER BY o.nm_obat");
      }
			
		}

    function get_all_obat_by_subkelompok_kel($kel,$pok,$role){

      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.subkelompok = '$kel' and o.kelompok = '$pok'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date       
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.subkelompok = '$kel' and o.kelompok = '$pok'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");
      }
			
		}

    function get_all_obat_by_jns_kel($jns,$kel,$role){

      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.kelompok = '$kel' 
        	AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.kelompok = '$kel' 
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");
      }
		
		}

    function get_all_obat_by_jns_sub($jns,$sub,$role){

      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.subkelompok = '$sub'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date       
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.subkelompok = '$sub'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date        
          ORDER BY o.nm_obat");
      }
			
		}

    function get_all_obat_by_jns_sub_kel($jns,$sub,$kel,$role){

      if($role == ''){
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE  o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.subkelompok = '$sub' and o.kelompok = '$kel'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date      
          ORDER BY o.nm_obat");
      }else{
        return $this->db->query("SELECT g.*, o.nm_obat, g.hargabeli, o.jenis_obat AS jenis_barang, gd.nama_gudang, 
        o.min_stock,o.jenis_obat,kel.nm_kelompok as kelompok,subkel.bentuk_sediaan as subkelompok
          FROM gudang_inventory g INNER JOIN master_obat o ON o.id_obat = g.id_obat 
          LEFT JOIN master_gudang gd ON gd.id_gudang = g.id_gudang 
          LEFT JOIN master_kelompok_obat kel ON o.kelompok = kel.kode 
          LEFT JOIN master_subkelompok_obat subkel ON o.subkelompok = subkel.kode 
          WHERE g.id_gudang = '$role'
          and o.nm_obat <>'' 
          and o.deleted = '0'
          and g.deleted = '0'
          and o.jenis_obat = '$jns' and o.subkelompok = '$sub' and o.kelompok = '$kel'
          AND to_char(CURRENT_DATE,'YYYY-MM-DD') <= G.expire_date        
          ORDER BY o.nm_obat");
      }
		
		}

    public function verif_stock_expire($id)
    {

        return $this->db->query("UPDATE gudang_inventory SET verif_expire = 1 
      where id_inventory = '$id'
        ");
 
  
    }
}

?>
