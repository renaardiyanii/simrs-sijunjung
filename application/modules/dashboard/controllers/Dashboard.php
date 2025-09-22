<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once ("Secure_area.php");
class Dashboard extends Secure_area {
	public function __construct() {
		parent::__construct();
        $this->load->model('dashboard/mdashboard','',TRUE);
        $this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('iri/rimpasien','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('master/Mmket_urikes','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('medrec/m_elrecord','',TRUE);
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
		$this->load->model('kepegawaian/M_pegawai','',TRUE);
	}
	
	////FORM VIEW
	public function index()
	{
		$data['title'] = 'Dashboard '.$this->config->item('namars');
		//$data['total_pendapatan'] = $this->mdashboard->get_all_vtot()->result();
        $login_data = $this->load->get_var("user_info");
        $data['roleid']=$this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$this->load->view('dashboard/vdashboard',$data);
	}
	
	public function pasien()
	{
		$data['title'] = 'Pasien '.$this->config->item('namars');
		$this->load->view('dashboard/vpasien',$data);
	}
	
	public function bed($lokasi='')
	{

		if($lokasi==''){
			// $data['title'] = 'Pasien '.$this->config->item('namars');
			// $data['bed'] = $this->mdashboard->get_data_bed()->result();
			// //$data['ruang'] = $this->mdashboard->get_data_ruang()->result();
			// //$data['pasien'] = $this->mdashboard->get_data_pasien_in_bed()->result();
	      	// $data['kapasitas_tot']  =0;
	      	// $data['isi_tot']    	=0;
	      	// $data['kosong_tot']  	=0;
			// foreach ($data['bed'] as $row) {
		    //   	$data['kapasitas_tot']  = $data['kapasitas_tot'] + $row->kapasitas;
		    //   	$data['isi_tot']  = $data['isi_tot'] + $row->isi;
		    //   	$data['kosong_tot']  = $data['kosong_tot'] + $row->kosong;
		    // }
			// $this->load->view('dashboard/vbed',$data);

			$data['title'] = 'Pasien ' . $this->config->item('namars');
			$data['bed'] = $this->mdashboard->get_data_bed_new()->result();

			$this->load->view('dashboard/vbed_new',$data);
		}
		else{
			$data['title'] = 'Data Pasien Ruang : '.strtoupper($lokasi);
			if($lokasi=='semua')
				$lok = '';
			else
				$lok = $lokasi;
			$data['pasien'] = $this->rimpasien->select_pasien_iri_lokasi($lok)->result();
			$this->load->view('dashboard/vbeddetails',$data);	
		}
	}

	public function bed_old()
	{

		// if($lokasi==''){
		// 	$data['title'] = 'Pasien '.$this->config->item('namars');
		// 	$data['bed'] = $this->mdashboard->get_data_bed()->result();
		// 	$data['pasien'] = $this->mdashboard->get_data_pasien_in_bed()->result();
	 //      	$data['kapasitas_tot']  =0;
	 //      	$data['isi_tot']    	=0;
	 //      	$data['kosong_tot']  	=0;
		// 	foreach ($data['bed'] as $row) {
		//       	$data['kapasitas_tot']  = $data['kapasitas_tot'] + $row->bed_kapasitas_real;
		// 	}
		// 	foreach ($data['pasien'] as $row) {
		//       	$data['isi_tot']    	= $data['isi_tot'] + $row->jumlah;
		// 	}
		//     $data['kosong_tot']  	= $data['kapasitas_tot'] - $data['isi_tot'];
		// 	$data['ruang'] = $this->mdashboard->get_data_ruang()->result();
		// 	// print_r(json_encode($data));
		// 	$this->load->view('dashboard/vbed',$data);
		// }else{
		// 	$data['title'] = 'Data Pasien Ruang : '.strtoupper($lokasi);
		// 	if($lokasi=='semua')
		// 		$lok = '';
		// 	else
		// 		$lok = $lokasi;
		// 	$data['pasien'] = $this->rimpasien->select_pasien_iri_lokasi($lok)->result();
		// 	$this->load->view('dashboard/vbeddetails',$data);	
		// }

		$data['data']=$this->mdashboard->get_data_ruang()->result_array();
		$data['kapasitas_tot']  =0;
	    $data['isi_tot']    	=0;
	    $data['kosong_tot']  	=0;

	 //    foreach ($data['bed'] as $row) {
		//       	$data['kapasitas_tot']  = $data['kapasitas_tot'] + $row->bed_kapasitas_real;
		// }
		// foreach ($data['pasien'] as $row) {
		//       	$data['isi_tot']    	= $data['isi_tot'] + $row->jumlah;
		// }

		$data['kosong_tot']  	= $data['kapasitas_tot'] - $data['isi_tot'];
		$data['ruang'] = $this->mdashboard->get_data_ruang()->result();
			// print_r(json_encode($data));
		$this->load->view('dashboard/vbed',$data);
	}
	// added aldi@@

	// manajemen bed
	public function bed_chart()
	{
		$data = [
			'kapasitasBed'=>$this->mdashboard->get_kapasitas_bed(),
			'bed_kosong'=>$this->mdashboard->get_kosong_bed(),
			'title'=>'Manajemen Bed',
		];
		$this->load->view('dashboard/bed/bed',$data);
	}

	public function get_kapasitas_bed()
	{
		$data = $this->mdashboard->get_kapasitas_bed();
		echo json_encode($data);
	}

	public function get_kosong_bed()
	{
		$data = $this->mdashboard->get_kosong_bed();
		echo json_encode($data);
	}

	// manajemen diagnosa terbanyak 10 
	public function top_ten_diagnosa($opsi='RJ',$year='',$month='',$date='')
	{
		$data = [
			'diagnosa'=>$this->mdashboard->get_ten_diagnosa($opsi,$year,$month,$date),
			'title'=>'Daftar Penyakit Terbanyak',
			'year'=>$year,
			'month'=>$month,
			'day'=>$date,
			'opsi'=>$opsi,
		];
		$this->load->view('dashboard/diagnosa/top_ten_diagnosa',$data);
	}
	

	public function get_diagnosa_ten($opsi='RJ',$year='',$month='',$day='')
	{
		$year==''?date('Y'):$year;
		$data = $this->mdashboard->get_ten_diagnosa($opsi,$year,$month,$day);
		echo json_encode($data);
	}

	// manajemen obat terbanyak 10 
	public function top_ten_medicine($year='',$month='',$date='')
	{
		// kalo mau difilter , disebelum year ditambahin $opsi='RJ'
		$data = [
			'medicine'=>$this->mdashboard->get_ten_medicine($year,$month,$date),
			'title'=>'Daftar Obat Terbanyak',
			'year'=>$year,
			'month'=>$month,
			'day'=>$date,
			// ini kalo mau difilter
			// '$opsi'=>$opsi,
		];
		$this->load->view('dashboard/medicine/top_ten_medicine',$data);
	}

	public function get_medicine_ten($year='',$month='',$day='')
	{
		$year==''?date('Y'):$year;
		$data = $this->mdashboard->get_ten_medicine($year,$month,$day);
		echo json_encode($data);
	}




	public function pulang_ranap($lokasi='') {
		if($lokasi==''){
			$data['title'] = 'Pasien '.$this->config->item('namars');
			$data['hasil'] = $this->mdashboard->get_data_bed()->result();
	      	$data['vvip_row']   =0;
	      	$data['vip_row']    =0;
	      	$data['utama_row']  =0;
	      	$data['i_row']      =0;
	      	$data['ii_row']     =0;
	      	$data['iii_row']    =0;
	      	$data['kapasitas_tot']  =0;
	      	$data['isi_tot']    	=0;
	      	$data['kosong_tot']  	=0;
			foreach ($data['hasil'] as $row) {
				if($row->kelas=='VVIP'){
					$data['vvip_row']=$data['vvip_row']+1;
		        }else if($row->kelas=='VIP'){
					$data['vip_row']=$data['vip_row']+1;
		        }else if($row->kelas=='UTAMA'){
					$data['utama_row']=$data['utama_row']+1;
		        }else if($row->kelas=='I'){
					$data['i_row']=$data['i_row']+1;
		        }else if($row->kelas=='II'){
					$data['ii_row']=$data['ii_row']+1;
		        }else if($row->kelas=='III'){
					$data['iii_row']=$data['iii_row']+1;
		        }
		      	$data['kapasitas_tot']  = $data['kapasitas_tot'] + $row->bed_kapasitas_real;
		      	$data['isi_tot']    	= $data['isi_tot'] + $row->bed_isi;
		      	$data['kosong_tot']  	= $data['kosong_tot'] + $row->bed_kosong;
			}
			$this->load->view('dashboard/vtot_pulangranap',$data);
		}else{
			$data['title'] = 'Data Pasien Pulang Ranap '.$lokasi;
			$data['pasien'] = $this->rimpasien->select_pasien_pulang_iri_lokasi($lokasi)->result();
			$this->load->view('dashboard/vpulangranap',$data);	
		}
	}

	public function pulang_ranap_date($lokasi='') {
			$date1=$this->input->post('date1');
			$date2=$this->input->post('date2');			
			$data['title'] = 'Data Pasien Pulang Ranap '.$lokasi;
			$data['pasien'] = $this->rimpasien->select_pasien_pulang_iri_tgl($date1,$date2,$lokasi)->result();
			$this->load->view('dashboard/vpulangranap',$data);	
	}
	
	public function periodik_pendapatan()
	{
		$data['title'] = 'Pendapatan Periodik '.$this->config->item('namars');
		$this->load->view('dashboard/vpendperiodik',$data);
	}
	
	public function pendapatan()
	{
		$data['title'] = 'Pendapatan Pelayanan Pasien '.$this->config->item('namars');
		$this->load->view('dashboard/vpendkeseluruhan',$data);
	}
	
	public function indikator_kinerja()
	{
		$data['title'] = 'Indikato Kinerja '.$this->config->item('namars');
		$this->load->view('dashboard/vindikator_kinerja',$data);
	}
	
	public function poliklinik($id_poli='',$tgl_awal='', $tgl_akhir='')
	{
		if($id_poli==''){
			
			$data['title'] = 'Kunjungan Pasien Poliklinik '.$this->config->item('namars');
		
			$this->load->view('dashboard/vpoliklinik',$data);
		
		}else{
			// echo "<script>console.log( 'Debug Objects: " . $id_poli . "' );</script>";
			
			$data['nm_poli'] = $this->mdashboard->get_nm_poli($id_poli)->row()->nm_poli;
		
			$data['title'] = 'Data Pasien Poliklinik '.$data['nm_poli'];
			if($tgl_awal == $tgl_akhir)
			  $data['tanggal'] = $tgl_awal;
			else
				$data['tanggal'] = date('d-m-Y',strtotime($tgl_awal)).' sampai '.date('d-m-Y',strtotime($tgl_akhir));
			// $data['pasien'] = $this->mdashboard->get_data_poli_pasien($id_poli)->result();
			$data['pasien'] = $this->mdashboard->get_data_poli_pasien_range($id_poli,$tgl_awal, $tgl_akhir)->result();
			$this->load->view('dashboard/vpoliklinikdetails',$data);
		}
	}

	public function lab($no_lab='',$tgl_awal='', $tgl_akhir='')
	{
		if($no_lab==''){
			$data['title'] = 'Kunjungan Pasien Laboratorium '.$this->config->item('namars');
			$this->load->view('dashboard/vlab',$data);
		}else{
			$data['title'] = 'Data Pasien Laboratorium ('.$no_lab.')';
			if($tgl_awal == $tgl_akhir)
				$data['tanggal'] = $tgl_awal;
			else
				$data['tanggal'] = date('d-m-Y',strtotime($tgl_awal)).' sampai '.date('d-m-Y',strtotime($tgl_akhir));
			// $data['pasien'] = $this->mdashboard->get_data_poli_pasien($id_poli)->result();
			$data['pasien'] = $this->mdashboard->get_data_poli_pasien_range($id_poli,$tgl_awal, $tgl_akhir)->result();
			$this->load->view('dashboard/vpoliklinikdetails',$data);
		}
	}

	public function rad($no_rad='',$tgl_awal='', $tgl_akhir='')
	{
		if($no_rad==''){
			$data['title'] = 'Kunjungan Pasien Radiologi '.$this->config->item('namars');
			$this->load->view('dashboard/vrad',$data);
		}else{
			$data['title'] = 'Data Pasien Radiologi ('.$no_rad.')';
			if($tgl_awal == $tgl_akhir)
				$data['tanggal'] = $tgl_awal;
			else
				$data['tanggal'] = date('d-m-Y',strtotime($tgl_awal)).' sampai '.date('d-m-Y',strtotime($tgl_akhir));
			// $data['pasien'] = $this->mdashboard->get_data_poli_pasien($id_poli)->result();
			$data['pasien'] = $this->mdashboard->get_data_poli_pasien_range($id_poli,$tgl_awal, $tgl_akhir)->result();
			$this->load->view('dashboard/vpoliklinikdetails',$data);
		}
	}
	
	public function poli()
	{
		$data['title'] = 'Pasien Poliklinik '.$this->config->item('namars');
		$data['pilihpoli'] = $this->mdashboard->get_data_poli()->result();

		$this->load->view('dashboard/vpilihpoli',$data);
	}
	
	public function diagnosa()
	{
		$data['title'] = '10 Diagnosa Terbanyak '.$this->config->item('namars');

		$this->load->view('dashboard/vdiagnosa',$data);	
	}
	
	public function farmasi()
	{
		$data['title'] = '10 Obat Terlaris '.$this->config->item('namars');

		$this->load->view('dashboard/vfarmasi',$data);	
	}

    public function farmasi_pembelian()
    {
        $data['title'] = 'Pembelian Obat '.$this->config->item('namars');
        $data['pembelian'] = $this->mdashboard->get_pembelian_obat()->result();

        $this->load->view('dashboard/vfarmasipembelian',$data);
    }

    public function farmasi_amprah(){
        $data['title'] = 'Amprah & Distribusi '.$this->config->item('namars');

        $this->load->view('dashboard/vamprah',$data);
    }



    public function farmasi_stok(){
    	$data['title'] = 'Laporan Stok '.$this->config->item('namars');

    	$this->load->view('dashboard/vstokfarmasi', $data);
	}

	function get_detail_farmasi_pembelian(){
        $line  = array();
        $line2 = array();
        $row2  = array();
        $hasil = $this->Frmmpo->get_po_detail_list($this->input->post('id'));

        $total = 0;
        foreach ($hasil as $value) {
            $row2['description'] = $value->description;
            $row2['satuank'] = $value->satuank;
            $row2['qty_po'] = "<p align='right'>".number_format($value->qty, '0', ',', '.')."</p>";
            $row2['hargabeli'] = "<p align='right'>".number_format($value->harga_po, '0', ',', '.')."</p>";
            $row2['subtotal'] = "<p align='right'>".number_format($value->subtotal, '0', ',', '.')."</p>";
            $total += $value->subtotal;
            $line2[] = $row2;
        }
        $line['data'] = $line2;
        $line['total'] = number_format($total, '2', ',', '.');

        echo json_encode($line);
    }

	public function urikes()
	{
		$data['title'] = 'URIKES '.$this->config->item('namars');
		$data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
        $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
        $data['diagnosa']=$this->mdashboard->get_diagnosa()->result();
		$this->load->view('dashboard/vurikes',$data);
	}
	public function aset(){
    	$data['title'] = 'Laporan Aset '.$this->config->item('namars');

    	$this->load->view('dashboard/vaset',$data);
	}

	public function get_data_periodik(){
		//$tahun_akhir=$this->input->post('tahun');
		$tahun_akhir='2016';
		$tahun_awal=$tahun_akhir-3;
		$a=array();
		$b=array();
		$c=array();
		$tableau=array();
		$bulan=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		$datajson=$this->mdashboard->get_data_periodik($tahun_awal, $tahun_akhir)->result();
		
		foreach($datajson as $row){
			if(substr($row->bln,0,4)==$tahun_akhir-2){
				$a[]=$row->pendapatan;
			} else if(substr($row->bln,0,4)==$tahun_akhir-1){
				$b[]=$row->pendapatan;
			} else if(substr($row->bln,0,4)==$tahun_akhir){
				$c[]=$row->pendapatan;
			}
		}
	
		for($i=0;$i<12;$i++){
    		$tableau[]=array("y" => $bulan[$i],"a" => $a[$i], "b" => $b[$i], "c" => $c[$i]);
		}

	    echo json_encode($tableau);
	}

	public function get_data_pasien(){
		$datajson=$this->mdashboard->get_data_pasien()->result();
	    echo json_encode($datajson);
	}
	
	public function get_data_pasien_range(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		// $datajson=$this->mdashboard->get_data_pasien_range('2017-02-01', '2017-02-28')->result();
		$datajson=$this->mdashboard->get_data_pasien_range($tgl_awal, $tgl_akhir)->result();
		$umum = "UMUM";
		$jumlah_umum = "0";
		$total_umum = "0";
		$bpjs = "BPJS";
		$jumlah_bpjs = "0";
		$total_bpjs = "0";
		$dijamin = "DIJAMIN";
		$jumlah_dijamin = "0";
		$total_dijamin = "0";

		foreach ($datajson as $row) {
			if($row->cara_bayar == "UMUM"){
				$jumlah_umum = $row->jumlah;
				$total_umum = $row->total;
			}
			if($row->cara_bayar == "BPJS"){
				$jumlah_bpjs = $row->jumlah;
				$total_bpjs = $row->total;
			}
			if($row->cara_bayar == "DIJAMIN"){
				$jumlah_dijamin = $row->jumlah;
				$total_dijamin = $row->total;
			} 
		}

		$arrayhasil[] = array('cara_bayar' => "UMUM", 'jumlah' => $jumlah_umum, 'total' => $total_umum);
		$arrayhasil[] = array('cara_bayar' => "BPJS", 'jumlah' => $jumlah_bpjs, 'total' => $total_bpjs);
		$arrayhasil[] = array('cara_bayar' => "DIJAMIN", 'jumlah' => $jumlah_dijamin, 'total' => $total_dijamin);

	    echo json_encode($arrayhasil);
	}

	public function get_data_kunjungan(){

		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_kunjungan_poli($tgl_awal, $tgl_akhir)->result();
		$datachart=[];
		$i=0;
		
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->nama, 'y' => (int)$row->total];
			$i++;
		}
	    echo json_encode($datachart);
	}

	public function get_total_kunjungan_poli(){
		$data['total_pasien']=$this->mdashboard->get_total_kunjungan_poli()->row()->total_pasien;
	    echo json_encode($data);
	}

	public function get_total_kunjungan_poli_range($tgl_awal='', $tgl_akhir=''){
		
		$data['total_pasien']=$this->mdashboard->get_total_kunjungan_poli_range($tgl_awal, $tgl_akhir)->row()->total_pasien;
	    echo json_encode($data);
	}

	public function get_data_kunjungan_perhari(){
		$id_poli=$this->input->post('id_poli');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_kunjungan_poli_perhari($id_poli, $tgl_awal, $tgl_akhir)->result();
	    // echo json_encode($datajson);
		$datachart=[];
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->tgl, 'y' => (int)$row->total];
			$i++;
		}
	    echo json_encode($datachart);
	}

	public function get_data_pendapatan_old(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_pendapatan($tgl_awal, $tgl_akhir)->result();
		$datachart="";
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->label, 'y' => (int)$row->value];
			$i++;
		}
	    echo json_encode($datachart);
	}

	public function get_data_pendapatan(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		// $datajson=$this->mdashboard->get_data_pendapatan($tgl_awal, $tgl_akhir)->result();
		// $datachart="";
		// $i=0;
		// foreach ($datajson as $row) {
		// 	$datachart[$i] = ['name' => $row->label, 'y' => (int)$row->value];
		// 	$i++;
		// }
	 //    echo json_encode($datachart);

		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_today()->result();
		}else{
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$line2[0][0] = 0;
		$line2[0][1] = 0;
		$line2[0][2] = 0;
		$line2[0][3] = 0;
		$line2[1][0] = 0;
		$line2[1][1] = 0;
		$line2[1][2] = 0;
		$line2[1][3] = 0;
		$line2[2][0] = 0;
		$line2[2][1] = 0;
		$line2[2][2] = 0;
		$line2[2][3] = 0;

		$i=1;
		foreach ($hasil as $value) {
			if($value->cara_bayar == "UMUM"){
				if($value->jenis == "rawat jalan"){
					$line2[0][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[0][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[0][2] = $value->total;
				}elseif($value->jenis == "penunjang"){
					$line2[0][3] = $value->total;
				}
			}elseif($value->cara_bayar == "BPJS"){
				if($value->jenis == "rawat jalan"){
					$line2[1][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[1][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[1][2] = $value->total;
				}elseif($value->jenis == "penunjang"){
					$line2[1][3] = $value->total;
				}
			}elseif($value->cara_bayar == "KERJASAMA"){
				if($value->jenis == "rawat jalan"){
					$line2[2][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[2][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[2][2] = $value->total;
				}elseif($value->jenis == "penunjang"){
					$line2[2][3] = $value->total;
				}
			}			
		}


		$datachart["UMUM"] = ['name' => "UMUM", 'y' => (array)$line2[0]];
		$datachart["BPJS"] = ['name' => "BPJS", 'y' => (array)$line2[1]];
		$datachart["KERJASAMA"] = ['name' => "KERJASAMA", 'y' => (array)$line2[2]];

				
		// $line2[] = $row;
		// $line['data'] = $line2;
					
		// echo json_encode($line);	    
		echo json_encode($datachart);
	}

	public function get_data_diagnosa_ird(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		//$datajson=$this->mdashboard->get_data_diagnosa_irj()->result();
		$datajson=$this->mdashboard->get_data_diagnosa_ird($tgl_awal, $tgl_akhir)->result();
		$datachart="";
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->nama, 'y' => (int)$row->jumlah];
			$i++;
		}

	    echo json_encode($datachart);
	}

	public function get_data_diagnosa_irj(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		//$datajson=$this->mdashboard->get_data_diagnosa_irj()->result();
		$datajson=$this->mdashboard->get_data_diagnosa_irj($tgl_awal, $tgl_akhir)->result();
		$datachart="";
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->nama, 'y' => (int)$row->jumlah];
			$i++;
		}
	    
	    echo json_encode($datachart);
	}

	public function get_data_diagnosa_iri(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		//$datajson=$this->mdashboard->get_data_diagnosa_irj()->result();
		$datajson=$this->mdashboard->get_data_diagnosa_iri($tgl_awal, $tgl_akhir)->result();
		$datachart="";
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->nama, 'y' => (int)$row->jumlah];
			$i++;
		}

	    echo json_encode($datachart);
	}

	public function get_data_vtot(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_vtot($tgl_awal, $tgl_akhir)->row()->vtot;
	    echo json_encode($datajson);
	}

	public function get_data_obat(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_obat($tgl_awal, $tgl_akhir)->result();
		$datachart="";
		$i=0;
		foreach ($datajson as $row) {
			$datachart[$i] = ['name' => $row->nama, 'y' => (int)$row->jumlah];
			$i++;
		}
	    echo json_encode($datachart);
	}

	//EXPORT 
	public function export_excel($tgl_awal='', $tgl_akhir='')
	{
		$data['title'] = 'Diagnosa Terbanyak';

		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($this->config->item('namars'))  
		        ->setLastModifiedBy($this->config->item('namars'))  
		        ->setTitle("Diagnosa Terbanyak ")  
		        ->setSubject("Diagnosa Terbanyak  Document")  
		        ->setDescription("Diagnosa Terbanyak  for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("")  
		        ->setCategory("Diagnosa Terbanyak");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$data_irj=$this->mdashboard->get_excel_diagnosa_irj($tgl_awal,$tgl_akhir)->result();
		$data_ird=$this->mdashboard->get_excel_diagnosa_ird($tgl_awal,$tgl_akhir)->result();
		$data_iri=$this->mdashboard->get_excel_diagnosa_iri($tgl_awal,$tgl_akhir)->result();
			
		$objPHPExcel=$objReader->load(APPPATH.'third_party/10_diagnosa.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)));
		$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Diagnosa Rawat Jalan');
		$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Diagnosa Rawat Darurat');
		$objPHPExcel->getActiveSheet()->SetCellValue('K4', 'Diagnosa Rawat Inap');
		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Jumlah');
		$rowCount=6;
		$i=1;
		foreach($data_irj as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jumlah);
		 	$i++;
		 	$rowCount++;
		}
		$rowCount=6;
		$i=1;
		foreach($data_ird as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->jumlah);
		 	$i++;
			$rowCount++;
		}
		$rowCount=6;
		$i=1;
		foreach($data_iri as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->jumlah);
		 	$i++;
		 	$rowCount++;
		}
		header('Content-Disposition: attachment;filename="10_Diagnosa_Terbanyak.xlsx"');  
		
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('10 Diagnosa');  
		   
		   
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean();  
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');  
		header('Cache-Control: max-age=0');  
		   
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');  
	}
	
	public function kunj_poli($tgl_awal='', $tgl_akhir='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_kunj_poli_today()->result();
		}else{
			$hasil = $this->mdashboard->get_kunj_poli_range($tgl_awal, $tgl_akhir)->result();
		}
		//decho json_encode($hasil);
		$i=1;
		$row2['sum_bpjs_kes'] 	=0;
		$row2['sum_kerjasama'] 	=0;
		$row2['sum_umum'] 		=0;
		$row2['sum_total'] 		=0;
		foreach ($hasil as $value) {
			$row2['rank'] 	= $i++;
			$row2['nm_poli'] 	= '<a href="'.site_url('dashboard/poliklinik').'/'.$value->id_poli.'/'.$tgl_awal.'/'.$tgl_akhir.'"><b style="color:black">'.$value->nm_poli.'</b></a>';
			$row2['kerjasama'] 		= '<center>'.$value->kerjasama.'</center>';
			$row2['umum'] 		= '<center>'.$value->umum.'</center>';
			$row2['bpjs_kes'] 	= '<center>'.$value->bpjs.'</center>';
			$row2['total'] 		= '<center><h5><b>'.$value->total.'</b></h5></center>';
			$row2['sum_kerjasama'] 	+= $value->kerjasama;
			$row2['sum_umum'] 		+= $value->umum;
			$row2['sum_bpjs_kes'] 	+= $value->bpjs;
			$row2['sum_total'] 		+= $value->total;

			$line2[] = $row2;
		}
		$row['rank'] 		= '';
		$row['nm_poli'] 	= '<h5><b>TOTAL PASIEN :</b></h5>';
		$row['kerjasama'] 	= '<center><h5><b>'.$row2['sum_kerjasama'].'</b></h5></center>';
		$row['umum'] 		= '<center><h5><b>'.$row2['sum_umum'].'</b></h5></center>';
		$row['bpjs_kes'] 	= '<center><h5><b>'.$row2['sum_bpjs_kes'].'</b></h5></center>';
		$row['total'] 		= '<center><h5><b>'.$row2['sum_total'].'</b></h5></center>';
					
		$line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function pendapatan_keseluruhan($tgl_awal='', $tgl_akhir='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_today()->result();
		}else{
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$line2[0][0] = "<b>Rawat Jalan</b>";
		$line2[1][0] = "<b>Rawat Darurat</b>";
		$line2[2][0] = "<b>Rawat Inap</b>";
		$line2[3][0] = "<b>Penunjang</b>";

		$line2[0][1] = 0;
		$line2[1][1] = 0;
		$line2[2][1] = 0;
		$line2[3][1] = 0;
		$line2[0][2] = 0;
		$line2[1][2] = 0;
		$line2[2][2] = 0;
		$line2[3][2] = 0;
		$line2[0][3] = 0;
		$line2[1][3] = 0;
		$line2[2][3] = 0;
		$line2[3][3] = 0;

		$i=1;
		foreach ($hasil as $value) {
			if($value->jenis == "rawat jalan"){
				if($value->cara_bayar == "UMUM"){
					$line2[0][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[0][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "KERJASAMA"){
					$line2[0][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "rawat darurat"){
				if($value->cara_bayar == "UMUM"){
					$line2[1][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[1][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "KERJASAMA"){
					$line2[1][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "rawat inap"){
				if($value->cara_bayar == "UMUM"){
					$line2[2][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[2][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "KERJASAMA"){
					$line2[2][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "penunjang"){
				if($value->cara_bayar == "UMUM"){
					$line2[3][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[3][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "KERJASAMA"){
					$line2[3][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}
		}
				
		// $line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function indikator_ruang($start='',$end='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		$ruang = $this->mdashboard->get_all_ruang_tt()->result();

		$i=0;
		foreach ($ruang as $value) {
			// $hasil = $this->mdashboard->get_ldhp($start,$end,$value->lokasi)->result();
			$hp = $this->mdashboard->get_ldhp($start,$end,$value->lokasi)->row()->hp;
			$ld = $this->mdashboard->get_ldhp($start,$end,$value->lokasi)->row()->ld;

			//BOR = ( jum hari perawatan / (jumlah tt * jumlah hari dalam 1 periode) ) * 100%
			$datetime1 = date_create(date("Y-m-t", strtotime($end.'-01')));
		    $datetime2 = date_create($start."-01");
		    
		    $interval = date_diff($datetime1, $datetime2);
		    
			$jumlah_hari_dalah_periode = $interval->format('%a')+1;
			// $jumlah_hari_dalah_periode = date("t", strtotime($bln_thn));
			$bor = ( $hp / ( $value->jumlah_bed * $jumlah_hari_dalah_periode ) ) * 100 ;

			//LOS = jumlah lama dirawat / jumlah pasien keluar
			//TOI = ( (jumlah tempat tidur * periode ) - jum hari perawatan ) / jumlah pasien keluar
			//BTO = jumlah pasien keluar / jumlah tempat tidur
			
			if($this->mdashboard->get_jum_pas_keluar($start,$end,$value->lokasi)->num_rows()==0){
				$j_p_k=0;
			}else{
				$j_p_k = $this->mdashboard->get_jum_pas_keluar($start,$end,$value->lokasi)->row()->jumlah_pasien_keluar;
			}
			if($j_p_k==0){
				$los = 0;
				$bto = 0;
				$toi = 0;
			}else{
				$los = $ld / $j_p_k;
				$bto = $j_p_k / $value->jumlah_bed;
				$toi = ( ($value->jumlah_bed * $jumlah_hari_dalah_periode ) - $hp ) / $j_p_k;
			}
			
			$line2[$i][0] = $value->lokasi;
			$line2[$i][1] = $value->jumlah_bed;
			$line2[$i][2] = number_format($bor,2)." %";
			$line2[$i][3] = number_format($los,2);
			$line2[$i][4] = number_format($toi,2);
			$line2[$i][5] = number_format($bto,2);
			$i++;
		}
				
		// $line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function indikator_kelas($start='',$end='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		$kelas = $this->mdashboard->get_all_kelas_tt()->result();

		$i=0;
		foreach ($kelas as $value) {
			// $hasil = $this->mdashboard->get_ldhp_kelas($start,$end,$value->kelas)->result();
			$hp = $this->mdashboard->get_ldhp_kelas($start,$end,$value->kelas)->row()->hp;
			$ld = $this->mdashboard->get_ldhp_kelas($start,$end,$value->kelas)->row()->ld;

			//BOR = ( jum hari perawatan / (jumlah tt * jumlah hari dalam 1 periode) ) * 100%
			$datetime1 = date_create(date("Y-m-t", strtotime($end.'-01')));
		    $datetime2 = date_create($start."-01");
		    
		    $interval = date_diff($datetime1, $datetime2);
		    
			$jumlah_hari_dalah_periode = $interval->format('%a')+1;
			// $jumlah_hari_dalah_periode = date("t", strtotime($bln_thn));
			$bor = ( $hp / ( $value->jumlah_bed * $jumlah_hari_dalah_periode ) ) * 100 ;

			//LOS = jumlah lama dirawat / jumlah pasien keluar
			//TOI = ( (jumlah tempat tidur * periode ) - jum hari perawatan ) / jumlah pasien keluar
			//BTO = jumlah pasien keluar / jumlah tempat tidur
			
			if($this->mdashboard->get_jum_pas_keluar_kelas($start,$end,$value->kelas)->num_rows()==0){
				$j_p_k=0;
			}else{
				$j_p_k = $this->mdashboard->get_jum_pas_keluar_kelas($start,$end,$value->kelas)->row()->jumlah_pasien_keluar;
			}
			if($j_p_k==0){
				$los = 0;
				$bto = 0;
				$toi = 0;
			}else{
				$los = $ld / $j_p_k;
				$bto = $j_p_k / $value->jumlah_bed;
				$toi = ( ($value->jumlah_bed * $jumlah_hari_dalah_periode ) - $hp ) / $j_p_k;
			}

			$line2[$i][0] = $value->kelas;
			$line2[$i][1] = $value->jumlah_bed;
			$line2[$i][2] = number_format($bor,2)." %";
			$line2[$i][3] = number_format($los,2);
			$line2[$i][4] = number_format($toi,2);
			$line2[$i][5] = number_format($bto,2);
			$i++;
		}
				
		// $line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function indikator_rs($start='',$end='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		$jumlah_bed = $this->mdashboard->get_all_rs_tt()->row()->jumlah_bed;

		$i=0;
		$hp = $this->mdashboard->get_ldhp_rs($start,$end)->row()->hp;
		$ld = $this->mdashboard->get_ldhp_rs($start,$end)->row()->ld;

		//BOR = ( jum hari perawatan / (jumlah tt * jumlah hari dalam 1 periode) ) * 100%
		$datetime1 = date_create(date("Y-m-t", strtotime($end.'-01')));
	    $datetime2 = date_create($start."-01");
	    
	    $interval = date_diff($datetime1, $datetime2);
	    
		$jumlah_hari_dalah_periode = $interval->format('%a')+1;
		// $jumlah_hari_dalah_periode = date("t", strtotime($bln_thn));
		$bor = ( $hp / ( $jumlah_bed * $jumlah_hari_dalah_periode ) ) * 100 ;

		//LOS = jumlah lama dirawat / jumlah pasien keluar
		//TOI = ( (jumlah tempat tidur * periode ) - jum hari perawatan ) / jumlah pasien keluar
		//BTO = jumlah pasien keluar / jumlah tempat tidur
		
		$jum_pas_keluar = $this->mdashboard->get_jum_pas_keluar_rs($start,$end);
		if($jum_pas_keluar->num_rows()==0){
			$j_p_k=0;
		}else{
			$j_p_k = $jum_pas_keluar->row()->jumlah_pasien_keluar;
		}
		if($j_p_k==0){
			$los = 0;
			$bto = 0;
			$toi = 0;
		}else{
			$los = $ld / $j_p_k;
			$bto = $j_p_k / $jumlah_bed;
			$toi = ( ($jumlah_bed * $jumlah_hari_dalah_periode ) - $hp ) / $j_p_k;
		}

		//NDR = ( Jumlah pasien mati > 48 jam / Jumlah pasien keluar (hidup + mati)) X 1000 permil
		//GDR = ( Jumlah pasien mati seluruhnya / Jumlah pasien keluar (hidup + mati)) X 1000 permil

		$jum_pas_keluar_mati_48jam = $this->mdashboard->get_jum_pas_keluar_rs_mati_48jam($start,$end)->row()->jumlah_pasien_keluar;
		$jum_pas_keluar_mati = $this->mdashboard->get_jum_pas_keluar_rs_mati($start,$end)->row()->jumlah_pasien_keluar;
		$jum_pas_keluar_seluruh = $this->mdashboard->get_jum_pas_keluar_rs_seluruh($start,$end)->row()->jumlah_pasien_keluar;

		$ndr = ( $jum_pas_keluar_mati_48jam / $jum_pas_keluar_seluruh ) * 1000;
		$gdr = ( $jum_pas_keluar_mati / $jum_pas_keluar_seluruh ) * 1000;

		$line2[$i][0] = $jumlah_bed;
		$line2[$i][1] = number_format($bor,2)." %";
		$line2[$i][2] = number_format($los,2);
		$line2[$i][3] = number_format($toi,2);
		$line2[$i][4] = number_format($bto,2);
		$line2[$i][5] = number_format($ndr,2)." ‰";
		$line2[$i][6] = number_format($gdr,2)." ‰";
				
		// $line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	public function data_bed(){
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->mdashboard->get_data_bed()->result();
		/*echo json_encode($hasil);*/
		$i=1;
		foreach ($hasil as $value) {
			$row2['rank'] 	= $i++;
			$row2['kelas'] 	= $value->kelas;
			$row2['lokasi'] 	= $value->lokasi;
			$row2['bed_kapasitas_real'] 	= $value->bed_kapasitas_real;
			$row2['bed_utama'] 	= $value->bed_utama;
			$row2['bed_cadangan'] 	= $value->bed_cadangan;
			$row2['bed_isi'] 	= $value->bed_isi;
			$row2['bed_kosong'] = $value->bed_kosong;
	
			$line2[] = $row2;
		}

		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function kunj_lab($tgl_awal='', $tgl_akhir='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_kunj_lab_today()->result();
		}else{
			$hasil = $this->mdashboard->get_kunj_lab_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$i=1;
		foreach ($hasil as $value) {
			$row['rank'] 	= $i++;
			// $row['no_lab'] 	= '<a href="'.site_url('dashboard/lab').'/'.$value->no_lab.'/'.$tgl_awal.'/'.$tgl_akhir.'"><b style="color:black">'.$value->no_lab.'</b></a>';
			$row['no_lab'] 	= '<center>'.$value->no_lab.'</center>';
			$row['no_register'] 	= '<center>'.$value->no_register.'</center>';
			$row['no_cm'] 	= '<center>'.$value->no_cm.'</center>';
			$row['tgl_kunjungan'] 	= '<center>'.$value->tgl_kunjungan.'</center>';
			$row['nama'] 	= '<center>'.$value->nama.'</center>';
			$tind = explode(",",$value->tindakan);
			$tind1 = "";
			foreach ($tind as $str) {
    			$tind1 = $tind1 . "<li>".$str."</li>";
			}
			$row['tindakan'] = '<ul>'.$tind1.'</ul>';
			//$tind = $this->mdashboard->get_tind_lab($value->no_lab)->result();
			//$tindakan = "<ul>";
			//foreach ($tind as $val) {
			//	$tindakan .= "<li>".$val->jenis_tindakan."</li>";
			//}
			//$tindakan .= "</ul>";
			//$row['tindakan'] = $tindakan;
			$line2[] = $row;
		}
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function kunj_rad($tgl_awal='', $tgl_akhir='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_kunj_rad_today()->result();
		}else{
			$hasil = $this->mdashboard->get_kunj_rad_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$i=1;
		foreach ($hasil as $value) {
			$row['rank'] 	= $i++;
			// $row['no_rad'] 	= '<a href="'.site_url('dashboard/rad').'/'.$value->no_rad.'/'.$tgl_awal.'/'.$tgl_akhir.'"><b style="color:black">'.$value->no_rad.'</b></a>';
			$row['no_rad'] 	= '<center>'.$value->no_rad.'</center>';
			$row['no_register'] 	= '<center>'.$value->no_register.'</center>';
			$row['no_cm'] 	= '<center>'.$value->no_cm.'</center>';
			$row['tgl_kunjungan'] 	= $value->tgl_kunjungan;
			$row['nama'] 	= '<center>'.$value->nama.'</center>';
			$tind = explode(",",$value->tindakan);
			$tind1 = "";
			foreach ($tind as $str) {
    			$tind1 = $tind1 . "<li>".$str."</li>";
			}
			$row['tindakan'] = '<ul>'.$tind1.'</ul>';
			$line2[] = $row;
		}
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

    public function data_stok(){
        $line  = array();
        $line2 = array();
        $row2  = array();

        $hasil = $this->mdashboard->get_data_stok(1)->result();
        $i=1;
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['gudang'] = $value->nama_gudang;
            $row2['obat'] = $value->nm_obat;
            $row2['satuan'] = $value->satuank;
            $row2['qty'] 	= "<div align=\"right\">".number_format($value->qty, '0', ',', '.')."</div>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    } 

    //  public function data_pasien_urikes($date1='',$date2='',$ket_urikes='',$kesatuan=''){
    //     $line  = array();
    //     $line2 = array();
    //     $row2  = array();
    //     if ($date1==null || $date1==''){
    //     		$date1 = date('y-m-d');
    //     		$date2 = date('y-m-d');	
    //     }else{
    //     	$date1=$date1;
    //     	$date2=$date2;
    //     }
    //     $kst3_id='';
    //     $kst2_id='';
    //     $kst_id='';

    //     if ($kesatuan!='') {
    //         $kesatuan = explode("-",$kesatuan);
    //         $kst_id=$kesatuan[0];               
    //         if ($kesatuan[1]) {
    //             $kst2_id=$kesatuan[1];
    //         }   
    //         if ($kesatuan[2]) {
    //             $kst3_id=$kesatuan[2];
    //         }   
    //      }
    //     $hasil = $this->mdashboard->get_data_urikes($date2,$date1,$kst_id,$kst2_id,$kst3_id,$ket_urikes)->result();
    //     $i=1;
    //     foreach ($hasil as $value) {
    //         $row2['no'] = $i++;
    //         $row2['tgl_kunjungan'] = date('d-m-y',strtotime($value->tgl_pemeriksaan));
    //         $row2['nama'] = $value->nama;
    //         $row2['umur'] = $value->umur;
    //         $row2['pangkat'] = $value->pangkat;
    //         $row2['nip'] = $value->nip;
    //         if ($value->kes3_nama!=null) {
	   //          $row2['kesatuan'] = $value->kes_nama ." | ". $value->kes2_nama." | ". $value->kes3_nama ;
    //         }elseif($value->kes2_nama!=null and $value->kes3_nama==null){
    //         	$row2['kesatuan'] = $value->kes_nama ." | ". $value->kes2_nama ;
    //         }elseif($value->kes_nama!=null){
    //         	$row2['kesatuan'] = $value->kes_nama;
    //         }else{
    //         	$row2['kesatuan'] ='';
    //         }
    //         $row2['sf_umum'] = $value->sf_umum;
    //         $row2['sf_atas'] = $value->sf_atas;
    //         $row2['sf_bawah'] = $value->sf_bawah;
    //         $row2['sf_dengar'] = $value->sf_dengar;
    //         $row2['sf_lihat'] = $value->sf_lihat;
    //         $row2['sf_gigi'] = $value->sf_gigi;
    //         $row2['sf_jiwa'] = $value->sf_jiwa;
    //         $row2['statkes'] = $value->statkes;
    //         $row2['catatan'] = $value->nama_ket_urikes;
    //         $row2['aksi'] = "<a href='".site_url("dashboard/data_hasil_urikes/".$value->idurikes)."'class='btn btn-danger btn-xs' style='width:50px;'>Hasil</a> ";


    //         $line2[] = $row2;
    //     }

    //     $line['data'] = $line2;

    //     echo json_encode($line);
    // }

    public function data_pasien_urikes(){
    	$date1 = $this->input->post('date_picker_awal');
    	$date2 = $this->input->post('date_picker_akhir');
    	$kesatuan = $this->input->post('kesatuan');
    	$ket = $this->input->post('ket_urikes');
    	$diag = $this->input->post('diagnosa');

    	if($date1 == ''){
    		$date1 = date('Y-m-d');
    	}

		if($date2 == ''){
    		$date2 = date('Y-m-d');
    	}

    	if($kesatuan == ''){
    		$kesatuan = '';
    	}

    	if($ket == ''){
    		$ket = '';
    	} 

    	if($diag == ''){
    		$diag = '';
    	}    	

        $line  = array();
        $line2 = array();
        $row2  = array();

        $kst3_id='';
        $kst2_id='';
        $kst_id='';

        $hasil = $this->mdashboard->get_data_urikes($date1, $date2, $kesatuan, $ket, $diag);
        $i=1;
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['tgl_kunjungan'] = date('d-m-y',strtotime($value->tgl_pemeriksaan));
            $row2['nama'] = $value->nama;
            $row2['umur'] = $value->umur;
            $row2['nip'] = $value->nip;
            $row2['pangkat'] = $value->pangkat;
            if ($value->kes3_nama!=null) {
	            $row2['kesatuan'] = $value->kes_nama ." | ". $value->kes2_nama." | ". $value->kes3_nama ;
            }elseif($value->kes2_nama!=null and $value->kes3_nama==null){
            	$row2['kesatuan'] = $value->kes_nama ." | ". $value->kes2_nama ;
            }elseif($value->kes_nama!=null){
            	$row2['kesatuan'] = $value->kes_nama;
            }else{
            	$row2['kesatuan'] ='';
            }
            $row2['sf_umum'] = $value->sf_umum;
            $row2['sf_atas'] = $value->sf_atas;
            $row2['sf_bawah'] = $value->sf_bawah;
            $row2['sf_dengar'] = $value->sf_dengar;
            $row2['sf_lihat'] = $value->sf_lihat;
            $row2['sf_gigi'] = $value->sf_gigi;
            $row2['sf_jiwa'] = $value->sf_jiwa;
            $row2['statkes'] = $value->statkes;
            $row2['catatan'] = $value->nama_ket_urikes;
            $row2['diagnosa'] = $value->diagnosa;
            $row2['aksi'] = "<a href='".site_url("dashboard/data_hasil_urikes/".$value->idurikes)."'class='btn btn-danger btn-xs' style='width:50px;'>Hasil</a> ";
            $line2[] = $row2;
        }

        $line['data'] = $line2;
    	echo json_encode($line);
	}

     public function get($bln_thn,$lok){
		$hasil = $this->mdashboard->get_jum_pas_keluar($bln_thn,$lok)->row()->jumlah_pasien_keluar;

        echo $hasil;
    }

    public function data_medrec_pasien($no_medrec=""){
		if($no_medrec!=''){
			$data['title'] = 'ELEKTRONIK MEDICAL RECORD ';

			$data['data_pasien'] = $this->m_elrecord->get_data_pasien($no_medrec)->row();
			$data['kunj_jalan'] = $this->m_elrecord->get_kunj_rj($no_medrec)->result();
			$data['count_kunj_jalan'] = count($data['kunj_jalan']);
			$data['kunj_inap'] = $this->m_elrecord->get_kunj_ri($no_medrec)->result();
			$data['count_kunj_inap'] = count($data['kunj_inap']);
			$data['data_farmasi'] = $this->m_elrecord->get_kunj_farmasi($no_medrec)->result();
			$data['count_data_farmasi'] = count($data['data_farmasi']);
			$data['data_lab'] = $this->m_elrecord->get_data_lab($no_medrec)->result();
			$data['count_data_lab'] = count($data['data_lab']);

			$data['data_rad'] = $this->m_elrecord->get_data_rad($no_medrec)->result();
			$data['count_data_rad'] = count($data['data_rad']);
			$data['data_ok'] = $this->m_elrecord->get_data_ok($no_medrec)->result();
			$data['count_data_ok'] = count($data['data_ok']);
			
			$this->load->view('medrec/v_pasien2',$data);
			// print_r(json_encode($data['data_pasien']));
		}
		
	}

	public function data_hasil_urikes($idurikes){
		$data_hasil = $this->mdashboard->get_hasil_urikes($idurikes)->result();
		foreach ($data_hasil as $row) {
			if ($row->kelompok=='M' && $row->tingkatan!='PATI' && $row->luar_negri='ya' ) {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        } else if ($row->kelompok=='X' && $row->luar_negri=='ya') {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/medical_exam").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        } else if ($row->kelompok=='X' || $row->tingkatan=='PATI') {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_umum").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        } else if ($row->kelompok=='M' && $row->luar_negri=='ya') {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/medical_exam").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        } else if ($row->kelompok=='MT') {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        }else if ($row->kelompok=='Z') {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/urikes_skd").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        } else {
	            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_umum").'/'.$idurikes.'", "_blank");window.focus()</script>';
	        }
    	}
    	redirect('dashboard/urikes','refresh');
	}

	public function cari_pasien($cm='')
	{
		$data['title'] = 'Cari Pasien';
		$data['data_pasien'] = "";

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
		
		// if (empty($data['data_pasien'])==1) 
		// {
		// 	$success = 	'<div class="alert alert-danger">
  //                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  //                           <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
  //                       </div>';
		// 	$this->session->set_flashdata('success_msg', $success);
		// 	$this->load->view('dashboard/vcaripasien',$data);	
		// } else 
		if($data['data_pasien']==""){
			$this->load->view('dashboard/vcaripasien',$data);	
		} else{
			$this->load->view('dashboard/vcaripasien',$data);
		}
		
	}

	public function data_aset(){
        $line  = array();
        $line2 = array();
        $row2  = array();

        $hasil = $this->mdashboard->get_data_aset()->result();
        $i=1;
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['no_asset'] = $value->asset_number;
            $row2['description'] = $value->description;
            $row2['kondisi'] = $value->kondisi;
            $row2['merk'] = $value->merk;
            $row2['lokasi'] = $value->lokasi;
            $row2['tgl_perolehan'] = $value->tgl_perolehan;
            $row2['harga'] 	= "<div align=\"right\">".number_format($value->harga, '0', ',', '.')."</div>";

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    } 

    public function kepegawaian($id_personil='') {
		if ($id_personil == '') {
			$data['title'] = 'Data Kepegawaian';
			$data['pangkat'] = $this->M_pegawai->get_pangkat()->result();
			$this->load->view('dashboard/vkepegawaian',$data);	
		} else {
			$data['data_personil']=$this->rjmregistrasi->show_personil($id_personil)->result();
			$this->load->view('dashboard/vkepegawaian_profile',$data);	
		}
	}

	public function data_farmasi_amprah(){
        $date1 = $this->input->post('date_picker_awal');
    	$date2 = $this->input->post('date_picker_akhir');

    	if($date1 == ''){
    		$date1 = date('Y-m-d');
    	}

		if($date2 == ''){
    		$date2 = date('Y-m-d');
    	}

    	$line  = array();
        $line2 = array();
        $row2  = array();

        $hasil = $this->mdashboard->get_data_amprah($date1, $date2)->result();
        $i=1;
        foreach ($hasil as $value) {
            $row2['no'] = $i++;
            $row2['tgl_amprah'] = $value->tgl_amprah;
            $row2['gd_peminta'] = $value->peminta;
            $row2['gd_distribusi'] = $value->distribusi;
            $row2['permintaan'] = $value->qty_req;
            $row2['pengiriman'] = $value->qty_acc;

            $line2[] = $row2;
        }

        $line['data'] = $line2;

        echo json_encode($line);
    }

}

?>
