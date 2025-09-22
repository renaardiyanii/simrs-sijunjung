<?php 
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mumcicilan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_all_pasien_cicilan_irj($dateawal,$dateakhir){
			return $this->db->query("SELECT
				a.*, b.*, c.*, d.*, e.*, f.id_loket, f.no_kwitansi, f.batal, f.retur from um_cicilan a
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				JOIN data_pasien c ON b.no_medrec=c.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				LEFT join nomor_kwitansi f ON a.idno_kwitansi=f.idno_kwitansi
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}

		function get_all_pasien_cicilan_iri($dateawal,$dateakhir){
			return $this->db->query("SELECT
				* from um_cicilan a
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				JOIN data_pasien c ON b.no_medrec=c.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}

		function get_pasien_kwitansi($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and LEFT(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.cara_bayar desc");
		}

		function get_data_cicilan_noreg($noreg){
			return $this->db->query("SELECT * FROM um_cicilan where no_register='$noreg'");
		}

		function get_max_cicilan_ke($noreg){
			return $this->db->query("SELECT IFNULL(max(cicilan_ke),0) as last_cicilan from um_cicilan where no_register='$noreg'");
		}

		function get_detail_pasien($no_medrec){
			return $this->db->query("SELECT
				*, (select count(*) from nomor_kwitansi where no_register=b.no_register GROUP BY no_register) as cicilan_ke
				from data_pasien a
				JOIN daftar_ulang_irj b ON b.no_medrec=a.no_medrec
				LEFT JOIN poliklinik d ON d.id_poli=b.id_poli
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where LEFT(a.xcreate,10)>='$dateawal' and LEFT(a.xcreate,10)<='$dateakhir'");
		}

        function get_data_pasien_iri($no_register){
			return $this->db->query("SELECT  a.no_ipd, b.no_cm as no_cm, b.sex, b.foto, b.nama as nama, left(b.tgl_lahir,10) as tgl_lahir,  b.no_hp as no_hp, b.alamat as alamat, c.ket tindakan, (select nm_dokter from data_dokter where c.id_dokter = data_dokter.id_dokter) as dokter, c.id_dokter FROM pasien_iri a, data_pasien b, operasi_header c where a.no_ipd = '$no_register' and a.no_cm = b.no_medrec and a.no_ipd = c.no_register group by c.no_register
				UNION 
				SELECT  a.no_register as no_ipd, b.no_cm as no_cm, b.sex, b.foto, b.nama as nama, left(b.tgl_lahir,10) as tgl_lahir,  b.no_hp as no_hp, b.alamat as alamat, c.ket as tindakan, (select nm_dokter from data_dokter where c.id_dokter = data_dokter.id_dokter) as dokter, c.id_dokter FROM daftar_ulang_irj a, data_pasien b, operasi_header c where a.no_register = '$no_register' and a.no_medrec = b.no_medrec and a.no_register = c.no_register  group by c.no_register ");
	}

	function get_id_bayarlangsung(){
		return $this->db->query("SELECT  max(id) as id FROM pembayaran_langsung");
    }

	function insert_langsung($data)
	{
		$this->db->insert('pembayaran_langsung', $data);
		return true;
	}

	function get_data_bayar_id(){
		return $this->db->query("SELECT * FROM pembayaran_langsung where id = $id");
	}

	function get_data_bayar(){
		return $this->db->query("SELECT * from no_register,nama_obat, qty, vtot
			FROM 
			Where Left(tgl_kunjungan,10)  = left(now(),10)");

	}		


	
	function get_layanan()
    {
        // return $this->db->query("SELECT A.id_tindakan, A.total_tarif, A.kelas, B.idtindakan, B.nmtindakan, B.idpok1  
		// 						FROM tarif_tindakan A, jenis_tindakan B 
		// 						WHERE A.id_tindakan=B.idtindakan AND A.kelas='NK' and B.idpok1 ='A'");

		return $this->db->query("SELECT DISTINCT kategori FROM jenis_tindakan WHERE kel_tindakan = ' Pelayanan Non Medis '");
    }

     function getdata_jenis_tindakan(){

	return $this->db->query("SELECT A.id_tindakan, A.total_tarif, A.kelas, B.idtindakan, B.nmtindakan, B.idpok1  
	                         FROM tarif_tindakan A, jenis_tindakan B 
							 WHERE A.id_tindakan=B.idtindakan AND A.kelas='NK' and B.idpok1 ='A'");
    }


	function get_item_layanan($jenis_bayar){

					return $this->db->query("SELECT a.idtindakan,a.nmtindakan, b.total_tarif 
					FROM jenis_tindakan a, tarif_tindakan b 
					where a.idtindakan = b.id_idtindakan 
					and a.idpok2 = '$jenis_bayar'");   				
	}

	function get_data_pembayaran_langsung() {
		return $this->db->query("SELECT a.*, b.name FROM pembayaran_langsung AS a, hmis_users AS b WHERE cetak IS NULL AND a.xuser = b.username");

		//return $data->result_array();
	}

	function get_data_tindakan_non_medis($kategori) {
		return $this->db->query("SELECT A
			.idtindakan,
			A.nmtindakan,
			b.total_tarif 
		FROM
			jenis_tindakan AS A,
			tarif_tindakan AS b 
		WHERE
			kategori = '$kategori' 
			AND A.idtindakan = b.id_tindakan 
			AND b.kelas IN ('NK','NR')");
	}

	function get_data_tindakan_non_medis_jenazah() {
		return $this->db->query("SELECT idtindakan, nmtindakan FROM jenis_tindakan WHERE kategori = 'Pemulasaran Jenazah'");
	}

	function get_nama_by_medrec($nocm) {
		return $this->db->query("SELECT nama FROM data_pasien WHERE no_cm = '$nocm'");
	}

	function hapus_item($id) {
		$this->db->where('id', $id);
		$this->db->delete('pembayaran_langsung');
		return true;
	}

	function update_no_kwitansi($kwitansi,$id) {
		$where = "cetak is null and id = '$id'";
		$this->db->where($where);
		$this->db->update('pembayaran_langsung', $kwitansi);
		return true;
	}

	function get_nocm_kwitansi($tgl, $nocm) {
		return $this->db->query("SELECT no_kwitansi FROM pembayaran_langsung WHERE tgl_cetak = '$tgl' AND no_cm = '$nocm'");
	}

	function get_data_pasien($no_kwitansi) {
		return $this->db->query("SELECT b.*, (select tgl_lahir from data_pasien a where a.no_cm = b.no_cm)as tgl_lahir FROM 
		pembayaran_langsung AS b WHERE  b.no_register = '$no_kwitansi'");
	}

	function get_detail_item ($no_kwitansi) {
		return $this->db->query("SELECT * FROM pembayaran_langsung WHERE no_register = '$no_kwitansi'");
	}
	
	function cek_no_kwitansi($nocm) {
		return $this->db->query("SELECT no_kwitansi FROM pembayaran_langsung WHERE no_cm = '$nocm'");
	}

	function get_user_kasir() {
		return $this->db->query("SELECT A
			.NAME,	a.username
		FROM
			dyn_role_user AS b,
			hmis_users AS A 
		WHERE
			b.ROLE IN ('Kasir','Administrator')
			AND A.userid = b.userid");
	}

	function get_name_by_username($user) {
		if($user == 'semua') {
			return $this->db->query("SELECT 'Semua User Kasir' AS name FROM hmis_users");
		} else {
			return $this->db->query("SELECT name FROM hmis_users WHERE username = '$user'");
		}
	}

	function get_lap_penerimaan_perkasir_semua($date, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_obat($date, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_ri($date, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nmruang,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.carabayar
			FROM
				no_kwitansi AS a,
				ruang AS b,
				pasien_iri AS c
			WHERE
				c.idrg = b.idrg
				AND a.no_register = c.no_ipd
				AND a.jenis_kwitansi = 'RI'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			// return $this->db->query("SELECT
			// 	a.*,
			// 	b.nmruang,
			// 	(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
			// 	(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
			// 	(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
			// 	c.carabayar
			// FROM
			// 	no_kwitansi AS a,
			// 	ruang AS b,
			// 	pasien_iri AS c
			// WHERE
			// 	c.idrg = b.idrg
			// 	AND a.no_register = c.no_ipd
			// 	AND a.jenis_kwitansi = 'RI'
			// 	AND c.carabayar = '$jaminan'
			// 	AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");

			return $this->db->query("SELECT A
				.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Sudah Cetak' AS keterangan,
				c.no_ipd
			FROM
				pasien_iri AS c
				LEFT JOIN no_kwitansi AS a ON a.no_register = c.no_ipd
				LEFT JOIN ruang AS b ON c.idrg = b.idrg
			WHERE
				A.jenis_kwitansi = 'RI' 
				AND C.carabayar = '$jaminan' 
				AND to_char( A.tgl_cetak, 'YYYY-MM-DD' ) = '$date' UNION 
			SELECT 
				a.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Belum Cetak' AS keterangan,
				c.no_ipd
			FROM 
				pasien_iri AS c 
				LEFT OUTER JOIN no_kwitansi AS a ON c.no_ipd = a.no_register 
				LEFT JOIN ruang AS b ON b.idrg = c.idrg 
			WHERE
				C.carabayar = '$jaminan' 
				AND to_char( c.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$date'
				AND c.cetak_kwitansi IS NULL");
		}
	}

	function get_lap_penerimaan_perkasir_semua_non_pasien($date) {
		return $this->db->query("SELECT
			SUM(a.vtot) AS jml,
			a.no_cm,
			a.nama,
			a.no_kwitansi,
			a.method_pay,
			(SELECT name FROM hmis_users WHERE min(a.xuser) = username LIMIT 1) AS kasir
		FROM
			pembayaran_langsung AS a
		WHERE
			a.cetak = '1'
			AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
		GROUP BY
			a.no_cm, a.nama, a.no_kwitansi, a.method_pay");
	}

	function get_lap_penerimaan_perkasir_semua_user($date, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_user_obat($date, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_user_ri($date, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nmruang,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.carabayar
			FROM
				no_kwitansi AS a,
				ruang AS b,
				pasien_iri AS c
			WHERE
				c.idrg = b.idrg
				AND a.no_register = c.no_ipd
				AND a.jenis_kwitansi = 'RI'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			// return $this->db->query("SELECT
			// 	a.*,
			// 	b.nmruang,
			// 	(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
			// 	(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
			// 	(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
			// 	c.carabayar
			// FROM
			// 	no_kwitansi AS a,
			// 	ruang AS b,
			// 	pasien_iri AS c
			// WHERE
			// 	c.idrg = b.idrg
			// 	AND a.no_register = c.no_ipd
			// 	AND a.jenis_kwitansi = 'RI'
			// 	AND c.carabayar = '$jaminan'
			// 	AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
			// 	AND a.jenis_bayar = '$carabayar'");

			return $this->db->query("SELECT A
				.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Sudah Cetak' AS keterangan
			FROM
				pasien_iri AS c
				LEFT JOIN no_kwitansi AS a ON a.no_register = c.no_ipd
				LEFT JOIN ruang AS b ON c.idrg = b.idrg
			WHERE
				A.jenis_kwitansi = 'RI' 
				AND c.carabayar = '$jaminan'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
			 	AND a.jenis_bayar = '$carabayar' UNION 
			SELECT 
				a.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Belum Cetak' AS keterangan
			FROM 
				pasien_iri AS c 
				LEFT OUTER JOIN no_kwitansi AS a ON c.no_ipd = a.no_register 
				LEFT JOIN ruang AS b ON b.idrg = c.idrg 
			WHERE
				C.carabayar = '$jaminan' 
				AND to_char( c.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$date'
				AND c.cetak_kwitansi IS NULL");
		}
	}

	function get_lap_penerimaan_perkasir_semua_user_non_pasien($date, $carabayar) {
		return $this->db->query("SELECT
			SUM(a.vtot) AS jml,
			a.no_cm,
			a.nama,
			a.no_kwitansi,
			a.method_pay,
			(SELECT name FROM hmis_users WHERE min(a.xuser) = username LIMIT 1) AS kasir
		FROM
			pembayaran_langsung AS a
		WHERE
			a.cetak = '1'
			AND a.method_pay = '$carabayar'
			AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
		GROUP BY
			a.no_cm, a.nama, a.no_kwitansi, a.method_pay");
	}

	function get_lap_penerimaan_perkasir_semua_jenis($date, $user, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.jenis_kwitansi != 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_jenis_obat($date, $user, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		}
	}

	function get_lap_penerimaan_perkasir_semua_jenis_ri($date, $user, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nmruang,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.carabayar
			FROM
				no_kwitansi AS a,
				ruang AS b,
				pasien_iri AS c
			WHERE
				c.idrg = b.idrg
				AND a.no_register = c.no_ipd
				AND a.jenis_kwitansi = 'RI'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");
		} else {
			// return $this->db->query("SELECT
			// 	a.*,
			// 	b.nmruang,
			// 	(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
			// 	(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
			// 	(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
			// 	c.carabayar
			// FROM
			// 	no_kwitansi AS a,
			// 	ruang AS b,
			// 	pasien_iri AS c
			// WHERE
			// 	c.idrg = b.idrg
			// 	AND a.no_register = c.no_ipd
			// 	AND a.jenis_kwitansi = 'RI'
			// 	AND c.carabayar = '$jaminan'
			// 	AND a.user_cetak = '$user'
			// 	AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'");

			return $this->db->query("SELECT A
				.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Sudah Cetak' AS keterangan
			FROM
				pasien_iri AS c
				LEFT JOIN no_kwitansi AS a ON a.no_register = c.no_ipd
				LEFT JOIN ruang AS b ON c.idrg = b.idrg
			WHERE
				A.jenis_kwitansi = 'RI' 
				AND c.carabayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date' UNION 
			SELECT 
				a.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Belum Cetak' AS keterangan
			FROM 
				pasien_iri AS c 
				LEFT OUTER JOIN no_kwitansi AS a ON c.no_ipd = a.no_register 
				LEFT JOIN ruang AS b ON b.idrg = c.idrg 
			WHERE
				C.carabayar = '$jaminan' 
				AND to_char( c.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$date'
				AND c.cetak_kwitansi IS NULL");
		}
	}

	function get_lap_penerimaan_perkasir_semua_jenis_non_pasien($date, $user) {
		return $this->db->query("SELECT
			SUM(a.vtot) AS jml,
			a.no_cm,
			a.nama,
			a.no_kwitansi,
			a.method_pay,
			(SELECT name FROM hmis_users WHERE min(a.xuser) = username LIMIT 1) AS kasir
		FROM
			pembayaran_langsung AS a
		WHERE
			a.cetak = '1'
			AND a.xuser = '$user'
			AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
		GROUP BY
			a.no_cm, a.nama, a.no_kwitansi, a.method_pay");
	}

	function get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND a.user_cetak = '$user'
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.jenis_kwitansi != 'Farmasi'
				AND a.no_register = c.no_register
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			return $this->db->query("SELECT
				a.*,
				b.nm_poli,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				daftar_ulang_irj AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND a.jenis_kwitansi != 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				b.nm_poli,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				poliklinik AS b,
				pasien_luar AS c
			WHERE
				a.asal = b.id_poli
				AND a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.jenis_kwitansi != 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		}
	}

	function get_lap_penerimaan_perkasir_pilih_obat($date, $user, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') { 
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			return $this->db->query("SELECT
				a.*,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				daftar_ulang_irj AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.user_cetak = '$user'
				AND a.jenis_kwitansi = 'Farmasi'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar' UNION
			SELECT
				a.*,
				CAST(c.no_cm AS VARCHAR),
				c.nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.cara_bayar
			FROM
				no_kwitansi AS a,
				pasien_luar AS c
			WHERE
				a.no_register = c.no_register
				AND c.cara_bayar = '$jaminan'
				AND a.jenis_kwitansi = 'Farmasi'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		}
	}

	function get_lap_penerimaan_perkasir_pilih_ri($date, $user, $carabayar, $jaminan) {
		if($jaminan == '' || $jaminan == 'semua') {
			return $this->db->query("SELECT
				a.*,
				b.nmruang,
				(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
				(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
				(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
				c.carabayar
			FROM
				no_kwitansi AS a,
				ruang AS b,
				pasien_iri AS c
			WHERE
				c.idrg = b.idrg
				AND a.no_register = c.no_ipd
				AND a.jenis_kwitansi = 'RI'
				AND a.user_cetak = '$user'
				AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
				AND a.jenis_bayar = '$carabayar'");
		} else {
			// return $this->db->query("SELECT
			// 	a.*,
			// 	b.nmruang,
			// 	(SELECT no_cm FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS no_cm,
			// 	(SELECT nama FROM data_pasien WHERE no_medrec = c.no_medrec LIMIT 1) AS nama,
			// 	(SELECT name FROM hmis_users WHERE a.user_cetak = username LIMIT 1) AS kasir,
			// 	c.carabayar
			// FROM
			// 	no_kwitansi AS a,
			// 	ruang AS b,
			// 	pasien_iri AS c
			// WHERE
			// 	c.idrg = b.idrg
			// 	AND a.no_register = c.no_ipd
			// 	AND a.jenis_kwitansi = 'RI'
			// 	AND c.carabayar = '$jaminan'
			// 	AND a.user_cetak = '$user'
			// 	AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
			// 	AND a.jenis_bayar = '$carabayar'");

			return $this->db->query("SELECT A
				.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Sudah Cetak' AS keterangan
			FROM
				pasien_iri AS c
				LEFT JOIN no_kwitansi AS a ON a.no_register = c.no_ipd
				LEFT JOIN ruang AS b ON c.idrg = b.idrg
			WHERE
				A.jenis_kwitansi = 'RI' 
				AND c.carabayar = '$jaminan'
			 	AND a.user_cetak = '$user'
			 	AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
			 	AND a.jenis_bayar = '$carabayar' UNION 
			SELECT 
				a.*,
				b.nmruang,
				( SELECT no_cm FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE no_medrec = C.no_medrec LIMIT 1 ) AS nama,
				( SELECT NAME FROM hmis_users WHERE A.user_cetak = username LIMIT 1 ) AS kasir,
				C.carabayar,
				'Belum Cetak' AS keterangan
			FROM 
				pasien_iri AS c 
				LEFT OUTER JOIN no_kwitansi AS a ON c.no_ipd = a.no_register 
				LEFT JOIN ruang AS b ON b.idrg = c.idrg 
			WHERE
				C.carabayar = '$jaminan' 
				AND to_char( c.tgl_keluar_resume, 'YYYY-MM-DD' ) = '$date'
				AND c.cetak_kwitansi IS NULL");
		}
	}

	function get_lap_penerimaan_perkasir_pilih_non_pasien($date, $user, $carabayar) {
		return $this->db->query("SELECT
			SUM(a.vtot) AS jml,
			a.no_cm,
			a.nama,
			a.no_kwitansi,
			a.method_pay,
			(SELECT name FROM hmis_users WHERE min(a.xuser) = username LIMIT 1) AS kasir
		FROM
			pembayaran_langsung AS a
		WHERE
			a.cetak = '1'
			AND a.xuser = '$user'
			AND a.method_pay = '$carabayar'
			AND to_char(a.tgl_cetak,'YYYY-MM-DD') = '$date'
		GROUP BY
			a.no_cm, a.nama, a.no_kwitansi, a.method_pay");
	}

	function get_lap_jml_konsul_gizi_old($date) {
		return $this->db->query("SELECT
			1 AS nomor,
			'VIP' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.kelas = 'VIP' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.kelas = 'VIP' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.kelas = 'VIP' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.kelas = 'VIP' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'VIP' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'VIP' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b,
			ruang AS c
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd 
			AND a.idrg = c.idrg UNION
		SELECT
			2 AS nomor,
			'Kelas I' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.kelas = 'I' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.kelas = 'I' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.kelas = 'I' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.kelas = 'I' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b,
			ruang AS c
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd 
			AND a.idrg = c.idrg UNION
		SELECT
			3 AS nomor,
			'Kelas II' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.kelas = 'II' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.kelas = 'II' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.kelas = 'II' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.kelas = 'II' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'II' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'II' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b,
			ruang AS c
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd
			AND a.idrg = c.idrg UNION
		SELECT
			4 AS nomor,
			'Kelas III' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.kelas = 'III' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.kelas = 'III' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.kelas = 'III' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.kelas = 'III' AND a.idrg NOT IN('0404','0106','0704','0304','0604','0706','0804','0805','0504') AND c.nmruang NOT LIKE '%Isolasi%') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'III' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'III' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b,
			ruang AS c
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd
			AND a.idrg = c.idrg UNION
		SELECT
			5 AS nomor,
			'ICU' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.idrg IN ('0404','0704','0304')) AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.idrg IN ('0404','0704','0304')) AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.idrg IN ('0404','0704','0304')) AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.idrg IN ('0404','0704','0304')) AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd UNION
		SELECT
			6 AS nomor,
			'HCU' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND a.idrg IN ('0106','0604','0706','0804','0805','0504')) AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND a.idrg IN ('0106','0604','0706','0804','0805','0504')) AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND a.idrg IN ('0106','0604','0706','0804','0805','0504')) AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND a.idrg IN ('0106','0604','0706','0804','0805','0504')) AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'II' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'II' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd UNION
		SELECT 
			7 AS nomor,
			'Isolasi' AS ruang,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS' AND c.nmruang LIKE '%Isolasi%') AS bpjs_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS' AND c.nmruang LIKE '%Isolasi%') AS bpjs_tkt_2,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM' AND c.nmruang LIKE '%Isolasi%') AS umum_tkt_1,
			SUM(a.qtyyanri) FILTER (WHERE a.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM' AND c.nmruang LIKE '%Isolasi%') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'I' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_iri AS a,
			pasien_iri AS b,
			ruang AS c
		WHERE
			to_char(a.tgl_layanan,'YYYY-MM') = '$date'
			AND a.no_ipd = b.no_ipd
			AND a.idrg = c.idrg UNION
		SELECT 
			8 AS nomor,
			'Poli Eksekutif' AS ruang,
			SUM(a.qtyind) FILTER (WHERE a.idtindakan = 'BM0007' AND b.cara_bayar = 'BPJS' AND c.nm_pokpoli = 'EKSEKUTIF') AS bpjs_tkt_1,
			SUM(a.qtyind) FILTER (WHERE a.idtindakan = 'BM0006' AND b.cara_bayar = 'BPJS' AND c.nm_pokpoli = 'EKSEKUTIF') AS bpjs_tkt_2,
			SUM(a.qtyind) FILTER (WHERE a.idtindakan = 'BM0007' AND b.cara_bayar = 'UMUM' AND c.nm_pokpoli = 'EKSEKUTIF') AS umum_tkt_1,
			SUM(a.qtyind) FILTER (WHERE a.idtindakan = 'BM0006' AND b.cara_bayar = 'UMUM' AND c.nm_pokpoli = 'EKSEKUTIF') AS umum_tkt_2,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'EKSEKUTIF' AND id_tindakan = 'BM0007' LIMIT 1) AS tarif_1,
			(SELECT total_tarif FROM tarif_tindakan WHERE kelas = 'EKSEKUTIF' AND id_tindakan = 'BM0006' LIMIT 1) AS tarif_2
		FROM
			pelayanan_poli AS a,
			daftar_ulang_irj AS b,
			poliklinik AS c
		WHERE
			to_char(a.tgl_kunjungan,'YYYY-MM') = '$date'
			AND a.no_register = b.no_register
			AND a.id_poli = c.id_poli
		ORDER BY nomor ASC
		");
	}

	function get_lap_jml_konsul_gizi($date) {
		return $this->db->query("SELECT
			1 AS nomor,
			'Gedung Merapi' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b,
			ruang AS C
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND c.nmruang LIKE '%Merapi%'
			AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705')
			AND A.idrg = C.idrg
		GROUP BY 
			a.kelas UNION 
		SELECT
			2 AS nomor,
			'Gedung Singgalang' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b,
			ruang AS C
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND c.nmruang LIKE '%Singgalang%'
			AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705')
			AND A.idrg = C.idrg
		GROUP BY 
			a.kelas UNION
		SELECT
			3 AS nomor,
			'Gedung Panorama' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b,
			ruang AS C
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND c.nmruang LIKE '%Panorama%'
			AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705')
			AND A.idrg = C.idrg
		GROUP BY 
			a.kelas UNION 
		SELECT
			4 AS nomor,
			'Gedung Limpapeh' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b,
			ruang AS C
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND c.nmruang LIKE '%Limpapeh%'
			AND a.idrg NOT IN ('0404','0704','0604','0504','0804','0805','0706','309','0701','0705')
			AND A.idrg = C.idrg
		GROUP BY 
			a.kelas UNION 
		SELECT
			5 AS nomor,
			'ICU' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND a.idrg IN ('0404','0704')
		GROUP BY 
			a.kelas UNION 
		SELECT
			6 AS nomor,
			'HCU' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND a.idrg IN ('0604','0504','0804','0805','0706')
		GROUP BY 
			a.kelas UNION 
		SELECT
			7 AS nomor,
			'Isolasi' AS ruang,
			a.kelas,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'BPJS') AS bpjs_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'BPJS') AS bpjs_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'UMUM') AS umum_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'UMUM') AS umum_tkt_2,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0007' AND b.carabayar = 'KERJASAMA') AS iks_tkt_1,
			SUM (A.qtyyanri) FILTER (WHERE A.id_tindakan = 'BM0006' AND b.carabayar = 'KERJASAMA') AS iks_tkt_2,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_bpjs,
			(SELECT tarif_bpjs FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_bpjs,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_umum,
			(SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_umum,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0007' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_1_iks,
			(SELECT tarif_iks FROM tarif_tindakan WHERE id_tindakan = 'BM0006' AND a.kelas = kelas LIMIT 1) AS tarif_tkt_2_iks 
		FROM
			pelayanan_iri AS A,
			pasien_iri AS b
		WHERE
			to_char( A.tgl_layanan, 'YYYY-MM' ) = '$date' 
			AND A.no_ipd = b.no_ipd 
			AND a.idrg IN ('309','0701','0705')
		GROUP BY 
			a.kelas 
		ORDER BY 
			nomor");
	}

	function get_poliklinik(){
		return $this->db->query("SELECT id_poli, nm_poli,nm_pokpoli, poli_bpjs FROM poliklinik order by nm_poli asc");
	}

	function get_nocm_tgl_non_pasien() {
		return $this->db->query("SELECT tgl_cetak, no_cm FROM pembayaran_langsung WHERE cetak IS NULL");
	}

	function generate_no_register_kwitansi() {
		$tahun = date('Y');
		$depan = substr($tahun,2,2);
		$where = "cetak is null";
		$this->db->set('no_kwitansi',"(select 'NP".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM pembayaran_langsung where cetak is null ), '000000') as int) +1 as varchar),6) as id)", FALSE);
		$this->db->set('no_register',"(select 'NP".$depan."' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM pembayaran_langsung where cetak is null ), '000000') as int) +1 as varchar),6) as id)", FALSE);
		$this->db->where($where);
		$this->db->update('pembayaran_langsung');
		return true;
	}

	function get_no_register_kwitansi() {
		return $this->db->query("SELECT no_register, no_kwitansi FROM pembayaran_langsung WHERE no_register IS NOT NULL ORDER BY no_register DESC LIMIT 1");
	}

	function get_tindakan_non_pasien($no_kwitansi) {
		return $this->db->query("SELECT item_bayar FROM pembayaran_langsung WHERE no_kwitansi = '$no_kwitansi'");
	}

	function get_master_poli() {
		return $this->db->query("SELECT id_poli, nm_poli FROM poliklinik WHERE nm_pokpoli NOT IN ('','EKSEKUTIF') AND id_poli NOT IN ('BK07','BK01','BK02','BK03')");
	}

	function get_master_ruang() {
		return $this->db->query("SELECT idrg, nmruang FROM ruang WHERE aktif = 'Active'");
	}

	function get_poli_rehab() {
		return $this->db->query("SELECT DISTINCT sub_kelompok FROM jenis_tindakan WHERE SUBSTRING(idtindakan,1,2) = 'BK' AND sub_kelompok IN ( 'ORTOTIK PROSTETIK', 'Fisioterapi', 'OKUPASI THERAPY', 'Terapi Wicara')");
	}

	function get_tindakan_unit_kerja_poli($id_poli, $date1, $date2) {
		return $this->db->query("SELECT 
			a.idtindakan,
			a.nmtindakan,
			SUM(a.qtyind) AS total_vol,
			SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qtyind) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE b.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE b.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE b.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_rj WHERE a.idtindakan = idtindakan AND tgl BETWEEN '$date1' AND '$date2' AND id_poli = '$id_poli' LIMIT 1) AS rill
		FROM 
			pelayanan_poli AS a
			LEFT JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register
			LEFT JOIN jenis_tindakan AS c ON a.idtindakan = c.idtindakan
		WHERE 
			to_char(b.tgl_kunjungan,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
			AND b.id_poli = '$id_poli'
			AND c.sub_kelompok NOT IN ('ORTOTIK PROSTETIK','Fisioterapi','OKUPASI THERAPY','Terapi Wicara')
		GROUP BY 
			a.idtindakan, a.nmtindakan");
	}

	function get_tindakan_unit_kerja_ruangan($idrg, $date1, $date2) {
		return $this->db->query("SELECT 
			a.id_tindakan AS idtindakan,
			c.nmtindakan,
			SUM(a.qtyyanri) AS total_vol,
			SUM(a.qtyyanri) FILTER (WHERE b.carabayar = 'BPJS') AS vol_bpjs,
			SUM(a.qtyyanri) FILTER (WHERE b.carabayar = 'UMUM') AS vol_umum,
			SUM(a.qtyyanri) FILTER (WHERE b.carabayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE b.carabayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE b.carabayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE b.carabayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_ri WHERE a.id_tindakan = id_tindakan AND tgl BETWEEN '$date1' AND '$date2' AND idrg = '$idrg' LIMIT 1) AS rill
		FROM 
			pelayanan_iri AS a
			LEFT JOIN pasien_iri AS b ON a.no_ipd = b.no_ipd
			LEFT JOIN jenis_tindakan AS c ON a.id_tindakan = c.idtindakan
		WHERE 
			to_char(a.tgl_layanan,'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
			AND a.idrg = '$idrg'
			AND c.sub_kelompok NOT IN ('ORTOTIK PROSTETIK','Fisioterapi','OKUPASI THERAPY','Terapi Wicara')
			AND SUBSTRING(a.id_tindakan,1,2) != 'BM'
		GROUP BY 
			a.id_tindakan, c.nmtindakan");
	}

	function get_tindakan_unit_kerja_rehab($id_poli, $date1, $date2) {
		return $this->db->query("SELECT 
			idtindakan,
			nmtindakan,
			SUM(total_vol) AS total_vol,
			SUM(vol_bpjs) AS vol_bpjs,
			SUM(vol_umum) AS vol_umum,
			SUM(vol_iks) AS vol_iks,
			SUM(penerimaan_bpjs) AS penerimaan_bpjs,
			SUM(penerimaan_umum) AS penerimaan_umum,
			SUM(penerimaan_iks) AS penerimaan_iks,
			COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) AS rill
		FROM 
			unit_kerja_rehab 
		WHERE 
			tgl BETWEEN '$date1' AND '$date2'
			AND sub_kelompok = '$id_poli'
		GROUP BY 
			idtindakan, nmtindakan");
	}

	function get_tindakan_unit_kerja_gizi($date1, $date2) {
		return $this->db->query("SELECT 
			idtindakan,
			nmtindakan,
			SUM(total_vol) AS total_vol,
			SUM(vol_bpjs) AS vol_bpjs,
			SUM(vol_umum) AS vol_umum,
			SUM(vol_iks) AS vol_iks,
			SUM(penerimaan_bpjs) AS penerimaan_bpjs,
			SUM(penerimaan_umum) AS penerimaan_umum,
			SUM(penerimaan_iks) AS penerimaan_iks,
			COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) AS rill
		FROM 
			unit_kerja_gizi
		WHERE 
			tgl BETWEEN '$date1' AND '$date2'
		GROUP BY 
			idtindakan, nmtindakan");
	}

	function get_tindakan_unit_kerja_lab($date1, $date2) {
		return $this->db->query("SELECT 
			a.id_tindakan AS idtindakan,
			a.jenis_tindakan AS nmtindakan,
			SUM(a.qty) AS total_vol,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_lab WHERE a.id_tindakan = id_tindakan AND tgl BETWEEN '$date1' AND '$date2' LIMIT 1) AS rill
		FROM 
			pemeriksaan_laboratorium a
		WHERE
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
		GROUP BY 
			a.id_tindakan, a.jenis_tindakan");
	}

	function get_tindakan_unit_kerja_rad($date1, $date2) {
		return $this->db->query("SELECT 
			a.id_tindakan AS idtindakan,
			a.jenis_tindakan AS nmtindakan,
			SUM(a.qty) AS total_vol,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_rad WHERE a.id_tindakan = id_tindakan AND tgl BETWEEN '$date1' AND '$date2' LIMIT 1) AS rill
		FROM 
			pemeriksaan_radiologi a
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
		GROUP BY 
			a.id_tindakan, a.jenis_tindakan");
	}

	function get_tindakan_unit_kerja_em($date1, $date2) {
		return $this->db->query("SELECT 
			a.id_tindakan AS idtindakan,
			a.jenis_tindakan AS nmtindakan,
			SUM(a.qty) AS total_vol,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_em WHERE a.id_tindakan = id_tindakan AND tgl BETWEEN '$date1' AND '$date2' LIMIT 1) AS rill
		FROM 
			pemeriksaan_elektromedik a
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
		GROUP BY 
			a.id_tindakan, a.jenis_tindakan");
	}

	function get_tindakan_unit_kerja_ok($date1, $date2) {
		return $this->db->query("SELECT 
			a.id_tindakan AS idtindakan,
			a.jenis_tindakan AS nmtindakan,
			SUM(a.qty) AS total_vol,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			(SELECT COALESCE(SUM(bpjs), 0) + COALESCE(SUM(umum), 0) + COALESCE(SUM(iks), 0) FROM rill_ok WHERE a.id_tindakan = id_tindakan AND tgl BETWEEN '$date1' AND '$date2' LIMIT 1) AS rill
		FROM 
			pemeriksaan_elektromedik a
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
		GROUP BY 
			a.id_tindakan, a.jenis_tindakan");
	}

	function get_tindakan_unit_kerja_resep($date1, $date2) {
		return $this->db->query("SELECT 
			a.item_obat AS idtindakan,
			a.nama_obat AS nmtindakan,
			SUM(a.qty) AS total_vol,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'BPJS') AS vol_bpjs,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'UMUM') AS vol_umum,
			SUM(a.qty) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS vol_iks,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'UMUM') AS penerimaan_umum,
			SUM(a.vtot) FILTER (WHERE a.cara_bayar = 'KERJASAMA') AS penerimaan_iks,
			SUM(a.vtot) AS rill
		FROM 
			resep_pasien a
		WHERE 
			to_char(a.tgl_kunjungan, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
		GROUP BY 
			a.item_obat, a.nama_obat");
	}

	function get_rincian_titipan_pasien($date) {
		return $this->db->query("SELECT 
			a.no_ipd,
			b.nama,
			b.no_medrec,
			b.no_cm,
			a.carabayar,
			c.nmruang,
			b.sex,
			a.tgl_masuk,
			a.tgl_keluar_resume,
			a.jaminan_adm,
			a.uang_muka_adm
		FROM 
			pasien_iri AS a,
			data_pasien AS b,
			ruang AS c
		WHERE 
			a.administrasi_tertunda = 1
			AND to_char(a.tgl_keluar_resume, 'YYYY-MM') = '$date'
			AND a.no_medrec = b.no_medrec 
			AND a.idrg = c.idrg");
	}

	function get_akomodasi_unit_kerja_ruangan($idrg, $date1, $date2) {
		return $this->db->query("SELECT 
			'Akomodasi' AS nmtindakan,
			SUM(a.diff) FILTER (WHERE a.carabayar = 'BPJS') AS vol_bpjs,
			SUM(a.diff) FILTER (WHERE a.carabayar = 'UMUM') AS vol_umum,
			SUM(a.diff) FILTER (WHERE a.carabayar = 'KERJASAMA') AS vol_iks,
			SUM(a.diff * COALESCE(a.tarif_bpjs, 0)) FILTER (WHERE a.carabayar = 'BPJS') AS penerimaan_bpjs,
			SUM(a.diff * COALESCE(a.total_tarif, 0)) FILTER (WHERE a.carabayar = 'UMUM') AS penerimaan_umum,
			SUM(a.diff * COALESCE(a.tarif_iks, 0)) FILTER (WHERE a.carabayar = 'KERJASAMA') AS penerimaan_iks
		FROM
			unit_akomodasi AS a
		WHERE
			a.idrg = '$idrg'
			AND to_char(a.tglkeluarrg, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'");
	}
}
?>