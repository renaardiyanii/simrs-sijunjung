<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Kelola_sep extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->model('irj/Rjmsep','',TRUE);
        $this->load->helper('tgl_indo');
	}
	
	public function index()
	{	
		$data['title'] = 'Kelola SEP Rawat Jalan';	
		$this->load->view('irj/kelola_sep',$data);	
	}	

	public function get_sep()
    {
        date_default_timezone_set('Asia/Jakarta');
        $list = $this->Rjmsep->get_sep();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $result->no_sep;
            $row[] = $result->no_cm;
            $row[] = $result->nama;
            $row[] = $result->no_kartu;
            // $row[] = date_indo(date('Y-m-d',strtotime($result->tgl_kunjungan))).' '.date('H:i',strtotime($result->tgl_kunjungan));
            $row[] = $result->tgl_kunjungan;
            if ($result->no_sep == '') {   
                $today = date('Y-m-d H:i:s');
                if (date_diff(date_create($today),date_create($result->tgl_kunjungan))->days <= 3) {
                    $row[] = '<button class="btn waves-effect waves-light btn-success btn-xs btn-block" onclick="buat_sep(\''.$result->no_register.'\')"><i class="fa fa-pencil-square-o"></i> Buat SEP</button>'; 
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
            "recordsTotal" => $this->Rjmsep->count_all(),
            "recordsFiltered" => $this->Rjmsep->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }	
}
