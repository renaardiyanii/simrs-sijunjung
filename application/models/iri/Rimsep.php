<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rimsep extends CI_Model {
        var $column_order = array(null,'pasien_iri.no_sep','data_pasien.no_cm','data_pasien.nama','nama','data_pasien.no_kartu','pasien_iri.tgl_masuk');
        var $column_search = array('pasien_iri.no_ipd','pasien_iri.no_sep','data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','pasien_iri.tgl_masuk'); 
        var $order = array('pasien_iri.tgl_masuk' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_datatables_query()  {

            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_medrec', 'inner');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.tgl_masuk,pasien_iri.hapusSEP');
            $this->db->where('pasien_iri.no_sep IS NOT NULL');
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
 
        public function get_sep()
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
            $this->db->select('pasien_iri.no_ipd,pasien_iri.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.tgl_masuk,pasien_iri.hapusSEP');
            $this->db->where('pasien_iri.no_sep IS NOT NULL');
            $this->db->where('pasien_iri.carabayar','BPJS');         

            return $this->db->count_all_results();
        }                                                                   

	}

?>