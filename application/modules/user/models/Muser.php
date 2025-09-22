<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul
		function get_user_data_pasien($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from data_pasien 
				where tgl_daftar>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND 
				tgl_daftar<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') AND xuser is not null group by xuser");
		}

		function get_user_all($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT u.username as xuser, IFNULL(SUM(c.total),0) as total, c.tgl_kunjungan as tgl 
				FROM hmis_users u 
				LEFT JOIN lap_user c 
				ON u.username = c.user AND c.tgl_kunjungan>=to_timestamp('$tgl_awal 23:59:59','YYYY-MM-DD') 
				and c.tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD') 
				GROUP BY u.username
				");
		}	

		function get_user_daful_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xcreate) as total, xcreate as xuser from daftar_ulang_irj 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD')
				and id_poli='BA00' group by xcreate");
		}

		function get_user_daful_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xcreate) as total, xcreate as xuser from daftar_ulang_irj 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') 
			    group by xcreate");
		}

		function get_user_tind_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from pelayanan_poli 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND left(idtindakan,2)!='1B' AND 
				tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') and id_poli='BA00' group by xuser");
		}

		function get_user_tind_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from pelayanan_poli 
				where tgl_kunjungan>=to_timestamp('$tgl_awal 23:59:59','YYYY-MM-DD HH24:MI:SS') 
				AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD HH24:MI:SS')  
				group by xuser");
		}

		function get_user_diag_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from diagnosa_pasien 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') 
				and id_poli='BA00' group by xuser");
		}

		function get_user_diag_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from diagnosa_pasien 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') 
				and id_poli!='BA00' group by xuser");
		}

		function get_cetak_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(xcetak) as total, xcetak from daftar_ulang_irj
where left(tgl_cetak_kw,10)>='$tgl_awal' AND left(tgl_cetak_kw,10)<='$tgl_akhir' and id_poli='BA00' group by xcetak");
		}

		function get_cetak_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(xcetak) as total, xcetak from daftar_ulang_irj 
				where tgl_cetak_kw>=to_date('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_cetak_kw<=to_date('$tgl_akhir','YYYY-MM-DD 23:59:59') 
				and id_poli!='BA00' group by xcetak");
		}

		function get_cetak_pl_rad($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
				where vtot_rad is not NULL and tgl_kunjungan>=to_date('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=
				to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xuser");
		}

		function get_cetak_pl_pa($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
				where vtot_pa is not NULL and tgl_kunjungan>=to_date('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=
				to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xuser");
		}

		function get_cetak_pl_lab($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
				where vtot_lab is not NULL and tgl_kunjungan>=to_date('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=
				to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xuser");
		}
		function get_cetak_pl_farm($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
				where vtot_obat is not NULL and tgl_kunjungan>=to_date('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=
				to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xuser");
		}

		function get_user_rad($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from pemeriksaan_radiologi 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xinput");
		}	

		function get_user_pa($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from pemeriksaan_patologianatomi 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xinput");
		}	
		
		function get_user_lab($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from pemeriksaan_laboratorium 
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xinput");
		}		

		function get_user_farm($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from resep_pasien
				where tgl_kunjungan>=to_timestamp('$tgl_awal','YYYY-MM-DD 23:59:59') AND tgl_kunjungan<=to_timestamp('$tgl_akhir','YYYY-MM-DD 23:59:59') group by xinput");
		}

		function getIdGudang($userid){
            $query = $this->db->get_where('dyn_gudang_user  ', array('userid' => $userid));
            return $query->row();
        }
	}
?>
