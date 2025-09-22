<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Pamkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register  AND  pasien_luar.cetak_kwitansi='0' AND b.no_pa is not NULL 
			GROUP BY no_pa,no_cm ,tgl, b.no_register, b.no_medrec, pasien_luar.nama
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_patologianatomi b, data_pasien 
				WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_pa is not NULL
				GROUP BY no_pa,no_cm ,tgl, b.no_register, b.no_medrec, data_pasien.nama
				ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND (b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%') AND  pasien_luar.cetak_kwitansi='0' AND b.no_pa is not NULL 
			GROUP BY no_pa,tgl, b.no_register, b.no_medrec, pasien_luar.nama
			UNION 
			SELECT data_pasien.no_cm as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
			FROM pemeriksaan_patologianatomi b, data_pasien 
			WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_pa is not NULL 
			GROUP BY no_cm,no_pa,tgl, b.no_register, b.no_medrec, data_pasien.nama  ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, nama, count(1) AS banyak 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register
			AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date'  
			AND  pasien_luar.cetak_kwitansi='0' 
			AND b.no_pa is not NULL 
			GROUP BY no_pa,tgl, b.no_register, b.no_medrec, nama
							UNION 
							SELECT data_pasien.no_cm as no_cm, b.no_pa, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
							FROM pemeriksaan_patologianatomi b, data_pasien 
							WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec 
							AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date' 
							AND b.cara_bayar='UMUM'  
							AND  b.cetak_kwitansi='0' 
							AND b.no_pa is not NULL 
							GROUP BY no_cm, no_pa,tgl, b.no_register, b.no_medrec, data_pasien.nama ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_pa){
			return $this->db->query("
			SELECT 
					dp.no_cm AS no_cm, 
					a.no_medrec, 
					a.no_register, 
					dp.nama, 
					dp.alamat AS alamat, 
					a.tgl_kunjungan AS tgl, 
					a.kelas, 
					a.cara_bayar, 
					a.idrg AS ruang, 
					DATE_PART('day', a.tgl_kunjungan - dp.tgl_lahir) AS tgl_lahir 
				FROM 
					pemeriksaan_patologianatomi a
				JOIN 
					data_pasien dp ON a.no_medrec::int = dp.no_medrec 
				WHERE 
					a.no_pa = $no_pa
				GROUP BY 
					a.no_pa, dp.no_cm, a.no_medrec, a.no_register, dp.nama, dp.alamat, 
					a.tgl_kunjungan, a.kelas, a.cara_bayar, a.idrg, dp.tgl_lahir;

			");
		}

		function get_data_pemeriksaan($no_pa){
			return $this->db->query("SELECT jenis_tindakan, biaya_pa, qty, vtot FROM pemeriksaan_patologianatomi WHERE no_pa='$no_pa'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_pa, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET cetak_kwitansi='1' WHERE no_pa='$no_pa'");
			$this->db->query("UPDATE pa_header SET diskon='$diskon' WHERE no_pa='$no_pa'");
			return true;
		}

		function update_status_cetak_kwitansi_bynoreg($diskon, $no_register, $xuser){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET cetak_kwitansi='1', xuser='$xuser', xupdate=now() WHERE no_register='$no_register'");
			$this->db->query("UPDATE pa_header SET diskon='$diskon' WHERE no_register='$no_register'");
			return true;
		}
		
	}
?>