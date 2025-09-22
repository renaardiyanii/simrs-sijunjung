<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbpjs extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }
    function get_data_bpjs() 
    {
        $this->db->from('bpjs_config');
        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
    public function update_bpjs($data_bpjs) 
    {
        $this->db->update('bpjs_config', $data_bpjs);
        $this->db->limit(1);
        return true;        
    }   
    function show_hide_secid($user,$password){
        $this->db->from('hmis_users');
        $this->db->select('*');
        $this->db->where('username', $user);
        $this->db->where('password', $password);
        $query = $this->db->get();
        return $query->result();
    }


    /// IRJ ///
    function hapussep_irj($no_sep)
    {      
        $data['no_sep'] = NULL;        
        $this->db->where('no_sep', $no_sep);
        $this->db->update('daftar_ulang_irj', $data);
    }

    function updatetglplg_irj($nosep,$data_update) 
    {
      $this->db->where('no_sep', $nosep);
      $this->db->update('daftar_ulang_irj', $data_update);
    }

    function update_sep_irj($no_register,$data_update)
    {
        $this->db->where('no_register', $no_register);
        $this->db->update('daftar_ulang_irj', $data_update);
        return true;
    }

    // function update_sep($no_sep,$data_update)
    // {
    //     $this->db->where('no_sep', $no_sep);
    //     $this->db->update('bpjs_sep', $data_update);
    //     return true;
    // }



    /// IRI ///
    function get_pasien_iri($no_ipd)
    {
        $this->db->FROM('pasien_iri');
        $this->db->SELECT('*');
        $this->db->WHERE('pasien_iri.no_ipd', $no_ipd);
        $query = $this->db->get();
        return $query->row();      
    } 
    function pasien_iri($no_sep)
    {
        $this->db->FROM('pasien_iri');
        $this->db->SELECT('*');
        $this->db->WHERE('pasien_iri.no_sep', $no_sep);
        $query = $this->db->get();
        return $query->row();      
    }  
    function update_sep_iri($no_register,$data_update)
    {
        $this->db->where('no_ipd', $no_register);
        $this->db->update('pasien_iri', $data_update);
        return true;
    }
    function rincian_irj($no_register) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->SELECT('*');
        $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
        $this->db->JOIN('kontraktor', 'daftar_ulang_irj.id_kontraktor = kontraktor.id_kontraktor', 'left');
        $this->db->WHERE('daftar_ulang_irj.no_register', $no_register);
        $query = $this->db->get();
        return $query->row();      
    } 
    function insert_sep($data)
    {
        $result = $this->db->insert('bpjs_sep', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function show_sep_irj($no_register) 
    {
        $this->db->from('daftar_ulang_irj');    
        $this->db->join('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
        $this->db->join('bpjs_sep', 'daftar_ulang_irj.no_sep = bpjs_sep.no_sep', 'inner');
        $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();      
    } 
    function show_pelayanan_iri($no_ipd) 
    {
        $this->db->from('pasien_iri');    
        $this->db->join('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');        
        $this->db->where('no_ipd', $no_ipd);
        $query = $this->db->get();
        return $query->row();      
    } 

    function hapussep_iri($no_sep)
    {      
        $data['no_sep'] = NULL;        
        $this->db->where('no_sep', $no_sep);
        $this->db->update('pasien_iri', $data);
    }
    function updatetglplg_iri($nosep,$data_update) 
    {
      $this->db->where('no_sep', $nosep);
      $this->db->update('pasien_iri', $data_update);
    }

    //////////////// SEP ///////////////////////
    function update($no_register,$data_update)
    {
        $this->db->where('no_register', $no_register);
        $this->db->update('daftar_ulang_irj', $data_update);
        return true;
    }
}