<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmtracer extends CI_Model {
        var $column_order = array(null,'daftar_ulang_irj.no_register','data_pasien.no_cm','poliklinik.nm_poli','daftar_ulang_irj.no_register','daftar_ulang_irj.cetak_tracer');
        var $column_search = array('daftar_ulang_irj.no_register','data_pasien.no_cm','poliklinik.nm_poli','daftar_ulang_irj.no_register','daftar_ulang_irj.cetak_tracer'); 
        var $order = array('data_pasien.no_cm' => 'desc');  

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		    private function _get_datatables($tgl_kunjungan)  {
          // strval($tgl_kunjungan)
          $this->db->from('data_pasien');
          $this->db->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec ', 'inner');
          $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
          $this->db->select('daftar_ulang_irj.no_register,data_pasien.no_cm,data_pasien.nama,poliklinik.nm_poli,daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan, daftar_ulang_irj.xuser,daftar_ulang_irj.cetak_tracer,data_pasien.tgl_daftar,daftar_ulang_irj.no_sep');
          $this->db->where("TO_CHAR(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '".$tgl_kunjungan."' " );
          // $this->db->query("SELECT daftar_ulang_irj.no_register, data_pasien.no_cm, data_pasien.nama, poliklinik.nm_poli, daftar_ulang_irj.no_register, daftar_ulang_irj.tgl_kunjungan, daftar_ulang_irj.xuser, daftar_ulang_irj.cetak_tracer, data_pasien.tgl_daftar FROM data_pasien INNER JOIN daftar_ulang_irj ON cast(data_pasien.no_medrec as integer) = cast(daftar_ulang_irj.no_medrec as integer) LEFT JOIN poliklinik ON daftar_ulang_irj.id_poli = poliklinik.id_poli WHERE tgl_kunjungan::varchar = cast(".$tgl_kunjungan ." as TEXT)");
          // $this->db->query("SELECT * 
          // FROM data_pasien 
          // INNER JOIN daftar_ulang_irj 
          // ON data_pasien.no_medrec = daftar_ulang_irj.no_medrec::integer
          // LEFT JOIN poliklinik 
          // ON daftar_ulang_irj.id_poli = poliklinik.id_poli 
          // WHERE to_char(tgl_kunjungan, 'YYYY-MM-DD') = '2021-03-12'");
          $i = 0;     
          foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
              if($i==0) {
                  $this->db->group_start();
                  $this->db->like($item, $_POST['search']['value']);
              }
              else {
                  $this->db->or_like($item, $_POST['search']['value']);
              }
              if(count($this->column_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
          }
         
          if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          } 
          else if(isset($this->order)) {
            $order = $this->order;       
            $this->db->order_by(key($order), $order[key($order)]);
          }
        }
 
        public function get_pasien($tgl_kunjungan)
        {
            $this->_get_datatables($tgl_kunjungan); 
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function count_filtered($tgl_kunjungan)
        {
            $this->_get_datatables($tgl_kunjungan);
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function count_all($tgl_kunjungan)
        {
            $this->db->from('data_pasien');
            $this->db->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec', 'inner');
            $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
            $this->db->select('daftar_ulang_irj.no_register,data_pasien.no_cm,data_pasien.nama,poliklinik.nm_poli,daftar_ulang_irj.no_register, daftar_ulang_irj.xuser,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.cetak_tracer');
            $this->db->where("TO_CHAR(daftar_ulang_irj.tgl_kunjungan, 'YYYY-MM-DD') = '".$tgl_kunjungan."' " );

            return $this->db->count_all_results();
        }



        var $column_order1 = array(null,'daftar_ulang_irj.no_register','data_pasien.no_cm','poliklinik.nm_poli','daftar_ulang_irj.no_register','daftar_ulang_irj.cetak_tracer', 'map_pasien.timein', 'map_pasien.timeout', 'map_pasien.petugas',' map_pasien.tiperawat', 'map_pasien.status', 'data_pasien.status_map');
        var $column_search1 = array('daftar_ulang_irj.no_register','data_pasien.no_cm','poliklinik.nm_poli','daftar_ulang_irj.no_register','daftar_ulang_irj.cetak_tracer', 'map_pasien.timein', 'map_pasien.timeout', 'map_pasien.petugas','map_pasien.tiperawat', 'map_pasien.status', 'data_pasien.status_map'); 
        var $order1 = array('data_pasien.no_cm' => 'desc');  
        
        private function _get_datatables1()  {
          $tgl_kunjungan = $this->input->post('tgl_kunjungan');

          $this->db->from('data_pasien');
          $this->db->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec', 'inner');
          $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
          $this->db->join('map_pasien', 'data_pasien.no_medrec = map_pasien.no_medrec AND daftar_ulang_irj.no_register=map_pasien.no_register', 'left');
          $this->db->select('daftar_ulang_irj.no_register, data_pasien.no_cm,data_pasien.nama,poliklinik.nm_poli,daftar_ulang_irj.tgl_kunjungan, daftar_ulang_irj.xcreate, daftar_ulang_irj.xuser, daftar_ulang_irj.cetak_tracer,data_pasien.tgl_daftar, map_pasien.timein, map_pasien.timeout, map_pasien.petugas, map_pasien.status, map_pasien.tiperawat, data_pasien.status_map');
          $this->db->where('LEFT(tgl_kunjungan,10)',$tgl_kunjungan);
          $this->db->where('map_pasien.timein',NULL);
          /*$this->db->group_by('data_pasien.no_medrec'); 
          $this->db->order_by('daftar_ulang_irj.no_register', 'desc'); */
          
          $i = 0;     
          foreach ($this->column_search1 as $item) {
            if($_POST['search']['value']) {
              if($i===0) {
                  $this->db->group_start();
                  $this->db->like($item, $_POST['search']['value']);
              }
              else {
                  $this->db->or_like($item, $_POST['search']['value']);
              }
              if(count($this->column_search1) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
          }
          
          if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          } 
          else if(isset($this->order1)) {
            $order = $this->order1;       
            $this->db->order_by(key($order), $order[key($order)]);
          }
        }
 
        public function get_pasien2()
        {
            $this->_get_datatables1();            
            $query = $this->db->get();     
            return $query->result();
        }

        public function get_pasien1()
        {
            $this->_get_datatables1();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();     
            return $query->result();
        }
 
        public function count_filtered1()
        {
            $this->_get_datatables1();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function count_all1()
        {
            $tgl_kunjungan = $this->input->post('tgl_kunjungan');
            $this->db->from('data_pasien');
            $this->db->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec', 'inner');
            $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'left');
            $this->db->select('daftar_ulang_irj.no_register,data_pasien.no_cm,data_pasien.nama,poliklinik.nm_poli,daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.cetak_tracer');
            $this->db->where('LEFT(tgl_kunjungan,10)',$tgl_kunjungan);  

            return $this->db->count_all_results();
        }    

        function insert_mappasien($data_insert){             
            $id=$this->db->insert('map_pasien', $data_insert);
            //echo $this->db->last_query();
            return $id;
        }

        function delete_mappasien($no_register){
          return $this->db->query("DELETE FROM map_pasien WHERE no_register='$no_register'");
        }

        function update_mappasien($no_register,$data){
          $this->db->where('no_register', $no_register);
          $id=$this->db->update('map_pasien', $data) and $this->db->query("DELETE FROM map_catatan WHERE no_register='$no_register'");
          //echo $this->db->last_query();
          return $id;
        }

        function get_datapasien2($tgl_kunjungan){

          $this->db->from('data_pasien');
          $this->db->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec', 'inner');
          $this->db->join('poliklinik', 'daftar_ulang_irj.id_poli = poliklinik.id_poli', 'inner');
          $this->db->join('map_pasien', 'data_pasien.no_medrec = map_pasien.no_medrec', 'inner');
          $this->db->select('daftar_ulang_irj.no_register,data_pasien.no_cm,data_pasien.nama,poliklinik.nm_poli,daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.cetak_tracer,data_pasien.tgl_daftar, map_pasien.timein, map_pasien.timeout, map_pasien.petugas, map_pasien.tiperawat, map_pasien.status, daftar_ulang_irj.jns_kunj');
          $this->db->where('LEFT(tgl_kunjungan,10)',$tgl_kunjungan);
          return $this->db->get();
        }

        function get_list_pasien_map($tgl_kunjungan){
            //  return $this->db->query("SELECT  `pasien_iri`.`no_ipd` as no_register, 
            //                                                  `data_pasien`.`no_cm`,
            //                                                  `data_pasien`.`no_medrec`,
            //                                                  `data_pasien`.`nama`,
            //                                                  `ruang`.nmruang as nm_poli,
            //                                                  `pasien_iri`.`tgl_masuk` as tgl_kunjungan,
            //                                                  '' as cetak_tracer,
            //                                                  `pasien_iri`.`verifuser` as xcreate,
            //                                                  `pasien_iri`.`status_pulang` as ket_pulang,
            //                                                  `data_pasien`.`tgl_daftar`,
            //                                                  `map_pasien`.`idmap_pasien`,
            //                                                  `map_pasien`.`timein`,
            //                                                  `map_pasien`.`timeout`,
            //                                                  `map_pasien`.`petugas`,
            //                                                  `map_catatan`.`catatan`,
            //                                                  `map_pasien`.`status`,
            //                                                  `map_pasien`.`tiperawat`,
            //                                                  `data_pasien`.`status_map`,
            //                                                  '' as poli_ke 
            //                                            FROM `data_pasien`
            //                                            INNER JOIN `pasien_iri` ON `data_pasien`.`no_medrec` = `pasien_iri`.`no_cm`
            //                                            INNER JOIN `ruang` ON `pasien_iri`.idrg = `ruang`.idrg
            //                                            left JOIN `map_pasien` ON `data_pasien`.`no_medrec` = `map_pasien`.`no_medrec` AND `pasien_iri`.`no_ipd` = `map_pasien`.`no_register`
            //                                            left JOIN `map_catatan` ON `data_pasien`.`no_medrec` = `map_catatan`.`no_medrec`
            //                                            WHERE pasien_iri.tgl_masuk='".$tgl_kunjungan."' AND `map_pasien`.`timein` is NULL
            //                                            UNION ALL SELECT
            //                                              `daftar_ulang_irj`.`no_register`,
            //                                              `data_pasien`.`no_cm`,
            //                                              `data_pasien`.`no_medrec`,
            //                                              `data_pasien`.`nama`,
            //                                              `poliklinik`.`nm_poli`,
            //                                              `daftar_ulang_irj`.`tgl_kunjungan`,
            //                                              `daftar_ulang_irj`.`cetak_tracer`,
            //                                              `daftar_ulang_irj`.`xcreate`,
            //                                              `daftar_ulang_irj`.`ket_pulang`,
            //                                              `data_pasien`.`tgl_daftar`,
            //                                              `map_pasien`.`idmap_pasien`,
            //                                              `map_pasien`.`timein`,
            //                                              `map_pasien`.`timeout`,
            //                                              `map_pasien`.`petugas`,
            //                                              `map_catatan`.`catatan`,
            //                                              `map_pasien`.`status`,
            //                                              `map_pasien`.`tiperawat`,
            //                                              `data_pasien`.`status_map`,
            //                                             `daftar_ulang_irj`.`poli_ke`
            //                                            FROM `data_pasien`
            //                                            INNER JOIN `daftar_ulang_irj` ON `data_pasien`.`no_medrec` = `daftar_ulang_irj`.`no_medrec`
            //                                            INNER JOIN `poliklinik` ON `daftar_ulang_irj`.`id_poli` = `poliklinik`.`id_poli`
            //                                            LEFT JOIN `map_pasien` ON `data_pasien`.`no_medrec` = `map_pasien`.`no_medrec` AND `daftar_ulang_irj`.`no_register` = `map_pasien`.`no_register` 
            //                                            LEFT JOIN `map_catatan` ON `data_pasien`.`no_medrec` = `map_catatan`.`no_medrec`
            //                                           WHERE LEFT(daftar_ulang_irj.tgl_kunjungan,10) = '".$tgl_kunjungan."' AND `map_pasien`.`timein` is NULL"
            //                                        );


                                                   return $this->db->query(" SELECT
                                                   daftar_ulang_irj.no_register,
                                                   data_pasien.no_cm,
                                                   data_pasien.no_medrec,
                                                   data_pasien.nama,
                                                   poliklinik.nm_poli,
                                                   daftar_ulang_irj.tgl_kunjungan,
                                                   daftar_ulang_irj.cetak_tracer,
                                                   daftar_ulang_irj.xcreate,
                                                   daftar_ulang_irj.ket_pulang,
                                                   data_pasien.tgl_daftar,
                                                   map_pasien.idmap_pasien,
                                                   map_pasien.timein,
                                                   map_pasien.timeout,
                                                   map_pasien.petugas,
                                                   map_catatan.catatan,
                                                   map_pasien.status,
                                                   map_pasien.tiperawat,
                                                   data_pasien.status_map,
                                                  daftar_ulang_irj.poli_ke
                                                 FROM data_pasien
                                                 INNER JOIN daftar_ulang_irj ON data_pasien.no_medrec = daftar_ulang_irj.no_medrec
                                                 INNER JOIN poliklinik ON daftar_ulang_irj.id_poli = poliklinik.id_poli
                                                 LEFT JOIN map_pasien ON data_pasien.no_medrec = CAST(map_pasien.no_medrec AS INTEGER) AND daftar_ulang_irj.no_register = map_pasien.no_register 
                                                 LEFT JOIN map_catatan ON data_pasien.no_medrec = CAST(map_catatan.no_medrec AS INTEGER)
                                                WHERE TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-dd') = '$tgl_kunjungan' AND map_pasien.timein is NULL"
                                                   );
        }

        private function _get_pasien_irj()  {
            $tgl_kunjungan = $this->input->post('tgl_kunjungan');
            $this->db->from('data_pasien');  
            $this->db->join('daftar_ulang_irj','data_pasien.no_medrec = daftar_ulang_irj.no_medrec','inner');            
            // $this->db->join('poliklinik','daftar_ulang_irj.id_poli = poliklinik.id_poli','left'); 
            // $this->db->join('map_pasien','data_pasien.no_medrec = map_pasien.no_medrec AND daftar_ulang_irj.no_register = map_pasien.no_register','left'); 
            // $this->db->where('LEFT(daftar_ulang_irj.tgl_kunjungan,10)', $tgl_kunjungan);
            // $this->db->where('map_pasien.timein', NULL);
            $this->db->order_by('daftar_ulang_irj.tgl_kunjungan');            
        
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
 
        public function get_pasien_irj()
        {
            $this->_get_pasien_irj();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function get_pasien_irj_filtered()
        {
            $this->_get_pasien_irj();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function get_pasien_irj_count()
        {
            $tgl_kunjungan = $this->input->post('tgl_kunjungan');
            $this->db->from('data_pasien');  
            $this->db->join('daftar_ulang_irj','data_pasien.no_medrec = daftar_ulang_irj.no_medrec','inner');            
            // $this->db->join('poliklinik','daftar_ulang_irj.id_poli = poliklinik.id_poli','left'); 
            // $this->db->join('map_pasien','data_pasien.no_medrec = map_pasien.no_medrec AND daftar_ulang_irj.no_register = map_pasien.no_register','left'); 
            // $this->db->where('LEFT(daftar_ulang_irj.tgl_kunjungan,10)', $tgl_kunjungan);
            // $this->db->where('map_pasien.timein', NULL);
            $this->db->order_by('daftar_ulang_irj.tgl_kunjungan');          
            return $this->db->count_all_results();
        } 

        // function get_list_pasien_map($tgl_kunjungan){
        //     return $this->db->query("SELECT * from (
        //       SELECT
        //         `pasien_iri`.`no_ipd` as no_register,
        //         `data_pasien`.`no_cm`,
        //         `data_pasien`.`no_medrec`,
        //         `data_pasien`.`nama`,
        //         `ruang`.nmruang as nm_poli,
        //         `pasien_iri`.`tgl_masuk` as tgl_kunjungan,
        //         '' as cetak_tracer,
        //         '' as xcreate,
        //         `data_pasien`.`tgl_daftar`,
        //         `map_pasien`.`idmap_pasien`,
        //         `map_pasien`.`timein`,
        //         `map_pasien`.`timeout`,
        //         `map_pasien`.`petugas`,
        //         `map_pasien`.`status`,
        //         `map_pasien`.`tiperawat`,
        //         `data_pasien`.`status_map`,
        //         '' as poli_ke 
        //       FROM
        //         `data_pasien`
        //         INNER JOIN `pasien_iri` ON `data_pasien`.`no_medrec` = `pasien_iri`.`no_cm`
                
        //         LEFT JOIN `ruang` ON `pasien_iri`.idrg = `ruang`.idrg
        //         LEFT JOIN `map_pasien` ON `data_pasien`.`no_medrec` = `map_pasien`.`no_medrec` 
        //         AND `pasien_iri`.`no_ipd` = `map_pasien`.`no_register`  
        //       WHERE
        //          `map_pasien`.`timein` is NULL 
        //         AND pasien_iri.tgl_keluar is NULL
        //         UNION ALL SELECT
        //         `daftar_ulang_irj`.`no_register`,
        //         `data_pasien`.`no_cm`,
        //         `data_pasien`.`no_medrec`,
        //         `data_pasien`.`nama`,
        //         `poliklinik`.`nm_poli`,
        //         `daftar_ulang_irj`.`tgl_kunjungan`,
        //         `daftar_ulang_irj`.`cetak_tracer`,
        //         `daftar_ulang_irj`.`xcreate`,
        //         `data_pasien`.`tgl_daftar`,
        //         `map_pasien`.`idmap_pasien`,
        //         `map_pasien`.`timein`,
        //         `map_pasien`.`timeout`,
        //         `map_pasien`.`petugas`,
        //         `map_pasien`.`status`,
        //         `map_pasien`.`tiperawat`,
        //         `data_pasien`.`status_map`,
        //          `daftar_ulang_irj`.`poli_ke`
        //       FROM
        //         `data_pasien`
        //         INNER JOIN `daftar_ulang_irj` ON `data_pasien`.`no_medrec` = `daftar_ulang_irj`.`no_medrec`
        //         LEFT JOIN `poliklinik` ON `daftar_ulang_irj`.`id_poli` = `poliklinik`.`id_poli`
        //         LEFT JOIN `map_pasien` ON `data_pasien`.`no_medrec` = `map_pasien`.`no_medrec` 
        //         AND `daftar_ulang_irj`.`no_register` = `map_pasien`.`no_register` 
        //       WHERE
        //         LEFT ( daftar_ulang_irj.tgl_kunjungan, 10 ) = '".$tgl_kunjungan."'
        //         AND `map_pasien`.`timein` is NULL) as a ORDER BY a.tgl_kunjungan");
        // }
        function get_poli($no_register){
          return $this->db->query("SELECT
          a.*,b.nm_poli
        FROM
          daftar_ulang_irj as a
        LEFT JOIN poliklinik as b ON a.id_poli = b.id_poli
        WHERE 
          a.no_register = '$no_register' ");
        }
        
        function get_ruang($no_register){
          return $this->db->query("SELECT
          a.*,b.nmruang
        FROM
          pasien_iri as a
        LEFT JOIN ruang as b ON a.idrg = b.idrg
        WHERE 
          a.no_ipd = '$no_register' ");
        }
        
        function get_loglist_pasien_map($param,$tgl_kunjungan,$nocm){
          //$tgla= $tgl_kunjungan;
          //$tglb= date('Y-m-d', strtotime('-15 days', strtotime($tgla)));
            if($param=='all'){
              $query="SELECT A.idmap_pasien,
              A.status,
              A.no_register,
              A.timein,
              A.timeout,
              A.catatan,
              C.tgl_daftar,
              C.no_cm,
              C.nama,
              b.nm_poli,
              A.tiperawat,
              d.xcreate AS petugas 
            FROM
              map_pasien A, daftar_ulang_irj d, data_pasien C, poliklinik b
            WHERE a.no_register = d.no_register
                  and  A.id_poli = b.id_poli
                  and A.tiperawat = 'IRJ' 
                  and C.no_medrec = cast(A.no_medrec as integer)
                    and (to_char( A.timeout,'YYYY-MM-DD') = '$tgl_kunjungan' 
              OR  to_char ( A.timein,'YYYY-MM-DD' ) = '$tgl_kunjungan')";
            }else if($param=='cm'){
              $query="SELECT a.idmap_pasien, a.status, a.no_register, a.timein, a.timeout, a.catatan, c.tgl_daftar, c.no_cm, c.nama, b.nm_poli, a.tiperawat, d.xcreate as petugas
                    from map_pasien a
                    JOIN daftar_ulang_irj d ON d.no_register=a.no_register
                    JOIN poliklinik b ON a.id_poli=b.id_poli and a.tiperawat='IRJ'
                    JOIN data_pasien c ON c.no_medrec=cast(A.no_medrec as integer)
                    WHERE c.no_medrec='".$nocm."'";
            }

            return $this->db->query($query);
        } 
	}

?>