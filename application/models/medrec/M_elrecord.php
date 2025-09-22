<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_elrecord extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function get_data_pasien($no_medrec){
		return $this->db->query("SELECT * FROM data_pasien WHERE no_medrec='$no_medrec'");
	}

	function get_kunj_rj($no_medrec){
		return $this->db->query("SELECT a.id_poli, a.no_register , a.tgl_kunjungan , b.nm_poli , c.nm_dokter , d.diagnosa FROM daftar_ulang_irj as a LEFT JOIN poliklinik as b ON a.id_poli = b.id_poli LEFT JOIN data_dokter as c ON a.id_dokter = c.id_dokter LEFT JOIN diagnosa_pasien as d ON( a.no_register = d.no_register AND d.klasifikasi_diagnos = 'utama') WHERE a.no_medrec = '$no_medrec' ORDER BY tgl_kunjungan DESC");
	}

	function get_kunj_ri($no_medrec){
		return $this->db->query("SELECT a.no_ipd , a.tgl_masuk , a.idrg , b.nmruang , a.dokter , c.nm_diagnosa FROM pasien_iri AS a LEFT JOIN ruang as b ON a.idrg = b.idrg LEFT JOIN icd1 as c ON a.diagnosa1 = c.id_icd WHERE no_cm = '$no_medrec'");
	}

	function get_kunj_farmasi($no_medrec){
		return $this->db->query("SELECT 
		    a.tgl_kunjungan,
		    a.nama_obat,
		    a.no_register,
		    a.qty,
		    a.cara_bayar,
		    IF(bed='Rawat Jalan' or bed='Rawat Darurat',(select nm_poli from poliklinik where id_poli=a.idrg),(select nmruang from ruang where idrg=a.idrg)) as nmruang,
		    b.no_cm
		FROM
		    resep_pasien a, data_pasien b
    	where a.no_medrec=b.no_medrec and b.no_medrec = '$no_medrec'");
	}

	function get_data_lab($no_medrec){
		return $this->db->query("SELECT 
		    a.tgl_kunjungan,
		    a.jenis_tindakan,
		    a.no_register,
		    a.qty,
		    a.cara_bayar,
		    a.idrg as nmruang,
		    b.no_cm
		FROM
		    pemeriksaan_laboratorium a, data_pasien b
		    where a.no_medrec=b.no_medrec AND  b.no_medrec = '$no_medrec'");
	}

	function get_data_rad($no_medrec){
		return $this->db->query("SELECT 
		    a.tgl_kunjungan,
		    a.jenis_tindakan,
		    a.no_register,
		    a.qty,
		    a.cara_bayar,
		    a.idrg as nmruang,
		    b.no_cm
		FROM
		    pemeriksaan_radiologi a, data_pasien b
		    where a.no_medrec=b.no_medrec AND  b.no_medrec = '$no_medrec'");
	}

	function get_data_ok($no_medrec){
		return $this->db->query("SELECT 
		    a.tgl_kunjungan,
		    a.jenis_tindakan,
		    a.no_register,
		    a.qty,
            (SELECT nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
		    a.cara_bayar,
		    IF(bed='Rawat Jalan' or bed='Rawat Darurat',(select nm_poli from poliklinik where id_poli=a.idrg),(select nmruang from ruang where idrg=a.idrg)) as nmruang,
		    b.no_cm
		FROM
		    pemeriksaan_operasi a, data_pasien b
		    where a.no_medrec=b.no_medrec AND  b.no_medrec = '$no_medrec'");
	}
}
