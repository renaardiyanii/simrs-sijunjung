<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class Emcdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('elektromedik/emmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('elektromedik/emmkwitansi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR PASIEN ELEKTROMEDIK Tanggal '.date('d-m-Y');
		
		$akhir = date('Y-m-d');
		$awal = date('Y-m-d', strtotime(date('Y-m-d') . ' -15 day'));
		$data['elektromedik']=$this->emmdaftar->get_daftar_pasien_em($awal, $akhir)->result();
		$data['kontraktor'] = $this->emmdaftar->get_kontraktor_kerjasama()->result();
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
	
		$this->load->view('elektromedik/emvdaftarpasien',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR PASIEN ELEKTROMEDIK Tanggal '.date('d-m-Y',strtotime($date));

		$data['elektromedik']=$this->emmdaftar->get_daftar_pasien_em_by_date($date)->result();
		$this->load->view('elektromedik/emvdaftarpasien',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR PASIEN ELEKTROMEDIK | '.$key;

		$data['elektromedik']=$this->emmdaftar->get_daftar_pasien_em_by_no($key)->result();
		$this->load->view('elektromedik/emvdaftarpasien',$data);
	}

	public function pemeriksaan_em($no_register='',$pelayan=''){
        $data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan ELEKTROMEDIK';

		$data['no_register']=$no_register;
		if(substr($no_register, 0,2)=="PL"){
			$validasi_em=$this->emmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row()->em;

			if($validasi_em == '1'){
				$data['data_pasien_pemeriksaan']=$this->emmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
				foreach($data['data_pasien_pemeriksaan'] as $row){
					$data['nama']=$row->nama;
					$data['alamat']=$row->alamat;
					$data['dokter_rujuk']=$row->dokter;
					$data['no_medrec']=$row->no_cm;
					$data['no_cm']='-';
					$data['kelas_pasien']='NK';
					$data['tgl_kun']=$row->tgl_kunjungan;
					$data['idrg']='-';
					$data['bed']='-';
					$data['cara_bayar']=$row->cara_bayar;
					$data['nmkontraktor']='';
					$data['tgl_periksa']=$row->tgl_kunjungan;
					$data['cara_bayar']=$row->cara_bayar;
					$data['em']=$row->em;
					$data['rs_perujuk']=$row->rs_perujuk;
					$data['idpoli'] = '';
				}
			}else{
				redirect("elektromedik/emcdaftar");
			}			
		}else{
			$data['data_pasien_pemeriksaan']=$this->emmdaftar->get_data_pasien_pemeriksaan($no_register)->result();

			
			// print_r($data['data_pasien_pemeriksaan']);die;
			//  var_dump($data['data_pasien_pemeriksaan']);
			// die();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']= $row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['tgl_periksa']=$row->jadwal_em;	
				$data['idpoli'] = '';			
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			// var_dump($data['cara_bayar']);
			if(substr($no_register, 0,2)=="RJ"){
				$diag = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->emmdaftar->get_diagnosa_by_no_register_rj($no_register)->result();
				}else{
					$data['nama_diagnosa'] = array();
				}
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA' OR $data['cara_bayar']=='BPJS'){
						$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;
					}else{
					 $data['nmkontraktor']='';
						// $data['bed']='Rawat Jalan';
						//$data['kelas_pasien']='II';

						$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
						$data['em'] = $data['data_pasien_daftar_ulang']->status_em;
						$data['idpoli'] = $data['data_pasien_daftar_ulang']->id_poli;
						// print_r($data['data_pasien_daftar_ulang']);die();
						$diagnosa=$this->emmdaftar->get_data_diagnosa_rj($no_register)->result();
						foreach($diagnosa as $row){
							$data['diagnosa'] = $row->diagnosa;
							$data['id_diagnosa'] = $row->id_diagnosa; 
						}

					}
				}else{
					redirect("elektromedik/emcdaftar");
				}	

			}else if (substr($no_register, 0,2)=="RI"){
				
				$diag = $this->emmdaftar->get_data_pasien_iri($no_register)->row();
				if ($diag != null) {
					$id_icd = $this->emmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$nm_diagnosa=$this->emmdaftar->get_nama_diagnosa($id_icd)->row();
					if ($nm_diagnosa == null) {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';		
					}else{
						$data['nama_diagnosa']= $nm_diagnosa->nm_diagnosa;
					}
				}else{
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				$data['idpoli'] = '';
				if($data['cara_bayar'] != null || $data['cara_bayar'] != ''){
					if($data['cara_bayar']=='KERJASAMA' OR $data['cara_bayar']=='BPJS'){
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor']=$kontraktor;	
					}else $data['nmkontraktor']='';		
					$diagnosa=$this->emmdaftar->get_data_diagnosa_ri($no_register)->result();	
					foreach($diagnosa as $row){
						$data['diagnosa'] = $row->diagnosa;
						$data['id_diagnosa'] = $row->id_diagnosa; 
					}
				}else{
					redirect("elektromedik/emcdaftar");
				}	
			}
		}

		$data['dokter_kirim'] = $this->labmdaftar->get_dokter_kirim($no_register)->row();
		
		$data['data_jenis_em']=$this->emmdaftar->get_jenis_em()->result();
		$data['data_pemeriksaan']=$this->emmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		$data['obat_resep_em']=$this->emmdaftar->get_data_obat_resep_em($no_register)->row();


		$data['dokter']=$this->emmdaftar->getdata_dokter()->result(); 
		$data['tindakan']=$this->emmdaftar->getdata_tindakan_pasien()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->emmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$data['obat_em'] = $this->emmdaftar->get_obat_em()->row();

        $data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
        $data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
        $data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
        $data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();

		$this->load->view('elektromedik/emvpemeriksaan',$data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=$this->emmdaftar->get_biaya_tindakan($id_tindakan,$kelas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data_tindakan=$this->emmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['qty']=$this->input->post('qty');
		$data['id_dokter']=$this->input->post('id_dokter');
		$data_dokter=$this->emmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_em']=$this->input->post('biaya_em_hide');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['no_em']=$this->input->post('no_em');		
		$data['xinput']=$this->input->post('xuser');

		$this->emmdaftar->insert_pemeriksaan($data);
		
		echo json_encode(array("status" => TRUE));
	}

	public function save_pemeriksaan(){
			if( isset( $_POST['myCheckboxes'] ) )
			{
				for ( $i=0; $i < count( $_POST['myCheckboxes'] ); $i++ )
				{
					$data['no_register']=$this->input->post('no_register');
					$data['no_medrec']=$this->input->post('no_medrec');
					$data['id_tindakan']=$this->input->post('myCheckboxes['.$i.']');
					$data['kelas']=$this->input->post('kelas_pasien');
					$data_tindakan=$this->emmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
					foreach($data_tindakan as $row){
						$data['jenis_tindakan']=$row->nmtindakan;
					}
					$data['qty']='1';
					if(substr($data['no_register'],0,2) == 'RI') {
						$titip = $this->emmdaftar->get_data_titip_iri($data['no_register'])->row();
					}

					if(substr($data['no_register'],0,2) == 'RI') {
						if($titip->titip == NULL) {
							if($this->input->post('cara_bayar') == 'KERJASAMA') {
								if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL){
									$data['biaya_em'] = 0;
								} else {
									$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
								}
							} else if($this->input->post('cara_bayar') == 'BPJS') {
								if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL){
									$data['biaya_em'] = 0;
								} else {
									$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
								}
							} else {
								$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
							}
						} else {
							if($this->input->post('cara_bayar') == 'KERJASAMA') {
								if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks == NULL){
									$data['biaya_em'] = 0;
								} else {
									$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks;
								}
							} else if($this->input->post('cara_bayar') == 'BPJS') {
								if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs == NULL){
									$data['biaya_em'] = 0;
								} else {
									$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs;
								}
							} else {
								$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->total_tarif;
							}
						}
					} else {
						if($this->input->post('cara_bayar') == 'KERJASAMA') {
							if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL){
								$data['biaya_em'] = 0;
							} else {
								$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
							}
						} else if($this->input->post('cara_bayar') == 'BPJS') {
							if($this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL){
								$data['biaya_em'] = 0;
							} else {
								$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
							}
						} else {
							$data['biaya_em']=$this->emmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
						}
					}
					$data['vtot']= intval($data['biaya_em']);
					$data['idrg']=$this->input->post('idrg');
					$data['bed']=$this->input->post('bed');
					$data['cara_bayar']=$this->input->post('cara_bayar');
					$data['xinput']=$this->input->post('xuserid');
	
					$no_register = $this->input->post('no_register');
					$cek_pasien_apa = substr($no_register,0,2);
					if($cek_pasien_apa == 'RI'){
						$cek_elektromedik = $this->emmdaftar->cek_elektromedik($no_register)->row();
					}else{
						$cek_elektromedik = $this->emmdaftar->cek_elektromedikrj($no_register)->row();
					}
	
					if($cek_elektromedik == false){
						$datafisik['no_register'] = $no_register;
						$datafisik['pemeriksaan_penunjang_dokter'] = '-'.' '.$data['jenis_tindakan'].' '.'(E)'.' <br>';
						$this->emmdaftar->insert_data_soap($datafisik);
					}else{
						$id = $cek_elektromedik->id;
						$datafisik['pemeriksaan_penunjang_dokter'] = $cek_elektromedik->pemeriksaan_penunjang_dokter.'<br>'.'-'.' '.$data['jenis_tindakan'].' '.'(E)'.'';
						$this->emmdaftar->update_data_soap($id, $datafisik);
					}
	
					$this->emmdaftar->insert_pemeriksaan($data);
				}
				echo json_encode(array("status" => TRUE));
			}
	}

	public function edit_diag(){
        $no_register=$this->input->post('no_register');
        $diagnosa=$this->input->post('id_diagnosa');
		
		if(substr($no_register, 0,2)=="RJ"){
			$data['diagnosa'] = $diagnosa;
			$id = $this->emmdaftar->edit_diag_masuk_rj($no_register, $data);
		}else{
			$data['diagmasuk'] = $diagnosa;
			$id = $this->emmdaftar->edit_diag_masuk_ri($no_ipd, $data);
		}
		    
		// echo json_encode($data);
		echo json_encode(array("status" => TRUE));
		
	}

	public function insert_header_em($pelayan='')
	{
		$no_register=$this->input->post('no_register');
		
			$idrg=$this->input->post('idrg');
			$bed=$this->input->post('bed');
			$kelas=$this->input->post('kelas_pasien');
		
			$cara_bayar=$this->input->post('cara_bayar');
			
			$getvtotem=$this->emmdaftar->get_vtot_em($no_register)->row();
			$vtot = intval($getvtotem->vtot_em);
			$getrdrj=substr($no_register, 0,2);

			// if ($this->emmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
			// 	$this->emmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
			// }
			
			// $no_em=$this->emmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_em;

			if ($getrdrj == 'RJ' ) {
				$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
			}
			else if ($getrdrj=="RD"){
				$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
			}else {
				$get_poli = null;
			}
	
			if ($get_poli != null) {
				$id_poli = $get_poli->id_poli;
			}else{
				$id_poli = null;
			}

			// if($getrdrj=="PL"){
			// 	$this->emmdaftar->selesai_daftar_pemeriksaan_PL_header($no_register,$vtot,$no_em);
			// } else if($getrdrj=="RJ"){			
			// 	$this->emmdaftar->selesai_daftar_pemeriksaan_IRJ_header($no_register,$vtot,$no_em);
			// }
			// else if ($getrdrj=="RD"){
			// 	$this->emmdaftar->selesai_daftar_pemeriksaan_IRD_header($no_register,$vtot,$no_em);
			// }
			// else if ($getrdrj=="RI"){
			// 	// $data_iri=$this->emmdaftar->getdata_iri($no_register)->result();
			// 	// foreach($data_iri as $row){
			// 	// 	$status_em=$row->status_em;
			// 	// }
			// 	// $status_em = $status_em + 1;
			// 	$this->emmdaftar->selesai_daftar_pemeriksaan_IRI_header($no_register,$vtot,$no_em);
			// }

			if ($pelayan == 'DOKTER') {
				if ($id_poli == 'BA00') {
					redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
				}else{
					if($getrdrj=="PL"){					
						redirect("elektromedik/emcdaftar/");
					} 
					else if($getrdrj=="RJ"){					
						redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
					}
					else if ($getrdrj=="RI"){					
						redirect("iri/rictindakan/index/$no_register");
					}else {
						redirect("elektromedik/emcdaftar/");
					}
				}				
			}else{
				if ($id_poli == 'BA00') {
					redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
				}else{
					if($getrdrj=="PL"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					} 
					else if($getrdrj=="RJ"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					}
					else if ($getrdrj=="RI"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					}else {
						redirect("elektromedik/emcdaftar/");
					}
				}				
			}
		
		
	

		//print_r($vtot);
	}

	public function selesai_daftar_pemeriksaan($pelayan='')
	{
		$login_data = $this->load->get_var("user_info");
		$no_register=$this->input->post('no_register');
			$idrg=$this->input->post('idrg');
			$bed=$this->input->post('bed');
			$kelas=$this->input->post('kelas_pasien');
		
			$cara_bayar=$this->input->post('cara_bayar');
			
			$getvtotem=$this->emmdaftar->get_vtot_em($no_register)->row();
			$vtot = intval($getvtotem->vtot_em);
			$getrdrj=substr($no_register, 0,2);
			
			// if ($this->emmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
				$this->emmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
			// }
			
			$no_em=$this->emmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_em;
			if ($getrdrj == 'RJ' ) {
				$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
			}
			else if ($getrdrj=="RD"){
				$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
			}else {
				$get_poli = null;
			}
	
			if ($get_poli != null) {
				$id_poli = $get_poli->id_poli;
			}else{
				$id_poli = null;
			}

			$tglkunjung = date('Y-m-d H:i:s');

			if($getrdrj=="PL"){
				$this->emmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$vtot,$no_em,$tglkunjung,$login_data->userid);
			} else if($getrdrj=="RJ"){		
				$data_iri=$this->emmdaftar->getdata_rj($no_register)->result();
				foreach($data_iri as $row){
					$status_em=$row->status_em;
				}
				$status_em = $status_em + 1;	
				$this->emmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$vtot,$no_em,$status_em,$tglkunjung,$login_data->userid);
			}
			else if ($getrdrj=="RD"){
				$data_iri=$this->emmdaftar->getdata_rj($no_register)->result();
				foreach($data_iri as $row){
					$status_em=$row->status_em;
				}
				$status_em = $status_em + 1;
				$this->emmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$vtot,$no_em,$status_em,$tglkunjung,$login_data->userid);
			}
			else if ($getrdrj=="RI"){
				$data_iri=$this->emmdaftar->getdata_iri($no_register)->result();
				foreach($data_iri as $row){
					$status_em=$row->status_em;
				}
				$status_em = $status_em + 1;
				$this->emmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$vtot,$no_em,$status_em,$tglkunjung,$login_data->userid);
			}

			if ($pelayan == 'DOKTER') {
				if ($id_poli == 'BA00') {
					redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
				}else{
					if($getrdrj=="PL"){					
						redirect("elektromedik/emcdaftar/");
					} 
					else if($getrdrj=="RJ"){					
						redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
					}
					else if ($getrdrj=="RI"){					
						redirect("iri/rictindakan/index/$no_register");
					}else {
						redirect("elektromedik/emcdaftar/");
					}
				}				
			}else{
				if ($id_poli == 'BA00') {
					redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
				}else{
					if($getrdrj=="PL"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					} 
					else if($getrdrj=="RJ"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					}
					else if ($getrdrj=="RI"){						
						redirect("elektromedik/emcdaftar/cetak_faktur/$no_em");
					}else {
						redirect("elektromedik/emcdaftar/");
					}
				}				
			}
		
		
	

		//print_r($vtot);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_em='')
	{
		$id=$this->emmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_em);
        echo json_encode(array("status" => $id_pemeriksaan_em));
	}	

	public function daftar_pasien_luar()
	{
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data['xuser']=$user;
		$data['nama']=$this->input->post('nama');
		$data['usia']=$this->input->post('usia');
		$data['jk']=$this->input->post('jk');
		$data['alamat']=$this->input->post('alamat');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');
		$data['em']='1';
		$data['dokter']=$this->input->post('dokter');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['jenis_PL']='EM';
		$data['cetak_kwitansi']=0;
		if($data['cara_bayar'] == 'BPJS') {
			$data['nmkontraktor'] = $this->input->post('iks_bpjs');
		} else if($data['cara_bayar'] == 'KERJASAMA') {
			$data['nmkontraktor'] = $this->input->post('iks');
		} else {
			$data['nmkontraktor'] = NULL;
		}
		$data['rs_perujuk'] = $this->input->post('perujuk');
		$data['no_hp'] = $this->input->post('no_hp');
		$data['email'] = $this->input->post('email');
		$data['nik'] = $this->input->post('nik');
		
		$this->emmdaftar->insert_pasien_luar($data);
		$notification = '<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
										<h3 class="text-success"><i class="fa fa-check-circle"></i> Daftar Ulang Pasien Berhasil.</h3>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-12"> 
													<hr style="margin-top: 5px;"> 
													<h2>Pasien Berhasil Di Daftarkan</h2>
												</div>   
											</div>
										</div> 
									</div>';	
		$this->session->set_flashdata('success_msg', $notification);
		
		redirect('elektromedik/emcdaftar/','refresh');
		//print_r($data);
	}

	public function cetak_faktur($no_em=''){
		$data['no_register']=$this->emmkwitansi->get_data_pemeriksaan($no_em)->row()->no_register;
		$data['no_em'] = $no_em;
		$jumlah_vtot=$this->labmdaftar->get_vtot_no_lab($no_em)->row()->vtot_no_lab;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if($no_em!=''){
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien']=$this->emmkwitansi->get_data_pasien($no_em)->row();
			$data['data_pemeriksaan']=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
			$cterbilang = new rjcterbilang();
			$tahun_lahir= substr($data['data_pasien']->tgl_lahir,0,4);
			$tahun_now = date('Y');
			$data['tahun']= intval($tahun_now) - intval($tahun_lahir);
			$jumlah_vtot0=0;
			foreach($data['data_pemeriksaan'] as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot0);
			
			$data['vtot_terbilang']=$vtot_terbilang;

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		
			$html = $this->load->view('paper_css/faktur_em',$data,true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();

			// $this->load->view('paper_css/faktur_em',$data);
		}else{
			redirect('elektromedik/emcdaftar/','refresh');
		}

	}

	public function cetak_faktur_backup($no_em='')
	{
		error_reporting(~E_ALL);
		
		$no_register=$this->emmkwitansi->get_data_pemeriksaan($no_em)->row()->no_register;

		
			$jumlah_vtot=$this->emmdaftar->get_vtot_no_em($no_em)->row()->vtot_no_em;
			$conf=$this->appconfig->get_headerpdf_appconfig()->result();
			$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
			$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
			$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
			$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
			$kota_header=$this->appconfig->get_kota_pdfconfig()->value;
			// echo $top_header.$logo_header.$bottom_header;die();
			// print_r($conf);die();
			if($no_em!=''){
				//set timezone
				date_default_timezone_set("Asia/Jakarta");
				$tgl_jam = date("d-m-Y H:i:s");
				$tgl = date("d-m-Y");
	
				foreach($conf as $rowheader){
					$head_pdf =	$rowheader->value;
				}
				$header_pdf=$this->config->item('header_pdf');
				
				
		
				$data_pasien=$this->emmkwitansi->get_data_pasien($no_em)->row();
				$data_pemeriksaan=$this->emmkwitansi->get_data_pemeriksaan($no_em)->result();
	
				$cterbilang=new rjcterbilang();
	
				$tahun= substr($data_pasien->tgl_lahir,0,4);
				$tahun_now = date('Y');
				$bulan=0;
				$hari=0;
				$tahun= intval($tahun_now) - intval($tahun);
				$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
				$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);
				
				$jumlah_vtot0=0;
				foreach($data_pemeriksaan as $row){
					$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
				}
				// echo $header_page;die();
	
				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot0);
				// $header_page = $top_header."<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\">".$bottom_header;
				$header_page = $top_header."<p align=\"center\">
												<img src=\"assets/img/".$logo_kesehatan_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
											</p>
										</td>
										<td  width=\"74%\" style=\"font-size:9px;\" align=\"center\">
											<font style=\"font-size:12px\">
												<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
											</font>
											<font style=\"font-size:11px\">
												<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
												<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
											</font>    
											<br>
											<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
											<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
										</td>
										<td width=\"13%\">
											<p align=\"center\">
												<img src=\"assets/img/".$logo_header."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
											</p>".$bottom_header;
				$konten='<style type="text/css">
						.table-font-size{
							font-size:9px;
							}
						.table-font-size1{
							font-size:12px;
							}
						.table-font-size2{
							font-size:9px;
							margin : 5px 1px 1px 1px;
							padding : 5px 1px 1px 1px;
							}
						</style>
						
						<font size="6" align="right">'.$tgl_jam.'</font><br>
						'.$header_page.'
						<hr/>
						<table border="0">
							<tr>
								<td width="20%"></td>
								<td width="3%"></td>
								<td width="78%"></td>							
							</tr>
							<tr>
								<td align="center" colspan="3"><b>FAKTUR ELEKTROMEDIK No. EM_'.$no_em.'</b></td>
							</tr>
							<tr>
								<td width="20%"><b>No. Registrasi</b></td>
								<td width="3%"> : </td>
								<td width="32%">'.$data_pasien->no_register.'</td>
								<td width="10%"><b>Nama Pasien</b></td>
								<td width="3%"> : </td>
								<td width="32%">'.$data_pasien->nama.'</td>
							</tr>
							<tr>
								<td><b>No. Medrec</b></td>
								<td> : </td>
								<td>'.$data_pasien->no_cm.'</td>
								<td><b>Umur</b></td>
								<td> : </td>
								<td>'.$tahun .' '.' Tahun.</td>
							</tr>
							<tr>
								<td><b>Golongan Pasien</b></td>
								<td> : </td>
								<td>'.$data_pasien->cara_bayar.'</td>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td rowspan="2">'.$data_pasien->alamat.'</td>
							</tr>
							<tr>
								<td><b>Asal Pasien</b></td>
								<td> : </td>
								<td>'.$data_pasien->ruang.'</td>
							</tr>
							<tr>
								<td width="20%"><b>Terbilang</b></td>
								<td width="3%"> : </td>
								<td width="78%"><b><i>'.strtoupper($vtot_terbilang).'</i></b></td>							
							</tr>
						</table>
						<br/><br/>
	
						<table border="1" style="padding:2px">
							<tr>
								<th width="5%"><p align="center"><b>No</b></p></th>
								<th width="55%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
								<th width="15%"><p align="center"><b>Biaya</b></p></th>
								<th width="10%"><p align="center"><b>Banyak</b></p></th>
								<th width="15%"><p align="center"><b>Total</b></p></th>
							</tr>
						';
						$i=1;
						$jumlah_vtot=0;
						foreach($data_pemeriksaan as $row){
							$jumlah_vtot=$jumlah_vtot+$row->vtot;
							$vtot = number_format( $row->vtot, 2 , ',' , '.' );
							$konten=$konten."
							<tr>
								  <td><p align=\"center\">$i</p></td>
								  <td>$row->jenis_tindakan</td>
								  <td><p align=\"right\">".number_format( $row->biaya_em, 2 , ',' , '.' )."</p></td>
								  <td><p align=\"center\">$row->qty</p></td>
								  <td><p align=\"right\">$vtot</P></td>
							</tr>";
							$i++;
	
						}
	
					$konten=$konten."
							<tr>
								<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
								<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
							</tr>";
						
					$login_data = $this->load->get_var("user_info");
					$user = strtoupper($login_data->username);
					$konten=$konten."
						</table>
						<br>
						<br>
						<table style=\"width:100%;\">
							<tr>
								<td width=\"75%\" ></td>
								<td width=\"25%\">
									<p align=\"center\">
									$kota_header, $tgl
									<br>Elektromedik
									<br><br><br>$user
									</p>
								</td>
							</tr>	
						</table>
						";
				
				$file_name="FKTR_EM_".$no_em."_".$data_pasien->nama.".pdf";
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					// $obj_pdf->setJPEGQuality(75);
	
					$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
					$img = file_get_contents('http://rsomh4.iotekno.id/assets/images/logos/logo.png');
					
					// $obj_pdf->Image('http://rsomh4.iotekno.id/assets/images/logos/logo.pngassets/images/logos/logo.png', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
					// $obj_pdf->Image('http://rsomh4.iotekno.id/assets/images/logos/logo.pngassets/images/logos/logo.png', '', '', 40, 40, '', '', '', false, 300, '', false, false, 1, false, false, false);
					// $obj_pdf->Image('@' . $img, 55, 19, '', '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
					// $obj_pdf->Image('@'.$img, 15, 140, 75, 113, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
					
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->setPrintFooter(false);
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins('5', '5', '5');
					$obj_pdf->SetAutoPageBreak(TRUE, '5');
					$obj_pdf->SetFont('helvetica', '', 9);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/'.$file_name, 'FI');
					redirect('elektromedik/emcdaftar/');
			}else{
				redirect('elektromedik/emcdaftar/','refresh');
			}
		

		
	}

	public function update_status_em()
	{	
		$no_register=$this->input->post('no_register');
		

		if ($this->input->post('em')!=null) 
		{	
			$data['em']=0;
			$data['status_em']=0;
			$data['jadwal_em']=date("Y-m-d");
			// $data['jadwal_em']=$this->input->post('jadwal');
		}

		
		$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);
		
		$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
                       	</div>';
		
		
		$this->session->set_flashdata('success_msg', $success);
		
		redirect('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register);
	}

	public function insert_permintaan_resep()
    {
        $no_register = $this->input->post('no_register');

        $data['no_medrec']=$this->input->post('no_medrec');
        $data['tgl_kunjungan']=date('Y-m-d');
        $data['id_inventory']=$this->input->post('id_inventory');
        $data['item_obat']=$this->input->post('id_obat');
        $data['nama_obat']=$this->input->post('nm_obat');
        $data['Satuan_obat']=$this->input->post('satuan');
        $data['qty']=$this->input->post('qty');
            $sgn=$this->input->post('signa');
            $qtx=$this->input->post('qtx');
            $satuan=$this->input->post('satuan');
            $cara_pakai=$this->input->post('cara_pakai');
            $makan = strtoupper($sgn.", ".$qtx." ".$satuan.", ".$cara_pakai);
                if ($makan==''){
                    $data['signa']="-";
                    $data['qtx']=0;
                    $data['Satuan_obat']="-";
                    $data['cara_pakai']="-";
                    $data['kali_harian']="-";
                } else {
                    $data['signa']=$makan;
                    if ($qtx == null) {
                        $qtxs = 0;
                    }else{
                        $qtxs = $qtx;
                    }
                    $data['qtx']=$qtxs;
                    $data['Satuan_obat']=$satuan;
                    $data['cara_pakai']=$cara_pakai;
                    $data['kali_harian']=$sgn;
                }
		$data['xupdate'] = date('Y-m-d H:i:s');
        $data['no_register']=$this->input->post('no_register');
		$kelas=$this->input->post('kelas_pasien');
        $idrg= $this->emmdaftar->get_idpoli($this->input->post('idrg'))->row()->id_poli;
        $bed=$this->input->post('idrg'); 
        $data['kelas']=$kelas;
        $data['idrg']=$idrg;  
        $data['bed']=$bed;
				
			

        $data['cara_bayar'] = $this->input->post('cara_bayar');      

        $data['no_resep']=$this->input->post('no_resep');
        $stok_obat=$this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();

        if (empty($stok_obat)) {
            $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');
            if($this->input->post('idpoli') != ''){
				if ($this->input->post('pelayan') == 'DOKTER') {
					redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register.'/DOKTER');
				}else{
					redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register);
				}                
            }else{
                if ($this->input->post('pelayan') == 'DOKTER') {
					redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register.'/DOKTER');
				}else{
					redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register);
				}                
            }
        }
        //update stok
        $this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);
        
        $data['biaya_obat']=$this->input->post('hargajual');
        $data['fmarkup']=$this->input->post('fmarkup');
        $data['ppn']=$this->input->post('margin');
        if($this->input->post('cara_bayar') == 'UMUM'){
            $total_akhir = (int)$data['biaya_obat'] * (int)$data['qty'];
        }else{
            $total_akhir = (int)$data['biaya_obat'] * (int)$data['qty'];
        }
        $data['vtot']=$total_akhir;

        $data['xinput']=$this->input->post('xuser');
        $data['satelit'] = $this->input->post('satelit');

        $data['kronis'] = $this->input->post('kronis');
        $kronis = $this->input->post('kronis');
        $poli = $this->input->post('idpoli');
        $ket = $this->input->post('ket');
        if($ket!=1){
            $klaim = $this->Frmmdaftar->cek_kronis_klaim($data['item_obat'], $poli, $kronis);
            $row_klaim = $klaim->row();
            $cek_klaim = $klaim->num_rows();
        }

		// if ($this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->num_rows() == 0) {
			$this->Frmmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		// }
		
		$data['no_resep']=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;

	

        /* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */
        if($data['cara_bayar'] == 'BPJS'){

            /* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
            */
            if($cek_klaim > 0) {
                if($data['qty'] > $row_klaim->qty){
                    $this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: '.$row_klaim->qty.' pcs)</div>');
                }else{
                    $this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> '.$row_klaim->keterangan.'</div>');
                    $this->Frmmdaftar->insert_permintaan($data);
                    
                }
            }else{
                $this->Frmmdaftar->insert_permintaan($data);

                $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
        
            }
        }else{
            $this->Frmmdaftar->insert_permintaan($data);     
        }

        if ($this->input->post('koreksi') != '') {
            if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register'].'/DOKTER');
			}else{
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register']);
			}                 
        }
        if($this->input->post('idpoli') != ''){
            if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register'].'/DOKTER');
			}else{
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register']);
			}                
        }else{
            if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register'].'/DOKTER');
			}else{
				redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$data['no_register']);
			}                
        }
        //echo print_r($data);
    }

	public function hapus_permintaan_resep()
    {
        $no_register = $this->input->post('no_register');

        $id_resep_pasien = $this->input->post('id_resep_pasien');

        $no_medrec=$this->input->post('no_medrec');    
		
		$obat=$this->Frmmdaftar->get_resep_pasien($id_resep_pasien)->row();
        $this->Frmmdaftar->update_stok_obat_hapus($obat->id_inventory, $obat->qty);
        $this->emmdaftar->hapus_resep_em($no_register,$id_resep_pasien);     
        
        if ($this->input->post('pelayan') == 'DOKTER') {
			redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register.'/DOKTER');
		}else{
			redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register);
		}                

        //echo print_r($data);
    }

	public function autocomplete_search()
	{
		$keyword = $_GET['term'];
		$data = $this->db->select('idpok2, idtindakan,nmtindakan')
				->from('jenis_tindakan_em')
				->like('UPPER(nmtindakan)',strtoupper($keyword))
				->or_like('UPPER(idtindakan)',strtoupper($keyword))->limit(20, 0)->get();
		$arr='';
		if($data->num_rows() > 0){
			foreach ($data->result_array() as $row){
				$new_row['label']=$row['idtindakan'].' - '.$row['nmtindakan'];
				$new_row['value']=$row['idtindakan'].' - '.$row['nmtindakan'];
				$new_row['idtindakan'] = $row['idtindakan'];
				$new_row['idpok2'] = $row['idpok2'];
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {        
			echo json_encode([]);
		}
	}

	public function add_tanggal_tindak()
	{		
		$tgl = $this->input->post('tgl_tindak').' '.$this->input->post('waktu_tindak');
		$no_register = $this->input->post('no_register');

        $cek = $this->emmdaftar->update_tanggal_tindakan($no_register,$tgl);
		if($cek == false){
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> No Register Tidak Ditemukan</div>');
		}else{
			$this->session->set_flashdata('warning', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-success"><i class="fa fa-success"></i>Berhasil</h3></div>');
		}
		redirect('elektromedik/Emcdaftar/pemeriksaan_em/'.$no_register);
	}

	public function update_rujukan_penunjang()
	{	
		$no_register=$this->input->post('no_register');
		if($no_register == null){
			echo json_encode(array('status' => false));	
		}else{
			if(substr($no_register,0,2) == 'RJ'){
				$data['em'] = 1;
				$data['jadwal_em'] = date("Y-m-d H:i:s");
				
				$id=$this->emmdaftar->update_rujukan_penunjang_irj($data,$no_register);
			}else{
				$data['em'] = 1;
				$data['jadwal_em'] = date("Y-m-d H:i:s");
				$id=$this->emmdaftar->update_rujukan_penunjang_iri($data,$no_register);
			}
			
			// $data['status_em']=0;		
		
			if($id == true){
				echo json_encode(array('status' => true));	
			}else{
				echo json_encode(array('status' => false));					
			}	

		}
		
	}

	public function cetak_order($noreg='') {
		$data['no_em'] = $noreg;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if($noreg!=''){
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['data_pasien']=$this->emmdaftar->get_data_pasien_by_noreg($noreg)->row();
			$data['data_pemeriksaan']=$this->emmdaftar->get_data_pemeriksaan_by_noreg($noreg)->result();
			$login_data = $this->load->get_var("user_info");
			$name  = $this->emmdaftar->get_ttd_by_userid($login_data->userid)->row();
			$data['user'] = strtoupper($name->name);
			$tahun_lahir= substr($data['data_pasien']->tgl_lahir,0,4);
			$tahun_now = date('Y');
			$data['tahun']= intval($tahun_now) - intval($tahun_lahir);

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		

			$html = $this->load->view('paper_css/order_em',$data,true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_em',$data);
		}else{
			redirect('elektromedik/emcdaftar/','refresh');
		}
	}

	public function batal_kunjungan($no_register,$pelayan='',$id_poli='')
	{		
        $cek = $this->emmdaftar->batal_kunjungan($no_register);
		if($cek == false){
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> No Register Tidak Ditemukan</div>');
		}else{
			$this->session->set_flashdata('warning', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-success"><i class="fa fa-success"></i>Berhasil</h3></div>');
		}
		$this->emmdaftar->delete_order_batal($no_register);
		if($pelayan == ''){
			redirect('elektromedik/Emcdaftar');
		}else{
			if(substr($no_register,0,2) == 'RJ'){
				if($id_poli == 'BA00'){
					redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
				}else{
					redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
				}
			}else {
				redirect('iri/rictindakan/index/'.$no_register);
			}
		}
	}

}