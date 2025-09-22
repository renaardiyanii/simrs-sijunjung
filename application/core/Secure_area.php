<?php
class Secure_area extends CI_Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	

		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/M_log','',TRUE);
		// $this->load->model('admin/M_Datatables','',TRUE);

		if(!$this->M_user->is_logged_in())
		{
			redirect('user/login');
		}
		
		$url = $this->uri->uri_string();
		
		if(!($this->M_user->has_permission($url,$this->M_user->get_logged_in_user_info()->userid)))
		{
			redirect('no_access');
		}
		
		$data['user'] = $this->session->userdata('userid');
		$data['ip'] = $this->input->ip_address();
		$data['url'] = $this->uri->segment(1) . "/" . $this->uri->segment(2);
		$data['body'] = $this->input->raw_input_stream;
		$data['date'] = date("Y-m-d H:i:s");
		$this->M_log->insert($data);


		//load up global data
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		$user_dokter = $this->M_user->get_user_dokter($data['user'])->row();
		$user_ppa = $this->M_user->get_user_ppa($data['user'])->row();
		$role_id = $this->M_user->get_role_id()->row()->roleid;
		//$data['allowed_modules']=$this->Module->get_allowed_modules($logged_in_employee_info->person_id);
		$data['user_info']=$logged_in_user_info;
		$data['user_ppa'] = $user_ppa;
		$data['user_dokter_info'] = $user_dokter;
		$data['role_id']=$role_id;
		$this->load->vars($data);
	}

	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
	');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
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

	function decryptData($data)
	{
		$privateKey     = '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
		$secretKey      = '1b2532b238123b129'; // user define secret key
		$encryptMethod  = "AES-256-CBC";
		$stringEncrypt  = $data; // user encrypt value
		$key    = hash('sha256',
			$privateKey
		);
		$ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
		$output = openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
		return $output;
		// output is a decripted value
	}

	
	public function hari($inp)
	{
		if ($inp == 1)
		{
			return "Senin ";
		}
		else if ($inp == 2)
		{
			return "Selasa ";
		}
		else if ($inp == 3)
		{
			return "Rabu ";
		}
		else if ($inp == 4)
		{
			return "Kamis ";
		}
		else if ($inp == 5)
		{
			return "Jumat ";
		}
		else if ($inp == 6)
		{
			return "Sabtu ";
		}
		else if ($inp == 7)
		{
			return "Minggu ";
		}		
		else
		{
			return "";
		}
	}

	public function bulan($inp)
	{
		if ($inp == 1)
		{
			return "Januari ";
		}
		else if ($inp == 2)
		{
			return "Februari ";
		}
		else if ($inp == 3)
		{
			return "Maret ";
		}
		else if ($inp == 4)
		{
			return "April ";
		}
		else if ($inp == 5)
		{
			return "Mei ";
		}
		else if ($inp == 6)
		{
			return "Juni ";
		}
		else if ($inp == 7)
		{
			return "July ";
		}
		else if ($inp == 8)
		{
			return "Agustus ";
		}
		else if ($inp == 9)
		{
			return "September ";
		}
		else if ($inp == 10)
		{
			return "Oktober ";
		}
		else if ($inp == 11)
		{
			return "November ";
		}
		else if ($inp == 12)
		{
			return "Desember ";
		}				
		else
		{
			return "";
		}
	}	
	
	
	public function tgl_indo($d='',$m='',$y='')
	{
		//
	}
}


?>