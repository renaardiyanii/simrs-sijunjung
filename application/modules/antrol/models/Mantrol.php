<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantrol extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function get_poliklinik_bpjs_antrol()
	{
		return $this->db->select('nm_poli,poli_bpjs,id_poli')
		->where('poli_bpjs != \'\' and poli_bpjs is not null')
		->get('poliklinik')->result();
	}

	function get_suratkontrol($nomorkartu)
	{
		return $this->db->query("SELECT * FROM bpjs_suratkontrol where no_kartu ='$nomorkartu' and sep is null or sep = '' order by tgl_rencana_kontrol	desc limit 1")->row();
	}
	
	function get_poliklinik_bpjs()
	{
		return $this->db->
		where('poli_bpjs != \'\' and poli_bpjs is not null')
		->get('poliklinik')->result();
	}

	function get_dokter_bpjs($kodepoli)
	{
		return $this->db->query("SELECT dd.nm_dokter,dd.id_dokter,dd.kode_dpjp_bpjs FROM dokter_poli dp join data_dokter dd on 
		dd.id_dokter = dp.id_dokter where dp.id_poli = '$kodepoli' 
		and (dd.kode_dpjp_bpjs != '' and dd.kode_dpjp_bpjs is not null) ")->result();
	}

	function get_data_pasien($nomorkartu)
	{
		return $this->db->select('no_identitas as nik,no_hp as nohp,no_cm as norm')
		->where('no_kartu',$nomorkartu)->get('data_pasien')->row();
	}

	function get_data_pasien_berdasarkan_nik($nik){
		return $this->db->select('no_kartu')
		->where('no_identitas',$nik)->get('data_pasien')->row();
	}

	function get_counter_internal()
	{
		$query = $this->db->query("SELECT nextval('rujukan_internal_counter') as sequence_value");
        $row = $query->row();
        return $row->sequence_value;
	}

	function get_antrian_farmasi($date = null)
	{
		if ($date == null) {
			$date = date('Y-m-d');
		}

		return $this->db->query("
			SELECT
				ROW_NUMBER() OVER (ORDER BY p.tgl_kunjungan ASC, p.no_register ASC) AS noantrian,
				p.no_register, p.no_medrec, p.tgl_kunjungan, p.nama, p.kelas, p.obat, p.idrg, p.bed, p.cara_bayar,
				p.farmasi, p.wkt_telaah_obat, p.no_sep, p.tgl,
				COALESCE(dp.alamat, p.alamat, '') as alamat,
				dp.no_cm,
				(SELECT no_resep
				 FROM resep_pasien
				 WHERE no_register = p.no_register
				 GROUP BY no_resep
				 LIMIT 1) AS jml_resep,
				CASE
					WHEN p.status_antrian_farmasi = 'dipanggil' OR p.status_antrian_farmasi = 'selesai' THEN '1'
					ELSE '0'
				END AS checkin,
				p.waktu_panggil_farmasi as waktu_panggil,
				p.waktu_selesai_farmasi as waktu_masuk_farmasi,
				COALESCE(p.status_antrian_farmasi, 'menunggu') as status,
				('F-' || LPAD(ROW_NUMBER() OVER (ORDER BY p.tgl_kunjungan ASC, p.no_register ASC)::text, 3, '0')) as no_antrian,
				p.nama as nama_pasien,
				p.waktu_panggil_farmasi as waktu_daftar
			FROM
				permintaan_obat p
			LEFT JOIN
				data_pasien dp ON p.no_medrec = dp.no_medrec
			WHERE
				p.obat = '1'
				AND p.tgl_kunjungan = '$date'
			ORDER BY
				p.tgl_kunjungan ASC, p.no_register ASC
		");
	}

	function panggil_antrian_farmasi($no_register, $no_antrian)
	{
		// Update status antrian farmasi menjadi 'dipanggil' dengan waktu panggil
		// Menggunakan kolom khusus antrian farmasi, bukan field 'farmasi' yang existing
		$data = [
			'status_antrian_farmasi' => 'dipanggil',
			'waktu_panggil_farmasi' => date('Y-m-d H:i:s')
		];

		return $this->update_source_table($no_register, $data);
	}

	function selesai_antrian_farmasi($no_register)
	{
		// Update status antrian farmasi menjadi 'selesai' dengan waktu selesai
		$data = [
			'status_antrian_farmasi' => 'selesai',
			'waktu_selesai_farmasi' => date('Y-m-d H:i:s')
		];

		return $this->update_source_table($no_register, $data);
	}

	private function update_source_table($no_register, $data)
	{
		// Tentukan tabel mana yang akan diupdate berdasarkan format no_register
		$prefix = substr($no_register, 0, 3);

		if ($prefix == 'PLF' || $prefix == 'PLL' || $prefix == 'PLR') {
			// Pasien luar (farmasi, lab, radiologi)
			return $this->db->where('no_register', $no_register)
				->update('pasien_luar', $data);
		} else if (substr($no_register, 0, 2) == 'RI') {
			// Pasien rawat inap
			return $this->db->where('no_ipd', $no_register)
				->update('pasien_iri', $data);
		} else {
			// Pasien rawat jalan (RJ prefix atau format lain)
			return $this->db->where('no_register', $no_register)
				->update('daftar_ulang_irj', $data);
		}
	}

	function get_pasien_by_no_cm($norm)
	{
		return $this->db->where('no_cm',$norm)->get('data_pasien')->row();
	}

	function get_bpjs_sep($no_rujukan, $type = 0)
	{
		$where = 'norujukan';
		$addition = null;
		if ($type) {
			$where = 'no_kartu';
			$addition = 'substr(no_register,0,3) = \'RI\'';
		}
		$data = $this->db->where($where, $no_rujukan)->where('no_sep is not null');
		if ($addition) {
			$data->where($addition);
			return $data->get('bpjs_sep');
		}
		return $data->get('bpjs_sep');
	}

	function cek_bpjs_suratkontrol($no_sep_asal)
	{
		return $this->db->where('no_sep_asal', $no_sep_asal)->get('bpjs_suratkontrol');
	}

	function insert_bpjs_surat_kontrol($data)
    {
        return $this->db->insert('bpjs_suratkontrol',$data);
    }

}
