<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
class Mckaru extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmkaru','',TRUE);
		$this->load->helper(array('html','url')); 
	}

	public function index(){
		$data['title'] = 'Master Kepala Ruangan';
        $data = [
            'karu'=>$this->mmkaru->get_all()->result(),
            'ruangan'=>$this->mmkaru->get_ruangan()->result(),
            'user'=>$this->mmkaru->get_user()->result()
        ];
		$this->load->view('master/mvkaru',$data);
	}

    public function transaction($method = "",$id_delete='')
    {
        $payload = $this->input->post();
        if(isset($payload['userid'])){
            $payload['userid'] = intval($payload['userid']);
        }
        switch($method){
            case 'insert':
                $res = $this->mmkaru->insert($payload);
                break;
            case 'update_by_userid':
                $res = $this->mmkaru->update_by_userid($payload['userid'],$payload);
                break;
            case 'update_by_idrg':
                $res = $this->mmkaru->update_by_idrg($payload['idrg'],$payload);
                break;
            case 'update_by_id':
                unset($payload['userid']);
                $res = $this->mmkaru->update_by_id($payload['id'],$payload);
                break;
            case 'delete':
                $res = $this->mmkaru->delete($id_delete);
                break;
            default:
                break;
        }
        echo json_encode([
            'code'=>$res?200:400
        ]);
    }
}
