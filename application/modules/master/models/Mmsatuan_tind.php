<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmsatuan_tind extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_satuan(){
			return $this->db->query("SELECT * FROM master_satuan_tindakan ORDER BY id");
		}

		function get_data_satuan($id){
			return $this->db->query("SELECT * FROM master_satuan_tindakan WHERE id='$id'");
		}

		function insert_satuan($data){
			$this->db->insert('master_satuan_tindakan', $data);
			return true;
		}

		
		function edit_satuan($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_satuan_tindakan', $data); 
			return true;
		}

		function delete_satuan($id){
			return $this->db->query("DELETE FROM master_satuan_tindakan WHERE id='$id'");
		}
	}
?>