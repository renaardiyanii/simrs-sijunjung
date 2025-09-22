<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmcara_pakai extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		
		function get_all_cara_pakai(){
			return $this->db->query("SELECT * FROM obat_cara_pakai ORDER BY cara_pakai");
		}

		function get_data_cara_pakai($id_cara_pakai){
			return $this->db->query("SELECT * FROM obat_cara_pakai WHERE id_cara_pakai='$id_cara_pakai'");
		}

		function insert_cara_pakai($data){
			$this->db->set('deleted',0,FALSE);
			$this->db->insert('obat_cara_pakai', $data);
			return true;
		}

		function edit_cara_pakai($id_cara_pakai, $data){
			$this->db->where('id_cara_pakai', $id_cara_pakai);
			$this->db->update('obat_cara_pakai', $data); 
			return true;
		}
		function delete_cara_pakai($id_cara_pakai){
			$this->db->where('id_cara_pakai', $id_cara_pakai);
			$this->db->delete('obat_cara_pakai'); 
			return true;
		}

		function soft_delete_cara_pakai($id_cara_pakai){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_cara_pakai',$id_cara_pakai);
			$this->db->update('obat_cara_pakai');
			return true;
		}

		function active_cara_pakai($id_cara_pakai){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_cara_pakai',$id_cara_pakai);
			$this->db->update('obat_cara_pakai');
			return true;
		}
		
	}
?>