<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpasien extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    function show($no_medrec) 
    {     
        $this->db->from('data_pasien');
        $this->db->where('no_medrec',$no_medrec);         
        $query = $this->db->get();
        return $query->row();
    }

    function pelayanan($no_register) 
    {
        if (substr($no_register,0,2) == 'RJ') {
            $this->db->select('*,DATE(a.tgl_kunjungan) as date_tgl_kunjungan');
            $this->db->from('daftar_ulang_irj as a');
            $this->db->join('data_pasien as b', 'a.no_medrec = b.no_medrec', 'inner');
            $this->db->join('poliklinik as c', 'a.id_poli = c.id_poli', 'left');
            $this->db->where('no_register',$no_register); 
        } 
        if (substr($no_register,0,2) == 'RI') {
            $this->db->from('pasien_iri as a');
            $this->db->join('data_pasien as b', 'a.no_medrec = b.no_medrec', 'inner'); 
            $this->db->where('no_ipd',$no_register); 
        }               
        $query = $this->db->get();
        return $query->row();
    }

    function get_poli_bpjs($poli_bpjs) 
    {     
        $this->db->from('poliklinik');
        $this->db->where('poli_bpjs',$poli_bpjs);         
        $query = $this->db->get();
        return $query->row();
    }
}