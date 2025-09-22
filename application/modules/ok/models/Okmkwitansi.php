<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Okmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			// return $this->db->query("SELECT data_pasien.no_cm as no_cm, b.no_ok, b.cara_bayar, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
			// 	FROM pemeriksaan_operasi b, data_pasien 
			// 	WHERE b.no_medrec=data_pasien.no_medrec AND b.no_ok is not NULL AND b.cetak_kwitansi ='0'  and b.cara_bayar <> 'BPJS'
			// 	GROUP BY no_ok 
			// 	UNION 
			// 	SELECT pasien_luar.no_register as no_cm, b.no_ok, 'UMUM' as cara_bayar, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama as nama, count(1) AS banyak 
			// 	FROM pemeriksaan_operasi b, pasien_luar 
			// 	WHERE b.no_medrec=pasien_luar.no_register AND b.no_ok is not NULL AND b.cetak_kwitansi='0' 
			// 	GROUP BY no_ok");

				return $this->db->query("SELECT data_pasien.no_cm as no_cm, b.no_ok, b.cara_bayar, b.tgl_kunjungan AS tgl, 
				b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_operasi b, data_pasien WHERE b.no_medrec=data_pasien.no_medrec 
				AND b.no_ok is not NULL AND b.cetak_kwitansi is null and b.cara_bayar <> 'BPJS' 
				GROUP BY no_ok,no_cm,b.cara_bayar,tgl,b.no_register,b.no_medrec,data_pasien.nama
				");

// UNION 
// SELECT pasien_luar.no_register as no_cm, b.no_ok, 'UMUM' as cara_bayar,
// b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama as nama, 
// count(1) AS banyak FROM pemeriksaan_operasi b, pasien_luar 
// WHERE b.no_medrec=CAST(pasien_luar.no_register AS INTEGER) AND b.no_ok is not NULL 
// AND b.cetak_kwitansi is null GROUP BY no_ok,pasien_luar.no_register,tgl,b.no_register,b.no_medrec,nama

		}

		function get_list_dp($date){
			
			return $this->db->query("SELECT a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, irna_antrian c 
					where a.no_reservasi=c.noreservasi
					and a.tgl_jadwal_ok= '$date'
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, pasien_iri c
					where a.tgl_jadwal_ok= '$date'
					and a.no_register=c.no_ipd
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, daftar_ulang_irj c
					where a.tgl_jadwal_ok= '$date'
					and a.no_register=c.no_register
					and b.no_medrec=c.no_medrec
					UNION 
					select a.*, b.nama, b.no_register as no_cm, 'UMUM' as cara_bayar, (select nm_dokter from data_dokter where b.dokter = data_dokter.id_dokter) as nm_dokter, 'PL' as nm_ruang from operasi_header a, pasien_luar b where a.tgl_jadwal_ok= '$date' and a.no_register = b.no_register");

		}


	function get_list_dp_by_key(){
			
			return $this->db->query("SELECT a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, irna_antrian c 
					where a.no_reservasi=c.noreservasi
					and a.status=0 and LEFT(a.tgl_jadwal_ok,10) = LEFT(NOW(), 10)
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, pasien_iri c
					where a.status=0 and LEFT(a.tgl_jadwal_ok,10) = LEFT(NOW(), 10)
					and a.no_register=c.no_ipd
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, daftar_ulang_irj c
					where a.status=0 and LEFT(a.tgl_jadwal_ok,10) = LEFT(NOW(), 10)
					and a.no_register=c.no_register
					and b.no_medrec=c.no_medrec
					UNION 
					select a.*, b.nama, b.no_register as no_cm, 'UMUM' as cara_bayar, (select nm_dokter from data_dokter where b.dokter = data_dokter.id_dokter) as nm_dokter, 'PL' as nm_ruang from operasi_header a, pasien_luar b where a.status = 0  and LEFT(a.tgl_jadwal_ok,10) = LEFT(NOW(), 10) and a.no_register = b.no_register");

		}



		function get_data_pasien($no_ok){
			// return $this->db->query("SELECT data_pasien.sex, data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, operasi_header.dp, operasi_header.diskon FROM pemeriksaan_operasi a, data_pasien, operasi_header WHERE a.no_medrec=data_pasien.no_medrec AND operasi_header.no_register = a.no_register and a.no_ok='$no_ok' GROUP BY a.no_register UNION 
			// 	SELECT pasien_luar.jk as sex, pasien_luar.no_register as no_cm, pasien_luar.no_register as no_medrec, a.no_register, pasien_luar.nama, pasien_luar.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, operasi_header.dp, operasi_header.diskon FROM pemeriksaan_operasi a, pasien_luar, operasi_header WHERE a.no_medrec=pasien_luar.no_register AND operasi_header.no_register = a.no_register and a.no_ok='$no_ok' GROUP BY a.no_register");

		return $this->db->query("SELECT data_pasien.tgl_lahir, data_pasien.sex,data_pasien.no_identitas, data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, 
		data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, 
		a.cara_bayar, a.idrg as ruang, operasi_header.dp, operasi_header.diskon 
		FROM pemeriksaan_operasi a, data_pasien, operasi_header 
		WHERE a.no_medrec=data_pasien.no_medrec 
		AND operasi_header.no_register = a.no_register and a.no_ok='$no_ok'
		 ");

// UNION 
// SELECT pasien_luar.tgl_kunjungan,pasien_luar.jk as sex, pasien_luar.no_register 
// as no_cm, CAST(pasien_luar.no_register AS INTEGER) as no_medrec, a.no_register, 
// pasien_luar.nama, pasien_luar.alamat as alamat, a.tgl_kunjungan as tgl, 
// a.kelas, a.cara_bayar, a.idrg as ruang, operasi_header.dp, operasi_header.diskon 
// FROM pemeriksaan_operasi a, pasien_luar, operasi_header 
// WHERE a.no_medrec=CAST(pasien_luar.no_register AS INTEGER) AND operasi_header.no_register = a.no_register 
// and a.no_ok='$no_ok'
		}

		function get_data_pemeriksaan($no_ok){
			return $this->db->query("SELECT jenis_tindakan, biaya_ok, qty, vtot FROM pemeriksaan_operasi WHERE no_ok='$no_ok'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_ok, $diskon, $total_bayar, $tunai, $no_register, $xuser){
			$today = date('Y-m-d H:i:s');
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_operasi SET cetak_kwitansi='1', tgl_cetak = '$today' WHERE no_ok='$no_ok'");
		//	$this->db->query("UPDATE ok_header SET diskon='$diskon' WHERE no_ok='$no_ok'");
			
			$this->db->query("UPDATE operasi_header SET tgl_cetak_kw='".date('Y-m-d')."', diskon='$diskon', total_bayar='$total_bayar', tunai='$tunai' WHERE idoperasi_header='$no_ok'");
			$this->db->query("UPDATE daftar_ulang_irj SET ok='0', status_ok='1' , diskon='$diskon' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET ok='0', status_ok='1' WHERE no_ipd='$no_register'");
			return true;
		}

		public function get_no_kwitansi($jenis_kwitansi='OK', $no_register=null)
		{
			if ($no_register != null ) {
				$this->db->where('no_registrasi', $no_register);
			}

			$cek = $this->db->select('*')->from('no_kwitansi')->where('jenis_kwitansi', $jenis_kwitansi)->order_by('no_kwitansi', 'DESC')->get();

			if ($cek->num_rows() > 0) {
				return $cek;
			}else{
				return false;
			}
		}

		public function insert_no_kwitansi($data)
		{
			$this->db->insert('no_kwitansi',$data);
		}

		public function insert_nomorkwitansi($data){
			return $this->db->insert('nomor_kwitansi', $data);
		}

		public function get_no_kwitansi_loket($idloket){
			return $this->db->query("SELECT NULLIF(MAX(idno_kwitansi),000000) as no_kwitansi from no_kwitansi");
		}

		public function get_row_noKwitansi_by_register($no_register)
		{
			return $this->db->query("SELECT * FROM no_kwitansi WHERE no_register = '".$no_register."' and LEFT(no_kwitansi,2) = 'RJ' ");
		}
		
	  function get_dp_ok($tgllok){

	  	if($tglok!=''){
			$txtok="and a.tgl_jadwal_ok='".$tglok."'";
		//	print_r($txtok);die();
		}else{
			$tglok = date('Y-m-d');
			$txtok="and a.tgl_jadwal_ok='".$tglok."'";
		}
		return $this->db->query("select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, irna_antrian c 
					where a.no_reservasi=c.noreservasi
					and a.status=0
					$txtok
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.carabayar as cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, pasien_iri c
					where a.status=0
					$txtok
					and a.no_register=c.no_ipd
					and b.no_medrec=c.no_cm
					UNION
					select a.*, b.nama, b.no_cm, c.cara_bayar, 
					(select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter,
					(select nmruang from ruang where idrg=a.idkamar_operasi) as nm_ruang
					from operasi_header a, data_pasien b, daftar_ulang_irj c
					where a.status=0
					$txtok
					and a.no_register=c.no_register
					and b.no_medrec=c.no_medrec 
					UNION 
					select a.*, b.nama, b.no_register as no_cm, 'UMUM' as cara_bayar, 
					(select nm_dokter from data_dokter where b.dokter = data_dokter.id_dokter) as nm_dokter, 
					'PL' as nm_ruang 
					from operasi_header a, pasien_luar b where a.status = 0
					 $txtok and a.no_register = b.no_register");
	   }



	}


?>