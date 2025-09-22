<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Pammaster extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_tindakan(){
			return $this->db->query("SELECT a.idtindakan,a.nmtindakan,b.kode,b.nm_kode,b.jenis,b.nm_jenis FROM jenis_tindakan_pa AS a LEFT JOIN pa_kode_jenis_tindakan AS b ON a.idtindakan=b.idtindakan ORDER BY a.nmtindakan ASC");
		}
		function get_all_jenis(){
			return $this->db->query("SELECT * FROM pa_jenis");
		}
		function get_all_kode(){
			return $this->db->query("SELECT * FROM pa_kode");
		}

		function get_data_tindakan($idtindakan){
			return $this->db->query("SELECT a.idtindakan,a.nmtindakan,b.id as id_kode_jenis_tindakan,b.kode,b.nm_kode,b.jenis,b.nm_jenis FROM jenis_tindakan_pa AS a LEFT JOIN pa_kode_jenis_tindakan AS b ON a.idtindakan=b.idtindakan WHERE a.idtindakan='$idtindakan'");
		}

		function insert_tindakan($data){
			$this->db->insert('pa_kode_jenis_tindakan', $data);
			return true;
		}

		function edit_tindakan($id, $data){
			$this->db->where('id', $id);
			$this->db->update('pa_kode_jenis_tindakan', $data); 
			return true;
		}

		function get_nm_jenis($jenis){
			return $this->db->query("SELECT nama FROM pa_jenis WHERE id='$jenis'");
		}

		function get_nm_kode($kode){
			return $this->db->query("SELECT kode FROM pa_kode WHERE id='$kode'");
		}
	}
?>
