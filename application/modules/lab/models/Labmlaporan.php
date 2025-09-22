<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Labmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		/////////laporan pemeriksaan
		function get_lap_pemeriksaan($date0,$date1){
			// return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan,
			//  COUNT(c.id_tindakan) as banyak, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl_kunjungan
			// FROM jenis_tindakan_lab d
			// LEFT JOIN pemeriksaan_laboratorium c ON c.id_tindakan IN (d.idtindakan) 
			// and to_char(c.tgl_kunjungan,'YYYY-MM-DD')>='$date0'
			// and to_char(c.tgl_kunjungan,'YYYY-MM-DD')<='$date1'
			// and c.no_register IN ((select no_register from daftar_ulang_irj))
			// GROUP BY d.idtindakan;");

			return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, 
			COUNT(c.id_tindakan) as banyak, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl_kunjungan 
			FROM jenis_tindakan_lab d LEFT JOIN pemeriksaan_laboratorium c ON c.id_tindakan IN (d.idtindakan) 
			and to_char(c.tgl_kunjungan,'YYYY-MM-DD')>='$date0' and to_char(c.tgl_kunjungan,'YYYY-MM-DD')<='$date1' 
			and c.no_register IN ((select no_register from daftar_ulang_irj)) GROUP BY d.idtindakan,d.nmtindakan, c.jenis_tindakan,tgl_kunjungan;");
		}

		function get_dates_detail($date0,$date1){
			// return $this->db->query("SELECT LEFT(c.tgl_kunjungan,10) as tgl_kunjungan,
			// SUM(if(e.cara_bayar='BPJS', 1, 0)) as BPJS,
			// SUM(if(e.cara_bayar='UMUM', 1, 0)) as UMUM,
			// SUM(if(e.cara_bayar='DIJAMIN', 1, 0)) as DIJAMIN,
			// SUM(if(f.sex='P', 1, 0)) as P,
			// SUM(if(f.sex='L', 1, 0)) as L
			// from pemeriksaan_laboratorium c
			// INNER JOIN jenis_tindakan_lab d ON c.id_tindakan IN (d.idtindakan)
			// INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			// INNER JOIN data_pasien f ON f.no_medrec=e.no_medrec
			// where LEFT(c.tgl_kunjungan,10)>='$date0'
			// and LEFT(c.tgl_kunjungan,10)<='$date1'
			// GROUP BY c.tgl_kunjungan"
			
			// );
			return $this->db->query("SELECT TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd') as tgl_kunjungan, SUM(CASE WHEN e.cara_bayar='BPJS' THEN 1 ELSE 0 END) as BPJS, SUM(CASE WHEN e.cara_bayar='UMUM' THEN 1 ELSE 0 END) as UMUM, SUM(CASE WHEN e.cara_bayar='DIJAMIN' THEN 1 ELSE 0 END) as DIJAMIN,
			SUM(CASE WHEN f.sex='P' THEN 1 ELSE 0 END) as P,
			SUM(CASE WHEN f.sex='L' THEN 1 ELSE 0 END) as L
			from pemeriksaan_laboratorium c
			INNER JOIN jenis_tindakan_lab d ON c.id_tindakan IN (d.idtindakan)
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			INNER JOIN data_pasien f ON f.no_medrec=e.no_medrec
			where TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')>='2021-03-27'
			and TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')<='$date1'
			GROUP BY c.tgl_kunjungan"
			
			);
		
		}

		function get_master_pemeriksaan_lab(){
			return $this->db->query("SELECT d.idtindakan, d.nmtindakan
			FROM jenis_tindakan_lab d");
		}

		function get_lap_pemeriksaan_detail($date0,$date1){

	


			// return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, COUNT(c.id_tindakan) as banyak, LEFT(c.tgl_kunjungan,10) as tgl_kunjungan
			// FROM jenis_tindakan_lab d
			// LEFT JOIN pemeriksaan_laboratorium c ON c.id_tindakan IN (d.idtindakan) 
			// and TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')>='$date0'
			// and TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')<='$date1'
			// INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			// GROUP BY d.idtindakan, c.tgl_kunjungan;");

			return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, COUNT(c.id_tindakan) as banyak, TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd') 
			as tgl_kunjungan 
			FROM jenis_tindakan_lab d 
			LEFT JOIN pemeriksaan_laboratorium c ON c.id_tindakan 
			IN (d.idtindakan) and TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')>='$date0' 
			and TO_CHAR(c.tgl_kunjungan,'YYYY-MM-dd')<='$date1' 
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register 
			GROUP BY d.idtindakan, c.tgl_kunjungan,d.nmtindakan,c.jenis_tindakan;");



		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_data_kunj_today(){
			// return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, a.tgl_kunjungan as tgl, count(1) as banyak, IF(a.bed='Rawat Jalan',(SELECT waktu_masuk_lab from daftar_ulang_irj where no_register=a.no_register),null) as waktu_masuk_lab,
			// 	IF(a.bed='Rawat Jalan',(SELECT waktu_keluar_lab from daftar_ulang_irj where no_register=a.no_register),null) as waktu_keluar_lab
			// 	FROM pemeriksaan_laboratorium a, data_pasien b 
			// 	WHERE a.no_medrec=b.no_medrec 
			// 	AND left(a.tgl_kunjungan,10)  = left(now(),10) 
			// 	GROUP BY a.no_register 
			// UNION
			// 		SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, c.tgl_kunjungan as tgl, count(1) as banyak, null as waktu_masuk_lab, null as waktu_keluar_lab
			// 	FROM pemeriksaan_laboratorium c, pasien_luar d 
			// 	WHERE c.no_register=d.no_register 
			// 	AND left(c.tgl_kunjungan,10)  = left(now(),10) 
			// 	GROUP BY c.no_register ");


			return $this->db->query("SELECT b.no_cm,
			A.no_medrec,
			A.no_register,
			A.cara_bayar,
			A.nm_dokter,
			nama,
			sex,
			A.bed,
			COUNT ( 1 ) AS banyak,
			A.tgl_mulai_pemeriksaan,
			A.tgl_selesai_pemeriksaan,
			A.tgl_kunjungan,
			CASE
					
					WHEN A.bed = 'Rawat Jalan' THEN
					( SELECT waktu_masuk_lab FROM daftar_ulang_irj WHERE no_register = A.no_register ) ELSE NULL 
				END AS waktu_masuk_lab,
			CASE
					
					WHEN A.bed = 'Rawat Jalan' THEN
					( SELECT waktu_keluar_lab FROM daftar_ulang_irj WHERE no_register = A.no_register ) ELSE NULL 
				END AS waktu_keluar_lab 
			FROM
				pemeriksaan_laboratorium A,
				data_pasien b 
			WHERE
				A.no_medrec = b.no_medrec 
					AND TO_CHAR( A.tgl_kunjungan, 'YYYY-MM-DD' ) = TO_CHAR( now( ), 'YYYY-MM-DD' ) 
			GROUP BY
				A.no_register,
				b.no_cm,
				A.no_medrec,
				nama,
				waktu_masuk_lab,
				waktu_keluar_lab,
				A.bed,
				A.cara_bayar,
				A.nm_dokter,
				sex,
				A.tgl_mulai_pemeriksaan,
				A.tgl_kunjungan,
				A.tgl_selesai_pemeriksaan
						");
		}

		function get_data_kunj_by_date($tgl){
			return $this->db->query("SELECT b.no_cm,
			A.no_medrec,
			A.no_register,
			A.cara_bayar,
			A.nm_dokter,
			nama,
			sex,
			A.bed,
			COUNT ( 1 ) AS banyak,
			A.tgl_mulai_pemeriksaan,
			A.tgl_selesai_pemeriksaan,
			A.tgl_kunjungan,
			CASE
					
					WHEN A.bed = 'Rawat Jalan' THEN
					( SELECT waktu_masuk_lab FROM daftar_ulang_irj WHERE no_register = A.no_register ) ELSE NULL 
				END AS waktu_masuk_lab,
			CASE
					
					WHEN A.bed = 'Rawat Jalan' THEN
					( SELECT waktu_keluar_lab FROM daftar_ulang_irj WHERE no_register = A.no_register ) ELSE NULL 
				END AS waktu_keluar_lab 
			FROM
				pemeriksaan_laboratorium A,
				data_pasien b 
			WHERE
				A.no_medrec = b.no_medrec 
				AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) = '$tgl' 
			GROUP BY
				A.no_register,
				b.no_cm,
				A.no_medrec,
				nama,
				waktu_masuk_lab,
				waktu_keluar_lab,
				A.bed,
				A.cara_bayar,
				A.nm_dokter,
				sex,
				A.tgl_mulai_pemeriksaan,
				A.tgl_kunjungan,
				A.tgl_selesai_pemeriksaan
				UNION
			SELECT
				'Pasien Luar' AS no_cm,
				C.no_medrec,
				C.no_register,
				d.cara_bayar,
				dokter As nm_dokter,
				nama,
				jk as sex,
				'Pasien Luar' as bed,
				COUNT ( 1 ) AS banyak,
				c.tgl_mulai_pemeriksaan,
				c.tgl_selesai_pemeriksaan,
				c.tgl_kunjungan,
				NULL AS waktu_masuk_lab,
				NULL AS waktu_keluar_lab 
			FROM
				pemeriksaan_laboratorium C,
				pasien_luar d 
			WHERE
				C.no_register = d.no_register 
				AND to_char( C.tgl_kunjungan, 'YYYY-MM-DD' ) = '$tgl' 
			GROUP BY
				C.no_register,
				no_cm,
				C.no_medrec,
				nama,
				waktu_masuk_lab,
				waktu_keluar_lab,
				d.cara_bayar,
				d.dokter,
				d.jk,
				c.tgl_mulai_pemeriksaan,
				c.tgl_kunjungan,
				c.tgl_selesai_pemeriksaan");
		}
		
		function get_data_kunj_bln($bln){
			return $this->db->query("SELECT to_char(tgl_kunjungan,'YYYY-MM-DD') AS hari, count(*) AS jum_kunj, to_char(tgl_kunjungan,'YYYY-MM-DD') as tgl 
										FROM pemeriksaan_laboratorium
										WHERE to_char(tgl_kunjungan,'YYYY-MM')='$bln'
										GROUP BY to_char(tgl_kunjungan,'YYYY-MM-DD')");
		}

		function get_data_kunj_thn($thn){
			return $this->db->query("SELECT to_char(tgl_kunjungan,'YYYY-MM-DD') AS bulan, count(*) AS jum_kunj 
				FROM pemeriksaan_laboratorium
				WHERE to_char(tgl_kunjungan,'YYYY')='$thn'
				GROUP BY tgl_kunjungan");
		}

		function get_total_kunj($tgl){
			return $this->db->query("SELECT COUNT(*) FROM pemeriksaan_laboratorium WHERE to_char(tgl_kunjungan,'YYYY-MM-DD')='$tgl' GROUP BY no_register");
		}

		function get_data_tindakan(){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_laboratorium a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD')
				");
		}

		function get_data_pemeriksaan(){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_laboratorium a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD')
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_laboratorium c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(C.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD')
				ORDER BY id_tindakan");
		}

		function get_data_tindakan_tgl($tgl){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_laboratorium a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'
				GROUP BY a.id_tindakan,b.nmtindakan");
		}

		function get_data_pemeriksaan_tgl($tgl){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_laboratorium a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_laboratorium c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl' ");
		}

		function get_data_tindakan_bln($bln){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan, count(qty) as jum_pem
				FROM pemeriksaan_laboratorium a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM')  = '$bln'
				GROUP BY a.id_tindakan,b.nmtindakan
				ORDER BY jum_pem DESC");
		}

		function get_data_pemeriksaan_bln($bln){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl, b.nama
				FROM pemeriksaan_laboratorium a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM')  = '$bln'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, d.nama
				FROM pemeriksaan_laboratorium c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM')  = '$bln'
				ORDER BY id_tindakan");
		}

		function get_data_tindakan_thn($thn){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan, count(qty) as jum_pem
				FROM pemeriksaan_laboratorium a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn'
				GROUP BY a.id_tindakan, b.nmtindakan
				ORDER BY jum_pem DESC");
		}

		function get_data_pemeriksaan_thn($thn){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl, b.nama
				FROM pemeriksaan_laboratorium a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, d.nama
				FROM pemeriksaan_laboratorium c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY')  = '$thn'
				ORDER BY id_tindakan");
		}

		//////////////////////////////////////////////////////////////////////

		function get_data_keu_tind($awal, $akhir){
			return $this->db->query("SELECT a.* FROM pendapatan_lab as a
					WHERE to_char(tgl_kunjungan , 'YYYY-MM-DD') >= '$awal'
					AND to_char(tgl_kunjungan , 'YYYY-MM-DD') <= '$akhir'
					AND no_lab IS NOT NULL
					ORDER BY tgl_kunjungan, no_lab");
		}

		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_laboratorium A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)=left(now(),10)
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_laboratorium C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)=left(now(),10)
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
		}

		function get_data_keuangan_today(){
			return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, nm_dokter, vtot
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,10) =left(now(),10)
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_laboratorium A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)='$tgl'
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_laboratorium C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)='$tgl'
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(id_tindakan) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl, SUM(vtot) as total 
										FROM pemeriksaan_laboratorium
										WHERE LEFT(tgl_kunjungan,7)='$bln'
				AND cetak_kwitansi='1'
										GROUP BY hari");
		}

		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj,  SUM(vtot) as total  
				FROM pemeriksaan_laboratorium
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				AND cetak_kwitansi='1'
				GROUP BY bulan");
		}

		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, nm_dokter, vtot
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_lab, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,7) = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl, id_tindakan
				ORDER BY id_tindakan");
		}

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_lab, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, tgl
				ORDER BY tgl, id_tindakan");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,4)  = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_lab, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,4) = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln, id_tindakan
				ORDER BY bln, id_tindakan");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_lab, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_laboratorium
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, bln
				ORDER BY bln, id_tindakan");
		}

		function row_table_pertgl($tgl){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_laboratorium
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
		}
		
		function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_laboratorium
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_laboratorium
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
		}
		
		function row_table_perbln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_laboratorium
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
		}

		function get_tindakan_hematologi() {
			return $this->db->query("SELECT idtindakan, nmtindakan FROM jenis_tindakan WHERE kategori = 'Laboratorium '");
		}

		function get_nmtindakan($tindakan) {
			return $this->db->query("SELECT nmtindakan FROM jenis_tindakan WHERE idtindakan = '$tindakan'");
		}
		
		function get_lap_hematologi($bln, $tindakan) {
			return $this->db->query("SELECT 
				1 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-01' UNION
			SELECT 
				2 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-02' UNION
				SELECT 
				3 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-03' UNION
				SELECT 
				4 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-04' UNION
				SELECT 
				5 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-05' UNION
				SELECT 
				6 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-06' UNION
				SELECT 
				7 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-07' UNION
				SELECT 
				8 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-08' UNION
				SELECT 
				9 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-09' UNION
				SELECT 
				10 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-10' UNION
			SELECT 
				11 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-11' UNION
			SELECT 
				12 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-12' UNION
			SELECT 
				13 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-13' UNION
			SELECT 
				14 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-14' UNION
			SELECT 
				15 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-15' UNION
			SELECT 
				16 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-16' UNION
			SELECT 
				17 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-17' UNION
			SELECT 
				18 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-18' UNION
			SELECT 
				19 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-19' UNION
			SELECT 
				20 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-20' UNION
			SELECT 
				21 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-21' UNION
			SELECT 
				22 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-22' UNION
			SELECT 
				23 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-23' UNION
			SELECT 
				24 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-24' UNION
			SELECT 
				25 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-25' UNION
			SELECT 
				26 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-26' UNION
			SELECT 
				27 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-27' UNION
			SELECT 
				28 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-28' UNION
			SELECT 
				29 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-29' UNION
			SELECT 
				30 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-30' UNION
			SELECT 
				31 AS tgl,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
				COUNT ( * ) FILTER ( WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' AND substr(bed,1,4) != '0404' AND substr(bed,1,4) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
				COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rj,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
				COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'BPJS' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_bpjs,
				COUNT ( * ) FILTER ( WHERE cara_bayar = 'UMUM' AND idrg LIKE '%Isolasi%' AND substr(no_register,1,2) != 'PL') AS jml_isolasi_umum,
				COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD') = '$bln-31'
			ORDER BY tgl ASC
			");
		}

		function get_lap_hematologi_dok($date, $tindakan) {
			return $this->db->query("SELECT
				1 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-01' UNION
			SELECT
				2 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-02' UNION
			SELECT
				3 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-03' UNION
			SELECT
				4 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-04' UNION
			SELECT
				5 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-05' UNION
			SELECT
				6 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-06' UNION
			SELECT
				7 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-07' UNION
			SELECT
				8 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-08' UNION
			SELECT
				9 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-09' UNION
			SELECT
				10 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-10' UNION
			SELECT
				11 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-11' UNION
			SELECT
				12 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-12' UNION
			SELECT
				13 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-13' UNION
			SELECT
				14 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-14' UNION
			SELECT
				15 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-15' UNION
			SELECT
				16 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-16' UNION
			SELECT
				17 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-17' UNION
			SELECT
				18 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-18' UNION
			SELECT
				19 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-19' UNION
			SELECT
				20 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-20' UNION
			SELECT
				21 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-21' UNION
			SELECT
				22 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-22' UNION
			SELECT
				23 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-23' UNION
			SELECT
				24 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-24' UNION
			SELECT
				25 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-25' UNION
			SELECT
				26 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-26' UNION
			SELECT
				27 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-27' UNION
			SELECT
				28 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-28' UNION
			SELECT
				29 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-29' UNION
			SELECT
				30 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-30' UNION
			SELECT
				31 AS tgl,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_umum_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%') AS jml_bpjs_isolasi_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
				COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
			FROM
				pemeriksaan_laboratorium 
			WHERE
				id_tindakan = '$tindakan' 
				AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-31'
			ORDER BY tgl ASC");
		}

		public function get_lap_jml_kunj($date, $tampil) {
			if($tampil == 'BLN') {
				return $this->db->query("SELECT
					1 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-01' UNION
				SELECT
					2 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-02' UNION
				SELECT
					3 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-03' UNION
				SELECT
					4 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-04' UNION
				SELECT
					5 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-05' UNION
				SELECT
					6 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-06' UNION
				SELECT
					7 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-07' UNION
				SELECT
					8 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-08' UNION
				SELECT
					9 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-09' UNION
				SELECT
					10 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-10' UNION
				SELECT
					11 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-11' UNION
				SELECT
					12 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-12' UNION
				SELECT
					13 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-13' UNION
				SELECT
					14 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-14' UNION
				SELECT
					15 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-15' UNION
				SELECT
					16 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-16' UNION
				SELECT
					17 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-17' UNION
				SELECT
					18 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-18' UNION
				SELECT
					19 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-19' UNION
				SELECT
					20 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-20' UNION
				SELECT
					21 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-21' UNION
				SELECT
					22 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-22' UNION
				SELECT
					23 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-23' UNION
				SELECT
					24 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-24' UNION
				SELECT
					25 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-25' UNION
				SELECT
					26 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-26' UNION
				SELECT
					27 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-27' UNION
				SELECT
					28 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-28' UNION
				SELECT
					29 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-29' UNION
				SELECT
					30 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-30' UNION
				SELECT
					31 AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-31'
				ORDER BY tgl ASC");
			} else {
				return $this->db->query("SELECT
					$date AS tgl,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'VIP' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_vip,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_1,
					COUNT ( * ) FILTER (WHERE kelas = 'I' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_1,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_2,
					COUNT ( * ) FILTER (WHERE kelas = 'II' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_2,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'BPJS' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_3,
					COUNT ( * ) FILTER (WHERE kelas = 'III' AND cara_bayar = 'UMUM' AND idrg NOT LIKE'%Isolasi%' AND substr( bed, 1, 4 ) != '0404' AND substr( bed, 1, 4 ) != '0106' AND substr(no_register,1,2) != 'PL') AS jml_umum_3,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_icu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'BPJS' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_hcu,
					COUNT ( * ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106' AND cara_bayar = 'UMUM' AND substr(no_register,1,2) != 'PL') AS jml_umum_hcu,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_bpjs_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg != 'BA00' AND substr( no_register, 1, 2 ) != 'PL' ) AS jml_umum_rj,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'BPJS' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_bpjs_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'NK' AND cara_bayar = 'UMUM' AND idrg = 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_umum_rd,
					COUNT ( * ) FILTER ( WHERE kelas = 'EKSEKUTIF' AND idrg != 'BA00' AND substr(no_register,1,2) != 'PL') AS jml_eks,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'BPJS') AS jml_isolasi_bpjs,
					COUNT ( * ) FILTER ( WHERE idrg LIKE'%Isolasi%' AND cara_bayar = 'UMUM') AS jml_isolasi_umum,
					COUNT ( * ) FILTER ( WHERE substr(no_register,1,2) = 'PL') AS jml_pasien_luar
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date'");
			}
		}

		public function get_lap_jml_kunj_dok($date, $tampil) {
			if($tampil == 'BLN') {
				return $this->db->query("SELECT
					1 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-01' UNION
				SELECT
					2 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-02' UNION
				SELECT
					3 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-03' UNION
				SELECT
					4 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-04' UNION
				SELECT
					5 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-05' UNION
				SELECT
					6 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-06' UNION
				SELECT
					7 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-07' UNION
				SELECT
					8 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-08' UNION
				SELECT
					9 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-09' UNION
				SELECT
					10 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-10' UNION
				SELECT
					11 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-11' UNION
				SELECT
					12 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-12' UNION
				SELECT
					13 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-13' UNION
				SELECT
					14 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-14' UNION
				SELECT
					15 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-15' UNION
				SELECT
					16 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-16' UNION
				SELECT
					17 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-17' UNION
				SELECT
					18 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-18' UNION
				SELECT
					19 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-19' UNION
				SELECT
					20 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-20' UNION
				SELECT
					21 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-21' UNION
				SELECT
					22 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-22' UNION
				SELECT
					23 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-23' UNION
				SELECT
					24 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-24' UNION
				SELECT
					25 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-25' UNION
				SELECT
					26 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-26' UNION
				SELECT
					27 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-27' UNION
				SELECT
					28 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-28' UNION
				SELECT
					29 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-29' UNION
				SELECT
					30 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-30' UNION
				SELECT
					31 AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date-31'
				ORDER BY tgl ASC");
			} else {
				return $this->db->query("SELECT
					$date AS tgl,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '331' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_el,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_bpjs_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RI' AND idrg NOT LIKE '%Isolasi%') AS jml_umum_ri_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'BPJS' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_bpjs_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND cara_bayar = 'UMUM' AND substr( no_register, 1, 2 ) = 'RJ' AND kelas = 'NK') AS jml_umum_rj_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'BPJS') AS jml_bpjs_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND idrg LIKE '%Isolasi%' AND cara_bayar = 'UMUM') AS jml_umum_isolasi_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'RI' AND kelas = 'EKSEKUTIF') AS jml_eks_pat,
					COUNT ( * ) FILTER ( WHERE id_dokter = '332' AND substr( no_register, 1, 2 ) = 'PL') AS jml_pl_pat
				FROM
					pemeriksaan_laboratorium 
				WHERE 
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date'");
			}
		}

		public function get_jenis_lab() {
			return $this->db->query("SELECT nama_jenis, kode_jenis FROM jenis_lab");
		}

		public function get_nama_jenis_lab($jenis) {
			return $this->db->query("SELECT nama_jenis FROM jenis_lab WHERE kode_jenis = '$jenis'");
		}

		public function get_lap_pendapatan($date, $jenis) {
			return $this->db->query("SELECT
				idtindakan,
				nmtindakan,
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'VIP' ) AS jml_vip
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106'  
				),
				(
				SELECT a.total_tarif AS tarif_vip
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'VIP'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'VIP' ) AS total_vip
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'I' ) AS jml_1
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106'  
				),
				(
				SELECT a.total_tarif AS tarif_1
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'I'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'I' ) AS total_1
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'II' ) AS jml_2
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106'  
				),
				(
				SELECT a.total_tarif AS tarif_2
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'II'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'II' ) AS total_2
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'III' ) AS jml_3
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106'  
				),
				(
				SELECT a.total_tarif AS tarif_3
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'III'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'III' ) AS total_3
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
					AND substr( bed, 1, 4 ) != '0404' 
					AND substr( bed, 1, 4 ) != '0106' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404') AS jml_icu
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE substr( bed, 1, 4 ) = '0404') AS total_icu
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI'   
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106') AS jml_hcu
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI' 
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE substr( bed, 1, 4 ) = '0106') AS total_hcu
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RI'   
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'NK' AND idrg != 'BA00') AS jml_rj
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ'   
				),
				(
				SELECT a.total_tarif AS tarif_rj
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'NK'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'NK' AND idrg != 'BA00') AS total_rj
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'NK' AND idrg = 'BA00') AS jml_rd
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ'   
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'NK' AND idrg = 'BA00') AS total_rd
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ' 
				),
				(
				SELECT SUM
					( qty ) FILTER ( WHERE kelas = 'EKSEKUTIF') AS jml_eks
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ'   
				),
				(
				SELECT a.total_tarif AS tarif_eks
				FROM
					tarif_tindakan AS a 
				WHERE
					a.id_tindakan = jenis_tindakan.idtindakan 
					AND a.kelas = 'EKSEKUTIF'  LIMIT 1
				),
				(
				SELECT SUM
					( vtot ) FILTER ( WHERE kelas = 'EKSEKUTIF') AS total_eks
				FROM
					pemeriksaan_laboratorium 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
					AND pemeriksaan_laboratorium.id_tindakan = jenis_tindakan.idtindakan 
					AND substr( no_register, 1, 2 ) = 'RJ' 
				)
			FROM
				jenis_tindakan 
			WHERE
				idtindakan LIKE '$jenis%'");
		}

		function get_lap_pemeriksaan_per_parameter($date, $tampil) {
			if($tampil == 'TGL') {
				return $this->db->query("SELECT
					jenis_tindakan,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS el_ri_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS el_ri_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS el_ri_iks,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS el_rj_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS el_rj_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS el_rj_iks,
					COUNT(id_tindakan) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '331') AS el_eksekutif,
					COUNT(id_tindakan) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '331') AS el_isolasi,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS f_ri_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS f_ri_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS f_ri_iks,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS f_rj_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS f_rj_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS f_rj_iks,
					COUNT(id_tindakan) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '332') AS f_eksekutif,
					COUNT(id_tindakan) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '332') AS f_isolasi
				FROM 
					pemeriksaan_laboratorium
				WHERE 
					to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date'
				GROUP BY 
					jenis_tindakan");
			} else {
				return $this->db->query("SELECT
					jenis_tindakan,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS el_ri_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS el_ri_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS el_ri_iks,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS el_rj_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS el_rj_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS el_rj_iks,
					COUNT(id_tindakan) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '331') AS el_eksekutif,
					COUNT(id_tindakan) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '331') AS el_isolasi,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS f_ri_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS f_ri_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS f_ri_iks,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS f_rj_bpjs,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS f_rj_umum,
					COUNT(id_tindakan) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS f_rj_iks,
					COUNT(id_tindakan) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '332') AS f_eksekutif,
					COUNT(id_tindakan) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '332') AS f_isolasi
				FROM 
					pemeriksaan_laboratorium
				WHERE 
					to_char(tgl_kunjungan,'YYYY-MM') = '$date'
				GROUP BY 
					jenis_tindakan");
			}
		}

		function get_lap_capkin($date,$tampil)
		{
			if($tampil == 'TGL'){
				$where = " TO_CHAR(tgl_kunjungan,'YYYY-MM-DD') = '$date'";
			}else{
				$where = " TO_CHAR(tgl_kunjungan,'YYYY-MM') = '$date'";
			}
			$sql = "
			SELECT
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS el_ri_bpjs,
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS el_ri_umum,
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS el_ri_iks,
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS el_rj_bpjs,
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS el_rj_umum,
				COUNT(*) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS el_rj_iks,
				COUNT(*) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '331') AS el_eksekutif,
				COUNT(*) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '331') AS el_isolasi,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS f_ri_bpjs,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS f_ri_umum,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS f_ri_iks,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS f_rj_bpjs,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS f_rj_umum,
				COUNT(*) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS f_rj_iks,
				COUNT(*) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '332') AS f_eksekutif,
				COUNT(*) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '332') AS f_isolasi
			FROM 
				pemeriksaan_laboratorium
			WHERE 
				$where
				
				
		UNION ALL
		select 
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK' AND $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE kelas = 'EKSEKUTIF' AND id_dokter = '331' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE idrg LIKE '%Isolasi%' AND id_dokter = '331' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE kelas = 'EKSEKUTIF' AND id_dokter = '332' and $where
		),
		(select COUNT(DISTINCT(no_register)) from pemeriksaan_laboratorium
		WHERE idrg LIKE '%Isolasi%' AND id_dokter = '332' and $where
		)
		
		
		
		UNION ALL
		SELECT
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS el_ri_bpjs,
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS el_ri_umum,
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS el_ri_iks,
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS el_rj_bpjs,
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS el_rj_umum,
				SUM(vtot) FILTER (WHERE id_dokter = '331' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS el_rj_iks,
				SUM(vtot) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '331') AS el_eksekutif,
				SUM(vtot) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '331') AS el_isolasi,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'BPJS' AND idrg NOT LIKE '%Isolasi%') AS f_ri_bpjs,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'UMUM' AND idrg NOT LIKE '%Isolasi%') AS f_ri_umum,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RI' AND cara_bayar = 'KERJASAMA' AND idrg NOT LIKE '%Isolasi%') AS f_ri_iks,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'BPJS' AND kelas = 'NK') AS f_rj_bpjs,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'UMUM' AND kelas = 'NK') AS f_rj_umum,
				SUM(vtot) FILTER (WHERE id_dokter = '332' AND SUBSTRING(no_register,1,2) = 'RJ' AND cara_bayar = 'KERJASAMA' AND kelas = 'NK') AS f_rj_iks,
				SUM(vtot) FILTER (WHERE kelas = 'EKSEKUTIF' AND id_dokter = '332') AS f_eksekutif,
				SUM(vtot) FILTER (WHERE idrg LIKE '%Isolasi%' AND id_dokter = '332') AS f_isolasi
			FROM 
				pemeriksaan_laboratorium
			WHERE 
				$where
				
				
			";
			// echo $sql;die();
			return $this->db->query(
				$sql
			);
		}

		function get_lap_daftar_hasil_pasien_lab($tampil, $date,$filter_darah) {

			// var_dump($tampil);
			// 	var_dump( $date);
			// 	var_dump($filter_darah);
			// die();
			if($filter_darah != "semua"){
			
				if($tampil == 'TGL') {
						return $this->db->query("SELECT
						b.nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						A.cito,
						A.biaya_lab,
					CASE
							WHEN ( SUBSTRING ( A.no_register, 1, 2 ) = 'RI' ) THEN
							A.idrg ELSE A.bed 
						END AS asal,
						A.kelas,
						A.cara_bayar,
						A.nm_dokter 
					FROM
						pemeriksaan_laboratorium A,
						data_pasien b 
					WHERE
						A.no_medrec = b.no_medrec 
						AND cetak_hasil = '1' 
						AND substr( A.no_register, 1, 2 ) <> 'PL' 
						AND substr( A.no_register, 1, 2 ) <> 'RI' 
						AND no_lab IS NOT NULL 
						AND id_tindakan = 'HA0137' 
						AND idrg != 'BA00' 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' ");
				} else {
						return $this->db->query("SELECT
						b.nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						A.cito,
						A.biaya_lab,
					CASE
							WHEN ( SUBSTRING ( A.no_register, 1, 2 ) = 'RI' ) THEN
							A.idrg ELSE A.bed 
						END AS asal,
						A.kelas,
						A.cara_bayar,
						A.nm_dokter 
					FROM
						pemeriksaan_laboratorium A,
						data_pasien b 
					WHERE
						A.no_medrec = b.no_medrec 
						AND cetak_hasil = '1' 
						AND substr( A.no_register, 1, 2 ) <> 'PL' 
						AND substr( A.no_register, 1, 2 ) <> 'RI' 
						AND no_lab IS NOT NULL 
						AND id_tindakan = 'HA0137' 
						AND idrg != 'BA00' 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM' ) = '$date'");
				}
			}else{
				
				if($tampil == 'TGL') {
					return $this->db->query("SELECT
						nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						a.cito,
						a.biaya_lab,
						CASE
							WHEN(SUBSTRING(a.no_register,1,2) = 'RI') THEN a.idrg
							ELSE a.bed 
						END AS asal,
						a.kelas,
						a.cara_bayar,
						a.nm_dokter
					FROM
						pemeriksaan_laboratorium A,
						data_pasien b 
					WHERE
						A.no_medrec = b.no_medrec 
						AND cetak_hasil = '1' 
						AND substr( A.no_register, 1, 2 ) <> 'PL' 
						AND no_lab IS NOT NULL 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' UNION
					SELECT
						nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						a.cito,
						a.biaya_lab,
						'Pasien Luar' AS asal,
						a.kelas,
						a.cara_bayar,
						a.nm_dokter
					FROM
						pemeriksaan_laboratorium A,
						pasien_luar b 
					WHERE
						A.no_register = b.no_register 
						AND cetak_hasil = '1' 
						AND no_lab IS NOT NULL 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
					ORDER BY 
						tgl DESC");
				} else {
					return $this->db->query("SELECT
						b.nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						a.cito,
						a.biaya_lab,
						CASE
							WHEN(SUBSTRING(a.no_register,1,2) = 'RI') THEN a.idrg
							ELSE a.bed 
						END AS asal,
						a.kelas,
						a.cara_bayar,
						a.nm_dokter
					FROM
						pemeriksaan_laboratorium A,
						data_pasien b 
					WHERE
						A.no_medrec = b.no_medrec 
						AND cetak_hasil = '1' 
						AND substr( A.no_register, 1, 2 ) <> 'PL' 
						AND no_lab IS NOT NULL 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM' ) = '$date' UNION
					SELECT
						nama,
						A.no_medrec,
						A.no_lab,
						A.no_register,
						A.jenis_tindakan,
						A.id_tindakan,
						A.tgl_kunjungan AS tgl,
						A.tgl_mulai_pemeriksaan,
						A.tgl_selesai_pemeriksaan,
						a.cito,
						a.biaya_lab,
						'Pasien Luar' AS asal,
						a.kelas,
						a.cara_bayar,
						a.nm_dokter
					FROM
						pemeriksaan_laboratorium A,
						pasien_luar b 
					WHERE
						A.no_register = b.no_register 
						AND cetak_hasil = '1' 
						AND no_lab IS NOT NULL 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM') = '$date' 
					ORDER BY 
						tgl DESC");
				}
			}


			
		}
	}
?>