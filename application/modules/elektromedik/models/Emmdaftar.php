<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Emmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for emcdaftar
		function get_daftar_pasien_em($awal, $akhir) {
			return $this->db->query("SELECT
				pemeriksaan_em.no_register ,
				data_pasien.no_cm as no_medrec ,
				pemeriksaan_em.tgl_kunjungan ,
				pemeriksaan_em.jadwal_em ,
				pemeriksaan_em.kelas ,
				pemeriksaan_em.idrg ,
				pemeriksaan_em.bed ,					
				pemeriksaan_em.nama as nama
			FROM
				pemeriksaan_em ,
				data_pasien
			WHERE
				pemeriksaan_em.no_medrec = data_pasien.no_medrec
				AND pemeriksaan_em.em = '1'
				AND to_char(pemeriksaan_em.jadwal_em,'YYYY-MM-DD') BETWEEN '$awal' AND '$akhir'
			ORDER BY
				pemeriksaan_em.jadwal_em DESC");
		}

		function get_daftar_pasien_em_by_date($date) {
			return $this->db->query("SELECT 
				pemeriksaan_em.no_register, 
				data_pasien.no_cm as no_medrec, 
				pemeriksaan_em.tgl_kunjungan, 
				pemeriksaan_em.jadwal_em ,
				pemeriksaan_em.kelas, 
				pemeriksaan_em.idrg, 
				pemeriksaan_em.bed, 
				data_pasien.nama as nama 
			FROM 
				pemeriksaan_em, 
				data_pasien 
			WHERE 
				pemeriksaan_em.no_medrec=data_pasien.no_medrec 
				and pemeriksaan_em.em = '1' 
				AND to_char(pemeriksaan_em.jadwal_em,'YYYY-MM-DD')='$date'");
		}

		function get_daftar_pasien_em_by_no($key) {
			return $this->db->query("SELECT 
				pemeriksaan_em.no_register, 
				data_pasien.no_cm as no_medrec, 
				pemeriksaan_em.tgl_kunjungan, 
				pemeriksaan_em.kelas, 
				pemeriksaan_em.idrg,
				pemeriksaan_em.bed, 
				data_pasien.nama as nama,
				pemeriksaan_em.jadwal_em
			FROM 
				pemeriksaan_em, 
				data_pasien 
			WHERE 
				pemeriksaan_em.no_medrec=data_pasien.no_medrec 
				and pemeriksaan_em.em = '1' 
				AND (pemeriksaan_em.nama LIKE '%$key%' OR pemeriksaan_em.nocm LIKE '%$key%')
			ORDER BY
				pemeriksaan_em.jadwal_em DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_em, data_pasien WHERE pemeriksaan_em.no_medrec=data_pasien.no_medrec AND pemeriksaan_em.no_register='$no_register'");
			//return $this->db->query("SELECT * FROM pemeriksaan_elektromedik, data_pasien WHERE pemeriksaan_elektromedik.no_medrec=data_pasien.no_medrec AND pemeriksaan_elektromedik.no_register='$no_register'");
			// return $this->db->query("SELECT
			// daftar_ulang_irj.*, data_pasien.nama, data_pasien.no_cm, data_pasien.foto
			// FROM
			// 	daftar_ulang_irj,
			// 	data_pasien 
			// WHERE
			// 	daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			// 	AND daftar_ulang_irj.no_register = '$no_register'");
		}

		function get_kontraktor_kerjasama() {
			return $this->db->query("SELECT * FROM kontraktor WHERE bpjs = 'KERJASAMA'");
		}

		function get_data_pasien_iri_pemeriksaan($no_register){
			//return $this->db->query("SELECT * FROM pemeriksaan_em, data_pasien WHERE pemeriksaan_em.no_medrec=data_pasien.no_medrec AND pemeriksaan_em.no_register='$no_register'");
			//return $this->db->query("SELECT * FROM pemeriksaan_elektromedik, data_pasien WHERE pemeriksaan_elektromedik.no_medrec=data_pasien.no_medrec AND pemeriksaan_elektromedik.no_register='$no_register'");
			return $this->db->query("SELECT
			pasien_iri.*, data_pasien.nama, data_pasien.no_cm, data_pasien.foto
			FROM
				pasien_iri,
				data_pasien 
			WHERE
				pasien_iri.no_medrec = data_pasien.no_medrec 
				AND pasien_iri.no_ipd = '$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM  pasien_luar WHERE  pasien_luar.no_register='$no_register'");
			// return $this->db->query("SELECT * FROM pemeriksaan_elektromedik, pasien_luar WHERE pemeriksaan_elektromedik.no_register=pasien_luar.no_register AND pemeriksaan_elektromedik.no_register='$no_register'");
		}

		function get_jenis_em(){
			return $this->db->query("SELECT je.kode_jenis, je.nama_jenis FROM  jenis_tindakan_em jte LEFT JOIN jenis_em je
			ON jte.idpok2=je.kode_jenis 
			GROUP BY je.kode_jenis, je.nama_jenis");
		}

		function get_ttd_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter where id_dokter = '$id_dokter' ");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function get_data_pemeriksaan_by_reg($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik WHERE no_register='$no_register' and no_em is null ");
		}

		function get_data_pemeriksaan($no_medrec){
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik WHERE no_medrec='$no_medrec' ");
		}

		function get_data_diagnosa_rj($no_register){
			return $this->db->query("SELECT b.id_icd as id_diagnosa, concat(b.id_icd, ' - ', b.nm_diagnosa) as diagnosa FROM daftar_ulang_irj as a left join icd1 as b on a.diagnosa=b.id_icd WHERE no_register='$no_register'");
		}

		function get_data_diagnosa_ri($no_ipd){
			return $this->db->query("SELECT b.id_icd as id_diagnosa , concat(b.id_icd , ' - ' , b.nm_diagnosa) as diagnosa FROM pasien_iri as a left join icd1 as b on a.diagmasuk = b.id_icd WHERE no_ipd='$no_ipd'");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_em where pemeriksaan_em.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_em.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_em order by nmtindakan");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif, tarif_iks, tarif_bpjs FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function getdata_dokter_isi($id_dokter){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter as a where a.id_dokter = '$id_dokter' ");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter,a.deleted FROM data_dokter
			as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Elektromedik' and a.deleted != '1' or b.id_poli='BZ02' ");			
		}

		function get_row_register_by_noem($no_em){
			return $this->db->query("SELECT no_register FROM pemeriksaan_elektromedik WHERE no_em='$no_em' LIMIT 1");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter=$id_dokter");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_elektromedik', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL_header($no_register,$getvtotem,$no_em){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em' WHERE no_register='$no_register'");
			// $this->db->query("UPDATE pasien_luar SET em=0, vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotem,$no_em,$tglkunjung,$userid){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em',tgl_kunjungan = '$tglkunjung', xuser='$userid' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET em=0, vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ_header($no_register,$getvtotem,$no_em){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em' WHERE no_register='$no_register' and no_em is null ");
			// $this->db->query("UPDATE daftar_ulang_irj SET em=0, status_em=1, vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotem,$no_em,$status,$tglkunjung){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em',tgl_kunjungan = '$tglkunjung', xuser='$userid' WHERE no_register='$no_register' and no_em is null ");
			$this->db->query("UPDATE daftar_ulang_irj SET em=0, status_em='$status', vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD_header($no_register,$getvtotem,$no_em){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em' WHERE no_register='$no_register' and no_em is null ");
			// $this->db->query("UPDATE daftar_ulang_irj SET em=0, status_em=1, vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotem,$no_em,$status,$tglkunjung){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em',tgl_kunjungan = '$tglkunjung', xuser='$userid' WHERE no_register='$no_register' and no_em is null ");
			$this->db->query("UPDATE daftar_ulang_irj SET em=0, status_em='$status', vtot_em='$getvtotem' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI_header($no_register,$getvtotem,$no_em){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em' WHERE no_register='$no_register' and no_em is null ");
			// $this->db->query("UPDATE pasien_iri SET em=0, status_em=1, vtot_em='$getvtotem' WHERE no_ipd='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$getvtotem,$no_em,$status,$tglkunjung){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET no_em='$no_em',tgl_kunjungan = '$tglkunjung', xuser='$userid' WHERE no_register='$no_register' and no_em is null ");
			$this->db->query("UPDATE pasien_iri SET em=0, status_em='$status', vtot_em='$getvtotem' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_em FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function getdata_rj($no_register){
			return $this->db->query("SELECT status_em FROM daftar_ulang_irj WHERE no_register='".$no_register."'");
		}

		function get_vtot_em($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_em FROM pemeriksaan_elektromedik WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_em($no_em){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_em FROM pemeriksaan_elektromedik WHERE no_em='".$no_em."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_em){
			$this->db->where('id_pemeriksaan_em', $id_pemeriksaan_em);
       		$this->db->delete('pemeriksaan_elektromedik');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO em_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_em FROM em_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_em DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$tahun = date('Y');
			$depan = substr($tahun,2,2);
			$this->db->set('no_register',"(select 'PLE".$depan."' || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM pasien_luar where \"jenis_PL\" = 'EM' ), '000000') as int) +1 as varchar),6) as id)", FALSE);
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(to_char(now(),'YYYY'),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(to_char(now(),'YYYY'),3,2))");
		}


		//modul for emcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_em(){
			// return $this->db->query("SELECT nama, a.no_em, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=a.no_em AND hasil_pemeriksaan_em.id_hasil_em !='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			// FROM pemeriksaan_elektromedik a, data_pasien 
			// WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_em is not null AND left(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
			// GROUP BY no_em
			// UNION
			// SELECT nama, b.no_em, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=b.no_em AND hasil_pemeriksaan_em.id_hasil_em !='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_em as vtot 
			// FROM pemeriksaan_elektromedik b, pasien_luar 
			// WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_em is not null AND left(b.tgl_kunjungan,10)=LEFT(NOW(),10) 
			// GROUP BY no_em ORDER BY tgl asc");

			return $this->db->query("SELECT nama, a.no_em, a.cara_bayar, a.no_register, a.tgl_kunjungan 
			as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) 
										 AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em 
										 WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em 
										 AND pemeriksaan_elektromedik.no_em=a.no_em 
										 AND hasil_pemeriksaan_em.id_hasil_em !=0) as selesai, cetak_kwitansi, sum(vtot) as vtot ,a.no_medrec,
							CASE 
								WHEN(substr(a.no_register,1,2) = 'RI') THEN (SELECT kontraktor.nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor = kontraktor.id_kontraktor AND a.no_register = pasien_iri.no_ipd LIMIT 1)
								WHEN (substr(a.no_register,1,2) = 'RJ') THEN (SELECT kontraktor.nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor = kontraktor.id_kontraktor AND a.no_register = daftar_ulang_irj.no_register LIMIT 1)
							END AS kontraktor
						FROM pemeriksaan_elektromedik a, data_pasien 
						WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_em is not null 
						AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')=to_char(NOW(),'YYYY-MM-DD') 
						and substring(a.no_register,1,2) != 'PL'
						GROUP BY no_em,nama,a.cara_bayar,a.no_register, a.tgl_kunjungan,cetak_kwitansi,a.no_medrec

						UNION
						SELECT nama, b.no_em, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, 
						(SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil 
						 FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em 
						 WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em 
						 AND pemeriksaan_elektromedik.no_em=b.no_em 
						 AND hasil_pemeriksaan_em.id_hasil_em !=0) as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi,
						 vtot_em as vtot ,b.no_medrec,
						 'Pasien Luar' AS kontraktor
						FROM pemeriksaan_elektromedik b, pasien_luar 
						WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_em is not null 
						AND to_char(b.tgl_kunjungan,'YYYY-MM-DD')=to_char(NOW(),'YYYY-MM-DD') 
						and substring(b.no_register,1,2) = 'PL'
						GROUP BY no_em,nama,b.cara_bayar,b.no_register, b.tgl_kunjungan,pasien_luar.cetak_kwitansi,vtot_em,b.no_medrec ORDER BY tgl asc");
		}

		function get_hasil_em_by_date($date){
			return $this->db->query("SELECT nama, a.no_em, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=a.no_em AND hasil_pemeriksaan_em.id_hasil_em is not null) as selesai, cetak_kwitansi, sum(vtot) as vtot ,a.no_medrec
			FROM pemeriksaan_elektromedik a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_em is not null AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')='$date'
			and substring(a.no_register,1,2) != 'PL'
			GROUP BY no_em ,nama,a.cara_bayar, a.no_register,tgl,cetak_kwitansi,a.no_medrec
			UNION
			SELECT nama, b.no_em, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=b.no_em AND hasil_pemeriksaan_em.id_hasil_em is not null) as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_em as vtot ,b.no_medrec
			FROM pemeriksaan_elektromedik b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_em is not null AND to_char(b.tgl_kunjungan,'YYYY-MM-DD')='$date'
			GROUP BY no_em ,nama,b.cara_bayar, b.no_register,tgl, pasien_luar.cetak_kwitansi,vtot_em,b.no_medrec ORDER BY tgl asc");
		}

		function get_hasil_em_by_no($key){
			return $this->db->query("SELECT nama, a.no_em, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=a.no_em AND hasil_pemeriksaan_em.id_hasil_em is not null) as selesai, cetak_kwitansi, sum(vtot) as vtot ,a.no_medrec
			FROM pemeriksaan_elektromedik a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_em is not null and (data_pasien.nama LIKE '%$key%' OR data_pasien.no_cm LIKE '%$key%')
			GROUP BY no_em ,nama,a.cara_bayar, a.no_register,tgl,cetak_kwitansi,a.no_medrec
			UNION
			SELECT nama, b.no_em, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_pemeriksaan_em.id_hasil_em) AS hasil FROM pemeriksaan_elektromedik,hasil_pemeriksaan_em WHERE pemeriksaan_elektromedik.id_pemeriksaan_em=hasil_pemeriksaan_em.id_pemeriksaan_em AND pemeriksaan_elektromedik.no_em=b.no_em AND hasil_pemeriksaan_em.id_hasil_em is not null) as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_em as vtot ,b.no_medrec
			FROM pemeriksaan_elektromedik b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_em is not null and (pasien_luar.nama LIKE '%$key%' OR CAST(pasien_luar.no_cm AS VARCHAR) LIKE '%$key%')
			GROUP BY no_em ,nama,b.cara_bayar, b.no_register,tgl, pasien_luar.cetak_kwitansi,vtot_em,b.no_medrec ORDER BY tgl asc");
		}

		function getrow_hasil_em($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik, data_pasien WHERE pemeriksaan_elektromedik.no_medrec=data_pasien.no_medrec AND pemeriksaan_elektromedik.no_register='".$no_register."' ");
		}	

		function get_data_pengisian_hasil($no_em){
			return $this->db->query("SELECT a.*, c.id_hasil_em  FROM pemeriksaan_elektromedik as a LEFT JOIN hasil_pemeriksaan_em AS c ON a.id_pemeriksaan_em=c.id_pemeriksaan_em WHERE a.no_em='".$no_em."' ORDER BY a.no_em");
		}

		function get_banyak_hasil_em($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_elektromedik WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_em){
			return $this->db->query("SELECT *, to_char(pemeriksaan_elektromedik.tgl_kunjungan, 'YYYY-MM-DD') as tgl FROM pemeriksaan_elektromedik, data_pasien WHERE pemeriksaan_elektromedik.no_medrec=data_pasien.no_medrec AND pemeriksaan_elektromedik.no_em='$no_em' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_em){
			return $this->db->query("SELECT *, to_char(pemeriksaan_elektromedik.tgl_kunjungan, 'YYYY-MM-DD') as tgl FROM pemeriksaan_elektromedik, pasien_luar WHERE pemeriksaan_elektromedik.no_register=pasien_luar.no_register AND pemeriksaan_elektromedik.no_em='$no_em' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_em){
			return $this->db->query("SELECT a.*,b.no_cm AS no_cm,b.nama AS nama,b.foto AS foto,to_char (a.tgl_kunjungan,'YYYY-MM-DD') AS tgl,c.*,e.kode_jenis, b.alamat, b.tgl_lahir, b.sex
			FROM pemeriksaan_elektromedik AS a 
			LEFT JOIN data_pasien AS b ON a.no_medrec=b.no_medrec 
			LEFT JOIN hasil_pemeriksaan_em AS c ON a.id_pemeriksaan_em=c.id_pemeriksaan_em 
			LEFT JOIN jenis_tindakan_em as d on a.id_tindakan = d.idtindakan
			LEFT JOIN jenis_em as e on d.idkel_tind = e.kode_jenis
			WHERE a.id_pemeriksaan_em='$id_pemeriksaan_em'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_em){
			return $this->db->query("SELECT a.*,b.no_cm AS no_cm,b.alamat,b.dokter,b.nama AS nama,to_char (a.tgl_kunjungan,'YYYY-MM-DD') AS tgl,
			c.*,e.kode_jenis, b.usia, b.jk FROM pemeriksaan_elektromedik AS a LEFT JOIN pasien_luar AS b ON a.no_medrec=b.no_cm 
			LEFT JOIN hasil_pemeriksaan_em AS c ON a.id_pemeriksaan_em=c.id_pemeriksaan_em 			 
			LEFT JOIN jenis_tindakan_em as d on a.id_tindakan = d.idtindakan
			LEFT JOIN jenis_em as e on d.idkel_tind = e.kode_jenis WHERE a.id_pemeriksaan_em='$id_pemeriksaan_em'");
		}

		function get_data_tindakan_em($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_em.* FROM jenis_hasil_em, jenis_tindakan WHERE  jenis_hasil_em.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function get_data_tindakan_em_id($id_pemeriksaan_em){
			return $this->db->query("SELECT
										*
									FROM
										pemeriksaan_elektromedik
									WHERE
										id_pemeriksaan_em = '$id_pemeriksaan_em'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_em', $data);
			return true;	
		}

		function update_hasil($id_pemeriksaan_em, $data){
			$this->db->where('id_pemeriksaan_em', $id_pemeriksaan_em);
			$this->db->update('hasil_pemeriksaan_em', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_em, $data){
			$this->db->where('id_pemeriksaan_em', $id_pemeriksaan_em);
			$this->db->update('pemeriksaan_elektromedik', $data);
			return true;
		}

		function edit_diag_masuk_rj($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}

		function edit_diag_masuk_ri($no_ipd, $data){
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}



		function get_row_register($id_pemeriksaan_em){
			return $this->db->query("SELECT no_register FROM pemeriksaan_elektromedik WHERE id_pemeriksaan_em='$id_pemeriksaan_em'");
		}

		function get_data_edit_tindakan_em($id_pemeriksaan_em, $no_em){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_em WHERE  id_pemeriksaan_em='$id_pemeriksaan_em' AND no_em='$no_em'");
		}

		function get_no_register($no_em){
			return $this->db->query("SELECT no_register FROM pemeriksaan_elektromedik WHERE  no_em='$no_em' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_em){
			return $this->db->query("UPDATE hasil_pemeriksaan_em SET hasil_em='$hasil_em' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_em){
			$this->db->query("UPDATE pemeriksaan_elektromedik SET cetak_hasil='1' where no_em='$no_em'");
			return true;
		}

		function get_dokter_pengirim_rj($no_register) {
			return $this->db->query("SELECT
				b.nm_dokter 
			FROM
				daftar_ulang_irj AS A,
				data_dokter AS b 
			WHERE
				A.id_dokter = b.id_dokter 
				AND A.no_register = '$no_register'");	
		}

		function get_dokter_pengirim_ri($no_register) {
			return $this->db->query("SELECT dokter FROM pasien_iri WHERE no_ipd = '$no_register'");
		}

		function get_data_hasil_em($no_em){
			return $this->db->query("SELECT a.id_tindakan,a.no_em,a.jenis_tindakan,a.hasil_periksa,b.* FROM pemeriksaan_elektromedik AS a LEFT JOIN hasil_pemeriksaan_em AS b ON a.id_pemeriksaan_em=b.id_pemeriksaan_em WHERE a.no_em='$no_em'");
		}

		function get_data_hasil_em_pertindakan($id_pemeriksaan_em){
			return $this->db->query("SELECT a.*,b.*,e.kode_jenis FROM pemeriksaan_elektromedik AS a LEFT JOIN hasil_pemeriksaan_em AS b ON a.id_pemeriksaan_em=b.id_pemeriksaan_em LEFT JOIN jenis_tindakan_em as d on a.id_tindakan = d.idtindakan LEFT JOIN jenis_em as e on d.idkel_tind = e.kode_jenis WHERE a.id_pemeriksaan_em='$id_pemeriksaan_em'");
		}

		function get_gambar_hasil_em($id_pemeriksaan_em){
			return $this->db->query("SELECT a.name, a.id_pemeriksaan_em FROM hasil_pemeriksaan_em_detail AS a LEFT JOIN hasil_pemeriksaan_em AS b ON a.id_pemeriksaan_em=b.id_pemeriksaan_em WHERE a.id_pemeriksaan_em='$id_pemeriksaan_em'");
		}

		function get_data_pasien_cetak($no_em){
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_em='$no_em'");
		}

		function get_data_pasien_luar_cetak($no_em){
			return $this->db->query("SELECT * FROM pemeriksaan_elektromedik a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_em='$no_em'");
		}

		//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_em_selesai(){
			// return $this->db->query("SELECT
			// 							nama ,
			// 							RIGHT(a.no_medrec , 6) as no_medrec ,
			// 							a.no_em ,
			// 							a.no_register ,
			// 							a.tgl_kunjungan as tgl ,
			// 							count(1) as banyak ,
			// 							(
			// 								SELECT
			// 									COUNT(hasil_periksa) as hasil
			// 								FROM
			// 									pemeriksaan_elektromedik
			// 								WHERE
			// 									no_em = a.no_em
			// 								AND hasil_periksa != ''
			// 							) as selesai ,
			// 							cetak_kwitansi ,
			// 							sum(vtot) as vtot
			// 						FROM
			// 							pemeriksaan_elektromedik a ,
			// 							data_pasien
			// 						WHERE
			// 							a.no_medrec = data_pasien.no_medrec
			// 						AND cetak_hasil = '1'
			// 						AND no_em is not null
			// 						-- AND LEFT(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
			// 						GROUP BY
			// 							no_em
			// 						ORDER BY
			// 								tgl asc ");


									return $this->db->query("SELECT
									nama ,
									a.no_medrec ,
									a.no_em ,
									a.no_register ,
									a.tgl_kunjungan as tgl ,
									count(1) as banyak ,
									(
										SELECT
											COUNT(hasil_periksa) as hasil
										FROM
											pemeriksaan_elektromedik
										WHERE
											no_em = a.no_em
										AND hasil_periksa != '0'
									) as selesai ,
									cetak_kwitansi ,
									sum(vtot) as vtot,
									data_pasien.no_hp,
									data_pasien.email,
									data_pasien.no_cm
								FROM
									pemeriksaan_elektromedik a ,
									data_pasien
								WHERE
									a.no_medrec = data_pasien.no_medrec
								AND cetak_hasil = '1'
								AND no_em is not null
								GROUP BY
									no_em,nama,RIGHT(a.no_register , 6),a.no_register,tgl,cetak_kwitansi,a.no_medrec, data_pasien.no_hp, data_pasien.email, data_pasien.no_cm
								
								UNION 
								SELECT nama, 
													a.no_medrec , a.no_em, a.no_register,
											a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) 
								as hasil FROM pemeriksaan_elektromedik 
								WHERE no_em=a.no_em AND hasil_periksa!='0') as selesai, 
								a.cetak_kwitansi, sum(vtot) as vtot, b.no_hp, b.email, CAST(b.no_cm AS VARCHAR) AS no_cm
								FROM pemeriksaan_elektromedik a, pasien_luar b 
								WHERE a.no_register=b.no_register AND cetak_hasil='1' 
								AND no_em is not null AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')=to_char(NOW(),'YYYY-MM-DD') 
								GROUP BY no_em,nama,RIGHT(a.no_register,6),a.no_register,tgl,a.cetak_kwitansi,a.no_medrec, b.no_hp, b.email, b.no_cm ");
		}

		function get_hasil_em_by_date_selesai($date){
			return $this->db->query("SELECT
										nama ,
										a.no_medrec ,
										a.no_em ,
										a.no_register ,
										a.tgl_kunjungan as tgl ,
										count(1) as banyak ,
										(
											SELECT
												COUNT(hasil_periksa) as hasil
											FROM
												pemeriksaan_elektromedik
											WHERE
												no_em = a.no_em
											AND hasil_periksa is not null
										) as selesai ,
										cetak_kwitansi ,
										sum(vtot) as vtot,
										data_pasien.no_hp,
										data_pasien.email
									FROM
										pemeriksaan_elektromedik a ,
										data_pasien
									WHERE
										a.no_medrec = data_pasien.no_medrec
									AND cetak_hasil = '1'
									AND no_em is not null 
									AND to_char(a.tgl_kunjungan,'YYYY-MM-DD')='$date'
									GROUP BY
										no_em,nama ,
										a.no_medrec ,
										a.no_register ,
										tgl,
										cetak_kwitansi,
										data_pasien.no_hp,
										data_pasien.email
									ORDER BY
											tgl asc");
		}

		function get_hasil_em_by_no_selesai($key){
			return $this->db->query("SELECT
										nama ,
										a.no_medrec  as no_medrec ,
										a.no_em ,
										a.no_register ,
										a.tgl_kunjungan as tgl ,
										count(1) as banyak ,
										(
											SELECT
												COUNT(hasil_periksa) as hasil
											FROM
												pemeriksaan_elektromedik
											WHERE
												no_em = a.no_em
											AND hasil_periksa is not null
										) as selesai ,
										cetak_kwitansi ,
										sum(vtot) as vtot,
										data_pasien.no_hp,
										data_pasien.email
									FROM
										pemeriksaan_elektromedik a ,
										data_pasien
									WHERE
										a.no_medrec = data_pasien.no_medrec
									AND cetak_hasil = '1'
									AND no_em is not null
									AND (data_pasien.nama LIKE '%$key%' OR data_pasien.no_cm LIKE '%$key%')
									GROUP BY
										no_em,nama ,
										a.no_medrec ,
										a.no_register ,
										tgl,
										cetak_kwitansi,
										data_pasien.no_hp,
										data_pasien.email
									ORDER BY
											tgl asc");
		}

		function getnm_dokter_rj($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		}

		function getnm_dokter_ri($no_register){
			return $this->db->query("SELECT dokter as nm_dokter FROM pasien_iri
				WHERE no_ipd='$no_register'");
		}

		public function insert_file_hasil($data = array()){
	        $insert = $this->db->insert_batch('hasil_pemeriksaan_em_detail',$data);
	        return $insert?true:false;
	    }

		function insert_data_soap($data){
			$this->db->insert('soap_pasien_rj', $data);
			return true;
		}
		
		function update_data_soap($id,$data){
			$this->db->where('id',$id);
			$this->db->update('soap_pasien_rj', $data);
			return true;
		}
	
		function getdata_tindakan_fisik($no_register)
		{
			return $this->db->query("SELECT *
									 FROM pemeriksaan_fisik 
									 where no_register='" . $no_register . "'");
		}

		function cek_elektromedikrj($no_register){
			return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='".$no_register."'");
		}

		function cek_elektromedik($no_register){
			return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='".$no_register."' AND DATE(tgl_input) = current_date");
		}

		function get_data_daftar_ulang($no_register){
			if(substr($no_register,0,2) == 'RJ'){
				return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register='".$no_register."'");
			}elseif (substr($no_register,0,2) == 'RI') {
				return $this->db->query("SELECT *,diagmasuk as diagnosa FROM pasien_iri WHERE no_ipd='".$no_register."'");
			}else{
				return $this->db->query("SELECT * FROM pasien_luar WHERE no_register='".$no_register."'");
			}
			
		}
		
		function get_nama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."'");
		}

		function get_nama_poli($id_poli){
			return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='".$id_poli."'");
		}
		
		function get_nama_kontraktor($id_kontraktor){
			return $this->db->query("SELECT * FROM kontraktor WHERE id_kontraktor='".$id_kontraktor."'");
		}

		function get_nama_diagnosa($id_icd){
			return $this->db->query("SELECT * FROM icd1 WHERE id_icd='".$id_icd."'");
		}

		function get_diagnosa_by_no_register_rj($no_register){
			return $this->db->query("SELECT * FROM diagnosa_pasien WHERE no_register='".$no_register."'");
		}

		function get_data_pasien_iri($no_register){
			return $this->db->query("SELECT * FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_data_pasien_luar($no_register){
			return $this->db->query("SELECT * FROM pasien_luar WHERE no_register='".$no_register."'");
		}

		function edit_dokter_pemeriksaan_em($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('pemeriksaan_elektromedik', $data);
			return true;
		}

		function get_satuan(){
			return $this->db->query("SELECT nm_satuan FROM obat_satuan ORDER BY nm_satuan ASC");
		}

		function get_obat_em(){
			return $this->db->query("SELECT * FROM gudang_inventory  a
			inner join master_obat b on a.id_obat = b.id_obat
			where a.id_gudang = '1'
			and b.id_obat = '2020' ");
		}

		function get_data_obat_resep_em($no_register){
			return $this->db->query("SELECT * FROM resep_pasien
			where no_register = '$no_register'
			and item_obat = '2020' ");
		}

		function hapus_resep_em($no_register,$id_resep_pasien){
			return $this->db->query("DELETE FROM resep_pasien
			where no_register = '$no_register'
			and id_resep_pasien = '$id_resep_pasien'
			and item_obat = '2020' ");
		}

		function get_idpoli($nm_poli){
			return $this->db->query("SELECT * FROM poliklinik where nm_poli = '$nm_poli' ");
		}

		public function get_detail_tindakan($id_tindakan){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
			and b.kelas='NK'");
		}
		function getcr_bayar_dijamin($no_register){
			return $this->db->query("SELECT a.cara_bayar as a, b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		}

		function update_tanggal_tindakan($no_register,$tgl){
			return $this->db->query("UPDATE pemeriksaan_elektromedik set tgl_tindakan = '$tgl' WHERE no_register='$no_register' and no_em is null ");				
		}
		
		function update_rujukan_penunjang_irj($data, $no_register){
			if($no_register == null){
				return false;
			}else{
				$this->db->where('no_register',$no_register);
				$this->db->update('daftar_ulang_irj', $data);
				return true;
			}						
		}
		
		function update_rujukan_penunjang_iri($data, $no_ipd){
			if($no_ipd == null){
				return false;
			}else{
				$this->db->where('no_ipd',$no_ipd);
				$this->db->update('pasien_iri', $data);
				return true;
			}						
		}

		function get_data_pasien_by_noreg($noreg){
			return $this->db->query("SELECT data_pasien.no_identitas,data_pasien.sex,TO_CHAR(data_pasien.tgl_lahir, 'YYYY-MM-DD') as tgl_lahir,cast(data_pasien.no_cm as integer) AS no_cm,a.no_medrec,a.no_register,data_pasien.nama,data_pasien.alamat AS alamat,a.tgl_kunjungan AS tgl,a.kelas,a.cara_bayar,a.idrg AS ruang FROM pemeriksaan_elektromedik a,data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_register='$noreg' limit 1 ");				
		}

		function get_data_pemeriksaan_by_noreg($noreg){
			return $this->db->query("SELECT jenis_tindakan, id_tindakan,tgl_kunjungan,xinput FROM pemeriksaan_elektromedik WHERE no_register='$noreg' and (to_char(tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD') or tgl_kunjungan is null) order by tgl_kunjungan asc ");
		}

		function get_ttd_by_userid($userid){
			return $this->db->query("SELECT name,ttd from hmis_users where userid = '$userid' ");
		}

		function batal_kunjungan($no_register){
			if(substr($no_register,0,2) == 'RJ'){
				return $this->db->query("UPDATE daftar_ulang_irj set em = '0' where no_register='$no_register' ");
			}elseif(substr($no_register,0,2) == 'RI'){
				return $this->db->query("UPDATE pasien_iri set em = '0' where no_ipd='$no_register' ");
			}else{
				return $this->db->query("DELETE FROM pasien_luar where no_register='$no_register' ");
			}

		}

		function delete_order_batal($no_register){
			return $this->db->query("DELETE FROM pemeriksaan_elektromedik where no_register = '$no_register' and no_em is null ");
		}

		function getdata_dokter_all()
		{
			return $this->db->query("SELECT * from data_dokter where klp_pelaksana = 'DOKTER' ");
		}

		function get_data_titip_iri($no_register) {
			return $this->db->query("SELECT titip, jatahklsiri FROM pasien_iri WHERE no_ipd = '$no_register'");
		}
	}
?>