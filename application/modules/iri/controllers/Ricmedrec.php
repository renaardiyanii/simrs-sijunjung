<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// include(dirname(dirname(__FILE__)).'/Tglindo.php');

// require_once(APPPATH.'controllers/Secure_area.php');
class Ricmedrec extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimlaporan');
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	//keperluan tanggal
	public function obj_tanggal(){
		//  $tgl_indo = new Tglindo();
		 return $this->tgl_indo();
	}

	public function index(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
		//bikin object buat penanggalan
		$data['controller']=$this; 

		//ambil data di pasien iri, ambil yang diagnosa1 nya masih kosong selama seminggu
		//buat awal
		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = substr($this->input->post('tgl_akhir'),0,10);
		$tgl_akhir = substr($this->input->post('tgl_akhir'),13,23);
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		// added for karu
		$login_data = $this->load->get_var("user_info");
		$ruangan = $this->rimpasien->load_ruangan_user($login_data->userid);
		$list_ruang = '';
		foreach($ruangan as $key=>$ruang){
			$list_ruang.='\''.$ruang->idrg.'\',';
			if ($key === array_key_last($ruangan)) {
				$list_ruang.='\''.$ruang->idrg.'\'';
				
			}
		}
		// var_dump($list_ruang);die();
		if($login_data->userid == 1){
			$admin = 1;
		}
		else{
			$admin = 0;
		}

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$data['week_akhir'] =  date("Y-m-d");
			$data['week_awal'] =  date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
			$week_akhir = date("Y-m-d");
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($tgl_awal,6,2);
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date($week_awal,$week_akhir,$list_ruang,$admin)->result_array();
		}

		if($tipe_input == 'TGL'){
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;			
			$tanggal_awal = substr($tgl_awal,8,2);
			$bulan_awal = substr($tgl_awal,6,2);
			$tahun_awal = substr($tgl_awal,0,4);
			$tanggal_akhir = substr($tgl_akhir,8,2);
			$bulan_akhir = substr($tgl_akhir,6,2);
			$tahun_akhir = substr($tgl_akhir,0,4);
			$data['date_start'] = $tanggal_awal." ".$bulan_awal." ".$tahun_awal;
			$data['date_end'] = $tanggal_akhir." ".$bulan_akhir." ".$tahun_akhir;
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date($tgl_awal,$tgl_akhir,$list_ruang,$admin)->result_array();
			// print_r($data['list_medrec']);exit;			
		}

		if($tipe_input == 'BLN'){
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $bulan;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($bulan,6,2);
			$data['tahun_show'] = substr($bulan,0,4);
			$data['list_medrec'] = $this->rimpasien->get_empty_diagnosa_by_month($bulan,$list_ruang);			
		}

		if($tipe_input == 'THN'){
			$data['list_medrec'] = $this->rimpasien->get_medrec_year($tahun,$list_ruang);
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['tahun_show'] = $tahun;
			// print_r($data['list_medrec']);exit;

		}

		//print_r($data['list_medrec']);exit;
		
		// $this->load->view('iri/rivlink');
		//$this->load->view('iri/list_antrian', $data);
		$data['userid'] = $login_data->userid;
		$this->load->view('iri/list_medrec', $data);
	}

	public function by_medrec() {
		$data['controller']=$this; 
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
		$data['userid'] = $login_data->userid;
		if($this->input->post('search_per') == 'cm'){
			$medrec = $this->input->post('medrec');
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date_by_medrec($medrec)->result_array();
		}else {
			$dateRange = $this->input->post('tanggal_laporan');
			$dates = explode(' - ', $dateRange);
			$startDate = $dates[0];
			$endDate = $dates[1];
			$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
			$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
			$data['tgl'] = $startDateObj->format('Y-m-d');
			$data['tgl1'] = $endDateObj->format('Y-m-d');
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date_by_tgl($data['tgl'],$data['tgl1'])->result_array();
		}

		$this->load->view('iri/list_medrec_by_cm', $data);
	}

	public function lap_keluar_iri(){
		$data['title'] = 'Pasien Keluar IRI';
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

		//ambil data di pasien iri, ambil yang diagnosa1 nya masih kosong selama seminggu
		//buat awal
		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_akhir = date("Y-m-d");
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($tgl_awal,6,2);
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_date($tgl_akhir);
			
			//print_r($data['list_medrec'][0]);exit;
		}

		if($tipe_input == 'TGL'){
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($tgl_awal,6,2);
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_date($tgl_akhir);
			
		}

		if($tipe_input == 'BLN'){
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $bulan;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($bulan,6,2);
			$data['tahun_show'] = substr($bulan,0,4);
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_month($bulan);
			
		}

		if($tipe_input == 'THN'){
			$data['list_medrec'] = $this->rimpasien->get_discharge_patient_by_year($tahun);

		}

		//print_r($data['list_medrec']);exit;
		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/list_antrian', $data);
		$this->load->view('iri/list_medrec_keluar', $data);
	}

	public function lengkapi_medrec($no_ipd=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		//print_r($data['data_pasien']);exit;

		// $this->load->view('iri/rivlink');
		//$this->load->view('iri/lengkapi_form_resume', $data);
		$this->load->view('iri/form_resume', $data);
	}

	public function list_pasien_masuk() {
		$data['title'] = 'List Pasien Masuk Rawat Inap';
		$data['week_akhir'] =  date("Y-m-d");
		$data['week_awal'] =  date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
		$week_akhir = date("Y-m-d");
		// $tgl_indo = new Tglindo();
		// $data['tgl'] = $tgl_akhir;
		// $data['type'] = $tipe_input;
		// $data['bulan_show'] = substr($tgl_awal,6,2);
		// $data['tahun_show'] = substr($tgl_awal,0,4);
		// $data['tanggal_show'] = substr($tgl_awal,8,2);
		$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
		$data['list_masuk'] = $this->rimlaporan->get_list_pasien_masuk($week_awal,$week_akhir)->result();
		$this->load->view('iri/list_pasien_masuk', $data);
	}
	
	public function list_pasien_masuk_by_medrec() {
		$data['title'] = 'List Pasien Masuk Rawat Inap';
		$data['week_akhir'] =  date("Y-m-d");
		$data['week_awal'] =  date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
		$week_akhir = date("Y-m-d");
		$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
		$medrec = $this->input->post('medrec');
		$data['list_masuk'] = $this->rimlaporan->get_list_pasien_masuk_by_medrec($medrec)->result();
		$this->load->view('iri/list_pasien_masuk', $data);
	}

	public function list_pasien_mutasi() {
		$data['title'] = 'List Pasien Masuk Rawat Inap';
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		if($tgl_awal == '' && $tgl_akhir == '') {
			$data['week_akhir'] = date("Y-m-d");
			$data['week_awal'] = date('Y-m-d');
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date('Y-m-d');
			$data['list_mutasi'] = $this->rimlaporan->get_list_pasien_mutasi($tgl_awal,$tgl_akhir)->result();
		} else {
			$data['week_akhir'] = $tgl_awal;
			$data['week_awal'] = $tgl_akhir;
			$data['list_mutasi'] = $this->rimlaporan->get_list_pasien_mutasi($tgl_awal,$tgl_akhir)->result();
		}
		$this->load->view('iri/list_pasien_mutasi', $data);
	}

	public function get_detail_mutasi() {
		$no_register = $this->input->post('no_register');

        $line   = array();
        $line2  = array();
        $row2   = array();

        $hasil = $this->rimlaporan->get_data_detail_mutasi($no_register)->result();
        foreach ($hasil as $value) {
            $row2['no_register'] = $value->no_ipd;
            $row2['nama'] = $value->nama;
			$row2['ruang'] = $value->nmruang;
            $row2['kelas'] = $value->kelas;
			$row2['tgl_masuk'] = $value->tglmasukrg;
			$row2['tgl_keluar'] = $value->tglkeluarrg;
            $row2['status'] = $value->statkeluarrg;

            $line2[] = $row2;
        }

        $line['data'] = $line2;
      
        echo json_encode($line);
	}

	public function data_lengkap($no_ipd) {
		$data['lengkap'] = 1;
		$data['tgl_dilengkapi'] = date("Y-m-d H:i:s");
		$data['kelengkapan_rm'] = 'Lengkap ≤ 24 jam';
		$this->rimpasien->update_data_lengkap($no_ipd, $data);
		redirect('iri/ricmedrec');
	}

	public function data_tidak_lengkap($no_ipd) {
		$data['lengkap'] = 2;
		$data['tgl_dilengkapi'] = date("Y-m-d H:i:s");
		$data['kelengkapan_rm'] = 'Tdk Lkp ≤ 24 jam';
		$this->rimpasien->update_data_tidak_lengkap($no_ipd, $data);
		redirect('iri/ricmedrec/list_tdk_lengkap');
	}

	public function save_tidak_lengkap(){
		$no_ipd = $this->input->post('noregg');
		$data['lengkap'] = 2;
		$data['ket_tdk_lengkap'] = $this->input->post('ket');
		// $data['tgl_dilengkapi'] = date("Y-m-d H:i:s");
		$this->rimpasien->update_data_tidak_lengkap($no_ipd, $data);
		redirect('iri/ricmedrec');
	}


	public function list_tdk_lengkap(){
		$data['controller']=$this; 
		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = substr($this->input->post('tgl_akhir'),0,10);
		$tgl_akhir = substr($this->input->post('tgl_akhir'),13,23);
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		// added for karu
		$login_data = $this->load->get_var("user_info");
		$ruangan = $this->rimpasien->load_ruangan_user($login_data->userid);
		$list_ruang = '';
		foreach($ruangan as $key=>$ruang){
			$list_ruang.='\''.$ruang->idrg.'\',';
			if ($key === array_key_last($ruangan)) {
				$list_ruang.='\''.$ruang->idrg.'\'';
				
			}
		}
		// var_dump($list_ruang);die();
		if($login_data->userid == 1){
			$admin = 1;
		}
		else{
			$admin = 0;
		}

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$data['week_akhir'] =  date("Y-m-d");
			$data['week_awal'] =  date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
			$week_akhir = date("Y-m-d");
			// $tgl_indo = new Tglindo();
			$data['tgl'] = $tgl_akhir;
			$data['type'] = $tipe_input;
			$data['bulan_show'] = substr($tgl_awal,6,2);
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			$week_awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
			$data['list_medrec'] = $this->rimpasien->get_medrec_range_date_tdk_lengkap($week_awal,$week_akhir,$list_ruang,$admin)->result_array();
		}
		$data['userid'] = $login_data->userid;
		$this->load->view('iri/list_medrec_tdk_lengkap', $data);
	}


	public function list_kelengkapan_rm() { 
		$tipe_input = $this->input->post('tampil_per');
		$date = $this->input->post('date_days');
		$month = $this->input->post('date_months');
	
		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == 'TGL') {
			$data['title'] = 'Laporan Pengembalian Rekam Medik Lengkap '.date("d F Y", strtotime($date));
			$data['date'] = $date;
			$data['date_title'] = date("d F Y", strtotime($date));
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimpasien->get_data($date, $tipe_input)->result();

			$this->load->view('iri/list_kelengkapan_rm',$data);
		} else if($tipe_input == 'BLN') {
			$data['title'] = 'Laporan Pengembalian Rekam Medik Lengkap '.date("F Y", strtotime($month));
			$data['date'] = $month;
			$data['date_title'] = date("F Y", strtotime($month));
			$data['tampil'] = $tipe_input;
			$data['data_kunjungan'] = $this->rimpasien->get_data($month, $tipe_input)->result();

			$this->load->view('iri/list_kelengkapan_rm',$data);
		} else {
			$tgl = date('Y-m-d');
			$data['title'] = 'Laporan Pengembalian Rekam Medik Lengkap '.date("d F Y", strtotime($tgl));
			$data['date'] = $tgl;
			$data['date_title'] = date("d F Y", strtotime($tgl));
			$data['tampil'] = 'TGL';
			$data['data_kunjungan'] = $this->rimpasien->get_data($tgl, 'TGL')->result();
		
			$this->load->view('iri/list_kelengkapan_rm',$data);
		}
	}

	public function data_lengkap2($no_ipd) {
		$data['lengkap'] = 1;
		$data['tgl_dilengkapi'] = date("Y-m-d H:i:s");
		$data['kelengkapan_rm'] = 'Lengkap ≤ 24 jam';
		$this->rimpasien->update_data_lengkap($no_ipd, $data);
		redirect('iri/ricmedrec/list_tdk_lengkap');
	}

	public function excel_lap_kelengkapan_rm($date, $tampil){
		$data = $this->rimpasien->get_data($date, $tampil)->result();
		
		if($tampil == 'TGL') {
			$tgl = date("d F Y", strtotime($date));
		} else {
			$tgl = date("F Y", strtotime($date));
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
			
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'No RM');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Jenis Kelamin');
		$sheet->setCellValue('E1', 'Agama');
		$sheet->setCellValue('F1', 'Umur');
		$sheet->setCellValue('G1', 'Kabupaten/Kota');
		$sheet->setCellValue('H1', 'Provinsi');
		$sheet->setCellValue('I1', 'Jaminan');
		$sheet->setCellValue('J1', 'Ruangan Awal');
		$sheet->setCellValue('K1', 'Kelas');
		$sheet->setCellValue('L1', 'Ket Tempat Tidur');
		$sheet->setCellValue('M1', 'Ruangan Pindah I');
		$sheet->setCellValue('N1', 'Kelas Pindah I');
		$sheet->setCellValue('O1', 'Tgl Pindah I');
		$sheet->setCellValue('P1', 'Ruangan Pindah II');
		$sheet->setCellValue('Q1', 'Kelas Pindah II');
		$sheet->setCellValue('R1', 'Tgl Pindah II');
		$sheet->setCellValue('S1', 'Ruangan Pindah III');
		$sheet->setCellValue('T1', 'Kelas Pindah III');
		$sheet->setCellValue('U1', 'Tgl Pindah III');
		$sheet->setCellValue('V1', 'Ruangan Pindah IV');
		$sheet->setCellValue('W1', 'Kelas Pindah IV');
		$sheet->setCellValue('X1', 'Tgl Pindah IV');
		$sheet->setCellValue('Y1', 'DPJP Utama');
		$sheet->setCellValue('Z1', 'Diagnosa Utama');
		$sheet->setCellValue('AA1', 'Diagnosa Sekunder Pertama');
		$sheet->setCellValue('AB1', 'Diagnosa Sekunder Kedua');
		$sheet->setCellValue('AC1', 'Diagnosa Sekunder Ketiga');
		$sheet->setCellValue('AD1', 'Tindakan');
		$sheet->setCellValue('AE1', 'Kondisi Pulang');
		$sheet->setCellValue('AF1', 'Cara Pulang');
		$sheet->setCellValue('AG1', 'Tgl Masuk');
		$sheet->setCellValue('AH1', 'Tgl Keluar');
		$sheet->setCellValue('AI1', 'Lama Rawat');
		$sheet->setCellValue('AJ1', 'Hari Rawatan');
		$sheet->setCellValue('AK1', 'Kelengkapan RM');
		$sheet->setCellValue('AL1', 'Pintu Masuk');
		$sheet->setCellValue('AM1', 'User yang memulangkan');

		$no = 1;
		$x = 2;
			
		foreach($data as $r){
			$ruang = $this->rimpasien->get_ruang($r->no_ipd)->result();
			$diag = $this->rimpasien->get_diagnosa($r->no_ipd)->result();
			$operasi = $this->rimpasien->get_operasi($r->no_ipd)->result();
				
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $r->no_cm);
			$sheet->setCellValue('C'.$x, $r->nama);
			$sheet->setCellValue('D'.$x, $r->sex);
			$sheet->setCellValue('E'.$x, $r->agama);
			$tgl_lahir = new DateTime($r->tgl_lahir);//start time
			$today = new DateTime('today');//end time
			$y = $today->diff($tgl_lahir)->y;
			$sheet->setCellValue('F'.$x, $y.' '.'Thn');
			$sheet->setCellValue('G'.$x, $r->kotakabupaten);
			$sheet->setCellValue('H'.$x, $r->provinsi);
			$sheet->setCellValue('I'.$x, $r->carabayar);
			$sheet->setCellValue('J'.$x, $r->ruang_awal);
			$sheet->setCellValue('K'.$x, $r->kelas_awal);
			$sheet->setCellValue('L'.$x,'');
			if($ruang != null){
				if($r->no_ipd == $ruang[0]->no_ipd){ 
					$sheet->setCellValue('M'.$x, isset($ruang[0]->nmruang)?$ruang[0]->nmruang:'');
					$sheet->setCellValue('N'.$x, isset($ruang[0]->kelas)?$ruang[0]->kelas:'');
					$sheet->setCellValue('O'.$x, isset($ruang[0]->tglmasukrg)?$ruang[0]->tglmasukrg:'');
					$sheet->setCellValue('P'.$x, isset($ruang[1]->nmruang)?$ruang[1]->nmruang:'');
					$sheet->setCellValue('Q'.$x, isset($ruang[1]->kelas)?$ruang[1]->kelas:'');
					$sheet->setCellValue('R'.$x, isset($ruang[1]->tglmasukrg)?$ruang[1]->tglmasukrg:'');
					$sheet->setCellValue('S'.$x, isset($ruang[2]->nmruang)?$ruang[2]->nmruang:'');
					$sheet->setCellValue('T'.$x, isset($ruang[2]->kelas)?$ruang[2]->kelas:'');
					$sheet->setCellValue('U'.$x, isset($ruang[2]->tglmasukrg)?$ruang[2]->tglmasukrg:'');
					$sheet->setCellValue('V'.$x, isset($ruang[3]->nmruang)?$ruang[3]->nmruang:'');
					$sheet->setCellValue('W'.$x, isset($ruang[3]->kelas)?$ruang[3]->kelas:'');
					$sheet->setCellValue('X'.$x, isset($ruang[3]->tglmasukrg)?$ruang[3]->tglmasukrg:'');
			}}else{ 
				$sheet->setCellValue('M'.$x,'');
				$sheet->setCellValue('N'.$x,'');
				$sheet->setCellValue('O'.$x,'');
				$sheet->setCellValue('P'.$x,'');
				$sheet->setCellValue('Q'.$x,'');
				$sheet->setCellValue('R'.$x,'');
				$sheet->setCellValue('S'.$x,'');
				$sheet->setCellValue('T'.$x,'');
				$sheet->setCellValue('U'.$x,'');
				$sheet->setCellValue('V'.$x,'');
				$sheet->setCellValue('W'.$x,'');
				$sheet->setCellValue('X'.$x,'');
			}
			$sheet->setCellValue('Y'.$x, $r->dokter);
				if($diag != null){
                    if($r->no_ipd == $diag[0]->no_register){
						$sheet->setCellValue('Z'.$x, isset($diag[0]->diagnosa)?$diag[0]->diagnosa:'');
						$sheet->setCellValue('AA'.$x, isset($diag[1]->diagnosa)?$diag[1]->diagnosa:'');
						$sheet->setCellValue('AB'.$x, isset($diag[2]->diagnosa)?$diag[2]->diagnosa:'');
						$sheet->setCellValue('AC'.$x, isset($diag[3]->diagnosa)?$diag[3]->diagnosa:'');
                }} else{
					$sheet->setCellValue('Z'.$x,'');
					$sheet->setCellValue('AA'.$x,'');
					$sheet->setCellValue('AB'.$x,'');
					$sheet->setCellValue('AC'.$x,'');
				}

			if($operasi != null){
				if($r->no_ipd == $operasi[0]->no_ipd){
					$sheet->setCellValue('AD'.$x,'Operasi');
			}} else{
				$sheet->setCellValue('AD'.$x,'');
			}

			$sheet->setCellValue('AE'.$x, $r->status_pulang);
			$sheet->setCellValue('AF'.$x, $r->cara_pulang);
			$sheet->setCellValue('AG'.$x, $r->tgl_masuk);
			$sheet->setCellValue('AH'.$x, $r->tgl_keluar);

			$temp_tgl_awal = strtotime($r->tgl_masuk);
			$temp_tgl_akhir = strtotime($r->tgl_keluar);
			$diff = $temp_tgl_akhir - $temp_tgl_awal;
			$diff =  floor($diff/(60*60*24));
			if($diff == 0){
				$diff = 1;
			}
			$lama_rawat = $diff.' Hari';

			$sheet->setCellValue('AI'.$x, $lama_rawat);
			$sheet->setCellValue('AJ'.$x, '');

			// if($r->jam_keluar != null && $r->tgl_dilengkapi != null){
			// 	$datetime1 = new DateTime($r->jam_keluar);//start time
			// 	$datetime2 = new DateTime($r->tgl_dilengkapi);//end time
			// 	$interval = $datetime1->diff($datetime2);
			// 	$jam_rm =  $interval->format('%H'); 
			// 	$hari_rm = $interval->format('%d');
			// 	if(intval($hari_rm) < 1 && $r->lengkap == '1'){
			// 		$ket = 'lengkap < 24 jam';
			// 	}else if(intval($hari_rm) >= 1 && $r->lengkap == '1'){
			// 		$ket = 'lengkap > 24 jam';
			// 	}else if(intval($hari_rm) < 1 && $r->lengkap == '2'){
			// 		$ket = 'Tidak Lengkap < 24 jam';
			// 	}else if(intval($hari_rm) >= 1 && $r->lengkap == '2'){
			// 		$ket = 'Tidak Lengkap > 24 jam';
			// 	}else{
			// 		$ket = 0;
			// 	}
			// }else{
			// 	$jam_rm =  null; 
			// 	$hari_rm = null;
			// 	$ket = null;	
			// }

			$sheet->setCellValue('AK'.$x, $r->kelengkapan_rm);
			$sheet->setCellValue('AL'.$x, $r->pintu_masuk);
			$sheet->setCellValue('AM'.$x, $r->user_plg);
			$x++;
		} 							
			
		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Kelengkapan RM '.$tgl;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');    
	}

	public function laporan_kelengkapan_rm() {
  

		$tampil_per = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$bulan = $this->input->post('date_months');
		$idrg = $this->input->post('idrg');

	

		if($tampil_per == 'TGL'){

			$data['tampil'] = $tampil_per;
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['idrg'] = $idrg;
			$data['data_kunjungan'] = $this->rimpasien->get_data_kelengkapan_tgl($idrg,$tgl_awal,$tgl_akhir)->result();
			$this->load->view('iri/laporan_kelengkapan_rm',$data);
		  
		}else if($tampil_per == 'BLN'){
			$data['date'] = $bulan;
			$data['tampil'] = $tampil_per;
			$data['idrg'] = $idrg;
			$data['data_kunjungan'] = $this->rimpasien->get_data_kelengkapan_bln($idrg,$bulan)->result();
	
			$this->load->view('iri/laporan_kelengkapan_rm',$data);
		}else{
			$data['tampil'] = '';
			$data['data_kunjungan'] = array();
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['idrg'] = $idrg;
			$this->load->view('iri/laporan_kelengkapan_rm',$data);
		}
	
	
		}


		public function excel_laporan_kelengkapan_rm($idrg,$tgl_awal,$tgl_akhir)
		{
			$data=$this->rimpasien->get_data_kelengkapan_tgl($idrg,$tgl_awal,$tgl_akhir)->result();
			
				// var_dump($data);die();            
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'Dirawat Diruangan');
				$sheet->setCellValue('B1', 'DPJP');
				$sheet->setCellValue('C1', 'Lengkap ≤ 24 jam');
				$sheet->setCellValue('D1', '%');
				$sheet->setCellValue('E1', 'Tdk Lengkap ≤ 24 jam');
				$sheet->setCellValue('F1', '%');
				$sheet->setCellValue('G1', 'Jumlah Berkas');

				$no = 1;
				$x = 2;
				
				foreach($data as $r){
					
					$sheet->setCellValue('A'.$x, $r->nmruang);
					$sheet->setCellValue('B'.$x, $r->dokter);
					$sheet->setCellValue('C'.$x, $r->lengkap_kurang_24);

					$jmlh_berkas = $r->lengkap_kurang_24 + $r->tdk_lengkap_kurang_24;
					$lengkap = $r->lengkap_kurang_24 / $jmlh_berkas;
					$lengkap_persen = $lengkap * 100;
					$tdk_lengkap = $r->tdk_lengkap_kurang_24 / $jmlh_berkas;
					$tdk_lengkap_persen = $tdk_lengkap * 100;


					$sheet->setCellValue('D'.$x, $lengkap_persen);
					$sheet->setCellValue('E'.$x, $r->tdk_lengkap_kurang_24);
					$sheet->setCellValue('F'.$x, $tdk_lengkap_persen);
					$sheet->setCellValue('G'.$x, $jmlh_berkas);
					$x++;
					} 
									
				
			
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kelengkapan RM';
				// ob_end_clean();
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');
		
				$writer->save('php://output');  
				
		}

		public function excel_laporan_kelengkapan_rm_bln($idrg,$bln)
		{
			$data=$this->rimpasien->get_data_kelengkapan_bln($idrg,$bln)->result();            
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$sheet->setCellValue('A1', 'Dirawat Diruangan');
				$sheet->setCellValue('B1', 'DPJP');
				$sheet->setCellValue('C1', 'Lengkap ≤ 24 jam');
				$sheet->setCellValue('D1', '%');
				$sheet->setCellValue('E1', 'Tdk Lengkap ≤ 24 jam');
				$sheet->setCellValue('F1', '%');
				$sheet->setCellValue('G1', 'Jumlah Berkas');

				$no = 1;
				$x = 2;
				
				foreach($data as $r){
					
					$sheet->setCellValue('A'.$x, $r->nmruang);
					$sheet->setCellValue('B'.$x, $r->dokter);
					$sheet->setCellValue('C'.$x, $r->lengkap_kurang_24);

					$jmlh_berkas = $r->lengkap_kurang_24 + $r->tdk_lengkap_kurang_24;
					$lengkap = $r->lengkap_kurang_24 / $jmlh_berkas;
					$lengkap_persen = $lengkap * 100;
					$tdk_lengkap = $r->tdk_lengkap_kurang_24 / $jmlh_berkas;
					$tdk_lengkap_persen = $tdk_lengkap * 100;


					$sheet->setCellValue('D'.$x, $lengkap_persen);
					$sheet->setCellValue('E'.$x, $r->tdk_lengkap_kurang_24);
					$sheet->setCellValue('F'.$x, $tdk_lengkap_persen);
					$sheet->setCellValue('G'.$x, $jmlh_berkas);
					$x++;
					} 
									
				
			
				
				$writer = new Xlsx($spreadsheet);
				$filename = 'Laporan Kelengkapan RM';
				// ob_end_clean();
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
				header('Cache-Control: max-age=0');
		
				$writer->save('php://output');  
				
		}

		public function list_pasien_pulang_ranap()
		{
		
			$data['title']='Pasien Pulang Rawat Inap';
			$dateRange = $this->input->post('tanggal_laporan');
			$data['poli']=$this->rjmpencarian->get_poliklinik_non_igd()->result();	
			if($dateRange){
				$dates = explode(' - ', $dateRange);
				$startDate = $dates[0];
				$endDate = $dates[1];
				$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
				$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
				$data['tgl'] = $startDateObj->format('Y-m-d');
				$data['tgl1'] = $endDateObj->format('Y-m-d');
				$data['data_tind']=$this->rimpasien->list_pulang_ranap($data['tgl'],$data['tgl1'])->result();
			
			}else{
				$data['tgl'] = date('Y-m-d');
				$data['tgl1'] = date('Y-m-d');
				$data['data_tind']=array();
				$data['data_detail_tind']=array();
			}

			$this->load->view('iri/list_pulang_ranap',$data);
		}

		public function cetak_resep_ranap()
		{
		
			$data['title']='Cetak Resep Pasien Pulang Rawat Inap';
			$dateRange = $this->input->post('tanggal_laporan');
			if($dateRange){
				$dates = explode(' - ', $dateRange);
				$startDate = $dates[0];
				$endDate = $dates[1];
				$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
				$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
				$data['tgl'] = $startDateObj->format('Y-m-d');
				$data['tgl1'] = $endDateObj->format('Y-m-d');
				$data['data_tind']=$this->rimpasien->list_pulang_ranap($data['tgl'],$data['tgl1'])->result();
			
			}else{
				$data['tgl'] = date('Y-m-d');
				$data['tgl1'] = date('Y-m-d');
				$data['data_tind']=array();
				$data['data_detail_tind']=array();
			}

			$this->load->view('iri/list_pulang_ranap_resep',$data);
		}

		public function cetak_list_resep($no_ipd = '')
			{
				$data['list_tindakan_pasien'] = $this->rimpasien->detail_resep_cetak($no_ipd)->result();
				$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
				$id_dokter = $this->rimpasien->get_id_dokter($no_ipd)->row()->id_dokter;
				$data['ttd_dokter'] = $this->rimpasien->ttd_dokter_resep($id_dokter)->row();
				$data['tgl'] = date("Y-m-d");

				$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
				$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
				$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
				$interval = date_diff(date_create(), date_create($data['data_pasien'][0]['tgl_lahir']));
				$thn = $interval->format("%Y Tahun");
				$data['tahun'] = $thn;
				$data['dokter'] = $this->rimpasien->get_ttd_dpjp($data['data_pasien'][0]['dr_dpjp'])->row()->nm_dokter;
				ini_set("pcre.backtrack_limit", "5000000");
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
				$mpdf->curlAllowUnsafeSslRequests = true;
				$html = $this->load->view('iri/cetak_resep', $data, true);
				
				$mpdf->WriteHTML($html);
				$mpdf->Output();

			}


			public function cetak_resep_rajal()
		{
		
			$data['title']='Cetak Resep Pasien Pulang Rawat Jalan';
			$dateRange = $this->input->post('tanggal_laporan');
			if($dateRange){
				$dates = explode(' - ', $dateRange);
				$startDate = $dates[0];
				$endDate = $dates[1];
				$startDateObj = DateTime::createFromFormat('Y/m/d', $startDate);
				$endDateObj = DateTime::createFromFormat('Y/m/d', $endDate);
				$data['tgl'] = $startDateObj->format('Y-m-d');
				$data['tgl1'] = $endDateObj->format('Y-m-d');
				$data['data_tind']=$this->rimpasien->list_pulang_rajal($data['tgl'],$data['tgl1'])->result();
			
			}else{
				$data['tgl'] = date('Y-m-d');
				$data['tgl1'] = date('Y-m-d');
				$data['data_tind']=array();
				$data['data_detail_tind']=array();
			}

			$this->load->view('iri/list_pulang_rajal_resep',$data);
		}

		public function cetak_list_resep_rajal($no_ipd = '',$stat = '')
			{
				$data['list_tindakan_pasien'] = $this->rimpasien->detail_resep_cetak($no_ipd)->result();
				$data['data_pasien'] = $this->rimpasien->pasien_resep_rajal($no_ipd)->row();
				$data['ttd_dokter'] = $this->rimpasien->ttd_dokter_resep($data['data_pasien']->id_dokter)->row();
				// var_dump($data['ttd_dokter']);die();
				$data['tgl'] = date("Y-m-d");
				$data['stat'] = $stat;

				$data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
				$data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
				$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
				// ini_set("pcre.backtrack_limit", "5000000");
				$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
				$mpdf->curlAllowUnsafeSslRequests = true;
				$html = $this->load->view('iri/cetak_resep_rajal', $data, true);
				
				$mpdf->WriteHTML($html);
				$mpdf->Output();

			}
}