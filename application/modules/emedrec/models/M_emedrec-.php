<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_emedrec extends CI_Model{
        function __construct(){
			parent::__construct();
		}

        function get_data_pasien_by_no_cm($no_cm){
            //return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
            return $this->db->query("SELECT *,TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_cm = '$no_cm'");
        }

        function getdata_record_pasien($no_cm){
			return $this->db->query("SELECT 
					a.no_register as noregister,
					TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
					a.id_dokter,
					b.nm_dokter AS dokter,
					c.nm_poli AS poli,
					d.diagnosa AS diagnosa 
				FROM
					daftar_ulang_irj
					AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
					LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
					LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register 
				WHERE
					a.no_medrec = '$no_cm' 
					AND d.klasifikasi_diagnos = 'utama'
					AND a.id_poli != 'BA00'");
		}

		function getdata_ird_pasien($no_cm){
			return $this->db->query("SELECT 
					a.no_register as noregister,
					TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
					a.id_dokter,
					b.nm_dokter AS dokter,
					c.nm_poli AS poli,
					d.diagnosa AS diagnosa 
				FROM
					daftar_ulang_irj
					AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
					LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
					LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register 
				WHERE
					a.no_medrec = '$no_cm' 
					-- AND d.klasifikasi_diagnos = 'utama'
					AND a.id_poli = 'BA00'
					");
		}

		function getdata_iri_pasien($no_cm){
			return $this->db->query("SELECT
										a.no_ipd, a.tgl_keluar, a.noregasal, a.tgl_masuk, a.dokter
									FROM
										pasien_iri as a
									WHERE
										no_medrec = '$no_cm'");
		}

		function getdata_detail_lab($no_reg){
			return $this->db->query("SELECT
					b.nmtindakan as nm_tindakan, a.hasil_lab as hasil
				FROM
					hasil_pemeriksaan_lab as a
				LEFT JOIN jenis_tindakan as b ON a.id_tindakan = b.idtindakan
				WHERE
					a.no_register = '$no_reg'");
		}

		function getdata_detail_obat($no_reg){
			return $this->db->query("SELECT
										tgl_kunjungan, nama_obat, item_obat , signa
									FROM
										resep_pasien as a
									WHERE
										a.no_register = '$no_reg'");
		}

		function getdata_detail_radiologi($no_reg){
			return $this->db->query("SELECT
										a.*, b.nm_dokter
									FROM
										hasil_pemeriksaan_rad as a
										LEFT JOIN pemeriksaan_radiologi as b ON a.id_pemeriksaan_rad = b.id_pemeriksaan_rad
									WHERE
										b.no_register = '$no_reg'");
		}

		function get_data_ringkas_medik_rj($no_cm){
			return $this->db->query("SELECT a.*,b.diagnosa,b.id_diagnosa,b.tindakan
			FROM v_ringkas_medik_rj a
			LEFT JOIN diagnosa_pasien b
			ON b.no_register = a.noregister
			WHERE no_medrec = '$no_cm'");
		}
		
		function get_data_asesmen_keperawatan($no_reg){
			return $this->db->query("SELECT 
					a.*,
					b.* 
				FROM
					daftar_ulang_irj
					AS a JOIN pemeriksaan_fisik AS b ON a.no_register = b.no_register 
				WHERE
					a.no_register = '$no_reg'");
		}

		function get_data_asesmen_masalah_keperawatan($no_reg){
			return $this->db->query("SELECT 
					* 
				FROM
					asesment_masalah_keperawatan
				WHERE
					no_register = '$no_reg'");
		}
    }

