<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Personil extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('html','url')); 
		$this->load->model('kepegawaian/M_pegawai','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->helper('pdf_helper');
	}
	
	public function index() {
		$data['title'] = 'Data Personil';
		$this->load->view('kepegawaian/index',$data);
	}

	public function edit($id='') {
		if ($id == '') {
			$data['title'] = 'Data Personil';
			$this->load->view('kepegawaian/index',$data);
		} else {					
			$data['title'] = 'Data Personil';			
			$data['pangkat'] = $this->M_pegawai->get_pangkat()->result();
			$data['data_pegawai'] = $this->M_pegawai->show_personil($id);
			if (count($data['data_pegawai'])>0) {
				$this->load->view("kepegawaian/personil", $data);
			} else {
				$this->session->set_flashdata('notification', 'Data Personil Tidak Ditemukan.');	
				redirect('kepegawaian/personil');	
			} 		
		}
	}

	public function load_data($id='') {		
		$data_pegawai = $this->M_pegawai->show_personil($id);
		echo json_encode($data_pegawai);
	}

	function insert_personil() { 
		$login_data = $this->load->get_var("user_info");
		$foto = '';
	   	if (!empty($_FILES["foto"]["name"])) {  
	   		$foto = strtotime("now").'_'.$_FILES['foto']['name'];		 		    	
	    	$config['upload_path'] = './upload/personil/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
	        $config['file_name'] = $foto;  
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('foto')) {  	        	
				$this->session->set_flashdata('notification', $this->upload->display_errors());	
				redirect('kepegawaian/personil'); 	            
	        }  
	        else {
	        	$data_upload = $this->upload->data();	        		        	
	        }
	    }
        $data = array(
			'nama' => $this->input->post('nm_pegawai'),
			'nik' => $this->input->post('nik'),
			'gender' => $this->input->post('gender'),
			'tmpt_lahir' => $this->input->post('tmpt_lahir'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'alamat' => $this->input->post('alamat'),
			'agama' => $this->input->post('agama'),
			'foto' => $foto,
			'created_at' => date('Y-m-d h:i:s'),
			'created_by' => $login_data->username
   		);  		
   		$result = $this->M_pegawai->insert_personil($data);
        redirect('kepegawaian/personil/edit/'.$result);     
    } 

	function update_personil() { 
		$login_data = $this->load->get_var("user_info");		
		$id = $this->input->post('id_personil');		 
	   	if (empty($_FILES["foto"]["name"])) {  	 
		   	$data_update = array(
				'nama' => $this->input->post('nm_pegawai'),
				'nip_nrp' => $this->input->post('nip_nrp'),
				'nik' => $this->input->post('nik'),
				'gender' => $this->input->post('gender'),
				'tmpt_lahir' => $this->input->post('tmpt_lahir'),
				'tgl_lahir' => $this->input->post('tgl_lahir'),
				'alamat' => $this->input->post('alamat'),
				'agama' => $this->input->post('agama'),
				'phone' => $this->input->post('phone'),			
				'kelompok_medis' => $this->input->post('kelompok_medis'),
				'no_sip' => $this->input->post('no_sip'),
				'k_tk' => $this->input->post('k_tk'),
				'status_rumah' => $this->input->post('status_rumah'),				
				'tmt_masuk' => $this->input->post('tmt_masuk'),
				'tmt_tni' => $this->input->post('tmt_tni'),
				'masa_prajurit' => $this->input->post('masa_prajurit'),
				'korps' => $this->input->post('korps'),
				'tmt_fiktif' => $this->input->post('tmt_fiktif'),
				'suku' => $this->input->post('suku'),
				'updated_at' => date('Y-m-d h:i:s'),
				'updated_by' => $login_data->username
	   		);  		
	   		$result = $this->M_pegawai->update_personil($id,$data_update);
	        echo json_encode($result);
	    } else {	  	    	  
	    	$foto = strtotime("now").'_'.$_FILES['foto']['name'];	
	    	$config['upload_path'] = './upload/personil/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
	        $config['file_name'] = $foto; 
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('foto'))  
	        {  
	             echo $this->upload->display_errors(); 
	        }  
	        else  
	        {
	        	$data_upload = $this->upload->data();  	        				
	        	$data_update = array(	
	        		'foto' => $foto,														
					'nama' => $this->input->post('nm_pegawai'),
					'nip_nrp' => $this->input->post('nip_nrp'),
					'gender' => $this->input->post('gender'),
					'tmpt_lahir' => $this->input->post('tmpt_lahir'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'alamat' => $this->input->post('alamat'),
					'agama' => $this->input->post('agama'),
					'phone' => $this->input->post('phone'),
					// 'pangkat_id' => $this->input->post('pangkat'),
					// 'masa_pangkat' => $this->input->post('masa_pangkat'),
					'kelompok_medis' => $this->input->post('kelompok_medis'),
					'k_tk' => $this->input->post('k_tk'),
					'status_rumah' => $this->input->post('status_rumah'),
					// 'jabatan' => $this->input->post('jabatan'),
					'tmt_masuk' => $this->input->post('tmt_masuk'),
					// 'tmt_jabatan' => $this->input->post('tmt_jabatan'),
					// 'lama_jabatan' => $this->input->post('lama_jabatan'),
					'tmt_tni' => $this->input->post('tmt_tni'),
					'masa_prajurit' => $this->input->post('masa_prajurit'),
					'korps' => $this->input->post('korps'),
					'tmt_fiktif' => $this->input->post('tmt_fiktif'),
					'suku' => $this->input->post('suku'),
					'updated_at' => date('Y-m-d h:i:s'),
					'updated_by' => $login_data->username
   				);	            
	            // echo '<img src="'.base_url().'upload/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';  
	            $result = $this->M_pegawai->update_personil($id,$data_update);
	        	echo json_encode($result);
	        }
	    } 
    } 

	public function cetak_kutipan($id=''){
		$data_personil = $this->M_pegawai->show_personil($id);
		$pendidikan_umum = $this->M_pegawai->show_pendidikan_umum($data_personil->id);	
		$pendidikan_militer = $this->M_pegawai->show_pendidikan_militer($data_personil->id);		
		$pangkat = $this->M_pegawai->pangkat_personil($data_personil->id);		
		$jabatan = $this->M_pegawai->jabatan_personil($data_personil->id);
		$tanda_jasa = $this->M_pegawai->tandajasa_personil($data_personil->id);
		if ($data_personil->tgl_lahir == '') {
			$tmpt_tgl_lahir = $data_personil->tmpt_lahir;			
		} else if ($data_personil->tmpt_lahir == '') {
			$tmpt_tgl_lahir = date( 'd-m-Y',strtotime($data_personil->tgl_lahir));
		} else {
			$tmpt_tgl_lahir = $data_personil->tmpt_lahir . ', ' . date( 'd-m-Y',strtotime($data_personil->tgl_lahir));
		}  
		date_default_timezone_set("Asia/Jakarta");
		$tgl_jam = date("d-m-Y H:i:s");
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:10px;
				    }
					.table-font-size2{
						font-size:8px;
						padding : 1px, 2px, 2px;
				    }				    
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:0.5px solid black; font-size:10px;\">
						<br>
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"55\">
						</td>
						<td width=\"60%\" style=\"border-bottom:0.5px solid black;\" align=\"center\">										
								<br>
								<br>
								<span style=\"font-size:13px;font-weight:bold;\">$namars</span>
								<br>
								<span style=\"font-size:10px;font-weight:bold;\">$alamatrs</span>						
						</td>
						<td width=\"20%\" style=\"border-bottom:0.5px solid black; font-size:10px;\" align=\"right\">
						
						</td>
					</tr>
				</table>
				<br>
				<h4 align=\"center\">KUTIPAN RIWAYAT HIDUP</h4>
									
				<table class=\"table-font-size2\" border=\"0\">
				<br>
				<br>
					<tr>";
					 $foto_path = 'upload/personil/'.$data_personil->foto;	
					 			
					if (!file_exists($foto_path) || $data_personil->foto == '' || $data_personil->foto == 'default.png') {						
						$konten.="<td width=\"18%\"><img src=\"upload/personil/empty.png\" alt=\"img\" width=\"2.8cm\" height=\"3.8cm\" border=\"5\"></td>";		    			
					} else {
						$konten.="<td width=\"18%\"><img src=\"$foto_path\" alt=\"img\" width=\"2.8cm\" height=\"3.8cm\"></td>";	
					}
						
						$konten.="<td width=\"82%\">
							<table class=\"table-font-size2\" border=\"0\">
								<tr>
									<td width=\"30%\">NAMA</td>
									<td width=\"2%\">:</td>
									<td width=\"38%\">$data_personil->nama</td>
									<td width=\"17%\">KORPS</td>
									<td width=\"2%\">:</td>
									<td width=\"21%\">$data_personil->korps</td>
								</tr>
								<tr>
									<td>NIP / NRP</td>
									<td>:</td>
									<td>$data_personil->nip_nrp</td>
									<td>TMT FIKTIF</td>
									<td>:</td>
									<td>$data_personil->tmt_fiktif</td>
								</tr>
								<tr>
									<td>TEMPAT / TGL LAHIR</td>
									<td>:</td>
									<td>$tmpt_tgl_lahir</td>
									<td>JENIS KELAMIN</td>
									<td>:</td>
									<td>$data_personil->gender</td>
								</tr>
								<tr>
									<td>PANGKAT / GOL</td>
									<td>:</td>
									<td>$data_personil->pangkat</td>
									<td>AGAMA</td>
									<td>:</td>
									<td>$data_personil->agama</td>
								</tr>
								<tr>
									<td width=\"30%\">MASA DINAS DLM PANGKAT</td>
									<td width=\"2%\">:</td>
									<td width=\"68%\">$data_personil->masa_pangkat</td>
								</tr>
								<tr>
									<td>TMT TNI</td>
									<td>:</td>
									<td>$data_personil->tmt_tni</td>									
								</tr>
								<tr>
									<td>MASA DINAS PRAJURIT</td>
									<td>:</td>
									<td>$data_personil->masa_prajurit</td>									
								</tr>
								<tr>
									<td>JABATAN</td>
									<td>:</td>
									<td>$data_personil->jabatan</td>									
								</tr>
								<tr>
									<td>LAMA JABATAN</td>
									<td>:</td>
									<td>$data_personil->lama_jabatan</td>									
								</tr>	
								<tr>
									<td>ALAMAT</td>
									<td>:</td>
									<td>$data_personil->alamat</td>
								</tr>	
							</table>
						</td>												
					</tr>																									
				</table>
				<br>
				<h5>I. PENDIDIKAN UMUM</h5>
				<table class=\"table-font-size2\" border=\"1\">
					<thead>
						<tr align=\"center\">
							<th width=\"5%\">NO</th>
							<th width=\"30%\">JENIS / NAMA PENDIDIKAN</th>
							<th width=\"30%\">ASAL PENDIDIKAN</th>
							<th width=\"20%\">JURUSAN</th>
							<th width=\"15%\">TAHUN LULUS</th>						
						</tr>
			        </thead>
	                <tbody>";	
	                	$i=1;
	                	foreach ($pendidikan_umum as $item) {
							$konten.="<tr>
								<td width=\"5%\" align=\"center\">".$i++."</td>
								<td width=\"30%\">$item->pendidikan</td>
								<td width=\"30%\">$item->tmpt_pendidikan</td>
								<td width=\"20%\">$item->jurusan</td>
								<td width=\"15%\" align=\"center\">$item->th_lulus</td>						
							</tr>";
						}                                                                     
	      			$konten.="</tbody>																										
				</table>
				<br>
				<h5>II. PENDIDIKAN MILITER</h5>
				<table class=\"table-font-size2\" border=\"1\">
					<thead>
						<tr align=\"center\">
							<th width=\"5%\" align=\"center\">NO</th>
							<th width=\"80%\">JENIS / NAMA PENDIDIKAN</th>							
							<th width=\"15%\">LULUS</th>						
						</tr>
			        </thead>
	                <tbody>";	
	                	$i=1;
	                	foreach ($pendidikan_militer as $item) {
							$konten.="<tr>
								<td width=\"5%\" align=\"center\">".$i++."</td>
								<td width=\"80%\">$item->pendidikan</td>							
								<td width=\"15%\" align=\"center\">$item->th_lulus</td>						
							</tr>";
						}                                                                     
	      			$konten.="</tbody>																										
				</table>
				<br>
				<h5>III. RIWAYAT PANGKAT</h5>
				<table class=\"table-font-size2\" border=\"1\">
					<thead>
						<tr align=\"center\">
							<th width=\"5%\">NO</th>
							<th width=\"55%\">PANGKAT</th>
							<th width=\"40%\">TMT PANGKAT</th>												
						</tr>
			        </thead>
	                <tbody>";	
	                	$i=1;
	                	foreach ($pangkat as $item) {
							$konten.="<tr>
								<td width=\"5%\" align=\"center\">".$i++."</td>
								<td width=\"55%\">$item->pangkat</td>
								<td width=\"40%\" align=\"center\">$item->tmt_pangkat</td>													
							</tr>";
						}                                                                     
	      			$konten.="</tbody>																										
				</table>
				<br>
				<h5>IV. RIWAYAT JABATAN</h5>
				<table class=\"table-font-size2\" border=\"1\">
					<thead>
						<tr align=\"center\">
							<th width=\"5%\" align=\"center\">NO</th>
							<th width=\"55%\">JABATAN</th>
							<th width=\"40%\">TMT JABATAN</th>												
						</tr>
			        </thead>
	                <tbody>";	
	                	$i=1;
	                	foreach ($jabatan as $item) {
							$konten.="<tr>
								<td width=\"5%\" align=\"center\">".$i++."</td>
								<td width=\"55%\">$item->jabatan</td>
								<td width=\"40%\" align=\"center\">$item->tmt_jabatan</td>														
							</tr>";
						}                                                                     
	      			$konten.="</tbody>																										
				</table>
				<br>
				<h5>V. RIWAYAT TANDA JASA</h5>
				<table class=\"table-font-size2\" border=\"1\">
					<thead>
						<tr align=\"center\">
							<th width=\"5%\" align=\"center\">NO</th>
							<th width=\"95%\">TANDA JASA</th>												
						</tr>
			        </thead>
	                <tbody>";	
	                	$i=1;
	                	foreach ($tanda_jasa as $item) {
							$konten.="<tr>
								<td width=\"5%\" align=\"center\">".$i++."</td>
								<td width=\"95%\">$item->tanda_jasa</td>													
							</tr>";
						}                                                                     
	      			$konten.="</tbody>																										
				</table>";			
								

		$file_name="kutipan_".$data_personil->id.".pdf";		
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
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'download/kepegawaian/kutipan/'.$file_name, 'FI');				
	}

	function show_pendidikan($id='') {						
		$result = $this->M_pegawai->show_pendidikan($id);				
		echo json_encode($result);
	}

	function delete_pendidikan() {						
		$id = $this->input->post('id');
		$id_personil = $this->input->post('id_personil');
		$jenis = $this->input->post('jenis');
		$result = $this->M_pegawai->delete_pendidikan($id);	
		if ($result == true) {
			if ($jenis == '1') {			
				$max_pendumum = $this->M_pegawai->max_pendumum($id_personil);
				if (empty($max_pendumum)) {
					$data = array('pend_umum_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_umum_akhir' => $max_pendumum->pendidikan);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}
			}
			if ($jenis == '2') {			
				$max_pendtni = $this->M_pegawai->max_pendtni($id_personil);
				if (empty($max_pendtni)) {
					$data = array('pend_tni_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_tni_akhir' => $max_pendtni->pendidikan);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}
			}				
		}			
		echo json_encode($result);
	}

	function save_pendumum() {
		$id_personil = $this->input->post('idpersonil_pendumum');
		$method = $this->input->post('method_pendumum');
		$result = '';
		if ($method == 'edit') {
			$id = $this->input->post('id_pendumum');
			$data = array(				
				'pendidikan' => $this->input->post('gelar_pendumum'),
				'tmpt_pendidikan' => $this->input->post('tmpt_pendumum'),
				'jurusan' => $this->input->post('jurusan_pendumum'),
				'th_lulus' => $this->input->post('thlulus_pendumum')
			);
			$result = $this->M_pegawai->update_pendidikan($id,$data);	
			if ($result == true) {
				$max_pendumum = $this->M_pegawai->max_pendumum($id_personil);
				if (empty($max_pendumum)) {
					$data = array('pend_umum_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_umum_akhir' => $max_pendumum->pendidikan,);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}					
			}		
		} else {
			$data = array(
				'id_personil' => $id_personil,
				'pendidikan' => $this->input->post('gelar_pendumum'),
				'tmpt_pendidikan' => $this->input->post('tmpt_pendumum'),
				'jurusan' => $this->input->post('jurusan_pendumum'),
				'th_lulus' => $this->input->post('thlulus_pendumum'),
				'jenis' => 1
			);
			$result = $this->M_pegawai->insert_pendidikan($data);
			if ($result == true) {
				$max_pendumum = $this->M_pegawai->max_pendumum($id_personil);
				if (empty($max_pendumum)) {
					$data = array('pend_umum_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_umum_akhir' => $max_pendumum->pendidikan,);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}					
			}	
		}		
		echo json_encode($result);
	}

	function save_pendmiliter() {
		$id_personil = $this->input->post('idpersonil_pendmiliter');
		$method = $this->input->post('method_pendmiliter');
		$result = '';
		if ($method == 'edit') {
			$id = $this->input->post('id_pendmiliter');
			$data = array(				
				'pendidikan' => $this->input->post('gelar_pendmiliter'),				
				'th_lulus' => $this->input->post('thlulus_pendmiliter')
			);
			$result = $this->M_pegawai->update_pendidikan($id,$data);
			if ($result == true) {
				$max_pendtni = $this->M_pegawai->max_pendtni($id_personil);
				if (empty($max_pendtni)) {
					$data = array('pend_tni_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_tni_akhir' => $max_pendtni->pendidikan);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}				
			}				
		} else {
			$data = array(
				'id_personil' => $id_personil,
				'pendidikan' => $this->input->post('gelar_pendmiliter'),				
				'th_lulus' => $this->input->post('thlulus_pendmiliter'),
				'jenis' => 2
			);
			$result = $this->M_pegawai->insert_pendidikan($data);
			if ($result == true) {
				$max_pendtni = $this->M_pegawai->max_pendtni($id_personil);
				if (empty($max_pendtni)) {
					$data = array('pend_tni_akhir' => '');
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);	
				} else {
					$data = array('pend_tni_akhir' => $max_pendtni->pendidikan);
					$result = $this->M_pegawai->update_pendidikan_akhir($id_personil,$data);
				}				
			}	
		}		
		echo json_encode($result);
	}

	function show_pangkat($id='') {						
		$result = $this->M_pegawai->show_pangkat($id);				
		echo json_encode($result);
	}

	function delete_pangkat() {								
		$id = $this->input->post('id');
		$id_personil = $this->input->post('id_personil');
		$result = $this->M_pegawai->delete_pangkat($id);
		if ($result == true) {
			$pangkat_id = $this->M_pegawai->max_pangkat($id_personil);
			if (!empty($pangkat_id)) {
				$data = array('pangkat_akhir' => $pangkat_id->id);
				$result = $this->M_pegawai->update_pangkat_akhir($id_personil,$data);		
			}				
		}				
		echo json_encode($result);
	}

	function save_pangkat() {		
		$id_personil = $this->input->post('idpersonil_pangkat');
		$method = $this->input->post('method_pangkat');
		$result = '';
		if ($method == 'edit') {
			$id = $this->input->post('id_pangkat');
			$data = array(				
				'pangkat' => $this->input->post('input_pangkat'),				
				'tmt_pangkat' => $this->input->post('tmt_pangkat')
			);
			$result = $this->M_pegawai->update_pangkat($id,$data);	
			if ($result == true) {
				$pangkat_id = $this->M_pegawai->max_pangkat($id_personil);
				if (!empty($pangkat_id)) {
					$data_update = array('pangkat_akhir' => $pangkat_id->id);
					$result = $this->M_pegawai->update_pangkat_akhir($id_personil,$data_update);	
				}				
			}		
		} else {
			$data = array(
				'id_personil' => $id_personil,
				'pangkat' => $this->input->post('input_pangkat'),				
				'tmt_pangkat' => $this->input->post('tmt_pangkat')
			);
			$result = $this->M_pegawai->insert_pangkat($data);
			if ($result == true) {
				$pangkat_id = $this->M_pegawai->max_pangkat($id_personil);
				if (!empty($pangkat_id)) {
					$data = array('pangkat_akhir' => $pangkat_id->id);
					$result = $this->M_pegawai->update_pangkat_akhir($id_personil,$data);		
				}				
			}	
		}		
		echo json_encode($result);
	}

	function show_jabatan($id='') {						
		$result = $this->M_pegawai->show_jabatan($id);				
		echo json_encode($result);
	}

	function delete_jabatan($id='') {						
		$result = $this->M_pegawai->delete_jabatan($id);				
		echo json_encode($result);
	}

	function save_jabatan() {		
		$id_personil = $this->input->post('idpersonil_jabatan');
		$method = $this->input->post('method_jabatan');
		$result = '';
		if ($method == 'edit') {
			$id = $this->input->post('id_jabatan');
			$data = array(				
				'jabatan' => $this->input->post('input_jabatan'),				
				'tmt_jabatan' => $this->input->post('input_tmt_jabatan')
			);
			$result = $this->M_pegawai->update_jabatan($id,$data);	
			if ($result == true) {
				$max_jabatan = $this->M_pegawai->max_jabatan($id_personil);
				if (!empty($max_jabatan)) {
					$data = array('jabatan_akhir' => $max_jabatan->id);
					$result = $this->M_pegawai->update_jabatan_akhir($id_personil,$data);	
				}				
			}
		} else {
			$data = array(
				'id_personil' => $id_personil,
				'jabatan' => $this->input->post('input_jabatan'),				
				'tmt_jabatan' => $this->input->post('input_tmt_jabatan')
			);
			$result = $this->M_pegawai->insert_jabatan($data);
			if ($result == true) {
				$max_jabatan = $this->M_pegawai->max_jabatan($id_personil);
				if (!empty($max_jabatan)) {
					$data = array('jabatan_akhir' => $max_jabatan->id);
					$result = $this->M_pegawai->update_jabatan_akhir($id_personil,$data);		
				}				
			}
		}		
		echo json_encode($result);
	}

	function show_tandajasa($id='') {						
		$result = $this->M_pegawai->show_tandajasa($id);				
		echo json_encode($result);
	}

	function delete_tandajasa($id='') {						
		$result = $this->M_pegawai->delete_tandajasa($id);				
		echo json_encode($result);
	}

	function save_tandajasa() {
		$method = $this->input->post('method_tandajasa');
		$result = '';
		if ($method == 'edit') {
			$id = $this->input->post('id_tandajasa');
			$data = array(				
				'tanda_jasa' => $this->input->post('input_tandajasa')
			);
			$result = $this->M_pegawai->update_tandajasa($id,$data);			
		} else {
			$data = array(
				'id_personil' => $this->input->post('idpersonil_tandajasa'),
				'tanda_jasa' => $this->input->post('input_tandajasa')
			);
			$result = $this->M_pegawai->insert_tandajasa($data);
		}		
		echo json_encode($result);
	}

	function remove_foto() {
		$id=$this->input->post('id');
		$result = $this->M_pegawai->remove_foto($id);				
		echo json_encode($result);
	}

	function delete_personil() {
		$id=$this->input->post('id');
		$result = $this->M_pegawai->delete_personil($id);				
		echo json_encode($result);
	}

	function import_personil() {
		$objPHPExcel = new PHPExcel();  
		$fileName = $this->input->post('file', TRUE);

		$config['upload_path'] = './upload/'; 
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
		$config['max_size'] = 10000;

		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
		  
		if (!$this->upload->do_upload('file')) {		   
		   echo json_encode($this->upload->display_errors()); 		   
		} else {
		   $media = $this->upload->data();
		   $inputFileName = 'upload/'.$media['file_name'];
		   
		   	try {
			    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($inputFileName);
		   	} catch(Exception $e) {
		   		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		   	}

		   $sheet = $objPHPExcel->getSheet(0);
		   $highestRow = $sheet->getHighestRow();
		   $highestColumn = $sheet->getHighestColumn();

		   	for ($row = 2; $row <= $highestRow; $row++){  
			    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row);
			    $data = array(
					"nama"=> $rowData[0][0],
					"nik"=> (string)$rowData[0][1],
					"nip_nrp"=> (string)$rowData[0][2],
					"gender"=> (string)$rowData[0][3],
					"tmpt_lahir"=> (string)$rowData[0][4],
					"tgl_lahir"=> ($rowData[0][5]!='')?date('Y-m-d',strtotime($rowData[0][5])):NULL,
					"alamat"=> (string)$rowData[0][6],
					"agama"=> (string)$rowData[0][7],
					"tmt_tni"=> ($rowData[0][8]!='')?date('Y-m-d',strtotime($rowData[0][8])):NULL,
					"korps"=> (string)$rowData[0][9],
					"tmt_fiktif"=> ($rowData[0][10]!='')?date('Y-m-d',strtotime($rowData[0][10])):NULL,
					"suku"=> (string)$rowData[0][11],
					"kelompok_medis"=> (string)$rowData[0][12],
					"no_sip"=> (string)$rowData[0][13],
					"k_tk"=> (string)$rowData[0][14],
					"status_rumah"=> (string)$rowData[0][15],
					"tmt_masuk"=> ($rowData[0][16]!='')?date('Y-m-d',strtotime($rowData[0][16])):NULL,
					// "tmt_masuk"=> ($rowData[0][16]!='')?\DateTime::createFromFormat('y/m/d', $rowData[0][16])->format('Y-m-d'):NULL,
					"phone"=> (string)$rowData[0][17],
					// "pangkat_akhir"=> (int)$rowData[0][18],
					// "tmt_pangkat_akhir"=> ($rowData[0][19]!='')?\DateTime::createFromFormat('y/m/d', $rowData[0][19])->format('Y-m-d'):NULL,
					// "jabatan_akhir"=> (string)$rowData[0][20],
					// "tmt_jabatan_akhir"=> ($rowData[0][21]!='')?date('Y-m-d',strtotime($rowData[0][21])):NULL,
					"pend_umum_akhir"=> (string)$rowData[0][22],
					// "jurusan_pend_umum_akhir"=> (string)$rowData[0][23],
					// "th_pend_umum_akhir"=> (string)$rowData[0][24],
					"pend_tni_akhir"=> (string)$rowData[0][25],
					// "th_pend_tni_akhir"=> (string)$rowData[0][26],
					"penempatan_intern"=> (string)$rowData[0][27],
					"tgl_pensiun"=> ($rowData[0][28]!='')?date('Y-m-d',strtotime($rowData[0][28])):NULL,
					"dasar"=> (string)$rowData[0][29],
					"kelas_jabatan"=> (string)$rowData[0][30]
			    );		     
			    $this->db->insert("kepegawaian_personil", $data);
			    $id_personil = $this->db->insert_id();
			    if (count($id_personil) && $rowData[0][18] != '') {
			    	$data_pangkat = array(
			    		'id_personil' => $id_personil, 
			    		'pangkat' => (int)$rowData[0][18], 
			    		// 'tmt_pangkat' => ($rowData[0][19]!='')?\DateTime::createFromFormat('y/m/d', $rowData[0][19])->format('Y-m-d'):NULL
			    		'tmt_pangkat' => ($rowData[0][19]!='')?date('Y-m-d',strtotime($rowData[0][19])):NULL
			    	);
			    	$this->db->insert("kepegawaian_pangkat", $data_pangkat);
			    	$pangkat_id = $this->M_pegawai->max_pangkat($id_personil);
					if (!empty($pangkat_id)) {
						$data = array('pangkat_akhir' => $pangkat_id->id);
						$result = $this->M_pegawai->update_pangkat_akhir($id_personil,$data);		
					}	
			    }
			    if (count($id_personil) && $rowData[0][20] != '') {
			    	$data_jabatan = array(
			    		'id_personil' => $id_personil, 
			    		'jabatan' => (string)$rowData[0][20], 
			    		// 'tmt_jabatan' => ($rowData[0][21]!='')?\DateTime::createFromFormat('y/m/d', $rowData[0][21])->format('Y-m-d'):NULL
			    		'tmt_jabatan' => ($rowData[0][21]!='')?date('Y-m-d',strtotime($rowData[0][21])):NULL
			    	);
			    	$this->db->insert("kepegawaian_jabatan", $data_jabatan);
			    	$max_jabatan = $this->M_pegawai->max_jabatan($id_personil);
					if (!empty($max_jabatan)) {
						$data = array('jabatan_akhir' => $max_jabatan->id);
						$result = $this->M_pegawai->update_jabatan_akhir($id_personil,$data);		
					}	
			    }
			} 
			echo true;
		}  
	}
}