<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// var_dump($data);die;
// require_once(APPPATH.'controllers/Secure_area.php');
class FrmCDistribusiLangsung extends Secure_area{

    public function __construct(){
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmdistribusi','',TRUE);
        $this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpemasok','',TRUE);
        $this->load->model('master/Mmobat','',TRUE);
        $this->load->helper('pdf_helper');
    }

    public function index(){
        $data['title'] = 'Distribusi Langsung';
        $date = date('Y-m-d');
        $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
        $data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();
        $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
        $data['data_obat']=$this->Mmobat->get_obat_by_gudang_for_distribusi($id_gudang)->result();
        $data['select_jenis']=$this->Frmmpemasok->cari_jenis()->result();
        $data['data_distribusi']=$this->Frmmamprah->get_data_distribusi_all($date,$id_gudang)->result();
        // var_dump($date);die();
        // $data['data_obat']=$this->Mmobat->getAllObat_adaStok()->result();
        $this->load->view('logistik_farmasi/Frmvdistribusilangsung',$data);
    }

    function search_dis_by_date(){
     
      $data['title'] = 'Detail Distribusi';
      $date = $this->input->post('tgl');
      if($date == ''){
        $date = date('Y-m-d');
      }

      $line2=$this->Frmmamprah->get_data_distribusi_all($date)->result();
  // var_dump($data['data_distribusi']);die();
      $line['data_distribusi'] = $line2;
     echo json_encode($line);

     
  }

    function insert_header_distribusi($id_gudang=''){
     
        $data['title'] = 'Detail Distribusi';
       $id= $this->Frmmamprah->insertdistribusiheader($this->input->post()) ;
       redirect('logistik_farmasi/FrmcDistribusiLangsung/form_detail_distribusi/'.$id);
       
    }

    function hapus_data_distribusi($id_dis,$id){
     
      $data['title'] = 'Detail Distribusi';
     $this->Frmmamprah->delete_item_distribusi($id);
     redirect('logistik_farmasi/FrmcDistribusiLangsung/form_detail_distribusi/'.$id_dis);
     
    }

    function insert_verifikasi(){
     
      $data['title'] = 'Detail Distribusi';
      $id_dis = $this->input->post('id_distribusi');

      $this->Frmmamprah->update_verif_header_dis($id_dis);
      $data['header']= $this->Frmmamprah->get_distribusi($id_dis)->row();
      $data['item_distribusi']= $this->Frmmamprah->get_item_distribusi($id_dis)->result();
      $this->Frmmamprah->insert_stock_verif($data);
      // var_dump($data['item_distribusi']);die();
      redirect('logistik_farmasi/FrmcDistribusiLangsung');
     
    }

    function form_detail_distribusi($id=''){
     
      $data['title'] = 'Detail Distribusi';
      $id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
      $data['data_obat']=$this->Mmobat->get_obat_by_gudang_for_distribusi($id_gudang)->result();
      $data['select_jenis']=$this->Frmmpemasok->cari_jenis()->result();
      
      $data_jenis=$this->Frmmpemasok->get_nm_jenis($id_gudang)->result();
      foreach($data_jenis as $row3){
        $data['jenis_nm'] = $row3->nm_jenis;
      }
     $data['id_dis'] =  $id;
     $data['header']= $this->Frmmamprah->get_distribusi($id)->row();
     $data['item_distribusi']= $this->Frmmamprah->get_item_distribusi($id)->result();
     $data['no_distribusi']=$data['header']->no_distribusi;
     $data['gd_asal']=$data['header']->nm_gd_asal;
     $data['gd_dituju']=$data['header']->nm_gd_tujuan;
     $data['tgl_distribusi']= date('d-m-Y', strtotime($data['header']->tgl_distribusi));
     $this->load->view('logistik_farmasi/Frmvdetaildistribusi',$data);
     
  }

    function insert_detail_distribusi($id_gudang=''){
      // var_dump($this->input->post());die();
      $obat = $this->input->post('id_obat_new');
      $id_obat = explode("@",$obat)[0];
      $batch_no = explode("@",$obat)[1];
      $data['id_distribusi'] = $this->input->post('id_distribusi');
      $data['id_obat'] = $id_obat;
      $data['batch_no'] = $batch_no;
      $data['expire_date'] = $this->input->post('exp_date');
      $data['qty'] = $this->input->post('jml');
      $data['satuank'] = $this->input->post('satuank');
      $this->Frmmamprah->insert_detail_distribusi($data) ;
      redirect('logistik_farmasi/FrmcDistribusiLangsung/form_detail_distribusi/'.$data['id_distribusi']);
     
    }

    function save(){
        // var_dump($this->input->post());die();
        $id_amprah = $this->Frmmamprah->insertDistribusiLangsung($this->input->post()) ;
        if ( $id_amprah != '' ){
            $msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data permintaan distribusi berhasil disimpan
					  </div>';
        }else{
            $msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data permintaan distribusi gagal disimpan
					  </div>';
        }
        $this->session->set_flashdata('alert_msg', $msg);
        //$this->cetak_faktur_amprah($id_amprah);
        //$this->session->set_flashdata('cetak', 'cetak('.$id_amprah.');');
        redirect('logistik_farmasi/FrmCDistribusiLangsung');
    }
}