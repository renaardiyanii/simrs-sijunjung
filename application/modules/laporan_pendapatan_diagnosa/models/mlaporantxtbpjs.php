<?php
class Mlaporantxtbpjs extends CI_Model {

    function get_laporan_txt_ranap($bln){
        $data=$this->db->query("SELECT
        *,
        ( SELECT nm_poli FROM poliklinik WHERE laporan_txt_bpjs_rawat_inap.id_poli = poliklinik.id_poli ) AS nm_poli 
    FROM
        laporan_txt_bpjs_rawat_inap 
    WHERE
        tgl_keluar LIKE'$bln%'");
        return $data->result();
    }
    
}
?>