<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
	}
	
	function index()
	{	  
		$data['title'] = 'Login RSUD Sijunjung'; 
		if($this->M_user->is_logged_in())
		{
			redirect('beranda');
		}
		else
		{
			$this->form_validation->set_rules('username', 'Username', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['list']=$this->M_user->get_all()->result();
				$this->load->view('login',$data);
			}
			else
			{	$role_id=$this->M_user->get_role_id()->row();
				if ($role_id->roleid == 37) {
					redirect('dashboard');
				} else if ($role_id->roleid == 30) {
					redirect('inacbg/pasien');
				} else if ($role_id->roleid == 29) {
					redirect('kepegawaian/personil');
				} else redirect('beranda');
			}
		}
		
	}

	function hashData($data)
	{
		$privateKey     = '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
		$secretKey      = '1b2532b238123b129'; // user define secret key
		$encryptMethod  = "AES-256-CBC";
		$string     = $data; // user define value

		$key     = hash('sha256', $privateKey);
		$ivalue  = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
		$result      = openssl_encrypt($string, $encryptMethod, $key, 0, $ivalue);
		$output = base64_encode($result);  // output is a encripted value
		return $output;
	}

	// function bot_change_password()
	// {
	// 	$datas = $this->M_user->get_all()->result();
	// 	foreach($datas as $v){
	// 		$this->M_user->update([
	// 			'vpassword'=>$this->hashData($v->password),
	// 			'vuserid'=>$v->userid
	// 		]);
	// 	}
	// 	echo json_encode(['ok'=>'ok']);
	// 	// var_dump();
	// }

	function login_check($username)
	{
		$password = $this->hashData($this->input->post("password"));
		
		if(!$this->M_user->login($username,$password))
		{
			$this->form_validation->set_message('login_check', '<p style="color:red;">Username/Password salah!</p>');
			return false;
		}
		return true;		
	}

	function ajax_check() {
		if($this->M_user->is_logged_in()) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}
}

?>