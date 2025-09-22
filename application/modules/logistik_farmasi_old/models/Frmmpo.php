<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frmmpo extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function cari_obat_keyword($keyword){
        $data = $this->db->query("SELECT o.id_obat, o.nm_obat, o.satuank,o.satuanb,o.faktorsatuan, 
        o.hargabeli, o.hargajual, o.jenis_obat,
        (select hargabeli from gudang_inventory where o.id_obat = gudang_inventory.id_obat order by id_inventory desc limit 1) as hargabeligd
        FROM master_obat o
        WHERE o.deleted = '0' and UPPER(o.nm_obat) LIKE '%".$keyword."%' LIMIT 20")->result();
        return $data;
    }

    // function cari_obat_keyword($keyword){
    //     $data = $this->db->query("SELECT o.id_obat, o.nm_obat, o.satuank, o.hargabeli, o.hargajual, g.batch_no, g.expire_date, g.qty, o.jenis_obat
    //     FROM master_obat o
    //     LEFT JOIN gudang_inventory g ON o.id_obat = g.id_obat
    //     WHERE UPPER(o.nm_obat) LIKE '%".$keyword."%' LIMIT 20")->result();
    //     return $data;
    // }

    function insert($data){
        // var_dump($data);die();
        if ($this->db->query("insert into header_po(supplier_id, tgl_po, sumber_dana, no_po, \"user\", surat_dari, no_surat, perihal, ppn,open,jenis_po,userid)
                            values(
                                    '".$data["supplier_id"]."',
                                    '".$data["tgl_po"]."',
                                    '".$data["sumber_dana"]."',
                                    '".$data["no_po"]."',
                                    '".$data["user"]."',
                                    '".$data["surat_dari"]."',
                                    '".$data["no_surat"]."',
                                    '".$data["perihal"]."',
                                    '".$data["ppn"]."',
                                    1,
                                    '".$data["jenis_po"]."',
                                    '".$data["userid"]."'
                                )"))
        {
            $json = json_decode($data["dataobat"], true);
            $id_po=$this->db->insert_id();

            $count = 0;
            $dataobat= array();
            $arr = array("id_po" => $id_po);
            foreach ($json as &$value) {
                array_push($dataobat, array_merge($value, $arr));
                $count++;
            }
            // var_dump($dataobat);
            // if($dataobat[0]['diskon_item'] == "" || $dataobat[0]['diskon_item'] == null && $dataobat[0]['diskon_persen'] == "" || $dataobat[0]['diskon_persen'] == null){
            //     $dataobat[0]['diskon_item'] = 0;
            //     $dataobat[0]['diskon_persen'] = 0;
                
            // }
            $this->db->query("UPDATE header_po SET jml_obat = ".$count." WHERE id_po = '".$id_po."'");

            foreach($dataobat as $value){
                // if($value['diskon_item'] == ""){
                //     $value['diskon_item'] = intval($value['diskon_item']);
                // }
                // if($value['diskon_persen'] == ""){
                //     $value['diskon_persen'] = intval($value['diskon_persen']);
                // }
                // $value['diskon_item'] = intval($value['diskon_item'] );
                // var_dump($value['diskon_item']);

                $this->db->insert('po', $value);
                // var_dump($value);

            }
            // die();
         
            return $id_po;
        }
        return false;
    }

    

    function insert_detail_beli($data, $id_gudang){
        // var_dump($data);die();
        // Aturan Baru, Beli Satuan Besar masuknya Jumlah Kemasan x Qty Beli.
        $qty_akhir = $data["qty_beli"];
        

        // Cek diskon item nya berupa Persentase/ Rupiah
        // if(strpos($data['diskon_item'], "%") !== false){
        //     $persentase = substr($data['diskon_item'], 0, strlen($data['diskon_item'])-1);
        //     $diskon_item = (($data['harga_po'] * $persentase) / 100) + $data['harga_po'];
        // }else{
        //     $persentase = 0;
        //     $diskon_item = $data['diskon_item'];
        // }

        //Cek Data Materai
        if($data['materai'] != 0){
            $materai = 6000;
        }else{
            $materai = 0;
        }

        /*$konten = "";
        $konten .= "insert into po(id_po, item_id, description, satuank, qty, qty_beli, batch_no, expire_date, user, hargabeli, diskon_item, harga_po, jml_kemasan, harga_item, satuan_item, diskon_persen)
         values(
                 '".$data["id_po"]."',
                 '".$data["item_id"]."',
                 '".$data["description"]."',
                 '".$data["satuank"]."',
                 '".$data["qty"]."',
                 '".$data["qty_beli"]."',
                 '".$data["batch_no"]."',
                 '".$data["expire_date"]."',
                 '".$this->load->get_var("user_info")->username."',
                 '".$data["hargabeli"]."',
                 '".$diskon_item."',
                 '".$data["harga_po"]."',
                 '".$data["jml_kemasan"]."',
                 '".$data["hargabeli"]."',
                 '".$data["satuan_item"]."',
                 '".$persentase."'
             )<br/>";*/
             if($data['diskon_item'] == ''){
                $data['diskon_item']= 0;
             }

             if($data['harga_po'] == ''){
                $data['harga_po']= 0;
             }


        if ($this->db->query("insert into po(id_po, item_id, description, satuank, qty, qty_beli, batch_no, expire_date, \"user\", hargabeli, diskon_item, harga_po, jml_kemasan, harga_item, satuan_item, diskon_persen, hargajual, no_faktur)
		    values(
				'".$data["id_po"]."',
				'".$data["item_id"]."',
				'".$data["description"]."',
				'".$data["satuan"]."',
				'".$data["qty"]."',
				'".$data["qty_beli"]."',
				'".$data["batch_no"]."',
				'".$data["expire_date"]."',
				'".$this->load->get_var("user_info")->username."',
				'".$data["hargabeli"]."',
				'".$data['diskon_item']."',
				'".$data["harga_po"]."',
				'".$data["jml_kemasan"]."',
				'".$data["hargabeli"]."',
				'".$data["satuan_item"]."',
				'".$data['diskon_item']."',
                '".$data['hargajual']."',
                '".$data['no_faktur']."'
			)"))
        {
            // $this->db->query("UPDATE header_po SET open = 2 WHERE id_po = '".$data["id_po"]."'");
            //Insert Table do (Delivery Order)
            // if($data['diskon'] == ''){
            //     $data['diskon'] = 0;
            // }

            
            $this->db->query("INSERT INTO \"do\"(id_po, no_faktur, tgl_faktur, jatuh_tempo, ppn, materai, cara_bayar, keterangan_faktur, diskon) 
                      VALUES ('".$data['id_po']."',  
                      '".$data['no_faktur']."', 
                      '".$data['tgl_faktur']."', 
                      '".$data['jatuh_tempo']."', 
                      '".$data['ppn']."', 
                      '".$materai."',
                      '".$data['cara_bayar']."', 
                      '".$data['keterangan']."', 
                      '".$data['diskon_item']."'
                      )");

            /*$konten .= "INSERT IGNORE INTO do (id_po, no_faktur, tgl_faktur, jatuh_tempo, ppn, materai, cara_bayar, keterangan_faktur, diskon)
                           VALUES ('".$data['id_po']."',
                           '".$data['no_faktur']."',
                           '".$data['tgl_faktur']."',
                           '".$data['jatuh_tempo']."',
                           '".$data['ppn']."',
                           '".$materai."',
                           '".$data['cara_bayar']."',
                           '".$data['keterangan']."',
                           '".$data['diskonF']."')<br/>";*/


            //Update Harga Jual Obat
            // $this->db->query("UPDATE master_obat SET
            //             hargajual = '".$data['hargajual']."',
            //             hargabeli = '".$data['hargabeli']."'
                        
            //             WHERE id_obat = '".$data["item_id"]."'");

            /*$konten .= "UPDATE master_obat SET
                             hargajual = '".$data['hargajual']."',
                             hargabeli = '".$data['hargabeli']."'

                             WHERE id_obat = '".$data["item_id"]."'<br/>";*/

            //Input History Pergerakan Stok
            $stok = $this->check_stock_awal(1, $data["item_id"], $data["batch_no"]);
            $stok_akhir = $stok + $qty_akhir;
            // $this->db->query("INSERT INTO history_stok (no_transaksi, id_obat, batch_no, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
			// 		VALUES ('".$data["no_faktur"]."', '".$data["item_id"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 'Pembelian', 1, '".$stok."', '".$qty_akhir."', '".$stok_akhir."')");

          
            $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, keterangan, gudang1, stok_awal, pembelian, stok_akhir)
            VALUES ('".$data["no_faktur"]."', '".$data["item_id"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 'Pembelian Obat', '".$id_gudang."', '".$stok."', '".$qty_akhir."', '".$stok_akhir."')");
        




            //Check stock gudang peminta
            $check_stock = $this->check_stock(1, $data["item_id"], $data["batch_no"]);
            if ($check_stock > 0){
                $this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_akhir."', hargajual = '".$data["hargajual"]."' , hargabeli = '".$data["hargabeli"]."' , satuan = '".$data["satuan"]."'
					WHERE id_gudang = '".$id_gudang."'
					AND id_obat  = '".$data["item_id"]."'
					AND batch_no = '".$data["batch_no"]."'");
            }
            else{
                $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date, hargajual, hargabeli,satuan)
					VALUES(
							'".$id_gudang."',
							'".$data["item_id"]."',
							'".$data["batch_no"]."',
							'".$qty_akhir."',
							'".$data["expire_date"]."',
                            '".$data["hargajual"]."',
                            '".$data["hargabeli"]."',
                            '".$data["satuan"]."'

						)");
            }
            $this->db->query("UPDATE header_po SET open = 2 WHERE id_po = '".$data["id_po"]."'");
        }
        return true;
    }
    /*
     function update($json){
         $userid = $this->session->userdata('username');
         foreach ($json as &$value) {
             $id = $value[0]["value"];
             $qty_beli = $value[1]["value"];
             $batch_no = $value[2]["value"];
             $expire_date = $value[3]["value"];
             $keterangan = $value[4]["value"];
             $id_obat = $value[5]["value"];

             $this->db->query("UPDATE po SET batch_no = '".$batch_no."', qty_beli = '".$qty_beli."', expire_date = '".$expire_date."', keterangan ='".$keterangan."', user = '".$userid."' WHERE id = '".$id."'");

             //Check stock gudang peminta
             $check_stock = $this->check_stock(1, $id_obat, $batch_no);
             if ($check_stock > 0)
                 $this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_beli."'
                 WHERE id_gudang = 1
                 AND id_obat  = '".$id_obat."'
                 AND batch_no = '".$batch_no."'");
             else
                 $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
                 VALUES(
                         1,
                         '".$id_obat."',
                         '".$batch_no."',
                         '".$qty_beli."',
                         '".$expire_date."'
                     )");
         }
         return true;
    }
    */
    function get_suppliers_(){
        return $this->db->query("SELECT person_id, company_name FROM suppliers")->result();
    }

    function get_suppliers(){
        return $this->db->query("SELECT * FROM master_pbf")->result();
    }

    function get_produsen(){
        return $this->db->query("SELECT * FROM master_produsen")->result();
    }

    function get_kemasan(){
        return $this->db->query("SELECT * FROM kemasan_obat")->result();
    }

    function get_satuan(){
        return $this->db->query("SELECT * FROM satuan_obat")->result();
    }


    function get($id_obat) {
        $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
        return $query->row();
    }

    function getIdGudang($userid){
        $query = $this->db->get_where('dyn_gudang_user', array('userid' => $userid));
        return $query->row();
    }

    function get_po_list($data){
        $where = "";
        if ($data["no_po"] != "")
        {
            $where .= " AND a.no_po = '".$data["no_po"]."'";
        }
        else {
            if (($data["tgl0"] != "") && ($data["tgl1"] == "")){
                $where .= " AND a.tgl_po = '".$data["tgl0"]."'";
            }
            if (($data["tgl0"] != "") && ($data["tgl1"] != "")){
                $where .= " AND a.tgl_po BETWEEN ('".$data["tgl0"]."') AND ('".$data["tgl1"]."')";
            }
            if ($data["supplier_id"] != ""){
                $where .= " AND supplier_id = ".$data["supplier_id"] ;
            }
        }

      return $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, a.supplier_id, s.pbf as 
      company_name, a.sumber_dana, a.user, a.open,g.nm_produsen,
(SELECT SUM(qty) FROM po WHERE id_po = a.id_po AND qty_beli IS NULL) AS qty, 
(SELECT SUM(qty_beli) FROM po WHERE id_po = a.id_po AND qty_beli IS NOT NULL) AS qtybeli
      FROM header_po a
      LEFT JOIN master_pbf s ON a.supplier_id = s.id
      LEFT JOIN master_produsen g ON a.vprodusen_id = g.id
      WHERE a.id_po > 0
      $where 
      ORDER BY a.no_po DESC")->result();

   //      return $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, a.supplier_id, s.company_name, a.sumber_dana, a.user, a.open
			// FROM header_po a
			// LEFT JOIN suppliers s ON a.supplier_id = s.person_id
			// WHERE a.id_po > 0
			// $where 
			// ORDER BY a.no_po DESC")->result();
    }
    function get_receiving_detail_list($id){
        return $this->db->query("SELECT *
            FROM receivings_items
            INNER JOIN master_obat m ON m.id_obat = receivings_items.item_id
            WHERE receivings_items.receiving_id = $id")->result();
    }

    function get_po_detail_list($id){
        return $this->db->query("SELECT p.*, (p.qty * cast(p.hargabeli as float)) AS subtotal, (p.qty * p.harga_item)-((p.qty * p.harga_item)*p.diskon_persen/100) AS total
        FROM po p
        INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER)
        WHERE p.id_po =$id  AND qty_beli IS NULL")->result();
    }
    // function get_po_detail_list_beli($id){
    //     return $this->db->query("SELECT p.*, IFNULL(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (IFNULL(SUM(p.qty_beli),0) * p.`harga_item`) AS subtotal, (IFNULL(SUM(p.qty_beli),0) * p.`harga_item`)-((IFNULL(SUM(p.qty_beli),0) * p.`harga_item`)*p.diskon_persen/100) AS total
    //         FROM po p
    //         INNER JOIN master_obat m ON m.id_obat = p.item_id
    //         WHERE p.id_po = $id GROUP BY p.item_id")->result();
    // }

    function get_po_detail_list_beli($id){
        // return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (COALESCE(SUM(p.qty_beli),0) * p.harga_item) AS subtotal, (COALESCE(SUM(p.qty_beli),0) * p.harga_item)-((COALESCE(SUM(p.qty_beli),0) * p.harga_item)*p.diskon_persen/100) AS total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) 
        // WHERE p.id_po = $id GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no,
        // p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item,
        // p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual")->result();

        return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (COALESCE(SUM(p.qty_beli),0) * p.harga_item) AS subtotal, (COALESCE(SUM(p.qty_beli),0) * p.harga_item)-((COALESCE(SUM(p.qty_beli),0) * p.harga_item)*p.diskon_persen/100) AS total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) 
        WHERE p.id_po = $id and p.qty_beli is not null GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no,
        p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item,
        p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual,p.qty_besar,p.satuanb,p.hargajual,
        p.nm_generik,
        p.bentuk_sediaan,
        p.kemasan,
        p.qty2")->result();
    }

    function get_po_detail_list_beli_pesanan($id){
        return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (COALESCE(SUM(p.qty_beli),0) * p.harga_item) AS subtotal, (COALESCE(SUM(p.qty_beli),0) * p.harga_item)-((COALESCE(SUM(p.qty_beli),0) * p.harga_item)*p.diskon_persen/100) AS total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) 
        WHERE p.id_po = $id GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no,
        p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item,
        p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual,p.qty_besar,p.satuanb,p.hargajual,p.nm_generik,p.bentuk_sediaan,p.kemasan,p.qty2")->result();

        // return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (COALESCE(SUM(p.qty_beli),0) * p.harga_item) AS subtotal, (COALESCE(SUM(p.qty_beli),0) * p.harga_item)-((COALESCE(SUM(p.qty_beli),0) * p.harga_item)*p.diskon_persen/100) AS total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) 
        // WHERE p.id_po = $id and p.qty_beli is not null GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no,
        // p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item,
        // p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual")->result();
    }

    
    function get_po_detail_beli($data){
        return $this->db->query("SELECT a.id, a.id_po, a.item_id, a.description, a.satuank, a.qty, a.qty_beli, a.expire_date, a.batch_no, a.keterangan, a.hargabeli, a.user, a.hargajual, a.jml_kemasan, a.diskon_persen
			FROM po a
			INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER)
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
			AND a.qty_beli!=0")->result();
    }
    function get_total_beli($data){

        $id_po = $data['id_po'];
        $item_id = $data['item_id'];
        // var_dump($data);
        // die();

        return $this->db->query("SELECT description, qty, a.satuank, COALESCE(SUM(qty_beli),0) as total_qty_beli, COALESCE(MAX(qty),0) as qty_po, COALESCE(SUM(qty_beli),0)-COALESCE(SUM(qty_beli),0) as kuota, b.open, o.hargajual, a.harga_item AS hargabeli, a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen 
        FROM po a LEFT JOIN header_po AS b ON b.id_po=a.id_po INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER) 
        WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
        GROUP BY description,qty,a.satuank,b.open,o.hargajual,a.harga_item,a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen
        ")->row();
        // return $this->db->query("SELECT description, qty, a.satuank, COALESCE(SUM(qty_beli),0) as total_qty_beli, COALESCE(MAX(qty),0) as qty_po, COALESCE(MAX(qty),0)-COALESCE(SUM(qty_beli),0) as kuota, b.open, o.hargajual, a.harga_item AS hargabeli, a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen 
        // FROM po a LEFT JOIN header_po AS b ON b.id_po=a.id_po INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER) 
        // WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
        // GROUP BY description,qty,a.satuank,b.open,o.hargajual,a.harga_item,a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen
        // ")->row();
    }

    
    function get_info($id)
    {
        // $query = $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, a.supplier_id, s.company_name, a.sumber_dana, a.user, a.ppn, a.surat_dari, a.no_surat, a.perihal, a.ppn
		// 	FROM header_po a
		// 	LEFT JOIN suppliers s ON a.supplier_id = s.person_id
		// 	WHERE a.id_po = ".$id);
        $query = $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, 
        a.supplier_id, s.company_name, a.sumber_dana, a.user, a.ppn, 
        a.surat_dari, a.no_surat, a.perihal,s.alamat as alamat_supplier,a.userid as id_user,
        b.ttd,b.name,a.jenis_po
        FROM header_po a
        LEFT JOIN suppliers s ON a.supplier_id = s.person_id
        left join hmis_users b on a.userid = cast(b.userid as int)
        WHERE a.id_po = $id");
        
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            //create object with empty properties.
            $obj = new stdClass;

            foreach ($query->list_fields() as $field)
            {
                $obj->$field='';
            }

            return $obj;
        }
    }

    public function checkisexist($id){
        $query=$this->db->query("select count(id_po) as exist, tgl_po as tgl 
			from header_po where no_po = '".$id."' AND cancel = 0 GROUP BY tgl_po");
        if($query->num_rows()==1)
        {
            return $query->row();
        }
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

    function check_stock_awal($id_gudang, $id_obat, $batch_no){
        $query = $this->db->query("SELECT * FROM gudang_inventory 
			WHERE id_gudang = '".$id_gudang."' AND id_obat = '".$id_obat."' AND batch_no = '".$batch_no."'");
        if($query->num_rows() > 0){
            return $query->row()->qty;
        }else{
            return 0;
        }
    }

    function delete_detail_beli($id){
        $this->db->where('id',$id);
        if ($this->db->delete('po')){
            return true;
        }else{
            return false;
        }
    }
    function selesai_po($id_po){
        return $this->db->query("UPDATE header_po SET open = 0 
					WHERE id_po = '$id_po'");
    }

    function cancel_po($id_po){
        return $this->db->query("UPDATE header_po SET cancel = 1, open = 0 
          WHERE id_po = '$id_po' AND open = 1");
    }

    function update_qty_po($id, $qty, $iditem){
        foreach ($qty as $key => $value) {
           $this->db->query("UPDATE po SET qty='".$value."' WHERE id_po='".$id."' AND item_id='".$iditem[$key]."'");
        }
        return true;
    }

    function getNomorPO(){
        $month = date('m'); $year = date('Y');
        //$query = $this->db->query("SELECT MAX(no_po) AS last FROM header_po WHERE tgl_po LIKE '".$month."/".$year."/%'  ")->row();
        $this->db->select_max('no_po', 'last');
        $this->db->like('tgl_po', $year);
        $query = $this->db->get('header_po')->row();

        $getLast = substr($query->last, 0, 3);
        $counter = $getLast + 1;
        $nextCounter = sprintf("%03s", $counter);
        $next = $nextCounter."/".$this->get_rome($month)."/".$year."/ULP";
        return $next;
    }

    function get_data_po($tgl1, $tgl2){
        return $this->db->query("SELECT a.id_po, a.tgl_po, a.no_po, b.company_name, sumber_dana FROM header_po as a
			left join suppliers as b on a.supplier_id=b.person_id
			WHERE a.tgl_po >= '$tgl1' and a.tgl_po <= '$tgl2'");
    }

    function get_data_po_obat($id_po){
        return $this->db->query("SELECT description, satuank, qty FROM po WHERE id_po = '$id_po'");
    }

    function get_data_pem_po($tgl1, $tgl2){
        return $this->db->query("SELECT a.id_po, a.tgl_po, a.no_po, b.company_name, sumber_dana FROM header_po as a
			left join suppliers as b on a.supplier_id=b.person_id
			WHERE a.tgl_po >= '$tgl1' and a.tgl_po <= '$tgl2' AND open=0");
    }

    function get_data_pem_po_obat($id_po){
        return $this->db->query("SELECT description, satuank, qty, qty_beli, batch_no, expire_date, hargabeli FROM po WHERE qty_beli IS NOT NULL AND id_po = '$id_po'");
    }

    function getNamaSupplier($supplier_id){
        return $this->db->select("adress")
            ->from('suppliers')
            ->where('person_id', $supplier_id)
            ->get()->row();
    }

    function getSatuanObat(){
        return $this->db->get('obat_satuan');
    }

    function get_rome($month){
        $rome = null;

        switch ($month){
            case "01":
                $rome = "I";
                break;

            case "02":
                $rome = "II";
                break;

            case "03":
                $rome = "III";
                break;

            case "04":
                $rome = "IV";
                break;

            case "05":
                $rome = "V";
                break;

            case "06":
                $rome = "VI";
                break;

            case "07":
                $rome = "VII";
                break;

            case "08":
                $rome = "VIII";
                break;

            case "09":
                $rome = "IX";
                break;

            case "10":
                $rome = "X";
                break;

            case "11":
                $rome = "XI";
                break;

            case "12":
                $rome = "XII";
                break;
        }

        return $rome;
    }
}

?>