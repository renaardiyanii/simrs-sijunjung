<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmviewtindakan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_viewtindakan(){
			return $this->db->query("SELECT idtindakan, nmtindakan,deleted  FROM jenis_tindakan ORDER BY idtindakan");
		}

		function get_all_viewtindakanby($data){
			return $this->db->query("SELECT idtindakan, nmtindakan,deleted  FROM jenis_tindakan WHERE idpok1 like '$data%' ORDER BY idtindakan");
		}

		function get_data_viewtindakan($idtindakan){
			return $this->db->query("SELECT idtindakan, nmtindakan, kelas, total_tarif, tarif_alkes, paket,a.deleted  FROM jenis_tindakan a, tarif_tindakan b WHERE a.idtindakan=b.id_tindakan AND idtindakan='$idtindakan'");
		}
		
	}
?>