<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmsubkelompok_tind extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_subkel(){
			return $this->db->query("SELECT * FROM master_subkelompok_tind ORDER BY id_subkelompok");
		}

		function get_data_subkel($id){
			return $this->db->query("SELECT * FROM master_subkelompok_tind WHERE id_subkelompok='$id'");
		}

		function insert_subkel($data){
			$this->db->insert('master_subkelompok_tind', $data);
			return true;
		}

		
		function edit_subkel($id, $data){
			$this->db->where('id_subkelompok', $id);
			$this->db->update('master_subkelompok_tind', $data); 
			return true;
		}

		function delete_subkel($id){
			return $this->db->query("DELETE FROM master_subkelompok_tind WHERE id_subkelompok='$id'");
		}
	}
?>