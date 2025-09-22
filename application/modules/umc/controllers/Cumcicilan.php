<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// include('Rjcterbilang.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once(APPPATH.'controllers/Secure_area.php');
//require_once(APPPATH.'helpers/tcpdf/tcpdf.php');
// class MYPDF extends TCPDF {  
// 	//$this->load->helper('pdf_helper');
//        // Page footer
//         public function Footer() {
//             // Position at 15 mm from bottom
//             $this->SetY(-8);
//             // Set font
//             $this->SetFont('helvetica', 'I', 8);
//             // Page number
// 	date_default_timezone_set("Asia/Jakarta");			
// 	$tgl_jam = date("d-m-Y H:i:s");
//         $this->Cell(0, 0, '', 0, false, 'L', 0, '', 0, false, 'T', 'M');    
// 	$this->Cell(0, 10, $this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');  
//         }      
//     }
class Cumcicilan extends Secure_area{
	public function __construct() {
		parent::__construct();

		$this->load->model('umc/Mumcicilan','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
		$this->load->model('iri/rimpasien','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		// $cterbilang=new rjcterbilang();
		// echo $cterbilang->terbilang(100);
		redirect('irj/rjcregistrasi','refresh');
	}
	
	public function irj()
	{
		$data['title'] = 'Daftar Uang Muka / Cicilan Pasien Rawat Jalan';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$dateawal=$this->input->post('date0');
		$dateakhir=$this->input->post('date1');
		$data['tgl_awal']=date('d-m-Y', strtotime($dateawal));
		$data['tgl_akhir']=date('d-m-Y', strtotime($dateakhir));
		if($dateawal=='' && $dateakhir=='')
		{
			$data['tgl_awal']=date('d-m-Y', strtotime('-7 days', time()));
			$dateawal=date('Y-m-d', strtotime('-7 days', time()));
			$dateakhir=date('Y-m-d');
			$data['tgl_akhir']=date('d-m-Y');
		}
		$data['url']='';
		$data['pasien_umc']=$this->mumcicilan->get_all_pasien_cicilan_irj($dateawal,$dateakhir)->result();
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('umc/umcviewlist',$data);
	}

	public function input_irj($no_medrec='')
	{
		$data['title'] = 'Input Uang Muka / Cicilan Pasien Rawat Jalan';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		
		$data['url']='';
		$data['pasien_umc']=$this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_medrec)->row();
		$data['last_daful']=$this->rjmregistrasi->get_pasien_last_daful($no_medrec)->row();
		$data['detail_cicilan']=$this->mumcicilan->get_max_cicilan_ke($data['last_daful']->no_register)->row()->last_cicilan;
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('umc/umcviewinput',$data);
	}

	public function iri()
	{
		$data['title'] = 'Input Uang Muka / Cicilan Pasien Rawat Inap';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		$date=$this->input->post('tgl');
		if($date==''){
			$date=date('Y-m-d');
		}
		$data['url']='';
		$data['pasien_daftar']=$this->rjmkwitansi->get_pasien_kwitansi($date)->result();
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('irj/rjvkwitansi',$data);
	}

	public function cari()
	{
		$data['title'] = 'Pencarian Pasien';
		$this->load->view('umc/umcviewlistpasien',$data);	
	}

	public function pasien()
	{
		$data['data_pasien']='';
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
		}	
		else if($this->input->post('cari_no_cm_lama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_cm_lama'))->result();
		}	
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
		}else if($this->input->post('cari_no_nrp')!=''){
			//mystring.replace(/,/g , ":")
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nrp($this->input->post('cari_no_nrp'))->result();
		}
		
		// if (empty($data['data_pasien'])) 
		// {
		// 	$success = 	'<div class="alert alert-danger">
  //                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  //                           <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
  //                       </div>';
  //           echo json_encode(0);
		// 	//$this->session->set_flashdata('success_msg', $success);
		// 	//redirect('irj/rjcregistrasi');
		
		// } else {
			//echo json_encode($this->input->post('cari_no_nrp'));
			echo json_encode($data['data_pasien']);
			//$this->load->view('irj/rjvformcaripasien',$data);
		// }
		
	}


	public function input_um_irj($no_register='')
	{
		$data['title'] = 'Input Uang Muka Pasien';
		$result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		
	//	print_r($result);die();

		$data['kasir']="";
		if($result){
			$data['kasir']=$result->kasir;
		}
		
		$data['pasien_iri']=$this->Mumcicilan->get_data_pasien_iri($no_register)->row();
         
      //   print_r($data['pasien_iri']);die();

		if ($this->input->post('submit')) {
			$insert['no_medrec'] = $data['pasien_iri']->no_cm;
			$insert['no_register'] = $this->input->post('no_reg_umc');
			$insert['nominal_input'] = $this->input->post('nom_kredit');
			$insert['penyetor'] = $this->input->post('penyetor_umc');
			$insert['xuser']=$this->session->userdata('userid');
			$insert['note_umc']=$this->input->post('note_umc');
			$insert['operasi']=$this->input->post('operasi');
			$insert['dokter']=$this->input->post('dokter');
			$insert['id_dokter']=$this->input->post('id_dokter');
			$insert['id_tindakan']=$this->input->post('id_tindakan');
			$insert['tgl_cetak']= date("Y-m-d");//$this->input->post('id_tindakan');
			$insert['user_cetak']= $result->name;

           $no_register = $this->input->post('no_reg_umc');
          
           $dp = $this->input->post('nom_kredit');

           $data = array(
           		'dp' => $dp 		
           );

		
          // $data['cicilan']=$this->Mumcicilan->get_data_cicilan_noreg($no_register)->row();
       //   print_r($data['cicilan']);die();
           // if (empty($data['cicilan'])) {
            	$create = $this->Mumcicilan->insert($insert);            
                
                $update = $this->Mumcicilan->update($data, $no_register);
           // }
        // }else{
          
           redirect ('umc/cumcicilan/input_um_irj/'.$no_register,'refresh');
        
        }
            
			// $create = $this->Mumcicilan->insert($insert);            
   //          $update = $this->Mumcicilan->update($data, $no_register);
               
		$data['um_cicilans']=$this->Mumcicilan->get_data_cicilan_noreg($no_register)->result();
		
		$this->load->view('umc/umcviewinput_rj',$data);
	}
	
	public function input_bayar_langsung()
	{
		$data['title'] = 'Input Pembayaran Non Pasien';
		// $result=$this->M_user->getKasirAkses($this->session->userdata('userid'));
		// $no = '00002052-22-000001';
		// $kw = substr($no, 12) + 1;
		$data['view']=0;
		$data['bayar_langsung'] = $this->Mumcicilan->get_data_pembayaran_langsung()->result();
		$data['tgl'] = false;
		$data['no_cm'] = false;	
		foreach($data['bayar_langsung'] as $row) {
			$data['tgl'] = $row->tgl_cetak;
			$data['no_cm'] = $row->no_cm;
		} 
		// $data['cetak'] = $cetak;
		// var_dump($data['cetak']);die();

	    $data['layanan'] = $this->Mumcicilan->get_layanan()->result();

		$data['data_pasien'] =  "";
		$dataregister=$this->input->post('cari_no_cm');
		if ($dataregister != null) {
			$data['data_registrasi']=$this->rjmregistrasi->get_data_pasien_by_no_cm_noreg($this->input->post('cari_no_cm'))->result();
		}else{
			$data['data_registrasi'] = array();
		}
		// $this->console_log($data['data_registrasi']);
	
		$this->load->view('umc/viewbayarlangsung',$data);
	}

	public function insert_input_bayar_langsung() {
		// var_dump($this->input->post());die();
		$idtindakan = explode('@',$this->input->post('id_dokter_akhir'))[1];
		$nmtindakan = explode('@',$this->input->post('id_dokter_akhir'))[2];
       
		$login_data = $this->load->get_var("user_info");
		$insert['nama'] = $this->input->post('nama');
		$insert['jenis_bayar'] = $this->input->post('jenis_bayar');
		$insert['item_bayar'] = $nmtindakan;
		$insert['xuser']=$login_data->username;//$this->session->userdata('name');
		$insert['keterangan']=$this->input->post('keterangan');
		$insert['tarif']=$this->input->post('tarif');
		$insert['qty']=$this->input->post('qty');
		$insert['jumlah_bayar']=$this->input->post('jumlah_bayar');
		$insert['tgl_cetak']= date("Y-m-d");
		$insert['no_cm'] = $this->input->post('cari_no_cm');
		$insert['vtot'] = $insert['tarif'] * $insert['qty'];
		$insert['id_item'] = $idtindakan;
		$insert['yang_bayar'] = $this->input->post('yang_bayar');
		$insert['method_pay'] = $this->input->post('method_pay');
			
		$id = $this->Mumcicilan->insert_langsung($insert);
		$id = $this->Mumcicilan->get_nocm_tgl_non_pasien()->row();
		echo json_encode($id);
	}

	public function detail_tindakan() {
		$line  = array();
		$line2 = array();
		$row2  = array();
		$data['bayar_langsung'] = $this->Mumcicilan->get_data_pembayaran_langsung()->result();

		$no = 1;
		foreach($data['bayar_langsung'] as $row) {
			$row2['no'] = $no++;
			$row2['pembayaran'] = $row->item_bayar;
			$row2['tarif'] = $row->tarif;
			$row2['qty'] = $row->qty;
			$row2['jumlah'] = $row->vtot;
			$row2['penyetor'] = $row->yang_bayar;
			$row2['penerima'] = $row->name;
			$row2['aksi'] = '<a href="'.base_url('umc/cumcicilan/hapus_item/'.$row->id).'" class="btn btn-danger">Hapus</a>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		echo json_encode($line);
	}

	public function data_item_bayar($jenis_bayar='')
	{
		
		$data=$this->rjmpelayanan->get_item_layanan($jenis_bayar)->result();
			echo "<option selected value=''>-Pilih item layanan-</option>";
			foreach($data as $row){
				
				echo "<option value='$row->id_tindakan'>$row->nmtindakan</option>";
				
			}
	
		
	}

	public function data_tindakan_non_medis($kategori='') {
		$kategori = str_replace('%20',' ',$kategori);
		$data=$this->Mumcicilan->get_data_tindakan_non_medis($kategori)->result();
		echo "<option selected value=''>-- Pilih Tindakan --</option>";
		foreach($data as $row){
			echo "<option value='$row->total_tarif@$row->idtindakan@$row->nmtindakan'>$row->nmtindakan - $row->total_tarif</option>";
		}
	}

	public function get_nama_by_medrec($nocm='') {
		echo $nocm;die();
		$data=$this->Mumcicilan->get_nama_by_medrec($nocm)->row();
		echo $data->nama;
	}

	public function hapus_item($id='') {
		$this->Mumcicilan->hapus_item($id);
		redirect('umc/cumcicilan/input_bayar_langsung');
	}

	public function cetak_print($id) {
		// var_dump($this->input->post());die();
		// $tgl = $this->input->post('tgl');
		// $nocm = $this->input->post('no_cm');

		// $cek = $this->Mumcicilan->cek_no_kwitansi($nocm)->row();
		// var_dump($cek->no_kwitansi); die();
		// if($cek) {
		// 	$no_kwitansi=substr($cek->no_kwitansi, 12) + 1;
		// 	$kwitansi['no_kwitansi']=$nocm.'-'.date('y').'-'.sprintf("%06d", $no_kwitansi);
		// } else {
		// 	$kwitansi['no_kwitansi'] = $nocm.'-'.date('y').'-00001';
		// }
		$cek = $this->Mumcicilan->get_no_register_kwitansi()->row();
		// var_dump($cek);die();
		$tahun = date('Y');
		$depan = substr($tahun,2,2);
		
		if($cek) {
			$no_register = substr($cek->no_register, 4) + 1;
			$kwitansi['no_register'] = 'NP'.$depan.''.sprintf("%06d", $no_register);
			$no_kwitansi = substr($cek->no_kwitansi, 5) + 1;
			$kwitansi['no_kwitansi'] = 'NP'.$depan.'-'.sprintf("%06d", $no_kwitansi);
		} else {
			$kwitansi['no_register'] = 'NP'.$depan.''.'00001';
			$kwitansi['no_kwitansi'] = 'NP'.$depan.'-'.'00001';
		}
		$kwitansi['cetak'] = 1;
		$kwitansi['tgl_cetak'] = date("Y-m-d");
		$this->Mumcicilan->update_no_kwitansi($kwitansi,$id);

		// $nokwitansi = $this->Mumcicilan->get_no_register_kwitansi()->row()->no_kwitansi;

		redirect('umc/cumcicilan/cetak_kwitansi/'.$kwitansi['no_register']);
	}

	public function cetak_kwitansi($no_register='') {
		// $noreg = 'NP23-000001';
		// var_dump(substr($noreg,5));die();
		$data['no_kwitansi'] = $no_register;
		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['tgl'] = date("d-m-Y");
		if($no_register!=''){
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$data['data_pasien']=$this->Mumcicilan->get_data_pasien($no_register)->row();
			// var_dump($data['data_pasien']);
			$data['data_pemeriksaan']=$this->Mumcicilan->get_detail_item($no_register)->result();
			$login_data = $this->load->get_var("user_info");
			$data['user'] = strtoupper($login_data->username);
			// $cterbilang=new rjcterbilang();
			$tahun_lahir= substr($data['data_pasien']->tgl_lahir,0,4);
			$tahun_now = date('Y');
			$data['tahun']= (int)$tahun_now - (int)$tahun_lahir;
			$jumlah_vtot0=0;
			foreach($data['data_pemeriksaan'] as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}
			$data['vtot_terbilang']=$cterbilang->terbilang($jumlah_vtot0);
			// $data['vtot_terbilang']=$jumlah_vtot0;


			$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
			$mpdf->curlAllowUnsafeSslRequests = true;		
			$html = $this->load->view('cetak_non_pasien',$data,true);
			//$this->mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			// $this->load->view('paper_css/faktur_rad',$data);
		}else{
			redirect('umc/cumcicilan/input_bayar_langsung/','refresh');
		}
	}

	public function lap_penerimaan_per_kasir() {
		$data['title'] = 'Laporan Penerimaan Per Kasir Per Kwitansi';
		$data['user_kasir'] = $this->Mumcicilan->get_user_kasir()->result();
		$this->load->view('umc/lap_penerimaan_per_kasir', $data);
	}

	public function lap_penerimaan_perkasir_exe($date, $user, $carabayar) {
		if($user == 'semua') {
			if($carabayar == 'semua') {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($date)->result();
			} else {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user($date, $carabayar)->result();
			}
		} else {
			if($carabayar == 'semua') {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis($date, $user)->result();
			} else {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar)->result();
			}
		}

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$row2['no'] = $i++;
			$row2['no_kwitansi'] = $value->no_kwitansi;
			$row2['asal'] = $value->nm_poli;
			$row2['jam'] = date("H:i", strtotime($value->tgl_cetak));
			$row2['no_register'] = $value->no_register;
			$row2['no_cm'] = $value->no_cm;
			$row2['nama'] = $value->nama;
			if($value->status == NULL) {
				$row2['status'] = '';
			} else {
				$row2['status'] = $value->status;
			}
			$row2['tindakan'] = number_format($value->tunai);
			$row2['jenis_bayar'] = $value->jenis_bayar;
			$row2['cara_bayar'] = $value->cara_bayar;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_penerimaan_perkasir($date, $user, $carabayar) {
		$tgl = date("d F Y", strtotime($date));
		$name = $this->Mumcicilan->get_name_by_username($user)->row()->name;
		//var_dump($name);die();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:J1')
			->getCell('A1')
			->setValue($name);
		$sheet->setCellValue('A2', 'No');
		$sheet->setCellValue('B2', 'No Kwitansi');
		$sheet->setCellValue('C2', 'Asal');
		$sheet->setCellValue('D2', 'Jam');
		$sheet->setCellValue('E2', 'No Register');
		$sheet->setCellValue('F2', 'No MR');
		$sheet->setCellValue('G2', 'Nama');
		$sheet->setCellValue('H2', 'Jaminan');
		$sheet->setCellValue('I2', 'Status');
		$sheet->setCellValue('J2', 'Jenis Bayar');
		$sheet->setCellValue('K2', 'Tindakan');
						
		if($user == 'semua') {
			if($carabayar == 'semua') {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($date)->result();
			} else {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user($date, $carabayar)->result();
			}
		} else {
			if($carabayar == 'semua') {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis($date, $user)->result();
			} else {
				$hasil = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar)->result();
			}
		}
	
		$no = 1;
		$x = 3;
		
		foreach($hasil as $row)
		{
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_kwitansi);
			$sheet->setCellValue('C'.$x, $row->nm_poli);
			$sheet->setCellValue('D'.$x, date("H:i", strtotime($row->tgl_cetak)));
			$sheet->setCellValue('E'.$x, $row->no_register);
			$sheet->setCellValue('F'.$x, $row->no_cm);
			$sheet->setCellValue('G'.$x, $row->nama);
			$sheet->setCellValue('H'.$x, $row->cara_bayar);
			if($row->status == NULL) {
				$sheet->setCellValue('I'.$x,'');
			} else {
				$sheet->setCellValue('I'.$x, $row->status);
			}
			$sheet->setCellValue('J'.$x, $row->jenis_bayar);
			$sheet->setCellValue('K'.$x, number_format($row->tunai));
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Perkasir Perkwitansi '.$tgl;
		//ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function lap_jml_konsul_gizi() {
		$data['title'] = 'Laporan Jumlah Konsul Gizi';
		$this->load->view('umc/lapjml_konsulgizi', $data);
	}

	public function lap_jml_konsul_gizi_exe($date) {
		$hasil = $this->Mumcicilan->get_lap_jml_konsul_gizi($date)->result();

		$line  = array();
		$line2 = array();
		$row2  = array();
		$i = 1;				
		foreach ($hasil as $value) {
			$bpjs_tkt_1 = $value->bpjs_tkt_1?($value->bpjs_tkt_1!='0'?($value->bpjs_tkt_1):0):0;
			$bpjs_tkt_2 = $value->bpjs_tkt_2?($value->bpjs_tkt_2!='0'?($value->bpjs_tkt_2):0):0;
			$umum_tkt_1 = $value->umum_tkt_1?($value->umum_tkt_1!='0'?($value->umum_tkt_1):0):0;
			$umum_tkt_2 = $value->umum_tkt_2?($value->umum_tkt_2!='0'?($value->umum_tkt_2):0):0;
			$iks_tkt_1 = $value->iks_tkt_1?($value->iks_tkt_1!='0'?($value->iks_tkt_1):0):0;
			$iks_tkt_2 = $value->iks_tkt_2?($value->iks_tkt_2!='0'?($value->iks_tkt_2):0):0;
			$tarif_bpjs_1 = $value->tarif_tkt_1_bpjs?($value->tarif_tkt_1_bpjs!='0'?($value->tarif_tkt_1_bpjs):0):0;
			$tarif_bpjs_2 = $value->tarif_tkt_2_bpjs?($value->tarif_tkt_2_bpjs!='0'?($value->tarif_tkt_2_bpjs):0):0;
			$tarif_umum_1 = $value->tarif_tkt_1_umum?($value->tarif_tkt_1_umum!='0'?($value->tarif_tkt_1_umum):0):0;
			$tarif_umum_2 = $value->tarif_tkt_2_umum?($value->tarif_tkt_2_umum!='0'?($value->tarif_tkt_2_umum):0):0;
			$tarif_iks_1 = $value->tarif_tkt_1_iks?($value->tarif_tkt_1_iks!='0'?($value->tarif_tkt_1_iks):0):0;
			$tarif_iks_2 = $value->tarif_tkt_2_iks?($value->tarif_tkt_2_iks!='0'?($value->tarif_tkt_2_iks):0):0;
			$jumlah = $bpjs_tkt_1 + $bpjs_tkt_2 + $umum_tkt_1 + $umum_tkt_2 + $iks_tkt_1 + $iks_tkt_2;

			$row2['no'] = $i++;
			$row2['kelas'] = $value->kelas;
			$row2['ruang'] = $value->ruang;
			$row2['bpjs_1'] = $bpjs_tkt_1;
			$row2['bpjs_2'] = $bpjs_tkt_2;
			$row2['umum_1'] = $umum_tkt_1;
			$row2['umum_2'] = $umum_tkt_2;
			$row2['iks_1'] = $iks_tkt_1;
			$row2['iks_2'] = $iks_tkt_2;
			$row2['tarif_bpjs_1'] = number_format($tarif_bpjs_1);
			$row2['tarif_bpjs_2'] = number_format($tarif_bpjs_2);
			$row2['tarif_umum_1'] = number_format($tarif_umum_1);
			$row2['tarif_umum_2'] = number_format($tarif_umum_2);
			$row2['tarif_iks_1'] = number_format($tarif_iks_1);
			$row2['tarif_iks_2'] = number_format($tarif_iks_2);
			$row2['jumlah'] = $jumlah;
			$row2['total'] = number_format(($tarif_bpjs_1 * $bpjs_tkt_1) + ($tarif_bpjs_2 * $bpjs_tkt_2) + ($tarif_umum_1 * $umum_tkt_1) + ($tarif_umum_2 * $umum_tkt_2) + ($tarif_iks_1 * $iks_tkt_1) + ($tarif_iks_2 * $iks_tkt_2));
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
	}

	public function excel_lap_jml_konsul_gizi($date) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Ruangan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Kelas');
		$sheet->mergeCells('D1:G1')
			->getCell('D1')
			->setValue('BPJS');
		$sheet->mergeCells('H1:K1')
			->getCell('H1')
			->setValue('UMUM');
		$sheet->mergeCells('L1:O2')
			->getCell('L1')
			->setValue('IKS');
		$sheet->mergeCells('P1:P2')
			->getCell('P1')
			->setValue('Jumlah');
		$sheet->mergeCells('Q1:Q2')
			->getCell('Q1')
			->setValue('Total');
		$sheet->setCellValue('D2', 'Qty');
		$sheet->setCellValue('E2', 'Tarif Tkt 1');
		$sheet->setCellValue('F2', 'Qty');
		$sheet->setCellValue('G2', 'Tarif Tkt 2');
		$sheet->setCellValue('H2', 'Qty');
		$sheet->setCellValue('I2', 'Tarif Tkt 1');
		$sheet->setCellValue('J2', 'Qty');
		$sheet->setCellValue('K2', 'Tarif Tkt 2');
		$sheet->setCellValue('L2', 'Qty');
		$sheet->setCellValue('M2', 'Tarif Tkt 1');
		$sheet->setCellValue('N2', 'Qty');
		$sheet->setCellValue('O2', 'Tarif Tkt 2');
						
		$hasil = $this->Mumcicilan->get_lap_jml_konsul_gizi($date)->result();
	
		$no = 1;
		$x = 3;
		
		foreach($hasil as $value) {
			$bpjs_tkt_1 = $value->bpjs_tkt_1?($value->bpjs_tkt_1!='0'?($value->bpjs_tkt_1):0):0;
			$bpjs_tkt_2 = $value->bpjs_tkt_2?($value->bpjs_tkt_2!='0'?($value->bpjs_tkt_2):0):0;
			$umum_tkt_1 = $value->umum_tkt_1?($value->umum_tkt_1!='0'?($value->umum_tkt_1):0):0;
			$umum_tkt_2 = $value->umum_tkt_2?($value->umum_tkt_2!='0'?($value->umum_tkt_2):0):0;
			$iks_tkt_1 = $value->iks_tkt_1?($value->iks_tkt_1!='0'?($value->iks_tkt_1):0):0;
			$iks_tkt_2 = $value->iks_tkt_2?($value->iks_tkt_2!='0'?($value->iks_tkt_2):0):0;
			$tarif_bpjs_1 = $value->tarif_tkt_1_bpjs?($value->tarif_tkt_1_bpjs!='0'?($value->tarif_tkt_1_bpjs):0):0;
			$tarif_bpjs_2 = $value->tarif_tkt_2_bpjs?($value->tarif_tkt_2_bpjs!='0'?($value->tarif_tkt_2_bpjs):0):0;
			$tarif_umum_1 = $value->tarif_tkt_1_umum?($value->tarif_tkt_1_umum!='0'?($value->tarif_tkt_1_umum):0):0;
			$tarif_umum_2 = $value->tarif_tkt_2_umum?($value->tarif_tkt_2_umum!='0'?($value->tarif_tkt_2_umum):0):0;
			$tarif_iks_1 = $value->tarif_tkt_1_iks?($value->tarif_tkt_1_iks!='0'?($value->tarif_tkt_1_iks):0):0;
			$tarif_iks_2 = $value->tarif_tkt_2_iks?($value->tarif_tkt_2_iks!='0'?($value->tarif_tkt_2_iks):0):0;
			$jumlah = $bpjs_tkt_1 + $bpjs_tkt_2 + $umum_tkt_1 + $umum_tkt_2 + $iks_tkt_1 + $iks_tkt_2;


			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $value->ruang);
			$sheet->setCellValue('C'.$x, $value->kelas);
			$sheet->setCellValue('D'.$x, $bpjs_tkt_2);
			$sheet->setCellValue('E'.$x, $tarif_bpjs_2);
			$sheet->setCellValue('F'.$x, $bpjs_tkt_1);
			$sheet->setCellValue('G'.$x, $tarif_bpjs_1);
			$sheet->setCellValue('H'.$x, $umum_tkt_2);
			$sheet->setCellValue('I'.$x, $tarif_umum_2);
			$sheet->setCellValue('J'.$x, $umum_tkt_1);
			$sheet->setCellValue('K'.$x, $tarif_umum_1);
			$sheet->setCellValue('L'.$x, $iks_tkt_2);
			$sheet->setCellValue('M'.$x, $tarif_iks_2);
			$sheet->setCellValue('N'.$x, $iks_tkt_1);
			$sheet->setCellValue('O'.$x, $tarif_iks_1);
			$sheet->setCellValue('P'.$x, $jumlah);
			$sheet->setCellValue('Q'.$x, number_format(($tarif_bpjs_1 * $bpjs_tkt_1) + ($tarif_bpjs_2 * $bpjs_tkt_2) + ($tarif_umum_1 * $umum_tkt_1) + ($tarif_umum_2 * $umum_tkt_2) + ($tarif_iks_1 * $iks_tkt_1) + ($tarif_iks_2 * $iks_tkt_2)));
			$x++;
		}		

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Jumlah Konsul Gizi '.$tgl;
		//ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function penerimaan_perkasir() {
		$data['title'] = 'Laporan Penerimaan Per Kasir';
		$data['user_kasir'] = $this->Mumcicilan->get_user_kasir()->result();
		$date = $this->input->post('date_picker_days');
		$carabayar = $this->input->post('carabayar');
		$user = $this->input->post('user_kasir');
		$jaminan = $this->input->post('jaminan');

		if($date == '' || $carabayar == '' || $user == '' || $jaminan == '') {
			$today = date("Y-m-d");
			$data['tgl'] = $today;
			$data['carabayar'] = 'semua';
			$data['user'] = 'semua';
			$data['jaminan'] = 'semua';
			$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($today, $jaminan)->result();
			$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_ri($today, $jaminan)->result();
			$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_obat($today, $jaminan)->result();
			$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_non_pasien($today)->result();
			$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
		} else {
			$data['tgl'] = $date;
			$data['carabayar'] = $carabayar;
			$data['user'] = $user;
			$data['jaminan'] = $jaminan;
			if($user == 'semua') {
				if($carabayar == 'semua') {
					$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($date, $jaminan)->result();
					$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_ri($date, $jaminan)->result();
					$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_obat($date, $jaminan)->result();
					$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_non_pasien($date)->result();
					$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
				} else {
					$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user($date, $carabayar, $jaminan)->result();
					$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_ri($date, $carabayar, $jaminan)->result();
					$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_obat($date, $carabayar, $jaminan)->result();
					$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_non_pasien($date, $carabayar)->result();
					$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
				}
			} else {
				if($carabayar == 'semua') {
					$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis($date, $user, $jaminan)->result();
					$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_ri($date, $user, $jaminan)->result();
					$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_obat($date, $user, $jaminan)->result();
					$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_non_pasien($date, $user)->result();
					$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
				} else {
					$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar, $jaminan)->result();
					$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_ri($date, $user, $carabayar, $jaminan)->result();
					$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_obat($date, $user, $carabayar, $jaminan)->result();
					$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_non_pasien($date, $user, $carabayar)->result();
					$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
				}
			}
		}
		$this->load->view('umc/penerimaa_per_kasir', $data);
	}

	public function pdf_penerimaan_perkasir($date, $carabayar, $user, $jaminan) {
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;
		$data['username'] = $this->Mumcicilan->get_name_by_username($user)->row()->name;
		$data['date'] = $date;
		if($user == 'semua') {
			if($carabayar == 'semua') {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($date, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_ri($date, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_obat($date, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_non_pasien($date)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			} else {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user($date, $carabayar, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_ri($date, $carabayar, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_obat($date, $carabayar, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_non_pasien($date, $carabayar)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			}
		} else {
			if($carabayar == 'semua') {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis($date, $user, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_ri($date, $user, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_obat($date, $user, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_non_pasien($date, $user)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			} else {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_ri($date, $user, $carabayar, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_obat($date, $user, $carabayar, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_non_pasien($date, $user, $carabayar)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			}
		}

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']); 
		$mpdf->curlAllowUnsafeSslRequests = true;		

		$html = $this->load->view('umc/pdf_penerimaan_perkasir',$data,true);
		//$this->mpdf->AddPage('L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function lap_realisasi_unit_kerja() {
		$data['title'] = 'Laporan Realisasi Pendapatan Perunit Kerja';
		$data['date_title'] = 'Unit Kerja';
		$data['rj_poli'] = $this->Mumcicilan->get_master_poli()->result();
		$data['ruang'] = $this->Mumcicilan->get_master_ruang()->result();
		$data['rehab'] = $this->Mumcicilan->get_poli_rehab()->result();
		$data['lap'] = '';
		$this->load->view('umc/laprealisasi_unit_kerja', $data);
	}

	public function lap_realisasi_unit_kerja_exe() {
		$data['title'] = 'Laporan Realisasi Pendapatan Perunit Kerja';
		$data['rj_poli'] = $this->Mumcicilan->get_master_poli()->result();
		$data['ruang'] = $this->Mumcicilan->get_master_ruang()->result();
		$data['rehab'] = $this->Mumcicilan->get_poli_rehab()->result();
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$data['lap'] = 'ada';
			$date1 = $this->input->post('date_picker_days1');
			$date2 = $this->input->post('date_picker_days2');
			$unit = $this->input->post('unit_kerja');
			$data['date1'] = $date1;
			$data['date2'] = $date2;
			$data['object'] = $unit;
			
			$poli = strpos($unit, "POLI");
			$ruang = strpos($unit, "RUANG");
			$rehab = strpos($unit, "INSREHAB");
			
			if($poli !== FALSE) {
				$id_poli = explode("_", $unit);
				$data['date_title'] = 'Unit Kerja Ins. Rawat Jalan '.$id_poli[2];
				$data['unit'] = 'poli';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_poli($id_poli[1], $date1, $date2)->result_array();
			}

			if($ruang !== FALSE) {
				$idrg = explode("_", $unit);
				$data['date_title'] = 'Unit Kerja Ins. Rawat Inap '.$idrg[2];
				$data['unit'] = 'ruang';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_ruangan($idrg[1], $date1, $date2)->result_array();
				$data['akomodasi'] = $this->Mumcicilan->get_akomodasi_unit_kerja_ruangan($idrg[1], $date1, $date2)->row();
			}

			if($rehab !== FALSE) {
				$id_rehab = explode("_", $unit);
				$data['date_title'] = 'Unit Kerja Ins. Rehab '.$id_rehab[1];
				$data['unit'] = 'rehab';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_rehab($id_rehab[1], $date1, $date2)->result_array();
			}

			if($unit == 'LAB') {
				$data['date_title'] = 'Unit Kerja Laboratorium';
				$data['unit'] = 'lab';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_lab($date1, $date2)->result_array();
			} else if($unit == 'RAD') {
				$data['date_title'] = 'Unit Kerja Radiologi';
				$data['unit'] = 'rad';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_rad($date1, $date2)->result_array();
			} else if($unit == 'UDT') {
				$data['date_title'] = 'Unit Kerja UDT';
				$data['unit'] = 'udt';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_em($date1, $date2)->result_array();
			} else if($unit == 'OK') {
				$data['date_title'] = 'Unit Kerja Ins. Bedah';
				$data['unit'] = 'ok';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_ok($date1, $date2)->result_array();
			} else if($unit == 'FAR') {
				$data['date_title'] = 'Unit Kerja Ins. Farmasi';
				$data['unit'] = 'farmasi';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_resep($date1, $date2)->result_array();
			} else if($unit == 'GIZI') {
				$data['date_title'] = 'Unit Kerja Ins. Gizi';
				$data['unit'] = 'gizi';
				$data['unit_kerja'] = $this->Mumcicilan->get_tindakan_unit_kerja_gizi($date1, $date2)->result_array();
			}

			$this->load->view('umc/laprealisasi_unit_kerja', $data);
		} else {
			redirect('umc/cumcicilan/lap_realisasi_unit_kerja');
		}
	}

	public function excel_lap_realisasi_unit_kerja($unit, $date1, $date2) {
		$tgl1 = date("d F Y", strtotime($date1));
		$tgl2 = date("d F Y", strtotime($date2));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		$sheet->mergeCells('A1:A2')
			->getCell('A1')
			->setValue('No');
		$sheet->mergeCells('B1:B2')
			->getCell('B1')
			->setValue('Tindakan');
		$sheet->mergeCells('C1:C2')
			->getCell('C1')
			->setValue('Total Vol');
		$sheet->mergeCells('D1:F1')
			->getCell('D1')
			->setValue('Volume');
		$sheet->mergeCells('G1:G2')
			->getCell('G1')
			->setValue('Total Tarif Rill');
		$sheet->mergeCells('H1:J2')
			->getCell('H1')
			->setValue('Penerimaan');
		$sheet->setCellValue('D2', 'BPJS');
		$sheet->setCellValue('E2', 'UMUM');
		$sheet->setCellValue('F2', 'IKS');
		$sheet->setCellValue('H2', 'BPJS');
		$sheet->setCellValue('I2', 'UMUM');
		$sheet->setCellValue('J2', 'IKS');

		$poli = strpos($unit, "POLI");
		$ruang = strpos($unit, "RUANG");
		$rehab = strpos($unit, "INSREHAB");

		if($poli !== FALSE) {
			$id_poli = explode("_", $unit);
			$unit = 'poli';
			$date_title = 'Unit Kerja Ins. Rawat Jalan '.$id_poli[2];
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_poli($id_poli[1], $date1, $date2)->result_array();
			// var_dump($unit_kerja);die();
		}

		if($ruang !== FALSE) {
			$idrg = explode("_", $unit);
			$unit = 'ruang';
			$date_title = 'Unit Kerja Ins. Rawat Inap '.$idrg[2];
			$akomodasi = $this->Mumcicilan->get_akomodasi_unit_kerja_ruangan($idrg[1], $date1, $date2)->row();
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_ruangan($idrg[1], $date1, $date2)->result_array();
		}

		if($rehab !== FALSE) {
			$id_rehab = explode("_", $unit);
			$unit = 'rehab';
			$date_title = 'Unit Kerja Ins. Rehab '.$id_rehab[1];
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_rehab($id_rehab[1], $date1, $date2)->result_array();
		}

		if($unit == 'LAB') {
			$date_title = 'Unit Kerja Laboratorium';
			$unit = 'lab';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_lab($date1, $date2)->result_array();
		} else if($unit == 'RAD') {
			$date_title = 'Unit Kerja Radiologi';
			$unit = 'rad';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_rad($date1, $date2)->result_array();
		} else if($unit == 'UDT') {
			$date_title = 'Unit Kerja UDT';
			$unit = 'udt';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_em($date1, $date2)->result_array();
		} else if($unit == 'OK') {
			$date_title = 'Unit Kerja Ins. Bedah';
			$unit = 'ok';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_ok($date1, $date2)->result_array();
		} else if($unit == 'FAR') {
			$date_title = 'Unit Kerja Ins. Farmasi';
			$unit = 'farmasi';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_resep($date1, $date2)->result_array();
		} else if($unit == 'GIZI') {
			$date_title = 'Unit Kerja Ins. Gizi';
			$unit = 'gizi';
			$unit_kerja = $this->Mumcicilan->get_tindakan_unit_kerja_gizi($date1, $date2)->result_array();
		}

		$title = str_replace("%20", " ", $date_title);
		
		$i = 1;
		$x = 3;
		$total_vol = 0;
		$total_vol_bpjs = 0;
		$total_vol_umum = 0;
		$total_vol_iks = 0;
		$penerimaan_bpjs = 0;
		$penerimaan_umum = 0;
		$penerimaan_iks = 0;
		$vtotRill = 0;

		foreach($unit_kerja as $row) {
			$vtotRill += $row['rill'];
			$total_vol += $row['total_vol'];
			$total_vol_bpjs += $row['vol_bpjs'];
			$total_vol_umum += $row['vol_umum'];
			$total_vol_iks += $row['vol_iks'];
			$penerimaan_bpjs += $row['penerimaan_bpjs'];
			$penerimaan_umum += $row['penerimaan_umum'];
			$penerimaan_iks += $row['penerimaan_iks'];

			$sheet->setCellValue('A'.$x, $i++);
			$sheet->setCellValue('B'.$x, $row['nmtindakan']);
			$sheet->setCellValue('C'.$x, $row['total_vol']);
			$sheet->setCellValue('D'.$x, $row['vol_bpjs']);
			$sheet->setCellValue('E'.$x, $row['vol_umum']);
			$sheet->setCellValue('F'.$x, $row['vol_iks']);
			$sheet->setCellValue('G'.$x, number_format($row['rill']));
			$sheet->setCellValue('H'.$x, number_format($row['penerimaan_bpjs']));
			$sheet->setCellValue('I'.$x, number_format($row['penerimaan_umum']));
			$sheet->setCellValue('J'.$x, number_format($row['penerimaan_iks']));
			$x++;
		}

		if($unit == 'ruang') {
			$sheet->setCellValue('A'.$x, $i);
			$sheet->setCellValue('B'.$x, $akomodasi->nmtindakan);
			$sheet->setCellValue('C'.$x, $akomodasi->vol_bpjs + $akomodasi->vol_umum + $akomodasi->vol_iks);
			$sheet->setCellValue('D'.$x, $akomodasi->vol_bpjs);
			$sheet->setCellValue('E'.$x, $akomodasi->vol_umum);
			$sheet->setCellValue('F'.$x, $akomodasi->vol_iks);
			$sheet->setCellValue('G'.$x, number_format($akomodasi->penerimaan_bpjs + $akomodasi->penerimaan_umum + $akomodasi->penerimaan_iks));
			$sheet->setCellValue('H'.$x, number_format($akomodasi->penerimaan_bpjs));
			$sheet->setCellValue('I'.$x, number_format($akomodasi->penerimaan_umum));
			$sheet->setCellValue('J'.$x, number_format($akomodasi->penerimaan_iks));
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Total Tindakan');
		$sheet->mergeCells('A'.$x.':'.'B'.$x.'');
		if($unit != 'ruang') {
			$sheet->setCellValue('C'.$x, $total_vol);
			$sheet->setCellValue('D'.$x, $total_vol_bpjs);
			$sheet->setCellValue('E'.$x, $total_vol_umum);
			$sheet->setCellValue('F'.$x, $total_vol_iks);
			$sheet->setCellValue('G'.$x, number_format($vtotRill));
			$sheet->setCellValue('H'.$x, number_format($penerimaan_bpjs));
			$sheet->setCellValue('I'.$x, number_format($penerimaan_umum));
			$sheet->setCellValue('J'.$x, number_format($penerimaan_iks));
		} else {
			$sheet->setCellValue('C'.$x, $total_vol + $akomodasi->vol_bpjs + $akomodasi->vol_umum + $akomodasi->vol_iks);
			$sheet->setCellValue('D'.$x, $total_vol_bpjs + $akomodasi->vol_bpjs);
			$sheet->setCellValue('E'.$x, $total_vol_umum + $akomodasi->vol_umum);
			$sheet->setCellValue('F'.$x, $total_vol_iks + $akomodasi->vol_iks);
			$sheet->setCellValue('G'.$x, number_format($vtotRill + $akomodasi->penerimaan_bpjs + $akomodasi->penerimaan_umum + $akomodasi->penerimaan_iks));
			$sheet->setCellValue('H'.$x, number_format($penerimaan_bpjs + $akomodasi->penerimaan_bpjs));
			$sheet->setCellValue('I'.$x, number_format($penerimaan_umum + $akomodasi->penerimaan_umum));
			$sheet->setCellValue('J'.$x, number_format($penerimaan_iks + $akomodasi->penerimaan_iks));
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Realisasi Pendapatan '.$title.' '.$tgl1.' '.'s/d'.' '.$tgl2;
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function penerimaan_perkasir_excel($date, $carabayar, $user, $jaminan) {
		$tgl = date("d F Y", strtotime($date));
		$username = $this->Mumcicilan->get_name_by_username($user)->row()->name;

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		if($user == 'semua') {
			if($carabayar == 'semua') {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua($date, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_ri($date, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_obat($date, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_non_pasien($date)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			} else {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user($date, $carabayar, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_ri($date, $carabayar, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_obat($date, $carabayar, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_user_non_pasien($date, $carabayar)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			}
		} else {
			if($carabayar == 'semua') {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis($date, $user, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_ri($date, $user, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_obat($date, $user, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_semua_jenis_non_pasien($date, $user)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			} else {
				$data['hasil'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih($date, $user, $carabayar, $jaminan)->result();
				$data['hasil_ri'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_ri($date, $user, $carabayar, $jaminan)->result();
				$data['farmasi'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_obat($date, $user, $carabayar, $jaminan)->result();
				$data['non_pasien'] = $this->Mumcicilan->get_lap_penerimaan_perkasir_pilih_non_pasien($date, $user, $carabayar)->result();
				$data['poli']=$this->Mumcicilan->get_poliklinik()->result();
			}
		}

		$subtotal_rj = 0;
        $subtotal_ri = 0;
		$subtotal_obat = 0;
        $subtotal_non_pasien = 0;
		$x = 1;

		foreach($data['poli'] as $row1) {
			$array = json_decode(json_encode($data['hasil']), True);
			$data_poli = array_column($array, 'asal');

			if (in_array($row1->id_poli, $data_poli)) {
				$sheet->setCellValue('A'.$x, 'Poliklinik : ');
				$sheet->setCellValue('B'.$x, $row1->nm_poli);
				$x++;

				$sheet->setCellValue('A'.$x, 'No');
				$sheet->setCellValue('B'.$x, 'Kasir');
				$sheet->setCellValue('C'.$x, 'No Kwitansi');
				$sheet->setCellValue('D'.$x, 'Jam');
				$sheet->setCellValue('E'.$x, 'No Register');
				$sheet->setCellValue('F'.$x, 'No MR');
				$sheet->setCellValue('G'.$x, 'Nama');
				$sheet->setCellValue('H'.$x, 'Jaminan');
				$sheet->setCellValue('I'.$x, 'Status');
				$sheet->setCellValue('J'.$x, 'Jenis Bayar');
				$sheet->setCellValue('K'.$x, 'Tindakan');
				$x++;

				$i=1;
                $subtotal = 0;

				foreach($data['hasil'] as $row2) {
					if ($row2->asal == $row1->id_poli) {
						if($row2->status == NULL) {
							$subtotal += $row2->tunai;
						} else if($row2->status == 'batal') {
							$subtotal += 0;
						} 

						$sheet->setCellValue('A'.$x, $i++);
						$sheet->setCellValue('B'.$x, $row2->kasir);
						$sheet->setCellValue('C'.$x, $row2->no_kwitansi);
						$sheet->setCellValue('D'.$x, date("H:i", strtotime($row2->tgl_cetak)));
						$sheet->setCellValue('E'.$x, $row2->no_register);
						$sheet->setCellValue('F'.$x, $row2->no_cm);
						$sheet->setCellValue('G'.$x, $row2->nama);
						$sheet->setCellValue('H'.$x, $row2->cara_bayar);

						if($row2->status == NULL) {
							$sheet->setCellValue('I'.$x, '');
						} else {
							$sheet->setCellValue('I'.$x, $row2->status);
						}
							
						$sheet->setCellValue('J'.$x, $row2->jenis_bayar);
						$sheet->setCellValue('K'.$x, number_format($row2->tunai));
						$x++;
					}
				}

				$subtotal_rj += $subtotal;
				$sheet->setCellValue('A'.$x, 'Subtotal');
				$sheet->mergeCells('A'.$x.':'.'J'.$x.'');
				$sheet->setCellValue('K'.$x, number_format($subtotal));
				$x++;

				$sheet->setCellValue('A'.$x, '');
				$x++;
			}
		}

		if($data['farmasi']) {
			$sheet->setCellValue('A'.$x, 'Farmasi');
			$x++;

			$sheet->setCellValue('A'.$x, 'No');
			$sheet->setCellValue('B'.$x, 'Kasir');
			$sheet->setCellValue('C'.$x, 'No Kwitansi');
			$sheet->setCellValue('D'.$x, 'Jam');
			$sheet->setCellValue('E'.$x, 'No Register');
			$sheet->setCellValue('F'.$x, 'No MR');
			$sheet->setCellValue('G'.$x, 'Nama');
			$sheet->setCellValue('H'.$x, 'Jaminan');
			$sheet->setCellValue('I'.$x, 'Status');
			$sheet->setCellValue('J'.$x, 'Jenis Bayar');
			$sheet->setCellValue('K'.$x, 'Tindakan');
			$x++;

			$i = 1;
			foreach($data['farmasi'] as $obat) {
				if($obat->status == NULL) {
					$subtotal_obat += $obat->tunai;
				} else if($obat->status == 'batal') {
					$subtotal_obat += 0;
				}

				$sheet->setCellValue('A'.$x, $i++);
				$sheet->setCellValue('B'.$x, $obat->kasir);
				$sheet->setCellValue('C'.$x, $obat->no_kwitansi);
				$sheet->setCellValue('D'.$x, date("H:i", strtotime($obat->tgl_cetak)));
				$sheet->setCellValue('E'.$x, $obat->no_register);
				$sheet->setCellValue('F'.$x, $obat->no_cm);
				$sheet->setCellValue('G'.$x, $obat->nama);
				$sheet->setCellValue('H'.$x, $obat->cara_bayar);

				if($obat->status == NULL) {
					$sheet->setCellValue('I'.$x, '');
				} else {
					$sheet->setCellValue('I'.$x, $obat->status);
				}
					
				$sheet->setCellValue('J'.$x, $obat->jenis_bayar);
				$sheet->setCellValue('K'.$x, number_format($obat->tunai));
				$x++;
			}

			$sheet->setCellValue('A'.$x, 'Subtotal');
			$sheet->mergeCells('A'.$x.':'.'K'.$x.'');
			$sheet->setCellValue('L'.$x, number_format($subtotal_obat));
			$x++;

			$sheet->setCellValue('A'.$x, '');
			$x++;
		}

		if($data['hasil_ri']) {
			$sheet->setCellValue('A'.$x, 'Rawat Inap');
			$x++;

			$sheet->setCellValue('A'.$x, 'No');
			$sheet->setCellValue('B'.$x, 'Kasir');
			$sheet->setCellValue('C'.$x, 'No Kwitansi');
			$sheet->setCellValue('D'.$x, 'Jam');
			$sheet->setCellValue('E'.$x, 'No Register');
			$sheet->setCellValue('F'.$x, 'No MR');
			$sheet->setCellValue('G'.$x, 'Nama');
			$sheet->setCellValue('H'.$x, 'Ruang');
			$sheet->setCellValue('I'.$x, 'Jaminan');
			$sheet->setCellValue('J'.$x, 'Status');
			$sheet->setCellValue('K'.$x, 'Jenis Bayar');
			$sheet->setCellValue('L'.$x, 'Tindakan');
			$x++;

			$i = 1;
			foreach($data['hasil'] as $iri) {
				if($iri->status == NULL) {
					$subtotal_ri += $iri->tunai;
				} else if($iri->status == 'batal') {
					$subtotal_ri += 0;
				}
				
				$sheet->setCellValue('A'.$x, $i++);
				$sheet->setCellValue('B'.$x, $iri->kasir);
				$sheet->setCellValue('C'.$x, $iri->no_kwitansi);
				$sheet->setCellValue('D'.$x, date("H:i", strtotime($iri->tgl_cetak)));
				$sheet->setCellValue('E'.$x, $iri->no_register);
				$sheet->setCellValue('F'.$x, $iri->no_cm);
				$sheet->setCellValue('G'.$x, $iri->nama);
				$sheet->setCellValue('H'.$x, $iri->nmruang);
				$sheet->setCellValue('I'.$x, $iri->carabayar);

				if($iri->status == NULL) {
					$sheet->setCellValue('J'.$x, '');
				} else {
					$sheet->setCellValue('J'.$x, $iri->status);
				}
				
				$sheet->setCellValue('K'.$x, $iri->jenis_bayar);
				$sheet->setCellValue('L'.$x, number_format($iri->tunai));
				$x++;
			}

			$sheet->setCellValue('A'.$x, 'Subtotal');
			$sheet->mergeCells('A'.$x.':'.'K'.$x.'');
			$sheet->setCellValue('L'.$x, number_format($subtotal_ri));
			$x++;

			$sheet->setCellValue('A'.$x, '');
			$x++;
		}

		if($data['non_pasien']) {
			$sheet->setCellValue('A'.$x, 'Non Pasien');
			$x++;

			$sheet->setCellValue('A'.$x, 'No');
			$sheet->setCellValue('B'.$x, 'Kasir');
			$sheet->setCellValue('C'.$x, 'Tindakan');
			$sheet->setCellValue('D'.$x, 'No Kwitansi');
			$sheet->setCellValue('E'.$x, 'No MR');
			$sheet->setCellValue('F'.$x, 'Nama');
			$sheet->setCellValue('G'.$x, 'Jenis Bayar');
			$sheet->setCellValue('H'.$x, 'Tindakan');
			$x++;

			$i = 1;
			foreach($data['non_pasien'] as $non) {
				$subtotal_non_pasien += $non->jml;
				$tindakan = $this->Mumcicilan->get_tindakan_non_pasien($non->no_kwitansi)->result();

				$sheet->setCellValue('A'.$x, $i++);
				$sheet->setCellValue('B'.$x, $non->kasir);
				$sheet->setCellValue('D'.$x, $non->no_kwitansi);
				$sheet->setCellValue('E'.$x, $non->no_cm);
				$sheet->setCellValue('F'.$x, $non->nama);
				$sheet->setCellValue('G'.$x, $non->method_pay);
				$sheet->setCellValue('H'.$x, number_format($non->jml));

				foreach($tindakan as $key=>$val) {
					$sheet->setCellValue('C'.$x, '- '.$val->item_bayar);
					$x++;
				}
				$x++;
			}

			$sheet->setCellValue('A'.$x, 'Subtotal');
			$sheet->mergeCells('A'.$x.':'.'G'.$x.'');
			$sheet->setCellValue('H'.$x, number_format($subtotal_non_pasien));
			$x++;

			$sheet->setCellValue('A'.$x, '');
			$x++;
		}

		$sheet->setCellValue('A'.$x, 'Total : ');
		$sheet->setCellValue('B'.$x, number_format($subtotal_rj + $subtotal_ri + $subtotal_non_pasien + $subtotal_obat));

		$writer = new Xlsx($spreadsheet);
		$filename = 'Laporan Penerimaan Perkasir '.$tgl.'(Cara Bayar : '.$carabayar.')(Kasir : '.$username.')(Jaminan : '.$jaminan.')';
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function titipan_pasien() {
		$data['title'] = 'Titipan Pasien Belum Selesai Administrasi';
		$date = $this->input->post('date_picker_months');

		if($date != '') {
			$data['date'] = $date;
			$data['date_title'] = 'Titipan Pasien '.date("F Y", strtotime($date));
			$data['titipan'] = $this->Mumcicilan->get_rincian_titipan_pasien($date)->result();
		} else {
			$data['date'] = date('Y-m');
			$data['date_title'] = 'Titipan Pasien '.date("F Y", strtotime(date('Y-m')));
			$data['titipan'] = $this->Mumcicilan->get_rincian_titipan_pasien(date('Y-m'))->result();
		}

		$this->load->view('umc/titipan_pasien', $data);
	}

	public function titipan_pasien_excel($date) {
		$tgl = date("F Y", strtotime($date));
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No.');
		$sheet->setCellValue('B1', 'No Register');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'No Medrec');
		$sheet->setCellValue('E1', 'Jaminan');
		$sheet->setCellValue('F1', 'Ruang');
		$sheet->setCellValue('G1', 'Kelamin');
		$sheet->setCellValue('H1', 'Tgl Masuk');
		$sheet->setCellValue('I1', 'Tgl Keluar');
		$sheet->setCellValue('J1', 'Titipan');
		$sheet->setCellValue('K1', 'Uang Jaminan');

		$data = $this->Mumcicilan->get_rincian_titipan_pasien($date)->result();

		$no = 1;
		$x = 2;

		foreach($data as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->no_ipd);
			$sheet->setCellValue('C'.$x, $row->nama);
			$sheet->setCellValue('D'.$x, $row->no_cm);
			$sheet->setCellValue('E'.$x, $row->carabayar);
			$sheet->setCellValue('F'.$x, $row->nmruang);
			$sheet->setCellValue('G'.$x, $row->sex);
			$sheet->setCellValue('H'.$x, date("d-m-Y", strtotime($row->tgl_masuk)));
			$sheet->setCellValue('I'.$x, date("d-m-Y", strtotime($row->tgl_keluar)));
			$sheet->setCellValue('J'.$x, $row->jaminan_adm);
			$sheet->setCellValue('K'.$x, number_format($row->uang_muka_adm));
			$x++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Rekap Titipan Pasien '.$tgl;
		ob_end_clean();
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function get_grandtotal_all($no_ipd) {
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);		
		
		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}			

		$grand_total = 0;
		$subsidi_total = 0;

		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);	
			$grand_total = $grand_total + $result['subtotal'];
		}
		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien, $pasien);
			$grand_total = $grand_total + $result['subtotal'];		
		}

		$list_pa = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
		$list_elektromedik = $this->rimpasien->get_list_em_iri($no_ipd);
		$list_lab_pasien = $this->rimpasien->get_list_lab_iri($no_ipd);
		$list_radiologi = $this->rimpasien->get_list_rad_iri($no_ipd);
		$list_resep = $this->rimpasien->get_list_all_resep_pasien($no_ipd);

		$list_ok = $this->rimpasien->get_list_ok_iri($no_ipd);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird($pasien[0]['noregasal']);
		$list_ok_ird = $this->rimpasien->get_list_ok_ird($pasien[0]['noregasal']);
		$list_em_ird = $this->rimpasien->get_list_em_ird($pasien[0]['noregasal']);
		$list_rad_ird = $this->rimpasien->get_list_rad_ird($pasien[0]['noregasal']);
		$list_lab_ird = $this->rimpasien->get_list_lab_ird($pasien[0]['noregasal']);
		$list_resep_ird = $this->rimpasien->get_list_resep_ird($pasien[0]['noregasal']);

		if ($pasienold[0]['id_poli'] == 'BA00') {
			if(($list_tindakan_ird)){
				$result = $this->string_table_ird_simple($list_tindakan_ird);
				$grand_total = $grand_total + $result['subtotal'];				
			}
			
			if(($list_ok_ird)){
				$result = $this->string_table_ok_ird($list_ok_ird);
				$grand_total = $grand_total + $result['subtotal'];			
			}
			
			if(($list_em_ird)){
				$result = $this->string_table_elektromedik_ird($list_em_ird);
				$grand_total = $grand_total + $result['subtotal'];	
			}
			
			if(($list_rad_ird)){
				$result = $this->string_table_radiologi_ird($list_rad_ird);
				$grand_total = $grand_total + $result['subtotal'];				
			}
			
			if(($list_lab_ird)){
				$result = $this->string_table_lab_ird($list_lab_ird);
				$grand_total = $grand_total + $result['subtotal'];				
			}
		}

		if(($list_radiologi)){
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
		}
		
		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//pa
		if(($list_pa)){
			$result = $this->string_table_pa_simple($list_pa);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ok
		if(($list_ok)){
			$result = $this->string_table_ok_simple($list_ok);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		if(($list_elektromedik)){
			$result = $this->string_table_elektromedik_simple($list_elektromedik);
			$grand_total = $grand_total + $result['subtotal'];			
			
		}

		return $grand_total;
		echo $grand_total;
	}

	private function string_table_elektromedik_simple($list_elektromedik){
		//var_dump($list_elektromedik); die();
		$konten = "";
		$subtotal = 0;
		if($list_elektromedik[0]['titip'] == NULL) {
			if($list_elektromedik[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_elektromedik[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_elektromedik as $r) {
					if($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_bpjs']*$r['qty']);
					} else if($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_elektromedik[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_elektromedik as $r) {
					if(($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
					} else if($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} 
		} else {
			if($list_elektromedik[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_elektromedik[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_elektromedik as $r) {
					if($list_elektromedik[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs']*$r['qty']);
					} else if($list_elektromedik[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_elektromedik[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_elektromedik as $r) {
					$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Elektromedik</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			}
		}
			
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal += $r['biaya_ok']*$r['qty'];
		}
		$konten = $konten.'
			<tr>
				<td colspan="7" align="left">Subtotal Operasi</td>
				<td align="right">Rp. '.number_format($subtotal).'</td>
			</tr>';
			 
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_pa_simple($list_pa_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_pa = number_format($r['biaya_pa'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Patologi Anatomi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien){
		$konten = "";
		$subtotal = 0;
		if($list_lab_pasien[0]['titip'] == NULL) {
			if($list_lab_pasien[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
					$total_tarif = number_format($r['total_tarif'],0);
					$vtot = number_format($r['vtot'],0);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_lab_pasien[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_lab_pasien as $r) {
					if($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_bpjs']*$r['qty']);
						$tarif_bpjs = number_format($r['tarif_bpjs'],0);
						$vtot = number_format($r['vtot'],0);
					} else if($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
						$tarif_bpjs = number_format($r['total_tarif'],0);
						$vtot = number_format($r['vtot'],0);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_lab_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_lab_pasien as $r) {
					if(($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
					} else if($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}
					$tarif_jatah_iks = number_format($r['tarif_jatah_iks'],0);
					$vtot = number_format($r['vtot'],0);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			}
		} else {
			if($list_lab_pasien[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
					$biaya_lab = number_format($r['tarif_jatah'],0);
					$vtot = number_format($r['vtot'],0);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_lab_pasien[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_lab_pasien as $r) {
					if($list_lab_pasien[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs']*$r['qty']);
						$biaya_lab = number_format($r['tarif_jatah_bpjs'],0);
						$vtot = number_format($r['vtot'],0);
					} else if($list_lab_pasien[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
						$biaya_lab = number_format($r['tarif_jatah'],0);
						$vtot = number_format($r['vtot'],0);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_lab_pasien[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_lab_pasien as $r) {
					$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
					$biaya_lab = number_format($r['tarif_iks'],0);
					$vtot = number_format($r['vtot'],0);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Laboratorium</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			}
		}
			 
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi){
		$konten = "";
		$subtotal = 0;
		//$selisih_rad = 0;
		if($list_radiologi[0]['titip'] == NULL) {
			if($list_radiologi[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_radiologi[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_radiologi as $r) {
					if($list_radiologi[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_bpjs']*$r['qty']);
					} else if($list_radiologi[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['total_tarif']*$r['qty']);
					}
				}
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_radiologi[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_radiologi as $r) {
					if(($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
						$subtotal = $subtotal + (($r['tarif_jatah_iks']*$r['qty']) - ($r['tarif_iks']*$r['qty']));
					} else if($r['tarif_jatah_iks'] < $r['tarif_iks']) {
						$subtotal = $subtotal + (0);
					}
				}	
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			}
		} else {
			if($list_radiologi[0]['cara_bayar'] == 'UMUM') {
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
				}	
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_radiologi[0]['cara_bayar'] == 'BPJS') {
				foreach ($list_radiologi as $r) {
					if($list_radiologi[0]['tgl_masuk'] >= '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah_bpjs']*$r['qty']);
					} else if($list_radiologi[0]['tgl_masuk'] < '2023-04-06') {
						$subtotal = $subtotal + ($r['tarif_jatah']*$r['qty']);
					}
				}	
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			} else if($list_radiologi[0]['cara_bayar'] == 'KERJASAMA') {
				foreach ($list_radiologi as $r) {
					$subtotal = $subtotal + ($r['tarif_iks']*$r['qty']);
				}	
				$konten = $konten.'
						<tr>
							<td colspan="7" align="left">Subtotal Radiologi</td>
							<td align="right">Rp. '.number_format($subtotal,0).'</td>
						</tr>
						';
			}
		}
			 
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_ird($list_lab_ird) {
		$konten = "";
		$subtotal = 0;

		foreach ($list_lab_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_lab']*$r['qty']);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_radiologi_ird($list_rad_ird) {
		$konten = "";
		$subtotal = 0;

		foreach ($list_rad_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_rad']*$r['qty']);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_elektromedik_ird($list_em_ird) {
		$konten = "";
		$subtotal = 0;

		foreach ($list_em_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_em']*$r['qty']);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Elektromedik</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ok_ird($list_ok_ird) {
		$konten = "";
		$subtotal = 0;

		foreach ($list_ok_ird as $r) {
			$subtotal = $subtotal + ($r['biaya_ok']*$r['qty']);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Operasi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien, $pasien){
		$konten = "";
		
		$subtotal = 0;
		$subtotal_tot = 0;
		$selisih_tindakan = 0;
		$subtotal_alkes=0;
		$subtotal_jth_kelas = 0;
		if(($pasien[0]['carabayar'] == 'BPJS' || $pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == NULL)) {
			foreach ($list_tindakan_pasien as $r) {
				$subtotal_tot = $subtotal_tot+(($r['tumuminap'] + $r['tarifalkes'])*$r['qtyyanri']);
				$subtotal += $r['total_per_tindakan'];
				$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
				$tumuminap = number_format($r['tumuminap'],0);
				$vtot = number_format($r['vtot'],0);

				$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
				$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
				$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
			}
			$konten = $konten.'
					<tr>
						<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
						<td align="right">Rp. '.number_format($subtotal,0).'</td>
					</tr>
					';
		} else if(($pasien[0]['carabayar'] == 'KERJASAMA') && ($pasien[0]['titip'] == NULL)) {
			foreach ($list_tindakan_pasien as $r) {
				if(($r['tumuminap'] > $r['tarif_iks']) || ($r['tumuminap'] == $r['tarif_iks'])) {
					$subtotal = $subtotal+(($r['tumuminap']*$r['qtyyanri']) - ($r['tarif_iks']*$r['qtyyanri']));
				} else if($r['tumuminap'] < $r['tarif_iks']) {
					$subtotal = $subtotal+(0);
				}
				//$selisih_tindakan = $selisih_tindakan + $subtotal_tot;
				//$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
				$tumuminap = number_format($r['tumuminap'],0);
				//$selisih_tindakan = ($subtotal_tot);
				$vtot = number_format($r['vtot'],0);

				$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
				$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
				$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
			}
			$konten = $konten.'
					<tr>
						<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
						<td align="right">Rp. '.number_format($subtotal,0).'</td>
					</tr>
					';
		} else if(($pasien[0]['carabayar'] == 'BPJS' || $pasien[0]['carabayar'] == 'UMUM') && ($pasien[0]['titip'] == '1')) {
			foreach ($list_tindakan_pasien as $r) {
				$subtotal = $subtotal+($r['tarif_jatah']*$r['qtyyanri']);
				
				//$selisih_tindakan = $selisih_tindakan + $subtotal_tot;
				//$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
				$tumuminap = number_format($r['tumuminap'],0);
				//$selisih_tindakan = ($subtotal_tot);
				$vtot = number_format($r['vtot'],0);

				$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
				$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
				$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
			}
			$konten = $konten.'
					<tr>
						<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
						<td align="right">Rp. '.number_format($subtotal,0).'</td>
					</tr>
					';
		} else if($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == '1') {
			foreach ($list_tindakan_pasien as $r) {
				$subtotal = $subtotal+($r['tarif_iks']*$r['qtyyanri']);
				
				//$selisih_tindakan = $selisih_tindakan + $subtotal_tot;
				//$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
				$tumuminap = number_format($r['tumuminap'],0);
				//$selisih_tindakan = ($subtotal_tot);
				$vtot = number_format($r['vtot'],0);

				$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
				$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
				$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
			}
			$konten = $konten.'
					<tr>
						<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
						<td align="right">Rp. '.number_format($subtotal,0).'</td>
					</tr>
					';
		}
		$result = array('konten' => $konten,
					'subtotal_tot' => $subtotal_tot,
					'subtotal' => $subtotal,
					'selisih_tindakan' => $selisih_tindakan,
					'subtotal_alkes' => $subtotal_alkes,
					'subsidi' => $subtotal_jth_kelas);
		return $result;
	}

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$subtotal = 0;
		$subtotalruang = 0;
		$selisih_ruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat=0;$ceknull=0;
		$subtotalvk=0;$subtotalicu=0;
		if(($pasien[0]['carabayar']=='UMUM') && ($pasien[0]['titip']==NULL)) {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;

					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						$total_per_kamar = $r['total_tarif'] * $diff;
					}

					$subtotal = $subtotal + $total_per_kamar;

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			} 
		} else if($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == NULL) {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;

					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						if($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							$total_per_kamar = $r['tarif_bpjs'] * $diff;
						} else if($pasien[0]['tgl_masuk'] < '2023-04-06') {
							$total_per_kamar = $r['total_tarif'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			}
		} else if(($pasien[0]['carabayar']=='KERJASAMA') && ($pasien[0]['titip']==NULL)) {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;



					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						$total_per_kamar = $r['tarif_iks'] * $diff;
						$total_jatah = $r['tarif_jatah_iks'] * $diff;
						if(($r['tarif_iks'] > $r['tarif_jatah_iks']) || ($r['tarif_iks'] == $r['tarif_jatah_iks'])) {
							$selisih_ruang =  $selisih_ruang + ($total_per_kamar - $total_jatah);
						} else if($r['tarif_iks'] < $r['tarif_jatah_iks']) {
							$selisih_ruang =  $selisih_ruang + (0);
						}
					}

					$subtotal = $subtotal + ($selisih_ruang);

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			} 
		} else if (($pasien[0]['carabayar']=='UMUM') && ($pasien[0]['titip']=='1')) {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
							//$selisih_hari =  "- Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;



					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					//$total_per_kamar = $r['vtot'] * $diff;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						$total_per_kamar = $r['tarif_jatah'] * $diff;
					}

					$subtotal = $subtotal + $total_per_kamar;

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			} 
		} else if($pasien[0]['carabayar'] == 'BPJS' && $pasien[0]['titip'] == '1') {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;

					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						if($pasien[0]['tgl_masuk'] >= '2023-04-06') {
							$total_per_kamar = $r['tarif_jatah_bpjs'] * $diff;
						} else if($pasien[0]['tgl_masuk'] < '2023-04-06') {
							$total_per_kamar = $r['tarif_jatah'] * $diff;
						}
					}

					$subtotal = $subtotal + $total_per_kamar;

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			}
		} else if($pasien[0]['carabayar'] == 'KERJASAMA' && $pasien[0]['titip'] == '1') {
			foreach ($list_mutasi_pasien as $r) {
				if(strpos($r['nmruang'],'Bersalin')==false){
					$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
					if($r['tglkeluarrg'] != null){
						$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
					}else{
						if($pasien[0]['tgl_keluar_resume'] != null){
							$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar_resume'])) ;
						}else{
							//$tgl_keluar_rg = "-" ;
							$tgl_keluar_rg = date("d-m-Y");
						}	
					}
					if($r['tglkeluarrg'] != null){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($r['tglkeluarrg']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari"; 
					}else{
						if($pasien[0]['tgl_keluar_resume'] != NULL){
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime($pasien[0]['tgl_keluar_resume']);//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}else{
							$start = new DateTime($r['tglmasukrg']);//start
							$end = new DateTime();//end

							$diff = $end->diff($start)->format("%a");
							if($diff == 0){
								$diff = 1;
							}
							$selisih_hari =  $diff." Hari";
						}
					}
					$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
					if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar_resume']==null || $pasien[0]['tgl_keluar_resume']=='')){
						$ceknull=1;
					}
					$total_tarif = $r['harga_jatah_kelas'] ;

					$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
					$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

					if($status_paket == 1){
						$total_per_kamar = 0;
					}else{
						$total_per_kamar = $r['tarif_jatah_iks'] * $diff;
					}

					$subtotal = $subtotal + $total_per_kamar;

					if(strpos($r['nmruang'],'ICU')){
						$subtotalicu+=$total_per_kamar;
					} else{
						$subtotalruang+=$total_per_kamar;
					}
				}
			}
		}
		//$konten = $konten."</table>";
		
		$result = array('konten' => $konten,
			'subtotal' => $subtotal,
			'subtotal_ruang' => $subtotalruang,
			'subtotal_vk' => $subtotalvk,
			'subtotal_icu' => $subtotalicu,
			'jasaperawat' => $jasaperawat,
			'selisihhari' => $diff,
			'ceknull' => $ceknull);
		return $result;
	}
}
?>