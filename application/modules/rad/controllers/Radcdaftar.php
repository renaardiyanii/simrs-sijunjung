<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/irj/Rjcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');
class Radcdaftar extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('rad/radmdaftar', '', TRUE);
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
		$this->load->model('lab/labmdaftar', '', TRUE);
		$this->load->model('rad/radmkwitansi', '', TRUE);
		$this->load->model('irj/rjmpelayanan', '', TRUE);
		$this->load->model('emedrec/m_emedrec', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('file');
	}

	public function index()
	{
		$data['title'] = 'DAFTAR PASIEN RADIOLOGI Tanggal ' . date('d-m-Y');
		$date = date('Y-m-d');
		$data['radiologi'] = $this->radmdaftar->get_daftar_pasien_rad($date)->result();
		$data['kontraktor'] = $this->radmdaftar->get_kontraktor_kerjasama()->result();
		$this->load->view('rad/radvdaftarpasien', $data);
		//print_r($data); 
	}

	public function list_order()
	{
		$data['title'] = 'DAFTAR ORDER RADIOLOGI Tanggal ' . date('d-m-Y');

		//$data['radiologi']=$this->radmdaftar->get_daftar_pasien_rad()->result();
		$data['radiologi'] = $this->radmdaftar->get_data_list_order()->result();
		$data['pasien_luar'] = $this->radmdaftar->get_data_list_order_pl()->result();
		$data['kontraktor'] = $this->radmdaftar->get_kontraktor_kerjasama()->result();
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
		$this->load->view('rad/radvorder', $data);
	}

	public function by_date()
	{
		$date = $this->input->post('date');
		$data['title'] = 'DAFTAR PASIEN RADIOLOGI Tanggal ' . date('d-m-Y', strtotime($date));

		$data['radiologi'] = $this->radmdaftar->get_daftar_pasien_rad_by_date($date)->result();
		$this->load->view('rad/radvdaftarpasien', $data);
	}

	public function by_no()
	{
		$key = $this->input->post('key');
		$data['title'] = 'DAFTAR PASIEN RADIOLOGI | ' . $key;

		$data['radiologi'] = $this->radmdaftar->get_daftar_pasien_rad_by_no($key)->result();
		$this->load->view('rad/radvdaftarpasien', $data);
	}

	public function by_modality()
	{
		$key = $this->input->post('modality');
		$data['title'] = 'DAFTAR PASIEN RADIOLOGI | ' . $key;

		$data['radiologi'] = $this->radmdaftar->get_daftar_pasien_rad_by_modality($key)->result();
		$this->load->view('rad/radvdaftarpasien', $data);
	}

	public function order_by_no()
	{
		$key = $this->input->post('key');
		$data['title'] = 'DAFTAR ORDER RADIOLOGI | ' . $key;
		$data['kontraktor'] = $this->radmdaftar->get_kontraktor_kerjasama()->result();
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
		$data['radiologi'] = $this->radmdaftar->get_list_order_rad_by_no($key)->result();
		$data['pasien_luar'] = $this->radmdaftar->get_list_order_rad_by_no_pl($key)->result();
		$this->load->view('rad/radvorder', $data);
	}

	public function order_by_date()
	{
		$date = $this->input->post('date');
		$data['title'] = 'DAFTAR ORDER RADIOLOGI Tanggal ' . date('d-m-Y', strtotime($date));
		$data['kontraktor'] = $this->radmdaftar->get_kontraktor_kerjasama()->result();
		$data['kontraktor_bpjs'] = $this->radmdaftar->get_kontraktor_bpjs()->result();
		$data['radiologi'] = $this->radmdaftar->get_list_order_rad_by_date($date)->result();
		$data['pasien_luar'] = $this->radmdaftar->get_list_order_rad_by_date_pl($date)->result();
		$this->load->view('rad/radvorder', $data);
	}

	public function list_tindakan_order($no_register = '', $pelayan = '')
	{
		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan RADIOLOGI | <a href="#" onclick="return openUrl(`' . site_url('rad/radcdaftar/list_order') . '`)" id="tombolkembali">Kembali</a>';
		$data['radiografer'] = $this->radmdaftar->get_radiografer()->result();
		$data['radio'] = 'RAD';
		$data['no_register'] = $no_register;
		$data['tanggal'] = 'list';
		if (substr($no_register, 0, 2) == "PL") {
			$rad = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row()->rad;
			//$kelas = 'NK';
			//$data['list_tindakan'] = $this->radmdaftar->get_tindakan_bius($kelas)->result();
			//if ($rad == '1') {
			$data_valid = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row();
			if ($data_valid = null) {
				$data['nama'] = '';
				$data['alamat'] = '';
				$data['dokter_rujuk'] = '';
				$data['no_medrec'] = '-';
				$data['no_cm'] = '-';
				$data['kelas_pasien'] = '';
				$data['tgl_kun'] = '';
				$data['tglkun'] = '';
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = '';
				$data['nmkontraktor'] = '';
				$data['tgl_periksa'] = '';
				$data['cara_bayar'] = '';
				$data['idpoli'] = '';
				$data['rad'] = '';
				$data['nama_diagnosa'] = '';
				$data['rs_perujuk'] = '';
			} else {
				$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
				foreach ($data['data_pasien_pemeriksaan'] as $row) {
					$data['nama'] = $row->nama;
					$data['alamat'] = $row->alamat;
					$data['dokter_rujuk'] = $row->dokter;
					$data['no_medrec'] = $row->no_cm;
					$data['idpoli'] = '';
					$data['no_cm'] = '-';
					$data['kelas_pasien'] = 'NK';
					$data['tgl_kun'] = $row->tgl_kunjungan;
					$data['idrg'] = '-';
					$data['bed'] = '-';
					$data['cara_bayar'] = $row->cara_bayar;
					$data['nmkontraktor'] = '';
					$data['tgl_periksa'] = $row->tgl_kunjungan;
					$data['cara_bayar'] = $row->cara_bayar;
					$data['rad'] = $row->rad;
					$data['jenkel'] = $row->jk;
					$data['tgl_lahir'] = $row->tgl_lahir;
					$data['nama_diagnosa'] = $row->diagnosa;
					$data['rs_perujuk'] = $row->rs_perujuk;
					$data['nmkontraktor'] = $row->nmkontraktor;
				}
			}
			// }else{
			// 	redirect("rad/radcdaftar");
			// }


		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_pemeriksaan($no_register)->result();
			//$kelas = $data['data_pasien_pemeriksaan']->kelas;
			//$data['list_tindakan'] = $this->radmdaftar->get_tindakan_bius($kelas)->result();

			//print_r($data['data_pasien_pemeriksaan']);die;
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_periksa'] = $row->jadwal_rad;
				$data['idpoli'] = '';
				$data['jenkel'] = $row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			// var_dump($data['cara_bayar']);
			if (substr($no_register, 0, 2) == "RJ") {
				//$tgl_tindak['tgl_tindak_perawat'] = date("Y-m-d H:i:s");
				//$this->radmdaftar->insert_tgl_tindak_perawat($tgl_tindak, $no_register);
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				if ($data['cara_bayar'] != null || $data['cara_bayar'] != '') {
					if ($data['cara_bayar'] == 'KERJASAMA') {
						$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row();
						$data['nmkontraktor'] = isset($kontraktor->nmkontraktor);
					} else {
						$data['nmkontraktor'] = '';
						// $data['bed']='Rawat Jalan';
						//$data['kelas_pasien']='II';

						$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
						$data['rad'] = $data['data_pasien_daftar_ulang']->status_rad;
						$data['idpoli'] = $data['data_pasien_daftar_ulang']->id_poli;

						// print_r($data['data_pasien_daftar_ulang']);die();
						$diagnosa = $this->radmdaftar->get_data_diagnosa_rj($no_register)->result();
						foreach ($diagnosa as $row) {
							$data['diagnosa'] = $row->diagnosa;
							$data['id_diagnosa'] = $row->id_diagnosa;
						}
					}
				} else {
					redirect("rad/radcdaftar");
				}
			} else if (substr($no_register, 0, 2) == "RI") {
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;

				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$nm_diagnosa = $this->radmdaftar->get_nama_diagnosa($id_icd)->row();

					if ($nm_diagnosa == null) {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
					} else {
						$data['nama_diagnosa'] = $nm_diagnosa->nm_diagnosa;
					}
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				$data['idpoli'] = '';
				if ($data['cara_bayar'] != null) {
					if ($data['cara_bayar'] == 'KERJASAMA') {
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor'] = $kontraktor;
					} else $data['nmkontraktor'] = '';
					$diagnosa = $this->radmdaftar->get_data_diagnosa_ri($no_register)->result();
					foreach ($diagnosa as $row) {
						$data['diagnosa'] = $row->diagnosa;
						$data['id_diagnosa'] = $row->id_diagnosa;
					}
					$data['rad'] = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->status_rad;
				} else {
					redirect("rad/radcdaftar");
				}
			}
		}

		$data['dokter_kirim'] = $this->labmdaftar->get_dokter_kirim($no_register)->row();

		$data['data_jenis_rad'] = $this->radmdaftar->get_jenis_rad()->result();
		//$data['data_pemeriksaan']=$this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		//$kelas = $data['data_pemeriksaan']
		$data['obat_resep_rad'] = $this->radmdaftar->get_data_obat_resep_rad($no_register)->row();


		$data['data_pemeriksaan_pacsman'] = $this->radmdaftar->get_data_pemeriksaan_by_reg_PACSMAN($no_register)->result();

		//add asesmen dokter
		// $rad_rows =$this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->num_rows();

		// foreach ($data['data_pemeriksaan'] as $key) {

		// 		$rad_jenis_tindakan[] = $key->jenis_tindakan;

		// }
		// $tidak_ada_rad[] = array("Tidak Ada Pemeriksaan Radiologi");

		// $tampung_rad= array();
		// if ($rad_rows == 0) {
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.$tidak_ada_rad[$i];
		// 	}
		// }else{
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.'Hasil Radiologi :'.$rad_jenis_tindakan[$i].'<br>';
		// 	}
		// }
		// $gabung_rad = implode($tampung_rad);

		// $datafisik['pem_penunjang'] = $gabung_rad;
		// $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		// if ($data_fisik==FALSE) {
		// 	$datafisik['no_register'] = $no_register;
		// 	$this->radmdaftar->insert_data_fisik_live($datafisik);
		// 	//INSERT
		// } else {
		// 	$this->radmdaftar->update_data_fisik_live($no_register, $datafisik);
		// 	// UPDATE
		// }

		$get_no_lab = $this->radmdaftar->get_no_lab_last($no_register)->row();
		if ($get_no_lab != null) {
			if ($get_no_lab->no_lab != 0) {
				$data['no_lab'] = $get_no_lab->no_lab;
			} else {
				$data['no_lab'] = null;
			}
		} else {
			$data['no_lab'] = null;
		}

		//end
		$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		$data['tindakan'] = $this->radmdaftar->getdata_tindakan_pasien()->result();
		$data['dokter_anestesi'] = $this->radmdaftar->get_dokter_anestesi()->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->radmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$data['obat_rad'] = $this->radmdaftar->get_obat_rad()->row();

		$data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
		$data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
		$data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
		$data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();
		$this->load->view('rad/radvlistorder', $data);
	}

	public function pemeriksaan_rad($no_register = '', $pelayan = '')
	{
		// var_dump($pelayan);die();
		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan RADIOLOGI | <a href="#" onclick="return openUrl(`' . site_url('rad/radcdaftar') . '`)" id="tombolkembali">Kembali</a>';
		$data['radiografer'] = $this->radmdaftar->get_radiografer()->result();
		$data['no_register'] = $no_register;
		$data['tanggal'] = 'list';
		if (substr($no_register, 0, 2) == "PL") {
			// $tgl_tindak['tgl_tindak_perawat'] = date("Y-m-d H:i:s");
			// $this->radmdaftar->insert_tgl_tindak_perawat($tgl_tindak, $no_register);
			$rad = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row()->rad;
			//if ($rad == '1') {
			$data_valid = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row();
			if ($data_valid = null) {
				$data['nama'] = '';
				$data['alamat'] = '';
				$data['dokter_rujuk'] = '';
				$data['no_medrec'] = '-';
				$data['no_cm'] = '-';
				$data['kelas_pasien'] = '';
				$data['tgl_kun'] = '';
				$data['tglkun'] = '';
				$data['idrg'] = '-';
				$data['bed'] = '-';
				$data['cara_bayar'] = '';
				$data['nmkontraktor'] = '';
				$data['tgl_periksa'] = '';
				$data['cara_bayar'] = '';
				$data['idpoli'] = '';
				$data['rad'] = '';
				$data['nama_diagnosa'] = '';
				$data['rs_perujuk'] = '';
			} else {
				$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
				foreach ($data['data_pasien_pemeriksaan'] as $row) {
					$data['nama'] = $row->nama;
					$data['alamat'] = $row->alamat;
					$data['dokter_rujuk'] = $row->dokter;
					$data['no_medrec'] = $row->no_cm;
					$data['idpoli'] = '';
					$data['no_cm'] = '-';
					$data['kelas_pasien'] = 'NK';
					$data['tgl_kun'] = $row->tgl_kunjungan;
					$data['idrg'] = '-';
					$data['bed'] = '-';
					$data['cara_bayar'] = $row->cara_bayar;
					$data['nmkontraktor'] = '';
					$data['tgl_periksa'] = $row->tgl_kunjungan;
					$data['cara_bayar'] = $row->cara_bayar;
					$data['rad'] = $row->rad;
					$data['jenkel'] = $row->jk;
					$data['tgl_lahir'] = $row->tgl_lahir;
					$data['nama_diagnosa'] = $row->diagnosa;
					$data['rs_perujuk'] = $row->rs_perujuk;
					$data['nmkontraktor'] = $row->nmkontraktor;
				}
			}
			// }else{
			// 	redirect("rad/radcdaftar");
			// }


		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_pemeriksaan($no_register)->result();


			//print_r($data['data_pasien_pemeriksaan']);die;
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_periksa'] = $row->jadwal_rad;
				$data['idpoli'] = '';
				$data['jenkel'] = $row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			// var_dump($data['cara_bayar']);
			if (substr($no_register, 0, 2) == "RJ") {
				// $tgl_tindak['tgl_tindak_perawat'] = date("Y-m-d H:i:s");
				// $this->radmdaftar->insert_tgl_tindak_perawat($tgl_tindak, $no_register);
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				if ($data['cara_bayar'] != null || $data['cara_bayar'] != '') {
					if ($data['cara_bayar'] == 'KERJASAMA') {
						$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row();
						$data['nmkontraktor'] = isset($kontraktor->nmkontraktor);
					} else {
						$data['nmkontraktor'] = '';
						// $data['bed']='Rawat Jalan';
						//$data['kelas_pasien']='II';

						$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
						$data['rad'] = $data['data_pasien_daftar_ulang']->status_rad;
						$data['idpoli'] = $data['data_pasien_daftar_ulang']->id_poli;

						// print_r($data['data_pasien_daftar_ulang']);die();
						$diagnosa = $this->radmdaftar->get_data_diagnosa_rj($no_register)->result();
						foreach ($diagnosa as $row) {
							$data['diagnosa'] = $row->diagnosa;
							$data['id_diagnosa'] = $row->id_diagnosa;
						}
					}
				} else {
					redirect("rad/radcdaftar");
				}
			} else if (substr($no_register, 0, 2) == "RI") {
				// $tgl_tindak['tgl_tindak_perawat'] = date("Y-m-d H:i:s");
				// $this->radmdaftar->insert_tgl_tindak_perawat($tgl_tindak, $no_register);
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;

				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$nm_diagnosa = $this->radmdaftar->get_nama_diagnosa($id_icd)->row();

					if ($nm_diagnosa == null) {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
					} else {
						$data['nama_diagnosa'] = $nm_diagnosa->nm_diagnosa;
					}
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				$data['idpoli'] = '';
				if ($data['cara_bayar'] != null) {
					if ($data['cara_bayar'] == 'KERJASAMA') {
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor'] = $kontraktor;
					} else $data['nmkontraktor'] = '';
					$diagnosa = $this->radmdaftar->get_data_diagnosa_ri($no_register)->result();
					foreach ($diagnosa as $row) {
						$data['diagnosa'] = $row->diagnosa;
						$data['id_diagnosa'] = $row->id_diagnosa;
					}
					$data['rad'] = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->status_rad;
				} else {
					redirect("rad/radcdaftar");
				}
			}
		}

		$data['dokter_kirim'] = $this->labmdaftar->get_dokter_kirim($no_register)->row();

		$data['data_jenis_rad'] = $this->radmdaftar->get_jenis_rad()->result();
		//$data['data_pemeriksaan']=$this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		// $data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_id_pemeriksaan($id_pemeriksaan)->result();
		//$data['norad'] = $data['data_pemeriksaan'][0]->no_rad;
		// $data['obat_resep_rad'] = $this->radmdaftar->get_data_obat_resep_rad($no_register)->row();


		$data['data_pemeriksaan_pacsman'] = $this->radmdaftar->get_data_pemeriksaan_by_reg_PACSMAN_new($no_register)->result();
		// var_dump($data['data_pemeriksaan_pacsman']); die();
		//add asesmen dokter
		// $rad_rows =$this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->num_rows();

		// foreach ($data['data_pemeriksaan'] as $key) {

		// 		$rad_jenis_tindakan[] = $key->jenis_tindakan;

		// }
		// $tidak_ada_rad[] = array("Tidak Ada Pemeriksaan Radiologi");

		// $tampung_rad= array();
		// if ($rad_rows == 0) {
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.$tidak_ada_rad[$i];
		// 	}
		// }else{
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.'Hasil Radiologi :'.$rad_jenis_tindakan[$i].'<br>';
		// 	}
		// }
		// $gabung_rad = implode($tampung_rad);

		// $datafisik['pem_penunjang'] = $gabung_rad;
		// $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		// if ($data_fisik==FALSE) {
		// 	$datafisik['no_register'] = $no_register;
		// 	$this->radmdaftar->insert_data_fisik_live($datafisik);
		// 	//INSERT
		// } else {
		// 	$this->radmdaftar->update_data_fisik_live($no_register, $datafisik);
		// 	// UPDATE
		// }



		//end
		$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		$data['tindakan'] = $this->radmdaftar->getdata_tindakan_pasien_new()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->radmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$data['obat_rad'] = $this->radmdaftar->get_obat_rad()->row();

		$data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
		$data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
		$data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
		$data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();

		$data['tindakan_request']=$this->radmdaftar->getdata_tindakan_request()->result();
		$data['tindakan_request_kel']=$this->radmdaftar->getdata_tindakan_request_kel()->result();
		$this->load->view('rad/radvpemeriksaan', $data);
	}

	public function pelayanan_rad($no_register = '', $pelayan = '')
	{
		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan RADIOLOGI';
		$data['tanggal'] = 'list';
		$data['no_register'] = $no_register;

		if (substr($no_register, 0, 2) == "PL") {
			$rad = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row()->rad;
			if ($rad == '1') {
				$data_valid = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->row();
				if ($data_valid = null) {
					$data['nama'] = '';
					$data['alamat'] = '';
					$data['dokter_rujuk'] = '';
					$data['no_medrec'] = '-';
					$data['no_cm'] = '-';
					$data['kelas_pasien'] = '';
					$data['tgl_kun'] = '';
					$data['idrg'] = '-';
					$data['bed'] = '-';
					$data['cara_bayar'] = '';
					$data['nmkontraktor'] = '';
					$data['tgl_periksa'] = '';
					$data['cara_bayar'] = '';
					$data['idpoli'] = '';
					$data['rad'] = '';
					$data['nama_diagnosa'] = '';
					$data['rs_perujuk'] = '';
				} else {
					$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
					foreach ($data['data_pasien_pemeriksaan'] as $row) {
						$data['nama'] = $row->nama;
						$data['alamat'] = $row->alamat;
						$data['dokter_rujuk'] = $row->dokter;
						$data['no_medrec'] = $row->no_cm;
						$data['idpoli'] = '';
						$data['no_cm'] = '-';
						$data['kelas_pasien'] = 'NK';
						$data['tgl_kun'] = $row->tgl_kunjungan;
						$data['idrg'] = '-';
						$data['bed'] = '-';
						$data['cara_bayar'] = $row->cara_bayar;
						$data['nmkontraktor'] = '';
						$data['tgl_periksa'] = $row->tgl_kunjungan;
						$data['cara_bayar'] = $row->cara_bayar;
						$data['rad'] = $row->rad;
						$data['jenkel'] = $row->jk;
						$data['tgl_lahir'] = $row->tgl_lahir;
						$data['nama_diagnosa'] = $row->diagnosa;
						$data['rs_perujuk'] = $row->rs_perujuk;
						$data['nmkontraktor'] = $row->nmkontraktor;
					}
				}
			} else {
				redirect("rad/radcdaftar");
			}
		} else {
			$data['data_pasien_pemeriksaan'] = $this->radmdaftar->get_data_pasien_pemeriksaan($no_register)->result();


			//print_r($data['data_pasien_pemeriksaan']);die;
			foreach ($data['data_pasien_pemeriksaan'] as $row) {
				$data['nama'] = $row->nama;
				$data['no_cm'] = $row->no_cm;
				$data['no_medrec'] = $row->no_medrec;
				$data['kelas_pasien'] = $row->kelas;
				$data['tgl_kun'] = $row->tgl_kunjungan;
				$data['idrg'] = $row->idrg;
				$data['bed'] = $row->bed;
				$data['cara_bayar'] = $row->cara_bayar;
				$data['tgl_periksa'] = $row->jadwal_rad;
				$data['idpoli'] = '';
				$data['jenkel'] = $row->sex;
				$data['tgl_lahir'] = $row->tgl_lahir;
				if ($row->foto == NULL) {
					$data['foto'] = 'unknown.png';
				} else {
					$data['foto'] = $row->foto;
				}
			}
			// var_dump($data['cara_bayar']);
			if (substr($no_register, 0, 2) == "RJ") {
				//$tgl_tindak['tgl_tindak_perawat'] = date("Y-m-d H:i:s");
				//$this->radmdaftar->insert_tgl_tindak_perawat($tgl_tindak, $no_register);
				$diag = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->row();
				if ($diag != null) {
					$data['nama_diagnosa'] = $this->radmdaftar->get_diagnosa_by_noreg_rj($no_register)->result();
				} else {
					$data['nama_diagnosa'] = array();
				}
				if ($data['cara_bayar'] != null || $data['cara_bayar'] != '') {
					if ($data['cara_bayar'] == 'KERJASAMA' or $data['cara_bayar'] == 'BPJS') {
						$kontraktor = $this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row();
						$data['nmkontraktor'] = isset($kontraktor->nmkontraktor) ? $kontraktor->nmkontraktor : '';
					} else {
						$data['nmkontraktor'] = '';
						// $data['bed']='Rawat Jalan';
						//$data['kelas_pasien']='II';

						$data['data_pasien_daftar_ulang'] = $this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
						$data['rad'] = $data['data_pasien_daftar_ulang']->status_rad;
						$data['idpoli'] = $data['data_pasien_daftar_ulang']->id_poli;

						// print_r($data['data_pasien_daftar_ulang']);die();
						$diagnosa = $this->radmdaftar->get_data_diagnosa_rj($no_register)->result();
						foreach ($diagnosa as $row) {
							$data['diagnosa'] = $row->diagnosa;
							$data['id_diagnosa'] = $row->id_diagnosa;
						}
					}
				} else {
					redirect("rad/radcdaftar");
				}
			} else if (substr($no_register, 0, 2) == "RI") {
				$diag = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;

				if ($diag != null) {
					$id_icd = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->diagmasuk;
					$nm_diagnosa = $this->radmdaftar->get_nama_diagnosa($id_icd)->row();

					if ($nm_diagnosa == null) {
						$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
					} else {
						$data['nama_diagnosa'] = $nm_diagnosa->nm_diagnosa;
					}
				} else {
					$data['nama_diagnosa'] = 'TIDAK ADA DIAGNOSA';
				}
				$data['idpoli'] = '';
				if ($data['cara_bayar'] != null) {
					if ($data['cara_bayar'] == 'KERJASAMA') {
						// $kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
						$kontraktor = $this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
						$data['nmkontraktor'] = $kontraktor;
					} else $data['nmkontraktor'] = '';
					$diagnosa = $this->radmdaftar->get_data_diagnosa_ri($no_register)->result();
					foreach ($diagnosa as $row) {
						$data['diagnosa'] = $row->diagnosa;
						$data['id_diagnosa'] = $row->id_diagnosa;
					}
					$data['rad'] = $this->radmdaftar->get_data_pasien_iri($no_register)->row()->status_rad;
				} else {
					redirect("rad/radcdaftar");
				}
			}
		}

		$data['dokter_kirim'] = $this->labmdaftar->get_dokter_kirim($no_register)->row();

		$data['data_jenis_rad'] = $this->radmdaftar->get_jenis_rad()->result();
		$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->result();
		$data['obat_resep_rad'] = $this->radmdaftar->get_data_obat_resep_rad($no_register)->row();


		$data['data_pemeriksaan_pacsman'] = $this->radmdaftar->get_data_pemeriksaan_by_reg_PACSMAN($no_register)->result();

		//add asesmen dokter
		// $rad_rows =$this->radmdaftar->get_data_pemeriksaan_by_reg($no_register)->num_rows();

		// foreach ($data['data_pemeriksaan'] as $key) {

		// 		$rad_jenis_tindakan[] = $key->jenis_tindakan;

		// }
		// $tidak_ada_rad[] = array("Tidak Ada Pemeriksaan Radiologi");

		// $tampung_rad= array();
		// if ($rad_rows == 0) {
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.$tidak_ada_rad[$i];
		// 	}
		// }else{
		// 	for ($i=0; $i < $rad_rows ; $i++) { 
		// 		$tampung_rad[] = '<br>'.'Hasil Radiologi :'.$rad_jenis_tindakan[$i].'<br>';
		// 	}
		// }
		// $gabung_rad = implode($tampung_rad);

		// $datafisik['pem_penunjang'] = $gabung_rad;
		// $data_fisik=$this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		// if ($data_fisik==FALSE) {
		// 	$datafisik['no_register'] = $no_register;
		// 	$this->radmdaftar->insert_data_fisik_live($datafisik);
		// 	//INSERT
		// } else {
		// 	$this->radmdaftar->update_data_fisik_live($no_register, $datafisik);
		// 	// UPDATE
		// }



		//end
		$data['dokter'] = $this->radmdaftar->getdata_dokter()->result();
		$data['tindakan'] = $this->radmdaftar->getdata_tindakan_pasien_new()->result();

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->radmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$data['obat_rad'] = $this->radmdaftar->get_obat_rad()->row();

		$data['satuan_signa'] = $this->Frmmdaftar->get_signa()->result();
		$data['qtx'] = $this->Frmmdaftar->get_qtx()->result();
		$data['satuan'] = $this->Frmmdaftar->get_satuan()->result();
		$data['cara_pakai'] = $this->Frmmdaftar->get_cara_pakai()->result();
		$get_id_ok = $this->labmdaftar->get_id_ok($no_register)->row();
		$data['id_ok'] = isset($get_id_ok->idoperasi_header) ? $get_id_ok->idoperasi_header : '';


		$data['tindakan_request']=$this->radmdaftar->getdata_tindakan_request()->result();
		$data['tindakan_request_kel']=$this->radmdaftar->getdata_tindakan_request_kel()->result();

		$this->load->view('rad/radvpemeriksaan', $data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan = $this->input->post('id_tindakan');
		$kelas = $this->input->post('kelas');
		$biaya = $this->radmdaftar->get_biaya_tindakan_new($id_tindakan)->row()->tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['no_register'] = $this->input->post('no_register');
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['id_tindakan'] = $this->input->post('idtindakan');
		$data['kelas'] = $this->input->post('kelas_pasien');
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunj');
		$data['jadwal'] = $this->input->post('tgl_kunj');
		$data_tindakan = $this->radmdaftar->getjenis_tindakan_new($data['id_tindakan'])->result();
		foreach ($data_tindakan as $row) {
			$data['jenis_tindakan'] = $row->nmtindakan;
		}
		$data['qty'] = 1;
		// $data['id_dokter'] = $this->input->post('id_dokter');
		// $data_dokter = $this->radmdaftar->getnama_dokter($data['id_dokter'])->result();
		// foreach ($data_dokter as $row) {
		// 	$data['nm_dokter'] = $row->nm_dokter;
		// }
		$data['biaya_rad'] = $this->input->post('biaya_rad_hide');
		$data['vtot'] = $this->input->post('biaya_rad_hide');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['no_rad'] = $this->input->post('no_rad');
		$data['xinput'] = $this->input->post('xuser');

		/*
		if($data['no_rad']!=''){
		} else {
			$this->radmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_rad']=$this->radmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_rad;
		}*/
		$no_register = $this->input->post('no_register');
		$cek_pasien_apa = substr($no_register, 0, 2);
		if ($cek_pasien_apa == 'RI') {
			$cek_radiologi = $this->radmdaftar->cek_radiologi($no_register)->row();
		} else {
			$cek_radiologi = $this->radmdaftar->cek_radiologirj($no_register)->row();
		}


		if ($cek_radiologi == false) {
			$datafisik['pemeriksaan_penunjang_dokter'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)' . ' <br>';
			$datafisik['no_register'] = $no_register;
			$this->radmdaftar->insert_data_soap($datafisik);
		} else {
			$id = $cek_radiologi->id;
			$datafisik['pemeriksaan_penunjang_dokter'] = $cek_radiologi->pemeriksaan_penunjang_dokter . '<br>-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
			$this->radmdaftar->update_data_soap($datafisik, $id);
		}


		// INSERT TO PENGKAJIAN MEDIS SJJ

		// $cek_pengkajian_medis = $this->rjmpelayanan->cek_pengkajian_medis($no_register)->row();
		// //  var_dump($cek_pengkajian_medis);die();
		// if ($cek_pengkajian_medis == false) {
		// 	$dat_medis['pemeriksaan_penunjang'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
		// 	$dat_medis['no_register'] = $no_register;
		// 	$this->rjmpelayanan->insert_pengkajian_medis_rj($dat_medis);
		// } else {
		// 	$id = $cek_pengkajian_medis->id;
		// 	$dat_medis['pemeriksaan_penunjang'] = $cek_pengkajian_medis->pemeriksaan_penunjang . ',' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
		// 	$this->rjmpelayanan->update_pengkajian_medis_rj_for_penunjang($dat_medis, $id);
		// }

		// END

		$this->radmdaftar->insert_pemeriksaan($data);

		// redirect('rad/radcdaftar/pemeriksaan_rad/'.$data['no_register']);
		// print_r($data);
		echo json_encode(array("status" => TRUE));
	}

	public function save_pemeriksaan_radiografer()
	{
		$no_register = $this->input->post('no_register');
		//validasi jika tidak memilih dokter
		// $validasi_dokter = $this->input->post('id_dokter');
		// if($validasi_dokter == null){
		// 	echo json_encode(array("status" => FALSE));
		// }else{

		if (isset($_POST['myCheckboxes'])) {

			for ($i = 0; $i < count($_POST['myCheckboxes']); $i++) {
				$data['no_register'] = $this->input->post('no_register');
				$data['komen'] = $this->input->post('komen');
				$data['no_medrec'] = $this->input->post('no_medrec');
				$data['jadwal'] = date("Y-m-d H:i:s");
				// var_dump($this->input->post('no_medrec'));
				// die();
				$data['id_tindakan'] = $this->input->post('myCheckboxes[' . $i . ']');
				$data['kelas'] = $this->input->post('kelas_pasien');

				// if($this->input->post('tgl_periksa')!=''){
				// $data['tgl_kunjungan']=date('Y-m-d H:i:s');
				// }else 
				// $data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan = $this->radmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach ($data_tindakan as $row) {
					$data['jenis_tindakan'] = $row->nmtindakan;
					$data['modality'] = $row->modality;
				}
				$data['qty'] = '1';
				// $data['id_dokter']=$this->input->post('id_dokter');
				// $data_dokter=$this->radmdaftar->getnama_dokter($data['id_dokter'])->result();
				// foreach($data_dokter as $row){
				// 	$data['nm_dokter']=$row->nm_dokter;
				// }
				if ($this->input->post('cara_bayar') == 'KERJASAMA') {
					if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL) {
						$data['biaya_rad'] = 0;
					} else {
						$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
					}
				} else {
					$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				}
				$data['vtot'] = intval($data['biaya_rad']);
				$data['idrg'] = $this->input->post('idrg');
				$data['bed'] = $this->input->post('bed');
				$data['cara_bayar'] = $this->input->post('cara_bayar');
				// $data['xinput']=$this->input->post('xuser');
				$data['xinput'] = $this->input->post('xuserid');
				$data['no_rad'] = $this->input->post('norad');
				$data['nmkontraktor'] = $this->input->post('nmkontraktor');
				$data['rs_perujuk'] = $this->input->post('rs_perujuk');
				$no_register = $this->input->post('no_register');

				$cek_pasien_apa = substr($no_register, 0, 2);
				if ($cek_pasien_apa == 'RI') {
					$cek_radiologi = $this->radmdaftar->cek_radiologi($no_register)->row();
				} else {
					$cek_radiologi = $this->radmdaftar->cek_radiologirj($no_register)->row();
				}


				if ($cek_radiologi == false) {
					$datafisik['pemeriksaan_penunjang_dokter'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)' . ' <br>';
					$datafisik['no_register'] = $no_register;
					$this->radmdaftar->insert_data_soap($datafisik);
				} else {
					$id = $cek_radiologi->id;
					$datafisik['pemeriksaan_penunjang_dokter'] = $cek_radiologi->pemeriksaan_penunjang_dokter . '<br>-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
					$this->radmdaftar->update_data_soap($datafisik, $id);
				}

				$this->radmdaftar->insert_pemeriksaan_radiografer($data);
			}

			echo json_encode(array("status" => TRUE));
		}

		$getvtotrad = $this->radmdaftar->get_vtot_rad($no_register)->row();
		$vtot = intval($getvtotrad->vtot_rad);
		// }	
		if (substr($no_register, 0, 2) == 'RI') {
			$jadwal['jadwal_rad'] = date("Y-m-d H:i:s");
			$jadwal['vtot_rad'] = $vtot;
			$this->radmdaftar->update_pemeriksaan_radiografer_iri($no_register, $jadwal);
			//echo json_encode(array("status" => TRUE));
		} else if (substr($no_register, 0, 2) == "RJ") {
			$jadwal['jadwal_rad'] = date("Y-m-d H:i:s");
			$jadwal['vtot_rad'] = $vtot;
			$this->radmdaftar->update_pemeriksaan_radiografer_irj($no_register, $jadwal);
			//echo json_encode(array("status" => TRUE));
		}
	}

	public function save_pemeriksaan()
	{
		//print_r($cek_radiologi);(die);
		// print_r($_POST['myCheckboxes']);die();
		$no_register = $this->input->post('no_register');
		//validasi jika tidak memilih dokter
		// $validasi_dokter = $this->input->post('id_dokter');
		// if($validasi_dokter == null){
		// 	echo json_encode(array("status" => FALSE));
		// }else{

		if (isset($_POST['myCheckboxes'])) {

			for ($i = 0; $i < count($_POST['myCheckboxes']); $i++) {
				$data['no_register'] = $this->input->post('no_register');
				$data['komen'] = $this->input->post('komen');
				$data['no_medrec'] = $this->input->post('no_medrec');
				$data['jadwal'] = date("Y-m-d H:i:s");
				// var_dump($this->input->post());
				// die();
				// $data['id_tindakan'] = $this->input->post('myCheckboxes[' . $i . ']');
				$data['kelas'] = $this->input->post('kelas_pasien');
				$data['kelas'] = ($data['kelas'] == 'EKSEKUTIF' ? 'VVIP' : $data['kelas']);
			
				// $data_tindakan = $this->radmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				// foreach ($data_tindakan as $row) {
				// 	$data['jenis_tindakan'] = $row->nmtindakan;
				// 	$data['modality'] = $row->modality;
				// }

				$data['jenis_tindakan'] = $this->input->post('myCheckboxes[' . $i . ']');
				$data['id_tindakan'] = 0;


				$data['qty'] = '1';
				if (substr($data['no_register'], 0, 2) == 'RI') {
					$titip = $this->radmdaftar->get_data_titip_iri($data['no_register'])->row();
				}

				if (substr($data['no_register'], 0, 2) == 'RI') {
					if ($titip->titip == NULL) {
						if ($this->input->post('cara_bayar') == 'KERJASAMA') {
							if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL) {
								$data['biaya_rad'] = 0;
							} else {
								$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
							}
						} else if ($this->input->post('cara_bayar') == 'BPJS') {
							// if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL) {
							// 	$data['biaya_rad'] = 0;
							// } else {
							// 	$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
							// }
							$data['biaya_rad'] = 0;
						} else {
							// $data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
							$data['biaya_rad'] = 0;
						}
					} else {
						if ($this->input->post('cara_bayar') == 'KERJASAMA') {
							if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks == NULL) {
								$data['biaya_rad'] = 0;
							} else {
								$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_iks;
							}
						} else if ($this->input->post('cara_bayar') == 'BPJS') {
							// if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs == NULL) {
							// 	$data['biaya_rad'] = 0;
							// } else {
							// 	$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->tarif_bpjs;
							// }
							$data['biaya_rad'] = 0;
						} else {
							// $data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $titip->jatahklsiri)->row()->total_tarif;
							$data['biaya_rad'] = 0;
						}
					}
				} else {
					if ($this->input->post('cara_bayar') == 'KERJASAMA') {
						if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks == NULL) {
							$data['biaya_rad'] = 0;
						} else {
							$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_iks;
						}
					} else if ($this->input->post('cara_bayar') == 'BPJS') {
						// if ($this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs == NULL) {
						// 	$data['biaya_rad'] = 0;
						// } else {
						// 	// $data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->tarif_bpjs;
						// 	$data['biaya_rad'] = 0;
						// }
						$data['biaya_rad'] = 0;
					} else {
						$data['biaya_rad'] = 0;
						// $data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
					}
				}
				$data['vtot'] = intval($data['biaya_rad']);
				$data['idrg'] = $this->input->post('idrg');
				$data['bed'] = $this->input->post('bed');
				$data['cara_bayar'] = $this->input->post('cara_bayar');
				// $data['xinput']=$this->input->post('xuser');
				$data['xinput'] = $this->input->post('xuserid');
				$data['nmkontraktor'] = $this->input->post('nmkontraktor');
				$data['rs_perujuk'] = $this->input->post('rs_perujuk');
				$no_register = $this->input->post('no_register');

				$cek_pasien_apa = substr($no_register, 0, 2);
				if ($cek_pasien_apa == 'RI') {
					$cek_radiologi = $this->radmdaftar->cek_radiologi($no_register)->row();
				} else {
					$cek_radiologi = $this->radmdaftar->cek_radiologirj($no_register)->row();
				}


				if ($cek_radiologi == false) {
					$datafisik['pemeriksaan_penunjang_dokter'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)' . ' <br>';
					$datafisik['no_register'] = $no_register;
					$this->radmdaftar->insert_data_soap($datafisik);
				} else {
					$id = $cek_radiologi->id;
					$datafisik['pemeriksaan_penunjang_dokter'] = $cek_radiologi->pemeriksaan_penunjang_dokter . '<br>-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
					$this->radmdaftar->update_data_soap($datafisik, $id);
				}


				// INSERT TO PENGKAJIAN MEDIS SJJ

				$cek_pengkajian_medis = $this->rjmpelayanan->cek_pengkajian_medis($no_register)->row();
				//  var_dump($cek_pengkajian_medis);die();
				if ($cek_pengkajian_medis == false) {
					$dat_medis['pemeriksaan_penunjang'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
					$dat_medis['no_register'] = $no_register;
					$this->rjmpelayanan->insert_pengkajian_medis_rj($dat_medis);
				} else {
					$id = $cek_pengkajian_medis->id;
					$dat_medis['pemeriksaan_penunjang'] = $cek_pengkajian_medis->pemeriksaan_penunjang . ',' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
					$this->rjmpelayanan->update_pengkajian_medis_rj_for_penunjang($dat_medis, $id);
				}

				// END

				$this->radmdaftar->insert_pemeriksaan($data);
			}

			echo json_encode(array("status" => TRUE));
		}
		// }	
		if (substr($no_register, 0, 2) == 'RI') {
			$jadwal['jadwal_rad'] = date("Y-m-d H:i:s");
			$this->radmdaftar->insert_jadwal_rad_iri($no_register, $jadwal);
			//echo json_encode(array("status" => TRUE));
		} else if (substr($no_register, 0, 2) == "RJ") {
			$jadwal['jadwal_rad'] = date("Y-m-d H:i:s");
			$this->radmdaftar->insert_jadwal_rad_irj($no_register, $jadwal);
			//echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_pemeriksaan($id = '', $no_register = '')
	{
		if (substr($no_register, 0, 2) == 'RI') {
			$data_iri = $this->radmdaftar->getdata_iri($no_register)->result();
			foreach ($data_iri as $row) {
				$status_rad = $row->status_rad;
				//var_dump($status_rad); die();
			}
			$status_rad = $status_rad + 1;
			$this->radmdaftar->selesai_per_pemeriksaan_iri($no_register, $status_rad);
		} else if (substr($no_register, 0, 2) == 'RJ') {
			$data_iri = $this->radmdaftar->getdata_rj($no_register)->result();
			foreach ($data_iri as $row) {
				$status_rad = $row->status_rad;
				//var_dump($status_rad); die();
			}
			$status_rad = $status_rad + 1;
			$this->radmdaftar->selesai_per_pemeriksaan_irj($no_register, $status_rad);
		}
		$data['selesai'] = 1;
		$data['tgl_kunjungan'] = date("Y-m-d H:i:s");
		$this->radmdaftar->selesai_pemeriksaan($id, $data);
		redirect('rad/radcdaftar/pemeriksaan_rad/' . $id);
	}

	public function edit_diag()
	{
		$no_register = $this->input->post('no_register');
		$diagnosa = $this->input->post('id_diagnosa');

		if (substr($no_register, 0, 2) == "RJ") {
			$data['diagnosa'] = $diagnosa;
			$id = $this->radmdaftar->edit_diag_masuk_rj($no_register, $data);
		} else {
			$data['diagmasuk'] = $diagnosa;
			$id = $this->radmdaftar->edit_diag_masuk_ri($no_register, $data);
		}

		// echo json_encode($data);
		echo json_encode(array("status" => TRUE));
	}

	public function insert_header_rad($pelayan = '')
	{
		// var_dump($this->input->post());die();
		$no_register = $this->input->post('no_register');
		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');

		$cara_bayar = $this->input->post('cara_bayar');
		$no_cm = $this->input->post('no_cm');
		$data_radiologi = json_decode($this->input->post('radiologi'));

		$data_pasien = $this->radmdaftar->get_data_pasien_form_pacs($no_cm)->row();
		$i = 0;
		$getvtotrad = $this->radmdaftar->get_vtot_rad($no_register)->row();
		$vtot = intval($getvtotrad->vtot_rad);
		$getrdrj = substr($no_register, 0, 2);


		// if ($this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
		// 	$this->radmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		// }

		// $no_rad=$this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_rad;

		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}

		// foreach($data_radiologi as $value){
		// 	$txt = ltrim(substr($no_register, 2),'0');
		// 	$date = date_create();
		// 	$timestamp = date_timestamp_get($date);
		// 	$accesion_no = substr($txt.$timestamp,0,12); // noreg + timestamp + sequence
		// 	// $generate_2 =  strval(date('Ymd')) + substr($timestamp,0,6); // ? date aja pak?datetime
		// 	$generate_2 =  date('YmdHis',strtotime($value->tgl_kunjungan)); // ? date aja pak?datetime , date hari i
		// 	$omr['PATIENT_NAME']=$data_pasien->nama;
		// 	$omr['PATIENT_SEX']=$data_pasien->sex;
		// 	// $omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
		// 	$omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
		// 	$omr['PATIENT_ID']=$this->input->post('no_cm'); // ini ASSN ID
		// 	$omr['ADMISSION_ID']=$no_register; // ini biasano kunjungan/kunjungan 
		// 	$omr['PATIENT_SEX']=$data_pasien->sex;
		// 	$omr['ATTEND_DOCTOR']='0902016'; // ?
		// 	$omr['REQUEST_DOCTOR']='dr Widya, S.RAD';
		// 	$omr['REFER_DOCTOR']='dr Agus, S.RAD'; 
		// 	$omr['REQUEST_DEPARTMENT']='RAD';
		// 	$omr['ACCESSION_NO']=strval($accesion_no); //no register + 3 angka generate dari belakang untuk no register yang sama unique
		// 	$omr['MWL_KEY']=$omr['ACCESSION_NO'];
		// 	$omr['TRIGGER_DTTM']=strval($generate_2); // datetime  + no_medrec
		// 	$omr['REPLICA_DTTM']='ANY'; 
		// 	$omr['SCHEDULED_AETITLE']=$value->modality;
		// 	$omr['SCHEDULED_DTTM']=strval($generate_2); 
		// 	$omr['ADMIT_DTTM']=strval($generate_2);
		// 	$omr['SCHEDULED_MODALITY']=$value->modality.'   '; //ini modality, perhatikan ada spasi dibelakangnya
		// 	$omr['SCHEDULED_STATION']=$value->modality; // 
		// 	$omr['SCHEDULED_PROC_ID']=$value->id_tindakan; // id periksa
		// 	$omr['SCHEDULED_PROC_DESC']=$value->jenis_tindakan; // 
		// 	$omr['REQUESTED_PROC_ID']=$value->id_tindakan; // id periksa
		// 	$omr['REQUESTED_PROC_DESC']=$value->jenis_tindakan; // 
		// 	$omr['SCHEDULED_PROC_STATUS']='120'; // permintaan baru
		// 	$omr['STUDY_INSTANCE_UID']='1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
		// 	$omr['IMAGING_REQUEST_COMMENTS']=$value->komen;
		// 	$result_pacs = $cara_bayar!="UMUM"?$this->insert_pacs($omr,$i):null;

		// 	// update ke db insert accesion number
		// 	// var_dump(strval($accesion_no). strval($i));die();
		// 	if($getrdrj=="PL"){
		// 		$result_pacs?$this->radmdaftar->selesai_daftar_pemeriksaan_PL_header($no_register,$vtot,$no_rad,strval($accesion_no). strval($i),$value->id_pemeriksaan_rad):$this->radmdaftar->selesai_daftar_pemeriksaan_PL_header($no_register,$vtot,$no_rad,'',$value->id_pemeriksaan_rad);
		// 	} else if($getrdrj=="RJ"){			
		// 		$result_pacs?$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ_header($no_register,$vtot,$no_rad,strval($accesion_no). strval($i),$value->id_pemeriksaan_rad):$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ_header($no_register,$vtot,$no_rad,'',$value->id_pemeriksaan_rad);
		// 	}
		// 	else if ($getrdrj=="RD"){
		// 		$result_pacs?$this->radmdaftar->selesai_daftar_pemeriksaan_IRD_header($no_register,$vtot,$no_rad,strval($accesion_no). strval($i),$value->id_pemeriksaan_rad):$this->radmdaftar->selesai_daftar_pemeriksaan_IRD_header($no_register,$vtot,$no_rad,'',$value->id_pemeriksaan_rad);
		// 	}
		// 	else if ($getrdrj=="RI"){
		// 		$data_iri=$this->radmdaftar->getdata_iri($no_register)->result();
		// 		foreach($data_iri as $row){
		// 			$status_rad=$row->status_rad;
		// 		}
		// 		$status_rad = $status_rad + 1;
		// 		$result_pacs?$this->radmdaftar->selesai_daftar_pemeriksaan_IRI_header($no_register,$status_rad,$vtot,$no_rad,strval($accesion_no). strval($count),$value->id_pemeriksaan_rad):$this->radmdaftar->selesai_daftar_pemeriksaan_IRI_header($no_register,$status_rad,$vtot,$no_rad,'',$value->id_pemeriksaan_rad);
		// 	}

		// 	$i++;
		// }
		// end of insert pacs
		// die();




		if ($pelayan == 'DOKTER') {
			if ($id_poli == 'BA00') {
				redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
			} else {
				if ($getrdrj == "PL") {
					redirect("rad/radcdaftar/");
				} else if ($getrdrj == "RJ") {
					redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
				} else if ($getrdrj == "RI") {
					redirect("iri/rictindakan/index/$no_register");
				} else {
					redirect("rad/radcdaftar/");
				}
			}
		} else {
			// if ($id_poli == 'BA00') {
			// 	redirect("rad/radcdaftar/cetak_faktur/$no_rad");
			// }else{
			// 	if($getrdrj=="PL"){					
			// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
			// 	} 
			// 	else if($getrdrj=="RJ"){					
			// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
			// 	}
			// 	else if ($getrdrj=="RI"){					
			// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
			// 	}else {
			redirect("rad/radcdaftar/");
			// 	}
			// }

		}



		//print_r($vtot);
	}

	public function selesai_cetak_faktur($pelayan = '')
	{
		$no_register = $this->input->post('no_register');
		$identitypasien = substr($no_register, 0, 2);

		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');

		$cara_bayar = $this->input->post('cara_bayar');
		$no_cm = $this->input->post('no_cm');
		$data_radiologi = json_decode($this->input->post('radiologi'));

		$data_pasien = $identitypasien == 'PL' ? $this->radmdaftar->get_data_pasien_form_pacs_luar($no_register)->row() : $this->radmdaftar->get_data_pasien_form_pacs($no_cm)->row();
		// var_dump($data_pasien);die();
		$get_accesion_number = $this->radmdaftar->get_accesion_number($no_register)->row();
		if (!empty($get_accesion_number)) { // jika sudah ada, langsung ambil dan proses...
			$sLastKode = substr($no_register, 0, 2) == "PL" ? substr($get_accesion_number->accesion_number, 13) : substr($get_accesion_number->accesion_number, 12); // ambil 3 digit terakhir
			$i = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
			//$sNextKode = "JNS" . sprintf('%03s', $sLastKode); // format hasilnya dan tambahkan prefix
			// if (strlen($sNextKode) > 6) {
			// 	$sNextKode = "JNS999";
			// }
		} else { // jika belum ada, gunakan kode yang pertama
			$i = 0;
		}
		//var_dump($i); die();
		//$i = 0;
		$getvtotrad = $this->radmdaftar->get_vtot_rad($no_register)->row();
		$vtot = intval($getvtotrad->vtot_rad);
		$getrdrj = substr($no_register, 0, 2);
		// if ($this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
		$this->radmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas);
		// }

		$no_rad = $this->radmdaftar->get_data_header($no_register, $idrg, $bed, $kelas)->row()->no_rad;

		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}
		// var_dump($data_radiologi);die();
		//var_dump(substr($no_register,0,2));die();
		foreach ($data_radiologi as $value) {
			$txt = substr($no_register, 0, 2) == "PL" ? ltrim(substr($no_register, 3), '0') : ltrim(substr($no_register, 2), '0');
			$date = date_create();
			$timestamp = date_timestamp_get($date);
			$accesion_no = substr($no_register, 0, 2) == "PL" ? substr($txt . $timestamp, 0, 13) : substr($txt . $timestamp, 0, 12); // noreg + timestamp + sequence
			// $generate_2 =  strval(date('Ymd')) + substr($timestamp,0,6); // ? date aja pak?datetime
			// $generate_2 =  date('YmdHis',strtotime($value->tgl_kunjungan)); // ? date aja pak?datetime , date hari i
			$generate_2 =  date('YmdHis'); // ? date aja pak?datetime , date hari i
			$omr['PATIENT_NAME'] = $data_pasien->nama;
			$omr['PATIENT_SEX'] = $data_pasien->sex;
			// $omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
			$omr['PATIENT_BIRTH_DATE'] = strval(date('Ymd', strtotime($data_pasien->tgl_lahir)));
			$omr['PATIENT_ID'] = $identitypasien == 'PL' ? substr($no_register, 3) : $this->input->post('no_cm'); // ini ASSN ID
			$omr['ADMISSION_ID'] = $no_register; // ini biasano kunjungan/kunjungan 
			$omr['PATIENT_SEX'] = $data_pasien->sex;
			$omr['ATTEND_DOCTOR'] = '0902016'; // ?
			$omr['REQUEST_DOCTOR'] = 'dr Widya, S.RAD';
			$omr['REFER_DOCTOR'] = 'dr Agus, S.RAD';
			$omr['REQUEST_DEPARTMENT'] = 'RAD';
			$omr['ACCESSION_NO'] = strval($accesion_no); //no register + 3 angka generate dari belakang untuk no register yang sama unique
			$omr['MWL_KEY'] = $omr['ACCESSION_NO'];
			$omr['TRIGGER_DTTM'] = strval($generate_2); // datetime  + no_medrec
			$omr['REPLICA_DTTM'] = 'ANY';
			$omr['SCHEDULED_AETITLE'] = $value->modality;
			$omr['SCHEDULED_DTTM'] = strval($generate_2);
			$omr['ADMIT_DTTM'] = strval($generate_2);
			$omr['SCHEDULED_MODALITY'] = $value->modality . '   '; //ini modality, perhatikan ada spasi dibelakangnya
			$omr['SCHEDULED_STATION'] = $value->modality; // 
			$omr['SCHEDULED_PROC_ID'] = $value->id_tindakan; // id periksa
			$omr['SCHEDULED_PROC_DESC'] = $value->jenis_tindakan; // 
			$omr['REQUESTED_PROC_ID'] = $value->id_tindakan; // id periksa
			$omr['REQUESTED_PROC_DESC'] = $value->jenis_tindakan; // 
			$omr['SCHEDULED_PROC_STATUS'] = '120'; // permintaan baru
			$omr['STUDY_INSTANCE_UID'] = '1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
			$omr['IMAGING_REQUEST_COMMENTS'] = $value->komen;
			// $result_pacs = $cara_bayar!="UMUM"?$this->insert_pacs($omr,$i):null;
			// var_dump(strval($accesion_no));die();
			// var_dump($omr);die();
			$result_pacs = $this->insert_pacs($omr, $i);

			// update ke db insert accesion number
			if ($getrdrj == "PL") {
				$this->radmdaftar->selesai_faktur_pemeriksaan_PL($no_register, $vtot, $no_rad, strval($accesion_no) . strval($i), $value->id_pemeriksaan_rad);
			} else if ($getrdrj == "RJ") {
				$data_iri = $this->radmdaftar->getdata_faktur_rj($no_register)->result();
				foreach ($data_iri as $row) {
					//$status_rad=$row->status_rad;
					$cetak_status_rad = $row->status_cetak_rad;
				}
				$cetak_status_rad = $cetak_status_rad + 1;
				$this->radmdaftar->selesai_faktur_pemeriksaan_IRJ($no_register, $vtot, $no_rad, strval($accesion_no) . strval($i), $value->id_pemeriksaan_rad, $cetak_status_rad);
			} else if ($getrdrj == "RD") {
				$data_iri = $this->radmdaftar->getdata_faktur_rj($no_register)->result();
				foreach ($data_iri as $row) {
					$cetak_status_rad = $row->status_cetak_rad;
				}
				$cetak_status_rad = $cetak_status_rad + 1;
				$this->radmdaftar->selesai_faktur_pemeriksaan_IRD($no_register, $vtot, $no_rad, strval($accesion_no) . strval($i), $value->id_pemeriksaan_rad, $cetak_status_rad);
			} else if ($getrdrj == "RI") {
				$data_iri = $this->radmdaftar->getdata_faktur_iri($no_register)->result();
				foreach ($data_iri as $row) {
					$cetak_status_rad = $row->status_cetak_rad;
				}
				$cetak_status_rad = $cetak_status_rad + 1;
				$this->radmdaftar->selesai_faktur_pemeriksaan_IRI($no_register, $cetak_status_rad, $vtot, $no_rad, strval($accesion_no) . strval($i), $value->id_pemeriksaan_rad);
			}

			$i++;
		}
		// end of insert pacs
		// die();




		if ($pelayan == 'DOKTER') {
			if ($id_poli == 'BA00') {
				redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
			} else {
				if ($getrdrj == "PL") {
					redirect("rad/radcdaftar/");
				} else if ($getrdrj == "RJ") {
					redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/" . $id_poli . "/" . $no_register);
				} else if ($getrdrj == "RI") {
					redirect("iri/rictindakan/index/$no_register");
				} else {
					redirect("rad/radcdaftar/");
				}
			}
		} else {
			if ($id_poli == 'BA00') {
				redirect("rad/radcdaftar/cetak_faktur/$no_rad");
			} else {
				if ($getrdrj == "PL") {
					redirect("rad/radcdaftar/cetak_faktur/$no_rad");
				} else if ($getrdrj == "RJ") {
					redirect("rad/radcdaftar/cetak_faktur/$no_rad");
				} else if ($getrdrj == "RI") {
					redirect("rad/radcdaftar/cetak_faktur/$no_rad");
				} else {
					redirect("rad/radcdaftar/");
				}
			}
		}
	}

	public function form_bhp($id_pemeriksaan_rad = '')
	{
		$data['title'] = 'Pengisian BHP Pemeriksaan';
		$data['data_pasien'] = $this->radmdaftar->get_data_pasien_pemeriksaan_header($id_pemeriksaan_rad)->row();
		$data['no_register'] = $data['data_pasien']->no_register;
		$data['no_medrec'] = $data['data_pasien']->no_medrec;

		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
		$data['master_bhp'] = $this->radmdaftar->get_master_bhp()->result();
		$data['view'] = 0;
		$this->load->view('rad/radvbhp', $data);
	}

	public function insert_bhp()
	{
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$userid = $login_data->userid;

		$data['no_register'] = $this->input->post('no_register');
		$no_register = $this->input->post('no_register');
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_rad');
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;

		$data['no_medrec'] = $this->input->post('no_medrec');

		$data['xuser'] = $user;
		$data['idxuser'] = $userid;

		$bhp = explode("@", $this->input->post('nama_bhp'));
		//var_dump($bhp[3]);die();
		$data['nama_bhp'] = $bhp[0];
		$data['satuan'] = $bhp[1];
		$data['kategori'] = $bhp[2];
		$data['id_bhp'] = $bhp[3];
		$data['tanggal_input'] = date("Y-m-d H:i:s");
		if ($this->input->post('ulang') == '') {
			$data['ulang'] = NULL;
		} else {
			$data['ulang'] = $this->input->post('ulang');
		}

		$data['nama_bhp'] = $bhp[0];
		$data['satuan'] = $bhp[1];
		$data['kategori'] = $bhp[2];

		//$get_ttd_dokter = $this->rjmpelayanan->ttd_pemeriksa($userid)->row();

		$data['qty'] = $this->input->post('qty');

		$id = $this->radmdaftar->insert_bhp($data);

		echo json_encode($id);
	}

	public function bhp_pasien($id_pemeriksaan_rad)
	{
		$hasil = $this->radmdaftar->get_bhp_pasien_radiologi($id_pemeriksaan_rad)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['nama_bhp'] = $value->nama_bhp;
			$row2['satuan'] = $value->satuan;
			$row2['kategori'] = $value->kategori;
			$row2['qty'] = $value->qty;
			$row2['aksi'] = '<a href="' . site_url('rad/radcdaftar/hapus_pemeriksaan_bhp/' . $value->id_bhp_rad) . '" class="btn btn-danger btn-xs">Hapus</a>
			
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBhp" onclick="edit_bhp(' . $value->id_bhp_rad . ')">Edit</button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function hapus_pemeriksaan_bhp($id_bhp = '')
	{
		$id_pemeriksaan_rad = $this->radmdaftar->get_bhp_pasien_radiologi_byid($id_bhp)->row()->id_pemeriksaan_rad;

		$id = $this->radmdaftar->hapus_pemeriksaan_bhp($id_bhp);

		$success = 	'<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				<h3><i class="fa fa-check-circle"></i> Data Berhasil Dihapus.</h3>
			</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('rad/radcdaftar/form_bhp/' . $id_pemeriksaan_rad);
	}

	public function get_data_edit_bhp()
	{
		$id = $this->input->post('id');
		//var_dump($id); die();
		$datajson = $this->radmdaftar->get_bhp_pasien_radiologi_byid($id)->result();
		echo json_encode($datajson);
	}

	public function edit_bhp_pemeriksaan()
	{
		$login_data = $this->load->get_var("user_info");
		$id_bhp = $this->input->post('id_bhp_edit_hide');
		$id_pemeriksaan_rad = $this->input->post('id_pemeriksaan_hide');

		$data['nama_bhp'] = explode('@', $this->input->post('nama_bhp_edit'))[0];
		$data['satuan'] = explode('@', $this->input->post('nama_bhp_edit'))[1];
		$data['kategori'] = explode('@', $this->input->post('nama_bhp_edit'))[2];

		$data['xuser'] = $login_data->username;
		$data['idxuser'] = $login_data->userid;
		$data['qty'] = $this->input->post('qty_edit');
		//var_dump($data['qty']); die();
		$id = $this->radmdaftar->edit_bhp_pemeriksaan($id_bhp, $data);
		echo json_encode($id);
		//redirect('rad/radcdaftar/form_bhp/'.$id_pemeriksaan_rad, 'refresh');
	}

	public function selesai_daftar_pemeriksaan_($pelayan = '')
	{
		// var_dump($this->input->post());die();
		$no_register = $this->input->post('no_register');
		$identitypasien = substr($no_register, 0, 2);

		$idrg = $this->input->post('idrg');
		$bed = $this->input->post('bed');
		$kelas = $this->input->post('kelas_pasien');

		$cara_bayar = $this->input->post('cara_bayar');
		$no_cm = $this->input->post('no_cm');
		$data_radiologi = json_decode($this->input->post('radiologi'));

		$data_pasien = $identitypasien == 'PL' ? $this->radmdaftar->get_data_pasien_form_pacs_luar($no_register)->row() : $this->radmdaftar->get_data_pasien_form_pacs($no_cm)->row();
		// var_dump($data_pasien);die();
		$i = 0;
		//$getvtotrad=$this->radmdaftar->get_vtot_rad($no_register)->row();
		//$vtot = intval($getvtotrad->vtot_rad);
		$getrdrj = substr($no_register, 0, 2);
		// if ($this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row() == null) {
		//$this->radmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		// }

		//$no_rad=$this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_rad;

		if ($getrdrj == 'RJ') {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else if ($getrdrj == "RD") {
			$get_poli = $this->labmdaftar->get_idpoli($no_register)->row();
		} else {
			$get_poli = null;
		}

		if ($get_poli != null) {
			$id_poli = $get_poli->id_poli;
		} else {
			$id_poli = null;
		}
		// var_dump($data_radiologi);die();
		//var_dump(substr($no_register,0,2));die();
		foreach ($data_radiologi as $value) {
			// $txt = substr($no_register,0,2) == "PL"?ltrim(substr($no_register,3),'0'):ltrim(substr($no_register, 2),'0') ;
			// $date = date_create();
			// $timestamp = date_timestamp_get($date);
			// $accesion_no = substr($no_register,0,2) == "PL"?substr($txt.$timestamp,0,13):substr($txt.$timestamp,0,12); // noreg + timestamp + sequence
			// $generate_2 =  strval(date('Ymd')) + substr($timestamp,0,6); // ? date aja pak?datetime
			// $generate_2 =  date('YmdHis',strtotime($value->tgl_kunjungan)); // ? date aja pak?datetime , date hari i
			// $generate_2 =  date('YmdHis'); // ? date aja pak?datetime , date hari i
			// $omr['PATIENT_NAME']=$data_pasien->nama;
			// $omr['PATIENT_SEX']=$data_pasien->sex;
			// $omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
			// $omr['PATIENT_BIRTH_DATE']=strval(date('Ymd',strtotime($data_pasien->tgl_lahir)));
			// $omr['PATIENT_ID']=$identitypasien == 'PL' ?substr($no_register,3):$this->input->post('no_cm'); // ini ASSN ID
			// $omr['ADMISSION_ID']=$no_register; // ini biasano kunjungan/kunjungan 
			// $omr['PATIENT_SEX']=$data_pasien->sex;
			// $omr['ATTEND_DOCTOR']='0902016'; // ?
			// $omr['REQUEST_DOCTOR']='dr Widya, S.RAD';
			// $omr['REFER_DOCTOR']='dr Agus, S.RAD'; 
			// $omr['REQUEST_DEPARTMENT']='RAD';
			// $omr['ACCESSION_NO']=strval($accesion_no); //no register + 3 angka generate dari belakang untuk no register yang sama unique
			// $omr['MWL_KEY']=$omr['ACCESSION_NO'];
			// $omr['TRIGGER_DTTM']=strval($generate_2); // datetime  + no_medrec
			// $omr['REPLICA_DTTM']='ANY'; 
			// $omr['SCHEDULED_AETITLE']=$value->modality;
			// $omr['SCHEDULED_DTTM']=strval($generate_2); 
			// $omr['ADMIT_DTTM']=strval($generate_2);
			// $omr['SCHEDULED_MODALITY']=$value->modality.'   '; //ini modality, perhatikan ada spasi dibelakangnya
			// $omr['SCHEDULED_STATION']=$value->modality; // 
			// $omr['SCHEDULED_PROC_ID']=$value->id_tindakan; // id periksa
			// $omr['SCHEDULED_PROC_DESC']=$value->jenis_tindakan; // 
			// $omr['REQUESTED_PROC_ID']=$value->id_tindakan; // id periksa
			// $omr['REQUESTED_PROC_DESC']=$value->jenis_tindakan; // 
			// $omr['SCHEDULED_PROC_STATUS']='120'; // permintaan baru
			// $omr['STUDY_INSTANCE_UID']='1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
			// $omr['IMAGING_REQUEST_COMMENTS']=$value->komen;
			// $result_pacs = $cara_bayar!="UMUM"?$this->insert_pacs($omr,$i):null;
			// var_dump(strval($accesion_no));die();
			// var_dump($omr);die();
			//$result_pacs = $this->insert_pacs($omr,$i);			

			// update ke db insert accesion number
			if ($getrdrj == "PL") {
				$this->radmdaftar->selesai_daftar_pemeriksaan_PL($no_register);
			} else if ($getrdrj == "RJ") {
				$data_iri = $this->radmdaftar->getdata_rj($no_register)->result();
				foreach ($data_iri as $row) {
					$status_rad = $row->status_rad;
				}
				$status_rad = $status_rad + 1;
				$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register, $status_rad);
			} else if ($getrdrj == "RD") {
				$data_iri = $this->radmdaftar->getdata_rj($no_register)->result();
				foreach ($data_iri as $row) {
					$status_rad = $row->status_rad;
				}
				$status_rad = $status_rad + 1;
				$this->radmdaftar->selesai_daftar_pemeriksaan_IRD($no_register, $status_rad);
			} else if ($getrdrj == "RI") {
				$data_iri = $this->radmdaftar->getdata_iri($no_register)->result();
				//foreach($data_iri as $row){
				//$status_rad=(int)$row->status_rad;
				//var_dump($status_rad); die();
				//}
				//$status_rad = $status_rad + 1;
				//var_dump($status_rad); die();
				$this->radmdaftar->selesai_daftar_pemeriksaan_IRI($no_register);
			}

			$i++;
		}
		// end of insert pacs
		// die();




		//if ($pelayan == 'DOKTER') {
		// if ($id_poli == 'BA00') {
		// 	redirect("ird/rdcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
		// }else{
		// 	if($getrdrj=="PL"){				
		// 		redirect("rad/radcdaftar/");
		// 	} 
		// 	else if($getrdrj=="RJ"){				
		// 		redirect("irj/rjcpelayananfdokter/pelayanan_tindakan/".$id_poli."/".$no_register);
		// 	}
		// 	else if ($getrdrj=="RI"){				
		// 		redirect("iri/rictindakan/index/$no_register");
		// 	}else {
		// 		redirect("rad/radcdaftar/");
		// 	}
		// }			
		//}else{
		//if ($id_poli == 'BA00') {
		redirect("rad/radcdaftar/");
		// }else{
		// 	if($getrdrj=="PL"){					
		// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		// 	} 
		// 	else if($getrdrj=="RJ"){					
		// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		// 	}
		// 	else if ($getrdrj=="RI"){					
		// 		redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		// 	}else {
		// 		redirect("rad/radcdaftar/");
		// 	}
		// }

		//}



		//print_r($vtot);
	}

	public function selesai_daftar_pemeriksaan()
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotrad=$this->radmdaftar->get_vtot_rad($no_register)->row()->vtot_rad;
		$getrdrj=substr($no_register, 0,2);

		$this->radmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_rad=$this->radmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_rad;

		if($getrdrj=="PL"){
			$this->radmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotrad,$no_rad);
		} else if($getrdrj=="RJ"){			
			$this->radmdaftar->selesai_daftar_pemeriksaan_IRJ_new($no_register,$getvtotrad,$no_rad);
		}
		else if ($getrdrj=="RD"){
			$this->radmdaftar->selesai_daftar_pemeriksaan_IRD_new($no_register,$getvtotrad,$no_rad);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->radmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_rad=$row->status_rad;
			}
			$status_rad = $status_rad + 1;
			$this->radmdaftar->selesai_daftar_pemeriksaan_IRI_new($no_register,$status_rad,$getvtotrad,$no_rad);
		}
		if($urikes=="1"){ //urikkes
			$this->radmdaftar->selesai_daftar_pemeriksaan_urikes($no_register,$getvtotrad,$no_rad);}



		if ($getrdrj == "PL") {
			redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		} else if ($getrdrj == "RJ") {
			redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		} else if ($getrdrj == "RI") {
			redirect("rad/radcdaftar/cetak_faktur/$no_rad");
		} else {
			redirect("rad/radcdaftar/");
		}
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_rad = '')
	{
		$id = $this->radmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_rad);
		echo json_encode(array("status" => $id_pemeriksaan_rad));

		// redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);

		//print_r($id);
	}

	public function daftar_pasien_luar()
	{
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		$data['xuser'] = $user;
		$data['nama'] = $this->input->post('nama');
		$data['usia'] = $this->input->post('usia');
		$data['jk'] = $this->input->post('jk');
		$data['tgl_lahir'] = $this->input->post('tgl_lahir');
		$data['alamat'] = $this->input->post('alamat');
		$data['diagnosa'] = $this->input->post('diagnosa');
		$data['tgl_kunjungan'] = date('Y-m-d H:i:s');
		$data['rad'] = '1';
		$data['cetak_rad'] = 1;
		$data['dokter'] = $this->input->post('dokter');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['jenis_PL'] = 'RAD';
		$data['cetak_kwitansi'] = 0;
		$data['rs_perujuk'] = $this->input->post('perujuk');
		if ($data['cara_bayar'] == 'BPJS') {
			$data['nmkontraktor'] = $this->input->post('iks_bpjs');
		}
		if ($data['cara_bayar'] == 'BPJS') {
			$data['nmkontraktor'] = $this->input->post('iks_bpjs');
		} else if ($data['cara_bayar'] == 'KERJASAMA') {
			$data['nmkontraktor'] = $this->input->post('iks');
		} else {
			$data['nmkontraktor'] = NULL;
		}
		$data['no_hp'] = $this->input->post('no_hp');
		$data['email'] = $this->input->post('email');
		$data['nik'] = $this->input->post('nik');
		$this->radmdaftar->insert_pasien_luar($data);

		redirect('rad/radcdaftar/list_order');
		//print_r($data);
	}

	public function cetak_faktur($no_rad = '')
	{
		$data['no_rad'] = $no_rad;
		$jumlah_vtot = $this->radmdaftar->get_vtot_no_rad($no_rad)->row()->vtot_no_rad;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if ($no_rad != '') {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien'] = $this->radmkwitansi->get_data_pasien($no_rad)->row();
			// var_dump($data['data_pasien']);
			$data['data_pemeriksaan'] = $this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
			$cterbilang = new rjcterbilang();
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = (int)$tahun_now - (int)$tahun_lahir;
			$jumlah_vtot0 = 0;
			foreach ($data['data_pemeriksaan'] as $row) {
				$jumlah_vtot0 = $jumlah_vtot0 + $row->vtot;
			}
			$data['vtot_terbilang'] = $cterbilang->terbilang($jumlah_vtot0);

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;
			$html = $this->load->view('paper_css/faktur_rad', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_rad',$data);
		} else {
			redirect('rad/radcdaftar/', 'refresh');
		}
	}

	// public function update_status_rad()
	// {	
	// 	$no_register=$this->input->post('no_register');


	// 	if ($this->input->post('rad')!=null) 
	// 	{	
	// 		$data['rad']=0;
	// 		$data['status_rad']=0;
	// 		$data['jadwal_rad']=date("Y-m-d");
	// 		// $data['jadwal_rad']=$this->input->post('jadwal');
	// 	}


	// 	$id=$this->rjmpelayanan->update_rujukan_penunjang($data,$no_register);

	// 	$success = 	'<div class="alert alert-success">
	//                     		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	//                         	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
	//                    	</div>';


	// 	$this->session->set_flashdata('success_msg', $success);

	// 	redirect('rad/radcdaftar/pemeriksaan_rad/'.$no_register);
	// }

	public function insert_permintaan_resep()
	{
		$no_register = $this->input->post('no_register');

		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['tgl_kunjungan'] = date('Y-m-d');
		$data['id_inventory'] = $this->input->post('id_inventory');
		$data['item_obat'] = $this->input->post('id_obat');
		$data['nama_obat'] = $this->input->post('nm_obat');
		$data['qty'] = $this->input->post('qty');
		$sgn = $this->input->post('signa');
		$qtx = $this->input->post('qtx');
		$satuan = $this->input->post('satuan');
		$cara_pakai = $this->input->post('cara_pakai');
		$makan = strtoupper($sgn . ", " . $qtx . " " . $satuan . ", " . $cara_pakai);
		if ($makan == '') {
			$data['signa'] = "-";
			$data['qtx'] = 0;
			$data['Satuan_obat'] = "-";
			$data['cara_pakai'] = "-";
			$data['kali_harian'] = "-";
		} else {
			$data['signa'] = $makan;
			if ($qtx == null) {
				$qtxs = 0;
			} else {
				$qtxs = $qtx;
			}
			$data['qtx'] = $qtxs;
			$data['Satuan_obat'] = $satuan;
			$data['cara_pakai'] = $cara_pakai;
			$data['kali_harian'] = $sgn;
		}


		$data['xupdate'] = date('Y-m-d H:i:s');
		$data['no_register'] = $this->input->post('no_register');
		$kelas = $this->input->post('kelas_pasien');
		$idrg = $this->input->post('idrg');
		// $idrg= $this->radmdaftar->get_idpoli($this->input->post('idrg'))->row()->id_poli;
		$bed = $this->input->post('idrg');
		$data['kelas'] = $kelas;
		$data['idrg'] = $idrg;
		$data['bed'] = $bed;



		$data['cara_bayar'] = $this->input->post('cara_bayar');

		// $data['no_resep']=$this->input->post('no_resep');
		$stok_obat = $this->Frmmdaftar->cek_stok_obat($data['id_inventory'], $data['qty'])->result();

		if (empty($stok_obat)) {
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> Stok Tidak Mencukupi</div>');
			if ($this->input->post('idpoli') != '') {
				if ($this->input->post('pelayan') == 'DOKTER') {
					redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			} else {
				if ($this->input->post('pelayan') == 'DOKTER') {
					redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
				} else {
					redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register);
				}
			}
		}
		//update stok
		$this->Frmmdaftar->update_stok_obat($data['id_inventory'], $data['qty']);

		$data['biaya_obat'] = $this->input->post('hargajual');
		$data['fmarkup'] = $this->input->post('fmarkup');
		$data['ppn'] = $this->input->post('margin');
		if ($this->input->post('cara_bayar') == 'UMUM') {
			$total_akhir = (int)$data['biaya_obat'] * (int)$data['qty'];
		} else {
			$total_akhir = (int)$data['biaya_obat'] * (int)$data['qty'];
		}
		$data['vtot'] = $total_akhir;

		$data['xinput'] = $this->input->post('xuser');
		$data['satelit'] = $this->input->post('satelit');

		$data['kronis'] = $this->input->post('kronis');
		$kronis = $this->input->post('kronis');
		$poli = $this->input->post('idpoli');
		$ket = $this->input->post('ket');
		if ($ket != 1) {
			$klaim = $this->Frmmdaftar->cek_kronis_klaim($data['item_obat'], $poli, $kronis);
			$row_klaim = $klaim->row();
			$cek_klaim = $klaim->num_rows();
		}

		// if ($this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->num_rows() == 0) {
		$this->Frmmdaftar->insert_data_header($no_register, $idrg, $bed, $kelas);
		// }

		$data['no_resep'] = $this->Frmmdaftar->get_data_header($no_register, $idrg, $bed, $kelas)->row()->no_resep;

		/* Cek Cara Bayar Untuk Klaim Kronis Non Kronis BPJS */
		if ($data['cara_bayar'] == 'BPJS') {

			/* Jika Record Ditemukan, cek QTY yg dipesan dengan Standar yg ada
            * Jika tidak ada langsung simpan data dengan Flash Data isi dari Keterangan Klaim
            */
			if ($cek_klaim > 0) {
				if ($data['qty'] > $row_klaim->qty) {
					$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> QTY Melebihi Standar Klaim yang ditentukan! (Max: ' . $row_klaim->qty . ' pcs)</div>');
				} else {
					$this->session->set_flashdata('info', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-info"><i class="fa fa-check-circle"></i> Informasi</h3> ' . $row_klaim->keterangan . '</div>');
					$this->Frmmdaftar->insert_permintaan($data);
				}
			} else {
				$this->Frmmdaftar->insert_permintaan($data);

				$data_fisik = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
			}
		} else {
			$this->Frmmdaftar->insert_permintaan($data);
		}

		if ($this->input->post('koreksi') != '') {
			if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register'] . '/DOKTER');
			} else {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register']);
			}
		}
		if ($this->input->post('idpoli') != '') {
			if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register'] . '/DOKTER');
			} else {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register']);
			}
		} else {
			if ($this->input->post('pelayan') == 'DOKTER') {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register'] . '/DOKTER');
			} else {
				redirect('rad/Radcdaftar/pemeriksaan_rad/' . $data['no_register']);
			}
		}
		//echo print_r($data);
	}

	public function hapus_permintaan_resep()
	{
		$no_register = $this->input->post('no_register');

		$id_resep_pasien = $this->input->post('id_resep_pasien');

		$no_medrec = $this->input->post('no_medrec');

		$obat = $this->Frmmdaftar->get_resep_pasien($id_resep_pasien)->row();
		$this->Frmmdaftar->update_stok_obat_hapus($obat->id_inventory, $obat->qty);
		$this->radmdaftar->hapus_resep_rad($no_register, $id_resep_pasien);

		if ($this->input->post('pelayan') == 'DOKTER') {
			redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register . '/DOKTER');
		} else {
			redirect('rad/Radcdaftar/pemeriksaan_rad/' . $no_register);
		}

		//echo print_r($data);
	}

	public function insert_pacs($result, $count)
	{
		// var_dump(APPPATH);

		$omr = [
			'MWL_KEY' => '',
			'TRIGGER_DTTM' => '',
			'REPLICA_DTTM' => '',
			'EVENT_TYPE' => '',
			'CHARACTER_SET' => '',
			'SCHEDULED_AETITLE' => '',
			'SCHEDULED_DTTM' => '',
			'SCHEDULED_MODALITY' => '',
			'SCHEDULED_STATION' => '',
			'SCHEDULED_LOCATION' => '',
			'SCHEDULED_PROC_ID' => '',
			'SCHEDULED_PROC_DESC' => '',
			'SCHEDULED_ACTION_CODES' => '',
			'SCHEDULED_PROC_STATUS' => '',
			'PREMEDICATION' => '',
			'CONTRAST_AGENT' => '',
			'REQUESTED_PROC_ID' => '',
			'REQUESTED_PROC_DESC' => '',
			'REQUESTED_PROC_CODES' => '',
			'REQUESTED_PROC_PRIORITY' => '',
			'REQUESTED_PROC_REASON' => '',
			'REQUESTED_PROC_COMMENTS' => '',
			'STUDY_INSTANCE_UID' => '',
			'PROC_PLACER_ORDER_NO' => '',
			'PROC_FILER_ORDER_NO' => '',
			'ACCESSION_NO' => '',
			'ATTEND_DOCTOR' => '',
			'PERFORM_DOCTOR' => '',
			'CONSULT_DOCTOR' => '',
			'REQUEST_DOCTOR' => '',
			'REFER_DOCTOR' => '',
			'REQUEST_DEPARTMENT' => '',
			'IMAGING_REQUEST_REASON' => '',
			'IMAGING_REQUEST_COMMENTS' => '',
			'IMAGING_REQUEST_DTTM' => '',
			'ISR_PLACER_ORDER_NO' => '',
			'ISR_FILLER_ORDER_NO' => '',
			'ADMISSION_ID' => '',
			'PATIENT_TRANSPORT' => '',
			'PATIENT_LOCATION' => '',
			'PATIENT_RESIDENCY' => '',
			'PATIENT_NAME' => '',
			'PATIENT_ID' => '',
			'OTHER_PATIENT_NAME' => '',
			'OTHER_PATIENT_ID' => '',
			'PATIENT_BIRTH_DATE' => '',
			'PATIENT_SEX' => '',
			'PATIENT_WEIGHT' => '',
			'PATIENT_SIZE' => '',
			'PATIENT_STATE' => '',
			'CONFIDENTIALITY' => '',
			'PREGNANCY_STATUS' => '',
			'MEDICAL_ALERT' => '',
			'CONTRAST_ALLERGIES' => '',
			'SPECIAL_NEEDS' => '',
			'SPECIALITY' => '',
			'DIAGNOSIS' => '',
			'ADMIT_DTTM' => ''
		];

		$omr['PATIENT_NAME'] = $result['PATIENT_NAME'];
		$omr['PATIENT_SEX'] = $result['PATIENT_SEX'];
		$omr['PATIENT_BIRTH_DATE'] = $result['PATIENT_BIRTH_DATE'];
		$omr['PATIENT_ID'] = $result['PATIENT_ID']; // ini ASSN ID
		$omr['ADMISSION_ID'] = $result['ADMISSION_ID']; // no registrasi/kunjungan 
		$omr['PATIENT_SEX'] = $result['PATIENT_SEX'];
		$omr['ATTEND_DOCTOR'] = '0902016'; // ?ini ID dokter widya
		$omr['REQUEST_DOCTOR'] = 'dr Widya, S.RAD';
		$omr['REFER_DOCTOR'] = $result['REFER_DOCTOR'];  // ini masukin dr Rjukan aja, tapi di pacs tetep gak muncul
		$omr['REQUEST_DEPARTMENT'] = 'RAD';
		$omr['ACCESSION_NO'] = $result['ACCESSION_NO'] . strval($count); //no register + 3 angka generate dari belakang untuk no register yang sama unique
		$omr['MWL_KEY'] = $omr['ACCESSION_NO'];
		$omr['TRIGGER_DTTM'] = $result['TRIGGER_DTTM']; // datetime  + no_medrec
		$omr['REPLICA_DTTM'] = 'ANY';
		$omr['SCHEDULED_AETITLE'] = $result['SCHEDULED_AETITLE']; // ini judul pemeriksaan
		$omr['SCHEDULED_DTTM'] = $result['SCHEDULED_DTTM'];
		$omr['ADMIT_DTTM'] = $result['SCHEDULED_DTTM'];
		$omr['SCHEDULED_MODALITY'] = $result['SCHEDULED_STATION'] . '    '; //ini modality, perhatikan ada spasi dibelakangnya
		$omr['SCHEDULED_STATION'] = $result['SCHEDULED_STATION']; // 
		$omr['SCHEDULED_PROC_ID'] = $result['REQUESTED_PROC_ID']; // id periksa
		$omr['SCHEDULED_PROC_DESC'] = $result['REQUESTED_PROC_DESC']; // 
		$omr['REQUESTED_PROC_ID'] = $omr['SCHEDULED_PROC_ID']; // id periksa
		$omr['REQUESTED_PROC_DESC'] = $omr['SCHEDULED_PROC_DESC']; // 
		$omr['SCHEDULED_PROC_STATUS'] = '120'; // permintaan baru
		$omr['STUDY_INSTANCE_UID'] = '1.2.840.113619.2.55.3.2831178355.675.0128378.202003000002';
		$omr['IMAGING_REQUEST_COMMENTS'] = $result['IMAGING_REQUEST_COMMENTS'];

		//$omr = $result;


		$str = implode('|', $omr);
		// write_file(APPPATH.'/'.$omr['PATIENT_NAME'].'-'.$omr['ACCESSION_NO'].'.txt', $str);
		// if(!file_put_contents('c:\\WinNMP\pacs_order\\'.$omr['PATIENT_NAME'].'-'.$omr['ACCESSION_NO'].'.txt', $str)){
		// 	echo 'gagal disimpan';
		// }else{
		// 	echo 'sukses';
		// }
		// disini ==+=====+++====+===+===+====+==+
		if (!file_put_contents('z:\\' . $omr['PATIENT_ID'] . $count . '.txt', $str)) {
		} else {
			file_put_contents('C:\\PACS_ORDER_ERROR\\' . $omr['PATIENT_ID'] . $count . '.txt', $str);
		}

		// sampe sini ==================================

	}


	public function autocomplete_search()
	{
		$keyword = $_GET['term'];
		$data = $this->db->select('idkel_tind, idtindakan,nmtindakan')
			->from('jenis_tindakan_rad')
			->like('UPPER(nmtindakan)', strtoupper($keyword))
			->or_like('UPPER(idtindakan)', strtoupper($keyword))->limit(20, 0)->get();
		$arr = '';
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$new_row['label'] = $row['idtindakan'] . ' - ' . $row['nmtindakan'];
				$new_row['value'] = $row['idtindakan'] . ' - ' . $row['nmtindakan'];
				$new_row['idtindakan'] = $row['idtindakan'];
				$new_row['idkel_tind'] = $row['idkel_tind'];
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {
			echo json_encode([]);
		}
	}

	public function update_rujukan_penunjang()
	{
		$no_register = $this->input->post('no_register');
		$no_medrec = $this->input->post('no_medrec');
		$diag_klinis = $this->input->post('diag_klinis');
		$getrdrj = substr($no_register, 0, 2);
		if ($no_register == null) {
			echo json_encode(array('status' => false));
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				$data['rad'] = 1;
				$data['cetak_rad'] = 1;
				$data['jadwal_rad'] = date("Y-m-d H:i:s");
				$data['diag_klinis_rad'] = $diag_klinis;
				$id = $this->radmdaftar->update_rujukan_penunjang_irj($data, $no_register);
			} else {
				$data['rad'] = 1;
				$data['cetak_rad'] = 1;
				$data['jadwal_rad'] = date("Y-m-d H:i:s");
				$data['diag_klinis_rad'] = $diag_klinis;
				$id = $this->radmdaftar->update_rujukan_penunjang_iri($data, $no_register);
			}

			// $data['status_rad']=0;		

			if ($id == true) {
				echo json_encode(array('status' => true));
				//redirect('rad/radcdaftar/cetak_permintaan_order/'.$no_register.'/'.$no_medrec);
			} else {
				echo json_encode(array('status' => false));
				//redirect('rad/radcdaftar/cetak_permintaan_order/'.$no_register.'/'.$no_medrec);		
			}
		}

		//redirect('rad/radcdaftar/cetak_order/'.$no_register);
	}

	public function cetak_order_new($noreg = '')
	{
		$data['no_rad'] = $noreg;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order($noreg)->row();
		if (!empty($data['data_pasien'])) {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order($noreg)->row();
			$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_noreg_new($noreg)->result();
			$data['diagnosa'] = $this->radmdaftar->get_diagnosa_order($noreg)->result();
			$login_data = $this->load->get_var("user_info");
			$name  = $this->radmdaftar->get_ttd_by_userid($login_data->userid)->row();
			$data['user'] = strtoupper($name->name);
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			if (substr($noreg, 0, 2) == 'RI') {
				$data['asal'] = $data['data_pasien']->ruang;
			} else if (substr($noreg, 0, 2) == 'RJ') {
				$data['asal'] = $data['data_pasien']->bed;
			}

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/order_rad', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_rad',$data);
		} else {

			$success = 	'<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Data Pasien Tidak Sesuai
       		</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('rad/radcdaftar/list_tindakan_order/' . $noreg);
		}
	}

	public function cetak_order($noreg = '')
	{
		$data['no_rad'] = $noreg;
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order($noreg)->row();
		if (!empty($data['data_pasien'])) {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order($noreg)->row();
			$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_by_noreg($noreg)->result();
			$data['diagnosa'] = $this->radmdaftar->get_diagnosa_order($noreg)->result();
			$login_data = $this->load->get_var("user_info");
			$name  = $this->radmdaftar->get_ttd_by_userid($login_data->userid)->row();
			$data['user'] = strtoupper($name->name);
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			if (substr($noreg, 0, 2) == 'RI') {
				$data['asal'] = $data['data_pasien']->ruang;
			} else if (substr($noreg, 0, 2) == 'RJ') {
				$data['asal'] = $data['data_pasien']->bed;
			}

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/order_rad', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_rad',$data);
		} else {

			$success = 	'<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Data Pasien Tidak Sesuai
       		</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('rad/radcdaftar/list_tindakan_order/' . $noreg);
		}
	}

	public function cetak_permintaan_bhp($id_pemeriksaan)
	{
		$conf = $this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order_bhp($id_pemeriksaan)->row();
		$noreg = $data['data_pasien']->no_register;
		$data['noreg'] = $noreg;
		if (!empty($data['data_pasien'])) {
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['data_pasien'] = $this->radmdaftar->get_data_pasien_order_bhp($id_pemeriksaan)->row();
			$data['data_pemeriksaan'] = $this->radmdaftar->get_data_pemeriksaan_bhp($id_pemeriksaan)->result();
			$data['nama_pemeriksaan'] = $this->radmdaftar->get_jenis_tindakan($id_pemeriksaan)->row()->jenis_tindakan;
			$login_data = $this->load->get_var("user_info");
			$name  = $this->radmdaftar->get_ttd_by_userid($login_data->userid)->row();
			$data['user'] = strtoupper($name->name);
			$tahun_lahir = substr($data['data_pasien']->tgl_lahir, 0, 4);
			$tahun_now = date('Y');
			$data['tahun'] = intval($tahun_now) - intval($tahun_lahir);
			if (substr($noreg, 0, 2) == 'RI') {
				$data['asal'] = $data['data_pasien']->ruang;
			} else if (substr($noreg, 0, 2) == 'RJ') {
				$data['asal'] = $data['data_pasien']->bed;
			}

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('paper_css/order_rad_bhp', $data, true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_rad',$data);
		} else {

			$success = 	'<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            <h3>Data Pasien Tidak Sesuai
       		</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('rad/radcdaftar/list_tindakan_order/' . $noreg);
		}
	}

	public function batal_kunjung($no_register, $pelayan = '', $id_poli = '')
	{
		$cek = $this->radmdaftar->batal_kunjungan($no_register);
		if ($cek == false) {
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> No Register Tidak Ditemukan</div>');
		} else {
			$this->session->set_flashdata('warning', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-success"><i class="fa fa-success"></i>Berhasil</h3></div>');
		}
		$this->radmdaftar->delete_order_batal($no_register);
		if ($pelayan == '') {
			redirect('rad/radcdaftar');
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				if ($id_poli == 'BA00') {
					redirect('ird/rdcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
				} else {
					redirect('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register);
				}
			} else {
				redirect('iri/rictindakan/index/' . $no_register);
			}
		}
	}

	public function save_pemeriksaan_bius()
	{
		$data['no_register'] = $this->input->post('no_register');
		$data['komen'] = $this->input->post('komen');
		$data['no_medrec'] = $this->input->post('no_medrec');
		//$data['id_tindakan']='BA0312';
		$data['id_tindakan'] = $this->input->post('idtindakan');
		$data['kelas'] = $this->input->post('kelas_pasien');
		$id_dokter = explode('-', $this->input->post('dokter_anestesi'))[0];
		$nmdokter = explode('-', $this->input->post('dokter_anestesi'))[2];
		// $data['tgl_kunjungan']=date('Y-m-d H:i:s');
		$data_tindakan = $this->radmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach ($data_tindakan as $row) {
			$data['jenis_tindakan'] = $row->nmtindakan;
			$data['modality'] = $row->modality;
		}
		$data['qty'] = '1';
		$data['biaya_rad'] = $this->radmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
		$data['vtot'] = intval($data['biaya_rad']);
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['xinput'] = $this->input->post('xuserid');
		$data['id_dokter'] = $id_dokter;
		$data['nm_dokter'] = $nmdokter;
		$data['jadwal'] = date("Y-m-d H:i:s");
		$no_register = $this->input->post('no_register');
		$cek_pasien_apa = substr($no_register, 0, 2);
		if ($cek_pasien_apa == 'RI') {
			$cek_radiologi = $this->radmdaftar->cek_radiologi($no_register)->row();
		} else {
			$cek_radiologi = $this->radmdaftar->cek_radiologirj($no_register)->row();
		}
		if ($cek_radiologi == false) {
			$datafisik['pemeriksaan_penunjang_dokter'] = '-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)' . ' <br>';
			$datafisik['no_register'] = $no_register;
			$this->radmdaftar->insert_data_soap($datafisik);
		} else {
			$id = $cek_radiologi->id;
			$datafisik['pemeriksaan_penunjang_dokter'] = $cek_radiologi->pemeriksaan_penunjang_dokter . '<br>-' . ' ' . $data['jenis_tindakan'] . ' ' . '(R)';
			$this->radmdaftar->update_data_soap($datafisik, $id);
		}
		$cek = $this->radmdaftar->insert_pemeriksaan($data);
		if ($cek == true) {
			echo json_encode(array("status" => TRUE));
		} else {
			echo json_encode(array("status" => FALSE));
		}
	}


	public function batal_kunjungsad($no_register, $no_rad)
	{
		$cek = $this->radmdaftar->batal_kunjungan($no_register);
		if ($cek == false) {
			$this->session->set_flashdata('warning', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-danger"><i class="fa fa-warning"></i> Perhatian</h3> No Register Tidak Ditemukan</div>');
		} else {
			$this->session->set_flashdata('warning', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h3 class="text-success"><i class="fa fa-success"></i>Berhasil</h3></div>');
		}
		$this->radmdaftar->delete_order_batalsdada($no_register, $no_rad);
		redirect('rad/radcpengisianhasil');
	}

	public function get_data_pemeriksaan()
	{
		$id = $this->input->post('id');
		//var_dump($id); die();
		$datajson = $this->radmdaftar->get_data_pemeriksaan_rad($id)->result();
		echo json_encode($datajson);
	}
	public function get_data_pasien_luar()
	{
		$id = $this->input->post('id');
		//var_dump($id); die();
		$datajson = $this->radmdaftar->get_data_pasien_luar($id)->result();
		echo json_encode($datajson);
	}

	public function get_data_pemeriksaan_by_noreg()
	{
		$no_register = $this->input->post('noreg');
		//var_dump($id); die();
		$datajson = $this->radmdaftar->get_data_pemeriksaan_rad_by_noreg($no_register)->result();

		//$data['noreg'] = $datajson;
		echo json_encode($datajson);
	}

	public function tunda_tindakan()
	{
		$noreg = $this->input->post('edit_id_tunda_hidden');

		if (substr($noreg, 0, 2) == "PL") {
			$data['tgl_kunjungan'] = $this->input->post('edit_tanggal');
			$data['alasan_tunda'] = $this->input->post('alasan_tunda');
			$this->radmdaftar->tunda_tindakan_pl($noreg, $data);
			redirect('rad/radcdaftar/list_order');
		} else if (substr($noreg, 0, 2) == "RJ") {
			$data['jadwal_rad'] = $this->input->post('edit_tanggal');
			$data['alasan_tunda_rad'] = $this->input->post('alasan_tunda');
			$this->radmdaftar->tunda_tindakan_rj($noreg, $data);
			redirect('rad/radcdaftar/list_order');
		} else {
			$data['jadwal_rad'] = $this->input->post('edit_tanggal');
			$data['alasan_tunda_rad'] = $this->input->post('alasan_tunda');
			$this->radmdaftar->tunda_tindakan_ri($noreg, $data);
			redirect('rad/radcdaftar/list_order');
		}
		//print_r($data);
	}

	public function update_pasien_luar()
	{
		$no_register = $this->input->post('no_register_hide');

		$data['nama'] = $this->input->post('nama_edit');
		$data['jk'] = $this->input->post('jk_edit');
		$data['cara_bayar'] = $this->input->post('cara_bayar_edit');
		if ($data['cara_bayar'] == 'BPJS') {
			$data['nmkontraktor'] = $this->input->post('iks_bpjs');
		} else if ($data['cara_bayar'] == 'KERJASAMA') {
			$data['nmkontraktor'] = $this->input->post('iks_edit');
		} else {
			$data['nmkontraktor'] = NULL;
		}
		$data['tgl_lahir'] = date("Y-m-d", strtotime($this->input->post('tgl_lahir_edit')));
		$data['alamat'] = $this->input->post('alamat_edit');
		$data['dokter'] = $this->input->post('dokter_edit');
		$data['diagnosa'] = $this->input->post('diagnosa_edit');
		$data['no_hp'] = $this->input->post('no_hp_edit');
		$data['email'] = $this->input->post('email_edit');

		$this->radmdaftar->update_pasien_luar($data, $no_register);
		redirect('rad/radcdaftar/list_order');
	}

	public function insert_petugas_tindakan()
	{
		$noreg = $this->input->post('edit_id_radiografer_hidden');
		$no_register = $this->input->post('no_register_modal_petugas');

		$id_radiografer = explode('@', $this->input->post('radiografer'))[0];
		$username = explode('@', $this->input->post('radiografer'))[1];

		$data['xuser'] = $username;
		$data['id_radiografer'] = $id_radiografer;

		$this->radmdaftar->insert_petugas_tindakan($noreg, $data);
		redirect('rad/radcdaftar/pemeriksaan_rad/' . $noreg);
	}

	public function insert_catatan_bhp()
	{
		$noreg = $this->input->post('edit_id_bhp_hidden');

		//$data['catatan_bhp'] = $this->input->post('edit_bhp');
		$data['catatan_bhp'] = str_replace(["<p>", "</p>", "&nbsp;", "
		", "
		"], "", $this->input->post('edit_bhp'));
		$data['bhp_total'] = $this->input->post('bhp_total');
		$data['bhp_gagal'] = $this->input->post('bhp_gagal');

		$this->radmdaftar->insert_catatan_bhp($noreg, $data);
	}

	public function insert_ulang_tindakan()
	{
		$noreg = $this->input->post('edit_id_hidden');
		$no_register = $this->input->post('noreg_ulang');

		$data_rad = $this->radmdaftar->get_data_pemeriksaan_rad($noreg)->result();
		foreach ($data_rad as $row) {
			$ulang = $row->ulang;
		}
		$ulang = $ulang + 1;

		$data['ulang'] = $ulang;
		$data['alasan_ulang'] = $this->input->post('alasan');
		$data['alasan_ulang_detail'] = $this->input->post('text_lain');
		//$data['bhp_gagal'] = $this->input->post('bhp_gagal');

		$this->radmdaftar->insert_ulang_tindakan($noreg, $data);
		redirect('rad/radcdaftar/pemeriksaan_rad/' . $noreg);
	}

	public function update_waktu_masuk()
	{
		$no_register = $this->input->post('no_register');

		if (substr($no_register, 0, 2) == "RJ") {
			$data_update['waktu_masuk_rad'] = date("Y-m-d H:i:s");
			$result = $this->radmdaftar->update_waktu_masuk_rj($no_register, $data_update);
			echo json_encode($result);
		} else if (substr($no_register, 0, 2) == "RI") {
			$data_update['waktu_masuk_rad'] = date("Y-m-d H:i:s");
			$result = $this->radmdaftar->update_waktu_masuk_ri($no_register, $data_update);
			echo json_encode($result);
		} else if (substr($no_register, 0, 2) == "PL") {
			$data_update['waktu_masuk_rad'] = date("Y-m-d H:i:s");
			$result = $this->radmdaftar->update_waktu_masuk_pl($no_register, $data_update);
			echo json_encode($result);
		}
	}

	public function cetak_permintaan_order($no_register = '')
	{
		$data['title'] = 'Cetak Permitaan Order';
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
		$data['logo_header'] =  "logo.png";
		//$data['kode_document'] = $this->m_emedrec->get_kode_document('cppt_iri');
		$data['data_pasien'] = $this->radmkwitansi->get_data_pasien_order($no_register)->result();
		//var_dump($data['data_pasien']); die();
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
		//$mpdf->curlAllowUnsafeSslRequests = true;		
		$html = $this->load->view('rad/paper_css/cetak_permintaan', $data, true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function cetak_label($no_ipd)
	{
		error_reporting(~E_ALL);
		if ($no_ipd != '') {
			//var_dump($no_ipd);die();
			$data_pasien = $this->radmdaftar->get_pasien_by_no_ipd($no_ipd)->row();
			//var_dump($data_pasien->nama);die();
			// print_r($data_pasien);die();
			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('50', '100'), true, 'UTF-8', false);
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
			$obj_pdf->SetMargins('0', '1', '3', '1'); //left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 12);
			$obj_pdf->setFontSubsetting(false);
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
			// $obj_pdf->Rotate(-90, 1, 1);
			// $obj_pdf->Translate(20, -47);
			//$obj_pdf->SetXY(0, 10);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128, 0, 0),
				'bgcolor' => false,
			);

			// $params = $obj_pdf->serializeTCPDFtagParameters(array($no_ipd, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));
			$params = $obj_pdf->serializeTCPDFtagParameters(array($data_pasien->no_medrec, 'C128', '', '', 50, 9, 0.4, array('position' => 'T', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 5, 'stretchtext' => 4), 'N'));

			// print_r($data_pasien[0]);die();


			//foreach($data_pasien as $row){
			//var_dump($row);die();
			//$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));
			//$no_medrec = $row->no_medrec;
			// $html="<b align=\"center\"><u>RS MMC PALEMBANG</u></b>";
			// $html.=
			// "
			// 	<br/>
			// 	<style type=\"text/css\">
			// .table-font-size{
			// 	margin-top:9px;
			//     }
			// .nama-pasien{
			// 	font-size:9px;
			//     }
			// </style>
			// <table class=\"table-font-size\" border=\"0\" width=\"300px\">
			// 		<tr>
			// 			<td colspan=\"2\">Medrec : ".$row['no_cm']."</td>
			// 		</tr>
			// 		<tr>
			// 			<td colspan=\"2\">No Register : $no_ipd</td>
			// 		</tr>
			// 		<tr>
			// 			<td align=\"left\" class=\"nama-pasien\"><b>".$row['nama']."</b></td>
			// 		</tr>
			// 		<tr>
			// 			<td>Tgl. Lahir : $tgl_lahir</td>
			// 			<td>JK : ".$row['sex']."</td>
			// 		</tr>
			// 		<tr>
			// 			<td colspan=\"2\">Dokter : ".$row['dokter']."</td>
			// 		</tr>
			// </table>
			// ";



			$html .=
				"
					<br/>
					<style type=\"text/css\">
					.table-font-size{
						margin-top:9px;
						}
					.nama-pasien{
						font-size:8px;
						}
					.rs{
						font-size:7px;
						}
					.list{
						font-size:7px;
						}
				</style>
				<table class=\"table-font-size\" border=\"0\" width=\"250px\">
				<tr>
					<td colspan=\"2\" class=\"nama-pasien\"><b>" . $data_pasien->nama . "     (" . $data_pasien->sex . ")</b></td>
				</tr>
				<tr>
					<td class=\"list\" width=\"30%\"><b>" . $data_pasien->no_identitas . "</b><br>
					" . $data_pasien->no_medrec . "<br>
					Lhr : " . date("d-m-Y", strtotime($data_pasien->tgl_lahir)) . "
					</td>

					<td width=\"70%\">";
			$html .= '		<tcpdf method="write1DBarcode" params="' . $params . '" />';
			$html .= "
					</td>
				</tr>
				<tr>
					<td colspan=\"2\" class=\"rs\"><b>RS. OTAK DR. Drs. M.HATTA BUKITTINGGI</b></td>
				</tr>
				</table>
				";
			//}




			$style = array(
				'fgcolor' => array(0, 0, 0),
				'bgcolor' => false
			);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			// $obj_pdf->AddPage();
			// $obj_pdf->writeHTML($html, true, 0, true, 0);
			$obj_pdf->AddPage();
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			$obj_pdf->Translate(20, 0);

			// $obj_pdf->Text(3, 44, $nrp);

			// $obj_pdf->Text(3, 22, $no_cm);
			// $obj_pdf->Text(3, 27, $nama.' ('.$row->sex.')');
			// $obj_pdf->Text(3, 32, $tgl_lahir);



			// Stop Transformation
			$obj_pdf->StopTransform();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		} else {
			redirect('iirj/rjcpelayanan/kunj_pasien_poli', 'refresh');
		}
	}

	public function batal_pemeriksaan($id_pemeriksaan, $noreg)
	{
		$this->radmdaftar->batal_pemeriksaan($id_pemeriksaan);
		// redirect('rad/radcdaftar/pemeriksaan_rad/'.$id_pemeriksaan);
		redirect('rad/radcdaftar/');
	}

	public function update_flag_dokter()
	{
		$data_update = $this->radmdaftar->get_update_flag_dokter()->result();
		// var_dump($data_update);die();
		foreach ($data_update as $val) {
			$data['hasil_simpan'] = 1;
			$this->radmdaftar->update_flag_hasil_simpan($val->id_pemeriksaan_rad, $data);
		}
		redirect('rad/radcdaftar');
	}

	public function batal_pemeriksaan_rad($no_register)
	{
		
		$this->radmdaftar->batal_kunjungan($no_register);
		
		$this->radmdaftar->delete_order_batal($no_register);
		
		redirect('rad/radcdaftar'); 
		
	}
}
