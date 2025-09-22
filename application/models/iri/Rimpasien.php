<?php
class Rimpasien extends CI_Model {

	public function get_pelaksana_pasien_iri($no_ipd){
		$data=$this->db->query("SELECT 
    a.idoprtr, a.tumuminap, a.tarifalkes,SUM(a.tumuminap*a.qtyyanri) as vtottind, SUM(a.tarifalkes*a.qtyyanri) as vtotalkes, SUM(a.qtyyanri) as qtyyanri,
    (SUM(a.tumuminap*a.qtyyanri)+SUM(a.tarifalkes*a.qtyyanri)) as vtot, a.id_tindakan, c.nmtindakan, b.nm_dokter,d.nmruang, e.nama, e.no_cm, e.alamat, f.carabayar, d.lokasi
	FROM
	    pelayanan_iri a,
	    data_dokter b,
	    jenis_tindakan c,
	    ruang d,
	    data_pasien e,
	    pasien_iri f
	WHERE
	    a.no_ipd = '$no_ipd'
	and a.idoprtr=b.id_dokter    
	and a.id_tindakan=c.idtindakan
	and a.idrg=d.idrg
	and f.no_ipd=a.no_ipd
	and f.no_cm=e.no_medrec
	group by a.idoprtr, a.idrg
	order by d.nmruang, b.nm_dokter");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

	public function delete_ruang_iri_by_ipd($no_ipd){
		$data=$this->db->query("
			DELETE FROM ruang_iri
			WHERE no_ipd = '$no_ipd' 
			");
	}

	public function delete_pasien_iri($no_ipd){
		$data=$this->db->query("
			DELETE FROM pasien_iri
			WHERE no_ipd = '$no_ipd' 
			");
	}

	public function get_matkes_ruang($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'NA01%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_ok($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'D%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_vk($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'BE%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_tindakan_perawat($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri JOIN data_dokter 
		ON pelayanan_iri.idoprtr=data_dokter.id_dokter
		where data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'");
		return $data->result_array();
	}

	public function get_detail_tindakan($id_tindakan,$kelas){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
and b.kelas='$kelas'");
		}

		public function get_detail_kelas($kelas){
			return $this->db->query("select * from kelas where kelas='$kelas'");
		}

		public function get_persen_jasa_ruang($idrg){
			return $this->db->query("select * from ruang where idrg='$idrg'");
		}

	public function get_jml_keluar_masuk_by_date($tgl_awal){
		$data=$this->db->query("
		SELECT a.tgl_masuk as tgl, TIMESTAMPDIFF(YEAR , b.tgl_lahir, NOW() )as umur, left(b.tgl_lahir,10) tgl_lahir, a.no_ipd,b.no_cm,b.nama,o.id_poli,p.nm_poli,o.xuser,c.id_icd,c.nm_diagnosa,b.sex,b.alamat,k.nmkontraktor, kst1.kst_nama, kst2.kst2_nama, kst3.kst3_nama, pkt.pangkat, (select nm_dokter from data_dokter where id_dokter = a.id_dokter) as dokter,
		r.nmruang,'MASUK' as tipe_masuk
		FROM pasien_iri as a
		LEFT JOIN data_pasien as b on a.no_cm = b.no_medrec
		LEFT JOIN daftar_ulang_irj as o on a.noregasal = o.no_register
		LEFT JOIN poliklinik as p on o.id_poli = p.id_poli
		LEFT JOIN kontraktor as k on a.id_kontraktor = k.id_kontraktor
		LEFT JOIN icd1 as c on a.diagnosa1 = c.id_icd
		LEFT JOIN ruang as r on a.idrg = r.idrg
		LEFT JOIN tni_kesatuan as kst1 on b.kst_id = kst1.kst_id
		LEFT JOIN tni_kesatuan2 as kst2 on b.kst2_id = kst2.kst2_id
		LEFT JOIN tni_kesatuan3 as kst3 on b.kst3_id = kst3.kst3_id
		LEFT JOIN tni_pangkat as pkt on b.pkt_id = pkt.pangkat_id
		WHERE a.tgl_masuk = '$tgl_awal'
		UNION
		SELECT d.tgl_keluar as tgl, TIMESTAMPDIFF(YEAR , e.tgl_lahir, NOW() )as umur, left(e.tgl_lahir,10) tgl_lahir, d.no_ipd,e.no_cm,e.nama,g.nm_poli,j.id_poli,j.xuser,f.id_icd,f.nm_diagnosa,e.sex,e.alamat,z.nmkontraktor, ab.kst_nama, ac.kst2_nama, ad.kst3_nama, af.pangkat, (select nm_dokter from data_dokter where id_dokter = d.id_dokter) as dokter,
		m.nmruang,'KELUAR' as tipe_masuk
		FROM pasien_iri as d
		LEFT JOIN data_pasien as e on d.no_cm = e.no_medrec
		LEFT JOIN daftar_ulang_irj as j on d.noregasal = j.no_register
		LEFT JOIN kontraktor as z on d.id_kontraktor = z.id_kontraktor
		LEFT JOIN ruang as m on d.idrg = m.idrg
		LEFT JOIN icd1 as f on d.diagnosa1 = f.id_icd
		LEFT JOIN poliklinik as g on j.id_poli = g.id_poli
		LEFT JOIN tni_kesatuan as ab on e.kst_id = ab.kst_id
		LEFT JOIN tni_kesatuan2 as ac on e.kst2_id = ac.kst2_id
		LEFT JOIN tni_kesatuan3 as ad on e.kst3_id = ad.kst3_id
		LEFT JOIN tni_pangkat as af on e.pkt_id = af.pangkat_id
		WHERE d.tgl_keluar = '$tgl_awal'
			");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_bulan($tgl_awal){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_tahun($tgl_awal){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

	//--- end laporan

	public function select_pasien_iri_all(){
		$data=$this->db->query("select *, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor
			from pasien_iri as a left join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NULL
			and (a.ipdibu = ' ' or a.ipdibu is null)

			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_user($userid){
		$data=$this->db->query("SELECT
									a.no_ipd,
									c.no_cm,
									a.nama,
									d.nmruang,
									b.kelas,
									a.bed,
									a.dokter,
									b.tglmasukrg,
									a.carabayar,
									k.nmkontraktor,
									TIMESTAMPDIFF(YEAR , c.tgl_lahir, NOW() )as umur
								FROM
									pasien_iri AS a
									LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
									INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
									LEFT JOIN ruang AS d ON a.idrg = d.idrg
									INNER JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
									LEFT JOIN kontraktor k ON k.`id_kontraktor` = a.`id_kontraktor` 
								WHERE
									a.tgl_keluar IS NULL
									AND b.tglkeluarrg IS NULL 
									AND e.userid = '$userid'
									AND a.mutasi = 0 
									AND ( a.ipdibu = ' ' OR a.ipdibu IS NULL ) 
								GROUP BY
									a.no_ipd,
									b.`idrgiri`,
									e.`id` 
								ORDER BY
									a.no_ipd ASC");
		return $data->result_array();
	}

	public function select_pasien_iri_lokasi($lokasi){
		$data=$this->db->query("SELECT
										a.no_ipd,
										c.no_cm,
										a.nama,
										d.lokasi,
										d.nmruang,
										b.kelas,
										a.bed,
										a.dokter,
										b.tglmasukrg,
										a.carabayar,
										k.nmkontraktor,
										g.nm_diagnosa,
										a.diagmasuk,
										p.pangkat,
										c.no_nrp,

									IF
										( ( `c`.`sex` = 'L' ), 1, '' ) AS `L`,
									IF
										( ( `c`.`sex` = 'P' ), 1, '' ) AS `P`,
									IF
										( ( `a`.`carabayar` = 'UMUM' ), 1, '' ) AS `umum`,
									IF
										( ( `a`.`id_kontraktor` = '2' ), 1, '' ) AS `tni_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '5' ), 1, '' ) AS `tni_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '7' ), 1, '' ) AS `tni_al_k`,
									IF
										( ( `a`.`id_kontraktor` IN ( '1', '3' ) ), 1, '' ) AS `tni_n_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '6' ), 1, '' ) AS `tni_n_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '8' ), 1, '' ) AS `tni_n_al_k`,
									IF
										( ( `a`.`id_kontraktor` = '4' ), 1, '' ) AS `pol`,
									IF
										( ( `a`.`id_kontraktor` = '9' ), 1, '' ) AS `pol_k`,
									IF
										( ( `a`.`id_kontraktor` = '10' ), 1, '' ) AS `askes_al`,
									IF
										( ( `a`.`id_kontraktor` = '11' ), 1, '' ) AS `askes_n_al`,
									IF
										( ( `a`.`id_kontraktor` = '12' ), 1, '' ) AS `bpjs_kes`,
									IF
										( ( `a`.`id_kontraktor` = '13' ), 1, '' ) AS `kjs`,
									IF
										( ( `a`.`id_kontraktor` = '14' ), 1, '' ) AS `pbi`,
									IF
										( ( `a`.`id_kontraktor` = '15' ), 1, '' ) AS `bpjs_ket`,
									IF
										( ( `a`.`id_kontraktor` = '16' ), 1, '' ) AS `phl`,
									IF
										( ( `a`.`id_kontraktor` = '17' ), 1, '' ) AS `jam_per`,
									IF
										(
											( ( `a`.`id_kontraktor` NOT IN ( '14', '15', '16', '17' ) ) AND ( `k`.`jamsoskes` = '0' ) ),
											1,
											'' 
										) AS `kerjasama`,
										`c`.`nrp_sbg` AS `nrp_sbg`,
										`c`.`no_nrp` AS `no_nrp`,
										`a`.`id_kontraktor` AS `id_kontraktor` 
									FROM
										pasien_iri AS a
										LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
										INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
										LEFT JOIN ruang AS d ON a.idrg = d.idrg
										INNER JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
										LEFT JOIN kontraktor k ON k.`id_kontraktor` = a.`id_kontraktor` 
										LEFT JOIN icd1 AS g ON a.diagmasuk=g.id_icd
										LEFT JOIN tni_pangkat as p on c.pkt_id=p.pangkat_id
									WHERE
										a.tgl_keluar IS NULL 
										AND e.userid = '1'
										AND a.mutasi = 0 
										AND ( a.ipdibu = ' ' OR a.ipdibu IS NULL ) 
										AND d.lokasi like '%$lokasi%'
										AND b.tglkeluarrg is null
									GROUP BY
										a.no_ipd,
										b.`idrgiri`,
										e.`id` 
									ORDER BY
										b.kelas DESC");
		return $data;
	}

	// public function select_ruang_user($userid){
	// 	$data=$this->db->query("select GROUP_CONCAT(nm_ruang) as akses_ruang from dyn_ruang_user as e where e.userid='$userid'
	// 		");
	// 	return $data->row();
	// }

	public function select_pasien_pulang_iri_lokasi($lokasi){
		$data=$this->db->query("SELECT
										a.no_ipd,
										c.no_cm,
										a.nama,
										d.nmruang,
										b.kelas,
										a.bed,
										a.dokter,
										b.tglmasukrg,
										a.tgl_keluar,
										a.carabayar,
										k.nmkontraktor,
										g.nm_diagnosa,
										a.diagmasuk,
										p.pangkat,
										c.no_nrp,

									IF
										( ( `c`.`sex` = 'L' ), 1, '' ) AS `L`,
									IF
										( ( `c`.`sex` = 'P' ), 1, '' ) AS `P`,
									IF
										( ( `a`.`carabayar` = 'UMUM' ), 1, '' ) AS `umum`,
									IF
										( ( `a`.`id_kontraktor` = '2' ), 1, '' ) AS `tni_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '5' ), 1, '' ) AS `tni_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '7' ), 1, '' ) AS `tni_al_k`,
									IF
										( ( `a`.`id_kontraktor` IN ( '1', '3' ) ), 1, '' ) AS `tni_n_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '6' ), 1, '' ) AS `tni_n_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '8' ), 1, '' ) AS `tni_n_al_k`,
									IF
										( ( `a`.`id_kontraktor` = '4' ), 1, '' ) AS `pol`,
									IF
										( ( `a`.`id_kontraktor` = '9' ), 1, '' ) AS `pol_k`,
									IF
										( ( `a`.`id_kontraktor` = '10' ), 1, '' ) AS `askes_al`,
									IF
										( ( `a`.`id_kontraktor` = '11' ), 1, '' ) AS `askes_n_al`,
									IF
										( ( `a`.`id_kontraktor` = '12' ), 1, '' ) AS `bpjs_kes`,
									IF
										( ( `a`.`id_kontraktor` = '13' ), 1, '' ) AS `kjs`,
									IF
										( ( `a`.`id_kontraktor` = '14' ), 1, '' ) AS `pbi`,
									IF
										( ( `a`.`id_kontraktor` = '15' ), 1, '' ) AS `bpjs_ket`,
									IF
										( ( `a`.`id_kontraktor` = '16' ), 1, '' ) AS `phl`,
									IF
										( ( `a`.`id_kontraktor` = '17' ), 1, '' ) AS `jam_per`,
									IF
										(
											( ( `a`.`id_kontraktor` NOT IN ( '14', '15', '16', '17' ) ) AND ( `k`.`jamsoskes` = '0' ) ),
											1,
											'' 
										) AS `kerjasama`,
										`c`.`nrp_sbg` AS `nrp_sbg`,
										`c`.`no_nrp` AS `no_nrp`,
										`a`.`id_kontraktor` AS `id_kontraktor` 
									FROM
										pasien_iri AS a
										LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
										INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
										LEFT JOIN ruang AS d ON a.idrg = d.idrg
										INNER JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
										LEFT JOIN kontraktor k ON k.`id_kontraktor` = a.`id_kontraktor` 
										LEFT JOIN icd1 AS g ON a.diagmasuk=g.id_icd
										LEFT JOIN tni_pangkat as p on c.pkt_id=p.pangkat_id
									WHERE
										a.tgl_keluar IS NOT NULL 
										AND e.userid = '1'
										AND a.mutasi = 0 
										AND ( a.ipdibu = ' ' OR a.ipdibu IS NULL ) 
										AND d.lokasi = '$lokasi'
									GROUP BY
										a.no_ipd,
										b.`idrgiri`,
										e.`id` 
									ORDER BY
										b.kelas DESC");
		return $data;
	}

	public function select_pasien_pulang_iri_tgl($date1,$date2,$lokasi){
		$data=$this->db->query("SELECT
										a.no_ipd,
										c.no_cm,
										a.nama,
										d.nmruang,
										b.kelas,
										a.bed,
										a.dokter,
										b.tglmasukrg,
										a.tgl_keluar,
										a.carabayar,
										k.nmkontraktor,
										g.nm_diagnosa,
										a.diagmasuk,
										p.pangkat,
										c.no_nrp,

									IF
										( ( `c`.`sex` = 'L' ), 1, '' ) AS `L`,
									IF
										( ( `c`.`sex` = 'P' ), 1, '' ) AS `P`,
									IF
										( ( `a`.`carabayar` = 'UMUM' ), 1, '' ) AS `umum`,
									IF
										( ( `a`.`id_kontraktor` = '2' ), 1, '' ) AS `tni_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '5' ), 1, '' ) AS `tni_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '7' ), 1, '' ) AS `tni_al_k`,
									IF
										( ( `a`.`id_kontraktor` IN ( '1', '3' ) ), 1, '' ) AS `tni_n_al_m`,
									IF
										( ( `a`.`id_kontraktor` = '6' ), 1, '' ) AS `tni_n_al_s`,
									IF
										( ( `a`.`id_kontraktor` = '8' ), 1, '' ) AS `tni_n_al_k`,
									IF
										( ( `a`.`id_kontraktor` = '4' ), 1, '' ) AS `pol`,
									IF
										( ( `a`.`id_kontraktor` = '9' ), 1, '' ) AS `pol_k`,
									IF
										( ( `a`.`id_kontraktor` = '10' ), 1, '' ) AS `askes_al`,
									IF
										( ( `a`.`id_kontraktor` = '11' ), 1, '' ) AS `askes_n_al`,
									IF
										( ( `a`.`id_kontraktor` = '12' ), 1, '' ) AS `bpjs_kes`,
									IF
										( ( `a`.`id_kontraktor` = '13' ), 1, '' ) AS `kjs`,
									IF
										( ( `a`.`id_kontraktor` = '14' ), 1, '' ) AS `pbi`,
									IF
										( ( `a`.`id_kontraktor` = '15' ), 1, '' ) AS `bpjs_ket`,
									IF
										( ( `a`.`id_kontraktor` = '16' ), 1, '' ) AS `phl`,
									IF
										( ( `a`.`id_kontraktor` = '17' ), 1, '' ) AS `jam_per`,
									IF
										(
											( ( `a`.`id_kontraktor` NOT IN ( '14', '15', '16', '17' ) ) AND ( `k`.`jamsoskes` = '0' ) ),
											1,
											'' 
										) AS `kerjasama`,
										`c`.`nrp_sbg` AS `nrp_sbg`,
										`c`.`no_nrp` AS `no_nrp`,
										`a`.`id_kontraktor` AS `id_kontraktor` 
									FROM
										pasien_iri AS a
										LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
										INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
										LEFT JOIN ruang AS d ON a.idrg = d.idrg
										INNER JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
										LEFT JOIN kontraktor k ON k.`id_kontraktor` = a.`id_kontraktor` 
										LEFT JOIN icd1 AS g ON a.diagmasuk=g.id_icd
										LEFT JOIN tni_pangkat as p on c.pkt_id=p.pangkat_id
									WHERE
										a.tgl_keluar IS NOT NULL 
										and b.tglmasukrg >= $date1
										and b.tglmasukrg <= $date2 
										AND e.userid = '1'
										AND a.mutasi = 0 
										AND ( a.ipdibu = ' ' OR a.ipdibu IS NULL ) 
										AND d.lokasi = '$lokasi'
									GROUP BY
										a.no_ipd,
										b.`idrgiri`,
										e.`id` 
									ORDER BY
										b.kelas DESC");
		return $data;
	}

	public function select_ruang_user($userid){
		return $this->db->query("select nm_ruang as akses_ruang from dyn_ruang_user where userid='$userid'
			");
	}
	public function get_bayi_by_ipd_ibu($ipdibu){
		$data=$this->db->query("select *
			from pasien_iri as a
			where a.ipdibu = '$ipdibu'
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_all(){
		$data=$this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_bpjs(){
		$data=$this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			and a.no_sep is not null
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_belum_cetak_kwitansi($date){
		if ($date=='' || $date == NULL) {
			$tgl=date('Y-m-d');
		}else{
			$tgl=$date;
		}
		
		$data=$this->db->query("SELECT *
			from pasien_iri as a inner join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			and a.cetak_kwitansi is NULL
			and (a.tgl_keluar='$tgl' or a.tgl_masuk='$tgl')	
			group by a.no_ipd
			order by a.no_ipd asc
			");
		return $data->result_array();
			// where a.tgl_keluar IS NOT NULL 
	}

	public function select_pasien_iri_pulang_sudah_cetak_kwitansi(){
		$data=$this->db->query("
			SELECT
				*
			FROM
				pasien_iri AS a
			INNER JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
			INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
			WHERE
			a.cetak_kwitansi = '1'
			ORDER BY
			a.no_ipd ASC
			");
		return $data->result_array();
	}



	public function get_list_ruang_mutasi_pasien($no_ipd){
		$data=$this->db->query("select a.*, b.nmruang, a.hrawatrg*tumumrg as vtot from ruang_iri a, ruang b
			where a.idrg=b.idrg
			and a.no_ipd = '$no_ipd'
			");

		// $data=$this->db->query("select *
		// 	from ruang_iri as a left join ruang as b on a.idrg = b.idrg
		// 	where a.no_ipd = '$no_ipd'
		// 	order by tglmasukrg asc
		// 	");
		return $data->result_array();
	}

	public function get_list_lokasi_mutasi_pasien($no_ipd){
		$data=$this->db->query("select distinct(b.lokasi), b.nmruang
			from ruang_iri as a left join ruang as b on a.idrg = b.idrg			
			where a.no_ipd = '$no_ipd'
			order by a.tglmasukrg asc
			");

		// $data=$this->db->query("select *
		// 	from ruang_iri as a left join ruang as b on a.idrg = b.idrg
		// 	where a.no_ipd = '$no_ipd'
		// 	order by tglmasukrg asc
		// 	");
		return $data->result_array();
	}
	public function get_list_lab_pasien($no_ipd,$no_reg_asal=null){
		if ($no_reg_asal!=null) {
			$no_asal= "OR a.no_register = '$no_reg_asal'";
		}else{
			$no_asal = "";
		}
		$data=$this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register = '$no_ipd' $no_asal
			and (a.cara_bayar='BPJS' or a.cara_bayar='KERJASAMA' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_lab is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_lab_pasien($no_ipd){
		$data=$this->db->query("select *
		from pemeriksaan_laboratorium as a
		where a.no_register in ('$no_ipd')
		and a.no_lab is not null
		order by xupdate asc");
		return $data->result_array();
	}

	public function get_patient_doctor($no_ipd){
		$data=$this->db->query("select distinct(idoprtr) from pelayanan_iri where no_ipd='$no_ipd' and idoprtr!=''");
		return $data->result_array();
	}

	public function get_list_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT tgl_kunjungan as tgl_operasi, COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			order by jenis_tindakan asc");
		return $data->result_array();
	}

	public function get_list_all_ok_pasien($no_ipd){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd')
			order by jenis_tindakan asc");
		return $data->result_array();
	}

	public function get_list_ok_pasien_newest($no_ipd,$no_reg_asal){
		$data=$this->db->query("(SELECT 
    COALESCE(no_ok, 'On Progress') AS no_ok,
    a.id_pemeriksaan_ok,
    a.id_tindakan,
    a.biaya_ok,
    IF(b.idkel_tind IN (11,12,13),(Select nama_kel from kel_tind where idkel_tind=b.idkel_tind),a.jenis_tindakan) as jenis_tindakan,
    a.id_dokter,
    a.id_opr_anes,
    a.id_dok_anes,
    a.jns_anes,
    a.id_dok_anak,
    a.qty,
    a.vtot,
    IF((SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) NOT IN ('Spesialis' , 'Dokter Jaga', 'Operasi')
            && (SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) != '',
        '',
        (SELECT 
                nm_dokter
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter)) AS nm_dokter,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_opr_anes) AS nm_opr_anes,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dok_anes) AS nm_dok_anes,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dok_anak) AS nm_dok_anak
FROM
    pemeriksaan_operasi a
	JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan
WHERE
    no_register IN ('$no_ipd','$no_reg_asal')
and b.idkel_tind NOT IN (21,23)
ORDER BY FIELD(jenis_tindakan, 'Sewa Kamar%') DESC)
UNION ALL
(SELECT 
    COALESCE(no_ok, 'On Progress') AS no_ok,
    a.id_pemeriksaan_ok,
    a.id_tindakan,
    SUM(a.biaya_ok) as biaya_ok,
    (Select nama_kel from kel_tind where idkel_tind=b.idkel_tind) as jenis_tindakan,
    a.id_dokter,
    a.id_opr_anes,
    a.id_dok_anes,
    a.jns_anes,
    a.id_dok_anak,
    SUM(a.qty) as qty,
    SUM(a.vtot) as vtot,
    '' AS nm_dokter,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_opr_anes) AS nm_opr_anes,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dok_anes) AS nm_dok_anes,
    (SELECT 
            nm_dokter AS nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dok_anak) AS nm_dok_anak
FROM
    pemeriksaan_operasi a
	JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan
WHERE
    no_register IN ('$no_ipd','$no_reg_asal')
    and b.idkel_tind IN (21,23)
    group by b.idkel_tind)");
		return $data->result_array();
	}

	//and jenis_tindakan not like '%MATKES%'
	public function get_list_tind_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			and jenis_tindakan not like '%MATKES%'");
		return $data->result_array();
	}

	public function get_list_matkes_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
				FROM pemeriksaan_operasi 
				WHERE no_register in ('$no_ipd','$no_reg_asal')
				and jenis_tindakan like '%MATKES%'");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_lab is not null
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1' and a.no_lab is not null
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_lab_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_lab is not null
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_all_pa_pasien($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd')
			and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			group by no_pa
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan not like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_usg_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_usg_pasien($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_radiologi_pasien($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd')
			and a.no_rad is not null			
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register ='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_rad is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_cetak_rad_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_rad
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			and a.no_rad is not null
			group by no_rad
			order by no_rad asc
			");
		return $data->result_array();
	}	

	public function get_cetak_rad_pasien_umum($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_rad
			from pemeriksaan_radiologi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			and a.no_rad is not null
			group by no_rad
			order by no_rad asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien($no_ipd,$no_reg_asal=''){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register = '$no_ipd' 			
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_bpjs($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register in ('$no_ipd', '$no_reg_asal') 			
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_resep_pasien($no_ipd){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register in ('$no_ipd')
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register='$no_ipd'
			and cetak_kwitansi <> 1
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_tindakan_ird_pasien($no_reg_asal){
		$data=$this->db->query("
			select a.*,b.nm_dokter, c.nmtindakan as nama_tindakan
			from tindakan_ird as a
			left join data_dokter as b on a.id_dokter = b.id_dokter
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.no_register = '$no_reg_asal'
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_pasien($no_reg_asal){
		$data=$this->db->query("select a.*, b.nm_poli as nmpoli
			from pelayanan_poli as a
			JOIN poliklinik as b ON a.id_poli=b.id_poli
			where a.no_register = '$no_reg_asal'
			order by a.tgl_kunjungan asc
			");
		return $data->result_array();
	}

	//
	public function get_list_poli_rj_pasien_irj($no_reg_asal){
		$data=$this->db->query("select *
			from pelayanan_poli as a
			where a.no_register = '$no_reg_asal'
			and (a.id_dokter is not null and a.id_dokter!='')
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_dokter_pasien($no_reg_asal){
		$data=$this->db->query("select a.*, IF((SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) NOT IN ('Spesialis' , 'Dokter Jaga', 'Operasi')
            && (SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) != '',
        '',
        (SELECT 
                nm_dokter
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter)) AS nm_dokter 
			from pelayanan_poli as a, data_dokter b
			where a.id_dokter=b.id_dokter 
        	and b.ket!='Perawat' and a.no_register = '$no_reg_asal'
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_dokter_pasien_kelompok($no_reg_asal, $case){
		$query='';
		if($case=='kelompok'){
			// $query="and kel_tind.idkel_tind IN (0,25) GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ";
			$query="and d.idkel_tind IN (18,25,26,27) GROUP BY a.id_dokter, c.idkel_tind";
		} else {
			// $query="and kel_tind.idkel_tind=3 GROUP BY pelayanan_iri.idoprtr";
			$query="and d.idkel_tind=0 GROUP BY a.id_dokter, a.idtindakan";
		}

		$data=$this->db->query("SELECT a.*,c.idkel_tind,d.nama_kel, IF((SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) NOT IN ('Spesialis' , 'Dokter Jaga', 'Operasi')
            && (SELECT 
                ket
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter) != '',
        '',
        (SELECT 
                nm_dokter
            FROM
                data_dokter
            WHERE
                id_dokter = a.id_dokter)) AS nm_dokter 
			from pelayanan_poli as a, data_dokter b, jenis_tindakan c, kel_tind d
			where a.id_dokter=b.id_dokter 
		and c.idkel_tind=d.idkel_tind 
        and a.idtindakan=c.idtindakan
        	and b.ket!='Perawat' and a.no_register = '$no_reg_asal' 
        $query 
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_perawat_pasien($no_reg_asal){
		$data=$this->db->query("select *, (SELECT nm_poli from poliklinik where id_poli=a.id_poli) as nmpoli
			from pelayanan_poli as a
			where (SELECT ket from data_dokter where id_dokter=a.id_dokter)='Perawat' and a.no_register = '$no_reg_asal'
			order by a.tgl_kunjungan asc
			");
		return $data->result_array();
	}

	//new new new
	public function get_list_poli_rj_perawat_pasien_newest($no_reg_asal){
		$data=$this->db->query("SELECT 
    a.tgl_kunjungan,
    a.nmtindakan,
    a.nm_dokter,
    (Select nm_poli from poliklinik where id_poli=a.id_poli) as nmpoli,
    (a.vtot) AS vtot,
    SUM(a.biaya_alkes * a.qtyind) AS biaya_alkes,
    SUM(a.qtyind) AS qtyind,
    a.no_register
FROM
    pelayanan_poli AS a
WHERE
    (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dokter) = 'Perawat'
        or (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = a.id_dokter) = 'Bidan'
        AND a.no_register = '$no_reg_asal'
GROUP BY a.nm_dokter
ORDER BY a.tgl_kunjungan ASC");
		return $data->result_array();
	}

	public function get_list_poli_rj_pasien_iri($no_reg_asal){
		$data=$this->db->query("select *
			from pelayanan_poli as a
			where a.no_register = '$no_reg_asal'
			and (a.id_dokter is not null and a.id_dokter!='')
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	// pendapatan
	public function get_list_pasien_keluar_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT *
			FROM pasien_iri as a
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.xuser = '$user'			
			");
		//
		return $data->result_array();
	}

	public function get_list_pasien_keluar_ird_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT a.*,b.nama
			FROM irddaftar_ulang as a
			LEFT JOIN data_pasien as b on a.no_medrec = b.no_medrec
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.xcetak = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_irj_by_tanggalold($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT a.*,b.nama, c.nm_poli,
			(select SUM(vtot) from pemeriksaan_laboratorium where no_register=a.no_register and cetak_kwitansi=1) as vtot_lab_lunas,
			(select SUM(vtot) from pemeriksaan_patologianatomi where no_register=a.no_register and cetak_kwitansi=1) as vtot_pa_lunas,
			(select SUM(vtot) from pemeriksaan_radiologi where no_register=a.no_register and cetak_kwitansi=1) as vtot_rad_lunas,
			(select SUM(vtot) from resep_pasien where no_register=a.no_register and cetak_kwitansi=1) as vtot_obat_lunas,
			(select SUM(vtot) from pemeriksaan_operasi where no_register=a.no_register and cetak_kwitansi=1) as vtot_ok_lunas,
			(select SUM(vtot) from pemeriksaan_fisio where no_register=a.no_register and cetak_kwitansi=1) as vtot_fisio_lunas

			FROM daftar_ulang_irj as a
			LEFT JOIN data_pasien as b on a.no_medrec = b.no_medrec
			LEFT JOIN poliklinik as c ON c.id_poli=a.id_poli
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw >='$tgl_awal' AND a.tgl_cetak_kw<='$tgl_akhir'
			and a.xcetak = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
            SELECT a.*,b.nama, SUM(c.vtot) as vtotpoli, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, (SELECT nm_poli from poliklinik where id_poli=a.id_poli) as nm_poli, c.tgl_cetak_kw as tgl_cetak, a.xuser
			FROM daftar_ulang_irj as a, data_pasien as b, pelayanan_poli as c  
			where c.tgl_cetak_kw IS NOT NULL
            and a.no_medrec = b.no_medrec
            and a.no_register=c.no_register
			and LEFT(c.tgl_cetak_kw,16)>='$tgl_awal' AND LEFT(c.tgl_cetak_kw,16)<='$tgl_akhir'			
			and c.idtindakan in ('1B0105','1B0106','1B0104','1B0102' '1B0101', '1B0103')
            group by (a.no_register)
			");
		//and c.xuser = '$user'
		return $data->result_array();
	}


	public function get_list_pasien_luar_lab($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_lab,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join lab_header as b on a.no_register = b.no_register
			where a.lab = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_rad($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_rad,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join rad_header as b on a.no_register = b.no_register
			where a.rad = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_obat($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_obat,b.diskon,a.xupdate,b.tot_tuslah
			FROM pasien_luar as a
			left join resep_header as b on a.no_register = b.no_resgister
			where a.obat = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}


	public function get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar BETWEEN '$tgl_awal' and '$tgl_akhir'
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	public function get_total_pendapatan_by_bulan($tgl_awal){
		// $data=$this->db->query("
		// 	SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl, SUM(a.diskon) as vtot_diskon_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'TUNAI' THEN vtot ELSE 0 END) AS vtot_tunai_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'KREDIT' THEN vtot ELSE 0 END) AS vtot_kredit_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'TUNAI' THEN diskon ELSE 0 END) AS vtot_diskon_tunai_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'KREDIT' THEN diskon ELSE 0 END) AS vtot_diskon_kredit_per_tgl

		// 	FROM pasien_iri as a
		// 	where a.tgl_keluar IS NOT NULL
		// 	and a.tgl_keluar LIKE '$tgl_awal-%'
		// 	GROUP BY tgl_keluar
		// 	");

		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl, SUM(a.diskon) as vtot_diskon_per_tgl,
			SUM(a.nilai_kkkd) as vtot_dibayar_kartu_kredit,
			SUM(a.tunai) as vtot_dibayar_pasien,
			SUM(a.total_charge_kkkd) as vtot_charge_kk

			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar LIKE '$tgl_awal-%'
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	public function get_total_pendapatan_by_tahun($tgl_awal){
		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar LIKE '$tgl_awal-%''
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	// kamari
	public function get_empty_diagnosa_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto, (select pangkat from tni_pangkat where pangkat_id=c.pkt_id) as pangkat, (select kst_nama from tni_kesatuan where kst_id=c.kst_id) as kesatuan, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan, 
				(SELECT nmruang from ruang where idrg=d.idrg) as nmruang
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar = '$tgl_akhir'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_medrec_range_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto, (select pangkat from tni_pangkat where pangkat_id=c.pkt_id) as pangkat, (select kst_nama from tni_kesatuan where kst_id=c.kst_id) as kesatuan, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan, 
				d.nmruang as nmruang
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang as d on a.idrg = d.idrg
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_medrec_year($tahun){
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto, (select pangkat from tni_pangkat where pangkat_id=c.pkt_id) as pangkat, (select kst_nama from tni_kesatuan where kst_id=c.kst_id) as kesatuan, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan, 
				d.nmruang as nmruang
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang as d on a.idrg = d.idrg
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar like '$tahun-%'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_empty_diagnosa_by_month($bulan){
		// $data=$this->db->query("
		// 	SELECT *
		// 		FROM pasien_iri as a
		// 		LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
		// 		WHERE a.tgl_keluar is not null
		// 		and a.tgl_keluar like '$bulan-%'
		// 	");
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.sex , c.no_cm as no_medrec_minto, (select pangkat from tni_pangkat where pangkat_id=c.pkt_id) as pangkat, (select kst_nama from tni_kesatuan where kst_id=c.kst_id) as kesatuan, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			(SELECT nmruang from ruang where idrg=d.idrg) as nmruang,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar like '$bulan-%'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	// public function get_empty_diagnosa_by_year($tahun){
	// 	$data=$this->db->query("
	// 		SELECT *
	// 			FROM pasien_iri as a
	// 			LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
	// 			WHERE a.tgl_keluar is not null
	// 			and a.tgl_keluar like '$tahun-%'
	// 		");
	// 	return $data->result_array();
	// }

	public function select_pasien_like($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select *
			from pasien_iri as a
			where a.no_ipd like '%$value%'
			and tgl_keluar is null
			");
		return $data->result_array();
	}

	public function select_diagnosa_iri_by_id($id){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select *
			from diagnosa_iri as a
			where a.no_register = '$id'
			");
		return $data->result_array();
	}


	//flag kwintansi
	public function flag_kwintasi_rad_terbayar($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_radiologi
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_lab_terbayar($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_laboratorium
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_obat_terbayar($no_ipd){
		$data=$this->db->query("
			update resep_pasien
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_ird_terbayar($no_register,$tgl_cetak,$lunas){
		$data=$this->db->query("
			update irddaftar_ulang
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak',lunas = $lunas
			where no_register = '$no_register'
			");
	}

	public function flag_irj_terbayar($no_register,$tgl_cetak,$lunas){
		$data=$this->db->query("
			update daftar_ulang_irj
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak', lunas = $lunas
			where no_register = '$no_register'
			");

	}

	function get_data_ruangan($no_ipd){
		return $this->db->query("SELECT a.no_ipd AS no_ipd , a.nama AS nama , a.klsiri AS klsiri , a.bed AS bed , b.nmruang AS nmruang , c.idrgiri AS idrgiri , d.no_cm AS no_cm FROM pasien_iri a LEFT JOIN ruang b ON LEFT(a.bed , 4) = b.idrg LEFT JOIN ruang_iri c ON( a.no_ipd = c.no_ipd AND a.bed = c.bed) LEFT JOIN data_pasien AS d ON a.no_cm = d.no_medrec WHERE a.no_ipd = '$no_ipd'");
	}

	function get_data_tanggal($no_ipd){
		return $this->db->query("SELECT a.no_ipd AS no_ipd, d.no_cm AS no_cm, a.tgl_masuk FROM pasien_iri a LEFT JOIN data_pasien AS d ON a.no_cm = d.no_medrec WHERE a.no_ipd = '$no_ipd'");
	}

	public function get_all_kelas_with_empty_bed(){
		$data=$this->db->query("
			SELECT concat(a.idrg,'-',b.nmruang,'-',a.kelas) as text, count(*) 
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			where a.isi = 'N'
			group by a.kelas,a.idrg,b.nmruang");
		return $data->result_array();
	}

	public function update_bed($asal, $baru){
		$this->db->query("UPDATE bed SET isi ='N' WHERE bed = '$asal'");
		$this->db->query("UPDATE bed SET isi ='Y' WHERE bed = '$baru'");
		return true;
	}

	public function update_tanggal($no_ipd, $tgl){
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', ['tgl_masuk' => $tgl]); 
		return true;
	}

	public function update_tanggal_ruangiri($no_ipd, $tgl){
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('ruang_iri', ['tglmasukrg' => $tgl]); 
		return true;
	}

	public function update_ruangan_ruangiri($data, $idrgiri){
			$this->db->where('idrgiri', $idrgiri);
			$this->db->update('ruang_iri', $data); 
			return true;
	}

	public function update_ruangan_pasieniri($data1, $no_ipd){
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data1); 
			return true;
	}
	public function get_vtot_ruangan($id_tindakan, $kelas){
		return $this->db->query("SELECT total_tarif AS vtot FROM tarif_tindakan WHERE id_tindakan = '$id_tindakan' AND kelas = '$kelas'");
	}

	function get_roleid($userid){
		return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
	}

	function balikkan_keruangan($no_ipd){
		$this->db->query("UPDATE pasien_iri as a, ruang_iri as b
			set a.tgl_keluar = NULL, b.tglkeluarrg = NULL, b.statkeluarrg = NULL
			where
			a.no_ipd = '$no_ipd' and b.no_ipd='$no_ipd'
			and b.idrgiri=(SELECT MAX(idrgiri) from ruang_iri as c where c.no_ipd='$no_ipd')");
		return true;
	}

	//discharge
	public function get_discharge_patient_by_date($tgl_akhir){
		$data=$this->db->query("
			SELECT 
			    a.no_ipd, a.dokter, a.carabayar as jenis_bayar, h.nmkontraktor,group_concat( e.diagnosa ) AS list_diagnosa_tambahan, group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan,
			    d.no_nrp, d.no_cm as no_medrec_patria, d.sex, d.nama, d.tgl_lahir, b.kelas as klsiri, b.tglmasukrg as tgl_masuk, c.nmruang, f.pangkat, g.kst_nama as kesatuan, e.diagnosa, b.tglmasukrg, b.tglkeluarrg as tgl_keluar, a.brtlahir,
			    i.nm_diagnosa, a.diagnosa1, 
			    IF(b.statkeluarrg!='keluar','MUTASI','PULANG') as ket
			FROM
			    pasien_iri as a
			LEFT JOIN data_pasien as d ON a.no_cm = d.no_medrec  
			LEFT JOIN ruang_iri as b ON a.no_ipd=b.no_ipd
			LEFT JOIN ruang as c ON b.idrg=c.idrg

			LEFT JOIN tni_pangkat as f ON f.pangkat_id=d.pkt_id
			LEFT JOIN tni_kesatuan as g ON g.kst_id=d.kst_id
			LEFT JOIN kontraktor as h ON h.id_kontraktor=a.id_kontraktor
			LEFT JOIN icd1 as i on a.diagnosa1 = i.id_icd
			LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
			WHERE b.tglkeluarrg = '$tgl_akhir'
			GROUP BY b.idrgiri
			");
		return $data->result_array();
	}

	public function get_discharge_patient_by_month($bulan){
		// $data=$this->db->query("
		// 	SELECT *
		// 		FROM pasien_iri as a
		// 		LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
		// 		WHERE a.tgl_keluar is not null
		// 		and a.tgl_keluar like '$bulan-%'
		// 	");
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.sex , c.no_cm as no_medrec_patria, h.pangkat, g.kst_nama as kesatuan, f.nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan, IF(d.statkeluarrg!='keluar','MUTASI','PULANG') as ket,
			i.nmruang, group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd and a.idrg=d.idrg
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				LEFT JOIN kontraktor as f ON f.id_kontraktor=a.id_kontraktor
				LEFT JOIN tni_kesatuan as g ON g.kst_id=c.kst_id
				LEFT JOIN tni_pangkat as h ON h.pangkat_id=c.pkt_id
				LEFT JOIN ruang as i ON i.idrg=d.idrg
				WHERE d.tglkeluarrg is not null
				and d.tglkeluarrg like '$bulan-%'
				GROUP BY a.no_ipd			
			");
		return $data->result_array();
	}

	public function get_discharge_patient_by_year($tahun){
		$data=$this->db->query("
			SELECT *, IF(d.statkeluarrg!='keluar','MUTASI','PULANG') as ket
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
                LEFT JOIN ruang_iri as d ON a.no_ipd=d.no_ipd
				WHERE d.statkeluarrg is not null
				and d.statkeluarrg like '$tahun-%'			
			");
		return $data->result_array();
	}

	public function get_lap_per_kasir($tgl_awal, $tgl_akhir)
	{
		return $this->db->query("SELECT * FROM penerimaan_kasir_new where tanggal_jam BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY no_kwitansi")->result_array();
	}

	public function get_lap_per_kasir_new($tgl_awal, $tgl_akhir)
	{
		return $this->db->query("SELECT * FROM penerimaan_kasir_new where tanggal_jam BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY no_kwitansi")->result_array();
	}

	// public function get_lap_per_kasir_ok($tgl_awal, $tgl_akhir)
	// {
	// 	return $this->db->query("SELECT * FROM penerimaan_kasir_ok where tanggal_jam BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result_array();
	// }

	// public function get_lap_per_kasir_ok($tgl_awal, $tgl_akhir)
	// {
	// 	return $this->db->query("SELECT * FROM penerimaan_kasir_ok where tleft(tanggal_jam, 10)='$tgl' order by no_kwitansi")->result_array();
	// }

    public function get_lap_per_kasir_ok($tgl)
	{
		$besok = date('Y-m-d', strtotime("+1 day", strtotime($tgl)));
		return $this->db->query("SELECT * FROM penerimaan_kasir_ok_new where tanggal_jam >= '$tgl 20:00:00' and tanggal_jam <= '$besok 19:59:59' order by no_kwitansi")->result_array();
	}

	public function get_lap_per_kasir_penunjang($tgl)
	{
		$besok = date('Y-m-d', strtotime("+1 day", strtotime($tgl)));
		return $this->db->query("SELECT * FROM penerimaan_kasir_penunjang_new where tanggal_jam >= '$tgl 20:00:00' and tanggal_jam <= '$besok 19:59:59' order by no_kwitansi")->result_array();
	}
	public function get_shift()
	{
		return $this->db->query('SELECT * FROM shift')->result();
	}
	public function get_shift_by_id($id)
	{
		return $this->db->query('SELECT * FROM shift WHERE kd_shift = '.$id.'')->row();
	}

	public function get_no_kwitansi($jenis_kwitansi='RI',$no_register=null)
	{
		if ($no_register != null ) {
			$this->db->where('no_registrasi', $no_register);
		}

		$cek = $this->db->select('*')->from('no_kwitansi')->where('jenis_kwitansi', $jenis_kwitansi)->order_by('no_kwitansi', 'DESC')->get();

		if ($cek->num_rows() > 0) {
			return $cek;
		}else{
			return false;
		}
	}

	public function get_no_kwitansi_bpjs($jenis_kwitansi='BPJS', $no_register=null)
	{
		if ($no_register != null ) {
			$this->db->where('no_registrasi', $no_register);
		}

		$cek = $this->db->select('*')->from('no_kwitansi')->where('left(jenis_kwitansi, 4) =', $jenis_kwitansi)->order_by('no_kwitansi', 'DESC')->get();

		if ($cek->num_rows() > 0) {
			return $cek;
		}else{
			return false;
		}
	}

	public function insert_no_kwitansi($data)
	{
		$this->db->insert('no_kwitansi',$data);
	}
}
?>
