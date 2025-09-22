<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rimipgedung extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_ipgedung($ip_user, $ruang_pasien_now)
	{
		return $this->db->query("SELECT * FROM master_ip_gedung WHERE ip_gedung='$ip_user' and idrg='$ruang_pasien_now'");
	}

	function get_ruangan_pasien_terakhir($no_ipd)
	{
		return $this->db->query("SELECT idrg FROM pasien_iri where no_ipd='$no_ipd' LIMIT 1");
	}

	function get_dokter_khusus($no_ipd, $id_dokter)
	{
		return $this->db->query("SELECT * FROM drtambahan_iri where no_register='$no_ipd' and ket='case_manager' and id_dokter='$id_dokter' LIMIT 1");
	}
}
