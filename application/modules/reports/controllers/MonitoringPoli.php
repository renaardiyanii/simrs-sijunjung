<?php

class MonitoringPoli extends CI_Controller {
    //$this->load->library('categories/categories_class')
    public function __construct() {
            parent::__construct();
            //$this->load->model('irj/Mdiagnosa','',TRUE);    
            //$this->load->library('koolreport/core/src/KoolReport');             
    }

    public function index() {
        $data["data"] = array(
            array("category"=>"Books","sale"=>32000,"cost"=>20000,"profit"=>12000),
            array("category"=>"Accessories","sale"=>43000,"cost"=>36000,"profit"=>7000),
            array("category"=>"Phones","sale"=>54000,"cost"=>39000,"profit"=>15000),
            array("category"=>"Movies","sale"=>23000,"cost"=>18000,"profit"=>5000),
            array("category"=>"Others","sale"=>12000,"cost"=>6000,"profit"=>6000)
        );
        $this->load->view('reports/pasien',$data);
    }
}
?>