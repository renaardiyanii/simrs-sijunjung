<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmform extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get($id=""){
			if($id != ''){
				return $this->db->where('id',$id)->get('master_form');
			}
			return $this->db->get('master_form');
			
		}

		function get_role_form($id_role=""){
			if($id_role != ''){
				return $this->db->query("SELECT master_role_form.id,master_role_form.role, 
				master_form.nama,master_form.id as id_form, master_form.kode,
				 master_form.url_output, master_form.views
				  FROM master_role_form JOIN master_form ON master_form.id = master_role_form.id_form
				   WHERE master_role_form.role = '$id_role' ORDER BY master_role_form.no_urut ASC");
			}
			return $this->db->select('master_role_form.id,master_role_form.role , master_form.nama,master_form.id as id_form,master_form.kode,master_form.url_output, master_form.views')
			->join('master_form','master_form.id = master_role_form.id_form')
			->get('master_role_form');
		}

		function get_role_form_by_id_form($id_form){
			return $this->db->select('master_role_form.id,master_role_form.role , master_form.nama')
				->join('master_form','master_form.id = master_role_form.id_form')
				->where('master_role_form.id_form',$id_form)
				->get('master_role_form');
		}

		function delete_role_form($id){
			return $this->db->where('id',$id)->delete('master_role_form');
		}
		
		
		function insert($data){
			return $this->db->insert('master_form', $data);
			
		}

		function insert_role_form($data){
			return $this->db->insert('master_role_form', $data);
			
		}

		function get_ppa(){
			return $this->db->query("SELECT user_ppa.*,ppa.ppa as ppa_name  FROM user_ppa
		LEFT JOIN ppa on user_ppa.ppa = ppa.id");
		}

		function get_form_by_kode($kode){
			return $this->db->where('kode',$kode)->get('master_form');
		}

		function get_form_by_kode_ok($kode){
			return $this->db->where('kode',$kode)->get('master_form_ok');
		}
	}
?>
