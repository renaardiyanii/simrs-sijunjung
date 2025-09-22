<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmjadwal extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jadwal
		function get_all_dokter(){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter, a.nipeg, a.ket, b.id_poli, (SELECT nm_poli FROM poliklinik where id_poli=b.id_poli) as nm_poli FROM data_dokter as a 
				LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter 
				where a.deleted='0'
				ORDER BY id_dokter");
		}
		function get_all_jadwal(){
			return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir, b.nm_dokter, c.nm_poli, c.lokasi, b.deleted FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter INNER JOIN poliklinik as c ON a.id_poli=c.id_poli");
		}
		function display_jadwal(){
			return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir, b.nm_dokter, c.nm_poli, c.lokasi FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter and b.deleted=0 INNER JOIN poliklinik as c ON a.id_poli=c.id_poli");
		}
		function get_data_jadwal($id){
			return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir, b.nm_dokter, c.nm_poli, b.deleted FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter  INNER JOIN poliklinik as c ON a.id_poli=c.id_poli WHERE a.id=$id");
		}

		
		//function get_jam($id_dokter){
		//	return $this->db->query("SELECT *, ")
		//}

		function get_jadwal($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE nm_dokter='$nm_dokter'");
		}
		function delete_jadwal_dokter($id){
			return $this->db->query("DELETE FROM jadwal_dokter WHERE id='$id'");
		}
		function insert_jadwal_dokter($data){
			$this->db->insert('jadwal_dokter', $data);
			return true;
		}

		function edit_jadwal($id, $data){
			$this->db->where('id', $id);
			$this->db->update('jadwal_dokter', $data); 
			return true;
		}
	}
?>
