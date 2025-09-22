<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once(APPPATH . 'controllers/Secure_area.php');

class Frmcreturjual extends Secure_area{

    function __construct(){
        parent::__construct();
        $this->load->model('farmasi/Frmmdaftar','',TRUE);
        $this->load->model('farmasi/Frmmreturjual','',TRUE);
        $this->load->model('user/Muser','',TRUE);
    }

    /* Data Codingan Lama~~
     *
     * public function index(){
        $data['title'] = 'Daftar Pasien Selesai';
        $this->load->view('farmasi/Frmvlistpasienselesai', $data);
    }

    function get_list_pasien(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
            $hasil = $this->Frmmreturjual->get_daftar_pasien($this->input->post())->result();

            foreach ($hasil as $value) {
                $row2['no_resep'] = "<p align='center'>".$value->no_resep."</p>";
                $row2['no_register'] = $value->no_register;
                $row2['nama'] = $value->nama;
                $row2['tgl_kunjungan'] = "<p align='center'>".$value->tgl_kunjungan."</p>";
                $row2['kelas'] = "<p align='center'>".$value->kelas."</p>";
                $row2['idrg'] = $value->idrg;
                $row2['bed'] = $value->bed;
                $row2['cetak_kwitansi'] = $value->cetak_kwitansi;
                $row2['cara_bayar'] = $value->cara_bayar;

                $row2['aksi'] = '<center>
				<a href="'.base_url('farmasi/Frmcreturjual/retur/'.$value->no_register).'" class="btn btn-primary btn-sm">Detail</a> 
			    </center>';

                $line2[] = $row2;
            }
            $line['data'] = $line2;

        }
        echo json_encode($line);
    }

    function retur($noregister){
        $data['title'] = 'Retur Penjualan';
        $data['noregister'] = $noregister;
        $data['master'] = $this->Frmmreturjual->get_detail_pasien($noregister)->row();
        $data['items'] = $this->Frmmreturjual->get_list_resep($noregister)->result();
        $this->load->view('farmasi/Frmvdaftarreturjual', $data);
    }

    function edit_data_retur(){
        $idresep = $this->input->post('idresep');
        $itemid = $this->input->post('item_id');

        $userid = $this->session->userid;
        $group = $this->Muser->getIdGudang($userid);
        $id_gudang = $group->id_gudang;

        $json = $this->Frmmreturjual->get_detail_item_retur($idresep, $id_gudang)->result();
        echo json_encode($json);
    }

    function save_retur(){
        $noregister = $this->input->post('no_register');

        if ($this->input->post('edit_quantity') != 0) {
            $userid = $this->session->userid;
            $group = $this->Muser->getIdGudang($userid);
            $id_gudang = $group->id_gudang;

            $save = $this->Frmmreturjual->edit_stok($this->input->post(), $id_gudang);
            if($save > 0){
                $this->session->set_flashdata('success_msg', '<h3><span style="color: green; ">Transaksi Berhasil Disimpan!</span></h3>');
                redirect('farmasi/Frmcreturjual/retur/' . $noregister);
            }
        } else {
            $this->session->set_flashdata('success_msg', '<h3><span style="color: red; ">Stok Tidak Memenuhi!!!</span></h3>');
            redirect('farmasi/Frmcreturjual/retur/' . $noregister);
        }

        //echo print_r($_POST, true);
    }*/

    public function index(){
        $data['title'] = 'List Pasien';
        $this->load->view('farmasi/frmvpasienselesai', $data);
    }

    function get_list_pasien(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        // var_dump($this->input->post('date'));die();
        if($this->input->post('date') == ''){
            $date =date('Y-m-d');
        }else{
            $date =$this->input->post('date');
        }
         
        
        $hasil = $this->Frmmdaftar->get_pengambilan_resep_pasien_selesai($date)->result();

        $no = 1;
        foreach ($hasil as $key =>$value) {
            $statuscb = "";
            $row2['no'] = $no++;
            $row2['tgl_kunjungan'] = $value->tgl_kunjungan;
            $row2['no_resep'] = $value->no_resep;
            $row2['no_register'] = $value->no_resgister;
            $row2['nama'] = $value->nama;
            $row2['kelas'] = $value->kelas;
            $row2['idrg'] = $value->idrg;
            $row2['bed'] = $value->bed;
            if($value->cara_bayar=='UMUM'){
                $carabayar = $value->cara_bayar;
            }else {
                $carabayar = $value->cara_bayar;
            }
            $row2['status'] = $carabayar."".$statuscb;
            $row2['aksi'] = 
            "<a href='".site_url('farmasi/Frmcreturjual/retur/'.$value->no_resgister)."' class=\"btn btn-primary btn-sm\">Detail</a>";

            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function get_detail_list(){
        $line2 = array();
        $row2  = array();
        $hasil = $this->Frmmdaftar->get_detail_obat_retur($this->input->post('id'));

        $no = 1;
        foreach ($hasil->result() as $value) {
            $row2['no'] = $no;
            $row2['tgl_kunjungan'] = $value->tgl_kunjungan;
            $row2['id_obat'] = $value->nama_obat;
            $row2['harga_obat'] = "<div align='right'>".number_format($value->biaya_obat, '0', ',', '.')."</div>";
            $row2['subtotal'] = "<div align='right'>".number_format($value->vtot, '0', ',', '.')."</div>";
            $row2['qty_beli'] = "<div align='right'>".number_format($value->qty, '0', ',', '.')."</div>";

            // if($value->qty_retur != 0){
            //     $row2['qty_retur'] = "<div align=\"center\">$value->qty_retur</div>";
            // }else{
            //     $row2['qty_retur'] = "<div align=\"center\"><input type=\"number\" id=\"qty_retur$no\" name=\"qty_retur$no\" min=\"0\" max=\"$value->qty\" style=\"width: 60%\"></div>";
            // }

            $row2['aksi'] = "<div align=\"center\">
            <button class=\"btn btn-primary btn-sm\" onclick=\"retur_barang('$no', '$value->id_resep_pasien', '$value->id_inventory', '$value->no_resep', '$value->qty')\"><i class=\"fa fa-cart-plus\"></i> Retur</button>&nbsp; 
            <button class=\"btn btn-danger btn-sm\" onclick=\"hapus_barang('$no', '$value->id_resep_pasien', '$value->id_inventory', '$value->no_resep')\"><i class=\"fa fa-trash\"></i> Hapus</button> 
            </div>";

            $no++;
            $line2[] = $row2;
        }
        $line['data'] = $line2;

        echo json_encode($line);
    }

    function save_retur_barang(){
        $idresep = $this->input->post('idresep');
        $id_inventory = $this->input->post('id_inventory');
        $qty = $this->input->post('qty');
        var_dump($qty);die();


        $data = array(
            'qty' => $qty,
            'id_resep_pasien' => $idresep
        );
        $this->Frmmdaftar->update_data($data);
        $this->Frmmdaftar->update_stok($qty, $id_inventory);

        echo json_encode(array('sukses' => true));
    }

    function save_hapus_item(){
        $data['id_resep_pasien'] = $this->input->post('idresep');
        $data['id_inventory'] = $this->input->post('id_inventory');

        $this->Frmmdaftar->hapus_data_obat_penjualan($data);

        echo json_encode(array('sukses' => true));
    }

    function retur($noregister){
        $data['title'] = 'Retur Penjualan';
        $data['no_register'] = $noregister;
        $data['master'] = $this->Frmmreturjual->get_detail_pasien($noregister)->row();
        $data['items'] = $this->Frmmreturjual->get_list_resep($noregister)->result();

        if(substr($noregister, 0,2)=="PL"){
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($noregister)->row()->nmkontraktor;
            $data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($noregister)->row()->nmdokter;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($noregister)->result();
    
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['kelas_pasien']=$row->kelas;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']='-';
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['cara_bayar']=$row->cara_bayar;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
            }
        }else{
            $data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($noregister)->row()->nmkontraktor;
            $data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($noregister)->result();
            foreach($data['data_pasien_resep'] as $row){
                $data['nama']=$row->nama;
                $data['no_medrec']=$row->no_medrec;
                $data['no_cm']=$row->no_cm;
                $data['kelas_pasien']=$row->kelas;
                $data['tgl_kun']=$row->tgl_kunjungan;
                $data['idrg']=$row->idrg;
                $data['bed']=$row->bed;
                $data['cara_bayar']=$row->cara_bayar;
                $data['foto']=$row->foto;
        
            }
            if (substr($noregister, 0,2)=="RD"){
                $data['bed']='Rawat Darurat';
            }
        }
        $dokter = $this->Frmmdaftar->getnama_dokter_poli($noregister)->num_rows();
        if($dokter > 0){
            $data['nmdokter'] = $this->Frmmdaftar->getnama_dokter_poli($noregister)->row()->nmdokter;
        }else{
            $data['nmdokter'] = "";
        }

        $this->load->view('farmasi/frmvdaftarreturjual', $data);
    }

    function edit_data_retur(){
        $idresep = $this->input->post('idresep');
        $itemid = $this->input->post('item_id');

        $userid = $this->session->userid;
        $group = $this->Muser->getIdGudang($userid);
        $id_gudang = $group->id_gudang;

        $json = $this->Frmmreturjual->get_detail_item_retur($idresep, $id_gudang)->result();
        echo json_encode($json);
    }

    function save_retur(){
            // var_dump($this->input->post());die();
            $noregister = $this->input->post('no_register');
            $id_resep = $this->input->post('id_resep');
    
            if ($this->input->post('edit_quantity') != 0) {
                $userid = $this->session->userid;
                $group = $this->Muser->getIdGudang($userid);
                $id_gudang = $group->id_gudang;
    
                $save = $this->Frmmreturjual->edit_stok($this->input->post(), $id_gudang);
                if($save > 0){
                    $this->session->set_flashdata('success_msg', '<h3><span style="color: green; ">Transaksi Berhasil Disimpan!</span></h3>');
                    redirect('farmasi/Frmcreturjual/retur/' . $noregister);
                }
            } else {
                $this->session->set_flashdata('success_msg', '<h3><span style="color: red; ">Stok Tidak Memenuhi!!!</span></h3>');
                redirect('farmasi/Frmcreturjual/retur/' . $noregister);
            }
    
            //echo print_r($_POST, true);
    }
}