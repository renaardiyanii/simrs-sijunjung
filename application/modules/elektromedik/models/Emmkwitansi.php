<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Emmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_elektromedik b, pasien_luar WHERE b.no_register=pasien_luar.no_register  AND  b.cetak_kwitansi is null AND b.no_em is not NULL GROUP BY no_em ,tgl ,b.no_register, b.no_medrec, pasien_luar.nama
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama as nama_pasien
				, count(1) AS banyak 
				FROM pemeriksaan_elektromedik b, data_pasien 
				WHERE cast(b.no_medrec as integer)=data_pasien.no_medrec AND b.cara_bayar in ('UMUM','KERJASAMA') AND b.cetak_kwitansi is null AND b.no_em is not NULL and substr(b.no_register,1,2) = 'RJ'
				GROUP BY no_em ,no_cm ,tgl, b.no_register, b.no_medrec, data_pasien.nama ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
			FROM pemeriksaan_elektromedik b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register 
			AND (b.no_register LIKE '%$key%' OR cast(b.no_medrec as text) LIKE '%$key%') 
			AND  b.cetak_kwitansi is null 
			AND b.no_em is not NULL 
			GROUP BY no_em ,tgl, b.no_register, b.no_medrec, pasien_luar.nama
							UNION 
							SELECT data_pasien.no_cm as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
							FROM pemeriksaan_elektromedik b, data_pasien 
							WHERE b.no_medrec=data_pasien.no_medrec 
							AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') 
							AND b.cara_bayar in ('UMUM','KERJASAMA')
							AND  b.cetak_kwitansi is null 
							AND b.no_em is not NULL 
							GROUP BY no_em,no_cm,tgl, b.no_register, b.no_medrec, data_pasien.nama  ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, nama, count(1) AS banyak 
			FROM pemeriksaan_elektromedik b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register 
			AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date' 
			AND  b.cetak_kwitansi is null 
			AND b.no_em is not NULL 
			GROUP BY no_em ,tgl, b.no_register, b.no_medrec, nama
							UNION 
							SELECT data_pasien.no_cm as no_cm, b.no_em, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
							FROM pemeriksaan_elektromedik b, data_pasien 
							WHERE b.no_medrec=data_pasien.no_medrec 
							AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD')='$date' 
							AND b.cara_bayar in ('UMUM','KERJASAMA')
							AND  b.cetak_kwitansi is null 
							AND b.no_em is not NULL 
							GROUP BY no_cm, no_em,tgl, b.no_register, b.no_medrec, data_pasien.nama ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_em){
			// return $this->db->query("SELECT  data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(a.tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_elektromedik a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_em='$no_em'
			// 	UNION
			// 	SELECT  'Pasien Luar' as no_cm, b.no_medrec, b.no_register, pasien_luar.nama, pasien_luar.alamat as alamat, b.tgl_kunjungan as tgl, b.kelas, b.cara_bayar, 'Pasien Luar' as ruang, datediff(now(),now()) as tgl_lahir FROM pemeriksaan_elektromedik b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND no_em='$no_em' GROUP BY no_em");


			return $this->db->query("SELECT 
			TO_CHAR(data_pasien.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir, 
			data_pasien.no_cm as no_cm, 
			a.no_medrec, 
			a.no_register, 
			data_pasien.sex , 
			data_pasien.nama, 
			data_pasien.alamat as alamat,
			 a.tgl_kunjungan as 
			tgl, 
			a.kelas, 
			a.cara_bayar, 
			a.bed as ruang,
			a.idrg as asal
			FROM pemeriksaan_elektromedik a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND no_em='$no_em'  and substr(A.no_register,1,2) <> 'PL'
			UNION
			SELECT 
			TO_CHAR(pasien_luar.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir , 
			'Pasien Luar' as no_cm,
			b.no_medrec, 
			b.no_register, 
			pasien_luar.jk as sex, 					
			pasien_luar.nama, 
			pasien_luar.alamat as alamat, 
			b.tgl_kunjungan as tgl, 
			b.kelas, 
			b.cara_bayar, 
			'Pasien Luar' as ruang,
			'Pasien Luar' as asal
			FROM pemeriksaan_elektromedik b, 
			pasien_luar WHERE b.no_register=pasien_luar.no_register AND no_em='$no_em' ");
		}

		function get_data_pemeriksaan($no_em){
			return $this->db->query("SELECT no_register,jenis_tindakan, biaya_em, qty, vtot FROM pemeriksaan_elektromedik WHERE no_em='$no_em'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}

		/////////

		function update_status_cetak_kwitansi($no_em, $diskon, $no_register, $xuser){
			$today = date('Y-m-d H:i:s');
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_elektromedik SET cetak_kwitansi='1', bayar_umum = '1', tgl_cetak = '$today' WHERE no_em='$no_em'");
			$this->db->query("UPDATE em_header SET diskon='$diskon' WHERE no_em='$no_em'");
			return true;
		}

		function update_status_cetak_kwitansi_bynoreg($diskon, $no_register, $xuser){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET cetak_kwitansi='1', bayar_umum = '1', xuser='$xuser', xupdate=now() WHERE no_register='$no_register'");
			$this->db->query("UPDATE em_header SET diskon='$diskon' WHERE no_register='$no_register'");
			return true;			
		}

		function get_data_adm_pasien_luar(){
			return $this->db->query("SELECT * FROM jenis_tindakan where idtindakan = '1B0105' ");//1B0226
		}

		public function get_detail_tindakan($id_tindakan){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
			and b.kelas='NK'");
		}

		function get_no_kwitansi_loket($idloket){
			return $this->db->query("SELECT NULLIF(MAX(idno_kwitansi),000000) as no_kwitansi from no_kwitansi");
		}

		function insert_nomorkwitansi($data){
			return $this->db->insert('nomor_kwitansi', $data);
		}

		function insert_nokwitansi($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_kwitansi',"(select 'EM".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Elektromedik' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			return $this->db->insert('no_kwitansi', $data);
		}

		function get_no_kwitansi($no_register){
			return $this->db->query("SELECT * from no_kwitansi where no_register ='".$no_register."' and LEFT(no_kwitansi,2) ='EM' ");
		}

		function get_detail_daful($no_register){
			return $this->db->query("SELECT *,(SELECT nm_poli from poliklinik where id_poli=daftar_ulang_irj.id_poli limit 1) as nm_poli,
			(SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter limit 1) as nm_dokter, 
			(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor limit 1) as kontraktor, 
			CASE WHEN extract('hour' from xupdate)>=7 and extract('hour' from xupdate)<=14 THEN 'Pagi' ELSE 'Sore' END as shift 
			FROM daftar_ulang_irj where no_register='$no_register' order by xupdate desc");
		}

		function update_status_piutang_em($no_em, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_elektromedik SET piutang = '1' WHERE no_em='$no_em'");
			$this->db->query("UPDATE em_header SET diskon='$diskon' WHERE no_em='$no_em'");
			return true;
		}
		
	}
?>
