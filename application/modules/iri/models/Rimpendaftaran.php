<?php
class Rimpendaftaran extends CI_Model
{

	public function select_dokter_like_ver2($value)
	{
		$data = $this->db->query("select *
			from data_dokter as a 
			where a.nm_dokter like '%$value%' and a.nm_dokter is not null and ket like '%Spesialis%'
			order by a.nm_dokter asc

			");
		return $data->result_array();
	}

	public function select_dokter_like($value, $poli)
	{
		$data = $this->db->query("select *
			from data_dokter as a 
			where a.nm_dokter like '%$value%' and a.nm_dokter is not null and ket = '$poli'
			order by a.nm_dokter asc

			");
		return $data->result_array();
	}

	// public function update_verifikasi_plg($data, $value){
	// 	$this->db->where('no_ipd', $value);
	// 	$this->db->update('pasien_iri', $data);
	// }

	public function select_dokter_likewithoutpoli($value)
	{
		$data = $this->db->query("SELECT *
		FROM data_dokter as a
		WHERE a.nm_dokter LIKE '%$value%' AND a.nm_dokter is not null
		ORDER BY a.nm_dokter asc");
		return $data->result_array();
	}

	public function select_pasien_irj_by_no_register_asal_with_diag_utama($no_register_asal)
	{
		$data = $this->db->query("

			select *
			from daftar_ulang_irj as a left join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on c.id_dokter = a.id_dokter
			LEFT JOIN diagnosa_pasien as d on d.no_register = a.no_register
			LEFT JOIN poliklinik as poli on poli.id_poli = a.id_poli
			where a.no_register='$no_register_asal' and d.klasifikasi_diagnos = 'utama'
			
			");
		return $data->result_array();
	}

	public function select_irna_antrian_by_noreservasi2($value)
	{
		return $this->db->query("select a.*, a.catatan_ringkasan as catt,a.dokter as dokter_rawat, b.*, c.*, c.status as status_nikah, d.*, e.*, f.*, k.*, g.*, h.*,h.diagnosa as code_diagnosa
			from pasien_iri as a inner join ruang as b on a.idrg = b.idrg
			inner join data_pasien as c on a.no_medrec = c.no_medrec
			left join icd1 as d on a.diagmasuk = d.id_icd
			left join daftar_ulang_irj as e on a.noregasal = e.no_register
			left join poliklinik as f on e.id_poli = f.id_poli
			left join data_dokter as g on a.id_dokter= g.id_dokter
			left join irna_antrian as h on a.noregasal = h.no_register_asal
			LEFT JOIN kontraktor as k on a.id_kontraktor = k.id_kontraktor
			where a.no_ipd='$value'");
	}

	public function get_pasien_iri_exist($no_cm)
	{
		return $data = $this->db->query("Select count(*) as exist from pasien_iri a, data_pasien b
			where a.no_medrec=b.no_medrec
			and a.tgl_keluar is null 
			and a.no_medrec=$no_cm");
	}

	public function get_irna_antrian_exist($no_reg)
	{
		return $data = $this->db->query("Select count(*) as exist from irna_antrian a, data_pasien b
			where a.no_medrec=b.no_medrec
			and a.no_register='$no_reg'");
	}

	public function select_pasien_irj_by_no_register_asal($no_register_asal)
	{
		$data = $this->db->query("
			Select *
			from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on c.id_dokter = a.id_dokter
			left join data_ppk as d on a.asal_rujukan = d.kd_ppk
			LEFT JOIN poliklinik as poli on poli.id_poli = a.id_poli
			where a.no_register='$no_register_asal'
			");
		return $data->result_array();
	}

	public function get_all_ppk()
	{
		$data = $this->db->query("
			select *
			from data_ppk
			order by nm_ppk asc
			");
		return $data->result_array();
	}

	public function get_all_kontraktor()
	{
		$data = $this->db->query("
			select *
			from kontraktor
			where nmkontraktor is not null or nmkontraktor <> ''
			order by nmkontraktor asc
			");
		return $data->result_array();
	}

	public function get_all_smf()
	{
		$data = $this->db->query("select *
			from cara_berkunjung as a 
			order by cara_kunj asc
			");
		return $data->result_array();
	}

	//upgrade price for VK
	public function update_tindakan($kelas, $idrg, $no_ipd)
	{
		$data = $this->db->query("UPDATE pelayanan_iri a
			SET a.tumuminap=(select total_tarif from tarif_tindakan where kelas='$kelas' and id_tindakan=a.id_tindakan), 
			a.kelas='$kelas', 
			a.vtot=(select total_tarif from tarif_tindakan where kelas='$kelas' and id_tindakan=a.id_tindakan)*a.qtyyanri,
			a.tarifalkes=(select tarif_alkes from tarif_tindakan where kelas='$kelas' and id_tindakan=a.id_tindakan)
			WHERE a.no_ipd='$no_ipd' and a.idrg='$idrg'
			");
	}

	public function update_ruangan($kelas, $idrg, $no_ipd)
	{
		$data = $this->db->query("update ruang_iri a set a.kelas='$kelas', 
			a.vtot=(select total_tarif from tarif_tindakan where kelas='$kelas' and id_tindakan=concat('1A',a.idrg)),
			a.jasa_perawat=datediff(tglkeluarrg,tglmasukrg)*(select total_tarif from tarif_tindakan where kelas='$kelas' and id_tindakan=concat('1A',a.idrg))*((select persen_jasa from kelas where kelas='$kelas')/100)
			where a.no_ipd='$no_ipd' and a.idrg='$idrg'
			");
	}


	//moris up

	public function select_pasien_ird_by_no_register_asal_with_diag_utama($no_register_asal)
	{
		$data = $this->db->query("
			SELECT
				a.*,b.*,c.*
			FROM
				irddaftar_ulang AS a
			LEFT JOIN data_pasien AS b ON a.no_medrec = b.no_medrec
			LEFT JOIN data_dokter AS c ON a.id_dokter = c.id_dokter
			LEFT JOIN diagnosa_ird as d on a.no_register = d.no_register
			WHERE
				a.no_register = '$no_register_asal'
				and d.klasifikasi_diagnos = 'utama'
			");
		return $data->result_array();
	}

	public function select_pasien_ird_by_no_register_asal($no_register_asal)
	{
		$data = $this->db->query("
			select * 
			from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on a.id_dokter = c.id_dokter
			left join data_ppk as d on a.asal_rujukan = d.kd_ppk
			left join poliklinik as poli on poli.id_poli = a.id_poli
			where CAST(a.no_register AS INTEGER)='$no_register_asal'
			");
		return $data->result_array();
	}

	public function select_irna_antrian_by_noreservasi($value)
	{
		$data = $this->db->query("SELECT a.* ,c.no_medrec, c.no_cm, d.nm_diagnosa
		from irna_antrian as a 
		inner join data_pasien as c on a.no_medrec = c.no_medrec
		left join icd1 as d on a.diagnosa = d.id_icd
		where a.noreservasi='$value'");
		return $data->result_array();
	}

	public function update_pendaftaran_mutasi($data, $value)
	{
		$this->db->where('no_ipd', $value);
		$this->db->update('pasien_iri', $data);

		// $v = $this->db->where('no_ipd', $value)->update('pasien_iri', $data);
		// $ruang_iri = $this->db->where('no_ipd',$value)->update('ruang_iri',['kelas'=>$data['klsiri']]);

	}

	public function update_pendaftaran_mutasi_new($data, $value) {
		$this->db->where('no_ipd', $value);
		$this->db->update('pasien_iri', $data);

		$v = $this->db->where('no_ipd', $value)->update('pasien_iri', $data);
		$ruang_iri = $this->db->where('no_ipd',$value)->update('ruang_iri',['kelas'=>$data['klsiri']]);

	}

	public function update_verifikasi_plg($data, $value)
	{
		$this->db->where('no_ipd', $value);
		$this->db->update('pasien_iri', $data);
	}

	public function update_punya_bayi($data, $value)
	{
		$this->db->where('no_ipd', $value);
		$this->db->update('pasien_iri', $data);
	}

	public function update_ruang_mutasi($data, $value)
	{
		$this->db->where('idrgiri', $value);
		$this->db->update('ruang_iri', $data);
	}

	public function update_ruang_mutasi_iri($data, $value)
	{
		$this->db->where('no_ipd', $value);
		$this->db->update('ruang_iri', $data);
	}
	public function get_bed_sebelum_mutasi($no_register_asal)
	{
		return $this->db->query("select bed from pasien_iri where no_ipd='$no_register_asal'");
	}
	public function update_bed_mutasi_iri($data, $value)
	{
		$this->db->where('bed', $value);
		$this->db->update('bed', $data);
	}

	public function update_data_pasien($data, $value)
	{
		$this->db->where('no_medrec', $value);
		$this->db->update('data_pasien', $data);
	}

	public function update_diagnosa1($id_icd, $no_ipd)
	{
		$data = $this->db->query("
			update pasien_iri
			set diagnosa1 = '$id_icd'
			where no_ipd = '$no_ipd'
			");
	}

	public function update_tgl_keluar($data, $value)
	{
		$data = $this->db->query("
			update pasien_iri
			set
			tgl_keluar = '" . $data['tgl_keluar'] . "',user_plg ='" . $data['user_plg'] . "',jam_keluar ='" . $data['jam_keluar'] . "'
			where no_ipd = '" . $value . "'
		");
	}

	public function update_ruang_iri($data, $value)
	{
		$data = $this->db->query("update ruang_iri
			set tglkeluarrg = '$data'
			where no_ipd = '$value' and tglkeluarrg is null
			");
		//$this->db->where('no_ipd', $value);
		//$this->db->update('ruang_iri', $data);
	}
	//moris up


	public function select_pasien_iri()
	{
		$data = $this->db->query("select * from pasien_iri");
		return $data->result_array();
	}

	public function select_pasien_iri_by_no_register_asal($no_register_asal)
	{
		$data = $this->db->query("select * from pasien_iri where no_ipd='$no_register_asal'");
		return $data->result_array();
	}

	public function select_ruang_like($value)
	{
		$data = $this->db->query("select * from ruang where idrg like '%$value%'");
		return $data->result_array();
	}

	public function insert_pendaftaran($data)
	{
		return $this->db->insert('pasien_iri', $data);
	}
	public function insert_ruang_iri($data)
	{
		$this->db->insert('ruang_iri', $data);
	}
	public function update_irna_antrian($data, $value)
	{
		$this->db->where('no_register_asal', $value);
		return $this->db->update('irna_antrian', $data);
	}

	public function update_irna_antrian_bayi($data, $value)
	{
		$this->db->where('noregasal', $value);
		return $this->db->update('pasien_iri', $data);
	}

	public function select_ruang_iri()
	{
		$data = $this->db->query("select * from ruang_iri");
		return $data->result_array();
	}

	public function select_ruang_iri_new()
	{
		return $this->db->query("SELECT 
			idrgiri 
		FROM ruang_iri ORDER BY idrgiri DESC LIMIT 1");
	}

	function insert_general_consent($data)
	{
		$this->db->insert('general_consent_iri', $data);
		return 1;
	}

	function get_general_consent($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('general_consent_iri');
	}

	function get_general_consent_noregasal($noregasal)
	{
		$this->db->where('no_register_lama', $noregasal);
		return $this->db->get('general_consent_iri');
	}

	function get_general_consent_noregasal_bayi($noregasal, $medrec)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_register_lama = '$noregasal'  and no_cm = '$medrec' ");
	}

	function update_general_consent($data, $noreg)
	{
		$this->db->where('no_register', $noreg);
		$this->db->update('general_consent_iri', $data);
		return 2;
	}

	function get_pasien_iri_by_noregasal($noregasal)
	{
		return $this->db->query("SELECT * FROM pasien_iri WHERE noregasal='$noregasal'");
	}

	function get_pasien_iri_by_noregasal_bayi($noregasal, $medrec)
	{
		return $this->db->query("SELECT * FROM pasien_iri WHERE noregasal='$noregasal' and no_medrec = $medrec");
	}

	function get_suratpersetujuaniri_by_noreg($noreg, $medrec)
	{
		return $this->db->query("SELECT formjson FROM surat_persetujuan_iri WHERE no_register='$noreg' and no_cm = '$medrec'");
	}

	function get_suratpersetujuaniri_by_noregasal($noregasal)
	{
		$this->db->where('no_register_lama', $noregasal);
		return $this->db->get('surat_persetujuan_iri');
	}

	function get_suratpersetujuaniri_by_noregasal_bayi($noregasal, $medrec)
	{
		return $this->db->query("SELECT * FROM surat_persetujuan_iri WHERE no_register_lama = '$noregasal'  and no_cm = '$medrec' ");
	}

	function insert_surat_persetujuan($data)
	{
		return $this->db->insert('surat_persetujuan_iri', $data);
	}

	function update_surat_persetujuan_iri($data, $noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('surat_persetujuan_iri', $data);
	}

	function update_pasien_iri_vtot_obat($vtot_akhir, $no_ipd)
	{
		$this->db->query("update pasien_iri set vtot_obat = vtot_obat::integer+$vtot_akhir where no_ipd = '$no_ipd'");
	}

	function update_pasien_iri($data, $no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
		return true;
	}

	function update_pasien_iri_vtot($vtot_akhir, $no_ipd)
	{
		return $this->db->query("update pasien_iri set vtot = vtot+$vtot_akhir where no_ipd = '$no_ipd'");
	}

	function get_diagnosa_pasien($noreglama)
	{
		$this->db->where('no_register', $noreglama);
		$this->db->where('klasifikasi_diagnos', 'utama');
		return $this->db->get('diagnosa_pasien');
	}

	function get_data_pasien($no_ipd)
	{
		return $this->db->query("SELECT * FROM pasien_iri a, data_pasien b WHERE a.no_medrec = b.no_medrec and no_ipd='$no_ipd'");
	}

	function get_data_pasien_iri($no_ipd)
	{
		$data = $this->db->query("SELECT * FROM pasien_iri a, data_pasien b WHERE a.no_medrec = b.no_medrec and no_ipd='$no_ipd'");

		return $data->result_array();
	}

	function get_histori_ruang_pasien($no_ipd)
	{
		return $this->db->query("SELECT
			idrg,
			idrgiri,
			bed,
			tglkeluarrg,
			tglmasukrg,
			( SELECT nmruang FROM ruang WHERE ruang_iri.idrg = ruang.idrg LIMIT 1) 
		FROM
			ruang_iri 
		WHERE
			no_ipd = '$no_ipd' 
		ORDER BY
			idrgiri DESC");
	}

	function delete_histori_ruang_pasien($no_ipd)
	{
		return $this->db->query("delete from ruang_iri where idrgiri = $no_ipd");
	}

	public function select_pasien_bayi($no_medrec)
	{
		$data = $this->db->query("
			select * 
			from data_pasien 
			where no_medrec='$no_medrec'
			");
		return $data->result_array();
	}
	public function update_pindah_ruang_iri($data, $value)
	{
		$this->db->where('noregasal', $value);
		return $this->db->update('pasien_iri', $data);
	}

	function get_idrgiri_new($no_ipd)
	{
		return $this->db->where('no_ipd', $no_ipd)->order_by('idrgiri', 'desc')->get('ruang_iri');
	}

	function update_ruang_iri_mutasi($no_ipd, $idrgiri, $data)
	{
		$this->db->where('idrgiri', $idrgiri);
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->update('ruang_iri', $data);
	}

	function get_suratpersetujuaniri_by_noipd($noreg)
	{
		return $this->db->query("SELECT * FROM surat_persetujuan_iri WHERE no_ipd='$noreg'");
	}

	function update_surat_persetujuan_iri_by_noipd($data, $noreg)
	{
		$this->db->where('no_ipd', $noreg);
		$this->db->update('surat_persetujuan_iri', $data);
		return true;
	}

	public function get_general_consent_iri($noreg_lama)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_register_lama = '$noreg_lama'");
	}

	public function get_general_consent_bynomedrec($nomedrec)
	{
		return $this->db->query("SELECT * FROM general_consent_iri WHERE no_cm = '$nomedrec'");
	}

	public function get_penanggungjawab_pasien($no_ipd)
	{
		return $this->db->select('nmpjawabri,jenkel,alamatpjawabri,notlppjawab,noidpjawab,hubpjawabri,namaaksespjawabri1,namaaksespjawabri2,namaaksespjawabri3')
			->from('pasien_iri')
			->where('no_ipd', $no_ipd)
			->get()->row();
	}

	public function get_pelayanan_iri($no_ipd)
	{
		return $this->db->where('no_ipd',$no_ipd)->get('pelayanan_iri')->result();
	}

	public function get_pemeriksaan_operasi($no_ipd)
	{
		return $this->db->where('no_register',$no_ipd)->get('pemeriksaan_operasi')->result();
	}

	public function get_pemeriksaan_radiologi($no_ipd)
	{
		return $this->db->where('no_register',$no_ipd)->get('pemeriksaan_radiologi')->result();
	}

	public function get_pemeriksaan_elektromedik($no_ipd)
	{
		return $this->db->where('no_register',$no_ipd)->get('pemeriksaan_elektromedik')->result();
	}

	public function get_pemeriksaan_laboratorium($no_ipd)
	{
		return $this->db->where('no_register',$no_ipd)->get('pemeriksaan_laboratorium')->result();
	}

	public function get_tarif_tindakan_kelas($kelas,$tindakan)
	{
		return $this->db->where('kelas',$kelas)->where('id_tindakan',$tindakan)->get('tarif_tindakan')->row();
	}

	public function update_pelayanan_iri($data)
	{
		return $this->db->query("
		UPDATE pelayanan_iri
		set kelas = '".$data['kelas']."',
		tumuminap = ".$data['tumuminap'].",
		vtot = qtyyanri * ".$data['tumuminap']."
		where id_jns_layanan = ".$data['id_jns_layanan']
		);
	}

	public function update_pemeriksaan_ok($data)
	{
		return $this->db->query("
		UPDATE pemeriksaan_operasi
		set kelas = '".$data['kelas']."',
		biaya_ok = ".$data['biaya_ok'].",
		vtot = qty * ".$data['biaya_ok'].",
		cara_bayar = '".$data['cara_bayar']."'
		where id_pemeriksaan_ok = ".$data['id_pemeriksaan_ok']);
	}

	public function update_pemeriksaan_radiologi($data)
	{
		return $this->db->query("
		UPDATE pemeriksaan_radiologi
		set kelas = '".$data['kelas']."',
		biaya_rad = ".$data['biaya_rad'].",
		vtot = qty * ".$data['biaya_rad']."
		where id_pemeriksaan_rad = ".$data['id_pemeriksaan_rad']
		);
	}

	public function update_pemeriksaan_elektromedik($data)
	{
		return $this->db->query("
		UPDATE pemeriksaan_elektromedik
		set kelas = '".$data['kelas']."',
		biaya_em = ".$data['biaya_em'].",
		vtot = qty * ".$data['biaya_em']."
		where id_pemeriksaan_em = ".$data['id_pemeriksaan_em']
		);
	}

	
	public function update_pemeriksaan_laboratorium($data)
	{
		return $this->db->query("
		UPDATE pemeriksaan_laboratorium
		set kelas = '".$data['kelas']."',
		biaya_lab = ".$data['biaya_lab'].",
		vtot = qty * ".$data['biaya_lab']."
		where id_pemeriksaan_lab = ".$data['id_pemeriksaan_lab']
		);
	}


	public function update_wkt_akhir_admisi($data,$wkt)
	{
		return $this->db->query("
		UPDATE pasien_iri
		set wkt_akhir_admisi = '$wkt'
		where noregasal = '$data'"
		);
	}

	public function get_all_cara_bayar(){
		$data=$this->db->query("
			select * from cara_bayar order by no_urut asc");
		return $data->result_array();
	}

	public function get_data_pasien_for_label($medrec){
		$data=$this->db->query("
			select nama,tgl_lahir,no_cm from data_pasien where no_medrec = '$medrec'");
		return $data->row();
	}
}
