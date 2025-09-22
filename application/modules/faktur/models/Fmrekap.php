<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Fmrekap extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		// function get_rekap_faktur_irj(){
		// 	return $this->db->query("(SELECT daftar_ulang_irj.counter_kwitansi, daftar_ulang_irj.tgl_kunjungan as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi FROM daftar_ulang_irj, data_pasien, poliklinik, no_kwitansi where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and no_kwitansi.no_registrasi=daftar_ulang_irj.no_register and no_kwitansi.status is null and left(daftar_ulang_irj.tgl_kunjungan,10)=now() order by daftar_ulang_irj.xupdate desc )
		// 		UNION ALL
		// 		(
		// 		SELECT null as counter_kwitansi, pasien_luar.tgl_kunjungan as tgl_kunjungan, pasien_luar.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, null as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi FROM pasien_luar, data_pasien, poliklinik, no_kwitansi where no_kwitansi.no_registrasi=pasien_luar.no_register and no_kwitansi.status is null and left(pasien_luar.tgl_kunjungan,10)=now() order by pasien_luar.xupdate desc)
		// 		");
		// }

	function get_rekap_faktur_irj($date){
			return $this->db->query("SELECT
			daftar_ulang_irj.counter_kwitansi,
			no_kwitansi.tgl_cetak AS tgl_kunjungan,
			daftar_ulang_irj.no_register AS no_register,
			data_pasien.no_cm AS no_cm,
			data_pasien.nama AS nama,
			daftar_ulang_irj.cara_bayar AS cara_bayar,
			poliklinik.id_poli AS id_poli,
			poliklinik.nm_poli AS nm_poli,
			no_kwitansi.no_kwitansi,
			no_kwitansi.status,
			no_kwitansi.referensi
		FROM
			no_kwitansi,
			daftar_ulang_irj,
			data_pasien,
			poliklinik 
		WHERE
			daftar_ulang_irj.no_register = no_kwitansi.no_register 
			AND no_kwitansi.status IS NULL 
			AND no_kwitansi.jenis_kwitansi = 'Rawat Jalan' 
			AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			AND poliklinik.id_poli = daftar_ulang_irj.id_poli 
			--AND substr( no_kwitansi.tgl_cetak, 1, 10 ) = to_char( now( ), 'YYYY-MM-DD' )
			AND to_char(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
			AND daftar_ulang_irj.id_poli != 'BA00'
			");
		}

		function get_rekap_faktur_irj_by_cm($nocm) {
			return $this->db->query("SELECT
				daftar_ulang_irj.counter_kwitansi,
				no_kwitansi.tgl_cetak AS tgl_kunjungan,
				daftar_ulang_irj.no_register AS no_register,
				data_pasien.no_cm AS no_cm,
				data_pasien.nama AS nama,
				daftar_ulang_irj.cara_bayar AS cara_bayar,
				poliklinik.id_poli AS id_poli,
				poliklinik.nm_poli AS nm_poli,
				no_kwitansi.no_kwitansi,
				no_kwitansi.status,
				no_kwitansi.referensi
			FROM
				no_kwitansi,
				daftar_ulang_irj,
				data_pasien,
				poliklinik 
			WHERE
				daftar_ulang_irj.no_register = no_kwitansi.no_register 
				AND no_kwitansi.status IS NULL 
				AND no_kwitansi.jenis_kwitansi = 'Rawat Jalan' 
				AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
				AND poliklinik.id_poli = daftar_ulang_irj.id_poli 
				--AND substr( no_kwitansi.tgl_cetak, 1, 10 ) = to_char( now( ), 'YYYY-MM-DD' )
				--AND to_char(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
				AND data_pasien.no_cm LIKE '%$nocm%'
				AND daftar_ulang_irj.id_poli != 'BA00'");
		}

       	function get_rekap_faktur_irj_batal(){
			return $this->db->query("SELECT daftar_ulang_irj.counter_kwitansi, no_kwitansi.tgl_cetak as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli,no_kwitansi.no_kwitansi, no_kwitansi.user_cencel,no_kwitansi.tgl_cencel, no_kwitansi.ket FROM no_kwitansi, daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_register = no_kwitansi.no_register and no_kwitansi.status = 'batal' and no_kwitansi.jenis_kwitansi = 'Rawat Jalan' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and substr(no_kwitansi.tgl_cetak,1,10)=to_char(now(),'YYYY-MM-DD') order by daftar_ulang_irj.tgl_cetak_kw desc");
		}

		 function get_rekap_faktur_irj_by_date_batal($date){
			return $this->db->query("SELECT daftar_ulang_irj.counter_kwitansi, no_kwitansi.tgl_cetak as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli,no_kwitansi.no_kwitansi, no_kwitansi.user_cencel,no_kwitansi.tgl_cencel, no_kwitansi.ket FROM no_kwitansi, daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_register = no_kwitansi.no_register and no_kwitansi.status = 'batal' and no_kwitansi.jenis_kwitansi = 'Rawat Jalan' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and substr(no_kwitansi.tgl_cetak,1,10)= '$date' order by daftar_ulang_irj.tgl_cetak_kw desc");
		}

		function get_rekap_faktur_irj_by_date($date) {
			return $this->db->query("SELECT
			daftar_ulang_irj.counter_kwitansi,
			no_kwitansi.tgl_cetak AS tgl_kunjungan,
			daftar_ulang_irj.no_register AS no_register,
			data_pasien.no_cm AS no_cm,
			data_pasien.nama AS nama,
			daftar_ulang_irj.cara_bayar AS cara_bayar,
			poliklinik.id_poli AS id_poli,
			poliklinik.nm_poli AS nm_poli,
			no_kwitansi.no_kwitansi,
			no_kwitansi.user_cencel,
			no_kwitansi.tgl_cencel,
			no_kwitansi.ket,
			no_kwitansi.status,
			no_kwitansi.referensi
		FROM
			no_kwitansi,
			daftar_ulang_irj,
			data_pasien,
			poliklinik 
		WHERE
			daftar_ulang_irj.no_register = no_kwitansi.no_register 
			AND no_kwitansi.jenis_kwitansi = 'Rawat Jalan' 
			AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			AND poliklinik.id_poli = daftar_ulang_irj.id_poli 
			AND to_char(no_kwitansi.tgl_cetak, 'YYYY-MM-DD') = '$date' 
			AND daftar_ulang_irj.id_poli != 'BA00'
		ORDER BY
			daftar_ulang_irj.tgl_cetak_kw DESC");
		}
    		// function get_rekap_faktur_iri(){
		// 	return $this->db->query("SELECT a.tgl_masuk as tgl_kunjungan, 
		// 		a.no_ipd as no_register, b.no_cm as no_cm, 
		// 		b.nama as nama, a.carabayar as cara_bayar, 
		// 		(select nmruang from ruang where idrg=a.idrg) as nm_poli
		// 		, a.idrg as id_poli
		// 		FROM pasien_iri a, data_pasien b
		// 		where a.no_cm=b.no_medrec  
		// 		and left(a.tgl_masuk,10)=left(now(),10) 
		// 		and a.cetak_kwitansi='1'
		// 		order by a.tgl_cetak_kw desc");
		// }

       function get_rekap_faktur_iri(){
			return $this->db->query("SELECT
				a.no_register,
				a.no_kwitansi,
				a.idno_kwitansi,
				c.nama,
				c.carabayar,
				c.tgl_keluar,
				a.tgl_cetak,
				c.cetak_kwitansi,
				c.selisih_tarif,
				c.no_medrec,
				a.vtot_bayar,
				a.tunai,
				a.diskon,
				b.no_cm,
				CASE 
					WHEN (a.status = 'batal') THEN 'BATAL'
					ELSE 'BAYAR'
				END AS status,
				a.tgl_cencel 
			FROM
				no_kwitansi AS a, pasien_iri AS c, data_pasien AS b
			WHERE
				a.jenis_kwitansi = 'RI' AND a.no_register = c.no_ipd
				AND c.no_medrec = b.no_medrec
			ORDER BY
				a.tgl_cetak DESC");
		}
         
		function get_rekap_faktur_iri_by_cm($nocm) {
			return $this->db->query("SELECT
				a.no_register,
				a.no_kwitansi,
				a.idno_kwitansi,
				c.nama,
				c.carabayar,
				c.tgl_keluar,
				c.selisih_tarif,
				c.no_medrec,
				a.tgl_cetak,
				c.cetak_kwitansi,
				a.vtot_bayar,
				a.tunai,
				a.diskon,
				b.no_cm,
				CASE 
					WHEN (a.status = 'batal') THEN 'BATAL'
					ELSE 'BAYAR'
				END AS status,
				a.tgl_cencel 
			FROM
				no_kwitansi AS a, pasien_iri AS c, data_pasien AS b
			WHERE
				a.jenis_kwitansi = 'RI' AND a.no_register = c.no_ipd
				AND c.no_medrec = b.no_medrec
				AND b.no_cm LIKE '%$nocm%'
			ORDER BY
				a.tgl_cetak DESC");
		}

		function get_rekap_faktur_ird($date){
			return $this->db->query("SELECT A
				.no_medrec,
				A.no_register,
				A.cara_bayar,
				B.no_cm,
				A.tgl_kunjungan,
				B.nama 
			FROM
				daftar_ulang_irj A,
				data_pasien B 
			WHERE
				to_char(A.tgl_kunjungan, 'YYYY-MM-DD') = '$date' 
				AND A.no_medrec = B.no_medrec 
				AND a.id_poli = 'BA00'
			ORDER BY
				A.tgl_kunjungan DESC");

			// return $this->db->query("SELECT
			// 	daftar_ulang_irj.counter_kwitansi,
			// 	no_kwitansi.tgl_cetak AS tgl_kunjungan,
			// 	daftar_ulang_irj.no_register AS no_register,
			// 	data_pasien.no_cm AS no_cm,
			// 	data_pasien.nama AS nama,
			// 	daftar_ulang_irj.cara_bayar AS cara_bayar,
			// 	poliklinik.id_poli AS id_poli,
			// 	poliklinik.nm_poli AS nm_poli,
			// 	no_kwitansi.no_kwitansi,
			// 	no_kwitansi.status,
			// 	no_kwitansi.referensi
			// FROM
			// 	no_kwitansi,
			// 	daftar_ulang_irj,
			// 	data_pasien,
			// 	poliklinik 
			// WHERE
			// 	daftar_ulang_irj.no_register = no_kwitansi.no_register 
			// 	AND no_kwitansi.status IS NULL 
			// 	AND no_kwitansi.jenis_kwitansi = 'Rawat Jalan' 
			// 	AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			// 	AND poliklinik.id_poli = daftar_ulang_irj.id_poli 
			// 	AND daftar_ulang_irj.id_poli = 'BA00'
			// 	AND to_char(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '$date'");
		}

		function get_pasien_kwitansi_ird_by_date($date){
			return $this->db->query("SELECT A
				.no_medrec,
				A.no_register,
				A.cara_bayar,
				B.no_cm,
				A.tgl_kunjungan,
				B.nama 
			FROM
				daftar_ulang_irj A,
				data_pasien B 
			WHERE
				to_char(A.tgl_kunjungan, 'YYYY-MM-DD') = '$date' 
				AND A.no_medrec = B.no_medrec 
				AND a.id_poli = 'BA00'
			ORDER BY
				A.tgl_kunjungan DESC");

			// return $this->db->query("SELECT
			// 	daftar_ulang_irj.counter_kwitansi,
			// 	no_kwitansi.tgl_cetak AS tgl_kunjungan,
			// 	daftar_ulang_irj.no_register AS no_register,
			// 	data_pasien.no_cm AS no_cm,
			// 	data_pasien.nama AS nama,
			// 	daftar_ulang_irj.cara_bayar AS cara_bayar,
			// 	poliklinik.id_poli AS id_poli,
			// 	poliklinik.nm_poli AS nm_poli,
			// 	no_kwitansi.no_kwitansi,
			// 	no_kwitansi.status,
			// 	no_kwitansi.referensi
			// FROM
			// 	no_kwitansi,
			// 	daftar_ulang_irj,
			// 	data_pasien,
			// 	poliklinik 
			// WHERE
			// 	daftar_ulang_irj.no_register = no_kwitansi.no_register 
			// 	AND no_kwitansi.status IS NULL 
			// 	AND no_kwitansi.jenis_kwitansi = 'Rawat Jalan' 
			// 	AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			// 	AND poliklinik.id_poli = daftar_ulang_irj.id_poli 
			// 	AND daftar_ulang_irj.id_poli = 'BA00'
			// 	AND to_char(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '$date'");
		}
		// function get_pasien_kwitansi_irj_by_date($date){
		// 	return $this->db->query(" (SELECT daftar_ulang_irj.counter_kwitansi, daftar_ulang_irj.tgl_kunjungan as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi FROM daftar_ulang_irj, data_pasien, poliklinik, no_kwitansi where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and no_kwitansi.no_registrasi=daftar_ulang_irj.no_register and no_kwitansi.status is null and left(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.xupdate desc )
		// 		UNION ALL
		// 		(
		// 		SELECT null as counter_kwitansi, pasien_luar.tgl_kunjungan as tgl_kunjungan, pasien_luar.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, null as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi FROM pasien_luar, data_pasien, poliklinik, no_kwitansi where no_kwitansi.no_registrasi=pasien_luar.no_register and no_kwitansi.status is null and left(pasien_luar.tgl_kunjungan,10)='$date' order by pasien_luar.xupdate desc)");
		// }

function get_pasien_kwitansi_irj_by_date($date){
			return $this->db->query("SELECT daftar_ulang_irj.counter_kwitansi, no_kwitansi.tgl_cetak as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi FROM no_kwitansi, daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_register = no_kwitansi.no_register and no_kwitansi.status is null and no_kwitansi.jenis_kwitansi = 'Rawat Jalan' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and substr(no_kwitansi.tgl_cetak,1,10)= '$date'");
		}

function get_pasien_kwitansi_irj_by_date_batal($date){
			return $this->db->query("SELECT daftar_ulang_irj.counter_kwitansi, no_kwitansi.tgl_cetak as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli, no_kwitansi.no_kwitansi, no_kwitansi.user_cencel, no_kwitansi.tgl_cencel,no_kwitansi.ket FROM no_kwitansi, daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_register = no_kwitansi.no_registrasi and no_kwitansi.status is not null and no_kwitansi.jenis_kwitansi = 'RJ' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and left(no_kwitansi.tgl_cencel,10)= '$date' order by no_kwitansi.tgl_cencel desc");
		}		

	function get_pasien_kwitansi_iri_by_date($date){
		return $this->db->query("SELECT
			a.no_register,
			a.no_kwitansi,
			a.idno_kwitansi,
			c.nama,
			c.carabayar,
			c.tgl_keluar,
			c.selisih_tarif,
			c.no_medrec,
			a.tgl_cetak,
			a.vtot_bayar,
			a.tunai,
			a.diskon,
			CASE 
				WHEN (a.status = 'batal') THEN 'BATAL'
				ELSE 'BAYAR'
			END AS status,
			a.tgl_cencel 
		FROM
			no_kwitansi AS a, pasien_iri AS c
		WHERE
			a.jenis_kwitansi = 'RI' 
			AND a.no_register = c.no_ipd 
			AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
		ORDER BY
			a.tgl_cetak DESC");
// 			return $this->db->query("SELECT
// 	data_pasien.no_cm,
// 	data_pasien.nama,
// 	pasien_iri.no_ipd AS no_register,
// 	pasien_iri.tgl_keluar AS tgl_keluar,
// 	no_kwitansi.tgl_cetak AS tgl_kunjungan,
// 	pasien_iri.carabayar AS cara_bayar,
// 	( SELECT nmruang FROM ruang WHERE idrg = pasien_iri.idrg ) AS nm_poli,
// 	pasien_iri.idrg AS id_poli,
// 	no_kwitansi.no_kwitansi 
// FROM
// 	pasien_iri,
// 	data_pasien,
// 	no_kwitansi 
// WHERE
// 	pasien_iri.no_cm = data_pasien.no_medrec 
// 	AND pasien_iri.no_ipd = no_kwitansi.no_registrasi 
// 	AND no_kwitansi.jenis_kwitansi in ('RI','BPJS RI') 
// 	AND no_kwitansi.STATUS IS NULL 
// 	AND LEFT ( no_kwitansi.tgl_cetak, 10 ) = '$date'");
		}



function get_rekap_lab(){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.idrg ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_laboratorium b ,
				 data_pasien a 
				WHERE b.no_lab is not null
				AND b.no_medrec = a.no_medrec 
				AND LEFT(b.tgl_kunjungan , 10) = LEFT(now() , 10) 
				GROUP BY no_register ORDER BY tgl DESC");
		}
		
	function get_rekap_lab_by_date($date){
		return $this->db->query("SELECT
		b.no_medrec AS no_cm,
		b.idrg,
		C.tgl_cetak AS tgl,
		C.no_kwitansi,
		b.no_lab,
		b.no_register,
		b.no_medrec,
		A.nama,
		b.cara_bayar,
		b.cetak_kwitansi,
		b.cetak_hasil,
		COUNT ( 1 ) AS banyak 
	FROM
		pemeriksaan_laboratorium b,
		data_pasien A,
		lab_header d,
		no_kwitansi C 
	WHERE
		b.no_lab IS NOT NULL 
		AND b.no_register = C.no_register 
		AND b.no_lab::varchar = d.no_lab::varchar 
		AND substr(b.no_register,1,2) = 'RJ'
		AND C.jenis_kwitansi = 'Laboratorium' 
		AND C.status IS NULL 
		AND b.no_medrec = A.no_medrec  
		AND to_char(c.tgl_cetak,'YYYY-MM-DD') = '$date'
	GROUP BY
		b.no_lab,
		b.no_medrec,
		b.idrg,
		c.tgl_cetak,
		c.no_kwitansi,
		b.no_register,
		a.nama,
		b.cetak_kwitansi,
		b.cetak_hasil,
		b.cara_bayar UNION
	SELECT
		a.no_cm AS no_cm,
		b.idrg,
		C.tgl_cetak AS tgl,
		C.no_kwitansi,
		b.no_lab,
		b.no_register,
		b.no_medrec,
		A.nama,
		b.cara_bayar,
		b.cetak_kwitansi,
		b.cetak_hasil,
		COUNT ( 1 ) AS banyak 
	FROM
		pemeriksaan_laboratorium b,
		pasien_luar A,
		no_kwitansi C 
	WHERE
		b.no_lab IS NOT NULL 
		AND b.no_register = C.no_register 
		AND C.jenis_kwitansi = 'Laboratorium' 
		AND C.status IS NULL 
		AND substr(b.no_register,1,2) = 'PL'
		AND b.no_register = A.no_register
		AND to_char(c.tgl_cetak,'YYYY-MM-DD') = '$date'
	GROUP BY
		b.no_lab,
		b.no_medrec,
		b.idrg,
		c.tgl_cetak,
		c.no_kwitansi,
		b.no_register,
		a.nama,
		b.cetak_kwitansi,
		b.cetak_hasil,
		b.cara_bayar,
		a.no_cm");
	}

function get_rekap_lab_by_key(){
	return $this->db->query("SELECT
		b.no_medrec AS no_cm,
		b.idrg,
		C.tgl_cetak AS tgl,
		C.no_kwitansi,
		b.no_lab,
		b.no_register,
		b.no_medrec,
		A.nama,
		b.cara_bayar,
		b.cetak_kwitansi,
		b.cetak_hasil,
		COUNT ( 1 ) AS banyak 
	FROM
		pemeriksaan_laboratorium b,
		data_pasien A,
		lab_header d,
		no_kwitansi C 
	WHERE
		b.no_lab IS NOT NULL 
		AND b.no_register = C.no_register 
		AND b.no_lab::varchar = d.no_lab::varchar
		AND substr(b.no_register,1,2) = 'RJ'
		AND C.jenis_kwitansi = 'Laboratorium' 
		AND C.status IS NULL 
		AND b.no_medrec = A.no_medrec  
	GROUP BY
		b.no_lab,
		b.no_medrec,
		b.idrg,
		c.tgl_cetak,
		c.no_kwitansi,
		b.no_register,
		a.nama,
		b.cetak_kwitansi,
		b.cetak_hasil,
		b.cara_bayar UNION
	SELECT
		a.no_cm AS no_cm,
		b.idrg,
		C.tgl_cetak AS tgl,
		C.no_kwitansi,
		b.no_lab,
		b.no_register,
		b.no_medrec,
		A.nama,
		b.cara_bayar,
		b.cetak_kwitansi,
		b.cetak_hasil,
		COUNT ( 1 ) AS banyak 
	FROM
		pemeriksaan_laboratorium b,
		pasien_luar A,
		no_kwitansi C 
	WHERE
		b.no_lab IS NOT NULL 
		AND b.no_register = C.no_register 
		AND C.jenis_kwitansi = 'Laboratorium' 
		AND C.status IS NULL 
		AND substr(b.no_register,1,2) = 'PL'
		AND b.no_register = A.no_register
	GROUP BY
		b.no_lab,
		b.no_medrec,
		b.idrg,
		c.tgl_cetak,
		c.no_kwitansi,
		b.no_register,
		a.nama,
		b.cetak_kwitansi,
		b.cetak_hasil,
		b.cara_bayar,
		a.no_cm");
}
		
//  function get_rekap_lab_by_key(){
// 			return $this->db->query("SELECT
// 	b.no_medrec AS no_cm,
// 	b.idrg,
// 	c.tgl_cetak AS tgl,
// 	c.no_kwitansi,
// 	b.no_lab,
// 	b.no_register,
// 	b.no_medrec,
// 	a.nama,
// 	b.cetak_kwitansi,
// 	b.cetak_hasil,
// 	count( 1 ) AS banyak 
// FROM
// 	pemeriksaan_laboratorium b,
// 	data_pasien a, lab_header d,
// 	no_kwitansi c 
// WHERE
// 	b.no_lab IS NOT NULL 
// 	AND b.no_register = c.no_registrasi 
// 	AND b.no_lab = d.no_lab
// 	AND c.jenis_kwitansi = 'LAB' 
// 	and c.status is null
// 	AND b.no_medrec = a.no_medrec 
// 	AND LEFT(c.tgl_cetak,10) = LEFT(now(),10) 
// GROUP BY
// 	b.no_lab
// ORDER BY
// 	c.tgl_cetak");
// 		}


		function get_rekap_rad(){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.idrg ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_radiologi b ,
				 data_pasien a 
				WHERE b.no_rad is not null
				AND b.no_medrec = a.no_medrec 
				AND LEFT(b.tgl_kunjungan , 10) = LEFT(now() , 10) 
				GROUP BY no_register ORDER BY tgl DESC");
		}
		
		function get_rekap_rad_by_date($date){
			return $this->db->query("SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_rad,
				b.no_register,
				b.no_medrec,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil 
			FROM
				pemeriksaan_radiologi b,
				data_pasien A,
				no_kwitansi C 
			WHERE
				b.no_rad IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Radiologi' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'RJ'
				AND b.no_medrec = A.no_medrec 
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date' UNION
			SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_rad,
				b.no_register,
				a.no_cm,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil 
			FROM
				pemeriksaan_radiologi b,
				pasien_luar A,
				no_kwitansi C 
			WHERE
				b.no_rad IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Radiologi' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'PL'
				AND b.no_register = A.no_register
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date'");
		}
		
		function get_rekap_rad_by_key(){
			$date = date('Y-m-d');
			return $this->db->query("SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_rad,
				b.no_register,
				b.no_medrec,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil 
			FROM
				pemeriksaan_radiologi b,
				data_pasien A,
				no_kwitansi C 
			WHERE
				b.no_rad IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Radiologi' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'RJ'
				AND b.no_medrec = A.no_medrec 
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date' UNION
			SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_rad,
				b.no_register,
				a.no_cm,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil 
			FROM
				pemeriksaan_radiologi b,
				pasien_luar A,
				no_kwitansi C 
			WHERE
				b.no_rad IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Radiologi' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'PL'
				AND b.no_register = A.no_register
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date'");
		}

		function get_rekap_em_by_key() {
			$date = date('Y-m-d');
			return $this->db->query("SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_em,
				b.no_register,
				b.no_medrec,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil
			FROM
				pemeriksaan_elektromedik b,
				data_pasien A,
				no_kwitansi C 
			WHERE
				b.no_em IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Elektromedik' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'RJ'
				AND b.no_medrec = A.no_medrec 
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date' UNION
			SELECT
				b.idrg,
				C.tgl_cetak AS tgl,
				C.no_kwitansi,
				b.no_em,
				b.no_register,
				b.no_medrec,
				A.nama,
				b.cetak_kwitansi,
				b.cetak_hasil
			FROM
				pemeriksaan_elektromedik b,
				pasien_luar A,
				no_kwitansi C 
			WHERE
				b.no_em IS NOT NULL 
				AND b.no_register = C.no_register 
				AND C.jenis_kwitansi = 'Elektromedik' 
				AND C.status IS NULL 
				AND substr(b.no_register,1,2) = 'PL'
				AND b.no_register = A.no_register
				AND to_char( C.tgl_cetak, 'YYYY-MM-DD' ) = '$date'");
		}

		function get_rekap_em_by_date($date){
			return $this->db->query("SELECT
				b.no_medrec AS no_cm,
				b.idrg,
				c.tgl_cetak AS tgl,
				c.no_kwitansi,
				b.no_em,
				b.no_register,
				b.no_medrec,
				a.nama,
				b.cetak_kwitansi,
				b.cetak_hasil
			FROM
				pemeriksaan_elektromedik b,
				data_pasien a,
				no_kwitansi c 
			WHERE
				b.no_em IS NOT NULL 
				AND b.no_register = c.no_register
				AND c.jenis_kwitansi = 'Elektromedik'
				and c.status is null 
				AND substr(b.no_register,1,2) = 'RJ'
				AND b.no_medrec = a.no_medrec 
				AND to_char(c.tgl_cetak, 'YYYY-MM-DD') = '$date' UNION
			SELECT
				b.no_medrec AS no_cm,
				b.idrg,
				c.tgl_cetak AS tgl,
				c.no_kwitansi,
				b.no_em,
				b.no_register,
				b.no_medrec,
				a.nama,
				b.cetak_kwitansi,
				b.cetak_hasil
			FROM
				pemeriksaan_elektromedik b,
				pasien_luar a,
				no_kwitansi c 
			WHERE
				b.no_em IS NOT NULL 
				AND b.no_register = c.no_register 
				AND c.jenis_kwitansi = 'Elektromedik'
				and c.status is null 
				AND substr(b.no_register,1,2) = 'PL'
				AND b.no_register = a.no_register 
				AND to_char(c.tgl_cetak, 'YYYY-MM-DD') = '$date'");
		}

		function get_rekap_frm(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama,no_kwitamsi.no_kwitanasi as no_kwitanasi, count(1) AS banyak FROM resep_pasien b, pasien_luar, no_kwitansi WHERE b.no_register=pasien_luar.no_register AND b.no_register = no_kwitansi.no_registrasi and no_kwitansi.status is null AND left(pasien_luar.tgl_kunjungan,10)=left(now(),10) GROUP BY no_resep ORDER BY tgl DESC");
		}

		function get_rekap_frm_ir(){
			return $this->db->query("SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak FROM resep_pasien b, daftar_ulang_irj, data_pasien WHERE b.no_register=daftar_ulang_irj.no_register AND left(daftar_ulang_irj.tgl_kunjungan,10)=left(now(),10) AND data_pasien.no_medrec=daftar_ulang_irj.no_medrec AND daftar_ulang_irj.status_obat >= 1 GROUP BY no_resep ORDER BY tgl DESC");
		}

		function get_rekap_frm_date_ir($date){
			return $this->db->query("SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak FROM resep_pasien b, daftar_ulang_irj, data_pasien WHERE b.no_register=daftar_ulang_irj.no_register AND left(daftar_ulang_irj.tgl_kunjungan,10)='$date' AND data_pasien.no_medrec=daftar_ulang_irj.no_medrec AND daftar_ulang_irj.status_obat >= 1 GROUP BY no_resep ORDER BY tgl DESC");
		}

// function get_rekap_ok(){
// 			return $this->db->query("SELECT
// 	data_pasien.no_cm,
// 	b.idoperasi_header,
// 	no_kwitansi.tgl_cetak AS tgl,
// 	b.no_register,
// 	b.no_medrec,
// 	data_pasien.nama,
// 	no_kwitansi.no_kwitansi as no_kwitanasi,
// 	count( 1 ) AS banyak,
// 	b.no_ok 
// FROM
// 	pemeriksaan_operasi b,
// 	daftar_ulang_irj,
// 	data_pasien,
// 	no_kwitansi
// WHERE
// 	b.no_register = daftar_ulang_irj.no_register 
// 	AND LEFT ( no_kwitansi.tgl_cetak, 10 ) = LEFT ( now( ), 10 ) 
// 	AND data_pasien.no_medrec = daftar_ulang_irj.no_medrec 
// 	AND no_kwitansi.status is null
// 	AND daftar_ulang_irj.status_ok >= 1 and daftar_ulang_irj.no_register = no_kwitansi.no_registrasi and no_kwitansi.jenis_kwitansi = 'OK'
// GROUP BY
// 	b.no_ok
// UNION
// SELECT
// 	data_pasien.no_cm,
// 	b.idoperasi_header,
// 	no_kwitansi.tgl_cetak AS tgl,
// 	b.no_register,
// 	b.no_medrec,
// 	data_pasien.nama,
// 	no_kwitansi.no_kwitansi as no_kwitansi,
// 	count( 1 ) AS banyak,
// 	b.no_ok 
// FROM
// 	pemeriksaan_operasi b,
// 	pasien_iri,
// 	data_pasien,
// 	no_kwitansi 
// WHERE
// 	b.no_register = pasien_iri.no_ipd 
// 	AND LEFT ( no_kwitansi.tgl_cetak, 10 ) = LEFT ( now( ), 10 ) 
// 	AND data_pasien.no_medrec = pasien_iri.no_cm 
// 	AND pasien_iri.status_ok >= 1 
// 	AND no_kwitansi.status is null
// 	AND pasien_iri.no_ipd = no_kwitansi.no_registrasi and no_kwitansi.jenis_kwitansi = 'OK'
// GROUP BY
// 	idoperasi_header");
// 		}


// 		function get_rekap_ok_date($date){
// 			return $this->db->query("SELECT
// 	data_pasien.no_cm,
// 	b.idoperasi_header,
// 	no_kwitansi.tgl_cetak AS tgl,
// 	b.no_register,
// 	b.no_medrec,
// 	data_pasien.nama,
// 	no_kwitansi.no_kwitansi as no_kwitansi,
// 	count( 1 ) AS banyak,
// 	b.no_ok 
// FROM
// 	pemeriksaan_operasi b,
// 	daftar_ulang_irj,
// 	data_pasien,
// 	no_kwitans 
// WHERE
// 	b.no_register = daftar_ulang_irj.no_register 
// 	AND LEFT ( no_kwitansi.tgl_cetak, 10 ) = '$date'
// 	AND data_pasien.no_medrec = daftar_ulang_irj.no_medrec 
// 	AND no_kwitansi.status is null
// 	AND daftar_ulang_irj.status_ok >= 1 and daftar_ulang_irj.no_register = no_kwitansi.no_registrasi and no_kwitansi.jenis_kwitansi = 'OK'
// GROUP BY
// 	idoperasi_header
// UNION
// SELECT
// 	data_pasien.no_cm,
// 	b.idoperasi_header,
// 	no_kwitansi.tgl_cetak AS tgl,
// 	b.no_register,
// 	b.no_medrec,
// 	data_pasien.nama,
// 	no_kwitansi.no_kwitansi as no_kwitansi,
// 	count( 1 ) AS banyak,
// 	b.no_ok 
// FROM
// 	pemeriksaan_operasi b,
// 	pasien_iri,
// 	data_pasien,
// 	no_kwitansi 
// WHERE
// 	b.no_register = pasien_iri.no_ipd 
// 	AND LEFT ( no_kwitansi.tgl_cetak, 10 ) = '$date' 
// 	AND data_pasien.no_medrec = pasien_iri.no_cm 
// 	AND pasien_iri.status_ok >= 1 
// 	AND no_kwitansi.status is null
// 	AND pasien_iri.no_ipd = no_kwitansi.no_registrasi  and no_kwitansi.jenis_kwitansi = 'OK'
// GROUP BY
// 	idoperasi_header
// 				");
// 		}



		function get_rekap_ok(){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.idrg ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_operasi b ,
				 data_pasien a 
				WHERE b.no_ok is not null
				AND b.no_medrec = a.no_medrec 
				AND LEFT(b.tgl_kujungan , 10) = LEFT(now() , 10) 
				GROUP BY no_register ORDER BY tgl DESC");
		}
		
		function get_rekap_ok_by_date($date){
			return $this->db->query("SELECT
	b.no_medrec AS no_cm,
	b.idrg,
	c.tgl_cetak AS tgl,
	c.no_kwitansi,
	b.no_ok,
	b.no_register,
	b.no_medrec,
	a.nama,
	b.cetak_kwitansi,
	count( 1 ) AS banyak 
FROM
	pemeriksaan_operasi b,
	data_pasien a, operasi_header d,
	no_kwitansi c 
WHERE
	b.no_ok IS NOT NULL 
	AND b.no_register = c.no_registrasi 
	AND b.no_ok = d.idoperasi_header
	AND c.jenis_kwitansi = 'OK'
	and c.status is null 
	AND b.no_medrec = a.no_medrec 
	AND LEFT(c.tgl_cetak,10) = '$date' 
GROUP BY
	b.no_ok
ORDER BY
	c.tgl_cetak");
		}
		
	function get_rekap_ok_by_key(){
			return $this->db->query("SELECT
	b.no_medrec AS no_cm,
	b.idrg,
	c.tgl_cetak AS tgl,
	c.no_kwitansi,
	b.no_ok,
	b.no_register,
	b.no_medrec,
	a.nama,
	b.cetak_kwitansi,
	count( 1 ) AS banyak 
FROM
	pemeriksaan_operasi b,
	data_pasien a, operasi_header d,
	no_kwitansi c 
WHERE
	b.no_ok IS NOT NULL 
	AND b.no_register = c.no_registrasi 
	AND b.no_ok = d.idoperasi_header
	AND c.jenis_kwitansi = 'OK' 
	and c.status is null
	AND b.no_medrec = a.no_medrec 
	AND LEFT(c.tgl_cetak,10) = LEFT(now(),10) 
GROUP BY
	b.no_ok
ORDER BY
	c.tgl_cetak");
		}

		function get_data_pasien_by_noreg($noreg){
			return $this->db->query("SELECT * FROM pasien_iri a, data_pasien b 
			where a.no_cm=b.no_medrec and a.no_ipd='$noreg'");
		}

		function get_rekap_frm_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama,no_kwitansi.no_kwitansi, count(1) AS banyak FROM resep_pasien b, pasien_luar, no_kwitansi WHERE b.no_register=pasien_luar.no_register AND b.no_register = no_kwitansi.no_registrasi and no_kwitansi.status is null AND left(pasien_luar.tgl_kunjungan,10)='$date' GROUP BY no_resep ORDER BY tgl DESC");
		}

		function get_rekap_frm_by_key(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama,no_kwitansi.no_kwitansi, count(1) AS banyak FROM resep_pasien b, pasien_luar, no_kwitansi WHERE b.no_register=pasien_luar.no_register AND b.no_register = no_kwitansi.no_registrasi and no_kwitansi.status is null AND left(pasien_luar.tgl_kunjungan,10)=LEFT(now(),10) GROUP BY no_resep ORDER BY tgl DESC");
		}

		function get_rekap_pa(){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.no_pa ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_patologianatomi b ,
				 data_pasien a 
				WHERE b.no_pa is not null
				AND b.no_medrec = a.no_medrec 
				AND LEFT(b.tgl_kunjungan , 10) = LEFT(now() , 10) 
				GROUP BY no_pa ORDER BY tgl DESC");
		}
		function get_rekap_pa_by_date($date){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.no_pa ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_patologianatomi b ,
				 data_pasien a 
				WHERE b.no_pa is not null
				AND b.no_medrec = a.no_medrec 
				AND LEFT(b.tgl_kunjungan , 10) = '$date'
				GROUP BY no_pa ORDER BY tgl DESC");
		}
		function get_rekap_pa_by_key($key){
			return $this->db->query("SELECT b.no_medrec AS no_cm ,
				 b.idrg ,
				 b.tgl_kunjungan AS tgl ,
				 b.no_register ,
				 b.no_medrec ,
				 a.nama ,
				 b.cetak_kwitansi,
				 b.cetak_hasil,
				 count(1) AS banyak 
				FROM pemeriksaan_patologianatomi b ,
				 data_pasien a 
				WHERE b.no_pa is not null
				AND b.no_medrec = a.no_medrec 
				AND (b.no_register LIKE '%$key%' or b.no_medrec LIKE '%$key%')
				GROUP BY no_pa ORDER BY tgl DESC");
		}

		public function cencel_irj($no_kwitansi='', $keterangan='')
		{
			$this->cencel_no_kwitansi_rj($no_kwitansi, 'Rawat Jalan', $keterangan);
           //update daftar ulang
			 $no_register = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->no_register;

			 $this->db->where('no_register', $no_register);

			 $this->db->update('daftar_ulang_irj',['status' => 0, 'tgl_cetak_kw' => null, 'cetak_kwitansi' => 0]);
			 $this->db->update('pelayanan_poli',['bayar' => NULL, 'tgl_cetak_kw' => null,]);
		}

		public function cencel_irj_double($no_kwitansi='', $keterangan='')
		{
			$this->cencel_no_kwitansi($no_kwitansi, 'Rawat Jalan', $keterangan);

			// $no_register = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->no_registrasi;

			// $this->db->where('no_register', $no_register);

			// $this->db->update('daftar_ulang_irj',['status' => 0, 'tgl_cetak_kw' => null, 'cetak_kwitansi' => 0, 'status_obat' => 0, 'obat' => 1]);
		}

		public function retur_irj($no_kwitansi='', $jml='')
		{
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$tgl=date('Y-m-d H:i:s');
			$this->db->update('no_kwitansi', 
				['user_retur' => $user, 'tgl_retur' => $tgl, 'jml_retur' => $jml],
				['no_kwitansi' => $no_kwitansi]);
		}

		public function cencel_iri($no_kwitansi='', $keterangan='')
		{

			$this->cencel_no_kwitansi($no_kwitansi, 'RI', $keterangan);

			$no_register = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->no_register;
		
		    $this->db->where('no_ipd', $no_register);
			$this->db->update('pasien_iri',['tgl_cetak_kw' => null, 'cetak_kwitansi' => null,'obat' => 1]);
		//	$this->cencel_no_kwitansi($no_register, 'RI');
		}

		public function cencel_lab($no_lab, $lab)
		{
         	// if (substr($no_kwitansi,0,2) == 'LA') {
            // $this->cencel_no_kwitansi($no_kwitansi, 'LAB', $keterangan);
            // } else {
            //  $this->cencel_no_kwitansi($no_kwitansi, 'PL LAB', $keterangan);
            // }

			// $this->db->where('no_lab', $no_lab);
			// $this->db->update('lab_header',['tgl_cetak_kw' => null]);
			// return true;

			$this->db->where('no_lab', $no_lab);
			$this->db->update('pemeriksaan_laboratorium', $lab);
			return true;
		}

		public function cancel_lab_kwitansi($no_kwitansi, $data) {
			$this->db->where('no_kwitansi', $no_kwitansi);
			$this->db->update('no_kwitansi', $data);
			return true;
		}

		public function cencel_lab_double($no_kwitansi,$keterangan,$no_register,$no_lab)
		{

        //   print_r(substr($no_kwitansi,0,2));die();
        
         if (substr($no_kwitansi,0,2) == 'LA') {
            $this->cencel_no_kwitansi($no_kwitansi, 'LAB', $keterangan);
            } else {
             $this->cencel_no_kwitansi($no_kwitansi, 'PL LAB', $keterangan);
            }

           // $no_lab = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->referensi;

           
       //    $jenis_kwitansi = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->jenis_kwitansi;
         
       //    $no_lab = $this->db->get_where('lab_header', ['no_register' => $no_kwitansi])
          // print_r($no_lab);die();

			// $this->db->where('no_lab', $no_lab);
			// $this->db->update('lab_header',['tgl_cetak_kw' => null]);

			// $this->db->where('no_lab', $no_lab);
			// $this->db->update('pemeriksaan_laboratorium',['cetak_kwitansi' => 0]);
	
			
		}
	public function cencel_rad($no_rad, $rad)
	{
            //  if (substr($no_kwitansi,0,2) == 'RA') {
            // $this->cencel_no_kwitansi($no_kwitansi, 'RAD', $keterangan);
            // } else {
            //  $this->cencel_no_kwitansi($no_kwitansi, 'PL RAD', $keterangan);
            // }

			// $this->db->where('no_rad', $no_rad);
			// $this->db->update('rad_header',['tgl_cetak_kw' => null]);

			// $this->db->where('no_rad', $no_rad);
			// $this->db->update('pemeriksaan_radiologi',['cetak_kwitansi' => 0]);

			$this->db->where('no_rad', $no_rad);
			$this->db->update('pemeriksaan_radiologi', $rad);
			return true;
	}

	public function cancel_rad_kwitansi($no_kwitansi, $data) {
		$this->db->where('no_kwitansi', $no_kwitansi);
		$this->db->update('no_kwitansi', $data);
		return true;
	}

	public function cencel_em($no_em, $em) {
		$this->db->where('no_em', $no_em);
		$this->db->update('pemeriksaan_elektromedik', $em);
		return true;
	}

	public function cancel_em_kwitansi($no_kwitansi, $data) {
		$this->db->where('no_kwitansi', $no_kwitansi);
		$this->db->update('no_kwitansi', $data);
		return true;
	}

	public function cencel_ok($no_kwitansi='', $keterangan='',$no_register='',$no_ok='')
		{

        //   print_r($no_kwitansi);die();
            $this->cencel_no_kwitansi($no_kwitansi, 'OK', $keterangan);

           $no_ok= $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->referensi;
         
       //    $no_lab = $this->db->get_where('lab_header', ['no_register' => $no_kwitansi])
          // print_r($no_lab);die();

			$this->db->where('idoperasi_header', $no_ok);
			$this->db->update('operasi_header',['tgl_cetak_kw' => null]);

			$this->db->where('no_ok', $no_ok);
			$this->db->update('pemeriksaan_operasi',['cetak_kwitansi' => 0]);

         }


		public function cencel_no_kwitansi($no_kwitansi, $jenis_kwitansi, $keterangan)
		{
	    	$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$tgl=date('Y-m-d H:i:s');
		
		//	$ket = $keterangan;
		//	if ($jenis_kwitansi == 'RJ' or  $jenis_kwitansi == 'RI') {
		//		$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
		//	}else if($jenis_kwitansi == 'OK' or $jenis_kwitansi == 'LAB' or $jenis_kwitansi == 'RAD'){
		//		$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
		//	}else
		//	{
				$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
				//$where1 = ['no_ipd' => $no_kwitansi];
		//	}

          //   print_r($where);die();

			$this->db->update('no_kwitansi',
				['status' => "batal", 'user_cencel' => $user, 'tgl_cencel' => $tgl, 'ket' => $keterangan],
				$where
			);
			// $this->db->update('pasien_iri',
			// 	['cetak_kwitansi' => NULL],
			// 	$where1
			// );
		}

		public function cencel_no_kwitansi_rj($no_kwitansi, $jenis_kwitansi, $keterangan) {
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$tgl=date('Y-m-d H:i:s');
		
		//	$ket = $keterangan;
		//	if ($jenis_kwitansi == 'RJ' or  $jenis_kwitansi == 'RI') {
		//		$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
		//	}else if($jenis_kwitansi == 'OK' or $jenis_kwitansi == 'LAB' or $jenis_kwitansi == 'RAD'){
		//		$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
		//	}else
		//	{
				//$no_register = $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->no_register;
				$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
				//$where1 = ['trx_no' => $no_kwitansi];
		//	}

          //   print_r($where);die();

			$this->db->update('no_kwitansi',
				['status' => "batal", 'user_cencel' => $user, 'tgl_cencel' => $tgl, 'ket' => $keterangan],
				$where
			);
			// $this->db->update('registrasi',
			// 	['bayar' => NULL, 'tgl_cetak_kw' => NULL],
			// 	$where1
			// );
		}

		public function cencel_reg_iri($no_kwitansi)
		{
	    	// $login_data = $this->load->get_var("user_info");
			// $user = $login_data->username;
			// $tgl=date('Y-m-d H:i:s');
		
		//	$ket = $keterangan;
		//	if ($jenis_kwitansi == 'RJ' or  $jenis_kwitansi == 'RI') {
		//		$where = ['no_kwitansi' => $no_kwitansi, 'jenis_kwitansi' => $jenis_kwitansi];
		//	}else if($jenis_kwitansi == 'OK' or $jenis_kwitansi == 'LAB' or $jenis_kwitansi == 'RAD'){
			$no_register = $this->db->get_where('registrasi', ['trx_no' => $no_kwitansi])->row()->payment_bill;
		//	}else
		//	{ 
				$where = ['trx_no' => $no_kwitansi];
				//$where1 = ['no_ipd' => $no_kwitansi];
		//	}

          //   print_r($where);die();

			$this->db->update('registrasi',
				['is_cancel' => 1, 'cancel_nominal' => $no_register],
				$where
			);
			// $this->db->update('pasien_iri',
			// 	['cetak_kwitansi' => NULL],
			// 	$where1
			// );
		}

		public function cencel_farmasi($no_kwitansi,$keterangan,$no_register)
		{
	
	//     print_r($keterangan);die();		

	//	 $this->cencel_no_kwitansi($no_kwitansi, 'PL OBAT', $keterangan);

           $no_resep= $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->referensi;

      //     print_r($no_resep);die();
         
          $no_register= $this->db->get_where('no_kwitansi', ['no_kwitansi' => $no_kwitansi])->row()->no_registrasi;
       //    $no_lab = $this->db->get_where('lab_header', ['no_register' => $no_kwitansi])
        //   print_r($no_register);die();

			// $this->db->where('no_resep', $no_resep);
			// $this->db->update('resep_header',['tgl_cetak_kw' => null]);

			$this->db->where('no_register', $no_register);
			$this->db->update('pasien_luar',['cetak_kwitansi' => 0, 'tgl_cetak_kw' => null, 'user_cetak_kw' => null]);

			$this->cencel_no_kwitansi($no_kwitansi, 'PL OBAT', $keterangan);

		}

		function get_nominal_register($no_kwitansi)
		{
			return $this->db->query("SELECT * FROM registrasi where trx_no = '$no_kwitansi' ");
		}

		function cancel_mhas($no_kwitansi,$data)
		{
			$this->db->where('trx_no', $no_kwitansi);
			$this->db->update('registrasi',$data);
			return true;
		}
		
		function get_pasien_cetak_ulang_bill_ri_date($date) {
			return $this->db->query("SELECT 
				a.no_ipd,
				c.nama,
				c.no_cm,
				a.no_medrec,
				b.nmruang,
				c.sex,
				a.tgl_masuk,
				a.tgl_keluar,
				a.dokter,
				a.carabayar,
				a.selisih_tarif,
				a.no_sep
			FROM 
				pasien_iri AS a
				LEFT JOIN ruang AS b ON a.idrg = b.idrg 
				LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE 
				a.tgl_keluar IS NOT NULL 
				AND a.tgl_keluar = '$date'");
		}

		function get_pasien_cetak_ulang_bill_ri_mr($mr) {
			return $this->db->query("SELECT 
				a.no_ipd,
				c.nama,
				c.no_cm,
				a.no_medrec,
				b.nmruang,
				c.sex,
				a.tgl_masuk,
				a.tgl_keluar,
				a.dokter,
				a.carabayar,
				a.selisih_tarif,
				a.no_sep
			FROM 
				pasien_iri AS a
				LEFT JOIN ruang AS b ON a.idrg = b.idrg 
				LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE 
				a.tgl_keluar IS NOT NULL 
				AND c.no_cm LIKE '%$mr%'");
		}

		function get_pasien_cetak_ulang_bill_ri($tgl_awal, $tgl_akhir) {
			return $this->db->query("SELECT 
				a.no_ipd,
				c.nama,
				c.no_cm,
				a.no_medrec,
				b.nmruang,
				c.sex,
				a.tgl_masuk,
				a.tgl_keluar,
				a.dokter,
				a.carabayar,
				a.selisih_tarif,
				a.no_sep
			FROM 
				pasien_iri AS a
				LEFT JOIN ruang AS b ON a.idrg = b.idrg 
				LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE 
				a.tgl_keluar IS NOT NULL 
				AND a.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'");
		}

		function get_pasien_cetak_ulang_bill_ri_sep($sep) {
			return $this->db->query("SELECT 
				a.no_ipd,
				c.nama,
				c.no_cm,
				a.no_medrec,
				b.nmruang,
				c.sex,
				a.tgl_masuk,
				a.tgl_keluar,
				a.dokter,
				a.carabayar,
				a.selisih_tarif,
				a.no_sep
			FROM 
				pasien_iri AS a
				LEFT JOIN ruang AS b ON a.idrg = b.idrg 
				LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE 
				a.tgl_keluar IS NOT NULL 
				AND a.no_sep LIKE '%$sep%'");
		}

		function get_pasien_blm_selesai_admin($date) {
			return $this->db->query("SELECT 
				a.no_ipd,
				b.no_cm,
				b.nama,
				a.carabayar,
				a.tgl_masuk,
				a.tgl_keluar,
				b.sex,
				c.nmruang,
				a.dokter,
				CASE 
					WHEN(a.administrasi_tertunda = 1) THEN 'Belum Selesai'
					ELSE 'Selesai'
				END AS ket
			FROM 
				pasien_iri AS a
				LEFT JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
				LEFT JOIN ruang AS c ON a.idrg = c.idrg
			WHERE 
				a.administrasi_tertunda IN (1,2)
				AND to_char(a.tgl_keluar_resume, 'YYYY-MM') = '$date'");
		}

		function update_selesai_administrasi($data, $no_ipd) {
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}
	}
?>
