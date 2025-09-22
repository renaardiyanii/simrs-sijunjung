<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmkeltind extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	//master poli
	function get_all_keltind(){
		return $this->db->query("SELECT * FROM kel_tind ORDER BY idkel_tind");
	}

	function get_data_keltind($idkel_tind){
		return $this->db->query("SELECT * FROM kel_tind WHERE idkel_tind='$idkel_tind'");
	}		

	function get_data_keltind_new($id) {
		return $this->db->query("SELECT * FROM master_keltind WHERE id_keltind = '$id'");
	}

	function delete_keltind($idkel_tind){
		return $this->db->query("DELETE FROM kel_tind WHERE idkel_tind='$idkel_tind'");
	}

	function delete_keltind_new($idkel_tind){
		return $this->db->query("DELETE FROM master_keltind WHERE id_keltind = '$idkel_tind'");
	}

	function insert_keltind($data){
		$this->db->insert('kel_tind', $data);
		return true;
	}

	function insert_keltind_new($data){
		$this->db->insert('master_keltind', $data);
		return true;
	}

	function edit_keltind($idkel_tind, $data){
		$this->db->where('idkel_tind', $idkel_tind);
		$this->db->update('kel_tind', $data); 
		return true;
	}

	function edit_keltind_new($id, $data) {
		$this->db->where('id_keltind', $id);
		$this->db->update('master_keltind', $data);
		return true;
	}

	function get_all_keltind_new() {
		return $this->db->query("SELECT * FROM master_keltind");
	}
}
?>
