<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frmmamprah extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        // var_dump($data);die();
        // return $data['user'];die();
        if ($this->db->query("insert into header_amprah(tgl_amprah, gd_asal, gd_dituju, \"user\")
							values(
									'" . date('Y-m-d') . "',
									'" . $data["gd_asal"] . "',
									'" . $data["gd_dituju"] . "',
									'" . $data["user"] . "'
								)")
        ) {
            $json = json_decode($data["dataobat"], true);
            $id_amprah = $this->db->insert_id();
           

            // $dataobat = array();
            // $arr = array("id_amprah" => $id_amprah, "id_gudang" => $data["gd_asal"], "id_gudang_tujuan" => $data["gd_dituju"], "user" => $data["user"]);
            // foreach ($json as &$value) {
            //     array_push($dataobat, array_merge($value, $arr));
            // }
            
            // $this->db->insert_batch('distribusi', $dataobat);


            $count = 0;
            $dataobat= array();
            $arr = array("id_amprah" => $id_amprah);
            foreach ($json as &$value) {
                array_push($dataobat, array_merge($value, $arr));
                $count++;
            }

            $this->db->query("UPDATE header_amprah SET jmlh_amprah = ".$count." WHERE id_amprah = '". $id_amprah."'");

            foreach($dataobat as $value){
             

              $this->db->insert('amprah', $value);
              // var_dump($value);

          }

           
            return $id_amprah;
        }
        return false;
    }

    function insert_langsung($data)
    {
        if ($this->db->query("insert into amprah(tgl_amprah, gd_asal, gd_dituju, user)
							values(
									'" . $data["tgl_amprah"] . "',
									'" . $data["gd_asal"] . "',
									'" . $data["gd_dituju"] . "',
									'" . $data["user"] . "'
								)")
        ) {
            $json = json_decode($data["dataobat"], true);
            $id_amprah = $this->db->insert_id();
            //echo $id_amprah."<br><br>";

            $dataobat = array();
            $arr = array("id_amprah" => $id_amprah, "id_gudang" => $data["gd_asal"], "id_gudang_tujuan" => $data["gd_dituju"], "user" => $data["user"]);
            foreach ($json as &$value) {
                array_push($dataobat, array_merge($value, $arr));
            }

            $this->db->insert_batch('distribusi', $dataobat);
            return $id_amprah;
        }
        return false;
    }

 
    function get_obat_jenis()
    {
        return $this->db->query("SELECT * FROM obat_jenis");
    }

    function get_gudang_tujuan()
    {
        return $this->db->query("SELECT * FROM master_gudang");
    }


    function get_gudang_asal()
    {
        $userid = $this->session->userdata('userid');
        return $this->db->query("SELECT * FROM dyn_gudang_user WHERE userid = $userid ORDER BY id_gudang");
    }

    function get($id_obat)
    {
        $query = $this->db->get_where('gudang_inventory', array('id_obat' => $id_obat));
        return $query->row();
    }

    function get_for_dis($id_obat,$batch_no,$id_gudang)
    {
      return $this->db->query("SELECT o.id_obat, o.nm_obat, g.qty, g.batch_no, g.satuan , g.expire_date
      FROM master_obat o
      INNER JOIN gudang_inventory g ON g.id_obat = o.id_obat
      WHERE o.id_obat = '$id_obat' and g.batch_no = '$batch_no' and g.id_gudang = $id_gudang")->result();
    }

    function get_username($userid){
        return $this->db->query("SELECT * FROM hmis_users WHERE userid = ".$userid)->row();
    }

    function getdata_amprah_by_role($id_gudang,$data, $url=null)
    {
        // var_dump($id_gudang['id_gudang']);die();
        $userid = $this->session->userdata('userid');
        $login = $this->get_username($userid)->username;
        $where = "";

        if ($url=="Frmcamprah") {
            $where .= "AND a.user= '".$login."'";   
        }

        if ($data["id_amprah"] != "") {
            $where .= " AND a.id_amprah = " . $data["id_amprah"];
        } else {
            if (($data["tgl0"] != "") && ($data["tgl1"] == "")) {
                $where .= " AND a.tgl_amprah = '" . $data["tgl0"] . "'";
            }
            if (($data["tgl0"] != "") && ($data["tgl1"] != "")) {
                $where .= " AND a.tgl_amprah BETWEEN ('" . $data["tgl0"] . "') AND ('" . $data["tgl1"] . "')";
            }
            if ($data["gd_asal"] != "") {
                $where .= " AND a.gd_asal = '" . $data["gd_asal"] . "'";
            }
            if ($data["gd_dituju"] != "") {
                $where .= " AND a.gd_dituju = '" . $data["gd_dituju"] . "'";
            }
        }
        // return $this->db->query("
            
        //     SELECT a.id_amprah, a.tgl_amprah, a.gd_asal, a.gd_dituju, a.user, a.no_faktur, d.nama_gudang, m.nama_gudang as nama_gudang_dituju, a.status FROM amprah a LEFT JOIN master_gudang d ON CAST(a.gd_asal AS INTEGER) = d.id_gudang LEFT JOIN master_gudang m ON CAST(a.gd_dituju AS INTEGER) = m.id_gudang LEFT JOIN (SELECT id_amprah, count(qty_req) - count(qty_acc) as open FROM distribusi GROUP BY id_amprah) s ON a.id_amprah = s.id_amprah WHERE a.jenis_amprah!='BHP' $where ORDER BY id_amprah ASC
        //     ")->result();
           
            return $this->db->query("
            
            SELECT a.id_amprah, a.tgl_amprah, a.gd_asal, a.gd_dituju, a.user,a.status,a.verif,d.nama_gudang as gudang_asal,m.nama_gudang as gudang_peminta from header_amprah a
      LEFT JOIN master_gudang d ON CAST(a.gd_asal AS INTEGER) = d.id_gudang LEFT JOIN master_gudang m ON CAST(a.gd_dituju AS INTEGER) = m.id_gudang 
      WHERE a.id_amprah > 0
      $where and gd_dituju = '" . $id_gudang['id_gudang'] . "'
      ORDER BY a.tgl_amprah DESC
            ")->result();
    }

    function getdata_amprahbhp_by_role($data)
    {
        $userid = $this->session->userdata('userid');

        $where = "";
        if ($data["id_amprah"] != "") {
            $where .= " AND a.id_amprah = " . $data["id_amprah"];
        } else {
            if (($data["tgl0"] != "") && ($data["tgl1"] == "")) {
                $where .= " AND a.tgl_amprah = '" . $data["tgl0"] . "'";
            }
            if (($data["tgl0"] != "") && ($data["tgl1"] != "")) {
                $where .= " AND a.tgl_amprah BETWEEN ('" . $data["tgl0"] . "') AND ('" . $data["tgl1"] . "')";
            }
            if ($data["gd_asal"] != "") {
                $where .= " AND a.gd_asal = '" . $data["gd_asal"] . "'";
            }
            if ($data["gd_dituju"] != "") {
                $where .= " AND a.gd_dituju = '" . $data["gd_dituju"] . "'";
            }
        }
        return $this->db->query("SELECT a.id_amprah, a.tgl_amprah, a.gd_asal, a.gd_dituju, a.user, a.no_faktur, d.nama_gudang, m.nama_gudang as nama_gudang_dituju, s.open
			FROM amprah a
			LEFT JOIN dyn_gudang_user d ON a.gd_asal = d.id_gudang
			LEFT JOIN master_gudang m ON a.gd_dituju = m.id_gudang
			LEFT JOIN (SELECT id_amprah, count(qty_req) - count(qty_acc) as open
			FROM distribusi
			GROUP BY id_amprah) s ON a.id_amprah = s.id_amprah
			WHERE d.userid = $userid
			and a.jenis_amprah='BHP' 
			$where
			ORDER BY id_amprah ASC")->result();
    }

    function get_amprah_detail_list($id)
    {
      //   return $this->db->query("SELECT a.id, a.id_amprah, a.id_obat, b.nm_obat, a.satuank, a.qty_req, a.qty_acc, a.expire_date, a.batch_no, a.keterangan, a.id_gudang_tujuan, a.id_gudang, b.hargabeli, c.status
			// FROM distribusi a
			// LEFT JOIN master_obat b on a.id_obat = b.id_obat
      // LEFT JOIN amprah c on a.id_amprah = c.id_amprah
			// WHERE a.id_amprah = $id")->result();

      return $this->db->query("SELECT a.id, a.id_amprah, a.id_obat, a.nm_obat, a.satuank, a.qty_req
      FROM amprah a
      WHERE a.id_amprah = '$id'")->result();
    }
    function get_amprah_detail_acc($data){
        return $this->db->query("SELECT a.id, a.id_amprah, a.id_obat, a.id_gudang, a.id_gudang_tujuan, a.satuank, a.qty_req, a.qty_acc, a.expire_date, a.batch_no, a.keterangan, a.user, b.nm_obat
            FROM distribusi a JOIN master_obat b ON a.id_obat=b.id_obat
            WHERE a.id_amprah = '".$data."' AND a.qty_acc IS NOT NULL AND a.batch_no IS NOT NULL AND a.expire_date IS NOT NULL")->result();
    }
    function get_info($id)
    {
        // $query = $this->db->query("SELECT a.id_amprah, a.no_faktur, a.gd_dituju, a.gd_asal, a.tgl_amprah, m1.nama_gudang as nm_gd_asal, m2.nama_gudang as nm_gd_dituju, a.user
		// 	FROM amprah a
		// 	JOIN master_gudang m1 ON a.gd_asal = m1.id_gudang
		// 	JOIN master_gudang m2 ON a.gd_dituju = m2.id_gudang
		// 	WHERE a.id_amprah = " . $id);

        $query = $this->db->query(" SELECT a.id_amprah, a.no_faktur, a.gd_dituju, a.gd_asal, a.tgl_amprah, m1.nama_gudang as nm_gd_asal, m2.nama_gudang as nm_gd_dituju, a.user FROM amprah a JOIN master_gudang m1 ON CAST(a.gd_asal AS INTEGER) = m1.id_gudang JOIN master_gudang m2 ON CAST(a.gd_dituju AS INTEGER) = m2.id_gudang WHERE a.id_amprah =" . $id);

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //create object with empty properties.
            $obj = new stdClass;

            foreach ($query->list_fields() as $field) {
                $obj->$field = '';
            }

            return $obj;
        }
    }
    /*
      function get_all($id_obat) {
        $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY id_obat");
        return $query->result();
        }

        function get_roleid($userid){
          return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
        }

        function get_gudangid($userid){
          return $this->db->query("Select id_gudang from dyn_gudang_user where userid = '".$userid."'");
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
            FROM gudang_inventory as a order by batch_no");
        }
        function get_receiving_amprah($id_amprah) {
         $query = $this->db->get_where('amprah', array('id_amprah'=>$id_amprah));
         return $query;
      }

        function getitem_obat($id_obat){
                return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
            }

        function getnama_gudang($id_gudang){
          return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
        }


        function insert_amprah($data1){
          $this->db->insert('header_amprah', $data1);
          return true;
        }
         function update_retur($batch_no){
          return $this->db->query("UPDATE gudang_inventory SET qty='$qty' WHERE batch_no='$batch_no'");
        }

        function hapus_data_receiving($receiving_id,$id_obat){
          return $this->db->query("DELETE FROM receiving_item WHERE receiving_id='$receiving_id' AND id_obat='$id_obat'");
        }

        function data_gudang($id_inventory){
          return $this->db->query("SELECT b.id_inventory, b.id_gudang, a.nm_obat, a.id_obat, b.batch_no , b.qty, LEFT(b.expire_date,10) as expire_date from master_obat as a, gudang_inventory as b where a.id_obat = b.id_obat and b.id_inventory ='$id_inventory'");
        }

        function cari_gudang(){
         return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
        }

        function data_gudang1($id_amprah){
          return $this->db->query("SELECT b.id_amprah, b.id_gudang, a.nm_obat, a.id_obat, b.batch_no , b.qty from master_obat as a, amprah as b where a.id_obat = b.id_obat and b.id_amprah ='$id_amprah'");
        }

        function cek_obat_gudang($id_obat, $expire_date, $id_gudang){
          return $this->db->query("SELECT id_inventory FROM gudang_inventory WHERE id_obat='$id_obat' and LEFT(expire_date,10)='$expire_date' and id_gudang='$id_gudang'");
        }

         function getdata_receiving_amprah($id_amprah){
         return $this->db->query("SELECT * FROM distribusi WHERE id_amprah='$id_amprah'");
        }

        // function get_receivings($no_faktur) {
        //  $this->db->get_where('header_amprah', array('no_faktur'=>$no_faktur));
        //  return true;
        // }

       function getnm_obat($id_obat){
        return $this->db->query("SELECT nm_obat FROM master_obat where id_obat='$id_obat'");

       }

       function insert_receiving_amprah($data){
        $this->db->insert('amprah',$data);
         return  true;
       }

        function hapus_data_amprah($id_amprah,$id_obat){
         return $this->db->query("DELETE FROM amprah WHERE id_amprah='$id_amprah' AND id_obat='$id_obat'");
      }

         function get_id_amprah($data){
            $tgl_amprah=$data['tgl_amprah'];
            $user=$data['user'];
            $gd_asal=$data['gd_asal'];
            $gd_dituju=$data['gd_dituju'];
         return $this->db->query("SELECT id_amprah FROM header_amprah WHERE tgl_amprah='$tgl_amprah' and user='$user' and  gd_asal='$gd_asal' and gd_dituju='$gd_dituju'");
        }*/


          function check_stock_awal($id_gudang, $id_obat, $batch_no){
      //Start Histori Stock
      $query = $this->db->query("SELECT * FROM gudang_inventory 
        WHERE id_gudang = '".$id_gudang."' AND id_obat = '".$id_obat."' AND batch_no = '".$batch_no."'");
      if($query->num_rows() > 0){
        return $query->row()->qty;
      }else{
        return 0;
      }
    }

    function insert_history($id_obat,$qty,$gudang,$batch_no,$user){
      // $this->db->insert('gudang_inventory', $data1);
      //Input History Stok
      $stok = $this->check_stock_awal($gudang, $id_obat, $batch_no);
      if ($stok < $qty) {
        return false;
      }else{
        $stok_akhir = $stok - $qty;
        // $this->db->query("UPDATE gudang_inventory
        //                   SET qty = ".$stok_akhir."
        //                   WHERE id_obat = '".$id_obat."' AND id_gudang = '".$gudang."' AND batch_no = '".$batch_no."'");

        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
        VALUES ('0', '".$id_obat."', '".$batch_no."', '".date('Y-m-d H:i:s')."', 'Distribusi', '".$gudang."', '".$stok."', '".$qty."', '".$stok_akhir."', '".$user."')");
      return true;
      }
      
    }

    function insert_history_hapus($id_obat,$qty,$gudang,$batch_no,$user){
      // $this->db->insert('gudang_inventory', $data1);
      //Input History Stok
      $stok = $this->check_stock_awal($gudang, $id_obat, $batch_no);
      $stok_akhir = $stok + $qty;
          $this->db->query("UPDATE gudang_inventory
                            SET qty = ".$stok_akhir."
                            WHERE id_obat = '".$id_obat."' AND id_gudang = '".$gudang."' AND batch_no = '".$batch_no."'");

          $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
            VALUES ('0', '".$id_obat."', '".$batch_no."', '".date('Y-m-d H:i:s')."', 'Batal Distribusi', '".$gudang."', '".$stok."', '".$qty."', '".$stok_akhir."', '".$user."')");
       return true;
    }

    function check_stock_gd_asal($id_gudang, $id_obat, $batch_no){
      $query=$this->db->query("select qty as jml
      from gudang_inventory 
      where id_gudang = '$id_gudang' and id_obat = '$id_obat' and batch_no = '$batch_no'"); 
      
      return $query->row()->jml;
    
    }

    function insertdistribusiheader($data){
      if ($this->db->query("insert into header_distribusi(no_distribusi, gd_asal, gd_dituju, tgl_distribusi,pengguna)
      values(
         '" . $data["no_distribusi"] . "',
          '" . $data["gd_asal"] . "',
          '" . $data["gd_dituju"] . "',
          '" . $data["tgl_distribusi"] . "',
          '" . $data["user"] . "'
        )")
      );
      $id_dis = $this->db->insert_id();
      return $id_dis;
    // die();
   
    }

    function insert_detail_distribusi($data)
    {
      return $this->db->insert('distribusi_langsung',$data);
    } 

    function get_distribusi($id)
    {
        return $this->db->query("SELECT *,(select nama_gudang from master_gudang b where cast (a.gd_asal  as int)= b.id_gudang ) as nm_gd_asal,
        (select nama_gudang from master_gudang b where cast (a.gd_dituju  as int)= b.id_gudang ) as nm_gd_tujuan 
        FROM header_distribusi a where id_distribusi = $id ");
    }

    function get_item_distribusi($id)
    {
        return $this->db->query("SELECT *,(select nm_obat from master_obat a where a.id_obat = b.id_obat ) from distribusi_langsung b where id_distribusi = $id ");
    }

    function delete_item_distribusi($id)
    {
        return $this->db->query("DELETE FROM distribusi_langsung
        WHERE id = $id ");
    }

    function update_verif_header_dis($id)
    {
        return $this->db->query("update header_distribusi set verif = 1 where id_distribusi = $id");
    }

    function get_data_distribusi_all($date,$id_gudang)
    {
        return $this->db->query("SELECT *,(select nama_gudang from master_gudang b where cast (a.gd_asal  as int)= b.id_gudang ) as nm_gd_asal,
        (select nama_gudang from master_gudang b where cast (a.gd_dituju  as int)= b.id_gudang ) as nm_gd_tujuan  from header_distribusi a where tgl_distribusi = '$date'
        and gd_asal = '$id_gudang' and verif != 1");
    }

    
    function insert_stock_verif($data)
    {
      // var_dump($data['header']);die();
      foreach ($data['item_distribusi'] as $row) {

      // pengurangan stock gudang asal 
      $cek_gd1 = $this->check_stock_gd_asal($data['header']->gd_asal,$row->id_obat,$row->batch_no);
      $stock = $cek_gd1;
      $stock_akhir = $stock - $row->qty;

        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, distribusi, stok_akhir)
        VALUES ('".$data['header']->no_distribusi."', '".$row->id_obat."', '".$row->batch_no."', '".date('Y-m-d H:i:s')."', 
        'Pengurangan Distribusi Langsung', '".$data['header']->gd_asal."', $stock , '".$row->qty."', $stock_akhir)");

        $this->db->query("UPDATE gudang_inventory SET qty = $stock - $row->qty
       where id_gudang = '".$data['header']->gd_asal."' and batch_no = '".$row->batch_no."' and id_obat = $row->id_obat
        ");

      // penambahan stock gudang tujuan
      $cek_gd2 = $this->check_stock_gd_asal2($data['header']->gd_dituju,$row->id_obat,$row->batch_no);

      if($cek_gd2->num_rows()){
        $jml = $cek_gd2->row()->jml;
        $jml_akhir = $jml + $row->qty;

        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, distribusi, stok_akhir)
          VALUES ('".$data['header']->no_distribusi."', '".$row->id_obat."', '".$row->batch_no."', '".date('Y-m-d H:i:s')."', 
         'Penambahan Distribusi Langsung', '".$data['header']->gd_dituju."', $jml , '".$row->qty."', $jml_akhir)");

            $this->db->query("UPDATE gudang_inventory SET qty = $jml + $row->qty 
           where id_gudang = '".$data['header']->gd_dituju."' and batch_no = '".$row->batch_no."' and id_obat = $row->id_obat
            ");

      }else{
        $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, distribusi, stok_akhir)
          VALUES ('".$data['header']->no_distribusi."', '".$row->id_obat."', '".$row->batch_no."', '".date('Y-m-d H:i:s')."', 
         'Penambahan Distribusi Langsung', '".$data['header']->gd_dituju."', $row->qty , '".$row->qty."', $row->qty)");

         $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
         VALUES(
             '".$data['header']->gd_dituju."',
             '".$row->id_obat."',
             '".$row->batch_no."',
             '".$row->qty."',
             '".$row->expire_date."'
           )");
      }
     

      }
  }

  function check_stock_gd_asal2($id_gd,$id_obat,$batch){
		$query=$this->db->query("
      SELECT qty as jml
      from gudang_inventory 
      where id_gudang = '$id_gd' and batch_no = '$batch' and id_obat = $id_obat"); 
		
		return $query;
	
	}

    function insertDistribusiLangsung($data){
         
        {

            $json = json_decode($data["dataobat"], true);
            $id_distribusi = $this->db->insert_id();


            $dataobat = array();
           
            $arr = array("id_distribusi" =>  $id_distribusi, "id_gudang" => $data["gd_asal"], "id_gudang_tujuan" => $data["gd_dituju"], "user" => $data["user"], "ket" => 'Langsung',"id_jenis" => $data["id_jenis"]);
            foreach ($json as &$value) {
                $id_batch  = explode('-',$value['id_obat_new']);
               
                $id_obat =  array("id_obat" =>  $id_batch[0]);
              
                array_push($dataobat, array_merge($value, $arr, $id_obat));
            }
            // var_dump($dataobat);die();
            $this->db->insert_batch('distribusi_langsung', $dataobat);
            // die();


            //Langsung Update Stok
            foreach ($dataobat as $item) {
           
             
               //cek stock,no batch gudang yang meminta amprah
              $cek_gd1 = $this->check_stock_gd_asal($data["gd_dituju"], $item['id_obat'], $item['batch_no']);
              
              if($cek_gd1){
                $stock_asal_gd1 = $cek_gd1;
                $stock_akhir_gd1 = $stock_asal_gd1 + $item["qty_req"];
              }else{
                $stock_asal_gd1 = 0;
                $stock_akhir_gd1 = 0 + $item["qty_req"];
              }

                  //input ke history obat di gudang yang minta amprah
                  $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
                  keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
                        VALUES ('0', '".$item["id_obat"]."', '".$item["batch_no"]."', '".date('Y-m-d H:i:s')."', 
                  'Distribusi', '".$data["gd_dituju"]."', '".$stock_asal_gd1."', '".$item["qty_req"]."', '".$stock_akhir_gd1."', '".$this->session->userdata('username')."')");



				
                //cek stock, no batch gudang yg mendistribusi
                $stock_asal_gd2 = $this->check_stock_gd_asal($data["gd_asal"], $item["id_obat"], $item["batch_no"]);
                $stock_akhir_gd2 = $stock_asal_gd2 -$item["qty_req"];
                //input history obat gudang distribusi
                $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
                keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
                      VALUES ('0', '".$item["id_obat"]."', '".$item["batch_no"]."', '".date('Y-m-d H:i:s')."', 
                'Distribusi', '".$data["gd_asal"]."', '".$stock_asal_gd2."', '".$item["qty_req"]."', '".$stock_akhir_gd2."', '".$this->session->userdata('username')."')");
                // die();

                //Cek apakah stok digudang yg dituju sudah ada Barangnya/ Belum
                $cek = $this->db->query("SELECT*FROM gudang_inventory WHERE id_obat = '".$item['id_obat']."' AND id_gudang = '".$data["gd_dituju"]."' AND batch_no = '".$item['batch_no']."'")->num_rows();

                //Insert/ Update Stok di Gudang yang dituju
                if($cek > 0){
                    $this->db->query("UPDATE gudang_inventory
                            SET qty = qty + ".$item['qty_req']."
                            WHERE id_obat = '".$item['id_obat']."' AND id_gudang = '".$data["gd_dituju"]."'  AND batch_no = '".$item['batch_no']."'");
                }else{
                    $this->db->query("INSERT INTO gudang_inventory (id_obat, id_gudang, qty, expire_date, batch_no, quantity_retur)
                        VALUES ('".$item['id_obat']."', '".$data["gd_dituju"]."', '".$item['qty_req']."', '".$item['expire_date']."', '".$item['batch_no']."', 0)");
                }

                //Update Stok Gudang Pengirim
                $this->db->query("UPDATE gudang_inventory
                            SET qty = qty - ".$item['qty_req']."
                            WHERE id_obat = '".$item['id_obat']."' AND id_gudang = '" . $data["gd_asal"] . "' AND batch_no = '".$item['batch_no']."'");


       
            }
            
        }
        return false;
    }

    function get_gudang_besar()
    {
        return $this->db->query("SELECT * FROM master_gudang where id_gudang = '1' ");
    }

		function get_obat_pilih_all_search($text){

			return $this->db->select('a.id_obat,
			b.nm_obat,
			b.hargabeli,
			b.hargajual,
			a.batch_no,
			a.expire_date,
			a.qty,
			b.jenis_obat,
			a.id_inventory,
      d.nama_gudang')
					->from('gudang_inventory a')
					->join('master_obat b', 'b.id_obat = a.id_obat', 'inner')
					->join('master_gudang d', 'd.id_gudang = a.id_gudang', 'inner')
					->where('b.id_obat = a.id_obat')
					->where('d.id_gudang = a.id_gudang')
					->where('b.id_obat',$text)
					->get();  				
		}

    function autocomplete_obat($q){   
			$query=$this->db->query("SELECT * FROM master_obat WHERE upper(nm_obat) LIKE upper('%$q%')  limit 10"
			);
	        if($query->num_rows() > 0){
	          foreach ($query->result_array() as $row){
	            $new_row['label']=htmlentities(stripslashes($row['id_obat'].' - '.$row['nm_obat']));
	            $new_row['value']=htmlentities(stripslashes($row['id_obat'].' - '.$row['nm_obat']));
	            $new_row['id_obat']=htmlentities(stripslashes($row['id_obat']));
	            $new_row['nm_obat']=htmlentities(stripslashes($row['nm_obat']));	            
	            $row_set[] = $new_row; //build an array
	          }
	          echo json_encode($row_set); //format the array into json data
	        } else {        
	            echo json_encode([]);
	        }
	  }

    function get_obat_done_distribusi($id){

      return $this->db->query("SELECT * from distribusi where id_amprah = '$id'
      ");

    }

    function insert_verifiksi_total($data_obat){
      //  var_dump($data_obat);die();
          //cek stock,no batch gudang yang meminta amprah

          foreach ($data_obat as $data) {
            if($data["expire_date"]==''){
              $expire_date='NULL';
            }else{
              $expire_date=$data["expire_date"];
            }
          $cek_gd1 = $this->check_stock_gd_asal_old($data["id_gudang"], $data["id_obat"], $data["batch_no"]);
          $stock_asal_gd1 = 0;
          $stock_akhir_gd1 = 0;				
          if($cek_gd1->num_rows()){
            if($cek_gd1->row()->jml){
              $stock_asal_gd1 = intval($cek_gd1->row()->jml);
              $stock_akhir_gd1 = $stock_asal_gd1 + $data["qty_acc"];
            }else{
              $stock_akhir_gd1 = 0 + $data["qty_acc"];
            }
          }

          //input ke history obat di gudang yang minta amprah
          $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
          keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
                VALUES ('0', '".$data["id_obat"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 
          'Distribusi', '".$data["id_gudang"]."', '".$stock_asal_gd1."', '".$data["qty_acc"]."', '".$stock_akhir_gd1."', '".$this->session->userdata('username')."')");




          //cek stock, no batch gudang yg mendistribusi
          $stock_asal_gd2 = $this->check_stock_gd_asal_old($data["id_gudang_tujuan"], $data["id_obat"], $data["batch_no"])->row()->jml;

          $stock_akhir_gd2 = $stock_asal_gd2 - $data["qty_acc"];
          //input history obat gudang distribusi
          $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
          keterangan, gudang1, stok_awal, distribusi, stok_akhir, created_by)
                VALUES ('0', '".$data["id_obat"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 
          'Distribusi', '".$data["id_gudang_tujuan"]."', '".$stock_asal_gd2."', '".$data["qty_acc"]."', '".$stock_akhir_gd2."', '".$this->session->userdata('username')."')");
          // die();



          //update stock di gudang (untuk gudang yg mendistribusi)
          $this->db->query("UPDATE gudang_inventory SET qty = qty - '".$data["qty_acc"]."' 
          WHERE id_gudang = '".$data["id_gudang_tujuan"]."'
          AND id_obat  = '".$data["id_obat"]."'
          AND batch_no = '".$data["batch_no"]."'");



          //Check stock gudang peminta amprah
          $check_stock = $this->check_stock($data["id_gudang"], $data["id_obat"], $data["batch_no"]);
          if ($check_stock > 0)			
            $this->db->query("UPDATE gudang_inventory SET qty = qty + '".$data["qty_acc"]."',expire_date = '".$expire_date."'
            WHERE id_gudang = '".$data['id_gudang']."'
            AND id_obat  = '".$data["id_obat"]."'
            AND batch_no = '".$data["batch_no"]."'");
          else
            $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
            VALUES(
                '".$data["id_gudang"]."',
                '".$data["id_obat"]."',
                '".$data["batch_no"]."',
                '".$data["qty_acc"]."',
                '".$expire_date."'
              )");

              //update verif header amprah
            //   $this->db->query("UPDATE header_amprah SET verif = '1'
            //   WHERE id_amprah = $id
            //  ");
    }}

    function check_stock_gd_asal_old($id_gudang, $id_obat, $batch_no){
      $query=$this->db->query("select qty as jml
      from gudang_inventory 
      where id_gudang = '$id_gudang' and id_obat = '$id_obat' and batch_no = '$batch_no'"); 
      
      return $query;
    
    }

    function check_stock($id_gudang, $id_obat, $batch_no){
      $query=$this->db->query("select count(id_inventory) as jml
        from gudang_inventory 
        where id_gudang = '".$id_gudang."' and id_obat = '".$id_obat."' and batch_no = '".$batch_no."'"); 
      if($query->num_rows()==1)
      {
        return $query->row()->jml;
      }
    }

}

?>