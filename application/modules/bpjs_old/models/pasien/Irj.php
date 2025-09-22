<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Irj extends CI_Model {
        var $column_order = array(null,'daftar_ulang_irj.no_sep','data_pasien.no_cm','data_pasien.nama','nama','data_pasien.no_kartu','daftar_ulang_irj.tgl_kunjungan');
        var $column_search = array('daftar_ulang_irj.no_sep','data_pasien.no_cm','data_pasien.nama','nama','data_pasien.no_kartu','daftar_ulang_irj.tgl_kunjungan'); 
        var $order = array('daftar_ulang_irj.tgl_kunjungan' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        private function _get_datatables_query()  {
            $tanggal_cari = $this->input->post('tanggal_cari');
            // $replace_tgl = str_replace('/','-',$tanggal_cari);
            $form_hari = substr($tanggal_cari,0,2);
            $form_bulan = substr($tanggal_cari,3,2);
            $form_tahun = substr($tanggal_cari,6,4);
            $from_date = $form_tahun.'/'.$form_bulan.'/'.$form_hari;
            $to_hari = substr($tanggal_cari,13,2);
            $to_bulan = substr($tanggal_cari,16,2);
            $to_tahun = substr($tanggal_cari,19,4);       
            $to_date = $to_tahun.'/'.$to_bulan.'/'.$to_hari;
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('daftar_ulang_irj.no_register,daftar_ulang_irj.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan');
            // $this->db->where('daftar_ulang_irj.no_sep IS NOT NULL');
            $this->db->where('daftar_ulang_irj.cara_bayar','BPJS');
            $this->db->where("TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY/MM/DD') BETWEEN '$from_date' AND '$to_date'");    
            // $this->db->where('daftar_ulang_irj.ket_pulang !=', 'BATAL_PELAYANAN_POLI');
            $this->db->where('daftar_ulang_irj.ket_pulang IS NULL');        
        
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
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->select('daftar_ulang_irj.no_register,daftar_ulang_irj.no_sep,data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan');
            // $this->db->where('daftar_ulang_irj.no_sep IS NOT NULL');
            $this->db->where('daftar_ulang_irj.cara_bayar','BPJS');
            $this->db->where("TO_CHAR(daftar_ulang_irj.tgl_kunjungan,'YYYY/MM/DD') BETWEEN '$from_date' AND '$to_date'");    
            // $this->db->where('daftar_ulang_irj.ket_pulang !=', 'BATAL_PELAYANAN_POLI');
            $this->db->where('daftar_ulang_irj.ket_pulang IS NULL');          
            return $this->db->count_all_results();
        }                                                                   

    }

?>