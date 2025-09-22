<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Pamdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for pacdaftar
		function get_daftar_pasien_pa(){
			return $this->db->query("SELECT pemeriksaan_pa.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_pa.tgl_kunjungan as tgl_kunjungan, pemeriksaan_pa.jadwal_pa as jadwal_pa, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, data_pasien.nama as nama  
							FROM pemeriksaan_pa, data_pasien 
							WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec
							AND LEFT(pemeriksaan_pa.jadwal_pa,10)=LEFT(NOW(),10)
							order by tgl_kunjungan asc
						");
		}

		function get_daftar_pasien_pa_by_date($date){
			return $this->db->query("SELECT
				pemeriksaan_pa.no_register,
				data_pasien.no_cm AS no_medrec,
				pemeriksaan_pa.tgl_kunjungan,
				pemeriksaan_pa.kelas,
				pemeriksaan_pa.idrg,
				pemeriksaan_pa.bed,
				data_pasien.nama AS nama 
			FROM
				pemeriksaan_pa,
				data_pasien 
			WHERE
				pemeriksaan_pa.no_medrec = data_pasien.no_medrec 
				AND to_char( pemeriksaan_pa.tgl_kunjungan, 'YYYY-MM-DD' ) = '$date' 
				AND pemeriksaan_pa.pa = '1'");
		}

		function get_daftar_pasien_pa_by_no($key){
			return $this->db->query("SELECT pemeriksaan_pa.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_pa.tgl_kunjungan, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, data_pasien.nama as nama  
										FROM pemeriksaan_pa, data_pasien 
										WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_pa.no_register LIKE '%$key%')
									UNION
										SELECT pemeriksaan_pa.no_register, pemeriksaan_pa.no_medrec, pemeriksaan_pa.tgl_kunjungan, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, pasien_luar.nama as nama  
										FROM pemeriksaan_pa, pasien_luar 
										WHERE pemeriksaan_pa.no_register=pasien_luar.no_register 
										AND (pasien_luar.nama LIKE '%$key%' OR pemeriksaan_pa.no_register LIKE '%$key%')
										ORDER BY tgl_kunjungan DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT *  FROM pemeriksaan_pa, data_pasien WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec AND pemeriksaan_pa.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_irj($no_register){
			return $this->db->query("SELECT nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor AND daftar_ulang_irj.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_iri($no_register){
			return $this->db->query("SELECT nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor=kontraktor.id_kontraktor AND pasien_iri.no_ipd='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_pa, pasien_luar WHERE pemeriksaan_pa.no_register=pasien_luar.no_register AND pemeriksaan_pa.no_register='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi WHERE no_register='$no_register' AND no_pa IS NULL");
		}
		function get_data_banyak_pemeriksaan($no_medrec){
			return $this->db->query("SELECT no_medrec ,max(id_pemeriksaan_pa) as id, count(no_register) as pemeriksaan from pemeriksaan_patologianatomi where no_medrec='$no_medrec' group by pemeriksaan_patologianatomi.no_medrec");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_pa where pemeriksaan_pa.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_pa.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_pa ORDER BY nmtindakan asc");
		}

		function getdata_tindakan_pasien_histo(){
			return $this->db->query("SELECT * FROM jenis_tindakan_new where instalasi = 'PA' ORDER BY nmtindakan asc");
		}

		function getdata_tindakan_pasien_sito(){
			return $this->db->query("SELECT * FROM jenis_tindakan_pa_sito ORDER BY nmtindakan asc");
		}

		function get_biaya_tindakan($id_tindakan){
			return $this->db->query("SELECT tarif FROM jenis_tindakan_new WHERE idtindakan='".$id_tindakan."'");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT A
					.id_dokter,
					A.nm_dokter 
				FROM
					data_dokter
					AS A LEFT JOIN dokter_poli AS b ON A.id_dokter = b.id_dokter 
				WHERE
				A.deleted =0");
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
			return $this->db->query("SELECT * FROM jenis_tindakan_new WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan_($data){
			$nm_kode = $this->db->query("SELECT nm_kode FROM pa_kode_jenis_tindakan WHERE idtindakan='".$data['id_tindakan']."'")->row()->nm_kode;

			$this->db->set('no_pa_tindakan', "(SELECT IFNULL(CONCAT('".$nm_kode."".date('y')."', LPAD (max(right(no_pa_tindakan,5))+1 ,5,0) ),'".$nm_kode."".date('y')."00001') FROM (SELECT * FROM pemeriksaan_patologianatomi WHERE LEFT(no_pa_tindakan,3) = '".$nm_kode."".date('y')."') AS a)", FALSE);

			$this->db->insert('pemeriksaan_patologianatomi', $data);
			return true;
		}

		function insert_pemeriksaan($data)
		{
			$this->db->insert('pemeriksaan_patologianatomi', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET pa=0, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET pa=0, status_pa=1, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET pa=0, status_pa=1, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_pa,$vtot_pa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi 
				SET no_pa = COALESCE(no_pa, '$no_pa') 
				WHERE no_register = '$no_register';");
			$this->db->query("UPDATE pasien_iri SET pa=0, status_pa='$status_pa', vtot_pa='$vtot_pa' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_pa FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_pa($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_pa FROM pemeriksaan_patologianatomi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_pa($no_pa){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_pa FROM pemeriksaan_patologianatomi WHERE no_pa='".$no_pa."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_pa){
			$this->db->where('id_pemeriksaan_pa', $id_pemeriksaan_pa);
       		$this->db->delete('pemeriksaan_patologianatomi');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO pa_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_pa FROM pa_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_pa DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for pacpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_pa(){
			return $this->db->query("SELECT C
					.nama,
					A.cara_bayar,
					A.id_pemeriksaan_pa,
					A.no_pa,
					A.no_pa_tindakan,
					A.no_register,
					to_char( A.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
					A.cetak_kwitansi,
					A.vtot,
					A.no_pa,
					A.jenis_tindakan
				FROM
					pemeriksaan_patologianatomi A,
					data_pasien C 
				WHERE
					cast(A.no_medrec as int) = C.no_medrec 
					AND A.no_pa IS NOT NULL ");
		}

		function get_hasil_pa_by_date($date){
			return $this->db->query("SELECT c.nama,a.cara_bayar,a.id_pemeriksaan_pa,a.no_pa,a.no_pa_tindakan,a.no_register,LEFT (a.tgl_kunjungan,10) AS tgl,a.cetak_kwitansi,a.vtot FROM pemeriksaan_patologianatomi a,data_pasien c WHERE a.no_medrec=c.no_medrec AND a.cetak_hasil='0' AND a.no_pa IS NOT NULL AND LEFT (a.tgl_kunjungan,10)='$date' UNION SELECT d.nama,b.cara_bayar,b.id_pemeriksaan_pa,b.no_pa,b.no_pa_tindakan,b.no_register,LEFT (b.tgl_kunjungan,10) AS tgl,d.cetak_kwitansi AS cetak_kwitansi,d.vtot_pa AS vtot FROM pemeriksaan_patologianatomi b,pasien_luar d WHERE b.no_register=d.no_register AND b.cetak_hasil='0' AND b.no_pa IS NOT NULL AND LEFT (b.tgl_kunjungan,10)='$date' ORDER BY tgl ASC");
		}

		function get_hasil_pa_by_no($key){
			return $this->db->query("SELECT c.nama,a.cara_bayar,a.id_pemeriksaan_pa,a.no_pa,a.no_pa_tindakan,a.no_register,LEFT (a.tgl_kunjungan,10) AS tgl,a.cetak_kwitansi,a.vtot FROM pemeriksaan_patologianatomi a,data_pasien c WHERE a.no_medrec=c.no_medrec AND a.cetak_hasil='0' AND a.no_pa IS NOT NULL AND (a.no_pa_tindakan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR c.nama LIKE '%$key%') UNION SELECT d.nama,b.cara_bayar,b.id_pemeriksaan_pa,b.no_pa,b.no_pa_tindakan,b.no_register,LEFT (b.tgl_kunjungan,10) AS tgl,d.cetak_kwitansi AS cetak_kwitansi,d.vtot_pa AS vtot FROM pemeriksaan_patologianatomi b,pasien_luar d WHERE b.no_register=d.no_register AND b.cetak_hasil='0' AND b.no_pa IS NOT NULL AND (b.no_pa_tindakan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR d.nama LIKE '%$key%') ORDER BY tgl ASC");
		}

		function getrow_hasil_pa($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi, data_pasien WHERE pemeriksaan_patologianatomi.no_medrec=data_pasien.no_medrec AND pemeriksaan_patologianatomi.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_row_register_by_nopa($no_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE no_pa='$no_pa' LIMIT 1");
		}

		function get_row_register_by_id_pemeriksaan_pa($id_pemeriksaan_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa' LIMIT 1");
		}

		function get_row_hasil($no_pa){
			return $this->db->query("SELECT hasil_periksa FROM pemeriksaan_patologianatomi WHERE no_pa='$no_pa' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_pa){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi WHERE no_pa='".$no_pa."'  AND cetak_hasil='0' ORDER BY no_pa");
		}

		function get_isi_hasil($no_pa){
			return $this->db->query("SELECT A
					.*,
					C.id_hasil_pemeriksaan,
					C.hasil_pa
				FROM
					pemeriksaan_patologianatomi
					AS A LEFT JOIN hasil_pemeriksaan_pa AS C ON A.id_pemeriksaan_pa = cast(C.id_pemeriksaan_pa as int)
				WHERE
					A.no_pa = '$no_pa' 
				ORDER BY
					A.no_pa");
		}

		function get_data_hasil($id_pemeriksaan_pa){
			return $this->db->query("SELECT hasil FROM pemeriksaan_patologianatomi WHERE id_pemeriksaan_pa='".$id_pemeriksaan_pa."'");
		}

		function get_edit_hasil($no_pa){
			return $this->db->query("SELECT a.*, b.nmtindakan FROM hasil_pemeriksaan_pa as a LEFT JOIN jenis_tindakan as b ON a.id_tindakan=b.idtindakan WHERE no_pa='".$no_pa."'");
		}

		function get_banyak_hasil_pa($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_pa){
			return $this->db->query("SELECT 
				a.*,
				c.*,
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') as tgl,
				b.tgl_kunjungan AS tglkunj
			FROM 
				pemeriksaan_patologianatomi AS a, data_pasien AS c, daftar_ulang_irj AS b
			WHERE 
				cast(a.no_medrec as int )=c.no_medrec 
				AND a.no_pa='$no_pa' 
				AND a.no_register = b.no_register UNION
			SELECT 
				a.*, 
				c.*,
				to_char(a.tgl_kunjungan, 'YYYY-MM-DD') as tgl,
				b.tgl_masuk AS tglkunj
			FROM 
				pemeriksaan_patologianatomi AS a, data_pasien AS c, pasien_iri AS b
			WHERE 
				cast(a.no_medrec as int )=c.no_medrec 
				AND a.no_pa='$no_pa'
				AND a.no_register = b.no_ipd LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, pasien_luar WHERE pemeriksaan_patologianatomi.no_register=pasien_luar.no_register AND pemeriksaan_patologianatomi.id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa){
			return $this->db->query("SELECT
					*,
					to_char ( pemeriksaan_patologianatomi.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl 
				FROM
					pemeriksaan_patologianatomi,
					data_pasien 
				WHERE
					CAST( pemeriksaan_patologianatomi.no_medrec as int ) = data_pasien.no_medrec 
					AND pemeriksaan_patologianatomi.id_pemeriksaan_pa = '$id_pemeriksaan_pa'
			");
		}

		function get_data_tindakan_pa($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_pa.* FROM jenis_hasil_pa, jenis_tindakan WHERE  jenis_hasil_pa.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($id_pemeriksaan_pa, $data){
			// $this->db->insert('hasil_pemeriksaan_pa', $data);
			$this->db->where('id_pemeriksaan_pa', $id_pemeriksaan_pa);
			$this->db->update('pemeriksaan_patologianatomi', $data); 
			
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_pa){
			return $this->db->query("UPDATE pemeriksaan_patologianatomi SET hasil_periksa=1 WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, pasien_luar WHERE pemeriksaan_patologianatomi.no_register=pasien_luar.no_register AND pemeriksaan_patologianatomi.id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_edit_tindakan_pa($id_tindakan, $no_pa){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_pa WHERE  id_tindakan='$id_tindakan' AND no_pa='$no_pa'");
		}

		function get_no_register_byid_pemeriksaan_pa($id_pemeriksaan_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE  id_pemeriksaan_pa='$id_pemeriksaan_pa' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_pa){
			return $this->db->query("UPDATE hasil_pemeriksaan_pa SET hasil_pa='$hasil_pa' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($id_pemeriksaan_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET cetak_hasil='1' where id_pemeriksaan_pa='$id_pemeriksaan_pa'");
			return true;
		}

		function get_jenis_pa(){
			return $this->db->query("SELECT * FROM jenis_pa");
		}

		function get_data_kategori_pa($no_pa){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM hasil_pemeriksaan_pa as a
				LEFT JOIN jenis_pa as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_pa='$no_pa' AND hasil_pa!='' 
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_blanko_kategori_pa($no_pa){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM pemeriksaan_patologianatomi as a
				LEFT JOIN jenis_pa as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_pa='$no_pa'
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_data_jenis_pa($no_pa){
			return $this->db->query("SELECT a.id_tindakan, a.no_pa, b.nmtindakan FROM hasil_pemeriksaan_pa a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_pa='$no_pa' AND hasil_pa!=''  GROUP BY id_tindakan");
		}

		function get_data_jenis_pa_by_id_pemeriksaan_pa($id_pemeriksaan_pa){
			return $this->db->query("SELECT a.id_tindakan, a.no_pa, b.nmtindakan, a.id_pemeriksaan_pa FROM hasil_pemeriksaan_pa a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND id_pemeriksaan_pa='$id_pemeriksaan_pa' AND hasil_pa!=''  GROUP BY id_tindakan");
		}

		function get_blanko_jenis_pa($id_pemeriksaan_pa){
			return $this->db->query("SELECT*FROM pemeriksaan_patologianatomi a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa' GROUP BY id_tindakan");
		}

		function get_data_hasil_pa($id_tindakan,$no_pa){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_pa WHERE id_tindakan='$id_tindakan' AND no_pa='$no_pa' AND hasil_pa!=''");
		}

		function get_blanko_hasil_pa($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_hasil_pa WHERE id_tindakan='$id_tindakan'");
		}

		function get_data_pasien_cetak($no_pa){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi a LEFT JOIN data_pasien b ON cast(A.no_medrec as int) = b.no_medrec WHERE a.no_pa='$no_pa' ");
		}

		function get_data_pasien_cetak_by_id_pemeriksaan($id_pemeriksaan){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi a LEFT JOIN data_pasien b ON a.no_medrec = b.no_medrec WHERE a.id_pemeriksaan_pa='$id_pemeriksaan' ");
		}

		function get_data_pasien_luar_cetak($no_pa){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_pa='$no_pa' GROUP BY no_pa");
		}

		//modul for pacdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_pa_selesai(){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_pa is not null AND LEFT(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
			GROUP BY no_pa");
		}

		function get_hasil_pa_by_date_selesai($date){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_pa is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_pa");
		}

		function get_hasil_pa_by_no_selesai($key){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_pa is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%' OR data_pasien.no_medrec LIKE '%$key%')
			GROUP BY no_pa");
		}

		function getnm_dokter_rj($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		}

		function getnm_dokter_ri($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM pasien_iri as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_ipd='$no_register'");
		}

		function get_jenis_tindakan_pa($idtindakan){
			return $this->db->query("SELECT * FROM pa_kode_jenis_tindakan
				WHERE idtindakan='$idtindakan'");
		}

		function update_rujukan_penunjang_irj($data, $no_register)
		{
			if ($no_register == null) {
				return false;
			} else {
				$this->db->where('no_register', $no_register);
				$this->db->update('daftar_ulang_irj', $data);
				return true;
			}
		}

		function update_rujukan_penunjang_iri($data, $no_ipd)
		{
			if ($no_ipd == null) {
				return false;
			} else {
				$this->db->where('no_ipd', $no_ipd);
				$this->db->update('pasien_iri', $data);
				return true;
			}
		}

		function get_no_register($no_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE  no_pa ='$no_pa' GROUP BY no_register");
		}

		
		function isi_hasil_new($data){
			$this->db->insert('hasil_pemeriksaan_pa', $data);
			return true;	
		}

		function get_data_hasil_pa_pertindakan($id_pemeriksaan_pa){
			return $this->db->query("SELECT a.id_tindakan,a.no_pa,a.jenis_tindakan,a.hasil_periksa,b.*FROM pemeriksaan_patologianatomi AS a LEFT JOIN hasil_pemeriksaan_pa AS b ON a.id_pemeriksaan_pa=cast (b.id_pemeriksaan_pa as int) WHERE a.id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_hasil_pa_selesai_new(){
			$date = date("Y-m-d");
			return $this->db->query("SELECT
				nama ,
				a.jenis_tindakan,
				a.id_pemeriksaan_pa,
				a.no_medrec ,
				a.no_pa ,
				a.no_register ,
				a.tgl_kunjungan as tgl ,
				cetak_kwitansi ,
				data_pasien.no_cm,
				data_pasien.no_hp,
				data_pasien.email
			FROM
				pemeriksaan_patologianatomi a ,
				data_pasien,
				hasil_pemeriksaan_pa b
			WHERE
				cast (a.no_medrec as int) = data_pasien.no_medrec
				AND cast(a.id_pemeriksaan_pa as text) = b.id_pemeriksaan_pa
				and substr(A.no_register,1,2) <> 'PL'
				AND a.no_pa is not null
				AND to_char(a.tgl_kunjungan, 'YYYY-MM-DD') = '$date'");

			
		}

	


	}
?>
