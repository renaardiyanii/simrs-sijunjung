<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Murikes extends CI_Model {
        var $column_order = array('idurikes','nomor_kode','nip','nama','tgl_lahir','umur','tgl_pemeriksaan','golongan','ket_urikes',null );
        var $column_search = array('urikkes_pasien.idurikes','urikkes_pasien.nomor_kode','urikkes_pasien.nip','urikkes_pasien.nama','urikkes_pasien.tgl_lahir','urikkes_pasien.umur','urikkes_pasien.tgl_pemeriksaan','urikkes_pasien.golongan','urikkes_pasien.ket_urikes'); 
        var $order = array('idurikes' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_datatables_query()  {
            $user = $this->input->post('roleid');

            $this->db->FROM('urikkes_pasien');
            $this->db->select('idurikes, nomor_kode, nip ,nama, tgl_lahir,umur, tgl_pemeriksaan, golongan, ket_urikes');
            $this->db->where('urikkes_pasien.nomor_kode !=',' ');

            $i = 0;     
            foreach ($this->column_search as $item)
            {
                if($_POST['search']['value'])
                {
                     
                    if($i===0)
                    {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order))
            {
                $order = $this->order;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function get_pasien_urikes()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function count_all()
        {
             $user = $this->input->post('roleid');

            $this->db->FROM('urikkes_pasien');
            $this->db->select('idurikes, nomor_kode, nip ,nama, tgl_lahir,umur, tgl_pemeriksaan, golongan, ket_urikes');
            $this->db->where('urikkes_pasien.nomor_kode !=',' ');

            if($user != '58' && $user != '1' && $user != '45' ){
                $this->db->where('urikkes_pasien.tgl_pemeriksaan', date('Y-m-d'));
            }
        
            return $this->db->count_all_results();
        }

        function getdata_rekap_urikkes(){
            $datenow=date('Y');
            $data= $this->db->query(" SELECT urikes.kdpangkat,
                                    COALESCE( t_militer_ba.frekuensi, 0) as s_militer_pamen 
                                       FROM urikkes_pasien as urikes
                                       LEFT JOIN ( SELECT tni_pangkat.pangkat,urikkes_pasien.kdpangkat, SUBSTRING(golongan,5) as gol,
                                                   Count(urikkes_pasien.nomor_kode) AS frekuensi
                                                    FROM    urikkes_pasien
                                                   LEFT JOIN tni_pangkat ON tni_pangkat.pangkat_id = urikkes_pasien.kdpangkat
                                                   WHERE urikkes_pasien.kelompok = 'M' AND left(tgl_pemeriksaan,4)='2018'
                                                   GROUP BY urikkes_pasien.kdpangkat) t_militer_ba
                                                   on urikes.kdpangkat=t_militer_ba.kdpangkat
                                    GROUP BY urikes.kdpangkat ASC");
            return $data->result_array();
        }
      
        function getdata_pasien_urikkes($idurikes,$date){
            return $this->db->query("SELECT CONCAT(a.kst_id,'@',a.kst2_id,'@',a.kst3_id) as kesatuan_gab , a.*,c.nmtindakan as nama_pemeriksaan, SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5) as gol, b.pangkat as nm_pangkat FROM urikkes_pasien a left join tni_pangkat_urikes b on a.kdpangkat=b.pangkat_id 
                left JOIN jenis_tindakan c on a.jenis_pemeriksaan=c.idtindakan where a.idurikes='$idurikes' and a.tgl_daftar!='$date'");
        }

        function getdata_paket(){
            return $this->db->query("SELECT id_tindakan, total_tarif, nmtindakan from tarif_tindakan a left join jenis_tindakan b on a.id_tindakan=b.idtindakan where a.id_tindakan LIKE'BZ03%'");
        }

        function get_dokter_urikes(){
            return $this->db->query("SELECT dd.* FROM data_dokter AS dd LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter WHERE id_poli='BZ03' and dd.deleted='0' group by dd.id_dokter ORDER BY nm_dokter");            
        }
         function getdata_diagnosa(){
            return $this->db->query("SELECT id_icd, nm_diagnosa from icd1 Order BY id asc");
        }

        // function getdata_laporan_bulanan($tgl1, $tgl2, $tingkatan){
        //     return $this->db->query("SELECT a.*, SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5,7) as gol, b.pangkat as nm_pangkat, b.tingkatan, b.intensif, c.* FROM urikkes_pasien a 
        //         left JOIN tni_pangkat b on a.kdpangkat=b.pangkat_id 
        //         left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
        //         where b.tingkatan IN (Select tingkatan from tni_pangkat where tingkatan like '%$tingkatan%' group by tingkatan DESC) 
        //         and kelompok !='MT'
        //          and a.kesatuan NOT LIKE '%Diskomlekal%'
        //             and a.kesatuan NOT LIKE '%pushidrosal%'
        //             and a.kesatuan NOT LIKE '%spersal%'
        //             and a.kesatuan NOT LIKE '%disminpersal%'
        //             and a.kesatuan NOT LIKE '%spersal%'
        //             and a.kesatuan NOT LIKE '%diskual%'
        //             and a.kesatuan NOT LIKE '%sopsal%'
        //             and a.kesatuan NOT LIKE '%dislitbangsal%'
        //             and a.kesatuan NOT LIKE '%dislitbangal%'
        //             and a.kesatuan NOT LIKE '%dislaikmatal%'
        //             and a.kesatuan NOT LIKE '%slogal%'
        //             and a.kesatuan NOT LIKE '%diskesal%'
        //             and a.kesatuan NOT LIKE '%dismatal%'
        //             and a.kesatuan NOT LIKE '%disdikal%'
        //             and a.kesatuan NOT LIKE '%disadal%'
        //             and a.kesatuan NOT LIKE '%puspenerbal%'
        //             and a.kesatuan NOT LIKE '%dissenlekal%'
        //             and a.kesatuan NOT LIKE '%itjenal%'
        //             and a.kesatuan NOT LIKE '%disfaslanal%'
        //             and a.kesatuan NOT LIKE '%dispamal%'
        //             and a.kesatuan NOT LIKE '%puspomal%'
        //             and a.kesatuan NOT LIKE '%srenal%'
        //             and a.kesatuan NOT LIKE '%diskumal%'
        //             and a.kesatuan NOT LIKE '%disbekal%'
        //             and a.kesatuan NOT LIKE '%stumal%'
        //             and a.kesatuan NOT LIKE '%disinf%'
        //             and a.kesatuan NOT LIKE '%smin%'
        //             and a.kesatuan NOT LIKE '%puskodal%'
        //             and a.kesatuan NOT LIKE '%mabesal%'
        //             and a.kesatuan NOT LIKE '%drosal%'
        //             and a.golongan is not null 
        //         AND a.tgl_pemeriksaan between '$tgl1' AND '$tgl2'");
        // }
       
        function getdata_pemeriksaan_umum_urikkes($idurikes){
            return $this->db->query("SELECT * , SUBSTRING(kardiologi,1,4) as kardiologi1, SUBSTRING(kardiologi,4) as kardio 
            , SUBSTRING(penyakit_dalam,1,4) as pd1, SUBSTRING(penyakit_dalam,4) as pd
            , SUBSTRING(bedah,1,4) as b1, SUBSTRING(bedah,4) as b
            , SUBSTRING(tht_audiometri,1,4) as tht1, SUBSTRING(tht_audiometri,4) as tht
            , SUBSTRING(mata,1,4) as m1, SUBSTRING(mata,4) as m
            , SUBSTRING(saraf,1,4) as s1, SUBSTRING(saraf,4) as s
            , SUBSTRING(gigi,1,4) as g1, SUBSTRING(gigi,4) as g
            , SUBSTRING(laboratorium,1,4) as l1, SUBSTRING(laboratorium,4) as l
            , SUBSTRING(radiologi,1,4) as r1, SUBSTRING(radiologi,4) as r
            , SUBSTRING(usg,1,4) as u1, SUBSTRING(usg,4) as u
            , SUBSTRING(spirometri,1,4) as sp1, SUBSTRING(spirometri,4) as sp
            , SUBSTRING(pap_semar,1,4) as ps1, SUBSTRING(pap_semar,4) as ps
            , SUBSTRING(lain_lain,1,4) as ll1, SUBSTRING(lain_lain,4) as ll FROM urikkes_pemeriksaan_umum where idurikes='$idurikes'");
        }
        function getdata_resume_pemeriksaan_umum_urikkes($idurikes){
            return $this->db->query("SELECT * FROM urikkes_resume_pemeriksaan_detail where idurikes='$idurikes'");
        }
        

    function kelompok($kode,$datenow){
         
         $data=$this->db->query("SELECT kelompok from urikkes_pasien where idurikes='$kode' AND left(tgl_daftar,4)='$datenow' ");
        
         return $data;
    }
    function tingkat_pangkat($pangkat){
         
         return $this->db->query("SELECT b.pokpangkat from tni_pangkat_urikes b left join urikkes_pasien a on b.pangkat_id=a.kdpangkat where kdpangkat='$pangkat' GROUP BY b.pokpangkat ");
    }

    function get_max_nokode($kode,$datenow){
         
         $data=$this->db->query("SELECT IFNULL(CONCAT('".$kode."-', LPAD (max(right(nomor_kode,4)),4,0) ),
                '".$kode."-0001') AS nomor_kode
                        FROM (SELECT * FROM urikkes_pasien) as a
                        where kelompok = '".$kode."' AND left(tgl_pemeriksaan,4)='$datenow' ");
        
         return $data;
    }

    function get_max_idurikes($nama){
         
         $data=$this->db->query("SELECT max(idurikes) as kode from urikkes_pasien where nama='$nama' ");
        
         return $data;
    }

    function get_pangkat(){
            return $this->db->query("SELECT * FROM tni_pangkat_urikes ORDER BY urutan asc");
        }

    function get_data_pasien_by_no_urikes($no_urikes){
            return $this->db->query("SELECT * FROM urikkes_pasien where idurikes='$no_urikes'");
        }
    function get_data_pasien_by_nrp($no_nrp){
            return $this->db->query("SELECT * FROM urikkes_pasien where nip='$no_nrp' ");
        }
    function get_data_pasien_by_nama($nama){
            return $this->db->query("SELECT * FROM urikkes_pasien where nama LIKE '%$nama%'");
        }

    function cek_urutan($pangkat){
            return $this->db->query("SELECT urutan from tni_pangkat_urikes where pangkat_id='$pangkat'");   
    }
    function cek_kesatuan_minto($idurikes){
            return $this->db->query("SELECT kst3_id FROM urikkes_pasien WHERE kst2_id=20 and kst3_id=7 and idurikes=$idurikes");   
    }
     function get_pangkat_pasien($idurikes){
            return $this->db->query("SELECT kdpangkat FROM urikkes_pasien WHERE idurikes=$idurikes");
        }

    function update_edit_data_pasien($idurikes,$table1,$data){
        $this->db->where('idurikes', $idurikes);
            $this->db->update($table1, $data);
            $id_table1    = $this->db->insert_id();
         $returndata  = array($table1 => $id_table1);

            return $returndata;
    }
     function update_pasien_urikes_skd($idurikes,$table1, $data, $table2, $data1){
            $this->db->where('idurikes', $idurikes);
            $this->db->update($table1, $data);
            $id_table1    = $this->db->insert_id();
            
            $this->db->where('idurikes', $idurikes);
            $this->db->update($table2, $data1);
            $id_table2    = $this->db->insert_id();

            $returndata  = array($table1 => $id_table1, $table2 =>$id_table2);

            return $returndata;
        } 
    function update_pasien_urikes($idurikes,$table1, $data, $table2, $data1, $table3, $data2){
            $this->db->where('idurikes', $idurikes);
            $this->db->update($table1, $data);
            $id_table1    = $this->db->insert_id();
            
            $this->db->where('idurikes', $idurikes);
            $this->db->update($table2, $data1);
            $id_table2    = $this->db->insert_id();
            
            $this->db->where('idurikes', $idurikes);
            $this->db->update($table3, $data2);
            $id_table3    = $this->db->insert_id();

            $returndata  = array($table1 => $id_table1, $table2 =>$id_table2, $table3=>$id_table3);

            return $returndata;
        } 

       public function insert_pasien_urikes($kode ,$table1, $data, $table2="", $data1="", $table3="", $data2=""){
           
            $datenow=date('Y');
            $this->db->set('nomor_kode', "(SELECT IFNULL(CONCAT('".$kode."-', LPAD (max(right(nomor_kode,4))+1 ,4,0) ),
                '".$kode."-0001') 
                        FROM (SELECT * FROM urikkes_pasien) AS a 
                        where kelompok='".$kode."' AND left(tgl_daftar,4)='$datenow' )", FALSE);

            $this->db->insert($table1, $data);
            $id_table1    = $this->db->insert_id();

            $this->db->set('nomor_kode', "(SELECT IFNULL(CONCAT('".$kode."-', LPAD (max(right(nomor_kode,4)) ,4,0) ),
                '".$kode."-0001') 
                        FROM (SELECT * FROM urikkes_pasien) AS a 
                        where kelompok='".$kode."' AND  left(tgl_daftar,4)='$datenow' )", FALSE);

            $this->db->insert($table2, $data1);
            $id_table2    = $this->db->insert_id();

            $this->db->set('nomor_kode', "(SELECT IFNULL(CONCAT('".$kode."-', LPAD (max(right(nomor_kode,4)) ,4,0) ),
                '".$kode."-0001') 
                        FROM (SELECT * FROM urikkes_pasien) AS a 
                        where kelompok='".$kode."' AND  left(tgl_daftar,4)='$datenow' )", FALSE);
            $this->db->insert($table3, $data2);
            $id_table3    = $this->db->insert_id();

            $return_data= array($table1 => $id_table1, $table2 =>$id_table2, $table3=>$id_table3);

            return $returndata;
        }

    

    function data_laporan($idurikes){
            return $this->db->query("SELECT 
                 e.kst_nama,f.kst2_nama,g.kst3_nama, a.*,SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5) as gol,
                     h.nm_diagnosa as diagkar,
                     i.nm_diagnosa as diagpeda, 
                     j.nm_diagnosa as diagbedah,
                     k.nm_diagnosa as diagtht,
                     l.nm_diagnosa as diagmata,                              
                     m.nm_diagnosa as diagsaraf,
                     n.nm_diagnosa as diaggigi,
                     o.nm_diagnosa as diaglab,
                     p.nm_diagnosa as diagrad,
                     q.nm_diagnosa as diagusg,
                     r.nm_diagnosa as diagspiro,
                     s.nm_diagnosa as diagpap,
                     t.nm_diagnosa as diaglain, 
                     b.*
                     ,SUBSTRING(b.kardiologi,1,4) as kardiologi1, SUBSTRING(b.kardiologi,4) as kardio 
                    , SUBSTRING(b.penyakit_dalam,1,4) as pd1, SUBSTRING(b.penyakit_dalam,4) as pd
                    , SUBSTRING(b.bedah,1,4) as b1, SUBSTRING(b.bedah,4) as b
                    , SUBSTRING(b.tht_audiometri,1,4) as tht1, SUBSTRING(b.tht_audiometri,4) as tht
                    , SUBSTRING(b.mata,1,4) as m1, SUBSTRING(b.mata,4) as m
                    , SUBSTRING(b.saraf,1,4) as s1, SUBSTRING(b.saraf,4) as s
                    , SUBSTRING(b.gigi,1,4) as g1, SUBSTRING(b.gigi,4) as g
                    , SUBSTRING(b.laboratorium,1,4) as l1, SUBSTRING(b.laboratorium,4) as l
                    , SUBSTRING(b.radiologi,1,4) as r1, SUBSTRING(b.radiologi,4) as r
                    , SUBSTRING(b.usg,1,4) as u1, SUBSTRING(b.usg,4) as u
                    , SUBSTRING(b.spirometri,1,4) as sp1, SUBSTRING(b.spirometri,4) as sp
                    , SUBSTRING(b.pap_semar,1,4) as ps1, SUBSTRING(b.pap_semar,4) as ps
                    , SUBSTRING(b.lain_lain,1,4) as ll1, SUBSTRING(b.lain_lain,4) as ll 
                    ,a.nomor_kode as kode,                 
                    c.*,d.* FROM
                  urikkes_pasien AS a 
                left join urikkes_pemeriksaan_umum as b 
                ON a.idurikes = b.idurikes 
                left join urikkes_resume_pemeriksaan_detail as c on a.idurikes = c.idurikes
                left join tni_pangkat_urikes d on a.kdpangkat = d.pangkat_id
                left join tni_kesatuan e on a.kst_id = e.kst_id
                left join tni_kesatuan2 f on a.kst2_id = f.kst2_id
                left join tni_kesatuan3 g on a.kst3_id = g.kst3_id
                LEFT join icd1 h on h.id_icd=b.kar_keterangan
                LEFT join icd1 i on i.id_icd=b.peda_keterangan
                LEFT join icd1 j on j.id_icd=b.bedah_keterangan
                LEFT join icd1 k on k.id_icd=b.tht_keterangan
                LEFT join icd1 l on l.id_icd=b.mata_keterangan
                LEFT join icd1 m on m.id_icd=b.saraf_keterangan
                LEFT join icd1 n on n.id_icd=b.gigi_keterangan
                LEFT join icd1 o on o.id_icd=b.lab_keterangan
                LEFT join icd1 p on p.id_icd=b.rad_keterangan
                LEFT join icd1 q on q.id_icd=b.usg_keterangan
                LEFT join icd1 r on r.id_icd=b.spiro_keterangan
                LEFT join icd1 s on s.id_icd=b.pap_keterangan
                LEFT join icd1 t on t.id_icd=b.lain_keterangan
                where a.idurikes='$idurikes' GROUP BY (a.idurikes)
                ");
        }

     function data_rekapitulasi($nomor_kode){ //gadipake
            return $this->db->query("SELECT 
                 a.*,SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5) as gol
                 ,b.*,SUBSTRING(b.kardiologi,1,4) as kardiologi1, SUBSTRING(b.kardiologi,4) as kardio 
            , SUBSTRING(b.penyakit_dalam,1,4) as pd1, SUBSTRING(b.penyakit_dalam,4) as pd
            , SUBSTRING(b.bedah,1,4) as b1, SUBSTRING(b.bedah,4) as b
            , SUBSTRING(b.tht_audiometri,1,4) as tht1, SUBSTRING(b.tht_audiometri,4) as tht
            , SUBSTRING(b.mata,1,4) as m1, SUBSTRING(b.mata,4) as m
            , SUBSTRING(b.saraf,1,4) as s1, SUBSTRING(b.saraf,4) as s
            , SUBSTRING(b.gigi,1,4) as g1, SUBSTRING(b.gigi,4) as g
            , SUBSTRING(b.laboratorium,1,4) as l1, SUBSTRING(b.laboratorium,4) as l
            , SUBSTRING(b.radiologi,1,4) as r1, SUBSTRING(b.radiologi,4) as r
            , SUBSTRING(b.usg,1,4) as u1, SUBSTRING(b.usg,4) as u
            , SUBSTRING(b.spirometri,1,4) as sp1, SUBSTRING(b.spirometri,4) as sp
            , SUBSTRING(b.pap_semar,1,4) as ps1, SUBSTRING(b.pap_semar,4) as ps
            , SUBSTRING(b.lain_lain,1,4) as ll1, SUBSTRING(b.lain_lain,4) as ll 
            , c.*, d.* FROM
                  urikkes_pasien AS a 
                    left join urikkes_pemeriksaan_umum as b 
                    ON a.idurikes = b.idurikes 
                    left join urikkes_resume_pemeriksaan_detail as c on a.idurikes = c.idurikes
                    left join tni_pangkat d on a.kdpangkat = d.pangkat_id
                    where a.idurikes='$nomor_kode' GROUP BY (a.nomor_kode)
                ");
        }
        
        function get_tindakan_paket($no_kode){
        return $this->db->query("SELECT kode_tindakan FROM urikkes_master_paket_detail WHERE kode_paket  = '$no_kode' AND poli_paket='Lab'");
        }

        function get_tindakan_lab($no_kode){
            return $this->db->query("SELECT c.nmtindakan  
                                    FROM
                                    urikkes_pasien a
                                    left join 
                                    urikkes_master_paket_detail b
                                    on a.jenis_pemeriksaan = b.kode_paket
                                    left join
                                    jenis_tindakan c
                                    on b.kode_tindakan=c.idtindakan
                                    where a.nomor_kode='$no_kode'
                                    AND b.poli_paket='BZ04'");
        }                                                        

         function get_tindakan_rad($no_kode){
            return $this->db->query("SELECT c.nmtindakan  
                                    FROM
                                    urikkes_pasien a
                                    left join 
                                    urikkes_master_paket_detail b
                                    on a.jenis_pemeriksaan = b.kode_paket
                                    left join
                                    jenis_tindakan c
                                    on b.kode_tindakan=c.idtindakan
                                    where a.nomor_kode='$no_kode'
                                    AND b.poli_paket='BZ02'");
        }       

        function download_laporan($date1='',$date2='') 
        {   
            return $this->db->query("
                select klasifikasi ,total ,pangkat from urikes_laporan where tgl_pemeriksaan <= '$date2' AND tgl_pemeriksaan >= '$date1'
                ");
        }  
        
        function get_rek_minto($date1='',$date2='')  //khusus minto
        {   
            return $this->db->query("
                SELECT a.kelompok, a.nama, a.umur, a.kesatuan, a.tgl_pemeriksaan, SUBSTRING(a.golongan,5,7) as statkes, f.kst3_nama as kesatuan_gab, b.pangkat, b.pokpangkat as tingkatan, b.intensif, b.urutan from urikkes_pasien a 
                      left join tni_pangkat_urikes b on a.kdpangkat = b.pangkat_id 
                      left JOIN tni_kesatuan d on a.kst_id = d.Kst_id 
                      left JOIN tni_kesatuan2 e on a.kst2_id = e.kst2_id 
                      left JOIN tni_kesatuan3 f on a.kst3_id = f.kst3_id
                where a.kst3_id='7' and a.kst2_id='20' and a.kst_id='1' AND a.tgl_pemeriksaan>='$date1' AND a.tgl_pemeriksaan<='$date2'
            ");
        }

         function get_rek_ex_mabesal($date1='',$date2='') //keseluruhan tanpa mabesal
        {   
            return $this->db->query("
                SELECT a.kelompok, a.nama, a.umur, a.kesatuan, a.tgl_pemeriksaan,  IFNULL(CONCAT(d.kst_nama,'-',e.kst2_nama),d.kst_nama) as kesatuan_gab, SUBSTRING(a.golongan,5,7) as statkes, b.pangkat, b.pokpangkat as tingkatan, b.urutan, b.intensif from urikkes_pasien a left join tni_pangkat_urikes b on a.kdpangkat = b.pangkat_id 
                            LEFt JOIN tni_kesatuan d on a.kst_id = d.Kst_id 
                            left JOIN tni_kesatuan2 e on a.kst2_id = e.kst2_id 
                            left JOIN tni_kesatuan3 f on a.kst3_id = f.kst3_id 
                    where a.kst_id!='1'
                    AND a.tgl_pemeriksaan>='$date1' AND a.tgl_pemeriksaan<='$date2'
            ");
        }  
        

         function getdata_laporan_bulanan($tgl1, $tgl2){ // keseluruhan militer
            return $this->db->query("
                SELECT a.*, IFNULL(CONCAT(d.kst_nama,'-',e.kst2_nama),d.kst_nama) as kesatuan_gab, SUBSTRING(a.golongan,1,4) as golongan1 , SUBSTRING(a.golongan,5,7) as statkes, b.pangkat as nm_pangkat, b.pokpangkat as tingkatan, b.intensif, b.urutan, c.* FROM urikkes_pasien a 
                        left JOIN tni_pangkat_urikes b on a.kdpangkat=b.pangkat_id 
                        left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
                        left JOIN tni_kesatuan d on a.kst_id = d.Kst_id 
                        left JOIN tni_kesatuan2 e on a.kst2_id = e.kst2_id 
                        left JOIN tni_kesatuan3 f on a.kst3_id = f.kst3_id
                where kelompok ='M'
                AND a.tgl_pemeriksaan>='$tgl1' AND a.tgl_pemeriksaan<='$tgl2'
                ");
        }
        function getdata_laporan_bulanan_umum($tgl1, $tgl2){ // keseluruhan umum
            return $this->db->query("
                SELECT a.*, SUBSTRING(a.golongan,1,4) as golongan1 , SUBSTRING(a.golongan,5,7) as statkes, c.* FROM urikkes_pasien a 
                        left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
                where kelompok ='X'
                AND a.tgl_pemeriksaan>='$tgl1' AND a.tgl_pemeriksaan<='$tgl2'
                ");
        }

         function getdata_laporan_bulanan_mt($tgl1, $tgl2){ // keseluruhan militer
            return $this->db->query("
                SELECT a.*, IFNULL(CONCAT(d.kst_nama,'-',e.kst2_nama),d.kst_nama) as kesatuan_gab, SUBSTRING(a.golongan,1,4) as golongan1 , SUBSTRING(a.golongan,5,7) as statkes, b.pangkat as nm_pangkat, b.pokpangkat as tingkatan, b.intensif, b.urutan, c.* FROM urikkes_pasien a 
                        left JOIN tni_pangkat_urikes b on a.kdpangkat=b.pangkat_id 
                        left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
                        left JOIN tni_kesatuan d on a.kst_id = d.Kst_id 
                        left JOIN tni_kesatuan2 e on a.kst2_id = e.kst2_id 
                        left JOIN tni_kesatuan3 f on a.kst3_id = f.kst3_id
                where a.kst_id='9'
                AND a.tgl_pemeriksaan>='$tgl1' AND a.tgl_pemeriksaan<='$tgl2'
                ");
        }
        // function getdata_khusus_mt($tgl1, $tgl2){
        //     return $this->db->query("SELECT a.*, SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5,7) as statkes, b.urutan, b.pangkat as nm_pangkat, b.tingkatan, b.intensif, c.* FROM urikkes_pasien a 
        //         left JOIN tni_pangkat_urikes b on a.kdpangkat=b.pangkat_id 
        //         left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
        //         where 
        //         -- b.tingkatan IN (Select tingkatan from tni_pangkat group by tingkatan DESC) 
        //         a.kelompok ='MT'
        //         and a.golongan is not null 
        //         AND a.tgl_pemeriksaan>='$tgl1' AND a.tgl_pemeriksaan<='$tgl2' ");
        // }
         function get_rek_mabesal($date1='',$date2='') 
        {   
            return $this->db->query("
                SELECT a.*, IFNULL(CONCAT(d.kst_nama,'-',e.kst2_nama),d.kst_nama) as kesatuan_gab, SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5,7) as statkes, b.pangkat as nm_pangkat, b.pokpangkat as tingkatan, b.urutan, b.intensif, c.* FROM urikkes_pasien a 
                        left JOIN tni_pangkat_urikes b on a.kdpangkat=b.pangkat_id 
                        left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
                        left JOIN tni_kesatuan d on a.kst_id = d.Kst_id 
                        left JOIN tni_kesatuan2 e on a.kst2_id = e.kst2_id 
                        left JOIN tni_kesatuan3 f on a.kst3_id = f.kst3_id
                where kelompok !='MT' and a.kst_id='1'
                AND a.tgl_pemeriksaan>='$date1' AND a.tgl_pemeriksaan<='$date2'
            ");
        }
        function getdata_laporan_bulanan_mabes($tgl1, $tgl2){ //mabes tni
            return $this->db->query("SELECT a.*, SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5,7) as gol, b.urutan, b.pangkat as nm_pangkat, b.tingkatan, b.intensif, c.* FROM urikkes_pasien a 
                left JOIN tni_pangkat b on a.kdpangkat=b.pangkat_id 
                left JOIN urikkes_pemeriksaan_umum c on a.idurikes = c.idurikes 
                where b.tingkatan IN (Select tingkatan from tni_pangkat group by tingkatan DESC) 
                and kelompok !='MT' and a.golongan is not null
                 and (a.kesatuan LIKE '%Diskomlekal%'
                    or a.kesatuan LIKE '%pushidrosal%'
                    or a.kesatuan LIKE '%spersal%'
                    or a.kesatuan LIKE '%disminpersal%'
                    or a.kesatuan LIKE '%spersal%'
                    or a.kesatuan LIKE '%diskual%'
                    or a.kesatuan LIKE '%sopsal%'
                    or a.kesatuan LIKE '%dislitbangsal%'
                    or a.kesatuan LIKE '%dislitbangal%'
                    or a.kesatuan LIKE '%dislaikmatal%'
                    or a.kesatuan LIKE '%slogal%'
                    or a.kesatuan LIKE '%diskesal%'
                    or a.kesatuan LIKE '%dismatal%'
                    or a.kesatuan LIKE '%disdikal%'
                    or a.kesatuan LIKE '%disadal%'
                    or a.kesatuan LIKE '%puspenerbal%'
                    or a.kesatuan LIKE '%dissenlekal%'
                    or a.kesatuan LIKE '%itjenal%'
                    or a.kesatuan LIKE '%disfaslanal%'
                    or a.kesatuan LIKE '%dispamal%'
                    or a.kesatuan LIKE '%puspomal%'
                    or a.kesatuan LIKE '%srenal%'
                    or a.kesatuan LIKE '%diskumal%'
                    or a.kesatuan LIKE '%disbekal%'
                    or a.kesatuan LIKE '%stumal%'
                    or a.kesatuan LIKE '%disinf%'
                    or a.kesatuan LIKE '%smin%'
                    or a.kesatuan LIKE '%puskodal%'
                    or a.kesatuan LIKE '%mabesal%'
                    or a.kesatuan LIKE '%drosal%')
                    
                AND a.tgl_pemeriksaan>='$date1' AND a.tgl_pemeriksaan<='$date2' ");
        }
  
	}

?>


