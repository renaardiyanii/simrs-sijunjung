<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmloket extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_loket(){
			return $this->db->query("SELECT * FROM dyn_kasir ORDER BY id");
		}

		function get_data_loket($id){
			return $this->db->query("SELECT * FROM dyn_kasir WHERE id='$id'");
		}		

		function delete_loket($id){
			return $this->db->query("DELETE FROM dyn_kasir WHERE id='$id'");
		}

		function insert_loket($data){
			$this->db->insert('dyn_kasir', $data);
			return true;
		}

		function edit_loket($id, $data){
			$this->db->where('id', $id);
			return $this->db->update('dyn_kasir', $data); ;
		}

	}
?>
