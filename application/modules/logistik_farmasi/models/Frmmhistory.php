<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmhistory extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_history_detail($id,$tgl){
			return $this->db->query("SELECT
										nama_obat,
										qty,
										Satuan_obat,
										tgl_kunjungan,
										Signa
									FROM
									resep_pasien
									WHERE
										no_medrec = '$id'
									AND tgl_kunjungan = '$tgl'
									AND cetak_faktur = 1")->result();
		}

		function get_data_pasien($data){
			$where = "";
			$where2 = "";

			if (($data["tgl0"] != "") && ($data["tgl1"] != "")){
	        	$where .= " AND tgl_kunjungan BETWEEN '".$data["tgl0"]."' AND '".$data["tgl1"]."' ";
	        	// $where2 .= " AND rp2.tgl_kunjungan BETWEEN '".$data["tgl0"]."' AND '".$data["tgl1"]."' ";
	        }

	        return $this->db->query("
			SELECT
				rp.tgl_kunjungan,
				rp.no_medrec,
				dp.nama,
				pl.nm_poli
			FROM
				data_pasien dp
			JOIN resep_pasien rp ON rp.no_medrec = dp.no_medrec
			JOIN poliklinik pl ON pl.id_poli = rp.idrg
			WHERE
				rp.no_medrec IS NOT NULL
			AND rp.cetak_faktur = 1
			$where
			UNION
			SELECT
				rp2.tgl_kunjungan,
				rp2.no_medrec,
				dp2.nama,
				rg.nmruang
			FROM
				data_pasien dp2
			JOIN resep_pasien rp2 ON rp2.no_medrec = dp2.no_medrec
			JOIN ruang rg ON rg.idrg = rp2.idrg
			WHERE
				rp2.no_medrec IS NOT NULL
			AND rp2.cetak_faktur = 1
			$where
			ORDER BY tgl_kunjungan")->result();
		}
	}
?>