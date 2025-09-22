<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class FrmcreturGudang extends Secure_area{

    public function __construct(){
        parent::__construct();
        $this->load->model('logistik_farmasi/FrmmreturGudang','',TRUE);
        $this->load->model('user/Muser','',TRUE);
        $this->load->library('session');
    }

    public function index(){
        $data['title'] = 'Daftar Penerimaan Barang';
        $data['logistik_farmasi']=$this->FrmmreturGudang->get_amprah();
        $this->load->view('logistik_farmasi/Frmvdaftardistribusigudang', $data);
    }

    function retur($id){
        $data['title'] = 'Daftar Penerimaan Barang';
        $data['retur_barang'] = $this->FrmmreturGudang->get_amprah_detail_list($id);
        $data['id_amprah'] = $id;
        $this->load->view('logistik_farmasi/Frmvdaftardetailreturgudang',$data);
    }

    public function edit_data_retur(){
        $batch_no=$this->input->post('batch_no');
        $userid = $this->session->userid;
        $group = $this->Muser->getIdGudang($userid);
        $id_gudang = $group->id_gudang;
        $datajson=$this->FrmmreturGudang->get_data_retur_by_batch($batch_no, $id_gudang)->result();
        echo json_encode($datajson);
    }

    function save_retur_gudang(){
        $userid = $this->session->userid;
        $group = $this->Muser->getIdGudang($userid);
        $id_gudang = $group->id_gudang;

        $id_amprah = $this->input->post('id_amprah');
        $this->FrmmreturGudang->insert_quantity($this->input->post());
        $this->FrmmreturGudang->edit_stok($this->input->post(), $id_gudang);
        redirect('logistik_farmasi/FrmcreturGudang/retur/'.$id_amprah);
    }
}