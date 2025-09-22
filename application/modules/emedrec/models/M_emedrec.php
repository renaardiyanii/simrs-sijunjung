<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_emedrec extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_data_pasien_by_no_cm($no_cm = "")
	{
		// var_dump($no_medrec );die();
		if ($no_cm != "") {

			return $this->db->query("SELECT a.*, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_cm = '$no_cm'");
		}
		return null;
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_medrec='$no_medrec'");
	}

	function get_data_pasien_by_no_cm_luar($no_medrec)
	{
		return $this->db->query("SELECT a.*, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM pasien_luar a where a.no_cm = '$no_medrec'");
	}

	function get_data_pasien_by_no_cm_real($nocm)
	{
		return $this->db->query("SELECT a.*, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_cm = '$nocm'");
	}

	function get_data_pasien_by_no_medrecs($no_medrec)
	{
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_medrec='$no_medrec'");
		// return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_medrec = '$no_medrec'");
		return $this->db->query(
			"
				SELECT *, 
				TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl,
				(SELECT count(*) from daftar_ulang_irj where no_medrec = a.no_medrec and TO_CHAR(tgl_kunjungan,'YYYY-MM-DD') = '" . date('Y-m-d') . "') as igd_irj,
				(select count(*) from 
				pasien_iri 
				LEFT JOIN ruang_iri AS b ON pasien_iri.no_ipd = b.no_ipd
				where no_medrec=a.no_medrec 
				and tgl_keluar is null 
				and pasien_iri.mutasi is null
				AND (b.tglkeluarrg IS NULL or TO_CHAR(b.tglkeluarrg, 'YYYY-MM-dd') = '')
				) as ranap
				FROM data_pasien a 
				where a.no_cm = '$no_medrec'
				"
		);
	}

	function get_data_pasien_by_nama($nama)
	{
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_medrec='$no_medrec'");
		// return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_medrec = '$no_medrec'");
		return $this->db->query(
			"
				SELECT *, 
				TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl,
				(SELECT count(*) from daftar_ulang_irj where no_medrec = a.no_medrec and TO_CHAR(tgl_kunjungan,'YYYY-MM-DD') = '" . date('Y-m-d') . "') as igd_irj,
				(select count(*) from 
				pasien_iri 
				LEFT JOIN ruang_iri AS b ON pasien_iri.no_ipd = b.no_ipd
				where no_medrec=a.no_medrec 
				and tgl_keluar is null 
				and pasien_iri.mutasi is null
				AND (b.tglkeluarrg IS NULL or TO_CHAR(b.tglkeluarrg, 'YYYY-MM-dd') = '')
				) as ranap
				FROM data_pasien a 
				where a.nama LIKE '%$nama%'
				"
		);
	}

	// function getdata_record_pasien($no_cm){
	// 	return $this->db->query("SELECT
	// 			a.no_register as noregister,
	// 			TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
	// 			a.id_dokter,
	// 			b.nm_dokter AS dokter,
	// 			c.nm_poli AS poli,
	// 			d.diagnosa AS diagnosa
	// 		FROM
	// 			daftar_ulang_irj
	// 			AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
	// 			LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
	// 			LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register
	// 		WHERE
	// 			a.no_medrec = '$no_cm'
	// 			AND d.klasifikasi_diagnos = 'utama'
	// 			AND a.id_poli != 'BA00'");
	// }



	// function getdata_record_pasien($no_cm){
	// 	return $this->db->query("SELECT
	// 	a.no_register as noregister,
	// 	TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
	// 	a.id_dokter,
	// 	b.nm_dokter AS dokter,
	// 	c.nm_poli AS poli,
	// 	d.diagnosa AS diagnosa ,
	// 	cetak_prmrj
	// FROM
	// 	daftar_ulang_irj
	// 	AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
	// 	LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
	// 	LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register
	// WHERE
	// 	a.no_cm = '$no_cm'
	// 	AND a.id_poli != 'BA00'");
	// }

	function getdata_record_pasien($no_medrec)
	{
		return $this->db->query(
			"SELECT
				a.no_register as noregister,
				e.no_cm,
				e.no_medrec,
				a.ket_pulang,
				TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				a.id_dokter,
				b.nm_dokter AS dokter,
				c.nm_poli AS poli,
				c.id_poli AS id_poli,
				cetak_prmrj
			FROM
				daftar_ulang_irj
				AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
				LEFT JOIN data_pasien as e ON a.no_medrec = e.no_medrec
			WHERE
				e.no_medrec = '$no_medrec'
				AND a.id_poli != 'BA00' order by no_register desc"
		);
	}

	function getdata_record_pasien_by_no_reg($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("SELECT a.*,
				a.no_register as noregister,
				TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				a.id_dokter,
				b.nm_dokter AS dokter,
				e.ttd,
				c.nm_poli AS poli
			FROM
				daftar_ulang_irj
				AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
                LEFT JOIN dyn_user_dokter as d on d.id_dokter = a.id_dokter
                left join hmis_users as e on e.userid=d.userid
			WHERE
				a.no_register = '$no_reg'");
		}
		return null;
	}

	function getdata_kontrol($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("select catatan,tindak_lanjut from daftar_ulang_irj where no_register ='$no_reg'");
		}
		return null;
	}

	function getdata_record_data_fungsional($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("SELECT * from penilaian_fungsional_status
			WHERE
				no_register = '$no_reg'");
		}
		return null;
	}





	function get_v_data_kontrol($no_register = '')
	{
		if ($no_register != '') {
			return $this->db->query("SELECT * FROM v_surat_kontrol
				WHERE no_register = '$no_register'")->result();
		} else {
			return $this->db->query("SELECT * FROM v_surat_kontrol")->result();
		}
	}

	function getdata_ird_pasien($no_medrec)
	{
		return $this->db->query("SELECT
					a.no_register as noregister,
					TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
					a.id_dokter,
					b.nm_dokter AS dokter,
					c.nm_poli AS poli
				FROM
					daftar_ulang_irj
					AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
					LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
				WHERE
					a.no_medrec = '$no_medrec'
					AND a.id_poli = 'BA00' order by noregister desc
					");
	}

	function getdata_iri_pasien($no_medrec)
	{
		return $this->db->query("SELECT
										a.no_ipd, a.tgl_keluar, a.noregasal, a.tgl_masuk, a.dokter,a.idrg,b.nmruang
									FROM
										pasien_iri as a
										LEFT JOIN ruang b ON a.idrg = b.idrg
									WHERE
										no_medrec = '$no_medrec' order by no_ipd desc");
	}

	function getdata_detail_lab($no_reg)
	{
		return $this->db->query("SELECT
					b.nmtindakan as nm_tindakan, a.hasil_lab as hasil
				FROM
					hasil_pemeriksaan_lab as a
				LEFT JOIN jenis_tindakan as b ON a.id_tindakan = b.idtindakan
				WHERE
					a.no_register = '$no_reg'");
	}

	function getdata_detail_obat($no_reg)
	{
		return $this->db->query("SELECT
										tgl_kunjungan, nama_obat, item_obat , signa
									FROM
										resep_pasien as a
									WHERE
										a.no_register = '$no_reg'");
	}

	function getdata_detail_radiologi($no_reg)
	{
		return $this->db->query("SELECT
										a.*, b.nm_dokter
									FROM
										hasil_pemeriksaan_rad as a
										LEFT JOIN pemeriksaan_radiologi as b ON a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
									WHERE
										b.no_register = '$no_reg'");
	}

	function getdata_hasil_pemeriksaan_radiologi($no_reg)
	{
		return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE a.no_register = '$no_reg'");
	}

	// function get_data_ringkas_medik_rj($no_cm){
	// 	return $this->db->query("SELECT a.*,b.diagnosa,b.id_diagnosa,b.tindakan
	// 	FROM v_ringkas_medik_rj a
	// 	LEFT JOIN diagnosa_pasien b
	// 	ON b.no_register = a.noregister
	// 	WHERE no_medrec = '$no_cm'");
	// }
	// function get_data_ringkas_medik_rj($no_medrec){
	// 	return $this->db->query("SELECT a.tgl_kunjungan,a.no_register,b.riwayat_kesehatan,status_lab as lab,
	// 	status_obat as obat,status_rad as rad,status_ok as ok,riwayat_alergi,tindak_lanjut,d.nm_dokter,a.cetak_prmrj,plan,
	// 	d.ttd
	// 	FROM daftar_ulang_irj a
	// 	LEFT JOIN pemeriksaan_fisik b
	// 	ON a.no_register = b.no_register
	// 	LEFT JOIN data_dokter d on a.id_dokter = d.id_dokter
	// 	where a.no_medrec = '$no_medrec' and a.cetak_prmrj = '1'");
	// }

	// hide prmrj =1 @aldi
	function get_data_ringkas_medik_rj($no_medrec)
	{
		return $this->db->query("
			SELECT a.tgl_kunjungan,a.no_register,
			b.riwayat_kesehatan,status_lab as lab,status_obat as obat,status_rad as rad,
			status_ok as ok,riwayat_alergi,
			tindak_lanjut,d.nm_dokter,f.ttd,a.cetak_prmrj,soap_pasien_rj.plan_dokter as plan FROM daftar_ulang_irj a
						FULL OUTER JOIN pemeriksaan_fisik b
						ON a.no_register =b.no_register
						FULL OUTER JOIN soap_pasien_rj
						on soap_pasien_rj.no_register = a.no_register
						FULL OUTER JOIN data_dokter d
						on a.id_dokter = d.id_dokter
						FULL OUTER JOIN dyn_user_dokter e on e.id_dokter = a.id_dokter
						FULL OUTER JOIN hmis_users f on f.userid = e.userid
						where a.no_medrec = $no_medrec
			");
	}

	function get_data_ringkas_medik_rj_by_noreg($no_register)
	{
		// SELECT a.tgl_kunjungan,a.no_register,
		// b.riwayat_kesehatan,status_lab as lab,status_obat as obat,status_rad as rad,
		// status_ok as ok,riwayat_alergi,c.diagnosa,c.klasifikasi_diagnos,
		// tindak_lanjut,d.nm_dokter,a.cetak_prmrj,plan FROM daftar_ulang_irj a
		// 			LEFT JOIN pemeriksaan_fisik b
		// 			ON a.no_register =b.no_register
		// 			LEFT JOIN diagnosa_pasien c
		// 			on a.no_register =c.no_register
		// 			LEFT JOIN data_dokter d
		// 			on a.id_dokter = d.id_dokter
		// 			where a.no_register = '$no_register' and a.cetak_prmrj = '1'
		return $this->db->query("SELECT a.tgl_kunjungan,a.no_register,
			b.riwayat_kesehatan,status_lab as lab,status_obat as obat,status_rad as rad,
			status_ok as ok,riwayat_alergi,
			tindak_lanjut,d.nm_dokter,f.ttd,a.cetak_prmrj,soap_pasien_rj.plan_dokter as plan FROM daftar_ulang_irj a
						FULL OUTER JOIN pemeriksaan_fisik b
						ON a.no_register =b.no_register
						FULL OUTER JOIN soap_pasien_rj
						on soap_pasien_rj.no_register = a.no_register
						FULL OUTER JOIN data_dokter d
						on a.id_dokter = d.id_dokter
						FULL OUTER JOIN dyn_user_dokter e on e.id_dokter = a.id_dokter
						FULL OUTER JOIN hmis_users f on f.userid = e.userid
						where a.no_register = '$no_register'");
	}

	function cek_prrmj($no_register)
	{
		return $this->db->query("SELECT cetak_prmrj from daftar_ulang_irj where no_register = 'no_register'");
	}

	function get_pemeriksaan_fisik_poli($date, $id_poli) {
		return $this->db->query("SELECT a.*,
			b.id_dokter,
			b.tgl_kontrol,
			b.no_medrec,
			c.nm_dokter AS dokter,
			b.no_register AS noreg
		FROM 
			pemeriksaan_fisik AS a
			LEFT JOIN daftar_ulang_irj AS b ON b.no_register = a.no_register
			LEFT JOIN data_dokter AS c ON c.id_dokter = b.id_dokter
		WHERE 
			B.id_poli = '$id_poli'
			AND to_char(b.tgl_kunjungan,'YYYY-MM-DD') = '$date'");
	}

	function get_pemeriksaan_fisik($no_register = '')
	{
		if ($no_register != '') {
			return $this->db->query("SELECT a.*,
				b.id_dokter,
				b.tgl_kontrol,
				c.nm_dokter AS dokter
				FROM pemeriksaan_fisik AS a
				LEFT JOIN daftar_ulang_irj AS b
				ON b.no_register = a.no_register
				LEFT JOIN data_dokter AS  c
				ON c.id_dokter = b.id_dokter
				WHERE a.no_register='$no_register'")->result();
		}
		return $this->db->query("SELECT * FROM pemeriksaan_fisik")->result();
	}

	function get_object_dokter($noreg)
	{
		return $this->db->query("SELECT subjective_dokter,objective_dokter, objective_perawat,subjective_perawat FROM soap_pasien_rj WHERE no_register = '$noreg' LIMIT 1")->row();
	}

	function get_data_cppt($no_cm)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,a.waktu_masuk_poli,a.waktu_masuk_dokter,e.*,b.name,c.nm_dokter as nama_dokter,hm.ttd as tandatangan_dokter,d.ttd as ttd_perawat,d.name as nm_perawat
			FROM daftar_ulang_irj as a
			FULL OUTER join soap_pasien_rj on soap_pasien_rj.no_register = a.no_register
			FULL OUTER join pemeriksaan_fisik as e on e.no_register = a.no_register
			FULL OUTER join hmis_users as d on d.userid = CAST(e.id_perawat AS INTEGER)
			FULL OUTER join data_dokter as c on a.id_dokter = c.id_dokter
			FULL OUTER join dyn_user_dokter as dyn on dyn.id_dokter = a.id_dokter
			FULL OUTER JOIN hmis_users as b on CAST(e.id_perawat as integer) = b.userid
			FULL OUTER join hmis_users as hm on hm.userid = dyn.userid
			WHERE a.no_medrec='$no_cm'
			ORDER BY a.tgl_kunjungan DESC LIMIT 10")->result();
	}

	function get_data_cppt_by_poli($no_medrec, $id_poli)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,a.no_register AS noreg,a.waktu_masuk_poli,a.waktu_masuk_dokter,e.*,b.name,c.nm_dokter as nama_dokter,hm.ttd as tandatangan_dokter,d.ttd as ttd_perawat,d.name as nm_perawat
			FROM daftar_ulang_irj as a
			FULL OUTER join soap_pasien_rj on soap_pasien_rj.no_register = a.no_register
			FULL OUTER join pemeriksaan_fisik as e on e.no_register = a.no_register
			FULL OUTER join hmis_users as d on d.userid = CAST(e.id_perawat AS INTEGER)
			FULL OUTER join data_dokter as c on a.id_dokter = c.id_dokter
			FULL OUTER join dyn_user_dokter as dyn on dyn.id_dokter = a.id_dokter
			FULL OUTER JOIN hmis_users as b on CAST(e.id_perawat as integer) = b.userid
			FULL OUTER join hmis_users as hm on hm.userid = dyn.userid
			WHERE a.no_medrec='$no_medrec' AND a.id_poli = '$id_poli'
			ORDER BY a.tgl_kunjungan DESC")->result();
	}

	function get_data_cppt_by_poli_all($no_medrec)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,a.no_register AS noreg,a.waktu_masuk_poli,a.waktu_masuk_dokter,e.*,b.name,c.nm_dokter as nama_dokter,hm.ttd as tandatangan_dokter,d.ttd as ttd_perawat,d.name as nm_perawat, poli.nm_poli,a.id_poli
			FROM daftar_ulang_irj as a
			FULL OUTER join soap_pasien_rj on soap_pasien_rj.no_register = a.no_register
			FULL OUTER join pemeriksaan_fisik as e on e.no_register = a.no_register
			FULL OUTER join hmis_users as d on d.userid = CAST(e.id_perawat AS INTEGER)
			FULL OUTER join data_dokter as c on a.id_dokter = c.id_dokter
			FULL OUTER join dyn_user_dokter as dyn on dyn.id_dokter = a.id_dokter
			FULL OUTER JOIN hmis_users as b on CAST(e.id_perawat as integer) = b.userid
			FULL OUTER join hmis_users as hm on hm.userid = dyn.userid
			INNER JOIN poliklinik as poli on poli.id_poli = a.id_poli
			WHERE a.no_medrec='$no_medrec'
			ORDER BY a.tgl_kunjungan DESC")->result();
	}

	function get_data_cppt_by_all($no_medrec)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,a.no_register AS noreg,a.waktu_masuk_poli,a.waktu_masuk_dokter,e.*,b.name,c.nm_dokter as nama_dokter,hm.ttd as tandatangan_dokter,d.ttd as ttd_perawat,d.name as nm_perawat
			FROM daftar_ulang_irj as a
			FULL OUTER join soap_pasien_rj on soap_pasien_rj.no_register = a.no_register
			FULL OUTER join pemeriksaan_fisik as e on e.no_register = a.no_register
			FULL OUTER join hmis_users as d on d.userid = CAST(e.id_perawat AS INTEGER)
			FULL OUTER join data_dokter as c on a.id_dokter = c.id_dokter
			FULL OUTER join dyn_user_dokter as dyn on dyn.id_dokter = a.id_dokter
			FULL OUTER JOIN hmis_users as b on CAST(e.id_perawat as integer) = b.userid
			FULL OUTER join hmis_users as hm on hm.userid = dyn.userid
			WHERE a.no_medrec='$no_medrec'
			ORDER BY a.tgl_kunjungan DESC")->result();
	}

	function get_data_cppt_pm($no_cm = '')
	{
		$this->db->where('rekam_medik_number', $no_cm);
		return $this->db->get('tb_rekam_medis_cppt');
	}

	function get_data_cppt_by_noreg($no_register)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,e.waktu_masuk_poli,e.waktu_masuk_dokter,a.*,b.name,c.nm_dokter as nama_dokter,hm.ttd as tandatangan_dokter,d.ttd as ttd_perawat,d.name as nm_perawat,e.id_poli
			FROM pemeriksaan_fisik as a left join hmis_users
			as b on CAST(a.id_perawat as integer) = b.userid
			left join soap_pasien_rj on soap_pasien_rj.no_register = a.no_register
			left join hmis_users as d on d.userid = CAST(a.id_perawat AS INTEGER)
			left join daftar_ulang_irj as e on e.no_register = a.no_register
			left join data_dokter as c on e.id_dokter = c.id_dokter
			left join dyn_user_dokter as dyn on dyn.id_dokter = e.id_dokter
			left join hmis_users as hm on hm.userid = dyn.userid
			WHERE a.no_register='$no_register'");
	}
	//added for putri 
	function get_soap_medik($noregister)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$noregister'");
	}
	// added for fisio @@aldi

	function get_data_cppt_by_noreg_fisio($no_register)
	{
		return $this->db->query("SELECT soap_pasien_rj.*,e.waktu_masuk_poli,hmis_users.ttd as ttd_perawat,hmis_users.name
			as nm_perawat FROM soap_pasien_rj LEFT JOIN hmis_users on soap_pasien_rj.id_pemeriksa = CAST(hmis_users.userid as varchar) LEFT JOIN daftar_ulang_irj as e
			on e.no_register = soap_pasien_rj.no_register WHERE soap_pasien_rj.no_register='$no_register'");
	}
	// end added

	function get_noreg_by_medrec_poli($no_medrec, $id_poli)
	{
		return $this->db->query("SELECT DISTINCT no_register FROM daftar_ulang_irj WHERE no_medrec = '$no_medrec' AND id_poli = '$id_poli'");
	}

	public function getdata_identitas($no_cm = '')
	{
		return $this->db->query("select dp.*, TO_CHAR( dp.tgl_lahir , 'DD-MM-YYYY' ) AS tgl,
			de.name as nama_pemeriksa,de.ttd as ttd
							from data_pasien AS dp
							INNER JOIN hmis_users as de
				ON de.userid = cast(dp.userid as int)
							where dp.no_medrec='$no_cm'");
	}
	function getdata_identitas_two($no_cm)
	{
		return $this->db->query("select dp.*, TO_CHAR( dp.tgl_lahir , 'DD-MM-YYYY' ) AS tgl
							from data_pasien AS dp
							where dp.no_medrec='$no_cm'");
	}

	function get_asssesment_keperawatan_irj($noreg = "")
	{
		if ($noreg != "") {
			$this->db->where('no_register', $noreg);
			return $this->db->get('assesment_keperawatan_irj');
		}
		return null;
	}

	public function get_data_asesmen_keperawatan($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("SELECT
				a.*,
				TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
				b.*
			FROM
				daftar_ulang_irj
				AS a JOIN pemeriksaan_fisik AS b ON a.no_register = b.no_register
			WHERE
				a.no_register = '$no_reg'");
		}
		return null;
	}

	public function get_checklist_assesment_keperawatan($no_reg)
	{
		return $this->db->query("SELECT
			a.no_register,
			TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
			b.*
		FROM
			daftar_ulang_irj
			AS a JOIN assesment_keperawatan_irj AS b ON a.no_register = b.no_register
		WHERE
			a.no_register = '$no_reg'");
	}

	public function get_checklist_asesmen_masalah_keperawatan($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("SELECT
					*
				FROM
					assesment_keperawatan_irj
				WHERE
					no_register = '$no_reg'");
		}
		return null;
	}


	public function get_data_asesmen_keperawatan_value($no_reg)
	{
		return $this->db->query("SELECT
			a.no_register,
			TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
			b.*
		FROM
			daftar_ulang_irj
			AS a JOIN pemeriksaan_fisik AS b ON a.no_register = b.no_register
		WHERE
			a.no_register = '$no_reg'");
	}

	public function get_data_asesmen_masalah_keperawatan($no_reg = "")
	{
		if ($no_reg != "") {
			return $this->db->query("SELECT
					*
				FROM
					asesment_masalah_keperawatan
				WHERE
					no_register = '$no_reg'");
		}
		return null;
	}

	public function get_data_laboratorium_by_noreg($no_reg)
	{
		return $this->db->query("SELECT b.id_tindakan,b.no_lab,b.no_register,b.jenis_hasil,b.kadar_normal,b.satuan,b.hasil_lab, c.nmtindakan, to_char(d.tgl_kunjungan,'YYYY-MM-DD') as tgl_kunjungan,d.idrg,d.xinput
			FROM
			hasil_pemeriksaan_lab as b
			LEFT JOIN jenis_tindakan_lab as c
			ON b.id_tindakan = c.idtindakan
			LEFT JOIN pemeriksaan_laboratorium as d
			ON b.no_lab = d.no_lab
			WHERE  b.no_register = '$no_reg'
			group by b.id_tindakan,b.no_lab,b.no_register,b.jenis_hasil,b.kadar_normal,b.satuan,b.hasil_lab, c.nmtindakan, to_char(d.tgl_kunjungan,'YYYY-MM-DD'),d.idrg,d.xinput
			");
	}

	public function get_diagnosa_pasien_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM diagnosa_pasien WHERE no_register='$no_reg'")->result_array();
	}

	public function get_icd9cmirj_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM icd9cm_irj WHERE no_register='$no_reg'")->result();
	}

	public function get_pemeriksaan_elektromedik_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik WHERE no_register='$no_reg'")->result();
	}

	public function get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik($no_reg)
	{
		return $this->db->query("select a.*, b.*,hmis_users.ttd as ttd_dokter,hmis_users.name as nm_dokter from pemeriksaan_elektromedik a
			inner join hasil_pemeriksaan_em b
			on a.id_pemeriksaan_em = b.id_pemeriksaan_em
			left join dyn_user_dokter on CAST(dyn_user_dokter.id_dokter as varchar) =  b.id_dokter
			left join hmis_users on hmis_users.userid = dyn_user_dokter.userid
			where no_register='$no_reg'")->result();
	}

	public function get_telaah_obat_by_no_reg($no_reg)
	{
		return $this->db->query("SELECT * FROM telaah_obat WHERE no_register='$no_reg'");
	}

	public function get_resep_pasien_by_noreg($no_reg)
	{
		return $this->db->query("SELECT a.*,b.id_dokter,c.nm_dokter,e.ttd FROM resep_pasien a
			left join daftar_ulang_irj b
			on a.no_register = b.no_register
			left join data_dokter c
			on b.id_dokter = c.id_dokter
            left join dyn_user_dokter as d
            on d.id_dokter = b.id_dokter
            left join hmis_users as e
            on e.userid = d.userid
			where a.no_register='$no_reg'");
	}

	// public function get_resep_pasien_by_noreg_telaah($no_reg)
	// {
	// 	if (substr($no_reg,0,2) == 'RJ') {
	// 		return $this->db->query("SELECT a.id_resep_pasien,a.tgl_kunjungan,a.racikan,a.nama_obat,a.qty,a.signa,b.id_dokter,c.nm_dokter,
	// 			(select ttd from hmis_users ,dyn_user_dokter where dyn_user_dokter.id_dokter = b.id_dokter and dyn_user_dokter.userid = hmis_users.userid) as ttd
	// 			FROM resep_pasien a,daftar_ulang_irj b,	data_dokter c
	// 			where a.no_register = b.no_register
	// 			and b.id_dokter = c.id_dokter
	// 			and a.no_register='$no_reg'");
	// 	}else{
	// 		return $this->db->query("SELECT a.id_resep_pasien,a.tgl_kunjungan,a.racikan,a.nama_obat,a.qty,a.signa,b.id_dokter,c.nm_dokter,
	// 			(select ttd from hmis_users ,dyn_user_dokter where dyn_user_dokter.id_dokter = b.id_dokter and dyn_user_dokter.userid = hmis_users.userid) as ttd
	// 			FROM resep_pasien a,pasien_iri b, data_dokter c
	// 			where a.no_register = b.no_ipd
	// 			and b.id_dokter = c.id_dokter
	// 			and a.no_register='$no_reg'");
	// 	}

	// }
	public function get_resep_pasien_by_noreg_telaah($no_reg)
	{
		if (substr($no_reg, 0, 2) == 'RJ') {
			return $this->db->query("SELECT A
				.id_resep_dokter,
				A.id_resep_pasien,
				A.tgl_kunjungan,
				A.racikan,
				A.nama_obat AS nama_obat,
				A.qty,
				A.ket_pakai_p,
				A.ket_pakai_s,
				A.ket_pakai_m,
				A.signa,
				A.qtx,
				A.kali_harian,
				A.cara_pakai,
				b.id_dokter,
				C.nm_dokter,
				b.no_sep,
				b.cara_bayar,
				a.vtot,
				a.no_antri,
				a.konsul,
				b.waktu_resep_farmasi,
				b.waktu_selesai_farmasi,
				( SELECT ttd FROM hmis_users, dyn_user_dokter WHERE dyn_user_dokter.id_dokter = b.id_dokter AND dyn_user_dokter.userid = hmis_users.userid ) AS ttd,
				( SELECT nmkontraktor FROM kontraktor WHERE b.id_kontraktor = kontraktor.id_kontraktor LIMIT 1 ) 
			FROM
				resep_pasien A,
				daftar_ulang_irj b,
				data_dokter C 
			WHERE
				A.no_register = b.no_register 
				AND b.id_dokter = C.id_dokter 
				AND A.no_register = '$no_reg'");
		} elseif (substr($no_reg, 0, 2) == 'PL') {
			return $this->db->query("SELECT a.id_resep_pasien,a.tgl_kunjungan,a.racikan,a.nama_obat,a.qty,a.signa
				FROM resep_pasien a where a.no_register='$no_reg'");
		} else {
			return $this->db->query("SELECT a.id_resep_dokter,a.tgl_kunjungan,a.racikan,a.nama_obat,a.qty,a.signa,b.id_dokter,c.nm_dokter,
					(select ttd from hmis_users ,dyn_user_dokter where dyn_user_dokter.id_dokter = b.id_dokter and dyn_user_dokter.userid = hmis_users.userid) as ttd
					FROM resep_pasien a,pasien_iri b, data_dokter c
					where a.no_register = b.no_ipd
					and b.id_dokter = c.id_dokter
					and a.no_register='$no_reg'");
		}
	}

	public function get_alergi_pemeriksaan_fisik_by_noreg($no_reg)
	{
		return $this->db->query("SELECT reaksi_alergi FROM pemeriksaan_fisik where no_register='$no_reg'");
	}

	function get_kode_document($kode_akses = "")
	{
		if ($kode_akses != "") {
			return $this->db->query("SELECT * FROM kode_document WHERE kode_akses='$kode_akses'");
		} else {
			return null;
		}
	}

	public function get_data_asesmen_keperawatan_ird($no_reg)
	{
		return $this->db->query(
			"SELECT
				a.no_register,
				TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
				b.*
			FROM
				daftar_ulang_irj
				AS a JOIN assesment_keperawatan_ird AS b ON a.no_register = b.no_register
			WHERE
				a.no_register = '$no_reg'"
		);
	}

	function get_data_assesment_medik_ird($no_reg)
	{
		return $this->db->query(
			"SELECT a.no_register,a.formjson FROM assesment_medik_igd as a
				-- LEFT JOIN dyn_user_dokter
				 WHERE a.no_register='$no_reg'"
		);
	}
	function get_data_triase_ird($no_reg)
	{
		return $this->db->query(
			"SELECT * FROM triase_igd WHERE no_register='$no_reg'"
		);
	}

	public function get_data_triase_ird_by_noreg($no_reg)
	{
		return $this->db->query(
			"SELECT
				a.no_register,
				TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
				b.* ,e.name,e.ttd
			FROM
				daftar_ulang_irj
				AS a JOIN triase_igd AS b ON a.no_register = b.no_register
				LEFT JOIN hmis_users as c on c.userid = b.id_pemeriksa
				LEFT JOIN dyn_user_dokter as d on d.id_dokter = a.id_dokter
				LEFT JOIN hmis_users as e on e.userid = d.userid
			WHERE
				a.no_register = '$no_reg'"
		);
	}

	function get_data_daftar_ulang_by_no_reg($no_register)
	{
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT *,(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor = kontraktor.id_kontraktor ),(select nm_poli from poliklinik where daftar_ulang_irj.id_poli = poliklinik.id_poli LIMIT 1) as namapoli FROM daftar_ulang_irj where no_register = '$no_register'");
	}

	function get_data_pasien_by_no_medrec($no_medrec)
	{
		return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_medrec = '$no_medrec'");
	}

	function get_data_konsul_by_noreg($no_register)
	{
		return $this->db->query("SELECT * FROM konsul_dokter where no_register = '$no_register'");
	}

	function get_data_dokter_by_konsul($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter where id_dokter = '$id_dokter'");
	}

	function get_data_poli_by_konsul($id_poli)
	{
		return $this->db->query("SELECT * FROM poliklinik where id_poli = '$id_poli'");
	}

	function get_data_jawab_konsul_by_noreg($no_register)
	{
		return $this->db->query("SELECT * FROM jawaban_konsul where no_register_lama = '$no_register'");
	}

	function get_data_hasil_em_pertindakan($id_pemeriksaan_em)
	{
		return $this->db->query("SELECT a.*,b.*,e.kode_jenis FROM pemeriksaan_elektromedik AS a LEFT JOIN hasil_pemeriksaan_em AS b ON a.id_pemeriksaan_em=b.id_pemeriksaan_em LEFT JOIN jenis_tindakan_em as d on a.id_tindakan = d.idtindakan LEFT JOIN jenis_em as e on d.idkel_tind = e.kode_jenis WHERE a.id_pemeriksaan_em='$id_pemeriksaan_em'");
	}

	function get_data_pasien_luar_cetak($no_em)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_em='$no_em' GROUP BY no_em");
	}

	function get_data_pasien_cetak($no_em)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_em='$no_em'");
	}

	function get_umur($no_medrec)
	{
		// return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
		return $this->db->query("SELECT DATE_PART('year', now()) - DATE_PART('year',tgl_lahir) AS umurday FROM data_pasien where no_medrec='$no_medrec'");
	}


	function get_nama_diagnosa($id_icd)
	{
		return $this->db->query("SELECT * FROM icd1 WHERE id_icd='" . $id_icd . "'");
	}

	function get_nama_dokter($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='" . $id_dokter . "'");
	}

	function get_nama_poli($id_poli)
	{
		return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='" . $id_poli . "'");
	}

	function get_nama_kontraktor($id_kontraktor)
	{
		return $this->db->query("SELECT * FROM kontraktor WHERE id_kontraktor='" . $id_kontraktor . "'");
	}

	function get_soap_pasien_rj_no_reg($noreg)
	{
		return $this->db->query("SELECT a.*,b.ttd,b.nm_dokter FROM soap_pasien_rj as a left join data_dokter as b on b.id_dokter=a.id_dokter WHERE no_register='$noreg'");
	}

	function get_diagnosa_kerja($noreg)
	{
		return $this->db->query("SELECT * FROM diagnosa_pasien WHERE no_register = '$noreg'");
	}

	function get_penunjang_igd($no_reg)
	{
		return $this->db->query("SELECT
				jenis_tindakan, 'LAB' AS ket
			FROM
				pemeriksaan_laboratorium 
			WHERE
				no_register = '$no_reg' UNION
			SELECT
				jenis_tindakan, 'EM' AS ket
			FROM
				pemeriksaan_elektromedik 
			WHERE
				no_register = '$no_reg' UNION
			SELECT
				jenis_tindakan, 'RAD' AS ket
			FROM
				pemeriksaan_radiologi 
			WHERE
				no_register = '$no_reg'");
	}

	function get_pemeriksaan_fisik_by_noreg($noreg)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='$noreg'");
	}

	function get_ttd_perawat_by_soap($no_reg)
	{
		return $this->db->query("SELECT b.ttd,b.name FROM pemeriksaan_fisik as a
			LEFT JOIN hmis_users as b on b.userid = CAST(a.id_perawat AS INTEGER)
			WHERE no_register='$no_reg'");
	}

	function get_ttd_perawat($userid)
	{
		$this->db->where('userid', $userid);
		return $this->db->get('hmis_users');
	}

	function get_tindakan_resep_pasien_ird($no_reg)
	{
		return $this->db->query("SELECT a.* , b.name,b.ttd from tindakan_resep_pasien_ird as a LEFT JOIN hmis_users as b on a.id_pemeriksa = b.userid
			WHERE a.no_register='$no_reg'");
	}

	function get_data_ttd($userid)
	{
		$this->db->where('userid', $userid);
		return $this->db->get('hmis_users');
	}

	function get_data_rad($noreg)
	{
		return $this->db->query("select * from pemeriksaan_radiologi where no_register ='$noreg'");
	}

	function get_formulir_transfer_ruangan($noreg)
	{
		// $this->db->where('no_register',$noreg);
		// return $this->db->get('transfer_ruangan');
		return $this->db->query("SELECT
			tr.*,
			gci.formjson::JSON->'question23'->>'nama' AS nm_keluarga_memberi_persetujuan,
			gci.formjson::JSON->'question23'->>'hub' AS hub_keluarga_memberi_persetujuan,
			gci.formjson::JSON->>'ttd_pasien' AS ttd_keluarga_pasien 
		FROM
			transfer_ruangan tr
			LEFT JOIN general_consent_iri gci ON tr.no_register = gci.no_register 
		WHERE
			tr.no_register = '$noreg'");
	}

	function get_formulir_transfer_ruangan2($noreg)
	{
		return $this->db->query("SELECT * from transfer_ruangan where no_register = '$noreg' order by id asc");
	}

	/**
	 * Added Aldi
	 * 13/10/2022
	 * Perbaikan Bugs Transfer ruangan
	 */

	function get_formulir_transfer_ruangan_ranap_rajal($noipd, $noreg)
	{
		// return $this->db->query("SELECT * from transfer_ruangan where no_register = '$noipd' or no_register='$noreg' order by id desc");
		return $this->db->query("SELECT 
			tr.*,
			gci.formjson::JSON->'question23'->>'nama' AS nm_keluarga_memberi_persetujuan,
			gci.formjson::JSON->'question23'->>'hub' AS hub_keluarga_memberi_persetujuan,
			gci.formjson::JSON->>'ttd_pasien' AS ttd_keluarga_pasien 
			from transfer_ruangan tr
			LEFT JOIN general_consent_iri gci ON tr.no_register = gci.no_register 
			where tr.no_register = '$noipd' or tr.no_register='$noreg' order by id desc");
	}

	function get_serah_terima($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('serah_terima');
	}

	function data_nipeg_by_nama($nama)
	{
		if ($nama != "") {
			return $this->db->query("select nipeg from data_dokter where nm_dokter='$nama' and nipeg != ''");
		} else {
			return null;
		}
	}

	function get_nama_dokter_by_no_ipd($no_ipd)
	{
		return $this->db->query("SELECT 
				a.id_dokter,
				a.nm_dokter,
				a.nipeg,
				d.ttd
			FROM 
				data_dokter AS a,
				pasien_iri AS b,
				dyn_user_dokter AS c,
				hmis_users AS d
			WHERE 
				b.no_ipd = '$no_ipd'
				AND a.id_dokter = b.id_dokter
				AND c.id_dokter = b.id_dokter
				AND d.userid = c.userid");
	}

	function data_nipeg_by_id($id)
	{
		if ($id != "") {
			return $this->db->query("select nipeg from data_dokter where id_dokter='$id'");
		} else {
			return null;
		}
	}


	function get_data_pasien_iri_bynoregasal($noregasal)
	{
		$this->db->where('noregasal', $noregasal);
		return $this->db->get('pasien_iri');
	}

	function check_skrining_covid($noreg)
	{
		return $this->db->query("SELECT a.*,c.ttd as ttd_pemeriksa,c.name
				FROM skrining_covid_igd as a
					LEFT JOIN hmis_users  as c on c.userid = cast(a.id_pemeriksa as int)
					WHERE a.no_register = '$noreg'");
	}

	function get_data_lembar_terapi($no_reg)
	{
		return $this->db->query("SELECT a.*,b.ttd as ttd_dokter,c.ttd as ttd_pemeriksa,b.nm_dokter,c.name
			FROM lembar_program_terapi as a
				LEFT JOIN data_dokter as b on a.id_dokter = b.id_dokter
				LEFT JOIN hmis_users  as c on c.userid = a.userid_pemeriksa
				WHERE a.no_register = '$no_reg'");
	}

	function get_data_formulir_rehab($no_reg)
	{
		return $this->db->query("SELECT * from rehab_medik_irj where no_register ='$no_reg'");
	}

	function getdata_resep_racik($no_register)
	{
		return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.item_obat limit 1) as nm_obat
				FROM obat_racikan AS a where no_register='" . $no_register . "'");
	}

	public function get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* from pemeriksaan_elektromedik a inner join hasil_pemeriksaan_em b
			on a.id_pemeriksaan_em = b.id_pemeriksaan_em where no_medrec='$no_medrec' and substring(no_register,1,2) = 'RJ' order by tgl_kunjungan desc")->result();
	}

	public function get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* from pemeriksaan_elektromedik a inner join hasil_pemeriksaan_em b
			on a.id_pemeriksaan_em = b.id_pemeriksaan_em where no_medrec='$no_medrec' order by tgl_kunjungan desc")->result();
	}

	function getdata_hasil_pemeriksaan_radiologi_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b
			on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE no_medrec = '$no_medrec' and substring(no_register,1,2) = 'RJ' and no_rad is not null and b.id_pemeriksaan_rad is not null order by tgl_kunjungan desc");
	}

	function getdata_hasil_pemeriksaan_history_radiologi_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b
			on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE no_medrec = '$no_medrec' and no_rad is not null and b.id_pemeriksaan_rad is not null order by tgl_kunjungan desc");
	}

	public function get_noreg_pemeriksaan_lab($no_medrec)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE no_medrec = '$no_medrec' and substring(no_register,1,2) = 'RJ' group by no_register order by no_register desc");
	}

	function get_only_dokter_igd($noreg)
	{
		return $this->db->select('h.ttd as ttd_dokter_pengirim,h.name as dokter_pengirim')
			->from('daftar_ulang_irj')
			->where('no_register', $noreg)
			->join('dyn_user_dokter a', 'a.id_dokter = daftar_ulang_irj.id_dokter')
			->join('hmis_users h', 'h.userid = a.userid')
			->get()
			->row();
	}

	function get_surat_kontrol_bysepasal($sep_asal)
	{
		return $this->db->where('no_sep_asal', $sep_asal)
			->get('bpjs_suratkontrol')->row();
	}

	public function get_noipd($no_reg)
	{
		return $this->db->query("SELECT no_ipd from pasien_iri where noregasal = '$no_reg'");
	}

	public function get_pasien_iri($no_ipd)
	{
		return $this->db->select('id_poli')->from('pasien_iri')->where('no_ipd', $no_ipd)->row();
	}

	public function get_list_tindakan_pasien_by_no_ipd($no_register)
	{
		return $this->db->query("SELECT A
				.*,
				(SELECT name FROM hmis_users WHERE userid = a.userid LIMIT 1) AS name,
				(SELECT ttd FROM hmis_users WHERE userid = a.userid LIMIT 1) AS ttd
			FROM
				pelayanan_poli AS A
			WHERE
				A.no_register = '$no_register'");
	}

	public function get_pasien_by_no_ipd($no_register)
	{
		return $this->db->query("SELECT
				a.*, b.*, c.nm_poli, d.nm_dokter
			FROM
				daftar_ulang_irj AS a,
				data_pasien AS b,
				poliklinik AS c,
				data_dokter AS d
			WHERE
				a.no_medrec = b.no_medrec
				AND a.id_poli = c.id_poli
				AND a.id_dokter = d.id_dokter
				AND a.no_register = '$no_register'");
	}

	public function get_ttd_dpjp($id_dokter)
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

	public function get_no_cm_by_medrec($no_medrec)
	{
		return $this->db->query("SELECT no_cm FROM data_pasien WHERE no_medrec = '$no_medrec'");
	}

	public function get_kode_rev_form($kode)
	{
		return $this->db->query("SELECT kode_form,tgl_rev_form,nama FROM data_form WHERE kode = '$kode'");
	}

	function get_data_rasal($noreg)
	{
		return $this->db->query("SELECT * FROM rasal WHERE no_register = '$noreg'");
	}

	function get_data_raslan($noreg)
	{
		return $this->db->query("SELECT * FROM raslan WHERE no_register = '$noreg'");
	}

	function get_data_gyssens($noreg)
	{
		return $this->db->query("SELECT * FROM gyssens WHERE no_register = '$noreg'");
	}

	function get_data_raspatur($noreg)
	{
		return $this->db->query("SELECT * FROM raspatur WHERE no_register = '$noreg'");
	}

	function get_data_iadl($noreg)
	{
		return $this->db->query("SELECT * FROM iadl WHERE no_register = '$noreg'");
	}

	function get_edukasi_penolakan_rencana_asuhan($noreg)
	{
		return $this->db->query("SELECT *
			FROM edukasi_penolakan_rencana_asuhan 
				WHERE no_register = '$noreg'");
	}

	function get_formulir_disfagia($no_ipd)
	{
		return $this->db->query("SELECT * FROM formulir_disfagia WHERE no_register = '$no_ipd'")->row();
	}

	public function get_nihss_for_medik($no_reg)
	{
		$data = $this->db->query("
		select tgl_input,id_dokter,formjson from assesment_medik_igd where no_register = '$no_reg'
		");
		return $data;
	}

	function get_akses_medrec($no_cm, $user)
	{
		return $this->db->query(
			"
			SELECT * FROM akses_medrec where no_cm = '$no_cm' and users = $user and users_acc is not null
			and '" . date('Y-m-d') . "' BETWEEN TO_CHAR(tgl_acc,'YYYY-MM-DD') AND TO_CHAR(tgl_acc + INTERVAL '7 days','YYYY-MM-DD')
			"
		);
	}

	function insert_akses_medrec($data)
	{
		$req = $this->db->query("
		SELECT * FROM akses_medrec where no_cm = '" . $data['no_cm'] . "' and users = " . $data['users'] . " and TO_CHAR(tgl_req,'YYYY-MM-DD') = '" . date('Y-m-d', strtotime($data['tgl_req'])) . "'
		");
		if ($req->num_rows() > 0) {
			return 1;
		}
		return $this->db->insert('akses_medrec', $data);
	}

	function get_permintaan_medrec()
	{
		return $this->db->query("SELECT data_pasien.nama,id,akses_medrec.no_cm,hmis_users.name,tgl_req from akses_medrec join data_pasien on data_pasien.no_cm = akses_medrec.no_cm
		join hmis_users on hmis_users.userid = akses_medrec.users
		where users_acc is null");
	}

	function acc_permintaan_medrec($id, $data)
	{
		return $this->db->where('id', $id)->update('akses_medrec', $data);
	}

	function get_poli() {
		return $this->db->query("SELECT id_poli, nm_poli FROM poliklinik WHERE nm_pokpoli != ''");
	}

	function get_dokter_sbpk($noreg) {
		return $this->db->query("SELECT 
			a.waktu_masuk_dokter,
			e.no_sep,
			d.ttd,
			b.nm_dokter,
			b.nipeg
		FROM 
			daftar_ulang_irj AS a
			LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
			LEFT JOIN dyn_user_dokter AS c ON a.id_dokter = c.id_dokter 
			LEFT JOIN hmis_users AS d ON c.userid = d.userid 
			LEFT OUTER JOIN bpjs_sep AS e ON a.no_register = e.no_register
		WHERE 
			a.no_register = '$noreg'");
	}

	function get_list_empty_sep_pasien($date) {
		return $this->db->query("SELECT
			a.tgl_kunjungan::date,
			c.no_cm,
			a.no_medrec,
			a.no_register,
			c.nama,
			c.sex,
			d.nm_dokter,
			b.nm_poli,
			a.no_sep
		FROM 
			daftar_ulang_irj AS a 
			LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli
			LEFT JOIN data_dokter AS d ON a.id_dokter = d.id_dokter
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
			AND a.id_poli != 'BA00'
			AND a.cara_bayar = 'BPJS'
			AND (a.no_sep IS NULL OR a.no_sep = '')");
	}

	function get_list_empty_sep_pasien_igd($date) {
		return $this->db->query("SELECT
			a.tgl_kunjungan::date,
			c.no_cm,
			a.no_medrec,
			a.no_register,
			c.nama,
			c.sex,
			d.nm_dokter,
			b.nm_poli,
			a.no_sep
		FROM 
			daftar_ulang_irj AS a 
			LEFT JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
			LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli
			LEFT JOIN data_dokter AS d ON a.id_dokter = d.id_dokter
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'
			AND a.id_poli = 'BA00'
			AND a.cara_bayar = 'BPJS'
			AND (a.no_sep IS NULL OR a.no_sep = '')");
	}

	function update_sep($no_register, $no_sep) {
		$this->db->query("UPDATE daftar_ulang_irj SET no_sep = '$no_sep' WHERE no_register = '$no_register'");
		$this->db->query("UPDATE bpjs_sep SET no_sep = '$no_sep' WHERE no_register = '$no_register'");
		return true;
	}

	// add sjj 2024
	function get_pengkajian_rawat_jalan($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_rawat_jalan where no_register='$noreg'");
	}

	function get_pengkajian_medis_rj($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medis_rj where no_register='$noreg'");
	}

	function get_diagnosa_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM diagnosa_pasien where no_register='$noreg'");
	}

    function get_tindakan_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$noreg'");
	}

	function get_procedur($noreg)
	{
		return $this->db->query("SELECT * FROM icd9cm_irj where no_register='$noreg'");
	}

    function get_ringkasan_keluar_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM ringkasan_keluar_rj where no_register='$noreg'");
	}

	function get_lembar_kontrol_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM lembar_kontrol_pasien where no_register='$noreg'");
	}

	function get_lembar_konsul_pasien($noreg)
	{
		return $this->db->query("SELECT
				a.*,(select nm_dokter from data_dokter where a.id_dokter_akhir = data_dokter.id_dokter) as dokter_tujuan,
				(select nm_poli from poliklinik where a.id_poli_akhir = poliklinik.id_poli) as poli_tujuan
			FROM
				lembar_konsul_pasien a
			WHERE
				a.no_register = '$noreg'");
	}

	function get_lembar_jawaban_konsul_pasien($noreg)
	{
		return $this->db->query("SELECT
				a.*,(select nm_dokter from data_dokter where a.id_dokter_akhir = data_dokter.id_dokter) as dokter_tujuan,
				(select nm_poli from poliklinik where a.id_poli_akhir = poliklinik.id_poli) as poli_tujuan
			FROM
				lembar_konsul_pasien a
			WHERE
				a.no_register = '$noreg'");
	}

	function get_pengantar_ranap_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM pengantar_rawat_inap where no_register='$noreg'");
	}

	function get_lab_pasien($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_laboratorium where no_register='$noreg'");
	}

	function get_rad_pasien($noreg)
	{
		return $this->db->query("SELECT jenis_tindakan FROM pemeriksaan_radiologi where no_register='$noreg'");
	}

	function get_permintaan_transfusi_darah($noreg)
	{
		return $this->db->query("SELECT * FROM permintaan_transfusi_darah where no_register='$noreg'");
	}

	function get_persetujuan_tindakan($noreg)
	{
		return $this->db->query("SELECT * FROM persetujuan_tindakan_medik where no_register='$noreg'");
	}

	function get_penolakan_tindakan($noreg)
	{
		return $this->db->query("SELECT * FROM penolakan_tindakan_medik where no_register='$noreg'");
	}

	function surat_rujukan($noreg)
	{
		return $this->db->query("SELECT * FROM surat_rujukan_pasien where no_register='$noreg'");
	}

	function cek_cppt($noreg)
	{
		return $this->db->query("SELECT subjective_dokter FROM soap_pasien_rj where no_register='$noreg'")->row();
	}

	function get_pengkajian_medis_igd($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medis_igd where no_register='$noreg'");
	}

	function get_fisik_igd($noreg)
	{
		return $this->db->query("SELECT sitolic,diatolic,nadi,suhu,pernafasan FROM pemeriksaan_fisik where no_register='$noreg'");
	}

	function get_triase_igd($noreg)
	{
		return $this->db->query("SELECT * FROM triase_igd where no_register='$noreg'");
	}

	function get_ringkasan_pulang_igd($noreg)
	{
		return $this->db->query("SELECT * FROM ringkasan_pulang_igd where no_register='$noreg'");
	}

	function get_skrining_igd($noreg)
	{
		return $this->db->query("SELECT * FROM formulir_skrining where no_register='$noreg'");
	}

	function get_ket_kematian($noreg)
	{
		return $this->db->query("SELECT * FROM surat_keterangan_kematian where no_register='$noreg'");
	}

	function get_diagnosa_pasien_utama($noreg)
	{
		return $this->db->query("SELECT * FROM diagnosa_pasien where no_register='$noreg' and klasifikasi_diagnos = 'utama'");
	}

	function get_resep_mata($noreg)
	{
		return $this->db->query("SELECT * FROM resep_mata where no_register='$noreg'");
	}

	function get_lembar_fisik_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM lembar_kedokteran_fisik_rehab where no_register='$noreg'");
	}

	function get_uji_fungsi_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM hasil_uji_fungsi_rehab where no_register='$noreg'");
	}

	function get_program_terapi_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM program_terapi where no_register='$noreg'");
	}

	function get_keperawatan_obgyn($noreg)
	{
		return $this->db->query("SELECT * FROM perawat_obgyn where no_register='$noreg'");
	}

	function get_cuti($noreg)
	{
		return $this->db->query("SELECT * FROM cuti_perawatan_new where no_register='$noreg'");
	}

	function get_penundaan($noreg)
	{
		return $this->db->query("SELECT * FROM penundaan_pelayanan where no_register='$noreg'");
	}

	function get_observasi($noreg)
	{
		return $this->db->query("SELECT * FROM observasi where no_register='$noreg'");
	}

	function get_edukasi_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM edukasi_pasien where no_register='$noreg'");
	}

	function get_medik_obgyn($noreg)
	{
		return $this->db->query("SELECT * FROM medik_obgyn where no_register='$noreg'");
	}

	function get_pengkajian_medik_anak($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medik_anak where no_register='$noreg'");
	}

	function get_pengkajian_keperawatan_anak($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_keperawatan_anak where no_register='$noreg'");
	}

	function get_pengkajian_medik_tht($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medik_tht where no_register='$noreg'");
	}

	function get_lap_pemebedahan($noreg)
	{
		return $this->db->query("SELECT * FROM laporan_pembedahan where no_register='$noreg'");
	}

	
	function get_lap_echo($noreg)
	{
		return $this->db->query("SELECT * FROM laporan_echo where no_register='$noreg'");
	}

	function get_persetujuan_hiv($noreg)
	{
		return $this->db->query("SELECT * FROM persetujuan_hiv where no_register='$noreg'");
	}
	function get_registrasi_hiv($noreg)
	{
		return $this->db->query("SELECT * FROM formulir_registrasi_hiv where no_register='$noreg'");
	}

	function get_keperawaran_ponek($noreg)
	{
		return $this->db->query("SELECT * FROM keperawatan_ponek where no_register='$noreg'");
	}
	function get_data_medis($no_reg)
		{
			return $this->db->query("SELECT
					formjson ->> 'pasien_pulang' AS pasien_pulang
				FROM
					pengkajian_medis_igd 
				WHERE
					no_register = '$no_reg';");
		}
		
		public function get_dokter_igd($no_reg)
		{
			return $this->db->query("SELECT
				a.id_dokter,
				c.name,
				c.ttd 
			FROM
				daftar_ulang_irj A,
				dyn_user_dokter b,
				hmis_users C 
			WHERE
				A.id_dokter = b.id_dokter 
				AND b.userid = C.userid 
				AND a.no_register = '$no_reg'");
		}
		function get_upload_penunjang($noreg)
		{
			return $this->db->query("SELECT * FROM upload_pemeriksaan_penunjang where no_register='$noreg'");
		}
		function get_medis_ponek($noreg)
		{
			return $this->db->query("SELECT * FROM medis_igd_ponek where no_register='$noreg'");
		}
		function get_triase_ponek($noreg)
		{
			return $this->db->query("SELECT * FROM triase_igd_ponek where no_register='$noreg'");
		}
		function get_asuhan_gizi($noreg)
		{
			return $this->db->query("SELECT * FROM asuhan_gizi where no_register='$noreg'");
		}
		function get_asuhan_gizi_anak($noreg)
		{
			return $this->db->query("SELECT * FROM asuhan_gizi_anak where no_register='$noreg'");
		}

	// function get_data_json($no_reg)
	// 	{
	// 		return $this->db->query("SELECT
	// 				formjson ->> 'rencana' AS rencana 
	// 			FROM
	// 				pengkajian_medis_igd 
	// 			WHERE
	// 				no_register = '$no_reg'");
	// 	}
	


}