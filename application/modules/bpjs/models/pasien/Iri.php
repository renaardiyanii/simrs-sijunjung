<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Iri extends CI_Model {
        var $column_order = array(null,'pasien_iri.no_sep','data_pasien.no_cm','data_pasien.nama','nama','data_pasien.no_kartu','pasien_iri.tgl_masuk');
        var $column_search = array('pasien_iri.no_ipd','pasien_iri.no_sep','data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','pasien_iri.tgl_masuk'); 
        var $order = array('pasien_iri.tgldaftarri' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_datatables_query()  {
            $tanggal_cari = $this->input->post('tanggal_cari');
            $form_hari = substr($tanggal_cari,0,2);
            $form_bulan = substr($tanggal_cari,3,2);
            $form_tahun = substr($tanggal_cari,6,4);
            $from_date = $form_tahun.'/'.$form_bulan.'/'.$form_hari;
            $to_hari = substr($tanggal_cari,13,2);
            $to_bulan = substr($tanggal_cari,16,2);
            $to_tahun = substr($tanggal_cari,19,4);       
            $to_date = $to_tahun.'/'.$to_bulan.'/'.$to_hari;
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.tgl_masuk');
            $this->db->where('pasien_iri.carabayar','BPJS');   
            $this->db->where("TO_CHAR(pasien_iri.tgl_masuk,'YYYY/MM/DD') BETWEEN '$from_date' AND '$to_date'");    
        
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
            $tanggal_cari = $this->input->post('tanggal_cari');
            $from_date = substr($tanggal_cari,0,10);
            $to_date = substr($tanggal_cari,13,23);
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('pasien_iri.no_ipd,pasien_iri.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.tgl_masuk');
            $this->db->where('pasien_iri.carabayar','BPJS');   
            $this->db->where("TO_CHAR(pasien_iri.tgl_masuk,'YYYY/MM/DD') BETWEEN '$from_date' AND '$to_date'");   

            return $this->db->count_all_results();
        }                                                                   

	}

?>