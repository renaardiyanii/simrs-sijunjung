<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mantrian extends CI_Model {        
        public function __construct() {
            parent::__construct();
        }

        function get_antrian($cur_date) {
          $this->db->FROM('antrian_pendaftaran');           
          $this->db->where('tanggal', $cur_date);
          $query = $this->db->get();
          return $query->row();
        }                               

        // function insert_klaim_irj($data_insert){          
        //     $this->db->insert('klaim', $data_insert);
        //     return $this->db->insert_id();
        // }   
        
        function update_antrian($data_update) {
            date_default_timezone_set("Asia/Jakarta");
            $cur_date = date('Y-m-d');
            $this->db->where('tanggal', $cur_date);
            $this->db->update('antrian_pendaftaran', $data_update);
            return true;
        }                                                                      

	}

?>