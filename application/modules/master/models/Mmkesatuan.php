<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkesatuan extends CI_Model {
        var $column_order = array(null,'tni_kesatuan.kst_nama');
        var $column_search = array(null,'tni_kesatuan.kst_nama'); 
        var $order = array('tni_kesatuan.kst_id' => 'desc');  

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		    private function _get_datatables()  {
          $this->db->FROM('tni_kesatuan');
          $this->db->JOIN('tni_kesatuan2', 'tni_kesatuan.kst_id = tni_kesatuan2.kst_id', 'left');
          $this->db->JOIN('tni_kesatuan3', 'tni_kesatuan2.kst2_id = tni_kesatuan3.kst2_id', 'left');
          $this->db->select('tni_kesatuan.kst_id,tni_kesatuan.kst_nama,tni_kesatuan2.kst2_id,tni_kesatuan2.kst2_nama,tni_kesatuan3.kst3_id,tni_kesatuan3.kst3_nama');
          $i = 0;     
          foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
              if($i===0) {
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
 
        public function get_kesatuan()
        {
            $this->_get_datatables();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function count_filtered()
        {
            $this->_get_datatables();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function count_all()
        {
            $this->db->FROM('tni_kesatuan');
            $this->db->JOIN('tni_kesatuan2', 'tni_kesatuan.kst_id = tni_kesatuan2.kst_id', 'left');
            $this->db->JOIN('tni_kesatuan3', 'tni_kesatuan2.kst2_id = tni_kesatuan3.kst2_id', 'left');
            $this->db->select('tni_kesatuan.kst_id,tni_kesatuan.kst_nama,tni_kesatuan2.kst2_id,tni_kesatuan2.kst2_nama,tni_kesatuan3.kst3_id,tni_kesatuan3.kst3_nama');     
            return $this->db->count_all_results();
        }    

        function get_kesatuan_all(){
          $this->db->FROM('tni_kesatuan');
          $this->db->JOIN('tni_kesatuan2', 'tni_kesatuan.kst_id = tni_kesatuan2.kst_id', 'left');
          $this->db->JOIN('tni_kesatuan3', 'tni_kesatuan2.kst2_id = tni_kesatuan3.kst2_id', 'left');
          $this->db->select('tni_kesatuan.kst_id,tni_kesatuan.kst_nama,tni_kesatuan2.kst2_id,tni_kesatuan2.kst2_nama,tni_kesatuan3.kst3_id,tni_kesatuan3.kst3_nama');
          $this->db->order_by('tni_kesatuan.kst_id');
          $query = $this->db->get();
          return $query;
        }

        function get_kesatuan1(){
          $this->db->select('*');
          $this->db->FROM('tni_kesatuan');        
          $this->db->order_by('tni_kesatuan.kst_id');
          $query = $this->db->get();
          return $query;
        }

        function get_kesatuan2(){
          $this->db->select('*');
          $this->db->FROM('tni_kesatuan2');        
          $this->db->order_by('tni_kesatuan2.kst2_id');
          $query = $this->db->get();
          return $query;
        }

        function get_kesatuan3(){
          $this->db->select('*');
          $this->db->FROM('tni_kesatuan3');        
          $this->db->order_by('tni_kesatuan3.kst3_id');
          $query = $this->db->get();
          return $query;
        }

        // function get_rl2($tahun) {
        //     $this->db->FROM('rl_tenaga_kerja');
        //     $this->db->where('tahun',$tahun); 
        //     $this->db->order_by('bulan','desc');
        //     $query = $this->db->get();
        //     return $query->result();
        // } 
        
        // function show_kesatuan($id) {
        //     $this->db->FROM('rl_tenaga_kerja');
        //     $this->db->where('id',$id); 
        //     $query = $this->db->get();
        //     return $query->row();
        // }  
        // function insert_kesatuan($data) {      
        //   $this->db->insert('rl_tenaga_kerja', $data);
        //   return true;
        // }   
        // function edit_kesatuan($id,$data) {      
        //   $this->db->where('id', $id);
        //   $this->db->update('rl_tenaga_kerja', $data);
        //   return true;
        // }     
        // public function delete_kesatuan($id){
        //   $this->db->where('id', $id);
        //   $this->db->delete('rl_tenaga_kerja');
        //   return true;
        // }   

	}

?>