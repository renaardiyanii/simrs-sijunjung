<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Kesatuan extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('master/mmkesatuan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Kesatuan';
        $data['kesatuan1']=$this->mmkesatuan->get_kesatuan1()->result();
        $data['kesatuan2']=$this->mmkesatuan->get_kesatuan2()->result();
        $data['kesatuan3']=$this->mmkesatuan->get_kesatuan3()->result();
		$this->load->view('master/mvkesatuan',$data);
	}

	public function get_kesatuan()
    {
        $list = $this->mmkesatuan->get_kesatuan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';			
            $row[] = '<center>'.$count->kst_nama.'</center>'; 
            foreach ($kesatuan as $item) {      
                if ($item->kst2_id == '' && $item->kst3_id == '') {
                    echo '<option value="'.$item->kst_id . '">'.$item->kst_nama.'</option>';
                } else if ($item->kst3_id == '') {
                    echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
                } else {
                    echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
                }                                                   
            }                              
            $row[] = '<center><button onclick="show_edit('.$count->kst_id.')" class="btn btn-xs btn-success text-bold" style="margin-right:3px;" id="btn-load-'.$count->kst_id.'"><i class="fa fa-pencil-square-o"></i></button><button onclick="delete_rl('.$count->kst_id.')" class="btn btn-xs btn-danger text-bold" style="margin-right:3px;"><i class="fa fa-trash"></i></button></center>';			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mmkesatuan->count_all(),
                        "recordsFiltered" => $this->mmkesatuan->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }		

}
