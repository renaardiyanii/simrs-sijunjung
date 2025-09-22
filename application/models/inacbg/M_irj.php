<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class M_irj extends CI_Model {
        var $column_order = array(null,null,'tgl_kunjungan','no_cm','nama','no_kartu','no_sep');
        var $column_search = array('data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','daftar_ulang_irj.no_sep','daftar_ulang_irj.id_poli'); 
        var $order = array('tgl_kunjungan' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

    private function _get_datatables_query()  {
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ina_cbg', 'daftar_ulang_irj.no_sep = ina_cbg.no_sep', 'left');
            $this->db->select('id_poli,tgl_kunjungan,data_pasien.no_cm,nama,no_kartu,daftar_ulang_irj.no_register,no_sep,klaim,ina_cbg.id as id_inacbg');
            $this->db->where('daftar_ulang_irj.no_sep !=','');
            $this->db->where('daftar_ulang_irj.cara_bayar','BPJS');
            $this->db->where('daftar_ulang_irj.tgl_pulang !=','');
        
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
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->JOIN('ina_cbg', 'daftar_ulang_irj.no_sep = ina_cbg.no_sep', 'left');
            $this->db->select('id_poli,tgl_kunjungan,data_pasien.no_cm,nama,no_kartu,daftar_ulang_irj.no_register,no_sep,klaim,ina_cbg.id as id_inacbg');
            $this->db->where('daftar_ulang_irj.no_sep !=','');
            $this->db->where('daftar_ulang_irj.cara_bayar','BPJS');            

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

        function get_dokter($id_dokter) {
          $this->db->FROM('data_dokter');
          $this->db->SELECT('nm_dokter');   
          $this->db->where('id_dokter', $id_dokter);
          $query = $this->db->get();
          return $query->row();
        }         


        function diagnosa_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('diagnosa_pasien', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'inner');
          $this->db->SELECT('diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }    

        function procedure_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
          $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.nm_procedure,icd9cm_irj.klasifikasi_procedure');   
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
        function get_dataklaim($no_register) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');          
          $this->db->SELECT('daftar_ulang_irj.no_sep,daftar_ulang_irj.vtot_rad,daftar_ulang_irj.vtot_obat,daftar_ulang_irj.vtot_lab,daftar_ulang_irj.biaya_alkes,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.tgl_pulang,daftar_ulang_irj.id_dokter,data_pasien.no_cm,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex as gender,daftar_ulang_irj.no_medrec,daftar_ulang_irj.id_poli,daftar_ulang_irj.ket_pulang,data_pasien.kelas_bpjs');   
          $this->db->where('no_register', $no_register);
          $query = $this->db->get();
          return $query->row();
        }  

        function jatah_kelas($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');          
          $this->db->SELECT('data_pasien.kelas_bpjs');   
          $this->db->where('daftar_ulang_irj.no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }         

        // function get_tarif_rs($no_register) {
        //   $this->db->FROM('pelayanan_poli');
        //   $this->db->JOIN('daftar_ulang_irj', 'pelayanan_poli.no_register = daftar_ulang_irj.no_register', 'inner');          
        //   $this->db->SELECT('IFNULL(SUM(pelayanan_poli.vtot), 0) AS tarif');   
        //   $this->db->where('pelayanan_poli.no_register', $no_register);
        //   $query = $this->db->get();
        //   return $query->row();
        // }             

        function claim_status($no_register) {
          $this->db->FROM('ina_cbg');           
          $this->db->where('no_register', $no_register);
          $query = $this->db->get();
          return $query->row();
        } 
        function check_klaim($no_sep) {
          $this->db->FROM('ina_cbg');  
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }      

        function delete_klaim($no_sep){
            $this->db->where('no_sep', $no_sep);
            $this->db->delete('ina_cbg');
            return true;
        }   

        function insert_inacbg($data_insert){          
            $this->db->insert('ina_cbg', $data_insert);
            return true;
        }   
        
        function update_klaim($data_update,$no_sep){
            $this->db->where('no_sep', $no_sep);
            $this->db->update('ina_cbg', $data_update);
            return true;
        }                                                                      

  }

?>