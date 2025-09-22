<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Fisiomkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_fisio b, pasien_luar WHERE b.no_register=pasien_luar.no_register  AND  pasien_luar.cetak_kwitansi='0' AND b.no_fisio is not NULL GROUP BY no_fisio 
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_fisio b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_fisio is not NULL
				GROUP BY no_fisio 
				ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
				FROM pemeriksaan_fisio b, pasien_luar 
				WHERE b.no_register=pasien_luar.no_register AND (b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%') AND  pasien_luar.cetak_kwitansi='0' AND b.no_fisio is not NULL 
				GROUP BY no_fisio
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_fisio b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_fisio is not NULL 
				GROUP BY no_fisio  ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, nama, count(1) AS banyak FROM pemeriksaan_fisio b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(b.tgl_kunjungan,10)='$date'  AND  pasien_luar.cetak_kwitansi='0' AND b.no_fisio is not NULL GROUP BY no_fisio
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_fisio, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_fisio b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND left(b.tgl_kunjungan,10)='$date' AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_fisio is not NULL 
				GROUP BY no_fisio ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_fisio){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_fisio a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_fisio='$no_fisio' GROUP BY no_fisio");
		}

		function get_data_pemeriksaan($no_fisio){
			return $this->db->query("SELECT jenis_tindakan, biaya_fisio, qty, vtot FROM pemeriksaan_fisio WHERE no_fisio='$no_fisio'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_fisio, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_fisio SET cetak_kwitansi='1' WHERE no_fisio='$no_fisio'");
			$this->db->query("UPDATE fisio_header SET diskon='$diskon' WHERE no_fisio='$no_fisio'");
			return true;
		}

		function update_status_cetak_kwitansi_bynoreg($diskon, $no_register, $xuser){
			$this->db->query("UPDATE pemeriksaan_fisio SET cetak_kwitansi='1', xuser='$xuser', xupdate=now() WHERE no_register='$no_register'");
			$this->db->query("UPDATE fisio_header SET diskon='$diskon' WHERE no_register='$no_register'");
			return true;
		}
		
	}
?>