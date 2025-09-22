<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class rjmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_data_kunj_all($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT * from sum_detail_jumlah_kunjungan where tanggal>='$tgl_awal' and tanggal<='$tgl_akhir'");
		}
		function get_data_iri_masuk_lt1($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='1' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_masuk_lt2($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='2' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_masuk_lt3($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='3' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_keluar_lt1($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='1' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_iri_keluar_lt2($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='2' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_iri_keluar_lt3($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='3' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_ird_masuk($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from irddaftar_ulang where to_char(tgl_kunjungan,'YYYY-MM-DD')>='$tgl_awal' and to_char(tgl_kunjungan,'YYYY-MM-DD')<='$tgl_akhir' GROUP BY tgl_kunjungan");
		}
		function get_data_irj_masuk($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from daftar_ulang_irj where to_char(tgl_kunjungan,'YYYY-MM-DD')>='$tgl_awal' and to_char(tgl_kunjungan,'YYYY-MM-DD')<='$tgl_akhir' GROUP BY tgl_kunjungan");
		}

		function get_pasien_baru_irj($tgl) {
			$data = $this->db->query("SELECT a.*, b.nm_poli, c.nm_dokter, d.nama
			FROM
				daftar_ulang_irj AS a,
				poliklinik AS b,
				data_dokter AS c,
				data_pasien AS d
			WHERE
				a.id_poli = b.id_poli
				AND a.no_medrec = d.no_medrec
				AND a.id_dokter = c.id_dokter
				AND a.jns_kunj = 'BARU'
				AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$tgl'
			ORDER BY
				a.tgl_kunjungan DESC");
			
			return $data->result_array();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_pendapatan_perpoli($date_awal,$date_akhir){
			$data=$this->db->query("select b.id_poli, b.nm_poli, c.tanggal, ifnull(c.total,0) as total, ifnull(c.jumlah,0) as jumlah from poliklinik b left JOIN  
(SELECT a.tanggal, sum(a.penerimaan) as total, sum(a.jumlah_os) as jumlah, a.nm_poli , a.id_poli
FROM  v_pendapatan_rawat_jalan a 
where left(a.tanggal,16)>'$date_awal' and left(a.tanggal,16)<'$date_akhir'
group by a.id_poli) as c
on c.id_poli=b.id_poli");
			return $data->result_array();
			//SELECT tanggal, sum(penerimaan) as total, sum(jumlah_os) as jumlah, nm_poli FROM v_pendapatan_rawat_jalan where left(tanggal,16)>'$date_awal' and left(tanggal,16)<'$date_akhir' 	group by id_poli
		}

		function get_rekap_harian_kasir($date_awal,$date_akhir,$xuser){
			$data=$this->db->query("SELECT
	a.*,
	d.kasir,
	b.id_poli,
	e.nm_poli,
	c.nama,
	c.no_cm,
	b.vtot,
	 ( SELECT string_agg( DISTINCT kel_tind.nama_kel, E' + ' ) FROM kel_tind, pelayanan_poli, jenis_tindakan WHERE pelayanan_poli.idkwitansi = a.idno_kwitansi and jenis_tindakan.idtindakan=pelayanan_poli.idtindakan
	and jenis_tindakan.idkel_tind=kel_tind.idkel_tind) AS nama_kel 
	FROM nomor_kwitansi a
LEFT JOIN dyn_kasir_user d ON a.id_loket=d.kasir
LEFT JOIN daftar_ulang_irj b ON a.no_register=b.no_register
LEFT JOIN poliklinik e ON b.id_poli=e.id_poli
JOIN data_pasien c ON c.no_medrec=b.no_medrec
where TO_CHAR(a.xcreate,'YYYY-MM-DD HH24:MI')>='$date_awal' AND TO_CHAR(a.xcreate,'YYYY-MM-DD HH24:MI')<='$date_akhir'
and d.userid=$xuser");
			return $data->result_array();
			//SELECT tanggal, sum(penerimaan) as total, sum(jumlah_os) as jumlah, nm_poli FROM v_pendapatan_rawat_jalan where left(tanggal,16)>'$date_awal' and left(tanggal,16)<'$date_akhir' 	group by id_poli
		}

		function get_data_kunj_harian($tgl, $id_poli,$cara_bayar,$bayar_bpjs){
			$textbb='';
			if($cara_bayar!='SEMUA'){
				$textcb="and du.cara_bayar='$cara_bayar'";
				// IF($cara_bayar=='KERJASAMA'){
				// 	$textcb="and du.cara_bayar='KERJASAMA'";
				// }else{
				// 	$textcb="and du.cara_bayar='$cara_bayar'";
				// 	if($bayar_bpjs!='SEMUA' && $cara_bayar=='BPJS'){
				// 		$textbb="and du.id_kontraktor='".$bayar_bpjs."'";
				// 	}
				// }
			} else $textcb='';
			// return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar,
			// 	                     NULLIF(du.ket_pulang,'-') as ket_pulang,
			// 							(SELECT diag.diagnosa  
			// 							FROM diagnosa_pasien AS diag
			// 							WHERE diag.no_register=du.no_register
			// 							AND diag.klasifikasi_diagnos='utama' GROUP BY no_register LIMIT 1) AS diagnosa,
			// 							(SELECT kon.nmkontraktor  
			// 							FROM kontraktor AS kon
			// 							WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor,
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE to_char(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' AND du.id_poli='$id_poli' and du.status = 1 and a.ket_pulang !='BATAL_PELAYANAN_POLI' $textcb $textbb

			// 						ORDER BY du.no_register ");
			
			return $this->db->query("SELECT 
				(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa LIMIT 1) AS nm_diagnosa,
				du.id_poli, 
				du.no_register, 
				du.no_medrec, 
				dp.nama,
				dp.kotakabupaten, 
				dp.alamat,
				dp.no_cm, 
				du.cara_bayar,
				du.wkt_penyerahan_obat, 
				NULLIF(dp.no_nrp,'-') as no_nrp, 
				NULLIF(du.ket_pulang,'-') as ket_pulang, 
			--(SELECT hub.hub_name FROM tni_hubungan AS hub WHERE hub.hub_id=dp.nrp_sbg LIMIT 1) AS nrp_sbg, 
				(SELECT kon.nmkontraktor FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor LIMIT 1) AS kontraktor,
				(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter LIMIT 1) as nm_dokter,
				dp.tgl_lahir,
				dp.sex,
				dp.kotakabupaten,
				du.diag_baru,
				du.jns_kunj,
				du.id_poli,
				du.waktu_masuk_poli ,
				du.waktu_masuk_dokter,
				du.waktu_pulang,
				du.tgl_kunjungan,
				(SELECT id_diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) as id_diagnosa,
				(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) AS diagnosa,
				CASE
					WHEN(du.xcreate = 'APM') THEN 'APM'
					ELSE (SELECT name FROM hmis_users WHERE du.xcreate = username LIMIT 1)
				END AS xdaftar,
				du.no_sep
			FROM 
				daftar_ulang_irj AS du 
				LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
			WHERE 
				du.id_poli != 'BA00'  
				and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' $textcb $textbb 
				and du.id_poli='$id_poli'
				and (ket_pulang <> 'BATAL_PELAYANAN_POLI' or ket_pulang is null)  
			ORDER BY 
				no_register, id_poli");
		}

		function get_data_pasien_konsul_irj($week_awal, $week_akhir) {
			$data = $this->db->query("SELECT
				a.id, a.no_register AS no_reg, a.nama_pasien, a.diagnosa, a.tanggal_konsul,
				(SELECT nm_dokter FROM data_dokter WHERE CAST(a.id_dokter_asal AS INT) = id_dokter) AS dokter_asal,
				(SELECT nm_dokter FROM data_dokter WHERE CAST(a.id_dokter_akhir AS INT) = id_dokter) AS dokter_akhir,
				(SELECT nm_poli FROM poliklinik WHERE a.id_poli_asal = id_poli) AS poli_asal,
				(SELECT nm_poli FROM poliklinik WHERE a.id_poli_akhir = id_poli) AS poli_akhir,
				(SELECT no_medrec FROM daftar_ulang_irj WHERE a.no_register = no_register_lama LIMIT 1) AS no_medrec
			FROM
				konsul_dokter AS a
				--INNER JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register_lama
			WHERE
				a.verif_daftar IS NULL
				AND a.tanggal_konsul BETWEEN '$week_awal' AND '$week_akhir'
			");

			return $data->result();
		}

		function get_data_kunj_harian_dokter($tgl, $id_poli,$cara_bayar,$bayar_bpjs,$id_dokter){
			$textbb='';
			if($cara_bayar!='SEMUA'){
				$textcb="and du.cara_bayar='$cara_bayar'";
				// IF($cara_bayar=='KERJASAMA'){
				// 	$textcb="and du.cara_bayar='KERJASAMA'";
				// }else{
				// 	$textcb="and du.cara_bayar='$cara_bayar'";
				// 	if($bayar_bpjs!='SEMUA' && $cara_bayar=='BPJS'){
				// 		$textbb="and du.id_kontraktor='".$bayar_bpjs."'";
				// 	}
				// }
			} else $textcb='';
			// return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar,
			// 	                     NULLIF(du.ket_pulang,'-') as ket_pulang,
			// 							(SELECT diag.diagnosa  
			// 							FROM diagnosa_pasien AS diag
			// 							WHERE diag.no_register=du.no_register
			// 							AND diag.klasifikasi_diagnos='utama' GROUP BY no_register LIMIT 1) AS diagnosa,
			// 							(SELECT kon.nmkontraktor  
			// 							FROM kontraktor AS kon
			// 							WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor,
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE to_char(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' AND du.id_poli='$id_poli' and du.status = 1 and a.ket_pulang !='BATAL_PELAYANAN_POLI' $textcb $textbb

			// 						ORDER BY du.no_register ");
			
			return $this->db->query("SELECT 
				(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa LIMIT 1) AS nm_diagnosa,
				du.id_poli, 
				du.no_register, 
				du.no_medrec, 
				dp.nama,
				dp.kotakabupaten,
				dp.alamat, 
				dp.no_cm, 
				du.cara_bayar,
				du.wkt_penyerahan_obat, 
				NULLIF(dp.no_nrp,'-') as no_nrp, 
				NULLIF(du.ket_pulang,'-') as ket_pulang, 
			--(SELECT hub.hub_name FROM tni_hubungan AS hub WHERE hub.hub_id=dp.nrp_sbg LIMIT 1) AS nrp_sbg, 
				(SELECT kon.nmkontraktor FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor LIMIT 1) AS kontraktor,
				(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter LIMIT 1) as nm_dokter,
				dp.tgl_lahir,
				dp.sex,
				dp.kotakabupaten,
				du.diag_baru,
				du.jns_kunj,
				du.id_poli,
				du.waktu_masuk_poli ,
				du.waktu_masuk_dokter,
				du.waktu_pulang,
				du.tgl_kunjungan,
				(SELECT id_diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) as id_diagnosa,
				(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) AS diagnosa,
				CASE
					WHEN(du.xcreate = 'APM') THEN 'APM'
					ELSE (SELECT name FROM hmis_users WHERE du.xcreate = username LIMIT 1)
				END AS xdaftar,
				du.no_sep
			FROM 
				daftar_ulang_irj AS du 
				LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
			WHERE 
				du.id_poli != 'BA00'  
				and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' $textcb $textbb 
				and du.id_poli='$id_poli'
				and du.id_dokter = '$id_dokter'
				and (ket_pulang <> 'BATAL_PELAYANAN_POLI' or ket_pulang is null)  
			ORDER BY 
				no_register, id_poli");
		}
		
		function get_data_kunj_bulanan($bulan, $id_poli){

			return $this->db->query("SELECT 
					TO_CHAR(d.tgl_kunjungan, 'YYYY-MM-DD') AS tgl_kunj,
					d.id_poli,
					COUNT(*) AS jumlah_kunj, 
					SUM(CASE WHEN d.jns_kunj = 'BARU' THEN 1 ELSE 0 END) AS pasien_baru, 
					SUM(CASE WHEN d.jns_kunj = 'LAMA' THEN 1 ELSE 0 END) AS pasien_lama,  
					SUM(CASE WHEN d.ket_pulang = 'BATAL_PELAYANAN_POLI' THEN 1 ELSE 0 END) AS jumlah_batal,
					u.name AS nmuser
				FROM daftar_ulang_irj d
				LEFT JOIN hmis_users u ON d.xuser::int = u.userid
				WHERE d.id_poli != 'BA00'  
				AND TO_CHAR(d.tgl_kunjungan,'YYYY-MM') = '$bulan' 
				AND d.id_poli = '$id_poli'
				GROUP BY 
					TO_CHAR(d.tgl_kunjungan,'YYYY-MM-DD'),
					d.id_poli,
					u.name
				ORDER BY tgl_kunj, d.id_poli");
		}
		
		function get_data_kunj_tahunan($tahun, $id_poli){
			return $this->db->query("SELECT TO_CHAR(tgl_kunjungan,'MM') AS bulan_kunj, count(*) AS jumlah_kunj ,id_poli
										FROM daftar_ulang_irj 
										WHERE daftar_ulang_irj.id_poli != 'BA00'  
										and TO_CHAR(tgl_kunjungan,'YYYY')='$tahun' AND id_poli='$id_poli'
										GROUP BY TO_CHAR(tgl_kunjungan,'MM'),id_poli");
		}
		
		function get_data_kunj_poli_harian($tgl, $cara_bayar,$bayar_bpjs){
			$textbb='';
			if($cara_bayar!='SEMUA'){
				IF($cara_bayar=='KERJASAMA'){
					$textcb="and du.cara_bayar='KERJASAMA'";
				}else{
					$textcb="and du.cara_bayar='$cara_bayar'";
					// if($bayar_bpjs!='SEMUA' && $cara_bayar=='BPJS'){
					// 	$textbb="and du.id_kontraktor='".$bayar_bpjs."'";
					// }
				}
			}else $textcb='';


			// return $this->db->query("SELECT du.id_poli, du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, IFNULL(dp.no_nrp,'-') as no_nrp, IFNULL(du.ket_pulang,'-') as ket_pulang,
			// 							(SELECT hub.hub_name  
			// 							FROM tni_hubungan AS hub
			// 							WHERE hub.hub_id=dp.nrp_sbg) AS nrp_sbg,
			// 							(SELECT diag.diagnosa  
			// 							FROM diagnosa_pasien AS diag
			// 							WHERE diag.no_register=du.no_register
			// 							AND diag.klasifikasi_diagnos='utama' LIMIT 1) AS diagnosa,
			// 							(SELECT kon.nmkontraktor  
			// 							FROM kontraktor AS kon
			// 							WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10) = '$tgl' $textcb $textbb
			// 						ORDER BY no_register, id_poli");

			return $this->db->query("SELECT 
				(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa LIMIT 1) AS nm_diagnosa,
				du.id_poli, 
				du.no_register, 
				du.no_medrec, 
				dp.nama,
				dp.alamat,
				dp.kotakabupaten, 
				dp.no_cm, 
				du.cara_bayar,
				du.wkt_penyerahan_obat, 
				NULLIF(dp.no_nrp,'-') as no_nrp, 
				NULLIF(du.ket_pulang,'-') as ket_pulang, 
			--(SELECT hub.hub_name FROM tni_hubungan AS hub WHERE hub.hub_id=dp.nrp_sbg LIMIT 1) AS nrp_sbg, 
				(SELECT kon.nmkontraktor FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor LIMIT 1) AS kontraktor,
				(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter LIMIT 1) as nm_dokter,
				dp.tgl_lahir,
				dp.sex,
				dp.kotakabupaten,
				du.diag_baru,
				du.jns_kunj,
				du.id_poli,
				du.waktu_masuk_poli ,
				du.waktu_masuk_dokter,
				du.waktu_pulang,
				du.tgl_kunjungan,
				(SELECT id_diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) as id_diagnosa,
				(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) AS diagnosa,
				CASE
					WHEN(du.xcreate = 'APM') THEN 'APM'
					ELSE (SELECT name FROM hmis_users WHERE du.xcreate = username LIMIT 1)
				END AS xdaftar,
				du.no_sep
			FROM 
				daftar_ulang_irj AS du 
				LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
			WHERE 
				du.id_poli != 'BA00'  
				and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl'
				$textcb $textbb ORDER BY no_register, id_poli");
					//and (ket_pulang <> 'BATAL_PELAYANAN_POLI' or ket_pulang is null) 
		}

		function get_lap_jml_dpjp_today($tgl) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli != 'BA00'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_dpjp_harian($tgl) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli != 'BA00'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_dpjp_harian($tgl) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				A.tanggal_konsul = '$tgl' 
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_kunj_data_pasien_igd($tgl) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli = 'BA00'");

			return $data->result_array();
		}

		function get_diagnosa_pasien() {
			return $this->db->query("SELECT * FROM diagnosa_pasien");
		}

		function get_lap_kunj_data_pasien_igd_bulan($bulan) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli = 'BA00'");

			return $data->result_array();
		}

		function get_lap_kunj_data_pasien_igd_tahun($tahun) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli = 'BA00'");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga($tgl) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli != 'BA00'
				AND a.id_poli != 'BK04'
				AND a.id_poli != 'BK01'
				AND a.id_poli != 'BK08'
				AND a.id_poli != 'BK07'
				AND a.id_poli != 'BK02'
				AND a.id_poli != 'BK05'
				AND a.id_poli != 'BK00'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga($tgl) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli IN ('BK01','BK04','BK08','BK07','BK02','BK05','BK00')");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga_bulan($bulan) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli != 'BA00'
				AND a.id_poli != 'BK04'
				AND a.id_poli != 'BK01'
				AND a.id_poli != 'BK08'
				AND a.id_poli != 'BK07'
				AND a.id_poli != 'BK02'
				AND a.id_poli != 'BK05'
				AND a.id_poli != 'BK00'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga_bulan($bulan) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli IN ('BK01','BK04','BK08','BK07','BK02','BK05','BK00')");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga_tahun($tahun) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli != 'BA00'
				AND a.id_poli != 'BK04'
				AND a.id_poli != 'BK01'
				AND a.id_poli != 'BK08'
				AND a.id_poli != 'BK07'
				AND a.id_poli != 'BK02'
				AND a.id_poli != 'BK05'
				AND a.id_poli != 'BK00'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga_tahun($tahun) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli IN ('BK01','BK04','BK08','BK07','BK02','BK05','BK00')");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga_pilih($tgl, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga_pilih($tgl, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga_bulan_pilih($bulan, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga_bulan_pilih($bulan, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_poli_irj_gaada_tiga_tahun_pilih($tahun, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_poli_irj_ada_tiga_tahun_pilih($tahun, $id_poli) {
			$data = $this->db->query("SELECT 
				a.*, b.nm_dokter, c.*, d.nm_poli,
				CASE WHEN(c.sex = 'L') THEN 'Laki Laki' ELSE 'Perempuan' END AS kelamin,
				(SELECT diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS diag1,
				(SELECT id_diagnosa FROM diagnosa_pasien WHERE a.no_register = no_register AND to_char(a.tgl_kunjungan, 'YYYY') = '$tahun' LIMIT 1) AS id_diag
			FROM
				daftar_ulang_irj AS a 
				INNER JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
				INNER JOIN poliklinik AS d ON a.id_poli = d.id_poli
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli = '$id_poli'");

			return $data->result_array();
		}

		function get_lap_jml_dpjp_bulanan($bulan) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli != 'BA00'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_dpjp_bulanan($bulan) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') = '$bulan' 
			-- 	AND A.id_poli_akhir = 'BK00'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}


		function get_lap_jml_dpjp_tahunan($tahun) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli != 'BA00'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_dpjp_tahunan($tahun) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY') = '$tahun' 
			-- 	AND A.id_poli_akhir = 'BK00'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_jml_dpjp_triwulan($bulan_awal, $bulan_akhir) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'
				AND a.id_poli != 'BA00'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_dpjp_triwulan($bulan_awal, $bulan_akhir) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir' 
			-- 	AND A.id_poli_akhir = 'BK00'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_jml_harian_dpjp($tgl, $id_poli) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_harian_dpjp($tgl, $id_poli) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				A.tanggal_konsul = '$tgl' 
				AND A.id_poli_akhir = '$id_poli'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_jml_bulanan_dpjp($bulan, $id_poli) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_bulanan_dpjp($bulan, $id_poli) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') = '$bulan' 
			 	AND A.id_poli_akhir = '$id_poli'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_jml_tahunan_dpjp($tahun, $id_poli) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_tahunan_dpjp($tahun, $id_poli) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY') = '$tahun' 
			 	AND A.id_poli_akhir = '$id_poli'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function get_lap_jml_triwulan_dpjp($bulan_awal, $bulan_akhir, $id_poli) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function get_lap_jml_konsul_triwulan_dpjp($bulan_awal, $bulan_akhir, $id_poli) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir' 
			 	AND A.id_poli_akhir = '$id_poli'
			-- 	AND A.id_dokter_akhir = '189'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function  get_lap_jml_harian_per_dpjp($tgl, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = '$id_dokter'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function  get_lap_jml_konsul_harian_per_dpjp($tgl, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				A.tanggal_konsul = '$tgl' 
				AND A.id_poli_akhir = '$id_poli'
				AND A.id_dokter_akhir = '$id_dokter'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function  get_lap_jml_bulanan_per_dpjp($bulan, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') = '$bulan'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = '$id_dokter'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function  get_lap_jml_konsul_bulanan_per_dpjp($bulan, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') = '$bulan' 
			 	AND A.id_poli_akhir = '$id_poli'
			 	AND A.id_dokter_akhir = '$id_dokter'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function  get_lap_jml_tahunan_per_dpjp($tahun, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY') = '$tahun'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = '$id_dokter'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function  get_lap_jml_konsul_tahunan_per_dpjp($tahun, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY') = '$tahun' 
			 	AND A.id_poli_akhir = '$id_poli'
			 	AND A.id_dokter_akhir = '$id_dokter'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}

		function  get_lap_jml_triwulan_per_dpjp($bulan_awal, $bulan_akhir, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT count(*) AS jumlah, b.nm_dokter, c.nm_poli
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b,
				poliklinik AS c
			WHERE
				to_char(a.tgl_kunjungan, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'
				AND a.id_poli = '$id_poli'
				AND a.id_dokter = '$id_dokter'
				AND a.id_dokter = b.id_dokter
				AND a.id_poli = c.id_poli
			GROUP BY
				b.nm_dokter,
				c.nm_poli");

			return $data->result_array();
		}

		function  get_lap_jml_konsul_triwulan_per_dpjp($bulan_awal, $bulan_akhir, $id_poli, $id_dokter) {
			$data = $this->db->query("SELECT COUNT
				( * ) AS jumlah,
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
			CASE
					WHEN ( A.opsi_konsul = 'konsultasi_sekali' ) THEN
					'Konsultasi Sekali' 
					WHEN ( A.opsi_konsul = 'rawat_bersama' ) THEN
					'Rawat Bersama' 
					WHEN ( A.opsi_konsul = 'alih_rawat' ) THEN
					'Alih Rawat' ELSE'' 
				END AS opsi 
			FROM
				konsul_dokter AS A,
				data_dokter AS b,
				poliklinik AS C 
			WHERE
				to_char(A.tanggal_konsul, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir' 
			 	AND A.id_poli_akhir = '$id_poli'
			 	AND A.id_dokter_akhir = '$id_dokter'
				AND CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter 
				AND A.id_poli_akhir = C.id_poli 
			GROUP BY
				b.nm_dokter,
				C.nm_poli,
				A.tanggal_konsul,
				A.opsi_konsul");

			return $data->result_array();
		}
		
		function get_data_kunj_poli_bulanan($bulan){
			return $this->db->query("SELECT
			d.id_poli,
			TO_CHAR(d.tgl_kunjungan, 'YYYY-MM-DD') AS tgl_kunj,
			COUNT(d.no_register) AS jumlah_kunj,
			SUM(CASE WHEN d.jns_kunj = 'BARU' THEN 1 ELSE 0 END) AS pasien_baru,
			SUM(CASE WHEN d.jns_kunj = 'LAMA' THEN 1 ELSE 0 END) AS pasien_lama,
			SUM(CASE WHEN d.cara_bayar = 'UMUM' THEN 1 ELSE 0 END) AS umum,
			SUM(CASE WHEN d.cara_bayar = 'BPJS' THEN 1 ELSE 0 END) AS bpjs,
			SUM(CASE WHEN d.cara_bayar = 'KERJASAMA' THEN 1 ELSE 0 END) AS kerjasama,
			SUM(CASE WHEN d.ket_pulang = 'BATAL_PELAYANAN_POLI' THEN 1 ELSE 0 END) AS jumlah_batal,
			u.name AS nmuser
			FROM
			daftar_ulang_irj d
			LEFT JOIN hmis_users u ON d.xuser::int = u.userid
			WHERE
			d.id_poli != 'BA00'
			AND TO_CHAR(d.tgl_kunjungan, 'YYYY-MM') = '$bulan'
			GROUP BY
			TO_CHAR(d.tgl_kunjungan, 'YYYY-MM-DD'),
			d.id_poli,
			u.name
			ORDER BY
			tgl_kunj, d.id_poli;");
 
		}
		
		function get_data_kunj_poli_tahunan($tahun){
			return $this->db->query("SELECT id_poli, TO_CHAR(tgl_kunjungan,'MM') AS bulan_kunj, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE daftar_ulang_irj.id_poli != 'BA00'  
										and TO_CHAR(tgl_kunjungan,'YYYY')='$tahun'
										GROUP BY TO_CHAR(tgl_kunjungan,'MM'), id_poli");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////keuangan
		function get_data_keu_harian($tgl, $tgl1, $id_poli){
			
			// return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.diskon,'0') as diskon, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' 
			// 						AND LEFT(du.tgl_kunjungan,10)<= '$tgl1'
			// 						AND du.id_poli='$id_poli' 
			// 						ORDER BY no_register 
			// 						");

				return $this->db->query("SELECT du.no_register,dp.no_cm, du.no_medrec, dp.nama, 
				CASE WHEN CAST(du.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, du.biayadaftar, du.vtot, 
				NULLIF(du.vtot_lab,0) as vtot_lab, 
				NULLIF(du.vtot_rad,0) as vtot_rad, NULLIF(du.vtot_pa,0) as vtot_pa, NULLIF(du.vtot_obat,0) as vtot_obat, 
				du.cara_bayar, NULLIF(du.tunai,'0') as tunai, NULLIF(du.tunai2,'0') as tunai2, NULLIF(du.vtot_ok,0) as vtot_ok, 
				NULLIF(du.diskon,'0') as diskon, NULLIF(du.diskon2,'0') as diskon2, NULLIF(du.nilai_kkkd,'0') as nilai_kkkd, 
				NULLIF(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	
				as nmkontraktor
							FROM daftar_ulang_irj AS du
							LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
							WHERE TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')>= '$tgl' 
							and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')<= '$tgl1' 
							AND du.id_poli='$id_poli' 
							ORDER BY no_register
				");
		}
		
		function get_data_keu_bulanan($bulan, $id_poli, $status, $cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, count(*) AS jumlah_kunj,
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar
										FROM daftar_ulang_irj 
										WHERE LEFT(tgl_kunjungan,7)='$bulan' AND id_poli='$id_poli' $select_status $select_cara_bayar
										GROUP BY LEFT(tgl_kunjungan,10)");
		}
		
		function get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj,
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun' AND id_poli='$id_poli' $select_status $select_cara_bayar
										GROUP BY SUBSTR(tgl_kunjungan,6,2)");
		}
		
		function get_data_keu_poli_harian($tgl,$tgl1){			
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, 
				CASE WHEN CAST(du.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, du.biayadaftar, du.vtot, 
				NULLIF(du.vtot_lab,0) as vtot_lab, 
				NULLIF(du.vtot_rad,0) as vtot_rad, NULLIF(du.vtot_pa,0) as vtot_pa, NULLIF(du.vtot_obat,0) as vtot_obat, 
				du.cara_bayar, NULLIF(du.tunai,'0') as tunai, NULLIF(du.tunai2,'0') as tunai2, NULLIF(du.vtot_ok,0) as vtot_ok, 
				NULLIF(du.diskon,'0') as diskon, NULLIF(du.diskon2,'0') as diskon2, NULLIF(du.nilai_kkkd,'0') as nilai_kkkd, 
				NULLIF(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	
				as nmkontraktor
													FROM daftar_ulang_irj AS du
													LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
													WHERE TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')>= '$tgl' and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')<= '$tgl1' 
													ORDER BY no_register,id_poli ");
		}
		
		function get_data_keu_poli_bulanan($bulan,$status,$cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT id_poli, DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, 
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj, sum(vtot_lab) as jumlah_lab, sum(vtot_rad) as jumlah_rad,
										sum(vtot_obat) as jumlah_obat
										FROM daftar_ulang_irj 
										WHERE LEFT(tgl_kunjungan,7)='$bulan' $select_status $select_cara_bayar
										GROUP BY LEFT(tgl_kunjungan,10), id_poli");
		}
		
		function get_data_keu_poli_tahunan($tahun,$status,$cara_bayar){
			//MONTHNAME(LEFT(tgl_kunjungan,10))
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT id_poli, SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj, 
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun' $select_status $select_cara_bayar
										GROUP BY SUBSTR(tgl_kunjungan,6,2), id_poli");
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////LAP KEUANGAN
		function get_data_keu_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar){
			
			$select="";
			if ($id_dokter!='SEMUA') {
				$select=" AND id_dokter='$id_dokter' ";
			}
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			return $this->db->query("Select * from (SELECT * FROM tindakan_all 
										WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir' $select $select_cara_bayar
										ORDER BY tgl) as a, data_dokter b where a.id_dokter=b.id_dokter");
		}
		
		function get_data_keu_det_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar){
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			return $this->db->query("Select * from (SELECT * FROM tindakan_all 
										WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir' $select_cara_bayar
										ORDER BY tgl) as a, data_dokter b where a.id_dokter=b.id_dokter group by a.id_dokter");
		}
		function get_nm_dokter($id_dokter){

			return $this->db->query("SELECT nm_dokter FROM data_dokter 
										WHERE id_dokter='$id_dokter'");
		}

		function get_kunj_pasien_detail($tampil, $date){
			if($tampil == 'TGL') {
				$data = $this->db->query("SELECT 
					* 
				FROM  
					lap_kunj_pasien_irj_detail 
				WHERE 
					tanggal = '$date'");
				return $data->result_array();
			} else {
				$data = $this->db->query("SELECT 
					* 
				FROM  
					lap_kunj_pasien_irj_detail 
				WHERE 
					tanggal LIKE '$date%'");
				return $data->result_array();
			}
		}
		
		function get_nama_poli_by_id($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function get_dokter_poli($id_poli){

			
				return $this->db->query("SELECT dd.nm_dokter,dd.id_dokter
					FROM
					    data_dokter AS dd, dokter_poli as dp
					WHERE
					    dd.id_dokter =  dp.id_dokter and
					    dp.id_poli = '$id_poli'
					        AND dd.deleted != '1'
							group by dd.nm_dokter,dd.id_dokter
					ORDER BY dd.nm_dokter");
								
		 				
		}

		
		function get_kunj_diagnosa_kasus_jenkel($date,$lap_per,$layanan){
			if($layanan == 'rj'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel where id_poli != 'BA00'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' and id_poli != 'BA00'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY-MM') = '$date' and id_poli != 'BA00'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}
			}else if($layanan == 'rd'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' and id_poli = 'BA00'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY-MM') = '$date' and id_poli = 'BA00'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}else{
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}
			}else if($layanan == 'ri'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(hidup) as baru,
					sum (mati) as lama,
					sum(hidup) + sum(mati) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel_ri
						where tgl_kunjungan = '$date'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(hidup) + sum(mati) desc
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(hidup) as baru,
					sum (mati) as lama,
					sum(hidup) + sum(mati) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel_ri
						where tgl_kunjungan LIKE '$date%'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(hidup) + sum(mati) desc
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}else{
					return $this->db->query("SELECT id_diagnosa,nm_diagnosa,
					SUM(l) as l,
					SUM(p) as p,
					sum(baru) as baru,
					sum (lama) as lama,
					sum(baru) + sum(lama) as jumlah
					from lap_kunj_poli_diagnosa_kasus_jenkel
						GROUP BY id_diagnosa,nm_diagnosa
						order by sum(baru) + sum(lama) desc
					");
				}
			}												 
		}

		function get_kunj_wilayah_jaminan($date,$lap_per,$layanan){
			if($layanan == 'Rawat Jalan'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan where to_char(tgl_kunjungan, 'YYYY-MM-DD') = '$date' and id_poli != 'BA00'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan where to_char(tgl_kunjungan, 'YYYY-MM') = '$date' and id_poli != 'BA00'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}else{
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}
			}else if($layanan == 'Rawat Darurat'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan where to_char(tgl_kunjungan, 'YYYY-MM-DD') = '$date' and id_poli = 'BA00'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan where to_char(tgl_kunjungan, 'YYYY-MM') = '$date' and id_poli = 'BA00'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}else{
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}
			}else{
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan_ri
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan_ri where tgl_keluar = '$date'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan_ri where tgl_keluar LIKE '$date%'
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
						
					");
				}else{
					return $this->db->query("SELECT kotakabupaten,
					sum (umum) as umum,
					sum (bpjs) as bpjs,
					sum (inhealth) as inhealth,
					sum (nayaka) as nayaka,
					sum (bukit_asam) as bukit_asam,
					sum (telkom) as telkom,
					sum (pln) as pln,
					sum (taspen) as taspen,
					sum (jasa_rahaja) as jasa_rahaja,
					sum (bpjs_pbi) as bpjs_pbi,
					sum (bpjs_mandiri) as bpjs_mandiri,
					sum (bpjs_non_pbi) as bpjs_non_pbi,
					sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
					sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi) as jumlah
					from lap_kunj_poli_wilayah_jaminan
						GROUP BY kotakabupaten
						order by sum (umum) + sum(inhealth) + sum(bukit_asam) + sum(telkom) + sum(pln) +  
							sum(bpjs_pbi) + sum(bpjs_mandiri) + sum(bpjs_non_pbi)  desc
								
					");
				}
			}
			
			
															 
		}

		function get_kunj_jenkel_jaminan_kasus($date,$lap_per,$layanan){
			if($layanan == 'rj'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						 
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' and id_poli != 'BA00'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM') = '$date' and id_poli != 'BA00'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}else{
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
								
					");
				}

			}else if($layanan == 'rd'){
				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						 
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' and id_poli = 'BA00'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM') = '$date' and id_poli = 'BA00'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}else{
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
								
					");
				}

			}else if($layanan == 'ri'){

				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						 
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus_ri
						where tgl_keluar = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus_ri
						where tgl_keluar LIKE '$date%'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}else{
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
								
					");
				}

			}else{

				if($date == '' || $lap_per == ''){
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						 
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY-MM') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						where to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
						
					");
				}else{
					return $this->db->query("SELECT nm_poli,
					sum (umum_baru_l) as umum_baru_l,
					sum (umum_baru_p) as umum_baru_p,
					sum (umum_lama_l) as umum_lama_l,
					sum (umum_lama_p) as umum_lama_p,
					
					sum (bpjs_baru_l) as bpjs_baru_l,
					sum (bpjs_baru_p) as bpjs_baru_p,
					sum (bpjs_lama_l) as bpjs_lama_l,
					sum (bpjs_lama_p) as bpjs_lama_p,
					
					sum (bukit_asam_baru_l) as bukit_asam_baru_l,
					sum (bukit_asam_baru_p) as bukit_asam_baru_p,
					sum (bukit_asam_lama_l) as bukit_asam_lama_l,
					sum (bukit_asam_lama_p) as bukit_asam_lama_p,
					
					sum (pln_baru_l) as pln_baru_l,
					sum (pln_baru_p) as pln_baru_p,
					sum (pln_lama_l) as pln_lama_l,
					sum (pln_lama_p) as pln_lama_p,
					
					sum (inhealth_baru_l) as inhealth_baru_l,
					sum (inhealth_baru_p) as inhealth_baru_p,
					sum (inhealth_lama_l) as inhealth_lama_l,
					sum (inhealth_lama_p) as inhealth_lama_p,
					
					sum (telkom_baru_l) as telkom_baru_l,
					sum (telkom_baru_p) as telkom_baru_p,
					sum (telkom_lama_l) as telkom_lama_l,
					sum (telkom_lama_p) as telkom_lama_p,
	
					sum (baru) as baru,
					sum (lama) as lama,
	
					sum(baru) + sum(lama)  as jumlah
	
					from lap_kunj_poli_jenkel_jaminan_kasus
						GROUP BY nm_poli
						order by sum(baru) + sum(lama) desc
								
					");
				}

			}
			
			
															 
		}

		function get_kunj_wilayah_diagnosa($date,$lap_per){
			if($date == '' || $lap_per == ''){
				return $this->db->query("SELECT nm_diagnosa,kotakabupaten,sum(jumlah) as jumlah from lap_kunj_poli_wilayah_diagnosa
				where substring(tgl_kunjungan,1,7 ) = '2021-03' and kotakabupaten = 'ACEH'
				group by nm_diagnosa,kotakabupaten	");
			}elseif($lap_per == 'TGL') {
				return $this->db->query("SELECT nm_poli,
				sum (umum_baru_l) as umum_baru_l,
				sum (umum_baru_p) as umum_baru_p,
				sum (umum_lama_l) as umum_lama_l,
				sum (umum_lama_p) as umum_lama_p,
				
				sum (bpjs_baru_l) as bpjs_baru_l,
				sum (bpjs_baru_p) as bpjs_baru_p,
				sum (bpjs_lama_l) as bpjs_lama_l,
				sum (bpjs_lama_p) as bpjs_lama_p,
				
				sum (bukit_asam_baru_l) as bukit_asam_baru_l,
				sum (bukit_asam_baru_p) as bukit_asam_baru_p,
				sum (bukit_asam_lama_l) as bukit_asam_lama_l,
				sum (bukit_asam_lama_p) as bukit_asam_lama_p,
				
				sum (pln_baru_l) as pln_baru_l,
				sum (pln_baru_p) as pln_baru_p,
				sum (pln_lama_l) as pln_lama_l,
				sum (pln_lama_p) as pln_lama_p,
				
				sum (inhealth_baru_l) as inhealth_baru_l,
				sum (inhealth_baru_p) as inhealth_baru_p,
				sum (inhealth_lama_l) as inhealth_lama_l,
				sum (inhealth_lama_p) as inhealth_lama_p,
				
				sum (telkom_baru_l) as telkom_baru_l,
				sum (telkom_baru_p) as telkom_baru_p,
				sum (telkom_lama_l) as telkom_lama_l,
				sum (telkom_lama_p) as telkom_lama_p,

				sum (baru) as baru,
				sum (lama) as lama,

				sum(baru) + sum(lama)  as jumlah

				from lap_kunj_poli_jenkel_jaminan_kasus
					where to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date'
					GROUP BY nm_poli
					order by sum(baru) + sum(lama) desc
					
				");
			}elseif($lap_per == 'BLN') {
				return $this->db->query("SELECT nm_poli,
				sum (umum_baru_l) as umum_baru_l,
				sum (umum_baru_p) as umum_baru_p,
				sum (umum_lama_l) as umum_lama_l,
				sum (umum_lama_p) as umum_lama_p,
				
				sum (bpjs_baru_l) as bpjs_baru_l,
				sum (bpjs_baru_p) as bpjs_baru_p,
				sum (bpjs_lama_l) as bpjs_lama_l,
				sum (bpjs_lama_p) as bpjs_lama_p,
				
				sum (bukit_asam_baru_l) as bukit_asam_baru_l,
				sum (bukit_asam_baru_p) as bukit_asam_baru_p,
				sum (bukit_asam_lama_l) as bukit_asam_lama_l,
				sum (bukit_asam_lama_p) as bukit_asam_lama_p,
				
				sum (pln_baru_l) as pln_baru_l,
				sum (pln_baru_p) as pln_baru_p,
				sum (pln_lama_l) as pln_lama_l,
				sum (pln_lama_p) as pln_lama_p,
				
				sum (inhealth_baru_l) as inhealth_baru_l,
				sum (inhealth_baru_p) as inhealth_baru_p,
				sum (inhealth_lama_l) as inhealth_lama_l,
				sum (inhealth_lama_p) as inhealth_lama_p,
				
				sum (telkom_baru_l) as telkom_baru_l,
				sum (telkom_baru_p) as telkom_baru_p,
				sum (telkom_lama_l) as telkom_lama_l,
				sum (telkom_lama_p) as telkom_lama_p,

				sum (baru) as baru,
				sum (lama) as lama,

				sum(baru) + sum(lama)  as jumlah

				from lap_kunj_poli_jenkel_jaminan_kasus
					where to_char(tgl_kunjungan,'YYYY-MM') = '$date'
					GROUP BY nm_poli
					order by sum(baru) + sum(lama) desc
					
				");
			}elseif($lap_per == 'THN') {
				return $this->db->query("SELECT nm_poli,
				sum (umum_baru_l) as umum_baru_l,
				sum (umum_baru_p) as umum_baru_p,
				sum (umum_lama_l) as umum_lama_l,
				sum (umum_lama_p) as umum_lama_p,
				
				sum (bpjs_baru_l) as bpjs_baru_l,
				sum (bpjs_baru_p) as bpjs_baru_p,
				sum (bpjs_lama_l) as bpjs_lama_l,
				sum (bpjs_lama_p) as bpjs_lama_p,
				
				sum (bukit_asam_baru_l) as bukit_asam_baru_l,
				sum (bukit_asam_baru_p) as bukit_asam_baru_p,
				sum (bukit_asam_lama_l) as bukit_asam_lama_l,
				sum (bukit_asam_lama_p) as bukit_asam_lama_p,
				
				sum (pln_baru_l) as pln_baru_l,
				sum (pln_baru_p) as pln_baru_p,
				sum (pln_lama_l) as pln_lama_l,
				sum (pln_lama_p) as pln_lama_p,
				
				sum (inhealth_baru_l) as inhealth_baru_l,
				sum (inhealth_baru_p) as inhealth_baru_p,
				sum (inhealth_lama_l) as inhealth_lama_l,
				sum (inhealth_lama_p) as inhealth_lama_p,
				
				sum (telkom_baru_l) as telkom_baru_l,
				sum (telkom_baru_p) as telkom_baru_p,
				sum (telkom_lama_l) as telkom_lama_l,
				sum (telkom_lama_p) as telkom_lama_p,

				sum (baru) as baru,
				sum (lama) as lama,

				sum(baru) + sum(lama)  as jumlah

				from lap_kunj_poli_jenkel_jaminan_kasus
					where to_char(tgl_kunjungan,'YYYY') = '$date'
					GROUP BY nm_poli
					order by sum(baru) + sum(lama) desc
					
				");
			}else{
				return $this->db->query("SELECT nm_poli,
				sum (umum_baru_l) as umum_baru_l,
				sum (umum_baru_p) as umum_baru_p,
				sum (umum_lama_l) as umum_lama_l,
				sum (umum_lama_p) as umum_lama_p,
				
				sum (bpjs_baru_l) as bpjs_baru_l,
				sum (bpjs_baru_p) as bpjs_baru_p,
				sum (bpjs_lama_l) as bpjs_lama_l,
				sum (bpjs_lama_p) as bpjs_lama_p,
				
				sum (bukit_asam_baru_l) as bukit_asam_baru_l,
				sum (bukit_asam_baru_p) as bukit_asam_baru_p,
				sum (bukit_asam_lama_l) as bukit_asam_lama_l,
				sum (bukit_asam_lama_p) as bukit_asam_lama_p,
				
				sum (pln_baru_l) as pln_baru_l,
				sum (pln_baru_p) as pln_baru_p,
				sum (pln_lama_l) as pln_lama_l,
				sum (pln_lama_p) as pln_lama_p,
				
				sum (inhealth_baru_l) as inhealth_baru_l,
				sum (inhealth_baru_p) as inhealth_baru_p,
				sum (inhealth_lama_l) as inhealth_lama_l,
				sum (inhealth_lama_p) as inhealth_lama_p,
				
				sum (telkom_baru_l) as telkom_baru_l,
				sum (telkom_baru_p) as telkom_baru_p,
				sum (telkom_lama_l) as telkom_lama_l,
				sum (telkom_lama_p) as telkom_lama_p,

				sum (baru) as baru,
				sum (lama) as lama,

				sum(baru) + sum(lama)  as jumlah

				from lap_kunj_poli_jenkel_jaminan_kasus
					GROUP BY nm_poli
					order by sum(baru) + sum(lama) desc
							
				");
			}
			
															 
		}

		public function get_diagnosa()
		{			
			return $this->db->query("SELECT * from icd1 where deleted = '0' ");
		}

		public function get_wilayah()
		{			
			return $this->db->query("SELECT * from wilayah WHERE kotakabupaten IS NOT NULL");
		}

		public function get_wilayah_detail($date,$lap_per)
		{			
			if($date == '' || $lap_per == ''){
				return $this->db->query("SELECT
					CASE
						WHEN c.provinsi::text = 'SUMATERA BARAT'::text THEN c.kotakabupaten
					ELSE c.provinsi
				END AS kotakabupaten,
					a.id_diagnosa,
					COUNT(a.id_diagnosa) AS jmlh_pasien
				FROM
					diagnosa_pasien a,
					daftar_ulang_irj b,
					data_pasien c
				WHERE 
					a.no_register = b.no_register
					AND b.no_medrec = c.no_medrec
				GROUP BY 
				c.provinsi, c.kotakabupaten, a.id_diagnosa ");
			}elseif($lap_per == 'TGL') {
				return $this->db->query("SELECT
					CASE
						WHEN c.provinsi::text = 'SUMATERA BARAT'::text THEN c.kotakabupaten
					ELSE c.provinsi
				END AS kotakabupaten,
					a.id_diagnosa,
					COUNT(a.id_diagnosa) AS jmlh_pasien
				FROM
					diagnosa_pasien a,
					daftar_ulang_irj b,
					data_pasien c
				WHERE 
					a.no_register = b.no_register
					AND b.no_medrec = c.no_medrec
					AND to_char(b.tgl_kunjungan,'YYYY-MM-DD') = '$date'
				GROUP BY 
				c.provinsi, c.kotakabupaten, a.id_diagnosa");
			}elseif($lap_per == 'BLN') {
				return $this->db->query("SELECT
					CASE
						WHEN c.provinsi::text = 'SUMATERA BARAT'::text THEN c.kotakabupaten
					ELSE c.provinsi
				END AS kotakabupaten,
					a.id_diagnosa,
					COUNT(a.id_diagnosa) AS jmlh_pasien
				FROM
					diagnosa_pasien a,
					daftar_ulang_irj b,
					data_pasien c
				WHERE 
					a.no_register = b.no_register
					AND b.no_medrec = c.no_medrec
					AND to_char(b.tgl_kunjungan, 'YYYY-MM') = '$date'
				GROUP BY 
				c.provinsi, c.kotakabupaten, a.id_diagnosa");
			}elseif($lap_per == 'THN') {
				return $this->db->query("SELECT
					CASE
						WHEN c.provinsi::text = 'SUMATERA BARAT'::text THEN c.kotakabupaten
					ELSE c.provinsi
				END AS kotakabupaten,
					a.id_diagnosa,
					COUNT(a.id_diagnosa) AS jmlh_pasien
				FROM
					diagnosa_pasien a,
					daftar_ulang_irj b,
					data_pasien c
				WHERE 
					a.no_register = b.no_register
					AND b.no_medrec = c.no_medrec
					AND to_char(b.tgl_kunjungan,'YYYY') = '$date'
				GROUP BY 
				c.provinsi, c.kotakabupaten, a.id_diagnosa");
			}else{
				return $this->db->query("SELECT kotakabupaten,id_diagnosa,sum(jmlh_pasien) as jmlh_pasien from wilayah_detail group by kotakabupaten,id_diagnosa order by sum(jmlh_pasien) desc ");				
			}
		}

		public function get_nm_poli($id_poli)
		{			
			return $this->db->query("SELECT * from poliklinik where id_poli = '$id_poli' ");
		}

		
		

		public function get_biaya_tindakan($idtindakan,$kelas)
		{			
			return $this->db->query("SELECT * from tarif_tindakan where id_tindakan = '$idtindakan' and kelas = '$kelas' ");
		}

		function get_kunj_poli_jaminan($date,$lap_per,$layanan){
			if($layanan == 'rj'){
				if($date == '' || $lap_per == ''){
					return $this->db->query(" SELECT d.nm_poli,
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
						sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
						sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
						sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
						sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
				   FROM daftar_ulang_irj a,
					data_pasien b,
					poliklinik d
				  WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text))
						GROUP BY d.nm_poli
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					limit 10	
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT d.nm_poli,a.id_poli
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' AND a.id_poli != 'BA00'
							GROUP BY d.nm_poli,a.id_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
																					
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND  ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM') = '$date' AND a.id_poli != 'BA00'
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY') = '$date'
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
						
					");
				}else{
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) 
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
								
					");
				}

			}else if($layanan == 'rd'){
				if($date == '' || $lap_per == ''){
					return $this->db->query(" SELECT d.nm_poli,
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
						sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
						sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
						sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
						sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
				   FROM daftar_ulang_irj a,
					data_pasien b,
					poliklinik d
				  WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text))
						GROUP BY d.nm_poli
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					limit 10	
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT d.nm_poli,a.id_poli
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date' AND a.id_poli = 'BA00'
							GROUP BY d.nm_poli,a.id_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
																					
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND  ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM') = '$date' AND a.id_poli = 'BA00'
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
						
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY') = '$date'
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
						
					");
				}else{
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) 
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
								
					");
				}

			}else if($layanan == 'ri'){

				if($date == '' || $lap_per == ''){
					return $this->db->query(" SELECT d.nm_poli,
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
						sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
						sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
						sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
						sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
				   FROM daftar_ulang_irj a,
					data_pasien b,
					poliklinik d
				  WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text))
						GROUP BY d.nm_poli
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					limit 10	
								
					");
				}elseif($lap_per == 'TGL') {
					return $this->db->query("SELECT d.nmruang as nm_poli,
					sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.carabayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

					sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

					FROM pasien_iri a,
						data_pasien b,
						ruang d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.idrg)::text = (d.idrg)::text)) and a.tgl_keluar = '$date'
							GROUP BY d.nmruang
						order by 
						sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
			
																					
					");
				}elseif($lap_per == 'BLN') {
					return $this->db->query("SELECT d.nmruang as nm_poli,
					sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.carabayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

					sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

					FROM pasien_iri a,
						data_pasien b,
						ruang d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.idrg)::text = (d.idrg)::text)) and a.tgl_keluar LIKE '$date%'
							GROUP BY d.nmruang
						order by 
						sum(CASE WHEN ((a.carabayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					
					");
				}elseif($lap_per == 'THN') {
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY') = '$date'
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
						
					");
				}else{
					return $this->db->query("SELECT d.nm_poli,
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
					sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
					sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
					sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
					sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,
	
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
					sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah
	
					FROM daftar_ulang_irj a,
						data_pasien b,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND ((a.id_poli)::text = (d.id_poli)::text)) 
							GROUP BY d.nm_poli
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
						limit 10
								
					");
				}

			}												 
		}

		public function get_user_kasir()
		{			
			return $this->db->query("select * from dyn_role_user a, hmis_users b
			where a.userid = b.userid
			and a.roleid = '1013' ");
		}

		
		public function get_poliklinik()
		{			
			return $this->db->query("select * from poliklinik order by nm_poli");
		}

		
		function get_data_keu_poli_kasir($tgl,$tgl1,$userid){	
			if ($userid != '') {
				$texa = " and lower(a.user_cetak) = '$userid' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("select b.id_poli,b.no_register,b.jns_kunj,b.kelas_pasien,a.no_kwitansi,
				a.tgl_cetak,c.nama,c.no_identitas,
				CASE WHEN CAST(b.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status,
				case when b.jns_kunj = 'BARU'
					then (select total_tarif from tarif_tindakan where id_tindakan = '1B0105' and kelas ='NK')
					else (select total_tarif from tarif_tindakan where id_tindakan = '1B0101' and kelas ='NK') 
				end as biaya_adm,
				(select vtot from pelayanan_poli where idtindakan = '1B0104'
					and a.no_register = pelayanan_poli.no_register) as biaya_kartu,
				(select sum(vtot) 
					 from pelayanan_poli 
					 where (idtindakan != '1B0101' or idtindakan != '1B0105')
					 and idtindakan != '1B0104'
					 and a.no_register = pelayanan_poli.no_register
				) as biaya_tindakan
			from no_kwitansi a ,daftar_ulang_irj b, data_pasien c 
			where b.no_register = a.no_register 
			and b.no_medrec = c.no_medrec 
			and a.status is null
			and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1'
			and a.jenis_kwitansi = 'Rawat Jalan' 
			$texa ");
		}

		function get_data_keu_poli_farmasi($tgl,$tgl1,$userid){	
			if ($userid != '') {
				$texa = " and lower(a.user_cetak) = '$userid' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("select b.id_poli,b.no_register,b.no_medrec,b.kelas_pasien,a.no_kwitansi, a.tgl_cetak,c.nama,c.no_identitas, 
				CASE WHEN CAST(b.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
				(select sum(vtot) from resep_pasien where  a.no_register = resep_pasien.no_register ) as biaya_obat 
			from no_kwitansi a ,daftar_ulang_irj b, data_pasien c 
			where b.no_register = a.no_register 
			and b.no_medrec = c.no_medrec 
			and a.status is null 
			and a.jenis_kwitansi = 'Farmasi'
			and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1' 
			$texa ");
		}

		function get_data_keu_poli_rad($tgl,$tgl1,$userid){	
			if ($userid != '') {
				$texa = " and lower(a.user_cetak) = '$userid' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("select b.id_poli,b.no_register,b.no_medrec,b.kelas_pasien,a.no_kwitansi, a.tgl_cetak,c.nama,c.no_identitas, 
				CASE WHEN CAST(b.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
				(select sum(vtot) from pemeriksaan_radiologi where a.no_register = pemeriksaan_radiologi.no_register ) as biaya_rad
			from no_kwitansi a ,daftar_ulang_irj b, data_pasien c 
			where b.no_register = a.no_register and b.no_medrec = c.no_medrec 
			and a.status is null and a.jenis_kwitansi = 'Radiologi' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1' 
			$texa ");
		}

		function get_data_keu_poli_lab($tgl,$tgl1,$pelayanan,$carabayar){	
			
			if ($pelayanan != 'SEMUA' && $carabayar !='SEMUA') {
			
				if($pelayanan == 'IRJ'){
					return $this->db->query("SELECT
					jenis_tindakan,
					vtot,
					nama,
					tgl_kunjungan,
					no_cm,
					ruang,
					no_register 
				FROM
					lap_pendapatan_lab 
				WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					AND LEFT(no_register, 2) = 'RJ'
					AND carabayar = '$carabayar' order by no_cm asc");
				}else{
					return $this->db->query("SELECT
					jenis_tindakan,
					vtot,
					nama,
					tgl_kunjungan,
					no_cm,
					ruang,
					no_register 
				FROM
					lap_pendapatan_lab 
				WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					AND LEFT(no_register, 2) = 'RI'
					AND carabayar = '$carabayar'  order by no_cm asc");
				}
				
			}else if($pelayanan == 'SEMUA' && $carabayar !='SEMUA'){	
				return $this->db->query("SELECT
					jenis_tindakan,
					vtot,
					nama,
					tgl_kunjungan,
					no_cm,
					ruang,
					no_register 
				FROM
					lap_pendapatan_lab 
				WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					AND carabayar = '$carabayar'  order by no_cm asc");
			}else if($pelayanan != 'SEMUA' && $carabayar =='SEMUA'){
				if($pelayanan == 'IRJ'){
					return $this->db->query("SELECT
					jenis_tindakan,
					vtot,
					nama,
					tgl_kunjungan,
					no_cm,
					ruang,
					no_register 
				FROM
					lap_pendapatan_lab 
				WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					AND LEFT(no_register, 2) = 'RJ'  order by no_cm asc");
				}else{
					return $this->db->query("SELECT
					jenis_tindakan,
					vtot,
					nama,
					tgl_kunjungan,
					no_cm,
					ruang,
					no_register 
				FROM
					lap_pendapatan_lab 
				WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					AND LEFT(no_register, 2) = 'RI'  order by no_cm asc");
				}
				
			}else{
				return $this->db->query("SELECT
				jenis_tindakan,
				vtot,
				nama,
				tgl_kunjungan,
				no_cm,
				ruang,
				no_register 
			FROM
				lap_pendapatan_lab 
			WHERE
					LEFT ( tgl_kunjungan, 10 ) >= '$tgl' 
					AND LEFT ( tgl_kunjungan, 10 ) <= '$tgl1'
					order by no_cm asc
				");
			}

				
		}

		function get_data_keu_poli_em($tgl,$tgl1,$userid){	
			if ($userid != '') {
				$texa = " and lower(a.user_cetak) = '$userid' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("select b.id_poli,b.no_register,b.no_medrec,b.kelas_pasien,a.no_kwitansi, a.tgl_cetak,c.nama,c.no_identitas, 
				CASE WHEN CAST(b.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
				(select sum(vtot) from pemeriksaan_elektromedik where a.no_register = pemeriksaan_elektromedik.no_register ) as biaya_em
			from no_kwitansi a ,daftar_ulang_irj b, data_pasien c where b.no_register = a.no_register and b.no_medrec = c.no_medrec and a.status is null
			and a.jenis_kwitansi = 'Elektromedik'
			and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1' 
			$texa ");
		}

		function get_data_keu_poli_ok($tgl,$tgl1,$userid){	
			if ($userid != '') {
				$texa = " and lower(a.user_cetak) = '$userid' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("select b.id_poli,b.no_register,b.no_medrec,b.kelas_pasien,a.no_kwitansi, a.tgl_cetak,c.nama,c.no_identitas, 
				CASE WHEN CAST(b.status as integer)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
				(select sum(vtot) from pemeriksaan_operasi where a.no_register = pemeriksaan_operasi.no_register ) as biaya_ok
			from no_kwitansi a ,daftar_ulang_irj b, data_pasien c where b.no_register = a.no_register and b.no_medrec = c.no_medrec and a.status is null
			and a.jenis_kwitansi = 'OK'
			and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
			and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1' 
			$texa ");
		}

		function get_kunj_dokter_poli_jaminan($date,$lap_per){
			if($date == '' || $lap_per == ''){
				return $this->db->query("SELECT d.id_poli,(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter),
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
						sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
						sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
						sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
						sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

					FROM daftar_ulang_irj a,
						data_pasien b,
						kontraktor c,
						poliklinik d
					WHERE ((a.no_medrec = b.no_medrec) AND (a.id_kontraktor = c.id_kontraktor) AND ((a.id_poli)::text = (d.id_poli)::text))
							GROUP BY d.id_poli,a.id_dokter
						order by 
						sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
							sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
							
				");
			}elseif($lap_per == 'TGL') {
				return $this->db->query("SELECT d.id_poli,(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter),
				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
				sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
				sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
				sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
				sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

				FROM daftar_ulang_irj a,
					data_pasien b,
					kontraktor c,
					poliklinik d
				WHERE ((a.no_medrec = b.no_medrec) AND (a.id_kontraktor = c.id_kontraktor) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM-DD') = '$date'
						GROUP BY d.id_poli,a.id_dokter
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc							
				");
			}elseif($lap_per == 'BLN') {
				return $this->db->query("SELECT d.id_poli,(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter),
				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
				sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
				sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
				sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
				sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

				FROM daftar_ulang_irj a,
					data_pasien b,
					kontraktor c,
					poliklinik d
				WHERE ((a.no_medrec = b.no_medrec) AND (a.id_kontraktor = c.id_kontraktor) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY-MM') = '$date'
						GROUP BY d.id_poli,a.id_dokter
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					
				");
			}elseif($lap_per == 'THN') { 
				return $this->db->query("SELECT d.id_poli,(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter),
				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
				sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
				sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
				sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
				sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

				FROM daftar_ulang_irj a,
					data_pasien b,
					kontraktor c,
					poliklinik d
				WHERE ((a.no_medrec = b.no_medrec) AND (a.id_kontraktor = c.id_kontraktor) AND ((a.id_poli)::text = (d.id_poli)::text)) AND  to_char(tgl_kunjungan,'YYYY') = '$date'
						GROUP BY d.id_poli,a.id_dokter
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
					
				");
			}else{
				return $this->db->query("SELECT d.id_poli,(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter),
				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) AS umum,
				sum(CASE WHEN ((a.cara_bayar)::text = 'BPJS'::text) THEN 1 ELSE 0 END) AS bpjs,
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) AS inhealth,
				sum(CASE WHEN (a.id_kontraktor = 64) THEN 1 ELSE 0 END) AS nayaka,
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) AS bukit_asam,
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) AS telkom,
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) AS pln,
				sum(CASE WHEN (a.id_kontraktor = 69) THEN 1 ELSE 0 END) AS taspen,
				sum(CASE WHEN (a.id_kontraktor = 68) THEN 1 ELSE 0 END) AS jasa_rahaja,
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) AS bpjs_pbi,
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) AS bpjs_mandiri,
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) AS bpjs_non_pbi,

				sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
				sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) as jumlah

				FROM daftar_ulang_irj a,
					data_pasien b,
					kontraktor c,
					poliklinik d
				WHERE ((a.no_medrec = b.no_medrec) AND (a.id_kontraktor = c.id_kontraktor) AND ((a.id_poli)::text = (d.id_poli)::text))
						GROUP BY d.id_poli,a.id_dokter
					order by 
					sum(CASE WHEN ((a.cara_bayar)::text = 'UMUM'::text) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 63) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 65) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 66) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 67) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 3) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 17) THEN 1 ELSE 0 END) +
						sum(CASE WHEN (a.id_kontraktor = 10) THEN 1 ELSE 0 END) desc
							
				");
			}																		 
		}

		function get_data_kunj_waktu_irj($tgl,$lapper){
		
						return $this->db->query("SELECT id_poli,nm_dokter,sum(selisih) as jumlah,sum(pasien) as pasien
						FROM lap_kunj_waktu_irj
						group by id_poli,nm_dokter
						order by sum(selisih) desc");
		}

		
		function get_data_keu_kerjasama_rj($tgl,$tgl1,$id_kontraktor){	
			if ($id_kontraktor != '') {
				$texa = " and b.id_kontraktor = '$id_kontraktor' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("SELECT b.id_poli,b.no_register,b.no_sep,b.jns_kunj,b.kelas_pasien,a.no_kwitansi,
					a.tgl_cetak,c.nama,c.no_identitas,a.vtot_bayar,b.id_kontraktor,
					CASE WHEN b.ket_pulang = 'PULANG' THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = b.id_kontraktor) as nmkontraktor,
					(select diagnosa from diagnosa_pasien where diagnosa_pasien.no_register = b.no_register and klasifikasi_diagnos = 'utama') as nmdiagnosa,
					(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as nmpoli
					from no_kwitansi a ,daftar_ulang_irj b, data_pasien c 
					where b.no_register = a.no_register 
					and b.no_medrec = c.no_medrec 
					and a.status is null
					and a.jenis_kwitansi = 'Rawat Jalan' 
					and b.cara_bayar = 'KERJASAMA'
					and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
					and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1'
				$texa ");
		}

		
		function get_data_keu_kerjasama_ri($tgl,$tgl1,$id_kontraktor){	
			if ($id_kontraktor != '') {
				$texa = " and b.id_kontraktor = '$id_kontraktor' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("SELECT b.nm_ruang,b.no_ipd,b.klsiri,a.no_kwitansi,
					a.tgl_cetak,c.nama,c.no_identitas,a.vtot_bayar,b.id_kontraktor,
					CASE WHEN b.status_pulang = 'PULANG SENDIRI' THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = b.id_kontraktor) as nmkontraktor				
					from no_kwitansi a ,pasien_iri b, data_pasien c 
					where b.no_ipd = a.no_register 
					and b.no_medrec = c.no_medrec 
					and a.status is null
					and a.jenis_kwitansi = 'RI' 
					and b.carabayar = 'KERJASAMA'
					and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
					and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1'
				$texa ");
		}

		
		function get_data_keu_kerjasama_penunjang($tgl,$tgl1,$id_kontraktor){	
			if ($id_kontraktor != '') {
				$texa = " and b.id_kontraktor = '$id_kontraktor' ";
			}else{
				$texa = " ";
			}	
			// return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.tunai2,'0') as tunai2, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, IFNULL(du.diskon2,'0') as diskon2, IFNULL(du.nilai_kkkd,'0') as nilai_kkkd, IFNULL(du.nilai_kkkd2,'0') as nilai_kkkd2, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
			// 						FROM daftar_ulang_irj AS du
			// 						LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
			// 						WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
			// 						ORDER BY no_register,id_poli ");

				return $this->db->query("SELECT b.no_sep,b.id_poli,b.no_register,b.jns_kunj,b.kelas_pasien,a.no_kwitansi,
					a.tgl_cetak,c.nama,c.no_identitas,a.vtot_bayar,b.id_kontraktor,
					CASE WHEN b.ket_pulang = 'PULANG' THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = b.id_kontraktor) as nmkontraktor,
					(select diagnosa from diagnosa_pasien where diagnosa_pasien.no_register = b.no_register and klasifikasi_diagnos = 'utama') as nmdiagnosa,
					(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as nmpoli
					from no_kwitansi a ,daftar_ulang_irj b, data_pasien c 
					where b.no_register = a.no_register 
					and b.no_medrec = c.no_medrec 
					and a.status is null
					and a.jenis_kwitansi != 'RI' 
					and a.jenis_kwitansi != 'Rawat Jalan'
					and b.cara_bayar = 'KERJASAMA'
					and to_date(a.tgl_cetak,'YYYY-MM-DD')>= '$tgl' 
					and to_date(a.tgl_cetak,'YYYY-MM-DD')<= '$tgl1'
				$texa ");
		}

		function get_kontraktor(){		
			return $this->db->query("SELECT * 
			FROM kontraktor
			order by nmkontraktor asc");
		}

		function get_nmkontraktor($id_kontraktor){		
			return $this->db->query("SELECT * 
			FROM kontraktor
			where id_kontraktor = '$id_kontraktor' 
			order by nmkontraktor asc");
		}

		public function get_data_pemeriksaan_rad_irj($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_lab_irj($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_em_irj($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_obat_irj($no_register)
		{
			return $this->db->query("SELECT * FROM resep_pasien where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_tindakan_irj($no_register)
		{
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register = '$no_register' ");
		}

		public function get_dokter(){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter a where  a.deleted = '0' ORDER BY a.nm_dokter");
		}

		public function get_ruang(){
			return $this->db->query("SELECT * FROM ruang ORDER BY nmruang");
		}

		public function get_data_keu_dokter_report($id_dokter,$awal,$akhir,$jenis,$poli,$ruang){

			if ($id_dokter!=null) {
				$select_id_dokter = " AND id_dokter = '$id_dokter' "; 
			}else{
				$select_id_dokter = "";
			}

			if($awal != null && $akhir != null){
				$select_tgl = " AND tgl_kunjungan >= '$awal' AND tgl_kunjungan <= '$akhir' ";
			}else{
				$select_tgl = "";
			}

			if($jenis == 'RJ'){
				if($poli != null){
					$select_jenis = "AND id_poli = '$poli' ";
				}else{
					$select_jenis = "";
				}
			}else{
				if($ruang != null){
					$select_jenis = "AND id_poli = '$ruang' ";
				}else{
					$select_jenis = "";
				}
			}

			return $this->db->query("SELECT *,to_char(tgl_kunjungan,'DD-MM-YYYY') as tgl_kunjungan FROM pendapatan_dokter 
			where jenis_pelayanan = '$jenis' $select_id_dokter $select_tgl $select_jenis 
			ORDER BY to_char(tgl_kunjungan,'DD-MM-YYYY') desc");
		}
		
		function get_data_konsul($id){
			return $this->db->query("SELECT a.*,
				(SELECT nm_poli FROM poliklinik WHERE a.id_poli_asal = id_poli LIMIT 1) AS poli_asal,
				(SELECT nm_poli FROM poliklinik WHERE a.id_poli_akhir = id_poli LIMIT 1) AS poli_tujuan,
				(SELECT kelas_pasien FROM daftar_ulang_irj WHERE a.no_register = no_register_lama AND a.id_poli_akhir = id_poli LIMIT 1) AS kelas,
				(SELECT nm_dokter FROM data_dokter WHERE CAST(a.id_dokter_akhir AS INT) = id_dokter LIMIT 1) AS dokter_penerima,
				(SELECT kode_dpjp_bpjs FROM data_dokter WHERE CAST(a.id_dokter_akhir AS INT) = id_dokter LIMIT 1) AS kode_dpjp
			FROM 
				konsul_dokter AS a
			WHERE 
				a.id=CAST('$id' AS INT)");
		}

		function edit_konsul($id, $data){
			$this->db->where('id', $id);
			$this->db->update('konsul_dokter', $data); 
			return true;
		}

		function edit_data_konsul_daftar_ulang($noreg, $id_poli, $du) {
			$this->db->where('no_register_lama', $noreg);
			$this->db->where('id_poli', $id_poli);
			$this->db->update('daftar_ulang_irj', $du); 
			return true;
		}

		function get_lap_dpjp_utama($date) {
			return $this->db->query("SELECT
				a.id_dokter,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BA00' ) AS igd,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BE00' ) AS kandungan,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW00' ) AS umum,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW01' ) AS umum24,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ00' ) AS interne,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ00' ) AS saraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BR00' ) AS anak,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI00' ) AS mcu,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ01' ) AS paru,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli IN ('BD00','BF00')) AS fungsi_luhur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK00' ) AS rehab_medik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB00' ) AS bedah,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB02' ) AS bedah_syaraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB05' ) AS anestesi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BV01' ) AS vaksin,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK02' ) AS terapi_wicara,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BM00' ) AS gizi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BG00' ) AS gigi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ02' ) AS neuropsikiatri,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BT00' ) AS tht,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK09' ) AS akupuntur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK07' ) AS fisioterapi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK03' ) AS ortetik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK01' ) AS okupasi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ01' ) AS neurointervensi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BH00' ) AS mata,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ02' ) AS jantung,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI04' ) AS scu
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b
			WHERE
				to_char( a.tgl_kunjungan, 'YYYY-MM' ) = '$date' 
				AND a.no_register_lama IS NULL
				AND a.id_dokter = b.id_dokter
				AND a.kelas_pasien = 'NK'
				AND (a.ket_pulang != 'BATAL_PELAYANAN_POLI' OR a.ket_pulang IS NULL)
			GROUP BY
				a.id_dokter,
				dokter");
		}

		function get_lap_dpjp_utama_tgl($date) {
			return $this->db->query("SELECT
				a.id_dokter,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BA00' ) AS igd,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BE00' ) AS kandungan,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW00' ) AS umum,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW01' ) AS umum24,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ00' ) AS interne,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ00' ) AS saraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BR00' ) AS anak,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI00' ) AS mcu,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ01' ) AS paru,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli IN ('BD00','BF00')) AS fungsi_luhur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK00' ) AS rehab_medik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB00' ) AS bedah,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB02' ) AS bedah_syaraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB05' ) AS anestesi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BV01' ) AS vaksin,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK02' ) AS terapi_wicara,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BM00' ) AS gizi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BG00' ) AS gigi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ02' ) AS neuropsikiatri,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BT00' ) AS tht,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK09' ) AS akupuntur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK07' ) AS fisioterapi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK03' ) AS ortetik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK01' ) AS okupasi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ01' ) AS neurointervensi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BH00' ) AS mata,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ02' ) AS jantung,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI04' ) AS scu
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b
			WHERE
				to_char( a.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
				AND a.no_register_lama IS NULL
				AND a.id_dokter = b.id_dokter
				AND a.kelas_pasien = 'NK'
				AND (a.ket_pulang != 'BATAL_PELAYANAN_POLI' OR a.ket_pulang IS NULL)
			GROUP BY
				a.id_dokter,
				dokter");
		}

		function get_lap_dpjp_konsul_tgl($date, $opsi) {
			return $this->db->query("SELECT
				a.id_dokter_akhir,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BA00' ) AS igd,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BE00' ) AS kandungan,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BW00' ) AS umum,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BW01' ) AS umum24,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ00' ) AS interne,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ00' ) AS saraf,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BR00' ) AS anak,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BI00' ) AS mcu,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ01' ) AS paru,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir IN ('BD00','BF00')) AS fungsi_luhur,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK00' ) AS rehab_medik,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB00' ) AS bedah,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB02' ) AS bedah_syaraf,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB05' ) AS anestesi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BV01' ) AS vaksin,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK02' ) AS terapi_wicara,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BM00' ) AS gizi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BG00' ) AS gigi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ02' ) AS neuropsikiatri,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BT00' ) AS tht,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK09' ) AS akupuntur,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK07' ) AS fisioterapi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK03' ) AS ortetik,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK01' ) AS okupasi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ01' ) AS neurointervensi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BH00' ) AS mata,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ02' ) AS jantung,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BI04' ) AS scu
			FROM
				konsul_dokter AS a
				LEFT JOIN data_dokter AS b ON CAST(a.id_dokter_akhir AS INT) = b.id_dokter
				LEFT OUTER JOIN daftar_ulang_irj c ON a.no_register = c.no_register
			WHERE
				to_char( a.tanggal_konsul, 'YYYY-MM-DD' ) = '$date' 
				AND c.kelas_pasien = 'NK'
				AND a.opsi_konsul = '$opsi'
			GROUP BY
				a.id_dokter_akhir,
				dokter");
		}

		function get_lap_dpjp_konsul($date, $opsi) {
			return $this->db->query("SELECT
				a.id_dokter_akhir,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BA00' ) AS igd,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BE00' ) AS kandungan,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BW00' ) AS umum,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BW01' ) AS umum24,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ00' ) AS interne,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ00' ) AS saraf,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BR00' ) AS anak,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BI00' ) AS mcu,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ01' ) AS paru,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir IN ('BD00','BF00')) AS fungsi_luhur,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK00' ) AS rehab_medik,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB00' ) AS bedah,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB02' ) AS bedah_syaraf,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BB05' ) AS anestesi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BV01' ) AS vaksin,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK02' ) AS terapi_wicara,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BM00' ) AS gizi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BG00' ) AS gigi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ02' ) AS neuropsikiatri,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BT00' ) AS tht,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK09' ) AS akupuntur,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK07' ) AS fisioterapi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK03' ) AS ortetik,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BK01' ) AS okupasi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BJ01' ) AS neurointervensi,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BH00' ) AS mata,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BQ02' ) AS jantung,
				COUNT ( a.id_dokter_akhir ) FILTER ( WHERE a.id_poli_akhir = 'BI04' ) AS scu
			FROM
				konsul_dokter AS a
				LEFT JOIN data_dokter AS b ON CAST(a.id_dokter_akhir AS INT) = b.id_dokter
				LEFT OUTER JOIN daftar_ulang_irj c ON a.no_register = c.no_register
			WHERE
				to_char( a.tanggal_konsul, 'YYYY-MM' ) = '$date' 
				AND c.kelas_pasien = 'NK'
				AND a.opsi_konsul = '$opsi'
			GROUP BY
				a.id_dokter_akhir,
				dokter");
		}

		function get_lap_dpjp_utama_eksekutif($date) {
			return $this->db->query("SELECT
				a.id_dokter,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BH03' ) AS mata,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BG03' ) AS gigi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ03' ) AS interne,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ04' ) AS paru,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BR03' ) AS anak,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BD03' ) AS fungsi_luhur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW04' ) AS umum,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW05' ) AS umum24,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli IN ('BK08','BJ09')) AS fisioterapi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB03' ) AS bedah,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB04' ) AS bedah_syaraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BM03' ) AS gizi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ05' ) AS jantung,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK06' ) AS ortetik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK04' ) AS okupasi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK05' ) AS terapi_wicara,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ03' ) AS saraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ08' ) AS neurointervensi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ07' ) AS neuropsikiatri,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI03' ) AS mcu,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BV02' ) AS vaksin
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b
			WHERE
				to_char( a.tgl_kunjungan, 'YYYY-MM' ) = '$date' 
				AND a.no_register_lama IS NULL
				AND a.id_dokter = b.id_dokter
				AND a.kelas_pasien = 'EKSEKUTIF'
				AND (a.ket_pulang != 'BATAL_PELAYANAN_POLI' OR a.ket_pulang IS NULL)
			GROUP BY
				a.id_dokter,
				dokter");
		}

		function get_lap_dpjp_utama_eksekutif_tgl($date) {
			return $this->db->query("SELECT
				a.id_dokter,
				b.nm_dokter AS dokter,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BH03' ) AS mata,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BG03' ) AS gigi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ03' ) AS interne,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ04' ) AS paru,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BR03' ) AS anak,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BD03' ) AS fungsi_luhur,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW04' ) AS umum,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BW05' ) AS umum24,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli IN ('BK08','BJ09')) AS fisioterapi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB03' ) AS bedah,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BB04' ) AS bedah_syaraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BM03' ) AS gizi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BQ05' ) AS jantung,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK06' ) AS ortetik,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK04' ) AS okupasi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BK05' ) AS terapi_wicara,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ03' ) AS saraf,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ08' ) AS neurointervensi,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BJ07' ) AS neuropsikiatri,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BI03' ) AS mcu,
				COUNT ( a.id_dokter ) FILTER ( WHERE a.id_poli = 'BV02' ) AS vaksin
			FROM
				daftar_ulang_irj AS a,
				data_dokter AS b
			WHERE
				to_char( a.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
				AND a.no_register_lama IS NULL
				AND a.id_dokter = b.id_dokter
				AND a.kelas_pasien = 'EKSEKUTIF'
				AND (a.ket_pulang != 'BATAL_PELAYANAN_POLI' OR a.ket_pulang IS NULL)
			GROUP BY
				a.id_dokter,
				dokter");
		}

		function get_lap_dpjp_konsul_eksekutif($date, $opsi) {
			return $this->db->query("SELECT A
				.id_dokter_akhir,
				b.nm_dokter AS dokter,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BH03' ) AS mata,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BG03' ) AS gigi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ03' ) AS interne,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ04' ) AS paru,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BR03' ) AS anak,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BD03' ) AS fungsi_luhur,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BW04' ) AS umum,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BW05' ) AS umum24,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir IN ( 'BK08', 'BJ09' ) ) AS fisioterapi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BB03' ) AS bedah,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BB04' ) AS bedah_syaraf,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BM03' ) AS gizi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ05' ) AS jantung,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK06' ) AS ortetik,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK04' ) AS okupasi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK05' ) AS terapi_wicara,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ03' ) AS saraf,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ08' ) AS neurointervensi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ07' ) AS neuropsikiatri,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BI03' ) AS mcu,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BV02' ) AS vaksin 
			FROM
				konsul_dokter AS A
				LEFT JOIN data_dokter AS b ON CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter
				LEFT OUTER JOIN daftar_ulang_irj c ON a.no_register = c.no_register
			WHERE
				to_char( A.tanggal_konsul, 'YYYY-MM' ) = '$date' 
				AND c.kelas_pasien = 'EKSEKUTIF'
				AND A.opsi_konsul = '$opsi' 
			GROUP BY
				A.id_dokter_akhir,
				dokter");
		}

		function get_lap_dpjp_konsul_eksekutif_tgl($date, $opsi) {
			return $this->db->query("SELECT A
				.id_dokter_akhir,
				b.nm_dokter AS dokter,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BH03' ) AS mata,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BG03' ) AS gigi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ03' ) AS interne,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ04' ) AS paru,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BR03' ) AS anak,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BD03' ) AS fungsi_luhur,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BW04' ) AS umum,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BW05' ) AS umum24,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir IN ( 'BK08', 'BJ09' ) ) AS fisioterapi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BB03' ) AS bedah,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BB04' ) AS bedah_syaraf,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BM03' ) AS gizi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BQ05' ) AS jantung,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK06' ) AS ortetik,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK04' ) AS okupasi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BK05' ) AS terapi_wicara,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ03' ) AS saraf,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ08' ) AS neurointervensi,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BJ07' ) AS neuropsikiatri,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BI03' ) AS mcu,
				COUNT ( A.id_dokter_akhir ) FILTER ( WHERE A.id_poli_akhir = 'BV02' ) AS vaksin 
			FROM
				konsul_dokter AS A
				LEFT JOIN data_dokter AS b ON CAST ( A.id_dokter_akhir AS INT ) = b.id_dokter
				LEFT OUTER JOIN daftar_ulang_irj c ON a.no_register = c.no_register
			WHERE
				to_char( A.tanggal_konsul, 'YYYY-MM-DD' ) = '$date' 
				AND c.kelas_pasien = 'EKSEKUTIF'
				AND A.opsi_konsul = '$opsi' 
			GROUP BY
				A.id_dokter_akhir,
				dokter");
		}

		function get_jenis_kunj_pasien($date, $tampil) {
			if($tampil == 'TGL') {
				return $this->db->query("SELECT
					to_char(tgl_kunjungan,'YYYY-MM') AS tgl,
					CASE
						WHEN (jns_kunj = 'LAMA') THEN 'Pengunjung Lama'
						WHEN (jns_kunj = 'BARU') THEN 'Pengunjung Baru'
					END AS jenis,
					COUNT (jns_kunj) AS jml
				FROM
					daftar_ulang_irj
				WHERE 
					to_char(tgl_kunjungan, 'YYYY-MM-DD') = '$date'
				GROUP BY
					tgl, jns_kunj");
			} else {
				return $this->db->query("SELECT
					to_char(tgl_kunjungan,'YYYY-MM') AS tgl,
					CASE
						WHEN (jns_kunj = 'LAMA') THEN 'Pengunjung Lama'
						WHEN (jns_kunj = 'BARU') THEN 'Pengunjung Baru'
					END AS jenis,
					COUNT (jns_kunj) AS jml
				FROM
					daftar_ulang_irj
				WHERE 
					to_char(tgl_kunjungan, 'YYYY-MM') = '$date'
				GROUP BY
					tgl, jns_kunj");
			}
		}

		function get_data_list_pasien_rekap($date) {
			return $this->db->query("SELECT
				a.no_register,
				b.nama,
				b.no_cm,
				c.nm_poli,
				a.tgl_kunjungan,
				a.cara_bayar
			FROM 
				daftar_ulang_irj AS a,
				data_pasien AS b,
				poliklinik AS C
			WHERE
				a.no_medrec = b.no_medrec
				AND a.id_poli = c.id_poli
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
				--AND a.id_poli != 'BA00'
			ORDER BY 
				a.tgl_kunjungan DESC");
		}

		function get_data_pasien_rekap($no_register) {
			return $this->db->query("SELECT
			a.no_register,
			b.nama,
			b.no_cm,
			a.no_medrec,
			c.nm_poli,
			a.tgl_kunjungan,
			a.cara_bayar,
			b.tgl_lahir,
			b.alamat,
			b.sex,
			a.id_kontraktor,
			(SELECT nmkontraktor FROM kontraktor WHERE a.id_kontraktor = id_kontraktor LIMIT 1) AS nmkontraktor,
			(SELECT nm_dokter FROM data_dokter WHERE a.id_dokter = id_dokter LIMIT 1) AS dokter
		FROM 
			daftar_ulang_irj AS a,
			data_pasien AS b,
			poliklinik AS C
		WHERE
			a.no_medrec = b.no_medrec
			AND a.id_poli = c.id_poli
			AND a.no_register = '$no_register'");
		}

		function pencarian_pasien_baru_apm($tgl,$bulan=''){
			if($bulan !=''){
				return $this->db->where("TO_CHAR(xupdate,'YYYY-MM') = '$tgl'")
				->where('xuser', 'APM')
				->get('data_pasien');
				
			}
			return $this->db->where("TO_CHAR(xupdate,'YYYY-MM-dd') = '$tgl'")
			->where('xuser','APM')
			->get('data_pasien');
			
		}

		function pencarian_pasien_baru_apm_poli($tgl,$bulan=''){
			if($bulan !=''){
				return $this->db->where("TO_CHAR(tgl_kunjungan,'YYYY-MM') = '$tgl'")
				->where('xcreate', 'APM')
				->get('daftar_ulang_irj');
				
			}
			return $this->db->where("TO_CHAR(tgl_kunjungan,'YYYY-MM-dd') = '$tgl'")
			->where('xcreate','APM')
			->get('daftar_ulang_irj');
			
		}


		function pencarian_pasien_poli_apm($tgl,$bulan=''){
			if($bulan != ''){
				return $this->db->where("TO_CHAR(tgl_kunjungan,'YYYY-MM') = '$tgl'")
				->where('xcreate', 'APM')
				->get('daftar_ulang_irj');
			}
			return $this->db->where("TO_CHAR(tgl_kunjungan,'YYYY-MM-dd') = '$tgl'")
			->where('xcreate','APM')
			->get('daftar_ulang_irj');
		}

		function pencarian_pasien_baru_total_apm($pencarian,$data)
		{
			if($pencarian == 'BLN')
			{
				return $this->db->query("SELECT count(no_medrec),TO_CHAR(tgl_daftar,'YYYY-MM-dd') as tgl from data_pasien where xuser = 'APM'
				and TO_CHAR(tgl_daftar,'YYYY-MM') = '$data'
				group by TO_CHAR(tgl_daftar,'YYYY-MM-dd')");
			}

				return $this->db->query("SELECT count(no_medrec),TO_CHAR(tgl_daftar,'YYYY-MM') as tgl from data_pasien where xuser = 'APM'
				and TO_CHAR(tgl_daftar,'YYYY') = '$data'
				group by TO_CHAR(tgl_daftar,'YYYY-MM')");
		}

		function pencarian_pasien_poliklinik_total_apm($pencarian,$data)
		{
			if($pencarian == 'BLN')
			{
				return $this->db->query("SELECT count(no_medrec),TO_CHAR(tgl_kunjungan,'YYYY-MM-dd') as tgl from daftar_ulang_irj where xcreate = 'APM'
				and TO_CHAR(tgl_kunjungan,'YYYY-MM') = '$data'
				group by TO_CHAR(tgl_kunjungan,'YYYY-MM-dd')");
			}

			return $this->db->query("SELECT count(no_medrec),TO_CHAR(tgl_kunjungan,'YYYY-MM') as tgl from daftar_ulang_irj where xcreate = 'APM'
			and TO_CHAR(tgl_kunjungan,'YYYY') = '$data'
			group by TO_CHAR(tgl_kunjungan,'YYYY-MM')");
		}

		function get_pasien_input_realisasi_tindakan($date1, $date2) {
			return $this->db->query("SELECT 
				*
			FROM 
				v_input_realisasi_tindakan_irj 
			WHERE 
				to_char(tgl_kunjungan,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
			ORDER BY 
				tgl_kunjungan ASC");
		}

		function get_tindakan_umbal($no_register) {
			return $this->db->query("SELECT A
				.no_register,
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
			FROM
				pemeriksaan_laboratorium AS A 
			WHERE
				A.no_lab IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan,
				A.no_register UNION 
			SELECT A
				.no_register,
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
			FROM
				pemeriksaan_radiologi AS A 
			WHERE
				A.no_rad IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan,
				A.no_register UNION 
			SELECT A
				.no_register,
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan 
			FROM
				pemeriksaan_operasi AS A 
			WHERE
				A.no_ok IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan,
				A.no_register UNION
			SELECT A
				.no_register,
				A.idtindakan AS id_tindakan,
				A.nmtindakan AS jenis_tindakan,
				SUM ( A.vtot ) AS total,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan 
			FROM
				pelayanan_poli AS A
			WHERE
				A.no_register = '$no_register' 
			GROUP BY
				A.idtindakan,
				A.nmtindakan,
				A.no_register");
		}

		function get_data_tindakan($id_tindakan, $no_register) {
			return $this->db->query("SELECT A
			.no_register,
			A.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.vtot ) AS total,
			( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
			( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
			( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
			( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
			(SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND no_register = '$no_register' LIMIT 1) AS vtot 
		FROM
			pemeriksaan_laboratorium AS A 
		WHERE
			A.no_lab IS NOT NULL 
			AND A.no_register = '$no_register' 
			AND a.id_tindakan = '$id_tindakan'
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			A.no_register UNION 
		SELECT A
			.no_register,
			A.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.vtot ) AS total,
			( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
			( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
			( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
			( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
			(SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND no_register = '$no_register' LIMIT 1) AS vtot 
		FROM
			pemeriksaan_radiologi AS A 
		WHERE
			A.no_rad IS NOT NULL 
			AND A.no_register = '$no_register' 
			AND a.id_tindakan = '$id_tindakan'
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			A.no_register UNION 
		SELECT A
			.no_register,
			A.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.vtot ) AS total,
			( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
			( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
			( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
			( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
			(SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND no_register = '$no_register' LIMIT 1) AS vtot
		FROM
			pemeriksaan_operasi AS A 
		WHERE
			A.no_ok IS NOT NULL 
			AND A.no_register = '$no_register' 
			AND a.id_tindakan = '$id_tindakan'
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			A.no_register UNION
		SELECT A
			.no_register,
			A.idtindakan AS id_tindakan,
			A.nmtindakan AS jenis_tindakan,
			SUM ( A.vtot ) AS total,
			( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
			( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
			( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
			( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan,
			(SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$id_tindakan' AND no_register = '$no_register' LIMIT 1) AS vtot
		FROM
			pelayanan_poli AS A
		WHERE
			A.no_register = '$no_register' 
			AND a.idtindakan = '$id_tindakan'
		GROUP BY
			A.idtindakan,
			A.nmtindakan,
			A.no_register");
		}

		function get_resep_umbal_pasien($no_register) {
			return $this->db->query("SELECT
				no_register,
				item_obat,
				nama_obat,
				'Farmasi' AS kel_tindakan,
				'' AS sub_kelompok,
				'' AS kategori,
				\"Satuan_obat\" AS satuan,
				SUM(vtot) AS total 
			FROM 
				resep_pasien 
			WHERE 
				no_register = '$no_register'
			GROUP BY 
				no_register, item_obat, nama_obat, \"Satuan_obat\"");
		}

		function insert_realisasi_tindakan($data) {
			$this->db->insert('realisasi_tindakan', $data);
		}

		function get_data_tindakan_obat($item_obat, $no_register) {
			return $this->db->query("SELECT
				no_register,
				item_obat,
				nama_obat,
				'Farmasi' AS kel_tindakan,
				'' AS sub_kelompok,
				'' AS kategori,
				\"Satuan_obat\" AS satuan,
				SUM(vtot) AS total,
				(SELECT vtot FROM realisasi_tindakan WHERE id_tindakan = '$item_obat' AND no_register = '$no_register' LIMIT 1) AS vtot
			FROM 
				resep_pasien 
			WHERE 
				no_register = '$no_register'
				AND item_obat = '$item_obat'
			GROUP BY 
				no_register, item_obat, nama_obat, \"Satuan_obat\"");
		}

		function get_total_tindakan_pasien($no_register) {
			return $this->db->query("SELECT a.*,
				(SELECT vtot FROM total_realisasi_tindakan WHERE no_register = a.no_ipd LIMIT 1) AS vtot
			FROM 
				lap_pendapatan_pasien_pulang AS a
			WHERE 
				a.no_ipd = '$no_register'");
		}

		function get_tindakan_input_total($no_register) {
			return $this->db->query("SELECT 
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				SUM(a.qty) AS qty,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
				'lab' AS ins
			FROM
				pemeriksaan_laboratorium AS A 
			WHERE
				A.no_lab IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan UNION
			SELECT 
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				SUM(a.qty) AS qty,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
				'rad' AS ins
			FROM
				pemeriksaan_radiologi AS A 
			WHERE
				A.no_rad IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan UNION
			SELECT 
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				SUM(a.qty) AS qty,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
				'ok' AS ins
			FROM
				pemeriksaan_operasi AS A 
			WHERE
				A.no_ok IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan UNION
				SELECT 
				A.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.vtot ) AS total,
				SUM(a.qty) AS qty,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.id_tindakan LIMIT 1 ) AS satuan,
				'em' AS ins 
			FROM
				pemeriksaan_elektromedik AS A 
			WHERE
				A.no_em IS NOT NULL 
				AND A.no_register = '$no_register' 
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan UNION
			SELECT 
				A.idtindakan AS id_tindakan,
				A.nmtindakan AS jenis_tindakan,
				SUM ( A.vtot ) AS total,
				SUM(a.qtyind) AS qty,
				( SELECT kel_tindakan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kel_tindakan,
				( SELECT sub_kelompok FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS sub_kelompok,
				( SELECT kategori FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS kategori,
				( SELECT satuan FROM jenis_tindakan WHERE idtindakan = A.idtindakan LIMIT 1 ) AS satuan,
				CASE
					WHEN (b.id_poli = 'BA00') THEN 'tind_igd'
					ELSE 'tind_irj'
				END AS ins 
			FROM
				pelayanan_poli AS A,
				daftar_ulang_irj AS b
			WHERE
				A.no_register = '$no_register' 
				AND a.no_register = b.no_register
			GROUP BY
				A.idtindakan,
				A.nmtindakan,
				b.id_poli");
		}

		function get_obat_input_total($no_register) {
			return $this->db->query("SELECT
				item_obat,
				nama_obat,
				'Farmasi' AS kel_tindakan,
				'' AS sub_kelompok,
				'' AS kategori,
				\"Satuan_obat\" AS satuan,
				SUM(vtot) AS total,
				SUM(qty) AS qty
			FROM 
				resep_pasien 
			WHERE 
				no_register = '$no_register'
			GROUP BY 
				item_obat, nama_obat, \"Satuan_obat\"");
		}

		function insert_total_tindakan_pasien($datot) {
			$this->db->insert('total_realisasi_tindakan', $datot);
		}

		function insert_detail_tindakan_pasien($data) {
			$this->db->insert('realisasi_tindakan', $data);
		}

		function update_total_tindakan_pasien($datot, $no_register) {
			$this->db->where('no_register', $no_register);
			$this->db->update('total_realisasi_tindakan', $datot);
			return true;
		}

		function update_detail_tindakan_pasien($data, $id_tindakan, $no_register) {
			$this->db->where('no_register', $no_register);
			$this->db->where('id_tindakan', $id_tindakan);
			$this->db->update('realisasi_tindakan', $data);
			return true;
		}

		function lap_pasien_baru_surveilans($date1,$date2,$idrg){
			if($idrg == 'semua') {
				return $this->db->query("SELECT
				no_medrec,
				TO_CHAR( tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl_kunjungan,
				no_register AS no_ipd,
				no_register AS noregasal,
				e.formjson :: jsonb,
				jns_kunj,
				( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
				( SELECT sex FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
				( SELECT TO_CHAR( tgl_lahir, 'YYYY-MM-DD' ) FROM data_pasien b WHERE A.no_medrec = b.no_medrec ) AS tgl_lahir,
				( SELECT nm_dokter FROM data_dokter b WHERE A.id_dokter = b.id_dokter ) AS dokter 
				FROM
					daftar_ulang_irj
					A LEFT JOIN surveilans_ri e ON A.no_register = e.no_ipd 
				WHERE
					jns_kunj = 'BARU' 
					AND '[$date1,$date2]' :: daterange @> CAST ( A.tgl_kunjungan AS DATE ) 
					AND e.formjson IS NOT NULL UNION
				SELECT A
					.no_medrec,
					TO_CHAR( tgl_masuk, 'DD-MM-YYYY' ) AS tgl_kunjungan,
					A.no_ipd,
					noregasal,
					e.formjson :: jsonb,
					s.jns_kunj,
					( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
					( SELECT sex FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
					( SELECT TO_CHAR( tgl_lahir, 'YYYY-MM-DD' ) FROM data_pasien b WHERE A.no_medrec = b.no_medrec ) AS tgl_lahir,
					dokter 
				FROM
					pasien_iri
					A LEFT JOIN surveilans_ri e ON A.no_ipd = e.no_ipd
					LEFT JOIN daftar_ulang_irj s ON A.noregasal = s.no_register 
				WHERE
					s.jns_kunj = 'BARU' 
					AND '[$date1,$date2]' :: daterange @> CAST ( A.tgl_masuk AS DATE ) 
					AND e.formjson IS NOT NULL");
			} else {
				return $this->db->query("SELECT
					no_medrec,
					TO_CHAR( tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl_kunjungan,
					no_register AS no_ipd,
					no_register AS noregasal,
					e.formjson :: jsonb,
					jns_kunj,
					( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
					( SELECT sex FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
					( SELECT TO_CHAR( tgl_lahir, 'YYYY-MM-DD' ) FROM data_pasien b WHERE A.no_medrec = b.no_medrec ) AS tgl_lahir,
					( SELECT nm_dokter FROM data_dokter b WHERE A.id_dokter = b.id_dokter ) AS dokter 
					FROM
						daftar_ulang_irj
						A LEFT JOIN surveilans_ri e ON A.no_register = e.no_ipd 
					WHERE
						jns_kunj = 'BARU' 
						AND '[$date1,$date2]' :: daterange @> CAST ( A.tgl_kunjungan AS DATE ) 
						AND e.formjson IS NOT NULL 
						AND e.idrg = '$idrg' UNION
					SELECT A
						.no_medrec,
						TO_CHAR( tgl_masuk, 'DD-MM-YYYY' ) AS tgl_kunjungan,
						A.no_ipd,
						noregasal,
						e.formjson :: jsonb,
						s.jns_kunj,
						( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
						( SELECT sex FROM data_pasien b WHERE A.no_medrec = b.no_medrec ),
						( SELECT TO_CHAR( tgl_lahir, 'YYYY-MM-DD' ) FROM data_pasien b WHERE A.no_medrec = b.no_medrec ) AS tgl_lahir,
						dokter 
					FROM
						pasien_iri
						A LEFT JOIN surveilans_ri e ON A.no_ipd = e.no_ipd
						LEFT JOIN daftar_ulang_irj s ON A.noregasal = s.no_register 
					WHERE
						s.jns_kunj = 'BARU' 
						AND '[$date1,$date2]' :: daterange @> CAST ( A.tgl_masuk AS DATE ) 
						AND e.formjson IS NOT NULL AND e.idrg = '$idrg'");
			}
		}

		function lap_peralatan_medis_surveilans($date1,$date2,$idrg){
			if($idrg == 'semua') {
				return $this->db->query("SELECT
					no_medrec,
					TO_CHAR( e.tgl_input, 'DD-MM-YYYY' ) AS tgl_kunjungan,
					no_register AS no_ipd,
					no_register AS noregasal,
					e.formjson :: jsonb,
					( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec )
						FROM
							daftar_ulang_irj
							A LEFT JOIN surveilans_ri e ON A.no_register = e.no_ipd 
						WHERE
						'[$date1,$date2]' :: daterange @> CAST ( e.tgl_input AS DATE ) 
							AND e.formjson IS NOT NULL 
							UNION
						SELECT 
						A.no_medrec,
							TO_CHAR(e.tgl_input, 'DD-MM-YYYY' ) AS tgl_kunjungan,
							A.no_ipd,
							noregasal,
							e.formjson :: jsonb,
							( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec )
						FROM
							pasien_iri
							A LEFT JOIN surveilans_ri e ON A.no_ipd = e.no_ipd
						WHERE
							'[$date1,$date2]' :: daterange @> CAST ( e.tgl_input AS DATE ) 
							AND e.formjson IS NOT NULL");
			} else {
				return $this->db->query("SELECT
					no_medrec,
					TO_CHAR( e.tgl_input, 'DD-MM-YYYY' ) AS tgl_kunjungan,
					no_register AS no_ipd,
					no_register AS noregasal,
					e.formjson :: jsonb,
					( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec )
						FROM
							daftar_ulang_irj
							A LEFT JOIN surveilans_ri e ON A.no_register = e.no_ipd 
						WHERE
						'[$date1,$date2]' :: daterange @> CAST ( e.tgl_input AS DATE ) 
							AND e.formjson IS NOT NULL 
							AND e.idrg = '$idrg' UNION
						SELECT 
						A.no_medrec,
							TO_CHAR(e.tgl_input, 'DD-MM-YYYY' ) AS tgl_kunjungan,
							A.no_ipd,
							noregasal,
							e.formjson :: jsonb,
							( SELECT nama FROM data_pasien b WHERE A.no_medrec = b.no_medrec )
						FROM
							pasien_iri
							A LEFT JOIN surveilans_ri e ON A.no_ipd = e.no_ipd
						WHERE
							'[$date1,$date2]' :: daterange @> CAST ( e.tgl_input AS DATE ) 
							AND e.formjson IS NOT NULL AND e.idrg = '$idrg'");
			}
		}

		function lap_alat_infeksi_surveilans($date1,$date2,$idrg){
			if($idrg == 'semua') {
				return $this->db->query("SELECT
					tgl,
					COUNT ( * ) AS jml_pasien,
					COALESCE ( SUM ( ett ), 0 ) AS jml_ett,
					COALESCE ( SUM ( cvl ), 0 ) AS jml_cvl,
					COALESCE ( SUM ( infus ), 0 ) AS jml_infus,
					COALESCE ( SUM ( kateter ), 0 ) AS jml_kateter,
					COALESCE ( SUM ( tirah_baring ), 0 ) AS jml_tirah_baring,
					COALESCE ( SUM ( vap ), 0 ) AS jml_vap,
					COALESCE ( SUM ( bakteremia ), 0 ) AS jml_bakteremia,
					COALESCE ( SUM ( plebitis ), 0 ) AS jml_plebitis,
					COALESCE ( SUM ( isk ), 0 ) AS jml_isk,
					COALESCE ( SUM ( dekubitus ), 0 ) AS jml_dekubitus,
					COALESCE ( SUM ( kultur ), 0 ) AS jml_kultur,
					COALESCE ( SUM ( antibiotika ), 0 ) AS jml_antibiotika
				FROM
					lap_alat_infeksi_surveilans 
				WHERE
					tgl BETWEEN '$date1' AND '$date2'
				GROUP BY tgl");
			} else {
				return $this->db->query("SELECT
					tgl,
					COUNT ( * ) AS jml_pasien,
					COALESCE ( SUM ( ett ), 0 ) AS jml_ett,
					COALESCE ( SUM ( cvl ), 0 ) AS jml_cvl,
					COALESCE ( SUM ( infus ), 0 ) AS jml_infus,
					COALESCE ( SUM ( kateter ), 0 ) AS jml_kateter,
					COALESCE ( SUM ( tirah_baring ), 0 ) AS jml_tirah_baring,
					COALESCE ( SUM ( vap ), 0 ) AS jml_vap,
					COALESCE ( SUM ( bakteremia ), 0 ) AS jml_bakteremia,
					COALESCE ( SUM ( plebitis ), 0 ) AS jml_plebitis,
					COALESCE ( SUM ( isk ), 0 ) AS jml_isk,
					COALESCE ( SUM ( dekubitus ), 0 ) AS jml_dekubitus,
					COALESCE ( SUM ( kultur ), 0 ) AS jml_kultur,
					COALESCE ( SUM ( antibiotika ), 0 ) AS jml_antibiotika
				FROM
					lap_alat_infeksi_surveilans 
				WHERE
					tgl BETWEEN '$date1' AND '$date2'
					AND idrg = '$idrg'
				GROUP BY tgl");
			}
		}

		function lap_surveilands($date1,$date2,$idrg){
			if($idrg == 'semua'){
				return $this->db->query("SELECT
				COUNT ( * ) AS jml_pasien,
				COALESCE ( SUM ( op_terbuka ), 0 ) AS jml_op_terbuka,
				COALESCE ( SUM ( op_tertutup ), 0 ) AS jml_op_tertutup,
				COALESCE ( SUM ( luka_bersih ), 0 ) AS jml_luka_bersih,
				COALESCE ( SUM ( luka_kontaminasi ), 0 ) AS jml_luka_kontaminasi,
				COALESCE ( SUM ( luka_konta ), 0 ) AS jml_luka_konta,
				COALESCE ( SUM ( luka_kotor ), 0 ) AS jml_luka_kotor,
				COALESCE ( SUM ( op_satujam ), 0 ) AS jml_op_satujam,
				COALESCE ( SUM ( op_duajam ), 0 ) AS jml_op_duajam,
				COALESCE ( SUM ( op_limajam ), 0 ) AS jml_op_limajam,
				COALESCE ( SUM ( asa ), 0 ) AS jml_asa,
				COALESCE ( SUM ( resiko ), 0 ) AS jml_resiko,
				COALESCE ( SUM ( jml_pasien_kateter ), 0 ) AS jml_pasien_kateter,
				COALESCE ( SUM ( jml_hari_kateter ), 0 ) AS jml_hari_kateter,
				COALESCE ( SUM ( jml_pasien_infus ), 0 ) AS jml_pasien_infus,
				COALESCE ( SUM ( jml_hari_infus ), 0 ) AS jml_hari_infus,
				COALESCE ( SUM ( jml_pasien_cvl ), 0 ) AS jml_pasien_cvl,
				COALESCE ( SUM ( jml_hari_cvl ), 0 ) AS jml_hari_cvl,
				COALESCE ( SUM ( jml_pasien_ett ), 0 ) AS jml_pasien_ett,
				COALESCE ( SUM ( jml_hari_ett ), 0 ) AS jml_hari_ett,
				COALESCE ( SUM ( profilaksis ), 0 ) AS jml_profilaksis,
				COALESCE ( SUM ( pengobatan ), 0 ) AS jml_pengobatan,
				COALESCE ( SUM ( darah ), 0 ) AS jml_darah,
				COALESCE ( SUM ( urine ), 0 ) AS jml_urine,
				COALESCE ( SUM ( sputum ), 0 ) AS jml_sputum,
				COALESCE ( SUM ( pus_luka ), 0 ) AS jml_pus_luka,
				COALESCE ( SUM ( hasil_kultur ), 0 ) AS jml_hasil_kultur,
				COALESCE ( SUM ( bakteremia ), 0 ) AS jml_bakteremia,
				COALESCE ( SUM ( sepsis ), 0 ) AS jml_sepsis,
				COALESCE ( SUM ( vap ), 0 ) AS jml_vap,
				COALESCE ( SUM ( isk ), 0 ) AS jml_isk,
				COALESCE ( SUM ( luka_operasi ), 0 ) AS jml_luka_operasi,
				COALESCE ( SUM ( plebitis ), 0 ) AS jml_plebitis,
				COALESCE ( SUM ( infeksi_lain ), 0 ) AS jml_infeksi_lain,
				COALESCE ( SUM ( dekubitus ), 0 ) AS jml_dekubitus,
				COALESCE ( SUM ( tirah_baring ), 0 ) AS jml_tirah_baring
					FROM
						lap_surveilands
					WHERE
						'[$date1,$date2]' :: daterange @> CAST ( tgl AS DATE )
					");
			}else{
				return $this->db->query("SELECT
				COUNT ( * ) AS jml_pasien,
				COALESCE ( SUM ( op_terbuka ), 0 ) AS jml_op_terbuka,
				COALESCE ( SUM ( op_tertutup ), 0 ) AS jml_op_tertutup,
				COALESCE ( SUM ( luka_bersih ), 0 ) AS jml_luka_bersih,
				COALESCE ( SUM ( luka_kontaminasi ), 0 ) AS jml_luka_kontaminasi,
				COALESCE ( SUM ( luka_konta ), 0 ) AS jml_luka_konta,
				COALESCE ( SUM ( luka_kotor ), 0 ) AS jml_luka_kotor,
				COALESCE ( SUM ( op_satujam ), 0 ) AS jml_op_satujam,
				COALESCE ( SUM ( op_duajam ), 0 ) AS jml_op_duajam,
				COALESCE ( SUM ( op_limajam ), 0 ) AS jml_op_limajam,
				COALESCE ( SUM ( asa ), 0 ) AS jml_asa,
				COALESCE ( SUM ( resiko ), 0 ) AS jml_resiko,
				COALESCE ( SUM ( jml_pasien_kateter ), 0 ) AS jml_pasien_kateter,
				COALESCE ( SUM ( jml_hari_kateter ), 0 ) AS jml_hari_kateter,
				COALESCE ( SUM ( jml_pasien_infus ), 0 ) AS jml_pasien_infus,
				COALESCE ( SUM ( jml_hari_infus ), 0 ) AS jml_hari_infus,
				COALESCE ( SUM ( jml_pasien_cvl ), 0 ) AS jml_pasien_cvl,
				COALESCE ( SUM ( jml_hari_cvl ), 0 ) AS jml_hari_cvl,
				COALESCE ( SUM ( jml_pasien_ett ), 0 ) AS jml_pasien_ett,
				COALESCE ( SUM ( jml_hari_ett ), 0 ) AS jml_hari_ett,
				COALESCE ( SUM ( profilaksis ), 0 ) AS jml_profilaksis,
				COALESCE ( SUM ( pengobatan ), 0 ) AS jml_pengobatan,
				COALESCE ( SUM ( darah ), 0 ) AS jml_darah,
				COALESCE ( SUM ( urine ), 0 ) AS jml_urine,
				COALESCE ( SUM ( sputum ), 0 ) AS jml_sputum,
				COALESCE ( SUM ( pus_luka ), 0 ) AS jml_pus_luka,
				COALESCE ( SUM ( hasil_kultur ), 0 ) AS jml_hasil_kultur,
				COALESCE ( SUM ( bakteremia ), 0 ) AS jml_bakteremia,
				COALESCE ( SUM ( sepsis ), 0 ) AS jml_sepsis,
				COALESCE ( SUM ( vap ), 0 ) AS jml_vap,
				COALESCE ( SUM ( isk ), 0 ) AS jml_isk,
				COALESCE ( SUM ( luka_operasi ), 0 ) AS jml_luka_operasi,
				COALESCE ( SUM ( plebitis ), 0 ) AS jml_plebitis,
				COALESCE ( SUM ( infeksi_lain ), 0 ) AS jml_infeksi_lain,
				COALESCE ( SUM ( dekubitus ), 0 ) AS jml_dekubitus,
				COALESCE ( SUM ( tirah_baring ), 0 ) AS jml_tirah_baring
					FROM
						lap_surveilands
					WHERE
						'[$date1,$date2]' :: daterange @> CAST ( tgl AS DATE ) and idrg='$idrg'
					");
			}
			
		}


		public function data_ruangan()
		{
			return $this->db->query("SELECT idrg,nmruang FROM ruang");
		}

		public function data_ruangan_nm($idrg)
		{
			return $this->db->query("SELECT nmruang FROM ruang where idrg = '$idrg'");
		}

		public function get_count_bed()
		{
			return $this->db->query("SELECT count(*) as bed from bed");
		}

		public function get_hari_perawatan()
		{
			return $this->db->query("SELECT * from get_hari_perawatan");
		}

		public function get_hari_perawatan_search($thn)
		{
			return $this->db->query("SELECT COUNT
					( * ) AS hp_januari,
					(
					SELECT COUNT
						( * ) AS hp_februari 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 2 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 2 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_maret 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 3 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 3 :: DOUBLE PRECISION
						AND tgl_keluar != '' and tgl_keluar is not null 
					),
					(
					SELECT COUNT
						( * ) AS hp_april 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 4 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 4 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_mei 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 5 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 5 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_juni 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 6 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 6 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_juli 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 7 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 7 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_agustus 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 8 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 8 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_september 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 9 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 9 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_oktober 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 10 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 10 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_november 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 11 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 11 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					),
					(
					SELECT COUNT
						( * ) AS hp_desember 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 12 :: DOUBLE PRECISION 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 12 :: DOUBLE PRECISION 
						AND tgl_keluar != '' and tgl_keluar is not null
					) 
				FROM
					pasien_iri 
				WHERE
					TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT, tgl_masuk :: DATE ) <= 1 :: DOUBLE PRECISION 
					AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) > 1 :: DOUBLE PRECISION
					AND tgl_keluar != '' and tgl_keluar is not null
						");
		}

		public function get_lama_perawatan()
		{
			return $this->db->query("SELECT * from get_lama_rawat");
		}

		public function get_lama_perawatan_search($thn)
		{
			return $this->db->query("SELECT COALESCE
					(
						SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
						0 
					) AS lamrat_januari,
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_februari 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 2 :: DOUBLE PRECISION  and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_maret 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 3 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_april 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 4 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_mei 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 5 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT SUM
						( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS lamrat_juni 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 6 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_juli 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 7 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_agustus 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 8 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_september 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 9 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_oktober 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 10 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_november 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 11 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					),
					(
					SELECT COALESCE
						(
							SUM ( CASE WHEN tgl_keluar :: DATE - tgl_masuk = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ),
							0 
						) AS lamrat_desember 
					FROM
						pasien_iri 
					WHERE
						TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 12 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''
					) 
				FROM
					pasien_iri 
				WHERE
					TO_CHAR( tgl_masuk, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 1 :: DOUBLE PRECISION and tgl_keluar is not null and tgl_keluar != ''");
		}


		public function get_pasien_keluar()
		{
			return $this->db->query("SELECT * from get_pasien_keluar");
		}

		public function get_pasien_keluar_search($thn)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS keluar_januari,
			(
			SELECT COUNT
				( * ) AS keluar_februari 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 2 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_maret 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 3 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_april 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 4 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_mei 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 5 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_juni 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 6 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_juli 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 7 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_agustus 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 8 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_september 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 9 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_oktober 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 10 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_november 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 11 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			),
			(
			SELECT COUNT
				( * ) AS keluar_desember 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 12 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''
			) 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY' ) = '$thn' 
				AND date_part( 'month' :: TEXT, tgl_keluar :: DATE ) = 1 :: DOUBLE PRECISION 	and tgl_keluar is not null and tgl_keluar !=''");
		}

		public function get_pasien_meninggal()
		{
			return $this->db->query("SELECT * from jumlah_pasien_meninggal");
		}

		public function get_pasien_meninggal_search($thn)
		{
			return $this->db->query("SELECT COUNT
					( * ) AS meninggal_januari,
					(
					SELECT COUNT
						( * ) AS meninggal_februari 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 2 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_maret 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 3 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_april 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 4 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_mei 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 5 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_juni 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 6 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_juli 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 7 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_agustus 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 8 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_september 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 9 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_okt 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 10 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_nov 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 11 :: DOUBLE PRECISION 
					),
					(
					SELECT COUNT
						( * ) AS meninggal_des 
					FROM
						pasien_iri 
					WHERE
						tgl_meninggal IS NOT NULL 
						AND tgl_meninggal :: TEXT <> '' :: TEXT 
						AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
						AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 12 :: DOUBLE PRECISION 
					) 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT, tgl_meninggal :: DATE ) = 1 :: DOUBLE PRECISION");
		}

		public function get_pasien_meninggal_48()
		{
			return $this->db->query("SELECT * from pasien_meninggal_lebih48jam");
		}

		public function get_pasien_meninggal_48_search($thn)
		{
					return $this->db->query("SELECT COUNT
					( * ) AS meninggal_lebih48_januari ,
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_februari
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 2 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_maret
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 3 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_april
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 4 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_mei
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 5 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_juni
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 6 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_juli
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 7 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_agustus
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 8 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_september
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 9 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_okt
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 10 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_nov
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 11 :: DOUBLE PRECISION
					),
					(
					SELECT COUNT
					( * ) AS meninggal_lebih48_des
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 12 :: DOUBLE PRECISION
					)
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT = 'LEBIH 48 JAM' :: TEXT 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY' ) = '$thn' 
					AND date_part( 'month' :: TEXT,tgl_meninggal :: DATE ) = 1 :: DOUBLE PRECISION");
		}

		public function get_list_lab_ird_rekap($noreg_asal) {
			return $this->db->query("SELECT A
				.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.qty ) AS qtx,
				SUM ( A.vtot ) AS total_rekap
			FROM
				pemeriksaan_laboratorium AS A
			WHERE
				A.no_register = '$noreg_asal' 
				AND A.no_lab IS NOT NULL 
				-- AND a.bayar_umum IS NULL
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan");
		}

		public function get_list_tindakan_ird_rekap($no_reg_asal) {
			return $this->db->query("SELECT A
				.idtindakan,
				b.nmtindakan,
				SUM ( A.qtyind ) AS qty,
				SUM ( A.vtot ) AS total 
			FROM
				pelayanan_poli AS A,
				jenis_tindakan AS b
			WHERE
				A.no_register = '$no_reg_asal' 
				AND A.idtindakan = b.idtindakan 
				-- AND a.bayar_umum IS NULL
			GROUP BY
				A.idtindakan,
				b.nmtindakan");
		}

		public function get_list_em_ird_rekap($noreg_asal) {
			return $this->db->query("SELECT A
				.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.qty ) AS qtx,
				SUM ( A.vtot ) AS total_rekap
			FROM
				pemeriksaan_elektromedik AS A
			WHERE
				A.no_register = '$noreg_asal' 
				AND A.no_em IS NOT NULL 
				-- AND a.bayar_umum IS NULL
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan");
		}

		public function get_list_rad_ird_rekap($noreg_asal) {
			return $this->db->query("SELECT A
				.id_tindakan,
				A.jenis_tindakan,
				SUM ( A.qty ) AS qtx,
				SUM ( A.vtot ) AS total_rekap
			FROM
				pemeriksaan_radiologi AS A
			WHERE
				A.no_register = '$noreg_asal' 
				AND A.no_rad IS NOT NULL 
				-- AND a.bayar_umum IS NULL
			GROUP BY
				A.id_tindakan,
				A.jenis_tindakan");
		}

		public function get_pasien_masuk_borlostoi($bulan)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS limpapeh_l2,
			(
			SELECT COUNT
			( * ) AS limpapeh_l3
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0802','0804')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS limpapeh_l4
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0803','0805')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS singgalang_l1_l2
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0601','0602')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS singgalang_l3
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg = '0603'
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS merapi_l1
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg = '0701'
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS merapi_l2
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0702','0705')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS merapi_l3
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0703','0706')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS anak
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0101','0501','0103')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS bedah
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg = '0502'
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS kebidanan
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0503','0107')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS icu
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg IN ('0404','0704')
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					),
					(
					SELECT COUNT
					( * ) AS nicu
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg = '0406'
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'
					)
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.idrg = '0801' 
					AND to_char( b.tgl_masuk, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_pasien_keluar_hidup_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
				( * ) AS limpapeh_l3
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0802','0804')
					),
					(
						SELECT COUNT
					( * ) AS limpapeh_l4
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0803','0805')
					),
					(
						SELECT COUNT
					( * ) AS singgalang_l1_l2
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0601','0602')
					),
					(
						SELECT COUNT
					( * ) AS singgalang_l3
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0603'
					),
					(
					SELECT COUNT
					( * ) AS merapi_l1
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0701'
					),
					(
					SELECT COUNT
					( * ) AS merapi_l2
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT
					AND tgl_meninggal is  null 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0702','0705')
					),
					(
					SELECT COUNT
					( * ) AS merapi_l3
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT
					AND tgl_meninggal is  null 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0703','0706')
					),
					(
					SELECT COUNT
					( * ) AS anak
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0101','0501','0103')
					),
					(
					SELECT COUNT
					( * ) AS bedah
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT
					AND tgl_meninggal is  null 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0502'
					),
					(
					SELECT COUNT
					( * ) AS kebidanan
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0503','0107')
					),
					(
					SELECT COUNT
					( * ) AS icu
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0404','0704')
					),
					(
					SELECT COUNT
					( * ) AS nicu
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0406'
					)
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND tgl_meninggal is  null
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0801'");
		}

		public function get_pasien_keluar_mati_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0802','0804')
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0803','0805')
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0603' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l1 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0701' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0703','0706')
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
				),
				(
				SELECT COUNT
					( * ) AS bedah 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0502' 
				),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
				),
				(
				SELECT COUNT
					( * ) AS icu
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0404','0704') 
				),
				(
				SELECT COUNT
					( * ) AS nicu
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0406'
				)
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
				AND idrg = '0801'");
		}

		public function get_pasien_keluar_hidup_mati_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0802','0804')
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0803','0805')
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l3 
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0603' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l1 
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0701' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0703','0706')
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
				),
				(
				SELECT COUNT
					( * ) AS bedah 
				FROM
					pasien_iri 
				WHERE
				tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0502' 
				),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
				),
				(
				SELECT COUNT
					( * ) AS icu
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg IN ('0404','0704') 
				),
				(
				SELECT COUNT
					( * ) AS nicu
				FROM
					pasien_iri 
				WHERE
						tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
					AND idrg = '0406'
				)
			FROM
				pasien_iri 
			WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) = '$bulan' 
				AND idrg = '0801'");
		}

		public function get_pasien_mati_kurang48_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0802' 
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0803' 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0603' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l1 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0701' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0703' 
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
				),
				(
				SELECT COUNT
					( * ) AS bedah 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0502' 
				),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
				),
				(
				SELECT COUNT
					( * ) AS icu 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0404', '0704' ) 
				),
				(
				SELECT COUNT
					( * ) AS nicu 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0406' 
				) 
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
				AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND idrg = '0801'");
		}

		public function get_pasien_mati_lebih48_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0802' 
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0803' 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0603' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l1 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0701' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0703' 
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
				),
				(
				SELECT COUNT
					( * ) AS bedah 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0502' 
				),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
				),
				(
				SELECT COUNT
					( * ) AS icu 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0404', '0704' ) 
				),
				(
				SELECT COUNT
					( * ) AS nicu 
				FROM
					pasien_iri 
				WHERE
					tgl_meninggal IS NOT NULL 
					AND tgl_meninggal :: TEXT <> '' :: TEXT 
					AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
					AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0406' 
				) 
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
				AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND idrg = '0801'");
		}

		public function get_lama_rawat_borlostoi($bulan)
		{
				return $this->db->query("SELECT SUM
				( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS limpapeh_l2,
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0802', '0804' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS limpapeh_l4 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0803', '0805' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS singgalang_l1_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS singgalang_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0603' 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS merapi_l1 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0701' 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS merapi_l2 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS merapi_l3 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0703', '0706' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS anak 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS bedah 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0502' 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS kebidanan 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS icu 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0404', '0704' ) 
				),
				(
				SELECT SUM
					( CASE WHEN ( tgl_keluar :: DATE - tgl_masuk ) = 0 AND tgl_keluar IS NOT NULL THEN 1 ELSE tgl_keluar :: DATE - tgl_masuk END ) AS nicu 
				FROM
					pasien_iri 
				WHERE
					tgl_keluar IS NOT NULL 
					AND tgl_keluar :: TEXT <> '' :: TEXT 
					AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
					AND idrg = '0406' 
				) 
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND tgl_keluar :: TEXT <> '' :: TEXT 
				AND TO_CHAR( tgl_keluar :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND idrg = '0801'");
		}

		public function get_pasien_awal_borlostoi($bulan)
		{
			$bulan_day = $bulan.'-01';
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ( '0802', '0804' ) 
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0803','0805')
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0601','0602')
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l3
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg = '0603'
				),
				(
				SELECT COUNT
					( * ) AS merapi_l1
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg = '0701'
				),
				(
				SELECT COUNT
					( * ) AS merapi_l2
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0702','0705')
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0703','0706')
				),
				(
				SELECT COUNT
					( * ) AS anak
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0101','0501','0103')
				),
				(
				SELECT COUNT
					( * ) AS bedah
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg = '0502'
				),
				(
				SELECT COUNT
					( * ) AS kebidanan
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0503','0107')
				),
				(
				SELECT COUNT
					( * ) AS icu
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg IN ('0404','0704')
				),
				(
				SELECT COUNT
					( * ) AS nicu
				FROM
					pasien_iri 
				WHERE
					pasien_iri.tgl_keluar  > '$bulan_day' 
					AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
					AND idrg = '0406'
				)
			FROM
				pasien_iri 
			WHERE
				pasien_iri.tgl_keluar  > '$bulan_day' 
				AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM' :: TEXT ) < '$bulan' 
				AND idrg = '0801'");
		}

		public function get_pasien_pindah_borlostoi($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0802', '0804' ) 
					AND statkeluarrg = 'pindah' 
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0803', '0805' ) 
					AND statkeluarrg = 'pindah' 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
					AND statkeluarrg = 'pindah' 
				),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM ruang_iri WHERE to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0603' AND statkeluarrg = 'pindah' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM ruang_iri WHERE to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0701' AND statkeluarrg = 'pindah' ),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
					AND statkeluarrg = 'pindah' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0703', '0706' ) 
					AND statkeluarrg = 'pindah' 
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
					AND statkeluarrg = 'pindah' 
				),
				( SELECT COUNT ( * ) AS bedah FROM ruang_iri WHERE to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0502' AND statkeluarrg = 'pindah' ),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
					AND statkeluarrg = 'pindah' 
				),
				(
				SELECT COUNT
					( * ) AS icu 
				FROM
					ruang_iri 
				WHERE
					to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0404', '0704' ) 
					AND statkeluarrg = 'pindah' 
				),
				( SELECT COUNT ( * ) AS nicu FROM ruang_iri WHERE to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0406' AND statkeluarrg = 'pindah' ) 
			FROM
				ruang_iri 
			WHERE
				to_char( tglkeluarrg, 'YYYY-MM' ) = '$bulan' 
				AND idrg = '0801' 
				AND statkeluarrg = 'pindah'");
		}

		public function get_jumlah_tt_vip()
		{
				return $this->db->query("	SELECT COUNT
				( * ) AS limpapeh_l2,
				( SELECT COUNT ( * ) AS limpapeh_l3 FROM bed WHERE idrg IN ( '0802', '0804' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS limpapeh_l4 FROM bed WHERE idrg IN ( '0803', '0805' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS singgalang_l1_l2 FROM bed WHERE idrg IN ( '0601', '0602' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM bed WHERE idrg = '0603' AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM bed WHERE idrg = '0701' AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS merapi_l2 FROM bed WHERE idrg IN ( '0702', '0705' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS merapi_l3 FROM bed WHERE idrg IN ( '0703', '0706' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS anak FROM bed WHERE idrg IN ( '0101', '0501', '0103' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS bedah FROM bed WHERE idrg = '0502' AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS kebidanan FROM bed WHERE idrg IN ( '0503', '0107' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS icu FROM bed WHERE idrg IN ( '0404', '0704' ) AND kelas = 'VIP' ),
				( SELECT COUNT ( * ) AS nicu FROM bed WHERE idrg = '0406' AND kelas = 'VIP' ) 
			FROM
				bed 
			WHERE
				idrg = '0801' 
				AND kelas = 'VIP'");
		}

		public function get_jumlah_tt_satu()
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				( SELECT COUNT ( * ) AS limpapeh_l3 FROM bed WHERE idrg IN ( '0802', '0804' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS limpapeh_l4 FROM bed WHERE idrg IN ( '0803', '0805' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS singgalang_l1_l2 FROM bed WHERE idrg IN ( '0601', '0602' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM bed WHERE idrg = '0603' AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM bed WHERE idrg = '0701' AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS merapi_l2 FROM bed WHERE idrg IN ( '0702', '0705' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS merapi_l3 FROM bed WHERE idrg IN ( '0703', '0706' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS anak FROM bed WHERE idrg IN ( '0101', '0501', '0103' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS bedah FROM bed WHERE idrg = '0502' AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS kebidanan FROM bed WHERE idrg IN ( '0503', '0107' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS icu FROM bed WHERE idrg IN ( '0404', '0704' ) AND kelas = 'I' ),
				( SELECT COUNT ( * ) AS nicu FROM bed WHERE idrg = '0406' AND kelas = 'I' ) 
			FROM
				bed 
			WHERE
				idrg = '0801' 
				AND kelas = 'I'");
		}

		public function get_jumlah_tt_dua()
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				( SELECT COUNT ( * ) AS limpapeh_l3 FROM bed WHERE idrg IN ( '0802', '0804' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS limpapeh_l4 FROM bed WHERE idrg IN ( '0803', '0805' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS singgalang_l1_l2 FROM bed WHERE idrg IN ( '0601', '0602' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM bed WHERE idrg = '0603' AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM bed WHERE idrg = '0701' AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS merapi_l2 FROM bed WHERE idrg IN ( '0702', '0705' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS merapi_l3 FROM bed WHERE idrg IN ( '0703', '0706' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS anak FROM bed WHERE idrg IN ( '0101', '0501', '0103' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS bedah FROM bed WHERE idrg = '0502' AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS kebidanan FROM bed WHERE idrg IN ( '0503', '0107' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS icu FROM bed WHERE idrg IN ( '0404', '0704' ) AND kelas = 'II' ),
				( SELECT COUNT ( * ) AS nicu FROM bed WHERE idrg = '0406' AND kelas = 'II' ) 
			FROM
				bed 
			WHERE
				idrg = '0801' 
				AND kelas = 'II'");
		}

		public function get_jumlah_tt_tiga()
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				( SELECT COUNT ( * ) AS limpapeh_l3 FROM bed WHERE idrg IN ( '0802', '0804' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS limpapeh_l4 FROM bed WHERE idrg IN ( '0803', '0805' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS singgalang_l1_l2 FROM bed WHERE idrg IN ( '0601', '0602' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM bed WHERE idrg = '0603' AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM bed WHERE idrg = '0701' AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS merapi_l2 FROM bed WHERE idrg IN ( '0702', '0705' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS merapi_l3 FROM bed WHERE idrg IN ( '0703', '0706' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS anak FROM bed WHERE idrg IN ( '0101', '0501', '0103' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS bedah FROM bed WHERE idrg = '0502' AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS kebidanan FROM bed WHERE idrg IN ( '0503', '0107' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS icu FROM bed WHERE idrg IN ( '0404', '0704' ) AND kelas = 'III' ),
				( SELECT COUNT ( * ) AS nicu FROM bed WHERE idrg = '0406' AND kelas = 'III' ) 
			FROM
				bed 
			WHERE
				idrg = '0801' 
				AND kelas = 'III'");
		}

		public function get_jumlah_hari_perawatan($bulan)
		{
				return $this->db->query("SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l2,
						(
						SELECT SUM
							(
							CASE
									
									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
										END 
										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
									END 
									) AS limpapeh_l3 
								FROM
									ruang_iri 
								WHERE
									idrg IN ( '0802', '0804' ) 
									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
								),
								(
								SELECT SUM
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
												END 
												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
											END 
											) AS limpapeh_l4 
										FROM
											ruang_iri 
										WHERE
											idrg IN ( '0803', '0805' ) 
											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
										),
										(
										SELECT SUM
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
														END 
														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
													END 
													) AS singgalang_l1_l2 
												FROM
													ruang_iri 
												WHERE
													idrg IN ( '0601', '0602' ) 
													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
												),
												(
												SELECT SUM
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																END 
																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
															END 
															) AS singgalang_l3 
														FROM
															ruang_iri 
														WHERE
															idrg = '0603' 
															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
														),
														(
														SELECT SUM
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																		END 
																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																	END 
																	) AS merapi_l1 
																FROM
																	ruang_iri 
																WHERE
																	idrg = '0701' 
																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																),
																(
																SELECT SUM
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																			(
																			CASE
																					
																					WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																					EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																				END 
																				) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																			END 
																			) AS merapi_l2 
																		FROM
																			ruang_iri 
																		WHERE
																			idrg IN ( '0702', '0705' ) 
																			AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																			AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																		),
																	
																				(
																				SELECT SUM
																					(
																					CASE
																							
																							WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																									EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																								END 
																								) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																							END 
																							) AS merapi_l3 
																						FROM
																							ruang_iri 
																						WHERE
																							idrg IN ( '0703', '0706' ) 
																							AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																							AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																						),
																						(
																						SELECT SUM
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																										END 
																										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																									END 
																									) AS anak 
																								FROM
																									ruang_iri 
																								WHERE
																									idrg IN ( '0101', '0501', '0103' ) 
																									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																								),
																								(
																								SELECT SUM
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																												END 
																												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																											END 
																											) AS bedah 
																										FROM
																											ruang_iri 
																										WHERE
																											idrg = '0502' 
																											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																										),
																										(
																										SELECT SUM
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																														END 
																														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																													END 
																													) AS kebidanan 
																												FROM
																													ruang_iri 
																												WHERE
																													idrg IN ( '0503', '0107' ) 
																													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																												),
																												(
																												SELECT SUM
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																END 
																																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																															END 
																															) AS icu 
																														FROM
																															ruang_iri 
																														WHERE
																															idrg IN ( '0404', '0704' ) 
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																														),
																														(
																														SELECT SUM
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																																	(
																																	CASE
																																			
																																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																		END 
																																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																																	END 
																																	) AS nicu 
																																FROM
																																	ruang_iri 
																																WHERE
																																	idrg = '0406' 
																																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																) 
																															FROM
																																ruang_iri 
																															WHERE
																																idrg = '0801' 
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_jumlah_hari_perawatan_vip($bulan)
		{
				return $this->db->query("SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l2,
						(
			SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l3 
					FROM
						ruang_iri 
					WHERE
						idrg IN ( '0802', '0804' ) 
						AND kelas = 'VIP'
						AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
						AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
					),
					(
					SELECT SUM
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
								(
								CASE
										
										WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
										EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
									END 
									) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
								END 
								) AS limpapeh_l4 
							FROM
								ruang_iri 
							WHERE
								idrg IN ( '0803', '0805' ) 
								AND kelas = 'VIP'
								AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
								AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
							),
							(
							SELECT SUM
								(
								CASE
										
										WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
										(
										CASE
												
												WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
												EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
											END 
											) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
										END 
										) AS singgalang_l1_l2 
									FROM
										ruang_iri 
									WHERE
										idrg IN ( '0601', '0602' )
										AND kelas = 'VIP' 
										AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
										AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
									),
									(
									SELECT SUM
										(
										CASE
												
												WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
												(
												CASE
														
														WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
														EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
													END 
													) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
												END 
												) AS singgalang_l3 
											FROM
												ruang_iri 
											WHERE
												idrg = '0603' 
												AND kelas = 'VIP'
												AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
												AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
											),
											(
											SELECT SUM
												(
												CASE
														
														WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
														(
														CASE
																
																WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
															END 
															) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
														END 
														) AS merapi_l1 
													FROM
														ruang_iri 
													WHERE
														idrg = '0701' 
														AND kelas = 'VIP'
														AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
														AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
													),
													(
													SELECT SUM
														(
														CASE
																
																WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																(
																CASE
																		
																		WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																		EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																	END 
																	) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																END 
																) AS merapi_l2 
															FROM
																ruang_iri 
															WHERE
																idrg IN ( '0702', '0705' ) 
																AND kelas = 'VIP'
																AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
															),
														
																	(
																	SELECT SUM
																		(
																		CASE
																				
																				WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																				(
																				CASE
																						
																						WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																						EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																					END 
																					) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																				END 
																				) AS merapi_l3 
																			FROM
																				ruang_iri 
																			WHERE
																				idrg IN ( '0703', '0706' ) 
																				AND kelas = 'VIP'
																				AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																			),
																			(
																			SELECT SUM
																				(
																				CASE
																						
																						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																						(
																						CASE
																								
																								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																							END 
																							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																						END 
																						) AS anak 
																					FROM
																						ruang_iri 
																					WHERE
																						idrg IN ( '0101', '0501', '0103' ) 
																						AND kelas = 'VIP'
																						AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																						AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																					),
																					(
																					SELECT SUM
																						(
																						CASE
																								
																								WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																								(
																								CASE
																										
																										WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																										EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																									END 
																									) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																								END 
																								) AS bedah 
																							FROM
																								ruang_iri 
																							WHERE
																								idrg = '0502' 
																								AND kelas = 'VIP'
																								AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																								AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																							),
																							(
																							SELECT SUM
																								(
																								CASE
																										
																										WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																										(
																										CASE
																												
																												WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																												EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																											END 
																											) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																										END 
																										) AS kebidanan 
																									FROM
																										ruang_iri 
																									WHERE
																										idrg IN ( '0503', '0107' ) 
																										AND kelas = 'VIP'
																										AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																										AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																									),
																									(
																									SELECT SUM
																										(
																										CASE
																												
																												WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																												(
																												CASE
																														
																														WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																														EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																													END 
																													) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																												END 
																												) AS icu 
																											FROM
																												ruang_iri 
																											WHERE
																												idrg IN ( '0404', '0704' ) 
																												AND kelas = 'VIP'
																												AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																												AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																											),
																											(
																											SELECT SUM
																												(
																												CASE
																														
																														WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																														(
																														CASE
																																
																																WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																															END 
																															) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																														END 
																														) AS nicu 
																													FROM
																														ruang_iri 
																													WHERE
																														idrg = '0406' 
																														AND kelas = 'VIP'
																														AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																														AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																													) 
																												FROM
																													ruang_iri 
																												WHERE
																													idrg = '0801' 
																													AND kelas = 'VIP'
																												AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_jumlah_hari_perawatan_satu($bulan)
		{
				return $this->db->query("SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l2,
						(
						SELECT SUM
							(
							CASE
									
									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
										END 
										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
									END 
									) AS limpapeh_l3 
								FROM
									ruang_iri 
								WHERE
									idrg IN ( '0802', '0804' ) 
									AND kelas = 'I'
									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
								),
								(
								SELECT SUM
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
												END 
												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
											END 
											) AS limpapeh_l4 
										FROM
											ruang_iri 
										WHERE
											idrg IN ( '0803', '0805' ) 
											AND kelas = 'I'
											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
										),
										(
										SELECT SUM
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
														END 
														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
													END 
													) AS singgalang_l1_l2 
												FROM
													ruang_iri 
												WHERE
													idrg IN ( '0601', '0602' )
													AND kelas = 'I' 
													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
												),
												(
												SELECT SUM
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																END 
																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
															END 
															) AS singgalang_l3 
														FROM
															ruang_iri 
														WHERE
															idrg = '0603' 
															AND kelas = 'I'
															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
														),
														(
														SELECT SUM
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																		END 
																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																	END 
																	) AS merapi_l1 
																FROM
																	ruang_iri 
																WHERE
																	idrg = '0701' 
																	AND kelas = 'I'
																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																),
																(
																SELECT SUM
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																			(
																			CASE
																					
																					WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																					EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																				END 
																				) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																			END 
																			) AS merapi_l2 
																		FROM
																			ruang_iri 
																		WHERE
																			idrg IN ( '0702', '0705' ) 
																			AND kelas = 'I'
																			AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																			AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																		),
																	
																				(
																				SELECT SUM
																					(
																					CASE
																							
																							WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																									EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																								END 
																								) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																							END 
																							) AS merapi_l3 
																						FROM
																							ruang_iri 
																						WHERE
																							idrg IN ( '0703', '0706' ) 
																							AND kelas = 'I'
																							AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																							AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																						),
																						(
																						SELECT SUM
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																										END 
																										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																									END 
																									) AS anak 
																								FROM
																									ruang_iri 
																								WHERE
																									idrg IN ( '0101', '0501', '0103' ) 
																									AND kelas = 'I'
																									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																								),
																								(
																								SELECT SUM
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																												END 
																												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																											END 
																											) AS bedah 
																										FROM
																											ruang_iri 
																										WHERE
																											idrg = '0502' 
																											AND kelas = 'I'
																											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																										),
																										(
																										SELECT SUM
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																														END 
																														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																													END 
																													) AS kebidanan 
																												FROM
																													ruang_iri 
																												WHERE
																													idrg IN ( '0503', '0107' ) 
																													AND kelas = 'I'
																													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																												),
																												(
																												SELECT SUM
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																END 
																																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																															END 
																															) AS icu 
																														FROM
																															ruang_iri 
																														WHERE
																															idrg IN ( '0404', '0704' ) 
																															AND kelas = 'I'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																														),
																														(
																														SELECT SUM
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																																	(
																																	CASE
																																			
																																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																		END 
																																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																																	END 
																																	) AS nicu 
																																FROM
																																	ruang_iri 
																																WHERE
																																	idrg = '0406' 
																																	AND kelas = 'I'
																																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																) 
																															FROM
																																ruang_iri 
																															WHERE
																																idrg = '0801' 
																																AND kelas = 'I'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_jumlah_hari_perawatan_dua($bulan)
		{
				return $this->db->query("SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l2,
						(
						SELECT SUM
							(
							CASE
									
									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
										END 
										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
									END 
									) AS limpapeh_l3 
								FROM
									ruang_iri 
								WHERE
									idrg IN ( '0802', '0804' ) 
									AND kelas = 'II'
									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
								),
								(
								SELECT SUM
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
												END 
												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
											END 
											) AS limpapeh_l4 
										FROM
											ruang_iri 
										WHERE
											idrg IN ( '0803', '0805' ) 
											AND kelas = 'II'
											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
										),
										(
										SELECT SUM
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
														END 
														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
													END 
													) AS singgalang_l1_l2 
												FROM
													ruang_iri 
												WHERE
													idrg IN ( '0601', '0602' )
													AND kelas = 'II' 
													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
												),
												(
												SELECT SUM
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																END 
																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
															END 
															) AS singgalang_l3 
														FROM
															ruang_iri 
														WHERE
															idrg = '0603' 
															AND kelas = 'II'
															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
														),
														(
														SELECT SUM
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																		END 
																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																	END 
																	) AS merapi_l1 
																FROM
																	ruang_iri 
																WHERE
																	idrg = '0701' 
																	AND kelas = 'II'
																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																),
																(
																SELECT SUM
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																			(
																			CASE
																					
																					WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																					EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																				END 
																				) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																			END 
																			) AS merapi_l2 
																		FROM
																			ruang_iri 
																		WHERE
																			idrg IN ( '0702', '0705' ) 
																			AND kelas = 'II'
																			AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																			AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																		),
																	
																				(
																				SELECT SUM
																					(
																					CASE
																							
																							WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																									EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																								END 
																								) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																							END 
																							) AS merapi_l3 
																						FROM
																							ruang_iri 
																						WHERE
																							idrg IN ( '0703', '0706' ) 
																							AND kelas = 'II'
																							AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																							AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																						),
																						(
																						SELECT SUM
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																										END 
																										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																									END 
																									) AS anak 
																								FROM
																									ruang_iri 
																								WHERE
																									idrg IN ( '0101', '0501', '0103' ) 
																									AND kelas = 'II'
																									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																								),
																								(
																								SELECT SUM
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																												END 
																												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																											END 
																											) AS bedah 
																										FROM
																											ruang_iri 
																										WHERE
																											idrg = '0502' 
																											AND kelas = 'II'
																											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																										),
																										(
																										SELECT SUM
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																														END 
																														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																													END 
																													) AS kebidanan 
																												FROM
																													ruang_iri 
																												WHERE
																													idrg IN ( '0503', '0107' ) 
																													AND kelas = 'II'
																													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																												),
																												(
																												SELECT SUM
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																END 
																																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																															END 
																															) AS icu 
																														FROM
																															ruang_iri 
																														WHERE
																															idrg IN ( '0404', '0704' ) 
																															AND kelas = 'II'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																														),
																														(
																														SELECT SUM
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																																	(
																																	CASE
																																			
																																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																		END 
																																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																																	END 
																																	) AS nicu 
																																FROM
																																	ruang_iri 
																																WHERE
																																	idrg = '0406' 
																																	AND kelas = 'II'
																																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																) 
																															FROM
																																ruang_iri 
																															WHERE
																																idrg = '0801' 
																																AND kelas = 'II'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_jumlah_hari_perawatan_tiga($bulan)
		{
				return $this->db->query("SELECT SUM
				(
				CASE
						
						WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
						(
						CASE
								
								WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
								EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
							END 
							) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
						END 
						) AS limpapeh_l2,
						(
						SELECT SUM
							(
							CASE
									
									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
										END 
										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
									END 
									) AS limpapeh_l3 
								FROM
									ruang_iri 
								WHERE
									idrg IN ( '0802', '0804' ) 
									AND kelas = 'III'
									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
								),
								(
								SELECT SUM
									(
									CASE
											
											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
												END 
												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
											END 
											) AS limpapeh_l4 
										FROM
											ruang_iri 
										WHERE
											idrg IN ( '0803', '0805' ) 
											AND kelas = 'III'
											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
										),
										(
										SELECT SUM
											(
											CASE
													
													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
														END 
														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
													END 
													) AS singgalang_l1_l2 
												FROM
													ruang_iri 
												WHERE
													idrg IN ( '0601', '0602' )
													AND kelas = 'III' 
													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
												),
												(
												SELECT SUM
													(
													CASE
															
															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																END 
																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
															END 
															) AS singgalang_l3 
														FROM
															ruang_iri 
														WHERE
															idrg = '0603' 
															AND kelas = 'III'
															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
														),
														(
														SELECT SUM
															(
															CASE
																	
																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																		END 
																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																	END 
																	) AS merapi_l1 
																FROM
																	ruang_iri 
																WHERE
																	idrg = '0701' 
																	AND kelas = 'III'
																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																),
																(
																SELECT SUM
																	(
																	CASE
																			
																			WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																			(
																			CASE
																					
																					WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																					EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																				END 
																				) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																			END 
																			) AS merapi_l2 
																		FROM
																			ruang_iri 
																		WHERE
																			idrg IN ( '0702', '0705' ) 
																			AND kelas = 'III'
																			AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																			AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																		),
																	
																				(
																				SELECT SUM
																					(
																					CASE
																							
																							WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																									EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																								END 
																								) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																							END 
																							) AS merapi_l3 
																						FROM
																							ruang_iri 
																						WHERE
																							idrg IN ( '0703', '0706' ) 
																							AND kelas = 'III'
																							AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																							AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																						),
																						(
																						SELECT SUM
																							(
																							CASE
																									
																									WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																											EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																										END 
																										) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																									END 
																									) AS anak 
																								FROM
																									ruang_iri 
																								WHERE
																									idrg IN ( '0101', '0501', '0103' ) 
																									AND kelas = 'III'
																									AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																									AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																								),
																								(
																								SELECT SUM
																									(
																									CASE
																											
																											WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																													EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																												END 
																												) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																											END 
																											) AS bedah 
																										FROM
																											ruang_iri 
																										WHERE
																											idrg = '0502' 
																											AND kelas = 'III'
																											AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																											AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																										),
																										(
																										SELECT SUM
																											(
																											CASE
																													
																													WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																															EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																														END 
																														) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																													END 
																													) AS kebidanan 
																												FROM
																													ruang_iri 
																												WHERE
																													idrg IN ( '0503', '0107' ) 
																													AND kelas = 'III'
																													AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																													AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																												),
																												(
																												SELECT SUM
																													(
																													CASE
																															
																															WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																	EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																END 
																																) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																															END 
																															) AS icu 
																														FROM
																															ruang_iri 
																														WHERE
																															idrg IN ( '0404', '0704' ) 
																															AND kelas = 'III'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																															AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																														),
																														(
																														SELECT SUM
																															(
																															CASE
																																	
																																	WHEN SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), '6', '2' ) != SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '6', '2' ) THEN
																																	(
																																	CASE
																																			
																																			WHEN SUBSTR( CAST ( tglmasukrg AS VARCHAR ), '0', '8' ) = '$bulan' THEN
																																			EXTRACT ( DAY FROM ( date_trunc( 'month', tglmasukrg :: DATE ) + INTERVAL '1 month - 1 day' ) :: TIMESTAMP - tglmasukrg ) ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - CONCAT ( SUBSTR( CAST ( tglkeluarrg AS VARCHAR ), 0, 8 ), '-01' ) :: TIMESTAMP ) 
																																		END 
																																		) + 1 ELSE EXTRACT ( DAY FROM tglkeluarrg :: TIMESTAMP - tglmasukrg :: TIMESTAMP ) + 1 
																																	END 
																																	) AS nicu 
																																FROM
																																	ruang_iri 
																																WHERE
																																	idrg = '0406' 
																																	AND kelas = 'III'
																																	AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																	AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan' 
																																) 
																															FROM
																																ruang_iri 
																															WHERE
																																idrg = '0801' 
																																AND kelas = 'III'
																															AND TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM' ) = '$bulan' 
				AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM' ) = '$bulan'");
		}

		public function get_jumlah_pasien_masuk_pindah($bulan)
		{
				return $this->db->query("SELECT COUNT
				( * ) AS limpapeh_l2,
				(
				SELECT COUNT
					( * ) AS limpapeh_l3 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0802', '0804' ) 
					AND statmasukrg = 'pindahan' 
				),
				(
				SELECT COUNT
					( * ) AS limpapeh_l4 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0803', '0805' ) 
					AND statmasukrg = 'pindahan' 
				),
				(
				SELECT COUNT
					( * ) AS singgalang_l1_l2 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0601', '0602' ) 
					AND statmasukrg = 'pindahan' 
				),
				( SELECT COUNT ( * ) AS singgalang_l3 FROM ruang_iri WHERE to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0603' AND statmasukrg = 'pindahan' ),
				( SELECT COUNT ( * ) AS merapi_l1 FROM ruang_iri WHERE to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' AND idrg = '0701' AND statmasukrg = 'pindahan' ),
				(
				SELECT COUNT
					( * ) AS merapi_l2 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0702', '0705' ) 
					AND statmasukrg = 'pindahan' 
				),
				(
				SELECT COUNT
					( * ) AS merapi_l3 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0703', '0706' ) 
					AND statmasukrg = 'pindahan' 
				),
				(
				SELECT COUNT
					( * ) AS anak 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0101', '0501', '0103' ) 
					AND statmasukrg = 'pindahan' 
				),
				( SELECT COUNT ( * ) AS bedah FROM ruang_iri WHERE to_char( tglmasukrg, 'YYYY-MM' ) = '$$bulan' AND idrg = '0502' AND statmasukrg = 'pindahan' ),
				(
				SELECT COUNT
					( * ) AS kebidanan 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0503', '0107' ) 
					AND statmasukrg = 'pindahan' 
				),
				(
				SELECT COUNT
					( * ) AS icu 
				FROM
					ruang_iri 
				WHERE
					to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
					AND idrg IN ( '0404', '0704' ) 
					AND statmasukrg = 'pindahan' 
				),
				( SELECT COUNT ( * ) AS nicu FROM ruang_iri WHERE to_char( tglmasukrg, 'YYYY-MM' ) = '$$bulan' AND idrg = '0406' AND statmasukrg = 'pindahan' ) 
			FROM
				ruang_iri 
			WHERE
				to_char( tglmasukrg, 'YYYY-MM' ) = '$bulan' 
				AND idrg = '0801' 
				AND statmasukrg = 'pindahan'");
		}

		public function get_pasien_awal_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml
		FROM
			pasien_iri 
		WHERE
			pasien_iri.tgl_keluar > '$tgl' 
			AND to_char( pasien_iri.tgl_masuk :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM-DD' :: TEXT ) < '$tgl' 
			AND $where");
		}

		public function get_pasien_masuk_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml
				FROM
					ruang_iri AS A,
					pasien_iri AS b 
				WHERE
					A.no_ipd = b.no_ipd 
					AND to_char( A.tglmasukrg, 'YYYY-MM-DD' ) = to_char( b.tgl_masuk, 'YYYY-MM-DD' ) 
					AND A.$where
					AND to_char( b.tgl_masuk, 'YYYY-MM-DD' ) = '$tgl'");
		}

		public function get_pasien_masuk_pindah_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				to_char( tglmasukrg, 'YYYY-MM-DD' ) = '$tgl' 
				AND $where
				AND statmasukrg = 'pindahan' ");
		}

		public function get_pasien_keluar_pindah_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml
			FROM
				ruang_iri 
			WHERE
				to_char( tglkeluarrg, 'YYYY-MM-DD' ) = '$tgl' 
				AND $where
				AND statkeluarrg = 'pindah'");
		}

		public function get_pasien_keluar_hidup_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml
			FROM
				pasien_iri 
			WHERE
				tgl_keluar IS NOT NULL 
				AND tgl_keluar :: TEXT <> '' :: TEXT 
				AND tgl_meninggal is  null
				AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM-DD' :: TEXT ) = '$tgl' 
				AND $where");
		}

		public function get_pasien_keluar_mati_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
				( * ) AS jml 
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND to_char( pasien_iri.tgl_meninggal :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM-DD' :: TEXT ) = '$tgl' 
				AND $where");
		}

		public function get_pasien_keluar_hidup_mati_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml
			FROM
				pasien_iri 
			WHERE
					tgl_keluar IS NOT NULL 
				AND tgl_keluar :: TEXT <> '' :: TEXT 
				AND to_char( pasien_iri.tgl_keluar :: TIMESTAMP WITH TIME ZONE, 'YYYY-MM-DD' :: TEXT ) = '$tgl' 
				AND $where");
		}

		public function get_pasien_mati_krg48_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND kondisi_meninggal :: TEXT IN ( 'KURANG 48 JAM', 'MENINGGALKRG48' ) 
				AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM-DD' ) = '$tgl' 
				AND $where");
		}

		public function get_pasien_mati_lbh48_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				pasien_iri 
			WHERE
				tgl_meninggal IS NOT NULL 
				AND tgl_meninggal :: TEXT <> '' :: TEXT 
				AND kondisi_meninggal :: TEXT IN ( 'LEBIH 48 JAM', 'MENINGGALLBH48' ) 
				AND TO_CHAR( tgl_meninggal :: DATE, 'YYYY-MM-DD' ) = '$tgl' 
				AND $where ");
		}

		public function get_lama_rawat_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT SUM
			( CASE WHEN ( tglkeluarrg :: DATE - tglmasukrg ) = 0 AND tglkeluarrg IS NOT NULL THEN 1 ELSE tglkeluarrg :: DATE - tglmasukrg END ) AS jml 
		FROM
			ruang_iri 
		WHERE
			tglkeluarrg IS NOT NULL 
			AND tglkeluarrg :: TEXT <> '' :: TEXT 
			AND TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl' 
			AND $where");
		}

		public function get_hari_rawat_ruangan($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				( tglkeluarrg IS NULL or TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl'  )
				AND $where and TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM-DD' ) <= '$tgl' 
		");
		}

		public function get_hari_rawat_ruangan_vip($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				( tglkeluarrg IS NULL or TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl'  )
				AND $where and kelas='VIP' and TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM-DD' ) <= '$tgl'
			");
		}

		public function get_hari_rawat_ruangan_satu($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				( tglkeluarrg IS NULL or TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl'  )
				AND $where and kelas='I' and TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM-DD' ) <= '$tgl' 
			");
		}

		public function get_hari_rawat_ruangan_dua($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				( tglkeluarrg IS NULL or TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl'  )
				AND $where and kelas='II' and TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM-DD' ) <= '$tgl'  
			");
		}

		public function get_hari_rawat_ruangan_tiga($tgl,$where)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				ruang_iri 
			WHERE
				( tglkeluarrg IS NULL or TO_CHAR( tglkeluarrg :: DATE, 'YYYY-MM-DD' ) = '$tgl'  )
				AND $where and kelas='III' and TO_CHAR( tglmasukrg :: DATE, 'YYYY-MM-DD' ) <= '$tgl' 
			");
		}

		function get_laporan_morbiditas($date, $tampil,$layanan) {
			if($layanan == 'rj'){
				if($tampil == 'TGL') {
					return $this->db->query("SELECT 
						b.id_diagnosa,
						b.diagnosa,
						a.id_poli,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'LAMA') AS hari_0_27_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_0_27_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_0_27_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'LAMA') AS hari_28_1_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_28_1_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_28_1_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'LAMA') AS tahun_1_4_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_1_4_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_1_4_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'LAMA') AS tahun_5_14_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_5_14_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_5_14_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'LAMA') AS tahun_15_24_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_15_24_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_15_24_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'LAMA') AS tahun_25_44_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_25_44_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_25_44_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'LAMA') AS tahun_45_64_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_45_64_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_45_64_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'LAMA') AS tahun_65_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_65_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_65_baru_l
					FROM 
						daftar_ulang_irj AS a,
						diagnosa_pasien AS b,
						data_pasien AS c 
					WHERE 
						a.no_register = b.no_register 
						AND a.no_medrec = c.no_medrec 
						AND to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
						AND a.id_poli != 'BA00'
					GROUP BY 
						b.id_diagnosa, b.diagnosa,a.id_poli");
				} else {
					return $this->db->query("SELECT 
						b.id_diagnosa,
						b.diagnosa,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'LAMA') AS hari_0_27_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_0_27_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_0_27_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'LAMA') AS hari_28_1_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_28_1_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_28_1_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'LAMA') AS tahun_1_4_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_1_4_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_1_4_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'LAMA') AS tahun_5_14_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_5_14_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_5_14_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'LAMA') AS tahun_15_24_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_15_24_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_15_24_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'LAMA') AS tahun_25_44_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_25_44_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_25_44_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'LAMA') AS tahun_45_64_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_45_64_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_45_64_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'LAMA') AS tahun_65_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_65_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_65_baru_l
					FROM 
						daftar_ulang_irj AS a,
						diagnosa_pasien AS b,
						data_pasien AS c 
					WHERE 
						a.no_register = b.no_register 
						AND a.no_medrec = c.no_medrec 
						AND to_char(a.tgl_kunjungan,'YYYY-MM') = '$date'
						AND a.id_poli != 'BA00'
					GROUP BY 
						b.id_diagnosa, b.diagnosa,a.id_poli");
				}

			}else if($layanan == 'rd'){

				if($tampil == 'TGL') {
					return $this->db->query("SELECT 
						b.id_diagnosa,
						b.diagnosa,
						a.id_poli,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'LAMA') AS hari_0_27_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_0_27_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_0_27_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'LAMA') AS hari_28_1_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_28_1_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_28_1_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'LAMA') AS tahun_1_4_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_1_4_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_1_4_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'LAMA') AS tahun_5_14_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_5_14_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_5_14_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'LAMA') AS tahun_15_24_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_15_24_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_15_24_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'LAMA') AS tahun_25_44_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_25_44_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_25_44_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'LAMA') AS tahun_45_64_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_45_64_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_45_64_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'LAMA') AS tahun_65_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_65_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_65_baru_l
					FROM 
						daftar_ulang_irj AS a,
						diagnosa_pasien AS b,
						data_pasien AS c 
					WHERE 
						a.no_register = b.no_register 
						AND a.no_medrec = c.no_medrec 
						AND to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
						AND a.id_poli = 'BA00'
					GROUP BY 
						b.id_diagnosa, b.diagnosa,a.id_poli");
				} else {
					return $this->db->query("SELECT 
						b.id_diagnosa,
						b.diagnosa,
						a.id_poli,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'LAMA') AS hari_0_27_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_0_27_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(c.tgl_lahir)) BETWEEN 0 AND 27 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) = 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_0_27_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'LAMA') AS hari_28_1_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS hari_28_1_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(DAY FROM age(tgl_lahir)) >= 28 AND EXTRACT(YEAR FROM age(tgl_lahir)) = 0 AND EXTRACT(MONTH FROM age(tgl_lahir)) >= 0 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS hari_28_1_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'LAMA') AS tahun_1_4_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_1_4_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 1 AND 4 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_1_4_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'LAMA') AS tahun_5_14_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_5_14_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 5 AND 14 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_5_14_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'LAMA') AS tahun_15_24_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_15_24_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 15 AND 24 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_15_24_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'LAMA') AS tahun_25_44_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_25_44_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 25 AND 44 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_25_44_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'LAMA') AS tahun_45_64_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_45_64_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) BETWEEN 45 AND 64 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_45_64_baru_l,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'LAMA') AS tahun_65_lama,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'P') AS tahun_65_baru_p,
						COUNT(a.no_register) FILTER (WHERE EXTRACT(YEAR FROM age(c.tgl_lahir)) >= 65 AND a.jns_kunj = 'BARU' AND c.sex = 'L') AS tahun_65_baru_l
					FROM 
						daftar_ulang_irj AS a,
						diagnosa_pasien AS b,
						data_pasien AS c 
					WHERE 
						a.no_register = b.no_register 
						AND a.no_medrec = c.no_medrec 
						AND to_char(a.tgl_kunjungan,'YYYY-MM') = '$date'
						AND a.id_poli = 'BA00'
					GROUP BY 
						b.id_diagnosa, b.diagnosa,a.id_poli");
				}

			}else if($layanan == 'ri'){
				if($tampil == 'TGL') {
					return $this->db->query("SELECT
					b.id_diagnosa,
					b.diagnosa,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS hari_0_27_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS hari_0_27_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS hari_0_27_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS hari_28_1_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS hari_28_1_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS hari_28_1_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
					) AS tahun_1_4_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_1_4_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_1_4_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_5_14_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_5_14_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_5_14_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_15_24_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_15_24_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_15_24_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_25_44_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_25_44_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_25_44_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_45_64_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_45_64_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_45_64_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_65_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_65_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_65_baru_l 
					FROM
						pasien_iri AS A,
						diagnosa_iri AS b,
						data_pasien AS C 
					WHERE
						A.no_ipd = b.no_register 
						AND A.no_medrec = C.no_medrec 
						and a.tgl_keluar = '$date'
					GROUP BY
						b.id_diagnosa,
						b.diagnosa");
				} else {
					return $this->db->query("SELECT
					b.id_diagnosa,
					b.diagnosa,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS hari_0_27_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS hari_0_27_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( C.tgl_lahir ) ) BETWEEN 0 
						AND 27 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) = 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS hari_0_27_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS hari_28_1_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS hari_28_1_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( DAY FROM age( tgl_lahir ) ) >= 28 
						AND EXTRACT ( YEAR FROM age( tgl_lahir ) ) = 0 
						AND EXTRACT ( MONTH FROM age( tgl_lahir ) ) >= 0 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS hari_28_1_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
					) AS tahun_1_4_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_1_4_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 1 
						AND 4 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_1_4_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_5_14_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_5_14_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 5 
						AND 14 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_5_14_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_15_24_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_15_24_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 15 
						AND 24 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_15_24_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_25_44_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_25_44_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 25 
						AND 44 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_25_44_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_45_64_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_45_64_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) BETWEEN 45 
						AND 64 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_45_64_baru_l,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NOT NULL 
					) AS tahun_65_lama,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'P' 
					) AS tahun_65_baru_p,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						EXTRACT ( YEAR FROM age( C.tgl_lahir ) ) >= 65 
						AND A.tgl_keluar IS NOT NULL 
						AND A.tgl_meninggal IS NULL 
						AND C.sex = 'L' 
					) AS tahun_65_baru_l 
				FROM
					pasien_iri AS A,
					diagnosa_iri AS b,
					data_pasien AS C 
				WHERE
					A.no_ipd = b.no_register 
					AND A.no_medrec = C.no_medrec 
					and a.tgl_keluar like '$date%'
				GROUP BY
					b.id_diagnosa,
					b.diagnosa");
				}

			}
			
		}

		public function get_tt_perbulan($bln)
		{
			return $this->db->query("SELECT
			ruangan,
			bed,
			tgl_update,
			kelas 
			FROM
				monitoring_jumlah_bed 
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$bln'
			");
		}

		public function get_jmlh_bed_ruangan_perbulan()
		{
			return $this->db->query("SELECT 
			* 
			FROM
				monitoring_jumlah_bed 
			order by tgl_update asc
			");
		}

		function insert_monitoring_jmlh_bed($data){
			$this->db->insert('monitoring_jumlah_bed', $data);
			return true;
		}


		public function get_kelompok_ruangan()
		{
			return $this->db->query("SELECT * from kelompok_ruang 
			");
		}

		public function get_tt_vip_ruangan($kel)
		{
			return $this->db->query("SELECT count (*) as jml from 
			ruang as A,
			bed as C
			WHERE 
			A.idrg = C.idrg
				and A.id_kel = '$kel' and C.kelas = 'VIP' 
				");
		}

		public function get_tt_satu_ruangan($kel)
		{
			return $this->db->query("SELECT count (*) as jml from 
			ruang as A,
			bed as C
			WHERE 
			A.idrg = C.idrg
			and A.id_kel = '$kel' and C.kelas = 'I' 
			");
		}

		public function get_tt_dua_ruangan($kel)
		{
			return $this->db->query("SELECT count (*) as jml from 
			ruang as A,
			bed as C
			WHERE 
			A.idrg = C.idrg
				and A.id_kel = '$kel' and C.kelas = 'II' 
				");
		}

		public function get_tt_tiga_ruangan($kel)
		{
			return $this->db->query("SELECT count (*) as jml from 
			ruang as A,
			bed as C
			WHERE 
			A.idrg = C.idrg
				and A.id_kel = '$kel' and C.kelas = 'III' 
				");
		}

		public function update_monitor_bed_ruangan_vip($data,$tgl)
		{
			return $this->db->query("UPDATE monitoring_jumlah_bed 
			SET bed = '".$data['bed']."',
			tgl_update = '".$data['tgl_update']."'
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$tgl' 
				AND kelas = 'VIP' 
				AND ruangan = '".$data['ruangan']."'
			");
		}

		public function update_monitor_bed_ruangan_satu($data,$tgl)
		{
			return $this->db->query("UPDATE monitoring_jumlah_bed 
			SET bed = '".$data['bed']."',
			tgl_update = '".$data['tgl_update']."'
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$tgl' 
				AND kelas = 'I' 
				AND ruangan = '".$data['ruangan']."'
			");
		}


		public function update_monitor_bed_ruangan_dua($data,$tgl)
		{
			return $this->db->query("UPDATE monitoring_jumlah_bed 
			SET bed = '".$data['bed']."',
			tgl_update = '".$data['tgl_update']."'
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$tgl' 
				AND kelas = 'II' 
				AND ruangan = '".$data['ruangan']."'
			");
		}


		public function update_monitor_bed_ruangan_tiga($data,$tgl)
		{
			return $this->db->query("UPDATE monitoring_jumlah_bed 
			SET bed = '".$data['bed']."',
			tgl_update = '".$data['tgl_update']."'
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$tgl' 
				AND kelas = 'III' 
				AND ruangan = '".$data['ruangan']."'
			");
		}

		public function count_jmlh_bed_ruangan_perbulan($bln)
		{
			return $this->db->query("SELECT COUNT
			( * ) AS jml 
			FROM
				monitoring_jumlah_bed 
			WHERE
				TO_CHAR( tgl_update :: DATE, 'YYYY-MM' ) = '$bln' 
			");
		}

		public function get_nm_poliklinik($id_poli) {
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli = '$id_poli'");
		}

		public function get_lap_list_tindakan($date, $tampil, $poli) {
			if($tampil == 'TGL') {
				if($poli == 'semua') {
					return $this->db->query("SELECT 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'BPJS') AS bpjs,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'UMUM') AS umum,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS iks,
						(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = a.idtindakan AND kelas = 'NK' LIMIT 1) AS tarif_rs
					FROM 
						pelayanan_poli a 
						LEFT JOIN daftar_ulang_irj b ON a.no_register = b.no_register 
						LEFT JOIN poliklinik c ON c.id_poli = b.id_poli 
					WHERE 
						to_char(b.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
						AND (b.ket_pulang NOT IN ('DIRUJUK_RAWATINAP','BATAL_PELAYANAN_POLI') OR b.ket_pulang IS NULL)
					GROUP BY 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli
					ORDER BY 
						c.nm_poli");
				} else {
					return $this->db->query("SELECT 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'BPJS') AS bpjs,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'UMUM') AS umum,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS iks,
						(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = a.idtindakan AND kelas = 'NK' LIMIT 1) AS tarif_rs
					FROM 
						pelayanan_poli a 
						LEFT JOIN daftar_ulang_irj b ON a.no_register = b.no_register 
						LEFT JOIN poliklinik c ON c.id_poli = b.id_poli 
					WHERE 
						to_char(b.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
						AND b.id_poli = '$poli'
						AND (b.ket_pulang NOT IN ('DIRUJUK_RAWATINAP','BATAL_PELAYANAN_POLI') OR b.ket_pulang IS NULL)
					GROUP BY 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli
					ORDER BY 
						c.nm_poli");
				}
			} else {
				if($poli == 'semua') {
					return $this->db->query("SELECT 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'BPJS') AS bpjs,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'UMUM') AS umum,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS iks,
						(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = a.idtindakan AND kelas = 'NK' LIMIT 1) AS tarif_rs
					FROM 
						pelayanan_poli a 
						LEFT JOIN daftar_ulang_irj b ON a.no_register = b.no_register 
						LEFT JOIN poliklinik c ON c.id_poli = b.id_poli 
					WHERE 
						to_char(b.tgl_kunjungan, 'YYYY-MM') = '$date'
						AND (b.ket_pulang NOT IN ('DIRUJUK_RAWATINAP','BATAL_PELAYANAN_POLI') OR b.ket_pulang IS NULL)
					GROUP BY 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli
					ORDER BY 
						c.nm_poli");
				} else {
					return $this->db->query("SELECT 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'BPJS') AS bpjs,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'UMUM') AS umum,
						SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS iks,
						(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = a.idtindakan AND kelas = 'NK' LIMIT 1) AS tarif_rs
					FROM 
						pelayanan_poli a 
						LEFT JOIN daftar_ulang_irj b ON a.no_register = b.no_register 
						LEFT JOIN poliklinik c ON c.id_poli = b.id_poli 
					WHERE 
						to_char(b.tgl_kunjungan, 'YYYY-MM') = '$date'
						AND b.id_poli = '$poli'
						AND (b.ket_pulang NOT IN ('DIRUJUK_RAWATINAP','BATAL_PELAYANAN_POLI') OR b.ket_pulang IS NULL)
					GROUP BY 
						a.idtindakan,
						a.nmtindakan,
						c.nm_poli
					ORDER BY 
						c.nm_poli");
				}
			}
		}

		public function data_lap_serangan_stroke($data,$tampil)
		{
			// var_dump($data['tampil']);die();
			
			if($data['tampil'] == 'TGL'){
				return $this->db->query("SELECT COUNT
				( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Golden Stroke' ) AS kel_golden,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Akut' ) AS kel_akut,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Non Stroke' ) AS non_stroke,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '≤ 4,5 Jam' ) AS kel_golden_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '> 4,5 Jam sd/ ≤ 6 Jam' ) AS kel_golden_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '1 Jam' ) AS kel_golden_1jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '2 Jam' ) AS kel_golden_2jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '3 Jam' ) AS kel_golden_3jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4 Jam' ) AS kel_golden_4jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4,5 Jam' ) AS kel_golden_4koma5jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 06 Jam sd ≤ 24 Jam' ) AS kel_akut_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 24 Jam sd ≤ 03 hari' ) AS kel_akut_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 03 Hari sd ≤ 07 hari' ) AS kel_akut_3,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 07 hari' ) AS kel_akut_4 
				FROM
					assesment_medik_igd A 
				WHERE
					TO_CHAR( A.tgl_input, 'YYYY-MM-DD' ) BETWEEN '".$data['date1']."'
					AND '".$data['date2']."'				
				");
			}else if($data['tampil'] == 'BLN'){
				return $this->db->query("SELECT COUNT
				( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Golden Stroke' ) AS kel_golden,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Akut' ) AS kel_akut,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Non Stroke' ) AS non_stroke,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '≤ 4,5 Jam' ) AS kel_golden_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '> 4,5 Jam sd/ ≤ 6 Jam' ) AS kel_golden_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '1 Jam' ) AS kel_golden_1jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '2 Jam' ) AS kel_golden_2jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '3 Jam' ) AS kel_golden_3jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4 Jam' ) AS kel_golden_4jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4,5 Jam' ) AS kel_golden_4koma5jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 06 Jam sd ≤ 24 Jam' ) AS kel_akut_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 24 Jam sd ≤ 03 hari' ) AS kel_akut_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 03 Hari sd ≤ 07 hari' ) AS kel_akut_3,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 07 hari' ) AS kel_akut_4 
				FROM
					assesment_medik_igd A 
				WHERE
					TO_CHAR( A.tgl_input, 'YYYY-MM' ) = '".$data['date']."'				
				");
			}else{
				return $this->db->query("SELECT COUNT
				( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Golden Stroke' ) AS kel_golden,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Akut' ) AS kel_akut,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Non Stroke' ) AS non_stroke,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '≤ 4,5 Jam' ) AS kel_golden_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '> 4,5 Jam sd/ ≤ 6 Jam' ) AS kel_golden_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '1 Jam' ) AS kel_golden_1jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '2 Jam' ) AS kel_golden_2jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '3 Jam' ) AS kel_golden_3jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4 Jam' ) AS kel_golden_4jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4,5 Jam' ) AS kel_golden_4koma5jam,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 06 Jam sd ≤ 24 Jam' ) AS kel_akut_1,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 24 Jam sd ≤ 03 hari' ) AS kel_akut_2,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 03 Hari sd ≤ 07 hari' ) AS kel_akut_3,
				COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 07 hari' ) AS kel_akut_4 
				FROM
					assesment_medik_igd A 
				WHERE
					TO_CHAR( A.tgl_input, 'YYYY-MM-DD' ) BETWEEN '".$data['date']."'
					AND '".$data['date']."'				
				");
			}
				
		}

		public function data_lap_serangan_stroke_tgl($date1,$date2){
			return $this->db->query("SELECT COUNT
			( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Golden Stroke' ) AS kel_golden,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Akut' ) AS kel_akut,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Non Stroke' ) AS non_stroke,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '≤ 4,5 Jam' ) AS kel_golden_1,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '> 4,5 Jam sd/ ≤ 6 Jam' ) AS kel_golden_2,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '1 Jam' ) AS kel_golden_1jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '2 Jam' ) AS kel_golden_2jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '3 Jam' ) AS kel_golden_3jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4 Jam' ) AS kel_golden_4jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4,5 Jam' ) AS kel_golden_4koma5jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 06 Jam sd ≤ 24 Jam' ) AS kel_akut_1,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 24 Jam sd ≤ 03 hari' ) AS kel_akut_2,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 03 Hari sd ≤ 07 hari' ) AS kel_akut_3,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 07 hari' ) AS kel_akut_4 
			FROM
				assesment_medik_igd A 
			WHERE
				TO_CHAR( A.tgl_input, 'YYYY-MM-DD' ) BETWEEN '$date1'
				AND '$date2'				
			");
		}

		public function data_lap_serangan_stroke_bln($date){
			return $this->db->query("SELECT COUNT
			( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Golden Stroke' ) AS kel_golden,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Kel Akut' ) AS kel_akut,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'ket_stroke' ) :: TEXT = 'Non Stroke' ) AS non_stroke,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '≤ 4,5 Jam' ) AS kel_golden_1,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_golden_details' ) :: TEXT = '> 4,5 Jam sd/ ≤ 6 Jam' ) AS kel_golden_2,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '1 Jam' ) AS kel_golden_1jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '2 Jam' ) AS kel_golden_2jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '3 Jam' ) AS kel_golden_3jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4 Jam' ) AS kel_golden_4jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'golden_details_satu' ) :: TEXT = '4,5 Jam' ) AS kel_golden_4koma5jam,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 06 Jam sd ≤ 24 Jam' ) AS kel_akut_1,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 24 Jam sd ≤ 03 hari' ) AS kel_akut_2,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 03 Hari sd ≤ 07 hari' ) AS kel_akut_3,
			COUNT ( A.formjson ) FILTER ( WHERE ( A.formjson ->> 'kel_akut' ) :: TEXT = '> 07 hari' ) AS kel_akut_4 
			FROM
				assesment_medik_igd A 
			WHERE
				TO_CHAR( A.tgl_input, 'YYYY-MM' ) = '$date'			
			");
		}

		public function get_data_pasien_new()
		{
			return $this->db->query("SELECT no_cm,nama,no_kartu,no_medrec,no_identitas from data_pasien order by no_medrec desc limit 50
			");
		}

		function get_data_pasien_konsul_irj_new($week_awal, $week_akhir) {
			$data = $this->db->query("SELECT A
					.ID,
					A.no_register AS no_reg,
					A.diag_kerja,
					A.tgl_konsul,
					A.no_medrec,
					( SELECT nm_dokter FROM data_dokter WHERE CAST ( A.id_dokter_asal AS INT ) = id_dokter ) AS dokter_asal,
					( SELECT nm_dokter FROM data_dokter WHERE CAST ( A.id_dokter_akhir AS INT ) = id_dokter ) AS dokter_akhir,
					( SELECT nm_poli FROM poliklinik WHERE A.id_poli_asal = id_poli ) AS poli_asal,
					( SELECT nm_poli FROM poliklinik WHERE A.id_poli_akhir = id_poli ) AS poli_akhir,
					( SELECT no_cm FROM data_pasien WHERE A.no_medrec = no_medrec LIMIT 1 ) AS no_cm,
					( SELECT nama FROM data_pasien WHERE A.no_medrec = no_medrec LIMIT 1 ) AS nama 
				FROM
					lembar_konsul_pasien AS A 
					
				WHERE
						A.daftar is null and
					A.tgl_konsul BETWEEN '$week_awal' 
					AND '$week_akhir'
			");

			return $data->result();
		}

		function get_data_pasien_kontrol_irj_new($week_awal, $week_akhir) {
			$data = $this->db->query("SELECT A
					.*,b.no_medrec,
					( SELECT nm_poli FROM poliklinik WHERE poliklinik.id_poli = b.id_poli ),
					( SELECT nama FROM data_pasien WHERE data_pasien.no_medrec = b.no_medrec ),
					( SELECT no_cm FROM data_pasien WHERE data_pasien.no_medrec = b.no_medrec )  
				FROM
					lembar_kontrol_pasien
					A LEFT JOIN daftar_ulang_irj b ON A.no_register = b.no_register where a.tgl_input BETWEEN '$week_awal' 
					AND '$week_akhir'
			");

			return $data->result();
		}

		function get_data_keu_poli_harian_bpjs($tgl,$tgl1){
			return $this->db->query("SELECT
					(select nm_poli from poliklinik where du.id_poli=poliklinik.id_poli) as nm_poli,
					du.no_register,
					dp.no_cm,
					du.no_medrec,
					dp.nama,
					du.vtot,
					du.tgl_kunjungan,
					NULLIF ( du.vtot_lab, 0 ) AS vtot_lab,
					NULLIF ( du.vtot_rad, 0 ) AS vtot_rad,
					(
						SELECT SUM
						( vtot ) AS total_obat 
					FROM
						resep_pasien where du.no_register = resep_pasien.no_register group by no_register
					) as vtot_obat,
					du.cara_bayar,
					NULLIF ( du.vtot_ok, 0 ) AS vtot_ok,
					( SELECT nmkontraktor FROM kontraktor WHERE id_kontraktor = du.id_kontraktor ) AS nmkontraktor 
				FROM
					daftar_ulang_irj AS du
					LEFT JOIN data_pasien AS dp ON du.no_medrec = dp.no_medrec 
				WHERE
					TO_CHAR( du.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl' 
					AND TO_CHAR( du.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl1' 
					AND du.cara_bayar = 'BPJS'
				ORDER BY
					no_register,
					id_poli
			");

		}

		function get_data_pasien_jasa_rj($tgl,$tgl1,$cara_bayar){
			if($cara_bayar == 'UMUM'){
				return $this->db->query("
					SELECT
					no_register,
					tgl_masuk,
					tgl_keluar,
					no_cm,
					nama,
					cara_bayar,
					no_sep,
					dpjp,
					SUM ( qty_tindakan ) qty_tindakan,
					SUM ( harga_tindakan ) harga_tindakan,
					SUM ( qty_labor ) AS qty_labor,
					SUM ( harga_labor ) AS harga_labor,
					SUM ( qty_rad ) AS qty_rad,
					SUM ( harga_rad ) harga_rad,
					SUM ( qty_ok ) qty_ok,
					SUM ( harga_ok ) harga_ok,
					SUM ( qty_obat ) qty_obat,
					SUM ( harga_obat ) harga_obat 
					FROM
						v_laporan_billing_irj 
					WHERE
						to_char( tgl_masuk, 'YYYY-MM-DD' ) >= '$tgl' 
						AND TO_CHAR( tgl_masuk, 'YYYY-MM-DD' ) <= '$tgl1' 
						AND cara_bayar = 'UMUM'
					GROUP BY
						no_register,
						tgl_masuk,
						tgl_keluar,
						no_cm,
						nama,
						cara_bayar,
						no_sep,
						dpjp
				");
			}else if($cara_bayar == 'BPJS'){
				return $this->db->query("
					SELECT
					no_register,
					tgl_masuk,
					tgl_keluar,
					no_cm,
					nama,
					cara_bayar,
					no_sep,
					dpjp,
					SUM ( qty_tindakan ) qty_tindakan,
					SUM ( harga_tindakan ) harga_tindakan,
					SUM ( qty_labor ) AS qty_labor,
					SUM ( harga_labor ) AS harga_labor,
					SUM ( qty_rad ) AS qty_rad,
					SUM ( harga_rad ) harga_rad,
					SUM ( qty_ok ) qty_ok,
					SUM ( harga_ok ) harga_ok,
					SUM ( qty_obat ) qty_obat,
					SUM ( harga_obat ) harga_obat 
					FROM
						v_laporan_billing_irj 
					WHERE
						to_char( tgl_masuk, 'YYYY-MM-DD' ) >= '$tgl' 
						AND TO_CHAR( tgl_masuk, 'YYYY-MM-DD' ) <= '$tgl1' 
						AND cara_bayar = 'BPJS'
					GROUP BY
						no_register,
						tgl_masuk,
						tgl_keluar,
						no_cm,
						nama,
						cara_bayar,
						no_sep,
						dpjp
				");
			}else{
				return $this->db->query("
					SELECT
					no_register,
					tgl_masuk,
					tgl_keluar,
					no_cm,
					nama,
					cara_bayar,
					no_sep,
					dpjp,
					SUM ( qty_tindakan ) qty_tindakan,
					SUM ( harga_tindakan ) harga_tindakan,
					SUM ( qty_labor ) AS qty_labor,
					SUM ( harga_labor ) AS harga_labor,
					SUM ( qty_rad ) AS qty_rad,
					SUM ( harga_rad ) harga_rad,
					SUM ( qty_ok ) qty_ok,
					SUM ( harga_ok ) harga_ok,
					SUM ( qty_obat ) qty_obat,
					SUM ( harga_obat ) harga_obat 
					FROM
						v_laporan_billing_irj 
					WHERE
						to_char( tgl_masuk, 'YYYY-MM-DD' ) >= '$tgl' 
						AND TO_CHAR( tgl_masuk, 'YYYY-MM-DD' ) <= '$tgl1' 
					GROUP BY
						no_register,
						tgl_masuk,
						tgl_keluar,
						no_cm,
						nama,
						cara_bayar,
						no_sep,
						dpjp
				");
			}	
		}

		function get_data_pasien_jasa_ri($tgl,$tgl1,$cara_bayar){
			if($cara_bayar == 'UMUM'){
						return $this->db->query("
						SELECT
						no_ipd,
						tgl_masuk,
						tgl_keluar,
						no_cm,
						nama,
						carabayar,
						no_sep,
						dpjp,
						SUM ( qty_tindakan ) qty_tindakan,
						SUM ( harga_tindakan ) harga_tindakan,
						SUM ( qty_labor ) AS qty_labor,
						SUM ( harga_labor ) AS harga_labor,
						SUM ( qty_rad ) AS qty_rad,
						SUM ( harga_rad ) harga_rad,
						SUM ( qty_ok ) qty_ok,
						SUM ( harga_ok ) harga_ok,
						SUM ( qty_obat ) qty_obat,
						SUM ( harga_obat ) harga_obat 
						FROM
							v_laporan_billing_iri where left(tgl_keluar, 10) >= '$tgl' 
							AND left(tgl_keluar, 10) <= '$tgl1'
							AND carabayar = 'UMUM'
						GROUP BY
							no_ipd,
							tgl_masuk,
							tgl_keluar,
							no_cm,
							nama,
							carabayar,
							no_sep,
							dpjp
					");
			}else if($cara_bayar == 'BPJS'){
				return $this->db->query("
				SELECT
				no_ipd,
				tgl_masuk,
				tgl_keluar,
				no_cm,
				nama,
				carabayar,
				no_sep,
				dpjp,
				SUM ( qty_tindakan ) qty_tindakan,
				SUM ( harga_tindakan ) harga_tindakan,
				SUM ( qty_labor ) AS qty_labor,
				SUM ( harga_labor ) AS harga_labor,
				SUM ( qty_rad ) AS qty_rad,
				SUM ( harga_rad ) harga_rad,
				SUM ( qty_ok ) qty_ok,
				SUM ( harga_ok ) harga_ok,
				SUM ( qty_obat ) qty_obat,
				SUM ( harga_obat ) harga_obat 
				FROM
					v_laporan_billing_iri where left(tgl_keluar, 10) >= '$tgl' 
					AND left(tgl_keluar, 10) <= '$tgl1'
					AND carabayar = 'BPJS'
				GROUP BY
					no_ipd,
					tgl_masuk,
					tgl_keluar,
					no_cm,
					nama,
					carabayar,
					no_sep,
					dpjp ");
			}else{
				return $this->db->query("
				SELECT
				no_ipd,
				tgl_masuk,
				tgl_keluar,
				no_cm,
				nama,
				carabayar,
				no_sep,
				dpjp,
				SUM ( qty_tindakan ) qty_tindakan,
				SUM ( harga_tindakan ) harga_tindakan,
				SUM ( qty_labor ) AS qty_labor,
				SUM ( harga_labor ) AS harga_labor,
				SUM ( qty_rad ) AS qty_rad,
				SUM ( harga_rad ) harga_rad,
				SUM ( qty_ok ) qty_ok,
				SUM ( harga_ok ) harga_ok,
				SUM ( qty_obat ) qty_obat,
				SUM ( harga_obat ) harga_obat 
				FROM
					v_laporan_billing_iri where left(tgl_keluar, 10) >= '$tgl' 
					AND left(tgl_keluar, 10) <= '$tgl1'
				GROUP BY
					no_ipd,
					tgl_masuk,
					tgl_keluar,
					no_cm,
					nama,
					carabayar,
					no_sep,
					dpjp ");
			}
			
		}

		function get_data_dokter_dpjp() {
			return $this->db->query("SELECT id_dokter,nm_dokter from data_dokter where klp_pelaksana = 'DOKTER' order by nm_dokter asc
			");
		}

		function get_data_qty_tind_jasa_rajal($tgl1,$tgl2,$id_dokter) {
			if($id_dokter == 'SEMUA'){
					return $this->db->query("
					SELECT A
						.no_register,
						A.tgl_kunjungan,
						A.cara_bayar,
						A.no_sep,
						A.id_dokter,
						(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter) as nmdokter,
						(select nm_poli from poliklinik where poliklinik.id_poli = a.id_poli) as nmpoli,
						C.nama,
						C.no_cm,
						COUNT ( b.no_register ) AS qty_tindakan 
					FROM
						daftar_ulang_irj A,
						pelayanan_poli b,
						data_pasien C 
					WHERE
						A.no_register = b.no_register 
						AND A.no_medrec = C.no_medrec 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
						AND TO_CHAR( A.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2' 
					GROUP BY
						A.no_register,
						C.nama,
						C.no_cm
			");
			}else{
					return $this->db->query("
					SELECT A
						.no_register,
						A.tgl_kunjungan,
						A.cara_bayar,
						A.no_sep,
						A.id_dokter,
						(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter) as nmdokter,
						(select nm_poli from poliklinik where poliklinik.id_poli = a.id_poli) as nmpoli,
						C.nama,
						C.no_cm,
						COUNT ( b.no_register ) AS qty_tindakan 
					FROM
						daftar_ulang_irj A,
						pelayanan_poli b,
						data_pasien C 
					WHERE
						A.no_register = b.no_register 
						AND A.no_medrec = C.no_medrec 
						AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
						AND TO_CHAR( A.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2'
						AND a.id_dokter = '$id_dokter'
					GROUP BY
						A.no_register,
						C.nama,
						C.no_cm
				");
			}
			
		}

		function geta_data_detail_tind_jasa($tgl1,$tgl2){
			return $this->db->query("
			SELECT no_register,
				tgl_kunjungan,
				idtindakan,
				nmtindakan,
				biaya_tindakan,
				(select name from hmis_users where hmis_users.userid = pelayanan_poli.userid) as pelaksana
			FROM
				pelayanan_poli 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
				AND TO_CHAR( tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2' 

		");
		}


		function get_data_qty_tind_jasa_ranap($tgl1,$tgl2,$id_dokter) {
			if($id_dokter == 'SEMUA'){
					return $this->db->query("
					SELECT
						a.no_ipd,
						a.tgl_masuk,
						a.tgl_keluar,
						a.carabayar,
						a.no_sep,
						a.id_dokter,
						( SELECT nm_dokter FROM data_dokter WHERE data_dokter.id_dokter = A.id_dokter ) AS nmdokter, 
						C.nama,
						C.no_cm,
						COUNT ( b.no_ipd ) AS qty_tindakan
					FROM
						pasien_iri a,
						data_pasien c,
						pelayanan_iri b
					WHERE
						A.no_ipd = b.no_ipd
						AND A.no_medrec = C.no_medrec
						AND LEFT ( a.tgl_keluar, 10 ) >= '$tgl1' 
						AND LEFT ( a.tgl_keluar, 10 ) <= '$tgl2'
						GROUP BY
						A.no_ipd,
						C.nama,
						C.no_cm,
						a.tgl_masuk,
						a.tgl_keluar,
						a.carabayar,
						a.no_sep,
						a.id_dokter
			");
			}else{
					return $this->db->query("
					SELECT
						a.no_ipd,
						a.tgl_masuk,
						a.tgl_keluar,
						a.carabayar,
						a.no_sep,
						a.id_dokter,
						( SELECT nm_dokter FROM data_dokter WHERE data_dokter.id_dokter = A.id_dokter ) AS nmdokter, 
						C.nama,
						C.no_cm,
						COUNT ( b.no_ipd ) AS qty_tindakan
					FROM
						pasien_iri a,
						data_pasien c,
						pelayanan_iri b
					WHERE
						A.no_ipd = b.no_ipd
						AND A.no_medrec = C.no_medrec
						AND LEFT ( a.tgl_keluar, 10 ) >= '$tgl1' 
						AND LEFT ( a.tgl_keluar, 10 ) <= '$tgl2'
						AND a.id_dokter = '$id_dokter'
						GROUP BY
						A.no_ipd,
						C.nama,
						C.no_cm,
						a.tgl_masuk,
						a.tgl_keluar,
						a.carabayar,
						a.no_sep,
						a.id_dokter
				");
			}
			
		}

		function geta_data_detail_tind_jasa_ranap($ipd){
			return $this->db->query("
			SELECT A
					.no_ipd,
					A.tgl_layanan,
					A.id_tindakan,
					A.vtot,
					A.qtyyanri,
					( SELECT NAME FROM hmis_users WHERE hmis_users.userid = A.idoprtr :: INT ) AS pelaksana,
					b.nmtindakan,
					( SELECT nmruang FROM ruang WHERE ruang.idrg = a.idrg ) AS ruang
				FROM
					pelayanan_iri A,
					jenis_tindakan_new b 
				WHERE
					A.id_tindakan = b.idtindakan 
					AND a.no_ipd = '$ipd' order by tgl_layanan asc
		");
		}

		function geta_data_detail_tind_jasa_ranap_new($tgl1,$tgl2,$id_dokter,$cara_bayar,$id_ruang){
			if($cara_bayar != 'SEMUA'){
				if($id_dokter != 'SEMUA' and $id_ruang != 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							id_dokter = '$id_dokter' AND carabayar = '$cara_bayar' and kelompok = '$id_ruang' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else if($id_dokter == 'SEMUA' && $id_ruang != 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							carabayar = '$cara_bayar' and kelompok = '$id_ruang' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else if($id_dokter != 'SEMUA' && $id_ruang == 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							carabayar = '$cara_bayar' and id_dokter = '$id_dokter' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else{
					return $this->db->query("
											SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							carabayar = '$cara_bayar' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}

			}else{
				if($id_dokter != 'SEMUA' and $id_ruang != 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							id_dokter = '$id_dokter' and kelompok = '$id_ruang' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else if($id_dokter == 'SEMUA' && $id_ruang != 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							carabayar = '$cara_bayar' and kelompok = '$id_ruang' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else if($id_dokter != 'SEMUA' && $id_ruang == 'SEMUA'){
					return $this->db->query("
						SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							id_dokter = '$id_dokter' and
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}else{
					return $this->db->query("
											SELECT
								no_ipd,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								carabayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_ri 
							WHERE
							
								to_char ( tgl_keluar, 'YYYY-MM-DD') >= '$tgl1' 
								AND to_char ( tgl_keluar, 'YYYY-MM-DD') <= '$tgl2' order by tgl_keluar desc
									");
				}
			}
			
			
		}

		function get_data_qty_tind_jasa_rajal_new($tgl1,$tgl2,$id_dokter,$id_poli,$cara_bayar) {
			if($cara_bayar != 'SEMUA'){
					if($id_dokter != 'SEMUA' && $id_poli != 'SEMUA'){
						return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_dokter = '$id_dokter' and id_poli = '$id_poli'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								AND cara_bayar = '$cara_bayar'
								ORDER BY
									tgl_keluar DESC
							");
					}else if($id_dokter == 'SEMUA' && $id_poli != 'SEMUA'){
							return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_poli = '$id_poli'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								AND cara_bayar = '$cara_bayar'
								ORDER BY
									tgl_keluar DESC
							");
					}else if($id_dokter != 'SEMUA' && $id_poli == 'SEMUA'){
							return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_dokter = '$id_dokter'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								AND cara_bayar = '$cara_bayar'
								ORDER BY
									tgl_keluar DESC
							");
					}else{

						return $this->db->query("
							SELECT
								no_register,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								cara_bayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan::int,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_rj
							WHERE
							to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
							AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
							AND cara_bayar = '$cara_bayar'
							ORDER BY
								tgl_keluar DESC
						");
					}
			}else{
					if($id_dokter != 'SEMUA' && $id_poli != 'SEMUA'){
						return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_dokter = '$id_dokter' and id_poli = '$id_poli'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								ORDER BY
									tgl_keluar DESC
							");
					}else if($id_dokter == 'SEMUA' && $id_poli != 'SEMUA'){
							return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_poli = '$id_poli'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								ORDER BY
									tgl_keluar DESC
							");
					}else if($id_dokter != 'SEMUA' && $id_poli == 'SEMUA'){
							return $this->db->query("
								SELECT
									no_register,
									nama,
									tgl_masuk,
									tgl_keluar,
									no_cm,
									cara_bayar,
									dpjp,
									jenis,
									nama_tindakan,
									qty_tindakan,
									harga_tindakan::int,
									ruang,
									no_sep,
									pelaksana
								FROM
									v_jasa_medik_rj
								WHERE
								id_dokter = '$id_dokter'
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
								AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
								ORDER BY
									tgl_keluar DESC
							");
					}else{

						return $this->db->query("
							SELECT
								no_register,
								nama,
								tgl_masuk,
								tgl_keluar,
								no_cm,
								cara_bayar,
								dpjp,
								jenis,
								nama_tindakan,
								qty_tindakan,
								harga_tindakan::int,
								ruang,
								no_sep,
								pelaksana
							FROM
								v_jasa_medik_rj
							WHERE
							to_char( tgl_keluar, 'YYYY-MM-DD' ) >= '$tgl1' 
							AND to_char( tgl_keluar, 'YYYY-MM-DD' ) <= '$tgl2' 
							ORDER BY
								tgl_keluar DESC
						");
					}
			}	
			
		}

		function get_data_obat() {
			return $this->db->query("SELECT
					id_obat,
					nm_obat 
				FROM
					master_obat 
				WHERE
				deleted = 0
				ORDER BY
					nm_obat ASC
							");
		}

		function get_data_obat_peritem($tgl1,$tgl2,$id_obat) {
			return $this->db->query("SELECT A
					.item_obat,
					A.tgl_kunjungan,
					A.qty,
					A.no_register,
					b.nama,
					b.no_cm,
					(select nm_dokter from data_dokter where c.id_dokter = data_dokter.id_dokter) as dokter,
					(select nm_poli from poliklinik where c.id_poli = poliklinik.id_poli) as poli
				FROM
					resep_pasien A,
					data_pasien b,
					daftar_ulang_irj c
				WHERE
					A.no_medrec = b.no_medrec and
					a.no_register = c.no_register 
					AND LEFT ( A.no_register, 2 ) = 'RJ' 
					AND A.item_obat = '$id_obat' 
					AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
					AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2'
			");

		}

		function get_data_obat_peritem_ranap($tgl1,$tgl2,$id_obat) {
			return $this->db->query("SELECT A
					.item_obat,
					A.tgl_kunjungan,
					A.qty,
					A.no_register,
					b.nama,
					b.no_cm 
				FROM
					resep_pasien A,
					data_pasien b 
				WHERE
					A.no_medrec = b.no_medrec 
					AND LEFT ( A.no_register, 2 ) = 'RI'
					AND a.item_obat = '$id_obat'
					AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
					AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2' 
			");

		}

		function get_data_jam_farmasi($tgl1,$tgl2) {
			return $this->db->query("SELECT 
			C.tgl_kunjungan,
			C.no_register,
			b.nama,
			b.no_cm,
			(SELECT nm_dokter FROM data_dokter WHERE C.id_dokter = data_dokter.id_dokter) AS dokter,
			(SELECT nm_poli FROM poliklinik WHERE C.id_poli = poliklinik.id_poli) AS poli,
			b.alamat,
			C.waktu_resep_farmasi,
			C.waktu_selesai_farmasi,
			C.cara_bayar,
			C.no_sep,
			b.no_kartu
		FROM 
			daftar_ulang_irj C
			INNER JOIN (
				SELECT DISTINCT ON (no_register) * 
				FROM resep_pasien 
				ORDER BY no_register, tgl_resep 
			) resep ON C.no_register = resep.no_register
			JOIN data_pasien b ON C.no_medrec = b.no_medrec
		WHERE 
			LEFT(C.no_register, 2) = 'RJ' 
			AND to_char(C.tgl_kunjungan, 'YYYY-MM-DD') >= '$tgl1'
			AND to_char(C.tgl_kunjungan, 'YYYY-MM-DD') <= '$tgl2';
			");

		}

		function get_data_poli() {
			return $this->db->query("SELECT id_poli,nm_poli from poliklinik  order by nm_poli asc
			");
		}

		function get_data_ruangan() {
			return $this->db->query("select DISTINCT kelompok from ruang");
			}

			function get_data_resep_farmasi($tgl1,$tgl2) {
				return $this->db->query("SELECT
					no_register,
					nama_obat,
					qty,
					biaya_obat,
					vtot 
				FROM
					resep_pasien 
				WHERE
					to_char( tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl1' 
					AND to_char( tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2'
				");
	
			}
}
?>
