<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Pasien extends Secure_area {
    public function __construct(){
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->model('bpjs/Mbpjs','',TRUE);
        $this->load->model('bpjs/pasien/Irj','',TRUE);
        $this->load->model('bpjs/pasien/Iri','',TRUE);
        $this->load->model('bpjs/Mpasien','',TRUE); 
    }

    public function pelayanan($no_register='') 
    {       
        $result = $this->Mpasien->pelayanan($no_register);      
        echo json_encode($result);
    }
    
    public function irj()
    {   
        $data['title'] = 'BPJS - Unit Rawat Jalan / UGD';   
        $this->load->view('bpjs/pasien/irj',$data); 
    }   

    public function iri()
    {   
        $data['title'] = 'BPJS - Unit Rawat Inap';    
        $this->load->view('bpjs/pasien/iri',$data);  
    }   

    public function pasien_irj()
    {
        date_default_timezone_set('Asia/Jakarta');
        $list = $this->Irj->get_sep();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<center>'.$result->no_sep.'</center>';
            $row[] = '<center>'.$result->no_cm.'</center>';
            $row[] = $result->nama;
            $row[] = '<center>'.$result->no_kartu.'</center>';
            $row[] = '<center>'.date_indo(date('Y-m-d',strtotime($result->tgl_kunjungan))).'</center>';
            if ($result->no_sep == '') {   
                $today = date('Y-m-d H:i:s');
                if (date_diff(date_create($today),date_create($result->tgl_kunjungan))->days <= 3) {
                    $row[] = '<button class="btn waves-effect waves-light btn-success btn-xs btn-block create_sep" data-noregister="'.$result->no_register.'"><i class="fa fa-pencil-square-o"></i> Buat SEP</button>'; 
                } else  {
                    $row[] = '<button class="btn waves-effect waves-light btn-warning btn-xs btn-block" onclick="penjaminan_sep(\''.$result->no_register.'\')">Penjaminan SEP</button>';                  
                }                             
            } else {                
                $row[] = '<button class="btn waves-effect waves-light btn-primary btn-xs btn-block cetak_sep" data-noregister="'.$result->no_register.'"><i class="fa fa-print"></i> Cetak</button><button class="btn waves-effect waves-light btn-danger btn-xs btn-block delete-sep" onclick="hapus_sep(\''.$result->no_sep.'\')"><i class="fa fa-trash"></i> Hapus</button>';   
            }                           
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Irj->count_all(),
            "recordsFiltered" => $this->Irj->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }   

    public function pasien_iri()
    {
        $list = $this->Iri->get_sep();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<center>'.$result->no_sep.'</center>';
            $row[] = '<center>'.$result->no_cm.'</center>';
            $row[] = $result->nama;
            $row[] = '<center>'.$result->no_kartu.'</center>';
            // $row[] = date_indo(date('Y-m-d',strtotime($result->tgl_masuk))).' '.date('H:i',strtotime($result->tgl_masuk));
            $row[] = '<center>'.date_indo(date('Y-m-d',strtotime($result->tgl_masuk))).'</center>';
            if ($result->no_sep == '') {   
                $today = date('Y-m-d H:i:s');
                if (date_diff(date_create($today),date_create($result->tgl_masuk))->days <= 3) {
                    $row[] = '<button class="btn waves-effect waves-light btn-success btn-xs btn-block create_sep" data-noregister="'.$result->no_ipd.'"><i class="fa fa-pencil-square-o"></i> Buat SEP</button>'; 
                } else  {
                    $row[] = '<button class="btn waves-effect waves-light btn-warning btn-xs btn-block" onclick="penjaminan_sep(\''.$result->no_ipd.'\')">Penjaminan SEP</button>';                  
                }                             
            } else {                
                $row[] = '<button class="btn waves-effect waves-light btn-primary btn-xs btn-block cetak_sep" data-noregister="'.$result->no_ipd.'"><i class="fa fa-print"></i> Cetak</button><button class="btn waves-effect waves-light btn-warning btn-xs btn-block update_tglplg" data-noregister="'.$result->no_ipd.'"><i class="fa fa-pencil-square-o"></i> Update Tgl Plg</button><button class="btn waves-effect waves-light btn-danger btn-xs btn-block delete-sep" onclick="hapus_sep(\''.$result->no_sep.'\')"><i class="fa fa-trash"></i> Hapus</button>';   
            }              
                    
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Iri->count_all(),
                        "recordsFiltered" => $this->Iri->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }   

    public function get_pasien_iri()
    {   $no_sep = $this->input->post('no_sep');
        $result = $this->Mbpjs->pasien_iri($no_sep);
        echo json_encode($result);
    } 

    public function get_poli_bpjs($poli_bpjs='') 
    {       
        $result = $this->Mpasien->get_poli_bpjs($poli_bpjs);      
        echo json_encode($result);
    }
}
