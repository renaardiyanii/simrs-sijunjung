<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmtindakan extends CI_Model{
		function __construct(){
			parent::__construct();
		}


		function get_all_tindakan_new(){
			return $this->db->query("SELECT idtindakan, nmtindakan,tmno,instalasi,deleted,tarif,keterangan FROM jenis_tindakan_new ORDER BY idtindakan");
		}

		function get_all_tindakan_download() {
			return $this->db->query("SELECT
				a.idtindakan,
				a.nmtindakan,
				CASE
					WHEN(a.deleted = 1) THEN 'NON-ACTIVE'
					ELSE 'ACTIVE'
				END AS deleted,
				a.kel_tindakan,
				a.sub_kelompok,
				a.kategori,
				a.satuan,
				a.idpok1,
				a.idpok2,
				a.idkel_tind,
				a.idkel_inacbg,
				a.lis,
				a.prosedur,
				a.modality,
				a.id_kategori,
				a.id_sub_kelompok,
				a.id_satuan,
				a.id_kel
				-- c.kelas,
				-- c.total_tarif,
				-- c.tarif_bpjs,
				-- c.tarif_iks
			FROM
				jenis_tindakan AS a
				-- LEFT OUTER JOIN tarif_tindakan AS c ON a.idtindakan = c.id_tindakan
			ORDER BY
				idtindakan");
		}

		function get_all_tarif_download() {
			return $this->db->query("SELECT
				c.id_tarif_tindakan,
				a.idtindakan,
				a.nmtindakan,
				c.kelas,
				c.total_tarif,
				c.tarif_bpjs,
				c.tarif_iks,
				c.jasa_rs,
				c.idrg
			FROM
				jenis_tindakan AS a
				LEFT OUTER JOIN tarif_tindakan AS c ON a.idtindakan = c.id_tindakan
			ORDER BY
				idtindakan");
		}

		function get_all_subkelompok() {
			return $this->db->query("SELECT * FROM master_subkelompok_tind");
		}

		function get_all_kategori() {
			return $this->db->query("SELECT * FROM master_kategori");
		}

		function get_all_satuan_tind() {
			return $this->db->query("SELECT * FROM master_satuan_tindakan");
		}

		function get_all_tindakan_rad() {
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idpok2 = 'LA'");
		}

		function get_data_edit_tindakan_rad($id) {
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan = '$id'");
		}

		function update_tindakan_rad($id_tindakan, $data) {
			$this->db->where('idtindakan', $id_tindakan);
			$this->db->update('jenis_tindakan', $data);
			return true;
		}

		function get_all_kel_tindakan(){
			return $this->db->query("SELECT *  FROM kel_tind ORDER BY idkel_tind");
		}

		function get_all_kel_tindakan_new(){
			return $this->db->query("SELECT *  FROM master_keltind");
		}

		function get_tindakan_byid($idtindakan){
			return $this->db->query("SELECT idtindakan, kelas, total_tarif, tarif_alkes FROM jenis_tindakan a, tarif_tindakan b WHERE a.idtindakan=b.id_tindakan AND idtindakan='$idtindakan' ORDER BY idtindakan ");
		}

		function insert_jenis_tindakan($data){
			$this->db->insert('jenis_tindakan', $data);
			return true;
		}

		function insert_tarif_tindakan($data){
			$this->db->insert('tarif_tindakan', $data);
			return true;
		}

		function get_data_tindakan($idtindakan){
			return $this->db->query("SELECT *  FROM jenis_tindakan a LEFT JOIN tarif_tindakan b on a.idtindakan=b.id_tindakan where a.idtindakan='$idtindakan'");
		}

		function get_data_tindakan_new($idtindakan){
			return $this->db->query("
			SELECT
				idtindakan,
				nmtindakan,
				tmno,
				instalasi,
				tarif,
				id_poli
			FROM
				jenis_tindakan_new a
			WHERE
				A.idtindakan = '$idtindakan'");
		}

		function return_tarif($id_tindakan, $kelas){
			return $this->db->query("SELECT id_tarif_tindakan FROM tarif_tindakan_new WHERE id_tindakan='$id_tindakan' AND kelas='$kelas'");
		}

		function edit_jenis_tindakan($idtindakan, $data){
			$this->db->where('idtindakan', $idtindakan);
			$this->db->update('jenis_tindakan', $data); 
		}
		function edit_tarif_tindakan($id_tarif_tindakan, $data){
			$this->db->where('id_tarif_tindakan', $id_tarif_tindakan);
			$this->db->update('tarif_tindakan', $data); 
			return true;
		}

		function delete_tindakan($id_tindakan){
			$this->db->query("DELETE FROM tarif_tindakan WHERE id_tindakan='$id_tindakan'");
			return $this->db->query("DELETE FROM jenis_tindakan WHERE idtindakan='$id_tindakan'");
		}
		
		function soft_delete_tindakan($id){
			$this->db->set('deleted', 1);
			$this->db->where('idtindakan',$id);
			$this->db->update('jenis_tindakan'); 
			return true;
		}

		function active_tindakan($id){
			$this->db->set('deleted', '0',false);
			$this->db->where('idtindakan',$id);
			$this->db->update('jenis_tindakan'); 
			return true;
		}

		function nonactive_tindakan($id) {
			$this->db->set('deleted', '1',false);
			$this->db->where('idtindakan',$id);
			$this->db->update('jenis_tindakan_new'); 
			return true;
		}

		function get_all_tindakan_inacbg(){
			return $this->db->query("SELECT idtindakan,nmtindakan,idkel_inacbg FROM jenis_tindakan ORDER BY idtindakan");
		}

		function get_all_kel_inacbg(){
			return $this->db->query("SELECT *  FROM inacbg_kel ORDER BY idkel_inacbg");
		}

		function edit_jenis_inacbg($idtindakan, $data){
			$this->db->where('idtindakan', $idtindakan);
			$this->db->update('jenis_tindakan', $data); 
		}

		function get_all_prosedur(){
			return $this->db->query("SELECT id_tind, nm_tindakan FROM icd9cm ORDER BY id_tind");
		}

		function get_id_poli(){
			return $this->db->query("SELECT substring(id_poli,1,2) as id_poli,nm_poli from poliklinik where id_poli != 'ME00' and id_poli != 'HA00' and id_poli != 'LA00'");
		}

		public function get_tindakan_by_by($id_poli)
		{
			$select = explode("-", $id_poli);
			$select_nm_poli=$select[0];
			$select_id_poli=$select[1];
			$id_poli = substr($select_id_poli,0,2);

			if ($select_nm_poli == 'semua') {
				return $this->db->query("SELECT * from jenis_tindakan");
			}elseif ($select_nm_poli == 'admin') {
				return $this->db->query("SELECT * from jenis_tindakan where idpok2 like '1B%' ");
			}elseif ($select_nm_poli == 'ruang') {
				return $this->db->query("SELECT * from jenis_tindakan where idpok2 like '1A%' ");
			}elseif ($select_nm_poli == 'ird') {
				return $this->db->query("SELECT * from jenis_tindakan where idpok2 like 'BA%' ");
			}elseif ($select_nm_poli == 'penunjang') {
				return $this->db->query("SELECT * from jenis_tindakan where idpok1 like '$select_id_poli%' ");
			}elseif ($select_nm_poli == 'poli') {
				return $this->db->query("SELECT * from jenis_tindakan where substring(a.idtindakan,1,2) like '$id_poli%' ");
			}else{
				return $this->db->query("SELECT * from jenis_tindakan");
			}

		}

		function get_modality() {
			return $this->db->query("SELECT * FROM jenis_rad WHERE kode_jenis != 'XA'");
		}

		function get_all_tindakan_tanpa_tarif(){
			return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					tmno,
					instalasi,
					deleted,
					tarif,
					keterangan,
					(select nm_poli from poliklinik where poliklinik.id_poli = jenis_tindakan_new.id_poli) as nmpoli
				FROM
					jenis_tindakan_new 
				WHERE
					idtindakan NOT LIKE'AC%' 
					AND idtindakan NOT LIKE'DD%' 
				ORDER BY
					idtindakan DESC");
		}

		function get_all_tindakan_dengan_tarif(){
			return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					tmno,
					instalasi,
					deleted,
					tarif,
					keterangan 
				FROM
					jenis_tindakan_new 
				WHERE
					idtindakan LIKE'AC%' 
					OR idtindakan LIKE'DD%' 
				ORDER BY
					idtindakan DESC");
		}

		function insert_jenis_tindakan_tanpa_tarif($data){
			$this->db->insert('jenis_tindakan_new', $data);
			return true;
		}

		function soft_delete_tindakan_new($id){
			$this->db->set('deleted', 1);
			$this->db->where('idtindakan',$id);
			$this->db->update('jenis_tindakan_new'); 
			return true;
		}

		function active_tindakan_new($id){
			$this->db->set('deleted', '0',false);
			$this->db->where('idtindakan',$id);
			$this->db->update('jenis_tindakan_new'); 
			return true;
		}

		
		function delete_tindakan_new($id){
			return $this->db->query("DELETE FROM jenis_tindakan_new WHERE idtindakan='$id'");
		}

		function edit_jenis_tindakan_new($idtindakan, $data){
			$this->db->where('idtindakan', $idtindakan);
			$this->db->update('jenis_tindakan_new', $data); 
		}

		function insert_tarif_tindakan_new($data){
			$this->db->insert('tarif_tindakan_new', $data);
			return true;
		}

		function get_data_tindakan_dgn_tarif($idtindakan){
			return $this->db->query("SELECT
					* 
				FROM
					jenis_tindakan_new
					A LEFT JOIN tarif_tindakan_new b ON A.idtindakan = b.id_tindakan 
				WHERE
					A.idtindakan = '$idtindakan'");
		}

		function edit_tarif_tindakan_new($id_tarif_tindakan, $data){
			$this->db->where('id_tarif_tindakan', $id_tarif_tindakan);
			$this->db->update('tarif_tindakan_new', $data); 
			return true;
		}

		function get_poliklinik(){
			return $this->db->query("SELECT id_poli,nm_poli from poliklinik order by nm_poli asc");
		}


		

	}
?>

