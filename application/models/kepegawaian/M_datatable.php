<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_datatable extends CI_Model {
        var $colorder_pendidikan_umum = array(null,'pendidikan','tmpt_pendidikan','jurusan','th_lulus');
        var $colsearch_pendidikan_umum = array(null,'pendidikan','tmpt_pendidikan','jurusan','th_lulus'); 
        var $order_pendidikan_umum = array('th_lulus' => 'asc');  

        var $colorder_pendidikan_militer = array(null,'pendidikan','th_lulus');
        var $colsearch_pendidikan_militer = array(null,'pendidikan','th_lulus'); 
        var $order_pendidikan_militer = array('th_lulus' => 'asc'); 

        var $colorder_pangkat = array(null,'pangkat','tmt_pangkat');
        var $colsearch_pangkat = array(null,'pangkat','tmt_pangkat'); 
        var $order_pangkat = array('tmt_pangkat' => 'asc'); 

        var $colorder_jabatan = array(null,'jabatan','tmt_jabatan');
        var $colsearch_jabatan = array(null,'jabatan','tmt_jabatan'); 
        var $order_jabatan = array('tmt_jabatan' => 'asc');  

        var $colorder_tandajasa = array(null,'tandajasa');
        var $colsearch_tandajasa = array(null,'tandajasa'); 
        var $order_tandajasa = array('id' => 'asc'); 

        var $colorder_personil = array(null,'nama','nip_nrp',null,null,'alamat');
        var $colsearch_personil = array('nama','nip_nrp','alamat'); 
        var $order_personil = array('(kepegawaian_master_pangkat.id * -1)' => 'DESC','nama' => 'ASC');  

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_pendidikan_umum()  {

            $this->db->FROM('kepegawaian_pendidikan');            
            $this->db->where('jenis',1);
            $this->db->where('id_personil', $this->input->post('id_personil'));
        
            $i = 0;     
            foreach ($this->colsearch_pendidikan_umum as $item)
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
     
                    if(count($this->colsearch_pendidikan_umum) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_pendidikan_umum[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_pendidikan_umum))
            {
                $order = $this->order_pendidikan_umum;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function pendidikan_umum()
        {
            $this->_get_pendidikan_umum();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function pendidikan_umum_filtered()
        {
            $this->_get_pendidikan_umum();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function pendidikan_umum_count()
        {
            $this->db->FROM('kepegawaian_pendidikan');            
            $this->db->where('jenis',1);
            $this->db->where('id_personil', $this->input->post('id_personil'));           
            return $this->db->count_all_results();
        } 


        ////////////

        private function _get_pendidikan_militer()  {

            $this->db->FROM('kepegawaian_pendidikan');            
            $this->db->where('jenis',2);
            $this->db->where('id_personil', $this->input->post('id_personil'));
        
            $i = 0;     
            foreach ($this->colsearch_pendidikan_militer as $item)
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
     
                    if(count($this->colsearch_pendidikan_militer) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_pendidikan_militer[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_pendidikan_militer))
            {
                $order = $this->order_pendidikan_militer;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function pendidikan_militer()
        {
            $this->_get_pendidikan_militer();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function pendidikan_militer_filtered()
        {
            $this->_get_pendidikan_militer();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function pendidikan_militer_count()
        {
            $this->db->FROM('kepegawaian_pendidikan');            
            $this->db->where('jenis',2);
            $this->db->where('id_personil', $this->input->post('id_personil'));           
            return $this->db->count_all_results();
        }

        ////////////

        private function _get_pangkat()  {
            $this->db->select('kepegawaian_pangkat.id,kepegawaian_pangkat.id_personil,kepegawaian_master_pangkat.pangkat,kepegawaian_pangkat.tmt_pangkat');
            $this->db->from('kepegawaian_pangkat');                        
            $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');
            $this->db->where('id_personil', $this->input->post('id_personil'));
            $this->db->order_by('kepegawaian_master_pangkat.id', 'ASC');
        
            $i = 0;     
            foreach ($this->colsearch_pangkat as $item)
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
     
                    if(count($this->colsearch_pangkat) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_pangkat[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_pangkat))
            {
                $order = $this->order_pangkat;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function pangkat()
        {
            $this->_get_pangkat();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function pangkat_filtered()
        {
            $this->_get_pangkat();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function pangkat_count()
        {
            $this->db->select('kepegawaian_pangkat.id,kepegawaian_pangkat.id_personil,kepegawaian_master_pangkat.pangkat,kepegawaian_pangkat.tmt_pangkat');
            $this->db->from('kepegawaian_pangkat');                        
            $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');          
            $this->db->where('id_personil', $this->input->post('id_personil'));           
            return $this->db->count_all_results();
        }  

        ////////////

        private function _get_jabatan()  {

            $this->db->FROM('kepegawaian_jabatan');                        
            $this->db->where('id_personil', $this->input->post('id_personil'));
        
            $i = 0;     
            foreach ($this->colsearch_jabatan as $item)
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
     
                    if(count($this->colsearch_jabatan) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_jabatan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_jabatan))
            {
                $order = $this->order_jabatan;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function jabatan()
        {
            $this->_get_jabatan();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function jabatan_filtered()
        {
            $this->_get_jabatan();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function jabatan_count()
        {
            $this->db->FROM('kepegawaian_jabatan');                        
            $this->db->where('id_personil', $this->input->post('id_personil'));           
            return $this->db->count_all_results();
        } 

        ////////////

        private function _get_tandajasa()  {

            $this->db->FROM('kepegawaian_tandajasa');                        
            $this->db->where('id_personil', $this->input->post('id_personil'));
        
            $i = 0;     
            foreach ($this->colsearch_tandajasa as $item)
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
     
                    if(count($this->colsearch_tandajasa) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_tandajasa[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_tandajasa))
            {
                $order = $this->order_tandajasa;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function tanda_jasa()
        {
            $this->_get_tandajasa();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function tandajasa_filtered()
        {
            $this->_get_tandajasa();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function tandajasa_count()
        {
            $this->db->FROM('kepegawaian_tandajasa');                        
            $this->db->where('id_personil', $this->input->post('id_personil'));           
            return $this->db->count_all_results();
        } 

        ////////////

        private function _get_personil() {  
            $search_per = $this->input->post('search_per');
            $search_jenis = $this->input->post('search_jenis');
            $search_nama = $this->input->post('search_nama'); 
            $search_tgl_lahir = $this->input->post('search_tgl_lahir'); 
            $search_pangkat = $this->input->post('search_pangkat');
            $search_jabatan = $this->input->post('search_jabatan'); 
            $search_pendidikan = $this->input->post('search_pendidikan'); 
            $search_nip_nrp = $this->input->post('search_nip_nrp'); 
            $search_alamat = $this->input->post('search_alamat');          
            $this->db->select('kepegawaian_personil.id,kepegawaian_personil.foto,kepegawaian_personil.tgl_lahir,kepegawaian_personil.nama,kepegawaian_personil.nip_nrp,kepegawaian_personil.alamat,kepegawaian_master_pangkat.pangkat,kepegawaian_jabatan.jabatan');
            $this->db->FROM('kepegawaian_personil');                         
            $this->db->join('kepegawaian_pangkat', 'kepegawaian_personil.pangkat_akhir = kepegawaian_pangkat.id', 'left');
            $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');
            $this->db->JOIN('kepegawaian_jabatan', 'kepegawaian_personil.jabatan_akhir = kepegawaian_jabatan.id', 'left');               
            switch ($search_per) {
                case "nama":
                    $this->db->like('kepegawaian_personil.nama', $search_nama);
                    break;
                case "nip_nrp":
                    $this->db->like('kepegawaian_personil.nip_nrp', $search_nip_nrp);
                    break;
                case "jenis":
                    $this->db->where('kepegawaian_master_pangkat.jenis', $search_jenis);
                    break;
                case "pangkat":
                    $this->db->where('kepegawaian_pangkat.pangkat', $search_pangkat);
                    break;
                case "jabatan":
                    $this->db->like('kepegawaian_jabatan.jabatan', $search_jabatan);
                    break;
                case "pendidikan":
                    $this->db->where('kepegawaian_pendidikan.jenis', $search_pendidikan);
                    break;
                case "alamat":
                    $this->db->like('kepegawaian_personil.alamat', $search_alamat);
                    break;
                case "tgl_lahir":
                    $this->db->like('kepegawaian_personil.tgl_lahir', $search_tgl_lahir);
                    break;
            }              
        
            $i = 0;     
            foreach ($this->colsearch_personil as $item)
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
     
                    if(count($this->colsearch_personil) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->colorder_personil[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_personil))
            {
                $order = $this->order_personil;       
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function get_personil()
        {
            $this->_get_personil();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function personil_count_filtered()
        {
            $this->_get_personil();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function personil_count_all()
        {
            $search_per = $this->input->post('search_per');
            $search_jenis = $this->input->post('search_jenis');
            $search_nama = $this->input->post('search_nama'); 
            $search_tgl_lahir = $this->input->post('search_tgl_lahir'); 
            $search_pangkat = $this->input->post('search_pangkat');
            $search_jabatan = $this->input->post('search_jabatan'); 
            $search_pendidikan = $this->input->post('search_pendidikan'); 
            $search_nip_nrp = $this->input->post('search_nip_nrp'); 
            $search_alamat = $this->input->post('search_alamat');          
            $this->db->select('kepegawaian_personil.id,kepegawaian_personil.foto,kepegawaian_personil.tgl_lahir,kepegawaian_personil.nama,kepegawaian_personil.nip_nrp,kepegawaian_personil.alamat,kepegawaian_master_pangkat.pangkat,kepegawaian_jabatan.jabatan');
            $this->db->FROM('kepegawaian_personil');                         
            $this->db->join('kepegawaian_pangkat', 'kepegawaian_personil.pangkat_akhir = kepegawaian_pangkat.id', 'left');
            $this->db->join('kepegawaian_master_pangkat', 'kepegawaian_pangkat.pangkat = kepegawaian_master_pangkat.id', 'left');
            $this->db->JOIN('kepegawaian_jabatan', 'kepegawaian_personil.jabatan_akhir = kepegawaian_jabatan.id', 'left');               
            if ($search_per == 'nama') {                
                $this->db->like('kepegawaian_personil.nama', $search_nama);
            } else if ($search_per == 'nip_nrp') {
                $this->db->like('kepegawaian_personil.nip_nrp', $search_nip_nrp);
            } else if ($search_per == 'jenis') {                
                $this->db->where('kepegawaian_master_pangkat.jenis', $search_jenis);
            } else if ($search_per == 'pangkat') {
                $this->db->where('kepegawaian_pangkat.pangkat', $search_pangkat);
            } else if ($search_per == 'jabatan') {
                $this->db->like('kepegawaian_jabatan.jabatan', $search_jabatan);
            } else if ($search_per == 'pendidikan') {
                $this->db->where('kepegawaian_pendidikan.jenis', $search_pendidikan);
            } else if ($search_per == 'alamat') {
                $this->db->like('kepegawaian_personil.alamat', $search_alamat);
            } else if ($search_per == 'tgl_lahir') {
                $this->db->like('kepegawaian_personil.tgl_lahir', $search_tgl_lahir);
            } else {

            }    
            return $this->db->count_all_results();
        }                                                                    

	}

?>