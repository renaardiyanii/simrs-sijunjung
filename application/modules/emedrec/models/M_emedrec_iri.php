<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_emedrec_iri extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	public function get_pasien_iri_by_no_cm($no_cm)
	{
		$data = $this->db->query("
		select a.*, a.jasa_perawat as jasaperawat, b.*,d.*,e.*, 
		f.nm_diagnosa as nm_diagmasuk, d.nmruang, a.id_dokter as dr_dpjp, a.tuslah
		from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join ruang_iri as c on a.no_ipd = c.no_ipd
		left join ruang as d on c.idrg = d.idrg
		left join icd1 as e on a.diagnosa1 = e.id_icd
		left join icd1 as f on a.diagmasuk = f.id_icd
		where b.no_cm = '$no_cm' 
		Order by c.idrgiri DESC");
		return $data->result();
	}

	public function get_pasien_by_no_ipd_for_resume($no_ipd)
	{
		$data = $this->db->query("
		select a.*, a.jasa_perawat as jasaperawat, b.*, c.vtot as vtot_ruang, c.*,d.*,e.*, 
		f.nm_diagnosa as nm_diagmasuk, d.nmruang, g.nmkontraktor, a.id_dokter as dr_dpjp, a.tuslah,hmis_users.ttd as ttd_dpjp,
		(select nm_dokter from data_dokter where data_dokter.id_dokter = a.id_dokter) as nami
		from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		left join ruang_iri as c on a.no_ipd = c.no_ipd
		left join ruang as d on a.idrg = d.idrg
		left join icd1 as e on a.diagnosa1 = e.id_icd
		left join icd1 as f on a.diagmasuk = f.id_icd
		left join kontraktor g on g.id_kontraktor=a.id_kontraktor
		left join dyn_user_dokter on dyn_user_dokter.id_dokter = a.id_dokter
		left join hmis_users on hmis_users.userid = dyn_user_dokter.userid
		where a.no_ipd = '$no_ipd' 
		Order by c.idrgiri DESC");
		return $data;
	}

	public function get_assesment_medis_bynoipd($no_ipd)
	{
		$data = $this->db->query("
		SELECT
		a.*,
		b.ttd as ttd,
		b.name as name
		FROM
			assesment_medis_iri as a
		LEFT JOIN hmis_users as b
			ON cast(a.userid as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'
		");
		return $data;
	}

	public function get_data_formulir_b($no_ipd)
	{
		$data = $this->db->query("
			SELECT A
			.*,
			b.NAME as user_nama,
			b.ttd 
		FROM
			form_b_evaluasi AS A,
			hmis_users AS b 
		WHERE
			no_ipd = '$no_ipd' 
			AND A.xuser = b.userid
		");
		return $data;
	}

	public function get_data_formulir_a($no_ipd)
	{
		$data = $this->db->query("
		SELECT
		a.*,
		b.ttd as ttd
		
		
		FROM
		form_a_evaluasi as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'
		");
		return $data;
	}


	public function get_obat_for_resume($no_ipd)
	{
		$data = $this->db->query("
		SELECT * FROM resep_dokter WHERE no_register = '$no_ipd' and resep_pulang = '1'
		");
		return $data;
	}

	public function get_obat_all_for_resume($no_ipd)
	{
		$data = $this->db->query(" SELECT * FROM resep_pasien WHERE no_register = '$no_ipd' and resep_pulang ='0' ");
		return $data;
	}

	public function get_radiologi_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$no_ipd'
		");
		return $data;
	}

	public function get_lab_for_resume($no_ipd)
	{
		$data = $this->db->query("SELECT 
			* 
		FROM 
			pemeriksaan_laboratorium 
		WHERE 
			no_register = '$no_ipd'
			AND no_lab IS NOT NULL
			AND cetak_hasil = 1");

		return $data;
	}

	public function get_diagnosa_for_resume($no_ipd)
	{
		$data = $this->db->query("
		select * from diagnosa_iri where no_register = '$no_ipd' and klasifikasi_diagnos != 'utama'
		");
		return $data;
	}

	public function get_diagnosa_utama_for_resume($no_ipd)
	{
		$data = $this->db->query("SELECT * from diagnosa_iri where no_register ='$no_ipd'  and klasifikasi_diagnos = 'utama'
		");
		return $data;
	}

	public function get_tindakan_utama_for_resume($no_ipd)
	{
		$data = $this->db->query("
		SELECT
				pelayanan_iri_temp.no_ipd,
				pelayanan_iri_temp.id_tindakan,
				jenis_tindakan.nmtindakan,
				jenis_tindakan.idtindakan
			FROM
				pelayanan_iri_temp
			LEFT JOIN jenis_tindakan 
				ON pelayanan_iri_temp.id_tindakan = jenis_tindakan.idtindakan where pelayanan_iri_temp.no_ipd = '$no_ipd'
		");
		return $data;
	}


	public function get_data_for_pengantar_iri_by_no_ipd($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengantar_iri WHERE no_ipd = '$no_ipd'")->result();
	}

	public function get_tanggal_masuk_ranap($no_ipd)
	{
		return $this->db->query("SELECT tgl_masuk FROM pasien_iri WHERE no_ipd = '$no_ipd'");
	}

	public function get_last_ruang($no_ipd)
	{
		return $this->db->query("SELECT b.nmruang FROM ruang_iri AS a, ruang AS b WHERE a.no_ipd = '$no_ipd' AND a.idrg = b.idrg ORDER BY a.tglmasukrg ASC LIMIT 1");
	}

	public function get_data_general_consent($no_register)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_register='$no_register'")->result();
	}

	public function get_noregasal($no_ipd)
	{
		return $this->db->query("SELECT * FROM pasien_iri WHERE no_ipd='$no_ipd'");
	}

	public function get_data_iri($no_reg)
	{
		$data = $this->db->query("SELECT * FROM pasien_iri WHERE no_ipd = '$no_reg'");

		return $data->result_array();
	}

	public function get_data_surat_persetujuan($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_persetujuan_iri WHERE no_ipd='$no_ipd'")->result();
	}

	public function get_data_catatan_awal_medis($no_ipd)
	{
		return $this->db->query("SELECT a.*,b.no_medrec,b.carabayar,b.id_dokter,c.pekerjaan,d.*,e.nm_dokter,h.id_dokter as dpjp,f.ttd,e.nm_dokter as nm_pemeriksa,e.nipeg FROM assesment_medis_iri as a
		LEFT JOIN pasien_iri as b on a.no_ipd = b.no_ipd
		LEFT JOIN data_pasien  as c on b.no_medrec = c.no_medrec
		LEFT JOIN pemeriksaan_fisik_ri as d on a.no_ipd = d.no_ipd
		LEFT JOIN hmis_users as f on a.userid = cast(f.userid as TEXT)
		LEFT JOIN dyn_user_dokter as h on a.userid = cast(h.userid as TEXT)
		LEFT JOIN data_dokter as e on h.id_dokter = e.id_dokter
		WHERE a.no_ipd = '$no_ipd'")->result();
		// $this->db->where('no_ipd',$no_ipd);
		// return $this->db->get('assesment_medis_iri')->result();
	}

	public function assesment_awal_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd,
		b.name as name
		
		
		FROM
			assesment_keperawatan_iri as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_perawat_1 as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'")->result();
	}

	public function pengkajian_dekubitus($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd
		
		
		FROM
			dekubitus_tambahan_iri as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'")->result();
	}

	public function fungsional_iri($no_ipd)
	{
		return $this->db->query("SELECT
			a.*,
			b.ttd as ttd
		FROM
			fungsional_tambahan_iri as a
			LEFT JOIN hmis_users as b ON cast(a.id_pemeriksa as int) = b.userid
		WHERE 
			a.no_ipd = '$no_ipd'
		ORDER BY 
			a.tgl_input DESC")->result();
	}

	public function skala_morse_iri($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd
		
		
		FROM
			skala_morse_tambahan_iri as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'")->result();
	}

	public function ews_iri($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd
		
		
		FROM
			lembar_ews_ri as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'")->row();
	}

	public function get_rencana_pemulangan($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd,
		b.name as perawat
		
		FROM
			rencana_pemulangan_iri as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'");
	}

	public function get_data_pasien($medrec)
	{
		return $this->db->query("SELECT * FROM data_pasien WHERE no_medrec='$medrec'")->result();
	}

	function get_cppt_iri($no_ipd)
	{
		return $this->db->query("SELECT 
			a.*,
			b.ttd,
			(SELECT c.ttd FROM hmis_users c, dyn_user_dokter d WHERE d.id_dokter = a.id_pjp AND d.userid = c.userid LIMIT 1) AS ttd_pjp
		FROM 
			soap_pasien_ri as a
			LEFT JOIN hmis_users as b on a.id_pemeriksa = b.userid
		WHERE 
			a.no_ipd = '$no_ipd' 
			and a.role != 'Case Manager'
		ORDER BY 
			tanggal_pemeriksaan DESC");
	}

	function get_cppt_iri_all($medrec)
	{
		return $this->db->query("SELECT A
			.*,
			b.ttd,
			hm.ttd AS ttd_pjp 
		FROM
			soap_pasien_ri AS A 
			INNER JOIN pasien_iri AS c ON A.no_ipd = c.no_ipd
			LEFT JOIN hmis_users AS b ON A.id_pemeriksa = b.userid
			FULL OUTER JOIN hmis_users AS hm ON hm.userid = A.id_pjp 
		WHERE
			c.no_medrec = '$medrec' 
			and a.role != 'Case Manager'
		ORDER BY
			tanggal_pemeriksaan DESC");
	}


	function get_konsul_igd($no_ipd)
	{
		return $this->db->query("SELECT a.*,g.no_cm,g.nama,c.tgl_lahir,AGE(current_date,c.tgl_lahir) as umur,d.nm_dokter as dokter_pengirim,d.nipeg as nipeg_pengirim ,e.nm_dokter as dokter_penerima , e.nipeg as nipeg_penerima,f.nm_poli as nama_poli_tujuan,h.userid as userid_pengirim,i.userid as userid_penerima
		FROM konsultasi_pasien_iri as a 
		LEFT JOIN pasien_iri as b on b.no_ipd = a.no_ipd 
		LEFT JOIN data_pasien as g on b.no_medrec = g.no_medrec
		LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec 
		LEFT JOIN data_dokter as d on d.id_dokter = CAST(a.id_dokter_pengirim AS INTEGER) 
		LEFT JOIN data_dokter as e on e.id_dokter = CAST(a.id_dokter_penerima AS INTEGER)
		LEFT JOIN poliklinik as f on f.id_poli = SUBSTRING(a.id_poli_tujuan,1,4)
		LEFT JOIN dyn_user_dokter as h on h.id_dokter = a.id_dokter_pengirim
		LEFT JOIN dyn_user_dokter as i on i.id_dokter = a.id_dokter_penerima
		where a.no_ipd = '$no_ipd'
		");
	}

	function get_konsultasi_pasien_iri($no_ipd)
	{
		// return $this->db->query("SELECT a.*,c.nama,c.tgl_lahir,AGE(current_date,c.tgl_lahir) as umur,c.no_cm,d.nm_dokter as nama_dokter_penerima,d.nipeg as nipeg_penerima,e.nm_poli,f.nipeg as nipeg_pengirim,g.nmruang,hmis_two.ttd as ttd_penerima,hmis_one.ttd as ttd_pengirim
		// FROM konsultasi_pasien_iri as a
		// LEFT JOIN pasien_iri as b on a.no_ipd = b.no_ipd 
		// LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec 
		// LEFT JOIN data_dokter as d on CAST(a.id_dokter_penerima AS INTEGER) = d.id_dokter
		// LEFT JOIN poliklinik as e on e.id_poli = SUBSTRING(a.id_poli_tujuan,1,4)	
		// LEFT JOIN data_dokter as f on CAST(a.id_dokter_pengirim AS INTEGER) = f.id_dokter
		// LEFT JOIN data_dokter as h ON h.id_dokter = a.id_dokter_penerima
		// LEFT JOIN data_dokter as i ON i.id_dokter = a.id_dokter_pengirim
		// LEFT JOIN dyn_user_dokter as d_one on d_one.id_dokter = a.id_dokter_pengirim
		// LEFT JOIN hmis_users as hmis_one on hmis_one.userid = d_one.userid
		// LEFT JOIN dyn_user_dokter as d_two on d_two.id_dokter = a.id_dokter_penerima
		// LEFT JOIN hmis_users as hmis_two on hmis_two.userid = d_two.userid
		// LEFT JOIN ruang as g on g.idrg = a.ruangan
		// WHERE a.no_ipd ='$no_ipd'");

		return $this->db->query("SELECT DISTINCT a.no_ipd,a.tgl_konsultasi,a.id_dokter_pengirim,a.id_dokter_penerima,a.id_poli_tujuan,
		a.ruangan,a.kemungkinan,a.diobati_untuk,a.kelainan,a.pengobatan,
		a.perhatian_khusus,a.nasehat,a.permintaan_dokter_asal,a.nm_dokter_pengirim,
		a.nm_dokter_penerima,a.id,a.jawaban_konsul_rehab::jsonb,
		CASE
		WHEN a.jawaban_konsul_rehab is not NULL then 
		 '<b>'||CAST(a.jawaban_konsul_rehab::json->>'subjective' as varchar)||'</b>'||'<br>'||
		 '<b>komunikasi :</b>'||'<br> &nbsp;- <b>Distalgia : </b> '||  
		 CAST(a.jawaban_konsul_rehab->'komunikasi'->>'distagia' as varchar)  || '<br> &nbsp;- <b>Disatria : </b>' ||
		 CAST(a.jawaban_konsul_rehab->'komunikasi'->>'disatria' as varchar) || ' <br>' ||
		 
		 '<b>Mobilisasi :</b>'||'<br> - <b>Sitting Balance : </b> '||  
		 CAST(a.jawaban_konsul_rehab->'mobilisasi'->>'sitting_balance' as varchar)  || '<br> &nbsp;- <b>Standing Balance : </b>' ||
		 CAST(a.jawaban_konsul_rehab->'mobilisasi'->>'standing_balance' as varchar) || ' <br>' ||
		 '&nbsp;- <b>Gait : </b>' ||
		 CAST(a.jawaban_konsul_rehab->'mobilisasi'->>'gait' as varchar) || ' <br>' ||
		 
		 '<b>Upper Extremity :</b> <br>' || '&nbsp;- <b>Dextra</b> : ' ||
		 CAST(a.jawaban_konsul_rehab->'question1'->'upper_extremity'->>'dextra' as varchar)  || '<br> &nbsp;- <b>Sinistra : </b>' ||
		 CAST(a.jawaban_konsul_rehab->'question1'->'upper_extremity'->>'sinistra' as varchar) || ' <br>' ||
		 '<b>Lower Extremity :</b> <br>' || '&nbsp;- <b>Dextra</b> : ' ||
		 CAST(a.jawaban_konsul_rehab->'question1'->'lower_extremity'->>'dextra' as varchar)  || '<br> &nbsp;- <b>Sinistra : </b>' ||
		 CAST(a.jawaban_konsul_rehab->'question1'->'lower_extremity'->>'sinistra' as varchar) || ' <br>' ||
		 
		 '<b>UMN Sign :</b> '||
		 CAST(a.jawaban_konsul_rehab->'umn_signn'->>'umn_sign' as varchar)  || '<br>' ||
		 '<b>Ulkus :</b> '||
		 CAST(a.jawaban_konsul_rehab->'umn_signn'->>'ulkus' as varchar)  || '<br>' ||
		 '<b>Kontraktur :</b> '||
		 CAST(a.jawaban_konsul_rehab->'umn_signn'->>'kontraktur' as varchar) 
		 else
		 a.hal_yang_ditemukan
		END
		as hal_yang_ditemukan,
		
		CASE
		WHEN  a.jawaban_konsul_rehab is not NULL then
		'<b>'||CAST(a.jawaban_konsul_rehab::json->>'assesment' as varchar)||'</b>'
		ELSE
		a.kesan
		END as kesan,
		
		CASE
		WHEN  a.jawaban_konsul_rehab is not NULL then
		'<b>'||CAST(a.jawaban_konsul_rehab::json->>'planning' as varchar)||'</b>'
		ELSE
		a.anjuran
		END as anjuran,
		
		a.pengajuan_konsul_kembali,
		a.pemindahan_pengobatan,
		a.tgl_jawaban,
		
		c.nama,c.tgl_lahir,AGE(current_date,c.tgl_lahir) as umur,c.no_cm,d.nm_dokter as nama_dokter_penerima,d.nipeg as nipeg_penerima,e.nm_poli,f.nipeg as nipeg_pengirim,g.nmruang,hmis_two.ttd as ttd_penerima,hmis_one.ttd as ttd_pengirim
				FROM konsultasi_pasien_iri as a
				LEFT JOIN pasien_iri as b on a.no_ipd = b.no_ipd 
				LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec 
				LEFT JOIN data_dokter as d on CAST(a.id_dokter_penerima AS INTEGER) = d.id_dokter
				LEFT JOIN poliklinik as e on e.id_poli = SUBSTRING(a.id_poli_tujuan,1,4)	
				LEFT JOIN data_dokter as f on CAST(a.id_dokter_pengirim AS INTEGER) = f.id_dokter
				LEFT JOIN data_dokter as h ON h.id_dokter = a.id_dokter_penerima
				LEFT JOIN data_dokter as i ON i.id_dokter = a.id_dokter_pengirim
				LEFT JOIN dyn_user_dokter as d_one on d_one.id_dokter = a.id_dokter_pengirim
				LEFT JOIN hmis_users as hmis_one on hmis_one.userid = d_one.userid
				LEFT JOIN dyn_user_dokter as d_two on d_two.id_dokter = a.id_dokter_penerima
				LEFT JOIN hmis_users as hmis_two on hmis_two.userid = d_two.userid
				LEFT JOIN ruang as g on g.idrg = a.ruangan
				WHERE a.no_ipd ='$no_ipd'");
	}

	function pemeriksaan_fisik_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik_ri WHERE no_ipd ='$no_ipd' order by tanggal_pemeriksaan desc limit 1");
	}

	function get_catatan_edukasi_iri($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd,
		b.name as perawat
		
		FROM
			catatan_edukasi as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_perawat as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'");
	}

	function get_ceklis_pasien_iri($no_ipd)
	{
		return $this->db->query("SELECT
		a.*,
		b.ttd as ttd,
		b.name as perawat
		
		FROM
			ceklis_pasien_mpp as a
		LEFT JOIN hmis_users as b
			ON cast(a.id_pemeriksa as int) = b.userid
		WHERE a.no_ipd = '$no_ipd'");
	}


	function get_jadwal_dpjp_case_manager($noipd)
	{
		return $this->db->query("SELECT a.no_ipd, a.id_pemeriksa, b.sebagai,b.tgl_input,d.ttd
		from soap_pasien_ri a, jadwal_dpjp_case_manager b, dyn_user_dokter c, hmis_users d
		where a.no_ipd ='$noipd'
		and a.id_pemeriksa = cast(b.userid as int ) 
		and a.tanggal_pemeriksaan = b.tgl_input
		and cast(b.userid as integer) = c.userid
		and d.userid = c.userid 
		order by b.tgl_input	");
		// return $this->db->query("SELECT a.no_ipd, a.id_pemeriksa, b.sebagai,to_char(b.tgl_input,'YYYY-MM-DD') as tgl_input
		// from soap_pasien_ri a, jadwal_dpjp_case_manager b
		// where a.no_ipd ='$noipd'
		// and a.id_pemeriksa = cast(b.userid as int ) and a.tanggal_pemeriksaan = b.tgl_input
		// order by b.tgl_input
		// ");
		// $this->db->where('no_ipd',$noipd);
		// return $this->db->get('jadwal_dpjp_case_manager');
	}

	function get_tgl_jadwal_dpjp_case_manager($noipd)
	{
		return $this->db->query("SELECT tgl_input,no_ipd from case_manager_tgl_input
		WHERE no_ipd='$noipd'
		group by tgl_input,no_ipd");
	}

	function get_dokter_jadwal_dpjp_case_manager($noipd)
	{
		return $this->db->query("SELECT userid,sebagai,nm_dokter,ttd,no_ipd  from case_manager_dokter
		WHERE no_ipd='$noipd'
		group by userid,sebagai,nm_dokter,ttd,no_ipd  ");
	}

	function data_pasien($no_ipd)
	{
		if (substr($no_ipd, 0, 2) == 'RI') {
			return $this->db->query("SELECT *,(select nmruang from ruang where ruang.idrg = pasien_iri.idrg
			)
			FROM 
				data_pasien
			LEFT JOIN pasien_iri
			ON data_pasien.no_medrec = pasien_iri.no_medrec where pasien_iri.no_ipd='$no_ipd'");
		} else {
			return $this->db->query("SELECT *
			FROM 
				data_pasien
			RIGHT OUTER JOIN daftar_ulang_irj
			ON data_pasien.no_medrec = daftar_ulang_irj.no_medrec where daftar_ulang_irj.no_register='$no_ipd'");
		}
	}

	function data_pasien_iri($no_ipd)
	{
		return $this->db->query("
		SELECT *,(select nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as nm_dokter_dpjp,
		(select nipeg from data_dokter where id_dokter=pasien_iri.id_dokter) as nipeg_dpjp,
		hmis_users.ttd as ttd_dokter_dpjp
		FROM daftar_ulang_irj
		RIGHT OUTER JOIN pasien_iri
		ON daftar_ulang_irj.no_register = pasien_iri.noregasal 
		LEFT JOIN dyn_user_dokter on dyn_user_dokter.id_dokter = pasien_iri.id_dokter
		LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid
		where pasien_iri.no_ipd='$no_ipd'");
	}

	function get_diagnosa_masuk_ringkasan($no_reg_asal)
	{
		return $this->db->query("
		select * from diagnosa_pasien where no_register = '$no_reg_asal'
		");
	}



	function get_drtambahan_iri($noreg)
	{
		return $this->db->query("SELECT a.*,b.nm_dokter FROM drtambahan_iri as a
		LEFT JOIN data_dokter as b on CAST(a.id_dokter AS INTEGER)= b.id_dokter
		WHERE a.no_register='$noreg'");
		// $this->db->where('no_register',$noreg);
		// return $this->db->get('drtambahan_iri');
	}

	function gethasil_rad($noipd)
	{
		return $this->db->query("SELECT *, (select nmtindakan from jenis_tindakan where idtindakan = pemeriksaan_radiologi.id_tindakan)  as nmrad
		FROM pemeriksaan_radiologi
		WHERE pemeriksaan_radiologi.no_register='$noipd'");
	}

	function gethasil_lab($noipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium where no_register ='$noipd'");
	}

	function gethasil_em($noipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik where no_register ='$noipd'");
	}

	public function get_data_laboratorium_by_noipd($noipd)
	{
		return $this->db->query("SELECT b.*, c.nmtindakan,hmis_users.ttd as ttd_dokter_pengirim,hmis_users.name
		FROM
				hasil_pemeriksaan_lab as b
				LEFT JOIN jenis_tindakan_lab as c
				ON b.id_tindakan = c.idtindakan
				LEFT JOIN pemeriksaan_laboratorium on pemeriksaan_laboratorium.no_lab  = b.no_lab
				LEFT JOIN dyn_user_dokter on CAST(dyn_user_dokter.id_dokter as varchar) = pemeriksaan_laboratorium.id_dokter
				LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid
				WHERE b.no_register='$noipd'
		");
	}

	function get_spri($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('pasien_iri');
	}

	function getdata_hasil_pemeriksaan_radiologi_iri($noipd)
	{
		return $this->db->query("SELECT a.*, b.*,hmis_users.ttd as ttd_dokter,hmis_users.name as nm_dokter 
		FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad LEFT JOIN dyn_user_dokter on CAST(dyn_user_dokter.id_dokter as varchar) = b.id_dokter_1 left join hmis_users on hmis_users.userid = dyn_user_dokter.userid WHERE a.no_register = '$noipd'");
	}

	function get_serah_terima($noipd, $noreg)
	{
		return $this->db->query("SELECT * FROM serah_terima WHERE no_register='$noipd'
		UNION ALL
		SELECT * FROM serah_terima WHERE no_register_lama='$noreg'
		");
	}


	function get_asuhan_gizi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('asuhan_gizi');
	}


	function get_ttd_gizi($name)
	{
		$this->db->where('username', $name);
		return $this->db->get('hmis_users');
	}

	function get_assesment_gizi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('assesment_gizi');
	}


	function get_ttd_assesment_gizi($name)
	{
		$this->db->where('userid', $name);
		return $this->db->get('hmis_users');
	}

	function get_serah_terima_iri($noipd, $noreglama)
	{
		return $this->db->query("(SELECT * FROM serah_terima WHERE no_register='$noipd' ORDER BY id desc)
		UNION ALL
		(SELECT * FROM serah_terima WHERE no_register='$noreglama' ORDER BY id desc)");
	}

	function get_rekonsiliasi_obat($noipd)
	{

		return $this->db->query("SELECT
				a.*
				FROM
				 rekonsiliasi_obat as a
				 where a.no_ipd = '$noipd'
					");
	}

	function get_pemberian_obat($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('daftar_pemberian_obat');
	}

	function get_laporan_persalinan($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('laporan_persalinan');
	}


	public function get_dokter_ruangan($noipd)
	{
		return $this->db->query("SELECT drtambahan_iri.*,data_dokter.nm_dokter,data_dokter.ttd,data_dokter.nipeg FROM drtambahan_iri
		join data_dokter on cast(drtambahan_iri.id_dokter as integer) = data_dokter.id_dokter 
		where no_register = '$noipd' and drtambahan_iri.ket = 'dokter_ruangan'
		");
	}

	public function get_catatan_persalinan($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_persalinan WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_id_poli_asal($noregasal)
	{
		return $this->db->query("select * from daftar_ulang_irj where no_register = '$noregasal' ");
	}

	public function assesment_keperawatan_ird_get($noregasal)
	{
		return $this->db->query("select * from assesment_keperawatan_ird where no_register = '$noregasal' ");
	}

	public function assesment_keperawatan_irj_get($noregasal)
	{
		return $this->db->query("select * from assesment_keperawatan_irj where no_register = '$noregasal' ");
	}
	public function get_riwayat_penyakit_igd($no_register)
	{
		return $this->db->query("SELECT * FROM assesment_keperawatan_ird WHERE no_register='$no_register' ");
	}

	public function get_fisik_igd($no_register)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$no_register' ");
	}

	public function get_elektro_for_resume($no_ipd)
	{
		$data = $this->db->query("
			SELECT * FROM pemeriksaan_elektromedik WHERE no_register = '$no_ipd'
		");
		return $data;
	}

	public function get_poli($no_register)
	{
		return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register='$no_register' ");
	}

	public function get_hasil_lab_for_resume($no_register, $id_tindakan)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_register='$no_register' and id_tindakan = '$id_tindakan' ");
	}

	public function get_prosedur_for_resume($no_register)
	{
		return $this->db->query("SELECT * FROM icd9cm_iri WHERE no_register='$no_register' ");
	}


	function update_data_resume($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('resume_pulang_iri', $data);
	}

	function insert_data_resume($data_insert)
	{
		return $this->db->insert('resume_pulang_iri', $data_insert);
	}

	function get_ttd_by_name($name)
	{
		return $this->db->query("select ttd,name from hmis_users where name = '$name' ");
	}

	public function get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* from pemeriksaan_elektromedik a inner join hasil_pemeriksaan_em b
		on a.id_pemeriksaan_em = b.id_pemeriksaan_em where no_medrec='$no_medrec' and substring(no_register,1,2) = 'RI'  order by tgl_kunjungan desc ")->result();
	}

	public function get_gabungan_hasil_pemeriksaan_em_pemeriksaanelektromedik_all2($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* from pemeriksaan_elektromedik a inner join hasil_pemeriksaan_em b
		on a.id_pemeriksaan_em = b.id_pemeriksaan_em where no_medrec='$no_medrec' order by tgl_kunjungan desc ")->result();
	}


	function getdata_hasil_pemeriksaan_radiologi_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b 
		on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE no_medrec = '$no_medrec' and substring(no_register,1,2) = 'RI'  order by tgl_kunjungan desc ");
	}

	function getdata_hasil_pemeriksaan_history_radiologi_all($no_medrec)
	{
		return $this->db->query("SELECT a.*, b.* FROM pemeriksaan_radiologi as a LEFT JOIN hasil_pemeriksaan_rad as b 
		on a.id_pemeriksaan_rad = b.id_pemeriksaan_rad WHERE no_medrec = '$no_medrec' order by tgl_kunjungan desc ");
	}

	public function get_noreg_pemeriksaan_lab($no_medrec)
	{
		return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE no_medrec = '$no_medrec' and substring(no_register,1,2) = 'RI'  group by no_register ");
	}

	public function get_data_em_query($noipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik WHERE no_register = '$noipd' ");
	}

	public function get_data_rad_query($noipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register = '$noipd' ");
	}

	public function get_data_lab_query($noipd)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_register = '$noipd' ");
	}

	public function gte_tdd_keluarda($noipd)
	{
		return $this->db->query("SELECT * FROM surat_persetujuan_iri WHERE no_ipd = '$noipd' ");
	}

	public function get_data_resrp_query($noipd)
	{
		return $this->db->query("SELECT * FROM resep_pasien WHERE no_register = '$noipd' ");
	}

	public function get_hasil_lab_for_resume_last($no_register, $idtindakan)
	{
		return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_register='$no_register' and id_tindakan = '$idtindakan' ");
	}

	function get_intruksi_obat($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('intruksi_obat_iri');
	}

	public function get_nolab_pemeriksaan_lab($no_register)
	{
		return $this->db->query("SELECT
			a.no_lab 
		FROM
			pemeriksaan_laboratorium a,
			hasil_pemeriksaan_lab c
		WHERE
			a.no_register = '$no_register' 
			AND a.no_lab IS NOT NULL 
			AND a.no_register = c.no_register
			AND a.cetak_hasil = 1
		GROUP BY
			a.no_lab 
		ORDER BY
			a.no_lab DESC ");
	}

	public function data_pasien_kio($no_register)
	{
		return $this->db->query("SELECT a.nama,a.tgl_lahir,a.no_medrec,d.status_pulang,a.alamat, d.id_dokter,d.tgl_masuk,d.tgl_keluar,to_char(c.tgl_input,'MM') as tgl_masukin_kio,d.nm_ruang
		from data_pasien a, resep_pasien b, intruksi_obat_iri c, pasien_iri d
		where a.no_medrec = cast(b.no_medrec as integer) and b.no_register = c.no_ipd
		and b.no_register = d.no_ipd
		and b.no_register = '$no_register'
		group by a.nama,a.tgl_lahir,a.no_medrec,d.status_pulang,a.alamat, d.id_dokter,d.tgl_masuk,d.tgl_keluar,to_char(c.tgl_input,'MM'),d.nm_ruang ");
	}

	public function bln_kio($no_register)
	{
		return $this->db->query("SELECT to_char(tgl_input,'MM') as tgl_masukin_kio FROM intruksi_obat_iri WHERE no_ipd = '$no_register' group by to_char(tgl_input,'MM') ");
	}

	public function nm_dokter_kio($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter = '$id_dokter' ");
	}

	public function tgl_kio($no_register)
	{
		return $this->db->query("SELECT to_char(tgl_input,'MM') as bln,to_char(tgl_input,'DD') as tgl FROM intruksi_obat_iri WHERE no_ipd = '$no_register' group by to_char(tgl_input,'MM'),to_char(tgl_input,'DD') ");
	}

	public function get_kio($no_register)
	{
		return $this->db->query("SELECT *, to_char(tgl_input,'MM') as bln,to_char(tgl_input,'DD') as tgl FROM intruksi_obat_iri WHERE no_ipd = '$no_register' ");
	}

	public function obat_kio($no_register)
	{
		return $this->db->query("SELECT item_obat,nama_obat FROM resep_pasien WHERE no_register = '$no_register' group by nama_obat,item_obat ");
	}

	public function get_riwayat_penyakit($no_register, $id_poli)
	{
		if ($id_poli == 'BA00') {
			return $this->db->query("SELECT * FROM assesment_keperawatan_ird WHERE no_register='$no_register' ");
		} else {
			return $this->db->query("SELECT * from assesment_keperawatan_irj where no_register = '$no_register' ");
		}
	}

	public function get_data_selisih_tarif($no_ipd)
	{
		return $this->db->query("SELECT * FROM selisih_tarif WHERE no_ipd='$no_ipd'");
	}

	public function get_catatan_medis_awal_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_awal_medis_neonetus WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_persalinan_normal($no_ipd)
	{
		return $this->db->query("SELECT * FROM persalinan_normal WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_pemantauan_pemberian_cairan($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemberian_cairan_iri WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_persetujuan_anestesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_anestesi_ri WHERE no_ipd='$no_ipd'")->result();
	}

	public function get_asuhan_keperawatan_perioperatif($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM asuhan_keperawatan_peri_operatif WHERE no_ipd='$no_ipd' or no_ipd='$noregasal'")->result();
	}

	public function get_catatan_observasi_khusus($no_ipd)
	{
		return $this->db->query("SELECT * FROM catatan_observasi_khusus WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_asesmen_jatuh_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_resiko_jatuh WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_monitor_asesmen_jatuh_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_resiko_jatuh WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_pengkajian_jatuh_anak($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_resiko_jatuh_anak WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_skrining_gizi_anak_lanjut($no_ipd)
	{
		return $this->db->query("SELECT * FROM gizi_anak_ri WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_monitoring_asesmen_nyeri_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * FROM monitoring_nyeri_ri WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_pengkajian_nyeri_komprehensif($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_nyeri_komprehensif WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_persetujuan_kedokteran($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_kedokteran WHERE no_ipd='$no_ipd'")->result();
	}
	public function get_penolakan_kedokteran($no_ipd)
	{
		return $this->db->query("SELECT * FROM penolakan_kedokteran_ri WHERE no_ipd='$no_ipd'")->result();
	}
	public function get_edukasi_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM edukasi_anestesi_ri WHERE no_ipd='$no_ipd'")->result();
	}
	public function get_status_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM status_sedasi_ri WHERE no_ipd='$no_ipd'")->result();
	}
	public function get_checklist_keselamatan_operasi($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM checklist_keselamatan_pasien_operasi WHERE no_ipd='$no_ipd' or no_ipd='$noregasal'")->result();
	}
	public function get_lap_medik_lokal_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM lap_medik_lokal_anestesi WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_asuhan_keperawatan_pre_operatif($no_ipd)
	{
		return $this->db->query("SELECT * FROM keperawatan_preoperatif_ri WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_checklist_persiapan_operasi($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM checklist_persiapan_operasi WHERE no_ipd='$no_ipd' or no_ipd='$noregasal'")->result();
	}
	public function get_pembedahan_lokal_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM pembedahan_anestesi_lokal_ri WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_pemberian_infus($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemberian_infus_ri WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_pra_anestesi($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM assesment_pra_anestesi WHERE no_ipd='$no_ipd' or no_ipd='$noregasal' ")->result();
	}
	public function get_surveilans($no_ipd)
	{
		return $this->db->query("SELECT * FROM surveilans_ri WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_prasedasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_pra_sedasi WHERE no_ipd='$no_ipd'")->row();
	}
	public function lap_anestesi($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi WHERE no_ipd='$no_ipd' or no_ipd = '$noregasal'")->result();
	}
	public function lap_operasi($no_ipd)
	{
		return $this->db->query("SELECT * FROM laporan_operasi WHERE no_ipd='$no_ipd'")->result();
	}
	public function get_pengkajian_rehab_medik($no_ipd)
	{
		return $this->db->query("SELECT * FROM pengkajian_rehab_medik WHERE no_ipd='$no_ipd'")->row();
	}
	public function get_site_marking($no_ipd)
	{
		return $this->db->query("SELECT * FROM site_marking_ri WHERE no_ipd='$no_ipd'")->row();
	}
	function get_surat_rujukan($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_rujukan where no_ipd='$no_ipd'")->row();
	}
	function get_permintaan_pulang_sendiri($no_ipd)
	{
		return $this->db->query("SELECT * FROM permintaan_pulang_sendiri where no_ipd='$no_ipd'")->row();
	}
	function get_surat_pernyataan_dnr($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_pernyataan_dnr where no_ipd='$no_ipd'")->result();
	}

	function get_penundaan_pelayanan($no_ipd)
	{
		return $this->db->query("SELECT * FROM penundaan_pelayanan where no_ipd='$no_ipd'")->row();
	}
	function get_asesmen_resiko_kejadian_dekubitus($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_resiko_kejadian_dekubitus where no_ipd='$no_ipd'")->row();
	}


	function get_tindakan_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM tindakan_keperawatan_iri where no_ipd='$no_ipd'")->row();
	}

	function get_asesmen_ginekologi_kebidanan($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_ginekologi_kebidanan where no_ipd='$no_ipd'");
	}

	function get_cppt_casemanager($no_ipd)
	{
		return $this->db->select('soap_pasien_ri.assesment,soap_pasien_ri.tanggal_pemeriksaan,soap_pasien_ri.role ,h.name,h.ttd')
			->from('soap_pasien_ri')
			->join('hmis_users h', 'h.userid = soap_pasien_ri.id_pemeriksa', 'left')
			->where('no_ipd', $no_ipd)
			->order_by('tanggal_pemeriksaan', 'asc')
			->get()->result();
	}

	function get_observasi_harian($no_ipd)
	{
		return $this->db->query("SELECT * FROM lembar_observasi_harian where no_ipd='$no_ipd'")->row();
	}

	public function get_geriatri($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_awal_geriatri WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_dokter_for_konsul_igd($no_ipd)
	{
		return $this->db->query("select id_dokter,dokter,no_ipd from pasien_iri where noregasal = '$no_ipd'");
	}

	function get_pemeriksaan_fisik_iri($no_ipd)
	{
		return $this->db->query(
			"SELECT 
			a.bb,
			a.suhu,
			a.nadi,
			a.frekuensi_nafas,
			a.no_ipd,
			a.id_pemeriksa,
			a.nama_pemeriksa,
			a.tanggal_pemeriksaan,
			a.sitolic,
			a.diatolic,
			a.oksigen,
			a.cvp,
			a.skala_norton,
			a.skala_nyeri,
			a.e_gcs as gcs_e,
			a.m_gcs as gcs_m,
			a.v_gcs as gcs_v,
			b.ttd 
			FROM pemeriksaan_fisik_ri a LEFT JOIN hmis_users b ON a.id_pemeriksa=b.userid where no_ipd='$no_ipd'ORDER BY tanggal_pemeriksaan ASC"
		)->result();
	}

	function get_id_ok($no_ipd)
	{
		return $this->db->query("SELECT * from operasi_header where no_register = '$no_ipd'");
	}

	function get_id_ok2($no_ipd)
	{
		return $this->db->query("SELECT
		* 
	FROM
		operasi_header
		A LEFT JOIN pemeriksaan_operasi b ON A.idoperasi_header = b.idoperasi_header 
	WHERE
		a.no_register = '$no_ipd'")->row();
	}

	function get_kio_resep_iri($no_ipd)
	{
		return $this->db->query("SELECT * FROM kio_resep_iri where no_ipd='$no_ipd' order by tgl_resep desc ");
	}

	function get_dpo_resep_iri($no_ipd)
	{
		return $this->db->query("SELECT * FROM dpo_iri where no_ipd='$no_ipd' order by tgl_dpo desc ");
	}

	function get_ttd_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_register = '$no_ipd'");
	}

	function get_lap_operasi_ri_rj($no_ipd, $noreg)
	{
		return $this->db->query("SELECT * FROM laporan_operasi where no_ipd = '$no_ipd' or no_ipd= '$noreg'");
	}

	function get_laporan_operasi($noipd)
	{
		$this->db->where('no_ipd', $noipd);
		return $this->db->get('laporan_operasi');
	}

	public function get_rekap_tindakan_pasien($no_ipd)
	{
		return $this->db->query("SELECT A
			.id_tindakan,
			b.nmtindakan,
			SUM(a.qtyyanri) AS qty,
			SUM(a.vtot) AS total
		FROM
			pelayanan_iri AS A,
			jenis_tindakan AS b 
		WHERE
			A.no_ipd = '$no_ipd' 
			AND A.id_tindakan = b.idtindakan
		GROUP BY
			a.id_tindakan, b.nmtindakan");
	}

	function get_kio_resume($no_ipd)
	{
		return $this->db->where('no_ipd', $no_ipd)->order_by('id', 'DESC')->limit(1)->get('kio_resep_iri');
	}

	function getdata_dokter($id_dokter)
	{
		return $this->db->query("SELECT 
			a.nipeg,
			c.ttd
		FROM 
			data_dokter AS a,
			dyn_user_dokter AS b,
			hmis_users AS c 
		WHERE 
			b.id_dokter = a.id_dokter 
			AND b.userid = c.userid 
			AND b.id_dokter = '$id_dokter'");
	}

	public function lap_anestesi_grafik_pemantauan($no_ipd,$noregasal)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi_grafik_pemantauan WHERE no_ipd='$no_ipd' or no_ipd='$noregasal' ")->result();
	}
	public function stat_sedasi_grafik_pemantauan($no_ipd)
	{
		return $this->db->query("SELECT * FROM status_sedasi_grafik_pemantauan WHERE no_ipd='$no_ipd'")->result();
	}

	public function get_nilai_hasil_lab($no_lab, $id_tindakan, $no_ipd)
	{
		return $this->db->query("SELECT 
			jenis_hasil,
			hasil_lab
		FROM 	
			hasil_pemeriksaan_lab
		WHERE 
			no_lab = '$no_lab'
			AND id_tindakan = '$id_tindakan'
			AND no_register = '$no_ipd'");
	}

	public function get_id_dok_anes($no_ipd)
	{
		return $this->db->query("select id_dok_anes from pemeriksaan_operasi where no_register = '$no_ipd'");
	}

	function data_pasien_rj_ri($no_medrec)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_medrec'");
	}

	function get_data_konsultasi_rj_ri($no_medrec)
	{
		return $this->db->query("SELECT DISTINCT
		CASE WHEN
		SUBSTRING(uk.no_reg,1,2)='RI' THEN 'RI'
		ELSE 'RJ'
		END as form_konsul,
		uk.tgl_order_konsul,
		uk.no_medrec,
		uk.no_reg,
		dp.nama,
		dp.tgl_lahir,
		AGE(current_date,dp.tgl_lahir) AS umur,
		dp.no_cm,
		dd.nm_dokter AS nama_dokter_penerima,
		poli.nm_poli,
		CASE WHEN
		SUBSTRING(uk.no_reg,1,2)='RI' THEN ruang.nmruang
		ELSE poli_asal.nm_poli
		END as nm_asal_konsul,
		dd2.nm_dokter AS nama_dokter_pengirim,
		uk.kemungkinan,
		uk.bagian_diobati_untuk,
		uk.kelainan,
		uk.pengobatan,
		uk.perhatian_khusus,
		uk.nasehat,
		uk.opsi_konsul,
		hu2.ttd as ttd_pengirim,
		dd2.nipeg as nipeg_pengirim,
		uk.hal_yang_ditemukan,
		uk.kesan,
		uk.anjuran,
		uk.tgl_konsul_kembali,
		uk.pemindahan_pengobatan,
		uk.tgl_jawaban,
		hu.ttd as ttd_penerima,
		dd.nipeg as nipeg_penerima
		FROM
		(
			SELECT 
				kpi.tgl_konsultasi as tgl_order_konsul,
				pi.no_ipd as no_reg,
				pi.no_medrec,
				kpi.id_dokter_penerima as id_dokter,
				kpi.id_poli_tujuan as id_poli_tujuan,
				kpi.ruangan as asal_konsul,
				kpi.id_dokter_pengirim as dokter_asal,
				kpi.kemungkinan as kemungkinan,
				kpi.diobati_untuk as bagian_diobati_untuk,
				kpi.kelainan,
				kpi.pengobatan as pengobatan,
				kpi.perhatian_khusus,
				kpi.nasehat,
				kpi.permintaan_dokter_asal as opsi_konsul,
				CASE
				WHEN kpi.jawaban_konsul_rehab IS NOT NULL THEN
				'<b>' || CAST ( kpi.jawaban_konsul_rehab :: json ->> 'subjective' AS VARCHAR ) || '</b>' || '<br>' || '<b>komunikasi :</b>' || '<br> &nbsp;- <b>Distalgia : </b> ' || CAST (kpi.jawaban_konsul_rehab -> 'komunikasi' ->> 'distagia' AS VARCHAR ) || '<br> &nbsp;- <b>Disatria : </b>' || CAST (kpi.jawaban_konsul_rehab -> 'komunikasi' ->> 'disatria' AS VARCHAR ) || ' <br>' || '<b>Mobilisasi :</b>' || '<br> - <b>Sitting Balance : </b> ' || CAST ( kpi.jawaban_konsul_rehab -> 'mobilisasi' ->> 'sitting_balance' AS VARCHAR ) || '<br> &nbsp;- <b>Standing Balance : </b>' || CAST ( kpi.jawaban_konsul_rehab -> 'mobilisasi' ->> 'standing_balance' AS VARCHAR ) || ' <br>' || '&nbsp;- <b>Gait : </b>' || CAST ( kpi.jawaban_konsul_rehab -> 'mobilisasi' ->> 'gait' AS VARCHAR ) || ' <br>' || '<b>Upper Extremity :</b> <br>' || '&nbsp;- <b>Dextra</b> : ' || CAST (kpi.jawaban_konsul_rehab -> 'question1' -> 'upper_extremity' ->> 'dextra' AS VARCHAR ) || '<br> &nbsp;- <b>Sinistra : </b>' || CAST ( kpi.jawaban_konsul_rehab -> 'question1' -> 'upper_extremity' ->> 'sinistra' AS VARCHAR ) || ' <br>' || '<b>Lower Extremity :</b> <br>' || '&nbsp;- <b>Dextra</b> : ' || CAST ( kpi.jawaban_konsul_rehab -> 'question1' -> 'lower_extremity' ->> 'dextra' AS VARCHAR ) || '<br> &nbsp;- <b>Sinistra : </b>' || CAST ( kpi.jawaban_konsul_rehab -> 'question1' -> 'lower_extremity' ->> 'sinistra' AS VARCHAR ) || ' <br>' || '<b>UMN Sign :</b> ' || CAST ( kpi.jawaban_konsul_rehab -> 'umn_signn' ->> 'umn_sign' AS VARCHAR ) || '<br>' || '<b>Ulkus :</b> ' || CAST ( kpi.jawaban_konsul_rehab -> 'umn_signn' ->> 'ulkus' AS VARCHAR ) || '<br>' || '<b>Kontraktur :</b> ' || CAST ( kpi.jawaban_konsul_rehab -> 'umn_signn' ->> 'kontraktur' AS VARCHAR ) ELSE kpi.hal_yang_ditemukan 
				END AS hal_yang_ditemukan,
				CASE WHEN 
				kpi.jawaban_konsul_rehab IS NOT NULL THEN
				'<b>' || CAST ( kpi.jawaban_konsul_rehab :: json ->> 'assesment' AS VARCHAR ) || '</b>' ELSE kpi.kesan 
				END AS kesan,
				CASE WHEN 
				kpi.jawaban_konsul_rehab IS NOT NULL THEN
				'<b>' || CAST ( kpi.jawaban_konsul_rehab :: json ->> 'planning' AS VARCHAR ) || '</b>' ELSE kpi.anjuran 
				END AS anjuran,
				kpi.pengajuan_konsul_kembali as tgl_konsul_kembali,
				kpi.pemindahan_pengobatan,
				kpi.tgl_jawaban
				FROM
				konsultasi_pasien_iri kpi
				LEFT JOIN pasien_iri pi
				ON kpi.no_ipd=pi.no_ipd

			UNION

			SELECT	 
					kd.tanggal_konsul as tgl_order_konsul,
					dui.no_register as no_reg,
					dui.no_medrec,
					CAST(kd.id_dokter_akhir AS INTEGER) as id_dokter,
					kd.id_poli_akhir as id_poli_tujuan,
					kd.id_poli_asal as asal_konsul,
					CAST(kd.id_dokter_asal AS INTEGER) as dokter_asal,
					kd.kemungkinan_sangkaan as kemungkinan,
					kd.bagian as bagian_diobati_untuk,
					kd.kelainan,
					kd.pengobatan_untuk as pengobatan,
					kd.perhatian_khusus,
					kd.nasehat,
					kd.opsi_konsul,
					CASE WHEN
					kd.id_poli_akhir='BK00' THEN kd.jawaban_konsul_rehab::json->>'subjective' 
					ELSE kd.detail_penyakit_jawaban
					END as hal_yang_ditemukan,
					CASE WHEN
					kd.id_poli_akhir='BK00' THEN kd.jawaban_konsul_rehab::json->>'assesment' 
					ELSE kd.kesan_jawaban
					END as kesan,
					CASE WHEN
					kd.id_poli_akhir='BK00' THEN kd.jawaban_konsul_rehab::json->>'planning' 
					ELSE kd.anjuran_jawaban
					END as anjuran,
					kd.pengajuan_kembali_jawaban as tgl_konsul_kembali,
					CAST(kd.pemindahan_pengobatan_jawaban AS CHAR) as pemindahan_pengobatan,
					NULL as tgl_jawaban
					FROM
					konsul_dokter kd
					LEFT JOIN daftar_ulang_irj dui
					ON kd.no_register=dui.no_register
		) as uk


		JOIN data_pasien dp ON dp.no_medrec=uk.no_medrec
		LEFT JOIN data_dokter dd ON uk.id_dokter=dd.id_dokter
		LEFT JOIN poliklinik poli ON SUBSTRING(uk.id_poli_tujuan,1,4)=poli.id_poli
		LEFT JOIN ruang ON uk.asal_konsul=ruang.idrg
		LEFT JOIN poliklinik poli_asal ON uk.asal_konsul=poli_asal.id_poli
		LEFT JOIN data_dokter dd2 ON uk.dokter_asal=dd2.id_dokter
		LEFT JOIN dyn_user_dokter dud2 ON uk.dokter_asal=dud2.id_dokter
		LEFT JOIN hmis_users hu2 ON dud2.userid=hu2.userid
		LEFT JOIN dyn_user_dokter dud ON uk.id_dokter=dud.id_dokter
		LEFT JOIN hmis_users hu ON dud.userid=hu.userid
		WHERE uk.no_medrec='$no_medrec'

		ORDER BY uk.tgl_order_konsul DESC
		");
	}

	function get_cppt_ri_rj($no_medrec)
	{
		return $this->db->query("SELECT 
		CASE WHEN
		SUBSTRING(cij.no_reg,1,2)='RI' THEN 'RI'
		ELSE 'RJ'
		END as form_cppt,
		cij.no_medrec,
		cij.no_reg,
		CASE WHEN
		SUBSTRING(cij.no_reg,1,2)='RI' THEN (SELECT kode_rm FROM kode_document WHERE kode_akses='cppt_iri' LIMIT 1) 
		ELSE (SELECT kode_rm FROM kode_document WHERE kode_akses='cppt' LIMIT 1) 
		END as kode_document,
		CASE WHEN
		SUBSTRING(cij.no_reg,1,2)='RI' THEN 'CATATAN PERKEMBANGAN PASIEN TERINTEGRASI'
		ELSE 'CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN'
		END as form_title,
		cij.tanggal_pemeriksaan,
		cij.json_val
		FROM
		(
			SELECT 
				pi.no_ipd as no_reg,
				pi.no_medrec,
				spri.tanggal_pemeriksaan,
				jsonb_build_object(
				'tangan_kiri_otot',spri.tangan_kiri_otot,
				'tangan_kanan_otot',spri.tangan_kanan_otot,
				'kaki_kiri_otot',spri.kaki_kiri_otot,
				'kaki_kanan_otot',spri.kaki_kanan_otot,
				'role',spri.role,
				'assesment_adime',spri.assesment_adime,
				'subjective',spri.subjective,
				'diagnosa_adime',spri.diagnosa_adime,
				'objective',spri.objective,
				'intervensi_adime',spri.intervensi_adime,
				'assesment',spri.assesment,
				'monitoring_adime',spri.monitoring_adime,
				'plan',spri.plan,
				'evaluasi_adime',spri.evaluasi_adime,
				'ttd',hu1.ttd,
				'nama_pemeriksa',spri.nama_pemeriksa,
				'konsul_dokter',jsonb_build_array(((spri.konsul_dokter->0)::jsonb)||(jsonb_build_object('ttd_konsul',(SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where id_dokter = CAST(SPLIT_PART(spri.konsul_dokter::json->0->>'konsultasi_dokter','-',2) AS INTEGER))))),
				'instruksi',spri.instruksi,
				'tgl_acc_pjp',spri.tgl_acc_pjp,
				'ttd_pjp',hu2.ttd,
				'nama_pjp',spri.nama_pjp
				) as json_val
				FROM
				soap_pasien_ri spri
				LEFT JOIN pasien_iri pi ON spri.no_ipd=pi.no_ipd
				LEFT JOIN hmis_users hu1 ON spri.id_pemeriksa=hu1.userid
				LEFT JOIN hmis_users hu2 ON spri.id_pjp=hu2.userid		

			UNION

			SELECT	 
				dui.no_register as no_reg,
				dui.no_medrec,
				CAST(sprj.tgl_input AS TIMESTAMP) as tanggal_pemeriksaan,
				jsonb_build_object(
				'waktu_masuk_poli',dui.waktu_masuk_poli,
				'subjective_perawat',sprj.subjective_perawat,
				'objective_perawat',sprj.objective_perawat,
				'assesment_perawat',sprj.assesment_perawat,
				'plan_perawat',sprj.plan_perawat,
				'ttd_perawat',hup.ttd,
				'nm_perawat',hup.name,
				'waktu_masuk_dokter',dui.waktu_masuk_dokter,
				'subjective_dokter',sprj.subjective_dokter,
				'objective_dokter',sprj.objective_dokter,
				'assesment_dokter',sprj.assesment_dokter,
				'plan_dokter',sprj.plan_dokter,
				'ttd_dokter',hud.ttd,
				'nama_dokter',dd.nm_dokter,
				'sip_dokter',dd.nipeg
				) as json_val
				FROM
				soap_pasien_rj sprj
				LEFT JOIN daftar_ulang_irj dui ON sprj.no_register=dui.no_register
				LEFT JOIN pemeriksaan_fisik pf ON pf.no_register=sprj.no_register
				LEFT JOIN hmis_users hup on hup.userid = CAST(pf.id_perawat AS INTEGER)
				LEFT JOIN dyn_user_dokter dud ON dud.id_dokter=dui.id_dokter
				LEFT JOIN hmis_users hud ON hud.userid=dud.userid
				LEFT JOIN data_dokter dd ON dd.id_dokter=dui.id_dokter
		) as cij

		WHERE cij.no_medrec='$no_medrec' and cij.tanggal_pemeriksaan is not null

		ORDER BY cij.tanggal_pemeriksaan DESC
		");
	}

	public function get_asesmen_ulang_terminal_keluarga($no_ipd)
	{
		return $this->db->query("SELECT * FROM asesmen_ulang_terminal_keluarga WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_cuti_perawatan($no_ipd)
	{
		return $this->db->query("SELECT * FROM cuti_perawatan WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_nihss($no_ipd)
	{
		return $this->db->query("SELECT * FROM nihss WHERE no_ipd='$no_ipd'")->row();
	}

	public function get_suket($no_ipd)
	{
		return $this->db->query("SELECT * FROM suket_sakit WHERE no_register='$no_ipd'")->row();
	}

	public function get_pernyataan_cara_bayar_umum($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_cara_bayar_umum WHERE no_register='$no_ipd'")->row();
	}

	public function get_pernyataan_titip($no_ipd)
	{
		return $this->db->query("SELECT * FROM pernyataan_titip WHERE no_register='$no_ipd'")->row();
	}

	function get_keperawatan_geriatri($no_ipd) {
		return $this->db->query("SELECT * FROM keperawatan_geriatri WHERE no_register = '$no_ipd'")->row();
	}

	function get_formulir_disfagia($no_ipd,$noreg) {
		return $this->db->query("SELECT * FROM formulir_disfagia WHERE no_register = '$no_ipd' or no_register = '$noreg'")->row();
	}

	function get_patologi_klinik($no_ipd) {
		return $this->db->query("SELECT * FROM patologi_klinik WHERE no_register = '$no_ipd'")->row();
	}

	function get_data_rasal($noreg)
	{
		return $this->db->query("SELECT * FROM rasal where no_register='$noreg'");
	}

	function get_data_raslan($noreg)
	{
		return $this->db->query("SELECT * FROM raslan where no_register='$noreg'");
	}

	function get_edukasi_penolakan_rencana_asuhan($noreg)
		{
			return $this->db->query("SELECT *
			FROM edukasi_penolakan_rencana_asuhan 
				WHERE no_register = '$noreg'");
		}

	public function get_diagnosa_for_mpp($no_ipd)
	{
		$data = $this->db->query("
		select diagnosa,id_diagnosa,klasifikasi_diagnos from diagnosa_iri where no_register = '$no_ipd' order by id_diagnosa_pasien asc
		");
		return $data;
	}

	public function get_nihss_for_medik($no_ipd)
	{
		$data = $this->db->query("
		select tanggal_pemeriksaan,userid,formjson_dewasa from assesment_medis_iri where no_ipd = '$no_ipd'
		");
		return $data;
	}

	function get_list_empty_sep_pasien($date) {
		if($date == '') {
			return $this->db->query("SELECT 
				a.tgl_masuk,
				a.tgl_keluar,
				d.nmruang,
				a.no_medrec,
				c.no_cm,
				a.no_ipd,
				c.nama,
				c.sex,
				a.dokter,
				a.no_sep
			FROM
				pasien_iri AS A 
				LEFT JOIN ruang_iri AS b ON A.no_ipd = b.no_ipd
				INNER JOIN data_pasien AS C ON A.no_medrec = C.no_medrec
				LEFT JOIN ruang AS d ON A.idrg = d.idrg
			WHERE
				A.tgl_keluar IS NULL 
				AND ( b.tglkeluarrg IS NULL OR TO_CHAR( b.tglkeluarrg, 'YYYY-MM-dd' ) = '' ) 
				AND A.mutasi IS NULL 
				AND ( A.no_sep IS NULL OR A.no_sep = '' ) 
				AND a.carabayar = 'BPJS'
			ORDER BY
				A.no_ipd ASC");
		} else {
			return $this->db->query("SELECT 
				a.tgl_masuk,
				a.tgl_keluar,
				d.nmruang,
				a.no_medrec,
				c.no_cm,
				a.no_ipd,
				c.nama,
				c.sex,
				a.dokter,
				a.no_sep
			FROM
				pasien_iri AS A 
				INNER JOIN data_pasien AS C ON A.no_medrec = C.no_medrec
				LEFT JOIN ruang AS d ON A.idrg = d.idrg
			WHERE
				a.tgl_keluar = '$date'
				AND ( A.no_sep IS NULL OR A.no_sep = '' ) 
				AND a.carabayar = 'BPJS'
			ORDER BY
				A.no_ipd ASC");
		}
	}

	function update_sep($no_register, $no_sep) {
		$this->db->query("UPDATE pasien_iri SET no_sep = '$no_sep' WHERE no_ipd = '$no_register'");
		$this->db->query("UPDATE bpjs_sep SET no_sep = '$no_sep' WHERE no_register = '$no_register'");
		return true;
	}

	public function get_pengkajian_keperawatan_general($no_ipd)
	{
		return $this->db->query("SELECT * from assesment_keperawatan_iri where no_ipd = '$no_ipd'");
	}

	public function get_pengkajian_awal_ranap($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_medis_iri where no_ipd = '$no_ipd'");
	}

	public function get_pengkajian_dekubitus($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_decubitus where no_ipd = '$no_ipd'");
	}

	public function get_pengkajian_pasien_kecanduan($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_medis_kecanduan where no_ipd = '$no_ipd'");
	}

	public function get_pengkajian_anestesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_pra_anastesi_sedasi where no_ipd = '$no_ipd'");
	}

	public function get_pengkajian_resiko_infeksi($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_resiko_infeksi where no_ipd = '$no_ipd'");
	}

	public function get_pengantar_rawat_inap($no_ipd)
	{
		return $this->db->query("SELECT * from pengantar_rawat_inap where no_register = '$no_ipd'");
	}

	public function get_dicharge_planning_kep($no_ipd)
	{
		return $this->db->query("SELECT * from dischard_planing where no_ipd = '$no_ipd'");
	}

	public function get_cek_keselamatan_ok($no_ipd)
	{
		return $this->db->query("SELECT * from checklist_keselamatan_pasien_operasi where no_ipd = '$no_ipd'");
	}

	public function get_catkep_peri_operatif($no_ipd)
	{
		return $this->db->query("SELECT * from keperawatan_peri_operaktif where no_ipd = '$no_ipd'");
	}

	public function get_cat_pemindahan_ruangan($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_pemindahan_pasien where no_ipd = '$no_ipd'");
	}

	public function get_catatan_perawat($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_perawat where no_ipd = '$no_ipd'");
	}

	public function get_catatan_anestesi_pemulihan($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_kamar_pemulihan where no_ipd = '$no_ipd'");
	}

	public function get_grafik_tanda_vital($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_grafik_vital where no_ipd = '$no_ipd'");
	}

	public function get_lembar_observasi_harian($no_ipd)
	{
		return $this->db->query("SELECT * from lembar_observasi_harian where no_ipd = '$no_ipd'");
	}

	public function get_kontrol_intensive($no_ipd)
	{
		return $this->db->query("SELECT * from kontrol_intensive where no_ipd = '$no_ipd'");
	}

	public function get_lembar_ppi($no_ipd)
	{
		return $this->db->query("SELECT * from penerapan_pencegahan_infeksi where no_ipd = '$no_ipd'");
	}

	public function get_pemantauan_pemberian_cairan_new($no_ipd)
	{
		return $this->db->query("SELECT * from pemantauan_pemberian_cairan where no_ipd = '$no_ipd'");
	}

	public function get_rekonsiliasi_obat_new($no_ipd)
	{
		return $this->db->query("SELECT * from rekonsiliasi_obat where no_ipd = '$no_ipd'");
	}

	public function get_rencana_tindakan_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * from rencana_tindakan_keperawatan where no_ipd = '$no_ipd'");
	}

	public function get_daftar_pemberian_terapi($no_ipd)
	{
		return $this->db->query("SELECT * from daftar_pemberian_terapi where no_ipd = '$no_ipd'");
	}

	public function get_lap_pembedahan_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * from laporan_anestesi_lokal where no_ipd = '$no_ipd'");
	}

	public function get_lap_pendamping_anestesi($no_ipd)
	{
		return $this->db->query("SELECT * from laporan_anestesi_lokal where no_ipd = '$no_ipd'");
	}

	public function get_laporan_pembedahan($no_ipd)
	{
		return $this->db->query("SELECT * from laporan_pembedahan where no_register = '$no_ipd'");
	}

	public function get_lembar_konsul($no_ipd)
	{
		return $this->db->query("SELECT
				*,
				(select nm_dokter from data_dokter where lembar_konsul_ri.dokter_konsul = data_dokter.id_dokter) as dokter_konsulen,
				(select nm_dokter from data_dokter where lembar_konsul_ri.dokter_dpjp = data_dokter.id_dokter) as dokter
			FROM
				lembar_konsul_ri 
			WHERE
				no_ipd = '$no_ipd' order by id desc");
	}

	public function get_lembar_intruksi($no_ipd)
	{
		return $this->db->query("SELECT * from lembar_intruksi where no_ipd = '$no_ipd'");
	}

	public function get_patologi_anatomi($no_ipd)
	{
		return $this->db->query("SELECT * from patologi_anatomi where no_ipd = '$no_ipd'");
	}

	public function get_pengajuan_pembedahan($no_ipd)
	{
		return $this->db->query("SELECT * from pengajuan_pembedahan where no_ipd = '$no_ipd'");
	}

	public function get_askep_general($no_ipd)
	{
		return $this->db->query("SELECT * from asuhan_keperawatan_general where no_ipd = '$no_ipd'");
	}

	public function get_persiapan_perawatan_dirumah($no_ipd)
	{
		return $this->db->query("SELECT * from perawatan_dirumah where no_ipd = '$no_ipd'");
	}

	public function get_cat_khusus_paliatif($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_paliatif where no_ipd = '$no_ipd'");
	}

	public function get_pramedi_pasca_operasi($no_ipd)
	{
		return $this->db->query("SELECT * from premedi_pasca_bedah where no_ipd = '$no_ipd'");
	}

	public function get_status_sedasi_new($no_ipd)
	{
		return $this->db->query("SELECT * from status_sedasi_ri where no_ipd = '$no_ipd'");
	}

	public function get_penolakan_tindakan_medis($no_ipd)
	{
		return $this->db->query("SELECT * from penolakan_tindakan_medik where no_register = '$no_ipd'");
	}

	public function get_persetujuan_tindakan_medis($no_ipd)
	{
		return $this->db->query("SELECT * from persetujuan_tindakan_medik where no_register = '$no_ipd'");
	}

	
	public function get_second_opinion($no_ipd)
	{
		return $this->db->query("SELECT * from second_options where no_ipd = '$no_ipd'");
	}

	public function get_permintaan_privasi($no_ipd)
	{
		return $this->db->query("SELECT * from permintaan_privasi where no_ipd = '$no_ipd'");
	}

	public function get_pernyataan_rad_kontras($no_ipd)
	{
		return $this->db->query("SELECT * from pernyataan_radkontras where no_ipd = '$no_ipd'");
	}

	public function get_pernyataan_restrain_mekanik($no_ipd)
	{
		return $this->db->query("SELECT * from pernyataan_resistrain where no_ipd = '$no_ipd'");
	}

	public function get_pernyataan_anestesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * from pernyataan_anastesi_sedasi where no_ipd = '$no_ipd'");
	}

	public function get_pernyataan_tindakan_hemodialisis($no_ipd)
	{
		return $this->db->query("SELECT * from tindakan_hemodialisa where no_ipd = '$no_ipd'");
	}

	public function get_pernyataan_transfusi_darah($no_ipd)
	{
		return $this->db->query("SELECT * from persetujuan_transfusi_darah where no_ipd = '$no_ipd'");
	}
	function get_permintaan_transfusi_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM permintaan_transfusi_darah where no_register='$no_ipd'");
	}
	function get_pemakaian_ventilator($no_ipd)
	{
		return $this->db->query("SELECT * FROM pemakaian_ventilator where no_ipd='$no_ipd'");
	}

	public function get_persetujuan_izin_operasi($no_ipd)
	{
		return $this->db->query("SELECT * from persetujuan_operasi where no_ipd = '$no_ipd'");
	}

	public function get_suket_kelahiran($no_ipd)
	{
		return $this->db->query("SELECT * from surat_kelahiran where no_ipd = '$no_ipd'");
	}

	public function get_surat_penolakan_resusitasi($no_ipd)
	{
		return $this->db->query("SELECT * from pernyataan_resusitasi where no_ipd = '$no_ipd'");
	}

	public function get_pengobatan_iodiumdoc($no_ipd)
	{
		return $this->db->query("SELECT * from lodium_radioaktif where no_ipd = '$no_ipd'");
	}

	public function get_edukasi_pemberian_darah($no_ipd)
	{
		return $this->db->query("SELECT * from catatan_pemberian_darah where no_ipd = '$no_ipd'");
	}

	public function get_edukasi_anestesi_sedasi($no_ipd)
	{
		return $this->db->query("SELECT * from edukasi_anastesi_sedasi where no_ipd = '$no_ipd'");
	}

	public function get_leaflet_pasien($no_ipd)
	{
		return $this->db->query("SELECT * from tanda_terima_leaflet where no_ipd = '$no_ipd'");
	}

	public function get_surat_pernyataan_pulang($no_ipd)
	{
		return $this->db->query("SELECT * from paps where no_ipd = '$no_ipd'");
	}

	public function get_ringkasan_masuk_keluar_pasien($no_ipd)
	{
		return $this->db->query("SELECT * from ringkasan_masuk_keluar_ri where no_ipd = '$no_ipd'");
	}

	public function get_resume_pasien_pulang_keperawatan($no_ipd)
	{
		return $this->db->query("SELECT * from resume_keperawatan where no_ipd = '$no_ipd'");
	}

	public function get_resume_pasien_pulang($no_ipd)
	{
		return $this->db->query("SELECT *,(select carabayar from pasien_iri where pasien_iri.no_ipd = resume_pulang_iri.no_ipd) from resume_pulang_iri where no_ipd = '$no_ipd'");
	}

	public function get_risiko_jatuh_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_resiko_jatuh_dewasa where no_ipd = '$no_ipd'");
	}
	
	public function get_risiko_jatuh_geriatri($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_resiko_geriatri where no_ipd = '$no_ipd'");
	}

	public function get_data_bayi_lahir($no_ipd)
	{
		return $this->db->query("SELECT * from bayi_baru_lahir where no_ipd = '$no_ipd'");
	}
	public function get_identifikasi_bayi($no_ipd)
	{
		return $this->db->query("SELECT * from identifikasi_bayi where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_jatuh_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_jatuh_neonatus where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_kep_perinatologi($no_ipd)
	{
		return $this->db->query("SELECT * from keperawatan_perina where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_kep_anak($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_keperawatan_anak where no_ipd = '$no_ipd'");
	}
	public function get_resiko_jatuh_anak($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_resiko_jatuh_anak where no_ipd = '$no_ipd'");
	}
	public function get_medis_ranap_anak($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_medik_anak where no_ipd = '$no_ipd'");
	}
	public function get_medis_ranap_neonatus($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_medik_neonatus where no_ipd = '$no_ipd'");
	}
	public function get_persetujuan_bayi_tabung($no_ipd)
	{
		return $this->db->query("SELECT * from bayi_tabung where no_ipd = '$no_ipd'");
	}
	public function get_serah_terima_bayi($no_ipd)
	{
		return $this->db->query("SELECT * from serah_terima_bayi where no_ipd = '$no_ipd'");
	}
	public function get_askep_obgyn($no_ipd)
	{
		return $this->db->query("SELECT * from asuhan_keperawatan_kebidanan where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_keperawatan_obgyn($no_ipd)
	{
		return $this->db->query("SELECT * from keperawatan_obgyn where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_medis_kb($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_medik_kb where no_ipd = '$no_ipd'");
	}
	public function get_asuhan_keperawatan_hcu($no_ipd)
	{
		return $this->db->query("SELECT * from asuhan_keperawatan_hcu where no_ipd = '$no_ipd'");
	}
	public function get_pengkajian_kep_hcu($no_ipd)
	{
		return $this->db->query("SELECT * from pengkajian_kep_hcu where no_ipd = '$no_ipd'");
	}
	public function get_hand_over($no_ipd)
	{
		return $this->db->query("SELECT * from hand_over where no_ipd = '$no_ipd'");
	}
	public function get_assesment_ulang_nyeri($no_ipd)
	{
		return $this->db->query("SELECT * from assesment_nyeri where no_ipd = '$no_ipd'");
	}
	function get_pews($no_ipd)
	{
		return $this->db->query("SELECT * FROM pews where no_ipd='$no_ipd'");
	}
	function get_surat_rujukan_new($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_rujukan where no_ipd='$no_ipd'");
	}
	function get_surat_kematian($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_kematian where no_ipd='$no_ipd'");
	}
	function get_persetujuan_penolakan_rujukan($no_ipd)
	{
		return $this->db->query("SELECT * FROM persetujuan_penolakan_rujukan where no_ipd='$no_ipd'");
	}

	function get_ews_dewasa($no_ipd)
	{
		return $this->db->query("SELECT * FROM ews_dewasa where no_ipd='$no_ipd'");
	}

	public function get_dokter_yang_merawat_resume($no_ipd)
	{
		return $this->db->query("SELECT
			a.id_dokter,
			c.name,
			c.ttd 
		FROM
			pasien_iri A,
			dyn_user_dokter b,
			hmis_users C 
		WHERE
			A.id_dokter = b.id_dokter 
			AND b.userid = C.userid 
			AND a.no_ipd = '$no_ipd'");
	}
	function get_monitoring_transfusi_darah($no_ipd)
	{
		return $this->db->query("SELECT * FROM monitoring_transfusi_darah where no_ipd='$no_ipd'");
	}
	function get_formulir_transfer_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM transfer_pasien where no_ipd='$no_ipd'");
	}
	function get_upload_penunjang($no_ipd)
	{
		return $this->db->query("SELECT * FROM upload_pemeriksaan_penunjang where no_register='$no_ipd'");
	}

	public function get_kio_iri($no_ipd)
	{
		return $this->db->query("
		select * from kio_resep_iri where no_ipd = '$no_ipd' order by tgl_resep desc");
	}
	function get_surat_kontrol_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM surat_kontrol where no_ipd='$no_ipd'");
	}
	public function get_dokter_igd($noregasal)
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
				AND a.no_register = '$noregasal'");
		}

		public function get_noregasalnew($ipd)
		{
			return $this->db->query("select noregasal from pasien_iri where no_ipd = '$ipd'");
		}
	function get_resiko_jatuh_new($no_ipd)
	{
		return $this->db->query("SELECT * FROM resiko_jatuh_general where no_register='$no_ipd'");
	}

	function get_monitoring_anatesi($no_ipd)
	{
		return $this->db->query("SELECT * FROM assesment_pra_induksi where no_ipd='$no_ipd'");
	}
	function get_asuhan_gizi_ri($no_ipd)
	{
		return $this->db->query("SELECT * FROM asuhan_gizi where no_register='$no_ipd'");
	}
}


