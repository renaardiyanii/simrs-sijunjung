<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmjadwal extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	//master jadwal
	function get_all_dokter()
	{
		return $this->db->query("SELECT a.id_dokter, a.nm_dokter, a.nipeg, a.ket, b.id_poli, (SELECT nm_poli FROM poliklinik where id_poli=b.id_poli limit 1) as nm_poli FROM data_dokter as a 
				LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter 
				where a.deleted='0'
				ORDER BY id_dokter");
	}
	function get_all_jadwal()
	{
		return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir,a.status, b.nm_dokter, c.nm_poli, c.lokasi, b.deleted FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter INNER JOIN poliklinik as c ON a.id_poli=c.id_poli");
	}
	function display_jadwal()
	{
		return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir, b.nm_dokter, c.nm_poli, c.lokasi FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter and b.deleted=0 INNER JOIN poliklinik as c ON a.id_poli=c.id_poli");
	}
	function get_data_jadwal($id)
	{
		return $this->db->query("SELECT a.id, a.id_dokter, a.id_poli, a.hari, a.awal, a.akhir, b.nm_dokter, c.nm_poli, b.deleted FROM jadwal_dokter as a 
				INNER JOIN data_dokter as b ON a.id_dokter=b.id_dokter  INNER JOIN poliklinik as c ON a.id_poli=c.id_poli WHERE a.id=$id");
	}


	//function get_jam($id_dokter){
	//	return $this->db->query("SELECT *, ")
	//}

	function get_jadwal($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter WHERE nm_dokter='$nm_dokter'");
	}
	function delete_jadwal_dokter($id)
	{
		return $this->db->query("DELETE FROM jadwal_dokter WHERE id='$id'");
	}
	function soft_delete_jadwal_dokter($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('jadwal_dokter', $data);
		return true;
	}
	function insert_jadwal_dokter($data)
	{
		$this->db->insert('jadwal_dokter', $data);
		return true;
	}

	function edit_jadwal($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('jadwal_dokter', $data);
		return true;
	}
	function active_jadwal_dokter($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('jadwal_dokter', $data);
		return true;
	}

	function jadwalSebulan()
	{
		return $this->db->select('jadwal_dokter.* , data_dokter.nm_dokter,poliklinik.nm_poli,CASE when jadwal_dokter.status = \'1\' then \'aktif\' else \'Tidak Aktif\' end statusjadwal')
			->join('poliklinik', 'poliklinik.id_poli = jadwal_dokter.id_poli')
			->join('data_dokter', 'data_dokter.id_dokter = jadwal_dokter.id_dokter')
			->where("TO_CHAR(tgl,'YYYY-MM') = TO_CHAR(now(), 'YYYY-MM')")->get('jadwal_dokter');
	}

	function getallpoli()
	{
		return $this->db->select('id_poli,nm_poli')->get('poliklinik');
	}

	function getDokter($poli)
	{
		return $this->db->select('data_dokter.id_dokter,data_dokter.nm_dokter')
			->from('dokter_poli')
			->join('poliklinik', 'poliklinik.id_poli = dokter_poli.id_poli')
			->join('data_dokter', 'data_dokter.id_dokter = dokter_poli.id_dokter')
			->where('dokter_poli.id_poli', $poli)
			->get();
	}

	function insertJadwalDokterBatch($data)
	{
		return $this->db->insert_batch('jadwal_dokter', $data);
	}

	function updateJadwalDokterBatch($data, $id)
	{
		unset($data['id']);
		return $this->db->where('id', $id)->update('jadwal_dokter', $data);
	}

	function hapusJadwalDokter($id)
	{
		return $this->db->where('id', $id)->delete('jadwal_dokter');
	}
}
