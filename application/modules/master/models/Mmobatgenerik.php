<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobatgenerik extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_obat_generik(){
			return $this->db->query("SELECT * FROM obat_generik ORDER BY id desc");
		}

		function get_all_ket_gudang(){
			return $this->db->query("SELECT * FROM ket_master_gudang ORDER BY id_ket");
		}

		function get_data_generik($id){
			return $this->db->query("SELECT * FROM obat_generik WHERE id='$id'");
		}

		function insert_obat_generik($data){
			$this->db->insert('obat_generik', $data);
			return true;
		}

		function get_data_bed($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang AND id_gudang='$id_gudang'");
		}

		function edit_generik($id, $data){
			$this->db->where('id', $id);
			$this->db->update('obat_generik', $data); 
			return true;
		}

		function delete_generik($id){
			return $this->db->query("DELETE FROM obat_generik WHERE id='$id'");
		}
	}
?>