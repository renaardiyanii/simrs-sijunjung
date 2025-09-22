<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class rdmlaporan extends CI_Model{
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
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from irddaftar_ulang where Left(tgl_kunjungan,10)>='$tgl_awal' and Left(tgl_kunjungan,10)<='$tgl_akhir' GROUP BY Left(tgl_kunjungan,10)");
		}
		function get_data_irj_masuk($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from daftar_ulang_irj where Left(tgl_kunjungan,10)>='$tgl_awal' and Left(tgl_kunjungan,10)<='$tgl_akhir' GROUP BY Left(tgl_kunjungan,10)");
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
			
			return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, 
			NULLIF(du.ket_pulang,'-') as ket_pulang, 
			(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' GROUP BY no_register,diagnosa LIMIT 1) AS diagnosa,			 
			(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa) AS nm_diagnosa,
			(SELECT kon.nmkontraktor FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor,			
			(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter) as nm_dokter,
			dp.tgl_lahir,dp.sex,dp.kotakabupaten,du.diag_baru,du.jns_kunj,du.id_poli,du.waktu_masuk_poli ,du.diagnosa as id_diagnosa,du.tgl_kunjungan,du.waktu_masuk_dokter,du.waktu_pulang,
			aki.formjson 
			FROM daftar_ulang_irj AS du 
			LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
			left join assesment_keperawatan_ird as aki on du.no_register = aki.no_register
			WHERE to_char(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' AND
			du.id_poli='$id_poli' and (du.ket_pulang !='BATAL_PELAYANAN_POLI' or du.ket_pulang is null)
			$textcb $textbb ORDER BY du.no_register");
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
			
			return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, 
			NULLIF(du.ket_pulang,'-') as ket_pulang, 
			(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' GROUP BY no_register,diagnosa LIMIT 1) AS diagnosa,			 
			(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa) AS nm_diagnosa,
			(SELECT kon.nmkontraktor FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor,			
			(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter) as nm_dokter,
			dp.tgl_lahir,dp.sex,dp.kotakabupaten,du.diag_baru,du.jns_kunj,du.id_poli,du.waktu_masuk_poli ,du.diagnosa as id_diagnosa,du.tgl_kunjungan,du.waktu_masuk_dokter,du.waktu_pulang,
			aki.formjson
			FROM daftar_ulang_irj AS du 
			LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
			LEFT JOIN data_dokter AS dd ON du.id_dokter=dd.id_dokter 
			left join assesment_keperawatan_ird as aki on du.no_register = aki.no_register
			WHERE to_char(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' AND
			du.id_dokter = '$id_dokter' AND
			du.id_poli='$id_poli' and (du.ket_pulang !='BATAL_PELAYANAN_POLI' or du.ket_pulang is null)
			$textcb $textbb ORDER BY du.no_register");
		}
		
		function get_data_kunj_bulanan($bulan, $id_poli){

			return $this->db->query("SELECT 
			TO_CHAR(tgl_kunjungan,'YYYY-MM-DD') AS tgl_kunj,
			count(*) AS jumlah_kunj, 
			SUM(CASE WHEN jns_kunj = 'BARU' THEN 1 ELSE NULL END) as pasien_baru, 
			SUM(CASE WHEN jns_kunj = 'LAMA' THEN 1 ELSE NULL END) as pasien_lama,  
			SUM(CASE WHEN ket_pulang != 'BATAL_PELAYANAN_POLI' THEN 1 ELSE 0 END) AS jumlah_tidak_batal,
			SUM(CASE WHEN ket_pulang = 'BATAL_PELAYANAN_POLI' THEN 1 ELSE 0 END) AS jumlah_batal
			FROM daftar_ulang_irj WHERE 
			TO_CHAR(tgl_kunjungan,'YYYY-MM')='$bulan' 
			AND id_poli='$id_poli' GROUP BY TO_CHAR(tgl_kunjungan,'YYYY-MM-DD')");
		}
		
		function get_data_kunj_tahunan($tahun, $id_poli){
			return $this->db->query("SELECT TO_CHAR(tgl_kunjungan,'MM') AS bulan_kunj, count(*) AS jumlah_kunj 
										FROM daftar_ulang_irj 
										WHERE TO_CHAR(tgl_kunjungan,'YYYY')='$tahun' AND id_poli='$id_poli
										GROUP BY TO_CHAR(tgl_kunjungan,'MM')");
		}
		
		function get_data_kunj_poli_harian($tgl, $cara_bayar,$bayar_bpjs){
			$textbb='';
			if($cara_bayar!='SEMUA'){
				IF($cara_bayar=='KERJASAMA'){
					$textcb="and du.cara_bayar='KERJASAMA'";
				}else{
					$textcb="and du.cara_bayar='$cara_bayar'";
					if($bayar_bpjs!='SEMUA' && $cara_bayar=='BPJS'){
						$textbb="and du.id_kontraktor='".$bayar_bpjs."'";
					}
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
						(SELECT icd1.nm_diagnosa FROM icd1 WHERE icd1.id_icd = du.diagnosa) AS nm_diagnosa,
						du.id_poli, du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, 
						NULLIF(dp.no_nrp,'-') as no_nrp, NULLIF(du.ket_pulang,'-') as ket_pulang, 
						(SELECT hub.hub_name FROM tni_hubungan AS hub WHERE hub.hub_id=dp.nrp_sbg) AS nrp_sbg, 
						(SELECT diag.diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register 
						AND diag.klasifikasi_diagnos='utama' LIMIT 1) AS diagnosa, (SELECT kon.nmkontraktor 
						FROM kontraktor AS kon WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor,
						(SELECT nm_dokter FROM data_dokter Where data_dokter.id_dokter = du.id_dokter) as nm_dokter,
						dp.tgl_lahir,dp.sex,dp.kotakabupaten,du.diag_baru,du.jns_kunj,du.id_poli,du.waktu_masuk_poli ,du.waktu_masuk_dokter,du.waktu_pulang,du.tgl_kunjungan,
						(SELECT id_diagnosa FROM diagnosa_pasien AS diag WHERE diag.no_register=du.no_register AND diag.klasifikasi_diagnos='utama' LIMIT 1) as id_diagnosa,
						aki.formjson
							FROM daftar_ulang_irj AS du 
							LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec 
							left join assesment_keperawatan_ird as aki on du.no_register = aki.no_register
							WHERE du.id_poli = 'BA00' 
							and (du.ket_pulang !='BATAL_PELAYANAN_POLI' or du.ket_pulang is null)
							and TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' $textcb $textbb ORDER BY no_register, id_poli");
		}
		
		function get_data_kunj_poli_bulanan($bulan){
			return $this->db->query("SELECT id_poli, TO_CHAR ( tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl_kunj, count(no_register) AS jumlah_kunj, 
								COUNT(CASE WHEN jns_kunj = 'BARU' THEN 1 ELSE NULL END) as pasien_baru, 
								COUNT(CASE WHEN jns_kunj = 'LAMA' THEN 1 ELSE NULL END) as pasien_lama, 
								COUNT(CASE WHEN cara_bayar = 'UMUM' THEN 1 ELSE NULL END) as umum, 
								COUNT(CASE WHEN cara_bayar = 'BPJS' THEN 1 ELSE NULL END) as bpjs, 
								COUNT(CASE WHEN cara_bayar = 'KERJASAMA' THEN 1 ELSE NULL END) as kerjasama, 
								COUNT(CASE WHEN ket_pulang = 'BATAL_PELAYANAN_POLI' THEN  1 ELSE NULL END) AS jumlah_batal  
										FROM daftar_ulang_irj 
										WHERE du.id_poli = 'BA00' 
										and TO_CHAR(tgl_kunjungan,'YYYY-MM') = '$bulan'
										and (ket_pulang!='BATAL_PELAYANAN_POLI' or ket_pulang is null)
										GROUP BY TO_CHAR ( tgl_kunjungan, 'YYYY-MM-DD' ),id_poli");
 
		}
		
		function get_data_kunj_poli_tahunan($tahun){
			return $this->db->query("SELECT id_poli, TO_CHAR(tgl_kunjungan,'MM') AS bulan_kunj, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE du.id_poli = 'BA00' 
										and TO_CHAR(tgl_kunjungan,'YYYY')='$tahun'
										and (ket_pulang!='BATAL_PELAYANAN_POLI' or ket_pulang is null)
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

				return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, 
				CASE WHEN CAST(du.status AS INTEGER)=1 THEN 'PULANG' ELSE 'DIRAWAT' END as status, 
				du.biayadaftar, du.vtot, du.cara_bayar, NULLIF(du.tunai,'0') as tunai, NULLIF(du.diskon,'0') as diskon, 
				NULLIF(du.vtot_lab,0) as vtot_lab, NULLIF(du.vtot_rad,0) as vtot_rad, NULLIF(du.vtot_ok,0) as vtot_ok, 
				NULLIF(du.vtot_pa,0) as vtot_pa, NULLIF(du.vtot_obat,0) as vtot_obat, (SELECT nmkontraktor from kontraktor 
									where id_kontraktor=du.id_kontraktor)as nmkontraktor
													FROM daftar_ulang_irj AS du
													LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
													WHERE TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')>= '$tgl' 
													AND TO_CHAR(du.tgl_kunjungan,'YYYY-MM-DD')<= '$tgl1'
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

		function get_kunj_pasien_detail($tgl_awal,$tgl_akhir){
			$data=$this->db->query("select * FROM  lap_kunj_pasien_irj_detail where tanggal between '$tgl_awal' and '$tgl_akhir'");
			return $data->result_array();
		}
		
		function get_nama_poli_by_id($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function get_dokter_poli($id_poli){

			
				return $this->db->query("SELECT dd.*  
					FROM
					    data_dokter AS dd, dokter_poli as dp
					WHERE
					    dd.id_dokter =  dp.id_dokter and
					    dp.id_poli = '$id_poli'
					        AND dd.deleted != '1'
					ORDER BY dd.nm_dokter");
								
		 				
		}

		
		function get_diagnosa($date,$lap_per){
			if($date == '' || $lap_per == ''){
				return $this->db->query("SELECT a.id_diagnosa,b.nm_diagnosa,
					SUM( CASE WHEN c.sex = 'L' and d.jns_kunj = 'BARU' THEN 1 END) as l,
					SUM(CASE WHEN c.sex = 'P' and d.jns_kunj = 'BARU' THEN 1 END) as p,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) as baru,
					sum (case when d.jns_kunj = 'LAMA' then 1 end) as lama,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) + sum (case when d.jns_kunj = 'LAMA' then 1 end) as jumlah
					from diagnosa_pasien a,
					icd1 b,
					data_pasien c,
					daftar_ulang_irj d
					where a.id_diagnosa = b.id_icd
					and a.no_register = d.no_register
					and c.no_medrec = d.no_medrec
					and b.deleted = '0'
					GROUP BY a.id_diagnosa,b.nm_diagnosa
				");
			}elseif($lap_per == 'TGL') {
				return $this->db->query("SELECT a.id_diagnosa,b.nm_diagnosa,
					SUM( CASE WHEN c.sex = 'L' and d.jns_kunj = 'BARU' THEN 1 END) as l,
					SUM(CASE WHEN c.sex = 'P' and d.jns_kunj = 'BARU' THEN 1 END) as p,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) as baru,
					sum (case when d.jns_kunj = 'LAMA' then 1 end) as lama,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) + sum (case when d.jns_kunj = 'LAMA' then 1 end) as jumlah
					from diagnosa_pasien a,
					icd1 b,
					data_pasien c,
					daftar_ulang_irj d
					where a.id_diagnosa = b.id_icd
					and a.no_register = d.no_register
					and c.no_medrec = d.no_medrec
					and b.deleted = '0'
					and to_char(d.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					GROUP BY a.id_diagnosa,b.nm_diagnosa
				");
			}elseif($lap_per == 'BLN') {
				return $this->db->query("SELECT a.id_diagnosa,b.nm_diagnosa,
					SUM( CASE WHEN c.sex = 'L' and d.jns_kunj = 'BARU' THEN 1 END) as l,
					SUM(CASE WHEN c.sex = 'P' and d.jns_kunj = 'BARU' THEN 1 END) as p,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) as baru,
					sum (case when d.jns_kunj = 'LAMA' then 1 end) as lama,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) + sum (case when d.jns_kunj = 'LAMA' then 1 end) as jumlah
					from diagnosa_pasien a,
					icd1 b,
					data_pasien c,
					daftar_ulang_irj d
					where a.id_diagnosa = b.id_icd
					and a.no_register = d.no_register
					and c.no_medrec = d.no_medrec
					and b.deleted = '0'
					and to_char(d.tgl_kunjungan,'YYYY-MM') = '$date'
					GROUP BY a.id_diagnosa,b.nm_diagnosa
				");
			}elseif($lap_per == 'THN') {
				return $this->db->query("SELECT a.id_diagnosa,b.nm_diagnosa,
					SUM( CASE WHEN c.sex = 'L' and d.jns_kunj = 'BARU' THEN 1 END) as l,
					SUM(CASE WHEN c.sex = 'P' and d.jns_kunj = 'BARU' THEN 1 END) as p,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) as baru,
					sum (case when d.jns_kunj = 'LAMA' then 1 end) as lama,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) + sum (case when d.jns_kunj = 'LAMA' then 1 end) as jumlah
					from diagnosa_pasien a,
					icd1 b,
					data_pasien c,
					daftar_ulang_irj d
					where a.id_diagnosa = b.id_icd
					and a.no_register = d.no_register
					and c.no_medrec = d.no_medrec
					and b.deleted = '0'
					and to_char(d.tgl_kunjungan,'YYYY') = '$date'
					GROUP BY a.id_diagnosa,b.nm_diagnosa
				");
			}else{
				return $this->db->query("SELECT a.id_diagnosa,b.nm_diagnosa,
					SUM( CASE WHEN c.sex = 'L' and d.jns_kunj = 'BARU' THEN 1 END) as l,
					SUM(CASE WHEN c.sex = 'P' and d.jns_kunj = 'BARU' THEN 1 END) as p,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) as baru,
					sum (case when d.jns_kunj = 'LAMA' then 1 end) as lama,
					sum(CASE WHEN d.jns_kunj = 'BARU' THEN 1 END) + sum (case when d.jns_kunj = 'LAMA' then 1 end) as jumlah
					from diagnosa_pasien a,
					icd1 b,
					data_pasien c,
					daftar_ulang_irj d
					where a.id_diagnosa = b.id_icd
					and a.no_register = d.no_register
					and c.no_medrec = d.no_medrec
					and b.deleted = '0'
					GROUP BY a.id_diagnosa,b.nm_diagnosa
				");
			}
			
															 
		}

		public function get_data_pemeriksaan_rad_ird($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_lab_ird($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_em_ird($no_register)
		{
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik where no_register = '$no_register' ");
		}

		public function get_data_pemeriksaan_tindakan_ird($no_register)
		{
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register = '$no_register' ");
		}

		function get_kunj_pasien_detail_igd($tampil, $date) {
			if($tampil == 'TGL') {
				return $this->db->query("SELECT 
					A.*,
					( SELECT diagnosa FROM diagnosa_pasien WHERE diagnosa_pasien.no_register = A.no_register AND diagnosa_pasien.klasifikasi_diagnos = 'utama' ) AS nama_diagnosa,
					( SELECT id_diagnosa FROM diagnosa_pasien WHERE diagnosa_pasien.no_register = A.no_register AND diagnosa_pasien.klasifikasi_diagnos = 'utama' ) AS id_diagnosa,
					(select wkt_masuk_rg from pasien_iri where pasien_iri.noregasal = A.no_register) as waktu_masuk_ri,
					( SELECT formjson -> 'ket_stroke' AS ket_stroke FROM assesment_medik_igd b WHERE b.no_register = A.no_register ),
					( SELECT formjson -> 'kel_golden_details' AS kel_golden_details FROM assesment_medik_igd c WHERE c.no_register = A.no_register ),
					( SELECT formjson -> 'golden_details_satu' AS golden_details_satu FROM assesment_medik_igd d WHERE d.no_register = A.no_register ),
					( SELECT formjson -> 'kel_akut' AS kel_akut FROM assesment_medik_igd e WHERE e.no_register = A.no_register )
				FROM
					lap_kunj_pasien_irj_detail AS A 
				WHERE
					tanggal = '$date'
					AND id_poli = 'BA00'");
			} else {
				return $this->db->query("SELECT 
					A.*,
					( SELECT diagnosa FROM diagnosa_pasien WHERE diagnosa_pasien.no_register = A.no_register AND diagnosa_pasien.klasifikasi_diagnos = 'utama' ) AS nama_diagnosa,
					( SELECT id_diagnosa FROM diagnosa_pasien WHERE diagnosa_pasien.no_register = A.no_register AND diagnosa_pasien.klasifikasi_diagnos = 'utama' ) AS id_diagnosa,
					(select wkt_masuk_rg from pasien_iri where pasien_iri.noregasal = A.no_register) as waktu_masuk_ri,
					( SELECT formjson -> 'ket_stroke' AS ket_stroke FROM assesment_medik_igd b WHERE b.no_register = A.no_register ),
					( SELECT formjson -> 'kel_golden_details' AS kel_golden_details FROM assesment_medik_igd c WHERE c.no_register = A.no_register ),
					( SELECT formjson -> 'golden_details_satu' AS golden_details_satu FROM assesment_medik_igd d WHERE d.no_register = A.no_register ),
					( SELECT formjson -> 'kel_akut' AS kel_akut FROM assesment_medik_igd e WHERE e.no_register = A.no_register )
				FROM
					lap_kunj_pasien_irj_detail AS A 
				WHERE
					tanggal LIKE '$date%'
					AND id_poli = 'BA00'");
			}
		}

		function get_kunj_pasien_detail_igd_tind($tampil, $date) {
			if($tampil == 'TGL') {
				return $this->db->query("SELECT
				no_register,
				idtindakan,
				nmtindakan 
			FROM
				pelayanan_poli 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' and id_poli = 'BA00'");
			} else {
				return $this->db->query("SELECT
				no_register,
				idtindakan,
				nmtindakan 
			FROM
				pelayanan_poli 
			WHERE
				to_char( tgl_kunjungan, 'YYYY-MM-DD' ) LIKE '$date%' and id_poli = 'BA00'");
			}
		}

	}
?>
