<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'controllers/irj/Rjcterbilang.php');
class Utdcdaftar extends Secure_area {

    public function __construct(){
		parent::__construct();
		
		$this->load->model('utdrs/Utdmdaftar','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
	}

    public function index(){
		$date=$this->input->post('date');
		$key=$this->input->post('key');
		if(!empty($date)){
			$data['title'] = 'DAFTAR PASIEN UNIT TRANSFUSI DARAH Tanggal '.date('d-m-Y',strtotime($date));
			$data['utd']=$this->Utdmdaftar->get_daftar_pasien_pa_by_date($date)->result();
		}else if(!empty($key)){
			$data['title'] = 'DAFTAR PASIEN UNIT TRANSFUSI DARAH | '.$key;
			$data['utd']=$this->Utdmdaftar->get_daftar_pasien_pa_by_no($key)->result();
		}else{
			$data['title'] = 'DAFTAR PASIEN UNIT TRANSFUSI DARAH Tanggal '.date('d-m-Y');
			$data['utd']=$this->Utdmdaftar->get_daftar_pasien_pa_by_date(date('Y-m-d'))->result();
		}

		$this->load->view('utdrs/utdvdaftarpasien',$data);
	}

    public function pemeriksaan_utdrs($no_register = '', $pelayan = ''){

		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Transfusi Darah Pasien';
		$data['no_register']=$no_register;
        $data['data_pasien_pemeriksaan']=$this->Utdmdaftar->get_data_pasien_pemeriksaan($no_register)->result();
        foreach($data['data_pasien_pemeriksaan'] as $row){
            $data['nama']=$row->nama;
            $data['no_cm']=$row->no_cm;
            $data['no_medrec']=$row->no_medrec;
            $data['kelas_pasien']=$row->kelas;				
            $data['tgl_kun']=$row->tgl_kunjungan;
            $data['idrg']=$row->idrg;
            $data['bed']=$row->bed;
            $data['cara_bayar']=$row->cara_bayar;	
            $data['tgl_periksa']=$row->tgl_kunjungan;			
            if($row->foto==NULL){
                $data['foto']='unknown.png';
            }else {
                $data['foto']=$row->foto;
            }
			
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->Utdmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';

				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->Utdmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['data_pemeriksaan']=$this->Utdmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['tindakan_histo']=$this->Utdmdaftar->getdata_tindakan_utdrs()->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->Utdmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$data['dokter']=$this->Utdmdaftar->getdata_dokter()->result();

		$this->load->view('utdrs/utdvpemeriksaan',$data);
	}

	public function insert_pemeriksaan()
	{
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['kelas']=$this->input->post('kelas_pasien');
		if($this->input->post('tgl_periksa')!=''){
			$data['tgl_kunjungan']=$this->input->post('tgl_periksa');
		}else $data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');
		$data['id_tindakan']=$this->input->post('idtindakan_h');
		$data_tindakan=$this->Utdmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}


		$data['qty']=$this->input->post('qty_h');
		$data['id_dokter']=$this->input->post('id_dokter_h');
		$data_dokter=$this->Utdmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_utd']=$this->input->post('biaya_pa_hide_h');
		$data['vtot']=$this->input->post('vtot_hide_h');

		$this->Utdmdaftar->insert_pemeriksaan($data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_utd='')
	{
		$this->Utdmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_utd);
        echo json_encode(array("status" => $id_pemeriksaan_utd));
		
	}	

	public function update_rujukan_penunjang()
	{
		$no_register = $this->input->post('no_register');
		if ($no_register == null) {
			echo json_encode(array('status' => false));
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				$data['utdrs'] = 1;
				$id = $this->Utdmdaftar->update_rujukan_penunjang_irj($data, $no_register);
			} else {
				$data['utdrs'] = 1;
				$id = $this->Utdmdaftar->update_rujukan_penunjang_iri($data, $no_register);
			}	

			if ($id == true) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR PA DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getrdrj=substr($no_register, 0,2);

		$this->Utdmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_utdrs=$this->Utdmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_utdrs;

		 if($getrdrj=="RJ"){
			$this->Utdmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$no_utdrs);
		}
		else if ($getrdrj=="RD"){
			$this->Utdmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$no_utdrs);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->Utdmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_utdrs=$row->status_utdrs;
			}
			$status_utdrs = $status_utdrs + 1;
			$this->Utdmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_utdrs,$no_utdrs);
		}

		redirect("utdrs/utdcdaftar/cetak_faktur/$no_utdrs");
		
	}

	public function cetak_faktur($no_utdrs='')
	{
		$data['no_utdrs'] = $no_utdrs;
		$jumlah_vtot=$this->Utdmdaftar->get_vtot_no_utdrs($no_utdrs)->row()->vtot_no_utdrs;
		if($no_utdrs!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$data['logo_kesehatan_header'] = "kementriankesehatan.png";
			$data['logo_header'] =  "logo.png";
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
			$data['tgl'] = date("d-m-Y");
			$data['data_pasien']=$this->Utdmdaftar->get_data_pasien($no_utdrs)->row();
			$data['data_pemeriksaan']=$this->Utdmdaftar->get_data_pemeriksaan_faktur($no_utdrs)->result();
			$cterbilang = new rjcterbilang();
			$jumlah_vtot0 = 0;
			foreach ($data['data_pemeriksaan'] as $row) {
				$jumlah_vtot0 = $jumlah_vtot0 + $row->vtot;
			}
			$vtot_terbilang = $cterbilang->terbilang($jumlah_vtot0);
			$data['vtot_terbilang'] = $vtot_terbilang;
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->name);
		
			

			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
			$mpdf->curlAllowUnsafeSslRequests = true;

			$html = $this->load->view('faktur', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();

			// $this->load->view('paper_css/faktur', $data);
		}else{
			redirect('utdrs/utdcdaftar/','refresh');
		}
	}

}