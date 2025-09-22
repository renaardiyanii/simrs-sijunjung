<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');
require_once(APPPATH.'controllers/Secure_area.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Ricreservasi extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimruang');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmregistrasi');
	
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function index($no_ipd='',$mutasi=''){
		// MENU
		$data['title'] = '';
		$data['reservasi']='active';
		$data['daftar']='';
		$data['mutasi']='';
		$data['pasien'] = '';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['kelas'] = $this->rimkelas->get_all_kelas();

		//kalo mutasi data pasien masukin
		$data['mutasi'] ='';
		$data['data_pasien'] = '';
		if($no_ipd != ''){
			$data['pesan'] = '';
			$temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
			if($temp){
				$data['pesan'] =
				"<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i><b>Terdapat Data Tindakan yang belum tersimpan ! Simpan terlebih dahulu sebelum pasien akan dimutasi/dipulangkan</b>
				</div>";
			}
			$data['smf']=$this->rimpendaftaran->get_all_smf();
			$data['data_pasien'] = $this->rimreservasi->select_pasien_irj_by_ipd($no_ipd); // untuk keperluan mutasi
			$data['mutasi'] = $mutasi;
	 // 	print_r($data);die();
			// $this->load->view('iri/rivlink');
			$this->load->view('iri/form_reservasi', $data);
		}else{
			
			$this->index2();
		}

		//get pasien rawat jalan
		//$data['list_pasien_irj'] = $this->rimreservasi->select_pasien_irj_like('rj');

		//get pasien rawat darurat
		//$data['list_pasien_ird'] = $this->rimreservasi->select_pasien_ird_like('rd');
		//print_r($data['data_pasien']);exit;

		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/form_reservasi', $data);
	}

	public function list_batal(){
		// MENU
		$data['title'] = 'Data Pasien Batal Reservasi Rawat Inap';		
		if($this->input->post('date0')==''){
			$date0=date('Y-m-d',strtotime('-7 days'));
		}else{
			$date0=$this->input->post('date0');
		}
		if($this->input->post('date1')==''){
			$date1=date('Y-m-d');
		}else{
			$date1=$this->input->post('date1');
		}

		$data['list_batal_antrian'] = $this->rimreservasi->select_pasien_batal_antrian($date0,$date1);
		$data['list_batal_reservasi'] = $this->rimreservasi->select_pasien_batal_reservasi_new($date0,$date1);
     //   print_r($data);die();
		$this->load->view('iri/list_batal_reservasi', $data);		
		
	}

	public function undo_antrian($noreservasi){
		// MENU		
		$this->rimreservasi->undo_pasien_batal_antrian($noreservasi);		
		$this->session->set_flashdata('pesan',
				"<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Reservasi dengan nomor ".$noreservasi." berhasil dikembalikan ke antrian !
				</div>");
		redirect('iri/ricreservasi/list_batal', 'refresh');
		
	}

	public function undo_reservasi($no_register){
		// MENU		
		$this->rimreservasi->undo_pasien_batal_reservasi($no_register);		
		$this->session->set_flashdata('pesan',
				"<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Nomor register ".$no_register." berhasil dikembalikan ke antrian reservasi rawat inap !
				</div>");
		redirect('iri/ricreservasi/list_batal', 'refresh');
		
	}

	public function index2($no_ipd=''){
		// MENU
		
		$data['title'] = '';
		$data['reservasi']='active';
		$data['daftar']='';
		$data['mutasi']='';
		$data['pasien'] = '';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['kelas'] = $this->rimkelas->get_all_kelas();

		//bikin object buat penanggalan
		$data['controller']=$this;

		//get data di rujukan rawat inap
		$data['data_irj'] = $this->rimreservasi->select_pasien_irj_like("rj");
		// $data['data_ird'] = $this->rimreservasi->select_pasien_ird_like("rd");

		//print_r($data['data_irj'][0]);

		//$this->load->view('iri/rivlink');
		$this->load->view('iri/form_reservasi_2', $data);
	}

	public function reservasi_from_list($no_register=''){

		// MENU
		$data['title'] = '';
		$data['reservasi']='active';
		$data['daftar']='';
		$data['mutasi']='';
		$data['pasien'] = '';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['kelas'] = $this->rimkelas->get_all_kelas();
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();
		//get data di rujukan rawat inap
		$kode = substr($no_register, 0,2);

		switch ($kode) {
			case 'RJ':
				$data['data_pasien'] = $this->rimreservasi->select_pasien_irj_like($no_register);
				break;
			case 'RD':
				$data['data_pasien'] = $this->rimreservasi->select_pasien_ird_like($no_register);
				break;
			default:
				# code...
				break;
		}
		if ($data['data_pasien'] == null) {
			$success = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h4><i class="fa fa-ban"></i> Data Pasien dengan No. Register '.$no_register.' Tidak Ditemukan.</h4> 
                       		</div>';
		$this->session->set_flashdata('pesan', $success);
			redirect('iri/ricreservasi/index2');
		}
		// print_r($data['data_pasien']);exit;

		//$this->load->view('iri/rivlink');
		$ceks=$this->rimreservasi->check_iri($data['data_pasien'][0]['no_medrec'])->row();
	
		//print_r($ceks);die();
		//echo $ceks->cek;

		if(!empty($ceks)){
			$data['pesan'] ="<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Pasien dgn Nomor MR ".$data['data_pasien'][0]['no_cm_real']." masih dirawat sejak tanggal ".date('d-m-Y',strtotime($ceks->tgl_masuk))."
				</div>";
		}else{
			$data['pesan'] ='';
		}

		$this->load->view('iri/form_reservasi', $data);
	}

	public function batal($no_register=''){

		if($no_register!=''){
			// MENU
			$id=$this->rimreservasi->batal_iri_reservasi($no_register);
			$this->session->set_flashdata('pesan',
				'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-muted"><i class="fa fa-check-circle"></i> Reservasi Pasien dengan no register '.$no_register.' berhasil dibatalkan</h3>
                       		</div>');
			redirect('iri/ricreservasi/');
		}
		
	}

	function emptyroom_date($date='')
	{
		if($date!=''){
			$data=$this->rimreservasi->getemptyroom_date($date)->result();
			echo "<option selected value=''>--Pilih Ruangan--</option>";
			foreach($data as $row){
				echo "<option value='".$row->idrg.'-'.$row->nmruang.'-'.$row->kelas."'>$row->idrg | $row->nmruang - $row->kelas</option>";
			}
		}
		
	}

	function emptybed_date($idrg='',$kelas='',$date='')
	{
		if($date!='' and $idrg!='' and $kelas!=''){
			$data=$this->rimreservasi->getemptybed_date($idrg,$kelas,$date)->result();
			echo "<option selected value=''>--Pilih Bed--</option>";
			foreach($data as $row){
				echo "<option value='$row->bed'>$row->bed</option>";
			}
		}
		
	}

	public function insert_reservasi(){
		// RESRVASI
		$count=$this->rimpendaftaran->get_pasien_iri_exist($this->input->post('no_cm_h'))->row()->exist;
		$data_reservasi['tppri']=$this->input->post('tppri',true);
		if($data_reservasi['tppri']=='rawatjalan' and (int)$count==0 ){
			$count=0;
		}else if($data_reservasi['tppri']=='ruangrawat' and (int)$count==1 ){
			$count=0;
		}
		if((int)$count==0){
			 // Asal

			$datenow=date('Ymd');
			$noreservasi=count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow))+1;
			$data_reservasi['noreservasi']=$datenow.'-'.$noreservasi; // No. Antrian
			$data_reservasi['rujukan']=$this->input->post('rujukan'); // Rujukan
			$data_reservasi['no_cm']=$this->input->post('no_cm_real'); // No. CM
			$data_reservasi['no_cm']=$this->input->post('no_cm_h'); // No. CM Hidden

			if($data_reservasi['tppri']=='rawatjalan'){
				$data_reservasi['no_register_asal']=$this->input->post('no_register_rawatjalan'); // Kode Reg. Asal
				$data_pasien_reservasi = $this->rimreservasi->select_pasien_irj($data_reservasi['no_register_asal']);

				$this->session->set_flashdata('pesan',
				"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Reg asal tidak ditemukan!
				</div>");
				if(!($data_pasien_reservasi)){
					redirect('iri/Ricdaftar/index/1');
					exit;
				}
			}else if($data_reservasi['tppri']=='ruangrawat'){

				$data_reservasi['no_register_asal']=$this->input->post('no_register_ruangrawat',true); // Kode Reg. Asal
				$data_bed_iri_mutasi=$this->rimpendaftaran->get_bed_sebelum_mutasi($data_reservasi['no_register_asal'])->row();
				$data_update_pasien_iri['mutasi']=1;
				$data_update_ruang_iri['tglkeluarrg']=date('Y-m-d H:i:s');
				$this->rimpendaftaran->update_pendaftaran_mutasi($data_update_pasien_iri, $data_reservasi['no_register_asal']);
				$this->rimpendaftaran->update_ruang_mutasi_iri($data_update_ruang_iri, $data_reservasi['no_register_asal']);
				$data_update_bed_iri['isi']='N';
				$this->rimpendaftaran->update_bed_mutasi_iri($data_update_bed_iri,$data_bed_iri_mutasi->bed);
			}else{
				$data_reservasi['no_register_asal']=$this->input->post('no_register_rawatdarurat'); // Kode Reg. Asal
				$data_pasien_reservasi = $this->rimreservasi->select_pasien_ird($data_reservasi['no_register_asal']);
				
				$this->session->set_flashdata('pesan',
				"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Reg asal tidak ditemukan!
				</div>");
				if(!($data_pasien_reservasi)){
					redirect('iri/ricreservasi');
					exit;
				}
			}
			$data_reservasi['tglreserv']=date('Y-m-d H:i:s'); // Tanggal Reservasi
			$data_reservasi['telp']=$this->input->post('telp'); // Telp
			$data_reservasi['hp']=$this->input->post('hp'); // HP

			$data_reservasi['id_poli']=$this->input->post('id_poli'); // Id Poli
			$data_reservasi['poliasal']=$this->input->post('poliasal'); // Poli Asal
			$data_reservasi['id_dokter']=$this->input->post('id_dokter'); // Poli asal
			$data_reservasi['dokter']=$this->input->post('dokter'); // Poli Asal
			$data_reservasi['diagnosa']=$this->input->post('diagnosa_id'); // Poli Asal
			$data_reservasi['dikirim_oleh']=$this->input->post('dikirim_oleh');
			$data_reservasi['dikirim_oleh_teks']=$this->input->post('dikirim_oleh_text');
			
			//  RENCANA MASUK
			$data_reservasi['tglrencanamasuk']=$this->input->post('tglrencanamasuk'); // Rencana masuk
			$data_reservasi['tglsprawat']=$this->input->post('tglsprawat'); // Tgl. SP. Rawat
			$temp_ruang = $this->input->post('ruang',true); // Kode ruang pilih
			$temp_ruang =explode("-", $temp_ruang);
			$data_reservasi['ruangpilih']=$temp_ruang[0]; // Kode ruang pilih
			// $data_reservasi['kelas']=$this->input->post('kelas'); // Kelas
			$data_reservasi['kelas']=$temp_ruang[2]; // Kelas
			$data_reservasi['pilihan_prioritas']=$this->input->post('pilihan_prioritas'); // Kelas
			$data_reservasi['prioritas']=$this->input->post('prioritas'); // Kelas
			//if(($this->input->post('infeksi'))){
			if($this->input->post('infeksi') != null){
				$data_reservasi['infeksi']=$this->input->post('infeksi'); // Infeksi
			}else{
				$data_reservasi['infeksi']='N';
			}
			$data_reservasi['keterangan']=$this->input->post('keterangan'); // Keterangan
			$data_reservasi['carabayar']=$this->input->post('carabayar'); 
			$data_reservasi['statusantrian']='N'; // Keterangan
			$data_reservasi['batal']='N'; // Keterangan
			$data_reservasi['bed']=$this->input->post('bed'); // bed
			$login_data = $this->load->get_var("user_info");
			$data_reservasi['user_approve'] = $login_data->username;		
			$roleid= $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;	
			// MENU
			$data['reservasi']='active';
			$data['daftar']='';
			$data['pasien']='';
			$data['mutasi']='';
			$data['status']='';
			$data['resume']='';
			$data['kontrol']='';
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Data telah tersimpan!
			</div>");
			
			$id=$this->rimreservasi->insert_reservasi($data_reservasi);			
			if($id==''){
				if($this->input->post('mutasi')!=''){
				redirect('iri/ricpasien');
				}else{
					if ($roleid=='24') {
						redirect('iri/ricpasien');
					}else {
					redirect('iri/Ricdaftar/index/1');
				}}
			}else{				
				$this->session->set_flashdata('pesan',
				"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Gagal menambahkan pasien ke list antrian !
				</div>");				
				redirect('iri/ricreservasi/reservasi_from_list/'.$data_reservasi['no_register_asal']);
			}
			
		}else{
			if($this->input->post('tppri',true)=='rawatjalan'){
				$data_reservasi['no_register_asal']=$this->input->post('no_register_rawatjalan'); // Kode Reg. Asal	
			}else if($this->input->post('tppri',true)=='ruangrawat'){
				$data_reservasi['no_register_asal']=$this->input->post('no_register_ruangrawat',true); // Kode Reg. 
			}else{
				$data_reservasi['no_register_asal']=$this->input->post('no_register_rawatdarurat'); // Kode Reg. Asal
			}
			$this->session->set_flashdata('pesan',
				"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Pasien sudah dirawat diruangan !
				</div>");				
			redirect('iri/ricreservasi/reservasi_from_list/'.$data_reservasi['no_register_asal']);
		}
		

	}

	public function data_pasien_ird() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimreservasi->select_pasien_ird_like($keyword);
		foreach($data as $row){
			if($row['no_register'] != null){
				$coba=strtotime($row['tgl_lahir']);
				$date=date('d/m/Y', $coba);
				
				$arr['query'] = $keyword;
				$arr['suggestions'][] 	= array(
					'value'				=>$row['no_register'],
					'no_cm'				=>$row['no_medrec'],
					'no_cm_real'		=>$row['no_cm'],
					'no_reg'			=>$row['no_register'],
					'nama'				=>$row['nama'],
					'jenis_kelamin'		=>$row['sex'],
					'tanggal_lahir'		=>$date,
					'telp'				=>$row['no_telp'],
					'hp'				=>$row['no_hp'],
					'id_poli'			=>'',
					'poliasal'			=>'',
					'id_dokter'			=>$row['id_dokter'],
					'dokter'			=>$row['nm_dokter'],
					'diagnosa'			=>$row['diagnosa_utama'],
					'diagnosa_id'			=>$row['id_diagnosa']

					// 'id_poli'			=>$row['id_poli'],
					// 'poliasal'			=>$row['poliasal'],
					// 'id_dokter'			=>$row['id_dokter'],
					// 'dokter'			=>$row['dokter'],
					// 'diagnosa'			=>$row['diagnosa']
			);
			}
		}
		if(!($arr)){
			$arr['suggestions'][] 	= array(
				'value'				=>"Data Tidak Ditemukan",
				'no_cm'				=>"Data Tidak Ditemukan",
				'no_reg'			=>"Data Tidak Ditemukan",
				'nama'				=>"Data Tidak Ditemukan",
				'jenis_kelamin'		=>"Data Tidak Ditemukan",
				'tanggal_lahir'		=>"Data Tidak Ditemukan",
				'telp'				=>"Data Tidak Ditemukan",
				'hp'				=>"Data Tidak Ditemukan",
				'id_poli'			=>"Data Tidak Ditemukan",
				'poliasal'			=>"Data Tidak Ditemukan",
				'id_dokter'			=>"Data Tidak Ditemukan",
				'dokter'			=>"Data Tidak Ditemukan",
				'diagnosa'			=>"Data Tidak Ditemukan",
				'diagnosa_id'		=>"Data Tidak Ditemukan"
				// 'id_poli'			=>$row['id_poli'],
				// 'poliasal'			=>$row['poliasal'],
				// 'id_dokter'			=>$row['id_dokter'],
				// 'dokter'			=>$row['dokter'],
				// 'diagnosa'			=>$row['diagnosa']
			);
		}
		echo json_encode($arr);
    }

    public function data_ruang() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimreservasi->select_ruang_like($keyword);
		foreach($data as $row){
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				// 'value'				=>$row['idrg'].' - '.$row['nmruang'].' - '.$row['koderg'],
				'value'				=>$row['idrg'].' - '.$row['nmruang'],
				'idrg'				=>$row['idrg'],
				'nmruang'			=>$row['nmruang'],
				//'kelas'				=>$row['koderg']
			);
		}
		echo json_encode($arr);
    }
	
	public function data_pasien_irj() {
		

		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimreservasi->select_pasien_irj_like($keyword);

		foreach($data as $row){
			if($row['no_register'] != null){
				$coba=strtotime($row['tgl_lahir']);
				$date=date('d/m/Y', $coba);
				
				$arr['query'] = $keyword;
				$arr['suggestions'][] 	= array(
					'value'				=>$row['no_register'],
					'no_cm'				=>$row['no_medrec'],
					'no_cm_real'		=>$row['no_cm'],
					'no_reg'			=>$row['no_register'],
					'nama'				=>$row['nama'],
					'jenis_kelamin'		=>$row['sex'],
					'tanggal_lahir'		=>$date,
					'telp'				=>$row['no_telp'],
					'hp'				=>$row['no_hp'],
					'id_poli'			=>$row['id_poli'],
					'poliasal'			=>$row['nm_poli'],
					'id_dokter'			=>$row['id_dokter'],
					'dokter'			=>$row['nama_dokter'],
					'diagnosa'			=>$row['diagnosa_utama'],
					'diagnosa_id'		=>$row['id_diagnosa']
					// 'id_poli'			=>$row['id_poli'],
					// 'poliasal'			=>$row['poliasal'],
					// 'id_dokter'			=>$row['id_dokter'],
					// 'dokter'			=>$row['dokter'],
					// 'diagnosa'			=>$row['diagnosa']
				);
			}
		}
		if(!($arr)){
			$arr['suggestions'][] 	= array(
				'value'				=>"Data Tidak Ditemukan",
				'no_cm'				=>"Data Tidak Ditemukan",
				'no_reg'			=>"Data Tidak Ditemukan",
				'nama'				=>"Data Tidak Ditemukan",
				'jenis_kelamin'		=>"Data Tidak Ditemukan",
				'tanggal_lahir'		=>"Data Tidak Ditemukan",
				'telp'				=>"Data Tidak Ditemukan",
				'hp'				=>"Data Tidak Ditemukan",
				'id_poli'			=>"Data Tidak Ditemukan",
				'poliasal'			=>"Data Tidak Ditemukan",
				'id_dokter'			=>"Data Tidak Ditemukan",
				'dokter'			=>"Data Tidak Ditemukan",
				'diagnosa'			=>"Data Tidak Ditemukan",
				'diagnosa_id'		=>"Data Tidak Ditemukan"
				// 'id_poli'			=>$row['id_poli'],
				// 'poliasal'			=>$row['poliasal'],
				// 'id_dokter'			=>$row['id_dokter'],
				// 'dokter'			=>$row['dokter'],
				// 'diagnosa'			=>$row['diagnosa']
			);
		}
		echo json_encode($arr);
    }

    public function data_pasien_iri() {
		

		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimreservasi->select_pasien_iri_like($keyword);

		foreach($data as $row){
			if($row['no_ipd'] != null){
				$coba=strtotime($row['tgl_lahir']);
				$date=date('d/m/Y', $coba);
				
				$arr['query'] = $keyword;
				$arr['suggestions'][] 	= array(
					'value'				=>$row['no_ipd'],
					'no_cm'				=>$row['no_medrec'],
					'no_reg'			=>$row['no_ipd'],
					'nama'				=>$row['nama'],
					'jenis_kelamin'		=>$row['sex'],
					'tanggal_lahir'		=>$date,
					'telp'				=>$row['no_telp'],
					'hp'				=>$row['no_hp'],
					'id_poli'			=>$row['idrg'],
					'poliasal'			=>$row['nmruang'],
					'id_dokter'			=>$row['id_dokter'],
					'dokter'			=>$row['dokter'],
					'diagnosa'			=>$row['id_icd'],
					'diagnosa_id'		=>$row['diagmasuk']
					// 'id_poli'			=>$row['id_poli'],
					// 'poliasal'			=>$row['poliasal'],
					// 'id_dokter'			=>$row['id_dokter'],
					// 'dokter'			=>$row['dokter'],
					// 'diagnosa'			=>$row['diagnosa']
				);
			}
		}
		if(!($arr)){
			$arr['suggestions'][] 	= array(
				'value'				=>"Data Tidak Ditemukan",
				'no_cm'				=>"Data Tidak Ditemukan",
				'no_reg'			=>"Data Tidak Ditemukan",
				'nama'				=>"Data Tidak Ditemukan",
				'jenis_kelamin'		=>"Data Tidak Ditemukan",
				'tanggal_lahir'		=>"Data Tidak Ditemukan",
				'telp'				=>"Data Tidak Ditemukan",
				'hp'				=>"Data Tidak Ditemukan",
				'id_poli'			=>"Data Tidak Ditemukan",
				'poliasal'			=>"Data Tidak Ditemukan",
				'id_dokter'			=>"Data Tidak Ditemukan",
				'dokter'			=>"Data Tidak Ditemukan",
				'diagnosa'			=>"Data Tidak Ditemukan",
				'diagnosa_id'		=>"Data Tidak Ditemukan"
				// 'id_poli'			=>$row['id_poli'],
				// 'poliasal'			=>$row['poliasal'],
				// 'id_dokter'			=>$row['id_dokter'],
				// 'dokter'			=>$row['dokter'],
				// 'diagnosa'			=>$row['diagnosa']
			);
		}
		echo json_encode($arr);
    }

    function show_reservation($tgl_jadwal=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->rimreservasi->get_reservation_schedule($tgl_jadwal);		
		
		/*<th>No Reservasi</th>
									<th>No Reservasi</th>
									<th>Asal</th>
									<th>No MR</th>
									<th>Nama</th>								
									<th>Cara Bayar</th>
									<th>Ruang</th>
									<th>Kelas</th>
									<th>Bed</th>
									<th>Dokter yg Merujuk</th>
									<th>Ket</th>
									<th>Tgl Masuk</th>*/
		foreach ($hasil as $value) {
			$row2['no_reservasi'] = $value->noreservasi;
			$row2['asal'] = $value->nm_poli;
			$row2['no_cm'] = $value->no_cm;
			$row2['nama'] = $value->nama;
			$row2['cara_bayar'] = $value->cara_bayar;
			$row2['nmruang'] = $value->nmruang;
			$row2['kelas'] = $value->kelas;
			$row2['bed'] = $value->bed;
			$row2['nm_dokter'] = $value->dokter;
			$row2['ket'] = $value->pilihan_prioritas;	
			$row2['tglrencanamasuk'] = date('d-m-Y',strtotime($value->tglrencanamasuk));
			$row2['detail'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="detail_rsrv('.$value->noreservasi.')"><i class="fa fa-eye"></i></button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }


    function show_schedule($tgl_jadwal_ok=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->rimreservasi->get_operation_schedule($tgl_jadwal_ok);		
		
		/*<th>No Reservasi</th>
								<th>Asal</th>
								<th>No MR</th>
								<th>Nama</th>								
								<th>Cara Bayar</th>
								<th>Prioritas</th>
								<th>Dokter</th>
								<th>Ket</th>
								<th>Tanggal</th>
								<th>Waktu</th>*/
		foreach ($hasil as $value) {
			if($value->no_reservasi!=''){
				$row2['no_reservasi'] = $value->no_reservasi;
			}else{
				$row2['no_reservasi'] = $value->no_register;
			}			
			$row2['type_rawat'] = $value->type_rawat;
			$row2['no_cm'] = $value->no_cm;
			$row2['nama'] = $value->nama;
			$row2['cara_bayar'] = $value->cara_bayar;
			$row2['prioritas'] = $value->prioritas;
			$row2['nm_dokter'] = $value->nm_dokter;
			$row2['ket'] = $value->ket;	
			$row2['tgl_jadwal_ok'] = date('d-m-Y',strtotime($value->tgl_jadwal_ok));
			$row2['waktu_ok'] = date('H:i',strtotime($value->intime_jadwal_ok));	
			$row2['detail'] = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="detail_ok('.$value->idoperasi_header.')"><i class="fa fa-eye"></i></button>';		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

    function detail_rsrv($noreservasi=''){
    	if($noreservasi!=''){
    		$data['title'] = 'DETAIL RESERVASI PASIEN RAWAT INAP | '.$noreservasi;

			$this->load->view('iri/rivdetailjadwal',$data);
    	}
    }
}
