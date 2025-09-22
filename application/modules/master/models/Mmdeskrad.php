<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmdeskrad extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_deskripsi(){
			return $this->db->query("SELECT * FROM master_desk_rad order by judul");
		}

		function get_data_deskripsi($id){
			return $this->db->query("SELECT * FROM master_desk_rad WHERE id='$id'");
		}
		function delete_deskripsi($id){
			return $this->db->query("DELETE FROM master_desk_rad WHERE id='$id'");
		}
		function insert_deskripsi($data){
			$this->db->insert('master_desk_rad', $data);
			return true;
		}

		function edit_deskripsi($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_desk_rad', $data); 
			return true;
		}

		function get_bhp_radiologi() {
			return $this->db->query("SELECT * FROM master_bhp_radiologi");
		}

		function insert_bhp($data){
			$this->db->insert('master_bhp_radiologi', $data);
			return true;
		}

		function get_data_master_bhp($id) {
			return $this->db->query("SELECT * FROM master_bhp_radiologi WHERE id_bhp = '$id'");
		}

		function edit_bhp($id, $data) {
			$this->db->where('id_bhp', $id);
			$this->db->update('master_bhp_radiologi', $data);
			return true;
		}
	}
?>
