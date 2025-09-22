<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmhasilpa extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_tindakan_pa(){
			return $this->db->query("SELECT idtindakan, nmtindakan FROM jenis_tindakan WHERE idtindakan LIKE 'H%'");
		}

		function get_all_hasil_pa(){
			return $this->db->query("SELECT a.*, b.nmtindakan FROM jenis_hasil_pa AS a LEFT JOIN jenis_tindakan AS b ON a.id_tindakan=b.idtindakan ORDER BY a.id_tindakan, a.id_jenis_hasil_pa");
		}

		function insert_jenis_hasil_pa($data){
			$this->db->insert('jenis_hasil_pa', $data);
			return true;
		}

		function delete_jenis_hasil_pa($id_jenis_hasil_pa){
			return $this->db->query("DELETE FROM jenis_hasil_pa WHERE id_jenis_hasil_pa='$id_jenis_hasil_pa'");
		}
	}
?>
