<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobat_konsinyasi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master Obatk
		function get_all_obatk(){
			return $this->db->query("SELECT id, id_obatk, nm_obatk, hargabeli, hargajual, obatalkes FROM obat_konsinyasi
				ORDER BY id");
		}
		
		function get_data_obatk($id){
			return $this->db->query("SELECT * FROM obat_konsinyasi 
				WHERE id=$id");
		}
		function get_id_max(){
			return $this->db->query('SELECT MAX(substr(id_obatk, 3, 3)+1) as kodex FROM obat_konsinyasi');	
		}
		//function get_jam($id_dokter){
		//	return $this->db->query("SELECT *, ")
		//}

		function get_obatk($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE nm_dokter='$nm_dokter'");
		}
		function delete_obatk($id){
			return $this->db->query("DELETE FROM obat_konsinyasi WHERE id='$id'");
		}
		function insert_obatk($data){
			$this->db->insert('obat_konsinyasi', $data);
			return true;
		}

		function edit_obatk($id, $data){
			$this->db->where('id', $id);
			$this->db->update('obat_konsinyasi', $data); 
			return true;
		}
	}
?>
