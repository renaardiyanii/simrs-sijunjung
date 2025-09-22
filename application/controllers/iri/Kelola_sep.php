<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Kelola_sep extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->model('iri/Rimsep','',TRUE);
        $this->load->helper('tgl_indo');
	}
	
	public function index()
	{	
		$data['title'] = '';	
		$this->load->view('iri/kelola_sep',$data);	
	}	

	public function get_sep()
    {
        $list = $this->Rimsep->get_sep();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->no_sep;
            $row[] = $result->no_cm;
            $row[] = $result->nama;
            $row[] = $result->no_kartu;
            // $row[] = date_indo(date('Y-m-d',strtotime($result->tgl_masuk))).' '.date('H:i',strtotime($result->tgl_masuk));
            $row[] = date_indo(date('Y-m-d',strtotime($result->tgl_masuk)));
            if ($result->no_sep == '') {   
                if (date('Y-m-d',strtotime($result->tgl_masuk)) == date('Y-m-d')) {
                    $row[] = '<a class="btn waves-effect waves-light btn-primary btn-xs btn-block" target="_blank" href="'.site_url('bpjs/sep/create_irj/'.$result->no_ipd).'">Buat SEP</a>'; 
                } else  {
                    $row[] = '<button class="btn waves-effect waves-light btn-warning btn-xs btn-block" onclick="penjaminan_sep(\''.$result->no_ipd.'\')">Penjaminan SEP</button>'; 
                }                             
            } else {                
                $row[] = '<button class="btn waves-effect waves-light btn-primary btn-xs btn-block" onclick="cetak_sep(\''.$result->no_ipd.'\')">Cetak</button><button class="btn waves-effect waves-light btn-warning btn-xs btn-block" onclick="update_sep(\''.$result->no_sep.'\')">Update</button><button class="btn waves-effect waves-light btn-danger btn-xs btn-block delete-sep" onclick="hapus_sep(\''.$result->no_sep.'\')">Hapus</button>';   
            }           	
            		
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Rimsep->count_all(),
                        "recordsFiltered" => $this->Rimsep->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }	

    public function get_pasien_iri()
    {   $no_sep = $this->input->post('no_sep');
        $result = $this->Mbpjs->pasien_iri($no_sep);
        echo json_encode($result);
    }   
}
