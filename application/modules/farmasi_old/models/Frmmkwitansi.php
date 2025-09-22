<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT
			'Pasien Luar' AS no_cm,
			b.no_resep,
			b.tgl_kunjungan AS tgl,
			b.no_register,
			b.no_medrec,
			pasien_luar.nama,
			COUNT ( 1 ) AS banyak,
			b.cara_bayar AS cara_bayar 
		FROM
			resep_pasien b,
			pasien_luar 
		WHERE
			b.no_register = pasien_luar.no_register 
			AND b.cetak_kwitansi IS NULL 
			AND b.no_resep != 0  
		GROUP BY
			no_resep,
			tgl,
			b.no_register,
			b.no_medrec,
			pasien_luar.nama,
			b.cara_bayar UNION
		SELECT
			data_pasien.no_cm AS no_cm,
			b.no_resep,
			b.tgl_kunjungan AS tgl,
			b.no_register,
			b.no_medrec,
			data_pasien.nama,
			COUNT ( 1 ) AS banyak,
			cara_bayar AS cara_bayar 
		FROM
			resep_pasien b,
			data_pasien 
		WHERE
			CAST ( b.no_medrec AS INTEGER ) = data_pasien.no_medrec 
			AND b.cara_bayar in ('UMUM','KERJASAMA')
			AND b.cetak_kwitansi IS NULL 
			AND b.no_resep != 0  
		GROUP BY
			no_resep,
			no_cm,
			tgl,
			b.no_register,
			b.no_medrec,
			data_pasien.nama,
			cara_bayar 
		ORDER BY
			tgl ASC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND b.no_resep != 0 AND (b.no_register='$key' OR b.no_medrec='$key') AND b.cetak_kwitansi IS NULL  GROUP BY no_resep ,tgl,b.no_register, b.no_medrec, pasien_luar.nama 
				UNION
				SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  data_pasien.nama, count(1) AS banyak FROM resep_pasien b, data_pasien WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec  AND  b.no_resep != 0 AND (b.no_register='$key' OR b.no_medrec='$key') AND b.cara_bayar in ('UMUM','KERJASAMA') AND b.cetak_kwitansi IS NULL  GROUP BY no_resep,data_pasien.no_cm,tgl, b.no_register, b.no_medrec, data_pasien.nama 
				ORDER BY tgl ASC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND b.no_resep != 0 AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date' GROUP BY no_resep ,tgl, b.no_register, b.no_medrec, pasien_luar.nama 
				UNION
				SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  data_pasien.nama, count(1) AS banyak FROM resep_pasien b, data_pasien WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec AND b.no_resep != 0 AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date' AND b.cara_bayar in ('UMUM','KERJASAMA') GROUP BY no_resep ,data_pasien.no_cm,tgl, b.no_register, b.no_medrec, data_pasien.nama 
				ORDER BY tgl ASC");
		}
		/////////

		function get_list_kwitansi_rj() {
			$date = date("Y-m-d");
			return $this->db->query("SELECT a.*, b.*, c.nm_poli FROM daftar_ulang_irj AS a, data_pasien AS b, poliklinik AS c WHERE a.no_medrec = b.no_medrec AND a.id_poli = c.id_poli AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'");
		}

		function get_list_kwitansi_by_date_rj($date) {
			return $this->db->query("SELECT a.*, b.*, c.nm_poli FROM daftar_ulang_irj AS a, data_pasien AS b, poliklinik AS c WHERE a.no_medrec = b.no_medrec AND a.id_poli = c.id_poli AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'");
		}

		function get_data_pasien($no_resep){
			// return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.cara_bayar, b.idrg, b.bed, a.no_medrec, a.no_register, data_pasien.nama as nama, data_pasien.sex as sex, data_pasien.goldarah as goldarah, a.tgl_kunjungan as tgl_kunjungan, a.kelas, '-' as nm_dokter FROM resep_pasien a, data_pasien, resep_header b WHERE a.no_resep=b.no_resep AND a.no_medrec=data_pasien.no_medrec AND a.no_resep='$no_resep' GROUP BY a.no_resep
			// UNION 
			// SELECT 'Pasien Luar' as no_cm, c.cara_bayar, c.idrg, c.bed, c.no_medrec, c.no_register, pasien_luar.nama as nama, '-' as sex, '-' as goldarah, c.tgl_kunjungan as tgl_kunjungan, c.kelas, d.nm_dokter FROM resep_pasien c, pasien_luar, resep_header d WHERE c.no_resep=d.no_resep AND c.no_register=pasien_luar.no_register AND c.no_register=pasien_luar.no_register AND c.no_resep='$no_resep' GROUP BY c.no_resep");


			return $this->db->query("SELECT to_char(data_pasien.tgl_lahir , 'DD-MM-YYYY') as tgl_lahir, data_pasien.no_cm as no_cm, a.cara_bayar, b.idrg, b.bed, a.no_medrec, 
			a.no_register, data_pasien.nama as nama, data_pasien.sex 
			as sex,data_pasien.alamat as alamat, data_pasien.goldarah as goldarah, a.tgl_kunjungan 
			as tgl_kunjungan, a.kelas, '-' as nm_dokter 
			FROM resep_pasien a, data_pasien, resep_header b 
			WHERE a.no_resep=b.no_resep AND CAST(a.no_medrec AS INTEGER)=data_pasien.no_medrec 
			AND a.no_resep='$no_resep' and substr(A.no_register,1,2) <> 'PL'
						UNION 
						SELECT pasien_luar.usia, 'Pasien Luar' as no_cm, c.cara_bayar, c.idrg, c.bed, 
						c.no_medrec, c.no_register, pasien_luar.nama as nama, '-' as sex, pasien_luar.alamat as alamat,
						'-' as goldarah, c.tgl_kunjungan as tgl_kunjungan, c.kelas, d.nm_dokter 
						FROM resep_pasien c, pasien_luar, resep_header d WHERE c.no_resep=d.no_resep 
						AND c.no_register=pasien_luar.no_register 
						AND c.no_register=pasien_luar.no_register AND c.no_resep='$no_resep'");
		}

		function get_data_pasien_rj($no_register) {
			return $this->db->query("SELECT a.*, b.*, c.nm_poli, d.nm_dokter FROM daftar_ulang_irj AS a, data_pasien AS b, poliklinik AS c, data_dokter AS d WHERE a.no_medrec = b.no_medrec AND a.id_poli = c.id_poli AND a.id_dokter = d.id_dokter AND a.no_register = '$no_register'");
		}

		function get_data_pasien_by_noreg($no_register){
			// return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.cara_bayar, b.idrg, b.bed, a.no_medrec, a.no_register, data_pasien.nama as nama, data_pasien.sex as sex, data_pasien.goldarah as goldarah, a.tgl_kunjungan as tgl_kunjungan, a.kelas, '-' as nm_dokter FROM resep_pasien a, data_pasien, resep_header b WHERE a.no_resep=b.no_resep AND a.no_medrec=data_pasien.no_medrec AND a.no_resep='$no_resep' GROUP BY a.no_resep
			// UNION 
			// SELECT 'Pasien Luar' as no_cm, c.cara_bayar, c.idrg, c.bed, c.no_medrec, c.no_register, pasien_luar.nama as nama, '-' as sex, '-' as goldarah, c.tgl_kunjungan as tgl_kunjungan, c.kelas, d.nm_dokter FROM resep_pasien c, pasien_luar, resep_header d WHERE c.no_resep=d.no_resep AND c.no_register=pasien_luar.no_register AND c.no_register=pasien_luar.no_register AND c.no_resep='$no_resep' GROUP BY c.no_resep");


			return $this->db->query("SELECT to_char(data_pasien.tgl_lahir , 'DD-MM-YYYY') as tgl_lahir, data_pasien.no_cm as no_cm, a.cara_bayar, b.idrg, b.bed, a.no_medrec, 
			a.no_register, data_pasien.nama as nama, data_pasien.sex 
			as sex,data_pasien.alamat as alamat, data_pasien.goldarah as goldarah, a.tgl_kunjungan 
			as tgl_kunjungan, a.kelas, '-' as nm_dokter 
			FROM resep_pasien a, data_pasien, resep_header b 
			WHERE a.no_resep=b.no_resep AND CAST(a.no_medrec AS INTEGER)=data_pasien.no_medrec 
			AND a.no_register='$no_register' and substr(A.no_register,1,2) <> 'PL'
						UNION 
						SELECT pasien_luar.usia, 'Pasien Luar' as no_cm, c.cara_bayar, c.idrg, c.bed, 
						c.no_medrec, c.no_register, pasien_luar.nama as nama, '-' as sex, pasien_luar.alamat as alamat,
						'-' as goldarah, c.tgl_kunjungan as tgl_kunjungan, c.kelas, d.nm_dokter 
						FROM resep_pasien c, pasien_luar, resep_header d WHERE c.no_resep=d.no_resep 
						AND c.no_register=pasien_luar.no_register 
						AND c.no_register=pasien_luar.no_register AND c.no_register='$no_register'");
		}

		function getdata_ruang($idrg){
			return $this->db->query("SELECT * FROM ruang WHERE idrg='$idrg'");
		}

		function getdata_poliklinik($idrg){
			return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='$idrg'");
		}

		function get_data_adm_pasien_luar(){
			return $this->db->query("SELECT * FROM jenis_tindakan where idtindakan = '1B0105' ");//1B0226
		}

		public function get_detail_tindakan($id_tindakan){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
			and b.kelas='NK'");
		}

		function get_data_permintaan($no_resep){
			//return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, signa, vtot, racikan, id_resep_pasien FROM resep_pasien b where no_resep='$no_resep'");
			return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, vtot,signa, racikan, id_resep_pasien FROM resep_pasien b where no_resep='$no_resep'");
		}

		function get_data_permintaan_rj($no_register) {
			return $this->db->query("SELECT vtot_obat FROM daftar_ulang_irj WHERE no_register = '$no_register'");
		}

		function get_data_permintaan_rj_detail($no_register) {
			return $this->db->query("SELECT * FROM resep_pasien WHERE no_register = '$no_register'");
		}
		function getdata_resep_racik($no_register){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.item_obat) as nm_obat 
				FROM obat_racikan AS a where no_register='".$no_register."'");
		}

		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * from data_rs where koders='$koders'");
		}

		function get_total_tuslah($no_resep){
			return $this->db->query("SELECT sum(tuslah) as vtot_tuslah from resep_pasien where no_resep='$no_resep'");
		}
		
		function update_status_resep($nokwitansi_kt,$no_register){
			$this->db->query("update  set nokwitansi_kt='$nokwitansi_kt', tglcetak_kwitansi=now() where no_register='$no_register'");
			return true;
		}

		function update_diskon($diskon,$no_resep){
			$this->db->query("update resep_header set diskon='$diskon' where no_resep='$no_resep'");
			return true;
		}

		function update_status_cetak_kwitansi($no_register){
			//$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE resep_pasien SET cetak_kwitansi='1' WHERE no_register='$no_register'");
			//$this->db->query("UPDATE resep_header SET diskon='$diskon' WHERE no_resep='$no_resep'");
			return true;
		}

		function get_no_kwitansi_loket($idloket){
			return $this->db->query("SELECT NULLIF(MAX(idno_kwitansi),000000) as no_kwitansi from no_kwitansi");
		}

		public function get_row_noKwitansi_by_register($no_register)
		{
			return $this->db->query("SELECT * FROM no_kwitansi WHERE no_register = '".$no_register."' and LEFT(no_kwitansi,3) = 'FAR' ");
		}

		function insert_nomorkwitansi($data){
			return $this->db->insert('nomor_kwitansi', $data);
		}

		function insert_nokwitansi($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_kwitansi',"(select 'FAR".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Farmasi' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			return $this->db->insert('no_kwitansi', $data);
		}



		public function get_nama_xuser_by_noreg($no_register)
		{
			return $this->db->query("SELECT * FROM nomor_kwitansi WHERE no_register = '$no_register'");
		}

	}
?>