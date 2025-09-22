<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aplicares extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	/**
	 * Fungsi : Referensi Kamar
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/aplicares
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/aplicares/refkamar
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function refkamar(){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'aplicaresws/rest/ref/kelas';
		echo $this->vclaim->get($url,'https://apijkn.bpjs-kesehatan.go.id/');
	}

	// menu 
	public function menu($val='')
	{
		switch($val){
			case 'refkamar':
				$url = 'aplicares/referensikamar';
				break;

			case 'ketersediaankamar':
				$url = 'aplicares/ketersediaankamar';
			default:
				break;
		}
		return $this->load->view($url);
	}

	/**
	 * Fungsi : Melihat Data Ketersediaan Kamar RS 
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/aplicares
	 * =========================================================================================
	 *
	 * Parameter : 
	 * kodeppk : nama atau kode faskes
	 * start : start
	 * limit : limit
	 * 
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/aplicares/ketersediaankamar?start=1&limit=1
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function ketersediaankamar($datatable=''){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'aplicaresws/rest/bed/read/0311R001/'.$this->input->get('start').'/'.$this->input->get('limit');
		// if($datatable!=''){
		// 	$data = json_decode($this->vclaim->get($url,'https://apijkn.bpjs-kesehatan.go.id/'));
		// 	echo json_encode(['data'=>$data->response->list]);
		// 	return;
		// }
		echo $this->vclaim->get($url,'https://apijkn.bpjs-kesehatan.go.id/');
	}
	

	/**
	 * Fungsi : Update Ketersediaan Tempat Tidur 
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/aplicares
	 * =========================================================================================
	 *
	 * Method : POST
	 * Format : Json
	 * 
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/aplicares/updatetempattidur
	 * 
	 * kodekelas: kode kelas ruang rawat sesuai dengan mapping BPJS Kesehatan
	 * koderuang: kode ruangan Rumah Sakit
	 * namaruang: nama ruang rawat Rumah Sakit
	 * kapasitas: Kapasitas ruang Rumah Sakit
	 * tersedia: Jumlah tempat tidur yang kosong / dapat ditempati pasien baru
	 * 
	 * * Untuk Rumah Sakit yang ingin mencantumkan informasi ketersediaan tempat tidur untuk pasien laki – laki, perempuan, laki – laki atau perempuan
	 * 
	 * tersediapria : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru laki – laki
	 * Tersediawanita : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru perempuan
	 * tersediapriawanita : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru laki – laki atau perempuan
	 * 
	 * 
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function updatetempattidur(){
		header('Content-Type: application/json; charset=utf-8');
        $url = 'aplicaresws/rest/bed/update/0311R001';
        $param = $this->input->post();

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{ 
			"kodekelas":"'.$param['kodekelas'].'", 
			"koderuang":"'.$param['koderuang'].'", 
			"namaruang":"'.$param['namaruang'].'", 
			"kapasitas":"'.$param['kapasitas'].'", 
			"tersedia":"'.$param['tersedia'].'",
			"tersediapria":"'.$param['tersediapria'].'", 
			"tersediawanita":"'.$param['tersediawanita'].'", 
			"tersediapriawanita":"'.$param['tersediapriawanita'].'"
		}
          '),true);
		// var_dump($data);die();

        $response = $this->vclaim->post($url,$data,[],'https://apijkn.bpjs-kesehatan.go.id/');
        echo $response;
	}

	/**
	 * Fungsi : Insert Ruangan Baru 
	 * Method : POST
	 * Parameter :
	 * kodekelas: kode kelas ruang rawat sesuai dengan mapping BPJS Kesehatan
	 * koderuang: kode ruangan Rumah Sakit
	 * namaruang: nama ruang rawat Rumah Sakit
	 * kapasitas: Kapasitas ruang Rumah Sakit
	 * tersedia: Jumlah tempat tidur yang kosong / dapat ditempati pasien baru
	 * 
	 * * Untuk Rumah Sakit yang ingin mencantumkan informasi ketersediaan tempat tidur untuk pasien laki – laki, perempuan, laki – laki atau perempuan
	 * tersediapria : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru laki – laki
	 * Tersediawanita : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru perempuan
	 * tersediapriawanita : Jumlah tempat tidur yang kosong / dapat ditempati pasien baru laki – laki atau perempuan
	 * 
	 ** feel free to ask
	 * dev.aldihadistian@gmail.com
	 */

	public function ruanganbaru(){
		header('Content-Type: application/json; charset=utf-8');
        $url = 'aplicaresws/rest/bed/create/0311R001';
        $param = $this->input->post();
		// var_dump($param);die();
        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{ 
			"kodekelas":"'.$param['kodekelas'].'", 
			"koderuang":"'.explode('@',$param['koderuang'])[0].'", 
			"namaruang":"'.$param['namaruang'].'", 
			"kapasitas":"'.$param['kapasitas'].'", 
			"tersedia":"'.$param['tersedia'].'",
			 "tersediapria":"'.$param['tersediapria'].'", 
			"tersediawanita":"'.$param['tersediawanita'].'", 
			"tersediapriawanita":"'.$param['tersediapriawanita'].'"
		   }
          '),true);
        $response = $this->vclaim->post($url,$data,[],'https://apijkn.bpjs-kesehatan.go.id/');
        echo $response;
	}

	/**
	 * Fungsi : Hapus Ruangan 
	 * Method : POST
	 * Parameter :
	 * kodekelas: kode kelas ruang rawat sesuai dengan mapping BPJS Kesehatan
	 * koderuang: kode ruangan Rumah Sakit
	 * 
	 ** feel free to ask
	 * dev.aldihadistian@gmail.com
	 */

	public function hapusruangan(){
		header('Content-Type: application/json; charset=utf-8');
        $url = 'aplicaresws/rest/bed/delete/0311R001';
        $param = $this->input->post();

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{ 
			"kodekelas":"'.$param['kodekelas'].'", 
			"koderuang":"'.$param['koderuang'].'"
		}'),true);

        $response = $this->vclaim->post($url,$data,[],'https://apijkn.bpjs-kesehatan.go.id/');
        echo $response;
	}

	// bot untuk hapus semua ruangan
	public function bothapusruangan()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'aplicaresws/rest/bed/read/0311R001/' . '0'. '/' . '100';
		$data =  $this->vclaim->get($url, 'https://apijkn.bpjs-kesehatan.go.id/');
		$data_decode = json_decode($data);
		$url = 'aplicaresws/rest/bed/delete/0311R001';
		foreach($data_decode->response->list as $v){
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
			{ 
				"kodekelas":"' . $v->kodekelas . '", 
				"koderuang":"' . $v->koderuang . '"
			}'), true);
			$this->vclaim->post($url, $data, [], 'https://apijkn.bpjs-kesehatan.go.id/');
		}
	}

	// bot untuk add semua ruangan
	public function botaddsemuaruangan()
	{
		header('Content-Type: application/json; charset=utf-8');
        $url = 'aplicaresws/rest/bed/create/0311R001';
		
		$bed_rs = $this->mbpjs->get_bed()->result();
		foreach($bed_rs as $v){
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
			{ 
				"kodekelas":"'.$v->kodekelas.'", 
				"koderuang":"'. $v->koderuang.'", 
				"namaruang":"'.$v->nmruang.'", 
				"kapasitas":"'.$v->kapasitas.'", 
				"tersedia":"'.($v->kosong=='-1'?'0':$v->kosong).'",
				"tersediapria":"'.'0'.'", 
				"tersediawanita":"'.'0'.'", 
				"tersediapriawanita":"'.($v->kosong=='-1'?'0':$v->kosong).'"
			   }
			  '),true);
			$response = $this->vclaim->post($url,$data,[],'https://apijkn.bpjs-kesehatan.go.id/');
		}
	}

	public function masukKeluarBed($idrg,$kelas)
	{
		header('Content-Type: application/json; charset=utf-8');
		

		$bed = $this->mbpjs->get_bed_idrg($idrg,$kelas)->row();

		$url = 'aplicaresws/rest/bed/update/0311R001';

		$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
		{ 
			"kodekelas":"' . $bed->kodekelas . '", 
			"koderuang":"' . $bed->koderuang . '", 
			"namaruang":"' . $bed->nmruang . '", 
			"kapasitas":"' . $bed->kapasitas . '", 
			"tersedia":"' . $bed->kosong . '",
			"tersediapria":"' . '0' . '", 
			"tersediawanita":"' . '0' . '", 
			"tersediapriawanita":"' . $bed->kosong . '"
		}
          '), true);
		$response = $this->vclaim->post($url, $data, [], 'https://apijkn.bpjs-kesehatan.go.id/');
		echo $response;
	}

	public function updateterkini()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = 'aplicaresws/rest/bed/update/0311R001';
		$bed_rs = $this->mbpjs->get_bed()->result();
		foreach ($bed_rs as $v) {
			$data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
			{ 
				"kodekelas":"' . $v->kodekelas . '", 
				"koderuang":"' . $v->koderuang . '", 
				"namaruang":"' . $v->nmruang . '", 
				"kapasitas":"' . $v->kapasitas . '", 
				"tersedia":"' . ($v->kosong == '-1'?'0':$v->kosong) . '",
				"tersediapria":"' . '0' . '", 
				"tersediawanita":"' . '0' . '", 
				"tersediapriawanita":"' . ($v->kosong == '-1' ? '0' : $v->kosong) . '"
			}
			'), true);
			$response = $this->vclaim->post($url, $data, [], 'https://apijkn.bpjs-kesehatan.go.id/');
		}
		echo $response;
	}

}

?>
