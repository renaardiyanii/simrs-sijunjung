<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MPointMedika extends CI_Model{

	function __construct(){
			parent::__construct();
	}

	public function get_cppt_pm_by_no_medrek($no_medrek) {
		$this->db->select("*")->from('tb_rekam_medis_cppt')
		->join('data_pasien','data_pasien.no_cm = rekam_medik_number')
		->join('poliklinik','tb_rekam_medis_cppt.code_poli = poliklinik.kode_poli')
		->where("rekam_medik_number",$no_medrek)
		->order_by('waktu_pelayanan','desc');
		$query = $this->db->get();
		if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return array();
        }       
	}

	public function get_assesment_medis_by_medrec($no_medrec)
	{
		$this->db->where('rekam_medik_number',$no_medrec);
		$this->db->order_by('waktu_pelayanan','desc');
		return $this->db->get('tb_assesmen_medis_poli')->result();
	}

	function get_last_pasien()
	{
		return $this->db->query("SELECT MAX(no_cm) FROM data_pasien");
	}

	function get_diagnosa_by_nocm($nomedrec,$keyword="")
	{
		if($keyword!=""){
			return $this->db->query("SELECT a.id_diagnosa,a.diagnosa,a.klasifikasi_diagnos,a.diagnosa_text,to_char(b.tgl_kunjungan,'YYYY-MM-DD')as tgl,c.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as nm_poli FROM diagnosa_pasien as a
			LEFT JOIN daftar_ulang_irj as b on b.no_register = a.no_register
			LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec
			WHERE c.no_cm = '$nomedrec' AND UPPER(a.id_diagnosa) LIKE '%$keyword%'
			OR UPPER(a.diagnosa) LIKE '%$keyword%'
			ORDER BY b.tgl_kunjungan DESC LIMIT 20");
		}else{
			return $this->db->query("SELECT a.id_diagnosa,a.diagnosa,a.klasifikasi_diagnos,a.diagnosa_text,to_char(b.tgl_kunjungan,'DD-MM-YYYY')as tgl,c.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as nm_poli FROM diagnosa_pasien as a
			LEFT JOIN daftar_ulang_irj as b on b.no_register = a.no_register
			LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec
			WHERE c.no_cm = '$nomedrec'
			ORDER BY b.tgl_kunjungan DESC LIMIT 20");
		}
	}
		

}
    