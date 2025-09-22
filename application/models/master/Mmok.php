<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmok extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_perawat(){
			return $this->db->query("SELECT * FROM perawat_ok");
		}

		function get_all_perawat_active(){
			return $this->db->query("SELECT * FROM perawat_ok where deleted!=1");
		}
		
		function delete_perawat($id){
			return $this->db->query("DELETE FROM perawat_ok WHERE id='$id'");
		}

		function insert_perawat($data){
			$this->db->insert('perawat_ok', $data);
			return true;
		}
		function get_data_perawat($id){
			return $this->db->query("SELECT * FROM perawat_ok WHERE id=$id");
		}
		function edit_perawat($id, $data){
			$this->db->where('id', $id);
			$this->db->update('perawat_ok', $data); 
			return true;
		}
	}
?>
