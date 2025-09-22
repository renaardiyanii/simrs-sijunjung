<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmpencarian extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////daftar_ulang
		function get_cara_berkunjung(){
			return $this->db->query("SELECT * FROM cara_berkunjung");
		}
		function get_ppk(){
			return $this->db->query("SELECT * FROM data_ppk ORDER BY nm_ppk");
		}
		function get_kelas(){
			return $this->db->query("SELECT * FROM kelas");
		}
		function get_kesatuan(){
			return $this->db->query("SELECT * FROM tni_kesatuan");
		}
		function get_kesatuan_all(){
			$this->db->FROM('tni_kesatuan');
            $this->db->JOIN('tni_kesatuan2', 'tni_kesatuan.kst_id = tni_kesatuan2.kst_id', 'left');
            $this->db->JOIN('tni_kesatuan3', 'tni_kesatuan2.kst2_id = tni_kesatuan3.kst2_id', 'left');
            $this->db->select('tni_kesatuan.kst_id,tni_kesatuan.kst_nama,tni_kesatuan2.kst2_id,tni_kesatuan2.kst2_nama,tni_kesatuan3.kst3_id,tni_kesatuan3.kst3_nama');
            $query = $this->db->get();
			return $query;
        }

        function printer_tracer($ip_from) {
			$this->db->FROM('printer_send');
            $this->db->JOIN('printer_unit', 'printer_send.id_unit = printer_unit.id', 'left');
            $this->db->where('printer_send.description', '1');     
            $this->db->where('printer_send.from', $ip_from); 
            $query = $this->db->get();
			return $query;
        }

        function get_wilayah(){
			$this->db->FROM('provinsi');
            $this->db->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner');
            $this->db->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner');
            $this->db->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner');
            $query = $this->db->get();
			return $query;
        }
		function get_kesatuan2(){
			return $this->db->query("SELECT * FROM tni_kesatuan2");
		}
		function get_kesatuan3(){
			return $this->db->query("SELECT * FROM tni_kesatuan3");
		}
		function get_pangkat(){
			return $this->db->query("SELECT * FROM tni_pangkat");
		}
		function get_pekerjaan(){
			return $this->db->query("SELECT * FROM data_pekerjaan order by pekerjaan ASC");
		}
		function get_hubungan(){
			return $this->db->query("SELECT * FROM tni_hubungan");
		}
		function get_angkatan(){
			return $this->db->query("SELECT * FROM tni_angkatan");
		}
		function get_poliklinik(){
			return $this->db->query("SELECT id_poli, nm_poli, poli_bpjs FROM poliklinik");
		}
		function get_cara_bayar(){
			return $this->db->query("SELECT * FROM cara_bayar");
		}
		function get_kontraktor(){
			return $this->db->query("SELECT * FROM kontraktor ORDER BY nmkontraktor");
		}
		function get_diagnosa(){
			return $this->db->query("SELECT id_icd, nm_diagnosa FROM icd1 ORDER BY id_icd");
		}
		function get_dokter(){
			return $this->db->query("SELECT id_dokter, nm_dokter FROM data_dokter where deleted='0' ORDER BY nm_dokter");
		}
		function get_data_kecelakaan(){
			$this->db->select('*');
			$this->db->from('kecelakaan_ird');
			$query = $this->db->get();
			return $query;
		}
		function load_kesatuan2($id_kesatuan1){
			$this->db->select('*');
			$this->db->from('tni_kesatuan2');
			$this->db->where('kst_id', $id_kesatuan1);
			$query = $this->db->get();
			return $query;
		}
		function load_kesatuan3($id_kesatuan2){
			$this->db->select('*');
			$this->db->from('tni_kesatuan3');
			$this->db->where('kst2_id', $id_kesatuan2);
			$query = $this->db->get();
			return $query;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////pencarian list antrian pasien per poli by
		function get_pasien_daftar_today($id_poli){
			return $this->db->query("SELECT
								a.no_antrian as antri,
								a.tgl_kunjungan AS tgl,
								b.no_cm AS kode,
								a.no_register AS id,
								b.nama AS nama,
								c.nm_dokter,
								a.cara_bayar AS ket,
								a.kelas_pasien AS kelas,
								a.waktu_masuk_poli as waktu_masuk_poli,
								a.hapusSEP as hapusSEP,
								(
									SELECT
										count(*)
									FROM
										pelayanan_poli
									WHERE
										no_register = a.no_register
									AND bayar = '1'
								) AS unpaid
							FROM
								daftar_ulang_irj AS a,
								data_pasien AS b,
								data_dokter c
							WHERE
								a.id_poli = '$id_poli'
							AND a.no_medrec = b.no_medrec
							and left(a.tgl_kunjungan,10) = left(now(),10)
							AND a.`status` = '0'
							AND a.id_dokter = c.id_dokter
								GROUP BY antri ");
// //SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0'
// 			WHERE
// 									c.kdpangkat = d.pangkat_id
// 								AND c.jenis_pemeriksaan = e.kode_paket
// 								and left(c.tgl_pemeriksaan,10) = left(now(),10)
// 								AND e.poli_paket = '$id_poli'
// 								GROUP BY
// 									kode
		}

		function get_pasien_urikes_today($id_poli){
			return $this->db->query("
								SELECT
									c.idurikes as antri,
									c.tgl_pemeriksaan AS tgl,
									c.nomor_kode AS kode,
									d.pangkat AS id,
									c.nama AS nama,
									c.`status` AS ket,
									c.catatan AS kelas,
									c.kelompok AS unpaid,
									c.tgl_pemeriksaan as waktu_masuk_poli,
									c.tgl_cetak_kw as hapusSEP
								FROM
									urikkes_pasien AS c
								LEFT join 
									tni_pangkat AS d on c.kdpangkat = d.pangkat_id
								LEFT JOIN
									urikkes_master_paket_detail AS e on c.jenis_pemeriksaan = e.kode_paket 
								WHERE
								left(c.tgl_pemeriksaan,10) = left(now(),10)
								AND e.poli_paket = '$id_poli'
								GROUP BY
									c.nomor_kode");
		}

		function get_pasien_daftar_by_nocm($id_poli,$no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and data_pasien.no_medrec='$no_medrec' and daftar_ulang_irj.status='0'");
		}
		function get_pasien_daftar_by_noregister($id_poli,$no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and daftar_ulang_irj.no_register='$no_register' and daftar_ulang_irj.status='0'");
		}
		function get_pasien_daftar_by_date($id_poli,$date){
			return $this->db->query("SELECT
								a.no_antrian as antri,
								a.tgl_kunjungan AS tgl,
								b.no_cm AS kode,
								a.no_register AS id,
								b.nama AS nama,
								c.nm_dokter,
								a.cara_bayar AS ket,
								a.kelas_pasien AS kelas,
								a.waktu_masuk_poli as waktu_masuk_poli,
								a.hapusSEP as hapusSEP,
								(
									SELECT
										count(*)
									FROM
										pelayanan_poli
									WHERE
										no_register = a.no_register
									AND bayar = '1'
								) AS unpaid
							FROM
								daftar_ulang_irj AS a,
								data_pasien AS b,
								data_dokter c
							WHERE
								a.id_poli = '$id_poli'
							AND a.no_medrec = b.no_medrec
							and a.id_dokter = c.id_dokter
							AND LEFT (a.tgl_kunjungan, 10) = '$date'
							AND a.`status` = '0'
							GROUP BY antri");
		}

		function get_pasien_urikes_by_date($id_poli,$date){
			return $this->db->query("
								SELECT
									c.idurikes as antri,
									c.tgl_pemeriksaan AS tgl,
									c.nomor_kode AS kode,
									d.pangkat AS id,
									c.nama AS nama,
									c.`status` AS ket,
									c.catatan AS kelas,
									c.kelompok AS unpaid,
									c.tgl_pemeriksaan as waktu_masuk_poli,
									c.tgl_cetak_kw as hapusSEP
								FROM
									urikkes_pasien AS c
								LEFT join 
									tni_pangkat AS d on c.kdpangkat = d.pangkat_id
								LEFT JOIN
									urikkes_master_paket_detail AS e on c.jenis_pemeriksaan = e.kode_paket 
								WHERE
								left(c.tgl_pemeriksaan,10) = '$date'
								AND e.poli_paket = '$id_poli'
								GROUP BY
									c.nomor_kode");
		}

		function get_nrp(){
			return $this->db->query("select no_nrp, no_cm as no_medrec from data_pasien where no_nrp is not null");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat		
		function get_prop(){
			return $this->db->query("SELECT * FROM provinsi order by nama");
		}
		function get_kotakab($id_prop){
			return $this->db->query("SELECT * FROM kotakabupaten where id_prov='$id_prop' order by nama");
		}
		function get_kecamatan($id_kabupaten){
			return $this->db->query("SELECT * FROM kecamatan where id_kabupaten='$id_kabupaten' order by nama");
		}
		function get_kelurahan($id_kecamatan){
			return $this->db->query("SELECT * FROM kelurahandesa where id_kecamatan='$id_kecamatan' order by nama");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////list_poli
		function get_poli($username){
			return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
										(select count(id_poli) from daftar_ulang_irj 
										where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.status='0' 
										and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10)) as counter
									FROM poliklinik 
									LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
									where dyn_poli_user.userid='$username'
									GROUP BY poliklinik.id_poli");
		}
		function get_nm_poli($id_poli){//judul poli -> header dalam list antrian
			return $this->db->query("SELECT nm_poli FROM poliklinik where id_poli='$id_poli'");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////tarif_tindakan
		function get_tarif_tindakan($keyword,$kelas_pasien){//judul poli -> header dalam list antrian
			return $this->db->query("select * from jenis_tindakan, tarif_tindakan where jenis_tindakan.nmtindakan like '%$keyword%' and jenis_tindakan.idtindakan=tarif_tindakan.idtindakan and tarif_tindakan.kelas='$kelas_pasien' and jenis_tindakan.cito='B'");
		}



			
		function get_list_rawat_jalan(){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
			FROM daftar_ulang_irj, data_pasien 
			where daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
			and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
				");
		}
		
				function get_data_by_register($no_register){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
FROM daftar_ulang_irj, data_pasien 
where daftar_ulang_irj.no_register='$no_register' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
");
	}

		function edit_cara_bayar($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data); 
			return true;
		}


}

?>
