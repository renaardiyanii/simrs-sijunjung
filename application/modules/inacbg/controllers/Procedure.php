<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');

class Procedure extends Secure_area {
    public function __construct() {
            parent::__construct();
            $this->load->model('Mprocedure','',TRUE);  
            $this->load->library('inacbg');          
    }

    //////////////////////////////////////// Rawat Jalan ////////////////////////////////////////

    function autocomplete_irj()
    {    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->Mprocedure->autocomplete_irj($q);
        }
    }

    public function insert()
    {   
        date_default_timezone_set("Asia/Jakarta");
        $noRegister = $this->input->post('no_register');
        $cek_limit = $this->Mprocedure->count_limit($noRegister);        
        if ($cek_limit < 30) {
            $login_data = $this->load->get_var("user_info");
            $user = $login_data->username;
            $idProcedure = '';
            $namaProcedure = '';
            
            if (!$this->input->post('procedure') || $this->input->post('procedure') == '') { 
                $result_error = array(
                    'metadata' => array('code' => '402','message' => 'Silahkan pilih diagnosa terlebih dahulu.'),
                    'response' => null
                );
                echo json_encode($result_error);                 
            } else {
                $procedure = explode("@", $this->input->post('procedure'));
                $idProcedure = $procedure[0]; 
                $namaProcedure = $procedure[1];    
                if (substr($noRegister, 0,2) == 'RJ') {  
                    $exist = $this->db->from('icd9cm_irj')->where('id_procedure',$idProcedure)->where('no_register',$noRegister)->get();
                }
                if (substr($noRegister, 0,2) == 'RI') {  
                    $exist = $this->db->from('icd9cm_iri')->where('id_procedure',$idProcedure)->where('no_register',$noRegister)->get();
                }
                if( $exist->num_rows() > 0 ) {
                    $result_error = array(
                        'metadata' => array('code' => '422','message' => 'Prosedur '.$idProcedure.' sudah ada. Tidak dapat menginput prosedur yang sama.'),
                        'response' => null
                    );
                    echo json_encode($result_error);
                } else {
                    $dataInsert = array(
                        'tgl_kunjungan' => $this->input->post('tgl_masuk'),
                        'no_register' => $noRegister,
                        'id_poli' => $this->input->post('id_poli'),
                        'id_procedure' => $idProcedure,
                        'nm_procedure' => $namaProcedure,
                        'xuser' => $user
                    );
                    $result = $this->Mprocedure->insert($dataInsert);      
                    if ($result == true) {
                        $result_success = array(
                            'metadata' => array('code' => '200','message' => 'Prosedur berhasil disimpan.'),
                            'response' => 'OK'
                        );
                        echo json_encode($result_success);       
                    } else {
                        $result_error = array(
                            'metadata' => array('code' => '500','message' => $result),
                            'response' => null
                        );
                        echo json_encode($result_error);
                    } 
                }           
            }
        } else {
            $result_error = array(
                'metadata' => array('code' => '403','message' => 'Jumlah penginputan prosedur sudah mencapai batas maksimal.'),
                'response' => null
            );
            echo json_encode($result_error);
        }
    }

    public function get_procedure(){
        $data_procedure=$this->Mprocedure->get_procedure();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_procedure as $procedure) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<span class="code">'.$procedure->id_procedure.'</span>'.$procedure->nm_procedure;               
            $row[] = '<button type="button" onclick="delete_procedure(\''.$procedure->id.'\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mprocedure->count_all(),
            "recordsFiltered" => $this->Mprocedure->filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function delete()
    {   
        $id = $this->input->post('id');
        $no_register = $this->input->post('no_register');
        $result=$this->Mprocedure->delete($id,$no_register);
        echo json_encode($result);
    }

    function select2() {   
        if (isset($_GET['q'])) {
            $keyword = rawurlencode($_GET['q']);   
            $result = $this->Mprocedure->select2($keyword);                 
            if (empty($result)) {
                echo json_encode([]);                   
            } else {                                       
                foreach ($result as $row) {
                    $new_row['id'] = htmlentities(stripslashes($row->id_tind.'@'.$row->nm_tindakan));
                    $new_row['text'] = htmlentities(stripslashes($row->id_tind.' - '.$row->nm_tindakan));                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }

    function select2_inacbg() {  
        if (isset($_GET['q'])) {
            $keyword = rawurlencode($_GET['q']);            
            $request = array(
                'metadata'=>array(
                    'method' => 'search_procedures'
                ),                  
                'data'=>array(
                    'keyword' => $keyword
                )
            );  

            $data_request=json_encode($request);    
            $response = $this->inacbg->web_service($data_request);
            if ($response == '' || $response == null) { 
                $result_error = array(
                    'metadata' => array('code' => '503','message' => 'Gagal menampilkan data. Silahkan coba lagi.'),
                    'response' => null
                );
                echo json_encode($result_error);                    
            } else {            
                $check_result = json_decode($response);                                 
                if (isset($check_result->metadata->code) && $check_result->metadata->code == '200') {
                    $procedure = json_encode($check_result->response->data);
                    $result_object = json_decode($procedure);
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

    //////////////////////////////////////// Rawat Inap ////////////////////////////////////////        
                        
}
?>
