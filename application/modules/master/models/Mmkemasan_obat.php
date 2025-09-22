<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkemasan_obat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal

		function get_all_kemasan_obat(){
			return $this->db->query("SELECT * FROM kemasan_obat order by id");
		}


		function get_data_kemasan($id){
			return $this->db->query("SELECT * FROM kemasan_obat WHERE id='$id'");
		}
		function delete_kemasan_obat($id){
			return $this->db->query("DELETE FROM kemasan_obat WHERE id='$id'");
		}
		function insert_kemasan_obat($data){
			$this->db->insert('kemasan_obat', $data);
			return true;
		}

		function edit_kemasan($id, $data){
			$this->db->where('id', $id);
			$this->db->update('kemasan_obat', $data); 
			return true;
		}
	}
?>
