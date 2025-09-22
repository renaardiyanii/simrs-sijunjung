<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Medmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_poliklinik(){
			return $this->db->query("SELECT id_poli, nm_poli FROM poliklinik");
		}
		function get_lokasi(){
			return $this->db->query("SELECT lokasi FROM ruang where lokasi!='Kamar Operasi' group by lokasi ");
		}
		function get_nm_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli = '$id_poli'");
		}

		function get_ruangan(){
			return $this->db->query("SELECT * FROM ruang where lokasi!='Kamar Operasi'");
		}

		function get_ruangan_by_lokasi($lokasi){
			return $this->db->query("SELECT * FROM ruang where lokasi='$lokasi' and lokasi!='Kamar Operasi'");
		}

		function get_data_diag_rd($awal, $akhir){
			return $this->db->query("SELECT
									id_diagnosa ,
									diagnosa ,
									SUM(L) as L ,
									SUM(P) as P ,
									SUM(P+L) as tot ,
									SUM(baru) as baru ,
									SUM(usia1) as usia1 ,
									SUM(usia2) as usia2 ,
									SUM(usia3) as usia3 ,
									SUM(usia4) as usia4 ,
									SUM(usia5) as usia5 ,
									SUM(usia6) as usia6 ,
									SUM(usia7) as usia7 ,
									SUM(usia8) as usia8 ,
									SUM(usia9) as usia9 ,
									SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7+usia8+usia9) as tot_usia ,
									SUM(stat1) as stat1 ,
									SUM(stat2) as stat2 ,
									SUM(stat3) as stat3 ,
									SUM(stat4) as stat4 ,
									SUM(stat1+stat2+stat3+stat4) as tot_stat 
								FROM
									diagnosa_irj_v2
								WHERE
									(
										LEFT(tgl , 10) BETWEEN '$awal'
										AND '$akhir'
									)
								AND id_poli = 'BA00'
								GROUP BY
									id_diagnosa
								ORDER BY
									tot_stat desc");
		}

        function get_data_diag_rj_old($awal, $akhir, $poli){
            return $this->db->query("SELECT
									id_diagnosa ,
									diagnosa ,
									SUM(L) as L ,
									SUM(P) as P ,
									SUM(P+L) as tot ,
									SUM(usia1) as usia1 ,
									SUM(usia2) as usia2 ,
									SUM(usia3) as usia3 ,
									SUM(usia4) as usia4 ,
									SUM(usia5) as usia5 ,
									SUM(usia6) as usia6 ,
									SUM(usia7) as usia7 ,
									SUM(usia8) as usia8 ,
									SUM(usia9) as usia9 ,
									SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7+usia8+usia9) as tot_usia ,
									SUM(stat1) as stat1 ,
									SUM(stat2) as stat2 ,
									SUM(stat3) as stat3 ,
									SUM(stat4) as stat4 ,
									SUM(stat5) as stat5 ,
									SUM(stat6) as stat6 ,
									SUM(stat7) as stat7  ,
									SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
								FROM
									diagnosa_irj_v2
								WHERE
									(
										LEFT(tgl , 10) BETWEEN '$awal'
										AND '$akhir'
									)
								AND id_poli LIKE '%$poli%'
								GROUP BY
									id_diagnosa
								ORDER BY
									tot_stat desc");
        }

        function get_data_diag_rj($awal, $akhir, $poli){
            return $this->db->query("SELECT
										id_diagnosa,
										diagnosa,
										SUM(l) as L,
										SUM(p) as P,
										SUM(l+p) as tot,
										SUM(usia1) as usia1,
										SUM(usia2) as usia2,
										SUM(usia3) as usia3,
										SUM(usia4) as usia4,
										SUM(usia5) as usia5,
										SUM(usia6) as usia6,
										SUM(usia7) as usia7,
										SUM(usia8) as usia8,
										SUM(usia9) as usia9,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7+usia8+usia9) as tot_usia,
										SUM(umum) as umum,
										SUM(tni_al_m) as tni_al_m,
										SUM(tni_al_s) as tni_al_s,
										SUM(tni_al_k) as tni_al_k,
										SUM(tni_n_al_m) as tni_n_al_m,
										SUM(tni_n_al_s) as tni_n_al_s,
										SUM(tni_n_al_k) as tni_n_al_k,
										SUM(pol) as pol,
										SUM(pol_k) as pol_k,
										SUM(askes_al) as askes_al,
										SUM(askes_n_al) as askes_n_al,
										SUM(bpjs_kes) as bpjs_kes,
										SUM(kjs) as kjs,
										SUM(pbi) as pbi,
										SUM(bpjs_ket) as bpjs_ket,
										SUM(phl) as phl,
										SUM(jam_per) as jam_per,
										SUM(kerjasama) as kerjasama,
										SUM(umum+tni_al_m+tni_al_s+tni_al_k+tni_n_al_m+tni_n_al_s+tni_n_al_k+pol+pol_k+askes_al+askes_n_al+bpjs_kes+kjs+pbi+bpjs_ket+phl+jam_per+kerjasama) as tot_stat 
									FROM
										dashboard_kunj_poli 
									WHERE
										(
											LEFT(tgl_kunjungan , 10) BETWEEN '$awal'
											AND '$akhir'
										)
									AND id_poli LIKE '%$poli%'
									GROUP BY
										id_diagnosa
									ORDER BY
										tot_stat desc");
        }

		function get_data_diag_ri($awal, $akhir, $lokasi){
			return $this->db->query("SELECT
										nm_diagnosa ,
										diagnosa1 ,
										lokasi,
										klsiri,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia6) as usia8 ,
										SUM(usia7) as usia9 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7+usia8+usia9) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_iri_v2
									WHERE
										(
											LEFT(tgl_keluar , 10) BETWEEN '$awal'
											AND '$akhir'
										)
									AND lokasi LIKE '%$lokasi%'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

		function get_data_rekap_ri($awal, $akhir, $lokasi){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
										SUM(stat1_utama_ps) as stat1_utama_ps,
										SUM(stat1_utama_hr) as stat1_utama_hr,
										SUM(stat1_I_ps) as stat1_I_ps,
										SUM(stat1_I_hr) as stat1_I_hr,
										SUM(stat1_II_ps) as stat1_II_ps,
										SUM(stat1_II_hr) as stat1_II_hr,
										SUM(stat1_III_ps) as stat1_III_ps,
										SUM(stat1_III_hr) as stat1_III_hr,	

										SUM(stat2_vvip_ps) as stat2_vvip_ps,
										SUM(stat2_vvip_hr) as stat2_vvip_hr,
										SUM(stat2_vip_ps) as stat2_vip_ps,
										SUM(stat2_vip_hr) as stat2_vip_hr,
										SUM(stat2_utama_ps) as stat2_utama_ps,
										SUM(stat2_utama_hr) as stat2_utama_hr,
										SUM(stat2_I_ps) as stat2_I_ps,
										SUM(stat2_I_hr) as stat2_I_hr,
										SUM(stat2_II_ps) as stat2_II_ps,
										SUM(stat2_II_hr) as stat2_II_hr,
										SUM(stat2_III_ps) as stat2_III_ps,
										SUM(stat2_III_hr) as stat2_III_hr,	

										SUM(stat3_vvip_ps) as stat3_vvip_ps,
										SUM(stat3_vvip_hr) as stat3_vvip_hr,
										SUM(stat3_vip_ps) as stat3_vip_ps,
										SUM(stat3_vip_hr) as stat3_vip_hr,
										SUM(stat3_utama_ps) as stat3_utama_ps,
										SUM(stat3_utama_hr) as stat3_utama_hr,
										SUM(stat3_I_ps) as stat3_I_ps,
										SUM(stat3_I_hr) as stat3_I_hr,
										SUM(stat3_II_ps) as stat3_II_ps,
										SUM(stat3_II_hr) as stat3_II_hr,
										SUM(stat3_III_ps) as stat3_III_ps,
										SUM(stat3_III_hr) as stat3_III_hr,	

										SUM(stat4_vvip_ps) as stat4_vvip_ps,
										SUM(stat4_vvip_hr) as stat4_vvip_hr,
										SUM(stat4_vip_ps) as stat4_vip_ps,
										SUM(stat4_vip_hr) as stat4_vip_hr,
										SUM(stat4_utama_ps) as stat4_utama_ps,
										SUM(stat4_utama_hr) as stat4_utama_hr,
										SUM(stat4_I_ps) as stat4_I_ps,
										SUM(stat4_I_hr) as stat4_I_hr,
										SUM(stat4_II_ps) as stat4_II_ps,
										SUM(stat4_II_hr) as stat4_II_hr,
										SUM(stat4_III_ps) as stat4_III_ps,
										SUM(stat4_III_hr) as stat4_III_hr,	

										SUM(stat5_vvip_ps) as stat5_vvip_ps,
										SUM(stat5_vvip_hr) as stat5_vvip_hr,
										SUM(stat5_vip_ps) as stat5_vip_ps,
										SUM(stat5_vip_hr) as stat5_vip_hr,
										SUM(stat5_utama_ps) as stat5_utama_ps,
										SUM(stat5_utama_hr) as stat5_utama_hr,
										SUM(stat5_I_ps) as stat5_I_ps,
										SUM(stat5_I_hr) as stat5_I_hr,
										SUM(stat5_II_ps) as stat5_II_ps,
										SUM(stat5_II_hr) as stat5_II_hr,
										SUM(stat5_III_ps) as stat5_III_ps,
										SUM(stat5_III_hr) as stat5_III_hr,	

										SUM(stat6_vvip_ps) as stat6_vvip_ps,
										SUM(stat6_vvip_hr) as stat6_vvip_hr,
										SUM(stat6_vip_ps) as stat6_vip_ps,
										SUM(stat6_vip_hr) as stat6_vip_hr,
										SUM(stat6_utama_ps) as stat6_utama_ps,
										SUM(stat6_utama_hr) as stat6_utama_hr,
										SUM(stat6_I_ps) as stat6_I_ps,
										SUM(stat6_I_hr) as stat6_I_hr,
										SUM(stat6_II_ps) as stat6_II_ps,
										SUM(stat6_II_hr) as stat6_II_hr,
										SUM(stat6_III_ps) as stat6_III_ps,
										SUM(stat6_III_hr) as stat6_III_hr,	

										SUM(stat7_vvip_ps) as stat7_vvip_ps,
										SUM(stat7_vvip_hr) as stat7_vvip_hr,
										SUM(stat7_vip_ps) as stat7_vip_ps,
										SUM(stat7_vip_hr) as stat7_vip_hr,
										SUM(stat7_utama_ps) as stat7_utama_ps,
										SUM(stat7_utama_hr) as stat7_utama_hr,
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_utama_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_utama_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_utama_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_utama_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_utama_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_utama_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_utama_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_utama_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_utama_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_utama_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_utama_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_utama_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_utama_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_utama_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekap_iri_v2
									WHERE
										(
											LEFT(tgl_keluar , 10) BETWEEN '$awal'
											AND '$akhir'
										)
									AND lokasi LIKE '%$lokasi%'
									group by
										tgl_keluar");
		}

		function get_data_proc_rj($awal, $akhir){
			return $this->db->query("SELECT
									id_procedure ,
									nm_procedure ,
									SUM(L) as L ,
									SUM(P) as P ,
									SUM(P+L) as tot ,
									SUM(baru) as baru ,
									SUM(usia06) as usia06 ,
									SUM(usia728) as usia728 ,
									SUM(usia1) as usia1 ,
									SUM(usia2) as usia2 ,
									SUM(usia3) as usia3 ,
									SUM(usia4) as usia4 ,
									SUM(usia5) as usia5 ,
									SUM(usia6) as usia6 ,
									SUM(usia7) as usia7 ,
									SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
									SUM(stat1) as stat1 ,
									SUM(stat2) as stat2 ,
									SUM(stat3) as stat3 ,
									SUM(stat4) as stat4 ,
									SUM(stat1+stat2+stat3+stat4) as tot_stat 
								FROM
									procedure_irj
								WHERE
									(
										LEFT(tgl , 10) BETWEEN '$awal'
										AND '$akhir'
									)
								AND id_poli != 'BA00'
								GROUP BY
									id_procedure
								ORDER BY
									tot_stat desc
								LIMIT 10");
		}

		function get_data_proc_rd($awal, $akhir){
			return $this->db->query("SELECT
									id_procedure ,
									nm_procedure ,
									SUM(L) as L ,
									SUM(P) as P ,
									SUM(P+L) as tot ,
									SUM(baru) as baru ,
									SUM(usia06) as usia06 ,
									SUM(usia728) as usia728 ,
									SUM(usia1) as usia1 ,
									SUM(usia2) as usia2 ,
									SUM(usia3) as usia3 ,
									SUM(usia4) as usia4 ,
									SUM(usia5) as usia5 ,
									SUM(usia6) as usia6 ,
									SUM(usia7) as usia7 ,
									SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
									SUM(stat1) as stat1 ,
									SUM(stat2) as stat2 ,
									SUM(stat3) as stat3 ,
									SUM(stat4) as stat4 ,
									SUM(stat1+stat2+stat3+stat4) as tot_stat 
								FROM
									procedure_irj
								WHERE
									(
										LEFT(tgl , 10) BETWEEN '$awal'
										AND '$akhir'
									)
								AND id_poli = 'BA00'
								GROUP BY
									id_procedure
								ORDER BY
									tot_stat desc
								LIMIT 10");
		}

		function get_data_proc_ri($awal, $akhir, $lokasi){
			return $this->db->query("SELECT
										nm_procedure ,
										id_procedure ,
										lokasi,
										klsiri,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat1+stat2+stat3+stat4) as tot_stat 
									FROM
										procedure_icdiri
									WHERE
										(
											LEFT(tgl_keluar , 10) BETWEEN '$awal'
											AND '$akhir'
										)
									AND lokasi LIKE '%$lokasi%'
									group by
										id_procedure
									order by
										tot_stat desc
									LIMIT 10");
		}

		function get_data_poli_igd($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_igd
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_urologi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedah_urologi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_bedah_umum($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedah_umum
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}

		function get_data_poli_bedah_tulang($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedah_tulang
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_bedah_saraf($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedah_saraf
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_bedah_plastik($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedah_plastik
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_psikologi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_psikologi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_kesehatanjiwa($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_kesehatanjiwa
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_kebidanan($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_kebidanan
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_kia($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_kia
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_kb($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_kb
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_kulit($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_kulit
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_gigi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_gigi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_bedahmulut($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bedahmulut
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_orthodonti($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_orthodonti
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
			function get_data_poli_periodonsi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_periodonsi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_prosthodonti($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_prosthodonti
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_mata($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_mata
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_tht($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_tht
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_rehabmedik($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_rehabmedik
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_bayi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_bayi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_penyakitdalam($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_penyakitdalam
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_paru($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_paru
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_jantung($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_jantung
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_anak($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_anak
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_syaraf($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_syaraf
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_umum($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_umum
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}
		function get_data_poli_gizi($awal, $akhir){
			return $this->db->query("SELECT
										id_diagnosa ,
										diagnosa ,
										SUM(L) as L ,
										SUM(P) as P ,
										SUM(P+L) as tot ,
										SUM(usia1) as usia1 ,
										SUM(usia2) as usia2 ,
										SUM(usia3) as usia3 ,
										SUM(usia4) as usia4 ,
										SUM(usia5) as usia5 ,
										SUM(usia6) as usia6 ,
										SUM(usia7) as usia7 ,
										SUM(usia1+usia2+usia3+usia4+usia5+usia6+usia7) as tot_usia ,
										SUM(stat1) as stat1 ,
										SUM(stat2) as stat2 ,
										SUM(stat3) as stat3 ,
										SUM(stat4) as stat4 ,
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										diagnosa_irj_detail_poli_gizi
									where
										LEFT(tgl_kunjungan , 10) >= '$awal'
									and LEFT(tgl_kunjungan , 10) <= '$akhir'
									group by
										id_diagnosa
									order by
										tot_stat desc");
		}

		//laporan tindakan
		function get_chart_tind_detail($poli,$tglawal,$tglakhir){
			$txtpoli='';
			if($poli!='semua'){
				$txtpoli=" and c.id_poli='$poli'";
			}

			return $this->db->query("select b.*, SUM(b.qtyind) as banyak 
					from jenis_tindakan a 
					JOIN pelayanan_poli b ON a.idtindakan=b.idtindakan
					JOIN poliklinik c ON b.id_poli=c.id_poli
					where a.idpok1 IN ('B','Z')
					and LEFT(b.tgl_kunjungan,10)>='$tglawal' and LEFT(b.tgl_kunjungan,10)<='$tglakhir'
					$txtpoli
					GROUP BY a.idtindakan
					order by SUM(b.qtyind) DESC");
		}

		function get_chart_tindakan_rj($poli,$tglawal,$tglakhir){
			$txtpoli='';
			if($poli!='semua'){
				$txtpoli=" and c.id_poli='$poli'";
			}

			return $this->db->query("select b.*, c.*, SUM(b.qtyind) as banyak 
					from jenis_tindakan a 
					JOIN pelayanan_poli b ON a.idtindakan=b.idtindakan
					JOIN poliklinik c ON b.id_poli=c.id_poli
					where a.idpok1 IN ('B','Z')
					and LEFT(b.tgl_kunjungan,10)>='$tglawal' and LEFT(b.tgl_kunjungan,10)<='$tglakhir'
					$txtpoli
					GROUP BY a.idtindakan, c.id_poli
					order by SUM(b.qtyind) DESC");
		}

		function get_chart_tindakan_ri($lokasi,$tglawal,$tglakhir){
			$txtlokasi='';
			if($lokasi!=''){
				$txtlokasi=" and c.lokasi='$lokasi'";
			}

			return $this->db->query("SELECT a.*, c.*, SUM(b.qtyyanri) as banyak 
					from jenis_tindakan a 
					JOIN pelayanan_iri b ON a.idtindakan=b.id_tindakan
					JOIN ruang c ON b.idrg=c.idrg and c.lokasi!='Kamar Operasi'
					where a.idpok1 IN ('N','B','C')
					and LEFT(b.tgl_layanan,10)>='$tglawal' and LEFT(b.tgl_layanan,10)<='$tglakhir'
					$txtlokasi
					GROUP BY a.idtindakan, c.idrg
					order by SUM(b.qtyyanri) DESC");
		}

		function get_chart_ri_tind_detail($lokasi,$tglawal,$tglakhir){
			$txtlokasi='';
			if($lokasi!=''){
				$txtlokasi=" and c.lokasi='$lokasi'";
			}

			return $this->db->query("SELECT a.*, c.*, SUM(b.qtyyanri) as banyak 
					from jenis_tindakan a 
					JOIN pelayanan_iri b ON a.idtindakan=b.id_tindakan
					JOIN ruang c ON b.idrg=c.idrg and c.lokasi!='Kamar Operasi'
					where a.idpok1 IN ('N','B','C')
					and LEFT(b.tgl_layanan,10)>='$tglawal' and LEFT(b.tgl_layanan,10)<='$tglakhir'
					$txtlokasi
					GROUP BY a.idtindakan
					order by SUM(b.qtyyanri) DESC");
		}

		function get_sensus_iri_masuk($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_masuk");
			return $this->db->query("SELECT * FROM sensus_iri_masuk WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_pindah_dari($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_pindah_dari");
			return $this->db->query("SELECT * FROM sensus_iri_pindah_dari WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_keluar_hidup($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_keluar_hidup");
			return $this->db->query("SELECT * FROM sensus_iri_keluar_hidup WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_pindah_ke($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_pindah_ke");
			return $this->db->query("SELECT * FROM sensus_iri_pindah_ke WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_rujuk_rs_lain($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_rujuk_rs_lain");
			return $this->db->query("SELECT * FROM sensus_iri_rujuk_rs_lain WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_keluar_meninggal($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_keluar_meninggal");
			return $this->db->query("SELECT * FROM sensus_iri_keluar_meninggal WHERE tgl='$tgl' AND lokasi='$lokasi'");
		}

		function get_sensus_iri_dalam_perawatan($tgl, $lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_dalam_perawatan");
			return $this->db->query("SELECT * FROM sensus_iri_dalam_perawatan WHERE '$tgl' BETWEEN(tgl_masuk + INTERVAL 1 DAY) and tgl_keluar AND lokasi = '$lokasi'");
		}

		function get_data_kamar($lokasi){
			// return $this->db->query("SELECT * FROM sensus_iri_dalam_perawatan");
			return $this->db->query("SELECT * FROM data_kamar WHERE lokasi = '$lokasi'");
		}

		function get_sensus_irJ($tgl, $id_poli){
			// return $this->db->query("SELECT * FROM sensus_iri_dalam_perawatan");
			return $this->db->query("SELECT * FROM dashboard_kunj_poli WHERE tgl_kunjungan='$tgl' AND id_poli = '$id_poli'");
		}

		function get_data_anggota($no_nrp){
			return $this->db->query("SELECT IFNULL(e.pkt_id,'') AS pkt_id,IFNULL(a.pangkat,'') AS pangkat,IFNULL(e.kst_id,'') AS kst_id,IFNULL(b.kst_nama,'') AS kst_nama,IFNULL(e.kst2_id,'') AS kst2_id,IFNULL(c.kst2_nama,'') AS kst2_nama,IFNULL(e.kst3_id,'') AS kst3_id,IFNULL(d.kst3_nama,'') AS kst3_nama FROM data_pasien e LEFT JOIN tni_pangkat a ON a.pangkat_id=e.pkt_id LEFT JOIN tni_kesatuan b ON b.kst_id=e.kst_id LEFT JOIN tni_kesatuan2 c ON c.kst2_id=e.kst2_id LEFT JOIN tni_kesatuan3 d ON d.kst3_id=e.kst3_id WHERE e.no_nrp='".$no_nrp."' AND e.nrp_sbg='T' LIMIT 1");
		}

	}
?>
