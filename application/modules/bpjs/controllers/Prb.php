<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prb extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	/**
	 * Menu Rujukan
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rujukan
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/sep/index
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function index(){
        $this->load->view('prb',['title'=>'Pembuatan Rujukan Balik','user'=>$this->load->get_var("user_info")->userid]);
	}

	/**
	 * Example Pemanggilan :
	 * - <ipaddress>/bpjs/prb/insert
	 *
	 */
	public function insert()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		// var_dump($param);die();
		$url = 'PRB/insert';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request":
			{
			"t_prb":
				{  
					"noSep":"'.$param['noSep'].'",
					"noKartu":"'.$param['noKartu'].'",
					"alamat":"'.$param['alamat'].'",
					"email":"'.$param['email'].'",
					"programPRB":"'.$param['programPRB'].'",
					"kodeDPJP":"'.$param['kodeDPJP'].'",
					"keterangan":"'.$param['keterangan'].'",
					"saran":"'.$param['saran'].'",
					"user":"'.$param['user'].'",
					"obat":'.json_encode($param['obat']).'    
					}
				}
			}  '),true);
	   $response = $this->vclaim->post($url,$data);
	// $response = '{"metaData":{"code":"200","message":"Sukses"},"response":{"noSRB":"4842525","noSEP":null,"tglSRB":"2022-09-28","keterangan":"TEST","saran":"test","programPRB":{"kode":"03","nama":"Asthma"},"DPJP":{"kode":"18158","nama":"dr. Ferdhi Adha, MARS, Sp. S"},"peserta":{"noKartu":"0000018458019","nama":"SISMAYETISNA","tglLahir":"1956-11-26","kelamin":"P","noTelepon":"082283149007","email":"testemail@gmail.com","alamat":"test alamat","asalFaskes":{"kode":"03040202","nama":"RASIMAH AHMAD"}},"obat":{"list":[{"nmObat":"Simvastatin tab scored 10 mg","signa":"1 x 2","jmlObat":"12"},{"nmObat":"Analog Insulin Long Acting inj 100 UI\/ml, flexpen 3 ml","signa":"1 x 2","jmlObat":"32"}]}}}';
	   $retObj = json_decode($response);
	   if($retObj->metaData->code == '200'){
			$data_insert = [
				'nosep'=>$param['noSep'],
				'nokartu'=>$param['noKartu'],
				'alamat'=>$param['alamat'],
				'email'=>$param['email'],
				'kodeprogramprb'=>$param['programPRB'],
				'namaprogramprb'=>$retObj->response->programPRB->nama,
				'kodedpjp'=>$param['kodeDPJP'],
				'namadpjp'=>$retObj->response->DPJP->nama,
				'keterangan'=>$param['keterangan'],
				'saran'=>$param['saran'],
				'user'=>$param['user'],
				'obat'=>json_encode($param['obat']),
				'nosrb'=>$retObj->response->noSRB,
				'tglsrb'=>$retObj->response->tglSRB,
				'deleted'=>'0'
			];
			// var_dump($data_insert);die();
			$this->mbpjs->insert_rujukan_prb($data_insert);
	   }
	   echo $response;
	}


	public function delete()
	{
		header('Content-Type: application/json; charset=utf-8');
		$param = $this->input->post();
		$url = 'PRB/Delete';
		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
			"request":
			 {
			"t_prb":
			  {  
				"noSrb":"'.$param['noSrb'].'",
				"noSep":"'.$param['noSep'].'",
				"user": "'.$param['user'].'"
			   }
			 }
		  }'),true);
	   $response = $this->vclaim->delete($url,$data);
	   $retObj = json_decode($response);
	   if($retObj->metaData->code == '200'){
			$this->mbpjs->delete_prb('nosrb',$param['noSrb']);
	   }
	   echo $response;
	}
	
	public function cetak_prb($nosrb,$nosep)
	{
		$url = 'prb/'.$nosrb.'/nosep/'.$nosep;
		$data['prb'] =  json_decode($this->vclaim->get($url));
		if($data['prb']->metaData->code == '200')
		{
			$this->load->view('cetak_prb',$data);
			// $this->load->view('cetak_prb');
			return;
		}
		echo $data['prb']->metaData->message;
	}

}

?>
