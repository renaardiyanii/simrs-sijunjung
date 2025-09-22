<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcjadwal extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Mmjadwal', '', TRUE);
		$this->load->model('irj/rjmpencarian', '', TRUE);
	}


	public function index()
	{
		$this->load->view('master/mvjadwal', [
			'title' => 'Jadwal Dokter'
		]);
	}

	public function jadwaldoktersebulan()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->Mmjadwal->jadwalSebulan()->result());
	}

	public function getpoli()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->Mmjadwal->getallpoli()->result());
	}

	public function getdokter($id_poli)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->Mmjadwal->getDokter($id_poli)->result());
	}

	public function updatejadwaldokter()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->input->post();
		$insert = $this->Mmjadwal->updateJadwalDokterBatch($data, $data['id']);
		echo json_encode(
			[
				'code' => $insert ? 200 : 400
			]
		);
	}

	public function hapusjadwaldokter($id)
	{
		header('Content-Type: application/json; charset=utf-8');
		$hapus = $this->Mmjadwal->hapusJadwalDokter($id);
		echo json_encode(
			[
				'code' => $hapus ? 200 : 400
			]
		);
	}

	public function insertjadwaldokter()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->input->post();
		// var_dump($data);die();
		$data_batch = [];
		foreach (explode(',', $data['tgl']) as $tgl) {
			array_push($data_batch, [
				'id_poli' => $data['id_poli'],
				'id_dokter' => $data['id_dokter'],
				'tgl' => date('Y-m-d', strtotime($tgl)),
				'awal' => $data['mulai'],
				'akhir' => $data['selesai']
			]);
		}
		$insert = $this->Mmjadwal->insertJadwalDokterBatch($data_batch);
		echo json_encode(
			[
				'code' => $insert ? 200 : 400
			]
		);
	}

	public function index_old()
	{
		$data['title'] = 'Master Jadwal';
		$data['dokter'] = $this->Mmjadwal->get_all_dokter()->result();
		$data['jadwal'] = $this->Mmjadwal->get_all_jadwal()->result();
		$data['poli'] = $this->rjmpencarian->get_poliklinik()->result();
		$this->load->view('master/mvjadwal', $data);
	}

	public function insert_jadwal()
	{
		$data['id_dokter'] = $this->input->post('dokter');
		$data['id_poli'] = $this->input->post('poli');
		$data['hari'] = $this->input->post('hari');
		$data['awal'] = $this->input->post('awal');
		$data['akhir'] = $this->input->post('akhir');
		$data['status'] = 0;
		$this->Mmjadwal->insert_jadwal_dokter($data);


		redirect('master/Mcjadwal');
		//print_r($data);
	}

	public function get_data_edit_jadwal()
	{
		$id = $this->input->post('id');
		$datajson = $this->Mmjadwal->get_data_jadwal($id)->result();
		echo json_encode($datajson);
	}

	public function edit_jadwal()
	{
		$id = $this->input->post('edit_id_hidden');
		$data['hari'] = $this->input->post('edit_hari');
		$data['awal'] = $this->input->post('edit_awal');
		$data['akhir'] = $this->input->post('edit_akhir');
		$this->Mmjadwal->edit_jadwal($id, $data);
		redirect('master/Mcjadwal');
		//print_r($data);
	}
	public function delete_jadwal_dokter($id = '')
	{
		$data['deleted'] = '1';
		$datajson = $this->Mmjadwal->delete_jadwal_dokter($id);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Jadwal Dokter dengan ID "' . $id . '" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/Mcjadwal', 'refresh');
	}

	public function soft_delete_jadwal_dokter($id = '')
	{
		$data['status'] = '1';
		$datajson = $this->Mmjadwal->soft_delete_jadwal_dokter($id, $data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Jadwal Dokter dengan ID "' . $id . '" berhasil di non-aktifkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		echo json_encode($datajson);
		// redirect('master/Mcjadwal','refresh');
	}

	public function active_jadwal_dokter($id = '')
	{
		$data['status'] = '0';
		$datajson = $this->Mmjadwal->active_jadwal_dokter($id, $data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Jadwal Dokter dengan ID "' . $id . '" berhasil di aktifkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		// redirect('master/Mcjadwal','refresh');
		echo json_encode($datajson);
	}
}
