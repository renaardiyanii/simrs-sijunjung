<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class mpiutang extends CI_Model {

    public function get_pasien_piutang($tgl='',$medrec=''){
		if($tgl != '' && $medrec != ''){
			$data=$this->db->query("SELECT * from header_piutang where lunas != 1 and jns_kwitansi != 'Rawat Inap' and to_char(created_date,'YYYY-MM-DD') = '$tgl' and medrec = '$medrec'");
		}else if ($tgl == '' && $medrec != ''){
			$data=$this->db->query("SELECT * from header_piutang where lunas != 1 and jns_kwitansi != 'Rawat Inap'  and medrec = '$medrec'");
		}else if($tgl != '' && $medrec == ''){
			$data=$this->db->query("SELECT * from header_piutang where lunas != 1 and jns_kwitansi != 'Rawat Inap' and to_char(created_date,'YYYY-MM-DD') = '$tgl'");
		}else{
			$data=$this->db->query("SELECT * from header_piutang where lunas != 1 and jns_kwitansi != 'Rawat Inap'");
		}
		
		return $data->result();
	}

	public function get_pasien_piutang_ranap(){
		$data=$this->db->query("SELECT * from header_piutang where lunas != 1 and jns_kwitansi = 'Rawat Inap'");
		return $data->result();
	}

    public function get_pasien_piutang_detail($id){
		$data=$this->db->query("SELECT * from header_piutang where id = $id");
		return $data->row();
	}

    public function insert_cicilan_piutang($data){
		$this->db->query("INSERT INTO cicilan_piutang (id_piutang,no_register,created_date, created_by,
        sisa_angsuran,biaya_angsuran,sisa_akhir,no_kwitansi) 
        VALUES ('".$data['id_piutang']."','".$data['no_register']."','".$data['created_date']."',
        '".$data['created_by']."','".$data['sisa_angsuran']."','".$data['biaya_angsuran']."','".$data['sisa_akhir']."','".$data['no_kwitansi']."')");
	
	}

    public function get_pasien_cicilan_detail($id){
		$data=$this->db->query("SELECT * from cicilan_piutang where id_piutang = $id order by id asc");
		return $data->result();
	}

    public function get_sisa_akhir_cicilan($id){
		$data=$this->db->query("SELECT sisa_akhir from cicilan_piutang where id_piutang = $id order by id desc limit 1");
		return $data->row();
	}

	public function get_pasien_cicilan_detail_piutang($id){
		$data=$this->db->query("SELECT * from cicilan_piutang where id = $id");
		return $data->row();
	}

	public function update_header_piutang_lunas($id){
		$this->db->query("UPDATE header_piutang set lunas = 1,tgl_lunas = now() where id = $id");
		return true;
	}

	public function get_pasien_cicilan_detail_piutang_by_id_piutang($id){
		$data=$this->db->query("SELECT * from cicilan_piutang where id_piutang = $id order by id asc");
		return $data->result();
	}

	public function get_pasien_piutang_by_noreg($noreg){
		$data=$this->db->query("SELECT * from header_piutang where no_register = $no_register");
		return $data->result();
	}

	function update_status_cetak_kwitansi_lab_lunas($no_lab,$no_register){
		$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_kwitansi='1', piutang = '2' WHERE no_lab='$no_lab'");
		return true;
	}

	function update_status_cetak_kwitansi_rad_lunas($no_rad,$no_register){
		
		$this->db->query("UPDATE pemeriksaan_radiologi SET cetak_kwitansi='1', piutang = '2' WHERE no_rad='$no_rad'");
		return true;
	}

	function update_status_cetak_kwitansi_em_lunas($no_em,$no_register){
		$this->db->query("UPDATE pemeriksaan_elektromedik SET cetak_kwitansi='1', piutang = '2' WHERE no_em='$no_em'");
		return true;
	}

	




  }