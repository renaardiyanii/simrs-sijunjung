<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkelompok_obat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_kelompok(){
			return $this->db->query("SELECT * FROM obat_kelompok");
		}

		function get_data_kelompok($id){
			return $this->db->query("SELECT * FROM obat_kelompok WHERE id_satuan='$id'");
		}
		function delete_kelompok_obat($id){
			return $this->db->query("DELETE FROM obat_kelompok WHERE id_satuan='$id'");
		}
		function insert_kelompok_obat($data){
			$this->db->insert('obat_kelompok', $data);
			return true;
		}

		function edit_kelompok($id, $data){
			$this->db->where('id_satuan', $id);
			$this->db->update('obat_kelompok', $data); 
			return true;
		}
	}
?>
