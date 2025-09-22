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
            $data['ruangan'] = $this->Mgizi->get_ruangan();
			$this->load->view('gizi/index',$data); 
	}

    public function ruangan($ruangan)
    {
        if (is_null($ruangan)) {
            redirect('gizi');
        }       
        $data['title'] = 'Gizi';    
        $data['ruangan'] = $ruangan;
        $this->load->view('gizi/ruangan',$data); 
    }

    public function permintaan_diet($no_ipd)
    {       
        $data['title'] = 'Form Permintaan Diet';                
        $data['data_pasien'] = $this->Mgizi->show_pasien_iri($no_ipd);
        $kamar_bed = explode(" ", $data['data_pasien']->bed);
        $kamar = substr($kamar_bed[0], -2);
        $data['kamar_bed'] = $kamar . ' - '. $kamar_bed[2];
        $data['standar_diet'] = $this->Mgizi->standar_diet();           
        $data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();           
        $this->load->view('gizi/permintaan_diet',$data); 
    }

    public function insert_permintaan_diet()
    {   
        $no_ipd = $this->input->post('no_ipd');
        $standar_diet = $this->input->post('standar_diet');
        $bentuk_makanan = $this->input->post('bentuk_makanan');
        $catatan = $this->input->post('catatan');
        $current = $this->Mgizi->show_permintaan_diet($no_ipd);  
        if ($current != null && $standar_diet == $current->standar && $bentuk_makanan == $current->bentuk && $catatan == $current->catatan) {
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
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->Mgizi->insert_permintaan_diet($data);  
            $result = array(
                'metadata' => array('code' => '200','message' => 'Permintaan Diet Berhasil Disimpan.'),
                'response' => null
            );
            echo json_encode($result);
        }
        
    }

    public function show_permintaan_diet($no_ipd)
    {       
        $result = $this->Mgizi->show_permintaan_diet($no_ipd);           
        echo json_encode($result);
    }

    public function cetak_permintaan($lokasi)
    {
        $result = $this->Mgizi->per_ruangan($lokasi);
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
                        <br>
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
                                    <th rowspan=\"2\" width=\"12%\"  style=\"text-align: center;\">RM</th>
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
                                    if ($item->bed == '' || $item->bed == null) {
                                        $kamar = '';
                                        $bed = '';
                                    } else {
                                        $kamar_bed = explode(" ", $item->bed);
                                        $kamar = substr($kamar_bed[0], -2);
                                        $bed = $kamar_bed[2];
                                    }
                                    $konten=$konten."<tbody><tr>
                                        <td width=\"5%\" style=\"text-align: center;\">".$i++."</td>
                                        <td width=\"15%\">$item->nama</td>
                                        <td width=\"12%\" style=\"text-align: center;\">$item->no_cm</td>
                                        <td width=\"13%\" style=\"text-align: center;\">$item->kelas/$kamar/$bed</td>
                                        <td width=\"12%\">$item->diagmasuk</td>
                                        <td width=\"9%\" style=\"text-align: center;\">$item->standar</td>
                                        <td width=\"9%\" style=\"text-align: center;\">$item->bentuk</td>
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

    public function lap_by_diet()
    {       
            $data['title'] = 'Laporan Konsultasi Berdasarkan Macam Diet';    
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
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<center>'.date( 'Y-m-d',strtotime($count->tgl_masuk)).'</center>';			
            $row[] = '<center>'.$count->no_cm.'</center>';
            if (date('Y-m-d',strtotime($count->tgl_daftar)) == date('Y-m-d',strtotime($count->tgldaftarri))) {
                $row[] = $count->nama.' | <span class="label label-danger">BARU</span>';
            } else{
                $row[] = $count->nama;
            }
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
            $row[] = '<center><a href="'.base_url().'gizi/permintaan_diet/'.$count->no_ipd.'" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i> Permintaan Diet</a></center>';
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
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $item->standar;
            $row[] = '<center>'.$item->bentuk.' - '.$item->nm_bentuk.'</center>';
            $row[] = $item->catatan;
            $row[] = '<center>'.$item->created_at.'</center>';
            $row[] = '<center>'.$item->created_by.'</center>';
            $data[] = $row;
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
                  		
}
?>
