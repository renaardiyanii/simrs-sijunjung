<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Datatable extends Secure_area {
	public function __construct() {
			parent::__construct();			
            $this->load->helper('tgl_indo');
            $this->load->model('kepegawaian/M_datatable','',TRUE);			
	}

    public function pendidikan_umum()
    {
        $list = $this->M_datatable->pendidikan_umum();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $count->pendidikan;
            $row[] = $count->tmpt_pendidikan;  
            $row[] = $count->jurusan;
            $row[] = '<center>'.$count->th_lulus.'</center>';		                        
            $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit" onclick="edit_pendumum('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete" onclick="delete_pendumum('.$count->id.')"><i class="ti-trash"></i></a></center>';			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_datatable->pendidikan_umum_count(),
                        "recordsFiltered" => $this->M_datatable->pendidikan_umum_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function pendidikan_militer()
    {
        $list = $this->M_datatable->pendidikan_militer();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $count->pendidikan;
            $row[] = '<center>'.$count->th_lulus.'</center>';                                
            $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="Edit" data-original-title="Edit" onclick="edit_pendmiliter('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Edit" data-toggle="tooltip" data-original-title="Delete" onclick="delete_pendmiliter('.$count->id.')"><i class="ti-trash"></i></a></center>';            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_datatable->pendidikan_militer_count(),
                        "recordsFiltered" => $this->M_datatable->pendidikan_militer_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function pangkat()
    {
        $list = $this->M_datatable->pangkat();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $count->pangkat;
            $row[] = '<center>'.$count->tmt_pangkat.'</center>';                                
            $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit" onclick="edit_pangkat('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete" onclick="delete_pangkat('.$count->id.')"><i class="ti-trash"></i></a></center>';            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_datatable->pangkat_count(),
                        "recordsFiltered" => $this->M_datatable->pangkat_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function jabatan()
    {
        $list = $this->M_datatable->jabatan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $count->jabatan;
            $row[] = '<center>'.$count->tmt_jabatan.'</center>';                                
            $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit" onclick="edit_jabatan('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete" onclick="delete_jabatan('.$count->id.')"><i class="ti-trash"></i></a></center>';            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_datatable->jabatan_count(),
                        "recordsFiltered" => $this->M_datatable->jabatan_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function tanda_jasa()
    {
        $list = $this->M_datatable->tanda_jasa();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $count->tanda_jasa;                                          
            $row[] = '<center><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit" onclick="edit_tandajasa('.$count->id.')"><i class="ti-marker-alt"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete" onclick="delete_tandajasa('.$count->id.')"><i class="ti-trash"></i></a></center>';            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_datatable->tandajasa_count(),
                        "recordsFiltered" => $this->M_datatable->tandajasa_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }	


    public function show_personil(){
        $data_personil=$this->M_datatable->get_personil();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_personil as $personil) {
            $no++;
            $row = array();
            $row[] = '<h6 class="text-center">'.$no.'</h6>';
            if (is_null($personil->foto) || $personil->foto == '') {
                $row[] = '<span class="round" style="background:url(\''.base_url()."upload/personil/unknown.png".'\') center center no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"></span>';
            } else $row[] = '<span class="round" style="background:url(\''.base_url()."upload/personil/".$personil->foto.'\') center center no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"></span>';            
            
            $row[] = '<h6>'.$personil->nama.'</h6><small class="text-muted">'.date_indo(date('Y-m-d',strtotime($personil->tgl_lahir))).'</small>';
            $row[] = '<h6>'.$personil->nip_nrp.'</h6>';
            $row[] = '<h6>'.$personil->pangkat.'</h6>';
            $row[] = '<h6>'.$personil->jabatan.'</h6>'; 
            $row[] = '<h6>'.$personil->alamat.'</h6>';                           
            $row[] = $personil->id;                       
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_datatable->personil_count_all(),
            "recordsFiltered" => $this->M_datatable->personil_count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }			
                  		
}
?>
