<?php
class Rimdaftar extends CI_Model {

	public function get_irna_antrian_all(){
		$data=$this->db->query(
			"SELECT a.noreservasi,a.no_medrec,a.no_register_asal,a.tglreserv,b.nama,b.no_hp,b.no_cm,a.kelas,a.infeksi,a.prioritas,a.tglrencanamasuk,a.tppri, d.tgl_keluar, (select cara_bayar from daftar_ulang_irj where daftar_ulang_irj.no_register = a.no_register_asal) as cara_bayar
			FROM
				irna_antrian AS a
					INNER JOIN
				data_pasien AS b ON a.no_medrec = b.no_medrec
				LEFT JOIN
				pasien_iri d ON a.no_register_asal=d.no_ipd
			WHERE
				a.batal = 'N' AND a.statusantrian = 'N'
				AND d.tgl_keluar is null
				AND a.bayi = 0
			ORDER BY noreservasi ASC
			");
		return $data->result_array();
	} // AND (c.lokasi != 'Ruang Bersalin' or c.lokasi != 'Anyelir')

	public function get_irna_antrian_vk_all(){
		$data=$this->db->query(
			"SELECT 
					    a.*, b.*, c.*, d.tgl_keluar
					FROM
					    irna_antrian AS a
					        INNER JOIN
					    data_pasien AS b ON a.no_medrec = b.no_medrec
					        INNER JOIN
					    ruang AS c ON a.ruangpilih = c.idrg
					    LEFT JOIN
						pasien_iri d ON a.no_register_asal=d.no_ipd
					WHERE
					    a.batal = 'N' AND a.statusantrian = 'N'
						AND (c.lokasi = 'Ruang Bersalin' or c.lokasi = 'Anyelir')
					    AND d.tgl_keluar is null
					ORDER BY noreservasi ASC
			");
		return $data->result_array();
	}

	public function get_irna_antrian_by_noreg($noregasal){

		return $this->db->query("SELECT a.noreservasi,a.no_medrec,a.no_register_asal,a.tglreserv,b.nama,b.no_hp,a.kelas,a.infeksi,a.prioritas,a.tglrencanamasuk,a.tppri, d.tgl_keluar, (select cara_bayar from daftar_ulang_irj where daftar_ulang_irj.no_register = a.no_register_asal) as cara_bayar
		FROM
			irna_antrian AS a
				INNER JOIN
			data_pasien AS b ON a.no_medrec = b.no_medrec
			LEFT JOIN
			pasien_iri d ON a.no_register_asal=d.no_ipd
		WHERE
			a.batal = 'N' AND a.statusantrian = 'N' and a.no_register_asal = '$noregasal'
			AND d.tgl_keluar is null
		ORDER BY noreservasi ASC ");
	}

	// moris up

	public function select_irna_antrian_all($kode_ruang, $kelas){
		if($kode_ruang=='-' && $kelas!='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where kelas='$kelas' and batal='N' and statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas=='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where ruangpilih='$kode_ruang' and batal='N' and statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas!='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where ruangpilih='$kode_ruang' and kelas='$kelas' and batal='N' and statusantrian='N'");
		}else{
			$data=$this->db->query(
			"select *from irna_antrian
			where batal='N' and statusantrian='N'");
		}
		return $data->result_array();
	}

	public function select_pasien_by_no_medrec($no_register_asal){
		$data=$this->db->query("select * from data_pasien where no_medrec='$no_register_asal'");
		return $data->result_array();
	}

	public function select_pasien_ird_by_no_register_asal($no_register_asal){
		$data=$this->db->query("select * from pasien_ird where no_reg='$no_register_asal'");
		return $data->result_array();
	}
	public function select_ruang_like($value){
		$data=$this->db->query("select * from ruang where idrg like '%$value%' order by idrg asc");
		return $data->result_array();
	}
	public function update_reservasi($noreservasi, $data){
		$this->db->where('noreservasi', $noreservasi);
		$this->db->update('irna_antrian', $data);
	}

	public function get_antrian_by_no_reservasi($noreservasi){
		$data=$this->db->query("select * from irna_antrian where noreservasi = '$noreservasi' ");
		return $data->result_array();
	}

	public function get_noregasal($noreservasi){
		return $this->db->query("select no_register_asal from irna_antrian where noreservasi = '$noreservasi' ");
	}

	public function update_mutasi($no_ipd){
		return $this->db->query("UPDATE pasien_iri SET mutasi=0 WHERE no_ipd = '$no_ipd' ");
	}

	public function get_pasien_terverifikasi() {
		$data=$this->db->query("SELECT DISTINCT
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
		a.ipdibu,
		a.verifikasi_plg,
		EXTRACT(EPOCH FROM c.tgl_lahir-NOW()) as umur
		
	FROM
		pasien_iri AS a
		LEFT JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
		INNER JOIN data_pasien AS c ON a.no_medrec = c.no_medrec
		LEFT JOIN ruang AS d ON a.idrg = d.idrg
		LEFT JOIN kontraktor k ON k.id_kontraktor = a.id_kontraktor 
	WHERE
		a.tgl_keluar IS NULL
		AND a.verifikasi_plg = 1
	ORDER BY
		a.no_ipd ASC
			");
		return $data->result_array();
	}

	public function update_verifikasi_plg_pasien($no_ipd, $data){
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('pasien_iri', $data);
	}

	
}
?>
