<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Fisiomdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for labcdaftar
		function get_daftar_pasien_fisio(){
			return $this->db->query("SELECT pemeriksaan_fisioterapi.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_fisioterapi.tgl_kunjungan as tgl_kunjungan, pemeriksaan_fisioterapi.kelas, pemeriksaan_fisioterapi.idrg, pemeriksaan_fisioterapi.bed, data_pasien.nama as nama  
							FROM pemeriksaan_fisioterapi, data_pasien 
							WHERE pemeriksaan_fisioterapi.no_medrec=data_pasien.no_medrec
							AND LEFT(pemeriksaan_fisioterapi.tgl_kunjungan,10)=LEFT(NOW(),10)
							order by tgl_kunjungan asc
						");
		}

		function get_daftar_pasien_fisio_by_date($date){
			return $this->db->query("SELECT pemeriksaan_fisioterapi.no_register ,
									data_pasien.no_cm as no_medrec ,
									pemeriksaan_fisioterapi.tgl_kunjungan ,
									pemeriksaan_fisioterapi.kelas ,
									pemeriksaan_fisioterapi.idrg ,
									pemeriksaan_fisioterapi.bed ,
									data_pasien.nama as nama
									FROM
									pemeriksaan_fisioterapi ,
									data_pasien
									WHERE
									pemeriksaan_fisioterapi.no_medrec = data_pasien.no_medrec
									AND
									LEFT(pemeriksaan_fisioterapi.tgl_kunjungan , 10) = '$date'
									ORDER BY
									tgl_kunjungan DESC");
		}

		function get_daftar_pasien_fisio_by_no($key){
			return $this->db->query("SELECT pemeriksaan_fisioterapi.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_fisioterapi.tgl_kunjungan, pemeriksaan_fisioterapi.kelas, pemeriksaan_fisioterapi.idrg, pemeriksaan_fisioterapi.bed, data_pasien.nama as nama  
										FROM pemeriksaan_fisioterapi, data_pasien 
										WHERE pemeriksaan_fisioterapi.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_fisioterapi.no_register LIKE '%$key%')
									UNION
										SELECT pemeriksaan_fisioterapi.no_register, pemeriksaan_fisioterapi.no_medrec, pemeriksaan_fisioterapi.tgl_kunjungan, pemeriksaan_fisioterapi.kelas, pemeriksaan_fisioterapi.idrg, pemeriksaan_fisioterapi.bed, pasien_luar.nama as nama  
										FROM pemeriksaan_fisioterapi, pasien_luar 
										WHERE pemeriksaan_fisioterapi.no_register=pasien_luar.no_register 
										AND (pasien_luar.nama LIKE '%$key%' OR pemeriksaan_fisioterapi.no_register LIKE '%$key%')
										ORDER BY tgl_kunjungan DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT *  FROM pemeriksaan_fisioterapi, data_pasien WHERE pemeriksaan_fisioterapi.no_medrec=data_pasien.no_medrec AND pemeriksaan_fisioterapi.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_irj($no_register){
			return $this->db->query("SELECT nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor AND daftar_ulang_irj.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_iri($no_register){
			return $this->db->query("SELECT nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor=kontraktor.id_kontraktor AND pasien_iri.no_ipd='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisioterapi, pasien_luar WHERE pemeriksaan_fisioterapi.no_register=pasien_luar.no_register AND pemeriksaan_fisioterapi.no_register='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio WHERE no_register='$no_register' AND no_fisio IS NULL");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_fisioterapi where pemeriksaan_fisioterapi.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_fisioterapi.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_fisio ORDER BY nmtindakan asc");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function get_roleid($userid){
			return $this->db->query("SELECT roleid from dyn_role_user where userid = '".$userid."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT  a.id_dokter, a.nm_dokter FROM data_dokter as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Patologi Klinik' or b.id_poli='HA00' and a.deleted=0");
		}

		function getnama_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function getnm_dokter($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		}

		function getcr_bayar_bpjs($no_register){
			return $this->db->query("SELECT b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		}

		function getcr_bayar_dijamin($no_register){
			return $this->db->query("SELECT a.cara_bayar as a, b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		}

		function getruang($idrg){
			return $this->db->query("SELECT nmruang FROM ruang WHERE idrg='$idrg'");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_fisio', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotfisio,$no_fisio){
			$this->db->query("UPDATE pemeriksaan_fisio SET no_fisio='$no_fisio' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET fisio=0, vtot_fisio='$getvtotfisio' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotfisio,$no_fisio){
			$this->db->query("UPDATE pemeriksaan_fisio SET no_fisio='$no_fisio' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET fisio=0, status_fisio=1, vtot_fisio='$getvtotfisio' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotfisio,$no_fisio){
			$this->db->query("UPDATE pemeriksaan_fisio SET no_fisio='$no_fisio' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET fisio=0, status_fisio=1, vtot_fisio='$getvtotfisio' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_fisio,$vtot_fisio,$no_fisio){
			$this->db->query("UPDATE pemeriksaan_fisio SET no_fisio=IF(no_fisio IS NULL, '$no_fisio', no_fisio) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET fisio=0, status_fisio='$status_fisio', vtot_fisio='$vtot_fisio' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_fisio FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_fisio($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_fisio FROM pemeriksaan_fisio WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_fisio($no_fisio){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_fisio FROM pemeriksaan_fisio WHERE no_fisio='".$no_fisio."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_fisio){
			$this->db->where('id_pemeriksaan_fisio', $id_pemeriksaan_fisio);
       		$this->db->delete('pemeriksaan_fisio');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO fisio_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_fisio FROM fisio_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_fisio DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for labcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_fisio(){
			return $this->db->query("SELECT nama, a.no_fisio, a.cara_bayar, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_fisio is not null
			GROUP BY no_fisio
			UNION
			SELECT nama, b.no_fisio, b.cara_bayar, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=b.no_fisio AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_fisio as vtot 
			FROM pemeriksaan_fisio b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_fisio is not null
			GROUP BY no_fisio ORDER BY tgl asc");
		}

		function get_hasil_fisio_by_date($date){
			return $this->db->query("SELECT nama, a.no_fisio, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_fisio is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_fisio
			UNION
			SELECT nama, b.no_fisio, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=b.no_fisio AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_fisio as vtot 
			FROM pemeriksaan_fisio b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_fisio is not null AND left(b.tgl_kunjungan,10)  = '$date'
			GROUP BY no_fisio ORDER BY tgl asc");
		}

		function get_hasil_fisio_by_no($key){
			return $this->db->query("SELECT nama, a.no_fisio, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_fisio is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_fisio
			UNION
			SELECT nama, b.no_fisio, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=b.no_fisio AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_fisio as vtot 
			FROM pemeriksaan_fisio b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_fisio is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_fisio ORDER BY tgl asc");
		}

		function getrow_hasil_fisio($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio, data_pasien WHERE pemeriksaan_fisio.no_medrec=data_pasien.no_medrec AND pemeriksaan_fisio.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_fisio){
			return $this->db->query("SELECT no_register FROM pemeriksaan_fisio WHERE id_pemeriksaan_fisio='$id_pemeriksaan_fisio'");
		}

		function get_row_register_by_nofisio($no_fisio){
			return $this->db->query("SELECT no_register FROM pemeriksaan_fisio WHERE no_fisio='$no_fisio' LIMIT 1");
		}

		function get_row_hasil($no_fisio){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_fisio WHERE no_fisio='$no_fisio' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_fisio){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio WHERE no_fisio='".$no_fisio."'  AND cetak_hasil='0' ORDER BY no_fisio");
		}

		function get_isi_hasil($no_fisio){
			return $this->db->query("SELECT a.id_tindakan, a.jenis_tindakan, b.* FROM pemeriksaan_fisio as a 
				LEFT JOIN jenis_hasil_fisio as b ON a.id_tindakan=b.id_tindakan 
				WHERE a.no_fisio='".$no_fisio."' ORDER BY a.id_tindakan");
		}

		function get_edit_hasil($no_fisio){
			return $this->db->query("SELECT a.*, b.nmtindakan FROM hasil_pemeriksaan_fisio as a LEFT JOIN jenis_tindakan as b ON a.id_tindakan=b.idtindakan WHERE no_fisio='".$no_fisio."'");
		}

		function get_banyak_hasil_fisio($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_fisio){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_fisio.tgl_kunjungan, 10) as tgl FROM pemeriksaan_fisio, data_pasien WHERE pemeriksaan_fisio.no_medrec=data_pasien.no_medrec AND pemeriksaan_fisio.no_fisio='$no_fisio' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_fisio){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_fisio.tgl_kunjungan, 10) as tgl FROM pemeriksaan_fisio, pasien_luar WHERE pemeriksaan_fisio.no_register=pasien_luar.no_register AND pemeriksaan_fisio.no_fisio='$no_fisio' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_fisio){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_fisio.tgl_kunjungan, 10) as tgl FROM pemeriksaan_fisio, data_pasien WHERE pemeriksaan_fisio.no_medrec=data_pasien.no_medrec AND pemeriksaan_fisio.id_pemeriksaan_fisio='$id_pemeriksaan_fisio'");
		}

		function get_data_tindakan_fisio($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_fisio.* FROM jenis_hasil_fisio, jenis_tindakan WHERE  jenis_hasil_fisio.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_fisio', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_fisio){
			return $this->db->query("UPDATE pemeriksaan_fisio SET hasil_periksa=1 WHERE id_pemeriksaan_fisio='$id_pemeriksaan_fisio'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_fisio){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_fisio.tgl_kunjungan, 10) as tgl FROM pemeriksaan_fisio, pasien_luar WHERE pemeriksaan_fisio.no_register=pasien_luar.no_register AND pemeriksaan_fisio.id_pemeriksaan_fisio='$id_pemeriksaan_fisio'");
		}

		function get_data_edit_tindakan_fisio($id_tindakan, $no_fisio){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_fisio WHERE  id_tindakan='$id_tindakan' AND no_fisio='$no_fisio'");
		}

		function get_no_register($no_fisio){
			return $this->db->query("SELECT no_register FROM pemeriksaan_fisio WHERE  no_fisio='$no_fisio' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_fisio){
			return $this->db->query("UPDATE hasil_pemeriksaan_fisio SET hasil_fisio='$hasil_fisio' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_fisio){
			$this->db->query("UPDATE pemeriksaan_fisio SET cetak_hasil='1' where no_fisio='$no_fisio'");
			return true;
		}

		function get_jenis_fisio(){
			return $this->db->query("SELECT * FROM jenis_fisio");
		}

		function get_data_kategori_lab($no_fisio){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM hasil_pemeriksaan_fisio as a
				LEFT JOIN jenis_fisio as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_fisio='$no_fisio' AND hasil_fisio!='' 
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_blanko_kategori_lab($no_fisio){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM pemeriksaan_fisio as a
				LEFT JOIN jenis_fisio as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_fisio='$no_fisio'
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_data_jenis_fisio($no_fisio){
			return $this->db->query("SELECT a.id_tindakan, a.no_fisio, b.nmtindakan FROM hasil_pemeriksaan_fisio a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_fisio='$no_fisio' AND hasil_fisio!=''  GROUP BY id_tindakan");
		}

		function get_blanko_jenis_fisio($no_fisio){
			return $this->db->query("SELECT a.id_tindakan, a.no_fisio, b.nmtindakan FROM pemeriksaan_fisio a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_fisio='$no_fisio' GROUP BY id_tindakan");
		}

		function get_data_hasil_fisio($id_tindakan,$no_fisio){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_fisio WHERE id_tindakan='$id_tindakan' AND no_fisio='$no_fisio' AND hasil_fisio!=''");
		}

		function get_blanko_hasil_fisio($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_hasil_fisio WHERE id_tindakan='$id_tindakan'");
		}

		function get_data_pasien_cetak($no_fisio){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_fisio='$no_fisio' GROUP BY no_fisio");
		}

		function get_data_pasien_luar_cetak($no_fisio){
			return $this->db->query("SELECT * FROM pemeriksaan_fisio a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_fisio='$no_fisio' GROUP BY no_fisio");
		}

		//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_fisio_selesai(){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_fisio, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_fisio is not null AND LEFT(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
			GROUP BY no_fisio");
		}

		function get_hasil_fisio_by_date_selesai($date){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_fisio, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_fisio is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_fisio");
		}

		function get_hasil_fisio_by_no_selesai($key){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_fisio, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_fisio WHERE no_fisio=a.no_fisio AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_fisio a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_fisio is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%' OR data_pasien.no_medrec LIKE '%$key%')
			GROUP BY no_fisio");
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
	}
?>
