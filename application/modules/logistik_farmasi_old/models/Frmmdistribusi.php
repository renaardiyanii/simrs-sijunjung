<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmdistribusi extends CI_Model{
    function __construct(){
    parent::__construct();
  }
  function get_data_master_gudang_all($id){
	return $this->db->query("select * from master_gudang where id_gudang = '$id'")->result_array();
}
  function get_amprah_detail_list($id){
		// return $this->db->query("SELECT DISTINCT a.id_amprah, a.id_obat, b.nm_obat, a.satuank, a.qty_req, a.id_gudang_tujuan, a.id_gudang
		// 	FROM distribusi a
		// 	LEFT JOIN master_obat b on a.id_obat = b.id_obat
		// 	WHERE a.id_amprah = $id")->result();

		return $this->db->query("SELECT DISTINCT a.id_amprah, a.id_obat, a.nm_obat, a.satuank, a.qty_req
		FROM amprah a
		WHERE a.id_amprah = '$id'")->result();
    }
	function get_amprah_detail_acc($data){
		return $this->db->query("SELECT a.id, a.id_amprah, a.id_obat, a.id_gudang, a.id_gudang_tujuan, a.satuank, a.qty_req, a.qty_acc, a.expire_date, a.batch_no, a.keterangan, a.user
			FROM distribusi a
			WHERE a.id_amprah = '".$data["id_amprah"]."' AND a.id_obat = '".$data["id_obat"]."'
			AND a.qty_acc IS NOT NULL AND a.batch_no IS NOT NULL AND a.expire_date IS NOT NULL")->result();
    }
	function get_total_acc($data){
		

		// MIGRATE FROM MYSQL TO POSTGRESQL
		// return $this->db->query("
		// SELECT id_obat, id_gudang, id_gudang_tujuan, qty_req, satuank, 
		// COALESCE(SUM(qty_acc),0) as total_qty_acc, 
		// COALESCE(MAX(qty_req),0)-COALESCE(SUM(qty_acc),0) as kuota 
		// FROM distribusi a 
		// WHERE a.id_amprah= '".$data["id_amprah"]."'
		// AND a.id_obat = '".$data["id_obat"]."'
		// GROUP BY a.id_obat,a.id_gudang,a.id_gudang_tujuan,a.qty_req,a.satuank
		// ")->row();
		return $this->db->query("
		select a.gd_asal,a.gd_dituju,a.id_amprah,b.id_obat,b.nm_obat,b.satuank,b.qty_req from header_amprah a left join 
		amprah b on cast(a.id_amprah as text) = b.id_amprah where a.id_amprah = '".$data["id_amprah"]."' and b.id_obat = '".$data["id_obat"]."'
		")->row();


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

	function check_stock_gd_asal($id_gudang, $id_obat, $batch_no){
		$query=$this->db->query("select qty as jml
		from gudang_inventory 
		where id_gudang = '$id_gudang' and id_obat = '$id_obat' and batch_no = '$batch_no'"); 
		
		return $query;
	
	}

	function get_expire_date($id_gudang, $id_obat, $batch_no){
		$query=$this->db->query("select expire_date
			from gudang_inventory 
			where id_gudang = '".$id_gudang."' and id_obat = '".$id_obat."' and batch_no = '".$batch_no."'"); 
		if($query->num_rows()==1)
		{
			return $query->row()->expire_date;
		}
	}
    function get_amprah_detail_stock($ido, $idg){
		return $this->db->query("SELECT batch_no, expire_date, qty FROM gudang_inventory WHERE id_obat = $ido and id_gudang = $idg 
		and qty != 0 and  DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date) >= 0
        and (DATE_PART('year', expire_date::date) - DATE_PART('year', now()::date)) * 12 +
              (DATE_PART('month', expire_date::date) - DATE_PART('month', now()::date)) >= 1  ")->result();
    }
    function update_status_amprah($id_amprah){
    	$status="1";
		$this->db->query("UPDATE header_amprah SET status = $status where id_amprah = $id_amprah");
    }
	function insert_detail_acc($data){   
		if($data["expire_date"]==''){
			$expire_date='NULL';
		}else{
			$expire_date=$data["expire_date"];
		}

		$this->db->query("insert into distribusi(id_amprah, id_obat, id_gudang, id_gudang_tujuan, satuank, qty_req, qty_acc, batch_no, expire_date, \"user\")
		values(
				'".$data["id_amprah"]."',
				'".$data["id_obat"]."',
				'".$data["id_gudang"]."',
				'".$data["id_gudang_tujuan"]."',
				'".$data["satuank"]."',
				'".$data["qty_req"]."',
				'".$data["qty_acc"]."',
				'".$data["batch_no"]."',
				'".$expire_date."',
				'".$this->session->userdata('username')."'
			)");
		return true;
   }
   
	function delete_detail_acc($id){		
		$this->db->where('id',$id);	
		if ($this->db->delete('distribusi')){
			return true;
		}else{			
			return false;
		}
	}
}

?>
