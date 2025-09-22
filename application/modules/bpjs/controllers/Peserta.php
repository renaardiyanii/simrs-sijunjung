<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Peserta extends Secure_area {
	public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

	/**
	 * Rujukan Berdasarkan Nomor Kartu
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/peserta
	 * =========================================================================================
	 *
	 * - nomor => nomor  kartu
	 * - pencarian => nokartu / nik
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/peserta/cari_peserta?pencarian=nokartu&nomor=12312321
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function cari_peserta(){
		header('Content-Type: application/json; charset=utf-8');
		switch($this->input->get('pencarian')){
			case 'nik':
				$url = '/Peserta/'.$this->input->get('pencarian').'/'.$this->input->get('nomor').'/tglSEP/'.date('Y-m-d');
				break;
			case 'nokartu':
				$url = '/Peserta/'.$this->input->get('pencarian').'/'.$this->input->get('nomor').'/tglSEP/'.date('Y-m-d');
				break;
			default:
				$url = '';
				break;
		}
		echo $this->vclaim->get($url);
	}


}

?>
