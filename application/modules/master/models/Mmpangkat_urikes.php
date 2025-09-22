<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmpangkat_urikes extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_pangkat_urikes(){
			return $this->db->query("SELECT * FROM tni_pangkat_urikes where deskripsi!='delete' ORDER BY urutan ");
		}

		function get_data_pangkat_urikes($id){
			return $this->db->query("SELECT * FROM tni_pangkat_urikes WHERE pangkat_id='$id' and deskripsi!='delete'");
		}	

		function get_tingkat_pangkat_urikes(){
			return $this->db->query("SELECT intensif FROM tni_pangkat_urikes where deskripsi!='delete' group by intensif ");
		}
		function get_kelompok_pangkat_urikes(){
			return $this->db->query("SELECT pokpangkat FROM tni_pangkat_urikes where deskripsi!='delete' group by pokpangkat ");
		}
		function get_urutan_pangkat_urikes(){
			return $this->db->query("SELECT pangkat, urutan from tni_pangkat_urikes where deskripsi!='delete' GROUP BY urutan order by urutan ");
		}				
	
		function delete_pangkat_urikes($id){
			return $this->db->query("UPDATE tni_pangkat_urikes SET deskripsi='delete' WHERE pangkat_id='$id'");
		}

		function insert_pangkat_urikes($data){
			$this->db->insert('tni_pangkat_urikes', $data);
			return true;
		}

		function edit_pangkat_urikes($id, $data){
			$this->db->where('pangkat_id', $id);
			return $this->db->update('tni_pangkat_urikes', $data); ;
		}

	}
?>
