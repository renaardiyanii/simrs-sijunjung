<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmpbf extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_pbf(){
			return $this->db->query("SELECT * FROM master_pbf ORDER BY id");
		}

		function get_all_ket_gudang(){
			return $this->db->query("SELECT * FROM ket_master_gudang ORDER BY id_ket");
		}

		function get_data_pbf($id){
			return $this->db->query("SELECT * FROM master_pbf WHERE id='$id'");
		}

		function insert_pbf($data){
			$this->db->insert('master_pbf', $data);
			return true;
		}

		function get_data_bed($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang AND id_gudang='$id_gudang'");
		}

		function edit_pbf($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_pbf', $data); 
			return true;
		}

		function delete_pbf($id){
			return $this->db->query("DELETE FROM master_pbf WHERE id='$id'");
		}
	}
?>