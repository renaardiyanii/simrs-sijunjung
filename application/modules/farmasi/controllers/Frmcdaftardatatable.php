<?php

class Frmcdaftardatatable extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Frmmdaftardatatable');
        $this->load->model('Frmmdaftar');
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
        $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
        $isWhere = 'tgl_kunjungan = \'' . date('Y-m-d') . '\'';
        $iswherewajib = ' obat = \'1\' and wkt_telaah_obat is null';
        header('Content-Type: application/json');
        echo $this->Frmmdaftardatatable->get_tables(
            $tables,
            $search,
            $isWhere,
            ',
            (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
            (select no_sep from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register),
            (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int))',
            $iswherewajib
        );
    }

    function view_data_persiapan()
    {
        $login_data = $this->load->get_var("user_info");
        $roleid = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
        if($roleid == '1014'){
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . date('Y-m-d') . '\'';
            $iswherewajib = ' obat = \'1\' and left(no_register,2) = \'RJ\'';
            header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables(
                $tables,
                $search,
                $isWhere,
                ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select alamat from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec)
               ',
                $iswherewajib
            );
        }else if($roleid == '1046'){
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . date('Y-m-d') . '\'';
            $iswherewajib = ' obat = \'1\' and left(no_register,2) = \'RI\'';
            header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables(
                $tables,
                $search,
                $isWhere,
                ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select alamat from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec)
               ',
                $iswherewajib
            );
        }else{
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . date('Y-m-d') . '\'';
            $iswherewajib = ' obat = \'1\'';
            header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables(
                $tables,
                $search,
                $isWhere,
                ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select alamat from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = data_pasien.no_medrec)
            ',
                $iswherewajib
            );
        }



        
    } 

    function view_data_bynoreg($noreg)
    {
        $tables = "permintaan_obat";
        $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
        $isWhere = 'no_cm LIKE \'%' . $noreg . '%\'';
        $iswherewajib = ' obat = \'1\' and wkt_telaah_obat is null';
        // header('Content-Type: application/json');
        echo $this->Frmmdaftardatatable->get_tables(
            $tables,
            $search,
            $isWhere,
            ',
            (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
            (select no_sep from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register),
            (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int))',
            $iswherewajib
        );
    }

    function view_data_persiapan_bynoreg($noreg)
    {
        $tables = "permintaan_obat";
        $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
        $isWhere = 'no_cm LIKE \'%' . $noreg . '%\'';
        $iswherewajib = ' obat = \'1\' and wkt_telaah_obat is not null';
        // header('Content-Type: application/json');
        echo $this->Frmmdaftardatatable->get_tables($tables, $search, $isWhere, ',
            (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
            (select sex from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select no_hp from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select wkt_dispensing_obat from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register),
            (select wkt_penyerahan_obat from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register)', $iswherewajib);
    }

    function view_data_bydate($date)
    {
        $tables = "permintaan_obat";
        $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
        $isWhere = 'tgl_kunjungan = \'' . $date . '\'';
        $iswherewajib = ' obat = \'1\' and wkt_telaah_obat is null';
        // header('Content-Type: application/json');
        echo $this->Frmmdaftardatatable->get_tables(
            $tables,
            $search,
            $isWhere,
            ',
            (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
            (select sex from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select no_hp from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
            (select wkt_dispensing_obat from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register),
            (select wkt_penyerahan_obat from daftar_ulang_irj where permintaan_obat.no_register = daftar_ulang_irj.no_register)',
            $iswherewajib
        );
    }

    function view_data_persiapan_bydate($date)
    {

        $login_data = $this->load->get_var("user_info");
        $roleid = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;
        if($roleid == '1014'){
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . $date . '\'';
            $iswherewajib = ' obat = \'1\' and left(no_register,2) = \'RJ\'';
            // header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables($tables, $search, $isWhere, ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int))
            
                ', $iswherewajib);
        }else if($roleid == '1046'){
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . $date . '\'';
            $iswherewajib = ' obat = \'1\' and left(no_register,2) = \'RI\'';
            // header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables($tables, $search, $isWhere, ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int))
            
                ', $iswherewajib);
        }else{
            $tables = "permintaan_obat";
            $search = array('no_register', 'nama', 'no_cm', 'CAST(no_medrec as VARCHAR)');
            $isWhere = 'tgl_kunjungan = \'' . $date . '\'';
            $iswherewajib = ' obat = \'1\'';
            // header('Content-Type: application/json');
            echo $this->Frmmdaftardatatable->get_tables($tables, $search, $isWhere, ',
                (SELECT no_resep FROM resep_pasien WHERE no_register=permintaan_obat.no_register GROUP BY no_resep limit 1) as jml_resep,
                (select sex from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select alamat from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int)),
                (select no_hp from data_pasien where permintaan_obat.no_medrec = cast(data_pasien.no_cm as int))
            
                ', $iswherewajib);
        }


       
    }

    function view_data_bynoreg_($noreg)
    {
        $hasil = $this->Frmmdaftardatatable->get_pasien_resep_bynoreg($noreg)->result();

        $line  = array();
        $line2 = array();
        $row2  = array();
        $i = 1;
        $persen = 0;
        foreach ($hasil as $value) {
            // $row2['aksi'] = '
            // <button class="btn btn-primary btn-sm resep">Resep</button><br>
            // <button class="btn btn-primary btn-sm telaah">Telaah Obat</button><br>'
            $row2['tgl_kunjungan'] = $value->tgl_kunjungan;
            $row2['no_cm'] = $value->no_cm;
            $row2['no_register'] = $value->no_register;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['ruang'] = $value->bed;
            $row2['cara_bayar'] = $value->cara_bayar;
            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function view_data_where()
    {
        $tables = "artikel";
        $search = array('judul', 'kategori', 'penulis', 'tgl_posting');
        $where  = array('kategori' => 'php');
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }

    function view_data_query()
    {
        $query  = "SELECT kategori.nama_kategori AS nama_kategori, subkat.* FROM subkat 
                       JOIN kategori ON subkat.id_kategori = kategori.id_kategori";
        $search = array('nama_kategori', 'subkat', 'tgl_add');
        $where  = null;
        // $where  = array('nama_kategori' => 'Tutorial');

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }
}
