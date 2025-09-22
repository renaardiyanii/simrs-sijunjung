<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmdokter extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_dokter(){
			// return $this->db->query("SELECT a.id_dokter, a.nm_dokter, a.nipeg, a.ket, a.kode_dpjp_bpjs,b.id_poli, a.klp_pelaksana,a.deleted ,
			//                        (SELECT nm_poli FROM poliklinik where id_poli=b.id_poli) as nm_poli FROM data_dokter as a 
			// 	LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter 
			// 	ORDER BY id_dokter");
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter, a.nipeg, a.ket, a.kode_dpjp_bpjs,a.klp_pelaksana,deleted
			            FROM data_dokter a				
                        ORDER BY a.id_dokter");

		}

		function get_all_dokter_poli()
		{
			return $this->db->query("SELECT DISTINCT a.id_dokter, a.nm_dokter, a.nipeg, a.ket, a.kode_dpjp_bpjs,a.klp_pelaksana,a.deleted,b.id_poli,c.nm_poli,c.poli_bpjs,a.nm_dokter
			FROM data_dokter a
			LEFT JOIN dokter_poli as b
			on b.id_dokter = a.id_dokter	
			LEFT JOIN poliklinik as c
			on c.id_poli = b.id_poli			
			ORDER BY a.id_dokter");
		}

		function get_data_dokter($id_dokter){
			return $this->db->query("SELECT *, a.id_dokter as id_dokter, (SELECT nm_poli from poliklinik WHERE id_poli=b.id_poli limit 1) as nm_poli FROM data_dokter a LEFT JOIN dokter_poli b on a.id_dokter=b.id_dokter where a.id_dokter='$id_dokter'");
		}

		function get_dokter($nm_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE nm_dokter='$nm_dokter'");
		}
		function get_all_biaya(){
			return $this->db->query("SELECT * FROM jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and kelas='III' and (nmtindakan like '%Konsul%' or nmtindakan like '%PERIKSA%')");
		}
		

		function delete_dokter_poli($id_poli,$id_dokter){
			return $this->db->query("DELETE FROM dokter_poli WHERE id_dokter='$id_dokter' and id_poli='$id_poli'");
		}

		function delete_dokter($id_dokter,$data){
			$this->db->where('id_dokter', $id_dokter);
			$this->db->update('data_dokter', $data); 
			return true;
		}

		function active_dokter($id_dokter,$data){
			$this->db->where('id_dokter', $id_dokter);
			$this->db->update('data_dokter', $data); 
			return true;
		}

		function insert_dokter($data){
			$this->db->set('deleted',0);
			$this->db->insert('data_dokter', $data);
			return true;
		}

		function insert_dokter_poli($data){
			$this->db->insert('dokter_poli', $data);
			return true;
		}

		function edit_dokter($id_dokter, $data){
			$this->db->where('id_dokter', $id_dokter);
			$this->db->update('data_dokter', $data); 
			return true;
		}


		public function get_nm_poli($id_poli)
		{
			return $this->db->query("SELECT * FROM poliklinik where id_poli = '$id_poli' ");
		}

		function get_all_dokter_user()
		{
			return $this->db->query("SELECT name,data_dokter.id_dokter,hmis_users.userid,data_dokter.nm_dokter,dyn_user_dokter.id as id_relasi FROM data_dokter
			LEFT JOIN dyn_user_dokter on dyn_user_dokter.id_dokter = data_dokter.id_dokter
			LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid
			WHERE data_dokter.deleted = 0
			AND data_dokter.ket NOT LIKE 'PERAWAT%'
			ORDER BY data_dokter.nm_dokter asc  ")->result();
		}

		function get_dyn_user_dokter_by_id_dokter($id_dokter)
		{
			$this->db->where('id_dokter',$id_dokter);
			return $this->db->get('dyn_user_dokter');
		}

		function update_dyn_user_dokter($id_dokter,$data)
		{
			$this->db->where('id_dokter',$id_dokter);
			$this->db->update('dyn_user_dokter',$data);
			return 201;
		}

		function insert_dyn_user_dokter($data)
		{
			$this->db->insert('dyn_user_dokter',$data);
			return 200;
		}

		function get_all_dokter_none_spesialis()
		{
			return $this->db->query("SELECT * FROM data_dokter WHERE ket NOT LIKE '%Eksekutif' AND deleted=0 AND ket NO LIKE = 'PERAWAT%'")->result();
		}

		function get_all_hmis_users()
		{
			return $this->db->query('SELECT * FROM hmis_users')->result();
		}

		function delete_dyn_user_dokter_by_id($id)
		{
			return $this->db->query("DELETE FROM dyn_user_dokter WHERE id=$id");
		}
	}
?>
