<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmsatuan_obat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_satuan(){
			return $this->db->query("SELECT * FROM obat_satuan order by nm_satuan");
		}

		function get_all_satuan_obat(){
			return $this->db->query("SELECT * FROM obat_satuan order by nm_satuan");
		}


		function get_data_satuan($id){
			return $this->db->query("SELECT * FROM obat_satuan WHERE id_satuan='$id'");
		}
		function delete_satuan_obat($id){
			return $this->db->query("DELETE FROM obat_satuan WHERE id_satuan='$id'");
		}
		function insert_satuan_obat($data){
			$this->db->insert('obat_satuan', $data);
			return true;
		}

		function edit_satuan($id, $data){
			$this->db->where('id_satuan', $id);
			$this->db->update('obat_satuan', $data); 
			return true;
		}
	}
?>
