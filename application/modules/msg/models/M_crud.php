<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_crud extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function insert_history_waba($data)
  {
    $this->db->insert('waba_response', $data);
    return true;
  }

  function get_history()
  {
    return $this->db->query("SELECT wp.*,dr.role FROM waba_response wp LEFT JOIN dyn_role dr ON wp.created_by_role=dr.id WHERE date(created_date)=CURRENT_DATE ORDER BY created_date DESC")->result();
  }

  function get_history_by_date($tgl)
  {
    return $this->db->query("SELECT wp.*,dr.role FROM waba_response wp LEFT JOIN dyn_role dr ON wp.created_by_role=dr.id WHERE date(created_date)='$tgl' ORDER BY created_date DESC")->result();
  }
}
