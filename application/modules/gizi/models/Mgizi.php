<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mgizi extends CI_Model {
        var $column_order = array(null,'pasien_iri.no_ipd','pasien_iri.tgl_masuk','data_pasien.no_cm','data_pasien.nama','pasien_iri.carabayar','ruang.nmruang','ruang_iri.bed','data_pasien.tgl_daftar','pasien_iri.tgldaftarri');
        var $column_search = array('pasien_iri.no_ipd','pasien_iri.tgl_masuk','data_pasien.no_cm','data_pasien.nama','pasien_iri.carabayar','ruang.nmruang','ruang_iri.bed','data_pasien.tgl_daftar','pasien_iri.tgldaftarri'); 
        var $order = array('tgl_masuk' => 'desc');  

        var $column_order_ugd = array(null,'daftar_ulang_irj.no_register','daftar_ulang_irj.tgl_kunjungan','data_pasien.no_cm','data_pasien.nama','daftar_ulang_irj.cara_bayar');
        var $column_search_ugd = array('daftar_ulang_irj.no_register','daftar_ulang_irj.tgl_kunjungan','data_pasien.no_cm','data_pasien.nama','daftar_ulang_irj.cara_bayar'); 
        var $order_ugd = array('tgl_kunjungan' => 'asc');  

        public function __construct() {
            parent::__construct();
            $this->load->database();
        } 

		private function _get_datatables_query()  {
            $ruangan = $this->input->post('ruangan');
            // $tanggal = $this->input->post('tanggal');
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('ruang_iri', 'pasien_iri.no_ipd = ruang_iri.no_ipd', 'inner');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ruang', 'pasien_iri.idrg = ruang.idrg', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,data_pasien.no_cm,data_pasien.nama,pasien_iri.carabayar,ruang.nmruang,ruang_iri.bed, data_pasien.tgl_daftar, pasien_iri.tgldaftarri, pasien_iri.gizi');
            $this->db->where('pasien_iri.tgl_keluar IS NULL'); 
            $this->db->where('ruang.lokasi', $ruangan); 
            $this->db->where('ruang_iri.statkeluarrg IS NULL'); 
            $this->db->where('ruang_iri.tglkeluarrg IS NULL'); 
            $this->db->where('pasien_iri.permintaan_gizi', 1); 
            $this->db->order_by('ruang_iri.bed', 'ASC');  
            // $this->db->where('pasien_iri.tgl_masuk', $tanggal);  
        
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

        private function _get_datatables_query_ugd()  {
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan,data_pasien.no_cm,data_pasien.nama,daftar_ulang_irj.cara_bayar');
            $this->db->where('daftar_ulang_irj.tgl_pulang IS NULL'); 
            $this->db->where('daftar_ulang_irj.id_poli', 'BA00'); 
            $this->db->where('daftar_ulang_irj.flag_permintaan_gizi', 1); 
            $this->db->order_by('daftar_ulang_irj.tgl_kunjungan', 'ASC');  
        
            $i = 0;     
            foreach ($this->column_search_ugd as $item)
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
     
                    if(count($this->column_search_ugd) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->column_order_ugd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_ugd))
            {
                $order = $this->order_ugd;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

         var $column_order_showgizi = array(null,'gizi_pasien_diet.no_ipd','pasien_iri.tgl_masuk','data_pasien.no_cm','data_pasien.tgl_daftar','data_pasien.nama','pasien_iri.tgldaftarri','pasien_iri.carabayar','menu_diet.nama_menu','menu_diet.komposisi','ruang.nmruang','pasien_iri.bed','gizi_pasien_diet.tanggal','gizi_pasien_diet.xuser', 'gizi_pasien_diet.ket_waktu','kelompok_diet.pokdiet','gizi_pasien_diet.note','gizi_pasien_diet.idgizi_pasien_diet');
        var $column_search_showgizi = array('gizi_pasien_diet.no_ipd','pasien_iri.tgl_masuk','data_pasien.no_cm','data_pasien.tgl_daftar','data_pasien.nama','pasien_iri.tgldaftarri','pasien_iri.carabayar','menu_diet.nama_menu','menu_diet.komposisi','ruang.nmruang','pasien_iri.bed','gizi_pasien_diet.tanggal','gizi_pasien_diet.xuser','gizi_pasien_diet.ket_waktu','kelompok_diet.pokdiet','gizi_pasien_diet.note','gizi_pasien_diet.idgizi_pasien_diet',); 
        var $order_showgizi = array('gizi_pasien_diet.xupdate' => 'desc');

        private function _get_datatables_query_gizipasien($no_ipd)  {

            /*$this->db->query("SELECT * FROM gizi_pasien_diet 
                INNER JOIN pasien_iri ON gizi_pasien_diet.no_ipd = pasien_iri.no_ipd 
                INNER JOIN data_pasien ON pasien_iri.no_cm = data_pasien.no_medrec 
                LEFT JOIN diet ON diet.iddiet=gizi_pasien_diet.iddiet
                LEFT JOIN ruang ON pasien_iri.idrg = ruang.idrg 
                where pasien_iri.tgl_keluar IS NULL and gizi_pasien_diet.no_ipd='".$no_ipd."'");                        
            */
            $this->db->FROM('gizi_pasien_diet');
            $this->db->JOIN('pasien_iri', 'gizi_pasien_diet.no_ipd = pasien_iri.no_ipd', 'inner');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('diet', 'diet.iddiet=gizi_pasien_diet.iddiet', 'left');
            $this->db->JOIN('menu_diet', 'diet.idmenu_diet = menu_diet.idmenu_diet', 'left');
            $this->db->JOIN('kelompok_diet', 'kelompok_diet.idpokdiet=kelompok_diet.idpokdiet AND kelompok_diet.idpokdiet=diet.idkel_diet', 'left');
            $this->db->JOIN('ruang', 'ruang.idrg=(LEFT(gizi_pasien_diet.idbed,4))', 'left');
            $this->db->select('gizi_pasien_diet.no_ipd, pasien_iri.tgl_masuk, data_pasien.no_cm, data_pasien.nama, menu_diet.nama_menu, menu_diet.komposisi, pasien_iri.carabayar, ruang.nmruang, pasien_iri.bed, gizi_pasien_diet.tanggal, gizi_pasien_diet.ket_waktu, gizi_pasien_diet.note, gizi_pasien_diet.xuser, pasien_iri.tgldaftarri, data_pasien.tgl_daftar, kelompok_diet.pokdiet, gizi_pasien_diet.idgizi_pasien_diet');
            $this->db->where('pasien_iri.tgl_keluar IS NULL', null, false); 
            $this->db->where('gizi_pasien_diet.no_ipd', $no_ipd );

            $i = 0;     
            foreach ($this->column_search_showgizi as $item)
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
     
                    if(count($this->column_search_showgizi) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
            //$this->db->FROM('gizi_pasien_diet');
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->column_order_showgizi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_showgizi))
            {
                $order = $this->order_showgizi;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function get_pasien()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();            
            return $query->result();
        }

        public function get_pasien_ugd()
        {
            $this->_get_datatables_query_ugd();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();            
            return $query->result();
        }

        public function count_all()
        {
            $ruangan = $this->input->post('ruangan');
            // $tanggal = $this->input->post('tanggal');
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('ruang_iri', 'pasien_iri.no_ipd = ruang_iri.no_ipd', 'inner');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ruang', 'pasien_iri.idrg = ruang.idrg', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,data_pasien.no_cm,data_pasien.nama,pasien_iri.carabayar,ruang.nmruang,ruang_iri.bed, data_pasien.tgl_daftar, pasien_iri.tgldaftarri');
            $this->db->where('pasien_iri.tgl_keluar IS NULL'); 
            $this->db->where('ruang.lokasi', $ruangan); 
            $this->db->where('ruang_iri.statkeluarrg IS NULL'); 
            $this->db->where('ruang_iri.tglkeluarrg IS NULL'); 
            $this->db->order_by('ruang_iri.bed', 'ASC');  
            // $this->db->where('pasien_iri.tgl_masuk', $tanggal);  
            return $this->db->count_all_results();
        }
 
        public function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_ugd()
        {
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan,data_pasien.no_cm,data_pasien.nama,daftar_ulang_irj.cara_bayar');
            $this->db->where('daftar_ulang_irj.tgl_pulang IS NULL'); 
            $this->db->where('daftar_ulang_irj.id_poli', 'BA00'); 
            $this->db->where('daftar_ulang_irj.flag_permintaan_gizi', 1); 
            $this->db->order_by('daftar_ulang_irj.tgl_kunjungan', 'ASC');  
            return $this->db->count_all_results();
        }
 
        public function count_filtered_ugd()
        {
            $this->_get_datatables_query_ugd();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function get_pasien_gizi($no_ipd)
        {
            $this->_get_datatables_query_gizipasien($no_ipd);
            //echo $this->db->last_query();
            if($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $query->result();
        }

        public function count_filtered_gizipasien($no_ipd)
        {
            $this->_get_datatables_query_gizipasien($no_ipd);
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_gizipasien($no_ipd)
        {
            $this->db->FROM('gizi_pasien_diet');
            $this->db->JOIN('pasien_iri', 'gizi_pasien_diet.no_ipd = pasien_iri.no_ipd','inner');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ruang', 'pasien_iri.idrg = ruang.idrg', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,data_pasien.no_cm,data_pasien.nama,pasien_iri.carabayar,ruang.nmruang,ruang_iri.bed');
            $this->db->where('pasien_iri.tgl_keluar IS NULL', null, false);
            $this->db->where('gizi_pasien_diet.no_ipd', $no_ipd);
            return $this->db->count_all_results();
        }

        public function insert_gizipasien($data)
        {
            return $this->db->insert('gizi_pasien_diet', $data);                  
        }   

        public function insert_dietpasien($data)
        {
            return $this->db->insert('record_diet', $data);                  
        }                                                                  

        function delete_menu($iddiet){
            return $this->db->query("DELETE FROM gizi_pasien_diet WHERE idgizi_pasien_diet=$iddiet");
        }

        public function show_pasien($no_ipd)
        {
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('ruang_iri', 'pasien_iri.no_ipd = ruang_iri.no_ipd');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');            
            $this->db->JOIN('ruang', 'pasien_iri.idrg = ruang.idrg', 'left');
            $this->db->JOIN('gizi_pasien_diet', 'pasien_iri.no_ipd = gizi_pasien_diet.no_ipd', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,data_pasien.no_cm,data_pasien.nama,pasien_iri.carabayar,ruang.nmruang,ruang_iri.bed');
            $this->db->where('pasien_iri.tgl_keluar IS NULL', null, false);
            $this->db->WHERE('pasien_iri.no_ipd', $no_ipd);
            $query = $this->db->get();
            return $query->row();
        }

        public function show_pasien_ugd($no_ipd)
        {
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('gizi_pasien_diet', 'daftar_ulang_irj.no_register = gizi_pasien_diet.no_ipd', 'left');
            $this->db->select('daftar_ulang_irj.no_register,daftar_ulang_irj.tgl_kunjungan,data_pasien.no_cm,data_pasien.nama,daftar_ulang_irj.cara_bayar,daftar_ulang_irj.asuhan,daftar_ulang_irj.screening,daftar_ulang_irj.edukasi');
            $this->db->where('daftar_ulang_irj.tgl_pulang IS NULL'); 
            $this->db->WHERE('daftar_ulang_irj.no_register', $no_ipd);
            $query = $this->db->get();
            return $query->row();
        }

        public function get_all_menudiet(){
            return $this->db->query("SELECT 
                *
            FROM
                diet
                    INNER JOIN
                menu_diet ON diet.idmenu_diet = menu_diet.idmenu_diet
            ORDER BY iddiet");
        }

        ///////////////////

        public function pasien_ruangan($tanggal,$lokasi)
        {
            $this->db->from('pasien_iri as a');
            $this->db->join('data_pasien as b', 'a.no_cm = b.no_medrec', 'inner');
            $this->db->join('ruang as c', 'a.idrg = c.idrg', 'inner');            
            $this->db->join('gizi_permintaan_diet as d', 'a.no_ipd = d.no_ipd', 'left');
            $this->db->join('kontraktor as e', 'a.id_kontraktor = e.id_kontraktor', 'left');
            $this->db->join('ruang_iri as f', 'a.no_ipd = f.no_ipd', 'inner');
            $this->db->select('b.nama,b.no_cm,a.diagmasuk,b.nama,b.nama,f.kelas,d.catatan,d.standar,d.bentuk,d.created_at,e.nmkontraktor');
            $this->db->where('c.lokasi', $lokasi);
            $this->db->where('LEFT(a.tgl_masuk,10)', $tanggal); 
            $this->db->order_by('a.tgl_masuk', 'asc'); 
            $query = $this->db->get();
            return $query->result();
        }

        public function show_permintaan_diet($no_ipd)
        {
            $this->db->from('gizi_permintaan_diet');   
            $this->db->where('no_ipd', $no_ipd); 
            $this->db->order_by('created_at', 'desc');        
            $query = $this->db->get();
            return $query->row();
        }

        public function show_permintaan_diet_byid($id)
        {
            $this->db->from('gizi_permintaan_diet');   
            $this->db->where('id', $id); 
            $this->db->order_by('created_at', 'desc');        
            $query = $this->db->get();
            return $query->row();
        }

        public function insert_permintaan_diet($data)
        {
            return $this->db->insert('gizi_permintaan_diet', $data);
        }

        public function update_permintaan_diet($id,$data)
        {   
            $this->db->trans_begin();   
            $this->db->from('gizi_permintaan_diet');   
            $this->db->where('id', $id); 
            $query = $this->db->get()->row();
            $data_log = array(
                'action' => 'edit',
                'action_by' => $this->load->get_var("user_info")->username,
                'action_at' => date('Y-m-d H:i:s'),
                'id_permintaan' => $query->id,
                'no_ipd' => $query->no_ipd,
                'bed' => $query->bed,
                'standar' => $query->standar,
                'bentuk' => $query->bentuk,
                'catatan' => $query->catatan,
                'created_by' => $query->created_by,
                'created_at' => $query->created_at,
                'notification' => $query->notification
            );
            // $this->db->insert('gizi_permintaan_diet_log', $data_log);

            $this->db->where('id', $id);
            $this->db->update('gizi_permintaan_diet', $data);    

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            } 
        } 

        public function update_flag_permintaan_diet($no_register,$data)
        {  
            // var_dump($data);die(); 
            if(substr($no_register, 0,2) == 'RI'){
                $this->db->where('no_ipd', $no_register);
                return $this->db->update('pasien_iri', $data);    
            }else{
                $this->db->where('no_register', $no_register);
                return $this->db->update('daftar_ulang_irj', $data);    
            } 
        } 

        public function delete_permintaan_diet($id)
        {
            $this->db->trans_begin();   
            $this->db->from('gizi_permintaan_diet');   
            $this->db->where('id', $id); 
            $query = $this->db->get()->row();
            $data = array(
                'action' => 'delete',
                'action_by' => $this->load->get_var("user_info")->username,
                'action_at' => date('Y-m-d H:i:s'),
                'id_permintaan' => $query->id,
                'no_ipd' => $query->no_ipd,
                'bed' => $query->bed,
                'standar' => $query->standar,
                'bentuk' => $query->bentuk,
                'catatan' => $query->catatan,
                'created_by' => $query->created_by,
                'created_at' => $query->created_at,
                'notification' => $query->notification
            );
            // $this->db->insert('gizi_permintaan_diet_log', $data);

            $this->db->where('id', $id);
            $this->db->delete('gizi_permintaan_diet');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            } 
        }

        public function update_ceklis_ahli_gizi($no_ipd,$data)
        {   
            if (substr($no_ipd, 0,2) == 'RI') {
                $this->db->where('no_ipd', $no_ipd);
                return $this->db->update('pasien_iri', $data);                  
            } else {
                $this->db->where('no_register', $no_ipd);
                return $this->db->update('daftar_ulang_irj', $data);                  
            }  
        } 
        public function show_ceklis_ahli_gizi($no_ipd)
        {
            $this->db->select('asuhan,edukasi,screening,monitoring');
            $this->db->from('pasien_iri');   
            $this->db->where('no_ipd', $no_ipd);      
            $query = $this->db->get();
            return $query->row();
        }

        public function get_ruangan()
        {
            $this->db->from('ruang');
            $this->db->group_by('lokasi');
            $query = $this->db->get();
            return $query->result();
        }

        public function get_notif()
        {
            $this->db->select('pasien_iri.idrg,gizi,lokasi');
            $this->db->from('pasien_iri');
            $this->db->join('ruang', 'pasien_iri.idrg = ruang.idrg', 'inner'); 
            $this->db->group_by('pasien_iri.idrg,pasien_iri.gizi,ruang.idrg');
            $this->db->where('pasien_iri.gizi','1');
            $this->db->where('pasien_iri.tgl_keluar',null);            
            $query = $this->db->get();
            return $query->result();
        }

        public function per_ruangan1($lokasi)
        {
            $this->db->select('b.nama,c.no_cm,b.diagmasuk,f.kelas,a.catatan,a.standar,a.bentuk,a.created_at,e.nmkontraktor,f.bed, b.no_ipd');
            $this->db->from('gizi_permintaan_diet as a');          
            $this->db->join('pasien_iri as b', 'a.no_ipd = b.no_ipd', 'inner');
            $this->db->join('data_pasien as c', 'b.no_medrec = c.no_medrec', 'inner');
            $this->db->join('ruang as d', 'b.idrg = d.idrg', 'left');  
            $this->db->join('kontraktor as e', 'b.id_kontraktor = e.id_kontraktor', 'left');
            $this->db->join('ruang_iri as f', 'b.no_ipd = f.no_ipd', 'inner');
            $this->db->where('d.lokasi', $lokasi);
            $this->db->where('b.tgl_keluar IS NULL');
            $this->db->where('f.statkeluarrg IS NULL'); 
            $this->db->where('f.tglkeluarrg IS NULL'); 
            $this->db->where('a.id IN (select max(id) from gizi_permintaan_diet as g join pasien_iri h on h.no_ipd=g.no_ipd where (created_by like "%'.$lokasi.'%" or created_by="gizi") and tgl_keluar is null group by g.no_ipd)', NULL, FALSE); 
            $query = $this->db->get();
            return $query->result();
        }

        function per_ruangan($lokasi){
            $lokasi_gd = str_replace("%20"," ",$lokasi);
            return $this->db->query("SELECT b.nama,
            b.diagmasuk,
            f.kelas,
            A.catatan,
            A.standar,
            A.bentuk,
            A.created_at,
            e.nmkontraktor,
            f.bed,
            b.no_ipd 
            FROM
                gizi_permintaan_diet
                AS A INNER JOIN pasien_iri AS b ON A.no_ipd = b.no_ipd
                INNER JOIN data_pasien AS C ON b.no_medrec = C.no_medrec
                LEFT JOIN ruang AS d ON b.idrg = d.idrg
                LEFT JOIN kontraktor AS e ON b.id_kontraktor = e.id_kontraktor
                INNER JOIN ruang_iri AS f ON b.no_ipd = f.no_ipd 
            WHERE
                d.lokasi = '$lokasi_gd' 
                AND b.tgl_keluar IS NULL 
                AND b.permintaan_gizi = 1 
                AND f.statkeluarrg IS NULL 
                AND f.tglkeluarrg IS NULL 
                AND A.ID IN (
                SELECT MAX
                    ( ID ) 
                FROM
                    gizi_permintaan_diet
                    AS G JOIN pasien_iri h ON h.no_ipd = G.no_ipd 
                WHERE
                     tgl_keluar IS NULL 
                GROUP BY
                G.no_ipd 
                )");
        }
        public function data_label($lokasi){
            $lokasi_gd = str_replace("%20"," ",$lokasi);
            return $this->db->query("SELECT
            d.nama,
            a.bentuk, 
            a.standar,
            d.no_cm,
            lokasi
        FROM
            gizi_permintaan_diet AS a
            JOIN pasien_iri AS b ON a.no_ipd = b.no_ipd
            JOIN ruang AS c ON b.idrg = c.idrg
            JOIN data_pasien AS d ON b.no_medrec = d.no_medrec 
        WHERE
            c.lokasi = '$lokasi_gd' 
            AND b.tgl_keluar IS NULL 
            AND b.permintaan_gizi = 1 
            AND A.ID IN (
            SELECT MAX
                ( ID ) 
            FROM
                gizi_permintaan_diet
                AS G JOIN pasien_iri h ON h.no_ipd = G.no_ipd 
            WHERE
                 tgl_keluar IS NULL 
            GROUP BY
            G.no_ipd 
            )");
        }

        public function standar_diet()
        {
            $this->db->from('master_standar_diet');           
            $query = $this->db->get();
            return $query->result();
        }

        public function bentuk_makanan()
        {
            $this->db->from('master_bentuk_makanan');           
            $query = $this->db->get();
            return $query->result();
        }

        public function show_pasien_iri($no_ipd){
            $data=$this->db->query("
                select a.no_ipd, a.tgl_masuk, b.nama, b.no_cm, f.nm_diagnosa, d.lokasi, c.bed, c.kelas, b.tgl_lahir,d.nmruang
                from pasien_iri as a inner join data_pasien as b on a.no_medrec = b.no_medrec
                left join ruang_iri as c on a.no_ipd = c.no_ipd
                left join ruang as d on c.idrg = d.idrg
                left join icd1 as e on a.diagnosa1 = e.id_icd
                left join icd1 as f on a.diagmasuk = f.id_icd
                left join kontraktor g on g.id_kontraktor=a.id_kontraktor
                where a.no_ipd = '$no_ipd' 
                Order by c.idrgiri DESC");
            return $data->row();
        }

        function get_status_pasien($tgl_awal, $tgl_akhir){
            $sql = "SELECT tgl,sum(covid_pc) AS covid_pc,sum(covid_bpjs_anggota) AS covid_bpjs_anggota,sum(covid_bpjs_non) AS covid_bpjs_non,sum(non_covid_pc) AS non_covid_pc,sum(non_covid_bpjs_anggota) AS non_covid_bpjs_anggota,sum(non_covid_bpjs_non) AS non_covid_bpjs_non FROM gizi_rekap WHERE tgl BETWEEN ? AND ? GROUP BY tgl ORDER BY tgl"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_kon_rj_status_pasien($tgl_awal, $tgl_akhir){
            $sql = "SELECT tgl,sum(covid_pc) AS covid_pc,sum(covid_bpjs_anggota) AS covid_bpjs_anggota,sum(covid_bpjs_non) AS covid_bpjs_non,sum(non_covid_pc) AS non_covid_pc,sum(non_covid_bpjs_anggota) AS non_covid_bpjs_anggota,sum(non_covid_bpjs_non) AS non_covid_bpjs_non FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND screening=1 AND LEFT(no_ipd,2)='RJ' GROUP BY tgl ORDER BY tgl"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_kon_ri_status_pasien($tgl_awal, $tgl_akhir){
            $sql = "SELECT tgl,sum(covid_pc) AS covid_pc,sum(covid_bpjs_anggota) AS covid_bpjs_anggota,sum(covid_bpjs_non) AS covid_bpjs_non,sum(non_covid_pc) AS non_covid_pc,sum(non_covid_bpjs_anggota) AS non_covid_bpjs_anggota,sum(non_covid_bpjs_non) AS non_covid_bpjs_non FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND screening=1 AND LEFT(no_ipd,2)='RI' GROUP BY tgl ORDER BY tgl"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_bentuk_makanan($tgl_awal, $tgl_akhir){
            $sql = "SELECT id, no_ipd, standar, bentuk, created_by, created_at, tgl FROM gizi_rekap WHERE tgl BETWEEN ? AND ? ORDER BY tgl, no_ipd"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_kon_rj_bentuk_makanan($tgl_awal, $tgl_akhir){
            $sql = "SELECT id, no_ipd, standar, bentuk, created_by, created_at, tgl FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND screening=1 AND LEFT(no_ipd,2)='RJ' ORDER BY tgl, no_ipd"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_kon_ri_bentuk_makanan($tgl_awal, $tgl_akhir){
            $sql = "SELECT id, no_ipd, standar, bentuk, created_by, created_at, tgl FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND screening=1 AND LEFT(no_ipd,2)='RI' ORDER BY tgl, no_ipd"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_edu_rj_bentuk_makanan($tgl_awal, $tgl_akhir){
            $sql = "SELECT id, no_ipd, standar, bentuk, created_by, created_at, tgl FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND edukasi=1 AND LEFT(no_ipd,2)='RJ' ORDER BY tgl, no_ipd"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_edu_ri_bentuk_makanan($tgl_awal, $tgl_akhir){
            $sql = "SELECT id, no_ipd, standar, bentuk, created_by, created_at, tgl FROM gizi_rekap WHERE tgl BETWEEN ? AND ? AND edukasi=1 AND LEFT(no_ipd,2)='RI' ORDER BY tgl, no_ipd"; 
            return $this->db->query($sql, array($tgl_awal, $tgl_akhir));
        }

        function get_bentuk_makanan_header(){
            $this->db->select('id, kode, nm_bentuk');           
            $this->db->from('gizi_bentuk_makanan');           
            $query = $this->db->get();
            return $query;
        }

        function get_standar_diet_header(){
            $this->db->select('id, standar, category');           
            $this->db->from('gizi_standar_diet');           
            $query = $this->db->get();
            return $query;
        }


        function get_lokasi_ruang(){
			return $this->db->query("SELECT lokasi FROM ruang group by lokasi");
		}


	}

?>