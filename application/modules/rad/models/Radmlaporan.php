<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Radmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		/////////laporan pemeriksaan
		function get_lap_pemeriksaan($date0,$date1,$tindak,$dokter){
			if($tindak != 'semua'){
				$andtindak = " AND id_tindakan = '$tindak' ";
			}else{
				$andtindak = " ";
			}

			if($dokter != 'semua'){
				$anddokter = " AND id_dokter = '$dokter' ";
			}else{
				$anddokter = " ";
			}

			return $this->db->query("SELECT 
				count(id_tindakan) as banyak,
				to_char(tgl_kunjungan,'YYYY-MM-DD') as tgl_kunjungan,
				id_tindakan,
				jenis_tindakan,
				id_dokter,
				nm_dokter 
			from 
				pemeriksaan_radiologi
			where 
				to_char(tgl_kunjungan,'YYYY-MM-DD')>='$date0' 
				and to_char(tgl_kunjungan,'YYYY-MM-DD')<='$date1'  
				$andtindak  $anddokter
			group by 
				to_char(tgl_kunjungan,'YYYY-MM-DD'),
				id_tindakan,
				jenis_tindakan,
				id_dokter,
				nm_dokter 
			ORDER BY 
				tgl_kunjungan ASC");
		}

		function get_dates_detail($date0,$date1){
			return $this->db->query("SELECT 
				LEFT(c.tgl_kunjungan,10) as tgl_kunjungan,
				SUM(if(e.cara_bayar='BPJS', 1, 0)) as BPJS,
				SUM(if(e.cara_bayar='UMUM', 1, 0)) as UMUM,
				SUM(if(e.cara_bayar='DIJAMIN', 1, 0)) as DIJAMIN,
				SUM(if(f.sex='P', 1, 0)) as P,
				SUM(if(f.sex='L', 1, 0)) as L
			from 
				pemeriksaan_radiologi c
				INNER JOIN jenis_tindakan_rad d ON c.id_tindakan IN (d.idtindakan)
				INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
				INNER JOIN data_pasien f ON f.no_medrec=e.no_medrec
			where 
				LEFT(c.tgl_kunjungan,10)>='$date0'
				and LEFT(c.tgl_kunjungan,10)<='$date1'
			GROUP BY 
				c.tgl_kunjungan");
		}

		function get_master_pemeriksaan_rad(){
			return $this->db->query("SELECT 
				d.idtindakan, 
				d.nmtindakan
			FROM 
				jenis_tindakan_rad d");
		}

		function get_lap_pemeriksaan_detail($date0,$date1){
			return $this->db->query("SELECT 
				d.idtindakan, 
				d.nmtindakan, 
				c.jenis_tindakan, 
				COUNT(c.id_tindakan) as banyak, 
				LEFT(c.tgl_kunjungan,10) as tgl_kunjungan
			FROM 
				jenis_tindakan_rad d
				LEFT JOIN pemeriksaan_radiologi c ON c.id_tindakan IN (d.idtindakan) 
				and LEFT(c.tgl_kunjungan,10)>='$date0'
				and LEFT(c.tgl_kunjungan,10)<='$date1'
				INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			GROUP BY 
				d.idtindakan, 
				c.tgl_kunjungan;");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_data_kunj_today(){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.no_medrec, 
				a.no_register, 
				nama, 
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				CASE 
					WHEN a.bed='Rawat Jalan' THEN (SELECT waktu_masuk_rad from daftar_ulang_irj where no_register=a.no_register) 
					ELSE null 
				END as waktu_masuk_rad,								
				CASE 
					WHEN a.bed='Rawat Jalan' THEN (SELECT waktu_keluar_rad from daftar_ulang_irj where no_register=a.no_register) 
					ELSE null 
				END as waktu_keluar_rad  
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b 
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_char(a.jadwal,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD') 
			GROUP BY a.no_register,b.no_cm, a.no_medrec,nama, tgl ,a.bed UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.no_medrec, 
				c.no_register, 
				nama, 
				c.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				null as waktu_masuk_rad, 
				null as waktu_keluar_rad
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d 
			WHERE 
				c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD') 
			GROUP BY 
				c.no_register,
				no_cm, 
				c.no_medrec, 
				nama, 
				tgl ");
		}

		function get_data_kunj_by_date($tgl){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.no_medrec, 
				a.no_register, 
				nama, 
				count(1) as banyak, 
				case 
					when a.bed='Rawat Jalan' then cast((SELECT waktu_masuk_rad from daftar_ulang_irj where no_register=a.no_register) as text) 
					else null 
				end as waktu_masuk_rad,
				case 
					when a.bed='Rawat Jalan' then cast((SELECT waktu_keluar_rad from daftar_ulang_irj where no_register=a.no_register) as text) 
					else null 
				end as waktu_keluar_rad 
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b 
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_char(a.jadwal,'YYYY-MM-DD')  = '$tgl' 
			GROUP BY a.no_register ,b.no_cm, a.no_medrec,nama,waktu_masuk_rad,waktu_keluar_rad UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.no_medrec, 
				c.no_register, 
				nama, 
				count(1) as banyak, 
				null as waktu_masuk_rad, 
				null as waktu_keluar_rad 
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d 
			WHERE 
				c.no_register=d.no_register 
				AND to_char(c.jadwal,'YYYY-MM-DD')  = '$tgl' 
			GROUP BY 
				c.no_register,
				no_cm,
				c.no_medrec,
				nama,
				waktu_masuk_rad,
				waktu_keluar_rad ");
		}
		
		function get_data_kunj_bln($bln){
			return $this->db->query("SELECT 
				to_char(jadwal,'YYYY-MM-DD') AS hari, 
				count(*) AS jum_kunj, 
				to_char(jadwal,'YYYY-MM-DD') as tgl 
			FROM 
				pemeriksaan_radiologi
			WHERE 
				to_char(jadwal,'YYYY-MM')='$bln'
			GROUP BY 
				to_char(jadwal,'YYYY-MM-DD')");
		}

		function get_data_kunj_thn($thn){
			return $this->db->query("SELECT 
				to_char(tgl_kunjungan,'YYYY-MM-DD') AS bulan, 
				count(*) AS jum_kunj 
			FROM 
				pemeriksaan_radiologi
			WHERE 
				to_char(tgl_kunjungan,'YYYY')='$thn'
			GROUP BY 
				bulan");
		}

		function get_total_kunj($tgl){
			return $this->db->query("SELECT COUNT(*) FROM pemeriksaan_radiologi WHERE to_char(tgl_kunjungan,'YYYY-MM-DD')='$tgl' GROUP BY no_register");
		}

		function get_data_tindakan(){
			return $this->db->query("SELECT 
			a.no_register,
				a.id_tindakan, 
				b.nmtindakan
			FROM 
				pemeriksaan_radiologi a, 
				jenis_tindakan_new b
			WHERE 
				a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_char(now(),'YYYY-MM-DD')");
		}

		function get_data_pemeriksaan(){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.id_tindakan, 
				a.no_medrec, 
				a.no_register, 
				b.nama
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = to_Char(now(),'YYYY-MM-DD') UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.id_tindakan, 
				c.no_medrec, 
				c.no_register, 
				d.nama
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d
			WHERE 
				c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM-DD')  = to_Char(now(),'YYYY-MM-DD')
			ORDER BY 
				id_tindakan");
		}

		function get_data_tindakan_tgl($tgl){
			return $this->db->query("SELECT
				a.no_register, 
				a.id_tindakan, 
				b.nmtindakan
			FROM 
				pemeriksaan_radiologi a, 
				jenis_tindakan_new b
			WHERE 
				a.id_tindakan=b.idtindakan 
				AND to_Char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'");
		}

		function get_data_pemeriksaan_tgl($tgl){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.id_tindakan, 
				a.no_medrec, 
				a.no_register, 
				b.nama
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_Char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl' UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.id_tindakan, 
				c.no_medrec, 
				c.no_register, 
				d.nama
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d
			WHERE 
				c.no_register=d.no_register 
				AND to_Char(c.tgl_kunjungan,'YYYY-MM-DD')  = '$tgl'");
		}

		function get_data_tindakan_bln($bln){
			return $this->db->query("SELECT 
				a.id_tindakan, 
				b.nmtindakan
			FROM 
				pemeriksaan_radiologi a, 
				jenis_tindakan b
			WHERE 
				a.id_tindakan=b.idtindakan 
				AND to_Char(a.tgl_kunjungan,'YYYY-MM')  = '$bln'");
		}

		function get_data_pemeriksaan_bln($bln){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.id_tindakan, 
				a.no_medrec, 
				a.no_register, 
				to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl,
				b.nama
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY-MM')  = '$bln' UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.id_tindakan, 
				c.no_medrec, 
				c.no_register, 
				to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, 
				d.nama
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d
			WHERE 
				c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY-MM')  = '$bln'
			ORDER BY 
				id_tindakan");
		}

		function get_data_tindakan_thn($thn){
			return $this->db->query("SELECT 
			a.no_register,
				a.id_tindakan, 
				b.nmtindakan
			FROM 
				pemeriksaan_radiologi a, 
				jenis_tindakan b
			WHERE 
				a.id_tindakan=b.idtindakan 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn'");
		}

		function get_data_pemeriksaan_thn($thn){
			return $this->db->query("SELECT 
				b.no_cm, 
				a.id_tindakan, 
				a.no_medrec, 
				a.no_register, 
				to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl, 
				b.nama
			FROM 
				pemeriksaan_radiologi a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND to_char(a.tgl_kunjungan,'YYYY')  = '$thn' UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				c.id_tindakan, 
				c.no_medrec, 
				c.no_register, 
				to_char(c.tgl_kunjungan,'YYYY-MM-DD') as tgl, 
				d.nama
			FROM 
				pemeriksaan_radiologi c, 
				pasien_luar d
			WHERE 
				c.no_register=d.no_register 
				AND to_char(c.tgl_kunjungan,'YYYY')  = '$thn'
			ORDER BY 
				id_tindakan");
		}

		//////////////////////////////////////////////////////////////////////

		function get_data_keu_tind($awal, $akhir){
			return $this->db->query("SELECT 
				a.* 
			FROM 
				pendapatan_rad as a
			WHERE 
				to_char(tgl_kunjungan , 'YYYY-MM-DD') >= '$awal'
				AND to_char(tgl_kunjungan , 'YYYY-MM-DD') <= '$akhir'
				AND no_rad IS NOT NULL
			ORDER BY 
				tgl_kunjungan, 
				no_rad");
		}

		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT 
				B.no_cm, 
				A.no_medrec, 
				A.no_register, 
				B.nama, 
				count(A.id_tindakan) as jum_pem, 
				SUM(A.vtot) as total
			FROM 
				pemeriksaan_radiologi A, 
				data_pasien B
			WHERE  
				A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)=left(now(),10)
				AND A.cetak_kwitansi='1'
			GROUP BY 
				A.no_register UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				C.no_medrec, 
				C.no_register, 
				D.nama, 
				count(C.id_tindakan) as jum_pem, 
				SUM(C.vtot) as total
			FROM 
				pemeriksaan_radiologi C, 
				pasien_luar D
			WHERE  
				C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)=left(now(),10)
				AND D.cetak_kwitansi='1'
			GROUP BY 
				no_register");
		}

		function get_data_keuangan_today(){
			return $this->db->query("SELECT 
				no_register, 
				id_tindakan, 
				jenis_tindakan, 
				vtot
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,10) =left(now(),10)
				AND cetak_kwitansi='1'
			ORDER BY 
				id_tindakan");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT 
				B.no_cm, 
				A.no_medrec, 
				A.no_register, 
				B.nama, 
				count(A.id_tindakan) as jum_pem, 
				SUM(A.vtot) as total
			FROM 
				pemeriksaan_radiologi A, 
				data_pasien B
			WHERE  
				A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)='$tgl'
				AND A.cetak_kwitansi='1'
			GROUP BY A.no_register UNION
			SELECT 
				'Pasien Luar' as no_cm, 
				C.no_medrec, 
				C.no_register, 
				D.nama, 
				count(C.id_tindakan) as jum_pem, 
				SUM(C.vtot) as total
			FROM 
				pemeriksaan_radiologi C, 
				pasien_luar D
			WHERE  
				C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)='$tgl'
				AND D.cetak_kwitansi='1'
			GROUP BY 
				no_register");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT 
				DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, 
				count(id_tindakan) AS jum_kunj, 
				LEFT(tgl_kunjungan,10) as tgl, 
				SUM(vtot) as total 
			FROM 
				pemeriksaan_radiologi
			WHERE 
				LEFT(tgl_kunjungan,7)='$bln'
				AND cetak_kwitansi='1'
			GROUP BY 
				hari");
		}

		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT 
				MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, 
				count(*) AS jum_kunj,  
				SUM(vtot) as total  
			FROM 
				pemeriksaan_radiologi
			WHERE 
				LEFT(tgl_kunjungan,4)='$thn'
				AND cetak_kwitansi='1'
			GROUP BY 
				bulan");
		}

		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT 
				no_register, 
				id_tindakan, 
				jenis_tindakan, 
				vtot
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
			ORDER BY 
				id_tindakan");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,10) as tgl, 
				count(1) as jum_pem
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
			GROUP BY 
				tgl");
		}

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,10) as tgl, 
				id_tindakan, 
				jenis_tindakan, 
				biaya_rad, 
				count(id_tindakan) as jumlah_pasien, 
				sum(qty) as jumlah_pemeriksaan, 
				sum(vtot) as total
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,7) = '$bln'
				AND cetak_kwitansi='1'
			GROUP BY 
				tgl, 
				id_tindakan
			ORDER BY 
				id_tindakan");
		}

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,10) as tgl, 
				count(1) as jum_pem
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
			GROUP BY 
				tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,10) as tgl, 
				id_tindakan, 
				jenis_tindakan, 
				biaya_rad, 
				count(id_tindakan) as jumlah_pasien, 
				sum(qty) as jumlah_pemeriksaan, 
				sum(vtot) as total
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
			GROUP BY 
				id_tindakan, 
				tgl
			ORDER BY 
				tgl, 
				id_tindakan");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,7) as bln, 
				count(1) as jum_pem
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,4)  = '$thn'
				AND cetak_kwitansi='1'
			GROUP BY 
				bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,7) as bln, 
				id_tindakan, 
				jenis_tindakan, 
				biaya_rad, 
				count(id_tindakan) as jumlah_pasien, 
				sum(qty) as jumlah_pemeriksaan, 
				sum(vtot) as total
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,4) = '$thn'
				AND cetak_kwitansi='1'
			GROUP BY 
				bln,
				id_tindakan
			ORDER BY 
				bln, 
				id_tindakan");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,7) as bln, 
				count(1) as jum_pem
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
			GROUP BY 
				bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT 
				left(tgl_kunjungan,7) as bln, 
				id_tindakan, 
				jenis_tindakan, 
				biaya_rad, 
				count(id_tindakan) as jumlah_pasien, 
				sum(qty) as jumlah_pemeriksaan, 
				sum(vtot) as total
			FROM 
				pemeriksaan_radiologi
			WHERE 
				left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
			GROUP BY 
				id_tindakan, 
				bln
			ORDER BY 
				bln, 
				id_tindakan");
		}

		function row_table_pertgl($tgl){
			return $this->db->query("SELECT 
				Count(*)
			FROM 
				pemeriksaan_radiologi
			WHERE  
				left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
			GROUP BY 
				id_tindakan");
		}
		
		function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
			return $this->db->query("SELECT 
				Count(*)
			FROM 
				pemeriksaan_radiologi
			WHERE  
				left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
			GROUP BY 
				id_tindakan");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT 
				Count(*)
			FROM 
				pemeriksaan_radiologi
			WHERE  
				left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
			GROUP BY 
				id_tindakan");
		}
		
		function row_table_perbln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT 
				Count(*)
			FROM 
				pemeriksaan_radiologi
			WHERE  
				left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
			GROUP BY 
				id_tindakan");
		}
		
		function get_tindakan(){
			return $this->db->query("SELECT 
				*
			FROM 
				jenis_tindakan_rad 
			ORDER BY 
				nmtindakan ASC ");
		}
		
		function get_pemeriksaan_tindakan_tgl($tgl) {
			return $this->db->query("SELECT 
				id_tindakan,
				jenis_tindakan,
				COUNT (*) FILTER ( WHERE id_dokter = '329' ) AS drwidya,
				COUNT (*) FILTER ( WHERE id_dokter = '330' ) AS dromy,
				COUNT (*) FILTER ( WHERE id_dokter IS NULL ) AS kosong
			FROM
				pemeriksaan_radiologi
			WHERE
				to_char(tgl_kunjungan,'YYYY-MM-DD') = '$tgl' 
			GROUP BY
				id_tindakan, jenis_tindakan");
		}

		function get_pemeriksaan_tindakan_bln($bln) {
			return $this->db->query("SELECT 
				id_tindakan,
				jenis_tindakan,
				COUNT (*) FILTER ( WHERE id_dokter = '329' ) AS drwidya,
				COUNT (*) FILTER ( WHERE id_dokter = '330' ) AS dromy,
				COUNT (*) FILTER ( WHERE id_dokter IS NULL ) AS kosong
			FROM
				pemeriksaan_radiologi
			WHERE
				to_char(tgl_kunjungan,'YYYY-MM') = '$bln' 
			GROUP BY
				id_tindakan, jenis_tindakan");
		}

		function get_pemeriksaan_tindakan_thn($thn) {
			return $this->db->query("SELECT 
				id_tindakan,
				jenis_tindakan,
				COUNT (*) FILTER ( WHERE id_dokter = '329' ) AS drwidya,
				COUNT (*) FILTER ( WHERE id_dokter = '330' ) AS dromy,
				COUNT (*) FILTER ( WHERE id_dokter IS NULL ) AS kosong
			FROM
				pemeriksaan_radiologi
			WHERE
				to_char(tgl_kunjungan,'YYYY') = '$thn' 
			GROUP BY
				id_tindakan, jenis_tindakan");
		}

		function get_pemeriksaan_tindakan() {
			$date = date("Y-m-d");
			return $this->db->query("SELECT 
				id_tindakan,
				jenis_tindakan,
				COUNT (*) FILTER ( WHERE id_dokter = '329' ) AS drwidya,
				COUNT (*) FILTER ( WHERE id_dokter = '330' ) AS dromy,
				COUNT (*) FILTER ( WHERE id_dokter IS NULL ) AS kosong
			FROM
				pemeriksaan_radiologi
			WHERE
				to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' 
			GROUP BY
				id_tindakan, jenis_tindakan");
		}

		function get_jml_pemeriksaan_expert_tahun($thn)
		{
			return $this->db->query("SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'JANUARI' as bulan, 01 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-01' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'FEBUARI' as bulan, 02 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-02' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'MARET' as bulan, 03 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-03' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'APRIL' as bulan, 04 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-04' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'MEI' as bulan, 05 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-05' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'JUNI' as bulan, 06 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-06' AND modality IS NOT NULL
			GROUP BY
				modality
			
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'JULI' as bulan, 07 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-07' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'AGUSTUS' as bulan, 08 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-08' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'SEPTEMBER' as bulan, 09 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-09' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'OKTOBER' as bulan, 10 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-10' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'NOVEMBER' as bulan, 11 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-11' AND modality IS NOT NULL
			GROUP BY
				modality
				
			UNION ALL
			SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert,'DESEMBER' as bulan, 12 as bln
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$thn-12' AND modality IS NOT NULL
			GROUP BY
				modality
			ORDER BY bln ASC
			");
		}

		function get_jml_pemeriksaan_expert_bln($bln) {
			return $this->db->query("SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' )
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' )
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' ) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' ) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') ) 
				END AS jml_exam,
				CASE 
					WHEN (modality = 'MR') THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'MR' AND cetak_hasil = 1)
					WHEN ( modality = 'CT' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'CT' AND cetak_hasil = 1)
					WHEN ( modality = 'LA' ) THEN
						COUNT ( * ) FILTER ( WHERE modality = 'LA' AND cetak_hasil = 1) 
					WHEN ( modality = 'US' ) THEN 
						COUNT ( * ) FILTER ( WHERE modality = 'US' AND cetak_hasil = 1) 
					WHEN ( modality IN ('DX','CR')) THEN
						COUNT ( * ) FILTER ( WHERE modality IN ('DX','CR') AND cetak_hasil = 1) 
				END AS jml_expert
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$bln' AND modality is not null
			GROUP BY
				modality");
		}

		function get_penerimaan_bln($date) {
			return $this->db->query("SELECT
				CASE 
					WHEN (modality = 'MR') THEN 'Pencitraan MRI'
					WHEN (modality = 'CT') THEN 'Radiografi CT Scan'
					WHEN (modality = 'LA') THEN 'Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN 'Radiografi Konvensional'
					WHEN (modality = 'US') THEN 'USG'
				END AS modality,
				CASE 
					WHEN (modality = 'MR') THEN 
						sum ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS')
					WHEN ( modality = 'CT' ) THEN
						sum ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS')
					WHEN ( modality = 'LA' ) THEN
						sum ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS') 
					WHEN ( modality = 'US' ) THEN 
						sum ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS') 
					WHEN ( modality IN ('DX','CR')) THEN
						sum ( vtot ) FILTER ( WHERE modality IN ('DX','CR') AND cara_bayar = 'BPJS') 
				END AS bpjs,
				CASE 
					WHEN (modality = 'MR') THEN 
						sum ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM')
					WHEN ( modality = 'CT' ) THEN
						sum ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM')
					WHEN ( modality = 'LA' ) THEN
						sum ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM') 
					WHEN ( modality = 'US' ) THEN 
						sum ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM') 
					WHEN ( modality IN ('DX','CR')) THEN
						sum ( vtot ) FILTER ( WHERE modality IN ('DX','CR') AND cara_bayar = 'UMUM') 
				END AS umum
			FROM
				pemeriksaan_radiologi 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' AND modality is not null
			GROUP BY
				modality");
		}

		function get_penerimaan_thn($date) {
			return $this->db->query("SELECT
				'JANUARI' AS bulan, 01 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-01' GROUP BY  modality
			UNION ALL
			SELECT
				'FEBUARI' AS bulan, 02 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-02' GROUP BY  modality
			UNION ALL
			SELECT
				'MARET' AS bulan, 03 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-03' GROUP BY  modality
			UNION ALL
			SELECT
				'APRIL' AS bulan, 04 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality 
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-04' GROUP BY  modality
			UNION ALL
			SELECT
				'MEI' AS bulan, 05 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-05' GROUP BY  modality
			UNION ALL
			SELECT
				'JUNI' AS bulan, 06 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality 
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-06' GROUP BY  modality
			UNION ALL
			SELECT
				'JULI' AS bulan, 07 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality 
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-07' GROUP BY  modality
			UNION ALL
			SELECT
				'AGUSTUS' AS bulan, 08 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-08' GROUP BY  modality
			UNION ALL
			SELECT
				'SEPTEMBER' AS bulan, 09 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality 
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-09' GROUP BY  modality
			UNION ALL
			SELECT
				'OKTOBER' AS bulan, 10 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality 
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-10' GROUP BY  modality
			UNION ALL
			SELECT
				'NOVEMBER' AS bulan, 11 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-11' GROUP BY  modality
			UNION ALL
			SELECT
				'DESEMBER' AS bulan, 12 AS bln,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'BPJS' ) AS mr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'BPJS' ) AS ct_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'BPJS' ) AS la_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'BPJS' ) AS us_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'BPJS' ) AS cr_bpjs,
				SUM ( vtot ) FILTER ( WHERE modality = 'MR' AND cara_bayar = 'UMUM' ) AS mr_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'CT' AND cara_bayar = 'UMUM' ) AS ct_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'LA' AND cara_bayar = 'UMUM' ) AS la_umum,
				SUM ( vtot ) FILTER ( WHERE modality = 'US' AND cara_bayar = 'UMUM' ) AS us_umum,
				SUM ( vtot ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) AND cara_bayar = 'UMUM' ) AS cr_umum ,
				SUM(vtot) AS total_bln,
				CASE 
					WHEN (modality = 'MR') THEN '2 Pencitraan MRI'
					WHEN (modality = 'CT') THEN '1 Radiografi CT Scan'
					WHEN (modality = 'LA') THEN '4 Radiografi Panoramic/Dental'
					WHEN (modality IN ('DX','CR')) THEN '5 Radiografi Konvensional'
					WHEN (modality = 'US') THEN '3 USG'
				END AS modality
			FROM
				pemeriksaan_radiologi 
			WHERE
				modality IS NOT NULL 
				AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-12' GROUP BY  modality
			ORDER BY bln ASC, modality ASC");
		}

		function get_utilitas($date, $modality) {
			if($modality == 'CR-DX') {
				return $this->db->query("SELECT COUNT
					( * ) AS jml,
					to_char( tgl_kunjungan, 'DD' ) AS tgl,
					modality 
				FROM
					pemeriksaan_radiologi 
				WHERE
					modality IN ('CR','DX') 
					AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
				GROUP BY
					tgl,
					modality
				ORDER BY tgl ASC");
			} else {
				return $this->db->query("SELECT COUNT
					( * ) AS jml,
					to_char( tgl_kunjungan, 'DD' ) AS tgl,
					modality 
				FROM
					pemeriksaan_radiologi 
				WHERE
					modality = '$modality' 
					AND to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
				GROUP BY
					tgl,
					modality
				ORDER BY tgl ASC");
			}
		}

		function get_waktu_tunggu_semua($date1, $date2) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE
					
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_dokter_pilih_petugas($date1, $date2, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE	
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer' 
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_petugas_pilih_dokter($date1, $date2, $dokter) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				And A.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_pilih_dua($date1, $date2, $dokter, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE	
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter' 
				AND a.id_radiografer = '$radiografer'
				AND A.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter' 
				AND a.id_radiografer = '$radiografer'
				AND A.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.id_radiografer = CAST('$radiografer' AS INT)
				AND A.hasil_simpan = '1'");
		}

		function get_penerimaan_per_kelas($date, $modality) {
			if($modality == 'CR-DX') {
				return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'VIP' ) AS total_bpjs_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'VIP' ) AS jml_tindakan_bpjs_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'VIP' ) AS total_umum_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'VIP' ) AS jml_tindakan_umum_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0106' ) AS total_bpjs_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0106' ) AS jml_tindakan_bpjs_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0106' ) AS total_umum_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0106' ) AS jml_tindakan_umum_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'I' ) AS total_bpjs_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'I' ) AS jml_tindakan_bpjs_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'I' ) AS total_umum_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'I' ) AS jml_tindakan_umum_1
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'II' ) AS total_bpjs_2
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'II' ) AS jml_tindakan_bpjs_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'II' ) AS total_umum_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'II' ) AS jml_tindakan_umum_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'III' ) AS total_bpjs_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'III' ) AS jml_tindakan_bpjs_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'III' ) AS total_umum_3
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'III' ) AS jml_tindakan_umum_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0404' ) AS total_bpjs_icu
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0404' ) AS jml_tindakan_bpjs_icu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0404' ) AS total_umum_icu
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0404' ) AS jml_tindakan_umum_icu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					)
				FROM
					jenis_tindakan 
				WHERE
					jenis_tindakan.idtindakan LIKE'LA%' 
					AND jenis_tindakan.modality IN ('CR','DX')");
			} else {
				return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'VIP' ) AS total_bpjs_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'VIP' ) AS jml_tindakan_bpjs_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'VIP' ) AS total_umum_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'VIP' ) AS jml_tindakan_umum_vip 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0106' ) AS total_bpjs_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0106' ) AS jml_tindakan_bpjs_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0106' ) AS total_umum_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0106' ) AS jml_tindakan_umum_hcu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'I' ) AS total_bpjs_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'I' ) AS jml_tindakan_bpjs_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'I' ) AS total_umum_1 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'I' ) AS jml_tindakan_umum_1
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'II' ) AS total_bpjs_2
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'II' ) AS jml_tindakan_bpjs_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'II' ) AS total_umum_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'II' ) AS jml_tindakan_umum_2 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'III' ) AS total_bpjs_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND kelas = 'III' ) AS jml_tindakan_bpjs_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'III' ) AS total_umum_3
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND kelas = 'III' ) AS jml_tindakan_umum_3 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0404' ) AS total_bpjs_icu
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS' AND substr(bed,1,4) = '0404' ) AS jml_tindakan_bpjs_icu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0404' ) AS total_umum_icu
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM' AND substr(bed,1,4) = '0404' ) AS jml_tindakan_umum_icu 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RI' 
					)
				FROM
					jenis_tindakan 
				WHERE
					jenis_tindakan.idtindakan LIKE'LA%' 
					AND jenis_tindakan.modality = '$modality'");
			}
		}

		function get_penerimaan_per_kelas_nonri($date, $modality) {
			if($modality == 'CR-DX') {
				return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00'
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ' 
						AND idrg != 'BA00'
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_luar 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_luar 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_luar
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_luar
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_rd
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ' 
						AND idrg = 'BA00'
					)
				FROM
					jenis_tindakan 
				WHERE
					jenis_tindakan.idtindakan LIKE'LA%' 
					AND jenis_tindakan.modality IN ('CR','DX')");
			} else {
				return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00'
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ' 
						AND idrg != 'BA00'
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_rj 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg != 'BA00' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_luar 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_luar 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_luar
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_luar
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'PL' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'BPJS') AS total_bpjs_rd
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'BPJS') AS jml_tindakan_bpjs_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT SUM
						( vtot ) FILTER ( WHERE cara_bayar = 'UMUM') AS total_umum_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ'
						AND idrg = 'BA00' 
					),
					(
					SELECT COUNT
						( jenis_tindakan ) FILTER ( WHERE cara_bayar = 'UMUM') AS jml_tindakan_umum_rd 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND pemeriksaan_radiologi.id_tindakan = jenis_tindakan.idtindakan 
						AND substr( no_register, 1, 2 ) = 'RJ' 
						AND idrg = 'BA00'
					)
				FROM
					jenis_tindakan 
				WHERE
					jenis_tindakan.idtindakan LIKE'LA%' 
					AND jenis_tindakan.modality = '$modality'");
			}
		}

		function get_waktu_tunggu_semua_igd($date1, $date2) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' AND a.idrg = 'BA00'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_dokter_pilih_petugas_igd($date1, $date2, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '2022-09-01' 
				AND '2022-09-30' AND a.idrg = 'BA00'
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_petugas_pilih_dokter_igd($date1, $date2, $dokter) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '2022-09-01' 
				AND '2022-09-30' AND a.idrg = 'BA00'
				AND A.id_dokter = '$dokter'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_pilih_dua_igd($date1, $date2, $dokter, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '2022-09-01' 
				AND '2022-09-30' AND a.idrg = 'BA00'
				AND A.id_dokter = '$dokter'
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_non($date1, $date2) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE		
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2'
				AND a.idrg != 'BA00'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE	
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_dokter_pilih_petugas_non($date1, $date2, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE		
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer'
				AND a.idrg != 'BA00'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_semua_petugas_pilih_dokter_non($date1, $date2, $dokter) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE	
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter' 
				AND a.idrg != 'BA00'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.hasil_simpan = '1'");
		}

		function get_waktu_tunggu_pilih_dua_non($date1, $date2, $dokter, $radiografer) {
			return $this->db->query("SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.cara_bayar,
				C.alamat,
				CASE
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_pasien WHERE no_register = b.no_register AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter' 
				AND a.id_radiografer = '$radiografer'
				AND a.idrg != 'BA00'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_ipd AS no_register,
				C.no_cm,
				C.nama,
				C.tgl_lahir,
				b.carabayar AS cara_bayar,
				C.alamat,
				CASE	
					WHEN ( C.sex = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				( SELECT diagnosa FROM diagnosa_iri WHERE no_ipd = b.no_ipd AND klasifikasi_diagnos = 'utama' LIMIT 1 ) AS diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_iri AS b ON b.no_ipd = A.no_register
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter' 
				AND a.id_radiografer = '$radiografer'
				AND a.hasil_simpan = '1' UNION
			SELECT A
				.jadwal AS tgl_periksa,
				A.jenis_tindakan,
				A.modality,
				b.no_register,
				CAST ( b.no_cm AS VARCHAR ),
				b.nama,
				b.tgl_lahir,
				b.cara_bayar,
				b.alamat,
				CASE
					WHEN ( b.jk = 'L' ) THEN
					'Laki Laki' ELSE'Perempuan' 
				END AS kelamin,
				CASE
					WHEN(substring(a.no_register,1,2) = 'RI') THEN a.idrg
					WHEN(substring(a.no_register,1,2) = 'RJ') THEN a.bed
					ELSE 'Pasien Luar'
				END AS asal,
				b.diagnosa,
				( SELECT NAME FROM hmis_users WHERE A.id_radiografer = userid LIMIT 1 ) AS radiografer,
				A.nm_dokter,
				A.tgl_kunjungan AS selesai_periksa,
				( SELECT CAST ( tanggal_isi AS TIMESTAMP ) FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = A.id_pemeriksaan_rad LIMIT 1 ) AS selesai_expert 
			FROM
				pemeriksaan_radiologi
				AS A INNER JOIN pasien_luar AS b ON b.no_register = A.no_register 
			WHERE
				to_char( A.jadwal, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND A.id_dokter = '$dokter'
				AND a.id_radiografer = CAST('$radiografer' AS INT)
				AND a.hasil_simpan = '1'");
		}

		function get_lap_ulang_bln($date) {
			return $this->db->query("SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR' ) 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT' ) 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA' ) 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US' ) 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' ) ) 
					END AS jml
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date' 
						AND modality IS NOT NULL 
				GROUP BY
					modality");
		}

		function get_lap_ulang_thn($date) {
			return $this->db->query("SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'JANUARI' AS bulan,
						01 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-01' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'FEBUARI' AS bulan,
						02 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-02' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'MARET' AS bulan,
						03 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-03' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'APRIL' AS bulan,
						04 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-04' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'MEI' AS bulan,
						05 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-05' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'JUNI' AS bulan,
						06 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-06' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'JULI' AS bulan,
						07 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-07' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'AGUSTUS' AS bulan,
						08 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-08' 
						AND modality IS NOT NULL 
				GROUP BY
					modality
				UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'SEPTEMBER' AS bulan,
						09 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-09' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'OKTOBER' AS bulan,
						10 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-10' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'NOVEMBER' AS bulan,
						11 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-11' 
						AND modality IS NOT NULL 
				GROUP BY
					modality UNION ALL
				SELECT
				CASE
					WHEN
						( modality = 'MR' ) THEN
							'Pencitraan MRI' 
							WHEN ( modality = 'CT' ) THEN
							'Radiografi CT Scan' 
							WHEN ( modality = 'LA' ) THEN
							'Radiografi Panoramic/Dental' 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							'Radiografi Konvensional' 
							WHEN ( modality = 'US' ) THEN
							'USG' 
						END AS modality,
					CASE
							WHEN ( modality = 'MR' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'MR') 
							WHEN ( modality = 'CT' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'CT') 
							WHEN ( modality = 'LA' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'LA') 
							WHEN ( modality = 'US' ) THEN
							SUM ( ulang ) FILTER ( WHERE modality = 'US') 
							WHEN ( modality IN ( 'DX', 'CR' ) ) THEN
							SUM ( ulang ) FILTER ( WHERE modality IN ( 'DX', 'CR' )) 
						END AS jml,
						'DESEMBER' AS bulan,
						12 AS bln 
					FROM
						pemeriksaan_radiologi 
					WHERE
						to_char( tgl_kunjungan, 'YYYY-MM' ) = '$date-12' 
						AND modality IS NOT NULL 
				GROUP BY
					modality
				ORDER BY bln ASC");
		}

		function get_data_laporan_bhp($date1, $date2) {
			return $this->db->query("SELECT A
				.no_register,
				c.nama,
				c.no_cm,
				b.bed,
				b.idrg,
				CASE WHEN (c.sex = 'L') THEN 'Laki Laki'
				ELSE 'Perempuan' END AS kelamin,
				b.cara_bayar,
				c.tgl_lahir,
				a.id_pemeriksaan_rad,
				b.jenis_tindakan
			FROM
				bhp_radiologi AS A
				INNER JOIN pemeriksaan_radiologi AS b ON a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				INNER JOIN data_pasien AS c ON b.no_medrec = c.no_medrec
			WHERE
				to_char(a.tanggal_input,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
				AND SUBSTRING(a.no_register,1,2) != 'PL' UNION
			SELECT A
				.no_register,
				c.nama,
				CAST(c.no_cm AS VARCHAR),
				b.bed,
				b.idrg,
				CASE WHEN (c.jk = 'L') THEN 'Laki Laki'
				ELSE 'Perempuan' END AS kelamin,
				b.cara_bayar,
				c.tgl_lahir,
				a.id_pemeriksaan_rad,
				b.jenis_tindakan
			FROM
				bhp_radiologi AS A
				INNER JOIN pemeriksaan_radiologi AS b ON a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				INNER JOIN pasien_luar AS c ON b.no_medrec = c.no_cm
			WHERE
				to_char(a.tanggal_input,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
				AND SUBSTRING(a.no_register,1,2) = 'PL'");
		}

		function get_data_bhp_detail($id) {
			return $this->db->query("SELECT
				a.no_register,
				b.jenis_tindakan,
				a.nama_bhp,
				a.satuan,
				a.kategori,
				a.qty
			FROM 
				bhp_radiologi AS A
				INNER JOIN pemeriksaan_radiologi AS b ON a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
			WHERE
				a.id_pemeriksaan_rad = '$id'");
		}

		function get_lap_bhp_excel($date1, $date2) {
			return $this->db->query("SELECT A
				.no_register,
				C.nama,
				C.no_cm,
				b.bed,
				b.idrg,
				CASE
					WHEN ( C.sex = 'L' ) THEN 'Laki Laki' 
					ELSE 'Perempuan' 
				END AS kelamin,
				b.cara_bayar,
				C.tgl_lahir,
				A.id_pemeriksaan_rad,
				b.jenis_tindakan,
				a.nama_bhp,
				a.satuan,
				a.kategori,
				a.qty
			FROM
				bhp_radiologi
				AS A INNER JOIN pemeriksaan_radiologi AS b ON A.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec 
			WHERE
				to_char( A.tanggal_input, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND SUBSTRING ( A.no_register, 1, 2 ) != 'PL' UNION
			SELECT A
				.no_register,
				C.nama,
				CAST ( C.no_cm AS VARCHAR ),
				b.bed,
				b.idrg,
				CASE
					WHEN ( C.jk = 'L' ) THEN 'Laki Laki' 
					ELSE 'Perempuan' 
				END AS kelamin,
				b.cara_bayar,
				C.tgl_lahir,
				A.id_pemeriksaan_rad,
				b.jenis_tindakan ,
				a.nama_bhp,
				a.satuan,
				a.kategori,
				a.qty
			FROM
				bhp_radiologi
				AS A INNER JOIN pemeriksaan_radiologi AS b ON A.id_pemeriksaan_rad = b.id_pemeriksaan_rad
				INNER JOIN pasien_luar AS C ON b.no_medrec = C.no_cm 
			WHERE
				to_char( A.tanggal_input, 'YYYY-MM-DD' ) BETWEEN '$date1' 
				AND '$date2' 
				AND SUBSTRING ( A.no_register, 1, 2 ) = 'PL'");
		}

		function get_bhp_per_tahun($date) {
			return $this->db->query("SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-01' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp 
				),
				'JANUARI' AS bulan,
				01 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-02' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'FEBUARI' AS bulan,
				02 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-03' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'MARET' AS bulan,
				03 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-04' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
					
				),
				'APRIL' AS bulan,
				04 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-05' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'MEI' AS bulan,
				05 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-06' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'JUNI' AS bulan,
				06 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-07' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'JULI' AS bulan,
				07 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-08' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'AGUSTUS' AS bulan,
				08 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-09' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'SEPTEMBER' AS bulan,
				09 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-10' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp 
				),
				'OKTOBER' AS bulan,
				10 AS bln
			FROM
				master_bhp_radiologi  UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-11' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'NOVEMBER' AS bulan,
				11 AS bln
			FROM
				master_bhp_radiologi UNION ALL
			SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date-12' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				),
				'DESEMBER' AS bulan,
				12 AS bln
			FROM
				master_bhp_radiologi
			ORDER BY bln ASC");
		}

		function get_bhp_per_bulan($date) {
			return $this->db->query("SELECT
				nama_bhp,
				(
				SELECT COUNT
					( nama_bhp ) AS jml 
				FROM
					bhp_radiologi 
				WHERE
					to_char( tanggal_input, 'YYYY-MM' ) = '$date' 
					AND bhp_radiologi.id_bhp = master_bhp_radiologi.id_bhp
				)
			FROM
				master_bhp_radiologi");
		}

		function get_lap_amprah_rad($date1, $date2) {
			return $this->db->query("SELECT
				a.qty_req,
				a.qty_acc,
				b.nm_obat,
				(SELECT nama_gudang FROM master_gudang WHERE id_gudang = a.id_gudang LIMIT 1) AS peminta,
				(SELECT nama_gudang FROM master_gudang WHERE id_gudang = a.id_gudang_tujuan LIMIT 1) AS tujuan
			FROM
				distribusi AS A
				INNER JOIN master_obat AS b ON a.id_obat = b.id_obat 
				INNER JOIN header_amprah AS c ON a.id_amprah = c.id_amprah
			WHERE
				a.id_gudang = 102
				AND to_char(c.tgl_amprah,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
		}

		function get_lap_pertumbuhan_by_expert($date1, $date2) {
			return $this->db->query("SELECT 
				to_char(tgl_kunjungan,'YYYY') AS tahun,
				COUNT(*) FILTER (WHERE cetak_hasil = 1) AS jml
			FROM 
				pemeriksaan_radiologi
			WHERE
				to_char(tgl_kunjungan,'YYYY') BETWEEN '$date1' AND '$date2'
			GROUP BY 
				tahun
			ORDER BY 
				tahun ASC");
		}

		function get_data_laporan_pasien_luar($tipe, $date) {
			if($tipe == 'Tanggal') {
				return $this->db->query("SELECT
					c.no_register,
					a.nama,
					a.tgl_kunjungan,
					c.jenis_tindakan,
					(SELECT tanggal_isi FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = c.id_pemeriksaan_rad LIMIT 1) AS tanggal_isi,
					a.cara_bayar,
					c.modality,
					c.accesion_number,
					c.tgl_generate,
					c.nm_dokter,
					a.nmkontraktor
				FROM 
					pasien_luar a,
					pemeriksaan_radiologi C
				WHERE 
					a.no_register = c.no_register 
					AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
				ORDER BY
					a.tgl_kunjungan DESC");
			} else {
				return $this->db->query("SELECT
					c.no_register,
					a.nama,
					a.tgl_kunjungan,
					c.jenis_tindakan,
					(SELECT tanggal_isi FROM hasil_pemeriksaan_rad WHERE id_pemeriksaan_rad = c.id_pemeriksaan_rad LIMIT 1) AS tanggal_isi,
					a.cara_bayar,
					c.modality,
					c.accesion_number,
					c.tgl_generate,
					c.nm_dokter,
					a.nmkontraktor
				FROM 
					pasien_luar a,
					pemeriksaan_radiologi C
				WHERE 
					a.no_register = c.no_register 
					AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$date'
				ORDER BY
					a.tgl_kunjungan DESC");
			}
		}

		function get_data_laporan_jumlah_pasien_luar($tipe, $date) {
			if($tipe == 'Tanggal') {
				return $this->db->query("SELECT 
					a.jenis_tindakan,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS drommy_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS drommy_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS drommy_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS. Madina%') AS drommy_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS drommy_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS drommy_blank,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS drwid_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS drwid_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS drwid_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS. Madina%') AS drwid_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS drwid_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS drwid_blank,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS blank_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS blank_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS blank_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS. Madina%') AS blank_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS blank_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS blank_blank
				FROM 
					pemeriksaan_radiologi A,
					pasien_luar c
				WHERE 
					SUBSTRING(a.no_register,1,2) = 'PL'
					AND a.no_register = c.no_register
					AND to_char(c.tgl_kunjungan,'YYYY-MM-DD') = '$date'
				GROUP BY 
					a.jenis_tindakan");
			} else {
				return $this->db->query("SELECT 
					a.jenis_tindakan,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS drommy_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS drommy_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS drommy_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RS. Madina%') AS drommy_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS drommy_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '330' AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS drommy_blank,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS drwid_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS drwid_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS drwid_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RS. Madina%') AS drwid_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS drwid_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter = '329' AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS drwid_blank,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%BPJS - Mandiri%') AS blank_bpjs_mandiri,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS Ahmad Mochtar Bukittingi%') AS blank_rsam,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS. Adnan WD Payakumbuh%') AS blank_rs_payakumbuh,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RS. Madina%') AS blank_madina,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND c.nmkontraktor LIKE '%RST Bukittinggi%') AS blank_rst,
					COUNT(a.jenis_tindakan) FILTER (WHERE a.id_dokter IS NULL AND (c.nmkontraktor iS NULL OR c.nmkontraktor IN ('','--Pilih Kontraktor--'))) AS blank_blank
				FROM 
					pemeriksaan_radiologi A,
					pasien_luar c
				WHERE 
					SUBSTRING(a.no_register,1,2) = 'PL'
					AND a.no_register = c.no_register
					AND to_char(c.tgl_kunjungan,'YYYY-MM') = '$date'
				GROUP BY 
					a.jenis_tindakan");
			}
		}

		function get_data_laporan_jumlah_pasien_cetak_billing($tipe, $date) {
			if($tipe == 'Tanggal') {
				return $this->db->query("SELECT 
					a.no_register,
					c.no_cm,
					c.nama,
					a.jenis_tindakan,
					a.cara_bayar,
					a.tgl_generate AS tgl_cetak_billing
				FROM 
					pemeriksaan_radiologi a,
					data_pasien c 
				WHERE 
					a.no_medrec = c.no_medrec 
					AND to_char(a.tgl_generate,'YYYY-MM-DD') = '$date'
					AND substring(a.no_register,1,2) != 'PL'
					AND a.accesion_number IS NOT NULL UNION 
				SELECT 
					a.no_register,
					'Pasien Luar' AS no_cm,
					c.nama,
					a.jenis_tindakan,
					a.cara_bayar,
					a.tgl_generate AS tgl_cetak_billing
				FROM 
					pemeriksaan_radiologi a,
					pasien_luar c 
				WHERE 
					a.no_register = c.no_register
					AND to_char(a.tgl_generate,'YYYY-MM-DD') = '$date'
					AND substring(a.no_register,1,2) = 'PL'
					AND a.accesion_number IS NOT NULL
				ORDER BY 
					tgl_cetak_billing DESC");
			} else {
				return $this->db->query("SELECT 
					a.no_register,
					c.no_cm,
					c.nama,
					a.jenis_tindakan,
					a.cara_bayar,
					a.tgl_generate AS tgl_cetak_billing
				FROM 
					pemeriksaan_radiologi a,
					data_pasien c 
				WHERE 
					a.no_medrec = c.no_medrec 
					AND to_char(a.tgl_generate,'YYYY-MM') = '$date'
					AND substring(a.no_register,1,2) != 'PL'
					AND a.accesion_number IS NOT NULL UNION 
				SELECT 
					a.no_register,
					'Pasien Luar' AS no_cm,
					c.nama,
					a.jenis_tindakan,
					a.cara_bayar,
					a.tgl_generate AS tgl_cetak_billing
				FROM 
					pemeriksaan_radiologi a,
					pasien_luar c 
				WHERE 
					a.no_register = c.no_register
					AND to_char(a.tgl_generate,'YYYY-MM') = '$date'
					AND substring(a.no_register,1,2) = 'PL'
					AND a.accesion_number IS NOT NULL
				ORDER BY 
					tgl_cetak_billing DESC");
			}
		}
	}
?>