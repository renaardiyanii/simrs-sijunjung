<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/koolreport/core/autoload.php');
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;

class Pasien extends Secure_area {
    //$this->load->library('categories/categories_class')
    public function __construct() {
            parent::__construct();
            $this->load->model('MpointMedika','',TRUE);
            //$this->load->model('irj/Mdiagnosa','',TRUE);    
            //$this->load->library('koolreport/core/src/KoolReport');             
    }

    public function get_last_pasien()
    {
        echo $this->MpointMedika->get_last_pasien()->row()->max;
        
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

    public function get_diagnosa_by_medrek($nomedrec = "",$keyword="")
    {
        // var_dump($nomedrec);die();
        if($keyword!=""){
            $data= $this->MpointMedika->get_diagnosa_by_nocm($nomedrec,$keyword)->result();
        }else{
            $data= $this->MpointMedika->get_diagnosa_by_nocm($nomedrec)->result();
            
        }
        // var_dump($data);die();
        echo "<table id=\"table_obat_history\" class=\" table display table-hover table-bordered table-striped\" style=\"width: 100%;\">
        <thead>
            <tr>
                <th style=\"width: 5%;\">No</th>
                <th style=\"width: 10%;\">Tgl</th>
                <th style=\"width: 10%;\">Poli</th>
                <th style=\"width: 10%;\">Id Diagnosa</th>
                <th style=\"width: 30%;\">Diagnosa</th>
                 <th style=\"width: 35%;\">Catatan</th>
            </tr>
        </thead>";
        foreach ($data as $key) {

        echo "<tr>
                <td>
                    <input type=\"checkbox\" name=\"jumlah_diagnosa[]\" id=\"history-$key->id_diagnosa\" value=\"$key->id_diagnosa@$key->diagnosa@$key->diagnosa_text\">
                    <label for=\"history-$key->id_diagnosa\"></label>
                </td>
                <td>$key->tgl</td>
                <td>$key->nm_poli</td>
                <td>$key->id_diagnosa</td>
                <td>$key->diagnosa</td>
                <td>$key->diagnosa_text</td>
            </tr>";
        }

        echo "</table>";
    }
        
}
?>