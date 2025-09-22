<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');

class Gizi extends Secure_area {
    public $xuser;
	public function __construct() {
			parent::__construct();
            $this->xuser = $this->load->get_var("user_info")->username; 
			$this->load->model('gizi/Mgizi','',TRUE);
            $this->load->model('gizi/M_diet','',TRUE);
            $this->load->model('iri/rimtindakan','',TRUE);
            $this->load->model('irj/rjmpelayanan','',TRUE);
            $this->load->model('master/mmgizi','',TRUE);	
            $this->load->helper('pdf_helper');
            $this->load->helper('tgl_indo');			            
		}

	public function index()
	{    	
		$data['title'] = 'Gizi';	
        $data['ruangan'] = $this->Mgizi->get_lokasi_ruang()->result();
        $data['notif'] = $this->Mgizi->get_notif();
		$this->load->view('gizi/index',$data); 
	}

    public function ruangan($ruangan)
    {
        if (is_null($ruangan)) {
            redirect('gizi');
        }       
        $data['title'] = 'Gizi';    
        $ruang = str_replace('%20',' ',$ruangan);
        $data['ruangan'] = $ruang;
        // var_dump($data['ruangan']);die();
        if ($ruangan == 'ugd') {
            $this->load->view('gizi/ruangan_ugd',$data); 
        } else {
            $this->load->view('gizi/ruangan',$data); 
        }
    }

    public function permintaan_diet($no_ipd)
    {       
        $data['title'] = 'Form Permintaan Diet'; 
        $data['standar_diet'] = $this->Mgizi->standar_diet();           
        $data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();
        $data2['gizi']=null;
        $this->Mgizi->update_ceklis_ahli_gizi($no_ipd,$data2);   
        if (substr($no_ipd, 0,2) == 'RI') {
            $data['data_pasien'] = $this->Mgizi->show_pasien_iri($no_ipd);
            $kamar_bed = explode(" ", $data['data_pasien']->bed);
            $kamar = substr($kamar_bed[0], -2);
            $data['kamar_bed'] = $kamar . ' - '. $kamar_bed[2];
            $this->load->view('gizi/permintaan_diet',$data); 
        } else {
            $data['data_pasien'] = $this->Mgizi->show_pasien_ugd($no_ipd);  
            $this->load->view('gizi/permintaan_diet_ugd',$data); 
        }        
    }

    public function asuhan_gizi($no_ipd)
    {       
        $data['title'] = 'Formulir Asuhan Gizi'; 
        $data['standar_diet'] = $this->Mgizi->standar_diet();           
        $data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();   
        if (substr($no_ipd, 0,2) == 'RI') {
            $data['data_pasien'] = $this->Mgizi->show_pasien_iri($no_ipd);
            $kamar_bed = explode(" ", $data['data_pasien']->bed);
            $kamar = substr($kamar_bed[0], -2);
            $data['kamar_bed'] = $kamar . ' - '. $kamar_bed[2];
            $this->load->view('gizi/asuhan_gizi',$data); 
        } else {
            $data['data_pasien'] = $this->Mgizi->show_pasien_ugd($no_ipd);  
            $this->load->view('gizi/permintaan_diet_ugd',$data); 
        }        
    }

    public function insert_ceklis_ahli_gizi($no_ipd, $nmcb, $val)
    {   
        // $no_ipd = $this->input->post('no_ipd');
        
        $data['update_at'] = date('Y-m-d H:i:s');
        $data[$nmcb] = $val;
        // var_dump($val);
        // var_dump($val);
        // die();
        // $data = array(
        //     'edukasi' => $this->input->post('edCheckbox'), 
        //     'screening' => $this->input->post('screnCheckbox'), 
        //     'asuhan' => $this->input->post('asCheckbox')
        // );
        // echo $data['$nmcb'];
        // die();
        $this->Mgizi->update_ceklis_ahli_gizi($no_ipd, $data);  
        $result = array(
            'metadata' => array('code' => '200','message' => 'Ceklis Berhasil Disimpan.'),
            'response' => null
        );
        echo json_encode($result);
        
    }
    public function show_ceklis_ahli_gizi($no_ipd)
    {       
        $result = $this->Mgizi->show_ceklis_ahli_gizi($no_ipd);     
        echo json_encode($result);
    }


    public function insert_permintaan_diet()
    {   
        // var_dump($this->input->post());die();
        $no_ipd = $this->input->post('no_ipd');
        $standar_diet = $this->input->post('standar_diet');
        $bentuk_makanan = $this->input->post('bentuk_makanan');
        $catatan = $this->input->post('catatan');
        if($this->input->post('tgl_permintaan')!=null){
            $waktu_permintaan = $this->input->post('tgl_permintaan').' '.$this->input->post('jam_permintaan').':00';
        }else{
            $waktu_permintaan = date('Y-m-d H:i:s');
        }
        
        $current = $this->Mgizi->show_permintaan_diet($no_ipd); 
        //  var_dump($current);die(); 
        if ($current != null && $standar_diet == $current->standar && $bentuk_makanan == $current->bentuk && $catatan == $current->catatan && substr($waktu_permintaan, 0,16) == substr($current->created_at, 0,16)) {
            $result = array(
                'metadata' => array('code' => '402','message' => 'Tidak ada perubahan.'),
                'response' => null
            );
            echo json_encode($result);
        } else {
            $data = array(
                'no_ipd' => $this->input->post('no_ipd'), 
                'bed' => $this->input->post('bed'), 
                'standar' => $this->input->post('standar_diet'), 
                'bentuk' => $this->input->post('bentuk_makanan'), 
                'catatan' => $this->input->post('catatan'), 
                'created_by' => $this->xuser, 
                'created_at' => $waktu_permintaan
            );
            $this->Mgizi->insert_permintaan_diet($data);  
            $data2['gizi']='1';
            $this->Mgizi->update_ceklis_ahli_gizi($no_ipd,$data2);  
            $result = array(
                'metadata' => array('code' => '200','message' => 'Permintaan Diet Berhasil Disimpan.'),
                'response' => null,
            );
            echo json_encode($result);
        }
        
    }

    public function show_permintaan_diet($no_ipd)
    {       
        $result = $this->Mgizi->show_permintaan_diet($no_ipd);           
        echo json_encode($result);
    }

    public function delete_permintaan_diet($id)
    {       
        $result = $this->Mgizi->delete_permintaan_diet($id);           
        echo json_encode($result);
    }

    public function show_permintaan_diet_byid($id)
    {       
        $result = $this->Mgizi->show_permintaan_diet_byid($id);           
        echo json_encode($result);
    }

    public function edit_permintaan_diet()
    {   
        $id = $this->input->post('id');
        $waktu_permintaan = $this->input->post('tgl_permintaan').' '.$this->input->post('jam_permintaan').':00';
        $data = array(
            'standar' => $this->input->post('standar_diet'), 
            'bentuk' => $this->input->post('bentuk_makanan'), 
            'catatan' => $this->input->post('catatan'), 
            'created_by' => $this->xuser, 
            'created_at' => $waktu_permintaan
        );
        $this->Mgizi->update_permintaan_diet($id, $data);  
        $result = array(
            'metadata' => array('code' => '200','message' => 'Permintaan Diet Berhasil Diedit.'),
            'response' => null,
        );
        echo json_encode($result);
        
    }

    public function edit_flag_permintaan_diet()
    {   
        // var_dump($this->input->post());die();
        $data = array(
            'permintaan_gizi' => $this->input->post('flag'), 
        );
        $no_register = ($this->input->post('no_ipd')!=null) ? $this->input->post('no_ipd') : $this->input->post('no_register') ;
        $this->Mgizi->update_flag_permintaan_diet($no_register, $data);  
        $result = array(
            'metadata' => array('code' => '200','message' => 'Permintaan Diet Berhasil Diupdate.'),
            'response' => null,
        );
        echo json_encode($result);
    }


    public function cetak_permintaan_($lokasi)
    {
        $result = $this->Mgizi->per_ruangan($lokasi)->result();

        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $nmsingkat=$this->config->item('nmsingkat');  
        $tanggal = date('Y-m-d');              

        $konten = "<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                    }
                    .table-ttd{
                        font-size:7px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:7px;
                        font-style:italic;
                    }
                </style><style type=\"text/css\">
                .table>tbody>tr>td {vertical-align: middle}
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <div align=\"right\">
                            Dicetak pada ".date('d F Y, H:i')."
                        </div>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"40%\" style=\"font-size:9px;\">
                                    <table cellpadding=\"2\">
                                        <tr>
                                          <td>DINAS KESEHATAN ANGKATAN LAUT</td>
                                        </tr>
                                         <tr>
                                          <td>RUMKITAL DR. MINTOHARDJO</td>
                                        </tr>
                                        <tr>
                                          <td><hr></td>
                                        </tr>
                                    </table>
                                </td>                                  
                            </tr>
                        </table>
                        <br>
                        <br>
                        <table style=\"text-align:center;font-size:12px;\">
                            <tr>
                            <td style=\"font-weight:bold;\">DAFTAR PERMINTAAN DIET PASIEN</td>
                            </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size\">                           
                            <tr>                                
                                <td width=\"20%\">RUANGAN</td>
                                <td width=\"3%\">:</td>
                                <td width=\"34%\">".strtoupper($lokasi)."</td>
                                <td width=\"15%\">JAGA SORE</td>
                                <td width=\"3%\">:</td>
                                <td></td>
                            </tr>
                            <tr>                                
                                <td width=\"20%\">JUMLAH O.S</td>
                                <td width=\"3%\">:</td>
                                <td width=\"34%\"></td>
                                <td width=\"15%\">JAGA MALAM</td>
                                <td width=\"3%\">:</td>
                                <td></td>
                            </tr>                   
                            <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                        </table><br>                        
                        <style type=\"text/css\">
                            .table-font
                                font-size:10px;
                                }
                            </style>
                            <table class=\"table-font\" border=\"0.5\" cellpadding=\"2\">
                                <thead><tr>
                                    <th rowspan=\"2\" width=\"5%\"  style=\"text-align: center;vertical-align:middle;\">NO</th>
                                    <th rowspan=\"2\" width=\"15%\"  style=\"text-align: center;\">NAMA</th>
                                    <th rowspan=\"2\" width=\"12%\"  style=\"text-align: center;\">RM / TGL LAHIR</th>
                                    <th rowspan=\"2\" width=\"13%\"  style=\"text-align: center;\">KLS/KMR</th>
                                    <th rowspan=\"2\" width=\"12%\"  style=\"text-align: center;\">DIAGNOSA</th>
                                    <th colspan=\"2\" width=\"18%\" style=\"text-align: center;\">DIET</th>
                                    <th rowspan=\"2\" width=\"15%\"  style=\"text-align: center;\">CATATAN</th>
                                    <th rowspan=\"2\" width=\"10%\"  style=\"text-align: center;\">STATUS</th>
                                </tr>
                                <tr>
                                    <td style=\"text-align: center;font-size:8px;\">STANDAR</td>
                                    <td style=\"text-align: center;font-size:8px;\">BENTUK</td>
                                </tr></thead>";
                                $i = 1;
                                foreach ($result as $item) {
                                    $data2['gizi']=null;
                                    $this->Mgizi->update_ceklis_ahli_gizi($item->no_ipd,$data2);
                                    if ($item->bed == '' || $item->bed == null) {
                                        $kamar = '';
                                        $bed = '';
                                    } else {
                                        $kamar_bed = explode(" ", $item->bed);
                                        $kamar = substr($kamar_bed[0], -2);
                                        $bed = $kamar_bed[2];
                                    }
                                    $bentuk_makanan = '';
                                    if ($item->bentuk == 'MK') {
                                        $bentuk_makanan = 'Makanan Cair';
                                    } else $bentuk_makanan = $item->bentuk;
                                    $konten=$konten."<tbody><tr>
                                        <td width=\"5%\" style=\"text-align: center;\">".$i++."</td>
                                        <td width=\"15%\">$item->nama</td>
                                        <td width=\"12%\" style=\"text-align: center;\"></td>
                                        <td width=\"13%\" style=\"text-align: center;\">$item->kelas/$kamar/$bed</td>
                                        <td width=\"12%\">$item->diagmasuk</td>
                                        <td width=\"9%\" style=\"text-align: center;\">$item->standar</td>
                                        <td width=\"9%\" style=\"text-align: center;\">$bentuk_makanan</td>
                                        <td width=\"15%\">$item->catatan</td>
                                        <td width=\"10%\" style=\"text-align: center;\">$item->nmkontraktor</td>
                                    </tr></tbody>"; 
                                }
                                                              
                            $konten=$konten."</table>
                                <br><br><br>
                                <table>
                                    <tr>
                                        <td width=\"60%\">                                      
                                        </td>
                                        <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                            Jakarta,____________20____<br><br><br><br><br> ________________________
                                        </td>
                                    </tr>                               
                                </table>";                

        // $file_name="GPD_".$fields->no_register.".pdf";
        $file_name="Permintaan Diet_".$lokasi."_".$tanggal.".pdf";
        tcpdf();               
        // $obj_pdf = new TCPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(FCPATH.'download/gizi/permintaan_diet/'.$file_name, 'FI');             

    }  

    public function cetak_permintaan($lokasi)
    {
        $data['result'] = $this->Mgizi->per_ruangan($lokasi)->result(); 
        // var_dump($data['result']);die();  
        date_default_timezone_set("Asia/Jakarta"); 
        $data['tgl_jam'] = date("d-m-Y H:i:s"); 
        $data['lokasi'] =  str_replace("%20"," ",$lokasi);;     

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P','debug' => true]);
        $html = $this->load->view('gizi/cetak_permintaan_gizi',$data,true);
        $mpdf->curlAllowUnsafeSslRequests = true;
        //$this->mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $mpdf->Output();          

    }  

    public function cetak_label_($lokasi)
    {
        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $nmsingkat=$this->config->item('nmsingkat');  
        $tanggal = date('d F Y');              

        $konten = "<style type=\"text/css\">
                    .table-font-size{
                        font-size:8px;
                        padding:1px;
                        font-family : Arial, Helvetica, sans-serif;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding-top: 3px;
                    }
                    .table-ttd{
                        font-size:7px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:7px;
                        font-style:italic;
                    }
                </style>
                ";
                    $datapasien=$this->Mgizi->data_label($lokasi);
                    var_dump($datapasien);die();
                    $kolom = 2;
                    $chunks = array_chunk($datapasien, $kolom,true);
                    $konten=$konten.$konten.
                    "<br><br>
                <table>";
                    foreach ($chunks as $chunk) {
                     $konten=$konten.
                        "<tr>";
                            foreach ($chunk as $galery) {    
                            $konten=$konten."
                            <td width=\"50%\">
                                <table class=\"table-font-size\" width=\"110%\">
                                       <tr>

                                            <td width=\"20%\" style=\"text-align:center;\"><p><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"23\"></p></td> 
                                            <td width=\"70%\"> RUMKITAL Dr. MINTOHARDJO</td>
                                       </tr>
                                       <tr>
                                            <td width=\"20%\">Nama</td>
                                            <td width=\"3%\">:</td>
                                            <td width=\"77%\">".ucwords(strtolower($galery->nama))."</td>
                                       </tr>
                                       <tr>
                                            <td width=\"20%\">RM / Lahir</td>
                                            <td width=\"3%\">:</td>
                                            <td width=\"77%\">$galery->rm_lahir</td>
                                       </tr>
                                       <tr>
                                            <td width=\"20%\">Diet</td>
                                            <td width=\"3%\">:</td>
                                            <td width=\"77%\">$galery->diet</td>
                                       </tr>
                                       <tr>
                                            <td width=\"20%\">Tanggal</td>
                                            <td width=\"3%\">:</td>
                                            <td width=\"77%\">$tanggal</td>
                                       </tr>
                                        <tr  style=\"padding:0px\">
                                            <td width=\"20%\">Ruang</td>
                                            <td width=\"3%\">:</td>
                                            <td width=\"77%\">$galery->lokasi</td>
                                       </tr>
                                       <tr >
                                            <td width=\"20%\" style=\"font-size:1px;\"></td>
                                            <td width=\"3%\" style=\"font-size:1px;\"></td>
                                            <td width=\"77%\" style=\"font-size:1px;\"></td>
                                       </tr>
                                </table>
                            </td> 
                            <td width=\"5%\"></td>";
                            }
                        $konten=$konten."                  
                        </tr> <br><br>";

                    }
                        $konten=$konten."  
                </table>
                    
                    <br>
                        
                                ";               

        // $file_name="GPD_".$fields->no_register.".pdf";
        $file_name="Cetak Label Diet_".$lokasi."_".$tanggal.".pdf";
        tcpdf();           
        $width = 165;  
        $height = 200; 
        $pageLayout = array($width, $height); //  or array($height, $width) 
        // $obj_pdf = new TCPDF('p', PDF_UNIT, $pageLayout, true, 'UTF-8', false);
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $title = "";
        $obj_pdf->SetTitle($file_name);
        $obj_pdf->SetHeaderData('', '', $title, '');     
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetMargins('3', '1', '5');
        $obj_pdf->SetAutoPageBreak(TRUE, '5');
        $obj_pdf->SetFont('helvetica', '', 10);
        $obj_pdf->setFontSubsetting(false); 
        $obj_pdf->AddPage();
        ob_start();
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(FCPATH.'download/gizi/permintaan_diet/'.$file_name, 'FI');             

    } 
    
    public function cetak_label($lokasi)
    {
                     
        $data['datapasien'] = $this->Mgizi->data_label($lokasi)->result(); 
        // var_dump($data['datapasien']);die();
        $data['logo_kesehatan_header'] = "kementriankesehatan.png";
        $data['logo_header'] =  "logo.png";
        // var_dump($data['result']);die();  
        date_default_timezone_set("Asia/Jakarta"); 
        $data['tgl_jam'] = date("d-m-Y H:i:s"); 
        $data['lokasi'] =  str_replace("%20"," ",$lokasi);;     

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [70, 40],
            'margin_top' => 5,
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'mirrorMargins' => true
        ]);
        $html = $this->load->view('gizi/label_makanan',$data,true);
        $mpdf->curlAllowUnsafeSslRequests = true;
        //$this->mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $mpdf->Output();                          

    } 

    public function lap_by_diet()
    {       
        $data['title'] = 'Laporan Gizi';
        $data['bm_header'] = $this->Mgizi->get_bentuk_makanan_header()->result();
        $data['sd_header'] = $this->Mgizi->get_standar_diet_header()->result();
        $this->load->view('gizi/gizi_lapdiet',$data); 
    }	

	public function get_pasien()
    {
        $list = $this->Mgizi->get_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            if ($count->gizi == '1') {
                $row[] = '<center style="color:red;" >'.$no.'</center>';
            }else {
                $row[] = '<center>'.$no.'</center>';

            }
            $row[] = '<center><a href="'.base_url().'gizi/permintaan_diet/'.$count->no_ipd.'" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i> Permintaan Diet</a> 
            </center>';
            $row[] = '<center>'.$count->nmruang.'</center>';
            $row[] = '<center>'.date( 'Y-m-d',strtotime($count->tgl_masuk)).'</center>';			
            $row[] = '<center>'.$count->no_cm.'</center>';
            $row[] = '<center>'.$count->no_ipd.'</center>';
            $row[] = $count->nama;
            if ($count->bed == '' || $count->bed == null) {
                $row[] = '';
                $row[] = '';
            } else {
                $kamar_bed = explode(" ", $count->bed);
                $kamar = substr($kamar_bed[0], -2);
                $row[] = '<center>'.$kamar.'</center>';
                $row[] = '<center>'.$kamar_bed[2].'</center>';
            }
            $row[] = '<center>'.$count->carabayar.'</center>';
            // $row[] = '<center>
            //               <form>
            //               <input type="checkbox" id="asCheckbox[]" name="asCheckbox[]" class="TestName">  
            //               <label for="asCheckbox">Asuhan Gizi</label>
            //               <input type="checkbox" id="edCheckbox" class="flat-red" name="edCheckbox"> 
            //                 <label for="edCheckbox">Edukasi</label>
            //               <input type="checkbox" id="screnCheckbox" class="flat-red" name="screnCheckbox">
            //                 <label for="screnCheckbox"> Screening Gizi </label>
            //               </form>
            //             </center>';
           
            // <a href="'.base_url().'gizi/asuhan_gizi/'.$count->no_ipd.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Pengisian Asuhan Gizi</a>

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mgizi->count_all(),
            "recordsFiltered" => $this->Mgizi->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function get_pasien_ugd()
    {
        $list = $this->Mgizi->get_pasien_ugd();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<center>'.$count->no_register.'</center>';
            $row[] = '<center>'.date( 'Y-m-d',strtotime($count->tgl_kunjungan)).'</center>';            
            $row[] = '<center>'.$count->no_cm.'</center>';     
            $row[] = '<center>'.$count->no_register.'</center>';
            $row[] = $count->nama;
            $row[] = '<center>'.$count->cara_bayar.'</center>';
            $row[] = '<center><a href="'.base_url().'gizi/permintaan_diet/'.$count->no_register.'" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i> Permintaan Diet</a></center>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mgizi->count_all_ugd(),
            "recordsFiltered" => $this->Mgizi->count_filtered_ugd(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function show_pasien_gizi($no_ipd)
    {
        $list = $this->Mgizi->get_pasien_gizi($no_ipd);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $count->nama_menu.' <b>|</b> '.$count->komposisi;
            $row[] = $count->nmruang.' | '.$count->bed;
            $row[] = date('d-m-Y',strtotime($count->tanggal));
            $row[] = $count->ket_waktu;
            $row[] = $count->note;
            $row[] = '<center>'.$count->xuser.'<br><button href="'.base_url().'gizi/gizi_pasien" class="btn btn-xs btn-primary" onclick="delete_menu(\''.$count->idgizi_pasien_diet.'\')" style="margin-right:3px;">Hapus</button></center>';
            //onclick="menu_diet(\''.$count->no_ipd.'\')"
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mgizi->count_all_gizipasien($no_ipd),
            "recordsFiltered" => $this->Mgizi->count_filtered_gizipasien($no_ipd),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function history_permintaan_diet()
    {
        $list = $this->M_diet->get_history();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $item->standar;
            $row[] = '<center>'.$item->bentuk.' - '.$item->nm_bentuk.'</center>';
            $row[] = $item->catatan;
            $row[] = '<center>'.date('Y-m-d H:i', strtotime($item->created_at)).'</center>';
            $row[] = '<center>'.$item->created_by.'</center>';
            $row[] = '<div class="btn-group">
                    <button class="btn waves-effect waves-light btn-success" onclick="show_edit_permintaan_diet(\''.$item->id.'\')"><i class="fa fa-trash"></i> Edit</button>
                    <button class="btn waves-effect waves-light btn-danger" onclick="hapus_permintaan_diet(\''.$item->id.'\')"><i class="fa fa-trash"></i> Hapus</button>
                </div>'; 
            $data[] = $row;
            $i++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_diet->count_all_history(),
            "recordsFiltered" => $this->M_diet->count_filtered_history(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function history_permintaan_diet_ruangan()
    {
        $list = $this->M_diet->get_history();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $item->standar;
            $row[] = '<center>'.$item->bentuk.' - '.$item->nm_bentuk.'</center>';
            $row[] = $item->catatan;
            $row[] = '<center>'.date('Y-m-d H:i', strtotime($item->created_at)).'</center>';
            $row[] = '<center>'.$item->created_by.'</center>';
            $row[] = '<div class="btn-group">
                    <button class="btn waves-effect waves-light btn-danger" onclick="hapus_permintaan_diet(\''.$item->id.'\')"><i class="fa fa-trash"></i> Hapus</button>
                </div>'; 
            $data[] = $row;
            $i++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_diet->count_all_history(),
            "recordsFiltered" => $this->M_diet->count_filtered_history(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function show_pasien()
    {
    	$no_ipd = $this->input->post('no_ipd');
        $result = $this->Mgizi->show_pasien($no_ipd);
        echo json_encode($result);
    }

    public function delete_menu($id)
    {        
        $result = $this->Mgizi->delete_menu($id);
        echo json_encode($result);
    }

    public function insert_gizipasien()
    {        
        $data['no_ipd'] = $this->input->post('no_ipd');
        $data['iddiet'] = $this->input->post('iddiet');
        $data['idbed'] = $this->input->post('idbed');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['ket_waktu'] = $this->input->post('ket_waktu');

        $data1['pasien']=$this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
        $data['idpokdiet']=null;
        if((int)$this->input->post('dietCheckbox')==1){
            if($this->rjmpelayanan->get_pasien_recorddiet($data1['pasien'][0]['no_medrec'])->row()){
            $data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data1['pasien'][0]['no_medrec'])->row()->idpokdiet;
            }
        }
        

        date_default_timezone_set("Asia/Jakarta");
        $login_data = $this->load->get_var("user_info");
        $user = $login_data->username;
        $data['xuser']=$user;
        $data['xupdate']=date("Y-m-d H:i:s");
        if($this->input->post('note')!=''){
           $data['note'] = $this->input->post('note'); 
        }
        //print_r($data);break;
        $result = $this->Mgizi->insert_gizipasien($data);
        echo json_encode($result);
    }

    public function gizi_pasien($no_ipd)
    {
        $data['no_ipd'] = $no_ipd;
        $data['pasien']=$this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
        $data['result'] = '';//$this->Mgizi->show_pasien($no_ipd);
        $data['title'] = 'Gizi Pasien';
        $data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
        $data['menudiet']=$this->mmgizi->get_all_menudiet()->result();
        $data['idpokdiet']='';
        if($this->rjmpelayanan->get_pasien_recorddiet($data['pasien'][0]['no_medrec'])->row()){
            $data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['pasien'][0]['no_medrec'])->row()->idpokdiet;
        }
        $this->load->view('gizi/gizi_pasien',$data);
    }	

    static function SaveViaTempFile($objWriter){
        $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }

    public function rekap_status_pasien(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_status_pasien($tgl_awal, $tgl_akhir)->result();

        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['covid_pc']   = $value->covid_pc;
            $row2['covid_bpjs_anggota']   = $value->covid_bpjs_anggota;
            $row2['covid_bpjs_non']   = $value->covid_bpjs_non;
            $row2['covid_total']   = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non);
            $row2['non_covid_pc']   = $value->non_covid_pc;
            $row2['non_covid_bpjs_anggota']   = $value->non_covid_bpjs_anggota;
            $row2['non_covid_bpjs_non']   = $value->non_covid_bpjs_non;
            $row2['non_covid_total']   = ($value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
            $row2['total']      = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non+$value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
    
            $line2[] = $row2;
        }
                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }

    public function rekap_kon_rj_status_pasien(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_kon_rj_status_pasien($tgl_awal, $tgl_akhir)->result();

        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['covid_pc']   = $value->covid_pc;
            $row2['covid_bpjs_anggota']   = $value->covid_bpjs_anggota;
            $row2['covid_bpjs_non']   = $value->covid_bpjs_non;
            $row2['covid_total']   = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non);
            $row2['non_covid_pc']   = $value->non_covid_pc;
            $row2['non_covid_bpjs_anggota']   = $value->non_covid_bpjs_anggota;
            $row2['non_covid_bpjs_non']   = $value->non_covid_bpjs_non;
            $row2['non_covid_total']   = ($value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
            $row2['total']      = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non+$value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
    
            $line2[] = $row2;
        }
                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }
        
    public function rekap_kon_ri_status_pasien(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_kon_ri_status_pasien($tgl_awal, $tgl_akhir)->result();

        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['covid_pc']   = $value->covid_pc;
            $row2['covid_bpjs_anggota']   = $value->covid_bpjs_anggota;
            $row2['covid_bpjs_non']   = $value->covid_bpjs_non;
            $row2['covid_total']   = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non);
            $row2['non_covid_pc']   = $value->non_covid_pc;
            $row2['non_covid_bpjs_anggota']   = $value->non_covid_bpjs_anggota;
            $row2['non_covid_bpjs_non']   = $value->non_covid_bpjs_non;
            $row2['non_covid_total']   = ($value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
            $row2['total']      = ($value->covid_pc+$value->covid_bpjs_anggota+$value->covid_bpjs_non+$value->non_covid_pc+$value->non_covid_bpjs_anggota+$value->non_covid_bpjs_non);
    
            $line2[] = $row2;
        }
                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }   

    public function rekap_bentuk_makanan(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_bentuk_makanan($tgl_awal, $tgl_akhir)->result();
        $bm_header = $this->Mgizi->get_bentuk_makanan_header($tgl_awal, $tgl_akhir)->result();
        $sd_header = $this->Mgizi->get_standar_diet_header($tgl_awal, $tgl_akhir)->result();
        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['no_ipd']   = $value->no_ipd;
            foreach ($bm_header as $row) {
                foreach ($row as $key => $value_kode) {
                    if($key=="kode"){
                        $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = ($value_kode==$value->bentuk) ? 1 : '' ;
                    }
                }
            }
            if($value->standar==''){
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = '' ;
                        }
                    }
                }
            }else{
                $standars = explode(",", $value->standar);
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $status = '';
                            foreach ($standars as $standar) {
                                if($status == 1){
                                    break;
                                }else{
                                    $status = ($value_kode==$standar) ? 1 : '' ;
                                }
                            }
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = $status;
                        }
                    }
                }
            }
            
            $line2[] = $row2;
        }

                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }

    public function rekap_kon_rj_bentuk_makanan(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_kon_rj_bentuk_makanan($tgl_awal, $tgl_akhir)->result();
        $bm_header = $this->Mgizi->get_bentuk_makanan_header($tgl_awal, $tgl_akhir)->result();
        $sd_header = $this->Mgizi->get_standar_diet_header($tgl_awal, $tgl_akhir)->result();
        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['no_ipd']   = $value->no_ipd;
            foreach ($bm_header as $row) {
                foreach ($row as $key => $value_kode) {
                    if($key=="kode"){
                        $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = ($value_kode==$value->bentuk) ? 1 : '' ;
                    }
                }
            }
            if($value->standar==''){
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = '' ;
                        }
                    }
                }
            }else{
                $standars = explode(",", $value->standar);
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $status = '';
                            foreach ($standars as $standar) {
                                if($status == 1){
                                    break;
                                }else{
                                    $status = ($value_kode==$standar) ? 1 : '' ;
                                }
                            }
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = $status;
                        }
                    }
                }
            }
            
            $line2[] = $row2;
        }

                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }  

    public function rekap_kon_ri_bentuk_makanan(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_kon_ri_bentuk_makanan($tgl_awal, $tgl_akhir)->result();
        $bm_header = $this->Mgizi->get_bentuk_makanan_header($tgl_awal, $tgl_akhir)->result();
        $sd_header = $this->Mgizi->get_standar_diet_header($tgl_awal, $tgl_akhir)->result();
        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['no_ipd']   = $value->no_ipd;
            foreach ($bm_header as $row) {
                foreach ($row as $key => $value_kode) {
                    if($key=="kode"){
                        $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = ($value_kode==$value->bentuk) ? 1 : '' ;
                    }
                }
            }
            if($value->standar==''){
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = '' ;
                        }
                    }
                }
            }else{
                $standars = explode(",", $value->standar);
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $status = '';
                            foreach ($standars as $standar) {
                                if($status == 1){
                                    break;
                                }else{
                                    $status = ($value_kode==$standar) ? 1 : '' ;
                                }
                            }
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = $status;
                        }
                    }
                }
            }
            
            $line2[] = $row2;
        }

                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }      

    public function rekap_edu_rj_bentuk_makanan(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_edu_rj_bentuk_makanan($tgl_awal, $tgl_akhir)->result();
        $bm_header = $this->Mgizi->get_bentuk_makanan_header($tgl_awal, $tgl_akhir)->result();
        $sd_header = $this->Mgizi->get_standar_diet_header($tgl_awal, $tgl_akhir)->result();
        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['no_ipd']   = $value->no_ipd;
            foreach ($bm_header as $row) {
                foreach ($row as $key => $value_kode) {
                    if($key=="kode"){
                        $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = ($value_kode==$value->bentuk) ? 1 : '' ;
                    }
                }
            }
            if($value->standar==''){
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = '' ;
                        }
                    }
                }
            }else{
                $standars = explode(",", $value->standar);
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $status = '';
                            foreach ($standars as $standar) {
                                if($status == 1){
                                    break;
                                }else{
                                    $status = ($value_kode==$standar) ? 1 : '' ;
                                }
                            }
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = $status;
                        }
                    }
                }
            }
            
            $line2[] = $row2;
        }

                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }        

    public function rekap_edu_ri_bentuk_makanan(){
        $tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
        $tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $line  = array();
        $line2 = array();
        $row2  = array();
        if($tgl_awal=='' && $tgl_akhir==''){
            echo json_encode($line);die();
        }
        $hasil = $this->Mgizi->get_edu_ri_bentuk_makanan($tgl_awal, $tgl_akhir)->result();
        $bm_header = $this->Mgizi->get_bentuk_makanan_header($tgl_awal, $tgl_akhir)->result();
        $sd_header = $this->Mgizi->get_standar_diet_header($tgl_awal, $tgl_akhir)->result();
        $i=1;

        foreach ($hasil as $value) {
            $row2['rank']   = $i++;
            $row2['tgl']   = $value->tgl;
            $row2['no_ipd']   = $value->no_ipd;
            foreach ($bm_header as $row) {
                foreach ($row as $key => $value_kode) {
                    if($key=="kode"){
                        $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = ($value_kode==$value->bentuk) ? 1 : '' ;
                    }
                }
            }
            if($value->standar==''){
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = '' ;
                        }
                    }
                }
            }else{
                $standars = explode(",", $value->standar);
                foreach ($sd_header as $row) {
                    foreach ($row as $key => $value_kode) {
                        if($key=="standar"){
                            $status = '';
                            foreach ($standars as $standar) {
                                if($status == 1){
                                    break;
                                }else{
                                    $status = ($value_kode==$standar) ? 1 : '' ;
                                }
                            }
                            $row2[strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$value_kode))))] = $status;
                        }
                    }
                }
            }
            
            $line2[] = $row2;
        }

                
        $line['data'] = $line2;
                    
        echo json_encode($line);
    }  		
}
?>
