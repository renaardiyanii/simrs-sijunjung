<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Antrian extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('antrian/Mantrian','',TRUE);		
	}

	public function index()
	{
		
		$this->load->view('antrian/loket');
	}

	public function client()
	{		
		$this->load->view('antrian/client');
	}	

	public function pasien()
	{		
		$this->load->view('antrian/pasien');
	}	

	public function cetak_antrian($jns_pasien) {
		date_default_timezone_set("Asia/Jakarta");
		$cur_date = date('Y-m-d');
		$antrian = $this->Mantrian->get_antrian($cur_date); 		
				switch ($jns_pasien) {
				    case 'bpjs':	
				    	$nomor = $antrian->total_bpjs+1;			    	
				    	$no_antrian = 'F' . $nomor;  
				    	$data_update = array('total_bpjs' => $nomor);
				    	$this->Mantrian->update_antrian($data_update);         		
				    break;
				    case 'anggota':
				    	$nomor = $antrian->total_anggota+1;			    	
				    	$no_antrian = 'D' . $nomor;  
				    	$data_update = array('total_anggota' => $nomor);
				    	$this->Mantrian->update_antrian($data_update);         		
				    break;
				    case 'fisio':
				    	$nomor = $antrian->total_fisio+1;			    	
				    	$no_antrian = 'E' . $nomor;  
				    	$data_update = array('total_fisio' => $nomor);
				    	$this->Mantrian->update_antrian($data_update);           		
				    break;
				}                                     
                $hour = date("H:i:s"); 
                $date = date("d");
        		$year = date("Y");
        		$month = date("m"); 
                $months = array('','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'); 
                   $konten="<head>
    							<meta charset=\"utf-8\">
    							<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    							<title>Nomor Antrian</title>
	    						<style type=\"text/css\">
	                            	body {font-family:Helvetica,Arial;width:8cm;height:5cm;margin:0;margin-left:5px;}
	                            </style>  
                            </head>  
                            <body style='font-size:14px;'>                            
								<div style=\"background:#fff;float:left;width:5cm;height:8cm;border:solid thin;padding:10px;margin:0cm;\">
									<div style=\"text-align:center;border-bottom:solid thin;padding-bottom:10px;\">
										<span style=\"font-weight:bold;\">RUMAH SAKIT</span>
										<br>
										<span style=\"font-weight:bold;margin-top:10px;\">TNI AL MINTOHARDJO</span>
										<br/>
										<span style=\"font-size:12px;\">$date $months[$month] $year $hour</span>
									</div>
									<div style=\"text-align:center;border-bottom:solid thin;padding-bottom:10px;\">
									<p>No. Antrian :</p>
										<span style=\"font-size:80px;\">$no_antrian</span>	</div>
									<div style=\"text-align:center;padding-top:10px;\">
											</div>
									<div style=\"text-align:center;padding-top:10px;\">										
										<span style=\"font-size:12px;\">Jl. Bendungan Hilir No. 17A, JAKARTA PUSAT</span>
										<br/>
										<span style=\"text-align:left;font-size:12px;\">Tlp.021-5703081 Fax.021-5711997</span>
										</div>
								</div>                           
                            </body>";                           
                        echo $konten;
                        echo  "<script>
                                jsPrintSetup.setPrinter('TX 80 Thermal'); 
                                jsPrintSetup.setOption('marginTop', '');
                                jsPrintSetup.setOption('marginLeft', '');
                                jsPrintSetup.setOption('headerStrLeft', '');
                                jsPrintSetup.setOption('headerStrCenter', '');
                                jsPrintSetup.setOption('headerStrRight', '');
                                jsPrintSetup.setOption('footerStrLeft', '');
                                jsPrintSetup.setOption('footerStrCenter', '');
                                jsPrintSetup.setOption('footerStrRight', '');
                                jsPrintSetup.setOption('printSilent',1);
                                jsPrintSetup.print(); 
                                close();
                            </script>";                                                                             

    }
}