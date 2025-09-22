<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmstandar_diet extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get($id=""){
			if($id != ''){
				return $this->db->where('id',$id)->get('master_standar_diet');
			}
			return $this->db->get('master_standar_diet');
			
		}

		function get_data_standar_diet($id){
			return $this->db->query("SELECT * FROM master_standar_diet WHERE id='$id'");
		}

		function edit_standar_diet($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_standar_diet', $data); 
			return true;
		}


		function soft_delete_standar_diet($id){
			$this->db->set('active', '1', FALSE);
			$this->db->where('id',$id);
			$this->db->update('master_standar_diet');
			return true;
		}

		function soft_active_standar_diet($id){
			$this->db->set('active', '0', FALSE);
			$this->db->where('id',$id);
			$this->db->update('master_standar_diet');
			return true;
		}

		function insert($data){
			return $this->db->insert('master_standar_diet', $data);
			
		}

		
	}
?>
