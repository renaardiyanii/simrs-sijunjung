<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frmmproduksi extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_obat_all(){
        return $this->db->query("SELECT o.id_obat, o.nm_obat,o.deleted
        FROM master_obat o
        WHERE o.deleted = '0' and id_obat >= 6000");
    }

    
    function get_obat_all_by_id_gudang($id_gudang){
        return $this->db->query("SELECT o.id_obat, o.nm_obat, g.qty, g.batch_no, g.expire_date,g.id_inventory,g.id_gudang
        FROM master_obat o
        INNER JOIN gudang_inventory g ON g.id_obat = o.id_obat
        WHERE  g.id_gudang = $id_gudang and o.id_obat >= 6000");
    }

    function insert_header_produksi($data){
        $this->db->insert('header_obat_produksi',$data);
        return  $this->db->insert_id();
       
    }

    function get_data_header_produksi($id_produksi){
        return $this->db->query("SELECT * from header_obat_produksi where id = $id_produksi");
    }

    function insert_detail_produksi($data){
        $this->db->insert('data_detail_produksi', $data);
		return true;
       
    }

    function get_data_obat_produksi($id_produksi){
        return $this->db->query("SELECT *,(select nm_obat from master_obat where cast(master_obat.id_obat as text) = data_detail_produksi.id_obat) 
        from data_detail_produksi where id_produksi = $id_produksi");
    }

    function hapus_detail_produksi($id){
        return $this->db->query("delete from data_detail_produksi where id = $id");
    }

    function check_stock_gd_asal($id_inventory){
		$query=$this->db->query("
        select qty as jml
                from gudang_inventory 
                where id_inventory = $id_inventory"); 
		
		return $query;
	
	}

    function insert_selesai_produksi($data){

            $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
            keterangan, gudang1, stok_awal, produksi, stok_akhir, created_by)
            VALUES ('".$data['data_header']->id."', '".$data['data_header']->id_obat."', '".$data['data_header']->batch_no."', 
            '".date('Y-m-d H:i:s')."', 
            'Produksi Tambah', '".$data['id_gudang']."', '0', '".$data['data_header']->qty."', '".$data['data_header']->qty."', 
            '".$this->session->userdata('username')."')");


            $this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
            VALUES(
                    7,
                    '".$data['data_header']->id_obat."',
                    '".$data['data_header']->batch_no."',
                    '".$data['data_header']->qty."',
                    '".$data['data_header']->exp_date."'
                )");
                

            foreach ($data['data_obat_produksi'] as $row) {
                $cek_gd1 = $this->check_stock_gd_asal($row->id_inventory)->row()->jml;
                $stock_akhir = $cek_gd1 - $row->qty;
                //  var_dump( $row->qty);die();
                $this->db->query("UPDATE gudang_inventory SET qty = qty - $row->qty 
				WHERE id_inventory = $row->id_inventory
				");

                $this->db->query("INSERT INTO history_obat (no_transaksi, id_obat, batch_no, created_date, 
                keterangan, gudang1, stok_awal, produksi, stok_akhir, created_by)
                VALUES ('".$data['data_header']->id."', '".$row->id_obat."',
                 '".$row->batch_no."', 
                '".date('Y-m-d H:i:s')."', 
                'Produksi Kurang', '".$row->id_gudang."', '".$cek_gd1."', '".$row->qty."', '".$stock_akhir."', 
                '".$this->session->userdata('username')."')");
            }


            return true;
    }

    function insert_master_produksi($data){
        $this->db->insert('master_produksi', $data);
        return  $this->db->insert_id();
       
    }

    function get_data_master_produksi($id_produksi){
        return $this->db->query("SELECT * from master_produksi where id = $id_produksi");
    }

    function insert_detail_master_produksi($data){
        $this->db->insert('detail_master_produksi', $data);
		return true;
       
    }

    function get_data_detail_master_produksi($id_produksi){
        return $this->db->query("SELECT * from detail_master_produksi where id_master = $id_produksi");
    }

    function hapus_detail_master_produksi($id){
        return $this->db->query("delete from detail_master_produksi where id = $id");
    }

    function get_data_master_produksi_all(){
        return $this->db->query("SELECT * from master_produksi");
    }

    function get_data_detail_produksi_all($id_obat){
        return $this->db->query("SELECT * from detail_master_produksi where id_obat_utama = $id_obat");
    }

    function get_data_detail_bahan($id_obat,$id_gd){
        return $this->db->query("SELECT * from gudang_inventory where id_obat = $id_obat and id_gudang = $id_gd");
    }

    function get_nm_obat($id_obat){
        return $this->db->query("SELECT nm_obat from master_obat where id_obat = $id_obat");
    }

    function get_data_inventory($id){
        return $this->db->query("SELECT * from gudang_inventory where id_inventory = $id");
    }
}

?>