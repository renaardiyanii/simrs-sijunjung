<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class M_diet extends CI_Model {
        var $column_order = array(null,'no_ipd','standar','bentuk','catatan','gizi_permintaan_diet.created_by','gizi_permintaan_diet.created_at');
        var $column_search = array('no_ipd','standar','bentuk','catatan','gizi_permintaan_diet.created_by','gizi_permintaan_diet.created_at'); 
        var $order = array('gizi_permintaan_diet.created_at' => 'asc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

    private function _get_datatables_query()  {
            $no_ipd = $this->input->post('no_ipd');
            $this->db->select('gizi_permintaan_diet.standar,gizi_permintaan_diet.bentuk,gizi_bentuk_makanan.nm_bentuk,gizi_permintaan_diet.catatan,gizi_permintaan_diet.created_at,gizi_permintaan_diet.created_by'); 
            $this->db->from('gizi_permintaan_diet'); 
            $this->db->join('gizi_bentuk_makanan', 'gizi_permintaan_diet.bentuk = gizi_bentuk_makanan.kode','inner');   
            $this->db->where('gizi_permintaan_diet.no_ipd', $no_ipd); 
        
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
 
        public function get_history()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function count_filtered_history()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function count_all_history()
        {
            $no_ipd = $this->input->post('no_ipd');
            $this->db->select('gizi_permintaan_diet.standar,gizi_permintaan_diet.bentuk,gizi_bentuk_makanan.nm_bentuk,gizi_permintaan_diet.catatan,gizi_permintaan_diet.created_at,gizi_permintaan_diet.created_by'); 
            $this->db->from('gizi_permintaan_diet'); 
            $this->db->join('gizi_bentuk_makanan', 'gizi_permintaan_diet.bentuk = gizi_bentuk_makanan.kode','inner');  
            $this->db->where('gizi_permintaan_diet.no_ipd', $no_ipd);           
            return $this->db->count_all_results();
        }
  }

?>