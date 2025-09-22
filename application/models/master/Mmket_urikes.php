<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmket_urikes extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_ket_urikes(){
			return $this->db->query("SELECT * FROM urikkes_keterangan ORDER BY ket_urikes");
		}

		function get_data_ket_urikes($id){
			return $this->db->query("SELECT * FROM urikkes_keterangan WHERE ket_urikes='$id'");
		}	

		function get_nama_ket_urikes($id){
			return $this->db->query("SELECT nama_ket_urikes FROM urikkes_keterangan WHERE ket_urikes='$id'");
		}		
	
		function delete_ket_urikes($id){
			return $this->db->query("DELETE FROM urikkes_keterangan WHERE ket_urikes='$id'");
		}

		function insert_ket_urikes($data){
			$this->db->insert('urikkes_keterangan', $data);
			return true;
		}

		function edit_ket_urikes($id, $data){
			$this->db->where('ket_urikes', $id);
			return $this->db->update('urikkes_keterangan', $data); ;
		}

	}
?>
