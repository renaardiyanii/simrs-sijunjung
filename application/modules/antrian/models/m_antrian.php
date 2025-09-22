<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_antrian extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    function get_panggilan_perawat($id_poli) 
    {     
        // return $this->db->where('waktu_masuk_poli','!= null')->get('daftar_ulang_irj');
        return $this->db->query("SELECT d.nama,hm.name,daftar_ulang_irj.no_register FROM daftar_ulang_irj
        left join data_pasien as d on d.no_medrec = daftar_ulang_irj.no_medrec
        left join hmis_users as hm on hm.userid::varchar = daftar_ulang_irj.pemeriksa_perawat 
         WHERE id_poli='$id_poli' 
         AND tgl_kunjungan::date = CURRENT_DATE 
         AND pemeriksa_perawat is not null
         
         ORDER BY waktu_masuk_poli DESC LIMIT 1");
    }

    function get_panggilan_dokter($id_poli)
    {
        return $this->db->query("SELECT d.nama,hm.name FROM daftar_ulang_irj
        left join data_pasien as d on d.no_medrec = daftar_ulang_irj.no_medrec
        left join hmis_users as hm on hm.userid::varchar = daftar_ulang_irj.pemeriksa_dokter 
         WHERE id_poli='$id_poli' 
         AND tgl_kunjungan::date = CURRENT_DATE 
         AND pemeriksa_dokter is not null
         ORDER BY waktu_masuk_dokter DESC LIMIT 1");
    }

    function get_poli($id_poli)
    {
        return $this->db->where('id_poli',$id_poli)->from('poliklinik')->get();
    }

    function get_count_peserta($id_poli)
    {
        return $this->db->query("SELECT COALESCE(COUNT(DISTINCT pemeriksa_perawat),0)+COALESCE(COUNT(DISTINCT pemeriksa_dokter),0) as count_peserta
        from daftar_ulang_irj
        WHERE tgl_kunjungan::date = CURRENT_DATE
        AND id_poli = '$id_poli'
        and pemeriksa_perawat is not null");
    }

    function get_detail_counter_peserta_perawat($id_poli)
    {
        return $this->db->query("SELECT DISTINCT ON (h.userid ) 
        h.name as perawat,
        h.userid as id_perawat,0 as id_dokter,'' as dokter,d.nama,daftar_ulang_irj.no_register as no_register,
                daftar_ulang_irj.waktu_masuk_poli
                        from daftar_ulang_irj
                        LEFT JOIN hmis_users as h on h.userid::varchar = daftar_ulang_irj.pemeriksa_perawat
                        left join data_pasien as d on d.no_medrec = daftar_ulang_irj.no_medrec
                        WHERE tgl_kunjungan::date = CURRENT_DATE
                        AND id_poli = '$id_poli'
                        and pemeriksa_perawat is not null
                        GROUP BY h.name,h.userid,d.nama,daftar_ulang_irj.waktu_masuk_poli,daftar_ulang_irj.no_register
                        ORDER BY h.userid,daftar_ulang_irj.no_register DESC");
    }

    function get_detail_counter_peserta_dokter($id_poli)
    {
        return $this->db->query("SELECT DISTINCT ON (h.userid ) 
        h.name as dokter,
        0 as id_perawat,'' as perawat,daftar_ulang_irj.pemeriksa_dokter as id_dokter,d.nama,daftar_ulang_irj.no_register as no_register,
                daftar_ulang_irj.waktu_masuk_dokter
                        from daftar_ulang_irj
                        LEFT JOIN hmis_users as h on h.userid::varchar = daftar_ulang_irj.pemeriksa_dokter
                        left join data_pasien as d on d.no_medrec = daftar_ulang_irj.no_medrec
                        WHERE tgl_kunjungan::date = CURRENT_DATE
                        AND id_poli = '$id_poli'
                        and pemeriksa_dokter is not null
                        GROUP BY h.name,h.userid,d.nama,daftar_ulang_irj.waktu_masuk_dokter,daftar_ulang_irj.no_register
                        ORDER BY h.userid,daftar_ulang_irj.no_register DESC");
    }

   
}