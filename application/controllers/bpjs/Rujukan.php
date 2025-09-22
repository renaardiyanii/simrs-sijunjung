<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');


class Rujukan extends Secure_area {
	public $xuser;
	public $connection_error;
	public $bpjs_config;
	public function __construct(){
	    parent::__construct();
	    $this->load->helper('pdf_helper');	
	    $this->load->helper('tgl_indo');
		$this->load->library('vclaim');
	    $this->load->model('bpjs/Mbpjs','',TRUE);
	    $this->load->model('bpjs/Mrujukan','',TRUE);
	    $this->load->model('bpjs/Msep','',TRUE);	
	    $this->xuser = $this->load->get_var("user_info")->username; 
		$result_error = array(
			'metaData' => array('code' => '503','message' => 'Terjadi Kesalahan, koneksi dengan service gagal'),
			'response' => ['peserta' => null]
		);
		$this->connection_error = json_encode($result_error); 
		$this->bpjs_config = $this->Mbpjs->get_data_bpjs();	    
	}

	public function index()
    {   
        $data['title'] = 'Rujukan';  
        $this->load->view('bpjs/rujukan/index',$data);  
    } 

    public function get_rujukan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $list = $this->Mrujukan->get_rujukan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<center>'.$result->no_rujukan.'</center>';
            $row[] = '<center>'.$result->no_sep.'</center>';
            $row[] = '<center>'.$result->nama_poli_rujukan.'</center>';
            $row[] = $result->nama;
            $row[] = $result->no_bpjs;           
            $row[] = '<center>'.date_indo(date('Y-m-d',strtotime($result->tgl_rujukan))).'</center>';
            if ($result->deleted == 1) {
            	$row[] = '<label class="label label-danger text-center">Telah dihapus</label>'; 
            } else {
            	$row[] = '<a href="'.site_url('bpjs/rujukan/cetak/'.$result->no_rujukan).'" target="_blank" class="btn waves-effect waves-light btn-primary btn-xs btn-block"><i class="fa fa-print"></i> Cetak</a><button class="btn waves-effect waves-light btn-warning btn-xs btn-block update-rujukan" data-no-rujukan="'.$result->no_rujukan.'"><i class="fa fa-pencil-square-o"></i> Update</button><button class="btn waves-effect waves-light btn-danger btn-xs btn-block delete-rujukan" data-no-rujukan="'.$result->no_rujukan.'"><i class="fa fa-trash"></i> Hapus</button>'; 
            }  
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mrujukan->count_all(),
            "recordsFiltered" => $this->Mrujukan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }  

    public function show_rujukan($no_rujukan)
    {
        $result = $this->Mrujukan->show_rujukan($no_rujukan);
        echo json_encode($result);
    }  

	function pcare($no_rujukan='') {
		$param = 'Rujukan/'.$no_rujukan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			echo $result;
		} else {			
			echo $this->connection_error;
		}
	}

	function rs($no_rujukan='') {
		$param = 'Rujukan/RS/'.$no_rujukan;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			echo $result;
		} else {			
			echo $this->connection_error;
		}
	}

	function no_bpjs($no_bpjs='') {
		$jenis_faskes = $this->input->post('jenis_faskes');
		if ($jenis_faskes == 'RUJUKAN RS') {
			$param = 'Rujukan/RS/Peserta/'.$no_bpjs;
		} else $param = 'Rujukan/Peserta/'.$no_bpjs;
		$content_type = 'application/json';
		$result = $this->vclaim->get($param,$content_type);
		if ($result) {
			echo $result;
		} else {			
			echo $this->connection_error;
		}
	}

	function create() 
	{	
		$noBpjs = $this->input->post('noka');
		$noSep = $this->input->post('no_sep');
		$nama = $this->input->post('nama');
		$tglRujukan = $this->input->post('tgl_rujukan');
		$ppkDirujuk = $this->input->post('ppk_dirujuk');
		if ($ppkDirujuk != '' && $ppkDirujuk != null) {
			$ppk_rujukan = explode(" - ", $this->input->post('ppk_dirujuk'));
			$ppkDirujuk = $ppk_rujukan[0];
		}
		$jnsPelayanan = $this->input->post('jenis_pelayanan');
		$catatan = $this->input->post('catatan');                 
		$diagRujukan = $this->input->post('diagnosa_rujukan');                 
		$tipeRujukan = $this->input->post('tipe_rujukan');                 
		$poliRujukan = $this->input->post('poli_rujukan'); 
		$kode_diagnosa = '';
		if ($diagRujukan != '' && $diagRujukan != null) {
			$diagnosa = explode(" - ", $diagRujukan);
			$kode_diagnosa = $diagnosa[0];
		}
		if ($poliRujukan != '' && $poliRujukan != null) {
			$poli_rujukan = explode(" - ", $this->input->post('poli_rujukan'));
			$poliRujukan = $poli_rujukan[0];
		}
		$request_sep = array(
		   	'request' => array(
		   		't_rujukan' => array(
		   			'noSep' => $noSep,
		   			'tglRujukan' => $tglRujukan,
		   			'ppkDirujuk' => $ppkDirujuk,
		   			'jnsPelayanan' => $jnsPelayanan,
		   			'catatan' => $catatan,                 
		   			'diagRujukan' => $kode_diagnosa,                 
		   			'tipeRujukan' => $tipeRujukan,                 
		   			'poliRujukan' => $poliRujukan,                 
                 	'user' => $this->xuser		   					   			
		   		)
		   	)
		);		
		$data_rujukan = json_encode($request_sep);	
        $param = 'Rujukan/insert';
		$content_type = 'Application/x-www-form-urlencoded';
		$result = $this->vclaim->post($param,$content_type,$data_rujukan);
		$result_object = json_decode($result);
		if ($result_object->metaData->code == '200') {
			$data_insert = array(
				'no_bpjs' => $noBpjs,
       			'no_sep' => $noSep,
       			'no_rujukan' => $result_object->response->rujukan->noRujukan,
       			'tgl_rujukan' => $result_object->response->rujukan->tglRujukan,
       			'kode_ppk_dirujuk' => $result_object->response->rujukan->tujuanRujukan->kode,
       			'nama_ppk_dirujuk' => $result_object->response->rujukan->tujuanRujukan->nama,
       			'kode_poli_rujukan' => $result_object->response->rujukan->poliTujuan->kode,
       			'nama_poli_rujukan' => $result_object->response->rujukan->poliTujuan->nama,
       			'nama' => $nama,
       			'diagnosa' => $diagRujukan,
       			'jenis_pelayanan' => $jnsPelayanan,
       			'tipe_rujukan' => $tipeRujukan,
       			'jenis_kelamin' => $result_object->response->rujukan->peserta->kelamin,
       			'keterangan' => $catatan,
       			'created_at' => date('Y-m-d H:i:s'),
       			'user_created' => $this->xuser
          	);
			$this->Mrujukan->insert_rujukan($data_insert);		
		}
		echo $result;
	}

	function update() 
	{	
		$ppkDirujuk = $this->input->post('update_ppk_dirujuk');
		$diagRujukan = $this->input->post('update_diagnosa_rujukan');                 
		$poliRujukan = $this->input->post('update_poli_rujukan'); 
		$kode_diagnosa = '';
		$nama_poli_rujukan = '';
		$nama_ppk_dirujuk = '';
		if ($ppkDirujuk != '' && $ppkDirujuk != null) {
			$ppk_rujukan = explode(" - ", $this->input->post('update_ppk_dirujuk'));
			$ppkDirujuk = $ppk_rujukan[0];
			$nama_ppk_dirujuk = $ppk_rujukan[1];
		}
		if ($diagRujukan != '' && $diagRujukan != null) {
			$diagnosa = explode(" - ", $diagRujukan);
			$kode_diagnosa = $diagnosa[0];
		}
		if ($poliRujukan != '' && $poliRujukan != null) {
			$poli_rujukan = explode(" - ", $poliRujukan);
			$poliRujukan = $poli_rujukan[0];
			$nama_poli_rujukan = $poli_rujukan[1];
		}
		$request_sep = array(
		   	'request' => array(
		   		't_rujukan' => array(
		   			'noRujukan' => $this->input->post('update_norujukan'),
		   			'ppkDirujuk' => $ppkDirujuk,
		   			'tipe' => $this->input->post('update_tipe_rujukan'),
		   			'jnsPelayanan' => $this->input->post('update_jenis_pelayanan'),
		   			'catatan' => $this->input->post('update_catatan'),                 
		   			'diagRujukan' => $kode_diagnosa,                 
		   			'tipeRujukan' => $this->input->post('update_tipe_rujukan'),                 
		   			'poliRujukan' => $poliRujukan,                 
                 	'user' => $this->xuser		   					   			
		   		)
		   	)
		);		
		$data_rujukan = json_encode($request_sep);	
        $param = 'Rujukan/update';
		$content_type = 'Application/x-www-form-urlencoded';
		$result = $this->vclaim->put($param,$content_type,$data_rujukan);
		$result_object = json_decode($result);
		if ($result_object->metaData->code == '200') {
			$data_update = array(
       			'kode_ppk_dirujuk' => $ppkDirujuk,
       			'nama_ppk_dirujuk' => $nama_ppk_dirujuk,
       			'kode_poli_rujukan' => $poliRujukan,
       			'nama_poli_rujukan' => $nama_poli_rujukan,
       			'diagnosa' => $diagRujukan,
       			'jenis_pelayanan' => $this->input->post('update_jenis_pelayanan'),
       			'tipe_rujukan' => $this->input->post('update_tipe_rujukan'),
       			'keterangan' => $this->input->post('update_catatan'),
       			'updated_at' => date('Y-m-d H:i:s'),
       			'user_updated' => $this->xuser
          	);
			$this->Mrujukan->update($this->input->post('update_norujukan'),$data_update);		
		}
		echo $result;
	}

	public function delete() 
	{
		$no_rujukan = $this->input->post('no_rujukan');
		if ($no_rujukan == '' || $no_rujukan == null){
			$result_error = array(
        		'metaData' => array('code' => '402','message' => 'No. Rujukan tidak boleh kosong.'),
        		'response' => ['peserta' => null]
      		);
			echo json_encode($result_error);		
		} else {				        
		  	$data_request = array(
		   		'request'=>array(
			   		't_rujukan'=>array(
			   			'noRujukan' => $no_rujukan,
			   			'user' => $this->xuser
			   		)
			   	)
		   	);
    	   	$data = json_encode($data_request);										
            $param = 'Rujukan/delete';
			$content_type = 'application/x-www-form-urlencoded';
			$result = $this->vclaim->delete($param,$content_type,$data);
            if ($result) { 
		    	$result_object = json_decode($result);
				if ($result_object->metaData->code == '200') {
					$data_update['deleted'] = 1;
					$data_update['deleted_at'] = date('Y-m-d H:i:s');
					$data_update['user_deleted'] = $this->xuser;
					$this->Mrujukan->update($no_rujukan,$data_update);					
				}
				echo $result;	
		 	} else {				
				echo $this->connection_error;					 			
		 	}
		}
	}

	public function sep($no_sep="") {			
		$param = 'SEP/'.$no_sep;
		$content_type = 'Application/x-www-form-urlencoded';
		$result = $this->vclaim->get($param,$content_type);				
		if ($result) {
			echo $result;
		} else {
			echo $this->connection_error;
		}
	}

	public function cetak($no_rujukan="") {					
		$data_rujukan = $this->Mrujukan->show_rujukan($no_rujukan);
		if (empty($data_rujukan)) {     
			$error_view = '<!DOCTYPE html>
							<html>
							<head>
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<style>
							.notice {
							    padding: 15px;
							    background-color: #fafafa;
							    border-left: 6px solid #7f7f84;
							    margin-top: 25px;
							    margin-bottom: 10px;
							    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
							}
							.notice-danger {
								font-family: Helvetica,Arial;
							    border-color: #d73814;
							}
							.notice-danger h3
							{
								margin-top: 0;
								margin-bottom: 15px;
							    color: #d9534f;
							    font-family: Helvetica,Arial;
							}
							</style>
							</head>
							<body>
								<div class="notice notice-danger">
									<h3>Tidak Dapat Mencetak Rujukan</h3>
	        						Data tidak ditemukan.
	    						</div>
							</body>
							</html>';
			echo $error_view;
			return true;
		} else {
			switch ($data_rujukan->tipe_rujukan) {
				case 0:
					$tipe_rujukan = 'Rujukan Penuh';
					break;
				case 1:
					$tipe_rujukan = 'Rujukan Partial';
					break;
				case 2:
					$tipe_rujukan = 'Rujukan Balik';
					break;
				default:
					$tipe_rujukan = '';
					break;
			}
			switch ($data_rujukan->jenis_pelayanan) {
				case 1:
					$jenis_pelayanan = 'Rawat Inap';
					break;
				case 2:
					$jenis_pelayanan = 'Rawat Jalan';
					break;
				default:
					$jenis_pelayanan = '';
					break;
			}
      	    $fields = array(
				'nama_ppk_dirujuk' => $data_rujukan->nama_ppk_dirujuk,
       			'nama_poli_rujukan' => $data_rujukan->nama_poli_rujukan,
       			'nama' => $data_rujukan->nama,
       			'no_bpjs' => $data_rujukan->no_bpjs,
       			'diagnosa' => $data_rujukan->diagnosa,
       			'keterangan' => $data_rujukan->keterangan,
       			'no_bpjs' => $data_rujukan->no_bpjs,
       			'no_rujukan' => $data_rujukan->no_rujukan,
       			'tipe_rujukan' => $tipe_rujukan,
       			'jenis_pelayanan' => $jenis_pelayanan,
       			'jenis_kelamin' => $data_rujukan->jenis_kelamin
			);				
					        		
    		$data_cetakan = json_encode($fields);
			$this->cetakan_rujukan($data_cetakan);							
		}
	}

	public function cetakan_rujukan($data_cetakan)
	{	$fields = json_decode($data_cetakan);
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		$konten_sep = "<style type=\"text/css\">
				.content-rujukan {
					font-size: 7.5px;
					letter-spacing: normal;
				}
				</style>
				<table class=\"content-rujukan\" border=\"0\" cellpadding=\"3\">
					<tr>
						<td width=\"20%\">
						<br>
							<img src=\"assets/images/logos/logo_bpjs.png\" alt=\"img\" height=\"40\">
						</td>
						<td width=\"60%\" align=\"center\">
							
								<br><br><span style=\"font-size: 9px;font-weight: bold;text-decoration: underline;\">SURAT RUJUKAN RUMAH SAKIT</span>
							<br><br>
							<span style=\"font-size: 9px;\">$fields->tipe_rujukan</span>
						</td>
						<td width=\"20%\" align=\"right\">
								
						</td>
					</tr>
					<br>
					<br>
					<br>
					<tr>
						<td width=\"11%\">Kepada Yth</td>
						<td width=\"2%\">:</td>
						<td width=\"40%\" style=\"font-weight: bold;\">$fields->nama_ppk_dirujuk</td>
						<td width=\"15%\">No. Rujukan</td>
						<td width=\"2%\">:</td>
						<td width=\"30%\"style=\"font-weight: bold;\">$fields->no_rujukan</td>
					</tr>		
					<tr>
						<td></td>
						<td></td>
						<td>$fields->nama_poli_rujukan</td>
						<td>Asal Rumah Sakit</td>
						<td>:</td>
						<td>RSAL DR MINTOHARJO</td>
					</tr>		
					<tr>
						<td colspan=\"5\">Mohon pemeriksaan dan penanganan lebih lanjut penderita :</td>
					</tr>	
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td>$fields->nama</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu BPJS</td>
						<td>:</td>
						<td>$fields->no_bpjs</td>
						<td>Kelamin</td>
						<td>:</td>
						<td>$fields->jenis_kelamin</td>
					</tr>
					<tr>
						<td>Diagnosa</td>
						<td>:</td>
						<td>$fields->diagnosa</td>
						<td>Rawat</td>
						<td>:</td>
						<td>$fields->jenis_pelayanan</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td>$fields->keterangan</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>				
					<tr>
						<td colspan=\"3\">Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
						<td></td>
						<td width=\"18%\" colspan=\"2\" align=\"center\">".date_indo(date('Y-m-d'))."<br><br>Mengetahui</td>
					</tr>		
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width=\"18%\" align=\"center\"><br/><br/><br/><br/>_____________________</td>
						<td></td>
					</tr>										
				</table>
			";	

		$file_name="Rujukan_".$fields->no_rujukan.".pdf";
		tcpdf();
		$width = 216;
		$height = 356;
		$pageLayout = array($width, $height); 
		$obj_pdf = new TCPDF('P', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetMargins('5', '2', '5');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten_sep.$konten_perincian;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'download/bpjs/rujukan/'.$file_name, 'FI');				
	}
}

?>
