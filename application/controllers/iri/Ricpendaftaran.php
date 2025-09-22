<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');
require_once(APPPATH.'controllers/Secure_area.php');
class Ricpendaftaran extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimkelas');
		$this->load->model('irj/rjmtracer','',TRUE);
		$this->load->model('iri/rimreservasi');
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmregistrasi');
		$this->load->model('bpjs/Mbpjs','',TRUE);	
		$this->load->helper('pdf_helper');
	}
	
	public function index($noreservasi=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		// $value=array(
		// 	'noreservasi'=>$noreservasi
		// );
		// $this->session->set_userdata($value);
		// $irna_antrian=$this->rimpendaftaran->select_irna_antrian_by_noreservasi($this->session->userdata('noreservasi'));

		$irna_antrian=$this->rimpendaftaran->select_irna_antrian_by_noreservasi($noreservasi);
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();

		$tppri=$irna_antrian[0]['tppri'];
		$data['nosurat_skdp'] = '';
		if($tppri=='rawatjalan'){
			$pasien=$this->rimpendaftaran->select_pasien_irj_by_no_register_asal($irna_antrian[0]['no_register_asal']);
			$data['nosurat_skdp'] = $pasien[0]['nosurat_skdp'];
		} else if($tppri=='ruangrawat'){
			$pasien=$this->rimpendaftaran->select_pasien_iri_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		} else{
			$pasien=$this->rimpendaftaran->select_pasien_ird_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		}

		$data['kls_bpjs']='';
		$pasiendetail = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($irna_antrian[0]['no_medrec'])->result();

		foreach($pasiendetail as $row){
			$no_medrec=$row->no_medrec;
			$data['kls_bpjs']=$row->kelas_bpjs;
		}
		//print_r($data['kls_bpjs']);
		$data['irna_reservasi']=$irna_antrian;
		
		$data['kelas'] = $this->rimkelas->get_all_kelas_with_empty_bed();
	
	    $data['status_bed'] = $this->rimkelas->get_status_bed($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);

		$data['all_kelas'] = $this->rimkelas->get_kelas();

		$data['empty_bed'] = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);


		$data['data_pasien']=$pasien;

		//get data ppk
		$data['ppk']=$this->rimpendaftaran->get_all_ppk();

		//cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();

		//get cara kunjungan
		$data['smf']=$this->rimpendaftaran->get_all_smf();
		//print_r($data['smf']);exit;

		//kontraktor
		$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result_array();

		$data['kontraktor']=$this->rjmregistrasi->get_kontraktor_bpjs('KERJASAMA')->result_array();
		
		//$this->load->view('iri/rivlink');
		// $this->load->view('iri/rivheader');
		// $this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivpendaftaran', $data_reservasi);
		$this->load->view('iri/form_pendaftaran', $data);
		//$this->load->view('iri/rivfooter');
	}
	public function data_ruang() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_ruang_like($keyword);
		foreach($data as $row){
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['idrg'].' - '.$row['nmruang'].' - '.$row['koderg'],
				'idrg'				=>$row['idrg'],
				'nmruang'			=>$row['nmruang'],
				'kelas'				=>$row['koderg']
			);
		}
		echo json_encode($arr);
    }
	public function insert_pendaftaran() {		
		$no_kartu = $this->input->post('no_bpjs');
	 	if ($this->input->post('diagnosa_id') == '-' OR $this->input->post('diagnosa_id') == ' ') {
		$notif = 	'<div class="alert alert-danger">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-exclamation-circle"></i> Pendaftaran Gagal.</h3> Diagnosa tidak boleh kosong.
                       		</div>';
			$this->session->set_flashdata('notification', $notif);	
			redirect('iri/ricpendaftaran/index/'.$this->input->post('noipdlama'));	     		
	 	} // metadata code	

		$data_pendaftaran['no_cm']=$this->input->post('no_cm_hidden');
		$data_pendaftaran['noipdlama']=$this->input->post('noipdlama');
		$count=$this->rimpendaftaran->get_pasien_iri_exist($data_pendaftaran['no_cm'])->row()->exist;		
		if((int)$count==0){
			$data_pendaftaran['noregasal']=$this->input->post('noregasal');
			// $data_pendaftaran['no_cm']=$this->input->post('no_cm');
			
			$data_pendaftaran['tgldaftarri']=$this->input->post('tgldaftarri');
			$data_pendaftaran['carabayar']=$this->input->post('carabayar');
			$data_pendaftaran['id_smf']=$this->input->post('id_smf');
			$data_pendaftaran['id_dokter']=$this->input->post('id_dokter');
			$data_pendaftaran['dokter']=$this->input->post('nmdokter');
			
			$data_pendaftaran['nama']=$this->input->post('nama');
			$data_pendaftaran['tgl_masuk']=date('Y-m-d');

			//ambil_data irna antrian
			$irna_antrian = $this->rimreservasi->select_irna_antrian_by_noreservasi($data_pendaftaran['noipdlama']);
			$data_pendaftaran['diagmasuk'] = $this->input->post('diagnosa_id');//isi sama diagnosa di irna antrian

			//data lainlain
			$data_pendaftaran['jatahklsiri']=$this->input->post('jatahkls');
			$data_pendaftaran['no_rujukan'] = $this->input->post('no_rujukan');
			$data_pendaftaran['tgl_rujukan'] = $this->input->post('tgl_rujukan');
			$data_pendaftaran['nopembayarri']=$this->input->post('nopembayarri');
			$id_kontraktor = $this->input->post('nmkontraktorbpjs');
			if($this->input->post('carabayar')=='BPJS'){
				$id_kontraktor = $this->input->post('nmkontraktorbpjs');
			}		
			$data_pendaftaran['id_kontraktor']=$id_kontraktor;
			$data_pendaftaran['ketpembayarri']=$this->input->post('ketpembayarri');
			$data_pendaftaran['nmpembayatri']=$this->input->post('nmpembayarri');
			$data_pendaftaran['golpembayarri']=$this->input->post('golpembayarri');
			$data_pendaftaran['nmpjawabri']=$this->input->post('nmpjawabri');
			$data_pendaftaran['alamatpjawabri']=$this->input->post('alamatpjawabri');
			$data_pendaftaran['notlppjawab']=$this->input->post('notlppjawab');
			$data_pendaftaran['kartuidpjawab']=$this->input->post('kartuidpjawab');
			$data_pendaftaran['noidpjawab']=$this->input->post('noidpjawab');
			$data_pendaftaran['hubpjawabri']=$this->input->post('hubjawabri');
			$data_pendaftaran['catatan']=$this->input->post('catatan');
			$data_pendaftaran['catatan_ringkasan']=$this->input->post('catatan_ring');
			$get_data_bpjs = $this->Mbpjs->get_data_bpjs();
			if ($this->input->post('asal_rujukan') && $this->input->post('ppk_asal_rujukan')) {
				$data_pendaftaran['asal_rujukan']=$this->input->post('asal_rujukan');
				$data_pendaftaran['ppk_asal_rujukan']=$this->input->post('ppk_asal_rujukan');
			} else {
				$data_pendaftaran['asal_rujukan'] = 2;
				$data_pendaftaran['ppk_asal_rujukan'] = $get_data_bpjs->rsid.' - RSAL DR MINTOHARJO';
			}
			if ($this->input->post('katarak') == 1) {
				$data_pendaftaran['katarak'] = 1;
			} else $data_pendaftaran['katarak'] = 0;
			$data_pendaftaran['nosurat_skdp_sep']=$this->input->post('nosurat_skdp_sep');
			$data_pendaftaran['dpjp_skdp_sep']=$this->input->post('dpjp_skdp_sep');

			//
			// $data_pendaftaran['idrg']=$this->input->post('ruang');
			// $data_ruang_iri['kelas']=$this->input->post('kelas');
			$temp_ruang=$this->input->post('ruang');
			$temp_ruang =explode("-", $temp_ruang);
			$data_pendaftaran['idrg']=$temp_ruang[0]; // Kode ruang pilih
			$data_pendaftaran['klsiri']=$temp_ruang[2]; // Kode ruang pilih
			$data_ruang_iri['kelas']=$temp_ruang[2]; // Kelas

			$data_ruang_iri['idrg']=$temp_ruang[0];
			$data_ruang_iri['bed']=$this->input->post('bed');
			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser']=$login_data->username;

			//ngambil dari jatah kelas
			$data_ruang_iri['harga_jatah_kelas']= 0;
			// $biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'],$data_pendaftaran['idrg']);
			// if(!($biaya_ruang) || $data_pendaftaran['carabayar'] != 'DIJAMIN / JAMSOSKES'){
			// 	$data_ruang_iri['harga_jatah_kelas']= 0;
			// }else{
			// 	$data_ruang_iri['harga_jatah_kelas']=$biaya_ruang[0]['total_tarif'];
			// }
			
			$data_pendaftaran['bed']=$data_ruang_iri['bed']; // Kode ruang pilih
			$data_ruang_iri['tglmasukrg']=$this->input->post('tglmasukrg');

			//get biaya ruang
			$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_ruang_iri['kelas'],$data_pendaftaran['idrg'])->row()->total_tarif;
			$data_ruang_iri['vtot']=$biaya_ruang;
			$data_pendaftaran['vtot_ruang']=$biaya_ruang;
			
			$data_pendaftaran['ipdibu']=$this->input->post('noipdibu');
			if($data_pendaftaran['ipdibu'] != ""){
				$data_ibu = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['ipdibu']);

				//overide data yang awal diganti pake data yang dari ibu untuk ruangannya aja. kalo ada ipd ibu
				$data_pendaftaran['idrg']=$data_ibu[0]['idrg']; // Kode ruang pilih
				$data_pendaftaran['klsiri']=$data_ibu[0]['kelas']; // Kode ruang pilih
				$data_ruang_iri['kelas']=$data_ibu[0]['kelas']; // Kelas
				$data_ruang_iri['idrg']=$data_ibu[0]['idrg'];
				$data_ruang_iri['bed']=$data_ibu[0]['bed'];
				$data_pendaftaran['bed']=$data_ibu[0]['bed']; // Kode ruang pilih
				$data_ruang_iri['vtot']=0;
			}

			// MENU
			$data['reservasi']='';
			$data['daftar']='active';
			$data['pasien']='';
			$data['mutasi']='';
			$data['status']='';
			$data['resume']='';
			$data['kontrol']='';

			//cek kalo bed masih kosong, kalo udah diisi ga bisa
			$bed=$this->input->post('bed');
			$bed = $this->rimkelas->get_bed_by_bed($bed);
			if($bed[0]['isi'] == 'Y' && $data_pendaftaran['ipdibu'] == ""){
				$this->session->set_flashdata('pesan',
				"<div class='alert alert-error alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
				</div>");
				header('Location: '.base_url().'iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']);
				exit;
			}

			//select bed yang kosong
			//update bed menjadi Y

			//set no_ipd
			//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
			$no=count($this->rimpendaftaran->select_pasien_iri())+1;
			$data_pendaftaran['no_ipd']='RI'.sprintf("%08d", $no);
			$temp_data_ipd = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
			while (($temp_data_ipd)) {
				$no = $no + 1;
				$data_pendaftaran['no_ipd']='RI'.sprintf("%08d", $no);
				$temp_data_ipd =  $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
			}

			$login_data = $this->load->get_var("user_info");
			$data_pendaftaran['verifuser']=$login_data->username;
			$status_pasien = $this->rimpendaftaran->insert_pendaftaran($data_pendaftaran); 
			$data_ruang_iri['no_ipd']=$data_pendaftaran['no_ipd'];
			$data_ruang_iri['statmasukrg']="masuk";
			$data_ruang_iri['xuser'] = $login_data->username;
			// echo json_encode($data_ruang_iri);

			// if($data_pendaftaran['carabayar'] == "BPJS"){
			// 	$response_sep = $this->create_sep($no_kartu,$data_pendaftaran['no_ipd'],$data_pendaftaran['noipdlama'],$this->input->post('no_cm'));
			// 	// $response_sep = $this->create_sep($data_pendaftaran['no_ipd']);				
			// 		if ($response_sep->metadata->code == '200') {
			// 			$message = '<div class="alert alert-info">
		   //                      		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		   //                          	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan. Silahkan klik <a href="'.base_url().'bpjs/sep/iri/'.$data_pendaftaran['no_ipd'].'"" target="_blank">disini</a> untuk mencetak SEP dengan nomor '.$response_sep->response.'
		   //                     		</div>';
					// 		} else {
					// 			$message = '<div class="alert alert-info">
		   //                      		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		   //                          	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> <span class="text-danger">Gagal membuat SEP, '.$response_sep->metadata->message.'</span>
		   //                     		</div>';
					// 		}
							
					// } else {
					// 	$message = '<div class="alert alert-info">
		   //                      		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		   //                          	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
		   //                     		</div>';
					// }
			if($data_pendaftaran['carabayar'] == "BPJS") {
				$message = '<div class="alert alert-info">
	                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
	                            	<p>
										<button type="button" class="btn btn-social btn-bitbucket create_sep" data-noregister="'.$data_pendaftaran['no_ipd'].'" style="margin-top: 10px;">
							                <i class="fa fa-edit" style="font-size: 1.3em;"></i> Buat SEP
							            </button>
								    </p>
	                       		</div>';	
			} else {
				$message = '<div class="alert alert-info">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
                       		</div>';
			}

            $data0['no_medrec']=$data_pendaftaran['no_cm'];
            $data0['no_register']=$data_pendaftaran['no_ipd'];
			$data0['id_poli']=$data_ruang_iri['idrg'];
			$data0['timeout']=date('Y-m-d H:i:s');
			$data0['status']=1;
			$data0['tiperawat']='IRI';

			/*$id1=$this->rjmtracer->insert_mappasien($data0);*/

			$this->session->set_flashdata('pesan',$message);
			$data_update['statusantrian']='Y';
			$data_update['user_approve'] = $login_data->username;

			$data_bed['isi'] = 'Y';
			$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
			$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
			$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);

            /** Update RI Otomatis Rujukan ke Farmasi
             * 23 April 2018 22:40 */
            // $obat['obat'] = 1;
            // $obat['status_obat'] = 0;
            // $this->rimtindakan->update_rujukan_penunjang($obat, $data0['no_register']);
			
			// $this->validation_pendaftaran(); // Form validasi
			// if($this->form_validation->run()==FALSE){
			// 	$this->session->set_flashdata('pesan',
			// 	"<div class='alert alert-danger alert-dismissable'>
			// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			// 		<i class='icon fa fa-check'></i> Data gagal tersimpan!
			// 	</div>");
			// 	redirect('iri/ricpendaftaran');
			// }else{
			// 	$this->session->set_flashdata('pesan',
			// 	"<div class='alert alert-success alert-dismissable'>
			// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			// 		<i class='icon fa fa-check'></i> Data telah tersimpan!
			// 	</div>");
			// 	$data_update['statusantrian']='Y';
			// 	$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);
			// 	$this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
			// 	$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
			// 	redirect('iri/ricdaftar');
			// }
			$noresev=$data_pendaftaran['no_ipd'];
			// echo '<script type="text/javascript">window.open("'.site_url("iri/ricpendaftaran/cetak_rawatinap/$noresev").'", "_blank");window.focus()</script>';
			
			// redirect('iri/ricdaftar','refresh');

			echo json_encode(array("status" => TRUE, "ket" => "1", "nex" => 'iri/ricpendaftaran/cetak_rawatinap/'.$noresev));

		} else {
			// $this->session->set_flashdata('pesan',
			// 	'<div class="alert alert-danger">
		    //                      		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		    //                          	<h3><i class="fa fa-ban"></i> Pendaftaran Pasien Gagal.</h3> Pasien sudah dirawat diruangan.
		    //                     		</div>');				
			// redirect('iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']);

			echo json_encode(array("status" => TRUE, "ket" => "2", "nex" => 'iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']));
		}
		
	}


	public function cetak_rawatinap($no_ipd=''){
		if($no_ipd!=''){
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$telprs=$this->config->item('telp');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
			$data_identitas=$this->rimpendaftaran->select_irna_antrian_by_noreservasi2($no_ipd)->result();						
			foreach($data_identitas as $row){
			$interval = date_diff(date_create(), date_create($row->tgl_lahir));	
			$hari = (date("d",strtotime($row->tgldaftarri)));	
			$bulan = (date("F",strtotime($row->tgldaftarri)));	
			$tahun = (date("Y",strtotime($row->tgldaftarri)));	
			$jam = (date("H:i:s",strtotime($row->tgldaftarri)));	
							
			$konten_header=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					</style>
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"15%\" style=\"border-bottom:1px solid black; font-size:13px; \"><p><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\"></p></td>
						<td width=\"65%\" style=\"border-bottom:1px solid black; font-size:14px;\">
						<br/><b>$namars</b> <br/><span style=\"font-size:10px;\">$alamatrs</span><br/><span style=\"font-size:10px;\">$telprs</span></td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:12px;align:right\">
						<div style=\" text-align:center;font-size:13px; border:1px solid black;\">RM 02</div>
						
						</td>
						</tr>												
					</table>					
					";
				$konten=
							"<style type=\"text/css\">
							.table-font-size2{
								font-size:10px;
							    }
							</style>
							<p align=\"center\" style=\"font-size:13px\"><u><b>RINGKASAN MASUK & KELUAR PASIEN </b></u></p>

							<table class=\"table-font-size2 \" cellpadding=\"2\" cellspacing=\"1\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">	
								
								<tr>
									<td width=\"18%\"><b>No. RM </b></td>
									<td width=\"2%\">:</td>
									<td width=\"30%\"><b>".strtoupper($row->no_cm)."</b></td>
									<td width=\"17%\"><b>KELAS</b></td>
									<td width=\"2%\">:</td>
									<td width=\"31%\"> <b>".strtoupper($row->klsiri)."</b></td>
								</tr>
								<tr> 
									<td width=\"18%\"><b>RUANGAN </b></td>
									<td width=\"2%\">:</td>
									<td width=\"30%\"><b>".strtoupper($row->nmruang)." </b></td>
									<td width=\"17%\"><b>Tanggal masuk</b></td>
									<td width=\"2%\"><b>:</b></td>
									<td width=\"31%\"><b>".$hari. " ".$bulan. " ".$tahun. ", Jam ".$jam."</b></td>
								</tr>
								<tr>
									<td width=\"18%\">Asal Poli</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".$row->nm_poli."</td>
									<td width=\"17%\">Dikirim Oleh</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->dikirim_oleh=='rs_lainnya'? 'Rumah Sakit ':
										($row->dikirim_oleh=='bp_satkes'? 'BP / SATKES':
										($row->dikirim_oleh=='dokter'? 'Dokter':
										($row->dikirim_oleh=='puskesmas'? 'Puskesmas': 
										($row->dikirim_oleh=='instansi_lainnya'? 'Instansi':
										($row->dikirim_oleh=='kasus'? 'Kasus Polisi':
										($row->dikirim_oleh=='sendiri'? 'Datang Sendiri'
											:' ')))))))."					
										".$row->dikirim_oleh_teks."</td>
								</tr>
								<tr>
									<td width=\"18%\">Dokter </td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".$row->nm_dokter."</td>
									<td width=\"17%\"><b>Diagnosa Awal</b></td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->nm_diagnosa)."</td>
								
								</tr>

								<tr>
									<td width=\"18%\">Nama Pasien</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".$row->nama."</td>
									<td width=\"17%\">Pendidikan</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($row->pendidikan))."</td>
								</tr>
								<tr>
									<td width=\"18%\">Tempat,Tgl Lahir</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".$row->tmpt_lahir.", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
									<td width=\"17%\">Jenis Kelamin</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->sex=='L'? 'Laki-laki':($row->sex=='P'? 'Perempuan':'Laki-laki / Perempuan'))."</td>
								</tr>
								<tr>
									<td width=\"18%\">Usia</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
									<td width=\"17%\">Status Pasien</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".(($row->carabayar=='UMUM' )? 'UMUM':($row->carabayar.' - '.$row->nmkontraktor))."</td>
								</tr>
								<tr>
									<td width=\"18%\">Pekerjaan</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : '.................') :$row->pekerjaan)."</td>
									<td width=\"17%\">Jabatan</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->jabatan=='' ? '.............' :$row->jabatan)."</td>
								</tr>
								<tr>
									<td width=\"18%\">Nomor Telepon</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".($row->no_hp)."</td>
									".($row->nrp_sbg == 'T' ? '
									<td width=\"17%\">NIP/NRP</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\"><b>'.($row->no_nrp).'</b></td>
								':'')."
								</tr>
								<tr>
									<td width=\"18%\">Agama</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".($row->agama=='' ? 'ISLAM / PROTESTAN / KATHOLIK / HINDU / BUDHA / KONGHUCU' :$row->agama)."</td>
									".($row->nrp_sbg == 'T' ? '
									<td width=\"24%\">Kesatuan</td>
									<td width=\"2%\">:</td>
									<td width=\"68%\">'.($row->kst_id=='' ? ($row->kesatuan_ehr) : ($row->kst_nama.' | '.$row->kst2_nama.' | '.$row->kst3_nama)).'</td>
								':'')."
								</tr>
								<tr>
									<td width=\"18%\">Status Pernikahan</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".($row->status_nikah=='K'? 'Menikah' :($row->status_nikah!='K'? 'Belum Menikah':'Menikah / Belum Menikah'))."</td>
									".($row->nrp_sbg == 'T' ? '
									<td width=\"24%\">Pangkat</td>
									<td width=\"2%\">:</td>
									<td width=\"68%\">'.($row->pangkat).'</td>
								':'')."
								</tr>
								<tr>
									<td width=\"18%\">Alamat Rumah</td>
									<td width=\"2%\">:</td>
									<td width=\"30%\">".($row->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')."</td>
									<td width=\"17%\">Catatan</td>
									<td width=\"2%\">:</td>
									<td width=\"31%\">".($row->catt)."</td>
								</tr>

							</table>

							<style type=\"text/css\">
							.table-font-size2{
								font-size:10px;
							    }
							.table3 td{
							 	height:17px;
							 }
							</style>
							
							<table class=\"table-font-size2 table3\" border=\"0.5 \" >	
								<tr> 
									<td width=\"40%\"><b>Diagnosa Akhir <br></b></td>
									<td width=\"30%\"><b>Tanggal Keluar</b></td>
									<td width=\"30%\"><b>Jam Keluar</b></td>
								</tr>
								<tr>
									<td width=\"50%\"><b>Utama :</b></td>
									<td width=\"50%\"><b>Komplikasi :</b></td>
									
									
								</tr>
								<tr> 
									<td width=\"100%\">Lama Dirawat : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; hari</td>
								
									
								</tr>
								<tr>
									<td width=\"100%\">Penyebab Luar Cedera & keracunan / morfologi Neoplaspa : </td>
									
								</tr>
								<tr>
									<td width=\"50%\">Infeksi Nosokomial :</td>
									<td width=\"50%\">Penyebab Infeksi :</td>
								</tr>
								<tr>
									<td width=\"50%\">Nama Opsi / Tindakan : </td>
									<td width=\"50%\">Golongan Operasi :</td>
								</tr>
								<tr>
									<td width=\"50%\">Jenis Anestesi : </td>
									<td width=\"50%\">Tanggal dan No. Kode : </td>
								</tr>
								<tr>
									<td width=\"18%\">Imunisasi yang Pernah di Dapat : </td>
									<td width=\"14%\"> 1. BCG <br> 2. DPT <br> 3. Polio <br> 4. TFT</td>
									<td width=\"18%\"> 5. DT <br> 6. Campak <br> 7. Hepatitis</td>
									<td width=\"50%\">Pengobatan Radioterapi/KUBT :</td>
								</tr>
								<tr>
									<td width=\"50%\">Imunisasi yang diperoleh selama dirawat: <br> </td>
									<td width=\"50%\">Transfusi Darah : <br>Golongan Darah :</td>
								</tr>
								<tr>
									<td width=\"25%\">Keadaan Keluar : <br> 1. Sembuh <br> 2. Membaik <br> 3. Belum Sembuh </td>
									<td width=\"25%\"> &nbsp; 	<br> 4. Wafat kurang 48 jam <br> 5. Wafat lebih 48 jam </td>
									<td width=\"25%\">Cara Keluar : <br> 1.Diijinkan pulang <br> 2. Pulang Paksa <br> 3. Dirujuk Ke ........... </td>
									<td width=\"25%\">&nbsp; 	<br> 4. Lari <br> 5.Pindah RS Lain</td>
								</tr>
								<tr>
									<td width=\"50%\">Dokter yang merawat : <br><br><br></td>
									<td width=\"50%\">Tanda Tangan : <br><br><br></td>
								</tr>
								
							</table>
					";
				
			}
		
			$file_name="Ringkasan_rawatinap_$no_ipd.pdf";
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
					$obj_pdf->Output(FCPATH.'/download/iri/riidentitas/'.$file_name, 'FI');				
				
		}else{
			redirect('iri/ricpendaftaran','refresh');
		}
	}



	public function validation_pendaftaran(){
		$this->form_validation->set_rules('noregasal', 'No. Reg. Asal', 'required');
	}

	public function data_dokter_autocomp() {
		

		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_dokter_like($keyword);
		foreach($data as $row){
			
			
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['nm_dokter'],
				'id_dokter'				=>$row['id_dokter'],
				'nm_dokter'				=>$row['nm_dokter']
			);
		}
		echo json_encode($arr);
    }
}
