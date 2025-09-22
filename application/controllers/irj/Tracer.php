<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Tracer extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('irj/rjmtracer','',TRUE);
        $this->load->model('irj/rjmregistrasi','',TRUE);
        $this->load->model('irj/rjmpencarian','',TRUE);
        $this->load->library("EscPos.php"); 
	}
	
	public function index()
	{	
		$data['title'] = 'Cetak Tracer';	
		$this->load->view('irj/tracer',$data);	
	}	

    public function example() {     
        $this->load->library("EscPos.php"); 

    }

    public function cetak($no_register='') {        
        $ip_from = $this->input->ip_address();
        $printer=$this->rjmpencarian->printer_tracer($ip_from)->row();         
        if($no_register!=''){
            if ($printer == '') {
                echo 'Print not allowed';
            } else {
                $namars=$this->config->item('namars');
                $alamatrs=$this->config->item('alamat');
                $kota=$this->config->item('kota');
                $nmsingkat=$this->config->item('nmsingkat');
                date_default_timezone_set("Asia/Jakarta");
                $tgl_jam = date("d-m-Y H:i:s");
                $login_data = $this->load->get_var("user_info");
                $font_size = '15px';
                if ($printer->unit) {
                    $asal_unit = $printer->unit . ' | ' . $printer->no_pc;
                } else $asal_unit = '';
                if($login_data->name=='' || $login_data->name==null){
                    $user=$login_data->username;
                } else $user=$login_data->name;                    
                    $row = $this->rjmregistrasi->getdata_tracer($no_register)->row(); 
                    if ($row->jns_kunj  == 'BARU') {
                        $print_to = $printer->printer_loket;
                        $font_size = '13px';
                        $width_page = '300px';
                        $sama_dengan = '=================================';
                    } else {
                        if ($printer->id_unit == 1 && $row->cara_bayar == 'UMUM') {
                            $print_to = $printer->printer_tracer;   
                            $width_page = '415px';     
                            $sama_dengan = '============================================';
                            // echo '<script type="text/javascript">window.open("'.site_url("irj/tracer/cetak_loket/$no_register").'", "_blank");window.focus()</script>';
                        } else {
                            $print_to = $printer->printer_tracer;   
                            $width_page = '415px';     
                            $sama_dengan = '============================================';
                        }                        
                    }

                    if ($row != '') {       
                        if($row->sex=='L') {
                            $sex='Laki-laki';
                        } else { 
                            $sex='Perempuan';
                        }
                        $no_medrec=$row->no_medrec;
                        $txtperusahaan='';
                        if($row->nmkontraktor!=''){
                            if ($row->cara_bayar=='BPJS'){
                                $txtperusahaan = $row->nmkontraktor;
                            } else $txtperusahaan = $row->cara_bayar . " - " . $row->nmkontraktor;
                        } else $txtperusahaan = $row->cara_bayar;
                        //Online
                        if($row->online==1)
                            $online = " (Online)";
                        else
                            $online = "";
                        $konten2 = '';
                        $konten=
                            "<style type=\"text/css\">
                            .table-font-size{
                                    font-size:$font_size;
                                }
                            table {table-layout:fixed;}
                            table td {word-wrap:break-word;}
                            body {font-family:Helvetica,Arial;width:$width_page;height:453px;margin:0;margin-left:5px;}
                            </style>    
                            <body style='font-size:11px;'>            
                            <hr>$namars<br/>
                            Jl. Bendungan Hilir No. 17A Tlp.021-5703081 Fax.021-5711997, JAKARTA PUSAT
                            <br>
                             <h3 style=\"font-size:35px;font-weight:bold;text-align:center;margin:25px;margin-bottom:0;\">$row->no_antrian</h3>
                             <h5 style=\"font-size:23px;font-weight:bold;text-align:center;margin-bottom:0;margin-top:10px;\">No. RM : $row->no_cm</h5>
                             <p style=\"font-size:16px;text-align:center;margin:25px;margin-top:10px;\">Pasien : $row->jns_kunj $online</p>
                            <span style=\"font-size:16px;text-align:center;\">$sama_dengan</span>
                            <table class=\"table-font-size\" width=\"100%\" style=\"100%\">   
                                <tr>
                                    <td width=\"28%\"></td>
                                    <td width=\"5%\"></td>
                                    <td width=\"67%\"></td>                         
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>";
                                if($row->no_cm_lama != '') {
                                $konten2="<tr>
                                    <td>No. RM Lama </td>
                                    <td> : </td>
                                    <td><b>".$row->no_cm_lama."</b></td>
                                    
                                </tr>";
                                }                                
                                $konten3="<tr>
                                    <td>Tgl Jam</td>
                                    <td> : </td>
                                    <td>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</td>
                                    
                                </tr> <tr>
                                    <td >No. Registrasi</td>
                                    <td > : </td>
                                    <td >$row->no_register</td>
                                </tr>                                                                                         
                                <tr>
                                    <td>Nama</td>
                                    <td> : </td>
                                    <td colspan=\"2\"><b>$row->nama</b></td>
                                </tr>   
                                
                                <tr>
                                    <td>Tgl Lahir</td>
                                    <td> : </td>
                                    <td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
                                </tr>


                                <tr>
                                    <td>Layanan</td>
                                    <td> : </td>
                                    <td colspan=\"2\"><b>$row->nm_poli</b></td>
                                </tr>

                                <tr>
                                    <td>Pasien</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$txtperusahaan</td>
                                </tr>                        
                                <tr>
                                    <td>Petugas</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$user</td>
                                </tr>  
                                 <tr>
                                    <td>Pendaftar</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$row->xuser</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                           
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>                                             
                            </table>
                            <span style=\"font-size:16px;text-align:center;\">$sama_dengan</span>
                            <p style=\"font-size:9px;margin:5px;\">$asal_unit</p>
                            </body>
                        ";   
                        $konten=$konten.$konten2.$konten3;
                        echo $konten;
                        echo  "<script>
                                jsPrintSetup.setPrinter('$print_to'); 
                                jsPrintSetup.setOption('marginTop', 0);
                                jsPrintSetup.setOption('marginLeft', 0);
                                jsPrintSetup.setOption('marginRight', 0);
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

        } else {
            redirect('irj/rjcregistrasi','refresh');
        }
    }

    public function cetak_loket($no_register='') {        
        $ip_from = $this->input->ip_address();
        $printer=$this->rjmpencarian->printer_tracer($ip_from)->row();         
        if($no_register!=''){
            if ($printer == '') {
                echo 'Print not allowed';
            } else {
                $namars=$this->config->item('namars');
                $alamatrs=$this->config->item('alamat');
                $kota=$this->config->item('kota');
                $nmsingkat=$this->config->item('nmsingkat');
                date_default_timezone_set("Asia/Jakarta");
                $tgl_jam = date("d-m-Y H:i:s");
                $login_data = $this->load->get_var("user_info");
                if ($printer->unit) {
                    $asal_unit = $printer->unit . ' | ' . $printer->no_pc;
                } else $asal_unit = '';
                if($login_data->name=='' || $login_data->name==null){
                    $user=$login_data->username;
                } else $user=$login_data->name;                    
                    $row = $this->rjmregistrasi->getdata_tracer($no_register)->row(); 
                    $print_to = $printer->printer_loket;
                    $width_page = '300px';
                    $sama_dengan = '=================================';                  

                    if ($row != '') {       
                        if($row->sex=='L') {
                            $sex='Laki-laki';
                        } else { 
                            $sex='Perempuan';
                        }
                        $no_medrec=$row->no_medrec;
                        $txtperusahaan='';
                        if($row->nmkontraktor!=''){
                            if($row->cara_bayar=='BPJS'){
                                $txtperusahaan=$row->nmkontraktor;
                            } else $txtperusahaan=$row->cara_bayar . " - " . $row->nmkontraktor;
                        } else $txtperusahaan=$row->cara_bayar;
                        $konten2 = '';
                        $konten=
                            "<style type=\"text/css\">
                            .table-font-size{
                                    font-size:13px;
                                }
                            table {table-layout:fixed;}
                            table td {word-wrap:break-word;}
                            body {font-family:Helvetica,Arial;width:$width_page;height:453px;margin:0;margin-left:5px;}
                            </style>    
                            <body style='font-size:11px;'>            
                            <hr>$namars<br/>
                            Jl. Bendungan Hilir No. 17A Tlp.021-5703081 Fax.021-5711997, JAKARTA PUSAT
                            <br>
                             <h3 style=\"font-size:35px;font-weight:bold;text-align:center;margin:25px;margin-bottom:0;\">$row->no_antrian</h3>
                             <h5 style=\"font-size:23px;font-weight:bold;text-align:center;margin-bottom:0;margin-top:10px;\">No. RM : $row->no_cm</h5>
                             <p style=\"font-size:16px;text-align:center;margin:25px;margin-top:10px;\">Pasien : $row->jns_kunj</p>
                            <span style=\"font-size:16px;text-align:center;\">$sama_dengan</span>
                            <table class=\"table-font-size\" width=\"100%\" style=\"100%\">   
                                <tr>
                                    <td width=\"32%\"></td>
                                    <td width=\"5%\"></td>
                                    <td width=\"63%\"></td>                         
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>";
                                if($row->no_cm_lama != '') {
                                $konten2="<tr>
                                    <td>No. RM Lama </td>
                                    <td> : </td>
                                    <td><b>".$row->no_cm_lama."</b></td>
                                    
                                </tr>";
                                }                                
                                $konten3="<tr>
                                    <td>Tgl Jam</td>
                                    <td> : </td>
                                    <td>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</td>
                                    
                                </tr> <tr>
                                    <td >No. Registrasi</td>
                                    <td > : </td>
                                    <td >$row->no_register</td>
                                </tr>                                                                                         
                                <tr>
                                    <td>Nama</td>
                                    <td> : </td>
                                    <td colspan=\"2\"><b>$row->nama</b></td>
                                </tr>   
                                
                                <tr>
                                    <td>Tgl Lahir</td>
                                    <td> : </td>
                                    <td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
                                </tr>


                                <tr>
                                    <td>Layanan</td>
                                    <td> : </td>
                                    <td colspan=\"2\"><b>$row->nm_poli</b></td>
                                </tr>

                                <tr>
                                    <td>Pasien</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$txtperusahaan</td>
                                </tr>                        
                                <tr>
                                    <td>Petugas</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$user</td>
                                </tr>  
                                <tr>
                                    <td>Pendaftar</td>
                                    <td> : </td>
                                    <td colspan=\"2\">$row->xuser</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>                           
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>                                             
                            </table>
                            <span style=\"font-size:16px;text-align:center;\">$sama_dengan</span>
                            <p style=\"font-size:9px;margin:5px;\">$asal_unit</p>
                            </body>
                        ";   
                        $konten=$konten.$konten2.$konten3;
                        echo $konten;
                        echo  "<script>
                                jsPrintSetup.setPrinter('$print_to'); 
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

        } else {
            redirect('irj/rjcregistrasi','refresh');
        }
    }

    // public function test_tracer($no_register) {   
         
    //     $ip_from = $this->input->ip_address();
    //     // $printer=$this->rjmpencarian->printer_tracer($ip_from)->row();           
    //     if ($no_register != '') {
    //         $namars=$this->config->item('namars');
    //         $alamatrs=$this->config->item('alamat');
    //         $kota=$this->config->item('kota');
    //         $nmsingkat=$this->config->item('nmsingkat');

    //         date_default_timezone_set("Asia/Jakarta");
                        
    //         $data_tracer=$this->rjmregistrasi->getdata_tracer($no_register)->result();

    //         foreach($data_tracer as $row) {
    //             if ($row->sex=='L') {
    //                 $sex='Laki-laki';
    //             } else { 
    //                 $sex='Perempuan';
    //             }

    //             $txtperusahaan='';
    //             if($row->cara_bayar!='UMUM'){
    //                 $txtperusahaan="BPJS ".$row->nmkontraktor;
    //             } else $txtperusahaan='UMUM';
    //             // if ($printer == '') {
    //             //     echo 'Print not allowed';
    //             // } else {
    //                 try {         
    //                     $tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));   
    //                     $tgl_jam = date('d-m-Y',strtotime($row->tgl_kunjungan)) . " | " . date('H:i:s',strtotime($row->tgl_kunjungan));          
    //                     $login_data = $this->load->get_var("user_info");
    //                     if($login_data->name=='' || $login_data->name==null){
    //                         $user=$login_data->username;
    //                     }else $user=$login_data->name;                                    
    //                     $connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("smb://192.168.1.212/TX 80 Thermal");
    //                     $connector->write(Mike42\Escpos\Printer::GS.'R'.$this->intLowHigh(512, 2)); 
    //                     $profile = Mike42\Escpos\CapabilityProfiles\DefaultCapabilityProfile::getInstance();
    //                     $printer = new Mike42\Escpos\Printer($connector);
    //                     $printer -> setEmphasis(true);
    //                     $margin = 32;
    //                     $width = 140;                     
    //                         $printer -> setFont(Mike42\Escpos\Printer::FONT_C); 
    //                         $printer->text("$namars\n");                            
    //                         $printer->text("Jl. Bendungan Hilir No.17A, RT.4/RW.3\nBendungan Hilir, Tanah Abang\n");   
    //                         $printer->text("\n");  
    //                         $printer->text("\n");     
    //                         $printer -> setTextSize(8, 8);
    //                         $printer->text("$row->no_antrian\n"); 
    //                         $printer -> setTextSize(1, 1);  
    //                         $printer->text("\n");  
    //                         $printer->text("\n");
    //                         $printer->text("====================================\n");
    //                         $printer -> setFont(Mike42\Escpos\Printer::FONT_B);                         
    //                         $printer->text("No. Registrasi : $no_register\n");                                                 
    //                         $printer->text("Tgl Jam : $tgl_jam\n");                            
    //                         $printer->text("No. RM : $row->no_cm\n");                            
    //                         if ($row->no_cm_lama != '') {                                
    //                             $printer->text("No. RM Lama : $row->no_cm_lama\n");
    //                         }
                                                        
    //                         // $printer->text("Nama : $row->nama\n");   
    //                         // $printer -> setPrintLeftMargin(140);                         
    //                         $printer->text("Nama : ANDRI GUNAWAN HAMENGKUBUWONO HADIKUSUMO ATMADJAYA\n");  
    //                         $printer->text("Tgl Lahir : $tgl_lahir\n");                            
    //                         // $printer->text("Layanan : $row->nm_poli\n");                            
    //                         $printer->text("Layanan : POLI BEDAH PENYAKIT DALAM DALAM\n"); 
    //                         $printer->text("Pasien : $txtperusahaan\n");                            
    //                         $printer->text("Petugas : $user\n");
    //                         $printer -> setFont(Mike42\Escpos\Printer::FONT_A); 
    //                         $printer->text("====================================\n");
    //                         $printer->cut();
    //                         $printer->close(); 
    //                         echo "sukses";  
                                       
    //                 } catch (Exception $e) {
    //                     echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    //                 }
    //             // }                                
    //         }
    //     } else {
    //         return false;
    //     }

    // }

	public function get_pasien()
    {
        $list = $this->rjmtracer->get_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->no_register;
            $row[] = $result->no_cm;
            $row[] = $result->nama;            
            $row[] = $result->nm_poli;
            $row[] = $result->tgl_kunjungan;
            if ($result->cetak_tracer == 1) {
            	$row[] = '<i class="fa fa-check"></i>';
            } else $row[] = '';	
            if ( date("Y-m-d") == substr($result->tgl_daftar,0,10) ) 
            $jns_kunjungan="BARU";
            else $jns_kunjungan="LAMA";
            $row[] = '<center><button class="btn btn-danger btn-sm delete-sep" onclick="cetak_tracer(\''.$result->no_register.'\',\''.$jns_kunjungan.'\')" style="margin-bottom:5px;"><i class="fa fa-print"></i> Cetak</button><a class="btn btn-success btn-sm" href="'.site_url("irj/Rjcsjp/cetak_sjp/").'/'.$result->no_register.'" target="_blank">Cetak SJP IRJ</a></center>';	
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->rjmtracer->count_all(),
                        "recordsFiltered" => $this->rjmtracer->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }	
}
