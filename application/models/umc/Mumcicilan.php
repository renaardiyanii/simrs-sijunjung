<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mumcicilan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_all_pasien_cicilan_irj($dateawal,$dateakhir){
			return $this->db->query("SELECT
				a.*, b.*, c.*, d.*, e.*, f.id_loket, f.no_kwitansi, f.batal, f.retur from um_cicilan a
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				JOIN data_pasien c ON b.no_medrec=c.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				LEFT join nomor_kwitansi f ON a.idno_kwitansi=f.idno_kwitansi
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}

		function get_all_pasien_cicilan_iri($dateawal,$dateakhir){
			return $this->db->query("SELECT
				* from um_cicilan a
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				JOIN data_pasien c ON b.no_medrec=c.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}

		function get_pasien_kwitansi($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and LEFT(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.cara_bayar desc");
		}

		function get_data_cicilan_noreg($noreg){
			return $this->db->query("SELECT * FROM um_cicilan where no_register='$noreg'");
		}

		function get_max_cicilan_ke($noreg){
			return $this->db->query("SELECT IFNULL(max(cicilan_ke),0) as last_cicilan from um_cicilan where no_register='$noreg'");
		}

		function get_detail_pasien($no_medrec){
			return $this->db->query("SELECT
				*, (select count(*) from nomor_kwitansi where no_register=b.no_register GROUP BY no_register) as cicilan_ke
				from data_pasien a
				JOIN daftar_ulang_irj b ON b.no_medrec=a.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}
	}
?>