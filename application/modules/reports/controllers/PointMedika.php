<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/koolreport/core/autoload.php');
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;

class PointMedika extends Secure_area {
    //$this->load->library('categories/categories_class')
    public function __construct() {
            parent::__construct();
            $this->load->model('MpointMedika','',TRUE);    

            //$this->load->model('irj/Mdiagnosa','',TRUE);    
            //$this->load->library('koolreport/core/src/KoolReport');             
    }

    public function index() {
    }

    public function get_cppt_by_medrek($no_medrec) {
        //header('Content-Type: application/json');
        //$this->setOutputMode(NORMAL);
        //echo json_encode($this->MPointMedika->get_cppt_pm_by_no_medrek($no_medrec), true);
        $data['data']= $this->MpointMedika->get_cppt_pm_by_no_medrek($no_medrec);
        $this->load->view("pasien",$data);
    }

    public function get_assesmen_medis_by_medrek($nomedrec)
    {
        $val['data'] = $this->MpointMedika->get_assesment_medis_by_medrec($nomedrec);
        $this->load->view('assesment_medis_poli',$val);
    }
}
?>