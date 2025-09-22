<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmpemasok extends CI_Model{
    function __construct(){
    parent::__construct();
  }

  function cari_pemasok(){
    return $this->db->query("SELECT * FROM suppliers ORDER BY person_id");
  }
   function cari_jenis(){
    return $this->db->query("SELECT * FROM obat_jenis where kelompok = 'PEMBELIAN' ORDER BY id_jenis");
  }
  function cari_pemasok_bhp(){
    return $this->db->query("SELECT * FROM suppliers where type='BHP' ORDER BY person_id");
  }
  function get_pemasok(){
    return $this->db->query("SELECT person_id, company_name, account_number, adress, phone, zip_code FROM suppliers ORDER BY person_id ");
  }

   function get_jenis(){
    return $this->db->query("SELECT id_jenis, nm_jenis FROM obat_jenis ORDER BY id_jenis ");
  }

  function get_pemasok_bhp(){
    return $this->db->query("SELECT person_id, company_name, account_number, adress, phone, zip_code FROM suppliers where type='BHP' ORDER BY person_id ");
  }
  function get_company(){
    return $this->db->query("SELECT company_name FROM suppliers ORDER BY person_id");
  }
  function get_company_name($receiving_id){
    return $this->db->query("SELECT receivings.supplier_id, suppliers.company_name from suppliers, receivings where receivings.supplier_id=suppliers.person_id and receivings.receiving_id='$receiving_id'");
  }

   function get_nm_jenis($receiving_id){
    return $this->db->query("SELECT receivings.id_jenis, obat_jenis.nm_jenis from obat_jenis, receivings where receivings.id_jenis=obat_jenis.id_jenis and receivings.receiving_id='$receiving_id'");
  }

  function get_company_name_new($id){
    return $this->db->query("SELECT receivings.supplier_id, suppliers.company_name from suppliers, receivings where receivings.supplier_id=suppliers.person_id and receivings.receiving_id='$id'");
  }

  function get_company_name_byidsupplier($supplier_id){
    return $this->db->query("SELECT company_name from suppliers where person_id='$supplier_id'");
  }
  function get_account_numb(){
    return $this->db->query("SELECT account_number FROM suppliers ORDER BY person_id");
  }
  function get_data_supplier($person_id){
    return $this->db->query("SELECT * FROM suppliers WHERE person_id=$person_id'");
  }

  function insert_supplier($data){
    $this->db->insert('suppliers', $data);
    return true;
  }
}
?>
