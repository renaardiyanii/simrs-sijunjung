<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantrol extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function get_poliklinik_bpjs_antrol()
	{
		return $this->db->select('nm_poli,poli_bpjs,id_poli')
		->where('poli_bpjs != \'\' and poli_bpjs is not null')
		->get('poliklinik')->result();
	}

	function get_suratkontrol($nomorkartu)
	{
		return $this->db->query("SELECT * FROM bpjs_suratkontrol where no_kartu ='$nomorkartu' and sep is null or sep = '' order by tgl_rencana_kontrol	desc limit 1")->row();
	}
	
	function get_poliklinik_bpjs()
	{
		return $this->db->
		where('poli_bpjs != \'\' and poli_bpjs is not null')
		->get('poliklinik')->result();
	}

	function get_dokter_bpjs($kodepoli)
	{
		return $this->db->query("SELECT dd.nm_dokter,dd.id_dokter,dd.kode_dpjp_bpjs FROM dokter_poli dp join data_dokter dd on 
		dd.id_dokter = dp.id_dokter where dp.id_poli = '$kodepoli' 
		and (dd.kode_dpjp_bpjs != '' and dd.kode_dpjp_bpjs is not null) ")->result();
	}

	function get_data_pasien($nomorkartu)
	{
		return $this->db->select('no_identitas as nik,no_hp as nohp,no_cm as norm')
		->where('no_kartu',$nomorkartu)->get('data_pasien')->row();
	}

	function get_data_pasien_berdasarkan_nik($nik){
		return $this->db->select('no_kartu')
		->where('no_identitas',$nik)->get('data_pasien')->row();
	}

	function get_counter_internal()
	{
		$query = $this->db->query("SELECT nextval('rujukan_internal_counter') as sequence_value");
        $row = $query->row();
        return $row->sequence_value;
	}

	function get_pasien_by_no_cm($norm)
	{
		return $this->db->where('no_cm',$norm)->get('data_pasien')->row();
	}

	function get_bpjs_sep($no_rujukan, $type = 0)
	{
		$where = 'norujukan';
		$addition = null;
		if ($type) {
			$where = 'no_kartu';
			$addition = 'substr(no_register,0,3) = \'RI\'';
		}
		$data = $this->db->where($where, $no_rujukan)->where('no_sep is not null');
		if ($addition) {
			$data->where($addition);
			return $data->get('bpjs_sep');
		}
		return $data->get('bpjs_sep');
	}

	function cek_bpjs_suratkontrol($no_sep_asal)
	{
		return $this->db->where('no_sep_asal', $no_sep_asal)->get('bpjs_suratkontrol');
	}

	function insert_bpjs_surat_kontrol($data)
    {
        return $this->db->insert('bpjs_suratkontrol',$data);
    }

}
