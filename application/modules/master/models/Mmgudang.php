<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmgudang extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_gudang(){
			return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
		}

		function get_all_ket_gudang(){
			return $this->db->query("SELECT * FROM ket_master_gudang ORDER BY id_ket");
		}

		function get_data_gudang($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='$id_gudang'");
		}

		function insert_gudang($data){
			$this->db->insert('master_gudang', $data);
			return true;
		}

		function get_data_bed($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang AND id_gudang='$id_gudang'");
		}

		function edit_gudang($id_gudang, $data){
			$this->db->where('id_gudang', $id_gudang);
			$this->db->update('master_gudang', $data); 
			return true;
		}

		function delete_gudang($id_gudang){
			return $this->db->query("DELETE FROM master_gudang WHERE id_gudang='$id_gudang'");
		}
	}
?>