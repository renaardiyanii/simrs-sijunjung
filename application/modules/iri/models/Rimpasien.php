<?php
class Rimpasien extends CI_Model
{

	public function get_pelaksana_pasien_iri($no_ipd)
	{
		$data = $this->db->query("SELECT 
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

	public function get_jml_keluar_masuk_by_range_date($tgl_awal, $tgl_akhir)
	{
		$data = $this->db->query("
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

	public function delete_ruang_iri_by_ipd($no_ipd)
	{
		$data = $this->db->query("
			DELETE FROM ruang_iri
			WHERE no_ipd = '$no_ipd' 
			");
	}

	public function delete_pasien_iri($no_ipd)
	{
		$data = $this->db->query("
			DELETE FROM pasien_iri
			WHERE no_ipd = '$no_ipd' 
			");
	}

	public function get_matkes_ruang($noregister)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'NA01%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_ok($noregister)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'D%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_vk($noregister)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'BE%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_tindakan_perawat($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pelayanan_iri JOIN data_dokter 
		ON pelayanan_iri.idoprtr=data_dokter.id_dokter
		where data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'");
		return $data->result_array();
	}

	// public function get_pasien_pulang_by_date($tgl_awal) {
	// 	$data=$this->db->query("SELECT *
	// 	FROM 
	// 		pasien_iri 
	// 	WHERE
	// 		tgl_keluar = '2022-06-22'");

	// 	return $data->result_array();
	// }

	// public function get_pasien_pulang_by_bulan($tgl_awal) {
	// 	$data=$this->db->query("SELECT *
	// 	FROM 
	// 		pasien_iri 
	// 	WHERE
	// 		tgl_keluar LIKE '$tgl_awal%'");

	// 	return $data->result_array();
	// }

	// public function get_pasien_pulang_by_tahun($tgl_awal) {
	// 	$data=$this->db->query("SELECT *
	// 	FROM 
	// 		pasien_iri
	// 	WHERE
	// 		tgl_keluar LIKE '$tgl_awal%'");

	// 	return $data->result_array();
	// }

	public function get_detail_tindakan($id_tindakan, $kelas)
	{
		return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
and b.kelas='$kelas'");
	}

	public function get_detail_kelas($kelas)
	{
		return $this->db->query("select * from kelas where kelas='$kelas'");
	}

	public function get_persen_jasa_ruang($idrg)
	{
		return $this->db->query("select * from ruang where idrg='$idrg'");
	}

	public function get_jml_keluar_masuk_by_date($tgl_awal)
	{
		$data = $this->db->query("SELECT namaaksespjawabri1,namaaksespjawabri2,namaaksespjawabri3,to_char(a.tgl_masuk,'YYYY-MM-DD') as tgl, 
			DATE_PART('year', now()) - DATE_PART('year',b.tgl_lahir) as umur, substring(to_char(b.tgl_lahir, 'YYYY-MM-DD'),0,10) as tgl_lahir, a.no_ipd,b.no_cm,b.nama,o.id_poli,p.nm_poli,o.xuser,c.id_icd,c.nm_diagnosa,b.sex,b.alamat,k.nmkontraktor, 
			(select nm_dokter from data_dokter where id_dokter = a.id_dokter limit 1) as dokter, r.nmruang,'MASUK' as tipe_masuk, a.carabayar
			FROM pasien_iri as a 
			LEFT JOIN data_pasien as b on a.no_medrec = b.no_medrec 
			LEFT JOIN daftar_ulang_irj as o on a.noregasal = o.no_register 
			LEFT JOIN poliklinik as p on o.id_poli = p.id_poli 
			LEFT JOIN kontraktor as k on a.id_kontraktor = k.id_kontraktor 
			LEFT JOIN icd1 as c on a.diagnosa1 = c.id_icd 
			LEFT JOIN ruang as r on a.idrg = r.idrg 
			WHERE a.tgl_masuk = '$tgl_awal' 

			UNION SELECT namaaksespjawabri1,namaaksespjawabri2,namaaksespjawabri3,d.tgl_keluar as tgl, 
			DATE_PART('year', now()) - DATE_PART('year',e.tgl_lahir)as umur, substring(to_char(e.tgl_lahir, 'YYYY-MM-DD'),0,10) as tgl_lahir, d.no_ipd,e.no_cm,e.nama,g.nm_poli,j.id_poli,j.xuser,f.id_icd,f.nm_diagnosa,e.sex,e.alamat,z.nmkontraktor, 
			(select nm_dokter from data_dokter where id_dokter = d.id_dokter limit 1) as dokter, m.nmruang,'KELUAR' as tipe_masuk, d.carabayar
			FROM pasien_iri as d 
			LEFT JOIN data_pasien as e on d.no_medrec = e.no_medrec 
			LEFT JOIN daftar_ulang_irj as j on d.noregasal = j.no_register 
			LEFT JOIN kontraktor as z on d.id_kontraktor = z.id_kontraktor 
			LEFT JOIN ruang as m on d.idrg = m.idrg 
			LEFT JOIN icd1 as f on d.diagnosa1 = f.id_icd 
			LEFT JOIN poliklinik as g on j.id_poli = g.id_poli 
			WHERE d.tgl_keluar = '$tgl_awal'

			"); // di union di pasien_iri dari tgl_keluar di ganti tgl_masuk
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_bulan($tgl_awal)
	{
		$data = $this->db->query("SELECT h.*,
		NULLIF(h.tgl_keluar,to_char(h.tgl_masuk,'YYYY-MM')) as tanggal 
		FROM 
		(SELECT * FROM 
			 (select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar 
			 from pasien_iri as b 
			 where b.tgl_keluar= '$tgl_awal' 
			 GROUP BY b.tgl_keluar) as d 
		 LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk 
					from pasien_iri as a 
					where to_char(a.tgl_masuk,'YYYY-MM') = '$tgl_awal' 
					GROUP BY a.tgl_masuk) as e on d.tgl_keluar = to_char(e.tgl_masuk,'YYYY-MM') 
		 
		 UNION SELECT * FROM 
			 (select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar 
			from pasien_iri as b 
			where b.tgl_keluar = '$tgl_awal' 
			GROUP BY b.tgl_keluar) as d 
		 RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk 
					 from pasien_iri as a
					 where to_char(a.tgl_masuk,'YYYY-MM') like '$tgl_awal' 
					 GROUP BY a.tgl_masuk) as e on d.tgl_keluar = to_char(e.tgl_masuk,'YYYY-MM') ) as h order by tanggal asc
			");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_tahun($tgl_awal)
	{
		$data = $this->db->query("SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
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

	public function select_pasien_iri_all($userid)
	{
		$data = $this->db->query("SELECT DISTINCT
		a.no_ipd,
		c.no_cm,
		c.nama,
		c.sex,
		c.kotakabupaten,
		d.nmruang,
		b.kelas,
		a.bed,
		a.dokter,
		b.tglmasukrg,
		a.carabayar,
		k.nmkontraktor,
		a.ipdibu,
		a.verifikasi_plg,
		a.no_sep,
		a.pasien_anak,
		a.jatahklsiri,
		EXTRACT(EPOCH FROM c.tgl_lahir - NOW()) as umur,
		a.tgldaftarri,
		a.tgl_masuk,
		a.titip,
		a.selisih_tarif,
		a.wkt_masuk_rg,
		a.naik_1_tingkat,
		a.tgl_verif,
		rp.formjson->>'tanggal_perencanaan_pemulangan' as tanggal_perencanaan_pemulangan,
		diag.nm_diagnosa,
		(SELECT name FROM hmis_users WHERE a.user_verif = userid LIMIT 1) AS name_verif,
		( SELECT nm_dokter FROM data_dokter WHERE A.id_dokter = id_dokter LIMIT 1 ) AS name_dokter 
	FROM pasien_iri AS a
	LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
	INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
	LEFT JOIN ruang AS d ON a.idrg = d.idrg
	LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
	LEFT OUTER JOIN rencana_pemulangan_iri rp ON a.no_ipd = rp.no_ipd
	LEFT OUTER JOIN icd1 diag ON a.diagmasuk = diag.id_icd
	LEFT JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
	WHERE a.tgl_keluar IS NULL
		-- AND (diag.deleted = 0 OR diag.nm_diagnosa IS NULL)
		AND (b.tglkeluarrg IS NULL or TO_CHAR(b.tglkeluarrg, 'YYYY-MM-dd') = '')
		AND a.mutasi IS NULL
		AND e.userid = '$userid'
	ORDER BY a.no_ipd ASC;
	");

		return $data->result_array();
	}

	public function select_pasien_iri_user($userid)
	{ #
		// TIMESTAMPDIFF(YEAR , c.tgl_lahir, NOW() )as umur
		$data = $this->db->query("SELECT
									a.no_ipd,
									c.no_cm,
									c.nama,
									d.nmruang,
									b.kelas,
									a.bed,
									a.dokter,
									b.tglmasukrg,
									a.carabayar,
									k.nmkontraktor,
									EXTRACT(EPOCH FROM c.tgl_lahir-NOW()) as umur
									
								FROM
									pasien_iri AS a
									LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
									INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
									LEFT JOIN ruang AS d ON a.idrg = d.idrg
									INNER JOIN dyn_ruang_user AS e ON a.idrg = e.id_ruang
									LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
								WHERE
									a.tgl_keluar IS NULL
									AND b.tglkeluarrg IS NULL 
									AND e.userid = '$userid'
									AND a.mutasi is null
									AND ( a.ipdibu = '' OR a.ipdibu IS NULL ) 
								ORDER BY
									a.no_ipd ASC");
		return $data->result_array();
	}

	public function select_pasien_iri_lokasi($lokasi)
	{
		$data = $this->db->query("SELECT
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

	public function select_pasien_pulang_iri_lokasi($lokasi)
	{
		$data = $this->db->query("SELECT
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

	public function select_pasien_pulang_iri_tgl($date1, $date2, $lokasi)
	{
		$data = $this->db->query("SELECT
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

	public function select_ruang_user($userid)
	{
		return $this->db->query("select nm_ruang as akses_ruang from dyn_ruang_user where userid='$userid'
			");
	}
	public function get_bayi_by_ipd_ibu($ipdibu)
	{
		$data = $this->db->query("select *
			from pasien_iri as a
			where a.ipdibu = '$ipdibu'
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_all()
	{
		$data = $this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_bpjs()
	{
		$data = $this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			and a.no_sep is not null
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_belum_cetak_kwitansi($date)
	{
		$data = $this->db->query("SELECT DISTINCT a.*, c.*, CASE
				WHEN a.titip = '1' THEN 'TITIP'
				ELSE '' END AS status_titip
			FROM pasien_iri AS a
			INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			where a.tgl_keluar IS NOT NULL
			AND LEFT(A.tgl_keluar,10) = '$date'
			AND A.carabayar = 'UMUM'
			ORDER BY 
			a.tgl_keluar DESC
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_belum_cetak_kwitansi_bpjs($date)
	{
		$data = $this->db->query("SELECT DISTINCT a.*, c.*, CASE
				WHEN a.titip = '1' THEN 'TITIP'
				ELSE '' END AS status_titip
			FROM pasien_iri AS a
			INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			where a.tgl_keluar IS NOT NULL
			AND LEFT(A.tgl_keluar,10) = '$date'
			AND A.carabayar != 'UMUM'
			ORDER BY 
			a.tgl_keluar DESC
			");
		return $data->result_array();
	}


	public function select_pasien_iri_pulang_belum_cetak_kwitansi_by_date($date)
	{
		$data = $this->db->query("SELECT DISTINCT A.*,
				C.*,
				CASE
						
						WHEN A.titip = '1' THEN
						'TITIP' ELSE'' 
					END AS status_titip 
				FROM
					pasien_iri
					AS A INNER JOIN data_pasien AS C ON A.no_medrec = C.no_medrec 
					where A.tgl_keluar IS NOT NULL 
					AND left(A.tgl_keluar,10) = '$date' 
					AND A.carabayar = 'UMUM'
				ORDER BY
					A.tgl_keluar DESC
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_belum_cetak_kwitansi_by_date_bpjs($date)
	{
		$data = $this->db->query("SELECT DISTINCT A.*,
				C.*,
				CASE
						
						WHEN A.titip = '1' THEN
						'TITIP' ELSE'' 
					END AS status_titip 
				FROM
					pasien_iri
					AS A INNER JOIN data_pasien AS C ON A.no_medrec = C.no_medrec 
					where A.tgl_keluar IS NOT NULL 
					AND left(A.tgl_keluar,10) = '$date' 
					AND A.carabayar != 'UMUM'
				ORDER BY
					A.tgl_keluar DESC
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_sudah_cetak_kwitansi()
	{
		$data = $this->db->query("
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

	public function get_list_ruang_mutasi_pasien_bayi($no_ipd)
	{
		$data = $this->db->query("SELECT DISTINCT A.*,
			b.nmruang,
			C.tarif as total_tarif,
			C.tarif as tarif_jatah,
			C.tarif as tarif_jatah_bpjs,
			C.tarif as tarif_jatah_iks
			FROM
				ruang_iri A,
				ruang b,
				jenis_tindakan_new C 
			WHERE
				A.idrg = b.idrg 
				AND C.idtindakan = concat ( '1A', A.idrg ) 
				AND B.kelas = A.kelas 
				AND A.no_ipd = '$no_ipd'");
		return $data->result_array();
	}

	public function get_list_ruang_mutasi_pasien_($no_ipd)
	{
		$data = $this->db->query("SELECT DISTINCT A
			.*,
			b.nmruang,
			C.total_tarif,
			(SELECT
				x.total_tarif
			FROM
				tarif_tindakan AS x,
				pasien_iri AS y
			WHERE
				a.idrg = b.idrg 
				AND x.id_tindakan = concat ( '1A', a.idrg ) 
				AND x.kelas = y.jatahklsiri
				AND y.no_ipd = a.no_ipd 
				AND a.no_ipd = '$no_ipd' LIMIT 1
			) AS tarif_jatah,
			c.tarif_bpjs,
			(SELECT
				x.tarif_bpjs
			FROM
				tarif_tindakan AS x,
				pasien_iri AS y
			WHERE
				a.idrg = b.idrg 
				AND x.id_tindakan = concat ( '1A', a.idrg ) 
				AND x.kelas = y.jatahklsiri
				AND y.no_ipd = a.no_ipd 
				AND a.no_ipd = '$no_ipd' LIMIT 1
			) AS tarif_jatah_bpjs,
			c.tarif_iks,
			(SELECT
				x.tarif_iks
			FROM
				tarif_tindakan AS x,
				pasien_iri AS y
			WHERE
				a.idrg = b.idrg 
				AND x.id_tindakan = concat ( '1A', a.idrg ) 
				AND x.kelas = y.jatahklsiri
				AND y.no_ipd = a.no_ipd 
				AND a.no_ipd = '$no_ipd' LIMIT 1
			) AS tarif_jatah_iks
		FROM
			ruang_iri A,
			ruang b,
			tarif_tindakan C 
		WHERE
			A.idrg = b.idrg 
			AND C.id_tindakan = concat ( '1A', A.idrg ) 
			AND C.kelas = A.kelas 
			AND A.no_ipd = '$no_ipd'");

		return $data->result_array();
	}

	public function get_list_ruang_mutasi_pasien($no_ipd)
	{
		$data = $this->db->query("SELECT DISTINCT A.*,
				b.nmruang,
				C.tarif as total_tarif,
				C.tarif as tarif_jatah,
				C.tarif as tarif_jatah_bpjs,
				C.tarif as tarif_jatah_iks
				FROM
					ruang_iri A,
					ruang b,
					jenis_tindakan_new C 
				WHERE
					A.idrg = b.idrg 
					AND C.idtindakan = concat ( '1A', A.idrg ) 
					AND B.kelas = A.kelas 
					AND A.no_ipd = '$no_ipd'");

		return $data->result_array();
	}

	public function get_list_lokasi_mutasi_pasien($no_ipd)
	{
		$data = $this->db->query("select distinct(b.lokasi), b.nmruang,a.tglmasukrg
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
	public function get_list_lab_pasien($no_ipd, $no_reg_asal = null)
	{
		if ($no_reg_asal != null) {
			$no_asal = "OR a.no_register = '$no_reg_asal'";
		} else {
			$no_asal = "";
		}
		$data = $this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register = '$no_ipd' $no_asal
			and (a.cara_bayar='BPJS' or a.cara_bayar='KERJASAMA' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_lab is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_lab_pasien($no_ipd)
	{
		$data = $this->db->query("select *
		from pemeriksaan_laboratorium as a
		where a.no_register = '$no_ipd'
		and a.no_lab is not null
		order by xupdate asc");
		return $data->result_array();
	}

	public function get_patient_doctor($no_ipd)
	{
		$data = $this->db->query("select distinct(idoprtr) from pelayanan_iri where no_ipd='$no_ipd' and idoprtr!=''");
		return $data->result_array();
	}

	public function get_list_ok_pasien($no_ipd, $no_reg_asal)
	{
		// $data=$this->db->query("SELECT tgl_kunjungan as tgl_operasi, COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
		// 	FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
		// 	order by jenis_tindakan asc");
		// return $data->result_array();

		$data = $this->db->query("SELECT tgl_kunjungan as tgl_operasi, 
		COALESCE(no_ok, 0) AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, 
		(select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter limit 1) as nm_dokter, 
		(select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes limit 1) as nm_opr_anes, 
		(select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes limit 1) as nm_dok_anes, 
		(select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak limit 1) as nm_dok_anak 
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			order by jenis_tindakan asc");
		return $data->result_array();
	}

	public function get_list_all_ok_pasien($no_ipd)
	{
		$data = $this->db->query("SELECT COALESCE(no_ok, 0) AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
			FROM pemeriksaan_operasi WHERE no_register = '$no_ipd'
			order by jenis_tindakan asc");
		return $data->result_array();
	}

	public function get_list_ok_pasien_newest($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("(SELECT COALESCE(no_ok, 0) AS no_ok, a.id_pemeriksaan_ok, a.id_tindakan, a.biaya_ok, 
		case when cast(b.idkel_tind as integer) IN (11,12,13) then
		  (Select nama_kel from kel_tind where idkel_tind=b.idkel_tind) else
		  a.jenis_tindakan end as jenis_tindakan, 
	a.id_dokter, a.id_opr_anes, a.id_dok_anes, a.jns_anes, a.id_dok_anak, a.qty, a.vtot, 
		case when (SELECT ket FROM data_dokter WHERE id_dokter = a.id_dokter) NOT IN ('Spesialis' , 'Dokter Jaga', 'Operasi') and (SELECT ket FROM data_dokter WHERE id_dokter = a.id_dokter) != '' then 
		  '' else (SELECT nm_dokter FROM data_dokter WHERE id_dokter = a.id_dokter) end AS nm_dokter, 
	(SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_opr_anes) AS nm_opr_anes, (SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_dok_anes) AS nm_dok_anes, (SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_dok_anak) AS nm_dok_anak 
   FROM pemeriksaan_operasi a 
	JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan 
	WHERE no_register IN ('$no_ipd','$no_reg_asal') ) 
	
	UNION ALL (SELECT COALESCE(no_ok, 0) AS no_ok, a.id_pemeriksaan_ok, a.id_tindakan, SUM(a.biaya_ok) as biaya_ok, (Select nama_kel from kel_tind where idkel_tind=b.idkel_tind) as jenis_tindakan, a.id_dokter, a.id_opr_anes, a.id_dok_anes, a.jns_anes, a.id_dok_anak, SUM(a.qty) as qty, SUM(a.vtot) as vtot, '' AS nm_dokter, (SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_opr_anes) AS nm_opr_anes, (SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_dok_anes) AS nm_dok_anes, (SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = a.id_dok_anak) AS nm_dok_anak 
			   FROM pemeriksaan_operasi a 
			   JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan 
			   WHERE no_register IN ('$no_ipd','$no_reg_asal')
			   group by b.idkel_tind,no_ok,a.id_pemeriksaan_ok, a.id_tindakan, a.id_dokter, a.id_opr_anes, a.id_dok_anes, a.jns_anes, a.id_dok_anak)");
		return $data->result_array();
	}

	//and jenis_tindakan not like '%MATKES%'
	public function get_list_tind_ok_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("SELECT COALESCE(no_ok, '0') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			and jenis_tindakan not like '%MATKES%'");
		return $data->result_array();
	}

	public function get_list_matkes_ok_pasien($no_ipd, $no_reg_asal)
	{
		// $data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
		// 		FROM pemeriksaan_operasi 
		// 		WHERE no_register in ('$no_ipd','$no_reg_asal')
		// 		and jenis_tindakan like '%MATKES%'");
		// return $data->result_array();

		$data = $this->db->query("SELECT COALESCE(no_ok, 0) AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
				FROM pemeriksaan_operasi 
				WHERE no_register in ('$no_ipd','$no_reg_asal')
				and jenis_tindakan like '%MATKES%'");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi is null and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_lab is not null
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi is null and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1' and a.no_lab is not null
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_lab_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_lab is not null
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_all_pa_pasien($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd')
			and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			group by no_pa
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan not like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_elektromedik_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from pemeriksaan_elektromedik as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_em is not null
			and a.jenis_tindakan not like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_usg_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_usg_pasien($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_radiologi_pasien($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register = '$no_ipd'
			and a.no_rad is not null			
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register ='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_rad is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_cetak_rad_pasien($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select no_rad
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

	public function get_cetak_rad_pasien_umum($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select no_rad
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

	public function get_list_resep_pasien($no_ipd, $no_reg_asal = '')
	{
		$data = $this->db->query("select *
			from resep_pasien as a
			where a.no_register = '$no_ipd' 			
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_bpjs($no_ipd, $no_reg_asal)
	{
		$data = $this->db->query("select *
			from resep_pasien as a
			where a.no_register in ('$no_ipd', '$no_reg_asal') 			
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_resep_pasien($no_ipd)
	{
		$data = $this->db->query("select *
			from resep_pasien as a
			where a.no_register = '$no_ipd'
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_umum($no_ipd)
	{
		$data = $this->db->query("select *
			from resep_pasien as a
			where a.no_register='$no_ipd'
			and cetak_kwitansi <> 1
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_tindakan_ird_pasien($no_reg_asal)
	{
		// $data=$this->db->query("
		// 	select a.*,b.nm_dokter, c.nmtindakan as nama_tindakan
		// 	from tindakan_ird as a
		// 	left join data_dokter as b on a.id_dokter = b.id_dokter
		// 	left join jenis_tindakan as c on a.idtindakan = c.idtindakan
		// 	where a.no_register = '$no_reg_asal'
		// 	order by tgl_kunjungan asc
		// 	");
		// return $data->result_array();

		$data = $this->db->query("
		select a.*,b.nm_dokter, c.nmtindakan as nama_tindakan
		from tindakan_ird as a
		left join data_dokter as b on CAST(a.id_dokter AS INTEGER) = b.id_dokter
		left join jenis_tindakan as c on a.idtindakan = c.idtindakan
		where a.no_register = '$no_reg_asal'
		order by tgl_kunjungan asc
		");
		return $data->result_array();
	}

	public function get_list_poli_rj_pasien($no_reg_asal)
	{
		$data = $this->db->query("select a.*, b.nm_poli as nmpoli
			from pelayanan_poli as a
			JOIN poliklinik as b ON a.id_poli=b.id_poli
			where a.no_register = '$no_reg_asal'
			order by a.tgl_kunjungan asc
			");
		return $data->result_array();
	}

	//
	public function get_list_poli_rj_pasien_irj($no_reg_asal)
	{
		$data = $this->db->query("select *
			from pelayanan_poli as a
			where a.no_register = '$no_reg_asal'
			and (a.id_dokter is not null and a.id_dokter!='')
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_dokter_pasien($no_reg_asal)
	{
		$data = $this->db->query("select a.*, IF((SELECT 
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

	public function get_list_poli_rj_dokter_pasien_kelompok($no_reg_asal, $case)
	{
		$query = '';
		if ($case == 'kelompok') {
			// $query="and kel_tind.idkel_tind IN (0,25) GROUP BY pelayanan_iri.idoprtr, jenis_tindakan.idkel_tind ";
			$query = "and d.idkel_tind IN (18,25,26,27) GROUP BY a.id_dokter, c.idkel_tind";
		} else {
			// $query="and kel_tind.idkel_tind=3 GROUP BY pelayanan_iri.idoprtr";
			$query = "and d.idkel_tind=0 GROUP BY a.id_dokter, a.idtindakan";
		}

		$data = $this->db->query("SELECT a.*,c.idkel_tind,d.nama_kel, IF((SELECT 
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

	public function get_list_poli_rj_perawat_pasien($no_reg_asal)
	{
		$data = $this->db->query("select *, (SELECT nm_poli from poliklinik where id_poli=a.id_poli) as nmpoli
			from pelayanan_poli as a
			where (SELECT ket from data_dokter where id_dokter=a.id_dokter)='Perawat' and a.no_register = '$no_reg_asal'
			order by a.tgl_kunjungan asc
			");
		return $data->result_array();
	}

	//new new new
	public function get_list_poli_rj_perawat_pasien_newest($no_reg_asal)
	{
		$data = $this->db->query("SELECT 
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

	public function get_list_poli_rj_pasien_iri($no_reg_asal)
	{
		$data = $this->db->query("select *
			from pelayanan_poli as a
			where a.no_register = '$no_reg_asal'
			and (a.id_dokter is not null and a.id_dokter!='')
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	// pendapatan
	public function get_list_pasien_keluar_by_tanggal($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xuser = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
			SELECT *
			FROM pasien_iri as a
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			 $texa			
			");
		//
		return $data->result_array();
	}

	public function get_list_pasien_keluar_ird_by_tanggal($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xuser = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
			SELECT a.*,b.nama
			FROM irddaftar_ulang as a
			LEFT JOIN data_pasien as b on cast(a.no_medrec as integer) = b.no_medrec
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			 $texa
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_irj_by_tanggalold($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xcetak = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
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
			and to_char(a.tgl_cetak_kw,'YYYY-MM-DD') >='$tgl_awal' AND to_char(a.tgl_cetak_kw,'YYYY-MM-DD') <='$tgl_akhir'
			 $texa
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_irj_by_tanggal($tgl_awal, $tgl_akhir, $user)
	{
		$data = $this->db->query("
		SELECT a.*,b.nama, SUM(c.vtot) as vtotpoli, 
		(SELECT nmkontraktor 
			 from kontraktor
			 where id_kontraktor=a.id_kontraktor) as nmkontraktor, (
				SELECT nm_poli 
				from poliklinik 
				where id_poli=a.id_poli) 
	as nm_poli, c.tgl_cetak_kw as tgl_cetak, a.xuser 
	FROM daftar_ulang_irj as a, data_pasien as b, pelayanan_poli as c 
	where c.tgl_cetak_kw IS NOT NULL 
	and a.no_medrec = b.no_medrec 
	and a.no_register=c.no_register 
	and TO_CHAR(c.tgl_cetak_kw,'YYYY-MM-DD HH24:MI:SS')>='$tgl_awal' 
	AND TO_CHAR(c.tgl_cetak_kw,'YYYY-MM-DD HH24:MI:SS')<='$tgl_akhir' 
	and c.idtindakan in ('1B0105','1B0106','1B0104','1B0102' ,'1B0101', '1B0103') 
	group by (a.no_register,b.nama,tgl_cetak)
			");
		//and c.xuser = '$user'
		return $data->result_array();
	}


	public function get_list_pasien_luar_lab($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xuser = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_lab,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join lab_header as b on a.no_register = b.no_register
			where a.lab = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			 $texa
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_rad($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xuser = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_rad,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join rad_header as b on a.no_register = b.no_register
			where a.rad = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			 $texa
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_obat($tgl_awal, $tgl_akhir, $user)
	{
		if ($user != '') {
			$texa = " and a.xuser = '$user'";
		} else {
			$texa = "";
		}
		$data = $this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_obat,b.diskon,a.xupdate,b.tot_tuslah
			FROM pasien_luar as a
			left join resep_header as b on a.no_register = b.no_resgister
			where a.obat = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			 $texa
			");
		return $data->result_array();
	}


	public function get_total_pendapatan_by_range_date($tgl_awal, $tgl_akhir)
	{
		$data = $this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar BETWEEN '$tgl_awal' and '$tgl_akhir'
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	public function get_tarif_jatahkls_inacbg_new($jatahkls)
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new 
		WHERE
			kelas = '$jatahkls'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_jatahkls_inacbg($jatahkls)
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new_v2
		WHERE
			kelas = '$jatahkls' UNION 
		SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			tipe_rs
		FROM
			tarif_inacbg_new_v1
		WHERE
			kelas = '$jatahkls'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_kelas_inacbg($kls)
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new_v2
		WHERE
			kelas = '$kls' UNION 
		SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			tipe_rs
		FROM
			tarif_inacbg_new_v1
		WHERE
			kelas = '$kls'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_kelas_inacbg_new($kls)
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new 
		WHERE
			kelas = '$kls'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_inacbg_kelas_satu()
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new 
		WHERE
			kelas = 'I'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_inacbg_kelas_dua()
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new 
		WHERE
			kelas = 'II'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_vip()
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new_v2 
		WHERE
			kelas = 'I' UNION 
		SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			tipe_rs
		FROM
			tarif_inacbg_new_v1
		WHERE
			kelas = 'I'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_tarif_vip_new()
	{
		return $this->db->query("SELECT
			kd_inacbg,
			uraian,
			kelas,
			tarif,
			'A' AS tipe_rs
		FROM
			tarif_inacbg_new 
		WHERE
			kelas = 'I'
		ORDER BY
			kd_inacbg ASC");
	}

	public function get_total_pendapatan_by_bulan($tgl_awal)
	{
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

		$data = $this->db->query("
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

	public function get_total_pendapatan_by_tahun($tgl_awal)
	{
		$data = $this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar LIKE '$tgl_awal-%''
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	// kamari
	public function get_empty_diagnosa_by_date($tgl_awal, $tgl_akhir)
	{
		$data = $this->db->query("
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

		// $data=$this->db->query("
		// SELECT a.*,b.*,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, concat( e.diagnosa ) AS list_diagnosa_tambahan, concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan, (SELECT nmruang from ruang where idrg=d.idrg) as nmruang FROM pasien_iri as a LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register WHERE a.tgl_keluar is not null and a.tgl_keluar = '$tgl_akhir' 
		// ");
		return $data->result_array();
	}

	public function get_medrec_range_date_by_medrec($medrec)
	{
		$data = $this->db->query("SELECT A
			.user_plg,
			A.tgl_masuk,
			A.tgl_keluar,
			(select nm_dokter from data_dokter where a.id_dokter = data_dokter.id_dokter ) as dokter,
			A.no_ipd,
			A.nama,
			A.klsiri,
			A.carabayar,
			A.nm_ruang,
			b.id_icd,
			b.nm_diagnosa,
			C.tgl_lahir,
			C.sex,
			C.no_cm AS no_medrec_minto,
			( SELECT nmkontraktor FROM kontraktor WHERE id_kontraktor = A.id_kontraktor ) AS nmkontraktor,
			string_agg ( e.diagnosa, ',' ) AS list_diagnosa_tambahan,
			string_agg ( e.id_diagnosa, ',' ) AS list_id_diagnosa_tambahan,
			d.nmruang AS nmruang,
			a.lengkap,
			a.tgl_dilengkapi,
			a.xuser,
			hm.name AS verifikator
		FROM
			pasien_iri
			AS A LEFT OUTER JOIN icd1 AS b ON A.diagnosa1 = b.id_icd
			LEFT JOIN data_pasien AS C ON A.no_medrec = C.no_medrec
			LEFT JOIN ruang AS d ON A.idrg = d.idrg
			LEFT OUTER JOIN diagnosa_iri AS e ON A.no_ipd = e.no_register 
			LEFT OUTER JOIN hmis_users AS hm ON hm.userid = a.user_verif
		WHERE
			A.tgl_keluar IS NOT NULL 
			AND c.no_cm = '$medrec' 
		GROUP BY
			A.no_ipd,
			A.nama,
			A.klsiri,
			A.carabayar,
			A.nm_ruang,
			b.id_icd,
			b.nm_diagnosa,
			C.tgl_lahir,
			C.sex,
			C.no_cm,
			A.id_kontraktor,
			d.nmruang,
			A.tgl_masuk,
			A.tgl_keluar,
			A.id_dokter,
			A.user_plg,
			a.lengkap,
			a.tgl_dilengkapi,
			a.xuser,
			hm.name
		ORDER BY
			A.tgl_keluar DESC");

		return $data;
	}

	public function get_medrec_range_date($tgl_awal, $tgl_akhir, $where = "", $admin = 0)
	{
		// if($admin == 1){
		// 	$data = $this->db->query("
		// 	SELECT a.tgl_masuk,a.tgl_keluar,a.dokter,a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto,
		// 		(SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, string_agg( e.diagnosa,',' ) AS list_diagnosa_tambahan,
		// 		string_agg( e.id_diagnosa,',' ) AS list_id_diagnosa_tambahan, d.nmruang as nmruang FROM pasien_iri as a LEFT JOIN icd1 as b
		// 		on a.diagnosa1 = b.id_icd LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec LEFT JOIN ruang as d on a.idrg = d.idrg
		// 		LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register WHERE a.tgl_keluar is not null and a.tgl_keluar BETWEEN '$tgl_awal' 
		// 		AND '$tgl_akhir' AND a.cetak_kwitansi = '1'
		// 		GROUP BY a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm,a.id_kontraktor,d.nmruang,a.tgl_masuk,a.tgl_keluar,
		// 		a.dokter
		// 		ORDER BY a.tgl_keluar DESC
		// 	");
		// }else{
		// 	if($where==""){
		// $data=$this->db->query("
		// SELECT a.tgl_masuk,a.tgl_keluar,a.dokter,a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto,
		// (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, string_agg( e.diagnosa,',' ) AS list_diagnosa_tambahan,
		// string_agg( e.id_diagnosa,',' ) AS list_id_diagnosa_tambahan, d.nmruang as nmruang FROM pasien_iri as a LEFT JOIN icd1 as b
		// on a.diagnosa1 = b.id_icd LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec LEFT JOIN ruang as d on a.idrg = d.idrg
		// LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register WHERE a.tgl_keluar is not null and a.tgl_keluar BETWEEN '$tgl_awal' 
		// AND '$tgl_akhir' AND a.idrg = 0
		// GROUP BY a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm,a.id_kontraktor,d.nmruang,a.tgl_masuk,a.tgl_keluar,
		// a.dokter
		// 	");

		$data = $this->db->query("SELECT 
			a.administrasi_tertunda,
			a.user_plg,
			a.tgl_masuk,
			a.tgl_keluar,
			a.dokter,
			a.no_ipd,
			a.nama,
			a.klsiri,
			a.carabayar,
			a.nm_ruang,
			b.id_icd,
			b.nm_diagnosa,
			c.tgl_lahir, 
			c.sex,
			c.no_cm as no_medrec_minto,
			(SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, 
			string_agg( e.diagnosa,',' ) AS list_diagnosa_tambahan,
			string_agg( e.id_diagnosa,',' ) AS list_id_diagnosa_tambahan, 
			d.nmruang as nmruang, 
			a.xuser, 
			a.lengkap, 
			a.tgl_dilengkapi,
			hm.name AS verifikator
		FROM 
			pasien_iri as a 
			LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd 
			LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec 
			LEFT JOIN ruang as d on a.idrg = d.idrg
			LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register 
			LEFT OUTER JOIN hmis_users AS hm ON hm.userid = a.user_verif
		WHERE 
			a.tgl_keluar is not null 
			and a.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
		GROUP BY 
			a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm,a.id_kontraktor,d.nmruang,a.tgl_masuk,a.tgl_keluar,
			a.dokter,a.user_plg, a.xuser, a.lengkap, a.tgl_dilengkapi,a.administrasi_tertunda, hm.name
		ORDER BY a.tgl_keluar DESC");
		// 	}else{
		// 		$data=$this->db->query("
		// 		SELECT a.tgl_masuk,a.tgl_keluar,a.dokter,a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto,
		// 		(SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, string_agg( e.diagnosa,',' ) AS list_diagnosa_tambahan,
		// 		string_agg( e.id_diagnosa,',' ) AS list_id_diagnosa_tambahan, d.nmruang as nmruang FROM pasien_iri as a LEFT JOIN icd1 as b
		// 		on a.diagnosa1 = b.id_icd LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec LEFT JOIN ruang as d on a.idrg = d.idrg
		// 		LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register WHERE a.tgl_keluar is not null and a.tgl_keluar BETWEEN '$tgl_awal' 
		// 		AND '$tgl_akhir' AND a.idrg in($where)
		// 		GROUP BY a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm,a.id_kontraktor,d.nmruang,a.tgl_masuk,a.tgl_keluar,
		// 		a.dokter
		// 		ORDER BY a.tgl_keluar DESC
		// 			");
		// 	}
		// }
		return $data;
	}

	public function get_medrec_year($tahun, $where)
	{
		$data = $this->db->query("
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
				" . ($where != "" ? "and a.idrg in ($where)" : "AND a.idrg = 0") . " 
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_empty_diagnosa_by_month($bulan, $where)
	{
		// $data=$this->db->query("
		// 	SELECT *
		// 		FROM pasien_iri as a
		// 		LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
		// 		WHERE a.tgl_keluar is not null
		// 		and a.tgl_keluar like '$bulan-%'
		// 	");
		$data = $this->db->query("
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
				" . ($where != "" ? "and a.idrg in ($where)" : "AND a.idrg = 0") . "
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

	public function select_pasien_like($value)
	{
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data = $this->db->query("
			select *
			from pasien_iri as a
			where a.no_ipd like '%$value%'
			and tgl_keluar is null
			");
		return $data->result_array();
	}

	public function select_diagnosa_iri_by_id($id)
	{
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data = $this->db->query("
			select *
			from diagnosa_iri as a
			where a.no_register = '$id'
			");
		return $data->result_array();
	}

	public function flag_kwintasi_em_terbayar($no_ipd)
	{
		$data = $this->db->query("
			update pemeriksaan_elektromedik
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}
	//flag kwintansi
	public function flag_kwintasi_rad_terbayar($no_ipd)
	{
		$data = $this->db->query("
			update pemeriksaan_radiologi
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_lab_terbayar($no_ipd)
	{
		$data = $this->db->query("
			update pemeriksaan_laboratorium
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_obat_terbayar($no_ipd)
	{
		$data = $this->db->query("
			update resep_pasien
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_ird_terbayar($no_register, $tgl_cetak, $lunas)
	{
		$data = $this->db->query("
			update irddaftar_ulang
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak',lunas = $lunas
			where no_register = '$no_register'
			");
	}

	public function flag_irj_terbayar($no_register, $tgl_cetak, $lunas)
	{
		$data = $this->db->query("
			update daftar_ulang_irj
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak', lunas = $lunas
			where no_register = '$no_register'
			");
	}

	function get_data_ruangan($no_ipd)
	{
		return $this->db->query("SELECT (select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter) as nm_dokter,a.id_dokter,a.no_ipd AS no_ipd , a.nama AS nama , a.klsiri AS klsiri , a.bed AS bed , b.nmruang AS nmruang , c.idrgiri AS idrgiri , d.no_cm AS no_cm 
		FROM pasien_iri a 
		LEFT JOIN ruang b ON LEFT(a.bed , 4) = b.idrg 
		LEFT JOIN ruang_iri c ON( a.no_ipd = c.no_ipd AND a.bed = c.bed) 
		LEFT JOIN data_pasien AS d ON a.no_medrec = d.no_medrec  WHERE a.no_ipd = '$no_ipd'");
	}

	function get_data_tanggal($no_ipd)
	{
		return $this->db->query("SELECT a.no_ipd AS no_ipd, d.no_cm AS no_cm, a.tgl_masuk FROM pasien_iri a LEFT JOIN data_pasien AS d ON a.no_cm = d.no_medrec WHERE a.no_ipd = '$no_ipd'");
	}

	public function get_all_kelas_with_empty_bed()
	{
		$data = $this->db->query("
			SELECT concat(a.idrg,'-',b.nmruang,'-Kelas(',a.kelas,')') as text, count(*) 
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			where a.isi = 'N'
			group by a.kelas,a.idrg,b.nmruang
			order by concat(a.idrg,'-',b.nmruang,'-Kelas(',a.kelas,')') ");
		return $data->result_array();
	}

	public function update_bed($asal, $baru)
	{
		$this->db->query("UPDATE bed SET isi ='N' WHERE bed = '$asal'");
		$this->db->query("UPDATE bed SET isi ='Y' WHERE bed = '$baru'");
		return true;
	}

	public function update_tanggal($no_ipd, $tgl)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', ['tgl_masuk' => $tgl]);
		return true;
	}

	public function update_tanggal_ruangiri($no_ipd, $tgl)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('ruang_iri', ['tglmasukrg' => $tgl]);
		return true;
	}

	public function update_ruangan_ruangiri($data, $idrgiri)
	{
		$this->db->where('idrgiri', $idrgiri);
		$this->db->update('ruang_iri', $data);
		return true;
	}

	public function update_ruangan_pasieniri($data1, $no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data1);
		return true;
	}
	public function get_vtot_ruangan($id_tindakan, $kelas)
	{
		return $this->db->query("SELECT total_tarif AS vtot FROM tarif_tindakan WHERE id_tindakan = '$id_tindakan' AND kelas = '$kelas'");
	}

	function get_roleid($userid)
	{
		return $this->db->query("Select roleid from dyn_role_user where userid = '" . $userid . "'");
	}

	function balikkan_keruangan($no_ipd)
	{
		$this->db->query("UPDATE pasien_iri set tgl_keluar = null where no_ipd = '$no_ipd'");
		$this->db->query("UPDATE ruang_iri set tglkeluarrg = null,statkeluarrg = null where no_ipd = '$no_ipd'");
		return true;
	}

	//discharge
	public function get_discharge_patient_by_date($tgl_akhir)
	{
		$data = $this->db->query("
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

	public function get_discharge_patient_by_month($bulan)
	{
		// $data=$this->db->query("
		// 	SELECT *
		// 		FROM pasien_iri as a
		// 		LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
		// 		WHERE a.tgl_keluar is not null
		// 		and a.tgl_keluar like '$bulan-%'
		// 	");
		$data = $this->db->query("
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

	public function get_discharge_patient_by_year($tahun)
	{
		$data = $this->db->query("
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
		return $this->db->query('SELECT * FROM shift WHERE kd_shift = ' . $id . '')->row();
	}

	public function get_no_kwitansi($jenis_kwitansi = 'RI', $no_register = null)
	{
		if ($no_register != null) {
			$this->db->where('no_registrasi', $no_register);
		}

		$cek = $this->db->select('*')->from('no_kwitansi')->where('jenis_kwitansi', $jenis_kwitansi)->order_by('no_kwitansi', 'DESC')->get();

		if ($cek->num_rows() > 0) {
			return $cek;
		} else {
			return false;
		}
	}

	public function get_no_kwitansi_bpjs($jenis_kwitansi = 'BPJS', $no_register = null)
	{
		if ($no_register != null) {
			$this->db->where('no_registrasi', $no_register);
		}

		$cek = $this->db->select('*')->from('no_kwitansi')->where('left(jenis_kwitansi, 4) =', $jenis_kwitansi)->order_by('no_kwitansi', 'DESC')->get();

		if ($cek->num_rows() > 0) {
			return $cek;
		} else {
			return false;
		}
	}

	public function insert_no_kwitansi($data)
	{
		$this->db->insert('no_kwitansi', $data);
	}

	function get_id_dokter_from_userid($userid)
	{
		$this->db->where('userid', $userid);
		return $this->db->get('dyn_user_dokter');
	}

	function get_data_konsultasi_bersama($id_dokter)
	{
		return $this->db->query("SELECT
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
		EXTRACT(EPOCH FROM c.tgl_lahir-NOW()) as umur
		
	FROM
		pasien_iri AS a
		LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
		INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
		LEFT JOIN ruang AS d ON a.idrg = d.idrg
		LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
		LEFT JOIN drtambahan_iri on drtambahan_iri.no_register = a.no_ipd
	WHERE
		a.tgl_keluar IS NULL
		AND b.tglkeluarrg IS NULL 
		AND drtambahan_iri.id_dokter = '$id_dokter'
		AND a.mutasi is null
		AND ( a.ipdibu = '' OR a.ipdibu IS NULL ) 
	ORDER BY
		a.no_ipd ASC");
	}

	function get_pasien_iri_for_dokter($id_dokter)
	{
		return $this->db->query("Select 0 as id_drtambahan,no_cm,pasien_iri.nama,r.nmruang,pasien_iri.klsiri as kelas,pasien_iri.bed,ri.tglmasukrg,ipdibu,carabayar, cast(pasien_iri.id_dokter as integer), pasien_iri.no_ipd, 'DPJP' as ket, 
		(select nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as dokter,k.nmkontraktor,EXTRACT(EPOCH FROM data_pasien.tgl_lahir-NOW()) as umur
		from pasien_iri 
		LEFT JOIN data_pasien on data_pasien.no_medrec = pasien_iri.no_medrec
		LEFT JOIN ruang as r on pasien_iri.idrg = r.idrg
		LEFT JOIN ruang_iri as ri on pasien_iri.no_ipd = ri.no_ipd
		LEFT JOIN kontraktor k ON k.id_kontraktor = pasien_iri.id_kontraktor 
		where pasien_iri.id_dokter=$id_dokter
		UNION ALL 
		select cast(id_drtambahan as integer),c.no_cm,b.nama,r.nmruang,b.klsiri as kelas,b.bed,ri.tglmasukrg,b.ipdibu,b.carabayar,  cast(drtambahan_iri.id_dokter as integer), no_register,ket,
		(select nm_dokter from data_dokter where id_dokter=cast(drtambahan_iri.id_dokter as integer)) as nm_dokter,
		k.nmkontraktor,EXTRACT(EPOCH FROM c.tgl_lahir-NOW()) as umur
		from drtambahan_iri 
		LEFT JOIN pasien_iri as b on drtambahan_iri.no_register = b.no_ipd
		LEFT JOIN data_pasien as c on b.no_medrec = c.no_medrec
		LEFT JOIN ruang as r on r.idrg = b.idrg
		LEFT JOIN ruang_iri as ri on b.no_ipd = ri.no_ipd
		LEFT JOIN kontraktor k ON k.id_kontraktor = b.id_kontraktor 
		where id_drtambahan=$id_dokter");
	}

	function get_pasien_iri_by_iddokter($noipd, $id_dokter)
	{
		$this->db->where('id_dokter', $id_dokter);
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('pasien_iri');
	}

	function get_drtambahan_iri_by_id_doktertambahan($noregister, $id_dokter)
	{
		$this->db->where('no_register', $noregister);
		$this->db->where('id_dokter', $id_dokter);
		return $this->db->get('drtambahan_iri');
	}

	public function get_list_all_elektromedik_pasien($no_ipd)
	{
		$data = $this->db->query("select *
			from pemeriksaan_elektromedik as a
			where a.no_register = '$no_ipd'
			and a.no_em is not null			
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_tindakan_ird($no_reg_asal)
	{
		$data = $this->db->query("
		select *
		from pelayanan_poli as a
		where a.no_register = '$no_reg_asal'	
		order by tgl_kunjungan asc
		");
		return $data->result_array();
	}

	public function get_list_ok_iri($no_ipd)
	{
		$data = $this->db->query("SELECT A
			.*, y.*,
			x.tarif_iks, 
			x.total_tarif AS tarif_jatah,
			( SELECT b.nm_dokter AS dok_anes FROM pemeriksaan_operasi A, data_dokter b WHERE A.id_dok_anes = b.id_dokter AND A.no_register = '$no_ipd' LIMIT 1),
			( SELECT b.nm_dokter AS dok_anak FROM pemeriksaan_operasi A, data_dokter b WHERE A.id_dok_anak = b.id_dokter AND A.no_register = '$no_ipd' LIMIT 1),
			b.nm_dokter AS dok_ok,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS total_tarif
		FROM
			pemeriksaan_operasi AS A,
			data_dokter AS b,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			AND A.id_dokter = b.id_dokter 
			AND A.no_ok IS NOT NULL 
			AND A.no_register = '$no_ipd' ");
		return $data->result_array();
	}

	public function get_list_ok_iri_billing($no_ipd)
	{
		$data = $this->db->query("SELECT A
		.*,
		(
		SELECT
			b.nm_dokter AS dok_anes 
		FROM
			pemeriksaan_operasi A,
			data_dokter b 
		WHERE
			A.id_dok_anes = b.id_dokter 
			AND A.no_register = '$no_ipd' 
			LIMIT 1 
		),
		(
		SELECT
			b.nm_dokter AS dok_anak 
		FROM
			pemeriksaan_operasi A,
			data_dokter b 
		WHERE
			A.id_dok_anak = b.id_dokter 
			AND A.no_register = '$no_ipd' 
			LIMIT 1 
		),
		b.nm_dokter AS dok_ok
	FROM
		pemeriksaan_operasi AS A,
		data_dokter AS b,
		pasien_iri AS y 
	WHERE
		A.no_register = y.no_ipd 
		AND A.id_dokter = b.id_dokter 
		AND A.no_ok IS NOT NULL 
		AND A.no_register = '$no_ipd' ");
		return $data->result_array();
	}

	public function get_list_ok_iri_status($no_ipd)
	{
		$data = $this->db->query("SELECT DISTINCT A
			.*,
			y.*,
			x.total_tarif AS tarif_jatah,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri LIMIT 1) AS tarif_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.jatahklsiri LIMIT 1) AS tarif_iks_jatah,
			(SELECT nm_dokter FROM data_dokter WHERE A.id_dok_anes = id_dokter LIMIT 1) AS dok_anes,
			(SELECT nm_dokter FROM data_dokter WHERE A.id_dok_anak = id_dokter LIMIT 1) AS dok_anak,
			(SELECT nm_dokter FROM data_dokter WHERE a.id_dokter = id_dokter LIMIT 1) AS dok_ok,
			a.vtot AS okvtot,
		CASE		
			WHEN ( A.no_ok IS NULL ) THEN
			'Belum Ditindak' ELSE'Ditindak' 
		END AS status, a.no_ok
		FROM
			pemeriksaan_operasi AS A,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			--AND A.no_ok IS NOT NULL
			AND A.no_register = '$no_ipd' ");
		return $data->result_array();
	}

	public function get_list_lab_iri($no_ipd)
	{
		$data = $this->db->query("SELECT A
		.*,
		y.*,
		x.tarif as total_tarif,
		x.tarif as tarif_jatah_bpjs
	FROM
		pemeriksaan_laboratorium AS A,
		jenis_tindakan_new AS x,
		pasien_iri AS y 
	WHERE
		A.id_tindakan = x.idtindakan 
		AND A.no_register = y.no_ipd 
		AND y.no_ipd = '$no_ipd' 
		AND no_lab IS NOT NULL ");
		return $data->result_array();
	}

	public function get_list_lab_iri_status($no_ipd)
	{
		$data = $this->db->query("SELECT A
				.*,
				y.*,
				x.tarif as tarif_iks,
				x.tarif AS tarif_jatah,
			CASE
					
					WHEN ( A.tgl_kunjungan IS NULL ) THEN
					'Belum Ditindak' ELSE'Ditindak' 
				END AS status,
				A.tgl_kunjungan 
			FROM
				pemeriksaan_laboratorium AS A,
				jenis_tindakan_new AS x,
				pasien_iri AS y 
			WHERE
				A.id_tindakan = x.idtindakan 
				AND A.no_register = y.no_ipd 
				AND y.no_ipd = '$no_ipd'
					--AND no_lab IS NOT NULL 
			");
		return $data->result_array();
	}

	public function get_list_rad_iri($no_ipd)
	{
		$data = $this->db->query("SELECT
		a.*,y.*,
		x.tarif as tarif_iks,
		x.tarif  AS tarif_jatah,
		x.tarif  AS tarif_jatah_bpjs,
		x.tarif  AS tarif_bpjs,
		x.tarif  AS tarif_jatah_iks,
		x.tarif AS total_tarif
	FROM
		pemeriksaan_radiologi AS a,
		jenis_tindakan_new AS x,
		pasien_iri AS y
	WHERE
		a.id_tindakan = x.idtindakan 
		AND a.no_register = y.no_ipd
		AND a.no_register = '$no_ipd' 
		AND a.no_rad IS NOT NULL
	ORDER BY
		a.xupdate ASC ");
		return $data->result_array();
	}

	public function get_list_rad_iri_status($no_ipd)
	{
		$data = $this->db->query("SELECT
			a.*,y.*,x.tarif_iks, x.total_tarif AS tarif_jatah,
		CASE WHEN (a.tgl_kunjungan IS NULL) THEN 'Belum Ditindak'
		ELSE 'Ditindak' END AS status, a.tgl_kunjungan
		FROM
			pemeriksaan_radiologi AS a,
			tarif_tindakan AS x,
			pasien_iri AS y
		WHERE
			x.kelas = y.jatahklsiri 
			AND a.id_tindakan = x.id_tindakan 
			AND a.no_register = y.no_ipd
			AND a.no_register = '$no_ipd' 
			--AND a.no_rad IS NOT NULL
		ORDER BY
			a.xupdate ASC ");
		return $data->result_array();
	}

	public function get_list_em_iri($no_ipd)
	{
		$data = $this->db->query("SELECT
			a.*,y.*, 
			x.tarif_iks, 
			x.total_tarif AS tarif_jatah, 
			y.jatahklsiri,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS total_tarif
		FROM
			pemeriksaan_elektromedik AS a,
			tarif_tindakan AS x,
			pasien_iri AS y
		WHERE
			x.kelas = y.jatahklsiri 
			AND a.id_tindakan = x.id_tindakan 
			AND a.no_register = y.no_ipd
			AND a.no_register = '$no_ipd' 
			AND a.no_em IS NOT NULL
		ORDER BY
			a.xupdate ASC ");
		return $data->result_array();
	}

	public function get_list_em_iri_status($no_ipd)
	{
		$data = $this->db->query("SELECT
			a.*,y.*, x.tarif_iks, x.total_tarif AS tarif_jatah, y.jatahklsiri,
		CASE WHEN (a.tgl_kunjungan IS NULL) THEN 'Belum Dtindak'
		ELSE 'Ditindak' END AS status,
		a.vtot AS total, a.tgl_kunjungan
		FROM
			pemeriksaan_elektromedik AS a,
			tarif_tindakan AS x,
			pasien_iri AS y
		WHERE
			x.kelas = y.jatahklsiri 
			AND a.id_tindakan = x.id_tindakan 
			AND a.no_register = y.no_ipd
			AND a.no_register = '$no_ipd' 
			--AND a.no_em IS NOT NULL
		ORDER BY
			a.xupdate ASC ");
		return $data->result_array();
	}

	public function get_list_resep_iri($no_ipd)
	{
		$data = $this->db->query("SELECT 
			a.*, 
			b.kategori6 
		FROM 
			resep_pasien AS a 
			LEFT OUTER JOIN master_obat AS b ON a.item_obat::int = b.id_obat
		WHERE a.no_register = '$no_ipd'");
		return $data->result_array();
	}

	public function get_list_resep_iri_rekap($no_ipd)
	{
		return $this->db->query("SELECT
			a.nama_obat,
			b.kategori6,
			SUM(a.qty) AS quantiti,
			SUM(a.vtot) + SUM(a.embalase::integer) AS total_rekap
		FROM
			resep_pasien AS a
			LEFT OUTER JOIN master_obat AS b ON a.item_obat::int = b.id_obat
		WHERE
			a.no_register = '$no_ipd'
		GROUP BY
			a.nama_obat, b.kategori6");
	}

	public function get_list_resep_iri_new($no_ipd)
	{
		return $this->db->query("SELECT vtot_obat FROM pasien_iri WHERE no_ipd = '$no_ipd'");
		//return $data->row();
	}

	public function get_list_resep_iri_status($no_ipd)
	{
		$data = $this->db->query("SELECT 
			*, CASE WHEN (cetak_faktur IS NULL) THEN 'Belum Selesai'
			ELSE 'Selesai' END AS status
		FROM 
			resep_pasien 
		WHERE 
			no_register = '$no_ipd' 
			and no_resep != 0 ");
		return $data->result_array();
	}

	public function get_list_ok_ird($no_register)
	{
		$data = $this->db->query("SELECT *,
			( SELECT b.nm_dokter AS nm_dok_anes FROM pemeriksaan_operasi A, data_dokter b WHERE A.id_dok_anes = b.id_dokter AND A.no_register = '$no_register' LIMIT 1),
			( SELECT b.nm_dokter AS nm_dok_anak FROM pemeriksaan_operasi A, data_dokter b WHERE A.id_dok_anak = b.id_dokter AND A.no_register = '$no_register' LIMIT 1),
			b.nm_dokter AS dok_ok 
		FROM pemeriksaan_operasi AS a,
		data_dokter AS b
		WHERE no_register = '$no_register' 
		and a.id_dokter = b.id_dokter
		and no_ok is not null ");
		return $data->result_array();
	}

	public function get_list_lab_ird($no_register)
	{
		$data = $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_register = '$no_register' and no_lab is not null");
		return $data->result_array();
	}

	public function get_list_rad_ird($no_register)
	{
		$data = $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$no_register' and no_rad is not null");
		return $data->result_array();
	}

	public function get_list_em_ird($no_register)
	{
		$data = $this->db->query("SELECT * FROM pemeriksaan_elektromedik WHERE no_register = '$no_register' and no_em is not null ");
		return $data->result_array();
	}

	public function get_list_resep_ird($no_register)
	{
		$data = $this->db->query("SELECT * FROM resep_pasien WHERE no_register = '$no_register' and no_resep != 0 ");
		return $data->result_array();
	}

	public function get_kelas()
	{
		return $this->db->query("SELECT * FROM kelas");
	}

	public function select_prosedur_iri_by_id($id)
	{
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data = $this->db->query("
			select *
			from icd9cm_iri as a
			where a.no_register = '$id'
			");
		return $data->result_array();
	}

	function batal_pasien($no_ipd, $user_login, $bed)
	{
		$this->db->where('no_ipd', $no_ipd)
			->update('ruang_iri', [
				'statkeluarrg' => 'BATAL',
				'tglkeluarrg' => date('Y-m-d H:i:s')
			]);
		$this->db->where('bed', $bed)->update('bed', ['isi' => 'N']);
		return $this->db->where('no_ipd', $no_ipd)
			->update('pasien_iri', [
				'batal' => '1',
				'tglbatal' => date('Y-m-d H:i:s'),
				'userbatal' => $user_login
			]);
		// $this->db->query("SET LOCAL var.logged_user = '$user_login'");
		// return $this->db->query("DELETE FROM pasien_iri WHERE no_ipd='$no_ipd'");
	}

	function load_ruangan_user($userid)
	{
		return $this->db->where('userid', $userid)->get('user_kepala_ruangan')->result();
	}

	function hapus_tindakan($id)
	{
		$this->db->where('id_jns_layanan', $id);
		$this->db->delete('pelayanan_iri');
		return true;
	}

	function get_ttd_dpjp($id_dokter)
	{
		return $this->db->query("SELECT 
			a.ttd, c.nm_dokter 
		FROM 
			hmis_users AS a, 
			dyn_user_dokter AS b,
			data_dokter AS c
		WHERE 
			a.userid = b.userid 
			AND b.id_dokter = c.id_dokter
			AND b.id_dokter = '$id_dokter'");
	}

	function get_ttd_by_login($userid)
	{
		return $this->db->query("SELECT ttd FROM hmis_users WHERE userid = '$userid'");
	}

	public function get_rekap_tindakan_pasien($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			c.nmruang,
			SUM ( A.qtyyanri ) AS qty,
			SUM ( A.vtot ) AS total
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS c
			-- ruang_iri AS d
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan NOT IN ( '1B0134', '1B0137','PK0012','PK0013')
			--AND a.id_tindakan != '1B0137'
			AND A.id_tindakan = b.idtindakan 
			AND a.idrg = c.idrg
			-- AND a.idrg = d.idrg
			-- AND a.no_ipd = d.no_ipd
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			c.nmruang
		-- ORDER BY min(d.tglmasukrg) ASC
		");
	}

	public function get_rekap_tindakan_pasien_urutan($no_ipd)
	{
		return $this->db->query("SELECT 
			A.id_tindakan,
			c.nmtindakan,
			SUM ( A.qtyyanri ) AS qtyyanri,
			SUM ( A.vtot ) AS vtot
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS c
		WHERE
			A.no_ipd = '$no_ipd' 
			AND a.id_tindakan NOT IN('1B0134','1B0137')
			AND  SUBSTRING(a.id_tindakan,1,2) != 'BK'
			AND C.nmtindakan NOT LIKE '%darah%' 
			AND C.nmtindakan NOT LIKE '%Darah%' 
			AND C.idkel_inacbg NOT IN (2,14) 
			AND C.id_kel != 1 
			AND A.id_tindakan = c.idtindakan 
		GROUP BY
			A.id_tindakan,
			c.nmtindakan")->result_array();
	}

	public function get_rekap_tindakan_pasien_jatah($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			c.nmruang,
			SUM ( A.qtyyanri ) AS qty,
			SUM ( A.vtot ) AS total,
			(SELECT total_tarif FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.jatahklsiri) LIMIT 1) AS tarif_jatah,
			(SELECT tarif_iks FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.jatahklsiri) LIMIT 1) AS tarif_jatah_iks,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.jatahklsiri) LIMIT 1) AS tarif_jatah_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.klsiri) LIMIT 1) AS total_trif,
			(SELECT tarif_iks FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.klsiri) LIMIT 1) AS tarif_iks,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE a.id_tindakan = id_tindakan AND kelas = min(e.klsiri) LIMIT 1) AS tarif_bpjs
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS c,
			ruang_iri AS d,
			pasien_iri AS e
		WHERE
			A.no_ipd = '$no_ipd' 
			AND a.id_tindakan != '1B0134'
			AND a.id_tindakan != '1B0137'
			AND A.id_tindakan = b.idtindakan 
			AND a.idrg = c.idrg
			AND a.idrg = d.idrg
			AND a.no_ipd = d.no_ipd
			AND a.no_ipd = e.no_ipd
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			c.nmruang
		ORDER BY min(d.tglmasukrg) ASC");
	}

	public function get_rekap_tindakan_pasien_iks_jatah($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			SUM ( A.qtyyanri ) AS qty,
			f.tarif_iks
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS C,
			-- ruang_iri AS d,
			pasien_iri AS e,
			tarif_tindakan AS f 
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan != '1B0134' 
			AND A.id_tindakan != '1B0137' 
			AND A.id_tindakan = b.idtindakan 
			AND A.idrg = C.idrg 
			-- AND A.idrg = d.idrg 
			-- AND A.no_ipd = d.no_ipd 
			AND e.no_ipd = A.no_ipd 
			AND A.id_tindakan = f.id_tindakan 
			AND e.jatahklsiri = f.kelas 
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			f.tarif_iks
		-- ORDER BY
		-- 	MIN ( d.tglmasukrg ) ASC
		");
	}

	public function get_list_tindakan_ird_rekap($no_reg_asal)
	{
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
			AND a.bayar_umum IS NULL
		GROUP BY
			A.idtindakan,
			b.nmtindakan");
	}

	public function get_list_tindakan_ird_rekap_cetak($noregasal)
	{
		return $this->db->query("SELECT A
			.idtindakan,
			b.nmtindakan,
			SUM ( A.qtyind ) AS qty,
			SUM ( A.vtot ) AS total 
		FROM
			pelayanan_poli AS A,
			jenis_tindakan AS b
		WHERE
			A.no_register = '$noregasal' 
			AND A.idtindakan = b.idtindakan 
			AND a.bayar_umum IS NOT NULL
		GROUP BY
			A.idtindakan,
			b.nmtindakan");
	}

	public function get_rekap_tindakan_pasien_visite($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.idoprtr,
			A.xuser,
			d.NAME,
			SUM ( A.qtyyanri ) AS qty,
			SUM ( A.vtot ) AS total
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS C,
			hmis_users AS d
			-- ruang_iri AS e
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan = b.idtindakan 
			AND A.idrg = C.idrg 
			AND A.id_tindakan IN ( '1B0134', '1B0137','PK0012','PK0013') 
			AND CAST ( A.idoprtr AS INT ) = d.userid 
			-- AND a.idrg = e.idrg
			-- AND a.no_ipd = e.no_ipd
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.xuser,
			A.idoprtr,
			d.NAME
		-- ORDER BY min(e.tglmasukrg) ASC
		");
	}

	public function get_rekap_tindakan_pasien_visite_jatah($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.idoprtr,
			A.xuser,
			d.NAME,
			SUM ( A.qtyyanri ) AS qty,
			SUM ( A.vtot ) AS total,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan AND kelas = min(f.jatahklsiri) LIMIT 1) AS tarif_jatah,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan AND kelas = min(f.jatahklsiri) LIMIT 1) AS tarif_jatah_iks,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = a.id_tindakan AND kelas = min(f.jatahklsiri) LIMIT 1) AS tarif_jatah_bpjs
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS C,
			hmis_users AS d,
	-- 			ruang_iri AS e,
			pasien_iri AS f
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan = b.idtindakan 
			AND A.idrg = C.idrg 
			AND A.id_tindakan IN ( '1B0134', '1B0137' ) 
			AND CAST ( A.idoprtr AS INT ) = d.userid 
	-- 			AND e.idrg = a.idrg
			AND a.no_ipd = f.no_ipd
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.xuser,
			A.idoprtr,
			d.NAME");
	}

	public function get_rekap_tindakan_pasien_visite_iks_jatah($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.idoprtr,
			A.xuser,
			d.NAME,
			SUM ( A.qtyyanri ) AS qty,
			g.tarif_iks
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b,
			ruang AS C,
			hmis_users AS d,
			-- ruang_iri AS e,
			pasien_iri AS f,
			tarif_tindakan AS g
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan = b.idtindakan 
			AND A.idrg = C.idrg 
			AND A.id_tindakan IN ( '1B0134', '1B0137' ) 
			AND CAST ( A.idoprtr AS INT ) = d.userid 
			-- AND e.idrg = a.idrg
			AND a.no_ipd = a.no_ipd
			AND a.no_ipd = f.no_ipd
			AND a.id_tindakan = g.id_tindakan
			AND f.jatahklsiri = g.kelas
		GROUP BY
			A.id_tindakan,
			b.nmtindakan,
			C.nmruang,
			A.xuser,
			A.idoprtr,
			d.NAME,
			g.tarif_iks
		-- ORDER BY min(e.tglmasukrg) ASC
		");
	}

	public function get_list_rad_iri_rekap($no_ipd)
	{
		return $this->db->query("SELECT 
			a.id_tindakan,
			y.tgl_masuk,
			a.jenis_tindakan,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			x.total_tarif AS tarif_jatah,
			y.carabayar,
			SUM(a.qty) AS qtx,
			SUM(a.vtot) AS total_rekap,
			a.biaya_rad,
			tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS total_tarif
		FROM
			pemeriksaan_radiologi AS A,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			AND A.no_register = '$no_ipd' 
			AND A.no_rad IS NOT NULL 
			AND a.cetak_kwitansi IS NULL
		GROUP BY
			a.id_tindakan, a.jenis_tindakan, y.klsiri, y.jatahklsiri, y.titip, x.tarif_iks, tarif_jatah, y.carabayar, a.biaya_rad, x.tarif_bpjs, y.tgl_masuk");
	}

	public function get_list_rad_ird_rekap($noreg_asal)
	{
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
			AND a.bayar_umum IS NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_rad_ird_rekap_cetak($noregasal)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap
		FROM
			pemeriksaan_radiologi AS A
		WHERE
			A.no_register = '$noregasal' 
			AND A.no_rad IS NOT NULL 
			AND a.bayar_umum IS NOT NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_lab_ird_rekap($noreg_asal)
	{
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
			AND a.bayar_umum IS NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_lab_ird_rekap_cetak($noregasal)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap
		FROM
			pemeriksaan_laboratorium AS A
		WHERE
			A.no_register = '$noregasal' 
			AND A.no_lab IS NOT NULL 
			AND a.bayar_umum IS NOT NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_em_ird_rekap($noreg_asal)
	{
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
			AND a.bayar_umum IS NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_em_ird_rekap_cetak($noregasal)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap
		FROM
			pemeriksaan_elektromedik AS A
		WHERE
			A.no_register = '$noregasal' 
			AND A.no_em IS NOT NULL
			AND a.bayar_umum IS NOT NULL
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_ok_ird_rekap($noreg_asal)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap
		FROM
			pemeriksaan_operasi AS A
		WHERE
			A.no_register = '$noreg_asal' 
			AND A.no_ok IS NOT NULL 
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan");
	}

	public function get_list_em_iri_rekap($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			y.tgl_masuk,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			x.total_tarif AS tarif_jatah,
			y.carabayar,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap,
			a.biaya_em,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS total_tarif
		FROM
			pemeriksaan_elektromedik AS A,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			AND A.no_register = '$no_ipd' 
			AND A.no_em IS NOT NULL 
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			tarif_jatah,
			y.carabayar,
			a.biaya_em,
			x.tarif_bpjs,
			y.tgl_masuk");
	}

	public function get_list_ok_iri_rekap($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			y.tgl_masuk,
			A.jenis_tindakan,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			x.total_tarif AS tarif_jatah,
			y.carabayar,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap,
			a.biaya_ok,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS total_tarif
		FROM	
			pemeriksaan_operasi AS A,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.jatahklsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			AND A.no_register = '$no_ipd' 
			AND A.no_ok IS NOT NULL 
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			tarif_jatah,
			y.carabayar,
			a.biaya_ok,
			x.tarif_bpjs,
			y.tgl_masuk");
	}

	public function get_list_lab_iri_rekap($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			y.tgl_masuk,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			x.total_tarif,
			y.carabayar,
			SUM ( A.qty ) AS qtx,
			SUM ( A.vtot ) AS total_rekap,
			a.biaya_lab,
			x.tarif_bpjs AS tarif_jatah_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_bpjs,
			(SELECT tarif_iks FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah_iks,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = y.klsiri AND id_tindakan = a.id_tindakan LIMIT 1) AS tarif_jatah
		FROM
			pemeriksaan_laboratorium AS A,
			tarif_tindakan AS x,
			pasien_iri AS y 
		WHERE
			x.kelas = y.klsiri 
			AND A.id_tindakan = x.id_tindakan 
			AND A.no_register = y.no_ipd 
			AND A.no_register = '$no_ipd' 
			AND A.no_lab IS NOT NULL 
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan,
			y.klsiri,
			y.jatahklsiri,
			y.titip,
			x.tarif_iks,
			x.total_tarif,
			y.carabayar,
			a.biaya_lab,
			x.tarif_bpjs,
			y.tgl_masuk");
	}

	function hapus_tindakan_ok($id)
	{
		$this->db->where('id_pemeriksaan_ok', $id);
		$this->db->delete('pemeriksaan_operasi');
		return true;
	}

	function update_data_lengkap($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function update_data_tidak_lengkap($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function batal_verifikasi($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function get_total_tindakan_pasien($no_register)
	{
		return $this->db->query("SELECT SUM(vtot) AS total FROM pelayanan_iri WHERE no_ipd = '$no_register'");
	}

	function diterima_pasien($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd)
			->update('pasien_iri', [
				'wkt_masuk_rg' => 'NOW()'
			]);
	}

	function get_recent_idrg_patient($no_ipd)
	{
		return $this->db->query("SELECT idrg FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	public function get_medrec_range_date_tdk_lengkap($tgl_awal, $tgl_akhir, $where = "", $admin = 0)
	{

		$data = $this->db->query("
		SELECT a.user_plg,a.tgl_masuk,a.tgl_keluar,a.dokter,a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm as no_medrec_minto,a.ket_tdk_lengkap,
		(SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, string_agg( e.diagnosa,',' ) AS list_diagnosa_tambahan,
		string_agg( e.id_diagnosa,',' ) AS list_id_diagnosa_tambahan, d.nmruang as nmruang, a.xuser, a.lengkap, a.tgl_dilengkapi FROM pasien_iri as a LEFT JOIN icd1 as b
		on a.diagnosa1 = b.id_icd LEFT JOIN data_pasien as c on a.no_medrec = c.no_medrec LEFT JOIN ruang as d on a.idrg = d.idrg
		LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register WHERE a.tgl_keluar is not null AND A.lengkap = 2 and A.tgl_dilengkapi is null
		GROUP BY a.no_ipd,a.nama,a.klsiri,a.carabayar,a.nm_ruang,b.id_icd,b.nm_diagnosa,c.tgl_lahir, c.sex,c.no_cm,a.id_kontraktor,d.nmruang,a.tgl_masuk,a.tgl_keluar,a.ket_tdk_lengkap,
		a.dokter,a.user_plg, a.xuser, a.lengkap, a.tgl_dilengkapi
		ORDER BY a.tgl_keluar DESC
		");

		return $data;
	}

	function get_data($date, $tampil)
	{
		if ($tampil == 'TGL') {
			return $this->db->query("SELECT A
				.no_cm,
				A.nama,
				b.no_ipd,
				A.sex,
				A.agama,
				A.tgl_lahir,
				A.kotakabupaten,
				A.provinsi,
				b.selisih_tarif,
				b.titip,
				b.naik_1_tingkat,
				b.carabayar,
				(SELECT ruang.nmruang FROM ruang, ruang_iri WHERE ruang.idrg = ruang_iri.idrg AND ruang_iri.statmasukrg = 'masuk' LIMIT 1) AS ruang_awal,
				(SELECT kelas FROM ruang_iri WHERE statmasukrg = 'masuk' LIMIT 1) AS kelas_awal,
				b.dokter,
				b.cara_pulang,
				b.status_pulang,
				b.tgl_masuk,
				b.tgl_keluar,
				b.jam_keluar,
				b.kelengkapan_rm,
				b.tgl_dilengkapi,
				b.lengkap,
				user_plg,
				(SELECT e.nm_poli FROM daftar_ulang_irj AS C, poliklinik AS e WHERE C.no_register = b.noregasal AND e.id_poli = C.id_poli ) as pintu_masuk
			FROM
				data_pasien A,
				pasien_iri b 
			WHERE
				A.no_medrec = b.no_medrec
				and b.tgl_dilengkapi is not null 
				and b.lengkap is not null 
				and b.tgl_keluar = '$date'");
		} else {
			return $this->db->query("SELECT A
				.no_cm,
				A.nama,
				b.no_ipd,
				A.sex,
				A.agama,
				A.tgl_lahir,
				A.kotakabupaten,
				A.provinsi,
				b.selisih_tarif,
				b.titip,
				b.naik_1_tingkat,
				b.carabayar,
				(SELECT ruang.nmruang FROM ruang, ruang_iri WHERE ruang.idrg = ruang_iri.idrg AND ruang_iri.statmasukrg = 'masuk' LIMIT 1) AS ruang_awal,
				(SELECT kelas FROM ruang_iri WHERE statmasukrg = 'masuk' LIMIT 1) AS kelas_awal,
				b.dokter,
				b.cara_pulang,
				b.status_pulang,
				b.tgl_masuk,
				b.tgl_keluar,
				b.jam_keluar,
				b.tgl_dilengkapi,
				b.kelengkapan_rm,
				b.lengkap,
				user_plg,
				(SELECT e.nm_poli FROM daftar_ulang_irj AS C, poliklinik AS e WHERE C.no_register = b.noregasal AND e.id_poli = C.id_poli ) as pintu_masuk
			FROM
				data_pasien A,
				pasien_iri b 
			WHERE
				A.no_medrec = b.no_medrec
				and b.tgl_dilengkapi is not null 
				and b.lengkap is not null 
				and b.tgl_keluar LIKE '$date%'");
		}
	}

	function get_ruang($no_ipd)
	{
		return $this->db->query("SELECT
			a.kelas,
			a.tglmasukrg,
			b.nmruang,
			a.idrg,
			a.no_ipd
			FROM 
			ruang_iri AS a,
			ruang AS b
			WHERE 
			a.no_ipd = '$no_ipd'
			and a.idrg = b.idrg 
			and a.statmasukrg = 'pindahan'
			ORDER BY tglmasukrg");
	}


	function get_diagnosa($no_ipd)
	{
		return $this->db->query("SELECT
			no_register,
			diagnosa,
			klasifikasi_diagnos 
			FROM
			diagnosa_iri where no_register = '$no_ipd'
			ORDER BY
			id_diagnosa_pasien ASC");
	}

	function get_operasi($no_ipd)
	{
		return $this->db->query("SELECT * from laporan_operasi where no_ipd = '$no_ipd' ");
	}

	function get_general_consent($no_ipd)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_register = '$no_ipd'");
	}

	function get_ipd_ibu($no_ipd)
	{
		return $this->db->query("SELECT ipdibu FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	function get_data_kelengkapan($data)
	{

		if ($data['tampil'] == 'TGL') {
			if ($data['idrg'] == 'semua') {
				return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND A.tgl_keluar BETWEEN '" . $data['tgl_awal'] . "' AND '" . $data['tgl_akhir'] . "'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
			} else {
				return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.idrg in ('" . $data['idrg'] . "') 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND A.tgl_keluar BETWEEN '" . $data['tgl_awal'] . "' AND '" . $data['tgl_akhir'] . "'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
			}
		} else if ($data['tampil'] == 'BLN') {
			if ($data['idrg'] == 'semua') {
				return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND TO_CHAR( A.tgl_keluar, 'YYYY-MM' ) = '" . $data['date'] . "'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
			} else {
				return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.idrg in ('" . $data['date'] . "') 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND TO_CHAR( A.tgl_keluar, 'YYYY-MM' ) = '" . $data['date'] . "'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
			}
		}
	}

	function get_data_kelengkapan_tgl($idrg, $tgl_awal, $tgl_akhir)
	{


		if ($idrg == 'semua') {
			return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND A.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
		} else {
			return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.idrg in ($idrg) 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND A.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'		
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
		}
	}

	function get_data_kelengkapan_bln($idrg, $bln)
	{


		if ($idrg == 'semua') {
			return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND  A.tgl_keluar LIKE '$bln%' 
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
		} else {
			return $this->db->query("SELECT
					b.nmruang,
					A.dokter,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap = 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap = 1 
					) AS lengkap_kurang_24,
					COUNT ( A.no_ipd ) FILTER (
						
					WHERE
						DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 1 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND A.lengkap != 1 
						OR DATE_PART( 'day', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) = 0 
						AND DATE_PART( 'hour', A.tgl_dilengkapi :: TIMESTAMP - A.jam_keluar :: TIMESTAMP ) > 0 
						AND A.lengkap != 1 
					) AS tdk_lengkap_kurang_24 
					FROM
						pasien_iri A,
						ruang b 
					WHERE
						A.idrg = b.idrg 
						AND A.idrg in ($idrg) 
						AND A.tgl_dilengkapi IS NOT NULL 
						AND A.jam_keluar IS NOT NULL 
						AND TO_CHAR( A.tgl_keluar, 'YYYY-MM' ) = '$date'	
					GROUP BY
						b.nmruang,
						A.dokter,
						A.jam_keluar,
						A.tgl_dilengkapi ");
		}
	}



	function adm_tertunda($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	public function flag_kwintasi_rad_piutang($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_radiologi
			set piutang = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_lab_piutang($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_laboratorium
			set piutang = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_obat_piutang($no_ipd){
		$data=$this->db->query("
			update resep_pasien
			set piutang = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_em_piutang($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_elektromedik
			set piutang = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_irj_piutang($no_register){
		$data=$this->db->query("
			update daftar_ulang_irj
			piutang = 1
			where no_register = '$no_register'
			");

	}

	public function flag_kwintasi_rad_piutang_lunas($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_radiologi
			set piutang = '2',cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_lab_piutang_lunas($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_laboratorium
			set piutang = '2',cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_obat_piutang_lunas($no_ipd){
		$data=$this->db->query("
			update resep_pasien
			set piutang = '2',cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_em_piutang_lunas($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_elektromedik
			set piutang = '2',cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function get_total_obat_with_embalase($no_ipd){
		$data=$this->db->query("
				SELECT SUM
				( vtot ) as vtot,
				count(racikan = 1) as racik,
				count(no_register) as obat
			FROM
				resep_pasien 
			WHERE
				no_register = '$no_ipd'
			");
			return $data->row();
	}

	public function get_data_penanggung_jwb($no_ipd){
		$data=$this->db->query("
				SELECT
				* 
			FROM
				general_consent_iri where no_register='$no_ipd'
		");
			return $data->row();
	}

	public function get_data_pasien_adm($no_ipd){
		$data=$this->db->query("
				SELECT
				no_ipd,
				carabayar,
				id_kontraktor,
				(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = pasien_iri.id_kontraktor) as nmkontraktor,
				administrasi_tertunda,
				alasan_titipan,
				jaminan_adm,
				uang_muka_adm,
				tgl_masuk,
				tgl_keluar,
				(select nm_ruang from ruang where pasien_iri.idrg = ruang.idrg) as nmruang,
				(select nama from data_pasien where pasien_iri.no_medrec = data_pasien.no_medrec) as nama,
				(select sex from data_pasien where pasien_iri.no_medrec = data_pasien.no_medrec) as sex,
				(select alamat from data_pasien where pasien_iri.no_medrec = data_pasien.no_medrec) as alamat,
				(select name from hmis_users where pasien_iri.user_verif = hmis_users.userid) as nmverif,
				(select ttd from hmis_users where pasien_iri.user_verif = hmis_users.userid) as ttd_verif
			FROM
				pasien_iri 
			WHERE
				no_ipd = '$no_ipd'
		");
			return $data->row();
	}

	public function get_list_visite_ird($no_reg_asal)
	{
		$data = $this->db->query("
		select *
		from pelayanan_poli as a
		where a.no_register = '$no_reg_asal'	
		AND a.bayar IS NULL	
		and idtindakan in('1B0105','1B0106','1B0107') 
		order by tgl_kunjungan asc
		
		");
		return $data->result_array();
	}

	public function get_list_rehab_ird($noregasal)
	{
		return $this->db->query("
		select *
		from pelayanan_poli as a
		where a.no_register = '$noregasal'	
		AND a.bayar IS NULL	
		AND SUBSTR(a.idtindakan,0,3) = 'BK'
		order by tgl_kunjungan asc
		")->result_array();
	}

	public function get_list_perawat_ird($noregasal)
	{
		return $this->db->query("SELECT A
			.nmtindakan,
			SUM ( A.qtyind ) AS qtyind,
			SUM ( A.vtot ) AS vtot 
		FROM
			pelayanan_poli
			AS A LEFT JOIN jenis_tindakan AS b ON A.idtindakan = b.idtindakan 
		WHERE
			A.no_register = '$noregasal' 
			AND SUBSTRING(A.idtindakan,1,2) != 'BK' 
			AND A.idtindakan NOT IN('1B0107','1B0105','1B0106') 
			AND b.nmtindakan NOT LIKE ANY (ARRAY['%darah%','%Darah%']) 
			AND b.idkel_inacbg != 2
			AND (b.idkel_inacbg != 14 OR b.id_kel != 1)
		GROUP BY
			A.nmtindakan")->result_array();
	}

	public function get_list_bmhp_ird($noregasal)
	{
		return $this->db->query("SELECT 
			a.nmtindakan,
			SUM(a.qtyind) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_poli AS a
			LEFT JOIN jenis_tindakan AS b ON a.idtindakan = b.idtindakan
		WHERE 
			a.no_register = '$noregasal'	
			AND b.idkel_inacbg = 2
		GROUP BY 
			a.nmtindakan")->result_array();
	}

	public function get_list_bmhp_iri($noregasal)
	{
		return $this->db->query("SELECT 
			b.nmtindakan,
			SUM(a.qtyyanri) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_iri AS a
			LEFT JOIN jenis_tindakan AS b ON a.id_tindakan = b.idtindakan
		WHERE 
			a.no_ipd = '$noregasal'	
			AND b.idkel_inacbg = 2
		GROUP BY 
			b.nmtindakan")->result_array();
	}

	public function get_list_alat_ird($noregasal)
	{
		return $this->db->query("SELECT 
			a.nmtindakan,
			SUM(a.qtyind) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_poli AS a
			LEFT JOIN jenis_tindakan AS b ON a.idtindakan = b.idtindakan
		WHERE 
			a.no_register = '$noregasal'	
			AND (b.idkel_inacbg = 14 OR b.id_kel = 1)
		GROUP BY 
			a.nmtindakan")->result_array();
	}

	public function get_list_alat_iri($noregasal)
	{
		return $this->db->query("SELECT 
			b.nmtindakan,
			SUM(a.qtyyanri) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_iri AS a
			LEFT JOIN jenis_tindakan AS b ON a.id_tindakan = b.idtindakan
		WHERE 
			a.no_ipd = '$noregasal'	
			AND (b.idkel_inacbg = 14 OR b.id_kel = 1)
		GROUP BY 
			b.nmtindakan")->result_array();
	}

	public function get_list_pelayanan_darah_ird($noregasal)
	{
		return $this->db->query("SELECT 
			a.nmtindakan,
			SUM(a.qtyind) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_poli AS a
			LEFT JOIN jenis_tindakan AS b ON a.idtindakan = b.idtindakan
		WHERE 
			a.no_register = '$noregasal'	
			AND b.nmtindakan ~* 'darah'
		GROUP BY 
			a.nmtindakan")->result_array();
	}

	public function get_list_pelayanan_darah_iri($noregasal)
	{
		return $this->db->query("SELECT 
			b.nmtindakan,
			SUM(a.qtyyanri) AS qty,
			SUM(a.vtot) AS vtot
		FROM 
			pelayanan_iri AS a
			LEFT JOIN jenis_tindakan AS b ON a.id_tindakan = b.idtindakan
		WHERE 
			a.no_ipd = '$noregasal'	
			AND b.nmtindakan ~* 'darah'
		GROUP BY 
			b.nmtindakan")->result_array();
	}

	function get_list_lab_urutan($noreg) {
		return $this->db->query("SELECT A
			.id_tindakan,
			A.jenis_tindakan,
			SUM ( A.qty ) AS qty,
			SUM ( A.vtot ) AS vtot
		FROM
			pemeriksaan_laboratorium AS A
		WHERE
			A.no_register = '$noreg' 
			AND A.no_lab IS NOT NULL 
		GROUP BY
			A.id_tindakan,
			A.jenis_tindakan")->result_array();
	}

	function flag_obat($no_ipd,$data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	public function select_pasien_iri_all_dokter($id_dokter)
	{
		$data = $this->db->query("SELECT DISTINCT
		a.no_ipd,
		c.no_cm,
		c.nama,
		c.sex,
		c.kotakabupaten,
		d.nmruang,
		b.kelas,
		a.bed,
		a.dokter,
		b.tglmasukrg,
		a.carabayar,
		k.nmkontraktor,
		a.ipdibu,
		a.verifikasi_plg,
		a.no_sep,
		a.pasien_anak,
		a.jatahklsiri,
		EXTRACT(EPOCH FROM c.tgl_lahir - NOW()) as umur,
		a.tgldaftarri,
		a.tgl_masuk,
		a.titip,
		a.selisih_tarif,
		a.wkt_masuk_rg,
		a.naik_1_tingkat,
		a.tgl_verif,
		rp.formjson->>'tanggal_perencanaan_pemulangan' as tanggal_perencanaan_pemulangan,
		diag.nm_diagnosa,
		(SELECT name FROM hmis_users WHERE a.user_verif = userid LIMIT 1) AS name_verif,
		(SELECT nm_dokter FROM data_dokter WHERE A.id_dokter = id_dokter LIMIT 1 ) AS name_dokter 
			FROM pasien_iri AS a
			LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
			INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			LEFT JOIN ruang AS d ON a.idrg = d.idrg
			LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
			LEFT OUTER JOIN rencana_pemulangan_iri rp ON a.no_ipd = rp.no_ipd
			LEFT OUTER JOIN icd1 diag ON a.diagmasuk = diag.id_icd
			LEFT JOIN dyn_user_dokter AS e ON a.id_dokter = e.id_dokter
			LEFT JOIN drtambahan_iri as f ON f.no_register = a.noregasal
			WHERE a.tgl_keluar IS NULL
				AND (b.tglkeluarrg IS NULL or TO_CHAR(b.tglkeluarrg, 'YYYY-MM-dd') = '')
				AND a.mutasi IS NULL
				AND ( e.id_dokter = '$id_dokter' or f.id_dokter = '$id_dokter')
				UNION
				SELECT DISTINCT
		a.no_ipd,
		c.no_cm,
		c.nama,
		c.sex,
		c.kotakabupaten,
		d.nmruang,
		b.kelas,
		a.bed,
		a.dokter,
		b.tglmasukrg,
		a.carabayar,
		k.nmkontraktor,
		a.ipdibu,
		a.verifikasi_plg,
		a.no_sep,
		a.pasien_anak,
		a.jatahklsiri,
		EXTRACT(EPOCH FROM c.tgl_lahir - NOW()) as umur,
		a.tgldaftarri,
		a.tgl_masuk,
		a.titip,
		a.selisih_tarif,
		a.wkt_masuk_rg,
		a.naik_1_tingkat,
		a.tgl_verif,
		rp.formjson->>'tanggal_perencanaan_pemulangan' as tanggal_perencanaan_pemulangan,
		diag.nm_diagnosa,
		(SELECT name FROM hmis_users WHERE a.user_verif = userid LIMIT 1) AS name_verif,
		(SELECT nm_dokter FROM data_dokter WHERE A.id_dokter = id_dokter LIMIT 1 ) AS name_dokter 
			FROM pasien_iri AS a
			LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
			INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			LEFT JOIN ruang AS d ON a.idrg = d.idrg
			LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
			LEFT OUTER JOIN rencana_pemulangan_iri rp ON a.no_ipd = rp.no_ipd
			LEFT OUTER JOIN icd1 diag ON a.diagmasuk = diag.id_icd
			LEFT JOIN dyn_user_dokter AS e ON a.id_dokter = e.id_dokter
			LEFT JOIN drtambahan_iri as f ON f.no_register = a.no_ipd
			WHERE a.tgl_keluar IS NULL
				AND (b.tglkeluarrg IS NULL or TO_CHAR(b.tglkeluarrg, 'YYYY-MM-dd') = '')
				AND a.mutasi IS NULL
				AND ( e.id_dokter = '$id_dokter' or f.id_dokter = '$id_dokter')
	
			
	");

		return $data->result_array();
	}

	public function list_pulang_ranap($tgl1,$tgl2)
	{
				return $this->db->query("SELECT A
					.tgl_masuk,
					A.tgl_keluar,
					A.no_ipd,
					b.nama,
					b.no_cm,
					a.no_sep,
					(select nmruang from ruang where a.idrg = ruang.idrg) as ruang
				FROM
					pasien_iri
					AS A LEFT JOIN data_pasien AS b on a.no_medrec = b.no_medrec::int
				WHERE
					LEFT ( A.tgl_keluar, 10 ) >= '$tgl1' 
					AND LEFT ( A.tgl_keluar, 10 ) <= '$tgl2'");
	}

	public function detail_resep_cetak($ipd)
	{
				return $this->db->query("SELECT
				tgl_kunjungan,
				nama_obat,
				qty,
				signa,
				biaya_obat,
				vtot from resep_pasien where no_register = '$ipd'");
	}

	public function list_pulang_rajal($tgl1,$tgl2)
	{
				return $this->db->query("SELECT A
					.tgl_kunjungan,
					A.no_register,
					b.nama,
					b.no_cm,
					A.no_sep,
					A.cara_bayar,
					( SELECT nm_poli FROM poliklinik WHERE A.id_poli = poliklinik.id_poli ) AS poli,
					( SELECT nm_dokter FROM data_dokter WHERE A.id_dokter = data_dokter.id_dokter ) AS dokter
					
				FROM
					daftar_ulang_irj
					AS A LEFT JOIN data_pasien AS b ON A.no_medrec = b.no_medrec :: INT 
				WHERE
					to_char( A.tgl_kunjungan, 'YYYY-MM-DD') >= '$tgl1' 
					AND to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl2'");
	}

	public function pasien_resep_rajal($ipd)
	{
				return $this->db->query("SELECT A
				.tgl_kunjungan,
				A.no_register,
				b.nama,
				b.no_cm,
				A.no_sep,
				A.cara_bayar,
				A.id_dokter,
				( SELECT nm_poli FROM poliklinik WHERE A.id_poli = poliklinik.id_poli ) AS poli,
				( SELECT nm_dokter FROM data_dokter WHERE A.id_dokter = data_dokter.id_dokter ) AS dokter 
			FROM
				daftar_ulang_irj
				AS A LEFT JOIN data_pasien AS b ON A.no_medrec = b.no_medrec :: INT 
			WHERE
				A.no_register = '$ipd'");
	}
	public function ttd_dokter_resep($id_dokter)
	{
				return $this->db->query("SELECT
					ttd,
				NAME 
				FROM
					hmis_users
					LEFT JOIN dyn_user_dokter ON hmis_users.userid = dyn_user_dokter.userid 
				WHERE
					dyn_user_dokter.id_dokter = '$id_dokter'");
	}

	public function get_id_dokter($ipd)
	{
		return $this->db->query("SELECT id_dokter FROM pasien_iri where no_ipd = '$ipd'");
	}

	public function get_medrec_range_date_by_tgl($tgl,$tgl1)
	{
		$data = $this->db->query("SELECT A
				.user_plg,
				A.tgl_masuk,
				A.tgl_keluar,
				(select nm_dokter from data_dokter where a.id_dokter = data_dokter.id_dokter ) as dokter,
				A.no_ipd,
				A.nama,
				A.klsiri,
				A.carabayar,
				A.nm_ruang,
				b.id_icd,
				b.nm_diagnosa,
				C.tgl_lahir,
				C.sex,
				C.no_cm AS no_medrec_minto,
				( SELECT nmkontraktor FROM kontraktor WHERE id_kontraktor = A.id_kontraktor ) AS nmkontraktor,
				string_agg ( e.diagnosa, ',' ) AS list_diagnosa_tambahan,
				string_agg ( e.id_diagnosa, ',' ) AS list_id_diagnosa_tambahan,
				d.nmruang AS nmruang,
				A.lengkap,
				A.tgl_dilengkapi,
				A.xuser,
				hm.NAME AS verifikator 
			FROM
				pasien_iri
				AS A LEFT OUTER JOIN icd1 AS b ON A.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien AS C ON A.no_medrec = C.no_medrec
				LEFT JOIN ruang AS d ON A.idrg = d.idrg
				LEFT OUTER JOIN diagnosa_iri AS e ON A.no_ipd = e.no_register
				LEFT OUTER JOIN hmis_users AS hm ON hm.userid = A.user_verif 
			WHERE
				LEFT ( A.tgl_keluar, 10 ) >= '$tgl' 
				AND LEFT ( A.tgl_keluar, 10 ) <= '$tgl1'
			GROUP BY
				A.no_ipd,
				A.nama,
				A.klsiri,
				A.carabayar,
				A.nm_ruang,
				b.id_icd,
				b.nm_diagnosa,
				C.tgl_lahir,
				C.sex,
				C.no_cm,
				A.id_kontraktor,
				d.nmruang,
				A.tgl_masuk,
				A.tgl_keluar,
				A.id_dokter,
				A.user_plg,
				A.lengkap,
				A.tgl_dilengkapi,
				A.xuser,
				hm.NAME 
			ORDER BY
				A.tgl_keluar DESC");

		return $data;
	}

	public function get_list_utdrs_iri($no_ipd)
	{
		$data = $this->db->query("SELECT A
		.*,
		y.*,
		x.tarif as total_tarif,
		x.tarif as tarif_jatah_bpjs
	FROM
		pemeriksaan_unitdarah AS A,
		jenis_tindakan_new AS x,
		pasien_iri AS y 
	WHERE
		A.id_tindakan = x.idtindakan 
		AND A.no_register = y.no_ipd 
		AND y.no_ipd = '$no_ipd' 
		AND no_utdrs IS NOT NULL ");
		return $data->result_array();
	}

	public function get_list_utd_ird($no_register)
	{
		$data = $this->db->query("SELECT * FROM pemeriksaan_unitdarah WHERE no_register = '$no_register'");
		return $data->result_array();
	}


  
}
