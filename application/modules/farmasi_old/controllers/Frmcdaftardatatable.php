<?php

    class Frmcdaftardatatable extends Secure_area
    {
        public function __construct()
        {  
            parent::__construct();
            $this->load->model('Frmmdaftardatatable');
        }

        public function index()
        {
            $this->load->view('home');
        }

        public function onetable()
        {
            $this->load->view('onetable');

        }

        public function tablewhere()
        {
            $this->load->view('tablewhere');

        }

        public function tablequery()
        {
            $this->load->view('tablequery');

        }

        function view_data()
        {
            $tables = "permintaan_obat";
            $search = array('no_register','nama','no_cm','CAST(no_medrec as VARCHAR)');
            $isWhere = 'TO_CHAR(tgl_kunjungan,\'YYYY-MM-DD\') = \''.date('Y-m-d').'\'';
            $iswherewajib = ' obat = \'1\' and (farmasi <> \'2\' or farmasi = \'1\' or farmasi is null)';
            header('Content-Type: application/json');
            // echo $this->Frmmdaftardatatable->get_tables($tables,$search,$isWhere,',(SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep',$iswherewajib);
            echo $this->Frmmdaftardatatable->get_tables($tables,$search,$isWhere,'',$iswherewajib);
        }

        function view_data_where()
        {
            $tables = "artikel";
            $search = array('judul','kategori','penulis','tgl_posting');
            $where  = array('kategori' => 'php');
            // jika memakai IS NULL pada where sql
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_where($tables,$search,$where,$isWhere);
        }

        function view_data_query()
        {
            $query  = "SELECT kategori.nama_kategori AS nama_kategori, subkat.* FROM subkat 
                       JOIN kategori ON subkat.id_kategori = kategori.id_kategori";
            $search = array('nama_kategori','subkat','tgl_add');
            $where  = null; 
            // $where  = array('nama_kategori' => 'Tutorial');
            
            // jika memakai IS NULL pada where sql
            $isWhere = null;
            // $isWhere = 'artikel.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query,$search,$where,$isWhere);
        }
    }
?>