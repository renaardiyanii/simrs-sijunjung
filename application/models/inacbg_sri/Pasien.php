
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Pasien extends Secure_area {
  public $xuser;
    public function __construct() {
      parent::__construct();
      $this->load->model('inacbg/M_pasien','',TRUE);    
      $this->load->model('inacbg/M_inacbg','',TRUE); 
      $this->load->model('Mdiagnosa','',TRUE);   
      $this->load->model('Mprocedure','',TRUE);  
      $this->xuser = $this->load->get_var("user_info");    
      $this->load->helper('tgl_indo');         
      $this->load->library('vclaim');
      $this->load->helper('pdf_helper');
      $this->load->library('inacbg');    
    }

  public function index() {        
      $data['title'] = 'Coding / Grouping';
      $data['kelompok_tarif'] = $this->M_inacbg->kelompok_tarif();
      $this->load->view('inacbg/index',$data);        
  }

  public function develop() {        
      $data['title'] = 'Coding / Grouping';
      $this->load->view('inacbg/index_backup',$data);        
  }

  public function get_pelayanan() {
    $line  = array();
    $line2 = array();
    $row2  = array();
    $data_klaim = $this->M_pasien->get_pelayanan();
    $no = 1;
    foreach ($data_klaim as $value) {
      $cbg_code = '<span id="cbg_code_'.$value->no_register.'">-</span>';
      $cbg_status = '<span id="cbg_status_'.$value->no_register.'">-</span>';
      $row2['no_register'] = $value->no_register;
      if ($value->tgl_kunjungan == NULL || $value->tgl_kunjungan == '0000-00-00') {
        $row2['tgl_kunjungan'] = '';
      } else $row2['tgl_kunjungan'] = date_indo(date('Y-m-d',strtotime($value->tgl_kunjungan))); 

      switch (substr($value->no_register, 0,2)) {
        case 'RJ':
          $row2['tgl_pulang'] = date_indo(date('Y-m-d',strtotime($value->tgl_kunjungan))); 
          break;
        case 'RI':
          if ($value->tgl_pulang == NULL || $value->tgl_pulang == '0000-00-00') {
            $row2['tgl_pulang'] = '';
          } else $row2['tgl_pulang'] = date_indo(date('Y-m-d',strtotime($value->tgl_pulang)));  
          break;
      } 

      if (is_null($value->no_sep) || $value->no_sep == '') {
        $row2['no_sep'] = $value->no_sep;
      } else {
        $row2['no_sep'] = $value->no_sep;
        $data = array(
          'metadata'=>array(
            'method' => 'get_claim_data'
          ),            
          'data'=>array(  
            'nomor_sep' => $value->no_sep
          )
        );
        $data_klaim=json_encode($data);
        $response = $this->inacbg->web_service($data_klaim);    
        $claim_data = json_decode($response);
        if ($claim_data->metadata->code == '200') {
          if (!is_null($claim_data->response->data->grouper->response)) {
            $cbg_code = '<span id="cbg_code_'.$value->no_register.'">'.$claim_data->response->data->grouper->response->cbg->code.'</span>';
          }
          $cbg_status = '<span id="cbg_status_'.$value->no_register.'">'.strtoupper($claim_data->response->data->klaim_status_cd).'</span>';
        }
      } 

      if (isset($value->jaminan)) {
        $row2['jaminan'] = $value->jaminan;  
      } else $row2['jaminan'] = ''; 

      switch (substr($value->no_register, 0,2)) {
        case 'RJ':
          $row2['tipe'] = 'RJ';  
          break;
        case 'RI':
          $row2['tipe'] = 'RI';  
          break;
        default:
          $row2['tipe'] = '-'; 
          break;
      }    

      $row2['cbg_code'] = $cbg_code;
      $row2['status_kirim'] = $cbg_status; 
      $row2['no_register'] = $value->no_register;
      $line2[] = $row2;
    }
        
    $line['data'] = $line2;
    echo json_encode($line2);
  }

  public function get_pelayanan_kriteria() {
    $cbg_code = '-';
    $cbg_status = '-';
    $line  = array();
    $line2 = array();
    $row2  = array();
    $data_klaim=$this->M_pasien->get_pelayanan_kriteria();
    $no = 1;
    foreach ($data_klaim as $value) {
      $row2['no'] = $no++;
      $row2['no_register'] = $value->no_register;
      if ($value->tgl_kunjungan == NULL || $value->tgl_kunjungan == '0000-00-00') {
        $row2['tgl_kunjungan'] = '';
      } else $row2['tgl_kunjungan'] = date_indo(date('Y-m-d',strtotime($value->tgl_kunjungan))); 

      if ($value->tgl_pulang == NULL || $value->tgl_pulang == '0000-00-00') {
        $row2['tgl_pulang'] = '';
      } else $row2['tgl_pulang'] = date_indo(date('Y-m-d',strtotime($value->tgl_pulang))); 

      if (is_null($value->no_sep) || $value->no_sep == '') {
        $row2['no_sep'] = '';
      } else {
        $row2['no_sep'] = $value->no_sep;
        $data = array(
          'metadata'=>array(
            'method' => 'get_claim_data'
          ),            
          'data'=>array(  
            'nomor_sep' => $value->no_sep
          )
        );
        $data_klaim=json_encode($data);
        $response = $this->inacbg->web_service($data_klaim);    
        $claim_data = json_decode($response);
        if ($claim_data->metadata->code == '200') {
          if (!is_null($claim_data->response->data->grouper->response)) {
            $cbg_code = $claim_data->response->data->grouper->response->cbg->code;
          }
          $cbg_status = $claim_data->response->data->klaim_status_cd;
        }
      } 

      if (isset($value->jaminan)) {
        $row2['jaminan'] = $value->jaminan;  
      } else $row2['jaminan'] = ''; 

      switch (substr($value->no_register, 0,2)) {
        case 'RJ':
          $row2['tipe'] = 'RJ';  
          break;
        case 'RI':
          $row2['tipe'] = 'RI';  
          break;
        default:
          $row2['tipe'] = '-'; 
          break;
      }    

      $row2['cbg_code'] = $cbg_code;

      $row2['status_kirim'] = $cbg_status; 
      $line2[] = $row2;
    }
        
    $line['data'] = $line2;
    echo json_encode($line);
  }

  public function pelayanan($no_register='') {
    $data['title'] = 'Coding / Grouping';
    $data['coder_nik'] = $this->xuser->nik;
    $data['no_register'] = $no_register;   
    $data['kelompok_tarif'] = $this->M_inacbg->kelompok_tarif(); 
    if ($no_register == '') {
      redirect('inacbg/index');
    } else {
      if (substr($no_register, 0,2) == 'RJ') {
        $data['data_pasien'] = $this->M_pasien->show_pelayanan_irj($no_register);               
        if ($data['data_pasien']) {
          if ($data['data_pasien']->id_dokter == '') {
            $data['nm_dokter'] = '';
          } else {
            $get_dokter = $this->M_pasien->get_dokter($data['data_pasien']->id_dokter);
            if (count($get_dokter)) {
              $data['nm_dokter'] = $get_dokter->nm_dokter;
            } else {
              $data['nm_dokter'] = '';
            }         
          }
        }   
      } else if (substr($no_register, 0,2) == 'RI') {
        $data['data_pasien'] = $this->M_pasien->show_pelayanan_iri($no_register); 
        if ($data['data_pasien']) {
            $get_dokter = $this->M_pasien->get_dokter($data['data_pasien']->id_dokter);
            if (count($get_dokter)) {
              $data['nm_dokter'] = $get_dokter->nm_dokter;
            } else {
              $data['nm_dokter'] = '';
            }         
        }   
      }
      if ($data['data_pasien']) {
        $tgl_pelayanan = date('Y-m-d');
        $param = 'Peserta/nokartu/'.$data['data_pasien']->no_kartu.'/'.'tglSEP/'.$tgl_pelayanan;
        $content_type = 'application/json';
        $data['data_bpjs'] = json_decode($this->vclaim->get($param,$content_type));
        $data['data_sep'] = json_decode($this->vclaim->get('SEP/'.$data['data_pasien']->no_sep,'Application/x-www-form-urlencoded'));  
        $this->load->view('inacbg/form_klaim',$data); 
      } else {
        $notification = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Data tidak ditemukan.</h4>
                Data Pasien dengan No. Registrasi '.$no_register.' Tidak Ditemukan.
              </div>';
        $this->session->set_flashdata('notification', $notification);     
        redirect('inacbg/pasien');  
      }
    }   
  }

  function get_autocomplete(){    
      if (isset($_GET['term'])){
        $q = strtolower($_GET['term']);
        $category = $_GET['category'];
        $this->M_pasien->get_autocomplete($category,$q);
      }
  }

  public function tarif_rs($no_register='')
  {                                         
      $result = $this->M_pasien->get_tarif_rs($no_register);
      if($result == null){
        if(substr($no_register, 0,2)=="RJ"){
          echo $this->get_tarif_rj($no_register);
        }else if(substr($no_register, 0,2)=="RI"){
          echo $this->get_tarif_ri($no_register);
        }else{
          echo json_encode($result);
        }
      } else {
        echo json_encode($result);
      }
  } 

  public function get_tarif_rj($no_register=''){                      
      $result['tarif_tenaga_ahli'] = 0; //1
      $result['tarif_bmhp']=0; //2
      $result['tarif_rawat_intensif']=0; //3
      $result['tarif_pelayanan_darah']=0; //4
      $result['tarif_penunjang']=0; //5
      $result['tarif_konsultasi']=0; //6
      $result['tarif_alkes']=0; //7
      $result['tarif_kamar']=0; //8
      $result['tarif_laboratorium']=0; //9
      $result['tarif_radiologi']=0; //10
      $result['tarif_keperawatan']=0; //11
      $result['tarif_prosedur_bedah']=0; //12
      $result['tarif_prosedur_non_bedah']=0; //13
      $result['tarif_sewa_alat']=0; //14
      $result['tarif_obat']=0; //15
      $result['tarif_rehabilitasi']=0; //16else if($row1->idkel_inacbg == 17){
      $result['tarif_obat_kronis']=0; //17
      $result['tarif_obat_kemoterapi']=0; //18

      $data_tindakan=$this->M_pasien->getdata_tindakan_pasien_rj($no_register)->result();            
      foreach ($data_tindakan as $row) {
        if($row->idkel_inacbg == 1){
          $result['tarif_tenaga_ahli']+=$row->vtot; //1
        } else if($row->idkel_inacbg == 2){
          $result['tarif_bmhp']+=$row->vtot; //2
        } else if($row->idkel_inacbg == 3){
          $result['tarif_rawat_intensif']+=$row->vtot;
        } else if($row->idkel_inacbg == 4){
          $result['tarif_pelayanan_darah']+=$row->vtot;
        } else if($row->idkel_inacbg == 5){
          $result['tarif_penunjang']+=$row->vtot;
        } else if($row->idkel_inacbg == 6){
          $result['tarif_konsultasi']+=$row->vtot; //6
        } else if($row->idkel_inacbg == 7){
          $result['tarif_alkes']+=$row->vtot; //7
        } else if($row->idkel_inacbg == 8){
          $result['tarif_kamar']+=$row->vtot; //8
        } else if($row->idkel_inacbg == 9){
          $result['tarif_laboratorium']+=$row->vtot; //9
        } else if($row->idkel_inacbg == 10){
          $result['tarif_radiologi']+=$row->vtot; //10
        } else if($row->idkel_inacbg == 11){
          $result['tarif_keperawatan']+=$row->vtot; //11
        } else if($row->idkel_inacbg == 12){
          $result['tarif_prosedur_bedah']+=$row->vtot; //12
        } else if($row->idkel_inacbg == 13){
          $result['tarif_prosedur_non_bedah']+=$row->vtot; //13
        } else if($row->idkel_inacbg == 14){
          $result['tarif_sewa_alat']+=$row->vtot; //14
        } else if($row->idkel_inacbg == 15){
          $result['tarif_obat']+=$row->vtot; //15
        } else if($row->idkel_inacbg == 16){
          $result['tarif_rehabilitasi']+=$row->vtot; //16
        } else if($row1->idkel_inacbg == 17){
          $result['tarif_obat_kronis']+=$row->vtot; //17
        } else if($row1->idkel_inacbg == 18){
          $result['tarif_obat_kemoterapi']+=$row->vtot; //18
        } else {

        }
      }  
      $data_laboratorium=$this->M_pasien->getdata_lab_pasien($no_register)->result();           
      foreach ($data_laboratorium as $row1) {
        if($row1->idkel_inacbg == 1){
          $result['tarif_tenaga_ahli']+=$row1->vtot; //1
        } else if($row1->idkel_inacbg == 2){
          $result['tarif_bmhp']+=$row1->vtot; //2
        } else if($row1->idkel_inacbg == 3){
          $result['tarif_rawat_intensif']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 4){
          $result['tarif_pelayanan_darah']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 5){
          $result['tarif_penunjang']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 6){
          $result['tarif_konsultasi']+=$row1->vtot; //6
        } else if($row1->idkel_inacbg == 7){
          $result['tarif_alkes']+=$row1->vtot; //7
        } else if($row1->idkel_inacbg == 8){
          $result['tarif_kamar']+=$row1->vtot; //8
        } else if($row1->idkel_inacbg == 9){
          $result['tarif_laboratorium']+=$row1->vtot; //9
        } else if($row1->idkel_inacbg == 10){
          $result['tarif_radiologi']+=$row1->vtot; //10
        } else if($row1->idkel_inacbg == 11){
          $result['tarif_keperawatan']+=$row1->vtot; //11
        } else if($row1->idkel_inacbg == 12){
          $result['tarif_prosedur_bedah']+=$row1->vtot; //12
        } else if($row1->idkel_inacbg == 13){
          $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
        } else if($row1->idkel_inacbg == 14){
          $result['tarif_sewa_alat']+=$row1->vtot; //14
        } else if($row1->idkel_inacbg == 15){
          $result['tarif_obat']+=$row1->vtot; //15
        } else if($row1->idkel_inacbg == 16){
          $result['tarif_rehabilitasi']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 17){
          $result['tarif_obat_kronis']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 18){
          $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
        } else {

        }
      } 
      $data_pa=$this->M_pasien->getdata_pa_pasien($no_register)->result();           
      foreach ($data_pa as $row1) {
        if($row1->idkel_inacbg == 1){
          $result['tarif_tenaga_ahli']+=$row1->vtot; //1
        } else if($row1->idkel_inacbg == 2){
          $result['tarif_bmhp']+=$row1->vtot; //2
        } else if($row1->idkel_inacbg == 3){
          $result['tarif_rawat_intensif']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 4){
          $result['tarif_pelayanan_darah']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 5){
          $result['tarif_penunjang']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 6){
          $result['tarif_konsultasi']+=$row1->vtot; //6
        } else if($row1->idkel_inacbg == 7){
          $result['tarif_alkes']+=$row1->vtot; //7
        } else if($row1->idkel_inacbg == 8){
          $result['tarif_kamar']+=$row1->vtot; //8
        } else if($row1->idkel_inacbg == 9){
          $result['tarif_laboratorium']+=$row1->vtot; //9
        } else if($row1->idkel_inacbg == 10){
          $result['tarif_radiologi']+=$row1->vtot; //10
        } else if($row1->idkel_inacbg == 11){
          $result['tarif_keperawatan']+=$row1->vtot; //11
        } else if($row1->idkel_inacbg == 12){
          $result['tarif_prosedur_bedah']+=$row1->vtot; //12
        } else if($row1->idkel_inacbg == 13){
          $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
        } else if($row1->idkel_inacbg == 14){
          $result['tarif_sewa_alat']+=$row1->vtot; //14
        } else if($row1->idkel_inacbg == 15){
          $result['tarif_obat']+=$row1->vtot; //15
        } else if($row1->idkel_inacbg == 16){
          $result['tarif_rehabilitasi']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 17){
          $result['tarif_obat_kronis']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 18){
          $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
        } else {

        }
      } 
      $data_radiologi=$this->M_pasien->getdata_rad_pasien($no_register)->result();          
      foreach ($data_radiologi as $row1) {
        if($row1->idkel_inacbg == 1){
          $result['tarif_tenaga_ahli']+=$row1->vtot; //1
        } else if($row1->idkel_inacbg == 2){
          $result['tarif_bmhp']+=$row1->vtot; //2
        } else if($row1->idkel_inacbg == 3){
          $result['tarif_rawat_intensif']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 4){
          $result['tarif_pelayanan_darah']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 5){
          $result['tarif_penunjang']+=$row1->vtot;
        } else if($row1->idkel_inacbg == 6){
          $result['tarif_konsultasi']+=$row1->vtot; //6
        } else if($row1->idkel_inacbg == 7){
          $result['tarif_alkes']+=$row1->vtot; //7
        } else if($row1->idkel_inacbg == 8){
          $result['tarif_kamar']+=$row1->vtot; //8
        } else if($row1->idkel_inacbg == 9){
          $result['tarif_laboratorium']+=$row1->vtot; //9
        } else if($row1->idkel_inacbg == 10){
          $result['tarif_radiologi']+=$row1->vtot; //10
        } else if($row1->idkel_inacbg == 11){
          $result['tarif_keperawatan']+=$row1->vtot; //11
        } else if($row1->idkel_inacbg == 12){
          $result['tarif_prosedur_bedah']+=$row1->vtot; //12
        } else if($row1->idkel_inacbg == 13){
          $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
        } else if($row1->idkel_inacbg == 14){
          $result['tarif_sewa_alat']+=$row1->vtot; //14
        } else if($row1->idkel_inacbg == 15){
          $result['tarif_obat']+=$row1->vtot; //15
        } else if($row1->idkel_inacbg == 16){
          $result['tarif_rehabilitasi']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 17){
          $result['tarif_obat_kronis']+=$row1->vtot; //16
        } else if($row1->idkel_inacbg == 18){
          $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
        } else {

        }
      } 
      $data_resep=$this->M_pasien->getdata_resep_pasien($no_register)->result();         
      foreach ($data_resep as $row1) {
        $result['tarif_obat']+=$row1->vtot; //15
      } 
      // $data_ok=$this->M_pasien->getdata_ok_pasien($no_register)->result();           
      // foreach ($data_ok as $row1) {
      //   if($row1->idkel_inacbg == 1){
      //     $result['tarif_tenaga_ahli']+=$row1->vtot; //1
      //   } else if($row1->idkel_inacbg == 2){
      //     $result['tarif_bmhp']+=$row1->vtot; //2
      //   } else if($row1->idkel_inacbg == 3){
      //     $result['tarif_rawat_intensif']+=$row1->vtot;
      //   } else if($row1->idkel_inacbg == 4){
      //     $result['tarif_pelayanan_darah']+=$row1->vtot;
      //   } else if($row1->idkel_inacbg == 5){
      //     $result['tarif_penunjang']+=$row1->vtot;
      //   } else if($row1->idkel_inacbg == 6){
      //     $result['tarif_konsultasi']+=$row1->vtot; //6
      //   } else if($row1->idkel_inacbg == 7){
      //     $result['tarif_alkes']+=$row1->vtot; //7
      //   } else if($row1->idkel_inacbg == 8){
      //     $result['tarif_kamar']+=$row1->vtot; //8
      //   } else if($row1->idkel_inacbg == 9){
      //     $result['tarif_laboratorium']+=$row1->vtot; //9
      //   } else if($row1->idkel_inacbg == 10){
      //     $result['tarif_radiologi']+=$row1->vtot; //10
      //   } else if($row1->idkel_inacbg == 11){
      //     $result['tarif_keperawatan']+=$row1->vtot; //11
      //   } else if($row1->idkel_inacbg == 12){
      //     $result['tarif_prosedur_bedah']+=$row1->vtot; //12
      //   } else if($row1->idkel_inacbg == 13){
      //     $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
      //   } else if($row1->idkel_inacbg == 14){
      //     $result['tarif_sewa_alat']+=$row1->vtot; //14
      //   } else if($row1->idkel_inacbg == 15){
      //     $result['tarif_obat']+=$row1->vtot; //15
      //   } else if($row1->idkel_inacbg == 16){
      //     $result['tarif_rehabilitasi']+=$row1->vtot; //16
      //   } else if($row1->idkel_inacbg == 17){
      //     $result['tarif_obat_kronis']+=$row1->vtot; //16
      //   } else if($row1->idkel_inacbg == 18){
      //     $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
      //   } else {

      //   }
      // } 

      $data['no_register'] = $no_register;
      $data['tarif_tenaga_ahli'] = $result['tarif_tenaga_ahli']; //1
      $data['tarif_bmhp'] = $result['tarif_bmhp']; //2
      $data['tarif_rawat_intensif'] = $result['tarif_rawat_intensif'];
      $data['tarif_pelayanan_darah'] = $result['tarif_pelayanan_darah'];
      $data['tarif_penunjang'] = $result['tarif_penunjang'];
      $data['tarif_konsultasi'] = $result['tarif_konsultasi']; //6
      $data['tarif_alkes'] = $result['tarif_alkes']; //7
      $data['tarif_kamar'] = $result['tarif_kamar']; //8
      $data['tarif_laboratorium'] = $result['tarif_laboratorium']; //9
      $data['tarif_radiologi'] = $result['tarif_radiologi']; //10
      $data['tarif_keperawatan'] = $result['tarif_keperawatan']; //11
      $data['tarif_prosedur_bedah'] = $result['tarif_prosedur_bedah']; //12
      $data['tarif_prosedur_non_bedah'] = $result['tarif_prosedur_non_bedah']; //13
      $data['tarif_sewa_alat'] = $result['tarif_sewa_alat']; //14
      $data['tarif_obat'] = $result['tarif_obat']; //15
      $data['tarif_rehabilitasi'] = $result['tarif_rehabilitasi']; //16
      $data['tarif_obat_kronis'] = $result['tarif_obat_kronis']; //16
      $data['tarif_obat_kemoterapi'] = $result['tarif_obat_kemoterapi']; //16

      $this->M_pasien->insert_inacbg_tarif_rs($data);  

      echo json_encode($result);
  } 

  public function get_tarif_ri($no_register=''){                      
      $result['tarif_tenaga_ahli'] = 0; //1
      $result['tarif_bmhp']=0; //2
      $result['tarif_rawat_intensif']=0; //3
      $result['tarif_pelayanan_darah']=0; //4
      $result['tarif_penunjang']=0; //5
      $result['tarif_konsultasi']=0; //6
      $result['tarif_alkes']=0; //7
      $result['tarif_kamar']=0; //8
      $result['tarif_laboratorium']=0; //9
      $result['tarif_radiologi']=0; //10
      $result['tarif_keperawatan']=0; //11
      $result['tarif_prosedur_bedah']=0; //12
      $result['tarif_prosedur_non_bedah']=0; //13
      $result['tarif_sewa_alat']=0; //14
      $result['tarif_obat']=0; //15
      $result['tarif_rehabilitasi']=0; //16else if($row1->idkel_inacbg == 17){
      $result['tarif_obat_kronis']=0; //17
      $result['tarif_obat_kemoterapi']=0; //18
      $noregasal=$this->M_pasien->get_noregasal($no_register)->row()->noregasal;  

      // $list_tindakan_pasien = $this->rimtindakan->get_list_sumtindakan_pasien_by_no_ipd($no_ipd); 
        $data_tindakan=$this->M_pasien->getdata_tindakan_pasien_ri($no_register)->result();            
        foreach ($data_tindakan as $row) {
          if($row->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row->vtot; //1
          } else if($row->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row->vtot; //2
          } else if($row->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row->vtot;
          } else if($row->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row->vtot;
          } else if($row->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row->vtot;
          } else if($row->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row->vtot; //6
          } else if($row->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row->vtot; //7
          } else if($row->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row->vtot; //8
          } else if($row->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row->vtot; //9
          } else if($row->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row->vtot; //10
          } else if($row->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row->vtot; //11
          } else if($row->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row->vtot; //12
          } else if($row->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row->vtot; //13
          } else if($row->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row->vtot; //14
          } else if($row->idkel_inacbg == 15){
            $result['tarif_obat']+=$row->vtot; //15
          } else if($row->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row->vtot; //17
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row->vtot; //18
          } else {

          }
        }  
        // $list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); 
        $data_ruangan=$this->M_pasien->getdata_ruangan_pasien_ri($no_register)->result();  
        // print_r($data_ruangan);die();   
        foreach ($data_ruangan as $row) {
            $result['tarif_kamar'] += $row->vtot;
        }
        // $list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
        // $list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_ok=$this->M_pasien->getdata_ok_pasien($no_register)->result();   
             
        foreach ($data_ok as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        }   
        // $list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_pa=$this->M_pasien->getdata_pa_pasien($no_register)->result();           
        foreach ($data_pa as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        $data_pa_asal=$this->M_pasien->getdata_pa_pasien($noregasal)->result();           
        foreach ($data_pa_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        // $list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_laboratorium=$this->M_pasien->getdata_lab_pasien($no_register)->result();           
        foreach ($data_laboratorium as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        $data_laboratorium_asal=$this->M_pasien->getdata_lab_pasien($noregasal)->result();           
        foreach ($data_laboratorium_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        // $list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_radiologi=$this->M_pasien->getdata_rad_pasien($no_register)->result();          
        foreach ($data_radiologi as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        $data_radiologi_asal=$this->M_pasien->getdata_rad_pasien($noregasal)->result();          
        foreach ($data_radiologi_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row1->vtot; //1
          } else if($row1->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row1->vtot; //2
          } else if($row1->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row1->vtot; //6
          } else if($row1->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row1->vtot; //7
          } else if($row1->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row1->vtot; //8
          } else if($row1->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row1->vtot; //9
          } else if($row1->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row1->vtot; //10
          } else if($row1->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row1->vtot; //11
          } else if($row1->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row1->vtot; //12
          } else if($row1->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row1->vtot; //13
          } else if($row1->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row1->vtot; //14
          } else if($row1->idkel_inacbg == 15){
            $result['tarif_obat']+=$row1->vtot; //15
          } else if($row1->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row1->vtot; //16
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row1->vtot; //16
          } else {

          }
        } 
        // $list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_resep=$this->M_pasien->getdata_resep_pasien($no_register)->result();         
        foreach ($data_resep as $row1) {
          $result['tarif_obat'] += $row1->vtot;
        } 
        $data_resep_asal=$this->M_pasien->getdata_resep_pasien($noregasal)->result();         
        foreach ($data_resep_asal as $row1) {
          $result['tarif_obat'] += $row1->vtot;
        } 
        // $poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
        $data_tindakan_asal=$this->M_pasien->getdata_tindakan_pasien_rj($noregasal)->result();            
        foreach ($data_tindakan_asal as $row) {
          if($row->idkel_inacbg == 1){
            $result['tarif_tenaga_ahli']+=$row->vtot; //1
          } else if($row->idkel_inacbg == 2){
            $result['tarif_bmhp']+=$row->vtot; //2
          } else if($row->idkel_inacbg == 3){
            $result['tarif_rawat_intensif']+=$row->vtot;
          } else if($row->idkel_inacbg == 4){
            $result['tarif_pelayanan_darah']+=$row->vtot;
          } else if($row->idkel_inacbg == 5){
            $result['tarif_penunjang']+=$row->vtot;
          } else if($row->idkel_inacbg == 6){
            $result['tarif_konsultasi']+=$row->vtot; //6
          } else if($row->idkel_inacbg == 7){
            $result['tarif_alkes']+=$row->vtot; //7
          } else if($row->idkel_inacbg == 8){
            $result['tarif_kamar']+=$row->vtot; //8
          } else if($row->idkel_inacbg == 9){
            $result['tarif_laboratorium']+=$row->vtot; //9
          } else if($row->idkel_inacbg == 10){
            $result['tarif_radiologi']+=$row->vtot; //10
          } else if($row->idkel_inacbg == 11){
            $result['tarif_keperawatan']+=$row->vtot; //11
          } else if($row->idkel_inacbg == 12){
            $result['tarif_prosedur_bedah']+=$row->vtot; //12
          } else if($row->idkel_inacbg == 13){
            $result['tarif_prosedur_non_bedah']+=$row->vtot; //13
          } else if($row->idkel_inacbg == 14){
            $result['tarif_sewa_alat']+=$row->vtot; //14
          } else if($row->idkel_inacbg == 15){
            $result['tarif_obat']+=$row->vtot; //15
          } else if($row->idkel_inacbg == 16){
            $result['tarif_rehabilitasi']+=$row->vtot; //16
          } else if($row1->idkel_inacbg == 17){
            $result['tarif_obat_kronis']+=$row->vtot; //17
          } else if($row1->idkel_inacbg == 18){
            $result['tarif_obat_kemoterapi']+=$row->vtot; //18
          } else {

          }
        }  

      $data['no_register'] = $no_register;
      $data['tarif_tenaga_ahli'] = $result['tarif_tenaga_ahli']; //1
      $data['tarif_bmhp'] = $result['tarif_bmhp']; //2
      $data['tarif_rawat_intensif'] = $result['tarif_rawat_intensif'];
      $data['tarif_pelayanan_darah'] = $result['tarif_pelayanan_darah'];
      $data['tarif_penunjang'] = $result['tarif_penunjang'];
      $data['tarif_konsultasi'] = $result['tarif_konsultasi']; //6
      $data['tarif_alkes'] = $result['tarif_alkes']; //7
      $data['tarif_kamar'] = $result['tarif_kamar']; //8
      $data['tarif_laboratorium'] = $result['tarif_laboratorium']; //9
      $data['tarif_radiologi'] = $result['tarif_radiologi']; //10
      $data['tarif_keperawatan'] = $result['tarif_keperawatan']; //11
      $data['tarif_prosedur_bedah'] = $result['tarif_prosedur_bedah']; //12
      $data['tarif_prosedur_non_bedah'] = $result['tarif_prosedur_non_bedah']; //13
      $data['tarif_sewa_alat'] = $result['tarif_sewa_alat']; //14
      $data['tarif_obat'] = $result['tarif_obat']; //15
      $data['tarif_rehabilitasi'] = $result['tarif_rehabilitasi']; //16
      $data['tarif_obat_kronis'] = $result['tarif_obat_kronis']; //16
      $data['tarif_obat_kemoterapi'] = $result['tarif_obat_kemoterapi']; //16

      $this->M_pasien->insert_inacbg_tarif_rs($data);  

      echo json_encode($result);
  } 

  public function save_tarif_rs()
  { 
      $no_register = $this->input->post('no_register');
      $data_update = array(               
        'tarif_prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
        'tarif_prosedur_bedah' => $this->input->post('prosedur_bedah'), 
        'tarif_konsultasi' => $this->input->post('konsultasi'), 
        'tarif_tenaga_ahli' => $this->input->post('tenaga_ahli'), 
        'tarif_keperawatan' => $this->input->post('keperawatan'), 
        'tarif_penunjang' => $this->input->post('penunjang'), 
        'tarif_radiologi' => $this->input->post('radiologi'), 
        'tarif_laboratorium' => $this->input->post('laboratorium'), 
        'tarif_pelayanan_darah' => $this->input->post('pelayanan_darah'), 
        'tarif_rehabilitasi' => $this->input->post('rehabilitasi'), 
        'tarif_kamar' => $this->input->post('kamar'), 
        'tarif_rawat_intensif' => $this->input->post('rawat_intensif'), 
        'tarif_obat' => $this->input->post('obat'), 
        'tarif_alkes' => $this->input->post('alkes'), 
        'tarif_bmhp' => $this->input->post('bmhp'), 
        'tarif_sewa_alat' => $this->input->post('sewa_alat')
      );
      $result = $this->M_pasien->update_tarif_rs($no_register,$data_update);
      echo json_encode($result);
  }    

  public function billing($no_register='')
  {
    $get_diagnosa = $this->Mdiagnosa->pelayanan($no_register); 
    $get_procedure = $this->Mprocedure->pelayanan($no_register);  
    $login_data = $this->load->get_var("user_info");
    $user = strtoupper($login_data->username);
    if($no_register != '') {
      date_default_timezone_set("Asia/Bangkok");
      $tgl_jam = date("d-m-Y H:i:s");
      $tgl = date("d-m-Y");
      $namars=$this->config->item('namars');
      $kota_kab=$this->config->item('kota');
      $alamatrs=$this->config->item('alamat');
      $telp=$this->config->item('telp');
      $nmsingkat=$this->config->item('namasingkat');
      $data_pasien=$this->M_pasien->get_pasien_billing($no_register);
      // print_r($data_pasien);die();

      if ($data_pasien->tgl_lahir == NULL || $data_pasien->tgl_lahir == '0000-00-00 00:00:00') { 
        $tgl_lahir = "-";
      } else {
        $tgl_lahir = date('Y-m-d',strtotime($data_pasien->tgl_lahir));
      }
      if($data_pasien->sex=='L'){
        $jk = "LAKI-LAKI";
      } else {
        $jk = "PEREMPUAN";
      }

      if($data_pasien->cara_bayar ==' BPJS'){
        $cara_bayar=$data_pasien->cara_bayar;
      } else {
        $cara_bayar='DIJAMIN / JAMSOSKES';
      }

      $konten="<style type=\"text/css\">
          .table-font-size{
            font-size:12px;
              }
          .table-font-size2{
            font-size:8px;
            margin : 1px 1px 1px 1px;
            padding : 1px 1px 1px 1px;
              }
          .table-font-size2 th{
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
              }
          .table-font-size2 td{
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
              }
          .telaah-resep {
            font-size:5px;
          }
          </style>
          
          <table class=\"table-font-size1\" border=\"0\">
            <tr>
              <td width=\"16%\">
                <span align=\"center\">
                  <img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
                </span>
              </td>
              <td align=\"center\" width=\"70%\" style=\"\"><b><font style=\"font-size:13px\">$namars</font></b><br><br><font style=\"font-size:8px\">$alamatrs $kota_kab $telp</font><br>
              </td>
              <td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>           
            </tr>
          </table>";

      $tenaga_ahli = array();
      $bmhp = array();
      $rawat_intensif = array();
      $pelayanan_darah = array();
      $penunjang = array();
      $konsultasi = array();
      $alkes = array();
      $kamar_akomodasi = array();
      $laboratorium = array();
      $radiologi = array();
      $keperawatan = array();
      $prosedur_bedah = array();
      $prosedur_non_bedah = array();
      $sewa_alat = array();
      $obat = array();
      $rehabilitasi = array();  

      $total_tenaga_ahli = 0;
      $total_bmhp = 0;
      $total_rawat_intensif = 0;
      $total_pelayanan_darah = 0;
      $total_penunjang = 0;
      $total_konsultasi = 0;
      $total_alkes = 0;
      $total_kamar_akomodasi = 0;
      $total_laboratorium = 0;
      $total_radiologi = 0;
      $total_keperawatan = 0;
      $total_prosedur_bedah = 0;
      $total_prosedur_non_bedah = 0;
      $total_sewa_alat = 0;
      $total_obat = 0;
      $total_rehabilitasi = 0;

      if (substr($no_register, 0,2) == 'RJ') {  
        $jenis_rawat = 'JALAN';
        $data_tindakan=$this->M_pasien->getdata_tindakan_pasien_rj($no_register)->result();    
        // print_r($data_tindakan);die();        
        foreach ($data_tindakan as $row) {
          if($row->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row);
            $total_tenaga_ahli += $row->vtot;
          } else if($row->idkel_inacbg == 2){
            array_push($bmhp, $row);
            $total_bmhp += $row->vtot;
          } else if($row->idkel_inacbg == 3){
            array_push($rawat_intensif, $row);
            $total_rawat_intensif += $row->vtot;
          } else if($row->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row);
            $total_pelayanan_darah += $row->vtot;
          } else if($row->idkel_inacbg == 5){
            array_push($penunjang, $row);
            $total_penunjang += $row->vtot;
          } else if($row->idkel_inacbg == 6){
            array_push($konsultasi, $row);
            $total_konsultasi += $row->vtot;
          } else if($row->idkel_inacbg == 7){
            array_push($alkes, $row);
            $total_alkes += $row->vtot;
          } else if($row->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row);
            $total_kamar_akomodasi += $row->vtot;
          } else if($row->idkel_inacbg == 9){
            array_push($laboratorium, $row);
            $total_laboratorium += $row->vtot;
          } else if($row->idkel_inacbg == 10){
            array_push($radiologi, $row);
            $total_radiologi += $row->vtot;
          } else if($row->idkel_inacbg == 11){
            array_push($keperawatan, $row);
            $total_keperawatan += $row->vtot;
          } else if($row->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row);
            $total_prosedur_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row);
            $total_prosedur_non_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 14){
            array_push($sewa_alat, $row);
            $total_sewa_alat += $row->vtot;
          } else if($row->idkel_inacbg == 15){
            array_push($obat, $row);
            $total_obat += $row->vtot;
          } else if($row->idkel_inacbg == 16){
            array_push($rehabilitasi, $row);
            $total_rehabilitasi += $row->vtot;
          } else {

          }
        }  
        $data_laboratorium=$this->M_pasien->getdata_lab_pasien_rj($no_register)->result();           
        foreach ($data_laboratorium as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        $data_radiologi=$this->M_pasien->getdata_rad_pasien_rj($no_register)->result();    

        foreach ($data_radiologi as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        $data_resep=$this->M_pasien->getdata_resep_pasien($no_register)->result();         
        foreach ($data_resep as $row1) {
          array_push($obat, $row1);
          $total_obat += $row1->vtot;
        } 
        $data_ok=$this->M_pasien->getdata_ok_pasien_rj($no_register)->result();           
        foreach ($data_ok as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
      } 

      if (substr($no_register, 0,2) == 'RI') {  
        $jenis_rawat = 'INAP';
        $noregasal=$this->M_pasien->get_noregasal($no_register)->row()->noregasal;  

        // $list_tindakan_pasien = $this->rimtindakan->get_list_sumtindakan_pasien_by_no_ipd($no_ipd); 
        $data_tindakan=$this->M_pasien->getdata_tindakan_pasien_ri($no_register)->result();            
        foreach ($data_tindakan as $row) {
          if($row->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row);
            $total_tenaga_ahli += $row->vtot;
          } else if($row->idkel_inacbg == 2){
            array_push($bmhp, $row);
            $total_bmhp += $row->vtot;
          } else if($row->idkel_inacbg == 3){
            array_push($rawat_intensif, $row);
            $total_rawat_intensif += $row->vtot;
          } else if($row->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row);
            $total_pelayanan_darah += $row->vtot;
          } else if($row->idkel_inacbg == 5){
            array_push($penunjang, $row);
            $total_penunjang += $row->vtot;
          } else if($row->idkel_inacbg == 6){
            array_push($konsultasi, $row);
            $total_konsultasi += $row->vtot;
          } else if($row->idkel_inacbg == 7){
            array_push($alkes, $row);
            $total_alkes += $row->vtot;
          } else if($row->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row);
            $total_kamar_akomodasi += $row->vtot;
          } else if($row->idkel_inacbg == 9){
            array_push($laboratorium, $row);
            $total_laboratorium += $row->vtot;
          } else if($row->idkel_inacbg == 10){
            array_push($radiologi, $row);
            $total_radiologi += $row->vtot;
          } else if($row->idkel_inacbg == 11){
            array_push($keperawatan, $row);
            $total_keperawatan += $row->vtot;
          } else if($row->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row);
            $total_prosedur_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row);
            $total_prosedur_non_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 14){
            array_push($sewa_alat, $row);
            $total_sewa_alat += $row->vtot;
          } else if($row->idkel_inacbg == 15){
            array_push($obat, $row);
            $total_obat += $row->vtot;
          } else if($row->idkel_inacbg == 16){
            array_push($rehabilitasi, $row);
            $total_rehabilitasi += $row->vtot;
          } else {

          }
        }  
        // $list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd); 
        $data_ruangan=$this->M_pasien->getdata_ruangan_pasien_ri($no_register)->result();  
        // print_r($data_ruangan);die();   
        foreach ($data_ruangan as $row) {
            array_push($kamar_akomodasi, $row);
            $total_kamar_akomodasi += $row->vtot;
        }
        // $list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
        // $list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_ok=$this->M_pasien->getdata_ok_pasien($no_register)->result();   
             
        foreach ($data_ok as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        }   
        // $list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_pa=$this->M_pasien->getdata_pa_pasien($no_register)->result();           
        foreach ($data_pa as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        $data_pa_asal=$this->M_pasien->getdata_pa_pasien($noregasal)->result();           
        foreach ($data_pa_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        // $list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_laboratorium=$this->M_pasien->getdata_lab_pasien($no_register)->result();           
        foreach ($data_laboratorium as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        $data_laboratorium_asal=$this->M_pasien->getdata_lab_pasien($noregasal)->result();           
        foreach ($data_laboratorium_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        // $list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_radiologi=$this->M_pasien->getdata_rad_pasien($no_register)->result();          
        foreach ($data_radiologi as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        $data_radiologi_asal=$this->M_pasien->getdata_rad_pasien($noregasal)->result();          
        foreach ($data_radiologi_asal as $row1) {
          if($row1->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row1);
            $total_tenaga_ahli += $row1->vtot;
          } else if($row1->idkel_inacbg == 2){
            array_push($bmhp, $row1);
            $total_bmhp += $row1->vtot;
          } else if($row1->idkel_inacbg == 3){
            array_push($rawat_intensif, $row1);
            $total_rawat_intensif += $row1->vtot;
          } else if($row1->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row1);
            $total_pelayanan_darah += $row1->vtot;
          } else if($row1->idkel_inacbg == 5){
            array_push($penunjang, $row1);
            $total_penunjang += $row1->vtot;
          } else if($row1->idkel_inacbg == 6){
            array_push($konsultasi, $row1);
            $total_konsultasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 7){
            array_push($alkes, $row1);
            $total_alkes += $row1->vtot;
          } else if($row1->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row1);
            $total_kamar_akomodasi += $row1->vtot;
          } else if($row1->idkel_inacbg == 9){
            array_push($laboratorium, $row1);
            $total_laboratorium += $row1->vtot;
          } else if($row1->idkel_inacbg == 10){
            array_push($radiologi, $row1);
            $total_radiologi += $row1->vtot;
          } else if($row1->idkel_inacbg == 11){
            array_push($keperawatan, $row1);
            $total_keperawatan += $row1->vtot;
          } else if($row1->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row1);
            $total_prosedur_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row1);
            $total_prosedur_non_bedah += $row1->vtot;
          } else if($row1->idkel_inacbg == 14){
            array_push($sewa_alat, $row1);
            $total_sewa_alat += $row1->vtot;
          } else if($row1->idkel_inacbg == 15){
            array_push($obat, $row1);
            $total_obat += $row1->vtot;
          } else if($row1->idkel_inacbg == 16){
            array_push($rehabilitasi, $row1);
            $total_rehabilitasi += $row1->vtot;
          } else {

          }
        } 
        // $list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
        $data_resep=$this->M_pasien->getdata_resep_pasien($no_register)->result();         
        foreach ($data_resep as $row1) {
          array_push($obat, $row1);
          $total_obat += $row1->vtot;
        } 
        $data_resep_asal=$this->M_pasien->getdata_resep_pasien($noregasal)->result();         
        foreach ($data_resep_asal as $row1) {
          array_push($obat, $row1);
          $total_obat += $row1->vtot;
        } 
        // $poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
        $data_tindakan_asal=$this->M_pasien->getdata_tindakan_pasien_rj($noregasal)->result();            
        foreach ($data_tindakan_asal as $row) {
          if($row->idkel_inacbg == 1){
            array_push($tenaga_ahli, $row);
            $total_tenaga_ahli += $row->vtot;
          } else if($row->idkel_inacbg == 2){
            array_push($bmhp, $row);
            $total_bmhp += $row->vtot;
          } else if($row->idkel_inacbg == 3){
            array_push($rawat_intensif, $row);
            $total_rawat_intensif += $row->vtot;
          } else if($row->idkel_inacbg == 4){
            array_push($pelayanan_darah, $row);
            $total_pelayanan_darah += $row->vtot;
          } else if($row->idkel_inacbg == 5){
            array_push($penunjang, $row);
            $total_penunjang += $row->vtot;
          } else if($row->idkel_inacbg == 6){
            array_push($konsultasi, $row);
            $total_konsultasi += $row->vtot;
          } else if($row->idkel_inacbg == 7){
            array_push($alkes, $row);
            $total_alkes += $row->vtot;
          } else if($row->idkel_inacbg == 8){
            array_push($kamar_akomodasi, $row);
            $total_kamar_akomodasi += $row->vtot;
          } else if($row->idkel_inacbg == 9){
            array_push($laboratorium, $row);
            $total_laboratorium += $row->vtot;
          } else if($row->idkel_inacbg == 10){
            array_push($radiologi, $row);
            $total_radiologi += $row->vtot;
          } else if($row->idkel_inacbg == 11){
            array_push($keperawatan, $row);
            $total_keperawatan += $row->vtot;
          } else if($row->idkel_inacbg == 12){
            array_push($prosedur_bedah, $row);
            $total_prosedur_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 13){
            array_push($prosedur_non_bedah, $row);
            $total_prosedur_non_bedah += $row->vtot;
          } else if($row->idkel_inacbg == 14){
            array_push($sewa_alat, $row);
            $total_sewa_alat += $row->vtot;
          } else if($row->idkel_inacbg == 15){
            array_push($obat, $row);
            $total_obat += $row->vtot;
          } else if($row->idkel_inacbg == 16){
            array_push($rehabilitasi, $row);
            $total_rehabilitasi += $row->vtot;
          } else {

          }
        }  
        //ADMINISTRASI INAP 40.000*LAMARAWAT
        // $selisih_hari=$this->M_pasien->get_selisih_hari($no_register)->row()->selisih_hari;  
        // $fixs_adm=40000*$selisih_hari;
        // $result['tarif_kamar']+=$fixs_adm; //8
        // array_push($kamar_akomodasi, $row);
        // $total_kamar_akomodasi += $row->vtot;
      }

      $total_tarif = $total_tenaga_ahli+$total_bmhp+$total_rawat_intensif+$total_pelayanan_darah+$total_penunjang+$total_konsultasi+$total_alkes+$total_kamar_akomodasi+$total_laboratorium+
      $total_radiologi+$total_keperawatan+$total_prosedur_bedah+$total_prosedur_non_bedah+$total_sewa_alat+$total_obat+$total_rehabilitasi;
      
      // if ($total_tenaga_ahli == 0) {
      //   $total_tenaga_ahli = NULL;
      // } else {
        // $total_tenaga_ahli = "Rp. ".$total_tenaga_ahli;
      // }

      // if ($total_bmhp == 0) {
      //   $total_bmhp = NULL;
      // } else {
        // $total_bmhp = "Rp. ".$total_bmhp;
      // }

      // if ($total_rawat_intensif == 0) {
      //   $total_rawat_intensif = NULL;
      // } else {
        // $total_rawat_intensif = "Rp. ".$total_rawat_intensif;
      // }

      // if ($total_pelayanan_darah == 0) {
      //   $total_pelayanan_darah = NULL;
      // } else {
        // $total_pelayanan_darah = "Rp. ".$total_pelayanan_darah;
      // }

      // if ($total_penunjang == 0) {
      //   $total_penunjang = NULL;
      // } else {
        // $total_penunjang = "Rp. ".$total_penunjang;
      // }

      // if ($total_konsultasi == 0) {
      //   $total_konsultasi = NULL;
      // } else {
        // $total_konsultasi = "Rp. ".$total_konsultasi;
      // }

      // if ($total_alkes == 0) {
      //   $total_alkes = NULL;
      // } else {
        // $total_alkes = "Rp. ".$total_alkes;
      // }

      // if ($total_kamar_akomodasi == 0) {
      //   $total_kamar_akomodasi = NULL;
      // } else {
        // $total_kamar_akomodasi = "Rp. ".$total_kamar_akomodasi;
      // }

      // if ($total_laboratorium == 0) {
      //   $total_laboratorium = NULL;
      // } else {
        // $total_laboratorium = "Rp. ".$total_laboratorium;
      // }

      // if ($total_radiologi == 0) {
      //   $total_radiologi = NULL;
      // } else {
        // $total_radiologi = "Rp. ".$total_radiologi;
      // }

      // if ($total_keperawatan == 0) {
      //   $total_keperawatan = NULL;
      // } else {
        // $total_keperawatan = "Rp. ".$total_keperawatan;
      // }

      // if ($total_prosedur_bedah == 0) {
      //   $total_prosedur_bedah = NULL;
      // } else {
        // $total_prosedur_bedah = "Rp. ".$total_prosedur_bedah;
      // }

      // if ($total_prosedur_non_bedah == 0) {
      //   $total_prosedur_non_bedah = NULL;
      // } else {
        // $total_prosedur_non_bedah = "Rp. ".$total_prosedur_non_bedah;
      // }

      // if ($total_sewa_alat == 0) {
      //   $total_sewa_alat = NULL;
      // } else {
        // $total_sewa_alat = "Rp. ".$total_sewa_alat;
      // }

      // if ($total_obat == 0) {
      //   $total_obat = NULL;
      // } else {
        // $total_obat = "Rp. ".$total_obat;
      // }

      // if ($total_rehabilitasi == 0) {
      //   $total_rehabilitasi = NULL;
      // } else {
        // $total_rehabilitasi = "Rp. ".$total_rehabilitasi;
      // }
      // print_r($kamar_akomodasi);die();



      $no_tindakan = 1;
      $konten = $konten."
      <hr/>
        <table border=\"0\" class=\"lembar-resep\" cellpadding=\"5\">
          <tr>
            <td width=\"100%\" align=\"center\">
              <br>
              <br>
              <font style=\"font-size: 10px;font-weight: bold;\">BILLING INACBGS RAWAT $jenis_rawat</font>
              <br>
            </td>
          </tr>               
        </table>
        <table border=\"0\" cellpadding=\"2\">
          <tr>
            <td width=\"13%\">Nama</td>
            <td width=\"2%\">:</td>
            <td width=\"42%\">$data_pasien->nama</td>
            <td width=\"15%\">Tgl. Kunjungan</td>
            <td width=\"2%\">:</td>
            <td width=\"27%\">".date('Y-m-d',strtotime($data_pasien->tgl_masuk))."</td>
          </tr> 
          <tr>
            <td>Tgl. Lahir</td>
            <td>:</td>
            <td>".$tgl_lahir."</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>$jk</td>
          </tr>
          <tr>
            <td>Golongan</td>
            <td>:</td>
            <td>$data_pasien->cara_bayar</td>
            <td>No. RM</td>
            <td>:</td>
            <td>$data_pasien->no_cm</td>
          </tr>
          <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <td>$data_pasien->no_kartu</td>
            <td>No. SEP</td>
            <td>:</td>
            <td>$data_pasien->no_sep</td>
          </tr> 
          <tr>
            <td>Unit</td>
            <td>:</td>
            <td>$data_pasien->unit</td>
            <td>Dokter</td>
            <td>:</td>
            <td>$data_pasien->nm_dokter</td>
          </tr> 
        </table>
        <br>
        <h3 style=\"font-size: 10px;font-weight: bold;\">Tarif Rumah Sakit</h3>
        <table border=\"1\" cellpadding=\"2\">
          <tr>
            <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">No.</th>
            <th width=\"70%\" style=\"text-align: center;font-weight: bold;\">Pemeriksaan</th>
            <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">Biaya</th>
          </tr>";
          if (!empty($tenaga_ahli)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  TENAGA AHLI</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_tenaga_ahli)."</th>
            </tr>";
            $i=1;
            foreach ($tenaga_ahli as $tarif_tenaga_ahli) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_tenaga_ahli->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_tenaga_ahli->vtot)."</th>
              </tr>";
            }
          }
          
          if (!empty($bmhp)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  BMHP</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_bmhp)."</th>
            </tr>";
            $i=1;
            foreach ($bmhp as $tarif_bmhp) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_bmhp->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_bmhp->vtot)."</th>
              </tr>";
            }
          }
          if (!empty($rawat_intensif)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  RAWAT INTENSIF</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_rawat_intensif)."</th>
            </tr>";
            $i=1;
            foreach ($rawat_intensif as $tarif_rawat_intensif) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_rawat_intensif->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_rawat_intensif->vtot)."</th>
              </tr>";
            }
          }
          if (!empty($pelayanan_darah)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  PELAYANAN DARAH</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_pelayanan_darah)."</th>
            </tr>";
            $i=1;
            foreach ($pelayanan_darah as $tarif_pelayanan_darah) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_pelayanan_darah->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_pelayanan_darah->vtot)."</th>
              </tr>";
            }
          }

          if (!empty($penunjang)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  PENUNJANG</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_penunjang)."</th>
            </tr>";
            $i=1;
            foreach ($penunjang as $tarif_penunjang) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_penunjang->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_penunjang->vtot)."</th>
              </tr>";
            }
          }

          if (!empty($konsultasi)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  KONSULTASI</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_konsultasi)."</th>
            </tr>";
            $i=1;
            foreach ($konsultasi as $tarif_konsultasi) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_konsultasi->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_konsultasi->vtot)."</th>
              </tr>";
            }
          }

          if (!empty($alkes)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  ALKES</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_alkes)."</th>
            </tr>";
            $i=1;
            foreach ($alkes as $tarif_alkes) {
              $konten = $konten."<tr>
                <th width=\"8%\"></th>
                <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_alkes->nmtindakan))."</th>
                <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_alkes->vtot)."</th>
              </tr>";
            }
          }
          
          if (!empty($kamar_akomodasi)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  KAMAR / AKOMODASI</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_kamar_akomodasi)."</th>
            </tr>";
            $i=1;
            foreach ($kamar_akomodasi as $tarif_akomodasi) {
              if (isset($tarif_akomodasi->lama_rawat)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_akomodasi->nmruang))." (".$tarif_akomodasi->lama_rawat." hari)</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_akomodasi->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_akomodasi->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_akomodasi->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($laboratorium)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  LABORATORIUM</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_laboratorium)."</th>
            </tr>";
            $i=1;
            foreach ($laboratorium as $tarif_laboratorium) {
              if (isset($tarif_laboratorium->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_laboratorium->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_laboratorium->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_laboratorium->jenis_tindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_laboratorium->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($radiologi)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  RADIOLOGI / DIAGNOSTIK</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_radiologi)."</th>
            </tr>";
            $i=1;
            foreach ($radiologi as $tarif_radiologi) {
              if (isset($tarif_radiologi->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_radiologi->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_radiologi->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_radiologi->jenis_tindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_radiologi->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($keperawatan)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  KEPERAWATAN</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_keperawatan)."</th>
            </tr>";
            $i=1;
            foreach ($keperawatan as $tarif_keperawatan) {
              // if nmtindakan karena belum tau ada objek selain nmtindakan
              if (isset($tarif_keperawatan->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_keperawatan->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_keperawatan->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_keperawatan->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_keperawatan->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($prosedur_bedah)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  PROSEDUR BEDAH</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_prosedur_bedah)."</th>
            </tr>";
            $i=1;
            foreach ($prosedur_bedah as $tarif_prosedur_bedah) {
              if (isset($tarif_prosedur_bedah->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_prosedur_bedah->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_prosedur_bedah->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_prosedur_bedah->jenis_tindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_prosedur_bedah->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($prosedur_non_bedah)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  PROSEDUR NON BEDAH</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_prosedur_non_bedah)."</th>
            </tr>";
            $i=1;
            foreach ($prosedur_non_bedah as $tarif_prosedur_non_bedah) {
              if (isset($tarif_prosedur_non_bedah->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_prosedur_non_bedah->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_prosedur_non_bedah->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_prosedur_non_bedah->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_prosedur_non_bedah->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($sewa_alat)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  SEWA ALAT</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_sewa_alat)."</th>
            </tr>";
            $i=1;
            foreach ($sewa_alat as $tarif_sewa_alat) {
              if (isset($tarif_sewa_alat->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_sewa_alat->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_sewa_alat->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_sewa_alat->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_sewa_alat->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($obat)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  OBAT</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_obat)."</th>
            </tr>";
            $i=1;
            foreach ($obat as $tarif_obat) {
              if (isset($tarif_obat->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_obat->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_obat->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_obat->nama_obat))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_obat->vtot)."</th>
                </tr>";
              }
            }
          }
          
          if (!empty($rehabilitasi)) {
            $konten = $konten."<tr>
              <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">".$no_tindakan++."</th>
              <th width=\"70%\" style=\"font-weight: bold;\">  REHABILITASI</th>
              <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_rehabilitasi)."</th>
            </tr>";
            $i=1;
            foreach ($rehabilitasi as $tarif_rehabilitasi) {
              if (isset($tarif_rehabilitasi->nmtindakan)) {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_rehabilitasi->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_rehabilitasi->vtot)."</th>
                </tr>";
              } else {
                $konten = $konten."<tr>
                  <th width=\"8%\"></th>
                  <th width=\"70%\">  ".$i++.". ".ucwords(strtolower($tarif_rehabilitasi->nmtindakan))."</th>
                  <th width=\"22%\" style=\"text-align: right;\">".$this->rupiah($tarif_rehabilitasi->vtot)."</th>
                </tr>";
              }
            }
          }
          $konten = $konten."<tr>
            <th colspan=\"2\" style=\"font-weight: bold;text-align: right;\">Total :</th>
            <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">".$this->rupiah($total_tarif)."</th>
          </tr>
               

        </table>
        <br>
        <h3 style=\"font-size: 10px;font-weight: bold;\">Diagnosa (ICD-10)</h3>
        <table border=\"1\" cellpadding=\"3\">
          <tr>
            <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">No.</th>
            <th width=\"70%\" style=\"text-align: center;font-weight: bold;\">Diagnosa (ICD-10)</th>
            <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">Klasifikasi</th>
          </tr>";
          if (empty($get_diagnosa)) {
            $konten = $konten . "
                <tr>
                  <td width=\"100%\" style=\"text-align: center;\"></td>
                </tr>";
          } else {
            $no_diagnosa=1;
            foreach($get_diagnosa as $diagnosa){
              $konten = $konten . "
                  <tr>
                    <td style=\"text-align: center;\">".$no_diagnosa++."</td>
                    <td> ".$diagnosa->id_diagnosa." - ".$diagnosa->diagnosa."</td>
                    <td style=\"text-align: center;\">".$diagnosa->klasifikasi_diagnos."</td>
                  </tr>";
            }
          }
          $konten = $konten ."</table>
        <br>
        <h3 style=\"font-size: 10px;font-weight: bold;\">Prosedure (ICD-9)</h3>
        <table border=\"1\" cellpadding=\"3\">
          <tr>
            <th width=\"8%\" style=\"text-align: center;font-weight: bold;\">No.</th>
            <th width=\"70%\" style=\"text-align: center;font-weight: bold;\">Prosedure (ICD-9)</th>
            <th width=\"22%\" style=\"text-align: center;font-weight: bold;\">Klasifikasi</th>
            </tr>";
          if (empty($get_procedure)) {
            $konten = $konten . "
                <tr>
                  <td width=\"100%\" style=\"text-align: center;\"></td>
                </tr>";
          } else {
            $no_procedure=1;
            foreach($get_procedure as $procedure){
              $konten = $konten . "
                  <tr>
                    <td style=\"text-align: center;\">".$no_procedure++."</td>
                    <td> ".$procedure->id_procedure." - ".$procedure->nm_procedure."</td>
                    <td style=\"text-align: center;\">".$procedure->klasifikasi_procedure."</td>
                  </tr>";
            }
          }
          $konten = $konten ."</table>";
      //echo $konten;     
        $file_name="Billing_INACBG_$no_register.pdf";      
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();      
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);        
        $obj_pdf->SetCreator(PDF_CREATOR);
        $title = "";
        $obj_pdf->SetTitle($file_name);
        $obj_pdf->SetHeaderData('', '', $title, '');
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins('5', '5', '5');
        $obj_pdf->SetAutoPageBreak(TRUE, '15');
        $obj_pdf->SetFont('helvetica', '', 9);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        ob_start();
          $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');        
        $obj_pdf->Output(FCPATH.'/download/inacbg/billing/'.$file_name, 'FI');
    }else{
      redirect('irj/rjcsjp/','refresh');
    }
  }    

  public function rupiah($nominal){
    $result = "Rp " . number_format($nominal,0,'','.');
    return $result;
  }

  public function get_pasien() {
    $no_register = $this->input->post('no_register');
    if (substr($no_register, 0,2) == 'RJ') {
      $result = $this->M_pasien->show_pelayanan_irj($no_register); 
    }              

    if (substr($no_register, 0,2) == 'RI') {
      $result = $this->M_pasien->show_pelayanan_iri($no_register); 
    }
    echo json_encode($result);
  }

  public function get_inacbg() {
    $no_register = $this->input->post('no_register');
    $result = $this->M_inacbg->claim_status($no_register); 
    echo json_encode($result);
  }

}
?>
