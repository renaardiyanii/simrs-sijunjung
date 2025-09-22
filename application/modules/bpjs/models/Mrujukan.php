<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mrujukan extends CI_Model {
        var $column_order = array(null,'no_rujukan','no_sep','poli_tujuan','nama','no_bpjs','no_bpjs','tgl_rujukan');
        var $column_search = array(null,'no_rujukan','no_sep','poli_tujuan','nama','no_bpjs','no_bpjs','tgl_rujukan'); 
        var $order = array('id' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_datatables_query()  {
            $tanggal_cari = $this->input->post('tanggal_cari');
            $from_date = substr($tanggal_cari,0,10);
            $to_date = substr($tanggal_cari,13,23);
            $this->db->FROM('bpjs_rujukan');           
            $this->db->where("DATE_FORMAT(tgl_rujukan,'%Y-%m-%d') BETWEEN DATE_FORMAT('$from_date','%Y-%m-%d') AND DATE_FORMAT('$to_date','%Y-%m-%d')");            
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
 
        public function get_rujukan()
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
            $this->db->FROM('bpjs_rujukan');           
            $this->db->where("DATE_FORMAT(tgl_rujukan,'%Y-%m-%d') BETWEEN DATE_FORMAT('$from_date','%Y-%m-%d') AND DATE_FORMAT('$to_date','%Y-%m-%d')");                    
            return $this->db->count_all_results();
        }  

        function insert_rujukan($data)
        {
            $result = $this->db->insert('bpjs_rujukan', $data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }   

        function show_rujukan($no_rujukan) 
        {         
            $this->db->from('bpjs_rujukan');        
            $this->db->where('no_rujukan', $no_rujukan);
            $query = $this->db->get();
            return $query->row();      
        }          

        function update($no_rujukan,$data_update)
        {
            $this->db->where('no_rujukan', $no_rujukan);
            $this->db->update('bpjs_rujukan', $data_update);
            return true;
        }                                                     

	}

?>