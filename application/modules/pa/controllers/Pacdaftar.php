<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include('.php');
// require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
// require_once(APPPATH.'controllers/Secure_area.php');
require_once(APPPATH . 'controllers/irj/Rjcterbilang.php');
class Pacdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->model('admin/appconfig', '', TRUE);
	}

	public function index(){
		$date=$this->input->post('date');
		$key=$this->input->post('key');
		if(!empty($date)){
			$data['title'] = 'DAFTAR PASIEN PATOLOGI ANATOMI Tanggal '.date('d-m-Y',strtotime($date));
			$data['patologi']=$this->pamdaftar->get_daftar_pasien_pa_by_date($date)->result();
		}else if(!empty($key)){
			$data['title'] = 'DAFTAR PASIEN PATOLOGI ANATOMI | '.$key;
			$data['patologi']=$this->pamdaftar->get_daftar_pasien_pa_by_no($key)->result();
		}else{
			$data['title'] = 'DAFTAR PASIEN PATOLOGI ANATOMI Tanggal '.date('d-m-Y');
			$data['patologi']=$this->pamdaftar->get_daftar_pasien_pa_by_date(date('Y-m-d'))->result();
		}

		// $data['patologi']=$this->pamdaftar->get_daftar_pasien_pa()->result();
		$this->load->view('pa/pavdaftarpasien',$data);
		//print_r($data);
	}

	// public function by_date(){
	// 	$date=$this->input->post('date');
	// 	$data['title'] = 'DAFTAR PASIEN PATOLOGI ANATOMI Tanggal '.date('d-m-Y',strtotime($date));

	// 	$data['patologi']=$this->pamdaftar->get_daftar_pasien_pa_by_date($date)->result();
	// 	$this->load->view('pa/pavdaftarpasien',$data);
	// }

	// public function by_no(){
	// 	$key=$this->input->post('key');
	// 	$data['title'] = 'DAFTAR PASIEN PATOLOGI ANATOMI | '.$key;

	// 	$data['patologi']=$this->pamdaftar->get_daftar_pasien_pa_by_no($key)->result();
	// 	$this->load->view('pa/pavdaftarpasien',$data);
	// }

	public function pemeriksaan_pa($no_register = '', $pelayan = ''){

		$data['pelayan'] = $pelayan;
		$data['title'] = 'Input Pemeriksaan Patologi Anatomi';

		$data['no_register']=$no_register;

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='II';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['nmkontraktor']='';
				$data['tgl_periksa']=$row->tgl_kunjungan;
				// $data['waktu_masuk_pa']="";
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_pasien_pemeriksaan($no_register)->result();
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
			}
			
			if ($data['no_medrec']=='-') {
				$data['pemeriksaan_kee']='0';
				}
			else {
				$pemeriksaan_ke=$this->pamdaftar->get_data_banyak_pemeriksaan($data['no_medrec'])->row();
				$data['pemeriksaan_kee']=isset($pemeriksaan_ke->pemeriksaan)?$pemeriksaan_ke->pemeriksaan:'';
				}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->pamdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';

				//$data['kelas_pasien']='III';

				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_pa']=$data['data_pasien_daftar_ulang']->waktu_masuk_pa;

				// if($data['waktu_masuk_pa']==null){
				// 	$data['waktu_masuk_pa']=date('Y-m-d H:i:s');
				// 	$data2['waktu_masuk_pa']=$data['waktu_masuk_pa'];
				// 	$id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);			
				// }
			}else if (substr($no_register, 0,2)=="RI"){
				// $data['waktu_masuk_pa']="";
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->pamdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['data_jenis_pa']=$this->pamdaftar->get_jenis_pa()->result();
		$data['data_pemeriksaan']=$this->pamdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter']=$this->pamdaftar->getdata_dokter()->result();
		$data['tindakan']=$this->pamdaftar->getdata_tindakan_pasien()->result();
		// $data['tindakan_histo']=$this->pamdaftar->getdata_tindakan_pasien_histo()->result();
		// $data['tindakan_sito']=$this->pamdaftar->getdata_tindakan_pasien_sito()->result();

		$data['tindakan_histo']=$this->pamdaftar->getdata_tindakan_pasien_histo()->result();
		$data['tindakan_sito']='';
		
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->pamdaftar->get_roleid($login_data->userid)->row()->roleid;

		$this->load->view('pa/pavpemeriksaan',$data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=$this->pamdaftar->get_biaya_tindakan($id_tindakan)->row()->tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan_()
	{
		var_dump($this->input->post());die();
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

		if($this->input->post('jenis_blanko')=='1'){
			$data['id_tindakan']=$this->input->post('idtindakan_h');
			$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
			foreach($data_tindakan as $row){
				$data['jenis_tindakan']=$row->nmtindakan;
			}
			$data['qty']=$this->input->post('qty_h');
			$data['id_dokter']=$this->input->post('id_dokter_h');
			$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
			foreach($data_dokter as $row){
				$data['nm_dokter']=$row->nm_dokter;
			}
			$data['biaya_pa']=$this->input->post('biaya_pa_hide_h');
			$data['vtot']=$this->input->post('vtot_hide_h');

			$blanko['jenis_sediaan']=$this->input->post('jenis_sediaan');
			$blanko['lokasi_jaringan']=$this->input->post('lokasi_jaringan');
			$blanko['cairan_fiksasi']=$this->input->post('cairan_fiksasi');
			$blanko['diagnosa_klinik']=$this->input->post('diagnosa_klinik');
			$blanko['keterangan_klinik']=$this->input->post('keterangan_klinik');

			$data['jenis_blanko'] = '1';
			$data['isi_blanko'] = json_encode($blanko);
		}else{
			$data['id_tindakan']=$this->input->post('idtindakan_s');
			$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
			foreach($data_tindakan as $row){
				$data['jenis_tindakan']=$row->nmtindakan;
			}
			$data['qty']=$this->input->post('qty_s');
			$data['id_dokter']=$this->input->post('id_dokter_s');
			$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
			foreach($data_dokter as $row){
				$data['nm_dokter']=$row->nm_dokter;
			}
			$data['biaya_pa']=$this->input->post('biaya_pa_hide_s');
			$data['vtot']=$this->input->post('vtot_hide_s');


			$blanko['bahan_sediaan']=$this->input->post('bahan_sediaan');
			$blanko['cara_pengambilan']=$this->input->post('cara_pengambilan');
			$blanko['tanggal_pengambilan']=$this->input->post('tanggal_pengambilan');
			$blanko['cairan_fiksasi']=$this->input->post('cairan_fiksasi');
			$blanko['diagnosa_klinik']=$this->input->post('diagnosa_klinik');
			$blanko['keterangan_klinik']=$this->input->post('keterangan_klinik');
			$blanko['keterangan_klinik']=$this->input->post('keterangan_klinik');
			$blanko['genekologik']=$this->input->post('genekologik');
			$blanko['status_perkawinan']=$this->input->post('status_perkawinan');
			$blanko['haidminsatu']=$this->input->post('haidminsatu');
			$blanko['lama_kawin']=$this->input->post('lama_kawin');
			$blanko['siklus_haid']=$this->input->post('siklus_haid');
			$blanko['perkawinan']=$this->input->post('perkawinan');
			$blanko['paritas']=$this->input->post('paritas');
			$blanko['kontrasepsi']=$this->input->post('kontrasepsi');
			$blanko['menopause']=$this->input->post('menopause');
			$blanko['terapi']=$this->input->post('terapi');
			$blanko['sifat_pertanyaan']=$this->input->post('sifat_pertanyaan');

			$data['jenis_blanko'] = '2';
			$data['isi_blanko'] = json_encode($blanko);
		}


		//SET NO PA PE TINDAKAN
		// $data['no_pa_tindakan'] = $data['id_tindakan'];

		/*$data['no_pa']=$this->input->post('no_pa');
		if($data['no_pa']!=''){
		} else {
			$this->pamdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_pa']=$this->pamdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_pa;
		}*/

		$this->pamdaftar->insert_pemeriksaan($data);
		
		//redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register'].'/'.$data['no_pa']);
		// redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register']);
		// print_r($data);
		echo json_encode(array("status" => TRUE));
	}

	public function insert_pemeriksaan()
	{
		// var_dump($this->input->post());die();
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['kelas']=$this->input->post('kelas_pasien');
		if($this->input->post('tgl_input')!=''){
			$data['tgl_kunjungan']=$this->input->post('tgl_input');
		}else {
			$data['tgl_kunjungan']=$this->input->post('tgl_periksa');
		}
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');
		$data['id_tindakan']=$this->input->post('idtindakan_h');
		$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}


		$data['qty']=$this->input->post('qty_h');
		$data['id_dokter']=$this->input->post('id_dokter_h');
		$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_pa']=$this->input->post('biaya_pa_hide_h');
		$data['vtot']=$this->input->post('vtot_hide_h');

		$this->pamdaftar->insert_pemeriksaan($data);
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
				if($this->input->post('tgl_periksa')!=''){
					$data['tgl_kunjungan']=$this->input->post('tgl_periksa');
				}else 
					$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach($data_tindakan as $row){
					$data['jenis_tindakan']=$row->nmtindakan;
				}
				$data['qty']='1';
				$data['id_dokter']=$this->input->post('id_dokter');
				$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
				foreach($data_dokter as $row){
					$data['nm_dokter']=$row->nm_dokter;
				}
				$data['biaya_pa']=$this->pamdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				$data['vtot']=$data['biaya_pa'];
				$data['idrg']=$this->input->post('idrg');
				$data['bed']=$this->input->post('bed');
				$data['cara_bayar']=$this->input->post('cara_bayar');
				$data['xinput']=$this->input->post('xuser');

				$this->pamdaftar->insert_pemeriksaan($data);
		    }
			
			echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR PA DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotpa=$this->pamdaftar->get_vtot_pa($no_register)->row()->vtot_pa;
		$getrdrj=substr($no_register, 0,2);

		$this->pamdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_pa=$this->pamdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_pa;

		if($getrdrj=="PL"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotpa,$no_pa);
		} else if($getrdrj=="RJ"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotpa,$no_pa);
		}
		else if ($getrdrj=="RD"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotpa,$no_pa);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->pamdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_pa=$row->status_pa;
			}
			$status_pa = $status_pa + 1;
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_pa,$getvtotpa,$no_pa);
		}

		//window.open("'.site_url("pa/pacdaftar/cetak_blanko/$no_pa").'", "_blank");
		if($getrdrj=="PL"){
			echo '<script type="text/javascript">
					window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");
					window.focus()
				</script>';
			redirect('pa/pacdaftar/','refresh');
		} 
		else if($getrdrj=="RJ"){
			redirect("pa/pacdaftar/cetak_faktur/$no_pa");

		}
		else if ($getrdrj=="RD"){
			echo '<script type="text/javascript">
					window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");
					window.focus()
				</script>';
			redirect('pa/pacdaftar/','refresh');

		}
		else if ($getrdrj=="RI"){
			redirect("pa/pacdaftar/cetak_faktur/$no_pa");

		}

		// echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';

		// redirect('pa/pacdaftar/','refresh');
		
		//print_r($getvtotpa);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_pa='')
	{
		$this->pamdaftar->hapus_data_pemeriksaan($id_pemeriksaan_pa);
        echo json_encode(array("status" => $id_pemeriksaan_pa));
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		//$data['xuser']=$this->input->post('xuser');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->pamdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['pa']='1';
		
		$this->pamdaftar->insert_pasien_luar($data);
		
		redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register']);
		print_r($data);
	}

	public function cetak_faktur($no_pa='')
	{
		$data['no_pa'] = $no_pa;
		$jumlah_vtot=$this->pamdaftar->get_vtot_no_pa($no_pa)->row()->vtot_no_pa;
		if($no_pa!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$data['logo_kesehatan_header'] = "kementriankesehatan.png";
			$data['logo_header'] =  "logo.png";
			$data['kota_header'] = $this->appconfig->get_kota_pdfconfig()->value;
			$data['tgl'] = date("d-m-Y");
			$data['data_pasien']=$this->pamkwitansi->get_data_pasien($no_pa)->row();
			$data['data_pemeriksaan']=$this->pamkwitansi->get_data_pemeriksaan($no_pa)->result();
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

			$html = $this->load->view('paper_css/faktur', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();

			// $this->load->view('paper_css/faktur', $data);
		}else{
			redirect('pa/pacdaftar/','refresh');
		}
	}

	public function cetak_blanko($id_pemeriksaan_pa='')
	{
		if($id_pemeriksaan_pa!=' '){
			$no_register=$this->pamdaftar->get_row_register_by_id_pemeriksaan_pa($id_pemeriksaan_pa)->row()->no_register;
			// foreach($nr as $row){
			// 	$no_register=$row->no_register;
			// }
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_jenis_pa=$this->pamdaftar->get_blanko_jenis_pa($id_pemeriksaan_pa)->row();
			// $data_kategori_pa=$this->pamdaftar->get_blanko_kategori_pa($id_pemeriksaan_pa)->result();
			$nohptelp = "";$almt = "";

			$konten="
					<table  border=\"0\" style=\"padding-top:10px;padding-bottom:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\"><br>$namars
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:12px\">PATOLOGI ANATOMI</font></b><br><br>$alamatrs $kota_kab <br>$telp 
								<br>
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>

					<hr/><br/><br>
					<p align=\"center\"><b>
					BLANKO PEMERIKSAAN PATOLOGI ANATOMI
					</b></p><br/>";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->pamdaftar->get_data_pasien_cetak_by_id_pemeriksaan($id_pemeriksaan_pa)->row();
				$konten=$konten.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No PA</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$data_pasien->no_pa_tindakan</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Pa</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien=$this->pamdaftar->get_data_pasien_cetak_by_id_pemeriksaan($id_pemeriksaan_pa)->row();
				if($data_pasien->sex=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt."$data_pasien->alamat ";
				if($data_pasien->rt!=""){
					$almt = $almt."RT. $data_pasien->rt ";
				}
				if($data_pasien->rw!=""){
					$almt = $almt."RW. $data_pasien->rw ";
				}
				if($data_pasien->kelurahandesa!=""){
					$almt = $almt."$data_pasien->kelurahandesa ";
				}
				if($data_pasien->kecamatan!=""){
					$almt = $almt."$data_pasien->kecamatan ";
				}
				if($data_pasien->kotakabupaten!=""){
					$almt = $almt."<br>$data_pasien->kotakabupaten ";
				}

				if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
					$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
				} else if($data_pasien->no_telp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_telp";
				} else if($data_pasien->no_hp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp."-";
				}

				$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
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
				// $nm_poli=$this->pamdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				$nm_poli=$data_pasien->idrg;
				// if($data_pasien->cara_bayar=='BPJS'){
				// 	$a=$this->pamdaftar->getcr_bayar_bpjs($data_pasien->no_register)->row();
				// 	$cara_bayar= "$a->b";
				// } else if($data_pasien->cara_bayar=='DIJAMIN'){
				// 	$a=$this->pamdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
				// 	$cara_bayar= "$a->a - $a->b";
				// } else {
				// 	$cara_bayar=$data_pasien->cara_bayar;
				// }
				$cara_bayar=$data_pasien->cara_bayar;
				if (substr($no_register,0,2)=='RJ') {
					$nama_dokter=$this->pamdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)=='RI') {
					$nama_dokter=$this->pamdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg." (".$data_pasien->bed.")";
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}
				$konten=$konten.
					"<table  border=\"0\">
						<tr>
							<td width=\"10%\">No PA</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$data_pasien->no_pa_tindakan</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Pa</td>
							<td> : </td>
							<td>$data_pasien->nm_dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>$cara_bayar</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>
								$almt
							</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			$konten=$konten."
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px;
						    font-size:10;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						}
					</style>

					<table class=\"table-isi\" border=\"0\">";
					// foreach ($data_kategori_pa as $rw) {
					// 	$tindakan=strtoupper($rw->nama_jenis);
					// 	// $konten=$konten."
					// 	// 	<tr>
					// 	// 		<th colspan=\"4\"><p align=\"left\">
					// 	// 			<br/><b>$tindakan</b></p>
					// 	// 		</th>
					// 	// 	</tr>";
					// 	foreach($data_jenis_pa as $row){
					// 		if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) {
					// 			$konten=$konten."
					// 				<tr>
					// 					<th colspan=\"4\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
					// 				</tr>";
					// 		}
					// 	}
					// }
					
				$konten=$konten."
					</table>
					<hr>
					<br/>
					<br/>
					<hr>
					<table style=\"padding-left:10px; padding-top:10px; \" style=\"padding-bottom:5px;\">
						<tr>
							<th width=\"20%\"><p align=\"left\">Pemeriksaan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\">
								<p align=\"left\">$data_jenis_pa->nmtindakan<br>
								</p>
							</th>
						</tr>";
				$isi_blanko = json_decode($data_jenis_pa->isi_blanko, true);

				if($data_jenis_pa->jenis_blanko=="1"){
					$konten=$konten."
						<tr>
							<th width=\"100%\" colspan=\"3%\"><h3 align=\"left\"><b>Pemeriksaan Histopatologi</b></h3></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Jenis Sediaan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['jenis_sediaan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Lokasi Jaringan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['lokasi_jaringan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Cairan fiksasi</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['cairan_fiksasi']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Diagnosa Klinik</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['diagnosa_klinik']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Keterangan Klinik</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['keterangan_klinik']."</p></th>
						</tr>
						<hr>
						<tr>
							<th colspan=\"3\"><p align=\"left\"><br><br>Pada penderita ini pernah dilakukan pemeriksaan patalogi Anatomik</p></th>
						</tr>
						<tr>
							<th width=\"30%\"><p align=\"left\">Tanggal : </p></th>
							<th width=\"30%\"><p align=\"left\">No :</p></th>
							<th width=\"40%\"><p align=\"left\">Tempat :</p></th>
						</tr>
					</table>
					";
				}else{
					$konten=$konten."
						<tr>
							<th width=\"100%\" colspan=\"3%\"><h3 align=\"left\"><b>Pemeriksaan Sitologi</b></h3></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Bahan Sediaan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['bahan_sediaan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Cara Pengambilan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['cara_pengambilan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Tanggal Pengambilan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['tanggal_pengambilan']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Cairan Fiksasi</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['cairan_fiksasi']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Diagnosa Klinik</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['diagnosa_klinik']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Keterangan Klinik</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['keterangan_klinik']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Genekologik</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['genekologik']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Status Perkawinan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['status_perkawinan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Hari -1 haid</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['haidminsatu']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Lama Kawin</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['lama_kawin']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Siklus Haid</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['siklus_haid']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Perkawinan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['perkawinan']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Paritas</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['paritas']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Kontrasepsi</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['kontrasepsi']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Menopause</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['menopause']."</p></th>
						</tr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Terapi</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['terapi']."</p></th>
						</tr>
						<hr>
						<tr>
							<th width=\"20%\"><p align=\"left\">Sifat pertanyaan</p></th>
							<th width=\"5%\"><p align=\"left\">:</p></th>
							<th width=\"75%\"><p align=\"left\">".$isi_blanko['sifat_pertanyaan']."</p></th>
						</tr>
						<hr>
						<tr>
							<th colspan=\"3\"><p align=\"left\"><br><br>Pada penderita ini pernah dilakukan pemeriksaan patalogi Anatomik</p></th>
						</tr>
						<tr>
							<th width=\"30%\"><p align=\"left\">Tanggal : </p></th>
							<th width=\"30%\"><p align=\"left\">No :</p></th>
							<th width=\"40%\"><p align=\"left\">Tempat :</p></th>
						</tr>
					</table>
					";
				}
				$konten=$konten."
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%; padding-bottom:5px;\">
						<tr>
							<td width=\"70%\" ></td>
							<td width=\"30%\">
								<p align=\"center\"><br>
								$kota_kab, $tgl								
								
								<br><br><br><br>( Nama Jelas / tanda tangan dokter )
								</p>
							</td>
						</tr>	
					</table>
					";
			
				$file_name="Blanko_PA_".$id_pemeriksaan_pa.".pdf";
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
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/pa/papengisianhasil/'.$file_name, 'FI');
				
				// print_r($a);
		}else{
			// redirect('pa/pacdaftar/','refresh');
		}
	}

	public function update_rujukan_penunjang()
	{
		$no_register = $this->input->post('no_register');
		//  var_dump($no_register);die();
		if ($no_register == null) {
			echo json_encode(array('status' => false));
		} else {
			if (substr($no_register, 0, 2) == 'RJ') {
				$data['pa'] = 1;
				$id = $this->pamdaftar->update_rujukan_penunjang_irj($data, $no_register);
			} else {
				$data['pa'] = 1;
				$id = $this->pamdaftar->update_rujukan_penunjang_iri($data, $no_register);
			}	

			if ($id == true) {
				echo json_encode(array('status' => true));
			} else {
				echo json_encode(array('status' => false));
			}
		}
	}
}