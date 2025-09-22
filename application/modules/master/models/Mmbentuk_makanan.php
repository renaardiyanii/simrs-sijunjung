<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmbentuk_makanan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get($id=""){
			if($id != ''){
				return $this->db->where('id',$id)->get('master_bentuk_makanan');
			}
			return $this->db->get('master_bentuk_makanan');
			
		}

		function get_data_bentuk_makanan($id){
			return $this->db->query("SELECT * FROM master_bentuk_makanan WHERE id='$id'");
		}

		function edit_bentuk_makanan($id, $data){
			$this->db->where('id', $id);
			$this->db->update('master_bentuk_makanan', $data); 
			return true;
		}


		function soft_delete_bentuk_makanan($id){
			$this->db->set('active', '1', FALSE);
			$this->db->where('id',$id);
			$this->db->update('master_bentuk_makanan');
			return true;
		}

		function soft_active_bentuk_makanan($id){
			$this->db->set('active', '0', FALSE);
			$this->db->where('id',$id);
			$this->db->update('master_bentuk_makanan');
			return true;
		}

		function insert($data){
			return $this->db->insert('master_bentuk_makanan', $data);
			
		}

	}
?>
