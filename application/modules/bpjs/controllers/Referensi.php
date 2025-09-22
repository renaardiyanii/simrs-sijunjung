<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Referensi extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	public function referensi_kamar()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = '/aplicaresws/rest/ref/kelas';
		echo $this->vclaim->get($url, 'https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev');
	}

	/**
	 * Dokter DPJP (Pencarian Data Untuk DPJP Layan)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * - pelayanan => 1. Ranap / 2. Rajal
	 * - tglpelayanan => YYYY-mm-dd
	 * - spesialis => ex : SAR / INT / 018
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan=2022-09-04&spesialis=SAR
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */

	 public function dokter_pjp($jenis_pelayanan,$spesialis)
    {
		return referensi($this->child.'dokter/pelayanan/'.$jenis_pelayanan.'/tglPelayanan/'.date('Y-m-d').'/Spesialis/'.$spesialis);
    }
	public function dokter_dpjp(){
		header('Content-Type: application/json; charset=utf-8');
		$tglpelayanan = date('Y-m-d');
		if($this->input->get('tglpelayanan')){
			$tglpelayanan = $this->input->get('tglpelayanan');
		}
		if($this->input->get('namaspesialis')){
			$spesialis = $this->mbpjs->getkodebpjsberdasarkannama($this->input->get('namaspesialis'));
			if($spesialis){
				$spesialis = $spesialis->poli_bpjs;
				$url = '/referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/'.$spesialis;
				echo $this->vclaim->get($url);
				return;
			}
			$url = '/referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/';
			echo $this->vclaim->get($url);	
			return;
		}
		$url = '/referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/'.$this->input->get('spesialis');
		echo $this->vclaim->get($url);
	}

	public function cari_dokter_hfis(){
		header('Content-Type: application/json; charset=utf-8');
		$tglpelayanan = date('Y-m-d');
		if($this->input->get('tglpelayanan')){
			$tglpelayanan = $this->input->get('tglpelayanan');
		}
		if($this->input->get('namaspesialis')){
			$spesialis = $this->mbpjs->getkodebpjsberdasarkannama($this->input->get('namaspesialis'));
			if($spesialis){
				$spesialis = $spesialis->poli_bpjs;
				$url = '/referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/'.$spesialis;
				echo $this->vclaim->get($url);
				return;
			}
			$url = '/referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/';
			echo $this->vclaim->get($url);	
			return;
		}
		$url = 'referensi/dokter/pelayanan/'.$this->input->get('pelayanan').'/tglPelayanan/'.$tglpelayanan.'/Spesialis/'.$this->input->get('spesialis');
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi Provinsi (Pencarian Data Untuk Provinsi)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/provinsi
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function provinsi(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/propinsi';
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi Kabupaten (Pencarian Data Untuk Kabupaten)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/kabupaten?provinsi=<Kodeprovinsi>
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function kabupaten(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/kabupaten/propinsi/'.$this->input->get('provinsi');
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi Kecamatan (Pencarian Data Untuk Kecamatan)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/kecamatan?kabupaten=<Kodekabupaten>
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function kecamatan(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/kecamatan/kabupaten/'.$this->input->get('kabupaten');
		echo $this->vclaim->get($url);
	}

	public function kelurahan(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/kelurahan/kecamatan/'.$this->input->get('kecamatan');
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi ruangrawat (Pencarian Data Untuk ruangrawat)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/ruangrawat
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function ruangrawat(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/ruangrawat';
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi kelasrawat (Pencarian Data Untuk kelasrawat)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/kelasrawat
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function kelasrawat(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/kelasrawat';
		echo $this->vclaim->get($url);
	}

	
	/**
	 * Referensi spesialistik (Pencarian Data Untuk spesialistik)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/spesialistik
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function spesialistik(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/spesialistik';
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi carakeluar (Pencarian Data Untuk carakeluar)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/carakeluar
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function carakeluar(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/carakeluar';
		echo $this->vclaim->get($url);
	}

	/**
	 * Referensi pascapulang (Pencarian Data Untuk pascapulang)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/pascapulang
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function pascapulang(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/pascapulang';
		echo $this->vclaim->get($url);
	}

	

	public function poliklinik() {   
        if (isset($_GET['q'])) {
			$url = 'referensi/poli/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->poli as $row) {
                    $new_row['id'] = $row->kode;
                    $new_row['text'] = $row->nama;                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }

	public function diagnosa_select2() {   
        if (isset($_GET['q'])) {
			$url = 'referensi/diagnosa/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->diagnosa as $row) {
                    $new_row['id'] = $row->kode;
                    $new_row['text'] = $row->nama;                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }

	public function faskes_select2() {   
		// var_dump($this->input->get('q')['term']);
		// die();
        if (isset($_GET['q'])) {
			$url = 'referensi/faskes/'.$this->input->get('q')['term'].'/'.$this->input->get('asal_rujukan');
			// var_dump($url);die();
			$result = $this->vclaim->get($url);
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->faskes as $row) {
					$new_row['id'] = $row->kode;
					$new_row['text'] = $row->nama;
					$row_set[] = $new_row;
				}
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }
	

	public function refpoliklinik() {   
        if (isset($_GET['q'])) {
			$url = 'referensi/poli/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			echo $result;                                                                          
        } else echo json_encode([]);    
    }

	public function procedure() {   
        if (isset($_GET['q'])) {
			$url = 'referensi/procedure/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->procedure as $row) {
                    $new_row['id'] = $row->kode;
                    $new_row['text'] = $row->nama;                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);    
    }

	
	/**
	 * Referensi pascapulang (Pencarian Data Untuk pascapulang)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/referensi
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/referensi/pascapulang
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function dokterdpjp_lpk(){
		if (isset($_GET['q'])) {
			$url = 'referensi/dokter/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			// var_dump($result);die();
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->procedure as $row) {
                    $new_row['id'] = $row->kode;
                    $new_row['text'] = $row->nama;                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]);
	}

	public function diagnosaprb()
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/diagnosaprb';
		echo $this->vclaim->get($url);
	}

	public function obatprb()
	{
		header('Content-Type: application/json; charset=utf-8');

		if (isset($_GET['q'])) {
			$url = 'referensi/obatprb/'.$this->input->get('q');
			$result = $this->vclaim->get($url);
			$result = json_decode($result);          
            if ($result->metaData->code != '200') {
                echo json_encode([]);                   
            } else {             
				                       
                foreach ($result->response->list as $row) {
                    $new_row['id'] = $row->kode;
                    $new_row['text'] = $row->nama;                 
                    $row_set[] = $new_row;
                }
                echo json_encode($row_set);                     
            }                                                                                   
        } else echo json_encode([]); 
	}

	public function diagnosa($diagnosa)
	{
		header('Content-Type: application/json; charset=utf-8');
		$url = '/referensi/diagnosa/'.$diagnosa;
		echo $this->vclaim->get($url);
	}

	public function get_bpjs_by_id_poli($id_poli)
	{
		header('Content-Type: application/json; charset=utf-8');
		$poli = $this->mbpjs->get_poli_bpjs($id_poli);
		echo json_encode(['poli_bpjs'=>$poli->poli_bpjs??'']);
	}
}

?>
