<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmjenis_obat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_jenis(){
			return $this->db->query("SELECT * FROM obat_jenis");
		}

		function get_data_jenis($id){
			return $this->db->query("SELECT * FROM obat_jenis WHERE id_jenis='$id'");
		}
		function delete_jenis_obat($id){
			return $this->db->query("DELETE FROM obat_jenis WHERE id_jenis='$id'");
		}
		function insert_jenis_obat($data){
			$this->db->insert('obat_jenis', $data);
			return true;
		}

		function edit_jenis($id, $data){
			$this->db->where('id_jenis', $id);
			$this->db->update('obat_jenis', $data); 
			return true;
		}
	}
?>
