<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');

class Diagnosa extends Secure_area {
    public function __construct() {
            parent::__construct();
            $this->load->model('irj/Mdiagnosa','',TRUE);    
            $this->load->library('inacbg');             
    }

    function autocomplete_irj()
    {    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->Mdiagnosa->autocomplete_irj($q);
        }
    }

    public function insert() 
    {
        date_default_timezone_set("Asia/Jakarta");
        $no_register = $this->input->post('no_register');
        if ($this->input->post('diagnosa_text')) {
            $diagnosaText = $this->input->post('diagnosa_text');
        } else {
            $diagnosaText = NULL;
        }
        $cek_utama = $this->Mdiagnosa->count_utama($no_register);
        $cek_limit = $this->Mdiagnosa->count_limit($no_register);        
        if ($cek_limit < 30) {
            if ($cek_utama > 0) {
                $klasifikasi = 'tambahan';
            } else {
                $klasifikasi = 'utama';
            }       
            
            $login_data = $this->load->get_var("user_info");
            $user = $login_data->username;
            $idDiagnosa = NULL;
            $namaDiagnosa = NULL;
            if ($this->input->post('diagnosa') != '') { 
                $diagnosa = explode("@", $this->input->post('diagnosa'));
                $idDiagnosa = $diagnosa[0]; 
                $namaDiagnosa = $diagnosa[1]; 
                // $result_error = array(
                //     'metadata' => array('code' => '402','message' => 'Silahkan pilih diagnosa terlebih dahulu.'),
                //     'response' => null
                // );
                // echo json_encode($result_error);                 
            } 
            // else {
                 
                if (substr($no_register, 0,2) == 'RJ') {  
                    $exist = $this->db->from('diagnosa_pasien')->where('id_diagnosa',$idDiagnosa)->where('no_register',$no_register)->get();
                }
                if (substr($no_register, 0,2) == 'RI') {  
                    $exist = $this->db->from('diagnosa_iri')->where('id_diagnosa',$idDiagnosa)->where('no_register',$no_register)->get();
                }
                if( $exist->num_rows() > 0 ) {
                    $result_error = array(
                        'metadata' => array('code' => '422','message' => 'Diagnosa '.$idDiagnosa.' sudah ada. Tidak dapat menginput diagnosa yang sama.'),
                        'response' => null
                    );
                    echo json_encode($result_error);
                } else {
                    $data_insert = array(
                        'no_register' => $no_register,
                        'tgl_kunjungan' => $this->input->post('tgl_masuk'),
                        'id_diagnosa' => $idDiagnosa,
                        'diagnosa' => $namaDiagnosa,
                        'diagnosa_text' => $diagnosaText,
                        'klasifikasi_diagnos' => $klasifikasi,
                        'xuser' => $user
                    );
//add
                    // $cekdiagnosa_kerja = $this->Mdiagnosa->cekdiagnosa_kerja($no_register)->row();
                    // if($cekdiagnosa_kerja == false){
                    //     $datafisik['diag_kerja'] = 'Diagnosa :  '. $namaDiagnosa.' ';
                    //     $datafisik['diag_banding'] = 'Diagnosa :  '. $namaDiagnosa.' ';
                    // }else{
                    //     $datafisik['diag_kerja'] = $cekdiagnosa_kerja->diag_banding.'<br>'.'Diagnosa '.$namaDiagnosa.'';
                    //     $datafisik['diag_banding'] = $cekdiagnosa_kerja->diag_banding.'<br>'.'Diagnosa '.$namaDiagnosa.'';
                    // }
                    
                    if($this->input->post('diagnosa') != ''){
                        $result = $this->Mdiagnosa->insert($data_insert);
                    }else{
                        $result = false;
                    }
                   

                    if ($result == true) {
                        if ($klasifikasi == 'utama'){
                            $this->Mdiagnosa->update_bpjs_sep($no_register,['diagawal'=>$idDiagnosa]);
                        }
                        $result_success = array(
                            'metadata' => array('code' => '200','message' => 'Diagnosa berhasil disimpan.'),
                            'response' => 'OK'
                        );
                        
                        // $data_fisik=$this->Mdiagnosa->getdata_tindakan_fisik($no_register)->row();
                        // if ($data_fisik==FALSE) {
                        //     $datafisik['no_register'] = $no_register;
                        //     $this->Mdiagnosa->insert_data_fisik($datafisik);
                        //     //INSERT
                        // } else {
                        //     $this->Mdiagnosa->update_data_fisik($no_register, $datafisik);
                        //     // UPDATE
                        // }
                        echo json_encode($result_success);       
                    } else {
                        $result_error = array(
                            'metadata' => array('code' => '500','message' => $result),
                            'response' => null
                        );
                        echo json_encode($result_error);
                    } 
                }   
            // }
        } else {
            $result_error = array(
                'metadata' => array('code' => '403','message' => 'Jumlah penginputan diagnosa sudah mencapai batas maksimal.'),
                'response' => null
            );
            echo json_encode($result_error);
        }
        
    }

    public function get_diagnosa()
    {
        $no_register = $this->input->post('no_register');
        $data_diagnosa=$this->Mdiagnosa->get_diagnosa();
        $data = array();
        $no = $_POST['start'];
        $diagnosa_pasien = '';        
        
        foreach ($data_diagnosa as $diagnosa) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
                if ($diagnosa->klasifikasi_diagnos == 'utama') {
                    $row[] = '<span class="code">'.$diagnosa->id_diagnosa.'</span>'.$diagnosa->diagnosa;
                } else $row[] = '<span class="code">'.$diagnosa->id_diagnosa.'</span> ' .$diagnosa->diagnosa;               
            } else $row[] = '';

            $row[] = $diagnosa->diagnosa_text;
            
            if ($diagnosa->klasifikasi_diagnos == 'utama') {          
                $row[] = '<center><label class="label label-primary" style="font-size: 12px;">Primer</label></center>';
                $row[] = '<button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {     
                $row[] = '<center><label class="label label-warning" style="font-size: 12px;">Sekunder</label></center>';
                $row[] = '<button type="button" onclick="set_utama_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Primer</button><button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';  
            }                        
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mdiagnosa->count_all(),
            "recordsFiltered" => $this->Mdiagnosa->filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function get_diagnosa_inacbg()
    {
        $no_register = $this->input->post('no_register');
        $data_diagnosa=$this->Mdiagnosa->get_diagnosa();
        $data = array();
        $no = $_POST['start'];
        $diagnosa_pasien = '';        
        
        foreach ($data_diagnosa as $diagnosa) {
            $request = array(
                'metadata'=>array(
                    'method' => 'search_diagnosis'
                ),                  
                'data'=>array(
                    'keyword' => $diagnosa->id_diagnosa
                )
            );  
            $data_request=json_encode($request);    
            $response = $this->inacbg->web_service($data_request);
            if ($response == '' || $response == null) { 
                $status_diagnosa = '-';             
            } else {            
                $check_result = json_decode($response);                                 
                if (isset($check_result->metadata->code) && $check_result->metadata->code == '200') {
                    $list_diagnosa = json_encode($check_result->response->data);
                    $result_object = json_decode($list_diagnosa);
                    if ($result_object == "EMPTY") {
                        $status_diagnosa = '<center><span style="color: #dd4b39;">Tidak Valid</span></center>';
                    } else {
                        foreach ($result_object as $row) {
                            if($row[1] == $diagnosa->id_diagnosa) {
                                $status_diagnosa = '<center><span style="color: #00a65a;">Valid</span></center>';
                            } else {
                                $status_diagnosa = '<center><span style="color: #dd4b39;">Tidak Valid</span></center>';
                            }
                        }
                    }                   
                } else $status_diagnosa = '<center><span style="color: #dd4b39;">Tidak Valid</span></center>';
            }  
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
                if ($diagnosa->klasifikasi_diagnos == 'utama') {
                    $row[] = '<span class="code">'.$diagnosa->id_diagnosa.'</span>'.$diagnosa->diagnosa;
                } else $row[] = '<span class="code">'.$diagnosa->id_diagnosa.'</span> ' .$diagnosa->diagnosa;               
            } else $row[] = '';

            $row[] = $diagnosa->diagnosa_text;
            
            if ($diagnosa->klasifikasi_diagnos == 'utama') {          
                $row[] = '<center><label class="label label-primary" style="font-size: 12px;">Primer</label></center>';
                $row[] = $status_diagnosa;
                $row[] = '<button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {     
                $row[] = '<center><label class="label label-warning" style="font-size: 12px;">Sekunder</label></center>';
                $row[] = $status_diagnosa;
                $row[] = '<button type="button" onclick="set_utama_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Primer</button><button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';  
            }                        
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mdiagnosa->count_all(),
            "recordsFiltered" => $this->Mdiagnosa->filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function delete()
    {   
        $id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
        $no_register = $this->input->post('no_register');
        $result = $this->Mdiagnosa->delete($id_diagnosa_pasien,$no_register);
       // $fisik = $this->Mdiagnosa->update_fisik($$no_register);
        $cek_utama = $this->Mdiagnosa->count_utama($no_register);
        if ($cek_utama == 0) {
            $this->Mdiagnosa->auto_utama($no_register);
        }            
        echo json_encode($result);
    }

    public function set_utama(){   
        $id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
        $no_register = $this->input->post('no_register');
        $result = $this->Mdiagnosa->set_utama($id_diagnosa_pasien,$no_register);
        echo json_encode($result);
    }

    function select2() {  
        $keyword = $_GET['q'];
        //var_dump($keyword);die();
        $where = 0;
        $data = $this->db->select('id_icd, nm_diagnosa')
            ->from('icd1')
            // ->where('deleted', $where)
            ->where('nm_diagnosa ~*', $keyword)
            ->or_like('UPPER(id_icd)',strtoupper($keyword))
            ->where('deleted', $where)
            ->limit(50, 0)
            ->get();
            // $data = $this->Frmmdaftar->get_diagnosa_select2($keyword);
            // var_dump($data);die();
            $arr='';
            if($data->num_rows() > 0){
                foreach ($data->result_array() as $row){
                    $new_row['id']=$row['id_icd'].'@'.$row['nm_diagnosa'];
                    $new_row['text']=$row['id_icd'].' - '.$row['nm_diagnosa'];
                    $new_row['id_diag'] = $row['id_icd'];
                    $new_row['nama']  =$row['nm_diagnosa'];
                    $row_set[] = $new_row; //build an array
                }
                echo json_encode($row_set); //format the array into json data
            } else {
                echo json_encode([]);
            }
        
        // if (isset($_GET['q'])) {
        //     $keyword = rawurlencode(ucfirst($_GET['q']));   
        //     $result = $this->Mdiagnosa->select2($keyword);                 
        //     if (empty($result)) {
        //         echo json_encode([]);                   
        //     } else {                                       
        //         foreach ($result as $row) {
        //             $new_row['id'] = htmlentities(stripslashes($row->id_icd.'@'.$row->nm_diagnosa));
        //             $new_row['text'] = htmlentities(stripslashes($row->id_icd.' - '.$row->nm_diagnosa));                 
        //             $row_set[] = $new_row;
        //         }
        //         echo json_encode($row_set);                     
        //     }                                                                                   
        // } else echo json_encode([]);    
    }

    function select2_kode() {   
        if (isset($_GET['q'])) {
            $keyword = rawurlencode($_GET['q']);   
            $result = $this->Mdiagnosa->select2($keyword);                 
            if (empty($result)) {
                echo json_encode([]);                   
            } else {                                       
                    foreach ($result as $row) {
                        $new_row['id']=htmlentities(stripslashes($row->id_icd));
                        $new_row['text']=htmlentities(stripslashes($row->id_icd.' - '.$row->nm_diagnosa));                
                        $row_set[] = $new_row;
                    }
                    echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }

    function select2_kode_bpjs() {   
        if (isset($_GET['q'])) {
            $keyword = rawurlencode($_GET['q']);    
            $response = $this->libreferensi->diagnosa($keyword);    
            if ($response == '' || $response == null) { 
                $result_error = array(
                    'metaData' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
                    'response' => null
                );
                echo json_encode($result_error);                    
            } else {            
                $check_result = json_decode($response);                                 
                if (isset($check_result->metaData->code) && $check_result->metaData->code == '200') {
                    $diagnosa = json_encode($check_result->response->diagnosa);
                    $result_object = json_decode($diagnosa, true);
                    foreach ($result_object as $row) {
                        $new_row['id'] = htmlentities(stripslashes($row['kode']));
                        $new_row['text'] = htmlentities(stripslashes($row['nama']));                          
                        $result[] = $new_row;
                    }
                    echo json_encode($result);                      
                } else echo json_encode([]);
            }                                                                                   
        } else echo json_encode([]);    
    }

    function select2_inacbg() {   
        if (isset($_GET['q'])) {
            $keyword = rawurlencode($_GET['q']);            
            $request = array(
                'metadata'=>array(
                    'method' => 'search_diagnosis'
                ),                  
                'data'=>array(
                    'keyword' => $keyword
                )
            );  
            $data_request=json_encode($request);    
            $response = $this->inacbg->web_service($data_request);
            if ($response == '' || $response == null) { 
                echo json_encode([]);               
            } else {            
                $check_result = json_decode($response);                                 
                if (isset($check_result->metadata->code) && $check_result->metadata->code == '200') {
                    $diagnosa = json_encode($check_result->response->data);
                    $result_object = json_decode($diagnosa);
                    if ($result_object == "EMPTY") {
                        echo json_encode([]);
                    } else {
                        foreach ($result_object as $row) {
                            $new_row['id']=htmlentities(stripslashes($row[1].'@'.$row[0]));
                            $new_row['text']=htmlentities(stripslashes($row[1].' - '.$row[0]));                   
                            $row_set[] = $new_row;
                        }
                        echo json_encode($row_set); 
                    }                   
                } else echo json_encode([]);
            }                                                                                   
        } else echo json_encode([]);    
    }
                        
}
?>
