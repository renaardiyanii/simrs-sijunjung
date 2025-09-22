<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once(APPPATH.'controllers/Secure_area.php');
include('Rjcterbilang.php');
class Rjcregistrasi extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			//$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			$this->load->model('irj/M_update_sepbpjs','',TRUE);
			$this->load->model('bpjs/Mbpjs','',TRUE);
			$this->load->helper('pdf_helper');
			$this->load->helper('bpjs');
			$this->load->helper('tgl_indo');
			$this->load->model('admin/appconfig','',TRUE);

			// $this->load->constant();		
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	
	{
	//	var_dump(NAMA_RS);die();
		$data['title'] = 'Registrasi Pasien';
		$data['data_pasien'] =  "";
		$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		$this->console_log($data['data_registrasi']);
		$this->load->view('irj/rjvformcaripasien',$data);
	}

	public function get_timestamp($no_register='')
	{
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
        $url = $data_bpjs->service_url;

        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id,
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);		
		echo $encoded_signature;
		echo $timestamp;
	}

	public function data_wilayah(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')->limit(10, 0)->get()->result();

		//print_r($data);die();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>($row->id),					
				'nm_kelurahan'	=>$row->nama
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function get_wilayah()
	{
		$json = [];
	
		$this->load->database();

			// $query = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')
			// ->like('initcap(kotakabupaten.nama)',$this->input->get("q"))
			// ->or_like('initcap(kecamatan.nama)',$this->input->get("q"))
			// ->or_like('initcap(kelurahandesa.nama)',$this->input->get("q"))
			// ->select('provinsi.id as id_provinsi,kotakabupaten.id as id_kota,kecamatan.id as id_kecamatan,kelurahandesa.id as id_kelurahan,provinsi.nama as nm_provinsi,kotakabupaten.nama as nm_kota,kecamatan.nama as nm_kecamatan,kelurahandesa.nama as nm_kelurahan')->limit(50, 0)->get();	
			// $json = $query->result();

			$query = $this->db->from('provinsi')->JOIN('kotakabupaten', 'provinsi.id = kotakabupaten.id_prov', 'inner')->JOIN('kecamatan', 'kotakabupaten.id = kecamatan.id_kabupaten', 'inner')->JOIN('kelurahandesa', 'kecamatan.id = kelurahandesa.id_kecamatan', 'inner')
			->like('kotakabupaten.nama',strtoupper($this->input->get("q")))
			->or_like('kecamatan.nama',strtoupper($this->input->get("q")))
			->or_like('kelurahandesa.nama',strtoupper($this->input->get("q")))
			->select('provinsi.id as id_provinsi,kotakabupaten.id as id_kota,kecamatan.id as id_kecamatan,kelurahandesa.id as id_kelurahan,provinsi.nama as nm_provinsi,kotakabupaten.nama as nm_kota,kecamatan.nama as nm_kecamatan,kelurahandesa.nama as nm_kelurahan')->limit(50, 0)->get();	
			$json = $query->result();

		
		echo json_encode($json);
	}
	
	public function regpasien()
	{
		$data['title'] = 'Pendaftaran Pasien Baru';
		$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['prop']=$this->rjmpencarian->get_prop()->result();
	
		$data['pekerjaan']=$this->rjmpencarian->get_pekerjaan()->result();
	
		$this->load->view('irj/rjvformdaftar',$data);
	}

	public function show_keluarga($no_cm_pasien='')
	{
		$result=$this->rjmregistrasi->show_keluarga($no_cm_pasien)->row();
		//$data['mrnrp']=$this->rjmpencarian->get_hubungan()->result();
		echo json_encode($result);
	}

	public function generate_rm()
	{
		$no_medrec = $this->input->post('no_medrec');
		$no_cm = $this->input->post('no_cm');	
		$tgldaftar = date("Y-m-d H:i:s");	
		$data_update = array(
			'no_cm_lama' => $no_cm,
			'tgl_daftar' => $tgldaftar
        );                  			
		$result=$this->rjmregistrasi->generate_rm($no_medrec,$data_update);
		echo json_encode($result);
	}

	public function get_rm()
	{		
		$no_medrec = $this->input->post('no_medrec');				               			
		$result=$this->rjmregistrasi->get_rm($no_medrec)->row();
		echo json_encode($result);
	}

	public function save_keluarga()
	{
		$no_cm_pasien = $this->input->post('no_cm_pasien');
		$if_exist=$this->rjmregistrasi->show_keluarga($no_cm_pasien)->row();
		$data_save = array(
			'nik' => $this->input->post('keluarga_nik'),
        	'nama' => $this->input->post('keluarga_nama'),
        	'hubungan' => $this->input->post('keluarga_hubungan'),
        	'no_nrp' => $this->input->post('keluarga_nrp'),
        	'tgl_lahir' => $this->input->post('keluarga_tgl_lahir'),
        	'alamat' => $this->input->post('keluarga_alamat'),
        	'telp' => $this->input->post('keluarga_telp'),
        	'agama' => $this->input->post('keluarga_agama'),
        	'pendidikan' => $this->input->post('keluarga_pendidikan'),
        	'pekerjaan' => $this->input->post('keluarga_pekerjaan'),
        	'pangkat' => $this->input->post('keluarga_pangkat'),
        	'alamat_kantor' => $this->input->post('keluarga_alamat_kantor'),
        	'telp_kantor' => $this->input->post('keluarga_telp_kantor'),
        	'jabatan' => $this->input->post('keluarga_jabatan'),
        	'kesatuan' => $this->input->post('keluarga_kesatuan'),
        	'alamat_kesatuan' => $this->input->post('keluarga_alamat_kesatuan'),
        	'telp_kesatuan' => $this->input->post('keluarga_telp_kesatuan'),
        	'no_cm_pasien' => $no_cm_pasien
        );  
        $result ='';         	
		if (empty($if_exist)) {
			$result=$this->rjmregistrasi->insert_keluarga($data_save);
		} else {
			$result=$this->rjmregistrasi->update_keluarga($no_cm_pasien,$data_save);
		}
		echo json_encode($result);
	}

	public function data_keluarga(){
		$data_keluarga=$this->rjmregistrasi->getdata_keluarga();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_keluarga as $keluarga) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $keluarga->no_cm;            
            switch ($keluarga->nrp_sbg) {
				case 'T':		   	
					$row[] = 'Tenaga Kerja';
					break;
				case '1':
				    $row[] = 'Orang Tua';				
				    break;
				case '2':
				    $row[] = 'Suami';				
				    break;
				case '3':
				    $row[] = 'Istri';				
				    break;
				case '4':
				    $row[] = 'Anak Ke-1';				
				    break;
				case '5':
				    $row[] = 'Anak Ke-2';				
				    break;
				case '6':
				    $row[] = 'Anak Ke-3';				
				    break;
				case '7':
				    $row[] = 'Anak Ke-4';				
				    break;
				case '8':
				    $row[] = 'Anak Ke-5';				
				    break;			
			}
            $row[] = $keluarga->nama;
            $row[] = $keluarga->alamat;
            $row[] = $keluarga->no_telp;
            $row[] = $keluarga->pekerjaan;
           	// $row[] = '<center><button type="button" class="btn btn-primary btn-xs" onclick="show_procedure('.$keluarga->id.')"><i class="fa fa-pencil-square-o"></i></button></center>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->rjmregistrasi->keluarga_count_all(),
                        "recordsFiltered" => $this->rjmregistrasi->keluarga_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function data_kotakab($id_prop='',$sid='')
	{
		$data=$this->rjmpencarian->get_kotakab($id_prop)->result();
			echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kecamatan($id_kabupaten='',$sid='')
	{
		$data=$this->rjmpencarian->get_kecamatan($id_kabupaten)->result();
			echo "<option selected value=''>Pilih Kecamatan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}

	public function data_kelurahan($id_kecamatan='',$sid='')
	{
		$data=$this->rjmpencarian->get_kelurahan($id_kecamatan)->result();
			echo "<option selected value=''>Pilih Kelurahan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_dokter_poli($id_poli='')
	{
		$data=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
	}
	public function data_kontraktor($tipe='')
	{
		$result = $this->rjmregistrasi->get_kontraktor_bpjs($tipe)->result();
			// echo "<option selected value=''>-Pilih Penjamin-</option>";
			// foreach($data as $row){
			// 	echo "<option value='$row->id_kontraktor'>$row->nmkontraktor</option>";
			// }
		echo json_encode($result);
	}
	public function data_kontraktorCoba()
	{
		$tipe='BPJS';
		$data=$this->rjmregistrasi->get_kontraktor_bpjs($tipe)->result();
		echo json_encode($data);
	}

	public function data_tindakan_iri(){
		$keyword=$this->input->post('q');
		//echo json_encode($keyword);			
		$data=$this->rjmregistrasi->get_all_tindakan('III',$keyword)->result();
		echo json_encode($data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function pasien($cm='')
	{
		$data['title'] = 'Registrasi Pasien';
		
			
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		}	
		else if($this->input->post('cari_no_cm_lama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_cm_lama'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_lama_history($this->input->post('cari_no_cm_lama'))->result();
		}	
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_kartu_history($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_identitas_history($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_nama_history($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_alamat_history($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_tgl_history($this->input->post('cari_tgl'))->result();
		}else if($this->input->post('cari_no_nrp')!=''){
			//mystring.replace(/,/g , ":")
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nrp($this->input->post('cari_no_nrp'))->result();
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_nrp_history($this->input->post('cari_no_nrp'))->result();
		}
		
		if (empty($data['data_pasien'])==1) 
		{
			$success = 	'<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('irj/rjcregistrasi');
		
		} else {
		
			$this->load->view('irj/rjvformcaripasien',$data);
		}
		
	}
	
	public function cek_available_nokartu($nokartu, $nokartuold='')
	{
		$result=$this->rjmregistrasi->cek_no_kartu($nokartu,$nokartuold);
		echo $result->num_rows();
	}

	public function cek_available_nonrp($nonrp, $nonrpold='')
	{		
		$result=$this->rjmregistrasi->cek_no_nrp(str_replace('_', '/', $nonrp),$nonrpold)->result();
		echo json_encode($result);
	}

	public function cek_available_nonrp1($nonrp, $hub='')
	{
		$result=$this->rjmregistrasi->cek_no_nrp1($nonrp,$hub)->result();
		echo json_encode($result);
	}
	//identitas old masih diperlukan? @rachmatg
	public function cek_available_noidentitas($noidentitas, $noidentitasold='')
	{
		$result=$this->rjmregistrasi->cek_no_identitas($noidentitas, $noidentitasold);
		echo $result->num_rows();
	}
	
	// non tni
	// tni & kel
	public function insert_tindakan_kartu($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		// 1B0104 kartu umum
		// 1B0111 kartu tentara
		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];
			
			if($data1['no_nrp']!=''){
				$data['idtindakan']='1B0111';
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0111')->row();
			}else{
				$data['idtindakan']='1B0104';
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
			}
				
			
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");
			$data['bpjs']='0';
			/*if($data1['jenis_pasien']=='BARU'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
				$data['idtindakan']='BA0102';					
			}else{
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
				$data['idtindakan']='BA0103';
			}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			$data['bpjs']='0';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
	}

	//automatic add action
	// public function insert_tindakan($data1)
	// {
	// 	date_default_timezone_set("Asia/Jakarta");
	// 	$login_data = $this->load->get_var("user_info");
	// 	$user = $login_data->username;
	// 	$data['xuser']=$user;
	// 	$data['xupdate']=date("Y-m-d H:i:s");
	// 	//  1B0102 ADM RAWAT JALAN 
	// 	//  1B0103 ADM RAWAT Darurat
	// 	//  1B0104 KARTU
	// 	//  1B0107 Biaya Spesialis IRJ
	// 	//  1B0108 Biaya IGD
	// 	//  1B0105 Biaya Dokter Akupuntur

	// 	$data['no_register']=$data1['no_register'];
	// 	$no_register=$data1['no_register'];		
	// 	$data['id_poli']=$data1['id_poli'];	
	// 	$cara_bayar=$data1['cara_bayar'];	
	// 	//default 
	// 	if($data['id_poli']=='BA00'){
			
	// 		/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
	// 			$data['idtindakan']='1B0106';
	// 			$data['bpjs']='0';
	// 		}else if($data1['cara_bayar']=='BPJS'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
	// 			$data['idtindakan']='1B0104';
	// 			$data['bpjs']='1';
	// 		}
	// 		else { */
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
	// 			$data['idtindakan']='1B0101';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	/*if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 		$data['idtindakan']='BA0103';
	// 	}		*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);

	// 		//IGD ADD DOCTOR FEE
	// 		// $detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0108')->row();	
	// 		// 	$data['idtindakan']='1B0108';
	// 		// 	if($cara_bayar=='BPJS'){
	// 		// 		$data['bpjs']='1';
	// 		// 	}else
	// 		// 		$data['bpjs']='0';
	// 		// //}
	// 		// $data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0101')->row();
	// 		$data['idtindakan']='BA0101';
	// 	}		

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota+=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);			
			
	// 		//penambahan vtot di daftar_ulang_irj
	// 		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
	// 		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
	// 		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

	// 	}else if($data['id_poli']=='BJ00'){
			
	// 		/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
	// 			$data['idtindakan']='1B0106';
	// 			$data['bpjs']='0';
	// 		}else if($data1['cara_bayar']=='BPJS'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
	// 			$data['idtindakan']='1B0104';
	// 			$data['bpjs']='1';
	// 		}
	// 		else { */
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0103')->row();	
	// 			$data['idtindakan']='1B0103';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	/*if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 		$data['idtindakan']='BA0103';
	// 	}		*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);

	// 		//Akupuntur ADD DOCTOR FEE
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0105')->row();	
	// 			$data['idtindakan']='1B0105';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 		/*if($data1['jenis_pasien']=='BARU'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 			$data['idtindakan']='BA0102';					
	// 		}else{
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 			$data['idtindakan']='BA0103';
	// 		}*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota+=$data['vtot'];

	// 		$id=$this->rjmpelayanan->insert_tindakan($data);			
			
	// 		//penambahan vtot di daftar_ulang_irj
	// 		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
	// 		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
	// 		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

	// 	}else if($data['id_poli']=='CB00'){
			
	// 		/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
	// 			$data['idtindakan']='1B0106';
	// 			$data['bpjs']='0';
	// 		}else if($data1['cara_bayar']=='BPJS'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
	// 			$data['idtindakan']='1B0104';
	// 			$data['bpjs']='1';
	// 		}
	// 		else { */
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();	
	// 			$data['idtindakan']='1B0102';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 		$data['idtindakan']='BA0103';
	// 	}		

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);

	// 		//Akupuntur ADD DOCTOR FEE
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0110')->row();	
	// 			$data['idtindakan']='1B0110';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 		/*if($data1['jenis_pasien']=='BARU'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 			$data['idtindakan']='BA0102';					
	// 		}else{
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 			$data['idtindakan']='BA0103';
	// 		}*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota+=$data['vtot'];

	// 		$id=$this->rjmpelayanan->insert_tindakan($data);			
			
	// 		//penambahan vtot di daftar_ulang_irj
	// 		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
	// 		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
	// 		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

	// 	}else{

	// 		/*if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0106')->row();
	// 			$data['idtindakan']='1B0106';
	// 			$data['bpjs']='0';
	// 		}
	// 		else if($data1['cara_bayar']=='BPJS'){
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0104')->row();
	// 			$data['idtindakan']='1B0104';
	// 			$data['bpjs']='1';
	// 		}			
	// 		else { */
	// 			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
	// 			$data['idtindakan']='1B0101';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}			
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	/*if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 		$data['idtindakan']='BA0103';
	// 	}		*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);
			
	// 		//IGD ADD DOCTOR FEE
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0107')->row();	
	// 			$data['idtindakan']='1B0107';
	// 			if($cara_bayar=='BPJS'){
	// 				$data['bpjs']='1';
	// 			}else
	// 				$data['bpjs']='0';
	// 		//}
	// 		$data['tgl_kunjungan']=date("Y-m-d H:i:s");

	// 	/*if($data1['jenis_pasien']=='BARU'){
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
	// 		$data['idtindakan']='BA0102';					
	// 	}else{
	// 		$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
	// 		$data['idtindakan']='BA0103';
	// 	}		*/

	// 		$data['nmtindakan']=$detailtind->nmtindakan;		

	// 		$data['biaya_tindakan']=$detailtind->total_tarif;
	// 		$data['biaya_alkes']=$detailtind->tarif_alkes;
	// 		$data['qtyind']='1';
	// 		//$data['dijamin']=$this->input->post('dijamin');
	// 		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	// 		$vtota+=$data['vtot'];
	// 		$id=$this->rjmpelayanan->insert_tindakan($data);

	// 		//penambahan vtot di daftar_ulang_irj
	// 		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
	// 		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$vtota;
	// 		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
	// 	}
			

	// 	if($data['id_poli']=='BZ04'){ //lab
	// 		$data4['lab']=1;
	// 		$data4['status_lab']=0;
	// 		$data4['jadwal_lab']=date("Y-m-d H:i:s");
	// 		$data4['ket_pulang']="PULANG";
	// 		$data4['tgl_pulang']=date("Y-m-d");
	// 		$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
	// 	}else if($data['id_poli']=='BZ02'){ //rad
	// 		$data4['rad']=1;
	// 		$data4['status_rad']=0;
	// 		$data4['jadwal_rad']=date("Y-m-d H:i:s");
	// 		$data4['ket_pulang']="PULANG";
	// 		$data4['tgl_pulang']=date("Y-m-d");
	// 		$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
	// 	}else if($data['id_poli']=='BZ01'){ //pa
	// 		$data4['pa']=1;
	// 		$data4['status_pa']=0;
	// 		$data4['jadwal_pa']=date("Y-m-d H:i:s");
	// 		$data4['ket_pulang']="PULANG";
	// 		$data4['tgl_pulang']=date("Y-m-d");
	// 		$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
	// 	}/*else{
	// 		//add periksa
	// 		$detailperiksa=$this->rjmregistrasi->get_tarif_periksa_dokter($data1['id_dokter'])->row();

	// 		$data3['id_dokter']=$data1['id_dokter'];
	// 		$data3['nmtindakan']=$detailperiksa->nmtindakan;
	// 		$data3['nm_dokter']=$detailperiksa->nm_dokter;
	// 		$data3['idtindakan']=$detailperiksa->id_biaya_periksa;
	// 		$data3['qtyind']='1';
	// 		$data3['biaya_tindakan']=$detailperiksa->total_tarif;
	// 		$data3['biaya_alkes']=$detailperiksa->tarif_alkes;
	// 		$data3['vtot']=(int)$data3['biaya_tindakan']+(int)$data3['biaya_alkes'];
	// 		$data3['no_register']=$data1['no_register'];
	// 		$data3['xuser']=$user;
	// 		$id=$this->rjmpelayanan->insert_tindakan($data3);
			
	// 		//penambahan vtot di daftar_ulang_irj
	// 		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
	// 		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data3['vtot'];
	// 		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
	// 	}*/
	// 	$no_register=$data1['no_register'];
	// 	/*if($data1['cara_bayar']!='UMUM'){
	// 	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
	// 	}*/
		
		
	// }


	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];				
		//default BA0102
		if($data['id_poli']=='BA00'){
			//1B0102 ->> BPJS Administrasi
			if($data1['jenis_pasien']=='BARU'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='0';
			}else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='1';
			}
			else { 
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
				$data['idtindakan']='1B0101';
				$data['bpjs']='0';
			}

			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
	//	print_r($data);exit();	
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}else{

			if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='0';
			}
			else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='1';
			}			
			else { 
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
				$data['idtindakan']='1B0101';
				$data['bpjs']='0';
			}			
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}
			
		
                $no_register=$data1['no_register'];
                
		
	}


	public function irj_pulang()
	{			
		$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_belum_pulang()->result();

		$data['title'] = 'Daftar Pasien Rawat Jalan yang Belum Pulang';
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformdaftarpulang',$data);
	}

	public function kontrol_pasien()
	{			//2016-09-25 2017-03-02
		
		if($this->input->post('tgl0')!=''){
			$tgl0=$this->input->post('tgl0');
			$tgl00=date('d-m-Y', strtotime($tgl0));
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
			$tgl00=date('d-m-Y', strtotime('-7 days'));
		}

		if($this->input->post('tgl1')!=''){
			$tgl1=$this->input->post('tgl1');
			$tgl11=date('d-m-Y', strtotime($tgl1));
		}else{
			$tgl1=date('Y-m-d');
			$tgl11=date('d-m-Y');
		}
		$data['daftar_kontrol']=$this->rjmregistrasi->get_daftar_kontrol($tgl0,$tgl1)->result();

		$data['title'] = 'Tanggal Kontrol Pasien | '.$tgl00.' s/d '.$tgl11;
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformkontrol',$data);	
	}	

	public function daftarulang($no_cm)
	{
		$data['title'] = 'Registrasi Pasien';
		$data['waktu_masuk_mr'] = date('Y-m-d h:i:s');
		$data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
		$data['poliumum']='';//$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
			
		if($no_cm != ''){//update
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();			
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			//$this->console_log($data_dokter);
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
			$data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			//$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			$data['hubungan']=$this->rjmpencarian->get_hubungan()->result();

			$data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			$data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
			$data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan']=$this->rjmpencarian->get_pekerjaan()->result();
			$data['online']= 0;
			$data['status'] = 0;
			// $data['cetak_kwitansi'] = 0;
			// $data['lab'] = 0;
			// $data['status_lab']=0;
			// $data['rad'] = 0;
			// $data['status_rad']=0;
			// $data['pa'] = 0;
			// $data['status_pa']=0;
			// $data['ok'] = 0;
			// $data['status_ok']=0;
			// $data['obat'] = 0;
			// $data['status_oba']=0;


			$this->load->view('irj/rjvformdaftar2',$data);
			
			
		}else if($_SERVER['REQUEST_METHOD'] !='POST'){
			redirect('irj/rjcregistrasi');
		}else{
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($no_cm)->row();
			$data['hubungan']=$this->rjmpencarian->get_hubungan()->result();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();			
			$data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			//$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			$data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			$data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
			// $data['kesatuan2']=$this->rjmpencarian->get_kesatuan2()->result();
			// $data['kesatuan3']=$this->rjmpencarian->get_kesatuan3()->result();
			$data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan']=$this->rjmpencarian->get_pekerjaan()->result();
			$data['online']= 0;
			$data['status'] = 0;
			//$data['cetak_kwitansi'] = 0;
			// $data['lab'] = 0;
			// $data['status_lab']=0;
			// $data['rad'] = 0;
			// $data['status_rad']=0;
			// $data['pa'] = 0;
			// $data['status_pa']=0;
			// $data['ok'] = 0;
			// $data['status_ok']=0;
			// $data['obat'] = 0;
			// $data['status_oba']=0;
			
			$this->load->view('irj/rjvformdaftar2',$data);		
		}
	}

	public function daftarulang_online($no_cm="", $id_online="")
	{
		$data['title'] = 'Registrasi Pasien';
		$data['waktu_masuk_mr'] = date('Y-m-d h:i:s');
		$data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
		$data['poliumum']='';//$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
			
		if($no_cm!=''){//update
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_online($no_cm)->row();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();			
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
			$data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			$data['hubungan']=$this->rjmpencarian->get_hubungan()->result();
			$data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			$data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
			$data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			$data['pekerjaan']=$this->rjmpencarian->get_pekerjaan()->result();
			$data['online']=1;
			$data['id_online']=$id_online;
			$this->load->view('irj/rjvformdaftar2',$data);
		}else{
			redirect('irj/rjconline');
		}
	}
	
	function cetak_faktur_kt($no_register='')
	{
			
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			// 
			//print_r($detail_daful);
			if($detail_daful->cara_bayar=='UMUM'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;
			


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}else{
				$txtperusahaan="<td></td>
								<td></td>
								<td></td>";
			}
			
			
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$vtot=0;
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			$jumlah_vtot =  $vtot;
						
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";	
			$nomor=$this->rjmkwitansi->get_no_kwitansi($no_register)->row();	
			$no_kwitansi=$nomor->no_kwitansi;	
			
			$style='';			
			if($data_pasien->sex=='L'){
				$sex='LAKI-LAKI';
			}else{
				$sex='PEREMPUAN';
			}

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:7px;
					    }
					.table-font-size1{
						font-size:8.5px;
					    }
					</style>
					
					<table  border=\"0\" style=\"padding-top:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:7px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam
								<br> $no_kwitansi
							</font></td>						
						</tr>
						
					</table>
						<tr>
						<td colspan=\"3\" ><font size=\"10\" align=\"center\"><u><b>KWITANSI REGISTRASI RAWAT JALAN 
						No. $no_register-1  </b></u></font></td>
					</tr>
					<table class=\"table-font-size1\" border=\"0\" style=\"padding-top:5px;\">		
								
																								
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"35%\">".strtoupper($data_pasien->nama)."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"22%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Kelamin</b></td>
								<td> : </td>
								<td>".$sex."</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->alamat)."</td>
								<td><b>Poli Tujuan</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nm_poli)."</td>
							</tr>
							
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								<td><b>Waktu Shift</b></td>
								<td> : </td>
								<td>".$detail_daful->shift."</td>						
								$txtperusahaan
							</tr>							
							
							<tr>
								<td></td>
								<td></td>
								<td></td>						
								<td></td>
								<td></td>
								<td></td>
							</tr>
																											
					</table>";
															
			
				
			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();

			
			//print_r($data_tindakan);
			$no=1;
			$konten.="<table border=\"1\" style=\"padding:2px\" class=\"table-font-size1\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

			
				foreach($data_tindakan as $row1){
					
					$konten.="
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}

						
			
			$konten.="
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th ><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>

					</table>
					<table style=\"padding-top:5px;\" class=\"table-font-size1\"><tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>
							</tr></table>
					
					";
					/*<table style=\"border:1px solid black; \" >										
					<tr>
						<td width=\"50%\" ><p>Jumlah </p></td>
						<td width=\"10%\">:</td>
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					</table>*/
			
			$konten.="
					
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl								
								
								<br><br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>";


			//echo $konten1;

				$konten1=$konten."<hr>".$konten."<hr>".$konten;
				// var_dump($konten1);die();
				$file_name="Daftar_$no_register-1.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '0', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '2');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi/kwitansi/','refresh');
		}
	}

	public function insert_data_pasien()
	{
		if ($this->input->post('jenis_identitas') == 'KTP') {
			$check_ktp = $this->rjmregistrasi->check_ktp($this->input->post('no_identitas'))->row();
			if (count($check_ktp)) {
				$success = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success">Nomor KTP Sudah Terdaftar.</h3> Harap masukkan nomor KTP yang lain.
                       		</div>';
				$this->session->set_flashdata('success_msg', $success);
				redirect('irj/rjcregistrasi/regpasien');
			}			
		}				

		if ($this->input->post('jenis_identitas')!='') {
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}		
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		
		if($this->input->post('no_kartu') == '') {
			$data['no_kartu'] = NULL;
		} else {
			$data['no_kartu'] = $this->input->post('no_kartu');
		}

		if ($this->input->post('id_kontraktor1')!='') {
			$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}
		if ($this->input->post('id_kontraktor2')!='') {
			$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}

		$data['nama']=strtoupper($this->input->post('nama'));		
		
		if($this->input->post('chk1') != ''){
			
			$data['no_nrp']=$this->input->post('no_nrp');
			$data['nrp_sbg']=$this->input->post('nrp_sbg');

			$data['angkatan_id']=$this->input->post('angkatan');
			if ($this->input->post('kesatuan') != '') {
				$kesatuan = explode("@", $this->input->post('kesatuan'));
				$data['kst_id']=$kesatuan[0];				
				if ($kesatuan[1]) {
					$data['kst2_id']=$kesatuan[1];
				}	
				if ($kesatuan[2]) {
					$data['kst3_id']=$kesatuan[2];
				}				
			}			
			$data['pkt_id']=$this->input->post('pangkat');

		}else{
			$data['no_nrp']=null;
			$data['nrp_sbg']=null;
			$data['angkatan_id']=null;
			$data['kst_id']=null;
			$data['kst2_id']=null;
			$data['kst3_id']=null;
			$data['pkt_id']=null;			
		}

		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');

		if ($this->input->post('load_wilayah') != '') {
			$wilayah = explode("@", $this->input->post('load_wilayah'));
			$data['id_provinsi']=$wilayah[0];
			$data['id_kotakabupaten']=$wilayah[1];
			$data['id_kecamatan']=$wilayah[2];
			$data['id_kelurahandesa']=$wilayah[3];

			$data['provinsi']=$this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
			$data['kotakabupaten']=$this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
			$data['kecamatan']=$this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
			$data['kelurahandesa']=$this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
		}

		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		//$data['no_cm_lama']=$this->input->post('mr_lama');
		$data['goldarah']=$this->input->post('goldarah');
		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		$data['jabatan']=$this->input->post('jabatan');		

		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_daftar']=date("Y-m-d");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');		
		
		$id=$this->rjmregistrasi->insert_pasien_irj($data);
		
		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Baru Berhasil.</h3> Data berhasil disimpan. Silahkan daftar ulang pasien.
                       		</div>';
		$this->session->set_flashdata('success_msg', $success);
		
		redirect('irj/rjcregistrasi/daftarulang/'.$id);
	}
	public function update_data_pasien()
	{
		$no_medrec = $this->input->post('no_medrec');
	//	print_r($no_medrec);die();
		$data['no_cm']=$this->input->post('cm_baru');
		if($this->input->post('jenis_identitas')!=''){
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}		
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		if($this->input->post('no_kartu') == '') {
			$data['no_kartu'] = NULL;
		} else {
			$data['no_kartu'] = $this->input->post('no_kartu');
		}			

		if($this->input->post('chk1')!=''){
			$data['no_nrp']=$this->input->post('no_nrp');
			$data['nrp_sbg']=$this->input->post('nrp_sbg');

			if($this->input->post('angkatan')!='') {
				$data['angkatan_id']=$this->input->post('angkatan');
				$kesatuan = explode("@", $this->input->post('kesatuan'));
				$data['kst_id']=$kesatuan[0];				
				if ($kesatuan[1]) {
					$data['kst2_id']=$kesatuan[1];
				} else {
					$data['kst2_id']='';
				}
				if ($kesatuan[2]) {
					$data['kst3_id']=$kesatuan[2];
				} else {
					$data['kst3_id']='';
				}
				$data['pkt_id']=$this->input->post('pangkat');
			}		
		} else{
			$data['no_nrp']=NULL;
			$data['nrp_sbg']= NULL;
			$data['angkatan_id']=NULL;
			$data['kst_id']=NULL;
			$data['kst2_id']=NULL;
			$data['kst3_id']=NULL;
			$data['pkt_id']=NULL;			
		}

		$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
		$data['no_asuransi1']=$this->input->post('no_asuransi1');
		$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
		$data['no_asuransi2']=$this->input->post('no_asuransi2');
		$data['nama']=$this->input->post('nama');
		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');

		if ($this->input->post('load_wilayah') != '') {		
			$wilayah = explode("@", $this->input->post('load_wilayah'));
			$data['id_provinsi']=$wilayah[0];
			$data['id_kotakabupaten']=$wilayah[1];
			$data['id_kecamatan']=$wilayah[2];
			$data['id_kelurahandesa']=$wilayah[3];		
			$data['provinsi']=$this->rjmregistrasi->nm_provinsi($data['id_provinsi'])->nama;
			$data['kotakabupaten']=$this->rjmregistrasi->nm_kota($data['id_kotakabupaten'])->nama;
			$data['kecamatan']=$this->rjmregistrasi->nm_kecamatan($data['id_kecamatan'])->nama;
			$data['kelurahandesa']=$this->rjmregistrasi->nm_kelurahan($data['id_kelurahandesa'])->nama;
		}

		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		$data['jabatan']=$this->input->post('jabatan');	

		date_default_timezone_set("Asia/Jakarta");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;

		$id=$this->rjmregistrasi->update_pasien_irj($data,$no_medrec);		
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);
	}

	public function insert_daftar_ulang()
	{	
		$no_medrec=$this->input->post('no_medrec');
		$no_rujukan=$this->input->post('no_rujukan');
		$no_kartu=$this->input->post('no_kartu');
		// var_dump($this->input->post('cetak_kartu'));die();

		$cek_data_poli=$this->rjmregistrasi->cek_data_poli($no_medrec)->row();
		
		if (isset($cek_data_poli) && $this->input->post('id_poli')!='BA00') {
			$data_poli = $cek_data_poli->nm_poli;
			$notification = '<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	Pasien sudah terdaftar pada poli "'.$cek_data_poli->nm_poli.'" pada tanggal "'.date_indo(date('Y-m-d',strtotime($cek_data_poli->tgl_kunjungan))).' | '.date('H:i',strtotime($cek_data_poli->tgl_kunjungan)).'". <br>Silahkan Pulangkan Kunjungan Sebelumnya.
                       		</div>';
			$this->session->set_flashdata('notification', $notification);			
			redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);			
		} else {						
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
			$tahun=0;
			$bulan=0;
			$hari=0;
			foreach($get_umur as $row)
			{
				$tahun=floor($row->umurday/365);
				$bulan=floor(($row->umurday - ($tahun*365))/30);
				$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
			}

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;

			$data['no_medrec']=$no_medrec;
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');
			$data['catatan']=$this->input->post('entri_catatan');	

			if ($this->input->post('kll_penjamin')) {
				$data['kll_penjamin'] = implode(',', $this->input->post('kll_penjamin'));
			}

			if ($this->input->post('katarak') == 1) {
				$data['katarak'] = 1;
			} else $data['katarak'] = 0;

			$data['nosurat_skdp_sep'] = $this->input->post('nosurat_skdp_sep');
			$data['dpjp_skdp_sep'] = $this->input->post('dpjp_skdp_sep');
			if ($this->input->post('alber') == 'kecelakaan') {
				$data['kll_tgl_kejadian'] = $this->input->post('kll_tgl_kejadian');
				$data['kll_provinsi'] = $this->input->post('kll_provinsi');
				$data['kll_kabupaten'] = $this->input->post('kll_kabupaten');
				$data['kll_kecamatan'] = $this->input->post('kll_kecamatan');
				$data['kll_ketkejadian'] = $this->input->post('kll_ketkejadian');
			}

			$data['no_rujukan']=$this->input->post('no_rujukan');
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar'] = $this->input->post('cara_bayar');
			$data['id_kontraktor'] = $this->input->post('id_kontraktor');
			if($this->input->post('id_diagnosa')!=''){
				$data['diagnosa']=$this->input->post('id_diagnosa');
			}
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');

			if($this->input->post('id_poli')=='BA00'){
				$data['alasan_berobat']=$this->input->post('alber');
		
				if($this->input->post('pasdatDg')!=''){
					$data['datang_dengan']=$this->input->post('pasdatDg');}

				if($this->input->post('jenis_kecelakaan')!=''){
					$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
					if($this->input->post('lokasi_kecelakaan')!=''){
						$data['lokasi_kecelakaan']=$this->input->post('lokasi_kecelakaan');
					}
				}
			}

			$data['biayadaftar']=0;
			
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;

			$data['xcreate']=$this->input->post('user_name');
			$data['atas_nama']=$this->input->post('atas_nama');
			$data['tgl_kunjungan']=date('Y-m-d H:i:s');
			$data['xupdate']=date('Y-m-d H:i:s');
			if($this->input->post('online')==1)
				$data['online']=1;
			
			$id=$this->rjmregistrasi->insert_daftar_ulang($data);
			// Start 
			// Update Daful Online. Jika berhasil flag rubah 1
			// 06 Juli 2018 
			$id_online = $this->input->post('id_online');
			if($this->input->post('online')==1){ 
				$http_header = array(
					   'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImNlZmZjMjMyMTA5YWY2NDIwNDViNmE0YzZjZWY0ZWRkNjQyZjQzYTJjZWE5YWM2MzgxMDQ1ZjI5NjU5ZmE1OTFiM2M1Zjg4YWM5OGE0OWU1In0.eyJhdWQiOiIzIiwianRpIjoiY2VmZmMyMzIxMDlhZjY0MjA0NWI2YTRjNmNlZjRlZGQ2NDJmNDNhMmNlYTlhYzYzODEwNDVmMjk2NTlmYTU5MWIzYzVmODhhYzk4YTQ5ZTUiLCJpYXQiOjE1MzExMDcwOTIsIm5iZiI6MTUzMTEwNzA5MiwiZXhwIjoxNTYyNjQzMDkyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.PKurqaMA_RWoILkwaIxkyckJMFXswV3bHJkiL3XDTLsp_MukheKtd05nTxDl-eFueqmLVE-X6MsYTxZOfx14km8GYucpqHy-k9B84Dl0yUySOYAF5xPz6Po3jjSLASpCXjycsliC0Jr0eQp2UiDuLXTQE-FR4D9MzfbXqKM2QOVwI3oAhBeqlPI-DQVji2W3Xe2xSzskvxM-NuxPZfl5qUVEBxApodouU1U1Dnx8vhvkERJ7yX8rgba1WkrfnLelIDXauA-zkWZY-HZCISCEi-InEhEk99xYpCjgab09Rb8TETu6GtAK_DhOZOqtEpvIHY5JheVPZHfE9JbpueJG_PBkgpR_71AkwPxnuoQHfdGI5PsamUanoucKLssHrU5wQpwGhnuu0LW-_9ih0S22zRCQIZ7ZpO9S-py5xCYEVbPeBWSk6ThLPs-1XsaGAQubY7OVSKVAsdJSIp3wrqkUPbDZdxNYAD8RVXdMUBzDqN5P5GVWDZPPE4--9QId7lRWyRr2_EG7Ma_19vrq_cb9EES3v8DE-nbPBX1DEwQQWPR63nyqKZBZOpz0aTEr7wd6I7QSfuRCMtcgAFUKCMEywOZ6tiMhu4YSn_z1ofUeIrbtDDYSBmk612k29ZtUABtcrlq6IcAWVX_PeRqmNU0RtMgp6TEvBqnBWjCCS_7rimM', 
					   'Content-Type: application/x-www-form-urlencoded',
					   'X-cons-id: ' . 'application/json'
				);
				$ch = curl_init('http://182.253.223.45/rsal_mintohardjo/api/daful_confrim/'.$id_online);
				// curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				// print_r($result);
				curl_close($ch);
			}
			/** End */

			$data['no_nrp']=$this->input->post('hidden_nrpdaful');				
			$data['no_register']=$id->no_register;

			$data['jenis_pasien']=$this->input->post('jns_kunj');
			if($this->input->post('cetak_kartu')=='1'){
				$this->insert_tindakan_kartu($data);
				$no_cm = $this->input->post('cetak_kartu1');
				// echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm").'", "_blank");</script>';
			}


	//--- UNTUK CETAK SJP BAGI PASIEN DI JAMIN
              if($data['cara_bayar'] == "KERJASAMA" || $data['cara_bayar'] == "KERJASAMA" ){
				echo '<script type="text/javascript">window.open("'.site_url("irj/rjcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
			}				
//-- END OF CETAK SJP			
      
			if($this->input->post('extra') != '1'){
					
					$this->insert_tindakan($data);
			}	
		
			if($this->input->post('jns_kunj')=='BARU'){
				 echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/").'/'.$this->input->post('cetak_kartu1').'", "_blank");window.focus()</script>';
			}	

			$no_register=$id->no_register;
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/").'/'.$no_register.'", "_blank");window.focus()</script>';	

			if ($data['cara_bayar'] == "BPJS") {
				$notification = '<div class="alert alert-success">
					            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
					            <h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
					            <div class="form-actions">
						            <div class="row">
										<div class="col-md-12"> 
											<hr style="margin-top: 5px;"> 
											<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_tracer(\''.$no_register.'\',\''.$data['jns_kunj'].'\')"><i class="fa fa-print"></i> Cetak Tracer</button>	
											<button class="btn waves-effect waves-light btn-primary create_sep" data-noregister="'.$no_register.'" target="_blank"><i class="fa fa-print"></i> Buat SEP</button>								       
										</div>   
									</div>
								</div> 
				        	</div>';			
			} else {
				
				$notification = '<div class="alert alert-success">
					            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
					            <h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
					            <div class="form-actions">
						            <div class="row">
										<div class="col-md-12"> 
											<hr style="margin-top: 5px;"> 
											<button class="btn waves-effect waves-light btn-danger" type="button" onclick="cetak_tracer(\''.$no_register.'\',\''.$data['jns_kunj'].'\')"><i class="fa fa-print"></i> Cetak Tracer</button>									
										</div>   
									</div>
								</div> 
				        	</div>';	
			}
		}

		$this->session->set_flashdata('success_msg', $notification);
		if($this->input->post('online')==1) {
			redirect('irj/rjconline');
		} else {
			redirect('irj/rjcregistrasi');
		}
	}	

	public function sep_print($fields)
	{			
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: ".$fields['No. SEP']."</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: ".$fields['Tgl. SEP']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: ".$fields['No. Kartu']." MR: ".$fields['No. Medrec']."</td>
						<td>Peserta</td>
						<td>: ".$fields['Peserta']."</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: ".$fields['Nama Peserta']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: ".$fields['Tgl. Lahir']."</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: ".$fields['Jenis Kelamin']."</td>
						<td>Jenis Rawat</td>
						<td>: ".$fields['Jenis Rawat']."</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: ".$fields['Poli Tujuan']."</td>
						<td>Kelas Rawat</td>
						<td>: ".$fields['Kelas Rawat']."</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: ".$fields['Asal Faskes']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: ".$fields['Diagnosa Awal']."</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: ".$fields['Catatan']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields['Cetakan Ke']."</td>
						<td>: ".$date->format('d-m-Y H:i:s')."</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
		$file_name="sep_".$fields['No. Register'].".pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}	
	public function pasien_bpjs($no_register='')
	{
		$data['title'] = 'Daftar Pasien Rawat Jalan';
		$data['message'] = $this->session->flashdata('message');

		if($no_register==''){
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien()->result();
			$this->console_log($data['daftar_pasien']);
			$this->load->view('irj/rjvformdaftarbpjs',$data);
		}else{
			$data['detail_pasien']=$this->rjmregistrasi->get_detail_daful($no_register)->result();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();

			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();

			$this->load->view('irj/rjvformdaful',$data);
		}
			
	}
	public function insert_pasien_bpjs()
	{			
			//get umur
			$no_medrec=$this->input->post('no_medrec');
			$no_register=$this->input->post('no_register');
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
			$tahun=0;
			$bulan=0;
			$hari=0;
			foreach($get_umur as $row)
			{
				// echo $row->umurday;
				$tahun=floor($row->umurday/365);
				$bulan=floor(($row->umurday - ($tahun*365))/30);
				$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
			}

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;
			$data['tgl_kunjungan']=$this->input->post('tgl_kunj')." ".date('H:i:s');
			
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');

			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}

			$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('jenis_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('jenis_kontraktor');
			}
			$data['diagnosa']=$this->input->post('id_diagnosa');
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');
			$data['no_sep']=$this->input->post('no_sep');


			$id=$this->rjmregistrasi->update_daftar_ulang($no_register,$data);
			
			if ($data['cara_bayar']=="BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">

									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>

									Daftar ulang pasien berhasil. &nbsp;<a href="'.site_url('irj/rjcregistrasi/buat_SEP/'.$no_register).'" class="btn btn-danger">Cetak SEP</a>
									</h4>
								</div>
							</div>
						</div>';
			} else {
				$success = 	'

						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>

									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.

									</h4>
								</div>
							</div>
						</div>';
			}
			
			$this->session->set_flashdata('success_msg', $success);
		
			redirect('irj/rjcregistrasi/pasien_bpjs/'.$no_register,'refresh');
			
	}

	public function rekap_tracer(){		
		$data['title'] = 'Daftar Rekap Tracer Pasien Poli';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('Y-m-d',strtotime($date));
			$data['pasien_tracer']=$this->rjmregistrasi->get_pasien_tracer($date)->result();
		}else{
			$data['pasien_tracer']=$this->rjmregistrasi->get_pasien_tracer(date('Y-m-d'))->result();
		}
		$this->load->view('irj/rjvformrekaptracer',$data);
	}

	
	//CETAK KARCIS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_tracer_old($no_register='')
	{
		if($no_register!=''){
			/*$get_nokarcis=$this->rjmkwitansi->get_new_nokarcis($no_register)->result();
				foreach($get_nokarcis as $val){
					$noseri_karcis=sprintf("B%s%05s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_nokarcis($noseri_karcis,$no_register);
			*/
			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
			

			$data_tracer=$this->rjmregistrasi->getdata_tracer($no_register)->result();			
			foreach($data_tracer as $row){
				if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
				$no_medrec=$row->no_medrec;
				$txtperusahaan='';
				if($row->nmkontraktor!=''){
					if($row->cara_bayar=='BPJS'){
						$txtperusahaan=$row->nmkontraktor;
					}
					else $txtperusahaan=$row->cara_bayar." - ".$row->nmkontraktor;
				}else $txtperusahaan='UMUM';
				$konten=
					"<style type=\"text/css\">
					.table-font-size{
							font-size:14px;
					    }
					</style>					
					$namars | $alamatrs
					
					<h1 style=\"font-size:15px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<u>No. Antrian</u>&nbsp; &nbsp;&nbsp;: $row->no_antrian</h1><br/>
					<table class=\"table-font-size\">
						<tr>
							<td width=\"20%\"><h4>No. MR</h4></td>
							<td width=\"5%\"> : </td>
							<td width=\"30%\"><b>$row->no_cm</b></td>
							<td >Pasien</td>
							<td width=\"5%\"> : </td>
							<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>							
						</tr>
						<tr>
							<td>Tgl Registrasi</td>
							<td> : </td>
							<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
							
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
							
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nama</b></td>
						</tr>												
						<tr>
							<td>Unit Tujuan</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nm_poli</b></td>
						</tr>
						
						<tr>
							<td>Tgl Lahir</td>
							<td> : </td>
							<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>
						<tr>
							<td>Umur</td>
							<td> : </td>
							<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
						</tr>
						<tr>
							<td>Kelamin</td>
							<td> : </td>
							<td >$sex</td>
						</tr>";

						if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
							$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
							foreach($data_tracer as $row1){
								if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
									$txtpulang='| '.$row1->ket_pulang;
								}else $txtpulang='';

								$konten1="<tr>
									<td>Unit & Kunjungan Lalu</td>
									<td> : </td>
									<td colspan=\"4\">".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
								</tr>";
								}
						}else $konten1="<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>";

						$login_data = $this->load->get_var("user_info");
						if($login_data->name=='' || $login_data->name==null){
							$user=$login_data->username;
						}else $user=$login_data->name;

						$konten=$konten."$konten1<tr>
							<td>Petugas</td>
							<td> : </td>
							<td colspan=\"2\">".$user."</td>
						</tr>						
						<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
					</table><br>
					<hr/>
					<br>
				";
						
						
			
						
			}
			print_r($konten);
			$konten1=$konten."<br>".$konten."<br>".$konten;
			$file_name="Tracer_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('5', '5', '5');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '2');
				$obj_pdf->SetFont('helvetica', '', 7);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'/download/irj/rjtracer/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}

		public function cetak_tracer($no_register='')
	{
		if($no_register!=''){
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			
			

			$data_tracer=$this->rjmregistrasi->getdata_tracer($no_register)->result();			
			foreach($data_tracer as $row){
				if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
				$no_medrec=$row->no_medrec;
				$txtperusahaan='';
				if($row->cara_bayar!='UMUM'){
					$txtperusahaan="BPJS ".$row->nmkontraktor;
				} else $txtperusahaan='UMUM';
				$konten=
					"<style type=\"text/css\">
					.table-font-size{
							font-size:10px;
					    }
					</style>					
					$namars | $alamatrs
					
					<br/>
					<table class=\"table-font-size\" style=\"text-align:center;\">
							<tr>
							<td style=\"font-size:22px;font-weight:bold;\">$row->no_antrian</td>
							</tr>
						</table>
						<br>
					<table class=\"table-font-size\">	
						<tr>
							<td width=\"32%\"></td>
							<td width=\"5%\"></td>
							<td width=\"52%\"></td>
							=======================================
						</tr>
						
						<tr>
							<td></td>
							<td></td>
							<td></td>							
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							
						</tr>

						<tr>
							<td >No. Registrasi</td>
							<td > : </td>
							<td >$row->no_register</td>
						</tr>					
																
						<tr>
							<td>Tgl Jam</td>
							<td> : </td>
							<td>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</td>
							
						</tr>						
						<tr>
							<td>No. RM</td>
							<td> : </td>
							<td><b>".$row->no_cm."</b></td>
							
						</tr>";
						if($row->no_cm_lama != '') {
						$konten2="<tr>
							<td>No. RM Lama </td>
							<td> : </td>
							<td>".$row->no_cm_lama."</td>
							
						</tr>";
						}
						$konten3="<tr>
							<td>Nama</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nama</b></td>
						</tr>	
						
						<tr>
							<td>Tgl Lahir</td>
							<td> : </td>
							<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>


						<tr>
							<td>Layanan</td>
							<td> : </td>
							<td colspan=\"2\">$row->nm_poli</td>
						</tr>

						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td colspan=\"2\">$txtperusahaan</td>
						</tr>

						<tr>
							<td>Pendaftar</td>
							<td> : </td>
							<td colspan=\"2\">$row->xuser</td>
						</tr>";

						$login_data = $this->load->get_var("user_info");
						if($login_data->name=='' || $login_data->name==null){
							$user=$login_data->username;
						}else $user=$login_data->name;

						$konten=$konten.$konten2.$konten3."$konten1
						<tr>
							<td>Petugas</td>
							<td> : </td>
							<td colspan=\"2\">".$user."</td>
						</tr>						
						<tr>
						=======================================
							<td width=\"18%\"></td>
							<td width=\"4%\"></td>
							<td width=\"78%\"></td>
							</tr>							

					</table>
				";
						
						
			
						
			}
			print_r($konten);
			$konten1=$konten;
			$file_name="Tracer_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$width = 120;
				$height = 120;
				$pageLayout = array($width, $height); 
				$obj_pdf = new TCPDF('P', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('5', '5', '5');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '0');
				$obj_pdf->SetFont('helvetica', '', 7);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'/download/irj/rjtracer/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_identitas($no_cm='')
	{
		error_reporting(~E_ALL);

		if($no_cm!=''){
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$telprs=$this->config->item('telp');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
			$data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();						
			foreach($data_identitas as $row){
			$interval = date_diff(date_create(), date_create($row->tgl_lahir));
			$conf=$this->appconfig->get_headerpdf_appconfig($no_register)->result();

			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
			$header_page = $top_header.$logo_header.$bottom_header.'<br><hr/>';

							
			$konten_header=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
					    }
					</style>
										
					";
			$konten = $header_page;
			// echo $konten;die();
			$keluarga = '';
			if ($row->no_nrp != '' && $row->nrp_sbg != 'T') {
				$keluarga=$this->rjmregistrasi->keluarga_anggota($row->no_nrp);
				if ($keluarga) {
					$konten.="<style type=\"text/css\">
							.table-font-size2{
								font-size:7px;
							    }
							</style>
							<hr/>
							<p align=\"center\" style=\"font-size:11px\"><u><b>IDENTITAS PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								".($row->no_cm_lama!='' ? '<tr>
									<td width="27%"><b>NO. RM LAMA</b></td>
									<td width="5%"><b>:</b></td>
									<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
								</tr>':'')."					
								<tr>
									<td width=\"27%\">TANGGAL DAFTAR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
								</tr>
								".($row->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$row->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">USIA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								</tr>
											
											
										
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? ' ' : $row->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
								</tr>								
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">AGAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PERKAWINAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PASIEN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
										')."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
								</tr>
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->pkt_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kst_name).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
							<br/>
							<p align=\"center\" style=\"font-size:11px\"><u><b>KELUARGA PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">																		
								".($keluarga->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$keluarga->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->sex=='L'? 'LAKI-LAKI':($keluarga->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga->tmpt_lahir).", ".date('d-m-Y', strtotime($keluarga->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->alamat=='' ? ' ' :$keluarga->alamat).' '.($keluarga->kelurahandesa!='' ? 'KEL. '.$keluarga->kelurahandesa:'').' '.($keluarga->kecamatan!='' ? 'KEC. '.$keluarga->kecamatan:'').' '.($keluarga->kotakabupaten!='' ? ', '.$keluarga->kotakabupaten:'').' '.($keluarga->provinsi!='' ? ', '.$keluarga->provinsi:'')." ".($keluarga->no_hp=='' ? ' ' : $keluarga->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->pekerjaan=='' ? ($keluarga->angkatan_name!='' ? $keluarga->angkatan_name : '................................................................................................') :$keluarga->pekerjaan)."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">........................................................................................................................................................................................................................../".($keluarga->no_telp_kantor=='' ? '.....................................................................' :$keluarga->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($keluarga->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->no_kartu=='' ? '-': $keluarga->no_kartu)."</td>
								</tr>
								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($keluarga->no_nrp).'</b></td>
								</tr>':'')."
								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->pkt_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">JABATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->jabatan=='' ? '.................................' :strtoupper($keluarga->jabatan))."</td>
								</tr>
								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->kst_name).'</td>
								</tr>':'')."
								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->kesatuan_ehr).'</td>
								</tr>':'')."

								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->jabatan_ehr).'</td>
								</tr>':'')."
								".($keluarga->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
					";
				} else {
					$keluarga_pasien=$this->rjmregistrasi->show_keluarga($row->no_cm)->row();
					if ($keluarga_pasien) {
						$konten.="<style type=\"text/css\">
							.table-font-size2{
								font-size:7px;
							    }
							</style>
							<p align=\"center\" style=\"font-size:11px\"><u><b>IDENTITAS PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								".($row->no_cm_lama!='' ? '<tr>
									<td width="27%"><b>NO. RM LAMA</b></td>
									<td width="5%"><b>:</b></td>
									<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
								</tr>':'')."					
								<tr>
									<td width=\"27%\">TANGGAL DAFTAR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
								</tr>
								".($row->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$row->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">USIA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								</tr>
											
											
										
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? ' ' : $row->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
								</tr>								
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">AGAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PERKAWINAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PASIEN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
										')."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
								</tr>
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->pkt_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kst_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
							<br/>
							<p align=\"center\" style=\"font-size:11px\"><u><b>KELUARGA PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">																		
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga_pasien->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">HUBUNGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga_pasien->hubungan)."</td>
								</tr>
								<tr>
									<td width=\"27%\">TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".date('d-m-Y', strtotime($keluarga_pasien->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT RUMAH</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga_pasien->alamat</td>
								</tr>
								<tr>
									<td width=\"27%\">NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga_pasien->telp</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga_pasien->pekerjaan</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga_pasien->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$keluarga_pasien->alamat).' '.($keluarga_pasien->no_telp=='' ? '....................................' :'/ '.$keluarga_pasien->no_telp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga_pasien->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($keluarga_pasien->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>$keluarga_pasien->no_nrp</b></td>
								</tr>
								".($keluarga_pasien->no_nrp != '' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga_pasien->pangkat).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">JABATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga_pasien->jabatan=='' ? '.................................' :strtoupper($keluarga_pasien->jabatan))."</td>
								</tr>
								".($keluarga_pasien->kesatuan != '' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga_pasien->kesatuan).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">ALAMAT KESATUAN/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga_pasien->alamat_kesatuan=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$keluarga_pasien->alamat_kesatuan).' '.($keluarga_pasien->telp_kesatuan=='' ? '....................................' :'/ '.$keluarga_pasien->telp_kesatuan)."</td>
								</tr>
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
					";
					} else {
						$konten.=
									"<style type=\"text/css\">
									.table-font-size2{
										font-size:10px;
									    }
									</style>
									<p align=\"center\" style=\"font-size:13px\"><u><b>IDENTITAS PASIEN</b></u></p>
									<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
										".($row->no_cm_lama!='' ? '<tr>
											<td width="27%"><b>NO. RM LAMA</b></td>
											<td width="5%"><b>:</b></td>
											<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
										</tr>':'')."					
										<tr>
											<td width=\"27%\">TANGGAL DAFTAR</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
										</tr>
										".($row->jenis_identitas== 'KTP' ? '<tr>
											<td width="27%">NIK</td>
											<td width="5%">:</td>
											<td width="68%">'.$row->no_identitas.'</td>
										</tr>':'')."
										<tr>
											<td width=\"27%\">NAMA LENGKAP</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".strtoupper($row->nama)."</td>
										</tr>
										<tr>
											<td width=\"27%\">JENIS KELAMIN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
										</tr>
										<tr>
											<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
										</tr>
										<tr>
											<td width=\"27%\">USIA</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
										</tr>
													
													
												
										<tr>
											<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? ' ' :$row->no_hp)."</td>
										</tr>
										<tr>
											<td width=\"27%\">PEKERJAAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
										</tr>
										<tr>
											<td width=\"27%\">JABATAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->jabatan=='' ? ' ' :strtoupper($row->jabatan))."</td>
										</tr>
										<tr>
											<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
										</tr>
										<tr>
											<td width=\"27%\">AGAMA</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
										</tr>
										<tr>
											<td width=\"27%\">PENDIDIKAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
										</tr>
										<tr>
											<td width=\"27%\">STATUS PERKAWINAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
										</tr>
										<tr>
											<td width=\"27%\">STATUS PASIEN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
												')."</td>
										</tr>
										<tr>
											<td width=\"27%\">NO KARTU BPJS</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
										</tr>
										".($row->nrp_sbg == 'T' ? '<tr>
											<td width=\"27%\">NIP/NRP</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
										</tr>':'')."
										".($row->nrp_sbg == 'T' ? '<tr>
											<td width=\"27%\">PANGKAT/ GOLONGAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">'.($row->pkt_name).'</td>
										</tr>':'')."
										".($row->nrp_sbg == 'T' ? '<tr>
											<td width=\"27%\">KESATUAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">'.($row->kst_name).'</td>
										</tr>':'')."
										".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
										".($row->nrp_sbg == 'T' ? '<tr>
											<td width=\"27%\">ANGKATAN</td>
											<td width=\"5%\">:</td>
											<td width=\"68%\">'.($row->angkatan_name).'</td>
										</tr>':'')."
										<tr>
											<td width=\"27%\"></td>
											<td width=\"5%\"></td>
											<td width=\"68%\"></td>
										</tr>												
									</table>
							";
					}
					
				}
				
			}
			else if ($row->no_nrp == '') {
				$keluarga=$this->rjmregistrasi->show_keluarga($row->no_cm)->row();
				if ($keluarga) {
					$konten.="<style type=\"text/css\">
							.table-font-size2{
								font-size:7px;
							    }
							</style>
							<p align=\"center\" style=\"font-size:11px\"><u><b>IDENTITAS PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								".($row->no_cm_lama!='' ? '<tr>
									<td width="27%"><b>NO. RM LAMA</b></td>
									<td width="5%"><b>:</b></td>
									<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
								</tr>':'')."					
								<tr>
									<td width=\"27%\">TANGGAL DAFTAR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
								</tr>
								".($row->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$row->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">USIA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								</tr>
											
											
										
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? '' :$row->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
								</tr>								
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">AGAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PERKAWINAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PASIEN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
										')."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
								</tr>
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->pkt_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kst_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
							<br/>
							<p align=\"center\" style=\"font-size:11px\"><u><b>KELUARGA PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">																		
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">HUBUNGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($keluarga->hubungan)."</td>
								</tr>
								<tr>
									<td width=\"27%\">TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".date('d-m-Y', strtotime($keluarga->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT RUMAH</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga->alamat</td>
								</tr>
								<tr>
									<td width=\"27%\">NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga->telp</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">$keluarga->pekerjaan</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$keluarga->alamat).' '.($keluarga->no_telp=='' ? '....................................' :'/ '.$keluarga->no_telp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($keluarga->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>$keluarga->no_nrp</b></td>
								</tr>
								".($keluarga->no_nrp != '' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->pkt_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">JABATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->jabatan=='' ? '.................................' :strtoupper($keluarga->jabatan))."</td>
								</tr>
								".($keluarga->kesatuan != '' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->kesatuan).'</td>
								</tr>':'')."
								".($keluarga->pangkat != '' ? '<tr>
									<td width=\"27%\">PANGKAT</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($keluarga->pangkat).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">ALAMAT KESATUAN/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($keluarga->alamat_kesatuan=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$keluarga->alamat_kesatuan).' '.($keluarga->telp_kesatuan=='' ? '....................................' :'/ '.$keluarga->telp_kesatuan)."</td>
								</tr>
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
					";
				} else {
					$konten.=
							"<style type=\"text/css\">
							.table-font-size2{
								font-size:10px;
							    }
							</style>
							<p align=\"center\" style=\"font-size:13px\"><u><b>IDENTITAS PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								".($row->no_cm_lama!='' ? '<tr>
									<td width="27%"><b>NO. RM LAMA</b></td>
									<td width="5%"><b>:</b></td>
									<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
								</tr>':'')."					
								<tr>
									<td width=\"27%\">TANGGAL DAFTAR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
								</tr>
								".($row->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$row->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">USIA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								</tr>
											
											
										
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? ' ' : $row->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JABATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->jabatan=='' ? ' ' :strtoupper($row->jabatan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">AGAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PERKAWINAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PASIEN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
										')."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
								</tr>
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->pkt_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kst_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
					";
				}
				
			}
			else {
				$konten.=
							"<style type=\"text/css\">
							.table-font-size2{
								font-size:10px;
							    }
							</style>
							<p align=\"center\" style=\"font-size:13px\"><u><b>IDENTITAS PASIEN</b></u></p>
							<table class=\"table-font-size2 \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								".($row->no_cm_lama!='' ? '<tr>
									<td width="27%"><b>NO. RM LAMA</b></td>
									<td width="5%"><b>:</b></td>
									<td width="68%"><b>'.$row->no_cm_lama.'</b></td>
								</tr>':'')."					
								<tr>
									<td width=\"27%\">TANGGAL DAFTAR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
								</tr>
								".($row->jenis_identitas== 'KTP' ? '<tr>
									<td width="27%">NIK</td>
									<td width="5%">:</td>
									<td width="68%">'.$row->no_identitas.'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\">NAMA LENGKAP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->nama)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JENIS KELAMIN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
								</tr>
								<tr>
									<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".strtoupper($row->tmpt_lahir).", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
								</tr>
								<tr>
									<td width=\"27%\">USIA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								</tr>
											
											
										
								<tr>
									<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->alamat=='' ? ' ' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')." ".($row->no_hp=='' ? ' ' : $row->no_hp)."</td>
								</tr>
								<tr>
									<td width=\"27%\">PEKERJAAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : ' ') :$row->pekerjaan)."</td>
								</tr>
								<tr>
									<td width=\"27%\">JABATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->jabatan=='' ? ' ' :strtoupper($row->jabatan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"> ".($row->no_telp_kantor=='' ? ' ' :$row->no_telp_kantor)."</td>
								</tr>
								<tr>
									<td width=\"27%\">AGAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->agama=='' ? '' :strtoupper($row->agama))."</td>
								</tr>
								<tr>
									<td width=\"27%\">PENDIDIKAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->pendidikan=='' ? '' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PERKAWINAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
								</tr>
								<tr>
									<td width=\"27%\">STATUS PASIEN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".(($row->no_nrp=='' && $row->no_kartu=='' )? 'UMUM':'BPJS - DIJAMIN
										')."</td>
								</tr>
								<tr>
									<td width=\"27%\">NO KARTU BPJS</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
								</tr>
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">NIP/NRP</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\"><b>'.($row->no_nrp).'</b></td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">PANGKAT/ GOLONGAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->pkt_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kst_name).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">KESATUAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->kesatuan_ehr).'</td>
								</tr>':'')."

								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">JABATAN DATA LAMA</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->jabatan_ehr).'</td>
								</tr>':'')."
								".($row->nrp_sbg == 'T' ? '<tr>
									<td width=\"27%\">ANGKATAN</td>
									<td width=\"5%\">:</td>
									<td width=\"68%\">'.($row->angkatan_name).'</td>
								</tr>':'')."
								<tr>
									<td width=\"27%\"></td>
									<td width=\"5%\"></td>
									<td width=\"68%\"></td>
								</tr>												
							</table>
					";
			}
			
						
			}
			$file_name="Identitas_$no_cm.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('15', '10', '15');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 10);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten_header.$konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'/download/irj/rjidentitas/'.$file_name, 'FI');				
				
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP
	public function buat_SEP($no_register) {

		//$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = time();  //cari timestamp
		//echo $timestamp."asa";
        
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
        $encoded_signature = base64_encode($signature);
		//echo $encoded_signature."asa";
        
		$http_header = array(
               'Accept: application/json', 
               'Content-type: application/x-www-form-urlencoded',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
        );
		 
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		
         // nama variabel sesuai dengan nama di xml
         $noKartu = $data['data_pasien_daftar_ulang']->no_kartu;
		 $tglSep = date('Y-m-d H:i:s');
         $tglRujukan = $data['data_pasien_daftar_ulang']->tgl_rujukan;
         $noRujukan = $data['data_pasien_daftar_ulang']->no_rujukan;
         $ppkRujukan = $data['data_pasien_daftar_ulang']->asal_rujukan;
		 $ppkPelayanan = '10000'; //id rs
         $jnsPelayanan = '2'; //1->RJ 2->RD 3-> RI
		 $catatan = 'Coba SEP Bridging';
         $diagAwal = $data['data_pasien_daftar_ulang']->diagnosa;
         $poliTujuan = $data['data_pasien_daftar_ulang']->id_poli;
		 $klsRawat = $data['data_pasien_daftar_ulang']->kelas_pasien;
		 $lakaLantas = '2';
         $user = $logged_in_user_info->username;
         $noMr = $data['data_pasien_daftar_ulang']->no_medrec;
         
		 $data = '<request>
					<data>
					<t_sep>
					<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
					 
					</t_sep>
					</data>
				</request>';
				/*
				
					<poliTujuan>'.$poliTujuan.'</poliTujuan>
					
					 
					 
<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
 
 <noKartu>'.$noKartu.'</noKartu>
					<tglSep>'.$tglSep.'</tglSep>
					<tglRujukan>'.$tglRujukan.'</tglRujukan>
					<noRujukan>'.$noRujukan.'</noRujukan>
					<ppkRujukan>'.$ppkRujukan.'</ppkRujukan>
					<ppkPelayanan>'.$ppkPelayanan.'</ppkPelayanan>
					<jnsPelayanan>'.$jnsPelayanan.'</jnsPelayanan>
					<catatan>'.$catatan.'</catatan>
					<diagAwal>'.$diagAwal.'</diagAwal>
					<poliTujuan>MAT</poliTujuan>
					<klsRawat>'.$klsRawat.'</klsRawat>
					<lakaLantas>'.$lakaLantas.'</lakaLantas>
					<user>'.$user.'</user>
					<noMr>'.$noMr.'</noMr>
					 
 */
		//echo("<br>".$data);
		//break;
         //$ch = curl_init('http://api.asterix.co.id/SepWebRest/sep/create/');
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
		// echo $result; 
         $sep = json_decode($result)->response;
         //echo $sep."sad";
		 return("0301R00104160000010");
		
		// foreach ($sep as $key => $value){
				// echo "$key: $value\n";
				// echo "$key: $value->nama\n";
				// echo "$key: $value->nik\n";
			// };
			
			// foreach($sep->data as $mydata){
				// echo $mydata->nama . "\n";
					// foreach($mydata->values as $values){
						// echo $values->value . "\n";
					// }
			// }
      	}
	
	public function cetak_sep($no_register) {
		
		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH.'controllers/irj/SEP.php');

		$sep = new SEP();
		//$this->load->model('r_jalan');
		$entri_rj = $this->rjmregistrasi->get_entri($no_register);
		
		if (!$entri_rj) {
			return;
		}
		
		//$this->load->model('pasien_irj');
		$pasien = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($entri_rj->no_medrec)->row();
		if (!$pasien) {
			return;
		} 
		//$this->load->model('ppk');
		$ppk = $this->rjmregistrasi->get_ppk($entri_rj->asal_rujukan);
		if ($ppk) {
			$ppk = $ppk->nm_ppk;
		}
		else {
			$ppk = $entri_rj->asal_rujukan;
		}
		
		$result = $this->rjmregistrasi->get_diagnosa($entri_rj->diagnosa);
		if($result!=''){
		$diagnosa=$result->id_icd." - ".$result->nm_diagnosa;
		}else $diagnosa='';
		// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
		
		$fields = array(
				'No. Register' => $entri_rj->no_register,
				'No. SEP' => $entri_rj->no_sep,
				'Tgl. SEP' => date('d/m/Y'),
				'No. Kartu' => $pasien->no_kartu,
				'Peserta' => $pasien->pesertaBPJS,
				'Nama Peserta' => $pasien->nama,
				'Tgl. Lahir' => date("d-m-Y", strtotime($pasien->tgl_lahir)),
				'Jenis Kelamin' => $pasien->sex,
				'Asal Faskes' => $ppk,
				'Poli Tujuan' => $entri_rj->nm_poli,
				'Kelas Rawat' => $entri_rj->kelas_pasien,
				'Jenis Rawat' => 'Rawat Jalan',
				'Diagnosa Awal' => $diagnosa,
				//'Catatan' => $entri_rj->CATATAN
				'Catatan' => '',
				'Nama RS' => $namars
			); 
		$sep->set_nilai($fields);
		$sep->cetak();
	}	
	
	public function cetak_kartu_pasien()
	{
		// $this->load->library('PrintZebra');  
		// $hostPrinter = "\\PENDAFTARAN\Zebra P330i Card Printer USB (Copy 1)";
		// $speedPrinter = 4;
		// $darknessPrint = 2;
		// $labelSize = array(300,10);
		// $referencePoint = array(223,15);

		// $z = new ZebraPrinter($hostPrinter, $speedPrinter, $darknessPrint, $labelSize, $referencePoint);
		// $z->setBarcode(1, 344, 80, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,30,4);
		// $z->setBarcode(1, 344, 230, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,180,4);
		// $z->setLabelCopies(1);
		// $z->print2zebra();
		// echo $no_cm;
		$no_cm = $this->input->post('cetak_kartu');
		$no_medrec = $this->input->post('no_medrec');
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm").'", "_blank");window.focus()</script>';
		// echo '<img src="'.base_url().'irj/rjcregistrasi/bikin_barcode/'.$no_cm.'" height="120px">';
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec,'refresh');
		//echo $no_cm;
	}

	//NEW
	///////////////////////////////////////////////////////////////////////////////////////////
	public function st_cetak_kartu_pasien($no_cm)
	{
		error_reporting(~E_ALL);

		if($no_cm!=''){

			$data_pasien=$this->rjmregistrasi->getdata_pasien($no_cm)->result();

			tcpdf();
			$obj_pdf = new TCPDF('P', 'mm', array('54','86'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('3', '3', '3', '1');//left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			$obj_pdf->Rotate(-90, 1, 1);
			$obj_pdf->Translate(0, -52);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');


			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

			IMPORTANT:
			If you are printing user-generated content, tcpdf tag can be unsafe.
			You can disable this tag by setting to false the K_TCPDF_CALLS_IN_HTML
			constant on TCPDF configuration file.

			For security reasons, the parameters for the 'params' attribute of TCPDF
			tag must be prepared as an array and encoded with the
			serializeTCPDFtagParameters() method (see the example below).

			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */




			// $params = $obj_pdf->serializeTCPDFtagParameters(array('www.google.com', 'QRCODE,H', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>1), 'N'));

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128,0,0),
				'bgcolor' => false,
			);

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_cm, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));


			foreach($data_pasien as $row){
				$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));

				if(empty($row->no_nrp)){
					$nrp = '';
				}else{
					// $nrp = 'NRP/NIP : '.$row->no_nrp;
					$nrp = $row->no_nrp;
				}
				if($row->sex=='L'){
					$sex='LAKI-LAKI';
				}else{
					$sex='PEREMPUAN';
				}

				if(strlen($row->nama)>25){
					$nama = substr($row->nama, 0, 23).'..';
				}else{
					$nama = $row->nama;
				}

				//$barcode = $this->set_barcode($no_cm);

				$barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_cm.'">';
				

				$html=
				"
					<br/>
					<br/>
					<br/>
					<br/>
					<style type=\"text/css\">
				.table-font-size{
					margin-top:9px;
				    }
				.nama-pasien{
					font-size:12px;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"400px\">
						<tr>
							<td>$no_cm</td>
						</tr>
						<tr>
							<td class=\"nama-pasien\"><b>$row->nama</b></td>
						</tr>
						<tr>
							<td>$tgl_lahir</td>
						</tr>
						<tr>
							<td>$nrp</td>
						</tr>
					</table>
				";
			}
			// $html = $konten.'<tcpdf method="write2DBarcode" params="'.$params.'" />';


			// output the HTML content
			// $obj_pdf->writeHTML($html, true, 0, true, 0);

			// set style for barcode
			$style = array(
			    'fgcolor' => array(0,0,0),
			    'bgcolor' => false
			);
			// $obj_pdf->write2DBarcode($no_cm, 'QRCODE,H', 3, 22, 15, 15, $style, 'N');
			$obj_pdf->write1DBarcode($no_cm, 'C128B', '', 20, 30, 9, 17, $style, 'T');

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);
			$obj_pdf->writeHTML($html, true, 0, true, 0);


			// Stop Transformation
			$obj_pdf->StopTransform();
			

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}

	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function sep_tracer()
	{
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');
		
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();			
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: 0601R00111160000032</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: 2016-11-30</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: 0000026975981 MR: 0000000014</td>
						<td>Peserta</td>
						<td>: PNS PUSAT</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: NURAINI FITRIYAH</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: 1999-08-17</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: P</td>
						<td>Jenis Rawat</td>
						<td>: Jalan</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: Poli Penyakit Mata</td>
						<td>Kelas Rawat</td>
						<td>: Kelas III</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: dr. HJ. SRI AULIATI</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: Cholera due to Vibrio cholerae 01, biovar eltor</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: test catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke 5</td>
						<td>: 06-12-2016 11:25:40</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
			// $poli="Jalan";
			// if($poli!="Darurat"){
				$data_tracer=$this->rjmregistrasi->getdata_tracer('RJ16000104')->result();			
				foreach($data_tracer as $row){
					if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
					$no_medrec=$row->no_medrec;
					if($row->nmkontraktor!=''){
						if($row->cara_bayar=='BPJS'){
							$txtperusahaan=$row->nmkontraktor;
						}
						else $txtperusahaan=$row->cara_bayar." - ".$row->nmkontraktor;
					}else {$txtperusahaan='UMUM';}
					$konten=$konten."<style type=\"text/css\">
						.table-font-size{
							font-size:13px;
						    }
						</style>	<br><br><hr>				
						$namars | $alamatrs
						
						<h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u></h3><br/>
						<table class=\"table-font-size\">
							<tr>
								<td width=\"20%\"><h4>No. Antrian</h4></td>
								<td width=\"5%\"> : </td>
								<td width=\"30%\"><b>$row->no_antrian</b></td>
								<td>No. MR</td>
								<td width=\"5%\"> : </td>
								<td width=\"20%\"><b>$row->no_cm</b></td>
							</tr>
							<tr>
								<td>Tgl Registrasi</td>
								<td> : </td>
								<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
								<td >Pasien</td>
								<td width=\"5%\"> : </td>
								<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>
							</tr>
							<tr>
								<td>No. Registrasi</td>
								<td> : </td>
								<td><b>$row->no_register</b></td>
							</tr>
							<tr>
								<td>Pasien</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nama</b></td>
							</tr>												
							<tr>
								<td>Unit Tujuan</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nm_poli</b></td>
							</tr>
							
							<tr>
								<td>Tgl Lahir</td>
								<td> : </td>
								<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
							</tr>
							<tr>
								<td>Umur</td>
								<td> : </td>
								<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
							</tr>
							<tr>
								<td>Kelamin</td>
								<td> : </td>
								<td >$sex</td>
							</tr>";

							if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
								$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
								foreach($data_tracer as $row1){
									if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
										$txtpulang='| '.$row1->ket_pulang;
									}else $txtpulang='';

									$konten1="<tr>
										<td>Unit & Kunjungan Lalu</td>
										<td> : </td>
										<td colspan=\"2\">".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
									</tr>";
									}
							}else {$konten1="<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>";}

							$login_data = $this->load->get_var("user_info");
							if($login_data->name=='' || $login_data->name==null){
								$user=$login_data->username;
							}else {$user=$login_data->name;}

							$konten=$konten."$konten1<tr>
								<td>Petugas</td>
								<td> : </td>
								<td colspan=\"2\">".$user."</td>
							</tr>						
							<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
						</table><br>
						<br>
						<style type=\"text/css\">
							.table-diagnosis{
								font-size:9px;
							    }
							</style>
							<table class=\"table-diagnosis\" border=\"1\">
								<tr>
									<td width=\"18%\">Diagnosis</td>
									<td width=\"7%\">ICD10</td>
									<td width=\"4%\">KB</td>
									<td width=\"4%\">KL</td>
									<td width=\"15%\">Tindakan</td>
									<td width=\"10%\">ICD 9 CM</td>
									<td width=\"15%\">INA CBG</td>
									<td width=\"15%\">Nama Dokter</td>
									<td width=\"12%\">Kode Dokter</td>
								</tr>
								<tr>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
								</tr>
							</table>
					";
				}
			// }
						
			
		
		// }
		$file_name="sep.pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADEFR);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}

	public function create_sep($no_kartu='',$no_register='') {
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;
		
        $url = $data_bpjs->service_url;

        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id,
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
  		$ch = curl_init($url . 'Peserta/Peserta/'.$no_kartu);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); 

		curl_close($ch);
    	if($result!='') {
			$datakartu = json_decode($result)->response;
			$cek_peserta = json_decode($result);
			if ($cek_peserta->metaData->code != '200') {
				return $cek_peserta;     		
		 	}	
		} else {
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Service Unavailable'),
	        		'response' => ['peserta' => null]
	      	);
			return $result_error;
		}		

       	$entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
       	$no_medrec =$this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
       	$xuser = $entri_catatan->xuser;
       	$id_poli = $entri_catatan->id_poli;
       	$alasan_berobat = $entri_catatan->alasan_berobat;
       	if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
       		$laka_lantas = '1';
       		$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
       	}
       	else {
       		$laka_lantas = '2';
       		$lokasi_laka = '';
       	}
       	$poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

		if($datakartu->peserta->provUmum->kdProvider==NULL or $datakartu->peserta->provUmum->kdProvider==''){
			$ppkrujuk='0901R004';
		} else
			$ppkrujuk=$datakartu->peserta->provUmum->kdProvider;


		if($entri_catatan->no_rujukan==NULL or $entri_catatan->no_rujukan==''){
			$norujuk='0';
		} else
			$norujuk=$entri_catatan->no_rujukan;

 		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $no_kartu,
		   			'tglSep' =>  $tgl_sep,
		   			'tglRujukan' => $tgl_sep,
		   			'noRujukan' => $norujuk,
		   			'ppkRujukan' => $ppkrujuk,
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'catatan' => $entri_catatan->catatan,
		   			'diagAwal' => $entri_catatan->diagnosa,
		   			'poliTujuan' => $poli_bpjs->poli_bpjs,
		   			'klsRawat' => '3',
		   			'lakaLantas' => $laka_lantas,
		   			'lokasiLaka' => $lokasi_laka,   			
		   			'user' => $xuser,
		   			'noMr' => $no_medrec
		   		)
		   	)
		);		  
    	$datasep=json_encode($data);


        $ch = curl_init($url . 'SEP/insert');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result!='') {
		    $sep = json_decode($result);
			if ($sep->metaData->code == '200') {				
          		$data_update = array(
           			'no_sep' => $sep->response
              	);
           		$this->Mbpjs->update_sep_irj($no_register,$data_update);
			}
			return $sep;
		 } else{
		 	$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Service Unavailable'),
	        		'response' => ['peserta' => null]
	      	);
			return $result_error;
		}

	}
		
		public function create_sep2($no_kartu='',$no_register='')
	{
		$data_bpjs = $this->Mbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
        $url = $data_bpjs->service_url;

        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
  		$ch = curl_init($url . 'Peserta/Peserta/'.$no_kartu);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
    	if($result!='') { //valid koneksi internet
		$datakartu = json_decode($result)->response;
		}
		$cek_peserta = json_decode($result);
	 	if ($cek_peserta->metaData->message == 'KP : Peserta Tidak Ditemukan') {
		$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Peserta Untuk Nomor '.$no_kartu.' Tidak Ditemukan
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		     
		   	//echo '<script type="text/javascript">window.close();</script>';	
		   	redirect('irj/rjcregistrasi/','refresh');//exit(); 		
	 	} // metadata code		

       $entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
       $no_medrec =$this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
       $xuser = $entri_catatan->xuser;
       $id_poli = $entri_catatan->id_poli;
       $alasan_berobat = $entri_catatan->alasan_berobat;
       if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
       	$laka_lantas = '1';
       	$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
       }
       else {
       	$laka_lantas = '2';
       	$lokasi_laka = '';
       }
       $poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

		if($datakartu->peserta->provUmum->kdProvider==NULL or $datakartu->peserta->provUmum->kdProvider==''){
			$ppkrujuk='09020100';
		}else
			$ppkrujuk=$datakartu->peserta->provUmum->kdProvider;


		if($entri_catatan->no_rujukan==NULL or $entri_catatan->no_rujukan==''){
			$norujuk='0';
		}else
			$norujuk=$entri_catatan->no_rujukan;

 		 $data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $no_kartu,
		   			'tglSep' =>  $tgl_sep,
		   			'tglRujukan' => $tgl_sep,
		   			'noRujukan' => $norujuk,//$entri_catatan->NO_RUJUKAN,
		   			'ppkRujukan' => $ppkrujuk,
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'catatan' => $entri_catatan->catatan,
		   			// 'diagAwal' => $datakartu->item->diagnosa->kdDiag,
		   			'diagAwal' => $entri_catatan->diagnosa,
		   			// 'poliTujuan' => $datakartu->poliRujukan->kdPoli, // INT
		   			'poliTujuan' => $poli_bpjs->id_poli, // INT
		   			'klsRawat' => '3',//$datakartu->peserta->provUmum->
		   			'lakaLantas' => $laka_lantas,
		   			'lokasiLaka' => $lokasi_laka,   			
		   			'user' => $xuser,
		   			'noMr' => $no_medrec //'999999999',//$datakartu->item->peserta->noMr
		   			)
		   		)
		   	);		  
    	   $datasep=json_encode($data);
       	   //print_r($datasep);exit();
           $ch = curl_init($url . 'SEP/insert');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
             curl_close($ch);
             if($result!=''){//valid koneksi internet
		     $sep = json_decode($result);
         // print_r($sep->response);exit; ///////////////////////////////////////
		    if ($sep->metaData->code == '800') {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metaData->message.'
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		
			echo $sep->metaData->message;     
			print_r($datasep);
		   	//echo '<script type="text/javascript">window.close();</script>';
		   	//redirect('irj/rjcregistrasi/');exit();
		    }
			else if ($sep->metaData->code == '200') {
				

           // $id= $no_rujukan;
          $data_update = array(
           'NO_SEP' => $sep->response
              );
            $this->M_update_sepbpjs->update_sep_bpjs($no_register,$data_update);
            // print_r($sep->response);
            // exit();
				echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepmanual/cetak_sep/").'/'.$no_register.'", "_blank");window.focus()</script>';

			} else {
				echo $sep->metaData->message;
				exit();
			}
		 } else{
		 	echo "Pastikan Anda Terhubung Internet!!";
		exit();
		 }

		 } 
}
?>
