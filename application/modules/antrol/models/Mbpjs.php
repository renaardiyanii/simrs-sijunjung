<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbpjs extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    function get_data_bpjs()
    {
        $this->db->from('bpjs_config');
        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
    public function update_bpjs($data_bpjs)
    {
        $this->db->update('bpjs_config', $data_bpjs);
        $this->db->limit(1);
        return true;
    }
    function show_hide_secid($user,$password){
        $this->db->from('hmis_users');
        $this->db->select('*');
        $this->db->where('username', $user);
        $this->db->where('password', $password);
        $query = $this->db->get();
        return $query->result();
    }


    /// IRJ ///
    function hapussep_irj($no_sep)
    {
        $data['no_sep'] = NULL;
        $this->db->where('no_sep', $no_sep);
        $this->db->update('daftar_ulang_irj', $data);
    }

    function updatetglplg_irj($nosep,$data_update)
    {
      $this->db->where('no_sep', $nosep);
      $this->db->update('daftar_ulang_irj', $data_update);
    }

    function update_sep_irj($no_register,$data_update)
    {
        $this->db->where('no_register', $no_register);
        $this->db->update('daftar_ulang_irj', $data_update);
        return true;
    }

    // function update_sep($no_sep,$data_update)
    // {
    //     $this->db->where('no_sep', $no_sep);
    //     $this->db->update('bpjs_sep', $data_update);
    //     return true;
    // }



    /// IRI ///
    function get_pasien_iri($no_ipd)
    {
        $this->db->FROM('pasien_iri');
        $this->db->SELECT('*');
        $this->db->WHERE('pasien_iri.no_ipd', $no_ipd);
        $query = $this->db->get();
        return $query->row();
    }
    function pasien_iri($no_sep)
    {
        $this->db->FROM('pasien_iri');
        $this->db->SELECT('*');
        $this->db->WHERE('pasien_iri.no_sep', $no_sep);
        $query = $this->db->get();
        return $query->row();
    }
    function update_sep_iri($no_register,$data_update)
    {
        $this->db->where('no_ipd', $no_register);
        $this->db->update('pasien_iri', $data_update);
        return true;
    }
    function rincian_irj($no_register)
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->SELECT('*');
        $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
        $this->db->JOIN('kontraktor', 'daftar_ulang_irj.id_kontraktor = kontraktor.id_kontraktor', 'left');
        $this->db->WHERE('daftar_ulang_irj.no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    }
    function insert_sep($data)
    {
        $result = $this->db->insert('bpjs_sep', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function show_sep_irj($no_register)
    {
        $this->db->from('daftar_ulang_irj');
        $this->db->join('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
        $this->db->join('bpjs_sep', 'daftar_ulang_irj.no_sep = bpjs_sep.no_sep', 'inner');
        $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    }
    function show_pelayanan_iri($no_ipd)
    {
        $this->db->from('pasien_iri');
        $this->db->join('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
        $this->db->where('no_ipd', $no_ipd);
        $query = $this->db->get();
        return $query->row();
    }

    function hapussep_iri($no_sep)
    {
        $data['no_sep'] = NULL;
        $this->db->where('no_sep', $no_sep);
        $this->db->update('pasien_iri', $data);
    }
    function updatetglplg_iri($nosep,$data_update)
    {
      $this->db->where('no_sep', $nosep);
      $this->db->update('pasien_iri', $data_update);
    }

    //////////////// SEP ///////////////////////
    function update($no_register,$data_update)
    {
        $this->db->where('no_register', $no_register);
        $this->db->update('daftar_ulang_irj', $data_update);
        return true;
    }


    function update_spri($data,$no_ipd){
        $this->db->where('no_ipd', $no_ipd);
        $this->db->update('pasien_iri', $data);
        return true;
    }

    function hapus_spri($no_ipd)
    {
        $this->db->where('no_ipd', $no_ipd);
        $this->db->update('pasien_iri',
        [
            "nosurat_skdp_sep"=>null
        ]);
    }

    function get_data_dokter($spesialis){
       $data = $this->db->query("SELECT * FROM data_dokter WHERE ket = '$spesialis'");
        return $data->result_array();
    }

    function insert_bpjs_surat_kontrol($data)
    {
        return $this->db->insert('bpjs_suratkontrol',$data);
    }

    function get_bpjs_sep($no_register)
    {
        return $this->db->where('no_register',$no_register)->get('bpjs_sep');
    }

    function update_sep_bpjs($no_register,$data)
    {
        $this->db->where('no_register',$no_register)->update('bpjs_sep',$data);
        unset($data['internal']);
        return $this->db->where('no_register',$no_register)->update('daftar_ulang_irj',$data);
    }

    function update_bpjs_surat_kontrol($data,$surat_kontrol)
    {
        return $this->db->where('surat_kontrol',$surat_kontrol)
        ->update('bpjs_suratkontrol',$data);
    }

    function cari_bpjs_sep($no_register)
    {
        return $this->db->select('bpjs_sep.*,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_hp,data_pasien.no_cm')->from('bpjs_sep')
        ->join('data_pasien','data_pasien.no_medrec = bpjs_sep.no_medrec')
        ->where('bpjs_sep.no_register',$no_register)
        ->get();
    }

    function hapus_bpjs_surat_kontrol($nosurat)
    {
        return $this->db->where('surat_kontrol',$nosurat)->delete('bpjs_suratkontrol');
    }

    function cari_sep($sep)
    {
        return $this->db->where('no_sep',$sep)->get('bpjs_sep')->row();
    }

    function get_diagnosa($sep)
    {
        return $this->db->where('no_sep',$sep)->get('daftar_ulang_irj')->row();
    }

    function get_diagnosa_ranap($sep)
    {
        return $this->db->select('diagmasuk as diagnosa,\'rawatinap\' as id_poli')->where('no_sep',$sep)->get('pasien_iri')->row();
    }

    function cari_data_pasien($no_kartu)
    {
        return $this->db->where('no_kartu',$no_kartu)->get('data_pasien')->row();
    }

    function delete_sep($sep,$no_register = '')
    {
        if($no_register != ''){
            $this->db->where('no_register',$no_register)->update('daftar_ulang_irj',[
                'no_sep'=>''
            ]);
        }
        return $this->db->where('no_sep',$sep)->delete('bpjs_sep');
    }


    // prb

    function insert_rujukan_prb($data)
    {
        return $this->db->insert('bpjs_rujukan_prb',$data);
    }

    function delete_prb($column,$data)
    {
        return $this->db->where($column,$data)->update('bpjs_rujukan_prb',['deleted'=>'1']);
    }

    function get_bed()
    {
        return $this->db->query("
     select concat(a.idrg ,(
case when kelas = 'VIP' then '40'
when kelas ='I' then '10'
when kelas = 'II' then '20'
when kelas = 'III' then '30'
end
)) as koderuang,
(select nmruang from ruang where ruang.idrg = a.idrg) as nmruang,
a.kelasjkn as kodekelas,  count(*) as kapasitas,
sum(case when isi='N' then 1 else 0 end) as kosong
from bed as a
 where aktif is null and kelasjkn is not null
 group by koderuang,nmruang,kelasjkn
 ;
        ");
    }

    function get_bed_idrg($idrg,$kelas)
    {
        return $this->db->query("
         SELECT 
            (
            case when kelas = 'VIP' then 'VIP'
            when kelas ='I' then 'KL1'
            when kelas = 'II' then 'KL2'
            when kelas = 'III' then 'KL3'
            end
            ) as kodekelas
            ,concat(a.idrg ,(
            case when kelas = 'VIP' then '40'
            when kelas ='I' then '10'
            when kelas = 'II' then '20'
            when kelas = 'III' then '30'
            end
            )) as koderuang, a.nmruang, a.kelas, sum(kapasitas) AS kapasitas, sum(kapasitas) - sum(isi) AS kosong FROM (
				
				SELECT A
					.idrg,
					b.nmruang,
					A.kelas,
					COUNT ( a.idrg ) AS kapasitas,
					0 AS isi
				FROM
					bed AS A , ruang AS b
				WHERE
					a.idrg = b.idrg
					and a.idrg = '$idrg' and b.kelas ='$kelas'
				GROUP BY
					A.idrg,
					b.nmruang,
					A.kelas 
					UNION
					SELECT A
					.idrg,
					b.nmruang,
					a.klsiri AS kelas,
					0 AS kapasitas,
					COUNT ( * ) AS isi 
				FROM
					pasien_iri AS A, ruang AS b, ruang_iri AS c
				WHERE
					A.tgl_keluar is null and a.idrg = b.idrg AND a.no_ipd = c.no_ipd AND c.tglkeluarrg is null
					AND a.mutasi is null and a.idrg = '$idrg' and b.kelas ='$kelas'
				GROUP BY
					A.idrg,
					A.klsiri,
					b.nmruang) AS a GROUP BY a.idrg, a.kelas, a.nmruang ORDER BY a.nmruang, a.kelas
        ");
    }

    function getkodebpjsberdasarkannama($nama)
    {
        return $this->db->select('poli_bpjs')
        ->where('lokasi',$nama)
        ->where('poli_bpjs is not null')
        ->get('poliklinik')
        ->row();
    }

    function get_poli_bpjs($id_poli)
    {
        return $this->db->select('poli_bpjs')->where('id_poli',$id_poli)
        ->get('poliklinik')->row();
    }

    function get_pasien_no_medrec($no_medrec)
    {
        return $this->db->select('no_cm')->where('no_medrec',$no_medrec)->get('data_pasien')->row();
    }

    function get_noregister_booking($kodebooking)
    {
        return $this->db->select('no_register,no_sep')->where('noreservasi',$kodebooking)
        ->get('daftar_ulang_irj')->row();
    }

	function get_noregister_noregister($noregister)
    {
        return $this->db->select('no_register,no_sep')->where('no_register',$noregister)
        ->get('daftar_ulang_irj')->row();
    }

    function insert_history_antrol($data)
    {
        return $this->db->insert('history_antrol',$data);
    }
    function getdatapasienberdasarnoregister($noregister)
    {
        return $this->db->select('pasien_iri.diagmasuk,data_pasien.no_medrec,pasien_iri.klsiri,data_pasien.nama,data_pasien.no_kartu,data_pasien.no_hp,pasien_iri.no_ipd')
        ->join("data_pasien","data_pasien.no_medrec = pasien_iri.no_medrec","inner")
        ->where('pasien_iri.no_ipd', $noregister)
        ->get('pasien_iri')
        ->row();
    }

    function getdataspribynoka($no_kartu)
    {
        return $this->db->select('data_dokter.*,bpjs_suratkontrol.*')
        ->join('data_dokter','data_dokter.kode_dpjp_bpjs = bpjs_suratkontrol.dokter_bpjs','inner')
        ->where('bpjs_suratkontrol.sep IS NULL')
        ->where('bpjs_suratkontrol.no_kartu',$no_kartu)
        ->order_by("bpjs_suratkontrol.id","DESC")
        ->get('bpjs_suratkontrol')
        ->row();
    }
    
    

}