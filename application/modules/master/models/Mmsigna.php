<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmsigna extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		
		function get_all_signa(){
			return $this->db->query("SELECT * FROM signa ORDER BY signa");
		}

		function get_data_signa($id_signa){
			return $this->db->query("SELECT * FROM signa WHERE id_signa='$id_signa'");
		}

		function insert_signa($data){
			$this->db->set('deleted',0,FALSE);
			$this->db->insert('signa', $data);
			return true;
		}

		function edit_signa($id_signa, $data){
			$this->db->where('id_signa', $id_signa);
			$this->db->update('signa', $data); 
			return true;
		}
		function delete_signa($id_signa){
			$this->db->where('id_signa', $id_signa);
			$this->db->delete('signa'); 
			return true;
		}

		function soft_delete_signa($id_signa){
			$this->db->set('deleted', '1', FALSE);
			$this->db->where('id_signa',$id_signa);
			$this->db->update('signa');
			return true;
		}

		function active_signa($id_signa){
			$this->db->set('deleted', '0', FALSE);
			$this->db->where('id_signa',$id_signa);
			$this->db->update('signa');
			return true;
		}
		
	}
?>