<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Labmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 
				'Pasien Luar' as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				pasien_luar.nama as nama_pasien, 
				count(1) AS banyak, 
				'Pasien Luar' AS nm_poli
			FROM 
				pemeriksaan_laboratorium b, pasien_luar 
			WHERE 
				b.no_register = pasien_luar.no_register
				AND  b.cetak_kwitansi is null
				AND b.no_lab is not NULL 
				AND substr( b.no_register, 1, 2 ) = 'PL'
			GROUP BY no_lab , tgl ,b.no_register, b.no_medrec , pasien_luar.nama UNION
			SELECT 
				data_pasien.no_cm as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				data_pasien.nama as nama_pasien, 
				count(1) AS banyak, c.nm_poli
			FROM 
				pemeriksaan_laboratorium b, 
				data_pasien, 
				daftar_ulang_irj AS a, 
				poliklinik AS c
			WHERE 
				b.no_medrec=data_pasien.no_medrec 
				AND b.cara_bayar in ('UMUM','KERJASAMA')
				AND  b.cetak_kwitansi is null
				AND b.no_lab is not NULL
				and substr(b.no_register,1,2) = 'RJ'
				AND a.no_register = b.no_register 
				AND a.id_poli = c.id_poli
			GROUP BY no_lab , no_cm , tgl , b.no_register, b.no_medrec , data_pasien.nama, c.nm_poli
			ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 
				'Pasien Luar' as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				pasien_luar.nama as nama_pasien,
				count(1) AS banyak, 
				'Pasien Luar' AS nm_poli
			FROM 
				pemeriksaan_laboratorium b, pasien_luar 
			WHERE
				b.no_register = pasien_luar.no_register
				AND (b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
				AND  b.cetak_kwitansi is null
				AND b.no_lab is not NULL 
			GROUP BY no_lab , tgl ,b.no_register, b.no_medrec , pasien_luar.nama UNION
			SELECT 
				data_pasien.no_cm as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				data_pasien.nama as nama_pasien, 
				count(1) AS banyak, 
				c.nm_poli
			FROM 
				pemeriksaan_laboratorium b, 
				data_pasien, 
				daftar_ulang_irj AS a, 
				poliklinik AS c
			WHERE 
				b.no_medrec=data_pasien.no_medrec 
				AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
				AND b.cara_bayar in ('UMUM','KERJASAMA')
				AND  b.cetak_kwitansi is null
				AND b.no_lab is not NULL
				and substr(b.no_register,1,2) <> 'PL'
				AND a.no_register = b.no_register 
				AND a.id_poli = c.id_poli
			GROUP BY no_lab , no_cm , tgl , b.no_register, b.no_medrec , data_pasien.nama, c.nm_poli
			ORDER BY tgl DESC ");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 
				'Pasien Luar' as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				pasien_luar.nama as nama_pasien, 
				count(1) AS banyak, 
				'Pasien Luar' AS nm_poli
			FROM 
				pemeriksaan_laboratorium b, pasien_luar 
			WHERE 
				b.no_register = pasien_luar.no_register  
				AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD') = '$date'
				AND b.cetak_kwitansi is null 
				AND b.no_lab is not NULL 
			GROUP BY no_lab , tgl ,b.no_register, b.no_medrec , pasien_luar.nama UNION
			SELECT 
				data_pasien.no_cm as no_cm, 
				b.no_lab, 
				b.tgl_kunjungan AS tgl, 
				b.no_register, 
				b.no_medrec, 
				data_pasien.nama as nama_pasien, 
				count(1) AS banyak, 
				c.nm_poli 
			FROM 
				pemeriksaan_laboratorium b, 
				data_pasien, 
				daftar_ulang_irj AS a, 
				poliklinik AS c 
			WHERE 
				b.no_medrec = data_pasien.no_medrec 
				AND TO_CHAR(b.tgl_kunjungan,'YYYY-MM-DD') = '$date' 
				AND b.cara_bayar in ('UMUM','KERJASAMA')
				AND b.cetak_kwitansi is null
				AND b.no_lab is not NULL
				and substr(b.no_register,1,2) <> 'PL'
				AND a.no_register = b.no_register 
				AND a.id_poli = c.id_poli
			GROUP BY no_lab , no_cm , tgl , b.no_register, b.no_medrec , data_pasien.nama, c.nm_poli
			ORDER BY tgl DESC");
		}
		/////////

		function getdata_pasien_sjp($no_register){
			return $this->db->query("SELECT a.*, 
				b.no_cm, b.alamat, b.tgl_lahir, b.sex, b.nama
				FROM pemeriksaan_laboratorium as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				WHERE a.no_register='$no_register'");
		}

		function get_data_pasien($no_lab){
			return $this->db->query("SELECT 
				null as no_identitas ,
				pasien_luar.jk as sex,
				TO_CHAR(pasien_luar.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir, 
				pasien_luar.no_cm AS no_cm,
				a.no_medrec,
				a.no_register,
				pasien_luar.nama,
				pasien_luar.alamat AS alamat,
				a.tgl_kunjungan AS tgl,
				a.kelas,
				a.cara_bayar,
				'Pasien Luar' AS asal, 
				'Pasien Luar' AS ruang,
				a.idrg,
				a.bed
			FROM 
				pemeriksaan_laboratorium a,
				pasien_luar 
			WHERE 
				a.no_register=pasien_luar.no_register 
				AND no_lab='$no_lab' UNION 
			SELECT 
				data_pasien.no_identitas,
				data_pasien.sex,
				TO_CHAR(data_pasien.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir,
				cast(data_pasien.no_cm as integer) AS no_cm,
				a.no_medrec,
				a.no_register,
				data_pasien.nama,
				data_pasien.alamat AS alamat,
				a.tgl_kunjungan AS tgl,
				a.kelas,
				a.cara_bayar,
				'Pasien Luar' AS asal, 
				CASE
					WHEN (SUBSTRING(a.no_register,1,2) = 'RJ') THEN a.bed 
					ELSE a.idrg 
				END AS ruang,
				a.idrg,
				a.bed
			FROM 
				pemeriksaan_laboratorium a,
				data_pasien 
			WHERE 
				a.no_medrec=data_pasien.no_medrec 
				AND no_lab='$no_lab' 
				and substr(A.no_register,1,2) <> 'PL'");
				
		}

		function get_data_pasien_luar($no_lab){
			return $this->db->query("SELECT pasien_luar.no_cm AS no_cm,a.no_medrec,a.no_register,pasien_luar.nama,pasien_luar.alamat AS alamat,a.tgl_kunjungan AS tgl,a.kelas,a.cara_bayar,a.idrg AS ruang FROM pemeriksaan_laboratorium a,pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_lab='$$no_lab' GROUP BY no_lab UNION 
				SELECT data_pasien.no_cm AS no_cm,a.no_medrec,a.no_register,data_pasien.nama,data_pasien.alamat AS alamat,a.tgl_kunjungan AS tgl,a.kelas,a.cara_bayar,a.idrg AS ruang FROM pemeriksaan_laboratorium a,data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_lab='$$no_lab' GROUP BY no_lab");
		}

		function get_data_pemeriksaan($no_lab){
			return $this->db->query("SELECT jenis_tindakan, biaya_lab, qty, vtot FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_lab, $diskon, $no_register, $xuser){
			$today = date('Y-m-d H:i:s');
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_kwitansi='1', bayar_umum = '1', tgl_cetak = '$today' WHERE no_lab='$no_lab'");
			$this->db->query("UPDATE lab_header SET diskon='$diskon' WHERE no_lab='$no_lab'");
			return true;
		}

		function update_status_cetak_kwitansi_bynoreg($diskon, $no_register, $xuser){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_kwitansi='1', bayar_umum = '1', xuser='$xuser', xupdate=now() WHERE no_register='$no_register'");
			$this->db->query("UPDATE lab_header SET diskon='$diskon' WHERE no_register='$no_register'");
			return true;
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
			$this->db->set('no_kwitansi',"(select 'LAB".$depan."-' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_kwitansi),6) FROM no_kwitansi where jenis_kwitansi = 'Laboratorium' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			return $this->db->insert('no_kwitansi', $data);
		}

		function get_no_kwitansi($no_register){
			return $this->db->query("SELECT no_kwitansi FROM no_kwitansi where no_register ='".$no_register."' and LEFT(no_kwitansi,3) ='LAB' ");
		}

		function get_data_adm_pasien_luar(){
			return $this->db->query("SELECT * FROM jenis_tindakan where idtindakan = '1B0105' "); //1B0226
		}

		function get_detail_daful($no_register){
			return $this->db->query("SELECT *,(SELECT nm_poli from poliklinik where id_poli=daftar_ulang_irj.id_poli limit 1) as nm_poli,
			(SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter limit 1) as nm_dokter, 
			(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor limit 1) as kontraktor, 
			CASE WHEN extract('hour' from xupdate)>=7 and extract('hour' from xupdate)<=14 THEN 'Pagi' ELSE 'Sore' END as shift 
			FROM daftar_ulang_irj where no_register='$no_register' order by xupdate desc");
		}

		function update_status_piutang_lab($no_lab, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET piutang='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_laboratorium SET piutang = '1' WHERE no_lab='$no_lab'");
			$this->db->query("UPDATE lab_header SET diskon='$diskon' WHERE no_lab='$no_lab'");
			return true;
		}
		
	}
?>