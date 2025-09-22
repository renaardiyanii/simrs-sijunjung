<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_notif extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_allowed_notif()
	{
		$userid = $this->session->userdata('userid');
		return $this->db->query("select dn.* from 
		  dyn_notif dn, 
		  dyn_role_user ru
			where ru.userid=$userid and
			(dn.roleid=ru.roleid or ru.roleid='1')
			order by dn.notif_id asc");
	}

	function get_allowed_notif_by_id($notif_id)
	{
		$queryn = $this->db->query("select notif_query from dyn_notif where notif_id=$notif_id")->row()->notif_query;
		return $this->db->query("$queryn")->num_rows();
	}
}
