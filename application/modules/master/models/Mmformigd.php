<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmformigd extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get($id=""){
			if($id != ''){
				return $this->db->where('id',$id)->get('master_form_igd');
			}
			return $this->db->get('master_form_igd');
			
		}

		function get_role_form($id_role=""){
			if($id_role != ''){
				return $this->db->select('master_role_form_igd.id,master_role_form_igd.role , master_form_igd.nama,master_form_igd.id as id_form,master_form_igd.kode,master_form_igd.url_output')
				->join('master_form_igd','master_form_igd.id = master_role_form_igd.id_form')
				->where('master_role_form_igd.role',$id_role)
				->order_by('master_form_igd.urut','ASC')
				->get('master_role_form_igd');
			}
			return $this->db->select('master_role_form_igd.id,master_role_form_igd.role , master_form_igd.nama,master_form_igd.id as id_form,master_form_igd.kode,master_form_igd.url_output')
			->join('master_form_igd','master_form_igd.id = master_role_form_igd.id_form')
			->order_by('master_form_igd.urut','ASC')
			->get('master_role_form_igd');
		}

		function get_role_form_by_id_form($id_form){
			return $this->db->select('master_role_form_igd.id,master_role_form_igd.role , master_form_igd.nama')
				->join('master_form_igd','master_form_igd.id = master_role_form_igd.id_form')
				->where('master_role_form_igd.id_form',$id_form)
				->get('master_role_form_igd');
		}

		function delete_role_form($id){
			return $this->db->where('id',$id)->delete('master_role_form_igd');
		}
		
		
		function insert($data){
			return $this->db->insert('master_form_igd', $data);
			
		}

		function insert_role_form($data){
			return $this->db->insert('master_role_form_igd', $data);
			
		}

		function get_ppa(){
			return $this->db->query("SELECT user_ppa.*,ppa.ppa as ppa_name  FROM user_ppa
		LEFT JOIN ppa on user_ppa.ppa = ppa.id");
		}

		function get_form_by_kode($kode){
			return $this->db->where('kode',$kode)->get('master_form_igd');
		}

		function get_form_by_kode_irj($kode){
			return $this->db->where('kode',$kode)->get('master_form_irj');
		}
	}
?>
