<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msep extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    function show($no_register) 
    {         
        if (substr($no_register,0,2) == 'RJ') {   
            $this->db->from('daftar_ulang_irj');        
            $this->db->join('bpjs_sep', 'daftar_ulang_irj.no_sep = bpjs_sep.no_sep', 'inner');   
            $this->db->where('daftar_ulang_irj.no_register', $no_register);
        } 
        if (substr($no_register,0,2) == 'RI') {
            $this->db->from('pasien_iri');        
            $this->db->join('bpjs_sep', 'pasien_iri.no_sep = bpjs_sep.no_sep', 'inner'); 
            $this->db->where('no_ipd', $no_register);
        }             
        $query = $this->db->get();
        return $query->row();      
    } 

    function update($no_sep,$data_update)
    {
        $this->db->where('no_sep', $no_sep);
        $this->db->update('bpjs_sep', $data_update);
        return true;
    }

    function update_cetakan($no_sep)
    {
        $this->db->query("UPDATE bpjs_sep SET cetakan=cetakan+1 WHERE no_sep = '$no_sep'");
    }

    function get_autocomplete($q){   
        $query=$this->db->query("
            SELECT data_pasien.no_cm,data_pasien.nama,daftar_ulang_irj.no_register,daftar_ulang_irj.no_sep FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec = daftar_ulang_irj.no_medrec WHERE daftar_ulang_irj.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
            UNION
            SELECT data_pasien.no_cm,data_pasien.nama,pasien_iri.no_ipd as no_register,pasien_iri.no_sep FROM data_pasien JOIN pasien_iri ON data_pasien.no_medrec = pasien_iri.no_cm WHERE pasien_iri.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec limit 100"
        );
        if($query->num_rows() > 0){
          foreach ($query->result_array() as $row){
            $new_row['label']=htmlentities(stripslashes($row['no_cm'].' - '.$row['nama']));
            $new_row['value']=htmlentities(stripslashes($row['no_sep']));
            $new_row['no_cm'] = sprintf("%06d",$row['no_cm']);
            $new_row['nama']=htmlentities(stripslashes($row['nama']));          
            $new_row['no_register']=htmlentities(stripslashes($row['no_register']));
            $new_row['no_sep']=htmlentities(stripslashes($row['no_sep']));
            $row_set[] = $new_row;
          }
          echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }
    function insert_manual($noRegister,$noSep)
    {
        $this->db->set('no_sep', $noSep);
        if (substr($noRegister,0,2) == 'RJ') {
            $this->db->where('no_register', $noRegister);
            $this->db->update('daftar_ulang_irj');
        }
        if (substr($noRegister,0,2) == 'RI') {
            $this->db->where('no_ipd', $noRegister);
            $this->db->update('pasien_iri');
        }
        return true;
    }
}