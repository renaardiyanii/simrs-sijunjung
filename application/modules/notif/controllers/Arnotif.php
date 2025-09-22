<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arnotif extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_notif', '', TRUE);
	}

	public function index()
	{
		$getN = $this->M_notif->get_allowed_notif();
		if ($getN->num_rows() > 0) {
			$totn = 0;
			$resultp = [];
			$resultd = [];
			foreach ($getN->result() as $ndata) {
				$resultd['nid'] = $ndata->notif_id;
				$this->db->db_debug = false;
				if (!@$this->db->query("$ndata->notif_query")) {
					$error = $this->db->error();
					$resultd['countn'] = 0;
					$totn += 0;
				} else {
					$resultd['countn'] = $this->db->query("$ndata->notif_query")->row()->total;
					$totn += $this->db->query("$ndata->notif_query")->row()->total;
				}

				$resultp[] = $resultd;
			}
			$this->db->db_debug = true;
			$result['totn'] = $totn;
			$result['data'] = $resultp;
			$result['stsn'] = 1;
			echo json_encode($result);
		} else {
			$result['stsn'] = 0;
		}
	}
}
