<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmgolongan_obat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_golongan(){
			return $this->db->query("SELECT * FROM obat_golongan");
		}

		function get_data_golongan($id){
			return $this->db->query("SELECT * FROM obat_golongan WHERE id_golongan='$id'");
		}
		function delete_golongan_obat($id){
			return $this->db->query("DELETE FROM obat_golongan WHERE id_golongan='$id'");
		}
		function insert_golongan_obat($data){
			$this->db->insert('obat_golongan', $data);
			return true;
		}

		function edit_golongan($id, $data){
			$this->db->where('id_golongan', $id);
			$this->db->update('obat_golongan', $data); 
			return true;
		}
	}
?>
