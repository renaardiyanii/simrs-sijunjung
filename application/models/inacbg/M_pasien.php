<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pasien extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    // public function get_pelayanan_kriteria() 
    // {        
    //     $jenis_rawat = $this->input->post('jenis_rawat');      
    //     $periode = $this->input->post('periode');     
    //     $tanggal_cari = $this->input->post('tanggal_cari');     
    //     $kelas_rawat = $this->input->post('kelas_rawat');     
    //     $status_klaim = $this->input->post('status_klaim'); 

    //     if ($jenis_rawat == 'rawat_jalan') {
    //         $query = $this->db->query("
    //             SELECT * FROM inacbg_klaim AS a INNER JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' AND b.tgl_pulang != ''
    //             ORDER BY tgl_kunjungan DESC
    //         ");  
    //     }   

    //     $query = $this->db->query("
    //         SELECT * FROM inacbg_klaim AS a INNER JOIN daftar_ulang_irj AS b ON a.no_register = b.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' AND b.tgl_pulang != ''
    //         UNION ALL
    //         SELECT a.no_cm,a.nama,b.no_ipd AS no_register,b.no_sep,b.tgl_masuk AS tgl_kunjungan,b.tgl_keluar AS tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN pasien_iri AS b ON a.no_medrec = b.no_cm LEFT JOIN inacbg_klaim AS c ON b.no_ipd = c.no_register WHERE a.no_cm = '$no_cm' AND b.carabayar = 'BPJS' AND b.tgl_keluar != ''
    //         ORDER BY tgl_kunjungan DESC
    //     ");     
    //     return $query->result();
    // } 

    public function get_pelayanan() 
    {        
        $no_cm = $this->input->post('no_cm');   
        $query = $this->db->query("
            SELECT a.no_cm,a.nama,b.no_register,b.no_sep,b.tgl_kunjungan,b.tgl_pulang,c.payor_cd AS jaminan FROM data_pasien AS a INNER JOIN daftar_ulang_irj AS b ON a.no_medrec = b.no_medrec LEFT JOIN inacbg_klaim AS c ON b.no_register = c.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' GROUP BY tgl_kunjungan
            UNION ALL
            SELECT a.no_cm,a.nama,b.no_ipd AS no_register,b.no_sep,b.tgl_masuk AS tgl_kunjungan,b.tgl_keluar AS tgl_pulang,c.payor_cd AS jaminan FROM data_pasien AS a INNER JOIN pasien_iri AS b ON a.no_medrec = b.no_cm LEFT JOIN inacbg_klaim AS c ON b.no_ipd = c.no_register WHERE a.no_cm = '$no_cm' AND b.carabayar = 'BPJS'
            ORDER BY tgl_kunjungan DESC
        ");     
        return $query->result();
    } 

    function get_autocomplete($category,$q)
    {   
        if ($category == '1') {
            $query = $this->db->query("SELECT no_cm,nama,sex,tgl_lahir,no_kartu FROM data_pasien WHERE no_cm LIKE '%$q%' LIMIT 100");
        } else if ($category == '2') {
            $query = $this->db->query("
                SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE daftar_ulang_irj.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
                UNION
                SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN pasien_iri ON data_pasien.no_medrec=pasien_iri.no_cm WHERE pasien_iri.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
                LIMIT 100");
        } else if ($category == '3') {
            $query = $this->db->query("SELECT no_cm,nama,sex,tgl_lahir,no_kartu FROM data_pasien WHERE nama LIKE '%$q%' LIMIT 100");
        }  else if ($category == '4') {
            $query = $this->db->query("SELECT no_cm,nama,sex,tgl_lahir,no_kartu FROM data_pasien WHERE no_identitas LIKE '%$q%' AND jenis_identitas='KTP' LIMIT 100");
        }
        // $query=$this->db->query("
        //     SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE daftar_ulang_irj.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
        //     UNION
        //     SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN pasien_iri ON data_pasien.no_medrec=pasien_iri.no_cm WHERE pasien_iri.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
        //     UNION
        //     SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien WHERE no_cm LIKE '%$q%' GROUP BY data_pasien.no_medrec
        //     UNION
        //     SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien WHERE nama LIKE '%$q%' GROUP BY data_pasien.no_medrec
        //     UNION
        //     SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien WHERE no_identitas LIKE '%$q%' AND jenis_identitas='KTP' GROUP BY data_pasien.no_medrec limit 100"
        // );
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $new_row['label'] = htmlentities(stripslashes($row['no_cm'].' - '.$row['nama']));
                $new_row['value'] = htmlentities(stripslashes($q));
                $new_row['no_cm'] = htmlentities(stripslashes($row['no_cm']));
                $new_row['nama'] = htmlentities(stripslashes($row['nama']));
                $new_row['gender'] = htmlentities(stripslashes($row['sex']));
                if ($row['tgl_lahir'] == '0000-00-00 00:00:00' || $row['tgl_lahir'] == NULL) {
                    $new_row['tgl_lahir'] = '';
                } else $new_row['tgl_lahir'] = htmlentities(stripslashes(date("d-m-Y", strtotime($row['tgl_lahir']))));
                $new_row['no_kartu'] = htmlentities(stripslashes($row['no_kartu']));
                $row_set[] = $new_row;
            }
            echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }

    function get_tarif_rs($no_register) 
    {
        $this->db->FROM('inacbg_tarif_rs');
        if (substr($no_register, 0,2) == 'RJ') {
            $this->db->JOIN('daftar_ulang_irj', 'inacbg_tarif_rs.no_register = daftar_ulang_irj.no_register', 'inner');
        }
        if (substr($no_register, 0,2) == 'RI') {
            $this->db->JOIN('pasien_iri', 'inacbg_tarif_rs.no_register = pasien_iri.no_ipd', 'inner');
        }                           
        $this->db->where('inacbg_tarif_rs.no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    }  

    function update_tarif_rs($no_register,$data_update) 
    {
        $this->db->where('no_register', $no_register);
        $q = $this->db->get('inacbg_tarif_rs');
        $this->db->reset_query();

        if ( $q->num_rows() > 0 ) 
        {
            $this->db->where('no_register', $no_register);
            $this->db->update('inacbg_tarif_rs', $data_update);
        } else {            
            $this->db->set('no_register', $no_register);
            $this->db->insert('inacbg_tarif_rs', $data_update);    
        }        
        return true;
    }   

    function get_dokter($id_dokter) 
    {
        $this->db->FROM('data_dokter');
        $this->db->SELECT('nm_dokter');   
        $this->db->where('id_dokter', $id_dokter);
        $query = $this->db->get();
        return $query->row();
    }   

    /////////////////////////////////// Rawat Jalan ///////////////////////////////////

    function show_pelayanan_irj($no_register) {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner'); 
        $this->db->JOIN('data_dokter', 'daftar_ulang_irj.id_dokter = data_dokter.id_dokter', 'left');          
        $this->db->SELECT("daftar_ulang_irj.no_sep,data_pasien.no_kartu,DATE_FORMAT(daftar_ulang_irj.tgl_kunjungan, '%Y-%m-%d 00:00:00') as tgl_masuk,DATE_FORMAT(daftar_ulang_irj.tgl_pulang, '%Y-%m-%d 00:00:00') as tgl_pulang,daftar_ulang_irj.id_dokter,data_pasien.no_cm,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.jenis_identitas,data_pasien.no_identitas,data_pasien.sex as gender,daftar_ulang_irj.no_medrec,daftar_ulang_irj.id_poli,daftar_ulang_irj.ket_pulang,data_pasien.kelas_bpjs,data_dokter.nm_dokter");   
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    } 

    function diagnosa_irj($no_register) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('diagnosa_pasien', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'inner');
        $this->db->SELECT('diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
        $this->db->where('daftar_ulang_irj.no_register', $no_register);
        $query = $this->db->get();
        return $query->result();
    }    

    function procedure_irj($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
        $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.nm_procedure,icd9cm_irj.klasifikasi_procedure');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }      

    /////////////////////////////////// Rawat Inap /////////////////////////////////// 

    function show_pelayanan_iri($no_register) {
        $this->db->FROM('pasien_iri as a');
        $this->db->JOIN('data_pasien as b', 'a.no_cm = b.no_medrec', 'inner');          
        $this->db->SELECT("a.no_sep,a.vtot_rad,a.vtot_obat,a.vtot_lab,a.biaya_alkes,b.no_kartu,DATE_FORMAT(a.tgl_masuk, '%Y-%m-%d 00:00:00') as tgl_masuk,DATE_FORMAT(a.tgl_keluar, '%Y-%m-%d 00:00:00') as tgl_keluar,a.id_dokter,b.no_cm,a.klsiri,b.nama,b.tgl_lahir,b.jenis_identitas,b.no_identitas,b.sex as gender,a.keadaanpulang,b.kelas_bpjs");   
        $this->db->where('no_ipd', $no_register);
        $query = $this->db->get();
        return $query->row();
    }  

    function diagnosa_iri($no_register) 
    {
        $this->db->FROM('pasien_iri');
        $this->db->JOIN('diagnosa_iri', 'pasien_iri.no_ipd = diagnosa_iri.no_register', 'inner');
        $this->db->SELECT('pasien_iri.no_ipd as no_register,diagnosa_iri.nm_dokter,diagnosa_iri.id_diagnosa,diagnosa_iri.klasifikasi_diagnos,diagnosa_iri.diagnosa');   
        $this->db->where('pasien_iri.no_ipd', $no_register);
        $query = $this->db->get();
        return $query->result();
    }    

    function procedure_iri($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
        $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.nm_procedure,icd9cm_irj.klasifikasi_procedure');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }   

    ////GET TARIF ////
    function getdata_tindakan_pasien_rj($no_register){
        return $this->db->query("SELECT a.nmtindakan,a.vtot,c.nm_poli,d.idkel_inacbg FROM pelayanan_poli a INNER JOIN daftar_ulang_irj b ON a.no_register=b.no_register LEFT JOIN poliklinik c ON c.id_poli=a.id_poli LEFT JOIN jenis_tindakan d ON d.idtindakan=a.idtindakan WHERE b.no_reg_parent='$no_register' ORDER BY b.tgl_kunjungan ASC");
    }

    function getdata_lab_pasien($no_register){
        return $this->db->query("SELECT a.jenis_tindakan,a.vtot,b.idkel_inacbg FROM pemeriksaan_laboratorium a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan WHERE a.no_register='$no_register' AND a.no_lab IS NOT NULL AND a.cara_bayar='BPJS'");
    }

    function getdata_pa_pasien($no_register){
        return $this->db->query("SELECT a.no_register,a.jenis_tindakan,a.vtot,b.idkel_inacbg FROM pemeriksaan_patologianatomi a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan WHERE a.no_register='$no_register' AND a.no_pa IS NOT NULL AND a.cara_bayar='BPJS'");
    }
    
    function getdata_lab_pasien_rj($no_register){
        return $this->db->query("SELECT a.jenis_tindakan,a.vtot,b.idkel_inacbg FROM pemeriksaan_laboratorium a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan LEFT JOIN daftar_ulang_irj c ON a.no_register=c.no_register WHERE c.no_reg_parent='$no_register' AND a.no_lab IS NOT NULL");
    }
    
    function getdata_rad_pasien_rj($no_register){
        return $this->db->query("SELECT a.jenis_tindakan,a.vtot,b.idkel_inacbg FROM pemeriksaan_radiologi a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan LEFT JOIN daftar_ulang_irj c ON a.no_register=c.no_register WHERE c.no_reg_parent='$no_register' AND a.no_rad IS NOT NULL");
    }

    function getdata_rad_pasien($no_register){
        return $this->db->query("SELECT a.jenis_tindakan,a.vtot,b.idkel_inacbg FROM pemeriksaan_radiologi a LEFT JOIN jenis_tindakan b ON a.id_tindakan=b.idtindakan WHERE a.no_register='$no_register' AND a.no_rad IS NOT NULL AND a.cara_bayar='BPJS'");
    }

    function getdata_resep_pasien($no_register){
        return $this->db->query("SELECT a.nama_obat,a.vtot,a.no_register FROM resep_pasien a WHERE a.no_register='$no_register' AND a.no_resep IS NOT NULL AND a.cara_bayar='BPJS'");
    }

    function getdata_ok_pasien($no_register){
        return $this->db->query("SELECT A.no_register,B.jenis_tindakan,B.vtot,D.idkel_inacbg FROM operasi_header A INNER JOIN pemeriksaan_operasi B ON A.no_register=B.no_register INNER JOIN jenis_tindakan D ON B.id_tindakan=D.idtindakan WHERE A.no_register='$no_register'");
    }

    // function getdata_ok_pasien($no_register){
    //     return $this->db->query("SELECT A.no_register,B.jenis_tindakan,B.vtot,D.idkel_inacbg FROM operasi_header A INNER JOIN pemeriksaan_operasi B ON A.no_register=B.no_register INNER JOIN jenis_tindakan D ON B.id_tindakan=D.idtindakan WHERE A.no_register='$no_register'");
    // }

    function insert_inacbg_tarif_rs($data){
        $this->db->insert('inacbg_tarif_rs', $data);
        return true;
    }
    
    function getdata_resep_pasien_rj($no_register){
        return $this->db->query("SELECT a.nama_obat,a.vtot FROM resep_pasien a LEFT JOIN daftar_ulang_irj b ON a.no_register=b.no_register WHERE b.no_reg_parent='$no_register' AND a.no_resep IS NOT NULL");
    }
    
    function getdata_ok_pasien_rj($no_register){
        return $this->db->query("SELECT B.jenis_tindakan,B.vtot,D.idkel_inacbg FROM operasi_header A INNER JOIN pemeriksaan_operasi B ON A.no_register=B.no_register INNER JOIN daftar_ulang_irj C ON A.no_register=C.no_register INNER JOIN jenis_tindakan D ON B.id_tindakan=D.idtindakan WHERE C.no_reg_parent='$no_register'");
    }

    function get_noregasal($no_register){
        return $this->db->query("SELECT noregasal FROM pasien_iri WHERE no_ipd='$no_register'");
    }

    function getdata_tindakan_pasien_ri($no_register){
        return $this->db->query("SELECT c.nmtindakan,a.vtot,c.idkel_inacbg FROM pelayanan_iri AS a INNER JOIN jenis_tindakan AS c ON a.id_tindakan=c.idtindakan WHERE a.no_ipd='$no_register' ORDER BY c.nmtindakan ASC");
    }

    function getdata_ruangan_pasien_ri($no_register){
        return $this->db->query("SELECT a.idrg,IF (DATEDIFF(tglmasukrg,tglkeluarrg)=0,1,DATEDIFF(tglkeluarrg,tglmasukrg)) AS lama_rawat,c.total_tarif,d.nmruang,IF (DATEDIFF(tglmasukrg,tglkeluarrg)=0,c.total_tarif,(DATEDIFF(tglkeluarrg,tglmasukrg)*c.total_tarif)) AS vtot FROM ruang_iri AS a LEFT JOIN ruang AS d ON a.idrg=d.idrg LEFT JOIN tarif_tindakan AS c ON a.idrg=RIGHT (c.id_tindakan,4) AND a.kelas=c.kelas WHERE a.no_ipd='$no_register' AND c.id_tindakan LIKE '1%' ORDER BY tglmasukrg ASC");
    }

    function get_selisih_hari($no_register){
        return $this->db->query("SELECT IF(DATEDIFF(tgl_keluar,tgl_masuk)=0,1,DATEDIFF(tgl_keluar,tgl_masuk)) as selisih_hari FROM pasien_iri where no_ipd='$no_register'");
    }

    function get_pasien_billing($no_register) {
        if (substr($no_register, 0,2) == 'RJ') {  
            $this->db->from('daftar_ulang_irj as a');
            $this->db->join('data_pasien as b', 'a.no_medrec = b.no_medrec', 'inner');
            $this->db->join('data_dokter as c', 'a.id_dokter = c.id_dokter', 'left');
            $this->db->join('poliklinik as d', 'a.id_poli = d.id_poli', 'left');
            $this->db->select('b.nama,b.tgl_lahir,b.no_cm,b.no_kartu,b.sex,a.tgl_kunjungan as tgl_masuk,a.no_sep,a.cara_bayar,c.nm_dokter,d.nm_poli as unit');   
            $this->db->where('no_register', $no_register);
            $query = $this->db->get();
            return $query->row();
        }

        if (substr($no_register, 0,2) == 'RI') {  
            $this->db->from('pasien_iri as a');
            $this->db->join('data_pasien as b', 'a.no_cm = b.no_medrec', 'inner');
            $this->db->join('data_dokter as c', 'a.id_dokter = c.id_dokter', 'left');
            $this->db->join('ruang as d', 'a.idrg = d.idrg', 'left');
            $this->db->select('b.nama,b.tgl_lahir,b.no_cm,b.no_kartu,b.sex,a.tgl_masuk,a.no_sep,a.carabayar as cara_bayar,c.nm_dokter,d.nmruang as unit');   
            $this->db->where('no_ipd', $no_register);
            $query = $this->db->get();
            return $query->row();
        }
    }
                                                                     
}
?>