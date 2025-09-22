<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// include(dirname(dirname(__FILE__)).'/Tglindo.php');

// require_once(APPPATH.'controllers/Secure_area.php');
class Ricdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimdaftar');
		$this->load->model('iri/rimpasien');
		$this->load->model('irj/rjmtracer');
		$this->load->model('ird/rdmpelayanan');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimreservasi');
	}
	
	public function index($tipe=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//bikin object buat penanggalan
		$data['controller']=$this; 

		if(!$this->input->post('kode_ruang')){
			$data_daftar['kode_ruang']='-';
		}else{
			$kode_ruang=$this->input->post('kode_ruang');
			if($kode_ruang==''){
				$kode_ruang='-';
			}
			$data_daftar['kode_ruang']=$kode_ruang;
		}
		if(!$this->input->post('kelas')){
			$data_daftar['kelas']='-';
		}else{
			$kelas=$this->input->post('kelas');
			if($kelas==''){
				$kelas='-';
			}
			$data_daftar['kelas']=$kelas;
		}

		if($tipe!='0'){
			$data_list_reservasi_all = $this->rimdaftar->get_irna_antrian_all();
		}else{
			$data_list_reservasi_all = $this->rimdaftar->get_irna_antrian_vk_all();
		}
		
		$data['list_reservasi_all'] = $data_list_reservasi_all;
		
		// $this->load->view('iri/rivlink');
		$this->load->view('iri/list_antrian', $data);
	}

	public function daftar_iri_by_noreg()
	{
		
		$noregasal=$this->input->post('no_reg_asal');
		$data_pasien_daftar_ulang=$this->rdmpelayanan->getdata_daftar_ulang_pasien_ird($noregasal)->row();

		 if($data_pasien_daftar_ulang){
			$data4['timein']=date('Y-m-d H:i:s');
			$data4['status']=2;
			$id1=$this->rjmtracer->update_mappasien($noregasal,$data4);
	
			$count=$this->rimpendaftaran->get_pasien_iri_exist($data_pasien_daftar_ulang->no_medrec)->row()->exist;
			$data_reservasi['tppri']= "rawatjalan";
			if($data_reservasi['tppri']=='rawatjalan' and (int)$count==0 ){
				$count=0;
			}else if($data_reservasi['tppri']=='ruangrawat' and (int)$count==1 ){
				$count=0;
			}
	
			if((int)$count==0){
	
				$datenow=date('Ymd');
				$noreservasi=count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow))+1;
				$data_reservasi['noreservasi']=$datenow.'-'.$noreservasi; // No. Antrian
				$data_reservasi['rujukan']='regional'; // Rujukan
				$data_reservasi['no_medrec']=$data_pasien_daftar_ulang->no_medrec; // No. CM
				$data_reservasi['no_register_asal']=$noregasal; // Kode Reg. Asal
				
				$data_reservasi['tglreserv']=date('Y-m-d H:i:s'); // Tanggal Reservasi
				$data_reservasi['telp']=$data_pasien_daftar_ulang->no_telp; // Telp
				$data_reservasi['hp']=$data_pasien_daftar_ulang->no_hp; // HP
				$data_reservasi['id_poli']=$data_pasien_daftar_ulang->id_poli; // Id Poli
				$data_reservasi['id_dokter']=$data_pasien_daftar_ulang->id_dokter; // Poli asal
				$data_reservasi['dokter']=$data_pasien_daftar_ulang->dokter; // Poli Asal
				$data_reservasi['diagnosa']=$data_pasien_daftar_ulang->diagnosa; // Poli Asal
				$data_reservasi['dikirim_oleh']='Dokter';
				$data_reservasi['dikirim_oleh_teks']=$data_pasien_daftar_ulang->dokter;
				$data_reservasi['tglrencanamasuk']=date('Y-m-d'); // Rencana masuk
				$data_reservasi['pilihan_prioritas']=$this->input->post('pilihan_prioritas'); // Kelas
				$data_reservasi['prioritas']=$this->input->post('prioritas'); // Kelas
				if($this->input->post('infeksi') != null){
					$data_reservasi['infeksi']=$this->input->post('infeksi'); // Infeksi
				}else{
					$data_reservasi['infeksi']='N';
				}
				$data_reservasi['carabayar']=$data_pasien_daftar_ulang->cara_bayar;
				$data_reservasi['statusantrian']='N'; // Keterangan
				$data_reservasi['batal']='N'; // Keterangan
				$login_data = $this->load->get_var("user_info");
				$data_reservasi['user_approve'] = $login_data->username;		
				$roleid= $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;	
				
				$data_reservasi['spri'] = substr($data_reservasi['id_poli'],-2).strval(date('m')).strval(sprintf("%02d", $noreservasi));
	
				$countirna=$this->rimpendaftaran->get_irna_antrian_exist($noregasal)->row()->exist;
				if((int)$countirna==0){
					$id=$this->rimreservasi->insert_reservasi($data_reservasi);	
				}
				
				//update status pulang di daftar_ulang_irj
				$data['tgl_pulang']=date("Y-m-d");
				$data['waktu_pulang'] = date('Y-m-d H:i:s');
				$data['status']=1;
				$data['ket_pulang']='DIRUJUK_RAWATINAP';

				$id=$this->rdmpelayanan->update_pulang($data,$noregasal);
				//

			}
		 }else{
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-times'></i> Data Pasien Tidak Ditemukan!
			</div>");
			redirect('iri/Ricdaftar/index/1');
		 }
		
		$data['list_reservasi_all'] = $this->rimdaftar->get_irna_antrian_by_noreg($noregasal)->result_array();
		$this->load->view('iri/list_antrian',$data);
	}
	
	public function rest_api() { 
		$data_list_reservasi_all = $this->rimdaftar->get_irna_antrian_all();
		$data['list_reservasi_all'] = $data_list_reservasi_all;
		//var_dump($data);
		header('Content-Type: application/json');
		echo json_encode($data_list_reservasi_all);
	}

	public function batal_reservasi($noreservasi){
		//ambil irna antrian
		$data_reservasi = $this->rimdaftar->get_antrian_by_no_reservasi($noreservasi);
		$status_bisa_batal = true;
		//cek semua tindakan yang pernah ada. kalo belum ada tindakan ga boleh batal
		if(substr($data_reservasi[0]['no_register_asal'], 0,2) == "RI"){
			//get pasien RI. ambil no ip sama register asalnya
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data_reservasi[0]['no_register_asal']);
			$no_ipd = $pasien[0]['no_ipd'];
			$no_register_asal = $pasien[0]['noregasal'];
			$data['tglkeluarrg']=NULL;

			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$no_register_asal);
			if(($list_lab_pasien)){
				$status_bisa_batal = false;
			}
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$no_register_asal);//belum ada no_register
			if(($list_radiologi)){
				$status_bisa_batal = false;
			}
			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$no_register_asal);
			if(($list_resep)){
				$status_bisa_batal = false;
			}
		}else{
			$no_ipd = '';
			$no_register_asal = $data_reservasi[0]['no_register_asal'];
		}
		
		/*$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($no_register_asal);
		if(($list_tindakan_ird)){
			$status_bisa_batal = false;
		}
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($no_register_asal);
		if(($poli_irj)){
			$status_bisa_batal = false;
		}*/

		if($status_bisa_batal == true){
			//echo "bisa pulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
			</div>");
			$data['batal']='Y';
			$login_data = $this->load->get_var("user_info");
			$data['xinput'] = $login_data->username;
			$this->rimdaftar->update_reservasi($noreservasi, $data);
			redirect('iri/ricdaftar');
		}else{
			//echo "tidak bisa ulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Reservasi tidak bisa dibatalkan karena sudah ada tindakan yang terinput!
			</div>");
			redirect('iri/ricdaftar');
		}		
	}

	public function batal_mutasi($noreservasi){
		
		//echo "bisa pulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
			</div>");
			$no_reg_asal = $this->rimdaftar->get_noregasal($noreservasi)->row()->no_register_asal;
			$this->rimdaftar->update_mutasi($no_reg_asal);
			$data['batal']='Y';
			$login_data = $this->load->get_var("user_info");
			$data['xinput'] = $login_data->username;
			$this->rimdaftar->update_reservasi($noreservasi, $data);
			redirect('iri/ricdaftar');		
	}

	public function daftar_pasien_verifikasi() {
		$data['title'] = 'Daftar Pasien Sudah Verifikasi';
		$data['controller']=$this; 

		//$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
		//if($tipe_input == ''){
		//$week_akhir = date('Y-m-d', strtotime(date('Y-m-d') . ' +30 day'));
		//$tgl_akhir = date("Y-m-d");
		$data['data_kunjungan']=$this->rimdaftar->get_pasien_terverifikasi();
		
		$this->load->view('iri/list_pasien_terverifikasi',$data);
	}

	public function batal_verif($no_ipd='') {
		$data['verifikasi_plg'] = NULL;
		$this->rimdaftar->update_verifikasi_plg_pasien($no_ipd,$data);

		redirect('iri/ricdaftar/daftar_pasien_verifikasi');
	}
}
