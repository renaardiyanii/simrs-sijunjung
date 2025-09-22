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
            $this->db->JOIN('printer_unit', 'cast(printer_send.id_unit as integer) = printer_unit.id', 'left');
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
			return $this->db->query("SELECT * FROM data_pekerjaan order by id  asc");
		}
		function get_sukubangsa(){
			return $this->db->query("SELECT * FROM master_sukubangsa order by nm_sukubangsa ASC");
		}
		function get_hubungan(){
			return $this->db->query("SELECT * FROM tni_hubungan");
		}
		function get_angkatan(){
			return $this->db->query("SELECT * FROM tni_angkatan");
		}
		function get_poliklinik(){
			//return $this->db->query("SELECT id_poli, nm_poli,nm_pokpoli, poli_bpjs FROM poliklinik ORDER BY nm_poli ASC");
			return $this->db->query("SELECT id_poli, nm_poli,nm_pokpoli, poli_bpjs,active FROM poliklinik  WHERE active= '1' ORDER BY nm_poli ASC");
		}
		function get_poliklinik_non_igd(){
			return $this->db->query("SELECT id_poli, nm_poli,nm_pokpoli, poli_bpjs FROM poliklinik WHERE id_poli != 'BA00' ORDER BY nm_poli ASC");
		}

		function get_poli_konsul_iri() {
			return $this->db->query("SELECT
			id_poli,
			nm_poli,
			nm_pokpoli,
			poli_bpjs 
			FROM
				poliklinik 
			WHERE
				id_poli != 'BA00'
				AND id_poli != 'BK09'
				AND id_poli != 'BK07'
				AND id_poli != 'BK08'
				AND id_poli != 'BJ09'
				AND id_poli != 'BK01'
				AND id_poli != 'BK04'
				AND id_poli != 'BK03'
				AND id_poli != 'BK06'
				and nm_pokpoli != 'EKSEKUTIF'
			ORDER BY
				nm_poli ASC");
		}

		function get_poli_konsul_anestesi() {
			return $this->db->query("SELECT
				id_poli,
				nm_poli,
				nm_pokpoli,
				poli_bpjs 
			FROM
				poliklinik 
			WHERE
				id_poli = 'BB05'");
		}
		function get_poliklinik_non_igd_gaada_tiga(){
			return $this->db->query("SELECT 
				id_poli, nm_poli,nm_pokpoli, poli_bpjs 
			FROM 
				poliklinik 
			WHERE 
				id_poli != 'BA00' 
				AND id_poli != 'BK04'
				AND id_poli != 'BK01'
				AND id_poli != 'BK08'
				AND id_poli != 'BK07'
				AND id_poli != 'BK02'
				AND id_poli != 'BK05'
				AND id_poli != 'BK00'
			ORDER BY 
				nm_poli ASC");
		}
		function get_poliklinik_non_igd_ada_tiga(){
			return $this->db->query("SELECT 
				id_poli, nm_poli,nm_pokpoli, poli_bpjs 
			FROM 
				poliklinik 
			WHERE  
				 id_poli IN ('BK04', 'BK01', 'BK08', 'BK07', 'BK02', 'BK05', 'BK00')
			ORDER BY 
				nm_poli ASC");
		}
		function get_cara_bayar(){
			return $this->db->query("SELECT * FROM cara_bayar");
		}
		function get_kontraktor(){
			return $this->db->query("SELECT * FROM kontraktor ORDER BY id_kontraktor asc");
		}
		function get_diagnosa(){
			return $this->db->query("SELECT id_icd, nm_diagnosa FROM icd1 ORDER BY id_icd");
		}
		function get_dokter(){
			
		//	return $this->db->query("SELECT id_dokter, nm_dokter FROM data_dokter where deleted='0' ORDER BY nm_dokter");
		
		return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter a, dokter_poli b where a.deleted='0'
		                       and a.id_dokter = b.id_dokter AND b.id_poli = 'BB00' AND a.deleted = '0' ORDER BY a.nm_dokter");
	    }

		function get_dokter_noreg($no_register)
		{
			if(substr($no_register,0,2) == 'RI'){
				return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter a, pasien_iri b where a.deleted='0'
			and a.id_dokter = b.id_dokter and b.no_ipd = '$no_register'");
			}
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter a, daftar_ulang_irj b where a.deleted='0'
			and a.id_dokter = b.id_dokter and b.no_register = '$no_register'");
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
		// antrol update
		function get_pasien_daftar_today_checkin($id_poli) {
			$date = date('Y-m-d');
			if ($id_poli == 'BM00') {
				return $this->db->query("SELECT
					a.no_antrian as antri,
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					-- Menambahkan kolom checkin
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
						) THEN 1 ELSE 0 
					END AS checkin,
		
					-- Menambahkan kolom cetaksep
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
						) THEN 1 ELSE 0 
					END AS cetaksep,
					(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					a.ket_pulang
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
					AND a.no_medrec = b.no_medrec
					AND TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					AND a.id_dokter = c.id_dokter
					AND a.tgl_pulang IS NULL
					-- Hanya tampilkan pasien yang sudah checkin
					AND EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					)
				GROUP BY antri, tgl, kode, id, nama, sex, dokter, ket, kelas, waktu_masuk_poli
				ORDER BY a.no_antrian ASC");
			} else {
				return $this->db->query("SELECT
					a.no_antrian as antri,
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					-- Menambahkan kolom checkin
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
						) THEN 1 ELSE 0 
					END AS checkin,
		
					-- Menambahkan kolom cetaksep
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
						) THEN 1 ELSE 0 
					END AS cetaksep,
					(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					a.ket_pulang
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
					AND a.no_medrec = b.no_medrec
					AND TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					AND a.id_dokter = c.id_dokter
					-- Hanya tampilkan pasien yang sudah checkin
					AND EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					)
				GROUP BY antri, tgl, kode, id, nama, sex, dokter, ket, kelas, waktu_masuk_poli
				ORDER BY a.no_antrian ASC");
			}
		}


		function get_pasien_daftar_today_notcheckin($id_poli) {
			$date = date('Y-m-d');
			if ($id_poli == 'BM00') {
				return $this->db->query("SELECT
					a.no_antrian as antri,
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					-- Menambahkan kolom checkin
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
						) THEN 1 ELSE 0 
					END AS checkin,
		
					-- Menambahkan kolom cetaksep
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
						) THEN 1 ELSE 0 
					END AS cetaksep,
					(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					a.ket_pulang
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
					AND a.no_medrec = b.no_medrec
					AND TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					AND a.id_dokter = c.id_dokter
					AND a.tgl_pulang IS NULL
					-- Hanya tampilkan pasien yang belum checkin
					AND NOT EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					)
				GROUP BY antri, tgl, kode, id, nama, sex, dokter, ket, kelas, waktu_masuk_poli
				ORDER BY a.no_antrian ASC");
			} else {
				return $this->db->query("SELECT
					a.no_antrian as antri,
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					-- Menambahkan kolom checkin
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
						) THEN 1 ELSE 0 
					END AS checkin,
		
					-- Menambahkan kolom cetaksep
					CASE 
						WHEN EXISTS (
							SELECT 1 FROM history_antrol h 
							WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
						) THEN 1 ELSE 0 
					END AS cetaksep,
					(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					a.ket_pulang
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
					AND a.no_medrec = b.no_medrec
					AND TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					AND a.id_dokter = c.id_dokter
					-- Hanya tampilkan pasien yang belum checkin
					AND NOT EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					)
				GROUP BY antri, tgl, kode, id, nama, sex, dokter, ket, kelas, waktu_masuk_poli
				ORDER BY a.no_antrian ASC");
			}
		}
		
		
		
		function get_pasien_daftar_today($id_poli){
			$date = date('Y-m-d');
			if($id_poli == 'BM00'){
							return $this->db->query("SELECT
							a.no_antrian as antri,
							a.kekhususan,
							a.no_register_lama,
							CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
							b.no_cm AS kode,
							a.no_register AS id,
							b.nama AS nama,
							b.sex AS sex,
							c.nm_dokter AS dokter,
							a.cara_bayar AS ket,
							a.kelas_pasien AS kelas,
							a.waktu_masuk_poli as waktu_masuk_poli,
							a.\"hapusSEP\" as \"hapusSEP\",
							a.status,
							a.ket_pulang,
							(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
							-- Menambahkan kolom checkin
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					) THEN 1 ELSE 0 
				END AS checkin,

				-- Menambahkan kolom cetaksep
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
					) THEN 1 ELSE 0 
				END AS cetaksep,
				(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					
					a.ket_pulang
						FROM
							daftar_ulang_irj AS a,
							data_pasien AS b,
							data_dokter c
						WHERE
							a.id_poli = '$id_poli'
						AND a.no_medrec = b.no_medrec
						and TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
						AND a.id_dokter= c.id_dokter
						AND a.tgl_pulang is null
							GROUP BY antri,tgl,kode,id,nama,sex,dokter,ket,kelas,waktu_masuk_poli
							ORDER BY a.no_antrian ASC");
			}else{
							return $this->db->query("SELECT
							a.no_antrian as antri,
							a.kekhususan,
							a.no_register_lama,
							CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
							b.no_cm AS kode,
							a.no_register AS id,
							b.nama AS nama,
							b.sex AS sex,
							c.nm_dokter AS dokter,
							a.cara_bayar AS ket,
							a.kelas_pasien AS kelas,
							a.waktu_masuk_poli as waktu_masuk_poli,
							a.\"hapusSEP\" as \"hapusSEP\",
							a.status,
							a.ket_pulang,
							(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
							-- Menambahkan kolom checkin
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					) THEN 1 ELSE 0 
				END AS checkin,

				-- Menambahkan kolom cetaksep
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
					) THEN 1 ELSE 0 
				END AS cetaksep,
				(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs,
					a.ket_pulang
						FROM
							daftar_ulang_irj AS a,
							data_pasien AS b,
							data_dokter c
						WHERE
							a.id_poli = '$id_poli'
						AND a.no_medrec = b.no_medrec
						and TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
						AND a.id_dokter= c.id_dokter
							GROUP BY antri,tgl,kode,id,nama,sex,dokter,ket,kelas,waktu_masuk_poli
							ORDER BY a.no_antrian ASC");
			}
			
		}
		public function get_pasien_daftar_today_dokter($id_poli)
		{
			if($id_poli!='BM00' && $id_poli != 'BB05'){
				return $this->db->query("SELECT DISTINCT
				a.waktu_masuk_dokter,
				a.no_register_lama,
				a.kekhususan,
				a.no_antrian as antri,
				a.tgl_kunjungan AS tgl,
				b.no_cm AS kode,
				a.no_register AS id,
				b.nama AS nama,
				b.sex AS sex,
				c.nm_dokter AS dokter,
				a.cara_bayar AS ket,
				a.kelas_pasien AS kelas,
				a.waktu_masuk_poli as waktu_masuk_poli,
				a.\"hapusSEP\" as \"hapusSEP\",
				a.status,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
					-- soap_pasien_rj d
				WHERE
					a.id_poli = '$id_poli'
				-- and a.no_register = d.no_register
				-- and d.objective_perawat is not null 
				AND a.no_medrec = b.no_medrec
				and TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = TO_CHAR(now(),'YYYY-MM-DD')
				AND a.id_dokter= c.id_dokter
				GROUP BY antri,tgl,kode,id,nama,sex,dokter,ket,kelas,waktu_masuk_poli,a.no_register
				ORDER BY a.no_antrian ASC");
			}else if ($id_poli == 'BM00'){
				return $this->db->query("SELECT a.waktu_masuk_dokter, 
				a.no_register_lama,
				a.kekhususan,
				a.no_antrian as antri,
				a.tgl_kunjungan AS tgl, 
				b.no_cm AS kode, 
				a.no_register AS id, 
				b.nama AS nama, 
				b.sex AS sex, 
				c.nm_dokter AS dokter, 
				a.cara_bayar AS ket, 
				a.kelas_pasien AS kelas, 
				a.waktu_masuk_poli as waktu_masuk_poli, 
				a.\"hapusSEP\" as \"hapusSEP\", 
				a.status,
				( SELECT count(*) FROM pelayanan_poli WHERE no_register = a.no_register AND bayar = '1' ) AS unpaid,
					a.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor
					FROM daftar_ulang_irj AS a,
				data_pasien AS b, data_dokter c WHERE a.id_poli = '$id_poli' and  a.no_medrec = b.no_medrec  and TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = TO_CHAR(now(),'YYYY-MM-DD') AND a.id_dokter= c.id_dokter and a.tgl_pulang is null GROUP BY antri,tgl,kode,id,nama,sex,dokter,ket,kelas,waktu_masuk_poli,a.no_register ORDER BY a.no_antrian ASC");
			} else if($id_poli == 'BB05') {
				return $this->db->query("SELECT 
					a.waktu_masuk_dokter,
					A.no_antrian AS antri,
					A.kekhususan,
					A.no_register_lama,
					CAST ( A.tgl_kunjungan AS TIMESTAMP ) AS tgl,
					b.no_cm AS kode,
					A.no_register AS ID,
					b.nama AS nama,
					b.sex AS sex,
					C.nm_dokter AS dokter,
					A.cara_bayar AS ket,
					A.kelas_pasien AS kelas,
					A.waktu_masuk_poli AS waktu_masuk_poli,
					A.\"hapusSEP\" AS \"hapusSEP\",
					A.status,
					( SELECT COUNT ( * ) FROM pelayanan_poli WHERE no_register = A.no_register AND bayar = '1' ) AS unpaid,
					A.ket_pulang,
					(SELECT nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor
				FROM
					daftar_ulang_irj AS A,
					data_pasien AS b,
					data_dokter C 
				WHERE
					A.id_poli = '$id_poli' 
					AND A.no_medrec = b.no_medrec 
					AND TO_CHAR( A.tgl_kunjungan, 'YYYY-MM-DD' ) = TO_CHAR( now( ), 'YYYY-MM-DD' ) 
					AND A.id_dokter = C.id_dokter 
				GROUP BY
					antri,
					tgl,
					kode,
					ID,
					nama,
					sex,
					dokter,
					ket,
					kelas,
					waktu_masuk_poli 
				ORDER BY
					A.no_antrian ASC");
			}
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
									c.nomor_kode"
								);
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
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
				-- Menambahkan kolom checkin
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'checkin'
					) THEN 1 ELSE 0 
				END AS checkin,

				-- Menambahkan kolom cetaksep
				CASE 
					WHEN EXISTS (
						SELECT 1 FROM history_antrol h 
						WHERE h.no_register = a.no_register AND h.aksi = 'cetaksep'
					) THEN 1 ELSE 0 
				END AS cetaksep,
					(
						SELECT
							count(*)
						FROM
							pelayanan_poli
						WHERE
							no_register = a.no_register
						AND bayar = '1'
					) AS unpaid,
					a.ket_pulang,
					
				(SELECT poli_bpjs from poliklinik where id_poli = '$id_poli') as poli_bpjs

				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
				AND a.no_medrec = b.no_medrec
				and CAST (a.id_dokter AS INTEGER) = c.id_dokter
				AND LEFT (CAST(a.tgl_kunjungan AS TEXT), 10) = '$date'
				ORDER BY a.no_antrian ASC
				");
		}

		function get_pasien_daftar_by_date_dokter($id_poli,$date){
			if($id_poli != 'BB05') {
				return $this->db->query("SELECT DISTINCT
					a.waktu_masuk_dokter,
					a.kekhususan,
					a.no_antrian as antri,
					a.tgl_kunjungan AS tgl,
					b.no_cm AS kode,
					a.no_register_lama,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					a.status,
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					(
						SELECT
							count(*)
						FROM
							pelayanan_poli
						WHERE
							no_register = a.no_register
						AND bayar = '1'
					) AS unpaid,
					a.ket_pulang
					FROM
						daftar_ulang_irj AS a,
						data_pasien AS b,
						data_dokter c
						-- soap_pasien_rj d
					WHERE
						a.id_poli = '$id_poli'
					-- and a.no_register = d.no_register
					-- and d.objective_perawat is not null 
					AND a.no_medrec = b.no_medrec
					and TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = '$date'
					AND a.id_dokter= c.id_dokter
					GROUP BY antri,tgl,kode,id,nama,sex,dokter,ket,kelas,waktu_masuk_poli,a.no_register
					ORDER BY a.no_antrian ASC");
			} else {
				return $this->db->query("SELECT DISTINCT
					a.waktu_masuk_dokter,
					a.no_antrian as antri,
					a.kekhususan,
					a.no_register_lama,
					CAST(a.tgl_kunjungan AS TIMESTAMP) AS tgl,
					b.no_cm AS kode,
					a.no_register AS id,
					b.nama AS nama,
					b.sex AS sex,
					c.nm_dokter AS dokter,
					a.cara_bayar AS ket,
					a.kelas_pasien AS kelas,
					a.waktu_masuk_poli as waktu_masuk_poli,
					a.\"hapusSEP\" as \"hapusSEP\",
					(select nmkontraktor from kontraktor where kontraktor.id_kontraktor = a.id_kontraktor) as nmkontraktor,
					a.status,
				
					(
						SELECT
							count(*)
						FROM
							pelayanan_poli
						WHERE
							no_register = a.no_register
						AND bayar = '1'
					) AS unpaid,
					a.ket_pulang
				FROM
					daftar_ulang_irj AS a,
					data_pasien AS b,
					data_dokter c
				WHERE
					a.id_poli = '$id_poli'
				AND a.no_medrec = b.no_medrec
				and CAST (a.id_dokter AS INTEGER) = c.id_dokter
				AND LEFT (CAST(a.tgl_kunjungan AS TEXT), 10) = '$date'
				ORDER BY a.no_antrian ASC");
			}	
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
			// return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
			// 							(select count(id_poli) from daftar_ulang_irj 
			// 							where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.status='0' 
			// 							and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10)) as counter
			// 						FROM poliklinik 
			// 						LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
			// 						where dyn_poli_user.userid='$username'
			// 						GROUP BY poliklinik.id_poli");

						return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
							(select count(id_poli) from daftar_ulang_irj 
							where poliklinik.id_poli=daftar_ulang_irj.id_poli 
							and daftar_ulang_irj.status = '0'  
							and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD')) as counter
							FROM poliklinik 
							LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
							where dyn_poli_user.userid= $username
							GROUP BY poliklinik.id_poli,poliklinik.nm_poli"); 
		}
		function get_poli_non_igd($username){
			// return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
			// 							(select count(id_poli) from daftar_ulang_irj 
			// 							where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.status='0' 
			// 							and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10)) as counter
			// 						FROM poliklinik 
			// 						LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
			// 						where dyn_poli_user.userid='$username'
			// 						GROUP BY poliklinik.id_poli");
			$date = date('Y-m-d');
						return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
							(select count(id_poli) from daftar_ulang_irj 
							where poliklinik.id_poli=daftar_ulang_irj.id_poli 
						 
							and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD') = '$date') as counter
							FROM poliklinik 
							LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
							where dyn_poli_user.userid= $username and poliklinik.id_poli != 'BA00'
							GROUP BY poliklinik.id_poli,poliklinik.nm_poli"); 
		}					
		function get_poli_dokter($username){

						return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
							(select count(id_poli) from daftar_ulang_irj,pemeriksaan_fisik 
							where poliklinik.id_poli=daftar_ulang_irj.id_poli 
							and daftar_ulang_irj.status = '0'  
							and daftar_ulang_irj.no_register = pemeriksaan_fisik.no_register
							and pemeriksaan_fisik.objective is not null 
							and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD') = to_char(now(),'YYYY-MM-DD')) as counter
							FROM poliklinik 
							LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
							where dyn_poli_user.userid= $username
							GROUP BY poliklinik.id_poli,poliklinik.nm_poli"); 
		}					
		function get_poli_dokter_non_igd($username){

						return $this->db->query("SELECT
	poliklinik.id_poli,
	poliklinik.nm_poli,
	(
	SELECT COUNT
		( id_poli ) 
	FROM
		daftar_ulang_irj
-- 		soap_pasien_rj 
	WHERE
		poliklinik.id_poli = daftar_ulang_irj.id_poli 
		AND daftar_ulang_irj.status = '0' 
-- 		AND soap_pasien_rj.no_register = daftar_ulang_irj.no_register 
-- 		AND soap_pasien_rj.objective_perawat IS NOT NULL 
		AND TO_CHAR( daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD' ) = to_char( now( ), 'YYYY-MM-DD' ) 
	) AS counter 
FROM
	poliklinik
	LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli = poliklinik.id_poli 
WHERE
	dyn_poli_user.userid =$username 
	AND poliklinik.id_poli != 'BA00' 
	AND poliklinik.id_poli != 'BM00' 
GROUP BY
	poliklinik.id_poli,
	poliklinik.nm_poli UNION ALL
SELECT
	poliklinik.id_poli,
	poliklinik.nm_poli,
	(
	SELECT COUNT
		( id_poli ) 
	FROM
		daftar_ulang_irj 
	WHERE
		poliklinik.id_poli = daftar_ulang_irj.id_poli 
		AND daftar_ulang_irj.status = '0' 
		AND TO_CHAR( daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD' ) = to_char( now( ), 'YYYY-MM-DD' ) 
	) AS counter 
FROM
	poliklinik
	LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli = poliklinik.id_poli 
WHERE
	dyn_poli_user.userid =$username 
	AND poliklinik.id_poli = 'BM00' 
GROUP BY
	poliklinik.id_poli,
	poliklinik.nm_poli"); 
		}
		function get_nm_poli($id_poli){//judul poli -> header dalam list antrian
			return $this->db->query("SELECT nm_poli,poli_bpjs FROM poliklinik where id_poli='$id_poli'");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////tarif_tindakan
		function get_tarif_tindakan($keyword,$kelas_pasien){//judul poli -> header dalam list antrian
			return $this->db->query("select * from jenis_tindakan, tarif_tindakan where jenis_tindakan.nmtindakan like '%$keyword%' and jenis_tindakan.idtindakan=tarif_tindakan.idtindakan and tarif_tindakan.kelas='$kelas_pasien' and jenis_tindakan.cito='B'");
		}



			
		function get_list_rawat_jalan(){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid,
			(select nmkontraktor from kontraktor where daftar_ulang_irj.id_kontraktor = kontraktor.id_kontraktor) as nm_kontraktor
						FROM daftar_ulang_irj, data_pasien 
						where daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
						and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-dd') = TO_CHAR(now(),'YYYY-MM-dd') and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
				");
		}
		
				function get_data_by_register($no_register){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
			FROM daftar_ulang_irj, data_pasien 
			where daftar_ulang_irj.no_register='$no_register' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
			and TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-dd') = TO_CHAR(now(),'YYYY-MM-dd') and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
			");
				}

		function edit_cara_bayar($no_register, $data){
			// $this->db->where('no_register', $no_register);
			// $this->db->update('daftar_ulang_irj', $data); 
			// return true;
			// print_r($data);
			// die();
			$cara_bayar = $data['cara_bayar'];
			$id_kontraktor = $data['id_kontraktor'];
			if($id_kontraktor == null || $id_kontraktor == ''){
				$this->db->query("UPDATE daftar_ulang_irj
				SET cara_bayar = '$cara_bayar'
				WHERE no_register = '$no_register'");
			}
			else{
				$this->db->query("UPDATE daftar_ulang_irj
				SET cara_bayar = '$cara_bayar',
					id_kontraktor = $id_kontraktor
				WHERE no_register = '$no_register'");
			}
			
			return true;

		}

		public function cariDokter($iddokter)
		{
			return $this->db->query("SELECT id_dokter,kode_dpjp_bpjs,nm_dokter from data_dokter where id_dokter=$iddokter");
		}
		public function cariPoliklinik($idpoli)
		{
			return $this->db->query('SELECT id_poli,nm_pokpoli,nm_poli from poliklinik where id_poli=\''.$idpoli.'\'');
		}
	
		public function get_wilayah_baru()
		{
			return  $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')
			->like('kotakabupaten.nama', strtoupper($this->input->get("q")))
			->or_like('kecamatan.nama', strtoupper($this->input->get("q")))
			->or_like('kelurahandesa.nama', strtoupper($this->input->get("q")))
			->select('provinsi.id as id_provinsi,kotakabupaten.id as id_kota,kecamatan.id as id_kecamatan,kelurahandesa.id as id_kelurahan,provinsi.nama as nm_provinsi,kotakabupaten.nama as nm_kota,kecamatan.nama as nm_kecamatan,kelurahandesa.nama as nm_kelurahan')->limit(50, 0)->get();
		}

		// ADD SJJ 2024

		function get_last_cmpatria(){
			return $this->db->query("SELECT no_cm, no_medrec FROM data_pasien ORDER BY no_medrec DESC");
		}
}

?>
