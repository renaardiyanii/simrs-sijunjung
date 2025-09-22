<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_pasien(){
			return $this->db->get("pasienonline");
		}

		function get_umur($no_medrec){
			// return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
			return $this->db->query("SELECT DATE_PART('year', now()) - DATE_PART('year',tgl_lahir) AS umurday FROM data_pasien where no_medrec=$no_medrec");
		}

		function delete_pasien_online($id)
		{
			return $this->db->where('id',$id)
			->delete('pasienonline');

		}

		function get_nama_by_nocm($nocm)
		{
			return $this->db->where('no_cm',$nocm)->get('data_pasien');
		}
	}
?>
