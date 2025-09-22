<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Labmdaftar extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	//modul for labcdaftar
	function get_daftar_pasien_lab()
	{
		$week_akhir = date('Y-m-d');
		$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -31 day'));
		return $this->db->query("SELECT pemeriksaan_lab.waktu_masuk_lab ,pemeriksaan_lab.no_register ,
				pemeriksaan_lab.no_medrec as  no_medrec ,pemeriksaan_lab.tgl_kunjungan ,pemeriksaan_lab.order_lab_cito,
				pemeriksaan_lab.kelas ,pemeriksaan_lab.idrg ,pemeriksaan_lab.bed , 
				pemeriksaan_lab.cara_bayar,  pemeriksaan_lab.nama AS nama, pemeriksaan_lab.dokter AS dokter,pemeriksaan_lab.no_cm,
				pemeriksaan_lab.jadwal_lab,(select cito from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = pemeriksaan_lab.no_register and cito is not null limit 1) as cito
			FROM 
				pemeriksaan_lab  
			WHERE  
				pemeriksaan_lab.lab = '1'
				AND to_char(pemeriksaan_lab.jadwal_lab,'YYYY-MM-DD') BETWEEN '$week_awal' AND '$week_akhir' 
			ORDER BY pemeriksaan_lab.jadwal_lab DESC");
		// return $this->db->query("
		// 	SELECT 
		// 	pemeriksaan_laboratorium.waktu_masuk_lab, 
		// 	pemeriksaan_laboratorium.no_register, 
		// 	data_pasien.no_cm as no_medrec, 
		// 	pemeriksaan_laboratorium.tgl_kunjungan as tgl_kunjungan, 
		// 	pemeriksaan_laboratorium.kelas, 
		// 	pemeriksaan_laboratorium.idrg, 
		// 	pemeriksaan_laboratorium.bed, 
		// 	data_pasien.nama as nama  
		// 				FROM pemeriksaan_laboratorium, data_pasien 
		// 				WHERE 
		// 				pemeriksaan_laboratorium.lab = '1' and pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec

		// 			");
		// AND LEFT(pemeriksaan_laboratorium.tgl_kunjungan,10)=LEFT(NOW(),10)
		// 		UNION
		// SELECT  c.tgl_pemeriksaan AS waktu_masuk_lab,
		// 		c.idurikes AS no_medrec,
		// 		d.pangkat AS no_register,
		// 		c.tgl_pemeriksaan AS tgl_kunjungan,
		// 		c.kelompok AS kelas,
		// 		c.catatan AS idrg,
		// 		c.tgl_cetak_kw AS bed,
		// 		c.nama AS nama
		// 		FROM
		// 			urikkes_pasien AS c
		// 		LEFT join 
		// 			tni_pangkat AS d on c.kdpangkat = d.pangkat_id
		// 		LEFT JOIN
		// 			urikkes_master_paket_detail AS e on c.jenis_pemeriksaan = e.kode_paket 
		// 		WHERE
		// 		LEFT(c.tgl_pemeriksaan,10) = LEFT(NOW(),10)
		// 		AND e.poli_paket = 'BZ04'
		// 		GROUP BY
		// 			c.idurikes
		// 		ORDER BY tgl_kunjungan DESC
	}

	// 		function get_daftar_pasien_lab_by_date($date){
	// 			return $this->db->query("
	// 			SELECT pemeriksaan_laboratorium.waktu_masuk_lab ,pemeriksaan_laboratorium.no_register ,data_pasien.no_cm AS no_medrec ,pemeriksaan_laboratorium.tgl_kunjungan ,pemeriksaan_laboratorium.kelas ,pemeriksaan_laboratorium.idrg ,pemeriksaan_laboratorium.bed ,data_pasien.nama AS nama 
	// 			FROM pemeriksaan_laboratorium,data_pasien 
	// 			WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec 
	// 			and pemeriksaan_laboratorium.cetak_kwitansi is null
	// 			AND to_char (pemeriksaan_laboratorium.tgl_kunjungan,'YYYY-MM-DD')='$date' ");
	// //					
	// 		}
	function get_kontraktor_kerjasama()
	{
		return $this->db->query("SELECT * FROM kontraktor WHERE bpjs = 'KERJASAMA'");
	}

	function get_daftar_pasien_lab_by_date($date)
	{
		return $this->db->query("SELECT pemeriksaan_lab.waktu_masuk_lab ,pemeriksaan_lab.no_register ,
		pemeriksaan_lab.no_medrec as  no_medrec ,pemeriksaan_lab.tgl_kunjungan , pemeriksaan_lab.order_lab_cito,
		pemeriksaan_lab.kelas ,pemeriksaan_lab.idrg ,pemeriksaan_lab.bed , 
		pemeriksaan_lab.cara_bayar,  pemeriksaan_lab.nama AS nama, pemeriksaan_lab.dokter AS dokter,pemeriksaan_lab.no_cm,
		pemeriksaan_lab.jadwal_lab,(select cito from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = pemeriksaan_lab.no_register and cito is not null limit 1) as cito
		FROM pemeriksaan_lab WHERE  
		pemeriksaan_lab.lab = '1' and 
		to_char (pemeriksaan_lab.jadwal_lab,'YYYY-MM-DD')='$date'
		ORDER BY pemeriksaan_lab.jadwal_lab DESC");
	}

	function get_daftar_pasien_lab_by_no($key)
	{
		// return $this->db->query("
		// 	SELECT pemeriksaan_laboratorium.waktu_masuk_lab, pemeriksaan_laboratorium.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_laboratorium.tgl_kunjungan, pemeriksaan_laboratorium.kelas, pemeriksaan_laboratorium.idrg, pemeriksaan_laboratorium.bed, data_pasien.nama as nama  
		// 							FROM pemeriksaan_laboratorium, data_pasien 
		// 							WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec 
		// 							AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_laboratorium.no_register LIKE '%$key%')
		// 						UNION
		// 							SELECT pemeriksaan_laboratorium.waktu_masuk_lab, pemeriksaan_laboratorium.no_register, pemeriksaan_laboratorium.no_medrec, pemeriksaan_laboratorium.tgl_kunjungan, pemeriksaan_laboratorium.kelas, pemeriksaan_laboratorium.idrg, pemeriksaan_laboratorium.bed, pasien_luar.nama as nama  
		// 							FROM pemeriksaan_laboratorium, pasien_luar 
		// 							WHERE pemeriksaan_laboratorium.no_register=pasien_luar.no_register 
		// 							AND (pasien_luar.nama LIKE '%$key%' OR pemeriksaan_laboratorium.no_register LIKE '%$key%')
		// 							ORDER BY tgl_kunjungan DESC"
		// 						);

		// return $this->db->query("SELECT pemeriksaan_laboratorium.waktu_masuk_lab, pemeriksaan_laboratorium.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_laboratorium.tgl_kunjungan, pemeriksaan_laboratorium.kelas, pemeriksaan_laboratorium.idrg, pemeriksaan_laboratorium.bed, data_pasien.nama as nama, pemeriksaan_lab.jadwal_lab  
		// 	FROM pemeriksaan_laboratorium, data_pasien 
		// 	WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec 
		// 	AND pemeriksaan_lab.lab = '1'
		// 	AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_laboratorium.no_register LIKE '%$key%')
		// 	ORDER BY pemeriksaan_lab.jadwal_lab DESC"
		// );
		return $this->db->query("SELECT pemeriksaan_lab.waktu_masuk_lab ,pemeriksaan_lab.no_register ,
									pemeriksaan_lab.no_medrec as  no_medrec ,pemeriksaan_lab.tgl_kunjungan ,pemeriksaan_lab.order_lab_cito,
									pemeriksaan_lab.kelas ,pemeriksaan_lab.idrg ,pemeriksaan_lab.bed , pemeriksaan_lab.no_cm,
									pemeriksaan_lab.cara_bayar,  pemeriksaan_lab.nama AS nama, pemeriksaan_lab.dokter AS dokter,
									pemeriksaan_lab.jadwal_lab,(select cito from pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register = pemeriksaan_lab.no_register and cito is not null limit 1) as cito
									FROM pemeriksaan_lab  WHERE  
									pemeriksaan_lab.lab = '1'
									AND no_cm LIKE '%$key%'
									ORDER BY pemeriksaan_lab.jadwal_lab DESC");
	}

	function get_data_pasien_pemeriksaan($no_register)
	{
		// 	return $this->db->query("SELECT
		// 	daftar_ulang_irj.*, data_pasien.nama, data_pasien.no_cm, data_pasien.foto
		// FROM
		// 	daftar_ulang_irj,
		// 	data_pasien 
		// WHERE
		// 	daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
		// AND daftar_ulang_irj.no_register = '$no_register'");


		//return $this->db->query("SELECT *  FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.no_register='$no_register'");
		return $this->db->query("SELECT *  FROM pemeriksaan_lab, data_pasien WHERE 
			pemeriksaan_lab.no_medrec=data_pasien.no_medrec AND pemeriksaan_lab.no_register='$no_register'
			");
	}

	function get_data_pasien_kontraktor_irj($no_register)
	{
		return $this->db->query("SELECT nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor AND daftar_ulang_irj.no_register='$no_register'");
	}

	function get_data_pasien_kontraktor_iri($no_register)
	{
		return $this->db->query("SELECT nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor=kontraktor.id_kontraktor AND pasien_iri.no_ipd='$no_register'");
	}

	function get_data_pasien_luar_pemeriksaan($no_register)
	{
		return $this->db->query("SELECT * FROM  pasien_luar WHERE  pasien_luar.no_register='$no_register'");
	}

	function get_data_pemeriksaan($no_register)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_register='$no_register' and no_lab is null ");
	}

	function getdata_tindakan_pasien2($no_register)
	{
		return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_laboratorium where pemeriksaan_laboratorium.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_laboratorium.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
	}

	function getdata_tindakan_pasien()
	{
		return $this->db->query("SELECT * FROM jenis_tindakan_lab WHERE deleted = 0 OR deleted IS NULL ORDER BY idtindakan asc");
	}
	function get_master_jenis_kuman_lab()
	{
		return $this->db->get('master_jenis_kuman_lab');
	}

	function insert_tindakan($data)
	{
		$this->db->insert('pelayanan_poli', $data);
		return $this->db->insert_id();
	}
	public function get_detail_tindakan($id_tindakan)
	{
		return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
			and b.kelas='NK'");
	}

	function get_biaya_tindakan_($id, $kelas)
	{
		return $this->db->query("SELECT total_tarif, tarif_iks, tarif_bpjs FROM tarif_tindakan WHERE id_tindakan='" . $id . "' AND kelas = '" . $kelas . "'");
	}

	function get_biaya_tindakan($id, $kelas)
	{
		return $this->db->query("SELECT
				tarif as total_tarif
			FROM
				jenis_tindakan_new 
			WHERE
				idtindakan = '$id'");
	}

	function get_roleid($userid)
	{
		return $this->db->query("Select roleid from dyn_role_user where userid = '" . $userid . "'");
	}

	function getdata_dokter()
	{
		//	return $this->db->query("SELECT  a.id_dokter, a.nm_dokter FROM data_dokter as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Patologi Klinik' or b.id_poli='BZ04' and a.deleted=0");
		return $this->db->query("SELECT  a.id_dokter, a.nm_dokter 
			FROM data_dokter a
			inner join dokter_poli b on a.id_dokter = b.id_dokter
			where a.deleted=0
			and b.id_poli = 'BZ04'
			group by a.id_dokter, a.nm_dokter ");
	}

	function getnama_poli($id_poli)
	{
		return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
	}

	function getnm_dokter($no_register)
	{
		if (substr($no_register, 0, 2) == 'RJ') {
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		} elseif (substr($no_register, 0, 2) == 'RI') {
			return $this->db->query("SELECT b.nm_dokter FROM pasien_iri as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_ipd='$no_register'");
		} else {
			return $this->db->query("SELECT dokter as nm_dokter FROM pasien_luar 
				WHERE no_register='$no_register'");
		}
	}

	function getcr_bayar_bpjs($no_register)
	{
		return $this->db->query("SELECT b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
	}

	function getcr_bayar_dijamin($no_register)
	{
		if (substr($no_register, 0, 2) == 'RJ') {
			return $this->db->query("SELECT a.cara_bayar as a, b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		} else {
			return $this->db->query("SELECT a.carabayar as a, b.nmkontraktor as b FROM pasien_iri as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_ipd='$no_register'");
		}
	}

	function getruang($idrg)
	{
		return $this->db->query("SELECT nmruang FROM ruang WHERE idrg='$idrg'");
	}

	function getnama_dokter($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='$id_dokter'");
		//return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter= 3");
	}

	function getjenis_tindakan($id_tindakan)
	{
		return $this->db->query("SELECT * FROM jenis_tindakan_new WHERE idtindakan='" . $id_tindakan . "' ");
	}

	function insert_pemeriksaan($data)
	{
		//	print_r($data);die();
		$this->db->insert('pemeriksaan_laboratorium', $data);
		return true;
	}

	function selesai_daftar_pemeriksaan_PL_header($no_register, $getvtotlab, $no_lab)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register'");
		// $this->db->query("UPDATE pasien_luar SET lab=0, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_PL($no_register, $getvtotlab, $no_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register'");
		$this->db->query("UPDATE pasien_luar SET lab=0, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRJ_header($no_register, $getvtotlab, $no_lab)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register' and no_lab is null ");
		// $this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab=1, vtot_lab=$getvtotlab WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRJ($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null ");
		$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab='$status_lab', vtot_lab=$getvtotlab WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRD_header($no_register, $getvtotlab, $no_lab)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register' and no_lab is null ");
		// $this->db->query("UPDATE irddaftar_ulang SET lab=0, status_lab=1, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRD($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null ");
		$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab='$status_lab', vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRI_header($no_register, $status_lab, $vtot_lab, $no_lab)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab= '$no_lab' WHERE no_register='$no_register' and no_lab is null ");
		// $this->db->query("UPDATE pasien_iri SET lab=0, status_lab=1, vtot_lab='$vtot_lab' WHERE no_ipd='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRI($no_register, $status_lab, $vtot_lab, $no_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab= '$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null ");
		$this->db->query("UPDATE pasien_iri SET lab=0, status_lab='$status_lab', vtot_lab='$vtot_lab' WHERE no_ipd='$no_register'");
		return true;
	}

	function getdata_iri($no_register)
	{
		return $this->db->query("SELECT status_lab FROM pasien_iri WHERE no_ipd='" . $no_register . "'");
	}

	function getdata_rj($no_register)
	{
		return $this->db->query("SELECT status_lab FROM daftar_ulang_irj WHERE no_register='" . $no_register . "'");
	}

	function get_vtot_lab($no_register)
	{
		return $this->db->query("SELECT SUM(NULLIF (vtot,0)) as vtot_lab FROM pemeriksaan_laboratorium WHERE no_register='" . $no_register . "'");
	}

	function get_vtot_no_lab($no_lab)
	{
		return $this->db->query("SELECT SUM(vtot) as vtot_no_lab FROM pemeriksaan_laboratorium WHERE no_lab='" . $no_lab . "'");
	}

	function hapus_data_pemeriksaan($id_pemeriksaan_laboratorium)
	{
		$this->db->where('id_pemeriksaan_lab', $id_pemeriksaan_laboratorium);
		$this->db->delete('pemeriksaan_laboratorium');
		return true;
	}


	function insert_data_header($no_register, $idrg, $bed, $kelas)
	{
		return $this->db->query("INSERT INTO lab_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
	}

	function get_data_header($no_register, $idrg, $bed, $kelas)
	{
		return $this->db->query("SELECT no_lab FROM lab_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_lab DESC LIMIT 1");
	}
	function get_data_header_non_hema_non_mikro($no_register, $idrg, $bed, $kelas)
	{
		return $this->db->query("SELECT no_lab FROM lab_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' and mikro is null and hema is null ORDER BY no_lab DESC LIMIT 1");
	}

	function insert_pasien_luar($data)
	{
		$tahun = date('Y');
		$depan = substr($tahun, 2, 2);
		$this->db->set('no_register', "(select 'PLL" . $depan . "' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM pasien_luar where \"jenis_PL\" = 'LAB' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
		$this->db->insert('pasien_luar', $data);
		return true;
	}

	// function insert_pasien_luar($data){
	// 	$this->db->insert('pasien_luar', $data);
	// 	return true;
	// }

	function get_new_register()
	{
		//return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");

		return $this->db->query("SELECT max(right(no_register,6)) as counter, substring(to_char(now(),'YYYY-MM-DD'),3,2) as year 
			from pasien_luar where substring(no_register,3,2) = (select substring(to_char(now(),'YYYY-MM-DD'),3,2))");
	}

	// function get_new_register(){
	// 	return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
	// }


	//modul for labcpengisianhasil /////////////////////////////////////////////////////////////

	function get_hasil_lab()
	{
		return $this->db->query("SELECT cetak_hasil, nama, a.no_lab, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND no_lab is not null
			GROUP BY no_lab
			UNION
			SELECT cetak_hasil, nama, b.no_lab, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot 
			FROM pemeriksaan_laboratorium b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND no_lab is not null
			GROUP BY no_lab ORDER BY tgl asc");
	}

	function get_hasil_lab_by_date($date)
	{
		// return $this->db->query("SELECT cetak_hasil, nama, a.no_lab, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
		// FROM pemeriksaan_laboratorium a, data_pasie
		// WHERE a.no_medrec=data_pasien.no_medrec AND no_lab is not null AND left(a.tgl_kunjungan,10)  = '$date'
		// GROUP BY no_lab
		// UNION
		// SELECT cetak_hasil, nama, b.no_lab, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot 
		// FROM pemeriksaan_laboratorium b, pasien_luar 
		// WHERE b.no_register=pasien_luar.no_register AND no_lab is not null AND left(b.tgl_kunjungan,10)  = '$date'
		// GROUP BY no_lab ORDER BY tgl asc");

		return $this->db->query("SELECT A.cetak_hasil, B.nama, A.no_lab, A.cara_bayar, A.no_register, 
			TO_CHAR(A.tgl_kunjungan,'YYYY-MM-DD') AS tgl, COUNT ( 1 ) AS banyak, 
			( SELECT COUNT ( hasil_periksa ) AS hasil FROM pemeriksaan_laboratorium 
			 WHERE no_lab = A.no_lab AND hasil_periksa != 0 ) AS selesai, cetak_kwitansi, 
			 CAST(SUM ( vtot ) AS bigint) AS vtot, A.no_medrec, a.tgl_selesai_pemeriksaan, a.tgl_mulai_pemeriksaan
			 FROM pemeriksaan_laboratorium A, data_pasien B
			 WHERE 
			 A.no_medrec = B.no_medrec 
			 AND no_lab IS NOT NULL 
			 and substr(A.no_register,1,2) <> 'PL'
			 AND to_char ( A.tgl_kunjungan,'YYYY-MM-DD' ) = '$date' 
			 GROUP BY A.no_lab,A.cetak_hasil, B.nama, A.no_lab, A.cara_bayar, A.no_register, 
			 TO_CHAR(A.tgl_kunjungan,'YYYY-MM-DD'), A.cetak_kwitansi,A.no_medrec, a.tgl_selesai_pemeriksaan, a.tgl_mulai_pemeriksaan

			 UNION
			 SELECT A.cetak_hasil, B.nama, A.no_lab, A.cara_bayar, A.no_register, 
			 TO_CHAR(A.tgl_kunjungan,'YYYY-MM-DD') AS tgl, COUNT ( 1 ) AS banyak, 
			 ( SELECT COUNT ( hasil_periksa ) AS hasil FROM pemeriksaan_laboratorium 
			  WHERE no_lab = A.no_lab AND hasil_periksa != 0 ) AS selesai, A.cetak_kwitansi, 
			  CAST(SUM ( vtot ) AS bigint) AS vtot, A.no_medrec, a.tgl_selesai_pemeriksaan, a.tgl_mulai_pemeriksaan
			  FROM pemeriksaan_laboratorium A, pasien_luar B 
			  WHERE A.no_register = B.no_register AND no_lab IS NOT NULL 
			  AND to_char ( A.tgl_kunjungan,'YYYY-MM-DD' ) = '$date' 
			  GROUP BY A.no_lab,A.cetak_hasil, B.nama, A.no_lab, A.cara_bayar, 
			  A.no_register, TO_CHAR(A.tgl_kunjungan,'YYYY-MM-DD'), A.cetak_kwitansi,A.no_medrec, a.tgl_selesai_pemeriksaan, a.tgl_mulai_pemeriksaan
			");
	}

	function get_hasil_lab_by_no($key)
	{
		return $this->db->query("SELECT cetak_hasil, nama, a.no_lab, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa is not null) as selesai, cetak_kwitansi, sum(vtot) as vtot ,A.no_medrec
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND no_lab is not null AND  data_pasien.no_cm LIKE '%$key%' 
			GROUP BY no_lab,cetak_hasil,nama, a.no_lab, a.cara_bayar, a.no_register,tgl,cetak_kwitansi,vtot,A.no_medrec
			UNION
			SELECT cetak_hasil, nama, b.no_lab, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa is not null) as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot ,b.no_medrec
			FROM pemeriksaan_laboratorium b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND no_lab is not null AND  b.no_register LIKE '%$key%' 
			GROUP BY no_lab,cetak_hasil,nama, b.no_lab, b.cara_bayar, b.no_register,tgl,pasien_luar.cetak_kwitansi,vtot_lab,b.no_medrec
			 ORDER BY tgl asc");
	}

	function getrow_hasil_lab($no_register)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.no_register='" . $no_register . "' ");
	}

	function get_row_register($id_pemeriksaan_laboratorium)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE id_pemeriksaan_laboratorium='$id_pemeriksaan_laboratorium'");
	}

	function get_row_register_by_nolab($no_lab)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab' LIMIT 1");
	}

	function get_row_register_by_nomed($no_medrec)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE no_medrec='$no_medrec'");
	}

	function get_row_hasil($no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab='$no_lab' LIMIT 1");
	}

	function get_data_pengisian_hasil($no_lab)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_lab='" . $no_lab . "'  AND cetak_hasil='0' ORDER BY no_lab");
	}

	function get_isi_hasil($no_lab)
	{
		return $this->db->query("SELECT a.id_tindakan as idtindak, a.jenis_tindakan, a.id_pemeriksaan_lab, b.* 
			FROM pemeriksaan_laboratorium as a 
				LEFT JOIN jenis_hasil_lab as b ON a.id_tindakan=b.id_tindakan 
				WHERE a.no_lab='" . $no_lab . "' ORDER BY a.id_tindakan");
	}

	function get_edit_hasil($no_lab)
	{
		return $this->db->query("SELECT a.*, b.nmtindakan FROM hasil_pemeriksaan_lab as a LEFT JOIN jenis_tindakan as b ON a.id_tindakan=b.idtindakan WHERE no_lab='" . $no_lab . "'");
	}

	function get_banyak_hasil_lab($no_register)
	{
		return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_register=" . $no_register . "' ");
	}

	function get_data_hasil_pemeriksaan($no_lab)
	{
		return $this->db->query("SELECT *, TO_CHAR(pemeriksaan_laboratorium.tgl_kunjungan,'YYYY-MM-DD') as tgl FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.no_lab='$no_lab' LIMIT 1");
	}

	function get_data_hasil_pemeriksaan_pasien_luar($no_lab)
	{
		return $this->db->query("SELECT *, TO_CHAR(pemeriksaan_laboratorium.tgl_kunjungan,'YYYY-MM-DD') as tgl FROM pemeriksaan_laboratorium, pasien_luar WHERE pemeriksaan_laboratorium.no_register=pasien_luar.no_register AND pemeriksaan_laboratorium.no_lab='$no_lab' LIMIT 1");
	}

	function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_laboratorium)
	{
		return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.id_pemeriksaan_laboratorium='$id_pemeriksaan_laboratorium'");
	}

	function get_data_tindakan_lab($id_tindakan)
	{
		return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_lab.* FROM jenis_hasil_lab, jenis_tindakan WHERE  jenis_hasil_lab.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
	}

	function isi_hasil($data)
	{
		$this->db->insert('hasil_pemeriksaan_lab', $data);
		return true;
	}

	function set_hasil_periksa($id_pemeriksaan_laboratorium)
	{
		return $this->db->query("UPDATE pemeriksaan_laboratorium SET hasil_periksa=1 WHERE id_pemeriksaan_lab='$id_pemeriksaan_laboratorium'");
	}

	function set_hasil_periksa_by_noreg($noreg)
	{
		return $this->db->query("UPDATE pemeriksaan_laboratorium SET hasil_periksa=1 WHERE no_register='$noreg'");
	}


	function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_laboratorium)
	{
		return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, pasien_luar WHERE pemeriksaan_laboratorium.no_register=pasien_luar.no_register AND pemeriksaan_laboratorium.id_pemeriksaan_laboratorium='$id_pemeriksaan_laboratorium'");
	}

	function get_data_edit_tindakan_lab($id_tindakan, $no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_laboratorium WHERE  id_tindakan='$id_tindakan' AND no_lab='$no_lab'");
	}

	function get_no_register($no_lab)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE  no_lab='$no_lab' GROUP BY no_register");
	}

	function edit_hasil($id_hasil_pemeriksaan, $hasil_lab, $data_update)
	{
		// return $this->db->query("UPDATE hasil_pemeriksaan_laboratorium SET hasil_lab='$hasil_lab' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		$data['hasil_lab'] = $hasil_lab;
		$this->db->where('id_hasil_pemeriksaan', $id_hasil_pemeriksaan);
		return $this->db->update('hasil_pemeriksaan_lab', $data_update);
	}

	function update_status_cetak_hasil($no_lab)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_hasil='1',tgl_selesai_pemeriksaan = 'now()' where no_lab='$no_lab'");
		return true;
	}

	function get_jenis_lab()
	{
		return $this->db->query("SELECT * FROM jenis_lab");
	}

	function get_data_kategori_lab($no_lab)
	{
		// return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
		// 		FROM hasil_pemeriksaan_lab as a
		// 		LEFT JOIN jenis_lab as b
		// 		ON LEFT(a.id_tindakan,2)=b.kode_jenis
		// 		WHERE no_lab='$no_lab' AND hasil_lab!='' 
		// 		GROUP BY LEFT(id_tindakan,2),b.nama_jenis");

		return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM hasil_pemeriksaan_lab as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE 
					no_lab='$no_lab' 
					AND hasil_lab!='' 
					AND a.id_tindakan NOT IN ('HK0136','HK0137','HM0122','HM0123','HM0124','HM0125','HM0126','HM0127','HM0128','HM0129','HM0130','HM0131','HM0132','HM0133')
				GROUP BY LEFT(id_tindakan,2),b.nama_jenis");
	}

	function get_data_kategori_lab_kultur($no_lab) {
		return $this->db->query("SELECT 
			LEFT(a.id_tindakan,2) AS kode_jenis, 
			b.nama_jenis
		FROM 
			hasil_pemeriksaan_lab as a
			LEFT JOIN jenis_lab as b ON LEFT(a.id_tindakan,2)=b.kode_jenis
		WHERE 
			no_lab='$no_lab' 
			AND hasil_lab!='' 
			AND a.id_tindakan IN ('HK0136','HK0137','HM0122','HM0123','HM0124','HM0125','HM0126','HM0127','HM0128','HM0129','HM0130','HM0131','HM0132','HM0133')
		GROUP BY LEFT(id_tindakan,2),b.nama_jenis");
	}

	function get_data_kategori_lab_api($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM pemeriksaan_laboratorium as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_lab='$no_lab' AND id_tindakan='$id_tindakan' 
				GROUP BY LEFT(id_tindakan,2),b.nama_jenis");
	}

	function get_data_kategori_lab_new($no_lab)
	{
		return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM hasil_pemeriksaan_lab as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE CAST(no_lab AS VARCHAR)='$no_lab' AND hasil_lab!='' 
				GROUP BY LEFT(id_tindakan,2),b.nama_jenis");
	}

	function get_blanko_kategori_lab($no_lab)
	{
		return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM pemeriksaan_laboratorium as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_lab='$no_lab'
				GROUP BY LEFT(id_tindakan,2)");
	}

	function get_data_jenis_lab($no_lab)
	{
		// return $this->db->query("
		// 		SELECT A .id_tindakan, A.no_lab, b.nmtindakan FROM hasil_pemeriksaan_lab A, 
		// 		jenis_tindakan b,
		// 		pemeriksaan_laboratorium AS c 
		// 		WHERE A.id_tindakan = b.idtindakan AND 
		// 		a.no_lab = '$no_lab' 
		// 		AND hasil_lab::varchar  !=''
		// 		AND a.no_lab::varchar = cast(C.no_lab as text)  GROUP BY a.id_tindakan, A.no_lab, b.nmtindakan

		// 		");

		return $this->db->query("SELECT
			A .id_tindakan, 
			A.no_lab, 
			b.nmtindakan 
		FROM 
			hasil_pemeriksaan_lab A, 
			jenis_tindakan_new b,
			pemeriksaan_laboratorium AS c 
		WHERE 
			A.id_tindakan = b.idtindakan 
			AND a.no_lab = '$no_lab' 
			AND a.id_tindakan NOT IN ('HK0136','HK0137','HM0122','HM0123','HM0124','HM0125','HM0126','HM0127','HM0128','HM0129','HM0130','HM0131','HM0132','HM0133')
			AND hasil_lab::varchar  !=''
			AND a.no_lab::varchar = cast(C.no_lab as text)  
		GROUP BY a.id_tindakan, A.no_lab, b.nmtindakan");
	}

	function get_data_jenis_lab_kultur($no_lab) {
		return $this->db->query("SELECT
			A .id_tindakan, 
			A.no_lab, 
			b.nmtindakan 
		FROM 
			hasil_pemeriksaan_lab A, 
			jenis_tindakan b,
			pemeriksaan_laboratorium AS c 
		WHERE 
			A.id_tindakan = b.idtindakan 
			AND a.no_lab = '$no_lab' 
			AND a.id_tindakan IN ('HK0136','HK0137','HM0122','HM0123','HM0124','HM0125','HM0126','HM0127','HM0128','HM0129','HM0130','HM0131','HM0132','HM0133')
			AND hasil_lab::varchar  !=''
			AND a.no_lab::varchar = cast(C.no_lab as text)  
		GROUP BY a.id_tindakan, A.no_lab, b.nmtindakan");
	}

	function get_data_jenis_lab_api($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT A
				.id_tindakan,
				A.no_lab,
				b.nmtindakan 
			FROM
				pemeriksaan_laboratorium A,
				jenis_tindakan b 
			WHERE
				A.id_tindakan = b.idtindakan 
				AND no_lab = '$no_lab' 
				AND id_tindakan = '$id_tindakan' 
			GROUP BY
				a.id_tindakan,
				A.no_lab,
				b.nmtindakan");
	}

	function get_data_jenis_lab_new($no_lab)
	{
		return $this->db->query("SELECT a.id_tindakan, a.no_lab, b.nmtindakan FROM hasil_pemeriksaan_lab a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND CAST(no_lab AS VARCHAR)='$no_lab' AND hasil_lab!=''  GROUP BY id_tindakan,a.no_lab,b.nmtindakan");
	}

	function get_blanko_jenis_lab($no_lab)
	{
		return $this->db->query("SELECT a.id_tindakan, a.no_lab, b.nmtindakan FROM pemeriksaan_laboratorium a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_lab='$no_lab' GROUP BY id_tindakan");
	}

	function get_data_hasil_lab($id_tindakan, $no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE id_tindakan='$id_tindakan' AND no_lab='$no_lab' AND hasil_lab!='' order by no_urut asc");
	}

	function get_data_hasil_lab_new($no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab='$no_lab' AND hasil_lab!=''");
	}

	function get_blanko_hasil_lab($id_tindakan)
	{
		return $this->db->query("SELECT * FROM jenis_hasil_lab WHERE id_tindakan='$id_tindakan'");
	}

	function get_data_pasien_cetak($no_lab)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_lab='$no_lab'");
	}

	function get_id_pemeriksaan_lab($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT id_pemeriksaan_lab FROM pemeriksaan_laboratorium WHERE id_tindakan='$id_tindakan' AND no_lab='$no_lab'");
	}

	function get_data_pasien_cetak_new($no_rad)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND a.no_rad='$no_rad'");
	}

	function get_data_pasien_luar_cetak($no_lab)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium a, pasien_luar WHERE a.no_medrec=pasien_luar.no_cm AND no_lab='$no_lab'");
	}

	function get_data_pasien_luar_cetak_new($no_medrec)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium a, pasien_luar WHERE a.no_medrec=pasien_luar.no_cm AND no_cm='$n0_medrec'");
	}
	//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

	function get_hasil_lab_selesai()
	{
		return $this->db->query("SELECT 
				b.nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND cetak_hasil='1' 
				and substr(A.no_register,1,2) <> 'PL'
				AND no_lab is not null 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')=to_char(NOW(),'YYYY-MM-DD') 
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan UNION 
			SELECT 
				nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				pasien_luar b 
			WHERE 
				a.no_register=b.no_register 
				AND cetak_hasil='1' 
				AND no_lab is not null 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')=to_char(NOW(),'YYYY-MM-DD') 
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan");
	}

	function get_hasil_lab_by_date_selesai($date)
	{
		return $this->db->query("SELECT 
				b.nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND cetak_hasil='1' 
				and substr(A.no_register,1,2) <> 'PL'
				AND no_lab is not null 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$date'
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan UNION 
			SELECT 
				nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				pasien_luar b 
			WHERE 
				a.no_register=b.no_register 
				AND cetak_hasil='1' 
				AND no_lab is not null 
				AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')  = '$date'
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan");
	}

	function get_hasil_lab_by_no_selesai($key)
	{
		return $this->db->query("SELECT 
				b.nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				data_pasien b
			WHERE 
				a.no_medrec=b.no_medrec 
				AND cetak_hasil='1' 
				and substr(A.no_register,1,2) <> 'PL'
				AND no_lab is not null 
				AND b.no_cm LIKE '%$key%'
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan UNION 
			SELECT 
				nama, 
				a.no_medrec, 
				a.no_lab, 
				a.no_register,
				a.jenis_tindakan,
				a.id_tindakan,
				a.tgl_kunjungan as tgl, 
				count(1) as banyak, 
				(SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!=0) as selesai, 
				a.cetak_kwitansi, 
				sum(vtot) as vtot, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan
			FROM 
				pemeriksaan_laboratorium a, 
				pasien_luar b 
			WHERE 
				a.no_register=b.no_register 
				AND cetak_hasil='1' 
				AND no_lab is not null 
				AND a.no_register LIKE '%$key%'
			GROUP BY 
				no_lab,
				nama,
				RIGHT(a.no_register,6),
				a.no_register,
				tgl,
				a.cetak_kwitansi,
				a.no_medrec,
				a.jenis_tindakan,
				a.id_tindakan, 
				b.no_hp, 
				b.email,
				a.tgl_mulai_pemeriksaan,
				a.tgl_selesai_pemeriksaan");
	}

	function getnm_dokter_rj($no_register)
	{
		return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
	}

	public function get_noreg_pemeriksaan_lab($no_medrec)
	{
		return $this->db->query("SELECT
				no_register
			FROM
				pemeriksaan_laboratorium 
			WHERE
				CAST ( no_medrec AS VARCHAR ) = '$no_medrec'
			GROUP BY
				no_register
			ORDER BY min(tgl_kunjungan) DESC limit 10");
	}

	public function get_no_register_by_medrec($no_medrec)
	{
		return $this->db->query("SELECT DISTINCT no_register FROM pemeriksaan_laboratorium WHERE CAST ( no_medrec AS VARCHAR ) = '$no_medrec'");
	}

	function get_umur($no_medrec)
	{
		// return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
		return $this->db->query("SELECT DATE_PART('year', now()) - DATE_PART('year',tgl_lahir) AS umurday,age(now(),tgl_lahir) FROM data_pasien where CAST(no_medrec AS VARCHAR)='$no_medrec'");
	}

	public function get_nolab_pemeriksaan_lab($no_medrec)
	{
		return $this->db->query("SELECT
				a.no_lab 
			FROM
				pemeriksaan_laboratorium a,
				hasil_pemeriksaan_lab c
			WHERE
				a.no_register = '$no_medrec' 
				AND a.no_lab IS NOT NULL 
				AND a.no_register = c.no_register
				AND a.cetak_hasil = 1
			GROUP BY
				a.no_lab 
			ORDER BY
				a.no_lab DESC");
	}

	public function get_nolab_pemeriksaan_lab_by_medrec($no_medrec)
	{
		return $this->db->query("SELECT
				a.no_lab 
			FROM
				pemeriksaan_laboratorium a,
				hasil_pemeriksaan_lab c
			WHERE
				a.no_medrec = '$no_medrec' 
				AND a.no_lab IS NOT NULL 
				AND a.no_register = c.no_register
				AND a.cetak_hasil = 1
			GROUP BY
				a.no_lab 
			ORDER BY
				a.no_lab DESC");
	}

	public function get_data_pasien_lab($no_medrec)
	{
		return $this->db->query("SELECT * FROM data_pasien WHERE no_medrec='$no_medrec'");
	}

	public function get_data_laboratorium_by_noipd($no_ipd)
	{
		return $this->db->query("SELECT b.*, c.nmtindakan,hmis_users.ttd as ttd_dokter_pengirim,hmis_users.name
			FROM
					hasil_pemeriksaan_lab as b
					LEFT JOIN jenis_tindakan_lab as c
					ON b.id_tindakan = c.idtindakan
					LEFT JOIN pemeriksaan_laboratorium on pemeriksaan_laboratorium.no_lab  = b.no_lab
					LEFT JOIN dyn_user_dokter on CAST(dyn_user_dokter.id_dokter as varchar) = pemeriksaan_laboratorium.id_dokter
					LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid
					WHERE b.no_register='$no_ipd'
			");
	}

	function getnm_dokter_ri($no_register)
	{
		return $this->db->query("SELECT dokter as nm_dokter FROM pasien_iri
				WHERE no_ipd='$no_register'");
	}

	function cek_lab($no_register)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='" . $no_register . "'");
	}

	function cek_soap_rj($no_register)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$no_register'");
	}

	function cek_soap($no_register)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$no_register' AND DATE(tgl_input) = current_date");
	}

	function update_data_soap($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('soap_pasien_rj', $data);
		return true;
	}

	// function getdata_tindakan_fisik($no_register)
	// {
	// 	return $this->db->query("SELECT *
	// 							 FROM pemeriksaan_fisik 
	// 							 where no_register='" . $no_register . "'");
	// }



	// function insert_data_fisik($data){
	// 	$this->db->insert('pemeriksaan_fisik', $data);
	// 	return true;
	// }

	function insert_data_soap($data)
	{
		$this->db->insert('soap_pasien_rj', $data);
		return true;
	}

	function update_data_fisik($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('pemeriksaan_fisik', $data);
		return true;
	}

	function get_data_dokter_pengisi_lab($no_lab)
	{
		return $this->db->query("SELECT id_dokter,nm_dokter FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab' ");
	}

	function get_data_dokter_pengisi_lab_new($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT id_dokter,nm_dokter FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab' AND id_tindakan='$id_tindakan'");
	}

	function input_dokter_isi($data, $no_lab)
	{
		$this->db->where('no_lab', $no_lab);
		$this->db->update('pemeriksaan_laboratorium', $data);
		return true;
	}

	function get_idpoli($no_register)
	{
		return $this->db->query("select id_poli from daftar_ulang_irj where no_register ='$no_register' ");
	}

	function get_dokter_kirim($no_register)
	{
		if (substr($no_register, 0, 2) == 'RJ') {
			return $this->db->query("SELECT nm_dokter from daftar_ulang_irj a, data_dokter b 
						where a.id_dokter = b.id_dokter and no_register ='$no_register' ");
		} elseif (substr($no_register, 0, 2) == 'RI') {
			return $this->db->query("SELECT nm_dokter from pasien_iri a, data_dokter b 
						where a.id_dokter = b.id_dokter and no_ipd ='$no_register' ");
		} else {
			return $this->db->query("SELECT dokter as nm_dokter from pasien_luar where  no_register ='$no_register' ");
		}
	}

	function get_nama_poli($idrg)
	{
		return $this->db->query("select nm_poli from poliklinik where id_poli ='$idrg' ");
	}


	// function get_data_pasien_urikes($no_register){
	// 	return $this->db->query("SELECT nomor_kode, nama, catatan, tgl_pemeriksaan, jenis_pemeriksaan, nama_paket FROM urikkes_pasien, urikkes_master_paket_detail, urikkes_master_paket WHERE urikkes_pasien.jenis_pemeriksaan=urikkes_master_paket.kode_paket AND urikkes_pasien.nomor_kode='$no_register'");
	// }

	// added @aldi
	function load_bridging_lab()
	{
		return $this->db->get('jenis_hasil_lab')->result();
	}

	function update_jenis_hasil_lab($data, $id)
	{
		$this->db->where('id_jenis_hasil_lab', $id);
		return $this->db->update('jenis_hasil_lab', $data);
	}

	function get_daftar_order($noreg)
	{
		return $this->db->query("SELECT * from pemeriksaan_laboratorium where no_register ='$noreg' ");
	}

	function data_kiriman_order($noreg)
	{
		return $this->db->query("SELECT 
				(select nm_dokter from data_dokter where data_dokter.id_dokter = pasien_iri.id_dokter) as dokter,
				(select nmruang from ruang where ruang.idrg = pasien_iri.idrg) as ruang
			from pasien_iri  where no_ipd = '$noreg'
			union 
			select
				(select nm_dokter from data_dokter where data_dokter.id_dokter = daftar_ulang_irj.id_dokter) as dokter,
				(select nm_poli from poliklinik where poliklinik.id_poli = daftar_ulang_irj.id_poli) as ruang	
			from daftar_ulang_irj where no_register = '$noreg' ");
	}

	function get_jenis_hasil_lab()
	{
		return $this->db->query("SELECT * from jenis_tindakan_lab ");
	}

	function get_isi_hasil_tgl($no_lab)
	{
		return $this->db->query("SELECT *
			FROM pemeriksaan_laboratorium as a 
				WHERE a.no_lab='" . $no_lab . "' ORDER BY a.id_tindakan");
	}

	function input_tgl_periksa_isi($data, $no_lab, $id_tindakan)
	{
		$this->db->where('no_lab', $no_lab);
		$this->db->where('id_tindakan', $id_tindakan);
		$this->db->update('pemeriksaan_laboratorium', $data);
		return true;
	}

	function get_tgl_periksa_lab($no_register)
	{
		return $this->db->query("SELECT tgl_isi FROM hasil_pemeriksaan_lab WHERE no_lab = '$no_register'");
	}

	function isi_hasil_lengkap($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT * from hasil_pemeriksaan_lab where no_lab ='$no_lab' and id_tindakan = '$id_tindakan' and (hasil_lab = '' or hasil_lab is null) ");
	}

	function get_isi_hasil_lengkap($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT a.id_tindakan as idtindak, a.jenis_tindakan, a.id_pemeriksaan_lab, b.* 
			FROM pemeriksaan_laboratorium as a 
				LEFT JOIN jenis_hasil_lab as b ON a.id_tindakan=b.id_tindakan 
				WHERE a.no_lab='" . $no_lab . "' and a.id_tindakan ='$id_tindakan' ORDER BY a.id_tindakan, b.no_urut ASC");
	}

	function get_edit_hasil_lengkap($no_lab, $id_tindakan)
	{
		$datas = $this->db->query("select nmtindakan from jenis_tindakan where idtindakan = '$id_tindakan' limit 1");
		if (strpos($datas->row()->nmtindakan, 'Kultur Dan Sensitifity') !== false) {
			return $this->db->query("
					SELECT a.id_tindakan,a.jenis_hasil,a.kadar_normal,a.satuan,hasil_pemeriksaan_lab.nama_organisme,
					(select no_lab from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_lab,
					(select no_register from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_register,
					(select ket from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as ket,
					(select nmtindakan from jenis_tindakan where idtindakan = '$id_tindakan' limit 1) as nmtindakan,
					hasil_pemeriksaan_lab.id_hasil_pemeriksaan,hasil_pemeriksaan_lab.jenis_hasil,hasil_pemeriksaan_lab.jenis_kuman,hasil_pemeriksaan_lab.mic,hasil_pemeriksaan_lab.sensitifitas
					FROM jenis_hasil_lab a
					LEFT JOIN hasil_pemeriksaan_lab on a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan
					where a.id_tindakan = '$id_tindakan' and hasil_pemeriksaan_lab.no_lab = '$no_lab'
					order by a.no_urut ASC
				");
		}
		if (strpos($datas->row()->nmtindakan, 'Pewarnaan') !== false) {
			return $this->db->query("
					SELECT a.id_tindakan,a.jenis_hasil,a.kadar_normal,a.satuan,hasil_pemeriksaan_lab.hasil_lab,
					(select no_lab from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_lab,
					(select no_register from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_register,
					(select ket from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as ket,
					(select nmtindakan from jenis_tindakan where idtindakan = '$id_tindakan' limit 1) as nmtindakan,
					hasil_pemeriksaan_lab.id_hasil_pemeriksaan,hasil_pemeriksaan_lab.jenis_hasil,hasil_pemeriksaan_lab.jenis_kuman,hasil_pemeriksaan_lab.mic,hasil_pemeriksaan_lab.sensitifitas
					FROM jenis_hasil_lab a
					LEFT JOIN hasil_pemeriksaan_lab on a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan
					where a.id_tindakan = '$id_tindakan' and hasil_pemeriksaan_lab.no_lab = '$no_lab'
					order by a.no_urut ASC
				");
		}
		return $this->db->query("SELECT a.id_tindakan,a.jenis_hasil,a.kadar_normal,a.satuan,
			(select no_lab from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_lab,
			(select no_register from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as no_register,
			(select ket from hasil_pemeriksaan_lab where no_lab = '$no_lab' limit 1) as ket,
			(select case when a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan and a.jenis_hasil = hasil_pemeriksaan_lab.jenis_hasil then hasil_lab else null end  from hasil_pemeriksaan_lab where no_lab = '$no_lab' and a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan and a.jenis_hasil = hasil_pemeriksaan_lab.jenis_hasil limit 1) as hasil_lab,
			(select case when a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan and a.jenis_hasil = hasil_pemeriksaan_lab.jenis_hasil then id_hasil_pemeriksaan else null end  from hasil_pemeriksaan_lab where no_lab = '$no_lab' and a.id_tindakan = hasil_pemeriksaan_lab.id_tindakan and a.jenis_hasil = hasil_pemeriksaan_lab.jenis_hasil limit 1) as id_hasil_pemeriksaan,
			(select nmtindakan from jenis_tindakan where idtindakan = '$id_tindakan' limit 1) as nmtindakan
			from jenis_hasil_lab as a 
			where a.id_tindakan ='$id_tindakan' ORDER BY a.no_urut ASC");
		// return $this->db->query("SELECT a.*, b.nmtindakan FROM hasil_pemeriksaan_lab as a LEFT JOIN jenis_tindakan as b ON a.id_tindakan=b.idtindakan WHERE no_lab='".$no_lab."' and a.id_tindakan ='$id_tindakan' ");
	}

	function get_ket_hasil($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab = '$no_lab' AND id_tindakan = '$id_tindakan'");
	}

	function cek_isi_hasil($no_lab, $id_tindakan)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab as a WHERE no_lab='" . $no_lab . "' and a.id_tindakan ='$id_tindakan' ");
	}

	function cek_isi_hasil_selesao($no_lab)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a WHERE no_lab='" . $no_lab . "' ");
	}

	function num_isi_hasil($no_lab)
	{
		return $this->db->query("SELECT id_tindakan,no_lab from hasil_pemeriksaan_lab WHERE no_lab='" . $no_lab . "' group by id_tindakan,no_lab ");
	}

	function ttd_haisl($id_dokter)
	{
		return $this->db->query("SELECT * FROM dyn_user_dokter a, hmis_users b
			where a.userid = b.userid and id_dokter = '$id_dokter'");
	}

	function update_rujukan_penunjang_irj($data, $no_register)
	{
		if ($no_register == null) {
			return false;
		} else {
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
	}

	function update_rujukan_penunjang_iri($data, $no_ipd)
	{
		if ($no_ipd == null) {
			return false;
		} else {
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}
	}

	function cek_hasil_edit_add($no_lab, $id_tindakan, $jenis_hasil)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab where no_lab = '$no_lab' and id_tindakan = '$id_tindakan' and jenis_hasil = '$jenis_hasil' ");
	}

	function get_data_pasien_by_noreg($noreg)
	{
		return $this->db->query("SELECT data_pasien.no_identitas,data_pasien.sex,TO_CHAR(data_pasien.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir,cast(data_pasien.no_cm as integer) AS no_cm,a.no_medrec,a.no_register,data_pasien.nama,data_pasien.alamat AS alamat,a.tgl_kunjungan AS tgl,a.kelas,a.cara_bayar,a.idrg AS ruang FROM pemeriksaan_laboratorium a,data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_register='$noreg' limit 1 ");
	}

	function get_data_pemeriksaan_by_noreg($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan, id_tindakan,tgl_kunjungan,xinput FROM pemeriksaan_laboratorium WHERE no_register='$noreg' and (to_char(tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD') or tgl_kunjungan is null) order by tgl_kunjungan asc ");
	}

	function get_ttd_by_userid($userid)
	{
		return $this->db->query("SELECT name,ttd from hmis_users where userid = '$userid' ");
	}

	function batal_kunjungan($no_register)
	{
		if (substr($no_register, 0, 2) == 'RJ') {
			return $this->db->query("UPDATE daftar_ulang_irj set lab = '0' where no_register='$no_register' ");
		} elseif (substr($no_register, 0, 2) == 'RI') {
			return $this->db->query("UPDATE pasien_iri set lab = '0' where no_ipd='$no_register' ");
		} else {
			return $this->db->query("DELETE FROM pasien_luar where no_register='$no_register' ");
		}
	}

	function delete_order_batal($no_register)
	{
		return $this->db->query("DELETE FROM pemeriksaan_laboratorium where no_register = '$no_register' and no_lab is null ");
	}

	function update_cito($id)
	{
		$cekcito = $this->db->query("SELECT cito FROM pemeriksaan_laboratorium where id_pemeriksaan_lab = '$id'")->row();
		if ($cekcito->cito == '1') {
			return $this->db->query("UPDATE pemeriksaan_laboratorium set cito = '0' where id_pemeriksaan_lab = '$id' ");
		} else {
			return $this->db->query("UPDATE pemeriksaan_laboratorium set cito = '1' where id_pemeriksaan_lab = '$id' ");
		}
	}

	function get_data_titip_iri($no_register)
	{
		return $this->db->query("SELECT titip, jatahklsiri FROM pasien_iri WHERE no_ipd = '$no_register'");
	}

	function get_detail_pemeriksaan_lab($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_laboratorium WHERE no_lab IS NULL AND no_register = '$noreg'");
	}

	function convertTipeKadarNormal2($tipe, $hasil, $sex)
	{
		// var_dump($sex);die();			// Tipe
		// $tipe = 'L:3-7 | P:2.4-5.7';
		// 35 - 50 // 30 // oke
		// 35 - 46 (Pria) / 32 - 46 (Wanita) // 12 // oke
		// L:3-7 | P:2.4-5.7 //12 atau float angka //oke
		// L: <41 | P: <31 // 12  //oke
		// <= 4 // 12 //oke
		// > 10 // 12 //oke
		// < 10 // 21 //oke

		// Negatif // Negatif / Positif //oke
		// Negatif (Skala<2) // Negatif / Positif
		// Negatif (0-3/LPB) // Negatif / Positif

		// end
		$checkType = strpos($tipe, '-');
		$checkType2 = strpos($tipe, '|');
		$checkType4 = strpos($tipe, '>');
		$checkType3 = strpos($tipe, '<');
		$checkType5 = strpos($tipe, 'Negatif');
		// $checkType5 = strpos($tipe, 'L: <');
		$checkType6 = strpos($tipe, '≤');
		$checkType7 = strpos($tipe, 'Positif/Negatif');
		$checkType8 = strpos($tipe, 'Non Reaktif');
		$checkType9 = strpos($tipe, 'Normal');
		$checkType10 = strpos($tipe, 'Positif');
		if ($checkType !== false) {
			$checkTypeLagi = strpos($tipe, '(Pria) /');
			if ($checkTypeLagi !== false) {
				// cek pasien apakah pria atau wanita
				$pembanding = explode('/', $tipe); // [35 - 46 (Pria) , 32 - 46 (Wanita)]
				if ($sex == 'Laki-laki') {
					$explodePertama = explode(' - ', $pembanding[0]); //[ 35, 46 (Pria)]
					$explodePertama[1] = preg_replace('/[^0-9]/', '', $explodePertama[1]);
					$value = $this->convertStringToInt($hasil);
					$result = ($value >= $this->convertStringToInt($explodePertama[0]) && $value <= $this->convertStringToInt($explodePertama[1])) ? false : true;
					return $result;
				} else {
					$explodeKedua = explode(' - ', $pembanding[1]); // [32 , 46 (Wanita)]
					$explodeKedua[1] = preg_replace('/[^0-9]/', '', $explodePertama[1]);
					$value = $this->convertStringToInt($hasil);
					$result = ($value >= $this->convertStringToInt($explodeKedua[0]) && $value <= $this->convertStringToInt($explodeKedua[1])) ? false : true;
					return $result;
				}
			}
			$value = $this->convertStringToFloat($hasil);
			$result = ($value >=  explode(' - ', $tipe)[0] && $value <=  explode('-', $tipe)[1]) ? false : true;
			return $result;
		}

		if ($checkType2 !== false) {
			$pembanding = explode(' | ', $tipe); // L:3-7 | P:2.4-5.7
			// var_dump($pembanding);die();
			if ($sex == 'Laki-laki') {
				// var_dump($pembanding[0]);die();
				$checkTipeLain = strpos($pembanding[0], 'L: <');
				if ($checkTipeLain !== false) {
					//L: < 41
					$x = $this->convertStringToInt(preg_replace('/[^0-9]/', '', $pembanding[0])); // 41
					$value = $this->convertStringToInt($hasil);
					$result = $value < $x ? false : true;
					return $result;
				}

				$explodePertama = explode('-', $pembanding[0]); //[ L:2 , 7
				$explodePertama[0] = preg_replace('/[^0-9]/', '', $explodePertama[0]);
				$value = $this->convertStringToInt($hasil);
				$result = ($value >= $this->convertStringToInt($explodePertama[0]) && $value <= $this->convertStringToInt($explodePertama[1])) ? false : true;
				// $result = ($value >= $explodePertama[0] && $value <= $explodePertama[1])?false:true;
				return $result;
			} else {
				$checkTipeLain = strpos($pembanding[1], 'P: <');
				if ($checkTipeLain !== false) {
					//L: < 41
					$x = $this->convertStringToInt(preg_replace('/[^0-9]/', '', $pembanding[1])); // 41
					$value = $this->convertStringToInt($hasil);
					$result = $value < $x ? false : true;
					return $result;
				}
				$explodeKedua = explode('-', $pembanding[1]); //  [P:2.4,5.7]
				$explodeKedua[0] = substr($explodeKedua[0], 2);
				$value = $this->convertStringToFloat($hasil);
				$result = ($value >= $this->convertStringToFloat($explodeKedua[0]) && $value <= $this->convertStringToFloat($explodeKedua[1])) ? false : true;
				return $result;
			}
		}

		if ($checkType6 !== false) {
			$kadar = preg_replace('/[^0-9]/', '', $tipe);
			$value = $value = $this->convertStringToInt($hasil);
			$result = ($value <= $this->convertStringToInt($kadar)) ? false : true;
		}

		if ($checkType3 !== false) {
			$kadar = preg_replace('/[^0-9]/', '', $tipe);
			$value = $value = $this->convertStringToInt($hasil);
			$result = ($value < $this->convertStringToInt($kadar)) ? false : true;
		}

		if ($checkType4 !== false) {
			$kadar = preg_replace('/[^0-9]/', '', $tipe);
			$value = $value = $this->convertStringToInt($hasil);
			$result = ($value > $this->convertStringToInt($kadar)) ? false : true;
		}

		if ($checkType5 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		if ($checkType7 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		if ($checkType8 !== false) {
			$kadar = stripos($hasil, $tipe);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		if ($checkType9 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		if ($checkType10 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}
		// var_dump($result);die();
		return $result;
	}

	// ini fungsi barunya:

	function convertTipeKadarNormal($tipe, $hasil, $sex)
	{
		$result = false; // default

		log_message('debug', "Memulai fungsi. Tipe: $tipe, Hasil: $hasil, Jenis Kelamin: $sex");
		// var_dump($hasil);die();			
		// Tipe
		// $tipe = 'L:3-7 | P:2.4-5.7';
		// 35 - 50 // 30 // oke
		// 35 - 46 (Pria) / 32 - 46 (Wanita) // 12 // oke

		// L:3-7 | P:2.4-5.7 //12 atau float angka //oke
		// L: <41 | P: <31 // 12  //oke
		// <= 4 // 12 //oke
		// > 10 // 12 //oke
		// < 10 // 21 //oke

		// Negatif // Negatif / Positif //oke
		// Negatif (Skala<2) // Negatif / Positif
		// Negatif (0-3/LPB) // Negatif / Positif

		// end
		$checkType = strpos($tipe, '-');
		$checkType2 = strpos($tipe, '|');
		$checkType4 = strpos($tipe, '>');
		$checkType3 = strpos($tipe, '<');
		$checkType5 = strpos($tipe, 'Negatif');
		// $checkType5 = strpos($tipe, 'L: <');
		$checkType6 = strpos($tipe, '≤');
		$checkType7 = strpos($tipe, 'Positif/Negatif');
		$checkType8 = strpos($tipe, 'Non Reaktif');
		$checkType9 = strpos($tipe, 'Normal');
		$checkType10 = strpos($tipe, 'Positif');

		log_message('debug', "Memeriksa checkType: $checkType");
		if ($checkType !== false && $checkType2 !== true) {
			$checkTypeLagi = strpos($tipe, '(Pria) /');
			if ($checkTypeLagi !== false) {
				// cek pasien apakah pria atau wanita
				$pembanding = explode('/', $tipe); // [35 - 46 (Pria) , 32 - 46 (Wanita)]
				if ($sex == 'Laki-laki') {
					$explodePertama = explode(' - ', $pembanding[0]); //[ 35, 46 (Pria)]
					$explodePertama[1] = preg_replace('/[^0-9]/', '', $explodePertama[1]);
					$value = $this->convertStringToInt($hasil);
					$result = ($value >= $this->convertStringToInt($explodePertama[0]) && $value <= $this->convertStringToInt($explodePertama[1])) ? false : true;
					return $result;
				} else {
					$explodeKedua = explode(' - ', $pembanding[1]); // [32 , 46 (Wanita)]
					$explodeKedua[1] = preg_replace('/[^0-9]/', '', $explodeKedua[1]);
					$value = $this->convertStringToInt($hasil);
					$result = ($value >= $this->convertStringToInt($explodeKedua[0]) && $value <= $this->convertStringToInt($explodeKedua[1])) ? false : true;
					return $result;
				}
			}
			if ($checkType2 !== false && $checkType !== false) { // Jika ada '|'
				if ($sex == 'Laki-laki') {
					$explodePertama = explode('L:', $tipe)[1];
					$batasBawah = $this->convertStringToFloat(explode('-', $explodePertama)[0]);
					$batasAtas = $this->convertStringToFloat(explode('-', $explodePertama)[1]);
				} else {
					$explodeKedua = explode('P:', $tipe)[1];
					$batasBawah = $this->convertStringToFloat(explode('-', $explodeKedua)[0]);
					$batasAtas = $this->convertStringToFloat(explode('-', $explodeKedua)[1]);
				}
			} else { // Jika tidak ada '|'
				$batasBawah = $this->convertStringToFloat(explode(' - ', $tipe)[0]);
				$batasAtas = $this->convertStringToFloat(explode('-', $tipe)[1]);
			}

			$value = $this->convertStringToFloat($hasil);
			$result = ($value >= $batasBawah && $value <= $batasAtas) ? false : true;
			log_message('debug', "Dalam checkType, Batas Bawah: $batasBawah, Batas Atas: $batasAtas, Value: $value, Result: $result");
			return $result;
		}

		log_message('debug', "Memeriksa checkType2: $checkType2");
		if ($checkType2 !== false) {
			$pembanding = explode(' | ', $tipe); // L:3-7 | P:2.4-5.7
			log_message('debug', "Pembanding untuk checkType2: " . print_r($pembanding, true));
			if ($sex == 'Laki-laki') {
				$checkTipeLain = strpos($pembanding[0], 'L: <');
				if ($checkTipeLain !== false) {
					//L: < 41
					$x = $this->convertStringToInt(preg_replace('/[^0-9]/', '', $pembanding[0])); // 41
					$value = $this->convertStringToInt($hasil);
					log_message('debug', "Laki-laki (Tipe L: <). X: $x, Value: $value");
					$result = $value < $x ? false : true;
					return $result;
				}

				$explodePertama = explode('-', $pembanding[0]);
				$batasBawah = $this->convertStringToFloat(preg_replace('/[^0-9\.]/', '', $explodePertama[0]));
				$batasAtas = $this->convertStringToFloat(preg_replace('/[^0-9\.]/', '', $explodePertama[1]));
				$value = $this->convertStringToFloat($hasil);

				$result = ($value >= $batasBawah && $value <= $batasAtas) ? false : true;
				log_message('debug', "Laki-laki - Batas Bawah: $batasBawah, Batas Atas: $batasAtas, Value: $value");

				return $result;
			} else {
				$checkTipeLain = strpos($pembanding[1], 'P: <');
				if ($checkTipeLain !== false) {
					//L: < 41
					$x = $this->convertStringToInt(preg_replace('/[^0-9]/', '', $pembanding[1])); // 41
					$value = $this->convertStringToInt($hasil);
					$result = $value < $x ? false : true;
					return $result;
				}
				$explodeKedua = explode('-', $pembanding[1]); //  [P:2.4,5.7]
				$explodeKedua[0] = $this->convertStringToFloat(substr($explodeKedua[0], 2));
				$explodeKedua[1] = $this->convertStringToFloat($explodeKedua[1]);
				$value = $this->convertStringToFloat($hasil);
				$result = ($value >= $explodeKedua[0] && $value <= $explodeKedua[1]) ? false : true;
				log_message('debug', "Dalam checkType2 Wanita, Batas Bawah: " . $explodeKedua[0] . ", Batas Atas: " . $explodeKedua[1] . ", Value: $value, Result: $result");
				return $result;
			}
		}
		// die($result);

		log_message('debug', "Memeriksa checkType6: $checkType6");
		if ($checkType6 !== false) {
			$kadar = $this->convertStringToFloat(preg_replace('/[^0-9\.]/', '', $tipe));
			$value = $this->convertStringToFloat($hasil);
			$result = $value <= $kadar ? false : true;
			return $result;
		}

		log_message('debug', "Memeriksa checkType3: $checkType3");
		if ($checkType3 !== false) {
			$kadar = $this->convertStringToFloat(preg_replace('/[^0-9\.]/', '', $tipe));
			$value = $this->convertStringToFloat($hasil);
			$result = $value < $kadar ? false : true;
			return $result;
		}

		log_message('debug', "Memeriksa checkType4: $checkType4");
		if ($checkType4 !== false) {
			$kadar = $this->convertStringToFloat(preg_replace('/[^0-9\.]/', '', $tipe));
			$value = $this->convertStringToFloat($hasil);
			$result = $value > $kadar ? false : true;
			return $result;
		}

		log_message('debug', "Memeriksa checkType5: $checkType5");
		if ($checkType5 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		log_message('debug', "Memeriksa checkType7: $checkType7");
		if ($checkType7 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		log_message('debug', "Memeriksa checkType8: $checkType8");
		if ($checkType8 !== false) {
			$kadar = stripos($hasil, $tipe);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		log_message('debug', "Memeriksa checkType9: $checkType9");
		if ($checkType9 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}

		log_message('debug', "Memeriksa checkType10: $checkType10");
		if ($checkType10 !== false) {
			$kadar = stripos($tipe, $hasil);
			if ($kadar !== false) {
				$result = false;
			} else {
				$result = true;
			}
		}
		// var_dump($kadar);die();
		log_message('debug', "Hasil akhir dari fungsi: $result");
		return $result;
	}

	function convertStringToInt($string)
	{
		return intval($string);
	}

	function convertStringToFloat($string)
	{
		return floatval($string);
	}

	function check_pemeriksaan_micro($no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab = '$no_lab' AND SUBSTRING(id_tindakan,1,2) = 'HM'");
	}

	function get_data_header_hasil_pemeriksaan_micro($no_lab)
	{
		return $this->db->query("
				SELECT DISTINCT a.id_tindakan, a.jenis_tindakan, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Lokasi' AND a.id_tindakan = id_tindakan LIMIT 1) AS lokasi, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Konsistensi' AND a.id_tindakan = id_tindakan LIMIT 1) AS konsitensi, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Selularitas' AND a.id_tindakan = id_tindakan LIMIT 1) AS selularitas, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Sistem Eritropoetik' AND a.id_tindakan = id_tindakan LIMIT 1) AS eritropoetik, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Sistem Granulopoetik' AND a.id_tindakan = id_tindakan LIMIT 1) AS granulopoetik, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Sistem Trombopoetik' AND a.id_tindakan = id_tindakan LIMIT 1) AS trombopoetik, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Sistem Limfopoetik' AND a.id_tindakan = id_tindakan LIMIT 1) AS limfopoetik, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Simpulan' AND a.id_tindakan = id_tindakan LIMIT 1) AS simpulan, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'Saran' AND a.id_tindakan = id_tindakan LIMIT 1) AS saran, 
				(SELECT hasil_lab FROM hasil_pemeriksaan_lab WHERE no_lab::varchar = cast(A.no_lab as text) AND jenis_hasil = 'M/E Ratio' AND a.id_tindakan = id_tindakan LIMIT 1) AS meratio FROM pemeriksaan_laboratorium a WHERE a.no_lab::varchar = '$no_lab' AND a.hasil_periksa = '1' AND SUBSTRING(a.id_tindakan,1,2) = 'HM'
				");
	}

	function get_data_hasil_pemeriksaan_micro($no_lab)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab = '$no_lab' AND SUBSTRING(id_tindakan,1,2) = 'HM' AND id_hasil_ IS NULL");
	}

	function check_nolab_today($date)
	{
		return $this->db->query("SELECT 
				no_lab
			FROM
				lab_header 
			WHERE
				SUBSTR( no_lab::varchar, 1, 6 ) = '$date'
				AND no_lab IS NOT NULL
			ORDER BY 
				no_lab DESC
			LIMIT 1");
	}

	function get_tindakan_hematologi_pasien($no_register)
	{
		return $this->db->query("SELECT id_tindakan, jenis_tindakan FROM pemeriksaan_laboratorium WHERE no_register = '$no_register' AND no_lab IS NULL AND SUBSTRING(id_tindakan,1,2) IN ('HA','HH')");
	}

	function get_tindakan_non_hematologi_pasien($no_register)
	{
		return $this->db->query("SELECT id_tindakan, jenis_tindakan FROM pemeriksaan_laboratorium WHERE no_register = '$no_register' AND no_lab IS NULL AND SUBSTRING(id_tindakan,1,2) NOT IN ('HA','HH','HM')");
	}

	function get_tindakan_mikro_pasien($no_register)
	{
		return $this->db->query("SELECT id_tindakan, jenis_tindakan FROM pemeriksaan_laboratorium WHERE no_register = '$no_register' AND no_lab IS NULL AND SUBSTRING(id_tindakan,1,2) = 'HM'");
	}

	function insert_data_header_hema($no_register, $idrg, $bed, $kelas, $nolab)
	{
		return $this->db->query("INSERT INTO lab_header (no_register, idrg, bed, kelas, no_lab, hema) VALUES ('$no_register','$idrg','$bed','$kelas','$nolab','1')");
	}

	function insert_data_header_mikro($no_register, $idrg, $bed, $kelas, $nolab)
	{
		return $this->db->query("INSERT INTO lab_header (no_register, idrg, bed, kelas, no_lab, mikro) VALUES ('$no_register','$idrg','$bed','$kelas','$nolab','1')");
	}

	function get_data_header_hema($no_register, $idrg, $bed, $kelas)
	{
		return $this->db->query("SELECT no_lab FROM lab_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' AND no_lab IS NOT NULL AND hema = '1' ORDER BY no_lab DESC LIMIT 1");
	}
	function get_data_header_mikro($no_register, $idrg, $bed, $kelas)
	{
		return $this->db->query("SELECT no_lab FROM lab_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' AND no_lab IS NOT NULL AND mikro = '1' ORDER BY no_lab DESC LIMIT 1");
	}

	function selesai_daftar_pemeriksaan_IRJ_hema($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null AND SUBSTRING(id_tindakan,1,2) = 'HA'");
		$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab='$status_lab', vtot_lab=$getvtotlab WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRJ_mikro($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null AND SUBSTRING(id_tindakan,1,2) = 'HM'");
		$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab='$status_lab', vtot_lab=$getvtotlab WHERE no_register='$no_register'");
		return true;
	}

	function selesai_daftar_pemeriksaan_IRJ_non_hema($no_register, $getvtotlab, $no_lab, $status_lab, $tglkunjung)
	{
		$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab',tgl_kunjungan = '$tglkunjung',tgl_mulai_pemeriksaan = 'now()' WHERE no_register='$no_register' and no_lab is null AND SUBSTRING(id_tindakan,1,2) != 'HA' AND SUBSTRING(id_tindakan,1,2) != 'HM'");
		$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab='$status_lab', vtot_lab=$getvtotlab WHERE no_register='$no_register'");
		return true;
	}

	function input_keterangan_pemeriksaan($data, $no_lab)
	{
		$this->db->where('no_lab', $no_lab);
		$this->db->update('pemeriksaan_laboratorium', $data);
		return true;
	}

	function get_keterangan_nolab($no_lab)
	{
		return $this->db->query("SELECT ket FROM pemeriksaan_laboratorium WHERE no_lab = '$no_lab' AND ket IS NOT NULL LIMIT 1");
	}

	function get_nama_organisme_kultur($id, $nolab)
	{
		return $this->db->query("SELECT nama_organisme_kultur from pemeriksaan_laboratorium where id_tindakan = '$id' and no_lab = $nolab")->row();
	}

	function get_id_poli($no_register) {
		return $this->db->query("SELECT id_poli FROM daftar_ulang_irj WHERE no_register = '$no_register'");
	}

	function get_id_ok($no_register) {
		return $this->db->query("select idoperasi_header from operasi_header where no_register = '$no_register'
		");
	}

	function get_id_dokter($id_dokter) {
		return $this->db->query("SELECT * FROM dyn_user_dokter where id_dokter='$id_dokter'
		");
	}
}