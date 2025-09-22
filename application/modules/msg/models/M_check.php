<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_check extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function check_user_login()
  {
    $userid = $this->session->userdata('userid');
    return $this->db->query("SELECT name FROM hmis_users WHERE userid=$userid")->row()->name;
    // return $userid;
  }

  function check_config_waba()
  {
    return $this->db->query("SELECT * FROM waba_config WHERE record_stat='Aktif'")->row();
  }

  function check_limit_harian()
  {
    $userid = $this->session->userdata('userid');
    return $this->db->query("SELECT count(*) as total FROM waba_response WHERE created_by_role=$userid AND response_code='200' AND date(created_date)=CURRENT_DATE")->row()->total;
  }

  function check_limit_bulan()
  {
    $userid = $this->session->userdata('userid');
    return $this->db->query("SELECT count(*) as total FROM waba_response WHERE created_by_role=$userid AND response_code='200' AND date_trunc('month',created_date)=date_trunc('month',CURRENT_DATE)")->row()->total;
  }

  public function check_created_tgl_token()
  {
    return $this->db->query("SELECT date_token_create as tgl FROM waba_config WHERE record_stat='Aktif'")->row()->tgl;
  }
}
