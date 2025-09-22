<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_inacbg extends CI_Model {
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function config_inacbg()
    {
        return $this->db->query("select * from inacbg_config limit 1");
    } 

    public function update_config($data){
        $this->db->update('inacbg_config', $data);
        $this->db->limit(1);
        return true;        
    }  

    function get_coder_nik($username) 
    {
        $this->db->FROM('hmis_users');
        $this->db->SELECT('nik');   
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }                                       

    function claim_status($no_register) 
    {
        $this->db->FROM('inacbg_klaim');           
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    } 
    function check_klaim($no_sep) 
    {
        $this->db->FROM('inacbg_klaim');  
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->row();
    }      

    function delete_klaim($no_sep)
    {
        $this->db->where('no_sep', $no_sep);
        $this->db->delete('inacbg_klaim');
        return true;
    }   

    function insert_inacbg($data_insert)
    {          
        $this->db->insert('inacbg_klaim', $data_insert);
        return true;
    }   
    
    function update_klaim($data_update,$no_sep)
    {
        $this->db->where('no_sep', $no_sep);
        $this->db->update('inacbg_klaim', $data_update);
        return true;
    }      
    function kelompok_tarif() 
    {
        $this->db->FROM('inacbg_kel');  
        $this->db->ORDER_BY('order'); 
        $query = $this->db->get();
        return $query->result();
    }  

    public function get_incbg_klaim($tgl_awal, $tgl_akhir)
    {
        return $this->db->query("
            SELECT *,inacbg_klaim.no_sep,
            CASE 
                WHEN jenis_rawat = 2 THEN daftar_ulang_irj.vtot_bayar
                ELSE pasien_iri.total_bayar
            END as 'total_bayar'
            FROM `inacbg_klaim` 
                    LEFT JOIN daftar_ulang_irj ON inacbg_klaim.no_register=daftar_ulang_irj.no_register 
                    LEFT JOIN pasien_iri ON inacbg_klaim.no_register=pasien_iri.no_ipd
             WHERE `status_klaim` = 3 AND inacbg_klaim.tgl_pulang >= '$tgl_awal' AND inacbg_klaim.tgl_pulang <= '$tgl_akhir'
        ");
    }                         
}

?>