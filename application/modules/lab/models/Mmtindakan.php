<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmtindakan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_tindakan(){
			return $this->db->query("SELECT idtindakan, nmtindakan  FROM jenis_tindakan ORDER BY idtindakan");
		}

		function get_all_kel_tindakan(){
			return $this->db->query("SELECT *  FROM kel_tind ORDER BY idkel_tind");
		}

		function get_tindakan($idtindakan){
			return $this->db->query("SELECT*FROM jenis_tindakan WHERE idtindakan='$idtindakan'");
		}

		function get_tindakan_byid($idtindakan){
			return $this->db->query("SELECT idtindakan, kelas, total_tarif, tarif_alkes FROM jenis_tindakan a, tarif_tindakan b WHERE a.idtindakan=b.id_tindakan AND idtindakan='$idtindakan' ORDER BY idtindakan");
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
			return $this->db->query("SELECT idtindakan, nmtindakan, kelas, total_tarif, tarif_alkes, paket, idkel_tind  FROM jenis_tindakan a LEFT JOIN tarif_tindakan b on a.idtindakan=b.id_tindakan where a.idtindakan='$idtindakan'");
		}

		function return_tarif($id_tindakan, $kelas){
			return $this->db->query("SELECT id_tarif_tindakan FROM tarif_tindakan WHERE id_tindakan='$id_tindakan' AND kelas='$kelas'");
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

		//INACBG
		//

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

		//LAB

		function get_all_tindakan_lab(){
			return $this->db->query("SELECT idtindakan,nmtindakan,lis FROM jenis_tindakan WHERE idpok1='H' ORDER BY idtindakan");
		}

		function edit_tindakan_lab_lis($idtindakan, $data){
			$this->db->where('idtindakan', $idtindakan);
			$this->db->update('jenis_tindakan', $data); 
		}
		
	}
?>

