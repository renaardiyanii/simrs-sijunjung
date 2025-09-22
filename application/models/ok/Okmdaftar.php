<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Okmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_daftar_selesaipasien_ok_by_date($date){
			return $this->db->query("SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.cara_bayar,
			    b.kelas_pasien,
			    (SELECT 
			            nm_poli
			        FROM
			            poliklinik
			        WHERE
			            id_poli = b.id_poli) AS ruang,
			    '' AS bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    daftar_ulang_irj b,
			    data_pasien c 
			where a.no_register=b.no_register
			and b.no_medrec=c.no_medrec
			and a.status=1
			AND LEFT(a.tgl_jadwal_ok,10)='$date'
			UNION ALL SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.carabayar AS cara_bayar,
			    b.klsiri,
			    (SELECT 
			            nmruang
			        FROM
			            ruang
			        WHERE
			            idrg = b.idrg) AS ruang,
			    b.bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    pasien_iri b,
			    data_pasien c
			where a.no_register=b.no_ipd
			and b.no_cm=c.no_medrec
			and a.status=1
			AND LEFT(a.tgl_jadwal_ok,10)='$date'
			");
		}

		function get_daftar_selesaipasien_ok_by_no($key){
			return $this->db->query("SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.cara_bayar,
			    b.kelas_pasien,
			    (SELECT 
			            nm_poli
			        FROM
			            poliklinik
			        WHERE
			            id_poli = b.id_poli) AS ruang,
			    '' AS bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    daftar_ulang_irj b,
			    data_pasien c 
			where a.no_register=b.no_register
			and b.no_medrec=c.no_medrec
			and a.status=1
			AND (c.nama LIKE '%$key%' OR a.no_register LIKE '%$key%')
			UNION ALL SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.carabayar AS cara_bayar,
			    b.klsiri,
			    (SELECT 
			            nmruang
			        FROM
			            ruang
			        WHERE
			            idrg = b.idrg) AS ruang,
			    b.bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    pasien_iri b,
			    data_pasien c
			where a.no_register=b.no_ipd
			and b.no_cm=c.no_medrec
			and a.status=1
			AND (c.nama LIKE '%$key%' OR a.no_register LIKE '%$key%')");
		}

		function get_vtot_id_ok($idoperasi_header){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_ok FROM pemeriksaan_operasi WHERE idoperasi_header=".$idoperasi_header);
		}

		function get_daftar_pasien_hasil_ok(){
			return $this->db->query("SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.cara_bayar,
			    b.kelas_pasien,
			    (SELECT 
			            nm_poli
			        FROM
			            poliklinik
			        WHERE
			            id_poli = b.id_poli) AS ruang,
			    '' AS bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    daftar_ulang_irj b,
			    data_pasien c 
			where a.no_register=b.no_register
			and b.no_medrec=c.no_medrec
			and a.status=1
			UNION ALL SELECT 
				a.idoperasi_header,
			    a.no_register,
			    a.tgl_jadwal_ok,
			    a.intime_jadwal_ok,
			    b.carabayar AS cara_bayar,
			    b.klsiri,
			    (SELECT 
			            nmruang
			        FROM
			            ruang
			        WHERE
			            idrg = b.idrg) AS ruang,
			    b.bed,
			    c.nama,
			    c.no_cm,
			    (Select SUM(vtot) from pemeriksaan_operasi where idoperasi_header=a.idoperasi_header) as vtot,
			    IF(a.outtime_jadwal_ok is NULL,'Belum Diinput','Sudah Diinput') as status
			FROM
			    operasi_header a,
			    pasien_iri b,
			    data_pasien c
			where a.no_register=b.no_ipd
			and b.no_cm=c.no_medrec
			and a.status=1");
		}

		function get_data_pasien_pemeriksaan_by_idokhead($id){
			return $this->db->query("SELECT
	b.*,
	a.no_reservasi,
	a.no_register,
	a.type_rawat,
 case when a.type_rawat = 'rawatjalan' then (select kelas_pasien from daftar_ulang_irj where no_register = a.no_register ) 
	ELSE  (select klsiri from pasien_iri where no_ipd = a.no_register ) end as kelas,
IF
	(
		a.no_register IS NULL,
		( SELECT carabayar FROM irna_antrian WHERE noreservasi = a.no_reservasi LIMIT 1 ),
		( SELECT carabayar FROM pasien_iri WHERE no_register = a.no_register LIMIT 1 ) 
	) AS carabayar,
	a.tgl_daftar,
	( SELECT nm_dokter FROM data_dokter WHERE id_dokter = a.id_dokter LIMIT 1 ) AS nm_dokter,
IF
	(
		a.no_register IS NULL,
		( SELECT nmruang FROM ruang WHERE idrg = ( SELECT ruangpilih FROM irna_antrian WHERE noreservasi = a.no_reservasi LIMIT 1 ) ),
		( SELECT nmruang FROM ruang WHERE idrg = ( SELECT idrg FROM pasien_iri WHERE no_register = a.no_register LIMIT 1 ) ) 
	) AS idrg,
IF
	(
		a.no_register IS NULL,
		( SELECT bed FROM irna_antrian WHERE noreservasi = a.no_reservasi LIMIT 1 ),
		( SELECT bed FROM pasien_iri WHERE no_register = a.no_register LIMIT 1 ) 
	) AS bed,
IF
	(
		a.no_register IS NOT NULL 
		AND a.type_rawat = 'rawatjalan',
		( SELECT nm_poli FROM poliklinik WHERE id_poli = ( SELECT id_poli FROM daftar_ulang_irj WHERE no_register = a.no_register ) LIMIT 1 ),
		'' 
	) AS nm_poli 
FROM
	operasi_header a,
	data_pasien b 
WHERE
	b.no_medrec =
IF
	(
		a.no_register IS NULL,
		( SELECT no_cm FROM irna_antrian WHERE noreservasi = a.no_reservasi LIMIT 1 ),
		IF(a.no_register IS NOT NULL and a.type_rawat='ruangrawat',
			( SELECT no_cm FROM pasien_iri WHERE no_ipd = a.no_register LIMIT 1 ),
			( SELECT no_medrec FROM daftar_ulang_irj WHERE no_register = a.no_register LIMIT 1 ))	
	) 
	AND a.idoperasi_header =$id  ");
		}
		
		//modul for okcdaftar
		function get_daftar_pasien_ok(){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan as tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
									FROM pemeriksaan_ok, data_pasien 
									WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec
							 order by tgl_kunjungan desc");
		}
		// AND LEFT(pemeriksaan_ok.jadwal_ok,10)=LEFT(NOW(),10)

		function get_daftar_pasien_ok_by_date($date){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
										FROM pemeriksaan_ok, data_pasien 
										WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec 
										AND LEFT(pemeriksaan_ok.jadwal_ok,10)='$date'
										ORDER BY tgl_kunjungan DESC");
		}

		function get_daftar_pasien_ok_by_no($key){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
										FROM pemeriksaan_ok, data_pasien 
										WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_ok.no_register LIKE '%$key%')");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_ok, data_pasien WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec AND pemeriksaan_ok.no_register='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_ok, pasien_luar WHERE pemeriksaan_ok.no_register=pasien_luar.no_register AND pemeriksaan_ok.no_register='$no_register'");
		}

	function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT id_pemeriksaan_ok, id_dokter2, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter2) as nm_dokter2, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak 
				FROM pemeriksaan_operasi WHERE no_register='$no_register' AND no_ok IS NULL");
		}


		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_ok where pemeriksaan_ok.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_ok.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien($kelas){
			return $this->db->query("SELECT * FROM jenis_tindakan_ok where kelas='$kelas'");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function getdata_dokter(){
			return $this->db->query("select *
			from data_dokter 
			where nm_dokter <> ''
			order by nm_dokter asc");
		}

		function getdata_perawat_anastesi(){
			return $this->db->query("select *
			from perawat_ok 
			where klp_pelaksana='PERAWAT ANASTESI' and deleted!=1
			order by nm_perawat asc");
		}

		function getdata_perawat_asisten(){
			return $this->db->query("select *
			from perawat_ok 
			where klp_pelaksana='PERAWAT OPERASI' and deleted!=1
			order by nm_perawat asc");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function get_data_item_pemeriksaan_byid($id){
				return $this->db->query("SELECT *
				from pemeriksaan_operasi a WHERE a.id_pemeriksaan_ok='$id'");
		}

		function insert_pemeriksaan($data){
			$id=$this->db->insert('pemeriksaan_operasi', $data);
			echo $this->db->last_query();
			return $id;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET ok=0, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET ok=0, status_ok=1, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET ok=0, status_ok=1, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_ok,$vtot_ok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok=IF(no_ok IS NULL, '$no_ok', no_ok) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET ok=0, status_ok='$status_ok', vtot_ok='$vtot_ok' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_ok FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_ok($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_ok FROM pemeriksaan_operasi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_ok($no_ok){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_ok FROM pemeriksaan_operasi WHERE no_ok='".$no_ok."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_ok){
			$this->db->where('id_pemeriksaan_ok', $id_pemeriksaan_ok);
       		$this->db->delete('pemeriksaan_operasi');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO ok_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_ok FROM ok_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_ok DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}
	
		function insert_detailok($data){
			$this->db->insert('operasi_header', $data);
			return $this->db->insert_id();
		}

		function getdata_kamarok(){
			return $this->db->query("SELECT * FROM ruang WHERE lokasi='Kamar Operasi'");
		}

		function get_data_pemeriksaan_byidokhead($id){
			return $this->db->query("SELECT id_pemeriksaan_ok, id_dokter2, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak,  vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter2) as nm_dokter2, (select nm_perawat from perawat_ok where id=pemeriksaan_operasi.id_dokter_asist) as nm_asist_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, (select nm_perawat from perawat_ok where id=pemeriksaan_operasi.perawat_anastesi) as perawat_anastesi, id_dokter_asist 
				FROM pemeriksaan_operasi WHERE idoperasi_header='$id' ORDER BY id_pemeriksaan_ok ASC");
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}

		function get_operasi_header_bynoreg($no_register){
				return $this->db->query("SELECT * FROM operasi_header WHERE no_register='$no_register'");
		}

		function get_operasi_header_bynoreservasi($no_reservasi){
				return $this->db->query("SELECT * FROM operasi_header WHERE no_reservasi='$no_reservasi'");
		}

		function get_operasi_header_byid($id){
				return $this->db->query("SELECT *, (select nmruang from ruang where idrg=operasi_header.idkamar_operasi) as nmruang, (select nm_dokter from data_dokter where id_dokter=operasi_header.id_dokter) as nm_dokter FROM operasi_header WHERE idoperasi_header='$id'");
		}
		//modul for okcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_ok(){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function get_hasil_ok_by_date($date){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null AND left(A.tgl_kunjungan,10)  = '$date'
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null AND left(b.tgl_kunjungan,10)  = '$date'
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function get_hasil_ok_by_no($key){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function getrow_hasil_ok($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_row_register_by_nook($no_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE no_ok='$no_ok' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi WHERE no_register='".$no_register."'  AND cetak_hasil='0' ORDER BY no_ok");
		}

		function get_banyak_hasil_ok($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.no_ok='$no_ok' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, pasien_luar WHERE pemeriksaan_operasi.no_register=pasien_luar.no_register AND pemeriksaan_operasi.no_ok='$no_ok' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_tindakan_ok($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_ok.* FROM jenis_hasil_ok, jenis_tindakan WHERE  jenis_hasil_ok.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_ok', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_ok){
			return $this->db->query("UPDATE pemeriksaan_operasi SET hasil_periksa=1 WHERE id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, pasien_luar WHERE pemeriksaan_operasi.no_register=pasien_luar.no_register AND pemeriksaan_operasi.id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_edit_tindakan_ok($id_tindakan, $no_ok){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_ok WHERE  id_tindakan='$id_tindakan' AND no_ok='$no_ok'");
		}

		function get_no_register($no_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE  no_ok='$no_ok' AND cetak_hasil='0' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_ok){
			return $this->db->query("UPDATE hasil_pemeriksaan_ok SET hasil_ok='$hasil_ok' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET cetak_hasil='1' where no_ok='$no_ok'");
			return true;
		}

		function get_jenis_ok(){
			return $this->db->query("SELECT * FROM jenis_ok");
		}

		function get_data_jenis_ok($no_ok){
			return $this->db->query("SELECT a.id_tindakan, a.no_ok, b.nmtindakan FROM hasil_pemeriksaan_ok a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_ok='$no_ok' AND hasil_ok!=''  GROUP BY id_tindakan");
		}

		function get_data_hasil_ok($id_tindakan,$no_ok){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_ok WHERE id_tindakan='$id_tindakan' AND no_ok='$no_ok' AND hasil_ok!=''");
		}

		function get_data_pasien_cetak($no_ok){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_ok='$no_ok' GROUP BY no_ok");
		}

		function get_data_pasien_luar_cetak($no_ok){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_ok='$no_ok' GROUP BY no_ok");
		}

		function update_detailok($data,$idoperasi_header){
			$this->db->where('idoperasi_header', $idoperasi_header);
			$this->db->update('operasi_header', $data);
			return true;
		}

		function update_pemeriksaan($data,$idoperasi){
			$this->db->where('id_pemeriksaan_ok', $idoperasi);			
			return $this->db->update('pemeriksaan_operasi', $data);;
		}
	}
?>