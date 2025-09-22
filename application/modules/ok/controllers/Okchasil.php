<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
//require_once(APPPATH.'controllers/Secure_area.php');
class Okchasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('ok/okmdaftar','',TRUE);
		$this->load->model('ok/okmkwitansi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('iri/rimtindakan','',TRUE);
		$this->load->model('emedrec/M_emedrec_iri','',TRUE);
		$this->load->model('admin/appconfig','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR PASIEN OPERASI';

		$data['operasi']=$this->okmdaftar->get_daftar_pasien_ok()->result();
		$this->load->view('ok/okvdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'DAFTAR PASIEN HASIL OPERASI | Tanggal '.$date;

		$data['operasi']=$this->okmdaftar->get_daftar_selesaipasien_ok_by_date($date)->result();
		$this->load->view('ok/okvdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'DAFTAR PASIEN HASIL OPERASI | '.$key;

		$data['operasi']=$this->okmdaftar->get_daftar_selesaipasien_ok_by_no($key)->result();
		$this->load->view('ok/okvdaftarpengisian',$data);
	}

	public function input_hasil($idoperasi_header){				
		$data['data_pasien']=$this->okmdaftar->get_data_pasien_pemeriksaan_by_idokhead($idoperasi_header)->row();
	    		$data['title'] = 'LAPORAN OPERASI PASIEN | '.$data['data_pasien']->no_register;
	    		
	    		$data['id']=$idoperasi_header;
	    		$data['no_register']=$data['data_pasien']->no_register;
				$data['nama']=$data['data_pasien']->nama;
				$data['alamat']=$data['data_pasien']->alamat;
				$data['dokter_rujuk']=$data['data_pasien']->nm_dokter;
				$data['no_medrec']=$data['data_pasien']->no_medrec;
				$data['no_cm']=$data['data_pasien']->no_cm;
				$data['kelas_pasien']=$data['data_pasien']->kelas;
				$data['tgl_kun']=$data['data_pasien']->tgl_daftar;
				$data['type_rawat']=$data['data_pasien']->type_rawat;			
				$data['cara_bayar']=$data['data_pasien']->cara_bayar;

				if($data['data_pasien']->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$data['data_pasien']->foto;
				}

				if($data['data_pasien']->type_rawat=='ruangrawat'){					
					$data['idrg']=$data['data_pasien']->idrg;
					$data['bed']=$data['data_pasien']->bed;
				}else{
					//$data['idrg']=$data['data_pasien']->nm_poli;
					$data['idrg']='-';
					$data['bed']='-';
				}
				if($data['cara_bayar']=='DIJAMIN' && $data['data_pasien']->type_rawat=='rawatjalan'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else if($data['cara_bayar']=='DIJAMIN' && $data['data_pasien']->type_rawat=='ruangrawat'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($data['no_register'])->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else{
					$data['nmkontraktor']='';
				}

				$data['get_data_ok'] =$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
				// var_dump($data['get_data_ok']);die();
				$data['checklist_keselamatan_operasi'] =$this->rimtindakan->get_checklist_keselamatan_pasien_operasi($idoperasi_header)->row();
				$data['laporan_anestesi'] = $this->rimtindakan->get_laporan_anestesi($idoperasi_header)->row();
				$data['laporan_operasi'] = $this->rimtindakan->get_laporan_operasi($idoperasi_header)->row();
				$data['status_sedasi'] = $this->rimtindakan->get_status_sedasi($idoperasi_header)->row();
				$data['persetujuan_tind_kedokteran'] = $this->rimtindakan->get_persetujuan_dokter($data['data_pasien']->no_register);
		//$data['detail_operasi']=$this->okmdaftar->get_data_detai($idoperasi_header)->result();
		$this->load->view('ok/okvhasilpasien',$data);
		//print_r($data);
	}


	public function checklist_keselamatan_pasien_operasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
	
		$data['formjson'] = $this->input->post('keselamatan_pasien_operasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_checklist_keselamatan_pasien_operasi($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_checklist_keselamatan_pasien_operasi($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_checklist_keselamatan_pasien_operasi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function laporan_anestesi()
	{
		// var_dump($this->input->post());die();
	
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		// $data['formjson'] = $this->input->post('ews_json');
		// $data['id_pemeriksa'] = $login_data->userid;
		// $data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_laporan_anestesi($id_ok);	

		if($data_note->num_rows()){// check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if($check_perawat_2_exist){ //check if data perawat 2 available then
					$data['formjson'] = $this->input->post('ews_json');
			}else{
					$data['id_pemeriksa_2'] = $login_data->userid;
					$data['formjson'] = $this->input->post('ews_json');
			}
			$submitdata = $this->rimtindakan->update_laporan_anestesi($id_ok,$data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}else{
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('ews_json');
			$submitdata = $this->rimtindakan->insert_laporan_anestesi($data);
			$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));
		}


		echo $submitdata;
	}

	public function laporan_operasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_laporan_operasi($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_operasi($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_laporan_operasi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function checklist_keselamatan_operasi_view($no_ipd,$id_ok)
    {
       
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
     
        // var_dump($id_ok);die();
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['checklist_keselamatan_operasi'] = $this->rimtindakan->get_checklist_keselamatan_pasien_operasi($id_ok)->row();
        $this->load->view('ok/formulir/checklist_keselamatan_operasi/v_checklist_keselamatan_pasien_operasi',$data);

    }

	
    public function laporan_anestesi_view($no_ipd,$id_ok)
    {
      
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['lap_anestesi'] = $this->rimtindakan->get_laporan_anestesi($id_ok)->row();
        $this->load->view('ok/formulir/laporan_anestesi/v_laporan_anestesi',$data);

    }

	public function laporan_operasi_view($no_ipd,$id_ok)
    {
      
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['lap_operasi'] = $this->rimtindakan->get_laporan_operasi($id_ok)->row();
        $this->load->view('ok/formulir/laporan_operasi/v_laporan_operasi',$data);

    }

	public function jadwal_operasi(){
		$data['title'] = 'JADWAL PASIEN OPERASI';

		$this->load->view('ok/okvjadwal',$data);
		//print_r($data);
	}	
	
	public function get_operasi_header($id='')
	{
		if($id!=''){			
			$data_header=$this->okmdaftar->get_operasi_header_byid($id)->row();
			echo json_encode($data_header);
		}
		
	}

	public function save_hasilok()
	{
		$data['no_register']=$this->input->post('no_register');	
		
		// $data['type_anas']=$this->input->post('type_anas');
		$data['type_operasi']=$this->input->post('type_operasi');

		// $data['type_anas']=$this->input->post('type_anas');
		// $data['type_operasi']=$this->input->post('type_operasi');
		$id_icd9cm = $this->input->post('id_icd9cm');
		// $diagpreop = explode("@", $this->input->post('diagnosapreok'));    	
    	// if ($this->input->post('id_diagnosapreok') == '') {
    	// 	$data['iddiag_preop'] = ''; 
    	// 	$data['diag_preop'] = ''; 
    	// } else {
		// 	$data['iddiag_preop'] = $diagpreop[0]; 
		// 	$data['diag_preop'] = $diagpreop[1];     		
    	// }
		$login_data = $this->load->get_var("user_info");
		$data['id_pemeriksa'] = $login_data->userid;
    	$diagpostop = explode("@", $this->input->post('diagnosapostok'));    	
    	if ($this->input->post('id_diagnosapostok') == '') {
    		$data['iddiag_postop'] = ''; 
    		$data['diag_postop'] = ''; 
    	} else {
			$data['iddiag_postop'] = $diagpostop[0]; 
			$data['diag_postop'] = $diagpostop[1];     		
    	}

		$data['tind_ok']=$this->input->post('tind_ok');
		$data['lap_ok']=$this->input->post('lap_ok');	
		$data['cat_pr']=$this->input->post('cat_pr');		
		$data['intime_jadwal_ok']=$this->input->post('intime_jadwal_ok');
		$data['outtime_jadwal_ok']=$this->input->post('outtime_jadwal_ok');
		//$data['lama_ok']=$this->input->post('lama_ok');

		$data['komplikasi']=$this->input->post('komplikasi');
		$data['implant']=$this->input->post('implant');
		$data['jmlh_perdarahan']=$this->input->post('jmlh_perdarahan');
		$data['jmlh_transfuse']=$this->input->post('jmlh_transfuse');
		$data['jaringan']=$this->input->post('jaringan');
		$data['ins_pasca_bedah']=$this->input->post('ins_pasca_bedah');
		$data['obat_diberikan']=$this->input->post('obat_diberikan');
		$data['di_pa_kan']=$this->input->post('di_pa_kan');


		$start_time = new DateTime($data['intime_jadwal_ok']);
	    $end_time = new DateTime($data['outtime_jadwal_ok']);

	    $time_diff = date_diff($start_time,$end_time);

	    $data['lama_ok']= $time_diff->format('%h');
		$data['xupdate']=date('Y-m-d H:i:s');
		$idoperasi_header=$this->input->post('idoperasi_header');

		
            $ext = end((explode("/", $_FILES['gambar_implant']['type'])));# extra () to prevent notice
            // echo $ext;
	        $date = new DateTime();

	        $timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

            $fileName = str_replace(' ', '_', $data['no_register']."-".$idoperasi_header."~".$result.".".$ext);
            $_FILES['userFile']['name'] = $fileName;
            $_FILES['userFile']['type'] = $_FILES['gambar_implant']['type'];
            $_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['gambar_implant']['tmp_name']);
            $_FILES['userFile']['error'] = $_FILES['gambar_implant']['error'];
            $_FILES['userFile']['size'] = $_FILES['gambar_implant']['size'];

            $uploadPath = './download/ok/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('userFile')){
                $fileData = $this->upload->data();
                $data['gambar_implant'] = $fileName;
	            // $uploadData['token'] = $data_rand;
                // $uploadData['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
            }else{
             	$error = $this->upload->display_errors();
			 	echo $error;
            }
			// echo $fileName."<br>";
            // echo $i.'<br>';
        
        
			
        
		
		
		//print_r($data);break;
		$id=$this->okmdaftar->update_detailok($data,$idoperasi_header);

		echo json_encode($id);
		
		
	}

	function get_itempemeriksaan($idoperasi_header=''){		
		$line  = array();
		$line2 = array();
		$row2  = array();
			$hasil = $this->okmdaftar->get_data_pemeriksaan_byidokhead($idoperasi_header)->result();		
		
		/*<th>No</th>												  	
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Operator</th>												  	
												  	<th width="10%">Total Pemeriksaan</th>
												  	<th width="5%">Aksi</th>*/		
		foreach ($hasil as $value) {
			$row2['id_pemeriksaan_ok'] = $value->id_pemeriksaan_ok;
			$row2['jenis_tindakan'] = $value->jenis_tindakan;
			//$row2['biaya_ok'] = $value->biaya_ok;
			//$row2['qty'] = $value->qty;
			$row2['vtot'] = number_format($value->vtot,0);
			$txtdokter='Dokter 1 : '.$value->nm_dokter.' ('.$value->id_dokter.')';										
			if($value->id_dokter2<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter 2 : '.$value->nm_dokter2.' ('.$value->id_dokter2.')';
			if($value->id_dokter_asist<>NULL)
				$txtdokter=$txtdokter.'<br>Asisten Dokter : '.$value->nm_asist_dokter.' ('.$value->id_dokter_asist.')';
			if($value->id_dok_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anestesi: '.$value->nm_dok_anes.' ('.$value->id_dok_anes.')';
			if($value->perawat_anastesi<>NULL)
				$txtdokter=$txtdokter.'<br>Perawat Anestesi: '.$value->perawat_anastesi;
			if($value->jns_anes<>NULL)
				$txtdokter=$txtdokter.'<br>Jenis Anestesi: '.$value->jns_anes;
			if($value->id_dok_anak<>NULL)
				$txtdokter=$txtdokter.'<br>Dokter Anak: '.$value->nm_dok_anak.' ('.$value->id_dok_anak.')';
			$row2['operator'] = $txtdokter;
			$row2['aksi'] = '<button type="button" class="btn btn-danger btn-xs" onClick="hapus_data_pemeriksaan('.$value->id_pemeriksaan_ok.')"><i class="fa fa-trash"></i></button>';		
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }

	public function insert_pemeriksaan()
	{
		$data['idoperasi_header']=$this->input->post('idoperasi_header');
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data_tindakan=$this->okmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['id_dokter']=$this->input->post('id_dokter1');
		$data['id_dokter_asist']=$this->input->post('id_dokter_asist');

		if($this->input->post('perawat_anas')!=''){
			$data['perawat_anastesi']=$this->input->post('perawat_anas');
		}
		
		$data['id_dokter2']=$this->input->post('id_dokter2');
		//$data['id_opr_anes']=$this->input->post('id_opr_anes');
		$data['id_dok_anes']=$this->input->post('id_dok_anes');
		$data['jns_anes']=$this->input->post('jns_anes');
		$data['id_dok_anak']=$this->input->post('id_dok_anak');
		//$data['tgl_jadwal']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		//$data['tgl_operasi']=$this->input->post('jadwal_operasi').' '.$this->input->post('jam_jadwal_operasi');
		$data['biaya_ok']=$this->input->post('biaya_ok_hide');
		$data['qty']=$this->input->post('qty');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');
		$data['xupdate']=$this->input->post('xupdate');

		/*$data['no_ok']=$this->input->post('no_ok');
		if($data['no_ok']!=''){
		} else {
			$this->okmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_ok']=$this->okmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_ok;
		}*/

		$id=$this->okmdaftar->insert_pemeriksaan($data);
		echo json_encode($id);
		//redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register'].'/'.$data['no_ok']);
		//redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register']);
		//print_r($data);
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
				$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan=$this->okmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach($data_tindakan as $row){
					$data['jenis_tindakan']=$row->nmtindakan;
				}
				$data['qty']='1';
				$data['id_dokter']=$this->input->post('id_dokter');
				$data_dokter=$this->okmdaftar->getnama_dokter($data['id_dokter'])->result();
				foreach($data_dokter as $row){
					$data['nm_dokter']=$row->nm_dokter;
				}
				$data['biaya_ok']=$biaya=$this->okmdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				$data['vtot']=$data['biaya_ok'];
				$data['idrg']=$this->input->post('idrg');
				$data['bed']=$this->input->post('bed');
				$data['cara_bayar']=$this->input->post('cara_bayar');
				$data['xinput']=$this->input->post('xuser');

				$this->okmdaftar->insert_pemeriksaan($data);
		    }
			
			echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR OK DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotok=$this->okmdaftar->get_vtot_ok($no_register)->row()->vtot_ok;
		$getrdrj=substr($no_register, 0,2);

		$this->okmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_ok=$this->okmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_ok;

		if($getrdrj=="PL"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotok,$no_ok);
		} else if($getrdrj=="RJ"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotok,$no_ok);
		}
		else if ($getrdrj=="RD"){
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotok,$no_ok);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->okmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_ok=$row->status_ok;
			}
			$status_ok = $status_ok + 1;
			$this->okmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_ok,$getvtotok,$no_ok);
		}

		// if($getrdrj=="PL"){
		// 	echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';

		// 	redirect('ok/okcdaftar/','refresh');
		// } 
		// else if($getrdrj=="RJ"){
		// 	echo '<script type="text/javascript">window.close();
		// 	window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
		// }
		// else 
		if ($getrdrj=="RJ"){
			echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
		 	redirect('ok/okcdaftar/','refresh');
		}
		else if ($getrdrj=="RI"){
			echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';
			redirect('ok/okcdaftar/','refresh');
		}

		// echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/cetak_faktur/$no_ok").'", "_blank");window.focus()</script>';

		// redirect('ok/Labcdaftar/','refresh');
		
		//print_r($getvtotok);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_ok='')
	{
		$this->okmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_ok);
        echo json_encode(array("status" => $id_pemeriksaan_ok));
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		//$data['xuser']=$this->input->post('xuser');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->okmdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['ok']='1';
		
		$this->okmdaftar->insert_pasien_luar($data);
		
		redirect('ok/okcdaftar/pemeriksaan_ok/'.$data['no_register']);
		print_r($data);
	}

	public function cetak_hasil($idoperasi_header=''){
		$jumlah_vtot=$this->okmdaftar->get_vtot_id_ok($idoperasi_header)->row()->vtot_no_ok;
		date_default_timezone_set("Asia/Jakarta");
		$tgl_jam = date("d-m-Y H:i:s");
		$data['tgl'] = date("d-m-Y");
		$data['idoperasi_header'] = $idoperasi_header;

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$data['logo_header']=$this->appconfig->get_header_isi_pdfconfig()->value;
		$data['logo_kesehatan_header']=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$data['kota_header']=$this->appconfig->get_kota_pdfconfig()->value;

		$data['namars']=$this->config->item('namars');
		$data['kota_kab']=$this->config->item('kota');
		$data['telp']=$this->config->item('telp');
		$data['alamatrs']=$this->config->item('alamat');
		$data['nmsingkat']=$this->config->item('namasingkat');
		$data['data_pasien']=$this->okmkwitansi->get_data_pasien($idoperasi_header)->row();
		$data['data_pemeriksaan']=$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();

		$data_header=$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();
		$data['hasil'] = $data_header;
		
		
		$cterbilang=new rjcterbilang();

		$tahun=0;
		$bulan=0;
		$hari=0;
		//  ta['data_pasien']->tgl_lahir - ($bulan * 30) - ($tahun * 365);
		$this->load->view('laporan_operasi',$data);
	}

	public function cetak_hasil_old($idoperasi_header='')
	{
		error_reporting(~E_ALL);
		$jumlah_vtot=$this->okmdaftar->get_vtot_id_ok($idoperasi_header)->row()->vtot_no_ok;

		$conf=$this->appconfig->get_headerpdf_appconfig()->result();
		$top_header=$this->appconfig->get_header_top_pdfconfig()->value;
		$bottom_header=$this->appconfig->get_header_bottom_pdfconfig()->value;
		$logo_header=$this->appconfig->get_header_isi_pdfconfig()->value;
		$logo_kesehatan_header=$this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
		$kota_header=$this->appconfig->get_kota_pdfconfig()->value;

		if($idoperasi_header!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->okmkwitansi->get_data_pasien($idoperasi_header)->row();
			$data_pemeriksaan=$this->okmdaftar->get_operasi_header_byid($idoperasi_header)->row();

			foreach($conf as $rowheader){
				$head_pdf =	$rowheader->value;
			}
			
			$cterbilang=new rjcterbilang();

			$tahun=0;
			$bulan=0;
			$hari=0;
			$tahun=floor($data_pasien->tgl_lahir/365);
			$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
			$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);			
			
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
			$konten="<style type=\"text/css\">
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
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_page
					<hr>
					<h3 align=\"center\"><b><u>LAPORAN OPERASI</u><br/>
					No. OK_$idoperasi_header
					</b></h3>
					<table>												
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->no_register</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->nama ($data_pasien->sex)</td>
						</tr>
						<tr>
							<td><b>No. RM</b></td>
							<td> : </td>
							<td>$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td><b>Umur</b></td>
							<td> : </td>
							<td>$tahun tahun.</td>
						</tr>
						<tr>
							<td><b>Nama Dokter Operator</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->nm_dokter</td>
						</tr>
						<tr>
							<td><b>Nama Asisten</b></td>
							<td> : </td>
							<td></td>
						</tr>
						<tr>
							<td><b>Jenis Operasi</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->type_operasi</td>
						</tr>
						<tr>
							<td><b>Jenis Anestesi</b></td>
							<td> : </td>
							<td>$data_pemeriksaan->type_anas</td>
						</tr>
					</table>
					<br/>

					<hr>					
					<table>	
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"77%\"></td>
						</tr>											
						<tr>
							<td width=\"20%\"><b>Diagnosa Pre Op</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">".$data_pemeriksaan->iddiag_preop." - ".$data_pemeriksaan->diag_preop."</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Diagnosa Post Op</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">".$data_pemeriksaan->iddiag_postop." - ".$data_pemeriksaan->diag_postop."</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Tindakan Operasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"77%\">$data_pemeriksaan->tind_ok</td>
						</tr>
					</table>
					<br><br>
					<table border=\"1\" style=\"padding:2px\">		
						<thead>										
						<tr>
							<td width=\"20%\"><b>Tgl Operasi</b></td>							
							<td width=\"20%\"><b>Jam Operasi Dimulai</b></td>
							<td width=\"20%\"><b>Jam Operasi Selesai</b></td>
							<td width=\"30%\"><b>Lama Operasi Berlangsung</b></td>							
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width=\"20%\" align=\"center\">".date('d-m-Y',strtotime($data_pemeriksaan->tgl_jadwal_ok))."</td>		
							<td width=\"20%\" align=\"center\">$data_pemeriksaan->intime_jadwal_ok</td>
							<td width=\"20%\" align=\"center\">$data_pemeriksaan->outtime_jadwal_ok</td>
							<td width=\"30%\" align=\"center\">$data_pemeriksaan->lama_ok Jam</td>							
						</tr>
						</tbody>
					</table>
					<br><br>
					<table >												
						<tr>
							<td width=\"20%\"><b>Laporan Operasi</b></td>	
							<td width=\"3%\"> : </td>						
							<td width=\"77%\">$data_pemeriksaan->lap_ok</td>
						</tr>
						<tr>
							<td width=\"20%\"><b>Catatan</b></td>	
							<td width=\"3%\"> : </td>						
							<td width=\"77%\" rowspan=\"3\"></td>
						</tr>
					</table>
					";									
				$this->load->helper('pdf_helper');
				
				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
				$konten=$konten."					
					<br>
					<br><br>
					<br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_header, $tgl
								<br>Tanda Tangan Dokter Operator
								<br><br><br><br><br>(_______________________)
								</p>
							</td>
						</tr>	
					</table>
					";
				
			// $file_name="FKTR_$no_ok.pdf";
				$file_name="HASIL_OK_".$idoperasi_header."_".$data_pasien->nama.".pdf";
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
				$obj_pdf->SetMargins('10', '5', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ok/okhasil/'.$file_name, 'FI');
		}else{
			redirect('ok/okcdaftar/','refresh');
		}
	}

	public function laporan_anestesi_grafik_pemantauan()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');

		$check_data_grafik_pemantauan = $this->rimtindakan->get_laporan_anestesi_grafik_pemantauan($id_ok);

		if ($check_data_grafik_pemantauan->num_rows()) { // check if data available then
			$data['grafikjson'] = $this->input->post('grafik_json');
			$data['last_user_entry'] = $login_data->userid;
			$data['last_tgl_entry'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->update_laporan_anestesi_grafik_pemantauan($id_ok, $data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['grafikjson'] = $this->input->post('grafik_json');
			$data['last_user_entry'] = $login_data->userid;
			$data['last_tgl_entry'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->insert_laporan_anestesi_grafik_pemantauan($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $submitdata;
	}
	// grafik pemantauan status sedasi
	public function status_sedasi_grafik_pemantauan()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');

		$check_data_grafik_pemantauan = $this->rimtindakan->get_status_sedasi_grafik_pemantauan($id_ok);

		if ($check_data_grafik_pemantauan->num_rows()) { // check if data available then
			$data['grafikjson'] = $this->input->post('grafik_json');
			$data['last_user_entry'] = $login_data->userid;
			$data['last_tgl_entry'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->update_status_sedasi_grafik_pemantauan($id_ok, $data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['grafikjson'] = $this->input->post('grafik_json');
			$data['last_user_entry'] = $login_data->userid;
			$data['last_tgl_entry'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->insert_status_sedasi_grafik_pemantauan($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $submitdata;
	}

	public function laporan_pembedahan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('bedah_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->okmdaftar->get_laporan_pembedahan($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->okmdaftar->update_laporan_pembedahan($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_register']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->okmdaftar->insert_laporan_pembedahan($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function laporan_pembedahan_view($no_ipd,$id_ok)
    {
      
        $noipd=$no_ipd!=""?$no_ipd:$this->input->post('user_id');
        $data['logo_header'] = $this->appconfig->get_header_isi_pdfconfig()->value;
        $data['logo_kesehatan_header'] = $this->appconfig->get_header_logo_kesehatan_pdfconfig()->value;
        $data['logo_header'] = 'logo.png';
        $data['data_pasien'] = $this->M_emedrec_iri->data_pasien($noipd)->result();
        $data['lap_pembedahan'] = $this->okmdaftar->get_laporan_pembedahan($no_ipd)->row();
		// var_dump($data['lap_pembedahan']);die();
        $this->load->view('ok/formulir/laporan_pembedahan/laporan_pembedahan',$data);

    }

	public function pengkajian_praanestesi_sedasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('pengkajian_praanestesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_pra_anastesi_sedasi_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pra_anastesi_sedasi_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_pra_anastesi_sedasi_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function catatan_peri_operatif()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('caper_peri_operatif_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_kep_perioperatif_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_kep_perioperatif_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_kep_perioperatif_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function catatan_pemulihan()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('catatan_pemulihan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_catatan_kamar_pemulihan_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_kamar_pemulihan_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_catatan_kamar_pemulihan_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function lap_bedah_anestesi_lokal()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('lap_bedah_anestesi_lokal_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_laporan_pembedahan_anestesi_lokal_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_pembedahan_anestesi_lokal_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_pembedahan_anestesi_lokal_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function lap_bedah_anestesi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('lap_bedah_anestesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_pembedahan_anastesi_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pembedahan_anastesi_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_pembedahan_anastesi_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function pramedi_pasca_operasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('pramedi_pasca_operasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_premedi_pasca_bedah_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_premedi_pasca_bedah_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_premedi_pasca_bedah_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function status_sedasi_sjj()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('status_sedasi_sjj_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_status_sedasi_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_status_sedasi_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_status_sedasi_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function edukasi_anestesi_sedasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('edukasi_anestesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_edukasi_anestesi_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_edukasi_anestesi_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_edukasi_anestesi_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function tindakan_anestesi_sedasi()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
		$data['formjson'] = $this->input->post('tindakan_anestesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note=$this->rimtindakan->get_anastesi_sedasi_ok($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_anastesi_sedasi_ok($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_anastesi_sedasi_ok($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}
}