<?php
class Rimdokter extends CI_Model {

	public function select_all_data_dokter(){
		$data=$this->db->query("select *
			from data_dokter 
			where nm_dokter <> ''
			and deleted=0
			order by nm_dokter asc
			");
		return $data->result_array();
	}


	public function select_all_data_dokter_tambah($noreg){
		$data=$this->db->query("
			select *
			from data_dokter 
			where nm_dokter <> '' and id_dokter!=(select id_dokter from pasien_iri where no_ipd='$noreg')
			and deleted=0
			order by nm_dokter asc
			");
		return $data->result_array();
	}

	public function select_all_data_dokter_pasien($noreg){
		$data=$this->db->query("Select 0 as id_drtambahan, cast(id_dokter as integer), no_ipd, 'DPJP' as ket, 
		(select nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as nm_dokter 
		from pasien_iri where no_ipd='$noreg'
		UNION ALL 
		select cast(id_drtambahan as integer), cast(id_dokter as integer), no_register,ket,
		(select nm_dokter from data_dokter where id_dokter=cast(drtambahan_iri.id_dokter as integer)) as nm_dokter 
		from drtambahan_iri where no_register='$noreg'
			");
		return $data->result_array();
	}

	public function select_drtambahan_iri($noreg) {
		$data = $this->db->query("SELECT 
		CASE 
		  WHEN SUBSTR(ket, 0, 15) = 'Dokter Bersama' THEN SUBSTR(ket, 1, 15)
		  ELSE ket
		END AS modified_ket,
		(SELECT nm_dokter 
		 FROM data_dokter 
		 WHERE id_dokter = CAST(drtambahan_iri.id_dokter AS INTEGER)) AS nm_dokter 
	  FROM drtambahan_iri 
	  WHERE 
		no_register = '$noreg' 
		AND ket NOT IN ('dokter_jaga', 'case_manager', 'dokter_ruangan')
	  GROUP BY modified_ket, nm_dokter;
	  
	  ");

		return $data->result_array();
	}

	public function select_mutasi_pasien_backup($no_ipd) {
		$data = $this->db->query("SELECT
			b.nmruang
		FROM
			ruang_iri AS a,
			ruang AS b
		WHERE
			no_ipd = '$no_ipd'
			AND statkeluarrg = 'pindah'
			AND a.idrg = b.idrg");

		return $data->result_array();
	}

	public function select_mutasi_pasien($no_ipd) {
		$data = $this->db->query("SELECT b.nmruang FROM ruang_iri AS a, ruang AS b WHERE a.no_ipd = '$no_ipd' AND a.statkeluarrg = 'pindah' AND a.idrg = b.idrg");
		return $data->result_array();
	}

	public function insert_dokter_bersama($data){
		$this->db->insert('drtambahan_iri', $data);
		return $this->db->insert_id();
	}

	public function change_drbersama($id){
		$this->db->query("DELETE FROM drtambahan_iri WHERE id_drtambahan='$id'");
		return true;
	}

	public function hapus_drbersama($id){
		$this->db->query("DELETE FROM drtambahan_iri WHERE id_drtambahan='$id'");
		return true;
	}

	// added aldi
	function select_user_dokter_all()
	{
		return $this->db->query('SELECT d.id_dokter,data_dokter.kode_dpjp_bpjs,data_dokter.nm_dokter FROM dyn_user_dokter as d left join data_dokter on d.id_dokter = data_dokter.id_dokter');
	}

	public function select_all_data_perawat(){
		$data=$this->db->query("select *
			from data_dokter 
			where klp_pelaksana = 'PERAWAT' 
			and deleted=0
			order by nm_dokter asc
			");
		return $data->result_array();
	}
}
?>