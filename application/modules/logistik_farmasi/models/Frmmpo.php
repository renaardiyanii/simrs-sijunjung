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
        //  var_dump($data);die();
        $tgl = date('Y-m-d',strtotime($data["tgl_po"]));
        if ($this->db->query("insert into header_po(supplier_id, tgl_po, sumber_dana, no_po, \"user\", 
        surat_dari, no_surat, perihal, ppn,open,userid)
                            values(
                                    '".$data["supplier_id"]."',
                                    '".$tgl."',
                                    '".$data["sumber_dana"]."',
                                    '".$data["no_po"]."',
                                    '".$data["user"]."',
                                    '".$data["surat_dari"]."',
                                    '".$data["no_surat"]."',
                                    '".$data["perihal"]."',
                                    '".$data["ppn"]."',
                                    1,
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
        $qty_akhir = $data["qty_beli_kecil"];

        if($data["diskon_item"] == ''){
            $diskon = 0;
        }else{
            $diskon = $data["diskon_item"];
        }

       

        if ($this->db->query("insert into po(id_po, 
        item_id, 
        description, 
        satuank, 
        qty, 
        qty_beli, 
        batch_no, 
        expire_date, 
        \"user\", hargabeli,harga_po, 
        jml_kemasan, harga_item,diskon_persen, hargajual, no_faktur,no_do)
		    values(
				'".$data["id_po"]."',
				'".$data["item_id"]."',
				'".$data["description"]."',
				'".$data["satuan"]."',
				'".$data["qty_beli_kecil"]."',
				'".$data["qty_beli_kecil"]."',
				'".$data["batch_no"]."',
				'".$data["expire_date"]."',
				'".$this->load->get_var("user_info")->username."',
				'".$data["hargabeli"]."',
				'".$data["total"]."',
				'".$data["isi"]."',
				'".$data["hargabeli_kecil"]."',
                '".$diskon."',
                '".$data['hargajual']."',
                '".$data['no_faktur']."',
                '".$data['no_do']."'
			)"))
        {
            
           
            if($data['tgl_do'] == '' && $data['tgl_faktur'] != ''){
                $tgl_faktur = $data['tgl_faktur'];
                $tgl_do = null;
            }else if($data['tgl_do'] != '' && $data['tgl_faktur'] == ''){
                $tgl_faktur = null;
                $tgl_do = $data['tgl_do'];
            }

            $this->db->query("INSERT INTO \"do\"(id_po, 
            no_faktur, no_do,tgl_do,tgl_terima,
            tgl_faktur, jatuh_tempo, 
            ppn,
            cara_bayar, keterangan_faktur,materai,diskon) 
                      VALUES ('".$data['id_po']."',  
                      '".$data['no_faktur']."', 
                      '".$data['no_do']."',
                      '".$tgl_do."',
                      '".$data['tgl_terima']."',
                      '".$tgl_faktur."', 
                      '".$data['jatuh_tempo']."', 
                      '".$data['ppn']."', 
                      '".$data['cara_bayar']."', 
                      '".$data['keterangan']."',
                      0,
                      $diskon

                      )");

          

            $stok = $this->check_stock_awal(1, $data["item_id"], $data["batch_no"]);
            $stok_akhir = $stok + $qty_akhir;
            

            if($data["no_faktur"] == null){
                $no_transaksi = $data['no_do'];
            }else{
                $no_transaksi = $data["no_faktur"];
            }
          
            // $this->db->query("INSERT INTO history_obat (no_transaksi, 
            // id_obat, batch_no, created_date, keterangan, 
            // gudang1, stok_awal, pembelian, stok_akhir,expire_date,hargabeli)
            // VALUES ('".$no_transaksi."', '".$data["item_id"]."', 
            // '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 
            // 'Pembelian Obat', '".$id_gudang."', '".$stok."', '".$qty_akhir."', '".$stok_akhir."','".$data["expire_date"]."','".$data["hargabeli_kecil"]."')");
        
            // $check_stock = $this->check_stock(1, $data["item_id"], $data["batch_no"]);
            // if ($check_stock > 0){
                // $this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_akhir."', hargajual = '".$data["hargajual"]."' , hargabeli = '".$data["hargabeli_kecil"]."' , satuan = '".$data["satuan"]."'
				// 	WHERE id_gudang = '".$id_gudang."'
				// 	AND id_obat  = '".$data["item_id"]."'
				// 	AND batch_no = '".$data["batch_no"]."'");
            // }
            // else{
                // $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date, hargajual, hargabeli,satuan)
				// 	VALUES(
				// 			'".$id_gudang."',
				// 			'".$data["item_id"]."',
				// 			'".$data["batch_no"]."',
				// 			'".$qty_akhir."',
				// 			'".$data["expire_date"]."',
                //             '".$data["hargajual"]."',
                //             '".$data["hargabeli_kecil"]."',
                //             '".$data["satuan"]."'

				// 		)");
            // }
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
        return $this->db->query("SELECT p.*,
        (select ppn from header_po where P.id_po = header_po.id_po) as ppn
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

        return $this->db->query("SELECT P
        .*,
        COALESCE ( SUM ( P.qty_beli ), 0 ) AS qty_beli,
        M.hargabeli,
        M.hargajual,
        P.harga_po AS subtotal,
        ( COALESCE ( SUM ( P.harga_po ) )) AS total 
    FROM
        po
        P INNER JOIN master_obat M ON M.id_obat = CAST ( P.item_id AS INTEGER ) 
    WHERE
        P.id_po = $id
        AND P.qty_beli IS NOT NULL 
    GROUP BY
        P.item_id,
        P.id_po,
        P.description,
        P.qty,
        P.satuank,
        P.qty_beli,
        P.batch_no,
        P.expire_date,
        P.keterangan,
        P.USER,
        P.hargabeli,
        P.diskon_item,
        P.harga_po,
        P.no_faktur,
        P.jml_kemasan,
        P.harga_item,
        P.satuan_item,
        P.diskon_persen,
        P.input_time,
        P.ID,
        M.hargabeli,
        M.hargajual,
        P.qty_besar,
        P.satuanb,
        P.hargajual,
        P.nm_generik,
        p.bentuk_sediaan,
        p.kemasan,
        p.qty2,
        p.no_do,
        p.verifikasi_gudang,
				p.verifikasi_penerima,
				p.verifikasi_gudang_dt,
				p.verifikasi_penerima_dt")->result();
    }

    function get_po_detail_list_beli_pesanan($id){
        return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, P.harga_po AS subtotal, sum (P.harga_po) as total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) WHERE p.id_po = $id GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no, p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item, p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual,p.qty_besar,p.satuanb,p.hargajual,p.nm_generik,p.bentuk_sediaan,p.kemasan,p.qty2,P.no_do,p.verifikasi_gudang,p.verifikasi_gudang_dt,p.verifikasi_penerima,p.verifikasi_penerima_dt,p.ket_obat")->result();

        // return $this->db->query("SELECT p.*, COALESCE(SUM(p.qty_beli),0) as qty_beli, m.hargabeli, m.hargajual, (COALESCE(SUM(p.qty_beli),0) * p.harga_item) AS subtotal, (COALESCE(SUM(p.qty_beli),0) * p.harga_item)-((COALESCE(SUM(p.qty_beli),0) * p.harga_item)*p.diskon_persen/100) AS total FROM po p INNER JOIN master_obat m ON m.id_obat = CAST(p.item_id AS INTEGER) 
        // WHERE p.id_po = $id and p.qty_beli is not null GROUP BY p.item_id,p.id_po,p.description,p.qty,p.satuank,p.qty_beli,p.batch_no,
        // p.expire_date,p.keterangan,p.user,p.hargabeli,p.diskon_item,p.harga_po,p.no_faktur,p.jml_kemasan,p.harga_item,
        // p.satuan_item,p.diskon_persen,p.input_time,p.id,m.hargabeli,m.hargajual")->result();
    }

    function get_po_detail_beli_belum_verif_penerima($data)
    {
        return $this->db->query("SELECT a.id, a.id_po, a.item_id, a.description, a.satuank, a.qty, a.qty_beli, a.expire_date, a.batch_no, a.keterangan, a.hargabeli, a.user, a.hargajual, a.jml_kemasan, a.diskon_persen,a.verifikasi_penerima,a.verifikasi_penerima_dt,a.verifikasi_gudang,a.verifikasi_gudang_dt,a.diskon_item,a.no_faktur,a.no_do,a.harga_item
			FROM po a
			-- INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER)
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
            and a.verifikasi_penerima is null
			AND a.qty_beli!=0")->result();
    }

    function get_po_detail_beli_belum_verif_gudang($data)
    {
        return $this->db->query("SELECT a.id, a.id_po, a.item_id, a.description, a.satuank, a.qty, a.qty_beli, a.expire_date, a.batch_no, a.keterangan, a.hargabeli, a.user, a.hargajual, a.jml_kemasan, a.diskon_persen,a.verifikasi_penerima,a.verifikasi_penerima_dt,a.verifikasi_gudang,a.verifikasi_gudang_dt,a.diskon_item,a.no_faktur,a.no_do,a.harga_item
			FROM po a
			-- INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER)
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
            and a.verifikasi_gudang is null
			AND a.qty_beli!=0")->result();
    }

    
    function get_po_detail_beli($data){
        return $this->db->query("SELECT a.id, a.id_po, a.item_id, a.description, a.satuank, a.qty, a.qty_beli, a.expire_date, a.batch_no, a.keterangan, a.hargabeli, a.user, a.hargajual, a.jml_kemasan, a.diskon_persen,a.verifikasi_penerima,a.verifikasi_penerima_dt,a.verifikasi_gudang,a.verifikasi_gudang_dt,a.diskon_item,a.no_faktur,a.no_do,a.harga_item
			FROM po a
			-- INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER)
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
			AND a.qty_beli!=0")->result();
    }
    function get_total_beli($data){

        $id_po = $data['id_po'];
        $item_id = $data['item_id'];
        // var_dump($data);
        // die();

        return $this->db->query("SELECT description, qty, a.satuank,a.qty_besar, 
        	COALESCE ( SUM ( qty_beli ), 0 ) AS total_qty_beli,
            COALESCE ( MAX ( cast(qty_besar as int) ), 0 ) AS qty_po,
            COALESCE ( SUM ( qty_beli ), 0 ) - COALESCE ( SUM ( qty_beli ), 0 ) AS kuota, 
        b.open, o.hargajual, a.harga_item AS hargabeli, a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen 
        FROM po a LEFT JOIN header_po AS b ON b.id_po=a.id_po INNER JOIN master_obat o ON o.id_obat = CAST(a.item_id AS INTEGER) 
        WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
        GROUP BY description,qty,a.satuank,b.open,o.hargajual,a.harga_item,a.jml_kemasan, a.harga_po, a.satuan_item, a.diskon_persen,a.qty_besar,a.id ORDER BY a.id ASC
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
        $query = $this->db->query("SELECT A
        .id_po,
        A.no_po,
        A.tgl_po,
        A.supplier_id,
        s.pbf,
        s.alamat,
        A.sumber_dana,
        A.USER,
        A.ppn,
        A.surat_dari,
        A.no_surat,
        A.perihal,
        A.userid AS id_user,
        b.ttd,
        b.NAME,
        A.jenis_po 
    FROM
        header_po
        A LEFT JOIN master_pbf s ON A.supplier_id = s.id
        LEFT JOIN hmis_users b ON A.userid = CAST ( b.userid AS INT ) 
    WHERE
        A.id_po = $id");
        
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
          return $this->db->query("UPDATE po SET qty='".$value."' WHERE id_po='".$id."' AND item_id='".$iditem[$key]."'");
        }
    }

    function getNomorPO(){
        $month = date('m'); $year = date('Y');
        //$query = $this->db->query("SELECT MAX(no_po) AS last FROM header_po WHERE tgl_po LIKE '".$month."/".$year."/%'  ")->row();
        $this->db->select_max('no_po', 'last');
        $this->db->like(to_char('tgl_po','YYYY'), $year);
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

    public function verifikasi_penerima($data,$hasil)
    {
        foreach($hasil as $val){
            $res = $this->db->where('id',$val->id)->update('po',$data);
        }
        return true;
    }
    public function verifikasi_gudang($v,$data,$id_gudang = 1)
    {
        foreach($data as $val){

            $qty_akhir = $val->qty_beli;
            if($val->diskon_item == ''){
                $diskon = 0;
            }else{
                $diskon = $val->diskon_item;
            }
            if($val->no_faktur == null){
                $no_transaksi = $val->no_do;
            }else{
                $no_transaksi = $val->no_faktur;
            }
            $stok = $this->check_stock_awal(1, $val->item_id, $val->batch_no);
            $stok_akhir = $stok + $qty_akhir;
            $this->db->query("INSERT INTO history_obat (no_transaksi, 
                id_obat, batch_no, created_date, keterangan, 
                gudang1, stok_awal, pembelian, stok_akhir,expire_date,hargabeli)
                VALUES ('".$no_transaksi."', '".$val->item_id."', 
                '".$val->batch_no."', '".date('Y-m-d H:i:s')."', 
                'Pembelian Obat', '".$id_gudang."', '".$stok."', '".$qty_akhir."', '".$stok_akhir."','".$val->expire_date."','".$val->harga_item."')");
            
                $check_stock = $this->check_stock(1, $val->item_id, $val->batch_no);
                if ($check_stock > 0){
                    $this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_akhir."', hargajual = '".$val->hargajual."' , hargabeli = '".$val->harga_item."' , satuan = '".$val->satuank."'
                        WHERE id_gudang = '".$id_gudang."'
                        AND id_obat  = '".$val->item_id."'
                        AND batch_no = '".$val->batch_no."'");
                }
                else{
                    $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date, hargajual, hargabeli,satuan)
                        VALUES(
                                '".$id_gudang."',
                                '".$val->item_id."',
                                '".$val->batch_no."',
                                '".$qty_akhir."',
                                '".$val->expire_date."',
                                '".$val->hargajual."',
                                '".$val->harga_item."',
                                '".$val->satuank."'
    
                            )");
                }
            $res = $this->db->where('id',$val->id)->update('po',$v);
        }
        return true;
    }

    function check_po_id($id)
    {
        return $this->db->where('id',$id)->get('po')->row();
    }


    function hapus_po_id($id)
    {
        return $this->db->where('id',$id)->delete('po');
    }
}

?>