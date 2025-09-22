<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmprodusen extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_produsen(){
			return $this->db->query("SELECT * FROM master_produsen ORDER BY id");
		}

		function get_all_ket_gudang(){
			return $this->db->query("SELECT * FROM ket_master_gudang ORDER BY id_ket");
		}

		function get_data_produsen($id){
			return $this->db->query("SELECT * FROM master_produsen WHERE id='$id'");
		}

		function insert_produsen($data){
			$this->db->insert('master_produsen', $data);
			return true;
		}

		function get_data_bed($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang AND id_gudang='$id_gudang'");
		}

		function edit_produsen($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_produsen', $data); 
			return true;
		}

		function delete_produsen($id){
			return $this->db->query("DELETE FROM master_produsen WHERE id='$id'");
		}
	}
?>