<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class MinmedIRILaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_ruangan(){
			return $this->db->query("SELECT lokasi FROM ruang GROUP BY lokasi");
		}

		function get_data($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
										lokasi,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}
//start rekapitulasi per ruangan pasien inap
		function get_data_anyelir($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_anyelir
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_bougenvile($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_bougenvile
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_bayi($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_bayi
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}


		function get_data_cempakaatas($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_cempakaatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_cempakabawah($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_cempakabawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_dahliaatas($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_dahliaatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_dahliabawah($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_dahliabawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}


		function get_data_edelweis($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_edelweis
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_flamboyanatas($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_flamboyanatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_flamboyanbawah($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_flamboyanbawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_gardenia($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_gardenia
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}

		function get_data_ICU($awal, $akhir){
			return $this->db->query("SELECT
										tgl_keluar as tgl_keluar,
										SUM(pulang_1) as pulang_1 ,
										SUM(pulang_2) as pulang_2 ,
										SUM(pulang_3) as pulang_3 ,
										SUM(stat1_vvip_ps) as stat1_vvip_ps,
										SUM(stat1_vvip_hr) as stat1_vvip_hr,
										SUM(stat1_vip_ps) as stat1_vip_ps,
										SUM(stat1_vip_hr) as stat1_vip_hr,
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
										SUM(stat7_I_ps) as stat7_I_ps,
										SUM(stat7_I_hr) as stat7_I_hr,
										SUM(stat7_II_ps) as stat7_II_ps,
										SUM(stat7_II_hr) as stat7_II_hr,
										SUM(stat7_III_ps) as stat7_III_ps,
										SUM(stat7_III_hr) as stat7_III_hr,	

										SUM(stat1_vvip_ps+stat1_vip_ps+stat1_I_ps+stat1_II_ps+stat1_III_ps+
											stat2_vvip_ps+stat2_vip_ps+stat2_I_ps+stat2_II_ps+stat2_III_ps+
											stat3_vvip_ps+stat3_vip_ps+stat3_I_ps+stat3_II_ps+stat3_III_ps+
											stat4_vvip_ps+stat4_vip_ps+stat4_I_ps+stat4_II_ps+stat4_III_ps+
											stat5_vvip_ps+stat5_vip_ps+stat5_I_ps+stat5_II_ps+stat5_III_ps+
											stat6_vvip_ps+stat6_vip_ps+stat6_I_ps+stat6_II_ps+stat6_III_ps+
											stat7_vvip_ps+stat7_vip_ps+stat7_I_ps+stat7_II_ps+stat7_III_ps) as tot_stat_ps,

										SUM(stat1_vvip_hr+stat1_vip_hr+stat1_I_hr+stat1_II_hr+stat1_III_hr+
											stat2_vvip_hr+stat2_vip_hr+stat2_I_hr+stat2_II_hr+stat2_III_hr+
											stat3_vvip_hr+stat3_vip_hr+stat3_I_hr+stat3_II_hr+stat3_III_hr+
											stat4_vvip_hr+stat4_vip_hr+stat4_I_hr+stat4_II_hr+stat4_III_hr+
											stat5_vvip_hr+stat5_vip_hr+stat5_I_hr+stat5_II_hr+stat5_III_hr+
											stat6_vvip_hr+stat6_vip_hr+stat6_I_hr+stat6_II_hr+stat6_III_hr+
											stat7_vvip_hr+stat7_vip_hr+stat7_I_hr+stat7_II_hr+stat7_III_hr) as tot_stat_hr

									FROM
										rekapitulasi_pasien_inap_ICU
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										tgl_keluar");
		}
//end rekapitulasi pasien inap

//start diagnosa rawat inap
function get_data_diagnosa_anyelir($awal, $akhir, $kelas){
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
										dianosa_pasien_inap_anyelir
									where
										klsiri = '$kelas'
									and
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_anyelir_vip($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_anyelir_vip
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}


function get_data_diagnosa_bougenvile($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_bougenvile
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_cempakaatas($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_cempakaatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_cempakabawah($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_cempakabawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_dahliaatas($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_dahliaatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_dahliabawah($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_dahliabawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_edelweis($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_edelweis
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_flamboyanatas($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_flamboyanatas
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}
function get_data_diagnosa_flamboyanbawah($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_flamboyanbawah
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_gardenia($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_gardenia
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_icu($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_icu
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}

function get_data_diagnosa_bayi($awal, $akhir){
			return $this->db->query("SELECT
										
										nm_diagnosa ,
										diagnosa1 ,
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
										SUM(stat5) as stat5 ,
										SUM(stat6) as stat6 ,
										SUM(stat7) as stat7  ,
										SUM(stat1+stat2+stat3+stat4+stat5+stat6+stat7) as tot_stat 
									FROM
										dianosa_pasien_inap_bayi
									where
										LEFT(tgl_keluar , 10) >= '$awal'
									and LEFT(tgl_keluar , 10) <= '$akhir'
									group by
										diagnosa1
									order by
										tot_stat desc");
		}
//end diagnosa rawat inap			

	}
?>
