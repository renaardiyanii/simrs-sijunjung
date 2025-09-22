<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Emmlaporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/////////laporan pemeriksaan
	function get_lap_pemeriksaan($date0, $date1)
	{
		return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, 
			COUNT(c.id_tindakan) as banyak, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl_kunjungan
			FROM jenis_tindakan_em d
			LEFT JOIN pemeriksaan_elektromedik c ON c.id_tindakan IN (d.idtindakan) 
			and to_char(c.tgl_kunjungan,'YYYY-MM-DD')>='$date0'
			and to_char(c.tgl_kunjungan,'YYYY-MM-DD')<='$date1'
			and c.no_register IN ((select no_register from daftar_ulang_irj))
			GROUP BY d.idtindakan,d.nmtindakan, c.jenis_tindakan,tgl_kunjungan;");
	}

	function get_dates_detail($date0, $date1)
	{
		return $this->db->query("SELECT LEFT(c.tgl_kunjungan,10) as tgl_kunjungan,
			SUM(if(e.cara_bayar='BPJS', 1, 0)) as BPJS,
			SUM(if(e.cara_bayar='UMUM', 1, 0)) as UMUM,
			SUM(if(e.cara_bayar='DIJAMIN', 1, 0)) as DIJAMIN,
			SUM(if(f.sex='P', 1, 0)) as P,
			SUM(if(f.sex='L', 1, 0)) as L
			from pemeriksaan_elektromedik c
			INNER JOIN jenis_tindakan_em d ON c.id_tindakan IN (d.idtindakan)
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			INNER JOIN data_pasien f ON f.no_medrec=e.no_medrec
			where LEFT(c.tgl_kunjungan,10)>='$date0'
			and LEFT(c.tgl_kunjungan,10)<='$date1'
			GROUP BY c.tgl_kunjungan");
	}

	function get_master_pemeriksaan_em()
	{
		return $this->db->query("SELECT d.idtindakan, d.nmtindakan
			FROM jenis_tindakan_em d");
	}

	function get_lap_pemeriksaan_detail($date0, $date1)
	{
		return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, COUNT(c.id_tindakan) as banyak, LEFT(c.tgl_kunjungan,10) as tgl_kunjungan
			FROM jenis_tindakan_em d
			LEFT JOIN pemeriksaan_elektromedik c ON c.id_tindakan IN (d.idtindakan) 
			and LEFT(c.tgl_kunjungan,10)>='$date0'
			and LEFT(c.tgl_kunjungan,10)<='$date1'
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			GROUP BY d.idtindakan, c.tgl_kunjungan;");
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
	function get_data_kunj_today()
	{
		// 			return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, a.tgl_kunjungan as tgl, count(1) as banyak, IF(a.bed='Rawat Jalan',(SELECT waktu_masuk_em from daftar_ulang_irj where no_register=a.no_register),null) as waktu_masuk_em,
		// IF(a.bed='Rawat Jalan',(SELECT waktu_keluar_em from daftar_ulang_irj where no_register=a.no_register),null) as waktu_keluar_em  
		// 				FROM pemeriksaan_elektromedik a, data_pasien b 
		// 				WHERE a.no_medrec=b.no_medrec 
		// 				AND left(a.tgl_kunjungan,10)  = left(now(),10) 
		// 				GROUP BY a.no_register 
		// 			UNION
		// 					SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, c.tgl_kunjungan as tgl, count(1) as banyak, null as waktu_masuk_em, null as waktu_keluar_em
		// 				FROM pemeriksaan_elektromedik c, pasien_luar d 
		// 				WHERE c.no_register=d.no_register 
		// 				AND left(c.tgl_kunjungan,10)  = left(now(),10) 
		// 				GROUP BY c.no_register ");

		return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				CASE WHEN a.bed='Rawat Jalan' THEN (SELECT waktu_masuk_em from daftar_ulang_irj 
															where no_register=a.no_register) ELSE null END as waktu_masuk_em,
															
				CASE WHEN a.bed='Rawat Jalan' THEN (SELECT waktu_keluar_em from daftar_ulang_irj 
										where no_register=a.no_register) ELSE null END as waktu_keluar_em  
								FROM pemeriksaan_elektromedik a, data_pasien b 
								WHERE a.no_medrec=b.no_medrec 
								AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD') 
								GROUP BY a.no_register,b.no_cm, a.no_medrec,nama, tgl ,a.bed
							UNION
									SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, c.tgl_kunjungan as tgl, 
									count(1) as banyak, null as waktu_masuk_em, null as waktu_keluar_em
								FROM pemeriksaan_elektromedik c, pasien_luar d 
								WHERE c.no_register=d.no_register 
								AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD') 
								GROUP BY c.no_register,no_cm, c.no_medrec, nama, tgl ");
	}

	function get_data_kunj_by_date($tgl)
	{
		// return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, count(1) as banyak, IF(a.bed='Rawat Jalan',(SELECT waktu_masuk_em from daftar_ulang_irj where no_register=a.no_register),null) as waktu_masuk_em,
		// 	IF(a.bed='Rawat Jalan',(SELECT waktu_keluar_em from daftar_ulang_irj where no_register=a.no_register),null) as waktu_keluar_em 
		// 	FROM pemeriksaan_elektromedik a, data_pasien b 
		// 	WHERE a.no_medrec=b.no_medrec 
		// 	AND left(a.tgl_kunjungan,10)  = '$tgl' 
		// 	GROUP BY a.no_register 
		// UNION
		// 		SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, count(1) as banyak, null as waktu_masuk_em, null as waktu_keluar_em 
		// 	FROM pemeriksaan_elektromedik c, pasien_luar d 
		// 	WHERE c.no_register=d.no_register 
		// 	AND left(c.tgl_kunjungan,10)  = '$tgl' 
		// 	GROUP BY c.no_register ");

		return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, count(1) as banyak, case when a.bed='Rawat Jalan' then (SELECT waktu_masuk_em from daftar_ulang_irj where no_register=a.no_register) else null end as waktu_masuk_em,
				case when a.bed='Rawat Jalan' then (SELECT waktu_keluar_em from daftar_ulang_irj where no_register=a.no_register) else null end as waktu_keluar_em 
				FROM pemeriksaan_elektromedik a, data_pasien b 
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl' 
				GROUP BY a.no_register , b.no_cm, a.no_medrec,nama,waktu_masuk_em,waktu_keluar_em,a.bed
				UNION
					SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, count(1) as banyak, null as waktu_masuk_em, null as waktu_keluar_em  
				FROM pemeriksaan_elektromedik c, pasien_luar d 
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl' 
				GROUP BY c.no_register,no_cm, c.no_medrec,nama,waktu_masuk_em,waktu_keluar_em");
	}

	function get_data_kunj_bln($bln)
	{
		// return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(*) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl 
		// 							FROM pemeriksaan_elektromedik
		// 							WHERE LEFT(tgl_kunjungan,7)='$bln'
		// 							GROUP BY LEFT(tgl_kunjungan,10)");
		return $this->db->query("SELECT no_register, to_char(tgl_kunjungan,'YYYY-MM-DD') AS hari, count(*) AS jum_kunj, to_char(tgl_kunjungan,'YYYY-MM-DD') as tgl 
										FROM pemeriksaan_elektromedik
										WHERE to_char(tgl_kunjungan,'YYYY-MM')='$bln'
										GROUP BY to_char(tgl_kunjungan,'YYYY-MM-DD'), no_register");
	}

	function get_data_kunj_thn($thn)
	{
		// return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj 
		// 	FROM pemeriksaan_elektromedik
		// 	WHERE LEFT(tgl_kunjungan,4)='$thn'
		// 	GROUP BY bulan");
		return $this->db->query("SELECT no_register, to_char(tgl_kunjungan,'YYYY-MM') AS bulan, count(*) AS jum_kunj 
				FROM pemeriksaan_elektromedik
				WHERE to_char(tgl_kunjungan,'YYYY')='$thn'
				GROUP BY tgl_kunjungan, no_register");
	}

	function get_total_kunj($tgl)
	{
		return $this->db->query("SELECT COUNT(*) FROM pemeriksaan_elektromedik WHERE left(tgl_kunjungan,10)='$tgl' GROUP BY no_register");
	}

	function get_data_tindakan()
	{
		return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_elektromedik a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD')
				group by id_tindakan,nmtindakan
				");
	}

	function get_data_pemeriksaan()
	{
		return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_elektromedik a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_Char(now(),'YYYY-MM-DD')
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_elektromedik c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = to_Char(now(),'YYYY-MM-DD')
				ORDER BY id_tindakan");
	}

	function get_data_tindakan_tgl($tgl)
	{
		// 	return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
		// 		FROM pemeriksaan_elektromedik a, jenis_tindakan b
		// 		WHERE a.id_tindakan=b.idtindakan 
		// 		AND left(a.tgl_kunjungan,10)  = '$tgl'
		// 		GROUP BY a.id_tindakan");
		return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_elektromedik a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'
				GROUP BY a.id_tindakan,b.nmtindakan");
	}

	function get_data_pemeriksaan_tgl($tgl)
	{
		// return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
		// 	FROM pemeriksaan_elektromedik a, data_pasien b
		// 	WHERE a.no_medrec=b.no_medrec 
		// 	AND left(a.tgl_kunjungan,10)  = '$tgl'
		// UNION
		// 		SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
		// 	FROM pemeriksaan_elektromedik c, pasien_luar d
		// 	WHERE c.no_register=d.no_register 
		// 	AND left(c.tgl_kunjungan,10)  = '$tgl'
		// 	ORDER BY id_tindakan");
		return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_elektromedik a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_elektromedik c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl' ");
	}

	function get_data_tindakan_bln($bln)
	{
		// return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
		// 	FROM pemeriksaan_elektromedik a, jenis_tindakan b
		// 	WHERE a.id_tindakan=b.idtindakan 
		// 	AND left(a.tgl_kunjungan,7)  = '$bln'
		// 	GROUP BY a.id_tindakan");
		return $this->db->query("SELECT a.id_tindakan, b.nmtindakan, count(qty) as jum_pem
				FROM pemeriksaan_elektromedik a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM')  = '$bln'
				GROUP BY a.id_tindakan,b.nmtindakan
				ORDER BY jum_pem DESC");
	}

	function get_data_pemeriksaan_bln($bln)
	{
		// return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, left(a.tgl_kunjungan,10) as tgl, b.nama
		// 	FROM pemeriksaan_elektromedik a, data_pasien b
		// 	WHERE a.no_medrec=b.no_medrec 
		// 	AND left(a.tgl_kunjungan,7)  = '$bln'
		// UNION
		// 		SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, left(c.tgl_kunjungan,10) as tgl, d.nama
		// 	FROM pemeriksaan_elektromedik c, pasien_luar d
		// 	WHERE c.no_register=d.no_register 
		// 	AND left(c.tgl_kunjungan,7)  = '$bln'
		// 	ORDER BY id_tindakan");
		return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl, b.nama
				FROM pemeriksaan_elektromedik a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM')  = '$bln'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, d.nama
				FROM pemeriksaan_elektromedik c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM')  = '$bln'
				ORDER BY id_tindakan");
	}

	function get_data_tindakan_thn($thn)
	{
		// return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
		// 	FROM pemeriksaan_elektromedik a, jenis_tindakan b
		// 	WHERE a.id_tindakan=b.idtindakan 
		// 	AND left(a.tgl_kunjungan,4)  = '$thn'
		// 	GROUP BY a.id_tindakan");
		return $this->db->query("SELECT a.id_tindakan, b.nmtindakan, count(qty) as jum_pem
				FROM pemeriksaan_elektromedik a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn'
				GROUP BY a.id_tindakan, b.nmtindakan
				ORDER BY jum_pem DESC");
	}

	function get_data_pemeriksaan_thn($thn)
	{
		// return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, left(a.tgl_kunjungan,10) as tgl, b.nama
		// 	FROM pemeriksaan_elektromedik a, data_pasien b
		// 	WHERE a.no_medrec=b.no_medrec 
		// 	AND left(a.tgl_kunjungan,4)  = '$thn'
		// UNION
		// 		SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, left(c.tgl_kunjungan,10) as tgl, d.nama
		// 	FROM pemeriksaan_elektromedik c, pasien_luar d
		// 	WHERE c.no_register=d.no_register 
		// 	AND left(c.tgl_kunjungan,4)  = '$thn'
		// 	ORDER BY id_tindakan");
		return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl, b.nama
				FROM pemeriksaan_elektromedik a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, d.nama
				FROM pemeriksaan_elektromedik c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY')  = '$thn'
				ORDER BY id_tindakan");
	}

	//////////////////////////////////////////////////////////////////////


	function get_data_keu_tind($awal, $akhir)
	{
		return $this->db->query("SELECT a.*, b.nama as nama FROM pendapatan_em as a
					LEFT JOIN data_pasien as b
					ON a.no_medrec=b.no_cm
					WHERE LEFT(tgl_kunjungan , 10) >= '$awal'
					AND LEFT(tgl_kunjungan , 10) <= '$akhir'
					AND no_em IS NOT NULL
					ORDER BY tgl_kunjungan, no_em");
	}

	function get_data_keu_tindakan_today()
	{
		return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_elektromedik A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)=left(now(),10)
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_elektromedik C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)=left(now(),10)
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
	}

	function get_data_keuangan_today()
	{
		return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, vtot
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,10) =left(now(),10)
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
	}

	function get_data_keu_tind_tgl($tgl)
	{
		return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_elektromedik A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)='$tgl'
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_elektromedik C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)='$tgl'
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
	}

	function get_data_keu_tind_bln($bln)
	{
		return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(id_tindakan) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl, SUM(vtot) as total 
										FROM pemeriksaan_elektromedik
										WHERE LEFT(tgl_kunjungan,7)='$bln'
				AND cetak_kwitansi='1'
										GROUP BY hari");
	}

	function get_data_keu_tind_thn($thn)
	{
		return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj,  SUM(vtot) as total  
				FROM pemeriksaan_elektromedik
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				AND cetak_kwitansi='1'
				GROUP BY bulan");
	}

	function get_data_keuangan_tgl($tgl)
	{
		return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, vtot
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
	}

	function get_data_periode_bln($bln)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
	}

	function get_data_keuangan_bln($bln)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_em, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,7) = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl, id_tindakan
				ORDER BY id_tindakan");
	}

	function get_data_periode_bln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
	}

	function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_em, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, tgl
				ORDER BY tgl, id_tindakan");
	}

	function get_data_periode_thn($thn)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,4)  = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln");
	}

	function get_data_keuangan_thn($thn)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_em, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,4) = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln, id_tindakan
				ORDER BY bln, id_tindakan");
	}

	function get_data_periode_thn_bycarabayar($thn, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY bln");
	}

	function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_em, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_elektromedik
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, bln
				ORDER BY bln, id_tindakan");
	}

	function row_table_pertgl($tgl)
	{
		return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_elektromedik
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
	}

	function row_table_pertgl_bycarabayar($tgl, $cara_bayar)
	{
		return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_elektromedik
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
	}

	function row_table_perbln($bln)
	{
		return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_elektromedik
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
	}

	function row_table_perbln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_elektromedik
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
	}

	function get_list_tindakan($date, $tampil, $ruang)
	{
		if ($ruang == 'semua') {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'";
			}

			return $this->db->query("SELECT 
					a.no_register,
					a.tgl_kunjungan AS tgl_kunjungan,
					c.no_cm AS no_medrec,
					c.nama,
					a.cara_bayar,
					a.jenis_tindakan,
					a.biaya_em,
					(SELECT nmkontraktor FROM kontraktor WHERE b.id_kontraktor = id_kontraktor LIMIT 1) AS kontraktor,
					a.idrg AS asal,
					a.kelas,
					b.dokter,
					(SELECT name FROM hmis_users WHERE a.xuser = userid::varchar LIMIT 1) AS petugas
				FROM 
					pemeriksaan_elektromedik AS a
					LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec 
					LEFT JOIN pasien_iri AS b ON a.no_register = b.no_ipd
				WHERE 
					$where
					AND SUBSTRING(a.no_register,1,2) = 'RI' UNION
				SELECT 
					a.no_register,
					a.tgl_kunjungan AS tgl_kunjungan,
					c.no_cm AS no_medrec,
					c.nama,
					a.cara_bayar,
					a.jenis_tindakan,
					a.biaya_em,
					(SELECT nmkontraktor FROM kontraktor WHERE b.id_kontraktor = id_kontraktor LIMIT 1) AS kontraktor,
					a.bed AS asal,
					a.kelas,
					(SELECT nm_dokter FROM data_dokter WHERE b.id_dokter = id_dokter LIMIT 1) AS dokter,
					(SELECT name FROM hmis_users WHERE a.xuser = userid::varchar LIMIT 1) AS petugas
				FROM 
					pemeriksaan_elektromedik AS a
					LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec 
					LEFT JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register
				WHERE 
					$where
					AND SUBSTRING(a.no_register,1,2) = 'RJ' UNION
				SELECT 
					a.no_register,
					a.tgl_kunjungan AS tgl_kunjungan,
					'Pasien Luar' AS no_medrec,
					c.nama,
					a.cara_bayar,
					a.jenis_tindakan,
					a.biaya_em,
					c.nmkontraktor AS kontraktor,
					'Pasien Luar' AS asal,
					a.kelas,
					c.dokter,
					(SELECT name FROM hmis_users WHERE a.xuser = userid::varchar LIMIT 1) AS petugas
				FROM 
					pemeriksaan_elektromedik AS a
					LEFT JOIN pasien_luar AS c ON a.no_register = c.no_register
				WHERE
					$where
					AND SUBSTRING(a.no_register,1,2) = 'PL'
				ORDER BY 
					tgl_kunjungan DESC");
		} else if ($ruang == 'PL') {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'";
			}

			return $this->db->query("SELECT 
					a.no_register,
					a.tgl_kunjungan AS tgl_kunjungan,
					'Pasien Luar' AS no_medrec,
					c.nama,
					a.cara_bayar,
					a.jenis_tindakan,
					a.biaya_em,
					c.nmkontraktor AS kontraktor,
					'Pasien Luar' AS asal,
					a.kelas,
					c.dokter,
					(SELECT name FROM hmis_users WHERE a.xuser::int = userid LIMIT 1) AS petugas
				FROM 
					pemeriksaan_elektromedik AS a
					LEFT JOIN pasien_luar AS c ON a.no_register = c.no_register
				WHERE
					$where
				ORDER BY 
					tgl_kunjungan DESC");
		} else {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date' AND SUBSTRING(a.no_register,1,2) = '$ruang'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date' AND SUBSTRING(a.no_register,1,2) = '$ruang'";
			}

			return $this->db->query("SELECT 
					a.no_register,
					a.tgl_kunjungan AS tgl_kunjungan,
					a.no_medrec,
					c.nama,
					a.cara_bayar,
					a.jenis_tindakan,
					a.biaya_em,
					(SELECT nmkontraktor FROM kontraktor WHERE b.id_kontraktor = id_kontraktor LIMIT 1) AS kontraktor,
					CASE
						WHEN(SUBSTRING(a.no_register,1,2) = 'RI') THEN a.idrg
						ELSE a.bed
					END AS asal,
					a.kelas,
					b.dokter,
					(SELECT name FROM hmis_users WHERE a.xuser::int = userid LIMIT 1) AS petugas
				FROM 
					pemeriksaan_elektromedik AS a
					LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec 
					LEFT JOIN pasien_iri AS b ON a.no_register = b.no_ipd
				WHERE
					$where");
		}
	}

	function get_list_keuangan($date, $tampil, $ruang)
	{
		if ($ruang == 'semua') {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'";
			}

			return $this->db->query("SELECT 
					a.id_tindakan,
					a.jenis_tindakan,
					CASE 
						WHEN(SUBSTRING(a.no_register,1,2) = 'RI') THEN 'Rawat Inap'
						WHEN(SUBSTRING(a.no_register,1,2) = 'RJ') THEN 'Rawat Jalan' 
						ELSE 'Pasien Luar'
					END AS ruang,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'BPJS') AS bpjs,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'UMUM') AS umum,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS iks,
					(SELECT MIN(total_tarif) FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan LIMIT 1) AS tarif_rs
				FROM
					pemeriksaan_elektromedik AS a
				WHERE 
					$where
				GROUP BY 
					a.id_tindakan,
					a.jenis_tindakan,
					SUBSTRING(a.no_register,1,2)");
		} else if ($ruang == 'PL') {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'";
			}

			return $this->db->query("SELECT 
					a.id_tindakan,
					a.jenis_tindakan,
					'Pasien Luar' AS ruang,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'BPJS') AS bpjs,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'UMUM') AS umum,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS iks,
					(SELECT MIN(total_tarif) FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan LIMIT 1) AS tarif_rs
				FROM
					pemeriksaan_elektromedik AS a
				WHERE 
					$where
					AND SUBSTRING(a.no_register,1,2) = 'PL'
				GROUP BY
					a.id_tindakan,
					a.jenis_tindakan");
		} else {
			if ($tampil == 'TGL') {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date' AND SUBSTRING(a.no_register,1,2) = '$ruang'";
			} else {
				$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date' AND SUBSTRING(a.no_register,1,2) = '$ruang'";
			}

			if ($ruang = 'RI') {
				$idrg = 'Rawat Inap';
			} else {
				$idrg = 'Rawat Jalan';
			}

			return $this->db->query("SELECT 
					a.id_tindakan,
					a.jenis_tindakan,
					'$idrg' AS ruang,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'BPJS') AS bpjs,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'UMUM') AS umum,
					COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS iks,
					(SELECT MIN(total_tarif) FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan LIMIT 1) AS tarif_rs
				FROM
					pemeriksaan_elektromedik AS a
				WHERE 
					$where
				GROUP BY 
					a.id_tindakan,
					a.jenis_tindakan");
		}
	}

	function get_list_jml_tindakan($date, $tampil)
	{
		if ($tampil == 'TGL') {
			$where = "to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'";
		} else {
			$where = "to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'";
		}

		return $this->db->query("SELECT 
				a.id_tindakan AS id_tindakan,
				a.jenis_tindakan AS tindakan,
				c.dokter AS dokter,
				'DPJP Ranap' AS ket,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'BPJS') AS bpjs,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'UMUM') AS umum,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS iks
			FROM 
				pasien_iri AS c
				LEFT JOIN pemeriksaan_elektromedik AS a ON a.no_register = c.no_ipd 
			WHERE
				$where
			GROUP BY 
				a.id_tindakan,
				a.jenis_tindakan,
				c.dokter UNION 
			SELECT 
				a.id_tindakan AS id_tindakan,
				a.jenis_tindakan AS tindakan,
				b.nm_dokter AS dokter,
				'DPJP Rajal' AS ket,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'BPJS') AS bpjs,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'UMUM') AS umum,
				COUNT(a.id_tindakan) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS iks
			FROM 
				daftar_ulang_irj AS c 
				LEFT JOIN pemeriksaan_elektromedik AS a ON a.no_register = c.no_register 
				LEFT JOIN data_dokter AS b ON c.id_dokter = b.id_dokter
			WHERE 
				$where
			GROUP BY 
				a.id_tindakan,
				a.jenis_tindakan,
				b.nm_dokter");
	}
}
