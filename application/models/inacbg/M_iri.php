<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_iri extends CI_Model {
        var $column_order = array(null,'tgl_masuk','no_cm','nama','no_kartu','no_sep');
        var $column_search = array('pasien_iri.tgl_masuk','data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','pasien_iri.no_sep'); 
        var $order = array('tgl_masuk' => 'desc');  

        var $column_order_diagnosa = array(null,'diagnosa_text','klasifikasi_diagnos','id_diagnosa');
        var $column_search_diagnosa = array('diagnosa_text','klasifikasi_diagnos','id_diagnosa','diagnosa'); 
        var $order_diagnosa = array('tgl_kunjungan' => 'desc'); 

        var $procedure_order = array(null,'procedure_text','klasifikasi_procedure','id_procedure');
        var $procedure_search = array('icd9cm_iri.id_procedure','icd9cm_iri.procedure_text','icd9cm_iri.klasifikasi_procedure','icd9cm_iri.procedure'); 
        var $default_order_procedure = array('icd9cm_iri.tgl_kunjungan' => 'desc','icd9cm_iri.id' => 'desc'); 

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        private function procedure_query()  {
            $no_medrec = $this->input->post('no_medrec');
            $this->db->FROM('icd9cm_iri');
            $this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = icd9cm_iri.no_register', 'left');
            $this->db->where('pasien_iri.no_cm',$no_medrec);
        
            $i = 0;     
            foreach ($this->procedure_search as $item)
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
     
                    if(count($this->procedure_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
             
            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->procedure_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->default_order_procedure))
            {
                $order = $this->default_order_procedure;
                $this->db->order_by(key($order), $order[key($order)]);
            }
     //   }
    }    
 
        public function getdata_procedure_pasien()
        {
            $this->procedure_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }

        public function procedure_filtered()
        {
            $this->procedure_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function procedure_count_all()
        {
            $no_medrec = $this->input->post('no_medrec');
            $this->db->FROM('icd9cm_iri');
            $this->db->JOIN('pasien_iri', 'pasien_iri.no_ipd = icd9cm_iri.no_register', 'left');
            $this->db->where('pasien_iri.no_cm',$no_medrec);
            return $this->db->count_all_results();
        }    

        function show_procedure($id_icd9cm) {
            $this->db->FROM('icd9cm_iri'); 
            $this->db->where('id', $id_icd9cm);
            $query = $this->db->get();
            return $query->row();
        } 

        function update_procedure($id_icd9cm,$data_update){
          $this->db->where('id', $id_icd9cm);
          $this->db->update('icd9cm_iri', $data_update);
          return true;
        } 

		    private function _get_datatables_query()  {

            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ina_cbg', 'pasien_iri.no_sep = ina_cbg.nomor_sep', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,pasien_iri.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.no_sep,ina_cbg.id as id_inacbg');
            $this->db->where('pasien_iri.no_sep !=','');
            $this->db->where('pasien_iri.carabayar','BPJS');  
        
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
 
        public function get_klaim()
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
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ina_cbg', 'pasien_iri.no_sep = ina_cbg.nomor_sep', 'left');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.tgl_masuk,pasien_iri.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.no_sep,ina_cbg.id as id_inacbg');
            $this->db->where('pasien_iri.no_sep !=','');
            $this->db->where('pasien_iri.carabayar','BPJS');             

            return $this->db->count_all_results();
        }

        private function _get_diagnosa_query()  {

            $this->db->FROM('diagnosa_iri');
            $this->db->where('no_register',$this->input->post('no_ipd'));        
        
            $i = 0;     
            foreach ($this->column_search_diagnosa as $item)
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
     
                    if(count($this->column_search_diagnosa) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->column_order_diagnosa[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order_diagnosa))
            {
                $order_diagnosa = $this->order_diagnosa;       
                $this->db->order_by(key($order_diagnosa), $order_diagnosa[key($order_diagnosa)]);
            }
        }         

        public function list_diagnosa()
        {
            $this->_get_diagnosa_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function diagnosa_filtered()
        {
            $this->_get_diagnosa_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function diagnosa_count_all()
        {
            $this->db->FROM('diagnosa_iri'); 
            $this->db->where('no_register',$this->input->post('no_ipd'));             

            return $this->db->count_all_results();
        }           
  
        function show_pasien($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
          $this->db->SELECT('data_pasien.no_cm,data_pasien.no_kartu,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex,daftar_ulang_irj.no_sep');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        } 

        function get_coder_nik($username) {
          $this->db->FROM('hmis_users');
          $this->db->SELECT('coder_nik');   
          $this->db->where('username', $username);
          $query = $this->db->get();
          return $query->row();
        }      


        function diagnosa_iri($no_sep) {
          $this->db->FROM('pasien_iri');
          $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
          $this->db->JOIN('diagnosa_iri', 'pasien_iri.no_ipd = diagnosa_iri.no_register', 'inner');
          $this->db->SELECT('pasien_iri.no_sep,pasien_iri.tgl_masuk,diagnosa_iri.no_register,diagnosa_iri.id_diagnosa,diagnosa_iri.klasifikasi_diagnos,diagnosa_iri.diagnosa');    
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }
       function diagnosa_utama($no_sep) {
          $this->db->FROM('pasien_iri');
          $this->db->SELECT('diagnosa1');    
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }     

        function show_diagnosa($id_diagnosa_pasien) {
          $this->db->FROM('diagnosa_iri'); 
          $this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
          $query = $this->db->get();
          return $query->row();
        }         

        function procedure_iri($no_sep) {
          $this->db->FROM('pasien_iri');
          $this->db->JOIN('icd9cm_iri', 'pasien_iri.no_ipd = icd9cm_iri.no_register', 'inner');
          $this->db->SELECT('icd9cm_iri.no_register,icd9cm_iri.id_procedure,icd9cm_iri.procedure,icd9cm_iri.klasifikasi_procedure');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }            

        function dataklaim_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
          $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
          $this->db->SELECT('daftar_ulang_irj.no_sep,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.tgl_pulang,klaim.id as id_klaim,daftar_ulang_irj.id_dokter');   
          $this->db->where('daftar_ulang_irj.no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }                       

        function insert_klaim_irj($data_insert){          
            $this->db->insert('klaim', $data_insert);
            return $this->db->insert_id();
        }  

        function setklaim_irj($data_setklaim){          
            $this->db->insert('set_klaim', $data_setklaim);
            return $this->db->insert_id();
        }    

////// Fix ///
        function get_dataklaim($no_ipd) {
          $this->db->FROM('pasien_iri');
          $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');         
          $this->db->SELECT('pasien_iri.no_sep,data_pasien.no_kartu,pasien_iri.tgl_masuk,pasien_iri.tgl_keluar,pasien_iri.id_dokter,data_pasien.no_cm,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex as gender,pasien_iri.no_cm,pasien_iri.status_pulang,data_pasien.kelas_bpjs,pasien_iri.no_cm,pasien_iri.klsiri,pasien_iri.keadaanpulang');   
          $this->db->where('no_ipd', $no_ipd);
          $query = $this->db->get();
          return $query->row();
        }  

        function get_tarif_rs($no_register) {
          $this->db->FROM('pelayanan_poli');
          $this->db->JOIN('daftar_ulang_irj', 'pelayanan_poli.no_register = daftar_ulang_irj.no_register', 'inner');          
          $this->db->SELECT('IFNULL(SUM(pelayanan_poli.vtot), 0) AS tarif');   
          $this->db->where('pelayanan_poli.no_register', $no_register);
          $query = $this->db->get();
          return $query->row();
        }          

        function claim_status($no_sep) {
          $this->db->FROM('ina_cbg');
          $this->db->SELECT('status');   
          $this->db->where('nomor_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        } 
        function check_klaim($no_sep) {
          $this->db->FROM('ina_cbg');  
          $this->db->where('nomor_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }         

        function insert_inacbg($data_insert){          
            $this->db->insert('ina_cbg', $data_insert);
            return true;
        }   
        
        function update_klaim($data_update,$no_sep){
            $this->db->where('nomor_sep', $no_sep);
            $this->db->update('ina_cbg', $data_update);
            return true;
        } 
        function update_klasifikasi($id_icd9cm,$data_update){
            $this->db->query("update icd9cm_iri set klasifikasi_procedure='tambahan' where klasifikasi_procedure='utama'");
            $this->db->where('id', $id_icd9cm);
            $this->db->update('icd9cm_iri', $data_update);
            return true;
        }                                                                       

	}

?>