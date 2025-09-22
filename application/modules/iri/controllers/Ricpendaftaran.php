<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');
// require_once(APPPATH.'controllers/Secure_area.php');
class Ricpendaftaran extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimkelas');
		$this->load->model('irj/rjmtracer', '', TRUE);
		$this->load->model('iri/rimreservasi');
		$this->load->model('irj/rjmpencarian', '', TRUE);
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmregistrasi');
		$this->load->model('bpjs/Mbpjs', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->library('vclaim');
	}

	public function cetak_iri()
	{
		return $this->load->view('RM_02');
	}

	public function index($noreservasi = '')
	{
		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = 'active';
		$data['pasien'] = '';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';
		$irna_antrian = $this->rimpendaftaran->select_irna_antrian_by_noreservasi($noreservasi);
		$data['poli'] = $this->rjmpencarian->get_poliklinik()->result();
		$tppri = $irna_antrian[0]['tppri'];
		// var_dump($irna_antrian);die();
		$data['nosurat_skdp'] = '';
		if ($tppri == 'rawatjalan') {
			$pasien = $this->rimpendaftaran->select_pasien_irj_by_no_register_asal($irna_antrian[0]['no_register_asal']);
			$data['nosurat_skdp'] = $pasien[0]['nosurat_skdp'];
		} else if ($tppri == 'ruangrawat') {
			$pasien = $this->rimpendaftaran->select_pasien_iri_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		} else {
			$pasien = $this->rimpendaftaran->select_pasien_ird_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		}
		$data['kls_bpjs'] = '';
		$pasiendetail = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($irna_antrian[0]['no_medrec'])->result();
		foreach ($pasiendetail as $row) {
			$no_medrec = $row->no_medrec;
			$data['kls_bpjs'] = $row->kelas_bpjs;
		}

		$data['irna_reservasi'] = $irna_antrian;
		$data['kelas'] = $this->rimkelas->get_all_kelas_with_empty_bed();
		// var_dump($data['kelas']);die();
		$data['status_bed'] = $this->rimkelas->get_all_status_bed();
		$data['all_kelas'] = $this->rimkelas->get_kelas();
		$data['empty_bed'] = $this->rimkelas->get_all_empty_bed();
		$data['data_pasien'] = $pasien;
		$data['ppk'] = $this->rimpendaftaran->get_all_ppk();
		$data['cara_bayar'] = $this->rimpendaftaran->get_all_cara_bayar();
		$data['kontraktor_all'] = $this->rimpendaftaran->get_all_kontraktor();
		$data['smf'] = $this->rimpendaftaran->get_all_smf();
		$data['kontraktorbpjs'] = $this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result_array();
		$data['kontraktor'] = $this->rjmregistrasi->get_kontraktor_kerjasama('KERJASAMA')->result_array();
		$data['pasien_iri'] = $this->rimpendaftaran->get_pasien_iri_by_noregasal($irna_antrian[0]['no_register_asal'])->result();
		$data['no_ipd'] = isset($data['pasien_iri'][0]->no_ipd) ? $data['pasien_iri'][0]->no_ipd : '';
		//  var_dump($data['no_ipd']);die();
		$data['no_register_asal'] = $irna_antrian[0]['no_register_asal'];
		$data['surat_persetujuan_iri'] = $this->rimpendaftaran->get_suratpersetujuaniri_by_noregasal($irna_antrian[0]['no_register_asal'])->result();
		$data['general_consent'] = $this->rimpendaftaran->get_general_consent_noregasal($irna_antrian[0]['no_register_asal'])->result();
		$data['selisih_tarif'] = $this->rimtindakan->get_selisih_tarif($data['no_ipd'])->row();
		$data['pernyataan_titip'] = $this->rimtindakan->get_pernyataan_titip($data['no_ipd'])->row();
		$data['leaflet_hak'] = $this->rimtindakan->get_leaflet_hak($data['no_ipd'])->row();
		// var_dump($data['leaflet_hak']);die();
		$data['pernyataan_cara_bayar_umum'] = $this->rimtindakan->get_pernyataan_cara_bayar_umum($data['no_ipd'])->row();
		$data['diagnosa_pasien'] = $this->rimpendaftaran->get_diagnosa_pasien($irna_antrian[0]['no_register_asal'])->result();
		$this->load->view('iri/form_pendaftaran', $data);
	}
	public function data_ruang()
	{
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_ruang_like($keyword);
		foreach ($data as $row) {
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['idrg'] . ' - ' . $row['nmruang'] . ' - ' . $row['koderg'],
				'idrg'				=> $row['idrg'],
				'nmruang'			=> $row['nmruang'],
				'kelas'				=> $row['koderg']
			);
		}
		echo json_encode($arr);
	}

	public function insert_pendaftaran_()
	{

		$no_kartu = $this->input->post('no_bpjs');
		if ($this->input->post('diagnosa_id') == '-' or $this->input->post('diagnosa_id') == ' ') {

			echo json_encode(['code' => 400, 'message' => 'Diagnosa Kosong Harap Isi Diagnosa']);
			exit();
		} // metadata code

		$data_pendaftaran['no_medrec'] = $this->input->post('no_cm_hidden');
		$data_pendaftaran['noipdlama'] = $this->input->post('noipdlama');
		$data_pendaftaran['spri'] = $this->input->post('spri');
		// var_dump($data_pendaftaran['no_medrec']);die();
		if ($this->input->post('noregasal') == '') {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal_bayi($this->input->post('noregasal'), $data_pendaftaran['no_medrec'])->num_rows();
		} else {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal($this->input->post('noregasal'))->num_rows();
		}

		if (!$count) {

			// $data_pendaftaran['drpengirim'] = $this->input->post('')
			// var_dump($count);die();
			$data_pendaftaran['titip'] = $this->input->post('titip');
			$data_pendaftaran['selisih_tarif'] = $this->input->post('selisih_tarif');
			$data_pendaftaran['naik_1_tingkat'] = $this->input->post('naik_1_tingkat');
			$data_pendaftaran['drpengirim'] = $this->input->post('drpengirim');
			$data_pendaftaran['noregasal'] = $this->input->post('noregasal');
			$data_pendaftaran['tgldaftarri'] = $this->input->post('tgldaftarri');
			$data_pendaftaran['carabayar'] = $this->input->post('carabayar');
			$data_pendaftaran['id_smf'] = $this->input->post('id_smf');
			$dokter = explode('-', $this->input->post('dokter'));
			$data_pendaftaran['id_dokter'] = $dokter[0];
			$data_pendaftaran['dokter'] = $dokter[1];
			$data_pendaftaran['nama'] = $this->input->post('name');
			$data_pendaftaran['tgl_masuk'] = date('Y-m-d');
			$data_pendaftaran['jam_masuk'] = date('H:i:s');

			//ambil_data irna antrian
			$irna_antrian = $this->rimreservasi->select_irna_antrian_by_noreservasi($data_pendaftaran['noipdlama']);

			$data_pendaftaran['diagmasuk'] = explode('-', $this->input->post('diagnosa_id'))[0]; //isi sama diagnosa di irna antrian

			//data lainlain
			$data_pendaftaran['jatahklsiri'] = $this->input->post('jatahkls');
			$data_pendaftaran['no_rujukan'] = $this->input->post('no_rujukan');
			$data_pendaftaran['tgl_rujukan'] = $this->input->post('tgl_rujukan');
			$data_pendaftaran['nopembayarri'] = $this->input->post('nopembayarri');
			if ($this->input->post('carabayar') == 'KERJASAMA') {
				$id_kontraktor = $this->input->post('nmkontraktorbpjs');
				$data_pendaftaran['id_kontraktor'] = intval($id_kontraktor);
			} elseif ($this->input->post('carabayar') == 'BPJS') {
				$data_pendaftaran['id_kontraktor'] = 3;
			} else {
				$data_pendaftaran['id_kontraktor'] = null;
			}

			$data_pendaftaran['ketpembayarri'] = $this->input->post('ketpembayarri');
			$data_pendaftaran['nmpembayatri'] = $this->input->post('nmpembayarri');
			$data_pendaftaran['jenkel'] = $this->input->post('jenkel');
			$data_pendaftaran['pasien_anak'] = $this->input->post('anak');
			$data_pendaftaran['golpembayarri'] = $this->input->post('golpembayarri');
			$data_pendaftaran['nmpjawabri'] = $this->input->post('nmpjawabri');
			$data_pendaftaran['alamatpjawabri'] = $this->input->post('alamatpjawabri');
			$data_pendaftaran['namaaksespjawabri1'] = $this->input->post('namaaksespjawab1');
			$data_pendaftaran['namaaksespjawabri2'] = $this->input->post('namaaksespjawab2');
			$data_pendaftaran['namaaksespjawabri3'] = $this->input->post('namaaksespjawab3');
			$data_pendaftaran['notlppjawab'] = $this->input->post('notlppjawab');
			$data_pendaftaran['kartuidpjawab'] = $this->input->post('kartuidpjawab');
			$data_pendaftaran['tgllahirpjawabri'] = $this->input->post('tgllahirpjawabri');
			$data_pendaftaran['noidpjawab'] = $this->input->post('noidpjawab');
			$data_pendaftaran['hubpjawabri'] = $this->input->post('hubjawabri');
			$data_pendaftaran['catatan'] = $this->input->post('catatan');
			$data_pendaftaran['catatan_ringkasan'] = $this->input->post('catatan_ring');
			$get_data_bpjs = $this->Mbpjs->get_data_bpjs();
			if ($this->input->post('asal_rujukan') && $this->input->post('ppk_asal_rujukan')) {
				$data_pendaftaran['asal_rujukan'] = $this->input->post('asal_rujukan');
				$data_pendaftaran['ppk_asal_rujukan'] = $this->input->post('ppk_asal_rujukan');
			} else {
				$data_pendaftaran['asal_rujukan'] = 2;
				$data_pendaftaran['ppk_asal_rujukan'] = $get_data_bpjs->rsid . ' - RSOMH BUKITTINGGI';
			}
			if ($this->input->post('katarak') == 1) {
				$data_pendaftaran['katarak'] = 1;
			} else $data_pendaftaran['katarak'] = 0;
			$data_pendaftaran['nosurat_skdp_sep'] = $this->input->post('nosurat_skdp_sep');
			$data_pendaftaran['dpjp_skdp_sep'] = $this->input->post('dpjp_skdp_sep');
			$ipd = explode(" - ", $this->input->post('ipdnama'))[0];

			//
			// $data_pendaftaran['idrg']=$this->input->post('ruang');
			// $data_ruang_iri['kelas']=$this->input->post('kelas');
			// $temp_ruang_raw=$this->input->post('ruangibu')?$this->input->post('ruangibu'):$this->input->post('ruang');
			// $temp_ruang =explode("-", $temp_ruang_raw);
			// $data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
			// $data_pendaftaran['idrg']=explode("-", $temp_ruang_raw)[0]; // Kode ruang pilih
			// $data_pendaftaran['klsiri']=explode("-", $temp_ruang_raw)[2]; // Kode ruang pilih
			// $data_ruang_iri['kelas']=explode("-", $temp_ruang_raw)[2]; // Kelas

			// $data_ruang_iri['idrg']=$temp_ruang[0];
			// $data_ruang_iri['bed']=$this->input->post('bed');
			// var_dump($data_ruang_iri['bed']);die();
			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;

			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;
			$data_ruang_iri['idrgiri'] = $no_id;

			//ngambil dari jatah kelas
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			// $data_pendaftaran['bed']=$data_ruang_iri['bed']; // Kode ruang pilih
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');
			// $data_ruang_iri['tglmasukrg']=$this->input->post('tglmasukrg');

			//get biaya ruang

			$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();
			// var_dump($get_tarif_ruang);

			if (!$get_tarif_ruang) {
				echo json_encode([
					'code' => '404',
					'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
				]);
				exit;
			}
			$tarif_ruang = $get_tarif_ruang->total_tarif;

			$biaya_ruang = 0;
			if ($tarif_ruang = null || $tarif_ruang = "") {
				$biaya_ruang = 0;
			} else {
				$biaya_ruang = $tarif_ruang;
			}
			$data_ruang_iri['vtot'] = intval($biaya_ruang);
			$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);

			$data_pendaftaran['ipdibu'] = $this->input->post('noipdibu');
			if ($data_pendaftaran['ipdibu'] != "") {
				$data_ibu = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['ipdibu']);

				//overide data yang awal diganti pake data yang dari ibu untuk ruangannya aja. kalo ada ipd ibu

				$data_pendaftaran['ipdibu'] = $ipd;
				// var_dump($ipd);die();
				$data_pendaftaran['nm_ruang'] = $data_ibu[0]['nm_ruang'];
				$data_pendaftaran['idrg'] = $data_ibu[0]['idrg']; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = $data_ibu[0]['kelas']; // Kode ruang pilih
				$data_ruang_iri['kelas'] = $data_ibu[0]['kelas']; // Kelas
				$data_ruang_iri['idrg'] = $data_ibu[0]['idrg'];
				$data_ruang_iri['bed'] = $data_ibu[0]['bed'];
				$data_pendaftaran['bed'] = $data_ibu[0]['bed']; // Kode ruang pilih
				$data_ruang_iri['vtot'] = 0;
				$data_pendaftaran['vtot_ruang'] = 0;
			} else {
				$temp_ruang_raw = $this->input->post('ruang');
				$temp_ruang = explode("-", $temp_ruang_raw);
				$data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
				$data_pendaftaran['idrg'] = explode("-", $temp_ruang_raw)[0]; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = explode("-", $temp_ruang_raw)[2]; // Kode ruang pilih
				$data_ruang_iri['kelas'] = explode("-", $temp_ruang_raw)[2]; // Kelas
				$data_ruang_iri['idrg'] = $temp_ruang[0];
				$data_ruang_iri['bed'] = $this->input->post('bed');
				$data_pendaftaran['bed'] = $data_ruang_iri['bed'];

				//get biaya ruang
				$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();

				if (!$get_tarif_ruang) {
					echo json_encode([
						'code' => '404',
						'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
					]);
					exit;
				}
				$tarif_ruang = $get_tarif_ruang->total_tarif;

				// $biaya_ruang = 0;
				if ($tarif_ruang == null || $tarif_ruang == "") {
					$biaya_ruang = 0;
				} else {
					$biaya_ruang = $tarif_ruang;
				}
				// var_dump($biaya_ruang);die();
				$data_ruang_iri['vtot'] = intval($biaya_ruang);
				$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);
			}

			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;
			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;;
			$data_ruang_iri['idrgiri'] = $no_id;

			//ngambil dari jatah kelas
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			// Kode ruang pilih
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');

			// MENU
			$data['reservasi'] = '';
			$data['daftar'] = 'active';
			$data['pasien'] = '';
			$data['mutasi'] = '';
			$data['status'] = '';
			$data['resume'] = '';
			$data['kontrol'] = '';
			$bd = $data_ruang_iri['bed'];
			$beds = $bd;
			$bed = $this->rimkelas->get_bed_by_bed($beds);
			// var_dump($bed);die();
			if (!$bed->num_rows()) {
				echo json_encode([
					'code' => 0,
					'message' => 'Tarif Bed Tidak Ada, Silahkan Kontak Administrator!'
				]);
			} else {
				if ($bed->result_array()[0]['isi'] == 'Y' && $data_pendaftaran['ipdibu'] == "") {
					$this->session->set_flashdata(
						'pesan',
						"<div class='alert alert-error alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
					</div>"
					);

					echo json_encode([
						'code' => 99,
						'message' => 'Bed Kosong,Silahkan Pilih Bed Lain!'
					]);
					exit;
				}
				$no = count($this->rimpendaftaran->select_pasien_iri()) + 1;
				$data_pendaftaran['no_ipd'] = 'RI' . strval(substr(date('Y'), 2)) . sprintf("%06d", $no);
				$temp_data_ipd = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				while (($temp_data_ipd)) {
					$no = $no + 1;
					$data_pendaftaran['no_ipd'] = 'RI' . sprintf("%08d", $no);
					$temp_data_ipd =  $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				}

				$login_data = $this->load->get_var("user_info");
				$data_pendaftaran['verifuser'] = $login_data->username;
				$status_pasien = $this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
				$data_ruang_iri['no_ipd'] = $data_pendaftaran['no_ipd'];
				$data_ruang_iri['statmasukrg'] = "masuk";
				$data_ruang_iri['xuser'] = $login_data->username;

				// if($data_pendaftaran['carabayar'] == "BPJS") {
				// 	$message = '<div class="alert alert-info">
				// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 						<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 						<p>
				// 							<button type="button" class="btn btn-social btn-bitbucket create_sep" data-noregister="'.$data_pendaftaran['no_ipd'].'" style="margin-top: 10px;">
				// 								<i class="fa fa-edit" style="font-size: 1.3em;"></i> Buat SEP
				// 							</button>
				// 						</p>
				// 					</div>';
				// } else {
				// 	$message = '<div class="alert alert-info">
				// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 					<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 				</div>';
				// }

				$data0['no_medrec'] = $data_pendaftaran['no_medrec'];
				$data0['no_register'] = $data_pendaftaran['no_ipd'];
				$data0['id_poli'] = $data_ruang_iri['idrg'];
				$data0['timeout'] = date('Y-m-d H:i:s');
				$data0['status'] = 1;
				$data0['tiperawat'] = 'IRI';
				// $this->session->set_flashdata('pesan',$message);
				$data_update['statusantrian'] = 'Y';
				$data_update['user_approve'] = $login_data->username;

				$data_bed['isi'] = 'Y';
				$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
				$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
				$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);
				$noresev = $data_pendaftaran['no_ipd'];
				// echo json_encode(array("status" => TRUE, "ket" => "1", "nex" => 'emedcrec/c_emedrec_ri/cetak_pengantar_iri/'.$noresev));
				echo json_encode([
					'code' => 1,
					'message' => 'Pendaftaran Pasien Berhasil!'
				]);
			}
		} else {
			echo json_encode([
				'code' => 2,
				'message' => 'Pasien Sudah Berada Di Ruangan!'
			]);
			// echo json_encode(array("status" => TRUE, "ket" => "2", "nex" => 'iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']));
		}
	}

	public function insert_pendaftaran()
	{

		$no_kartu = $this->input->post('no_bpjs');
		if ($this->input->post('diagnosa_id') == '-' or $this->input->post('diagnosa_id') == ' ') {

			echo json_encode(['code' => 400, 'message' => 'Diagnosa Kosong Harap Isi Diagnosa']);
			exit();
		} // metadata code	

		$data_pendaftaran['no_medrec'] = $this->input->post('no_cm_hidden');
		$data_pendaftaran['noipdlama'] = $this->input->post('noipdlama');
		$data_pendaftaran['spri'] = $this->input->post('spri');
		if ($this->input->post('noregasal') == '0') {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal_bayi($this->input->post('noregasal'), $data_pendaftaran['no_medrec'])->num_rows();
		} else {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal($this->input->post('noregasal'))->num_rows();
		}
		// $count=$this->rimpendaftaran->get_pasien_iri_by_noregasal($this->input->post('noregasal'))->num_rows();
		if (!$count) {

			$data_pendaftaran['titip'] = $this->input->post('titip');
			$data_pendaftaran['selisih_tarif'] = $this->input->post('selisih_tarif');
			$data_pendaftaran['naik_1_tingkat'] = $this->input->post('naik_1_tingkat');
			$data_pendaftaran['drpengirim'] = $this->input->post('drpengirim');
			$data_pendaftaran['noregasal'] = $this->input->post('noregasal');
			$data_pendaftaran['tgldaftarri'] = $this->input->post('tgldaftarri');
			$data_pendaftaran['carabayar'] = $this->input->post('carabayar');
			$data_pendaftaran['id_smf'] = $this->input->post('id_smf');
			$dokter = explode('-', $this->input->post('dokter'));
			$data_pendaftaran['id_dokter'] = $dokter[0];
			// $data_pendaftaran['dokter'] = $dokter[1];
			$data_pendaftaran['nama'] = $this->input->post('name');
			$data_pendaftaran['tgl_masuk'] = ($this->input->post('tglmasukrg')) ? date('Y-m-d', strtotime($this->input->post('tglmasukrg'))) : date('Y-m-d');
			$data_pendaftaran['jam_masuk'] = ($this->input->post('tglmasukrg')) ? date('H:i:s', strtotime($this->input->post('tglmasukrg'))) : date('H:i:s');

			//ambil_data irna antrian
			$irna_antrian = $this->rimreservasi->select_irna_antrian_by_noreservasi($data_pendaftaran['noipdlama']);

			$data_pendaftaran['diagmasuk'] = explode('-', $this->input->post('diagnosa_id'))[0]; //isi sama diagnosa di irna antrian

			//data lainlain
			$data_pendaftaran['jatahklsiri'] = $this->input->post('jatahkls');
			$data_pendaftaran['no_rujukan'] = $this->input->post('no_rujukan');
			$data_pendaftaran['tgl_rujukan'] = $this->input->post('tgl_rujukan');
			$data_pendaftaran['nopembayarri'] = $this->input->post('nopembayarri');
			if ($this->input->post('carabayar') == 'KERJASAMA') {
				$id_kontraktor = $this->input->post('nmkontraktorbpjs');
				$data_pendaftaran['id_kontraktor'] = intval($id_kontraktor);
			} elseif ($this->input->post('carabayar') == 'BPJS') {
				if ($this->input->post('id_kontraktor_old') != '') {
					$data_pendaftaran['id_kontraktor'] = $this->input->post('id_kontraktor_old');
				} else {
					$data_pendaftaran['id_kontraktor'] = 3;
				}
			} else {
				$data_pendaftaran['id_kontraktor'] = null;
			}

			$data_pendaftaran['ketpembayarri'] = $this->input->post('ketpembayarri');
			$data_pendaftaran['nmpembayatri'] = $this->input->post('nmpembayarri');
			$data_pendaftaran['jenkel'] = $this->input->post('jenkel');
			$data_pendaftaran['pasien_anak'] = $this->input->post('anak');
			$data_pendaftaran['golpembayarri'] = $this->input->post('golpembayarri');
			$data_pendaftaran['nmpjawabri'] = $this->input->post('nmpjawabri');
			$data_pendaftaran['alamatpjawabri'] = $this->input->post('alamatpjawabri');
			$data_pendaftaran['namaaksespjawabri1'] = $this->input->post('namaaksespjawab1');
			$data_pendaftaran['namaaksespjawabri2'] = $this->input->post('namaaksespjawab2');
			$data_pendaftaran['namaaksespjawabri3'] = $this->input->post('namaaksespjawab3');
			$data_pendaftaran['notlppjawab'] = $this->input->post('notlppjawab');
			$data_pendaftaran['kartuidpjawab'] = $this->input->post('kartuidpjawab');
			$data_pendaftaran['tgllahirpjawabri'] = $this->input->post('tgllahirpjawabri');
			$data_pendaftaran['noidpjawab'] = $this->input->post('noidpjawab');
			$data_pendaftaran['hubpjawabri'] = $this->input->post('hubjawabri');
			$data_pendaftaran['catatan'] = $this->input->post('catatan');
			$data_pendaftaran['catatan_ringkasan'] = $this->input->post('catatan_ring');
			$get_data_bpjs = $this->Mbpjs->get_data_bpjs();
			if ($this->input->post('asal_rujukan') && $this->input->post('ppk_asal_rujukan')) {
				$data_pendaftaran['asal_rujukan'] = $this->input->post('asal_rujukan');
				$data_pendaftaran['ppk_asal_rujukan'] = $this->input->post('ppk_asal_rujukan');
			} else {
				$data_pendaftaran['asal_rujukan'] = 2;
				$data_pendaftaran['ppk_asal_rujukan'] = $get_data_bpjs->rsid . ' - RSUD SIJUNJUNG';
			}
			if ($this->input->post('katarak') == 1) {
				$data_pendaftaran['katarak'] = 1;
			} else $data_pendaftaran['katarak'] = 0;
			$data_pendaftaran['nosurat_skdp_sep'] = $this->input->post('nosurat_skdp_sep');
			$data_pendaftaran['dpjp_skdp_sep'] = $this->input->post('dpjp_skdp_sep');
			$ipd = explode(" - ", $this->input->post('ipdnama'))[0];

			if ($ipd != "") {
				//$ipd = explode(" - ", $data_pendaftaran['ipdibu'])[0];
				$data_ibu = $this->rimtindakan->get_pasien_by_no_ipd($ipd);
				// var_dump($data_ibu);die();
				//overide data yang awal diganti pake data yang dari ibu untuk ruangannya aja. kalo ada ipd ibu

				$data_pendaftaran['ipdibu'] = $ipd;
				$data_pendaftaran['nm_ruang'] = 'Perinatologi';
				$data_pendaftaran['idrg'] = '1001'; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = $this->input->post('klsiri'); // Kode ruang pilih
				$data_ruang_iri['kelas'] = $this->input->post('klsiri'); // Kelas
				$data_ruang_iri['idrg'] = '1001';
				$data_ruang_iri['bed'] = $this->input->post('bed');;
				$data_pendaftaran['bed'] = $this->input->post('bed');; // Kode ruang pilih
				$data_ruang_iri['vtot'] = 0;
				$data_pendaftaran['vtot_ruang'] = 0;
			} else {
				$temp_ruang_raw = $this->input->post('ruang');
				$temp_ruang = explode("@", $temp_ruang_raw);
				$data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
				$data_pendaftaran['idrg'] = explode("@", $temp_ruang_raw)[0]; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = explode("@", $temp_ruang_raw)[2]; // Kode ruang pilih
				$data_ruang_iri['kelas'] = explode("@", $temp_ruang_raw)[2]; // Kelas
				$data_ruang_iri['idrg'] = $temp_ruang[0];
				$data_ruang_iri['bed'] = $this->input->post('bed');
				$data_pendaftaran['bed'] = $data_ruang_iri['bed'];

				//get biaya ruang
				$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();

				// if (!$get_tarif_ruang) {
				// 	echo json_encode([
				// 		'code' => '404',
				// 		'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
				// 	]);
				// 	exit;
				// }
				$tarif_ruang = $get_tarif_ruang->total_tarif;

				// $biaya_ruang = 0;
				if ($tarif_ruang == null || $tarif_ruang == "") {
					$biaya_ruang = 0;
				} else {
					$biaya_ruang = $tarif_ruang;
				}
				// var_dump($biaya_ruang);die();
				$data_ruang_iri['vtot'] = intval($biaya_ruang);
				$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);
			}

			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;
			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;;
			$data_ruang_iri['idrgiri'] = $no_id;

			//ngambil dari jatah kelas
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			// Kode ruang pilih
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');

			// MENU
			$data['reservasi'] = '';
			$data['daftar'] = 'active';
			$data['pasien'] = '';
			$data['mutasi'] = '';
			$data['status'] = '';
			$data['resume'] = '';
			$data['kontrol'] = '';
			$bd = $data_ruang_iri['bed'];
			$beds = $bd;
			$bed = $this->rimkelas->get_bed_by_bed($beds);
			// var_dump($bed);die();
			if (!$bed->num_rows()) {
				echo json_encode([
					'code' => 0,
					'message' => 'Tarif Bed Tidak Ada, Silahkan Kontak Administrator!'
				]);
			} else {
				if ($bed->result_array()[0]['isi'] == 'Y' && $data_pendaftaran['ipdibu'] == "") {
					$this->session->set_flashdata(
						'pesan',
						"<div class='alert alert-error alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
					</div>"
					);

					echo json_encode([
						'code' => 99,
						'message' => 'Bed Kosong,Silahkan Pilih Bed Lain!'
					]);
					exit;
				}
				$no = count($this->rimpendaftaran->select_pasien_iri()) + 1;
				$data_pendaftaran['no_ipd'] = 'RI' . strval(substr(date('Y'), 2)) . sprintf("%06d", $no);
				$temp_data_ipd = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				while (($temp_data_ipd)) {
					$no = $no + 1;
					$data_pendaftaran['no_ipd'] = 'RI' . sprintf("%08d", $no);
					$temp_data_ipd =  $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				}

				$login_data = $this->load->get_var("user_info");
				$data_pendaftaran['verifuser'] = $login_data->username;
				$status_pasien = $this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
				$data_ruang_iri['no_ipd'] = $data_pendaftaran['no_ipd'];
				$data_ruang_iri['statmasukrg'] = "masuk";
				$data_ruang_iri['xuser'] = $login_data->username;

				// if($data_pendaftaran['carabayar'] == "BPJS") {
				// 	$message = '<div class="alert alert-info">
				// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 						<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 						<p>
				// 							<button type="button" class="btn btn-social btn-bitbucket create_sep" data-noregister="'.$data_pendaftaran['no_ipd'].'" style="margin-top: 10px;">
				// 								<i class="fa fa-edit" style="font-size: 1.3em;"></i> Buat SEP
				// 							</button>
				// 						</p>
				// 					</div>';	
				// } else {
				// 	$message = '<div class="alert alert-info">
				// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 					<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 				</div>';
				// }

				$data0['no_medrec'] = $data_pendaftaran['no_medrec'];
				$data0['no_register'] = $data_pendaftaran['no_ipd'];
				$data0['id_poli'] = $data_ruang_iri['idrg'];
				$data0['timeout'] = date('Y-m-d H:i:s');
				$data0['status'] = 1;
				$data0['tiperawat'] = 'IRI';
				// $this->session->set_flashdata('pesan',$message);
				$data_update['statusantrian'] = 'Y';
				$data_update['user_approve'] = $login_data->username;

				$data_bed['isi'] = 'Y';
				$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
				$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
				$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);
				$noresev = $data_pendaftaran['no_ipd'];
				// echo json_encode(array("status" => TRUE, "ket" => "1", "nex" => 'emedcrec/c_emedrec_ri/cetak_pengantar_iri/'.$noresev));

				/**
				 * Penambahan Bridging Aplicares Mobile JKN
				 */

				$bed = $this->Mbpjs->get_bed_idrg($data_ruang_iri['idrg'], $data_ruang_iri['kelas'])->row();

				$url = 'aplicaresws/rest/bed/update/0311R001';
				if ($bed) {
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
				}

				/**End added */

				echo json_encode([
					'code' => 1,
					'message' => 'Pendaftaran Pasien Berhasil!'
				]);
			}
		} else {
			// var_dump($this->input->post());die();
			$noreg_asal = $this->input->post('noregasal');
			//ruangan pasien iri
			$temp_ruang_raw = $this->input->post('ruang');
			$temp_ruang = explode("@", $temp_ruang_raw);
			$data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
			$data_pendaftaran['idrg'] = explode("@", $temp_ruang_raw)[0];
			$data_pendaftaran['klsiri'] = explode("@", $temp_ruang_raw)[2];
			$data_pendaftaran['bed'] = $this->input->post('bed');
			$bd = $data_pendaftaran['bed'];
			$beds = $bd;
			$bed = $this->rimkelas->get_bed_by_bed($beds);
			if (!$bed->num_rows()) {
				echo json_encode([
					'code' => 0,
					'message' => 'Tarif Bed Tidak Ada, Silahkan Kontak Administrator!'
				]);
			}
			$data_pendaftaran['jatahklsiri'] = $this->input->post('jatahkls');
			$data_pendaftaran['titip'] = $this->input->post('titip');
			$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();
			if (!$get_tarif_ruang) {
				echo json_encode([
					'code' => '404',
					'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
				]);
				exit;
			}

			$tarif_ruang = $get_tarif_ruang->total_tarif;

			if ($tarif_ruang == null || $tarif_ruang == "") {
				$biaya_ruang = 0;
			} else {
				$biaya_ruang = $tarif_ruang;
			}
			$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);
			// $data_pendaftaran['selisih_tarif'] = 0;
			// $data_pendaftaran['pindah_ruang'] = 0;
			$no_ipd = $this->rimtindakan->get_no_ipd($noreg_asal)->row()->no_ipd;
			$this->rimpendaftaran->update_pindah_ruang_iri($data_pendaftaran, $noreg_asal);

			// //update ruang iri
			// $idrg = $this->input->post('idrg');
			// $bed = $this->input->post('bed');
			// $kelas = $this->input->post('kelas');
			$get_idrgiri = $this->rimtindakan->get_idrgiri_new($no_ipd)->row();
			$datasupdate['tglkeluarrg'] = date('Y-m-d');
			$datasupdate['statkeluarrg'] = 'pindah';
			$datasupdate['xupdate'] = date('Y-m-d');
			$this->rimtindakan->update_ruang_iri_mutasi($no_ipd, $get_idrgiri->idrgiri, $datasupdate);

			// insert ruang iri
			$data_ruang_iri['kelas'] = explode("@", $temp_ruang_raw)[2];
			$data_ruang_iri['idrg'] = $temp_ruang[0];
			$data_ruang_iri['bed'] = $this->input->post('bed');
			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;
			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;;
			$data_ruang_iri['idrgiri'] = $no_id;
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');

			$data_ruang_iri['no_ipd'] = $no_ipd;
			$data_ruang_iri['statmasukrg'] = "masuk";
			$data_ruang_iri['xuser'] = $login_data->username;
			$data_ruang_iri['vtot'] = intval($biaya_ruang);

			$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);

			//update irna antrian
			$no_reser = $this->input->post('noregasal');
			$data_update['statusantrian'] = 'Y';
			$data_update['user_approve'] = $login_data->username;
			$this->rimpendaftaran->update_irna_antrian($data_update, $no_reser);

			//data bed
			$data_bed['isi'] = 'Y';
			$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);




			echo json_encode([
				'code' => 1,
				'message' => 'berhasil!'
			]);
			// echo json_encode(array("status" => TRUE, "ket" => "2", "nex" => 'iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']));
		}
	}

	public function insert_pendaftaran_backup()
	{
		//  var_dump($this->input->post('noregasal'));die();
		$no_kartu = $this->input->post('no_bpjs');
		if ($this->input->post('diagnosa_id') == '-' or $this->input->post('diagnosa_id') == ' ') {

			echo json_encode(['code' => 400, 'message' => 'Diagnosa Kosong Harap Isi Diagnosa']);
			exit();
		} // metadata code	

		$data_pendaftaran['no_medrec'] = $this->input->post('no_cm_hidden');
		$data_pendaftaran['noipdlama'] = $this->input->post('noipdlama');
		$data_pendaftaran['spri'] = $this->input->post('spri');
		if ($this->input->post('noregasal') == '0') {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal_bayi($this->input->post('noregasal'), $data_pendaftaran['no_medrec'])->num_rows();
		} else {
			$count = $this->rimpendaftaran->get_pasien_iri_by_noregasal($this->input->post('noregasal'))->num_rows();
		}
		// $count=$this->rimpendaftaran->get_pasien_iri_by_noregasal($this->input->post('noregasal'))->num_rows();
		if (!$count) {

			$data_pendaftaran['titip'] = $this->input->post('titip');
			$data_pendaftaran['drpengirim'] = $this->input->post('drpengirim');
			$data_pendaftaran['noregasal'] = $this->input->post('noregasal');
			$data_pendaftaran['tgldaftarri'] = $this->input->post('tgldaftarri');
			$data_pendaftaran['carabayar'] = $this->input->post('carabayar');
			$data_pendaftaran['id_smf'] = $this->input->post('id_smf');
			$dokter = explode('-', $this->input->post('dokter'));
			$data_pendaftaran['id_dokter'] = $dokter[0];
			$data_pendaftaran['dokter'] = $dokter[1];
			$data_pendaftaran['nama'] = $this->input->post('name');
			$data_pendaftaran['tgl_masuk'] = date('Y-m-d');
			$data_pendaftaran['jam_masuk'] = date('H:i:s');

			//ambil_data irna antrian
			$irna_antrian = $this->rimreservasi->select_irna_antrian_by_noreservasi($data_pendaftaran['noipdlama']);

			$data_pendaftaran['diagmasuk'] = explode('-', $this->input->post('diagnosa_id'))[0]; //isi sama diagnosa di irna antrian

			//data lainlain
			$data_pendaftaran['jatahklsiri'] = $this->input->post('jatahkls');
			$data_pendaftaran['no_rujukan'] = $this->input->post('no_rujukan');
			$data_pendaftaran['tgl_rujukan'] = $this->input->post('tgl_rujukan');
			$data_pendaftaran['nopembayarri'] = $this->input->post('nopembayarri');
			if ($this->input->post('carabayar') == 'KERJASAMA') {
				$id_kontraktor = $this->input->post('nmkontraktorbpjs');
				$data_pendaftaran['id_kontraktor'] = intval($id_kontraktor);
			} elseif ($this->input->post('carabayar') == 'BPJS') {
				$data_pendaftaran['id_kontraktor'] = 3;
			} else {
				$data_pendaftaran['id_kontraktor'] = null;
			}

			$data_pendaftaran['ketpembayarri'] = $this->input->post('ketpembayarri');
			$data_pendaftaran['nmpembayatri'] = $this->input->post('nmpembayarri');
			$data_pendaftaran['jenkel'] = $this->input->post('jenkel');
			$data_pendaftaran['pasien_anak'] = $this->input->post('anak');
			$data_pendaftaran['golpembayarri'] = $this->input->post('golpembayarri');
			$data_pendaftaran['nmpjawabri'] = $this->input->post('nmpjawabri');
			$data_pendaftaran['alamatpjawabri'] = $this->input->post('alamatpjawabri');
			$data_pendaftaran['namaaksespjawabri1'] = $this->input->post('namaaksespjawab1');
			$data_pendaftaran['namaaksespjawabri2'] = $this->input->post('namaaksespjawab2');
			$data_pendaftaran['namaaksespjawabri3'] = $this->input->post('namaaksespjawab3');
			$data_pendaftaran['notlppjawab'] = $this->input->post('notlppjawab');
			$data_pendaftaran['kartuidpjawab'] = $this->input->post('kartuidpjawab');
			$data_pendaftaran['tgllahirpjawabri'] = $this->input->post('tgllahirpjawabri');
			$data_pendaftaran['noidpjawab'] = $this->input->post('noidpjawab');
			$data_pendaftaran['hubpjawabri'] = $this->input->post('hubjawabri');
			$data_pendaftaran['catatan'] = $this->input->post('catatan');
			$data_pendaftaran['catatan_ringkasan'] = $this->input->post('catatan_ring');
			$get_data_bpjs = $this->Mbpjs->get_data_bpjs();
			if ($this->input->post('asal_rujukan') && $this->input->post('ppk_asal_rujukan')) {
				$data_pendaftaran['asal_rujukan'] = $this->input->post('asal_rujukan');
				$data_pendaftaran['ppk_asal_rujukan'] = $this->input->post('ppk_asal_rujukan');
			} else {
				$data_pendaftaran['asal_rujukan'] = 2;
				$data_pendaftaran['ppk_asal_rujukan'] = $get_data_bpjs->rsid . ' - RSOMH BUKITTINGGI';
			}
			if ($this->input->post('katarak') == 1) {
				$data_pendaftaran['katarak'] = 1;
			} else $data_pendaftaran['katarak'] = 0;
			$data_pendaftaran['nosurat_skdp_sep'] = $this->input->post('nosurat_skdp_sep');
			$data_pendaftaran['dpjp_skdp_sep'] = $this->input->post('dpjp_skdp_sep');
			$ipd = explode(" - ", $this->input->post('ipdnama'))[0];

			if ($ipd != "") {
				//$ipd = explode(" - ", $data_pendaftaran['ipdibu'])[0];
				$data_ibu = $this->rimtindakan->get_pasien_by_no_ipd($ipd);
				//overide data yang awal diganti pake data yang dari ibu untuk ruangannya aja. kalo ada ipd ibu

				$data_pendaftaran['ipdibu'] = $ipd;
				// var_dump($ipd);die();
				$data_pendaftaran['nm_ruang'] = $data_ibu[0]['nm_ruang'];
				$data_pendaftaran['idrg'] = $data_ibu[0]['idrg']; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = $data_ibu[0]['kelas']; // Kode ruang pilih
				$data_ruang_iri['kelas'] = $data_ibu[0]['kelas']; // Kelas
				$data_ruang_iri['idrg'] = $data_ibu[0]['idrg'];
				$data_ruang_iri['bed'] = $data_ibu[0]['bed'];
				$data_pendaftaran['bed'] = $data_ibu[0]['bed']; // Kode ruang pilih
				$data_ruang_iri['vtot'] = 0;
				$data_pendaftaran['vtot_ruang'] = 0;
			} else {
				$temp_ruang_raw = $this->input->post('ruang');
				$temp_ruang = explode("-", $temp_ruang_raw);
				$data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
				$data_pendaftaran['idrg'] = explode("-", $temp_ruang_raw)[0]; // Kode ruang pilih
				$data_pendaftaran['klsiri'] = explode("-", $temp_ruang_raw)[2]; // Kode ruang pilih
				$data_ruang_iri['kelas'] = explode("-", $temp_ruang_raw)[2]; // Kelas
				$data_ruang_iri['idrg'] = $temp_ruang[0];
				$data_ruang_iri['bed'] = $this->input->post('bed');
				$data_pendaftaran['bed'] = $data_ruang_iri['bed'];

				//get biaya ruang
				$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();

				if (!$get_tarif_ruang) {
					echo json_encode([
						'code' => '404',
						'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
					]);
					exit;
				}
				$tarif_ruang = $get_tarif_ruang->total_tarif;

				// $biaya_ruang = 0;
				if ($tarif_ruang == null || $tarif_ruang == "") {
					$biaya_ruang = 0;
				} else {
					$biaya_ruang = $tarif_ruang;
				}
				// var_dump($biaya_ruang);die();
				$data_ruang_iri['vtot'] = intval($biaya_ruang);
				$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);
			}

			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;
			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;;
			$data_ruang_iri['idrgiri'] = $no_id;

			//ngambil dari jatah kelas
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			// Kode ruang pilih
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');

			// MENU
			$data['reservasi'] = '';
			$data['daftar'] = 'active';
			$data['pasien'] = '';
			$data['mutasi'] = '';
			$data['status'] = '';
			$data['resume'] = '';
			$data['kontrol'] = '';
			$bd = $data_ruang_iri['bed'];
			$beds = $bd;
			$bed = $this->rimkelas->get_bed_by_bed($beds);
			// var_dump($bed);die();
			if (!$bed->num_rows()) {
				echo json_encode([
					'code' => 0,
					'message' => 'Tarif Bed Tidak Ada, Silahkan Kontak Administrator!'
				]);
			} else {
				if ($bed->result_array()[0]['isi'] == 'Y' && $data_pendaftaran['ipdibu'] == "") {
					$this->session->set_flashdata(
						'pesan',
						"<div class='alert alert-error alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
					</div>"
					);

					echo json_encode([
						'code' => 99,
						'message' => 'Bed Kosong,Silahkan Pilih Bed Lain!'
					]);
					exit;
				}
				$no = count($this->rimpendaftaran->select_pasien_iri()) + 1;
				$data_pendaftaran['no_ipd'] = 'RI' . strval(substr(date('Y'), 2)) . sprintf("%06d", $no);
				$temp_data_ipd = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				while (($temp_data_ipd)) {
					$no = $no + 1;
					$data_pendaftaran['no_ipd'] = 'RI' . sprintf("%08d", $no);
					$temp_data_ipd =  $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
				}

				$login_data = $this->load->get_var("user_info");
				$data_pendaftaran['verifuser'] = $login_data->username;
				$status_pasien = $this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
				$data_ruang_iri['no_ipd'] = $data_pendaftaran['no_ipd'];
				$data_ruang_iri['statmasukrg'] = "masuk";
				$data_ruang_iri['xuser'] = $login_data->username;

				// if($data_pendaftaran['carabayar'] == "BPJS") {
				// 	$message = '<div class="alert alert-info">
				// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 						<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 						<p>
				// 							<button type="button" class="btn btn-social btn-bitbucket create_sep" data-noregister="'.$data_pendaftaran['no_ipd'].'" style="margin-top: 10px;">
				// 								<i class="fa fa-edit" style="font-size: 1.3em;"></i> Buat SEP
				// 							</button>
				// 						</p>
				// 					</div>';	
				// } else {
				// 	$message = '<div class="alert alert-info">
				// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				// 					<h3><i class="fa fa-check-circle"></i> Pendaftaran Pasien Berhasil.</h3> Data berhasil disimpan.
				// 				</div>';
				// }

				$data0['no_medrec'] = $data_pendaftaran['no_medrec'];
				$data0['no_register'] = $data_pendaftaran['no_ipd'];
				$data0['id_poli'] = $data_ruang_iri['idrg'];
				$data0['timeout'] = date('Y-m-d H:i:s');
				$data0['status'] = 1;
				$data0['tiperawat'] = 'IRI';
				// $this->session->set_flashdata('pesan',$message);
				$data_update['statusantrian'] = 'Y';
				$data_update['user_approve'] = $login_data->username;

				$data_bed['isi'] = 'Y';
				$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
				$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
				$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);
				$noresev = $data_pendaftaran['no_ipd'];
				// echo json_encode(array("status" => TRUE, "ket" => "1", "nex" => 'emedcrec/c_emedrec_ri/cetak_pengantar_iri/'.$noresev));
				echo json_encode([
					'code' => 1,
					'message' => 'Pendaftaran Pasien Berhasil!'
				]);
			}
		} else {
			// var_dump($this->input->post());die();
			$noreg_asal = $this->input->post('noregasal');
			//ruangan pasien iri
			$temp_ruang_raw = $this->input->post('ruang');
			$temp_ruang = explode("-", $temp_ruang_raw);
			$data_pendaftaran['nm_ruang'] = $temp_ruang_raw;
			$data_pendaftaran['idrg'] = explode("-", $temp_ruang_raw)[0];
			$data_pendaftaran['klsiri'] = explode("-", $temp_ruang_raw)[2];
			$data_pendaftaran['bed'] = $this->input->post('bed');
			$bd = $data_pendaftaran['bed'];
			$beds = $bd;
			$bed = $this->rimkelas->get_bed_by_bed($beds);
			if (!$bed->num_rows()) {
				echo json_encode([
					'code' => 0,
					'message' => 'Tarif Bed Tidak Ada, Silahkan Kontak Administrator!'
				]);
			}
			$data_pendaftaran['jatahklsiri'] = $this->input->post('jatahkls');
			$data_pendaftaran['titip'] = $this->input->post('titip');
			$get_tarif_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'], $data_pendaftaran['idrg'])->row();
			if (!$get_tarif_ruang) {
				echo json_encode([
					'code' => '404',
					'message' => 'Tarif Ruangan Tidak Ada , Silahkan Isi Terlebih Dahulu'
				]);
				exit;
			}

			$tarif_ruang = $get_tarif_ruang->total_tarif;

			if ($tarif_ruang == null || $tarif_ruang == "") {
				$biaya_ruang = 0;
			} else {
				$biaya_ruang = $tarif_ruang;
			}
			$data_pendaftaran['vtot_ruang'] = intval($biaya_ruang);
			$data_pendaftaran['selisih_tarif'] = 0;
			$data_pendaftaran['pindah_ruang'] = 0;
			$no_ipd = $this->rimtindakan->get_no_ipd($noreg_asal)->row()->no_ipd;
			$this->rimpendaftaran->update_pindah_ruang_iri($data_pendaftaran, $noreg_asal);

			// //update ruang iri
			// $idrg = $this->input->post('idrg');
			// $bed = $this->input->post('bed');
			// $kelas = $this->input->post('kelas');
			$get_idrgiri = $this->rimtindakan->get_idrgiri_new($no_ipd)->row();
			$datasupdate['tglkeluarrg'] = date('Y-m-d');
			$datasupdate['statkeluarrg'] = 'pindah';
			$datasupdate['xupdate'] = date('Y-m-d');
			$this->rimtindakan->update_ruang_iri_mutasi($no_ipd, $get_idrgiri->idrgiri, $datasupdate);

			// insert ruang iri
			$data_ruang_iri['kelas'] = explode("-", $temp_ruang_raw)[2];
			$data_ruang_iri['idrg'] = $temp_ruang[0];
			$data_ruang_iri['bed'] = $this->input->post('bed');
			$login_data = $this->load->get_var("user_info");
			$data_ruang_iri['xuser'] = $login_data->username;
			$no_id = ($this->rimpendaftaran->select_ruang_iri_new()->row()->idrgiri) + 1;;
			$data_ruang_iri['idrgiri'] = $no_id;
			$data_ruang_iri['harga_jatah_kelas'] = 0;
			$data_ruang_iri['tglmasukrg'] = $this->input->post('tglmasukrg');

			$data_ruang_iri['no_ipd'] = $no_ipd;
			$data_ruang_iri['statmasukrg'] = "masuk";
			$data_ruang_iri['xuser'] = $login_data->username;
			$data_ruang_iri['vtot'] = intval($biaya_ruang);

			$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);

			//update irna antrian
			$no_reser = $this->input->post('noregasal');
			$data_update['statusantrian'] = 'Y';
			$data_update['user_approve'] = $login_data->username;
			$this->rimpendaftaran->update_irna_antrian($data_update, $no_reser);

			//data bed
			$data_bed['isi'] = 'Y';
			$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);




			echo json_encode([
				'code' => 1,
				'message' => 'berhasil!'
			]);
			// echo json_encode(array("status" => TRUE, "ket" => "2", "nex" => 'iri/ricpendaftaran/index/'.$data_pendaftaran['noipdlama']));
		}
	}

	public function update_irna_antrian($no_reg = '')
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_regis = $no_reg;
		// var_dump($no_regis);die();
		$login_data = $this->load->get_var("user_info");
		$data_update['statusantrian'] = 'Y';
		$data_update['user_approve'] = $login_data->username;
		$this->rimpendaftaran->update_irna_antrian($data_update, $no_regis);
		$wkt = date('Y-m-d h:i:s');
		// $this->rimpendaftaran->update_wkt_akhir_admisi($no_regis,$wkt);
		redirect('iri/Ricdaftar/index/1', 'refresh');
	}

	public function update_irna_antrian_bayi($no_reg = '')
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_regis = $no_reg;
		// var_dump($no_regis);die();
		$data_update['daftar_bayi'] = 1;
		$this->rimpendaftaran->update_irna_antrian_bayi($data_update, $no_regis);
		$wkt = date('Y-m-d h:i:s');
		$this->rimpendaftaran->update_wkt_akhir_admisi($no_regis,$wkt);
		redirect('iri/Ricbayi', 'refresh');
	}

	public function get_penanggungjawab_pasien($no_ipd)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data_pasien = $this->rimpendaftaran->get_penanggungjawab_pasien($no_ipd);
		echo json_encode($data_pasien);
	}

	public function update_penanggung_jawab()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->input->post();
		$update_data_pasien = $this->rimpendaftaran->update_pasien_iri($data, $this->input->post('no_ipd'));
		$result = json_encode($update_data_pasien ? array('code' => 200) : array('code' => 404));
		echo $result;
	}

	// added @aldi
	public function update_pendaftaran_pasien()
	{
		$data = $this->input->post();
		if ($data['carabayar'] != "BPJS") {
			unset(
				$data['id_kontraktor_bpjs'],
				$data['no_bpjs'],
				$data['no_medrec'],
				$data['carabayar'],
				$data['no_ipd'],
				$data['id_kontraktor_bpjs'],
				$data['nmkontraktorbpjs'],
				$data['nosurat_skdp_sep'],
				$data['dpjp_skdp_sep'],
				$data['catatan'],
				$data['no_bpjs'],
				$data['nmkontraktorbpjs']
			);
		} else {
			unset(
				$data['nmkontraktorbpjs'],
				$data['id_kontraktor_bpjs'],
				$data['no_ipd'],
				$data['carabayar'],
				$data['no_medrec'],
				$data['no_bpjs']
			);
		}
		// $removeData = $data['carabayar']!='BPJS'?unset($data['no_ipd'],$data['id_kontraktor_bpjs'],$data['nmkontraktorbpjs'],$data['nosurat_skdp_sep'],$data['dpjp_skdp_sep'],$data['catatan']):unset($data['no_ipd']);
		$pasien['no_kartu'] = $this->input->post('no_bpjs');
		$update_pasien = $this->rimpendaftaran->update_data_pasien($pasien, $this->input->post('no_medrec'));
		$update_data_pasien = $this->rimpendaftaran->update_pasien_iri($data, $this->input->post('no_ipd'));
		$result = json_encode($update_data_pasien ? array('code' => 200) : array('code' => 404));
		echo $result;
	}


	public function cetak_rawatinap($no_ipd = '')
	{
		error_reporting(~E_ALL);
		if ($no_ipd != '') {
			$data['data_pengantar'] = $this->rimpendaftaran->select_irna_antrian_by_noreservasi2($no_ipd)->result();
			return $this->load->view('iri/RM_001a_RI', $data);
			// $namars=$this->config->item('namars');
			// $alamatrs=$this->config->item('alamat');
			// $telprs=$this->config->item('telp');
			// $kota=$this->config->item('kota');
			// $nmsingkat=$this->config->item('nmsingkat');

			// //set timezone
			// date_default_timezone_set("Asia/Bangkok");
			// $tgl_jam = date("d-m-Y H:i:s");

			// $data_identitas=$this->rimpendaftaran->select_irna_antrian_by_noreservasi2($no_ipd)->result();
			// foreach($data_identitas as $row){
			// $interval = date_diff(date_create(), date_create($row->tgl_lahir));
			// $hari = (date("d",strtotime($row->tgldaftarri)));
			// $bulan = (date("F",strtotime($row->tgldaftarri)));
			// $tahun = (date("Y",strtotime($row->tgldaftarri)));
			// $jam = (date("H:i:s",strtotime($row->tgldaftarri)));

			// $konten_header=
			// 		"<style type=\"text/css\">
			// 		.table-font-size{
			// 			font-size:9px;
			// 		    }
			// 		</style>
			// 		<table class=\"table-font-size\" border=\"0\">
			// 			<tr>
			// 			<td rowspan=\"3\" width=\"15%\" style=\"border-bottom:1px solid black; font-size:13px; \"><p><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"49\" style=\"padding-right:5px;\"></p></td>
			// 			<td width=\"65%\" style=\"border-bottom:1px solid black; font-size:14px;\">
			// 			<br/><b>$namars</b> <br/><span style=\"font-size:10px;\">$alamatrs</span><br/><span style=\"font-size:10px;\">$telprs</span></td>
			// 			<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:12px;align:right\">
			// 			<div style=\" text-align:center;font-size:13px; border:1px solid black;\">RM 02</div>

			// 			</td>
			// 			</tr>
			// 		</table>
			// 		";
			// 	$konten=
			// 				"<style type=\"text/css\">
			// 				.table-font-size2{
			// 					font-size:10px;
			// 				    }
			// 				</style>
			// 				<p align=\"center\" style=\"font-size:13px\"><u><b>RINGKASAN MASUK & KELUAR PASIEN </b></u></p>

			// 				<table class=\"table-font-size2 \" cellpadding=\"2\" cellspacing=\"1\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">

			// 					<tr>
			// 						<td width=\"18%\"><b>No. RM </b></td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\"><b>".strtoupper($row->no_cm)."</b></td>
			// 						<td width=\"17%\"><b>KELAS</b></td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\"> <b>".strtoupper($row->klsiri)."</b></td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\"><b>RUANGAN </b></td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\"><b>".strtoupper($row->nmruang)." </b></td>
			// 						<td width=\"17%\"><b>Tanggal masuk</b></td>
			// 						<td width=\"2%\"><b>:</b></td>
			// 						<td width=\"31%\"><b>".$hari. " ".$bulan. " ".$tahun. ", Jam ".$jam."</b></td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Asal Poli</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".$row->nm_poli."</td>
			// 						<td width=\"17%\">Dikirim Oleh</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->dikirim_oleh=='rs_lainnya'? 'Rumah Sakit ':
			// 							($row->dikirim_oleh=='bp_satkes'? 'BP / SATKES':
			// 							($row->dikirim_oleh=='dokter'? 'Dokter':
			// 							($row->dikirim_oleh=='puskesmas'? 'Puskesmas':
			// 							($row->dikirim_oleh=='instansi_lainnya'? 'Instansi':
			// 							($row->dikirim_oleh=='kasus'? 'Kasus Polisi':
			// 							($row->dikirim_oleh=='sendiri'? 'Datang Sendiri'
			// 								:' ')))))))."
			// 							".$row->dikirim_oleh_teks."</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Dokter </td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".$row->nm_dokter."</td>
			// 						<td width=\"17%\"><b>Diagnosa Awal</b></td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->nm_diagnosa)."</td>

			// 					</tr>

			// 					<tr>
			// 						<td width=\"18%\">Nama Pasien</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".$row->nama."</td>
			// 						<td width=\"17%\">Pendidikan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($row->pendidikan))."</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Tempat,Tgl Lahir</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".$row->tmpt_lahir.", ".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
			// 						<td width=\"17%\">Jenis Kelamin</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->sex=='L'? 'Laki-laki':($row->sex=='P'? 'Perempuan':'Laki-laki / Perempuan'))."</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Usia</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
			// 						<td width=\"17%\">Status Pasien</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".(($row->carabayar=='UMUM' )? 'UMUM':($row->carabayar.' - '.$row->nmkontraktor))."</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Pekerjaan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : '.................') :$row->pekerjaan)."</td>
			// 						<td width=\"17%\">Jabatan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->jabatan=='' ? '.............' :$row->jabatan)."</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Nomor Telepon</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".($row->no_hp)."</td>
			// 						".($row->nrp_sbg == 'T' ? '
			// 						<td width=\"17%\">NIP/NRP</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\"><b>'.($row->no_nrp).'</b></td>
			// 					':'')."
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Agama</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".($row->agama=='' ? 'ISLAM / PROTESTAN / KATHOLIK / HINDU / BUDHA / KONGHUCU' :$row->agama)."</td>
			// 						".($row->nrp_sbg == 'T' ? '
			// 						<td width=\"24%\">Kesatuan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"68%\">'.($row->kst_id=='' ? ($row->kesatuan_ehr) : ($row->kst_nama.' | '.$row->kst2_nama.' | '.$row->kst3_nama)).'</td>
			// 					':'')."
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Status Pernikahan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".($row->status_nikah=='K'? 'Menikah' :($row->status_nikah!='K'? 'Belum Menikah':'Menikah / Belum Menikah'))."</td>
			// 						".($row->nrp_sbg == 'T' ? '
			// 						<td width=\"24%\">Pangkat</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"68%\">'.($row->pangkat).'</td>
			// 					':'')."
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Alamat Rumah</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"30%\">".($row->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$row->alamat).' '.($row->kelurahandesa!='' ? 'KEL. '.$row->kelurahandesa:'').' '.($row->kecamatan!='' ? 'KEC. '.$row->kecamatan:'').' '.($row->kotakabupaten!='' ? ', '.$row->kotakabupaten:'').' '.($row->provinsi!='' ? ', '.$row->provinsi:'')."</td>
			// 						<td width=\"17%\">Catatan</td>
			// 						<td width=\"2%\">:</td>
			// 						<td width=\"31%\">".($row->catt)."</td>
			// 					</tr>

			// 				</table>

			// 				<style type=\"text/css\">
			// 				.table-font-size2{
			// 					font-size:10px;
			// 				    }
			// 				.table3 td{
			// 				 	height:17px;
			// 				 }
			// 				</style>

			// 				<table class=\"table-font-size2 table3\" border=\"0.5 \" >
			// 					<tr>
			// 						<td width=\"40%\"><b>Diagnosa Akhir <br></b></td>
			// 						<td width=\"30%\"><b>Tanggal Keluar</b></td>
			// 						<td width=\"30%\"><b>Jam Keluar</b></td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\"><b>Utama :</b></td>
			// 						<td width=\"50%\"><b>Komplikasi :</b></td>


			// 					</tr>
			// 					<tr>
			// 						<td width=\"100%\">Lama Dirawat : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; hari</td>


			// 					</tr>
			// 					<tr>
			// 						<td width=\"100%\">Penyebab Luar Cedera & keracunan / morfologi Neoplaspa : </td>

			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\">Infeksi Nosokomial :</td>
			// 						<td width=\"50%\">Penyebab Infeksi :</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\">Nama Opsi / Tindakan : </td>
			// 						<td width=\"50%\">Golongan Operasi :</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\">Jenis Anestesi : </td>
			// 						<td width=\"50%\">Tanggal dan No. Kode : </td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"18%\">Imunisasi yang Pernah di Dapat : </td>
			// 						<td width=\"14%\"> 1. BCG <br> 2. DPT <br> 3. Polio <br> 4. TFT</td>
			// 						<td width=\"18%\"> 5. DT <br> 6. Campak <br> 7. Hepatitis</td>
			// 						<td width=\"50%\">Pengobatan Radioterapi/KUBT :</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\">Imunisasi yang diperoleh selama dirawat: <br> </td>
			// 						<td width=\"50%\">Transfusi Darah : <br>Golongan Darah :</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"25%\">Keadaan Keluar : <br> 1. Sembuh <br> 2. Membaik <br> 3. Belum Sembuh </td>
			// 						<td width=\"25%\"> &nbsp; 	<br> 4. Wafat kurang 48 jam <br> 5. Wafat lebih 48 jam </td>
			// 						<td width=\"25%\">Cara Keluar : <br> 1.Diijinkan pulang <br> 2. Pulang Paksa <br> 3. Dirujuk Ke ........... </td>
			// 						<td width=\"25%\">&nbsp; 	<br> 4. Lari <br> 5.Pindah RS Lain</td>
			// 					</tr>
			// 					<tr>
			// 						<td width=\"50%\">Dokter yang merawat : <br><br><br></td>
			// 						<td width=\"50%\">Tanda Tangan : <br><br><br></td>
			// 					</tr>

			// 				</table>
			// 		";

			// }

			// $file_name="Ringkasan_rawatinap_$no_ipd.pdf";
			// 	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// 	tcpdf();
			// 	$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// 	$obj_pdf->SetCreator(PDF_CREATOR);
			// 	$title = "";
			// 	$obj_pdf->SetTitle($file_name);
			// 	$obj_pdf->SetHeaderData('', '', $title, '');
			// 	// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// 	// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			// 	$obj_pdf->setPrintHeader(false);
			// 	$obj_pdf->setPrintFooter(false);
			// 	$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// 	// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// 	// $obj_pdf->SetFooterMargin('5');
			// 	$obj_pdf->SetMargins('15', '10', '15');//left top right
			// 	$obj_pdf->SetAutoPageBreak(TRUE, '5');
			// 	$obj_pdf->SetFont('helvetica', '', 10);
			// 	$obj_pdf->setFontSubsetting(false);
			// 	$obj_pdf->AddPage();
			// 	ob_start();
			// 		$content = $konten_header.$konten;
			// 	ob_end_clean();
			// 	$obj_pdf->writeHTML($content, true, false, true, false, '');
			// 		$obj_pdf->Output(FCPATH.'/download/iri/riidentitas/'.$file_name, 'FI');

		} else {
			redirect('iri/ricpendaftaran', 'refresh');
		}
	}



	public function validation_pendaftaran()
	{
		$this->form_validation->set_rules('noregasal', 'No. Reg. Asal', 'required');
	}

	public function data_dokter_autocomp($poli)
	{
		$str_poli = str_replace('%20', ' ', $poli);
		$sub_poli = substr($str_poli, 11);
		$camel_poli = ucwords(strtolower($sub_poli));

		$poliklinik = 'Spesialis ' . $camel_poli;
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(5);
		$data = $this->rimpendaftaran->select_dokter_like($keyword, $poliklinik);
		foreach ($data as $row) {


			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['nm_dokter'],
				'id_dokter'				=> $row['id_dokter'],
				'nm_dokter'				=> $row['nm_dokter']
			);
		}

		echo json_encode($arr);
	}

	// added aldi
	public function data_dokter_autocompwithoutpoli()
	{
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_dokter_likewithoutpoli($keyword);
		foreach ($data as $row) {


			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['nm_dokter'] . ' - ' . $row['ket'],
				'id_dokter'			=> $row['id_dokter'],
				'nm_dokter'			=> $row['nm_dokter'],
			);
		}

		echo json_encode($arr);
	}

	public function insert_general_consent()
	{
		// var_dump($this->input->post());die();
		$data['no_register'] = $this->input->post('no_register');
		$data['no_register_lama'] = $this->input->post('no_register_lama');
		$data['no_cm'] = $this->input->post('no_cm');
		$data['formjson'] = $this->input->post('formjson');
		$login_data = $this->load->get_var("user_info");
		$data['ttd_pemeriksa'] = $login_data->ttd;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$check_available_data = $this->rimpendaftaran->get_general_consent($data['no_register'])->num_rows();
		$insert_or_update = $check_available_data ? $this->rimpendaftaran->update_general_consent($data, $data['no_register']) : $this->rimpendaftaran->insert_general_consent($data);
		echo json_encode([
			'code' => $insert_or_update == 1 ? 200 : 201,
			'no_register' => $data['no_register']
		]);

		// add pengantar disini

		// if($this->rimpendaftaran->insert_general_consent($data)){
		// 	$result['data'] = 'success';
		// 	$result['code'] = '1';
		// 	$result['no_register'] = $data['no_register'];
		// 	echo json_encode($result);
		// }else{
		// 	$result['data'] = 'error';
		// 	$result['code'] = '404';
		// 	$result['no_register'] = $data['no_register'];

		// 	echo json_encode($result);

		// }
	}

	public function update_biodata_pasien()
	{
		if ($this->rimpendaftaran->update_data_pasien($this->input->post(), $this->input->post('no_cm'))) {
			echo json_encode(array('kode' => '1', 'message' => 'success'));
		} else {
			echo json_encode(array('kode' => '2', 'message' => 'error'));
		}
	}

	public function insert_surat_persetujuan()
	{

		$data['no_register'] = $this->input->post('no_register');
		$data['no_register_lama'] = $this->input->post('no_register_lama');
		$data['no_cm'] = $this->input->post('no_cm');
		$data['no_ipd'] = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('formjson');
		$login_data = $this->load->get_var("user_info");
		$data['ttd_pemeriksa'] = $login_data->ttd;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$check_available_data = $this->rimpendaftaran->get_suratpersetujuaniri_by_noipd($data['no_ipd'])->row();

		if ($check_available_data) {
			$insert_or_update = $this->rimpendaftaran->update_surat_persetujuan_iri_by_noipd($data, $data['no_ipd']);
		} else {
			$insert_or_update = $this->rimpendaftaran->insert_surat_persetujuan($data);
		}

		echo json_encode([
			'code' => $insert_or_update == 1 ? 200 : 201,
			'no_register' => $data['no_register']
		]);
	}

	public function data_dokter_autocomp_ver2()
	{
		// $poliklinik = 'Spesialis ';
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_dokter_like_ver2($keyword);
		foreach ($data as $row) {


			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=> $row['nm_dokter'],
				'id_dokter'				=> $row['id_dokter'],
				'nm_dokter'				=> $row['nm_dokter']
			);
		}

		echo json_encode($arr);
	}

	public function cetak_gelang($no_medrec)
    {
		
            $data['data_pasien'] = $this->rimpendaftaran->get_data_pasien_for_label($no_medrec);
			// var_dump($data_pasien);die();
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [70, 30],
                'margin_top' => 2,
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'margin_header' => 0,
                'margin_footer' => 0,
                'mirrorMargins' => true
            ]);
            $html = $this->load->view('iri/survey/label_gelang', $data, true);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output();
    }
}
