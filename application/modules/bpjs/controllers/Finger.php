<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finger extends Secure_area {

	public function __construct(){
	    parent::__construct();  	            
		$this->load->model('Mbpjs','mbpjs',TRUE);
	    $this->load->library('vclaim');

		$this->xuser = $this->load->get_var("user_info")->username; 

    }

    // create function for return view
    // retrieve data from parameter and pass it to view
    public function index()
    {
        $encodedData = $this->input->get('data');
        $decodedData = base64_decode($encodedData);
        
        // Pass the decoded data to the view
        $data['decodedData'] = json_decode($decodedData);
        $data['title'] = "BPJS - Backdate Kunjungan / Fingerprint";
        $this->load->view('finger/index', $data);
    }

    public function pengajuan_sep()
	{
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		header('Content-type: application/json');
		$data = $this->input->post();
		$param = 'Sep/pengajuanSEP';
		$data = json_encode([
			'request'=>[
				't_sep'=>[
					'noKartu'=>$data['no_kartu_pengajuan'],
					'tglSep'=>$data['tgl_pengajuan_sep'],
					'jnsPelayanan'=>$data['jenis_pelayanan_pengajuan_sep'],
					'jnsPengajuan'=>$data['jenis_pengajuan_pengajuan_sep'],
					'keterangan'=>$data['keterangan_pengajuan_sep'],
					'user'=>$user
				]
			]
		]);
        echo $this->vclaim->post($param,$data);
    }

    // create function for post data to api
    public function submit_finger()
    {
		$login_data = $this->load->get_var("user_info");
        $user = $login_data->username;
        $no_kartu = $this->input->post('no_kartu');
        $tgl_pelayanan = $this->input->post('tgl_pelayanan');
        $jenis_pelayanan = $this->input->post('jenis_pelayanan');
        $jenis_pengajuan = $this->input->post('jenis_pengajuan');
        $keterangan = $this->input->post('keterangan');
        header('Content-type: application/json');
		if($jenis_pengajuan == '3' || $jenis_pengajuan == '4')
		{
			$param = 'Sep/aprovalSEP';
			$jenis_pengajuan = $jenis_pengajuan=='3'?'1':'2';
			$data = [
				'request'=>[
					't_sep'=>[
						'noKartu'=>$no_kartu,
						'tglSep'=>$tgl_pelayanan,
						'jnsPelayanan'=>$jenis_pelayanan,
						'jnsPengajuan'=>$jenis_pengajuan,
						'keterangan'=>$keterangan,
						'user'=>$user
					]
				]
			];
			echo $this->vclaim->post($param,$data);
			return;
		}
        $param = 'Sep/pengajuanSEP';
		$data = [
			'request'=>[
				't_sep'=>[
					'noKartu'=>$no_kartu,
					'tglSep'=>$tgl_pelayanan,
					'jnsPelayanan'=>$jenis_pelayanan,
					'jnsPengajuan'=>$jenis_pengajuan,
					'keterangan'=>$keterangan,
					'user'=>$user
				]
			]
		];
        echo $this->vclaim->post($param,$data);
    }

}