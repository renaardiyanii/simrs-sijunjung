<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmqtx extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		
		function get_all_qtx(){
			return $this->db->query("SELECT * FROM obat_qtx ORDER BY qtx");
		}

		function get_data_qtx($id_qtx){
			return $this->db->query("SELECT * FROM obat_qtx WHERE id_qtx='$id_qtx'");
		}

		function insert_qtx($data){
			$this->db->set('deleted',0,FALSE);
			$this->db->insert('obat_qtx', $data);
			return true;
		}

		function edit_qtx($id_qtx, $data){
			$this->db->where('id_qtx', $id_qtx);
			$this->db->update('obat_qtx', $data); 
			return true;
		}
		function delete_qtx($id_qtx){
			$this->db->where('id_qtx', $id_qtx);
			$this->db->delete('obat_qtx'); 
			return true;
		}

		function soft_delete_qtx($id_qtx){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_qtx',$id_qtx);
			$this->db->update('obat_qtx');
			return true;
		}

		function active_qtx($id_qtx){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_qtx',$id_qtx);
			$this->db->update('obat_qtx');
			return true;
		}
		
	}
?>