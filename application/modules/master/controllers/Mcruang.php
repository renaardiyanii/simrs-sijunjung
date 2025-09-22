<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Mcruang extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmruang','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Ruangan';

		$data['ruang']=$this->mmruang->get_all_ruang()->result();
		$data['bed']=$this->mmruang->get_all_bed()->result();
		$data['kelas']=$this->mmruang->get_all_kelas()->result();
		$this->load->view('master/mvruang',$data);
		//print_r($data);
	}

	// public function insert_ruang(){

	// 	$ruang['idrg']=$this->input->post('ruang_noruangan');
	// 	$ruang['nmruang']=$this->input->post('ruang_nmruangan');
	// 	$ruang['lokasi']=$this->input->post('ruang_lokasiruangan');
	// 	$ruang['aktif']='Active';
	// 	/*$ruang['VVIP']=$this->input->post('vvip');
	// 	$ruang['VIP']=$this->input->post('vip');
	// 	$ruang['UTAMA']=$this->input->post('utama');
	// 	$ruang['I']=$this->input->post('i');
	// 	$ruang['II']=$this->input->post('ii');
	// 	$ruang['III']=$this->input->post('iii');*/
	// 	$this->mmruang->insert_ruang($ruang);

	// 	$tindakan['idtindakan']='1A'.$ruang['idrg'];
	// 	$tindakan['nmtindakan']=$this->input->post('ruang_nmruangan');
	// 	$tindakan['idpok1']='1';
	// 	$tindakan['idpok2']='1A';

	// 	$this->mmruang->insert_tindakan($tindakan);
	// 	$tarif['id_tindakan']=$tindakan['idtindakan'];
	// 	$tarif['idrg']=$this->input->post('ruang_noruangan');
	// 	$tarif['kelas']='III';
	// 	$this->mmruang->insert_tarif($tarif);
		
	// 	redirect('master/Mcruang');
	// 	// print_r($ruang);
	// }

	public function insert_ruang(){

		$ruang['idrg']=$this->input->post('ruang_noruangan');
		$ruang['nmruang']=$this->input->post('ruang_nmruangan');
		$ruang['kelas']=$this->input->post('ruang_kelas');
		$ruang['aktif']='Active';
		if($ruang['jumlah_tt'] != ''){
			$ruang['jumlah_tt']=$this->input->post('jumlah_tt');
		}else{
				$ruang['jumlah_tt']='0';
		}
		
		$this->mmruang->insert_ruang($ruang);

		$tindakan['idtindakan']='1A'.$ruang['idrg'];
		$tindakan['nmtindakan']=$this->input->post('ruang_nmruangan');
		$tindakan['idpok1']='1';
		$tindakan['idpok2']='1A';
		$tindakan['tarif']= $this->input->post('ruang_tarif');
		$this->mmruang->insert_tindakan($tindakan);
		
		redirect('master/Mcruang');

	}

	public function get_data_edit_ruang(){
		$idrg=$this->input->post('idrg');
		$datajson=$this->mmruang->get_data_ruang($idrg)->result();
		// var_dump($datajson);
		// die();
		echo json_encode($datajson);
	}

	public function get_data_edit_bed(){
		$bed=$this->input->post('bed');
		$datajson=$this->mmruang->get_data_bed($bed)->result();
	    echo json_encode($datajson);
	}

	public function edit_ruang(){
		$id_ruang=$this->input->post('edit_id_ruang_hidden');
		$idrg=$this->input->post('edit_idrg_hidden');
		$nmruang=$this->input->post('edit_nmruang');
		$kelas=$this->input->post('edit_kelas_ruang');
		$status=$this->input->post('edit_aktif');

		$jumlah_tt=$this->input->post('edit_jumlah_tt');
		if($jumlah_tt != ''){
				$data['jumlah_tt']=$this->input->post('edit_jumlah_tt');
		}else{
				$data['jumlah_tt']='0';
		}
	
		$data['aktif']='Active';

	
		$data['nmruang']=$nmruang;
		$data['kelas']=$kelas;
		$data['aktif']=$status;
		$this->mmruang->edit_ruang($idrg, $data);
		
		redirect('master/Mcruang');

	}

	public function edit_bed(){
		$bed=$this->input->post('edit_bed_hidden');
		$no_bed=$this->input->post('edit_no_bed_hidden');
		$idrg=$this->input->post('edit_idrg_hidden');
		$kls=$this->input->post('edit_kelas');
		$data['isi']=$this->input->post('edit_isi');
		$data['status']=$this->input->post('edit_status');

		$data['idrg']=$this->input->post('edit_nmruang_bed');
		$data['kelas']=$this->input->post('edit_kelas');

		$kls=$this->input->post('edit_kelas');
		if($kls=='VVIP'){
			$kelas='VV';
		} else if($kls=='VIP'){
			$kelas='VP';
		} else if($kls=='UTAMA'){
			$kelas='UT';
		} else if($kls=='I'){
			$kelas='10';
		} else if($kls=='II'){
			$kelas='20';
		} else if($kls=='III'){
			$kelas='30';
		}

		$data['bed']=$data['idrg'].' '.$kelas.' '.$no_bed;
		// var_dump($data);
		// die();
		$this->mmruang->edit_bed($bed, $data);
		
		redirect('master/Mcruang');
		//print_r($data);
	}

	public function get_banyak_bed(){
		$idrg=$this->input->post('idrg');
		$kelas=$this->input->post('kelas');
		$datajson=$this->mmruang->get_banyak_bed($idrg, $kelas)->result();
	    echo json_encode($datajson);
	}

	public function insert_bed(){
		$data['idrg']=$this->input->post('idrg');
		$data['kelas']=$this->input->post('kelas');
		$no_bed=$this->input->post('no_bed_hidden');
		$no_bed++;
		if($no_bed<10){
			$no_bed='0'.$no_bed;
		}
		$kls=$this->input->post('kelas');
		if($kls=='VVIP'){
			$kelas='VV';
		} else if($kls=='VIP'){
			$kelas='VP';
		} else if($kls=='UTAMA'){
			$kelas='UT';
		} else if($kls=='I'){
			$kelas='10';
		} else if($kls=='II'){
			$kelas='20';
		} else if($kls=='III'){
			$kelas='30';
		}
	 
		$data['isi']='N';
		$data['status']=$this->input->post('status');
		$data['bed']=$data['idrg'].' '.$kelas.' '.$no_bed;
		$this->mmruang->insert_bed($data);
		
		redirect('master/Mcruang');
	
	}

	public function hapus_bed(){
		$bed=$this->input->post('bed');
		$this->mmruang->delete_bed($bed);
		
		redirect('master/Mcruang');
		//print_r($this->mmruang->delete_bed($bed));
	}

	public function nonaktif_bed(){
		$bed=$this->input->post('bed');
		$isi = $this->input->post('isi');
		// var_dump($bed);die();
		$this->mmruang->nonaktif_bed($bed,$isi);
		redirect('master/Mcruang');
	}

	public function soft_delete_ruang($id_ruang){
		$data['aktif'] = 'Non-Active';
		$result = $this->mmruang->soft_delete_ruang($id_ruang,$data);
		echo json_encode($result);
		// redirect('master/Mcruang');
	}

	public function active_ruang($id_ruang){
		$data['aktif'] = 'Active';
		$this->mmruang->active_ruang($id_ruang,$data);
		redirect('master/Mcruang');
	
	}

	public function allruang()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data['ruang']=$this->mmruang->get_all_ruang_aktif()->result();
		echo json_encode($data['ruang']);
	}
	
	public function getallbedaktif()
	{
		header('Content-Type: application/json; charset=utf-8');
		$data['ruang']=$this->mmruang->get_all_bed_aktif()->result();
		echo json_encode($data['ruang']);
	}

	public function insert_jkn_kelas()
	{
		header('Content-Type: application/json; charset=utf-8');

		$data = $this->input->post();
		$key = count(array_keys($data))==1?array_keys($data)[0]:null;
		if($key)
		{
			$kelas = explode('-',$key)[1];
			$list_bed = $data[$key];
			$dt = [];
			foreach($list_bed as $bd)
			{
				array_push($dt,[
					'bed'=>$bd,
					'kelasjkn'=>$kelas
				]);
			}
			// var_dump($dt);
			$res = $this->db->update_batch('bed', $dt, 'bed');
			if($res)
			{
				echo json_encode([
					'code'=>200,
					'message'=>'Data Berhasil Disimpan'
				]);
				return;
			}
			echo json_encode([
				'code'=>500,
				'message'=>'Data Gagal Disimpan'
			]);
			return;
		}
		echo json_encode([
			'code'=>500,
			'message'=>'Data Gagal Disimpan,silahkan pilih kelas yang benar'
		]);
		return;
	}

}